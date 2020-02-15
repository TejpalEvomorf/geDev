<?php
class Bmargin_model extends CI_Model {
	
	function bmInInv($booking)
	{
		$shaInitialInvoiceWeekDays=shaInitialInvoiceWeekDays($booking['student']);
		$OngoingInvoiceDate=date('Y-m-d',strtotime($booking['booking_from'].' + '.$shaInitialInvoiceWeekDays.' days'));
		$initialInvTo=date('Y-m-d',strtotime($OngoingInvoiceDate.' - 1 days'));
		
		$lastInvoice=initialInvoiceByShaId($booking['student']);
		$lastInvoice['booking_from']=$booking['booking_from'];
		$lastInvoice['booking_to']=$initialInvTo;
		return $lastInvoice;
	}
	
	function ongInvBetDates($from,$to,$appId=0)
	{
		$sql="select * from `invoice_ongoing` where";
		$sql .="`application_id`='".$appId."' and ";
		
		$sql .="(";
		$sql .="(`booking_from`>='".$from."' and `booking_from`<='".$to."')";//F BF T
		$sql .=" OR (`booking_to`>='".$from."' and `booking_to`<='".$to."')";//F BT T
		$sql .=" OR (`booking_from`<='".$from."' and  `booking_to`>='".$to."')";//BF F T BT
		$sql .=")";
		return $this->db->query($sql)->result_array();
	}
	
