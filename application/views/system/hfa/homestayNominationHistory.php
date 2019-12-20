<?php if(!empty($nominationHistory)){?>

	<div class="widget referral-info-widget infobar nominatedgamily" style="margin-top:0;">
  <div class="widget-heading" style="padding-left:0;">Homestay nomination HISTORY</div>
  <div class="widget-body" style="border-bottom:0px;">
    <input type="checkbox" class="read-more-state" id="extraNominationHistoryHfa" /> 
  <ul class="timeline read-more-wrap" style="margin-top: 0 !important; margin-left: -24px ;" id="nominationHistoryHfa">
  <?php   foreach($nominationHistory as $nHK=>$nH): 
					  $bookingDuration='Booking: '.date('d M Y',strtotime($nH['booking_from']));
					  if($nH['booking_to']!='0000-00-00')
						 $bookingDuration .=' - '.date('d M Y',strtotime($nH['booking_to'].' +1 day'));
					  else	
						  $bookingDuration .=' - Not set';
					  $nHStudent=getshaOneAppDetails($nH['student']);
  ?>
  
						 <li style="padding-bottom: 0;" class="timeline-grey <?php if($nHK>2){?>read-more-target<?php } ?>">
						    <div class="timeline-icon"><i class="material-icons">alarm</i></div>
						    <div class="timeline-body">
									<div class="timeline-header">
									<a class="vHBookingDurationHfa" href="<?=site_url()?>booking/view/<?=$nH['id']?>" target="_blank"><span class="notes-list-head author"><?=$bookingDuration?></span></a>
									<a class="vHStudentNameHfa" href="<?=site_url()?>sha/application/<?=$nH['student']?>" target="_blank"><span class="date">Nominated by <?=$nHStudent['fname'].' '.$nHStudent['lname']?></span></a>
									</div>
							</div>
						</li>
  
  <?php endforeach; ?>	
  </ul>
  <?php if(count($nominationHistory)>3){?><label for="extraNominationHistoryHfa" class="read-more-trigger">See all</label><?php  }?>
  </div>
</div>
	<script type="text/javascript">
    $(document).ready(function(){
        $("label[for='extraNominationHistoryHfa']").click(function(){
            setTimeout(function(){
            
            if($(".read-more-state").is(':checked'))
                $("label[for='extraNominationHistoryHfa']").text('See less');
            else
                $("label[for='extraNominationHistoryHfa']").text('See all');
                
                },500);
            
        });
    });
    </script>
<?php } ?>