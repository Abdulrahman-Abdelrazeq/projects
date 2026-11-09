<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="title"><b>عنوان الإعلان <span class="text-danger">*</span></b></label>
            {!! Form::text('title', null, [
                'class' => 'form-control input-lg',
                'placeholder' => 'أدخل عنوان الإعلان',
                'required' => 'required'
            ]) !!}
            @error('title')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="link"><b>رابط الإعلان (اختياري)</b></label>
            {!! Form::text('link', null, [
                'class' => 'form-control input-lg',
                'placeholder' => 'https://example.com'
            ]) !!}
            @error('link')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="order"><b>ترتيب الظهور</b></label>
            {!! Form::number('order', $record->order ?? 0, [
                'class' => 'form-control input-lg',
                'placeholder' => '0',
                'min' => '0'
            ]) !!}
            <small class="form-text text-muted">ترتيب تصاعدي (الأصغر يظهر أولاً)</small>
            @error('order')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="active"><b>حالة التفعيل <span class="text-danger">*</span></b></label>
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
            <label for="image"><b>صورة الإعلان <span class="text-danger">{{ empty($record->id) ? '*' : '' }}</span></b></label>
            <input type="file" name="image" class="form-control" {{ empty($record->id) ? 'required' : '' }}>
            @if(!empty($record->image))
                <div class="mt-2">
                    <a href="{{ asset('storage/' . $record->image) }}" data-lightbox="image">
                        <img src="{{ asset('storage/' . $record->image) }}" alt="صورة الإعلان" class="img-thumbnail" style="height: 100px;">
                    </a>
                </div>
            @endif
            @error('image')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

