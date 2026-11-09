@extends('includes.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- Shop summary card -->
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-store mr-1"></i>
                        بيانات المحل: <strong>{{ $shop->shop_name }}</strong> (كود الدعم: {{ $shop->shop_code }})
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('subscriptions.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-right"></i> رجوع لجدول الاشتراكات
                        </a>
                    </div>
                </div>
                <div class="card-body py-2">
                    <div class="row text-center">
                        <div class="col-md-3 border-left">
                            <span class="text-muted d-block small">الاشتراك الحالي يبدأ في</span>
                            <strong>{{ $shop->start_date ? \Carbon\Carbon::parse($shop->start_date)->format('Y-m-d') : '-' }}</strong>
                        </div>
                        <div class="col-md-3 border-left">
                            <span class="text-muted d-block small">الاشتراك الحالي ينتهي في</span>
                            <strong class="{{ $shop->isExpired() ? 'text-danger' : 'text-success' }}">
                                {{ $shop->end_date ? \Carbon\Carbon::parse($shop->end_date)->format('Y-m-d') : '-' }}
                            </strong>
                        </div>
                        <div class="col-md-3 border-left">
                            <span class="text-muted d-block small">نوع المتجر</span>
                            <span class="badge badge-info">{{ $shop->shop_type ?? 'تجزئة' }}</span>
                        </div>
                        <div class="col-md-3">
                            <span class="text-muted d-block small">حالة المتجر الحالية</span>
                            @if($shop->active == 1 && !$shop->isExpired())
                                <span class="badge badge-success">مفعل</span>
                            @elseif($shop->isExpired())
                                <span class="badge badge-danger">منتهي الصلاحية</span>
                            @else
                                <span class="badge badge-secondary">معطل</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- History table card -->
            <div class="card card-default">
                {{-- <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history mr-1 text-primary"></i>
                        سجل الاشتراكات وتجديداتها لهذا المحل
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#addHistoryForm">
                            <i class="fas fa-plus"></i> إضافة فترة اشتراك سابقة أو جديدة
                        </button>
                    </div>
                </div> --}}

                <div class="card-body">
                    @include('layouts.massage')

                    <!-- Collapsible add history form -->
                    {{-- <div class="collapse mb-4" id="addHistoryForm">
                        <div class="p-3 bg-light rounded border">
                            <h5 class="text-primary mb-3"><i class="fas fa-plus-circle"></i> إضافة فترة اشتراك إلى سجل المحل</h5>
                            <form action="{{ route('subscriptions.storeHistory', $shop->id) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="small font-weight-bold">تاريخ البداية <span class="text-danger">*</span></label>
                                            <input type="date" name="start_date" class="form-control form-control-sm" required value="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="small font-weight-bold">تاريخ النهاية <span class="text-danger">*</span></label>
                                            <input type="date" name="end_date" class="form-control form-control-sm" required value="{{ date('Y-m-d', strtotime('+1 month')) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="small font-weight-bold">المبلغ المدفوع</label>
                                            <input type="number" step="0.01" name="amount" class="form-control form-control-sm" placeholder="0.00" value="0">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="small font-weight-bold">الحالة</label>
                                            <select name="status" class="form-control form-control-sm">
                                                <option value="مفعل">مفعل</option>
                                                <option value="منتهي">منتهي</option>
                                                <option value="ملغي">ملغي</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="small font-weight-bold">النوع</label>
                                            <select name="shop_type" class="form-control form-control-sm">
                                                <option value="تجزئة" {{ $shop->shop_type == 'تجزئة' ? 'selected' : '' }}>تجزئة</option>
                                                <option value="جملة" {{ $shop->shop_type == 'جملة' ? 'selected' : '' }}>جملة</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group mb-2">
                                            <label class="small font-weight-bold">ملاحظات (مثال: تجديد سنوي، اشتراك سابق يدوي، الخ)</label>
                                            <input type="text" name="notes" class="form-control form-control-sm" placeholder="ملاحظات توضيحية حول هذه الفترة...">
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-center pt-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="update_shop_current" value="1" id="updateShopCurrent">
                                            <label class="form-check-label small" for="updateShopCurrent">
                                                تحديث التواريخ الحالية للمحل بهذه التواريخ
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 text-left">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-save"></i> حفظ في السجل
                                    </button>
                                    <button type="button" class="btn btn-secondary btn-sm" data-toggle="collapse" data-target="#addHistoryForm">
                                        إلغاء
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div> --}}

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover text-center align-middle">
                            <thead class="thead-dark">
                            <tr>
                                <th style="width: 30px">#</th>
                                <th>تاريخ بداية الفترة</th>
                                <th>تاريخ نهاية الفترة</th>
                                <th>مدة الاشتراك</th>
                                <th>النوع</th>
                                <th>المبلغ</th>
                                <th>الحالة</th>
                                <th>ملاحظات</th>
                                <th>تاريخ التسجيل</th>
                                <th style="width: 60px">إجراء</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($records as $record)
                                @php
                                    $isExpired = $record->end_date && \Carbon\Carbon::parse($record->end_date)->endOfDay()->isPast();
                                @endphp
                                <tr class="{{ $isExpired ? 'table-light' : 'table-success' }}">
                                    <td>{{ $loop->iteration + ($records->currentPage() - 1) * $records->perPage() }}</td>
                                    <td>{{ $record->start_date ? \Carbon\Carbon::parse($record->start_date)->format('Y-m-d') : '-' }}</td>
                                    <td>
                                        <strong class="{{ $isExpired ? 'text-muted' : 'text-success' }}">
                                            {{ $record->end_date ? \Carbon\Carbon::parse($record->end_date)->format('Y-m-d') : '-' }}
                                        </strong>
                                    </td>
                                    <td><span class="badge badge-info">{{ $record->duration }}</span></td>
                                    <td><span class="badge badge-secondary">{{ $record->shop_type ?? '-' }}</span></td>
                                    <td>{{ number_format($record->amount, 2) }}</td>
                                    <td>
                                        @if(!$isExpired && $record->status == 'مفعل')
                                            <span class="badge badge-success"><i class="fas fa-check-circle"></i> ساري</span>
                                        @elseif($isExpired)
                                            <span class="badge badge-secondary"><i class="fas fa-clock"></i> منتهي</span>
                                        @else
                                            <span class="badge badge-warning">{{ $record->status }}</span>
                                        @endif
                                    </td>
                                    <td><small>{{ $record->notes ?? '-' }}</small></td>
                                    <td><small class="text-muted">{{ $record->created_at ? $record->created_at->format('Y-m-d H:i') : '-' }}</small></td>
                                    <td>
                                        <form action="{{ route('subscriptions.destroyHistory', $record->id) }}" method="POST" style="display:inline;"
                                              onsubmit="return confirm('هل تريد بالتأكيد حذف هذا السجل من تاريخ المحل؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-xs" title="حذف السجل">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4 text-muted">
                                        <i class="fas fa-history fa-3x mb-2 d-block"></i>
                                        لا توجد فترات اشتراك مسجلة في أرشيف هذا المحل بعد.
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

