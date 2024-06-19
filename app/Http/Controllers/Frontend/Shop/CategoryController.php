<?php

namespace App\Http\Controllers\Frontend\Shop;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\ShopCategories as Category;

class CategoryController extends Controller
{
    /**
     * Show the specified resource.
     *
     * @param Category $category
     * @return Response
     */
    public function show(Category $category)
    {
        $category->increment('view_counts');
        $category->load('filterGroups');
        $products               = $category->getProductsWithAttributes();
        $mostExpensiveProduct   = $category->getMostExpensiveProduct();
        $categories             = Category::with('activeChildren')->whereNull('parent_id')->where('status', 1)->get();
        $manufacturers          = $category->manufacturers;

        foreach ($products as $product) {
            $highlightAttributes[$product->id] = [];
            foreach ($product->attributes as $attribute)
            {
                if ($attribute->pivot->highlight)
                {
                    $highlightAttributes[$product->id][$attribute->name] = $attribute->pivot->value;
                }
            }
        }
        return view('frontend.shop.categories.show', compact('category', 'products', 'mostExpensiveProduct', 'categories', 'highlightAttributes', 'manufacturers'));
    }

    /**
     * Returns products of a category by filters, order and price range, also pagination.
     *
     * @param Request $request
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function filter(Request $request, Category $category)
    {
        if (!$request->ajax()) {
            abort(400);
        }

        $limit = $request->input('limit');
        if ($request->limit != 15 && $request->limit != 25 && $request->limit != 50 && $request->limit != 75) {
            $limit = 15;
        }

        switch ($request->order) {
            case 'most_viewed':
                $order = 'view_counts';
                $sort = 'DESC';
                break;
            case 'latest':
                $order = 'created_at';
                $sort = 'DESC';
                break;
            case 'price_asc':
                $order = 'price';
                $sort = 'ASC';
                break;
            case 'price_desc':
                $order = 'price';
                $sort = 'DESC';
                break;
            case 'most_popular':
                $order = 'most_popular';
                $sort = 'DESC';
                break;
            case 'best_seller':
                $order = 'best_seller';
                $sort = 'DESC';
                break;
            default:
                $order = 'created_at';
                $sort = 'DESC';
        }

        $filterGroups = $category->filtersWithGroup;
        $filters = [];
        foreach ($filterGroups as $group) {
            foreach ($group->filters as $filter) {
                if (in_array($filter->id, $request->input('filters') ?? [])) {
                    $filters[$group->id][] = $filter->id;
                }
            }
        }

        $manufacturers = $request->manufacturers ?? [];


        $minPrice = $request->minPrice ?? null;
        $maxPrice = $request->maxPrice ?? null;

        $products = $category->filteredProducts($filters, $limit, $order, $sort, $minPrice, $maxPrice, $manufacturers);

        foreach ($products as $product) {
            $highlightAttributes[$product->id] = [];
            foreach ($product->attributes as $attribute)
            {
                if ($attribute->pivot->highlight)
                {
                    $highlightAttributes[$product->id][$attribute->name] = $attribute->pivot->value;
                }
            }
        }

        $products = view('frontend.shop.categories.products', compact('products', 'highlightAttributes'))->render();

        return response()->json($products);
    }
}
