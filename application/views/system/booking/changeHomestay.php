<?php
$accomodationTypeList=accomodationTypeList();
?>
<div class="page-heading">
      <h1>Change homestay</h1>
</div>

<div class="container-fluid">                                

    <div data-widget-group="group1">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                         		
                                <form id="CHB_form">
                                    <div id="CHB_stepOne">
                                        <div class="form-group col-xs-6" style="padding-left:0;">
                                            <label class="control-label">Booking id</label>
                                            <input type="text" class="form-control" id="CHB_bookingId"  name="CHB_bookingId" >
                                        </div>
                                        <div class="form-group col-xs-6" style="padding-left:0;">
                                            <label class="control-label">Student Name</label>
                                            <input type="text" class="form-control" id="CHB_studentName" required readonly>
                                        </div>
                                        <div class="form-group col-xs-6" style="padding-left:0;">
                                            <label class="control-label">Date From</label>
                                                <input type="text" class="form-control" id="CHB_bookingFrom" name="CHB_bookingFrom" required>
                                        </div>
                                        <div class="form-group col-xs-6" style="padding-left:0;">
                                            <label class="control-label">Date To</label>
                                                <input type="text" class="form-control" id="CHB_bookingTo" name="CHB_bookingTo">
                                        </div>
                                        <input type="hidden" id="CHB_studentIdFound" name="CHB_studentIdFound" />
                                        <input type="hidden" id="CHB_studyTourBooking" name="CHB_studyTourBooking" value="0" />
                                   </div>
                                   
                                   <div id="CHB_stepTwo" style="/*display:none;*/">
                                   		<div class="form-group col-xs-6" style="padding-left:0;">
                                            <label class="control-label">Host family id</label>
                                            <input type="text" class="form-control" id="CHB_hfaId"  name="CHB_hfaId" >
                                        </div>
                                        <div class="form-group col-xs-6" style="padding-left:0;">
                                            <label class="control-label">Host Name</label>
                                            <input type="text" class="form-control" id="CHB_hfaName" required readonly>
                                        </div>
                                        
                              
                                        
                                        <div class="form-group col-xs-12" style="padding-left:0;">
                                              <label class="control-label">Product</label>
                                              <select class="form-control" id="CHB_product" name="CHB_product" required>
                                                <option value="">Select Product</option>
                                                  <?php foreach($accomodationTypeList as $aTK=>$aTV){?>
                                                <option value="<?=$aTK?>"><?=$aTV?></option>
                                              <?php } ?>
                                              </select>
                                        </div>
                                   
                                        <div class="form-group" style="clear:both;display:none;" id="CHB_roomsAvailableParent">
                                            <label for="radio" class="control-label">Select the room you want to place the student in</label>
                                            <div class="" id='CHB_roomsAvailable' style="margin-left: -8px;"></div>
                                        </div>
                                       <input type="hidden" id="CHB_hfaIdFound" name="CHB_hfaIdFound" />
                                   </div>
                                   
                                   <div id="CHB_stepThree" style="/*display:none;*/clear:both;">
                                   		 
                                        <div class="checkbox checkbox-primary" id="initialInvoiceDIv">
                                            <label class="checkbox-primary-label">
                                                <input type="checkbox" name="CHB_initial_invoice" id="CHB_initial_invoice" value="1" checked="checked">
                                                Create initial invoice
                                            </label>
                                        </div>
                                         
                                         <p id="CHB_stepThreeError" style="display:none;"></p>
                                         <p id="CHB_stepThreeSucess" style="display:none;"></p>
                                         <img src="<?=loadingImagePath()?>" id="CHB_stepThreeSubmitProcess" style="margin:10px 1px 7px 0px;display:none;">
                                        <button type="button" class="btn btn-success btn-raised m-n btn-info" id="CHB_stepThreeSubmit">Submit</button>
                                   </div>
                                   
                              </form>
                                
                    </div>
                    <div class="panel-footer"></div>
                </div>
            </div>
            
            <div class="col-md-6" id="CHB_alerts"></div>
            
        </div>
    </div>

</div>


