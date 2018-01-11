@section('content')
	@foreach ($users as $user)
	<a href="{{URL::to('/users/'.$user->user_id.'/edit/')}}" class="btn btn-sm btn-primary" style="float: right;"> Edit User</a>
	<h3> User</h3>
	<hr>
	<div class="row">
		<div class="col-md-6">
			<h3>{{$user->first_name}} {{$user->last_name}}</h3>
		</div>
		<div class="col-md-6">
			  <div class="panel panel-default">
			  <div class="panel-heading"><center>Account Information</center></div>
			  <div class="panel-body">
			    <table class="table">
			    	<tr>
			    		<td><strong>Email:</strong></td><td>{{$user->login}}</td>
			    	</tr>
			    	<tr>
			    		<td><strong>Company:</strong></td><td>				@if ($user->seller > 0 || !is_null($user->seller))
					{{$user->seller}}
				@else
					SMD
				@endif</td>
			    	</tr>
			    </table>
			  </div>
			  </div>
		</div>







<!--
		<ul>
			<li><strong>Name : </strong>{{$user->first_name}} {{$user->last_name}}</li>
			<li><strong>Email : </strong>{{$user->login}}</li>
			<li><strong>Company : </strong>
				@if ($user->seller > 0 || !is_null($user->seller))
					{{$user->seller}}
				@else
					SMD
				@endif
			</li>
		</ul>

	-->
	@endforeach
@stop