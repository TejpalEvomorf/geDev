<?php
if(isset($client['agreement'])){
?>
      <div class="panel-heading">
          <h2>UPLOADED AGREEMENTS</h2>
      </div>
      <div class="panel-body">
          <?php 
              foreach($client['agreement'] as $agree)
              {?>
                  <p style="float:left;" id="clientAgreement-<?=$agree['id']?>">
                  	<a href="<?=static_url().'uploads/client/'.$agree['name']?>" target="_blank"><?=getFileTypeIcon($agree['name']).' '.$agree['name']?></a>
                    &nbsp;&nbsp;
                    <a href="javascript:;" onclick="deleteClientAgreement(<?=$agree['id']?>);">
                    	<i class="font16 material-icons">delete</i>
                     </a>
                  </p>
              <?php }?>
      </div>
<?php }?>