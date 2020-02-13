 <?php
$stateList=stateList();
$nationList=nationList();
$nameTitleList=nameTitleList();
$genderList=genderList();
$smokingHabbits=smokingHabbits();

$religionList=religionList();
$languageList=languageList();
$languagePrificiencyList=languagePrificiencyList();
$geRefList=geRefList();
$accomodationTypeList=accomodationTypeList();
$guardianshipTypeList=guardianshipTypeList();
$age=age_from_dob($formOne['dob']) ;
/*if(!empty($formOne['nominated_hfa_id']))
$nominatedfamilyname =nominatedfmailyname($formOne['nominated_hfa_id']);*/

$homestayChooseReasonList=homestayChooseReasonList();

$officeList=officeList();
$employeeList=employeeList();
$clientsList=clientsList();
$clientGroupList=clientGroupList();
$clientsListshause=clientsListshause();
$guardianList=guardianList();
$getCaregiverCompanyList=getCaregiverCompanyList();
$caregiverList=array();
if($formTwo['guardian_assigned']!=0)
{
	$caregiverDetails=getCaregiverDetail($formTwo['guardian_assigned']);
	$caregiverList=getCaregiversByCompany($caregiverDetails['company']);
}
	
if($formOne['booking_from']!='0000-00-00' && $formOne['booking_to']!='0000-00-00'){
	 $bfrom=date('Y-m-d',strtotime($formOne['booking_from']));
	 $bto=date('Y-m-d',strtotime($formOne['booking_to'].' +1 day')); 
	 $datediff = strtotime($bto) - strtotime($bfrom);

$totalDays=abs(round($datediff / (60 * 60 * 24)));
 // $totalDays=dayDiff($bfrom,$bto);
  $getWeekNDays=getWeekNDays($totalDays);
  //see($getWeekNDays);
}

$duplicateShaFirst=getDuplicateShaFirst($formOne['id'])
?>
<style type="text/css">
#officeUse-guardianship_endDate.form-control[readonly]{
	cursor:text;
}

.vHBookingDurationSha
{
	width: unset !important;text-align: unset !important;
}
.vHStudentNameSha
{
	width: unset !important;text-align: unset !important;font-weight: lighter !important;font-size: 11px !important;color: #bdbdbd !important;
}
.vHStudentNameSha:hover
{
	text-decoration: underline;
}
</style>

