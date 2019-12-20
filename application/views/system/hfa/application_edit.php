<?php
$step=hfaAppCheckStep($formOne['id']);
?>

<!--Personal details-->
<div class="col-md-3">
    <div class="panel panel-white">
        <div class="panel-heading">
            <h2 class="colorDarkgrey text-center" style="float:none">1 - Personal details</h2>
        </div>
        <div class="panel-body">
        <div class="text-center">
              <i class="mb-xl material-icons hfa_edit_page_icon">adjust</i>
        </div>
        
        <div class="pull-left">
        <h3 class="mt-n mb-n pt-xs">
        <small class="mt-sm
		<?php if($step>1){?>
        	colorLightgreen">
            Complete
        <?php }else{?>
        	colorBlue">
            Not filled
        <?php } ?>
        </small>
        </h3>
        </div>
        
        <a  href="<?=site_url()?>hfa/application_edit_one/<?=$formOne['id']?>" target="_blank" class="m-n btn btn-raised pull-right 
		<?php if($step>1){?>
        	btn-success">
            Edit
        <?php }else{?>
        	btn-info">
            Fill
        <?php } ?>
        </a>       
        </div>
        
        <div class="edot-desc">
        <h2>Personal Details</h2>
        <ul>
        <li>Name</li>
        <li>Email</li>
        <li>Phone numbers</li>
        <li>Prefered way to contact</li>
        <li>Address</li>
        </ul>
        </div>
        <div class="edot-desc">
        <h2>Emergency contact details</h2>
        <ul>
        <li>Name</li>
        <li>Your relationship to this person</li>
        <li>Phone number</li>
        <li>Email</li>
        </ul>
        </div>
        
    </div>
</div>
<!--Personal details ENDS-->

<!--Property details-->
<div class="col-md-3">
    <div class="panel panel-white">
        <div class="panel-heading">
            <h2 class="colorDarkgrey text-center" style="float:none">2 - Property details</h2>
        </div>
        <div class="panel-body">
        <div class="text-center">
              <i class="mb-xl material-icons hfa_edit_page_icon">dashboard</i>
        </div>
        
        <div class="pull-left">
        <h3 class="mt-n mb-n pt-xs">
        <small class="mt-sm
		<?php if($step>2){?>
        	colorLightgreen">
            Complete
        <?php }else{?>
        	colorBlue">
            Not filled
        <?php } ?>
        </small>
        </h3>
        </div>
        
        <?php if($step>1){?>
        <a  href="<?=site_url()?>hfa/application_edit_two/<?=$formOne['id']?>" target="_blank" class="m-n btn btn-raised pull-right 
		<?php if($step>2){?>
        	btn-success">
            Edit
        <?php }else{?>
        	btn-info">
            Fill
        <?php } ?>
        </a>
        <?php } ?>
        
        </div>
        
        <div class="edot-desc">
        <h2>Dwelling Type</h2>
        <ul>
        <li>Dwelling type</li>
        <li>Main type of flooring</li>
        <li>Internet availability</li>
        <li>Smoke detector</li>
        <li>Facilities</li>
        </ul>
        </div>
        <div class="edot-desc">
        <h2>Bedrooms</h2>
        <ul>
        <li>No. of bedrooms</li>
        <li>Type of room</li>
        <li>Type of flooring</li>
        <li>Access to the room</li>
        <li>Internal ensuite</li>
        <li>Room availability</li>
        </ul>
        </div>
        <div class="edot-desc">
        <h2>Bathrooms</h2>
        <ul>
        <li>No. of bathrooms</li>
        <li>Bathroom availability</li>
        <li>Bathroom features</li>
        <li>Bathroom location</li>
        </ul>
        </div>
        <div class="edot-desc">
        <h2>Laundry</h2>
        </div>
        <div class="edot-desc">
        <h2>Home description</h2>
        </div>
        
    </div>
</div>
<!--Property details ENDS-->
                            
