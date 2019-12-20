<?php
class Cron extends CI_Controller {
	
		function __construct()
		{
			parent::__construct();
			$this->load->model('cron_model');
			$this->load->model('invoice_model');
			$this->load->helper('product_helper');
		}
		
		function emailTest()
		{
			//echo date('Y-m-d H:i:s');
		}
		
		function hfaToUnavailable()
		{
			$this->emailTest();
			$this->cron_model->hfaToUnavailable();
		}
		
		function hfaUnavailableToApproved()
		{
			$this->emailTest();
			$this->cron_model->hfaUnavailableToApproved();
		}
		
		
		function bookingArrived()
		{
			$this->emailTest();
			//$this->cron_model->bookingArrived();
		}
		
		function bookingMovedOut()
		{
			$this->emailTest();
			$this->cron_model->bookingMovedOut();
		}
		
		
		function generateOngoingInvoices()
		{
			$this->emailTest();
			$date=date('Y-m-d',strtotime('+2 week'));
			//$date='2018-11-15';
			$bookings=$this->cron_model->ongoingBooking($date);
			//see($bookings);
			
			$currentBookings=array();
			foreach($bookings as $booking)
			{
					$getShaOneAppDetails=getShaOneAppDetails($booking['student']);
					$client_id=$getShaOneAppDetails['client'];
					$clientDetail=clientDetail($client_id);
					if($clientDetail['group_invoice']=='1')
						continue;
						
					$lastInvoice=$this->invoice_model->getLastOngoingInvoiceByStudentId($booking['student']);
					if(!empty($lastInvoice))
					{
						if($lastInvoice['study_tour']=='1')
							continue;
						//ongoing invoice block
						if(strtotime($lastInvoice['booking_to'])<=strtotime($date))
						{
							addNewOngoingInvoice($booking['id']);
							$currentBookings[]=$booking;
						}
						else
							continue;
					}
					else
					{
						//Initial invoice block
						$lastInvoice=initialInvoiceByShaId($booking['student']);
						if($lastInvoice['study_tour']=='1')
							continue;
						$shaInitialInvoiceWeekDays=shaInitialInvoiceWeekDays($booking['student']);
						$OngoingInvoiceDate=date('Y-m-d',strtotime($booking['booking_from'].' + '.$shaInitialInvoiceWeekDays.' days'));
						//echo $booking['student'];see($OngoingInvoiceDate);
						//if(((strtotime($lastInvoice['booking_to'])<=strtotime($date) && $lastInvoice['booking_to']!='0000-00-00') || ($lastInvoice['booking_to']=='0000-00-00' && strtotime($booking['booking_from'].' +4 weeks')<=strtotime($date))) && $lastInvoice['cancelled']=='0')
						if($OngoingInvoiceDate==$date)
						{
							addNewOngoingInvoice($booking['id']);//echo '  done';
							$currentBookings[]=$booking;
						}
						else
							continue;
					}
			}
			
			see($currentBookings);
			
		}
		
		function generateOngoingInvoicesDirect()
		{
			$this->emailTest();
			$date=date('Y-m-d');
			$bookings=$this->cron_model->ongoingBookingDirect($date);
			see($bookings);
			foreach($bookings as $booking)
			{
				addNewOngoingInvoiceDirect($booking['id']);
			}
		}
		
		
		function generatePoWeekly()
		{//die(0);
			//$this->emailTest();
			$date=date('Y-m-d');
			//$date='2019-08-16';
			//$date='2019-08-02';
			generatePoWeekly($date);
		}
		
		function revisitRequired()
		{
			$this->emailTest();
			$date=date('Y-m-d');
			//$date='2018-05-18';
			$this->cron_model->revisitRequired($date);
		}
		
