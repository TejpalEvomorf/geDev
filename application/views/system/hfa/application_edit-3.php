<link type='text/css'  href="https://fonts.googleapis.com/icon?family=Material+Icons"  rel="stylesheet"> 
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
//see($formThree);
$familyMembers=$formThree['family_members'];
$fmTitle=$fmFname=$fmLname='';
if($formOne['title']!=0)
		$fmTitle=$formOne['title'];
$fmFname=$formOne['fname'];
$fmLname=$formOne['lname'];
$fmMobile=$formOne['mobile'];

$datePickerDobSettings=datePickerDobSettings();
//see($formThree);
?>
<div class="wFormContainer new_forms add-hostfamily-application dd-hostfamily-applicatio3" id="add-hostfamily-application-2">

<legend class="headingHostForm">Host Family Application Form
<span class="hand-written">All fields with red asterick<span class="reqField"> * </span>are mandatory</span></legend>

<div style="background:none;" class="">
  <div class="wForm" id="tfa_0-WRPR" dir="ltr">
  
<form method="post" action="" class="hintsBelow labelsAbove" id="host_family_application_threeForm">
<input type="hidden" name="id" value="<?=$formOne['id']?>" />

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

<?php for($x=1;$x<=9;$x++){  ?>
<fieldset class="hfa1_top_block_bedrooms hfa_family_member_details" id="hfa_family_member_details_<?php echo $x;?>" <?php if($familyMembers<$x){?>style="display:none;"<?php } ?>>

<div class="hfa-member-heading-cont overflow-del-ex">
<h2><?php if($x==1) echo 'PRIMARY APPLICANT'; else echo 'SECONDARY APPLICANT'; ?> DETAILS (Member <?php echo $x;?>) </h2>	<?php if($x!=1) {?>	
   
   <span class="famember-delete hfa-fathree">
    <i class="font16 material-icons">delete</i>
    <input type="button" data-id="<?= @$formTwo['bathroomDetails'][$x-1]['id']  ?>" value="Delete" onclick="deletehfadetail(<?= @$formThree['memberDetails'][$x-1]['id']  ?>,'member',<?= @$formThree['memberDetails'][$x-1]['application_id']  ?>,<?= @count($formThree['memberDetails'])?>);"  class="hfamember">
    </span>
   
   <?php if($x<=$familyMembers){?>

    <div class="btn-group dropdown hfa-faswap">
                <button class="btn" data-toggle="dropdown">
                    <i class="swap-orange material-icons">swap_vert</i>
                    <span class="swap-orange">SWAP</span>
                </button>
                <ul class="dropdown-menu" role="menu">
						<?php for($xSwap=1;$xSwap<=$familyMembers;$xSwap++){
                                    if($x==$xSwap){continue;}
                                    $xSwapMemberId=$formThree['memberDetails'][$x-1]['id'];
                        ?>
                                    <li><a href="<?=site_url()?>hfa/swapFamilyMember/<?=$xSwapMemberId.'/'.$xSwap?>">With member <?=$xSwap?><?php if($xSwap=='1'){echo '(make primary)';}?></a></li>
                        <?php } ?> 
                </ul>
            </div>
    <?php } ?>
    
           

	<?php }?>
 </div>   
    
    
<div class="hfa1_home_left">		

<div class=" full_width_field">
				<span class="hfa1_app_onefourth">
				<label class="onefourth_label full_label" for="hfa1_family_title">Title</label>
				 <select name="hfa_family-<?=$x?>[title]" class="onefourth_input" id="hfa_family_title-<?=$x?>">
				<option value="">Select</option>
                <?php foreach($nameTitleList as $ntK=>$ntV){?>
	                <option value="<?=$ntK?>" <?php if(empty($formThree['memberDetails'])){if($fmTitle==$ntK && $x==1){echo 'selected="selected"';}}else{if(isset($formThree['memberDetails'][$x-1]) && $formThree['memberDetails'][$x-1]['title']==$ntK){echo 'selected="selected"';}}?>><?=$ntV?></option>
                <?php } ?>
				</select>
				</span>
              <span class="hfa1_app_onefofth">
			<label class="full_label" for="hfa_fname_family-<?=$x?>">First name <span class="reqField">*</span></label>
			<input type="text" class="full_input hfa_fname_family errorOnBlur" name="hfa_family-<?=$x?>[fname]" value="<?php  if(empty($formThree['memberDetails'])){if($x==1){echo $fmFname;}}else{if(isset($formThree['memberDetails'][$x-1])){echo $formThree['memberDetails'][$x-1]['fname'];}}?>" id="hfa_fname_family-<?=$x?>">
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="hfa_lname_family-<?=$x?>">Last name <span class="reqField">*</span></label>
			<input type="text" class="full_input hfa_lname_family errorOnBlur" name="hfa_family-<?=$x?>[lname]" value="<?php  if(empty($formThree['memberDetails'])){if($x==1){echo $fmLname;}}else{if(isset($formThree['memberDetails'][$x-1])){echo $formThree['memberDetails'][$x-1]['lname'];}}?>" id="hfa_lname_family-<?=$x?>">
			</span>
</div>

<div class="hfa1_unit_street_name full_width_field">
			<span class="hfa1_app_half margin_10">
			<label class="half_label full_label" for="hfa_dob_family-<?=$x?>">Date of birth <span class="reqField">*</span></label>
			<input style="float:left" type="text" data-sha3_id="<?php if(isset($formThree['memberDetails'][$x-1])){ echo $formThree['memberDetails'][$x-1]['id']; } ?>" class="<?php if(isset($formThree['memberDetails'][$x-1])) { echo 'age18Check'; }?> half_input date-of-birth3 date-icon hfa_dob_family errorOnBlur" name="hfa_family-<?=$x?>[dob]" value="<?php if(isset($formThree['memberDetails'][$x-1])){if($formThree['memberDetails'][$x-1]['dob']!='0000-00-00'){echo date('d/m/Y',strtotime($formThree['memberDetails'][$x-1]['dob']));}}?>" id="hfa_dob_family-<?=$x?>">
            <span id="hfaFamilyMember_dob_error-<?=$x?>" class="hfaFamilyMember_dob_error" style="float:left; clear:both; padding-left:0; margin-top: -6px;">Date format is wrong</span>
			</span>
			<span class="hfa1_app_half">
			<label class="half_label full_label" for="hfa_gender_family-<?=$x?>">Gender <span class="reqField">*</span></label>
            <select name="hfa_family-<?=$x?>[gender]" class="half_input hfa_gender_family errorOnBlur" id="">
            <option value="">Select</option>
            <?php foreach($genderList as $glK=>$glV){?>
            <option value="<?=$glK?>" <?php if(isset($formThree['memberDetails'][$x-1])){if($formThree['memberDetails'][$x-1]['gender']==$glK){echo 'selected="selected"';}}?>><?=$glV?></option>
            <?php } ?>
            </select>
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="hfa_lname_family-<?=$x?>">Contact number</label>
			<input type="text" class="full_input" name="hfa_family-<?=$x?>[contact_number]" value="<?php  
			if(empty($formThree['memberDetails'][$x-1]['contact_number'])){if($x==1){echo $fmMobile;}}else{if(isset($formThree['memberDetails'][$x-1])){echo $formThree['memberDetails'][$x-1]['contact_number'];}}?>" id="hfa_lname_family-<?=$x?>">
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="hfa_role_family<?=$x?>" class="full_label">Family role</label>
            <select data-id="<?= $x?>" class="full_input familyrole" name="hfa_family-<?=$x?>[role]" id="hfa_role_family<?=$x?>">
            <option value="">Select one</option>
            <?php foreach($family_role as $frK=>$frV){?>
	            <option  value="<?=$frK?>" <?php if(isset($formThree['memberDetails'][$x-1])){if($formThree['memberDetails'][$x-1]['role']==$frK){echo 'selected="selected"';}}?>><?=$frV?></option>
            <?php } ?>
            </select>
			</span>
			 <span class="full_width_field left_margin left_marginss" id="hfa_role_family_other-<?= $x ?>"  <?php if((isset($formThree['memberDetails'][$x-1]['role']) && $formThree['memberDetails'][$x-1]['role']!=17)  || $familyMembers<$x){?>style="display:none;"<?php } ?>  >
                <label   for="" class="full_label hidden_label">Other family role </label>
                <input type="text" id='other_role-<?= $x ?>'  name="hfa_family-<?=$x?>[other_role]" class="halfss_inputss errorOnBlur" value="<?php echo !empty($formThree['memberDetails'][$x-1]['other_role'] ) ? $formThree['memberDetails'][$x-1]['other_role']  :'' ?>"	/>	
				
</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="hfa1_occupation_family" class="full_label">Occupation</label>
			<input type="text" id="hfa_occupation_family-<?=$x?>" value=" <?php if(isset($formThree['memberDetails'][$x-1])){echo $formThree['memberDetails'][$x-1]['occu'];}?>" name="hfa_family-<?=$x?>[occu]" class="full_input">
			</span>
</div>


       

</div>

<div class="hfa1_home_right">
<div class=" full_width_field">
			<span class="hfa1_app_full smoke-yes">
			<label for="hfa_smoker_family-<?=$x?>" class="full_label">Does this person smoke? <span class="reqField">*</span></label>
            <select class="full_input hfa_smoker_family errorOnBlur" name="hfa_family-<?=$x?>[smoke]" id="hfa_smoker_family-<?=$x?>">
            <option value="">Select one</option>
           		 <?php foreach($smokingHabbits as $shK=>$shV){?>               
                	<option  value="<?=$shK?>" <?php if(isset($formThree['memberDetails'][$x-1])){if($formThree['memberDetails'][$x-1]['smoke']==$shK){echo 'selected="selected"';}}?>><?=$shV?></option>
                <?php } ?>
            </select>
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full smoke-yes">
			<label for="hfa_nation_family-<?=$x?>" class="full_label">Ethnicity</label>
            <select class="full_input" name="hfa_family-<?=$x?>[nation]" id="hfa_nation_family-<?=$x?>">
            <option value="">Select one</option>
            <?php foreach($nationList as $nlK=>$nlV){?>
            	<option  value="<?=$nlK?>" <?php if(isset($formThree['memberDetails'][$x-1])){if($formThree['memberDetails'][$x-1]['ethnicity']==$nlK){echo 'selected="selected"';}}?>><?=$nlV?></option>
          	<?php } ?>
            </select>
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full smoke-yes">
			<label class="full_label" for="hfa1_room_availability">How many languages does this family member speak? <span class="reqField">*</span></label>
				<select class="full_input hfa_family_member_language errorOnBlur" id="hfa_family_member_language-<?php echo $x;?>" name="hfa_family-<?=$x?>[languages]">
                <option value="">Select one</option>
                <option class=""  value="1" <?php if(isset($formThree['memberDetails'][$x-1])){if($formThree['memberDetails'][$x-1]['language']=="1"){echo 'selected="selected"';}}?>>1 language</option>
                <option class=""  value="2" <?php if(isset($formThree['memberDetails'][$x-1])){if($formThree['memberDetails'][$x-1]['language']=="2"){echo 'selected="selected"';}}?>>2 languages</option>
                <option class=""  value="3" <?php if(isset($formThree['memberDetails'][$x-1])){if($formThree['memberDetails'][$x-1]['language']=="3"){echo 'selected="selected"';}}?>>3 languages</option>
                <option class=""  value="4" <?php if(isset($formThree['memberDetails'][$x-1])){if($formThree['memberDetails'][$x-1]['language']=="4"){echo 'selected="selected"';}}?>>4 languages</option>
                <option class=""  value="5" <?php if(isset($formThree['memberDetails'][$x-1])){if($formThree['memberDetails'][$x-1]['language']=="5"){echo 'selected="selected"';}}?>>5 languages</option>
                </select>
			</span>
</div>

<?php 
//see($formThree['memberDetails']);
for($y=1;$y<=5;$y++){?>
    <div class=" margin_bottom_zero full_width_field left_margin hfa_family_member_language_details hfa_family_member_language_details_<?php echo $y;?>" <?php if(!isset($formThree['memberDetails'][$x-1]['languages'][$y-1])){?>style="display:none;"<?php } ?>>
                <span class="hfa1_app_halfs margin_10 smoke-yes smoke-yes11">
                <label class="full_label hidden_label" for="">Language <?php echo $y;?> <span class="reqField">*</span></label>
                <select data-id="<?= $y?>" name="hfa_family-<?=$x?>[languages-<?=$y?>][language]" class=" othersel halfs_input hfa_family_language errorOnBlur">
                <option value="">Select one</option>
                <?php foreach($languageList as $llK=>$llV){?>
	                <option class="" value="<?=$llK?>" <?php if(isset($formThree['memberDetails'][$x-1]['languages'][$y-1]) && $formThree['memberDetails'][$x-1]['languages'][$y-1]['language']==$llK){?>selected="selected"<?php } ?>><?=$llV?></option>
                <?php } ?>
                </select>
				
                </span>
				
                <span class="hfa1_app_halfs margin_10 smoke-yes smoke-yes11">
                <label class="full_label hidden_label" for="">Proficiency</label>
                <select id="" name="hfa_family-<?=$x?>[languages-<?=$y?>][prof]" class="halfs_input">
                <option value="">Select one</option>
                <?php foreach($languagePrificiencyList as $lpK=>$lpV){?>
	                <option value="<?=$lpK?>" <?php if(isset($formThree['memberDetails'][$x-1]['languages'][$y-1]) && $formThree['memberDetails'][$x-1]['languages'][$y-1]['prof']==$lpK){?>selected="selected"<?php } ?>><?=$lpV?></option>
                <?php } ?>
                </select>
                </span>  
                
           <span class="full_width_field" id="olang-<?= $y ?>" <?php if(empty($formThree['memberDetails'][$x-1]['languages'][$y-1]['other_language'])) { ?> style="display:none;"  <?php }  ?>>
                <label  for="" class="full_label hidden_label">Other language </label>
                <input type="text" id='lang-<?= $y ?>'  name="hfa_family-<?=$x?>[languages-<?=$y?>][other_language]" class="halfss_inputss errorOnBlur" value="<?php echo !empty($formThree['memberDetails'][$x-1]['languages'][$y-1]['other_language'] ) ? $formThree['memberDetails'][$x-1]['languages'][$y-1]['other_language'] :'' ?>"	>	
				
</span>
                          
    </div>
<?php } ?>
	
    <div class="wwccWrapperHfa">
	<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="" class="full_label">Do you have the "Working with Children" (WWCC) check completed? <span class="reqField">*</span></label>
				<select id="hfa_working_children-<?php echo $x;?>" name="hfa_family-<?=$x?>[wwcc]" class="full_input hfa_working_children errorOnBlur">
                <option value="">Select one</option>
                <option value="1" id="" class="" <?php if(isset($formThree['memberDetails'][$x-1])){if($formThree['memberDetails'][$x-1]['wwcc']=="1"){echo 'selected="selected"';}}?>>Yes</option>
                <option value="0" class="" <?php if(isset($formThree['memberDetails'][$x-1])){if($formThree['memberDetails'][$x-1]['wwcc']=="0"){echo 'selected="selected"';}}?>>No</option>
                </select>
			</span>
</div>
    <div  class=" full_width_field left_margin" id="type_wwcc_clearance_<?php echo $x;?>" <?php if(!isset($formThree['memberDetails'][$x-1])){?>style="margin-bottom:3px; display:none;"<?php }else{if($formThree['memberDetails'][$x-1]['wwcc']!="1"){?>style="margin-bottom:3px; display:none;"<?php }else{?>style="margin-bottom:3px;"<?php }}?>>
			<span class="hfa1_app_full smoke-yes lolo">
			<label for="" class="full_label hidden_label">Have you received clearance? <span class="reqField">*</span></label>
            <select id="hfa_type_wwcc_clearance-<?php echo $x;?>" name="hfa_family-<?=$x?>[wwcc_clear]" class="full_input_select hfa_type_wwcc_clearance errorOnBlur">
            <option value="">Select one</option>
            <option value="1" class="" <?php if(isset($formThree['memberDetails'][$x-1])){if($formThree['memberDetails'][$x-1]['wwcc_clearence']=="1"){echo 'selected="selected"';}}?>>Yes</option>
            <option value="0" class="" <?php if(isset($formThree['memberDetails'][$x-1])){if($formThree['memberDetails'][$x-1]['wwcc_clearence']=="0"){echo 'selected="selected"';}}?>>No</option>
            </select>
			</span>
</div>
	
    <div  <?php if(!isset($formThree['memberDetails'][$x-1])){?>style="display:none;"<?php }else{if($formThree['memberDetails'][$x-1]['wwcc_clearence']!="0"){?>style="display:none;"<?php }}?> id="clearance_non_availability_<?php echo $x;?>" class=" full_width_field left_margin">
			<span class="hfa1_app_full smoke-yes lolol">
			<label class="full_label hidden_label" for="hfa1_type_wwcc_application_number">Provide application no.</label>
			<input type="text" class="full_inputss" name="hfa_family-<?=$x?>[wwcc_appli_num]" value="<?php if(isset($formThree['memberDetails'][$x-1])){echo $formThree['memberDetails'][$x-1]['wwcc_application_no'];}?>" id="hfa1_type_wwcc_application_number">
			</span>
    </div>
    
    
	<div  <?php if(!isset($formThree['memberDetails'][$x-1])){?>style="display:none;"<?php }else{if($formThree['memberDetails'][$x-1]['wwcc_clearence']!="1"){?>style="display:none;"<?php }}?> id="clearance_availability_<?php echo $x;?>" class=" full_width_field left_margin">
			<span class="hfa1_app_halfs margin_10 smoke-yes lolol">
			<label class="full_label hidden_label" for="hfa1_type_wwcc_clearance_number">Clearance no.</label>
			<input type="text" class="halfs_input" name="hfa_family-<?=$x?>[wwcc_clear_num]" value="<?php if(isset($formThree['memberDetails'][$x-1])){echo $formThree['memberDetails'][$x-1]['wwcc_clearence_no'];}?>" id="hfa1_type_wwcc_clearance_number">
			</span>
            <span class="hfa1_app_halfs smoke-yes lolol">
			<label class="full_label hidden_label" for="">Expiry date</label>
			<input type="text" class="halfs_input date-icon hfa_wwcc_expiry" name="hfa_family-<?=$x?>[wwcc_clear_expiry]" value="<?php if(isset($formThree['memberDetails'][$x-1])){if($formThree['memberDetails'][$x-1]['wwcc_expiry']!="0000-00-00"){echo date('d/m/Y',strtotime($formThree['memberDetails'][$x-1]['wwcc_expiry']));}}?>"   readonly="readonly">
			</span>
            <span class="hfa1_app_full smoke-yes lolol">
			<label style="width:260px;" class="wwcc-field full_label hidden_label" for="hfa1_type_wwcc_photo">Upload a scanned copy of the WWCC for this person</label>
			<input type="button" class="choose-btn full_input_select" name="" value="Choose file" id="hfa_wwcc_file_btn-<?=$x?>" onclick="$('#hfa_wwcc_file-<?=$x?>').trigger('click');" <?php if(isset($formThree['memberDetails'][$x-1])){if($formThree['memberDetails'][$x-1]['wwcc_file']!=""){?>style="display:none;"<?php }}?>>
            <input type="file" id="hfa_wwcc_file-<?=$x?>" name="hfa_family-<?=$x?>[wwcc_file]" class="hfa_wwcc_file" style="display:none;">
            <input type="hidden" name="hfa_family-<?=$x?>[wwcc_file_update]" value="<?php if(isset($formThree['memberDetails'][$x-1]) && $formThree['memberDetails'][$x-1]['wwcc_file']!=''){?>0<?php }else{echo 1;} ?>" id="hfa_wwcc_file_update-<?=$x?>" />
             
			<?php if(isset($formThree['memberDetails'][$x-1]) && $formThree['memberDetails'][$x-1]['wwcc_file']!=''){?>
            <input type="hidden" name="hfa_family-<?=$x?>[wwcc_file_name_update]" value="<?=$formThree['memberDetails'][$x-1]['wwcc_file']?>" id="hfa_wwcc_file_name_update-<?=$x?>" />
           	<!--<a class="hfa_use_same_file" id="hfa_use_same_file-<?=$x?>" href="javascript:void(0);" style="display:none;">Use the same file</a>-->
            <?php } ?>
			
            </span>
            <span id="hfa_wwcc_file_name-<?=$x?>" class="hfa_wwcc_file_name" <?php if(isset($formThree['memberDetails'][$x-1])){if($formThree['memberDetails'][$x-1]['wwcc_file']==""){?>style="display:none;float:left;width:100%;"<?php }}else{?>style="display:none;float:left;width:100%;"<?php }?>>
            	<p id="hfa_wwcc_file_name_text-<?=$x?>" style="display:none;" class="hfa_wwcc_file_name_text"></p>
                
					<?php if(isset($formThree['memberDetails'][$x-1]) && $formThree['memberDetails'][$x-1]['wwcc_file']!='')
								{
                					echo '<p class="hfa_wwcc_file_name_text_edit" id="hfa_wwcc_file_name_text_edit-'.$x.'">';
										echo '<a href="'.static_url().'uploads/hfa/wwcc/'.$formThree['memberDetails'][$x-1]['wwcc_file'].'" target="_blank">Preview file</a>';
									echo "</p>";
								}
						?>
            	<a href="javascript:void(0);" id="hfa_upload_diff_file-<?=$x?>" class="hfa_upload_diff_file_edit">Upload different file</a>
            </span>
            
            <?php if(isset($formThree['memberDetails'][$x-1]) && $formThree['memberDetails'][$x-1]['wwcc_file']!=''){?>
           	<a class="hfa_use_same_file" id="hfa_use_same_file-<?=$x?>" href="javascript:void(0);" style="display:none;">Use the same file</a>
            <?php } ?>
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
                <option value="1" id="" class="" <?php if($formThree['pets']=="1"){?>selected="selected"<?php }?>>Yes</option>
                <option value="0" id="" class="" <?php if($formThree['pets']=="0"){?>selected="selected"<?php }?>>No</option>
				</select>
			</span>
</div>

<div class=" full_width_field" <?php if($formThree['pets']==0){?>style="display:none;"<?php }?> id="what_pets_lives">
			<span class="hfa1_app_full" style="width: 55%;">
			<label class="full_label hidden_label" for="hfa1_what_pet">What pets?</label>
			<input type="checkbox" style="float:left;width:20px !important; margin-right:5px;" name="hfa_pet[dog]" value="1" <?php if($formThree['pet_dog']==1){?>checked="checked"<?php }?>>
            <label style="float: left; margin-right: 50px; margin-bottom: 5px;" for="" class="selt wtpt">Dog</label>
            <input type="checkbox" style="float:left; width:20px !important; margin-right:5px;" name="hfa_pet[bird]" value="1" <?php if($formThree['pet_bird']==1){?>checked="checked"<?php }?>>
            <label style="float: left; margin-bottom: 5px; margin-right: 48px;" for="" class="selt wtpt">Bird</label>
            <input type="checkbox" style="float:left; width:20px !important; margin-right:5px;" name="hfa_pet[cat]" value="1" <?php if($formThree['pet_cat']==1){?>checked="checked"<?php }?>>
            <label style="float: left; margin-bottom: 5px; margin-right: 54px;" for="" class="selt wtpt">Cat</label>
            <input type="checkbox" class="hfa_checkbox_input " style="float:left; width:20px !important; margin-right:5px;" name="hfa_pet[other]" value="1"  id="pet_other" <?php if($formThree['pet_other']==1){?>checked="checked"<?php }?>>
            <label style="float: left; margin-right: 35px; margin-bottom: 5px;" for="" class="selt wtpt"  name="hfa_pet[other]">Other</label>
			</span>
</div>

<div class=" full_width_field left_margin" id="type_pet" <?php if($formThree['pet_other']!=1){?>style="display:none;"<?php }?>>
			<span class="hfa1_app_full">
			<label for="hfa1_type_pet" class="full_label hidden_label">Other pets <span class="reqField">*</span></label>
			<input type="text" id="hfa_other_pet_val" value="<?=$formThree['pet_other_val']?>" name="hfa_pet[other_val]" class="full_inputss errorOnBlur">
			</span>
</div>
     
     <div class=" full_width_field"  <?php if($formThree['pets']==0){?>style="display:none;"<?php }?> id="pets_lives">
			<span class="hfa1_app_full">
			<label for="hfa_pet_in" class="full_label">Do the pets live inside the house?</label>
				<select id="hfa_pet_in" name="hfa_pet_in" class="full_input">
                <option value="">Select one</option>
                <option value="1" id="" class="" <?php if($formThree['pet_inside']=="1"){?>selected="selected"<?php }?>>Yes</option>
                <option value="0" class="" <?php if($formThree['pet_inside']=="0"){?>selected="selected"<?php }?>>No</option>
                </select>
			</span>
	</div> 

</div>


<div class="hfa1_home_right">
	<div class=" full_width_field"  <?php if($formThree['pets']==0){?>style="display:none;"<?php }?> id="pet_desc">
                <span class="hfa1_app_full">
                <label for="hfa_family_desc" class="full_label">Pet description</label>
                <textarea id="hfa_family_desc" value="" name="hfa_pet_desc" style="height:188px;padding:5px 10px;"><?=$formThree['pet_desc']?></textarea>
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
                <option class="" id="" value="1" <?php if($formThree['insurance']=="1"){?>selected="selected"<?php }?>>Yes</option>
                <option class="" id="" value="0" <?php if($formThree['insurance']=="0"){?>selected="selected"<?php }?>>No</option>
				</select>
			</span>
</div>

<div id="type_insurance_info" <?php if($formThree['insurance']=="1"){?>style="display:none; float:left;"<?php } ?>>
<p style="float:left; margin-bottom:0;"><a target="_blank" href="http://www.homestayhostinsuranceplus.com">Click here</a> to know more or to apply for Public Liability Insurance</p>
</div>

<div <?php if($formThree['insurance']!="1"){?>style="display: none;"<?php } ?> id="type_insurance" class=" full_width_field left_margin">
			<span class="hfa1_app_full">
			<label class="full_label hidden_label" for="hfa1_insurance_provider">Insurance provider</label>
			<input type="text" class="full_inputss" name="hfa_insurance_provider" value="<?=$formThree['ins_provider']?>" id="hfa1_insurance_provider">
			</span>
            <span class="hfa1_app_halfs margin_10">
			<label for="hfa1_type_policy_number" class="full_label hidden_label">Policy no.</label>
			<input type="text" id="hfa1_type_policy_number" value="<?=$formThree['ins_policy_no']?>" name="hfa_policy_number" class="halfs_input">
			</span>
            <span class="hfa1_app_halfs">
			<label for="hfa1_type_wwcc_policy_expiry" class="full_label hidden_label">Expiry date</label>
			<input type="text" id="hfa1_type_wwcc_policy_expiry" value="<?php if(isset($formThree['ins_expiry'])){if($formThree['ins_expiry']!='0000-00-00'){echo date('d/m/Y',strtotime($formThree['ins_expiry']));}}?>" name="hfa_policy_expiry" class="halfs_input date-icon hfa_policy_expiry"   readonly="readonly">
			</span>
            
            <!--PL file upload-->
            <span class="hfa1_app_full">
			<label style="width:260px;" class="wwcc-field full_label hidden_label" for="hfa1_type_wwcc_photo">Upload a scanned copy of the Public Liability Insurance</label>
			<input type="button" class="choose-btn full_input_select" name="" value="Choose file" id="hfa_ins_file_btn" onclick="$('#hfa_ins_file').trigger('click');" <?php if($formThree['ins_file']!=""){?>style="display:none;"<?php }?>>
            <input type="file" id="hfa_ins_file" name="hfa_ins_file" class="hfa_ins_file" style="display:none;">
            <input type="hidden" name="hfa_ins_file_update" value="<?php if($formThree['ins_file']!=''){?>0<?php }else{echo 1;} ?>" id="hfa_ins_file_update" />
             
			<?php if($formThree['ins_file']!=''){?>
            <input type="hidden" name="hfa_ins_file_name_update" value="<?=$formThree['ins_file']?>" id="hfa_ins_file_name_update" />
           	<?php } ?>
			
            </span>
            
            <span id="hfa_ins_file_name" class="hfa_wwcc_file_name" <?php if($formThree['ins_file']==""){?>style="display:none;float:left;width:100%;"<?php }?>>
            	<p id="hfa_ins_file_name_text" style="display:none;" class="hfa_wwcc_file_name_text"></p>
                
					<?php if($formThree['ins_file']!='')
								{
                					echo '<p class="hfa_ins_file_name_text_edit" id="hfa_ins_file_name_text_edit">';
										echo '<a href="'.static_url().'uploads/hfa/ins/'.$formThree['ins_file'].'" target="_blank">Preview file</a>';
									echo "</p>";
								}
						?>
            	<a href="javascript:void(0);" id="hfa_upload_diff_file_ins" class="hfa_upload_diff_file_edit_ins" style=" clear:both; ">Upload different file</a>
            </span>
            
            <?php if($formThree['ins_file']!=''){?>
           	<a class="hfa_use_same_file_ins" id="hfa_use_same_file_ins" href="javascript:void(0);" style="display:none; clear:both;">Use the same file</a>
            <?php } ?>
            
            <!--PL file upload-->
            
            <span class="hfa1_app_full" style="margin-top:10px;">
			<label class="full_label hidden_label" for="hfa1_type_Liability_insurance" style="width:200px; margin-top:10px;">Does it provide $20 million Public Liability cover?</label>
            <select class="full_input_select" name="hfa_liability_insurance" id="hfa_Liability_insurance">
            <option value="">Select one</option>
            <option class="" id=" " value="1" <?php if($formThree['20_million']=="1"){?>selected="selected"<?php }?>>Yes</option>
            <option class="" value="0" <?php if($formThree['20_million']=="0"){?>selected="selected"<?php }?>>No</option>
            </select>
			</span>
</div>
      

</div>


<div class="hfa1_home_right">

<div class=" full_width_field" style="" id="content-insurance">
			<span class="hfa1_app_full">
			<label for="hfa1_content_insurance" class="full_label">Do you have Home Contents insurance?</label>
				<select id="hfa_content_insurance" name="hfa_content_insurance" class="full_input">
                <option value="">Select one</option>
                <option value="1" id=" " class="" <?php if($formThree['ins_content']=="1"){?>selected="selected"<?php }?>>Yes</option>
                <option value="0" class="" <?php if($formThree['ins_content']=="0"){?>selected="selected"<?php }?>>No</option>
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
                	<option  value="<?=$rlK?>" <?php if($formThree['main_religion']==$rlK){?>selected="selected"<?php }?>><?=$rlV?></option>
                <?php } ?>
                <option  value="0" <?php if($formThree['main_religion']=="0"){?>selected="selected"<?php }?>>Other</option>
				</select>
			</span>
