<?php
$stateList=stateList();
$clientCategories=clientCategories();
$clientGroupList=clientGroupList();
?>
<div class="page-heading"><h1>Add new client</h1></div>

<div class="container-fluid">
                                
<div data-widget-group="group1">
	<div class="row">
    
      <div class="col-sm-3">
          <div class="panel panel-profile panel-bluegraylight" data-widget='{"draggable": "false"}'>
          <div class="panel-heading">
                                          <h2>Client Type</h2>
                                      </div>
              <div class="panel-body">
                  <form class="" id="formCreateClientCategory">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="category">Type</label>
                        <select class="form-control" id="category" name="category" onchange="$('#clientCategory').val(this.value);" required>
		                        <option value="">Select one</option>
                                <?php foreach($clientCategories as $catK=>$catV){?>	
                                   <option value="<?=$catK?>"><?=$catV?></option>
                                <?php } ?>
                        </select>
                    </div>
                    <div class="form-group client-checkbox" id="create_client_commissionDiv" style="display:none;">
					
						<div class="checkbox checkbox-primary">
							<label>
								<input type="checkbox" name="commission" id="commission" >
								This agent is enrolled for commission program
							</label>
						</div>
                        
                        <div id="create_client_commissionValDiv" style="display:none;">
                            <label>Enter commission rate($)</label>
                            <input id="commission_value" value="50"  name="commission_value" required data-parsley-type="number">
                        </div>
				</div>
                
                    <div class="form-group client-checkbox" id="create_client_GroupInvDiv" style="display:none;">
					
						<div class="checkbox checkbox-primary">
							<label>
								<input type="checkbox" name="groupInvEnroll" id="groupInvEnroll" >
								This client is enrolled for group invoices
							</label>
						</div>
                        
                        <div id="create_client_GroupInvValDiv" class="checkbox checkbox-primary child" style="display:none; ">
                        	<label>
								Options for invoices
							</label><br />
                            <label style="margin-bottom:5px;">
								<input type="checkbox" name="groupInvEnrollPlacementFee" id="groupInvEnrollPlacementFee" checked>
								Placement fee
							</label><br />
                            <label>
								<input type="checkbox" name="groupInvEnrollAPU" id="groupInvEnrollAPU" checked>
								APU
							</label><br />
                            <label>
								<input type="checkbox" name="groupInvEnrollAccomodationFee" id="groupInvEnrollAccomodationFee" checked>
								Accomodation fee
							</label>
                        </div>
				</div>
                 
                 
                 <div class="form-group">
                        <label class="col-sm-2 control-label" for="clientGroup">Client Group</label>
                        <select class="form-control" id="clientGroup" name="clientGroup" onchange="$('#clientGroupVal').val(this.value);" >
		                        <option value="">Select one</option>
                                <?php foreach($clientGroupList as $groupK=>$groupV){?>	
                                   <option value="<?=$groupK?>"><?=$groupV?></option>
                                <?php } ?>
                        </select>
                    </div>
                     
                  </form>
              </div>
          </div>
      </div>
    
	<div class="col-sm-9">
			
			<div class="panel panel-primary" data-widget='{"draggable": "false"}'>
				<div class="panel-body">
							
							<form class="" id="formCreateClient">
                            	<div class="form-group width-fifty-left">
								<label for="bname" class="control-label">Business name</label>
								<input type="text" class="form-control" id="bname" name="bname" placeholder="Business name" required>
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
                              <label class="col-sm-2 control-label" for="state">State</label>
                              <input type="text" class="form-control" id="state" name="state"  placeholder="State" >
                              <!--<select class="form-control" id="state" name="state">
	                              <option value="">Select one</option>
                                <?php foreach($stateList as $stateK=>$stateV){?>
                                          <option value="<?=$stateK?>"><?=$stateV?></option>
                                <?php } ?>
                              </select>-->
                          </div>
                          
                          
                          <div class="form-group width-fifty-left" style="clear:both">
                              <label class="col-sm-2 control-label" for="country">Country</label>
                              <input type="text" class="form-control" id="country" name="country"  placeholder="Country" >
                          </div>
                          
                          <div class="form-group width-fifty-right">
                            	<label for="postal_code" class="control-label">Postcode</label>
								<input type="text" class="form-control" id="postal_code" name="postal_code"  placeholder="Postcode" >
						 </div>
                            
							<div class="form-group width-fifty-left">
								<label for="p_name" class="control-label">Primary contact first name</label>
                                <input type="text" class="form-control" id="p_name" name="p_name"  placeholder="First name" required>
							</div>
                            
                            <div class="form-group width-fifty-right">
								<label for="p_lname" class="control-label">Primary contact last name</label>
                            	<input type="text" class="form-control" id="p_lname" name="p_lname"  placeholder="Last name" required>
                            </div>
                            
                            <div class="form-group width-fifty-left">
								<label for="p_phone" class="control-label">Primary contact phone</label>
								<input type="text" class="form-control" id="p_phone" name="p_phone"  placeholder="Primary contact phone" required>
							</div>
							
                            <div class="form-group width-fifty-right">
								<label for="p_email" class="control-label">Primary contact email</label>
								<input type="text" class="form-control" id="p_email" name="p_email"  placeholder="Primary contact email" data-parsley-type="email" required>
							</div>
							
							<div class="form-group width-fifty-left">
								<label for="s_name" class="control-label">Secondary contact firs tname</label>
								<input type="text" class="form-control" id="s_name" name="s_name"  placeholder="Secondary contact first name">
							</div>
                            <div class="form-group width-fifty-right">
								<label for="s_lname" class="control-label">Secondary contact last name</label>
								<input type="text" class="form-control" id="s_lname" name="s_lname"  placeholder="Secondary contact last name">
							</div>
                            
                            <div class="form-group width-fifty-left">
								<label for="s_phone" class="control-label">Emergency contact phone</label>
								<input type="text" class="form-control" id="s_phone" name="s_phone"  placeholder="Emergency contact phone">
							</div>
                            
                            <div class="form-group width-fifty-right">
								<label for="abn" class="control-label">Secondary contact email</label>
								<input type="text" class="form-control" id="s_email" name="s_email"  placeholder="Secondary contact email" data-parsley-type="email">
							</div>
                            
                            <div class="form-group" style="clear:both;">
								<label class="control-label">Notes</label>
								<textarea  rows="4" class="form-control" id="notes" name="notes"></textarea>
							</div>
                            
                            <input type="hidden" name="category" id="clientCategory" value="" />
                            <input type="hidden" name="clientGroup" id="clientGroupVal" value="" />
                            </form>
						</div>
						
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-sm-8">
                                    <button class="btn-raised btn-primary btn" id="submitBtnCreateClient">Submit</button>
                                    <img src="<?=loadingImagePath()?>" id="formCreateClientProcess" style="display:none;">
                                </div>
                            </div>
						</div>
                        
				</div>
				
			</div>
		</div>
	</div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$("input#commission_value").TouchSpin({
		  verticalbuttons: true,
		  min: 1
		});
		
	$('#category')	.change(function(){
		if($(this).val()=='2')
		{
			$('#create_client_commissionDiv').slideDown();
			$('#create_client_GroupInvDiv, #create_client_GroupInvValDiv').slideUp();
			$('#groupInvEnroll').prop('checked', false);
		}
		else if($(this).val()=='3' || $(this).val()=='4')
		{
			$('#create_client_GroupInvDiv').slideDown();
			$('#create_client_commissionDiv, #create_client_commissionValDiv').slideUp();
			$('#commission').prop('checked', false);
		}
		else	
		{
			$('#create_client_commissionDiv, #create_client_commissionValDiv').slideUp();
			$('#create_client_GroupInvDiv, #create_client_GroupInvValDiv').slideUp();
			$('#commission').prop('checked', false);
			$('#groupInvEnroll').prop('checked', false);
		}
	});
	
	$('#commission').click(function(){
		if($(this).is(':checked'))
			$('#create_client_commissionValDiv').slideDown();
		else
			$('#create_client_commissionValDiv').slideUp();
	});
	
	$('#groupInvEnroll').click(function(){
		if($(this).is(':checked'))
			$('#create_client_GroupInvValDiv').slideDown();
		else
			$('#create_client_GroupInvValDiv').slideUp();
	});
	
});
</script>