	function bm4()
	{
		$outputHtml='';
		$bid=$_POST['marginBookingId'];
		$from=normalToMysqlDate($_POST['marginFrom']);
		$to=normalToMysqlDate($_POST['marginTo']);
		
		$booking=bookingDetails($bid);//see($booking);
		//$from=$booking['booking_from'];
		//$to=date('Y-m-d',strtotime($booking['booking_from'].' + 10 days'));
		
		$appId=$booking['student'];
		
		if(strtotime($booking['booking_from']) > strtotime($from))
			$from=$booking['booking_from'];
		
		//if()	
		
		//$from=$booking['booking_from'];
		//$from=date('Y-m-d',strtotime($booking['booking_from'].' + 1 day'));
		//$to=date('Y-m-d',strtotime($booking['booking_from'].' + 10 days'));
		
		//1695
		/*$from='2018-09-16';
		$to='2018-09-18';*/
		
		//1152
		//$from='2018-09-15';
		//$to='2018-09-25';
		
		//2168
		//$from='2018-10-27';
		//$to='2018-11-05';
		
		//2833
		/*$from='2019-04-06';
		$to='2019-04-15';*/
		/*$from='2019-03-06';
		$to='2019-03-15';*/
		
		
		//$to=date('Y-m-d',strtotime($to.' - 1 day'));
		$dayDiff=dayDiff($from,$to);
		
		$outputHtml .=$from.' '.$to.', days='.$dayDiff.'<br>';
		
		//$initialInv=$this->initialInvBetDates($from,$to,$appId);
		$initialInv=array();
		$InitialInvoice=$this->bmInInv($booking);
		if(strtotime($InitialInvoice['booking_from']) <= strtotime($from) && strtotime($InitialInvoice['booking_to']) >= strtotime($from))
			$initialInv[]=$InitialInvoice;
		//see($initialInv);
		
		$accFeeInInv=0;
		$placementFeeInInv=0;
		$apuFeeInInv=0;
		$caregivingFeeInInv=0;
		$nominationFeeInInv=0;
		$ottFeeInInv=0;
		$ccsFeeInInv=0;
		$customFeeInInv=0;
		
		$placementFeeInInvPaid=$apuFeeInInvPaid=$caregivingFeeInInvPaid=$nominationFeeInInvPaid=$ottFeeInInvPaid=$ccsFeeInInvPaid=$customFeeInInvPaid=$accFeeTotalInInvPaid=0;
		
		foreach($initialInv as $inInv)
		{
			$accFeeTotalInInv=0;
			if($from<$inInv['booking_from'])
				$fromInInv=$inInv['booking_from'];
			else
				$fromInInv=$from;
			
			if($to>$inInv['booking_to'])
				$toInInv=$inInv['booking_to'];
			else
				$toInInv=$to;
				
			$dayDiffInInv=dayDiff($fromInInv,$toInInv);//echo '<br>Initial inv duration= '.$dayDiffInInv.'<br>';
			
			$inInvD=initialInvoiceDetails($inInv['id']);
			//see($inInvD);
			
			foreach($inInvD['items'] as $inInvItem)
			{
				if($inInvItem['type']=='accomodation' || $inInvItem['type']=='accomodation_ed')
					$accFeeTotalInInv +=$inInvItem['total'];
				elseif($inInvItem['type']=='placement')
				{
					if($fromInInv == $inInv['booking_from'])
						$placementFeeInInv +=$inInvItem['total'];
				}
				elseif($inInvItem['type']=='apu')
				{
					if($fromInInv == $inInv['booking_from'])
						$apuFeeInInv +=$inInvItem['total'];
				}
				elseif($inInvItem['type']=='guardianship')
				{//
				
					if($booking['booking_to']!='0000-00-00')
						$gaurdiansipDuration=dayDiff($booking['booking_from'],$booking['booking_to']);
					else	
						$gaurdiansipDuration=$inInvItem['qty']*7;
					$guardianshipPerDay=$inInvItem['total']/$gaurdiansipDuration;
					$caregivingFeeInInv +=$guardianshipPerDay*$dayDiffInInv;
				}
				elseif($inInvItem['type']=='nomination')
				{
					if($fromInInv == $inInv['booking_from'])
						$nominationFeeInInv +=$inInvItem['total'];
				}
				elseif($inInvItem['type']=='ott')
				{
					if($fromInInv == $inInv['booking_from'])
						$ottFeeInInv +=$inInvItem['total'];
				}
				elseif($inInvItem['type']=='ccs')
				{
					if($fromInInv == $inInv['booking_from'])
						$ccsFeeInInv +=$inInvItem['total'];
				}
				elseif($inInvItem['type']=='custom' || $inInvItem['type']=='')
				{//
					if($fromInInv == $inInv['booking_from'])
						$customFeeInInv +=$inInvItem['total'];
				}
			}
			
			
			////
			$inInvDuration=dayDiff($inInv['booking_from'],$inInv['booking_to']);
			$accFeeInInv +=($accFeeTotalInInv/$inInvDuration)*$dayDiffInInv;
			////
		}
		
		//Payment Initial invoice #STARTS
			if(!empty($initialInv))
			{
				if($inInv['status']=='3')
				{
					$placementFeeInInvPaid=$placementFeeInInv;
					$apuFeeInInvPaid=$apuFeeInInv;
					$caregivingFeeInInvPaid=$caregivingFeeInInv;
					$nominationFeeInInvPaid=$nominationFeeInInv;
					$ottFeeInInvPaid=$ottFeeInInv;
					$ccsFeeInInvPaid=$ccsFeeInInv;
					if($customFeeInInv > 0)//if not negative
						$customFeeInInvPaid=$customFeeInInv;
					$accFeeTotalInInvPaid=$accFeeInInv;
				}
				elseif($inInv['status']=='2')
				{
					$inInvAmountPaid=0;
					foreach($initialInv as $inInv)
					{
						$inInvDetails=initialInvoiceDetails($inInv['id']);
						foreach($inInvDetails['payments'] as $inInvDetailsPayments)
							$inInvAmountPaid +=$inInvDetailsPayments['amount_paid'];
					}//echo '$inInvAmountPaid= '.$inInvAmountPaid;
					
					//placement fee
					if($inInvAmountPaid!=0)
					{
						if($inInvAmountPaid >= $placementFeeInInv)
							$placementFeeInInvPaid=$placementFeeInInv;
						else
							$placementFeeInInvPaid=$inInvAmountPaid;
						$inInvAmountPaid -=$placementFeeInInvPaid;
					}
					//APU fee
					if($inInvAmountPaid!=0)
					{
						if($inInvAmountPaid >= $apuFeeInInv)
							$apuFeeInInvPaid=$apuFeeInInv;
						else
							$apuFeeInInvPaid=$inInvAmountPaid;
						$inInvAmountPaid -=$apuFeeInInvPaid;
					}
					//caregiving fee
					if($inInvAmountPaid!=0)
					{
						if($inInvAmountPaid >= $caregivingFeeInInv)
							$caregivingFeeInInvPaid=$caregivingFeeInInv;
						else
							$caregivingFeeInInvPaid=$inInvAmountPaid;
						$inInvAmountPaid -=$caregivingFeeInInvPaid;
					}
					//nomination fee
					if($inInvAmountPaid!=0)
					{
						if($inInvAmountPaid >= $nominationFeeInInv)
							$nominationFeeInInvPaid=$nominationFeeInInv;
						else
							$nominationFeeInInvPaid=$inInvAmountPaid;
						$inInvAmountPaid -=$nominationFeeInInvPaid;
					}
					//ott fee
					if($inInvAmountPaid!=0)
					{
						if($inInvAmountPaid >= $ottFeeInInv)
							$ottFeeInInvPaid=$ottFeeInInv;
						else
							$ottFeeInInvPaid=$inInvAmountPaid;
						$inInvAmountPaid -=$ottFeeInInvPaid;
					}
					//ott fee
					if($inInvAmountPaid!=0)
					{
						if($inInvAmountPaid >= $ccsFeeInInv)
							$ccsFeeInInvPaid=$ccsFeeInInv;
						else
							$ccsFeeInInvPaid=$inInvAmountPaid;
						$inInvAmountPaid -=$ccsFeeInInvPaid;
					}
					//custom fee
					if($inInvAmountPaid!=0 && $customFeeInInv > 0)
					{
						if($inInvAmountPaid >= $customFeeInInv)
							$customFeeInInvPaid=$customFeeInInv;
						else
							$customFeeInInvPaid=$inInvAmountPaid;
						$inInvAmountPaid -=$customFeeInInvPaid;
					}
					//accomodation fee
					if($inInvAmountPaid!=0)
					{//echo 'accFeeTotalInInv='.$accFeeInInv;
						if($inInvAmountPaid >= $accFeeInInv)
							$accFeeTotalInInvPaid=$accFeeInInv;
						else
							$accFeeTotalInInvPaid=$inInvAmountPaid;
						$inInvAmountPaid -=$accFeeTotalInInvPaid;
					}
				}
			}
		//Payment Initial invoice #ENDS
		
		//echo "============<br>Initial Invoice<br>";
		
		/*echo 'Acc fee= '.$accFeeInInv.'<br>';
		echo 'Placement fee= '.$placementFeeInInv.'<br>';
		echo 'APU fee= '.$apuFeeInInv.'<br>';
		echo 'Caregiving fee= '.$caregivingFeeInInv.'<br>';
		echo 'Nomination fee= '.$nominationFeeInInv.'<br>';
		echo 'OTT fee= '.$ottFeeInInv.'<br>';
		echo 'CCS fee= '.$ccsFeeInInv.'<br>';
		echo 'Custom fee= '.$customFeeInInv.'<br>';*/
		$totalInInv=$accFeeInInv+$placementFeeInInv+$apuFeeInInv+$caregivingFeeInInv+$nominationFeeInInv+$ottFeeInInv+$ccsFeeInInv+$customFeeInInv;
		
		//echo "============<br><br>";
		
		$ongoingInv=$this->ongInvBetDates($from,$to,$appId);
		//see($ongoingInv);
		
		$accFeeInOnv=0;
		$holidayFeeOnInv=0;
		$customFeeOnInv=0;
		$caregivingFeeOnInv=0;
		
		$caregivingFeeonInvPaid=$customFeeOnInvPaid=$accFeeTotalOnInvPaid=0;
		
		foreach($ongoingInv as $ongInv)
		{
			$accFeeTotalOnInv=0;
			$holidayFeeTotalOnInv=0;
			$customFeeOnInvSingle=0;
			
			if($from<$ongInv['booking_from'])
				$fromOngInv=$ongInv['booking_from'];
			else
				$fromOngInv=$from;
			
			if($to>$ongInv['booking_to'])
				$toOngInv=$ongInv['booking_to'];
			else
				$toOngInv=$to;
			
			$dayDiffOngInv=dayDiff($fromOngInv,$toOngInv);//echo '<br>Ongoing inv duration= '.$dayDiffOngInv.'<br>';
				
			$ongInvD=ongoingInvoiceDetails($ongInv['id']);
			//see($ongInvD);
			foreach($ongInvD['items'] as $ongInvItem)
			{
				if($ongInvItem['type']=='accomodation' || $ongInvItem['type']=='accomodation_ed')
					$accFeeTotalOnInv +=$ongInvItem['total'];
				elseif($ongInvItem['type']=='holidayDiscount')
				{//
						$holidayFeeTotalOnInv +=$ongInvItem['total'];
				}
				elseif($ongInvItem['type']=='custom' || $ongInvItem['type']=='')
				{
					if($fromOngInv == $ongInv['booking_from'])
						$customFeeOnInvSingle +=$ongInv['total'];
				}
			}
			
			$customFeeOnInv +=$customFeeOnInvSingle;
			
			//Guardianship fee calculation #STARTS
			if(empty($initialInv))
			{
				$initialInv=initialInvoiceByShaId($appId);
				$inInvD=initialInvoiceDetails($initialInv['id']);
			}
			if(isset($inInvD) && !empty($inInvD))
			{
				foreach($inInvD['items'] as $inInvItem)
				{
					if($inInvItem['type']=='guardianship')
					{
						if($booking['booking_to']!='0000-00-00')
							$gaurdiansipDuration=dayDiff($booking['booking_from'],$booking['booking_to']);
						else	
							$gaurdiansipDuration=$inInvItem['qty']*7;
						$guardianshipPerDay=$inInvItem['total']/$gaurdiansipDuration;
						$caregivingFeeOnInv +=$guardianshipPerDay*$dayDiffOngInv;
					}
				}
			}
			//Guardianship fee calculation #ENDS
			
			////Acc fee calculation
			$onInvDuration=dayDiff($ongInv['booking_from'],$ongInv['booking_to']);
			$accFeeInOnvSingle=($accFeeTotalOnInv/$onInvDuration)*$dayDiffOngInv;
			$accFeeInOnv +=$accFeeInOnvSingle;
			//echo ($accFeeTotalOnInv/$onInvDuration)*$dayDiffOngInv.'<br>';
			
			$holidayFeeOnInv +=($holidayFeeTotalOnInv/$onInvDuration)*$dayDiffOngInv;
			////
			
			
			//Payment Ongoing invoice #STARTS
			if(!empty($ongoingInv))
			{
				$customFeeOnInvSinglePaid=0;
				if($ongInv['status']=='3')
				{
					if($customFeeOnInvSingle>0)
					{
						$customFeeOnInvSinglePaid=$customFeeOnInvSingle;
						$customFeeOnInvPaid +=$customFeeOnInvSinglePaid;
					}	
					
					$accFeeInOnvSinglePaid=$accFeeInOnvSingle;
					$accFeeTotalOnInvPaid +=$accFeeInOnvSinglePaid;
				}
				elseif($ongInv['status']=='2')
				{
					$onInvAmountPaidSingle=0;
					$onInvDetails=ongoingInvoiceDetails($ongInv['id']);
					foreach($onInvDetails['payment'] as $onInvDetailsPayments)
						$onInvAmountPaidSingle +=$onInvDetailsPayments['amount_paid'];
					
					if($onInvAmountPaidSingle!=0 && $customFeeOnInvSingle>0)
					{
						if($onInvAmountPaidSingle >= $customFeeOnInvSingle)
							$customFeeOnInvSinglePaid=$customFeeOnInvSingle;
						else
							$customFeeOnInvSinglePaid=$onInvAmountPaidSingle;
						$onInvAmountPaidSingle -=$customFeeOnInvSinglePaid;
					}
					
					if($onInvAmountPaidSingle!=0)
					{
						if($onInvAmountPaidSingle >= $accFeeInOnvSingle)
							$accFeeInOnvSinglePaid=$accFeeInOnvSingle;
						else
							$accFeeInOnvSinglePaid=$onInvAmountPaidSingle;
						$onInvAmountPaidSingle -=$accFeeInOnvSinglePaid;
					}
					
					$customFeeOnInvPaid +=$customFeeOnInvSinglePaid;
					$accFeeTotalOnInvPaid +=$accFeeInOnvSinglePaid;
				}
			}
			//Payment Ongoing invoice #ENDS
		}
		
		/*echo "============<br>Ongoing Invoice<br>";
		
		echo 'Acc fee= '.$accFeeInInv.'<br>';
		echo 'Custom fee= '.$customFeeOnInv.'<br>';
		echo 'Holiday fee= '.$holidayFeeOnInv.'<br>';*/
		$totalOnInv=$accFeeInOnv+$customFeeOnInv+$holidayFeeOnInv+$caregivingFeeOnInv;
		//echo "============<br><br>";
		
		//echo "============<br>Total<br>";
		$total=$totalInInv+$totalOnInv;
		//echo $total;
		
		
		//Total Paid #STARTS
		if(!empty($initialInv))
		  {
			  if((isset($initialInv[0]) && $initialInv[0]['status']=='3') || (!isset($initialInv[0]) && $initialInv['status']=='3'))
				  $caregivingFeeonInvPaid=$caregivingFeeOnInv;
		  }
		
		$accFeeTotalPaid=$accFeeTotalInInvPaid+$accFeeTotalOnInvPaid;
		$customFeePaid=$customFeeInInvPaid+$customFeeOnInvPaid;
		$totalPaid=$accFeeTotalPaid+$customFeePaid+$placementFeeInInvPaid+$apuFeeInInvPaid+$caregivingFeeInInvPaid+$nominationFeeInInvPaid+$ottFeeInInvPaid+$ccsFeeInInvPaid+$caregivingFeeonInvPaid;
		//Total Paid #ENDS
		
		$accFeeTotal=$accFeeInInv+$accFeeInOnv;
		$outputHtml .='Acc fee= '.$accFeeTotal.'<br>';
		$outputHtml .='Holiday fee= '.$holidayFeeOnInv.'<br>';
		$accFeeAfterHoliday=$accFeeTotal+$holidayFeeOnInv;
		if($accFeeTotalPaid >= $holidayFeeOnInv)
		$accFeeTotalPaidAfterHoliday=$accFeeTotalPaid+$holidayFeeOnInv;
		
		$outputHtml .='Total Acc fee= '.$accFeeAfterHoliday.' (Paid: '.$accFeeTotalPaidAfterHoliday.')'.'<br><br>';
		
		$outputHtml .='Placement fee= '.$placementFeeInInv.' (Paid: '.$placementFeeInInvPaid.')'.'<br>';
		$outputHtml .='APU fee= '.$apuFeeInInv.' (Paid: '.$apuFeeInInvPaid.')'.'<br>';
		$caregivingFeeTotal=$caregivingFeeInInv+$caregivingFeeOnInv;
		$caregivingFeePaid=$caregivingFeeInInvPaid+$caregivingFeeonInvPaid;
		$outputHtml .='Caregiving fee= '.$caregivingFeeTotal.' (Paid: '.$caregivingFeePaid.')'.'<br>';
		$outputHtml .='Nomination fee= '.$nominationFeeInInv.' (Paid: '.$nominationFeeInInvPaid.')'.'<br>';
		$outputHtml .='OTT fee= '.$ottFeeInInv.' (Paid: '.$ottFeeInInvPaid.')'.'<br>';
		$outputHtml .='CCS fee= '.$ccsFeeInInv.' (Paid: '.$ccsFeeInInvPaid.')'.'<br>';
		
		$customFeeTotal=$customFeeInInv+$customFeeOnInv;
		$outputHtml .='Custom fee= '.$customFeeTotal.' (Paid: '.$customFeePaid.')'.'<br>';
		
		
		$outputHtml .="============<br>Total<br>";
		$total=$totalInInv+$totalOnInv;
		$outputHtml .=$total/*.' (Paid: '.$totalPaid.')'*/;
		
		$output['accFee']=$accFeeAfterHoliday;
		$output['caregivingFee']=$caregivingFeeTotal;
		$output['html']=$outputHtml;
		//echo json_encode($output);
		return json_encode($output);
	}
	
