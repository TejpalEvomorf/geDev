<?php
$genderList=genderList();

$profilePicClass='';
$profilePic=static_url().'system/img/default-'.strtolower($genderList[$formOne['gender']]).'.jpg';
$hfaShaProfilePic=hfaShaProfilePic($formOne['id'],'sha');
if(empty($hfaShaProfilePic))
	$hfaShaProfilePic=hfaShaProfilePicLatest($formOne['id'],'sha');
else
	$profilePicClass='profilPicSet';	
if(!empty($hfaShaProfilePic))
	$profilePic=static_url().'uploads/sha/photos/thumbs/'.$hfaShaProfilePic['name'];
?>
<img class="media-object img-resposnive <?=$profilePicClass?>" src="<?=$profilePic?>" alt="Generic placeholder image" width='88' height='88'>