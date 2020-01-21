<?php
$dwellingTypeList=dwellingTypeList();
$floorTypeList=floorTypeList();
$roomTypeList=roomTypeList();
$genderList=genderList();
$nationList=nationList();
$floorsList=floorsList();
?>

<!--Success Pop Up STARTS-->
  <div class="modal fade successPop" id="hfa_successPopUpOne"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h2 class="modal-title"></h2>
							</div>
							<div class="modal-body">
								<img src="<?=str_replace('http:','https:',static_url())?>img/tick.png" />
								<h3>First Step of your Host Family application (Personal Details), has been submitted successfully.</h3>
								<p>We have sent you a link in your email. You can use that link to continue at the same step, in case you wish to complete the application later.</p>
                                <a href="javascript:void(0)" data-dismiss="modal">CONTINUE TO NEXT STEP</a>
							</div>
							<div class="modal-footer">
                            <span style="font-weight:bold; color:#1d7643; background:#eeeeee;">Step 1: Personal details (Complete) <img src="<?=str_replace('http:','https:',static_url())?>img/complete-tick.png" /></span>
                            <span>Step 2: Property details</span>
                            <span>Step 3: Family details</span>
                            <span>Step 4: Student preferences</span>
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div>
<!--Success Pop ENDS-->

<div class="wFormContainer new_forms add-hostfamily-application dd-hostfamily-applicatio2" id="add-hostfamily-application-2">

<legend class="headingHostForm">Host Family Application Form
<span class="hand-written">All fields with red asterick<span class="reqField"> * </span>are mandatory</span></legend>

<div style="background:none;" class="">
  <div class="wForm" id="tfa_0-WRPR" dir="ltr">
  
<form method="post" action="" class="hintsBelow labelsAbove" id="host_family_application_twoForm">
<input type="hidden" name="id" value="<?=$id?>" />
<fieldset id="tfa_4" class="section column">
<fieldset id="" class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new">

<h3>Dwelling type</h3>

<div class="hfa1_home_left">		

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="hfa_dwellingType" class="full_label">Dwelling Type</label>
				<select class="full_input" id="hfa_dwellingType" name="hfa_dwellingType">
                <option value="">Select one</option>
                <?php foreach($dwellingTypeList as $dtK=>$dtV) {?>
	                <option  value="<?=$dtK?>"><?=$dtV?></option>
                <?php } ?>
				</select>
			</span>
</div>
<div class=" full_width_field" id="flooring_select">
			<span class="hfa1_app_full">
			<label for="hfa1_floors" class="full_label">How many floors <span class="reqField">*</span></label>
				<select class="full_input" id="hfa_floors" name="hfa_floors">
                <option value="">Select one</option>
                <?php foreach($floorsList as $flK=>$flV){?>
	               	 <option class="floors" value="<?=$flK?>"><?=$flV?></option>
                 <?php } ?>
                </select>
			</span>
			<div class=" full_width_field">
			<span class="hfa1_app_full"> 
			<label for="hfa1_granny_flat" class="full_label">Do you have a Granny Flat<span class="reqField">*</span></label>
				<select class="full_input" name="granny_flat" id="granny_flat">
                <option value="">Select one</option>
                <option class="" value="0">No</option>
                <option class="" value="1">Yes</option>
                </select>
			</span>
</div>

<div class=" full_width_field" id="flooring_select">
			<span class="hfa1_app_full">
			<label for="hfa1_flooring_type" class="full_label">Main type of flooring</label>
				<select class="full_input" id="hfa_flooring_select" name="hfa_flooring_select">
                <option value="">Select one</option>
                <?php foreach($floorTypeList as $ftK=>$ftV){?>
	               	 <option class="" value="<?=$ftK?>"><?=$ftV?></option>
                 <?php } ?>
                </select>
			</span>
</div>

<div style="display:none;" id="type_flooring" class=" full_width_field left_margin">
			<span class="hfa1_app_full">
			<label class="full_label hidden_label" for="hfa_flooring_other">Other type of flooring <span class="reqField">*</span></label>
			<input type="text" class="full_inputss errorOnBlur" name="hfa_flooring_other" value="" id="hfa_flooring_other">
			</span>
</div>
        
<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="hfa1_internet_type" class="full_label">Is internet available to students in<br /> your home? </label>
				<select class="full_input" name="hfa_internet_to_students" id="hfa_internet_to_students">
                <option value="">Select one</option>
                <option class=""  value="0">No</option>
                <option class=""  value="1">Yes ($10/week will be payable directly to you by the student)</option>
                </select>
			</span>
</div>

