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
                        <h4 class="title">View Profile</h4>
                    </div>
                    <div class="content">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <p class="profile-detail">
                                            {{ $user->username }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <p class="profile-detail">
                                            {{ $user->name }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <p class="profile-detail">
                                            {{ $user->phone }}
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email address</label>
                                        <p class="profile-detail">
                                            {{ $user->email }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <p class="profile-detail">
                                            {{ $user->location }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <h4>Order Detail ({{ $orders->count() }})</h4>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>
                                                #
                                            </th>
                                            <th>
                                                Date
                                            </th>
                                            <th>
                                                Location
                                            </th>
                                            <th>
                                                Status
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($orders->isEmpty())
                                            <tr>
                                                <td colspan="4">
                                                    No order yet.
                                                </td>
                                            </tr>
                                        @else
                                            @foreach($orders as $order)
                                            <tr>
                                                <td>
                                                    <a href="{{ url('home/order/orderdetail/'. $order->id) }}">#{{ $order->id }}</a>
                                                </td>
                                                <td>
                                                    {{ $order->created_at->format('d M Y') }}
                                                </td>
                                                <td>
                                                    {{ str_limit($order->location, 40) }}
                                                </td>
                                                <td class="text-center">
                                                    @if($order->status == 0)
                                                        <i class="fa fa-circle text-default"></i>
                                                    @elseif($order->status == 1)
                                                        <i class="fa fa-circle text-info"></i>
                                                    @elseif($order->status == 2)
                                                        <i class="fa fa-circle text-success"></i>
                                                    @elseif($order->status == 3)
                                                        <i class="fa fa-circle text-warning"></i>
                                                    @elseif($order->status == 4)
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
                                {!! $orders->render() !!}
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-user">
                    <div class="content">
                        <div class="author">
                             <a href="#">
                                 <img id="profile-image" class="avatar border-gray" src="{{ ($user->avatar != null ? $user->avatar : url('lib/img/default_avatar.png')) }}" alt="Avatar Image"/>
                                 <img class="avatar border-gray loading-image" src="http://media.giphy.com/media/JBeu9q9LC1Kve/giphy.gif" style="display: none">
                                  <h4 class="title">{{ $user->name }}<br />
                                     <small>{{ $user->username }}</small>
                                  </h4>
                            </a>
                        </div>
                        <p class="description text-center">
                            {{ $user->location }}
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
<script type="text/javascript">
  $(document).ready(function () {
      $(":input").inputmask();

      $("#profile-image").click(function() {
          $("#avatar_field").click();
      });

      // ajax to upload avatar
      $('#avatar_field').change(function() {
          var status = $('#status');

          $('#upload_avatar').ajaxForm({
              beforeSend: function() {
                  status.empty();
              },
              uploadProgress: function(event, position, total, percentComplete) {
                  $('#profile-image').css('display','none');
                  $('.loading-image').css('display','inherit');
                  //$('.placeholder-image').css('opacity','0.5');
              },
              complete: function(xhr) {
                  var x = xhr.responseText.replace(/\"|\\/g, "");
                  console.log(x);
                  $('#profile-image').css('display','inherit');
                  $('.loading-image').css('display','none');
                  $("#profile-image").attr("src", x);
                  //$('.placeholder-image').css('opacity','1');
              }
          });

          $('#upload_avatar').submit();
      });
  });
</script>
@stop
