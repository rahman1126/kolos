@extends('layouts.app')
@section('content')
<div class="col-md-12">
	<div class="contents">
		<div class="card" style="background-color: transparent; box-shadow: none">
			<div class="header">
				<a href="{{ url('home/slideshow/create') }}" class="btn btn-default pull-right btn-sm">Add New</a>
				<h4 class="title">Homeslideshow</h4>
			</div>
			<div class="content">
				@if($sliders->isEmpty())
					<p>No sliders found.</p>
				@else
					<div class="row">
					<?php $i = 1; ?>
					@foreach($sliders as $slider)
						<div class="col-md-4">
                            <div class="card">
                                <div class="">
                                    <img style="max-width: 100%; display: block;" src="{{ $slider->image }}" alt="image">
                                    <div class="box">
                                        <p>{{ $slider->name }}</p>
                                        <div class="text-center" style="padding-bottom: 10px;">
                                            <a href="{{ url('home/slideshow/edit'. '/' .$slider->id) }}"><i class="fa fa-edit"></i></a>
                                            <a href="#" data-toggle="modal" data-target="#myModal-{{ $i }}"><i class="fa fa-times"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="caption">
                                    <p>{{ str_limit($slider->description, 60) }}</p>
                                </div>
                            </div>
						</div>
                    <?php $i++ ?>
				    @endforeach
					</div>
				@endif
			</div>
		</div>
	</div>
</div>
@stop