<div class=" full_width_field left_margin" id="hfa_internet_to_students_type" style="display:none;">
			<span class="hfa1_app_full">
			<label for="hfa1_grany_flat" class="full_label hidden_label">What type of internet is it? <span class="reqField">*</span></label>
			<input type="radio" style="float:left;width:20px !important; margin-right:5px;" name="hfa_internet_to_students_type" value="1" checked="checked">
            <label style="float:left; margin-right:237px; margin-bottom:13px; " for="" class="selt">Wireless broadband</label>
            <input type="radio" style="float:left; width:20px !important; margin-right:5px;" name="hfa_internet_to_students_type" value="2"> 
            <label style="float:left; margin-right:245px; margin-bottom:13px; " for="" class="selttwo">Cable broadband</label>
			</span>
</div>
</div>
</div>
<div class="hfa1_home_right">
<div class=" full_width_field">
			<span class="hfa1_app_full"> 
			<label for="hfa1_smoke_type" class="full_label">Do you have a working smoke<br /> detector fitted in your home?</label>
				<select class="full_input" name="smoke_detector" id="">
                <option value="">Select one</option>
                <option class="" value="0">No</option>
                <option class="" value="1">Yes</option>
                </select>
			</span>
</div>
       





      <div class=" full_width_field">
      
      <label for="hfa1_facility" class="full_label">Facilities </label>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" id="facility_pool" value="1" name="hfa_facility_pool" class="hfa_checkbox_input ">
				<label for="facility_pool" class="hfa_facilities_pool_label selt">Swimming pool</label>                
	  </span>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" id="facility_tennis" value="1" name="hfa_facility_tennis" class="hfa_checkbox_input ">
				<label for="" class="hfa_facilities_tennis_label selt">Tennis court</label>                
	  </span>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" id="facility_piano" value="1" name="hfa_facility_piano" class="hfa_checkbox_input ">
				<label for="" class="hfa_facilities_piano_label selt">Piano</label>                
	  </span>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" id="facility_gym" value="1" name="hfa_facility_gym" class="hfa_checkbox_input ">
				<label for="" class="hfa_facilities_gym_label selt">Gym</label>                
	  </span>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" id="facility_disable" value="1" name="hfa_facility_disable" class="hfa_checkbox_input ">
				<label for="" class="hfa_facilities_disable_label selt">Disable access</label>                
	  </span>
      
      <span class="hfa1_app_full">	
				<input type="checkbox" id="facility_others" value="1" name="hfa_facility_other" class="hfa_checkbox_input ">
				<label for="" class="hfa_facilities_others selt">Other (please describe)</label>                
	  </span>
      
      </div>
      
      
      <div style="display:none;" id="type_facility" class=" full_width_field left_margin">
			<span class="hfa1_app_full">
			<label class="full_label hidden_label Other-facilities" for="hfa1_type_facility">Other facilities <span class="reqField">*</span></label>
			<input type="text" class="full_inputss errorOnBlur Other-facilities-in" name="hfa_facility_other_val" value="" id="hfa_facility_other_val">
			</span>
    </div>

   </div>                   
        
</div>


</fieldset>
</fieldset>

<div id="tfa_0-A" class="actions add_new_submission"><h4>PROPERTY DETAILS</h4></div>

<fieldset id="tfa_5" class="section column">
<fieldset id="" class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new">

<fieldset class="hfa1_top_block">
<h3>Bedrooms</h3>

<div class=" full_width_field" style="margin-top:2px;">
			<span class="hfa1_app_half">
			<label for="hfa1_per_bedroom" class="full_label">No. of bedrooms in the house <span class="reqField">*</span></label>
            <select class="full_input errorOnBlur" name="hfa_bedroom" id="hfa_bedroom_input"><option value="">Select one</option>
            <option class="" id="" value="1">1</option>
            <option class="" id="" value="2">2</option>
            <option class="" id="" value="3">3</option>
            <option class="" id="" value="4">4</option>
            <option class="" id="" value="5">5</option>
            <option class="" id="" value="6">6</option>
            <option class="" id="" value="7">7</option>
            <option class="" id="" value="8">8</option>
            <option class="" id="" value="9">9</option>
            </select>
			</span>
            
            <span class="hfa1_app_half" id="hfa_bedroom_avail_span" style="margin-left:60px; display:none;">
			<label for="hfa_bedroom_avail" class="full_label">No. of bedrooms available to student <span class="reqField">*</span></label>
            <select class="full_input errorOnBlur" name="hfa_bedroom_avail" id="hfa_bedroom_avail">
            </select>
			</span>
</div>

</fieldset>

