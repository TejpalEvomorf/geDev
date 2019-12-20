<?php
if(isset($incident_documents)){
?>
      <div class="panel-heading">
          <h2>UPLOADED Documents </h2>
      </div>
      <div class="panel-body">
          <?php 
              foreach($incident_documents as $doc)
              {?>
                  <p style="float:left;width:100%;" id="bookingIncidentDoc-<?=$doc['id']?>">
                  	<a href="<?=static_url().'uploads/bookingIncidentDoc/'.$doc['name']?>" target="_blank"><?=getFileTypeIcon($doc['name']).' '.$doc['name']?></a>
                    &nbsp;&nbsp;
                    <a href="javascript:;" onclick="deleteBookingIncidentDoc(<?=$doc['id']?>);">
                    	<i class="font16 material-icons">delete</i>
                     </a>
                  </p>
              <?php }?>
      </div>
<?php }?>