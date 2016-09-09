@extends('layouts.app')
@section('content')

<?php

$jsonData = array
(
    array("Pending", \App\Order::pending_order(Auth::id()) ),
    array("InProgress" , \App\Order::inprogress_order(Auth::id())),
    array("Complete" , \App\Order::complete_order(Auth::id())),
    array("Cancelled" , \App\Order::canceled_order(Auth::id())),
    array("Declined" , \App\Order::declined_order(Auth::id())),
);

?>

<div class="col-md-6">
    <div class="card">
        <div class="content">
            <div id="chart">

            </div>
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="card">
        <div class="content">
            <div id="chart2">

            </div>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="card">
        <div class="header">
            <!-- <a href="{{ url('home/article/trashed') }}" class="btn btn-default btn-round btn-sm pull-right">Trash</a> -->
            <h4 class="title">Orders</h4>
        </div>
        <div class="content">
            <div class="content table-responsive table-full-width">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>
                                On
                            </th>
                        	<th>Customer</th>
                        	<th></th>
                            <th>
                                Merchant
                            </th>
                            <th>
                                For
                            </th>

                            <th>
                                Value
                            </th>
                            <th>Status</th>
                        	<th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                        	<td>{{ $order->id }}</td>
                            <td>
                                {{ $order->created_at->format('d/m/y, H:i T') }}
                            </td>
                        	<td><a href="#">{{ $order->user->name }}</a></td>
                        	<td><i class="fa fa-long-arrow-right" aria-hidden="true"></i></td>
                            <td>
                                <a href="#">{{ $order->merchant->company }}</a>
                            </td>
                            <td>
                                <?php echo $date = date('d/m/y H:i T', strtotime($order->booking_time)) ?>
                            </td>

                            <td>
                                @if(isset($order->orderservice[0]))
                                    @if($order->orderservice[0]->service != null)
                                         <?php $total = 0 ?>
                                         @foreach($order->orderservice as $data)
                                            @if($data->service != null)
                                                <?php $total += $data->service->price * $data->quantity ?>
                                            @endif
                                         @endforeach
                                         {{  number_format( $total , 0 , '' , '.' ) }}
                                     @else
                                        <p class="text-danger">?</p>
                                     @endif
                                 @endif
                            </td>
                            <td class="text-center">
                                @if($order->status == 0)
                                    <i class="fa fa-circle text-default"></i>
                                @elseif($order->status == 1)
                                    <i class="fa fa-circle text-info"></i>
                                @elseif($order->status == 2)
                                    <i class="fa fa-circle text-success"></i>
                                @elseif($order->status == 3)
                                    <i class="fa fa-circle text-warning"></i>
                                @elseif($order->status == 4)
                                        <i class="fa fa-circle text-danger"></i>
                                @endif
                            </td>
                        	<td class="td-actions text-right">
                                <a href="{{ url('home/order/orderdetail/'. $order->id) }}" rel="tooltip" title="" class="btn btn-info btn-simple btn-xs" data-original-title="View Data">
                                    <i class="fa fa-file" aria-hidden="true"></i>
                                </a>
                                <button type="button" data-id="delete-{{ $order->id }}" onclick="alertme(this.getAttribute('data-id'));" rel="tooltip" title="" class="btn btn-danger btn-simple btn-xs" data-original-title="Delete Data">
                                    <i class="fa fa-times"></i>
                                </button>
                                <form id="delete-{{ $order->id }}" method="post" action="{{ url('home/order/delete') }}" style="display: none">
                                	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                                	<input type="hidden" name="id" value="{{ $order->id }}">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

            <div class="footer">
                <div class="legend">
                    <i class="fa fa-circle text-default"></i> Waiting Confirmation
                    <i class="fa fa-circle text-info"></i> In progress
                    <i class="fa fa-circle text-success"></i> Completed
                    <i class="fa fa-circle text-canceled"></i> Canceled
                    <i class="fa fa-circle text-danger"></i> Declined
                </div>
            </div>
        </div>

        <div class="text-center">
            {!! $orders->render() !!}
        </div>

    </div>
</div>

@endsection
@section('footer')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript">
// delete order
function alertme(data_id)
{
    var formid = data_id;
    swal({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      //type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
      closeOnConfirm: false
    }).then(function(isConfirm) {
      if (isConfirm) {

        swal(
          'Congratulations!',
          'Data has been deleted.',
          'success'
        );

        setTimeout(function() {
          $("#"+formid).submit();
        }, 200);

      }
    })
}

jQuery(document).ready(function() {

    $('#chart').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 0,//null,
            plotShadow: false
        },
        title: {
            text: 'Percentage Activity'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                colors: ['#607D8B', '#00BCD4', '#4CAF50', '#F57C00', '#FF5252'],
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                },
                showInLegend: true
            }
        },
        series: [{
            type: 'pie',
            name: 'Percentage',
            data: <?php echo json_encode($jsonData);?>
        }]
    });


    $('#chart2').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 0,//null,
            plotShadow: false
        },
        title: {
            text: 'Total Activity'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y}</b>'
        },
        plotOptions: {
            pie: {
                colors: ['#607D8B', '#00BCD4', '#4CAF50', '#F57C00', '#FF5252'],
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y}',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                },
                showInLegend: true
            }
        },
        series: [{
            type: 'pie',
            name: 'Total',
            data: <?php echo json_encode($jsonData);?>
        }]
    });

});
</script>

@stop