</div>

<div class=" full_width_field left_margin" id="religion_other" <?php if($formThree['main_religion']!="0"){?>style="display:none;"<?php }?>>
			<span class="hfa1_app_full">
			<label for="hfa1_type_pet" class="full_label hidden_label">Other religion <span class="reqField">*</span></label>
			<input type="text" id="hfa_religion_other" value="<?=$formThree['main_religion_other']?>" name="hfa_religion_other" class="full_inputss errorOnBlur">
			</span>
</div>


<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="hfa1_international_student" class="full_label">Have you hosted international students in the past?</label>
				<select id="hfa_international_student" name="hfa_international_student" class="full_input">
                <option value="">Select one</option>
               <option  value="0" <?php if($formThree['hosted_international_in_past']=="0"){?>selected="selected"<?php }?>>No</option>
              <option  value="1" <?php if($formThree['hosted_international_in_past']=="1"){?>selected="selected"<?php }?>>Yes</option>
                </select>
			</span>
</div>

<div class=" full_width_field left_margin" id="international_student" <?php if($formThree['hosted_international_in_past']!="1"){?>style="display:none;"<?php }?>>
			<span class="hfa1_app_full">
			<label for="hfa_exp" class="full_label hidden_label">What experience do you have as a homestay family?</label>
			<textarea id="hfa_exp" value="" name="hfa_exp" class="full_textarea"><?=$formThree['homestay_exp']?></textarea>
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="hfa_family_desc" class="full_label">Please describe your family</label>
            <p>Be sure to mention pastime and interests, hobbies, likes and dislikes. Any information here will be shared with your allocated placement and will help them understand your family and the experience they can look forward to. </p>
			<textarea id="hfa_family_desc" value="" name="hfa_family_desc" class="full_textareas"><?=$formThree['family_desc']?></textarea>
			</span>
