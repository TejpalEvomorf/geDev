<?php
$apuCompanyList=apuCompanyList();
$clientsList=clientsList();
$accomodationTypeList=accomodationTypeList();
$roomDetails=roomDetails($booking['room']);

$roomTypeList=roomTypeList();
$stateList=stateList();
$genderList=genderList();
$nameTitleList=nameTitleList();
$profilechecklist=profilechecklist();

$bookingBedNumber=bookingBedNumber($booking['id']);
?>
<div class="container-fluid">
                                 
    <div data-widget-group="group1">
        <div class="row">

        
    		<div class="col-md-12 ge-app-header profile-area">
            
            <div class="media col-md-6 col-sm-6 col-xs-6">
				<a target="_blank" class="media-left pr-n" href="<?=site_url()?>hfa/application/<?=$host['id']?>" id="appProfilePic">
					<?php 
					$hostProfilePicData['formOne']=$host;
					$this->load->view('system/hfa/profilePic',$hostProfilePicData);
					?>
				</a>
				<div class="colorLightgrey media-body pl-xl">
					<!--<a target="_blank" href="<?=site_url()?>hfa/application/<?=$host['id']?>" target="_blank"><h4 class="colorDarkgrey media-heading lalala"><?=ucwords($host['lname'])?> Family</h4></a>-->
                    
                   <a target="_blank" href="<?=site_url()?>hfa/application/<?=$host['id']?>" > <h4 class="colorDarkgrey media-heading lalala"><?php  if($host['title']!=0){echo $nameTitleList[$host['title']].' ';}?> <?=ucwords($host['fname'].' '.$host['lname'])?></h4></a>
                   <?php
                    $addressForMap='';
					if($host['street']!='')
						$addressForMap .=$host['street'].", ";
					$addressForMap .=ucfirst($host['suburb']).", ".$stateList[$host['state']].", ".$host['postcode'];
					echo getMapLocationLink($addressForMap);
				   ?>
                    <br />
                    <a style="color:#888888" href="mailto:<?=$host['email']?>" class="mailto"><?=$host['email']?></a><br /> <?=$host['mobile']?>
				</div>
			</div>
            
            <div class="pull-right col-md-6 col-sm-6 col-xs-6">
               <a target="_blank" class="media-left pr-n" href="<?=site_url()?>sha/application/<?=$student['id']?>" id="appProfilePic" style="float:right;">
					<?php 
					$studentProfilePicData['formOne']=$student;
					$this->load->view('system/sha/profilePic',$studentProfilePicData);
					?>
				</a>
               <div class="colorLightgrey media-body pl-xl" style="float:right; padding-right:32px; text-align:right;">
					<a target="_blank" href="<?=site_url()?>sha/application/<?=$student['id']?>"><h4 class="colorDarkgrey media-heading lalala">
					<?php  if($student['title']!=0){echo $nameTitleList[$student['title']].' ';}?>
					<?=ucwords($student['fname'].' '.$student['lname'])?> </h4></a>
                    <?=$genderList[$student['gender']]?>, age <?=age_from_dob($student['dob']);?><br />
                    <?=$student['mobile']?>, <a style="color:#888888" href="mailto:<?=$student['email']?>" class="mailto"><?=$student['email']?><br />
                    <?=$student['three']['college']?></a>
				</div>               
                
            </div>
            
            
            </div>
           
           <div class="ge-app-submenu col-md-12 pl-n pr-n ul-tabs">
			<ul class="nav nav-tabs material-nav-tabs mb-lg">
				<li class="active"><a href="#tab-8-1" data-toggle="tab"> Office use </a></li>
				<li><a href="#tab-8-2" data-toggle="tab"> PO/Invoice history</a></li>
			</ul>
		</div>
        <div class="p-n col-md-12 tab-content">
						<div class="tab-pane active" id="tab-8-1">
                       			
                                <!--tab 1 content #STARTS-->
                                <div class="p-n col-md-12">
           
           
           		<!--11111111111111-->
                <div class="col-md-4">
                
                <div class="family-details-all tab-pane panel panel-bluegraylight"  data-widget='{"draggable": "false"}'>
                           <div class="panel-heading">                                
                                      <h2>Booking Details</h2>
                               </div>

                                    <div class="about-area panel-body">
                                  <div class="table-responsive">
                                      
                                      <table class="table about-table">
                                          <tbody>
                                              <tr>
                                                  <td>
                                                  <div class="personel-info pt-n">
							<span class="icon"><i class="material-icons">assignment</i></span>
							<span>Booking Id: <?=$booking['id']?></span>
                            </div>
                                                  </td>
                                              </tr>
                                              
                                              <tr>
                                                  <td>
                                                  <div class="personel-info pt-n">
							<span class="icon"><i class="material-icons">date_range</i></span>
							Durations:
									<?php
                                    if($booking['booking_from']!='0000-00-00')
                                    {
                                        echo date('d M Y',strtotime($booking['booking_from']));
                                       if($booking['booking_to']!='0000-00-00')
                                           echo ' - '.date('d M Y',strtotime($booking['booking_to'].' +1 day'));
                                      else	
                                          echo ' - Not set';
                                     }
                                     else
                                        echo 'Not set';
                                    ?><!--</span><i class="material-icons" style="float:right;font-size:18px; color:hsl(199, 98%, 48%);cursor:pointer;" onclick="editBookingPopContent(<?=$booking['id']?>)" data-toggle="modal" data-target="#model_editBooking">edit</i>
                            </span>-->
                            </div>
                                                  </td>
												  
                                              </tr>
											 
                                                  <tr>
                                                  <td>
                                                  <div class="personel-info pt-n">
							<span class="icon"><i class="material-icons">business</i></span>
							<span>Product: <?=$accomodationTypeList[$student['accomodation_type']];?></span>
                            </div>
                                                  </td>
                                              </tr>
                                              
                                               <tr>
                                                  <td>
                                                  <div class="personel-info pt-n">
							<span class="icon"><i class="material-icons">home</i></span>
							
							<span>Room type: <?=@$roomTypeList[@$roomDetails['type']].' '.' '.'(Student Bedroom '.@$bookingBedNumber.')';?></span>
                            </div>
                                                  </td>
                                              </tr>
 <?php  if($booking['moveout_date']!='0000-00-00')
                                    { ?>
                                              <tr>
											  <td>
												  <div class="personel-info pt-n">
							<span class="icon"><i class="material-icons">business_center</i></span>
							<span>Move out date:<span id="viewBooking_moveoutdate">
			<?php echo  date('d M Y',strtotime($booking['moveout_date'])); ?>
							</span>
							</div>
												  </td>
											  </tr>
									<?php }?>
                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                           
                           
                          
                            
                            
                           
		</div>
                
 
    <div class="panel panel-bluegraylight">
        <div class="panel-heading">
            <h2>Booking notes</h2>
        </div>
        <div class="panel-body">
           <form id="updateBookingNotesForm">
                <input type="hidden" name="booking_id" value="<?=$booking['id']?>" />
				<div class="m-n form-group">
					<label class="control-label">Any Notes related to this Booking</label>
					<textarea  rows="4" class="form-control" id="bookingNotes_viewPage" name="notes"><?=$booking['notes']?></textarea>
				</div>
			</form>
        </div>
    </div>
    
    <?php $this->load->view('system/booking/incidentsBox');?>
    <?php $this->load->view('system/booking/feedbacksBox');?>
    <?php $this->load->view('system/booking/CGDocBox');?>
    
