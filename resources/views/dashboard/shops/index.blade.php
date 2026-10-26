@extends('includes.master')
@section('content')
    <!-- Main row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title"> المحلات </h3>
                    <div class="card-tools">
                        <a class="btn  btn-outline-success btn-xs text-success" href="{{route('shops.create')}}">
                            <i class="fas fa-plus"></i> اضافة محل
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="get" class="search-form" role="search">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
{{--                                    <label> اسم المستخدم </label>--}}
                                </div>
                                {{--                                <div class="col-md-6">--}}
                                {{--                                    @inject('user','App\Models\User')--}}
                                {{--                                    {!! Form::select('name', $user->pluck('name','id')->toArray()--}}
                                {{--                                          ,request('name'), [--}}
                                {{--                                        'class' => 'select2 form-control',--}}
                                {{--                                        'placeholder' => 'اختر المستخدم'--}}
                                {{--                                    ]) !!}--}}
                                {{--                                </div>--}}
                                <div class="col-md-1">
{{--                                    <button class="btn btn-search" type="submit">--}}
{{--                                        <i class="fas fa-search"></i>--}}
{{--                                    </button>--}}
                                </div>
                            </div>
                        </div>
                        <!-- /.row -->
                    </form>
                    <table class="table table-striped">
                        @include('layouts.massage')
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 10px">#</th>
                            <th class="text-center"> اسم المحل</th>
                            <th class="text-center">رابط الapi</th>
                            <th class="text-center">الصورة</th>
                            <th class="text-center">كود الدعم الفنى</th>
                            <th class="text-center">عنوان المحل</th>
                            <th class="text-center"> مفعل</th>
                            <th class="text-center"> تعديل</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($records as $record)
                            <tr>
                                <td class="text-center">{{$loop->iteration}}.</td>
                                <td class="text-center"> {{$record->shop_name}}</td>
                                <td class="text-center"> {{$record->link_api}} </td>
                                <td class="text-center">
                                    <a href="{{  asset('storage/'.$record->image) }}" data-lightbox="image"
                                                           data-title="{{ $record->title }}">
                                        <img src="{{ asset('storage/' .$record->image) }}" alt="image"
                                             class="img-thumbnail" style="height: 70px;">
                                    </a></td>
                                <td class="text-center"> {{$record->shop_code}} </td>
                                <td class="text-center"> {{$record->address}} </td>

                                @if($record->active == 1)
                                    <td class="text-center">
                                    <span>
                                       <i class="fas fa-check-circle  text-success"></i>
                                    </span>
                                    </td>
                                @else
                                    <td class="text-center">
                                    <span>
                                       <i class="fas fa-times-circle  text-danger"></i>
                                    </span>
                                    </td>
                                @endif

                                <td class="text-center">
                                    <a class="btn btn-xs" href="{{route('shops.edit',$record->id)}}">
                                        <i class="fas fa-edit text-success"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!-- /.card-body -->
                </div>
                <div class="card-footer text-xs-center">
                    <ul class="pagination">
                        {!! $records->render() !!}
                    </ul>
                </div>
            </div>
        </div>
@stop