	function bmPo()
	{
		$outputHtml='';
		$bid=$_POST['marginBookingId'];
		$from=normalToMysqlDate($_POST['marginFrom']);
		$to=normalToMysqlDate($_POST['marginTo']);
		
		$booking=bookingDetails($bid);//see($booking);
		$appId=$booking['student'];
		
		if(strtotime($booking['booking_from']) > strtotime($from))
			$from=$booking['booking_from'];
		
		//$to=date('Y-m-d',strtotime($to.' - 1 day'));
		$dayDiff=dayDiff($from,$to);
		
		$outputHtml .=$from.' '.$to.', days='.$dayDiff.'<br>';
		$outputHtml .='===============================<br>';
		
		$purchaseOrders=$this->poBetDates($from,$to,$bid);
		//see($purchaseOrders);
		
		$accFeePo=0;
		$adminFeePo=0;
		$customFeePo=0;
		$holidayFeePo=0;
		
		$accFeePoPaid=0;
		$adminFeePoPaid=0;
		$customFeePoPaid=0;
		//$holidayFeePoPaid=0;
		
		foreach($purchaseOrders as $po)
		{
			$accFeeTotalPo=0;
			$adminFeeTotalPo=0;
			$holidayFeeTotalPo=0;
			$customFeePoSingle=0;
			
			$poDeatils=poDetails($po['id']);
			//see($poDeatils);
			
			//Dates #STARTS
			if($from<$poDeatils['from'])
				$fromPo=$poDeatils['from'];
			else
				$fromPo=$from;
			
			if($to>$poDeatils['to'])
				$toPo=$poDeatils['to'];
			else
				$toPo=$to;
			//Dates #ENDS
			//echo '<br>Dates: '.$fromPo.' '.$toPo;
			
			foreach($poDeatils['items'] as $poItems)
			{
				if($poItems['type']=='accomodation' || $poItems['type']=='accomodation_ed')
					$accFeeTotalPo +=$poItems['total'];
				elseif($poItems['type']=='adminFee')
				{
					if($poItems['qty_unit']=='3')
						$adminFeeTotalPo +=getPoAdminFee($poDeatils['items']);
					else	
						$adminFeeTotalPo +=$poItems['total'];
				}
				elseif($poItems['type']=='custom' || $poItems['type']=='')
				{
					if($fromPo == $po['from'])
						$customFeePoSingle +=$poItems['total'];
				}
				elseif($poItems['type']=='holidayDiscount')
					$holidayFeeTotalPo +=$poItems['total'];
			}
			
			//echo ' Holiday fee: '.$holidayFeeTotalPo;
			////Acc fee calculation
			$dayDiffPo=dayDiff($fromPo,$toPo);
			$poDuration=dayDiff($po['from'],$po['to']);
			
			$customFeePo +=$customFeePoSingle;
			
			$accFeePoSingle=($accFeeTotalPo/$poDuration)*$dayDiffPo;
			$accFeePo +=$accFeePoSingle;
			
			$adminFeePoSingle=($adminFeeTotalPo/$poDuration)*$dayDiffPo;
			$adminFeePo +=$adminFeePoSingle;
			
			$holidayFeePoSingle=($holidayFeeTotalPo/$poDuration)*$dayDiffPo;
			$holidayFeePo +=$holidayFeePoSingle;
			
			$customFeePoSinglePaid=0;
			//Payment #STARTS
			if($po['status']=='2')
			{
				if($customFeePoSingle>0)
				{
					$customFeePoSinglePaid=$customFeePoSingle;
					$customFeePoPaid +=$customFeePoSinglePaid;
				}
				
				$accFeePoSinglePaid=$accFeePoSingle;
				$accFeePoPaid +=$accFeePoSinglePaid;
				
				/*$adminFeePoSinglePaid=$adminFeePoSingle;
				$adminFeePoPaid +=$adminFeePoSinglePaid;*/
				
				/*$holidayFeePoSinglePaid=$holidayFeePoSingle;
				$holidayFeePoPaid +=$holidayFeePoSinglePaid;*/
			}
			elseif($po['status']=='3')
			{
				$customFeePoSinglePaid=$accFeePoSinglePaid=$adminFeePoSinglePaid=$holidayFeePoSinglePaid=0;
				
				$poAmountPaidSingle=0;
				$poPaymentDetails=poPaymentDetails($po['id']);
				foreach($poPaymentDetails as $pPD)
				{
					$poAmountPaidSingle +=$pPD['amount_paid'];
				}
				
				//Custom fee
				if($poAmountPaidSingle!=0 && $customFeePoSingle>0)
				{
					if($poAmountPaidSingle >= $customFeePoSingle)
						$customFeePoSinglePaid=$customFeePoSingle;
					else
						$customFeePoSinglePaid=$poAmountPaidSingle;
					$poAmountPaidSingle -=$customFeePoSinglePaid;
				}
				
				//Admin fee	
				/*if($poAmountPaidSingle!=0)
				{
					if($poAmountPaidSingle >= $adminFeePoSingle)
						$adminFeePoSinglePaid=$adminFeePoSingle;
					else
						$adminFeePoSinglePaid=$poAmountPaidSingle;
					$poAmountPaidSingle -=$adminFeePoSinglePaid;
				}*/
				
				//Acc fee		
				if($poAmountPaidSingle!=0)
				{
					if($poAmountPaidSingle >= $accFeePoSingle)
						$accFeePoSinglePaid=$accFeePoSingle;
					else
						$accFeePoSinglePaid=$poAmountPaidSingle;
					$poAmountPaidSingle -=$accFeePoSinglePaid;
				}
				
				//Holiday fee	
				/*if($poAmountPaidSingle!=0)
				{
					if($poAmountPaidSingle >= $holidayFeePoSingle)
						$holidayFeePoSinglePaid=$holidayFeePoSingle;
					else
						$holidayFeePoSinglePaid=$poAmountPaidSingle;
					$poAmountPaidSingle -=$holidayFeePoSinglePaid;
				}*/
				
				$customFeePoPaid +=$customFeePoSinglePaid;
				$accFeePoPaid +=$accFeePoSinglePaid;
				//$adminFeePoPaid +=$adminFeePoSinglePaid;
				//$holidayFeePoPaid +=$holidayFeePoSinglePaid;
			}
			//Payment #ENDS
		}
		
		$outputHtml .='   Accomodation fee: '.$accFeePo;
		$outputHtml .='<br>   Holiday fee: '.$holidayFeePo;
		$accFeePoAfterHoliday=$accFeePo+$holidayFeePo;
		if($accFeePoPaid >= $holidayFeePo)
		$accFeePoPaidAfterHoliday=$accFeePoPaid+$holidayFeePo;
		$outputHtml .='<br>   Total Accomodation fee: '.$accFeePoAfterHoliday.' (Paid: '.$accFeePoPaidAfterHoliday.')<br>';
		
		//$outputHtml .='<br>   Admin fee: '.$adminFeePo.' (Paid: '.$adminFeePoPaid.')';
		$outputHtml .='<br>   Admin fee: '.$adminFeePo;
		$outputHtml .='<br>   Custom fee: '.$customFeePo.' (Paid: '.$customFeePoPaid.')';
		
		/*$poTotalAmount=$accFeePo+$adminFeePo+$customFeePo+$holidayFeePo;
		$poTotalAmountPaid=$accFeePoPaid+$adminFeePoPaid+$customFeePoPaid;*/
		$poTotalAmount=$accFeePo+$customFeePo+$holidayFeePo-$adminFeePo;
		$poTotalAmountPaid=$accFeePoPaid+$customFeePoPaid;
		
		$outputHtml .='<br> Total amount= '.$poTotalAmount/*.' (Paid: '.$poTotalAmountPaid.')'*/;
		
		$output['accFee']=$accFeePoAfterHoliday;
		$output['poTotalAmount']=$poTotalAmount;
		$output['adminFeePo']=$adminFeePo;
		$output['html']=$outputHtml;
		//echo json_encode($output);
		return json_encode($output);
	}
	
