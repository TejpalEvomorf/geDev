<?php 
if($formOne['client']!='0')
{
	$clientDetail=clientDetail($formOne['client']);
	
	$stringAddressClient='';
	if(trim($clientDetail['suburb'])!='')
	  $stringAddressClient .=trim($clientDetail['suburb']);
	if(trim($clientDetail['state'])!='')
	{
	  if($stringAddressClient!='')
		  $stringAddressClient .='*';
	  $stringAddressClient .=trim($clientDetail['state']);
	}
	if(trim($clientDetail['postal_code'])!='' && $clientDetail['postal_code']!='0')
	{
	  if($stringAddressClient!='')
		  $stringAddressClient .='*';
	  $stringAddressClient .=trim($clientDetail['postal_code']);
	}
	$addressForMapClient='';
	$addressForMapClient .= $clientDetail['street_address'];
	if($clientDetail['street_address']!='' && $stringAddressClient!='')
	  $addressForMapClient.=',';
	$addressForMapClient.=str_replace('*',', ',$stringAddressClient);
	$addressForMapClientLink=getMapLocationLink($addressForMapClient);
	
	$clientGroupList=clientGroupList();
	?>
    <!--<label class="control-label" style="margin-bottom: 10px;">Client details</label>
	<div class="family-details-all tab-pane panel panel-bluegraylight"  data-widget='{"draggable": "false"}' style="visibility: visible;margin-bottom:0;">
			 <div class="about-area panel-body">-->
					<div class="table-responsive">
						
						<table class="table about-table" style="margin:0 !important;">
							<tbody>
								<tr>
									<td><b>Client Group</b> :
										  <?php 
											  if($clientDetail['client_group']!='')
											  	echo $clientGroupList[$clientDetail['client_group']];
											  else
											    echo "Not available";
										  ?>
									</td>
								</tr>
								<tr>
									<td><b>Primary Contact Name</b> :
									  <?=$clientDetail['primary_contact_name'].' '.$clientDetail['primary_contact_lname']?>
									</td>
								</tr>
								<tr>
									<td><b>Primary contact phone</b> :
										  <?=$clientDetail['primary_phone']?>
									</td>
								</tr>
								<tr>
									<td><b>Primary contact email</b> :
										<a href="mailto:<?=$clientDetail['primary_email']?>" class="mailto"><?=$clientDetail['primary_email']?></a>
									</td>
								</tr>
								<tr>
									<td><b>Address</b> :
										  <?=$addressForMapClientLink?>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				<!--</div>
	</div>-->
<?php } ?>