@extends('layouts.app')
@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Edit Profile</h4>
                    </div>
                    <div class="content">
                        <form action="{{ url('home/user/update') }}" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                        <label>Username <star>*</star></label>
                                        <input type="text" name="username" class="form-control" placeholder="Username" value="{{ $user->username }}">
                                        @if ($errors->has('username'))
                                            <label class="error">{{ $errors->first('username') }}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label>Full Name <star>*</star></label>
                                        <input type="text" name="name" class="form-control" placeholder="Full Name" value="{{ $user->name }}">
                                        @if ($errors->has('name'))
                                            <label class="error">{{ $errors->first('name') }}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                        <label>Phone Number <star>*</star></label>
                                        <input type="text" name="phone" class="form-control" placeholder="Phone Number" value="{{ $user->phone }}" data-inputmask="'mask' : '+62 999-9999-9999'" maxlength="18">
                                        @if ($errors->has('phone'))
                                            <label class="error">{{ $errors->first('phone') }}</label>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="exampleInputEmail1">Email address <star>*</star></label>
                                        <input type="email" name="email" class="form-control" placeholder="Email" value="{{ $user->email }}">
                                        @if ($errors->has('email'))
                                            <label class="error">{{ $errors->first('email') }}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
                                        <label>Address <star>*</star></label>
                                        <textarea name="location" rows="5" class="form-control">{{ $user->location }}</textarea>
                                        @if ($errors->has('location'))
                                            <label class="error">{{ $errors->first('location') }}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label for="password">New Password</label>
                                        <input type="password" name="password" class="form-control">
                                        @if ($errors->has('password'))
                                            <label class="error">{{ $errors->first('password') }}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password_confirmation">Password Again</label>
                                        <input type="password" name="password_confirmation" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <button type="submit" class="btn btn-warning btn-fill pull-right">Update Profile</button>
                            <div class="clearfix"></div>
                        </form>
                        <form id="upload_avatar" action="{{ url('home/user/uploadimageuser') }}" method="post" enctype="multipart/form-data" style="display: none">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                            <input id="avatar_field" type="file" class="form-control" name="avatar" accept="image/jpeg,image/png">
                            <input type="hidden" name="id" value="{{ $user->id }}"></input>
                            <input type="hidden" name="name" value="{{ $user->name }}"></input>
                        </form>
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
