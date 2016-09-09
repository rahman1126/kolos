@extends('auth.register')
@section('content')

<div class="col-md-12">
  <form class="form-horizontal form-label-left" id="form2" method="post" enctype="multipart/form-data" action="{{ url('register/pro/nexttwo') }}">

    <div class="card card-plain">
    <div class="content">

    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="form-group {{ ($errors->has('business_name') ? 'has-error' : '') }}">
      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="business-name">Company <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input type="text" id="business-name" name="business_name" value="{{ old('business_name') }}" required="required" class="form-control col-md-7 col-xs-12">
        @if ($errors->has('business_name'))
            <span class="help-block">
                <strong>{{ $errors->first('business_name') }}</strong>
            </span>
        @endif
      </div>
      <div class="col-md-3">
        <div class="help-tip">
          <p>This is the inline help tip! You can explain to your users what this section of your web app is about.</p>
        </div>
      </div>

    </div>

    <div class="form-group {{ ($errors->has('category') ? 'has-error' : '') }}">
      <label for="city" class="control-label col-md-3 col-sm-3 col-xs-12">Business Category</label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <select name="category" class="form-control select2_group">
          <option value="">{{ trans('welcome.ChooseCategory') }}</option>
          @foreach($categories as $cat)
            <option>{{ $cat->name }}</option>
          @endforeach
        </select>
        @if ($errors->has('category'))
            <span class="help-block">
                <strong>{{ $errors->first('category') }}</strong>
            </span>
        @endif
      </div>
    </div>

    <div class="form-group {{ ($errors->has('address') ? 'has-error' : '') }}">
      <label for="address" class="control-label col-md-3 col-sm-3 col-xs-12">Address <span class="required">*</span></label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <textarea class="form-control" rows="3" name="address" required>{{ old('address') }}</textarea>
        @if ($errors->has('address'))
            <span class="help-block">
                <strong>{{ $errors->first('address') }}</strong>
            </span>
        @endif
      </div>
    </div>

    <br>

    <div class="form-group {{ ($errors->has('city') ? 'has-error' : '') }}">
      <label for="city" class="control-label col-md-3 col-sm-3 col-xs-12">City <span class="required">*</span></label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <select name="city" class="city form-control">
            <option value="">Select</option>
            <option value="1">Jakarta Selatan</option>
            <option value="3">Jakarta Utara</option>
            <option value="2">Jakarta Barat</option>
            <option value="4">Jakarta Timur</option>
            <option value="5">Jakarta Pusat</option>
        </select>
        @if ($errors->has('city'))
            <span class="help-block">
                <strong>{{ $errors->first('city') }}</strong>
            </span>
        @endif
      </div>
    </div>

    <div class="form-group {{ ($errors->has('district') ? 'has-error' : '') }}">
      <label for="district" class="control-label col-md-3 col-sm-3 col-xs-12">District</label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <select name="district" id="response" class="district form-control" disabled="disabled">
            <option value="">Select</option>
        </select>
        @if ($errors->has('district'))
            <span class="help-block">
                <strong>{{ $errors->first('district') }}</strong>
            </span>
        @endif
      </div>
    </div>


    <!-- <div class="form-group {{ ($errors->has('postcode') ? 'has-error' : '') }}">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">Postcode <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input id="postcode" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text" name="postcode" value="{{ old('postcode') }}">
        @if ($errors->has('postcode'))
            <span class="help-block">
                <strong>{{ $errors->first('postcode') }}</strong>
            </span>
        @endif
      </div>
    </div> -->

    <!-- <div class="form-group {{ ($errors->has('office_number') ? 'has-error' : '') }}">
      <label class="control-label col-md-3 col-sm-3">Office Telephone</label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input id="office_number" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text" name="office_number" value="{{ old('office_number') }}">
        @if ($errors->has('office_number'))
            <span class="help-block">
                <strong>{{ $errors->first('office_number') }}</strong>
            </span>
        @endif
      </div>
    </div> -->

    <!-- <div class="form-group {{ ($errors->has('employees') ? 'has-error' : '') }}">
      <label class="control-label col-md-3 col-sm-3">Number of Employees</label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input id="employees" class="date-picker form-control col-md-7 col-xs-12" required="required" type="number" name="employees" value="{{ old('employees') }}">
        @if ($errors->has('employees'))
            <span class="help-block">
                <strong>{{ $errors->first('employees') }}</strong>
            </span>
        @endif
      </div>
    </div> -->

    <div class="form-group {{ ($errors->has('area_covered') ? 'has-error' : '') }}">
      <label for="city" class="control-label col-md-3 col-sm-3 col-xs-12">Area Covered</label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <select name="area_covered" class="area-covered form-control">
            <option value="">Select</option>
            <option value="1-10">1 - 10 km</option>
            <option value="20">20 km</option>
            <option value="30">30 km</option>
            <option value="40">40 km</option>
            <option value="50">50 km</option>
        </select>
        @if ($errors->has('area_covered'))
            <span class="help-block">
                <strong>{{ $errors->first('area_covered') }}</strong>
            </span>
        @endif
      </div>
    </div>

    <br>

    <div class="footer text-center">
        <button class="btn btn-warning btn-fill" type="submit">Next Step</button>
    </div>

    </div>
    </div>

  </form>
</div>
@stop
@section('footer')
<script type="text/javascript">
$("select.city").change(function(){
    var selectedCountry = $(".city option:selected").val();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: "POST",
        url: '{{ url('register/pro/district') }}',
        data: {
            city : selectedCountry,
            _token: CSRF_TOKEN
        }
    }).done(function(data){
        //console.log(data);
        $("#response").html(data);
        $('#response').prop('disabled', false);
    });
});
</script>
@stop
