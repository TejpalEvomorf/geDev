<?php
$employeeList=employeeList();
$loggedInUser=loggedInUser();
?>
                      <div class="m-n form-group">
                           
						   <div class="m-n form-group">
					<label  for="notes_title"class="control-label">Subject</label>
					<input type="text" class="form-control"  id="notes_title" name="note_title" value="<?php  echo @$not['note_title'] ?>" required/>
					<input type="hidden" name="sha_id" id="hfanoteid" value="<? echo $formOne?>" />
					<input type="hidden" name="not_id" id="notid" value="<?php  echo @$not['id'] ?>" />
				</div>
                
                <div class="pl-n m-n form-group col-xs-6">
                    <label class="control-label">Date</label>
                    <div class="input-group date">
                        <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
                        <input type="text" class="form-control notes_date"  name="notes_date" id="notes_date" value="<?php  if(isset($not)){if($not['note_date']!='0000-00-00'){echo date('d/m/Y',strtotime($not['note_date']));}else{echo  date('d M Y',strtotime($not['note_created']));}} ?>" required>
                    </div>
                </div>
                <div class="pl-n m-n form-group col-xs-6">
                  <label class="control-label">Employee</label>
                  
                 <?php if($loggedInUser['user_type']=='2'){?>
				  	<input type="hidden" name="notes_emp" value="<?php if(isset($not)){ echo $not['employee'];}else{ echo $loggedInUser['id'];}?>" />
				 <?php } ?>
                      <select class="form-control" id="notes_emp" name="notes_emp" required <?php if($loggedInUser['user_type']=='2'){echo "disabled";}?>>
                             <option value="" >Select employee</option>
                                  <?php
                                  foreach($employeeList as $emp)
								  {
								  	?>
                                  <option value="<?=$emp['id']?>" <?php if(isset($not)){if($not['employee']==$emp['id']){echo 'selected';}}elseif($loggedInUser['user_type']=='2' && $loggedInUser['id']==$emp['id']){echo 'selected';}?>><?=$emp['fname'].' '.$emp['lname']?></option>
                                  <?php
								  }
								  ?>
                               </select>
                </div>
                
				<div class="m-n form-group" style="clear:both;">
					<label class="control-label">Notes description</label>
					<textarea  rows="4" class="form-control" id="notes_family" name="notes_family"><?php  echo @$not['notes_family'] ?></textarea>
				</div>
				 
                      </div>
 <script>

	$(document).ready(function(){
		$('.notes_date').datepicker({
			orientation: "bottom",
			todayHighlight: true,
			format:'dd/mm/yyyy',
			autoclose:true
		});
	});
		
</script>   
                      
   