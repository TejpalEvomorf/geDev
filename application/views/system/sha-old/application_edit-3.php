<?php
$smokingHabbits=smokingHabbits();
$geRefList=geRefList();
$homestayChooseReasonList=homestayChooseReasonList();
?>

<div class="wFormContainer new_forms add-hostfamily-application student-homestay-application3" id="student-homestay-application">

<legend class="headingHostForm">Student Homestay Application Form 
<span class="hand-written">All fields with red asterick<span class="reqField"> * </span>are mandatory</span></legend>

<div style="background:none;" class="">
  <div class="" >
  
<form method="post" action="" class="hintsBelow labelsAbove" id="sha_threeForm">
<input type="hidden" name="id" value="<?=$formOne['id']?>">
<div id="tfa_0-A" class="actions add_new_submission"><h4>HEALTH DETAILS AND PREFERENCES</h4></div>

<fieldset class="section column" id="tfa_21">
<fieldset class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new" id="">

<h3>Your Health Details</h3>

<div class="hfa1_home_left">		

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="sha_student_dietary" class="full_label" style="width:250px;">Will you have any special dietary requirements?</label>
				<select id="sha_student_diet" class="full_input" name="sha_student_diet">
                <option value="">Select one</option>
                <option value="1" <?php if($formThree['diet_req']=='1'){echo 'selected="selected"';}?>>Yes</option>
                <option value="0" <?php if($formThree['diet_req']=='0'){echo 'selected="selected"';}?>>No</option>
                </select>
			</span>
</div>

<div id="sha_type_of_dietary" <?php if($formThree['diet_req']!='1'){echo 'style="display:none; margin-bottom:0;"';}?> class=" full_width_field left_margin">
      
      <label for="hfa1_facility" class="full_label hidden_label">Dietary requirements <span class="reqField">*</span></label>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" id="" value="1" name="sha_diet[veg]" class="hfa_checkbox_input sha_diet" <?php if($formThree['diet_req']=='1' && $formThree['diet_veg']==1){echo 'checked="checked"';}?>>
				<label for="" class=" selt">Vegetarian</label>                
	  </span>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" id="" value="1" name="sha_diet[gluten]" class="hfa_checkbox_input sha_diet" <?php if($formThree['diet_req']=='1' && $formThree['diet_gluten']==1){echo 'checked="checked"';}?>>
				<label for="" class=" selt">Gluten/Lactose Free</label>                
	  </span>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" id="" value="1" name="sha_diet[pork]" class="hfa_checkbox_input sha_diet" <?php if($formThree['diet_req']=='1' && $formThree['diet_pork']==1){echo 'checked="checked"';}?>>
				<label for="" class="selt">No Pork</label>                
	  </span>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" id="" value="1" name="sha_diet[food_allergy]" class="hfa_checkbox_input sha_diet" <?php if($formThree['diet_req']=='1' && $formThree['diet_food_allergy']==1){echo 'checked="checked"';}?>>
				<label for="" class="selt">Food Allergies</label>                
	  </span>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" id="sha_other_dietary" value="1" name="sha_diet[other]" class="hfa_checkbox_input sha_diet" <?php if($formThree['diet_req']=='1' && $formThree['diet_other']==1){echo 'checked="checked"';}?>>
				<label for="sha_other_dietary" class="selt">Other, please provide details</label>                
	  </span>
     <p style="color: rgb(255, 0, 0);display:none;" id="dietError">This field is required.</p> 
</div>

  
  <div class=" full_width_field left_margin" id="sha_dietary_requirements" <?php if($formThree['diet_req']!='1' || $formThree['diet_other']!=1){echo 'style="display:none;"';}?>>
			<span class="hfa1_app_full">
			<label for="sha_dietary_requirement" class="full_label hidden_label">Other dietary requirements <span class="reqField">*</span></label>
			<input type="text" id="sha_diet_other_val" value="<?php if($formThree['diet_req']=='1' || $formThree['diet_other']==1){echo$formThree['diet_other_val'];}?>" name="sha_diet[other_val]" class="full_inputss errorOnBlur width-230">
			</span>
</div>


