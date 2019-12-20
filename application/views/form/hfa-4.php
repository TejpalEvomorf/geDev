<?php
$geRefList=geRefList();
$smokingHabbits=smokingHabbits();
?>

<!--Success Pop Up STARTS-->
  <div class="modal fade successPop" id="hfa_successPopUpThree"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h2 class="modal-title"></h2>
							</div>
							<div class="modal-body">
								<img src="<?=str_replace('http:','https:',static_url())?>img/tick.png" />
								<h3>Third Step of your Host Family application (Family Details), has been submitted successfully.</h3>
								<p>You can continue to next step or if you wish to do that later, you can use the link sent in your email upon completion of first step.</p>
                                <a href="javascript:void(0)" data-dismiss="modal">CONTINUE TO NEXT STEP</a>
							</div>
							<div class="modal-footer">
                            <span style="font-weight:bold; color:#1d7643; background:#eeeeee;">Step 1: Personal Details (complete) <img src="<?=str_replace('http:','https:',static_url())?>img/complete-tick.png" /></span>
                            <span style="font-weight:bold; color:#1d7643; background:#eeeeee;">Step 2: Property Details (complete) <img src="<?=str_replace('http:','https:',static_url())?>img/complete-tick.png" /></span>
                           <span style="font-weight:bold; color:#1d7643; background:#eeeeee;">Step 3: Family details (complete) <img src="<?=str_replace('http:','https:',static_url())?>img/complete-tick.png" /></span>
                            <span>Step 4: Student preferences</span>
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div>
<!--Success Pop ENDS-->

<div class="wFormContainer new_forms add-hostfamily-application dd-hostfamily-applicatio4" id="add-hostfamily-application-2">

<legend class="headingHostForm">Host Family Application Form
<span class="hand-written">All fields with red asterick<span class="reqField"> * </span>are mandatory</span></legend>

<div style="background:none;" class="">
  <div class="wForm" id="tfa_0-WRPR" dir="ltr">
  
