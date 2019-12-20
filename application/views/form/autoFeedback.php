<div id="student-homestay-application" class="wFormContainer new_forms add-hostfamily-application">
<legend class="headingHostForm">Ge Homestay Student Feedback</legend>
	<p style="font-size:14px; margin-bottom: 10px;">Thank you for using Global experience's services.</p>
    
<?php if(isset($submitted)){?>
<p style="font-size:14px;">Your have already submitted your feedback.</p>
<?php }else{ ?>    
<p style="font-size:14px;">We would greatly appreciate if you can take some time to fill in the survey below. Your feedback is important to us and we hope to improve our services in the future.</p>

  <div style="background:none;" class="">
  <div class="wForm">
  
<form method="post"  class="hintsBelow labelsAbove" id="feedbackForm">
<input type="hidden" name="booking" value="<?=$id?>" />
<input type="hidden" name="student" value="<?=$booking['student']?>" />
<input type="hidden" name="host" value="<?=$booking['host']?>" />
<fieldset class="section column">
<fieldset id="" class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new">

<h3>Personal Details</h3>

<div class="hfa1_home_fuul">		
    <div class=" full_width_field">
        <span class="hfa1_app_full">
            <label class="full_label full_label_fuul" for="feedback">Full Name</label>
            <input type="text" class="full_input_fuul errorOnBlur notReq" name="sha_name" value="<?=ucwords($shaOne['fname'].' '.$shaOne['lname'])?>" id="sha_name">
        </span>
        <span class="hfa1_app_full">
            <label class="full_label full_label_fuul" for="feedback">Educational Institution</label>
            <input type="text" class="full_input_fuul errorOnBlur notReq" name="sha_college" value="<?=$shaThree['college']?>" id="sha_college">
        </span>
        <span class="hfa1_app_full">
            <label class="full_label full_label_fuul" for="feedback">Name of Homestay family (full name)</label>
            <input type="text" class="full_input_fuul errorOnBlur notReq" name="host_name" value="<?=ucwords($hfaOne['fname'].' '.$hfaOne['lname'])?>" id="hostname">
        </span>
        <span class="hfa1_app_full">
        <?php
		$stateList=stateList();
        $hfaAddress='';
		if($hfaOne['street']!='')
			$hfaAddress .=$hfaOne['street'].", ";
		$hfaAddress .=ucfirst($hfaOne['suburb']).", ".$stateList[$hfaOne['state']].", ".$hfaOne['postcode'];
		?>
            <label class="full_label full_label_fuul" for="feedback">Homestay Address</label>
            <input type="text" class="full_input_fuul errorOnBlur notReq" name="host_address" value="<?=$hfaAddress?>" id="host_address">
        </span>
        <span class="hfa1_app_full">
            <label class="full_label full_label_fuul" for="feedback">Move in date</label>
            <input type="text" class="full_input_fuul errorOnBlur notReq" name="move_in_date" id="move_in_date" value="<?=date('d/m/Y',strtotime($booking['booking_from']))?>" readonly="readonly">
        </span>
    </div>
</div>
<div class="hfa1_home_right"></div>

</fieldset>
</fieldset>


<fieldset class="section column">
<fieldset id="" class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new">

<h3>Airport Pick-up</h3>

<div class="hfa1_home_fuul">		
    <div class=" full_width_field">
    <span class="hfa1_app_full">
			<label class="full_label " for="sha_accomodation">Did Global Experience organise your airport pick-up?</label>
            <select class="full_input_fuul errorOnBlur" name="apu" id="apu">
				<option value="">Select one</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
                </select>
			</span>
            
            <div id="apuSatisfiedDiv" style="display:none;">
                <div class=" full_width_field" style="margin-top: 12px;">
                    <span class="hfa1_app_full">
                        <label style="margin-bottom:5px;" for="" class="full_label">If 'Yes', were you satisfied with the airport pick-up service?</label>
                        <input type="radio" value="1" name="apu_satisfied" id="apu_satisfied" style="float:left;width:20px !important; margin-right:5px;">
                        <label class="selt " for="postal_address_same" style="float:left;  margin-bottom:3px; margin-right: 20px;  ">Satisfied </label>
                        <input type="radio" value="0" name="apu_satisfied" id="apu_satisfied" style="float:left; width:20px !important; margin-right:5px;">
                        <label class="selttwo " for="postal_address_provide" style="float:left; margin-bottom:3px;  ">Dissatisfied </label>
                    </span>
                </div>
    
                <div class=" full_width_field">
                            <span class="hfa1_app_full">
                            <label for="apu_desc" class="full_label">If you were not happy with the airport pick-up service, could you briefly explain why?</label>
                            <textarea name="apu_desc" id="apu_desc" class="full_input_fuul"></textarea>
                            </span>
                </div>            
            </div>
            
    </div>
</div>
<div class="hfa1_home_right"></div>

</fieldset>
</fieldset>


<fieldset class="section column">
<fieldset id="" class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new">

<h3> Homestay Experience</h3>

			<div class=" full_width_field" style="margin-top: 12px;">
                <span class="hfa1_app_full">
                    <label style="margin-bottom:5px;" for="" class="full_label">Do you find the homestay comfortable? </label>
                    
                    <input type="radio" value="extremely_dissatisfied" name="hfa_comfort" style="float:left;width:20px !important; margin-right:5px;">
                    <label class="selt " style="float:left; margin-bottom:3px; margin-right: 20px;  ">Extremely Dissatisfied</label>
                   
                    <input type="radio" value="dissatisfied" name="hfa_comfort" style="float:left; width:20px !important; margin-right:5px;">
                    <label class="selttwo " style="float:left;  margin-bottom:3px; margin-right: 20px;  ">Dissatisfied</label>
                    
                    <input type="radio" value="satisfied" name="hfa_comfort" style="float:left;width:20px !important; margin-right:5px;">
                    <label class="selt " for="postal_address_same" style="float:left;margin-bottom:3px; margin-right: 20px; ">Satisfied/ Neutral </label>
                    
                    <input type="radio" value="happy" name="hfa_comfort" style="float:left; width:20px !important; margin-right:5px;">
                    <label class="selttwo " style="float:left; margin-bottom:3px; ">Happy</label>
                </span>
                 <p class="border-bot"></p>
			</div>

			<div class=" full_width_field" style="margin-top: 12px;">
                <span class="hfa1_app_full">
                    <label style="margin-bottom:5px;" for="" class="full_label">Is your homestay family friendly and helpful?  </label>
                    
                    <input type="radio" value="extremely_dissatisfied" name="hfa_friendly" style="float:left;width:20px !important; margin-right:5px;">
                    <label class="selt " style="float:left;  margin-bottom:3px; margin-right: 20px;   ">Extremely Dissatisfied</label>
                    
                    <input type="radio" value="dissatisfied" name="hfa_friendly" style="float:left; width:20px !important; margin-right:5px;">
                    <label class="selttwo " style="float:left; margin-bottom:3px; margin-right: 20px;  ">Dissatisfied</label>
                    
                    <input type="radio" value="satisfied" name="hfa_friendly" style="float:left;width:20px !important; margin-right:5px;">
                    <label class="selt " style="float:left; margin-bottom:3px; margin-right: 20px;   ">Satisfied/ Neutral </label>
                    
                    <input type="radio" value="happy" name="hfa_friendly" style="float:left; width:20px !important; margin-right:5px;">
                    <label class="selttwo " style="float:left; margin-bottom:3px;  ">Happy</label>
                </span>
                <p class="border-bot"></p>
			</div>

			<div class=" full_width_field" style="margin-top: 12px;">
                <span class="hfa1_app_full">
                    <label style="margin-bottom:5px;" for="" class="full_label">How do you feel about the food in your homestay?  </label>
                    
                    <input type="radio" value="extremely_dissatisfied" name="hfa_food" style="float:left;width:20px !important; margin-right:5px;">
                    <label class="selt " style="float:left; margin-bottom:3px; margin-right: 20px;  ">Extremely Dissatisfied</label>
                    
                    <input type="radio" value="dissatisfied" name="hfa_food" style="float:left; width:20px !important; margin-right:5px;">
                    <label class="selttwo " style="float:left; margin-bottom:3px; margin-right: 20px;  ">Dissatisfied</label>
                    
                    <input type="radio" value="satisfied" name="hfa_food" style="float:left;width:20px !important; margin-right:5px;">
                    <label class="selt " style="float:left; margin-bottom:3px; margin-right: 20px;   ">Satisfied/ Neutral </label>
                    
                    <input type="radio" value="happy" name="hfa_food" style="float:left; width:20px !important; margin-right:5px;">
                    <label class="selttwo " style="float:left; margin-bottom:3px;  ">Happy</label>
                </span>
                <p class="border-bot"></p>
			</div>

			<div class=" full_width_field" style="margin-top: 12px;">
                <span class="hfa1_app_full">
                    <label style="margin-bottom:5px;" for="" class="full_label">Overall, are you happy with your homestay? </label>
                    
                    <input type="radio" value="extremely_dissatisfied" name="hfa_overall" style="float:left;width:20px !important; margin-right:5px;">
                    <label class="selt " style="float:left; margin-bottom:3px; margin-right: 20px;   ">Extremely Dissatisfied</label>
                    
                    <input type="radio" value="dissatisfied" name="hfa_overall" style="float:left; width:20px !important; margin-right:5px;">
                    <label class="selttwo " style="float:left;  margin-bottom:3px;margin-right: 20px;  ">Dissatisfied</label>
                    
                    <input type="radio" value="satisfied" name="hfa_overall" style="float:left;width:20px !important; margin-right:5px;">
                    <label class="selt " style="float:left; margin-bottom:3px; margin-right: 20px;   ">Satisfied/ Neutral </label>
                    
                    <input type="radio" value="happy" name="hfa_overall" style="float:left; width:20px !important; margin-right:5px;">
                    <label class="selttwo " style="float:left;  margin-bottom:3px;  ">Happy</label>
                </span>
         
			</div>
            
<div class="hfa1_home_right"></div>

</fieldset>
</fieldset>


<fieldset class="section column">
<fieldset id="" class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new">

<h3> Your Testimonials</h3>

<div class="hfa1_home_fuul">		
    <div class=" full_width_field">
    
            <div class=" full_width_field">
                        <span class="hfa1_app_full">
                        <label for="testimonial" class="full_label ">It would be appreciated if you could drop us a few lines in regards to our service and your experience living in your homestay</label>
                        <textarea id="testimonial" value="" name="testimonial" class="full_input fuul_input"></textarea>
                        </span>
            </div>            
            
            
    </div>
</div>
<div class="hfa1_home_right"></div>

</fieldset>
</fieldset>

<fieldset class="section column">
<fieldset id="" class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new">

<h3>  Other Comments?﻿</h3>

<div class="hfa1_home_fuul">		
    <div class=" full_width_field">
    
            <div class=" full_width_field">
                        <span class="hfa1_app_full">
                        <label for="comments" class="full_label ">Please write below any comments/suggestions that might assist Global Experience in providing a better service in the future.</label>
                        <textarea id="comments" value="" name="comments" class="full_input fuul_input"></textarea>
                        </span>
            </div>            
            
            
    </div>
</div>
<div class="hfa1_home_right"></div>

</fieldset>
</fieldset>

<div class="end-options" style="border:0;">
  <input type="button" value="Submit" id="feedbackSubmitBtn" class="btn-btn-medium hfa_submit">
  <div id="feedbackProcess" style="display:none;" class="appFormProcess">
      <img src="<?=str_replace('http:','https:',static_url())?>img/submitload.gif"   />
  </div>
  <span id="feedbackError" style="display:none;color:#F00;">The form is incomplete. Fields outlined with red are required in the right format.</span>
</div>

<!--<p class="end-options-para">After submitting the application, you can continue to fill the application form further or you can fill the full application form later, using the link 
sent in your email.</p>-->

</form>
</div>
</div>
<?php } ?>

</div>

<script type="text/javascript">
$(document).ready(function(){
	
	
	  $('#move_in_date').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'dd/mm/yy'
	  });
		
	$('#apu').change(function(){
		if($(this).val()=='1')
			$('#apuSatisfiedDiv').slideDown();
		else
			$('#apuSatisfiedDiv').slideUp();
	});
	
	$('#feedbackSubmitBtn').click(function(){
		
			var $feedbackProcess=$('#feedbackProcess');
			var $feedbackSubmitBtn=$('#feedbackSubmitBtn');
			
			$feedbackProcess.show();
			$feedbackSubmitBtn.hide();
				
			var feedbackForm=$('#feedbackForm').serialize();
			$.ajax({
					url:site_url()+'form/feedbackSubmit',
					type:'POST',
					data:feedbackForm,
					success:function(data)
						{
								scrollToDiv('#student-homestay-application');
								$feedbackSubmitBtn.show();
								$feedbackProcess.hide();
								successBar('Feedback submitted successfully');
								$('#feedbackForm')[0].reset();
								$('#apuSatisfiedDiv').hide();
						}
				});

		});
	});
</script>