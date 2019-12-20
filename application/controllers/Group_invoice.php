<?php
class Group_invoice extends CI_Controller 
{

	function __construct()
		{
			parent::__construct();
			$this->load->model('group_invoice_model');
		}
		
		function getActionOnType($client)
		{
			if($client==26)
				$inv='homestay_servicesGI';
			else
				$inv='taylors_collegeGI';
			return $inv;	
		}
		
		function addGroupInvView($client,$id)
		{
			$inv=$this->getActionOnType($client);
			recentActionsAddData($inv,$id,'view');
		}
		
		function addGroupInvListView($client,$status)
		{
			$inv=$this->getActionOnType($client);
				
			if($status==0)
				$type='all';
			elseif($status==1)
				$type='pending';
			elseif($status==2)
				$type='partial';
			elseif($status==3)
				$type='paid';
			recentActionsAddData($inv,$type,'view');
		}
		
	  function all($client=0)
		  {
			  $status='0';
			  $this->invoiceList($status,$client);
		  }
		
	function pending($client=0)
		{
			$status='1';
			$this->invoiceList($status,$client);
		}
		
		function partial($client=0)
		{
			$status='2';
			$this->invoiceList($status,$client);
		}
		
		function paid($client=0)
		{
			$status='3';
			$this->invoiceList($status,$client);
		}
		
