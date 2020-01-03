<?php
$employeeList=employeeList();
$incidentStatusList=incidentStatusList();
$incidentLevelList=incidentLevelList();
$incidentLevelDescList=incidentLevelDescList();
$loggedInUser=loggedInUser();
?>
					<div class="pl-n m-n form-group col-xs-12">
                          <label class="control-label">Incident reported by</label>
                              <select class="form-control" id="bookIncident_emp" name="bookIncident_emp" required <?php if($loggedInUser['user_type']=='2'){echo "disabled";}?>>
                              <option value="" >Select employee</option>
                                  <?php
                                  foreach($employeeList as $emp)
								  {
								  	?>
                                  <option value="<?=$emp['id']?>" <?php if(isset($incident)){if($incident['employee']==$emp['id']){echo 'selected';}}elseif($loggedInUser['user_type']=='2' && $loggedInUser['id']==$emp['id']){echo 'selected';}?>><?=$emp['fname'].' '.$emp['lname']?></option>
                                  <?php
								  }
								  ?>
                               </select>
                               <?php if($loggedInUser['user_type']=='2'){?>
				  			   	<input type="hidden" name="bookIncident_emp" value="<?php if(isset($incident)){ echo $incident['employee'];}else{ echo $loggedInUser['id'];}?>" />
				 			   <?php } ?>
                      </div>
                      
                        <div class="pl-n m-n form-group col-xs-6">
                            <label class="control-label">Incident date</label>
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
                                <input type="text" class="form-control"  name="bookIncident_date" id="bookIncident_date" value="<?php if(isset($incident)){echo date('d/m/Y',strtotime($incident['incident_date']));}?>" required>
                            </div>
                        </div>
                        
                        <div class="pl-n m-n form-group col-xs-6">
                          <label class="control-label">Incident status</label>
                              <select class="form-control" id="bookIncident_status" name="bookIncident_status" required>
                             <!-- <option value="" >Select status</option>-->
                                  <?php
                                  foreach($incidentStatusList as $inStatusK=>$inStatus)
								  {
								  	?>
                                  <option value="<?=$inStatusK?>" <?php if(isset($incident) && $incident['status']==$inStatusK){echo 'selected';}?>><?=$inStatus?></option>
                                  <?php
								  }
								  ?>
                               </select>
                      </div>
                        
                        <div class="pl-n m-n form-group col-xs-12">
                          <label class="control-label">Incident level</label>
                               
                              <select style="float:left; width:95%;" class="form-control" id="bookIncident_level" name="bookIncident_level" required>
                              <option value="" >Select level</option>
                                  <?php
                                  foreach($incidentLevelList as $inLevelK=>$inLevel)
								  {
								  	?>
                                  <option value="<?=$inLevelK?>" <?php if(isset($incident) && $incident['level']==$inLevelK){echo 'selected';}?>><?=$inLevel?></option>
                                  <?php
								  }
								  ?>
                               </select>
                               <i id="bookIncident_level_toolTip" class="fa fa-info-circle colorBlue" data-placement="top" data-toggle="tooltip"  data-original-title="" style="float:right;margin-top:18px; font-size: 22px;"></i>
                      </div>
                      
                        
                        <div class="pl-n m-n form-group col-xs-12" id="bookIncident_levelOtherDiv" <?php if(!isset($incident) || (isset($incident) && $incident['level']!='9')){?>style="display:none;"<?php } ?>>
                          <label class="control-label">Other type of incident level</label>
                          <input type="text" class="form-control" name="bookIncident_levelOther" value="<?php if(isset($incident) && $incident['level']=='9'){echo $incident['level_other'];}?>">
                      </div>
                      
                    <div class="m-n form-group" style="clear:both;">
                        <label class="control-label">Incident Details</label>
                        <textarea  rows="4" class="form-control" id="bookIncident_details" name="bookIncident_details" required><?php if(isset($incident)){echo $incident['details'];}?></textarea>
                    </div>                      
                    <!--<div class="m-n form-group">
                        <label class="control-label">Incident follow up</label>
                        <textarea  rows="4" class="form-control" id="bookIncident_followUp" name="bookIncident_followUp"><?php if(isset($incident)){echo $incident['follow_up'];}?></textarea>
                    </div>-->                      
                    <div class="m-n form-group">
                        <label class="control-label">Incident outcome</label>
                        <textarea  rows="4" class="form-control" id="bookIncident_outcome" name="bookIncident_outcome"><?php if(isset($incident)){echo $incident['outcome'];}?></textarea>
                    </div>
                        
					<?php if(isset($incident)){?>
                        <!--<input type="hidden" name="bookingIncident_id" value="<?=$incident['id']?>" />
                        <input type="hidden" name="bookingIncident_bookingId" value="<?=$incident['booking_id']?>" />-->
                    <?php }
					else{?>
	                    <!--<input type="hidden" name="bookingIncident_bookingId" value="<?=$booking_id?>" />-->
                    <?php } ?>
                    
                     <input type="hidden" name="bookingIncident_id" id="bookingIncident_id" value="<?php if(isset($incident)){echo $incident['id'];}?>" />
                     <input type="hidden" name="bookingIncident_bookingId" value="<?=$booking_id?>" />
                 
<script>

	$(document).ready(function(){
		$('#bookIncident_date').datepicker({
			orientation: "bottom",
			todayHighlight: true,
			format:'dd/mm/yyyy',
			autoclose:true
		});
		
		var incidentLevelDescList=<?=json_encode($incidentLevelDescList)?>;
		
		<?php if(isset($incident)){?>
			$('#bookIncident_level_toolTip').attr('data-original-title',incidentLevelDescList[<?=$incident['level']?>]);
		<?php }else{?>
			$('#bookIncident_level_toolTip').attr('data-original-title',incidentLevelDescList[0]);
		<?php } ?>
		
		$('#bookIncident_level').change(function(){
			var changedLevel=$(this).val();
			if(changedLevel=='')
				changedLevel='0';
			$('#bookIncident_level_toolTip').attr('data-original-title',incidentLevelDescList[changedLevel])
			if(changedLevel=='9')
			{
				$('#bookIncident_levelOtherDiv').slideDown();
				$('#bookIncident_levelOtherDiv > input').attr("required","required");
			}
			else
			{
				$('#bookIncident_levelOtherDiv').slideUp();
				$('#bookIncident_levelOtherDiv > input').removeAttr("required");
			}
		});
	});
		
</script>                    