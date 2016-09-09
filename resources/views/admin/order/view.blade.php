@extends('layouts.app')
@section('content')

<div class="col-md-12">
    <div class="card">
        <div class="header">
            <div class="btn-group pull-right">
                <a href="{{ url('home/order?status=current') }}" class="btn btn-sm {{ (Request::get('status') == 'current' ? 'btn-warning' : 'btn-default') }}">Current</a>
                <a href="{{ url('home/order?status=past') }}" class="btn btn-sm {{ (Request::get('status') == 'past' ? 'btn-warning' : 'btn-default') }}">Complete</a>
            </div>
            <h4 class="title">Orders</h4>
            <p class="category">
                {{ (Request::has('user_id') ? \App\User::getUser(Request::get('user_id'))->name . ' has' : 'Total') }} {{ $orders->total() }} Orders
            </p>
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
                    @if($orders->isEmpty())
                        <tr>
                            <td colspan="9">
                                No order yet.
                            </td>
                        </tr>
                    @else
                        @foreach($orders as $order)
                            <tr>
                            	<td><a href="{{ url('home/order/orderdetail/'. $order->id) }}">#{{ $order->id }}</a></td>
                                <td>
                                    {{ $order->created_at->format('d/m/y, H:i T') }}
                                </td>
                            	<td><a href="{{ url('home/view/profile/'. $order->user->id) }}">{{ $order->user->name }}</a></td>
                            	<td><i class="fa fa-long-arrow-right" aria-hidden="true"></i></td>
                                <td>
                                    <a href="{{ url('home/view/company/'. $order->merchant->user_id) }}">{{ $order->merchant->company }}</a>
                                </td>
                                <td>
                                    <?php echo $date = date('d/m/y H:i T', strtotime($order->booking_time)) ?>
                                </td>

                                <td>
                                    @if(isset($order->orderservice[0]))
                                        @if($order->orderservice[0]->service != null)
                                             <?php $total = 0 ?>
                                             @foreach($order->orderservice as $data)
                                                @if ($data->service != null)
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
                    @endif
                    </tbody>
                </table>

            </div>

            <div class="footer">
                <div class="legend">
                    <i class="fa fa-circle text-default"></i> Waiting Confirmation
                    <i class="fa fa-circle text-info"></i> In progress
                    <i class="fa fa-circle text-success"></i> Completed
                    <i class="fa fa-circle text-warning"></i> Canceled
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
</script>

@stop
