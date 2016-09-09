<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <title>Become a Merchant - Kolos</title>

  <!-- Bootstrap core CSS -->

  <link rel="icon" type="image/png" sizes="32x32" href="{{ url('dist/img/favicon.png') }}">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

  <!-- Styles -->
  <link href="{{ url('dist/css/bootstrap.min.css') }}" rel="stylesheet">
  {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
  <link rel="stylesheet" type="text/css" href="{{ url('dist/css/animate.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('dist/css/custom.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ url('dist/css/admin.css') }}">

  <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>

<body style="background:#F7F7F7;">

    <div id="wrapper" style="max-width: 900px;">
      <div id="login" class="animate form">
        <section class="login_content">
        <div class="col-md-6 col-md-offset-3">
          <h2 style="font-size: 28px">Validate your phone</h2>
          <p>We already sent you validation code to your phone number at the first step. Please insert your validation code below to activate your account.</p>
          <br>
        </div>
        <div class="clearfix"></div>
        <div class="center">
             
              <form action="{{ url('register/pro/validatephone') }}" method="post" class="form-horizontal form-label-left">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  
                  <div class="form-group {{ ($errors->has('code') ? 'has-error' : '') }}">
                  <div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-6 col-xs-offset-3">
                    <div class="input-group">
                        <input type="text" name="code" class="form-control" style="margin: 0">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-dark">Validate</button> 
                        </span>
                    </div>
                    @if ($errors->has('code'))
                        <span class="help-block">
                            <strong>{{ $errors->first('code') }}</strong>
                        </span>
                    @endif
                  </div>
                  </div>
              </form>
        </div>     
        </section>
        <!-- content -->
      </div>
    </div>



  <script src="{{ url('dist/js/jquery.min.js') }}"></script>
  <script src="{{ url('dist/js/bootstrap.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('dist/js/notify/pnotify.core.js') }}"></script>
    <script type="text/javascript" src="{{ url('dist/js/notify/pnotify.buttons.js') }}"></script>
  @include('layouts.flash')

</body>
</html>
