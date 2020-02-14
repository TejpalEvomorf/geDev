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
$employeeList=employeeList();
$gf = 'Granny flat';
$nm = 'Not mentioned';
?>
            <div class="col-md-3">
                        <div class="panel panel-profile panel panel-bluegraylight">
                            <div class="panel-heading">
                            <h2>General Details</h2>
                        </div>
			  	<div class="panel-body">
					<div>
                    <div class="personel-info pt-n">
							<span class="icon"><i class="material-icons">person_pin</i></span>
							<span>Family Id: <?=$formOne['id']?></span>
						</div>
                       <div class="personel-info">
							<span class="icon"><i class="material-icons">person</i></span>
							<span><?php if($formOne['title']!=''){echo $nameTitleList[$formOne['title']]." ";}?><?=ucwords($formOne['fname'].' '.$formOne['lname'])?></span>
						</div>
                        
						<div class="personel-info">
							<span class="icon"><i class="material-icons">email</i></span>
							<span><a href="mailto:<?=$formOne['email']?>" class="mailto"><?=$formOne['email']?></a></span>
						</div>

						<div class="personel-info">
							<span class="icon"><i class="material-icons">phone_iphone</i></span>
							<span><?=$formOne['mobile']?></span>
						</div>
                        
                        <?php if($formOne['home_phone']!=''){?>
                            <div class="personel-info">
								<span class="icon"><i class="material-icons">call</i></span>
								<span><?=$formOne['home_phone']?> (H)</span>
							</div>
                        <?php }?>
                        <?php if($formOne['work_phone']!=''){?>
                            <div class="personel-info">
								<span class="icon"><i class="material-icons">call_end</i></span>
								<span><?=$formOne['work_phone']?> (W)</span>
							</div>
                        <?php }?>
                        
                        
                        <div class="personel-info">
							<span class="icon"><i class="material-icons">perm_phone_msg</i></span>
							<span>
							<?php
								if($formOne['contact_way']=="1")
								{
									echo "Phone";
									if($formOne['contact_time']!="00:00:00")
										echo ", ".date('H:i',strtotime($formOne['contact_time']));
								}
								else	
									echo "Email";
								echo " prefered";	
							?>
                            </span>
						</div>
                        
                        <?php /* if($formOne['family_members']!=''){?>
							<div class="personel-info">
								<span class="icon"><i class="material-icons">group</i></span>
								<span><?=$formOne['family_members']?></span>
							</div>
                          <?php } */ ?>
                          
                         
						<?php
							$addressForMap='';
							if($formOne['street']!='')
								$addressForMap .=$formOne['street'].", ";
							$addressForMap .=ucfirst($formOne['suburb']).", ".$stateList[$formOne['state']].", ".$formOne['postcode'];
							//$addressForMap=str_replace("'",'',$addressForMap);
						?>
						<div class="personel-info">
							<span class="icon"><i class="material-icons">place</i></span>
							<?=getMapLocationLink($addressForMap)?>
						</div>

						<div class="personel-info pb-n">
							<span class="icon"><i class="material-icons">add_location</i></span>
							<span>
                            <?php if($formOne['postal_address']=="0")
															echo "Same as home address";
														else	
															{
																$addressForMapPostal='';
																if($formOne['street_postal']!='')
																	$addressForMapPostal .=$formOne['street_postal'].", ";
																$addressForMapPostal .=ucfirst($formOne['suburb_postal']).", ".$stateList[$formOne['state_postal']].", ".$formOne['postcode_postal'];
																
																echo getMapLocationLink($addressForMapPostal);
															}
							?>
                            </span>
						</div>
					</div>

			  	</div>
                </div>
            
            
            
	  <div class="panel panel-profile panel panel-bluegraylight">
					  <div class="panel-heading">
					  <h2>Call Logs</h2>
				  </div>
		  <div class="panel-body">
                    <!--<div class="about-area">-->
                            <button class="btn-raised btn-primary btn btn-sm" data-toggle="modal" data-target="#model_hfaCallLog" style="margin-bottom: 40px;">New Call log</button> 
                    <!--</div>-->
                    <div id="callLog" style="padding-left:20px;">
                        <?php $this->load->view('system/hfa/callLog');?>
                    </div>
		  </div>
	  </div>
      
      <div class="panel panel-profile panel panel-bluegraylight">
					  <div class="panel-heading">
					  <h2>Visits and reports</h2>
				  </div>
		  <div class="panel-body">
          
          <!--radio boxes-->
          <div class="row">
						  <div class="col-sm-8">
							  
                                    <form id="hfaOfficeUseRevisitDurationForm">
                                        <input type="hidden" name="id" value="<?=$formOne['id']?>" />
                                        
                                        <label  class="mt-n control-label filterItemLabel">Select revisit duration</label>
                                        <div class="radio block">
                                        <label>
                                            <input type="radio" name="revisit_duration" value="6" <?php if($formOne['revisit_duration']=='6'){echo 'checked';}?>>
                                            <span class="circle"></span>
                                            <span class="check"></span>
                                            6 months
                                        </label>
                                        </div>
                                        <div class="radio block">
                                        <label>
                                            <input type="radio" name="revisit_duration" value="12" <?php if($formOne['revisit_duration']=='12'){echo 'checked';}?>>
                                            <span class="circle"></span>
                                            <span class="check"></span>
                                            12 months
                                        </label>
                                        </div>
                                    </form>
							 
						  </div>
					  </div>
          <!--redio boxes #ENDS-->
          
                    <!--<div class="about-area">-->
                            <button class="btn-raised btn-primary btn btn-sm" data-toggle="modal" data-target="#model_hfaVisits" style="margin-bottom: 40px;">Add new visit</button> 
                    <!--</div>-->
                    <div id="visits" style="padding-left:20px;">
                        <?php $this->load->view('system/hfa/visits');?>
                    </div>
		  </div>
	  </div>

    <div class="panel panel-profile panel panel-bluegraylight">
					  <div class="panel-heading">
					  <h2>Home Description</h2>
				  </div>
		  <div class="panel-body">
						  <div class="about-area">
								  <p class="pre-wrap">
                                  <?php 
								  	if($formTwo['home_desc']!='')
								  		echo $formTwo['home_desc'];
									else
										echo "Not available.";
                                    ?>
                                  </p> 
						  </div>
		  </div>
	  </div>          
            
