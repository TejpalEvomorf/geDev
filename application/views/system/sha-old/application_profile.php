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
//$guardianshipTypeList=guardianshipTypeList();
$age=age_from_dob($formOne['dob']) ;

$homestayChooseReasonList=homestayChooseReasonList();
?>

            <div class="col-md-3">
                        <div class="panel panel-profile panel-bluegraylight">
                            <div class="panel-heading">
                            <h2>General Details</h2>
                        </div>
			  	<div class="panel-body">
					<div>
					
					<?php   if(!empty($formOne['sha_student_no'])){?>
                    <div class="personel-info">
							<span class="icon"><i class="material-icons">person_pin</i></span>
							<span>Student no.  <?= $formOne['sha_student_no']?></span>
						</div>
					<?php }?>
                    	<div class="personel-info">
							<span class="icon"><i class="fa fa-<?=strtolower($genderList[$formOne['gender']])?>"></i></span>
							<span><?=$genderList[$formOne['gender']]?></span>
						</div>
                        
                        <div class="personel-info">
							<span class="icon"><i class="material-icons">cake</i></span>
							<span><?php if($formOne['dob']!='0000-00-00'){echo date('d M Y',strtotime($formOne['dob']));}else{echo "Not available";}?></span>
						</div>
                        
						<div class="personel-info">
							<span class="icon"><i class="material-icons">email</i></span>
							<span><?php if($formOne['email']!=''){echo '<a class="mailto" href="mailto:'.$formOne['email'].'">'.$formOne['email'].'</a>';}else{echo "Not available";}?></span>
						</div>

						<?php if($formOne['mobile']!=''){?>
						<div class="personel-info">
							<span class="icon"><i class="material-icons">phone_iphone</i></span>
							<span class="phone-icon-phone">					           
                                <?=$formOne['mobile']?>
                             </span>
						</div>
                        <?php } ?>
                        
                        
                         <?php if($formOne['home_phone']!=''){?>
                            <div class="personel-info">
								<span class="icon"><i class="material-icons">call</i></span>
								<span><?=$formOne['home_phone']?> (H)</span>
							</div>
                        <?php }?>
                        
						
						<?php if($formOne['nation']!=0){?>
                            <div class="personel-info">
                                <span class="icon"><i class="material-icons">flag</i></span>
                                <span><?=$nationList[$formOne['nation']]?></span>
                            </div>
						<?php }?>
                        
                            
                            
                                <div class="personel-info">
                                <span class="icon"><i class="material-icons">business</i></span>
                                <span><?=$accomodationTypeList[$formOne['accomodation_type']]?></span>
                                <?php if($formOne['accomodation_type']==2 && $formOne['student_name2']!=''){?>
                                    <span><strong>Second student name: </strong></span><br />
                                    <span class="second-student-name"><?=$formOne['student_name2']?></span>
                                    <?php } ?>
                                </div>
                           
                            
					</div>
			  	</div>
 </div>               
  
  		

      <div class="panel panel-profile panel-bluegraylight">
                          <div class="panel-heading">
                          <h2>About Student</h2>
                      </div>
              <div class="panel-body">
                              <div class="about-area">
                                      <p class="pre-wrap" style="margin-bottom:0px;">
									  <?php if($formTwo['student_desc']!=''){?>
										  <?=$formTwo['student_desc']?></p>
                                      <?php }else{?> 
                                      <p style="margin-top:-20px; margin-bottom:0px;">Not available. </p> 
                                      <?php } ?>
                                     
                              </div>
              </div>
      </div>

         
         
<div class="panel panel-profile panel-bluegraylight">
                <div class="panel-heading">
                <h2>About Student's Family</h2>
            </div>
    <div class="panel-body">
        <div class="pre-wrap" style="">
        <?php if($formTwo['student_family_desc']!=''){?>                    
           <p style="margin-top:-17px; margin-bottom:-20px;"> <?=$formTwo['student_family_desc']?></p>
			  <?php }else{ ?>
              Not available.
              <?php } ?>
        </div>
    </div>
</div>

<div class="panel panel-profile panel-bluegraylight">
                          <div class="panel-heading">
                          <h2>Internal notes</h2>
                      </div>
              <div class="panel-body">
                              <div class="about-area">
                                      <div id="profile_internal_notes" >
                                      <p class="pre-wrap" style="margin-bottom:0px; margin-top:0;"><?php if(trim($formOne['special_request_notes'])!=''){?><?=$formOne['special_request_notes']?><?php }else{ ?>
                                      <p style="margin-bottom:0px;">Not available. 
                                      <?php } ?>
                                      </p> 
                                      </div>
                                     
                              </div>
              </div>
      </div>

