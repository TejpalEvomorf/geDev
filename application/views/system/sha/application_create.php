<?php
$nameTitleList=nameTitleList();
$genderList=genderList();
$accomodationTypeList=accomodationTypeList();
$nationList=nationList();
$studyTourList=studyTourList();
$datePickerDobSettings=datePickerDobSettings();
?>
<div id="student-homestay-application" class="wFormContainer new_forms add-hostfamily-application">
    <legend class="headingHostForm">Student Homestay Application Form
        <span class="hand-written">All fields with red asterick<span class="reqField"> * </span>are mandatory</span>
    </legend>
    <div style="background:none;" class="">
        <div class="wForm" id="tfa_0-WRPR" dir="ltr">
            <form method="post" class="hintsBelow labelsAbove" id="sha_oneForm">
                <input type="hidden" name="filled_by" value="2" />
                <fieldset id="tfa_14" class="section column">
                    <fieldset id="" class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new">
                        <h3>Personal Details</h3>
                        <div class="hfa1_home_left">
                            <div class=" full_width_field">
                                <span class="hfa1_app_onefourth">
										<label class="onefourth_label full_label" for="sha_per_title_input">Title</label>
										<select name="sha_name_title" class="onefourth_input" id="sha_name_title">
											<option value="">Select</option>
											<?php foreach($nameTitleList as $ntK=>$ntV){?>
											<option value="<?=$ntK?>" class=""><?=$ntV?></option>
											<?php } ?>
										</select>
								</span>
                                <span class="hfa1_app_onefofth">
										<label class="full_label" for="sha_fname">First name <span class="reqField">*</span></label>
                                <input type="text" class="full_input errorOnBlur" name="sha_fname" value="" id="sha_fname">
                                </span>
                            </div>
                            <div class="hfa1_unit_street_name full_width_field">
                                <span class="hfa1_app_half margin_10">
										<label for="sha_mname" class="half_label full_label">Middle name</label>
										<input type="text" id="sha_mname" value="" name="sha_mname" class="half_input">
									</span>
                                <span class="hfa1_app_half">
										<label class="half_label full_label" for="sha_lname">Last name <span class="reqField">*</span></label>
                                <input type="text" class="half_input errorOnBlur" name="sha_lname" value="" id="sha_lname">
                                </span>
                            </div>
                            <div class="hfa1_unit_street_name full_width_field">
                                <span class="hfa1_app_half margin_10">
										<label for="sha_gender" class="half_label full_label">Gender <span class="reqField">*</span></label>
                                <select id="sha_gender" class="half_input errorOnBlur" name="sha_gender">
                                    <option value="">Select</option>
                                    <?php foreach($genderList as $glK=>$glV){?>
                                    <option value="<?=$glK?>">
                                        <?=$glV?>
                                    </option>
                                    <?php } ?>
                                </select>
                                </span>
                                <span class="hfa1_app_half">
										<label for="sha_dob" class="half_label full_label">Date of birth <span class="reqField">*</span></label>
                                <input style="float:left;"  type="text" id="sha_dob" value="" name="sha_dob" class="half_input date-of-birth3 date-icon errorOnBlur">
                                <span style="float:left; clear:both; padding-left: 0; margin-top: -6px;display:none;" id="sha_dob_error">Date format is wrong</span>
                                </span>
                                
                            </div>
                            <div class=" full_width_field">
                                <span class="hfa1_app_full">
										<label class="full_label" for="sha_email">Email <!--<span class="reqField">*</span>--></label>
                                <input style="float:left;" type="text" class="full_input errorOnBlur" name="sha_email" value="" id="sha_email">
                                <span style="float:left; clear:both; padding-left: 0;" id="sha_email_error">Email format is wrong</span>
                                </span>
                                
                            </div>
                            <div class=" full_width_field">
                                <span class="hfa1_app_full">
										<label class="full_label" for="sha_mobile">Mobile number </label>
                                <input type="text" class="full_input errorOnBlur" name="sha_mobile" value="" id="sha_mobile">
                                </span>
                            </div>
                            <div class=" full_width_field">
                                <span class="hfa1_app_full">
										<label class="full_label" for="sha_home_phone">Home phone number</label>
										<input type="text" class="full_input  errorOnBlur notReq" name="sha_home_phone" value="" id="sha_home_phone">
									</span>
                            </div>
                            
                            <div class=" full_width_field">
                                <span class="hfa1_app_full">
										<label for="sha_nationality" class="full_label">Nationality</label>
										<select class="full_input" id="sha_nationality" name="sha_nationality">
											<option value="">Select one</option>
											<?php foreach($nationList as $nlK=>$nlV){?>
											<option value="<?=$nlK?>" class=""><?=$nlV?></option>
											<?php } ?>
										</select>
									</span>
                            </div>
                            <div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="sha_student_no">Student College id/number </label>
			<input type="text" class="full_input errorOnBlur notReq" name="sha_student_no" value=" " id="sha_student_no">
			</span>
