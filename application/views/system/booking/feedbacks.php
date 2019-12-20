<?php if(!empty($feedbacks)){?>
<input type="checkbox" class="read-more-state" id="extraFeedbacks" />
<ul class="timeline timelineul read-more-wrap" style="margin-top: 0 !important; margin-left: -24px ;">
<?php	foreach($feedbacks as $logK=>$log)
{
  $student=getshaOneAppDetails($log['student']);
  $host=getHfaOneAppDetails($log['host']);
  ?>

<li class="timeline-grey <?php if($logK>2){?>read-more-target<?php } ?>" style="">
    <div class="timeline-icon"><i class="material-icons">alarm</i></div>
    <div class="timeline-body">
        <div class="timeline-header">
            <a href="<?=site_url()?>booking/view/<?=$log['booking']?>" style="width:unset;text-align:unset;"><span  class="author tyuedit" style="text-transform: capitalize;">By <?=ucwords($student['fname'].' '.$student['lname'])?> for <?=$host['lname']?> Family</span></a>
            <?php if($this->router->fetch_class()=='booking' && userAuthorisations('bookingFeedback_delete')){ ?>
                <span onClick="bookingFeedback_delete(<?=$log['id'].','.$log['booking']?>);" class="bookingFeedback_delete">×</span>
            <?php } ?>
           <span class="date"><?=date('d M Y h:i A',strtotime($log['date']));?></span>
           <a class="colorBlue" style="text-align:left; width:auto; height: auto;" href="<?=site_url()?>form/studentFeedbackView/<?=$log['id']?>" target="_blank">
             <span class="note-badge" style="font-size: 13px;"> <i style="margin-top: -2px; font-size: 16px; color:inherit;margin-right: 5px;" class="material-icons">assignment</i>View feedback</span>
             </a>
        </div>
    </div>
</li>   

<?php } ?></ul>
<?php if(count($feedbacks)>3){?>
<label for="extraFeedbacks" class="read-more-trigger">See all</label><?php  }?>

<script type="text/javascript">
$(document).ready(function(){
	$("label[for='extraFeedbacks']").click(function(){
		setTimeout(function(){
		
		if($(".read-more-state").is(':checked'))
			$("label[for='extraFeedbacks']").text('See less');
		else
			$("label[for='extraFeedbacks']").text('See all');
			
			},500);
		
	});
});
</script>
<?php } ?>