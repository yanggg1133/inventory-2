@section('content')
<script type="text/javascript">
	$(document).ready(function(){

	    $('#sales').click(function(e) {  
	        var selectMonth = $("#select_month").val();
	        var selectYear = $("#select_year").val();
	        var month = encodeURIComponent(selectMonth);
	        var year = encodeURIComponent(selectYear);
	        window.location.replace("/sales-report?month="+month+"&year="+year);

	    });

	    $('#dates').click(function(e) {  
	        var selectStart = $("#datepicker1").val();
	        var selectEnd = $("#datepicker2").val();
	        var start = encodeURIComponent(selectStart);
	        var end = encodeURIComponent(selectEnd);
	        window.location.replace("/sales-report?start="+start+"&end="+end);

	    });

	    $('#shipping').click(function(e) {  
	        var shippingMonth = $("#shipping_month").val();
	        var shippingYear = $("#shipping_year").val();
	        var month = encodeURIComponent(shippingMonth);
	        var year = encodeURIComponent(shippingYear);
	        window.location.replace("/shipping-report?month="+month+"&year="+year);

	    });

	    $('#inventory').click(function(e) {  
	        var seller = $("#seller-inventory").val();
	        window.location.replace("/inventory-report/"+seller);

	    });

	    $('#purchase').click(function(e) {  
	        var seller = $("#seller-purchase").val();
	        window.location.replace("/purchase-report/"+seller);

	    });
	});
</script> 
	<h3><i class="fa fa-tachometer fa-4"></i> Dashboard</h3>


				<h2>Reports</h2>
				<hr>
				<div class="clearfix"></div>
				<div class="col-md-6">
					<div class="panel panel-primary">
						<div class="panel-heading">Inventory Report</div>	
						<div class="panel-body">
							<div class="col-md-6">
							<label>Seller</label>
							<select id="seller-inventory" name="seller_id" >
						      @foreach ($sellers as $seller)
						      <option value="{{$seller->id}}">{{$seller->company}}</option>
						      @endforeach
						    </select>
							</div>
							<div class="clearfix"></div>
							<hr>
							<div class="col-md-6">
								<button type="button" id="inventory" class="btn btn-sm btn-primary" >Submit</button>
							</div>
							</div>
					</div>
				</div>

	<div class="col-md-6">
					<div class="panel panel-primary">
						<div class="panel-heading">Purchase Report</div>	
						<div class="panel-body">
							<div class="col-md-6">
							<label>Seller</label>
							<select id="seller-purchase" name="seller_id" >
						      @foreach ($sellers as $seller)
						      <option value="{{$seller->id}}">{{$seller->company}}</option>
						      @endforeach
						    </select>
							</div>
							<div class="clearfix"></div>
							<hr>
							<div class="col-md-6">
								<button type="button" id="purchase" class="btn btn-sm btn-primary" >Submit</button>
							</div>
							</div>
					</div>
				</div>


	<div class="clearfix"></div>
		<div class="col-md-6">
		<div class="panel panel-primary">

			<div class="panel-heading">Monthly Sales Report</div>	
			<div class="panel-body">
				<div class="col-md-6">
				<label>Month</label>
					<select id="select_month" name="month">
						@for ($i = 1; $i <= 12; $i++)
							@if($i < 10 )
								<option value="0{{$i}}">{{date ("F", mktime(null, null, null, (int)'0'.$i))}}</option>
							@else
								<option value="{{$i}}">{{date ("F", mktime(null, null, null, $i))}}</option>
							@endif
						@endfor
					</select>
				</div>
				<div class="col-md-6">
				<label>Year</label>
					<select id="select_year" name="year">
						@for($y=2015; $y <= (int)date("Y"); $y++ )
							<option value="{{$y}}">{{$y}}</option>
						@endfor
					</select>
				</div>
				<div class="clearfix"></div>
				<hr>
				<div class="col-md-6">
				<button type="button" id="sales" class="btn btn-sm btn-primary" >Submit</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">Date Range Sales Report</div>	
			<div class="panel-body">
				<div class="col-md-6">
				<label>Start Date</label>
				<input id="datepicker1" name="date[]" type="text" placeholder="xxxx-xx-xx" class="input-md datepicker">
				</div>
				<div class="col-md-6">
				<label>End Date</label>
				<input id="datepicker2" name="date[]" type="text" placeholder="xxxx-xx-xx" class="input-md datepicker">
				</div>
				<div class="clearfix"></div>
				<hr>
				<div class="col-md-6">
				<button type="button" id="dates" class="btn btn-sm btn-primary">Submit</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="clearfix"></div>

	<div class="col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">Shipping Report</div>
			<div class="panel-body">
				<div class="col-md-6">
				<label>Month</label>
					<select id="shipping_month" name="month">
						@for ($i = 1; $i <= 12; $i++)
							@if($i < 10 )
								<option value="0{{$i}}">{{date ("F", mktime(null, null, null, (int)'0'.$i))}}</option>
							@else
								<option value="{{$i}}">{{date ("F", mktime(null, null, null, $i))}}</option>
							@endif
						@endfor
					</select>
				</div>
				<div class="col-md-6">
				<label>Year</label>
					<select id="shipping_year" name="year">
						@for($y=2015; $y <= (int)date("Y"); $y++ )
							<option value="{{$y}}">{{$y}}</option>
						@endfor
					</select>
				</div>
				<div class="clearfix"></div>
				<hr>
				<div class="col-md-6">
				<button type="button" id="shipping" class="btn btn-sm btn-primary" >Submit</button>
				</div>
			</div>
		</div>
	</div>

@stop