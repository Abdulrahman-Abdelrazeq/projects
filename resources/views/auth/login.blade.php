@extends('includes.auth-master')

@section('content')

    <p class="login-box-msg">تسجيل الدخول</p>

    @if(session()->has('error'))
        <div class="row">
            <div class="col-xs-12 col-sm-12" id="success">
                <ul class="alert alert-danger text-center list-unstyled">
                    {!! session()->get('error') !!}
                </ul>
            </div>
        </div>
    @endif


    <form action="{{ url('/login') }}" method="post">
        {{ csrf_field() }}
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="البريد الالكترونى">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>

        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="الرقم السرى">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>
{{--        @if(session()->has('error'))--}}
{{--            <span class="help-block">--}}
{{--                    <strong style="font-size: large; color: red">  {!! session()->get('error') !!}</strong>--}}
{{--                    </span>--}}
{{--        @endif--}}
        <div class="row">
{{--            <div class="col-8">--}}
{{--                <div class="icheck-primary">--}}
{{--                    <input type="checkbox" id="remember">--}}
{{--                    <label for="remember">--}}
{{--                        تذكرنى--}}
{{--                    </label>--}}
{{--                </div>--}}
{{--            </div>--}}
            <!-- /.col -->
            <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">دخول</button>
            </div>
            <!-- /.col -->
        </div>
    </form>

    {{--      <div class="social-auth-links text-center mb-3">--}}
    {{--        <p>- أو -</p>--}}
    {{--        <a href="#" class="btn btn-block btn-primary">--}}
    {{--          <i class="fab fa-facebook mr-2"></i> التسجيل باستخدام الفيس بوك--}}
    {{--        </a>--}}
    {{--        <a href="#" class="btn btn-block btn-danger">--}}
    {{--          <i class="fab fa-google-plus mr-2"></i> التسجيل باستخدام جوجل--}}
    {{--        </a>--}}
    {{--      </div>--}}
    <!-- /.social-auth-links -->

    {{--      <p class="mb-1">--}}
    {{--        <a href="#">نسيت كلمة المرور </a>--}}
    {{--      </p>--}}
    {{--      <p class="mb-0">--}}
    {{--        <a href="register.html" class="text-center">تسجيل من جديد</a>--}}
    {{--      </p>--}}
@stop


