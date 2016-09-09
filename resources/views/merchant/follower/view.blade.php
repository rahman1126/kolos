@extends('layouts.app')
@section('content')

<!-- pro request from mobile app -->
<div class="col-md-12">
    <div class="card">
        <div class="header">
            <a href="{{ url('home/follower/create') }}" class="btn btn-dark btn-sm pull-right">Send Promo Message</a>
            <h4 class="title">Followers</h4>
            <p class="category">Total: {{ $followers->count() }}</p>
        </div>
        <div class="content">
            <div class="content table-responsive table-full-width">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Order Num</th>
                            <th>Joined On</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if($followers->isEmpty())
                        <tr>
                            <td colspan="4">
                                You have no follower yet.
                            </td>
                        </tr>
                    @else
                        @foreach($followers as $user)
                            <tr>
                            	<td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ \App\Order::getFollowerOrderCount(Auth::id(), $user->id) }} times</td>
                                <td>
                                    {{ $user->created_at }}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>

@stop
