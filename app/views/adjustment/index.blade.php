@section('content')
	<a href="{{URL::to('/adjustment-memos/create')}}" class="btn btn-sm btn-primary" style="float: right;"> Add New</a>
	<h3><i class="fa fa-users fa-4"></i> Adjustment Memos</h3>
    <hr>
    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="dataTable">
		<thead>
		    <tr>
		      <th>Date</th>
		      <th>Product</th>
		      <th>Quantity</th>
		    </tr>
		</thead>
	  	<tbody>
	  		@foreach ($memos as $memo)
	  		<tr>
		    	<td><a href="{{URL::to('/adjustment-memos/'.$memo->id)}}">{{$memo->date}}</a></td>
		    	<td>{{$memo->product}}</td>
		    	<td>{{$memo->quantity}}</td>
	    	</tr>
	    	@endforeach
		</tbody>
	</table>
@stop
