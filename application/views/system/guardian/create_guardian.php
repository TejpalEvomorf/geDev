<?php
$stateList=stateList();
$genderList=genderList();
?>
<div class="page-heading"><h1>Add new caregiver</h1></div>

<div class="container-fluid">
                                
<div data-widget-group="group1">
	<div class="row">
    
<!--      <div class="col-sm-3">
          <div class="panel panel-profile panel-bluegraylight" data-widget='{"draggable": "false"}'>
          <div class="panel-heading">
                                          <h2>Other info</h2>
                                      </div>
              <div class="panel-body">
                  <form class="" id="formCreateClientCategory">
                    
                  </form>
              </div>
          </div>
      </div>-->
    
	<div class="col-sm-12">
			
			<div class="panel panel-primary" data-widget='{"draggable": "false"}'>
				<div class="panel-body">
							
							<form class="" id="formCreateGuardian">
                            
                            <div class="form-group width-fifty-left">
								<label for="fname" class="control-label">First name</label>
                                <input type="text" class="form-control" id="fname" name="fname"  placeholder="First name" required>
							</div>
                            
                            <div class="form-group width-fifty-right">
								<label for="lname" class="control-label">Last name</label>
                            	<input type="text" class="form-control" id="lname" name="lname"  placeholder="Last name" required>
                            </div>
                            
                            <div class="form-group width-fifty-left">
								<label for="cname" class="control-label">Company name</label>
								<input type="text" class="form-control" id="cname" name="cname" placeholder="Company name" required>
							</div>
							<div class="form-group width-fifty-right">
								<label for="abn" class="control-label">ABN</label>
								<input type="text" class="form-control" id="abn" name="abn"  placeholder="ABN">
							</div>
							
                            <div class="form-group width-full">
                            	<label for="address" class="control-label">Street address</label>
								<input type="text" class="form-control" id="address" name="address"  placeholder="Street address" >
							</div>
                            
                           <div class="form-group width-fifty-left">
                            	<label for="suburb" class="control-label">Suburb</label>
								<input type="text" class="form-control" id="suburb" name="suburb"  placeholder="Suburb" >
							</div>
							
                         <div class="form-group width-fifty-right">
                              <label class="col-sm-2 control-label" for="category">State</label>
                              <select class="form-control" id="state" name="state">
	                              <option value="">Select one</option>
                                <?php foreach($stateList as $stateK=>$stateV){?>
                                          <option value="<?=$stateK?>"><?=$stateV?></option>
                                <?php } ?>
                              </select>
                          </div>
                          
                          <div class="form-group width-fifty-left" style="clear:both;">
                            	<label for="postal_code" class="control-label">Postcode</label>
								<input type="text" class="form-control" id="postal_code" name="postal_code"  placeholder="Postcode" >
						 </div>
                            
                         <div class="form-group width-fifty-right">
                            <label for="phone" class="control-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone"  placeholder="Phone" required>
                        </div>
                        
                        <div class="form-group width-fifty-left">
                            <label for="email" class="control-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email"  placeholder="Email" data-parsley-type="email" required>
                        </div>
                            
                          <div class="form-group width-fifty-right">
                              <label for="gender" class="control-label">Gender</label>
                              <select name="gender" id="gender" class="form-control" required>
                                <option value="">Select one</option>
                                <?php foreach($genderList as $gK=>$gV){?>
                                <option value="<?=$gK?>"><?=$gV?></option>
                                <?php } ?>
                              </select>
                          </div>
                          
                          <div class="form-group width-fifty-left">
								<label for="i_name" class="control-label">Incharge name</label>
								<input type="text" class="form-control" id="i_name" name="i_name" placeholder="Incharge name">
						  </div>
                          
                          <div class="form-group width-fifty-right">
								<label for="i_phone" class="control-label">Incharge phone</label>
								<input type="text" class="form-control" id="i_phone" name="i_phone"  placeholder="Incharge phone">
							</div>
							
                            <div class="form-group width-fifty-left">
								<label for="i_email" class="control-label">Incharge email</label>
								<input type="text" class="form-control" id="i_email" name="i_email"  placeholder="Incharge email" data-parsley-type="email">
							</div>
              
							 </form>
						</div>
						
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-sm-8">
                                    <button class="btn-raised btn-primary btn" id="submitBtnCreateGuardian">Submit</button>
                                    <img src="<?=loadingImagePath()?>" id="formCreateGuardianProcess" style="display:none;">
                                </div>
                            </div>
						</div>
                        
				</div>
				
			</div>
		</div>
	</div>
  </div>
  </div>