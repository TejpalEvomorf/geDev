<?php
$shaStatusList=shaStatusList();
$loggedInUser=loggedInUser();
$user_type=$loggedInUser['user_type'];
if($user_type==2)
	$employee_details=employee_details($loggedInUser['id']);

$resolveWarningsFirst=false;
$getTourWarnings=getTourWarnings('all',$id);
if(count($getTourWarnings)>0)
	$resolveWarningsFirst=true;

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
									  if(($status=='approved_with_payment' || $status=='approved_without_payment') && ($sK=='new' || $sK=='pending_invoice' || $sK=='rejected'))
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
                      <?php if($client_id ==0) {?>
                          <div class="m-n form-group">
                              <label class="control-label">Assign client</label>
                                  <select class="form-control" id="shaChangeStatus_client" name="shaChangeStatus_client" >
	                                  <option value="">Select client</option>
                                      <?php foreach($clientsList as $cLK=>$cLV){?>
                                                  <option value="<?=$cLV['id']?>"><?=$cLV['bname']?></option>
                                              <?php } ?>
                                  </select>
                          </div>
                          <?php }else{?>
                          	<input type="hidden" name="shaChangeStatus_client" value="<?=$client_id?>" />
                          <?php } ?>
                    </div>


                      <div class="pl-n m-n form-group col-xs-12"  id="shaChangeStatus_dateDiv" <?php if($status!='cancelled'){?>style="display:none;"<?php } ?>>
                          <label class="control-label">Cancellation date</label>
                          <div class="input-group date">
                              <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
                              <input type="text" class="form-control"  name="shaChangeStatus_date" id="dateChangeStatus_date" value="<?php if($date_status_changed=='0000-00-00 00:00:00'){echo date('d/m/Y');}else{echo date('d/m/Y',strtotime($date_status_changed));}?>">
                          </div>
                      </div>

                     <div class="m-n form-group" id="shaChangeStatus_reasonDiv" <?php if($status!='rejected' && $status!='cancelled'){?>style="display:none;clear:both;"<?php } ?>>
                          <label class="control-label">Reason</label>
                            <textarea class="form-control" name="hfaChangeStatus_reason"><?=trim($reason)?></textarea>
                      </div>

	                     <input type="hidden" name="shaChangeStatus_id" id="shaChangeStatus_id" value="<?=$id?>" />
                       <input type="hidden" name="pageStatus" value="<?=$pageStatus?>" id="pageStatus" />
					 <p id="shaChangeStatusPendingInvInfoMsg" class="changeStatusWarningMsg" style="display:none;">By changing status to Pending invoice, initial group invoice will be generated in Invoices section for all applications in this tour.</p>
 <?php } else {?>
	<p>You cannot change the status of a rejected or cancelled tour.</p>
<?php } ?>

<?php if($resolveWarningsFirst){?>
	<input type="hidden" name="warningsNotReloved" value="1" />
    <p id="tourChangeStatusWarningsInfoMsg" class="changeStatusWarningMsg" style="display:none;">You can only change status to Pending invoice after resolving all warnings.</p>
<?php } ?>
     
       <script type="text/javascript">
    	   $(document).ready(function(){
			   
			    var shaStatus='<?=$status?>';
		   if(shaStatus=='rejected' ||shaStatus=='cancelled')
		   {
			   $('#tourChangeStatusSubmit').hide();
			   $('#shaChangeStatusClose').show();
		   }
		   else
		   {
			   $('#tourChangeStatusSubmit').show();
			   $('#shaChangeStatusClose').hide();
		   }
			   
    		    $('#dateChangeStatus_date').datepicker({
    			    orientation: "top",
    			    todayHighlight: true,
    	    	  startDate: "-0d",
    			    format:'dd/mm/yyyy',
    			    autoclose:true
    		    });
	        });
	   </script>