<div class="panel panel-profile panel panel-bluegraylight">
                <div class="panel-heading">
                <h2>Family Description</h2>
            </div>
    <div class="panel-body">
        <div class="pre-wrap">
        <?php if($formThree['family_desc']!='')
    	        	echo $formThree['family_desc'];
				else
					echo "Not available.";
			?>
        </div>
    </div>
</div>

                <div class="panel panel-profile panel-bluegraylight">
                    <div class="panel-heading">
                        <h2>UPLOAD Document</h2>
                    </div>
                    <div class="panel-body">
                        <form action="<?=site_url()?>hfa/hfa_document_upload" id="hf-documents-upload" class="dropzone">
                            <input type="hidden" name="clientId" id="clientId" value="<?=$formOne['id']?>" />
                        </form>
                    </div>
                </div>
				<div class="panel panel-profile panel-bluegraylight" id="clientAgreements">
                <?php $this->load->view('system/hfa/document_list');?>
                 </div>        

		<?php if($formOne['EC_name']!='' || $formOne['EC_relation']!='' || $formOne['EC_phone']!='' || $formOne['EC_email']!=''){?>
		<div class="panel panel-profile panel-bluegraylight">
                          <div class="panel-heading">
                          <h2>Emergency contact details</h2>
                      </div>
              <div class="about-area panel-body">
                                  <div class="table-responsive">
                                      
                                      <table class="table about-table">
                                          <tbody>
                                              <tr>
                                                  <td><b>Name</b> :
														<?php 
                                                              if($formOne['EC_name']!='')
															  	echo $formOne['EC_name'];
															  else	
															   echo "Not mentioned";	
                                                        ?>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td><b>Relationship to this person</b> :
														<?php 
                                                              if($formOne['EC_relation']!='')
															  	echo $formOne['EC_relation'];
															  else	
															   echo "Not mentioned";	
                                                        ?>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td><b>Phone number</b> :
														<?php 
                                                              if($formOne['EC_phone']!='')
															  	echo $formOne['EC_phone'];
															  else	
															   echo "Not mentioned";	
                                                        ?>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td><b>Email</b> :
														<?php 
                                                              if($formOne['EC_email']!='')
															  	echo $formOne['EC_email'];
															  else	
															   echo "Not mentioned";	
                                                        ?>
                                                  </td>
                                              </tr>
                                          </tbody>
                                      </table>
                                  </div>
								</div>
      </div>
<?php } ?>
                 
                 
				
   
</div>
                        
