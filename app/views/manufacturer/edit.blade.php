@section('content')
	<h3><i class="fa fa-wrench fa-4"></i> Manufacturer</h3>
    <hr>

    @foreach ($manufacturers as $manufacturer)

    {{ Form::open(array('action' => array('ManufacturerController@update', $id), 'class' => 'form-horizontal', 'files' => true)) }}
		<fieldset>

		<legend>Add New Manufacturer</legend>

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

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Company</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="title" type="text" value="{{$manufacturer->title}}" class="form-control input-md">
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="filebutton">Logo</label>
		  <div class="col-md-4">
		    <input id="filebutton" name="image" class="input-file" type="file">
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Email</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="email" type="text" value="{{$manufacturer->email}}" class="form-control input-md">
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Phone</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="phone" type="text" value="{{$manufacturer->phone}}" class="form-control input-md">
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Website</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="website" type="text" value="{{$manufacturer->website}}" class="form-control input-md">
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