</div>
</fieldset>
</fieldset>


<fieldset id="tfa_12" class="section column">
<fieldset id="" class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new">

<h3>Bank Account Details <b style="font-weight:400; color:hsl(146, 62%, 29%);">(for receiving payments)</b></h3>

<div class="hfa1_home_left">		

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="">Bank name</label>
			<input type="text" class="full_input" name="hfa_bank" value="<?php if(!empty($formThree['bankDetails'])){echo $formThree['bankDetails']['bank_name'];}?>" id="">
			</span>
</div>


<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="">Account name</label>
			<input type="text" class="full_input" name="hfa_account_name" value="<?php if(!empty($formThree['bankDetails'])){echo $formThree['bankDetails']['acc_name'];}?>" id="">
			</span>
</div>
      

</div>


<div class="hfa1_home_right">

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="">BSB</label>
			<input type="text" class="full_input" name="hfa_bsb" value="<?php if(!empty($formThree['bankDetails'])){echo $formThree['bankDetails']['bsb'];}?>" id="">
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="">Account number</label>
			<input type="text" class="full_input" name="hfa_account_num" value="<?php if(!empty($formThree['bankDetails'])){echo $formThree['bankDetails']['acc_no'];}?>" id="">
			</span>
</div>

</div>


</fieldset>
</fieldset>


