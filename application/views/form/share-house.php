<?php
$accomodationTypeList=houseTypeList();
$nameTitleList=nameTitleList();
$nationList=nationList();
$stateList=stateList();
?>

<div id="add-hostfamily-application" class="wFormContainer new_forms add-hostfamily-application">
	<legend class="headingHostForm">Share House Application Form
	<span class="hand-written">All fields with red asterick<span class="reqField"> * </span>are mandatory</span></legend>
  	<div style="background:none;" class="">
  		<div class="wForm" id="tfa_0-WRPR" dir="ltr">
			<form method="post"  class="hintsBelow labelsAbove" id="host_family_application_oneForm">
				<fieldset id="tfa_1" class="section column">
					<fieldset id="" class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new">
					<div class="hfa1_home_left">		

						<div class=" full_width_field">
					        <span class="hfa1_app_full">
								<label class="full_label" for="first_name">First Name <span class="reqField">*</span></label>
					        <input type="text" class="errorOnBlur full_input errorOnBlur" name="first_name" value="" id="first_name">
					        </span>
					        <span id="share_house_first_name_error">First Name is wrong</span>
					    </div>
					    <div class=" full_width_field">
					        <span class="hfa1_app_full">
								<label class="full_label" for="last_name">Last Name <span class="reqField">*</span></label>
					        <input type="text" class="full_input errorOnBlur" name="last_name" value="" id="last_name">
					        </span>
					        <span id="share_house_last_name_error">Last Name is wrong</span>
					    </div>
					    <div class=" full_width_field">
					        <span class="hfa1_app_full">
								<label class="full_label" for="mobile">Mobile No <span class="reqField">*</span></label>
								<input type="text" class="full_input  errorOnBlur" name="mobile" value="" id="mobile">
							</span>
					        <span id="share_house_mobile_error">Mobile No is wrong</span>
					    </div>
					    <div style="margin-top: 12px;" class=" full_width_field">
					        <span class="hfa1_app_full">
					            <label class="full_label" for="gender">Gender</label>
					            <input style="float:left;width:20px !important; margin-right:5px;" name="gender" value="1" checked="checked" type="radio">
					            <label style="float:left; margin-right:34px; margin-bottom:13px; " for="" class="selt">Male</label>
					            <input style="float:left; width:20px !important; margin-right:5px;" name="gender" value="2" type="radio">
					            <label style="float:left; margin-right:35px; margin-bottom:13px; " for="" class="selttwo">Female</label>
					        </span>
					    </div>    
					    <div class=" full_width_field">
					        <span class="hfa1_app_full">
								<label class="full_label" for="email">Email ID<span class="reqField">*</span></label>
								<input type="text" class="full_input  errorOnBlur notReq" name="email" value="" id="email">
							</span>
					        <span id="share_house_email_error">Email format is wrong</span>
					    </div>
					    <div class="full_width_field">
					        <span class="hfa1_app_full">
					            <label for="nationality" class="full_label">Nationality <span class="reqField">*</span></label>
					            <select class="full_input" id="nationality" name="nationality">
					                <option value="">Select one</option>
					                <?php foreach($nationList as $nlK=>$nlV){?>
					                <option value="<?=$nlK?>" class=""><?=$nlV?></option>
					                <?php } ?>
					            </select>
					        </span>
					        <span id="share_house_nationality_error">Nationality is wrong</span>
					    </div>
					</div>
					<div class="hfa1_home_right">

						<div class=" full_width_field">
					        <span class="hfa1_app_full">
								<label for="arrival_date" class="full_label">Arrival Date<span class="reqField">*</span></label>
								<input type="text" id="arrival_date" value="" name="arrival_date" class="full_input date-icon errorOnBlur"  readonly="readonly" />
							</span>
					        <span id="share_house_arrival_date_error">Arrival Date is wrong</span>
					    </div>
					    <div class=" full_width_field">
					        <span class="hfa1_app_full">
					            <label for="arrival_time" class="full_label">Arrival Time</label>
					            <input type="text" id="arrival_time" value="" name="arrival_time" class="full_input date-icon errorOnBlur"  readonly="readonly" />
					        </span>
					        <span id="share_house_arrival_time_error">Arrival Time is wrong</span>
					    </div>
					    <div class=" full_width_field">
					        <span class="hfa1_app_full">
								<label class="full_label" for="flight_no">Flight Number</label>
					        <input type="text" class="full_input errorOnBlur" name="flight_no" value="" id="flight_no">
					        </span>
					        <span id="share_house_flight_no_error">Flight No is wrong</span>
					    </div>
					    <div class=" full_width_field">
					        <span class="hfa1_app_full">
					            <label class="full_label" for="flight_no">College Name</label>
					        <input type="text" class="full_input errorOnBlur" name="college_name" value="" id="college_name">
					        </span>
					        <span id="share_house_flight_no_error">College Name is wrong</span>
					    </div>
					    <div class=" full_width_field">
					        <span class="hfa1_app_full">
								<label class="full_label" for="college_address">College Address</label>
					        <input type="text" class="full_input errorOnBlur" name="college_address" value="" id="college_address">
					        </span>
					        <span id="share_house_college_address_error">College Address is wrong</span>
					    </div>
					   <div class=" full_width_field">
					        <span class="hfa1_app_full">
					            <label class="full_label" for="">Service Type</label>
					            <?php foreach($accomodationTypeList as $atK=>$atV){?>
					            <div class="radio block"><label><input name="service_type" value="<?php echo $atK;?>" <?php if($atK==1) { echo 'checked="checked"'; } ?> type="radio"><span class="circle"></span><span class="check"></span> <?php echo $atV?></label></div>
					            <?php } ?>
					        </span>
					    </div>  
					</div>


					</fieldset>
				</fieldset>
				
				<fieldset class="section column tfa_2" id="">
					<fieldset class="main-bfBlock_new" id="">
						<h3>Terms &amp; Conditions</h3>
							<div class="reveal-modal" id="myModal">
								<legend class="headingHostForm">Global Experience Terms and Conditions</legend>
									<ul type="disc" style="list-style-type:disc; margin-left:16px;">

										<li>Minimum booking is for four weeks and a $320 bond must be paid upon arrival to the Driver.</li>

										<li>Pre-arrangement fee is non-refundable if the accommodation is cancelled within 2 weeks up to 2 days before the arrival.</li>

										<li>Pre-arrangement and 4 weeks accommodation fees are non-refundable if cancellation is done within 48 hours before the arrival.</li>

										<li>If your flight details have changed, you must let Global Experience knows and provide us with the new arrival/flight details so that we can re-arrange your pick-up.</li>

										<li>If you wish to extend your stay, you need to contact Global Experience to arrange for the next payment. Payment should be done through online banking or direct deposit to our Westpac Account (details will be supplied upon extension).</li>
									</ul>
								</div>
							<input type="checkbox" name="tnc" id="tnc" class="errorOnBlur" value="terms" style="margin-top:-3px; margin-right:5px;">
							<span>I accept the terms &amp; conditions <span class="reqField">*</span></span>
							<p id="tncError" style="display:none;color:#F00; float:right;">Please accept the terms &amp; conditions</p>
						</fieldset>
					</fieldset>
				<div class="end-options-admin">
					<input type="button" value="Submit &amp; continue" id="hfaOneSubmitBtn" class="btn-btn-medium hfa_submit">
					<div id="hfaOneProcess" style="display:none;" class="appFormProcess">
						<img src="<?=static_url()?>img/submitload.gif"   />
					</div>
					<span id="hfaOneError" style="display:none;color:#F00;">The form is incomplete. Fields outlined with red are required in the right format.</span>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	//$('#retrieve_application').modal({backdrop: 'static', keyboard: false});
	
	$('#ret_app_btn').click(function(){
		
		var $ret_app_btn_process=$('#ret_app_btn_process');
		var $ret_app_btn=$('#ret_app_btn');
								
			$('#ret_app_link, #ret_app_error, #ret_app_btn_process').hide();
			$ret_app_btn_process.hide()
			
			
			var $ret_app_email=$('#ret_app_email');
			var ret_app_email=$ret_app_email.val().trim();
			
			removeFieldError($ret_app_email);
			if(ret_app_email=='')
					addFieldError($ret_app_email);
			else
			{
				$ret_app_btn_process.show();
				$ret_app_btn.hide();
				
				var ret_app_form_data=$('#ret_app_form').serialize();
				$.ajax({
						url:site_url()+'form/ret_app_form_hfa_submit',
						type:'POST',
						data:ret_app_form_data,
						success:function(data)
							{
								$ret_app_btn_process.hide();
								$ret_app_btn.show();
								
									if(data=='not-found')
										$('#ret_app_error').show();
									else
									{
										$('#ret_app_found_email').text(ret_app_email);
										$('#ret_app_found_continue').attr('href',data);
										$('#ret_app_link').show();
									}
							}
					});
			}		
			
		});
	
	
	$('#hfa_contact_time').timepicker();
	
	
	$('#postal_address_same, #postal_address_provide').click(function(){
		if($('input[name=hfa_postal_address]:checked').val()==0)
			$('#postal_address_provideDiv').slideUp();
		else	
			$('#postal_address_provideDiv').slideDown();
	});
	
	$('#arrival_time').timepicker({
        minuteStep: 5,
        showInputs: false,
        disableFocus: true
    });

    $("#share_house_first_name_error,#share_house_last_name_error,#share_house_mobile_error,#share_house_email_error,#share_house_nationality_error,#share_house_arrival_date_error,#share_house_arrival_time_error,#share_house_flight_no_error,#share_house_college_name_error,#share_house_college_address_error").hide();

    $('#arrival_date').datepicker({
        changeMonth: true,
        changeYear: true,
        defaultDate: "<?php echo date('d/m/Y'); ?>",
        dateFormat: 'dd/mm/yy'
    });




	$('#hfaOneSubmitBtn').click(function(){

		var $hfaOneProcess=$('#hfaOneProcess');
		var $hfaOneSubmitBtn=$('#hfaOneSubmitBtn')
			
		var $share_house_first_name = $('#first_name');
        var $share_house_last_name = $('#last_name');
        var $share_house_mobile = $('#mobile');

        var $share_house_email = $('#email');
        var $share_house_nationality = $('#nationality');

        var $share_house_arrival_date = $('#arrival_date');

        var $tncError=$('#tncError');
        var $tnc=$('#tnc');
        

        var share_house_first_name = $share_house_first_name.val().trim();
        var share_house_last_name = $share_house_last_name.val().trim();;
        var share_house_mobile = $share_house_mobile.val().trim();
        var share_house_email = $share_house_email.val().trim();
        var share_house_nationality = $share_house_nationality.val().trim();
        var share_house_arrival_date = $share_house_arrival_date.val().trim();
       	
       	var tnc=$tnc.is(':checked');

        removeFieldError($share_house_first_name);
        removeFieldError($share_house_last_name);
        removeFieldError($share_house_mobile);
        removeFieldError($share_house_email);
        removeFieldError($share_house_nationality);
        removeFieldError($share_house_arrival_date);
        removeFieldError($tnc);
        $('#share_house_email_error').hide();

		if (share_house_first_name == '' || share_house_last_name == '' || share_house_mobile == '' ||  share_house_email==''|| !isValidEmailAddress(share_house_email)  || share_house_nationality == '' || share_house_arrival_date == '' || !tnc ) {
				
			if (share_house_first_name == '')
                addFieldError($share_house_first_name);
            else
                removeFieldError($share_house_first_name);

            if (share_house_last_name == '')
                addFieldError($share_house_last_name);
            else
                removeFieldError($share_house_last_name);
            
            if (share_house_mobile == '')
                addFieldError($share_house_mobile);
            else
                removeFieldError($share_house_mobile);
            
            if (share_house_nationality == '')
                addFieldError($share_house_nationality);
            else
                removeFieldError($share_house_nationality);
           
            if (share_house_email == '' || !isValidEmailAddress(share_house_email)) {
				if(share_house_email!='' && !isValidEmailAddress(share_house_email))
	                $('#share_house_email_error').show();
                addFieldError($share_house_email);
            } else
                removeFieldError($share_house_email);

            if (share_house_arrival_date == '')
                addFieldError($share_house_arrival_date);
            else
                removeFieldError($share_house_arrival_date);
			
            if(!tnc)
				$tncError.show();
			else
				$tncError.hide();

			//$('#hfaOneError').show();
			scrollToDiv('#add-hostfamily-application');
			errorBar('All fields marked with red are required');
		}
		else
		{
			$hfaOneProcess.show();
			$hfaOneSubmitBtn.hide();
			
			var host_family_application_oneData=$('#host_family_application_oneForm').serialize();
			$.ajax({
					url: site_url() + 'form/share_house_application_submit',
					type:'POST',
					data:host_family_application_oneData,
					success:function(data)
						{
							$(location).attr('href', site_url() + 'form/share_house_application_complete')
						}
				});
		}
		
	});
		
});
function clearRetAppFrom(){
	$('#ret_app_form')[0].reset();
	$('#ret_app_error, #ret_app_link').hide();
}		
</script>