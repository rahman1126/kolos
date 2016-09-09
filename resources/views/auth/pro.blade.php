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
  <link rel="stylesheet" type="text/css" href="{{ url('dist/css/bootstrap-wysihtml5.css') }}">
  <link href="{{ url('dist/css/bootstrap.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ url('dist/css/prettify.css') }}">
  {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
  <link rel="stylesheet" type="text/css" href="{{ url('dist/css/animate.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('dist/css/select2.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('dist/css/custom.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('dist/css/clockpicker.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('dist/css/jquery.Jcrop.min.css') }}">
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
        <div class="center">
           <p><a href="{{ url('/') }}"><img src="http://kolos.co.id/dist/img/logo.png" class="img-responsive" style="width: 80px; margin: auto;" alt="logo kolos"></a></p>
          <h2 style="font-size: 28px">Become a Merchant</h2>
          <p>Single process to become kolos business partner</p>
          <br>
        </div>
        <div id="wizard" class="form_wizard wizard_horizontal text-left">
              <ul class="wizard_steps">
                <li>
                  <a href="{{ url('register/pro') }}" class="{{ (session('step') > 1 ? 'done' : 'selected') }}">
                    <span class="step_no">1</span>
                    <span class="step_descr">
                        Personality<br />
                        <small>Who are you?</small>
                    </span>
                  </a>
                </li>

                <li>
                  @if(session('step') < 2)
                  <?php $class = 'disabled'; ?>
                  @elseif(session('step') > 2)
                  <?php $class = 'done'; ?>
                  @else
                  <?php $class = 'selected'; ?>
                  @endif
                  <a href="{{ url('register/pro/two') }}" class="{{ $class }}">
                    <span class="step_no">2</span>
                    <span class="step_descr">
                        Business<br />
                        <small>Describe your business</small>
                    </span>
                  </a>
                </li>
                <li>
                  @if(session('step') < 3)
                  <?php $class2 = 'disabled'; ?>
                  @elseif(session('step') > 3)
                  <?php $class2 = 'done'; ?>
                  @else
                  <?php $class2 = 'selected'; ?>
                  @endif
                  <a href="{{ url('register/pro/three') }}" class="{{ $class2 }}">
                    <span class="step_no">3</span>
                    <span class="step_descr">
                        Business<br />
                        <small>Details &amp; photograph</small>
                    </span>
                  </a>
                </li>
                <li>
                  @if(session('step') < 4)
                  <?php $class2 = 'disabled'; ?>
                  @elseif(session('step') > 4)
                  <?php $class2 = 'done'; ?>
                  @else
                  <?php $class2 = 'selected'; ?>
                  @endif
                  <a href="{{ url('register/pro/four') }}" class="{{ $class2 }}">
                    <span class="step_no">4</span>
                    <span class="step_descr">
                        Services<br />
                        <small>What do you offer?</small>
                    </span>
                  </a>
                </li>
              </ul>
              @yield('content')

        </section>
        <!-- content -->
      </div>
    </div>



  <script src="{{ url('dist/js/wysihtml5-0.3.0.min.js') }}"></script>
  <script src="{{ url('dist/js/jquery.min.js') }}"></script>
  <script src="{{ url('dist/js/bootstrap.min.js') }}"></script>
  <!-- form wizard -->
  <!--<script type="text/javascript" src="{{ url('dist/js/jquery.smartWizard.js') }}"></script>-->
  <script type="text/javascript" src="{{ url('dist/js/input_mask/jquery.inputmask.js') }}"></script>
  <script type="text/javascript" src="{{ url('dist/js/select2.full.js') }}"></script>
  <script type="text/javascript" src="{{ url('dist/js/clockpicker.js') }}"></script>
  <script type="text/javascript" src="{{ url('dist/js/jquery.form.js') }}"></script>
  <script type="text/javascript" src="{{ url('dist/js/bootstrap-wysihtml5.js') }}"></script>
  <script type="text/javascript" src="{{ url('dist/js/prettify.js') }}"></script>
  <script type="text/javascript" src="{{ url('dist/js/notify/pnotify.core.js') }}"></script>
  <script type="text/javascript" src="{{ url('dist/js/notify/pnotify.buttons.js') }}"></script>

  <script type="text/javascript">

    $(document).ready(function(){
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert('Geolocation is not supported by this browser.');
        }

        function showPosition(position) {
            alert(position.coords.latitude);
        }

        $('#description').wysihtml5({
            "font-styles": false,
            "color": false,
            "image": true,
            "link": true,
            "html": false,
            "lists": true,
        });
        $(":input").inputmask();
        $(".select2_group").select2({});
        // clockpicker
        $('.clockpicker').clockpicker({
            donetext: 'Done',
        });

          $("select.city").change(function(){
              var selectedCountry = $(".city option:selected").val();
              var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
              $.ajax({
                  type: "POST",
                  url: '{{ url('register/pro/district') }}',
                  data: {
                      city : selectedCountry,
                      _token: CSRF_TOKEN
                  }
              }).done(function(data){
                  //console.log(data);
                  $("#response").html(data);
                  $('#response').prop('disabled', false);
              });
          });


        // upload foto cover
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.the-cover').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#cover").change(function(){
            readURL(this);
        });

        $(".upload-box-cover").click(function() {
          $("#cover").click();
        });

        // upload foto logo
        function readURL2(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.the-logo').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#logo").change(function(){
            readURL2(this);
        });

        $(".upload-box-logo").click(function() {
          $("#logo").click();
        });


        $(window).keydown(function(event){
            if(event.which==13 && !$(event.target).is("textarea")) {
                event.preventDefault();
                console.log("ENTER PREVENTED");
                return false;
            }else{ // just to test
                console.log("ENTER was in textarea");
            }
        });

        // add more services
        var max_fields      = 20; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID

        var x = 1; //initlal text box count
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div class="form-group"><label for="service_name" class="control-label col-md-3 col-sm-3 col-xs-12">Service</label><div class="col-md-5"><input type="text" name="service_name[]" class="form-control" placeholder="Service name" /></div><div class="col-md-3"><input class="form-control" type="number" name="service_price[]" placeholder="Price"></div><div class="col-md-8 col-md-offset-3"><input class="form-control" type="text" name="service_desc[]" placeholder="Description" required><hr></div><a href="#" class="remove_field"><i class="fa fa-times" aria-hidden="true"></i></a></div>'); //add input box
            }
        });

        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent('div.form-group').remove(); x--;
        })
    });
  </script>
    @include('layouts.flash')
</body>
</html>
