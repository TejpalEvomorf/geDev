<?php
$stateList=stateList();
?>
<div class="page-heading"><h1><?php if(isset($company)){echo 'Edit';}else{echo 'Add new';}?> caregiver company</h1></div>

<div class="container-fluid">
                                
<div data-widget-group="group1">
	<div class="row">
   
	<div class="col-sm-12">
			
			<div class="panel panel-primary" data-widget='{"draggable": "false"}'>
				<div class="panel-body">
							
							<form class="" id="formCreateCGCompany">
                            
                            <div class="form-group width-fifty-left">
								<label for="cname" class="control-label">Company name</label>
								<input type="text" class="form-control" id="CGCname" name="CGCname" placeholder="Company name" value="<?php if(isset($company)){echo $company['name'];}?>" required>
							</div>
							<div class="form-group width-fifty-right">
								<label for="abn" class="control-label">ABN</label>
								<input type="text" class="form-control" id="CGCabn" name="CGCabn"  placeholder="ABN"  value="<?php if(isset($company)){echo $company['abn'];}?>">
							</div>
							
                            <div class="form-group width-full">
                            	<label for="address" class="control-label">Street address</label>
								<input type="text" class="form-control" id="CGCaddress" name="CGCaddress"  placeholder="Street address"  value="<?php if(isset($company)){echo $company['street_address'];}?>">
							</div>
                            
                            <div class="form-group width-fifty-left">
                            	<label for="suburb" class="control-label">Suburb</label>
								<input type="text" class="form-control" id="CGCsuburb" name="CGCsuburb"  placeholder="Suburb"  value="<?php if(isset($company)){echo $company['suburb'];}?>">
							</div>
							
                         <div class="form-group width-fifty-right">
                              <label class="col-sm-2 control-label" for="CGCstate">State</label>
                              <select class="form-control" id="CGCstate" name="CGCstate">
	                              <option value="">Select one</option>
                                <?php foreach($stateList as $stateK=>$stateV){?>
                                          <option value="<?=$stateK?>"  <?php if(isset($company) && $stateK==$company['state']){echo 'selected';}?>><?=$stateV?></option>
                                <?php } ?>
                              </select>
                          </div>
                          
                          <div class="form-group width-fifty-left" style="clear:both;">
                            	<label for="postal_code" class="control-label">Postcode</label>
								<input type="text" class="form-control" id="CGCpostal_code" name="CGCpostal_code"  placeholder="Postcode"  value="<?php if(isset($company) && $company['postcode']!=0){echo $company['postcode'];}?>">
						 </div>
                          
                          <div class="form-group width-fifty-right">
								<label for="i_name" class="control-label">Incharge name</label>
								<input type="text" class="form-control" id="CGCi_name" name="CGCi_name" placeholder="Incharge name"  value="<?php if(isset($company)){echo $company['i_name'];}?>" required>
						  </div>
                          
                          <div class="form-group width-fifty-left">
								<label for="i_phone" class="control-label">Incharge phone</label>
								<input type="text" class="form-control" id="CGCi_phone" name="CGCi_phone"  placeholder="Incharge phone"  value="<?php if(isset($company)){echo $company['i_phone'];}?>" required>
							</div>
							
                            <div class="form-group width-fifty-right">
								<label for="i_email" class="control-label">Incharge email</label>
								<input type="text" class="form-control" id="CGCi_email" name="CGCi_email"  placeholder="Incharge email" data-parsley-type="email"  value="<?php if(isset($company)){echo $company['i_email'];}?>" required>
							</div>
              				  <?php if(isset($company)){?>
                              	<input type="hidden" id="id" name="id" value="<?=$company['id']?>">
							  <?php } ?>
							 </form>
						</div>
						
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-sm-8">
                                    <button class="btn-raised btn-primary btn" id="submitBtnCGC">Submit</button>
                                    <img src="<?=loadingImagePath()?>" id="submitBtnCGCProcess" style="display:none;">
                                </div>
                            </div>
						</div>
                        
				</div>
				
			</div>
		</div>
	</div>
  </div>
  </div>