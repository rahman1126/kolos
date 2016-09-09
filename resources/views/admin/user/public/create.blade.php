@extends('layouts.app')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="header">
                        <h4 class="title">New Merchant Form</h4>
                    </div>
                    <div class="content">
                        <form action="{{ url('home/becomeprorequest') }}" method="post" enctype="multipart/form-data">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
                                        <label>Company *</label>
                                        <input type="text" name="company" class="form-control" placeholder="Company" value="{{ old('company') }}">
                                        @if ($errors->has('company'))
                                            <label class="error">{{ $errors->first('company') }}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                        <label>Address *</label>
                                        <input id="gaddress" name="address" class="form-control" placeholder="Home Address" value="{{ old('address') }}"></input>
                                        @if ($errors->has('address'))
                                            <label class="error">{{ $errors->first('address') }}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div id="location-map" style="width:100%; height: 300px;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group{{ $errors->has('lat') ? ' has-error' : '' }}">
                                        <label>Latitude</label>
                                        <input type="text" name="lat" id="glat" class="form-control" placeholder="Latitude" value="" readonly="readonly">
                                        @if ($errors->has('lat'))
                                            <label class="error">{{ $errors->first('lat') }}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group{{ $errors->has('lon') ? ' has-error' : '' }}">
                                        <label>Longitude</label>
                                        <input type="text" name="lon" id="glon" class="form-control" placeholder="Longitude" value="" readonly="readonly">
                                        @if ($errors->has('lon'))
                                            <label class="error">{{ $errors->first('lon') }}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group{{ $errors->has('radius') ? ' has-error' : '' }}">
                                        <label>Area Covered (Meter) *</label>
                                        <input type="number" name="radius" id="gradius" class="form-control" value="{{ old('radius') }}" placeholder="Radius">
                                        @if ($errors->has('radius'))
                                            <label class="error">{{ $errors->first('radius') }}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group{{ $errors->has('open_time') ? ' has-error' : '' }} col-md-6">
                                    <label>Open Time *</label>
                                    <div class="input-group timepicker">
                                        <input type="time" class="form-control" name="open_time" value="{{ old('open_time') }}"></input>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                    @if ($errors->has('open_time'))
                                        <label class="error">{{ $errors->first('open_time') }}</label>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('close_time') ? ' has-error' : '' }} col-md-6">
                                    <label>Close Time *</label>
                                    <div class="input-group timepicker">
                                        <input type="time" class="form-control" name="close_time" value="{{ old('close_time') }}"></input>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                    @if ($errors->has('close_time'))
                                        <label class="error">{{ $errors->first('close_time') }}</label>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
                                        <?php
                                            $locations = array(
                                                'Jakarta Pusat',
                                                'Jakarta Barat',
                                                'Jakarta Selatan',
                                                'Jakarta Utara',
                                                'Jakarta Timur'
                                            );
                                        ?>
                                        <label>Location *</label>
                                        <select name="location" class="selectpicker" required>
                                            <option value="">Choose One</option>
                                            @foreach($locations as $loc)
                                              <option value="{{ $loc }}" {{ ($loc == old('location') ? 'selected' : '' ) }}>{{ $loc }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('location'))
                                            <label class="error">{{ $errors->first('location') }}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                                        <label>Category *</label>
                                        <select name="category" class="selectpicker" required>
                                            <option value="">Choose One</option>
                                            @foreach($categories as $cat)
                                              <option value="{{ $cat->id }}" {{ ($cat->id == old('category') ? 'selected' : '') }}>{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('category'))
                                            <label class="error">{{ $errors->first('category') }}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" rows="5" class="form-control" placeholder="Here can be your description">{{ old('description') }}</textarea>
                                        @if ($errors->has('description'))
                                            <label class="error">{{ $errors->first('description') }}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <input type="file" id="logo_file" name="logo" style="display: none">
                            <input type="file" id="cover_file" name="cover" style="display: none">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-warning btn-fill pull-right">Done</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-user">
                    <div class="image merchant">
                        <img id="upload_cover" src="http://www.vdgh.ca/wp-content/uploads/2014/04/dummy-background-ajaxed-hybrid-cargo-collective-theme-wordpress711.jpg" alt="..."/>
                    </div>
                    <div class="content">
                        <div class="author merchant">
                             <a href="#">
                            <img id="upload_logo" class="avatar merchant" src="https://www.freelancermap.com/images/company_dummy.png" alt="Merchant Logo"/>

                              <h4 class="title"></h4>
                            </a>
                            <p>

                            </p>
                        </div>
                        <p class="description text-center" style="color: #888;">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
@section('footer')
<script type="text/javascript" src="{{ url('dist/js/input_mask/jquery.inputmask.js') }}"></script>
<script type="text/javascript" src="{{ url('dist/js/jquery.form.js') }}"></script>
<script type="text/javascript" src='http://maps.google.com/maps/api/js?libraries=places&key=AIzaSyB0BXhT7bYjEqTiyjVIKswpmdMVm9XbV2k'></script>
<script type="text/javascript" src="{{ url('lib/js/locationpicker.min.js') }}"></script>
<script type="text/javascript">

    $('.timepicker').clockpicker({
        autoclose: true
    });
    $(":input").inputmask(); // phone number mask

    // geo location maps
    $('#location-map').locationpicker(
        {
            // default location
            location:
            {
                latitude: '-6.251176399999999',
                longitude: '106.79995910000002'
            },
        	radius: {{ (old('radius') == null ? '100' : old('radius')) }},
            zoom: 17,
            scrollwheel: false,
            inputBinding:
            {
                latitudeInput: $('#glat'),
                longitudeInput: $('#glon'),
                radiusInput: $('#gradius'),
                locationNameInput: $('#gaddress'),
                radiusInput: $('#gradius'),
            },
            enableAutocomplete: true,

        }
    ); // pick location from google map


    // upload ========
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#upload_cover').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#cover_file").change(function(){
        readURL(this);
    });

    $("#upload_cover").click(function() {
      $("#cover_file").click();
    });

    function readURL2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#upload_logo').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#logo_file").change(function(){
        readURL2(this);
    });

    $("#upload_logo").click(function() {
        $("#logo_file").click();
    });

</script>
@stop
