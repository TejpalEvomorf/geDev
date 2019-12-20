<?php
$nameTitleList=nameTitleList();
$genderList=genderList();
$accomodationTypeList=houseTypeList();
$nationList=nationList();
$locaitons=officeList();
//echo "<pre>";
//print_r($formOne);
?>

<div id="student-homestay-application" class="wFormContainer new_forms add-hostfamily-application">
<legend class="headingHostForm">Share House Application Form 
<span class="hand-written">All fields with red asterick<span class="reqField"> * </span>are mandatory</span></legend>
  <div style="background:none;" class="">
  <div class="wForm" id="tfa_0-WRPR" dir="ltr">
  

 <form method="post" class="hintsBelow labelsAbove" id="frm_share_house_edit">
                <fieldset id="tfa_14" class="section column">
                    <fieldset id="" class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new">
                        <div class="hfa1_home_left">
                            <div class=" full_width_field">
                                <span class="hfa1_app_full">
									<label class="full_label" for="first_name">First Name <span class="reqField">*</span></label>
                                <input type="text" class="errorOnBlur full_input errorOnBlur" name="first_name" value="<?php echo $formOne['first_name'];?>" id="first_name">
                                </span>
                                <span id="share_house_first_name_error">First Name is wrong</span>
                            </div>
                            <div class=" full_width_field">
                                <span class="hfa1_app_full">
									<label class="full_label" for="last_name">Last Name <span class="reqField">*</span></label>
                                <input type="text" class="full_input errorOnBlur" name="last_name" value="<?php echo $formOne['last_name'];?>" id="last_name">
                                </span>
                                <span id="share_house_last_name_error">Last Name is wrong</span>
                            </div>
                            <div class=" full_width_field">
                                <span class="hfa1_app_full">
									<label class="full_label" for="mobile">Mobile number <span class="reqField">*</span></label>
									<input type="text" class="full_input  errorOnBlur" name="mobile" value="<?php echo $formOne['mobile'];?>" id="mobile">
								</span>
                                <span id="share_house_phone_error">Mobile Number is wrong</span>
                            </div>
                            <div style="margin-top: 12px;" class=" full_width_field">
                                <span class="hfa1_app_full">
                                    <label class="full_label" for="gender">Gender</label>
                                    <input style="float:left;width:20px !important; margin-right:5px;" name="gender" value="1" type="radio">
                                    <label style="float:left; margin-right:34px; margin-bottom:13px; " for="gender" class="selt">Male</label>
                                    <input style="float:left; width:20px !important; margin-right:5px;" name="gender" value="2" type="radio">
                                    <label style="float:left; margin-right:35px; margin-bottom:13px; " for="" class="selttwo">Female</label>
                                </span>
                            </div>  
                            <div class=" full_width_field">
                                <span class="hfa1_app_full">
									<label class="full_label" for="email">Email ID <span class="reqField">*</span></label>
									<input type="text" class="full_input  errorOnBlur notReq" name="email" value="<?php echo $formOne['email'];?>" id="email" />
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
                            <div class="full_width_field">
                                <span class="hfa1_app_full">
									<label for="arrival_date" class="full_label">Arrival Date <span class="reqField">*</span></label>
									<input type="text" id="arrival_date" value="<?php if($formOne['arrival_date'] != '0000-00-00') { echo date('d/m/Y',strtotime($formOne['arrival_date'])); } ?>" name="arrival_date" class="full_input date-icon errorOnBlur"  readonly="readonly" />
								</span>
                                <span id="share_house_facebook_arrival_date_error">Please Enter Arrival Date</span>
                            </div>
                            <div class=" full_width_field">
                                <span class="hfa1_app_full">
                                    <label for="arrival_time" class="full_label">Arrival Time</label>
                                    <input type="text" id="arrival_time" value="<?php if($formOne['arrival_time'] !='00:00:00') { echo date( "H:i", strtotime($formOne['arrival_time'])); }?>" name="arrival_time" class="full_input date-icon errorOnBlur"  readonly="readonly" />
                                </span>
                                <span id="share_house_arrival_time_error">Arrival Time is wrong</span>
                            </div>
                            <div class=" full_width_field">
                                <span class="hfa1_app_full">
									<label class="full_label" for="flight_no">Flight Number</label>
                                <input type="text" class="full_input errorOnBlur" name="flight_no" value="<?php echo $formOne['flight_no'];?>" id="flight_no">
                                </span>
                                <span id="share_house_flight_no_error">Flight No is wrong</span>
                            </div>
                            <div class=" full_width_field">
                                <span class="hfa1_app_full">
                                    <label class="full_label" for="flight_no">College Name</label>
                                <input type="text" class="full_input errorOnBlur" value="<?php echo $formOne['college_name'];?>" name="college_name" value="" id="college_name">
                                </span>
                                <span id="share_house_flight_no_error">Flight No is wrong</span>
                            </div>
                            <div class=" full_width_field">
                                <span class="hfa1_app_full">
									<label class="full_label" for="college_address">College Address</label>
                                <input type="text" class="full_input errorOnBlur" name="college_address" value="<?php echo $formOne['college_address'];?>" id="college_address">
                                </span>
                                <span id="share_house_college_address_error">College Address is wrong</span>
                            </div>
                            <div style="margin-top: 12px;" class=" full_width_field">
                                <span class="hfa1_app_full">
                                    <label class="full_label" for="service_type">Service Type</label>
                                    <?php foreach($accomodationTypeList as $atK=>$atV){?>

                                    <div class="radio block"><label><input name="service_type" value="<?php echo $atK;?>" type="radio"><span class="circle"></span><span class="check"></span> <?php echo $atV?></label></div>
                                    <?php } ?>
                                </span>
                            </div> 
                        </div>
                    </fieldset>
                </fieldset>
                <div class="end-options-admin">
                	<input type="hidden" class="full_input errorOnBlur" name="id" value="<?php echo $formOne['id'];?>" id="id" />
                    <input type="button" value="Submit" id="shareHouseUpdateBtn" class="btn-btn-medium hfa_submit">
                    <div id="shaOneProcess" style="display:none;" class="appFormProcess">
                        <img src="<?php echo static_url()?>img/submitload.gif" />
                    </div>
                </div>
            </form>
