@extends('layouts.app')
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="header">
            <h4 class="title">Merchant Statistics</h4>
        </div>
        <div class="content table-responsive table-full-width">
            <table class="table table-hover table-striped">
                <thead>
                    <tr><th>ID</th>
                	<th>Company</th>
                	<th>Order Total</th>
                    <th>
                        Pending
                    </th>
                    <th>
                        In Progress
                    </th>
                    <th>
                        Complete
                    </th>
                    <th>
                        Canceled
                    </th>
                    <th>
                        Declined
                    </th>
                </tr></thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                    	<td>{{ $order->merchant_id }}</td>
                    	<td>{{ $order->merchant->company }}</td>
                    	<td>{{ $order->order_count }}</td>
                        <td class="text-default">
                            {{ \App\Order::pending_order($order->merchant_id) }}
                        </td>
                        <td class="text-info">
                            {{ \App\Order::inprogress_order($order->merchant_id) }}
                        </td>
                        <td class="text-success">
                            {{ \App\Order::complete_order($order->merchant_id) }}
                        </td>
                        <td class="text-warning">
                            {{ \App\Order::canceled_order($order->merchant_id) }}
                        </td>
                        <td class="text-danger">
                            {{ \App\Order::declined_order($order->merchant_id) }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
@stop
