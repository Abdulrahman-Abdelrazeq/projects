@extends('includes.master')
@section('content')
    <!-- Main row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title"> تعديل تعليمات  </h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <div class="card-body">
                    @include('layouts.massage')
                    {!! Form::model($record,[
                    'action' => ['Admin\InstructionController@update',$record->id],
                    'method' => 'put',
                    'files' => true,
                    'enctype' => 'multipart/form-data',
                    'class'=>"form-horizontal project-form"
                    ]) !!}

                    @include('dashboard.instructions.form')

                    <!-- /.card-body -->
                    <div class="card-footer">
                        <div class=" row  justify-content-between">
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-info"> تعديل</button>
                            </div>

                            <div class="col-sm-4">
                                <a href="{{route('instructions.edit',$record->id)}}" type="submit"
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
