@section('content')
	@foreach ($sellers as $seller)
	<a href="{{URL::to('/sellers/'.$seller->id.'/edit/')}}" class="btn btn-sm btn-primary" style="float: right;"> Edit Seller</a>
	<h3> Seller</h3>
	<hr>
	<div class="row">
	<div class="col-md-6">
		<h3>{{$seller->company}}</h3>
	</div>
	<div class="col-md-6">
		  <div class="panel panel-default">
		  <div class="panel-heading"><center>Contact Information</center></div>
		  <div class="panel-body">
		    <table class="table">
		    	<tr>
		    		<td><strong>Prefix:</strong></td><td>{{$seller->prefixer}}</td>
		    	</tr>
		    	<tr>
		    		<td><strong>Phone:</strong></td><td><a href="tel://{{$seller->phone}}">{{$seller->phone}}</a></td>
		    	</tr>
		    	<tr>
		    		<td><strong>Website:</strong></td><td><a href="http://{{$seller->website}}" target="_blank">{{$seller->website}}</a></td>
		    	</tr>
		    </table>
		  </div>
		  </div>
	</div>
	</div>
	<div class="row">
        <div class="col-md-12">
        	<h4>Sales Applications</h4>
        	<br>
        	<br>
        	<a data-toggle="modal" data-target="#amazon">
        		<img class="sales-app" src="{{URL::to('/assets/css/third_party_logos/amazon-250x250.jpeg')}}" alt="Amazon API" />
        	</a>
        	<a data-toggle="modal" data-target="#ebay">
        		<img class="sales-app" src="{{URL::to('/assets/css/third_party_logos/ebay-250x250.png')}}" alt="Ebay API" />
        	</a>
        	<a data-toggle="modal" data-target="#cscart">
        		<img class="sales-app" src="{{URL::to('/assets/css/third_party_logos/cscart-250x250.png')}}" alt="CS-Cart API" />
        	</a>
		</div>
	</div>

<!-- Modal -->
<div class="modal fade" id="amazon" tabindex="-1" role="dialog" aria-labelledby="amazon" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Amazon API</h4>
      </div>
      <div class="modal-body">
        {{Form::open(array('action' => 'UserApiProfileController@store'))}}
        <fieldset>
        @foreach ($amazon as $api)
        <input id="textinput" type="hidden" name="provider" value="amazon"/>
        <input id="textinput" type="hidden" name="seller" value="{{$seller->id}}"/>
      	<div class="form-group">
	        <label class="col-md-6 control-label" for="textinput">Merchant ID : </label>
	        <div class="col-md-6">
	        	<input id="textinput" type="text" name="amazon-merchant-id" <? if(isset($api->api_cred1)) {echo "value=\"$api->api_cred1\"";} ?> />
	        </div>
	        <label class="col-md-6 control-label" for="textinput">Marketplace ID : </label>
	        <div class="col-md-6">
	        	<input id="textinput" type="text" name="amazon-marketplace-id" <? if(isset($api->api_cred2)) {echo "value=\"$api->api_cred2\"";} ?> />
	        </div>
	        <label class="col-md-6 control-label" for="textinput">AWS Access Key ID : </label>
	        <div class="col-md-6">
	        	<input id="textinput" type="text" name="amazon-aws-id" <? if(isset($api->api_cred3)) {echo "value=\"$api->api_cred3\"";} ?> />
	        </div>
	        <label class="col-md-6 control-label" for="textinput">Secret Key : </label>
	        <div class="col-md-6">
	        	<input id="textinput" type="text" name="amazon-secret-key" <? if(isset($api->api_cred4)) {echo "value=\"$api->api_cred4\"";} ?> />
	        </div>
        	</div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button id="button1id" name="button1id" class="btn btn-primary">Submit</button>
          </div>
          @endforeach
          </fieldset>
      {{Form::close()}}
    </div>
  </div>
</div>
<div class="modal fade" id="ebay" tabindex="-1" role="dialog" aria-labelledby="ebay" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Ebay API</h4>
      </div>
      <div class="modal-body">
        {{Form::open(array('action' => 'UserApiProfileController@store'))}}
        <fieldset>
          @foreach ($ebay as $api)
          <input id="textinput" type="hidden" name="provider" value="ebay"/>
          <input id="textinput" type="hidden" name="seller" value="{{$seller->id}}"/>
      	<div class="form-group">
        	<label class="col-md-6 control-label" for="textinput">Authentication Token : </label>
	        <div class="col-md-6">
        		<input id="textinput" type="textarea" name="ebay-token" <? if(isset($api->api_cred1)) {echo "value=\"$api->api_cred1\"";} ?> />
	        </div>
        	</div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button id="button1id" name="button1id" class="btn btn-primary">Submit</button>
          </div>
          @endforeach
        </fieldset>
      {{Form::close()}}
    </div>
  </div>
</div>
<div class="modal fade" id="cscart" tabindex="-1" role="dialog" aria-labelledby="cscart" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">CS-Cart API</h4>
      </div>
      <div class="modal-body">
        {{Form::open(array('action' => 'UserApiProfileController@store'))}}
        <fieldset>
        @foreach ($cscart as $api)
        <input id="textinput" type="hidden" name="provider" value="cs-cart"/>
        <input id="textinput" type="hidden" name="seller" value="{{$seller->id}}"/>
      	<div class="form-group">
	        <label class="col-md-6 control-label" for="textinput">API User : </label>
	        <div class="col-md-6">
	        	<input id="textinput" type="text" name="cs-user" <? if(isset($api->api_cred1)) {echo "value=\"$api->api_cred1\"";} ?>/>
	        </div>
    	     </div>
            <div class="form-group">
    	        <label class="col-md-6 control-label" for="textinput">API Token : </label>
    	        <div class="col-md-6">
    	        	<input id="textinput" type="text" name="cs-token" <? if(isset($api->api_cred2)) {echo "value=\"$api->api_cred2\"";} ?> />
    	        </div>
    	     </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button id="button1id" name="button1id" class="btn btn-primary">Submit</button>
          </div>
          @endforeach
        </fieldset>
      {{Form::close()}}
    </div>
  </div>
  </div>
@endforeach
@stop