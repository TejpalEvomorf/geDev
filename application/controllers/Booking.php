<?php
class Booking extends CI_Controller {
	
		function __construct()
		{
			parent::__construct();
			$this->load->model('booking_model');
			$this->load->helper('product');
		}
	
		function index()
		{
			if(checkLogin())
				{
					$data['page']='bookings';
					$status='all';
					$this->applicationByStatus($status);
				}
				else
					redirectToLogin();
		}
		
		function expected_arrival()
		{
			if(checkLogin())
			{
				$status='expected_arrival';
				$this->applicationByStatus($status);
			}
			else
				redirectToLogin();
		}
		
		function on_hold()
		{
			if(checkLogin())
			{
				$status='on_hold';
				$this->applicationByStatus($status);
			}
			else
				redirectToLogin();
		}
		
		function cancelled()
		{
			if(checkLogin())
			{
				$status='cancelled';
				$this->applicationByStatus($status);
			}
			else
				redirectToLogin();
		}
		
		function arrived()
		{
			if(checkLogin())
			{
				$status='arrived';
				$this->applicationByStatus($status);
			}
			else
				redirectToLogin();
		}
		
		function progressive()
		{
			if(checkLogin())
			{
				$status='progressive';
				$this->applicationByStatus($status);
			}
			else
				redirectToLogin();
		}
		
		function moved_out()
		{
			if(checkLogin())
			{
				$status='moved_out';
				$this->applicationByStatus($status);
			}
			else
				redirectToLogin();
		}
		
		function applicationByStatus($status)
		{
			recentActionsAddData('booking',$status,'view');
			
			$data['page']='bookings';

			$data['booking_status_page']=$status;
			//see($data['list']);exit;
			$this->load->view('system/header',$data);
			$this->load->view('system/booking/list');
			$this->load->view('system/footer');
		}
		
		
		function matchedAppPlaceBookingPopContent($student_id,$host_id)
		{
			$data=array();
			$data['student']=$student_id;
			$data['studentOne']=getShaOneAppDetails($student_id);
			$data['host']=$host_id;
			$this->load->view('system/booking/placeBookingForm',$data);
		}
		
		
		function matchedAppPlaceBookingPopContentCH($student_id,$host_id)
		{
			$data=array();
			$data['student']=$student_id;
			$data['studentOne']=getShaOneAppDetails($student_id);
			$data['host']=$host_id;
			$this->load->view('system/booking/placeBookingFormCH',$data);
		}
		
		function eidtBookingPopContent($id)
		{
			$data=array();
			$data['booking']=bookingDetails($id);
			if(!empty($data['booking']))
			{
				$return['first']=$this->load->view('system/booking/editBookingForm',$data,true);
				$return['second']=$this->load->view('system/booking/editBookingFormSecond',$data,true);
				echo json_encode($return);
			}
		}
		
		function add()
		{
			if(checkLogin())
			{
				$data=$_POST;
				if(isset($data['host']))
					{
						if($data['placeBooking_startDate']!='' && $data['placeBooking_endDate']!='')
						{
							if(strtotime(normalToMysqlDate($data['placeBooking_startDate'])) > strtotime(normalToMysqlDate($data['placeBooking_endDate'])))
								echo 'properDate';
							else	
								$this->booking_model->addBooking($data);
						}
						else	
								$this->booking_model->addBooking($data);
					}
			}
			else
				redirectToLogin();
		}
		
		function edit()
		{
			if(checkLogin())
			{
			$data=$_POST;
			if(isset($data['booking_id']))
			{
					if($data['placeBooking_startDate']!='' && $data['placeBooking_endDate']!='')
					{
						if(strtotime(normalToMysqlDate($data['placeBooking_startDate'])) > strtotime(normalToMysqlDate($data['placeBooking_endDate'])))
							echo 'properDate';
						else	
							$this->booking_model->editBooking($data);
						
						
							 /* if(normalToMysqlDate($data['placeBooking_endDate']) > normalToMysqlDate($data['placeBooking_endDateOld']) && $data['placeBooking_endDateOld']!='')
								  {
									  if(dayDiff(date('Y-m-d'),normalToMysqlDate($data['placeBooking_endDateOld']))<=8)
									  {
										  //addNewOngoingInvoice($data['booking_id']);
										  echo "ongoingInvoiceGenerated";
									  }else{echo "extended but no change in invoice";}
								  }else
								  {
									  echo "not extended: Preponed";
									  
								  }*/
						 
					}
					else	
							$this->booking_model->editBooking($data);
			}
			}
			else
				echo "LO";
			
		}
		
		/*
		function afterBookingEdit($id)
		{
			$return='noResult';
			$bookingDetails=bookingDetails($id);
			
			/////////////#starts
			$this->load->model('invoice_model');
			$lastInvoice=$this->invoice_model->getLastOngoingInvoiceByStudentId($bookingDetails['student']);
			if(empty($lastInvoice))
			{	
				//echo "Initial - - -- ";
				$lastInvoiceType='initial';
				$lastInvoice=initialInvoiceByShaId($bookingDetails['student']);
				$shaInitialInvoiceWeekDays=shaInitialInvoiceWeekDays($bookingDetails['student']);
				if($shaInitialInvoiceWeekDays>0)
				{
					$InvoiceBookingTo=date('Y-m-d',strtotime($bookingDetails['booking_from'].' + '.$shaInitialInvoiceWeekDays.' days'));
					$InvoiceBookingFrom=$bookingDetails['booking_from'];
				}
			}
			else
			{	
				//echo "Ongoing - - -- ";
				$lastInvoiceType='ongoing';
				$InvoiceBookingTo=$lastInvoice['booking_to'];
				$InvoiceBookingFrom=$lastInvoice['booking_from'];	
			}
			
			if(isset($InvoiceBookingFrom) && isset($InvoiceBookingTo))
			{
				$dayDiff=dayDiff($InvoiceBookingFrom,$InvoiceBookingTo);
				
				if($dayDiff<=29 && strtotime($bookingDetails['booking_to'])<strtotime($InvoiceBookingTo))
				{
					//echo "Prepone";
					
					if($lastInvoice['status']=='1')//if not paid, if not paid then invoice will always be ongoing coz booking cannot be created with initial invoice unpaid
					{
						if($lastInvoice['moved_to_xero']=='0')//if not moved to xero
						{
							//echo " >>> Not moved to xero";
							$this->invoice_model->deleteOngoingInvoice($lastInvoice['id']);
							addNewOngoingInvoice($id);
						}
						else//moved to xero
						{
							//echo " >>> Moved to xero";
							$this->invoice_model->deleteOngoingInvoice($lastInvoice['id']);
							deleteXeroInvoice($lastInvoice['invoice_number']);
							addNewOngoingInvoice($id);
						}
						$return="InvUp";
					}
					else//if paid, now it can be either Initial or Ongoing
					{
						//edit existing invoice
						if($lastInvoiceType=='initial')
						{
							//echo "<br>Initial invoice updated";
							$this->invoice_model->updateInitialInvItems($bookingDetails,$lastInvoice['id']);
						}
						else
						{
							//echo "<br>Paid Ongoing invoice updated";
							$ongoingFrom=$lastInvoice['booking_from'];
							$ongoingTo=$bookingDetails['booking_to'];
							$this->invoice_model->updateOngInvItems($ongoingFrom,$ongoingTo,$bookingDetails['student'],$lastInvoice['id']);
						}
						$return="InvUpXero";
					}
				}
				elseif($dayDiff< 29 && strtotime($bookingDetails['booking_to'])>strtotime($InvoiceBookingTo))	
				{
					//echo "-------Postpone";
					
					if($lastInvoiceType=='initial')
					{	
						//echo " >>>> Initial invoice";
						//if initial then it will always be paid, so we will create a new ongoing booing for the extra days
						addNewOngoingInvoice($id);
						$return="InvAdd";
					}
					else
					{
						//echo "  >>> ongoing invoice ";
						if($lastInvoice['status']=='1')//If not Paid, then we will update the existing ongoing invoice whether it is sent to xero or not
						{
							$this->invoice_model->deleteOngoingInvoice($lastInvoice['id']);
							if($lastInvoice['moved_to_xero']=='1')//moved to xero
							{
								//echo " >>> Moved to xero";
								deleteXeroInvoice($lastInvoice['invoice_number']);
							}
							//else//if not moved to xero
								//echo " >>> Not moved to xero";
						}
						
						addNewOngoingInvoice($id);
						$return="InvUp";
					}
				}
				else
				{
					
					//if last invoice is more than 4 weeks, then it will always be onging invoice because initial invoice is never more than 4 weeks and ongoing invoice can be more than 4 weeks if its left with less than a week after that invoice(it can be between 4 to 5 week)
					if($dayDiff >= 29 && strtotime($bookingDetails['booking_to'])!=strtotime($InvoiceBookingTo))
					{
						if(strtotime($bookingDetails['booking_to'])>strtotime($InvoiceBookingTo))
							{
								//Prepone
								
								if($lastInvoice['status']=='1')//if not paid
										{
											if($lastInvoice['moved_to_xero']=='0')//if not moved to xero
											{
												//echo " >>> Not moved to xero";
												$this->invoice_model->deleteOngoingInvoice($lastInvoice['id']);
												addNewOngoingInvoice($id);
											}
											else//moved to xero
											{
												//echo " >>> Moved to xero";
												$this->invoice_model->deleteOngoingInvoice($lastInvoice['id']);
												deleteXeroInvoice($lastInvoice['invoice_number']);
												addNewOngoingInvoice($id);
											}
											$return="InvUp";
										}
										else//if paid, now it can be either Initial or Ongoing
										{
											//edit existing invoice
											
												//echo "<br>Paid Ongoing invoice updated";
												$ongoingFrom=$lastInvoice['booking_from'];
												$ongoingTo=$bookingDetails['booking_to'];
												$this->invoice_model->updateOngInvItems($ongoingFrom,$ongoingTo,$bookingDetails['student'],$lastInvoice['id']);
											
											$return="InvUpXero";
										}
							}
						else	
							{
								//Postpone
								
								if($lastInvoice['status']=='1')//If not Paid, then we will update the existing ongoing invoice whether it is sent to xero or not
									{
										$this->invoice_model->deleteOngoingInvoice($lastInvoice['id']);
										if($lastInvoice['moved_to_xero']=='1')//moved to xero
										{
											//echo " >>> Moved to xero";
											deleteXeroInvoice($lastInvoice['invoice_number']);
										}
									}
									
									addNewOngoingInvoice($id);
									$return="InvUp";
										}
					}
					
					//echo "Nothing";This is the case of extension
					if(strtotime($bookingDetails['booking_to'])>strtotime($lastInvoice['booking_to']) && dayDiff(date('Y-m-d'),$lastInvoice['booking_to'])<8)
						{
							//echo "<br>Have to create a new ongoing booking that can be skipped";
							addNewOngoingInvoice($id);
							$return="InvAdd";
						}
				}
			}
			//else
			//	echo "No invoice";
				echo $return;
		}*/
		