</div>
</div>

</div>

<script type="text/javascript">
$(document).ready(function(){
	$("input:radio[name='gender'][value="+<?php echo $formOne['gender'];?>+"]").attr('checked','checked');
	$("#nationality").val(<?php echo $formOne['nationality'];?>);
	$("input:radio[name='service_type'][value="+<?php echo $formOne['service_type'];?>+"]").attr('checked','checked');

	$("#share_house_first_name_error,#share_house_last_name_error,#share_house_mobile_error,#share_house_email_error,#share_house_nationality_error,#share_house_facebook_arrival_date_error,#share_house_arrival_time_error,#share_house_flight_no_error,#share_house_college_name_error,#share_house_college_address_error,#share_house_phone_error").hide();
	
	$('#arrival_time').timepicker({
        minuteStep: 5,
        showInputs: false,
        disableFocus: true
    });

	$('#arrival_date').datepicker({
        changeMonth: true,
        changeYear: true,
        defaultDate: "<?php echo date('d/m/Y'); ?>",
        dateFormat: 'dd/mm/yy'
    });
	$('#shareHouseUpdateBtn').click(function(){
		
			var $shaOneProcess=$('#shaOneProcess');
			var $shaOneSubmitBtn=$('#shareHouseUpdateBtn');
			var $first_name=$('#first_name');
			var $last_name=$('#last_name');
			var $mobile=$('#mobile');
			var $email=$('#email');
			var $nationality=$('#nationality');
			var first_name=$first_name.val().trim();
			var last_name=$last_name.val().trim();;
			var mobile=$mobile.val().trim();
			var email=$email.val().trim();
			var nationality=$nationality.val().trim();
			
			var $tncError=$('#tncError');
			var $homestayGuidlinesError=$('#sha_guidelinesError');
			var $hfaOneError=$('#hfaOneError');
			
			$tncError.hide();
			$homestayGuidlinesError.hide();
			$hfaOneError.hide();
			
			removeFieldError($first_name);
			removeFieldError($last_name);
			removeFieldError($email);
			removeFieldError($nationality);
			removeFieldError($mobile);

			$('#share_house_email_error').hide();
			
			if(first_name=='' || last_name=='' || email=='' || !isValidEmailAddress(email) || nationality=='' || mobile=='')
			{
				if(first_name=='')	
					addFieldError($first_name);
				else	
					removeFieldError($first_name);
						
				if(last_name=='')	
					addFieldError($last_name);
				else	
					removeFieldError($last_name);
					
				if(email=='' || !isValidEmailAddress(email))	
				{
					if(email!='' && !isValidEmailAddress(email))
						$('#share_house_email_error').show();
					addFieldError($email);
				}
				else	
					removeFieldError($email);

				if(nationality=='')	
					addFieldError($nationality);
				else	
					removeFieldError($nationality);
				
				if(mobile=='')	
					addFieldError($mobile);
				else	
					removeFieldError($mobile);
					
					//$hfaOneError.show();
					scrollToDiv('#student-homestay-application');
					errorBar('All fields marked with red are required');
			}
			else
			{
				$shaOneProcess.show();
				$shaOneSubmitBtn.hide();
				
				var frm_share_house_edit=$('#frm_share_house_edit').serialize();
				var id=$('input[name=id]').val();
				$.ajax({
					url:site_url()+'houses/application_edit_one_submit',
					type:'POST',
					data:frm_share_house_edit,
					success:function(data)
					{
						window.location.href=site_url()+'houses/profile/'+id;
					}
				});
			}
		});
	});
</script>