@section('content')
	@foreach ($purchaseorders as $purchaseorder)
	<a href="{{URL::to('/purchase-orders/'.$purchaseorder->po_id.'/edit')}}" class="btn btn-sm btn-primary" style="float: right;"> Edit Purchase Order</a>
	<h3> Purchase Order Details</h3>
	<hr>

	<div class="row">
        <div class="col-md-5">
			<div class="panel panel-primary">
				
				<div class="panel-heading">
					<h3 class="panel-title">PO # {{$purchaseorder->po_id}}</h3>
					<a href="{{URL::to('/purchase-orders/'.$purchaseorder->po_id.'/pdf')}}">Download PDF</a>
					<span class="pull-right clickable"></span>
				</div>
				<div class="panel-body">
					<strong>Client : </strong>{{$purchaseorder->seller}}
					<br>
					<strong>Supplier : </strong>{{$purchaseorder->supplier}}
					<br>
					<strong>Status : </strong>{{$purchaseorder->po_status}}

					{{ Form::open(array('action' => array('PurchaseOrderController@changeStatus', $purchaseorder->po_id), 'class' => 'form-horizontal', 'files' => true)) }}
						<fieldset>
							<div class="form-group">
								<label class="col-md-4 control-label" for="selectbasic">Status</label>
								<div class="col-md-4">
									<select id="status" name="status" class="form-control">
									    <option value="Pending">Pending</option>
									    <option value="Partial">Partial</option>
									    <option value="Complete">Complete</option>
									    <option value="canceled">Canceled</option>
									</select>
								</div>
								<div class="col-md-8">
									    <button id="button1id" name="button1id" class="btn btn-success">Submit</button>
								</div>

								</fieldset>
							{{Form::close()}}

					<br>
					<hr>
					<div class="col-md-10">

						{{ Form::open(array('action' => array('PurchaseOrderController@invoice',$purchaseorder->po_id), 'class' => 'form-horizontal', 'files' => true)) }}
			                	<input id="filebutton" name="image" class="input-file" type="file">
								<button id="button1id" name="button1id" class="btn btn-sm btn-primary" style="float: right;">Submit</button>
	                    {{Form::close()}}
	                    
	                </div>
	                    <br>
						<button  class="dropdown-toggle btn btn-sm btn-primary" data-toggle="dropdown"><strong><i class="fa fa-caret-down"></i> Invoices</strong></i></button>

	                    <ul class="dropdown-menu text-left" role="menu">
	                    	@foreach ($invoices as $invoice)
		                    <li><a href="/upload/invoices/{{$purchaseorder->po_id}}/{{$invoice->image}}" target="_blank" class="btn" role="button"> {{$invoice->created_at}}</a></li>
		                    @endforeach
	                    </ul>
				</div>
			</div>
		</div>
		<div class="col-md-2 purchase-count"><!-- In Stock -->
		<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading"><center><h4>Ordered / Received</h4></center></div>
			
				<div class="panel-body"><center><h4>{{$received . ' / ' . $ordered}}</h4></center></div>

		</div>

		</div>	
	</div><!-- In Stock -->
	</div>

	<div class="row">
		{{Form::open(array('action' => 'PurchaseOrderCheckinController@store', 'class' => 'form-horizontal')) }}
        <div class="col-md-12">
        	<button id="button1id" name="button1id" class="btn btn-sm btn-primary" style="float: right;">Submit</button>
        	<br>
        	<hr>
        	
        	<input type="hidden" name="po" value="{{$purchaseorder->po_id}}">
			<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="dataTable">
				<thead>
				    <tr>
				      <th> Product</th>
				      <th> Received</th>
				      <th> Ordered</th>
				      <th> Status</th>
				    </tr>
				</thead>
			  	<tbody>
			  		
			  		@foreach ($items as $item)
			    	<tr>
				      <td>
				      	<a href="{{URL::to('/products/'.$item->product_id)}}">{{$item->product}}</a>
				      	@if ($item->ordered_quantity != $item->received_quantity && $item->ordered_quantity > $item->received_quantity)
				      	<input type="hidden" name="item[]" value="{{$item->item_id}}">
				      	@endif
				      </td>
				      <td>
				      	{{$item->received_quantity}}
				      	@if ($item->ordered_quantity != $item->received_quantity && $item->ordered_quantity > $item->received_quantity)
				      	<input name="quantity[]" type="text" placeholder="quantity" class="input-md">
				      	@endif
				      </td>
				      <td>{{$item->ordered_quantity}}</td>
				      <td>{{$item->status}}</td>
				    </tr>
				    @endforeach

				</tbody>
			</table>
			<hr>
			<!-- Button (Double) -->
			<div class="">
				<label class="col-md-4 control-label" for="button1id"></label>
				<div class="col-md-8">
					<button id="button1id" name="button1id" class="btn btn-sm btn-primary" style="float: right;">Submit</button>
				</div>
			</div>
			{{Form::close()}}
		</div>
	</div>
	@endforeach
@stop