		function invoiceList($status,$client)
		{
			if(checkLogin())
			{
				if($client==0)
				header('location:'.site_url().'dashboard');
				$this->addGroupInvListView($client,$status);
					
				$data=array();
				$data['page']='groupInvoiceInitial';
				$data['initial_invoice_status']=$status;
				$filterGet=$_GET;
				$data['invoices']=$this->group_invoice_model->initialInvoicesList($status,$client);
				$data['client']=clientDetail($client);
				$this->load->view('system/header',$data);
				$this->load->view('system/group_invoice/list');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
		}
		
		function view($id)
		{
			if(checkLogin())
			{
				$data=array();
				$data['page']='invoice';
				$data['invoice']=$this->group_invoice_model->initialInvoiceDetails($id);
				if(empty($data['invoice']))
					header('location:'.site_url());
				
				$this->addGroupInvView($data['invoice']['client'],$id);
				$this->load->model('client_model');
				$data['client']=$this->client_model->clientDetail($data['invoice']['client']);
				//see($data);
				$this->load->view('system/header',$data);
				$this->load->view('system/group_invoice/view');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
		}
		
	function editInitialInvoiceItemPopContent()
	{
		if(isset($_POST['itemId']))
		{
			$data=$_POST;
			$data['invoice']=$this->group_invoice_model->initialInvoiceDetails($data['id']);
			$this->load->view('system/group_invoice/editItemForm',$data);
		}
	}
	
	function editInitialGroupInvoiceItemPopContentSubmit()
	{
		$data=$_POST;
		$this->group_invoice_model->editInvoiceItem($data);
		
		$data['invoice']=$this->group_invoice_model->initialInvoiceDetails($data['invoice_id']);
		$this->load->model('client_model');
		$data['client']=$this->client_model->clientDetail($data['invoice']['client']);
		
		$view_initial=$this->load->view('system/group_invoice/view',$data,true);
		$return['page']=$view_initial;
		echo json_encode($return);
	}
	
	function filters()
	{
		 $this->load->view('system/group_invoice/filters');
	}
	
	function invoice_upload()
	{
		//see($_FILES);
		
		$file=$_FILES['file']['tmp_name'];
		//$file = './csvfile/Taylors Payments Global 19072018.xls';
		$formOne=$this->readCsv($file);
		//see($formOne['values']);exit;
		
		$total=$imported=$ignoredNoBookings=$ignored0Nights=$ignoredMissing=0;
		$invoice=array();
		foreach($formOne['values'] as $valK=>$val)
			{
				$item=array();
				if(!isset($val['G']))
					continue;
				
				$total++;
				if($val['M']=='Nightly accommodation')
				{
					$valN=explode(' ',$val['N']);
					$item['qty']=$valN[0];
					$item['unit']=$valN[3];
				}
				else
				{
					$item['qty']='1';
					$item['unit']=$val['O'];
				}
				
				if($item['qty']==0)
				{
					$ignored0Nights++;
					continue;
				}
					
				$item['total']=$val['O'];
				$item['unit']=$item['total']/$item['qty'];
				
				$booking=$this->group_invoice_model->findBookingForInvoiceUpload($val);
				if(empty($booking))
					{
						$ignoredNoBookings++;
						continue;
					}
				else
					{
						if($booking==2)
						{
							$ignoredMissing++;
							continue;
						}
						$imported++;
					}
					
				$item['booking_id']=$booking['id'];
				$item['sha_id']=$booking['student'];
				$item['date_from']=$val['K'];//$item['date_from']='10-May-18';
				//$dateFrom= DateTime::createFromFormat( 'd-M-y', $item['date_from']);
				//$item['date_from']= $dateFrom->format( 'Y-m-d');
				
				$dateFrom = PHPExcel_Shared_Date::ExcelToPHP( $item['date_from'] );
				$item['date_from']=date('Y-m-d', $dateFrom);
				
				$item['date_to']=$val['L'];//$item['date_to']='10-May-18';
				/*$dateTo= DateTime::createFromFormat( 'd-M-y', $item['date_to']);
				$item['date_to']= $dateTo->format( 'Y-m-d');*/
				
				$dateTo = PHPExcel_Shared_Date::ExcelToPHP( $item['date_to'] );
				$item['date_to']=date('Y-m-d', $dateTo);
				
				$item['qty_unit']='2';
				
				if($val['M']=='Nightly accommodation')
				{
					$item['gst']='0';
					$item['type']='accomodation_ed';
				}
				elseif($val['M']=='Placement Fee')
				{
					$item['qty_unit']='0';
					$item['gst']='1';
					$item['type']='placement';
				}
				elseif($val['M']=='Clawback')
				{
					$item['gst']='0';
					$item['type']='clawback';
				}
				elseif($val['M']=='Ex-Gratia')
				{
					$item['gst']='0';
					$item['type']='Ex-Gratia';
				}
				
				$item['desc']=$val['I'].' '.$val['M'].' ('.$val['K'].' to '.$val['L'].')';
				
				
				if(!isset($invoice['date_from']))
					$invoice['date_from']=$item['date_from'];
				else
				{
					if(strtotime($invoice['date_from']) > strtotime($item['date_from']))
						$invoice['date_from']=$item['date_from'];
				}
				
				if(!isset($invoice['date_to']))
					$invoice['date_to']=$item['date_to'];
				else
				{
					if(strtotime($invoice['date_to']) < strtotime($item['date_to']))
						$invoice['date_to']=$item['date_to'];
				}	
				
				$invoice['date_to']=$item['date_to'];
				
				$invoice['items'][]=$item;
			}
			//echo $total.'-'.$imported.'-'.$ignoredNoBookings.'-'.$ignored0Nights.'-'.$ignoredMissing;
			//see($invoice);die();
			$postData['clientId']=$_POST['clientId'];
			if(isset($_POST['invoiceId']))
				$postData['invoiceId']=$_POST['invoiceId'];
			
			if(!empty($invoice))
				$this->group_invoice_model->invoiceUploadInsert($invoice,$postData);
			echo $total.'-'.$imported.'-'.$ignoredNoBookings.'-'.$ignored0Nights.'-'.$ignoredMissing;
	}
	
	
	function readCsv($file)
		  {
			  //load the excel library
					  $this->load->library('excel');
					  
					  //read file from path
		  $objPHPExcel = PHPExcel_IOFactory::load($file);
		  //get only the Cell Collection
		  $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
		  //extract to a PHP readable array format
		  foreach ($cell_collection as $cell) {
			  $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			  $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
			  $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
			  //header will/should be in row 1 only. of course this can be modified to suit your need.
			  if ($row == 1) {
				  $header[$row][$column] = $data_value;
			  } else {
				  $arr_data[$row][$column] = $data_value;
			  }
		  }
		  //send the data in an array format
		  $data['header'] = $header;
		  $data['values'] = $arr_data;
		  return $data;
		  }
		  
		 
		 function resetInvoice()
		 {
			 if(isset($_POST['resetGroupInvoiceId']))
			 {
				 $id=$_POST['resetGroupInvoiceId'];
				 $invoice=$this->group_invoice_model->initialInvoiceDetails($id);
				 if(empty($invoice))
					header('location:'.site_url());
				
				if($invoice['latest_invoice']=='1')	
				{
					$this->load->model('cron_model');
					$date=$invoice['date_from'];
					$clients=$this->cron_model->groupInvoiceClients($date,$invoice);
					//see($clients);
					
					$this->load->helper('product_helper');
					$groupInvStructure=getGroupInvStructure($clients,date('Y',strtotime($invoice['date_from'])));
					$groupInvStructure[0]['invoice_id']=$id;//see($groupInvStructure);
					$this->group_invoice_model->updateGroupInvItems($groupInvStructure);
				}
			 }
		 } 
		
	function deleteInvoiceItem()
	{
			$data=$_POST;
			if($data['itemId']!='')
			{
				$this->group_invoice_model->deleteInvoiceItem($data);
				$data['invoice']=$this->group_invoice_model->initialInvoiceDetails($data['id']);
				$this->load->model('client_model');
				$data['client']=$this->client_model->clientDetail($data['invoice']['client']);
				$view_initial=$this->load->view('system/group_invoice/view',$data,true);
				$return['page']=$view_initial;
				echo json_encode($return);
			}
	} 
}