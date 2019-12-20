<?php
$memberTurned18=false;
$wwccexpired=false;
if(isset($formThree))
	  {
		  foreach($formThree['memberDetails'] as $familyDetails)
			  {	
				  if(exact_age_from_dob($familyDetails['dob'])>17 && $familyDetails['wwcc']=='')
					  $memberTurned18=true;
				  if(check_wwcc_expiry($familyDetails['wwcc_expiry']) == "expired")
					  $wwccexpired=true;
			  }
	  }
	
	$hfaNotiCount=0;
	if(!empty($formThree))
	{
		  if($formThree['wwcc_status']==0){
			  $hfaNotiCount++;
		  }else{
			  if($formThree['wwcc_status']==1 && $memberTurned18)
			  	$hfaNotiCount++;
		  	  if($formThree['wwcc_status']==1 && $wwccexpired)
			  	$hfaNotiCount++;
		  }
		  
		  
		  if($formThree['pl_ins_status']==0)
			  $hfaNotiCount++;
		  elseif($formThree['pl_ins_status']==1){
			  if(($formThree['ins_expiry']!='0000-00-00') && strtotime($formThree['ins_expiry'])<strtotime(date('Y-m-d')))
					$hfaNotiCount++; 
		  }
		  	
	}
?>
<li style="float:right;" id="hfaAppPageNotiLi">
	 <?php if(!empty($formThree) && ($formThree['wwcc_status']==0 || $formThree['pl_ins_status']==0 || ($formThree['wwcc_status']==1 && $memberTurned18) || ($formThree['wwcc_status']==1 && $wwccexpired) || ($formThree['pl_ins_status']==1 && $formThree['ins_expiry']!='0000-00-00' && strtotime($formThree['ins_expiry'])<strtotime(date('Y-m-d'))))){?>
    <div class="dropdown table-actions  toolbar-icon-bg" style="padding: 12px 16px 12px;">

        
        <span class="toolbar-icon-bg" data-toggle="dropdown">
			<a data-toggle="tooltips" data-placement="right" title="Toggle Sidebar" style="color:#888888;">
				<span class="">
					<i class="material-icons" style="color:#e51c23;">notifications</i>
                    <?php if($hfaNotiCount!==0){?><span class="badge"><?=$hfaNotiCount?></span><?php } ?>
				</span>
			</a>
		</span>
        
        <ul class="dropdown-menu" role="menu">
            <?php if($formThree['wwcc_status']==0){?>
            <li>
              <a href="javascript:void(0);" data-toggle="modal" data-target="#mode_reviewWWCCstatus" onclick="wwreviewStatusModalInfoclick(<?=$formOne['id'].',0'?>);"><img src="<?=static_url()?>img/ww-icon.png" id="wwstatusicon-2564" data-placement="bottom" data-toggle="tooltip" data-original-title="Click to review WWCC status" width="16">&nbsp;&nbsp;WWCC not approved</a>
            </li>
            <?php }else{
				if($formThree['wwcc_status']==1 && $memberTurned18){ ?>
				<li>
                  <a href="javascript:void(0);" data-toggle="modal" data-target="#mode_reviewWWCCstatus" onclick="wwreviewStatusModalInfoclick(<?=$formOne['id'].','.$formThree['wwcc_status']?>);"><i class="font16 material-icons">cake</i>&nbsp;&nbsp;Member turned 18, provide WWCC</a>
                </li>
			 <?php }
			 if($formThree['wwcc_status']==1 && $wwccexpired){ ?>
				<li>
                  <a href="javascript:void(0);" data-toggle="modal" data-target="#mode_reviewWWCCstatus" onclick="wwreviewStatusModalInfoclick(<?=$formOne['id'].','.$formThree['wwcc_status']?>);"><i class="font16 material-icons">do_not_disturb_on</i>&nbsp;&nbsp;WWCC expired for a member</a>
                </li>
			<?php } } ?>
            <?php if($formThree['pl_ins_status']==0){?>
            <li>
              <a href="javascript:void(0);" class="mr-sm" data-toggle="modal" data-target="#mode_reviewPLIstatus" onclick="plreviewStatusModalInfoclick(<?=$formOne['id'].','.$formThree['pl_ins_status']?>);"><img src="<?=static_url()?>img/pl-icon.png" id="plstatusicon-3305" data-placement="bottom" data-toggle="tooltip" data-original-title="Click to review PL Insurance status" width="16">&nbsp;&nbsp;PL insurance not approved</a>
            </li>
            <?php }elseif($formThree['pl_ins_status']==1){
				if(($formThree['ins_expiry']!='0000-00-00') && strtotime($formThree['ins_expiry'])<strtotime(date('Y-m-d'))){?>
                      <li>
                        <a href="javascript:void(0);" class="mr-sm" data-toggle="modal" data-target="#mode_reviewPLIstatus" onclick="plreviewStatusModalInfoclick(<?=$formOne['id'].','.$formThree['pl_ins_status']?>);"><i class="font16 material-icons">do_not_disturb_on</i>&nbsp;&nbsp;PL Insurance has expired</a>
                      </li>
				<?php }
			} ?>
          </ul>
        </div>
    <?php } ?>
</li>