<?php
class Ztest extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Po_model');
		$this->load->helper('test_helper');
	}
	
	function query()
	{
		$desc="The Ninety-five Theses are a list of propositions written by Martin Luther that started the Protestant Reformation, a schism in the Catholic Church. Luther, a professor of moral theology at the University of Wittenberg, Germany, enclosed them in a letter to the Archbishop of Mainz on 31 October 1517, a date now commemorated annually as Reformation Day. They advance Luther's positions against the selling of plenary indulgences, certificates that were said to reduce the punishment for sins in purgatory. Luther claimed that his positions accorded with those of the pope, but the Theses contradict a 14th-century papal bull. Luther's ecclesiastical superiors had him tried for heresy, which culminated in his excommunication in 1521.";
		$desc=$this->db->escape_like_str($desc);
		$sql="update `some_table` set `desc`='".$desc."'";
		$this->db->query($sql);
		
		/*$sql="update `some_table` set `desc`=?";
		$this->db->query($sql,$desc);*/
		
		echo $this->db->last_query();
	}
	
	function one($id)
	{
		/*$shaInitialInvoiceWeekDays=shaInitialInvoiceWeekDays($id);
		see($shaInitialInvoiceWeekDays);*/
		
		$shaOngoingInvoiceWeekDays=shaOngoingInvoiceWeekDays($id);
		see($shaOngoingInvoiceWeekDays);
	}
	
	function PO($booking_id)
	{
		$bookingDetails=bookingDetails($booking_id);
		//see($bookingDetails);
		$booking_from=$bookingDetails['booking_from'];
		$booking_to=$bookingDetails['booking_to'];
		//$booking_from='2017-12-20';$booking_to='2018-02-02';
		
		$poDate['from']=$booking_from;
		$poDate['to']=date('Y-m-d',strtotime($booking_from .' + 4 weeks'));
		if(strtotime($poDate['to'])>strtotime($booking_to) && $booking_to!='0000-00-00')
			$poDate['to']=$booking_to;
		//see($poDate);
		
		return $poDate;
	}
	
	function POList($date)
	{
		$day=date('D',strtotime($date));
		if($day=='Fri')
		{
			$bookings=$this->po_bookings($date);
			$po_structure=array();
			foreach($bookings as $booking)
				$po_structure[]=$this->po_structure($booking['id']);
			
			see($po_structure);
		}
		else
			echo "notFriday";
	}
	
	function po_bookings($date)
	{
		$dateDuration=getPoDateByPoCreateDate($date);//see($dateDuration);
		$bookings=$this->Po_model->po_bookingsByDateDuration($dateDuration);
		return $bookings;
	}
	
	function po_structure($booking_id)
	{
		$bookingDetails=bookingDetails($booking_id);
		//see($bookingDetails);
		$roomDetails=roomDetails($bookingDetails['id']);
		//see($roomDetails);
		
		//Getting the duration of PO
		$po_from=$bookingDetails['booking_from'];
		$po_to=date('Y-m-d',strtotime($po_from.' + 4 weeks'));
		if(strtotime($po_to) > strtotime($bookingDetails['booking_to']))
			$po_to=$bookingDetails['booking_to'];
		
		//
		$ongoingInvoiceItemCreater=ongoingInvoiceItemCreater($po_from,$po_to);
		//see($ongoingInvoiceItemCreater);
		
		$accomodation_type='Single Room 18+';
		//$roomDetails['type']
		
		$item=array();
		$po_structure=array();
		$po_structure['booking_id']=$bookingDetails['id'];
		$po_structure['po_from']=$po_from;
		$po_structure['po_to']=$po_to;
		
		foreach($ongoingInvoiceItemCreater as $ong)
		{
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
		
		$po_structure['items']=$items;
		return $po_structure;
	}
	
	function poOngoing()
	{
		$date='2017-12-01';
		
		$dateDuration=getPoDateByPoCreateDate($date);//see($dateDuration);
		$po=$this->Po_model->poOngoing($dateDuration);
		see($po);
		
		 foreach($po as $booking)
				  $po_structure[]=$this->sdfs($booking['booking_id'],$booking);
			  
		see($po_structure);
	}
	
	function sdfs($booking_id,$ongoing=0)
	{
		$bookingDetails=bookingDetails($booking_id);
		//see($bookingDetails);
		
		//Accomodation type
		$student=getshaOneAppDetails($bookingDetails['student']);
		$age=age_from_dob($student['dob']);
		if($student['accomodation_type']==1 && $age<18)
			$accomodation_type='Single Room 18+';
		elseif($student['accomodation_type']==1 && $age>=18)
			$accomodation_type='Single Room 18+';
		else if($student['accomodation_type']==2)
			$accomodation_type='Twin Share';
		else if($student['accomodation_type']==3)
			$accomodation_type='Self-Catered';
		else if($student['accomodation_type']==4)
			$accomodation_type='VIP Single Room';
		else if($student['accomodation_type']==5)
			$accomodation_type='VIP Self-Catered';
			
		//see($roomDetails);
		
		//Getting the duration of PO
		$po_from=$bookingDetails['booking_from'];
		if($ongoing!=0)
			$po_from=$ongoing['to'];
		$po_to=date('Y-m-d',strtotime($po_from.' + 4 weeks'));
		if(strtotime($po_to) > strtotime($bookingDetails['booking_to']))
			$po_to=$bookingDetails['booking_to'];
		
		if($po_from==$po_to)
			echo "No<br>";
		else	
			echo $po_from.' to '.$po_to.'<br>';
	}
	
	
	
	function addContact()
	{
		$this->load->library('xero');
		
		$new_invoice = array(
			array(
				"Name"=>"333111 locks",
				"FirstName" => "3321LapJeww4y1",
				"LastName" => "332211Singh4wwy1",
				"EmailAddress" => "qqq3322wwwlapjetbbjjy44@evomorf.com",
				"Addresses"=> array(
					"Address" => array(
						array(
							"AddressType" => "STREET",
							"AddressLine1" => "23 good st.",
							"City" => "Harris park",
							"Region" => "nsw",
							"PostalCode" => "2150"
						)
					)
				),
				'BankAccountDetails'=>'Account number:34345223 BSB:4522345'
			)
		);
		
		
		/*$new_invoice = array(
			array(
				"Name"=>"",
				"FirstName" => "11LapJeww4y1",
				"LastName" => "11Singh4wwy1",
				"EmailAddress" => "",
				"Addresses"=> array(
					"Address" => array(
						array(
							"AddressType" => "STREET",
							"AddressLine1" => "23 good st.",
							"City" => "Harris park",
							"Region" => "nsw",
							"PostalCode" => "2150"
						)
					)
				),
				'BankAccountDetails'=>'Account number:34345223 BSB:4522345'
			)
		);*/
		
				$invoice_result = $this->xero->Contacts($new_invoice);
				see($invoice_result);
				
				if(isset($invoice_result->Status) && $invoice_result->Status=='OK')
					echo "Success ".$invoice_result->Contacts->Contact->ContactID;
				elseif(isset($invoice_result->ErrorNumber))
					echo "Error";
	}
	
	
	function addPo()
	{
		$this->load->library('xero');
		
		$LineItem[]=array(
				'Description'=>'helalskdj als',
				'Quantity'=>'6',
				'UnitAmount'=>'200'
			);
			
		$LineItem[]=array(
				'Description'=>'helalskdj als',
				'Quantity'=>'7',
				'UnitAmount'=>'400'
			);	
			
		$LineItem[]=array(
				'Description'=>'helalskdj als',
				'Quantity'=>'4',
				'UnitAmount'=>'300'
			);	
		
		$new_invoice = array(
			array(
				"Contact"=>array(
					'ContactID'=>'fce6a932-43da-46af-8115-dafbbedb3ba3',
				),
				'Date'=>date('Y-m-d'),
				"LineItems"=> array(
									"LineItem" => $LineItem
								),
				'Reference'=>'Booking id: 56'
			)
		);
		
				$invoice_result = $this->xero->PurchaseOrders($new_invoice);
				see($invoice_result);
				
				if(isset($invoice_result->Status) && $invoice_result->Status=='OK')
					echo "Success ".$invoice_result->PurchaseOrders->PurchaseOrder->PurchaseOrderID;
				elseif(isset($invoice_result->ErrorNumber))
					echo "Error";
	}
	
	
	function viewPo($po_no)
	{
				
				$this->load->library('xero');
				$po=$po_no;
				//$invoice_result = $this->xero->Payments($new_invoice);
				$invoice_result = $this->xero->PurchaseOrders($po);
				see($invoice_result);
				echo $invoice_result->Status;
				 echo ' '.$invoice_result->PurchaseOrders->PurchaseOrder->Status;
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
	
	function iwd($from,$to)
	{
		$invoiceWeekDay=invoiceWeekDay($from,$to);
		$invoiceWeekDay=$dayDiff=dayDiff($from,$to);
		see($invoiceWeekDay);
	}
	
	function umd5()
	{
		/*$insertPetVal=array(' Cat','dog','bird');
		$insertPetVal=array_map('trim', array_map('strtolower', $insertPetVal));
		if(in_array('cat',$insertPetVal))
			echo "Yes";
		else
			echo "No";	*/
			
			see(explode('(','yessldkfj)'));
	}
	
	function tourInv($id)
	{
		$inv=studyTourInitialInvoiceItems($id);
		see($inv);
		//echo date('Y-m-d',strtotime($inv[0]['booking_from'].' + 4 weeks'));
	}
	
	function shaInv($id)
	{
		$this->load->model('invoice_model');
		$inv=$this->invoice_model->initialInvoiceBefore($id);
		see($inv);
	}
	
	function shaInvUp($id,$from,$to)
	{
		$this->load->model('invoice_model');
		$inv=$this->invoice_model->initialInvoiceBeforeUpdate($id,$from,$to);
		see($inv);
	}	
	
	function shaOngInv($booking_id)
	{
		addNewOngoingInvoice($booking_id);
	}
	
	function diff($from,$to)
	{
		echo dayDiff($from,$to).' days';
	}
	
	function addDays($date,$days)
	{echo $date.' '.$days."<br>";
		echo date('Y-m-d',strtotime($date.' + '.$days.' days'));
	}
	
	/*function testSyncSuccess($partial,$paid,$appMoved,$partialUpdated)
	{
		$this->session->set_flashdata('invoiceSyncSummary',$partial.','.$paid.','.$appMoved.','.$partialUpdated);
		
		$res['partial']=$partial;
			$res['partial_u2p']=$partial;
			$res['partial_u2pT']=$partial;
		$res['partialUpdate']=$partialUpdated;
		$res['paid']=$paid;
			$res['paid_u2p']=$paid;
			$res['paid_p2p']=$paid;
			$res['paid_u2pT']=$paid;
			$res['paid_p2pT']=$paid;
		
		$this->session->set_flashdata('invoiceSyncSummary',$res['partial'].'-'.$res['partial_u2p'].'-'.$res['partial_u2pT'].','.$res['partialUpdate'].','.$res['paid'].'-'.$res['paid_u2p'].'-'.$res['paid_p2p'].'-'.$res['paid_u2pT'].'-'.$res['paid_p2pT']);
	}*/
	
	function testSyncSuccess($partial,$paid,$partialUpdated)
	{
		$res['partial']=$partial;
			$res['partial_u2p']=$partial;
			$res['partial_u2pT']=$partial;
		$res['partialUpdate']=$partialUpdated;
		$res['paid']=$paid;
			$res['paid_u2p']=$paid;
			$res['paid_p2p']=$paid;
			$res['paid_u2pT']=$paid;
			$res['paid_p2pT']=$paid;
		
		$this->session->set_flashdata('invoiceSyncSummary',implode(',',$res));
	}


	function testSyncSuccessOng($partial,$paid,$partialUpdated)
	{
		$this->session->set_flashdata('invoiceSyncSummary',$partial.','.$paid.','.$partialUpdated);
	}	
	
	function testSyncSuccessPO($partial,$paid,$partialUpdated)
	{
		$this->session->set_flashdata('invoiceSyncSummary',$partial.','.$paid.','.$partialUpdated);
	}	
	
	function checkPo()
	{
   						  $this->load->library('xero');
						  $po_result = $this->xero->Invoices('b1e53910-473c-46a3-b3cb-38ece571220e');	
						  see($po_result);
						  if(is_object($po_result))
						  {
							  if($po_result->Status=='OK')
							  {
								  if($po_result->Invoices->Invoice->Status=='PAID')
								    echo "<br> Status: PAID";
								 else	
								 	echo "<br> Status: NOT PAID";
							  }
						  }
						}
						
	function intersect()
	{
		$bookingIdsArrayHost=array(1,2,3,4);
		$bookingIdsArrayHost=array();
		$bookingIdsArraySTour=array(3,4,5,6);
		$bookingIdsArray=array_intersect($bookingIdsArrayHost,$bookingIdsArraySTour);
		see($bookingIdsArrayHost);
		see($bookingIdsArraySTour);
		see($bookingIdsArray);
		
	}
	
	function testEmail()
	{$this->load->library('email');
	$this->email->clear();
		/*$config = Array(
    'protocol' => 'smtp',
    'smtp_host' => 'ezihost.ezihosting.com',
    'smtp_port' => 465,
    'smtp_user' => 'no-reply@globalexperience.com.au',
    'smtp_pass' => 'beatify#@.me',
    'mailtype'  => 'html',
    'charset'   => 'iso-8859-1',
	'smtp_crypto' => 'ssl' 
);
 $this->email->initialize($config);*/
			  
			  /*$config = Array(
    'protocol' => 'smtp',
    'smtp_host' => 'smtp.office365.com',
    'smtp_port' => 587,
    'smtp_user' => 'no-reply@globalexperience.com.au',
    'smtp_pass' => 'beatify#@.me',
	//'smtp_pass' => 'Password23',
    'mailtype'  => 'html',
    'charset'   => 'iso-8859-1',
	'smtp_crypto' => 'TLS' 
);
			  $this->email->initialize($config);*/
			  
			  $this->email->from(header_from_email(),header_from());

			  $this->email->subject('Tesing SMTP');
			  $to =  'tejpal.1988@evomorf.com';
			 $to =  'tejpal.1988@gmail.com';
			  $this->email->to($to);

			  $email_msg_user='<p style="color:red;">Hello</p>';
			  $email_msg_user .='<p>Email sent using SMTP</p>';
			  $this->email->message($email_msg_user);

			  $this->email->send();
			  
			  echo "email sent ";
	}
	
	
	function bookingsCsv()
	{
			$this->load->library('excel');
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle('test worksheet');
		
			$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
					'font'=>array(
					'name'      =>  'Arial',
					'size'      =>  10,
				)
			));
			
			for($c='A';$c<='E';$c++)
			$this->excel->getActiveSheet()->getColumnDimension($c)->setAutosize(true);
			
			/*$excel_table_headings_new=array(
			  'A'=>'Booking id',
			  'B'=>'Student id',
			  'C'=>'Student name',
			  'D'=>'Family id',
			  'E'=>'Family name',
			  'F'=>'Booking Start date',
			  'G'=>'Booking End date',
			  'H'=>'Booking status',
			  'I'=>'Study tour name',
			  'J'=>'Initial invoice start date',
			  'K'=>'Initial invoice end date',
			  'L'=>'Ongoing invoice start date',
			  'M'=>'Ongoing invoice end date',
		  );*/
		  
		  $excel_table_headings_new=array(
			  'A'=>'Booking id',
			  'B'=>'Student',
			  'C'=>'College',
			  'D'=>'Arrival date',
			  'E'=>'Family name',
			);	
		  
		  		$x_start=1;
		  		foreach($excel_table_headings_new as $k=>$v)
				{
					$this->excel->getActiveSheet()->setCellValue($k.$x_start, $v);
				}
				$this->excel->getActiveSheet()->getStyle('A'.$x_start.':E'.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
				$this->excel->getActiveSheet()->getStyle('A'.$x_start.':E'.$x_start)->getFont()->setSize(10)->setBold(true);
			 	
				$x=$x_start+1;
				$this->load->model('zimport_model');
				$bookings=$this->zimport_model->bookingListForCsv();
				
				$bookingStatusList=bookingStatusList();
				foreach($bookings as $booking)
				{
					/*$booking_from=date('d-m-Y',strtotime($booking['booking_from']));
					if($booking['booking_to']!='0000-00-00')
						$booking_to=date('d-m-Y',strtotime($booking['booking_to']));
					else	
						$booking_to='';
					
					$student=getShaOneAppDetails($booking['student']);
					$host=getHfaOneAppDetails($booking['host']);
					$studyTour='';
					if($student['study_tour_id']!=0)
					{
						$tourDetail=tourDetail($student['study_tour_id']);
						$studyTour=$tourDetail['group_name'];
					}*/
						
					/*$this->excel->getActiveSheet()->setCellValue('A'.$x, $booking['id']);
					$this->excel->getActiveSheet()->setCellValue('B'.$x, $booking['student']);
					$this->excel->getActiveSheet()->setCellValue('C'.$x, $student['fname'].' '.$student['lname']);
					$this->excel->getActiveSheet()->setCellValue('D'.$x, $booking['host']);
					$this->excel->getActiveSheet()->setCellValue('E'.$x, $host['fname'].' '.$host['lname']);
					$this->excel->getActiveSheet()->setCellValue('F'.$x, $booking_from);
					$this->excel->getActiveSheet()->setCellValue('G'.$x, $booking_to);
					$this->excel->getActiveSheet()->setCellValue('H'.$x, ucfirst(str_replace('_',' ',$booking['status'])));
					$this->excel->getActiveSheet()->setCellValue('I'.$x, $studyTour);*/
					
					
					if($booking['arrival_date']=='0000-00-00')
						$booking['arrival_date']='';
					
					$this->excel->getActiveSheet()->setCellValue('A'.$x, $booking['id']);
					$this->excel->getActiveSheet()->setCellValue('B'.$x, $booking['student']);
					$this->excel->getActiveSheet()->setCellValue('C'.$x, $booking['arrival_date']);
					$this->excel->getActiveSheet()->setCellValue('D'.$x, $booking['college']);
					$this->excel->getActiveSheet()->setCellValue('E'.$x, $booking['host']);
					
					$x++;
				}
				
				$filename='Bookings.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
		
	}
	
	
	
	
	
	function poCsv()
	{
			$this->load->library('excel');
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle('test worksheet');
		
			$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
					'font'=>array(
					'name'      =>  'Arial',
					'size'      =>  10,
				)
			));
			
			for($c='A';$c<='G';$c++)
			$this->excel->getActiveSheet()->getColumnDimension($c)->setAutosize(true);
			
			$excel_table_headings_new=array(
		  'A'=>'PO No',
		  'B'=>'Booking id',
		  'C'=>'Student',
		  'D'=>'Host Family',
		  'E'=>'From date',
		  'F'=>'End date',
		   'G'=>'Amount'
		  );	
		  
		  		$x_start=1;
		  		foreach($excel_table_headings_new as $k=>$v)
				{
					$this->excel->getActiveSheet()->setCellValue($k.$x_start, $v);
				}
				$this->excel->getActiveSheet()->getStyle('A'.$x_start.':G'.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
				$this->excel->getActiveSheet()->getStyle('A'.$x_start.':G'.$x_start)->getFont()->setSize(10)->setBold(true);
			 	
				$x=$x_start+1;
				$this->load->model('zimport_model');
				
				$sql="SELECT `purchase_orders`.`id`,`purchase_orders`.`booking_id`,`purchase_orders`.`from`,`purchase_orders`.`to`,`sha_one`.`fname` as `student_fname`,`sha_one`.`lname` as `student_lname`,`hfa_one`.`fname` as `host_fname`,`hfa_one`.`lname` as `host_lname` FROM `purchase_orders` JOIN `bookings` ON(`purchase_orders`.`booking_id`=`bookings`.`id`) JOIN `sha_one` ON(`bookings`.`student`=`sha_one`.`id`) JOIN `hfa_one` ON(`bookings`.`host`=`hfa_one`.`id`)";
				$query=$this->db->query($sql);
				$pos=$query->result_array();
				
				foreach($pos as $po)
				{
					$poAmount=poAmount($po['id']);
					$this->excel->getActiveSheet()->setCellValue('A'.$x, $po['id']);
					$this->excel->getActiveSheet()->setCellValue('B'.$x, $po['booking_id']);
					$this->excel->getActiveSheet()->setCellValue('C'.$x, $po['student_fname'].' '.$po['student_lname']);
					$this->excel->getActiveSheet()->setCellValue('D'.$x, $po['host_fname'].' '.$po['host_lname']);
					$this->excel->getActiveSheet()->setCellValue('E'.$x, date('d-m-Y',strtotime($po['from'])));
					$this->excel->getActiveSheet()->setCellValue('F'.$x, date('d-m-Y',strtotime($po['to'])));
					$this->excel->getActiveSheet()->setCellValue('G'.$x,  '$'.$poAmount);
					$x++;
				}
				
				$filename='PurchaseOrders.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
		
	}
	
	function hostApprovedCsv()
	{
			$this->load->library('excel');
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle('test worksheet');
		
			$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
					'font'=>array(
					'name'      =>  'Arial',
					'size'      =>  10,
				)
			));
			
			for($c='A';$c<='G';$c++)
			$this->excel->getActiveSheet()->getColumnDimension($c)->setAutosize(true);
			
			$excel_table_headings_new=array(
		  'A'=>'Family id',
		  'B'=>'Contact name',
		  'C'=>'Status change date',
		  'D'=>'Submitted date'
		  );	
		  
		  		$x_start=1;
		  		foreach($excel_table_headings_new as $k=>$v)
				{
					$this->excel->getActiveSheet()->setCellValue($k.$x_start, $v);
				}
				$this->excel->getActiveSheet()->getStyle('A'.$x_start.':D'.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
				$this->excel->getActiveSheet()->getStyle('A'.$x_start.':D'.$x_start)->getFont()->setSize(10)->setBold(true);
			 	
				$x=$x_start+1;
				$this->load->model('zimport_model');
				
				$sql="SELECT * FROM `hfa_one` where `status`='approved' order by `id`";
				$query=$this->db->query($sql);
				$pos=$query->result_array();
				
				foreach($pos as $po)
				{
					$poAmount=poAmount($po['id']);
					$this->excel->getActiveSheet()->setCellValue('A'.$x, $po['id']);
					$this->excel->getActiveSheet()->setCellValue('B'.$x, $po['fname'].' '.$po['lname']);
					$this->excel->getActiveSheet()->setCellValue('C'.$x, date('Y-m-d',strtotime($po['date_status_changed'])));
					$this->excel->getActiveSheet()->setCellValue('D'.$x, date('Y-m-d',strtotime($po['date'])));
					$x++;
				}
				
				$filename='Approved families.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
		
	}
				
		public function sm()
    {
        $this->load->library('email');
 
        $account_name = 'Global experience';
        $outlook_account_username = "no-reply@globalexperience.com.au";
        $outlook_account_password = "P@55w0rd!23";
        $to = 'tejpal@evomorf.com';
		//$to = 'tejpal.1988@gmail.com';
        $subject = 'Hello this email send from my webserver';
        $body = 'Hi guys, how are you ? i am fine';
 /*
        $config['smtp_crypto'] = 'tls';
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = "smtp-mail.outlook.com";
		//$config['smtp_host'] = 'smtp.live.com';
        $config['smtp_port'] = 587;
        //$config['smtp_user'] = $outlook_account_username;
       // $config['smtp_pass'] = $outlook_account_password;
		 $config['smtp_user'] = "no-reply@globalexperience.com.au";
        $config['smtp_pass'] = "P@55w0rd!23";
		
        $config['mailtype'] = 'html';
        $config['charset']  = 'utf-8';
 
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");*/
		
		
		/*$config = array();  
		$config['protocol'] = 'smtp';  
		$config['smtp_host'] = 'smtp-mail.outlook.com';  
		$config['smtp_user'] = $outlook_account_username;  
		$config['smtp_pass'] = $outlook_account_password;  
		$config['smtp_port'] = 25;  
		$this->email->initialize($config);  
		  
		$this->email->set_newline("\r\n");*/  
		
		 
        $this->email->from(header_from_email(),header_from());
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($body);
        $this->email->send();
 
        $debug = $this->email->print_debugger();
        print_r($debug);
    }			

