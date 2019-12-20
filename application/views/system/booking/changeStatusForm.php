<style>
.warningCol.display-margin {

    margin-right: 4px !important;

}
</style>

<?php
$bookingStatusList=bookingStatusList();
if($status=='progressive' || $status=='moved_out' || $status=='cancelled')
	echo '<p>You cannot change status of '.$bookingStatusList[$status].' booking.</p>';
else
{
?>
<div id="ChangeStatusPopContentDiv">
    <div class="m-n form-group">
        <label class="control-label">Status</label>
            <select class="form-control" id="bookingChangeStatus_status" name="bookingChangeStatus_status">
                <?php foreach($bookingStatusList as $sK=>$sV){
						if($serviceOnlyBooking=='1' && strtotime($booking_from)==strtotime($booking_to))
						{
							if(!in_array($sK,array('expected_arrival','moved_out')))
								continue;
						}
						else
						{
							if($status=='expected_arrival' && ($sK=='progressive' || $sK=='moved_out'))
								continue;
							if($status=='arrived' && ($sK=='expected_arrival' || $sK=='on_hold' || $sK=='cancelled' || $sK=='moved_out'))
								continue;	
							if($status=='progressive' || $status=='moved_out' || $status=='cancelled')
								continue;
							if($status=='on_hold' && ($sK!='expected_arrival' && $sK!='arrived'))
								continue;
						}
					?>
                            <option value="<?=$sK?>" <?php if($status==$sK){echo 'selected="selected"';}?>><?=$sV?></option>
                        <?php } ?>
            </select>
    </div>
        
      <div class="pl-n m-n form-group col-xs-12"  id="bookingChangeStatus_dateDiv" <?php if($status!='cancelled'){?>style="display:none;"<?php } ?>>
            <label class="control-label">Date</label>
            <div class="input-group date">
                <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
                <input type="text" class="form-control"  name="bookingChangeStatus_date" id="bookingChangeStatus_date" value="<?php if($date_cancelled=='0000-00-00'){echo date('d/m/Y');}else{echo date('d/m/Y',strtotime($date_cancelled));}?>">
            </div>
        </div>
                      
       <div id="changeStatusCommentDiv" <?php if($status!='on_hold' && $status!='cancelled'){?>style="display:none;"<?php } ?>>
          <div class="form-group m-n">
					<label class="control-label">Comments</label>
					<textarea class="form-control" name="bookingChangeStatus_comment"><?=$comments?></textarea>
		 </div>
</div>   
       
                         
   <input type="hidden" name="bookingChangeStatus_id" id="bookingChangeStatus_id" value="<?=$id?>" />
   <input type="hidden" name="pageStatus" value="<?=$pageStatus?>" id="pageStatus" />
</div>
<!--2222222222222222-->
<?php if(!isset($studyTourBookings))
{?>
<div id="checkupPopContentDiv" style="display:none;">
<?php $this->load->view('system/booking/checkupPopContent');?>
</div>
<?php } ?>
<!--2222222222222222-->

 
 	<!--111111111111-->
    <?php
	if(isset($studyTourBookings))
	{
    $shaOne=getshaOneAppDetails($student);
	$tourDetail=tourDetail($shaOne['study_tour_id']);
	?>
    <input type="hidden"  name="studyTourId" value="<?=$shaOne['study_tour_id']?>"/>
    <input type="hidden"  name="bookingStatus" value="<?=$status?>"/>
	<div style="background: hsl(195, 12%, 94%) none repeat scroll 0 0;padding: 1em;">This booking is a part of tour group: <b><?=$tourDetail['group_name']?></b></div>
    
    <?php if(!empty($studyTourBookings)){?>
    
    
    <p style="margin:15px 0; font-size: 12px; color: #BDBDBD;">Below is the list of all the bookings related to this tour group. You can select the bookings for which you want to change the status along with the current booking's status change.This list can also contain bookings that have status as progressive, moved out and cancelled. It could also contain bookings that have changed homestay.</p>
    <div class="alert alert-info_orange ui-pnotify-container">You will not be able to select progressive, moved out and cancelled bookings as their status can't be changed.</div>
    <div style="background: hsl(195, 12%, 94%) none repeat scroll 0 0; margin: 15px 0 0 0; padding: 1em;">
          <div class="warningRowParent" style="margin:0; padding:0;">
              <div class="warningRow">
                  <div class="warningCol" style="color:#424242; font-weight:bold;width:43%;pointer:default;"">Booking details</div>
                  <div class="warningCol" style="color:#424242; font-weight:bold;width:43%;pointer:default;"">Status</div>
                  <div class="warningCol <?php if(count($studyTourBookings)>4){echo " display-margin";}?>" style="width:50px;float:right; padding:0; margin-right: -1em;">
                            <div class="checkbox checkbox-primary" style="margin:0; padding:0;">
                                <label data-placement="bottom" data-toggle="tooltip"  data-original-title="Select all">
                                    <input type="checkbox" id="bookingsWarningSelectAll">
                                    <span class="checkbox-material"><span class="check" style="margin:0;"></span></span>
                                </label>
                            </div>
                    </div>
              </div>
          </div>
      </div>
        <div style="overflow-y: auto; max-height: 400px;">
    <?php foreach($studyTourBookings as $sTB){?>
            <div class="warningRowParent">
                <div class="warningRow">
                    <div class="warningCol" style="width:43%;pointer:default;">
                    	Booking id: <a href="<?=site_url()?>booking/view/<?=$sTB['id']?>" target="_blank"><?=$sTB['id']?></a><br>
                        Duration:
                        <?php
								if($sTB['booking_from']!='0000-00-00')
								{
									echo date('d M Y',strtotime($sTB['booking_from']));
									if($sTB['booking_to']!='0000-00-00')
										echo ' - '.date('d M Y',strtotime($sTB['booking_to'].' +1 day'));
									else	
										echo ' - Not set';
								}
								else
									$row3 .='Not set';
						?>
                        <br>
                        Host: <a href="<?=site_url().'hfa/application/'.$sTB['host']?>" target="_blank"><?=ucfirst($sTB['hfa_lname'])?> Family</a>
                        <br>
                        Student: <a href="<?=site_url().'sha/application/'.$sTB['student']?>" target="_blank"><?=ucwords($sTB['sha_fname'].' '.$sTB['sha_lname'])?></a>
                    </div>
                    <div class="warningCol" style="width:43%;"><?=$bookingStatusList[$sTB['status']]?><?php if($sTB['duplicate']!='0'){echo '<p style="color:#b0b0b0;font-size:11px;">(Homestay changed)</p>';}?></div>
                    <div class="warningCol" style="width:50px;float:right; padding:0;">
                            <div class="checkbox checkbox-primary"  style=" padding:0;" <?php if(in_array($sTB['status'], array('progressive','moved_out','on_hold','cancelled'))){?>data-placement="bottom" data-toggle="tooltip"  data-original-title="<?=$bookingStatusList[$sTB['status']]?> booking status can't be changed"<?php } ?>>
                                <label class="">
                                    <input type="checkbox" name="bookingsWarning[]" value="<?=$sTB['id']?>" <?php if(in_array($sTB['status'], array('progressive','moved_out','on_hold','cancelled'))){?>disabled="disabled"<?php }else{?> class="bookingsWarningCB" <?php } ?>>
                                    <span class="checkbox-material"><span class="check" style="margin:0;"></span></span>
                                </label>
                            </div>
                    </div>
                </div>
            </div>
    <?php }echo "</div>";
	}
	}
	?>
 <!--111111111111-->
 
 <?php } ?>    
   <script type="text/javascript">
   
	   function changeSubmitBtnText()
	   {
		   if($('#bookingChangeStatus_changeAll').is(':checked'))
				$('#bookingChangeStatusSubmit').text('Change for all');
			else				
				$('#bookingChangeStatusSubmit').text('Change');
	   }
	   
	   $(document).ready(function(){
		   initializeToolTip();
		   changeSubmitBtnText();
		   $('#bookingChangeStatus_changeAll').click(function(){
			  		changeSubmitBtnText();
			  });
		   
		   $('#bookingChangeStatus_date').datepicker({
			orientation: "top",
			todayHighlight: true,
	    	startDate: "-0d",
			format:'dd/mm/yyyy',
			autoclose:true
		});
		
		   var bookingStatus='<?=$status?>';
		   if(bookingStatus=='progressive' ||bookingStatus=='moved_out' ||bookingStatus=='cancelled')
		   {
			   $('#bookingChangeStatusSubmit').hide();
			   $('#bookingChangeStatusClose').show();
		   }
		   else
		   {
			   $('#bookingChangeStatusSubmit').show();
			   $('#bookingChangeStatusClose').hide();
		   }
		   
		   $('#bookingsWarningSelectAll').click(function(){
			 	$(".bookingsWarningCB").prop('checked', $(this).prop('checked'));
			});
			 
		  $(".bookingsWarningCB").change(function(){
					if (!$(this).prop("checked"))
						$("#bookingsWarningSelectAll").prop("checked",false);
    		});
			
			$('#bookingChangeStatusNext').click(function(){
				
				$('#ChangeStatusPopContentDiv, #bookingChangeStatus_statusTitle, #bookingChangeStatusNext').hide();
				$('#checkupPopContentDiv, #bookingChangeStatus_arrivalTitle, #bookingChangeStatusSubmit, #bookingChangeStatusBack').show();
				
			});
			
			$('#bookingChangeStatusBack').click(function(){
				
				$('#ChangeStatusPopContentDiv, #bookingChangeStatus_statusTitle, #bookingChangeStatusNext').show();
				$('#checkupPopContentDiv, #bookingChangeStatus_arrivalTitle, #bookingChangeStatusSubmit, #bookingChangeStatusBack').hide();
				
			});
			
		   });
	   </script>
     