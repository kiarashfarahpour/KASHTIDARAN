@extends('frontend.layouts.app')
@section('styles')
    {!! $page->css !!}
    <style>
        .content {
            width: 100% !important;
            padding-right: 0 !important;
            padding-left: 0 !important;
            min-height: 100vh;
        }
    </style>
@endsection
@section('scripts')
    {!! $page->js !!}
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 my-4">
                <article>
                    <h1 class="main-title">{{ $page->title }}</h1>
                    @if($page->image_id)
                        <div>
                            <img src="{{ asset($page->image->name) }}" class="img-fluid rounded mb-3 mb-md-0" alt="{{ $page->title }}">
                        </div>
                    @endif
                    <div>
                        {!! $page->content !!}
                    </div>
                    <div>
                        @if($page->form)
                            @if (($page->form->authenticated && auth()->check()) OR !$page->form->authenticated)
                                <form action="{{ route('frontend.contacts.store', $page->slug) }}" method="post" class="form-horizontal">
                                    @csrf
                                    @if($page->form->inputs->count())
                                        @foreach($page->form->inputs as $input)
                                            @switch($input->type)
                                                @case('text')
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="input{{ $loop->iteration }}" class="control-label col-12">{{ $input->label }}</label>
                                                        <input type="text" class="form-control" id="input{{ $loop->iteration }}" name="inputs[{{ $input->id }}]" placeholder="{{ $input->placeholder }}">
                                                    </div>
                                                </div>
                                                @break
                                                @case('select')
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="input{{ $loop->iteration }}" class="control-label col-12">{{ $input->label }}</label>
                                                        <select name="inputs[{{ $input->id }}]" id="input{{ $loop->iteration }}" class="form-control fieldFilter" dir="rtl">
                                                            @foreach($input->options as $option)
                                                                <option value="{{ $option }}"{{ (old('inputs.' . $input->id) == $option ? ' selected' : '') }}>{{ $option }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                @break
                                                @case('checkbox')
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="input{{ $loop->iteration }}" class="control-label col-12">{{ $input->label }}</label>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="inputs[{{ $input->id }}]" id="input{{ $loop->iteration }}" value="1" class="flat"{{ (old('inputs' . $input->id) ? ' checked' : '') }}>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                @break
                                                @case('textarea')
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="input{{ $loop->iteration }}" class="control-label col-12">{{ $input->label }}</label>
                                                        <textarea id="input{{ $loop->iteration }}" name="inputs[{{ $input->id }}]" class="form-control" placeholder="{{ $input->placeholder }}"></textarea>
                                                    </div>
                                                </div>
                                                @break
                                            @endswitch
                                        @endforeach
                                        <div class="col-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary form-control">ارسال</button>
                                            </div>
                                        </div>
                                    @endif
                                </form>
                            @endif
                        @endif
                    </div>
                </article>
            </div>
        </div>
    </div>
@endsection
