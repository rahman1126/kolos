@extends('layouts.app')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Edit Category</h4>
                    </div>
                    <div class="content">
                        <form action="{{ url('home/category/update') }}" method="post" enctype="multipart/form-data">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label>Name <star>*</star></label>
                                <input type="text" name="name" class="form-control" value="{{ $category->name }}">
                                @if ($errors->has('name'))
                                    <label class="error">{{ $errors->first('name') }}</label>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label>Summary</label>
                                <input type="text" name="description" class="form-control" value="{{ $category->description }}">
                                @if ($errors->has('description'))
                                    <label class="error">{{ $errors->first('description') }}</label>
                                @endif
                            </div>

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $category->id }}">
                            <input id="cover" name="cover" type="file" accept="image/jpeg,image/png" style="display: none">
                            <input id="logo" name="logo" type="file" accept="image/jpeg,image/png" style="display: none">
                            <button type="submit" class="btn btn-warning btn-fill pull-right">Update</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-user">
                    <div class="image merchant">
                        <img id="btn-upload-cover" src="{{ ($category->cover == '' ? 'http://dummyimage.com/300x300/d1d1d1/ffffff.jpg&text=Cover+Image' : $category->cover) }}" alt="..."/>
                    </div>
                    <div class="content">
                        <div class="author merchant">
                             <a href="#">
                            <img id="btn-upload-logo" class="avatar merchant" src="{{ ($category->logo == '' ? 'http://dummyimage.com/300x300/d1d1d1/ffffff.jpg&text=Logo+Image' : $category->logo) }}" alt="Merchant Logo"/>

                              <h4 class="title">{{ $category->name }}</h4>
                            </a>
                        </div>
                        <p class="description text-center" style="color: #888;">
                            {{ $category->description }}
                        </p>
                    </div>
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
                $('#btn-upload-cover').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#cover").change(function(){
        readURL(this);
    });

    $("#btn-upload-cover").click(function() {
      $("#cover").click();
    });

    function readURL2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#btn-upload-logo').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#logo").change(function(){
        readURL2(this);
    });

    $("#btn-upload-logo").click(function() {
      $("#logo").click();
    });
</script>
@stop