<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="sha_student_allergies" class="full_label" style="width:250px;">Do you have any allergies?</label>
				<select id="sha_student_allergies" class="full_input" name="sha_student_allergies">
                <option value="">Select one</option>
                <option value="1"  <?php if($formThree['allergy_req']=='1'){echo 'selected="selected"';}?>>Yes</option>
                <option value="0"  <?php if($formThree['allergy_req']=='0'){echo 'selected="selected"';}?>>No</option>
                </select>
			</span>
</div>

<div id="sha_type_of_allergies" <?php if($formThree['allergy_req']!='1'){echo 'style="display:none; margin-bottom:0;"';}?> class=" full_width_field left_margin">
      
      <label for="hfa1_facility" class="full_label hidden_label">Types of allergies you have <span class="reqField">*</span></label>
      
     <span class="hfa1_app_full">	
				<input type="checkbox" id="" value="1" name="sha_allergy[hay_fever]" class="hfa_checkbox_input sha_allergy" <?php if($formThree['allergy_req']=='1' && $formThree['allergy_hay_fever']==1){echo 'checked="checked"';}?>>
				<label for="" class=" selt">Hay Fever</label>                
	  </span>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" id="" value="1" name="sha_allergy[asthma]" class="hfa_checkbox_input sha_allergy" <?php if($formThree['allergy_req']=='1' && $formThree['allergy_asthma']==1){echo 'checked="checked"';}?>>
				<label for="" class=" selt">Asthma</label>                
	  </span>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" id="" value="1" name="sha_allergy[lactose]" class="hfa_checkbox_input sha_allergy" <?php if($formThree['allergy_req']=='1' && $formThree['allergy_lactose']==1){echo 'checked="checked"';}?>>
				<label for="" class="selt">Lactose Intolerance</label>                
	  </span>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" id="" value="1" name="sha_allergy[gluten]" class="hfa_checkbox_input sha_allergy" <?php if($formThree['allergy_req']=='1' && $formThree['allergy_gluten']==1){echo 'checked="checked"';}?>>
				<label for="" class="selt">Gluten Intolerance</label>                
	  </span>
      
       <span class="hfa1_app_full">	
				<input type="checkbox" id="" value="1" name="sha_allergy[peanut]" class="hfa_checkbox_input sha_allergy" <?php if($formThree['allergy_req']=='1' && $formThree['allergy_peanut']==1){echo 'checked="checked"';}?>>
				<label for="" class="selt">Peanut Allergies</label>                
	  </span>
      
       <span class="hfa1_app_full">	
				<input type="checkbox" id="" value="1" name="sha_allergy[dust]" class="hfa_checkbox_input sha_allergy" <?php if($formThree['allergy_req']=='1' && $formThree['allergy_dust']==1){echo 'checked="checked"';}?>>
				<label for="" class="selt">Dust Allergies</label>                
	  </span>
      
       <span class="hfa1_app_full">	
				<input type="checkbox" id="sha_other_allergies" value="1" name="sha_allergy[other]" class="hfa_checkbox_input sha_allergy" <?php if($formThree['allergy_req']=='1' && $formThree['allergy_other']==1){echo 'checked="checked"';}?>>
				<label for="sha_other_allergies" class="selt">Other, please provide details</label>                
	  </span>
       <p style="color: rgb(255, 0, 0);display:none;" id="allergyError">This field is required.</p>    
</div>

<div class=" full_width_field left_margin" id="sha_allergy_requirements"  <?php if($formThree['allergy_req']!='1' || $formThree['allergy_other']!=1){echo 'style="display:none;"';}?>>
      <span id="" class="hfa1_app_full">
      <label class="full_label hidden_label" for="hfa1_other_allergies">Other allergies <span class="reqField">*</span></label>
      <input type="text" class="full_inputss errorOnBlur width-230" name="sha_allergy[other_val]" value="<?php if($formThree['allergy_req']=='1' || $formThree['allergy_other']==1){echo$formThree['allergy_other_val'];}?>" id="sha_allergy_other_val">
      </span>
</div>    

</div>


<div class="hfa1_home_right">

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="sha_student_smoke" class="full_label">Do you smoke?</label>
				<select id="sha_student_smoke" class="full_input" name="sha_student_smoke">
                <option value="">Select one</option>
                <?php foreach($smokingHabbits as $shK=>$shV){?>
	                <option class="" id="" value="<?=$shK?>"  <?php if($formThree['smoker']==$shK && $formThree['smoker']!=''){echo 'selected="selected"';}?>><?=$shV?></option>
                <?php } ?>
                </select>
			</span>
