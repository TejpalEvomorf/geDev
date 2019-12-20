<?php   
	if(!empty($transport))
       {
?> 
        <div class="panel panel-profile panel panel-bluegraylight">
            <div class="panel-heading">
                <h2>Transport information</h2>
            </div>
            <div class="panel-body">
            		<p>Select which transport information to show in profile word docs</p>
                <div id="transportListDivBookingView" style="padding-left:20px;">
                    
					
                                <input type="checkbox" class="read-more-state" id="extraTransport" />
                                <ul class="timeline timelineul read-more-wrap" style="margin-top: 0 !important; margin-left: -24px ;">
                                <?php	foreach($transport as $logK=>$log)
                                        {
                                                $college=clientDetail($log['college_id']);
                                            ?>
                                           
                                                <li class="timeline-grey <?php if($logK>2){?>read-more-target<?php } ?>" style="">
                                                    
                                                    <!--<div class="timeline-icon">
                                                    <input type="radio" name="bookingTransport" value="<?=$log['id']?>" <?php if($booking['transportInfo']==$log['id']){?>checked<?php }?>>
                                                    </div>-->
                                                   <div class="radio block">
                                                   <label>
                                                   <input type="radio" name="bookingTransport" value="<?=$log['id']?>" <?php if($booking['transportInfo']==$log['id']){?>checked<?php }?>>
                                                            <p  class="author notes-list-head" style="text-transform: capitalize;" ><?=$log['type']?></p>
                                                            <strong><p><?=$college['bname']?></p></strong>
                                                            <p class="date"><?=date('d M Y',strtotime($log['date']));?></p>
                                                   </label></div>
                                                   
                                             <!--  <div class="timeline-body">
                                                        <div class="timeline-header">
                                                            <span  class="author notes-list-head" style="text-transform: capitalize;" ><?=$log['type']?></span>
                                                            <strong><span><?=$college['bname']?></span></strong><br />
                                                            <span class="date"><?=date('d M Y',strtotime($log['date']));?></span>
                                                        </div>
                                                    </div>-->
                                                    
                                                </li>   
                                            
                            <?php } ?></ul>
                            <?php if(count($transport)>3){?>
                            <label for="extraTransport" class="read-more-trigger">See all</label><?php  }?>
                            
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
								
								$('input:radio[name="bookingTransport"]').change(function(){
										var transportVal=$(this).val();
										$.ajax({
											url:site_url+'booking/updateTransportInfo',
											type:'POST',
											data:{booking_id:<?=$booking['id']?>,transportInfo:transportVal},
											success:function(data){notiPop('success','Transport info selected successfully',"")}
										});
									});
                            });
                            </script>
                    
                    
                    
                </div>
            </div>
        </div> 
<?php } ?>