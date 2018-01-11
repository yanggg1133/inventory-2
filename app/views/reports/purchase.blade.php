@section('content')

	<div class="row">
        <div class="col-md-12">
        	<h1>Purchase Report</h1>
        	<hr>
			<table cellpadding="0" cellspacing="0" border="0" class="reports-table table table-striped table-bordered">
				<thead>
				    <tr>
				      <th> Product</th>
				      <th> Stock </th>
				      <th> Forecast </th>
				      <th> Purchase</th>
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

			  			if (isset($adjustments[0])) {
			  				$current_stock = ($ordered[0]["ordered"] - $sales[0]["sold"] + $adjustments[0]["quantity"]);
			  			}
			  			else {
			  				$current_stock = ($ordered[0]["ordered"] - $sales[0]["sold"]);
			  			}

			  			$par_vars = DB::select("SELECT IFNULL((SELECT IFNULL(SUM(sales_order_items.quantity), 0) FROM sales_order_items LEFT JOIN products ON (sales_order_items.aid = products.sku ) LEFT JOIN sales_orders ON (sales_orders.id = sales_order_items.so_id) WHERE products.id = $product->id AND sales_orders.purchase_date BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW() AND NOT(sales_orders.status ='returned' AND sales_orders.status ='canceled') GROUP BY sales_order_items.aid ), 0) as past30,  IFNULL((SELECT IFNULL(SUM(sales_order_items.quantity), 0) FROM sales_order_items LEFT JOIN products ON (sales_order_items.aid = products.sku ) LEFT JOIN sales_orders ON (sales_orders.id = sales_order_items.so_id) WHERE products.id = $product->id AND sales_orders.purchase_date BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW() AND NOT(sales_orders.status ='returned' AND sales_orders.status ='canceled') GROUP BY sales_order_items.aid ), 0)  as past7 FROM products WHERE id = $product->id");
                
			                foreach ($par_vars as $par_var) {
			                    $par = ceil((((($par_var->past30 / 30) * 7) + $par_var->past7) * 2) / 14);
			                    $dif = ceil(((($par_var->past30 / 30) * 7) + $par_var->past7) * 2);
			                }

			                $date1 = new DateTime(date("Y-m-d"));
			                $date2 = new DateTime(date("Y-m-d", strtotime("next tuesday")));

			                $datediff = $date1->diff($date2);

			                $diff = json_decode(json_encode($datediff), true);

			                $lead = $diff["d"] + 7;

			                $forecast = $par*$lead;

			                $purchase = ($forecast - $current_stock);

			                if ($purchase <= 0) {
			                	$purchase = 0;
			                }
			  		?>
			    	<tr>
				      	<td><strong>{{$product->title}}</strong></td>
				      	<td><strong>{{$current_stock}}</strong></td>
				      	<td><strong>{{$forecast}}</strong></td>
				      	<td><strong>{{$purchase}}</strong></td>
				    </tr>
				    @endforeach

				</tbody>
			</table>
		</div>
	</div>
@stop