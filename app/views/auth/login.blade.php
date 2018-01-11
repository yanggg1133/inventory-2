@section('content')
<div id="loginbox" class="col-md-4 col-sm-4">     
</div>

    <div id="loginbox" class="col-md-4 col-sm-8">                    
            <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title"><center><i class="fa fa-cubes fa-3"></i> BlueBinz</center></div>
                    </div>     

                    <div style="padding-top:30px" class="panel-body" >
                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                        
                        {{ Form::open(array('action' => 'AuthController@login', 'id' => 'loginforml','class' => 'form-horizontal')) }}
                                    
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        <input id="login-username" type="text" class="form-control" name="email" value="" placeholder="email">                                        
                                    </div>
                                
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                        <input id="login-password" type="password" class="form-control" name="password" placeholder="password">
                                    </div>
                                    

                                
                            <div class="input-group">
                                      <div class="checkbox">
                                        <label>
                                          <input id="login-remember" type="checkbox" name="remember" value="1"> Remember me
                                        </label>
                                      </div>
                                    </div>


                                <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->

                                    <div class="col-sm-12 controls">
                                          <button id="btn-login" class="btn btn-success" type="submit"> Login</button>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-md-12 control">
                                        <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                          <a href="#">Forgot password?</a>
                                        </div>
                                    </div>
                                </div>    
                        {{ Form::close() }}
                        </div>                     
            </div>  
    </div>
<div id="loginbox" class="col-md-4 col-sm-4">     
</div>
 @stop 

