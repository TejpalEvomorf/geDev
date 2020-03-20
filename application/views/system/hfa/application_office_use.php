<?php
$nameTitleList=nameTitleList();
$stateList=stateList();

$dwellingTypeList=dwellingTypeList();
$floorTypeList=floorTypeList();
$roomTypeList=roomTypeList();
$genderList=genderList();
$nationList=nationList();

$smokingHabbits=smokingHabbits();
$religionList=religionList();
$languageList=languageList();
$languagePrificiencyList=languagePrificiencyList();
$genderList=genderList();
$family_role=family_role();
$wwccTypeList=wwccTypeList();

$geRefList=geRefList();
$smokingHabbits=smokingHabbits();
?>

<style>
.vHBookingDurationHfa
{
	width: unset !important;text-align: unset !important;
}
.vHStudentNameHfa
{
	width: unset !important;text-align: unset !important;font-weight: lighter !important;font-size: 11px !important;color: #bdbdbd !important;
}
.vHStudentNameHfa:hover
{
	text-decoration: underline;
}
</style>  

<div class="col-md-4">
							  
	                 <div class="family-details-all tab-pane panel panel-bluegraylight"  data-widget='{"draggable": "false"}'>
                           <div class="panel-heading">                                
                                      <h2>Bank Details</h2>
                               </div>

                           <?php if(!empty($formThree)){//see($formThree);?>    
                                <?php if(isset($formThree['bankDetails']) && !empty($formThree['bankDetails'])){?>
                                    <div class="about-area panel-body">
                                  <div class="table-responsive">
                                      
                                      <table class="table about-table">
                                          <tbody>
                                              <tr>
                                                  <td><b>Bank name</b> :
														<?php 
                                                              if($formThree['bankDetails']['bank_name']!='')
															  	echo $formThree['bankDetails']['bank_name'];
															  else	
															   echo "n/a";	
                                                        ?>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td><b>Account name</b> :
                                                  	<?php
                                                    	if($formThree['bankDetails']['acc_name']!='')
															echo $formThree['bankDetails']['acc_name'];
														else	
															   echo "n/a";		
													?>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td><b>BSB</b> :
                                                  		<?php
                                                        	if($formThree['bankDetails']['bsb']!='')
																echo $formThree['bankDetails']['bsb'];
															else	
																echo "n/a";
                                                        ?>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td><b>Account number</b> :
												  		<?php
                                                        	if($formThree['bankDetails']['acc_no']!='')
																echo $formThree['bankDetails']['acc_no'];
															else
																echo "n/a";	
														?>
                                                  </td>
                                              </tr>
                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                              <?php } ?>
                           
                           <?php }else{ ?>
                          	 <div class="about-area p-md"><p>Bank account details not provided yet.</p></div>
                           <?php } ?>
                           
                          
                            
                            
                           
		</div>
        
        

    <div class="panel panel-profile panel-bluegraylight family-notes">
        <div class="panel-heading">
            <h2>Homestay nomination</h2>
        </div>
        <div class="panel-body">
		 
					  
					   <div class="widget referral-info-widget infobar nominatedgamily" style="margin-top:0;">
				
                  <?php   if(!empty($nomination)):  ?>					
						<label class="control-label filterItemLabel">Following students have nominated this family:</label>
                        <div class="widget-body" style="border-bottom:0px; padding-bottom: 0;"> 
					<?php   foreach($nomination as $val): ?>

				<ul id="nomination-<?= @$val['id'] ?>" class="timeline" style="margin-top: 0 !important; margin-left: -24px ;" >



                        <li class="timeline-grey">

                            <div class="timeline-icon"><i class="material-icons">alarm</i></div>

                            <div class="timeline-body">

                                <div class="timeline-header">

                                    <a href="<?=site_url()?>sha/application/<?=$val['id']?>" style="width:auto;text-align:left;" target="_blank"><span  class="notes-list-head author" ><?php  echo  ucfirst(@$val['fname']).' '.@$val['lname']?></span></a>

                                    <span class="date"><?php  echo  @date('d M Y',strtotime($val['nominaton_created']));?></span>

                                    <!--<span class="note-badge"> <i style="font-size: 16px; margin-left:20px;" class="material-icons">attach_file</i><?php echo @$val['totaldoc']?></span>-->
									<?php 
										$bookingByShaId=bookingByShaId($val['id']);
										if(!empty($bookingByShaId) && $bookingByShaId['host']==$formOne['id'])
										{
									?>
                                    <span  data-id="<?php echo @$val['id']?>" class="note-delete nominationdel">×</span>
									<?php } ?>
                                </div>

                            </div>

                        </li>     
