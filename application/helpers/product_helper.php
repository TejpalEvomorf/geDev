<?php

function productsList($year)
{
	$obj= &get_instance();
	$obj->load->model("product_model");
	$products=$obj->product_model->productsList($year);
	return $products;
}

function clientProductsList($client_id,$year)
{
	$obj= &get_instance();
	$obj->load->model("product_model");
	$products=$obj->product_model->clientProductsList($client_id,$year);
	return $products;
}

function getGstExclAmount($amount,$gst)
{
	return ($amount*100)/($gst+100);
}

function getGstAmount($amount,$gst)
{
	$gstExcl=($amount*100)/($gst+100);
	return ($gstExcl*($gst/100));
}

function initialInvoiceBefore($id)
{
	$obj= &get_instance();
	$obj->load->model("invoice_model");
	$invoice=$obj->invoice_model->initialInvoiceBefore($id);
	return $invoice;
}


function initialInvoiceListTd($invoice,$initial_invoice_pageStatus)
{
	//td1
	$td1='<a href="'.site_url().'invoice/view_initial/'.$invoice['id'].'" target="_blank" data-placement="bottom" data-toggle="tooltip"  data-original-title="System invoice number">'.'I-'.$invoice['id'].'</a>';
    if($invoice['moved_to_xero']==1)
		$td1.='<br><a href="https://go.xero.com/AccountsReceivable/Edit.aspx?InvoiceID='.$invoice['xero_invoiceId'].'" target="_blank" data-placement="bottom" data-toggle="tooltip"  data-original-title="Xero invoice number">'.$invoice['invoice_number'].'</a>';
	if($invoice['study_tour']=='0')
	{
		$bookingByShaId=bookingByShaId($invoice['application_id']);
		if(!empty($bookingByShaId))
			$td1 .='<br><a href="javascript:void(0);" data-placement="bottom" data-toggle="tooltip"  data-original-title="Booking id">'.$bookingByShaId['id'].'</a>';	
	}
	$td['td1']=$td1;								  
	
	//td4
	$total_amount=0;
	foreach($invoice['items'] as $item)
		$total_amount +=$item['total'];
	$td4='';
	
	if($initial_invoice_pageStatus=='0')
	{
		if($invoice['status']=='1')
			$td4.="<b style=' color:#e51c23; '>Pending</b>";
		elseif($invoice['status']=='2')
				$td4.="<b style=' color:#ff9800; '>Partially paid</b>";
		elseif($invoice['status']=='3')
				$td4.="<b style=' color:#8bc34a; '>Paid</b>";
		$td4.="<br>";				
	}
	$td4 .='Total: $'.add_decimal($total_amount);
	
	if($invoice['status']=='1')
	{
		$totalDays=shaInitialInvoiceWeekDays($invoice['application_id']);
		if($invoice['study_tour']==1)
			$totalDays=dayDiff($invoice['booking_from'],$invoice['booking_to']);
		$getWeekNDays=getWeekNDays($totalDays);
		
		if($initial_invoice_pageStatus!='0')
		{
			$td4.="<br>Duration: ";
			if(isset($getWeekNDays['week']))
				$td4.=$getWeekNDays['week'].' week'.s($getWeekNDays['week']).' ';
			if(isset($getWeekNDays['day']))
				$td4.=$getWeekNDays['day'].' night'.s($getWeekNDays['day']);
		}
	}
	else
	{
		if($initial_invoice_pageStatus!='0')
		{	
			$td4.="<br>Received: ";
			if($invoice['status']=='3')
				$td4.='$'.add_decimal($total_amount);
			else
			{
				$amount_paid=0;
				foreach($invoice['payments'] as $payment)
					$amount_paid +=$payment['amount_paid'];
				$td4.='$'.add_decimal($amount_paid);	
			}	
		}
	}
	
	$td4.='<br><span style="color:#b0b0b0;">Created: '.date('d M Y',strtotime($invoice['date'])).'</span>';
	
                       
   $td['td4']=$td4;
   
   //td office use
   $td_officeUse='';
   if($invoice['moved_to_xero']==1)
		$td_officeUse .='<a href="https://go.xero.com/AccountsReceivable/View.aspx?InvoiceID='.$invoice['xero_invoiceId'].'" target="_blank" style="margin-right: 1px; margin-left: 1px;"><img src="'.static_url().'img/xero-icon.png" data-placement="bottom" data-toggle="tooltip"  data-original-title="Moved to xero: '.date('d M Y',strtotime($invoice['moved_to_xero_date'])).'" width="19"></a>';
                                        
	if(isset($invoice['items_standard']))
	{
		if($invoice['studentInvSent']=='0000-00-00 00:00:00')
		{
			$StudentIconColor='colorLightgrey';
			$StudentIconToolTip='Student invoice not sent. Click to mark it as sent.';			
		}
		else
		{
			$StudentIconColor='colorLightgreen';
			$StudentIconToolTip='Student invoice sent on '.date('d M Y g:i A',strtotime($invoice['studentInvSent']));
		}
		
	    $td_officeUse .='<a href="javascript:changeStudentInvStatus('.$invoice['id'].');"  class="'.$StudentIconColor.'"><i class="font16 material-icons" data-placement="bottom" data-toggle="tooltip"  data-original-title="'.$StudentIconToolTip.'">face</i></a>';
	}
                                         
    if($invoice['cancelled']=='1')
	     $td_officeUse .='<a href="javascript:void(0);" target="_blank" data-toggle="modal" data-target="#model_initialInvoiceCancelInfo" onclick="initialInvoiceCancelInfoPopContent('.$invoice['id'].');"><i class="font16 material-icons" data-placement="bottom" data-toggle="tooltip"  data-original-title="Application cancelled" style="" >cancel</i></a>';
    
	if($invoice['study_tour']!='0')
	     $td_officeUse .='<a href="javascript:void(0);" target="_blank" ><i class="font16 material-icons" data-placement="bottom" data-toggle="tooltip"  data-original-title="Tour group invoice">stars</i></a>';
    
	 
	 $td['td_officeUse']=$td_officeUse;                                     
   
    return $td;                               
}

function getInvoiceIdFromInvoiceNumber($invoiceNumber)
{
	$obj= &get_instance();
	$obj->load->model("xero_model");
	$invoice=$obj->xero_model->getInvoiceIdFromInvoiceNumber($invoiceNumber);
	return $invoice;
}

function getInitialInvoicePayments($invoiceId)
{
	$obj= &get_instance();
	$obj->load->model("xero_model");
	$payments=$obj->xero_model->getInitialInvoicePayments($invoiceId);
	return $payments;
}

function getInitialInvoicePaymentsCount($invoiceId)
{
	$payments=getInitialInvoicePayments($invoiceId);
	return count($payments);
}

