<?php
$nameTitleList=nameTitleList();
$stateList=stateList();
$geRefList=geRefList();
?>

<div id="add-hostfamily-application" class="wFormContainer new_forms add-hostfamily-application">
<legend class="headingHostForm">Host Family Application Form
<span class="hand-written">All fields with red asterick<span class="reqField"> * </span>are mandatory</span></legend>
  <div style="background:none;" class="">
  <div class="wForm" id="tfa_0-WRPR" dir="ltr">
  
<form method="post"  class="hintsBelow labelsAbove" id="host_family_application_oneForm">
<fieldset id="tfa_1" class="section column">
<fieldset id="" class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new">

<h3>Personal Details</h3>

<div class="hfa1_home_left">		

<div class=" full_width_field">
				<span class="hfa1_app_onefourth">
				<label class="onefourth_label full_label" for="hfa1_per_title">Title</label>
				 <select name="hfa_name_title" class="onefourth_input" id="hfa_name_title">
                    <option value="">Select</option>
                    <?php foreach($nameTitleList as $titleK=>$titleV){?>
                    	<option value="<?=$titleK?>"  <?php if($formOne['title']==$titleK){echo 'selected="selected"';}?>><?=$titleV?></option>
                    <?php } ?>
                </select>
				</span>
              <span class="hfa1_app_onefofth" style="width:191px;">
			<label class="full_label" for="hfa_fname">Primary contact first name <span class="reqField">*</span></label>
			<input type="text" class="full_input errorOnBlur" name="hfa_fname" value="<?=$formOne['fname']?>" id="hfa_fname">
			</span>
</div>
        
<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="hfa_lname">Primary contact last name <span class="reqField">*</span></label>
			<input type="text" class="full_input errorOnBlur" name="hfa_lname" value="<?=$formOne['lname']?>" id="hfa_lname">
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="hfa_email">Email <span class="reqField">*</span></label>
			<input style="float:left;" type="text" class="full_input errorOnBlur" name="hfa_email" value="<?=$formOne['email']?>" id="hfa_email">
            <span id="hfa_email_error" style="padding-left:0; clear:both; float:left;">Email format is wrong</span>
			</span>
            
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="hfa_number">Mobile number <span class="reqField">*</span></label>
			<input type="text" class="full_input errorOnBlur" name="hfa_number" value="<?=$formOne['mobile']?>" id="hfa_number">
			</span>
</div>

<div class="hfa1_unit_street_name full_width_field">
			<span class="hfa1_app_half margin_10">
			<label class="half_label full_label" for="hfa_home">Home phone</label>
			<input type="text" class="half_input errorOnBlur notReq" name="hfa_home_phone" value="<?=$formOne['home_phone']?>" id="hfa_home_phone">
			</span>
			<span class="hfa1_app_half">
			<label class="half_label full_label" for="hfa_work_phone">Work phone</label>
			<input type="text" class="half_input errorOnBlur notReq" name="hfa_work_phone" value="<?=$formOne['work_phone']?>" id="hfa_work_phone">
			</span>
		</div>

		<div style="margin-top: 12px;" class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label"  style="margin-bottom:5px;">Preferred way to contact</label>
			<input type="radio" style="float:left;width:20px !important; margin-right:5px;" name="hfa_contact_way" value="1" <?php if($formOne['contact_way']==1){echo 'checked="checked"';}?>>
            <label style="float:left; margin-right:34px; margin-bottom:13px; " for="" class="selt">Phone</label>
            <input type="radio" style="float:left; width:20px !important; margin-right:5px;" name="hfa_contact_way" value="2" <?php if($formOne['contact_way']==2){echo 'checked="checked"';}?>>
            <label style="float:left; margin-right:35px; margin-bottom:13px; " for="" class="selttwo">Email</label>
			</span>
		</div>

	<div class="full_width_field toggle_time_wrapper">
		<span class="hfa1_app_full">
		<label for="hfa_contact_time" class="full_label">Best time to call</label>
		<input type="text" id="hfa_contact_time" value="<?php if($formOne['contact_time']!='00:00:00'){echo date('H:i',strtotime($formOne['contact_time']));}?>" name="hfa_contact_time" class="full_input best-time">
		</span>
	</div>
    
     <div class=" full_width_field">
		<span class="hfa1_app_full">
			<label for="hfa_family_member" class="full_label">Number of members in family</label>
			<input type="text" id="hfa_family_member" value="<?php if($formOne['family_members']!=0){echo $formOne['family_members'];}?>" name="hfa_family_member" class="full_input">
		</span>
	</div>   