		function generateOngoingInvoicesSTour()
		{
			$this->emailTest();
			$date=date('Y-m-d',strtotime('+2 week'));
			
			$initialInvoices=$this->cron_model->initialInvoiceEndingWithDate($date);
			$ongoingInvoices=$this->cron_model->ongoingInvoiceEndingWithDate($date);
			$initialInvoices=array_merge($initialInvoices,$ongoingInvoices);
			//see($initialInvoices);
			
			$duration['from']=date('Y-m-d',strtotime($date.' + 1 day'));
			$duration['to']=date('Y-m-d',strtotime($date.' + 4 weeks'));
			$tours=array();
			foreach($initialInvoices as $invoice)
			{
				$application=array();
				$prevItemAppId='';
				$prevItemDesc='';
				
				foreach($invoice['items'] as $itemK => $item)
				{
					if($item['type']=='accomodation' || $item['type']=='accomodation_ed')
					{
						if($item['type']=='accomodation_ed')
						{
							$currentItemAppId=$item['application_id'];
							$prevItemDescArray=explode('(',$prevItemDesc);
							$currentItemDescArray=explode('(',$item['desc']);
							
							if($prevItemAppId==$currentItemAppId)
							{
								$datesCurrent=explode('to',getTextBetweenBrackets($item['desc']));
								$datesPrev=explode('to',getTextBetweenBrackets($prevItemDesc));
								end($application);         // move the internal pointer to the end of the array
								$keyApp = key($application);
								$application[$keyApp]['dates']=$datesPrev[0].'to ';
								if(isset($datesCurrent[1]))
									$application[$keyApp]['dates'] .=trim($datesCurrent[1]);
								else	
									$application[$keyApp]['dates'] .=trim($datesCurrent[0]);
							}
						}
						else
						{
							$app['application_id']=$item['application_id'];
							$app['dates']=getTextBetweenBrackets($item['desc']);
							$application[]=$app;
						}
						$prevItemAppId=$item['application_id'];
						$prevItemDesc=$item['desc'];
					}
				}
				$tour['tour_id']=$invoice['application_id'];
				$tour['applications']=$application;
				$tour['initial_invoice']=$invoice['initial_invoice'];
				$tours[]=$tour;
			}
			//see($tours);
			
			foreach($tours as $tourK=>$tour)
			{
				foreach($tour['applications'] as $appK=>$app)
				{
					$dates=datesFromText($app['dates']);
					$bookingDetails=bookingByShaId($app['application_id']);
					if(!empty($bookingDetails))
					{
						$from=date('Y-m-d',strtotime($dates['to'].' + 1 day'));
						
						//If last invoice was initial invoice then we have to calculate the start date of the ongoing invoice from the booking
						if($tour['initial_invoice']=='1')
						  {	
						  	$shaInitialInvoiceWeekDays=tourInitialInvoiceWeekDays($tour['tour_id'],$bookingDetails['student']);
							$from=date('Y-m-d',strtotime($bookingDetails['booking_from'].' + '.$shaInitialInvoiceWeekDays.' days'));
						  }
						  //
						  
						if($bookingDetails['booking_to']=='0000-00-00')
							$to=date('Y-m-d',strtotime($from.' +4 weeks -1 day'));
						else	
							{
								$dayDiff=dayDiff($from,$bookingDetails['booking_to']);
								if($dayDiff>28)
									$to=date('Y-m-d',strtotime($from.' +4 weeks -1 day'));
								else	
									$to=$bookingDetails['booking_to'];
							}
							
							$tours[$tourK]['applications'][$appK]['from']=$from;
							$tours[$tourK]['applications'][$appK]['to']=$to;
							
							if(!isset($duration['end_date']) || (isset($duration['end_date']) && strtotime($to)<strtotime($duration['end_date'])))
								$duration['end_date']=$to;	
							
							$tours[$tourK]['applications'][$appK]['items']=$ongInvItems=ongInvItems($from,$to,$app['application_id']);
							//see($ongInvItems);
					}
				}
				$tours[$tourK]['duration']=$duration;
				
			}
			
			
			//see($tours);die();
			
			foreach($tours as $tour)
			{
				if(!empty($tour['duration']))
				{
					$this->load->model('tour_model');
					$this->tour_model->addOngoingInvoiceSTour($tour);
				}
			}
		}
		
