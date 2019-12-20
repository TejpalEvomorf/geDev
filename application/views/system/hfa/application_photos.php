 <!--wrwerwerwe-->
            <div class="col-md-3">
                        <div class="panel panel-profile panel-bluegraylight">
                            <div class="panel-heading">
                            <h2>UPLOAD FAMILY PHOTOS</h2>
                        </div>
			  	<div class="panel-body">
					<form action="<?=site_url()?>hfa/application_image_upload" id="hf-photos-form" class="dropzone">
                    	<input type="hidden" name="appId" value="<?=$formOne['id']?>" />
                    </form>
			  	</div>
			</div>
            
           <?php 
			   $hfaShaProfilePic=hfaShaProfilePic($formOne['id'],'hfa');
				if(!empty($hfaShaProfilePic))
					$selectBtnText="Change";
				else	
					$selectBtnText="Change";
			   ?> 
                    <div id="changeProfilePicDiv" <?php if(empty($photos)){?>style="display:none;"<?php } ?>>
                        <div class="panel panel-profile panel-bluegraylight">
                              <div class="panel-heading">
                                  <h2>FAMILY PROFILE PHOTO</h2>
                              </div>
                              <div class="panel-body">
                                  <button class="btn btn-primary btn-raised btn-sm" data-toggle="modal" data-target="#profilePicModel"  onclick="selectProfilePhotoPopContent(<?=$formOne['id']?>,'hfa');" id="selectProfilePhotoBtn"><?=$selectBtnText?> profile photo</button>
                              </div>
                        </div>
          			</div>
            
            </div>
                        <!--werwerwerw-->
<div class="col-md-9 panel-profile">
<div class="tab-pane p-md panel panel-default" data-widget='{"draggable": "false"}'>
				
<div class="panel-body profile-photos panel-body">
								
<?php $this->load->view('system/hfa/application_photos_list');?>

</div>
					

</div>
</div>


<!--Profile Pic Modle #STARTS-->
<?php $this->load->view('system/selectProfilePhotoPop');?>
<!--Profile Pic Modlw #ENDS-->

<link href="<?=static_url()?>system/js/photoswipe/photoswipe.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=static_url()?>system/js/photoswipe/klass.min.js"></script>
<script type="text/javascript" src="<?=static_url()?>system/js/photoswipe/code.photoswipe.jquery-3.0.4.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	
	Dropzone.options.hfPhotosForm = {
		maxFilesize: 20,
		acceptedFiles:'.jpeg,.jpg,.png,.JPG,.JPEG',
			init: function () {
			  this.on("complete", function (file) {
						  if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0)
						   {
							  setTimeout(function(){
								  $('.dz-preview').remove();
								  },1500);
							  refreshPhotos('<?=$formOne['id']?>');
						  }
				  });
		  }
	};
	
	});
	
function refreshPhotos(id)
{
	$.ajax({
			url:site_url+'hfa/appPagePhotosBoxRefresh',
			type:'POST',
			data:{id:id},
			success:function(data)
				{
					$('.profile-photos').html(data);
					$('#changeProfilePicDiv, #deleteAppPhotos').show();
					
					if(!$('#appProfilePic > img').hasClass('profilPicSet'))
					{
						if($('.profile-photos .col-md-3').length==1)
						{
							var srcProfilePic=$('.profile-photos .col-md-3:last > a >img').attr('src');
							$('#appProfilePic > img').attr('src',srcProfilePic);
						}
					}
				}
		});
}
</script>