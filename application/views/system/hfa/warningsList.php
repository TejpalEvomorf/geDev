<?php   
if(!empty($warnings))
	{
		  ?>
    <input type="checkbox" class="read-more-state" id="extraWarnings" />
	<ul class="timeline timelineul read-more-wrap" style="margin-top: 0 !important; margin-left: -24px ;">
	<?php	foreach($warnings as $logK=>$log)
			{
					$employee=employee_details($log['emp']);
					$hfaWarningDocs=hfaWarningDocs($log['id']);
					$hfaWarningDocsCount=count($hfaWarningDocs);
				?>
               
                    <li class="timeline-grey <?php if($logK>2){?>read-more-target<?php } ?>" style="">
                        <div class="timeline-icon"><i class="material-icons">alarm</i></div>
                        <div class="timeline-body">
                            <div class="timeline-header">
                                <span  class="author notes-list-head" style="text-transform: capitalize;" onclick="hfaWarningSendPopContent(<?=$log['id']?>,'edit');"><?=$log['subject']?></span>
                                <?php if( userAuthorisations('hfaWarning_delete')){ ?>
               						 <span onClick="hfaWarning_delete(<?=$log['id'].','.$log['hfa_id']?>);" class="timelineListDel">×</span>
            					<?php } ?>
                               <strong><span>By <?=$employee['fname'].' '.$employee['lname']?></span></strong><br />
                               <span class="date"><?=date('d M Y',strtotime($log['date']));?></span>
                               <span class="note-badge"> <i style="font-size: 16px; margin-left:20px;" class="material-icons">attach_file</i><?php echo $hfaWarningDocsCount;?></span>
                            </div>
                        </div>
                    </li>   
                
<?php } ?></ul>
<?php if(count($warnings)>3){?>
<label for="extraWarnings" class="read-more-trigger">See all</label><?php  }}else {?>
	<span style="margin-left: -20px;margin-top: -10px !important;float: left;">No warnings sent yet</span>
<?php }?>

<script type="text/javascript">
$(document).ready(function(){
	$("label[for='extraWarnings']").click(function(){
		setTimeout(function(){
		
		if($(".read-more-state").is(':checked'))
			$("label[for='extraWarnings']").text('See less');
		else
			$("label[for='extraWarnings']").text('See all');
			
			},500);
		
	});
});
</script>