@section('content')
	@foreach ($purchaseorders as $purchaseorder)
	<h3> Check-In Products for P0# {{$purchaseorder->po_id}}</h3>
	
	<hr>
	<div class="row">
        <div class="col-md-12">
			{{Form::open(array('action' => 'PurchaseOrderCheckinController@store', 'class' => 'form-horizontal')) }}
			<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
				<thead>

				    <tr>
				      <th> AID</th>
				      <th> QTY Ordered</th>
				      <th> QTY Received</th>
				      <th> Arrival Date</th>
				    </tr>
				</thead>
			  	<tbody>
			  		<input type="hidden" name="po" value="{{$purchaseorder->po_id}}">
			  		@foreach ($items as $item)
			    	<tr>
				      <td><a href="{{URL::to('/products/'.$item->product_id)}}">{{$item->aid}}</a>

				      		<input type="hidden" name="item[]" value="{{$item->aid}}">
				      	</td>
				      <td>{{$item->quantity}}</td>
				      <td><input name="quantity[]" type="text" placeholder="quantity" class="input-md"></td>
				      <td><input id="datepicker{{$item->id}}" name="date[]" type="text" placeholder="xxxx-xx-xx" class="input-md datepicker"></td>
				    </tr>
				    @endforeach
				    
				</tbody>
			</table>
			<!-- Button (Double) -->
			<div class="">
				<label class="col-md-4 control-label" for="button1id"></label>
				<div class="col-md-8">
					<button id="button1id" name="button1id" class="btn btn-success">Submit</button>
					<button id="button2id" name="button2id" class="btn btn-danger">Cancel</button>
				</div>
			</div>
			{{Form::close()}}
		</div>
	</div>
@endforeach
@stop