<div class="col-md-4">
	<div class="panel panel-profile panel-bluegraylight">
		<div class="panel-heading">
			<h2>Booking Details</h2>
		</div>
		<div class="panel-body">
			<div>
				<form id="updateShaBookingDatesForm">
					<input type="hidden" name="id" value="<?=$formOne['id']?>" />
					  <div class="m-n form-group">
						  <label class="control-label">From date</label>
							  <input type="text" class="form-control" id="shaBooking_startDate" name="shaBooking_startDate" value="<?php if($formOne['booking_from']!='0000-00-00'){echo date('d/m/Y',strtotime($formOne['booking_from']));}?>" onChange="updateShaBookingDates('from');" >
					  </div>
					  <div class="form-group">
						  <label for="shaBooking_endDate" class="control-label">To date</label>
						 <input type="text" class="form-control" id="shaBooking_endDate" name="shaBooking_endDate"  value="<?php if($formOne['booking_to']!='0000-00-00'){echo date('d/m/Y',strtotime($formOne['booking_to'].' +1 day'));}?>"  onChange="updateShaBookingDates('to');" >
					  </div>
					   <div class="form-group col-xs-6" style="padding-left: 0;">
						  <label for="shaBooking_week" class="control-label">Weeks</label>
						 <input type="text" class="form-control" id="shaBooking_week" data-parsley-type="number"  name="shaBooking_week"  value="<?=$formOne['weeks']?><?php //if(isset($getWeekNDays['week'])){echo $getWeekNDays['week'];}else{ echo 0;} ?>"   onChange="updateShaBookingDates('week');" >
					  </div>
					   <div class="form-group col-xs-6" style="padding-right: 0;">
						  <label for="shaBooking_day" class="control-label">Days</label>
						 <input type="text" class="form-control" data-parsley-type="number" id="shaBooking_day" name="shaBooking_day"  value="<?=$formOne['days']?><?php //if(isset($getWeekNDays['day'])){echo $getWeekNDays['day'];}else{ echo 0;} ?>"   onChange="updateShaBookingDates('day');" >
					  </div>
					  <!--<div class="row">
						  <div class="col-sm-8">
							  <input type="button" class="btn-raised btn-primary btn" id="updateShaBookingDatesSubmit" value="Update" onclick="updateShaBookingDates();">
							  <img src="<?=loadingImagePath()?>" id="updateShaBookingDatesProcess" style="display:none;">
						  </div>
					  </div>-->
					  <input type="hidden" id="oldweek" value="<?php if(isset($getWeekNDays['week'])){echo $getWeekNDays['week'];}else{ echo 0;} ?>"/>
					  <input type="hidden" id="oldday" value="<?php if(isset($getWeekNDays['day'])){echo $getWeekNDays['day'];}else{ echo 0;} ?>"/>
				</form>
			</div>
		</div>
	</div>
    
    <div class="panel panel-profile panel-bluegraylight">
        <div class="panel-heading">
            <h2>Student number</h2>
        </div>
        <div class="panel-body">
           <form id="updateShastudentnoForm">
                <input type="hidden" name="id" value="<?=$formOne['id']?>" />
				<div class="m-n form-group">
					<label class="control-label">Enter student college id/number</label>
					<input type="text" class="form-control" id="sha_studentid" name="sha_studentid" value="<?php echo @$formOne['sha_student_no'];?>"/>
					
				</div>
			</form>
        </div>
    </div>
    
    <?php if($age<18 && !empty($formTwo)){?>
    <div class="panel panel-profile panel-bluegraylight">
        <div class="panel-heading">
            <h2>Caregiving details</h2>
        </div>
        <div class="panel-body">
           <form id="guardianshipOfficeUseFormSubmit">
                <input type="hidden" name="id" value="<?=$formOne['id']?>" />
                <input type="hidden" id="accomodation_typeGOUFS" value="<?=$formOne['accomodation_type']?>" />
                <div class="m-n form-group">
					<label class="control-label">Caregiving required?</label><br />
					<div class="col-sm-8">
						<div class="radio block"><label><input type="radio" name="guardianship" value="1" <?php if($formTwo['guardianship']=='1'){echo "checked";}?>> Yes</label></div>
						<div class="radio block"><label><input type="radio" name="guardianship" value="0" <?php if($formTwo['guardianship']=='0'){echo "checked";}?>> No</label></div>
					</div>
				</div>
                <div style="clear: both;"> </div>
				<div class="m-n form-group" id="officeUse-guardian_assignedDiv" <?php if($formTwo['guardianship']!='1'){echo 'style="display:none;"';}?>>
                <label class="control-label">Caregiver company</label>
					<select class="form-control CGCclass" id="officeUse-CGC" onchange="getCGListShaOfficeusePage(this.value);">
                        <option value="">Select caregiver company</option>
                        <?php foreach($getCaregiverCompanyList as $cgc){
								$cg=getCaregiversByCompany($cgc['id']);
								if(empty($cg))
									continue;
							?>
                              <option value="<?=$cgc['id']?>" <?php if($formTwo['guardian_assigned']!=0 && $caregiverDetails['company']==$cgc['id']){echo 'selected="selected"';}?>><?=$cgc['name']?></option>
                        <?php } ?>
					</select>
                   
                <label class="control-label">Assign caregiver</label>
					<select class="form-control" id="officeUse-guardian_assigned" name="guardian_assigned">
                        <option value="">Select caregiver</option>
                        <?php foreach($caregiverList as $gLK=>$gLV){
							?>
                              <option value="<?=$gLV['id']?>" <?php if($formTwo['guardian_assigned']==$gLV['id']){echo 'selected="selected"';}?>><?=$gLV['fname'].' '.$gLV['lname']?></option>
                        <?php } ?>
					</select>
                    
                    <?php
						$guardianship_startDate='';
                     	if($formTwo['guardianship_startDate']!='0000-00-00')
					 		$guardianship_startDate=$formTwo['guardianship_startDate'];
						$guardianship_endDate=date('Y-m-d',strtotime($formOne['dob'].' + 18 years -1 day'));
                     	if($formTwo['guardianship_endDate']!='0000-00-00')
					 		$guardianship_endDate=$formTwo['guardianship_endDate'];	
					?>

					<?php 
                        $this->load->view('system/sha/CgDetailsDiv',$formTwo);
                    ?>

                       <div class="m-n form-group">
						  	  <label for="guardianship_startDate" class="control-label">Caregiving start date</label>
							  <input type="text" class="form-control" id="officeUse-guardianship_startDate" name="guardianship_startDate" value="<?php if($guardianship_startDate!=''){echo date('d/m/Y',strtotime($guardianship_startDate));}?>">
					  </div>
					  <div class="form-group">
						  <label for="guardianship_endDate" class="control-label">Caregiving end date</label>
						 <input type="text" class="form-control" id="officeUse-guardianship_endDate" name="guardianship_endDate"  value="<?=date('d/m/Y',strtotime($guardianship_endDate))?>" readonly="readonly" required>
					 <p class="text-default officeUse-guardianship-hint">Student turning 18 on <?=date('d M Y',strtotime($formOne['dob'].' + 18 years'))?></p>
                      </div>
					<p class="text-default officeUse-guardianship" id="officeUse-guardianshipDurationText"><?=guardianshipDurationOfficeUsePage($guardianship_startDate,$guardianship_endDate)?></p>
                </div>
			</form>
        </div>
    </div>

<?php } ?>