<div class="end-options admin-end">
<input type="button" value="Update" id="hfaThreeSubmitBtn" class="btn-btn-medium hfa_submit">

<div id="hfaThreeProcess" style="display:none;" class="appFormProcess">
	<img src="<?=str_replace('http:','https:',static_url())?>img/submitload.gif"   />
</div>

<span id="hfaThreeError" style="display:none;color:#F00;">The form is incomplete. Fields outlined with red are required in the right format.</span>
</div>

</form>
</div>
</div>

</div>
<script src="<?=str_replace('http:','https:',static_url())?>system/plugins/bootbox/bootbox.js"></script>
<script type="text/javascript">

function deletehfadetail(bid,type,id,c)
{
	//alert(site_url());
	
	if(type=='member'){
		var msg="Are you sure you wish to delete this member ?";
		var surl=site_url()+'hfa/deletehfadetail'
		var sid='#'+type;
	}
		bootbox.dialog({
				message: msg,
				title: "Delete",
				buttons: {
					  danger: {
						label: "Delete",
						className: "hfaDelMember",
						callback: function() {

								$.ajax({
								  url:surl,
								  type:'POST',
								  data:{id:id,bid:bid,type:type,c:c},
								  success:function(data)
									  {
										  if(data=='LO')
											  redirectToLogin();
										  else
										  {
											  window.location.href=site_url()+'hfa/application/'+id+sid;		
											  
										  }
									  }
								  });

							}
						}
					}
				});
}
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
	
	/*function toggleAgeWrapper(id,dob) {
		var _dob = new Date(dob);
		var ageDifMs = Date.now() - _dob.getTime();
		var ageDate = new Date(ageDifMs);
		var result_age = Math.abs(ageDate.getUTCFullYear() - 1970);
		//console.log(id);
		
		if(result_age>=18) {
			$(".toggle_age_check_"+id).show();
		}
		else {
			$(".toggle_age_check_"+id).hide();
		}
	}
	//toggleAgeWrapper();
	
	$(".age18Check").each(function(i,e){
		var dob = $(e).val();
		var id = $(e).data("sha3_id");
		toggleAgeWrapper(id,dob);
	});
	
	$(".age18Check").change(function(){
		var from = $(this).val().split("/");
		var dob = new Date(from[2], from[1] - 1, from[0]);
		var id = $(this).data("sha3_id");
		toggleAgeWrapper(id,dob);
	});*/
	
	
	function toggleAgeWrapper(memberNo,dob) {
		//var _dob = new Date(dob);
		//var ageDifMs = Date.now() - _dob.getTime();
		//var ageDate = new Date(ageDifMs);
		//var result_age = Math.abs(ageDate.getUTCFullYear() - 1970);
		
		$.ajax({
			 url:site_url()+'hfa/exact_age_from_dob_jquery/'+dob, 
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
	
	$(".hfa_dob_family").each(function(i,e){
		var memberNo=$(this).parents('.hfa_family_member_details').attr('id');
		
		var from = $(this).val().split("/");
		//var dob = new Date(from[2], from[1] - 1, from[0]);
		var dob = from[2]+'-'+from[1]+'-'+from[0];
		toggleAgeWrapper(memberNo,dob);
	});
	
	$(".hfa_dob_family").change(function(){
		
		var memberNo=$(this).parents('.hfa_family_member_details').attr('id');
		
		var from = $(this).val().split("/");
		//var dob = from[2], from[1] - 1, from[0];
		var dob = from[2]+'-'+from[1]+'-'+from[0];
		toggleAgeWrapper(memberNo,dob);
	});
	
	
	$( '.hfa_dob_family' ).datepicker({
		  changeMonth: true,
		  changeYear: true,
		   yearRange: "<?=$datePickerDobSettings['year_from'].':'.$datePickerDobSettings['year_to']?>",
		  defaultDate:"<?=$datePickerDobSettings['default_date']?>",
		  dateFormat: 'dd/mm/yy',
		});
		
	$( '.hfa_wwcc_expiry, .hfa_policy_expiry' ).datepicker({
		  changeMonth: true,
		  changeYear: true,
		  yearRange: "c-5:c+20",
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
			   
				var id=$('input[name=id]').val();
							$.ajax({
							url:site_url()+'hfa/application_edit_three_submit',
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
									window.location.href=site_url()+'hfa/application/'+id;		
							}
					});
			}
		});


	var hashMessage=window.location.hash;
	if(hashMessage=='#memberSwapped')
		successBar('Member swapped successfully');
	window.location.hash = '';
			
	});
	

</script>