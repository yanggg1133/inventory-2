@section('content')
	<h3><i class="fa fa-cubes fa-4"></i> Purchase Order</h3>
    <hr>
    {{ Form::open(array('action' => 'PurchaseOrderController@store', 'class' => 'form-horizontal', 'files' => true)) }}
		<fieldset>

		<!-- Form Name -->
		<legend>Add New Purchase Order</legend>

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
			<a href="#" class="btn btn-sm btn-primary add-items" style="float: right;"> Add Items</a>
			<h4>Add Items</h4>
			<hr>
			<div id="#po-items">
			<!-- Text input-->
			<div class="form-group">
				<select id="selectbasic" name="aid[]" class="form-select">
			      @foreach ($products as $product)
			      <option value="{{$product->aid}}">{{$product->title}}</option>
			      @endforeach
			    </select>
			  <input id="textinput" name="quantity[]" type="text" placeholder="quantity" class="input-md">
			  <input id="textinput" name="cost_per_item[]" type="text" placeholder="Cost Per Item" class="input-md">
			  <input id="textinput" name="estimated_arrival[]" type="text" placeholder="ETA" class="input-md">
			  <input id="textinput" name="tracking[]" type="text" placeholder="Tracking" class="input-md">
			</div>
			</div>
			<!-- Button (Double) -->
			<div class="">
			  <label class="col-md-4 control-label" for="button1id"></label>
			  <div class="col-md-8">
			    <button id="button1id" name="button1id" class="btn btn-success">Submit</button>
			    <button id="button2id" name="button2id" class="btn btn-danger">Cancel</button>
			  </div>
			</div>
		</fieldset>
	{{Form::close()}}

	<script type="text/javascript">
            var i = $('.form-group').size() + 1;

            //Add More
            $(".add-items").click(function(){
                var no = $(".form-group").length + 1;
                var more_textbox = $('<div class="form-group"><select id="selectbasic" name="aid[]" class="form-select">@foreach ($products as $product)<option value="{{$product->aid}}">{{$product->title}}</option>@endforeach</select> <input id="textinput" name="quantity[]" type="text" placeholder="quantity" class="input-md"> <input id="textinput" name="cost_per_item[]" type="text" placeholder="Cost Per Item" class="input-md"> <input id="textinput" name="estimated_arrival[]" type="text" placeholder="ETA" class="input-md"> <input id="textinput" name="tracking[]" type="text" placeholder="Tracking" class="input-md"> <a href="#" class="remove-item">Remove</a></div>');
                more_textbox.hide();
                $(".form-group:last").after(more_textbox);
                more_textbox.fadeIn('fast');
                i++;
                return false;
            });
             
            //Remove
            $('.form-horizontal').on('click', '.remove-item', function(){
            	if( i > 2 ) {
                        $(this).parents('.form-group').remove();
                        i--;
                }
                return false;
            });
    </script>

@stop