<?php
class Invoice extends CI_Controller {
	
		function __construct()
		{
			parent::__construct();
			$this->load->model('invoice_model');
			$this->load->helper('product');
		}
		
		function initial_all()
		{
			if(checkLogin())
			{
				recentActionsAddData('invoice_initial','all','view');
				$data=array();
				$data['page']='invoiceInitial';
				$status='0';
				$data['initial_invoice_status']=$status;
				$filterGet=$_GET;
				//$data['invoices']=$this->invoice_model->initialInvoicesList($status);
				$this->load->view('system/header',$data);
				$this->load->view('system/invoice/initial/list');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
		}
		
		function initial()
		{
			if(checkLogin())
			{
				recentActionsAddData('invoice_initial','pending','view');
				$data=array();
				$data['page']='invoiceInitial';
				$status='1';
				$data['initial_invoice_status']=$status;
				$filterGet=$_GET;
				//$data['invoices']=$this->invoice_model->initialInvoicesList($status);
				$this->load->view('system/header',$data);
				$this->load->view('system/invoice/initial/list');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
		}
		
		function initial_partial()
		{
			if(checkLogin())
			{
				recentActionsAddData('invoice_initial','partial','view');
				$data=array();
				$data['page']='invoiceInitial';
				$status='2';
				$data['initial_invoice_status']=$status;
				$filterGet=$_GET;
				//$data['invoices']=$this->invoice_model->initialInvoicesList($status);
				$this->load->view('system/header',$data);
				$this->load->view('system/invoice/initial/list');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
		}
		
		function initial_paid()
		{
			if(checkLogin())
			{
				recentActionsAddData('invoice_initial','paid','view');
				$data=array();
				$data['page']='invoiceInitial';
				$status='3';
				$data['initial_invoice_status']=$status;
				$filterGet=$_GET;
				//$data['invoices']=$this->invoice_model->initialInvoicesList($status);
				$this->load->view('system/header',$data);
				$this->load->view('system/invoice/initial/list');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
		}
		
		function view_initial($id)
		{
			if(checkLogin())
			{
				$data=array();
				$data['page']='invoice';
				$data['invoice']=$this->invoice_model->initialInvoiceDetails($id);
				if(empty($data['invoice']))
					header('location:'.site_url().'invoice/initial');
				
				recentActionsAddData('invoice_initial',$id,'view');
					
				$data['student']=getShaOneAppDetails($data['invoice']['application_id']);
				/////////
				if($data['invoice']['study_tour']==0)
					  {
						  $data['student']=getShaOneAppDetails($data['invoice']['application_id']);
						  $client_id=$data['student']['client'];
					  }
					  else
					  {
						  $tourDetail=tourDetail($data['invoice']['application_id']);
						  $client_id=$tourDetail['client_id'];
					  }
				////////
				$this->load->model('client_model');
				$data['client']=$this->client_model->clientDetail($client_id);
				//see($data);
				$this->load->view('system/header',$data);
				$this->load->view('system/invoice/initial/view_initial');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
		}
		
		function view_initial_student($id)
		{
			if(checkLogin())
			{
				$data=array();
				$data['page']='invoice';
				$data['invoice']=$this->invoice_model->initialInvoiceDetails($id);
				if(empty($data['invoice']['items_standard']))
					header('location:'.site_url().'invoice/initial');
					
				$data['student']=getShaOneAppDetails($data['invoice']['application_id']);
				$this->load->model('client_model');
				$data['client']=$this->client_model->clientDetail($data['student']['client']);
				//see($data);
				$this->load->view('system/header',$data);
				$this->load->view('system/invoice/initial/view_initial_standard');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
		}
		
	function deleteInvoiceItem()
	{
			$data=$_POST;
			if($data['itemId']!='')
			{
				$this->invoice_model->deleteInvoiceItem($data);
				$data['invoice']=$this->invoice_model->initialInvoiceDetails($data['id']);
				$data['student']=getShaOneAppDetails($data['invoice']['application_id']);
				$this->load->model('client_model');
				$data['client']=$this->client_model->clientDetail($data['student']['client']);
				
				$viewSuffix="";
				if($data['invoiceType']=='standard')
					$viewSuffix="_standard";
				
				$view_initial=$this->load->view('system/invoice/initial/view_initial'.$viewSuffix,$data,true);
				$return['page']=$view_initial;
				echo json_encode($return);
			}
	}

	
	function addNewInitialInvoiceItemPopContent($id,$invoiceType)
	{
		$data=array();
		$data['invoice']=$this->invoice_model->initialInvoiceDetails($id);
		$data['student']=getShaOneAppDetails($data['invoice']['application_id']);
		$data['invoiceType']=$invoiceType;
		$this->load->view('system/invoice/initial/addNewItemForm',$data);
	}
	
	function addNewInitialInvoiceItemPopContentSubmit()
	{
		$data=$_POST;
		$this->invoice_model->addNewInvoiceItem($data);
		
		$data['invoice']=$this->invoice_model->initialInvoiceDetails($data['invoice_id']);
		$data['student']=getShaOneAppDetails($data['invoice']['application_id']);
		$this->load->model('client_model');
		$data['client']=$this->client_model->clientDetail($data['student']['client']);
		
		if($data['invoiceType']=='real')
			$view_initial=$this->load->view('system/invoice/initial/view_initial',$data,true);
		else	
			$view_initial=$this->load->view('system/invoice/initial/view_initial_standard',$data,true);
		$return['page']=$view_initial;
		echo json_encode($return);
	}
	
	function editInitialInvoiceItemPopContent($invoiceTypePage)
	{
		if(isset($_POST['itemId']))
		{
			$data=$_POST;
			$data['invoice']=$this->invoice_model->initialInvoiceDetails($data['id']);
			if($data['invoice']['study_tour']=='1')
			{
				$dayItemDetails=array();
				$itemIdArray=explode('_',$data['itemId']);
				
				$itemDetails=$this->getInitialInvItemDetails($itemIdArray[1]);
				if($itemDetails['type']=='accomodation' || $itemDetails['type']=='accomodation_ed')
				{
					if($itemDetails['type']=='accomodation_ed')
						{
							$row=$this->getWeekItemIdInitialStour($itemIdArray[1]);
							if(!empty($row))
								$data['itemId']='il_'.$row['id'];
							else
							{
								$data['itemId']='il_week';
								$weekItemDetails['id']='week';
								$weekItemDetails['invoice_id']=$itemDetails['invoice_id'];
								$weekItemDetails['application_id']=$itemDetails['application_id'];
								$weekItemDetails['desc']=$itemDetails['desc'];
								$weekItemDetails['unit']=ceil($itemDetails['unit']*7);
								$weekItemDetails['qty_unit']='1';
								$weekItemDetails['qty']='0';
								$weekItemDetails['total']='';
								$weekItemDetails['gst']=$itemDetails['gst'];
								$weekItemDetails['xero_code']=$itemDetails['xero_code'];
								$weekItemDetails['type']='accomodation';
								$data['invoice']['items'][]=$weekItemDetails;
							}
							$dayItemDetails=$itemDetails;	
						}
					else
					{
						$row=$this->getDayItemIdInitialStour($itemIdArray[1]);
						if(!empty($row))
							$dayItemDetails=$this->getInitialInvItemDetails($row['id']);
					}
					$data['invoice']['dayItemDetails']=$dayItemDetails;
				}
			}
			
			$data['invoiceType']=$invoiceTypePage;
			$this->load->view('system/invoice/initial/editItemForm',$data);
		}
	}
	
	function getInitialInvItemDetails($itemId)
	{
		return $this->invoice_model->getInitialInvItemDetails($itemId);
	}
	
	function getWeekItemIdInitialStour($itemId)
	{
		return $this->invoice_model->getWeekItemIdInitialStour($itemId);
	}
	
	function getDayItemIdInitialStour($itemId)
	{
		return $this->invoice_model->getDayItemIdInitialStour($itemId);
	}
	
	function editInitialInvoiceItemPopContentSubmit()
	{
		$data=$_POST;
		$this->invoice_model->editInvoiceItem($data);
		
		$data['invoice']=$this->invoice_model->initialInvoiceDetails($data['invoice_id']);
		$data['student']=getShaOneAppDetails($data['invoice']['application_id']);
		$this->load->model('client_model');
		$data['client']=$this->client_model->clientDetail($data['student']['client']);
		
		$viewSuffix='';
		if($data['invoiceType']=='standard')
			$viewSuffix="_standard";
		$view_initial=$this->load->view('system/invoice/initial/view_initial'.$viewSuffix,$data,true);
		$return['page']=$view_initial;
		echo json_encode($return);
	}
	
	function downloadStudentInvoicePdf($id)
	{
		if($id!='')
		{
			$invoice=initialInvoiceDetails($id);
			if(!empty($invoice) && isset($invoice['items_standard']))
			{
				$invoice['student']=getshaOneAppDetails($invoice['application_id']);
				
				$this->load->library('pdf');
				$this->pdf->load_view('system/invoice/initial/pdf_standard',$invoice,true);
				$this->pdf->Output();
				$this->load->view('system/invoice/initial/pdf_standard',$invoice);
			}
		}
	}
	
	
	function initialInvoiceCancelInfo_popContent($id)
	{
		if(checkLogin())
				{
					if($id!='')
						{
							$invoice=initialInvoiceDetails($id);
							if(!empty($invoice) && $invoice['cancelled']=='1')
							{
								$initialInvoiceCancelledData=initialInvoiceCancelledData($invoice['id']);
								$invoice['cancel_data']=$initialInvoiceCancelledData;
								$this->load->view('system/invoice/initial/cancelInfo_popContent',$invoice);
							}
						}
				}
				else
					echo "LO";
	}
	
	function getToDateOnQtyChange()
	{
		if(checkLogin())
				{
					$data=$_POST;
					preg_match('#\((.*?)\)#', $data['itemDesc'], $match);//checking if there is anything between brekects, if not that means there is no date in the item desc and we return the desc as it is
					if(!empty($match))
					{
						$days=($data['qty']*7)-1;
						$newDate=date('d M Y',strtotime($data['invoiceDateFrom'].' + '.$days.' days'));
						$itemDesc=explode(' ',$data['itemDesc']);
						$removed = array_splice($itemDesc, -3, 3);
						$itemDesc=array_merge($itemDesc,explode(' ',$newDate));
						$itemDesc=implode(' ',$itemDesc);
						echo $itemDesc.')';
					}
					else
					{
						echo $data['itemDesc'];
					}
				}
				else
					echo "LO";
	}
	
	function getEDDateOnQtyChange()
	{
		if(checkLogin())
				{
					$data=$_POST;
					$qty_old=$data['qtyOld'];
					$qty_oldDay=$qty_old;
					$days=$data['qty'];
					$from=date('d M Y',strtotime($data['invoiceDateTo'].' - '.$qty_oldDay.' days'));
					$to='';
					$checkOutDate=date('d M Y',strtotime($data['invoiceDateTo'].' - 1 days'));
					
					$newDate='('.$from;
					$diff=$days-$qty_old;
					if($days>1)
						$to=' to '.date('d M Y',strtotime($checkOutDate.' '.$diff.' days'));
					$newDate .=$to.')';
					
					///////
					preg_match('#\((.*?)\)#', $data['itemDesc'], $match);
					if(!empty($match))
						$itemDesc=str_replace($match[0],'',$data['itemDesc']);
					else	
						$itemDesc=$data['itemDesc'];
					$itemDesc .=$newDate;
					//////////
					//$itemDesc=array_filter(explode(' ',$data['itemDesc']));
					
					//$removed = array_splice($itemDesc, -7, 7);
					//$itemDesc=array_merge($itemDesc,explode(' ',$newDate));
					//$itemDesc=implode(' ',$itemDesc);
					
					echo $itemDesc;
				}
				else
					echo "LO";
	}
	
	
	function ongoing_all()
		{
			$status='0';
			recentActionsAddData('invoice_ongoing','all','view');
			$this->ongoingListPage($status);
		}
		
	function ongoing()
		{
			$status='1';
			recentActionsAddData('invoice_ongoing','pending','view');
			$this->ongoingListPage($status);
		}
		
	function ongoing_partial()
		{
			$status='2';
			recentActionsAddData('invoice_ongoing','partial','view');
			$this->ongoingListPage($status);
		}
		
	function ongoing_paid()
		{
			$status='3';
			recentActionsAddData('invoice_ongoing','paid','view');
			$this->ongoingListPage($status);
		}	
		
		function ongoingListPage($status)
		{
			if(checkLogin())
			{
				$data=array();
				$data['page']='invoiceOngoing';
				$data['ongoing_invoice_status']=$status;
				//$data['invoices']=$this->invoice_model->ongoingInvoicesList($status);
				$this->load->view('system/header',$data);
				$this->load->view('system/invoice/ongoing/list');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
		}
	
		function view_ongoing($id)
		{
			if(checkLogin())
			{
				$data=array();
				$data['page']='invoice';
				$data['invoice']=$this->invoice_model->ongoingInvoiceDetails($id);
				if(empty($data['invoice']))
					header('location:'.site_url().'invoice/ongoing');
				
				recentActionsAddData('invoice_ongoing',$id,'view');
					
				$data['student']=getShaOneAppDetails($data['invoice']['application_id']);
				/////////
				if($data['invoice']['study_tour']==0)
					  {
						  $data['student']=getShaOneAppDetails($data['invoice']['application_id']);
						  $client_id=$data['student']['client'];
					  }
					  else
					  {
						  $tourDetail=tourDetail($data['invoice']['application_id']);
						  $client_id=$tourDetail['client_id'];
					  }
				////////
				$this->load->model('client_model');
				$data['client']=$this->client_model->clientDetail($client_id);
				//see($data);
				$this->load->view('system/header',$data);
				$this->load->view('system/invoice/ongoing/view_ongoing');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
		}
		
		
			
	function addNewOngoingInvoiceItemPopContent($id)
	{
		$data=array();
		$data['invoice']=$this->invoice_model->ongoingInvoiceDetails($id);
		$data['student']=getShaOneAppDetails($data['invoice']['application_id']);
		$this->load->view('system/invoice/ongoing/addNewItemForm',$data);
	}
		
	
	function addNewOngoingInvoiceItemPopContentSubmit()
	{
		$data=$_POST;
		$this->invoice_model->addNewOngoingInvoiceItem($data);
		
		$data['invoice']=$this->invoice_model->ongoingInvoiceDetails($data['invoice_id']);
		$data['student']=getShaOneAppDetails($data['invoice']['application_id']);
		$this->load->model('client_model');
		$data['client']=$this->client_model->clientDetail($data['student']['client']);
		
		$view_initial=$this->load->view('system/invoice/ongoing/view_ongoing',$data,true);
		$return['page']=$view_initial;
		echo json_encode($return);
	}
	
	function deleteOngoingInvoiceItem()
	{
			$data=$_POST;
			if($data['itemId']!='')
			{
				$this->invoice_model->deleteOngoingInvoiceItem($data);
				$data['invoice']=$this->invoice_model->ongoingInvoiceDetails($data['id']);
				$data['student']=getShaOneAppDetails($data['invoice']['application_id']);
				$this->load->model('client_model');
				$data['client']=$this->client_model->clientDetail($data['student']['client']);
				
				$view_initial=$this->load->view('system/invoice/ongoing/view_ongoing',$data,true);
				$return['page']=$view_initial;
				echo json_encode($return);
			}
	}
	
	function editOngoingInvoiceItemPopContent()
	{
		if(isset($_POST['itemId']))
		{
			$data=$_POST;
			$data['invoice']=$this->invoice_model->ongoingInvoiceDetails($data['id']);
			if($data['invoice']['study_tour']=='1')
			{
				$dayItemDetails=array();
				$itemIdArray=explode('_',$data['itemId']);
				
				$itemDetails=$this->getOngInvItemDetails($itemIdArray[1]);
				if($itemDetails['type']=='accomodation' || $itemDetails['type']=='accomodation_ed')
				{
					if($itemDetails['type']=='accomodation_ed')
						{
							$row=$this->getWeekItemIdOngStour($itemIdArray[1]);
							if(!empty($row))
								$data['itemId']='il_'.$row['id'];
							else
							{
								$data['itemId']='il_week';
								$weekItemDetails['id']='week';
								$weekItemDetails['invoice_id']=$itemDetails['invoice_id'];
								$weekItemDetails['application_id']=$itemDetails['application_id'];
								$weekItemDetails['desc']=$itemDetails['desc'];
								$weekItemDetails['unit']=ceil($itemDetails['unit']*7);
								$weekItemDetails['qty_unit']='1';
								$weekItemDetails['qty']='0';
								$weekItemDetails['total']='';
								$weekItemDetails['gst']=$itemDetails['gst'];
								$weekItemDetails['xero_code']=$itemDetails['xero_code'];
								$weekItemDetails['type']='accomodation';
								$data['invoice']['items'][]=$weekItemDetails;
							}
							$dayItemDetails=$itemDetails;	
						}
					else
					{
						$row=$this->getDayItemIdOngStour($itemIdArray[1]);
						if(!empty($row))
							$dayItemDetails=$this->getOngInvItemDetails($row['id']);
					}
					$data['invoice']['dayItemDetails']=$dayItemDetails;
				}
			}
			$this->load->view('system/invoice/ongoing/editItemForm',$data);
		}
	}
	
	function editOngoingInvoiceItemPopContentSubmit()
	{
		$data=$_POST;
		$this->invoice_model->editOngoingInvoiceItem($data);
		
		$data['invoice']=$this->invoice_model->ongoingInvoiceDetails($data['invoice_id']);
		$data['student']=getShaOneAppDetails($data['invoice']['application_id']);
		$this->load->model('client_model');
		$data['client']=$this->client_model->clientDetail($data['student']['client']);
		
		$view_initial=$this->load->view('system/invoice/ongoing/view_ongoing',$data,true);
		$return['page']=$view_initial;
		echo json_encode($return);
	}
	
	function filters()
	{
		 $this->load->view('system/invoice/filters');
	}
	
	function changeStudentInvStatus($id)
	{
		$text=$this->invoice_model->changeStudentInvStatus($id);
		echo $text;
	}
	
	function initialInvoiceUpdateDuration()
	{
		$data=$_POST;
		$student=getShaOneAppDetails($data['shaChangeStatus_id']);
		$totalDays=($data['weeks']*7)+($data['days'])-1;
		
		if($student['booking_from']!='0000-00-00')
		{
			$data['booking_from']=$student['booking_from'];
			$data['dates_available']=1;
		}
		else
		{
				$data['booking_from']=date('Y-m-d');
				$data['dates_available']=0;
		}
		
		$data['booking_to']=date('Y-m-d',strtotime($data['booking_from'].' +'.$totalDays.' days'));//see($data);
		$this->invoice_model->updatePendingInvoice($data);
	}
	
	
	function resetInitialInvoice($invoiceId)
	{
		$initialInvoiceDetails=initialInvoiceDetails($invoiceId);
		$sha=getshaOneAppDetails($initialInvoiceDetails['application_id']);
		//if($sha['status']=='pending_invoice')
		  //{
			  $this->load->model('invoice_model');
			  $this->invoice_model->resetInitialInvoice($invoiceId,$initialInvoiceDetails['application_id']);
			  $this->session->set_flashdata('initialInvoiceReset','yes');
		  //}
	}
	
	function resetOngoingInvoice($invoiceId)
	{
			$ongoingInvoiceDetails=ongoingInvoiceDetails($invoiceId);
			$from=$ongoingInvoiceDetails['booking_from'];
			$to=date('Y-m-d',strtotime($from.' + 4 weeks -1 days'));
			
			$this->resetUpdateOngoingInvoicePart2($invoiceId,$from,$to);
			$this->session->set_flashdata('ongoingInvoiceReset','yes');
	}
	
	function ongoingInvoiceUpdateDuration()
	{
		$data=$_POST;
		$data['invoiceId']=$data['invoice_id'];
		$ongoingInvoiceDetails=ongoingInvoiceDetails($data['invoiceId']);
		$sha=getShaOneAppDetails($data['shaChangeStatus_id']);
		$totalDays=($data['weeks']*7)+($data['days'])-1;
		
		$from=$ongoingInvoiceDetails['booking_from'];
		$to=date('Y-m-d',strtotime($from.' +'.$totalDays.' days'));
		
		$this->resetUpdateOngoingInvoicePart2($data['invoiceId'],$from,$to);
		$this->session->set_flashdata('ongoingInvoiceUpdated','yes');
	}
	
	
	function resetUpdateOngoingInvoicePart2($invoiceId,$from,$to)
	{
			$ongoingInvoiceDetails=ongoingInvoiceDetails($invoiceId);
			$booking=bookingByShaId($ongoingInvoiceDetails['application_id']);
			$ongoingInvoice['id']=$invoiceId;
			$ongoingInvoice['application_id']=$ongoingInvoiceDetails['application_id'];
			$ongoingInvoice['items']=array();
			
			// If this is first ongoing invoice so its 'from' date should be derived from booking dates
			$lastInvoiceWithEndingDate=$this->invoice_model->lastInvoiceWithEndingDate($ongoingInvoice['application_id'],date('Y-m-d',strtotime($ongoingInvoiceDetails['booking_from'].' - 1 day')));
			if($lastInvoiceWithEndingDate['initial_invoice']=='1')
			{
				$shaInitialInvoiceWeekDays=shaInitialInvoiceWeekDays($booking['student']);
				$from=$OngoingInvoiceDate=date('Y-m-d',strtotime($booking['booking_from'].' + '.$shaInitialInvoiceWeekDays.' days'));
				$to=$OngoingInvoiceDateTo=date('Y-m-d',strtotime($OngoingInvoiceDate.' + '.dayDIff($from,$to).' days - 1 day'));
			}
			//
			
			if(strtotime($from)<=strtotime($booking['booking_to']) || $booking['booking_to']=='0000-00-00')
			{
				if(strtotime($booking['booking_to']) >= strtotime($to) || $booking['booking_to']=='0000-00-00')
					$to=$to;
				else
					$to=$booking['booking_to'];
				$items=ongInvItems($from,$to,$ongoingInvoiceDetails['application_id']);
				$ongoingInvoice['from']=$from;
				$ongoingInvoice['to']=$to;
				$ongoingInvoice['items']=$items;
			}
			
			//see($ongoingInvoice);
			$this->load->model('invoice_model');
			$this->invoice_model->resetOngoingInvoice($ongoingInvoice);
	}
	
		
	
	
	
	
	
	
	
	function  ssa($booking_id)
	{
		addNewOngoingInvoice($booking_id);
		echo "done";
	}
	
	function ongoingInvoiceItems($booking_id)
	{
		$bookingDetails=bookingDetails($booking_id);
		$lastInvoice=$this->invoice_model->getLastOngoingInvoiceByStudentId($bookingDetails['student']);
		if(!empty($lastInvoice))
		{
			//ongoing invoice block
			$from=$lastInvoice['booking_to'];
		}
		else
		{
			//Initial invoice block
			$lastInvoice=initialInvoiceByShaId($bookingDetails['student']);
			if($lastInvoice['booking_to']!='0000-00-00')
				$from=$lastInvoice['booking_to'];
			else	
				$from=date('Y-m-d',strtotime($bookingDetails['booking_from'].' +4 weeks'));
		}
		
		
		if($bookingDetails['booking_to']=='0000-00-00')
			$to=date('Y-m-d',strtotime($from.' +4 weeks'));
		else	
			{
				$dayDiff=dayDiff($from,$bookingDetails['booking_to']);
				$dayDiff--;// dec 1 day as last day is checkout date
		
				if($dayDiff>28)
					$to=date('Y-m-d',strtotime($from.' +4 weeks'));
				else	
					$to=$bookingDetails['booking_to'];
			}
		/*$from='2017-11-22';
		$to='2018-01-25';*/
		$items=$this->ongInv($from,$to,$bookingDetails['student']);
		see($items);
	}
	
	function ongInv($from,$to,$student_id)
	{see($from.' '.$to);
		$ongoingInvoiceItemCreater=ongoingInvoiceItemCreater($from,$to);
		see($ongoingInvoiceItemCreater);
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
				$accomodation_type='Twin Share';
		else if($student['accomodation_type']==3)					
				$accomodation_type='Self-Catered';		
		else if($student['accomodation_type']==4)					
				$accomodation_type='VIP Single Room';
		else if($student['accomodation_type']==5)					
				$accomodation_type='VIP Self-Catered';			
		
		$items=array();
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
								$item['desc']=$p['name'].' ('.date('d M Y',strtotime($ong['to'].' - '.$ong['days'].' days + 1 day')).' to '.date('d M Y',strtotime($ong['to'])).')';
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
		
		return $items;
	}
	
	function sti($id)
	{
		/*$this->load->model('sha_model');
		$students=$this->sha_model->getPendingStudentsByTourId($id);
		foreach($students as $student)
		{
			$invoice[]=$this->invoice_model->initialInvoiceBefore($student['id']);
		}
		see($invoice);*/
		
		$items=studyTourInitialInvoiceItems($id);
			see($items);
			echo $sql="insert into `invoice_initial` (`application_id`,`study_tour`, `booking_from`, `booking_to`, `date`) values ('".$id."','1','".$items[0]['booking_from']."','".$items[0]['booking_to']."','".date('Y-m-d H:i:s')."')";
			echo "<br>";
		$invoice_id='1';

			foreach($items as $item)
			{$invoice=$item;
				/////////////
				foreach($item as $itemK=>$itemV)
				{
				if($itemK!='booking_from' && $itemK!='booking_to' && $itemK!='standard' && $itemK!='student')
				{
					$itemV['desc'].=', '.$item['student'];
					$type="";
					if($itemK=='placement_fee')
					{
						$type="placement";
						if($invoice['booking_from']!='0000-00-00')
							$itemV['desc'] .=' ('.dateFormat($invoice['booking_from']).')';
					}
					elseif($itemK=='accomodation_fee')	
					{
						$type="accomodation";
						if($invoice['booking_from']!='0000-00-00' || $invoice['booking_to']!='0000-00-00')
						{
							$itemV['desc'] .=' ('.dateFormat($invoice['booking_from']).' to ';
							if(isset($invoice['accomodation_fee_ed']))
							{
								$minusDays=$invoice['accomodation_fee_ed']['qty']+1;
								$itemV['desc'] .=dateFormat(date('Y-m-d',strtotime($invoice['booking_to'].' - '.$minusDays .' days')));	
							}
							else
								$itemV['desc'] .=dateFormat(date('Y-m-d',strtotime($invoice['booking_to'].' - 1 days')));	
							$itemV['desc'] .=')';	
						}
					}
					elseif($itemK=='accomodation_fee_ed')
					{	
						$type="accomodation_ed";		
						$itemV['desc'] .=' (';
						if($invoice['accomodation_fee_ed']['qty'] > 1)
						{
							$minusDays=$invoice['accomodation_fee_ed']['qty'];
							$itemV['desc'] .=dateFormat(date('Y-m-d',strtotime($invoice['booking_to'].' - '.$minusDays.' days'))).' to ';
						}
						
						$itemV['desc'] .=dateFormat(date('Y-m-d',strtotime($invoice['booking_to'].' - 1 days')));	
						$itemV['desc'] .=')';
					}
					elseif($itemK=='apu_fee')	
						$type="apu";
					elseif($itemK=='guardianship_fee')	
					{
						$type="guardianship";
						if($invoice['booking_from']!='0000-00-00' || $invoice['booking_to']!='0000-00-00')
							$itemV['desc'] .=' ('.dateFormat($invoice['booking_from']).' to '.dateFormat($invoice['booking_to']).')';	
					}
					elseif($itemK=='nomination_fee')	
						$type="nomination";
								
				  	$sql_item="insert into `invoice_initial_items` (`invoice_id`,`desc`,`unit`,`qty_unit`,`qty`,`total`,`gst`,`xero_code`,`type`,`date`) values ('".$invoice_id."','".$itemV['desc']."','".$itemV['unit']."','".$itemV['qty_unit']."','".$itemV['qty']."','".$itemV['total']."','".$itemV['gst']."','".$itemV['xero_code']."','".$type."','".date('Y-m-d H:i:s')."')";
				  	echo $sql_item."<br>";
					
					/*$sql_item="insert into `invoice_initial_items` (`invoice_id`,`desc`,`unit`,`qty_unit`,`qty`,`total`,`gst`,`xero_code`,`type`,`date`) values (?,?,?,?,?,?,?,?,?,?)";
				  	$this->db->query($sql_item,array($invoice_id,$itemV['desc'],$itemV['unit'],$itemV['qty_unit'],$itemV['qty'],$itemV['total'],$itemV['gst'],$itemV['xero_code'],$type,date('Y-m-d H:i:s')));*/
				}
			
				////////////////////
			}
			echo "<br><br>";
			}
			
	}
	
	function mpdf()
	{
			
 
 
 $this->load->library('pdf');
$this->pdf->load_view('system/invoice/initial/mpdf',true);
$this->pdf->Output();
	}
	
	function test($id)
	{
		$this->load->model('tour_model');
		$this->tour_model->addPendingInvoice($id);
	}
	
	function test2($id)
	{
		//$date=date('d M Y');
		/*$date='2017-10-25';
		$daay=4;
		$daay++;
		$date_next=date('d M Y',strtotime($date." - ".$daay." days"));
		echo $date.' '.$date_next;*/
		
		/*$dayDiff=daydiff('2017-09-09','2017-10-27');
		
		$weeks=($dayDiff/7);
		$weeks_only=(int)($dayDiff/7);
		$days=($dayDiff%7);
		echo 'diff '.$dayDiff.', '.$weeks_only.' weeks, '.$days.' days';*/
		
		/*$minusDays=3+1;
		echo dateFormat(date('Y-m-d',strtotime('2017-10-31 - '.$minusDays.' days'))).'<br>';
		
		$minusDays=3;
		echo dateFormat(date('Y-m-d',strtotime('2017-10-31 - '.$minusDays.' days'))).' to ';*/
		/*echo $shaInitialInvoiceWeekDays=shaInitialInvoiceWeekDays($id);
		
		$bookingByShaId=bookingByShaId($id);
		see($bookingByShaId);
		echo date('Y-m-d',strtotime($bookingByShaId['booking_from'].' + '.$shaInitialInvoiceWeekDays.' days'));*/
		
		
		if(dayDiff(date('Y-m-d'),$id)<=8)
				echo 'Generate straightaway on '.$id;
		else
				echo 'We have to wait';		
		echo '<br>';		
		
		$date=date('Y-m-d',strtotime('+1 week'));
		echo $date;
	}
	
	function init($student)
	{
		$invoice=initialInvoiceBefore($student);
		see($invoice);
	}
	
	function deleteOngoingInvoice($id)
	{
		if(checkLogin())
			{
				if(userAuthorisations('latest_ongInv_delete') && ifOngInvIsLatest($id))
					$this->invoice_model->deleteOngoingInvoice($id);
			}
		else
			echo "LO";
	}
	
	function getOngInvItemDetails($itemId)
	{
		return $this->invoice_model->getOngInvItemDetails($itemId);
	}
	
	function getWeekItemIdOngStour($itemId)
	{
		return $this->invoice_model->getWeekItemIdOngStour($itemId);
	}
	
	function getDayItemIdOngStour($itemId)
	{
		return $this->invoice_model->getDayItemIdOngStour($itemId);
	}
	
	public function ajax_list_invoiceInitial()
	{
		$invoices = $this->invoice_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		
		$initial_invoice_statusPage=$_POST['initial_invoice_statusPage'];
		
		foreach($invoices as $inv)
			{
				$invoice=initialInvoiceDetails($inv->id);
				
				$row = array();
				$row['DT_RowId']= "invoice_".$inv->id;
				if($invoice['study_tour']=='0')
					{
						$student=getShaOneAppDetails($invoice['application_id']);
						if(empty($student))
							continue;
						$student['three']=getShaThreeAppDetails($invoice['application_id']);
						$client=clientDetail($student['client']);											
					}
					else	
					  {
						  $tourDetail=tourDetail($invoice['application_id']);
						  $client=clientDetail($tourDetail['client_id']);
					  }
				
				$initialInvoiceListTd=initialInvoiceListTd($invoice,$initial_invoice_statusPage);
				$row1=$initialInvoiceListTd['td1'];
				$row[]=$row1;
				
				$row2='';
				$row2 .='<a href="'.site_url().'client/edit/'.$client['id'].'" target="_blank">'.$client['bname'].'</a>';
				$row2 .='<br>'.$client['primary_contact_name'].' '.$client['primary_contact_lname'];
				$row2 .='<br>'.$client['primary_phone'];
				$row[]=$row2;
				
				$row3='';
				if($invoice['study_tour']=='0')
						{
							  $row3 .='<a href="'.site_url().'sha/application/'.$invoice['application_id'].'" target="_blank">'.$student['fname'].' '.$student['lname'].'</a>';
							  $row3 .='<br><a class="mailto" href="mailto:'.$student['email'].'">'.$student['email'].'</a>';
							  $row3 .="<br>";
							  $row3 .=$student['mobile'];
						}
				else
						{
							  $row3 .='Tour: <a href="'.site_url().'tour/all_students/'.$tourDetail['id'].'" target="_blank">'.$tourDetail['group_name'].'</a>';
							  $row3 .='<br><a class="mailto" href="mailto:'.$tourDetail['group_contact_email'].'">'.$tourDetail['group_contact_email'].'</a><br>'.$tourDetail['group_contact_phone_no'];
						}
				$row[]=$row3;
				
				$row4=$initialInvoiceListTd['td4'];
				$row[]=$row4;
				
				$row5=$initialInvoiceListTd['td_officeUse'];
				$row[]=$row5;
				
				$row6='';
				$row6 .='<div class="btn-group dropdown table-actions">';
				$row6 .='<button class="btn btn-sm btn-midnightblue dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="true">';
					$row6 .='<i class="colorBlue material-icons">more_horiz</i>';
					$row6 .='<div class="ripple-container"></div>';
				$row6 .='</button>';
				$row6 .='<ul class="dropdown-menu dropdown-menu-sidebar" role="menu">';
					$row6 .='<li>';
						if($invoice['moved_to_xero']==0 && $invoice['cancelled']!='1')
							$row6 .='<a href="javascript:void(0);" class="moveInvoiceToXero" data-toggle="modal" data-target="#model_moveInitialInvoiceToXero" onclick="$(\'#moveInitialInvoiceToXero_id\').val($(this).parents(\'tr\').attr(\'id\'));"><i class="font16 material-icons">redo</i>&nbsp;&nbsp;Move to Xero</a>';
						
					$row6 .='</li>';
					$row6 .='<li>';
						$row6 .='<a href="'.site_url().'invoice/view_initial/'.$invoice['id'].'" target="_blank"><i class="font16 material-icons">view_quilt</i>&nbsp;&nbsp;View invoice data</a>';
					$row6 .='</li>';
					if(isset($invoice['items_standard']))
					{
					$row6 .='<li>';
						$row6 .='<a href="'.site_url().'invoice/view_initial_student/'.$invoice['id'].'" target="_blank"><i class="font16 material-icons">view_quilt</i>&nbsp;&nbsp;View student invoice data</a>';
					$row6 .='</li>';
					 } 
					$row6 .='</ul>';
				$row6 .='</div>';
				$row[]=$row6;
				
				$data[] = $row;
			}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->invoice_model->count_all(),
						"recordsFiltered" => $this->invoice_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	public function ajax_list_invoiceOngoing()
	{
		$this->load->model('Invoice_ongoing_model');
		$invoices = $this->Invoice_ongoing_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		
		$initial_invoice_statusPage=$_POST['ongoing_invoice_statusPage'];
		
		foreach($invoices as $inv)
			{
				$invoice=ongoingInvoiceDetails($inv->id);
				
				$row = array();
				$row['DT_RowId']= "invoice_".$inv->id;
				if($invoice['study_tour']=='0')
					{
						$student=getShaOneAppDetails($invoice['application_id']);
						if(empty($student))
						continue;
						$student['three']=getShaThreeAppDetails($invoice['application_id']);
						$client=clientDetail($student['client']);											
					}
					else	
					  {
						  $tourDetail=tourDetail($invoice['application_id']);
						  $client=clientDetail($tourDetail['client_id']);
					  }

				$ongoingInvoiceListTd=ongoingInvoiceListTd($invoice,$initial_invoice_statusPage);
				$row1=$ongoingInvoiceListTd['td1'];
				$row[]=$row1;
				
				$row2='';
				$row2 .='<a href="<?=site_url()?>client/edit/'.$client['id'].'" target="_blank">'.$client['bname'].'</a>';
				$row2 .='<br>'.$client['primary_contact_name'].' '.$client['primary_contact_lname'];
				$row2 .='<br>'.$client['primary_phone'];
				$row[]=$row2;
				
				$row3='';
				if($invoice['study_tour']=='0')
						{
							  $row3 .='<a href="'.site_url().'sha/application/'.$invoice['application_id'].'" target="_blank">'.$student['fname'].' '.$student['lname'].'</a>';
							  $row3 .='<br><a class="mailto" href="mailto:'.$student['email'].'">'.$student['email'].'</a>';
							  $row3 .="<br>";
							  $row3 .=$student['mobile'];
						}
				else
						{
							  $row3 .='Tour: <a href="'.site_url().'tour/all_students/'.$tourDetail['id'].'" target="_blank">'.$tourDetail['group_name'].'</a>';
							  $row3 .='<br><a class="mailto" href="mailto:'.$tourDetail['group_contact_email'].'">'.$tourDetail['group_contact_email'].'</a><br>'.$tourDetail['group_contact_phone_no'];
						}
				$row[]=$row3;
				
				$row4=$ongoingInvoiceListTd['td4'];
				$row[]=$row4;
				
				$row5=$ongoingInvoiceListTd['td_officeUse'];
				$row[]=$row5;
				
				$row6='';
				$row6 .='<div class="btn-group dropdown table-actions">';
                                        $row6 .='<button class="btn btn-sm btn-midnightblue dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="true">';
                                            $row6 .='<i class="colorBlue material-icons">more_horiz</i>';
                                            $row6 .='<div class="ripple-container"></div>';
                                        $row6 .='</button>';
                                        $row6 .='<ul class="dropdown-menu dropdown-menu-sidebar" role="menu">';
                                            $row6 .='<li>';
                                            	if($invoice['moved_to_xero']==0)
	                                            	$row6 .='<a href="javascript:void(0);" class="moveInvoiceToXero" data-toggle="modal" data-target="#model_moveInitialInvoiceToXero" onclick="$(\'#moveInitialInvoiceToXero_id\').val($(this).parents(\'tr\').attr(\'id\'));"><i class="font16 material-icons">redo</i>&nbsp;&nbsp;Move to Xero</a>';
                                            $row6 .='</li>';
                                            $row6 .='<li>';
                                                $row6 .='<a href="'.site_url().'invoice/view_ongoing/'.$invoice['id'].'" target="_blank"><i class="font16 material-icons">view_quilt</i>&nbsp;&nbsp;View invoice data</a>';
                                            $row6 .='</li>';
                                            if(userAuthorisations('latest_ongInv_delete') && ifOngInvIsLatest($invoice['id'])){
                                                $row6 .='<li>';
                                                    $row6 .='<a href="javascript:;" onclick="deleteOngoingInvoice('.$invoice['id'].');" id="deleteOngoingInvoice-'.$invoice['id'].'"><i class="font16 material-icons">delete</i>&nbsp;&nbsp;Delete</a>';
                                                $row6 .='</li>';
                                             }
                                        $row6 .='</ul>';
                                        $row6 .='</div>';
				$row[]=$row6;
				
				$data[] = $row;
			}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->Invoice_ongoing_model->count_all(),
						"recordsFiltered" => $this->Invoice_ongoing_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
}