<script type="application/javascript">
$(document).ready(function(){
	
	$('#CHB_bookingFrom,#CHB_bookingTo').datepicker({
			orientation: "bottom",
			format:'dd/mm/yyyy',
			autoclose:true
		});
	
	$('#CHB_bookingId').change(function(){
	
		addRemError('CHB_bookingId','',0);
	
		$('#CHB_studentName, #CHB_studentIdFound, #CHB_bookingFrom, #CHB_bookingTo, #CHB_product').val('');
		
		$('#CHB_roomsAvailableParent').hide();
		$('#CHB_roomsAvailable').html('');
		
		$('#initialInvoiceDIv').show();
		$('#CHB_studyTourBooking').val('0');
						
		$.ajax({
			url:site_url+'booking/shaNameByBookingIdForCreateBooking/'+$(this).val(),
			dataType: 'json',
			success:function(data)
				{
					if(data.hasOwnProperty('notFound'))
					{
						$('#CHB_bookingId').val('');
						addRemError('CHB_bookingId','',1);
						notiPop('error','Booking not found','');
					}
					else if(data.newBookingFrom=='')
					{
						addRemError('CHB_bookingId','There is no booking end date on this booking',1);
						$('#CHB_bookingId').focus();
					}
					else
					{
						if(data.studyTourBooking=='1')
						{
							$('#initialInvoiceDIv').hide();
							$('#CHB_studyTourBooking').val('1');
						}
							
						notiPop('success','Booking details found and updated','');
						$('#CHB_studentName').val(data.name);
						$('#CHB_studentIdFound').val(data.shaId);
						$('#CHB_bookingFrom').datepicker('setStartDate', data.newBookingFrom);
						$('#CHB_bookingFrom').datepicker('update',data.newBookingFrom);
					}
					
				}
		});
	
	});
	
	$('#CHB_hfaId').change(function(){
		
		addRemError('CHB_hfaId','',0);
		
		$('#CHB_hfaIdFound, #CHB_hfaName, #CHB_product').val('')
		
		$('#CHB_roomsAvailableParent').hide();
		$('#CHB_roomsAvailable').html('');
		
		var CHB_hfaId=$(this).val();
		
		if(CHB_hfaId!='')
		{
			$.ajax({
				url:site_url+'booking/hfaNameByIdForCreateBooking/'+$(this).val(),
				dataType: 'json',
				success:function(data)
					{
						if(data.hasOwnProperty('notFound'))
						{
							$('#CHB_hfaId').val('');
							addRemError('CHB_hfaId','',1);
							notiPop('error','Host family not found','');
						}
						else
						{
							$('#CHB_hfaIdFound').val(data.id)
							$('#CHB_hfaName').val(data.name);
							notiPop('success','Host family details found and updated','');
						}
					}
			});
		}
	
	});
	
	$('#CHB_stepThreeSubmit').click(function(){
		
		var CHB_studentIdFound=$('#CHB_studentIdFound').val();
		var CHB_bookingFrom=$('#CHB_bookingFrom').val();
		var CHB_bookingTo=$('#CHB_bookingTo').val();
		var CHB_hfaIdFound=$('#CHB_hfaIdFound').val();
		var CHB_product=$('#CHB_product').val();
		var CHB_bedroom=$("input[name='CHB_hfaRoom']:checked").val();
		
		$('#CHB_stepThreeError, #CHB_stepThreeSucess').text('').hide();
		
		var BookingFromDate = $.datepicker.parseDate('dd/mm/yy', CHB_bookingFrom);
		var BookingEndDate = $.datepicker.parseDate('dd/mm/yy', CHB_bookingTo);
		
		if(CHB_studentIdFound=='' || CHB_bookingFrom=='' || CHB_hfaIdFound=='' || CHB_product=='' || CHB_bedroom==null)
		{
			if(CHB_studentIdFound=='')
				alertMsg('CHB_alerts','danger','Please enter booking id');
			if(CHB_bookingFrom=='')
				alertMsg('CHB_alerts','danger','Please enter booking dates');
			if(CHB_hfaIdFound=='')
				alertMsg('CHB_alerts','danger','Please enter host family id');
			if(CHB_product=='')
				alertMsg('CHB_alerts','danger','Please select product type');	
			if(CHB_bedroom==null)
				alertMsg('CHB_alerts','danger','Please select a room');
		}
		else if(BookingFromDate >= BookingEndDate && BookingEndDate!=null)
			alertMsg('CHB_alerts','danger','Booking end date should be graeter than start date');
		else
		{
			$('#CHB_stepThreeSubmit').hide();
			$('#CHB_stepThreeSubmitProcess').show();
			
			var formdata=$('#CHB_form').serialize();
			$.ajax({
				url:site_url+'booking/changeHomestaySubmit',
				type:'POST',
				data:formdata,
				dataType: 'json',
				success:function(data)
					{
						scrollToDIv('wrapper');
						
						if(data.result=='LO')
							redirectToLogin();
						else if(data.result=='notAvail')
							alertMsg('CHB_alerts','danger','This room is not available on these dates');
						else if(data.result=='done')
						{
							alertMsg('CHB_alerts','success','Booking placed successfully, click <b><a target="_blank" href="'+site_url+'booking/view/'+data.booking_id+'">here</a></b> to view the booking');
							if($('#CHB_initial_invoice').is(':checked'))
							{
								if(data.hasOwnProperty('initial_invoice'))
								{
									var initialInvoice=data.initial_invoice.split('-');
									alertMsg('CHB_alerts','success','Initial invoice created, click <b><a target="_blank" href="'+site_url+'invoice/view_initial/'+initialInvoice[1]+'">here</a></b> to view the invoice');
								}
							}
							else	
							{
								if(data.hasOwnProperty('ongoing_invoice'))
								{
									var ongoingInvoice=data.ongoing_invoice.split('-');
									alertMsg('CHB_alerts','info','Initial invoice not created');
									if(ongoingInvoice[0]=='done')
										alertMsg('CHB_alerts','success','Ongoing invoice created, click <b><a target="_blank" href="'+site_url+'invoice/view_ongoing/'+ongoingInvoice[1]+'">here</a></b> to view the invoice');
									else if(ongoingInvoice[0]=='future')
										alertMsg('CHB_alerts','info_orange','Ongoing invoice will be created on '+ongoingInvoice[1]);	
								}
							}
							
							//Study tour booking #STARTS
							if($('#CHB_studyTourBooking').val()=='1')
							{
								alertMsg('CHB_alerts','success','Initial invice is not generated, please refer to the original initial invoice and make changes if required.');	
							}
							//Study tour booking #ENDS
						}
						$('#CHB_stepThreeSubmit').show();
						$('#CHB_stepThreeSubmitProcess').hide();
					}
				
			});
		}
			
	});
	
	
	$('#CHB_product').change(function(){
		
		$('#CHB_roomsAvailableParent').hide();
		$('#CHB_roomsAvailable').html('');	
							
		var student=$('#CHB_studentIdFound').val();
		var host=$('#CHB_hfaIdFound').val();
		var accomodation_type=$('#CHB_product').val();
		var from=$('#CHB_bookingFrom').val();
		var to=$('#CHB_bookingTo').val();
		
		if(student!='' && host!='' && from!='')
		{
			$.ajax({
					url:site_url+'booking/changeHomestayGetRooms',
					type:'POST',
					data:{host:host,accomodation_type:accomodation_type,from:from,to:to},
					success:function(data)
						{
							if(data=='')
								$('#CHB_roomsAvailableParent').hide();
							else
								$('#CHB_roomsAvailableParent').show();
							$('#CHB_roomsAvailable').html(data);	
						}
				});
		}
		else if(from=='')
			alertMsg('CHB_alerts','danger','Please enter booking dates');
		
	});
	
});

function addRemError(id,errorMsg,add)
{
	    var formField= $('#'+id).parsley();
		window.ParsleyUI.removeError(formField,'formFieldError');
		if(add==1)
		{
			if(errorMsg=='')
				errorMsg=' ';
			window.ParsleyUI.addError(formField,'formFieldError',errorMsg);
		}
}
</script>