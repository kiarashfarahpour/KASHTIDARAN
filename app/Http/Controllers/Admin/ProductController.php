<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Attribute;
use App\Models\Filter;
use App\Models\Image;
use App\Models\Manufacturer;
use App\Models\Option;
use App\Models\Product;
use App\Models\ShopCategories as Category;
use Arr;
use DataTables;
use Illuminate\Http\Request;
use Sms;
use Str;
use Rap2hpoutre\FastExcel\FastExcel;

class ProductController extends Controller
{
    /**
     * CommercialController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:products-create')->only(['create', 'store']);
        $this->middleware('permission:products-edit')->only(['edit', 'update']);
        $this->middleware('permission:products-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.products.index');
    }
    
    public function export()
    {
        return (new FastExcel(Product::with('manufacturer')->get()))->download('products.xlsx', function ($product) {
            return [
                'slug'              => $product->slug,
                'model'             => $product->model,
                'code'              => $product->code,
                'name'              => $product->name,
                'description'       => $product->description,
                'meta_keywords'     => $product->meta_keywords,
                'meta_description'  => $product->meta_description,
                'price'             => $product->price ? number_format($product->price, 0, '', '') : '',
                'stock'             => $product->stock,
                'manufacturer'      => $product->manufacturer->name ?? '',
            ];
        });
    }

    /**
     * Proceeds ajax request for datatable.
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function ajax(Request $request)
    {
        abort_unless($request->ajax(), 404);
        $products = Product::query();
        return Datatables::of($products)
            ->setTotalRecords($products->count())
            ->orderColumn('created_at', 'created_at $1')
            ->editColumn('image', function ($product) {
                return '<img src="' . asset(\App\ImageManager::getResizeName($product->image, ['width' => 40, 'height' => 40])) . '" class="img-responsive img-thumbnail">';
            })
            ->editColumn('price', function ($product) {
                $price = '';
                if ($product->special) {
                    $price .= '<del class="text-red clearfix">' . number_format($product->price, 0) . ' ریال</del>';
                    $price .= '<ins class="text-green">' . number_format($product->special, 0) . ' ریال</ins>';
                } else {
                    $price .= '<span>' . number_format($product->price, 0) . ' ریال</span>';
                }
                return $price;
            })
            ->editColumn('created_at', function ($product) {
                return view('admin.products.partials.created_at', compact('product'));
            })
            ->editColumn('status', function ($product) {
                return view('admin.products.partials.status', compact('product'));
            })
            ->addColumn('action', function ($product) {
                return view('admin.products.partials.actions', compact('product'));
            })
            ->rawColumns(['image', 'price', 'stock', 'status', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $manufacturers  = Manufacturer::get()->pluck('name', 'id')->toArray();
        $cats           = Category::get();
        $categories     = [];
        foreach ($cats as $cat) {
            $categories[$cat->id] = "{$cat->name} ({$cat->slug})";
        }
        $filters        = Filter::get()->pluck('filter', 'id');
        $attributes     = Attribute::get()->pluck('name', 'id');
        $options        = Option::with('values')->get();
        return view('admin.products.create', compact('manufacturers', 'categories', 'filters', 'attributes', 'products', 'options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product_data                   = $request->only(['name', 'slug', 'description', 'meta_description', 'model', 'code', 'manufacturer_id', 'price', 'special', 'stock', 'sort_order', 'status']);
        $product_data['user_id']        = auth()->id();
        $product_data['meta_keywords']  = dash2comma($request->input('meta_keywords'));
        if($request->hasFile('image'))
        {
            $name = Str::random(64);
            if($request->image->storeAs('public/images/products/' . date('Y/m'), $name . '.' . $request->image->extension()))
            {
                $image = Image::create([
                    'user_id'   => auth()->id(),
                    'name'      => 'storage/images/products/' . date('Y/m') . '/' . $name . '.' . $request->image->extension(),
                ]);
                image_resize($image->name, ['width' => 18, 'height' => 18]);
                $product_data['image_id'] = $image->id;
            }
        }
        $product = Product::create($product_data);

        // Sync relations
        $product->categories()->sync($request->input('category_id'));
        $product->filters()->sync($request->input('filter_id'));

        foreach ($request->required ?? [] as $optionId => $required)
        {
            $option_values_count = count($request->input("option_values.$optionId.value_id") ?? []);
            if ($option_values_count)
            {
                $productOption = new ProductOption([
                    'option_id'     => $optionId,
                    'product_id'    => $product->id,
                    'required'      => $required ? true : false
                ]);
                $productOption->save();

                $values = $request->input('option_values')[$optionId];
                $product_option_values = [];
                foreach ($values['value_id'] as $value_key => $value_id)
                {
                    $product_option_values[] = [
                        'option_value_id'   => $values['value_id'][$value_key],
                        'surplus_price'     => $values['surplus_price'][$value_key] ? true : false,
                        'price'             => $values['price'][$value_key],
                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ];
                }
                $productOption->optionValues()->attach($product_option_values);
            }
        }

        $attributes = [];
        if ($request->input('attribute_id')) {
            foreach ($request->input('attribute_id') as $key => $attribute) {
                if ($request->input('attribute_value.' . $key)) {
                    $attributes[$request->input('attribute_id.' . $key)] = ['value' => $request->input('attribute_value.' . $key)];
                }
            }
        }
        $product->attributes()->sync($attributes);
        $images_data = [];
        if ($request->hasfile('images')) {
            $date = date('Y/m');
            $images = [];
            foreach ($request->file('images') as $key => $file) {
                $name = Str::random(64);
                $image = \Image::make($file);
                $image->orientate();
                $imageName = $name . '.' . $file->getClientOriginalExtension();
                $destinationPath = '/storage/images/' . $date . '/';
                $root = $_SERVER["DOCUMENT_ROOT"];
                $dir = $root . $destinationPath;
                $old = umask(0);
                if( !file_exists($dir) ) {
                    mkdir($dir, 0755, true);
                }
                umask($old);
                $image->save($dir . $imageName, 20);
                $name = $destinationPath . $imageName;

                $images_data[] = Image::create([
                    'user_id'   => auth()->id(),
                    'name'      => $name,
                ]);
            }
            $product->images()->saveMany($images_data);
        }
        $this->doneMessage("محصول $product->name ایجاد شد.");
        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $product->load('categories', 'filters', 'attributes', 'options.optionValues', 'options.option.values');
        $manufacturers  = Manufacturer::pluck('name', 'id')->toArray();
        $cats           = Category::get();
        $categories     = [];
        foreach ($cats as $cat) {
            $categories[$cat->id] = "{$cat->name} ({$cat->slug})";
        }
        $selectedCategories     = array_pluck($product->categories->toArray(), 'id');
        $filters                = Filter::with('filterGroup')->get();
        $selectedFilters        = array_pluck($product->filters->toArray(), 'id');
        $attributes             = Attribute::get()->pluck('name', 'id');
        $selectedAttributes     = [];
        $highlightedAttributes  = [];
        foreach ($product->attributes->toArray() as $attribute) {
            $selectedAttributes[$attribute['id']] = $attribute['pivot']['value'];
            if ($attribute['pivot']['highlight']) {
                $highlightedAttributes[] = $attribute['id'];
            }
        }
        $options = Option::with('values')->get();
        return view('admin.products.edit', compact('product', 'manufacturers', 'categories', 'filters', 'attributes', 'selectedCategories', 'selectedAttributes', 'selectedFilters', 'highlightedAttributes', 'options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product_data                   = $request->only(['name', 'slug', 'description', 'meta_description', 'model', 'code', 'manufacturer_id', 'price', 'special', 'stock', 'sort_order', 'status']);
        $product_data['user_id']        = auth()->id();
        $product_data['meta_keywords']  = dash2comma($request->input('meta_keywords'));
        if($request->hasFile('image'))
        {
            $name = Str::random(64);
            if($request->image->storeAs('public/images/products/' . date('Y/m'), $name . '.' . $request->image->extension()))
            {
                $image = Image::create([
                    'user_id'   => auth()->id(),
                    'name'      => 'storage/images/products/' . date('Y/m') . '/' . $name . '.' . $request->image->extension(),
                ]);
                image_resize($image->name, ['width' => 18, 'height' => 18]);
                $product_data['image_id'] = $image->id;
            }
        }
        $product->update($product_data);

        foreach ($request->required ?? [] as $optionId => $required)
        {
            $option_values_count = count($request->input("option_values.$optionId.value_id") ?? []);
            if ($option_values_count)
            {
                // Check if it's new or exist
                if (in_array($optionId, $product->options->pluck('option_id')->toArray()))
                {
                    // Update the ProductOption row.
                    $productOption              = ProductOption::where('option_id', $optionId)->where('product_id', $product->id)->first();
                    $productOption->required    = $required ? true : false;
                    $productOption->save();
                }
                else
                {
                    // Add new ProductOption record.
                    $productOption = new ProductOption([
                        'option_id'     => $optionId,
                        'product_id'    => $product->id,
                        'required'      => $required ? true : false,
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ]);
                    $productOption->save();
                }

                $values = $request->input('option_values')[$optionId];
                $product_option_values = [];
                foreach ($values['value_id'] as $value_key => $value_id)
                {
                    $product_option_values[] = [
                        'option_value_id'   => $values['value_id'][$value_key],
                        'surplus_price'     => $values['surplus_price'][$value_key] ? true : false,
                        'price'             => $values['price'][$value_key],
                    ];
                }
                $productOption->optionValues()->sync($product_option_values);
            }
            else
            {
                // Remove option with relations from the database.
                $poModel = ProductOption::where(['option_id' => $optionId, 'product_id' => $product->id])->first();
                if ($poModel)
                {
                    //$poModel->delete();
                }
            }
        }
        // Sync relations
        $product->categories()->sync($request->input('category_id'));
        $product->filters()->sync($request->input('filter_id'));
        $attributes = [];
        if ($request->input('attribute_id')) {
            foreach ($request->input('attribute_id') as $key => $attribute) {
                if ($request->input('attribute_value.' . $key)) {
                    $attributes[$request->input('attribute_id.' . $key)] = [
                        'value' => $request->input('attribute_value.' . $key),
                        'highlight' => $request->input('attribute_highlight.' . $key) ?? 0,
                    ];
                }
            }
        }
        $product->attributes()->sync($attributes);
        
        $images_data = [];
        if ($request->hasfile('images')) {
            $date           = date('Y/m');
            $images_data    = [];
            foreach ($request->file('images') as $key => $file) {
                $name = Str::random(64);
                $image = \Image::make($file);
                $image->orientate();
                $imageName = $name . '.' . $file->getClientOriginalExtension();
                $destinationPath = '/storage/images/' . $date . '/';
                $root = $_SERVER["DOCUMENT_ROOT"];
                $dir = $root . $destinationPath;
                $old = umask(0);
                if( !file_exists($dir) ) {
                    mkdir($dir, 0755, true);
                }
                umask($old);
                $image->save($dir . $imageName, 20);
                $name = $destinationPath . $imageName;

                $images_data[] = Image::create([
                    'user_id'   => auth()->id(),
                    'name'      => $name,
                ]);
            }
            $product->images()->saveMany($images_data);
        }
        $this->doneMessage("محصول $product->name آپدیت شد.");
        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        $product->delete();
        $this->doneMessage('محصول با موفقیت حذف گردید.');
        return redirect()->route('admin.products.index');
    }
}
