@extends('includes.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">تعديل بيانات الاشتراك ({{ $record->shop_name }})</h3>
                    <div class="card-tools">
                        <a href="{{ route('subscriptions.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-right"></i> رجوع لجدول الاشتراكات
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @include('layouts.massage')

                    {!! Form::model($record, [
                        'action' => ['Admin\SubscriptionController@update', $record->id],
                        'method' => 'put',
                        'files' => true,
                        'enctype' => 'multipart/form-data',
                        'class' => 'form-horizontal project-form'
                    ]) !!}

                    @include('dashboard.subscriptions.form')

                    <div class="card-footer">
                        <div class="row justify-content-between">
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-info">
                                    <i class="fas fa-save"></i> حفظ التعديلات
                                </button>
                            </div>
                            <div class="col-sm-4 text-left">
                                <a href="{{ route('subscriptions.index') }}" class="btn btn-default float-right">إلغاء</a>
                            </div>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