<?php $this->load->view('system/booking/incidentsBox');?>
<?php $this->load->view('system/booking/feedbacksBox');?>

</div>


<div class="col-md-4">
	<div class="panel panel-profile panel-bluegraylight">
		<div class="panel-heading">
			<h2>Ownership Details</h2>
		</div>
		<div class="panel-body">
			<div>
			<form id="officeUseChangeAttrForm">
			<input type="hidden" name="id" value="<?=$formOne['id']?>" />
				  
				  <div class="m-n form-group">
					  <label class="control-label">Assign client</label>
						  <select class="form-control" id="officeUse-changeClient" name="client" onchange="officeUseChangeAttrFormSubmit_changeClient();">
							  <option value="">Select client</option>
							  <?php foreach($clientsList as $cLK=>$cLV){?>
										  <option value="<?=$cLV['id']?>" <?php if($formOne['client']==$cLV['id']){echo 'selected="selected"';}?>><?=$cLV['bname']?></option>
									  <?php } ?>
						  </select>
                          <div id="clientDetailsDiv">
	                          <?php $this->load->view('system/sha/clientDetailsDiv');?>
                          </div>
				  	</div>
				  
				  <div class="form-group">
					  <label for="officeUse-changeEmployee" class="control-label">Assign employee</label>
					  <select name="employee" id="officeUse-changeEmployee" class="form-control" onchange="officeUseChangeAttrFormSubmit();" required>
						  <option value="">Select employee</option>
						  <?php foreach($employeeList as $eLK=>$eLV){?>
						  <option value="<?=$eLV['id']?>" <?php if($formOne['employee']==$eLV['id']){echo 'selected="selected"';}?>><?=ucwords($eLV['fname'].' '.$eLV['lname'])?></option>
					  <?php } ?>
					  </select>
				  </div>
			</form>
			</div>
		</div>
	</div>
    
    
    	<div class="panel panel-profile panel-bluegraylight">
		<div class="panel-heading">
			<h2>College Details</h2>
		</div>
		<div class="panel-body">
			<div>
            <?php
            $shaCollegeNameMatched=shaCollegeNameMatched($formOne['id']);
			if($shaCollegeNameMatched)
				$collegeNotMatching_alertMsgStyle='style="display:none;"';
			else
				$collegeNotMatching_alertMsgStyle='';	
			?>
            <label class="control-label colorOrange" id="collegeNotMatching_alertMsg" <?=$collegeNotMatching_alertMsgStyle?>>The college details below are provided by student. Please select the relevant college/institution from the Select College/institutions dropdown above.</label>
			<form id="Adddressstudentupdate">
			<input type="hidden" name="id" id="studentid" value="<?=$formOne['id']?>" />
				  <?php //see($clientsListshause);?>
				  
				  <div class="m-n form-group">
					  <label class="control-label">Select College/Institutions</label>
						  <select class="form-control" id="officeClient" name="client" >
							  <option value="">Select </option>
							  <?php foreach($clientsListshause as $cLK=>$cLV){
								  $row1='';
				$stringAddress='';
											  if(trim($cLV['suburb'])!='')
												  $stringAddress .=' '.trim($cLV['suburb']);
											  if(trim($cLV['state'])!='')
											  {
												  if($stringAddress!='')
													  $stringAddress .='*';
												  $stringAddress .=trim($cLV['state']);
											  }
											  if(trim($cLV['postal_code'])!='' && $cLV['postal_code']!='0')
											  {
												  //if($stringAddress!='')
													 // $stringAddress .='*';
												  
												  $stringAddress .=' '.trim($cLV['postal_code']);
											  }
					
			  
				  $row1 .= $cLV['street_address'];
				if($cLV['street_address']!='' && $stringAddress!='')
					$row1.=',';
					$row1.=str_replace('*',', ',$stringAddress);
			  //$add=$cLV['street_address'] .!empty($cLV['suburb']) ? ',' .$cLV['suburb'] :''.!empty($stateList[@$cLV['state']]) ? ','.$stateList[@$cLV['state']] :''.!empty($cLV['postal_code']) ? ','.$cLV['postal_code'] :'';								  
			  $add=$row1 ;
			  //$add.=!empty($cLV['suburb']) ? ',' .$cLV['suburb'] :'';
			  //$add.=!empty($stateList[@$cLV['state']]) ? ',' .$stateList[@$cLV['state']]:'';
			  //$add.=!empty($cLV['postal_code']) ? ',' .$cLV['postal_code']:'';
			  
			  ?>
										  <option data-college_group="<?php echo @$cLV['client_group']?>" data-bname="<?php echo @$cLV['bname']?>" data-sub="<?php  echo @$cLV['suburb']  ?>" data-add="<?php echo @$add ?>" value="<?=$cLV['id']?>" ><?=$cLV['bname']?></option>
									  <?php } ?>
						  </select>
				  </div>
                  
                  <div class="m-n form-group">
					  <label class="control-label">Select College/University group</label>
                      <input type="hidden" id="officeUse-college_group" name="college_group" value="<?=$formThree['college_group']?>" />
						  <select class="form-control" id="officeUse-college_group_disabled" name="college_group_disabled" disable>
							  <option value="">Select </option>
							  <?php foreach($clientGroupList as $clgGrpK=>$clgGrp){				 					 ?>
										  <option value="<?=$clgGrpK?>" <?php if($clgGrpK==$formThree['college_group']){?>selected<?php } ?>><?=$clgGrp?></option>
									  <?php } ?>
						  </select>
				  </div>
				  <div class="form-group">
					  <label for="officeUse-student_college" class="control-label">Name of College/Institutions</label>
					   
							  <input type="text" class="form-control" id="officeUse-student_college" name="student_college" value="<?php echo @$formThree['college']?>" readonly>
					  
				  </div>
				  
				  <div class="form-group">
					  <label for="officeUse-sha_student_campus" class="control-label">Campus</label>
					   
							  <input type="text" class="form-control" id="officeUse-sha_student_campus" name="sha_student_campus" value="<?php echo @$formThree['campus']?>" readonly>
					  
				  </div>
				  <div class="form-group">
					  <label for="officeUse-student_college_address" class="control-label">Address</label>
				  <textarea  class="form-control"  name="sha_student_college_address" id="officeUse-student_college_address" readonly><?php echo @$formThree['college_address']?></textarea>
				  </div>
							  
							  <img src="<?=loadingImagePath()?>" id="updateShaBookingaddressProcess" style="display:none;">

			</form>
			</div>
		</div>
	</div>
	
	<?php if($formTwo['ins_file']!="") {?>
	  <div class="panel panel-profile panel-bluegraylight">
		<div class="panel-heading">
		  <h2>Files</h2>
		</div>
		<div class="panel-body">
		  
           			<ul class="timeline " style="margin-top: 0 !important; margin-left: -24px ;">
                        <li style="padding-bottom: 0;" class="timeline-grey">
                              <div class="timeline-icon"><i class="material-icons">attach_file</i></div>
                              <div class="timeline-body shaInsFIlePrevLink">
                                  <div class="timeline-header">
                                          <span class="notes-list-head author" ><?='<a href="'.static_url().'uploads/sha/ins/'.$formTwo['ins_file'].'" target="_blank">Preview Insurance Policy</a>';?></span>
                                  </div>
                              </div>
                        </li>
                    </ul>

        </div>
	  </div>
	<?php } ?>
    
