<?php
$geRefList=geRefList();
$smokingHabbits=smokingHabbits();
//see($formFour);
?>

<div class="wFormContainer new_forms add-hostfamily-application dd-hostfamily-applicatio4" id="add-hostfamily-application-2">

<legend class="headingHostForm">Host Family Application Form
<span class="hand-written">All fields with red asterick<span class="reqField"> * </span>are mandatory</span></legend>

<div style="background:none;" class="">
  <div class="wForm" id="tfa_0-WRPR" dir="ltr">
  
<form method="post" action="" class="hintsBelow labelsAbove" id="host_family_application_fourForm">
<input type="hidden" name="id" value="<?=$formOne['id']?>" />
<div id="tfa_0-A" class="actions add_new_submission"><h4>STUDENT PREFERENCES</h4></div>

<fieldset class="section column" id="tfa_13">
<fieldset class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new" id="">

<h3>Student Preferences</h3>

<div class="hfa1_home_left">		

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="hfa_student_age_pref">Student age preference</label>
				<select id="hfa_student_age_pref" name="hfa_student_age_pref" class="full_input">
                <option value="">Select one</option>
                <option class="" id="" value="1" <?php if($formFour['age_pref']=="1"){echo 'selected="selected"';}?>>Under 18</option>
                <option class="" id="" value="2" <?php if($formFour['age_pref']=="2"){echo 'selected="selected"';}?>>Over 18</option>
                <option class="" id="" value="3" <?php if($formFour['age_pref']=="3"){echo 'selected="selected"';}?>>No preference</option>
				</select>
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="hfa_student_gender_pref">Student gender preference</label>
				<select id="hfa_student_gender_pref" name="hfa_student_gender_pref" class="full_input">
                <option value="">Select one</option>
                <option class="" id="" value="2" <?php if($formFour['gender_pref']=="2"){echo 'selected="selected"';}?>>Female</option>
                <option class="" id="" value="1" <?php if($formFour['gender_pref']=="1"){echo 'selected="selected"';}?>>Male</option>
                <option class="" id="" value="3" <?php if($formFour['gender_pref']=="3"){echo 'selected="selected"';}?>>No preference</option>
				</select>
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="hfa_age_pref_reason" class="full_label">Reason for age and gender preference</label>
			<textarea id="hfa_age_pref_reason" value="" name="hfa_age_pref_reason" class="full_input"><?=$formFour['reason_age_gender']?></textarea>
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="hfa_disable_student_accomodate" style="width:270px;">Are you able to accommodate students with disabilities?</label>
				<select id="hfa_disable_student_accomodate" name="hfa_disable_student_accomodate" class="full_input">
                <option value="">Select one</option>
                <option value="1" id="" class="" <?php if($formFour['disable_students']=="0"){echo 'selected="selected"';}?>>Yes</option>
                <option value="0" id="" class="" <?php if($formFour['disable_students']=="1"){echo 'selected="selected"';}?>>No</option>
				</select>
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="hfa_smoker_student_accomodate" style="width:270px;">Are you able to accommodate students who smoke?</label>
				<select id="hfa_smoker_student_accomodate"  name="hfa_smoker_student_accomodate" class="full_input">
                <option value="" <?php if($formFour['smoker_students']==''){echo 'selected="selected"';}?>>Select one</option> 
                <?php foreach($smokingHabbits as $shK=>$shV){?>               
                	<option  value="<?=$shK?>" <?php if($formFour['smoker_students']!='' && $formFour['smoker_students']==$shK){echo 'selected="selected"';}?>><?=$shV?></option>
                <?php } ?>
				</select>
			</span>
</div>      

</div>



<div class="hfa1_home_right">

<div class=" full_width_field">
			<span class="hfa1_app_full smoke-yes">
			<label class="full_label" for="hfa_diet_student_accomodate" style="width:290px;">Will you be able to accommodate students with special dietary requirements?</label>
				<select id="hfa_diet_student_accomodate" name="hfa_diet_student_accomodate" class="full_input">
                <option value="">Select one</option>                
                <option value="1" id="" class="" <?php if($formFour['diet_student']=="1"){echo 'selected="selected"';}?>>Yes</option>
                <option value="0" id="" class="" <?php if($formFour['diet_student']=="0"){echo 'selected="selected"';}?>>No</option>
				</select>
			</span>
</div>  

<div class=" full_width_field left_margin"  <?php if($formFour['diet_student']!="1"){?>style="display:none;"<?php }?> id="type_of_dietary">
      
      <label class="full_label hidden_label" for="hfa1_facility">Dietary requirements </label>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" class="hfa_checkbox_input " name="diet[veg]" value="1" id="" <?php if($formFour['diet_req_veg']=="1"){?>checked="checked"<?php }?>>
				<label class=" selt" for="">Vegetarian</label>                
	  </span>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" class="hfa_checkbox_input " name="diet[gluten]" value="1" id="" <?php if($formFour['diet_req_gluten']=="1"){?>checked="checked"<?php }?>>
				<label class=" selt" for="">Gluten/Lactose Free</label>                
	  </span>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" class="hfa_checkbox_input " name="diet[no_pork]" value="1" id="" <?php if($formFour['diet_req_no_pork']=="1"){?>checked="checked"<?php }?>>
				<label class="selt" for="">No Pork</label>                
	  </span>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" class="hfa_checkbox_input " name="diet[food_allergies]" value="1" id="" <?php if($formFour['diet_req_food_allergy']=="1"){?>checked="checked"<?php }?>>
				<label class="selt" for="">Food Allergies</label>                
	  </span>
      
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full smoke-yes">
			<label class="full_label" for="hfa_allergic_student_accomodate" style="width:270px;">Are you able to accommodate students with allergies?</label>
				<select id="hfa_allergic_student_accomodate" name="hfa_allergic_student_accomodate" class="full_input">
                <option value="">Select one</option>                
                <option value="1" id="" class="" <?php if($formFour['allergic_students']=="1"){echo 'selected="selected"';}?>>Yes</option>
                <option value="0" id="" class="" <?php if($formFour['allergic_students']=="0"){echo 'selected="selected"';}?>>No</option>
				</select>
			</span>
