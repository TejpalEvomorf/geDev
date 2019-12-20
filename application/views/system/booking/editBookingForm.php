<?php
$employeeList=employeeList();
$loggedInUser=loggedInUser();
$formTwo=getHfaTwoAppDetails($booking['host']);
$roomTypeList=roomTypeList();
$getShaOneAppDetails=getShaOneAppDetails($booking['student']);
?>
<div class="m-n form-group">
    <label class="control-label">Booking owner</label>
    <select class="form-control" id="placeBooking_owner" name="placeBooking_owner" required>
	    <option value="">Select employee</option>
        <?php foreach($employeeList as $eV){?>
                    <option value="<?=$eV['id']?>" <?php if($booking['owner']==$eV['id']){echo 'selected="selected"';}?>><?=$eV['fname'].' '.$eV['lname']?></option>
                <?php } ?>
    </select>
</div>


<div class="pl-n m-n form-group col-xs-6">
  <label class="control-label">Booking start date</label>
      <div class="input-group date">
          <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
          <input type="text" class="form-control"  name="placeBooking_startDate" id="placeBooking_startDate" value="<?php if($booking['booking_from']!='0000-00-00'){echo date('d/m/Y',strtotime($booking['booking_from']));}?>" required>
      </div>
</div>

<div class="pl-n m-n form-group col-xs-6">
  <label class="control-label">Booking end date</label>
      <div class="input-group date">
          <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
          <input type="text" class="form-control"  name="placeBooking_endDate" id="placeBooking_endDate" value="<?php if($booking['booking_to']!='0000-00-00'){echo date('d/m/Y',strtotime($booking['booking_to'].' +1 day'));}?>">
          <input type="hidden"  name="placeBooking_endDateOld"  value="<?php if($booking['booking_to']!='0000-00-00'){echo date('d/m/Y',strtotime($booking['booking_to'].' +1 day'));}?>">
      </div>
</div>
<div class="move-notice-date-box">
  <a href="javascript:void(0);" onclick="$('#model_editBooking_first').hide();$('#model_editBooking_second').slideDown();" style="float:left;"><?php if($booking['notice_date']!='0000-00-00' || $booking['moveout_date']!='0000-00-00'){echo "Edit";}else {echo "Add";}?> Notice/Move out date</a>
  <!--<a href="javascript:void(0);" onclick="bookingEndDateHistory(<?=$booking['id']?>);" style="float:right;">
  <i class="material-icons" data-placement="bottom" data-toggle="tooltip"  data-original-title="Booking end date history">alarm</i>
  </a>-->

<?php if($booking['moveout_date']!='0000-00-00'){?>
  <span style="color: #424242; font-size: 12px; float:right;"><?php if($booking['moveout_date']!='0000-00-00'){echo date('d/m/Y',strtotime($booking['moveout_date'].' +1 day'));}?></span>
  <label style="color: #424242; font-size: 12px; float:right; margin:0 5px 0 0; line-height: unset;" class="control-label">Move out date</label>
<?php }?>

<?php if($booking['notice_date']!='0000-00-00'){?>
  <span style="color: #424242; font-size: 12px; float:right; margin: 0 15px 0 0;"><?php if($booking['notice_date']!='0000-00-00'){echo date('d/m/Y',strtotime($booking['notice_date']));}?></span>
  <label style="color: #424242; font-size: 12px; float:right; margin:0 5px 0 0; line-height: unset;" class="control-label">Notice date</label>
<?php } ?>
  </div>

<?php if($booking['booking_from']=='0000-00-00' || ($booking['booking_from']!='0000-00-00' && strtotime($booking['booking_from'])>strtotime(date('Y-m-d')))) {?>
<div class="form-group" style="float:left; width: 100%; margin-top: 10px;">
	  <label for="radio" class="control-label">Select the room you want to place the student in</label>
      <div class="col-sm-12">
            <div class="radio">
                                                        
					<?php 
					  $studentBookingDates['from']=$studentBookingDates['to']='';
					  if($getShaOneAppDetails['booking_from']!='0000-00-00')
						  $studentBookingDates['from']=$getShaOneAppDetails['booking_from'];
					  if($getShaOneAppDetails['booking_to']!='0000-00-00')
						  $studentBookingDates['to']=$getShaOneAppDetails['booking_to'];
					
					foreach($formTwo['bedroomDetails'] as $roomK=>$room){
						if(checkIfBedBooked($room['id'],$getShaOneAppDetails['accomodation_type'],$studentBookingDates) && $room['id']!=$booking['room'])
						  continue;
						?>
                                    
                        <div class="radio block">
                          <label>
                              <input type="radio" name="placeBooking_bedroom"  <?php if($room['id']==$booking['room']){echo 'checked';}?> value="<?=$room['id']?>" required>
                              <span class="circle"></span>
                              <span class="check"></span>
                              <?='Bedroom '?>
                              <?=$roomK+1 .': '.$roomTypeList[$room['type']]?>
                                          <?php
                                              if($room['internal_ensuit']==1)
                                                  echo '(Internal ensuit)';
                                          ?>
                          </label>
                        </div>
                                        
                    <?php }?>
                                                        
            </div>
      </div>
</div>
<?php } else{?>
<input type="hidden" name="placeBooking_bedroom" value="<?=$booking['room']?>" />
<?php }?>

<input type="hidden" name="booking_id" id="booking_id" value="<?=$booking['id']?>" />

<script type="text/javascript">
$(document).ready(function(){

		$('#placeBooking_startDate, #placeBooking_endDate').datepicker({
			/*orientation: "top",*/
			todayHighlight: true,
	    	format:'dd/mm/yyyy',
			autoclose:true,
			container:'#model_editBooking'
		});
		
	});
</script>		