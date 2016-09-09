@extends('layouts.app')

@section('content')
<div class="col-md-12">
  <div class="card">
      <div class="header">
          <a href="{{ url('home/form') }}" class="btn btn-default btn-round btn-sm pull-right">Back</a>
          <h4 class="title">{{ $form->business_name }}</h4>
      </div>
    <div class="content">
      <div class="content">
        <dl class="dl-horizontal">
		  <dt>Business Name</dt>
		  <dd>{{ $form->business_name }}</dd>

		  <dt>Business Category</dt>
		  <dd>{{ $form->category }}</dd>

		  <dt>Business Address</dt>
		  <dd>{{ $form->business_address }}</dd>

		  <dt>Business Phone</dt>
		  <dd>{{ $form->business_phone }}</dd>

		  <dt>Business Description</dt>
		  <dd>{!! $form->description !!}</dd>

		  <br>

		  <dt>Opening Time</dt>
		  <dd>{{ $form->open_time }}</dd>

		  <dt>Closing Time</dt>
		  <dd>{{ $form->close_time }}</dd>

		  <dt>Area Covered</dt>
		  <dd>{{ $form->area_covered }}</dd>

		  <dt>Number of Employees</dt>
		  <dd>{{ $form->number_employees }}</dd>

		  <dt>Service</dt>
		  @if($form->services != null)
		  <?php
		  	$json = json_decode($form->services, true);
		  ?>
		  <dd>
			  <ul style="list-style: none; padding: 0">
			  	@foreach($json[0] as $jsn)
			  		<li>{{ $jsn }}</li>
			  	@endforeach
			  </ul>
		  </dd>
		  @else
		  <dd>No service.</dd>
		  @endif

		  <dt>Name</dt>
		  <dd>{{ $form->name }}</dd>

		  <dt>Phone</dt>
		  <dd>{{ $form->phone }}</dd>

		  <dt>Email Registration</dt>
		  <dd>{{ $form->email_registration }}</dd>

		  <dt>Username</dt>
		  <dd>{{ $form->username }}</dd>

		  <dt>Password</dt>
		  <dd>{{ $form->password }}</dd>

		  <dt>Mobile Type</dt>
		  <dd>{{ $form->mobile }}</dd>
		</dl>

      </div>
    </div>
  </div>
</div>

@stop
