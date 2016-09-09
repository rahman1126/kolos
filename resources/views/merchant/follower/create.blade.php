@extends('layouts.app')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Messages</h4>
                    </div>
                    <div class="content">
                        <form action="{{ url('home/follower/store') }}" method="post" enctype="multipart/form-data">
                            <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                                <label>Your Message <star>*</star></label>
                                <input type="text" name="message" class="form-control" value="{{ old('message') }}">
                                <p>
                                    <small>Your message will be pushed to all your followers.</small>
                                </p>
                                @if ($errors->has('message'))
                                    <label class="error">{{ $errors->first('message') }}</label>
                                @endif
                            </div>

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-warning btn-fill pull-right">Push Message</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
