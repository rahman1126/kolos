@extends('layouts.app')
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="header">
            <h4 class="title">Merchants Location</h4>
        </div>
        <div class="content">
            <div id="map_canvas" style="height: 450px; width: 100%"></div>
        </div>
    </div>
</div>
@endsection
@section('footer')
<!-- <script type="text/javascript" src='http://maps.google.com/maps/api/js?libraries=places&key=AIzaSyB0BXhT7bYjEqTiyjVIKswpmdMVm9XbV2k'></script> -->
<script src="https://maps.googleapis.com/maps/api/js?v=3.11&sensor=false" type="text/javascript"></script>
<script type="text/javascript">
// check DOM Ready
var locations = [
        @foreach($merchants as $item)
            ['{{ $item->company }}', {{ $item->lat }}, {{ $item->lon }}, {{ $item->radius }}],
        @endforeach
    ];
    var map;
    var markers = [];

    function init(){
      map = new google.maps.Map(document.getElementById('map_canvas'), {
        zoom: 11,
        scrollwheel: false,
        center: new google.maps.LatLng(-6.24996058362775, 106.83873311351931),
        mapTypeId: google.maps.MapTypeId.ROADMAP
      });

      var num_markers = locations.length;
      for (var i = 0; i < num_markers; i++) {
        markers[i] = new google.maps.Marker({
          position: {lat:locations[i][1], lng:locations[i][2]},
          map: map,
          //icon: 'https://cdn2.iconfinder.com/data/icons/RocketTheme_eCommerce_Icon_Pack_1/32/shop.png',
          html: locations[i][0],
          id: i,
        });

        google.maps.event.addListener(markers[i], 'click', function(){
          var infowindow = new google.maps.InfoWindow({
            id: this.id,
            content:this.html,
            position:this.getPosition()
          });
          google.maps.event.addListenerOnce(infowindow, 'closeclick', function(){
            markers[this.id].setVisible(true);
          });
          this.setVisible(false);
          infowindow.open(map);
        });
      }

      // Add circle overlay and bind to marker
      for (var i = 0; i < num_markers; i++) {
          var circle = new google.maps.Circle({
            position: {lat:locations[i][1], lng:locations[i][2]},
            map: map,
            radius: locations[i][3],    // 10 miles in metres
            fillColor: '#ff700f',
            fillOpacity: 0.2,
            strokeColor: '#ff700f',
            strokeOpacity: 0.5,
            strokeWeight: 1,
          });
          circle.bindTo('center', markers[i], 'position');
        }

    }

    google.maps.event.addDomListener(window, 'load', init);
</script>
@stop
