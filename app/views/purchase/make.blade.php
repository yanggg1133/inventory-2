@section('content')
	<h3><i class="fa fa-cubes fa-4"></i> Purchase Order</h3>
    <hr>
    
    {{ Form::open(array('action' => 'PurchaseOrderController@store', 'class' => 'form-horizontal', 'files' => true)) }}
		<fieldset>

		<!-- Form Name -->
		<legend>Add New Purchase Order</legend>
			@if ($user->hasAccess('admin') != False)
			<!-- Select Basic -->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="selectbasic">Seller</label>
			  <div class="col-md-4">
			    <select id="selectbasic" name="seller_id" class="form-control">
			      @foreach ($sellers as $seller)
			      <option value="{{$seller->id}}">{{$seller->company}}</option>
			      @endforeach
			    </select>
			  </div>
			</div>
			@endif

			<!-- Select Basic -->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="selectbasic"> Supplier</label>
			  <div class="col-md-4">
			    <select id="selectbasic" name="supplier_id" class="form-control">
			      @foreach ($suppliers as $supplier)
			      <option value="{{$supplier->id}}">{{$supplier->title}}</option>
			      @endforeach
			    </select>
			  </div>
			</div>
			<a href="#" class="btn btn-sm btn-primary add-items" style="float: right;"> Add Items</a>
			<h4>Add Items</h4>
			<hr>
			<div id="#po-items">
			@foreach ($products as $item)
			<!-- Text input-->
			<?php
			  			$sales = DB::select("SELECT IF( sales_order_items.quantity IS NOT NULL , SUM( sales_order_items.quantity ) , 0 ) AS sold FROM sales_orders LEFT JOIN sales_order_items  ON ( sales_order_items.so_id = sales_orders.id) LEFT JOIN products ON (sales_order_items.aid = products.sku) WHERE NOT (sales_orders.status = 'returned' OR sales_orders.status ='canceled') AND products.sku = '$item->sku'");
			  			$ordered = DB::select("SELECT IF( purchase_order_checkins.quantity IS NOT NULL , SUM( purchase_order_checkins.quantity ) , 0 ) AS ordered FROM  `products` LEFT JOIN purchase_order_items ON ( purchase_order_items.aid = products.aid ) LEFT JOIN purchase_order_checkins ON ( purchase_order_checkins.poi_id = purchase_order_items.id ) WHERE products.sku = '$item->sku'");
			  			$adjustments = DB::select("SELECT IFNULL( SUM( quantity ) , 0 ) as quantity FROM adjustment_memos LEFT JOIN products ON (products.aid = adjustment_memos.aid) WHERE products.id = $item->id GROUP BY adjustment_memos.aid");

			  			$sales = json_decode(json_encode($sales), true);
			  			$ordered = json_decode(json_encode($ordered), true);
			  			$adjustments = json_decode(json_encode($adjustments), true);

			  			if (isset($adjustments[0])) {
			  				$current_stock = ($ordered[0]["ordered"] - $sales[0]["sold"] + $adjustments[0]["quantity"]);
			  			}
			  			else {
			  				$current_stock = ($ordered[0]["ordered"] - $sales[0]["sold"]);
			  			}

			  			$par_vars = DB::select("SELECT IFNULL((SELECT IFNULL(SUM(sales_order_items.quantity), 0) FROM sales_order_items LEFT JOIN products ON (sales_order_items.aid = products.sku ) LEFT JOIN sales_orders ON (sales_orders.id = sales_order_items.so_id) WHERE products.id = $item->id AND sales_orders.purchase_date BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW() AND NOT(sales_orders.status ='returned' AND sales_orders.status ='canceled') GROUP BY sales_order_items.aid ), 0) as past30,  IFNULL((SELECT IFNULL(SUM(sales_order_items.quantity), 0) FROM sales_order_items LEFT JOIN products ON (sales_order_items.aid = products.sku ) LEFT JOIN sales_orders ON (sales_orders.id = sales_order_items.so_id) WHERE products.id = $item->id AND sales_orders.purchase_date BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW() AND NOT(sales_orders.status ='returned' AND sales_orders.status ='canceled') GROUP BY sales_order_items.aid ), 0)  as past7 FROM products WHERE id = $item->id");
                
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
			
			  	@if ($purchase > 0)	
				<div class="form-group">
					<select id="selectbasic" name="aid[]" class="form-select">
				      @foreach ($products as $product)
				      @if ($item->aid ==$product->aid)
			      		<option value="{{$product->aid}}" selected="selected">{{$product->title}}</option>
			      	@else
			      		<option value="{{$product->aid}}">{{$product->title}}</option>
			      	@endif
				      @endforeach
				    </select>
				  <input id="textinput" name="quantity[]" type="text" placeholder="quantity" class="input-md" value="{{$purchase}}">
				  <input id="textinput" name="cost_per_item[]" type="text" placeholder="Cost Per Item" class="input-md">
				  <input id="textinput" name="estimated_arrival[]" type="text" placeholder="ETA" class="input-md">
				  <input id="textinput" name="tracking[]" type="text" placeholder="Tracking" class="input-md">
				  <a href="#" class="remove-item">Remove</a>
				</div>
				@endif
			@endforeach
			</div>
			<!-- Button (Double) -->
			<div class="">
			  <label class="col-md-4 control-label" for="button1id"></label>
			  <div class="col-md-8">
			    <button id="button1id" name="button1id" class="btn btn-success">Submit</button>
			    <button id="button2id" name="button2id" class="btn btn-danger">Cancel</button>
			  </div>
			</div>
		</fieldset>
	{{Form::close()}}

	<script type="text/javascript">
            var i = $('.form-group').size() + 1;

            //Add More
            $(".add-items").click(function(){
                var no = $(".form-group").length + 1;
                var more_textbox = $('<div class="form-group"><select id="selectbasic" name="aid[]" class="form-select">@foreach ($products as $product)<option value="{{$product->aid}}">{{$product->title}}</option>@endforeach</select> <input id="textinput" name="quantity[]" type="text" placeholder="quantity" class="input-md"> <input id="textinput" name="cost_per_item[]" type="text" placeholder="Cost Per Item" class="input-md"> <input id="textinput" name="estimated_arrival[]" type="text" placeholder="ETA" class="input-md"> <input id="textinput" name="tracking[]" type="text" placeholder="Tracking" class="input-md"> <a href="#" class="remove-item">Remove</a></div>');
                more_textbox.hide();
                $(".form-group:last").after(more_textbox);
                more_textbox.fadeIn('fast');
                i++;
                return false;
            });
             
            //Remove
            $('.form-horizontal').on('click', '.remove-item', function(){
            	if( i > 2 ) {
                        $(this).parents('.form-group').remove();
                        i--;
                }
                return false;
            });
    </script>

@stop