<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="hfa1_student_global" class="full_label">How did you hear about Global Experience?</label>
				<select class="full_input" id="hfa_ref" name="hfa_ref">
                <option value="">Select one</option>
               
               <?php foreach($geRefList as $refK=>$refV){?>
               <option value="<?=$refK?>" id="" class="" <?php if($formOne['ref']==$refK){echo 'selected="selected"';}?>><?=$refV?></option>
	              <?php } ?>
				</select>
			</span>
</div>
<div class=" full_width_field left_margin" id="hfa_ref_other_div" <?php if($formOne['ref']!=7){?>style="display:none;"<?php }?>>
			<span class="hfa1_app_full">
			<label for="" class="full_label hidden_label">Other referral, please specify</label>
			<input type="text" id="hfa_refff" value="<?=$formOne['ref_other']?>" name="hfa_ref_other" class="full_inputss">
			</span>
</div>
<div class=" full_width_field left_margin" id="hfa_ref_homestay_family_div" <?php if($formOne['ref']!=2){?>style="display:none;"<?php }?>>
			<span class="hfa1_app_full">
			<label for="" class="full_label hidden_label">Primary contact name</label>
			<input type="text" id="" value="<?=$formOne['ref_homestay_family']?>" name="hfa_ref_homestay_family" class="full_inputss">
			</span>
</div>
</div>


<div class="hfa1_home_right">





<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="hfa_street_address" class="full_label">Street address</label>
			<input type="text" id="hfa_street_address" value="<?=$formOne['street']?>" name="hfa_street_address" class="full_input">
			</span>
</div>

<div class="hfa1_unit_street_name full_width_field">
			<span class="hfa1_app_half margin_10">
			<label for="hfa_suburb" class="half_label full_label">Suburb <span class="reqField">*</span></label>
			<input type="text" style="margin-bottom:5px;" id="hfa_suburb" value="<?=$formOne['suburb']?>" name="hfa_suburb" class="half_input errorOnBlur">
			</span>
			<span class="hfa1_app_half">
			<label for="hfa_postcode" class="half_label full_label">Postcode <span class="reqField">*</span></label>
			<input type="text" style="margin-bottom:5px;" id="hfa_postcode" value="<?php if($formOne['postcode']!=0){echo $formOne['postcode'];}?>" name="hfa_postcode" class="half_input errorOnBlur">
			</span>
</div>


<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="hfa_state" class="full_label">State <span class="reqField">*</span></label>
            <select class="full_input errorOnBlur" id="hfa_state" name="hfa_state">
				<option value="">Select one</option>
                <?php foreach($stateList as $stateK=>$stateV){?>
                	<option value="<?=$stateK?>" <?php if($formOne['state']==$stateK){echo 'selected="selected"';}?>><?=$stateV?></option>
                <?php } ?>
                </select>
			</span>
</div>

<div class=" full_width_field" style="margin-top: 12px;">
			<span class="hfa1_app_full">
			<label style="margin-bottom:5px;" for="" class="full_label">Postal address</label>
			<input type="radio" value="0"  <?php if($formOne['postal_address']==0){echo 'checked="checked"';}?> name="hfa_postal_address" id="postal_address_same" style="float:left;width:20px !important; margin-right:5px;">
            <label class="selt seltlft" for="postal_address_same" style="float:left; width:91%; margin-bottom:3px; margin-top:1px;  ">Same as home address</label><br>
            <input type="radio" value="1" <?php if($formOne['postal_address']==1){echo 'checked="checked"';}?> name="hfa_postal_address" id="postal_address_provide" style="float:left; width:20px !important; margin-right:5px;">
            <label class="selttwo seltrt" for="postal_address_provide" style="float:left; margin-right:120px; margin-bottom:3px; margin-top:1px; ">Provide postal address</label>
			</span>