function php()
{
	phpinfo();
}

function sm1()
{
	//In your Controller code:
$config =array (        
    /*'protocol' => 'smtp',
    'smtp_host' => 'smtp.office365.com',
    'smtp_user' => 'no-reply@globalexperience.com.au',
    'smtp_pass' => "P@55w0rd!23",
    'smtp_crypto' => 'tls',    
    'newline' => "\r\n", //REQUIRED! Notice the double quotes!
    'smtp_port' => 587,*/
    'mailtype' => 'html'    
);
$this->load->library('email', $config);        

//$this->email->from('no-reply@globalexperience.com.au');        
$this->email->from(header_from_email(),header_from());
$this->email->to('tejpal@evomorf.com');        
$this->email->subject('Test');
$this->email->message('SMTP sending test');

$sent = $this->email->send();


if ($sent) 
{
    echo 'OK';
    
} else {
    echo $this->email->print_debugger();
}
}

function toUcwords()
{
	$this->load->model('zimport_model');
	//$this->zimport_model->toUcwords();
	
}
	
	function invoice_upload()
	{
		//see($_FILES);
		
		//$file=$_FILES['file']['tmp_name'];
		$file = './csvfile/groupInvoice.xls';
		$formOne=$this->readCsv($file);
		//see($formOne['values']);//exit;
		$this->load->model('zimport_model');
		/*$invoice=array();
		foreach($formOne['values'] as $valK=>$val)
			{
				$item=array();
				if(!isset($val['G']))
					continue;
					
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
					continue;
					
				$item['total']=$val['O'];
				$item['unit']=$item['total']/$item['qty'];
				
				
				
				$booking=$this->zimport_model->findStudentForInvoiceUpload($val);
				if(empty($booking))
					continue;
					
				$item['booking_id']=$booking['id'];
				$item['sha_id']=$booking['student'];
				$item['date_from']=$val['K'];
				$dateFrom= DateTime::createFromFormat( 'd M Y', $item['date_from']);
				$item['date_from']= $dateFrom->format( 'Y-m-d');
				
				$item['date_to']=$val['L'];
				$dateTo= DateTime::createFromFormat( 'd M Y', $item['date_to']);
				$item['date_to']= $dateTo->format( 'Y-m-d');
				
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
			see($invoice);
			//$this->zimport_model->invoiceUploadInsert($invoice);*/
			
			
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
				
				$booking=$this->zimport_model->findStudentForInvoiceUpload($val);
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
				$item['date_from']=$val['K'];
				$dateFrom= DateTime::createFromFormat( 'd M Y', $item['date_from']);
				$item['date_from']= $dateFrom->format( 'Y-m-d');
				
				$item['date_to']=$val['L'];
				$dateTo= DateTime::createFromFormat( 'd M Y', $item['date_to']);
				$item['date_to']= $dateTo->format( 'Y-m-d');
				
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
			
			//see($invoice);
			/*$postData['clientId']=$_POST['clientId'];
			if(isset($_POST['invoiceId']))
				$postData['invoiceId']=$_POST['invoiceId'];*/
			
			/*if(!empty($invoice))
				$this->group_invoice_model->invoiceUploadInsert($invoice,$postData);*/
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
		  
		  
		function bookingsWithSFId()
		{
			$this->load->model('zimport_model');
			$bookings=$this->zimport_model->bookingsWithSFId();
			see($bookings);
		}  
		
		function timeCheck()
		{
			$date=date('Y-m-d H:i:s');
			echo $date;
			
			$to_admin  = 'tejpal@evomorf.com';
				
	                $subject_admin ="Time check";
				
					
					
			$this->load->library('email');
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			$this->email->from(header_from_email(),header_from());
			$this->email->subject($subject_admin);
			$to =  $to_admin;
			$this->email->to($to);
			$this->email->message($date);
			$this->email->send();	
		}
	
	function poBookings()
	{
		
		$sql="SELECT * FROM `bookings` WHERE (`booking_to`='0000-00-00' OR `booking_to`>='2018-06-20') and `id` NOT IN(select `booking_id` from `purchase_orders`) order by `booking_from` ASC ";
		$query=$this->db->query($sql);
		//echo $this->db->last_query();
		$res=$query->result_array();
		//see($res);
		
		foreach($res as $r)
		{
			echo "'".$r['id']."',";
		}
	}
	
	function nextInvoiceId()
	{
		echo nextInvoiceId();
	}	
	
	function ongoingInvoiceUpdateDuration()
	{
		$this->load->model('invoice_model');
		$query=$this->db->query("select * from `invoice_ongoing_bk` where `study_tour`='0'");
		$ongoingInv=$query->result_array();
		
		//see($ongoingInv);die();
		
		foreach($ongoingInv as $ong)
		{
			$data['invoice_id']=$ong['id'];
			$data['shaChangeStatus_id']=$ong['application_id'];
			$from=$ong['booking_from'];
			$to=$ong['booking_to'];
			
			$data['invoiceId']=$data['invoice_id'];
			$ongoingInvoiceDetails=ongoingInvoiceDetails($data['invoiceId']);
			$sha=getShaOneAppDetails($data['shaChangeStatus_id']);
			//$totalDays=($data['weeks']*7)+($data['days'])-1;
			
			//$from=$ongoingInvoiceDetails['booking_from'];
			//$to=date('Y-m-d',strtotime($from.' +'.$totalDays.' days'));
			
			$this->resetUpdateOngoingInvoicePart2($data['invoiceId'],$from,$to);
			//$this->session->set_flashdata('ongoingInvoiceUpdated','yes');
		}echo "done";
	}
	
	function resetUpdateOngoingInvoicePart2($invoiceId,$from,$to)
	{
			$this->load->model('invoice_model');
			$this->load->model('zimport_model');
			$ongoingInvoiceDetails=ongoingInvoiceDetails($invoiceId);
			$booking=bookingByShaId($ongoingInvoiceDetails['application_id']);
			$ongoingInvoice['id']=$invoiceId;
			$ongoingInvoice['application_id']=$ongoingInvoiceDetails['application_id'];
			$ongoingInvoice['items']=array();
			
			// If this is first ongoing invoice so its 'from' date should be derived from booking dates
			$lastInvoiceWithEndingDate=$this->invoice_model->lastInvoiceWithEndingDate($ongoingInvoice['application_id'],date('Y-m-d',strtotime($ongoingInvoiceDetails['booking_from'].' - 1 day')));//if(!isset($lastInvoiceWithEndingDate['initial_invoice'])){echo $ongoingInvoice['application_id'].' '.date('Y-m-d',strtotime($ongoingInvoiceDetails['booking_from'].' - 1 day')).'<br>';}
			/*if($lastInvoiceWithEndingDate['initial_invoice']=='1')
			{
				$shaInitialInvoiceWeekDays=shaInitialInvoiceWeekDays($booking['student']);
				$from=$OngoingInvoiceDate=date('Y-m-d',strtotime($booking['booking_from'].' + '.$shaInitialInvoiceWeekDays.' days'));
				$to=$OngoingInvoiceDateTo=date('Y-m-d',strtotime($OngoingInvoiceDate.' + '.dayDIff($from,$to).' days - 1 day'));
			}*/
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
			
			//$this->zimport_model->resetOngoingInvoice($ongoingInvoice);
	}
	
	function fixInvoiceIds()
	{
		$this->load->model('zimport_model');
		$query=$this->db->query("select * from `invoice_ongoing_restored` order by `id`");
		$result=$query->result_array();
		
		foreach($result as $ong)
		{
			$invoice_id=nextInvoiceId();
			$sql="insert into `invoice_ongoing` (`id`,`application_id`,`study_tour`,`booking_from`,`booking_to`,`end_date`,`moved_to_xero`,`moved_to_xero_date`,`invoice_number`,`xero_invoiceId`,`status`,`date`) ";
			$sql .="values('".$invoice_id."','".$ong['application_id']."','".$ong['study_tour']."','".$ong['booking_from']."','".$ong['booking_to']."','".$ong['end_date']."','".$ong['moved_to_xero']."','".$ong['moved_to_xero_date']."','".$ong['invoice_number']."','".$ong['xero_invoiceId']."','".$ong['status']."','".$ong['date']."')";
			//$this->db->query($sql);
			//echo $sql.'<br>';
			$sqlItem="update `invoice_ongoing_items` set `invoice_id`='".$invoice_id."' where `invoice_id`='".$ong['id']."'";
			//$this->db->query($sqlItem);
			//echo $sqlItem.'<br><br>';
		}
		echo "done";
	}
	
	
	function hfaCsv()
	{
			$this->load->library('excel');
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle('test worksheet');
		
			$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
					'font'=>array(
					'name'      =>  'Arial',
					'size'      =>  10,
				)
			));
			
			for($c='A';$c<='G';$c++)
			$this->excel->getActiveSheet()->getColumnDimension($c)->setAutosize(true);
			
			$excel_table_headings_new=array(
			  'A'=>'Family id',
			  'B'=>'Primary contact name',
			  'C'=>'Approval date'
		  );	
		  
		  		$x_start=1;
		  		foreach($excel_table_headings_new as $k=>$v)
				{
					$this->excel->getActiveSheet()->setCellValue($k.$x_start, $v);
				}
				$this->excel->getActiveSheet()->getStyle('A'.$x_start.':C'.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
				$this->excel->getActiveSheet()->getStyle('A'.$x_start.':C'.$x_start)->getFont()->setSize(10)->setBold(true);
			 	
				$x=$x_start+1;
				$this->load->model('zimport_model');
				
				$query=$this->db->query("select * from `hfa_one` where `status`='approved'");
				//$HostFam$query->result_array();
				foreach($bookings as $booking)
				{
					$booking_from=date('d-m-Y',strtotime($booking['booking_from']));
					if($booking['booking_to']!='0000-00-00')
						$booking_to=date('d-m-Y',strtotime($booking['booking_to']));
					else	
						$booking_to='';
						
					$this->excel->getActiveSheet()->setCellValue('A'.$x, $booking['id']);
					$this->excel->getActiveSheet()->setCellValue('B'.$x, $booking['student']);
					$this->excel->getActiveSheet()->setCellValue('C'.$x, $booking['host']);
					$this->excel->getActiveSheet()->setCellValue('D'.$x, $booking_from);
					$this->excel->getActiveSheet()->setCellValue('E'.$x, $booking_to);
					$x++;
				}
				
				$filename='Bookings.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
		
	}
	
	
	
	function roomIdchanged()
	{
			$this->load->library('excel');
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle('test worksheet');
		
			$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
					'font'=>array(
					'name'      =>  'Arial',
					'size'      =>  10,
				)
			));
			
			for($c='A';$c<='G';$c++)
			$this->excel->getActiveSheet()->getColumnDimension($c)->setAutosize(true);
			
			$excel_table_headings_new=array(
		  'A'=>'Booking id',
		  'B'=>'Family',
		  'C'=>'Room no'
		  );	
		  
		  		$x_start=1;
		  		foreach($excel_table_headings_new as $k=>$v)
				{
					$this->excel->getActiveSheet()->setCellValue($k.$x_start, $v);
				}
				$this->excel->getActiveSheet()->getStyle('A'.$x_start.':C'.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
				$this->excel->getActiveSheet()->getStyle('A'.$x_start.':C'.$x_start)->getFont()->setSize(10)->setBold(true);
			 	
				$x=$x_start+1;
				$this->load->model('zimport_model');
				
				$query=$this->db->query("SELECT * from `bookings` order by `id`");
				$bookings=$query->result_array();
				
				foreach($bookings as $booking)
				{
					$queryRoom=$this->db->query("select * from `hfa_bedrooms` where `id`='".$booking['room']."'");
					if($queryRoom->num_rows()==0)
					{
					$this->excel->getActiveSheet()->setCellValue('A'.$x, $booking['id']);
					$this->excel->getActiveSheet()->setCellValue('B'.$x, $booking['host']);
					$this->excel->getActiveSheet()->setCellValue('C'.$x, '');
					$x++;
					}
				}
				
				$filename='Bookings-RoomIdChanged.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
		
	}
	
	function addNewOngoingInvoice($booking_id)
	{
		//addNewOngoingInvoice11($booking_id);
		//addNewOngoingInvoice($booking_id);
		//addNewOngoingInvoiceDirect($booking_id);//if we donot have initial invoice and we directly want ongoing invoice
		
		//for initial
			//$po_structure[]=po_structure($booking_id);
		//for ongoing
			/*$nextOngoing['to']='2019-03-28';//date of previous po(to date)
			$po_structure[]=po_structure($booking_id,$nextOngoing);*/
			
		//see($po_structure);
		/*$this->load->model('Po_model');
		$bookings=$this->Po_model->insertGeneratedPo($po_structure);*/
	}
	
	
	function login()
	{
		//if(!checkLogin())
//			echo 'Redirect';
//		else
//			echo 'Logged in';
			
			see(loggedInUser());
	}
	
	function checkLogin()
	{
		echo 'id '.$this->session->userdata("user_id").' id'.'<br>';
		if($this->session->userdata("user_id"))
			return true;
		else
			return false;
	}
	
	function bookingUpdate()
	{die();
		//see($_FILES);
		
		//$file=$_FILES['file']['tmp_name'];
		$file = './csvfile/book/moved_outEmpty.xlsx';
		$formOne=$this->readCsv($file);
		//see($formOne['values']);//exit;
		echo count($formOne['values']).'<br>';
		foreach($formOne['values'] as $valK=>$val)
		{
			echo $val['A'].',';
		}
			
	}
	
	function addTourInitialInvoice($id)
	{die();
		$this->load->model('tour_model');
		$this->tour_model->addPendingInvoice($id);
	}	
	
	function p($year)
	{
		$date=$year;
		//echo $date.': ';
		$day=date('D',strtotime($date));
		
		if($day=='Fri')
			$add=1;
		else
			$add=2;
		//echo $add;
		$dated=date('Y-m-d',strtotime($date.' next friday'));
		if($add==2)
			$dated=date('Y-m-d',strtotime($dated.' next friday'));
		//echo '<br>'.$dated;
		return $dated;
	}
	
	function op()
	{die();
		$this->load->model('zimport_model');
		$query=$this->db->query("select `id`,date(`date`) as `date` from `purchase_orders`");
		$res=$query->result_array();
		
		foreach($res as $r)
		{
			//echo $r['id'].'  -  ';
			//echo $this->p($r['date']);
			//echo '<br>';
			$dueDate=$this->p($r['date']);
			
			$this->db->query("update `purchase_orders` set `due_date`='".$dueDate."' where `id`='".$r['id']."'");
			//echo $this->db->last_query().'<br>';
		}
	}	
	
	function upi()
	{die();
		//$this->load->model('zimport_model');
		//$query=$this->db->query("select * from `invoice_ongoing` where `study_tour`='0'");
		$query=$this->db->query("select * from `invoice_ongoing` where `study_tour`='1'");
		$res=$query->result_array();
		//see($res);
		
		foreach($res as $r)
		{
			$qR=$this->db->query("select * from `invoice_ongoing_items` where `invoice_id`='".$r['id']."' and `type` NOT IN ('ott')");
			$resR=$qR->result_array();
			
			foreach($resR as $rR)
			{
				//$student=getshaOneAppDetails($r['application_id']);
				$student=getshaOneAppDetails($rR['application_id']);
				
				$sha_student_no='';
				if(trim($student['sha_student_no'])!='')
					$sha_student_no=', '.$student['sha_student_no'];
				$studentnameWithNo=$student['fname'].' '.$student['lname'].$sha_student_no;
				
				$studentname=$student['fname'].' '.$student['lname'];
				
				if($sha_student_no!='')
				{
					if( strpos( $rR['desc'], $studentnameWithNo ) !== false) {}
					else
					{
						if( strpos( $rR['desc'], $studentname) !== false)
						{
							echo $rR['id'].'  '.$studentnameWithNo.'<br>';
							//$this->db->query("update `invoice_ongoing_items` set `desc`= replace(`desc`,'".$studentname."','".$studentnameWithNo."') where `id`='".$rR['id']."'");
							//echo $this->db->last_query().'<br>';
						}
					}
				}
				
			}
		}
	}
	
	function cgCsv()
	{
			$this->load->library('excel');
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle('test worksheet');
		
			$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
					'font'=>array(
					'name'      =>  'Arial',
					'size'      =>  10,
				)
			));
			
			for($c='A';$c<='O';$c++)
			$this->excel->getActiveSheet()->getColumnDimension($c)->setAutosize(true);
			
			
		  
		  $excel_table_headings_new=array(
			  'A'=>'Fname',
			  'B'=>'Lname',
			  'C'=>'Company name',
			  'D'=>'ABN',
			  'E'=>'Street address', 
			  'F'=>'Suburb',
			  'G'=>'State',
			  'H'=>'Postal code',
			  'I'=>'Phone',
			  'J'=>'email',
			  'K'=>'Gender',
			  'L'=>'Inchage name',
			  'M'=>'Inchage email',
			  'N'=>'Inchage phone',
			);	
		  
		  		$x_start=1;
		  		foreach($excel_table_headings_new as $k=>$v)
				{
					$this->excel->getActiveSheet()->setCellValue($k.$x_start, $v);
				}
				$this->excel->getActiveSheet()->getStyle('A'.$x_start.':N'.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
				$this->excel->getActiveSheet()->getStyle('A'.$x_start.':N'.$x_start)->getFont()->setSize(10)->setBold(true);
			 	
				$x=$x_start+1;
				$this->load->model('zimport_model');
				$query=$this->db->query("select * from `guardians` order by `id`");
				$bookings=$query->result_array();
				
				$genderList=genderList();
				$bookingStatusList=bookingStatusList();
				foreach($bookings as $booking)
				{
					
					$this->excel->getActiveSheet()->setCellValue('A'.$x, $booking['fname']);
					$this->excel->getActiveSheet()->setCellValue('B'.$x, $booking['lname']);
					$this->excel->getActiveSheet()->setCellValue('C'.$x, $booking['company_name']);
					$this->excel->getActiveSheet()->setCellValue('D'.$x, $booking['abn']);
					$this->excel->getActiveSheet()->setCellValue('E'.$x, $booking['street_address']);
					$this->excel->getActiveSheet()->setCellValue('F'.$x, $booking['suburb']);
					$this->excel->getActiveSheet()->setCellValue('G'.$x, $booking['state']);
					$this->excel->getActiveSheet()->setCellValue('H'.$x, $booking['postal_code']);
					$this->excel->getActiveSheet()->setCellValue('I'.$x, $booking['phone']);
					$this->excel->getActiveSheet()->setCellValue('J'.$x, $booking['email']);
					$this->excel->getActiveSheet()->setCellValue('K'.$x, $genderList[$booking['gender']]);
					$this->excel->getActiveSheet()->setCellValue('L'.$x, $booking['incharge_name']);
					$this->excel->getActiveSheet()->setCellValue('M'.$x, $booking['incharge_email']);
					$this->excel->getActiveSheet()->setCellValue('N'.$x, $booking['incharge_phone']);
					
					$x++;
				}
				
				$filename='caregiver.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
		
	}
	
	function cgShaCsv()
	{
			$this->load->library('excel');
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle('test worksheet');
		
			$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
					'font'=>array(
					'name'      =>  'Arial',
					'size'      =>  10,
				)
			));
			
			for($c='A';$c<='O';$c++)
			$this->excel->getActiveSheet()->getColumnDimension($c)->setAutosize(true);
			
			
		  
		  $excel_table_headings_new=array(
			  'A'=>'Student Id',
			  'B'=>'Stduent Name',
			  'C'=>'Caregiver'
			);	
		  
		  		$x_start=1;
		  		foreach($excel_table_headings_new as $k=>$v)
				{
					$this->excel->getActiveSheet()->setCellValue($k.$x_start, $v);
				}
				$this->excel->getActiveSheet()->getStyle('A'.$x_start.':C'.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
				$this->excel->getActiveSheet()->getStyle('A'.$x_start.':C'.$x_start)->getFont()->setSize(10)->setBold(true);
			 	
				$x=$x_start+1;
				$this->load->model('zimport_model');
				/*$query=$this->db->query("select * from `guardians` order by `id`");
				$CG=$query->result_array();*/
				
				$query=$this->db->query("select `sha_two_copy`.`id` as `sid`, `sha_two_copy`.`guardian_assigned`, `sha_one`.`fname` as `sFname`, `sha_one`.`lname` as `sLname`, `guardians`.`company_name` as `company` from `sha_two_copy` left join `sha_one` ON(`sha_two_copy`.`id`=`sha_one`.`id`) left join `guardians` ON(`sha_two_copy`.`guardian_assigned`=`guardians`.`id`) where `sha_two_copy`.`guardian_assigned` != 0 order by `sha_two_copy`.`id`");
				$bookings=$query->result_array();
				
				foreach($bookings as $booking)
				{
					
					$this->excel->getActiveSheet()->setCellValue('A'.$x, $booking['sid']);
					$this->excel->getActiveSheet()->setCellValue('B'.$x, $booking['sFname'].' '.$booking['sLname']);
					$this->excel->getActiveSheet()->setCellValue('C'.$x, $booking['company']);
					$x++;
				}
				
				$filename='caregiverStudents.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
		
	}
	
	function hfCsv()
	{
			$this->load->library('excel');
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle('test worksheet');
		
			$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
					'font'=>array(
					'name'      =>  'Arial',
					'size'      =>  10,
				)
			));
			
			for($c='A';$c<='O';$c++)
			$this->excel->getActiveSheet()->getColumnDimension($c)->setAutosize(true);
			
			
		  
		  $excel_table_headings_new=array(
			  'A'=>'Name',
			  'B'=>'Email',
			  'C'=>'Application status',
			  'D'=>'Active / Inactive',
			  'E'=>'State'
			);	
		  
		  		$x_start=1;
		  		foreach($excel_table_headings_new as $k=>$v)
				{
					$this->excel->getActiveSheet()->setCellValue($k.$x_start, $v);
				}
				$this->excel->getActiveSheet()->getStyle('A'.$x_start.':E'.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
				$this->excel->getActiveSheet()->getStyle('A'.$x_start.':E'.$x_start)->getFont()->setSize(10)->setBold(true);
			 	
				$x=$x_start+1;
				$this->load->model('zimport_model');
				$query=$this->db->query("select * from `hfa_one` where `state` IN('nsw','vic','nt') and `status`!='do_not_use' order by `id`");
				$hfaList=$query->result_array();
				
				$stateList=stateList();
				$hfaStatusList=hfaStatusList();
				foreach($hfaList as $hfa)
				{
					$q=$this->db->query("select * from `bookings` where `booking_from`<='".date('Y-m-d')."' and `booking_to`>='".date('Y-m-d')."' and `host`='".$hfa['id']."'");
					//echo $this->db->last_query().'<br>';
					if($q->num_rows()>0)
						$active='Active';
					else
						$active='Inactive';	
					
					$this->excel->getActiveSheet()->setCellValue('A'.$x, ucwords($hfa['fname'].' '.$hfa['lname']));
					$this->excel->getActiveSheet()->setCellValue('B'.$x, $hfa['email']);
					$this->excel->getActiveSheet()->setCellValue('C'.$x, $hfaStatusList[$hfa['status']]);
					$this->excel->getActiveSheet()->setCellValue('D'.$x, $active);
					$this->excel->getActiveSheet()->setCellValue('E'.$x, $stateList[$hfa['state']]);
					
					$x++;
				}
				
				$filename='Host families.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
		
	}
	
	function ref(/*$date*/)
	{
		//$date='2018-09-21';
		//$bookings=poNextOngoing($date);
		//see($bookings);
		
		$this->load->model('zimport_model');
		$sql="select * from `hfa_members`";
		$query=$this->db->query($sql);
		$res=$query->result_array();
		
		$count=1;
		$hfa=array();
		foreach($res as $r)
		{
			$query=$this->db->query("select * from `hfa_members_language` where `member_id`='".$r['id']."'");
			if($query->num_rows()!=$r['language'])
			{
				//echo $count.'. '.$r['id']."<br>";
				//$count++;
				if(!in_array($r['application_id'],$hfa))
					$hfa[]=$r['application_id'];
			}
		}
		see($hfa);
	}
	
	
	function mrg()
	{
	  
		if(userAuthorisations('hfa_callLog_delete'))
			echo 'Can delete call Log';
		else
			echo 'Cannot delete call Log';
			
		echo "<br>";
		if(userAuthorisations('hfa_visitReport_delete'))
			echo 'Can delete visit report';
		else
			echo 'Cannot delete visit report';
			
		echo "<br>";
		if(userAuthorisations('randomTask'))
			echo 'Can do random task';
		else
			echo 'Cannot  do random task';
			
		echo "<br>";
		if(userAuthorisations('adminTask'))
			echo 'Can do adminTask';
		else
			echo 'Cannot do adminTask';
			
		echo "<br>";
		if(userAuthorisations('employeeTask'))
			echo 'Can do employeeTask';
		else
			echo 'Cannot do employeeTask';
		
			
	}
	
	
	function visitTime234()
	{
	
		$this->load->model('zimport_model');
		$sql="select * from `hfa_one` where `status`='confirmed'";
		$query=$this->db->query($sql);
		$res=$query->result_array();
		
		foreach($res as $r)
		{
			$query=$this->db->query("select * from `hfa_visitReport` where `hfa_id`='".$r['id']."'");
			if($query->num_rows()==0)
			{see($r);
				/*$dateCalled=$r['visit_date_time'];
				
				$sql="insert into `hfa_visitReport` (`hfa_id`,`date_visited`,`employee`,`date`) values (?,?,?,?)";
				$this->db->query($sql,array($r['id'],$dateCalled,$r['visitor_name'],date('Y-m-d H:i:s')));		*/
			}
		}
		//see($hfa);
	}
	
	
	
	function deIntReport()
	{die();
			$this->load->library('excel');
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle('test worksheet');
		
			$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
					'font'=>array(
					'name'      =>  'Arial',
					'size'      =>  10,
				)
			));
			
			for($c='A';$c<='P';$c++)
			$this->excel->getActiveSheet()->getColumnDimension($c)->setAutosize(true);
			
			
		  
		  $excel_table_headings_new=array(
			  'A'=>'Student ID',
			  'B'=>'Student name',
			  'C'=>'Nationality',
			  'D'=>'Active / Inactive',
			  'E'=>'Booking ID',
			  'F'=>'Notes',
			  'G'=>'Client',
			  'H'=>'College',
			  'I'=>'Student changed homestay',
			  'J'=>'If changed homestay, how many',
			  'K'=>'Homestay nomination',
			  'L'=>'Nominated host family name',
			  'M'=>'Host family address',
			  'N'=>'Contact number',
			  'O'=>'WWCC for all adults from host family',
			  'P'=>'Insurance details',
			  'Q'=>'Host family notes',
			  'R'=>'Student notes',
			  'S'=>'Last visit date',
			  'T'=>'Booking start date',
			  'U'=>'Booking end date',
			  'V'=>'Booking Status'
			);	
		  
		  		$x_start=1;
		  		foreach($excel_table_headings_new as $k=>$v)
				{
					$this->excel->getActiveSheet()->setCellValue($k.$x_start, $v);
				}
				$this->excel->getActiveSheet()->getStyle('A'.$x_start.':V'.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
				$this->excel->getActiveSheet()->getStyle('A'.$x_start.':V'.$x_start)->getFont()->setSize(10)->setBold(true);
			 	
				$x=$x_start+1;
				$this->load->model('zimport_model');
				//$query=$this->db->query("select * from `sha_one` where `duplicate`='0' order by `id` limit 20001, 10000");
				//$shaList=$query->result_array();
				$query=$this->db->query("select * from `bookings` order by `id`");
				$bookings=$query->result_array();
				//$this->hfaStatus($bookings);die();
				$nationList=nationList();
				$stateList=stateList();
				$bookingStatusList=bookingStatusList();
				
				//foreach($shaList as $sha)
				foreach($bookings as $bK=>$booking)
				{
					//$booking=bookingByShaId($sha['id']);
					$sha=getShaOneAppDetails($booking['student']);
					
					$bookingId='Student not placed yet';
					$bookingNotes='';
					$bookingActive='';
					if(!empty($booking))
					{
						$bookingId=$booking['id'];
						$bookingNotes=$booking['notes'];
						
						$dateToday=date('Y-m-d');
						
						/*if(strtotime($booking['booking_from'])<=strtotime($dateToday))
							echo '11';
						if($booking['booking_to']>strtotime($dateToday) || $booking['booking_to']=='0000-00-00')
						echo '22';
						
						if(date$booking['booking_to']>strtotime($dateToday)) 
							echo '33';
						else
							
						if($booking['booking_to']=='0000-00-00')
							echo '44';*/
						
						if(strtotime($booking['booking_from'])<=strtotime($dateToday) && (strtotime($booking['booking_to'])>strtotime($dateToday) || strtotime($booking['booking_to'])=='0000-00-00'))
							$bookingActive='Active';	
						else
							$bookingActive='Inactive';	
					}
					
					$nation='';
					if(isset($nationList[$sha['nation']]))
						$nation=$nationList[$sha['nation']];
					
					$client='';
					if($sha['client']!='')
					{
						$clientDetail=clientDetail($sha['client'])	;
						$client=$clientDetail['bname'];
					}
					
					$college='';
					if($sha['college']!='')
					{
						$collegeDetails=collegeDetail($sha['college']);
						$college=$collegeDetails['bname'];
					}
					
					$homestayChanged='No';
					$homestayChangedCount='';
					$getDuplicateShaSet=getDuplicateShaSet($sha['id']);
					if(count($getDuplicateShaSet)>1)
					{
						$homestayChanged='Yes';
						$homestayChangedCount=count($getDuplicateShaSet)-1;
					}
					
					$homestayNomination='No';
					$nominatedHfa='';
					$nominatedHfaAddress='';
					$nominatedHfaContact='';
					$nominatedHfaWwcc='';
					$nominatedHfaInsurance='';
					if($sha['homestay_nomination']=='1')
						$homestayNomination='Yes';
					
					////////////////////////
					
						
						/*if($sha['nominated_hfa_id']!='0')
						{*/
							$getHfaOneAppDetails=getHfaOneAppDetails($booking['host']);
							if(!empty($getHfaOneAppDetails))
							{
								$nominatedHfa=ucfirst($getHfaOneAppDetails['lname']).' Family';
								
								if($getHfaOneAppDetails['street']!='')
									$nominatedHfaAddress .=$getHfaOneAppDetails['street'].", ";
								$nominatedHfaAddress .=ucfirst($getHfaOneAppDetails['suburb']).", ".$stateList[$getHfaOneAppDetails['state']].", ".$getHfaOneAppDetails['postcode'];
								
								$nominatedHfaContact=$getHfaOneAppDetails['mobile'];
								
								$hfaThree=getHfaThreeAppDetails($booking['host']);
								if(!empty($hfaThree))
								{
								//wwcc #STARTS
									$family_role=family_role();
									$wwccPipe=false;
									foreach($hfaThree['memberDetails'] as $memberK=>$member)
									{
										if($wwccPipe)
											$nominatedHfaWwcc .=' | ';
										$wwccPipe=true;
										
										$nominatedHfaWwcc .=ucwords($member['fname'].' '.$member['lname']);
										if($member['role']!='')
										   {
												$nominatedHfaWwcc .=" (";
												  if($member['role']==17)
													  $nominatedHfaWwcc .=!empty($member['other_role']) ? ' - '.$member['other_role'] :'';
												  else
													  $nominatedHfaWwcc .= $family_role[$member['role']];
												$nominatedHfaWwcc .=")";	  
											}
										
										if($member['wwcc']=="1")
											{
														if($member['wwcc_clearence']=='1')
														{
															if(trim($member['wwcc_clearence_no'])!='')
																$nominatedHfaWwcc .=' - Clearence no.: '.$member['wwcc_clearence_no'];
															else
																$nominatedHfaWwcc .=' - Clearence no. unavailable';	
															if($member['wwcc_expiry']!="0000-00-00")
																$nominatedHfaWwcc .=', Expiry date: '.date('d M Y',strtotime($member['wwcc_expiry']));
															else
																$nominatedHfaWwcc .=', Expiry date unavailable';
														}
														else
														{
															if($member['wwcc_application_no']!='')
																$nominatedHfaWwcc .=' - Application no.: '.$member['wwcc_application_no'];
															else
																$nominatedHfaWwcc .=', Application no. unavailable';	
														}
											}
											else
												$nominatedHfaWwcc .=' - No WWCC details';
									}
								//wwcc #ENDS
								
								//Insurance #STARTS
									
									if($hfaThree['insurance']=="1")
									{
										$nominatedHfaInsurance='Insurance provider: ';
										if(trim($hfaThree['ins_provider'])!='')
											$nominatedHfaInsurance .=ucfirst($hfaThree['ins_provider']);
										else
											$nominatedHfaInsurance .='N/A';
										
										$nominatedHfaInsurance .=', Policy no.: ';
										if(trim($hfaThree['ins_policy_no'])!='')
											$nominatedHfaInsurance .=$hfaThree['ins_policy_no'];
										else
											$nominatedHfaInsurance .='N/A';
										
										$nominatedHfaInsurance .=', Expiry date: ';
										if($hfaThree['ins_expiry']!='0000-00-00')
											$nominatedHfaInsurance .=date('d M Y',strtotime($hfaThree['ins_expiry']));
										else
											$nominatedHfaInsurance .='N/A';
										
										  if($hfaThree['20_million']=='1')
											$nominatedHfaInsurance .=', $20 million Public Liability cover';
									}
									else
										$nominatedHfaInsurance="No";
									
								//Insurance #ENDS
								}
								else
								{
									$nominatedHfaWwcc='No WWCC details';
									$nominatedHfaInsurance='No';
								}
								
								$this->load->model('hfa_model');
								$hostNotes=$this->hfa_model->fanilynotedetail($booking['host']);
								$hostNotesVal="";//$hfaNoteTextObj = new PHPExcel_RichText();
								if(!empty($hostNotes))
								{
									
									foreach($hostNotes as $note)
									{
										//$hostNotesVal=$hostNotesVal."kjhkjhj ";
										//$hfaNoteTextObj = new PHPExcel_RichText();
										//$sf=$note['note_title'];
										//$hfaNoteTextObj->createTextRun($note['note_title'])->getFont()->setBold(true);
										/*$d=date('d M',strtotime($note['note_created']));
										$hfaNoteTextObj->createTextRun(" -".$d)->getFont()->setBold(true);
										$y=date('Y',strtotime($note['note_created']));
										$hfaNoteTextObj->createTextRun(" ".$y)->getFont()->setBold(true);
										$hfaNoteTextObj->createTextRun("\n".$note['notes_family']."\n");*/
										$hostNotesVal .=$note['note_title'].' - '.date('d M Y',strtotime($note['note_created']));
										$hostNotesVal .="\n".$note['notes_family'];
										$hostNotesVal .="\n"."============================="."\n";
									}
								}
							}
						/*}*/
						$this->load->model('sha_model');
						$shaNotes=$this->sha_model->notedetail($booking['student']);
						$shaNotesVal='';
								if(!empty($shaNotes))
								{
									foreach($shaNotes as $shaNote)
									{
										//$shaNotesVal=$shaNotesVal."kjhkjhj ";
										$shaNotesVal .=$shaNote['note_title'].' - '.date('d M Y',strtotime($shaNote['note_created']));
										$shaNotesVal .="\n".$shaNote['notes_family'];
										$shaNotesVal .="\n"."============================="."\n";
									}
								}
					
					
					$lastVisitDate=$this->getShaLastVistDate($booking['host']);
					$bookingStartDate=date('d M Y',strtotime($booking['booking_from']));
					if($booking['booking_to']!='0000-00-00')
						$bookingEndDate=date('d M Y',strtotime($booking['booking_to']));
					else	
						$bookingEndDate='Not set';
					$bookingStatus=$bookingStatusList[$booking['status']];
					////////////////
					
					$this->excel->getActiveSheet()->setCellValue('A'.$x, $sha['sha_student_no']);
					$this->excel->getActiveSheet()->setCellValue('B'.$x, ucwords($sha['fname'].' '.$sha['lname']));
					$this->excel->getActiveSheet()->setCellValue('C'.$x, $nation);
					$this->excel->getActiveSheet()->setCellValue('D'.$x, $bookingActive);
					$this->excel->getActiveSheet()->setCellValue('E'.$x, $bookingId);
					$this->excel->getActiveSheet()->setCellValue('F'.$x, $bookingNotes);
					$this->excel->getActiveSheet()->setCellValue('G'.$x, $client);
					$this->excel->getActiveSheet()->setCellValue('H'.$x, $college);
					$this->excel->getActiveSheet()->setCellValue('I'.$x, $homestayChanged);
					$this->excel->getActiveSheet()->setCellValue('J'.$x, $homestayChangedCount);
					$this->excel->getActiveSheet()->setCellValue('K'.$x, $homestayNomination);
					$this->excel->getActiveSheet()->setCellValue('L'.$x, $nominatedHfa);
					$this->excel->getActiveSheet()->setCellValue('M'.$x, $nominatedHfaAddress);
					$this->excel->getActiveSheet()->setCellValue('N'.$x, $nominatedHfaContact);
					$this->excel->getActiveSheet()->setCellValue('O'.$x, $nominatedHfaWwcc);
					$this->excel->getActiveSheet()->setCellValue('P'.$x, $nominatedHfaInsurance);
					
					$this->excel->getActiveSheet()->setCellValue('Q'.$x, $hostNotesVal);
					$this->excel->getActiveSheet()->setCellValue('R'.$x, $shaNotesVal);
					
					$this->excel->getActiveSheet()->setCellValue('S'.$x, $lastVisitDate);
					$this->excel->getActiveSheet()->setCellValue('T'.$x, $bookingStartDate);
					$this->excel->getActiveSheet()->setCellValue('U'.$x, $bookingEndDate);
					$this->excel->getActiveSheet()->setCellValue('V'.$x, $bookingStatus);
					
					$this->excel->getActiveSheet()->getStyle('Q'.$x)->getAlignment()->setWrapText(true);
					$this->excel->getActiveSheet()->getStyle('R'.$x)->getAlignment()->setWrapText(true);
					$x++;//unset($hfaNoteTextObj);
				}
				
				$filename='sha.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
		
	}
	
	function hfaStatus($bookings)
	{
		foreach($bookings as $book)
		{
			$hfa=getHfaOneAppDetails($book['host']);			
			if($hfa['status']!='approved')
				echo $book['id'].' '.$hfa['status'].' '.$hfa['id'].'<br>';
		}
	}
	
	function getShaLastVistDate($hfaId)
	{
		$date='';
		$hfa=getHfaOneAppDetails($hfaId);
		if($hfa['status']!='approved')
		{
			$query=$this->db->query("select * from `hfa_visitReport` where `hfa_id`='".$hfaId."'");
			if($query->num_rows()>0)
			{
				$row=$query->row_array();
				$date=date('d M Y',strtotime($row['date_visited']));
			}
		}
		else
			$date=date('d M Y',strtotime($hfa['date_status_changed']));
		return $date;		
	}
	
	function moveHistory()
	{die();
		$res=$this->db->query("select * from `hfa_revisit_history` order by `id` ")->result_array();
		//see($res);
		
		foreach($res as $r)
		{
			$this->db->query("insert into `hfa_visitReport` (`hfa_id`,`date_visited`,`revisit`,`employee`,`comments`,`date`)values(?,?,?,?,?,?)",array($r['hfa_id'],$r['date_visited'],'1',$r['employee'],$r['comments'],$r['date']));
		}echo "Done";
	}
	
	
	//function bm2($bid,$from,$to)
	function bm2()
	{
		$bid=$_POST['marginBookingId'];
		$from=normalToMysqlDate($_POST['marginFrom']);
		$to=normalToMysqlDate($_POST['marginTo']);
		
		$booking=bookingDetails($bid);//see($booking);
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
		
		
		$to=date('Y-m-d',strtotime($to.' - 1 day'));
		$dayDiff=dayDiff($from,$to);
		
		echo $from.' '.$to.', days='.$dayDiff.'<br>';
		
		$initialInv=$this->initialInvBetDates($from,$to,$appId);
		//see($initialInv);
		
		$accFeeInInv=0;
		$placementFeeInInv=0;
		$apuFeeInInv=0;
		$caregivingFeeInInv=0;
		$nominationFeeInInv=0;
		$ottFeeInInv=0;
		$ccsFeeInInv=0;
		$customFeeInInv=0;
		
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
		
		echo "============<br><br>";
		
		$ongoingInv=$this->ongInvBetDates($from,$to,$appId);
		//see($ongoingInv);
		
		$accFeeInOnv=0;
		$holidayFeeOnInv=0;
		$customFeeOnInv=0;
		$caregivingFeeOnInv=0;
		
		foreach($ongoingInv as $ongInv)
		{
			$accFeeTotalOnInv=0;
			$holidayFeeTotalOnInv=0;
			
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
						$customFeeOnInv +=$ongInv['total'];
				}
			}
			
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
			$accFeeInOnv +=($accFeeTotalOnInv/$onInvDuration)*$dayDiffOngInv;
			//echo ($accFeeTotalOnInv/$onInvDuration)*$dayDiffOngInv.'<br>';
			
			$holidayFeeOnInv +=($holidayFeeTotalOnInv/$onInvDuration)*$dayDiffOngInv;
			////
		}
		
		/*echo "============<br>Ongoing Invoice<br>";
		
		echo 'Acc fee= '.$accFeeInInv.'<br>';
		echo 'Custom fee= '.$customFeeOnInv.'<br>';
		echo 'Holiday fee= '.$holidayFeeOnInv.'<br>';*/
		$totalOnInv=$accFeeInOnv+$customFeeOnInv+$holidayFeeOnInv;
		echo "============<br><br>";
		
		//echo "============<br>Total<br>";
		$total=$totalInInv+$totalOnInv;
		//echo $total;
		
		
		$accFeeTotal=$accFeeInInv+$accFeeInOnv;
		echo 'Acc fee= '.$accFeeTotal.'<br>';
		echo 'Placement fee= '.$placementFeeInInv.'<br>';
		echo 'APU fee= '.$apuFeeInInv.'<br>';
		$caregivingFeeTotal=$caregivingFeeInInv+$caregivingFeeOnInv;
		echo 'Caregiving fee= '.$caregivingFeeTotal.'<br>';
		echo 'Nomination fee= '.$nominationFeeInInv.'<br>';
		echo 'OTT fee= '.$ottFeeInInv.'<br>';
		echo 'CCS fee= '.$ccsFeeInInv.'<br>';
		
		$customFeeTotal=$customFeeInInv+$customFeeOnInv;
		echo 'Custom fee= '.$customFeeTotal.'<br>';
		echo 'Holiday fee= '.$holidayFeeOnInv.'<br>';
		
		echo "============<br>Total<br>";
		$total=$totalInInv+$totalOnInv;
		echo $total;
	}
	
	
	
	function initialInvBetDates($from,$to,$appId=0)
	{
		$sql="select * from `invoice_initial` where ";
		$sql .="`application_id`='".$appId."' and ";
		
		$sql .="(";
		$sql .="(`booking_from`>='".$from."' and `booking_from`<='".$to."')";//F BF T
		$sql .=" OR (`booking_to`>='".$from."' and `booking_to`<='".$to."')";//F BT T
		$sql .=" OR (`booking_from`<='".$from."' and  `booking_to`>='".$to."')";//BF F T BT
		$sql .=")";
		return $this->db->query($sql)->result_array();
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
	function bm3($bid)
	{
		$booking=bookingDetails($bid);//see($booking);
		/*$appId=$booking['student'];
		$shaInitialInvoiceWeekDays=shaInitialInvoiceWeekDays($appId);
		$OngoingInvoiceDate=date('Y-m-d',strtotime($booking['booking_from'].' + '.$shaInitialInvoiceWeekDays.' days'));
		$initialInvTo=date('Y-m-d',strtotime($OngoingInvoiceDate.' - 1 days'));
		echo 'From '.$booking['booking_from'];
		echo '  To '.$initialInvTo;
		$lastInvoice=initialInvoiceByShaId($appId);*/
		
		$lastInvoice=$this->bmInInv($booking);
		see($lastInvoice);
	}
	
	
	function bm4()
	{
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
		
		echo $from.' '.$to.', days='.$dayDiff.'<br>';
		
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
					if($inInvAmountPaid!=0)
					{
						if($inInvAmountPaid >= $customFeeInInv)
							$customFeeInInvPaid=$customFeeInInv;
						else
							$customFeeInInvPaid=$inInvAmountPaid;
						$inInvAmountPaid -=$customFeeInInvPaid;
					}
					//accomodation fee
					if($inInvAmountPaid!=0)
					{echo 'accFeeTotalInInv='.$accFeeInInv;
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
		
		echo "============<br><br>";
		
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
				if($ongInv['status']=='3')
				{
					$customFeeOnInvSinglePaid=$customFeeOnInvSingle;
					$customFeeOnInvPaid +=$customFeeOnInvSinglePaid;
					
					$accFeeInOnvSinglePaid=$accFeeInOnvSingle;
					$accFeeTotalOnInvPaid +=$accFeeInOnvSinglePaid;
				}
				elseif($ongInv['status']=='2')
				{
					$onInvAmountPaidSingle=0;
					$onInvDetails=ongoingInvoiceDetails($ongInv['id']);
					foreach($onInvDetails['payment'] as $onInvDetailsPayments)
						$onInvAmountPaidSingle +=$onInvDetailsPayments['amount_paid'];
					
					if($onInvAmountPaidSingle!=0)
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
		echo "============<br><br>";
		
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
		echo 'Acc fee= '.$accFeeTotal.' (Paid: '.$accFeeTotalPaid.')'.'<br>';
		echo 'Placement fee= '.$placementFeeInInv.' (Paid: '.$placementFeeInInvPaid.')'.'<br>';
		echo 'APU fee= '.$apuFeeInInv.' (Paid: '.$apuFeeInInvPaid.')'.'<br>';
		$caregivingFeeTotal=$caregivingFeeInInv+$caregivingFeeOnInv;
		$caregivingFeePaid=$caregivingFeeInInvPaid+$caregivingFeeonInvPaid;
		echo 'Caregiving fee= '.$caregivingFeeTotal.' (Paid: '.$caregivingFeePaid.')'.'<br>';
		echo 'Nomination fee= '.$nominationFeeInInv.' (Paid: '.$nominationFeeInInvPaid.')'.'<br>';
		echo 'OTT fee= '.$ottFeeInInv.' (Paid: '.$ottFeeInInvPaid.')'.'<br>';
		echo 'CCS fee= '.$ccsFeeInInv.' (Paid: '.$ccsFeeInInvPaid.')'.'<br>';
		
		$customFeeTotal=$customFeeInInv+$customFeeOnInv;
		echo 'Custom fee= '.$customFeeTotal.' (Paid: '.$customFeePaid.')'.'<br>';
		echo 'Holiday fee= '.$holidayFeeOnInv.'<br>';
		
		echo "============<br>Total<br>";
		$total=$totalInInv+$totalOnInv;
		echo $total.' (Paid: '.$totalPaid.')';
	}
	
	
	function bm4_backup()
	{
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
		
		echo $from.' '.$to.', days='.$dayDiff.'<br>';
		
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
		
		echo "============<br><br>";
		
		$ongoingInv=$this->ongInvBetDates($from,$to,$appId);
		//see($ongoingInv);
		
		$accFeeInOnv=0;
		$holidayFeeOnInv=0;
		$customFeeOnInv=0;
		$caregivingFeeOnInv=0;
		
		foreach($ongoingInv as $ongInv)
		{
			$accFeeTotalOnInv=0;
			$holidayFeeTotalOnInv=0;
			
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
						$customFeeOnInv +=$ongInv['total'];
				}
			}
			
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
			$accFeeInOnv +=($accFeeTotalOnInv/$onInvDuration)*$dayDiffOngInv;
			//echo ($accFeeTotalOnInv/$onInvDuration)*$dayDiffOngInv.'<br>';
			
			$holidayFeeOnInv +=($holidayFeeTotalOnInv/$onInvDuration)*$dayDiffOngInv;
			////
		}
		
		/*echo "============<br>Ongoing Invoice<br>";
		
		echo 'Acc fee= '.$accFeeInInv.'<br>';
		echo 'Custom fee= '.$customFeeOnInv.'<br>';
		echo 'Holiday fee= '.$holidayFeeOnInv.'<br>';*/
		$totalOnInv=$accFeeInOnv+$customFeeOnInv+$holidayFeeOnInv;
		echo "============<br><br>";
		
		//echo "============<br>Total<br>";
		$total=$totalInInv+$totalOnInv;
		//echo $total;
		
		
		$accFeeTotal=$accFeeInInv+$accFeeInOnv;
		echo 'Acc fee= '.$accFeeTotal.'<br>';
		echo 'Placement fee= '.$placementFeeInInv.'<br>';
		echo 'APU fee= '.$apuFeeInInv.'<br>';
		$caregivingFeeTotal=$caregivingFeeInInv+$caregivingFeeOnInv;
		echo 'Caregiving fee= '.$caregivingFeeTotal.'<br>';
		echo 'Nomination fee= '.$nominationFeeInInv.'<br>';
		echo 'OTT fee= '.$ottFeeInInv.'<br>';
		echo 'CCS fee= '.$ccsFeeInInv.'<br>';
		
		$customFeeTotal=$customFeeInInv+$customFeeOnInv;
		echo 'Custom fee= '.$customFeeTotal.'<br>';
		echo 'Holiday fee= '.$holidayFeeOnInv.'<br>';
		
		echo "============<br>Total<br>";
		$total=$totalInInv+$totalOnInv;
		echo $total;
	}
	
	function bmPo()
	{
		$bid=$_POST['marginBookingId'];
		$from=normalToMysqlDate($_POST['marginFrom']);
		$to=normalToMysqlDate($_POST['marginTo']);
		
		$booking=bookingDetails($bid);//see($booking);
		$appId=$booking['student'];
		
		if(strtotime($booking['booking_from']) > strtotime($from))
			$from=$booking['booking_from'];
		
		//$to=date('Y-m-d',strtotime($to.' - 1 day'));
		$dayDiff=dayDiff($from,$to);
		
		echo $from.' '.$to.', days='.$dayDiff.'<br>';
		echo '===============================<br>';
		
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
			
			//Payment #STARTS
			if($po['status']=='2')
			{
				$customFeePoSinglePaid=$customFeePoSingle;
				$customFeePoPaid +=$customFeePoSinglePaid;
				
				$accFeePoSinglePaid=$accFeePoSingle;
				$accFeePoPaid +=$accFeePoSinglePaid;
				
				$adminFeePoSinglePaid=$adminFeePoSingle;
				$adminFeePoPaid +=$adminFeePoSinglePaid;
				
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
				if($poAmountPaidSingle!=0)
				{
					if($poAmountPaidSingle >= $customFeePoSingle)
						$customFeePoSinglePaid=$customFeePoSingle;
					else
						$customFeePoSinglePaid=$poAmountPaidSingle;
					$poAmountPaidSingle -=$customFeePoSinglePaid;
				}
				
				//Admin fee	
				if($poAmountPaidSingle!=0)
				{
					if($poAmountPaidSingle >= $adminFeePoSingle)
						$adminFeePoSinglePaid=$adminFeePoSingle;
					else
						$adminFeePoSinglePaid=$poAmountPaidSingle;
					$poAmountPaidSingle -=$adminFeePoSinglePaid;
				}
				
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
				$adminFeePoPaid +=$adminFeePoSinglePaid;
				//$holidayFeePoPaid +=$holidayFeePoSinglePaid;
			}
			//Payment #ENDS
		}
		echo '   Accomodation fee: '.$accFeePo.' (Paid: '.$accFeePoPaid.')';
		echo '<br>   Admin fee: '.$adminFeePo.' (Paid: '.$adminFeePoPaid.')';
		echo '<br>   Custom fee: '.$customFeePo.' (Paid: '.$customFeePoPaid.')';
		echo '<br>   Holiday fee: '.$holidayFeePo;
		
		$poTotalAmount=$accFeePo+$adminFeePo+$customFeePo+$holidayFeePo;
		$poTotalAmountPaid=$accFeePoPaid+$adminFeePoPaid+$customFeePoPaid;
		echo '<br> Total amount= '.$poTotalAmount.' (Paid: '.$poTotalAmountPaid.')';
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
	
	
	function clientsCsv()
	{
			$this->load->library('excel');
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle('test worksheet');
		
			$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
					'font'=>array(
					'name'      =>  'Arial',
					'size'      =>  10,
				)
			));
			
			for($c='A';$c<='E';$c++)
			$this->excel->getActiveSheet()->getColumnDimension($c)->setAutosize(true);
			
			
		  
		  $excel_table_headings_new=array(
			  'A'=>'Business name',
			  'B'=>'Type',
			  'C'=>'State',
			  'D'=>'Group',
			  'E'=>'Homestay fee account code'
			);	
			
			$excel_table_headings_new=array(
			  'A'=>'Id',
			  'B'=>'Business name',
			  'C'=>'Type',
			  'D'=>'State',
			  'E'=>'Group',
			  'F'=>'Homestay fee account code'
			);	
		  
		  		$x_start=1;
		  		foreach($excel_table_headings_new as $k=>$v)
				{
					$this->excel->getActiveSheet()->setCellValue($k.$x_start, $v);
				}
				//$this->excel->getActiveSheet()->getStyle('A'.$x_start.':E'.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
				//$this->excel->getActiveSheet()->getStyle('A'.$x_start.':E'.$x_start)->getFont()->setSize(10)->setBold(true);
				$this->excel->getActiveSheet()->getStyle('A'.$x_start.':F'.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
				$this->excel->getActiveSheet()->getStyle('A'.$x_start.':F'.$x_start)->getFont()->setSize(10)->setBold(true);
			 	
				$x=$x_start+1;
				$clients=$this->db->query("select * from `clients` order by `bname`")->result_array();
				$clientCategories=clientCategories();
				foreach($clients as $client)
				{
					/*$this->excel->getActiveSheet()->setCellValue('A'.$x, $client['bname']);
					$this->excel->getActiveSheet()->setCellValue('B'.$x, $clientCategories[$client['category']]);
					$this->excel->getActiveSheet()->setCellValue('C'.$x, $client['state']);
					$this->excel->getActiveSheet()->setCellValue('D'.$x, '');
					$this->excel->getActiveSheet()->setCellValue('E'.$x, '');*/
					if($client['id']==1600){continue;}
					$this->excel->getActiveSheet()->setCellValue('A'.$x, $client['id']);
					$this->excel->getActiveSheet()->setCellValue('B'.$x, $client['bname']);
					$this->excel->getActiveSheet()->setCellValue('C'.$x, $clientCategories[$client['category']]);
					$this->excel->getActiveSheet()->setCellValue('D'.$x, $client['state']);
					$this->excel->getActiveSheet()->setCellValue('E'.$x, '');
					$this->excel->getActiveSheet()->setCellValue('F'.$x, '');
					
					$x++;
				}
				
				$filename='clientsNew.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
		
	}
	
	function posNew()
	{
		//$bookings=[2332,2331,3531,2306,2386,3532,4177,3926,2348,2879,1475,485,1154,429,3721,460,1156,15,1915,3090,2344,2,2310,3482,3428,3268,3554,342,271,3199,3245,3684];
		//$bookings=[3251,2495,2144,3692,3693,3508,3507,3465,3479,1713,4244,3720,3222,4047,3483,4075,4175,1877,4221,3436,3588,734,3474,1950,3900,3883,3911,3421,3643,484,3978,4076,4055,1120,4194,3615,3668,3343,3820,3921,4190,3403,2314,296,382,3178,2002];
		//$bookings=[3686,1916,3731,2469,2472,3386,3899,3791,3896,3882,3908,2204,4431,2670,4059,3095,1114,4065,3186,1689,409,2670,4059,4142,2689,3663,3981,2275,1878,2404,1879,3906,1424,3655,4074,455,4150,237,2118,3526,4078,2335,3359,3373,2914,1397,2394,1106,3897];
		//$bookings=[4438,4447,1135,3711,3445,4063,1109,1103,3371,2963,3982,2203,3392,3653,1555,3307,3458,3633,3762,2958,4193,4361,4252,1516,4369,4406,3697,1848,3933,3798,4401,3676,4001,3802,2062,3689,4002,3905,4407,324,4050,3996,4411,4416,3321,4228,1347,4269,4282,2526,4289,482,2946,4191,4370,1383];
		//$bookings=[2429,3939,1043,3283,3895,3979,4283,1008,3997,2717,2893,3677,3973,698,3585,3975,3895,3979,4283,1008,3997,2717,2893,3677,3973,698,3585,3975,4163,1883,3980,2416,3603,4357,3495,3880,4367,3527,4392,4400,1032,2942,3521,4192,4216,277,970,3510,3995,3719,4143,714,4049,1600,4053,4358,1732,4295,1955,3626,4360,4185,4206,1643,3826,4288,876,4292,4359,374,506,304,2814,2815,3907,3938,2816,3889,3984,2817,4205,3934,3986,268,3620,3999,3640,3964,4046,4012,4054,3352,4201];
		//$bookings=[3559,3952,4067,4274,4376,3927,747,1766,443,1844,2661,3406,3494,3564,2488,3992,3888,3619,3712,1136,1771,3928,1133,3712,1136,1771,3928,1133,3518,29,2365,2839,2812,2000,3226,3669,3703,4141,3600,308,2375,2467,3967,2549,3351,4064,3279,4222,1941,4225,4227,2697,4277,206,219,2747,4403,3578,4197,393,1134,3621,376,2323,2859,2223,2374,3064,282,2070,3385,2383,3476,347,2565,3500,3127,3562,3755,3493,3783,2700,3848,4204,4209,2212,4226,2855,4284,278,3306,4045,4287,1116,297,301,411,3670,442,426,1892,2465,2846,2868,3347,4186];
		//$bookings=[3678 ,3679 ,4108 ,3825 ,3616 ,3394 ,3993 ,3405 ,4255 ,4254 ,3698 ,4245 ,4253 ,4363 ,3739 ,4362 ,4365 ,4154 ,3727 ,4263 ,3687 ,4365 ,4072 ,4105 ,2870 ,4115 ,4373 ,1861];
		//$bookings=[3322,3887,4077,3048,3262,3665,3622,2728,3898,3894,2813,4211,4348,4215,4349,4164,4350,4220,4212,4351,4219,3972,4352,4223,4165,4353,4224,4000,4166,4354,4214,4355,4229,4173,4356,4200,4174,4213,3714,4210,4294,4313,4329,4346,4073,4296,4314,4330,4368,4297,4315,4331,4298,4316,4333,4299,4334,4300,4335,3925,3671,3968,4302,4319,4336,3672,4303,4320,4337,3673,4103,4304,4321,4338,4305,4322,4339,3909,3970,4306,4323,4340,3903,4307,4324,4341,4420,3904,4308,3925,3671,3968,4302,4319,4336,3672,4303,4320,4337,3673,4103,4304,4321,4338,3162,3716,4010,1733,3935,2662,3891,4203,3059,1541,3715,3920];
		/*foreach($bookings as $bid)
		{
			$po=$this->db->query("select * from `purchase_orders` where `booking_id`=$bid order by `id` DESC limit 1")->row_array();
			echo $po['booking_id'].', '.$po['from'].', '.$po['to'].'<br>';
		}*/
		
		$bookings=$this->db->query("SELECT * FROM `bookings` WHERE `generate_po` = '1' AND `serviceOnlyBooking`='0' AND `status` LIKE 'arrived'")->result_array();
		foreach($bookings as $book)
		{
			$rows=$this->db->query("select * from `purchase_orders` where `booking_id`='".$book['id']."'")->num_rows();
			if($rows==0)
				echo "<br>".$book['id'];
		}
	}
	
	function ggf1()
	{
		$sha=$this->db->query("select * from `sha_three` where `college`!=''")->result_array();
		foreach($sha as $sh)
		{
			$rows=$this->db->query("select * from `clients` where `bname`=?",$sh['college'])->num_rows();
			if($rows==0)
				echo $sh['id'].'<br>';
		}
	}
	
	
	function ggf()
	{
			$this->load->library('excel');
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle('test worksheet');
		
			$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
					'font'=>array(
					'name'      =>  'Arial',
					'size'      =>  10,
				)
			));
			
			for($c='A';$c<='D';$c++)
			$this->excel->getActiveSheet()->getColumnDimension($c)->setAutosize(true);
			
			
		  
		  $excel_table_headings_new=array(
			  'A'=>'Student Id',
			  'B'=>'Student Name',
			  'C'=>'College Name',
			  'D'=>'College Group',
			);	
			
			
		  
		  		$x_start=1;
		  		foreach($excel_table_headings_new as $k=>$v)
				{
					$this->excel->getActiveSheet()->setCellValue($k.$x_start, $v);
				}
				//$this->excel->getActiveSheet()->getStyle('A'.$x_start.':E'.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
				//$this->excel->getActiveSheet()->getStyle('A'.$x_start.':E'.$x_start)->getFont()->setSize(10)->setBold(true);
				$this->excel->getActiveSheet()->getStyle('A'.$x_start.':D'.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
				$this->excel->getActiveSheet()->getStyle('A'.$x_start.':D'.$x_start)->getFont()->setSize(10)->setBold(true);
			 	
				$x=$x_start+1;
				$sha=$this->db->query("select * from `sha_three` where `college`!=''")->result_array();
				foreach($sha as $sh)
				{
					$rows=$this->db->query("select * from `clients` where `bname`=?",$sh['college'])->num_rows();
					if($rows==0)
					{
						$shaOne=getshaOneAppDetails($sh['id']);
						$this->excel->getActiveSheet()->setCellValue('A'.$x, $sh['id']);
						$this->excel->getActiveSheet()->setCellValue('B'.$x, $shaOne['fname'].' '.$shaOne['lname']);
						$this->excel->getActiveSheet()->setCellValue('C'.$x, $sh['college']);
						$this->excel->getActiveSheet()->setCellValue('D'.$x, '');
						
						$x++;
					}
				}
				
				
				$filename='clientsNew.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
		
	}
	
	function upSC()
	{
		$client=1511;
		$shaId="'204','25191'";
		$college=$this->db->query("select * from `clients` where `id`=?",$client)->row_array();
		if(!empty($college))
		{
			$college_group=$college['client_group'];
			$bname=$college['bname']; 
			$sub=$college['suburb']; 
			
			
			$row1='';
			$stringAddress='';
			if(trim($college['suburb'])!='')
				$stringAddress .=' '.trim($college['suburb']);
			if(trim($college['state'])!='')
			{
				if($stringAddress!='')
					$stringAddress .='*';
				$stringAddress .=trim($college['state']);
			}
			if(trim($college['postal_code'])!='' && $college['postal_code']!='0')
			{
				$stringAddress .=' '.trim($college['postal_code']);
			}
					
		  $row1 .= $college['street_address'];
		  if($college['street_address']!='' && $stringAddress!='')
			$row1.=',';
		  $row1.=str_replace('*',', ',$stringAddress);

		  $add=$row1 ;
		
		  $this->db->query("update `sha_three` set `college`=?, `college_group`=?, `campus`=?, `college_address`=? where `id` IN($shaId)",array($bname, $college_group, $sub, $add));
		  echo $this->db->last_query();
		}
		else
			echo "empty";
	}
	
	function generateOngoingInvoices()
		{
			echo $d=date('Y-m-d',strtotime(date('Y-m-d').'+1 day'));
			$date=date('Y-m-d',strtotime($d.'+2 week'));
			//$date='2018-11-15';
			$this->load->model('cron_model');
			$bookings=$this->cron_model->ongoingBooking($date);
			echo $this->db->last_query();
			
			$this->load->model('invoice_model');
			foreach($bookings as $booking)
			{echo "<br>Booking_id".$booking['id'];
				$lastInvoice=$this->invoice_model->getLastOngoingInvoiceByStudentId($booking['student']);
				if(empty($lastInvoice))
				{
					$lastInvoice=initialInvoiceByShaId($booking['student']);
					if($lastInvoice['study_tour']=='1')
						continue;
					$shaInitialInvoiceWeekDays=shaInitialInvoiceWeekDays($booking['student']);
					$OngoingInvoiceDate=date('Y-m-d',strtotime($booking['booking_from'].' + '.$shaInitialInvoiceWeekDays.' days'));
					
					echo '<br>'.$OngoingInvoiceDate.'=='.$date;
				}
			}
			
			
		}
		
		function test()
		{
			$a = "sdfsd/en/sdfsdf";
			if (strpos($a, '/en/') !== false) 
	    	 echo "yes";
			else
			echo "No";
			
		
		}
		
}
