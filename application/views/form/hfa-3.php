<?php
$nameTitleList=nameTitleList();
$smokingHabbits=smokingHabbits();
$religionList=religionList();
$languageList=languageList();
$languagePrificiencyList=languagePrificiencyList();
$genderList=genderList();
$family_role=family_role();
$nationList=nationList();
$wwccTypeList=wwccTypeList();

$familyMembers=$form_one['family_members'];
$fmTitle=$fmFname=$fmLname='';
if($form_one['title']!=0)
		$fmTitle=$form_one['title'];
$fmFname=$form_one['fname'];
$fmLname=$form_one['lname'];
$fmMobile=$form_one['mobile'];

$datePickerDobSettings=datePickerDobSettings();
?>

<!--Success Pop Up STARTS-->
  <div class="modal fade successPop" id="hfa_successPopUpTwo"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h2 class="modal-title"></h2>
							</div>
							<div class="modal-body">
								<img src="<?=str_replace('http:','https:',static_url())?>img/tick.png" />
								<h3>Second Step of your Host Family application (Property Details), has been submitted successfully.</h3>
								<p>You can continue to next step or if you wish to do that later, you can use the link sent in your email upon completion of first step.</p>
                                <a href="javascript:void(0)" data-dismiss="modal">CONTINUE TO NEXT STEP</a>
							</div>
							<div class="modal-footer">
                            <span style="font-weight:bold; color:#1d7643; background:#eeeeee;">Step 1: Personal Details (complete) <img src="<?=str_replace('http:','https:',static_url())?>img/complete-tick.png" /></span>
                            <span style="font-weight:bold; color:#1d7643; background:#eeeeee;">Step 2: Property Details (complete) <img src="<?=str_replace('http:','https:',static_url())?>img/complete-tick.png" /></span>
                            <span>Step 3: Family details</span>
                            <span>Step 4: Student preferences</span>
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div>
<!--Success Pop ENDS-->

<div class="wFormContainer new_forms add-hostfamily-application dd-hostfamily-applicatio3" id="add-hostfamily-application-2">

<legend class="headingHostForm">Host Family Application Form
<span class="hand-written">All fields with red asterick<span class="reqField"> * </span>are mandatory</span></legend>

<div style="background:none;" class="">
  <div class="wForm" id="tfa_0-WRPR" dir="ltr">
  
<form method="post" action="" class="hintsBelow labelsAbove" id="host_family_application_threeForm">
<input type="hidden" name="id" value="<?=$id?>" />

<div id="membersLoadingDiv"><img src="<?=str_replace('http:','https:',static_url())?>system/img/loading-filters.gif" style="margin: 0 auto;" /></div>

<div id="tfa_0-A" class="actions add_new_submission"><h4>FAMILY DETAILS</h4></div>

<fieldset id="tfa_8" class="section column" style="display:none;">
<fieldset id="" class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new">

<fieldset class="hfa1_top_block">
<h3>Family Member Details</h3>

<div class=" full_width_field" style="margin-top:2px;">
			<span class="hfa1_app_half">
			<label for="hfa_family_member" class="full_label">Number of members in your family <span class="reqField">*</span></label>
            <select class="full_input errorOnBlur" name="hfa_family_member" id="hfa_family_member">
            <option value="">Select one</option>
            <?php for($fm=1;$fm<=9;$fm++){?>
	            <option value="<?=$fm?>" <?php if($fm==$familyMembers){?>selected="selected"<?php } ?>><?=$fm?></option>
            <?php } ?>
            </select>
			</span>
</div>

</fieldset>

