@section('content')

<script type="text/javascript">
	$(document).ready(function(){

	    $('#monthly').click(function(e) {  
	        var selectMonth = $("#select_month").val();
	        var selectYear = $("#select_year").val();
	        var month = encodeURIComponent(selectMonth);
	        var year = encodeURIComponent(selectYear);
	        window.location.replace("/reports?month="+month+"&year="+year);

	    });

	    $('#dates').click(function(e) {  
	        var selectStart = $("#datepicker1").val();
	        var selectEnd = $("#datepicker2").val();
	        var start = encodeURIComponent(selectStart);
	        var end = encodeURIComponent(selectEnd);
	        window.location.replace("/reports?start="+start+"&end="+end);

	    });
	});
</script> 

<div class="row">
	<h3> Sales Report</h3>
	<br>
        	<div class="col-md-12">
        		<div class="col-md-12">
				<div class="clearfix"></div>
				<div class="col-md-4">
				<label>Start Date</label>
				<input id="datepicker1" name="date[]" type="text" placeholder="xxxx-xx-xx" class="input-md datepicker">
				</div>
				<div class="col-md-4">
				<label>End Date</label>
				<input id="datepicker2" name="date[]" type="text" placeholder="xxxx-xx-xx" class="input-md datepicker">
				</div>
				<div class="col-md-4">
				<button type="button" id="dates" class="btn btn-sm btn-primary" style="float: right;">Submit</button>
				</div>
			</div>
				<div class="clearfix"></div>
				<div class="col-md-5">
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
				<div class="col-md-5">
				<label>Year</label>
					<select id="select_year" name="year">
						@for($y=2015; $y <= (int)date("Y"); $y++ )
							<option value="{{$y}}">{{$y}}</option>
						@endfor
					</select>
				</div>
				<div class="col-md-2">
				<button type="button" id="monthly" class="btn btn-sm btn-primary" >Submit</button>
				</div>
			</div>
