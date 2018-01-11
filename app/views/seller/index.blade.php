@section('content')
	<a href="{{URL::to('/sellers/create')}}" class="btn btn-sm btn-primary" style="float: right;"> Add New Seller</a>
	<h3><i class="fa fa-users fa-4"></i> Sellers</h3>
    <hr>
    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="dataTable">
		<thead>
		    <tr>
		      <th>Company</th>
		      <th>Prefix</th>
		      <th>Website</th>
		      <th>Status</th>
		    </tr>
		</thead>
	  	<tbody>
	  		@foreach ($sellers as $seller)
	  		<tr>
		    	<td><a href="{{URL::to('/sellers/'.$seller->id)}}">{{$seller->company}}</a></td>
		    	<td>{{$seller->prefixer}}</td>
		    	<td>{{$seller->website}}</td>
		    	<td></td>
	    	</tr>
	    	@endforeach
		</tbody>
	</table>
@stop
