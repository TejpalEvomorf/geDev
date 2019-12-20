<?php
if(isset($warning_documents)){
?>
      <div class="panel-heading">
          <h2>UPLOADED Documents </h2>
      </div>
      <div class="panel-body">
          <?php 
              foreach($warning_documents as $doc)
              {?>
                  <p style="float:left;width:100%;" id="hfaWarningDoc-<?=$doc['id']?>">
                  	<a href="<?=static_url().'uploads/hfaWarningDoc/'.$doc['name']?>" target="_blank"><?=getFileTypeIcon($doc['name']).' '.$doc['name']?></a>
                    &nbsp;&nbsp;
                    <a href="javascript:;" onClick="deleteHfaWarningDoc(<?=$doc['id']?>);">
                    	<i class="font16 material-icons">delete</i>
                     </a>
                  </p>
              <?php }?>
      </div>
<?php }?>