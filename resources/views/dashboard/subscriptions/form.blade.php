<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="shop_name"><b>اسم المحل <span class="text-danger">*</span></b></label>
            {!! Form::text('shop_name', null, [
                'class' => 'form-control input-lg',
                'placeholder' => 'اسم المحل',
                'required' => 'required'
            ]) !!}
            @error('shop_name')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="shop_code"><b>كود الدعم الفني <span class="text-danger">*</span></b></label>
            {!! Form::text('shop_code', null, [
                'class' => 'form-control input-lg',
                'placeholder' => 'كود الدعم الفني (رقم المحل / Serial ID)',
                'required' => 'required'
            ]) !!}
            @error('shop_code')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="phone"><b>رقم التليفون</b></label>
            {!! Form::text('phone', null, [
                'class' => 'form-control input-lg',
                'placeholder' => 'رقم التليفون'
            ]) !!}
            @error('phone')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="address"><b>عنوان المحل <span class="text-danger">*</span></b></label>
            {!! Form::text('address', null, [
                'class' => 'form-control input-lg',
                'placeholder' => 'عنوان المحل',
                'required' => 'required'
            ]) !!}
            @error('address')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="link_api"><b>رابط الـ API الخاص بالتطبيق <span class="text-danger">*</span></b></label>
            {!! Form::text('link_api', null, [
                'class' => 'form-control input-lg',
                'placeholder' => 'مثال: https://samraapp.abosamrastore.com/api/v7',
                'required' => 'required'
            ]) !!}
            @error('link_api')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="admin_link_api"><b>رابط الـ API الخاص بلوحة التحكم (لوحة التاجر)</b></label>
            {!! Form::text('admin_link_api', null, [
                'class' => 'form-control input-lg',
                'placeholder' => 'مثال: http://localhost/badrshop/'
            ]) !!}
            <small class="form-text text-muted">الرابط المستخدم لمزامنة تاريخ انتهاء الاشتراك مع لوحة التاجر</small>
            @error('admin_link_api')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="start_date"><b>تاريخ بداية الاشتراك <span class="text-danger">*</span></b></label>
            {!! Form::date('start_date', $record->start_date ? \Carbon\Carbon::parse($record->start_date)->format('Y-m-d') : date('Y-m-d'), [
                'class' => 'form-control input-lg',
                'required' => 'required'
            ]) !!}
            @error('start_date')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="end_date"><b>تاريخ نهاية الاشتراك <span class="text-danger">*</span></b></label>
            {!! Form::date('end_date', $record->end_date ? \Carbon\Carbon::parse($record->end_date)->format('Y-m-d') : date('Y-m-d', strtotime('+1 month')), [
                'class' => 'form-control input-lg',
                'required' => 'required'
            ]) !!}
            @error('end_date')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="shop_type"><b>جملة أو تجزئة <span class="text-danger">*</span></b></label>
            {!! Form::select('shop_type', [
                'تجزئة' => 'تجزئة',
                'جملة' => 'جملة'
            ], null, [
                'class' => 'form-control input-lg'
            ]) !!}
            @error('shop_type')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="sort_order"><b>ترتيب الظهور في التطبيق</b></label>
            {!! Form::number('sort_order', $record->sort_order ?? 0, [
                'class' => 'form-control input-lg',
                'placeholder' => '0',
                'min' => '0'
            ]) !!}
            <small class="form-text text-muted">ترتيب تصاعدي (الأصغر يظهر أولاً)</small>
            @error('sort_order')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="active"><b>حالة الاشتراك <span class="text-danger">*</span></b></label>
            {!! Form::select('active', [
                '1' => 'مفعل',
                '0' => 'غير مفعل'
            ], null, [
                'class' => 'form-control input-lg'
            ]) !!}
            @error('active')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="image"><b>صورة المحل</b></label>
            <input type="file" name="image" class="form-control" {{ empty($record->id) ? 'required' : '' }}>
            @if(!empty($record->image))
                <div class="mt-2">
                    <a href="{{ asset('storage/' . $record->image) }}" data-lightbox="image">
                        <img src="{{ asset('storage/' . $record->image) }}" alt="صورة المحل" class="img-thumbnail" style="height: 90px;">
                    </a>
                </div>
            @endif
            @error('image')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

