<?php   
if(!empty($history))
	{
		  ?>
          <div class="panel-body" style="padding-top:0;">
          <div class="widget infobar">
           <div class="widget-heading" style="padding-left:0;">HOLD PAYMENT HISTORY</div>

                <div class="widget-body" style="border-bottom:0px;"> 
          
    <input type="checkbox" class="read-more-state" id="extraHPs" />
	<ul class="timeline timelineul read-more-wrap" style="margin-top: 0 !important; margin-left: -24px ;">
	<?php	foreach($history as $logK=>$log)
			{
					$employee=employee_details($log['employee']);
				?>
               
                    <li class="timeline-grey <?php if($logK>2){?>read-more-target<?php } ?>" style="">
                        <div class="timeline-icon"><i class="material-icons">alarm</i></div>
                        <div class="timeline-body">
                            <div class="timeline-header">
                                <span  class="author notes-list-head" style="text-transform: capitalize;" onclick="hfaWarningSendPopContent(<?=$log['id']?>,'edit');">By <?=$employee['fname'].' '.$employee['lname']?></span>
                                <?php if( userAuthorisations('bookingHoldPayment_delete')){ ?>
               						 <span onClick="bookingHoldPayment_delete(<?=$log['booking_id']?>,<?=$log['id']?>);" class="timelineListDel">×</span>
            					<?php } ?>
                                <?php if($log['reason']!=''){?>
                               		<span><strong>Reason:</strong> <?=$log['reason']?></span><br />
                                <?php } ?>
                               <span class="date"><?=dateFormat($log['date']);?></span>
                            </div>
                        </div>
                    </li>   
                
<?php } ?></ul>
<?php if(count($history)>3){?>
<label for="extraHPs" class="read-more-trigger">See all</label><?php  }?>

</div></div></div>

<script type="text/javascript">
$(document).ready(function(){
	$("label[for='extraHPs']").click(function(){
		setTimeout(function(){
		
		if($(".read-more-state").is(':checked'))
			$("label[for='extraHPs']").text('See less');
		else
			$("label[for='extraHPs']").text('See all');
			
			},500);
		
	});
});
</script>

<?php } ?>