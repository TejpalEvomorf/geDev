<div class="pl-n m-n form-group col-xs-6">
  <label class="control-label">Notice date</label>
      <div class="input-group date">
          <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
          <input type="text" class="form-control"  name="placeBooking_noticeDate" id="placeBooking_noticeDate" value="<?php if($booking['notice_date']!='0000-00-00'){echo date('d/m/Y',strtotime($booking['notice_date']));}?>" >
      </div>
</div>

<div class="pl-n m-n form-group col-xs-6">
  <label class="control-label">Move out date</label>
      <div class="input-group date">
          <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
          <input type="text" class="form-control"  name="placeBooking_moveoutDate" id="placeBooking_moveoutDate" value="<?php if($booking['moveout_date']!='0000-00-00'){echo date('d/m/Y',strtotime($booking['moveout_date'].' +1 day'));}?>">
      </div>
</div>

<input type="hidden" name="booking_id" value="<?=$booking['id']?>" />

<script type="text/javascript">
$(document).ready(function(){

		$('#placeBooking_noticeDate').datepicker({
			/*orientation: "auto",*/
			todayHighlight: true,
	    	startDate: "-0d",
			format:'dd/mm/yyyy',
			autoclose:true,
			container:'#model_editBooking'
        	
		}).on('changeDate', function (selectedDate) {
			$('#editBookingSubmitSecond, #editBookingBackSecond').hide();
			$('#editBookingProcessSecond').show();
			var notice=$(this).val();
			$.ajax({
						url:site_url+'booking/noticeGetBookingEnd',
						type:'POST',
						data:{notice:notice,booking_end:'<?php if($booking['booking_to']!='0000-00-00'){echo date('d/m/Y',strtotime($booking['booking_to']));}?>'},
						dataType:'json',
						success:function(data)
							{
								if(!$.isEmptyObject(data) && data.booking_end)
								{
									$("#placeBooking_endDate").datepicker("setDate", data.booking_end );
									$("#placeBooking_moveoutDate").datepicker("setDate", data.booking_end );
								}
								else	
									$("#placeBooking_moveoutDate").datepicker("setDate", $("#placeBooking_endDate").val());
								$('#editBookingSubmitSecond, #editBookingBackSecond').show();
								$('#editBookingProcessSecond').hide();
							}
					});
			
		});
		
		
		$('#placeBooking_moveoutDate').datepicker({
			/*orientation: "bottom",*/
			todayHighlight: true,
	    	startDate: "-0d",
			format:'dd/mm/yyyy',
			autoclose:true,
			container:'#model_editBooking'
        	
		}).on('changeDate', function (selectedDate) {
				$('#editBookingSubmitSecond, #editBookingBackSecond').hide();
				$('#editBookingProcessSecond').show();
    			$.ajax({
						url:site_url+'booking/moveOutRules',
						type:'POST',
						data:{notice:$('#placeBooking_noticeDate').val(),move_out:$(this).val(),booking_end:$('#placeBooking_endDate').val(),booking_end_old:'<?php if($booking['booking_to']!='0000-00-00'){echo date('d/m/Y',strtotime($booking['booking_to']));}?>'},
						dataType:'json',
						success:function(data)
							{
								if(!$.isEmptyObject(data) && data.booking_end)
									$("#placeBooking_endDate").datepicker("setDate", data.booking_end);
								$('#editBookingSubmitSecond, #editBookingBackSecond').show();
								$('#editBookingProcessSecond').hide();
							}
					});
		});
		
	});
</script>		