</div>





<div class="col-md-4">
    <div class="panel panel-profile panel-bluegraylight">
        <div class="panel-heading">
            <h2>Internal notes</h2>
        </div>
        <div class="panel-body">
           <form id="updateShaNotesForm">
                <input type="hidden" name="id" value="<?=$duplicateShaFirst?>" />
				<div class="m-n form-group">
					<label class="control-label">Any Special Requests or Notes</label>
					<textarea  rows="10" class="form-control" id="special_request_notes" name="special_request_notes"><?php echo $formOne['special_request_notes'];?></textarea>
				</div>
			</form>
        </div>
    </div>
 <?php if($formOne['study_tour_id']==0){
	  $this->load->view('system/booking/holidaysBox');
 } ?>      

    <div class="panel panel-profile panel-bluegraylight family-notes">
        <div class="panel-heading">
            <h2>STUDENT NOTES</h2>
        </div>
        <div class="panel-body">
		 <div class="row">
						  <div class="col-sm-8">
							  
							 <button class="btn-raised btn-primary btn btn-sm tyu" data-postid='' data-toggle="modal" data-id="<?=$duplicateShaFirst?>"  data-target="#model_hfafamilynote" >New Note</button>
							 
						  </div>
					  </div>
					  
					   <div class="widget referral-info-widget infobar" id="allhfanote">
					   <?php  $this->load->view('system/sha/allnote');?>
                
            </div>
			
           
        </div>
    </div>
    
    <div class="panel panel-profile panel-bluegraylight">
        <div class="panel-heading">
            <h2>Homestay nomination</h2>
        </div>
        
            <div class="panel-body">
            <?php
            if(!empty($formOne['nominated_hfa_id']))
            $nominatedfamilyname =nominatedfmailyname($formOne['nominated_hfa_id']);
            
            $bookingByShaId=bookingByShaId($formOne['id']);
            if(!empty($bookingByShaId) && $formOne['homestay_nomination']=='1' && $formOne['nominated_hfa_id']==$bookingByShaId['host'])
				$nominationAlertMsgStyle='';
			else
	            $nominationAlertMsgStyle='style="display:none;"';
            ?>
            <label class="control-label colorOrange" id="homestayNominationBoxSha_alertMsg" <?=$nominationAlertMsgStyle?>>A booking is already placed with this homestay nomination. So you cannot change the nominated host family in this application.</label>
            
                <form id="updateShaHNForm">
                <input type="hidden" name="id" value="<?=$formOne['id']?>" />
                    <div class="m-n form-group">
                    <label class="control-label">Has student nominated a host family?</label>
                        <div class="col-sm-8">
                            <div class="radio block"><label><input type="radio" name="homestayNomination" value="1" <?php if($formOne['homestay_nomination']=='1'){echo "checked";}?>> Yes</label></div>
                            <div class="radio block"><label><input type="radio" name="homestayNomination" value="0" <?php if($formOne['homestay_nomination']=='0'){echo "checked";}?>> No</label></div>
                        </div>
                    </div>
                </form>
            </div>

              <div class="panel-body nominatedfamilyfinfo" <?php if($formOne['homestay_nomination']!='1') {?> style="display:none;" <?php } ?> >
                  <form id="nominated_hfa_idform">
                      <input type="hidden" name="id" value="<?=$formOne['id']?>" />
                      <div class="m-n form-group">
                          <label class="control-label">Enter family id</label>
                          <input type="text" class="form-control" id="nominated_hfa_id" name="nominated_hfa_id" value="<?php echo !empty($formOne['nominated_hfa_id']) ? $formOne['nominated_hfa_id']  :'';?>"/>
                      </div>
                      <div class="m-n form-group">
                          <label class="control-label">Family contact name</label>
                          <input type="text" class="form-control" id="hostfamily_name" readonly value=" <?= @$nominatedfamilyname ?>"/>
                      </div>
                  </form>
              </div>                    
        
        <div id="homestayNominationBoxSha">
	        <?php $this->load->view('system/sha/homestayNominationBoxContent');?>
        </div>
    </div>
