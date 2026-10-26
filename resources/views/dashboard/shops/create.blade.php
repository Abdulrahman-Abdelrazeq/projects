@extends('includes.master')
@section('content')
    <!-- Main row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">اضافة محل </h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <div class="card-body">
                    @if (count($errors))
                        <div class="form-group">
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    @if(session()->has('error'))
                        <div class="form-group">
                            <div class="alert alert-danger">
                                <ul>
                                    <li>{{ session()->get('error')}}</li>
                                </ul>
                            </div>
                        </div>
                    @endif
                    {!! Form::open([
                    'action' => ['Admin\ShopController@store'],
                    'method' => 'post',
                    'files' => true,
                    'enctype' => 'multipart/form-data',
                    'class'=>"form-horizontal project-form"
                    ]) !!}


                @include('dashboard.shops.form')


                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info" onclick="this.disabled=true;this.form.submit();"
                        > إضافة
                        </button>
                        <a href="{{route('shops.create')}}" type="submit" class="btn btn-default float-right">إلغاء</a>
                    </div>
                    <!-- /.card-footer -->
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

@stop