</ul>
<?php endforeach; ?>	

  </div>
<?php endif; ?>
</div>
		<div class="m-n form-group" id="nominationEmpty" <?php  if(!empty($nomination)){?>style="display:none;"<?php } ?>>Family not nominated by any student.</div>

<div id="nominationHistoryHfaDiv">
<?php $this->load->view('system/hfa/homestayNominationHistory');?>
</div>
</div>
    </div>
 
	<?php //$this->load->view('system/hfa/revisitOfficeUseContent');?>  
    <?php $this->load->view('system/booking/incidentsBox');?>     
    <?php $this->load->view('system/booking/feedbacksBox');?>     
    <?php $this->load->view('system/hfa/transportInfoBox');?>     
    <?php $this->load->view('system/hfa/warningsBox');?>    
    
</div>


  
  
  
  
<div class="col-md-4">        
            
      <?php
      if($formOne['status']=='unavailable' || $formOne['status']=='approved')
	  {
				$hfaUnavailable=hfaUnavailable($formOne['id']);
				if(!empty($hfaUnavailable))
				{
		?>      
    <div class="panel panel-profile panel panel-orange" style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
          <div class="panel-heading">
          <h2>Unavailable</h2>
		  </div>
		  <div class="panel-body">
            <div class="about-area">
            <div class="personel-info personel-info-unavailable">
            <span class="icon"><i class="material-icons">date_range</i></span>
            <span><?=date('d M Y',strtotime($hfaUnavailable['date_from'])).' - '.date('d M Y',strtotime($hfaUnavailable['date_to']))?></span>
			</div>
            <div class="personel-info personel-info-unavailable">
            <span class=""><?=$formOne['comments']?></span>
			</div>
            </div>
		  </div>
	 </div>
       <?php }} ?>     
        
        
        <div class="panel panel-profile panel-bluegraylight">
                            <div class="panel-heading">
                            <h2>Self catered provision</h2>
                        </div>
			  	<div class="panel-body">
					<div>
                    <form id="hfaOfficeUseSelfCateredForm">
                    <input type="hidden" name="id" value="<?=$formOne['id']?>" />
                          
                    <label  class="mt-n control-label filterItemLabel">Self catered provision?</label>
                         <div class="radio block">
                              <label>
                                  <input type="radio" name="self_catered" value="1"  <?php if($formOne['self_catered']=='1'){echo "checked";}?>>
                                  <span class="circle"></span>
                                  <span class="check"></span>
                                  Yes
                              </label>
                         </div>
                         <div class="radio block">
                              <label>
                                  <input type="radio" name="self_catered" value="0"  <?php if($formOne['self_catered']=='0'){echo "checked";}?>>
                                  <span class="circle"></span>
                                  <span class="check"></span>
                                  No
                              </label>
                         </div>
                    </form>
                    </div>
			  	</div>
 </div>
 
 <?php if(isset($formTwo['bedroomDetails'])){?>
 <div class="family-details-all tab-pane panel panel-bluegraylight"  data-widget='{"draggable": "false"}'>
                           <div class="panel-heading">                                
                                      <h2>VIP Rooms</h2>
                               </div>

                           
                                    <div class="about-area panel-body">
                                    <div class="col-md-12 custom-accordion">
                                                <div class="panel-group panel-default" id="bedroomAccordionOU">
                                                    <?php foreach($formTwo['bedroomDetails'] as $bdK=>$bdV){?>
                                                                <div class="panel panel-default">
                                                                      <div class="media-body pb-md">
                                                                              <a data-toggle="collapse" data-parent="#bedroomAccordionOU" href="#collapseBedroomAccordionOU-<?=$bdK+1?>">
                                                                              <div class="panel-heading">
                                                                                  <h5 class="media-heading">BEDROOM <?=$bdK+1?></h5>
                                                                              </div>
                                                                              </a> 
                                                                              <div class="check-right">
                                                                                  <div class="checkbox checkbox-primary bathroom-hfa"   data-placement="left"  data-toggle="tooltip"  data-original-title="Click to mark it <?php if($bdV['vip']=='0'){echo 'VIP';}else{echo 'NORMAL';}?>">
                                                                                  <label><input name="vipcheck" id="vipcheck-<?=$bdV['id']?>"  type="checkbox" class="vipcheck" <?php if($bdV['vip']=='1'){?>checked<?php } ?>></label>
                                                                                  </div>
                                                                              </div>
                                                                              
                                                                      </div>
                                                                         
                                                                      <div id="collapseBedroomAccordionOU-<?=$bdK+1?>" class="collapse">
                                                                      <div class="panel-body">
                                                                          <table class="table about-table">
                                                                              <tbody>
                                                                                    <tr>
                                                                                        <td><b>Room type: </b><?=$roomTypeList[$bdV['type']]?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><b>Flooring type: </b>
                                                                                        	<?php
                                                                                              if($bdV['flooring']!="5")
                                                                                                  echo ucfirst($floorTypeList[$bdV['flooring']]);
                                                                                              else	
                                                                                                  echo ucfirst($bdV['flooring_other']);
                                                                                          	?>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><b>Room access: </b>
                                                                                        <?php
                                                                                              if($bdV['access']=="0")
                                                                                                  echo 'Inside';
                                                                                              elseif($bdV['access']=="1")
                                                                                              {	
                                                                                                  echo 'Outside';
                                                                                                  if($bdV['granny_flat']=="0")
                                                                                                      echo ", not a granny flat";
                                                                                                  elseif($bdV['granny_flat']=="1")
                                                                                                      echo ", granny flat";	
                                                                                              }
																							 else
																							 	echo 'n/a'; 
                                                                                          ?>
                                                                                          </td>
                                                                                    </tr> 
                                                                                    <tr>
                                                                                        <td><b>Internal ensuite: </b>
                                                                                         <?php
                                                                                              if($bdV['internal_ensuit']=="1")
                                                                                                  echo 'Yes';
                                                                                              elseif($bdV['internal_ensuit']=="0")
                                                                                                  echo 'No';
																							  else
																							  	  echo "n/a";
                                                                                          ?>
                                                                                          </td>
                                                                                    </tr>
                                                                                     <tr>
                                                                                        <td><b>Room available immediately: </b>
                                                                                        <?php
                                                                                              if($bdV['avail']=="1")
                                                                                                  echo 'Yes';
                                                                                              else	
                                                                                              {
																								  if(strtotime($bdV['avail_from'])<=strtotime(date('Y-m-d')))
																									  echo 'Yes';
																								  else
																								  {
																									  echo 'No, Available from '.date('d M Y',strtotime($bdV['avail_from']));
																									  if($bdV['avail_to']!='0000-00-00')
																										  echo ' - '.date('d M Y',strtotime($bdV['avail_to']));
																								  }
                                                                                              }
                                                                                          ?></td>
                                                                                    </tr>
                                                                                    <?php
                                                                                              if($bdV['avail']!="1" && strtotime($bdV['avail_from'])>strtotime(date('Y-m-d'))){?>
                                                                                    <tr>
                                                                                        <td><b>Student currently living in this room: </b>
                                                                                        <?php
                                                                                              if($bdV['currently_hosting']=="0")
                                                                                                  echo 'No';
                                                                                              elseif($bdV['currently_hosting']=="1")
                                                                                              {
                                                                                                  echo 'Yes';
                                                                                                  if($bdV['nation']!='')
                                                                                                      echo ", ".$nationList[$bdV['nation']];
                                                                                                  if($bdV['gender']!='')
                                                                                                      echo ", ".$genderList[$bdV['gender']];
                                                                                                  if($bdV['age']=='0')
                                                                                                      echo ", over 18";
                                                                                                  elseif($bdV['age']=='1')
                                                                                                      echo ", under 18";
                                                                                                          
                                                                                                  if($bdV['date_leaving']!='0000-00-00')
                                                                                                      echo ", leaving on ".date('d M Y',strtotime($bdV['date_leaving']));;			
                                                                                              }
																							  else
																							  	echo 'n/a';
                                                                                          ?></td>
                                                                                    </tr>
                                                                                    <?php } ?>
                                                                              </tbody>
                                                                          </table>
                                                                      
                                                                      </div>
                                                                      </div>
                                                                      
                                                                      
                                                                      
                                                                      
                                                                </div> 											
                                                     <?php }?>
                                                     </div>
                                                     </div>
                                                     
                                        
                              </div>
                          

                  
                           
  </div>
<?php } ?> 
 
 
	<?php
	   if($formOne['status']=='approved')
	   {
		   ?>
<div class="panel panel-profile panel-bluegraylight family-notes">
    <div class="panel-heading"><h2>College Approval</h2></div>
        <div class="panel-body">
          <div class="row">
              <div class="col-sm-8">
                  <button class="btn-raised btn-primary btn tyu btn-sm" data-toggle="modal" data-target="#model_addCApproval" >Add new approval</button>
              </div>
          </div>
                    
          <div class="widget referral-info-widget infobar" id="cApprovalList">
              <?php $this->load->view('system/hfa/collegeApprovalList');?>
          </div>
    </div>
</div>
	<?php
	   }
	?>
    
 
            
