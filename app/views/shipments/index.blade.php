@extends('template')
@section('content')

{{ Form::open(array('action' => 'ShipmentController@scanned', 'class' => 'form-horizontal', 'files' => true)) }}
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Tracking Number</label>
		  <div class="col-md-4">
		  <input id="textinput" name="tracking_num" type="text" class="form-control input-md">
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="button1id"></label>
		  <div class="col-md-8">
		    <button id="button1id" name="button1id" class="btn btn-success">Submit</button>
		  </div>
		</div>
{{Form::close()}}

<h3><i class="fa fa-sitemap fa-4"></i> Shipment Packages</h3>
    <hr>
    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="dataTable">
		<thead>
		    <tr>
		    	<th>Date</th>
					<th>SKU</th>
		    	<th>Customer</th>
		      <th>Tracking Num</th>
		    </tr>
		</thead>
	  	<tbody>
	  		@foreach ($prints as $print)
	  		<tr>
	  			<td>{{$print->created_at}}</td>
					<td>{{$print->sku}}</td>
	  			<td>{{$print->name}}</td>
		    	<td><a href="{{URL::to('/shipments/'.$print->tracking_num)}}" target="_blank">{{$print->tracking_num}}</a></td>
	    	</tr>
	    	@endforeach
		</tbody>
	</table>

@stop
