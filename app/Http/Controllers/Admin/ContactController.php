<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ContactController extends Controller
{
    /**
     * ContactController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:contacts-manage');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.contacts.index');
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
        $contacts = Contact::with('page')->select(['pages.id AS page_id', 'pages.title', 'contacts.id', 'contacts.ip', 'contacts.created_at'])->join('pages', 'contacts.page_id', '=', 'pages.id');
        return Datatables::of($contacts)
            ->setTotalRecords($contacts->count())
            ->addColumn('title', function ($contact) {
                return $contact->page->title;
            })
            ->editColumn('created_at', function ($contact) {
                return view('admin.contacts.partials.datatables.created_at', compact('contact'));
            })
            ->addColumn('actions', function ($contact) {
                return view('admin.contacts.partials.datatables.actions', compact('contact'));
            })
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $conatct
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        $contact->load('page', 'user', 'form', 'fields');
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function edit(Province $province)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Contact::destroy($id);
        $this->doneMessage('پیام مورد نظر با موفقیت حذف شد.');
        return redirect()->route('admin.contacts.index');
    }
}