<?php for($x=1;$x<=9;$x++){ ?>
<fieldset class="hfa1_top_block_bedrooms hfa_family_member_details" id="hfa_family_member_details_<?php echo $x;?>" <?php if($familyMembers<$x){?>style="display:none;"<?php } ?>>

<div class="hfa-member-heading-cont"><h2><?php if($x==1) echo 'PRIMARY APPLICANT'; else echo 'SECONDARY APPLICANT'; ?> DETAILS (Member <?php echo $x;?>)</h2></div>

<div class="hfa1_home_left">		

<div class=" full_width_field">
				<span class="hfa1_app_onefourth">
				<label class="onefourth_label full_label" for="hfa1_family_title">Title</label>
				 <select name="hfa_family-<?=$x?>[title]" class="onefourth_input" id="hfa_family_title-<?=$x?>">
				<option value="">Select</option>
                <?php foreach($nameTitleList as $ntK=>$ntV){?>
	                <option value="<?=$ntK?>" <?php if($fmTitle==$ntK && $x==1){echo 'selected="selected"';}?>><?=$ntV?></option>
                <?php } ?>
				</select>
				</span>
              <span class="hfa1_app_onefofth">
			<label class="full_label" for="hfa_fname_family-<?=$x?>">First name <span class="reqField">*</span></label>
			<input type="text" class="full_input hfa_fname_family errorOnBlur" name="hfa_family-<?=$x?>[fname]" value="<?php if($x==1){echo $fmFname;}?>" id="hfa_fname_family-<?=$x?>">
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="hfa_lname_family-<?=$x?>">Last name <span class="reqField">*</span></label>
			<input type="text" class="full_input hfa_lname_family errorOnBlur" name="hfa_family-<?=$x?>[lname]" value="<? if($x==1){echo $fmLname;}?>" id="hfa_lname_family-<?=$x?>">
			</span>
</div>

<div class="hfa1_unit_street_name full_width_field">
			<span class="hfa1_app_half margin_10">
			<label class="half_label full_label" for="hfa_dob_family-<?=$x?>">Date of birth <span class="reqField">*</span></label>
			<input type="text" class="half_input date-icon hfa_dob_family errorOnBlur date-of-birth3" name="hfa_family-<?=$x?>[dob]" value="" id="hfa_dob_family-<?=$x?>"  readonly="readonly">
			</span>
			<span class="hfa1_app_half">
			<label class="half_label full_label" for="hfa_gender_family-<?=$x?>">Gender <span class="reqField">*</span></label>
            <select name="hfa_family-<?=$x?>[gender]" class="half_input hfa_gender_family errorOnBlur" id="">
            <option value="">Select</option>
            <?php foreach($genderList as $glK=>$glV){?>
            <option value="<?=$glK?>"><?=$glV?></option>
            <?php } ?>
            </select>
			</span>
</div>
<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="hfa_contact_number_family-<?=$x?>">Contact number <span class="reqField">*</span></label>
			<input type="text" class="full_input" name="hfa_family-<?=$x?>[contact_number]" value="<? if($x==1){echo $fmMobile;}?>" id="hfa_contact_number_family-<?=$x?>">
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="hfa_role_family<?=$x?>" class="full_label">Family role</label>
            <select data-id="<?= $x?>" class="full_input familyrole" name="hfa_family-<?=$x?>[role]" id="hfa_role_family<?=$x?>">
            <option value="">Select one</option>
            <?php foreach($family_role as $frK=>$frV){?>
	            <option  value="<?=$frK?>"><?=$frV?></option>
            <?php } ?>
            </select>
			</span>
			<span class="full_width_field left_margin left_marginss" id="hfa_role_family_other-<?= $x ?>"  style="display:none;"  >
                <label   for="" class="full_label hidden_label">Other family role </label>
                <input type="text" id='other_role-<?= $x ?>'  name="hfa_family-<?=$x?>[other_role]" class="halfss_inputss errorOnBlur" value=""	/>	
				
</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="hfa1_occupation_family" class="full_label">Occupation</label>
			<input type="text" id="hfa_occupation_family-<?=$x?>" value="" name="hfa_family-<?=$x?>[occu]" class="full_input">
			</span>
</div>


       

</div>

<div class="hfa1_home_right">
<div class=" full_width_field smoke-yes">
			<span class="hfa1_app_full">
			<label for="hfa_smoker_family-<?=$x?>" class="full_label">Does this person smoke? <span class="reqField">*</span></label>
            <select class="full_input hfa_smoker_family errorOnBlur" name="hfa_family-<?=$x?>[smoke]" id="hfa_smoker_family-<?=$x?>">
            <option value="">Select one</option>
           		 <?php foreach($smokingHabbits as $shK=>$shV){?>               
                	<option  value="<?=$shK?>"><?=$shV?></option>
                <?php } ?>
            </select>
			</span>
</div>
<div class=" full_width_field smoke-yes">
			<span class="hfa1_app_full">
			<label for="hfa_nation_family-<?=$x?>" class="full_label">Ethnicity</label>
            <select class="full_input" name="hfa_family-<?=$x?>[nation]" id="hfa_nation_family-<?=$x?>">
            <option value="">Select one</option>
            <?php foreach($nationList as $nlK=>$nlV){?>
            	<option  value="<?=$nlK?>"><?=$nlV?></option>
          	<?php } ?>
            </select>
			</span>
</div>

<div class=" full_width_field smoke-yes">
			<span class="hfa1_app_full">
			<label class="full_label" for="hfa1_room_availability">How many languages does this family member speak? <span class="reqField">*</span></label>
				<select class="full_input hfa_family_member_language errorOnBlur" id="hfa_family_member_language-<?php echo $x;?>" name="hfa_family-<?=$x?>[languages]">
                <option value="">Select one</option>
                <option class=""  value="1">1 language</option>
                <option class=""  value="2">2 languages</option>
                <option class=""  value="3">3 languages</option>
                <option class=""  value="4">4 languages</option>
                <option class=""  value="5">5 languages</option>
                </select>
			</span>
</div>

<?php for($y=1;$y<=5;$y++){?>
    <div class=" full_width_field left_margin hfa_family_member_language_details hfa_family_member_language_details_<?php echo $y;?> margin_bottom_zero" style="display:none;">
                <span class="hfa1_app_halfs margin_10 smoke-yes smoke-yes11">
                <label class="full_label hidden_label" for="">Language <?php echo $y;?> <span class="reqField">*</span></label>
                <select  data-id="<?= $x.$y?>"  name="hfa_family-<?=$x?>[languages-<?=$y?>][language]" class="othersel halfs_input hfa_family_language errorOnBlur">
                <option value="">Select one</option>
                <?php foreach($languageList as $llK=>$llV){?>
	                <option class="" value="<?=$llK?>"><?=$llV?></option>
                <?php } ?>
                </select>
                </span>
                
                <span class="hfa1_app_halfs margin_10 smoke-yes smoke-yes11">
                <label class="full_label hidden_label" for="">Proficiency</label>
                <select id="" name="hfa_family-<?=$x?>[languages-<?=$y?>][prof]" class="halfs_input">
                <option value="">Select one</option>
                <?php foreach($languagePrificiencyList as $lpK=>$lpV){?>
	                <option value="<?=$lpK?>"><?=$lpV?></option>
                <?php } ?>
                </select>
                </span>   
                
                <span class="full_width_field" style="display:none;" id="olang-<?= $x.$y ?>">
                <label for="" class="full_label hidden_label">Other language</label>
                				<input type="text" id='lang-<?= $x.$y ?>'  name="hfa_family-<?=$x?>[languages-<?=$y?>][other_language]" class="halfss_inputss hfa_family_language errorOnBlur" value=""  />
                                </span>

                         
    </div>
<?php } ?>
<div class="wwccWrapperHfa" style="display:none;">
<div class=" full_width_field dob-under-eighteen">
			<span class="hfa1_app_full">
			<label for="" class="full_label">Do you have the "Working with Children" (WWCC) check completed? <span class="reqField">*</span></label>
				<select id="hfa_working_children-<?php echo $x;?>" name="hfa_family-<?=$x?>[wwcc]" class="full_input hfa_working_children errorOnBlur">
                <option value="">Select one</option>
                <option value="1" id="" class="">Yes</option>
                <option value="0" class="">No</option>
                </select>
			</span>
</div>

<div class=" full_width_field left_margin" id="type_wwcc_clearance_<?php echo $x;?>" style="margin-bottom:3px; display:none;">
			<span class="hfa1_app_full smoke-yes lolo">
			<label for="" class="full_label hidden_label">Have you received clearance? <span class="reqField">*</span></label>
            <select id="hfa_type_wwcc_clearance-<?php echo $x;?>" name="hfa_family-<?=$x?>[wwcc_clear]" class="full_input_select hfa_type_wwcc_clearance errorOnBlur">
            <option value="">Select one</option>
            <option value="1" id=" " class="">Yes</option>
            <option value="0" class="">No</option>
            </select>
			</span>
</div>

<div style="display:none;" id="clearance_non_availability_<?php echo $x;?>" class=" full_width_field left_margin">
			<span class="hfa1_app_full smoke-yes lolol">
            <label class="full_label hidden_label" for="hfa1_type_wwcc_application_number">Provide application no.</label>
            <input type="text" class="full_inputss" name="hfa_family-<?=$x?>[wwcc_appli_num]" value="" id="hfa1_type_wwcc_application_number">
			</span>
</div>
<div style="display:none;" id="clearance_availability_<?php echo $x;?>" class=" full_width_field left_margin">
			<span class="hfa1_app_halfs margin_10 smoke-yes lolol">
			<label class="full_label hidden_label" for="hfa1_type_wwcc_clearance_number">Clearance no.</label>
			<input type="text" class="halfs_input" name="hfa_family-<?=$x?>[wwcc_clear_num]" value="" id="hfa1_type_wwcc_clearance_number">
			</span>
            <span class="hfa1_app_halfs smoke-yes lolol">
			<label class="full_label hidden_label" for="">Expiry date</label>
			<input type="text" class="halfs_input date-icon hfa_wwcc_expiry" name="hfa_family-<?=$x?>[wwcc_clear_expiry]" value=""   readonly="readonly">
			</span>
            <span class="hfa1_app_full smoke-yes lolol">
			<label style="width:260px;" class="full_label hidden_label wwcc-field" for="hfa1_type_wwcc_photo">Upload a scanned copy of the WWCC for this person</label>
			<input type="button" class="full_input_select choose-btn" name="" value="Choose file" id="hfa_wwcc_file_btn-<?=$x?>" onclick="$('#hfa_wwcc_file-<?=$x?>').trigger('click');">
            <input type="file" id="hfa_wwcc_file-<?=$x?>" name="hfa_family-<?=$x?>[wwcc_file]" class="hfa_wwcc_file" style="display:none;">
			</span>
            <span id="hfa_wwcc_file_name-<?=$x?>" class="hfa_wwcc_file_name" style="display:none;float:left;width:100%;">
            	<p id="hfa_wwcc_file_name_text-<?=$x?>" class="hfa_wwcc_file_name_text" style="display:none;"></p>
            	<a href="javascript:void(0);" id="hfa_upload_diff_file-<?=$x?>" class="hfa_upload_diff_file">Upload different file</a>
            </span>
</div>
</div>

</div>


</fieldset>
<?php } ?>

