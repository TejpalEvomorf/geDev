<!DOCTYPE html>

<html>

<head>

	<title>Student invoice</title>

</head>

<body>

<table style="width:100%; font-size:12px; font-family: Helvetica, sans-serif; ">

<tr>
		<td valign="top" style="width:42%">
        <table style="width:100%; font-size:12px; ">
        <tr>
        <td><img src="<?=static_url()?>system/img/ge-pdf-logo.png" width="173px" height="46px"></td>
        </tr>
        <tr>
        <td style="padding-top:20px;">PO Box Q680 SYDNEY NSW 1230<br> AUSTRALIA</td>
        </tr>
        </table>
        </td>

		<td valign="top" style="width:33%">
        <b>Invoice Date</b><br>
        <?=date('d M Y')?><br><br>
        <b>Invoice Number</b><br>
        <?='I-'.$id?><br><br>
        <b>ABN</b><br>
        32 088 449 512
        </td>

		<td valign="top" style="width:25%">
        <b>Student details</b><br>
        <?=$student['fname'].' '.$student['lname']?><br>
        <?=$student['email']?>        
        </td>

</tr>

</table>

<table border="0" cellspacing="0" cellpadding="0" style="width:100%; margin-top:50px; font-size:12px;  font-family: Helvetica, sans-serif; ">

	<tr>

		<th style="border-bottom:1px solid black; text-align:left; padding:5px 0;">Description</th>

		<th style="border-bottom:1px solid black; text-align:right; padding:5px 0;">Quantity</th>

		<th style="border-bottom:1px solid black; text-align:right; padding:5px 0;">Unit Price<br>Excl. GST</th>
        
        <th style="border-bottom:1px solid black; text-align:right; padding:5px 0;">GST</th>
        
        <th style="border-bottom:1px solid black; text-align:right; padding:5px 0;">Amount<br>Excl. GST AUD</th>

	</tr>

	<?php
	$grandtotal=0;
	$subtotal=0;
	$totalgst=0;
    foreach($items_standard as $items)
	{
		 if($items['gst']==1)
		 {
			 $unit_amount=add_decimal(getGstExclAmount($items['unit'],10));
			 $total_amount=add_decimal(getGstExclAmount($items['total'],10));
			 $gst=getGstAmount($items['total'],10);
			 $totalgst+=$gst;
		}
		 else
		 {
			 $unit_amount= add_decimal($items['unit']);
			 $total_amount=add_decimal($items['total'],10);
		 }
		 $subtotal+=$total_amount;
		 $grandtotal +=$items['total'];
	?>
    <tr>

		<td style="border-bottom:1px solid grey; text-align:left; padding:5px 0;"><?=$items['desc']?></td>

		<td style="border-bottom:1px solid grey; text-align:right;"><?=add_decimal($items['qty'])?></td>

		<td style="border-bottom:1px solid grey; text-align:right;"><?php  if($items['gst']==1){echo add_decimal(getGstExclAmount($items['unit'],10));}else{echo add_decimal($items['unit']);}?></td>
        
        <td style="border-bottom:1px solid grey; text-align:right;"><?php if($items['gst']==1){echo '10%';}else{echo 'GST Free';}?></td>
        
        <td style="border-bottom:1px solid grey; text-align:right;"><?php  if($items['gst']==1){echo add_decimal(getGstExclAmount($items['total'],10));}else{echo add_decimal($items['total']);}?></td>

	</tr>
    <?php } 
	?>
    	
    <tr>

		<td style=" "></td>

		<td style=""></td>

		<td style=""></td>
        
        <td style="text-align:right; padding:5px 0;">Subtotal</td>
        
        <td style="text-align:right;"><?=$subtotal?></td>

	</tr>
    
    <tr>

		<td style=" "></td>

		<td style=""></td>

		<td style=""></td>
        
        <td style="text-align:right; padding:5px 0;">Total GST Free</td>
        
        <td style=" text-align:right;">0.00</td>

	</tr>
    
     <tr>

		<td style=" "></td>

		<td style=""></td>

		<td style="border-bottom:1px solid black;"></td>
        
        <td style="border-bottom:1px solid black; text-align:right; padding:5px 0;">Total GST 10%</td>
        
        <td style="border-bottom:1px solid black; text-align:right;"><?=add_decimal($totalgst)?></td>

	</tr>
    
     <tr>

		<td style=" "></td>

		<td style=""></td>

		<td style=""></td>
        
        <td style="text-align:right; padding:5px 0;">Invoice Total AUD</td>
        
        <td style="text-align:right;"><?=add_decimal($grandtotal)?></td>

	</tr>
    
    <tr>

		<td style=" "></td>

		<td style=""></td>

		<td style="border-bottom:2px solid black;"></td>
        
        <td style="border-bottom:2px solid black; text-align:right; padding:5px 0;">Total Net Payments AUD</td>
        
        <td style="border-bottom:2px solid black; text-align:right;">0.00</td>

	</tr>

<tr>

		<td style=" "></td>

		<td style=""></td>

		<td style=""></td>
        
        <td style="text-align:right; padding:5px 0;"><b>Amount Due AUD</b></td>
        
        <td style="text-align:right;"><b><?=add_decimal($grandtotal)?></b></td>

	</tr>

</table>

<table style="width:100%; font-size:12px;  font-family: Helvetica, sans-serif; ">

    <tr>
        
        <td style="padding:5px 0 10px;"><b>Due Date: <?=date('d M Y', strtotime("+7 days"))?></b></td>

	</tr>
    
    <tr>
        
        <td style="">Bank Name: Westpac; Account Name: Global Experience; Branch Number (BSB): 032 324; Account Number: 192 180</td>

	</tr>

</table>


</body>

</html>