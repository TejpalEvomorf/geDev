<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Xero_api extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('xero');
		$this->load->model(array('invoice_model','xero_model','po_model'));
		$this->load->helper('product');
	}

	public function index()
	{
		// 
	}
	
	function moveInitialInvoiceToXero()
	{
		if(checkLogin())
			{
				$data=$_POST;
				if(isset($data['invoiceId']))
				{
					$invoiceIdArray=explode('-',$data['invoiceId']);
					$invoiceId=$invoiceIdArray[1];
					$invoice=$this->invoice_model->initialInvoiceDetails($invoiceId);
					
					if($invoice['moved_to_xero']=='0')
						{
							if($invoice['study_tour']==0)
							{
								$data['student']=getShaOneAppDetails($invoice['application_id']);
								$client_id=$data['student']['client'];
							}
							else
							{
								$tourDetail=tourDetail($invoice['application_id']);
								$client_id=$tourDetail['client_id'];
							}
							
							$this->load->model('client_model');
							$data['client']=$this->client_model->clientDetail($client_id);
							if($data['client']['client_group']!='')
							{
								$clientGroupList=clientGroupList();
								$client_group=$clientGroupList[$data['client']['client_group']];
								$client_groupItem=array('TrackingCategory'=>array('Name' =>'Client Type','Option' => $client_group));
								$accountCodeList=clientGroupXeroAccountCodeList();
								$itemAccountCode=$accountCodeList[$data['client']['client_group']]['invoice'];
							}
							else
								$client_groupItem=array();
								
							$LineItem=array();
							foreach($invoice['items'] as $item)
							{
									if(in_array($item['type'],['accomodation','accomodation_ed']) && isset($itemAccountCode))
										$accountCode=$itemAccountCode;
									else
										$accountCode=$item['xero_code'];
									$LineItem[]=array(
											"Description" => $item['desc'].getWeekDayTextForXero($item['qty_unit']),
											"Quantity" => $item['qty'],
											"UnitAmount" => $item['unit'],
											"AccountCode" => $accountCode,
											"Tracking" => $client_groupItem
										);
							}
							
							$new_invoice = array(
							array(
								"Type"=>"ACCREC",
								"Contact" => array(
									"Name" => $data['client']['bname'],
									"Addresses"=>array(
											'Address'=>array(
												  'AddressLine1'=>$data['client']['street_address'],
												  'City'=>$data['client']['suburb'],
												  'State'=>$data['client']['state'],
												  'PostalCode'=>$data['client']['postal_code'],
												 ),								
											),
										),
								"Date" => date('Y-m-d'),
								"DueDate" =>date('Y-m-d', strtotime("+7 days")),
								"Status" => "DRAFT",
								"LineAmountTypes" => "Inclusive",
								"LineItems"=> array(
									"LineItem" => $LineItem
								)
							)
						);
						
								$invoice_result = $this->xero->Invoices($new_invoice);
								//see($invoice_result);
								if(isset($invoice_result->Status) && $invoice_result->Status=='OK')
								{
									$moveData['invoiceId']=$invoiceId;
									$moveData['invoiceNumber']=$invoice_result->Invoices->Invoice->InvoiceNumber;
									$moveData['xero_invoiceId']=$invoice_result->Invoices->Invoice->InvoiceID;
									$this->xero_model->moveInitialInvoiceToXero($moveData);
									$initialInvoiceDetails=$this->invoice_model->initialInvoiceDetails($invoiceId);
									$jsonResult['invoiceTd']=initialInvoiceListTd($initialInvoiceDetails,$data['pageStatus']);
									$jsonResult['xero_status']="<span style='opacity:0.5;'>Moved - ".date('d M Y',strtotime($initialInvoiceDetails['moved_to_xero_date'])).'</span> <a href="https://go.xero.com/AccountsReceivable/View.aspx?InvoiceID='.$initialInvoiceDetails['xero_invoiceId'].'" target="_blank">('.$initialInvoiceDetails['invoice_number'].')</a>';
									$jsonResult['result']="success";
									echo json_encode($jsonResult);
								}
								elseif(isset($invoice_result->ErrorNumber))
								{
									$jsonResult['result']="error";
									echo json_encode($jsonResult);
								}
					}
				}
			}
			else
			{
				$jsonResult['result']="LO";
				echo json_encode($jsonResult);
			}
	}
	
	function checkInitialInvoiceStatus()
	{
		if(checkLogin())
			{
				$data=$_POST;
				if(isset($data['invoiceNumber']) && $data['invoiceNumber']!='')
				{
					$invoice_id=getInvoiceIdFromInvoiceNumber($data['invoiceNumber']);
					if($invoice_id)
					{
						$invoice_result = $this->xero->Invoices($data['invoiceNumber']);
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
												$this->xero_model->initialInvoiceChangeStatus($invoice_id,'3');
											else
											{
												if($invoice_result->Invoices->Invoice->AmountPaid!=0.00)
													$this->xero_model->initialInvoiceChangeStatus($invoice_id,'2');
											}
											echo $response;
									  }
									  else
									  	echo 'noNewPayment';
								  }
							}
						}
					}
				}
			}
		else
			echo "LO";
	}
	
	
	function syncInitialInvoice()
	{
		if(checkLogin())
			{
				$return=array('partial'=>0,'partial_p2u'=>0,'partial_p2uT'=>0,'partialUpdated'=>0,'paid'=>0,'paid_u2p'=>0,'paid_p2p'=>0,'paid_u2pT'=>0,'paid_p2pT'=>0);
				$initialInvoices=$this->invoice_model->initialInvoicesListForSync();
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
													  $appMoved=$this->xero_model->initialInvoiceChangeStatus($invoice_id,'3');
													  $return['paid']++;
													  if($appMoved!='')
														  $return[$appMoved]++;
													}
												  else
												  {
													  if($invoice_result->Invoices->Invoice->AmountPaid!=0.00)
													  {
														  $appMoved=$this->xero_model->initialInvoiceChangeStatus($invoice_id,'2');
														  if($initialInvoiceDetails['status']==1)
															  $return['partial']++;
														  else if($initialInvoiceDetails['status']==2)
															  $return['partialUpdated']++;
														 if($appMoved!='')
														 	$return[$appMoved]++;
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
				$this->session->set_flashdata('invoiceSyncSummary',implode(',',$return));
			}
		else
			echo "LO";
	}
	
	
	function moveOngoingInvoiceToXero()
	{
		if(checkLogin())
			{
				$data=$_POST;
				if(isset($data['invoiceId']))
				{
					$invoiceIdArray=explode('-',$data['invoiceId']);
					$invoiceId=$invoiceIdArray[1];
					$invoice=$this->invoice_model->ongoingInvoiceDetails($invoiceId);
					
					if($invoice['moved_to_xero']=='0')
						{
							if($invoice['study_tour']==0)
							{
								$data['student']=getShaOneAppDetails($invoice['application_id']);
								$client_id=$data['student']['client'];
							}
							else
							{
								$tourDetail=tourDetail($invoice['application_id']);
								$client_id=$tourDetail['client_id'];
							}
							
							$this->load->model('client_model');
							$data['client']=$this->client_model->clientDetail($client_id);
							if($data['client']['client_group']!='')
							{
								$clientGroupList=clientGroupList();
								$client_group=$clientGroupList[$data['client']['client_group']];
								$client_groupItem=array('TrackingCategory'=>array('Name' =>'Client Type','Option' => $client_group));
								$accountCodeList=clientGroupXeroAccountCodeList();
								$itemAccountCode=$accountCodeList[$data['client']['client_group']]['invoice'];
							}
							else
								$client_groupItem=array();
							
							$LineItem=array();
							foreach($invoice['items'] as $item)
							{
									if(in_array($item['type'],['accomodation','accomodation_ed']) && isset($itemAccountCode))
										$accountCode=$itemAccountCode;
									else
										$accountCode=$item['xero_code'];
									$LineItem[]=array(
											"Description" => $item['desc'].getWeekDayTextForXero($item['qty_unit']),
											"Quantity" => $item['qty'],
											"UnitAmount" => $item['unit'],
											"AccountCode" => $accountCode,
											"Tracking" => $client_groupItem
										);
							}
							
							$new_invoice = array(
							array(
								"Type"=>"ACCREC",
								"Contact" => array(
									"Name" => $data['client']['bname'],
									"Addresses"=>array(
											'Address'=>array(
												  'AddressLine1'=>$data['client']['street_address'],
												  'City'=>$data['client']['suburb'],
												  'State'=>$data['client']['state'],
												  'PostalCode'=>$data['client']['postal_code'],
												 ),								
											),
										),
								"Date" => date('Y-m-d'),
								"DueDate" =>date('Y-m-d', strtotime("+7 days")),
								"Status" => "DRAFT",
								"LineAmountTypes" => "Inclusive",
								"LineItems"=> array(
									"LineItem" => $LineItem
								)
							)
						);
						
								$invoice_result = $this->xero->Invoices($new_invoice);
								//see($invoice_result);
								if(isset($invoice_result->Status) && $invoice_result->Status=='OK')
								{
									$moveData['invoiceId']=$invoiceId;
									$moveData['invoiceNumber']=$invoice_result->Invoices->Invoice->InvoiceNumber;
									$moveData['xero_invoiceId']=$invoice_result->Invoices->Invoice->InvoiceID;
									$this->xero_model->moveOngoingInvoiceToXero($moveData);
									$initialInvoiceDetails=$this->invoice_model->ongoingInvoiceDetails($invoiceId);
									$jsonResult['invoiceTd']=ongoingInvoiceListTd($initialInvoiceDetails,$data['pageStatus']);
									$invoiceNumber=(array)$moveData['invoiceNumber'];
									$jsonResult['xero_status']="<span style='opacity:0.5;'>Moved - ".date('d M Y',strtotime($initialInvoiceDetails['moved_to_xero_date'])).'</span> <a href="https://go.xero.com/AccountsReceivable/View.aspx?InvoiceID='.$initialInvoiceDetails['xero_invoiceId'].'" target="_blank">('.$initialInvoiceDetails['invoice_number'].')</a>';
									$jsonResult['result']="success";
									echo json_encode($jsonResult);
								}
								elseif(isset($invoice_result->ErrorNumber))
								{
									$jsonResult['result']="error";
									echo json_encode($jsonResult);
								}
					}
				}
			}
			else
			{
				$jsonResult['result']="LO";
				echo json_encode($jsonResult);
			}
	}
	
	
 function syncOngoingInvoice()
	{
		if(checkLogin())
			{
				$return=array('partial'=>0,'paid'=>0,'partialUpdated'=>0);
				$initialInvoices=$this->invoice_model->ongoingInvoicesListForSync();
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
													  $return['paid']++;
												  }
												  else
												  {
													  if($invoice_result->Invoices->Invoice->AmountPaid!=0.00)
													  {
														  $this->xero_model->ongoingInvoiceChangeStatus($invoice_id,'2');
														    if($ongoingInvoiceDetails['status']==1)
															  $return['partial']++;
														  else if($ongoingInvoiceDetails['status']==2)
															  $return['partialUpdated']++;
													  }
												  }
											}
										  }
								  }
							  }
						  }
						///////////////
					}
				}//see($return);
				$this->session->set_flashdata('invoiceSyncSummary',$return['partial'].','.$return['paid'].','.$return['partialUpdated']);
			}
		else
			echo "LO";
	}
	
	function checkOngoingInvoiceStatus()
	{
		if(checkLogin())
			{
				$data=$_POST;
				if(isset($data['invoiceNumber']) && $data['invoiceNumber']!='')
				{
					$invoice_id=getOngoingInvoiceIdFromInvoiceNumber($data['invoiceNumber']);
					if($invoice_id)
					{
						$invoice_result = $this->xero->Invoices($data['invoiceNumber']);
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
												$this->xero_model->ongoingInvoiceChangeStatus($invoice_id,'3');
											else
											{
												if($invoice_result->Invoices->Invoice->AmountPaid!=0.00)
													$this->xero_model->ongoingInvoiceChangeStatus($invoice_id,'2');
											}
											echo $response;
									  }
									  else
									  	echo 'noNewPayment';
								  }
							}
						}
					}
				}
			}
		else
			echo "LO";
	}
	
	function movePoToXero()
	{
		if(checkLogin())
			{
				$data=$_POST;
				if(isset($data['poId']))
				{
					$invoiceIdArray=explode('-',$data['poId']);
					$poId=$invoiceIdArray[1];
					$po=$this->po_model->poDetails($poId);
					
					if($po['moved_to_xero']=='0')
						{
							$bookingDetails=bookingDetails($po['booking_id']);
							$bankDetails=getHfaTwoAppDetailsBank($bookingDetails['host']);
							$data['host']=getHfaOneAppDetails($bookingDetails['host']);
							$data['student']=getShaOneAppDetails($bookingDetails['student']);
							$this->load->model('client_model');
							$data['client']=$this->client_model->clientDetail($data['student']['client']);
							if($data['client']['client_group']!='')
							{
								$clientGroupList=clientGroupList();
								$client_group=$clientGroupList[$data['client']['client_group']];
								$client_groupItem=array('TrackingCategory'=>array('Name' =>'Client Type','Option' => $client_group));
								$accountCodeList=clientGroupXeroAccountCodeList();
								$itemAccountCode=$accountCodeList[$data['client']['client_group']]['po'];
							}
							else
								$client_groupItem=array();
			 				if(!empty($bankDetails))
								  {
									  if(trim($bankDetails['acc_no'])=='' || trim($bankDetails['bsb'])=='')
										  $result='noBankDetails';
									  else
										  {
												// create array
												$LineItem=array();
												
												$getPoAdminFee=getPoAdminFee($po['items']);
											
												foreach($po['items'] as $item)
												{
													if(in_array($item['type'],['accomodation','accomodation_ed']) && isset($itemAccountCode))
														$accountCode=$itemAccountCode;
													else
														$accountCode=$item['xero_code'];
													
													$adminFeeInPercent=false;	
													if($item['type']=='adminFee' && $item['qty_unit']=='3')
														$adminFeeInPercent=true;
													
													if($adminFeeInPercent)
														$unitAmount= -1 * add_decimal($getPoAdminFee);
													else
													{
														$unitAmount=$item['unit'];
														if($item['type']=='adminFee' || $item['type']=='holidayDiscount')
															$unitAmount= -1 * abs($item['unit']);
													}
													
														$LineItem[]=array(
																"Description" => $item['desc'].getWeekDayTextForXero($item['qty_unit']),
																"Quantity" => $item['qty'],
																"UnitAmount" => $unitAmount,
																"AccountCode" => $accountCode,
																"Tracking" => $client_groupItem
															);
												} 
												
												$new_bill = array(
																					array(
																						//"InvoiceNumber"=>$bookingDetails['id'].': GE system booking id',
																						"InvoiceNumber"=>$bookingDetails['id'].': '.$data['student']['lname'].', '.date('d M Y',strtotime($po['from'])).' - '.date('d M Y',strtotime($po['to'])),
																						"Type"=>"ACCPAY",
																						"Contact" => array(
																							"Name" => $data['host']['fname'].' '.$data['host']['lname'],
																							'BankAccountDetails'=>$bankDetails['bsb'].' - '.$bankDetails['acc_no'],
																							"Addresses"=>array(
																									'Address'=>array(
																										  'AddressLine1'=>$data['host']['street'],
																										  'City'=>$data['host']['suburb'],
																										  'State'=>$data['host']['state'],
																										  'PostalCode'=>$data['host']['postcode'],
																										 ),								
																									),
																								),
																						"Date" => date('Y-m-d'),
																						"DueDate" =>$po['due_date'],
																						"PlannedPaymentDate"=>$po['due_date'],
																						"Status" => "DRAFT",
																						"LineAmountTypes" => "Inclusive",
																						"LineItems"=> array(
																							"LineItem" => $LineItem
																						)
																					)
																				);
											/////////
											$invoice_result = $this->xero->Invoices($new_bill);//see($invoice_result);
											if(isset($invoice_result->Status) && $invoice_result->Status=='OK')
											  {
												  $moveData['poId']=$poId;
												  $moveData['xero_poId']=$invoice_result->Invoices->Invoice->InvoiceID;
												  $this->xero_model->movePoToXeroUpdateDatabase($moveData);
												  $result="success";
												}
											  elseif(isset($invoice_result->ErrorNumber))
											  	$result="error";
												
											/////////////
										  }
								  }
								  else
									  $result='noBankDetails';
						}
						else//already moved
							$result="errorsss";
				}
				else//if poid not sent in ajax
					$result="error";
			}
			else
				$result="LO";
			
			$jsonResult['result']=$result;
			if($result=='success')
			{
				$po=$this->po_model->poDetails($poId);
				$jsonResult['poTd']=poListTd($po,$data['pageStatus']);
				$jsonResult['xero_status']="<span style='opacity:0.5;'>Moved - ".date('d M Y',strtotime($po['moved_to_xero_date'])).'</span> <a href="https://go.xero.com/AccountsPayable/View.aspx?InvoiceID='.$po['po_id_xero'].'" target="_blank">(Xero)</a>';
			}
			echo json_encode($jsonResult);
		}
	
	
	/*function syncPo()
	{
		if(checkLogin())
			{
				$pos=$this->po_model->poListForSync();
				foreach($pos as $po)
				{
					if($po['moved_to_xero']=='1')
					{
   						  $po_result = $this->xero->Invoices($po['po_id_xero']);	
						  if(is_object($po_result))
						  {
							  if($po_result->Status=='OK')
							  {
								  if($po_result->Invoices->Invoice->Status=='PAID')
								    $this->po_model->markPoBilled($po['id']);
							  }
						  }
					}
				}
			}
		else
			echo "LO";
	}*/
	
	
	function syncPo()
	{
		if(checkLogin())
			{
				$return=array('partial'=>0,'paid'=>0,'partialUpdated'=>0);
				$pos=$this->po_model->poListForSync();
				foreach($pos as $po)
				{
					if($po['moved_to_xero']=='1')
					{
   						  $po_result = $this->xero->Invoices($po['po_id_xero']);	
						   $pODetails=$this->po_model->poDetails($po['id']);
						  if(is_object($po_result))
						  {
							  if($po_result->Status=='OK')
							  {//see($po_result);
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
													  $return['paid']++;
													}
													else
												  {
													  if($po_result->Invoices->Invoice->AmountPaid!=0.00)
													  {
														  $appMoved=$this->xero_model->pOChangeStatus($po['id'],'3');
														  if($pODetails['status']==1)
															  $return['partial']++;
														  else if($pODetails['status']==3)
															  $return['partialUpdated']++;
													  }
												  }
									  }
								   }
								  
								  /*if($po_result->Invoices->Invoice->Status=='PAID')
								    $this->po_model->markPoBilled($po['id']);*/
							  }
						  }
					}
				}
				$this->session->set_flashdata('invoiceSyncSummary',$return['partial'].','.$return['paid'].','.$return['partialUpdated']);
			}
		else
			echo "LO";
	}
	
	
	
	function moveGroupInvInitialInvoiceToXero()
	{
		if(checkLogin())
			{
				$data=$_POST;
				if(isset($data['invoiceId']))
				{
					$invoiceIdArray=explode('-',$data['invoiceId']);
					$invoiceId=$invoiceIdArray[1];
					$this->load->model('group_invoice_model');
					$invoice=$this->group_invoice_model->initialInvoiceDetails($invoiceId);
					
					if($invoice['moved_to_xero']=='0')
						{
							$client_id=$invoice['client'];
							
							$this->load->model('client_model');
							$data['client']=$this->client_model->clientDetail($client_id);
							if($data['client']['client_group']!='')
							{
								$clientGroupList=clientGroupList();
								$client_group=$clientGroupList[$data['client']['client_group']];
								$client_groupItem=array('TrackingCategory'=>array('Name' =>'Client Type','Option' => $client_group));
								$accountCodeList=clientGroupXeroAccountCodeList();
								$itemAccountCode=$accountCodeList[$data['client']['client_group']]['invoice'];
							}
							else
								$client_groupItem=array();
							
							$LineItem=array();
							foreach($invoice['items'] as $item)
							{
									if(in_array($item['type'],['accomodation','accomodation_ed']) && isset($itemAccountCode))
										$accountCode=$itemAccountCode;
									else
										$accountCode=$item['xero_code'];
									$LineItem[]=array(
											"Description" => $item['desc'].getWeekDayTextForXero($item['qty_unit']),
											"Quantity" => $item['qty'],
											"UnitAmount" => $item['unit'],
											"AccountCode" => $accountCode,
											"Tracking" => $client_groupItem
										);
							}
							
							$new_invoice = array(
							array(
								"Type"=>"ACCREC",
								"Contact" => array(
									"Name" => $data['client']['bname'],
									"Addresses"=>array(
											'Address'=>array(
												  'AddressLine1'=>$data['client']['street_address'],
												  'City'=>$data['client']['suburb'],
												  'State'=>$data['client']['state'],
												  'PostalCode'=>$data['client']['postal_code'],
												 ),								
											),
										),
								"Date" => date('Y-m-d'),
								"DueDate" =>date('Y-m-d', strtotime("+7 days")),
								"Status" => "DRAFT",
								"LineAmountTypes" => "Inclusive",
								"LineItems"=> array(
									"LineItem" => $LineItem
								)
							)
						);
						
								$invoice_result = $this->xero->Invoices($new_invoice);
								//see($invoice_result);
								if(isset($invoice_result->Status) && $invoice_result->Status=='OK')
								{
									$moveData['invoiceId']=$invoiceId;
									$moveData['invoiceNumber']=$invoice_result->Invoices->Invoice->InvoiceNumber;
									$moveData['xero_invoiceId']=$invoice_result->Invoices->Invoice->InvoiceID;
									$this->xero_model->moveInitialGroupInvToXero($moveData);
									$initialInvoiceDetails=$this->group_invoice_model->initialInvoiceDetails($invoiceId);
									$jsonResult['invoiceTd']=initialGroupInvoiceListTd($initialInvoiceDetails,$data['pageStatus']);
									$jsonResult['xero_status']="<span style='opacity:0.5;'>Moved - ".date('d M Y',strtotime($initialInvoiceDetails['moved_to_xero_date'])).'</span> <a href="https://go.xero.com/AccountsReceivable/View.aspx?InvoiceID='.$initialInvoiceDetails['xero_invoiceId'].'" target="_blank">('.$initialInvoiceDetails['invoice_number'].')</a>';
									$jsonResult['result']="success";
									echo json_encode($jsonResult);
								}
								elseif(isset($invoice_result->ErrorNumber))
								{
									$jsonResult['result']="error";
									echo json_encode($jsonResult);
								}
					}
				}
			}
			else
			{
				$jsonResult['result']="LO";
				echo json_encode($jsonResult);
			}
	}
	
	
	function syncGroupInitialInvoice()
	{
		if(checkLogin())
			{
				$this->load->model('group_invoice_model');
				$return=array('partial'=>0,'partial_moved'=>0,'partialUpdated'=>0,'paid'=>0,'paid_moved'=>0);
				$initialInvoices=$this->group_invoice_model->initialInvoicesListForSync();
				foreach($initialInvoices as $invoice)
				{
					if($invoice['moved_to_xero']=='1')
					{
						  ////////////
						 /* $invoice_id=getInvoiceIdFromInvoiceNumber($invoice['invoice_number']);
						  if($invoice_id)
						  {*/$invoice_id=$invoice['id'];
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
													  $return['paid']++;
													  $return['paid_moved']+=$appMoved;
													}
												  else
												  {
													  if($invoice_result->Invoices->Invoice->AmountPaid!=0.00)
													  {
														  $appMoved=$this->group_invoice_model->initialInvoiceChangeStatus($invoice_id,'2');
														  if($initialInvoiceDetails['status']==1)
														  {
															  $return['partial']++;
															  $return['partial_moved']+=$appMoved;
														  }
														  else if($initialInvoiceDetails['status']==2)
															  $return['partialUpdated']++;
														}
												  }
											}
										  }
								  }
							  }
						  /*}*/
						///////////////
					}
				}see($return);
				$this->session->set_flashdata('invoiceSyncSummary',implode(',',$return));
			}
		else
			echo "LO";
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function addInvoice()
	{
		$new_invoice = array(
			array(
				"Type"=>"ACCREC",
				"Contact" => array(
					"Name" => "Sorav",
					"EmailAddress" => "sachin@sachin.com",
					"Addresses"=>array(
							  'Address'=>array(
									'AddressLine1'=>'21, good st.',
									'City'=>'Harris park',
									'State'=>'NSW',
									'PostalCode'=>'2150'
									),								
							),
				),
				"Date" => "2017-11-30",
				"DueDate" => "2017-12-06",
				"Status" => "AUTHORISED",
				"LineAmountTypes" => "Inclusive",
				"LineItems"=> array(
					"LineItem" => array(
						array(
							"Description" => "Test invoicesss",
							"Quantity" => "2.0000",
							"UnitAmount" => "2646.00",
							"AccountCode" => "43200"
						),
						array(
							"Description" => "dicount",
							"Quantity" => "2.0000",
							"UnitAmount" => "-646.00",
							"AccountCode" => "43200"
						)
					)
				)
			)
		);
		
				$invoice_result = $this->xero->Invoices($new_invoice);
				see($invoice_result);
				
				if(isset($invoice_result->Status) && $invoice_result->Status=='OK')
					echo "Success".$invoice_result->Invoices->Invoice->InvoiceNumber;
				elseif(isset($invoice_result->ErrorNumber))
					echo "Error";
	}
	
	function deleteInvoice()
	{
		$InvoiceNumber='ORC1044';
		$invoice_result = $this->xero->Invoices($InvoiceNumber);
		$invoiceStatus=$invoice_result->Invoices->Invoice->Status;
		if($invoiceStatus=='DRAFT')
			$status='DELETED';
		elseif($invoiceStatus=='AUTHORISED')
			$status='VOIDED';
			
		$new_invoice = array(
			array(
				"InvoiceNumber"=>$InvoiceNumber,
				"Status" => $status
			)
		);
		
				$invoice_result = $this->xero->Invoices($new_invoice);
				see($invoice_result);
				
				/*if(isset($invoice_result->Status) && $invoice_result->Status=='OK')
					echo "Success".$invoice_result->Invoices->Invoice->InvoiceNumber;
				elseif(isset($invoice_result->ErrorNumber))
					echo "Error";*/
	}
	
	
	function view($new_invoice)
	{
				//$new_invoice = "ORC1073";
				$invoice_result = $this->xero->Invoices($new_invoice);
				if(!is_object($invoice_result))
					echo "Not found.";
				else	
				{
					see($invoice_result);
				
					if($invoice_result->Status=='OK')
					{
						echo "Id: ".$invoice_result->Id;
						echo "<br>";
						echo "Invoice number: ".$invoice_result->Invoices->Invoice->InvoiceNumber;
						echo "<br>";
						echo "Invoice id: ".$invoice_result->Invoices->Invoice->InvoiceID;
						echo "<br>";
						echo "Status: ".$invoice_result->Invoices->Invoice->Status;
						$payments=$invoice_result->Invoices->Invoice->Payments->Payment;
						echo "<br>";
						if(isset($payments))
							{	see($payments);
								echo count($payments);
								foreach($payments as $pay)
								{
									echo "<br>".$pay->Amount;
								}
							}
					}
				}
				
	}
	
		function view2()
	{
				//$new_invoice = "ORC1060";
				//$new_invoice=array('IsReconciled'=>true);
				$new_invoice=array('invoice'=>'ORC1060');
				//$invoice_result = $this->xero->Payments($new_invoice);
				$invoice_result = $this->xero->Payments($new_invoice);
				see($invoice_result);
				
				/*if($invoice_result->Status=='OK')
				{
					echo "Id: ".$invoice_result->Id;
					echo "<br>";
					echo "Invoice number: ".$invoice_result->Invoices->Invoice->InvoiceNumber;
					echo "<br>";
					echo "Invoice id: ".$invoice_result->Invoices->Invoice->InvoiceID;
					$payments=$invoice_result->Invoices->Invoice->Payments;
					echo "<br>";
					echo count($payments->Payment);
					foreach($payments->Payment as $pay)
					{
						echo "<br>".$pay->Amount;
					}
				}*/
				
	}
	
	
	function addBill()
	{
		$new_invoice = array(
			array(
			"InvoiceNumber"=>'123 Test',
				"Type"=>"ACCPAY",
				"Contact" => array(
					"Name" => "Sorav",
					"EmailAddress" => "tejpal@tej.com",
					"Addresses"=>array(
							  'Address'=>array(
									'AddressLine1'=>'21, good st.',
									'City'=>'Harris park',
									'State'=>'NSW',
									'PostalCode'=>'2150'
									),								
							),
				),
				"Date" => "2018-11-22",
				"DueDate" => "2018-12-01",
				"PlannedPaymentDate"=> "2018-12-02",
				"Status" => "DRAFT",
				"LineAmountTypes" => "Inclusive",
				"LineItems"=> array(
					"LineItem" => array(
						array(
							"Description" => "Test invoicesss",
							"Quantity" => "2.0000",
							"UnitAmount" => "2646.00",
							"AccountCode" => "43200"
						)
					)
				)
			)
		);
		
				$invoice_result = $this->xero->Invoices($new_invoice);
				see($invoice_result);
				
				if(isset($invoice_result->Status) && $invoice_result->Status=='OK')
					echo "Success".$invoice_result->Invoices->Invoice->InvoiceNumber;
				elseif(isset($invoice_result->ErrorNumber))
					echo "Error";
	}
	
	function test()
	{
		//$initialInvoices=$this->invoice_model->initialInvoicesListForSync();
		//see($initialInvoices);
		//$invoices=[25321,25318,25291,25278,25269];
		$invoices='?InvoiceNumbers=25321,25318,25291,25278,25269';
		$invoice_result = $this->xero->Invoices($invoices);
		see($invoice_result);
	}
}
