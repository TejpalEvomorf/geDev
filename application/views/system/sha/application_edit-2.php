<?php
$nationList=nationList();
$religionList=religionList();
$languagePrificiencyList=languagePrificiencyList();
$languageList=languageList();
$guardianshipTypeList=guardianshipTypeList();
$age=age_from_dob($formOne['dob']);
?>


<div class="wFormContainer new_forms add-hostfamily-application dd-sha-applicatio2" id="student-homestay-application">

<legend class="headingHostForm">Student Homestay Application Form 
<span class="hand-written">All fields with red asterick<span class="reqField"> * </span>are mandatory</span></legend>

<div style="background:none;" class="">
  <div class="wForm" id="tfa_0-WRPR" dir="ltr">
  
<form method="post"  class="hintsBelow labelsAbove" id="sha_twoForm">
<input type="hidden" name="id" value="<?=$formOne['id']?>" />
<div id="tfa_0-A" class="actions add_new_submission"><h4>OTHER DETAILS</h4></div>

<fieldset class="section column" id="tfa_15">
<fieldset class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new" id="">

<h3>Your Details</h3>

<div class="hfa1_home_left">		

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="sha_student_language" class="full_label">How many languages do you speak? <span class="reqField">*</span></label>
				<select id="sha_student_language" class="full_input errorOnBlur" name="sha_student_language">
                <option value="">Select one</option>
                <option value="1" class="" <?php if($formTwo['languages']==1){echo 'selected="selected"';}?>>1 language</option>
                <option value="2" class="" <?php if($formTwo['languages']==2){echo 'selected="selected"';}?>>2 languages</option>
                <option value="3" class="" <?php if($formTwo['languages']==3){echo 'selected="selected"';}?>>3 languages</option>
                <option value="4" class="" <?php if($formTwo['languages']==4){echo 'selected="selected"';}?>>4 languages</option>
                <option value="5" class="" <?php if($formTwo['languages']==5){echo 'selected="selected"';}?>>5 languages</option>
                </select>
			</span>
</div>

<?php for($x=1;$x<=5;$x++){ ?>
<div class="margin_bottom_zero full_width_field left_margin sha_student_languages" <?php if($formTwo['languages']<$x){echo 'style="display:none;"';}?> id="sha_student_languages_details-<?=$x?>">
                <span class="hfa1_app_halfs margin_10 smoke-yes smoke-yes11">
                <label for="" class="full_label hidden_label">Language <?=$x?> <span class="reqField">*</span></label>
                <select class="othersel halfs_input sha_language errorOnBlur" name="sha_language[language-<?=$x?>][language]"  data-id="<?= $x?>" >
                <option value="">Select one</option>
                <?php foreach($languageList as $lK=>$lV){?>
	                <option value="<?=$lK?>" class="" <?php if(isset($formTwo['language'][$x-1]) && $formTwo['language'][$x-1]['language']==$lK){echo 'selected="selected"';}?>><?=$lV?></option>
                <?php } ?>
                </select>


                </span>
				
                <span class="hfa1_app_halfs margin_10 smoke-yes smoke-yes11">
                <label for="" class="full_label hidden_label">Proficiency</label>
                <select class="halfs_input" name="sha_language[language-<?=$x?>][prof]" id="">
                <option value="">Select one</option>
                <?php foreach($languagePrificiencyList as $lpK=>$lpV){?>
                	<option value="<?=$lpK?>"  class="" <?php if(isset($formTwo['language'][$x-1]) && $formTwo['language'][$x-1]['prof']==$lpK){echo 'selected="selected"';}?>><?=$lpV?></option>
                    <?php } ?>
                </select>
                </span>    
                
                <span id="olang-<?= $x ?>" <?php if(empty($formTwo['language'][$x-1]['other_language'] )) { ?> style="display:none;" <?php }  ?>>
                <label  style="clear:both;" for="" class="full_label hidden_label">Other language <span class="reqField">*</span></label>
                <input type="text" id='lang-<?= $x ?>'  name="sha_language[language-<?=$x?>][other_language]" class="halfss_inputss  sha_language errorOnBlur" value="<?php echo !empty($formTwo['language'][$x-1]['other_language'] ) ? $formTwo['language'][$x-1]['other_language']  :'' ?>" />
</span>
                        
    </div>
<?php } ?>   

