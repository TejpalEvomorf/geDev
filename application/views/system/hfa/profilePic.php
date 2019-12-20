<?php
$profilePicClass='';
$profilePic=static_url().'system/img/default-family.jpg';
$hfaShaProfilePic=hfaShaProfilePic($formOne['id'],'hfa');
if(empty($hfaShaProfilePic))
	$hfaShaProfilePic=hfaShaProfilePicLatest($formOne['id'],'hfa');
else
	$profilePicClass='profilPicSet';	
if(!empty($hfaShaProfilePic))
	$profilePic=static_url().'uploads/hfa/photos/thumbs/'.$hfaShaProfilePic['name'];
?>
<img class="media-object img-resposnive <?=$profilePicClass?>" src="<?=$profilePic?>" alt="Generic placeholder image" width='88' height='88'>