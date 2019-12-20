<?php
$stateList=stateList();
$genderList=genderList();
?>
<div class="page-heading"><h1>Edit caregiver</h1></div>

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
                                <input type="text" class="form-control" id="fname" name="fname" value="<?=$guardian['fname']?>" placeholder="First name" required>
							</div>
                            
                            <div class="form-group width-fifty-right">
								<label for="lname" class="control-label">Last name</label>
                            	<input type="text" class="form-control" id="lname" name="lname" value="<?=$guardian['lname']?>"  placeholder="Last name" required>
                            </div>
                            
                            <div class="form-group width-fifty-left">
								<label for="cname" class="control-label">Company name</label>
								<input type="text" class="form-control" id="cname" name="cname" value="<?=$guardian['company_name']?>" placeholder="Company name" required <?php if($guardian['id']==8){echo "readonly";}?>>
							</div>
							<div class="form-group width-fifty-right">
								<label for="abn" class="control-label">ABN</label>
								<input type="text" class="form-control" id="abn" name="abn" value="<?=$guardian['abn']?>"  placeholder="ABN">
							</div>
							
                            <div class="form-group width-full">
                            	<label for="address" class="control-label">Street address</label>
								<input type="text" class="form-control" id="address" name="address" value="<?=$guardian['street_address']?>"  placeholder="Street address" >
							</div>
                            
                            <div class="form-group width-fifty-left">
                            	<label for="suburb" class="control-label">Suburb</label>
								<input type="text" class="form-control" id="suburb" name="suburb" value="<?=$guardian['suburb']?>"  placeholder="Suburb" >
							</div>
							
                          <div class="form-group width-fifty-right">
                              <label class="col-sm-2 control-label" for="category">State</label>
                              <select class="form-control" id="state" name="state">
	                              <option value="">Select one</option>
                                <?php foreach($stateList as $stateK=>$stateV){?>
                                          <option value="<?=$stateK?>" <?php if($guardian['state']==$stateK){echo 'selected="selected"';}?>><?=$stateV?></option>
                                <?php } ?>
                              </select>
                          </div>
                          
                          <div class="form-group width-fifty-left" style="clear:both;">
                            	<label for="postal_code" class="control-label">Postcode</label>
								<input type="text" class="form-control" id="postal_code" name="postal_code" value="<?=$guardian['postal_code']?>"  placeholder="Postcode" >
						 </div>
                            
                         <div class="form-group width-fifty-right">
                            <label for="phone" class="control-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?=$guardian['phone']?>"  placeholder="Phone" required>
                        </div>
                        
                        <div class="form-group width-fifty-left">
                            <label for="email" class="control-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email"  value="<?=$guardian['email']?>" placeholder="Email" data-parsley-type="email" required>
                        </div>
                            
                          <div class="form-group width-fifty-right">
                              <label for="gender" class="control-label">Gender</label>
                              <select name="gender" id="gender" class="form-control" required>
                                <option value="">Select one</option>
                                <?php foreach($genderList as $gK=>$gV){?>
                                <option value="<?=$gK?>" <?php if($guardian['gender']==$gK){echo 'selected="selected"';}?>><?=$gV?></option>
                                <?php } ?>
                              </select>
                          </div>
                          
                          <div class="form-group width-fifty-left">
								<label for="i_name" class="control-label">Incharge name</label>
								<input type="text" class="form-control" id="i_name" name="i_name" value="<?=$guardian['incharge_name']?>" placeholder="Incharge name">
						  </div>
                          
                          <div class="form-group width-fifty-right">
								<label for="i_phone" class="control-label">Incharge phone</label>
								<input type="text" class="form-control" id="i_phone" name="i_phone" value="<?=$guardian['incharge_phone']?>"  placeholder="Incharge phone">
							</div>
							
                            <div class="form-group width-fifty-left">
								<label for="i_email" class="control-label">Incharge email</label>
								<input type="text" class="form-control" id="i_email" name="i_email"  placeholder="Incharge email" value="<?=$guardian['incharge_email']?>" data-parsley-type="email">
							</div>
               				<input type="hidden" name="id" id="id" value="<?=$guardian['id']?>" />
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