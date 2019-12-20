<?php
$employeeList=employeeList();
$loggedInUser=loggedInUser();
?>
					<div class="pl-n m-n form-group col-xs-12">
                          <label class="control-label">Holiday reported by</label>
                              <select class="form-control" id="bookHoliday_emp" name="bookHoliday_emp" required <?php if($loggedInUser['user_type']=='2'){echo "disabled";}?>>
                              <option value="" >Select employee</option>
                                  <?php
                                  foreach($employeeList as $emp)
								  {
								  	?>
                                  <option value="<?=$emp['id']?>" <?php if(isset($holiday)){if($holiday['employee']==$emp['id']){echo 'selected';}}elseif($loggedInUser['user_type']=='2' && $loggedInUser['id']==$emp['id']){echo 'selected';}?>><?=$emp['fname'].' '.$emp['lname']?></option>
                                  <?
								  }
								  ?>
                               </select>
                               <?php if($loggedInUser['user_type']=='2'){?>
				  			   	<input type="hidden" name="bookHoliday_emp" value="<?php if(isset($holiday)){ echo $holiday['employee'];}else{ echo $loggedInUser['id'];}?>" />
				 			   <?php } ?>
                      </div>
                      
                        <div class="pl-n m-n form-group col-xs-6">
                            <label class="control-label">Start from</label>
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
                                <input type="text" class="form-control"  name="bookHoliday_startDate" id="bookHoliday_startDate" value="<?php if(isset($holiday)){echo date('d/m/Y',strtotime($holiday['start']));}?>" required>
                            </div>
                        </div>
                      
                        <div class="pl-n m-n form-group col-xs-6">
                            <label class="control-label">End date</label>
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
                                <input type="text" class="form-control"  name="bookHoliday_endDate" id="bookHoliday_endDate" value="<?php if(isset($holiday)){echo date('d/m/Y',strtotime($holiday['end']));}?>" required>
                            </div>
                        </div>
                        
                        <div class="m-n form-group" style="clear:both;">
                        <label class="control-label">Notes</label>
                        <textarea  rows="4" class="form-control" id="bookHoliday_notes" name="bookHoliday_notes"><?php if(isset($holiday)){echo $holiday['notes'];}?></textarea>
                    </div>                      
                                          
                    
                        
					<?php if(isset($holiday)){?>
                        <input type="hidden" name="bookingHoliday_id" value="<?=$holiday['id']?>" />
                        <input type="hidden" name="bookingHoliday_bookingId" value="<?=$holiday['booking_id']?>" />
                        <input type="hidden" name="bookingHoliday_poId" value="<?=$holiday['po_id']?>" />
                        <input type="hidden" name="bookingHoliday_poItemId" value="<?=$holiday['po_item_id']?>" />
                        <input type="hidden" name="bookingHoliday_invoiceId" value="<?=$holiday['invoice_id']?>" />
                        <input type="hidden" name="bookingHoliday_invoiceItemId" value="<?=$holiday['invoice_item_id']?>" />
                    <?php }
					else{?>
	                    <input type="hidden" name="bookingHoliday_bookingId" value="<?=$booking_id?>" />
                    <?php } ?>
                 
<script>

	$(document).ready(function(){
		
		$('#bookHoliday_startDate, #bookHoliday_endDate').datepicker({
			orientation: "top",
			todayHighlight: true,
			format:'dd/mm/yyyy',
			autoclose:true
		});
		
	});
		
</script>                    