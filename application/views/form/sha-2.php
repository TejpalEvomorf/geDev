<?php
$nationList=nationList();
$religionList=religionList();
$languagePrificiencyList=languagePrificiencyList();
$languageList=languageList();
$guardianshipTypeList=guardianshipTypeList();
$age=age_from_dob($form_one['dob']) ;
?>

<!--Success Pop Up STARTS-->
  <div class="modal fade successPop" id="sha_successPopUpOne"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h2 class="modal-title"></h2>
							</div>
							<div class="modal-body">
								<img src="<?=str_replace('http:','https:',static_url())?>img/tick.png" />
								<h3>First Step of your Homestay application (Personal Details), has been submitted successfully.</h3>
								<p>We have sent you a link in your email. You can use that link to continue at the same step, in case you wish to complete the application later.</p>
                                <a href="javascript:void(0)" data-dismiss="modal">CONTINUE TO NEXT STEP</a>
							</div>
							<div class="modal-footer">
                            <span style="font-weight:bold; color:#1d7643; background:#eeeeee;">Step 1: Personal Details (Complete) <img src="<?=str_replace('http:','https:',static_url())?>img/complete-tick.png" /></span>
                            <span>Step 2: Other Details</span>
                            <span>Step 3: Health Details and Preferences</span>
                           </div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div>
<!--Success Pop ENDS-->

<div class="wFormContainer new_forms add-hostfamily-application dd-sha-applicatio2" id="student-homestay-application">

<legend class="headingHostForm">Student Homestay Application Form 
<span class="hand-written">All fields with red asterick<span class="reqField"> * </span>are mandatory</span></legend>

<div style="background:none;" class="">
  <div class="wForm" id="tfa_0-WRPR" dir="ltr">
  
<form method="post"  class="hintsBelow labelsAbove" id="sha_twoForm">
<input type="hidden" name="id" value="<?=$id?>" />
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
                <option value="1" class="">1 language</option>
                <option value="2" class="">2 languages</option>
                <option value="3" class="">3 languages</option>
                <option value="4" class="">4 languages</option>
                <option value="5" class="">5 languages</option>
                </select>
			</span>
</div>

<?php for($x=1;$x<=5;$x++){ ?>
<div class="margin_bottom_zero full_width_field left_margin sha_student_languages" style="display:none;" id="sha_student_languages_details-<?=$x?>">
                <span class="hfa1_app_halfs margin_10 smoke-yes smoke-yes11">
                <label for="" class="full_label hidden_label">Language <?=$x?> <span class="reqField">*</span></label>
                <select class="othersel halfs_input sha_language errorOnBlur" name="sha_language[language-<?=$x?>][language]" data-id="<?= $x?>">
                <option value="">Select one</option>
                <?php foreach($languageList as $lK=>$lV){?>
	                <option value="<?=$lK?>" class=""><?=$lV?></option>
                <?php } ?>
                </select>				
                </span>
                <span class="hfa1_app_halfs margin_10 smoke-yes smoke-yes11">
                <label for="" class="full_label hidden_label">Proficiency</label>
                <select class="halfs_input" name="sha_language[language-<?=$x?>][prof]" id="">
                <option value="">Select one</option>
                <?php foreach($languagePrificiencyList as $lpK=>$lpV){?>
                	<option value="<?=$lpK?>"  class=""><?=$lpV?></option>
                    <?php } ?>
                </select>
                </span>    
                
                <span style="display:none;" id="olang-<?= $x ?>">
                <label for="" class="full_label hidden_label">Other language <span class="reqField">*</span></label>
                <input type="text" id='lang-<?= $x ?>'  name="sha_language[language-<?=$x?>][other_language]" class="halfss_inputss  sha_language errorOnBlur" value="" />
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
	            <option value="<?=$nlK?>" class=""><?=$nlV?></option>
           <?php } ?>
            </select>
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full ">
			<label for="sha_student_religion" class="full_label">What is your religion</label>
				<select id="sha_student_religion" class="full_input" name="sha_student_religion">
                <option value="">Select one</option>
               <?php foreach($religionList as $rlK=>$rlV){?>
	                <option class="" value="<?=$rlK?>"><?=$rlV?></option>
               <?php } ?>
                <option class="" value="0">Other</option>
                </select>
			</span>
</div>

