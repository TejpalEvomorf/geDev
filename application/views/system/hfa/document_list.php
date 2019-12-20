<?php
if(isset($client['agreement'])){
?>
      <div class="panel-heading">
          <h2>UPLOADED Document </h2>
      </div>
      <div class="panel-body">
          <?php 
              foreach($client['agreement'] as $agree)
              {?>
                  <p style="float:left;" id="clientAgreement-<?=$agree['id']?>">
                  	<a href="<?=static_url().'uploads/hfadocument/'.$agree['name']?>" target="_blank"><?=getFileTypeIcon($agree['name']).' '.$agree['name']?></a>
                    &nbsp;&nbsp;
                    <a href="javascript:;" onclick="deleteClientAgreement(<?=$agree['id']?>,'hfadocument');">
                    	<i class="font16 material-icons">delete</i>
                     </a>
                  </p>
              <?php }?>
      </div>
<?php }?>