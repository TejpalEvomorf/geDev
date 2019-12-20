<style type="text/css">
.tooltip-inner {
     white-space:pre;
    max-width:none;
}
</style>
<?php
$nameTitleList=nameTitleList();

$checkIfStudentPlaced=false;
if($formOne['status']=='approved_with_payment' || $formOne['status']=='approved_without_payment')
	$checkIfStudentPlaced=checkIfStudentPlaced($formOne['id']);
?>
<div class="container-fluid">
                                 
<div data-widget-group="group1">
	<div class="row">
   
	<div class="col-md-12 ge-app-header profile-area">
			<div class="media col-md-6 col-sm-6 col-xs-6">
				<a class="media-left pr-n" href="#" id="appProfilePic">
					<?php $this->load->view('system/sha/profilePic');?>
				</a>
				<div class="colorLightgrey media-body pl-xl">
					<h4 class="colorDarkgrey media-heading">
                    	<?php
                        $mname='';
						if($formOne['mname']!='')
							$mname=$formOne['mname']." ";
						
						if($formOne['title']!='')
							echo $nameTitleList[$formOne['title']];	
						?>
						<?=ucwords($formOne['fname'].' '.$mname.$formOne['lname'])?>
                    </h4>
					Student Application Details<br /><br />
                    <a href="mailto:<?=$formOne['email']?>" class="mr-lg colorTeal icon"><i class="material-icons">email</i></a>
                    <a href="callto:<?=$formOne['mobile']?>" class="colorTeal icon"><i class="material-icons">call</i></a>
				</div>
			</div>	
            
            <div class="pull-right col-md-6 col-sm-6 col-xs-6">
            
            	
				
                <div class="pull-right col-md-3 col-sm-6 col-xs-12" onclick="scrollToDIv('apuDiv');" style="cursor:pointer;">
                    <div class="mb-n info-tile info-tile-alt tile-lime">
                    
                    <?php if(!empty($formTwo)){
						$apuToolTip='';
						if($formTwo['airport_pickup']=='1')
						{
								if($formTwo['airport_arrival_date']!='0000-00-00')
									 $apuToolTip .=date('d M Y',strtotime($formTwo['airport_arrival_date']));
								if($formTwo['airport_arrival_date']!='0000-00-00' && $formTwo['airport_arrival_time']!='00:00:00')
									$apuToolTip .=", ";
								if($formTwo['airport_arrival_time']!='00:00:00')
									$apuToolTip .=date('h:i A',strtotime($formTwo['airport_arrival_time']));
						}
					?>
                        <div class="info" data-placement="bottom"  data-toggle="tooltip"  data-original-title="<?=$apuToolTip?>">
                            <div class="tile-heading"><span>APU</span></div>
                            <div class="tile-body "><span>
								<?php if($formTwo['airport_pickup']=='0')
											  	echo "No";
											elseif($formTwo['airport_pickup']=='1')
												echo "Yes";
											else	
												echo "n/a";
								?>
                            </span></div>
                        </div>
                         <?php }else{ ?>
                        <div class="info">
                            <div class="tile-heading"><span>APU</span></div>
                            <div class="tile-body "><span>n/a</span></div>
                        </div>
                        <?php } ?>
                        
                    </div>
                </div>
               
				
				
                <div class="pull-right col-md-3 col-sm-6 col-xs-12" style="cursor:pointer;">
                    <div class="mb-n info-tile info-tile-alt tile-teal">
                        
                        <?php if(!empty($formThree)){?>
                        <div class="info" data-placement="bottom"  data-toggle="tooltip"  data-original-title="<?php if($formThree['smoker']=='1'){echo "Smokes outdoors";}elseif($formThree['smoker']=='2'){echo "Smokes indoors & outdoors";}?>">
                            <div class="tile-heading"><span>Smoker</span></div>
                            <div class="tile-body "><span>
								<?php if($formThree['smoker']=='0')
											  echo "No";
											elseif($formThree['smoker']=='1' || $formThree['smoker']=='2')
												echo "Yes";
											else	
												echo "n/a";
								?>
                            </span></div>
                        </div>
                        <?php } else{?>
                        	<div class="info">
                            <div class="tile-heading"><span>Smoker</span></div>
                            <div class="tile-body "><span>n/a</span></div>
                        </div>
                        <?php }?>
                        
                    </div>
                </div>
                
                
                
                <div class="pull-right col-md-3 col-sm-6 col-xs-12" style="cursor:pointer;">
                    <div class="mb-n info-tile info-tile-alt tile-brown">
                <?php if(!empty($formOne)){
					$ageStudent=age_from_dob($formOne['dob']);
					$ageStudentToolTip='';
					if($ageStudent<18 && !empty($formTwo))
					{
						if($formTwo['guardianship']==1)
							$ageStudentToolTip="Caregiving requested";
						elseif($formTwo['guardianship']=="0")
							$ageStudentToolTip="No caregiving";	
					}
					?>        
                        <div class="info"  data-placement="bottom"  data-toggle="tooltip"  data-original-title="<?=$ageStudentToolTip?>">
                            <div class="tile-heading"><span>Age</span></div>
                            <div class="tile-body "><span><?php if($ageStudent==0){echo 'n/a';}else{echo $ageStudent;}?></span></div>
                        </div>
                        <?php }else{?>
                        <div class="info">
                            <div class="tile-heading"><span>Age</span></div>
                            <div class="tile-body "><span>n/a</span></div>
                        </div>
                <?php }?>        
                    </div>
                </div>
                
            </div>
            
		</div>
		<div class="ge-app-submenu col-md-12 pl-n pr-n">
			<ul class="nav nav-tabs material-nav-tabs mb-lg">
				<li class="active"><a href="#tab-8-1" data-toggle="tab"> Profilessss </a></li>
				<li><a href="#tab-8-3" data-toggle="tab"> Edit</a></li>
				<li><a href="#tab-8-4" data-toggle="tab"> Office use</a></li>
			</ul>
           
	            <button class="btn btn-midnightblue btn-sm btn-danger"   onclick="" id="deleteAppPhotos" style="display:none;">Delete images</button>

                <?php if(($formOne['status']=='approved_with_payment' || $formOne['status']=='approved_without_payment') && !$checkIfStudentPlaced){?>
                
                 <div class="btn-group dropdown" id="filterMatchesStatusBtnDiv" style="display:none;">
                 
                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
                                            Status filter <span class="caret"></span>
                                        </button>
                                       <ul class="dropdown-menu" role="menu">
                                            <li><a href="javascript:void(0);" onclick="filterMatchesStatusSubmit($(this),'all');" class="selected">Show all</a></li>
                                            <li><a href="javascript:void(0);" onclick="filterMatchesStatusSubmit($(this),'2');">Show shortlisted</a></li>
                                            <li><a href="javascript:void(0);" onclick="filterMatchesStatusSubmit($(this),'3');">Show rejected</a></li>
                                            <li><a href="javascript:void(0);" onclick="filterMatchesStatusSubmit($(this),'1');">Show unreviewed</a></li>
                                        </ul>
                                    </div>
                            
	                <button class="btn btn-sm btn-primary btn-default"   onclick="" id="filterMatches" style="display:none;">Search filters</button>
                <?php }?>
        </div>  
		
					<div class="p-n col-md-12 tab-content">
						<div class="tab-pane active" id="tab-8-1">
                       	<?php //$this->load->view('system/sha/application_profile');?> 
                       </div>
						<div class="tab-pane" id="tab-8-3">
                        	<?php //$this->load->view('system/sha/application_edit');?>
						</div>
						<div class="tab-pane" id="tab-8-4">
							<?php $this->load->view('system/sha/application_office_use');?>
						</div>
                    </div>
	</div>