</div>



<div class="modal fade" id="model_hfafamilynote" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog" id="model_hfafamilynote_content">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								
								<h2 class="modal-title">Add New Note</h2>
							</div>
                            
                            <div class="modal-body">
                                <form id="updateHfaNotesFamilyForm">
               
			</form>   
	
			
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-success btn-raised" id="hfafamilynoteSubmit">Next</button>
                                <img src="<?=loadingImagePath()?>" id="hfafamilynote" style="margin-right:16px;display:none;">
                            </div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
                    
                    <div class="modal-dialog" id="model_familynot_second" style="display:none;">
						<div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h2 class="modal-title">Attach document to this note</h2>
                </div>
                
                <div class="modal-body">
                   <form action="<?=site_url()?>sha/sha_notedocument_upload" id="hf-photos-form1" class="dropzone">
                            <input type="hidden" name="clientId" id="clientId" value="<?php echo $formOne['id']?>" />	
                            <input type="hidden" name="notesid" id="notesid" value=" " />	
                        </form>            
                
				<div id="clientfaAgreementsParent" style="display:none;">
                <div class="panel panel-profile panel-bluegraylight" id="clientfaAgreements"   style="margin-top:32px; margin-bottom:0;">
    
                 </div>
                 </div>
                 </div>
               	 <div class="modal-footer">
                
	                <button style="float:left; background:#ebebeb;" type="button" class="btn btn-raised" id="editnotBackSecond">Back</button>
					<button type="button" class="btn btn-success btn-raised" id="editnotSubmitSecond" data-dismiss="modal" aria-hidden="true">Done</button>
                    
                    <!--<button type="button" class="btn btn-success btn-raised" id="editnotSubmitSecond">Done</button>-->
                    <img src="<?=loadingImagePath()?>" id="editBookingProcessSecond" style="margin-right:16px;display:none;">
                </div>
            </div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
                    
                    
                    
				</div><!-- /.modal -->

 <div class="modal fade" id="model_hfafamilynoteedit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h2 class="modal-title">Edit Note</h2>
                                </div>
                                
                                   <div class="modal-body">
                                <form id="updateHfaNotesFamilyFormedit">
               
			</form>   
			<div class="m-n form-group" style="padding:0;">
			<label class="control-label">Upload Document</label>
			 <form action="<?=site_url()?>sha/sha_notedocument_upload" id="hf-photos-formedit" class="dropzone">
                            <input type="hidden" name="clientId" id="clientIdedit" value="<?php echo $formOne['id']?>" />	
                            <input type="hidden" name="notesid" id="notesidedit" value=" " />	
                        </form>    