		function afterBookingEdit($id)
		{
			$return='noResult';
			$bookingDetails=bookingDetails($id);
			
			/////////////#starts
			$this->load->model('invoice_model');
			$lastInvoice=$this->invoice_model->getLastOngoingInvoiceByStudentId($bookingDetails['student']);
			if(empty($lastInvoice))
			{	
				//echo "Initial - - -- ";
				$lastInvoiceType='initial';
				$lastInvoice=initialInvoiceByShaId($bookingDetails['student']);
				$shaInitialInvoiceWeekDays=shaInitialInvoiceWeekDays($bookingDetails['student']);
				if($shaInitialInvoiceWeekDays>0)
				{
					$InvoiceBookingTo=date('Y-m-d',strtotime($bookingDetails['booking_from'].' + '.$shaInitialInvoiceWeekDays.' days'));
					$InvoiceBookingFrom=$bookingDetails['booking_from'];
				}
			}
			else
			{	
				//echo "Ongoing - - -- ";
				$lastInvoiceType='ongoing';
				$InvoiceBookingTo=$lastInvoice['booking_to'];
				$InvoiceBookingFrom=$lastInvoice['booking_from'];	
			}
			
			if(isset($InvoiceBookingFrom) && isset($InvoiceBookingTo))
			{
				$dayDiff=dayDiff($InvoiceBookingFrom,$InvoiceBookingTo);
				
				if($dayDiff<=29 && strtotime($bookingDetails['booking_to'])<strtotime($InvoiceBookingTo))
				{
					//echo "Prepone";
					
					if($lastInvoice['status']=='1')//if not paid, if not paid then invoice will always be ongoing coz booking cannot be created with initial invoice unpaid
					{
						if($lastInvoice['moved_to_xero']=='0')//if not moved to xero
						{
							//echo " >>> Not moved to xero";
							$this->invoice_model->deleteOngoingInvoice($lastInvoice['id']);
							addNewOngoingInvoice($id);
							$return="InvUp";
						}
						else//moved to xero
						{
						}
					}
					else//if paid, now it can be either Initial or Ongoing
					{
						
					}
				}
				elseif($dayDiff< 29 && strtotime($bookingDetails['booking_to'])>strtotime($InvoiceBookingTo))	
				{
					//echo "-------Postpone";
					
					if($lastInvoiceType=='initial')
					{	
						//echo " >>>> Initial invoice";
						//if initial then it will always be paid, so we will create a new ongoing booing for the extra days
						addNewOngoingInvoice($id);
						$return="InvAdd";
					}
					else
					{
						//echo "  >>> ongoing invoice ";
						
						if($lastInvoice['moved_to_xero']=='0')
						{
							if($lastInvoice['status']=='1')//If not Paid, then we will update the existing ongoing invoice whether it is sent to xero or not
							{
								$this->invoice_model->deleteOngoingInvoice($lastInvoice['id']);
							}
							
							addNewOngoingInvoice($id);
							$return="InvUp";
						}
					}
				}
				else
				{
					
					//if last invoice is more than 4 weeks, then it will always be onging invoice because initial invoice is never more than 4 weeks and ongoing invoice can be more than 4 weeks if its left with less than a week after that invoice(it can be between 4 to 5 week)
					if($dayDiff >= 29 && strtotime($bookingDetails['booking_to'])!=strtotime($InvoiceBookingTo))
					{
						if(strtotime($bookingDetails['booking_to'])>strtotime($InvoiceBookingTo))
							{
								//Prepone
								
								if($lastInvoice['status']=='1')//if not paid
										{
											if($lastInvoice['moved_to_xero']=='0')//if not moved to xero
											{
												//echo " >>> Not moved to xero";
												$this->invoice_model->deleteOngoingInvoice($lastInvoice['id']);
												addNewOngoingInvoice($id);
												$return="InvUp";
											}
											else//moved to xero
											{
											}
										}
										else//if paid, now it can be either Initial or Ongoing
										{
											//edit existing invoice
										}
							}
						else	
							{
								//Postpone
								
								if($lastInvoice['moved_to_xero']=='0')//moved to xero
								{
									if($lastInvoice['status']=='1')//If not Paid, then we will update the existing ongoing invoice whether it is sent to xero or not
									{
										$this->invoice_model->deleteOngoingInvoice($lastInvoice['id']);
									}
									addNewOngoingInvoice($id);
									$return="InvUp";
								}
							}
					}
				}
				
				//echo "Nothing";This is the case of extension
					if((strtotime($bookingDetails['booking_to'])>strtotime($lastInvoice['booking_to']) || $bookingDetails['booking_to']=='0000-00-00') && dayDiff(date('Y-m-d'),$lastInvoice['booking_to'])<15)
						{
							//echo "<br>Have to create a new ongoing booking that can be skipped";
							addNewOngoingInvoice($id);
							$return="InvAdd";
						}
			}
			
			//Creating PO if PO will be missed due to extention on the booking
			$this->createMissedPO($id,$bookingDetails['booking_to']);
			/*else
				echo "No invoice";*/
				echo $return;
		}
		