function clientsWithAgreementList($year)
{
	$obj= &get_instance();
	$obj->load->model("product_model");
	$clients=$obj->product_model->clientsWithAgreementList($year);
	return $clients;
}

function checkIfClientHasAgreement($clientId,$year)
{
	$clientsWithAgreementList=clientsWithAgreementList($year);
	$yes=false;
	foreach($clientsWithAgreementList as $cAL)
			{
				if($cAL['id']==$clientId)
					$yes=true;
			}
	return $yes;		
}

function initialInvoiceByShaId($id)
{
	$obj= &get_instance();
	$obj->load->model("invoice_model");
	$intialInvoice=$obj->invoice_model->initialInvoiceByShaId($id);
	return $intialInvoice;
}

function initialInvoiceByTourId($id)
{
	$obj= &get_instance();
	$obj->load->model("invoice_model");
	$intialInvoice=$obj->invoice_model->initialInvoiceByTourId($id);
	return $intialInvoice;
}

function initialInvoiceDetails($invoiceId)
{
	$obj= &get_instance();
	$obj->load->model("invoice_model");
	$intialInvoice=$obj->invoice_model->initialInvoiceDetails($invoiceId);
	return $intialInvoice;
}

function getInitialInvoiceAmount($invoiceId)
{
	$obj= &get_instance();
	$obj->load->model("invoice_model");
	$intialInvoice=$obj->invoice_model->initialInvoiceDetails($invoiceId);
	
	$amount=0;
	foreach($intialInvoice['items'] as $payment)
		$amount +=$payment['total'];
	return add_decimal($amount);
}

function getInitialInvoiceAmountPaid($invoiceId)
{
	$payments=getInitialInvoicePayments($invoiceId);
	$amount=0;
	foreach($payments as $payment)
		$amount +=$payment['amount_paid'];
	return add_decimal($amount);
}

function initialInvoiceItemsToForfeit($shaId,$invoiceId,$date_cancellation)
{
		$booking=bookingByShaId($shaId);
		//echo "<br>".$booking['booking_from'].' to '.$booking['booking_to'];
		$daysBefore=dayDiff($date_cancellation,$booking['booking_from'])-1;
		//echo "<br>"."Day diff= ".$daysBefore;
				
		$forfeit=array();
		$initialInvoiceDetails=initialInvoiceDetails($invoiceId);
		if($daysBefore<3)
		{
			foreach($initialInvoiceDetails['items'] as $iIDK=>$iIDV)
			{
				if($iIDV['type']=='placement' || $iIDV['type']=='ott' || $iIDV['type']=='ccs' || $iIDV['type']=='apu')
					$forfeit[]=array('type'=>$iIDV['type'],'desc'=>$iIDV['desc'],'amount'=>$iIDV['total']);
			
				if($iIDV['type']=='accomodation')
					$forfeit[]=array('type'=>$iIDV['type'],'desc'=>$iIDV['desc'],'amount'=>$iIDV['unit']*2);	
			}
		}
		elseif($daysBefore<7)
		{
			foreach($initialInvoiceDetails['items'] as $iIDK=>$iIDV)
			{
				if($iIDV['type']=='placement' || $iIDV['type']=='ott' || $iIDV['type']=='ccs')
					$forfeit[]=array('type'=>$iIDV['type'],'desc'=>$iIDV['desc'],'amount'=>$iIDV['total']);
			
				if($iIDV['type']=='accomodation')
					$forfeit[]=array('type'=>$iIDV['type'],'desc'=>$iIDV['desc'],'amount'=>$iIDV['unit']);	
			}
		}
		else
		{
			foreach($initialInvoiceDetails['items'] as $iIDK=>$iIDV)
			{
				if($iIDV['type']=='placement' || $iIDV['type']=='ott' || $iIDV['type']=='ccs')
					$forfeit[]=array('type'=>$iIDV['type'],'desc'=>$iIDV['desc'],'amount'=>$iIDV['total']);
			}
		}
		
		return $forfeit;
}

function initialInvoiceAmountToForfeit($forfeitItems)
	{
		$amount=0;
		foreach($forfeitItems as $item)
			$amount +=$item['amount'];
		return add_decimal($amount);	
	}
	
