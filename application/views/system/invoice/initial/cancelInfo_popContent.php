<div class="list-group">
       <div class="list-group-item withripple">
        <div class="row-content">
            <h4 class="list-group-item-heading">Date</h4>
            <p class="list-group-item-text"><?=date('d M Y',strtotime($cancel_data['date_cancellation']))?></p>
        </div>
       </div>
       
       <div class="list-group-item withripple">
        <div class="row-content">
            <h4 class="list-group-item-heading">Reason</h4>
            <p class="list-group-item-text"><?=$cancel_data['reason']?></p>
        </div>
       </div>
       
       <div class="list-group-item withripple">
        <div class="row-content">
            <h4 class="list-group-item-heading">Total invoice amount</h4>
            <p class="list-group-item-text">$<?=$cancel_data['total_amount']?></p>
        </div>
       </div>
        
         <div class="list-group-item withripple">
        <div class="row-content">
            <h4 class="list-group-item-heading">Amount received</h4>
            <p class="list-group-item-text">$<?=$cancel_data['received']?></p>
        </div>
       </div>
       
       <?php
			  $due="due";
			  $refund="owed";
			  if($cancel_data['settle_type']=='0' || $cancel_data['settle_type']=='1')
				  $settle_type=$due;
			  else	
				  $settle_type=$refund;
		?>
        <div class="list-group-item withripple">
        <div class="row-content">
            <h4 class="list-group-item-heading">Amount <?=$settle_type?></h4>
            <p class="list-group-item-text"><?='$'.add_decimal($cancel_data['settle_amount'])?></p>
        </div>
       </div>
</div>