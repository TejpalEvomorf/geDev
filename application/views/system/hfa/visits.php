<?php
if(!empty($visits))
	{  ?>
    <input type="checkbox" class="read-more-state" id="extraVisits" />
	<ul class="timeline timelineul read-more-wrap" style="margin-top: 0 !important; margin-left: -24px ;">
	<?php	foreach($visits as $logK=>$log)
			{
				if(is_numeric($log['employee']))
				{
					$employee=employee_details($log['employee']);
					$empName=$employee['fname'].' '.$employee['lname'];
				}
				else
					$empName=$log['employee'];
				
				$createEdit='View/Edit';
				$bedReport=getVisitReportBedInfo($log['id']);
				if($log['exterior']=='' && $log['exterior_commnets']=='' && $log['interior']=='' && $log['interior_comments']=='' && $log['homeliness']=='' && $log['homeliness_comments']=='' && $log['cleanliness']=='' && $log['cleanliness_comments']=='' && $log['family_warmth']=='' && $log['family_warmth_comments']=='' && $log['floor_type']=='' && $log['no_of_bedrooms']=='' && $log['no_of_bedrooms_used']=='' && $log['no_of_bathrooms']=='' && $log['no_of_bathrooms_used']=='' && $log['smoke_alarm']=='' && $log['smoke_alarm_info']=='' && $log['living_area']=='' && $log['living_area_comments']=='' && $log['dining_area']=='' && $log['dining_area_comments']=='' && $log['kitchen_area']=='' && $log['kitchen_area_comments']=='' && $log['laundry']=='' && $log['laundry_location']=='' && $log['laundry_comments']=='' && $log['floor_type_SF']=='' && $log['no_of_bedrooms_SF']=='' && $log['no_of_bedrooms_used_SF']=='' && $log['no_of_bathrooms_SF']=='' && $log['no_of_bathrooms_used_SF']=='' && $log['smoke_alarm_SF']=='' && $log['smoke_alarm_info_SF']=='' && $log['living_area_SF']=='' && $log['living_area_comments_SF']=='' && $log['dining_area_SF']=='' && $log['dining_area_comments_SF']=='' && $log['kitchen_area_SF']=='' && $log['kitchen_area_comments_SF']=='' && $log['laundry_SF']=='' && $log['laundry_location_SF']=='' && $log['laundry_comments_SF']==''&& $log['floor_type_TF']=='' && $log['no_of_bedrooms_TF']=='' && $log['no_of_bedrooms_used_TF']=='' && $log['no_of_bathrooms_TF']=='' && $log['no_of_bathrooms_used_TF']=='' && $log['smoke_alarm_TF']=='' && $log['smoke_alarm_info_TF']=='' && $log['living_area_TF']=='' && $log['living_area_comments_TF']=='' && $log['dining_area_TF']=='' && $log['dining_area_comments_TF']=='' && $log['kitchen_area_TF']=='' && $log['kitchen_area_comments_TF']=='' && $log['laundry_TF']=='' && $log['laundry_location_TF']=='' && $log['laundry_comments_TF']=='' &&  $log['sa_backyard']=='' && $log['sa_backyard_comments']=='' && $log['sa_internet']=='' && $log['sa_internet_comments']=='' && $log['sa_key']=='' && $log['sa_key_comments']=='' && $log['granny_flat']=='' && $log['granny_flat_comments']=='' && $log['sep_entrance']=='' && $log['sep_entrance_comments']=='' && $log['pool']=='' && $log['pool_comments']=='' && $log['anything']=='' && $log['anything_comments']=='' && $log['camera']=='' && $log['camera_comments']=='' && $log['host_exp']=='' && $log['multicultural']==''  && $log['interest']=='' && $log['religious']=='' && $log['u18_compatible']=='' && $log['here_referral']=='' && $log['here_adv_media']==''  && $log['here_fb']=='' && $log['comments']=='' && empty($bedReport))
					$createEdit='Create';
				?>
               
                    <li class="timeline-grey <?php if($logK>2){?>read-more-target<?php } ?>" style="">
                        <div class="timeline-icon"><i class="material-icons">alarm</i></div>
                        <div class="timeline-body">
                            <div class="timeline-header">
                                <span  class="author tyuedit" style="text-transform: capitalize;"><?=$empName?></span>
                                <?php if(userAuthorisations('hfa_visitReport_delete')){?>
                                    <span onClick="hfa_visitReport_delete(<?=$log['id'].','.$log['hfa_id']?>);" class="hfa_visitReport_delete">×</span>
                                <?php } ?>
	                            <i class="material-icons visitReportCopy" id="visitReportCopy-<?=$log['id']?>" style="cursor:pointer;">content_copy</i>
                                <span class="date" style="float:left; margin-top: 5px;"><?=date('d M Y, h:i A',strtotime($log['date_visited']));?>
                                <?php if(userAuthorisations('hfa_visitReport_editDate')){?>
                                <i style="color:#bdbdbd; font-size: 15px; margin-top: 1px;" class="fa fa-edit visitReportDateEdit" id="visitReportDateEdit-<?=$log['id']?>"></i>
                                <?php }?>
                                <?php if($log['revisit']=='1'){?>
	                                <i style="font-size: 16px; margin-left:5px; float:right;" class="material-icons">restore</i>
                                <?php } ?>
                                </span>
                                 <a style="color:#0fb2fc; text-align:left; width:auto; height: auto; clear:both;" href="<?=site_url()?>hfa/viewVisitReport/<?=$log['id']?>">
                                 <span class="note-badge" style="font-size: 13px;"> <i style="margin-top: -2px; font-size: 16px; color:#0fb2fc; margin-right: 5px;" class="material-icons">assignment</i><?=$createEdit?> report</span>
                                 </a>
                                 
								
                            </div>
                        </div>
                    </li>   
                
<?php } ?></ul>
<?php if(count($visits)>3){?>
<label for="extraVisits" class="read-more-trigger">See all</label><?php  }}else {?>
	<span style="margin-left: -20px;margin-top: -10px !important;float: left;">Visit history not available</span>
<?php }?>

<script type="text/javascript">
$(document).ready(function(){
	$("label[for='extraVisits']").click(function(){
		setTimeout(function(){
		
		if($(".read-more-state").is(':checked'))
			$("label[for='extraVisits']").text('See less');
		else
			$("label[for='extraVisits']").text('See all');
			
			},500);
		
	});
});
</script>