</div>

<div id="postal_address_provideDiv" <?php if($formOne['postal_address']==0){?>style="display:none"<?php } ?> class="full_width_field">
                  <div class=" full_width_field">
                      <span class="hfa1_app_full">
                      <label for="hfa_street_address" class="full_label">Street address</label>
                      <input type="text" id="hfa_street_address_postal" value="<?=$formOne['street_postal']?>" name="hfa_street_address_postal" class="full_input">
                      </span>
                  </div>
      
                  <div class="hfa1_unit_street_name full_width_field">
                              <span class="hfa1_app_half margin_10">
                              <label for="hfa_suburb" class="half_label full_label ">Suburb <span class="reqField">*</span></label>
                              <input type="text" style="margin-bottom:5px;" id="hfa_suburb_postal" value="<?=$formOne['suburb_postal']?>" name="hfa_suburb_postal" class="half_input errorOnBlur">
                              </span>
                              <span class="hfa1_app_half">
                              <label for="hfa_postcode" class="half_label full_label">Postcode <span class="reqField">*</span></label>
                              <input type="text" style="margin-bottom:5px;" id="hfa_postcode_postal" value="<?php if($formOne['postcode_postal']!=0){echo $formOne['postcode_postal'];}?>" name="hfa_postcode_postal" class="half_input errorOnBlur">
                              </span>
                  </div>
                  
                  
                  <div class=" full_width_field">
                              <span class="hfa1_app_full">
                              <label for="hfa_state" class="full_label">State <span class="reqField">*</span></label>
                              <select class="full_input errorOnBlur" id="hfa_state_postal" name="hfa_state_postal">
                                  <option value="">Select one</option>
                                  <?php foreach($stateList as $stateK=>$stateV){?>
                                      <option value="<?=$stateK?>"  <?php if($formOne['state_postal']==$stateK){echo 'selected="selected"';}?>><?=$stateV?></option>
                                  <?php } ?>
                                  </select>
                              </span>
                  </div>
            </div>
                            
                            <!--1111111111-->
                            
                            <fieldset style="padding-top:0;">
                            <h3 style="margin: 32px 0;">Emergency contact details</h3>
								 <div class=" full_width_field">
                                <span class="hfa1_app_full">
										<label class="full_label" for="sha_EC_name">Name</label>
		                                <input style="float:left;" type="text" class="full_input " name="hfa_EC_name" value="<?php if($formOne['EC_name']!=''){echo $formOne['EC_name'];}?>" id="hfa_EC_name">
                                </span>
                                
                            </div>
                            <div class=" full_width_field">
                                <span class="hfa1_app_full">
										<label class="full_label" for="sha_EC_relation">Your relationship to this person </label>
                                <input type="text" class="full_input " name="hfa_EC_relation" value="<?php if($formOne['EC_relation']!=''){echo $formOne['EC_relation'];}?>" id="hfa_EC_relation">
                                </span>
                            </div>
                            <div class=" full_width_field">
                                <span class="hfa1_app_full">
										<label class="full_label" for="sha_EC_phone">Phone number</label>
										<input type="text" class="full_input " name="hfa_EC_phone" value="<?php if($formOne['EC_phone']!=''){echo $formOne['EC_phone'];}?>" id="hfa_EC_phone">
									</span>
                            </div>
                            <div class=" full_width_field">
                                <span class="hfa1_app_full">
										<label class="full_label" for="sha_EC_email">Email</label>
										<input type="text" class="full_input " name="hfa_EC_email" value="<?php if($formOne['EC_email']!=''){echo $formOne['EC_email'];}?>" id="hfa_EC_email">
                                		<span style="float:left; clear:both; padding-left: 0;" id="hfa_EC_email_error">Email format is wrong</span>
									</span>
                            </div>

						</fieldset>
                            <!--1111111111-->
                      
        
</div>


</fieldset>
</fieldset>

<div class="end-options admin-end">
 <input type="hidden" name="id" value="<?=$formOne['id']?>" />
