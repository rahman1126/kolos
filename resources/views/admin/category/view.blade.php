@extends('layouts.app')
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="header">
            <a href="{{ url('home/category/trash') }}" class="btn btn-default btn-round btn-sm pull-right">Trash</a>
            <a href="{{ url('home/category/create') }}" class="btn btn-default btn-round btn-sm pull-right">Add New</a>
            <h4 class="title">Categories</h4>
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
                        	<th>Description</th>
                            <th>
                                Status
                            </th>
                            <th>
                                Top
                            </th>
                            <th class="text-right">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                        	<td>{{ $category->id }}.</td>
                            <td>
                                <img src="{{ $category->logo }}" class="responsive-img" alt="" style="width: 40px; height: 40px" />
                            </td>
                            <td>
                                {{ $category->name }}
                            </td>
                        	<td>{{ $category->description }}</td>
                            <td>
                                @if($category->active == 1)
                                <form action="{{ url('home/category/deactivate') }}" method="post" style="display: inline">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" value="{{ $category->id }}" name="id">
                                    <button type="submit" name="button" rel="tooltip" data-original-title="Click to Deactivate" class="btn btn-default btn-round btn-xs"><i class="fa fa-circle text-success" style="text-align: right"></i></button>
                                </form>
                                @else
                                <form action="{{ url('home/category/activate') }}" method="post" style="display: inline">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" value="{{ $category->id }}" name="id">
                                    <button type="submit" name="button" rel="tooltip" data-original-title="Click to Activate" class="btn btn-default btn-round btn-xs"><i class="fa fa-circle text-default" style="text-align: left"></i></button>
                                </form>
                                @endif
                            </td>
                            <td>
                                @if($category->top == 1)
                                <form action="{{ url('home/category/setasuntop') }}" method="post" style="display: inline">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" value="{{ $category->id }}" name="id">
                                    <button type="submit" name="button" rel="tooltip" data-original-title="Click to Deactivate" class="btn btn-default btn-round btn-xs"><i class="fa fa-circle text-danger" style="text-align: right"></i></button>
                                </form>
                                @else
                                <form action="{{ url('home/category/setastop') }}" method="post" style="display: inline">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" value="{{ $category->id }}" name="id">
                                    <button type="submit" name="button" rel="tooltip" data-original-title="Click to Activate" class="btn btn-default btn-round btn-xs"><i class="fa fa-circle text-default" style="text-align: left"></i></button>
                                </form>
                                @endif
                            </td>
                        	<td class="td-actions text-right">
                                <a href="{{ url('home/category/edit/'. $category->id) }}" rel="tooltip" title="" class="btn btn-info btn-simple btn-xs" data-original-title="Edit Data">
                                    <i class="fa fa-edit" aria-hidden="true"></i>
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

            <div class="footer">
                <div class="legend">
                    <i class="fa fa-circle text-default"></i> Inactive
                    <i class="fa fa-circle text-success"></i> Active
                </div>
            </div>
        </div>

        <div class="text-center">
            {!! $categories->render() !!}
        </div>

    </div>
</div>
@endsection
@section('footer')

<script type="text/javascript">
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