<div class="col-md-9 panel-profile">
<div class="">
							  
   
                        
          <div class="property-details-all tab-pane panel panel-success"  data-widget='{"draggable": "false"}'>                     
				<div class="panel-heading">
					<h2>PROPERTY DETAILS</h2>
				</div>
							
                               <?php if(!empty($formTwo)){?>             
                                <div class="about-area p-md">
								<div class="table-responsive panel panel-default" data-widget='{"draggable": "false"}'>
                                <div class="media-body panel-heading">
										<h2> Dwelling type </h2>
									</div>
                                    <div class="panel-body">
									<table class="table about-table">
										<tbody>
											<tr>
												<th>Dwelling type</th>
												<td><?php if($formTwo['d_type']!=''){echo $dwellingTypeList[$formTwo['d_type']];}else{echo "n/a";}?></td>
											</tr>
											<tr>
												<th>Main type of flooring</th>
												<td>
													<?php 
															if($formTwo['flooring']!='')
															{
																if($formTwo['flooring']!='5')
																	echo $floorTypeList[$formTwo['flooring']];
															}
															else
																echo 'n/a';	
															if($formTwo['flooring']=='5')	
																echo ucfirst($formTwo['flooring_other']);
													?>
                                                </td>
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
                            
                              <div class="about-area p-md" id="bedroomsDiv">
                                 <div class="table-responsive panel panel-default" data-widget='{"draggable": "false"}'>
                                <div class="media-body panel-heading">
										<h2>Bedrooms</h2>
									</div>
                                   <div class="panel-body"> 
                                            <div class="col-md-12 custom-accordion">
                                                <div class="panel-group panel-default" id="bedroomAccordion">
                                                    <?php foreach($formTwo['bedroomDetails'] as $bdK=>$bdV){?>
                                                                <div class="panel panel-default">
                                                                      <div class="media-body pb-md">
                                                                              <a data-toggle="collapse" data-parent="#bedroomAccordion" href="#collapseBedroomAccordion-<?=$bdK+1?>">
                                                                              <div class="panel-heading">
                                                                              <h5 class="media-heading">STUDENT BEDROOM <?=$bdK+1?> (<?=$roomTypeList[$bdV['type']]?>)</h5>
                                                                              <h5 class="pull-right media-heading">
                                                                                      <strong >Room Location:</strong>    	
                                                                                      <?php 
                                                                                      if($bdV['floor']=='0' || $bdV['floor'] == ''){echo $nm;}
                                                                                      elseif ($bdV['floor']=='g'){echo $gf;}
                                                                                      else{echo 'Floor '.$bdV['floor'];}
                                                                                      ?>
                                                                              </h5>
                                                                                                                                                                 	
                                                                              </div>
                                                                              </a>
                                                                      </div>
                                                                         
                                                                      <div id="collapseBedroomAccordion-<?=$bdK+1?>" class="collapse">
                                                                      <div class="panel-body">
                                                                          <table class="table about-table">
                                                                              <tbody>
                                                                                    <tr>
                                                                                        <th>Room type</th>
                                                                                        <td><?=$roomTypeList[$bdV['type']]?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                    	<th>Room Location</th>
                                                                                    	<td><?php 
                                                                                    	if($bdV['floor']=='0' || $bdV['floo'=='']){echo $nm;}
                                                                                    	elseif ($bdV['floor']=='g'){echo $gf;}
                                                                                    	else{echo 'Floor '.$bdV['floor'];}
                                                                                    	 
                                                                                    	?></td>
                                                                                    	
                                                                                    	
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th>Flooring type</th>
                                                                                        <td>
                                                                                          <?php
                                                                                              if($bdV['flooring']!="5")
                                                                                                  echo ucfirst($floorTypeList[$bdV['flooring']]);
                                                                                              else	
                                                                                                  echo ucfirst($bdV['flooring_other']);
                                                                                          ?>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th>Room access</th>
                                                                                        <td>
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
                                                                </div> 											
                                                     <?php }?>

<!-- host bedroom starts -->
<?php foreach($formTwo['hostbedroomDetails'] as $hbdK=>$hbdV){?>
                                                                <div class="panel panel-default">
                                                                      <div class="media-body pb-md">
                                                                              <a data-toggle="collapse" data-parent="#hbedroomAccordion" href="#collapseHBedroomAccordion-<?=$hbdK+1?>">
                                                                              <div class="panel-heading">
                                                                              <h5 class="media-heading">HOST BEDROOM <?=$hbdK+1?></h5>
                                                                              <h5 class="pull-right media-heading">
                                                                                  <strong>Room Location: </strong>
                                                                                  <?php 
                                                                                  if($hbdV['floor']=='0' || $hbdV['floor']==''){echo $nm;}
                                                                                  elseif ($hbdV['floor']=='g'){echo $gf;}
                                                                                  else{echo ' Floor '.$hbdV['floor'];}
                                                                                  ?>
                                                                              </h5>
                                                                              </div>
                                                                              </a>
                                                                      </div>
                                                                         
                                                                      <div id="collapseHBedroomAccordion-<?=$hbdK+1?>" class="collapse">
                                                                      <div class="panel-body">
                                                                          <table class="table about-table">
                                                                              <tbody>

                                                                                    <tr>
                                                                                    	<th>Room Location</th>
                                                                                    	<td><?php 
                                                                                    	if($hbdV['floor']=='0'|| $hbdV['floor']==''){echo $nm;}
                                                                                    	elseif ($hbdV['floor']=='g'){echo $gf;}
                                                                                    	else{echo 'Floor '.$hbdV['floor'];}
                                                                                    	 
                                                                                    	?></td>
                                                                                    	
                                                                                    	
                                                                                    </tr>
 
                                                                                 
                                                                                    <?php
                                                                                              if($bdV['avail']!="1" && strtotime($bdV['avail_from'])>strtotime(date('Y-m-d'))){?>
                                                                                    <tr>
                                                                                        <th>Student currently living in this room</th>
                                                                                        <td>
                                                                                         
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php } ?>
                                                                              </tbody>
                                                                          </table>
                                                                      
                                                                      </div>
                                                                      </div>
                                                                </div> 											
                                                     <?php }?>


                                                   <!-- Host bedroom ends -->  
                                                </div>
                                            </div>
                                  </div>
                               
                  	</div>
                    </div>
                            
                      	
                        <!--bathroom #START-->
                        <div class="about-area p-md" id="bathroomsDiv">
                                  <div class="table-responsive panel panel-default" data-widget='{"draggable": "false"}'>
                                <div class="media-body panel-heading">
                                            <h2>Bathrooms</h2>
                                        </div>
                                        
                                         <div class="panel-body"> 
                                        <div class="col-md-12 custom-accordion">
                                                <div class="panel-group panel-default" id="bathroomAccordion">
                                                		<?php foreach($formTwo['bathroomDetails'] as $btK=>$btV){?>
                                                        		
                                                                <div class="panel panel-default">
                                                                      <div class="media-body pb-md">
                                                                              <a data-toggle="collapse" data-parent="#bathroomAccordion" href="#collapseBathroomAccordion-<?=$btK+1?>"><div class="panel-heading">
                                                                              <h5 class="media-heading">BATHROOM <?=$btK+1?></h5>
                                                                              <h5 class="pull-right media-heading">
                                                                              	<strong>Bathroom Location:</strong>
                                                                                    	<?php 
                                                                                    	if($btV['floor']=='0' || $btV['floor']==''){echo $nm;}
                                                                                    	elseif ($btV['floor']=='g'){echo $gf;}
                                                                                    	else{echo 'Floor '.$btV['floor'];}
                                                                                    	 
                                                                                    	?>
                                                                              </h5></div></a>
                                                                      </div>
                                                                      
                                                                      <div id="collapseBathroomAccordion-<?=$btK+1?>" class="collapse">
                                                                          <div class="panel-body">
                                                                                <table class="table about-table">
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
                                                                                    	<th>Bathroom Location</th>
                                                                                    	<td><?php 
                                                                                    	if($btV['floor']=='0' || $btV['floor']==''){echo $nm;}
                                                                                    	elseif ($btV['floor']=='g'){echo $gf;}
                                                                                    	else{echo 'Floor '.$btV['floor'];}
                                                                                    	 
                                                                                    	?></td>
                                                                                    	
                                                                                    	
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
                                                                 </div>     
                                                                
                                                        <?php }?>
                                                </div>
                                        </div>
                                    </div>
                  		</div>
                        </div>
                        
                        <!--bathroom #ENDS-->
                        
                  
                            
                           <div class="about-area p-md">
                                  <div class="table-responsive panel panel-default" data-widget='{"draggable": "false"}'>
                                <div class="media-body panel-heading">
										<h2>Laundry</h2>
									</div>
                                    
                                    <div class="panel-body">
									<table class="table about-table">
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
                      </div>
                      
                            
     
                 <div class="family-details-all tab-pane panel panel-success"  data-widget='{"draggable": "false"}'  id="familyDetailsDiv">
                           <div class="panel-heading">                                
                                      <h2>FAMILY DETAILS</h2>
                               </div>
                                      
                                   <?php if(!empty($formThree)){//see($formThree);?>
                                    <div class="about-area p-md">
                                  <div class="table-responsive panel panel-default" data-widget='{"draggable": "false"}'>
                                <div class="media-body panel-heading">
                                              <h2>Family Member Details</h2>
                                     </div>
                                          
                                         <div class="panel-body"> 
                                          <div class="col-md-12 custom-accordion">
                                                <!--<div class="panel-group panel-default" id="familyMemberAccordion">-->
													 <?php for($fm=0;$fm<$formThree['family_members'];$fm++){?><div class="panel-group panel-default familyMemberAccordion" id="familyMemberAccordion-<?=$formThree['memberDetails'][$fm]['id']?>">
	                                                     <div class="panel panel-default">
                                                         		<div class="media-body pb-md">
                                                                    <a data-toggle="collapse" data-parent="#familyMemberAccordion-<?=$formThree['memberDetails'][$fm]['id']?>" href="#collapseFamilyMemberAccordion-<?=$fm+1?>"><div class="panel-heading">
                                                                    	<h5 class="media-heading">
                                                                        	Member <?=$fm+1?>
																			<?php 
																			echo ' - '.ucwords($formThree['memberDetails'][$fm]['fname'].' '.$formThree['memberDetails'][$fm]['lname']).', Age '.age_from_dob($formThree['memberDetails'][$fm]['dob']);
																			
																			if($formThree['memberDetails'][$fm]['role']!='')
																			 {
																				 	echo ', ';
																					if($formThree['memberDetails'][$fm]['role']==17)
																					{
																						$othval=!empty($formThree['memberDetails'][$fm]['other_role']) ? ' - '.$formThree['memberDetails'][$fm]['other_role'] :'';
																						echo $family_role[$formThree['memberDetails'][$fm]['role']].$othval;
																					}
																					else
																						echo $family_role[$formThree['memberDetails'][$fm]['role']];
																			  } 
																			 
																			if($formThree['memberDetails'][$fm]['wwcc']=="0" || $formThree['memberDetails'][$fm]['wwcc']=="1")
													 						{
																					echo ', WWCC ';
																					if($formThree['memberDetails'][$fm]['wwcc']=="0")
																						echo "(No)";
																					elseif($formThree['memberDetails'][$fm]['wwcc']=="1")
																					{
																						echo "(Yes)";
																						if($formThree['memberDetails'][$fm]['wwcc_clearence']=="1" && trim($formThree['memberDetails'][$fm]['wwcc_clearence_no'])!='')
																							echo ' - '.$formThree['memberDetails'][$fm]['wwcc_clearence_no'];
																					}
																			}
																			?>
                                                                        </h5>
                                                                    </div></a>
                                                                </div>
                                                                
                                                                <div id="collapseFamilyMemberAccordion-<?=$fm+1?>" class="collapse">
                                                                      <div class="panel-body">
                                                                              <table class="table about-table">
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
                                                                                                  <?php //see($formThree['memberDetails'][$fm]);
                                                                                                      if($formThree['memberDetails'][$fm]['role']!=''){
																										  if($formThree['memberDetails'][$fm]['role']==17){
																											  $othval=!empty($formThree['memberDetails'][$fm]['other_role']) ? ' - '.$formThree['memberDetails'][$fm]['other_role'] :'';
                                                                                                   echo $family_role[$formThree['memberDetails'][$fm]['role']].$othval;
																										  }else{
																										  echo $family_role[$formThree['memberDetails'][$fm]['role']];
																										  }
																									  } else{
																									  	  echo 'n/a';
																									  }
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
                                                                
                                                         </div></div>
                                                     <?php } ?>
                                              <!--  </div>-->
                                          </div> 
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
                                              <?php if(trim($formThree['pet_desc']!="")){?>
                                              <tr>
                                                  <th>Pets description</th>
                                                  <td><?=nl2br($formThree['pet_desc'])?></td>
                                              </tr>
                                              <?php }} ?>
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
                                      <table class="table about-table ">
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
                                
                                <div class="about-area p-md">
                                  <div class="table-responsive panel panel-default" data-widget='{"draggable": "false"}'>
                                <div class="media-body panel-heading">
                                          <h2>General Details</h2>
                                      </div>
                                      
                                      <div class="panel-body">
                                      <table class="table about-table">
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

                              </div>
                           


 
           <div class="property-details-all tab-pane panel panel-success"  data-widget='{"draggable": "false"}'>                     
				<div class="panel-heading">
					<h2>STUDENT PREFERENCES</h2>
				</div>
                 
				 <?php if(!empty($formFour) || $formOne['ref']!=''){?>
                            <div class="about-area p-md">
                                  <div class="table-responsive">
                                              <table class="table about-table">
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
                                                      <?php } ?>
                                                     <tr>
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
                                          <?php }else{?> 
                           							<div class="about-area p-md"><p>Student preferences not provided yet.</p></div>
                           					<?php } ?>
                                      </div>
                            
                            
                            
                           
		</div>
