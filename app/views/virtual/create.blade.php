@section('content')
	<h3><i class="fa fa-cubes fa-4"></i> Virtual Product</h3>
    <hr>
    
    {{ Form::open(array('action' => 'VirtualProductController@store', 'class' => 'form-horizontal', 'files' => true)) }}
		<fieldset>

		<!-- Form Name -->
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
			<div class="form-group">
			  <label class="col-md-4 control-label" for="textinput">Product Name</label>  
			  <div class="col-md-4">
			  <input id="textinput" name="title" type="text" placeholder="" class="form-control input-md">
				</div>
			</div>
			<div class="form-group">
			  <label class="col-md-4 control-label" for="textinput">ASIN</label>  
			  <div class="col-md-4">
			  <input id="textinput" name="asin" type="text" placeholder="" class="form-control input-md">  
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
                var more_textbox = $('<div class="form-group"><select id="selectbasic" name="aid[]" class="form-select">@foreach ($products as $product)<option value="{{$product->aid}}">{{$product->title}}</option>@endforeach</select> <a href="#" class="remove-item">Remove</a></div>');
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