<?php
for($x=1;$x<=9;$x++)
{
?>
<fieldset class="hfa1_top_block_bedrooms hfa_bedroom_avail_details" style="display:none;" id="hfa_bedroom_avail_details_<?php echo $x;?>">

<div class="hfa-member-heading-cont"><h2>STUDENT BEDROOM <?php echo $x;?></h2></div>

<div class="hfa1_home_left">		

<div class="hfa1_unit_street_name full_width_field">
			<span class="hfa1_app_half margin_10">
			<label for="hfa1_type_room" class="full_label">Type of room <span class="reqField">*</span></label>
			<select class="half_input room_type_select errorOnBlur" name="bedroom-<?=$x?>[room_select]" id="room_select-<?=$x?>">
            <option value="">Select one</option>
            <?php foreach($roomTypeList as $rtK=>$rtV){?>
	            <option  value="<?=$rtK?>"><?=$rtV?></option>
            <?php } ?>
            </select>
			</span>
			<span class="hfa1_app_half">
			<label for="room_flooring_select" class="full_label">Type of flooring <span class="reqField">*</span></label>
			<select class="half_input room_flooring_select errorOnBlur" name="bedroom-<?=$x?>[room_flooring_select]" id="room_flooring_select-<?php echo $x;?>">
            <option value="">Select one</option>
            <?php foreach($floorTypeList as $ftK=>$ftV){?>
	            <option value="<?=$ftK?>"><?=$ftV?></option>
            <?php } ?>
            </select>
			</span>
</div>

<div class=" full_width_field left_margin" id="bedroom_flooring_<?php echo $x;?>" style="display:none;">
			<span class="hfa1_app_full">
			<label  class="full_label hidden_label">Other type of flooring <span class="reqField">*</span></label>
			<input type="text" value="" name="bedroom-<?=$x?>[hfa_bed_flooring_other_val]" class="full_inputss hfa_bed_flooring_other_val errorOnBlur">
			</span>
</div>

<div class=" half_width_field">
			<span class="hfa1_app_half margin_10">
			<label for="hfa1_room_location" class="full_label">Room location <span class="reqField">*</span></label>
				<select class="half_input hfa_bedroom_floor student_room_location" name="bedroom-<?=$x?>[student_room]" id="student_room-<?=$x;?>" >
                <option value="" class="">Select one</option>
                  <?php foreach($floorsList as $flK=>$flV){?>
	               	 <option class="sha_location" style="display: none;" value="<?=$flK?>"><?=$flV?></option>
                 <?php } ?>
               
                
                <option class="location_granny_flat" value="g" style="display:none;">Granny Flat</option>

                </select>
			</span>
			<span class="hfa1_app_half ">
			<label class="full_label" for="hfa1_access_room">Access to the room</label>
				<select id="hfa_access_room-<?php echo $x;?>" name="bedroom-<?=$x?>[hfa_access_room]" class="half_input hfa_access_room">
                <option value="">Select one</option>
                <option value="0" id="" class="" <?php //if($formTwo['bedrooms_avail']>=$x){if($formTwo['bedroomDetails'][$x-1]['access']=="0"){echo 'selected="selected"';}}?>>Inside</option>
                <option value="1" id="" class="" <?php //if($formTwo['bedrooms_avail']>=$x){if($formTwo['bedroomDetails'][$x-1]['access']=="1"){echo 'selected="selected"';}}?>>Outside</option>
				</select>
			</span>
			
</div>

<div class=" full_width_field left_margin" id="access_room_outside_<?php echo $x;?>" style="display:none;">
			<span class="hfa1_app_full">
			<label for="hfa1_grany_flat" class="full_label hidden_label">Is it a granny flat? <span class="reqField">*</span></label>
			<input type="radio" style="float:left;width:20px !important; margin-right:5px;" name="bedroom-<?=$x?>[flat_grany]" value="1" checked="checked">
            <label style="float:left; margin-right:34px; margin-bottom:13px; " for="" class="selt">Yes</label>
            <input type="radio" style="float:left; width:20px !important; margin-right:5px;" name="bedroom-<?=$x?>[flat_grany]" value="0"> 
            <label style="float:left; margin-right:35px; margin-bottom:13px; " for="" class="selttwo">No</label>
			</span>
</div>
		
      
<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="hfa1_internal_ensuite">Internal ensuite</label>
				<select id="internal_ensuite" name="bedroom-<?=$x?>[internal_ensuite]" class="full_input">
                <option value="">Select one</option>
                <option value="1" id="" class="">Yes</option>
                <option value="0" id="" class="">No</option>
                </select>
			</span>
</div>
       

</div>

<div class="hfa1_home_right">

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="hfa_room_availability">Is this room available immediately? <span class="reqField">*</span></label>
				<select class="full_input hfa_room_availability errorOnBlur" name="bedroom-<?=$x?>[hfa_room_availability]" id="hfa_room_availability-<?php echo $x;?>">
                <option value="">Select one</option>
                <option class="" id="" value="1">Yes</option>
                <option class="" id="" value="0">No, please specify the next available date</option>
                </select>
			</span>
</div>

<div class=" full_width_field left_margin room_availability_1" id="room_availability_<?php echo $x;?>" style="display:none;">
			<span class="hfa1_app_halfs margin_10">
			<label for="hfa1_room_from_input" class="full_label hidden_label">From date <span class="reqField">*</span></label>
			<input type="text" id="hfa_room_avail_from-<?=$x?>" value="" name="bedroom-<?=$x?>[hfa_room_avail_from]" class="halfs_input date-icon hfa_room_avail_from errorOnBlur" readonly="readonly">
			</span>
            <span class="hfa1_app_halfs">
			<label for="hfa1_room_to_input" class="full_label hidden_label">To date</label>
			<input type="text" id="hfa_room_avail_to-<?=$x?>" value="" name="bedroom-<?=$x?>[hfa_room_avail_to]" class="halfs_input date-icon hfa_room_avail_to" readonly="readonly">
			</span>
            
            <div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="hfa1_hosting_student">Are you currently hosting a student in this room?</label>
				<select class="full_input hfa_hosting_student" name="bedroom-<?=$x?>[hfa_hosting_student]" id="hfa_hosting_student-<?php echo $x;?>">
                <option value="">Select one</option>
                <option class="" id="" value="0">No</option>
                <option class="" id="" value="1">Yes, please provide details below</option>
                </select>
			</span>
			</div>
            
            <div class=" full_width_field left_margin hosting_details_1" id="hosting_details_<?php echo $x;?>" style="display:none;">
			<span class="hfa1_app_halfs margin_10">
			<label for="hfa_room_date_leaving-<?=$x?>" class="full_label hidden_label ">Date leaving <span class="reqField">*</span></label>
			<input type="text" id="hfa_room_date_leaving-<?=$x?>" value="" name="bedroom-<?=$x?>[hfa_room_date_leaving]" class="halfs_input date-icon hfa_room_date_leaving errorOnBlur hfa_room_date_leaving-1" readonly="readonly">
			</span>
            <span class="hfa1_app_halfs">
			<label for="hfa1_hosting_details12_input" class="full_label hidden_label">Student age</label>
            <select class="halfs_input student_age-1" name="bedroom-<?=$x?>[student_age]" id="student_age-<?=$x?>">
            <option value="">Select one</option>
            <option class="" id="" value="0">Over 18</option>
            <option class="" id="" value="1">Under 18</option>
            </select>
			</span>
			<span class="hfa1_app_halfs margin_10">
			<label for="hfa1_hosting_details21_input" class="full_label hidden_label">Student gender</label>
			<select class="halfs_input stu-gen" name="bedroom-<?=$x?>[student_gender]" id="student_gender-<?=$x?>">
            <option value="">Select one</option>
            <option class="" id="" value="2">Female</option>
            <option class="" id="" value="1">Male</option>
            </select>
			</span>
            <span class="hfa1_app_halfs">
			<label for="hfa1_hosting_details22_input" class="full_label hidden_label">Nationality</label>
			<select class="halfs_input stu-gen" name="bedroom-<?=$x?>[student_nation]" id="student_nation-<?=$x?>">
            <option value="">Select one</option>
           <?php foreach($nationList as $nlK=>$nlV){?>
	            <option value="<?=$nlK?>"><?=$nlV?></option>
           <?php } ?>
            </select>
			</span>
			</div>
            
</div>

</div>


</fieldset>
<?php } ?>
<!-- HOST BEDROOMS -->
<?php
for($x=1;$x<=9;$x++)
{
?>
<fieldset class="hfa1_top_block_bedrooms hfa_bedroom_avail_details" style="display:none;" id="hfa_bedroom_location_<?php echo $x;?>">

<div class="hfa-member-heading-cont"><h2>HOST BEDROOM <?php echo $x;?></h2></div>

<div class="hfa1_home_left">		

<div class=" full_width_field">
			<span class="hfa1_app_full ">
			<label for="hfa1_room_location" class="full_label">Room location <span class="reqField">*</span></label>
				<select class="full_input hfa_bedroom_floor host_room_location" name="hbedroom-<?php echo $x;?>[host_room]" id="host_room-<?php echo $x;?>" >
                <option value="" class="">Select one</option>
                  <?php foreach($floorsList as $flK=>$flV){?>
	               	 <option class="sha_location" style="display: none;" value="<?=$flK?>" <?php if(!empty($formTwo['hostbedroomDetails'])){if($formTwo['hostbedroomDetails'][$x-1]['floor']==$flK){echo 'selected="selected"';}}else{}?>><?=$flV?></option>
                 <?php } ?>
               
                
                <option class="location_granny_flat" value="g" style="display:none;">Granny Flat</option>

                </select>
			</span>
</div>

       

</div>


</fieldset>
<?php } ?>


