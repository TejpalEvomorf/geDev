<?php   
if(!empty($checkups))
	{
		$bookingCheckupTypeList=bookingCheckupTypeList();
		  ?>
    <input type="checkbox" class="read-more-state" id="extraCheckups" />
	<ul class="timeline timelineul read-more-wrap" style="margin-top: 0 !important; margin-left: -24px ;">
	<?php	foreach($checkups as $logK=>$log)
			{
					$employee=employee_details($log['employee']);
					$empName=$employee['fname'].' '.$employee['lname'];
				?>
               
                    <li class="timeline-grey <?php if($logK>2){?>read-more-target<?php } ?>" style="">
                        <div class="timeline-icon"><i class="material-icons">alarm</i></div>
                        <div class="timeline-body">
                            <div class="timeline-header">
                                <span  class="author tyuedit" onclick="bookingCheckupPopContent(<?=$log['id']?>,'<?=$log['type']?>','edit');" style="cursor:pointer;"><?=$bookingCheckupTypeList[$log['type']]?></span>
                                 <?php if($log['type']=='3' && userAuthorisations('bookingCheckup_delete')){ ?>
                                	<span onClick="bookingCheckup_delete(<?=$log['id'].','.$log['booking']?>);" class="bookingCheckup_delete">×</span>
                                <?php } ?>
                                <span class="date">on <?=date('d M Y',strtotime($log['checkup_date']));?> by <?=$empName?></span>
                            </div>
                        </div>
                    </li>   
                
<?php } ?></ul>
<?php if(count($checkups)>3){?>
<label for="extraCheckups" class="read-more-trigger">See all</label><?php  }}else {?>
	<span style="margin-left: -20px;margin-top: -10px !important;float: left;">Check-up info not available</span>
<?php }?>

<script type="text/javascript">
$(document).ready(function(){
	$("label[for='extraCheckups']").click(function(){
		setTimeout(function(){
		
		if($(".read-more-state").is(':checked'))
			$("label[for='extraCheckups']").text('See less');
		else
			$("label[for='extraCheckups']").text('See all');
			
			},500);
		
	});
});
</script>