		function generateOngoingInvoicesSTour_old()
		{	
			$this->emailTest();
			$date=date('Y-m-d',strtotime('+1 week'));
			//$date='2018-04-10';
			$initialInvoices=$this->cron_model->initialInvoiceEndingWithDate($date);
			$ongoingInvoices=$this->cron_model->ongoingInvoiceEndingWithDate($date);
			//see($initialInvoices);
			$initialInvoices=array_merge($initialInvoices,$ongoingInvoices);
			
			$tours=array();
			foreach($initialInvoices as $invoice)
			{
				$application=array();
				$prevItemAppId='';
				$prevItemDesc='';
				
				foreach($invoice['items'] as $itemK => $item)
				{
					if($item['type']=='accomodation' || $item['type']=='accomodation_ed')
					{
						if($item['type']=='accomodation_ed')
						{
							$currentItemAppId=$item['application_id'];
							$prevItemDescArray=explode('(',$prevItemDesc);
							$currentItemDescArray=explode('(',$item['desc']);
							
							if($prevItemAppId==$currentItemAppId)
							{
								$datesCurrent=explode('to',getTextBetweenBrackets($item['desc']));
								$datesPrev=explode('to',getTextBetweenBrackets($prevItemDesc));
								end($application);         // move the internal pointer to the end of the array
								$keyApp = key($application);
								$application[$keyApp]['dates']=$datesPrev[0].'to ';
								if(isset($datesCurrent[1]))
									$application[$keyApp]['dates'] .=trim($datesCurrent[1]);
								else	
									$application[$keyApp]['dates'] .=trim($datesCurrent[0]);
							}
						}
						else
						{
							$app['application_id']=$item['application_id'];
							$app['dates']=getTextBetweenBrackets($item['desc']);
							$application[]=$app;
						}
						$prevItemAppId=$item['application_id'];
						$prevItemDesc=$item['desc'];
					}
				}
				$tour['tour_id']=$invoice['application_id'];
				$tour['applications']=$application;
				$tours[]=$tour;
			}
			//see($tours);
			
			foreach($tours as $tourK=>$tour)
			{
				$duration=array();
				foreach($tour['applications'] as $appK=>$app)
				{
					$dates=datesFromText($app['dates']);
					$bookingDetails=bookingByShaId($app['application_id']);
					if(!empty($bookingDetails))
					{
						$from=date('Y-m-d',strtotime($dates['to'].' + 1 day'));
						
						//If last invoice was initial invoice then we have to calculate the start date of the ongoing invoice from the booking
						if($tour['initial_invoice']=='1')
						  {	
						  	$shaInitialInvoiceWeekDays=shaInitialInvoiceWeekDays($bookingDetails['student']);
							$from=date('Y-m-d',strtotime($bookingDetails['booking_from'].' + '.$shaInitialInvoiceWeekDays.' days'));
						  }
						  //
						  
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
							
							$tours[$tourK]['applications'][$appK]['from']=$from;
							$tours[$tourK]['applications'][$appK]['to']=$to;
							
							$duration['from']=date('Y-m-d',strtotime($date.' + 1 day'));
							if(!isset($duration['to']) || (isset($duration['to']) && strtotime($to)>strtotime($duration['to'])))
								$duration['to']=$to;
							
							$tours[$tourK]['applications'][$appK]['items']=$ongInvItems=ongInvItems($from,$to,$app['application_id']);
							//see($ongInvItems);
					}
				}
				$tours[$tourK]['duration']=$duration;
				
			}
			//see($tours);
			
			foreach($tours as $tour)
			{
				if(!empty($tour['duration']))
				{
					$this->load->model('tour_model');
					$this->tour_model->addOngoingInvoiceSTour($tour);
				}
			}
		}
		
