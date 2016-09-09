@extends('layouts.app')
@section('content')

<!-- pro request from mobile app -->
<div class="col-md-12">
    <div class="card">
        <div class="header">
            <a href="{{ url('home/page/create') }}" class="btn btn-default btn-sm pull-right">Add More</a>
            <h4 class="title">Pages</h4>
        </div>
        <div class="content">
            <div class="content table-responsive table-full-width">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>
                                Name
                            </th>
                            <th>
                                Description
                            </th>
                            <th>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($pages as $page)
                        <tr>
                        	<td>{{ $page->id }}.</td>
                            <td>
                                {{ $page->name }}
                            </td>
                            <td>
                                {{ str_limit(strip_tags($page->description), 80) }}
                            </td>
                            <td>
                                <a href="{{ url('home/page/edit' . '/' . $page->id) }}" rel="tooltip" title="" class="btn btn-info btn-simple btn-xs" data-original-title="Edit Data">
                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                </a>
                                <!-- <button type="button" data-id="delete-{{ $page->id }}" onclick="alertme(this.getAttribute('data-id'));" rel="tooltip" title="" class="btn btn-danger btn-simple btn-xs" data-original-title="Delete Data">
                                    <i class="fa fa-times"></i>
                                </button> -->
                                <form id="delete-{{ $page->id }}" method="post" action="{{ url('home/page/delete') }}" style="display: none">
                                	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                                	<input type="hidden" name="id" value="{{ $page->id }}">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>

@stop
