<?php
$shaStatusList=shaStatusList();
$loggedInUser=loggedInUser();
$user_type=$loggedInUser['user_type'];
if($user_type==2)
	$employee_details=employee_details($loggedInUser['id']);

$guardianshipDateNotSet=false;
if(!empty($formTwo) && $formTwo['guardianship']=='1' && ($formTwo['guardianship_startDate']=='0000-00-00' || $formTwo['guardianship_endDate']=='0000-00-00'))
	$guardianshipDateNotSet=true;

if($status!='rejected' && $status!='cancelled')	
{
?>
                      <div class="m-n form-group">
                          <label class="control-label">Status</label>
                              <select class="form-control" id="shaChangeStatus_status" name="shaChangeStatus_status">
                                  <?php foreach($shaStatusList as $sK=>$sV){
									  
									  if($status=='new' && ($sK=='approved_with_payment' || $sK=='approved_without_payment'))
									  	continue;
 									  if($status=='pending_invoice' && ($sK=='new'))
									  	continue;
									  if(($status=='approved_with_payment' || $status=='approved_without_payment') && ( $sK=='pending_invoice' || $sK=='rejected'))
									  	continue;	
									  ?>
                                              <option value="<?=$sK?>" <?php if($status==$sK){echo 'selected="selected"';}?>><?=$sV?></option>
                                          <?php } ?>
                              </select>
                      </div>

                     <div id="shaAssignClientDiv" style="display:none;">
                      <?php
                      	$clientsList=clientsList();
						            $officeList=officeList();
						            $employeeList=employeeList();
					             ?>
                      <?php if($client==0) {?>
                          <div class="m-n form-group <?php  if($employee==0){?>col-xs-6x<?php } ?>">
                              <label class="control-label">Assign client</label>
                                  <select class="form-control" id="shaChangeStatus_client" name="shaChangeStatus_client" required>
	                                  <option value="">Select client</option>
                                      <?php foreach($clientsList as $cLK=>$cLV){?>
                                                  <option value="<?=$cLV['id']?>"><?=$cLV['bname']?></option>
                                              <?php } ?>
                                  </select>
                          </div>
                          <?php }else{?>
                          	<input type="hidden" name="shaChangeStatus_client" value="<?=$client?>" />
                          <?php } ?>

                          <?php
						  		if($employee==0){
							  ?>
                          <div class="m-n form-group <?php  if($client==0){?>col-xs-6y<?php } ?>">
                              <label class="control-label">Assign employee</label>
                                  <select class="form-control" id="shaChangeStatus_employee" name="shaChangeStatus_employee"  required>
                                  		<option value="">Select employee</option>
                                        <?php foreach($employeeList as $eLK=>$eLV) {?>
	                                        <option value="<?=$eLV['id']?>"><?=ucwords($eLV['fname'].' '.$eLV['lname'])?></option>
                                        <?php } ?>
                                  </select>
                          </div>
                          <?php }else{?>
                          	<input type="hidden" name="shaChangeStatus_employee" value="<?=$employee?>" />
                          <?php } ?>
                      </div>


                      <div class="pl-n m-n form-group col-xs-12"  id="shaChangeStatus_dateDiv" <?php if($status!='cancelled'){?>style="display:none;"<?php } ?>>
                          <label class="control-label">Cancellation date</label>
                          <div class="input-group date">
                              <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
                              <input type="text" class="form-control"  name="shaChangeStatus_date" id="dateChangeStatus_date" value="<?php if($date_cancelled=='0000-00-00'){echo date('d/m/Y');}else{echo date('d/m/Y',strtotime($date_cancelled));}?>">
                          </div>
                      </div>

                     <div class="m-n form-group" id="shaChangeStatus_reasonDiv" <?php if($status!='rejected' && $status!='cancelled'){?>style="display:none;clear:both;"<?php } ?>>
                          <label class="control-label">Reason</label>
                            <textarea class="form-control" name="hfaChangeStatus_reason"><?=trim($reason)?></textarea>
                      </div>

	   <input type="hidden" name="shaChangeStatus_id" id="shaChangeStatus_id" value="<?=$id?>" />
       <input type="hidden" name="pageStatus" value="<?=$pageStatus?>" id="pageStatus" />
       <p id="shaChangeStatusPendingInvInfoMsg" class="changeStatusWarningMsg" style="display:none;">By changing status to Pending invoice, an initial invoice will be generated in Invoices section for this application.</p>
       <p id="shaChangeStatusBookingFromErrorMsg" class="changeStatusWarningMsg" style="display:none;">This application is a part of group invoicing client. To change the status to pending invoice booking start date is required.</p>
<?php } else {?>
	<p>You cannot change the status of a rejected or cancelled application.</p>
<?php } ?>

<?php if($guardianshipDateNotSet){?>
	<input type="hidden" name="guardianshipDateNotSet" value="1" />
    <p id="shaChangeStatusGshipDateInfoMsg" class="changeStatusWarningMsg" style="display:none;">You can't change status to Pending invoice as long as caregiving start date is not defined.</p>
<?php } ?>

<input type="hidden" id="shaChangeStatusAppStep" value="<?=$step?>"/>

       <script type="text/javascript">
	   $(document).ready(function(){
		   
		   var step=$('#shaChangeStatusAppStep').val();
		   var shaStatus='<?=$status?>';
		   if(shaStatus=='rejected' ||shaStatus=='cancelled')
		   {
			   $('#shaChangeStatusSubmit').hide();
			   $('#shaChangeStatusClose').show();
		   }
		   else
		   {
			   		$('#shaChangeStatusSubmit').show();
			   		$('#shaChangeStatusClose').hide();
			}
		   
		   $('#dateChangeStatus_date').datepicker({
			orientation: "top",
			todayHighlight: true,
	    	startDate: "-0d",
			format:'dd/mm/yyyy',
			autoclose:true
		});

		   $('#shaChangeStatus_office').change(function(){
			   		var submitBtn=$('#shaChangeStatusSubmit');
					submitBtn.hide();
			   		$.ajax({
							url:site_url+'account/getEmployeeByOffice/'+$(this).val(),
							success:function(data)
								{
									$('#shaChangeStatus_employee').html(data);
									submitBtn.show();
								}
						});
			   });

		   });
	   </script>
