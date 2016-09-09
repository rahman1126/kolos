@extends('layouts.app')

@section('content')
<div class="">
  <div class="clearfix"></div>

  <div class="row">

    <div class="col-md-12">
      <div class="x_panel">
        <div class="x_title">
            <h2>Services Data</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li>
                    <a href="{{ url('home/service/create') }}" class="btn btn-primary btn-sm">Create new</a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">
        @if($services->isEmpty())
            <p>No service yet.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                       <th>ID</th>
                        <th style="width: 40%">Name</th>
                        <th style="width: 20%">IDR</th>
                        <th style="width: 30">Owner</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($services as $service)
                    <tr class="tr-content">
                       <td class="td-content">{{ $service->id }}</td>
                        <td class="td-content">{{ $service->name }}</td>
                        <td class="td-content">{{ number_format($service->price, 0) }}</td>
                        <td class="td-content">{{ $service->user->name }}</td>
                    </tr>
                    <tr>
                        <td class="td-menu" colspan="2">
                           
                            <span class="group-menu">
                                <a href="{{ url('home/service/edit/'. $service->id) }}" class="btn btn-default btn-xs">Edit</a>
                                <form action="{{ url('home/service/delete') }}" method="post" style="display: inline">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" value="{{ $service->id }}" name="id">
                                    <input type="submit" value="Delete" class="btn btn-danger btn-xs">
                                </form>
                            </span>
                            
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
            
            <div class="pull-left">
                {!! $services->render() !!}
            </div>
        @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
