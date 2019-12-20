<?php

if(isset($not['agreement'])){
?>
      <div class="panel-heading">
          <h2>UPLOADED Document </h2>
      </div>
      <div class="panel-body">
          <?php 
              foreach($not['agreement'] as $agree)
              {?>
                  <p style="float:left;" id="clientfamlAgreements-<?=$agree['id']?>">
                  	<a href="<?=static_url().'uploads/shanotedocument/'.$agree['name']?>" target="_blank"><?=getFileTypeIcon($agree['name']).' '.$agree['name']?></a>
                    &nbsp;&nbsp;
                    <a href="javascript:;" onclick="deletenotedocument(<?=$agree['id']?>,<?= $agree['sha_id'] ?>);">
                    	<i class="font16 material-icons">delete</i>
                     </a>
                  </p>
              <?php }?>
      </div>
<?php }?>