function sha_cancellationData($id)
	{
		$student=getshaOneAppDetails($id);
		
		$result=array();
		//check if pending, partially paid or paid
		$initialInvoice=initialInvoiceByShaId($id);
		//see($initialInvoice);
		if(!empty($initialInvoice))
		{
			$total_amount=getInitialInvoiceAmount($initialInvoice['id']);
			$total_amount_paid=getInitialInvoiceAmountPaid($initialInvoice['id']);
		
			//check if student placed or not
			$checkIfStudentPlaced=checkIfStudentPlaced($id);
			if($checkIfStudentPlaced)
			{
					$date_cancellation=$student['date_cancelled'];
					$forfeit=initialInvoiceItemsToForfeit($id,$initialInvoice['id'],$date_cancellation);
					$forfeit_tobe_amount=initialInvoiceAmountToForfeit($forfeit);
					//see($forfeit);
			}
			else
			{
				$forfeit_tobe_amount=$total_amount_paid;
			}
			
			$result['invoice_id']=$initialInvoice['id'];
			$result['total_amount']=$total_amount;
			$result['amount_paid']=$total_amount_paid;
			$result['forfeited_tobe']=$forfeit_tobe_amount;
			
			if($checkIfStudentPlaced)
			{
				if($result['amount_paid']==$result['forfeited_tobe'])//paid equal
					$result['settle_type']='0';	
				if(($result['amount_paid']<$result['forfeited_tobe']) || $result['amount_paid']==0)//paid less or not paid
					$result['settle_type']='1';//due	
				if($result['amount_paid']>$result['forfeited_tobe'])//paid more
					$result['settle_type']='2';//refund
					
				$result['settle_amount']=abs($total_amount_paid-$forfeit_tobe_amount);		
			}
			else
			{
				$result['settle_type']='2';//refund
				if($result['amount_paid']==0)
					$result['settle_type']='0';
					
				$result['settle_amount']=$total_amount_paid;
			}

		}
		return $result;
	}
	
	function sha_cancellationDataProcess($id)
	{
		$sha_cancellationData=sha_cancellationData($id);
		if(!empty($sha_cancellationData))
		{
			$obj= &get_instance();
			$obj->load->model("invoice_model");
			$intialInvoice=$obj->invoice_model->sha_cancellationDataProcess($sha_cancellationData);
		}
	}
	
	function initialInvoiceCancelledData($invoice_id)
	{
			$obj= &get_instance();
			$obj->load->model("invoice_model");
			$intialInvoice=$obj->invoice_model->initialInvoiceCancelledData($invoice_id);
			return $intialInvoice;
	}
	
	
	function ongoingInvoiceItemCreater($from,$to)
	{
		$obj=& get_instance();
		$obj->load->model('invoice_model');
		$to=date('Y-m-d',strtotime($to));
		$pricingYearFrom=$obj->invoice_model->getPricingYearByDate($from);
		$pricingYearTo=$obj->invoice_model->getPricingYearByDate($to);
		
		$return=array();
		if($pricingYearFrom==$pricingYearTo)
		{
			$invoiceWeekDay=invoiceWeekDay($from,$to);
			$invoiceWeekDay['from']=$from;
			$invoiceWeekDay['to']=$to;
			$invoiceWeekDay['price_year']=$pricingYearFrom['year'];
			$return[]=$invoiceWeekDay;
		}
		else
		{
			$from1=$from;
			$to1=date('Y-m-d',strtotime($pricingYearTo['date'] .' - 1 day'));
			$from2=date('Y-m-d',strtotime($pricingYearTo['date']));
			$to2=$to;
			
			$invoiceWeekDay1=invoiceWeekDay($from1,$to1);
			$invoiceWeekDay1['from']=$from1;
			$invoiceWeekDay1['to']=$to1;
			$invoiceWeekDay1['price_year']=$pricingYearFrom['year'];
			$return[]=$invoiceWeekDay1;
			
			$invoiceWeekDay2=invoiceWeekDay($from2,$to2);
			$invoiceWeekDay2['from']=$from2;
			$invoiceWeekDay2['to']=$to2;
			$invoiceWeekDay2['price_year']=$pricingYearTo['year'];
			$return[]=$invoiceWeekDay2;
		}
		return $return;
	}
	
	function invoiceWeekDay($from,$to)
	{
		$dayDiff=dayDiff($from,$to);
		$weeks=($dayDiff/7);
		$weeks_only=(int)($dayDiff/7);
		$days=($dayDiff%7);
		
		return array('weeks'=>$weeks_only,'days'=>$days);
	}
	
	function addNewOngoingInvoice($booking_id)
	{
		$obj=& get_instance();
		$obj->load->model('invoice_model');
		
		$bookingDetails=bookingDetails($booking_id);
		if($bookingDetails['generate_ongInv']=='1')
			{
					$lastInvoice=$obj->invoice_model->getLastOngoingInvoiceByStudentId($bookingDetails['student']);
					if(!empty($lastInvoice))
					{
						//ongoing invoice block
						$from=date('Y-m-d',strtotime($lastInvoice['booking_to'].' + 1 day'));
					}
					else
					{
						//Initial invoice block
						$lastInvoice=initialInvoiceByShaId($bookingDetails['student']);
							
						$shaInitialInvoiceWeekDays=shaInitialInvoiceWeekDays($bookingDetails['student']);
						$OngoingInvoiceDate=date('Y-m-d',strtotime($bookingDetails['booking_from'].' + '.$shaInitialInvoiceWeekDays.' days'));
						$from=$OngoingInvoiceDate;
					}
					
					
					if($bookingDetails['booking_to']=='0000-00-00')
						$to=date('Y-m-d',strtotime($from.' +4 weeks -1 day'));
					else	
						{
							$dayDiff=dayDiff($from,$bookingDetails['booking_to']);
							//$dayDiff--;// dec 1 day as last day is checkout date
					
							if($dayDiff>28)
							{
								$to=date('Y-m-d',strtotime($from.' +4 weeks -1 day'));
								
								if($dayDiff<35)
									$to=$bookingDetails['booking_to'];
							}
							else	
								$to=$bookingDetails['booking_to'];
						}
					
					$items=ongInvItems($from,$to,$bookingDetails['student']);
					if(!empty($items))
					{
						$ongoingInvoice['application_id']=$bookingDetails['student'];
						$ongoingInvoice['from']=$from;
						$ongoingInvoice['to']=$to;
						$ongoingInvoice['items']=$items;
						//echo "1.".$bookingDetails['student']."<br>";
						//see($ongoingInvoice);
						$obj->invoice_model->addNewOngoingInvoice($ongoingInvoice);
					}
			}
	}
	
	function addNewOngoingInvoiceDirect($booking_id)
	{
		$obj=& get_instance();
		$obj->load->model('invoice_model');
		
		$bookingDetails=bookingDetails($booking_id);
		
		$from=$bookingDetails['booking_from'];
		
		if($bookingDetails['booking_to']=='0000-00-00')
			$to=date('Y-m-d',strtotime($from.' +4 weeks -1 day'));
		else	
			{
				$dayDiff=dayDiff($from,$bookingDetails['booking_to']);
				//$dayDiff--;// dec 1 day as last day is checkout date
		
				if($dayDiff>28)
				{
					$to=date('Y-m-d',strtotime($from.' +4 weeks -1 day'));
					
					if($dayDiff<35)
						$to=$bookingDetails['booking_to'];
				}
				else	
					$to=$bookingDetails['booking_to'];
			}
		
		$items=ongInvItems($from,$to,$bookingDetails['student']);
		if(!empty($items))
		{
			$ongoingInvoice['application_id']=$bookingDetails['student'];
			$ongoingInvoice['from']=$from;
			$ongoingInvoice['to']=$to;
			$ongoingInvoice['items']=$items;
			//echo "1.".$bookingDetails['student']."<br>";
			//see($ongoingInvoice);
			$obj->invoice_model->addNewOngoingInvoice($ongoingInvoice);
		}
	}
	
	function ongInvItems($from,$to,$student_id)
	{//see($from.' '.$to);
		$ongoingInvoiceItemCreater=ongoingInvoiceItemCreater($from,$to);
		//see($ongoingInvoiceItemCreater);
		$student=getShaOneAppDetails($student_id);
		$age=age_from_dob($student['dob']);
		
		if($student['accomodation_type']==1)
			  {
				  if($age<18)
					  $accomodation_type='Single Room 18-';
				  if($age>=18)
					  $accomodation_type='Single Room 18+';
			  }
		else if($student['accomodation_type']==2)
			  {
					  //$accomodation_type='Twin Share';
				  if($age<18)
					  $accomodation_type='Twin Share 18-';
				  if($age>=18)
					  $accomodation_type='Twin Share 18+';
			  }
		else if($student['accomodation_type']==3)					
				$accomodation_type='Self-Catered';		
		else if($student['accomodation_type']==4)					
				$accomodation_type='VIP Single Room';
		else if($student['accomodation_type']==5)					
				$accomodation_type='VIP Self-Catered';			
		
		$items=array();
		if(strtotime($from)<strtotime($to))
		{
		foreach($ongoingInvoiceItemCreater as $ong)
		{
					$item=array();
					
					$products=productsList($ong['price_year']);
					
					foreach($products as $p)
					{
						if($p['name']==$accomodation_type)
						{
							
							if($ong['weeks']!=0)
							{
								$item['desc']=$p['name'].' ('.date('d M Y',strtotime($ong['from'])).' to '.date('d M Y',strtotime($ong['from'] .' + '.$ong['weeks'].' weeks -1 day')).')';
								$item['qty_unit']='1';
								$item['qty']=$ong['weeks'];
								$item['unit']=$p['price'];
								$item['total']=add_decimal($p['price']*$item['qty']);
								//$item['gst']=$p['gst'];
								$item['xero_code']=$p['xero_code'];
								$item['type']='accomodation';
								$items[]=$item;
							}
							
							if($ong['days']!=0)
							{
								$item['desc']=$p['name'].' (';
								if($ong['days']>1)
									$item['desc'] .=date('d M Y',strtotime($ong['to'].' - '.$ong['days'].' days + 1 day')).' to ';
								$item['desc'] .=date('d M Y',strtotime($ong['to'])).')';
								$item['qty_unit']='2';
								$item['qty']=$ong['days'];
								$item['unit']=add_decimal($p['price']/7);
								$item['total']=add_decimal(($p['price']/7)*$item['qty']);
								//$item['gst']=$p['gst'];
								$item['xero_code']=$p['xero_code'];
								$item['type']='accomodation_ed';
								$items[]=$item;
							}
							
							break;
						}
						else
						continue;
					}
			}
	}
		return $items;
	}
	
	function ongoingInvoiceListTd($invoice,$initial_invoice_pageStatus)
	  {
		  //td1
		  $td1='<a href="'.site_url().'invoice/view_ongoing/'.$invoice['id'].'" target="_blank" data-placement="bottom" data-toggle="tooltip"  data-original-title="System invoice number">'.'I-'.$invoice['id'].'</a>';
		  if($invoice['moved_to_xero']==1)
			  $td1.='<br><a href="https://go.xero.com/AccountsReceivable/Edit.aspx?InvoiceID='.$invoice['xero_invoiceId'].'" target="_blank" data-placement="bottom" data-toggle="tooltip"  data-original-title="Xero invoice number">'.$invoice['invoice_number'].'</a>';
		  if($invoice['study_tour']=='0')
			  {
				  $bookingByShaId=bookingByShaId($invoice['application_id']);
				  if(!empty($bookingByShaId))
					  $td1 .='<br><a href="javascript:void(0);" data-placement="bottom" data-toggle="tooltip"  data-original-title="Booking id">'.$bookingByShaId['id'].'</a>';	
			  }	  
		  $td['td1']=$td1;								  
		  
		  //td4
		  $total_amount=0;
		  foreach($invoice['items'] as $item)
			  $total_amount +=$item['total'];
		  $td4='';  
		  if($initial_invoice_pageStatus=='0')
			{
				if($invoice['status']=='1')
					$td4.="<b style=' color:#e51c23; '>Pending</b>";
				elseif($invoice['status']=='2')
						$td4.="<b style=' color:#ff9800; '>Partially paid</b>";
				elseif($invoice['status']=='3')
						$td4.="<b style=' color:#8bc34a; '>Paid</b>";
				$td4.="<br>";				
			}
		  $td4 .='Total: $'.add_decimal($total_amount);
		  
		 if($invoice['status']=='1')
			{
				 $shaOngoingInvoiceWeekDays=shaOngoingInvoiceWeekDays($invoice['id']);
				 if($invoice['study_tour']==1)
					$shaOngoingInvoiceWeekDays=dayDiff($invoice['booking_from'],$invoice['booking_to']);
				  $getWeekNDays=getWeekNDays($shaOngoingInvoiceWeekDays);

				  if($initial_invoice_pageStatus!='0')
					{
						  $td4.="<br>Duration: ";
						  if(isset($getWeekNDays['week']))
								$td4.=$getWeekNDays['week'].' week'.s($getWeekNDays['week']).' ';
						  if(isset($getWeekNDays['day']))
								$td4.=$getWeekNDays['day'].' day'.s($getWeekNDays['day']);
					}
			}
		else
			{
				if($initial_invoice_pageStatus!='0')
					{
						$td4.="<br>Received: ";
						if($invoice['status']=='3')
							$td4.='$'.add_decimal($total_amount);
						else
						{
							$amount_paid=0;
							foreach($invoice['payments'] as $payment)
								$amount_paid +=$payment['amount_paid'];
							$td4.='$'.add_decimal($amount_paid);	
						}
				}
			}
			
		  $td4.='<br><span style="color:#b0b0b0;">Created: '.date('d M Y',strtotime($invoice['date'])).'</span>';
		  
		  //$td4.='<br>Due date: ';       	
							 
		 $td['td4']=$td4;
		 
		 //td office use
		 $td_officeUse='';
		 if($invoice['moved_to_xero']==1)
			  $td_officeUse .='<a href="https://go.xero.com/AccountsReceivable/View.aspx?InvoiceID='.$invoice['xero_invoiceId'].'" target="_blank" style="margin-right: 1px; margin-left: 1px;"><img src="'.static_url().'img/xero-icon.png" data-placement="bottom" data-toggle="tooltip"  data-original-title="Moved to xero: '.date('d M Y',strtotime($invoice['moved_to_xero_date'])).'" width="19"></a>';
											  
		  /*if(isset($invoice['items_standard']))
			  $td_officeUse .='<a href="'.site_url().'invoice/view_initial_student/'.$invoice['id'].'" target="_blank"><i class="font16 material-icons" data-placement="bottom" data-toggle="tooltip"  data-original-title="Separate student invoice available">face</i></a>';*/
											   
		   $td['td_officeUse']=$td_officeUse;                                     
		 
		 if($invoice['study_tour']!='0')
		     $td['td_officeUse'] .='<a href="javascript:void(0);" target="_blank" ><i class="font16 material-icons" data-placement="bottom" data-toggle="tooltip"  data-original-title="Tour group invoice">stars</i></a>';
		 
		  return $td;                               
	  }
	  
	  function getOngoingInvoiceIdFromInvoiceNumber($invoiceNumber)
	  {
		  $obj= &get_instance();
		  $obj->load->model("xero_model");
		  $invoice=$obj->xero_model->getOngoingInvoiceIdFromInvoiceNumber($invoiceNumber);
		  return $invoice;
	  }
	  
	  function getOngoingInvoicePaymentsCount($invoiceId)
	  {
		  $payments=getOngoingInvoicePayments($invoiceId);
		  return count($payments);
	  }
	  
	  function getOngoingInvoicePayments($invoiceId)
	  {
		  $obj= &get_instance();
		  $obj->load->model("xero_model");
		  $payments=$obj->xero_model->getOngoingInvoicePayments($invoiceId);
		  return $payments;
	  }
	  
	  function ongoingInvoiceDetails($invoiceId)
	  {
	  $obj= &get_instance();
	  $obj->load->model("invoice_model");
	  $intialInvoice=$obj->invoice_model->ongoingInvoiceDetails($invoiceId);
	  return $intialInvoice;
	  }
	  
	  function deleteXeroInvoice($InvoiceNumber)
	  {
	  	  $obj= &get_instance();
		  $obj->load->library('xero');
		  $invoice_result = $obj->xero->Invoices($InvoiceNumber);
		  $invoiceStatus=$invoice_result->Invoices->Invoice->Status;
		  if($invoiceStatus=='DRAFT')
			  $status='DELETED';
		  elseif($invoiceStatus=='AUTHORISED')
			  $status='VOIDED';
			if(isset($status))
			{
				$new_invoice = array(
					array(
						"InvoiceNumber"=>$InvoiceNumber,
						"Status" => $status
					)
				);
			  $invoice_result = $obj->xero->Invoices($new_invoice);
			}
	  }
	  
	  
	  function generatePoWeekly($date)
	  {
		  $day=date('D',strtotime($date));
		  if($day=='Fri')
		  {
			  $obj= &get_instance();
			  $bookings=po_bookings($date);//see($bookings);
			  $po_structure=array();
			  foreach($bookings as $booking)
				  $po_structure[]=po_structure($booking['id']);
			  
			  $poNextOngoing=poNextOngoing($date);
			  foreach($poNextOngoing as $PON)
			  {
				  $obj->load->model('po_model');
				  $obj->po_model->changeBookingStatusToProgressive($PON['booking_id']);
				  $po_structure_next=po_structure($PON['booking_id'],$PON);
				  if(!empty($po_structure_next))
					  $po_structure[]=$po_structure_next;
			  }
			  
			 /* see($bookings);
			  see($poNextOngoing);*/
			  //see($po_structure);
			  if(!empty($po_structure))
			  {
				  $obj->load->model('Po_model');
				  $bookings=$obj->Po_model->insertGeneratedPo($po_structure);
			  }
		  }
		  else
			  echo "notFriday";
	  }
	  
	 function po_bookings($date)
	{
		$obj= &get_instance();
		$obj->load->model('Po_model');
		
		$type='initial';
		$dateDuration=getPoDateByPoCreateDate($date,$type);//see($dateDuration);
		$bookings=$obj->Po_model->po_bookingsByDateDuration($dateDuration);
		return $bookings;
	}
	
	 function poNextOngoing($date)
	{
		$obj= &get_instance();
		$obj->load->model('Po_model');
		
		$type='ongoing';
		$dateDuration=getPoDateByPoCreateDate($date,$type);//see($dateDuration);
		$bookings=$obj->Po_model->poNextOngoing($dateDuration);
		return $bookings;
	}
	
	function getPoDateByPoCreateDate($date,$type)
	{
		/*$dateFrom=date('Y-m-d',strtotime($date.' previous Thursday  previous Thursday previous Thursday'));
		$dateTo=date('Y-m-d',strtotime($dateFrom.' next wednesday'));*/
		
		if($type=='initial')
		{
			$dateFrom=date('Y-m-d',strtotime($date.' previous Thursday  previous Thursday'));
			$dateTo=date('Y-m-d',strtotime($dateFrom.' next wednesday'));
		}
		else
		{
			$dateFrom=date('Y-m-d',strtotime($date.' + 7 days'));
			$dateTo=date('Y-m-d',strtotime($dateFrom.' next thursday'));
		}
		return array('dateFrom'=>$dateFrom,'dateTo'=>$dateTo);
	}
	
	function po_structure($booking_id,$nextOngoing=0)
	{
		$bD=bookingDetails($booking_id);
		$student=getShaOneAppDetails($bD['student']);
		if($student['study_tour_id']==0)
		{
			$obj= &get_instance();
			$obj->load->helper('po_helper');
			$po_structureNew=po_structureNew($booking_id,$nextOngoing);
			return $po_structureNew;
		}
		else
		{
				$bookingDetails=bookingDetails($booking_id);
				//see($bookingDetails);
				
				//Accomodation type
				$accomodation_type=po_structure_accomodationType($bookingDetails);
				
				//Getting the duration of PO
				$po_from=$bookingDetails['booking_from'];
				if($nextOngoing!=0)
				{
						//$po_from=$nextOngoing['to'];
						$po_from=date('Y-m-d',strtotime($nextOngoing['to'].' +1 day'));
						
						$moveOutDate=$bookingDetails['moveout_date'];
						if($moveOutDate=='0000-00-00')
							$moveOutDate=$bookingDetails['booking_to'];
						if(strtotime($moveOutDate) <	$po_from && $moveOutDate!='0000-00-00')
							return array();
				}
						
				$po_to=date('Y-m-d',strtotime($po_from.' + 4 weeks -1 day'));
				
				$po_endDate=$bookingDetails['moveout_date'];
				if($po_endDate=='0000-00-00')
					$po_endDate=$bookingDetails['booking_to'];
				if(strtotime($po_to) > strtotime($po_endDate) && $po_endDate!='0000-00-00')
					$po_to=$po_endDate;			
				
				if(strtotime($po_from) >= strtotime($po_to))//in case if booking end date ahs arrived and we cannot create next PO
					return array();
				//
		
				$po_structure=po_structure2ndPart($po_from,$po_to,$accomodation_type,$bookingDetails,$nextOngoing);
				return $po_structure;
		}
	}
	
	function po_structure_accomodationType($bookingDetails)
	{
		$student=getshaOneAppDetails($bookingDetails['student']);
		$age=age_from_dob($student['dob']);
		if($student['accomodation_type']==1 && $age<18)
			$accomodation_type='Single Room 18-';
		elseif($student['accomodation_type']==1 && $age>=18)
			$accomodation_type='Single Room 18+';
		else if($student['accomodation_type']==2)
		{
			//$accomodation_type='Twin Share';
			if($age<18)
				$accomodation_type='Twin Share 18-';
			if($age>=18)
				$accomodation_type='Twin Share 18+';
		}
		else if($student['accomodation_type']==3)
			$accomodation_type='Self-Catered';
		else if($student['accomodation_type']==4)
			$accomodation_type='VIP Single Room';
		else if($student['accomodation_type']==5)
			$accomodation_type='VIP Self-Catered';
		
		return $accomodation_type;
	}
	
	function po_structure2ndPart($po_from,$po_to,$accomodation_type,$bookingDetails,$nextOngoing)
	{
		$stud=getShaOneAppDetails($bookingDetails['student']);
		if($stud['study_tour_id']==0)
		{
			$obj= &get_instance();
			$obj->load->helper('po_helper');
			$po_structure2ndPartNew=po_structure2ndPartNew($po_from,$po_to,$accomodation_type,$bookingDetails,$nextOngoing);
			return $po_structure2ndPartNew;
		}
		else
		{
			$ongoingInvoiceItemCreater=ongoingInvoiceItemCreater($po_from,$po_to);
			//see($ongoingInvoiceItemCreater);
			
			$student=getshaOneAppDetails($bookingDetails['student']);
			$studentNo='';
			if($student['sha_student_no']!='')
				$studentNo=' - '.$student['sha_student_no'];
			$bookingInfoForItems=$bookingDetails['id'].', '.$student['fname'].' '.$student['lname'].$studentNo.', ';
	
			$item=array();
			$po_structure=array();
			$po_structure['booking_id']=$bookingDetails['id'];
			$po_structure['po_from']=$po_from;
			$po_structure['po_to']=$po_to;
			
			$po_structure['initial']='1';
			if($nextOngoing!=0)
					$po_structure['initial']='0';
			
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
			
			///////Administration fee #STARTS  #commented because we dont want admin fee for study tour bookings
			/*$accomodationAmount=0;
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
				if($po_structure['initial']=='1')
				{
					$poDuration=dayDiff($po_from,$po_to);
					if($poDuration<=21)
						$percent=5;
					else
						$percent=10;	
					$itemAdminFee['desc'] .=' ('.$percent.'% on Accomodation fee)';
					$itemAdminFee['qty_unit']='3';//percent
					$itemAdminFee['unit']=$percent;
					$itemAdminFee['total']=$itemAdminFee['unit'];
				}
				else
				{
					$itemAdminFee['desc'] .=' ($10 flat)';
					$itemAdminFee['qty_unit']='4';//flat
					$itemAdminFee['unit']=10;
					$itemAdminFee['total']=$itemAdminFee['unit'];
				}
				
				$items[]=$itemAdminFee;
			}
			*/
			/////////Administration fee #ENDS
			
			$po_structure['items']=$items;
			return $po_structure;
		}
	}
	
	function poAmount($id)
	{
		$obj= &get_instance();
		$obj->load->model('po_model');
		$items=$obj->po_model->poItems($id);
	
		$total_amount=0;
			
		$getPoAdminFee=getPoAdminFee($items);
		foreach($items as $item)
		{
			$adminFeeInPercent=false;
			if($item['type']=='adminFee' && $item['qty_unit']=='3')
				$adminFeeInPercent=true;
															
			if($adminFeeInPercent)	
				$total_amount -=$getPoAdminFee;
			elseif($item['type']=='adminFee' && $item['qty_unit']=='4')
					$total_amount -=$item['total'];
			else
				$total_amount +=$item['total'];
		}	
			
		return add_decimal($total_amount);
	}

	
	function poListTd($po,$pageStatus)
	{
		//td1
		$td1='<a href="'.site_url().'purchase_orders/view/'.$po['id'].'" target="_blank" data-placement="bottom" data-toggle="tooltip"  data-original-title="System PO number">'.'PO-'.$po['id'].'</a>';
		if($po['moved_to_xero']==1)
			$td1.='<br><a href="https://go.xero.com/AccountsPayable/Edit.aspx?InvoiceID='.$po['po_id_xero'].'" target="_blank" data-placement="bottom" data-toggle="tooltip"  data-original-title="Open in Xero">Xero</a>';
		$td['td1']=$td1;								  
		
		//td4
		
		if($po['status']==1)
		{
			$amountColor='#e51c23';
			$amountTootip='Pending';
		}
		elseif($po['status']==3)
		{
			$amountColor='#ff9800';
			$amountTootip='Partially paid';
		}
		else	
		{
			$amountColor='#8bc34a';
			$amountTootip='Paid';
		}
		$td4='<b style=" color:'.$amountColor.'" data-placement="left"  data-toggle="tooltip"  data-original-title="'.$amountTootip.'">$'.poAmount($po['id']).'</b>';
		$td4.='<br>Due date: '.date('d M Y',strtotime($po['due_date']));
		$td['td4']=$td4;
	   
	   //td office use
	   $td_officeUse='';
	   if($po['moved_to_xero']==1)
			$td_officeUse .='<a href="https://go.xero.com/AccountsPayable/View.aspx?InvoiceID='.$po['po_id_xero'].'" target="_blank" style="margin-right: 1px; margin-left: 1px;"><img src="'.static_url().'img/xero-icon.png" data-placement="bottom" data-toggle="tooltip"  data-original-title="Moved to xero: '.date('d M Y',strtotime($po['moved_to_xero_date'])).'" width="19"></a>';
			
		$bankAlert=false;	
		$bankDetails=getHfaTwoAppDetailsBank($po['host']);
		if(!empty($bankDetails))
			{
				  if(trim($bankDetails['acc_no'])=='' || trim($bankDetails['bsb'])=='')
					  $bankAlert=true;
			}
		else
			$bankAlert=true;
		
		if($bankAlert)	
			$td_officeUse .='<span class="colorBlue" data-placement="bottom" data-toggle="tooltip"  data-original-title="Enter bank details in host family profile"><i class="fa fa-bank"></i></span>';								
		
		 if($po['initial']==1)
			$td_officeUse .='<a class="colorBlue" data-placement="bottom" data-toggle="tooltip"  data-original-title="Initial PO"><i class="material-icons">looks_one</i></a>';								
		
		 if($po['study_tour_id']!=0 /*&& $pageStatus=='all'*/)
			$td_officeUse .='<a class="colorBlue" data-placement="bottom" data-toggle="tooltip"  data-original-title="Tour group PO"><i class="material-icons">stars</i></a>';								
			
		$bookingDetails=bookingDetails($po['booking_id']);
		if($po['status']!='2' && $bookingDetails['hold_payment']=='1')
			$td_officeUse .='<a class="colorOrange" data-placement="bottom" data-toggle="tooltip"  data-original-title="Hold payment"><i class="material-icons">money_off</i></a>';																
			
		$td['td_officeUse']=$td_officeUse;                                     
	   
		return $td;                               
	}
	
