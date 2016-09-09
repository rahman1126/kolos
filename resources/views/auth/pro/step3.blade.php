@extends('auth.register')
@section('content')
<div id="step-3">
	<form class="form-horizontal form-label-left" method="post" action="{{ url('register/pro/nextthree') }}" enctype="multipart/form-data">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

	  <div class="card card-plain">
      <div class="content">

      <div class="form-group {{ ($errors->has('open_time') ? 'has-error' : '') }}">
          <label for="open_time" class="control-label col-md-3 col-sm-3 col-xs-12">Opening Time</label>
          <div class="col-md-6 col-sm-6 col-xs-12 clockpicker">
              <input type="text" name="open_time" class="form-control col-md-7 col-xs-12" value="{{ old('open_time') }}">
              <span class="fa fa-clock-o form-control-feedback right" aria-hidden="true"></span>
              @if ($errors->has('open_time'))
                    <span class="help-block">
                        <strong>{{ $errors->first('open_time') }}</strong>
                    </span>
                @endif
          </div>
          <div class="col-md-3">
            <div class="help-tip">
              <p>Select your opening time.</p>
            </div>
          </div>
      </div>

      <div class="form-group {{ ($errors->has('close_time') ? 'has-error' : '') }}">
          <label for="close_time" class="control-label col-md-3 col-sm-3 col-xs-12">Closing Time</label>
          <div class="col-md-6 col-sm-6 col-xs-12 clockpicker">
              <input type="text" name="close_time" class="form-control col-md-7 col-xs-12" value="{{ old('close_time') }}">
              <span class="fa fa-clock-o form-control-feedback right" aria-hidden="true"></span>
              @if ($errors->has('close_time'))
                <span class="help-block">
                    <strong>{{ $errors->first('close_time') }}</strong>
                </span>
            @endif
          </div>
      </div>

	  <div class="form-group {{ ($errors->has('description') ? 'has-error' : '') }}">
	    <label for="address" class="control-label col-md-3 col-sm-3 col-xs-12">Description <span class="required">*</span></label>
	    <div class="col-md-6 col-sm-6 col-xs-12">
	      <textarea class="form-control col-md-7 col-xs-12" rows="5" name="description" required>{{ old('description') }}</textarea>
	      @if ($errors->has('description'))
                <span class="help-block">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
            @endif
	    </div>
	    <div class="col-md-3">
            <div class="help-tip">
              <p>Tell us about your company.</p>
            </div>
          </div>
      </div>

	  <!-- <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Logo</label>
          <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="upload-box-logo" style="background-color: #fff; border:1px solid #ccc; width: 200px; height: 200px; cursor: pointer; overflow: hidden">
                  <img class="img-responsive the-logo" src="http://dummyimage.com/300x300/fafafa/4d4d4d.jpg&text=300+x+300" alt="">
              </div>
              <input id="logo" type="file" name="logo" style="display: none">
              <p class="help-block">Maximum file size is 150kb, and resolution 300 x 300 pixels is recomended. Please keep the aspect ratio 1:1 to make your logo looks great and attracting.</p>
          </div>
          <div class="col-md-3">
            <div class="help-tip">
              <p>Maximum file size is 150kb, and resolution 300 x 300 pixels is recomended. Please keep the aspect ratio 1:1 to make your logo looks great and attracting.</p>
            </div>
          </div>
      </div>

      <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Cover</label>
          <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="upload-box-cover" style="background-color: #fff; border:1px solid #ccc; width: 100%; height: 200px; cursor: pointer; overflow: hidden">
                  <img class="img-responsive the-cover" src="http://dummyimage.com/1024x500/fafafa/4d4d4d.jpg&text=1024+x+500" alt="">
              </div>
              <input id="cover" type="file" name="cover" style="display: none">
              <p class="help-block">Maximum file size is 500kb, and resolution 1024 x 500 pixels is recomended.</p>
          </div>
          <div class="col-md-3">
            <div class="help-tip">
              <p>Maximum file size is 500kb, and resolution 1024 x 500 pixels is recomended.</p>
            </div>
          </div>
      </div> -->

	  <div class="form-group {{ ($errors->has('website') ? 'has-error' : '') }}">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Website</label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input id="website" class="form-control col-md-7 col-xs-12" type="text" name="website" value="{{ old('website') }}">
            @if ($errors->has('website'))
                <span class="help-block">
                    <strong>{{ $errors->first('website') }}</strong>
                </span>
            @endif
          </div>
        </div>

        <br>

		<div class="footer text-center">
	        <button class="btn btn-warning btn-fill" type="submit">Next Step</button>
	    </div>

	</div></div>

	</form>
</div>
@stop
