@extends('layouts.auth')

<!-- Main Content -->
@section('content')

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
    <h1>Reset Password</h1>
    <h6>enter your email to process to the next step</h6>
        {!! csrf_field() !!}

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <div>
                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div>
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-btn fa-envelope"></i>Send Password Reset Link
                </button>
            </div>
        </div>
    </form>
@endsection
