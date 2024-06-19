@extends('frontend.layouts.shop')
@section('content')
<div class="container"> 
    <div class="row">
        <div id="content" class="col-sm-12 card card-body my-4">
            <h2>تیکت‌های من</h2>
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>عنوان</th>
                        <th>اولویت</th>
                        <th>تاریخ ایجاد</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $ticket->title }}</td>
                            <td>
                                @if($ticket->priority == 'high')
                                    زیاد
                                @elseif($ticket->priority == 'medium')
                                    متوسط
                                @else
                                    کم
                                @endif
                            </td>
                            <td>{{ jdate($ticket->created_at)->format('d M Y') }}</td>
                            <td>{{ $ticket->status == 1 ? 'باز' : 'بسته' }}</td>
                            <td>
                                <a class="btn btn-secondary text-white btn-xs" href="{{ route('frontend.tickets.show', $ticket->slug) }}">
                                    <span class="fa fa-eye"></span>
                                    مشاهده تیکت
                                </a>

                                <form style="display: inline-block;" action="{{ route('frontend.tickets.destroy', $ticket->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-{{ $ticket->status ? 'warning' : 'success' }} btn-xs" name="status" value="{{ $ticket->status ? 0 : 1}}" title="{{ $ticket->status == 1 ? 'رد نظر' : 'تایید نظر' }}">
                                        <span class="fa fa-{{ $ticket->status ? 'close' : 'check' }}"></span> {{ $ticket->status ? 'بستن تیکت' : 'باز کردن تیکت' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="6">
                        <a class="btn btn-primary text-white" href="{{ route('frontend.tickets.create') }}">تیکت جدید</a>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
