@extends('auth.pro')
@section('content')
<div id="step-4">
  <form class="form-horizontal form-label-left" method="post" action="{{ url('register/pro/finish') }}">
   
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
   
    <div class="form-group {{ ($errors->has('service_name') ? 'has-error' : '') }} {{ ($errors->has('service_price') ? 'has-error' : '') }}">
      <label for="service_name" class="control-label col-md-3 col-sm-3 col-xs-12">Service <span class="required">*</span></label>
      <div class="col-md-5 col-sm-5 col-xs-12">
        <input id="service_name" class="form-control col-md-5 col-xs-12" type="text" name="service_name[]" placeholder="Service Name" required>
      </div>
    
      <div class="col-md-3 col-sm-3 col-xs-12">
        <input class="form-control" type="number" name="service_price[]" placeholder="Price" required>
      </div>
      
      <div class="col-md-8 col-md-offset-3">
        <input class="form-control" type="text" name="service_desc[]" placeholder="Description" required>
        <hr>
      </div>
      
      @if ($errors->has('service_price'))
            <span class="help-block">
                <strong>{{ $errors->first('service_price') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group">
      <label for="service_name" class="control-label col-md-3 col-sm-3 col-xs-12">Service</label>
      <div class="col-md-5 col-sm-5 col-xs-12">
        <input id="service_name" class="form-control col-md-5 col-xs-12" type="text" name="service_name[]" placeholder="Service Name">
      </div>
    
      <div class="col-md-3 col-sm-3 col-xs-12">
        <input class="form-control" type="number" name="service_price[]" placeholder="Price">
      </div>
      
      <div class="col-md-8 col-md-offset-3">
        <input class="form-control" type="text" name="service_desc[]" placeholder="Description">
        <hr>
      </div>
    </div>

    <div class="form-group">
      <label for="service_name" class="control-label col-md-3 col-sm-3 col-xs-12">Service</label>
      <div class="col-md-5 col-sm-5 col-xs-12">
        <input id="service_name" class="form-control col-md-5 col-xs-12" type="text" name="service_name[]" placeholder="Service Name">
      </div>
    
      <div class="col-md-3 col-sm-3 col-xs-12">
        <input class="form-control" type="number" name="service_price[]" placeholder="Price">
      </div>
      
      <div class="col-md-8 col-md-offset-3">
        <input class="form-control" type="text" name="service_desc[]" placeholder="Description">
        <hr>
      </div>
    </div>

    <div class="form-group">
      <label for="service_name" class="control-label col-md-3 col-sm-3 col-xs-12">Service</label>
      <div class="col-md-5 col-sm-5 col-xs-12">
        <input id="service_name" class="form-control col-md-5 col-xs-12" type="text" name="service_name[]" placeholder="Service Name">
      </div>
    
      <div class="col-md-3 col-sm-3 col-xs-12">
        <input class="form-control" type="number" name="service_price[]" placeholder="Price">
      </div>
      
      <div class="col-md-8 col-md-offset-3">
        <input class="form-control" type="text" name="service_desc[]" placeholder="Description">
        <hr>
      </div>
    </div>
    
    <div class="input_fields_wrap">
    </div>
    
    <div class="form-group">
       <button class="add_field_button btn btn-dark pull-right" type="button">Add more service</button>
    </div>
    
    <div class="form-group actionBar">
      <button class="btn btn-success" type="submit">Complete Step</button>
    </div>
    
  </form>
</div>
</div>
@stop