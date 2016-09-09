@extends('layouts.app')
@section('content')
<div class="rows">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
	            <a href="{{ url('home/slideshow') }}" class="btn btn-default pull-right btn-sm">Cancel</a>
				<h4 class="title">Create Slide</h4>
	        </div>

			<div class="content">
				<form method="post" action="{{ url('home/slideshow/store') }}" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">

					<div class="form-group {{ ($errors->has('image') ? 'has-error' : '') }}">
						<img class="img-responsive upload" src="http://dummyimage.com/933x441/ebebeb/4d4d4d.jpg&text=Click+me+to+upload" style="border: 1px solid #ccc; cursor: pointer">
					    <input id="image" type="file" name="image" accept="image/jpeg, image/png" style="display: none">
                        @if ($errors->has('image'))
                            <span class="help-block">
                                <strong>{{ $errors->first('image') }}</strong>
                            </span>
                        @endif
                    </div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group {{ ($errors->has('name') ? 'has-error' : '') }}">
								<label>Name</label>
								<input type="text" class="form-control" name="name" value="{{ old('name') }}">
								@if ($errors->has('name'))
		                            <span class="help-block">
		                                <strong>{{ $errors->first('name') }}</strong>
		                            </span>
		                        @endif
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group {{ ($errors->has('description') ? 'has-error' : '') }}">
								<label>Description</label>
								<input type="text" name="description" class="form-control" value="{{ old('description') }}" />
								@if ($errors->has('description'))
		                            <span class="help-block">
		                                <strong>{{ $errors->first('description') }}</strong>
		                            </span>
		                        @endif
							</div>
						</div>
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-fill btn-warning">Create</button>
					</div>

				</form>
			</div>
		</div>
	</div>
</div>
@stop
@section('footer')
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.upload').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#image").change(function(){
        readURL(this);
    });

    $(".upload").click(function() {
      $("#image").click();
    });

</script>
@stop