	function poBetDates($from,$to,$bookingId=0)
	{
		$sql="select * from `purchase_orders` where";
		$sql .="`booking_id`='".$bookingId."' and ";
		
		$sql .="(";
		$sql .="(`from`>='".$from."' and `from`<='".$to."')";//F BF T
		$sql .=" OR (`to`>='".$from."' and `to`<='".$to."')";//F BT T
		$sql .=" OR (`from`<='".$from."' and  `to`>='".$to."')";//BF F T BT
		$sql .=")";
		return $this->db->query($sql)->result_array();
	}
	
	function bmMargin()
	{
		$data=$_POST;
		
		$profit=$data['accFeeInv']-$data['accFeePo'];
		$profitPercent=($profit/$data['accFeeInv'])*100;
		
		$outputHtml='';
		$outputHtml .='Profit= '.$profit.'<br>';
		$outputHtml .='Profit%= '.$profitPercent.'%<br>';
		$output['html']=$outputHtml;
		$output['profitPercent']=$profitPercent;
		
		//echo json_encode($output);
		return json_encode($output);
	}
	
	function bmPaidTill()
	{
		$data=$_POST;
		$bookingId=$_POST['marginBookingId'];
		$booking=bookingDetails($bookingId);
		
		$outputHtml='';
		//Inovice #START
		$onInv=$this->db->query("select * from `invoice_ongoing` where `application_id`='".$booking['student']."' and `status` IN('2','3') order by `id` DESC")->row_array();
		if(!empty($onInv))
		{
			if($onInv['status']=='3')
				$outputHtml .='Invoice is paid till '.dateFormat($onInv['booking_to']);
			else
			{
				$partialOngInvPaidTill=$this->partialOngInvPaidTill($onInv);
				$outputHtml .='Invoice is paid till '.$partialOngInvPaidTill['paidTillDate'];
			}
		}
		else
		{
			$inInv=$this->db->query("select * from `invoice_initial` where `application_id`='".$booking['student']."' and `status` IN('2','3') order by `id` DESC")->row_array();
			if(!empty($inInv))
			{
				if($inInv['status']=='3')
					$outputHtml .='Invoice is paid till '.dateFormat($inInv['booking_to']);
				else
					{
						$partialInInvPaidTill=$this->partialInInvPaidTill($inInv);
						$outputHtml .='Invoice is paid till '.$partialInInvPaidTill['paidTillDate'];
					}
			}
			else
				$outputHtml .='No Invoice is paid till date';
		}
		$outputHtml .='<br>';	
		//Inovice #END
		
		//PO #START
		$po=$this->db->query("select * from `purchase_orders` where `booking_id`='".$bookingId."' and `status` IN('2','3') order by `id` DESC")->row_array();
		if(!empty($po))
		{
			if($po['status']=='2')
				$outputHtml .='PO is paid till '.dateFormat($po['to']);
			else
				  {
					  $partialPoPaidTill=$this->partialPoPaidTill($po);
					  $outputHtml .='PO is paid till '.$partialPoPaidTill['paidTillDate'];
				  }
		}
		else
			$outputHtml .='No PO is paid till date';
		//PO #END
		
		
		//Total Received/Paid #STARTS
		$totalReceived=$this->totalReceivedByBooking($bookingId);
		$outputHtml .='<br>Total recveived= $'.$totalReceived;
		
		$totalPaid=$this->totalPaidByBooking($bookingId);
		$outputHtml .='<br>Total paid= $'.$totalPaid;
		//Total Received/Paid #ENDS
		
		$output['html']=$outputHtml;
		
		//echo json_encode($output);
		return json_encode($output);
	}
	
