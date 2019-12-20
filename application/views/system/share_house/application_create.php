<?php
$nameTitleList=nameTitleList();
$genderList=genderList();
$accomodationTypeList=houseTypeList();
$nationList=nationList();
$locaitons=officeList();
?>
<div id="student-homestay-application" class="wFormContainer new_forms add-hostfamily-application">
    <legend class="headingHostForm">Shared House Application Form
        <span class="hand-written">All fields with red asterick<span class="reqField"> * </span>are mandatory</span>
    </legend>
    <div style="background:none;" class="">
        <div class="wForm" id="tfa_0-WRPR" dir="ltr">
            <form method="post" class="hintsBelow labelsAbove" id="frm_share_house_add">
                <fieldset id="tfa_14" class="section column">
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
									<label class="full_label" for="mobile">Mobile number <span class="reqField">*</span></label>
									<input type="text" class="full_input  errorOnBlur" name="mobile" value="" id="mobile">
								</span>
                                <span id="share_house_mobile_error">Mobile number is wrong</span>
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
									<label class="full_label" for="email">Email ID <span class="reqField">*</span></label>
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
									<label for="arrival_date" class="full_label">Arrival Date <span class="reqField">*</span></label>
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
                            <div style="margin-top: 12px;" class=" full_width_field">
                                <span class="hfa1_app_full">
                                    <label class="full_label" for="service_type">Service Type</label>
                                    <?php foreach($accomodationTypeList as $atK=>$atV){?>
                                    <div class="radio block"><label><input name="service_type" value="<?php echo $atK;?>" <?php if($atK==1) { echo 'checked="checked"'; } ?> type="radio"><span class="circle"></span><span class="check"></span> <?php echo $atV?></label></div>    
                                    <?php } ?>
                                </span>
                            </div>      
                        </div>
                    </fieldset>
                </fieldset>


                <div class="end-options-admin">
                    <input type="button" value="Submit" id="shareHouseSubmitBtn" class="btn-btn-medium hfa_submit">
                    <div id="shaOneProcess" style="display:none;" class="appFormProcess">
                        <img src="<?php echo static_url()?>img/submitload.gif" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
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
   
    $('#shareHouseSubmitBtn').click(function() {

        var $shaOneProcess = $('#shaOneProcess');
        var $shaOneSubmitBtn = $('#shareHouseSubmitBtn');

        var $share_house_first_name = $('#first_name');
        var $share_house_last_name = $('#last_name');
        var $share_house_mobile = $('#mobile');
        var $share_house_email = $('#email');
        var $share_house_nationality = $('#nationality');
        var $share_house_arrival_date = $('#arrival_date');
        var share_house_first_name = $share_house_first_name.val().trim();
        var share_house_last_name = $share_house_last_name.val().trim();;
        var share_house_mobile = $share_house_mobile.val().trim();
        var share_house_email = $share_house_email.val().trim();
        var share_house_nationality = $share_house_nationality.val().trim();
        var share_house_arrival_date = $share_house_arrival_date.val().trim();
       
        removeFieldError($share_house_first_name);
        removeFieldError($share_house_last_name);
        removeFieldError($share_house_mobile);
        removeFieldError($share_house_email);
        removeFieldError($share_house_nationality);
        removeFieldError($share_house_arrival_date);
       $('#share_house_email_error').hide();

        if (share_house_first_name == '' || share_house_last_name == '' || share_house_mobile == '' ||  share_house_email==''  || !isValidEmailAddress(share_house_email) || share_house_nationality == '' || share_house_arrival_date == '') {

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
              

            scrollToDiv('#student-homestay-application');
            errorBar('All fields marked with red are required');
        } else {
            $shaOneProcess.show();
            $shaOneSubmitBtn.hide();

            var frm_share_house_add = $('#frm_share_house_add').serialize();
            $.ajax({
                url: site_url() + 'houses/frm_share_house_submit',
                type: 'POST',
                data: frm_share_house_add,
                success: function(response) {
                        window.location.href = site_url()+'houses/new_application#applicationCreated';
                }
            });
        }

        
    });
});
</script>