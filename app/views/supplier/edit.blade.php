@section('content')
	<h3><i class="fa fa-sitemap fa-4"></i> Supplier</h3>
    <hr>

    @foreach ($suppliers as $supplier)

    {{ Form::open(array('action' => array('SupplierController@edit', $id), 'class' => 'form-horizontal', 'files' => true)) }}
		<fieldset>
			
		<legend>Add New Supplier</legend>

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
		  <input id="textinput" name="title" type="text" value="{{$supplier->title}}" class="form-control input-md">
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="filebutton">Logo</label>
		  <div class="col-md-4">
		    <input id="filebutton" name="image" class="input-file" type="file">
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Sales Rep</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="rep" type="text" value="{{$supplier->rep}}" class="form-control input-md">
		    
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Email</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="email" type="text" value="{{$supplier->email}}" class="form-control input-md">
		    
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Phone</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="phone" type="text" value="{{$supplier->phone}}" class="form-control input-md">
		    
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Website</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="website" type="text" value="{{$supplier->website}}" class="form-control input-md">
		    
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Address1</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="address1" type="text" value="{{$supplier->address1}}" class="form-control input-md">
		    
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Address2</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="address2" type="text" value="{{$supplier->address2}}" class="form-control input-md">
		    
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">City</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="city" type="text" value="{{$supplier->city}}" class="form-control input-md">
		    
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">State</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="state" type="text" value="{{$supplier->state}}" class="form-control input-md">
		    
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Zip</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="zip" type="text" value="{{$supplier->zip}}" class="form-control input-md">
		    
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