</div>


<!--Call log Start-->
<div class="modal fade" id="model_hfaCallLog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h2 class="modal-title">Add New Call Log</h2>
                </div>
                
                <div class="modal-body">
                    <form id="hfaCallLog_form">
                    
                        <div class="pl-n m-n form-group col-xs-6">
                            <label class="control-label">Date of the call</label>
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
                                <input type="text" class="form-control"  name="hfaCallLog_date" id="hfaCallLog_date" required>
                            </div>
                        </div>
                                              
                        <div class="pr-n m-n form-group">
                            <label class="control-label">Time of the call</label>
                            <div class="input-group bootstrap-timepicker">
                                  <div class="input-group-addon"><i class="colorDarkgreen material-icons">query_builder</i></div>
                                  <input type="text" class="form-control" id="hfaCallLog_time"  name="hfaCallLog_time" value="" required>
                            </div>
                        </div>
                    
                    <div class="m-n form-group">
                          <label class="control-label">Person who made call</label>
                              <select class="form-control" id="hfaCallLog_emp" name="hfaCallLog_emp" required>
                              <option value="" >Select employee</option>
                                  <?php
                                  foreach($employeeList as $emp)
								  {
								  	?>
                                  <option value="<?=$emp['id']?>" ><?=$emp['fname'].' '.$emp['lname']?></option>
                                  <?php
								  }
								  ?>
                               </select>
                      </div>
                    
                    
                        <div class="m-n form-group">
                            <label class="control-label">The reason for the phone call</label>
                            <textarea class="form-control" name="hfaCallLog_reason"></textarea>
                        </div>
						<input type="hidden" name="hfaCallLog_hfaId" value="<?=$formOne['id']?>" />
                    </form>   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-raised" id="hfaCallLog_submit">Submit</button>
                    <img src="<?=loadingImagePath()?>" id="hfaCallLog_process" style="margin-right:16px;display:none;">
                </div>
            </div><!-- /.modal-content -->
        </div>