</div>
        
<div class="col-md-4">

<?php 
//see($student);
//if($student['study_tour_id']==0){ ?>
                
                <div class="family-details-all tab-pane panel panel-bluegraylight"  data-widget='{"draggable": "false"}'>
                           <div class="panel-heading">                                
                                      <h2>APU Info</h2>
                               </div>

                                    <div class="about-area panel-body">
                                  
                                  <div>
				<form id="">
					<input type="hidden" name="id" value="" />
					 
                     <!--<div class="m-n form-group">
					<label class="control-label">Airport pickup?</label><br />
					<div class="col-sm-8">
						<div class="radio block"><label><input type="radio" name="airport_pickup" value="1" <?php if($student['two']['airport_pickup']=='1'){echo 'checked';}?>> Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="airport_pickup" value="0"  <?php if($student['two']['airport_pickup']=='0'){echo 'checked';}?>> No</label></div>
					</div>
				    </div>-->
                    
                    <?php if($student['study_tour_id']==0){?>
                             <div class="m-n form-group">
                            <label class="control-label">Airport pickup?</label><br />
                            <div class="col-sm-8">
                                <div class="radio block"><label><input type="radio" name="airport_pickup" value="1" <?php if($student['two']['airport_pickup']=='1'){echo 'checked';}?>> Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="airport_pickup" value="0"  <?php if($student['two']['airport_pickup']=='0'){echo 'checked';}?>> No</label></div>
                            </div>
                            </div>
                    <?php }
					else{ ?>
		                    <div class="m-n form-group" style="overflow:hidden;">
                            <label class="control-label">Family to pickup from meeting point?</label><br />
                            <div class="col-sm-8">
                                <div class="radio block"><label><input type="radio" name="family_pickup_meeting_point" value="1" <?php if($student['two']['family_pickup_meeting_point']=='1'){echo 'checked';}?>> Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="family_pickup_meeting_point" value="0"  <?php if($student['two']['family_pickup_meeting_point']=='0'){echo 'checked';}?>> No</label></div>
                            </div>
                            </div>
                            
		                    <div class="m-n form-group" style="overflow:hidden;">
                            <label class="control-label">Airport pickup to meeting point?</label><br />
                            <div class="col-sm-8">
                                <div class="radio block"><label><input type="radio" name="airport_pickup_meeting_point" value="1" <?php if($student['two']['airport_pickup_meeting_point']=='1'){echo 'checked';}?>> Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="airport_pickup_meeting_point" value="0"  <?php if($student['two']['airport_pickup_meeting_point']=='0'){echo 'checked';}?>> No</label></div>
                            </div>
                            </div>
                            
		                    <div class="m-n form-group" style="overflow:hidden;">
                            <label class="control-label">Airport pick up to homestay?</label><br />
                            <div class="col-sm-8">
                                <div class="radio block"><label><input type="radio" name="airport_pickup_homestay" value="1" <?php if($student['two']['airport_pickup']=='1'){echo 'checked';}?>> Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="airport_pickup_homestay" value="0"  <?php if($student['two']['airport_pickup']=='0'){echo 'checked';}?>> No</label></div>
                            </div>
                            </div>
                    <?php } ?>
                    
					<div id="apuOptionsDiv" <?php if($student['two']['airport_pickup']=='0'){?>style="display:block;"<?php }?>>
					  <div class="form-group" style="clear:both;">
						  <label class="control-label">Select APU company</label><br />
							  <select class="form-control" id="selectAPUCBookingPage" name="selectAPUCBookingPage" onchange="" required>
							  <option value="">Select APU company</option>
							  <?php foreach($apuCompanyList as $apuC){?>
                                  <option value="<?=$apuC['id']?>" <?php if($student['two']['apu_company']==$apuC['id']){echo 'selected';}?>><?=$apuC['company_name']?></option>
                              <?php } ?>
						  </select>
					  </div>
                      
                        <div class="form-group col-xs-6" style="padding-left:0;">
						  <label class="control-label">Arrival date</label>
							  <input type="text" class="form-control" id="apu_arrival_date" name="" value="<?php if($student['arrival_date']!='0000-00-00'){echo date('d/m/Y',strtotime($student['arrival_date']));}?>" onChange="" >
					  </div>
					 <div class="form-group col-xs-6" style="padding-right:0;">
						  <label for="" class="control-label">Arrival time</label>
						 <input type="text" class="form-control" id="apu_arrival_time" name=""  value="<?php if($student['two']['airport_arrival_time']!='00:00:00'){echo date('h:i A',strtotime($student['two']['airport_arrival_time']));}?>"  onChange="" >
					  </div>
                      <div class="form-group col-xs-6" style="padding-left:0;">
						  <label for="" class="control-label">Carrier(Airline)</label>
						 <input type="text" class="form-control" id="apu_airport_carrier" name=""  value="<?php echo $student['two']['airport_carrier'];?>"  onChange="" >
					  </div>
                      <div class="form-group col-xs-6" style="padding-right:0;">
						  <label for="" class="control-label">Flight number</label>
						 <input type="text" class="form-control" id="apu_arrival_flight_no" name=""  value="<?php echo $student['two']['airport_flightno'];?>"  onChange="" >
					  </div>
                  </div>    
				</form>
			</div>
                                  
       </div>
                              
		</div>
		
		<div class="family-details-all tab-pane panel panel-bluegraylight"  data-widget='{"draggable": "false"}'>
                           <div class="panel-heading">                                
                                      <h2>ADO INFO</h2>
                               </div>

                                    <div class="about-area panel-body">
                                  
                                  
				<form id="">
					<input type="hidden" name="did" value="" />
					 
                     <div class="m-n form-group">
					<label class="control-label">Airport dropoff?</label><br />
					<div class="col-sm-8">
						<div class="radio block"><label><input type="radio" name="airport_dropoff" value="1" <?php if($student['two']['airport_dropoff']=='1'){echo 'checked';}?>> Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="airport_dropoff" value="0"  <?php if($student['two']['airport_dropoff']=='0'){echo 'checked';}?>> No</label></div>
					</div>
				    </div>
					<div id="apudropOptionsDiv" <?php if($student['two']['airport_dropoff']=='0'){?>style="display:none;"<?php }?>>
					  <div class="form-group" style="clear:both;">
						  <label class="control-label">Select ADO company</label><br />
							  <select class="form-control" id="apu_drop_company" name="apu_drop_company" onchange="" required>
							  <option value="">Select ADO company</option>
							  <?php foreach($apuCompanyList as $apuC){?>
                                  <option value="<?=$apuC['id']?>" <?php if($student['two']['apu_drop_company']==$apuC['id']){echo 'selected';}?>><?=$apuC['company_name']?></option>
                              <?php } ?>
						  </select>
					  </div>
                      
                        <div class="form-group col-xs-6" style="padding-left:0;">
						  <label class="control-label">Departure date</label>
							  <input type="text" class="form-control" id="airport_departure_date" name="" value="<?php if($student['two']['airport_departure_date']!='0000-00-00'){echo date('d/m/Y',strtotime($student['two']['airport_departure_date']));}?>" onChange="" >
					  </div>
					 <div class="form-group col-xs-6" style="padding-right:0;">
						  <label for="" class="control-label">Departure time</label>
						 <input type="text" class="form-control" id="airport_departure_time" name=""  value="<?php if($student['two']['airport_departure_time']!='00:00:00'){echo date('h:i A',strtotime($student['two']['airport_departure_time']));}?>"  onChange="" >
					  </div>
                      <div class="form-group col-xs-6" style="padding-left:0;">
						  <label for="" class="control-label">Carrier(Airline)</label>
						 <input type="text" class="form-control" id="airport_drop_carrier" name=""  value="<?php if($student['two']['airport_drop_carrier']){echo $student['two']['airport_drop_carrier'];}?>"  onChange="" >
					  </div>
                      <div class="form-group col-xs-6" style="padding-right:0;">
						  <label for="" class="control-label">Flight number</label>
						 <input type="text" class="form-control" id="airport_drop_flightno" name=""  value="<?php if($student['two']['airport_drop_flightno']){echo $student['two']['airport_drop_flightno'];}?>"  onChange="" >
					  </div>
                  </div>    
				</form>
					</div>
					
					</div>
		
  <?php // }  ?>                
 
 <?php $this->load->view('system/booking/transportInfoBox');?>          
 <?php $this->load->view('system/booking/holdPaymentBox');?>
 
 </div>


