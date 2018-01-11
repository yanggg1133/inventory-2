@section('content')

<div class="row">
        <div class="col-md-12">
        	<h3>{{$customer}}</h3>
        	<strong>{{date("F d, Y", strtotime($start_date))}} - {{date("F d, Y", strtotime($end_date))}}</strong>
        	<hr>
			<table cellpadding="0" cellspacing="0" border="0" class="reports-table table table-striped table-bordered">
				<thead>
				    <tr>
				      <th> Product</th>
				      <th> Quantity </th>
				      <th> Total </th>
				      <th> Tax </th>
				      <th> Shipping </th>
				      <th> Fee </th>
				    </tr>
				</thead>
			  	<tbody>

			  		@foreach ($amazon as $amazon)
			    	<tr>
					    <td>{{$amazon[0]["product"]}}</td>
					    <td>{{$amazon[0]["qty"]}}</td>
					    <td>{{money_format('%n', $amazon[0]["total"])}}</td>
					    <td>{{money_format('%n', $amazon[0]["tax"])}}</td>
					    <td>{{money_format('%n', $amazon[0]["shipping"])}}</td>
					    <td>{{money_format('%n', $amazon[0]["fee"])}}</td>
				    </tr>
				    @endforeach
				    <tr>
				    	<td><strong>Totals</strong></td>
					    <td><strong>{{$qty}}</strong></td>
					    <td><strong>{{money_format('%n', $total)}}</strong></td>
					    <td><strong>{{money_format('%n', $tax)}}</strong></td>
					    <td><strong>{{money_format('%n', $ship)}}</strong></td>
					    <td><strong>{{money_format('%n', $fee)}}</strong></td>
				    </tr>
				</tbody>
			</table>
			

			<script>
				$(document).ready(function(){
					$('.details').click(function(){
					    $(this).find('.hiders').toggle();
					});
				});
			</script>
			<div>
			    <fieldset class="details">
			    <strong><i class="fa fa-plus-square-o"></i> {{$customer}} Details</strong>
			    <div class="hiders" style="display:none" >
			        <table cellpadding="0" cellspacing="0" border="0" class="reports-table table table-striped table-bordered">
						<thead>
						    <tr>
						      <th> Order </th>
						      <th> Purchase </th>
						      <th> Product</th>
						      <th> Quantity </th>
						      <th> Total </th>
						      <th> Tax </th>
						      <th> Shipping </th>
						      <th> Fee </th>
						    </tr>
						</thead>
					  	<tbody>

					  		@foreach ($details as $detail)
					    	<tr>
							    <td><strong>{{$detail->order_id}}</strong></td>
							    <td>{{$detail->purchase_date}}</td>
							    <td>{{$detail->qbid}}</td>
							    <td>{{$detail->quantity}}</td>
							    <td>{{money_format('%n', $detail->total)}}</td>
							    <td>{{money_format('%n', $detail->tax)}}</td>
							    <td>{{money_format('%n', $detail->shipping)}}</td>
							    <td>{{money_format('%n', $detail->fee)}}</td>
						    </tr>
						    @endforeach
						</tbody>
					</table>
			    </div>
			</div>

			<h4>Estimated Deposit : {{money_format('%n',($total+$tax)-$fee)}}</h4>
			
		</div>
	</div>

@stop