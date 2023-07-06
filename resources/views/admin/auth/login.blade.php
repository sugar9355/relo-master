@extends('admin.layout.auth')

@section('content')
<div class="sign-form">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <div class="box p-4">
                    <h1 class="text-center border-bottom pb-2 text-purple">@lang('admin.auth.admin_login')</h1>
                <form class="form-material mb-1" role="form" method="POST" action="{{ url('/admin/login') }}" >
                {{ csrf_field() }}
                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                        <input type="email" name="email" required="true" class="form-control h3" id="email" placeholder="@lang('admin.email')">
                        @if ($errors->has('email'))
                            <span class="help-block" style="margin-left: 55px;color: red;">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                        <input type="password" name="password" required="true" class="form-control h3" id="password" placeholder="@lang('admin.password')">
                        @if ($errors->has('password'))
                            <span class="help-block" style="margin-left: 55px;color: red;">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="px-2 form-group">
                        <div class="form-check form-check-inline mb-0 mt-3">
                          <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="remember">
                          <label class="form-check-label" for="inlineCheckbox1">@lang('admin.auth.remember_me')</label>
                        </div>
                    </div>
                    <hr>
                    <div class="px-2 form-group mb-0">
                        <button type="submit" class="btn btn-purple btn-block text-uppercase">@lang('admin.auth.sign_in')</button>
                    </div>
                </form>
                <div class="p-2 text-xs-center text-muted">
                    <a class="text-black" href="{{ url('/admin/password/reset') }}"><span class="underline">@lang('admin.auth.forgot_your_password')?</span></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
