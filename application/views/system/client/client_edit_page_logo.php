<?php if($client['image']!=''){?>
<a href="<?=static_url()?>uploads/client/logo/<?=$client['image']?>">
<img src="<?=static_url()?>uploads/client/logo/<?=$client['image']?>" width="200"/>
</a>
<script type="text/javascript">

			$(document).ready(function()
			{
				//window.Code.PhotoSwipe.unsetActivateInstance(instance);
				$("#uploadClientLogoImage a").photoSwipe(
				{
					enableMouseWheel: false,
					enableKeyboard: false
				});
			});
		
</script>
<?php } ?>