<div class=" full_width_field left_margin" id="type_religion" style=" display:none;">
			<span class="hfa1_app_full smoke-yes lolol">
			<label for="sha_type_religion_input" class="full_label hidden_label">Other type of religion <span class="reqField">*</span></label>
			<input type="text" id="sha_religion_other_val" value="" name="sha_religion_other_val" class="full_inputss errorOnBlur">
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
                <option value="1" id="" class="">Yes</option>
                <option value="0" id="" class="">No</option>
				</select>
			</span>
</div>

<div class=" full_width_field" style="display:none;" id="what_pets_lives_can">
			<span class="hfa1_app_full" style="width: 55%;">
			<label class="full_label hidden_label" for="hfa1_what_pet">Type of pets you can live with</label>
			<input type="checkbox" style="float:left;width:20px !important; margin-right:5px;" name="sha_pets[dog]" value="1">
            <label style="float: left; margin-right: 50px; margin-bottom: 5px;" for="" class="selt wtpt">Dog</label>
            <input type="checkbox" style="float:left; width:20px !important; margin-right:5px;" name="sha_pets[bird]" value="1">
            <label style="float: left; margin-bottom: 5px; margin-right: 48px;" for="" class="selt wtpt">Bird</label>
            <input type="checkbox" style="float:left; width:20px !important; margin-right:5px;" name="sha_pets[cat]" value="1">
            <label style="float: left; margin-bottom: 5px; margin-right: 54px;" for="" class="selt wtpt">Cat</label>
            <input type="checkbox" class="hfa_checkbox_input " style="float:left; width:20px !important; margin-right:5px;" name="sha_pets[other]" value="1"  id="sha_pet_other">
            <label style="float: left; margin-right: 35px; margin-bottom: 5px;" for="sha_pet_other" class="selt wtpt" id="">Other</label>
			</span>
</div>

<div class=" full_width_field left_margin" id="sha_type_pet" style="display:none;">
			<span class="hfa1_app_full">
			<label for="sha_type_pet_can" class="full_label hidden_label">Other type of pets <span class="reqField">*</span></label>
			<input type="text" id="sha_pet_other_val" value="" name="sha_pets[other_val]" class="full_inputss errorOnBlur">
			</span>
</div>
      

</div>


<div class="hfa1_home_right">

<div class=" full_width_field" style="display:none;" id="pets_lives_can">
			<span class="hfa1_app_full">
			<label for="sha_pet_live_inside" class="full_label">Can you live with pets inside the house? </label>
				<select id="sha_pet_live_inside" name="sha_pet_live_inside" class="full_input">
                <option value="">Select one</option>
                <option value="1" id=" " class="">Yes</option>
                <option value="0" class="">No</option>
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
                <option class="" id="" value="1">Yes</option>
                <option class="" id="" value="0">No</option>
				</select>
			</span>
</div>



<div style="display: none;" id="sha_type_insurance" class=" full_width_field left_margin">
			<span class="hfa1_app_full">
			<label class="full_label hidden_label" for="sha_insurance_provider">Insurance provider</label>
			<input type="text" class="full_inputss" name="sha_insurance_provider" value="" id="sha_insurance_provider">
			</span>
            <span class="hfa1_app_halfs margin_10">
			<label for="sha_policy_number" class="full_label hidden_label">Policy no.</label>
			<input type="text" id="sha_policy_number" value="" name="sha_insurance_policy_number" class="halfs_input">
			</span>
            <span class="hfa1_app_halfs">
			<label for="sha_type_policy_expiry" class="full_label hidden_label">Expiry date</label>
			<input type="text" id="sha_insurance_policy_expiry" value="" name="sha_insurance_policy_expiry" class="halfs_input date-icon" readonly="readonly">
			</span>
</div>
      

</div>


<div class="hfa1_home_right">

<div class=" full_width_field" id="content_insurance_upload" style="display:none;">
			<span class="hfa1_app_full">
			<label for="sha_type__photo" class="full_label hidden_label" style="width:260px;">Upload a scanned copy of your Travel Insurance</label>
			<input type="button" id="sha_ins_policy_file_choose" value="Choose file" name="" class="full_input_select choose-btn">
			</span>
            <input type="file" id="insPolicyFile" name="insPolicyFile"   style="display:none;">
            <p id="insPolicyFileChoosen" style="display:none;"></p>
            <a style="display:none;" href="javascript:void(0);" id="insPolicyFileChooseAnother">Upload different file</a>
</div>

</div>


</fieldset>
</fieldset>


<fieldset id="tfa_18" class="section column">
<fieldset id="" class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new">

<h3>Airport Pickup Service</h3>

