@section('content')
	<h3><i class="fa fa-tag fa-4"></i> Product</h3>
    <hr>
    @foreach ($products as $product)
    {{ Form::open(array('action' => array('ProductController@update', $id), 'class' => 'form-horizontal', 'files' => true)) }}
		<fieldset>

		<legend>Add New Product</legend>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="selectbasic">Seller</label>
		  <div class="col-md-4">
		    <select id="seller_id" name="seller_id" class="form-control">
		      @foreach ($sellers as $seller)
		      <option value="{{$seller->id}}">{{$seller->company}}</option>
		      @endforeach
		    </select>
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Product Name</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="title" type="text" value="{{$product->title}}" class="form-control input-md">
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="filebutton">Image</label>
		  <div class="col-md-4">
		    <input id="filebutton" name="image" class="input-file" type="file">
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">SKU</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="sku" type="text" value="{{$product->sku}}" class="form-control input-md">
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">MFP</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="mfp" type="text" value="{{$product->mfp}}" class="form-control input-md">
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Amazon ASIN</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="amazon_asin" type="text" value="{{$product->amazon_asin}}" class="form-control input-md">
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="selectbasic">Manufacturer</label>
		  <div class="col-md-4">
		    <select id="manufacturer_id" name="manufacturer_id" class="form-control">
		      @foreach ($manufacturers as $manufacturer)
		      <option value="{{$manufacturer->id}}">{{$manufacturer->title}}</option>
		      @endforeach
		    </select>
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="selectbasic"> Supplier</label>
		  <div class="col-md-4">
		    <select id="supplier_id" name="supplier_id" class="form-control">
		      @foreach ($suppliers as $supplier)
		      <option value="{{$supplier->id}}">{{$supplier->title}}</option>
		      @endforeach
		    </select>
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">MSRP</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="msrp" type="text" value="{{$product->msrp}}" class="form-control input-md">
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Cost</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="cost" type="text" value="{{$product->cost}}" class="form-control input-md"> 
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Price</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="price" type="text" value="{{$product->price}}" class="form-control input-md">
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Weight</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="weight" type="text" value="{{$product->weight}}" class="form-control input-md">  
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Length</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="length" type="text" value="{{$product->length}}" class="form-control input-md">
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Width</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="width" type="text" value="{{$product->width}}" class="form-control input-md">
		  </div>
		</div>

		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">height</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="height" type="text" value="{{$product->height}}" class="form-control input-md">
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
			<script type="text/javascript">
                $(function() {
                	$("#seller_id").val("<?php echo $product->seller_id; ?>");
                    $("#manufacturer_id").val("<?php echo $product->manufacturer_id; ?>");
                    $("#supplier_id").val("<?php echo $product->supplier_id; ?>");
                });
          	</script>
	@endforeach

@stop
