@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="header">
            <a href="{{ url('home/user/createmerchant') }}" class="btn btn-default btn-sm pull-right">Add More</a>
            <h4 class="title">Merchants Data</h4>
        </div>
        <div class="content table-responsive table-full-width">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>
                            Rating
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Top
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
                        <td><a href="{{ url('home/view/company/'. $user->id) }}">{{ ($user->merchant->company != null ? $user->merchant->company : '-') }}</a></td>
                        <td style="width:12%">
                            <?php
                                $int = $user->merchant->rating > 0 ? floor($user->merchant->rating) : ceil($user->merchant->rating);
                                $dec = 5 - $int;
                            ?>
                            {!! str_repeat('<i class="fa fa-star"></i>', $int) !!}{!! str_repeat('<i class="fa fa-star-o"></i>', $dec) !!}
                        </td>
                        <td>
                            @if($user->merchant->active == 1)
                            <form action="{{ url('home/user/inactive') }}" method="post" style="display: inline">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{ $user->id }}" name="id">
                                <button type="submit" name="button" rel="tooltip" data-original-title="Click to Deactivate" class="btn btn-default btn-round btn-xs"><i class="fa fa-circle text-success" style="text-align: right"></i></button>
                            </form>
                            @else
                            <form action="{{ url('home/user/active') }}" method="post" style="display: inline">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{ $user->id }}" name="id">
                                <button type="submit" name="button" rel="tooltip" data-original-title="Click to Activate" class="btn btn-default btn-round btn-xs"><i class="fa fa-circle text-default" style="text-align: left"></i></button>
                            </form>
                            @endif
                        </td>
                        <td>
                            @if($user->merchant->featured == 0)
                            <form action="{{ url('home/user/featured') }}" method="post" style="display: inline">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{ $user->id }}" name="id">
                                <button type="submit" name="button" rel="tooltip" data-original-title="Click to Make it Top" class="btn btn-default btn-round btn-xs"><i class="fa fa-circle text-default" style="text-align: left"></i></button>
                            </form>
                            @else
                            <form action="{{ url('home/user/unfeatured') }}" method="post" style="display: inline">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{ $user->id }}" name="id">
                                <button type="submit" name="button" rel="tooltip" data-original-title="Click to Untop" class="btn btn-default btn-round btn-xs"><i class="fa fa-circle text-danger" style="text-align: right"></i></button>
                            </form>
                            @endif
                        </td>
                        <td class="td-actions text-right">
                            <a href="#" rel="tooltip" title="" class="btn btn-info btn-simple btn-xs" data-original-title="View Profile">
                                <i class="fa fa-user"></i>
                            </a>
                            <a href="{{ url('home/user/edit/'. $user->id) }}" rel="tooltip" title="" class="btn btn-success btn-simple btn-xs" data-original-title="Edit Merchant">
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
