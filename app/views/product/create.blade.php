@section('content')
	<h3><i class="fa fa-tag fa-4"></i> Product</h3>
    <hr>
    {{ Form::open(array('action' => 'ProductController@store', 'class' => 'form-horizontal', 'files' => true)) }}
		<fieldset>

		<!-- Form Name -->
		<legend>Add New Product</legend>
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
		  <label class="col-md-4 control-label" for="textinput">Product Name</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="title" type="text" placeholder="" class="form-control input-md">
		    
		  </div>
		</div>

		<!-- File Button --> 
		<div class="form-group">
		  <label class="col-md-4 control-label" for="filebutton">Image</label>
		  <div class="col-md-4">
		    <input id="filebutton" name="image" class="input-file" type="file">
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">SKU</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="sku" type="text" placeholder="" class="form-control input-md">
		    
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">MFP</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="mfp" type="text" placeholder="" class="form-control input-md">
		    
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Amazon ASIN</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="amazon_asin" type="text" placeholder="" class="form-control input-md">
		  </div>
		</div>

		<!-- Select Basic -->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="selectbasic">Manufacturer</label>
		  <div class="col-md-4">
		    <select id="selectbasic" name="manufacturer_id" class="form-control">
		      @foreach ($manufacturers as $manufacturer)
		      <option value="{{$manufacturer->id}}">{{$manufacturer->title}}</option>
		      @endforeach
		    </select>
		  </div>
		</div>

		<!-- Select Basic -->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="selectbasic"> Supplier</label>
		  <div class="col-md-4">
		    <select id="selectbasic" name="supplier_id" class="form-control">
		      @foreach ($suppliers as $supplier)
		      <option value="{{$supplier->id}}">{{$supplier->title}}</option>
		      @endforeach
		    </select>
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">MSRP</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="msrp" type="text" placeholder="" class="form-control input-md">
		    
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Cost</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="cost" type="text" placeholder="" class="form-control input-md">
		    
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Price</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="price" type="text" placeholder="" class="form-control input-md">
		    
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Weight</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="weight" type="text" placeholder="" class="form-control input-md">
		    
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Length</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="length" type="text" placeholder="" class="form-control input-md">
		    
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Width</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="width" type="text" placeholder="" class="form-control input-md">
		    
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Height</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="height" type="text" placeholder="" class="form-control input-md">
		    
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
