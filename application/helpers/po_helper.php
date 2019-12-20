<?php
function po_structureNew($booking_id,$previousPo=0)
{
	$bookingDetails=bookingDetails($booking_id);
		//see($bookingDetails);
		
		//Accomodation type
		$accomodation_type=po_structure_accomodationType($bookingDetails);
		
		//Getting the duration of PO
		$po_from=$bookingDetails['booking_from'];
		if($previousPo!=0)
		{
			$po_from=date('Y-m-d',strtotime($previousPo['to'].' + 1 day'));
		}
		$po_to=date('Y-m-d',strtotime($po_from.' + 2 weeks -1 day'));
		
		//if booking duration is 3 weeks or less then First PO will have full booking duration
		if(dayDIff($bookingDetails['booking_from'],$bookingDetails['booking_to']) <= 21 && $bookingDetails['booking_to']!='0000-00-00')
			$po_to=$bookingDetails['booking_to'];
		
		$po_endDate=$bookingDetails['moveout_date'];
		if($po_endDate=='0000-00-00')
			$po_endDate=$bookingDetails['booking_to'];
		if(strtotime($po_to) > strtotime($po_endDate) && $po_endDate!='0000-00-00')
			$po_to=$po_endDate;
		
		if(strtotime($po_from) >= strtotime($po_to))//in case if booking end date ahs arrived and we cannot create next PO
			return array();	
		
		$po_structure=po_structure2ndPartNew($po_from,$po_to,$accomodation_type,$bookingDetails,$previousPo);
		return $po_structure;
}

function po_structure2ndPartNew($po_from,$po_to,$accomodation_type,$bookingDetails,$previousPo)
{	//echo 'From= '.$po_from.', To= '.$po_to.'<br>';
	$ongoingInvoiceItemCreater=ongoingInvoiceItemCreater($po_from,$po_to);
	//see($ongoingInvoiceItemCreater);
		
	$student=getshaOneAppDetails($bookingDetails['student']);
	$studentNo='';
	if(trim($student['sha_student_no'])!='')
		$studentNo=' - '.$student['sha_student_no'];
	$bookingInfoForItems=$bookingDetails['id'].', '.$student['fname'].' '.$student['lname'].$studentNo.', ';

	$item=array();
	$po_structure=array();
	$po_structure['booking_id']=$bookingDetails['id'];
	$po_structure['po_from']=$po_from;
	$po_structure['po_to']=$po_to;
	
	$po_structure['initial']='1';
	if($previousPo!=0)
		$po_structure['initial']='0';
	
	$adminFeeInitialDate=date('Y-m-d',strtotime($bookingDetails['booking_from'].' + 14 days'));//echo $adminFeeInitialDate;echo ',  '.$bookingDetails['booking_from'];
	
		foreach($ongoingInvoiceItemCreater as $ong)
		{
				//$products=productsList($ong['price_year']);
				$products=clientProductsList($student['client'],$ong['price_year']);
				
				foreach($products as $p)
					{
						if($p['name']==$accomodation_type)
						{
							if($ong['weeks']!=0)
							{
								$item['desc']=$bookingInfoForItems.$p['name'].' ('.date('d M Y',strtotime($ong['from'])).' to '.date('d M Y',strtotime($ong['from'] .' + '.$ong['weeks'].' weeks -1 day')).')';
								$item['qty_unit']='1';
								$item['qty']=$ong['weeks'];
								$item['unit']=$p['cost'];
								$item['total']=add_decimal($p['cost']*$item['qty']);
								//$item['gst']=$p['gst'];
								//$item['xero_code']=$p['xero_code'];
								$item['xero_code']='52100';
								$item['type']='accomodation';
								$items[]=$item;
							}
							
							if($ong['days']!=0)
							{
								$item['desc']=$bookingInfoForItems.$p['name'].' ('.date('d M Y',strtotime($ong['to'].' - '.$ong['days'].' days + 1 day')).' to '.date('d M Y',strtotime($ong['to'])).')';
								$item['qty_unit']='2';
								$item['qty']=$ong['days'];
								$item['unit']=add_decimal($p['cost']/7);
								$item['total']=add_decimal(($p['cost']/7)*$item['qty']);
								//$item['gst']=$p['gst'];
								//$item['xero_code']=$p['xero_code'];
								$item['xero_code']='52100';
								$item['type']='accomodation_ed';
								$items[]=$item;
							}
							
							break;
						}
						else
						continue;
					}
		}
		
		///////Administration fee #STARTS
		
		$accomodationAmount=0;
		$itemAdminFee=array();
		foreach($items as $it)
		{
			if($it['type']=='accomodation' || $it['type']=='accomodation_ed')
			$accomodationAmount +=$it['total'];
		}
		
		if($accomodationAmount>0)
		{
			$itemAdminFee['qty']=1;
			$itemAdminFee['desc']=$bookingInfoForItems.'Administration Fee';
			$itemAdminFee['type']='adminFee';
			$itemAdminFee['xero_code']='52100';
			
			if(strtotime($po_from)<=strtotime($adminFeeInitialDate))
			{
				$percent=8.5;	
				$itemAdminFee['desc'] .=' ('.$percent.'% on Accomodation fee)';
				$itemAdminFee['qty_unit']='3';//percent
				$itemAdminFee['unit']=$percent;
				$itemAdminFee['total']=$itemAdminFee['unit'];
			}
			else
			{
				$itemAdminFee['qty']=dayDiff($po_from,$po_to);
				$itemAdminFee['desc'] .=' ($2 per day)';
				$itemAdminFee['qty_unit']='4';//days
				$itemAdminFee['unit']=2;
				$itemAdminFee['total']=$itemAdminFee['unit']*$itemAdminFee['qty'];
			}
			$items[]=$itemAdminFee;
		}
		///////Administration fee #ENDS
		
		$po_structure['items']=$items;
		return $po_structure;
}
?>