</fieldset>
</fieldset>



<fieldset class="section column" id="tfa_9">
<fieldset class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new" id="">

<h3>Pet Details</h3>

<div class="hfa1_home_left">		

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="hfa_pet">Do you have pets? <span class="reqField">*</span></label>
				<select id="hfa_pet" name="hfa_pets" class="full_input errorOnBlur">
                <option value="">Select one</option>
                <option value="1" id="" class="">Yes</option>
                <option value="0" id="" class="">No</option>
				</select>
			</span>
</div>

<div class=" full_width_field" style="display:none;" id="what_pets_lives">
			<span class="hfa1_app_full" style="width: 55%;">
			<label class="full_label hidden_label" for="hfa1_what_pet">What pets?</label>
			<input type="checkbox" style="float:left;width:20px !important; margin-right:5px;" name="hfa_pet[dog]" value="1">
            <label style="float: left; margin-right: 50px; margin-bottom: 5px;" for="" class="selt wtpt">Dog</label>
            <input type="checkbox" style="float:left; width:20px !important; margin-right:5px;" name="hfa_pet[bird]" value="1">
            <label style="float: left; margin-bottom: 5px; margin-right: 48px;" for="" class="selt wtpt">Bird</label>
            <input type="checkbox" style="float:left; width:20px !important; margin-right:5px;" name="hfa_pet[cat]" value="1">
            <label style="float: left; margin-bottom: 5px; margin-right: 54px;" for="" class="selt wtpt">Cat</label>
            <input type="checkbox" class="hfa_checkbox_input " style="float:left; width:20px !important; margin-right:5px;" name="hfa_pet[other]" value="1"  id="pet_other">
            <label style="float: left; margin-right: 35px; margin-bottom: 5px;" for="" class="selt wtpt"  name="hfa_pet[other]">Other</label>
			</span>
