<div class="widget-heading" style="padding-left:0;">Approved by following colleges</div>
		<div class="widget-body" style="border-bottom:0px;"> 

					<?php   if(!empty($cApprovalList)){  ?>					
                        <input type="checkbox" class="read-more-state" id="extraCApprovals" />
                        <ul class="timeline read-more-wrap" style="margin-top: 0 !important; margin-left: -24px ;" id="cApprovalList">
								<?php   foreach($cApprovalList as $valK=>$val){ 
									$college=clientDetail($val['college_id']);
								?>
                
                                    <li style="padding-bottom: 0;" class="timeline-grey <?php if($valK>2){?>read-more-target<?php } ?>">
                                        <div class="timeline-icon"><i class="material-icons">alarm</i></div>
                                        <div class="timeline-body">
                                            <div class="timeline-header">
                                                <span data-id="<?=$val['hfa_id'] ?>" data-postid="<?=$val['id']?>" class="notes-list-head author"><?=$college['bname']?></span>
                                                <span class="date"><?=date('d M Y',strtotime($val['date']));?></span>
                                                <span onClick="cApprovalDel(<?=$val['id'].','.$val['hfa_id']?>);" class="cApprovalDel">×</span>
                                            </div>
                                        </div>
                                    </li>
                            <?php } ?>
					</ul>

				<?php
                if(count($cApprovalList)>3){?>
                    <label for="extraCApprovals" class="read-more-trigger">See all</label>
                <?php
                  }}
                 else {?>

					<div class="m-n form-group" style="margin-left: -16px !important;">No college approval found.</div>
				<?php } ?>	

                </div>

<script type="text/javascript">

$(document).ready(function(){
	
		$("label[for='extraCApprovals']").click(function(){
			setTimeout(function(){
			
			if($(".read-more-state").is(':checked'))
				$("label[for='extraCApprovals']").text('See less');
			else
				$("label[for='extraCApprovals']").text('See all');
				
				},500);
		});
	
});

</script>	