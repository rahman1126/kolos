@extends('layouts.app')
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="header">
            <h4 class="title">Users Data</h4>
        </div>
        <div class="content table-responsive table-full-width">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>
                            Role
                        </th>
                        <th>
                            Since
                        </th>
                        <th>
                            Active
                        </th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="text-center">{{ $user->id }}</td>
                        <td><a href="{{ url('home/view/profile/'. $user->id) }}">{{ $user->name }}</a></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>
                            @if($user->status == 2)
                                <i class="fa fa-user-secret" aria-hidden="true"></i>
                            @elseif($user->status == 1)
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            @else
                                <i class="fa fa-user" aria-hidden="true"></i>
                            @endif
                        </td>
                        <td>
                            {{ $user->created_at->format('d F Y') }}
                        </td>
                        <td>
                            @if($user->active == 0)
                            <form action="{{ url('home/user/idup') }}" method="post" style="display: inline">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{ $user->id }}" name="id">
                                <button type="submit" name="button" rel="tooltip" data-original-title="Click to Activate" class="btn btn-default btn-round btn-xs"><i class="fa fa-circle text-default" style="text-align: left"></i></button>
                            </form>
                            @else
                            <form action="{{ url('home/user/mati') }}" method="post" style="display: inline">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{ $user->id }}" name="id">
                                <button type="submit" name="button" rel="tooltip" data-original-title="Click to Deactivate" class="btn btn-default btn-round btn-xs"><i class="fa fa-circle text-success" style="text-align: right"></i></button>
                            </form>
                            @endif
                        </td>
                        <td class="td-actions text-right">
                            <a href="#" rel="tooltip" title="" class="btn btn-info btn-simple btn-xs" data-original-title="View Profile">
                                <i class="fa fa-user"></i>
                            </a>
                            <a href="{{ url('home/user/edit/'. $user->id) }}" rel="tooltip" title="" class="btn btn-success btn-simple btn-xs" data-original-title="Edit User">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="footer">
            <div class="legend">
                <i class="fa fa-circle text-default"></i> Inactive
                <i class="fa fa-circle text-success"></i> Active
                <i class="fa fa-circle text-danger"></i> Top
            </div>
        </div>

        <div class="text-center">
            {!! $users->render() !!}
        </div>
    </div>
</div>
@endsection