function getPOPayments($invoiceId)
{
	$obj= &get_instance();
	$obj->load->model("xero_model");
	$payments=$obj->xero_model->getPOPayments($invoiceId);
	return $payments;
}

function getPOPaymentsCount($invoiceId)
{
	$payments=getPOPayments($invoiceId);
	return count($payments);
}

function getGroupInvStructure($clients,$year)
{
	foreach($clients as $cK=>$client)
	{
		$clients[$cK]['invoice']=array();
		$clients[$cK]['invoice']['items']=array();
		$products=clientProductsList($client['id'],$year);
		//see($products);
		
		$placement_fee=$apu_fee=array();
		foreach($products as $p)
		{
			if($client['group_invoice_placement_fee']=='1')
			{
				if($p['name']=='Placement fee')
					{
						$placement_fee['desc']='Placement fee';
						$placement_fee['qty_unit']='0';
						$placement_fee['qty']=1;
						$placement_fee['unit']=$p['price'];
						$placement_fee['total']=$placement_fee['qty']*$p['price'];
						$placement_fee['gst']='1';
						$placement_fee['type']='placement';
						$placement_fee['xero_code']=$p['xero_code'];	
					}
			}
			
			if($client['group_invoice_apu']=='1')
			{
				if($p['name']=='Airport Pickup Service')
					{
						$apu_fee['desc']=$p['name'];
						$apu_fee['qty_unit']='0';
						$apu_fee['qty']=1;
						$apu_fee['unit']=add_decimal($p['price']);
						$apu_fee['total']=$apu_fee['qty']*add_decimal($p['price']);
						$apu_fee['gst']=$p['gst'];
						$apu_fee['type']='apu';
						$apu_fee['xero_code']=$p['xero_code'];
					}
			}
		}
		
		if(isset($client['bookings']))
		{
			foreach($client['bookings'] as $cS)
			{
				if(!empty($placement_fee))
				{
					$placement_fee['booking_id']=$cS['id'];
					$placement_fee['sha_id']=$cS['student'];
					$placement_fee['from']=$cS['booking_from'];
					$placement_fee['to']='';
					$clients[$cK]['invoice']['items'][]=$placement_fee;
				}
				
				$studentTwo=getShaTwoAppDetails($cS['student']);
				if(!empty($apu_fee) && $studentTwo['airport_pickup']==1)
				{
					$apu_fee['booking_id']=$cS['id'];
					$apu_fee['sha_id']=$cS['student'];
					$apu_fee['from']=$cS['booking_from'];
					$apu_fee['to']='';
					$clients[$cK]['invoice']['items'][]=$apu_fee;
				}
				
				if($client['group_invoice_accomodation_fee']=='1')
				{
					$duration['booking_from']=$cS['booking_from'];
					$duration['booking_to']=date('Y-m-d',strtotime($cS['booking_from'].' + 4 weeks -1 day'));
					$getGroupInvoiceAccomodationFee=getGroupInvoiceAccomodationFee($products,$cS,$duration);
					if(!empty($getGroupInvoiceAccomodationFee))
					{
						foreach($getGroupInvoiceAccomodationFee as $aF)
							$clients[$cK]['invoice']['items'][]=$aF;
					}
				}
				
			}
		}
		
		if(isset($client['bookings_ong']))
		{
			foreach($client['bookings_ong'] as $cSOng)
			{
				foreach($cSOng as $on)
				{
					$yearOn=date('Y',strtotime($on['paid_till'].' + 1 day'));
					$productsOn=clientProductsList($on['client'],$yearOn);
					$bookingOn=bookingDetails($on['booking_id']);
					$durationOn['booking_from']=date('Y-m-d',strtotime($on['paid_till'].' + 1 day'));
					$durationOn['booking_to']=date('Y-m-d',strtotime($on['paid_till'].' + 4 weeks'));
					$getGroupInvoiceAccomodationFeeOn=getGroupInvoiceAccomodationFee($productsOn,$bookingOn,$durationOn);
					if(!empty($getGroupInvoiceAccomodationFeeOn))
					{
						foreach($getGroupInvoiceAccomodationFeeOn as $aFOn)
							$clients[$cK]['invoice']['items'][]=$aFOn;
					}	
				}
			}
		}
	}
	return $clients;
}

