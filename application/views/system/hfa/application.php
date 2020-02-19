 <?php
$hfaStatusList=hfaStatusList();
	
?>

<div class="container-fluid">
                                 
<div data-widget-group="group1">
	<div class="row">
    <!--<div class="page-heading"><h1>Application details</h1></div>-->

		<div class="col-md-12 ge-app-header profile-area">
			<div class="media col-md-6 col-sm-6 col-xs-6">
				<a class="media-left pr-n" href="#" id="appProfilePic">
					<?php $this->load->view('system/hfa/profilePic');?>
				</a>
				<div class="colorLightgrey media-body pl-xl">
					<h4 class="colorDarkgrey media-heading"><?=ucfirst($formOne['lname'])?> Family</h4>
					Host Family Application Details<br /><br />
                    <a style="float:left;" href="mailto:<?=$formOne['email']?>" class="mr-lg colorTeal icon"><i class="material-icons">email</i></a>
                   <!--  <a href="callto:<?=$formOne['mobile']?>" class="mr-lg colorTeal icon"><i class="material-icons">call</i></a> -->
                   <?php if($formOne['hfa_bookmark']=='0'){
	$matchStatusShortlistedClass='matchStatusGrey';
			$matchStatusShortlistedToolTip='Click to bookmark';
			
			}else{
				$matchStatusShortlistedClass='matchStatusGreen';
			$matchStatusShortlistedToolTip='Click to unmark';
}?>
                   <i style="float:left; margin-top:3px;" class="fa fa-bookmark  mr-lg <?=$matchStatusShortlistedClass;?> dark-gray" data-placement="bottom"  data-toggle="tooltip"  data-original-title="<?=$matchStatusShortlistedToolTip;?>" onclick="hostfamilybookmark($(this),<?=$formOne['id'] ;?>);"></i>
                    <?php