		function createMissedPO($booking_id,$bookingTo)
		{
				$this->load->model('po_model');
				$lastPO=$this->po_model->getLastPoForBooking($booking_id);
				
				if(!empty($lastPO))
				{
						$lastPoTo=$lastPO['to'];
						if((strtotime($lastPoTo) < strtotime($bookingTo)) || $bookingTo=='0000-00-00')//if booking To date is more then last PO To date, then check if PO needs to be generated
						{
							$dateToday=date('Y-m-d');
							$date=date('Y-m-d',strtotime($dateToday.' next Friday'));
							$type='ongoing';
							$dateDuration=getPoDateByPoCreateDate($date,$type);
							
							$from=date('Y-m-d',strtotime($dateDuration['dateFrom'].' -1 day'));
							$to=date('Y-m-d',strtotime($dateDuration['dateTo'].' -1 day'));
							
							if(strtotime($lastPoTo) < strtotime($from))
							{
								$nextOngoing['to']=$lastPoTo;//date of previous po(to date)
								$po_structure[]=po_structure($booking_id,$nextOngoing);
								
								//see($po_structure);
								$this->load->model('Po_model');
								$bookings=$this->Po_model->insertGeneratedPo($po_structure);
							}//else{echo "No-1 => LastPoTo= ".$lastPoTo.', From='.$from;}
						}//else{echo "No-2";}
				}//else{echo "No-3";}
		}
		
		function ad2($id)
		{
			$bookingDetails=bookingDetails($id);
			
			/////////////#starts
			$this->load->model('invoice_model');
			$lastInvoice=$this->invoice_model->getLastOngoingInvoiceByStudentId($bookingDetails['student']);
			if(empty($lastInvoice))
			{	echo "Initial - - -- ";
				$lastInvoiceType='initial';
				$lastInvoice=initialInvoiceByShaId($bookingDetails['student']);
				$shaInitialInvoiceWeekDays=shaInitialInvoiceWeekDays($bookingDetails['student']);
				if($shaInitialInvoiceWeekDays>0)
				{
					$InvoiceBookingTo=date('Y-m-d',strtotime($bookingDetails['booking_from'].' + '.$shaInitialInvoiceWeekDays.' days'));
					$InvoiceBookingFrom=$bookingDetails['booking_from'];
				}
			}
			else
			{	echo "Ongoing - - -- ";
				$lastInvoiceType='ongoing';
				$InvoiceBookingTo=$lastInvoice['booking_to'];
				$InvoiceBookingFrom=$lastInvoice['booking_from'];	
			}
			
			if(isset($InvoiceBookingFrom) && isset($InvoiceBookingTo))
			{
				echo $InvoiceBookingFrom.' '.$InvoiceBookingTo.' , booking_to='.$bookingDetails['booking_to'].'<br>';
				$dayDiff=dayDiff($InvoiceBookingFrom,$InvoiceBookingTo);
				
				if($dayDiff<=29 && strtotime($bookingDetails['booking_to'])<strtotime($InvoiceBookingTo))
				{
					echo "Prepone";
					
					if($lastInvoice['status']=='1')//if not paid, if not paid then invoice will always be ongoing coz booking cannot be created with initial invoice unpaid
					{
						if($lastInvoice['moved_to_xero']=='0')//if not moved to xero
						{
							echo " >>> Not moved to xero";
							$this->invoice_model->deleteOngoingInvoice($lastInvoice['id']);
							addNewOngoingInvoice($id);
						}
						else//moved to xero
						{
							echo " >>> Moved to xero";
							$this->invoice_model->deleteOngoingInvoice($lastInvoice['id']);
							deleteXeroInvoice($lastInvoice['invoice_number']);
							addNewOngoingInvoice($id);
						}
					}
					else//if paid, now it can be either Initial or Ongoing
					{
						//edit existing invoice
						if($lastInvoiceType=='initial')
						{echo "<br>Initial invoice updated";
							$this->invoice_model->updateInitialInvItems($bookingDetails,$lastInvoice['id']);
						}
						else
						{echo "<br>Paid Ongoing invoice updated";
							$ongoingFrom=$lastInvoice['booking_from'];
							$ongoingTo=$bookingDetails['booking_to'];
							echo "<br>".$ongoingFrom.' '.$ongoingTo;
							$this->invoice_model->updateOngInvItems($ongoingFrom,$ongoingTo,$bookingDetails['student'],$lastInvoice['id']);
						}
					}
				}
				elseif($dayDiff< 29 && strtotime($bookingDetails['booking_to'])>strtotime($InvoiceBookingTo))	
				{
					echo "-------Postpone";
					
					if($lastInvoiceType=='initial')
					{	echo " >>>> Initial invoice";
						//if initial then it will always be paid, so we will create a new ongoing booing for the extra days
						addNewOngoingInvoice($id);
					}
					else
					{echo "  >>> ongoing invoice ";
						if($lastInvoice['status']=='1')//If not Paid, then we will update the existing ongoing invoice whether it is sent to xero or not
						{
							$this->invoice_model->deleteOngoingInvoice($lastInvoice['id']);
							if($lastInvoice['moved_to_xero']=='1')//moved to xero
							{
								echo " >>> Moved to xero";
								deleteXeroInvoice($lastInvoice['invoice_number']);
							}
							else//if not moved to xero
								echo " >>> Not moved to xero";
						}
						//if Paid, then we will create a new ongoing invoice
						addNewOngoingInvoice($id);
					}
				}
				else
				{
					echo "Nothing";
					if(strtotime($bookingDetails['booking_to'])>strtotime($lastInvoice['booking_to']) && dayDiff(date('Y-m-d'),$lastInvoice['booking_to'])<8)
						echo "<br>Have to create a new ongoing booking that can be skipped";
				}
			}
			else
				echo "No invoice";
				
		}
		