function getGroupInvoiceAccomodationFee($products,$booking,$duration)
{
	  $accomodation_fee=array();
	  $invDur=array();
	  if(strtotime($duration['booking_from'])>=strtotime($booking['booking_from']) && (strtotime($duration['booking_from'])<=strtotime($booking['booking_to']) || $booking['booking_to']=='0000-00-00'))
	  {
		  $invDur['booking_from']=$duration['booking_from'];
		  
		  if(strtotime($duration['booking_to']) <= strtotime($booking['booking_to']) || $booking['booking_to']=='0000-00-00')
			  $invDur['booking_to']=$duration['booking_to'];
		  else
			  $invDur['booking_to']=$booking['booking_to'];  
	  }
	  
	  if(!empty($invDur))
	  {
		$student=getShaOneAppDetails($booking['student']);
		$age=age_from_dob($student['dob']);
		$dayDiff=dayDiff($invDur['booking_from'],$invDur['booking_to']);
		$weeks_only=(int)($dayDiff/7);
		$days=($dayDiff%7);
	  
		$product=array();
		foreach($products as $p)
			  {
						if($student['accomodation_type']==1)
							{
								if($p['name']=='Single Room 18-' && $age<18)
									$product=$p;
								if($p['name']=='Single Room 18+' && $age>=18)
									$product=$p;
							}
							else if($student['accomodation_type']==2)
							{
								if($p['name']=='Twin Share 18-' && $age<18)
									$product=$p;
								if($p['name']=='Twin Share 18+' && $age>=18)
									$product=$p;
							}
							else if($student['accomodation_type']==3)
							{
								if($p['name']=='Self-Catered')
									$product=$p;
							}
							else if($student['accomodation_type']==4)
							{
								if($p['name']=='VIP Single Room')
									$product=$p;
							}
							else if($student['accomodation_type']==5)
							{
								if($p['name']=='VIP Self-Catered')
									$product=$p;
							}
			  }
			  
			  if($weeks_only!=0)
			  {
			  	$accomodation_fee['accomodation_fee']=groupInvAccomodation_feeArray($product,$weeks_only);
			  	$accomodation_fee['accomodation_fee']['from']=$invDur['booking_from'];
			  	$accomodation_fee['accomodation_fee']['to']=date('Y-m-d',strtotime($invDur['booking_from'].' + '.$weeks_only.' weeks -1 day'));
				
				$accomodation_fee['accomodation_fee']['booking_id']=$booking['id'];
				$accomodation_fee['accomodation_fee']['sha_id']=$booking['student'];
			  }
			  if($days!=0)
			  {
					$accomodation_fee['accomodation_fee_ed']=groupInvAccomodation_fee_edArray($product,$days);
					
					if($weeks_only==0)
						$accomodation_fee['accomodation_fee_ed']['from']=$invDur['booking_from'];
					else
						$accomodation_fee['accomodation_fee_ed']['from']=date('Y-m-d',strtotime($accomodation_fee['accomodation_fee']['to'].' + 1 day'));
			  		
					$accomodation_fee['accomodation_fee_ed']['to']=$invDur['booking_to'];
					
					$accomodation_fee['accomodation_fee_ed']['booking_id']=$booking['id'];
					$accomodation_fee['accomodation_fee_ed']['sha_id']=$booking['student'];
				}
		}
	return $accomodation_fee;
}