</div><!-- /.modal -->
<!--Call log end-->

<!--Add new visit Start-->
<div class="modal fade" id="model_hfaVisits" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h2 class="modal-title">Add new visit</h2>
                </div>
                
                <div class="modal-body">
                    <form id="hfaAddNewVisit_form">
                    
                        <div class="pl-n m-n form-group col-xs-6">
                            <label class="control-label">Date of the Visit</label>
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
                                <input type="text" class="form-control"  name="hfaAddNewVisit_date" id="hfaAddNewVisit_date" required>
                            </div>
                        </div>
                                              
                        <div class="pr-n m-n form-group">
                            <label class="control-label">Time of the visit</label>
                            <div class="input-group bootstrap-timepicker">
                                  <div class="input-group-addon"><i class="colorDarkgreen material-icons">query_builder</i></div>
                                  <input type="text" class="form-control" id="hfaAddNewVisit_time"  name="hfaAddNewVisit_time" value="" required>
                            </div>
                        </div>
                    
                    <div class="m-n form-group">
                          <label class="control-label">Name of the person who visited this family</label>
                              <select class="form-control" id="hfaVisit_emp" name="hfaAddNewVisit_emp" required>
                              <option value="" >Select employee</option>
                                  <?php
                                  foreach($employeeList as $emp)
								  {
								  	?>
                                  <option value="<?=$emp['id']?>" ><?=$emp['fname'].' '.$emp['lname']?></option>
                                  <?php
								  }
								  ?>
                               </select>
                      </div>
                    
						<input type="hidden" name="hfaAddNewVisit_hfaId" value="<?=$formOne['id']?>" />
                    </form>   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-raised" id="hfaAddNewVisit_submit">Submit</button>
                    <img src="<?=loadingImagePath()?>" id="hfaAddNewVisit_process" style="margin-right:16px;display:none;">
                </div>
            </div><!-- /.modal-content -->
        </div>