if(ucfirst(@$formOne['hfa_registered_status'] )=='Online'){
echo '<span style="float:left; margin-top:4px;"  class="label label-success offline-online">Online submission</span>';}else if(ucfirst(@$formOne['hfa_registered_status'] )=='Offline'){
	echo '<span style="float:left; margin-top:4px;"  class="label label-darkgreen offline-online">Admin submission</span>';
}?>
				</div>
			</div>	
            <div class="pull-right col-md-6 col-sm-6 col-xs-6">
            
            
            <div class="pull-right col-md-3 col-sm-6 col-xs-12" <?php if($formThree['family_members']!='' || !empty($formTwo)){?>onclick="scrollToDIv('familyDetailsDiv');"<?php } ?> style="cursor:pointer;">
                    <div class="mb-n info-tile info-tile-alt tile-lime clearfix">
                        
                        <?php if($formThree['family_members']!='' || !empty($formTwo)){
				
				$familyChildren=0;
				
				if(isset($formThree))
				{
					foreach($formThree['memberDetails'] as $familyDetails)
						{	
							if(exact_age_from_dob($familyDetails['dob'])<18)
								$familyChildren++;
						}
				}
				?> 
                        <?php 
						if(!empty($formThree) || $formOne['family_members']!=''){
						?>
						<div style="height:auto;" class="info" data-placement="bottom"  data-toggle="tooltip"  data-original-title="<?php if($familyChildren==0){echo 'No';}else{echo 'Includes';}?> children less than 18 years"> 
						<?php }else{ echo '<div class="info"  style="height:auto;">'; } ?>
                            <div class="tile-heading"><span>Members</span></div>
                            <div class="tile-body ">
                            <span>
                            	<?php 
										if(!empty($formThree))
											echo $formThree['family_members'];
										else if($formOne['family_members']!='')
											echo $formOne['family_members'];
										else
											echo "n/a";	
										?>
                            </span></div>
                        </div>
                     <?php }else{ ?>
                     
                     <div class="info" style="height:auto;">
                            <div class="tile-heading"><span>Members</span></div>
                            <div class="tile-body ">
                            <span><?php echo "n/a";?></span></div>
                        </div>
                        
                     <?php } ?>
                        
                    </div>
                </div>
                
                <div class="pull-right col-md-3 col-sm-6 col-xs-12" onclick="scrollToDIv('bathroomsDiv');" style="cursor:pointer;">
                    <div class="mb-n info-tile info-tile-alt tile-teal">
                    <?php
					if(!empty($formTwo)){
						$bathroomAvailToStudent=0;
						foreach($formTwo['bathroomDetails'] as $bathDetails)
						  {	
							  if($bathDetails['avail_to_student']==1)
								  $bathroomAvailToStudent++;
						  }
						?>
                        <div class="info" data-placement="bottom"  data-toggle="tooltip"  data-original-title="Bathrooms available to student: <?=$bathroomAvailToStudent?>">
                            <div class="tile-heading"><span>Baths</span></div>
                            <div class="tile-body "><span><?=$formTwo['bathrooms']?></span></div>
                        </div>
                        <?php } else{?>
                        <div class="info">
                            <div class="tile-heading"><span>Baths</span></div>
                            <div class="tile-body "><span>n/a</span></div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                
                
                
                <div class="pull-right col-md-3 col-sm-6 col-xs-12" onclick="scrollToDIv('bedroomsDiv');" style="cursor:pointer;">
                    <div class="mb-n info-tile info-tile-alt tile-brown">
                    <?php if(!empty($formTwo)){?>
                        <div class="info"   data-placement="bottom"  data-toggle="tooltip"  data-original-title="Total bedrooms in property: <?=$formTwo['bedrooms']?>">
                            <div class="tile-heading"><span>Bedrooms</span></div>
                            <div class="tile-body "><span><?=$formTwo['bedrooms_avail']?></span></div>
                        </div>
                    <?php } else {?>
                           <div class="info">
                            	<div class="tile-heading"><span>Bedrooms</span></div>
                           	 	<div class="tile-body "><span>n/a</span></div>
                        	</div>
                    <?php } ?>
                    </div>
                </div>

            </div>

		</div>
		<div class="ge-app-submenu col-md-12 pl-n pr-n ul-tabs">
			<ul class="nav nav-tabs material-nav-tabs mb-lg">
				<li class="active"><a href="#tab-8-1" data-toggle="tab"> Profile </a></li>
				<li><a href="#tab-8-2" data-toggle="tab"> Photos</a></li>
				<li><a href="#tab-8-3" data-toggle="tab"> Edit</a></li>
				<li><a href="#tab-8-4" data-toggle="tab"> Office use</a></li>
				<li><a href="#tab-8-5" data-toggle="tab"> History</a></li>
                <?php $this->load->view('system/hfa/hfaAppPageNotiLi');?>
                <li style="float: right;padding: 15px 16px;font-size: 12px;font-weight: 500; text-transform:uppercase;"><?=$hfaStatusList[$formOne['status']]?></li>
                <li style="float:right"><button class="btn  btn-sm btn-danger"   onclick="" id="deleteAppPhotos" style="display:none;"><i class="material-icons" style="color:#e51c23; font-size:14px; margin-right:2px">image</i>Delete pics</button></li>
                <li style="float:right"><button class="btn btn-sm btn-primary" onclick="javascript:hfaPrintWindow(<?=$formOne['id']?>);" id="printProfieBtn" ><i class="material-icons" style="font-size:14px; margin-right:2px">print</i>Print</button></li>
                <li style="float: right;"> 
                    <div class="btn-group dropdown" id="sortHfaBookingHistory" style="display:none;">
                      <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
                          Sort <span class="caret"></span>
                      </button>
                     <ul class="dropdown-menu" role="menu">
                          <li id="sortHfaBookingHistory-1"><a href="javascript:void(0);" onclick="hfaBookingHistory('startDateDesc',2);">Booking start date (Latest on top)</a></li>
                          <li id="sortHfaBookingHistory-2"><a href="javascript:void(0);" onclick="hfaBookingHistory('startDate',2);">Booking start date (Oldest on top)</a></li>
                          <li id="sortHfaBookingHistory-3"><a href="javascript:void(0);" onclick="hfaBookingHistory('status',2);" class="selected">Status</a></li>
                      </ul>
                    </div>
                </li>
	        </ul>
		</div>
		
        <!--<div class="col-md-12">-->
			<!--<div class="tab-content">
				<div class="panel-profile">-->
					<div class="p-n col-md-12 tab-content">
						<div class="tab-pane active" id="tab-8-1">
                       	<?php $this->load->view('system/hfa/application_profile');?> 
                       </div>
						<div class="tab-pane" id="tab-8-2">								
							<?php $this->load->view('system/hfa/application_photos');?> 					
						</div>
						<div class="tab-pane" id="tab-8-3">
                        	<?php $this->load->view('system/hfa/application_edit');?>
						</div>
						<div class="tab-pane" id="tab-8-4">
							<?php $this->load->view('system/hfa/application_office_use');?>
						</div>
						<div class="tab-pane" id="tab-8-5">
							<?php $this->load->view('system/hfa/application_history');?>
						</div>
					</div>
				<!--</div>
			</div>--><!-- .tab-content -->
		<!--</div>--><!-- col-sm-8 -->
	</div>
</div>
                            </div>


                  

<script type="text/javascript">
$(document).ready(function(){
	var tabToOpen=window.location.hash;
	//alert(tabToOpen);
	if(tabToOpen!='')
		$('.nav-tabs a[href="'+tabToOpen+'"]').tab('show');
	 window.location.hash = '';
	//	 var tabToOpen = window.location.hash;
		// alert(tabToOpen);
    if (tabToOpen != '' && tabToOpen == '#bathroom') {
      notiPop("success", "Student Bathroom deleted successfully.", "");
	}
	   else if (tabToOpen != '' && tabToOpen == '#bedroom') {
      notiPop("success", "Student Bedroom deleted successfully.", "");
      window.location.hash = '';
    }else if (tabToOpen != '' && tabToOpen == '#hbedroom') {
      notiPop("success", "Host Bedroom deleted successfully.", "");
      window.location.hash = '';
    } else if (tabToOpen != '' && tabToOpen == '#member') {
      notiPop("success", "Member deleted successfully.", "");
      window.location.hash = '';
    }
	else if (tabToOpen != '' && tabToOpen == '#bedroomDeactived') {
      notiPop("success", "Student bedroom deactivated successfully.", "");
      window.location.hash = '';
    }
	else if (tabToOpen != '' && (tabToOpen == '#visitReportCreated' || tabToOpen == '#visitReportUpdated')) {
      if(tabToOpen == '#visitReportCreated')
	  	var alertMsgPart='created';
	  else
		  var alertMsgPart='updated';
	  notiPop("success", "Visit report "+alertMsgPart+" successfully.", "");
      window.location.hash = '';
    }
	
	hfaBookingHistory('status',1);
});

function hfaBookingHistory(sortBy,type)
{
	$('#sortHfaBookingHistory li a').removeClass('selected');
	if(sortBy=='startDateDesc')
		$('#sortHfaBookingHistory-1 a').addClass('selected');
	else if(sortBy=='startDate')
		$('#sortHfaBookingHistory-2 a').addClass('selected');
	else
		$('#sortHfaBookingHistory-3 a').addClass('selected');
	
	$('#bookingHistoryList_processing').show();
	$.ajax({
		url:site_url+"hfa/appHistoryTabContent",
		type:'POST',
		data:{id:'<?=$formOne['id']?>',sortBy:sortBy},
		success:function(data)
			{
				if(type==2)
					$('#bookingHistoryList_processing').hide();
				$('#bookingHistoryList tbody').replaceWith(data);
				if(type==1)
				{
					var oTableBookingHistory = $('#bookingHistoryList').dataTable({
								  "language": {
									  "lengthMenu": "_MENU_"
								  },
								   "processing": true, 
								   "order": [],
								  "columnDefs": [
									   { "width": "20%", "targets": -1 },
									   {"targets": [0,1,2,3,4],"orderable": false}
									],
								  "drawCallback": function( settings ) {   
										  initializeToolTip();
								  },
						 			   "sPaginationType": "full_numbers_no_ellipses",
									   "pageLength": 50,
									   "bLengthChange": false,
									   initComplete : function() 
										{
											initializeToolTip();
											$('.dataTables_filter').css('width',0).hide();
											$("#listTableSearchBtn").css("width","125px").show();
										}  
							  });

							$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
							$('#tab-8-5 .panel-footer').append($(".dataTable+.row"));
							$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
				}
			}
	});
	
	
}
</script>                            


<!--Loading the wwcc and PL insurance pop ups-->
<?php $this->load->view('system/hfa/wwccPlInsPopups.php');?>     