</div>

<div class=" full_width_field left_margin" id="sha_smoking_requirements" style="display:none;">
     <p>In Australia, smoking indoors may limit your ability to be placed with a family.</p>
</div> 


<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="sha_student_medication" class="full_label">Do you currently take any medication?</label>
				<select id="sha_student_medication" class="full_input" name="sha_student_medication">
                <option value="">Select one</option>
                <option class="" value="0" <?php if($formThree['medication']=="0"){echo 'selected="selected"';}?>>No</option>
                <option class="" value="1" <?php if($formThree['medication']=="1"){echo 'selected="selected"';}?>>Yes</option>
                </select>
			</span>
</div>

<div class=" full_width_field left_margin" id="sha_student_medication_requirement" <?php if($formThree['medication']!='1'){echo 'style="display:none;"';}?>>
     <span class="hfa1_app_full">
			<label class="full_label hidden_label" for="sha_medication_requirement">Details of any medication you take <span class="reqField">*</span></label>
			<textarea class="full_inputss errorOnBlur width-230" name="sha_student_medication_details" id="sha_student_medication_details"><?php if($formThree['medication']=='1'){echo $formThree['medication_desc'];}?></textarea>
	</span>
</div> 


<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="sha_student_disabilities" class="full_label">Do you have any disabilities?</label>
				<select id="sha_student_disabilities" name="sha_student_disabilities" class="full_input">
                <option value="">Select one</option>
                <option class="" value="0" <?php if($formThree['disabilities']=="0"){echo 'selected="selected"';}?>>No</option>
                <option class="" value="1" <?php if($formThree['disabilities']=="1"){echo 'selected="selected"';}?>>Yes</option>
                </select>
			</span>
</div>

<div class=" full_width_field left_margin" id="sha_student_disabilities_requirement" <?php if($formThree['disabilities']!='1'){echo 'style="display:none;"';}?>>
     <span class="hfa1_app_full">
			<label class="full_label hidden_label" for="">Details of any disabilities <span class="reqField">*</span></label>
			<textarea class="full_inputss errorOnBlur width-230" name="sha_disabilities_details" id="sha_disabilities_details"><?php if($formThree['disabilities']=='1'){echo $formThree['disabilities_desc'];}?></textarea>
	</span>
</div> 


</div>


</fieldset>
</fieldset>


<fieldset class="section column" id="tfa_22">
<fieldset class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new" id="">

<h3>Homestay Family Preferences</h3>

<div class="hfa1_home_left">		

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for=""  style="width:280px;">Can you live with children 0-10 years old?</label>
				<select id="" class="full_input" name="sha_live_with_child11">
                <option value="">Select one</option>
                <option value="1" id="" <?php if($formThree['live_with_child11']==1){echo 'selected="selected"';}?>>Yes</option>
                <option value="0" id="" <?php if($formThree['live_with_child11']=='0'){echo 'selected="selected"';}?>>No</option>
				</select>
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="" style="width:280px;">Can you live with children 11-17 years old?</label>
				<select id="" class="full_input" name="sha_live_with_child20">
                <option value="">Select one</option>
                <option value="1" id="" <?php if($formThree['live_with_child20']==1){echo 'selected="selected"';}?>>Yes</option>
                <option value="0" id="" <?php if($formThree['live_with_child20']=='0'){echo 'selected="selected"';}?>>No</option>
				</select>
			</span>
</div>
  
<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="">Reason for the preference above</label>
			<textarea class="full_input width-251" name="sha_live_with_child_reason" ><?=$formThree['live_with_child_reason']?></textarea>
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="" style="width:280px;">Will you stay with a family that includes a smoker?</label>
				<select id="" class="full_input" name="family_include_smoker">
                <option value="">Select one</option>
                <?php foreach($smokingHabbits as $shK=>$shV){?>
	                <option class=""  value="<?=$shK?>" <?php if($formThree['family_include_smoker']==$shK && $formThree['family_include_smoker']!=''){echo 'selected="selected"';}?>><?=$shV?></option>
                <?php } ?>
				</select>
			</span>
