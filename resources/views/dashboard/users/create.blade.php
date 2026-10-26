@extends('includes.master')
@section('content')
    <!-- Main row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">اضافة مستخدم </h3>
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
                    'action' => ['Admin\UserController@store'],
                    'method' => 'post',
                    'files' => true,
                    'enctype' => 'multipart/form-data',
                    'class'=>"form-horizontal project-form"
                    ]) !!}
                    <div class="form-group row">
                        <label for="inputName" class="col-sm-2 control-label">الإسم</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control" id="inputName" placeholder="الإسم">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 control-label">البريد الإلكترونى</label>
                        <div class="col-sm-10">
                            <input type="text" name="email" class="form-control" id="inputEmail3"
                                   placeholder="البريد الإلكترونى">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 control-label">الرقم السرى</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" class="form-control" id="inputPassword3"
                                   placeholder="الرقم السرى">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputCpassword3" class="col-sm-2 control-label"> تأكيد الرقم السرى</label>
                        <div class="col-sm-10">
                            <input type="password" name="password_confirmation" class="form-control"
                                   id="inputCpassword3" placeholder=" تأكيد الرقم السرى">
                        </div>
                    </div>

                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info" onclick="this.disabled=true;this.form.submit();"
                        > إضافة</button>
                        <a href="{{route('users.create')}}" type="submit" class="btn btn-default float-right">إلغاء</a>
                    </div>
                    <!-- /.card-footer -->
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

@stop
