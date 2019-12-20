<style type="text/css">
.photoCandidate
{
	cursor:pointer;
}
.profilePicClass
{
	background:hsl(88, 50%, 53%) !important;
}

</style>
<?php
	$hfaShaProfilePic=hfaShaProfilePic($id,$hfaSha);
	
	$profilePicClass="profilePicClass";
	$counter=$x=1;
	foreach($photos as $pK=>$pV){?>
    
		<?php if($x==1){?>
      				<div class="row">
      	<?php } ?>
      
          <div class="col-md-3">
              <input type="radio" name="profilePic" class="selectProfilePicRadio" id="selectProfilePicRadio-<?=$pV['id']?>" value="<?=$pV['id']?>" style="display:none;">
                  <a href="javascript:void(0);">
                      <label for="selectProfilePicRadio-<?=$pV['id']?>">
                          <img src="<?=static_url()?>uploads/<?=$hfaSha?>/photos/thumbs/<?=$pV['name']?>" alt="" class="img-thumbnail img-responsive mb-xl photoCandidate <?php if(!empty($hfaShaProfilePic) && $hfaShaProfilePic['id']==$pV['id']){echo $profilePicClass;}?>" id="photoCandidate-<?=$pV['id']?>">
                      </label>
                  </a>
           </div>
         
          <?php if($x==4 || count($photos)==$counter){?>
     	 		</div><!-- .row #ENDS-->
      	  <?php }?>
      
		<?php 
        if($x==4)
            $x=1;
        else	
            $x++;
        $counter++;
        } ?>
        
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="hfaSha" value="<?=$hfaSha?>">

<?php if(empty($photos)){?>
<p>No photos uploaded yet.</p>
<?php } ?>


<script type="text/javascript">
$(document).ready(function(){
	
	$('.selectProfilePicRadio').click(function(){
				var id=$(this).attr('id');
				var idArray=id.split('-');
				$('.photoCandidate').removeClass('<?=$profilePicClass?>');
				$('#photoCandidate-'+idArray[1]).addClass('<?=$profilePicClass?>');
		});
		
	});
</script>