<div class="col-md-4">
                
                <div class="family-details-all tab-pane panel panel-bluegraylight"  data-widget='{"draggable": "false"}'>
                           <div class="panel-heading">                                
                                      <h2>Profile Check List</h2>
                               </div>

                                    <div class="about-area panel-body">
                                  <div class="table-responsive">
                                      
                                      <table class="table about-table">
                                          <tbody>
										  <?php   $sd = []; $sd2 = []; $sd3=array(); ?>
										  <?php foreach($profilechecklist as $k=>$val){ ?>
										  <?php if(!empty($profilelist)) {
											  foreach($profilelist as $val1){
												 
												  if (@$val1['type'] == $k) {
											  $sd[$k] = "matchStatusGreen";
											  $sd2[$k] = "profile sent";
											  $sd3[$k] = $val1['id'];
																				  

											  }
											  }
											  

										  }?>
										  <?php if($k=='student_profile'){ 
										  $studentProfileType='standard';
										  $ageStudent=age_from_dob($student['dob']);
										  if($ageStudent<18)
										  {
											  if(trim($student['three']['college'])!='' && trim($student['three']['college_group'])!='' && in_array(trim($student['three']['college_group']),['pbs_nsw','pbs_vic','pbs_nt']))
														$studentProfileType='studentProfile-U18-PublicSchool';
											  else
												{
													if($student['two']['guardianship']=='1' && $student['two']['guardian_assigned']=='9')
														$studentProfileType='studentProfile-U18-Host-Caregiver';
													else
														$studentProfileType='studentProfile-U18-Host-Not-Caregiver';
												}
										  }
										  
										  ?>
                                              <tr>
                                                  <td>
                                                  <span class="icon booking-icon-check"><i class="material-icons">face</i></span>
                                                  	<?php if($studentProfileType=='standard'){?>
							                       		<span class="booking-icon-check-name">Student profile standard</span>
                                                   <?php }elseif($studentProfileType=='studentProfile-U18-PublicSchool'){?>
							                       		<span class="booking-icon-check-name">Student profile for U18 public high school</span>
                                                   <?php }elseif($studentProfileType=='studentProfile-U18-Host-Caregiver'){?>
                                                   		<span class="booking-icon-check-name">Student profile U18 with host as the caregiver</span>
                                                   <?php }elseif($studentProfileType=='studentProfile-U18-Host-Not-Caregiver'){?>
                                                   		<span class="booking-icon-check-name">Student profile for U18 without host as the caregiver</span>
                                                   <?php } ?>
                                                   <span class="icon student_profile" style="float:right; margin-top:5px;"  onClick="getprofiledetail('student_profile',<?=$booking['id']?>,<?=!empty($sd3[$k])? $sd3[$k] :'' ?>);"data-placement="bottom"   data-toggle="tooltip" data-eid="<?=!empty($sd3[$k])? $sd3[$k] :'' ?>" data-original-title="<?=!empty($sd2[$k])? $sd2[$k] :'Click to mark it sent' ?>"><i id="student_profile" style="font-size:16px; line-height:0;" class="fa fa-check <?=!empty($sd[$k])? $sd[$k] :'matchStatusGrey' ?>" data-toggle="modal" data-target="#model_bookingSendProfile"></i></span>
                                                   <span class="icon " style="float:right; margin-top:5px;cursor:pointer; margin-right: 10px;" onClick="generateProfile('student_profile',<?=$booking['id']?>);"><i style="font-size:16px; line-height:0;" class="fa fa-download "></i></span>
                                                  </td>
                                              </tr> 
										  <?php }else if($k=='hostFamily_profile'){?>
                                               <tr>
                                                  <td>
                                                  <span class="icon booking-icon-check"><i class="material-icons">home</i></span>
							                       <span class="booking-icon-check-name">Host family profile <?php if(trim($student['three']['college'])!=''){if(trim($student['three']['college_group'])!='' && in_array(trim($student['three']['college_group']),['pbs_nsw','pbs_vic','pbs_nt'])){ echo '- Public high school';}}?></span>
                                                  <span class="icon hostFamily_profile" style="float:right; margin-top:5px;" onClick="getprofiledetail('hostFamily_profile',<?=$booking['id']?>,<?=!empty($sd3[$k])? $sd3[$k] :'' ?>);" data-placement="bottom"   data-toggle="tooltip" data-eid="<?=!empty($sd3[$k])? $sd3[$k] :'' ?>"  data-original-title="<?=!empty($sd2[$k])? $sd2[$k] :'Click to mark it sent' ?>"><i  id="hostFamily_profile" style="font-size:16px; line-height:0;" class="fa fa-check <?=!empty($sd[$k])? $sd[$k] :'matchStatusGrey' ?>" data-toggle="modal" data-target="#model_bookingSendProfile"></i></span>
                                                    <span class="icon" style="float:right; margin-top:5px; cursor:pointer; margin-right: 10px;"onClick="generateProfile('hostFamily_profile',<?=$booking['id']?>);"><i style="font-size:16px; line-height:0;" class="fa fa-download "></i></span>
                                                  </td>
                                              </tr>  
										  <?php } //elseif($k=='Apu_profile' && $student['study_tour_id']==0){
											  elseif($k=='Apu_profile' ){
											  ?>
                                              
                                                <tr>
                                                  <td>
                                                  <span class="icon booking-icon-check"><i class="material-icons">flight</i></span>
												  <?php 

												  //if($student['two']['airport_pickup']=='1'){?>
							                       <span class="booking-icon-check-name" id="apuProfileDLink" >APU profile</span>
												    <span class="icon apuprofile Apu_profile" style="float:right; margin-top:5px;" data-placement="bottom" onClick="getprofiledetail('Apu_profile',<?=$booking['id']?>,<?=!empty($sd3[$k])? $sd3[$k] :'' ?>)"   data-toggle="tooltip" data-eid="<?=!empty($sd3[$k])? $sd3[$k] :'' ?>"  data-original-title="<?=!empty($sd2[$k])? $sd2[$k] :'Click to mark it sent' ?>"><i id="Apu_profile" style="font-size:16px; line-height:0;" class="fa fa-check <?=!empty($sd[$k])? $sd[$k] :'matchStatusGrey' ?>" data-toggle="modal" data-target="#model_bookingSendProfile"></i></span>
												  <?php } //elseif($k=='No_Apu_profile' && $student['study_tour_id']==0){
													  elseif($k=='No_Apu_profile' ){
													  ?>
												   <span class="booking-icon-check-name" id="noapuProfileDLink" >No APU requested profile</span>
												    <span class="icon noapuprofile No_Apu_profile" style="float:right; margin-top:5px;" data-placement="bottom"  data-toggle="tooltip" onClick="getprofiledetail('No_Apu_profile',<?=$booking['id']?>,<?=!empty($sd3[$k])? $sd3[$k] :'' ?>);"  id="No_Apu_profile" data-toggle="tooltip" data-eid="<?=!empty($sd3[$k])? $sd3[$k] :'' ?>" data-original-title="<?=!empty($sd2[$k])? $sd2[$k] :'Click to mark it sent' ?>"><i id="No_Apu_profile" style="font-size:16px; line-height:0;" class="fa fa-check <?=!empty($sd[$k])? $sd[$k] :'matchStatusGrey' ?>" data-toggle="modal" data-target="#model_bookingSendProfile"></i></span>
			
												  
                                                   <span class="icon apucom" style="float:right; margin-top:5px; cursor:pointer; margin-right: 10px;" onClick="generateProfile('apu_profile',<?=$booking['id']?>);"><i style="font-size:16px; line-height:0;" class="fa fa-download "></i></span>
												   
												   <span class="icon noapucom" style="float:right; margin-top:5px; cursor:pointer; margin-right: 10px;" ><i style="font-size:16px; line-height:0;" class="fa fa-download "></i></span>
												   
												   
												  </td>
                                              </tr>  
										  <?php } //elseif($k=='dropoff_profile' && $student['study_tour_id']==0 ){
											  elseif($k=='dropoff_profile'  ){
											  ?>

										  <tr>
                                                  <td class="dropoffapu" <?php if($student['two']['airport_dropoff']=='0'){?>style="display:none;"<?php }?>>
                                                  <span class="icon booking-icon-check"><i class="material-icons">flight_takeoff</i></span>
							                       <span class="booking-icon-check-name">Drop off  profile</span>
                                                  <span class="icon dropoff_profile" style="float:right; margin-top:5px;" onClick="getprofiledetail('dropoff_profile',<?=$booking['id']?>,<?=!empty($sd3[$k])? $sd3[$k] :'' ?>);" data-placement="bottom"   data-toggle="tooltip" data-eid="<?=!empty($sd3[$k])? $sd3[$k] :'' ?>"  data-original-title="<?=!empty($sd2[$k])? $sd2[$k] :'Click to mark it sent' ?>"><i  id="dropoff_profile" style="font-size:16px; line-height:0;" class="fa fa-check <?=!empty($sd[$k])? $sd[$k] :'matchStatusGrey' ?>" data-toggle="modal" data-target="#model_bookingSendProfile"></i></span>
                                                    <span class="icon errorhide" style="float:right; margin-top:5px; cursor:pointer; margin-right: 10px;<?php if(empty($student['two']['apu_drop_company'])){?>display:none;<?php }?>"onClick="generateProfile('dropoff_profile',<?=$booking['id']?>);"><i style="font-size:16px; line-height:0;" class="fa fa-download "></i></span>
                                                  <span class="icon errorshow" style="float:right; margin-top:5px; cursor:pointer; margin-right: 10px; <?php if(!empty($student['two']['apu_drop_company'])){?>display:none;<?php }?>"><i style="font-size:16px; line-height:0;" class="fa fa-download "></i></span>
												 </td>
                                              </tr>  
										  <?php } }?>
                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                           
                           
                          
                            
                            
                           
		</div>
                
 <?php 
 /*$clientDetail=clientDetail($student['client']);
 $notGroupInvClient=true;
 if($clientDetail['group_invoice']=='1' && ($clientDetail['group_invoice_placement_fee']=='1' || $clientDetail['group_invoice_apu']=='1' || $clientDetail['group_invoice_accomodation_fee']=='1'))
	 $notGroupInvClient=false;*/
 if($student['study_tour_id']==0 /*&& $notGroupInvClient*/){
	  $this->load->view('system/booking/holidaysBox');
 } ?>      

      <?php
        if($student['homestay_nomination']=='1' && $host['id']==$student['nominated_hfa_id'])
		{
		?>
        <div class="family-details-all tab-pane panel panel-bluegraylight"  data-widget='{"draggable": "false"}'>
                           <div class="panel-heading">                                
                                      <h2>Homestay nomination</h2>
                               </div>

                                    <div class="about-area panel-body">
                                  <p>This is a nominated host family booking</p>
                                  <div>
				<form id="generatePoOptionForm">
					<div class="checkbox checkbox-primary">
							<label>
								<input type="checkbox" name="generatePoOption" onclick="generatePoBookingOption();" value="1" <?php if($booking['generate_po']=='0'){?>checked="checked"<?php }?>>
                                <input type="hidden" name="generatePoOption_booking_id" value="<?=$booking['id']?>">
								Do not generate purchase orders for this booking
							</label>
						</div>
                       <div class="checkbox checkbox-primary">
							<label>
								<input type="checkbox" name="generateOngInvOption" onclick="generatePoBookingOption();" value="1" <?php if($booking['generate_ongInv']=='0'){?>checked="checked"<?php }?>>
                                Do not generate ongoing invoices for this booking
							</label>
						</div> 
				</form>
			</div>
                                  
       </div>
                              
		</div>
    <?php } ?>    
        
     <?php
	 if($student['study_tour_id']==0)
		 $this->load->view('system/booking/checkupsBox');
	 ?>
 </div>
 
 
 
 <!--<div class="col-md-4">
                
                <div class="family-details-all tab-pane panel panel-bluegraylight"  data-widget='{"draggable": "false"}'>
                           <div class="panel-heading">                                
                                      <h2>College Information</h2>
                               </div>

                                    <div class="about-area panel-body">
                                  
                                  <div>
				<form id="">
					<input type="hidden" name="id" value="" />
					  <div class="m-n form-group">
						  <label class="control-label">Select college</label>
							  <select class="form-control" id="officeUse-changeClient" name="client" onchange="officeUseChangeAttrFormSubmit_changeClient();">
							  <option value="">Select client</option>
								  <?php foreach($clientsList as $cLK=>$cLV){?>
                                          <option value="<?=$cLV['id']?>" ><?=$cLV['bname']?></option>
                                <?php } ?>
						  </select>
					  </div>
                      <div class="panel-body" style="background:hsl(195, 12%, 94%);">
					  <div class="form-group">
						  <label for="officeUse-changeEmployee" class="control-label">College / Institution name</label>
						 <input type="text" class="form-control" id="" name=""  value=""  onChange="" >
					  </div>
                      <div class="form-group">
						  <label for="officeUse-changeEmployee" class="control-label">Campus</label>
						 <input type="text" class="form-control" id="" name=""  value=""  onChange="" >
					  </div>
                      <div class="form-group">
						  <label for="officeUse-changeEmployee" class="control-label">Address</label>
						 <input type="text" class="form-control" id="" name=""  value=""  onChange="" >
					  </div>
                      </div>
				</form>
			</div>
                                  
       </div>
                              
		</div>
                
 
 </div>-->


                <!--11111111111111111-->
           </div>
                                <!--tab 1 content #ENDS-->
                                
                       </div>
						<div class="tab-pane" id="tab-8-2">								
							<?php $this->load->view('system/booking/poAndInvoiceList');?>
						</div>
						
					</div>
        
            
       </div>
    </div>
