<?php 
$roomTypeList=roomTypeList();
$floorTypeList=floorTypeList();

$roomShown=0;
?>
<div class="radio" id="roomsAvailRadioList" >
                    
	  <?php foreach($rooms as $roomK=>$room) {
						if((in_array($accomodation_type,array('4','5')) && $room['vip']!=1) || (in_array($accomodation_type,array('1','2','3')) && $room['vip']==1))
							continue;
						
						if(checkIfBedBooked($room['id'],$accomodation_type,$studentBookingDates))
							continue;
						elseif(!in_array($room['type'],$roomType))
							continue;
						else
							$roomShown++;
		  ?>
          <div class="radio block bookingFormRoomInfoDivParent">
            <label>
                <input type="radio" name="CHB_hfaRoom"  <?php if($roomShown==1){echo 'checked';}?> value="<?=$room['id']?>" required>
                <span class="circle"></span>
                <span class="check"></span>
                Bedroom
                <?=$roomK+1 .': '.$roomTypeList[$room['type']]?>
                            <?php
                                if($room['vip']==1)
                                    echo '- VIP';
                            ?>
            </label>
            <div class="bookingFormRoomInfoDiv" <?php if($roomShown>1){echo 'style="display:none;"';}?>>
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
          <?php } 
		  if($roomShown==0)
		  {?>
          	<p id="roomsUnAvailErrorMessage" class="roomsUnAvailErrorMessage">No bed is available with this host</p>
          <?php } ?>
</div>

<script type="text/javascript">
$('input[name=CHB_hfaRoom]').click(function(){
			var parentDiv=$(this).parents('div.bookingFormRoomInfoDivParent')
			$('.bookingFormRoomInfoDivParent').not(parentDiv).find('.bookingFormRoomInfoDiv').slideUp();
			parentDiv.find('.bookingFormRoomInfoDiv').slideDown();
});
</script>