@extends('includes.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">إضافة إعلان جديد</h3>
                    <div class="card-tools">
                        <a href="{{ route('ads.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-right"></i> رجوع للإعلانات
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @include('layouts.massage')

                    {!! Form::open([
                        'action' => ['Admin\AdController@store'],
                        'method' => 'post',
                        'files' => true,
                        'enctype' => 'multipart/form-data',
                        'class' => 'form-horizontal project-form'
                    ]) !!}

                    @include('dashboard.ads.form')

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-plus-circle"></i> إضافة الإعلان
                        </button>
                        <a href="{{ route('ads.index') }}" class="btn btn-default float-right">إلغاء</a>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

