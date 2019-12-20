<?php
$accomodationTypeList=accomodationTypeList();
?>
<div class="modal fade " id="model_createNewBooking_inPast" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h2 class="modal-title">Create booking in past</h2>
                  </div>
                  
                  <div class="modal-body">
                    <form id="CBP_form">
                       		
                            <div class="col-sm-12">
                                
                                <div class="form-group col-xs-6" style="padding-left:0;">
                                    <label class="control-label">Student id</label>
                                        <input type="text" class="form-control" id="CBP_studentId" name="CBP_studentId" >
                                </div>
                                <div class="form-group col-xs-6" style="padding-left:0;">
                                    <label class="control-label">Student Name</label>
                                        <input type="text" class="form-control" id="CBP_studentName" required readonly>
                                </div>
                            	<div class="form-group col-xs-6" style="padding-left:0;">
                                    <label class="control-label">Host id</label>
                                        <input type="text" class="form-control" id="CBP_hostId" name="CBP_hostId">
                                </div>
                                <div class="form-group col-xs-6" style="padding-left:0;">
                                    <label class="control-label">Host Name</label>
                                        <input type="text" class="form-control" id="CBP_hostName" required readonly>
                                </div>
                                <div class="form-group col-xs-6" style="padding-left:0;">
                                    <label class="control-label">Date From</label>
                                        <input type="text" class="form-control" id="CBP_bookingFrom" name="CBP_bookingFrom" onchange="cBPGetRoomList();" required>
                                </div>
                                <div class="form-group col-xs-6" style="padding-left:0;">
                                    <label class="control-label">Date To</label>
                                        <input type="text" class="form-control" id="CBP_bookingTo" name="CBP_bookingTo" onchange="cBPGetRoomList();" required>
                                </div>
                                <div class="form-group col-xs-6" style="padding-left:0;">
                                    <label class="control-label">Product</label>
                                  	<select class="form-control" id="CBP_product" name="CBP_product" onchange="cBPGetRoomList();" required>
                                      <option value="">Select Product</option>
                                      <?php foreach($accomodationTypeList as $rTK=>$rTV){?>
	                                      <option value="<?=$rTK?>"><?=$rTV?></option>
                                      <?php } ?>
                                  	</select>
                                </div>
                                <div class="form-group col-xs-6" style="padding-left:0;">
                                    <label class="control-label">Room</label>
                                  	<select class="form-control" id="CBP_room" name="CBP_room" required>
                                    </select>
                                </div>
                                <input type="hidden" name="CBP_studentIdFound" id="CBP_studentIdFound" />
                                <input type="hidden" name="CBP_hostIdFound" id="CBP_hostIdFound" />
                    </form>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-success btn-raised" id="CBP_submit">Submit</button>
                      <img src="<?=loadingImagePath()?>" id="moveInitialInvoiceToXeroProcess" style="margin-right:16px;display:none;">
                      <p id="CBP_booked" style="display:none;">Booking placed successfully.</p>
                      <p id="CBP_initialInvoiceUpdated" style="display:none;">Previous initial invoice has been updated.</p>
                      <p id="CBP_initialInvoiceCreated" style="display:none;">Initial invoice has been generated for this student.</p>
                      <p id="CBP_ongoingInvoiceCreated" style="display:none;">Ongoing invoice has been generated for this student.</p>
                      <p id="CBP_purchaseOrderCreated" style="display:none;">Purchase order has been generated for this booking.</p>
                      <p id="CBP_notAvail" style="display:none;">Room is not available on these dates.</p>
                  </div>
              </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

  </div>
  
  
  <div class="modal fade " id="model_createNewBooking_inFuture" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h2 class="modal-title">Move student to different family</h2>
                  </div>
                  
                  <div class="modal-body">
                    <form id="CBF_form">
                       		
                            <div class="col-sm-12">
                                
                                <div class="form-group col-xs-6" style="padding-left:0;">
                                    <label class="control-label">Booking id</label>
                                        <input type="text" class="form-control" id="CBF_bookingId"  name="CBF_bookingId" >
                                </div>
                                <div class="form-group col-xs-6" style="padding-left:0;">
                                    <label class="control-label">Student Name</label>
                                        <input type="text" class="form-control" id="CBF_studentName" required readonly>
                                </div>
                            	<div class="form-group col-xs-6" style="padding-left:0;">
                                    <label class="control-label">Host id</label>
                                        <input type="text" class="form-control" id="CBF_hostId" name="CBF_hostId">
                                </div>
                                <div class="form-group col-xs-6" style="padding-left:0;">
                                    <label class="control-label">Host Name</label>
                                        <input type="text" class="form-control" id="CBF_hostName" required readonly>
                                </div>
                                <div class="form-group col-xs-6" style="padding-left:0;">
                                    <label class="control-label">Date From</label>
                                        <input type="text" class="form-control" id="CBF_bookingFrom" name="CBF_bookingFrom" required>
                                </div>
                                <div class="form-group col-xs-6" style="padding-left:0;">
                                    <label class="control-label">Date To</label>
                                        <input type="text" class="form-control" id="CBF_bookingTo" name="CBF_bookingTo">
                                </div>
                                <div class="form-group col-xs-6" style="padding-left:0;">
                                    <label class="control-label">Product</label>
                                  	<select class="form-control" id="CBF_product" name="CBF_product" required>
                                      <option value="">Select Product</option>
                                      <?php foreach($roomTypeList as $rTK=>$rTV){?>
	                                      <option value="<?=$rTK?>"><?=$rTV?></option>
                                      <?php } ?>
                                  	</select>
                                </div>
                                <div class="form-group col-xs-6" style="padding-left:0;">
                                    <label class="control-label">Room</label>
                                  	<select class="form-control" id="CBF_room" name="CBF_room" required>
                                      <option value="">Select Room</option>
                                  	</select>
                                </div>
                                <input type="hidden" name="CBF_studentIdFound" id="CBF_studentIdFound" />
                                <input type="hidden" name="CBF_hostIdFound" id="CBF_hostIdFound" />
                    </form>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-success btn-raised" id="CBF_submit">Submit</button>
                      <img src="<?=loadingImagePath()?>" id="CBF_submitProcess" style="margin-right:16px;display:none;">
                  </div>
              </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

  </div>
  
  <script type="text/javascript">
	var selectRoomHtml='<option value="">Select Room</option>';
  	$(document).ready(function(){
		
		$('#CBP_bookingTo, #CBF_bookingFrom, #CBF_bookingTo').datepicker({
			orientation: "top",
			todayHighlight: true,
			format:'dd/mm/yyyy',
			autoclose:true
		});
		
		$('#CBP_bookingFrom').datepicker({
			orientation: "top",
			endDate: "-1d",
	    	format:'dd/mm/yyyy',
			autoclose:true
		});
		
		$('#CBP_studentId, #CBF_bookingId').change(function(){
			var thisTextField=$(this);
			if(thisTextField.attr('id')=='CBP_studentId')
			{
				var prefix='CBP';
				var url='booking/shaNameByIdForCreateBooking/';
				var valMsg='Student not found / Incomplete student application  / Student already placed / Student part of a study tour / Client not assigned / Client is enrolled for group invoices';
			}
			else
			{
				var prefix='CBF';
				var url='booking/shaNameByBookingIdForCreateBooking/';
				var valMsg='Booking not found';
			}
				
			var CBP_studentId= thisTextField.val();
			if(CBP_studentId.trim()!='')
				{
					var CBP_studentIdValidation= thisTextField.parsley();
					window.ParsleyUI.removeError(CBP_studentIdValidation,prefix+'_studentIdValidationError');
					$('#'+prefix+'_bookingFrom').val('');
						
					$.ajax({
						url:site_url+url+$(this).val(),
						dataType: 'json',
						success:function(data)
									{
										
										if(data.hasOwnProperty('notFound'))
										{
											window.ParsleyUI.addError(CBP_studentIdValidation,prefix+'_studentIdValidationError',valMsg);
											thisTextField.focus();
											$('#'+prefix+'_studentIdFound, #'+prefix+'_studentName').val('');
											$('#'+prefix+'_bookingFrom').val('');
										}
										else
										{
											$('#'+prefix+'_studentName').val(data.name);
											$('#'+prefix+'_studentIdFound').val(data.shaId);
											if(prefix=='CBF')
											{
												$('#'+prefix+'_bookingFrom').val(data.newBookingFrom);
												$('#CBF_bookingFrom').datepicker('setStartDate', data.newBookingFrom);
												$('#CBF_bookingFrom').datepicker('update',data.newBookingFrom);
											}
										}
									}
					});
			}
			else
				$('#'+prefix+'_studentIdFound, #'+prefix+'_studentName').val('');
		});
		
		
		$('#CBP_hostId, #CBF_hostId').change(function(){
			if($(this).attr('id')=='CBP_hostId')
				var prefix='CBP';
			else
				var prefix='CBF';
		
			$('#'+prefix+'_product').trigger('change').val('');
			
			var CBP_hostId= $('#'+prefix+'_hostId').val();
			if(CBP_hostId.trim()!='')
				{
					var CBP_hostIdValidation= $('#CBP_hostId').parsley();
					window.ParsleyUI.removeError(CBP_hostIdValidation,prefix+'_hostIdValidationError');
						
						
					$.ajax({
						url:site_url+'booking/hfaNameByIdForCreateBooking/'+CBP_hostId,
						dataType: 'json',
						success:function(data)
									{
										if(data.hasOwnProperty('notFound'))
											{
												window.ParsleyUI.addError(CBP_hostIdValidation,prefix+'_hostIdValidationError','Host family not found / Incomplete host family application');
												$('#'+prefix+'_hostId').focus();
												$('#'+prefix+'_hostIdFound, #'+prefix+'_hostName').val('');
												/*$('#'+prefix+'_room').html(selectRoomHtml);*/
											}
										else
										{
											$('#'+prefix+'_hostName').val(data.name);
											$('#'+prefix+'_room').html(data.roomsHtml);
											$('#'+prefix+'_hostIdFound').val(CBP_hostId);
										}
											
									}
					});
			}
			else
			{
				$('#'+prefix+'_hostIdFound, #'+prefix+'_hostName').val('');
				$('#'+prefix+'_room').html(selectRoomHtml);
			}
		});
		
		$('#CBP_submit').click(function(){
			 var valid=$('#CBP_form').parsley().validate();
			 if(valid)
			 {
				 var formdata=$('#CBP_form').serialize();
			 	$.ajax({
						url:site_url+'booking/cBP',
						type:'POST',
						data:formdata,
						dataType: 'json',
						success:function(data)
										{
											if(data.result=='LO')
												redirectToLogin();
										}
				});
			 }
		});
		
		$('#CBF_submit').click(function(){
			 var valid=$('#CBF_form').parsley().validate();
			 if(valid)
			 {
				 $('#CBF_submit').hide();
				 $('#CBF_submitProcess').show();
				 var formdata=$('#CBF_form').serialize();
			 	$.ajax({
						url:site_url+'booking/cBF',
						type:'POST',
						data:formdata,
						success:function(data)
										{
											alert(data);
											$('#CBF_submit').show();
											$('#CBF_submitProcess').hide();
										}
				});
			 }
		});
		
	});
	
function resetBookingForms()
{
	$('#CBP_form')[0].reset();
	$('#CBF_form')[0].reset();
	$('#CBP_room, #CBF_room').html(selectRoomHtml);
	
	$('#CBP_booked, #CBP_initialInvoiceUpdated, #CBP_initialInvoiceCreated, #CBP_ongoingInvoiceCreated, #CBP_purchaseOrderCreated, #CBP_notAvail').hide();
}	
  </script>