function groupInvAccomodation_feeArray($p,$weeks)
	{
		$accomodation_fee=array();
		$accomodation_fee['desc']=$p['name'];
		$accomodation_fee['qty_unit']='1';
		$accomodation_fee['qty']=$weeks;
		$accomodation_fee['unit']=$p['price'];
		$accomodation_fee['total']=add_decimal($p['price']*$weeks);
		$accomodation_fee['gst']=$p['gst'];
		$accomodation_fee['type']='accomodation';
		$accomodation_fee['xero_code']=$p['xero_code'];
		return $accomodation_fee;
	}
	
	function groupInvAccomodation_fee_edArray($p,$days)
	{
		$accomodation_fee=array();
		$accomodation_fee['desc']=$p['name'];
		$accomodation_fee['qty_unit']='2';
		$accomodation_fee['qty']=$days;
		$accomodation_fee['unit']=add_decimal($p['price']/7);
		$accomodation_fee['total']=add_decimal(($p['price']/7)*$days);
		$accomodation_fee['gst']=$p['gst'];
		$accomodation_fee['type']='accomodation_ed';
		$accomodation_fee['xero_code']=$p['xero_code'];
		return $accomodation_fee;
	}	

function initialGroupInvoiceListTd($invoice,$initial_invoice_pageStatus)
{
	//td1
	$td1='<a href="'.site_url().'group_invoice/view/'.$invoice['id'].'" target="_blank" data-placement="bottom" data-toggle="tooltip"  data-original-title="System invoice number">'.'G-'.$invoice['id'].'</a>';
    if($invoice['moved_to_xero']==1)
		$td1.='<br><a href="https://go.xero.com/AccountsReceivable/Edit.aspx?InvoiceID='.$invoice['xero_invoiceId'].'" target="_blank" data-placement="bottom" data-toggle="tooltip"  data-original-title="Xero invoice number">'.$invoice['invoice_number'].'</a>';
	
	$td['td1']=$td1;
	
	//td invoice details
	$td_invDetails='';
	$total_amount=0;
	foreach($invoice['items'] as $item)
		$total_amount +=$item['total'];
		
	if($initial_invoice_pageStatus=='0')
	{
		if($invoice['status']=='1')
			$td_invDetails.="<b style=' color:#e51c23; '>Pending</b>";
		elseif($invoice['status']=='2')
				$td_invDetails.="<b style=' color:#ff9800; '>Partially paid</b>";
		elseif($invoice['status']=='3')
				$td_invDetails.="<b style=' color:#8bc34a; '>Paid</b>";
		$td_invDetails.="<br>";				
	}	
	$td_invDetails .='Total: $'.add_decimal($total_amount);
	
	if($invoice['status']!='1' && $initial_invoice_pageStatus!='0')
	{
			$td_invDetails.="<br>Received: ";
			if($invoice['status']=='3')
				$td_invDetails.='$'.add_decimal($total_amount);
			else
			{
				$amount_paid=0;
				foreach($invoice['payments'] as $payment)
					$amount_paid +=$payment['amount_paid'];
				$td_invDetails.='$'.add_decimal($amount_paid);	
			}	
	}
	
	$td_invDetails.='<br><span style="color:#b0b0b0;">Created: '.date('d M Y',strtotime($invoice['date'])).'</span>';
	$td['td_invDetails']=$td_invDetails;
	
	//td office use
   $td_officeUse='';
   if($invoice['moved_to_xero']==1)
		$td_officeUse .='<a href="https://go.xero.com/AccountsReceivable/View.aspx?InvoiceID='.$invoice['xero_invoiceId'].'" target="_blank" style="margin-right: 1px; margin-left: 1px;"><img src="'.static_url().'img/xero-icon.png" data-placement="bottom" data-toggle="tooltip"  data-original-title="Moved to xero: '.date('d M Y',strtotime($invoice['moved_to_xero_date'])).'" width="19"></a>';
	if($invoice['imported']==1)
	$td_officeUse .='<a href="javascript:void(0);"  class=""><i class="colorBlue fa fa-upload" data-placement="bottom" data-toggle="tooltip"  data-original-title="Imported invoice"></i></a>';
		
   $td['td_officeUse']=$td_officeUse;
   
   return $td;
}