<!-- HOST -->
</fieldset>
</fieldset>



<fieldset class="section column" id="tfa_6">
<fieldset class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new" id="">

<fieldset class="hfa1_top_block">
<h3>Bathrooms</h3>

<div style="margin-top:2px;" class=" full_width_field">
			<span class="hfa1_app_half">
			<label class="full_label errorOnBlur" for="hfa_bathroom_input">No. of bathrooms in the house <span class="reqField">*</span></label>
            <select id="hfa_bathroom_input" name="hfa_bathroom_input" class="full_input errorOnBlur"><option value="">Select one</option>
            <option value="1" id="" class="">1</option>
            <option value="2" id="" class="">2</option>
            <option value="3" id="" class="">3</option>
            <option value="4" id="" class="">4</option>
            <option value="5" id="" class="">5</option>
            </select>
			</span>
</div>

</fieldset>

<?php for($x=1;$x<=5;$x++){
	?>
<fieldset class="hfa1_top_block_bedrooms hfa_bathroom_details" id="hfa_bathroom_details_<?php echo $x;?>" style="display:none;">

<div class="hfa-member-heading-cont"><h2>BATHROOM <?php echo $x;?></h2></div>

<div class="hfa1_home_left">		

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="hfa_bathroom_avail-<?=$x?>" class="full_label">Is it available to student? <span class="reqField">*</span></label>
				<select class="full_input errorOnBlur hfa_bathroom_avail" id="hfa_bathroom_avail-<?=$x?>" name="bathroom-<?=$x?>[hfa_bathroom_avail]">
                <option value="">Select one</option>
                <option class="" id="" value="1">Yes</option>
                <option class="" id="" value="0">No</option>
				</select>
			</span>
</div>
 <div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="hfa_bathroom_avail-<?=$x?>" class="full_label">Bathroom Location <span class="reqField">*</span></label>
				<select class="full_input hfa_bedroom_floor bathroom_location" id="bathroom_floor-<?=$x;?>" name="bathroom-<?=$x?>[bathroom_floor]">
                <option value="">Select one</option>
                <?php foreach($floorsList as $flK=>$flV){?>
	               	 <option class="sha_location" style="display: none;" value="<?=$flK?>"><?=$flV?></option>
                 <?php } ?>
                
                <option class="location_granny_flat" value="g" style="display:none;">Granny Flat</option>

                </select>
			</span>
</div>  


<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="hfa1_has_room" class="full_label">This bathroom has:</label>
            <input type="checkbox" style="float:left;width:20px !important; margin-right:5px;" name="bathroom-<?=$x?>[bathroomHas_toilet]" value="1">
            <label style="float:left; margin-right:34px; margin-bottom:13px; " for="" class="selt">Toilet</label>
            <input type="checkbox" style="float:left; width:20px !important; margin-right:5px;" name="bathroom-<?=$x?>[bathroomHas_shower]" value="1">
            <label style="float:left; margin-right:35px; margin-bottom:13px; " for="" class="selttwo">Shower</label>
            <input type="checkbox" style="float:left; width:20px !important; margin-right:5px;" name="bathroom-<?=$x?>[bathroomHas_bath]" value="1">
            <label style="float:left; margin-right:35px; margin-bottom:13px; " for="" class="selttwo">Bath</label>
			</span>
</div>
      

</div>

<div class="hfa1_home_right">

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="hfa_room_ensuite-<?php echo $x;?>" class="full_label">Is it ensuite?</label>
				<select id="hfa_room_ensuite-<?php echo $x;?>" name="bathroom-<?=$x?>[hfa_room_ensuite]" class="full_input hfa_room_ensuite">
                <option value="">Select one</option>
                <option value="1" id="" class="">Yes</option>
                <option value="0" id="" class="">No</option>
                </select>
			</span>
</div>

<div id="access_room_ensuite_<?php echo $x;?>" class=" full_width_field left_margin" style="display:none;">
            <span class="hfa1_app_full">
            <label for="" class="full_label">Bathroom location <span class="reqField">*</span></label>
            <input type="radio" value="1" name="bathroom-<?=$x?>[flat_grany_bathroom]" style="float:left; width:20px !important; margin-right:5px;" checked="checked">
            <label class="selttwo" for="" style="float:left; margin-right:35px; margin-top:1px; ">Internal (Inside the house)</label>
			</span>
            <span class="hfa1_app_full">
            <input type="radio" value="2" name="bathroom-<?=$x?>[flat_grany_bathroom]" style="float:left; width:20px !important; margin-right:5px;">
            <label class="selttwo" for="" style="float:left; margin-right:35px; margin-top:1px; ">External (Outside the house)</label>
			</span>
</div>

</div>


</fieldset>
<?php } ?>