</div>

<div class=" full_width_field left_margin" id="type_pet" style="display:none;">
			<span class="hfa1_app_full">
			<label for="hfa1_type_pet" class="full_label hidden_label">Other pets <span class="reqField">*</span></label>
			<input type="text" id="hfa_other_pet_val" value="" name="hfa_pet[other_val]" class="full_inputss errorOnBlur">
			</span>
</div>
      
	 <div class=" full_width_field" style="display:none;" id="pets_lives">
			<span class="hfa1_app_full smoke-yes">
			<label for="hfa_pet_in" class="full_label">Do the pets live inside the house?</label>
				<select id="hfa_pet_in" name="hfa_pet_in" class="full_input">
                <option value="">Select one</option>
                <option value="1" id=" " class="">Yes</option>
                <option value="0" class="">No</option>
                </select>
			</span>
	</div>
     
</div>


<div class="hfa1_home_right">

    <div class=" full_width_field"  style="display:none;" id="pet_desc">
                    <span class="hfa1_app_full">
                    <label for="hfa_family_desc" class="full_label">Pet description</label>
                    <textarea id="hfa_family_desc" value="" name="hfa_pet_desc" style="height:188px;padding:5px 10px;"></textarea>
                    </span>
    </div>

</div>


</fieldset>
</fieldset>


