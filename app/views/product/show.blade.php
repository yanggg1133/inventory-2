@section('content')

	@foreach ($products as $product)
	<a href="{{URL::to('/products/'.$product->product_id.'/edit/')}}" class="btn btn-sm btn-primary" style="float: right;"> Edit Product</a>
	<h3>Product Information</h3>
	<hr>
	<div class="row"><!-- Title Row -->
	<div class="col-md-12"><h3>{{$product->product}}</h3></div>
	</div><!-- Title Row -->
	<div class="row"><!-- Img Row -->
	<div class="col-md-3"><!-- Info Row -->
		@if ($product->image != null)
			<img class="product-img" src="{{URL::to('/').'/upload/products/'.$product->seller.'/'.$product->aid.'/'.$product->image}}" alt="" />
		@else
			<img src="http://fakeimg.pl/200x200/?text=Product">
		@endif
	</div><!-- Info Row -->
	<div class="col-md-2"><!-- In Stock -->

	</div><!-- In Stock -->
	<div class="col-md-2"><!-- In Stock -->
		<div class="row">
		<div class="panel panel-primary stock-box">
			<div class="panel-heading"><center><h4>In Stock</h4></center></div>
			<div class="panel-body"><center><h1>{{$checkins - $sales + $adjustments}}</h1></center></div>
		</div>
		</div>	
	</div><!-- In Stock -->
	<div class="col-md-2"><!-- In Stock -->
		<div class="row">
		<div class="panel panel-primary stock-box">
			<div class="panel-heading"><center><h4>Forecast</h4></center></div>	
			<div class="panel-body"><center><h1>{{$forecast}} <small><span class="label label-primary">± {{($forecast - $dif)}}</span></small></h1> </center></div>
		</div>
		</div>	
	</div><!-- In Stock -->
	<div class="col-md-2"><!-- In Stock -->
		<div class="row">
		<div class="panel panel-primary stock-box">
			<div class="panel-heading"><center><h4>Purchase</h4></center></div>	
			<div class="panel-body"><center><h1>{{$est_purchase}}</h1></center></div>
		</div>
		</div>	
	</div><!-- In Stock -->
	<div class="col-md-2"><!-- Filler -->
	</div><!-- Filler -->
	</div><!-- Img Row -->
	<div class="row"><!-- Shipping Row -->
	<div class="col-md-4"><div class="row"><div class="col-md-12"><h4>Product Attributes</h4></div></div>
		<div class="row"><div class="col-md-2"><strong>AID:</strong></div><div class="col-md-10">{{$product->aid}}</div></div>
		<div class="row"><div class="col-md-2"><strong>SKU:</strong></div><div class="col-md-10">{{$product->sku}}</div></div>
		<div class="row"><div class="col-md-2"><strong>MFP: </strong></div><div class="col-md-10">{{$product->mfp}}</div></div>
		<div class="row"><div class="col-md-2"><strong>Supplier: </strong></div><div class="col-md-10">{{$product->supplier}}</div></div>
		<div class="row"><div class="col-md-2"><strong>Mfg: </strong></div><div class="col-md-10">{{$product->manufacturer}}</div></div>
	</div>
	<div class="col-md-4"><div class="row"><div class="col-md-12"><h4>Shipping</h4></div></div>
		<div class="row"><div class="col-md-3"><strong>Weight: </strong></div><div class="col-md-9">{{$product->weight}}lbs</div></div>
		<div class="row"><div class="col-md-3"><strong>Length: </strong></div><div class="col-md-9">{{$product->length}}in</div></div>
		<div class="row"><div class="col-md-3"><strong>Width: </strong></div><div class="col-md-9">{{$product->width}}in</div></div>
		<div class="row"><div class="col-md-3"><strong>Height:</strong></div><div class="col-md-9">{{$product->height}}in</div></div>
	</div>
	<div class="col-md-4"><div class="row"><div class="col-md-12"><h4>Purchasing</h4></div></div>
		<div class="row"><div class="col-md-3"><strong>Cost: </strong></div><div class="col-md-9">${{$product->cost}}</div></div>
		<div class="row"><div class="col-md-3"><strong>Price: </strong></div><div class="col-md-9">${{$product->price}}</div></div>
		<div class="row"><div class="col-md-3"><strong>MSRP: </strong></div><div class="col-md-9">${{$product->msrp}}</div></div>
	</div>
	</div><!-- Shipping Row -->

	<h3><i class="fa fa-tag fa-4"></i> Checkin History</h3>
    <hr>
    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="dataTable">
		<thead>
		    <tr>
		      <th>PO#</th>
		      <th>Quantity</th>
		      <th>Date</th>
		    </tr>
		</thead>
	  	<tbody>
	  		@foreach ($checkin_history as $checkin_history)
	  		<tr>
		    	<td><a href="{{URL::to('/purchase-orders/'.$checkin_history->po)}}">{{$checkin_history->po}}</a></td>
		    	<td>{{$checkin_history->qty}}</td>
		    	<td>{{$checkin_history->date_received }}</td>
	    	</tr>
	    	@endforeach
		</tbody>
	</table>

	<h3><i class="fa fa-tag fa-4"></i> Adjustment History</h3>
    <hr>
    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="dataTable2">
		<thead>
		    <tr>
		      <th>Quantity</th>
		      <th>Memo</th>
		    </tr>
		</thead>
	  	<tbody>
	  		@foreach ($adjustments_history as $adjustment_history)
	  		<tr>
		    	<td>{{$adjustment_history->quantity}}</a></td>
		    	<td>{{$adjustment_history->memo}}</td>
	    	</tr>
	    	@endforeach
		</tbody>
	</table>

	@endforeach
@stop