</div>


<div class="hfa1_home_right">

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="hfa1_ethnicity_family">Ethnicity</label>
            <select id="sha_student_ethnicity" name="sha_student_ethnicity" class="full_input">
            <option value="">Select one</option>
           <?php foreach($nationList as $nlK=>$nlV){?>
	            <option value="<?=$nlK?>" class="" <?php if($formTwo['ethnicity']==$nlK){echo 'selected="selected"';}?>><?=$nlV?></option>
           <?php } ?>
            </select>
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="sha_student_religion" class="full_label">What is your religion</label>
				<select id="sha_student_religion" class="full_input" name="sha_student_religion">
                <option value="">Select one</option>
               <?php foreach($religionList as $rlK=>$rlV){?>
	                <option class="" value="<?=$rlK?>" <?php if($formTwo['religion']==$rlK){echo 'selected="selected"';}?>><?=$rlV?></option>
               <?php } ?>
                <option class="" value="0" <?php if($formTwo['religion']=="0"){echo 'selected="selected"';}?>>Other</option>
                </select>
			</span>
</div>

<div class=" full_width_field left_margin" id="type_religion" <?php if($formTwo['religion']!="0"){echo 'style=" display:none;"';}?>>
			<span class="hfa1_app_full smoke-yes lolol">
			<label for="sha_type_religion_input" class="full_label hidden_label">Other type of religion <span class="reqField">*</span></label>
			<input type="text" id="sha_religion_other_val" value="<?php if($formTwo['religion']=="0"){echo $formTwo['religion_other']; }?>" name="sha_religion_other_val" class="full_inputss errorOnBlur">
			</span>
</div>


</div>


</fieldset>
</fieldset>


<fieldset class="section column" id="tfa_16">
<fieldset class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new" id="">

<h3>Pet Details</h3>

<div class="hfa1_home_left">		

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="sha_new_pet_can">Can you live with pets? <span class="reqField">*</span></label>
				<select id="sha_live_with_pets" name="sha_live_with_pets" class="full_input errorOnBlur">
                <option value="">Select one</option>
                <option value="1" id="" class="" <?php if($formTwo['live_with_pets']==1){echo 'selected="selected"';}?>>Yes</option>
                <option value="0" id="" class="" <?php if($formTwo['live_with_pets']=="0"){echo 'selected="selected"';}?>>No</option>
				</select>
			</span>
</div>

<div class=" full_width_field" <?php if($formTwo['live_with_pets']!=1){echo 'style="display:none;"';}?> id="what_pets_lives_can">
			<span class="hfa1_app_full" style="width: 55%;">
			<label class="full_label hidden_label" for="hfa1_what_pet">Type of pets you can live with</label>
			<input type="checkbox" style="float:left;width:20px !important; margin-right:5px;" name="sha_pets[dog]" value="1" <?php if($formTwo['pet_dog']==1){echo 'checked="checked"';}?>>
            <label style="float: left; margin-right: 50px; margin-bottom: 5px;" for="" class="selt wtpt">Dog</label>
            <input type="checkbox" style="float:left; width:20px !important; margin-right:5px;" name="sha_pets[bird]" value="1" <?php if($formTwo['pet_bird']==1){echo 'checked="checked"';}?>>
            <label style="float: left; margin-bottom: 5px; margin-right: 48px;" for="" class="selt wtpt">Bird</label>
            <input type="checkbox" style="float:left; width:20px !important; margin-right:5px;" name="sha_pets[cat]" value="1" <?php if($formTwo['pet_cat']==1){echo 'checked="checked"';}?>>
            <label style="float: left; margin-bottom: 5px; margin-right: 54px;" for="" class="selt wtpt">Cat</label>
            <input type="checkbox" class="hfa_checkbox_input " style="float:left; width:20px !important; margin-right:5px;" name="sha_pets[other]" value="1"  id="sha_pet_other" <?php if($formTwo['pet_other']==1){echo 'checked="checked"';}?>>
            <label style="float: left; margin-right: 35px; margin-bottom: 5px;" for="sha_pet_other" class="selt wtpt" id="">Other</label>
			</span>
</div>

