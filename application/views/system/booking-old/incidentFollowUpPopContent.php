<div class="pl-n m-n form-group col-xs-12">
    <label class="control-label">Follow up date</label>
    <div class="input-group date">
        <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
        <input type="text" class="form-control"  name="bookIncidentFollowUp_date" id="bookIncidentFollowUp_date" required>
    </div>
</div>
<div class="m-n form-group">
    <label class="control-label">Incident follow up</label>
    <textarea  rows="4" class="form-control" id="bookIncident_followUp" name="bookIncident_followUp" required></textarea>
</div>                      
<input type="hidden" name="bookingIncident_Id" value="<?=$id?>" />
<input type="hidden" name="bookingIncident_bookingId" value="<?=$incident['booking_id']?>" />
                    
<script>

	$(document).ready(function(){
		$('#bookIncidentFollowUp_date').datepicker({
			orientation: "bottom",
			todayHighlight: true,
			format:'dd/mm/yyyy',
			autoclose:true
		});
	});
		
</script>                    