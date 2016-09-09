<!DOCTYPE html>
<html>
<head>
	<title>Kolos - {{ trans('welcome.title1') }}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="icon" type="image/png" sizes="32x32" href="{{ url('dist/img/favicon.ico') }}">
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900' rel='stylesheet' type='text/css'>
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="{{ url('dist/css/style.css') }}">

	<!-- Compiled and minified JavaScript -->
</head>
<body>
	@yield('content')
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
	<script type="text/javascript" src="{{ url('dist/js/jquery.form.js') }}"></script>
	<script type="text/javascript">
		(function($){
		  $(function(){
		    $('.parallax').parallax();
		    $('.modal-trigger').leanModal();
		    $('select').material_select();

		    $(window).scroll(function(){
			    var aTop = $('.intro').height();
			    if($(this).scrollTop() >= 10){
			        $('nav').removeClass('transparent');
			    } else {
			    	$('nav').addClass('transparent');
			    }
			});

		  }); // end of document ready
		})(jQuery); // end of jQuery name space

		$(document).ready(function() {

			var max_fields      = 20; //maximum input boxes allowed
		    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
		    var add_button      = $(".add_field_button"); //Add button ID

		    var x = 1; //initlal text box count
		    $(add_button).click(function(e){ //on add input button click
		        e.preventDefault();
		        if(x < max_fields){ //max input box allowed
		            x++; //text box increment
		            $(wrapper).append('<div class="col s12"><input type="text" name="service[]" class="col s11" /><a href="#" class="remove_field"><i class="material-icons valign-middle">remove_circle_outline</i></a></div>'); //add input box
		        }
		    });

		    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
		        e.preventDefault(); $(this).parent('div').remove(); x--;
		    })


			$('#submit-form').click(function(){
                //alert(0);
				var formData = new FormData($("#form-form")[0]);
			    $.ajax({
			      url: '{{ url('submit/form/merchant') }}',
			      type: "post",
			      async: false,
				  cache: false,
				  contentType:false,
				  processData:false,
			      data: formData,
			      success: function(data){
			        Materialize.toast(data, 4000);
			      }
			    });
			});
		});
	</script>
</body>
</html>