<div class=" full_width_field left_margin" id="sha_type_pet" <?php if($formTwo['pet_other']!=1){?>style="display:none;"<?php } ?>>
			<span class="hfa1_app_full">
			<label for="sha_type_pet_can" class="full_label hidden_label">Other type of pets <span class="reqField">*</span></label>
			<input type="text" id="sha_pet_other_val" value="<?php if($formTwo['pet_other']==1){ echo $formTwo['pet_other_val'];} ?>" name="sha_pets[other_val]" class="full_inputss errorOnBlur">
			</span>
</div>
      

</div>


<div class="hfa1_home_right">

<div class=" full_width_field" <?php if($formTwo['live_with_pets']!=1){echo 'style="display:none;"';}?> id="pets_lives_can">
			<span class="hfa1_app_full">
			<label for="sha_pet_live_inside" class="full_label">Can you live with pets inside the house? </label>
				<select id="sha_pet_live_inside" name="sha_pet_live_inside" class="full_input">
                <option value="">Select one</option>
                <option value="1" class="" <?php if($formTwo['pet_live_inside']==1){echo 'selected="selected"';}?>>Yes</option>
                <option value="0" class="" <?php if($formTwo['pet_live_inside']=="0"){echo 'selected="selected"';}?>>No</option>
                </select>
			</span>
</div>

</div>


</fieldset>
</fieldset>


<fieldset id="tfa_17" class="section column">
<fieldset id="" class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new">

<h3>Insurance Details</h3>

<div class="hfa1_home_left">		

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="sha_insurance" class="full_label" style="width:258px;">Do you have Travel Insurance? <span class="reqField">*</span></label>
				<select class="full_input errorOnBlur" id="sha_insurance" name="sha_insurance">
                <option value="">Select one</option>
                <option class="" id="" value="1" <?php if($formTwo['insurance']==1){echo 'selected="selected"';}?>>Yes</option>
                <option class="" id="" value="0" <?php if($formTwo['insurance']=="0"){echo 'selected="selected"';}?>>No</option>
				</select>
			</span>
</div>



<div <?php if($formTwo['insurance']!=1){echo 'style="display: none;"';}?> id="sha_type_insurance" class=" full_width_field left_margin">
			<span class="hfa1_app_full">
			<label class="full_label hidden_label" for="sha_insurance_provider">Insurance provider</label>
			<input type="text" class="full_inputss" name="sha_insurance_provider" value="<?php if($formTwo['insurance']==1){echo $formTwo['ins_provider'];}?>" id="sha_insurance_provider">
			</span>
            <span class="hfa1_app_halfs margin_10">
			<label for="sha_policy_number" class="full_label hidden_label">Policy no.</label>
			<input type="text" id="sha_policy_number" value="<?php if($formTwo['insurance']==1){echo $formTwo['ins_policy_no'];}?>" name="sha_insurance_policy_number" class="halfs_input">
			</span>
            <span class="hfa1_app_halfs">
			<label for="sha_type_policy_expiry" class="full_label hidden_label">Expiry date</label>
			<input type="text" id="sha_insurance_policy_expiry" value="<?php if($formTwo['insurance']==1 && $formTwo['ins_expiry']!='0000-00-00'){echo date('d/m/Y',strtotime($formTwo['ins_expiry']));}?>" name="sha_insurance_policy_expiry" class="halfs_input date-icon" readonly="readonly">
			</span>
</div>
      

</div>


<div class="hfa1_home_right">

