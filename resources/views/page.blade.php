@extends('layouts.web')
@section('content')


<nav class="parent" style="background-color: #FCF2D9!important;">
    <div class="nav-wrapper container">
      <a href="{{ url('/') }}" class="brand-logo"><img src="{{ url('dist/img/logo.png') }}" class="responsive-img"> KOLOS</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="#">{{ trans('welcome.downloadapp') }}</a></li>
        <li><a href="{{ url('register/pro') }}" class="modal-trigger">{{ trans('welcome.becomeamerchant') }}</a></li>
      </ul>
    </div>
</nav>

<br>

<section>
    <div class="container">
        {!! $page->description !!}
    </div>
</section>

@stop