</fieldset>
</fieldset>


<fieldset id="tfa_7" class="section column">
<fieldset id="" class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new">

<fieldset class="hfa1_top_block">
<h3>Laundry</h3>

<div style="margin-top:2px;" class=" full_width_field">
			<span class="hfa1_app_half">
			<label for="hfa1_laundry_available" class="full_label">Is the laundry available to the student? <span class="reqField">*</span></label>
            <select class="full_input errorOnBlur" name="hfa_laundry_avail" id="hfa1_laundry_available">
            <option value="">Select one</option>
             <option value="1" id="" class="">Yes</option>
             <option value="0" id="" class="">No</option>
            </select>
			</span>
            
            <span style="margin-left:60px; display:none;" class="hfa1_app_half" id="laundry_outside_house">
			<label class="full_label" for="hfa1_laundry_available_outside">Is the laundry located externally (outside the house)?</label>
            <select id="hfa_laundry_avail_outside" name="hfa_laundry_avail_outside" class="full_input">
            <option value="">Select one</option>
            <option value="1" id="" class="">Yes</option>
             <option value="0" id="" class="">No</option>
            </select>
            </span>
            <p id="hfa_laundry_avail_outsideP" style="display:none;">We recommend that you must nominate a day in a week for student to do the laundry.</p>