<div class=" full_width_field" id="content_insurance_upload" <?php if($formTwo['insurance']!=1){echo 'style="display:none;"';}?>>
			<span class="hfa1_app_full">
			<label for="sha_type__photo" class="full_label hidden_label" style="width:260px;">Upload a scanned copy of your Travel Insurance</label>
			<input type="button" id="sha_ins_policy_file_choose" value="Choose file" name="" class="full_input_select choose-btn" <?php if($formTwo['ins_file']!=''){?>style="display:none;"<?php } ?>>
			
				
            
            </span>
            <input type="file" id="insPolicyFile" name="insPolicyFile"   style="display:none;">
            <input type="hidden" name="sha_file_update" value="<?php if($formTwo['ins_file']!=''){?>0<?php }else{echo 1;} ?>" id="sha_file_update" />
            <?php if($formTwo['ins_file']!=''){?>
            <input type="hidden" name="sha_ins_file_name_update" value="<?=$formTwo['ins_file']?>" id="sha_ins_file_name_update" />
           	<?php } ?>
            
            <p id="insPolicyFileChoosen" style="display:none;margin: 0px;"></p>
            <?php if($formTwo['ins_file']!='')
								{
                					echo '<p id="sha_ins_file_name_text_edit" style="margin: 0px; font-size: 14px;">';
										echo '<a href="'.static_url().'uploads/sha/ins/'.$formTwo['ins_file'].'" target="_blank">Preview file</a>';
									echo "</p>";
								}
						?>
            <a <?php if($formTwo['ins_file']==''){?>style="display:none;"<?php } ?> href="javascript:void(0);" id="insPolicyFileChooseAnother">Upload different file</a>
            <?php if($formTwo['ins_file']!=''){?>
                    <a class="sha_use_same_file" id="sha_use_same_file" href="javascript:void(0);" style="display:none;">Use the same file</a>
                <?php } ?>
</div>

</div>


</fieldset>
</fieldset>


<fieldset id="tfa_18" class="section column">
<fieldset id="" class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new">