		function ongSTour($date)
		{
			$this->emailTest();
				
			//$date=date('Y-m-d',strtotime('+1 week'));
			//$date='2018-04-10';
			$initialInvoices=$this->cron_model->initialInvoiceEndingWithDate($date);
			$ongoingInvoices=$this->cron_model->ongoingInvoiceEndingWithDate($date);
			//see($initialInvoices);
			$initialInvoices=array_merge($initialInvoices,$ongoingInvoices);
			
			$duration['from']=date('Y-m-d',strtotime($date.' + 1 day'));
			$duration['to']=date('Y-m-d',strtotime($date.' + 4 weeks'));
			$tours=array();
			foreach($initialInvoices as $invoice)
			{
				$application=array();
				$prevItemAppId='';
				$prevItemDesc='';
				
				foreach($invoice['items'] as $itemK => $item)
				{
					if($item['type']=='accomodation' || $item['type']=='accomodation_ed')
					{
						if($item['type']=='accomodation_ed')
						{
							$currentItemAppId=$item['application_id'];
							$prevItemDescArray=explode('(',$prevItemDesc);
							$currentItemDescArray=explode('(',$item['desc']);
							
							if($prevItemAppId==$currentItemAppId)
							{
								$datesCurrent=explode('to',getTextBetweenBrackets($item['desc']));
								$datesPrev=explode('to',getTextBetweenBrackets($prevItemDesc));
								end($application);         // move the internal pointer to the end of the array
								$keyApp = key($application);
								$application[$keyApp]['dates']=$datesPrev[0].'to ';
								if(isset($datesCurrent[1]))
									$application[$keyApp]['dates'] .=trim($datesCurrent[1]);
								else	
									$application[$keyApp]['dates'] .=trim($datesCurrent[0]);
							}
						}
						else
						{
							$app['application_id']=$item['application_id'];
							$app['dates']=getTextBetweenBrackets($item['desc']);
							$application[]=$app;
						}
						$prevItemAppId=$item['application_id'];
						$prevItemDesc=$item['desc'];
					}
				}
				$tour['tour_id']=$invoice['application_id'];
				$tour['applications']=$application;
				$tour['initial_invoice']=$invoice['initial_invoice'];
				$tours[]=$tour;
			}
			//see($tours);
			
			foreach($tours as $tourK=>$tour)
			{
				foreach($tour['applications'] as $appK=>$app)
				{
					$dates=datesFromText($app['dates']);
					$bookingDetails=bookingByShaId($app['application_id']);
					if(!empty($bookingDetails))
					{
						$from=date('Y-m-d',strtotime($dates['to'].' + 1 day'));
						
						//If last invoice was initial invoice then we have to calculate the start date of the ongoing invoice from the booking
						if($tour['initial_invoice']=='1')
						  {	
						  	$shaInitialInvoiceWeekDays=tourInitialInvoiceWeekDays($tour['tour_id'],$bookingDetails['student']);
							$from=date('Y-m-d',strtotime($bookingDetails['booking_from'].' + '.$shaInitialInvoiceWeekDays.' days'));
						  }
						  //
						  
						if($bookingDetails['booking_to']=='0000-00-00')
							$to=date('Y-m-d',strtotime($from.' +4 weeks -1 day'));
						else	
							{
								$dayDiff=dayDiff($from,$bookingDetails['booking_to']);
								if($dayDiff>28)
									$to=date('Y-m-d',strtotime($from.' +4 weeks -1 day'));
								else	
									$to=$bookingDetails['booking_to'];
							}
							
							$tours[$tourK]['applications'][$appK]['from']=$from;
							$tours[$tourK]['applications'][$appK]['to']=$to;
							
							if(!isset($duration['end_date']) || (isset($duration['end_date']) && strtotime($to)<strtotime($duration['end_date'])))
								$duration['end_date']=$to;	
							
							$tours[$tourK]['applications'][$appK]['items']=$ongInvItems=ongInvItems($from,$to,$app['application_id']);
							//see($ongInvItems);
					}
				}
				$tours[$tourK]['duration']=$duration;
				
			}
			see($tours);
			
			/*foreach($tours as $tour)
			{
				if(!empty($tour['duration']))
				{
					$this->load->model('tour_model');
					$this->tour_model->addOngoingInvoiceSTour($tour);
				}
			}*/
		
		}
		
		//gruop invoces for clients: college and university
		function groupInvoices()
		{
			$this->emailTest();
			if(date('D')=='Mon')
			{
				$date=date('Y-m-d');
				//$date='2018-07-02';
				$year=date('Y',strtotime($date));
				$clients=$this->cron_model->groupInvoiceClients($date);
				//see($clients);
				
				$this->load->helper('product_helper');
				$groupInvStructure=getGroupInvStructure($clients,$year);see($groupInvStructure);
				$this->cron_model->insertGroupInvItems($groupInvStructure,$date);
			}
			else
				echo 'Not Monday';
		}
		
