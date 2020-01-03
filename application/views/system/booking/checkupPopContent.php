<?php
$employeeList=employeeList();
$checkupMethodList=checkupMethodList();
$loggedInUser=loggedInUser();
?>
					<div class="pl-n m-n form-group col-xs-12">
                          <label class="control-label">Staff name who did the check</label>
                              <select class="form-control" id="bookCheckup_emp" name="bookCheckup_emp" required <?php if($loggedInUser['user_type']=='2'){echo "disabled";}?>>
                              <option value="" >Select employee</option>
                                  <?php
                                  foreach($employeeList as $emp)
								  {
								  	?>
                                  <option value="<?=$emp['id']?>" <?php if(isset($checkup)){if($checkup['employee']==$emp['id']){echo 'selected';}}elseif($loggedInUser['user_type']=='2' && $loggedInUser['id']==$emp['id']){echo 'selected';}?>><?=$emp['fname'].' '.$emp['lname']?></option>
                                  <?php
								  }
								  ?>
                               </select>
                      </div>
                      
                        <div class="pl-n m-n form-group col-xs-6">
                            <label class="control-label">Date of check</label>
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
                                <input type="text" class="form-control"  name="bookCheckup_date" id="bookCheckup_date" value="<?php if(isset($checkup)){echo date('d/m/Y',strtotime($checkup['checkup_date']));}?>" required>
                            </div>
                        </div>
                        
                        <div class="pl-n m-n form-group col-xs-6">
                          <label class="control-label">Method of check</label>
                              <select class="form-control" id="bookCheckup_method" name="bookCheckup_method" required>
                              		<option value="" >Select method</option>
                                  <?php
                                  foreach($checkupMethodList as $cmlK=>$cml)
								  {
								  	?>
                                  <option value="<?=$cmlK?>" <?php if(isset($checkup) && $checkup['method']==$cmlK){echo 'selected';}?>><?=$cml?></option>
                                  <?php
								  }
								  ?>
                               </select>
                      </div>
                        
                         
					<?php if(isset($checkup)){?>
                        <input type="hidden" name="bookingCheckup_id" id="bookingCheckup_id" value="<?=$checkup['id']?>" />
                        <input type="hidden" name="bookingCheckup_bookingId" id="bookingCheckup_bookingId" value="<?=$checkup['booking']?>" />
                    	<input type="hidden" name="bookingCheckup_type" id="bookingCheckup_type" value="<?=$checkup['method']?>">
                    <?php }
					else{?>
                    	<input type="hidden" name="bookingCheckup_type" id="bookingCheckup_type" value="">
	                    <input type="hidden" name="bookingCheckup_bookingId" id="bookingCheckup_bookingId" value="<?=$booking_id?>" />
                    <?php } ?>
                    
                 <?php if($loggedInUser['user_type']=='2'){?>
				  	<input type="hidden" name="bookCheckup_emp" value="<?php if(isset($checkup)){ echo $checkup['employee'];}else{ echo $loggedInUser['id'];}?>" />
				 <?php } ?>
<script>

	$(document).ready(function(){
		$('#bookCheckup_date').datepicker({
			orientation: "bottom",
			todayHighlight: true,
			format:'dd/mm/yyyy',
			autoclose:true
		});
	});
		
</script>                    