<h3>Airport Pickup Service</h3>
<?php if($formOne['study_tour_id']!=0)
{?>
<div class="hfa1_home_left">		

			<div class=" full_width_field">
              <span class="hfa1_app_full">
                  <label class="full_label" for="">Family to pickup from meeting point</label>
                  <select class="full_input " name="family_pickup_from_meeting_point" >
                      <option value="">Select one</option>
                      <option class="" id="" value="1" <?php if($formTwo['family_pickup_meeting_point']=='1'){echo 'selected=""';}?>>Yes</option>
                      <option class="" id="" value="0" <?php if(($formTwo['family_pickup_meeting_point']=='0')){echo 'selected';}?>>No</option>
                  </select>
              </span>
              
              <span class="full_width_field">
                  <label class="full_label" for="">Airport pickup to meeting point</label>
                  <select class="full_input " name="airport_pickup_to_meeting_point" id="airport_pickup_homestay">
                      <option value="">Select one</option>
                      <option class="" id="" value="1" <?php if($formTwo['airport_pickup_meeting_point']=='1'){echo 'selected';}?>>Yes</option>
                      <option class="" id="" value="0" <?php if($formTwo['airport_pickup_meeting_point']=='0'){echo 'selected';}?>>No</option>
                  </select>
              </span>
        
              <span class="hfa1_app_full">
                  <label for="sha_airport_pickup_studyTour" class="full_label" style="width:258px;">Airport pick up to homestay</label>
                  <select class="full_input errorOnBlur" id="sha_airport_pickup_studyTour" name="sha_airport_pickup">
                      <option value="">Select one</option>
                      <option class="" id="" value="1" <?php if($formTwo['airport_pickup']==1){echo 'selected="selected"';}?>>Yes</option>
                      <option class="" id="" value="0" <?php if($formTwo['airport_pickup']=="0"){echo 'selected="selected"';}?>>No</option>
                  </select>
              </span>
        </div>


</div>

<div class="hfa1_home_right">
    <div class="hfa1_unit_street_name full_width_field" id="airport_pickup_options">
                <span class="hfa1_app_half margin_10">
                <label for="sha_airport_arrival_date" class="half_label full_label">Arrival date</label>
                <input style="float:left;" type="text" id="sha_airport_arrival_date" value="<?php if($formOne['arrival_date']!='0000-00-00'){echo date('d/m/Y',strtotime($formOne['arrival_date']));}?>" name="sha_airport_arrival_date" class="half_input date-icon date-of-birth4 ">
                <span style="float:left; padding-left:0; clear:both; margin-bottom: 9px; margin-top:-6px;" id="sha_apu_arrival_date_error">Date format is wrong</span>
                </span>
                <span class="hfa1_app_half">
                <label for="sha_airport_arrival_time" class="half_label full_label">Arrival time</label>
                <input style="float:left;" type="text" id="sha_airport_arrival_time" value="<?php if($formTwo['airport_arrival_time']!='00:00:00'){echo date('H:i',strtotime($formTwo['airport_arrival_time']));}?>" name="sha_airport_arrival_time" class="half_input best-time date-of-time">
                <span style="float:left; padding-left:0; clear:both; margin-bottom: 9px; margin-top:-6px;" id="sha_apu_arrival_time_error">Time format is wrong</span>
                </span>
               <!-- <div style="clear: both;float: left;width: 100%;padding-bottom: 10px;">
                    <span id="sha_apu_arrival_date_error" style="padding-left: 0px;">Date format is wrong</span>
                    <span id="sha_apu_arrival_time_error" style="padding-left: 145px;">Time format is wrong</span>
                </div>-->
                <span style="clear:both;" class="hfa1_app_half margin_10">
                <label for="sha_airport_carrier" class="half_label full_label" style="margin-right:0;">Carrier(Airline)</label>
                <input type="text" id="sha_airport_carrier" value="<?php echo $formTwo['airport_carrier'];?>" name="sha_airport_carrier" class="half_input ">
                </span>
                <span class="hfa1_app_half">
                <label for="sha_airport_flightno" class="half_label full_label">Flight number</label>
                <input type="text" id="sha_airport_flightno" value="<?php echo $formTwo['airport_flightno'];?>" name="sha_airport_flightno" class="half_input">
                </span>
    </div>
</div>
<?php }else{ ?>
	
    <div class="hfa1_home_left">		
            <div class=" full_width_field">
                        <span class="hfa1_app_full">
                        <label for="sha_airport_pickup" class="full_label" style="width:258px;">Do you require airport pickup? <span class="reqField">*</span></label>
                            <select class="full_input errorOnBlur" id="sha_airport_pickup" name="sha_airport_pickup">
                            <option value="">Select one</option>
                            <option class="" id="" value="1" <?php if(($formTwo['airport_pickup']==1) ||  (!isset($formTwo) && age_from_dob($formOne['dob'])<18)){echo 'selected="selected"';}?>>Yes</option>
                            <option class="" id="" value="0" <?php if(($formTwo['airport_pickup']=="0") ){echo 'selected="selected"';}?>>No</option>
                            </select>
                        </span>
            </div>
    
    		<div class="hfa1_unit_street_name full_width_field" id="airport_pickup_options" <?php if((!isset($formTwo) && age_from_dob($formOne['dob'])<18)){}elseif($formTwo['airport_pickup']!=1){echo 'style="display:block;"';}?>>
                        <span class="hfa1_app_half margin_10">
                        <label for="sha_airport_arrival_date" class="half_label full_label">Arrival date</label>
                        <input style="float:left;" type="text" id="sha_airport_arrival_date" value="<?php if($formOne['arrival_date']!='0000-00-00'){echo date('d/m/Y',strtotime($formOne['arrival_date']));}?>" name="sha_airport_arrival_date" class="half_input date-icon date-of-birth4">
                        <span style="float:left; padding-left:0; clear:both; margin-bottom: 9px; margin-top:-6px;" id="sha_apu_arrival_date_error">Date format is wrong</span>
                        </span>
            			<span class="hfa1_app_half">
                        <label for="sha_airport_arrival_time" class="half_label full_label">Arrival time</label>
                        <input  style="float:left;" type="text" id="sha_airport_arrival_time" value="<?php if($formTwo['airport_arrival_time']!='00:00:00'){echo date('H:i',strtotime($formTwo['airport_arrival_time']));}?>" name="sha_airport_arrival_time" class="half_input best-time">
                        <span style="float:left; padding-left:0; clear:both; margin-bottom: 9px; margin-top:-6px;" id="sha_apu_arrival_time_error">Time format is wrong</span>
                        </span>
                        <!--<div style="clear: both;float: left;width: 100%;padding-bottom: 10px;">
                            <span id="sha_apu_arrival_date_error" style="padding-left: 0px;">Date format is wrong</span>
                            <span id="sha_apu_arrival_time_error" style="padding-left: 145px;">Time format is wrong</span>
                        </div>-->
                        <span style="clear:both;" class="hfa1_app_half margin_10">
                        <label for="sha_airport_carrier" class="half_label full_label" style="margin-right:0;">Carrier(Airline)</label>
                        <input type="text" id="sha_airport_carrier" value="<?php echo $formTwo['airport_carrier'];?>" name="sha_airport_carrier" class="half_input ">
                        </span>
                        <span class="hfa1_app_half">
                        <label for="sha_airport_flightno" class="half_label full_label">Flight number</label>
                        <input type="text" id="sha_airport_flightno" value="<?php echo $formTwo['airport_flightno'];?>" name="sha_airport_flightno" class="half_input">
                        </span>
            </div>
    </div>

<?php } ?>

