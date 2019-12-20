<?php   
if(!empty($holidays))
	{
		  ?>
    <input type="checkbox" class="read-more-state" id="extraHolidays" />
	<ul class="timeline timelineul read-more-wrap" style="margin-top: 0 !important; margin-left: -24px ;">
	<?php	foreach($holidays as $logK=>$log)
			{
					$employee=employee_details($log['employee']);
					$empName=$employee['fname'];
				?>
               
                    <li class="timeline-grey <?php if($logK>2){?>read-more-target<?php } ?>" style="">
                        <div class="timeline-icon"><i class="material-icons">alarm</i></div>
                        <div class="timeline-body">
                            <div class="timeline-header">
                                <span  class="author notes-list-head" style="text-transform: capitalize;" onclick="bookingHolidayPopContent(<?=$log['id']?>,'edit');"><?=dateFormat($log['start']).' - '.dateFormat($log['end'])?></span>
                                <?php if($this->router->fetch_class()=='booking' && userAuthorisations('bookingHoliday_delete')){ ?>
                                	<span onClick="bookingHoliday_delete(<?=$log['id'].','.$log['booking_id']?>);" class="timelineListDel">×</span>
                                <?php } ?>
                               <span class="date"><?='by '.$empName.' on '.dateFormat($log['date'])?></span>
                            </div>
                        </div>
                    </li>   
                
<?php } ?></ul>
<?php if(count($holidays)>3){?>
<label for="extraHolidays" class="read-more-trigger">See all</label><?php  }}else {?>
	<span style="margin-left: -20px;float: left;">Holiday info not available</span>
<?php }?>

<script type="text/javascript">
$(document).ready(function(){
	$("label[for='extraHolidays']").click(function(){
		setTimeout(function(){
		
		if($(".read-more-state").is(':checked'))
			$("label[for='extraHolidays']").text('See less');
		else
			$("label[for='extraHolidays']").text('See all');
			
			},500);
		
	});
});
</script>