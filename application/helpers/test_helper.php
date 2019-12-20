<?php

function addNewOngoingInvoice11($booking_id)
	{
		$obj=& get_instance();
		$obj->load->model('invoice_model');
		
		$bookingDetails=bookingDetails($booking_id);
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
				
			$shaInitialInvoiceWeekDays=shaInitialInvoiceWeekDays11($bookingDetails['student']);
			$OngoingInvoiceDate=date('Y-m-d',strtotime($bookingDetails['booking_from'].' + '.$shaInitialInvoiceWeekDays.' days'));
			$from=$OngoingInvoiceDate;
		}
		echo $bookingDetails['booking_from'].' + '.$shaInitialInvoiceWeekDays.'  =  '.$from;
		
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
			see($ongoingInvoice);
			//$obj->invoice_model->addNewOngoingInvoice($ongoingInvoice);
		}
	}
	
	
	
	
function shaInitialInvoiceWeekDays11($id)
{
			$obj= &get_instance();
			$obj->load->helper('product');
			$initialInvoice=initialInvoiceByShaId($id);
			$initialInvoiceDetails=initialInvoiceDetails($initialInvoice['id']);
			
			$days=0;
			if(!empty($initialInvoiceDetails))
			{
				foreach($initialInvoiceDetails['items'] as $item)
				{
					if($item['type']=='accomodation')
						$days +=$item['qty']*7;
					
					if($item['type']=='accomodation_ed')
						$days +=$item['qty'];
				}
			}
			return $days;
}