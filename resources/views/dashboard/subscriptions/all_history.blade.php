@extends('includes.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-archive mr-1 text-primary"></i>
                        سجل وأرشيف اشتراكات جميع المحلات
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('subscriptions.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-right"></i> رجوع لجدول الاشتراكات الحالية
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- نموذج الفلترة والبحث -->
                    <form method="get" action="{{ route('subscriptions.allHistory') }}" class="mb-4 p-3 bg-light rounded border">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label class="small text-muted">المحل</label>
                                    <select name="shop_id" class="form-control form-control-sm select2">
                                        <option value="">جميع المحلات</option>
                                        @foreach($shops as $sId => $sName)
                                            <option value="{{ $sId }}" {{ request('shop_id') == $sId ? 'selected' : '' }}>{{ $sName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-2">
                                    <label class="small text-muted">من تاريخ بداية</label>
                                    <input type="date" name="start_date" class="form-control form-control-sm" value="{{ request('start_date') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-2">
                                    <label class="small text-muted">إلى تاريخ نهاية</label>
                                    <input type="date" name="end_date" class="form-control form-control-sm" value="{{ request('end_date') }}">
                                </div>
                            </div>
                            <div class="col-md-2 d-flex align-items-end mb-2">
                                <button class="btn btn-primary btn-sm ml-1" type="submit">
                                    <i class="fas fa-search"></i> فلترة
                                </button>
                                <a href="{{ route('subscriptions.allHistory') }}" class="btn btn-secondary btn-sm">
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
                                <th>اسم المحل</th>
                                <th>كود الدعم</th>
                                <th>تاريخ بداية الفترة</th>
                                <th>تاريخ نهاية الفترة</th>
                                <th>المدة</th>
                                <th>المبلغ</th>
                                <th>الحالة</th>
                                <th>ملاحظات</th>
                                <th>تاريخ التسجيل</th>
                                <th style="width: 100px">الإجراءات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($records as $record)
                                @php
                                    $isExpired = $record->end_date && \Carbon\Carbon::parse($record->end_date)->endOfDay()->isPast();
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration + ($records->currentPage() - 1) * $records->perPage() }}</td>
                                    <td>
                                        @if($record->shop)
                                            <strong>{{ $record->shop->shop_name }}</strong>
                                        @else
                                            <span class="text-muted">محل محذوف</span>
                                        @endif
                                    </td>
                                    <td><span class="badge badge-info">{{ $record->shop ? $record->shop->shop_code : '-' }}</span></td>
                                    <td>{{ $record->start_date ? \Carbon\Carbon::parse($record->start_date)->format('Y-m-d') : '-' }}</td>
                                    <td>
                                        <strong class="{{ $isExpired ? 'text-muted' : 'text-success' }}">
                                            {{ $record->end_date ? \Carbon\Carbon::parse($record->end_date)->format('Y-m-d') : '-' }}
                                        </strong>
                                    </td>
                                    <td><span class="badge badge-secondary">{{ $record->duration }}</span></td>
                                    <td>{{ number_format($record->amount, 2) }}</td>
                                    <td>
                                        @if(!$isExpired && $record->status == 'مفعل')
                                            <span class="badge badge-success">ساري</span>
                                        @elseif($isExpired)
                                            <span class="badge badge-secondary">منتهي</span>
                                        @else
                                            <span class="badge badge-warning">{{ $record->status }}</span>
                                        @endif
                                    </td>
                                    <td><small>{{ $record->notes ?? '-' }}</small></td>
                                    <td><small class="text-muted">{{ $record->created_at ? $record->created_at->format('Y-m-d') : '-' }}</small></td>
                                    <td>
                                        @if($record->shop)
                                            <a href="{{ route('subscriptions.history', $record->shop->id) }}" class="btn btn-info btn-xs" title="سجل هذا المحل">
                                                <i class="fas fa-history"></i>
                                            </a>
                                        @endif

                                        <form action="{{ route('subscriptions.destroyHistory', $record->id) }}" method="POST" style="display:inline;"
                                              onsubmit="return confirm('هل تريد بالتأكيد حذف هذا السجل؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-xs" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center py-4 text-muted">
                                        <i class="fas fa-inbox fa-3x mb-2 d-block"></i>
                                        لا توجد سجلات اشتراكات بعد.
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

