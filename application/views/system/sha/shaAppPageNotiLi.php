<?php
$ageStudent=age_from_dob($formOne['dob']);

$guardianNotAssigned=false;
if(!empty($formTwo) && $formTwo['guardianship']=='1' && $formTwo['guardian_assigned']=='0' && $ageStudent<18 )
	$guardianNotAssigned=true;
$guardianshipDateNotSet=false;
if(!empty($formTwo) && $formTwo['guardianship']=='1' && ($formTwo['guardianship_startDate']=='0000-00-00' || $formTwo['guardianship_endDate']=='0000-00-00'))
	$guardianshipDateNotSet=true;
	
$shaNotiCount=0;
if($guardianNotAssigned)
	$shaNotiCount++;
if($guardianshipDateNotSet)
	$shaNotiCount++;
?>
<li style="float:right;" id="shaAppPageNotiLi">
 <?php if($guardianNotAssigned || $guardianshipDateNotSet){?>
	<div class="dropdown table-actions  toolbar-icon-bg" style="padding: 12px 16px 12px;">

   <span class="toolbar-icon-bg" data-toggle="dropdown">
			<a style="color:#888888;">
				<span class="">
					<i class="material-icons" style="color:#e51c23;">notifications</i>
                    <?php if($shaNotiCount!==0){?><span class="badge"><?=$shaNotiCount?></span><?php } ?>
				</span>
			</a>
		</span>
    
    <ul class="dropdown-menu" role="menu">
        <?php if($guardianNotAssigned){?>
        <li>
          <a href="javascript:void(0);" onClick="$('#shaOfficeUseLi a').trigger('click');"><i class="font16 material-icons">group_work</i>&nbsp;&nbsp;Caregiver not assigned</a>
        </li>
        <?php }  ?>
        
        <?php if($guardianshipDateNotSet){?>
        <li>
          <a href="javascript:void(0);" onClick="$('#shaOfficeUseLi a').trigger('click');"><i class="font16 material-icons">group_work</i>&nbsp;&nbsp;Caregiving start date not set</a>
        </li>
        <?php }  ?>
      </ul>
    </div>
</li>
<?php }?>
<li style="float:right" id="shaAppPageNotiLi"></li>