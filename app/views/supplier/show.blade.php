@section('content')
	@foreach ($suppliers as $supplier)
	<a href="{{URL::to('/suppliers/'.$supplier->id.'/edit/')}}" class="btn btn-sm btn-primary" style="float: right;"> Edit Supplier</a>
	<h3> Supplier</h3>
	<hr>
	<div clas="row">
		<div class="col-md-12"><h3>{{$supplier->title}}</h3></div>
	</div>
	<div class="row">
		<div class="col-md-5"><img src="http://fakeimg.pl/250x250/?text=Company"></div>
		<div class="col-md-7">
			<div class="row"><div class="col-md-12"><h3>Contact Information</h3></div></div>
			<div class="row"><div class="col-md-2">Rep:</div><div class="col-md-10">{{$supplier->rep}}</div></div>
			<div class="row"><div class="col-md-2">Phone:</div><div class="col-md-10"><a href="tel://{{$supplier->phone}}">{{$supplier->phone}}</a></div></div>
			<div class="row"><div class="col-md-2">Email:</div><div class="col-md-10"><a href="mailto://{{$supplier->email}}">{{$supplier->email}}</a></div></div>
			<div class="row"><div class="col-md-2">Website:</div><div class="col-md-10"><a href="http://{{$supplier->website}}">{{$supplier->website}}</a></div></div>
			<div class="row"><div class="col-md-2">Address:</div><div class="col-md-10">{{$supplier->address1}}</div></div>
			<div class="row"><div class="col-md-2">Address 2:</div><div class="col-md-10">{{$supplier->address2}}</div></div>
			<div class="row"><div class="col-md-2">City:</div><div class="col-md-10">{{$supplier->city}}</div></div>
			<div class="row"><div class="col-md-2">State:</div><div class="col-md-10">{{$supplier->state}}</div></div>
			<div class="row"><div class="col-md-2">Zip:</div><div class="col-md-10">{{$supplier->zip}}</div></div>
		</div>
	</div>
	@endforeach
@stop