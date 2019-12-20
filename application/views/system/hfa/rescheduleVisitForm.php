<div class="pl-n m-n form-group col-xs-6">
  <label class="control-label">Visit date</label>
      <div class="input-group date">
          <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
          <input type="text" class="form-control"  name="hfaReschedule_date" id="hfaReschedule_date" value="<?php if($visit_date_time!='0000-00-00 00:00:00'){echo date('d/m/Y',strtotime($visit_date_time));}?>" required>
      </div>
</div>



<div class="pr-n m-n form-group">
  <label class="control-label">Visit time</label>
  <div class="input-group bootstrap-timepicker">
          <div class="input-group-addon"><i class="colorDarkgreen material-icons">query_builder</i></div>
          <input type="text" class="form-control" id="hfaReschedule_time"  name="hfaReschedule_time" value="<?php if($visit_date_time!='0000-00-00 00:00:00'){echo date('h:i A',strtotime($visit_date_time));}?>" required>
          </div>
</div>



<div class="m-n form-group" id="hfaReschedule_commentDiv">
<label class="control-label">Comments</label>
<textarea class="form-control" name="hfaReschedule_comment">
<?=$comments?>
</textarea>
</div> 

<input type="hidden" name="hfaReschedule_id" id="hfaReschedule_id" value="<?=$id?>" />
<script type="text/javascript">
$(document).ready(function(){
	
	$('#hfaReschedule_time').timepicker();
		
		$('#hfaReschedule_date').datepicker({
			orientation: "top",
			todayHighlight: true,
	    	startDate: "-0d",
			format:'dd/mm/yyyy',
			autoclose:true
		});
		
	});
</script>	