</div>

</fieldset>


</fieldset>
</fieldset>

<!--sdfsdfsdfsdfs-->
<fieldset id="tfa_4" class="section column tfa_4">
<fieldset id="" class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new">

<h3>Describe your home</h3>

<label>Be sure to mention any architectural features, atmosphere to expect and location based commentary. Any information 
here will be shared with your allocated placements and will help them understand your home and the experience they 
can look forward to.</label>

<textarea id="hfa_home_desc" value="" name="hfa_home_desc" class="full_textareas"></textarea>





</fieldset>
</fieldset>
<!--dfsdfsdfsdfdsf-->


<div class="end-options">
<input type="button" value="Submit &amp; continue" id="hfaTwoSubmitBtn" class="btn-btn-medium hfa_submit">

<div id="hfaTwoProcess" style="display:none;" class="appFormProcess">
	<img src="<?=str_replace('http:','https:',static_url())?>img/submitload.gif"   />
</div>

<span id="hfaTwoError" style="display:none;color:#F00;">The form is incomplete. Fields outlined with red are required in the right format.</span>
</div>

<p class="end-options-para">After submission, this part of the application wil be saved. You can always retrieve the saved application by clicking on Retrieve Saved 
Application button on the <a target="_blank" style="color:#000; text-decoration:underline;" href="<?=site_url()?>form/host_family_application">Host Family Application page</a> on Global experience website.</p>

</form>
</div>
</div>

</div>

<?php if($popUp!=''){?>
	<script type="text/javascript">
				$('#hfa_successPopUpOne').modal({backdrop: 'static', keyboard: false});
    </script>
<?php } ?>

