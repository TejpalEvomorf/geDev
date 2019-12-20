<div id="cgDocSentDiv">
    <div class="col-xs-12" style="padding-left:0;">
		<?php if($booking['cgDocSent']=='0000-00-00 00:00:00'){?>Are Caregiving service documents sent?<?php }else{
            $employee=employee_details($booking['cgDocSentBy']);
            ?>
            Caregiving service documents <b style="color:#81bb3e;">sent</b> by <i><?=$employee['fname'].' '.$employee['lname'];?></i> on <i><?=dateFormat($booking['cgDocSent'])?></i>
            <?php if($booking['cgDocRec']=='0000-00-00 00:00:00' && userAuthorisations('bookingCGDocSent_unsend')){?> <br /><a href="javascript:;" onclick="bookCGDocSentUnsend(<?=$booking['id']?>);">Mark as unsent</a><?php } ?>
        <?php } ?>
    </div>
    <div class="col-xs-4" style="padding-left:0; clear:both;padding-top: 20px ;">
	    <!--<button class="btn btn-<?php if($booking['cgDocSent']=='0000-00-00 00:00:00'){?>midnightblue<?php }else{?>success<?php } ?> btn-raised btn-sm" <?php if($booking['cgDocRec']=='0000-00-00 00:00:00'){?>data-toggle="modal" data-target="#model_bookingCGDocSent"<?php } ?>>Mark As Sent</button>-->
        <?php if($booking['cgDocSent']=='0000-00-00 00:00:00'){?>
        <button class="btn btn-midnightblue btn-raised btn-sm" data-toggle="modal" data-target="#model_bookingCGDocSent">Mark As Sent</button>
<?php } ?>   

    </div>
</div>
<div id="cgDocRecDiv" <?php if($booking['cgDocSent']=='0000-00-00 00:00:00'){?>style="display:none;"<?php } ?> style="border-top: 1px solid #f1f1f1;
float: left;
clear: both;
padding-top: 20px;
width: 100%;">
    <div class="col-xs-12" style="clear:both; padding-left:0;">
    	<?php if($booking['cgDocRec']=='0000-00-00 00:00:00'){?>Are Caregiving service documents received?<?php }else{
			//$cgDocList['cgDocList']=cgDocList($booking['id']);
			$employee=employee_details($booking['cgDocSentBy']);
			?>
	        Caregiving service documents <b style="color:#81bb3e;">received</b> by <i><?=$employee['fname'].' '.$employee['lname'];?></i> on <i><?=dateFormat($booking['cgDocRec'])?></i>
            <?php 
			//$this->load->view('system/booking/CGDocBoxDocs',$cgDocList);
			} ?>
    </div>
    <div class="col-xs-4" style="clear:both; padding-left:0;padding-top: 20px ;" >
	    <!--<button class="btn btn-<?php if($booking['cgDocRec']=='0000-00-00 00:00:00'){?>midnightblue<?php }else{?>success<?php } ?> btn-raised btn-sm" <?php if($booking['cgDocRec']=='0000-00-00 00:00:00'){?>data-toggle="modal" data-target="#model_bookingCGDocRec"<?php } ?>>Mark As Received</button>-->
       <?php if($booking['cgDocRec']=='0000-00-00 00:00:00'){?> 
        <button class="btn btn-midnightblue btn-raised btn-sm" data-toggle="modal" data-target="#model_bookingCGDocRec">Mark As Received</button>
        <?php } ?>
        
    </div>
    
    
</div>
       <?php if($booking['cgDocRec']!='0000-00-00 00:00:00'){
			$cgDocList['cgDocList']=cgDocList($booking['id']);
			$this->load->view('system/booking/CGDocBoxDocs',$cgDocList);
	}
			?>     

