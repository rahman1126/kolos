@extends('layouts.app')

@section('content')
<div class="">
  <div class="clearfix"></div>

  <div class="row">

    <div class="col-md-12">
      <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-home"></i> Dashboard Panel</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <p>Welcome to kolos {{ Auth::user()->name }}</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