		function autoFeedbackEmail()
		{
				$date=date('Y-m-d');
				//$date='2019-04-13';
				$this->load->library('email');
				$bookings=$this->cron_model->autoFeedbackEmailBookingList($date);//see($bookings);die(0);
				$unsubEmails=$this->cron_model->unsubscribedFeedbackEmailList();
				$uEmails=array();
				foreach($unsubEmails as $uE)
				{
				    $uEmails[]=$uE['email_id'];
				}
				
				foreach($bookings as $booking)
				{
				    $student=getshaOneAppDetails($booking['student']);
				    if(!empty($uEmails) && in_array($student['email'],$uEmails))
				        continue;
				    
					
					$this->email->clear(); 	
					$config['mailtype'] = 'html';
					$this->email->initialize($config);
			
					 $this->email->from(header_from_email(),header_from());
			
					$this->email->subject('How did we do? Global experience feedback');
					$to=$student['email'];
					//$to =  'tejpal@evomorf.com';
					$this->email->to($to);
					
					$link=codeEncode($booking['id']);
					$link=site_url().'form/studentFeedback/'.$link;
					$linkUnsub=codeEncode($student['email']);
					$linkUnsub=site_url().'form/unsubscribeFeedbackEmail/'.$linkUnsub;
					$emailData['link']=$link;
					$emailData['linkUnsub']=$linkUnsub;
					
					$email_msg_user=$this->load->view('form/emails/autoFeedbackEmail',$emailData,true);
					$this->email->message($email_msg_user);
					
					$this->email->send();
					
					$this->cron_model->feedbackEmailSent($booking['id'],$booking['stop']);
					/*$config['mailtype'] = 'html';
					$this->email->initialize($config);
					$this->email->from(header_from_email(),header_from());
					$this->email->subject('Copy to Developer - How did we do? Global experience feedback to '.$student['email']);
					$this->email->message($email_msg_user);
					$to='tejpal@evomorf.com';
					$this->email->to($to);
					$this->email->send();
					$this->email->clear(TRUE);*/
				}
		}
		
		
		
