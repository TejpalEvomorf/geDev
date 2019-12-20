<div id="CGDocBoxDocs" class=" col-xs-12" style="padding-left:0; padding-right:0;">
<?php if(!empty($cgDocList)){?>
<div id="CGDocBoxDocsDiv" class=""   style="padding-top: 25px; border-top: 1px solid #f1f1f1;margin-bottom: 0px;visibility: visible;opacity: 1;display: block;transform: translateY(0px);">
  <!-- <div class="panel-heading">
        <h2>Received Documents </h2>
    </div>-->
   <!-- <div class="panel-body">-->
        <?php 
            foreach($cgDocList as $doc)
            {?>
                <p style="float:left;width:100%;" id="bookingCGDoc-<?=$doc['id']?>">
                  <a href="<?=static_url().'uploads/bookingCGDoc/'.$doc['name']?>" target="_blank"><?=getFileTypeIcon($doc['name']).' '.$doc['name']?></a>
                  &nbsp;&nbsp;
                  <a href="javascript:;" onclick="deleteBookingCGDoc(<?=$doc['id']?>,<?=$doc['booking_id']?>);">
                      <i class="font16 material-icons">delete</i>
                   </a>
                </p>
            <?php }?>
<!--    </div>-->
    </div>
<?php } ?>                  
</div>