<input type="button" value="Update" id="hfaOneUpdate" class="btn-btn-medium hfa_submit">

<div id="hfaOneProcess" style="display:none;" class="appFormProcess">
	<img src="<?=str_replace('http:','https:',static_url())?>img/submitload.gif"   />
</div>

<span id="hfaOneError" style="display:none;color:#F00;">The form is incomplete. Fields outlined with red are required in the right format.</span>
</div>
</form>
</div>
</div>


</div>
<script type="text/javascript">
$(document).ready(function(){
	var preferred_way_current_value = $("input[name='hfa_contact_way']:checked").val();
	if(parseInt(preferred_way_current_value)==2) {
		$(".toggle_time_wrapper").hide();
	}
	
	$("input[name='hfa_contact_way']").click(function(){
		var current_value = $(this).val();
		if(parseInt(current_value)==2) {
			$(".toggle_time_wrapper").slideUp();
		}
		else {
			$(".toggle_time_wrapper").slideDown();
		}
	});	
	
	$('#hfa_contact_time').timepicker();
	
	$('#postal_address_same, #postal_address_provide').click(function(){
			if($('input[name=hfa_postal_address]:checked').val()==0)
				$('#postal_address_provideDiv').slideUp();
			else	
				$('#postal_address_provideDiv').slideDown();
		});
	
	$('#hfaOneUpdate').click(function(){
			
			var $hfaOneProcess=$('#hfaOneProcess');
			var $hfaOneSubmitBtn=$(this);
			
			var $hfa_name_title=$('#hfa_name_title');
			var $hfa_fname=$('#hfa_fname');
			var $hfa_lname=$('#hfa_lname');
			var $hfa_email=$('#hfa_email');
			var $hfa_number=$('#hfa_number');
			var $hfa_suburb=$('#hfa_suburb');
			var $hfa_postcode=$('#hfa_postcode');
			var $hfa_state=$('#hfa_state');
			var $tnc=$('#tnc');
			var $homestayGuidlines=$('#homestayGuidlines');
			
			var $hfa_home_phone=$('#hfa_home_phone');
			var $hfa_work_phone=$('#hfa_work_phone');
			var $hfa_suburb_postal=$('#hfa_suburb_postal');
			var $hfa_postcode_postal=$('#hfa_postcode_postal');
			var $hfa_state_postal=$('#hfa_state_postal');
			var $hfa_EC_email=$('#hfa_EC_email');
			
			var hfa_name_title=$hfa_name_title.val();
			var hfa_fname=$hfa_fname.val().trim();
			var hfa_lname=$hfa_lname.val().trim();
			var hfa_email=$hfa_email.val().trim();
			var hfa_number=$hfa_number.val().trim();
			var hfa_suburb=$hfa_suburb.val().trim();
			var hfa_postcode=$hfa_postcode.val().trim();
			var hfa_state=$hfa_state.val().trim();
			
			var hfa_home_phone=$hfa_home_phone.val().trim();
			var hfa_work_phone=$hfa_work_phone.val().trim();
			var hfa_suburb_postal=$hfa_suburb_postal.val().trim();
			var hfa_postcode_postal=$hfa_postcode_postal.val().trim();
			var hfa_state_postal=$hfa_state_postal.val();
			var hfa_postal_address=$('input[name=hfa_postal_address]:checked').val();
			var hfa_EC_email=$hfa_EC_email.val().trim();
			
			removeFieldError($hfa_fname);
			removeFieldError($hfa_lname);
			removeFieldError($hfa_email);
			removeFieldError($hfa_number);
			removeFieldError($hfa_suburb);
			removeFieldError($hfa_postcode);
			removeFieldError($hfa_state);	
			$('#tncError').hide()
			$('#homestayGuidlinesError').hide()
			$('#hfaOneError').hide();
			
			removeFieldError($hfa_home_phone);
			removeFieldError($hfa_work_phone);
			removeFieldError($hfa_suburb_postal);
			removeFieldError($hfa_postcode_postal);
			removeFieldError($hfa_state_postal);
			removeFieldError($hfa_EC_email);
			$('#hfa_email_error, #hfa_EC_email_error').hide();
			
			if(hfa_fname=='' || hfa_lname=='' || hfa_email=='' || !isValidEmailAddress(hfa_email) || hfa_number=='' /*|| isNaN(hfa_number)*/ || hfa_suburb=='' || hfa_postcode=='' || isNaN(hfa_postcode) || hfa_state=='' /*|| (hfa_home_phone!='' && isNaN(hfa_home_phone))*/ /*|| (hfa_work_phone!='' && isNaN(hfa_work_phone))*/ || (hfa_postal_address==1 && hfa_suburb_postal=='') || (hfa_postal_address==1 && (hfa_postcode_postal=='' || isNaN(hfa_postcode_postal))) || (hfa_postal_address==1 && hfa_state_postal=='')|| (hfa_EC_email != '' && !isValidEmailAddress(hfa_EC_email)))
			{
					if(hfa_fname=='')
						addFieldError($hfa_fname);
					else	
						removeFieldError($hfa_fname);

					if(hfa_lname=='')
						addFieldError($hfa_lname);
					else	
						removeFieldError($hfa_lname);
												
					if(hfa_email=='' || !isValidEmailAddress(hfa_email))
					{
						if(hfa_email!='' && !isValidEmailAddress(hfa_email))
							$('#hfa_email_error').show();
						addFieldError($hfa_email);
					}
					else	
						removeFieldError($hfa_email);
						
					if(hfa_number=='' /*|| isNaN(hfa_number)*/)
						addFieldError($hfa_number);
					else	
						removeFieldError($hfa_number);
					
					if(hfa_suburb=='')
						addFieldError($hfa_suburb);
					else	
						removeFieldError($hfa_suburb);
					
					if(hfa_postcode=='' || isNaN(hfa_postcode))
						addFieldError($hfa_postcode);
					else	
						removeFieldError($hfa_postcode);
					
					if(hfa_state=='')
						addFieldError($hfa_state);
					else	
						removeFieldError($hfa_state);	

					///	
					/*if(hfa_home_phone!='' && isNaN(hfa_home_phone))
						addFieldError($hfa_home_phone);
					else	
						removeFieldError($hfa_home_phone);	
					
					if(hfa_work_phone!='' && isNaN(hfa_work_phone))
						addFieldError($hfa_work_phone);
					else	
						removeFieldError($hfa_work_phone);*/
						
					if(hfa_postal_address==1 && hfa_suburb_postal=='')
						addFieldError($hfa_suburb_postal);
					else	
						removeFieldError($hfa_suburb_postal);
						
					if(hfa_postal_address==1 && (hfa_postcode_postal=='' || isNaN(hfa_postcode_postal)))
						addFieldError($hfa_postcode_postal);
					else	
						removeFieldError($hfa_postcode_postal);
						
					if(hfa_postal_address==1 && hfa_state_postal=='')
						addFieldError($hfa_state_postal);
					else	
						removeFieldError($hfa_state_postal);
				
					if(hfa_EC_email != '' && !isValidEmailAddress(hfa_EC_email))
					{
						$('#hfa_EC_email_error').show();
						addFieldError($hfa_EC_email);
					}
					else
						removeFieldError($hfa_EC_email);
						
			//$('#hfaOneError').show();
			scrollToDiv('#add-hostfamily-application');
			errorBar('All fields marked with red are required');
			}
			else
			{
				$hfaOneProcess.show();
				$hfaOneSubmitBtn.hide();
				
				var host_family_application_oneData=$('#host_family_application_oneForm').serialize();
				var id=$('input[name=id]').val();
				$.ajax({
						url:site_url()+'hfa/application_edit_one_submit',
						type:'POST',
						data:host_family_application_oneData,
						success:function(data)
							{
									//$hfaOneSubmitBtn.show();
									if(data=='duplicate-email')
									{
										scrollToDiv('#add-hostfamily-application');
										errorBar('Email id already used, use some other email id');
										addFieldError($hfa_email);
										$hfaOneSubmitBtn.show();
										$hfaOneProcess.hide();
									}
									else
										window.location.href=site_url()+'hfa/application/'+id;
							}
					});
			}
			
		});
		
	});

</script>