	function partialOngInvPaidTill($onInv)
	{
		  $paidTIllDate='';
		  $accFeeOnInv=$holidayFeeOnInv=$customFeeOnInv=$accFeeTotalDuration=0;
		  
		  $ongInvD=ongoingInvoiceDetails($onInv['id']);
		  foreach($ongInvD['items'] as $ongInvItem)
			  {
				  if($ongInvItem['type']=='accomodation' || $ongInvItem['type']=='accomodation_ed')
				  {
					  $accFeeOnInv +=$ongInvItem['total'];
					  if($ongInvItem['type']=='accomodation')
						  $accFeeTotalDuration +=$ongInvItem['qty']*7;
					  else
						  $accFeeTotalDuration +=$ongInvItem['qty'];	
				  }
				  elseif($ongInvItem['type']=='holidayDiscount')
					  $accFeeOnInv +=$ongInvItem['total'];
				  elseif($ongInvItem['type']=='custom' || $ongInvItem['type']=='')
					  $customFeeOnInv +=$ongInvItem['total'];
			  }
			  
			  $onInvAmountPaid=0;
			  foreach($ongInvD['payments'] as $onInvDetailsPayments)
				  $onInvAmountPaid +=$onInvDetailsPayments['amount_paid'];
			  
			  if($onInvAmountPaid!=0 && $customFeeOnInv>0)
			  {
				  if($onInvAmountPaid >= $customFeeOnInv)
					  $customFeeOnInvPaid=$customFeeOnInv;
				  else
					  $customFeeOnInvPaid=$onInvAmountPaid;
				  $onInvAmountPaid -=$customFeeOnInvPaid;
			  }
			  
			  if($accFeeTotalDuration>0 && $onInvAmountPaid>0)
			  {
				  $accFeePerDay=$accFeeOnInv/$accFeeTotalDuration;
				  $daysPaid=floor($onInvAmountPaid/$accFeePerDay);
				  $paidTillDate=date('d M Y',strtotime($onInv['booking_from'].' +'.$daysPaid.' days -1 day'));
			  }
			  
			  if($paidTillDate=='')
			  	$paidTillDate=date('d M Y',strtotime($onInv['booking_from'].' -1 day'));
			
			$return['paidTillDate']=$paidTillDate;
			$return['paidAmount']=$onInvAmountPaid;
			return $return;
	}
	
