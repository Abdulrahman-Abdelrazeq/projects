@if(session()->has('success'))
    <div class="row">
        <div class="col-xs-12 col-sm-12" id="success">
            <ul class='h4 alert alert-success text-center list-unstyled'>
                {!! session()->get('success') !!}
            </ul>
        </div>
    </div>
@endif
@if(session()->has('error'))
    <div class="row">
        <div class="col-xs-12 col-sm-12" id="success">
            <ul class="alert alert-danger text-center list-unstyled">
                {!! session()->get('error') !!}
            </ul>
        </div>
    </div>
@endif


@if (count($errors))
    <div class="form-group">
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
@if(session()->has('error'))
    <div class="form-group">
        <div class="alert alert-danger">
            <ul>
                <li>{{ session()->get('error')}}</li>
            </ul>
        </div>
    </div>
@endif
