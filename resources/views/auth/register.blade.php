<style> {
    body {margin-bottom: 25rem;}
}


</style>
<p>@extends('frontend.layouts.app') @section('styles')@endsection @section('content')</p>
<div class="container">
<div class="row justify-content-center">
<div class="col-md-6 mt-4">
<div class="card d-block">
<div class="card-header">ثبت&zwnj;نام</div>
<div class="card-body">
 @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<form action="{{ route('register') }}" method="POST">@csrf
<div class="form-group row"><label class="col-md-4 col-form-label text-md-right" for="first_name">نام</label>
    <div class="col-md-6"><input id="first_name" class="form-control @error('first_name') is-invalid @enderror" autocomplete="first_name" name="first_name" required="" type="text" value="{{ old('first_name') }}" autofocus="" /> @error('first_name') <span class="text-danger" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div>
</div>
<br />
<div class="form-group row"><label class="col-md-4 col-form-label text-md-right" for="last_name">نام خانوادگی</label>
<div class="col-md-6"><input id="last_name" class="form-control @error('last_name') is-invalid @enderror" autocomplete="last_name" name="last_name" required="" type="text" value="{{ old('last_name') }}" autofocus="" /> @error('last_name') <span class="text-danger" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div>
</div>
<br />
<div class="form-group row"><label class="col-md-4 col-form-label text-md-right" for="last_name">شهر</label>
<div class="col-md-6"><input id="city" class="form-control @error('city') is-invalid @enderror" autocomplete="city" name="city" required="" type="text" value="{{ old('city') }}" autofocus="" /> @error('city') <span class="text-danger" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div>
</div>
<br />
<div class="form-group row"><label class="col-md-4 col-form-label text-md-right" for="last_name">شغل</label>
<div class="col-md-6"><input id="job" class="form-control @error('job') is-invalid @enderror" autocomplete="job" name="job" required="" type="text" value="{{ old('job') }}" autofocus="" /> @error('job') <span class="text-danger" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div>
</div>
<br />
<div class="form-group row">
    <label class="col-md-4 col-form-label text-md-right" for="mobile">موبایل</label>
<div class="col-md-6"><input id="mobile" class="form-control @error('mobile') is-invalid @enderror" autocomplete="mobile" name="mobile" required="" type="text" value="{{ old('mobile') }}" autofocus="" /> @error('mobile')
<span class="text-danger" role="alert"><strong>{{ $message }}</strong> </span> @enderror </div>
<br />
</div>
 <br />
 <div class="form-group row"><label class="col-md-4 col-form-label text-md-right" for="password">پسورد</label>
    <div class="col-md-6"><input id="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password" name="password" required="" type="password" /> @error('password') <span class="text-danger" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div>
    </div>

    <br />
    <div class="form-group row"><label class="col-md-4 col-form-label text-md-right" for="password-confirm">تکرار پسورد</label>
    <div class="col-md-6"><input id="password-confirm" class="form-control" autocomplete="new-password" name="password_confirmation" required="" type="password" /></div>
    </div>

<div class="form-group row">&nbsp;</div>
<div class="form-group row"><br />
<div class="form-group row mb-0">
<div class="col-md-6 offset-md-4" style="text-align: center;"><button class="btn btn-primary" type="submit">ثبت&zwnj;نام</button></div>
</div>
</div>
</form></div>
</div>
</div>
</div>
</div>
<p>@endsection</p>