<fieldset id="tfa_10" class="section column">
<fieldset id="" class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new">

<h3>Insurance Details</h3>

<div class="hfa1_home_left">		

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="hfa_insurance" class="full_label" style="width:258px;">Do you have Public Liability insurance that covers the paying guests? <span class="reqField">*</span></label>
				<select class="full_input errorOnBlur" id="hfa_insurance" name="hfa_insurance">
                <option value="">Select one</option>
                <option class="" id="" value="1">Yes</option>
                <option class="" id="" value="0">No</option>
				</select>
			</span>
</div>

<div id="type_insurance_info" style="display:none; float:left;">
<p style="float:left; margin-bottom:0;"><a href="http://www.homestayhostinsuranceplus.com" target="_blank">Click here</a> to know more or to apply for Public Liability Insurance</p>
</div>

<div style="display: none;" id="type_insurance" class=" full_width_field left_margin">
			<span class="hfa1_app_full">
			<label class="full_label hidden_label" for="hfa1_insurance_provider">Insurance provider</label>
			<input type="text" class="full_inputss" name="hfa_insurance_provider" value="" id="hfa1_insurance_provider">
			</span>
            <span class="hfa1_app_halfs margin_10">
			<label for="hfa1_type_policy_number" class="full_label hidden_label">Policy no.</label>
			<input type="text" id="hfa1_type_policy_number" value="" name="hfa_policy_number" class="halfs_input">
			</span>
            <span class="hfa1_app_halfs">
			<label for="hfa1_type_wwcc_policy_expiry" class="full_label hidden_label">Expiry date</label>
			<input type="text" id="hfa1_type_wwcc_policy_expiry" value="" name="hfa_policy_expiry" class="halfs_input date-icon hfa_policy_expiry"   readonly="readonly">
			</span>
            
            <!--PL ins file-->
            <span class="hfa1_app_full wwcc-copy" style="padding-bottom:10px;">
			<label style="width:260px;" class="full_label hidden_label wwcc-field" for="hfa1_type_wwcc_photo">Upload a scanned copy of the Public Liability Insurance</label>
			<input type="button" class="full_input_select choose-btn" name="" value="Choose file" id="hfa_ins_file_btn" onclick="$('#hfa_ins_file').trigger('click');">
            <input type="file" id="hfa_ins_file" name="hfa_ins_file" class="hfa_ins_file" style="display:none;">
			</span>
            <span id="hfa_ins_file_name" class="hfa_ins_file_name" style="display:none;float:left;width:100%;">
            	<p id="hfa_ins_file_name_text" class="hfa_ins_file_name_text" style="display:none;"></p>
            	<a href="javascript:void(0);" id="hfa_upload_diff_file_ins" class="hfa_upload_diff_file_ins">Upload different file</a>
            </span>
            <!--PL ins file-->
            
            <span class="hfa1_app_full wwcc-copy">
			<label class="full_label hidden_label" for="hfa1_type_Liability_insurance" style="width:200px;">Does it provide $20 million Public Liability cover?</label>
            <select class="full_input_select" name="hfa_liability_insurance" id="hfa_Liability_insurance">
            <option value="">Select one</option>
            <option class="" id=" " value="1">Yes</option>
            <option class="" value="0">No</option>
            </select>
			</span>
</div>
      

</div>


<div class="hfa1_home_right">

<div class=" full_width_field" style="" id="content-insurance">
			<span class="hfa1_app_full smoke-yes">
			<label for="hfa1_content_insurance" class="full_label">Do you have Home Contents insurance?</label>
				<select id="hfa_content_insurance" name="hfa_content_insurance" class="full_input">
                <option value="">Select one</option>
                <option value="1" id=" " class="">Yes</option>
                <option value="0" class="">No</option>
                </select>
			</span>
</div>

</div>


</fieldset>
</fieldset>


<fieldset id="tfa_11" class="section column">
<fieldset id="" class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new">

