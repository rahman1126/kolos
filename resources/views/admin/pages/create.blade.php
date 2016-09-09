@extends('layouts.app')
@section('content')

<!-- pro request from mobile app -->
<div class="col-md-12">
    <div class="card">
        <div class="header">
            <a href="{{ url('home/page') }}" class="btn btn-default btn-sm pull-right">Cancel</a>
            <h4 class="title">Create Page</h4>
        </div>
        <div class="content">
            <form action="{{ url('home/page/store') }}" method="post" enctype="multipart/form-data">
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label>Name <star>*</star></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <label class="error">{{ $errors->first('name') }}</label>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                    <label>Description</label>
                    <textarea type="text" name="description" id="description" class="form-control" rows="10">{{ old('description') }}</textarea>
                    @if ($errors->has('description'))
                        <label class="error">{{ $errors->first('description') }}</label>
                    @endif
                </div>

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-warning btn-fill pull-right">Create</button>
                <div class="clearfix"></div>
            </form>
        </div>

    </div>
</div>
@stop
@section('footer')
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
    tinymce.init({ selector:'#description' });
</script>
@stop
