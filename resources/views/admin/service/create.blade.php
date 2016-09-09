@extends('layouts.app')

@section('content')
<div class="">
  <div class="clearfix"></div>

  <div class="row">

    <div class="col-md-12">
      <div class="x_panel">
        <div class="x_title">
            <h2>Create new service</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li>
                    <a href="{{ url('home/service') }}" class="btn btn-link btn-sm">Cancel</a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">         
            <form action="{{ url('home/service/store') }}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label>Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required></input>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                    <label>Description *</label>
                    <textarea name="description" class="form-control" rows="5" required>{{ old('description') }}</textarea>
                    @if ($errors->has('description'))
                        <span class="help-block">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                    <label>Price *</label>
                    <input type="text" name="price" class="form-control" value="{{ old('price') }}" required></input>
                    @if ($errors->has('price'))
                        <span class="help-block">
                            <strong>{{ $errors->first('price') }}</strong>
                        </span>
                    @endif
                </div>
            @if(Auth::user()->status == 2)
                <div class="form-group">
                    <label>Belongs To</label>
                    <select name="user_id" class="form-control" required>
                        <option value="">Choose merchant</option>
                        @foreach($merchants as $seller)
                            <option value="{{ $seller->user->id }}">{{ $seller->user->name }} - {{ $seller->company }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
                <br>
                <div class="form-group" style="display: none">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="#" id="btn-upload">
                                <img class="img-responsive thumbnail" id="data-image" src="http://dummyimage.com/300x300/d1d1d1/ffffff&text=No+Image">
                            </a>
                        </div> 
                    </div>
                    <input id="img" type="file" name="image" style="display: none">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary pull-right" value="Create"></input>
                </div>
            </form>
        </div>
        </div>
    </div>
  </div>
</div>                
@endsection
@section('footer')
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#data-image').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#img").change(function(){
        readURL(this);
    });

    $("#btn-upload").click(function() {
      $("#img").click();
    });
</script>
@stop
