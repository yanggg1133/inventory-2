@section('content')
	@foreach ($purchaseorders as $purchaseorder)
	<h3><i class="fa fa-cubes fa-4"></i> Purchase Order</h3>
    <hr>
    {{ Form::open(array('action' => array('PurchaseOrderController@update', $id), 'class' => 'form-horizontal', 'files' => true)) }}
		<fieldset>

		<legend>Edit Purchase Order</legend>

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
			  <label class="col-md-4 control-label" for="selectbasic"> Supplier</label>
			  <div class="col-md-4">
			    <select id="supplier_id" name="supplier_id" class="form-control">
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
			@foreach ($items as $item)
			<div class="form-group">
				<select id="selectbasic" name="aid[]" class="form-select" value="">
			      @foreach ($products as $product)
			      	@if ($item->aid ==$product->aid)
			      		<option value="{{$product->aid}}" selected="selected">{{$product->title}}</option>
			      	@else
			      		<option value="{{$product->aid}}">{{$product->title}}</option>
			      	@endif
			      @endforeach
			    </select>
			  <input id="textinput" name="quantity[]" type="text" value="{{$item->quantity}}" class="input-md">
			  <input id="textinput" name="cost_per_item[]" type="text" value="{{$item->cost_per_item}}" class="input-md">
			  <input id="textinput" name="estimated_arrival[]" type="text" value="{{$item->estimated_arrival}}" class="input-md">
			  <input id="textinput" name="tracking[]" type="text" value="{{$item->tracking}}" class="input-md">
			  <a href="/purchase/remove-item/{{$item->id}}">Remove Item</a>

			</div>
			@endforeach
			</div>

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

            $(".add-items").click(function(){
                var no = $(".form-group").length + 1;
                var more_textbox = $('<div class="form-group"><select id="selectbasic" name="aid[]" class="form-select">@foreach ($products as $product)<option value="{{$product->aid}}">{{$product->title}}</option>@endforeach</select> <input id="textinput" name="quantity[]" type="text" placeholder="quantity" class="input-md"> <input id="textinput" name="cost_per_item[]" type="text" placeholder="Cost Per Item" class="input-md"> <input id="textinput" name="estimated_arrival[]" type="text" placeholder="ETA" class="input-md"> <input id="textinput" name="tracking[]" type="text" placeholder="Tracking" class="input-md"> <a href="#" class="remove-item">Remove</a></div>');
                more_textbox.hide();
                $(".form-group:last").after(more_textbox);
                more_textbox.fadeIn('fast');
                i++;
                return false;
            });

            $('.form-horizontal').on('click', '.remove-item', function(){
            	if( i > 2 ) {
                        $(this).parents('.form-group').remove();
                        i--;
                }
                return false;
            });
            $(function() {
                    $("#seller_id").val("<?php echo $purchaseorder->seller_id; ?>");
                    $("#supplier_id").val("<?php echo $purchaseorder->supplier_id; ?>");

                });
    </script>
    @endforeach
@stop