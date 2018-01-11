@section('content')
	<a href="{{URL::to('/suppliers/create')}}" class="btn btn-sm btn-primary" style="float: right;"> Add New Supplier</a>
	<h3><i class="fa fa-sitemap fa-4"></i> Suppliers</h3>
    <hr>
    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="dataTable">
		<thead>
		    <tr>
		      <th>Company</th>
		      <th>Sales Rep</th>
		      <th>Phone</th>
		    </tr>
		</thead>
	  	<tbody>
	  		@foreach ($suppliers as $supplier)
	  		<tr>
		    	<td><a href="{{URL::to('/suppliers/'.$supplier->id)}}">{{$supplier->title}}</a></td>
		    	<td>{{$supplier->rep}}</td>
		    	<td>{{$supplier->phone}}</td>
	    	</tr>
	    	@endforeach
		</tbody>
	</table>
@stop