	function partialInInvPaidTill($onInv)
	{
		  $paidTillDate='';
		  $accFeeInInv=$firstDayFeeInInv=$caregivingFeeInInv=$accFeeTotalDuration=0;

		  $inInvD=initialInvoiceDetails($onInv['id']);
		  foreach($inInvD['items'] as $inInvItem)
			  {
				  if($inInvItem['type']=='accomodation' || $inInvItem['type']=='accomodation_ed')
				  {
					  $accFeeInInv +=$inInvItem['total'];
					  if($inInvItem['type']=='accomodation')
						  $accFeeTotalDuration +=$inInvItem['qty']*7;
					  else
						  $accFeeTotalDuration +=$inInvItem['qty'];	
				  }
				  elseif($inInvItem['type']=='guardianship')
				  {
				  	$caregivingFeeInInv +=$inInvItem['total'];
				  }
				  else
					  $firstDayFeeInInv +=$inInvItem['total'];
			  }
			  
			  $inInvAmountPaid=0;
			  foreach($inInvD['payments'] as $inInvDetailsPayments)
				  $inInvAmountPaid +=$inInvDetailsPayments['amount_paid'];
			  
			  if($inInvAmountPaid!=0 && $firstDayFeeInInv>0)
			  {
				  if($inInvAmountPaid >= $firstDayFeeInInv)
					  $firstDayFeeInInvPaid=$firstDayFeeInInv;
				  else
					  $firstDayFeeInInvPaid=$inInvAmountPaid;
				  $inInvAmountPaid -=$firstDayFeeInInvPaid;
			  }
			  
			  if($inInvAmountPaid!=0 && $caregivingFeeInInv>0)
			  {
				  if($inInvAmountPaid >= $caregivingFeeInInv)
					  $caregivingFeeInInvPaid=$caregivingFeeInInv;
				  else
					  $caregivingFeeInInvPaid=$inInvAmountPaid;
				  $inInvAmountPaid -=$caregivingFeeInInvPaid;
			  }
			  
			  if($accFeeTotalDuration>0 && $inInvAmountPaid>0)
			  {
				  $accFeePerDay=$accFeeInInv/$accFeeTotalDuration;
				  $daysPaid=floor($inInvAmountPaid/$accFeePerDay);//echo 'Days= '.$daysPaid.'<br>';
				  $paidTillDate=date('d M Y',strtotime($inInvD['booking_from'].' +'.$daysPaid.' days -1 day'));
			  }
			  
			  /*if($paidTillDate=='')
			  	$paidTillDate=date('d M Y',strtotime($inInvD['booking_from'].' -1 day'));*/
			
			$return['paidTillDate']=$paidTillDate;
			$return['paidAmount']=$inInvAmountPaid;
			return $return;
	}
	