</div>

                            </div>

<form id="filterMatchesForm">

	<?php
    	$accomodation_type=1;
		$accomodation_typeEdit=$formOne['accomodation_type'];
		$accomodation_typeRoomTypeEdit=roomTypeByAccomodationType($formOne['accomodation_type']);
	?>
    <input type="hidden" name="accomodation_type" id="accomodation_type" value="<?=$accomodation_type?>" />
    <input type="hidden" name="filterMatchesEditAccomodation_type" id="filterMatchesEditAccomodation_type" value="<?=$accomodation_typeEdit?>" />
    <input type="hidden" name="filterMatchesEditAccomodation_typeRoomType" id="filterMatchesEditAccomodation_typeRoomType" value="<?=implode(',',$accomodation_typeRoomTypeEdit)?>" />


	<?php
    if($formOne['arrival_date']!='0000-00-00')
	{
		$arrival_date=1;
		$arrival_dateEdit=date('d/m/Y',strtotime($formOne['arrival_date']));
	}
	else
	{
		$arrival_date=0;
		$arrival_dateEdit='';
	}
	?>
	<input type="hidden" name="arrival_date" id="arrival_date" value="<?=$arrival_date?>" />
    <input type="hidden" name="filterMatchesEditArrivalDate" id="filterMatchesEditArrivalDate" value="<?=$arrival_dateEdit?>" />
    
    <?php
    if(isset($formTwo['live_with_pets']))
	{
		$pets=1;
		$petsEdit=$formTwo['live_with_pets'];
	}
	else
	{
		$pets=0;
		$petsEdit='';
	}
	?>
    <input type="hidden" name="pets" id="pets" value="<?=$pets?>" />
    <input type="hidden" name="filterMatchesEditPets" id="filterMatchesEditPets" value="<?=$petsEdit?>" />
    
     <?php
			$child11=$child20='';
			if(isset($formThree['live_with_child11']))
				$child11=$formThree['live_with_child11'];
			if(isset($formThree['live_with_child20']))
				$child20=$formThree['live_with_child20'];
				
			$child=0;	
			if((isset($formThree['live_with_child11']) || isset($formThree['live_with_child20'])) && ($formThree['live_with_child11']!='' || $formThree['live_with_child20']!=''))
				$child=1;
	?>
    <input type="hidden" name="child" id="child" value="<?=$child?>" />
    <input type="hidden" name="filterMatchesEditChild11" id="filterMatchesEditChild11" value="<?=$child11?>" />
    <input type="hidden" name="filterMatchesEditChild20" id="filterMatchesEditChild20" value="<?=$child20?>" />
   
    <input type="hidden" name="age" id="age" value="1" />
    
     <?php 
	if($ageStudent<18)
	{?>
    	<input type="hidden" name="wwcc" id="wwcc" value="1" />
    <?php } ?>
    
    <input type="hidden" name="gender" id="gender" value="1" />
    
    <!--Student smoking habbits-->
    <?php
		$smoker="0";
		if(isset($formThree))
		{
			if($formThree['smoker']=='0')
				$smoker="0";
			elseif($formThree['smoker']=='1' || $formThree['smoker']=='2')
				$smoker="1";
		}
	?>
    <input type="hidden" name="smoker" id="smoker" value="<?=$smoker?>" />
    <input type="hidden" name="filterMatchesEditSmoker" id="filterMatchesEditSmoker" value="<?=$formThree['smoker']?>" />
    
    <!--Student smoking preferences-->
    <?php
		$smokerFamily="0";
		if(isset($formThree))
		{
			if($formThree['family_include_smoker']=='0')
				$smokerFamily="0";
			elseif($formThree['family_include_smoker']=='1' || $formThree['family_include_smoker']=='2')
				$smokerFamily="1";
		}
	?>
    <input type="hidden" name="smokerFamily" id="smokerFamily" value="<?=$smokerFamily?>" />
    <input type="hidden" name="filterMatchesEditSmokerFamily" id="filterMatchesEditSmokerFamily" value="<?=$formThree['smoker']?>" />
    
    
    <?php
    if(isset($formThree['diet_req']))
	{
		$diet_req=1;
		$diet_reqEdit=$formThree['diet_req'];
	}
	else
	{
		$diet_req=0;
		$diet_reqEdit='';
	}
	?>
    <input type="hidden" name="dietReq" id="dietReq" value="<?=$diet_req?>" />
    <input type="hidden" name="filterMatchesEditDietReq" id="filterMatchesEditDietReq" value="<?=$diet_reqEdit?>" />
    
     <?php
    if(isset($formThree['allergy_req']))
	{
		$allergy=1;
		$allergyEdit=$formThree['allergy_req'];
	}
	else
	{
		$allergy=0;
		$allergyEdit='';
	}
	?>
    <input type="hidden" name="allergy" id="allergy" value="<?=$allergy?>" />
    <input type="hidden" name="filterMatchesEditAllergy" id="filterMatchesEditAllergy" value="<?=$allergyEdit?>" />
    
    <?php
    if(isset($formThree['disabilities']))
	{
		$disability=1;
		$disabilityEdit=$formThree['disabilities'];
	}
	else
	{
		$disability=0;
		$disabilityEdit='';
	}
	?>
    <input type="hidden" name="disability" id="disability" value="<?=$disability?>" />
    <input type="hidden" name="filterMatchesEditDisability" id="filterMatchesEditDisability" value="<?=$disabilityEdit?>" />
    
    <?php
	$religion=0;
    if(isset($formTwo['religion']))
		$religionEdit=$formTwo['religion'];
	else
		$religionEdit='';
	?>
    <input type="hidden" name="religion" id="religion" value="<?=$religion?>" />
    <input type="hidden" name="filterMatchesEditReligion" id="filterMatchesEditReligion" value="<?=$religionEdit?>" />
    
    <input type="hidden" name="filterMatchesStatus" id="filterMatchesStatus" value="all" />
    
    <input type="hidden" name="id" value="<?=$formOne['id']?>" />
</form>
                            
<script type="text/javascript">
$(document).ready(function(){
	var tabToOpen=window.location.hash;
	if(tabToOpen!='')
		$('.nav-tabs a[href="'+tabToOpen+'"]').tab('show');
});

</script>



<?php if(($formOne['status']=='approved_with_payment' || $formOne['status']=='approved_without_payment')  && !$checkIfStudentPlaced){?>
	<div class="modal fade" id="model_PlaceBookingMatchedApp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h2 class="modal-title">Place booking</h2>
                </div>
                
                <div class="modal-body">
                    <form id="matchedAppPlaceBooking_form"></form>                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-raised" id="matchedAppPlaceBookingSubmit">Submit</button>
                    <img src="<?=loadingImagePath()?>" id="matchedAppPlaceBookingProcess" style="margin-right:16px;display:none;">
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
<?php } ?>    