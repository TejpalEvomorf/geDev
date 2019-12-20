<?php
$step=shaAppCheckStep($formOne['id']);
?>

<!--Personal details-->
<div class="col-md-4">
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
        
        <a  href="<?=site_url()?>sha/application_edit_one/<?=$formOne['id']?>"  class="m-n btn btn-raised pull-right  
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
        <li>Gender</li>
        <li>DOB</li>
        <li>Email</li>
        <li>Phone numbers</li>
        <li>Student College id/number</li>
        <li>Accomodation type</li>
        <li>Nationality</li>
        <li>Passport details</li>
        <li>Arrival date</li>
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

<!--Other Details-->
<div class="col-md-4">
    <div class="panel panel-white">
        <div class="panel-heading">
            <h2 class="colorDarkgrey text-center" style="float:none">2 - Other details</h2>
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
        <a  href="<?=site_url()?>sha/application_edit_two/<?=$formOne['id']?>"  class="m-n btn btn-raised pull-right 
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
        <h2>Student Details</h2>
        <ul>
        <li>Languages</li>
        <li>Ethnicity</li>
        <li>Religion</li>
        </ul>
        </div>
         <div class="edot-desc">
        <h2>Pet Details</h2>
        </div>
         <div class="edot-desc">
        <h2>Travel insurance</h2>
        </div>
        <div class="edot-desc">
        <h2>Airport pickup service</h2>
        <ul>
        <li>APU requirement</li>
        <li>Arrival date and time</li>
        <li>Airline</li>
        <li>Flight number</li>
        </ul>
        </div>
        <div class="edot-desc">
        <h2>Student story</h2>
        <ul>
        <li>Past homestay experience</li>
        <li>Student description</li>
        <li>Student family description</li>
        </ul>
        </div>
        <div class="edot-desc">
        <h2>Caregiving (for 18-)</h2>
        <ul>
        <li>Caregiving requirement</li>
        <li>Caregiver preference</li>
        </ul>
        </div>

        
    </div>
</div>
<!--Other Details ENDS-->
                            
<!--Health Details and Preferences details-->

<div class="col-md-4">
    <div class="panel panel-white">
        <div class="panel-heading">
            <h2 class="colorDarkgrey text-center" style="float:none">3 - Health Details and Preferences</h2>
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
        <a  href="<?=site_url()?>sha/application_edit_three/<?=$formOne['id']?>"  class="m-n btn btn-raised pull-right  
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
        <h2>Health details</h2>
        <ul>
        <li>Special dietary requirements</li>
        <li>Allergies</li>
        <li>Smoking habits</li>
        <li>Medications</li>
        <li>Disabilities</li>
        </ul>
        </div>
        <div class="edot-desc">
        <h2>Homestay family preferences</h2>
        <ul>
        <li>Living with children preference</li>
        <li>Smoking preference</li>
        <li>Other family preference</li>
        </ul>
        </div>
        <div class="edot-desc">
        <h2>College/Institution</h2>
        <ul>
        <li>Name</li>
        <li>Campus</li>
        <li>Address</li>
        <li>Course name</li>
        <li>Course start date</li>
        <li>Reason for homestay</li>
        <li>How did you heard about Global Experience</li>
        </ul>
        </div>
        
    </div>
</div>
<!--Health Details and Preferences ENDS-->