<h3>General Details</h3>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="hfa1_religion" class="full_label">What is the main religion at home?</label>
				<select class="full_input" id="hfa_religion" name="hfa_religion">
                <option value="">Select one</option>
                <?php foreach($religionList as $rlK=>$rlV){ ?>
                	<option  value="<?=$rlK?>"><?=$rlV?></option>
                <?php } ?>
                <option  value="0">Other</option>
				</select>
			</span>
</div>

<div class=" full_width_field left_margin" id="religion_other" style="display:none;">
			<span class="hfa1_app_full">
			<label for="hfa1_type_pet" class="full_label hidden_label">Other religion <span class="reqField">*</span></label>
			<input type="text" id="hfa_religion_other" value="" name="hfa_religion_other" class="full_inputss errorOnBlur">
			</span>
</div>


<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="hfa1_international_student" class="full_label">Have you hosted international students in the past?</label>
				<select id="hfa_international_student" name="hfa_international_student" class="full_input">
                <option value="">Select one</option>
               <option  value="0">No</option>
              <option  value="1">Yes</option>
                </select>
			</span>
</div>

<div class=" full_width_field left_margin" id="international_student" style="display:none;">
			<span class="hfa1_app_full">
			<label for="hfa_exp" class="full_label hidden_label">What experience do you have as a homestay family?</label>
			<textarea id="hfa_exp" value="" name="hfa_exp" class="full_textarea"></textarea>
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="hfa_family_desc" class="full_label">Please describe your family</label>
            <p>Be sure to mention pastime and interests, hobbies, likes and dislikes. Any information here will be shared with your allocated placement and will help them understand your family and the experience they can look forward to. </p>
			<textarea id="hfa_family_desc" value="" name="hfa_family_desc" class="full_textareas"></textarea>
			</span>
</div>


<!--<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="" class="full_label">Please describe your home</label>
            <p>Be sure to mention any architectural features, atmosphere to expect and location based commentary. Any information 
here will be shared with your allocated placements and will help them understand your home and the experience they 
can look forward to.</p>
			<textarea id="hfa_home_desc" value="" name="hfa_home_desc" class="full_textareas"></textarea>
			</span>
</div>-->

</fieldset>
</fieldset>


<fieldset id="tfa_12" class="section column">
<fieldset id="" class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new">

<h3>Bank Account Details <b style="font-weight:400; color:hsl(146, 62%, 29%);">(for receiving payments)</b></h3>

<div class="hfa1_home_left">		

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="">Bank name</label>
			<input type="text" class="full_input" name="hfa_bank" value="" id="">
			</span>
</div>


<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="">Account name</label>
			<input type="text" class="full_input" name="hfa_account_name" value="" id="">
			</span>
</div>
      

</div>


<div class="hfa1_home_right bsb-ryt">

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="">BSB</label>
			<input type="text" class="full_input" name="hfa_bsb" value="" id="">
			</span>
</div>

<div class=" full_width_field bsb-ryt">
			<span class="hfa1_app_full">
			<label class="full_label" for="">Account number</label>
			<input type="text" class="full_input" name="hfa_account_num" value="" id="">
			</span>
</div>

</div>


</fieldset>
</fieldset>


<div class="end-options">
<input type="button" value="Submit &amp; continue" id="hfaThreeSubmitBtn" class="btn-btn-medium hfa_submit">

<div id="hfaThreeProcess" style="display:none;" class="appFormProcess">
	<img src="<?=str_replace('http:','https:',static_url())?>img/submitload.gif"   />
</div>

<span id="hfaThreeError" style="display:none;color:#F00;">The form is incomplete. Fields outlined with red are required in the right format.</span>
</div>

<p class="end-options-para">After submission, this part of the application wil be saved. You can always retrieve the saved application by clicking on Retrieve Saved 
Application button on the <a target="_blank" style="color:#000; text-decoration:underline;" href="<?=site_url()?>form/host_family_application">Host Family Application page</a> on Global experience website.</p>

</form>
</div>
</div>

</div>

<?php if($popUp!=''){?>
	<script type="text/javascript">
				$('#hfa_successPopUpTwo').modal({backdrop: 'static', keyboard: false});
    </script>
<?php } ?>

