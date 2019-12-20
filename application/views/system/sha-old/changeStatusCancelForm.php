<?php
$shaStatusList=shaStatusList();
$loggedInUser=loggedInUser();
$user_type=$loggedInUser['user_type'];
if($user_type==2)
	$employee_details=employee_details($loggedInUser['id']);

if($status!='cancelled')	
{	
?>
                      <div class="m-n form-group">
                          <label class="control-label">Status </label>
                              <input type="hidden" id="shaChangeStatus_status" name="shaChangeStatus_status" value="cancelled" />
                               <select class="form-control" id="shaChangeStatus_status" name="shaChangeStatus_status">
                                  <?php foreach($shaStatusList as $sK=>$sV){
									  if($sK!='cancelled')
									  	continue;
									  ?>
                                              <option value="<?=$sK?>" <?php if($status==$sK){echo 'selected="selected"';}?>><?=$sV?></option>
                                          <?php } ?>
                              </select 
                      ></div>

                     <div class="pl-n m-n form-group col-xs-12"  id="shaChangeStatus_dateDiv" >
                          <label class="control-label">Cancellation date</label>
                          <div class="input-group date">
                              <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
                              <input type="text" class="form-control"  name="shaChangeStatus_date" id="dateChangeStatus_date" value="<?php if($date_cancelled=='0000-00-00'){echo date('d/m/Y');}else{echo date('d/m/Y',strtotime($date_cancelled));}?>">
                          </div>
                      </div>

                     <div class="m-n form-group" id="shaChangeStatus_reasonDiv" >
                          <label class="control-label">Reason</label>
                            <textarea class="form-control" name="hfaChangeStatus_reason"><?=trim($reason)?></textarea>
                      </div>

	   <input type="hidden" name="study_tour_id" value="<?=$study_tour_id?>" />
       <input type="hidden" name="shaChangeStatus_id" id="shaChangeStatus_id" value="<?=$id?>" />
       <input type="hidden" name="pageStatus" value="<?=$pageStatus?>" id="pageStatus" />
       <p class="changeStatusWarningMsg">You can only change status of individual application to Cancelled. You can change group status from tour group list.</p>
<?php }else { ?>
	<p>You cannot change the status of a cancelled application.</p>
<?php } ?>
       <script type="text/javascript">
	   $(document).ready(function(){

		   var shaStatus='<?=$status?>';
		   if(shaStatus=='cancelled')
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

		   });
	   </script>
