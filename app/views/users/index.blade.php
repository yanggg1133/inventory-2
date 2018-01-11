@section('content')
	<a href="{{URL::to('/users/create')}}" class="btn btn-sm btn-primary" style="float: right;"> Add New User</a>
	<h3><i class="fa fa-users fa-4"></i> Users</h3>
    <hr>
    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="dataTable">
		<thead>
		    <tr>
		      <th>Name</th>
		      <th>Email</th>
		      <th>Status</th>
		    </tr>
		</thead>
	  	<tbody>
	  		@foreach ($users as $user)
	  		<tr>
		    	<td><a href="{{URL::to('/users/'.$user->id)}}">{{$user->last_name}}, {{$user->first_name}}</a></td>
		    	<td>{{$user->email}}</td>
		    	<td></td>
	    	</tr>
	    	@endforeach
		</tbody>
	</table>
@stop