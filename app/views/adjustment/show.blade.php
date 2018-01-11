@section('content')
	@foreach ($memos as $memo)
	<a href="{{URL::to('/adjustment-memos/'.$memo->id.'/edit/')}}" class="btn btn-sm btn-primary" style="float: right;"> Edit Memo</a>
	<h3>Adjustment Memo</h3>
	<hr>
		<div class="row">
		<div class="col-md-12">
			<div class="row"><div class="col-md-2"><strong>Date :</strong></div><div class="col-md-10">{{date("m/d/Y",strtotime($memo->date))}}</div></div>
			<div class="row"><div class="col-md-2"><strong>AID:</strong></div><div class="col-md-10">{{$memo->aid}}</div></div>
			<div class="row"><div class="col-md-2"><strong>Product:</strong></div><div class="col-md-10">{{$memo->product}}</div></div>
			<div class="row"><div class="col-md-2"><strong>Quantity:</strong></div><div class="col-md-10">{{$memo->quantity}}</div></div>
			<div class="row"><div class="col-md-2"><strong>Memo:</strong></div><div class="col-md-10">{{$memo->memo}}</div></div>
		</div>
	</div>
	@endforeach

@stop