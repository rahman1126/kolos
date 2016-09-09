@extends('layouts.app')
@section('content')
<style media="screen">
    p.profile-detail{
        border: 1px solid #efefef;
        border-radius: 4px;
        padding: 7px 10px;
        color: grey;
    }
</style>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="header">
                        <h4 class="title">View Company</h4>
                    </div>
                    <div class="content">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Company</label>
                                        <p class="profile-detail">
                                            {{ $user->merchant->company }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <p class="profile-detail">
                                            {{ $user->merchant->location_detail }}
                                        </p>
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
                                    <div class="form-group">
                                        <label>Latitude</label>
                                        <input type="text" name="lat" id="glat" class="form-control" placeholder="Latitude" value="{{ $user->merchant->lat }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Longitude</label>
                                        <input type="text" name="lon" id="glon" class="form-control" placeholder="Longitude" value="{{ $user->merchant->lat }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Area Covered (Meter)</label>
                                        <p class="profile-detail">
                                            {{ $user->merchant->radius }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Open Time</label>
                                    <div class="form-group">
                                        <p class="profile-detail">
                                            {{ $user->merchant->open_time }}
                                        </p>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Close Time</label>
                                    <div class="form-group">
                                        <p class="profile-detail">
                                            {{ $user->merchant->close_time }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Location</label>
                                        <p class="profile-detail">
                                            {{ ($user->merchant->location != '' ? $user->merchant->location : '-') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                                        <label>Category</label>
                                        @foreach($categories as $cat)
                                            @if($cat->id == $user->merchant->category_id)
                                            <p class="profile-detail">
                                                {{ $cat->name }}
                                            </p>
                                            @endif
                                        @endforeach

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <p class="profile-detail">
                                            {{ ($user->merchant->description != '' ? $user->merchant->description : '-') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>


                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-user">
                    <div class="image merchant">
                        <img id="upload_cover" src="{{ ($user->merchant->cover == '' ? 'http://kolos.co.id/dist/img/bg-kolos.jpg' : $user->merchant->cover) }}" alt="..."/>
                    </div>
                    <div class="content">
                        <div class="author merchant">
                             <a href="#">
                            <img id="upload_logo" class="avatar merchant" src="{{ ($user->merchant->logo == '' ? 'http://kolos.co.id/dist/img/logo.png' : $user->merchant->logo) }}" alt="Merchant Logo"/>

                              <h4 class="title">{{ $user->merchant->company }}</h4>
                            </a>
                            <p>
                                <?php
                                    $rating = $user->merchant->rating;
                                    $int = $rating > 0 ? floor($rating) : ceil($rating);
                                    $dec = 5 - $rating;
                                ?>
                                {!! str_repeat('<i class="fa fa-star"></i>', $int) !!}{!! str_repeat('<i class="fa fa-star-o"></i>', ceil($dec)) !!} <br>
                                <small>Rating {{ $user->merchant->rating }} / 5.0 of {{ \App\Review::reviewnum($user->merchant->user_id) }} Reviews</small>
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
                                </tr>
                            </thead>
                            <tbody class="append-item">
                                @if($services->isEmpty())
                                    <tr>
                                        <td colspan="4">
                                            No service yet.
                                        </td>
                                    </tr>
                                @else
                                    @foreach($services as $service)
                                        <tr>
                                            <td>
                                                {{ $service->id }}
                                            </td>
                                            <td>{{ $service->name }}</td>
                                            <td>{{ str_limit($service->description, 50) }}</td>
                                            <td>{{ number_format($service->price, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                @endif
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
<script type="text/javascript" src='http://maps.google.com/maps/api/js?libraries=places&key=AIzaSyB0BXhT7bYjEqTiyjVIKswpmdMVm9XbV2k'></script>
<script type="text/javascript" src="{{ url('lib/js/locationpicker.min.js') }}"></script>
<script type="text/javascript">

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


</script>
@stop
