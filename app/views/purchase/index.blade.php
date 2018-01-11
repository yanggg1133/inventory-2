@section('content')
	<a href="{{URL::to('/purchase-orders/create')}}" class="btn btn-sm btn-primary" style="float: right;"> Add New Purchase Order</a>
	<h3><i class="fa fa-cubes fa-4"></i> Purchase Orders</h3>
    <hr>
    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="dataTable">
		<thead>
		    <tr>
		      <th> PO#</th>
		      <th> Seller</th>
		      <th> Supplier</th>
		      <th> Status</th>
		    </tr>
		</thead>
	  	<tbody>
	  		@foreach ($purchaseorders as $purchaseorder)
	    	<tr>
		      <td><a href="{{URL::to('/purchase-orders/'.$purchaseorder->po_id)}}">{{$purchaseorder->po_id}}</a></td>
		      <td>{{$purchaseorder->seller}}</td>
		      <td>{{$purchaseorder->supplier}}</td>
		      <td>{{$purchaseorder->status}}</td>
		    </tr>
		    @endforeach
		</tbody>
	</table>
@stop