<?php
if($studentOne['accomodation_type']=='7')
{
	if($studentOne['booking_to']!='0000-00-00')
		$bookingTo=date('d/m/Y',strtotime($studentOne['booking_to'].' +1 day'));
}
else
{
	if($studentOne['booking_from']!='0000-00-00')
		$bookingTo=date('d/m/Y',strtotime($studentOne['booking_from'].' +1 day'));
}
?>
<div class="pl-n m-n form-group col-xs-6">
  <label class="control-label">Booking start date</label>
      <div class="input-group date">
          <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
          <input type="text" class="form-control"  name="placeBooking_startDate" id="placeBooking_startDate" value="<?php if($studentOne['booking_from']!='0000-00-00'){echo date('d/m/Y',strtotime($studentOne['booking_from']));}?>" readonly="readonly" required>
      </div>
</div>

<div class="pl-n m-n form-group col-xs-6">
  <label class="control-label">Booking end date</label>
      <div class="input-group date">
          <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
          <input type="text" class="form-control"  name="placeBooking_endDate" id="placeBooking_endDate" value="<?=$bookingTo?>" readonly="readonly">
      </div>
</div>
<input type="hidden" name="student" value="<?=$student?>" />