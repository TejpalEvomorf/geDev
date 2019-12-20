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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	
	<link rel='stylesheet' type='text/css' href='<?=static_url()?>system/css/print-style.css' />
	<link rel='stylesheet' type='text/css' href='<?=static_url()?>system/css/media-print.css' media="print" />
     <link type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,400,400italic,500' rel='stylesheet'>

</head>

<body>

<div id="page-wrap">
		
<div id="identity">

<div id="logo" >
<h4 id="media-heading">
<?php
                        $mname='';
						if($formOne['mname']!='')
							$mname=$formOne['mname']." ";
						
						if($formOne['title']!='')
							echo $nameTitleList[$formOne['title']];	
						?>
						<?=ucwords($formOne['fname'].' '.$mname.$formOne['lname'])?>
</h4>
<span>Student Application Details</span>
</div>


</div>
		
<div style="clear:both"></div>

<div id="col-md-12">	
<!-- ---------------------------------colmd12start------------------------------------------------>
	
			<div id="about-area">
              <div id="table-responsive" data-widget="{&quot;draggable&quot;: &quot;false&quot;}">
              <table cellspacing="0" cellpadding="0"  id="panel-heading">
              <thead>
              <tr>
              <th>General Details</th>
              </tr>
              </thead>
              </table>
              
			  	<div id="panel-body">
                
                        <table id="table">
                        <tbody>
                        
                         <?php   if(!empty($formOne['sha_student_no'])){?>
                        <tr>
                        <th>Student no: </th>
                        <td><?= $formOne['sha_student_no']?></td>
                        </tr>
                        <?php }?>
                          
                                                
                         <tr>
                        <th>Gender: </th>
						<td><?=$genderList[$formOne['gender']]?></td>
						</tr>
                        
                        <tr>
                        <th>DOB: </th>
						<td><?php if($formOne['dob']!='0000-00-00'){echo date('d M Y',strtotime($formOne['dob']));}else{echo "Not available";}?></td>
						</tr>
                        
                        <tr>
                        <th>Email: </th>
						<td><?php if($formOne['email']!=''){echo '<a class="mailto" href="mailto:'.$formOne['email'].'">'.$formOne['email'].'</a>';}else{echo "Not available";}?></td>
						</tr>
                        
                        <tr>
                        <th>Phone: </th>
						<td><?=$formOne['mobile']?></td>
						</tr>
                        
                        <?php if($formOne['home_phone']!=''){?>
                        <tr>
                        <th>Home phone: </th>
						<td><?=$formOne['home_phone']?> (H)</td>
						</tr>
                        <?php }?>
                        
                        <?php if($formOne['nation']!=0){?>
                        <tr>
                        <th>Nationality: </th>
						<td><?=$nationList[$formOne['nation']]?></td>
						</tr>
                        <?php }?>
                        
                        <tr>
                        <th>Homestay type: </th>
						<td><?=$accomodationTypeList[$formOne['accomodation_type']]?></td>
						</tr>
                        
                        <?php if($formOne['accomodation_type']==2 && $formOne['student_name2']!=''){?>
                        <tr>
                        <th>Second student name: </th>
						<td><?=$formOne['student_name2']?></td>
						</tr>
                        <?php } ?>
                        
                        <tr>
                        <th>Arrival date: </th>
						<td>
						<?php 
							  if(isset($formOne['arrival_date']) && $formOne['arrival_date']!='0000-00-00')
								  echo date('d M Y',strtotime($formOne['arrival_date']));
							  else
								  echo 'n/a'; 
						?>
                        </td>
						</tr>
                        
                        <tr>
                        <th>Passport number: </th>
						<td>
						<?php 
							if(isset($formOne['passport_no']) && $formOne['passport_no']!='')
								echo $formOne['passport_no'];
							else
								echo 'n/a';
						?>
                        </td>
						</tr>
                        
                         <tr>
                        <th>Passport expiry date: </th>
						<td>
						<?php 
							if(isset($formOne['passport_exp']) && $formOne['passport_exp']!='0000-00-00')
								echo date('d M Y',strtotime($formOne['passport_exp']));
							else
								echo 'n/a'; 
						?>
                        </td>
						</tr>
                        
                        <tr>
                          <th>Languages spoken:</th>
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
                        <th>Ethnicity: </th>
						<td><?php if($formTwo['ethnicity']!=''){echo $nationList[$formTwo['ethnicity']];}else{echo 'n/a';}?></td>
						</tr>
                        
                        <tr>
                        <th>Religion: </th>
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
 
 <div id="about-area">
              <div id="table-responsive" data-widget="{&quot;draggable&quot;: &quot;false&quot;}">
              <table cellspacing="0" cellpadding="0"  id="panel-heading">
              <thead>
              <tr>
              <th>Pet Details</th>
              </tr>
              </thead>
              </table>
              
			  	<div id="panel-body">
                
                        <table id="table">
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
 
 
 <div id="about-area">
              <div id="table-responsive" data-widget="{&quot;draggable&quot;: &quot;false&quot;}">
              <table cellspacing="0" cellpadding="0"  id="panel-heading">
              <thead>
              <tr>
              <th>Insurance Details</th>
              </tr>
              </thead>
              </table>
              
			  	<div id="panel-body">
                
                        <table id="table">
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
 
 
 <div id="about-area">
              <div id="table-responsive" data-widget="{&quot;draggable&quot;: &quot;false&quot;}">
              <table cellspacing="0" cellpadding="0"  id="panel-heading">
              <thead>
              <tr>
              <th>Airport Pickup Service</th>
              </tr>
              </thead>
              </table>
              
			  	<div id="panel-body">
                
                        <table id="table">
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
											if($formTwo['airport_pickup']==1){
											?>
                                              <tr>
                                                  <th>Arrival date / Time</th>
                                                  <td>
												  	<?php if($formOne['arrival_date']!='0000-00-00'){echo date('d M Y',strtotime($formOne['arrival_date']));}?><?php if($formOne['arrival_date']!='0000-00-00' && $formTwo['airport_arrival_time']!='00:00:00'){echo ", ";}?><?php if($formTwo['airport_arrival_time']!='00:00:00'){echo date('h:i A',strtotime($formTwo['airport_arrival_time']));}?><?php if($formOne['arrival_date']=='0000-00-00' && $formTwo['airport_arrival_time']=='00:00:00'){echo "n/a";}?>
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
                                            <?php }}else{ ?>
                                            
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
 
 
 <div id="about-area">
              <div id="table-responsive" data-widget="{&quot;draggable&quot;: &quot;false&quot;}">
              <table cellspacing="0" cellpadding="0"  id="panel-heading">
              <thead>
              <tr>
              <th>Student's Story</th>
              </tr>
              </thead>
              </table>
              
			  	<div id="panel-body">
                
                        <table id="table">
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
												<th>About Student</th>
												<td>
													<?php if($formTwo['student_desc']!=''){?>
										  <?=$formTwo['student_desc']?></p>
                                      <?php }else{?> 
                                      <p style="margin-bottom:0px;">Not available. </p> 
                                      <?php } ?>
                                                </td>
											</tr>
                                            
                                            <tr>
												<th>About Student's Family</th>
												<td>
													 <?php if($formTwo['student_family_desc']!=''){?>                    
           <p style=" margin-bottom:0px;"> <?=$formTwo['student_family_desc']?></p>
			  <?php }else{ ?>
              Not available.
              <?php } ?>
                                                </td>
											</tr>
                                            
                                              
                                         </tbody>
                        </table>
                
			  	</div>
 </div>   
 </div>
 
 
  <?php if($age<18){?>
 <div id="about-area">
              <div id="table-responsive" data-widget="{&quot;draggable&quot;: &quot;false&quot;}">
              <table cellspacing="0" cellpadding="0"  id="panel-heading">
              <thead>
              <tr>
              <th>Caregiving details</th>
              </tr>
              </thead>
              </table>
              
			  	<div id="panel-body">
                
                        <table id="table">
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
 
 
<?php if(!empty($formThree)){?>
 <div id="about-area">
              <div id="table-responsive" data-widget="{&quot;draggable&quot;: &quot;false&quot;}">
              <table cellspacing="0" cellpadding="0"  id="panel-heading">
              <thead>
              <tr>
              <th>Your Health Details</th>
              </tr>
              </thead>
              </table>
              
			  	<div id="panel-body">
                
                        <table id="table">
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
 
 
  <div id="about-area">
              <div id="table-responsive" data-widget="{&quot;draggable&quot;: &quot;false&quot;}">
              <table cellspacing="0" cellpadding="0"  id="panel-heading">
              <thead>
              <tr>
              <th>Homestay Family Preferences</th>
              </tr>
              </thead>
              </table>
              
			  	<div id="panel-body">
                
                        <table id="table">
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
 
 
 <div id="about-area">
              <div id="table-responsive" data-widget="{&quot;draggable&quot;: &quot;false&quot;}">
              <table cellspacing="0" cellpadding="0"  id="panel-heading">
              <thead>
              <tr>
              <th>College/Institution Details</th>
              </tr>
              </thead>
              </table>
              
			  	<div id="panel-body">
                
                        <table id="table">
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
<div class="about-area"><p>Health details and preferences not provided yet.</p></div>
 <?php } ?>  

 
<!-- ---------------------------------colmd12end------------------------------------------------>
 
  </div>
            
            	
		
</div>
	
</body>

</html>