</fieldset>
</fieldset>


<fieldset id="tfa_19" class="section column">
<fieldset id="" class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new">

<h3>Your Story</h3>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="sha_home_student_past" class="full_label">Have you been a homestay student in the past?</label>
				<select id="sha_home_student_past" name="sha_home_student_past" class="full_input">
                <option value="">Select one</option>
                <option class="" id="" value="1" <?php if($formTwo['home_student_past']==1){echo 'selected="selected"';}?>>Yes</option>
               <option class="" id="" value="0" <?php if($formTwo['home_student_past']=="0"){echo 'selected="selected"';}?>>No</option>              
                </select>
			</span>
</div>

<div class=" full_width_field left_margin" id="homestay_student" <?php if($formTwo['home_student_past']!=1){echo 'style="display:none;"';}?>>
			<span class="hfa1_app_full">
			<label for="sha_home_student_exp" class="full_label hidden_label">What experience do you have as a homestay student?</label>
			<textarea id="sha_home_student_exp"  name="sha_home_student_exp" class="full_textarea"><?php if($formTwo['home_student_past']==1){echo $formTwo['home_student_exp'];}?></textarea>
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="" class="full_label">Please describe yourself</label>
            <p>Be sure to mention pastime and interests, hobbies, likes and dislikes. Any information here will be shared with your Homestay Family and will help them understand you better. </p>
			<textarea id="hfa_family_desc" name="sha_student_desc" class="full_textareas"><?=$formTwo['student_desc']?></textarea>
			</span>
</div>


<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="" class="full_label">Please describe your family back home</label>
            <p>Be sure to mention any relatives or siblings you may have, your likes and dislikes and hobbies you have as a family
back home. Any information here will be shared with your allocated Homestay Family and will help them understand
you better.</p>
			<textarea id="hfa_family_desc" name="sha_student_family_desc" class="full_textareas"><?=$formTwo['student_family_desc']?></textarea>
			</span>
</div>


<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="" class="full_label">Please describe your hobbies</label>
			<textarea name="sha_student_hobbies" class="full_textareas"><?=$formTwo['student_hobbies']?></textarea>
			</span>
</div>

</fieldset>
</fieldset>

<fieldset id="tfa_20" class="section column" <?php if($age>=18) {?>style="display:none;"<?php } ?>>
    <fieldset id="" class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new">
        <h3>Caregiving Details</h3>
        <div class="">		
            <div class=" full_width_field">
                        <span class="hfa1_app_full">
                        <label style="width:258px;" class="full_label" for="sha_guardian">Do you need caregiving? <span class="reqField">*</span></label>
                            <select id="sha_guardian" class="full_input" name="sha_guardian">
                            <option value="">Select one</option>
                            <option value="1" id="" class="" <?php if($formTwo['guardianship']==1){echo 'selected="selected"';}?>>Yes</option>
                            <option value="0" id="" class="" <?php if($formTwo['guardianship']=="0"){echo 'selected="selected"';}?>>No</option>
                            </select>
                        </span>
            </div>
        </div>
        
        <div class=" full_width_field" id="sha_guardian_requirementsDiv" <?php if($formTwo['guardianship']!="1"){echo 'style="display:none;"';}?>>
			<span class="hfa1_app_full">
			<label for="" class="full_label">Do you have any caregiver preference?</label>
			<textarea id="sha_guardian_requirements" name="sha_guardian_requirements" class="full_textareas"><?php  if($formTwo['guardianship']=="1"){echo $formTwo['guardianship_requirements'];}?></textarea>
			</span>
		</div>
    </fieldset>
</fieldset>


<div class="end-options admin-end">
	<input type="button" value="Update" id="shaTwoUpdate" class="btn-btn-medium hfa_submit">
	<div id="shaTwoProcess" style="display:none;" class="appFormProcess">
		<img src="<?=str_replace('http:','https:',static_url())?>img/submitload.gif"   />
	</div>
</div>