	function partialPoPaidTill($po)
	{
		$paidTIllDate='';
		
		$accFeePo=$holidayFeePo=$firstDayFeePo=$accFeeTotalDuration=0;
		$poDeatils=poDetails($po['id']);
		
		foreach($poDeatils['items'] as $poItems)
			{
				if($poItems['type']=='accomodation' || $poItems['type']=='accomodation_ed' || $poItems['type']=='holidayDiscount')
				{
					$accFeePo +=$poItems['total'];
					 if($poItems['type']=='accomodation')
						  $accFeeTotalDuration +=$poItems['qty']*7;
					  elseif($poItems['type']=='accomodation_ed')
						  $accFeeTotalDuration +=$poItems['qty'];	
				}
				elseif($poItems['type']=='adminFee')
				{
					if($poItems['qty_unit']=='3')
						$firstDayFeePo -=getPoAdminFee($poDeatils['items']);
					else	
						$firstDayFeePo -=$poItems['total'];
				}
				elseif($poItems['type']=='custom' || $poItems['type']=='')
						$firstDayFeePo +=$poItems['total'];
			}
			
		$poPaymentDetails=poPaymentDetails($po['id']);
		$poAmountPaid=0;
		foreach($poPaymentDetails as $pPD)
			$poAmountPaid +=$pPD['amount_paid'];
		
		if($poAmountPaid!=0 && $firstDayFeePo>0)
			  {
				  if($poAmountPaid >= $firstDayFeePo)
					  $customFeePoPaid=$firstDayFeePo;
				  else
					  $customFeePoPaid=$poAmountPaid;
				  $poAmountPaid -=$customFeePoPaid;
			  }	
			
		  if($accFeeTotalDuration>0 && $poAmountPaid>0)
			{
				$accFeePerDay=$accFeePo/$accFeeTotalDuration;//echo $accFeePerDay.' = '.$accFeePo.' / '.$accFeeTotalDuration.'<br>';
				$daysPaid=floor($poAmountPaid/$accFeePerDay);//echo 'days= '.$daysPaid.', amount= '.$poAmountPaid.'<br>';
				$paidTillDate=date('d M Y',strtotime($po['from'].' +'.$daysPaid.' days -1 day'));
			}  
			
			if($paidTillDate=='' && $po['initial']!='1')
			  	$paidTillDate=date('d M Y',strtotime($po['from'].' -1 day'));
		
		$return['paidTillDate']=$paidTillDate;
		$return['paidAmount']=$poAmountPaid;
		return $return;
	}
	
