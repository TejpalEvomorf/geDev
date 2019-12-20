<style type="text/css">
.tooltip-inner {
     white-space:pre;
    max-width:none;
}
</style>
<?php
$houseTypeList=houseTypeList();

$houseType=explode(' ',$houseTypeList[$formOne['service_type']]);
?>
<div class="container-fluid">
                                 
<div data-widget-group="group1">
	<div class="row">
   
	<div class="col-md-12 ge-app-header profile-area">
			<div class="media col-md-6 col-sm-6 col-xs-6">
				<a class="media-left pr-n" href="#" id="appProfilePic">
					<?php $this->load->view('system/share_house/profilePic');?>
				</a>
				<div class="colorLightgrey media-body pl-xl">
					<h4 class="colorDarkgrey media-heading">
						<?php echo ucwords($formOne['first_name'].' '.$formOne['last_name']);?>
                    </h4>
					Share House Details<br /><br />
                    <a href="mailto:<?php echo $formOne['email'];?>" class="mr-lg colorTeal icon"><i class="material-icons">email</i></a>
                    <a href="callto:<?php echo $formOne['mobile'];?>" class="colorTeal icon"><i class="material-icons">call</i></a>
				</div>
			</div>	
            
            <div class="pull-right col-md-6 col-sm-6 col-xs-6">
                <!--<div class="pull-right col-md-3 col-sm-6 col-xs-12" onclick="scrollToDIv('apuDiv');" style="cursor:pointer;">
                    <div class="mb-n info-tile info-tile-alt tile-lime">
                        <div class="info" data-placement="bottom"  data-toggle="tooltip"  data-original-title="dummy title">
                            <div class="tile-heading"><span>APU</span></div>
                            <div class="tile-body "><span>
								No
                            </span></div>
                        </div>
                    </div>
                </div>-->
               
				
				
                <div class="width-auto pull-right col-md-3 col-sm-6 col-xs-12" style="cursor:pointer;" >
                    <div class="mb-n info-tile info-tile-alt tile-teal">
                        
                        <div class="info">
                            <div class="tile-heading"><span>Arrival</span></div>
                            <div class="tile-body "><span>
								<?=date('d M',strtotime($formOne['arrival_date']))?>
                            </span></div>
                        </div>
                    </div>
                </div>
                
                
                
                <div class="width-auto pull-right col-md-3 col-sm-6 col-xs-12" style="cursor:pointer;">
                    <div class="mb-n info-tile info-tile-alt tile-brown">
                        <div class="info"  data-placement="bottom"  data-toggle="tooltip"  data-original-title="<?=$houseType[0]?>">
                            <div class="tile-heading"><span>Type</span></div>
                            <div class="tile-body "><span><?=$houseType[0]?></span></div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
		<div class="ge-app-submenu col-md-12 pl-n pr-n">
			<ul class="nav nav-tabs material-nav-tabs mb-lg">
				<li class="active"><a href="#tab-8-1" data-toggle="tab"> Profile </a></li>
				<li><a href="#tab-8-3" data-toggle="tab"> Edit</a></li>
				<li><a href="#tab-8-4" data-toggle="tab"> Office use</a></li>
            </ul>
        </div>  
		
					<div class="p-n col-md-12 tab-content">
						<div class="tab-pane active" id="tab-8-1">
                       	<?php $this->load->view('system/share_house/application_profile');?> 
                       </div>
						<div class="tab-pane" id="tab-8-3">
                        	<?php $this->load->view('system/share_house/application_edit');?>
						</div>
						<div class="tab-pane" id="tab-8-4">
							<?php $this->load->view('system/share_house/application_office_use');?>
						</div>
                      	<div class="tab-pane" id="tab-8-5">
                          <div class="col-md-12" style="display:none;">
                              <div class="panel panel-default">
                                <div class="panel-body no-padding">
                                </div>
                                <div class="panel-footer"></div>
                                </div>
                          </div>
                      	</div>
                    </div>
				</div>
			</div>
		</div>
		<form id="filterMatchesForm">
    		<input type="hidden" name="accomodation_type" id="accomodation_type" value="dummy accomodation type" />
    <input type="hidden" name="filterMatchesEditAccomodation_type" id="filterMatchesEditAccomodation_type" value="accomodation_typeEdit" />
    <input type="hidden" name="filterMatchesEditAccomodation_typeRoomType" id="filterMatchesEditAccomodation_typeRoomType" value="room type" />
	<input type="hidden" name="arrival_date_time" id="arrival_date_time" value="sdff" />
    <input type="hidden" name="filterMatchesEditArrivalDate" id="filterMatchesEditArrivalDate" value="<?php echo '45678910';?>" />
    
    <input type="hidden" name="pets" id="pets" value="dummy pet value" />
    <input type="hidden" name="filterMatchesEditPets" id="filterMatchesEditPets" value="<?php echo "23456";?>" />
    
    <input type="hidden" name="child" id="child" value="dummy child" />
    <input type="hidden" name="filterMatchesEditChild11" id="filterMatchesEditChild11" value="dummy value" />
    <input type="hidden" name="filterMatchesEditChild20" id="filterMatchesEditChild20" value="dummy" />
   
    <input type="hidden" name="age" id="age" value="1" />
    
    
    	<input type="hidden" name="wwcc" id="wwcc" value="1" />
   
    
    <input type="hidden" name="smoker" id="smoker" value="smoker" />
    <input type="hidden" name="filterMatchesEditSmoker" id="filterMatchesEditSmoker" value="smoker" />
    
    <input type="hidden" name="smokerFamily" id="smokerFamily" value="smokerFamily" />
    <input type="hidden" name="filterMatchesEditSmokerFamily" id="filterMatchesEditSmokerFamily" value="smoker" />
    <input type="hidden" name="dietReq" id="dietReq" value="diet_req" />
    <input type="hidden" name="filterMatchesEditDietReq" id="filterMatchesEditDietReq" value="234" />
    
    
    <input type="hidden" name="allergy" id="allergy" value="allergy" />
    <input type="hidden" name="filterMatchesEditAllergy" id="filterMatchesEditAllergy" value="allergyEdit" />
    
    <input type="hidden" name="disability" id="disability" value="disability" />
    <input type="hidden" name="filterMatchesEditDisability" id="filterMatchesEditDisability" value="disabilityEdit" />
    
    <input type="hidden" name="religion" id="religion" value="religion" />
    <input type="hidden" name="filterMatchesEditReligion" id="filterMatchesEditReligion" value="religionEdit" />
    
    <input type="hidden" name="filterMatchesStatus" id="filterMatchesStatus" value="all" />
    
    <input type="hidden" name="id" value="id" />
</form>
                            
<script type="text/javascript">
$(document).ready(function(){
	var tabToOpen=window.location.hash;
	if(tabToOpen!='')
		$('.nav-tabs a[href="'+tabToOpen+'"]').tab('show');
});

</script>
