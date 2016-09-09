@extends('layouts.app')
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="header">
            <a href="{{ url('home/form/trash') }}" class="btn btn-default btn-round btn-sm pull-right">Trash</a>
            <h4 class="title">Request Pro From Website</h4>
        </div>
        <div class="content">
            <div class="content table-responsive table-full-width">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>

                            </th>
                            <th>
                                Name
                            </th>
                        	<th>Company</th>
                            <th>
                                Address
                            </th>
                            <th>
                                Category
                            </th>
                            <th>
                                Phone
                            </th>
                            <th class="text-right">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($forms as $category)
                        <tr>
                        	<td>{{ $category->id }}.</td>
                            <td>
                                <img src="{{ $category->profile_picture }}" class="responsive-img" alt="" style="width: 40px; height: 40px" />
                            </td>
                            <td>
                                {{ $category->name }}
                            </td>
                        	<td>{{ $category->business_name }}</td>
                            <td>
                                {{ $category->business_address }}
                            </td>
                            <td>
                                {{ $category->category }}
                            </td>
                            <td>
                                {{ $category->phone }}
                            </td>
                        	<td class="td-actions text-right">
                                <a href="{{ url('home/form/detail' . '/' . $category->id) }}" rel="tooltip" title="" class="btn btn-info btn-simple btn-xs" data-original-title="Edit Data">
                                    <i class="fa fa-file" aria-hidden="true"></i>
                                </a>
                                <button type="button" data-id="delete-{{ $category->id }}" onclick="alertme(this.getAttribute('data-id'));" rel="tooltip" title="" class="btn btn-danger btn-simple btn-xs" data-original-title="Delete Data">
                                    <i class="fa fa-times"></i>
                                </button>
                                <form id="delete-{{ $category->id }}" method="post" action="{{ url('home/category/delete') }}" style="display: none">
                                	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                                	<input type="hidden" name="id" value="{{ $category->id }}">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <div class="text-center">
            {!! $forms->render() !!}
        </div>

    </div>
</div>

<!-- pro request from mobile app -->
<div class="col-md-12">
    <div class="card">
        <div class="header">
            <h4 class="title">Request Pro From Mobile App</h4>
        </div>
        <div class="content">
            <div class="content table-responsive table-full-width">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>

                            </th>
                            <th>
                                Name
                            </th>
                        	<th>Email</th>
                            <th>
                                Phone
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($requests as $category)
                        <tr>
                        	<td>{{ $category->id }}.</td>
                            <td>
                                <img src="{{ $category->profile_picture }}" class="responsive-img" alt="" style="width: 40px; height: 40px" />
                            </td>
                            <td>
                                {{ $category->name }}
                            </td>
                        	<td>{{ $category->email }}</td>

                            <td>
                                {{ $category->phone }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>
@endsection
