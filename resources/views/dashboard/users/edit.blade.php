@extends('includes.master')
@section('content')
    <!-- Main row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">تعديل بيانات مستخدم </h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <div class="card-body">
                    @include('layouts.massage')
                    {!! Form::model($record,[
                    'action' => ['Admin\UserController@update',$record->id],
                    'method' => 'put',
                    'files' => true,
                    'enctype' => 'multipart/form-data',
                    'class'=>"form-horizontal project-form"
                    ]) !!}
                    <div class="form-group row">
                        <label for="inputName" class="col-sm-2 control-label">تعديل</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" value="{{$record->name}}" class="form-control" id="inputName"
                                   placeholder="الإسم">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 control-label">البريد الإلكترونى</label>
                        <div class="col-sm-10">
                            <input type="text" name="email" value="{{$record->email}}" class="form-control"
                                   id="inputEmail3" placeholder="البريد الإلكترونى">
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
                        <div class=" row  justify-content-between">
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-info"> تعديل</button>
                            </div>


                            @if(auth()->id() != $record->id)
                                <div class="col-sm-4 text-center">
                                    <a href="{{url('/user/change-status/'.$record->id)}}" type="button"
                                       class="btn  btn-secondary"> تفعيل / إيقاف
                                    </a>
                                </div>
                            @else

                            @endif


                            <div class="col-sm-4">
                                <a href="{{route('users.edit',$record->id)}}" type="submit"
                                   class="btn btn-default float-right">إلغاء</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-footer -->
                    {!! Form::close() !!}
                </div>

            </div>
        </div>

@stop
