<?php
$recentActivityIconList=recentActivityIconList();
$recentActivityTitleList=recentActivityTitleList();
?>
<div class="widget">
    <div class="widget-heading">Recent Activities</div>
    <div class="widget-body">
        <ul class="timeline">
        
        <?php foreach($activities as $activity){
			$actionDesc=actionDescRA($activity);
			?>
                <li class="timeline-green">
                    <div class="timeline-icon"><i class="material-icons"><?=$recentActivityIconList[$activity['action_on_type']]?></i></div>
                    <div class="timeline-body">
                        <div class="timeline-header">
                            <span class="author"><a href="<?=site_url().$actionDesc['link']?>"><?=$actionDesc['desc']?></a></span>
                            <span class="date"><b><?php echo $recentActivityTitleList[$activity['action_on_type']];?></b></span><br>
                             <span class="date"><?=$actionDesc['timeAgo']?></span>
                        </div>
                    </div>
                </li>
            <?php } ?>
            
        </ul>
    </div>
</div>
<div style="height:65px;"></div>