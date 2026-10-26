<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="start_date"> <b>الملاحظات </b> </label>
            {!! Form::textarea('notes',null,[
                'class' => 'form-control input-lg',
                'placeholder' => 'الملاحظات',
                'rows' => 5,
            ]) !!}
            @error('notes')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="start_date"> <b> صورة التعليمات</b> </label>
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

{{--    <div class="col-md-6">--}}
{{--        <div class="form-group">--}}
{{--            <label for="end_date"> <b>حالة التفعيل</b> </label>--}}
{{--            {!! Form::select('active',[--}}
{{--                   '1' => 'مفعل',--}}
{{--                   '0' => 'غير مفعل',--}}
{{--               ],null,[--}}
{{--                   'class' =>'form-control input-lg'--}}
{{--               ]) !!}--}}
{{--            @error('active')--}}
{{--            <span class="text-danger">{{ $message }}</span>--}}
{{--            @enderror--}}
{{--        </div>--}}
    </div>
    <div class="col-md-6">

        <div class="form-group">
            <label for="end_date"> <b>الترتيب</b> </label>
            {!! Form::number('order',null,[
                   'class' =>'form-control input-lg'
               ]) !!}
            @error('order')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
