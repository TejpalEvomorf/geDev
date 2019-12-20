<p style="font-family: Arial, Helvetica, sans-serif; font-size:16px; color:#333333; line-height:24px;">Dear <?=$hostName?>,<p>
<p style="font-family: Arial, Helvetica, sans-serif; font-size:16px; color:#333333; line-height:24px;">Greetings from <b>Global experience</b>!</p>
<p style="font-family: Arial, Helvetica, sans-serif; font-size:16px; color:#333333; line-height:24px;">We are writing this email to remind you that your homestay host insurance is due to renew.</p>

<p style="font-family: Arial, Helvetica, sans-serif; font-size:16px; color:#333333; line-height:24px;"><b>Host Insurance Details</b>
<br>Host Name: <?=$hostName?>
<br>Insurance Provider: <?php if($insProvider!=''){echo $insProvider;}else{echo $notAvailableText;}?>
<br>Policy No: <?php if($policyNo!=''){echo $policyNo;}else{echo $notAvailableText;}?>
<br>Expiry Date: <?=$insExpiryDate?></p>

<p style="font-family: Arial, Helvetica, sans-serif; font-size:16px; margin-bottom:0; color:#333333; line-height:24px;">Please kindly forward the current public liability insurance details together with the certificate of insurance to <a href="mailto:receptionist@globalexperience.com.au">receptionist@globalexperience.com.au</a>.</p>
<p style="font-family: Arial, Helvetica, sans-serif; font-size:16px; color:#333333; line-height:24px;">If you have already renewed your insurance and sent those details to us, you may disregard this email.</p>
<p style="font-family: Arial, Helvetica, sans-serif; font-size:16px; color:#333333; margin-bottom:0; line-height:24px; width:25%;">Regards,<br>
Global Experience Team</p>

<a style="margin-top:10px;" href="http://globalexperience.com.au/"><img src="<?=static_url()?>img/email-signature.png" /></a>