</div>




<!--<div class="col-md-3">        
            
      <?php
   /* if($formOne['status']=='unavailable' || $formOne['status']=='approved')
	  {
				$hfaUnavailable=hfaUnavailable($formOne['id']);
				if(!empty($hfaUnavailable))
				{*/
		?>      
    <div class="panel panel-profile panel panel-orange" style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
          <div class="panel-heading">
          <h2>Unavailable</h2>
		  </div>
		  <div class="panel-body">
            <div class="about-area">
            <div class="personel-info personel-info-unavailable">
            <span class="icon"><i class="material-icons">date_range</i></span>
            <span><?php //echo date('d M Y',strtotime($hfaUnavailable['date_from'])).' - '.date('d M Y',strtotime($hfaUnavailable['date_to']))?></span>
			</div>
            <div class="personel-info personel-info-unavailable">
            <span class=""><?php //echo $formOne['comments']?></span>
			</div>
            </div>
		  </div>
	 </div>
       <?php   //}} ?>     
        
        
        <div class="panel panel-profile panel-bluegraylight">
                            <div class="panel-heading">
                            <h2>Referrals info</h2>
                        </div>
			  	<div class="panel-body">
					<div>
                    <form id="">
                    <input type="hidden" name="id" value="Referred by" />
                          
                    <div class="m-n form-group">
						  <label class="control-label">From date</label>
							  <input type="text" class="form-control" id="" name="" value="auto update value" required>
					  </div>
                      
                      <div class="row">
						  <div class="col-sm-8">
							  <input type="button" class="btn-raised btn-primary btn" id="Submit" value="Pay referrals" onclick="">
							  <img src="<?php //echooadingImagePath()?>" id="updateShaBookingDatesProcess" style="display:none;">
						  </div>
					  </div>
                        
                    </form>
                    </div>
                    
              <div class="widget referral-info-widget infobar">
                <div class="widget-heading">REFERRALS HISTORY</div>
                <div class="widget-body">
                    <ul class="timeline" style="margin-top: 0 !important;">
                        <li class="timeline-grey">
                            <div class="timeline-icon"><i class="material-icons">alarm</i></div>
                            <div class="timeline-body">
                                <div class="timeline-header">
                                    <span class="author">[$20] Referral Purchase Order generated by</span>
                                    <span class="date">Date</span>
                                </div>
                            </div>
                        </li>                       
                         <li class="timeline-grey">
                            <div class="timeline-icon"><i class="material-icons">alarm</i></div>
                            <div class="timeline-body">
                                <div class="timeline-header">
                                    <span class="author">[name of person whose account logged in]</span>
                                    <span class="date">Date</span>
                                </div>
                            </div>
                        </li>                       
                    </ul>
                </div>
            </div>
                    
			  	</div>
 </div>
            
