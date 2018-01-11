@section('content')

	<a href="{{URL::to('/virtual-products/create')}}" class="btn btn-sm btn-primary" style="float: right;">Add New Virtual Product</a>
	<h3><i class="fa fa-tag fa-4"></i> Virtual Products</h3>
    <hr>
    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="dataTable">
		<thead>
		    <tr>
		      <th>ASIN</th>
		      <th>Title</th>
		    </tr>
		</thead>
	  	<tbody>
	  		@foreach ($virtualproducts as $virtualproduct)
	  		<tr>
		    	<td><a href="{{URL::to('/virtual-products/'.$virtualproduct->id)}}">{{$virtualproduct->asin}}</a></td>
		    	<td>{{$virtualproduct->title}}</td>
	    	</tr>
	    	@endforeach
		</tbody>
	</table>
@stop