<?php 
$historyHeld=getBookingHoldPaymentInfo($booking['id'],'held');
$historyUnheld=getBookingHoldPaymentInfo($booking['id'],'unheld');
if($booking['hold_payment']=='0'){?>
<div class="panel-body">
      <button class="btn-raised btn-primary btn btn-sm" data-toggle="modal" data-target="#model_bookingHoldPos">Hold POs</button> 
</div>
<?php } else{?>
<div class="panel-body">
<?php
	$employee=employee_details($historyHeld['history']['employee']);
?>
  <div class="col-xs-12" style="padding-left:0;">
        Payment to host family <b class="colorOrange">held</b> by <i><?=$employee['fname'].' '.$employee['lname']?></i> on <i><?=dateFormat($historyHeld['history']['date'])?></i>
        <br><br>
        <b>Reason</b>:<br>
        <?php if($historyHeld['history']['reason']!=''){echo $historyHeld['history']['reason'];}else{echo 'No reason provided';}?>
  </div>
  <button class="btn-raised btn-primary btn btn-sm" onclick="bookingHoldPosUnhold(<?=$booking['id']?>,<?=$historyHeld['history']['id']?>);">Unhold POs</button> 
</div><?php } ?>

<?php $this->load->view('system/booking/holdPaymentHistory',$historyUnheld);?>