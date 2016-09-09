<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login To Red Tree Asia</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ url('lib/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('lib/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ url('lib/css/demo.css') }}">
    <link rel="stylesheet" href="{{ url('lib/css/light-bootstrap-dashboard.css') }}">
    <link rel="stylesheet" href="{{ url('lib/css/pe-icon-7-stroke.css') }}">

</head>
<body>

<nav class="navbar navbar-transparent navbar-absolute">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">Kolos</a>
        </div>
        <div class="collapse navbar-collapse">

            <ul class="nav navbar-nav navbar-right">
                <li>
                   <a href="{{ url('register/pro') }}">
                        Sign Up
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<div class="wrapper wrapper-full-page">
    <div class="full-page login-page" data-color="orange" data-image="{{ url('http://kolos.co.id/dist/img/bg-kolos.jpg') }}">

    <!--   you can change the color of the filter page using: data-color="blue | azure | green | orange | red | purple" -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                        <form role="form" method="POST" action="{{ url('/login') }}">
                        {!! csrf_field() !!}
                        <!--   if you want to have the card without animation please remove the ".card-hidden" class   -->
                            <div class="card">
                                <div class="header text-center" style="padding-bottom: 0">Login</div>
                                <div class="content">
                                    <div class="form-group">
                                        <label>Email address</label>
                                        <input type="email" class="form-control" name="email" placeholder="Enter email" value="{{ old('email') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" placeholder="Password" name="password">
                                    </div>
                                    <div class="form-group">
                                        <label class="checkbox">
                                            <input type="checkbox" data-toggle="checkbox" value="" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>
                                <div class="footer text-center">
                                    <button type="submit" class="btn btn-social btn-wd btn-fill btn-warning">
                                        <i class="fa fa-sign-in"></i> Sign in
                                    </button>
                                    <br>
                                    <a class="reset_pass" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

        <footer class="footer footer-transparent">
            <div class="container">
                <p class="copyright pull-right">
                    &copy; 2016 <a href="http://rahmankurnia.com">Kolos</a>. All right reserved.
                </p>
            </div>
        </footer>

    </div>

</div>

    <script src="{{ url('lib/js/jquery-1.10.2.js') }}"></script>
    <script src="{{ url('lib/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('lib/js/bootstrap-notify.js') }}"></script>
    <script src="{{ url('lib/js/sweetalert.js') }}"></script>
    <script src="{{ url('lib/js/bootstrap-select.js') }}"></script>
    <script src="{{ url('lib/js/bootstrap-checkbox-radio-switch.js') }}"></script>
    <script src="{{ url('lib/js/demo.js') }}"></script>
    <script src="{{ url('lib/js/light-bootstrap-dashboard.js') }}"></script>

</body>
</html>
