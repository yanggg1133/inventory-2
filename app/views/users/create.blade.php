@section('content')
	<h3><i class="fa fa-cubes fa-4"></i> Purchase Order</h3>
    <hr>
    {{ Form::open(array('action' => 'UserController@store', 'class' => 'form-horizontal', 'files' => true)) }}
		<fieldset>

		<!-- Form Name -->
		<legend>Add New Purchase Order</legend>

			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="textinput">First</label>  
			  <div class="col-md-4">
			  <input id="textinput" name="first_name" type="text" placeholder="" class="form-control input-md">
			    
			  </div>
			</div>

			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="textinput">Last</label>  
			  <div class="col-md-4">
			  <input id="textinput" name="last_name" type="text" placeholder="" class="form-control input-md">
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
			  <label class="col-md-4 control-label" for="textinput">Password</label>  
			  <div class="col-md-4">
			  <input id="textinput" name="password" type="password" placeholder="" class="form-control input-md">
			  </div>
			</div>

			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="textinput">Confirm Password</label>  
			  <div class="col-md-4">
			  <input id="textinput" name="confirm" type="password" placeholder="" class="form-control input-md">
			  </div>
			</div>

			<!-- Select Basic -->
			<div class="form-group">
				<label class="col-md-4 control-label" for="coupon_question">Is this a seller's account?</label>
			  <div class="col-md-4">
			  <input class="seller-account" type="checkbox" name="seller-account" value="1" />
			  </div>
			</div>

			<!-- Select Basic -->
			<div class="form-group">
			  <label class="seller_id col-md-4 control-label" for="textinput">Select a Seller</label>  
			  <div class="col-md-4">
			    <select id="selectbasic" name="seller_id" class="seller_id form-control">
			      @foreach ($sellers as $seller)
			      <option value="{{$seller->id}}">{{$seller->company}}</option>
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
		$( document ).ready(function() {
			$(".seller_id").hide();
			$(".seller-account").click(function() {
			    if($(this).is(":checked")) {
			        $(".seller_id").show();
			    } else {
			        $(".seller_id").hide();
			    }
			});
		});
	</script>

@stop