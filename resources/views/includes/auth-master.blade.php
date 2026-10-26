<!DOCTYPE html>
<html>
@include('includes.head')

<style>
    .login-box, .register-box {
        margin: 7% auto;
        width: 450px !important;
    }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">

            <img src="{{ asset('assets/admin-lte/dist/img/splash.png') }}" width="220">
            <br>

            <a href="javascript:void(0)"> لوحة تحكم سلسله محلات ابوسمره </a>
        </div>
        <!-- Main content -->
        <div class="card">
            <div class="card-body login-card-body">

                @yield('content')

            </div>
        </div>
    </div>
    @include('includes.footer')

    </body>
</html>