</div> --->
                        

<div class="col-md-4">
    <div class="panel panel-profile panel-bluegraylight">
        <div class="panel-heading">
            <h2>Internal Notes</h2>
        </div>
        <div class="panel-body">
           <form id="updateHfaNotesForm">
                <input type="hidden" name="id" value="<?=$formOne['id']?>" />
				<div class="m-n form-group">
					<label class="control-label">Any Special Requests or Internal Notes</label>
					<textarea  rows="10" class="form-control" id="special_request_notes" name="special_request_notes"><?php echo $formOne['special_request_notes'];?></textarea>
				</div>
			</form>
        </div>
    </div>
    
    <div class="panel panel-profile panel-bluegraylight family-notes">
        <div class="panel-heading">
            <h2>FAMILY NOTES</h2>
        </div>
        <div class="panel-body">
		 <div class="row">
						  <div class="col-sm-8">
							  
							 <button class="btn-raised btn-primary btn btn-sm tyu" data-postid='' data-id="<?php echo @$formOne['id'] ?>" data-toggle="modal" data-target="#model_hfafamilynote" >New Note</button>
							 
						  </div>
					  </div>
					  
					   <div class="widget referral-info-widget infobar" id="allhfanote">
					   <?php $this->load->view('system/hfa/allhfanote');?>
                
            </div>
			
           
        </div>
    </div>

    <div class="panel panel-profile panel-bluegraylight family-notes">
        <div class="panel-heading">
            <h2>Training event Attendence</h2>
        </div>
        <div class="panel-body">
             <div class="widget referral-info-widget infobar" id="attendence">
				 <div class="widget-heading" style="padding-left:0;">Attendence HISTORY</div>
				 <div class="widget-body" style="border-bottom:0px;"> 
					 <?php  $dates=gethfaTrainingDates($formOne['id']); if(!empty($dates)){  ?>					
						<input type="checkbox" class="read-more-state" id="extraNotes" />
				<ul class="timeline read-more-wrap" style="margin-top: 0 !important; margin-left: -24px ;">
					<?php   foreach($dates as $dK=>$date): ?>
						<li  style="padding-bottom: 0;" class="timeline-grey <?php if($dK>2){?>read-more-target<?php } ?>">
						<div class="timeline-icon"><i class="material-icons">alarm</i></div>
						<div class="timeline-body">
							<div class="timeline-header">
								<span class="notes-list-head" ><?=date('d M Y',strtotime($date['training_date']))?></span>				
							</div>
							
						</div>
						
					</li>     
					<?php endforeach; ?>	
				</ul>
				<?php }else {?>

		<div class="m-n form-group" style="margin-left: -16px !important;">
			Attendence history not available
		</div>
		<?php } ?>	
		</div>
		</div>
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
                   <form action="<?=site_url()?>hfa/hfa_familydocument_upload" id="hf-photos-form1" class="dropzone">
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
			 <!-- /.modal -->
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
			 <form action="<?=site_url()?>hfa/hfa_familydocument_upload" id="hf-photos-formedit" class="dropzone">
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
                    
              
              <?php if($formOne['status']=='approved'){
				  $clientList=clientsList();
				  ?>
			   <div class="modal fade" id="model_addCApproval" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h2 class="modal-title">Add new approval from college</h2>
							</div>
                            
                            <div class="modal-body">
                                <form id="addCApprovalForm">
                                	
                                        <div class="m-n form-group">
                                            <label class="control-label">Approved by</label>
                                            <select class="form-control" id="addCApproval_college" name="addCApproval_college" required>
                                                <option value="">Select College</option>
                                                <?php foreach($clientList as $client)
                                                {
                                                if($client['category']=='1' || $client['category']=='2')
                                                  continue;
                                                ?>
                                                  <option value="<?=$client['id']?>" ><?=$client['bname']?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        
                                        <div class="m-n form-group">
	                                      <input type="hidden" name="hfa_id" value="<?=$formOne['id']?>" />
                                          <label  for="notes_title"class="control-label">Approved date</label>
                                          <input type="text" class="form-control"  id="addCApproval_date" name="addCApproval_date" value="" required/>
                                        </div>
                                    
            					</form>   
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-success btn-raised" id="addCApprovalSubmit">Submit</button>
                                <img src="<?=loadingImagePath()?>" id="addCApprovalProcess" style="margin-right:16px;display:none;">
                            </div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
                    
                    <!-- /.modal-dialog -->
                </div><!-- /.modal -->
			  <?php } ?>
              
                    
                    
				<style>
				#clientfaAgreementsedit .panel-body p {
    width: 100%;
	#clientfaAgreements .panel-body p {
    width: 100%;
	
}
				</style>
