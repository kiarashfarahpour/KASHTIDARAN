<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FormsRequest;
use App\Models\Form;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FormController extends Controller
{
    /**
     * FormController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:forms-manage');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.forms.index');
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
        $forms = Form::latest();
        return Datatables::of($forms)
            ->setTotalRecords($forms->count())
            ->editColumn('authenticated', function ($form) {
                return view('admin.forms.partials.datatables.authenticated', compact('form'));
            })
            ->addColumn('actions', function ($form) {
                return view('admin.forms.partials.datatables.actions', compact('form'));
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
        return view('admin.forms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\FormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormsRequest $request)
    {
        $request->merge([
            'authenticated' => $request->input('authenticated', Form::GUEST),
            'user_id'       => auth()->id(),
        ]);
        $form = Form::create($request->only(['name', 'user_id', 'authenticated']));
        $this->doneMessage("فرم $form->name اضافه شد.");
        return redirect()->route('admin.forms.index');
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
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function edit(Form $form)
    {
        return view('admin.forms.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProvinceRequest  $request
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function update(FormsRequest $request, Form $form)
    {
        $request->merge([
            'authenticated' => $request->input('authenticated', Form::GUEST),
        ]);
        $form->update($request->only(['name', 'authenticated']));
        $this->doneMessage("فرم $form->name آپدیت شد.");
        return redirect()->route('admin.forms.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Form::destroy($id);
        $this->doneMessage('فرم مورد نظر با موفقیت حذف شد.');
        return redirect()->route('admin.forms.index');
    }
}
