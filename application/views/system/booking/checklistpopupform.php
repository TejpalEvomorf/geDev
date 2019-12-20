<?php //see($pinfo); ?>
<div class="m-n form-group">
                          <label class="control-label">Person who sent the profile</label>
                              <select class="form-control" id="employee-account" name="employee-account">
                               <option value="">Employee account</option>
							   <?php foreach($employees as $clientK=>$clientV){?>
							   <option value="<?=$clientV['id'] ?>" <?=  !empty($pinfo['emp_id']) && ($pinfo['emp_id']== $clientV['id'] )?'selected' :'' ?>><?=ucwords($clientV['fname'].' '.$clientV['lname'])?></option>
							   <?php }?>
							</select>
							<input type="hidden" name="bookid" id="bookid" value="<?= @$id ?>"/>
							<input type="hidden" name="type" value="<?= @$type ?>"/>
      </div>
      <div class="m-n form-group">
						  <label class="control-label">Date sent</label>
							  <input class="form-control" id="profilechecklistdate" name="profilechecklistdate" value="<?php echo !empty($pinfo['ckecklist_date'])? $pinfo['ckecklist_date'] :  date('d/m/Y')?>" type="text">
		<span class="material-input"></span></div>
		
		<script>
		$(document).ready(function(){
		$('#profilechecklistdate').datepicker({
			orientation: "top",
			todayHighlight: true,
	    	startDate: "-0d",
			format:'dd/mm/yyyy',
			autoclose:true
		});
		});
		
		</script>