<div class="hfa1_home_left">		

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="sha_airport_pickup" class="full_label" style="width:258px;">Do you require airport pickup? <span class="reqField">*</span></label>
				<select class="full_input errorOnBlur" id="sha_airport_pickup" name="sha_airport_pickup">
                <option value="">Select one</option>
                <option class="" id="" value="1" <?php if($form_one['dob']!='0000-00-00' && age_from_dob($form_one['dob'])<18){?>selected="selected"<?php } ?>>Yes</option>
                <option class="" id="" value="0" >No</option>
				</select>
			</span>
</div>
      

</div>


<div class="hfa1_home_right">

<div class="hfa1_unit_street_name full_width_field" id="airport_pickup_options" <?php if($form_one['dob']!='0000-00-00' && age_from_dob($form_one['dob'])<18){}else{?>style="display:block;"<?php } ?>>
			<span class="hfa1_app_half margin_10">
			<label for="sha_airport_arrival_date" class="half_label full_label">Arrival date</label>
			<input type="text" id="sha_airport_arrival_date" value="<?php if($form_one['arrival_date']!='0000-00-00'){echo date('d/m/Y',strtotime($form_one['arrival_date']));}?>" name="sha_airport_arrival_date" class="half_input date-icon date-of-birth4 ">
			</span>
			<span class="hfa1_app_half">
			<label for="sha_airport_arrival_time" class="half_label full_label">Arrival time</label>
			<input type="text" id="sha_airport_arrival_time" value="" name="sha_airport_arrival_time" class="half_input best-time date-of-time">
			</span>
            <span class="hfa1_app_half margin_10">
            <label for="sha_airport_carrier" class="half_label full_label" style="margin-right:0;">Carrier(Airline)</label>
            <input type="text" id="sha_airport_carrier" value="" name="sha_airport_carrier" class="half_input ">
            </span>
            <span class="hfa1_app_half">
            <label for="sha_airport_flightno" class="half_label full_label">Flight number</label>
            <input type="text" id="sha_airport_flightno" value="" name="sha_airport_flightno" class="half_input">
            </span>
</div>

</div>


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
                <option class="" id="" value="1">Yes</option>
               <option class="" id="" value="0">No</option>              
                </select>
			</span>
</div>

<div class=" full_width_field left_margin" id="homestay_student" style="display:none;">
			<span class="hfa1_app_full">
			<label for="sha_home_student_exp" class="full_label hidden_label">What experience do you have as a homestay student?</label>
			<textarea id="sha_home_student_exp" value="" name="sha_home_student_exp" class="full_textarea"></textarea>
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="" class="full_label">Please describe yourself</label>
            <p>Be sure to mention pastime and interests, hobbies, likes and dislikes. Any information here will be shared with your Homestay Family and will help them understand you better. </p>
			<textarea id="hfa_family_desc" value="" name="sha_student_desc" class="full_textareas"></textarea>
			</span>
</div>


<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="" class="full_label">Please describe your family back home</label>
            <p>Be sure to mention any relatives or siblings you may have, your likes and dislikes and hobbies you have as a family
back home. Any information here will be shared with your allocated Homestay Family and will help them understand
you better.</p>
			<textarea id="hfa_family_desc" value="" name="sha_student_family_desc" class="full_textareas"></textarea>
			</span>
</div>


<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="" class="full_label">Please describe your hobbies</label>
            <textarea value="" name="sha_student_hobbies" class="full_textareas"></textarea>
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
                            <option value="1" id="" class="">Yes</option>
                            <option value="0" id="" class="">No</option>
                            </select>
                        </span>
            </div>
        </div>
        <div class=" full_width_field" id="sha_guardian_requirementsDiv" style="display:none;">
			<span class="hfa1_app_full">
			<label for="" class="full_label">Do you have any caregiver preference?</label>
			<textarea id="sha_guardian_requirements" name="sha_guardian_requirements" class="full_textareas"></textarea>
			</span>
		</div>
    </fieldset>
</fieldset>


<div class="end-options">
<input type="button" value="Submit &amp; continue" id="shaTwoSubmitBtn" class="btn-btn-medium hfa_submit">

<div id="shaTwoProcess" style="display:none;" class="appFormProcess">
	<img src="<?=str_replace('http:','https:',static_url())?>img/submitload.gif"   />
</div>

</div>

<p class="end-options-para">
After submission, this part of the application wil be saved. You can always retrieve the saved application by clicking on Retrieve Saved 
Application button on the <a target="_blank" style="color:#000; text-decoration:underline;" href="<?=site_url()?>form/student_homestay_application">Student Homestay Application page</a> on Global experience website.</p>
</form>
</div>
</div>