</div>
     

</div>


<div class="hfa1_home_right">

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="" class="full_label">Other family preferences</label>
			<textarea class="full_input student_preferences width-251" name="sha_family_pref" id=""><?=$formThree['family_pref']?></textarea>
			</span>
</div>

</div>


</fieldset>
</fieldset>


<fieldset id="tfa_23" class="section column">
<fieldset id="" class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new">

<h3>College/Institution Details</h3>

<div class="hfa1_home_left">		

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="sha_student_college" class="full_label" style="width:260px;">Name of College/Institution you will study at</label>
			<input type="text" id="sha_student_college" value="<?=$formThree['college']?>" name="sha_student_college" class="full_input">
			</span>
</div>


<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="sha_student_campus" class="full_label" style="width:260px;">Campus</label>
			<input type="text" id="sha_student_campus" value="<?=$formThree['campus']?>" name="sha_student_campus" class="full_input">
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="">College/Institution address</label>
			<textarea class="full_input width-251" name="sha_student_college_address" id=""><?=$formThree['college_address']?></textarea>
			</span>
</div>
</div>


<div class="hfa1_home_right">

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="sha_student_course_name" class="full_label" style="width:260px;">Course name</label>
			<input type="text" id="sha_student_course_name" value="<?=$formThree['course_name']?>" name="sha_student_course_name" class="full_input">
			</span>
</div>


<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="sha_student_course_start_date" class="full_label" style="width:260px;">Course start date</label>
			<input type="text" id="sha_student_course_start_date" value="<?php if(isset($formThree) && $formThree['course_start_date']!='0000-00-00'){echo date('d/m/Y',strtotime($formThree['course_start_date']));}?>" name="sha_student_course_start_date" class="full_input">
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label style="width:280px;" for="homestay_choosing_reason" class="full_label">Your reason for choosing Homestay accommodation?</label>
				<select class="full_input" id="homestay_choosing_reason" name="homestay_choosing_reason">
                <option value="">Select one</option>
               <?php foreach($homestayChooseReasonList as $hrK=>$hrV){?>
	               <option class="" id="" value="<?=$hrK?>" <?php if($formThree['homestay_choosing_reason']==$hrK){echo 'selected="selected"';}?>><?=$hrV?></option>
                <?php } ?>
				</select>
			</span>
</div>

<div class=" full_width_field left_margin" id="homestay_reason" <?php if($formThree['homestay_choosing_reason']!=3){echo 'style="display:none;"';}?>>
			<span class="hfa1_app_full">
			<label for="" class="full_label hidden_label">Other reason for choosing homestay</label>
			<input type="text" id="" value="<?php if($formThree['homestay_choosing_reason']==3){echo $formThree['homestay_choosing_reason_other'];}?>" name="homestay_choosing_reason_other" class="full_inputss width-230">
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label style="width:280px;" for="homestay_hear_reason" class="full_label">How did you hear about Global Experience?</label>
				<select class="full_input" id="homestay_hear_ref" name="homestay_hear_ref">
                <option value="">Select one</option>
              <?php foreach($geRefList as $refK=>$refV){?>
	               <option class="" id="" value="<?=$refK?>" <?php if($formThree['homestay_hear_ref']==$refK){echo 'selected="selected"';}?>><?=$refV?></option>
               <?php } ?>
              </select>
			</span>
</div>

<div class=" full_width_field left_margin" id="hearabout_reason" <?php if($formThree['homestay_hear_ref']!=7){echo 'style="display:none;"';}?>>
			<span class="hfa1_app_full">
			<label for="" class="full_label hidden_label">Other referral, please specify</label>
			<input type="text" id="" value="<?php if($formThree['homestay_hear_ref']==7){echo $formThree['homestay_hear_ref_other_val'];}?>" name="homestay_hear_ref_other_val" class="full_inputss width-230">
			</span>
</div>

</div>


</fieldset>
</fieldset>


<div class="end-options admin-end">
<input type="button" value="Update" id="shaThreeUpdate" class="btn-btn-medium hfa_submit">
<div id="shaThreeProcess" style="display:none;" class="appFormProcess">
	<img src="<?=str_replace('http:','https:',static_url())?>img/submitload.gif"   />
