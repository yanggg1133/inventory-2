@section('content')
	@foreach ($memos as $memo)
	<h3><i class="fa fa-tag fa-4"></i> Seller</h3>
    <hr>
    {{ Form::open(array('action' => array('AdjustmentMemoController@update', $id), 'class' => 'form-horizontal')) }}
		<fieldset>

		<!-- Form Name -->
		<legend>Add New Seller</legend>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Product</label>  
		  <div class="col-md-4">
		  <select id="selectbasic" name="aid" class="form-select">
			      @foreach ($products as $product)
				      @if ($memo->aid == $product->aid)
				      		<option value="{{$product->aid}}" selected="selected">{{$product->title}}</option>
				      	@else
				      		<option value="{{$product->aid}}">{{$product->title}}</option>
				      @endif
			      @endforeach
			    </select>
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Quantity</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="quantity" type="text" value="{{$memo->quantity}}" class="form-control input-md">
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Memo</label>  
		  <div class="col-md-4">
		  <input id="textinput" name="memo" type="text" value="{{$memo->memo}}" class="form-control input-md">
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
	@endforeach
@stop

