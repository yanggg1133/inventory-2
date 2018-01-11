 @section('content')
	<h3><i class="fa fa-cubes fa-4"></i> User</h3>
    <hr>

    @foreach ($users as $user)

    {{ Form::open(array('action' => array('UserController@update', $user->id), 'class' => 'form-horizontal', 'files' => true)) }}
		<fieldset>

		<legend>Edit User</legend>

			<div class="form-group">
			  <label class="col-md-4 control-label" for="textinput">First</label>  
			  <div class="col-md-4">
			  <input id="textinput" name="first_name" type="text" value="{{$user->first_name}}" class="form-control input-md">
			  </div>
			</div>

			<div class="form-group">
			  <label class="col-md-4 control-label" for="textinput">Last</label>  
			  <div class="col-md-4">
			  <input id="textinput" name="last_name" type="text" value="{{$user->last_name}}" class="form-control input-md">
			  </div>
			</div>

			<div class="form-group">
			  <label class="col-md-4 control-label" for="textinput">Email</label>  
			  <div class="col-md-4">
			  <input id="textinput" name="email" type="text" value="{{$user->email}}" class="form-control input-md">
			  </div>
			</div>

			<div class="form-group">
			  <label class="col-md-4 control-label" for="textinput">Password</label>  
			  <div class="col-md-4">
			  <input id="textinput" name="password" type="password" placeholder="Change Password Type Here" class="form-control input-md">
			  </div>
			</div>

			<div class="form-group">
			  <label class="col-md-4 control-label" for="textinput">Confirm Password</label>  
			  <div class="col-md-4">
			  <input id="textinput" name="confirm" type="password" placeholder="Confirm New Password" class="form-control input-md">
			  </div>
			</div>
			@if ($ses_user->hasAccess('admin') != False)
			<div class="form-group">
				<label class="col-md-4 control-label" for="coupon_question">Is this a seller's account?</label>
			  <div class="col-md-4">
			  <input class="seller-account" id="seller-account" type="checkbox" name="seller-account" value="1" />
			  </div>
			</div>

			<div class="form-group">
			  <label class="seller_id col-md-4 control-label" for="textinput">Select a Seller</label>  
			  <div class="col-md-4">
			    <select id="seller_id" name="seller_id" class="seller_id form-control">
			      
			      <option value=""></option>
			      
			    </select>
			  </div>
			</div>
			@endif
			<div class="">
			  <label class="col-md-4 control-label" for="button1id"></label>
			  <div class="col-md-8">
			    <button id="button1id" name="button1id" class="btn btn-success">Submit</button>
			    <button id="button2id" name="button2id" class="btn btn-danger">Cancel</button>
			  </div>
			</div>
		</fieldset>

	{{Form::close()}}
@if ($ses_user->hasAccess('admin') != False)
	<script type="text/javascript">
		$( document ).ready(function() {
			$(".seller_id").hide();
			$(".seller_id").val("<?php echo $user->company; ?>");
			$(".seller-account").click(function() {
			    if($(this).is(":checked")) {
			        $(".seller_id").show();
			    } else {
			        $(".seller_id").hide();
			    }
			});

			
			<?php if ($user->company !== null  && $user->company !== '0'){?>
				$('#seller-account').prop('checked', true);
				$(".seller_id").show();
			<?php } ?>
		});
	</script>
@endif
	@endforeach

@stop