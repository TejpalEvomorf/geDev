<?php
if(!empty($client)){
?>
      <div class="panel-heading">
          <h2>UPLOADED Document </h2>
      </div>
      <div class="panel-body">
          <?php 
              foreach($client as $agree)
              {?>
                  <p style="float:left;" id="clientAgreement-<?=$agree['id']?>">
                  	<a href="<?=static_url().'uploads/shadocument/'.$agree['name']?>" target="_blank"><?=getFileTypeIcon($agree['name']).' '.$agree['name']?></a>
                    &nbsp;&nbsp;
                    <a href="javascript:;" onclick="deleteClientAgreement(<?=$agree['id']?>,'shadocument');">
                    	<i class="font16 material-icons">delete</i>
                     </a>
                  </p>
              <?php }?>
      </div>
<?php }?>