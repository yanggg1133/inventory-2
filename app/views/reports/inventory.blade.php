@section('content')

	<div class="row">
        <div class="col-md-12">
        	<h1>Current Inventory Details</h1>
        	<hr>
        	<h4>Inventory Value {{money_format('%n', $total_worth)}}</h4>
			<table cellpadding="0" cellspacing="0" border="0" class="reports-table table table-striped table-bordered">
				<thead>
				    <tr>
				      <th> Product</th>
				      <th> Stock </th>
				      <th> Value </th>
				    </tr>
				</thead>
			  	<tbody>

			  		@foreach ($products as $product)
			  		<?php
			  			$sales = DB::select("SELECT IF( sales_order_items.quantity IS NOT NULL , SUM( sales_order_items.quantity ) , 0 ) AS sold FROM sales_orders LEFT JOIN sales_order_items  ON ( sales_order_items.so_id = sales_orders.id) LEFT JOIN products ON (sales_order_items.aid = products.sku) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND products.sku = '$product->sku'");
			  			$ordered = DB::select("SELECT IF( purchase_order_checkins.quantity IS NOT NULL , SUM( purchase_order_checkins.quantity ) , 0 ) AS ordered FROM  `products` LEFT JOIN purchase_order_items ON ( purchase_order_items.aid = products.aid ) LEFT JOIN purchase_order_checkins ON ( purchase_order_checkins.poi_id = purchase_order_items.id ) WHERE products.sku = '$product->sku'");
			  			$adjustments = DB::select("SELECT IFNULL( SUM( quantity ) , 0 ) as quantity FROM adjustment_memos LEFT JOIN products ON (products.aid = adjustment_memos.aid) WHERE products.id = $product->id GROUP BY adjustment_memos.aid");
			  			$sales = json_decode(json_encode($sales), true);
			  			$ordered = json_decode(json_encode($ordered), true);
			  			$adjustments = json_decode(json_encode($adjustments), true);
			  		?>
			    	<tr>
				      <td><strong>{{$product->title}}</strong></td>
				      @if (isset($adjustments[0]))
				      	<td><strong>{{($ordered[0]["ordered"] - $sales[0]["sold"] + $adjustments[0]["quantity"])}}</strong></td>
				      @else
				      	<td><strong>{{($ordered[0]["ordered"] - $sales[0]["sold"])}}</strong></td>
				      @endif
				      
				      <td><strong>{{money_format('%n', ($ordered[0]["ordered"] -  $sales[0]["sold"]) * $product->cost)}}</strong></td>
				    </tr>
				    @endforeach

				</tbody>
			</table>
			<h4>Inventory Value {{money_format('%n', $total_worth)}}</h4>
		</div>
	</div>
@stop