@extends('includes.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-calendar-check mr-1 text-primary"></i> إدارة الاشتراكات (تطبيق مايو مول)</h3>
                    <div class="card-tools">
                        <a class="btn btn-outline-info btn-sm mr-1" href="{{ route('subscriptions.allHistory') }}">
                            <i class="fas fa-archive"></i> أرشيف الاشتراكات
                        </a>
                        <a class="btn btn-outline-success btn-sm" href="{{ route('subscriptions.create') }}">
                            <i class="fas fa-plus"></i> إضافة اشتراك
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- نموذج الفلترة والبحث -->
                    <form method="get" action="{{ route('subscriptions.index') }}" class="mb-4 p-3 bg-light rounded border">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-2">
                                    <label class="small text-muted">اسم المحل / كود الدعم / الهاتف</label>
                                    <input type="text" name="name" class="form-control form-control-sm"
                                           placeholder="بحث بالاسم أو الكود..." value="{{ request('name') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-2">
                                    <label class="small text-muted">من تاريخ بداية</label>
                                    <input type="date" name="start_date" class="form-control form-control-sm"
                                           value="{{ request('start_date') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-2">
                                    <label class="small text-muted">إلى تاريخ نهاية</label>
                                    <input type="date" name="end_date" class="form-control form-control-sm"
                                           value="{{ request('end_date') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-2">
                                    <label class="small text-muted">النوع</label>
                                    <select name="shop_type" class="form-control form-control-sm">
                                        <option value="all">الكل</option>
                                        <option value="تجزئة" {{ request('shop_type') == 'تجزئة' ? 'selected' : '' }}>تجزئة</option>
                                        <option value="جملة" {{ request('shop_type') == 'جملة' ? 'selected' : '' }}>جملة</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group mb-2">
                                    <label class="small text-muted">الحالة</label>
                                    <select name="active" class="form-control form-control-sm">
                                        <option value="all">الكل</option>
                                        <option value="1" {{ request('active') === '1' ? 'selected' : '' }}>مفعل</option>
                                        <option value="0" {{ request('active') === '0' ? 'selected' : '' }}>غير مفعل</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 d-flex align-items-end mb-2">
                                <button class="btn btn-primary btn-sm ml-1" type="submit">
                                    <i class="fas fa-search"></i> فلترة
                                </button>
                                <a href="{{ route('subscriptions.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-redo"></i> إعادة تعيين
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
                                <th>كود الدعم</th>
                                <th>اسم المحل</th>
                                <th>الصورة</th>
                                <th>تاريخ بداية الاشتراك</th>
                                <th>تاريخ نهاية الاشتراك</th>
                                <th>رقم التليفون</th>
                                <th>العنوان</th>
                                <th>رابط API التطبيق</th>
                                <th>رابط API لوحة التحكم</th>
                                <th>جملة / تجزئة</th>
                                <th>ترتيب الظهور</th>
                                <th>حالة الاشتراك</th>
                                <th style="width: 130px">الإجراءات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($records as $record)
                                @php
                                    $isExpired = $record->end_date && \Carbon\Carbon::parse($record->end_date)->endOfDay()->isPast();
                                @endphp
                                <tr class="{{ $isExpired ? 'table-danger' : '' }}">
                                    <td>{{ $loop->iteration + ($records->currentPage() - 1) * $records->perPage() }}</td>
                                    <td><span class="badge badge-info">{{ $record->shop_code }}</span></td>
                                    <td>
                                        <strong>{{ $record->shop_name }}</strong>
                                        @if($isExpired)
                                            <br><span class="badge badge-danger">منتهي الصلاحية</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($record->image)
                                            <a href="{{ asset('storage/' . $record->image) }}" data-lightbox="image">
                                                <img src="{{ asset('storage/' . $record->image) }}" alt="image"
                                                     class="img-thumbnail" style="height: 50px; width: 50px; object-fit: cover;">
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $record->start_date ? \Carbon\Carbon::parse($record->start_date)->format('Y-m-d') : '-' }}</td>
                                    <td>
                                        <span class="{{ $isExpired ? 'text-danger font-weight-bold' : 'text-success font-weight-bold' }}">
                                            {{ $record->end_date ? \Carbon\Carbon::parse($record->end_date)->format('Y-m-d') : '-' }}
                                        </span>
                                    </td>
                                    <td>{{ $record->phone ?? '-' }}</td>
                                    <td><small>{{ $record->address ?? '-' }}</small></td>
                                    <td>
                                        <a href="{{ $record->link_api }}" target="_blank" class="badge badge-light" title="{{ $record->link_api }}">
                                            {{ Str::limit($record->link_api, 20) }} <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    </td>
                                    <td>
                                        @if($record->admin_link_api)
                                            <a href="{{ $record->admin_link_api }}" target="_blank" class="badge badge-light" title="{{ $record->admin_link_api }}">
                                                {{ Str::limit($record->admin_link_api, 20) }} <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $record->shop_type == 'جملة' ? 'badge-primary' : 'badge-secondary' }}">
                                            {{ $record->shop_type ?? 'تجزئة' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-dark">{{ $record->sort_order ?? 0 }}</span>
                                    </td>
                                    <td>
                                        @if($record->active == 1 && !$isExpired)
                                            <span class="badge badge-success"><i class="fas fa-check-circle"></i> مفعل</span>
                                        @elseif($isExpired)
                                            <span class="badge badge-danger"><i class="fas fa-clock"></i> منتهي</span>
                                        @else
                                            <span class="badge badge-secondary"><i class="fas fa-times-circle"></i> معطل</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a class="btn btn-secondary btn-xs" href="{{ route('subscriptions.history', $record->id) }}" title="سجل اشتراكات المحل">
                                                <i class="fas fa-history"></i>
                                            </a>

                                            <a class="btn btn-info btn-xs" href="{{ route('subscriptions.edit', $record->id) }}" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            @if($record->admin_link_api)
                                                <form action="{{ route('subscriptions.sync', $record->id) }}" method="POST" style="display:inline;"
                                                      onsubmit="return confirm('هل تريد مزامنة تاريخ نهاية الاشتراك مع لوحة التاجر الآن؟');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning btn-xs" title="مزامنة مع لوحة التاجر">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('subscriptions.destroy', $record->id) }}" method="POST" style="display:inline;"
                                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا الاشتراك نهائياً؟');">
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
                                    <td colspan="14" class="text-center py-4 text-muted">
                                        <i class="fas fa-inbox fa-3x mb-2 d-block"></i>
                                        لا توجد اشتراكات مسجلة حالياً
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