</div> 


<div class=" full_width_field left_margin"   <?php if($formFour['allergic_students']!="1"){?>style="display:none;"<?php }?> id="type_of_allergies">
      
      <label class="full_label hidden_label" for="hfa1_facility">Type of allergies you can support</label>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" class="hfa_checkbox_input " name="allergy[hay_fever]" value="1" id="" <?php if($formFour['allerry_hay_fever']=="1"){?>checked="checked"<?php }?>>
				<label class=" selt" for="">Hay Fever</label>                
	  </span>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" class="hfa_checkbox_input " name="allergy[asthma]" value="1" id="" <?php if($formFour['allerry_asthma']=="1"){?>checked="checked"<?php }?>>
				<label class=" selt" for="">Asthma</label>                
	  </span>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" class="hfa_checkbox_input " name="allergy[lactose]" value="1" id="" <?php if($formFour['allerry_lactose']=="1"){?>checked="checked"<?php }?>>
				<label class="selt" for="">Lactose Intolerance</label>                
	  </span>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" class="hfa_checkbox_input " name="allergy[gluten]" value="1" id="" <?php if($formFour['allerry_gluten']=="1"){?>checked="checked"<?php }?>>
				<label class="selt" for="">Gluten Intolerance</label>                
	  </span>
      
       <span class="hfa1_app_full">	
				<input type="checkbox" class="hfa_checkbox_input " name="allergy[peanut]" value="1" id="" <?php if($formFour['allerry_peanut']=="1"){?>checked="checked"<?php }?>>
				<label class="selt" for="">Peanut Allergies</label>                
	  </span>
      
       <span class="hfa1_app_full">	
				<input type="checkbox" class="hfa_checkbox_input " name="allergy[dust]" value="1" id="" <?php if($formFour['allerry_dust']=="1"){?>checked="checked"<?php }?>>
				<label class="selt" for="">Dust Allergies</label>                
	  </span>
      
       <span class="hfa1_app_full">	
				<input type="checkbox" class="hfa_checkbox_input " name="allergy[other]" value="1" id="other_allergy_type" <?php if($formFour['allerry_other']=="1"){?>checked="checked"<?php }?>>
				<label class="selt" for="oher_allergy_type">Other, please provide details</label>                
	  </span>
      <span class="hfa1_app_full smoke-yes" id="other_allergies" <?php if($formFour['allerry_other']!=1){?>style="display:none; margin-top:10px;"<?php }?>>
      <label for="hfa1_other_allergies" class="full_label hidden_label">Other allergies <span class="reqField">*</span></label>
      <input type="text" id="hfa_other_allergies" value="<?=$formFour['allerry_other_val']?>" name="allergy[hfa_other_allergies]" class="full_inputss errorOnBlur">
      </span>
</div> 

</div>


</fieldset>
</fieldset>


<fieldset id="tfa_14" class="section column">
<fieldset id="" class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new">

<h3>Other</h3>	

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="">Other student preferences</label>
			<textarea class="full_textareas" name="other_pref" value="" id="other_preff"><?=$formFour['other_pref']?></textarea>
			</span>
</div>

</fieldset>
</fieldset>

<div class="end-options admin-end">
<input type="button" value="Update" id="hfaFourSubmitBtn" class="btn-btn-medium hfa_submit">

<div id="hfaFourProcess" style="display:none;" class="appFormProcess">
	<img src="<?=str_replace('http:','https:',static_url())?>img/submitload.gif"   />
</div>

<span id="hfaFourError" style="display:none;color:#F00;">The form is incomplete. Fields outlined with red are required in the right format.</span>
</div>

</form>
</div>
</div>

</div>

<script type="text/javascript">
$(document).ready(function(){
	
	
	$('#hfaFourSubmitBtn').click(function(){
		
			var $hfaFourProcess=$('#hfaFourProcess');
			var $hfaFourSubmitBtn=$('#hfaFourSubmitBtn')
		
			var $hfa_other_allergies=$('#hfa_other_allergies');
			var hfa_other_allergies=$hfa_other_allergies.val().trim();
			
			removeFieldError($hfa_other_allergies);
			$('#hfaFourError').hide();
			
			if($hfa_other_allergies.is(':visible') && hfa_other_allergies=='')
			{
				addFieldError($hfa_other_allergies);
				//$('#hfaFourError').show();
				scrollToDiv('#add-hostfamily-application-2');
				errorBar('All fields marked with red are required');
			}
			else
			{
				$hfaFourProcess.show();
				$hfaFourSubmitBtn.hide();
							
				var host_family_application_fourForm=$('#host_family_application_fourForm').serialize();
				var id=$('input[name=id]').val();
				$.ajax({
						url:site_url()+'hfa/application_edit_four_submit',
						type:'POST',
						data:host_family_application_fourForm,
						success:function(data)
							{
									$hfaFourProcess.hide();
									window.location.href=site_url()+'hfa/application/'+id;	
							}
					});
			}
		});
	
	});
</script>