</div>

<?php if($popUp!=''){?>
	<script type="text/javascript">
				$('#sha_successPopUpOne').modal({backdrop: 'static', keyboard: false});
    </script>
<?php } ?>

<script type="text/javascript">

$(document).ready(function(){
$(".othersel").change(function(){
	var lv=$(this).val();
	var d=$(this).data('id');

	if(lv==25)
	$("#olang-"+d).slideDown();
	
if(lv!=25)
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
		});
		
	
	$('#sha_insurance_policy_expiry').datepicker({
		  changeMonth: true,
		  changeYear: true,
		   yearRange: "c-5:c+20",
		  dateFormat: 'dd/mm/yy',
		});
		
			$('#sha_airport_arrival_date').datepicker({
		  changeMonth: true,
		  changeYear: true,
		 yearRange: "c-5:c+10",
		  dateFormat: 'dd/mm/yy',
		  autoUpdateInput: false
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
			
			
		$('#shaTwoSubmitBtn').click(function(){
			
			var $shaTwoProcess=$('#shaTwoProcess');
			var $shaTwoSubmitBtn=$('#shaTwoSubmitBtn');
			
			var $sha_student_language=$('#sha_student_language');
			var $sha_student_religion=$('#sha_student_religion');
			var $sha_religion_other_val=$('#sha_religion_other_val');
			var $sha_live_with_pets=$('#sha_live_with_pets');
			var $sha_pet_other=$('#sha_pet_other')
			var $sha_pet_other_val=$('#sha_pet_other_val');
			var $sha_insurance=$('#sha_insurance');
			var $sha_airport_pickup=$('#sha_airport_pickup');
			var $sha_guardian=$('#sha_guardian');
			
			var sha_student_language=$sha_student_language.val().trim();
			var sha_student_religion=$sha_student_religion.val();
			var sha_religion_other_val=$sha_religion_other_val.val().trim();
			var sha_live_with_pets=$sha_live_with_pets.val().trim();
			var sha_pet_other_val=$sha_pet_other_val.val().trim();
			var sha_insurance=$sha_insurance.val().trim();
			var sha_airport_pickup=$sha_airport_pickup.val().trim();
			var sha_guardian=$sha_guardian.val().trim();
			
			var sha_language=true;
			sha_language=multipleFieldValidation('sha_language');
			
			removeFieldError($sha_student_language);
			removeFieldError($sha_religion_other_val);
			removeFieldError($sha_live_with_pets);
			removeFieldError($sha_pet_other_val);
			removeFieldError($sha_insurance);
			removeFieldError($sha_airport_pickup);
			removeFieldError($sha_guardian);
			
			if(sha_student_language=='' || (sha_student_religion=='0' && sha_religion_other_val=='') || sha_live_with_pets=='' || (sha_live_with_pets!='0' && $sha_pet_other.is(':checked') && sha_pet_other_val=='') || sha_insurance=='' || sha_airport_pickup=='' || ($sha_guardian.is(':visible') && sha_guardian=='') || !sha_language)
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
					
				if(sha_live_with_pets!='0' && $sha_pet_other.is(':checked') && sha_pet_other_val=='')
					addFieldError($sha_pet_other_val);
				else	
					removeFieldError($sha_pet_other_val);
					
				if(sha_insurance=='')
					addFieldError($sha_insurance);
				else	
					removeFieldError($sha_insurance);
				
				if(sha_airport_pickup=='')
					addFieldError($sha_airport_pickup);
				else	
					removeFieldError($sha_airport_pickup);
				
				if($sha_guardian.is(':visible') && sha_guardian=='')
					addFieldError($sha_guardian);
				else	
					removeFieldError($sha_guardian);
				
				scrollToDiv('#student-homestay-application');
				errorBar('All fields marked with red are required');	
			}
			else
			{
					$shaTwoProcess.show();
					$shaTwoSubmitBtn.hide();
					
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
								url:site_url()+'form/sha_two_submit',
								type:'POST',
								//data:sha_twoForm,
								//data:  new FormData($('#sha_twoForm')[0]),
								data:formData,
								cache:false,
				          		contentType: false,
            					processData: false,
								success:function(data)
									{
										//$shaTwoProcess.hide();
										//$hfaThreeSubmitBtn.show();
											
										if(data=='next')
											window.location.href=site_url()+'form/student_homestay_application_three/<?=$link?>/pop';
								}
						});
			}
			
			});
			
	});
	
</script>