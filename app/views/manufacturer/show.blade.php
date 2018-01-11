@section('content')
	@foreach ($manufacturers as $manufacturer)
	<a href="{{URL::to('/manufacturers/'.$manufacturer->id.'/edit/')}}" class="btn btn-sm btn-primary" style="float: right;"> Edit Manufacturer</a>
	<h3> Manufacturer</h3>
	<hr>
	<div clas="row">
		<div class="col-md-12"><h3>{{$manufacturer->title}}</h3></div>
	</div>
	<div class="row">
		<div class="col-md-5"><img src="http://fakeimg.pl/250x250/?text=Company"></div>
		<div class="col-md-7">

			<div class="row"><div class="col-md-12"><h3>Contact Information</h3></div></div>
			<div class="row"><div class="col-md-2">Phone:</div><div class="col-md-10"><a href="tel://{{$manufacturer->phone}}">{{$manufacturer->phone}}</a></div></div>  
			<div class="row"><div class="col-md-2">Email:</div><div class="col-md-10">{{$manufacturer->email}}  </div></div>
			<div class="row"><div class="col-md-2">Website:</div><div class="col-md-10"><a href="http://{{$manufacturer->website}}" target="_blank">{{$manufacturer->website}}</a></div></div>
		</div>
	</div>

<!--
		<ul>
			<li><strong>Company : </strong>{{$manufacturer->title}}</li>
			<li><strong>Phone : </strong>{{$manufacturer->phone}}</li>
			<li><strong>Email : </strong>{{$manufacturer->email}}</li>
			<li><strong>Website : </strong>{{$manufacturer->website}}</li>
	</ul>
-->

	@endforeach
@stop