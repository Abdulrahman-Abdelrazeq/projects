@extends('includes.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-bullhorn mr-1 text-primary"></i> إدارة الإعلانات</h3>
                    <div class="card-tools">
                        <a class="btn btn-outline-success btn-sm" href="{{ route('ads.create') }}">
                            <i class="fas fa-plus"></i> إضافة إعلان
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- نموذج الفلترة والبحث -->
                    <form method="get" action="{{ route('ads.index') }}" class="mb-4 p-3 bg-light rounded border">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label class="small text-muted">عنوان الإعلان</label>
                                    <input type="text" name="title" class="form-control form-control-sm"
                                           placeholder="بحث بالعنوان..." value="{{ request('title') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-2">
                                    <label class="small text-muted">الحالة</label>
                                    <select name="active" class="form-control form-control-sm">
                                        <option value="all">الكل</option>
                                        <option value="1" {{ request('active') === '1' ? 'selected' : '' }}>مفعل</option>
                                        <option value="0" {{ request('active') === '0' ? 'selected' : '' }}>غير مفعل</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex align-items-end mb-2">
                                <button class="btn btn-primary btn-sm ml-1" type="submit">
                                    <i class="fas fa-search"></i> بحث
                                </button>
                                <a href="{{ route('ads.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-redo"></i> إلغاء
                                </a>
                            </div>
                        </div>
                    </form>

                    @include('layouts.massage')

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover text-center align-middle">
                            <thead class="thead-dark">
                            <tr>
                                <th style="width: 30px">#</th>
                                <th>عنوان الإعلان</th>
                                <th>الصورة</th>
                                <th>الرابط</th>
                                <th>الترتيب</th>
                                <th>الحالة</th>
                                <th>تاريخ الإضافة</th>
                                <th style="width: 110px">الإجراءات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($records as $record)
                                <tr>
                                    <td>{{ $loop->iteration + ($records->currentPage() - 1) * $records->perPage() }}</td>
                                    <td><strong>{{ $record->title }}</strong></td>
                                    <td>
                                        @if($record->image)
                                            <a href="{{ asset('storage/' . $record->image) }}" data-lightbox="image">
                                                <img src="{{ asset('storage/' . $record->image) }}" alt="image"
                                                     class="img-thumbnail" style="height: 60px; max-width: 100px; object-fit: cover;">
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($record->link)
                                            <a href="{{ $record->link }}" target="_blank" class="badge badge-light" title="{{ $record->link }}">
                                                {{ Str::limit($record->link, 25) }} <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td><span class="badge badge-dark">{{ $record->order ?? 0 }}</span></td>
                                    <td>
                                        @if($record->active == 1)
                                            <span class="badge badge-success"><i class="fas fa-check-circle"></i> مفعل</span>
                                        @else
                                            <span class="badge badge-secondary"><i class="fas fa-times-circle"></i> معطل</span>
                                        @endif
                                    </td>
                                    <td><small>{{ $record->created_at ? $record->created_at->format('Y-m-d') : '-' }}</small></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a class="btn btn-info btn-xs" href="{{ route('ads.edit', $record->id) }}" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('ads.destroy', $record->id) }}" method="POST" style="display:inline;"
                                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا الإعلان نهائياً؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-xs" title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        <i class="fas fa-bullhorn fa-3x mb-2 d-block"></i>
                                        لا توجد إعلانات مسجلة حالياً
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer clearfix">
                        <div class="float-right">
                            {!! $records->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

