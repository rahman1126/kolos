@extends('auth.pro')
@section('content')
<div id="step-1">
  <form class="form-horizontal form-label-left" id="form1" method="post" action="{{ url('register/pro/steploginprocess') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <br>

    <div class="form-group {{ ($errors->has('email') ? 'has-error' : '') }}">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-10">
        <input type="email" id="email" name="email" value="{{ old('email') }}" required="required" class="form-control col-md-7 col-xs-12">
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
      </div>
      <div class="col-md-3">
        <div class="help-tip">
          <p>This email will be used to authenticate your account when you login to kolos app. Make sure you use your right email, and dont forget.
          </p>
        </div>
      </div>
    </div>

    <div class="form-group {{ ($errors->has('password') ? 'has-error' : '') }}">
      <label for="password" class="control-label col-md-3 col-sm-3 col-xs-12">Password <span class="required">*</span></label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input id="password" class="form-control col-md-7 col-xs-12" type="password" name="password" value="{{ old('password') }}" required>
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
      </div>
    </div>

    <div class="form-group actionBar">
      <button class="btn btn-success" type="submit">Next Step</button>
    </div>

  </form>

</div>
@stop
