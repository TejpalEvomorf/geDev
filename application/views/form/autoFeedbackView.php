<div id="student-homestay-application" class="wFormContainer new_forms add-hostfamily-application">
<legend class="headingHostForm">Ge Homestay Student Feedback</legend>

  <div style="background:none;" class="">
  <div class="wForm">
  
<form method="post"  class="hintsBelow labelsAbove" id="feedbackForm">
<fieldset class="section column">
<fieldset id="" class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new">

<h3>Personal Details</h3>

<div class="hfa1_home_fuul">		
    <div class=" full_width_field">
        <span class="hfa1_app_full">
            <label class="full_label full_label_fuul" for="feedback">Full Name</label>
            <input type="text" class="full_input_fuul errorOnBlur notReq" name="sha_name" value="<?=$feedback['student_name']?>" id="sha_name">
        </span>
        <span class="hfa1_app_full">
            <label class="full_label full_label_fuul" for="feedback">Educational Institution</label>
            <input type="text" class="full_input_fuul errorOnBlur notReq" name="sha_college" value="<?=$feedback['student_college']?>" id="sha_college">
        </span>
        <span class="hfa1_app_full">
            <label class="full_label full_label_fuul" for="feedback">Name of Homestay family (full name)</label>
            <input type="text" class="full_input_fuul errorOnBlur notReq" name="host_name" value="<?=$feedback['host_name']?>" id="hostname">
        </span>
        <span class="hfa1_app_full">
            <label class="full_label full_label_fuul" for="feedback">Homestay Address</label>
            <input type="text" class="full_input_fuul errorOnBlur notReq" name="host_address" value="<?=$feedback['host_address']?>" id="host_address">
        </span>
        <span class="hfa1_app_full">
            <label class="full_label full_label_fuul" for="feedback">Move in date</label>
            <input type="text" class="full_input_fuul errorOnBlur notReq" name="move_in_date" id="move_in_date" value="<?=date('d/m/Y',strtotime($feedback['move_in_date']))?>" readonly="readonly">
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
                <option value="1" <?php if($feedback['apu']=='1'){echo 'selected';}?>>Yes</option>
                <option value="0" <?php if($feedback['apu']=='0'){echo 'selected';}?>>No</option>
                </select>
			</span>
            
            <div id="apuSatisfiedDiv" <?php if($feedback['apu']!='1'){echo 'style="display:none;"';}?>>
                <div class=" full_width_field" style="margin-top: 12px;">
                    <span class="hfa1_app_full">
                        <label style="margin-bottom:5px;" for="" class="full_label">If 'Yes', were you satisfied with the airport pick-up service?</label>
                        <input type="radio" value="1" name="apu_satisfied" id="apu_satisfied" style="float:left;width:20px !important; margin-right:5px;" <?php if($feedback['apu']=='1' && $feedback['apu_satisfied']=='1'){echo 'checked';}?>>
                        <label class="selt " for="postal_address_same" style="float:left;  margin-bottom:3px; margin-right: 20px;  ">Satisfied </label>
                        <input type="radio" value="0" name="apu_satisfied" id="apu_satisfied" style="float:left; width:20px !important; margin-right:5px;" <?php if($feedback['apu']=='1' && $feedback['apu_satisfied']=='0'){echo 'checked';}?>>
                        <label class="selttwo " for="postal_address_provide" style="float:left; margin-bottom:3px;  ">Dissatisfied </label>
                    </span>
                </div>
    
                <div class=" full_width_field">
                            <span class="hfa1_app_full">
                            <label for="apu_desc" class="full_label">If you were not happy with the airport pick-up service, could you briefly explain why?</label>
                            <textarea name="apu_desc" id="apu_desc" class="full_input_fuul"> <?php if($feedback['apu']=='1'){echo $feedback['apu_desc'];}?></textarea>
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
                    
                    <input type="radio" value="extremely_dissatisfied" name="hfa_comfort" style="float:left;width:20px !important; margin-right:5px;" <?php if($feedback['host_comfort']=='extremely_dissatisfied'){echo 'checked';}?>>
                    <label class="selt " style="float:left; margin-bottom:3px; margin-right: 20px;  ">Extremely Dissatisfied</label>
                   
                    <input type="radio" value="dissatisfied" name="hfa_comfort" style="float:left; width:20px !important; margin-right:5px;" <?php if($feedback['host_comfort']=='dissatisfied'){echo 'checked';}?>>
                    <label class="selttwo " style="float:left;  margin-bottom:3px; margin-right: 20px;  ">Dissatisfied</label>
                    
                    <input type="radio" value="satisfied" name="hfa_comfort" style="float:left;width:20px !important; margin-right:5px;" <?php if($feedback['host_comfort']=='satisfied'){echo 'checked';}?>>
                    <label class="selt " for="postal_address_same" style="float:left;margin-bottom:3px; margin-right: 20px; ">Satisfied/ Neutral </label>
                    
                    <input type="radio" value="happy" name="hfa_comfort" style="float:left; width:20px !important; margin-right:5px;" <?php if($feedback['host_comfort']=='happy'){echo 'checked';}?>>
                    <label class="selttwo " style="float:left; margin-bottom:3px; ">Happy</label>
                </span>
                 <p class="border-bot"></p>
			</div>

			<div class=" full_width_field" style="margin-top: 12px;">
                <span class="hfa1_app_full">
                    <label style="margin-bottom:5px;" for="" class="full_label">Is your homestay family friendly and helpful?  </label>
                    
                    <input type="radio" value="extremely_dissatisfied" name="hfa_friendly" style="float:left;width:20px !important; margin-right:5px;" <?php if($feedback['host_friendly']=='extremely_dissatisfied'){echo 'checked';}?>>
                    <label class="selt " style="float:left;  margin-bottom:3px; margin-right: 20px;   ">Extremely Dissatisfied</label>
                    
                    <input type="radio" value="dissatisfied" name="hfa_friendly" style="float:left; width:20px !important; margin-right:5px;" <?php if($feedback['host_friendly']=='dissatisfied'){echo 'checked';}?>>
                    <label class="selttwo " style="float:left; margin-bottom:3px; margin-right: 20px;  ">Dissatisfied</label>
                    
                    <input type="radio" value="satisfied" name="hfa_friendly" style="float:left;width:20px !important; margin-right:5px;" <?php if($feedback['host_friendly']=='satisfied'){echo 'checked';}?>>
                    <label class="selt " style="float:left; margin-bottom:3px; margin-right: 20px;   ">Satisfied/ Neutral </label>
                    
                    <input type="radio" value="happy" name="hfa_friendly" style="float:left; width:20px !important; margin-right:5px;" <?php if($feedback['host_friendly']=='happy'){echo 'checked';}?>>
                    <label class="selttwo " style="float:left; margin-bottom:3px;  ">Happy</label>
                </span>
                <p class="border-bot"></p>
			</div>

			<div class=" full_width_field" style="margin-top: 12px;">
                <span class="hfa1_app_full">
                    <label style="margin-bottom:5px;" for="" class="full_label">How do you feel about the food in your homestay?  </label>
                    
                    <input type="radio" value="extremely_dissatisfied" name="hfa_food" style="float:left;width:20px !important; margin-right:5px;" <?php if($feedback['host_food']=='extremely_dissatisfied'){echo 'checked';}?>>
                    <label class="selt " style="float:left; margin-bottom:3px; margin-right: 20px;  ">Extremely Dissatisfied</label>
                    
                    <input type="radio" value="dissatisfied" name="hfa_food" style="float:left; width:20px !important; margin-right:5px;" <?php if($feedback['host_food']=='dissatisfied'){echo 'checked';}?>>
                    <label class="selttwo " style="float:left; margin-bottom:3px; margin-right: 20px;  ">Dissatisfied</label>
                    
                    <input type="radio" value="satisfied" name="hfa_food" style="float:left;width:20px !important; margin-right:5px;" <?php if($feedback['host_food']=='satisfied'){echo 'checked';}?>>
                    <label class="selt " style="float:left; margin-bottom:3px; margin-right: 20px;   ">Satisfied/ Neutral </label>
                    
                    <input type="radio" value="happy" name="hfa_food" style="float:left; width:20px !important; margin-right:5px;" <?php if($feedback['host_food']=='happy'){echo 'checked';}?>>
                    <label class="selttwo " style="float:left; margin-bottom:3px;  ">Happy</label>
                </span>
                <p class="border-bot"></p>
			</div>

			<div class=" full_width_field" style="margin-top: 12px;">
                <span class="hfa1_app_full">
                    <label style="margin-bottom:5px;" for="" class="full_label">Overall, are you happy with your homestay? </label>
                    
                    <input type="radio" value="extremely_dissatisfied" name="hfa_overall" style="float:left;width:20px !important; margin-right:5px;" <?php if($feedback['host_overall']=='extremely_dissatisfied'){echo 'checked';}?>>
                    <label class="selt " style="float:left; margin-bottom:3px; margin-right: 20px;   ">Extremely Dissatisfied</label>
                    
                    <input type="radio" value="dissatisfied" name="hfa_overall" style="float:left; width:20px !important; margin-right:5px;" <?php if($feedback['host_overall']=='dissatisfied'){echo 'checked';}?>>
                    <label class="selttwo " style="float:left;  margin-bottom:3px;margin-right: 20px;  ">Dissatisfied</label>
                    
                    <input type="radio" value="satisfied" name="hfa_overall" style="float:left;width:20px !important; margin-right:5px;" <?php if($feedback['host_overall']=='satisfied'){echo 'checked';}?>>
                    <label class="selt " style="float:left; margin-bottom:3px; margin-right: 20px;   ">Satisfied/ Neutral </label>
                    
                    <input type="radio" value="happy" name="hfa_overall" style="float:left; width:20px !important; margin-right:5px;" <?php if($feedback['host_overall']=='happy'){echo 'checked';}?>>
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
                        <textarea id="testimonial" value="" name="testimonial" class="full_input fuul_input"><?=$feedback['testimonials']?></textarea>
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
                        <textarea id="comments" value="" name="comments" class="full_input fuul_input"><?=$feedback['comments']?></textarea>
                        </span>
            </div>            
            
            
    </div>
</div>
<div class="hfa1_home_right"></div>

</fieldset>
</fieldset>


</form>
</div>
</div>


</div>