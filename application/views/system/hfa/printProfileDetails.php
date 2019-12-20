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
						if($formOne['title']!='')
							echo $nameTitleList[$formOne['title']];	
						?>
						<?=ucwords($formOne['fname'].' '.$formOne['lname'])?>
</h4>
<span>Host Family Application Details</span>
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
                        
                        <tr>
                        <th>Family Id: </th>
                        <td><?=$formOne['id']?></td>
                        </tr>
                          
                                                
                         <tr>
                        <th>Name: </th>
						<td><?php if($formOne['title']!=''){echo $nameTitleList[$formOne['title']]." ";}?><?=ucwords($formOne['fname'].' '.$formOne['lname'])?></td>
						</tr>
                        
                       
                        <tr>
                        <th>Email: </th>
						<td><?=$formOne['email']?></td>
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
                        
                        <?php if($formOne['work_phone']!=''){?>
                        <tr>
                        <th>Work phone: </th>
						<td><?=$formOne['work_phone']?> (W)</td>
						</tr>
                        <?php }?>
                        
                        <tr>
                        <th>Preferred way to contact: </th>
						<td><?php
								if($formOne['contact_way']=="1")
								{
									echo "Phone";
									if($formOne['contact_time']!="00:00:00")
										echo ", ".date('h:i A',strtotime($formOne['contact_time']));
								}
								else	
									echo "Email";
								echo " prefered";	
							?></td>
						</tr>
                   
                        
                        <tr>
                        <th>Address: </th>
						<td><?php if($formOne['street']!=''){	echo $formOne['street'].", ";}?><?=ucfirst($formOne['suburb']).", ".$stateList[$formOne['state']].", ".$formOne['postcode']?></td>
						</tr>
                        
                        <tr>
                        <th>Location: </th>
						<td><?php if($formOne['postal_address']=="0")
															echo "Same as home address";
														else	
															{
																if($formOne['street_postal']!='')
																	echo $formOne['street_postal'].", ";
																echo ucfirst($formOne['suburb_postal']).", ".$stateList[$formOne['state_postal']].", ".$formOne['postcode_postal'];
															}
							?></td>
						</tr>
                        
                     
                         </tbody>
                        </table>
                
			  	</div>
 </div>   
 </div>
 
 <?php if(!empty($formTwo)){?> 
 <div id="about-area">
              <div id="table-responsive" data-widget="{&quot;draggable&quot;: &quot;false&quot;}">
              <table cellspacing="0" cellpadding="0"  id="panel-heading">
              <thead>
              <tr>
              <th>Dwelling Details</th>
              </tr>
              </thead>
              </table>
              
			  	<div id="panel-body">
                
                        <table id="table">
                        <tbody>
                        
                        <tr>
												<th>Dwelling type</th>
												<td>
                                             <?php if($formTwo['d_type']!=''){echo $dwellingTypeList[$formTwo['d_type']];}else{echo "n/a";}?>
                                                </td>
											</tr>
                                            
                                              <tr>
                                                  <th>Main type of flooring</th>
                                                  <td><?php 
															if($formTwo['flooring']!='')
															{
																if($formTwo['flooring']!='5')
																	echo $floorTypeList[$formTwo['flooring']];
															}
															else
																echo 'n/a';	
															if($formTwo['flooring']=='5')	
																echo ucfirst($formTwo['flooring_other']);
													?></td>
                                              </tr>
                                              
                                               <tr>
												<th>Internet availability for students</th>
												<td>
                                             <?php
                                                    	if($formTwo['internet']=="1")
														{
																echo "Yes";
																
																if($formTwo['internet_type']==1)
																	echo ", Wireless broadband";
																elseif($formTwo['internet_type']==2)	
																	echo ", Cable broadband";
														}
														elseif($formTwo['internet']=="0")
																echo "No";
														else	
																echo "n/a";	
													?>
                                                </td>
											</tr>
                                            
                                             <tr>
												<th>Working smoke detector</th>
												<td>
                                             <?php
                                                    	if($formTwo['s_detector']=="1")
																echo "Yes";
														elseif($formTwo['s_detector']=="0")
																echo "No";
														else
																echo 'n/a';		
													?>
                                                </td>
											</tr>
                                            
                                             <tr>
												<th>Facilities</th>
												<td>
                                             <?php
														$facilities=array();
														if($formTwo['facilities']['pool']=="1")
																$facilities[]='Pool';
														if($formTwo['facilities']['tennis']=="1")
																$facilities[]='Tennis court';
														if($formTwo['facilities']['piano']=="1")
																$facilities[]='Piano';
														if($formTwo['facilities']['gym']=="1")
																$facilities[]='Gym';
														if($formTwo['facilities']['disable_access']=="1")
																$facilities[]='Disable access';
														if($formTwo['facilities']['other']=="1")
																$facilities[]=ucwords($formTwo['facilities']['other_val']);						
														
														if(!empty($facilities))
															echo implode(', ',$facilities);
														else
															echo "No facilities available.";	
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
              <th>Bedroom Details</th>
              </tr>
              </thead>
              </table>
              
              <?php foreach($formTwo['bedroomDetails'] as $bdK=>$bdV){?>
              
              <div id="heading-panel">
              
              <table cellspacing="0" cellpadding="0"  id="panel-headingss">
              <thead>
              <tr>
              <th>STUDENT BEDROOM <?=$bdK+1?></th>
              </tr>
              </thead>
              </table>
              
              
              <div id="panel-body">
                
               <table id="table">
             
              <tbody>
                        
                        <tr>
												<th>Room type</th>
												<td>
													<?=$roomTypeList[$bdV['type']]?>
                                                </td>
											</tr>
                                            
                                              <tr>
                                                  <th>Flooring type</th>
                                                  <td><?php
														if($bdV['flooring']!="5")
															echo ucfirst($floorTypeList[$bdV['flooring']]);
														else	
															echo ucfirst($bdV['flooring_other']);
													?></td>
                                              </tr>
                                              
                                               <tr>
                                                  <th>Room access</th>
                                                  <td><?php
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
													  ?></td>
                                              </tr>
                                              
                                               <tr>
                                              <th>Internal ensuite</th>
                                              <td>
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
                                          <th>Room available immediately</th>
                                          <td>
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
                                            ?>
                                          </td>
                                      </tr>
                                      
                                      <?php
											  if($bdV['avail']!="1" && strtotime($bdV['avail_from'])>strtotime(date('Y-m-d'))){?>
									<tr>
										<th>Student currently living in this room</th>
										<td>
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
										  ?>
										</td>
									</tr>
									<?php } ?>

                        
                         </tbody>
              </table>
              </div>
              </div>
              
                <?php }?>    
 </div>   
 </div>
 
 <div id="about-area">
              <div id="table-responsive" data-widget="{&quot;draggable&quot;: &quot;false&quot;}">
              <table cellspacing="0" cellpadding="0"  id="panel-heading">
              <thead>
              <tr>
              <th>Bathroom Details</th>
              </tr>
              </thead>
              </table>
              
              <?php foreach($formTwo['bathroomDetails'] as $btK=>$btV){?>
              
              <div id="heading-panel">
              
              <table cellspacing="0" cellpadding="0"  id="panel-headingss">
              <thead>
              <tr>
              <th>BATHROOM <?=$btK+1?></th>
              </tr>
              </thead>
              </table>
              
              
              <div id="panel-body">
                
               <table id="table">
             
              <tbody>
                                                                                      <tr>
                                                                                          <th>Available student</th>
                                                                                          <td>
                                                                                            <?php 
                                                                                                    if($btV['avail_to_student']==1)
                                                                                                        echo "Yes";
                                                                                                    elseif($btV['avail_to_student']==0)
                                                                                                        echo "No";	
                                                                                            ?>
                                                                                          </td>
                                                                                      </tr>
                                                                                      <tr>
                                                                                          <th>Bathroom includes</th>
                                                                                          <td>
                                                                                            <?php
                                                                                                $bathroomHas=array();
                                                                                                if($btV['toilet']=="1")
                                                                                                        $bathroomHas[]='Toilet';
                                                                                                if($btV['shower']=="1")
                                                                                                        $bathroomHas[]='Shower';
                                                                                                if($btV['bath']=="1")
                                                                                                        $bathroomHas[]='Bath';				
                                                                                                
                                                                                                if(!empty($bathroomHas))
                                                                                                    echo implode(', ',$bathroomHas);
                                                                                                else
                                                                                                    echo "n/a";	
                                                                                            ?>
                                                                                          </td>
                                                                                      </tr>
                                                                                     <tr>
                                                                                          <th>Is it ensuite?</th>
                                                                                          <td>
                                                                                            <?php
                                                                                                if($btV['ensuit']=="1")
                                                                                                    echo 'Yes';
                                                                                                elseif($btV['ensuit']=="0")
                                                                                                {	
                                                                                                    echo "No, located ";
                                                                                                    if($btV['in_out']=="1")
                                                                                                        echo "Inside the house";
                                                                                                    elseif($btV['in_out']=="2")
                                                                                                        echo "Outside the house";	
                                                                                                }
																								else
																									echo 'n/a';
                                                                                            ?>
                                                                                          </td>
                                                                                      </tr> 
                                                                                  </tbody>
              </table>
              </div>
              </div>
              
                <?php }?>    
 </div>   
 </div>
 
 
 <div id="about-area">
              <div id="table-responsive" data-widget="{&quot;draggable&quot;: &quot;false&quot;}">
              <table cellspacing="0" cellpadding="0"  id="panel-heading">
              <thead>
              <tr>
              <th>Laundry Details</th>
              </tr>
              </thead>
              </table>
              
			  	<div id="panel-body">
                
                        <table id="table">
                        <tbody>
											<tr>
												<th>Laundry available to the student</th>
												<td>
														<?php
                                                        	if($formTwo['laundry']=="0")
																echo "No";
															elseif($formTwo['laundry']=="1")
															  {
																  echo "Yes";
																  if($formTwo['laundry_outside']=="1")
																	  	echo ", outside the house";
																  elseif($formTwo['laundry_outside']=="0")
																	  	echo ", inside the house";		
																  	
															  }
														?>
                                                </td>
											</tr>
										</tbody>
                        </table>
                
			  	</div>
 </div>   
 </div>
 
 <?php }else{?> 
                           <div class="about-area p-md"><p>Property details not provided yet.</p></div>
 <?php } ?>


 
  <?php if(!empty($formThree)){?>
 <div id="about-area">
              <div id="table-responsive" data-widget="{&quot;draggable&quot;: &quot;false&quot;}">
              <table cellspacing="0" cellpadding="0"  id="panel-heading">
              <thead>
              <tr>
              <th>Family Member Details</th>
              </tr>
              </thead>
              </table>
              
			  	 <?php for($fm=0;$fm<$formThree['family_members'];$fm++){?>
              
              <div id="heading-panel">
              
              <table cellspacing="0" cellpadding="0"  id="panel-headingss">
              <thead>
              <tr>
              <th>Member <?=$fm+1?></th>
              </tr>
              </thead>
              </table>
              
              
              <div id="panel-body">
                
               <table id="table">
             
              <tbody>
                                                                                        <tr>
                                                                                            <th>Name</th>
                                                                                            <td><?php if($formThree['memberDetails'][$fm]['title']!=''){echo $nameTitleList[$formThree['memberDetails'][$fm]['title']]." ";}?><?=ucwords($formThree['memberDetails'][$fm]['fname'].' '.$formThree['memberDetails'][$fm]['lname'])?></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th>Date of birth</th>
                                                                                            <td><?php if($formThree['memberDetails'][$fm]['dob']!='0000-00-00'){
																								echo date('d M Y',strtotime($formThree['memberDetails'][$fm]['dob'])).' '.'(Age '.age_from_dob($formThree['memberDetails'][$fm]['dob']).')';}?></td>
                                                                                        </tr>
																						 
                                                                                         <tr>
                                                                                            <th>Gender</th>
                                                                                            <td>
																							<?=$genderList[$formThree['memberDetails'][$fm]['gender']]?></td>
                                                                                        </tr>
																						<tr>
                                                                                            <th>Contact number</th>
                                                                                            <td><?php  if($formThree['memberDetails'][$fm]['contact_number']!='')
                                                                                                          echo $formThree['memberDetails'][$fm]['contact_number'];
																									  else
																									  	  echo 'n/a';?></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th>Family role</th>
                                                                                            <td>
                                                                                                  <?php
                                                                                                      if($formThree['memberDetails'][$fm]['role']!='')
                                                                                                          echo $family_role[$formThree['memberDetails'][$fm]['role']];
																									  else
																									  	  echo 'n/a';
                                                                                                  ?>
                                                                                              </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th>Occupation</th>
                                                                                            <td>
                                                                                            		<?php $formThree['memberDetails'][$fm]['occu']=trim($formThree['memberDetails'][$fm]['occu']);
                                                                                                    	if($formThree['memberDetails'][$fm]['occu'] !='') {
																											echo ucfirst($formThree['memberDetails'][$fm]['occu']);
																										}
																										else {
																											echo 'n/a';	
																										}
																									?>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th>Smoker</th>
                                                                                            <td><?=$smokingHabbits[$formThree['memberDetails'][$fm]['smoke']]?></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th>Ethnicity</th>
                                                                                            <td>
                                                                                                      <?php
                                                                                                      if($formThree['memberDetails'][$fm]['ethnicity']!='')
                                                                                                          echo $nationList[$formThree['memberDetails'][$fm]['ethnicity']];
																									  else
																									  		echo 'n/a';	  
                                                                                                  ?>
                                                                                            </td>
                                                                                        </tr>
                                                                                       <tr>
                                                                                            <th>Languages spoken</th>
                                                                                            <td><?php //$formThree['memberDetails'][$fm]['language']?>
																								<?php $languages_arr = array(); 
																									for($memLang=0;$memLang<$formThree['memberDetails'][$fm]['language'];$memLang++){ 
																										$loop_str = $languageList[$formThree['memberDetails'][$fm]['languages'][$memLang]['language']];
																										
																										if($formThree['memberDetails'][$fm]['languages'][$memLang]['language']=='25')
																											$loop_str .=" - ".$formThree['memberDetails'][$fm]['languages'][$memLang]['other_language'];
																										
                                                                                                        if($formThree['memberDetails'][$fm]['languages'][$memLang]['prof']!='') {
																											$loop_str .= " (".$languagePrificiencyList[$formThree['memberDetails'][$fm]['languages'][$memLang]['prof']].")";
																										}
                                                                                                        $languages_arr[]=$loop_str;
																										
																								} 
																								echo implode(', ',$languages_arr);
																								unset($languages_arr);
																								?>
																							</td>
                                                                                        </tr>
                                            
                                                                                        <?php 
																								$age_calculate = exact_age_from_dob($formThree['memberDetails'][$fm]['dob']); 
																								if($age_calculate >17 ) {
																						?>
                                                                                        <tr>
                                                                                              <th>Working with Children Check (WWCC)</th>
                                                                                              <td>
                                                                                                  <?php
                                                                                                      if($formThree['memberDetails'][$fm]['wwcc']=="0")
                                                                                                          echo "No";
                                                                                                      elseif($formThree['memberDetails'][$fm]['wwcc']=="1")
                                                                                                          echo "Yes";
																									  else
																									  	  echo "n/a";
                                                                                                  ?>
                                                                                              </td>
                                                                                        </tr>
																						<?php } ?>
                                                                                          <?php if($formThree['memberDetails'][$fm]['wwcc']=="1"){?>
                                                                                          <tr>
                                                                                              <th>Clearance received</th>
                                                                                              <td>
                                                                                                  <?php
                                                                                                      if($formThree['memberDetails'][$fm]['wwcc_clearence']=="0")
                                                                                                          echo "No";
                                                                                                      elseif($formThree['memberDetails'][$fm]['wwcc_clearence']=="1")
                                                                                                          echo "Yes";
                                                                                                  ?>
                                                                                              </td>
                                                                                          </tr>
                                                                                          <?php if($formThree['memberDetails'][$fm]['wwcc_clearence']=="0"){?>
                                                                                          <tr>
                                                                                              <th>Application no.</th>
                                                                                              <td>
                                                                                              		<?php
                                                                                                    		if(trim($formThree['memberDetails'][$fm]['wwcc_application_no'])!='')
																												echo $formThree['memberDetails'][$fm]['wwcc_application_no'];
																											else
																												echo 'n/a';	
																									?>
                                                                                              </td>
                                                                                          </tr>
                                                                                          <?php } ?>    
                                                                                          <?php if($formThree['memberDetails'][$fm]['wwcc_clearence']=="1"){?>
                                                                                          <tr>
                                                                                              <th>Clearance no.</th>
                                                                                              <td>
                                                                                              		<?php
                                                                                                    		if(trim($formThree['memberDetails'][$fm]['wwcc_clearence_no'])!='')
																												echo $formThree['memberDetails'][$fm]['wwcc_clearence_no'];
																											else
																												echo 'n/a';	
																									?>
                                                                                              </td>
                                                                                          </tr>
                                                                                          <tr>
                                                                                              <th>Expiry date</th>
                                                                                              <td>
                                                                                                      <?php 
                                                                                                              if($formThree['memberDetails'][$fm]['wwcc_expiry']!="0000-00-00")
                                                                                                                  echo date('d M Y',strtotime($formThree['memberDetails'][$fm]['wwcc_expiry']));
																											else
																													echo 'n/a';
                                                                                                      ?>
                                                                                              </td>
                                                                                              </tr>
                                                                                              <?php 
                                                                                                  if($formThree['memberDetails'][$fm]['wwcc_file']!=""){?>
                                                                                                          <tr>
                                                                                                              <th>Uploaded File</th>
                                                                                                              <td><?='<a style="color:hsl(199, 98%, 48%);" href="'.static_url().'uploads/hfa/wwcc/'.$formThree['memberDetails'][$fm]['wwcc_file'].'" target="_blank">Preview file</a>'?></td>
                                                                                                          </tr>
                                                                                          <?php } ?>
                                                                                          <?php } ?>
                                                                                          
                                                                                          <?php } ?>
                                                                                    </tbody>
              </table>
              </div>
              </div>
              
                <?php }?>    
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
                                                  <th>Pets</th>
                                                  <td>
                                                  			<?php
																if($formThree['pets']=="0")
                                                            		echo "No";
																elseif($formThree['pets']=="1")
																	echo "Yes ";
																
																if($formThree['pets']=="1")	
																{
																	$pets=array();
																	if($formThree['pet_dog']==1)
																		$pets[]='Dog';
																	if($formThree['pet_bird']==1)
																		$pets[]='Bird';
																	if($formThree['pet_cat']==1)
																		$pets[]='Cat';
																	if($formThree['pet_other']==1)
																		$pets[]=ucfirst ($formThree['pet_other_val']);
																		
																	if(!empty($pets))
																		echo '- '.implode(', ',$pets);
																}
															?>
                                                  </td>
                                              </tr>
                                              <?php if($formThree['pets']=="1"){?>
                                              <tr>
                                                  <th>Pets live inside</th>
                                                  <td>
                                                  		<?php
                                                        	if($formThree['pet_inside']=="0")
																echo "No";
															elseif($formThree['pet_inside']=="1")
																echo "Yes";
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
              <th>Insurance details</th>
              </tr>
              </thead>
              </table>
              
			  	<div id="panel-body">
                
                        <table id="table">
  <tbody>
                                              <tr>
                                                  <th>Public Liability insurance</th>
                                                  <td>
                                                  			<?php
																if($formThree['insurance']=="0")
                                                            		echo "No";
																elseif($formThree['insurance']=="1")
																	echo "Yes";
															?>
                                                  </td>
                                              </tr>
                                              
                                              <?php if($formThree['insurance']=="1"){?>
                                              	<tr>
                                                  <th>Insurance provider</th>
                                                  <td>
												  		<?php
                                                        	if($formThree['ins_provider']!='')
																echo ucfirst ($formThree['ins_provider']);
															else
																echo 'n/a';	
														?>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <th>Policy no.</th>
                                                  <td>
                                                  		<?php
                                                        	if($formThree['ins_policy_no']!='')
																echo $formThree['ins_policy_no'];
															else	
																echo 'n/a';	
														?>
                                                  </td>
                                              </tr>
                                               <tr>
                                                  <th>Expiry date</th>
                                                   <td>
												   			<?php 
																if($formThree['ins_expiry']!='0000-00-00')
																	echo date('d M Y',strtotime($formThree['ins_expiry']));
																else
																	echo 'n/a';	
															?>
                                                   </td>
                                              </tr>
                                              <?php  if($formThree['ins_file']!=""){?>
                                              <tr>
                                                  <th>Uploaded File</th>
                                                   <td>
												   			<?='<a style="color:hsl(199, 98%, 48%);" href="'.static_url().'uploads/hfa/ins/'.$formThree['ins_file'].'" target="_blank">Preview file</a>'?>
                                                   </td>
                                              </tr>
                                              <?php } ?>
                                               <tr>
                                                  <th>$20 million Public Liability cover</th>
                                                  <td>
                                                  			<?php
																if($formThree['20_million']=="0")
                                                            		echo "No";
																elseif($formThree['20_million']=="1")
																	echo "Yes";
																else
																	echo 'n/a';	
															?>
                                                  </td>
                                              </tr>
                                              <?php } ?>
                                              
                                              <tr>
                                                  <th>Home Contents insurance</th>
                                                  <td>
                                                  		<?php
                                                        	if($formThree['ins_content']=="0")
																echo "No";
															elseif($formThree['ins_content']=="1")
																echo "Yes";
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
              <th>General Details</th>
              </tr>
              </thead>
              </table>
              
			  	<div id="panel-body">
                
                        <table id="table">
                        		<tbody>
                                              <tr>
                                                  <th>Main religion</th>
                                                  <td>
                                                  			<?php
																if($formThree['main_religion']!="0" && $formThree['main_religion']!="")
                                                            		echo $religionList[$formThree['main_religion']];
																elseif($formThree['main_religion']=="0")
																	echo $formThree['main_religion_other'];	
																
																if($formThree['main_religion']=="")
																	echo 'n/a';
															?>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <th>Hosted international students in the past</th>
                                                  <td>
                                                  		<?php
                                                        	if($formThree['hosted_international_in_past']=="0")
																echo "No";
															elseif($formThree['hosted_international_in_past']=="1")
																echo "Yes";
															else	
																echo 'n/a';
														?>
                                                  </td>
                                              </tr>
                                              <?php if($formThree['hosted_international_in_past']==1 && $formThree['homestay_exp']!=''){?>
                                              <tr>
                                                  <th>Homestay family experience</th>
                                                  <td>
												  		<?php
                                                        	if(trim($formThree['homestay_exp']!=''))
																echo ucfirst ($formThree['homestay_exp']);
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
 	<?php }else{?> 
                           <div class="about-area p-md"><p>Family details not provided yet.</p></div>
                           <?php } ?>
 

<?php if(!empty($formFour) || $formOne['ref']!='' ){?>
 <div id="about-area">
              <div id="table-responsive" data-widget="{&quot;draggable&quot;: &quot;false&quot;}">
              <table cellspacing="0" cellpadding="0"  id="panel-heading">
              <thead>
              <tr>
              <th>STUDENT PREFERENCES</th>
              </tr>
              </thead>
              </table>
              
			  	<div id="panel-body">
                
                        <table id="table">
  <tbody>
													  <?php if(!empty($formFour)){?>
                                                      <tr>
                                                          <th>Student age preference</th>
                                                          <td>
														  	<?php 
																if($formFour['age_pref']=='1')
																	echo "Under 18";
																elseif($formFour['age_pref']=='2')
																	echo "Over 18";
																elseif($formFour['age_pref']=='3')
																	echo "No preference";
																else
																	echo 'n/a'	
															?>
                                                          </td>
                                                      </tr>
                                                      <tr>
                                                          <th>Student gender preference</th>
                                                          <td>
                                                              <?php 
																if($formFour['gender_pref']=='1')
																	echo "Male";
																elseif($formFour['gender_pref']=='2')
																	echo "Female";
																elseif($formFour['gender_pref']=='3')
																	echo "No preference";
																else
																	echo 'n/a'	
															?>
                                                          </td>
                                                      </tr>
                                                      <tr>
                                                          <th>Reason for age and gender preference</th>
                                                          <td>
														  			<?php
                                                                    	if(trim($formFour['reason_age_gender'])!='')
																			echo ucfirst ($formFour['reason_age_gender']);
																		else
																			echo 'n/a';
																	?>
                                                          </td>
                                                      </tr>
                                                      <tr>
                                                          <th>Accommodate students with disabilities</th>
                                                          <td>
                                                              <?php
                                                                  if($formFour['disable_students']=="1")
                                                                          echo "Yes";
                                                                  elseif($formFour['disable_students']=="0")
                                                                          echo "No";
																  else
																  		 echo 'n/a';	
                                                              ?>
                                                          </td>
                                                      </tr>
                                                      <tr>
                                                          <th>Accommodate students who smoke</th>
                                                          <td>
                                                              <?php
                                                                  if($formFour['smoker_students']!="")
                                                                          echo $smokingHabbits[$formFour['smoker_students']];
																  else
																		  echo 'n/a';
                                                              ?>
                                                          </td>
                                                      </tr>
                                                      <tr>
                                                          <th>Accommodate students with special dietary requirements</th>
                                                          <td>
                                                              <?php
																  if($formFour['diet_student']=="0")
																	echo "No";
																  elseif($formFour['diet_student']=="1")
																	echo "Yes";
																  else
																  	echo 'n/a';	
																
                                                                  $dietReq=array();
                                                                  if($formFour['diet_req_veg']=="1")
                                                                          $dietReq[]='Vegetarian';
                                                                 if($formFour['diet_req_gluten']=="1")
                                                                          $dietReq[]='Gluten/Lactose Free';
																if($formFour['diet_req_no_pork']=="1")
                                                                          $dietReq[]='No Pork';
																if($formFour['diet_req_food_allergy']=="1")
                                                                          $dietReq[]='Food Allergies';
																  		  		  		  						
                                                                if(!empty($dietReq) && $formFour['diet_student']=="1")
                                                                      echo " that is ",implode(', ',$dietReq);	
                                                              ?>
                                                          </td>
                                                      </tr>
                                                     <tr>
                                                          <th>Accommodate students with allergies</th>
                                                          <td>
                                                              <?php
																  if($formFour['allergic_students']=="0")
																	echo "No";
																  elseif($formFour['allergic_students']=="1")
																	echo "Yes";
																  else
																  	echo 'n/a';			
																
                                                                  $allergy=array();
                                                                  if($formFour['allerry_hay_fever']=="1")
                                                                          $allergy[]='Hay Fever';
                                                                  if($formFour['allerry_asthma']=="1")
                                                                          $allergy[]='Asthma';
																  if($formFour['allerry_lactose']=="1")
                                                                          $allergy[]='Lactose Intolerance';
																 if($formFour['allerry_gluten']=="1")
                                                                          $allergy[]='Gluten Intolerance';
																 if($formFour['allerry_peanut']=="1")
                                                                          $allergy[]='Peanut Allergies';
																 if($formFour['allerry_dust']=="1")
                                                                          $allergy[]='Dust Allergies';
																 if($formFour['allerry_other']=="1")
																	   {
																		   if($formFour['allerry_other_val']!="")
																		  	$allergy[]=ucfirst ($formFour['allerry_other_val']);		  		  	  
																	   }
																  		  		  		  						
                                                                  if(!empty($allergy) && $formFour['allergic_students']=="1")
                                                                      echo " that is ",implode(', ',$allergy);	
                                                              ?>
                                                          </td>
                                                      </tr> 
                                                      <tr>
                                                          <th>Other student preferences</th>
                                                          <td>
														  			<?php
                                                                    		if(trim($formFour['other_pref'])!='')
																				echo ucfirst ($formFour['other_pref']);
																			else
																				echo 'n/a';	
																	?>
                                                          </td>
                                                      </tr> 
                                                     <tr>
                                                     <?php } ?>
                                                        <th>Global Experience reference from</th>
                                                        <td>
															<?php
                                                            	if($formOne['ref']=="7")
																{
																	echo !empty($formOne['ref_other']) ? $geRefList[$formOne['ref']]. ' - ' . $formOne['ref_other'] : $geRefList[$formOne['ref']];
																	/*if($formFour['ref_other']!='')
																		echo $formFour['ref_other'];	*/
																}
																else if($formOne['ref']=="2"){
																	echo !empty($formOne['ref_homestay_family']) ? $geRefList[$formOne['ref']]. '  -  ' . $formOne['ref_homestay_family'] : $geRefList[$formOne['ref']];
																}
																elseif($formOne['ref']!="")
																	echo $geRefList[$formOne['ref']];
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
  <?php }else{?> 
                           							<div class="about-area p-md"><p>Student preferences not provided yet.</p></div>
                           					<?php } ?>
 
   
<!-- ---------------------------------colmd12end------------------------------------------------>
 
  </div>
            
            	
		
</div>
	
</body>

</html>