function groupInvoiceDetails($invoiceId)
{
	$obj= &get_instance();
	$obj->load->model("group_invoice_model");
	$intialInvoice=$obj->group_invoice_model->initialInvoiceDetails($invoiceId);
	return $intialInvoice;
}

function getGroupInvoicePayments($invoiceId)
{
	$obj= &get_instance();
	$obj->load->model("group_invoice_model");
	$payments=$obj->group_invoice_model->getInitialInvoicePayments($invoiceId);
	return $payments;
}

function getGroupInvoicePaymentsCount($invoiceId)
{
	$payments=getGroupInvoicePayments($invoiceId);
	return count($payments);
}

function getPoAdminFee($items)
{
	$accomodationTotal=$adminFeeQtyUnit=$adminFeeUnit=0;
	foreach($items as $item)
	{
		if(in_array($item['type'],array('accomodation','accomodation_ed')))
			$accomodationTotal +=$item['total'];
		elseif($item['type']=='adminFee')
		{	
			$adminFeeUnit=$item['unit'];
			$adminFeeQtyUnit=$item['qty_unit'];
		}
	}
	
	if($adminFeeQtyUnit=='3')
		{
			$adminFee=($adminFeeUnit*$accomodationTotal)/100 ;
		}
	else
		$adminFee=$adminFeeUnit;
	
	return 	$adminFee;
}

