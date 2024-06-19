@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>آیتم‌های هواشناسی {{ $weather->name }}</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a href="{{ route('admin.items.create', $weather->slug) }}"><i class="fa fa-plus"></i> افزودن آیتم</a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="display: block;">
                <div class="table-responsive">
                    <table class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان</th>
                            <th>ترتیب</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->sort_order }}</td>
                            <td>
                                <a href="{{ route('admin.items.edit', $item->id) }}" class="btn btn-primary btn-xs">
                                    <span class="fa fa-pencil"></span> ویرایش
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="4">هیچ آیتمی یافت نشد!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                </div>
                {{ $items->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
