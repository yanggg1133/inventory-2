@section('content')
	<a href="{{URL::to('/manufacturers/create')}}" class="btn btn-sm btn-primary" style="float: right;">Add New Manufacturer</a>
	<h3><i class="fa fa-wrench fa-4"></i> Manufacturers</h3> 
    <hr>
    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="dataTable">
		<thead>
		    <tr>
		      <th>Company</th>
		      <th>Phone</th>
		      <th>Website</th>
		    </tr>
		</thead>
	  	<tbody>
	    	@foreach ($manufacturers as $manufacturer)
	    	<tr>
		    	<td><a href="{{URL::to('/manufacturers/'.$manufacturer->id)}}">{{$manufacturer->title}}</a></td>
		    	<td>{{$manufacturer->phone}}</td>
		    	<td>{{$manufacturer->website}}</td>
	    	</tr>
	    	@endforeach
		</tbody>
	</table>

@stop