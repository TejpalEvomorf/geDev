<?php  
	$counter=$x=1;
	echo '<div class="row">';
	foreach($photos as $pK=>$pV){?>
    
		<?php if($x==1){?>
      				<!--<div class="row">-->
      	<?php } ?>
      
          
          <div class="col-md-3 mb-xl">
              <a href="<?=static_url()?>uploads/hfa/photos/<?=$pV['name']?>">
              <img src="<?=static_url()?>uploads/hfa/photos/thumbs/<?=$pV['name']?>" alt="" class="img-thumbnail img-responsive">
              </a>
              <button class="btn btn-primary btn-fab profile-del-img delAppPhotosIconSingle" id="delAppPhotosIconSingle-hfa-<?=$pV['id'].'-'.$pV['application_id']?>" style="display:none"><i class="fa fa-close"></i></button>
          </div>
         
      
          <?php if($x==4 || count($photos)==$counter){?>
     	 		<!--</div>--><!-- .row #ENDS-->
      	  <?php }?>
      
		<?php 
        if($x==4)
            $x=1;
        else	
            $x++;
        $counter++;
        } ?>
</div>
<?php if(empty($photos)){?>
<p>No photos have been uploaded yet.</p>
<?php } ?>

<?php if(!empty($photos)){?>
<script type="text/javascript">

			$(document).ready(function()
			{
				//window.Code.PhotoSwipe.unsetActivateInstance(instance);
				$(".profile-photos a").photoSwipe(
				{
					enableMouseWheel: false,
					enableKeyboard: false
				});
			});
		
</script>
<?php } ?>