<p class="end-options-para admin-end-options-para">
After submission, this part of the application wil be saved. You can always retrieve the saved application by clicking on Retrieve Saved 
Application button on the <a target="_blank" style="color:#000; text-decoration:underline;" href="<?=site_url()?>form/student_homestay_application">Student Homestay Application page</a> on Global experience website.</p>
</form>
</div>
</div>

</div>

<script type="text/javascript">

$(document).ready(function(){
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
	$('#sha_ins_policy_file_choose').click(function(){
			$('#insPolicyFile').trigger('click');
		});
	
	$('#insPolicyFile').change(function(){
		
			if (this.files && this.files[0]) 
			{
				if(!checkFileExt($(this).val()))
					 errorBar("Only image, pdf and MS word files are allowed");
				else if(!checkFileSize($(this)[0].files[0].size))
					 errorBar("Please select file less than 5MB");
				else
				{
						$('#insPolicyFileChoosen').text($('#insPolicyFile').val()).show();
						$('#insPolicyFileChooseAnother').show();
						$('#sha_ins_policy_file_choose').hide();		
				}	 
					 
			}
		});
		
	$('#insPolicyFileChooseAnother').click(function(){
			$('#insPolicyFileChoosen').text('').hide();
			$('#sha_ins_policy_file_choose').show();
			$('#insPolicyFileChooseAnother').hide();
			$('#insPolicyFile').val('');
			
			$('#sha_ins_file_name_text_edit').hide();
			$('#sha_use_same_file').show();
			$('#sha_file_update').val(1);
		});
		
		
		$('#sha_use_same_file').click(function(){
				$('#sha_ins_policy_file_choose').hide();
				$('#sha_use_same_file').hide();
				$('#sha_ins_file_name_text_edit').show();
				$('#insPolicyFileChooseAnother').show();
				$('#sha_file_update').val(0);
				$('#insPolicyFileChoosen').text('').hide();
			});
	
	$('#sha_insurance_policy_expiry').datepicker({
		  changeMonth: true,
		  changeYear: true,
		  yearRange: "c-5:c+20",
		  dateFormat: 'dd/mm/yy'
		});
		
			$('#sha_airport_arrival_date').datepicker({
		  changeMonth: true,
		  changeYear: true,
		  yearRange: "c-5:c+10",
		  dateFormat: 'dd/mm/yy'
		});
		
	$('#sha_airport_arrival_time').timepicker();

		$('#sha_student_language').change(function(){
				$('.sha_student_languages').hide();
				var student_language=$(this).val();
				
				if(student_language!='')
					{
						var langDetail='#sha_student_languages_details-1';
						if(student_language>1)
						{
							for(var x=2;x<=student_language;x++)
								langDetail +=' ,#sha_student_languages_details-'+x;
						}
						$(langDetail).show();
					}
			});
			
			
		$('#shaTwoUpdate').click(function(){
			
			var $shaTwoProcess=$('#shaTwoProcess');
			var $shaTwoSubmitBtn=$('#shaTwoUpdate');
			
			var $sha_student_language=$('#sha_student_language');
			var $sha_student_religion=$('#sha_student_religion');
			var $sha_religion_other_val=$('#sha_religion_other_val');
			var $sha_live_with_pets=$('#sha_live_with_pets');
			var $sha_pet_other=$('#sha_pet_other')
			var $sha_pet_other_val=$('#sha_pet_other_val');
			var $sha_insurance=$('#sha_insurance');
			if($('#sha_airport_pickup').length==1)
				var $sha_airport_pickup=$('#sha_airport_pickup');
			var $sha_guardian=$('#sha_guardian');
			var $sha_airport_arrival_date=$('#sha_airport_arrival_date');
			var $sha_airport_arrival_time=$('#sha_airport_arrival_time');
			
			var sha_student_language=$sha_student_language.val().trim();
			var sha_student_religion=$sha_student_religion.val();
			var sha_religion_other_val=$sha_religion_other_val.val().trim();
			var sha_live_with_pets=$sha_live_with_pets.val().trim();
			var sha_pet_other_val=$sha_pet_other_val.val().trim();
			var sha_insurance=$sha_insurance.val().trim();
			if($('#sha_airport_pickup').length==1)
				var sha_airport_pickup=$sha_airport_pickup.val().trim();
			else
				var sha_airport_pickup='1';	
			var sha_guardian=$sha_guardian.val().trim();
			var sha_airport_arrival_date=$sha_airport_arrival_date.val().trim();
			var sha_airport_arrival_time=$sha_airport_arrival_time.val().trim();
			
			
			var sha_language=true;
			sha_language=multipleFieldValidation('sha_language');
			
			removeFieldError($sha_student_language);
			removeFieldError($sha_religion_other_val);
			removeFieldError($sha_live_with_pets);
			removeFieldError($sha_pet_other_val);
			removeFieldError($sha_insurance);
			if($('#sha_airport_pickup').length==1)
				removeFieldError($sha_airport_pickup);
			removeFieldError($sha_guardian);
			removeFieldError($sha_airport_arrival_date);
			removeFieldError($sha_airport_arrival_time);
			$('#sha_apu_arrival_date_error, #sha_apu_arrival_time_error').hide();
			
			if(sha_student_language=='' || (sha_student_religion=='0' && sha_religion_other_val=='') || sha_live_with_pets=='' || (sha_live_with_pets!='0' && $sha_pet_other.is(':checked') && sha_pet_other_val=='') || sha_insurance=='' || sha_airport_pickup=='' || ($sha_guardian.is(':visible') && sha_guardian=='') || !sha_language || (sha_airport_arrival_date!='' && !isValidDate(sha_airport_arrival_date)) || (sha_airport_arrival_time!='' && !isTimeValid(sha_airport_arrival_time)))
			{
				if(sha_student_language=='')
					addFieldError($sha_student_language);
				else	
					removeFieldError($sha_student_language);
				
				if(sha_student_religion=='0' && sha_religion_other_val=='')	
					addFieldError($sha_religion_other_val);
				else	
					removeFieldError($sha_religion_other_val);
					
				if(sha_live_with_pets=='')
					addFieldError($sha_live_with_pets);
				else	
					removeFieldError($sha_live_with_pets);
					
				if($sha_live_with_pets!='0' && $sha_pet_other.is(':checked') && sha_pet_other_val=='')
					addFieldError($sha_pet_other_val);
				else	
					removeFieldError($sha_pet_other_val);
					
				if(sha_insurance=='')
					addFieldError($sha_insurance);
				else	
					removeFieldError($sha_insurance);
				
				if($('#sha_airport_pickup').length==1)
				{
					if(sha_airport_pickup=='')
						addFieldError($sha_airport_pickup);
					else	
						removeFieldError($sha_airport_pickup);
				}
				
				if($sha_guardian.is(':visible') && sha_guardian=='')
					addFieldError($sha_guardian);
				else	
					removeFieldError($sha_guardian);
					
				if(sha_airport_arrival_date!='' && !isValidDate(sha_airport_arrival_date))
				{
					$('#sha_apu_arrival_date_error').show();
					addFieldError($sha_airport_arrival_date);
				}
					
				if(sha_airport_arrival_time!='' && !isTimeValid(sha_airport_arrival_time))
				{
					$('#sha_apu_arrival_time_error').show();
					addFieldError($sha_airport_arrival_time);
				}
				
				scrollToDiv('#student-homestay-application');
				errorBar('All fields marked with red are required');
			}
			else
			{
					$shaTwoProcess.show();
					$shaTwoSubmitBtn.hide();
					var id=$('input[name=id]').val();
					
					var sha_twoForm=$('#sha_twoForm').serialize();
					
								//iPhone fix #Start
									var $form = $('#sha_twoForm');
									var $inputs = $('input[type="file"]', $form);
									$inputs.each(function(_, input) {
									  if (input.files.length > 0) return
									  $(input).prop('disabled', true);
									})
									var formData = new FormData($form[0]);
									$inputs.prop('disabled', false);
								//iPhone fix #End
					
								$.ajax({
								url:site_url()+'sha/application_edit_two_submit',
								type:'POST',
								//data:sha_twoForm,
								//data:  new FormData($('#sha_twoForm')[0]),
								data:formData,
								cache:false,
				          		contentType: false,
            					processData: false,
								            headers: {
              "cache-control": "no-cache"
            },
								success:function(data)
									{
										$shaTwoProcess.hide();
										window.location.href=site_url()+'sha/application/'+id;
									}
						});
			}
			
			});
			
	});
</script>