</div>						
              
				<div style="display:none;" id="clientfaAgreementseditParent">
                <div class="panel panel-profile panel-bluegraylight" id="clientfaAgreementsedit"  style="margin-top:32px; margin-bottom:0;">
                <?php //$this->load->view('system/hfa/familydocument_list');?>
                 </div>
                 </div>
                  </div>
				 
              
                                <div class="modal-footer">
                                <!--<button style="float:left;" type="button" class="btn btn-danger btn-raised" id="hfafamilynoteeditDelete">Delete</button>-->
								<button type="button" class="btn btn-success btn-raised" id="hfafamilynoteeditSubmit">Save</button>
							
                                <img src="<?=loadingImagePath()?>" id="hfafamilynoteedit" style="margin-right:16px;display:none;">
                            </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal --> 
				<style>
				#clientfaAgreementsedit .panel-body p {
    width: 100%;
				}
	#clientfaAgreements .panel-body p {
    width: 100%;
	
}

.help-block {
	
    display: block !important;
	
}
		
				</style>
				<link href="<?=static_url()?>system/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" type="text/css" rel="stylesheet"> <!-- Touchspin -->
<script src="<?=static_url()?>system/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js"></script>

<script type="text/javascript">

function addDays(date, days) {
    var result = new Date(date);
    result.setDate(result.getDate() + days);
    return result.toLocaleDateString();
}

