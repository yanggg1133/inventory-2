@section('content')
	<h3><i class="fa fa-truck fa-4"></i> Sales Orders</h3>
    <hr>
    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="dataTable">
		<thead>
		    <tr>
		      <th>Date</th>
		      <th>Order#</th>
		      <th>Name</th>
		      <th>Email</th>
		      <th>Status</th>
		      <th>Store</th>
		    </tr>
		</thead>
	  	<tbody>
	  		@foreach ($orders as $order)
		  		<tr>
		  			<td>{{$order->purchase_date}}</td>
		  			<td><a href="{{URL::to('/sales-orders/'.$order->order_id)}}">{{$order->id}}</a></td>
		  			<td>{{$order->buyer_name}}</td>
		  			<td>{{$order->email}}</td>
		  			<td>{{$order->status}}</td>
		  			<td>{{$order->purchase_source}}</td>
		    	</tr>
	  		@endforeach
		</tbody>
	</table>
@stop