<script type="text/javascript">
$(document).ready(function(){

$('#hfa_floors').on('change', function(){
	var selected_floors = $(this).val();
	$('.sha_location').each(function(){
		if($(this).attr('value') <= selected_floors){
			$(this).prop('selected', false)
			$(this).show()
		}
		else{
			$(this).prop('selected', false)
			$(this).hide()
		}
	})
});

$('#granny_flat').on('change', function(){

	if($(this).val() != 0){
		$('.hfa_bedroom_floor option').prop('selected', false)
		$(".location_granny_flat").show()
	}
	else{
		$('.hfa_bedroom_floor option').prop('selected', false)
		$(".location_granny_flat").hide()

	}
});

$('.hfa_room_avail_from, .hfa_room_avail_to, .hfa_room_date_leaving').datepicker({
		  changeMonth: true,
		  changeYear: true,
		  /*yearRange: "1900:2016",*/
		  dateFormat: 'dd/mm/yy'
		});


		$('#hfa_bedroom_input').change(function(){
				$('#hfa_bedroom_avail_span, .hfa_bedroom_avail_details').hide();
				$('#hfa_bedroom_avail').html('');
			//	$('#hfa_room_location').html('');
				var bed=$(this).val();
				if(bed!='')
				{
					$('#hfa_bedroom_avail').html('<option value="">Select one</option>');
					for(var x=1;x<=bed;x++)
					$('#hfa_bedroom_avail').append('<option class="" id="" value="'+x+'">'+x+'</option>');
					
					$('#hfa_bedroom_avail_span').show();
				}

				});
		
			$('#hfa_bedroom_avail').change(function(){
					$('.hfa_bedroom_avail_details').hide();
					
					var bedAvail=$(this).val();
					var hbed=$('#hfa_bedroom_input').val() - bedAvail;

					if(bedAvail!='')
					{
						$('#hfa_bedroom_avail_span').show();
						var hashAvail='#hfa_bedroom_avail_details_1';
						if(bedAvail>1)
						{
							for(var x=2;x<=bedAvail;x++)
								hashAvail +=' ,#hfa_bedroom_avail_details_'+x;
						}
						$(hashAvail).show();
					}

				if(hbed!=''){
						for(var x=1; x<=hbed;x++){
							hbed2 ='#hfa_bedroom_location_'+x;
							$(hbed2).show();
						}
						
					}

				});

				
			$('#hfa_bathroom_input')	.change(function(){
					$('.hfa_bathroom_details').hide();
					var bathroom=$('#hfa_bathroom_input').val();
					if(bathroom!='')
					{
						var hashBathAvail='#hfa_bathroom_details_1';
						if(bathroom>1)
						{
							for(var x=2;x<=bathroom;x++)
								hashBathAvail +=' ,#hfa_bathroom_details_'+x;
						}
						$(hashBathAvail).show();
					}
				});
				
				
				$('#hfaTwoSubmitBtn').click(function(){
					
		var $hfaTwoProcess=$('#hfaTwoProcess');
						var $hfaTwoSubmitBtn=$('#hfaTwoSubmitBtn')
					
						var $hfa_bedroom_input=$('#hfa_bedroom_input');
						var $hfa_bedroom_avail=$('#hfa_bedroom_avail');
						var $hfa_bathroom_input=$('#hfa_bathroom_input');
						var $hfa_floors=$('#hfa_floors');
						var $granny_flat=$('#granny_flat');
						var $hfa1_laundry_available=$('#hfa1_laundry_available');
						var $hfa_flooring_select=$('#hfa_flooring_select');
						var $hfa_flooring_other=$('#hfa_flooring_other');
						var $facility_others=$('#facility_others');
						var $hfa_facility_other_val=$('#hfa_facility_other_val');
						
						var hfa_bedroom_input=$hfa_bedroom_input.val();
						var hfa_bedroom_avail=$hfa_bedroom_avail.val();
						var hfa_bathroom_input=$hfa_bathroom_input.val();
						var hfa_floors=$hfa_floors.val();
						var granny_flat=$granny_flat.val();
						var hfa1_laundry_available=$hfa1_laundry_available.val();
						var hfa_flooring_select=$hfa_flooring_select.val();
						var hfa_flooring_other=$hfa_flooring_other.val();
						
						var hfa_facility_other_val=$hfa_facility_other_val.val().trim();
						
						removeFieldError($hfa_bedroom_input);
						removeFieldError($hfa_bedroom_avail);
						removeFieldError($hfa_bathroom_input);
						removeFieldError($hfa_floors);
						removeFieldError($granny_flat);
						removeFieldError($hfa1_laundry_available);
						removeFieldError($hfa_flooring_other);
						removeFieldError($hfa_facility_other_val);
						$('#hfaTwoError').hide();
						
						var hfa_bed_flooring_other_val=true;
						var room_type_select=true;
						var room_flooring_select=true;
						var student_room_location=true;
						var host_room_location=true;
						var hfa_room_availability=true;
						var bathroom_location=true;
						
						$('.hfa_bed_flooring_other_val').each(function(){
								var bedId=$(this).parents('div').attr('id').split('_')[2];
								
								if($("#hfa_bedroom_avail_details_"+bedId).is(":visible") && $("#room_flooring_select-"+bedId).val()==5 && $(this).val().trim()=='')
									{
										addFieldError($(this));
										hfa_bed_flooring_other_val=false;
									}
								else	
									removeFieldError($(this));
							});
							
						$('.room_type_select').each(function(){
								var bedId=$(this).attr('id').split('-')[1];
								
								if($("#hfa_bedroom_avail_details_"+bedId).is(":visible") && $(this).val()=='')
								{
									addFieldError($(this));
									room_type_select=false;
								}
								else	
									removeFieldError($(this));
							});

							$('.student_room_location').each(function(){
								var bedId=$(this).attr('id').split('-')[1];

								if($("#hfa_bedroom_avail_details_"+bedId).is(":visible") && $(this).val()=='')
								{
									addFieldError($(this));
									student_room_location=false;
								}
								else	
									removeFieldError($(this));
						});

								$('.host_room_location').each(function(){
								var bedId=$(this).attr('id').split('-')[1];

								if($("#hfa_bedroom_location_"+bedId).is(":visible") && $(this).val()=='')
								{
									addFieldError($(this));
									host_room_location=false;
								}
								else	
									removeFieldError($(this));
						});							
					
							
							$('.room_flooring_select').each(function(){
								var bedId=$(this).attr('id').split('-')[1];
								
								if($("#hfa_bedroom_avail_details_"+bedId).is(":visible") && $(this).val()=='')
								{
									addFieldError($(this));
									room_flooring_select=false;
								}
								else	
									removeFieldError($(this));
							});
						
							$('.hfa_room_availability').each(function(){
								var bedId=$(this).attr('id').split('-')[1];
								
								if($("#hfa_bedroom_avail_details_"+bedId).is(":visible") && $(this).val()=='')
								{
									addFieldError($(this));
									hfa_room_availability=false;
								}
								else	
									removeFieldError($(this));
							});

							$('.bathroom_location').each(function(){
								var bathId=$(this).attr('id').split('-')[1];

								if($("#hfa_bathroom_avail_details_"+bathId).is(":visible") && $(this).val()=='')
								{
									addFieldError($(this));
									bathroom_location=false;
								}
								else	
									removeFieldError($(this));
						});

						var hfa_room_avail_from=true;
						var hfa_bathroom_avail=true;
						hfa_room_avail_from=multipleFieldValidation('hfa_room_avail_from');
						hfa_bathroom_avail=multipleFieldValidation('hfa_bathroom_avail');
						
						if(hfa_bedroom_input=='' || hfa_bathroom_input=='' || hfa_floors=='' || granny_flat=='' || hfa1_laundry_available==''  || (hfa_flooring_select==5 && hfa_flooring_other=='') || ($facility_others.is(':checked') && hfa_facility_other_val=='') || ($('#hfa_bedroom_avail').is(':visible') && hfa_bedroom_avail=='') || !hfa_bed_flooring_other_val || !room_type_select || !student_room_location || !host_room_location  || !room_flooring_select || !hfa_room_availability || !hfa_room_avail_from || !hfa_bathroom_avail || !bathroom_location)
						{
								if(hfa_bedroom_input=='')
									addFieldError($hfa_bedroom_input);
								else	
									removeFieldError($hfa_bedroom_input);
						
								if(hfa_bathroom_input=='')
									addFieldError($hfa_bathroom_input);
								else	
									removeFieldError($hfa_bathroom_input);
								if(hfa_floors=='')
									addFieldError($hfa_floors);
								else
									removeFieldError($hfa_floors);
								if(granny_flat=='')
									addFieldError($granny_flat);
								else
									removeFieldError($granny_flat);
									
								if(hfa1_laundry_available=='')	
									addFieldError($hfa1_laundry_available);
								else	
									removeFieldError($hfa1_laundry_available);
								
								if(hfa_flooring_select==5 && hfa_flooring_other=='')
									addFieldError($hfa_flooring_other);
								else	
									removeFieldError($hfa_flooring_other);
									
								if($facility_others.is(':checked') && hfa_facility_other_val=='')
									addFieldError($hfa_facility_other_val);
								else	
									removeFieldError($hfa_facility_other_val);
									
								if($('#hfa_bedroom_avail').is(':visible') && hfa_bedroom_avail=='')	
									addFieldError($hfa_bedroom_avail);
								else	
									removeFieldError($hfa_bedroom_avail);
									//alert('error');
									
								//$('#hfaTwoError').show();	
								scrollToDiv('#add-hostfamily-application-2');
								errorBar('All fields marked with red are required');
						}
						else
						{
							$hfaTwoProcess.show();
							$hfaTwoSubmitBtn.hide();
				
							var host_family_application_twoData=$('#host_family_application_twoForm').serialize();
							$.ajax({
											url:site_url()+'form/host_family_application_two_submit',
											type:'POST',
											data:host_family_application_twoData,
											success:function(data)
												{
														$hfaTwoProcess.hide();
														//$hfaTwoSubmitBtn.show();
													
														if(data=='next')
															window.location.href=site_url()+'form/host_family_application_three/<?=$link?>/pop';		
												}
								});
						}
						
					});
	
	});
</script>