</div>
</div>
</form>
</div>
</div>

</div>

<script type="text/javascript">
$(document).ready(function(){
	
	$('.sha_diet').click(function(){
			if($(this).is(':checked'))
				$('#dietError').hide();
		});

	$('.sha_allergy').click(function(){
			if($(this).is(':checked'))
				$('#allergyError').hide();
		});
	
	$('#sha_student_course_start_date').datepicker({
		  changeMonth: true,
		  changeYear: true,
		  yearRange: "c-1:c+5",
		  dateFormat: 'dd/mm/yy'
		});	
			
	$('#shaThreeUpdate').click(function(){
			var $shaThreeProcess=$('#shaThreeProcess');
			var $shaThreeSubmitBtn=$('#shaThreeUpdate');
			
			var $sha_diet_other_val=$('#sha_diet_other_val');
			var $sha_allergy_other_val=$('#sha_allergy_other_val');
			var $sha_student_medication_details=$('#sha_student_medication_details');
			var $sha_disabilities_details=$('#sha_disabilities_details');
			
			var sha_diet_other_val=$sha_diet_other_val.val().trim();
			var sha_allergy_other_val=$sha_allergy_other_val.val().trim();
			var sha_student_medication_details=$sha_student_medication_details.val().trim();
			var sha_disabilities_details=$sha_disabilities_details.val().trim();
			
			removeFieldError($sha_diet_other_val);
			removeFieldError($sha_allergy_other_val);
			removeFieldError($sha_student_medication_details);
			removeFieldError($sha_disabilities_details);
			
			$('#allergyError, #dietError').hide();
			
			var sha_allergy=true;
			$('.sha_allergy').each(function(){
					if($('#sha_type_of_allergies').is(':visible'))
					{
						if(!$(this).is(':checked'))
							{
								sha_allergy=false;
								$('#allergyError').show();
							}
							else
							{
								sha_allergy=true;
								$('#allergyError').hide();
								return false;
							}
					}
				});
				
			var sha_diet=true;
			$('.sha_diet').each(function(){
				if($('#sha_type_of_dietary').is(':visible'))
					{
					  if(!$(this).is(':checked'))
						  {
							  sha_diet=false;
							  $('#dietError').show();
						  }
						  else
							{
								sha_diet=true;
								$('#dietError').hide();
								return false;
							}

					}
				});			
			
			
			if(($sha_diet_other_val.is(':visible') && sha_diet_other_val=='') || ($sha_allergy_other_val.is(':visible') && sha_allergy_other_val=='') || ($sha_student_medication_details.is(':visible') && sha_student_medication_details=='') || ($sha_disabilities_details.is(':visible') && sha_disabilities_details=='') || !sha_diet || !sha_allergy)
			{
				if($sha_diet_other_val.is(':visible') && sha_diet_other_val=='')
					addFieldError($sha_diet_other_val);
				else	
					removeFieldError($sha_diet_other_val);
						
				if($sha_allergy_other_val.is(':visible') && sha_allergy_other_val=='') 
					addFieldError($sha_allergy_other_val);
				else	
					removeFieldError($sha_allergy_other_val);
						
				if($sha_student_medication_details.is(':visible') && sha_student_medication_details=='') 
					addFieldError($sha_student_medication_details);
				else	
					removeFieldError($sha_student_medication_details);
						
				if($sha_disabilities_details.is(':visible') && sha_disabilities_details=='')
					addFieldError($sha_disabilities_details);
				else	
					removeFieldError($sha_disabilities_details);
				
				scrollToDiv('#student-homestay-application');
				errorBar('All fields marked with red are required');		
			}
			else
			{
					$shaThreeProcess.show();
					$shaThreeSubmitBtn.hide();
					var id=$('input[name=id]').val();
					
					var sha_threeForm=$('#sha_threeForm').serialize();
					$.ajax({
					url:site_url()+'sha/application_edit_three_submit',
					type:'POST',
					data:sha_threeForm,
					success:function(data)
						{
							$shaThreeProcess.hide();
							window.location.href=site_url()+'sha/application/'+id;
						}
					});
			}
		});
		
	});
</script>