<!--Family details-->
<div class="col-md-3">
    <div class="panel panel-white">
        <div class="panel-heading">
            <h2 class="colorDarkgrey text-center" style="float:none">3 - Family details</h2>
        </div>
        <div class="panel-body">
        <div class="text-center">
              <i class="mb-xl material-icons hfa_edit_page_icon">all_out</i>
        </div>
        
        <div class="pull-left">
        <h3 class="mt-n mb-n pt-xs">
        <small class="mt-sm
		<?php if($step>3){?>
        	colorLightgreen">
            Complete
        <?php }else{?>
        	colorBlue">
            Not filled
        <?php } ?>
        </small>
        </h3>
        </div>
       
       <?php if($step>2){?> 
        <a  href="<?=site_url()?>hfa/application_edit_three/<?=$formOne['id']?>" target="_blank" class="m-n btn btn-raised pull-right 
		<?php if($step>3){?>
        	btn-success">
            Edit
        <?php }else{?>
        	btn-info">
            Fill
        <?php } ?>
        </a>
        <?php } ?>
        
        </div>
        
        <div class="edot-desc">
        <h2>Family members</h2>
        <ul>
        <li>No.of members</li>
        <li>Name</li>
        <li>DOB</li>
        <li>Gender</li>
        <li>Contact number</li>
        <li>Family role</li>
        <li>Occupation</li>
        <li>Smoking habits</li>
        <li>Ethnicity</li>
        <li>Languages</li>
        <li>WWCC</li>
        </ul>
        </div>
        <div class="edot-desc">
        <h2>Pet details</h2>
        </div>
        <div class="edot-desc">
        <h2>Insurance details</h2>
        <ul>
        <li>Public liability insurance</li>
        <li>Home content insurance</li>
        </ul>
        </div>
         <div class="edot-desc">
        <h2>General details</h2>
        <ul>
        <li>Religion</li>
        <li>Past homestay experience</li>
        <li>Family description</li>
        </ul>
        </div>
        <div class="edot-desc">
        <h2>Bank account details</h2>
        <ul>
        <li>Bank name</li>
        <li>Account name</li>
        <li>BSB</li>
        <li>Account number</li>
        </ul>
        </div>
        
    </div>
</div>
<!--Family details ENDS-->

<!--Student preferences-->
<div class="col-md-3">
    <div class="panel panel-white">
        <div class="panel-heading">
            <h2 class="colorDarkgrey text-center" style="float:none">4 - Student preferences</h2>
        </div>
        <div class="panel-body">
        <div class="text-center">
              <i class="mb-xl material-icons hfa_edit_page_icon">face</i>
        </div>
        
        <div class="pull-left">
        <h3 class="mt-n mb-n pt-xs">
        <small class="mt-sm
		<?php if($step>4){?>
        	colorLightgreen">
            Complete
        <?php }else{?>
        	colorBlue">
            Not filled
        <?php } ?>
        </small>
        </h3>
        </div>
       
       <?php if($step>3){?> 
        <a  href="<?=site_url()?>hfa/application_edit_four/<?=$formOne['id']?>" target="_blank" class="m-n btn btn-raised pull-right  
		<?php if($step>4){?>
        	btn-success">
            Edit
        <?php }else{?>
        	btn-info">
            Fill
        <?php } ?>
        </a>
        <?php } ?>
        </div>
        
        <div class="edot-desc">
        <h2>Student preferences</h2>
        <ul>
        <li>Age preferences</li>
        <li>Gender preferences</li>
        <li>Reason for age and gender preferences</li>
        <li>Disability preferences</li>
        <li>Smoking preferences</li>
        <li>Dietary requirement preferences</li>
        <li>Allergies preferences</li>
        </ul>
        </div>
         <div class="edot-desc">
        <h2>Other</h2>
        <ul>
        <li>Other student preferences</li>
        <li>How did you hear about Global Experience</li>
        </ul>
        </div>
        
    </div>
</div>
<!--Student preferences ENDS-->   