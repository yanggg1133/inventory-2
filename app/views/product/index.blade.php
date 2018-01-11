@section('content')

	<a href="{{URL::to('/products/create')}}" class="btn btn-sm btn-primary" style="float: right;">Add New Product</a>
	<h3><i class="fa fa-tag fa-4"></i> Products</h3>
    <hr>
    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="dataTable">
		<thead>
		    <tr>
		      <th>AID</th>
		      <th>SKU</th>
		      <th>Product</th>
		      <th>Cost</th>
		      <th>Price</th>
		      <th>Weight</th>
		    </tr>
		</thead>
	  	<tbody>
	  		@foreach ($products as $product)
	  		<tr>
		    	<td><a href="{{URL::to('/products/'.$product->id)}}">{{$product->aid}}</a></td>
		    	<td>{{$product->sku}}</td>
		    	<td>{{$product->title}}</td>
		    	<td>{{$product->cost}}</td>
		    	<td>{{$product->price}}</td>
		    	<td>{{$product->weight}}</td>
	    	</tr>
	    	@endforeach
		</tbody>
	</table>
@stop