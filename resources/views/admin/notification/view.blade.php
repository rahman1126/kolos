@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Spread Message</h4>
            </div>
            <div class="content">
                <form action="{{ url('home/notification/notification') }}" method="post">
                   <div class="form-group">
                       <label for="message">Message</label>
                       <input type="text" name="message" class="form-control" placeholder="Hello kolos users!">
                   </div>
                   <div class="form-group">
                       <label for="user">Send To</label>
                       <label class="radio checked" style="margin-bottom: 10px;">
                            <span class="icons"><span class="first-icon fa fa-circle-o"></span><span class="second-icon fa fa-dot-circle-o"></span></span><input type="radio" data-toggle="radio" name="sendTo" value="4">All users
                        </label>
                        <label class="radio" style="margin-bottom: 10px;">
                             <span class="icons"><span class="first-icon fa fa-circle-o"></span><span class="second-icon fa fa-dot-circle-o"></span></span><input type="radio" data-toggle="radio" name="sendTo" value="2">Admins Only
                         </label>
                        <label class="radio" style="margin-bottom: 10px;">
                             <span class="icons"><span class="first-icon fa fa-circle-o"></span><span class="second-icon fa fa-dot-circle-o"></span></span><input type="radio" data-toggle="radio" name="sendTo" value="0">Customers Only
                         </label>
                         <label class="radio" style="margin-bottom: 10px;">
                              <span class="icons"><span class="first-icon fa fa-circle-o"></span><span class="second-icon fa fa-dot-circle-o"></span></span><input type="radio" data-toggle="radio" name="sendTo" value="1">Merchants Only
                          </label>
                   </div>
                    <div class="form-group">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button class="btn btn-warning btn-fill">Push Alert</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@stop