</div>
		<br> 

	<hr>

	<div class="row">
        <div class="col-md-12">

        	<center>
        		@if(isset($_GET["month"])) 
        			<h4>Report for {{date("F", mktime(null, null, null, $span1))}} {{date("Y", strtotime($span2))}}</h4>
        		@elseif(isset($_GET["start"]))
        			<h4>Report for {{date("F d, Y", strtotime($span1))}} - {{date("F d, Y", strtotime($span2))}}</h4>
        		@endif
        	</center>
			<table cellpadding="0" cellspacing="0" border="0" class="reports-table table table-striped table-bordered">
				<thead>
				    <tr>
				      <th> Product</th>
				      <th>  </th>
				      <th>Items (WEB)</th>
				      <th>Revenue (WEB)</th>
				      <th>  </th>
				      <th>Items (AMZ)</th>
				      <th>Revenue (AMZ)</th>
				      <th>  </th>
				      <th>Items (EBY)</th>
				      <th>Revenue (EBY)</th>
				      <th>Total </th>
				      <th>Items</th>
				      <th>Revenue</th>
				    </tr>
				</thead>
			  	<tbody>
			  		
			  		@foreach ($products as $product)
			    	<tr>
				      <td><strong>{{$product->title}}</strong></td>
				      <td></td>
				      @if ($cscart["$product->sku"] != null)
				      <td>{{$cscart["$product->sku"][0]["qty"]}}</td>
				      <td>{{money_format('%n', $cscart["$product->sku"][0]["rev"])}}</td>
				      @else
				      <td>0</td>
				      <td>$0.00</td>
				      @endif
				      <td></td>
				      @if ($amazon["$product->sku"] != null)
				      <td>{{$amazon["$product->sku"][0]["qty"]}}</td>
				      <td>{{money_format('%n', $amazon["$product->sku"][0]["rev"])}}</td>
				      @else
				      <td>0</td>
				      <td>$0.00</td>
				      @endif
				      <td></td>
				      @if ($ebay["$product->sku"] != null)
				      <td>{{$ebay["$product->sku"][0]["qty"]}}</td>
				      <td>{{money_format('%n', $ebay["$product->sku"][0]["rev"])}}</td>
				      @else
				      <td>0</td>
				      <td>$0.00</td>
				      @endif
				      <td></td>
				      @if ($itemqty_total["$product->sku"] != null)
				      <td>{{$itemqty_total["$product->sku"]}}</td>
				      @else
				      <td>0</td>
				      @endif
				      @if ($itemrev_total["$product->sku"] != null)
				      <td>{{money_format('%n', $itemrev_total["$product->sku"])}}</td>
				      @else
				      <td>$0.00</td>
				      @endif
				    </tr>
				    @endforeach
				    <tr class="reports-totals">
				      <td><strong> Totals </strong></td>
				      <td> </td>
				      <td> <strong>{{$cscartqty}}</strong> </td>
				      <td> <strong>{{money_format('%n', $cscartrev)}}</strong> </td>
				      <td> </td>
				      <td> <strong>{{$amazonqty}}</strong> </td>
				      <td> <strong>{{money_format('%n', $amazonrev)}}</strong> </td>
				      <td> </td>
				      <td> <strong>{{$ebayqty}}</strong> </td>
				      <td> <strong>{{money_format('%n', $ebayrev)}}</strong> </td>
				      <td> </td>
				      <td> <strong>{{$totalqty}}</strong> </td>
				      <td> <strong>{{money_format('%n', $totalrev)}}</strong> </td>
				    </tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
        <div class="col-md-12">

			<table cellpadding="0" cellspacing="0" border="0" class="reports-table table table-striped table-bordered">
				<thead>
				    <tr>
				      <th> Source </th>
				      <th> Product Sales </th>
				      <th> Product Cost </th>
				      <th> Tax Collected</th>
				      <th> Shipping Collected </th>
				      <th> Shipping Cost</th>
				      <th> Gross Sales </th>
				      <th> Orders </th>
				      <th> Fulfillment </th>
				      <th> Net Profit </th>
				    </tr>
				</thead>
			  	<tbody>

			    	<tr>
				      <td><strong> Cs-Cart </strong></td>
				      <td>{{money_format('%n', $cscartrev)}}</td>
				      <td>{{money_format('%n', $cscartcost)}}</td>
				      <td>{{money_format('%n', $cscarttax)}}</td>
				      <td>{{money_format('%n', $cscartshipping)}}</td>
				      <td>{{money_format('%n', $cscart_ship[0]["shipping_charge"])}}</td>
				      <td>{{money_format('%n', $cscartrev+$cscarttax+$cscartshipping)}}</td>
				      <td>{{$cscart_orders}}</td>
				      <td>{{money_format('%n', $cscart_orders * 4.00)}}</td>
				      <td>{{money_format('%n', ($cscartrev+$cscarttax+$cscartshipping)-($cscartcost+$cscarttax+$cscart_ship[0]["shipping_charge"]+($cscart_orders * 4.00)))}}</td>
				    </tr>
				    <tr>
				      <td><strong> Amazon </strong></td>
				      <td>{{money_format('%n', $amazonrev)}}</td>
				      <td>{{money_format('%n', $amazoncost)}}</td>
				      <td>{{money_format('%n', $amazontax)}}</td>
				      <td>{{money_format('%n', $amazonshipping)}}</td>
				      <td>{{money_format('%n', $amazon_ship[0]["shipping_charge"])}}</td>
				      <td>{{money_format('%n', $amazonrev+$amazontax+$amazonshipping)}}</td>
				      <td>{{$amazon_orders}}</td>
				      <td>{{money_format('%n', $amazon_orders * 4.00)}}</td>
				      <td>{{money_format('%n', ($amazonrev+$amazontax+$amazonshipping)-($amazoncost+$amazontax+$amazon_ship[0]["shipping_charge"]+($amazon_orders * 4.00)))}}</td>
				    </tr>
				    <tr>
				      <td><strong> Ebay </strong></td>
				      <td>{{money_format('%n', $ebayrev)}}</td>
				      <td>{{money_format('%n', $ebaycost)}}</td>
				      <td>{{money_format('%n', $ebaytax)}}</td>
				      <td>{{money_format('%n', $ebayshipping)}}</td>
				      <td>{{money_format('%n', $ebay_ship[0]["shipping_charge"])}}</td>
				      <td>{{money_format('%n', $ebayrev+$ebaytax+$ebayshipping)}}</td>
				      <td>{{$ebay_orders}}</td>
				      <td>{{money_format('%n', $ebay_orders * 4.00)}}</td>
				      <td>{{money_format('%n', ($ebayrev+$ebaytax+$ebayshipping)-($ebaycost+$ebaytax+$ebay_ship[0]["shipping_charge"]+($ebay_orders * 4.00)))}}</td>
				    </tr>
				    <tr class="reports-totals">
				      <td><strong> Totals </strong></td>
				      <td>{{money_format('%n', $totalrev)}}</td>
				      <td>{{money_format('%n', $totalcost)}}</td>
				      <td>{{money_format('%n', $cscarttax+$amazontax+$ebaytax)}}</td>
				      <td>{{money_format('%n', $cscartshipping+$amazonshipping+$ebayshipping)}}</td>
				      <td>{{money_format('%n', $cscart_ship[0]["shipping_charge"]+$amazon_ship[0]["shipping_charge"]+$ebay_ship[0]["shipping_charge"])}}</td>
				      <td>{{money_format('%n', ($cscartrev+$cscarttax+$cscartshipping)+($amazonrev+$amazontax+$amazonshipping)+($ebayrev+$ebaytax+$ebayshipping))}}</td>
				      <td>{{$total_orders}}</td>
				      <td>{{money_format('%n', $total_orders * 4.00)}}</td>
				      <td>{{money_format('%n', ($cscartrev+$cscarttax+$cscartshipping)-($cscartcost+$cscarttax+$cscart_ship[0]["shipping_charge"]+($cscart_orders * 4.00))+($amazonrev+$amazontax+$amazonshipping)-($amazoncost+$amazontax+$amazon_ship[0]["shipping_charge"]+($amazon_orders * 4.00))+($ebayrev+$ebaytax+$ebayshipping)-($ebaycost+$ebaytax+$ebay_ship[0]["shipping_charge"]+($ebay_orders * 4.00)))}}</td>
				    </tr>
				</tbody>
			</table>
		</div>
	</div>
@stop