function manageCGTd($cg)
{
	$html['td1']='<a href="javascript:void(0);">'.$cg['fname'].' '.$cg['lname'].'</a>';
    if($cg['email']!='')
		{
    		$html['td1'] .='<br>';
        	$html['td1'] .='<a class="mailto" href="mailto:'.$cg['email'].'">'.$cg['email'].'</a>';
        }
     if($cg['phone']!='')
	 	{
        	$html['td1'] .='<br>';
            $html['td1'] .=$cg['phone'];
     	}
	
	return $html;	
}

function poPaymentDetails($id)
{
	$obj= &get_instance();
	$obj->load->model("po_model");
	return $obj->po_model->poPaymentDetails($id);
}

function generate2ndPo($date)
	  {
			  $po_structure=array();
			  
			  $obj= &get_instance();
			  $obj->load->model('po_model');
			  $poNextOngoing=$obj->po_model->generate2ndPoFind1stPo($date);//echo $obj->db->last_query();
			  foreach($poNextOngoing as $PON)
			  {
				  $obj->load->model('po_model');
				  $ongPos=$obj->po_model->checkIfBookingHaveOngPos($PON['booking_id']);//echo $obj->db->last_query();
				  if(!$ongPos)
				  {
					  $obj->po_model->changeBookingStatusToProgressive($PON['booking_id']);
					  $po_structure_next=po_structure($PON['booking_id'],$PON);
					  if(!empty($po_structure_next))
						  $po_structure[]=$po_structure_next;
				  }
			  }
			  
			 /* see($bookings);
			  see($poNextOngoing);*/
			  see($po_structure);
			  if(!empty($po_structure))
			  {
				  $obj->load->model('Po_model');
				  $bookings=$obj->Po_model->insertGeneratedPo($po_structure);
			  }
		}
?>