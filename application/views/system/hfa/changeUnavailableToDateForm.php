<div class="pl-n m-n form-group col-xs-6">
  <label class="control-label">Unavailable From</label>
      <div class="input-group date">
          <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
          <input type="text" class="form-control"  name="hfaUnavailableDateFrom" id="hfaUnavailableDateFrom" value="<?=date('d/m/Y',strtotime($hfaUnavailable['date_from']));?>" disabled>
      </div>
</div>

<div class="pl-n m-n form-group col-xs-6">
  <label class="control-label">Unavailable to</label>
      <div class="input-group date">
          <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
          <input type="text" class="form-control"  name="hfaUnavailableDateTo" id="hfaUnavailableDateTo" value="<?=date('d/m/Y',strtotime($hfaUnavailable['date_to']));?>" required>
      </div>
</div>

<div class="m-n form-group" id="hfaUnavailable_commentDiv">
<label class="control-label">Comments</label>
<textarea class="form-control" name="hfaUnavailable_comment">
<?=$comments?>
</textarea>
</div>

<input type="hidden" name="hfaUnavailable_id" id="hfaUnavailable_id" value="<?=$id?>" />
<script type="text/javascript">
$(document).ready(function(){
	
		$('#hfaUnavailableDateTo').datepicker({
			orientation: "top",
			todayHighlight: true,
	    	startDate: "-0d",
			format:'dd/mm/yyyy',
			autoclose:true
		});
		
	});
</script>	