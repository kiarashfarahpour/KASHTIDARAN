<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\MyRequest;
use App\Models\Commercial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MyController extends Controller
{
    /**
     * MyController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display list of commercials inside a city.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Throwable
     */
    public function show(Request $request)
    {
        $user                   = auth()->user();
        $commercials            = Commercial::with('iams')->whereUserId(auth()->id())->latest()->paginate();
        $count['commercial']    = Commercial::whereUserId(auth()->id())->count();
        $count['view_counts']   = Commercial::whereUserId(auth()->id())->sum('view_counts');
        $count['bookmarks']     = $user->bookmarks()->count();
        $count['payments']      = $user->payments()->count();
        $settings               = get_settings();
        $bookmarks              = $user->bookmarks;
        $commercialsCategories  = $commercials->pluck('category_id')->toArray();
        $commercialsIds         = $commercials->pluck('id')->toArray();
        $relatedCommercials     = Commercial::whereIn('category_id', $commercialsCategories)
                                                ->whereNotIn('id', $commercialsIds)
                                                ->distinct()
                                                ->inRandomOrder()
                                                ->take(5)
                                                ->get();
        return view('frontend.my.show', compact('commercials', 'count', 'settings', 'bookmarks', 'relatedCommercials'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\MyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(MyRequest $request)
    {
        $user = auth()->user();
        $user_data = $request->only(['name', 'mobile']);
        if ($request->password) {
            $user_data['password'] = bcrypt($request->password);
        }
        $user->update($user_data);
        $this->doneMessage('اطلاعات پروفایل شما با موفقیت ذخیره شدند.');
        return redirect()->back();
    }
}
