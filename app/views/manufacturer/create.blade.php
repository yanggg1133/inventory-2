@section('content')
	<h3><i class="fa fa-wrench fa-4"></i> Manufacturer</h3>
    <hr>
    {{ Form::open(array('action' => 'ManufacturerController@store', 'class' => 'form-horizontal', 'files' => true)) }}
		<fieldset>

		<!-- Form Name -->
		<legend>Add New Manufacturer</legend>
		@if ($user->hasAccess('admin') != False)
		<!-- Select Basic -->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="selectbasic">Seller</label>
		  <div class="col-md-4">
		    <select id="selectbasic" name="seller_id" class="form-control">
		      @foreach ($sellers as $seller)
		      <option value="{{$seller->id}}">{{$seller->company}}</option>
		      @endforeach
		    </select>
		  </div>
		</div>
		@endif
		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Company</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="title" type="text" placeholder="" class="form-control input-md">
		  </div>
		</div>

		<!-- File Button --> 
		<div class="form-group">
		  <label class="col-md-4 control-label" for="filebutton">Logo</label>
		  <div class="col-md-4">
		    <input id="filebutton" name="image" class="input-file" type="file">
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
		  <label class="col-md-4 control-label" for="textinput">Phone</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="phone" type="text" placeholder="" class="form-control input-md">
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