	function syncInitialInvoice($limit='')
	{			//die(0);
				$this->load->library('xero');
				$this->load->model(array('invoice_model','xero_model'));
				$initialInvoices=$this->invoice_model->initialInvoicesListForSync($limit);
				foreach($initialInvoices as $invoice)
				{
					if($invoice['moved_to_xero']=='1')
					{
						  ////////////
						  $invoice_id=getInvoiceIdFromInvoiceNumber($invoice['invoice_number']);
						  if($invoice_id)
						  {
							  $initialInvoiceDetails=initialInvoiceDetails($invoice_id);
							  $invoice_result = $this->xero->Invoices($invoice['invoice_number']);	
							  if(is_object($invoice_result))
							  {
								  if($invoice_result->Status=='OK')
								  {
									  $payments=$invoice_result->Invoices->Invoice->Payments->Payment;
									  if(isset($payments))
										{	
											$countDB=getInitialInvoicePaymentsCount($invoice_id);
											$countAPI=count($payments);
											if($countAPI>$countDB)
											{
												  $response=$this->xero_model->initialInvoiceInsertNewPayments($invoice_id,$payments);
												  if($invoice_result->Invoices->Invoice->AmountDue==0.00)
												  {
													  $this->xero_model->initialInvoiceChangeStatus($invoice_id,'3');
												  }
												  else
												  {
													  if($invoice_result->Invoices->Invoice->AmountPaid!=0.00)
													  {
														  $this->xero_model->initialInvoiceChangeStatus($invoice_id,'2');
													  }
												  }
											}
										  }
								  }
							  }
						  }
						///////////////
					}
				}
	}
	
		
 function syncOngoingInvoice($limit='')
	{			//die(0);
				$this->load->library('xero');
				$this->load->model(array('invoice_model','xero_model'));
				$initialInvoices=$this->invoice_model->ongoingInvoicesListForSync($limit);
				foreach($initialInvoices as $invoice)
				{
					if($invoice['moved_to_xero']=='1')
					{
						  ////////////
						  $invoice_id=getOngoingInvoiceIdFromInvoiceNumber($invoice['invoice_number']);
						  if($invoice_id)
						  {
							  $ongoingInvoiceDetails=ongoingInvoiceDetails($invoice_id);
							  $invoice_result = $this->xero->Invoices($invoice['invoice_number']);	
							  if(is_object($invoice_result))
							  {
								  if($invoice_result->Status=='OK')
								  {
									  $payments=$invoice_result->Invoices->Invoice->Payments->Payment;
									  if(isset($payments))
										{	
											$countDB=getOngoingInvoicePaymentsCount($invoice_id);
											$countAPI=count($payments);
											if($countAPI>$countDB)
											{
												  $response=$this->xero_model->ongoingInvoiceInsertNewPayments($invoice_id,$payments);
												  if($invoice_result->Invoices->Invoice->AmountDue==0.00)
												  {
													  $this->xero_model->ongoingInvoiceChangeStatus($invoice_id,'3');
												  }
												  else
												  {
													  if($invoice_result->Invoices->Invoice->AmountPaid!=0.00)
													  {
														  $this->xero_model->ongoingInvoiceChangeStatus($invoice_id,'2');
													 }
												  }
											}
										  }
								  }
							  }
						  }
						///////////////
					}
				}
	}
	
	
	function syncPo($limit='')
	{			//die(0);
				$this->load->library('xero');
				$this->load->model(array('po_model','xero_model'));
				$pos=$this->po_model->poListForSync($limit);
				foreach($pos as $po)
				{
					if($po['moved_to_xero']=='1')
					{
   						  $po_result = $this->xero->Invoices($po['po_id_xero']);	
						   $pODetails=$this->po_model->poDetails($po['id']);
						  if(is_object($po_result))
						  {
							  if($po_result->Status=='OK')
							  {
								  $payments=$po_result->Invoices->Invoice->Payments->Payment;
								  if(isset($payments))
								  {
									  $countDB=getPOPaymentsCount($po['id']);
									  $countAPI=count($payments);
									  
									  if($countAPI>$countDB)
									  {
										  $response=$this->xero_model->pOInsertNewPayments($po['id'],$payments);
										  if($po_result->Invoices->Invoice->AmountDue==0.00)
												  {
													  $appMoved=$this->xero_model->pOChangeStatus($po['id'],'2');
													}
													else
												  {
													  if($po_result->Invoices->Invoice->AmountPaid!=0.00)
													  {
														  $appMoved=$this->xero_model->pOChangeStatus($po['id'],'3');
													  }
												  }
									  }
								   }
								}
						  }
					}
				}
	}
	
	
	function syncGroupInitialInvoice()
	{			//die(0);
				$this->load->library('xero');
				$this->load->model('group_invoice_model');
				
				$initialInvoices=$this->group_invoice_model->initialInvoicesListForSync();
				foreach($initialInvoices as $invoice)
				{
					if($invoice['moved_to_xero']=='1')
					{
						  	  $invoice_id=$invoice['id'];
							  $initialInvoiceDetails=groupInvoiceDetails($invoice_id);
							  $invoice_result = $this->xero->Invoices($invoice['invoice_number']);	
							  if(is_object($invoice_result))
							  {
								  if($invoice_result->Status=='OK')
								  {
									  $payments=$invoice_result->Invoices->Invoice->Payments->Payment;
									  if(isset($payments))
										{	
											$countDB=getGroupInvoicePaymentsCount($invoice_id);
											$countAPI=count($payments);
											if($countAPI>$countDB)
											{
												  $response=$this->group_invoice_model->initialInvoiceInsertNewPayments($invoice_id,$payments);
												  if($invoice_result->Invoices->Invoice->AmountDue==0.00)
												  {
													  $appMoved=$this->group_invoice_model->initialInvoiceChangeStatus($invoice_id,'3');
												  }
												  else
												  {
													  if($invoice_result->Invoices->Invoice->AmountPaid!=0.00)
													  {
														  $appMoved=$this->group_invoice_model->initialInvoiceChangeStatus($invoice_id,'2');
													  }
												  }
											}
										  }
								  }
							  }
					}
				}
	}
		
		function CGServiceDocEmail()
		{
				//$date='2019-07-'.$dd.date(' H:i:s');//
				$date=date('Y-m-d H:i:s');
				$day=date('N',strtotime($date));//$day=date('N');
				if(!in_array($day,array('6','7')))//not Saturday and Sunday i.e. we need only working days
				{
					$this->load->library('email');echo $date;
					$bookings=$this->cron_model->CGServiceDocEmail($date);see($bookings);echo $this->db->last_query();die(0);
					foreach($bookings as $booking)
					{
						$this->email->clear(); 	
						$config['mailtype'] = 'html';
						$this->email->initialize($config);
				
						 $this->email->from(header_from_email(),header_from());
				
						$this->email->subject('#'.$booking['id'].' - Caregiving service document not received');
						$employee=employee_details($booking['cgDocSentBy']);
						$to=$employee['email_company'];
						//$to =  'tejpal@evomorf.com';
						$this->email->to($to);
						
						$emailData['employee_name']=$employee['fname'].' '.$employee['lname'];
						$emailData['booking_id']=$booking['id'];
						
						$email_msg_user=$this->load->view('form/emails/CGServiceDocEmail',$emailData,true);
						$this->email->message($email_msg_user);
						
						$this->email->send();
						
						/*$config['mailtype'] = 'html';
						$this->email->initialize($config);
						$this->email->from(header_from_email(),header_from());
						$this->email->subject('Copy to Developer - How did we do? Global experience feedback to '.$student['email']);
						$this->email->message($email_msg_user);
						$to='tejpal@evomorf.com';
						$this->email->to($to);
						$this->email->send();
						$this->email->clear(TRUE);*/
					}
				}
		}
		