	function totalReceivedByBooking($bookingId)
	{
		$totalReceived=0;
		
		$onInvs=$this->db->query("select * from `invoice_ongoing` where `application_id`=(select `student` from `bookings` where `id`='".$bookingId."') and `status` IN('2','3') order by `id` DESC")->result_array();
		
		if(!empty($onInvs))
		{
			$onInvs2=$this->db->query("select * from `invoice_ongoing` where `application_id`=(select `student` from `bookings` where `id`='".$bookingId."') and `status` IN('1') and `id`<'".$onInvs[0]['id']."' order by `id` DESC")->result_array();
			$onInvs=array_merge($onInvs,$onInvs2);
			foreach($onInvs as $onInvK=>$onInv)
			{
				$onInvD=ongoingInvoiceDetails($onInv['id']);
				foreach($onInvD['items'] as $item)
				{
					if(in_array($item['type'],array('accomodation','accomodation_ed','holidayDiscount')))
					{
						if($onInvK==0 && $onInv['status']=='2')
							{}
						else
							$totalReceived +=$item['total'];
					}
				}
				
				if($onInvK==0 && $onInv['status']=='2')
				{
					$datePaidTill=$this->partialOngInvPaidTill($onInv);
					$totalReceived +=$datePaidTill['paidAmount'];
				}
			}
		}
		
		$inInv=$this->db->query("select * from `invoice_initial` where `application_id`=(select `student` from `bookings` where `id`='".$bookingId."') and `status` IN('2','3')")->row_array();
		
		if(!empty($inInv))
		{
			$inInvD=initialInvoiceDetails($inInv['id']);
			foreach($inInvD['items'] as $item)
			{
				if(in_array($item['type'],array('accomodation','accomodation_ed','guardianship')))
				{
					if(empty($onInvs) && $inInv['status']=='2')
						{}
					else
						$totalReceived +=$item['total'];
				}
			}
			
			if(empty($onInvs) && $inInv['status']=='2')
			{
				$datePaidTill=$this->partialInInvPaidTill($inInv);
				$totalReceived +=$datePaidTill['paidAmount'];
			}
		}
		
		return $totalReceived;
	}
	
	function totalPaidByBooking($bookingId)
	{
		$pos=$this->db->query("select * from `purchase_orders` where `booking_id`='".$bookingId."' and `status` IN('2','3') order by `id` DESC")->result_array();
		//echo $this->db->last_query().'<br>';//see($pos);
		if(!empty($pos))
		{
			$pos2=$this->db->query("select * from `purchase_orders` where `booking_id`='".$bookingId."' and `status` IN('1') and `id`<'".$pos[0]['id']."' order by `id` DESC")->result_array();
			$pos=array_merge($pos,$pos2);
		}//see($pos);
		$totalPaid=0;
		foreach($pos as $poK=>$po)
		{
			$poPaidSingle=0;
			$poDeatils=poDetails($po['id']);
			foreach($poDeatils['items'] as $poItem)
			{
				if(in_array($poItem['type'],array('accomodation','accomodation_ed','holidayDiscount','adminFee')))
					{
						if($poK==0 && $po['status']=='3')
							{}
						else
						{
							if($poItem['type']=='adminFee')
							{
								if($poItem['qty_unit']=='3')
									$totalPaid -=getPoAdminFee($poDeatils['items']);
								else	
									$totalPaid -=$poItem['total'];
							}
							else
								$totalPaid +=$poItem['total'];
						}
					}
			}
			if($poK==0 && $po['status']=='3')
			{
				$datePaidTill=$this->partialPoPaidTill($po);
				$totalPaid +=$datePaidTill['paidAmount'];
			}//echo $totalPaid.'<br>';
		}
		return $totalPaid;
	}
	
}