<script type="text/javascript">
function allnote(id){
	
	   $.ajax({
				  url:site_url+'hfa/allhfanote',
				  type:'POST',
				  data:{'hid':id},
				  success:function(data)
					  {
						 $("#allhfanote").html(data);
					  }
				  });
}

$(document).ready(function(){
	
		$('#hfafamilynoteSubmit').click(function(){
		//var notes_titleField = $('input#notes_title').parsley();
		//window.ParsleyUI.removeError(notes_titleField,'notes_titleFieldError');
		var valid=$('#updateHfaNotesFamilyForm').parsley().validate();
		if(valid){
		var formdata=$('#updateHfaNotesFamilyForm').serialize();
		  $.ajax({
				  url:site_url+'hfa/savefamilynote',
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
				  url:site_url+'hfa/savefamilynote',
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
	$('.tyu').on('click',function(){
		$('#model_hfafamilynote_content').slideDown();
		 $("#model_familynot_second").hide();
		 $('#clientfaAgreements').html('');
	var id=$(this).data('id');
	var noteid=$(this).data('postid');
	$('#updateHfaNotesFamilyForm').html('');
	
	$.ajax({
		url:site_url+'hfa/familynoteContent/'+id+'/'+noteid,
		success:function(data)
			{
				// alert(data);
				$('#updateHfaNotesFamilyForm').html(data);
				/*$('#notes_date').datepicker({
			orientation: "bottom",
			todayHighlight: true,
			format:'dd/mm/yyyy',
			autoclose:true
		});*/
			}
		});
	
	
})

	$('.vipcheck').click(function(){
		var checkbox=$(this);
		var cbId=$(this).attr('id');
		if($(this).is(':checked'))
			var cb='1';
		else
			var cb='0';
		
		$.ajax({
			url:site_url+'hfa/vipCheckBedroom',
			type:'POST',
			data:{bed:cbId,val:cb},
			success:function(data)
				{
					if(cb=='1')
					{
						msg='VIP';
						msgTtip='NORMAL';
					}
					else
					{
						msg='NORMAL';
						msgTtip='VIP';
					}
					notiPop('success','Room is marked as '+msg+' successfully',"");
					checkbox.parents('.checkbox-primary').attr('data-original-title','Click to mark it as '+msgTtip);
				}
		});
		

			
	});
	
	$(".nominationdel").click(function(){

	var id =$(this).data('id');


	bootbox.dialog({

				message: "If you delete this nomination the nomination information will also be deleted from student application.",

				title: "Delete",

				buttons: {

					  danger: {

						label: "Delete",

						className: "btn-danger",

						callback: function() {



								$.ajax({

		url:site_url+'hfa/deletenominationstudent/'+id+'/'+<?=$formOne['id']?>,

		success:function(data)
				{
					$("#nomination-"+id).remove();
				  	notiPop('success','Family nomination deleted successfully','');
					if($('.widget-body ul.timeline').length==0)
					{
						  $(".nominatedgamily").html('');
						  $('#nominationEmpty').show();
					}
					$('#nominationHistoryHfaDiv').html(data);
				}

		});



							}

						}

					}

				});



	

	

})

	
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
		url:site_url+'hfa/deletehfafamilydocument/',
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