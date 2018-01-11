@section('content')

	<div class="row">
        <div class="col-md-12">
        	<h1>Shipping Reports</h1>
        	<hr>
			<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="dataTable">
				<thead>
				    <tr>
				      <th> Ship Date</th>
				      <th> Order</th>
				      <th> Source </th>
				      <th> Tracking </th>
				      <th> Quantity </th>
				      <th> Charge </th>
				    </tr>
				</thead>
			  	<tbody>

			  		@foreach ($shipments as $shipment)
			  		
			    	<tr>
				      <td><strong>{{$shipment->ship_date}}</strong></td>
				      <td><strong><a href="{{URL::to('/sales-orders/'.$shipment->order_id)}}">{{$shipment->id}}</a></strong></td>
				      <td><strong>{{$shipment->purchase_source}}</strong></td>
				      <td><strong><a href="http://wwwapps.ups.com/WebTracking/track?track=yes&trackNums={{$shipment->main_tracking}}&loc=en_us" target="_blank" >{{$shipment->main_tracking}}</a></strong></td>
				      <td><strong>{{$shipment->quantity}}</strong></td>
				      <td><strong>{{money_format('%n', $shipment->negotiated_charges)}}</strong></td>
				    </tr>
				    @endforeach

				</tbody>
			</table>
			<table cellpadding="0" cellspacing="0" border="0" class="reports-table table table-striped table-bordered">
				<thead>
				    <tr>
				      <th> Orders</th>
				      <th> Packages</th>
				      <th> Cost </th>
				    </tr>
				</thead>
			  	<tbody>
			    	<tr>
				      <td><strong>{{$order_count}}</strong></td>
				      <td><strong>{{$tire_count}}</strong></td>
				      <td><strong>{{money_format('%n', $shipping_cost)}}</strong></td>
				    </tr>
				</tbody>
			</table>
		</div>
	</div>
@stop