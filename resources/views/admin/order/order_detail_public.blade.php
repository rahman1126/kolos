@extends('layouts.app')
@section('content')
<div class="col-md-12">
  <div class="card">

      <div class="header">
          <div class="pull-left">
              <h4 class="title">Order On {{ $orders->created_at->format('d F Y H:i T') }}</h4>
          </div>
          <div class="pull-right">

              @if ($orders->status == 0)
              <form action="{{ url('home/order/accept') }}" method="post" style="display: inline">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" name="id" value="{{ $orders->id }}">
                  <button type="submit" name="button" class="btn btn-success btn-sm">Accept</button>
              </form>
              <form action="{{ url('home/order/decline') }}" method="post" style="display: inline">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" name="id" value="{{ $orders->id }}">
                  <button type="submit" name="button" class="btn btn-danger btn-sm">Decline</button>
              </form>
              <span class="btn btn-sm btn-warning btn-fill">Waiting confirmation</span>

              @elseif($orders->status == 1)
                  <form action="{{ url('home/order/complete') }}" method="post" style="display: inline">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="id" value="{{ $orders->id }}">
                      <button type="submit" name="button" class="btn btn-success btn-sm">Set as Complete</button>
                  </form>
                  <span class="btn btn-sm btn-info btn-fill">On Progress</span>
              @elseif ($orders->status == 2)
                    <span class="btn btn-sm btn-success btn-fill">Completed</span>
              @elseif($orders->status == 3)
                    <span class="btn btn-sm btn-warning btn-fill">Canceled</span>
              @elseif($orders->status == 4)
                  <span class="btn btn-sm btn-danger btn-fill">Declined</span>
              @endif
          </div>
      </div>

      <br>

    <div class="content">
        <div class="content">
            <div class="row">
                <div class="col-md-4 text-center">
                    <a href="#">{{ $orders->user->name }}</a>
                    <br>{{ ($orders->user->location == '' ? $orders->location  : $orders->user->location) }}
                    <br>{{ ($orders->user->phone == '' ? '-' : $orders->user->phone) }}
                    <br>{{ $orders->user->email }}

                </div>
                <div class="col-md-4 text-center" style="border-left: 1px solid orange; border-right: 1px solid orange;">
                    <a href="#">{{ $orders->merchant->company }}</a>
                    <br>{{ $orders->merchant->location }}
                    <br>{{ $orders->user_merchant->phone }}
                    <br>{{ $orders->user_merchant->email }}
                </div>
                <div class="col-md-4 text-center">
                    <b>Order Detail</b>
                    <br>Booking Time: <?php echo $date = date('d F Y H:i T', strtotime($orders->booking_time)) ?>
                    <br>Location: {{ $orders->location }}
                    <br>Note: <i>{{ $orders->note }}</i>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Route</label>
                <div id="map" style="width: 100%; height: 300px;"></div>
                <small><span id="distance">0</span> meter, atau sekitar <span id="arrival_time">0 menit</span> perjalanan</small>
            </div>
        </div>

        <section class="content">

        <!-- Table row -->
        <div class="row">
          <div class="col-xs-12 table">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Product / Service</th>
                  <th style="width: 59%">Description</th>
                  <th>
                      Value
                  </th>
                  <th>

                  </th>
                  <th>
                      QTY
                  </th>
                  <th>Subtotal</th>
                </tr>
              </thead>
              <tbody>
              @foreach($orders->orderservice as $data)
                @if($data->service != null)
                <tr>
                  <td>{{ $data->service->id }}</td>
                  <td>{{ $data->service->name }}</td>
                  <td>{{ $data->service->description }}</td>
                  <td>
                      {{ number_format( $data->service->price , 0 , '' , '.' ) }}
                  </td>
                  <td>
                      x
                  </td>
                  <td>
                      {{ $data->quantity }}
                  </td>
                  <td>{{ number_format( $data->service->price * $data->quantity , 0 , '' , '.' ) }}</td>
                </tr>
                @else
                <tr>
                  <td>?</td>
                  <td>?</td>
                  <td><span class="test-danger">Service has been removed.</span></td>
                  <td>
                      ?
                  </td>
                  <td>
                      ?
                  </td>
                  <td>
                      x
                  </td>
                  <td>?</td>
                </tr>
                @endif
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <hr>

        <div class="row">
          <!-- accepted payments column -->
          <div class="col-xs-6">
            <div>
                <p class="lead">Review &amp; Feedback</p>
                <!-- end of user messages -->
                <ul class="review-list">
                    @if($review != null)
                    <li>
                        <div class="review-box">
                            <img src="{{ $review->customer->avatar }}" class="reviewer-img" alt="Avatar">
                                <a href="#">{{ $review->customer->name }}</a> rate it
                                    <?php
                                        $int = $review->rating > 0 ? floor($review->rating) : ceil($review->rating);
                                        $dec = 5 - $review->rating;
                                    ?>
                                    {!! str_repeat('<i class="fa fa-star"></i>', $int) !!}{!! str_repeat('<i class="fa fa-star-o"></i>', ceil($dec)) !!}
                            <p>
                                {{ $review->comment }}
                            </p>
                            <p class="text-right">{{ $review->created_at->format('d F Y H:i T') }}</p>
                        </div>
                    </li>
                    <hr>
                    @else
                    <li>
                        <p>No review yet.</p>
                    </li>
                    @endif

                    @if($feedback != null)
                    <li>
                        <div class="review-box">
                            <img src="{{ $feedback->merchant_detail->logo }}" class="reviewer-img" alt="Avatar">
                            <a href="#">{{ $feedback->merchant_detail->company }}</a>
                            <?php
                                $rating = $feedback->merchant_detail->rating;
                                $int = $rating > 0 ? floor($rating) : ceil($rating);
                                $dec = 5 - $rating;
                            ?>
                            {!! str_repeat('<i class="fa fa-star"></i>', $int) !!}{!! str_repeat('<i class="fa fa-star-o"></i>', ceil($dec)) !!}
                            <p>
                                {{ $feedback->comment }}
                            </p>
                            <p class="text-right">
                                {{ $feedback->created_at->format('d F Y H:i T') }}
                            </p>
                        </div>
                    </li>
                    @endif

                </ul>
                <!-- end of user messages -->


            </div>
          </div>


          <!-- /.col -->
          <div class="col-xs-6">
            <p class="lead">Amount Information</p>
            <div class="table-responsive">
              <table class="table">
                <tbody>
                  <tr>
                    <th style="width:50%">Subtotal:</th>
                    <?php $total = 0 ?>
                    @foreach($orders->orderservice as $data)
                        @if ($data->service != null)
                            <?php $total += $data->service->price * $data->quantity; ?>
                        @endif
                    @endforeach

                    <td>{{  number_format( $total , 0 , '' , '.' ) }}</td>
                  </tr>
                  <tr>
                    <th>Tax (0%)</th>
                    <td>0</td>
                  </tr>
                  <tr>
                    <th>Total:</th>
                    <td>{{  number_format( $total , 0 , '' , '.' ) }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.col -->


        </div>
        <!-- /.row -->
      </section>


    </div>
  </div>
</div>
@endsection
@section('footer')
<script type="text/javascript" src='http://maps.google.com/maps/api/js?libraries=geometry&key=AIzaSyB0BXhT7bYjEqTiyjVIKswpmdMVm9XbV2k'></script>
<script type="text/javascript">

    function initMap() {
      var pointA = new google.maps.LatLng({{ $orders->merchant->lat }}, {{ $orders->merchant->lon }}),
        pointB = new google.maps.LatLng({{ $orders->lat }}, {{ $orders->lon }}),
        map = new google.maps.Map(document.getElementById('map')),
        // Instantiate a directions service.
        directionsService = new google.maps.DirectionsService,
        directionsDisplay = new google.maps.DirectionsRenderer({
          map: map,
        });

        // add options
        map.setOptions(
        {
            scrollwheel: false,
            center: pointA,
            zoom: 1
        });

        //console.log(google.maps.geometry.spherical.computeDistanceBetween (pointA, pointB));
        $('#distance').html(Math.ceil(google.maps.geometry.spherical.computeDistanceBetween (pointA, pointB)));
      // get route from A to B
      calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB);

    }

    function calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB) {
      directionsService.route({
        origin: pointA,
        destination: pointB,
        travelMode: google.maps.TravelMode.DRIVING,
      }, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
          directionsDisplay.setDirections(response);
          var point = response.routes[ 0 ].legs[ 0 ];
          //console.log(point.duration.text);
          $('#arrival_time').html(point.duration.text);
        } else {
          window.alert('Directions request failed due to ' + status);
        }
      });
    }

    initMap();
</script>
@stop
