<?php
$genderList=genderList();
$smokingHabbits=smokingHabbitsFilters();
$religionList=religionList();
$accomodationTypeList=accomodationTypeList();
$roomTypeList=roomTypeList();
$stateList=stateList();
$languageList=languageList();
$clientList=clientsList();
?>

<ul class="nav nav-tabs material-nav-tabs stretch-tabs icon-tabs">
            <li class="active"><a href="#filterMatches-primaryTab" data-toggle="tab">
                Primary
            </a></li>
            <li><a href="#filterMatches-secondaryTab" data-toggle="tab"><span class="step size-64">
                  Secondary
                </span></a>
            </li>
        </ul>
<form id="filterMatchesForm2">
<input type="hidden" name="id" id="student_id" value="<?=$formOne['id']?>" />
<div class="tab-content">

        <div class="tab-pane active" id="filterMatches-primaryTab">

            <table class="table">
                <tbdody>
                <?php ///$input['filterMatchesEditSuburb']='';$input['suburb']=1;?>
                
                <tr>
                        <td>
                            <h5 class="filterMatchesLabel">Host name</h5>
                            <p class="filterMatchesLabelValue grey" style="text-transform: capitalize;">
								<?php 
								if($input['filterMatchesEditFname']!='' || $input['filterMatchesEditLname']!=''){
								if($input['filterMatchesEditFname']!=''){?>
                                    <?php echo $input['filterMatchesEditFname'];}
								if($input['filterMatchesEditLname']!=''){?>
                                    <?php echo $input['filterMatchesEditLname'];}?>                                    
                                    <i class="fa fa-edit  filterMatchesEditBtn filterMatchesEditBtn-hostName"></i>
                                 <?php }else{ echo "Not entered";} ?>   
                            </p>
                            <p>Filter host families according to host name.</p>
                            <!--<p>No desc req for now</p>-->
                           
                                <div class="form-group filterMatchesEdit-hostName" style="display:none">
									<label class="control-label">Enter host name</label>
									<div class="">
                                        <div class="form-group" style="width: 45%;float: left;">
                                            <input class="form-control" id="filterMatchesEditFname2" name="filterMatchesEditFname" placeholder="First Name" value="<?=$input['filterMatchesEditFname']?>" type="text">
                                        </div>
                                        <!--</div>
                                        <div class="">-->
                                        <div class="form-group" style="width: 45%;float: left;margin-left:20px;">
                                            <input class="form-control" id="filterMatchesEditLname2" name="filterMatchesEditLname" placeholder="Last Name" value="<?=$input['filterMatchesEditLname']?>" type="text">
                                        </div>
                                    </div>
                                    
                                    <div class="widget-body mt-n form-group" style="clear:both; padding-left:0; margin-left:-10px; border:0;">
                                        <div class="radio block">
                                          <label style="font-size:12px;">
                                              <input type="radio" name="hostNameSearchAll" value="all" <?php if($input['hostNameSearchAll']=='all'){?>checked<?php } ?>>
                                              <span class="circle"></span>
                                              <span class="check"></span>
                                              Search from all families
                                          </label>
                                     </div>
                                     <div class="radio block">
                                           <label style="font-size:12px;">
                                              <input type="radio" name="hostNameSearchAll" value="matching" <?php if($input['hostNameSearchAll']=='matching'){?>checked<?php } ?>>
                                              <span class="circle"></span>
                                              <span class="check"></span>
                                              Search from matching families
                                          </label>
                                     </div>
                                 </div> 
								</div>
                                
                        </td>
                		<td><span class="togglebutton toggle-success"><label><input type="checkbox" <?php if($input['hostName']==1 && ($input['filterMatchesEditFname']!='' || $input['filterMatchesEditLname']!='')){?>checked=""<?php }?> name="hostName" value="1" id="hostName2"> </label></span></td>
                    </tr>
                 
                
                <tr>
                        <td>
                            <h5 class="filterMatchesLabel">Accomodation type</h5>
                            <p class="filterMatchesLabelValue grey">
								
                                    <?php
                                    if($input['filterMatchesEditAccomodation_type']!='')
										echo $accomodationTypeList[$input['filterMatchesEditAccomodation_type']];
									else
										echo 'Not available';
										
									$filterMatchesEditAccomodation_typeRoomType=explode(',',$input['filterMatchesEditAccomodation_typeRoomType']);
									$filterMatchesEditAccomodation_typeGrannyFlat=$input['filterMatchesEditAccomodation_typeGrannyFlat'];
									?>
                                    <i class="fa fa-edit  filterMatchesEditBtn filterMatchesEditBtn-accomodation_type"></i>
                                  
                            </p>
                            
							<p id="accomodation_typeRoomTypeDesc" <?php if($input['filterMatchesEditAccomodation_type']==''){echo 'style="display:none;"';}?>>
                                
                                <span id="accomodation_typeRoomTypeDescSpan"><?=roomTypeByAccomodationTypeDesc($filterMatchesEditAccomodation_typeRoomType,$input['filterMatchesEditAccomodation_type'])?></span>
                                <i class="fa fa-edit  filterMatchesEditBtn filterMatchesEditBtn-accomodation_typeRoomType"></i>
                            </p>
                            
                            
                            <div class="form-group filterMatchesEdit-accomodation_typeRoomType" style="display:none;">
                            		
									<?php foreach($roomTypeList as $roomTK=>$roomTV){?>
                                          <div class="checkbox">
                                                <div class="checkbox block"><label><input type="checkbox" name="filterMatchesEditAccomodation_typeRoomType2[]"  value="<?=$roomTK?>" <?php if(in_array($roomTK,$filterMatchesEditAccomodation_typeRoomType)){?>checked="checked"<?php } ?> onclick="changeDescByRoomTypeFilterMatches();"> <?=$roomTV?></label></div>
                                            </div>
                                    <?php }?>
                                    <span>Show Granny flats</span>
                                      <div class="radio block">
                                        <label>
                                          <input type="radio" name="filterMatchesEditAccomodation_typeGrannyFlat2" value="1" <?php if($filterMatchesEditAccomodation_typeGrannyFlat=='1'){?>checked<?php } ?>>
                                            <span class="circle"></span>
                                            <span class="check"></span>
                                          Yes
                                        </label>
                                        <label>
                                          <input type="radio" name="filterMatchesEditAccomodation_typeGrannyFlat2" value="0" <?php if($filterMatchesEditAccomodation_typeGrannyFlat=='0'){?>checked<?php } ?>>
                                            <span class="circle"></span>
                                            <span class="check"></span>
                                          No
                                        </label>
                                      </div>
                                </div>
                                <div class="form-group filterMatchesEdit-accomodation_type" style="display:none">
									<label for="filterMatchesEditAccomodation_type2" class="control-label">Which accomodation type do you prefer?</label>
									<div class="">
                                      <select name="filterMatchesEditAccomodation_type" id="filterMatchesEditAccomodation_type2" class="form-control" onchange="selectRoomTypeByAccomodationType(this.value);">
                                          <option value="">Select One</option>
                                         <?php foreach($accomodationTypeList as $aTLK=>$aTLV) {?>
	                                          <option value="<?=$aTLK?>" <?php if($aTLK==$input['filterMatchesEditAccomodation_type']){?>selected="selected"<?php }?>><?=$aTLV?></option>
                                          <?php } ?>
                                      </select>
                                    </div>
                                    
								</div>
                                
                        </td>
                        <td><span class="togglebutton toggle-success"><label><input type="checkbox" <?php if($input['accomodation_type']==1 && $input['filterMatchesEditAccomodation_type']!=''){?>checked=""<?php }?> name="accomodation_type" value="1" id="accomodation_type2"> </label></span></td>
                    </tr>
                
                    <tr>
                        <td>
                            <h5 class="filterMatchesLabel">Arrival date</h5>
                            <p class="filterMatchesLabelValue grey">
							  <?php
							      if($input['filterMatchesEditArrivalDate']!='')
								  {
                                      echo date('d M Y',strtotime(normalToMysqlDate($input['filterMatchesEditArrivalDate'])));
									  echo '<i class="fa fa-edit filterMatchesEditBtn filterMatchesEditBtn-arrivalDate"></i>';	  
								  }
									else
										echo "Not available";  
                              ?>
                            </p>
                            <p>Filter host families according to their room availability based on student's arrival date.</p>
                            <div class="col-xs-12 filterMatchesEdit-arrivalDate" style="display:none" >
								<?php 
								  $arrivalDateVal='';
                                  if($input['filterMatchesEditArrivalDate']!='')
                                      $arrivalDateVal=$input['filterMatchesEditArrivalDate'];
                                ?>
									<div class="form-group">
									<label for="filterMatchesEditArrivalDate2" class="control-label">Change arrival date</label>
									<div class="">
										<input class="form-control" id="filterMatchesEditArrivalDate2" name="filterMatchesEditArrivalDate" placeholder="Arrival date" value="<?=$arrivalDateVal?>" type="text">
                                        <!--<button class="btn btn-success btn-raised btn-xs" id="filterMatchesEditArrivalDateSave">Save</button>-->
									</div>
                                </div>
                                
								</div>
                       </td>
                        <td><span class="togglebutton toggle-success"><label><input type="checkbox" <?php if($input['arrival_date']==1 && $input['filterMatchesEditArrivalDate']!=''){?>checked=""<?php }?> name="arrival_date" value="1" id="arrival_date2"> </label></span></td>
                    </tr>
                    
                    <tr>
                        <td>
                            <h5 class="filterMatchesLabel">Pets</h5>
                            <p class="filterMatchesLabelValue grey">
								<?php if($input['filterMatchesEditPets']!=''){?>
                                    Can<?php if($input['filterMatchesEditPets']=="0"){echo "not";}?> live with pets
                                    <i class="fa fa-edit  filterMatchesEditBtn filterMatchesEditBtn-pets"></i>
                                 <?php }else{ echo "Not available";} ?>   
                            </p>
                            <p>Filter host families according to student's pet preference.</p>
                            <!--<p>No desc req for now</p>-->
                           
                                <div class=" filterMatchesEdit-pets" style="display:none">
									<!--<label for="filterMatchesEditPets2" class="control-label">Can student live with pets?</label>-->
									<div class="form-group"><label for="filterMatchesEditPets2" class="control-label">Can student live with pets?</label>
                                      <select name="filterMatchesEditPets" id="filterMatchesEditPets2" class="form-control">
                                          <option value="">Select One</option>
                                          <option value="1" <?php if($input['filterMatchesEditPets']=="1"){?>selected="selected"<?php } ?>>Yes</option>
                                          <option value="0" <?php if($input['filterMatchesEditPets']=="0"){?>selected="selected"<?php } ?>>No</option>
                                      </select>
                                    </div>
                                    
                                   
                                    <?php
                                    if(!empty($input['filterMatchesEditPetsType']))
										$filterMatchesEditPetsType=explode(',',$input['filterMatchesEditPetsType']);
									?>
									<div class="form-group">
	                                     <label class="control-label">Type of pets student can live with</label>
											<div class="checkbox">
                                                <div class="checkbox block"><label><input type="checkbox" name="filterMatchesEditPetsType[]" class="Checkbox Checkbox_stateFilter1"  value="dog" <?php if(!empty($filterMatchesEditPetsType) && in_array('dog',$filterMatchesEditPetsType)){?>checked="checked"<?php } ?>/>  Dog</label></div>
                                                <div class="checkbox block"><label><input type="checkbox" name="filterMatchesEditPetsType[]" class="Checkbox Checkbox_stateFilter1"  value="bird" <?php if(!empty($filterMatchesEditPetsType) && in_array('bird',$filterMatchesEditPetsType)){?>checked="checked"<?php } ?>/>  Bird</label></div>
                                                <div class="checkbox block"><label><input type="checkbox" name="filterMatchesEditPetsType[]" class="Checkbox Checkbox_stateFilter1"  value="cat" <?php if(!empty($filterMatchesEditPetsType) && in_array('cat',$filterMatchesEditPetsType)){?>checked="checked"<?php } ?>/>  Cat</label></div>
                                            </div>
                                	</div>
                                    
                                    
									<div class="form-group">
	                                    <label for="filterMatchesEditPetsInside2" class="control-label">Can student live with pets inside the house?</label>
										<select name="filterMatchesEditPetsInside" id="filterMatchesEditPetsInside2" class="form-control">
                                          <option value="">Select One</option>
                                          <option value="1" <?php if($input['filterMatchesEditPetsInside']=="1"){?>selected="selected"<?php } ?>>Yes</option>
                                          <option value="0" <?php if($input['filterMatchesEditPetsInside']=="0"){?>selected="selected"<?php } ?>>No</option>
                                      </select>
                                	</div>
                                    
								</div>
                                
                        </td>
                        <td><span class="togglebutton toggle-success"><label><input type="checkbox" <?php if($input['pets']==1 && $input['filterMatchesEditPets']!=''){?>checked=""<?php }?> name="pets" value="1" id="pets2"> </label></span></td>
                    </tr>
                    
                    <tr>
                        <td>
                            <h5 class="filterMatchesLabel">Staying with children</h5>
                            <p class="filterMatchesLabelValue grey">
                            <?php
								$child11EditLink='<i class="fa fa-edit  filterMatchesEditBtn filterMatchesEditBtn-child"></i>';
								if($input['filterMatchesEditChild11']=='')
									$child11='Not available';
								elseif($input['filterMatchesEditChild11']=='0')
									$child11='No'.$child11EditLink;
								elseif($input['filterMatchesEditChild11']=='1')
									$child11='Yes'.$child11EditLink;		
																									
	                            $child22EditLink=' <i class="fa fa-edit  filterMatchesEditBtn filterMatchesEditBtn-child"></i>';
								if($input['filterMatchesEditChild20']=='')
									$child20='Not available';
								elseif($input['filterMatchesEditChild20']=='0')
									$child20='No'.$child22EditLink;
								elseif($input['filterMatchesEditChild20']=='1')
									$child20='Yes'.$child22EditLink;
							?>
								0 -10 yrs: <?=$child11?>	
                                <br />
								11 -17 yrs: <?=$child20?>
                            </p>
                            <p>Filter host families according to the student's choice of staying with children.</p>
                            
                                <div class="form-group filterMatchesEdit-child" style="display:none">
                                <h5 class="filterMatchesLabel">Can student live with children?</h5>
									<!--<label for="filterMatchesEditChild112" class="control-label">Can student live with children?</label>-->
									<div class="">
                                    <label  class="control-label">0 - 10 years</label>
                                      <select name="filterMatchesEditChild11" id="filterMatchesEditChild112" class="form-control">
                                          <option value="">Select One</option>
                                          <option value="1" <?php if($input['filterMatchesEditChild11']=="1"){?>selected="selected"<?php } ?>>Yes</option>
                                          <option value="0" <?php if($input['filterMatchesEditChild11']=="0"){?>selected="selected"<?php } ?>>No</option>
                                      </select>
                                      <label  class="control-label">11 - 17 years</label>
                                     <select name="filterMatchesEditChild20" id="filterMatchesEditChild202" class="form-control">
                                          <option value="">Select One</option>
                                          <option value="1" <?php if($input['filterMatchesEditChild20']=="1"){?>selected="selected"<?php } ?>>Yes</option>
                                          <option value="0" <?php if($input['filterMatchesEditChild20']=="0"){?>selected="selected"<?php } ?>>No</option>
                                      </select> 
                                    </div>
                                    
								</div>
                                
                        </td>
                        <td><span class="togglebutton toggle-success"><label><input type="checkbox" <?php if($input['child']==1 && ($input['filterMatchesEditChild11']!='' ||$input['filterMatchesEditChild20']!='') ){?>checked=""<?php }?> name="child" value="1" id="child2"> </label></span></td>
                    </tr>
                    
                    <tr>
                        <td>
                            <h5 class="filterMatchesLabel">Age</h5>
                            <p class="filterMatchesLabelValue grey">
								<?php
                                $ageStudent=age_from_dob($formOne['dob']);
								if($ageStudent>18)
									$ageStatus="Above 18";
								else	
									$ageStatus="Below 18";
								echo $ageStatus;
								?>
                                
                            </p>
                            <p>Filter host families based on whether student is above or below <?=strtolower($ageStatus)?>. </p>
                        </td>
                        <td><span class="togglebutton toggle-success"><label><input type="checkbox" <?php if($input['age']==1){?>checked=""<?php }?> name="age" value="1" id="age2"> </label></span></td>
                    </tr>
                    
                    <?php if($ageStudent<18){?>
                    <tr>
                        <td>
                            <h5 class="filterMatchesLabel">WWCC</h5>
                            <p class="filterMatchesLabelValue grey">
                            <?php 
							$wwccEditBtn='<i class="fa fa-edit  filterMatchesEditBtn filterMatchesEditBtn-wwcc"></i>';
							if($input['filterMatchesEditWWCC_expired']=="0" && $input['filterMatchesEditWWCC_clearence']=="0" && $input['filterMatchesEditWWCC_oneMember']=="0"){echo 'Click to select options '.$wwccEditBtn;} 
							if($input['filterMatchesEditWWCC_expired']=="1"){?><p style="margin:0;">Wwcc that is expired<?php echo $wwccEditBtn.'</p>';} 
                            if($input['filterMatchesEditWWCC_clearence']=="1"){?><p style="margin:0;">Not received clearance yet<?php echo $wwccEditBtn.'</p>'; }
                            if($input['filterMatchesEditWWCC_oneMember']=="1"){?><p style="margin:0;">At least one member having wwcc<?php echo $wwccEditBtn.'</p>'; } ?>
                            </p>
                            <p>Show only those host families in which all family members has WWCC</p>
                            
                            <div class="form-group filterMatchesEdit-wwcc" style="display:none">
									<label for="filterMatchesEditPets2" class="control-label">Show families that have:</label>
									<div class="">

                                      <div class="checkbox">
                                          <div class="checkbox block">
                                              <label><input type="checkbox" name="filterMatchesEditWWCC_expired" id="filterMatchesEditWWCC_expired2"  value="1" <?php if($input['filterMatchesEditWWCC_expired']=="1"){?>checked="checked"<?php } ?>> 
                                                  wwcc that is expired
                                              </label>
                                          </div>
                                      </div>
                                      
                                      <div class="checkbox">
                                          <div class="checkbox block">
                                              <label><input type="checkbox" name="filterMatchesEditWWCC_clearence" id="filterMatchesEditWWCC_clearence2"  value="1" <?php if($input['filterMatchesEditWWCC_clearence']=="1"){?>checked="checked"<?php } ?>> 
                                                  not received clearance yet
                                              </label>
                                          </div>
                                      </div>
                                      
                                      <div class="checkbox">
                                          <div class="checkbox block">
                                              <label><input type="checkbox" name="filterMatchesEditWWCC_oneMember" id="filterMatchesEditWWCC_oneMember2"  value="1" <?php if($input['filterMatchesEditWWCC_oneMember']=="1"){?>checked="checked"<?php } ?>> 
                                                  at least one member having wwcc
                                              </label>
                                          </div>
                                      </div>
                                    
								</div>
                            
                        </td>
                        <td><span class="togglebutton toggle-success"><label><input type="checkbox" <?php if($input['wwcc']==1){?>checked=""<?php }?> name="wwcc" value="1" id="wwcc2"> </label></span></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td>
                            <h5 class="filterMatchesLabel">State</h5>
							<p class="grey" id="fillterstates" <?php //if(!empty($input['filterMatchesEditState'])){echo 'style="display:none;"';}?>>
                                
                                <span id="filterMatchesEditstate"<?php if($input['filterMatchesEditState']==''){?>style="display:none;"<?php } ?>><?=@$input['filterMatchesEditState']?></span>
                                <span id="filterMatchesEditstateClick" <?php if($input['filterMatchesEditState']!=''){?>style="display:none;"<?php } ?>>Click to select state</span>
                                <i class="fa fa-edit  filterMatchesEditBtn filterMatchesEditBtn-state"></i>
								  <?php
                                   
										if(!empty($input['filterMatchesEditState']))
									$filterMatchesEditstate=explode(',',$input['filterMatchesEditState']);
									
									?>
                            </p>
                           <!--<span id="filterMatchesEditstate"><?=@$input['filterMatchesEditState']?></span>-->
                            <p>Filter host families according to entered state.</p>
                            
                            <div class="form-group filterMatchesEdit-state" style="display:none">
									<label class="control-label">Select state</label>
									<div class="">
<?php  foreach($stateList as $val){  ?>
<div class="checkbox">
                                                <div class="checkbox block"><label><input type="checkbox" name="filterMatchesEditState[]" class="Checkbox Checkbox_stateFilter"  value="<?=$val?>" <?php if(!empty($filterMatchesEditstate) && in_array($val,$filterMatchesEditstate)){?>checked="checked"<?php } ?>/>  <?=$val?></label></div>
                                            </div>
                                     
                                      
<?php  }?>
                                      
                                      
                                    
								</div>
                            
                        </td>
						<td><span class="togglebutton toggle-success"><label><input type="checkbox" <?php if($input['state']==1){?>checked=""<?php }?> name="state" value="1" id="state2"> </label></span></td>
                        
                    </tr>
                    
                    <tr>
                        <td>
                            <h5 class="filterMatchesLabel">Suburb</h5>
                            <p class="filterMatchesLabelValue grey">
								<?php if($input['filterMatchesEditSuburb']!=''){
									 echo $input['filterMatchesEditSuburb'];?>
                                    <i class="fa fa-edit  filterMatchesEditBtn filterMatchesEditBtn-suburb"></i>
                                 <?php }else{ echo "Not entered";} ?>   
                            </p>
                            <p>Filter host families according to entered suburb.</p>
                            <!--<p>No desc req for now</p>-->
                           
                                <div class="form-group filterMatchesEdit-suburb" style="display:none">
									<label for="filterMatchesEditSuburb2" class="control-label">Enter suburb name</label>
									<div class="">
                                    <input type="hidden" id="filterMatchesEditSuburbId2" value="<?=$input['filterMatchesEditSuburbId']?>"/>
                                    <input type="hidden" name="filterMatchesEditSuburb" id="filterMatchesEditSuburb2" class="form-control"  value="<?=$input['filterMatchesEditSuburb']?>"/>
                                    <input type="text" id="filterMatchesEditSuburb2Temp" class="form-control"  value="<?=$input['filterMatchesEditSuburb']?>"/>
                                    <div id="filterMatchesEditSuburb2_suggestions">
									</div>
                                    </div>
                                    
								</div>
                                
                        </td>
                        <td><span class="togglebutton toggle-success"><label><input type="checkbox" <?php if($input['suburb']==1 && $input['filterMatchesEditSuburb']!=''){?>checked=""<?php }?> name="suburb" value="1" id="suburb2"> </label></span></td>
                    </tr>
                    
                    <tr>
                        <td style="padding-bottom:0;">
                         			<?php
                                        if(!empty($input['filterMatchesEditCApproval']))
                                            $filterMatchesEditCApproval=explode(',',$input['filterMatchesEditCApproval']);
                                    ?>
                            <h5 class="filterMatchesLabel">Filter families that are approved by college:</h5>
                            <p class="grey" id="filltercApproval">
                                <span id="filterMatchesEditcApproval"<?php if($input['filterMatchesEditCApproval']==''){?>style="display:none;"<?php } ?>>No. of colleges selected: <?php if(isset($filterMatchesEditCApproval)){echo count($filterMatchesEditCApproval);}?></span>
                                <span id="filterMatchesEditcApprovalClick" <?php if($input['filterMatchesEditCApproval']!=''){?>style="display:none;"<?php } ?>>Click to select college</span>
                                <i class="fa fa-edit  filterMatchesEditBtn filterMatchesEditBtn-cApproval"></i>
                            </p>
                            
                        </td>
                        <td style="padding-bottom:0;"><span class="togglebutton toggle-success"><label><input type="checkbox" <?php if($input['cApproval']==1 && !empty($filterMatchesEditCApproval)){?>checked=""<?php }?> name="cApproval" value="1" id="cApproval2"> </label></span></td>
                    </tr>
                    
                    <tr>
                        <td colspan="2" style="border-top:none;padding-top:0;">
                         	<p>Filter host families according to selected college.</p>
                            
                            <div class="form-group filterMatchesEdit-cApproval" style="display:none">
                                    <label class="control-label">Select college</label>
                                    <div class="" style="height:300px;width:278px;overflow-x:hidden;">
                                        <?php  foreach($clientList as $clg){
                                                if($clg['category']=='1' || $clg['category']=='2')
                                                  continue;  ?>
                                        <div class="checkbox">
                                          <div class="checkbox block"><label><input type="checkbox" name="filterMatchesEditCApproval[]" class="Checkbox"  value="<?=$clg['id']?>" <?php if(!empty($filterMatchesEditCApproval) && in_array($clg['id'],$filterMatchesEditCApproval)){?>checked="checked"<?php } ?>/>  <?=$clg['bname']?></label></div>
                                        </div>
                                        <?php  }?>
                                    </div>
                            </div>
                        </td>
                        
                    </tr>
                    
                    <tr style="height: 200px;"><td></td><td></td></tr>
                    
                </tbdody>
            </table>
        </div>

        <div class="tab-pane" id="filterMatches-secondaryTab">
            <table class="table">
                <tbdody>
                    
                    <tr>
                    	<?php 
								$smokerEditLink='<i class="fa fa-edit  filterMatchesEditBtn filterMatchesEditBtn-smoker"></i>';
								  $smoker="Not available";
								  if($input['filterMatchesEditSmoker']=='0' || $input['filterMatchesEditSmoker']=='1' || $input['filterMatchesEditSmoker']=='2')
										  $smoker=$smokingHabbits[$input['filterMatchesEditSmoker']].$smokerEditLink;
							?>
                        <td>
                            <h5 class="filterMatchesLabel">Student smoking habits</h5>
                             <p class="filterMatchesLabelValue grey">
								<?=$smoker?>
                            </p>
                             <p>Filter host families according to student's smoking habits.</p>
                            
                            <div class="form-group filterMatchesEdit-smoker" style="display:none">
									<label for="filterMatchesEditSmoker2" class="control-label">Does student smoke?</label>
									<div class="">
                                      <select name="filterMatchesEditSmoker" id="filterMatchesEditSmoker2" class="form-control">
                                          <option value="">Select One</option>
                                          <?php foreach($smokingHabbits as $sHK=>$sHV){?>
                                          <option value="<?=$sHK?>" <?php if((string)$input['filterMatchesEditSmoker']== (string)$sHK){?>selected="selected"<?php } ?>><?=$sHV?></option>
                                          <?php } ?>
                                      </select>
                                    </div>
                                   
								</div>
                            
                        </td>
                        <td><span class="togglebutton toggle-success"><label><input type="checkbox" <?php if($input['smoker']==1 && $input['filterMatchesEditSmoker']!=''){?>checked=""<?php }?> name="smoker" value="1" id="smoker2"> </label></span></td>
                    </tr>
                    
                    <tr>
                    	<?php 
								$smokerEditLinkFamily='<i class="fa fa-edit  filterMatchesEditBtn filterMatchesEditBtn-smokerFamily"></i>';
								  $smokerFamily="Not available";
								  if($input['filterMatchesEditSmokerFamily']=='0' || $input['filterMatchesEditSmokerFamily']=='1' || $input['filterMatchesEditSmokerFamily']=='2')
										  $smokerFamily=$smokingHabbits[$input['filterMatchesEditSmokerFamily']].$smokerEditLinkFamily;
							?>
                        <td>
                            <h5 class="filterMatchesLabel">Student smoking preferences</h5>
                             <p class="filterMatchesLabelValue grey">
								<?=$smokerFamily?>
                            </p>
                             <p>Filter host families according to student's smoking preferences for families.</p>
                            
                            <div class="form-group filterMatchesEdit-smokerFamily" style="display:none">
									<label for="filterMatchesEditSmokerFamily2" class="control-label">student's smoking preferences for families</label>
									<div class="">
                                      <select name="filterMatchesEditSmokerFamily" id="filterMatchesEditSmokerFamily2" class="form-control">
                                          <option value="">Select One</option>
                                          <?php foreach($smokingHabbits as $sHK=>$sHV){?>
                                          <option value="<?=$sHK?>" <?php if((string)$input['filterMatchesEditSmokerFamily']== (string)$sHK){?>selected="selected"<?php } ?>><?=$sHV?></option>
                                          <?php } ?>
                                      </select>
                                    </div>
                                   
								</div>
                            
                        </td>
                        <td><span class="togglebutton toggle-success"><label><input type="checkbox" <?php if($input['smokerFamily']==1 && $input['filterMatchesEditSmokerFamily']!=''){?>checked=""<?php }?> name="smokerFamily" value="1" id="smokerFamily2"> </label></span></td>
                    </tr>
                    
                    
                    <tr>
                        <td>
                            <h5 class="filterMatchesLabel">Dietary requirements</h5>
                            <p class="filterMatchesLabelValue grey">
								<?php if($input['filterMatchesEditDietReq']!=''){
									if($input['filterMatchesEditDietReq']==1)
										echo 'Yes';
									else
										echo 'No';	
									?>
                                    <i class="fa fa-edit  filterMatchesEditBtn filterMatchesEditBtn-dietReq"></i>
                                 <?php }else{ echo "Not available";} ?>   
                            </p>
                            <p>Filter host families according to student's dietary requirements.</p>
                            <!--<p>No desc req for now</p>-->
                           
                                <div class="form-group filterMatchesEdit-dietReq" style="display:none">
									<label for="filterMatchesEditDietReq2" class="control-label">Will you have any special dietary requirements?</label>
									<div class="">
                                      <select name="filterMatchesEditDietReq" id="filterMatchesEditDietReq2" class="form-control">
                                          <option value="">Select One</option>
                                          <option value="1" <?php if($input['filterMatchesEditDietReq']=="1"){?>selected="selected"<?php } ?>>Yes</option>
                                          <option value="0" <?php if($input['filterMatchesEditDietReq']=="0"){?>selected="selected"<?php } ?>>No</option>
                                      </select>
                                    </div>
                                    
								</div>
                                
                        </td>
                        <td><span class="togglebutton toggle-success"><label><input type="checkbox" <?php if($input['dietReq']==1 && $input['filterMatchesEditDietReq']!=''){?>checked=""<?php }?> name="dietReq" value="1" id="dietReq2"> </label></span></td>
                    </tr>
                   
                   
                   <tr>
                        <td>
                            <h5 class="filterMatchesLabel">Student allergies</h5>

                            <p class="filterMatchesLabelValue grey">
								<?php if($input['filterMatchesEditAllergy']!=''){
									if($input['filterMatchesEditAllergy']==1)
										echo 'Yes';
									else
										echo 'No';	
									?>
                                    <i class="fa fa-edit  filterMatchesEditBtn filterMatchesEditBtn-allergy"></i>
                                 <?php }else{ echo "Not available";} ?>   
                            </p>
                            <p>Filter host families according to student's allergy details.</p>
                            <!--<p>No desc req for now</p>-->
                           
                                <div class="form-group filterMatchesEdit-allergy" style="display:none">
									<label for="filterMatchesEditAllergy2" class="control-label">Do you have any allergies?</label>
									<div class="">
                                      <select name="filterMatchesEditAllergy" id="filterMatchesEditAllergy2" class="form-control">
                                          <option value="">Select One</option>
                                          <option value="1" <?php if($input['filterMatchesEditAllergy']=="1"){?>selected="selected"<?php } ?>>Yes</option>
                                          <option value="0" <?php if($input['filterMatchesEditAllergy']=="0"){?>selected="selected"<?php } ?>>No</option>
                                      </select>
                                    </div>
                                    
								</div>
                                
                        </td>
                        <td><span class="togglebutton toggle-success"><label><input type="checkbox" <?php if($input['allergy']==1 && $input['filterMatchesEditAllergy']!=''){?>checked=""<?php }?> name="allergy" value="1" id="allergy2"> </label></span></td>
                    </tr>
                    
                    <tr>
                        <td>
                            <h5 class="filterMatchesLabel">Disability</h5>
                            <p class="filterMatchesLabelValue grey">
								<?php if($input['filterMatchesEditDisability']!=''){
									if($input['filterMatchesEditDisability']==1)
										echo 'Yes';
									else
										echo 'No';	
									?>
                                    <i class="fa fa-edit  filterMatchesEditBtn filterMatchesEditBtn-disability"></i>
                                 <?php }else{ echo "Not available";} ?>   
                            </p>
                            <p>Filter host families according to their preference for student's disability.</p>
                            <!--<p>No desc req for now</p>-->
                           
                                <div class="form-group filterMatchesEdit-disability" style="display:none">
									<label for="filterMatchesEditDisability2" class="control-label">Do you have any disabilities?</label>
									<div class="">
                                      <select name="filterMatchesEditDisability" id="filterMatchesEditDisability2" class="form-control">
                                          <option value="">Select One</option>
                                          <option value="1" <?php if($input['filterMatchesEditDisability']=="1"){?>selected="selected"<?php } ?>>Yes</option>
                                          <option value="0" <?php if($input['filterMatchesEditDisability']=="0"){?>selected="selected"<?php } ?>>No</option>
                                      </select>
                                    </div>
                                    
								</div>
                                
                        </td>
                        <td><span class="togglebutton toggle-success"><label><input type="checkbox" <?php if($input['disability']==1 && $input['filterMatchesEditDisability']!=''){?>checked=""<?php }?> name="disability" value="1" id="disability2"> </label></span></td>
                    </tr>
                    
                    <tr>
                        <td>
                            <h5 class="filterMatchesLabel">Gender</h5>
                             <p class="filterMatchesLabelValue grey">
								<?=$genderList[$formOne['gender']]?>
                            </p>
                            <p>Filter host families according to family preference for student's gender.</p>
                        </td>
                        <td><span class="togglebutton toggle-success"><label><input type="checkbox" <?php if($input['gender']==1){?>checked=""<?php }?> name="gender" value="1" id="gender2"> </label></span></td>
                    </tr>
                   
                   
                    <tr>
                        <td>
                            <h5 class="filterMatchesLabel">Religion</h5>
                            <p class="filterMatchesLabelValue grey">
								<?php
							      if($input['filterMatchesEditReligion']!='')
								  {
                                      echo $religionList[$input['filterMatchesEditReligion']];
									  echo '<i class="fa fa-edit filterMatchesEditBtn filterMatchesEditBtn-religion"></i>';	  
								  }
									else
										echo "Not available";  
                              ?>   
                            </p>
                            <p>Filter host families according to student's religion.</p>
                            <!--<p>No desc req for now</p>-->
                           
                                <div class="form-group filterMatchesEdit-religion" style="display:none">
									<label for="filterMatchesEditReligion2" class="control-label">What is your religion?</label>
									<div class="">
                                      <select name="filterMatchesEditReligion" id="filterMatchesEditReligion2" class="form-control">
                                          <option value="">Select One</option>
                                          <?php foreach($religionList as $relK=>$relV){?>
                                          <option value="<?=$relK?>" <?php if((string)$input['filterMatchesEditReligion']== (string)$relK){?>selected="selected"<?php } ?>><?=$relV?></option>
                                          <?php } ?>
                                      </select>
                                    </div>
                                    
								</div>
                                
                        </td>
                        <td><span class="togglebutton toggle-success"><label><input type="checkbox" <?php if($input['religion']==1 && $input['filterMatchesEditReligion']!=''){?>checked=""<?php }?> name="religion" value="1" id="religion2"> </label></span></td>
                    </tr>
                   
                   
                    <tr>
                        <td>
                            <h5 class="filterMatchesLabel">Language</h5>
                            <p class="filterMatchesLabelValue grey">
								<?php
							      if($input['filterMatchesEditLanguage']!='')
								  {
                                      echo $languageList[$input['filterMatchesEditLanguage']];
									  echo '<i class="fa fa-edit filterMatchesEditBtn filterMatchesEditBtn-language"></i>';	  
								  }
									else
										echo "Not available";  
                              ?>   
                            </p>
                            <p>Filter host families according to student's language.</p>
                            <!--<p>No desc req for now</p>-->
                           
                                <div class="form-group filterMatchesEdit-language" style="display:none">
									<label for="filterMatchesEditLanguage2" class="control-label">Select student's language</label>
									<div class="">
                                      <select name="filterMatchesEditLanguage" id="filterMatchesEditLanguage2" class="form-control">
                                          <option value="">Select One</option>
                                          <?php foreach($languageList as $langK=>$langV){?>
                                          <option value="<?=$langK?>" <?php if($input['filterMatchesEditLanguage']==$langK){?>selected="selected"<?php } ?>><?=$langV?></option>
                                          <?php } ?>
                                      </select>
                                    </div>
                                    
								</div>
                                
                        </td>
                        <td><span class="togglebutton toggle-success"><label><input type="checkbox" <?php if($input['language']==1 && $input['filterMatchesEditLanguage']!=''){?>checked=""<?php }?> name="language" value="1" id="language2"> </label></span></td>
                    </tr>
                    
                     <tr style="height: 200px;"><td></td></tr>
                    
                </tbdody>
            </table>
          </div>
	</div>
</form> 

<div id="filterMatchesUpdateBtnDiv">
	<input type="button" value="Update" class="m-n btn btn-raised btn-info" onclick="filterMatchesFormSubmit('#filterMatchesForm2');">
</div>

<script type="text/javascript">
$(document).ready(function(){
	
		$('input.Checkbox_stateFilter').click(function() {
													
		$("#filterMatchesEditstate").text($('.Checkbox_stateFilter:checked').map(function() {
    			return this.value;
				}).get().join(', '))
		if($("#filterMatchesEditstate").html()=='')
		{
				$('#filterMatchesEditstateClick').show();
				$('#filterMatchesEditstate').hide();
		}
		else
		{
				$('#filterMatchesEditstateClick').hide();
				$('#filterMatchesEditstate').show();
		}
});

		var suburb_search;
		$('#infoSidebar').on('keyup','#filterMatchesEditSuburb2Temp',function(){
			
			var inputText=$('#filterMatchesEditSuburb2Temp').val().trim();
			if(inputText!='')
			{
				
				if(suburb_search && suburb_search.readystate != 4)
					  suburb_search.abort();
				
				suburb_search =$.ajax({
					url:site_url+'hfa/findSuburb/',
					type:'POST',
					data:{input:inputText},
					success:function(data){
						console.log(data);
						$('#filterMatchesEditSuburb2_suggestions').html(data).show();
						if(data=='')
							$('#filterMatchesEditSuburb2_suggestions').html('').hide();
					}
				});
			}
			else
			{
				if(suburb_search && suburb_search.readystate != 4)
					  suburb_search.abort();
				$('#filterMatchesEditSuburb2_suggestions').html('').hide();
				
				$('#filterMatchesEditSuburbId, #filterMatchesEditSuburbId2').val('');
				$('#filterMatchesEditSuburb2, #filterMatchesEditSuburb2Temp').val('');
			}
		
		});
		
		
		/*$('#infoSidebar').on('keyup','#filterMatchesEditSuburb2Temp',function(){
			var inputText=$('#filterMatchesEditSuburb2Temp').val().trim();
			if(inputText!='')
			{
				var currentRequest = null;
				currentRequest =$.ajax({
					url:site_url+'hfa/findSuburb/',
					type:'POST',
					data:{input:inputText},
					beforeSend : function()
					{           
						if(currentRequest != null) {
							currentRequest.abort();
						}
					},
					success:function(data){
						console.log(data);
						$('#filterMatchesEditSuburb2_suggestions').html(data).show();
						if(data=='')
							$('#filterMatchesEditSuburb2_suggestions').html('').hide();
					}
				});
			}
			else
			{
				if(currentRequest != null)
					currentRequest.abort();	
				$('#filterMatchesEditSuburb2_suggestions').html('').hide();
				
				$('#filterMatchesEditSuburbId, #filterMatchesEditSuburbId2').val('');
				$('#filterMatchesEditSuburb2, #filterMatchesEditSuburb2Temp').val('');
			}
		});*/
		
		$('#infoSidebar').on('click','#filterMatchesEditSuburb2_suggestions > p',function(){
			$('#filterMatchesEditSuburbId, #filterMatchesEditSuburbId2').val($(this).attr('id'));
			$('#filterMatchesEditSuburb2, #filterMatchesEditSuburb2Temp').val($(this).text());
			$('#filterMatchesEditSuburb2_suggestions').html('').hide();
			});
		
	});
</script>