		function generate2ndPo()
		{
			$date=date('Y-m-d');
			//$date='2019-09-02';
			generate2ndPo($date);
		}
		
		function wwccExpiryReminderEmail()
		{
			$date=date('Y-m-d');//$date='2019-11-14';
			$members=$this->cron_model->wwccExpiryMemberList($date);
			//see($members);die();
			if(!empty($members))
			{
				$this->load->library('email');
				$emailSendingProfile['email_company']='receptionist@globalexperience.com.au';
				$emailSendingProfile['fname']='Global experience receptionist';
				$emailSendingProfile['lname']='';
			}
			foreach($members as $mem)
			{
						$this->email->clear(); 	
						$config['mailtype'] = 'html';
						$this->email->initialize($config);
				
						 $header_from_email=$emailSendingProfile['email_company'];
						 $header_from=$emailSendingProfile['fname'].' '.$emailSendingProfile['lname'];
						 $this->email->from($header_from_email,$header_from);
						 //$this->email->reply_to('agnes@globalexperience.com.au', 'Global Experience');
				
						$this->email->subject('Email Reminder for WWCC');
						
						$host=getHfaOneAppDetails($mem['application_id']);
						$to = $host['email'];
						//$to =  'tejpal@evomorf.com';//$to =  'tejpal.1988@gmail.com';
						$this->email->to($to);
						
						
						$emailData['hostName']=$host['fname'];
						$emailData['memberName']=$mem['fname'].' '.$mem['lname'];
						$emailData['age']=age_from_dob($mem['dob']);
						$emailData['wwccClearenceNo']=$mem['wwcc_clearence_no'];
						$emailData['wwccExpiryDate']=dateFormat($mem['wwcc_expiry']);
						$emailData['notAvailableText']='Not available';
						//$emailData['senderName']=$emailSendingProfile['fname'].' '.$emailSendingProfile['lname'];
						
						$email_msg_user=$this->load->view('form/emails/wwccExpiryReminderEmail',$emailData,true);
						$this->email->message($email_msg_user);
						
						$this->email->send();
			}
		}
		
		function plInsExpiryReminderEmail()
		{	
			$date=date('Y-m-d');//$date='2019-11-14';
			$hosts=$this->cron_model->plInsExpiryMemberList($date);
			//see($hosts);die();
			if(!empty($hosts))
			{
				$this->load->library('email');
				$emailSendingProfile['email_company']='receptionist@globalexperience.com.au';
				$emailSendingProfile['fname']='Global experience receptionist';
				$emailSendingProfile['lname']='';
			}
			foreach($hosts as $host)
			{
						$this->email->clear(); 	
						$config['mailtype'] = 'html';
						$this->email->initialize($config);
						
						 $header_from_email=$emailSendingProfile['email_company'];
						 $header_from=$emailSendingProfile['fname'].' '.$emailSendingProfile['lname'];
						 $this->email->from($header_from_email,$header_from);
						 //$this->email->reply_to('agnes@globalexperience.com.au', 'Global Experience');
				
						$this->email->subject('Email Reminder for Homestay Host Insurance');
						
						$hostOne=getHfaOneAppDetails($host['id']);
						$to = $hostOne['email'];
						//$to =  'tejpal@evomorf.com';//$to =  'tejpal.1988@gmail.com';
						$this->email->to($to);
						
						
						$emailData['hostName']=$hostOne['fname'];
						$emailData['insProvider']=$host['ins_provider'];
						$emailData['policyNo']=$host['ins_policy_no'];
						$emailData['insExpiryDate']=dateFormat($host['ins_expiry']);
						$emailData['notAvailableText']='Not available';
						//$emailData['senderName']=$emailSendingProfile['fname'].' '.$emailSendingProfile['lname'];
						
						$email_msg_user=$this->load->view('form/emails/plInsExpiryReminderEmail',$emailData,true);
						$this->email->message($email_msg_user);
						
						$this->email->send();
			}
		}
}