<form method="post" action="" class="hintsBelow labelsAbove" id="host_family_application_fourForm">
<input type="hidden" name="id" value="<?=$id?>" />
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
                <option class="" id="" value="1">Under 18</option>
                <option class="" id="" value="2">Over 18</option>
                <option class="" id="" value="3">No preference</option>
				</select>
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="hfa_student_gender_pref">Student gender preference</label>
				<select id="hfa_student_gender_pref" name="hfa_student_gender_pref" class="full_input">
                <option value="">Select one</option>
                <option class="" id="" value="2">Female</option>
                <option class="" id="" value="1">Male</option>
                <option class="" id="" value="3">No preference</option>
				</select>
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="hfa_age_pref_reason" class="full_label">Reason for age and gender preference</label>
			<textarea id="hfa_age_pref_reason" value="" name="hfa_age_pref_reason" class="full_input"></textarea>
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="hfa_disable_student_accomodate" style="width:270px;">Are you able to accommodate students with disabilities?</label>
				<select id="hfa_disable_student_accomodate" name="hfa_disable_student_accomodate" class="full_input">
                <option value="">Select one</option>
                <option value="1" id="" class="">Yes</option>
                <option value="0" id="" class="">No</option>
				</select>
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="hfa_smoker_student_accomodate" style="width:270px;">Are you able to accommodate students who smoke?</label>
				<select id="hfa_smoker_student_accomodate"  name="hfa_smoker_student_accomodate" class="full_input">
                <option value="">Select one</option> 
                <?php foreach($smokingHabbits as $shK=>$shV){?>               
                	<option  value="<?=$shK?>"><?=$shV?></option>
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
                <option value="1" id="" class="">Yes</option>
                <option value="0" id="" class="">No</option>
				</select>
			</span>
</div>  

<div class=" full_width_field left_margin" style="display:none;" id="type_of_dietary">
      
      <label class="full_label hidden_label" for="hfa1_facility">Dietary requirements </label>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" class="hfa_checkbox_input " name="diet[veg]" value="1" id="">
				<label class=" selt" for="">Vegetarian</label>                
	  </span>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" class="hfa_checkbox_input " name="diet[gluten]" value="1" id="">
				<label class=" selt" for="">Gluten/Lactose Free</label>                
	  </span>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" class="hfa_checkbox_input " name="diet[no_pork]" value="1" id="">
				<label class="selt" for="">No Pork</label>                
	  </span>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" class="hfa_checkbox_input " name="diet[food_allergies]" value="1" id="">
				<label class="selt" for="">Food Allergies</label>                
	  </span>
      
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full smoke-yes">
			<label class="full_label" for="hfa_allergic_student_accomodate" style="width:270px;">Are you able to accommodate students with allergies?</label>
				<select id="hfa_allergic_student_accomodate" name="hfa_allergic_student_accomodate" class="full_input">
                <option value="">Select one</option>                
                <option value="1" id="" class="">Yes</option>
                <option value="0" id="" class="">No</option>
				</select>
			</span>
</div> 


<div class=" full_width_field left_margin" style="display:none;" id="type_of_allergies">
      
      <label class="full_label hidden_label" for="hfa1_facility">Type of allergies you can support</label>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" class="hfa_checkbox_input " name="allergy[hay_fever]" value="1" id="">
				<label class=" selt" for="">Hay Fever</label>                
	  </span>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" class="hfa_checkbox_input " name="allergy[asthma]" value="1" id="">
				<label class=" selt" for="">Asthma</label>                
	  </span>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" class="hfa_checkbox_input " name="allergy[lactose]" value="1" id="">
				<label class="selt" for="">Lactose Intolerance</label>                
	  </span>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" class="hfa_checkbox_input " name="allergy[gluten]" value="1" id="">
				<label class="selt" for="">Gluten Intolerance</label>                
	  </span>
      
       <span class="hfa1_app_full">	
				<input type="checkbox" class="hfa_checkbox_input " name="allergy[peanut]" value="1" id="">
				<label class="selt" for="">Peanut Allergies</label>                
	  </span>
      
       <span class="hfa1_app_full">	
				<input type="checkbox" class="hfa_checkbox_input " name="allergy[dust]" value="1" id="">
				<label class="selt" for="">Dust Allergies</label>                
	  </span>
      
       <span class="hfa1_app_full">	
				<input type="checkbox" class="hfa_checkbox_input " name="allergy[other]" value="1" id="other_allergy_type">
				<label class="selt" for="oher_allergy_type">Other, please provide details</label>                
	  </span>
      <span class="hfa1_app_full smoke-yes" id="other_allergies" style="display:none; margin-top:10px;">
      <label for="hfa1_other_allergies" class="full_label hidden_label">Other allergies <span class="reqField">*</span></label>
      <input type="text" id="hfa_other_allergies" value="" name="allergy[hfa_other_allergies]" class="full_inputss errorOnBlur">
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
			<textarea class="full_textareas" name="other_pref" value="" id="other_preff"></textarea>
			</span>
</div>

</fieldset>
</fieldset>

<div class="end-options">
<input type="button" value="Submit" id="hfaFourSubmitBtn" class="btn-btn-medium hfa_submit">

<div id="hfaFourProcess" style="display:none;" class="appFormProcess">
	<img src="<?=str_replace('http:','https:',static_url())?>img/submitload.gif"   />
</div>

<span id="hfaFourError" style="display:none;color:#F00;">The form is incomplete. Fields outlined with red are required in the right format.</span>
</div>

<p class="end-options-para">This is the last part of the Host Family Application. After submitting this form, your application will be submitted for review and our Host Family 
Manager will contact you either through phone or email for property inspection.</p>

</form>
</div>
</div>

</div>

<?php if($popUp!=''){?>
	<script type="text/javascript">
				$('#hfa_successPopUpThree').modal({backdrop: 'static', keyboard: false});
    </script>
<?php } ?>

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
				$.ajax({
						url:site_url()+'form/host_family_application_four_submit',
						type:'POST',
						data:host_family_application_fourForm,
						success:function(data)
							{
									$hfaFourProcess.hide();
									//$hfaFourSubmitBtn.show();
									
									if(data=='next')

									{
									 	window.location.href=site_url()+'form/host_family_application_complete';
									}
							}
					});
			}
		});
	
	});
</script>