		function adddd($id)
		{
			$data=array();
			$bookingDetails=bookingDetails($id);
			
			/////////////#starts
			$this->load->model('invoice_model');
			$lastInvoice=$this->invoice_model->getLastOngoingInvoiceByStudentId($bookingDetails['student']);
			if(empty($lastInvoice))
			{
				$lastInvoice=initialInvoiceByShaId($bookingDetails['student']);
				$shaInitialInvoiceWeekDays=shaInitialInvoiceWeekDays($bookingDetails['student']);
				$InvoiceBookingTo=date('Y-m-d',strtotime($bookingDetails['booking_from'].' + '.$shaInitialInvoiceWeekDays.' days'));
				$InvoiceBookingFrom=$bookingDetails['booking_from'];
			}
			else
			{
				$InvoiceBookingTo=$lastInvoice['booking_to'];
				$InvoiceBookingFrom=$lastInvoice['booking_from'];	
			}
			
			if(dayDiff($InvoiceBookingFrom,$bookingDetails['booking_to'])<28)
			{
				if($bookingDetails['booking_to']>$InvoiceBookingTo)
					{
						//postpone
						echo "Postpone";
					}
				elseif($bookingDetails['booking_to']<$InvoiceBookingTo)	
					{
						//prepone
						echo "-----Prepone";
					}
				else
					echo "None";
			}
			else
				echo "Nothing happend";
				
			/////////////#ends
		}
		
		
			////////////// For data table server side STARTS
		public function ajax_list()
	{
		$list = $this->booking_model->get_datatables();
		$nameTitleList=nameTitleList();
		$stateList=stateList();
		$roomTypeList=roomTypeList();
		$bookingStatusList=bookingStatusList();
		$accomodationTypeList=accomodationTypeList();
		
		$data = array();
		
		foreach ($list as $booking) 
		{
			
			$host=getHfaOneAppDetails($booking->host);
			$student=getShaOneAppDetails($booking->student);
			$studentThree=getShaThreeAppDetails($booking->student);
			
			$row = array();
			$row['DT_RowId']= "booking_".$booking->id;
			
			//3rd Column: Booking info #STATRS
			 $row3='<strong>Booking id: '.$booking->id.'</strong>';
			 $row3 .='<br />';
			 $row3 .='Duration: ';
			 if($booking->booking_from!='0000-00-00')
			 {
				 $row3 .=date('d M Y',strtotime($booking->booking_from));
					 if($booking->booking_to!='0000-00-00')
						 $row3 .=' - '.date('d M Y',strtotime($booking->booking_to .' +1 day'));
					else	
						$row3 .=' - Not set';
			 }
			 else
			 	$row3 .='Not set';
             $row3 .='<br />';
			 if($student['accomodation_type']!='')
				 $row3 .=$accomodationTypeList[$student['accomodation_type']];
			/* $roomDetails=roomDetails($booking->room);
			 if(!empty($roomDetails))
			 {
	             $row3 .=$roomTypeList[$roomDetails['type']].' room ';
				 if($roomDetails['internal_ensuit']==1)
					 $row3 .='(Internal ensuit)';
			 }*/
            //3rd Column: Booking info #ENDS
			$row[]=$row3;
			
			
			//1st Column: HOST #STATRS
			if($booking->serviceOnlyBooking=='0')
			{
				 $row1='<a href="'.site_url().'hfa/application/'.$booking->host.'#tab-8-4" target="_blank">'.ucfirst($host['lname']).' Family</a>';
				 $row1 .='<br />';
				 $row1 .='<a class="mailto" href="mailto:'.$host['email'].'">'.$host['email'].'</a>'; 
	
				$row1 .='<br>';
			}
			else
				$row1='Not applicable';
				
			if($booking->serviceOnlyBooking=='0')
			{
				$addressForMap='';
				if($host['street']!='')
					$addressForMap .=$host['street'].", ";
				$addressForMap .=ucfirst($host['suburb']).", ".$stateList[$host['state']].", ".$host['postcode'];
				$row1 .= getMapLocationLink($addressForMap);
			}
			//1st Column: HOST #ENDS
			
			$row[]=$row1;
			
			//2nd Column: STUDENT #STATRS
			$studentTitle='';
			 if($student['title']!='')
				$studentTitle=$nameTitleList[$student['title']];
				
			 $row2='<a href="'.site_url().'sha/application/'.$booking->student.'#tab-8-4" target="_blank">'.$studentTitle.' '.ucwords($student['fname'].' '.$student['lname']).'</a>' ;
			 if(age_from_dob($student['dob'])<18){
				 $row2 .=' <span style="color:#e51c23; font-size:11px;">(U18)</span>';
			 }
			 
             $row2 .='<br />';
             $row2 .='<a class="mailto" href="mailto:'.$student['email'].'">'.$student['email'].'</a>'; 
             $row2 .='<br />';
			 if($studentThree['college']!='')
				 $row2 .=$studentThree['college'];
			 if($studentThree['college']!='' && $studentThree['campus']!='')
				  $row2 .=', ';
             if($studentThree['campus']!='')
			 $row2 .=$studentThree['campus'];
			
			if($studentThree['college']!='' || $studentThree['campus']!='')
				$row2 .='<br />';
	
			 if($booking->status=='expected_arrival')
				 if($student['arrival_date']!='0000-00-00'){
				 $row2 .='Arrival date: '.dateFormat($student['arrival_date']);
				 }else{
					  $row2 .='Arrival date: n/a';
				 }
			//2nd Column: STUDENT #ENDS
			$row[]=$row2;
			
			
			
			
			//4th Column: STATUS #STARTS
			$row4='<button class="mt-n mb-xs btn btn-sm btn-label" data-toggle="modal" data-target="#model_ChangeStatusBooking"  onclick="bookingChangeStatusPopContent('.$booking->id.','.'\''.$_POST['booking_status_page'].'\''.');" id="changeStatusBookingEditBtn-'.$booking->id.'">';
				$row4 .='<i class="material-icons font14">edit</i>';
				$row4 .='<span>';
			    if($_POST['booking_status_page']=='all')
					  $row4 .=$bookingStatusList[$booking->status];
				  else
					  $row4 .="Change";
			   $row4 .='</span>';
		 $row4 .='</button>';
		 
		  if(($booking->date_status_changed!='0000-00-00 00:00:00') || ($booking->status=='cancelled') )
		   {
				$row4 .='<br />';
                $row4 .='<span class="statusChangeDate" data-placement="bottom" data-toggle="tooltip"  data-original-title="Status change date">';
					if($booking->status!='cancelled')
						$row4 .=date('d M Y',strtotime($booking->date_status_changed));
					else
						$row4 .=date('d M Y',strtotime($booking->date_cancelled));
				$row4 .='</span>';
			}
			
			if(in_array($_POST['booking_status_page'],array('all','expected_arrival')) && $booking->status!='cancelled' && $booking->date_status_changed =='0000-00-00 00:00:00')
			{
				$row4 .='<br />';
                $row4 .='<span class="statusChangeDate" data-placement="bottom" data-toggle="tooltip"  data-original-title="Booking submitted date">';
					$row4 .=date('d M Y',strtotime($booking->date_added));
				$row4 .='</span>';
			}
         //4th Column: STATUS #ENDS
			$row[] = $row4;
			
			
			//4th Column: Office use #STARTS
			 $row6='';
			 if($student['study_tour_id']!=0)
			 {
				$tourDetail=tourDetail($student['study_tour_id']);
				$row6 .='<a href="javascript:void(0);"  style="margin-right:1px;"><i class="material-icons" data-placement="bottom" data-toggle="tooltip"  data-original-title="Part of a tour group: '.ucwords($tourDetail['group_name']).'">stars</i></a>';
			 }
			 
			 if($booking->status=='expected_arrival' && $student['arrival_date']!='0000-00-00')
			 {
				 //$daysToCheckIn=daydiff(date('Y-m-d'),$booking->booking_from)-1;
				 //$daysToCheckIn=daydiff(date('Y-m-d'),'2018-02-25')-1;
				 $daysToCheckIn=daydiff(date('Y-m-d'),$student['arrival_date'])-1;
				 if($daysToCheckIn<5 && $daysToCheckIn>=0)
				 {
					 $reminderCheckupAdded=ifReminderCheckupAdded($booking->id);
					 if(!$reminderCheckupAdded)
					 {
						 $toolTipText='Student arriving ';
						 if($daysToCheckIn<5)
						 {
							if($daysToCheckIn>0)
								$toolTipText .='in '.$daysToCheckIn.' day'.s($daysToCheckIn);
							if($daysToCheckIn==0)
								$toolTipText .='today';
						 }
						
						$remiderCheckupLink='';
						if($student['study_tour_id']==0)
							$remiderCheckupLink='onclick="bookingCheckupPopContent('.$booking->id.',2,\'add\')" class="bookingCheckupPopContent"';
						 
						$row6 .='<a href="javascript:void(0);" '.$remiderCheckupLink.'><i class="material-icons colorOrange" data-placement="bottom" data-toggle="tooltip"  data-original-title="'.$toolTipText.'">new_releases</i></a>';
					 }
				 }
				 if($daysToCheckIn<0)
					 $row6 .='<a href="javascript:void(0);"><i class="material-icons colorRed" data-placement="bottom" data-toggle="tooltip"  data-original-title="Arrival check" onclick="$(\'#changeStatusBookingEditBtn-'.$booking->id.'\').trigger(\'click\');">new_releases</i></a>';
			 }
			/* if(potoxero($booking->id)>0)
				 $matchgreenpo="matchStatusGreen";
				 else
					 $matchgreenpo='matchStatusGrey';
				 if(invoicetoxero($booking->student)>0)
				 $matchgreenin="matchStatusGreen";
				 else
					 $matchgreenin='matchStatusGrey';*/
			
			$targetInitialInvoice=$targetFirstPo='target="_blank"';		 
			$checkIfFirstPoMovedToXero=checkIfFirstPoMovedToXero($booking->id);
			
			$matchgreenpo='matchStatusGrey';
			if($checkIfFirstPoMovedToXero['id']!=0)
			{
				if($checkIfFirstPoMovedToXero['moved_to_xero']=='1')
				{
					$matchgreenpo="matchStatusGreen";
					$firstPoToolTip='First PO moved to xero';
				}
				else
					$firstPoToolTip='First PO waiting to be moved to xero';
				$firstPoLink=site_url().'purchase_orders/view/'.$checkIfFirstPoMovedToXero['id'];	
			}
			else
			{
				$firstPoLink='javascript:void(0);';	
				$firstPoToolTip='First PO not generated';
				$targetFirstPo='';
			}
			
			$checkIfInitialinvoiceMovedToXero=checkIfInitialinvoiceMovedToXero($booking->student,$student['study_tour_id']);
			
			$matchgreenin='matchStatusGrey';
			if($checkIfInitialinvoiceMovedToXero['id']!=0)
			{
				if($checkIfInitialinvoiceMovedToXero['moved_to_xero']=='1')
				{
					$matchgreenin="matchStatusGreen";
					$initialInvoiceToolTip='Initial invoice moved to xero';
				}
				else
					$initialInvoiceToolTip='Initial invoice waiting to be moved to xero';
				$initialInvoiceLink=site_url().'invoice/view_initial/'.$checkIfInitialinvoiceMovedToXero['id'];	
			}
			else
			{
				$initialInvoiceLink='javascript:void(0);';	
				$initialInvoiceToolTip='Initial invoice not generated';
				$targetInitialInvoice='';
			}
					 
			$row6.='<a href="'.$initialInvoiceLink.'" '.$targetInitialInvoice.'><i class="material-icons  '.$matchgreenin.' " data-placement="bottom" data-toggle="tooltip"  data-original-title="'.$initialInvoiceToolTip.'">monetization_on</i></a>';
			$row6.=' <a href="'.$firstPoLink.'" '.$targetFirstPo.'><i class="material-icons '.$matchgreenpo.'"  data-placement="bottom" data-toggle="tooltip"  data-original-title="'.$firstPoToolTip.'">receipt</i></a>';
			$row6 .='';
			//4th Column: Office use #ENDS
			$row[] = $row6;
			
			//5th Column: ACTIONS #STARTS
			$row5='<div class="btn-group dropdown table-actions">';
            	$row5 .='<button class="btn btn-sm btn-midnightblue dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="true">';
					$row5 .='<i class="colorBlue material-icons">more_horiz</i>';
					$row5 .='<div class="ripple-container"></div>';
				$row5 .='</button>';
				$row5 .='<ul class="dropdown-menu" role="menu">';
					   if($booking->serviceOnlyBooking=='0')	
						{
						  $row5 .='<li>';
						  $row5 .='<a href="javasctipt:;" onclick="editBookingPopContent('.$booking->id.')" data-toggle="modal" data-target="#model_editBooking"><i class="font16 material-icons">edit</i>&nbsp;&nbsp;Edit</a>';
						  $row5 .='</li>';
						}
					  $row5 .='<li>';
					  $row5 .='<a target="_blank" href="'.site_url().'booking/view/'.$booking->id.'"><i class="font16 material-icons">remove_red_eye</i>&nbsp;&nbsp;View</a>';
					  $row5 .='</li>';
					  if(in_array($booking->status,array('expected_arrival','on_hold','cancelled')))
					  {
					  	$row5 .='<li>';
					  	$row5 .='<a href="javascript:;" class="bookingDelete" id="bookingDelete-'.$booking->id.'"><i class="font16 material-icons">delete</i>&nbsp;&nbsp;Delete</a>';
					  	$row5 .='</li>';
					  }
				 $row5 .='</ul>';
             $row5 .='</div>';
			//5th Column: ACTIONS #ENDS
			
			$row[] = $row5;
			$data[] = $row;
		}
		
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->booking_model->count_all(),
						"recordsFiltered" => $this->booking_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	////////////// For data table server side ENDS	
	
	function deleteBooking()
	{
		if(isset($_POST['id']))
			{
				$this->booking_model->deleteBooking($_POST['id']);
				echo "done";
			}
	}
	
	function changeStatusPopContent($id,$pageStatus)
		{
			 $bookingDetails=bookingDetails($id);
			 $bookingDetails['pageStatus']=$pageStatus;
			 
			 $shaOne=getshaOneAppDetails($bookingDetails['student']);
			 if($shaOne['study_tour_id']!=0 && !in_array($bookingDetails['status'], array('moved_out','on_hold','progressive','cancelled')))
			 {
				 $tourDetails=tourDetail($shaOne['study_tour_id']);
				 $bookingDetails['studyTourBookings']=$this->booking_model->getBookingsByTourForChangeStatusWarnings($tourDetails['id'],$id);
			 }
			 $bookingDetails['booking_id']=$id;
			 $arivalCheckup=getArrivalCheckupInfoByBookingId($id);
			 if(!empty($arivalCheckup))
				$bookingDetails['checkup']=$arivalCheckup;
			 $this->load->view('system/booking/changeStatusForm',$bookingDetails);
		}
		
	function changeStatus()
		{
			$data=$_POST;
			if($data['bookingChangeStatus_id']!='')
			{//see($data);
				$this->booking_model->changeStatus($data);
				echo 'done';
			}
		}
	
	function updateClientProductsBookingPop($client)
	{
		$data['products']=clientProductsList($client,date('Y'));
		$this->load->view('system/booking/placeBookingFormProducts',$data);
	}
	
	function noticeGetBookingEnd()
	{
		$data=$_POST;
		$return=array();
		$notice=normalToMysqlDate($data['notice']);
		$booking_end=normalToMysqlDate($data['booking_end']);
		
		if($data['booking_end']==''){//echo 11;
			$return['booking_end']=date('d/m/Y',strtotime($notice.' + 2 weeks'));}
		else
		{
			if(dayDiff($notice,$booking_end)<14){//echo 33;
				$return['booking_end']=date('d/m/Y',strtotime($notice.' + 2 weeks'));}
		}
		
		echo json_encode($return);	
	}
	
	function moveOutRules()
	{
		//see($_POST);
		$data=$_POST;
		$return=$data;
		
		$notice=normalToMysqlDate($data['notice']);
		$booking_end=normalToMysqlDate($data['booking_end']);
		$booking_end_old=normalToMysqlDate($data['booking_end_old']);
		$move_out=normalToMysqlDate($data['move_out']);
		
		if($data['booking_end_old']=='')
		{
			  if($data['move_out']=='')
			  {
				  //it wont come here in this case
			  }
			  else
			  {
				  if(daydiff($notice,$move_out)>=14)
					  $return['booking_end']=$data['move_out'];
				  else
					  $return['booking_end']=date('d/m/Y',strtotime($notice.' +2 weeks'));
			  }
		}
		else
		{
			if(daydiff($notice,$move_out)>=14)
				$return['booking_end']=$data['move_out'];
			else
				$return['booking_end']=date('d/m/Y',strtotime($notice.' + 2 weeks'));
		}
		//see($return);
		echo json_encode($return);	
	}		
	
	function booking_endDate_history($id)
	{
		$this->load->model('admin_model');
		$data['history']=$this->booking_model->booking_endDate_history($id);
		$this->load->view('system/booking/booking_endDate_history',$data);
	}
	
	function view($id)
	{
			if(checkLogin())
			{
				$data['page']='bookings-view';
				$data['booking']=bookingDetails($id);
				if(empty($data['booking']))
					header('location:'.site_url().'booking/');
				else
				{	
					recentActionsAddData('booking',$id,'view');
					$data['student']=getShaOneAppDetails($data['booking']['student']);
					$data['student']['two']=getShaTwoAppDetails($data['booking']['student']);
					$data['student']['three']=getShaThreeAppDetails($data['booking']['student']);
					$data['host']=getHfaOneAppDetails($data['booking']['host']);
					if(!empty($data['host']))
						$data['host']['two']=getHfaTwoAppDetails($data['booking']['host']);
					$data['profilelist']=$this->booking_model->getallprofilechecklist($id);
					$data['pos']=$this->booking_model->posByBooking($id);
					$data['invoices']=$this->booking_model->invoicesByBooking($id);
					$data['incidents']=$this->booking_model->incidentsByBooking($id);
					$data['feedbacks']=$this->booking_model->feedbacksByBooking($id);
					$data['checkups']=$this->booking_model->checkupsByBooking($id);
					$data['holidays']=$this->booking_model->holidaysByBooking($id);
					if(!empty($data['host']))
					{
						$this->load->model('hfa_model');
						$data['transport']=$this->hfa_model->transportInfoByHfaId($data['host']['id']);
					}
					$this->load->view('system/header',$data);
					if($data['booking']['serviceOnlyBooking']=='0')
						$this->load->view('system/booking/view');
					else
						$this->load->view('system/booking/viewServiceOnlyBooking');	
					$this->load->view('system/footer');
				}
			}
			else
				redirectToLogin();
	}
	
	function filters()
	{
		 $this->load->view('system/booking/filters');
	}
	function sortfilters()
	{
		 $this->load->view('system/booking/sortfilters');
	}
	function selectApuCompany()
	{
		$data=$_POST;
		if(!empty($data))
			$this->booking_model->selectApuCompany($data);
	}
	function selectdropApuCompany()
	{
		$data=$_POST;
		if(!empty($data))
			$this->booking_model->selectdropApuCompany($data);
	}
	function selectApuOption()
	{
		$data=$_POST;
		if(!empty($data))
		{
			$this->booking_model->selectApuOption($data);
			$this->session->set_flashdata('apuOptionSelected','yes');
		}
	}
	
	function apuUpdate()
	{
		if(checkLogin())
			{
				$data=$_POST;
				if($data['sha_id']!='')
					{
						$this->booking_model->selectApuOption($data);
						echo 'done';
					}
			}
			else
				echo "LO";
	}
	
	function apuStUpdate()
	{
		if(checkLogin())
			{
				$data=$_POST;
				if($data['sha_id']!='')
					{
						$this->booking_model->selectApuStOption($data);
						echo 'done';
					}
			}
			else
				echo "LO";
	}
	
		function apudropUpdate()
	{
		if(checkLogin())
			{
				$data=$_POST;
				if($data['sha_id']!='')
					{
						$this->booking_model->selectdropApuOption($data);
						echo 'done';
					}
			}
			else
				echo "LO";
	}
	
	function arrivalDateUpdate()
	{
		if(checkLogin())
			{
				$data=$_POST;
				if($data['sha_id']!='')
					{
						$this->booking_model->arrivalDateUpdate($data);
						echo 'done';
					}
			}
			else
				echo "LO";
	}
	
	function departureDateUpdate()
	{
		if(checkLogin())
			{
				$data=$_POST;
				if($data['sha_id']!='')
					{
						$this->booking_model->departureDateUpdate($data);
						echo 'done';
					}
			}
			else
				echo "LO";
	}
	
	function departureTimeUpdate()
	{
		if(checkLogin())
			{
				$data=$_POST;
				if($data['sha_id']!='')
					{
						$this->booking_model->departureTimeUpdate($data);
						echo 'done';
					}
			}
			else
				echo "LO";
	}
	
	function arrivalTimeUpdate()
	{
		if(checkLogin())
			{
				$data=$_POST;
				if($data['sha_id']!='')
					{
						$this->booking_model->arrivalTimeUpdate($data);
						echo 'done';
					}
			}
			else
				echo "LO";
	}
	
	function airportCarrierUpdate()
	{
		if(checkLogin())
			{
				$data=$_POST;
				if($data['sha_id']!='')
					{
						$this->booking_model->airportCarrierUpdate($data);
						echo 'done';
					}
			}
			else
				echo "LO";
	}
	
	function airportdropCarrierUpdate()
	{
		if(checkLogin())
			{
				$data=$_POST;
				if($data['sha_id']!='')
					{
						$this->booking_model->airportdropCarrierUpdate($data);
						echo 'done';
					}
			}
			else
				echo "LO";
	}
	
		function airportdropFlightNoUpdate()
	{
		if(checkLogin())
			{
				$data=$_POST;
				if($data['sha_id']!='')
					{
						$this->booking_model->airportdropFlightNoUpdate($data);
						echo 'done';
					}
			}
			else
				echo "LO";
	}
	
	function airportFlightNoUpdate()
	{
		if(checkLogin())
			{
				$data=$_POST;
				if($data['sha_id']!='')
					{
						$this->booking_model->airportFlightNoUpdate($data);
						echo 'done';
					}
			}
			else
				echo "LO";
	}
	
	function updateBookingNotes()
	{
		if(checkLogin())
			{
				$data=$_POST;
				if($data['booking_id']!='')
					{
						$this->booking_model->updateBookingNotes($data);
						echo 'done';
					}
			}
			else
				echo "LO";
	}
	function getprofilechecklistform(){
		$this->load->model('account_model');
		$data=$_POST;
	//	if(!empty($data['eid'])){
			$data['pinfo']=$this->booking_model->getchecklistprofileinfo($data['id'],$data['type']);
			

	//	}
		$data['employees']=$this->account_model->employeeList();
		$this->load->view('system/booking/checklistpopupform',$data);
		

	}
	function saveprofilechecklist(){
		$data1=$_POST;
		
		if(checkLogin())
			{
				$data['emp_id']=$data1['employee-account'];
				$data['booking_id']=$data1['bookid'];
				$data['type']=$data1['type'];
				$data['ckecklist_date']=$data1['profilechecklistdate'];
				$cot=$this->booking_model->getchecklistinfo($data1['type'],$data1['bookid']);
				if($cot>0){
					$updata['emp_id']=$data1['employee-account'];
					$updata['ckecklist_date']=$data1['profilechecklistdate'];
					
				$this->booking_model->updatechecklistinfo($updata,$data1['bookid'],$data1['type']);
				}else{
				$this->booking_model->savechecklistinfo($data);
				}
						echo $data['type'];
			}else
				echo "LO";
		

	}
	function globalsearch(){
		$data1=$_POST;
		//see($data1);
		if(checkLogin())
			{
				
			$res=$this->booking_model->globalsearch($data1['type'],$data1['val']);
			$res1=$this->booking_model->globalsearch2($data1['type'],$data1['val']);
			
			echo json_encode(array("type"=>$data1['type'],"meth"=>$res));
			//echo json_encode(array("type"=>$data1['type'],"meth"=>$res1));
				 exit;
			
				
			}
			
			
	}
	
	function searchall(){
		//echo $_GET['value']; die;
				$data['page']='Search All';
				if($_GET['value']!=''){
				$tmp['result']=$this->booking_model->searchall($_GET['value']);
				$tmp['result1']=$this->booking_model->searchall2($_GET['value']);
				}
				$this->load->view('system/header',$data);
			$this->load->view('system/booking/Searchall',$tmp);
			$this->load->view('system/footer');
			}
			
	
		
		function shaNameByIdForCreateBooking($id)
		{
			/*$data['formOne']=getShaOneAppDetails($id);
			if($data['formOne']['client']!='')
				$client=clientDetail($data['formOne']['client']);
			else
				$client=array();	
			
			$booking=bookingByShaId($id);
			if(!empty($data['formOne']) && $data['formOne']['study_tour_id']==0 && empty($booking) && !empty($client) && $client['group_invoice']=='0')
				echo $data['formOne']['fname'].' '.$data['formOne']['lname'];
			else
				echo "notFound";*/	
				
			$data['formOne']=getShaOneAppDetails($id);
			$data['formTwo']=getShaTwoAppDetails($id);
			$age=age_from_dob($data['formOne']['dob']);
			if($data['formOne']['client']!='')
				$client=clientDetail($data['formOne']['client']);
			else
				$client=array();	
			$return=array();
			$booking=bookingByShaId($id);
			
			if(!empty($data['formOne']) && $data['formOne']['step']==4 && $data['formOne']['study_tour_id']==0 && empty($booking) && !empty($client) && $client['group_invoice']=='0' && ($age > 18 || $data['formTwo']['guardianship']=='' || ($data['formTwo']['guardianship']=='1' && $data['formTwo']['guardianship_startDate']!='0000-00-00' && $data['formTwo']['guardianship_endDate']!='0000-00-00')))
			{
				$return['shaId']=$id;
				$return['name']=$data['formOne']['fname'].' '.$data['formOne']['lname'];
			}
			else
				$return['notFound']="1";
			echo json_encode($return);	
		}
		
		function shaNameByBookingIdForCreateBooking($id)
		{
			/*$bookingDetails=bookingDetails($id);
			if(!empty($bookingDetails))
			{
				$data['formOne']=getShaOneAppDetails($bookingDetails['student']);
				if(!empty($data['formOne']) && $data['formOne']['study_tour_id']==0)
					echo $data['formOne']['fname'].' '.$data['formOne']['lname'];
				else
					echo "notFound";	
			}
			else
				echo "notFound";*/
				
				
			$bookingDetails=bookingDetails($id);
			$return=array();
			if(!empty($bookingDetails))
			{
				$data['formOne']=getShaOneAppDetails($bookingDetails['student']);
				if(!empty($data['formOne']) /*&& $data['formOne']['study_tour_id']==0*/)
				{
					$return['shaId']=$bookingDetails['student'];
					if($data['formOne']['study_tour_id']==0)
						$return['studyTourBooking']='0';
					else
						$return['studyTourBooking']='1';	
					$return['name'] =$data['formOne']['fname'].' '.$data['formOne']['lname'];
					$return['newBookingFrom']='';
					if($bookingDetails['booking_to']!='0000-00-00')
						$return['newBookingFrom']=date('d/m/Y',strtotime($bookingDetails['booking_to'].' + 1 day'));
				}
				else
					$return['notFound']="1";
			}
			else
				$return['notFound']="1";
			echo json_encode($return);
		}
		
		function hfaNameByIdForCreateBooking($id)
		{
			$data['formOne']=getHfaOneAppDetails($id);
			$data['formTwo']=getHfaTwoAppDetails($id);
			$return=array();
			if(!empty($data['formOne']) && $data['formOne']['step']==5)
			{
				//$roomTypeList=roomTypeList();
				$return['id']=$id;
				$return['name']=$data['formOne']['fname'].' '.$data['formOne']['lname'];
				/*$return['roomsHtml']='<option value="">Select Room</option>';
				$roomNo=0;
				foreach($data['formTwo']['bedroomDetails'] as $bed)
				{
					$roomNo++;
					$return['roomsHtml'] .='<option value="'.$bed['id'].'">Room '.$roomNo .' ('.$roomTypeList[$bed['type']].')</option>';
				}*/
			}
			else
				$return['notFound']="1";
			echo json_encode($return);
		}
		
		function cBP()
		{
			if(checkLogin())
			{
				$data=$_POST;
				$return=$this->booking_model->cBP($data);
			}
			else
				$return['result']="LO";
			
			echo  json_encode($return);
		}
		
		function cBF()
		{
			$data=$_POST;
			//$this->booking_model->cBF($data);
			echo 'done';
		}
		
		function cD($id)
		{
			echo $this->booking_model->createShaCopy($id);
		}
		function savebookinghliday(){
			$data=$_POST;
			 $this->booking_model->savebookinghliday($data);
			 echo 1;
			 exit;
			
		}
		
		function generatePoBookingOption()
		{
			if(checkLogin())
			{
				$data=$_POST;
				$this->booking_model->generatePoBookingOption($data);
			}
			else
				echo "LO";
		}
		
		function getRoomListForCreateBooking()
		{
			if(checkLogin())
			{
				$return['roomsHtml']='<option value="">Select Room</option>';
				$data=$_POST;
				if($data['host']!='' && $data['from']!='' && $data['to']!='' && $data['product']!='')
				{
					$this->load->model('booking_model');
					$beds=$this->booking_model->getRoomListForCreateBooking($data);
					$formTwo=getHfaTwoAppDetails($data['host']);
					
					$roomTypeList=roomTypeList();
					foreach($beds as $bed)
					{
						$roomNo=1;
						foreach($formTwo['bedroomDetails'] as $bedroom)
						{
							if($bedroom['id']==$bed['id'])
								break;
							$roomNo++;	
						}
						$return['roomsHtml'] .='<option value="'.$bed['id'].'">Room '.$roomNo .' ('.$roomTypeList[$bed['type']].')</option>';
					}
				}
			}
			else
				$return['result']="LO";
			
			echo  json_encode($return);
		}
		
	
		
		function changeHomestay()
		{
			$data['page']='bookings-changeHomestay';

			//$data['booking_status_page']=$status;
			//see($data['list']);exit;
			$this->load->view('system/header',$data);
			$this->load->view('system/booking/changeHomestay');
			$this->load->view('system/footer');
		}
		
		function changeHomestaySubmit()
		{
			if(checkLogin())
			{
				$data=$_POST;
				$result=$this->booking_model->changeHomestaySubmit($data);
				foreach($result as $rK=>$rV)
					$return[$rK]=$rV;
			}
			else
				$return['result']="LO";
				
			echo  json_encode($return);
		}
		
		function changeHomestayGetRooms()
		{
			$data=$_POST;
			
			if($data['accomodation_type']!='')
			{
				$this->load->model('hfa_model');
				$bedrooms=$this->hfa_model->getHfaTwoAppDetailsBedrooms($data['host']);
				
				$studentBookingDates['from']=normalToMysqlDate($data['from']);
				if($data['to']!='')
					$studentBookingDates['to']=normalToMysqlDate($data['to']);
				else
					$studentBookingDates['to']='';	
				
				$data['roomType']=roomTypeByAccomodationType($data['accomodation_type']);
				$data['studentBookingDates']=$studentBookingDates;
				$rooms=array();
				/*foreach($bedrooms as $room)
				{
					if(!checkIfBedBooked($room['id'],$data['accomodation_type'],$studentBookingDates))
					{
						if(in_array($room['type'],$roomType))
							$rooms[]=$room;
					}
				}
						 
				$data['rooms']=$rooms;*/
				$data['rooms']=$bedrooms;
				$roomHtml=$this->load->view('system/booking/changeHomestayGetRooms',$data,true);
				echo $roomHtml;
			}
			else
				echo '';
		}
		
	function addCH()
		{
			if(checkLogin())
			{
				$data=$_POST;
				if($data['placeBooking_startDate']!='' && $data['placeBooking_endDate']!='')
					{
						if(strtotime(normalToMysqlDate($data['placeBooking_startDate'])) > strtotime(normalToMysqlDate($data['placeBooking_endDate'])))
							$return['result']='properDate';
						else	
						{
							$result=$this->booking_model->changeHomestaySubmitCH($data);
							foreach($result as $rK=>$rV)
								$return[$rK]=$rV;
						}
					}
					else	
					{
							$result=$this->booking_model->changeHomestaySubmitCH($data);
							foreach($result as $rK=>$rV)
								$return[$rK]=$rV;
					}
			}
			else
				$return['result']="LO";
				
			echo  json_encode($return);
		}
	
	function addNewIncident()
	{
		if(checkLogin())
			{
				$data=$_POST;
				$return['incident_id']=$this->booking_model->addNewIncident($data);
				$res['incidents']=$this->booking_model->incidentsByBooking($data['bookingIncident_bookingId']);
				$return['incidents']=$this->load->view('system/booking/incidents',$res,true);
			}
		else
			$return['logout']="LO";
		echo json_encode($return);	
	}
	 
	 function bookingIncidentDoc_upload()
		{
			if($_FILES['file']['name']!= "")
				  {
						$path="./static/uploads/bookingIncidentDoc"; 
						$t1=time();
						$imagename=$t1.$_FILES['file']['name'];		
						move_uploaded_file($_FILES['file']['tmp_name'],$path.'/'.$imagename);
						$incident_id=$_POST['bookingIncident_idSecond'];
						$this->booking_model->bookingIncidentDoc_upload($incident_id,$imagename);
		
						$res['incidents']=$this->booking_model->incidentsByBooking($_POST['bookingIncident_bookingId']);
						$return['incidents']=$this->load->view('system/booking/incidents',$res,true);
						
						$resDoc['incident_documents']=bookingIncidentDocs($incident_id);
						$return['incident_documents']=$this->load->view('system/booking/incidentdocuments',$resDoc,true);
						echo json_encode($return);
					}
					
		}
	
	function addNewIncidentFollowUp()
	{
		if(checkLogin())
			{
				$data=$_POST;
				$this->booking_model->addNewIncidentFollowUp($data);
				$res['incidents']=$this->booking_model->incidentsByBooking($data['bookingIncident_bookingId']);
				$this->load->view('system/booking/incidents',$res);
			}
		else
			echo "LO";
	}
	
	function incidentFollowUpUpdate()
	{
		if(checkLogin())
			{
				$data=$_POST;
				$followUp=$this->booking_model->incidentFollowUpUpdate($data);
				echo viewFollowUpHeader($followUp);
			}
		else
			echo "LO";
	}
		
	function bookingIncident_delete($id,$bookingId)
	{
		if(checkLogin())
			{
					$this->booking_model->bookingIncident_delete($id);
					$res['incidents']=$this->booking_model->incidentsByBooking($bookingId);
					$this->load->view('system/booking/incidents',$res);
			}
		else
			echo "LO";
	}
	
	function bookingIncidentPopContent($id,$type)
	{
		if(checkLogin())
			{
				$res=array();
				if($type=='edit')
				{
					$res['incident']=$this->booking_model->bookingIncident_details($id);
					$res['booking_id']=$res['incident']['booking_id'];
					$resDoc['incident_documents']=bookingIncidentDocs($id);
					$return['incident_documents']=$this->load->view('system/booking/incidentdocuments',$resDoc,true);
				}
				else
					$res['booking_id']=$id;
				$return['content']=$this->load->view('system/booking/incidentPopContent',$res,true);
			}
		else
			$return['logout']="LO";
		echo json_encode($return);	
	}
		
	function deleteBookingIncidentDoc()
		{
			if(checkLogin())
			{
				if(isset($_POST['id']))
				{
					$bookingId=$this->booking_model->deleteBookingIncidentDoc($_POST['id']);
					if($bookingId!='0')
					{
						$res['incidents']=$this->booking_model->incidentsByBooking($bookingId);
						$this->load->view('system/booking/incidents',$res);
					}
				}
			}
			else
				echo "LO";
		}
	
	function bookingIncidentFollowUpPopContent($id)
	{
		if(checkLogin())
			{
				$res['id']=$id;
				$res['incident']=$this->booking_model->bookingIncident_details($id);
				$this->load->view('system/booking/incidentFollowUpPopContent',$res);
			}
		else
			echo "LO";
	}
	
	function bookingIncidentViewFollowUpPopContent($id)
	{
		if(checkLogin())
			{
				$res['followUps']=$this->booking_model->incidentFollowUps($id);
				$res['incident_id']=$id;
				$this->load->view('system/booking/incidentViewFollowUpPopContent',$res);
			}
		else
			echo "LO";
	}
		
	function bookingFeedback_delete($id,$bookingId)
	{
		if(checkLogin())
			{
				if(userAuthorisations('bookingFeedback_delete'))
				{
					$this->booking_model->bookingFeedback_delete($id);
					$res['feedbacks']=$this->booking_model->feedbacksByBooking($bookingId);
					$this->load->view('system/booking/feedbacks',$res);
				}
			}
		else
			echo "LO";
	}
	
	function bookingCheckupPopContent($id,$type)
	{
		if(checkLogin())
			{
				$res=array();
				if($type=='edit')
					$res['checkup']=$this->booking_model->bookingCheckup_details($id);
				else
					$res['booking_id']=$id;
				$this->load->view('system/booking/checkupPopContent',$res);
			}
		else
			echo "LO";
	}
	
	function addNewCheckup()
	{
		if(checkLogin())
			{
				$data=$_POST;
				$this->booking_model->addNewCheckup($data);
				$res['checkups']=$this->booking_model->checkupsByBooking($data['bookingCheckup_bookingId']);
				$this->load->view('system/booking/checkups',$res);
			}
		else
			echo "LO";
	}
		
	function bookingCheckup_delete($id,$bookingId)
	{
		if(checkLogin())
			{
				if(userAuthorisations('bookingCheckup_delete'))
				{
					$this->booking_model->bookingCheckup_delete($id);
					$res['checkups']=$this->booking_model->checkupsByBooking($bookingId);
					$this->load->view('system/booking/checkups',$res);
				}
			}
		else
			echo "LO";
	}
	
	function bookingHolidayPopContent($id,$type)
	{
		if(checkLogin())
			{
				$res=array();
				if($type=='edit')
					$res['holiday']=$this->booking_model->bookingHoliday_details($id);
				else
					$res['booking_id']=$id;
				$this->load->view('system/booking/holidaysPopContent',$res);
			}
		else
			echo "LO";
	}
	
	function addNewHoliday()
	{
		if(checkLogin())
			{
				$data=$_POST;
				$return=$this->booking_model->addNewHoliday($data);
				if($return['result']=='done')
				{
					$res['holidays']=$this->booking_model->holidaysByBooking($data['bookingHoliday_bookingId']);
					$return['holidays']=$this->load->view('system/booking/holidays',$res,true);
				}
			}
		else
			$return['result']="LO";
			
			echo  json_encode($return);
	}
		
	function bookingHoliday_delete($id,$bookingId)
	{
		if(checkLogin())
			{
				if(userAuthorisations('bookingHoliday_delete'))
				{
					$this->booking_model->bookingHoliday_delete($id);
					$res['holidays']=$this->booking_model->holidaysByBooking($bookingId);
					$this->load->view('system/booking/holidays',$res);
				}
			}
		else
			echo "LO";
	}
		
	  function placeBookingServicePopContentValidate($student_id)
	  {
		  $res='fine';
		  $studentOne=getShaOneAppDetails($student_id);
		  if($studentOne['accomodation_type']=='6' && $studentOne['booking_from']=='0000-00-00')
			 $res="transfer";
		  elseif($studentOne['accomodation_type']=='7' )
		  {
				$studentTwo=getShaTwoAppDetails($student_id); 
				if($studentTwo['guardianship']!='1' || $studentTwo['guardianship_startDate']=='0000-00-00' || $studentTwo['guardianship_endDate']=='0000-00-00')
					$res="guardianship";
		  }
		  echo $res;
	  }
		
	 function placeBookingServicePopContent($student_id)
	  {
		  $data=array();
		  $data['student']=$student_id;
		  $data['studentOne']=getShaOneAppDetails($student_id);
		  $this->load->view('system/booking/placeBookingFormService',$data);
	  }
	  
	  function addBookingService()
	  {
			if(checkLogin())
			{
				$data=$_POST;	
				$this->booking_model->addBookingService($data);
			}
			else
				echo "LO";
	 }
	
	function CGDocSent_submit()
	{
		if(checkLogin())
			{
				$data=$_POST;
				$return=$this->booking_model->CGDocSent_submit($data);
				$data['booking']=bookingDetails($data['bookCGDocSent_bookingId']);
				$this->load->view('system/booking/CGDocBoxBtns',$data);
			}
		else
			echo "LO";
	}
	
	function CGDocSent_unsend()
	{
		if(checkLogin())
			{
				$data=$_POST;
				$return=$this->booking_model->CGDocSent_unsend($data);
				$data['booking']=bookingDetails($data['booking_id']);
				$this->load->view('system/booking/CGDocBoxBtns',$data);
			}
		else
			echo "LO";
	}
	
	function CGDocRec_submit()
	{
		if(checkLogin())
			{
				$data=$_POST;
				
				$path="./static/uploads/bookingCGDoc/unsaved"; 
				$pathNew="./static/uploads/bookingCGDoc"; 
				foreach($data['bookCGDocRec_images'] as $doc)
				{
					$imagename=$doc;		
					$filePath=$path.'/'.$imagename;
					$filePathNew=$pathNew.'/'.$imagename;
					rename($filePath, $filePathNew);
				}
				
				$return=$this->booking_model->CGDocRec_submit($data);
				$data['booking']=bookingDetails($data['bookCGDocRec_bookingId']);
				$this->load->view('system/booking/CGDocBoxBtns',$data);
			}
		else
			echo "LO";
	}
	 
	 function bookingCGDocUpload()
		{
			if($_FILES['file']['name']!= "")
				  {
						$path="./static/uploads/bookingCGDoc/unsaved"; 
						$t1=time();
						$imagename=$t1.$_FILES['file']['name'];		
						move_uploaded_file($_FILES['file']['tmp_name'],$path.'/'.$imagename);
						echo $imagename;
					}
		}
		
	function cgDocListHtml()	
		{
			$data=$_POST;
			$cgDocList['cgDocList']=$this->booking_model->cgDocList($data['bookingId']);
			$this->load->view('system/booking/CGDocBoxDocs',$cgDocList);
		}
		
	function cgDocListTempHtml()	
		{
			$data['docsTemp']=$_POST;
			$this->load->view('system/booking/CGDocBoxTempDocs',$data);
		}
	
	function deleteBookingCGDoc()
	{
		$data=$_POST;
		$this->booking_model->deleteBookingCGDoc($data);
	}	
	
	function updateTransportInfo()
	{
		$data=$_POST;
		$this->booking_model->updateTransportInfo($data);
	}
	
	function paymentHoldSubmit()
	{
		if(checkLogin())
			{
				$data=$_POST;
				
				$this->booking_model->paymentHoldSubmit($data);
				$data['booking']['id']=$data['bookingHoldPos_booking_id'];
				$data['booking']['hold_payment']='1';
				$this->load->view('system/booking/holdPaymentBtns',$data);
			}
		else
			echo "LO";
	}
	
	function booking_unholdPayments($bid,$holdId)
	{
		if(checkLogin())
			{
				$data=$_POST;
				
				$this->booking_model->booking_unholdPayments($bid,$holdId);
				$data['booking']['id']=$bid;
				$data['booking']['hold_payment']='0';
				$this->load->view('system/booking/holdPaymentBtns',$data);
			}
		else
			echo "LO";
	}
	
	function bookingHoldPayment_delete($bid,$holdId)
	{
		if(checkLogin())
			{
				if(userAuthorisations('bookingHoldPayment_delete'))
				{
					$data=$_POST;
					
					$this->booking_model->bookingHoldPayment_delete($holdId);
					$data['booking']['id']=$bid;
					$bookingDetails=bookingDetails($bid);
					$data['booking']['hold_payment']=$bookingDetails['hold_payment'];
					$this->load->view('system/booking/holdPaymentBtns',$data);
				}
			}
		else
			echo "LO";
	}
}