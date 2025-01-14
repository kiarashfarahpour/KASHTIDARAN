@extends('admin.layouts.app')
@section('styles')
    <link href="{{ asset('vendor/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('scripts')
    <script src="{{ asset('vendor/yajra/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/yajra/js/simple_numbers_no_ellipses.js') }}"></script>
    <script type="text/javascript">
        $.fn.DataTable.ext.pager.simple_numbers_no_ellipses = function(page, pages){
            var numbers = [];
            var buttons = $.fn.DataTable.ext.pager.numbers_length;
            var half = Math.floor( buttons / 2 );
            var _range = function ( len, start ){
                var end;
                if ( typeof start === "undefined" ){
                    start = 0;
                    end = len;
                } else {
                    end = start;
                    start = len;
                }
                var out = [];
                for ( var i = start ; i < end; i++ ){ out.push(i); }
                return out;
            };
            if ( pages <= buttons ) {
                numbers = _range( 0, pages );
            } else if ( page <= half ) {
                numbers = _range( 0, buttons);
            } else if ( page >= pages - 1 - half ) {
                numbers = _range( pages - buttons, pages );
            } else {
                numbers = _range( page - half, page + half + 1);
            }
            numbers.DT_el = 'span';
            return [ 'previous', numbers, 'next' ];
        };
    </script>
    <script type="text/javascript">
        $('#forms').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.forms.ajax') }}',
                method: 'POST'
            },
            columns: [
                {data: 'name', name: 'name'},
                {data: 'authenticated', name: 'authenticated'},
                {data: 'actions', name: 'actions', orderable: false, searchable: false},
            ],
            "order": [[ 1, "desc" ]],
            initComplete: function () {
                this.api().columns('.search').every(function () {
                    var column = this;
                    var input = document.createElement("input");
                    $(input).addClass('form-control').appendTo($(column.footer()).empty())
                        .on('change', function () {
                            column.search($(this).val()).draw();
                        });
                });
            },
            "language": {
                "url": "{{ asset('vendor/yajra/i18n/Persian.json') }}"
            },
            "pagingType": "simple_numbers_no_ellipses"
        });
    </script>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>فرم‌ها</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a href="{{ route('admin.forms.create') }}"><i class="fa fa-plus"></i> افزودن فرم</a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="forms" class="table table-hover">
                    <thead>
                        <tr>
                            <th>نام</th>
                            <th>نوع نمایش</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
