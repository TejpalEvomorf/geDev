<?php
$gstPercent=gstPercent();

$placementFee=0;
$accomodationFee=0;
$apuFee=0;
foreach($invoiceItems as $iItem)
{
	if($iItem['type']=='placement')
		$placementFee +=$iItem['total'];
	if($iItem['type']=='accomodation' || $iItem['type']=='accomodation_ed')
		$accomodationFee +=$iItem['total'];
	if($iItem['type']=='apu' || $iItem['type']=='accomodation_ed')
		$apuFee +=$iItem['total'];
}

$placementFeeExclAmount=getGstExclAmount($placementFee,$gstPercent);
$placementFeeGstAmount=getGstAmount($placementFee,$gstPercent);
$accomodationFeeExclAmount=getGstExclAmount($accomodationFee,$gstPercent);
$accomodationFeeGstAmount=getGstAmount($accomodationFee,$gstPercent);
$apuFeeExclAmount=getGstExclAmount($apuFee,$gstPercent);
$apuFeeGstAmount=getGstAmount($apuFee,$gstPercent);

$amoutGstExclTotal=$placementFeeExclAmount+$accomodationFeeExclAmount+$apuFeeExclAmount;
$amoutGstTotal=$placementFeeGstAmount+$accomodationFeeGstAmount+$apuFeeGstAmount;
$amoutTotal=$placementFee+$accomodationFee+$apuFee;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	<title>Visit Report:</title>
	<link rel='stylesheet' type='text/css' href='<?=static_url()?>system/css/print-style.css' />
    <link rel='stylesheet' type='text/css' href='<?=static_url()?>system/css/ge-system.css' />
	<link rel='stylesheet' type='text/css' href='<?=static_url()?>system/css/media-print.css' media="print" />
     <link type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,400,400italic,500' rel='stylesheet'>


    
    <link href="https://www.gediculture.com/ge/theme/assets/css/styles.css" type="text/css" rel="stylesheet">                                     <!-- Core CSS with all styles -->



</head>

<body>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-transparent">
            <div class="panel-body">
                <div class="row mb-xl">
                    <div class="col-md-12">
                        
                        <div class="pull-left">   
                            <h3 class="text-muted1">Client details</h3>                         
                            <address>
                                <strong><?=$client['bname']?></strong><br>
                                <?=$client['primary_contact_name'].' '.$client['primary_contact_lname']?><br>
                                <?=$client['primary_email'].', '.$client['primary_phone']?><br><br>
                                <strong>Date of issue:</strong> <?=dateFormat(date('Y-m-d'))?>
                            </address>
                        </div>
                    </div>
                </div>
                <div class="row mb-xl">
                    <div class="col-md-12">  
                            <h3 class="text-muted1">Tax invoice</h3>
                        <div class="panel">
                            <div class="panel-body no-padding">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered m-n" border="1">
                                        <thead>
                                            <tr>
                                                <th>Description</th>
                                                <th class="text-right">Subtotal</th>
                                                <th class="text-right">Tax</th>
                                                <th class="text-right">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Placement fee</td>
                                                <td class="text-right">$<?=add_decimal($placementFeeExclAmount)?></td>
                                                <td class="text-right">$<?=add_decimal($placementFeeGstAmount)?></td>
                                                <td class="text-right">$<?=add_decimal($placementFee)?></td>
                                            </tr>
                                            <tr>
                                                <td>Homestay service fee</td>
                                                <td class="text-right">$<?=add_decimal($accomodationFeeExclAmount)?></td>
                                                <td class="text-right">$<?=add_decimal($accomodationFeeGstAmount)?></td>
                                                <td class="text-right">$<?=add_decimal($accomodationFee)?></td>
                                            </tr>
                                            <tr>
                                                <td>Airport pickup service</td>
                                                <td class="text-right">$<?=add_decimal($apuFeeExclAmount)?></td>
                                                <td class="text-right">$<?=add_decimal($apuFeeGstAmount)?></td>
                                                <td class="text-right">$<?=add_decimal($apuFee)?></td>
                                            </tr>
                                            <tr>
                                                <th>Subtotal</th>
                                                <th class="text-right">$<?=add_decimal($amoutGstExclTotal)?></th>
                                                <th class="text-right">$<?=add_decimal($amoutGstTotal)?></th>
                                                <th class="text-right">$<?=add_decimal($amoutTotal)?></th>
                                            </tr>
                                         </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
                <div class="row mb-xl">
                    <div class="col-md-12">
                            <h3 class="text-muted1">Guests</h3>
                        <div class="panel">
                            <div class="panel-body no-padding">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered m-n" border="1">
                                        <thead>
                                            <tr>
                                                <th>Invoice number</th>
                                                <th>Item description</th>
                                                <th class="text-right">Amount</th>
                                                <th class="text-right">Tax</th>
                                                <th class="text-right">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
											$amountTotal=$amountGstExclTotal=$amountGstTotal=0;
											foreach($invoiceItems as $item){
											$gstExclAmount=getGstExclAmount($item['total'],$gstPercent);
											$gstAmount=getGstAmount($item['total'],$gstPercent);
											
											$amountTotal +=$item['total'];
											$amountGstExclTotal +=$gstExclAmount;
											$amountGstTotal +=$gstAmount;
											?>
                                            <tr>
                                                <td><?='I-'.$item['invoice_id']?></td>
                                                <td><?=$item['desc']?></td>
                                                <td class="text-right">$<?=add_decimal($gstExclAmount)?></td>
                                                <td class="text-right">$<?=add_decimal($gstAmount)?></td>
                                                <td class="text-right"><?=$item['total']?></td>
                                            </tr>
                                        <?php } ?>
                                            <tr>
                                                <th>Total</th>
                                                <th></th>
                                                <th class="text-right">$<?=add_decimal($amountGstExclTotal)?></th>
                                                <th class="text-right">$<?=add_decimal($amountGstTotal)?></th>
                                                <th class="text-right">$<?=add_decimal($amountTotal)?></th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
            
             </div>
		</div>
	</div>
</div>
	
</body>

</html>