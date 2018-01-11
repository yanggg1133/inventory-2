@section('content')
	<h3><i class="fa fa-tag fa-4"></i> Seller</h3>
    <hr>
    @foreach ($sellers as $seller)
    {{ Form::open(array('action' => array('SellerController@edit', $id), 'class' => 'form-horizontal', 'files' => true)) }}
		<fieldset>

		<legend>Add New Seller</legend>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Company</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="company" type="text" value="{{$seller->company}}" class="form-control input-md">
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Prefix</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="prefixer" type="text" value="{{$seller->prefixer}}" class="form-control input-md">
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Phone</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="phone" type="text" value="{{$seller->phone}}" class="form-control input-md">
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Email</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="email" type="text" value="{{$seller->email}}" class="form-control input-md">
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Website</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="website" type="text" value="{{$seller->website}}" class="form-control input-md">
		    
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="button1id"></label>
		  <div class="col-md-8">
		    <button id="button1id" name="button1id" class="btn btn-success">Submit</button>
		    <button id="button2id" name="button2id" class="btn btn-danger">Cancel</button>
		  </div>
		</div>

		</fieldset>
	{{Form::close()}}
	@endforeach
@stop

