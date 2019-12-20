<!--Booking edit pop up #STARTS-->
<div class="modal fade" id="model_editBooking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        
        <div class="modal-dialog" id="model_editBooking_first">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h2 class="modal-title">Edit booking</h2>
                </div>
                
                <div class="modal-body">
                    <form id="editBooking_form"></form>
                    <div id="editBooking_form_msgs" style="clear: both;color: #8BC34A;font-size: 16px;font-weight: bold;">
                    	<p style="display:none;"></p>
                    </div>                
                </div>
                <div class="modal-footer">                 
                    <button style="float:right;" type="button" class="btn btn-success btn-raised" id="editBookingSubmit">Submit</button>
                    <img src="<?=loadingImagePath()?>" id="editBookingProcess" style="margin-right:16px;display:none; float:right;">
                     <a href="javascript:void(0);" onclick=""  style="float:right; margin: 8px 8px 0 0;" id="editBookingEndDateBtn">
 						 <i class="material-icons" data-placement="bottom" data-toggle="tooltip"  data-original-title="Booking end date history">alarm</i>
  				  </a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
        
        <div class="modal-dialog" id="model_editBooking_second" style="display:none;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h2 class="modal-title">Notice date</h2>
                </div>
                
                <div class="modal-body">
                    <form id="editBooking_form_second"></form>                
                </div>
                <div class="modal-footer">
                
	                <button type="button" class="btn btn-grey btn-raised" id="editBookingBackSecond">Back</button>
                    <button type="button" class="btn btn-success btn-raised" id="editBookingSubmitSecond">Done</button>
                    <img src="<?=loadingImagePath()?>" id="editBookingProcessSecond" style="margin-right:16px;display:none;">
                </div>
            </div><!-- /.modal-content -->
        </div>
        
    </div>
<!--Booking edit pop up #ENDS-->