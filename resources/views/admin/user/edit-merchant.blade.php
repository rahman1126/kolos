@extends('layouts.app')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Company Profile [{{ $user->id }}]</h4>
                    </div>
                    <div class="content">
                        <form action="{{ url('home/user/updatemerchant') }}" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                        <label>Username</label>
                                        <input type="text" name="username" class="form-control" placeholder="Username" value="{{ $user->username }}">
                                        @if ($errors->has('username'))
                                            <label class="error">{{ $errors->first('username') }}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                        <label>Phone</label>
                                        <input type="text" name="phone" class="form-control" data-inputmask="'mask' : '+62 999-9999-9999'" placeholder="Phone" value="{{ $user->phone }}">
                                        @if ($errors->has('phone'))
                                            <label class="error">{{ $errors->first('phone') }}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="exampleInputEmail1">Email address</label>
                                        <input type="email" name="email" class="form-control" placeholder="Email" value="{{ $user->email }}">
                                        @if ($errors->has('email'))
                                            <label class="error">{{ $errors->first('email') }}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label>Full Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Full Name" value="{{ $user->name }}">
                                        @if ($errors->has('name'))
                                            <label class="error">{{ $errors->first('name') }}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
                                        <label>Company</label>
                                        <input type="text" name="company" class="form-control" placeholder="Company" value="{{ $user->merchant->company }}">
                                        @if ($errors->has('company'))
                                            <label class="error">{{ $errors->first('company') }}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                        <label>Address</label>
                                        <input id="gaddress" name="address" class="form-control" placeholder="Home Address" value="{{ $user->merchant->location_detail }}"></input>
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
                                        <input type="text" name="lat" id="glat" class="form-control" placeholder="Latitude" value="{{ $user->merchant->lat }}">
                                        @if ($errors->has('lat'))
                                            <label class="error">{{ $errors->first('lat') }}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group{{ $errors->has('lon') ? ' has-error' : '' }}">
                                        <label>Longitude</label>
                                        <input type="text" name="lon" id="glon" class="form-control" placeholder="Longitude" value="{{ $user->merchant->lat }}">
                                        @if ($errors->has('lon'))
                                            <label class="error">{{ $errors->first('lon') }}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group{{ $errors->has('radius') ? ' has-error' : '' }}">
                                        <label>Area Covered (Meter)</label>
                                        <input type="number" name="radius" id="gradius" class="form-control" value="{{ $user->merchant->radius }}" placeholder="Radius">
                                        @if ($errors->has('radius'))
                                            <label class="error">{{ $errors->first('radius') }}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group{{ $errors->has('open_time') ? ' has-error' : '' }} col-md-6">
                                    <label>Open Time</label>
                                    <div class="input-group timepicker">
                                        <input type="time" class="form-control" name="open_time" value="{{ $user->merchant->open_time }}"></input>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                    @if ($errors->has('open_time'))
                                        <label class="error">{{ $errors->first('open_time') }}</label>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('close_time') ? ' has-error' : '' }} col-md-6">
                                    <label>Close Time</label>
                                    <div class="input-group timepicker">
                                        <input type="time" class="form-control" name="close_time" value="{{ $user->merchant->close_time }}"></input>
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
                                        <label>Location</label>
                                        <select name="location" class="selectpicker" required>
                                            <option value="">Choose One</option>
                                            @foreach($locations as $loc)
                                              <option value="{{ $loc }}" {{ ($user->merchant->location == $loc ? 'selected' : '') }}>{{ $loc }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('location'))
                                            <label class="error">{{ $errors->first('location') }}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                                        <label>Category</label>
                                        <select name="category" class="selectpicker" required>
                                            <option value="">Choose One</option>
                                            @foreach($categories as $cat)
                                              <option value="{{ $cat->id }}" {{ ($cat->id == $user->merchant->category_id ? 'selected' : '') }}>{{ $cat->name }}</option>
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
                                        <textarea name="description" rows="5" class="form-control" placeholder="Here can be your description">{{ $user->merchant->description }}</textarea>
                                        @if ($errors->has('description'))
                                            <label class="error">{{ $errors->first('description') }}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $user->merchant->id }}"></input>
                            <input type="hidden" name="usr_id" value="{{ $user->id }}"></input>
                            <button type="submit" class="btn btn-warning btn-fill pull-right">Update</button>
                            <div class="clearfix"></div>
                        </form>
                        <!-- here are the logo input -->
                        <form id="upload_logo" action="{{ url('home/user/uploadlogomerchant') }}" method="post" enctype="multipart/form-data" style="display: none">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                            <input id="logo_image" type="file" class="form-control" name="logo" accept="image/jpeg,image/png">
                            <input type="hidden" name="id" value="{{ $user->merchant->id }}"></input>
                            <input type="hidden" name="name" value="{{ $user->name }}"></input>
                            <input type="submit" value="Submit"></input>
                        </form>
                        <!-- upload cover image -->
                        <form id="upload_cover" action="{{ url('home/user/uploadcovermerchant') }}" method="post" enctype="multipart/form-data" style="display: none">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                            <input id="cover_image" type="file" class="form-control" name="cover" accept="image/jpeg,image/png">
                            <input type="hidden" name="id" value="{{ $user->merchant->id }}"></input>
                            <input type="hidden" name="name" value="{{ $user->name }}"></input>
                            <input type="submit" value="Submit"></input>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-user">
                    <div class="image merchant">
                        <img id="uploaded_cover" src="{{ ($user->merchant->cover == '' ? 'http://kolos.co.id/dist/img/bg-kolos.jpg' : $user->merchant->cover) }}" alt="..."/>
                    </div>
                    <div class="content">
                        <div class="author merchant">
                             <a href="#">
                            <img id="uploaded_logo" class="avatar merchant" src="{{ ($user->merchant->logo == '' ? 'http://kolos.co.id/dist/img/logo.png' : $user->merchant->logo) }}" alt="Merchant Logo"/>

                              <h4 class="title">{{ $user->merchant->company }}</h4>
                            </a>
                            <p>
                                <?php
                                    $rating = $user->merchant->rating;
                                    $int = $rating > 0 ? floor($rating) : ceil($rating);
                                    $dec = 5 - $rating;
                                ?>
                                {!! str_repeat('<i class="fa fa-star"></i>', $int) !!}{!! str_repeat('<i class="fa fa-star-o"></i>', ceil($dec)) !!}
                            </p>
                        </div>
                        <p class="description text-center" style="color: #888;">
                            {{ str_limit($user->merchant->description, 100) }}
                        </p>
                    </div>
                    <hr>
                    <div class="text-center">
                        <button href="#" class="btn btn-simple"><i class="fa fa-facebook-square"></i></button>
                        <button href="#" class="btn btn-simple"><i class="fa fa-twitter"></i></button>
                        <button href="#" class="btn btn-simple"><i class="fa fa-google-plus-square"></i></button>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Last 5 Orders</h4>
                    </div>
                    <div class="content">
                        <table class="table table-responsive table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        On
                                    </th>
                                    <th>
                                        Value
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @if($orders->isEmpty())
                                <tr>
                                    <td>
                                        No order yet.
                                    </td>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                </tr>
                            @else
                                @foreach($orders as $order)
                                    <tr>
                                        <td>
                                            {{ $order->id }}
                                        </td>
                                        <td>
                                            {{ $order->updated_at->format('d F Y') }}
                                        </td>
                                        <td>
                                            @if(isset($order->orderservice[0]))
                                                @if($order->orderservice[0]->service != null)
                                                     <?php $total = 0 ?>
                                                     @foreach($order->orderservice as $data)
                                                        @if($data->service != null)
                                                            <?php $total += $data->service->price * $data->quantity ?>
                                                        @endif
                                                     @endforeach
                                                     {{  number_format( $total , 0 , '' , '.' ) }}
                                                 @else
                                                    <p class="text-danger">?</p>
                                                 @endif
                                             @endif
                                        </td>
                                        <td class="text-right">
                                            @if($order->status == 0)
                                                <i class="fa fa-circle text-default"></i>
                                            @elseif($order->status == 1)
                                                <i class="fa fa-circle text-info"></i>
                                            @elseif($order->status == 2)
                                                <i class="fa fa-circle text-success"></i>
                                            @elseif($order->status == 3)
                                                <i class="fa fa-circle text-danger"></i>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>

                    </div>

                    <div class="text-center">
                        <a href="{{ url('home/order') }}" class="btn btn-warning btn-sm">Full Orders <i class="fa fa-arrow-right"></i></a>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <button type="button" id="addNewBtn" class="btn btn-warning pull-right">Add New</button>
                        <h4 class="title">Services</h4>
                    </div>
                    <div class="content">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        ID
                                    </th>
                                    <th>Service Name</th>
                                    <th>Description</th>
                                    <th>Value</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                                <tr class="new_data" style="display: none">
                                    <form id="formService" action="" method="post">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <td>#</td>
                                        <td><input type="text" id="sName" class="form-control" value=""></td>
                                        <td><input type="text" id="sDescription" class="form-control" value=""></td>
                                        <td><input type="text" id="sValue" class="form-control" value=""></td>
                                        <td class="text-right" style="padding-right: 15px"><a href="#" rel="tooltip" id="addServiceBtn" class="btn btn-default btn-simple btn-xs" data-original-title="Save Data">
                                            <i class="fa fa-save"></i><i class="fa fa-spinner fa-spin fa-fw btnLoader" style="display: none"></i>
                                        </a></td>
                                    </form>
                                </tr>
                            </thead>
                            <tbody class="append-item">

                            @foreach($services as $service)
                                <tr>
                                    <td>
                                        {{ $service->id }}
                                    </td>
                                    <td>{{ $service->name }}</td>
                                    <td>{{ str_limit($service->description, 50) }}</td>
                                    <td>{{ number_format($service->price, 0, ',', '.') }}</td>
                                    <td class="text-right">
                                        <!-- <a href="{{ url('home/service/edit' .'/'. $service->id) }}" rel="tooltip" title="" class="btn btn-info btn-simple btn-xs" data-original-title="Edit Data">
                                            <i class="fa fa-edit"></i>
                                        </a> -->
                                        <button type="button" data-id="delete-{{ $service->id }}" onclick="alertme(this.getAttribute('data-id'));" rel="tooltip" title="" class="btn btn-danger btn-simple btn-xs" data-original-title="Remove">
                                            <i class="fa fa-times"></i>
                                        </button>
                                        <form id="delete-{{ $service->id }}" method="post" action="{{ url('home/service/delete') }}" style="display: none">
                                        	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        	<input type="hidden" name="id" value="{{ $service->id }}">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
                latitude: {{ ($user->merchant->lat == '' ? '-6.251176399999999' : $user->merchant->lat) }},
                longitude: {{ ($user->merchant->lon == '' ? '106.79995910000002' : $user->merchant->lon) }}
            },
        	radius: {{ $user->merchant->radius }},
            zoom: 16,
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


    // ajax to upload logo
    $('#logo_image').change(function() {
        var status = $('#status');

        $('#upload_logo').ajaxForm({
            beforeSend: function() {
                status.empty();
            },
            uploadProgress: function(event, position, total, percentComplete) {
                $('#uploaded_logo').attr('src', "{{ url('lib/img/preloader.gif') }}");
            },
            complete: function(xhr) {
                var x = xhr.responseText.replace(/\"|\\/g, "");
                var newSrc = $('#uploaded_logo').attr('src').replace( $('#uploaded_logo').attr('src'), x);
                $("#uploaded_logo").attr("src", x);
            }
        });

        $('#upload_logo').submit();
    });

    // ajax to upload logo
    $('#cover_image').change(function() {
        var status = $('#status');

        $('#upload_cover').ajaxForm({
            beforeSend: function() {
                status.empty();
            },
            uploadProgress: function(event, position, total, percentComplete) {
                $('#uploaded_cover').attr('src', "{{ url('lib/img/gallery-loading.gif') }}");
            },
            complete: function(xhr) {
                var x = xhr.responseText.replace(/\"|\\/g, "");
                //console.log(x);
                var newSrc = $('#uploaded_cover').attr('src').replace( $('#uploaded_cover').attr('src'), x);
                $('#uploaded_cover').attr('src', x);
            }
        });

        $('#upload_cover').submit();
    });

    // upload logo image
    $("#uploaded_logo").click(function() {
        $("#logo_image").click();
    });

    $("#uploaded_cover").click(function() {
        $("#cover_image").click();
    });

    // deleted service
    function alertme(data_id)
	{
		var formid = data_id;
		swal({
		  title: 'Are you sure?',
		  text: "You won't be able to revert this!",
		  //type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!',
		  closeOnConfirm: false
		}).then(function(isConfirm) {
		  if (isConfirm) {

		    swal(
		      'Congratulations!',
		      'Data has been deleted.',
		      'success'
		    );

		    setTimeout(function() {
		      $("#"+formid).submit();
            }, 200);

		  }
		})
	}


$(document).ready(function() {
    //##### send add record Ajax request to response.php #########
    $("#addServiceBtn").click(function (e) {
            e.preventDefault();

            // validation
            if ($("#sName").val() == '') {

                swal({
            		  title: 'Enter service name!',
            		  //text: "Please enter service name!",
            		  showCancelButton: false,
            		  confirmButtonColor: '#3085d6',
            		  cancelButtonColor: '#d33',
            		  confirmButtonText: 'Ok!',
            		  closeOnConfirm: true
                });
                return false;
            }

            if ($("#sValue").val() == '') {

                swal({
            		  title: 'Enter service value!',
            		  //text: "Please enter service name!",
            		  showCancelButton: false,
            		  confirmButtonColor: '#3085d6',
            		  cancelButtonColor: '#d33',
            		  confirmButtonText: 'Ok!',
            		  closeOnConfirm: true
                });
                return false;
            }


            $("#addServiceBtn").hide(); //hide submit button
            $(".btnLoader").show(); //show loading image
            var token = '{{ csrf_token() }}';
            var myData = {'_token': token ,'user_id': "{{ $user->id }}", 'name':$('#sName').val(), 'description':$('#sDescription').val(), 'price':$('#sValue').val()}; //build a post data structure
            jQuery.ajax({
                type: "POST", // HTTP method POST or GET
                url: "{{ url('home/service/ajaxstore') }}", //Where to make Ajax calls
                dataType:"json", // Data type, HTML, json etc.
                data:myData, //Form variables
                success:function(response){
                    console.log(response);
                    $("#result").append(response);
                    $("#sName").val(''); //empty text field on successful
                    $("#sDescription").val('');
                    $("#sValue").val('');
                    $("#addServiceBtn").show(); //show submit button
                    $(".btnLoader").hide(); //hide loading image
                    $("tbody.append-item").prepend("<tr><td>"+ response['id'] +"</td><td>"+ response['name'] +"</td><td>"+ response['description'] +"</td><td>"+ response['price'] +"</td><td></td></tr>");

                },
                error:function (xhr, ajaxOptions, thrownError){
                    $("#addServiceBtn").show(); //show submit button
                    $(".btnLoader").hide(); //hide loading image
                    alert(thrownError);
                }
            });
    });

    $("#addNewBtn").click(function(){
        $(".new_data").css('display', 'table-row');
    });

});

</script>
@stop