</div>
<div class=" full_width_field">
                                <span class="hfa1_app_full">
										<label class="full_label" for="sha_accomodation">Accommodation type <span class="reqField">*</span></label>
                                <select id="sha_accomodation" class="full_input errorOnBlur" name="sha_accomodation">
                                    <option value="">Select one</option>
                                    <?php foreach($accomodationTypeList as $atK=>$atV){?>
                                    <option value="<?=$atK?>" class="">
                                        <?=$atV?>
                                    </option>
                                    <?php } ?>
                                </select>
                                </span>
                            </div>
                            <div class=" full_width_field left_margin" id="type_accomodation" style="display:none;">
                                <span class="hfa1_app_full smoke-yes">
										<label for="sha_name2" class="full_label hidden_label">Second student name</label>
										<input type="text" id="sha_name2" value="" name="sha_name2" class="full_inputss">
									</span>
                            </div>
                        </div>
                        
                        <div class="hfa1_home_right">
						
                            
                            
                            <div class=" full_width_field">
                                <span class="hfa1_app_full">
										<label for="sha_passport" class="full_label">Passport number</label>
										<input type="text" id="sha_passport" value="" name="sha_passport" class="full_input">
									</span>
                            </div>
                            <div class=" full_width_field">
                                <span class="hfa1_app_full">
										<label for="sha_passport_expiry" class="full_label">Passport expiry date</label>
										<input type="text" id="sha_passport_expiry" value="" name="sha_passport_expiry" class="full_input date-of-birth3 date-icon" readonly="readonly">
									</span>
                            </div>
                            <div class=" full_width_field">
                                <span class="hfa1_app_full">
										<label for="sha_arrival_date" class="full_label">Arrival date</label>
										<input style="float:left;"  type="text" id="sha_arrival_date" value="" name="sha_arrival_date" class="full_input date-of-birth3 date-icon">
                                        <span style="float:left; padding-left: 0; clear:both;display:none;" id="sha_arrival_date_error">Date format is wrong</span>
									</span>
                                
                            </div>

                            <div class=" full_width_field">
                                        <span class="hfa1_app_full">
                                        <label for="sha_arrival_date" class="full_label hidden_label">Duration of stay</label>
                                        </span>
                                        <span class="hfa1_app_half margin_10">
                                        <label for="sha_duration_week" class="half_label full_label">Weeks</label>
                                        <input type="text" id="sha_duration_week" value="" name="sha_duration_week" class="half_input">
                                        </span>
                                        <span class="hfa1_app_half">
                                        <label for="sha_duration_day" class="half_label full_label">Days</label>
                                        <input type="text" id="sha_duration_day" value="" name="sha_duration_day" class="half_input">
                                        </span>
                            </div>
                            <div class=" full_width_field">
                                	<span class="hfa1_app_full" style="margin-top:2px; margin-bottom:5px;">
                                        <!--	<label for="study_group" class="full_label">Assign to a study group</label>
                                                <input type="text" id="study_group" value="" name="study_group" class="full_input">-->
                                        <input type="checkbox" name="study_group" id="study_group" value="1" style="margin-top:-3px; margin-right:5px;">
										 <span style="font-size: 14px; color: rgb(51, 51, 51);" class="">This student is a part of tour group</span>
                                    </span>
                                    
                                    <div class=" full_width_field left_margin" id="studyTourListDiv" style="display:none;">
                                            <span class="hfa1_app_full">
                                                  <label for="sha_study_group" class="full_label hidden_label">Tour group<span class="reqField">*</span></label>
                                                  <select id="sha_study_group" class="full_inputss errorOnBlur" name="sha_study_group" style="border-radius:0;">
                                                      <option value="">Select</option>
                                                      <?php foreach($studyTourList as $sTV){?>
                                                      <option value="<?=$sTV['id']?>">
                                                      <?=$sTV['group_name']?>
                                                      </option>
                                                  <?php } ?>
                                                  </select>
                                                  <p style="font-family: open sans; font-size: 12px;">If tour group is not in the list, then create the tour group first and then assign the application to that tour group.</p>
                                            </span>
                                    </div>
                            </div>
                            
                            <!--1111111111-->
                            
                            <fieldset style="padding-top:0;">
                            <h3 style="margin: 32px 0;">Emergency contact details</h3>
								 <div class=" full_width_field">
                                <span class="hfa1_app_full">
										<label class="full_label" for="sha_EC_name">Name</label>
		                                <input style="float:left;" type="text" class="full_input " name="sha_EC_name" value="" id="sha_EC_name">
                                </span>
                                
                            </div>
                            <div class=" full_width_field">
                                <span class="hfa1_app_full">
										<label class="full_label" for="sha_EC_relation">Relationship to student </label>
                                <input type="text" class="full_input " name="sha_EC_relation" value="" id="sha_EC_relation">
                                </span>
                            </div>
                            <div class=" full_width_field">
                                <span class="hfa1_app_full">
										<label class="full_label" for="sha_EC_phone">Phone number</label>
										<input type="text" class="full_input " name="sha_EC_phone" value="" id="sha_EC_phone">
									</span>
                            </div>
                            <div class=" full_width_field">
                                <span class="hfa1_app_full">
										<label class="full_label" for="sha_EC_email">Email</label>
										<input type="text" class="full_input " name="sha_EC_email" value="" id="sha_EC_email">
                                		<span style="float:left; clear:both; padding-left: 0;" id="sha_EC_email_error">Email format is wrong</span>
									</span>
                            </div>

						</fieldset>
                            <!--1111111111-->
                            
                        </div>
                    </fieldset>
                </fieldset>
                <div class="end-options-admin">
                    <input type="button" value="Submit" id="shaOneSubmitBtn" class="btn-btn-medium hfa_submit">
                    <div id="shaOneProcess" style="display:none;" class="appFormProcess">
                        <img src="<?=static_url()?>img/submitload.gif" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {

    $('#sha_dob').datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "<?=$datePickerDobSettings['year_from'].':'.$datePickerDobSettings['year_to']?>",
        defaultDate: "<?=$datePickerDobSettings['default_date']?>",
        dateFormat: 'dd/mm/yy'
    });

    $('#sha_arrival_date').datepicker({
        changeMonth: true,
        changeYear: true,
		yearRange: "c-5:c+10",
        dateFormat: 'dd/mm/yy'
    });
	
	    $('#sha_passport_expiry').datepicker({
        changeMonth: true,
        changeYear: true,
		 yearRange: "c-5:c+30",
        dateFormat: 'dd/mm/yy'
    });


		$('#study_group').change(function(){
				 if($('#study_group').is(':checked'))
						$('#studyTourListDiv').slideDown();
					else	
						$('#studyTourListDiv').slideUp();
			});

    $('#shaOneSubmitBtn').click(function() {

        var $shaOneProcess = $('#shaOneProcess');
        var $shaOneSubmitBtn = $('#shaOneSubmitBtn');

        var $sha_fname = $('#sha_fname');
        var $sha_lname = $('#sha_lname');
        var $sha_gender = $('#sha_gender');
        var $sha_dob = $('#sha_dob');
        var $sha_email = $('#sha_email');
        var $sha_mobile = $('#sha_mobile');
        var $sha_home_phone = $('#sha_home_phone');
        var $sha_accomodation = $('#sha_accomodation');
		var $study_group_check=$('#study_group');
		var $sha_study_group=$('#sha_study_group');
		var $sha_arrival_date=$('#sha_arrival_date');
		var $sha_EC_email=$('#sha_EC_email');
		
        var sha_fname = $sha_fname.val().trim();
        var sha_lname = $sha_lname.val().trim();;
        var sha_gender = $sha_gender.val();
        var sha_dob = $sha_dob.val().trim();
        var sha_email = $sha_email.val().trim();
        var sha_mobile = $sha_mobile.val().trim();
        var sha_home_phone = $sha_home_phone.val().trim();
        var sha_accomodation = $sha_accomodation.val().trim();
		var sha_study_group=$sha_study_group.val().trim();
		var sha_arrival_date=$sha_arrival_date.val().trim();
		var sha_EC_email=$sha_EC_email.val().trim();

        removeFieldError($sha_fname);
        removeFieldError($sha_lname);
        removeFieldError($sha_gender);
        removeFieldError($sha_dob);
        removeFieldError($sha_email);
        removeFieldError($sha_mobile);
        removeFieldError($sha_home_phone);
        removeFieldError($sha_accomodation);
		removeFieldError($sha_study_group);
		removeFieldError($sha_arrival_date);
		removeFieldError($sha_EC_email);
        $('#sha_email_error, #sha_dob_error, #sha_arrival_date_error, #sha_EC_email_error').hide();

        if (sha_fname == '' || sha_lname == '' || sha_gender == '' || sha_dob == '' || (sha_dob!='' && !isValidDate(sha_dob)) /*|| sha_email == '' || !isValidEmailAddress(sha_email)*/|| (sha_email != '' && !isValidEmailAddress(sha_email)) ||  isNaN(sha_mobile) || sha_accomodation == '' || (sha_home_phone != '' && isNaN(sha_home_phone)) || ($study_group_check.is(':checked') && sha_study_group=='') || (sha_arrival_date!='' && !isValidDate(sha_arrival_date))|| (sha_EC_email != '' && !isValidEmailAddress(sha_EC_email))) {
            if (sha_fname == '')
                addFieldError($sha_fname);
            else
                removeFieldError($sha_fname);

            if (sha_lname == '')
                addFieldError($sha_lname);
            else
                removeFieldError($sha_lname);

            if (sha_gender == '')
                addFieldError($sha_gender);
            else
                removeFieldError($sha_gender);

            if (sha_dob == '')
                addFieldError($sha_dob);
            else
			{
                removeFieldError($sha_dob);
				
				if(!isValidDate(sha_dob))
				{
					  $('#sha_dob_error').show();
					addFieldError($sha_dob);
				}
			}
			

            /*if (sha_email == '' || !isValidEmailAddress(sha_email)) {
                if (sha_email != '' && !isValidEmailAddress(sha_email))
                    $('#sha_email_error').show();
                addFieldError($sha_email);
            } else
                removeFieldError($sha_email);*/
				
			if(sha_email != '' && !isValidEmailAddress(sha_email))
			{
				$('#sha_email_error').show();
                addFieldError($sha_email);
			}
			else
				removeFieldError($sha_email);
			

          /*  if (sha_mobile == '' || isNaN(sha_mobile))
                addFieldError($sha_mobile);
            else
                removeFieldError($sha_mobile);
*/
            if (sha_home_phone != '' && isNaN(sha_home_phone))
                addFieldError($sha_home_phone);
            else
                removeFieldError($sha_home_phone);

            if (sha_accomodation == '')
                addFieldError($sha_accomodation);
            else
                removeFieldError($sha_accomodation);
			
			if($study_group_check.is(':checked') && sha_study_group=='')
				addFieldError($sha_study_group);
            else
                removeFieldError($sha_study_group);
			
			
			if(sha_arrival_date!='' && !isValidDate(sha_arrival_date))
			{
				$('#sha_arrival_date_error').show();
				addFieldError($sha_arrival_date);
			}
				
			if(sha_EC_email != '' && !isValidEmailAddress(sha_EC_email))
			{
				$('#sha_EC_email_error').show();
                addFieldError($sha_EC_email);
			}
			else
				removeFieldError($sha_EC_email);

            scrollToDiv('#student-homestay-application');
            errorBar('All fields marked with red are required');
        } else {
            $shaOneProcess.show();
            $shaOneSubmitBtn.hide();

            var sha_oneForm = $('#sha_oneForm').serialize();
            $.ajax({
                url: site_url() + 'form/sha_one_submit',
                type: 'POST',
                data: sha_oneForm,
                success: function(data) {
                    if (data == 'duplicate-email') {
                        scrollToDiv('#student-homestay-application');
                        errorBar('Email id already used, use some other email id');
                        addFieldError($sha_email);
                        $shaOneSubmitBtn.show();
                        $shaOneProcess.hide();
                    } else {
                        window.location.href = site_url() + 'sha/new_application#applicationCreated';
                    }
                }
            });

        }

    });
});
</script>