@section('content')

	@foreach ($virtual_products as $virtual_product)
	<a href="{{URL::to('/virtual-products/'.$virtual_product->id.'/edit/')}}" class="btn btn-sm btn-primary" style="float: right;"> Edit Virtual Product</a>
	<h3>Adjustment Memo</h3>
	<hr>
		<div class="row">
		<div class="col-md-12">
			<div class="row"><div class="col-md-2"><strong>ASIN :</strong></div><div class="col-md-10">{{$virtual_product->asin}}</div></div>
			<div class="row"><div class="col-md-2"><strong>Product :</strong></div><div class="col-md-10">{{$virtual_product->title}}</div></div>
			<div class="row"><div class="col-md-2"><strong>Seller :</strong></div><div class="col-md-10">{{$virtual_product->seller}}</div></div>
		</div>
	</div>
	@endforeach

	<h3><i class="fa fa-tag fa-4"></i> Products</h3>
    <hr>
    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="dataTable2">
		<thead>
		    <tr>
		      <th>AID</th>
		      <th>SKU</th>
		      <th>Title</th>
		    </tr>
		</thead>
	  	<tbody>
	  		@foreach ($products as $product)
	  		<tr>
		    	<td>{{$product->aid}}</a></td>
		    	<td>{{$product->sku}}</a></td>
		    	<td>{{$product->title}}</td>
	    	</tr>
	    	@endforeach
		</tbody>
	</table>

@stop