<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InputRequest;
use App\Models\Input;
use App\Models\Form;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class InputController extends Controller
{
    /**
     * InputController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:forms-manage');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function index(Form $form)
    {
        return view('admin.inputs.index', compact('form'));
    }

    /**
     * Proceeds ajax request for datatable.
     *
     * @param  Request  $request
     * @param  \App\Models\Form  $form
     * @return mixed
     * @throws \Exception
     */
    public function ajax(Request $request, Form $form)
    {
        abort_unless($request->ajax(), 404);
        $inputs = Input::where('form_id', $form->id);
        return Datatables::of($inputs)
            ->setTotalRecords($inputs->count())
            ->addColumn('actions', function ($field) {
                return view('admin.inputs.partials.datatables.actions', compact('field'));
            })
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function create(Form $form)
    {
        return view('admin.inputs.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\FieldRequest  $request
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function store(FieldRequest $request, Form $form)
    {
        $field_data             = $request->only(['type', 'label', 'placeholder', 'sort_order']);
        $field_data['rules']    = $request->input('rules', []);
        $field_data['values']   = $request->input('values', []);
        $field_data['options']  = $request->input('options', []);
        $field_data['user_id']  = auth()->id();
        $field = $form->inputs()->create($field_data);
        $this->doneMessage("فیلد $input->name اضافه شد.");
        return redirect()->route('admin.inputs.index', $form->id);
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
     * @param  \App\Models\Input  $inputs
     * @return \Illuminate\Http\Response
     */
    public function edit(Input $input)
    {
        $input->load('form');
        return view('admin.inputs.edit', compact('input'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\InputRequest  $request
     * @param  \App\Models\Input  $input
     * @return \Illuminate\Http\Response
     */
    public function update(InputRequest $request, Input $input)
    {
        $input_data = $request->only(['name', 'type', 'label', 'placeholder', 'sort_order', 'is_price']);
        $input_data['rules']    = $request->input('rules', []);
        $input_data['values']   = $request->input('values', []);
        $input_data['options']  = $request->input('options', []);
        $input->update($input_data);
        $input->load('form');
        $this->doneMessage("فیلد $input->name آپدیت شد.");
        return redirect()->route('admin.inputs.index', $input->form->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Input::destroy($id);
        $this->doneMessage('فیلد مورد نظر با موفقیت حذف شد.');
        return redirect()->route('admin.inputs.index');
    }
}
