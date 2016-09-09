<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <title>Register to Red Tree Asia</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('dist/img/favicon.png') }}">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ url('lib/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('dist/css/admin.css') }}">
    <link rel="stylesheet" href="{{ url('lib/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ url('lib/css/demo.css') }}">
    <link rel="stylesheet" href="{{ url('lib/css/light-bootstrap-dashboard.css') }}">
    <link rel="stylesheet" href="{{ url('lib/css/pe-icon-7-stroke.css') }}">
    <link rel="stylesheet" href="{{ url('lib/css/register.css') }}">

    <style media="screen">
    .wizard_horizontal ul.wizard_steps li a .step_no {
        width: 40px;
        height: 40px;
        line-height: 40px;
        border-radius: 100px;
        display: block;
        margin: 0 auto 5px;
        font-size: 16px;
        text-align: center;
        position: relative;
        z-index: 5;
    }
    .wizard_horizontal ul.wizard_steps {
        display: table;
        list-style: none;
        position: relative;
        width: 100%;
        margin: 0 0 40px;
    }
    .wizard_horizontal ul.wizard_steps li {
        display: table-cell;
        text-align: center;
    }
    .wizard_horizontal ul.wizard_steps li a, .wizard_horizontal ul.wizard_steps li:hover {
        display: block;
        position: relative;
        -moz-opacity: 1;
        filter: alpha(opacity= 100);
        opacity: 1;
        color: #666;
    }
    .wizard_horizontal ul.wizard_steps li a .step_no {
        width: 40px;
        height: 40px;
        line-height: 40px;
        border-radius: 100px;
        display: block;
        margin: 0 auto 5px;
        font-size: 16px;
        text-align: center;
        position: relative;
        z-index: 5;
    }
    .wizard_verticle ul.wizard_steps li a.selected:before, .step_no {
        background: #ca5b1f;
        color: #fff;
    }
    .wizard_horizontal ul.wizard_steps li a.selected:before, .step_no {
        background: #ce610b;
        color: #fff;
    }
    .wizard_horizontal ul.wizard_steps li a, .wizard_horizontal ul.wizard_steps li:hover {
        display: block;
        position: relative;
        -moz-opacity: 1;
        filter: alpha(opacity= 100);
        opacity: 1;
        color: #666;
    }
    .wizard_horizontal ul.wizard_steps li:first-child a:before {
        left: 50%;
    }
    .wizard_horizontal ul.wizard_steps li a.selected:before, .step_no {
        background: #ce610b;
        color: #fff;
    }
    .wizard_horizontal ul.wizard_steps li a:before {
        content: "";
        position: absolute;
        height: 4px;
        background: #e5864f;
        top: 20px;
        width: 100%;
        z-index: 4;
        left: 0;
    }
    .wizard_horizontal ul.wizard_steps li:last-child a:before {
        right: 50%;
        width: 50%;
        left: auto;
    }
    .wizard_horizontal ul li .step_descr{
        color: #eee;
    }
    .wizard_horizontal ul li .step_descr small{
        color: #ccc;
    }
    .card .category, .card .form-group label{ color: #fff!important; }
    .bootstrap-select{
        background: white;
        border-radius: 4px;
    }
    </style>

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
        </div>
        <div class="collapse navbar-collapse">

            <ul class="nav navbar-nav navbar-right">
                <li>
                   <a href="{{ url('login') }}">
                        Looking to login?
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="wrapper wrapper-full-page">
    <div class="full-page register-page" data-color="orange" data-image="http://kolos.co.id/dist/img/bg-kolos.jpg">

    <!--   you can change the color of the filter page using: data-color="blue | azure | green | orange | red | purple" -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="header-text">
                            <h2>KOLOS</h2>
                            <h4>A Profesional For Every Need.</h4>
                            <span>
                                <small>With Kolos App, Order Any Trusted Professional Services to your door in just a few minutes.</small>
                            </span>
                            <hr>
                        </div>
                    </div>

                    @yield('content')


                </div>
            </div>
        </div>

        <footer class="footer footer-transparent">
            <div class="container">
                <p class="copyright text-center">
                    &copy; 2016 <a href="http://rahmankurnia.com">Kolos</a>. All right reserved.
                </p>
            </div>
        </footer>

    </div>

</div>

<script src="{{ url('lib/js/jquery-1.10.2.js') }}"></script>
    <script src="{{ url('lib/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('lib/js/jquery-ui.min.js') }}"></script>
    <script src="{{ url('lib/js/bootstrap-notify.js') }}"></script>
    <script src="{{ url('lib/js/sweetalert.js') }}"></script>
    <script src="{{ url('lib/js/bootstrap-select.js') }}"></script>
    <script src="{{ url('lib/js/bootstrap-checkbox-radio-switch.js') }}"></script>
    <script src="{{ url('lib/js/demo.js') }}"></script>
    <script src="{{ url('lib/js/light-bootstrap-dashboard.js') }}"></script>
    <script src="{{ url('lib/js/bootstrap-datetimepicker.js') }}"></script>
    <script type="text/javascript">
    $(document).on('click touchstart', '.navbar-toggle', function() {
        //alert('ok');
    });
    </script>
    @yield('footer')
    @if (!$errors->isEmpty())
    @foreach($errors->all() as $message)
        <script type="text/javascript">
        $().ready(function(){
            $.notify({
                icon: "pe-7s-info",
                message: "{{ $message }}"

            },{
                type: type[4],
                timer: 5000,
            });
        });
        </script>
    @endforeach
    @endif
</body>
</html>
