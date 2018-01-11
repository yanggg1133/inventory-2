@section('content')

	@foreach ($orders as $order)

	<h3>Order Information</h3>
	<hr>
	<div class="row"><!-- Title Row -->
	<div class="col-md-12"><h3> 
		Order # {{$order->id}}
		@if($order->status == 'shipped')
			<button id="button1id" name="button1id" class="btn btn-success">Shipped</button>
			@elseif ($order->status == 'canceled')
				<button id="button1id" name="button1id" class="btn btn-danger">Pending</button>
			@else
				<button id="button1id" name="button1id" class="btn btn-warning">Pending</button>
		@endif

	</h3></div>
	</div><!-- Title Row -->

	<div class="row"><!-- Img Row -->
	<div class="col-md-5"><!-- ID Row -->
		<div class="row"><div class="col-md-10"><strong>Name</strong></div></div>
		<div class="row"><div class="col-md-10">{{$order->buyer_name}}</div></div>
		<div class="row"><div class="col-md-10"><strong>Email</strong></div></div>
		<div class="row"><div class="col-md-10">{{$order->email}}</div></div>
		<div class="row"><div class="col-md-10"><strong>Phone</strong></div></div>
		<div class="row"><div class="col-md-10">{{$order->ship_phone}}</div></div>
		<div class="row"><div class="col-md-10"><strong>Address</strong></div></div>
		<div class="row"><div class="col-md-10">{{$order->ship_address1}}</div></div>
		<div class="row"><div class="col-md-10">{{$order->ship_city}}, {{$order->ship_state}} {{$order->ship_zip}}</div></div>
	</div><!-- ID Row -->
	<div class="col-md-6">
			<div class="panel panel-primary stock-box">
				<div class="panel-heading"><center><h4>Order Status</h4></center></div>
				<div class="panel-body">
					{{ Form::open(array('action' => array('SalesOrderController@changeStatus', $order->id), 'class' => 'form-horizontal', 'files' => true)) }}
						<fieldset>
							<div class="form-group">
								<label class="col-md-4 control-label" for="selectbasic">Status</label>
								<div class="col-md-4">
									<select id="status" name="status" class="form-control">
									    <option value="pending">Pending</option>
									    <option value="shipped">Shipped</option>
									    <option value="returned">Returned</option>
									    <option value="canceled">Canceled</option>
									</select>
								</div>
								<div class="col-md-8">
									    <button id="button1id" name="button1id" class="btn btn-success">Submit</button>
								</div>

								</fieldset>
							{{Form::close()}}

					</div>
			</div>
		</div>
	</div>
	<div class="col-md-5">
	</div>
	<div class="col-md-6">
			  <div class="panel panel-default">
			  <div class="panel-heading"><center>Tracking Info</center></div>
			  <div class="panel-body">
			    <table class="table">
			    	<tbody>
			    		@if(!empty($packages))
			    			<a href="/void-shipments/{{$shipment}}/{{$order_id}}">Void Shipments</a>
			    		@endif
			    		@foreach ($packages as $package)
			    		<tr>
			    			<td><strong>{{$package->created_at}}</strong></td><td><a href="http://wwwapps.ups.com/WebTracking/track?track=yes&trackNums={{$package->tracking_num}}&loc=en_us" target="_blank" >{{$package->tracking_num}}</a></td>
			    		</tr>
			    		@endforeach
			    	</tbody>
				</table>
			  </div>
			  </div>
		</div>
		<script>
			$('document').ready(function() {
				$("select#status").val("<?php echo $order->status;?>");
			});
		</script>
	@endforeach
	<div class="row">
        <div class="col-md-12">
			<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="dataTable">
				<thead>
				    <tr>
				      <th> Product</th>
				      <th> Quantity</th>
				      <th> Cost Per Items</th>
				      <th> Total</th>
				    </tr>
				</thead>
			  	<tbody>
			  		@foreach ($items as $item)
			    	<tr>
				      
				      <td>{{$item->product}}</td>
				      <td>{{$item->quantity}}</td>
				      <td>{{$item->cost}}</td>
				      <td>{{$item->total}}</td>

				    </tr>
				    @endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop