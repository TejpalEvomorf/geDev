<?php if(!empty($docsTemp)){?>
<div id="CGDocBoxTempDocsDiv" class="panel panel-profile panel-bluegraylight"   style="margin-top: 32px;margin-bottom: 0px;visibility: visible;opacity: 1;display: block;transform: translateY(0px);">
<div class="panel-heading">
    <h2>UPLOADED Document </h2>
</div>
<div class="panel-body">
    <?php 
        foreach($docsTemp['docs'] as $doc)
        {?>
            <p style="float:left;width:100%;" class="bookingCGDocTemp">
              <a href="<?=static_url().'uploads/bookingCGDoc/unsaved/'.$doc?>" target="_blank"><?=getFileTypeIcon($doc).' '.$doc?></a>
              &nbsp;&nbsp;
              <a href="javascript:;" onclick="deleteBookingCGDocTemp('<?=$doc?>');$(this).parents('p.bookingCGDocTemp').remove();">
                  <i class="font16 material-icons">delete</i>
               </a>
            </p>
        <?php }?>
</div>
</div>
<?php } ?>            