</div><!-- /.modal -->
<!--Add new visit end-->

<?php if(userAuthorisations('hfa_visitReport_editDate')){?>
<!--Edit visit Start-->
<div class="modal fade" id="model_hfaEditVisitReportDate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h2 class="modal-title">Edit visit report</h2>
                </div>
                
                <div class="modal-body">
                    <form id="hfaEditVisitReportDate_form">
                    </form>   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-raised" id="model_hfaEditVisitReportDate_submit">Submit</button>
                    <img src="<?=loadingImagePath()?>" id="model_hfaEditVisitReportDate_process" style="margin-right:16px;display:none;">
                </div>
            </div><!-- /.modal-content -->
        </div>
</div><!-- /.modal -->
<!--Edit visit end-->
<?php }?>

<!--Copy visit Start-->
<div class="modal fade" id="model_hfaCopyVisitReport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h2 class="modal-title">Copy visit report</h2>
                </div>
                
                <div class="modal-body">
                    <form id="hfaCopyVisitReport_form">
                    
                        <div class="pl-n m-n form-group col-xs-6">
                            <label class="control-label">Date of the Visit</label>
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
                                <input type="text" class="form-control"  name="hfaCopyVisitReport_date" id="hfaCopyVisitReport_date" required>
                            </div>
                        </div>
                                              
                        <div class="pr-n m-n form-group">
                            <label class="control-label">Time of the visit</label>
                            <div class="input-group bootstrap-timepicker">
                                  <div class="input-group-addon"><i class="colorDarkgreen material-icons">query_builder</i></div>
                                  <input type="text" class="form-control" id="hfaCopyVisitReport_time"  name="hfaCopyVisitReport_time" value="" required>
                            </div>
                        </div>
                    
                    <div class="m-n form-group">
                          <label class="control-label">Name of the person who visited this family</label>
                              <select class="form-control" id="hfaCopyVisitReport_emp" name="hfaCopyVisitReport_emp" required>
                              <option value="" >Select employee</option>
                                  <?php
                                  foreach($employeeList as $emp)
								  {
								  	?>
                                  <option value="<?=$emp['id']?>" ><?=$emp['fname'].' '.$emp['lname']?></option>
                                  <?php
								  }
								  ?>
                               </select>
                      </div>
                        <input type="hidden" name="hfaCopyVisitReport_hfaId" value="<?=$formOne['id']?>" />
                    	<input type="hidden" name="hfaCopyVisitReport_reportId" id="hfaCopyVisitReport_reportId" value="" />
                    </form>   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-raised" id="hfaCopyVisitReport_submit">Submit</button>
                    <img src="<?=loadingImagePath()?>" id="hfaCopyVisitReport_process" style="margin-right:16px;display:none;">
                </div>
            </div><!-- /.modal-content -->
        </div>
</div><!-- /.modal -->
<!--Copy visit end-->

<script type="text/javascript">

$(document).ready(function(){

	Dropzone.options.hfDocumentsUpload= {
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


	
		$('#hfaCallLog_time, #hfaAddNewVisit_time, #hfaCopyVisitReport_time').timepicker({
			minuteStep: 15/*,
			defaultTime:false*/
		});
		
		$('#hfaCallLog_date, #hfaAddNewVisit_date, #hfaCopyVisitReport_date').datepicker({
			orientation: "bottom",
			todayHighlight: true,
	    	/*startDate: "-0d",*/
			format:'dd/mm/yyyy',
			autoclose:true
		});
		
		
	});
</script>