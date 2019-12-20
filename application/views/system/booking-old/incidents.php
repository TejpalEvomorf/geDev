<?php   
if(!empty($incidents))
	{
		$incidentStatusList=incidentStatusList();
		  ?>
    <input type="checkbox" class="read-more-state" id="extraIncidents" />
	<ul class="timeline timelineul read-more-wrap" style="margin-top: 0 !important; margin-left: -24px ;">
	<?php	foreach($incidents as $logK=>$log)
			{
					$employee=employee_details($log['employee']);
					$empName=$employee['fname'].' '.$employee['lname'];
					$followUps=bookingIncidentFollowUps($log['id']);
					$followUpsCount=count($followUps);
					$incidentDocs=bookingIncidentDocs($log['id']);
					$incidentDocsCount=count($incidentDocs);
				?>
               
                    <li class="timeline-grey <?php if($logK>2){?>read-more-target<?php } ?>" style="">
                        <div class="timeline-icon"><i class="fa fa-info"></i></div>
                        <div class="timeline-body">
                            <div class="timeline-header">
                                <span  class="author tyuedit" style="text-transform: capitalize;"><?=$empName?></span>
                                <?php if($this->router->fetch_class()=='booking'){ ?>
                                	<span onClick="bookingIncident_delete(<?=$log['id'].','.$log['booking_id']?>);" class="bookingIncident_delete">×</span>
                                <?php } ?>
                               <span class="date"><?=date('d M Y',strtotime($log['incident_date']));?></span>
                               <span class="note-badge"> <i style="font-size: 16px; margin-left:20px;" class="material-icons">attach_file</i><?php echo $incidentDocsCount;?></span>
                               <div>
                               <a class="<?php if($log['status']=='1'){echo 'colorBlue';}else{echo 'colorRed';}?>" style="text-align:left; width:max-content; height: auto;display:unset;margin-right:10px;" href="javascript:void(0);" onClick="bookingIncidentPopContent(<?=$log['id']?>,'edit');">
                                 <span class="note-badge" style="font-size: 13px;" data-placement="right" data-toggle="tooltip"  data-original-title="Incident <?=$incidentStatusList[$log['status']]?>"> <i style="margin-top: -2px; font-size: 16px; color:inherit;margin-right: 5px;" class="material-icons">assignment</i>View/Edit</span>
                                 </a>
                                 
                                 <?php if($followUpsCount>0){?>
                                       <a class="colorBlue" style="text-align:left; width:max-content; height: auto;display:unset;" href="javascript:void(0);" onClick="bookingIncidentViewFollowUpPopContent(<?=$log['id']?>);" id="viewFollowUps-<?=$log['id']?>">
                                         <span class="note-badge" style="font-size: 13px;"> <i style="margin-top: -2px; font-size: 16px; color:inherit;margin-right: 5px;" class="material-icons">remove_red_eye</i>View follow ups (<?=$followUpsCount?>)</span>
                                       </a>
                                 <?php }
								 else{ ?>
                                       <a class="colorBlue" style="text-align:left; width:max-content; height: auto;display:unset;" href="javascript:void(0);" onClick="bookingIncidentAddFollowUpPopContent(<?=$log['id']?>);">
                                         <span class="note-badge" style="font-size: 13px;"> <i style="margin-top: -2px; font-size: 16px; color:inherit;margin-right: 5px;" class="material-icons">add</i>Add follow up</span>
                                       </a>
                                 <?php } ?>
                                 </div>
                            </div>
                        </div>
                    </li>   
                
<?php } ?></ul>
<?php if(count($incidents)>3){?>
<label for="extraIncidents" class="read-more-trigger">See all</label><?php  }}else {?>
	<span style="margin-left: -20px;margin-top: -10px !important;float: left;">Incident report not available</span>
<?php }?>

<script type="text/javascript">
$(document).ready(function(){
	$("label[for='extraVisits']").click(function(){
		setTimeout(function(){
		
		if($(".read-more-state").is(':checked'))
			$("label[for='extraIncidents']").text('See less');
		else
			$("label[for='extraIncidents']").text('See all');
			
			},500);
		
	});
});
</script>