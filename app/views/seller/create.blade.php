@section('content')
	<h3><i class="fa fa-tag fa-4"></i> Seller</h3>
    <hr>
    {{ Form::open(array('action' => 'SellerController@store', 'class' => 'form-horizontal', 'files' => true)) }}
		<fieldset>

		<!-- Form Name -->
		<legend>Add New Seller</legend>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Company</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="company" type="text" placeholder="" class="form-control input-md">
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Prefix</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="prefixer" type="text" placeholder="" class="form-control input-md">
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Phone</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="phone" type="text" placeholder="" class="form-control input-md">
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Email</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="email" type="text" placeholder="" class="form-control input-md">
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Website</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="website" type="text" placeholder="" class="form-control input-md">
		    
		  </div>
		</div>

		<!-- Button (Double) -->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="button1id"></label>
		  <div class="col-md-8">
		    <button id="button1id" name="button1id" class="btn btn-success">Submit</button>
		    <button id="button2id" name="button2id" class="btn btn-danger">Cancel</button>
		  </div>
		</div>

		</fieldset>
	{{Form::close()}}

@stop

