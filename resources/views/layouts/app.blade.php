<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Kolos CMS</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('dist/img/favicon.png') }}">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ url('lib/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ url('lib/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('lib/css/demo.css') }}">
    <link rel="stylesheet" href="{{ url('lib/css/light-bootstrap-dashboard.css') }}">
    <link rel="stylesheet" href="{{ url('lib/css/pe-icon-7-stroke.css') }}">
    <link rel="stylesheet" href="{{ url('lib/css/bootstrap-clockpicker.min.css') }}">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    @yield('header')
</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-color="orange" data-image="{{ url('lib/img/sidebar.jpg') }}">
        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="{{ url('/') }}" class="logo-text">
                    KOLOS
                </a>
            </div>
            <ul class="nav">
                <li>
                    <a href="{{ url('home') }}">
                        <i class="pe-7s-graph"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- only for admin -->
                @if(Auth::user()->status == 2)

                <li>
                    <a href="{{ url('home/user/edit/'. Auth::id()) }}">
                        <i class="pe-7s-user"></i>
                        <p>My Profile</p>
                    </a>
                </li>

                <!-- <li>
                    <a href="{{ url('home/form') }}">
                        <i class="pe-7s-mail-open-file"></i>
                        <p>Pro Requests</p>
                    </a>
                </li> -->

                <li>
                    <a href="{{ url('home/slideshow') }}">
                        <i class="pe-7s-photo-gallery"></i>
                        <p>Homeslideshows</p>
                    </a>
                </li>

                <!-- Users -->
                <li>
                    <a data-toggle="collapse" href="#articles" aria-expanded="false">
                        <i class="pe-7s-users"></i>
                        <p>Users
                           <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse {{ (Route::getCurrentRoute()->getPath() === 'home/user/admin' || Route::getCurrentRoute()->getPath() === 'home/user/merchant' || Route::getCurrentRoute()->getPath() === 'home/user/customer' ? 'in' : '') }}" id="articles" aria-expanded="true">
                        <ul class="nav">
                            <li><a href="{{ url('home/user/admin') }}">Admin</a></li>
                            <li><a href="{{ url('home/user/merchant') }}">Merchants</a></li>
                            <li><a href="{{ url('home/user/createmerchant') }}">Add Merchant</a></li>
                            <li><a href="{{ url('home/user/customer') }}">Customers</a></li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="{{ url('home/category') }}">
                        <i class="pe-7s-folder"></i>
                        <p>Categories</p>
                    </a>
                </li>

                <li>
                    <a data-toggle="collapse" href="#orders" aria-expanded="false">
                        <i class="pe-7s-cart"></i>
                        <p>Orders
                           <b class="caret"></b>
                        </p>
                    </a>
                    <div id="orders" class="collapse" aria-expanded="true">
                        <ul class="nav">
                            <li><a href="{{ url('home/order') }}">All Orders</a></li>
                            <li><a href="{{ url('home/order/mostorderedmerchants') }}">Merchant Statistics</a></li>
                            <li><a href="{{ url('home/order/customerstatistics') }}">Customers Statistics</a></li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="{{ url('home/notification') }}">
                        <i class="pe-7s-bell"></i>
                        <p>Push Notifications</p>
                    </a>
                </li>

                <li>
                    <a href="{{ url('home/page') }}">
                        <i class="pe-7s-folder"></i>
                        <p>Pages</p>
                    </a>
                </li>

                @endif


                <!-- for merchants only -->
                @if(Auth::user()->status == 1)

                <li>
                    <a href="{{ url('home/profile') }}">
                        <i class="pe-7s-id"></i>
                        <p>My Profile</p>
                    </a>
                </li>

                <li>
                    <a href="{{ url('home/profile/company') }}">
                        <i class="pe-7s-portfolio"></i>
                        <p>My Company</p>
                    </a>
                </li>

                <li>
                    <a href="{{ url('home/order') }}">
                        <i class="pe-7s-cart"></i>
                        <p>My Orders</p>
                    </a>
                </li>

                <li>
                    <a href="{{ url('home/follower') }}">
                        <i class="pe-7s-network"></i>
                        <p>My Followers</p>
                    </a>
                </li>

                @endif

                <!-- only for consumers -->
                @if(Auth::user()->status == 0)
                <li>
                    <a href="{{ url('home/becomepro') }}">
                        <i class="pe-7s-id"></i>
                        <p>Become a Pro</p>
                    </a>
                </li>
                @endif

            </ul>
        </div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
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
                        @if(Auth::user()->status == 1)
                        <?php $alertNum = \App\Alert::where('user_id', Auth::id())->where('read', 0)->count(); ?>
                        <?php $alerts = \App\Alert::where('user_id', Auth::id())->where('read', 0)->orderBy('created_at', 'DESC')->limit(10)->get(); ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-bell-o"></i>
                                <span class="notification" id="alertNumber">{{ $alertNum }}</span>
                                <p class="hidden-md hidden-lg">
                                    Notifications
                                    <b class="caret"></b>
                                </p>
                            </a>
                            <style media="screen">
                                .dropdown-menu>li>a { white-space: inherit!important; }
                                a.alert-box{ min-width: 400px; padding: 10px; border-bottom: 1px solid #eee; }
                                .alert-box a{ color: #333; }
                                .readAlert:hover{ color: orange; transition: all 0.3s}
                            </style>
                            <ul class="dropdown-menu">
                                @if($alerts->isEmpty())
                                    <li>
                                        <a href="#">No alert yet.</a>
                                    </li>
                                @else
                                    @foreach($alerts as $alert)
                                    <li>
                                        <a href="#" class="alert-box" id="alert-{{ $alert->id }}">
                                            <small><b>{{ $alert->created_at->format('d-m-Y') }}</b></small> -
                                            <span id="{{ $alert->order_id }}" onclick="goToOrder(this.id);">{{ $alert->message }}</span>
                                            <small><i id="{{ $alert->id }}" onclick="readAlert(this.id);" class="fa fa-times readAlert" aria-hidden="true"></i></small>
                                        </a>
                                    </li>
                                    <!-- {{ url('home/order/orderdetail/'. $alert->id) }} -->
                                    @endforeach
                                @endif
                            </ul>
                        </li>
                        @else
                            <?php $alertNum = null; ?>
                        @endif
                        @if(!Auth::guest())
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    @yield('content')
                    <!-- content goeas here -->
                </div>
            </div>
        </div>


    </div>
</div>

    <!-- JavaScripts -->
    <script src="{{ url('lib/js/jquery-1.10.2.js') }}"></script>
    <script src="{{ url('lib/js/jquery-ui.min.js') }}"></script>
    <script src="{{ url('lib/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('lib/js/bootstrap-notify.js') }}"></script>
    <script src="{{ url('lib/js/sweetalert.js') }}"></script>
    <script src="{{ url('lib/js/moment.min.js') }}"></script>
    <script src="{{ url('lib/js/bootstrap-select.js') }}"></script>
    <script src="{{ url('lib/js/bootstrap-checkbox-radio-switch.js') }}"></script>
    <script src="{{ url('lib/js/bootstrap-clockpicker.min.js') }}"></script>
    <script src="{{ url('lib/js/light-bootstrap-dashboard.js') }}"></script>

    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

    <script type="text/javascript">

        var old_count = {{ $alertNum }};

        // check new record in every 1 second
        setInterval(function(){
            $.ajax({
                type : "POST",
                url : "http://kolos.co.id/api/v2/alert/checkalert",
                data: { user_id: "{{ Auth::id() }}", _token : "{{ csrf_token() }}"},
                success : function(response){
                    if (response > old_count) {
                        //alert("Record changes");
                        old_count = response;
                        document.getElementById("alertNumber").innerHTML = response;
                        getOrder();
                    }
                }
            });
        },1000);

        // show notification new order
        function getOrder()
        {
            $.ajax({
                type : "POST",
                url : "http://kolos.co.id/api/v2/alert/getrecord",
                data: { user_id: "{{ Auth::id() }}", _token : "{{ csrf_token() }}"},
                dataType: 'json',
                success : function(data){
                    // $.notify({
                    // 	icon: "pe-7s-gift",
                    // 	message: "<b>Great news!</b> You get an order. Click here to review.",
                    //     url: "http://kolos.co.id/home/order/orderdetail/"+data.id,
                    //     target: "_self"
                    //
                    // },{
                    //     timer: 7000,
                    // });

                    $.ajax({
                        type : "POST",
                        url : "http://kolos.co.id/api/v2/alert/getlastalert",
                        data: { user_id: "{{ Auth::id() }}", _token : "{{ csrf_token() }}"},
                        success : function(response){
                            console.log(response);// asa
                            news = null;
                            if (response.icon == 1) {
                                news = "Great news!";
                                buttonIs = true;
                            } else if (response.icon == 3) {
                                news = "Sorry :(";
                                buttonIs = false;
                            } else {
                                news = "News!";
                                buttonIs = true;
                            }
                            swal({
                              title: news,
                              html: response.message,
                              showCloseButton: false,
                              showCancelButton: true,
                              showConfirmButton: buttonIs,
                              confirmButtonText:
                                '<a href="http://kolos.co.id/home/order/orderdetail/'+data.id+'" style="color: white">Review</a>',
                              cancelButtonText: 'Dismiss',
                            });
                        }
                    });

                    // send email on background.
                    sendEmail(data.merchant_id);
                    //console.log(data.id);
                }
            });
        }

        // send email to notify they got a new order
        function sendEmail(id)
        {
            $.ajax({
                type : "POST",
                url : "http://kolos.co.id/api/v2/alert/sendemail",
                data: { user_id: id, _token : "{{ csrf_token() }}"},
                dataType: 'json',
                success : function(data){
                    console.log('email has been sent');
                }
            });
        }

        // set alert as read
        function readAlert(id)
        {
            $.ajax({
                type : "POST",
                url : "http://kolos.co.id/api/v2/alert/read",
                data: { id: id, _token : "{{ csrf_token() }}"} ,
                success : function(response){
                    document.getElementById("alertNumber").innerHTML = document.getElementById("alertNumber").innerHTML - 1;
                    $("#alert-"+id).remove();
                }
            });
        }

        // go to order detail page
        function goToOrder(id)
        {
            var url = "http://kolos.co.id/home/order/orderdetail/"+id;
            window.location.href = url;
        }
    </script>

    @yield('footer')
    @include('layouts.flash')
</body>
</html>
