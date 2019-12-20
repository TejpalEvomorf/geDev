<?php
$genderList=genderList();
$profilePicClass='';
$profilePic=static_url().'system/img/default-'.strtolower($genderList[$formOne['gender']]).'.jpg';
?>
<img class="media-object img-resposnive <?=$profilePicClass?>" src="<?=$profilePic?>" alt="Generic placeholder image" width='88' height='88'>