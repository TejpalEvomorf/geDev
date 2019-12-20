<?php   
if(!empty($transport))
	{
		  ?>
    <input type="checkbox" class="read-more-state" id="extraTransport" />
	<ul class="timeline timelineul read-more-wrap" style="margin-top: 0 !important; margin-left: -24px ;">
	<?php	foreach($transport as $logK=>$log)
			{
					$college=clientDetail($log['college_id']);
				?>
               
                    <li class="timeline-grey <?php if($logK>2){?>read-more-target<?php } ?>" style="">
                        <div class="timeline-icon"><i class="material-icons">alarm</i></div>
                        <div class="timeline-body">
                            <div class="timeline-header">
                                <span  class="author notes-list-head" style="text-transform: capitalize;" onclick="hfaTransportInfoPopContent(<?=$log['id']?>,'edit');"><?=$log['type']?></span>
                               <?php if( userAuthorisations('hfaTransportInfo_delete')){ ?>
               						 <span onClick="hfaTransportInfo_delete(<?=$log['id'].','.$log['hfa_id']?>);" class="timelineListDel" style="margin-left:3px;">×</span>
            					<?php } ?>
                                <?php if(trim($log['gmap_link'])!=''){?>
	                                <span style="float:right; margin-top: -22px;" data-placement="bottom" data-toggle="tooltip" data-original-title="Google map location"><a href="<?=$log['gmap_link']?>" target="_blank"><i style="font-size: 16px; margin-right: -10px;" class="material-icons colorBlue">location_on</i></a></span>
                                <?php } ?>
                               <strong><span><?=$college['bname']?></span></strong><br />
                               <span class="date"><?=date('d M Y',strtotime($log['date']));?></span>
                            </div>
                        </div>
                    </li>   
                
<?php } ?></ul>
<?php if(count($transport)>3){?>
<label for="extraTransport" class="read-more-trigger">See all</label><?php  }}else {?>
	<span style="margin-left: -20px;margin-top: -10px !important;float: left;">Transport info not available</span>
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