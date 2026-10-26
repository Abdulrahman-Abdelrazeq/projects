<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="start_date"> <b>أسم المحل </b> </label>
            {!! Form::text('shop_name',null,[
                'class' => 'form-control input-lg',
                'placeholder' => 'أسم المحل'
            ]) !!}
            @error('shop_name')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="end_date"> <b>عنوان المحل </b> </label>
            {!! Form::text('address',null,[
                'class' => 'form-control input-lg',
                'placeholder' => ' عنوان المحل'
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
            <label for="start_date"> <b>رابط api </b> </label>
            {!! Form::text('link_api',null,[
                'class' => 'form-control input-lg',
                'placeholder' => 'رابط api'
            ]) !!}
            @error('link_api')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="end_date"> <b>كود الدعم الفني </b> </label>
            {!! Form::text('shop_code',null,[
                'class' => 'form-control input-lg',
                'placeholder' => 'كود الدعم الفني'
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
            <label for="start_date"> <b> صورة المحل</b> </label>
            <br>
            <input type="file" name="image" class="form-control">
            @if($record->image)
                <a href="{{  asset('storage/'.$record->image) }}" data-lightbox="image"
                   data-title="{{ $record->title }}">
                    <br>
                    <img src="{{ asset('storage/' .$record->image) }}" alt="image"
                         class="img-thumbnail" style="height: 70px;"></a>
            @endif

            @error('image')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="end_date"> <b>حالة التفعيل</b> </label>
            {!! Form::select('active',[
                   '1' => 'مفعل',
                   '0' => 'غير مفعل',
               ],null,[
                   'class' =>'form-control input-lg'
               ]) !!}
            @error('active')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
