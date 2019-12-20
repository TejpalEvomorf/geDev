<?php //see($_POST);
$employeeList=employeeList();
$clientsList=clientsList();
$loggedInUser=loggedInUser();
$formTwo=getHfaTwoAppDetails($host);
$roomTypeList=roomTypeList();
$floorTypeList=floorTypeList();
?>
<div class="pl-n m-n form-group col-xs-6">
    <label class="control-label">Booking owner</label>
    <select class="form-control" id="placeBooking_owner" name="placeBooking_owner" required>
	    <option value="">Select employee</option>
        <?php foreach($employeeList as $eV){?>
                    <option value="<?=$eV['id']?>"  <?php if($studentOne['employee']==$eV['id']){echo 'selected="selected"';}?>><?=$eV['fname'].' '.$eV['lname']?></option>
                <?php } ?>
    </select>
</div>

<div class="pl-n m-n form-group col-xs-6">
    <label class="control-label">Associated Client</label>
    <select class="form-control" id="placeBooking_owner" name="placeBooking_owner" required onchange="updateClientProductsBookingPop(this.val);">
	    <option value="">Select Client</option>
        <?php foreach($clientsList as $cV){?>
                    <option value="<?=$cV['id']?>"  <?php if($studentOne['client']==$cV['id']){echo 'selected="selected"';}?>><?=$cV['bname']?></option>
                <?php } ?>
    </select>
</div>


<div class="pl-n m-n form-group col-xs-6">
  <label class="control-label">Booking start date</label>
      <div class="input-group date">
          <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
          <input type="text" class="form-control"  name="placeBooking_startDate" id="placeBooking_startDate" value="<?php if($studentOne['booking_from']!='0000-00-00'){echo date('d/m/Y',strtotime($studentOne['booking_from']));}?>" required>
      </div>
</div>

<div class="pl-n m-n form-group col-xs-6">
  <label class="control-label">Booking end date</label>
      <div class="input-group date">
          <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
          <input type="text" class="form-control"  name="placeBooking_endDate" id="placeBooking_endDate" value="<?php if($studentOne['booking_to']!='0000-00-00'){echo date('d/m/Y',strtotime($studentOne['booking_to'].' +1 day'));}?>">
      </div>
</div>


<?php 
  $studentBookingDates['from']=$studentBookingDates['to']='';
  if($studentOne['booking_from']!='0000-00-00')
	  $studentBookingDates['from']=$studentOne['booking_from'];
  if($studentOne['booking_to']!='0000-00-00')
	  $studentBookingDates['to']=$studentOne['booking_to'];
	
  $bedroomDetails=array();
  foreach($formTwo['bedroomDetails'] as $r){
	  
	  if(checkIfBedBooked($r['id'],$studentOne['accomodation_type'],$studentBookingDates))
	  {
		  if(checkIfBedEligibleForTripleShare($r['id'],$studentOne['accomodation_type'],$studentBookingDates))
			  {$r['triple_share']=1;$bedroomDetails[]=$r;}
		  else
			  continue;
	  }
	  elseif($_POST['hostName']=='1' && $_POST['hostNameSearchAll']=='all')
		$bedroomDetails[]=$r;  
	  elseif(!in_array($r['type'],explode(',',$_POST['filterMatchesEditAccomodation_typeRoomType'])) && $_POST['accomodation_type']=='1')
		 continue;
	  elseif((($_POST['filterMatchesEditAccomodation_type']=='4' || $_POST['filterMatchesEditAccomodation_type']=='5') && $r['vip']!='1')  && $_POST['accomodation_type']=='1')
		continue;
	  /*elseif(($_POST['filterMatchesEditAccomodation_type']!='4' && $_POST['filterMatchesEditAccomodation_type']!='5') && $r['vip']=='1')
		continue;*/	  
	elseif(($_POST['filterMatchesEditAccomodation_typeGrannyFlat']=='0' ) && $r['access']=='1' && $r['granny_flat']=='1' && $_POST['accomodation_type']=='1')
		continue;	  	
	  else
		  $bedroomDetails[]=$r;
  }//see($bedroomDetails);
 ?>
                        
