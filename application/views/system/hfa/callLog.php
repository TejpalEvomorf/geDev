<?php   
if(!empty($callLog))
	{  ?><input type="checkbox" class="read-more-state" id="extraCallLogs" />
	<ul class="timeline timelineul read-more-wrap" style="margin-top: 0 !important; margin-left: -24px ;">
	<?php	foreach($callLog as $logK=>$log)
			{
				$employee=employee_details($log['employee']);
				?>
               
                    <li class="timeline-grey <?php if($logK>2){?>read-more-target<?php } ?>" style="">
                        <div class="timeline-icon"><i class="material-icons">alarm</i></div>
                        <div class="timeline-body">
                            <div class="timeline-header">
                                <span  class="author tyuedit" style="text-transform: capitalize;"><?=$employee['fname'].' '.$employee['lname']?></span>
                                <?php if(userAuthorisations('hfa_callLog_delete')){?>
                                    <span onClick="hfa_callLog_delete(<?=$log['id'].','.$log['hfa_id']?>);" class="hfa_callLog_delete">×</span>
                                <?php } ?>
                                <span class="date"><?=date('d M Y, h:i A',strtotime($log['date_called']));?></span>
                                <?php if($log['reason']!=''){?>
                                	<br><span class="date" style="color:#616161;"><?=nl2br($log['reason'])?></span>
                                <?php } ?>
                                
								
                            </div>
                        </div>
                    </li>   
                
<?php } ?></ul>
<?php if(count($callLog)>3){?>
<label for="extraCallLogs" class="read-more-trigger">See all</label><?php  }}else {?>
	<span style="margin-left: -20px;margin-top: -10px !important;float: left;">Call history not available</span>
<?php }?>

<script type="text/javascript">
$(document).ready(function(){
	$("label[for='extraCallLogs']").click(function(){
		setTimeout(function(){
		
		if($(".read-more-state").is(':checked'))
			$("label[for='extraCallLogs']").text('See less');
		else
			$("label[for='extraCallLogs']").text('See all');
			
			},500);
		
	});
});
</script>