</div>


<!--Send profile pop up #STARTS-->
<div class="modal fade" id="model_bookingSendProfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h2 class="modal-title">Profile sending information</h2>
      </div>
      <div class="modal-body">
        <form id="profilechecklist_form">
        
        
        
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-raised" id="profilechecklist_formSubmit" data-dismiss="modal" aria-hidden="true">Submit</button>
        <img src="<?=loadingImagePath()?>" id="shaChangeStatusProcess" style="margin-right:16px;display:none;">
        <button data-bb-handler="danger" type="button" class="ml5 btn btn-default" data-dismiss="modal" style="display:none;" id="shaChangeStatusClose">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
</div>
<!--Send profile pop up #ENDS-->

<?php $this->load->view('system/booking/editBookingPopUp');?>

<script type="text/javascript">
$(document).ready(function(){
	
	//booking placed success msg
		var tabToOpen=window.location.hash;
		if(tabToOpen=='#bookingPlaced')
			{
			notiPop('success','Booking placed successfully',"");
			//window.location.hash='';
			history.pushState('', document.title, window.location.pathname);
			}
		//booking placed success msg
	
	
	<?php if($student['two']['airport_pickup']==1){?>
	//alert("xcxz");
		$("#apuProfileDLink").show();
		$(".apuprofile").show();
	$("#noapuProfileDLink").hide();
	$(".noapuprofile").hide();
	//$(".apucom").hide();
	//$(".noapucom").hide();
	<?php if(!empty($student['two']['apu_company'])){?>
	
	$(".apucom").show();
	$(".noapucom").hide();
	<?php }else{ ?>
		$(".apucom").hide();
		$(".noapucom").show();
	<?php }}else{ ?>
	$("#apuProfileDLink").hide();
		$(".apuprofile").hide();
	$("#noapuProfileDLink").show();
	$(".noapuprofile").show();
	$(".noapucom").show();
		$(".apucom").hide();
	<?php  }?>
	<?php if(!empty($student['two']['apu_company']) && ($student['two']['airport_pickup']==1)){ ?>
$(".apucom").show();
$(".noapucom").hide();
	<?php } else if($student['two']['airport_pickup']==0){?>
	$(".apucom").show();
$(".noapucom").hide();
	<?php  }?>
	$("span.icon.noapucom").on("click",function(){
		
		notiPop('error','Select APU company',"");
		$('#selectAPUCBookingPage').parsley().validate();
		
		

	})
	$(".errorshow").on("click",function(){
		
		notiPop('error','Select ADO company',"");
		$('#apu_drop_company').parsley().validate();
		

	})
	
	$('#booking_holidayEndDate, #apu_arrival_date,#airport_departure_date').datepicker({
			orientation: "top",
			todayHighlight: true,
	    	startDate: "-0d",
			format:'dd/mm/yyyy',
			autoclose:true
		});
	
	$('#apu_arrival_time,#airport_departure_time').timepicker({minuteStep: 5,defaultTime:false});
	
	$('#apu_drop_company').change(function(){
		
		var apuCompanyId=$(this).val();
				$.ajax({
					url:'<?=site_url()?>booking/selectdropApuCompany',
					type:'POST',
					data:{sha_id:'<?=$booking['student']?>',apuCompanyId:apuCompanyId},
					success:function(data)
								{
									if(apuCompanyId!=''){
										$(".errorshow").hide();
									$(".errorhide").show()
										
									}else{
									$(".errorshow").show();
									$(".errorhide").hide();
									}
									notiPop('success','ADO  company assigned successfully',"");
								}
								
				});
	})
		
	$('#selectAPUCBookingPage').change(function(){
				
				var apuCompanyId=$(this).val();
				$.ajax({
					url:'<?=site_url()?>booking/selectApuCompany',
					type:'POST',
					data:{sha_id:'<?=$booking['student']?>',apuCompanyId:apuCompanyId},
					success:function(data)
								{
									var apuRadio=$('input[name=airport_pickup]:checked').val();
									if(apuRadio!='1')
									{
										$(".apucom").show();
										$(".noapucom").hide();
									}
									else
									{
											notiPop('success','APU company assigned successfully',"");
											//alert(apuCompanyId);
											if(apuCompanyId!=''){										
											$(".apucom").show();
											$(".noapucom").hide();
											//$("div#apuprofileselcomp").html('<span class="icon apucom" style="float:right; margin-top:5px; cursor:pointer; margin-right: 10px;" onClick="generateProfile("apu_profile","<?=$booking['id']?>");><i style="font-size:16px; line-height:0;" class="fa fa-download "></i></span>');
											}else{
											$(".apucom").hide();
											$(".noapucom").show();
											}
											//$("div#apuprofileselcomp").html('<span class="icon noapucom" style="float:right; margin-top:5px; cursor:pointer; margin-right: 10px;");><i style="font-size:16px; line-height:0;" class="fa fa-download "></i></span>');
									}
								}
				});
				
			});
			
		$('#selectAPUOptionBookingPage').change(function(){
				
				var apuOption=$(this).val();
				$.ajax({
					url:'<?=site_url()?>booking/selectApuOption',
					type:'POST',
					data:{sha_id:'<?=$booking['student']?>',apuOption:apuOption},
					success:function(data)
								{
									window.location.reload();
								}
				});
				
			});
			 $('input[name=airport_dropoff]').click(function(){
				  var apuRadio=$(this).val();
				  if(apuRadio=='1')
				  {
					  
					  $("#apudropOptionsDiv").show();
					  $(".dropoffapu").show();
					  var dc=$("#apu_drop_company").val();
					  if(dc!=''){
					  $(".errorshow").hide();
						$(".errorhide").show();
					  }else{
						   $(".errorshow").show();
						$(".errorhide").hide();
					  }
				  }else{
					   $("#apudropOptionsDiv").hide();
					   $(".dropoffapu").hide();
				  }
				  $.ajax({
						url:'<?=site_url()?>booking/apudropUpdate',
						data:{sha_id:'<?=$student['id']?>',apuOption:apuRadio},
						type:'POST',
						success:function(data)
							{
								if(data=='LO')
									redirectToLogin();
								else	
									notiPop('success','ADO  info updated successfully',"");
						
								
							}
					});
			 })
		  
		  $('input[name=airport_pickup]').click(function(){
				  var apuRadio=$(this).val();
				  if(apuRadio=='1')
				  {
				  	$('#apuOptionsDiv').show();
					$("#apuProfileDLink").show();
					$(".apuprofile").show();
				$("#noapuProfileDLink").hide();
				$(".noapuprofile").hide();
				var c=$("#selectAPUCBookingPage").val();
				if(c!=''){
					$(".apucom").show();
				$(".noapucom").hide();
				}else{
						$(".apucom").hide();
				$(".noapucom").show();
				}
				  }
				  else	
				  {
					$('#apuOptionsDiv').show();
					$("#apuProfileDLink").hide();
		$(".apuprofile").hide();
	$("#noapuProfileDLink").show();
	$(".noapuprofile").show();
	$(".apucom").show();
	$(".noapucom").hide();
				  }
					
					$.ajax({
						url:'<?=site_url()?>booking/apuUpdate',
						data:{sha_id:'<?=$student['id']?>',apuOption:apuRadio},
						type:'POST',
						success:function(data)
							{
								if(data=='LO')
									redirectToLogin();
								else	
									notiPop('success','APU info updated successfully',"");
						
								
							}
					});
			 });
			 
			 
			 $('#apu_arrival_date').change(function(){
					
					var arrival_date=$(this).val();
					$.ajax({
						url:'<?=site_url()?>booking/arrivalDateUpdate',
						data:{sha_id:'<?=$student['id']?>',arrival_date:arrival_date},
						type:'POST',
						success:function(data)
							{
								if(data=='LO')
									redirectToLogin();
								else	
									notiPop('success','Arrival date updated successfully',"");
							}
					});
				
			});
			
			 $('#airport_departure_date').change(function(){
					
					var arrival_date=$(this).val();
					$.ajax({
						url:'<?=site_url()?>booking/departureDateUpdate',
						data:{sha_id:'<?=$student['id']?>',arrival_date:arrival_date},
						type:'POST',
						success:function(data)
							{
								if(data=='LO')
									redirectToLogin();
								else	
									notiPop('success','Departure date updated successfully',"");
							}
					});
				
			});
			
			$('#airport_departure_time').change(function(){
				
					var arrival_time=$(this).val();
					$.ajax({
						url:'<?=site_url()?>booking/departureTimeUpdate',
						data:{sha_id:'<?=$student['id']?>',arrival_time:arrival_time},
						type:'POST',
						success:function(data)
							{
								if(data=='LO')
									redirectToLogin();
								else	
									notiPop('success','Departure time updated successfully',"");
							}
					});
				
			});
			
			$('#apu_arrival_time').change(function(){
				
					var arrival_time=$(this).val();
					$.ajax({
						url:'<?=site_url()?>booking/arrivalTimeUpdate',
						data:{sha_id:'<?=$student['id']?>',arrival_time:arrival_time},
						type:'POST',
						success:function(data)
							{
								if(data=='LO')
									redirectToLogin();
								else	
									notiPop('success','Arrival time updated successfully',"");
							}
					});
				
			});
			
			$('#apu_airport_carrier').change(function(){
				
					var airport_carrier=$(this).val();
					$.ajax({
						url:'<?=site_url()?>booking/airportCarrierUpdate',
						data:{sha_id:'<?=$student['id']?>',airport_carrier:airport_carrier},
						type:'POST',
						success:function(data)
							{
								if(data=='LO')
									redirectToLogin();
								else	
									notiPop('success','Carrier(Airline) updated successfully',"");
							}
					});
				
			});
			
			$('#airport_drop_carrier').change(function(){
				
					var airport_carrier=$(this).val();
					$.ajax({
						url:'<?=site_url()?>booking/airportdropCarrierUpdate',
						data:{sha_id:'<?=$student['id']?>',airport_carrier:airport_carrier},
						type:'POST',
						success:function(data)
							{
								if(data=='LO')
									redirectToLogin();
								else	
									notiPop('success','Carrier(Airline) updated successfully',"");
							}
					});
				
			});
			
			$('#airport_drop_flightno').change(function(){
				
					var airport_flightno=$(this).val();
					$.ajax({
						url:'<?=site_url()?>booking/airportdropFlightNoUpdate',
						data:{sha_id:'<?=$student['id']?>',airport_flightno:airport_flightno},
						type:'POST',
						success:function(data)
							{
								if(data=='LO')
									redirectToLogin();
								else	
									notiPop('success','Flight number updated successfully',"");
							}
					});
				
			});
			
			$('#apu_arrival_flight_no').change(function(){
				
					var airport_flightno=$(this).val();
					$.ajax({
						url:'<?=site_url()?>booking/airportFlightNoUpdate',
						data:{sha_id:'<?=$student['id']?>',airport_flightno:airport_flightno},
						type:'POST',
						success:function(data)
							{
								if(data=='LO')
									redirectToLogin();
								else	
									notiPop('success','Flight number updated successfully',"");
							}
					});
				
			});
			
			
			$('#bookingNotes_viewPage').change(function(){
					
					$.ajax({
						url:'<?=site_url()?>booking/updateBookingNotes',
						type:'POST',
						data:$('#updateBookingNotesForm').serialize(),
						success:function(data)
							{
								if(data=='LO')
									redirectToLogin();
								else
									notiPop('success','Booking notes updated successfully',"");
							}
					});
					
			});
			$("#profilechecklist_formSubmit").click(function(){
				var eid=$("#employee-account").val();
				var bid=$("#bookid").val();
				var formdata=$('#profilechecklist_form').serialize();
				$.ajax({
						url:'<?=site_url()?>booking/saveprofilechecklist',
						type:'POST',
						data:formdata,
						success:function(data)
							{
								$("#profilechecklist_formSubmit").hide();
							//	$('.'+data).attr('onclick', 'getprofiledetail('+data+','+bid+','+eid+')');
								
								$('.'+data).attr('data-original-title', 'profile sent');
								$('.'+data).attr('data-eid', eid);
								$("i#"+data).removeClass("matchStatusGrey");
								$("i#"+data).addClass("matchStatusGreen");
								if(data=='student_profile')
									var msg="Student homestay profile";
								else if(data=='hostFamily_profile')
									var msg="Host family profile";
								else if(data=='Apu_profile')
									var msg="Apu profile";
								else if(data=='No_Apu_profile')
									var msg="No APU requested profile";
								else if(data=='dropoff_profile')
									var msg="Drop off  profile";
								notiPop('success',msg+' '+'marked as sent.',"");
	
							}
					});
				

			})
			
			
			
		$('input[name=family_pickup_meeting_point],input[name=airport_pickup_meeting_point],input[name=airport_pickup_homestay]').click(function(){
				
				var apuRadioFamily=$('input[name=family_pickup_meeting_point]:checked').val();
				var apuRadioAirport=$('input[name=airport_pickup_meeting_point]:checked').val();
				var apuRadio=$('input[name=airport_pickup_homestay]:checked').val();
				
				
				$('#apuOptionsDiv').show();

				if(apuRadioAirport=='1' || apuRadio=='1')
				{
					$("#apuProfileDLink, .apuprofile").show();
					$("#noapuProfileDLink, .noapuprofile").hide();
				
					var c=$("#selectAPUCBookingPage").val();
					if(c!='')
					{
						$(".apucom").show();
						$(".noapucom").hide();
					 }
					 else
					 {
						$(".apucom").hide();
						$(".noapucom").show();
					  }
				}
				else
				{
					$("#apuProfileDLink, .apuprofile, .noapucom").hide();
					$("#noapuProfileDLink, .noapuprofile, .apucom").show();
				}
				
				
				$.ajax({
						url:'<?=site_url()?>booking/apuStUpdate',
						data:{sha_id:'<?=$student['id']?>',apuRadioFamily:apuRadioFamily,apuRadioAirport:apuRadioAirport,apuRadio:apuRadio},
						type:'POST',
						success:function(data)
							{
								if(data=='LO')
									redirectToLogin();
								else	
									notiPop('success','APU info updated successfully',"");
							}
					});
			
		});
});		
function getprofiledetail(type,id,eid){
	$("#shaChangeStatus_form").html('');
	//$("#profilechecklist_formSubmit").show();
	//var eid=$('.'+type).data('eid');
	
	$.ajax({
						url:'<?=site_url()?>booking/getprofilechecklistform',
						type:'POST',
						data:{'type':type,'id':id,'eid':eid},
						success:function(data)
							{
								
								
									$("#profilechecklist_form").html(data);
									var eid=$("#employee-account").val();
									if(eid)
										$("#profilechecklist_formSubmit").hide();
									else
										$("#profilechecklist_formSubmit").show();
							}
					});
	

}
		
function generateProfile(type,id)
{
	window.open(
		  '<?=site_url()?>GenerateProfile/'+type+'/'+id,
		  '_blank' 
		);		
}

</script>