<!--<div class="panel panel-profile panel-bluegraylight">
                <div class="panel-heading">
                <h2>About Student's Hobbies</h2>
            </div>
    <div class="panel-body">
        <div class="pre-wrap" style="">
        <?php if($formTwo['student_hobbies']!=''){?>                    
           <p style="margin-top:-17px; margin-bottom:-20px;"> <?=$formTwo['student_hobbies']?></p>
			  <?php }else{ ?>
              Not available.
              <?php } ?>
        </div>
    </div>
</div>-->


         <div class="panel panel-profile panel-bluegraylight">
                    <div class="panel-heading">
                        <h2>UPLOAD Document</h2>
                    </div>
                    <div class="panel-body">
                        <form action="<?=site_url()?>sha/sha_document_upload" id="sha-documents-upload" class="dropzone">
                            <input type="hidden" name="clientId" id="clientId" value="<?=$formOne['id']?>" />
                        </form>
                    </div>
                </div>
				<div class="panel panel-profile panel-bluegraylight" id="clientAgreements">
                <?php  $this->load->view('system/sha/document_list');?>
                 </div>        

</div>
                        
<div class="col-md-9 panel-profile">
		<div class="sha-details">
         
				  <div class="property-details-all tab-pane panel panel-success"  data-widget='{"draggable": "false"}'>                     
				<div class="panel-heading">
					<h2>ALL DETAILS</h2>
                  </div>
					         <?php if(!empty($formTwo)){?>                       
                                <div class="about-area p-md">
								<div class="table-responsive panel panel-default" data-widget='{"draggable": "false"}'>
                                    <div class="panel-body">
									<table class="table about-table">
										<tbody>
                                        <tr>
												<th>Arrival date</th>
												<td><?php 
												if(isset($formOne['arrival_date']) && $formOne['arrival_date']!='0000-00-00')
													echo date('d M Y',strtotime($formOne['arrival_date']));
												else
													echo 'n/a'; 
													?>
                                                 </td>
									  </tr>
                                      
                                      <tr>
                                          <th>Passport number</th>
                                          <td><?php 
												if(isset($formOne['passport_no']) && $formOne['passport_no']!='')
													echo $formOne['passport_no'];
												else
													echo 'n/a';
												?> 
											</td>
                                      </tr>
                                      
                                      <tr>
                                          <th>Passport expiry date</th>
                                          <td><?php 
											  if(isset($formOne['passport_exp']) && $formOne['passport_exp']!='0000-00-00')
												  echo date('d M Y',strtotime($formOne['passport_exp']));
											  else
												  echo 'n/a'; 
												  ?>
                                           </td>
                                      </tr>
                                      
											<tr>
												<th>Languages spoken</th>
												<td>
                                                <?php
                                            	foreach($formTwo['language'] as $lK=>$language)
												{
													?>
                                                    
                                                    <?=$languageList[$language['language']]?>
                                                            <?php
																if($language['language']=='25')
																	echo " - ".$language['other_language'];
                                                           		 if($language['prof']!='')
																		echo " (".$languagePrificiencyList[$language['prof']].")";
																if(count($formTwo['language'])-1 != $lK)
																	echo ", ";
															?>
                                                    
                                                      <?php }?>
                                                </td>
											</tr>
                                            
                                            
											<tr>
												<th>Ethnicity</th>
                                                <td><?php if($formTwo['ethnicity']!=''){echo $nationList[$formTwo['ethnicity']];}else{echo 'n/a';}?></td>
											</tr>
											<tr>
												<th>Religion</th>
												<td>
													<?php 
													if($formTwo['religion']!="0" && $formTwo['religion']!=''){
														echo ucfirst ($religionList[$formTwo['religion']]);
													}elseif($formTwo['religion']=="0"){
														echo ucfirst ($formTwo['religion_other']);
													}else{
														echo 'n/a';
													}
														
													?>
                                                </td>
											</tr>
										</tbody>
									</table>
                                    </div>
								</div>
							</div>
                            
                            <div class="about-area p-md">
								<div class="table-responsive panel panel-default" data-widget='{"draggable": "false"}'>
                                <div class="media-body panel-heading">
										<h2>Pet Details</h2>
									</div>
                                    <div class="panel-body">
									<table class="table about-table">
										<tbody>
											<tr>
												<th>Can live with pets</th>
												<td>
													<?php
													if($formTwo['live_with_pets']=="0")
														echo "No";
													elseif($formTwo['live_with_pets']=="1")
														echo "Yes ";
													else
														echo "n/a";
													
                                                    if($formTwo['live_with_pets']==1){
													
													  $pets=array();
													  if($formTwo['pet_dog']==1)
														  $pets[]='Dog';
													  if($formTwo['pet_cat']==1)
														  $pets[]='Cat';
													  if($formTwo['pet_bird']==1)
														  $pets[]='Bird';
													  if($formTwo['pet_other']==1 && $formTwo['pet_other_val']!='')
														  $pets[]=ucfirst ($formTwo['pet_other_val']);	
													  
													  if(!empty($pets))
														  echo '- '.implode(', ',$pets);
													
													?>
                                                </td>
											</tr>
                                            
                                              <tr>
                                                  <th>Can live with pets inside the house? </th>
                                                  <td><?php
                                                		if($formTwo['pet_live_inside']==1)
															echo "Yes";
														elseif($formTwo['pet_live_inside']=="0")
															echo "No";
														else
															echo "n/a";		
													?></td>
                                              </tr>
                                            <?php } ?>
                                         </tbody>
									</table>
                                    </div>
								</div>
							</div>
                            
                             <div class="about-area p-md">
								<div class="table-responsive panel panel-default" data-widget='{"draggable": "false"}'>
                                <div class="media-body panel-heading">
										<h2>Insurance Details</h2>
									</div>
                                    <div class="panel-body">
									<table class="table about-table">
										<tbody>
											<tr>
												<th>Travel Insurance</th>
												<td>
													<?php
                                                		if($formTwo['insurance']==1)
															echo "Yes";
														elseif($formTwo['insurance']=="0")
															echo "No";	
													?>
                                                </td>
											</tr>
                                            
                                            <?php 
											if($formTwo['insurance']==1){
											?>
                                              <tr>
                                                  <th>Insurance provider</th>
                                                  <td>
												  		<?php
                                                        	if(trim($formTwo['ins_provider'])!='')
																echo ucfirst ($formTwo['ins_provider']);
															else
																echo 'n/a';	
														?>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <th>Policy no.</th>
                                                  <td>
												  		<?php
                                                        	if(trim($formTwo['ins_policy_no']))
																echo ucfirst ($formTwo['ins_policy_no']);
															else
																echo 'n/a';	
														?>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <th>Expiry date</th>
                                                  <td><?php if($formTwo['ins_expiry']!='0000-00-00'){echo date('d M Y',strtotime($formTwo['ins_expiry']));}else{echo 'n/a';}?></td>
                                              </tr>
                                              
                                               <?php 
														if($formTwo['ins_file']!=""){?>
                                                                <tr>
                                                                    <th>Uploaded travel insurance</th>
                                                                    <td><?='<a style="color: hsl(199, 98%, 48%);" href="'.static_url().'uploads/sha/ins/'.$formTwo['ins_file'].'" target="_blank">Preview file</a>'?></td>
                                                           		</tr>
                                                <?php } ?>
                                              
                                            <?php } ?>
                                         </tbody>
									</table>
                                    </div>
								</div>
							</div>
                            
                             <div class="about-area p-md" id="apuDiv">
								<div class="table-responsive panel panel-default" data-widget='{"draggable": "false"}'>
                                <div class="media-body panel-heading">
										<h2>Airport Pickup Service</h2>
									</div>
                                    <div class="panel-body">
									<table class="table about-table">
										<tbody>
                                        <?php if($formOne['study_tour_id']==0){?>
											<tr>
												<th>Airport pickup</th>
												<td>
													<?php
                                                		if($formTwo['airport_pickup']==1)
															echo "Yes";
														elseif($formTwo['airport_pickup']=="0")
															echo "No";	
													?>
                                                </td>
											</tr>
                                            
                                            <?php 
											/*if($formTwo['airport_pickup']==1){*/
											?>
                                              <tr>
                                                  <th>Arrival date / Time</th>
                                                  <td>
												  	<?php if($formOne['arrival_date']!='0000-00-00'){echo date('d M Y',strtotime($formOne['arrival_date']));}?><?php if($formOne['arrival_date']!='0000-00-00' && $formTwo['airport_arrival_time']!='00:00:00'){echo ", ";}?><?php if($formTwo['airport_arrival_time']!='00:00:00'){echo date('H:i',strtotime($formTwo['airport_arrival_time']));}?><?php if($formOne['arrival_date']=='0000-00-00' && $formTwo['airport_arrival_time']=='00:00:00'){echo "n/a";}?>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <th>Carrier(Airline)</th>
                                                  <td>
												  		<?php
																if(trim($formTwo['airport_carrier'])!='')
																	echo ucfirst ($formTwo['airport_carrier']);
																else
																	echo 'n/a';	
														?>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <th>Flight number</th>
                                                  <td>
												  		<?php
                                                        		if(trim($formTwo['airport_flightno']))
																	echo ucfirst ($formTwo['airport_flightno']);
																else
																	echo 'n/a';
														?>
                                                  </td>
                                              </tr>
                                            <?php /*}*/}else{ ?>
                                            
                                                          <tr>
                                                              <th>Family to pickup from meeting point</th>
                                                              <td>
                                                                  <?php
                                                                      if($formTwo['family_pickup_meeting_point']=='1')
                                                                          echo "Yes";
                                                                      elseif($formTwo['family_pickup_meeting_point']=="0")
                                                                          echo "No";
																	  else  	
																	      echo "n/a";
                                                                  ?>
                                                              </td>
                                                          </tr>
                                                          <tr>
                                                              <th>Airport pickup to meeting point</th>
                                                              <td>
                                                                  <?php
                                                                      if($formTwo['airport_pickup_meeting_point']=='1')
                                                                          echo "Yes";
                                                                      elseif($formTwo['airport_pickup_meeting_point']=="0")
                                                                          echo "No";
																	  else  	
																	      echo "n/a";	  	
                                                                  ?>
                                                              </td>
                                                          </tr>
                                                          <tr>
                                                              <th>Airport pick up to homestay</th>
                                                              <td>
                                                                  <?php
                                                                      if($formTwo['airport_pickup']=='1')
                                                                          echo "Yes";
                                                                      elseif($formTwo['airport_pickup']=="0")
                                                                          echo "No";
																	   else  	
																	      echo "n/a";  
                                                                  ?>
                                                              </td>
                                                          </tr>
                                                          <tr>
                                                  <th>Arrival date / Time</th>
                                                  <td>
												  	<?php if($formOne['arrival_date']!='0000-00-00'){echo date('d M Y',strtotime($formOne['arrival_date']));}?><?php if($formOne['arrival_date']!='0000-00-00' && $formTwo['airport_arrival_time']!='00:00:00'){echo ", ";}?><?php if($formTwo['airport_arrival_time']!='00:00:00'){echo date('h:i A',strtotime($formTwo['airport_arrival_time']));}?><?php if($formOne['arrival_date']=='0000-00-00' && $formOne['arrival_date']=='00:00:00'){echo "n/a";}?>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <th>Carrier(Airline)</th>
                                                  <td>
												  		<?php
																if(trim($formTwo['airport_carrier'])!='')
																	echo ucfirst ($formTwo['airport_carrier']);
																else
																	echo 'n/a';	
														?>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <th>Flight number</th>
                                                  <td>
												  		<?php
                                                        		if(trim($formTwo['airport_flightno']))
																	echo ucfirst ($formTwo['airport_flightno']);
																else
																	echo 'n/a';
														?>
                                                  </td>
                                              </tr>
                                            <?php } ?>
                                            
                                         </tbody>
									</table>
                                    </div>
								</div>
							</div>
                            
                             <div class="about-area p-md">
								<div class="table-responsive panel panel-default" data-widget='{"draggable": "false"}'>
                                <div class="media-body panel-heading">
										<h2>Student's Story</h2>
									</div>
                                    <div class="panel-body">
									<table class="table about-table">
										<tbody>
											<tr>
												<th>Past homestay experience</th>
												<td>
													<?php
                                                		if($formTwo['home_student_past']==1)
															echo "Yes";
														elseif($formTwo['home_student_past']=="0")
															echo "No";
														else
															echo 'n/a';		
													?>
                                                </td>
											</tr>
                                            
                                            <?php 
											if($formTwo['home_student_past']==1){
											?>
                                              <tr>
                                                  <th>Experience as homestay student</th>
                                                  <td>
												  		<?php
                                                        	if(trim($formTwo['home_student_exp'])!='')
																echo ucfirst ($formTwo['home_student_exp']);
															else
																echo 'n/a';	
														?>
                                                  </td>
                                              </tr>
                                             <?php } ?>
                                             
                                            <tr>
                                            <th>Hobbies</th>
                                             <td><?php if($formTwo['student_hobbies']!=''){?>                    
                                             <?=$formTwo['student_hobbies']?>
											<?php }else{ ?>
                                            n/a
                                            <?php } ?>
                                            </td>
                                            </tr>
                                            
                                            
                                              <tr>
                                                  <td colspan="2" class="colorLightgrey font12">See left bar for Student and Student's family description.</td>
                                                  
                                              </tr>
                                            
                                              
                                         </tbody>
									</table>
                                    </div>
								</div>
							</div>
                            
                            <?php if($age<18){?>
                             <div class="about-area p-md">
								<div class="table-responsive panel panel-default" data-widget='{"draggable": "false"}'>
                                <div class="media-body panel-heading">
										<h2>Caregiving details</h2>
									</div>
                                    <div class="panel-body">
									<table class="table about-table">
										<tbody>
											<tr>
												<th>Caregiving requested</th>
												<td>
													<?php
                                                		if($formTwo['guardianship']==1)
															echo "Yes";
														elseif($formTwo['guardianship']=="0")
															echo "No";
														else
															echo 'n/a';
													
														if($formTwo['guardianship']==1 && trim($formTwo['guardianship_requirements'])!='')
															echo ', '.$formTwo['guardianship_requirements']; 
													?>
                                                </td>
											</tr>
                                         </tbody>
									</table>
                                    </div>
								</div>
							</div>
                          <?php }?>
                          <?php }else{?>
                          <div class="about-area p-md">
								<div class="table-responsive panel panel-default" data-widget='{"draggable": "false"}'>
                                    <div class="panel-body">
									<table class="table about-table">
										<tbody>
                                        <tr>
												<th>Arrival date</th>
												<td><?php 
												if(isset($formOne['arrival_date']) && $formOne['arrival_date']!='0000-00-00')
													echo date('d M Y',strtotime($formOne['arrival_date']));
												else
													echo 'n/a'; 
													?>
                                                 </td>
									  </tr>
                                      
                                      <tr>
                                          <th>Passport number</th>
                                          <td><?php 
												if(isset($formOne['passport_no']) && $formOne['passport_no']!='')
													echo $formOne['passport_no'];
												else
													echo 'n/a';
												?> 
											</td>
                                      </tr>
                                      
                                      <tr>
                                          <th>Passport expiry date</th>
                                          <td><?php 
											  if(isset($formOne['passport_exp']) && $formOne['passport_exp']!='0000-00-00')
												  echo date('d M Y',strtotime($formOne['passport_exp']));
											  else
												  echo 'n/a'; 
												  ?>
                                           </td>
                                      </tr>
                                      <tr>
                                          <td colspan="2" class="colorLightgrey font12">More details will appear only after completing STEP 2 (Other Details) of the student application. </td> 
                                      </tr>
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </div>
                          <?php } ?>
                          </div>
                          
                          

  
                         
          
          
             <div class="sha-health-details tab-pane panel panel-success"  data-widget='{"draggable": "false"}'>                     
				<div class="panel-heading">
					<h2>HEALTH DETAILS AND PREFERENCES</h2>
				</div>
                
                <?php if(!empty($formThree)){?>
                        <div class="about-area p-md">
								<div class="table-responsive panel panel-default" data-widget='{"draggable": "false"}'>
                                <div class="media-body panel-heading">
										<h2> Your Health Details </h2>
									</div>
                                    <div class="panel-body">
									<table class="table about-table">
										<tbody>
											<tr>
												<th>Special dietary requirements</th>
												<td>
                                                	<?php
														if($formThree['diet_req']=='0')
															echo "No";
														elseif($formThree['diet_req']=='1')
															echo "Yes ";
														else
															echo 'n/a';
															
                                                    	if($formThree['diet_req']=='1')
															{
																$diet=array();
																if($formThree['diet_veg']==1)
																	$diet[]='Vegetarian';
																if($formThree['diet_gluten']==1)
																	$diet[]='Gluten/Lactose Free';
																if($formThree['diet_pork']==1)
																	$diet[]='No Pork';
																if($formThree['diet_food_allergy']==1)
																	$diet[]='Food Allergies';	
																if($formThree['diet_other']==1 && $formThree['diet_other_val']!='')
																	$diet[]=ucfirst ($formThree['diet_other_val']);		
																
																if(!empty($diet))
																	echo '- '.implode(', ',$diet);
															}
													?>
                                                </td>
											</tr>
                                            
                                            <tr>
												<th>Allergies</th>
												<td>
                                                	<?php
														if($formThree['allergy_req']=='0')
															echo "No";
														elseif($formThree['allergy_req']=='1')
															echo "Yes ";
														else
															echo 'n/a';
															
                                                    	if($formThree['allergy_req']=='1')
															{
																$allergy=array();
																if($formThree['allergy_hay_fever']==1)
																	$allergy[]='Hay Fever';
																if($formThree['allergy_asthma']==1)
																	$allergy[]='Asthma';
																if($formThree['allergy_lactose']==1)
																	$allergy[]='Lactose Intolerance';
																if($formThree['allergy_gluten']==1)
																	$allergy[]='Gluten Intolerance';	
																if($formThree['allergy_peanut']==1)
																	$allergy[]='Peanut Allergies';	
																if($formThree['allergy_dust']==1)
																	$allergy[]='Dust Allergies';	
																if($formThree['allergy_other']==1 && $formThree['allergy_other_val']!='')
																	$allergy[]=ucfirst ($formThree['allergy_other_val']);		
																
																if(!empty($allergy))
																	echo '- '.implode(', ',$allergy);
															}	
													?>
                                                </td>
											</tr>
                                            
											<tr>
												<th>Smoker</th>
												<td>
													<?php
                                                            if($formThree['smoker']!='')
                                                                echo $smokingHabbits[$formThree['smoker']];
															else
																echo 'n/a';	
                                                        ?>
                                                  </td>
											</tr>
											<tr>
												<th>Any medication</th>
												<td>
														<?php
                                                            if($formThree['medication']=='1')
                                                                echo 'Yes';
															elseif($formThree['medication']=='0')
																echo "No";
															else 
																echo 'n/a';	
                                                        ?>
                                                </td>
											</tr>
                                            <?php if($formThree['medication']=='1'){?>
                                            <tr>
												<th>Medication details</th>
												<td><?=ucfirst ($formThree['medication_desc'])?></td>
											</tr>
                                            <?php } ?>
                                            
                                            <tr>
												<th>Disability</th>
												<td>
														<?php
                                                            if($formThree['disabilities']=='1')
                                                                echo 'Yes';
															elseif($formThree['disabilities']=='0')
																echo "No";
															else
																echo 'n/a';	
                                                        ?>
                                                </td>
											</tr>
                                            <?php if($formThree['disabilities']=='1'){?>
                                            <tr>
												<th>Disability details</th>
												<td><?=ucfirst ($formThree['disabilities_desc'])?></td>
											</tr>
                                            <?php } ?>
                                            
										</tbody>
									</table>
                                    </div>
								</div>
							</div>
                            
                            <div class="about-area p-md">
								<div class="table-responsive panel panel-default" data-widget='{"draggable": "false"}'>
                                <div class="media-body panel-heading">
										<h2> Homestay Family Preferences </h2>
									</div>
                                    <div class="panel-body">
									<table class="table about-table">
										<tbody>
											<tr>
												<th>Can you live with children 0-11 years old?</th>
												<td>
													<?php 
														if($formThree['live_with_child11']==1)
															echo "Yes";
														elseif($formThree['live_with_child11']=="0")	
															echo "No";
														else
															echo 'n/a';	
													?>
                                                </td>
											</tr>
                                            
                                            <tr>
												<th>Can you live with children 12-20 years old?</th>
												<td>
													<?php 
														if($formThree['live_with_child20']==1)
															echo "Yes";
														elseif($formThree['live_with_child20']=="0")	
															echo "No";
														else
															echo 'n/a';	
													?>
                                                </td>
											</tr>
                                            
                                            <tr>
												<th>Reason for the preference above</th>
												<td>
														<?php
                                                        		if(trim($formThree['live_with_child_reason'])!='')
																	echo ucfirst ($formThree['live_with_child_reason']);
																else
																	echo 'n/a';	
														?> 
                                                </td>
											</tr>
                                            
                                            <tr>
												<th>Can stay with a family that includes a smoker?</th>
												<td>
													<?php
                                                    	if($formThree['family_include_smoker']!='')
															echo $smokingHabbits[$formThree['family_include_smoker']];
														else
															echo 'n/a';	
													?>
                                                </td>
											</tr>
                                            
                                            <tr>
												<th>Other family preferences</th>
												<td>
														<?php
																if(trim($formThree['family_pref'])!='')
																	echo ucfirst ($formThree['family_pref']);
																else
																	echo 'n/a';
														?>
                                                </td>
											</tr>
                                         </tbody>
									</table>
                                    </div>
								</div>
							</div>
                            
                           <div class="about-area p-md">
								<div class="table-responsive panel panel-default" data-widget='{"draggable": "false"}'>
                                <div class="media-body panel-heading">
										<h2> College/Institution Details</h2>
									</div>
                                    <div class="panel-body">
									<table class="table about-table">
										<tbody>
											<tr>
												<th>College/Institution name</th>
												<td>
														<?php
															if(trim($formThree['college'])!='')
																echo ucfirst ($formThree['college']);
															else
																echo 'n/a';	
														?>
                                                </td>
											</tr>
                                            
                                            <tr>
												<th>Campus</th>
												<td>
														<?php
                                                        	if(trim($formThree['campus'])!='')
																echo ucfirst ($formThree['campus']);
															else
																echo 'n/a';	
														?>
                                                </td>
											</tr>
                                            
                                            <tr>
												<th>Address</th>
												<td>
														<?php
                                                        	if(trim($formThree['college_address'])!='')
																echo ucfirst ($formThree['college_address']);
															else
																echo 'n/a';	
														?>
                                                </td>
											</tr>
                                            
                                            <tr>
												<th>Course name</th>
												<td>
														<?php
                                                        	if(trim($formThree['course_name'])!='')
																echo ucfirst ($formThree['course_name']);
															else
																echo 'n/a';	
														?>
                                                </td>
											</tr>
                                            
                                            <tr>
												<th>Course start date</th>
												<td>
														<?php
                                                        	if(trim($formThree['course_start_date'])!='0000-00-00')
																echo  date('d M Y',strtotime($formThree['course_start_date']));
															else
																echo 'n/a';	
														?>
                                                </td>
											</tr>
                                            
                                            <tr>
												<th>Reason for homestay accommodation</th>
												<td>
													<?php
                                                    	if($formThree['homestay_choosing_reason']!='' && $formThree['homestay_choosing_reason']!=3)
															echo $homestayChooseReasonList[$formThree['homestay_choosing_reason']];
														elseif($formThree['homestay_choosing_reason']==3)
															echo ucfirst ($formThree['homestay_choosing_reason_other']);
														
														if($formThree['homestay_choosing_reason']=='')
															echo 'n/a';
													?>
                                                </td>
											</tr>
                                            
                                            <tr>
												<th>Global Experience reference from</th>
												<td>
													<?php
                                                    	if($formThree['homestay_hear_ref']!='' && $formThree['homestay_hear_ref']!=7)
															echo $geRefList[$formThree['homestay_hear_ref']];
														elseif($formThree['homestay_hear_ref']==7)
															echo ucfirst ($formThree['homestay_hear_ref_other_val']);
														
														if($formThree['homestay_hear_ref']=='')
															echo 'n/a';
													?>
                                                </td>
											</tr>
                                         </tbody>
									</table>
								</div>
                                </div>
							</div>
                            <?php }else{?> 
                           <div class="about-area p-md"><p>Health details and preferences not provided yet.</p></div>
                           <?php } ?>
                          </div> 
                          
                           
     		</div>                 
		</div>
<script type="text/javascript">

$(document).ready(function(){

	Dropzone.options.shaDocumentsUpload = {
		maxFilesize: 5,
		acceptedFiles:'.pdf,.PDF,.docx,.xlsx,.jpeg,.jpg,.png,.JPG,.JPEG',
			init: function () {
			 	  this.on("success", function(file, responseText) {
					  if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0)
						   {
							  setTimeout(function(){
								  $('.dz-preview').remove();
								  },1500);
								  notiPop('success','Document uploaded successfully','')
								  $('#clientAgreements').html(responseText);
							}
				});
		  }
	};
	
	
	

	

	
	});
</script>