function datediff(first, second) {
    // Take the difference between the dates and divide by milliseconds per day.
    // Round to nearest whole number to deal with DST.
    return Math.round((second-first)/(1000*60*60*24));
}
function allnote(id){
	
	   $.ajax({
				  url:site_url+'sha/allhfanote',
				  type:'POST',
				  data:{'hid':id},
				  success:function(data)
					  {
						 $("#allhfanote").html(data);
					  }
				  });
}
$(document).ready(function(){

	$('.CGCclass').change(function(){
		$('#careGiverDiv').hide()	
	});


	$("input#shaBooking_day").TouchSpin({
		  verticalbuttons: true,
		  min: 0,
		  max:6
		});
		$("input#shaBooking_week").TouchSpin({
		  verticalbuttons: true,
		  min: 0
		});

		$('#hfafamilynoteSubmit').click(function(){
		//var notes_titleField = $('input#notes_title').parsley();
		//window.ParsleyUI.removeError(notes_titleField,'notes_titleFieldError');
		var valid=$('#updateHfaNotesFamilyForm').parsley().validate();
		if(valid){
		var formdata=$('#updateHfaNotesFamilyForm').serialize();
		  $.ajax({
				  url:site_url+'sha/savenote',
				  type:'POST',
				  data:formdata,
				  success:function(data)
					  {
						  
						  var data = data.split('-');
						  
						  $("#notid").val(data[0]);
						  $("#notesid").val(data[0]);
						var id=  $("#clientId").val()
						  allnote(id);
						
						
						if(data[1]=='edit')
						  notiPop('success','Note updated successfully','');
					  else
						  notiPop('success','Note created successfully.','');
						  $('#model_hfafamilynote_content').hide();
						  $("#model_familynot_second").slideDown();
						  //$('#filtersLoadingDiv').hide();
						  //window.location.reload();
						 
					  }
				  });
		}
	})
	$('#hfafamilynoteeditSubmit').click(function(){
		var valid=$('#updateHfaNotesFamilyFormedit').parsley().validate();
		if(valid){
		var formdata=$('#updateHfaNotesFamilyFormedit').serialize();
		  $.ajax({
				  url:site_url+'sha/savenote',
				  type:'POST',
				  data:formdata,
				  success:function(data)
					  {
						 var data = data.split('-');
						  $("#notesidedit").val(data[0]);
						  	var id=  $("#clientId").val()
						  allnote(id);
						  notiPop('success','Note updated successfully','');
						  $('#model_hfafamilynoteedit').modal('toggle');
						  
						  //$("#model_hfafamilynoteedit").hide();
						//  $('#model_hfafamilynote_content').hide();
						 // $("#model_familynot_second").slideDown();
						  //$('#filtersLoadingDiv').hide();
						  //window.location.reload();
						// window.location.href=window.location.href.replace('#tab-8-4','')+'#tab-8-4';
						// window.location.reload();
					  }
				  });
		}
	})
	$('#editnotBackSecond').click(function(){
				$('#model_familynot_second').hide();
				$('#model_hfafamilynote_content').slideDown();
			});
	$('.tyu').on('click',function(){
		$('#model_hfafamilynote_content').slideDown();
		 $("#model_familynot_second").hide();
		 $('#clientfaAgreements').html('');
	var id=$(this).data('id');
	var noteid=$(this).data('postid');
	$('#updateHfaNotesFamilyForm').html('');
	
	$.ajax({
		url:site_url+'sha/noteContent/'+id+'/'+noteid,
		success:function(data)
			{
				// alert(data);
				$('#updateHfaNotesFamilyForm').html(data);
			}
		});
	
	
})
	$('#sha_studentid').change(function(){
		var formdata=$("#updateShastudentnoForm").serialize();
		$.ajax({
			url:site_url+'sha/savestudentnoinfo',
			type:'POST',
			data:formdata,
			success:function(data){
				if(data==1)
				notiPop("success","Student number has been updated.","");
				
			}
			})
		
	});
	
$('#officeClient').change(function(){
	$('#collegeNotMatching_alertMsg').hide();
	var va=$(this).find(':selected').attr('data-sub');
	var add=$(this).find(':selected').attr('data-add');
	var bname=$(this).find(':selected').attr('data-bname');
	var clgGroup=$(this).find(':selected').attr('data-college_group');
	var cid=$(this).val();
	$('#officeUse-sha_student_campus').val(va);
	$('#officeUse-student_college_address').val(add);
	$('#officeUse-student_college').val(bname);
	$('#officeUse-college_group, #officeUse-college_group_disabled').val(clgGroup);
})


$("#officeClient,#officeUse-student_college_address,#officeUse-student_college,#officeUse-sha_student_campus,#officeUse-college_group").change(function(){
	//var formdata=$("Adddressstudentupdate").serialize();
	$.ajax({
			url:site_url+'sha/saveaddressdetail/',
			type:'POST',
			data:{'college':$('#officeUse-student_college').val(),'sub':$('#officeUse-sha_student_campus').val(),'add':$('#officeUse-student_college_address').val(),'id':$('#studentid').val(),'cid':$('#officeClient').val(),'college_group':$('#officeUse-college_group').val()},
			success:function(data){
				notiPop("success","College details have been updated successfully.","");
				
			}
			})
				
	
})
		$('#shaBooking_startDate, #shaBooking_endDate,#officeUse-guardianship_startDate, #officeUse-guardianship_endDate').datepicker({
			orientation: "top",
			todayHighlight: true,
	    	startDate: "-0d",
			format:'dd/mm/yyyy',
			autoclose:true
		});
		
		Dropzone.options.hfPhotosForm1 = {
		maxFilesize: 5,
		acceptedFiles:'.pdf,.PDF,.docx,.xlsx,.jpeg,.jpg,.png,.JPG,.JPEG,.msg',
			init: function () {
			 	  this.on("success", function(file, responseText) {
					  if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0)
						   {
							  setTimeout(function(){
								  $('.dz-preview').remove();
								  },1500);
								  	var id=  $("#clientId").val()
						  allnote(id);
								  notiPop('success','Document uploaded successfully','')
								 
								  $('#clientfaAgreements').html(responseText);
								  if($('#clientfaAgreements div.panel-body > p').length>0)
									$('#clientfaAgreementsParent').show();
							}
				});
		  }
	}
			Dropzone.options.hfPhotosFormedit = {
		maxFilesize: 5,
		acceptedFiles:'.pdf,.PDF,.docx,.xlsx,.jpeg,.jpg,.png,.JPG,.JPEG,.msg',
			init: function () {
			 	  this.on("success", function(file, responseText) {
					  if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0)
						   {
							  setTimeout(function(){
								  $('.dz-preview').remove();
								  },1500);
								  	var id=  $("#clientId").val()
						  allnote(id);
								  notiPop('success','Document uploaded successfully','')
								 
								  $('#clientfaAgreementsedit').html(responseText);
								  if($('#clientfaAgreementsedit div.panel-body > p').length>0)
									$('#clientfaAgreementseditParent').show();
							}
				});
		  }
	}
	
	<?php if($nominationAlertMsgStyle==''){?>	
		$("input[name=homestayNomination]").attr('disabled', true);
		$("#nominated_hfa_id").attr('readonly', true);
	<?php } ?>

	
	});
	
	function deletenotedocument(id,nid){
			
				bootbox.dialog({
				message: "Are you sure you wish to delete this document?",
				title: "Delete",
				buttons: {
					  danger: {
						label: "Delete",
						className: "btn-danger",
						callback: function() {

								$.ajax({
		url:site_url+'sha/deletenotedocument/',
		type:'POST',
		data:{id:id},
		success:function(data)
			{
			
				$('p#clientfamlAgreements-'+id).remove();
				  allnote(nid);
				 notiPop('success','Document deleted successfully','');
			if($('#clientfaAgreementsedit div.panel-body > p').length==0)
			$('#clientfaAgreementseditParent').hide();
			}
		});

							}
						}
					}
				});
		}
</script>