<script type="text/javascript">
$(document).ready(function(){
	$(".familyrole").change(function(){
	var lv=$(this).val();
	var d=$(this).data('id');
	//alert(lv);
	//alert(d);
	if(lv==17)
	$("#hfa_role_family_other-"+d).slideDown();
	
	else
		$("#hfa_role_family_other-"+d).slideUp();
})
	$(".othersel").change(function(){
	var lv=$(this).val();
	var d=$(this).data('id');
	//alert(lv);
	//alert(d);
	if(lv==25)
	$("#olang-"+d).slideDown();
	
	else
		$("#olang-"+d).slideUp();
})
	$('#tfa_8').show();
	$('#membersLoadingDiv').hide();
	
	$( '.hfa_wwcc_expiry, .hfa_policy_expiry' ).datepicker({
		  changeMonth: true,
		  changeYear: true,
		  yearRange: "c-5:c+20",
		  dateFormat: 'dd/mm/yy',
		});
		
	$( '.hfa_dob_family' ).datepicker({
		  changeMonth: true,
		  changeYear: true,
		  yearRange: "<?=$datePickerDobSettings['year_from'].':'.$datePickerDobSettings['year_to']?>",
		  defaultDate:"<?=$datePickerDobSettings['default_date']?>",
		  dateFormat: 'dd/mm/yy',
		});	
		
		$('#hfa_family_member').change(function(){
				$('.hfa_family_member_details').hide();
				var family_memer=$(this).val();
				
				if(family_memer!='')
					{
						var hashFamily='#hfa_family_member_details_1';
						if(family_memer>1)
						{
							for(var x=2;x<=family_memer;x++)
								hashFamily +=' ,#hfa_family_member_details_'+x;
						}
						$(hashFamily).show();
					}
			});
			
			$('.hfa_family_member_language').change(function(){
						var memberId=$(this).attr('id');
						var memberIdSplit=memberId.split('-');
						var parentContainer='#hfa_family_member_details_'+memberIdSplit[1];
						$(parentContainer+' .hfa_family_member_language_details').hide();
						var language=$(this).val();
						if(language!='')
						{
							var hashLanguage=parentContainer+' .hfa_family_member_language_details_1';
							if(language>1)
							{
								for(var x=2;x<=language;x++)
									hashLanguage +=' ,'+parentContainer+' .hfa_family_member_language_details_'+x;
							}
							$(hashLanguage).show();
						}
				});
	
	
	$('#hfaThreeSubmitBtn').click(function(){
		
			var $hfaThreeProcess=$('#hfaThreeProcess');
			var $hfaThreeSubmitBtn=$('#hfaThreeSubmitBtn')
		
			var $hfa_family_member=$('#hfa_family_member');
			var $hfa_pet=$('#hfa_pet');
			var $hfa_insurance=$('#hfa_insurance');
			var $hfa_other_pet_val=$('#hfa_other_pet_val');
			var $pet_other=$('#pet_other');
			var $hfa_religion_other=$('#hfa_religion_other');
			
			var hfa_family_member=$hfa_family_member.val();
			var hfa_pet=$hfa_pet.val();
			var hfa_insurance=$hfa_insurance.val();
			var hfa_other_pet_val=$hfa_other_pet_val.val().trim();
			var hfa_religion_other=$hfa_religion_other.val().trim();
			
			removeFieldError($hfa_family_member);
			removeFieldError($hfa_pet);
			removeFieldError($hfa_insurance);
			removeFieldError($hfa_other_pet_val);
			removeFieldError($hfa_religion_other);
			$('#hfaThreeError').hide();
			
			var hfaFamilyFname=true;
			var hfaFamilyLname=true;
			var hfaFamilyDob=true;
			var hfaFamilyGender=true;
			var hfaSmokerFamily=true;
			var hfaFamilyLanguages=true;
			var hfaFamilyLanguage=true;
			var hfaWorkingChild=true;
			var hfaWwccClear=true;
			
			hfaFamilyFname=multipleFieldValidation('hfa_fname_family');
			hfaFamilyLname=multipleFieldValidation('hfa_lname_family');
			hfaFamilyDob=multipleFieldValidation('hfa_dob_family');
			hfaFamilyGender=multipleFieldValidation('hfa_gender_family');
			hfaSmokerFamily=multipleFieldValidation('hfa_smoker_family');
			hfaFamilyLanguages=multipleFieldValidation('hfa_family_member_language');
			hfaFamilyLanguage=multipleFieldValidation('hfa_family_language');
			hfaWorkingChild=multipleFieldValidation('hfa_working_children');
			hfaWwccClear=multipleFieldValidation('hfa_type_wwcc_clearance');
			
			if(hfa_family_member=='' || hfa_pet=='' || hfa_insurance=='' || (hfa_pet!='0' && hfa_other_pet_val=='' && $pet_other.is(':checked')) || !hfaFamilyFname || !hfaFamilyLname || !hfaFamilyDob || !hfaFamilyGender || !hfaSmokerFamily || !hfaFamilyLanguages || !hfaFamilyLanguage|| !hfaWorkingChild || !hfaWwccClear || ($hfa_religion_other.is(':visible') && hfa_religion_other==''))
			{
				if(hfa_family_member=='')
					addFieldError($hfa_family_member);
				else
					removeFieldError($hfa_family_member);
					
				if(hfa_pet=='')
					addFieldError($hfa_pet);
				else
					removeFieldError($hfa_pet);
					
				if(hfa_insurance=='')
					addFieldError($hfa_insurance);
				else
					removeFieldError($hfa_insurance);
					
				if(hfa_pet!='0' && hfa_other_pet_val=='' && $pet_other.is(':checked'))
					addFieldError($hfa_other_pet_val);
				else
					removeFieldError($hfa_other_pet_val);
				
				if($hfa_religion_other.is(':visible') && hfa_religion_other=='')
					addFieldError($hfa_religion_other);
				else
					removeFieldError($hfa_religion_other);
					
				//$('#hfaThreeError').show();
				scrollToDiv('#add-hostfamily-application-2');
				errorBar('All fields marked with red are required');
			}
			else
			{
				$hfaThreeProcess.show();
				$hfaThreeSubmitBtn.hide();
				
				var host_family_application_threeData=$('#host_family_application_threeForm').serialize();
				//iPhone fix #Start
				var $form = $('#host_family_application_threeForm');
				var $inputs = $('input[type="file"]', $form);
				$inputs.each(function(_, input) {
				  if (input.files.length > 0) return
				  $(input).prop('disabled', true);
				})
				var formData = new FormData($form[0]);
				$inputs.prop('disabled', false);
				//iPhone fix #End
				
							$.ajax({
							url:site_url()+'form/host_family_application_three_submit',
							type:'POST',
							//data:host_family_application_threeData,
							//data:  new FormData($('#host_family_application_threeForm')[0]),
							data:formData,
							cache:false,
				            contentType: false,
            				processData: false,
							success:function(data)
								{
									$hfaThreeProcess.hide();
									//$hfaThreeSubmitBtn.show();
										
									if(data=='next')
										window.location.href=site_url()+'form/host_family_application_four/<?=$link?>/pop';
							}
					});
			}
		});
	
	function toggleAgeWrapper(memberNo,dob) {
		
		$.ajax({
			 url:site_url()+'form/exact_age_from_dob_jquery/'+dob, 
			 success:function(data){
				 	var result_age = data;
					var wwccWrapperHfa=$('#'+memberNo).find('.wwccWrapperHfa');
					if(result_age>17) {
						wwccWrapperHfa.slideDown();
					}
					else {
						wwccWrapperHfa.slideUp();
					}
					
			  }
		});
	}
	
	$(".hfa_dob_family").change(function(){
		
		var memberNo=$(this).parents('.hfa_family_member_details').attr('id');
		
		var from = $(this).val().split("/");
		//var dob = from[2], from[1] - 1, from[0];
		var dob = from[2]+'-'+from[1]+'-'+from[0];
		toggleAgeWrapper(memberNo,dob);
	});
		
		
		
		
		////////////////////
		$('#hfa_ins_file').change(function(){
				
				if (window.File && window.FileReader && window.FileList && window.Blob)
		  			{
						var $btn=$(this);
						//var id=$btn.attr('id').split('-');
				
						if (this.files && this.files[0]) 
							{
									if(!checkFileExt($(this).val()))
									  {
										   errorBar("Only .jpg, .jpeg or .png  or .pdf or .docx files are allowed");
									  }
									 else if(!checkFileSize($(this)[0].files[0].size))
									  {
										   errorBar("Please select file less than 2MB");
									  }
									  else
										{
											$('#hfa_ins_file_btn').hide();
											$('#hfa_ins_file_name').show();
											
											 $('#hfa_ins_file_name_text').text($btn.val()).show();
										}
							}
					}
		  		else
					{
						alert("Please upgrade your browser, because your current browser lacks some new features we need!");
						return false;
					}
				});
				
				$('#hfa_upload_diff_file_ins').click(function(){
						$('#hfa_ins_file_name').hide();
						$('#hfa_ins_file_name_text').text('').hide();
						$('#hfa_ins_file').val('');
						$('#hfa_ins_file_btn').show();
						
				});
		////////////////////////
		
		
	});
	

</script>