<div class="form-group" style="position:unset;">
	  <label for="radio" class="control-label">Select the room you want to place the student in</label>
      <div class="col-sm-12">
            <div class="radio" id="roomsAvailRadioList" <?php if(empty($bedroomDetails)){?>style="display:none;"<?php } ?>>
                    
                                                          
					<?php foreach($bedroomDetails as $roomK=>$room){
						
						?>
                                    
                        <div class="radio block bookingFormRoomInfoDivParent">
                          <label>
                              <input type="radio" name="placeBooking_bedroom"  <?php if(count($bedroomDetails)==1){echo 'checked';}?> value="<?=$room['id']?>" required>
                              <span class="circle"></span>
                              <span class="check"></span>
                              <?='Bedroom '?>
                              <?=$roomK+1 .': '.$roomTypeList[$room['type']]?>
                                          <?php
                                              if($room['vip']==1)
                                                  echo '- VIP';
											  if(isset($room['triple_share']))
											  	  echo ' (Available for triple share)';
                                          ?>
                          </label>
                          <div class="bookingFormRoomInfoDiv" <?php if(count($bedroomDetails)>1){echo 'style="display:none;"';}?>>
                              <table class="table about-table">
                                <tbody>
                                      <tr>
                                          <td><b>Flooring type</b> :
                                            <?php
                                                if($room['flooring']!="5")
                                                    echo ucfirst($floorTypeList[$room['flooring']]);
                                                else	
                                                    echo ucfirst($room['flooring_other']);
                                            ?>
                                      </td>
                                      </tr>
                                      <tr>
                                          <td><b>Room access</b> :
                                            <?php
                                                if($room['access']=="0")
                                                    echo 'Inside';
                                                elseif($room['access']=="1")
                                                {	
                                                    echo 'Outside';
                                                    if($room['granny_flat']=="0")
                                                        echo ", not a granny flat";
                                                    elseif($room['granny_flat']=="1")
                                                        echo ", granny flat";	
                                                }
                                               else
                                                  echo 'n/a'; 
                                            ?>
                                          </td>
                                      </tr> 
                                      <tr>
                                          <td><b>Internal ensuite</b> :
                                            <?php
                                                if($room['internal_ensuit']=="1")
                                                    echo 'Yes';
                                                elseif($room['internal_ensuit']=="0")
                                                    echo 'No';
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
                                                        
            </div>
            
	            
						<p id="roomsUnAvailErrorMessage" <?php if(!empty($bedroomDetails)){?>style="display:none;"<?php } ?>>No bed is available with this host</p>
					
      </div>
</div>

<input type="hidden" name="student" value="<?=$student?>" />
<input type="hidden" name="host" value="<?=$host?>" />


<script type="text/javascript">
$(document).ready(function(){

		$('#placeBooking_startDate, #placeBooking_endDate').datepicker({
			/*orientation: "top",*/
			todayHighlight: true,
	    	startDate: "-0d",
			format:'dd/mm/yyyy',
			autoclose:true
		});
		
		
		<?php if(empty($bedroomDetails)){?>
			$('#matchedAppPlaceBookingSubmit').hide();
		<?php } else{?>
			$('#matchedAppPlaceBookingSubmit').show();
		<?php } ?>
		
		$('input[name=placeBooking_bedroom]').click(function(){
				var parentDiv=$(this).parents('div.bookingFormRoomInfoDivParent')
				$('.bookingFormRoomInfoDivParent').not(parentDiv).find('.bookingFormRoomInfoDiv').slideUp();
				parentDiv.find('.bookingFormRoomInfoDiv').slideDown();
			});
	});
</script>