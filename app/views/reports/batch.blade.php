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
				      <th>Product</th>
				      <th>QTY</th>
				      <th>Total</th>
				      <th>Shipping</th>
				      <th>Tax</th>
				      <th>Fee</th>
				    </tr>
				</thead>
			  	<tbody>
			  		
			  		@foreach ($products as $product)
			    	<tr>
			    	  @if ($amazon["$product->sku"][0]["qty"] > 0)
					      <td><strong>{{$amazon["$product->sku"][0]["product"]}}</strong></td>
					      <td>{{$amazon["$product->sku"][0]["qty"]}}</td>
					      <td>{{money_format('%n', $amazon["$product->sku"][0]["total"])}}</td>
					      <td>{{money_format('%n', $amazon["$product->sku"][0]["shipping"])}}</td>
					      <td>{{money_format('%n', $amazon["$product->sku"][0]["tax"])}}</td>
					      <td>{{money_format('%n', $amazon["$product->sku"][0]["fee"])}}</td>
				      @endif
				    </tr>
				    @endforeach
				    
				</tbody>
			</table>
		</div>
	</div>
@stop