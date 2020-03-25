<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {
	
	function hfa()
	{
			if(checkLogin())
			{
				recentActionsAddData('report','hfa','view');
				$data['page']='reports-hfa';
				$this->load->view('system/header',$data);
				$this->load->view('system/reports/hfa_report');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
	}
	
	function hfa_submit()
	{
		$data=$_POST;
		
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('test worksheet');
		
		$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
				'font'=>array(
				'name'      =>  'Arial',
				'size'      =>  10,
			)
		));
		
		$fields=array();
		$fieldIndex=$lastIndex='A';
		
		foreach($data['HR_field'] as $hr_field)
		{
			$fields[$fieldIndex]=$hr_field;
			$lastIndex=$fieldIndex;
			$fieldIndex++;
		}
		
		
	   foreach ($fields as $fieldK=>$field)
	   	$this->excel->getActiveSheet()->getColumnDimension($fieldK)->setAutosize(true);
	   
		
	  $x_start=1;
	  foreach($fields as $k=>$v)
	  {
		  $colHeading=ucwords($v);
		  if($v=='post_code')
			$colHeading='Postcode';		
			
		  $this->excel->getActiveSheet()->setCellValue($k.$x_start, $colHeading);
	  }
		  
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getFont()->setSize(10)->setBold(true);  
		
		$x=$x_start+1;
		
	$this->load->model('report_model');
	$families=$this->report_model->hfaListForReport($data);
	
	foreach($families as $hfa)
	{
		foreach($fields as $k=>$v)
		{
			$value='';
			if($v=='id')
				$value=$hfa['id'];
			elseif($v=='name')
				$value=$hfa['fname'].' '.$hfa['lname'];		
			elseif($v=='address')
				$value=$hfa['street'];		
			elseif($v=='suburb')
				$value=$hfa['suburb'];		
			elseif($v=='state')
			{
				$stateList=stateList();
				if(isset($stateList[$hfa['state']]))
					$value=$stateList[$hfa['state']];
				else	
					$value=$hfa['state'];
			}
			elseif($v=='post_code')
				$value=$hfa['postcode'];		
			elseif($v=='mobile')
				$value=$hfa['mobile'];		
			elseif($v=='email')
				$value=$hfa['email'];
			
			elseif($v=='insurance' || $v=='wwcc' || $v=='occupation')
			{
				$formThree=getHfaThreeAppDetails($hfa['id']);
				if(!empty($formThree))
				{
					if($v=='insurance')
					{
						if($formThree['insurance']=="1")
							{
								$value='Insurance provider: ';
								if(trim($formThree['ins_provider'])!='')
									$value .=ucfirst($formThree['ins_provider']);
								else
									$value .='N/A';
								
								$value .=', Policy no.: ';
								if(trim($formThree['ins_policy_no'])!='')
									$value .=$formThree['ins_policy_no'];
								else
									$value .='N/A';
								
								$value .=', Expiry date: ';
								if($formThree['ins_expiry']!='0000-00-00')
									$value .=date('d M Y',strtotime($formThree['ins_expiry']));
								else
									$value .='N/A';
								
								if($formThree['20_million']=='1')
									$value .=', $20 million Public Liability cover';
							}
							else
								$value="No";
					}
					elseif($v=='wwcc')
					{
						$value='';
						$family_role=family_role();
						$wwccPipe=false;
						foreach($formThree['memberDetails'] as $memberK=>$member)
						{
							if($wwccPipe)
								$value .=' | ';
							$wwccPipe=true;
							
							$value .=ucwords($member['fname'].' '.$member['lname']);
							if($member['role']!='')
							   {
									$value .=" (";
									  if($member['role']==17)
										  $value .=!empty($member['other_role']) ? ' - '.$member['other_role'] :'';
									  else
										  $value .= $family_role[$member['role']];
									$value .=")";	  
								}
							
							if($member['wwcc']=="1")
								{
											if($member['wwcc_clearence']=='1')
											{
												if(trim($member['wwcc_clearence_no'])!='')
													$value .=' - Clearance no.: '.$member['wwcc_clearence_no'];
												else
													$value .=' - Clearance no. unavailable';	
												if($member['wwcc_expiry']!="0000-00-00")
													$value .=', Expiry date: '.date('d M Y',strtotime($member['wwcc_expiry']));
												else
													$value .=', Expiry date unavailable';
											}
											else
											{
												if($member['wwcc_application_no']!='')
													$value .=' - Application no.: '.$member['wwcc_application_no'];
												else
													$value .=', Application no. unavailable';	
											}
								}
								else
									$value .=' - No WWCC details';
						}
					}
					elseif($v=='occupation')
					{

						$value='';
						$family_role=family_role();
						$occupyPipe=false;
						foreach($formThree['memberDetails'] as $memberK=>$member)
						{
						if($occupyPipe)
						$value .=' | ';
						$occupyPipe=true;

						$value .=ucwords($member['fname'].' '.$member['lname']);
						if($member['role']!='')
						{
						$value .=" (";
						if($member['role']==17)
						$value .=!empty($member['other_role']) ? ' - '.$member['other_role'] :'';
						else
						$value .= $family_role[$member['role']];
						$value .=")";	  
						}

						if(trim($member['occu'])!='')
						{
						$value .=': '.trim($member['occu']);
						}
						else{
						$value .=': Not mentioned';
						}	
						}
					}		
				}
				else
				{
					if($v=='insurance')
						$value="No";
					elseif($v=='wwcc')
						$value="No WWCC details";
					elseif($v=='occupation')
						$value='No Occupation details';
				}
			}
				
			$this->excel->getActiveSheet()->setCellValue($k.$x, $value);	
		}
		
		$x++;	
	}

				$filename='families.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
				//force user to download the Excel file without writing it to server's HD
				//$objWriter->save('php://output');
				$objWriter->save('static/report/families.xls');
				//$mpdf->Output('static/pdf/invoice.pdf','F');
		//header('location:'.site_url().'reports/hfa');
	}
	
	function college_auditing()
	{
			if(checkLogin())
			{
				recentActionsAddData('report','college_auditing','view');
				$data['page']='reports-college_auditing';
				$this->load->view('system/header',$data);
				$this->load->view('system/reports/college_auditing_report');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
	}
	
	function college_auditing_submit()
	{
		$data=$_POST;
		
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('test worksheet');
		
		$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
				'font'=>array(
				'name'      =>  'Arial',
				'size'      =>  10,
			)
		));
		
		$fields=array();
		$fieldIndex=$lastIndex='A';
		
		foreach($data['CaR_field'] as $hr_field)
		{
			$fields[$fieldIndex]=$hr_field;
			$lastIndex=$fieldIndex;
			$fieldIndex++;
		}
		
		foreach ($fields as $fieldK=>$field)
	   	$this->excel->getActiveSheet()->getColumnDimension($fieldK)->setAutosize(true);
	   
	  $x_start=1;
	  $reportFields=college_auditing_report_fields();
	  foreach($fields as $k=>$v)
	  {
		  if($v=='id')
			  $colHeading='Id';
		  else 
			  $colHeading=$reportFields[$v];
		  $this->excel->getActiveSheet()->setCellValue($k.$x_start, $colHeading);
	  }
		  
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getFont()->setSize(10)->setBold(true);  
		
		$x=$x_start+1;
		
	$this->load->model('report_model');
	$bookings=$this->report_model->bookingListForAuditingReport($data);
	
	$genderList=genderList();
	$stateList=stateList();
	$family_role=family_role();
	$bookingStatusList=bookingStatusList();
	foreach($bookings as $booking)
	{
		$hfaOne=getHfaOneAppDetails($booking['host']);
		$hfaThree=getHfaThreeAppDetails($booking['host']);
		$shaOne=getShaOneAppDetails($booking['student']);
		$shaThree=getShaThreeAppDetails($booking['student']);
		
		foreach($fields as $k=>$v)
		{
			$value='';
			if($v=='id')
				$value=$booking['id'];
			elseif($v=='office')
				$value='';
			elseif($v=='host_name')
				$value=$hfaOne['fname'].' '.$hfaOne['lname'];
			elseif($v=='host_email')
				$value=$hfaOne['email'];
			elseif($v=='host_address')
			{
				if($hfaOne['street']!='')
					$value .=$hfaOne['street'].", ";
				$value .=ucfirst($hfaOne['suburb']).", ".$stateList[$hfaOne['state']].", ".$hfaOne['postcode'];	
			}
			elseif($v=='resident')
				$value='';
			elseif($v=='wwcc')
			{
				if(!empty($hfaThree))
				{
						$wwccPipe=false;
						foreach($hfaThree['memberDetails'] as $memberK=>$member)
						{
							if($wwccPipe)
								$value .=' | ';
							$wwccPipe=true;
							
							$value .=ucwords($member['fname'].' '.$member['lname']);
							if($member['role']!='')
							   {
									$value .=" (";
									  if($member['role']==17)
										  $value .=!empty($member['other_role']) ? ' - '.$member['other_role'] :'';
									  else
										  $value .= $family_role[$member['role']];
									$value .=")";	  
								}
							
							if($member['wwcc']=="1")
								{
											if($member['wwcc_clearence']=='1')
											{
												if(trim($member['wwcc_clearence_no'])!='')
													$value .=' - Clearance no.: '.$member['wwcc_clearence_no'];
												else
													$value .=' - Clearance no. unavailable';	
												if($member['wwcc_expiry']!="0000-00-00")
													$value .=', Expiry date: '.date('d M Y',strtotime($member['wwcc_expiry']));
												else
													$value .=', Expiry date unavailable';
											}
											else
											{
												if($member['wwcc_application_no']!='')
													$value .=' - Application no.: '.$member['wwcc_application_no'];
												else
													$value .=', Application no. unavailable';	
											}
								}
								else
									$value .=' - No WWCC details';
						}
				}
			}
			elseif($v=='insurance')
			{
				if($hfaThree['insurance']=="1")
				  {
					  $value .='Insurance provider: ';
					  if(trim($hfaThree['ins_provider'])!='')
						  $value .=ucfirst($hfaThree['ins_provider']);
					  else
						  $value .='N/A';
					  
					  $value .=', Policy no.: ';
					  if(trim($hfaThree['ins_policy_no'])!='')
						  $value .=$hfaThree['ins_policy_no'];
					  else
						  $value .='N/A';
					  
					  $value .=', Expiry date: ';
					  if($hfaThree['ins_expiry']!='0000-00-00')
						  $value .=date('d M Y',strtotime($hfaThree['ins_expiry']));
					  else
						  $value .='N/A';
					  
					  if($hfaThree['20_million']=='1')
						  $value .=', $20 million Public Liability cover';
				  }
				  else
					  $value .="No";
			}
			elseif($v=='student_number')
				$value=$shaOne['sha_student_no'];
			elseif($v=='student_name')
				$value=$shaOne['fname'].' '.$shaOne['lname'];
			elseif($v=='student_dob')
				$value=date('d M Y',strtotime($shaOne['dob']));
			elseif($v=='student_age')
				$value=age_from_dob($shaOne['dob']);
			elseif($v=='student_gender')
				$value=$genderList[$shaOne['gender']];
			elseif($v=='college')
				$value=$shaThree['college'];
			elseif($v=='course_name')
			{
				if($shaThree['course_name'] && $shaThree['course_start_date'])
				{
				$value = 'Course: '.$shaThree['course_name'].' | Start date: '.date('d M Y',strtotime($shaThree['course_start_date']));
				}
				elseif($shaThree['course_start_date']=='0000-00-00' && !$shaThree['course_name'])
				{
				$value = 'Course not available | Start date not available';
				}
				elseif(!$shaThree['course_name'] && $shaThree['course_start_date'])
				{
				$value = 'Course not available'.' | Start Date: '.date('d M Y',strtotime($shaThree['course_start_date']));
				}
				if($shaThree['course_start_date']=='0000-00-00' && $shaThree['course_name'])
				{
				$value = 'Course: '.$shaThree['course_name'].' | Start date not available';
				}
			}
			elseif($v=='last_visit_date')
				$value=$this->report_model->hfaLastVisitDate($booking['host']);
			elseif($v=='client')
			{
				$clientDetail=clientDetail($shaOne['client']);
				$value=$clientDetail['bname'];
			}
			elseif($v=='client_group')
				{
					if($shaOne['client']!='0')
					{
						$clientGroupList=clientGroupList();
						$clientDetail=clientDetail($shaOne['client']);
						if($clientDetail['client_group']!='')
							$value=$clientGroupList[$clientDetail['client_group']];
					}
				}
			elseif($v=='booking_start_date')
				$value=date('d M Y',strtotime($booking['booking_from']));
			elseif($v=='booking_end_date')
			{
				if($booking['booking_to']!='0000-00-00')
					$value=date('d M Y',strtotime($booking['booking_to'].' + 1 day'));
				else	
					$value="Not set";
			}
			elseif($v=='booking_status')
				$value=$bookingStatusList[$booking['status']];
			
			$this->excel->getActiveSheet()->setCellValue($k.$x, $value);	
		}
		
		$x++;
	}

	
				$filename='college_auditing.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
				//force user to download the Excel file without writing it to server's HD
				//$objWriter->save('php://output');
				$objWriter->save('static/report/'.$filename);
				//$mpdf->Output('static/pdf/invoice.pdf','F');
		//header('location:'.site_url().'reports/hfa');
	}
	
	function tour_groups()
	{
			if(checkLogin())
			{
				recentActionsAddData('report','tour_groups','view');
				$data['page']='reports-tour_groups';
				$this->load->view('system/header',$data);
				$this->load->view('system/reports/tour_groups_report');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
	}
	
	function tour_groups_submit()
	{
		$data=$_POST;
		
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('test worksheet');
		
		$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
				'font'=>array(
				'name'      =>  'Arial',
				'size'      =>  10,
			)
		));
		
		$fields=array();
		$fieldIndex=$lastIndex='A';
		
		foreach($data['tgR_field'] as $hr_field)
		{
			$fields[$fieldIndex]=$hr_field;
			$lastIndex=$fieldIndex;
			$fieldIndex++;
		}
		
		foreach ($fields as $fieldK=>$field)
	   	$this->excel->getActiveSheet()->getColumnDimension($fieldK)->setAutosize(true);
	   
	  $x_start=1;
	  $reportFields=tour_groups_report_fields();
	  foreach($fields as $k=>$v)
	  {
		  if($v=='id')
			  $colHeading='Id';
		  else 
			  $colHeading=$reportFields[$v];
		  $this->excel->getActiveSheet()->setCellValue($k.$x_start, $colHeading);
	  }
		  
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getFont()->setSize(10)->setBold(true);  
		
		$x=$x_start+1;
		
	$this->load->model('report_model');
	$students=$this->report_model->shaListForTourGroupsReport($data);
	
	$nationList=nationList();
	$stateList=stateList();
	$genderList=genderList();
	$accomodationTypeList=accomodationTypeList();
	
	foreach($students as $sha)
	{
		$shaTwo=getShaTwoAppDetails($sha['id']);
		$shaThree=getShaThreeAppDetails($sha['id']);
		$hfa_name='Not placed';
		$tourDetail=tourDetail($sha['study_tour_id']);
		$sha_tour_group=$tourDetail['group_name'];
		$checking_date=$checking_out_date='';
		$hfa_address=$hfa_mobile=$hfa_email='';
		$booking=bookingByShaId($sha['id']);
		if(!empty($booking))
			{
				$hfaOne=getHfaOneAppDetails($booking['host']);
				
				$hfa_name=$hfaOne['fname'].' '.$hfaOne['lname'];
				
				$hfa_address='';
				if($hfaOne['street']!='')
					$hfa_address .=$hfaOne['street'].", ";
				$hfa_address .=ucfirst($hfaOne['suburb']).", ".$stateList[$hfaOne['state']].", ".$hfaOne['postcode'];	
				
				$checking_date=date('d M Y',strtotime($booking['booking_from']));
				if($booking['booking_to']!='0000-00-00')
					$checking_out_date=date('d M Y',strtotime($booking['booking_to'].' +1 day'));
				$checking_out_date='not set';
				
				$hfa_email=$hfaOne['email'];
				$hfa_mobile=$hfaOne['mobile'];
			}
			else
			{
				if($sha['booking_from']!='0000-00-00')
				{
					$checking_date=date('d M Y',strtotime($sha['booking_from']));
					if($sha['booking_to']!='0000-00-00')
						$checking_out_date=date('d M Y',strtotime($sha['booking_to'].' +1 day'));
					else
						$checking_out_date='Not set';
				}
			}
		
		foreach($fields as $k=>$v)
		{
			$value='';
			if($v=='id')
				$value=$sha['id'];
			elseif($v=='sha_name')
				$value=ucwords($sha['fname'].' '.$sha['lname']);
			elseif($v=='sha_dob')
				$value=date('d M Y',strtotime($sha['dob']));
			elseif($v=='sha_age')
				$value=age_from_dob($sha['dob']);
			elseif($v=='sha_gender')
				$value=$genderList[$sha['gender']];
			elseif($v=='sha_college')
			{
				$clientDetail=clientDetail($sha['client']);
				$value=$clientDetail['bname'];
			}
			elseif($v=='checking_date')
				$value=$checking_date;
			elseif($v=='checking_out_date')
				$value=$checking_out_date;
			elseif($v=='sha_tour_group')
				$value=$sha_tour_group;
			elseif($v=='hfa_name')
				$value=$hfa_name;
			elseif($v=='hfa_email')
				$value=$hfa_email;
			elseif($v=='hfa_address')
				$value=$hfa_address;
			elseif($v=='hfa_mobile')
				$value=$hfa_mobile;
			elseif($v=='sha_nation')
			{
				if($sha['nation']!=='')
					$value=$nationList[$sha['nation']];
			}
			elseif($v=='sha_allergy')
			{
					if($shaThree['allergy_req']=='0')
						$value .="No";
					elseif($shaThree['allergy_req']=='1')
						$value .="Yes ";
					else
						$value .='n/a';
						
					if($shaThree['allergy_req']=='1')
						{
							$allergy=array();
							if($shaThree['allergy_hay_fever']==1)
								$allergy[]='Hay Fever';
							if($shaThree['allergy_asthma']==1)
								$allergy[]='Asthma';
							if($shaThree['allergy_lactose']==1)
								$allergy[]='Lactose Intolerance';
							if($shaThree['allergy_gluten']==1)
								$allergy[]='Gluten Intolerance';	
							if($shaThree['allergy_peanut']==1)
								$allergy[]='Peanut Allergies';	
							if($shaThree['allergy_dust']==1)
								$allergy[]='Dust Allergies';	
							if($shaThree['allergy_other']==1 && $shaThree['allergy_other_val']!='')
								$allergy[]=ucfirst ($shaThree['allergy_other_val']);		
							
							if(!empty($allergy))
								$value .='- '.implode(', ',$allergy);
						}	
			}
			elseif($v=='sha_pets')
			{
				  if($shaTwo['live_with_pets']=="0")
					  $value .="No";
				  elseif($shaTwo['live_with_pets']=="1")
					  $value .="Yes ";
				  else
					  $value .="n/a";
				  
				  if($shaTwo['live_with_pets']==1)
				  {
						$pets=array();
						if($shaTwo['pet_dog']==1)
							$pets[]='Dog';
						if($shaTwo['pet_cat']==1)
							$pets[]='Cat';
						if($shaTwo['pet_bird']==1)
							$pets[]='Bird';
						if($shaTwo['pet_other']==1 && $shaTwo['pet_other_val']!='')
							$pets[]=ucfirst ($shaTwo['pet_other_val']);	
						
						if(!empty($pets))
							$value .='- '.implode(', ',$pets);
					}
			}
			elseif($v=='sha_kids')
			{
				$value .='0-11 years old(';
				if($shaThree['live_with_child11']==1)
					$value .="Yes";
				elseif($shaThree['live_with_child11']=="0")	
					$value .="No";
				else
					$value .='n/a';	
				$value .='), ';
				
				$value .='12-20 years old(';
				if($shaThree['live_with_child20']==1)
					$value .= "Yes";
				elseif($shaThree['live_with_child20']=="0")	
					$value .= "No";
				else
					$value .= 'n/a';
				$value .=')';	
			}
			elseif($v=='sha_accomodationType')
				$value=$accomodationTypeList[$sha['accomodation_type']];
			elseif($v=='sha_notes')
			{
				if($sha['special_request_notes']!=='')
					$value=$sha['special_request_notes'];
				else
					$value='n/a';	
			}
			
			$this->excel->getActiveSheet()->setCellValue($k.$x, $value);	
		}
		
		$x++;
	}

	
				$filename='tour_group.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
				//force user to download the Excel file without writing it to server's HD
				//$objWriter->save('php://output');
				$objWriter->save('static/report/'.$filename);
				//$mpdf->Output('static/pdf/invoice.pdf','F');
		//header('location:'.site_url().'reports/hfa');
	}
	
	function revisits()
	{
			if(checkLogin())
			{
				recentActionsAddData('report','revisits','view');
				$data['page']='reports-revisits';
				$this->load->view('system/header',$data);
				$this->load->view('system/reports/revisits_report');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
	}
	
	function revisits_submit()
	{
		$data=$_POST;
		//see($data);die(1);
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('test worksheet');
		
		$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
				'font'=>array(
				'name'      =>  'Arial',
				'size'      =>  10,
			)
		));
		
		$fields=array();
		$fieldIndex=$lastIndex='A';
		
		foreach($data['RR_field'] as $hr_field)
		{
			$fields[$fieldIndex]=$hr_field;
			$lastIndex=$fieldIndex;
			$fieldIndex++;
		}
		
		foreach ($fields as $fieldK=>$field)
	   	$this->excel->getActiveSheet()->getColumnDimension($fieldK)->setAutosize(true);
	   
	  $x_start=1;
	  $reportFields=revisits_report_fields();
	  foreach($fields as $k=>$v)
	  {
		  if($v=='id')
			  $colHeading='Host family id';
		  else 
			  $colHeading=$reportFields[$v];
		  $this->excel->getActiveSheet()->setCellValue($k.$x_start, $colHeading);
	  }
		  
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getFont()->setSize(10)->setBold(true);  
		
		$x=$x_start+1;
		
	$this->load->model('report_model');
	$families=$this->report_model->hfaListForRevisitsReport($data);
	
	$stateList=stateList();
	
	foreach($families as $hfa)
	{
		foreach($fields as $k=>$v)
		{
			$value='';
			if($v=='id')
				$value=$hfa['id'];
			elseif($v=='primary_host')
				$value=ucwords($hfa['fname'].' '.$hfa['lname']);
			elseif($v=='mobile')
				$value=$hfa['mobile'];
			elseif($v=='email_id')
				$value=$hfa['email'];
			elseif($v=='address')
			{
				$addressForMap='';
				if($hfa['street']!='')
					$addressForMap .=$hfa['street'].", ";
				$addressForMap .=ucfirst($hfa['suburb']).", ".$stateList[$hfa['state']].", ".$hfa['postcode'];
				$value=$addressForMap;
			}
			elseif($v=='last_visit_date')
				$value=date('d M Y',strtotime($hfa['date_status_changed']));
			elseif($v=='revisit_due_date')
				$value=date('d M Y',strtotime($hfa['date_status_changed'].' + '.$hfa['revisit_duration'].' months'));
			
			$this->excel->getActiveSheet()->setCellValue($k.$x, $value);	
		}
		
		$x++;
	}

	
				$filename='revisits.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
				//force user to download the Excel file without writing it to server's HD
				//$objWriter->save('php://output');
				$objWriter->save('static/report/'.$filename);
				//$mpdf->Output('static/pdf/invoice.pdf','F');
		//header('location:'.site_url().'reports/hfa');
	}
	
	function incidents()
	{
			if(checkLogin())
			{
				recentActionsAddData('report','incidents','view');
				$data['page']='reports-incidents';
				$this->load->view('system/header',$data);
				$this->load->view('system/reports/incidents_report');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
	}
	
	function incidents_submit()
	{
		$data=$_POST;
		//see($data);die(1);
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('test worksheet');
		
		$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
				'font'=>array(
				'name'      =>  'Arial',
				'size'      =>  10,
			)
		));
		
		$fields=array();
		$fieldIndex=$lastIndex='A';
		
		foreach($data['IR_field'] as $hr_field)
		{
			$fields[$fieldIndex]=$hr_field;
			$lastIndex=$fieldIndex;
			$fieldIndex++;
		}
		
		foreach ($fields as $fieldK=>$field)
	   	$this->excel->getActiveSheet()->getColumnDimension($fieldK)->setAutosize(true);
	   
	  $x_start=1;
	  $reportFields=incidents_report_fields();
	  foreach($fields as $k=>$v)
	  {
		  if($v=='id')
			  $colHeading='Student id';
		  else 
			  $colHeading=$reportFields[$v];
		  $this->excel->getActiveSheet()->setCellValue($k.$x_start, $colHeading);
	  }
		  
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getFont()->setSize(10)->setBold(true);  
		
		$x=$x_start+1;
		
	$this->load->model('report_model');
	$incidents=$this->report_model->incidentsListForReport($data);
	
	$incidentStatusList=incidentStatusList();
	$incidentLevelList=incidentLevelList();
	
	foreach($incidents as $in)
	{
		$shaOne=getShaOneAppDetails($in['sha_id']);
		$shaThree=getShaThreeAppDetails($in['sha_id']);
		$hfaOne=getHfaOneAppDetails($in['hfa_id']);
		foreach($fields as $k=>$v)
		{
			$value='';
			if($v=='id')
				$value=$in['sha_id'];
			elseif($v=='student_name')
				$value=ucwords($shaOne['fname'].' '.$shaOne['lname']);
			elseif($v=='student_college_id')
				$value=$shaOne['sha_student_no'];
			elseif($v=='host_family_name')
				$value=ucwords($hfaOne['fname'].' '.$hfaOne['lname']);
			elseif($v=='hfa_id')
				$value=$hfaOne['id'];
			elseif($v=='detail')
				$value=$in['details'];
			elseif($v=='follow_up')
				$value=$in['follow_up'];
			elseif($v=='outcome')
				$value=$in['outcome'];
			elseif($v=='incident_date')
				$value=date('d M Y',strtotime($in['incident_date']));
			elseif($v=='status')
				$value=$incidentStatusList[$in['status']];
			elseif($v=='level')
			{
				$value=$incidentLevelList[$in['level']];
				if($in['level']==9)
					$value .=": ".$in['level_other'];
			}
			elseif($v=='college')
				$value=$shaThree['college'];
			elseif($v=='client')
				{
					$clientDetail=clientDetail($shaOne['client']);
					$value=$clientDetail['bname'];
				}
			elseif($v=='client_group')
				{
					if($shaOne['client']!='0')
					{
						$clientGroupList=clientGroupList();
						$clientDetail=clientDetail($shaOne['client']);
						if($clientDetail['client_group']!='')
							$value=$clientGroupList[$clientDetail['client_group']];
					}
				}
			
			$this->excel->getActiveSheet()->setCellValue($k.$x, $value);	
		}
		
		$x++;
	}

	
				$filename='incidents.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
				//force user to download the Excel file without writing it to server's HD
				//$objWriter->save('php://output');
				$objWriter->save('static/report/'.$filename);
				//$mpdf->Output('static/pdf/invoice.pdf','F');
		//header('location:'.site_url().'reports/hfa');
	}
	
	function bookings()
	{
			if(checkLogin())
			{
				recentActionsAddData('report','bookings','view');
				$data['page']='reports-bookings';
				$this->load->view('system/header',$data);
				$this->load->view('system/reports/bookings_report');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
	}
	
	function bookings_submit()
	{
		$data=$_POST;
		//see($data);die(1);
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('test worksheet');
		
		$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
				'font'=>array(
				'name'      =>  'Arial',
				'size'      =>  10,
			)
		));
		
		$fields=array();
		$fieldIndex=$lastIndex='A';
		
		foreach($data['CaR_field'] as $hr_field)
		{
			$fields[$fieldIndex]=$hr_field;
			$lastIndex=$fieldIndex;
			$fieldIndex++;
		}
		//see($fields);
		foreach ($fields as $fieldK=>$field){//echo $fieldK.', ';
	   	$this->excel->getActiveSheet()->getColumnDimension($fieldK)->setAutosize(true);}
	   
	  $x_start=1;
	  $reportFields=bookings_report_fields();
	  foreach($fields as $k=>$v)
	  {
		  $colHeading=$reportFields[$v];
		  $this->excel->getActiveSheet()->setCellValue($k.$x_start, $colHeading);
	  }
		  
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getFont()->setSize(10)->setBold(true);  
		
		$x=$x_start+1;
		
	$this->load->model('report_model');
	$bookings=$this->report_model->bookingListForAuditingReport($data);//echo $this->db->last_query();see($bookings);die('dddd');
	
	$this->load->model('booking_model');
	
	$stateList=stateList();
	$genderList=genderList();
	$bookingStatusList=bookingStatusList();
	//see($fields);
	foreach($bookings as $booking)
	{
		$shaOne=getShaOneAppDetails($booking['student']);
		$shaTwo=getShaTwoAppDetails($booking['student']);
		$shaThree=getShaThreeAppDetails($booking['student']);
		$hfaOne=getHfaOneAppDetails($booking['host']);
		$caregiver=getCaregiverDetail($shaTwo['guardian_assigned']);
		$caregiverCompany=getCaregiverCompanyDetail($caregiver['company']);
		foreach($fields as $k=>$v)
		{
			$value='';
			if($v=='sha_name')
				$value=ucwords($shaOne['fname'].' '.$shaOne['lname']);
			elseif($v=='student_college_id')
				$value=$shaOne['sha_student_no'];
			elseif($v=='sha_dob')
				$value=date('d M Y',strtotime($shaOne['dob']));
			elseif($v=='sha_gender')
				$value=$genderList[$shaOne['gender']];
			elseif($v=='sha_age')
				$value=age_from_dob($shaOne['dob']);
			elseif($v=='sha_email')
				$value=$shaOne['email'];
			elseif($v=='sha_mobile')
				$value=$shaOne['mobile'].' ';
			elseif($v=='booking_number')
				$value=$booking['id'];
			elseif($v=='booking_status')
				$value=$bookingStatusList[$booking['status']];
			elseif($v=='client_name')
				{	
					$clientDetail=clientDetail($shaOne['client']);
					$value=$clientDetail['bname'];
				}
			elseif($v=='client_group')
				{
					if($shaOne['client']!='0')
					{
						$clientGroupList=clientGroupList();
						$clientDetail=clientDetail($shaOne['client']);
						if($clientDetail['client_group']!='')
							$value=$clientGroupList[$clientDetail['client_group']];
					}
				}
			elseif($v=='college_name')
				$value=$shaThree['college'];
			elseif($v=='booking_start_date')
				$value=date('d M Y',strtotime($booking['booking_from']));
			elseif($v=='booking_end_date')
			{
				if($booking['booking_to']!='0000-00-00')
					$value=date('d M Y',strtotime($booking['booking_to'].' +1 day'));
				else
					$value='Not set';	
			}
			elseif($v=='hfa_name')
				$value=ucwords($hfaOne['fname'].' '.$hfaOne['lname']);
			elseif($v=='hfa_address')
			{
				if($hfaOne['street']!='')
					$value .=$hfaOne['street'].", ";
				$value .=ucfirst($hfaOne['suburb']).", ".$stateList[$hfaOne['state']].", ".$hfaOne['postcode'];	
			}
			elseif($v=='hfa_mobile')
				$value=$hfaOne['mobile'];
			elseif($v=='hfa_email')
				$value=$hfaOne['email'];
			elseif($v=='apu')
			{
				if($shaTwo['airport_pickup']=='1')
					$value='Yes';
				else
					$value='No';	
			}
			elseif($v=='apu_company')
			{
				if($shaTwo['apu_company']!='0')
				{
					$apuCompanyDetail=apuCompanyDetail($shaTwo['apu_company']);
					if(!empty($apuCompanyDetail))
						$value=$apuCompanyDetail['company_name'];	 
				}
			}
			elseif($v=='apu_arrival_date')
			{
				if($shaOne['arrival_date']!='0000-00-00')
					$value=dateFormat($shaOne['arrival_date']);
			}
			elseif($v=='apu_arrival_time')
			{
				if($shaTwo['airport_arrival_time']!='00:00:00')
					$value=date('h:i A',strtotime($shaTwo['airport_arrival_time']));
			}
			elseif($v=='apu_flight_number')
				$value=$shaTwo['airport_flightno'];
			elseif($v=='sha_pets')
			{
				  if($shaTwo['live_with_pets']=="0")
					  $value .="No";
				  elseif($shaTwo['live_with_pets']=="1")
					  $value .="Yes";
				  else
					  $value .="n/a";
				  
				  if($shaTwo['live_with_pets']==1)
				  {
						$pets=array();
						if($shaTwo['pet_dog']==1)
							$pets[]='Dog';
						if($shaTwo['pet_cat']==1)
							$pets[]='Cat';
						if($shaTwo['pet_bird']==1)
							$pets[]='Bird';
						if($shaTwo['pet_other']==1 && $shaTwo['pet_other_val']!='')
							$pets[]=ucfirst ($shaTwo['pet_other_val']);	
						
						if(!empty($pets))
							$value .=' - '.implode(', ',$pets);
						
						if($shaTwo['pet_live_inside']==1)
							$value .= ", can live with pets inside the house";
						elseif($shaTwo['pet_live_inside']=="0")
							$value .= ", cannot live with pets inside the house";	
					}
			}
			elseif($v=='sha_kids')
			{
				$value .='0-11 years old: ';
				if($shaThree['live_with_child11']==1)
					$value .="Yes";
				elseif($shaThree['live_with_child11']=="0")	
					$value .="No";
				else
					$value .='n/a';	
				$value .=', ';
				
				$value .='12-20 years old: ';
				if($shaThree['live_with_child20']==1)
					$value .= "Yes";
				elseif($shaThree['live_with_child20']=="0")	
					$value .= "No";
				else
					$value .= 'n/a';
				$value .='';	
				
				if(trim($shaThree['live_with_child_reason'])!='')
					$value .= ', Reason: '.ucfirst ($shaThree['live_with_child_reason']);
			}
			elseif($v=='sha_allergy')
			{
					if($shaThree['allergy_req']=='0')
						$value .="No";
					elseif($shaThree['allergy_req']=='1')
						$value .="Yes ";
					else
						$value .='n/a';
						
					if($shaThree['allergy_req']=='1')
						{
							$allergy=array();
							if($shaThree['allergy_hay_fever']==1)
								$allergy[]='Hay Fever';
							if($shaThree['allergy_asthma']==1)
								$allergy[]='Asthma';
							if($shaThree['allergy_lactose']==1)
								$allergy[]='Lactose Intolerance';
							if($shaThree['allergy_gluten']==1)
								$allergy[]='Gluten Intolerance';	
							if($shaThree['allergy_peanut']==1)
								$allergy[]='Peanut Allergies';	
							if($shaThree['allergy_dust']==1)
								$allergy[]='Dust Allergies';	
							if($shaThree['allergy_other']==1 && $shaThree['allergy_other_val']!='')
								$allergy[]=ucfirst ($shaThree['allergy_other_val']);		
							
							if(!empty($allergy))
								$value .='- '.implode(', ',$allergy);
						}	
			}
			elseif($v=='sha_dietry_requirement')
			{
					if($shaThree['diet_req']=='0')
					  $value .= "No";
				  elseif($shaThree['diet_req']=='1')
					  $value .= "Yes ";
				  else
					   $value .= 'n/a';
					  
				  if($shaThree['diet_req']=='1')
					  {
						  $dietReq=array();
						  if($shaThree['diet_veg']==1)
							  $dietReq[]='Vegetarian';
						  if($shaThree['diet_gluten']==1)
							  $diet[]='Gluten/Lactose Free';
						  if($shaThree['diet_pork']==1)
							  $dietReq[]='No Pork';
						  if($shaThree['diet_food_allergy']==1)
							  $dietReq[]='Food Allergies';	
						  if($shaThree['diet_other']==1 && $shaThree['diet_other_val']!='')
							  $dietReq[]=ucfirst ($shaThree['diet_other_val']);		
						  
						  if(!empty($dietReq))
							  $value .='- '.implode(', ',$dietReq);
					  }
			}
			elseif($v=='sha_medication')
			{
				  if($shaThree['medication']=='1')
					  $value .= 'Yes';
				  elseif($shaThree['medication']=='0')
					  $value .= "No";
				  else 
					  $value .= 'n/a';	
					  
				  if($shaThree['medication']=='1')
					  $value .='- '.$shaThree['medication_desc'];
			}
			elseif($v=='sha_disabilty')
			{
				  if($shaThree['disabilities']=='1')
					  $value .= 'Yes';
				  elseif($shaThree['disabilities']=='0')
					  $value .= "No";
				  else 
					  $value .= 'n/a';	
					  
				  if($shaThree['disabilities']=='1')
					  $value .='- '.$shaThree['disabilities_desc'];
			}
			elseif($v=='sha_smoke')
			{
				  $smokingHabbits=smokingHabbits();
				  if($shaThree['smoker']!='')
					  $value .= str_replace('&amp;','&',$smokingHabbits[$shaThree['smoker']]);
				  else
					  $value .= 'n/a';	
			}
			elseif($v=='sha_smoker_inside')
			{
				  $smokingHabbits=smokingHabbits();
				  if($shaThree['family_include_smoker']!='')
					  $value .= str_replace('&amp;','&',$smokingHabbits[$shaThree['family_include_smoker']]);
				  else
					  $value .= 'n/a';	
			}
			elseif($v=='sha_other_family_pref')
			{
				  if($shaThree['family_pref']!='')
					  $value .= $shaThree['family_pref'];
				  else
					  $value .= 'n/a';
			}
			elseif($v=='course_name')
			{
				if($shaThree['course_name'] && $shaThree['course_start_date'])
				{
				$value = 'Course: '.$shaThree['course_name'].' | Start date: '.date('d M Y',strtotime($shaThree['course_start_date']));
				}
				elseif($shaThree['course_start_date']=='0000-00-00' && !$shaThree['course_name'])
				{
				$value = 'Course not available | Start date not available';
				}
				elseif(!$shaThree['course_name'] && $shaThree['course_start_date'])
				{
				$value = 'Course not available'.' | Start Date: '.date('d M Y',strtotime($shaThree['course_start_date']));
				}
				if($shaThree['course_start_date']=='0000-00-00' && $shaThree['course_name'])
				{
				$value = 'Course: '.$shaThree['course_name'].' | Start date not available';
				}
			}
			elseif($v=='cg_company')
				$value=$caregiverCompany['name'];
			elseif($v=='cg_name')
				$value=$caregiver['fname'].' '.$caregiver['lname'];
			elseif($v=='cg_mobile')
				$value=$caregiver['phone'];
			elseif($v=='cg_email')
				$value=$caregiver['email'];
			elseif($v=='holidays_latest' || $v=='holidays')
			{
				$bookingHolidays=$this->booking_model->holidaysByBooking($booking['id']);
				if(empty($bookingHolidays))
					$value='N/A';
				else	
				{
					if($v=='holidays_latest')
							$value=dateFormat($bookingHolidays[0]['start']).' - '.dateFormat($bookingHolidays[0]['end']);
					elseif($v=='holidays')
					{
						$holidayArray=array();
						foreach($bookingHolidays as $holiday)
							$holidayArray[]=dateFormat($holiday['start']).' - '.dateFormat($holiday['end']);
						$value=implode(' | ',$holidayArray);	
					}
				}
			}
			elseif($v=='homestay_change')
				$value=$this->shaHomestayChangeReportField($shaOne['id']);
			
			$this->excel->getActiveSheet()->setCellValue($k.$x, $value);	
		}
		
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
				//$objWriter->save('php://output');
				$objWriter->save('static/report/'.$filename);
				//$mpdf->Output('static/pdf/invoice.pdf','F');
		//header('location:'.site_url().'reports/hfa');
	}
	
	
	function booking_allocation()
	{
			if(checkLogin())
			{
				recentActionsAddData('report','booking_allocation','view');
				$data['page']='reports-booking_allocation';
				$this->load->view('system/header',$data);
				$this->load->view('system/reports/booking_allocation_report');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
	}
	
	function booking_allocation_submit()
	{
		$data=$_POST;
		//see($data);die('1');
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('test worksheet');
		
		$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
				'font'=>array(
				'name'      =>  'Arial',
				'size'      =>  10,
			)
		));
		
		$fields=array();
		$fieldIndex=$lastIndex='A';
		
		foreach($data['CaR_field'] as $hr_field)
		{
			$fields[$fieldIndex]=$hr_field;
			$lastIndex=$fieldIndex;
			$fieldIndex++;
		}
		//see($fields);
		foreach ($fields as $fieldK=>$field){//echo $fieldK.', ';
	   	$this->excel->getActiveSheet()->getColumnDimension($fieldK)->setAutosize(true);}
	   
	  $x_start=1;
	  $reportFields=bookings_allocation_report_fields();
	  foreach($fields as $k=>$v)
	  {
		  $colHeading=$reportFields[$v];
		  $this->excel->getActiveSheet()->setCellValue($k.$x_start, $colHeading);
	  }
		  
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getFont()->setSize(10)->setBold(true);  
		
		$x=$x_start+1;
		
	$this->load->model('report_model');
	$bookings=$this->report_model->bookingListForEmployeesReport($data);//echo $this->db->last_query();see($bookings);//die('dddd');
	
	$this->load->model('booking_model');
	
	$stateList=stateList();
	$genderList=genderList();
	$bookingStatusList=bookingStatusList();
	//see($fields);
	foreach($bookings as $booking)
	{
		$shaOne=getShaOneAppDetails($booking['student']);
		$shaTwo=getShaTwoAppDetails($booking['student']);
		$shaThree=getShaThreeAppDetails($booking['student']);
		$hfaOne=getHfaOneAppDetails($booking['host']);
		$caregiver=getCaregiverDetail($shaTwo['guardian_assigned']);
		$caregiverCompany=getCaregiverCompanyDetail($caregiver['company']);
		foreach($fields as $k=>$v)
		{
			$value='';
			if($v=='employee'){
				$employeeDetails=employee_details($shaOne['employee']);
				$value=ucwords($employeeDetails['fname'].' '.$employeeDetails['lname']);
			}
			elseif($v=='sha_name')
				$value=ucwords($shaOne['fname'].' '.$shaOne['lname']);
			elseif($v=='student_college_id')
				$value=$shaOne['sha_student_no'];
			elseif($v=='sha_dob')
				$value=date('d M Y',strtotime($shaOne['dob']));
			elseif($v=='sha_gender')
				$value=$genderList[$shaOne['gender']];
			elseif($v=='sha_age')
				$value=age_from_dob($shaOne['dob']);
			elseif($v=='sha_email')
				$value=$shaOne['email'];
			elseif($v=='sha_mobile')
				$value=$shaOne['mobile'].' ';
			elseif($v=='booking_number')
				$value=$booking['id'];
			elseif($v=='booking_status')
				$value=$bookingStatusList[$booking['status']];
			elseif($v=='client_name')
				{	
					$clientDetail=clientDetail($shaOne['client']);
					$value=$clientDetail['bname'];
				}
			elseif($v=='client_group')
				{
					if($shaOne['client']!='0')
					{
						$clientGroupList=clientGroupList();
						$clientDetail=clientDetail($shaOne['client']);
						if($clientDetail['client_group']!='')
							$value=$clientGroupList[$clientDetail['client_group']];
					}
				}
			elseif($v=='college_name')
				$value=$shaThree['college'];
			elseif($v=='booking_start_date')
				$value=date('d M Y',strtotime($booking['booking_from']));
			elseif($v=='booking_end_date')
			{
				if($booking['booking_to']!='0000-00-00')
					$value=date('d M Y',strtotime($booking['booking_to'].' +1 day'));
				else
					$value='Not set';	
			}
			elseif($v=='hfa_name')
				$value=ucwords($hfaOne['fname'].' '.$hfaOne['lname']);
			elseif($v=='hfa_address')
			{
				if($hfaOne['street']!='')
					$value .=$hfaOne['street'].", ";
				$value .=ucfirst($hfaOne['suburb']).", ".$stateList[$hfaOne['state']].", ".$hfaOne['postcode'];	
			}
			elseif($v=='hfa_mobile')
				$value=$hfaOne['mobile'];
			elseif($v=='hfa_email')
				$value=$hfaOne['email'];
			elseif($v=='apu')
			{
				if($shaTwo['airport_pickup']=='1')
					$value='Yes';
				else
					$value='No';	
			}
			elseif($v=='apu_company')
			{
				if($shaTwo['apu_company']!='0')
				{
					$apuCompanyDetail=apuCompanyDetail($shaTwo['apu_company']);
					if(!empty($apuCompanyDetail))
						$value=$apuCompanyDetail['company_name'];	 
				}
			}
			elseif($v=='apu_arrival_date')
			{
				if($shaOne['arrival_date']!='0000-00-00')
					$value=dateFormat($shaOne['arrival_date']);
			}
			elseif($v=='apu_arrival_time')
			{
				if($shaTwo['airport_arrival_time']!='00:00:00')
					$value=date('h:i A',strtotime($shaTwo['airport_arrival_time']));
			}
			elseif($v=='apu_flight_number')
				$value=$shaTwo['airport_flightno'];
			elseif($v=='sha_pets')
			{
				  if($shaTwo['live_with_pets']=="0")
					  $value .="No";
				  elseif($shaTwo['live_with_pets']=="1")
					  $value .="Yes";
				  else
					  $value .="n/a";
				  
				  if($shaTwo['live_with_pets']==1)
				  {
						$pets=array();
						if($shaTwo['pet_dog']==1)
							$pets[]='Dog';
						if($shaTwo['pet_cat']==1)
							$pets[]='Cat';
						if($shaTwo['pet_bird']==1)
							$pets[]='Bird';
						if($shaTwo['pet_other']==1 && $shaTwo['pet_other_val']!='')
							$pets[]=ucfirst ($shaTwo['pet_other_val']);	
						
						if(!empty($pets))
							$value .=' - '.implode(', ',$pets);
						
						if($shaTwo['pet_live_inside']==1)
							$value .= ", can live with pets inside the house";
						elseif($shaTwo['pet_live_inside']=="0")
							$value .= ", cannot live with pets inside the house";	
					}
			}
			elseif($v=='sha_kids')
			{
				$value .='0-11 years old: ';
				if($shaThree['live_with_child11']==1)
					$value .="Yes";
				elseif($shaThree['live_with_child11']=="0")	
					$value .="No";
				else
					$value .='n/a';	
				$value .=', ';
				
				$value .='12-20 years old: ';
				if($shaThree['live_with_child20']==1)
					$value .= "Yes";
				elseif($shaThree['live_with_child20']=="0")	
					$value .= "No";
				else
					$value .= 'n/a';
				$value .='';	
				
				if(trim($shaThree['live_with_child_reason'])!='')
					$value .= ', Reason: '.ucfirst ($shaThree['live_with_child_reason']);
			}
			elseif($v=='sha_allergy')
			{
					if($shaThree['allergy_req']=='0')
						$value .="No";
					elseif($shaThree['allergy_req']=='1')
						$value .="Yes ";
					else
						$value .='n/a';
						
					if($shaThree['allergy_req']=='1')
						{
							$allergy=array();
							if($shaThree['allergy_hay_fever']==1)
								$allergy[]='Hay Fever';
							if($shaThree['allergy_asthma']==1)
								$allergy[]='Asthma';
							if($shaThree['allergy_lactose']==1)
								$allergy[]='Lactose Intolerance';
							if($shaThree['allergy_gluten']==1)
								$allergy[]='Gluten Intolerance';	
							if($shaThree['allergy_peanut']==1)
								$allergy[]='Peanut Allergies';	
							if($shaThree['allergy_dust']==1)
								$allergy[]='Dust Allergies';	
							if($shaThree['allergy_other']==1 && $shaThree['allergy_other_val']!='')
								$allergy[]=ucfirst ($shaThree['allergy_other_val']);		
							
							if(!empty($allergy))
								$value .='- '.implode(', ',$allergy);
						}	
			}
			elseif($v=='sha_dietry_requirement')
			{
					if($shaThree['diet_req']=='0')
					  $value .= "No";
				  elseif($shaThree['diet_req']=='1')
					  $value .= "Yes ";
				  else
					   $value .= 'n/a';
					  
				  if($shaThree['diet_req']=='1')
					  {
						  $dietReq=array();
						  if($shaThree['diet_veg']==1)
							  $dietReq[]='Vegetarian';
						  if($shaThree['diet_gluten']==1)
							  $diet[]='Gluten/Lactose Free';
						  if($shaThree['diet_pork']==1)
							  $dietReq[]='No Pork';
						  if($shaThree['diet_food_allergy']==1)
							  $dietReq[]='Food Allergies';	
						  if($shaThree['diet_other']==1 && $shaThree['diet_other_val']!='')
							  $dietReq[]=ucfirst ($shaThree['diet_other_val']);		
						  
						  if(!empty($dietReq))
							  $value .='- '.implode(', ',$dietReq);
					  }
			}
			elseif($v=='sha_medication')
			{
				  if($shaThree['medication']=='1')
					  $value .= 'Yes';
				  elseif($shaThree['medication']=='0')
					  $value .= "No";
				  else 
					  $value .= 'n/a';	
					  
				  if($shaThree['medication']=='1')
					  $value .='- '.$shaThree['medication_desc'];
			}
			elseif($v=='sha_disabilty')
			{
				  if($shaThree['disabilities']=='1')
					  $value .= 'Yes';
				  elseif($shaThree['disabilities']=='0')
					  $value .= "No";
				  else 
					  $value .= 'n/a';	
					  
				  if($shaThree['disabilities']=='1')
					  $value .='- '.$shaThree['disabilities_desc'];
			}
			elseif($v=='sha_smoke')
			{
				  $smokingHabbits=smokingHabbits();
				  if($shaThree['smoker']!='')
					  $value .= str_replace('&amp;','&',$smokingHabbits[$shaThree['smoker']]);
				  else
					  $value .= 'n/a';	
			}
			elseif($v=='sha_smoker_inside')
			{
				  $smokingHabbits=smokingHabbits();
				  if($shaThree['family_include_smoker']!='')
					  $value .= str_replace('&amp;','&',$smokingHabbits[$shaThree['family_include_smoker']]);
				  else
					  $value .= 'n/a';	
			}
			elseif($v=='sha_other_family_pref')
			{
				  if($shaThree['family_pref']!='')
					  $value .= $shaThree['family_pref'];
				  else
					  $value .= 'n/a';
			}
			elseif($v=='course_name')
			{
				if($shaThree['course_name'] && $shaThree['course_start_date'])
				{
				$value = 'Course: '.$shaThree['course_name'].' | Start date: '.date('d M Y',strtotime($shaThree['course_start_date']));
				}
				elseif($shaThree['course_start_date']=='0000-00-00' && !$shaThree['course_name'])
				{
				$value = 'Course not available | Start date not available';
				}
				elseif(!$shaThree['course_name'] && $shaThree['course_start_date'])
				{
				$value = 'Course not available'.' | Start Date: '.date('d M Y',strtotime($shaThree['course_start_date']));
				}
				if($shaThree['course_start_date']=='0000-00-00' && $shaThree['course_name'])
				{
				$value = 'Course: '.$shaThree['course_name'].' | Start date not available';
				}
			}
			elseif($v=='cg_company')
				$value=$caregiverCompany['name'];
			elseif($v=='cg_name')
				$value=$caregiver['fname'].' '.$caregiver['lname'];
			elseif($v=='cg_mobile')
				$value=$caregiver['phone'];
			elseif($v=='cg_email')
				$value=$caregiver['email'];
			elseif($v=='holidays_latest' || $v=='holidays')
			{
				$bookingHolidays=$this->booking_model->holidaysByBooking($booking['id']);
				if(empty($bookingHolidays))
					$value='N/A';
				else	
				{
					if($v=='holidays_latest')
							$value=dateFormat($bookingHolidays[0]['start']).' - '.dateFormat($bookingHolidays[0]['end']);
					elseif($v=='holidays')
					{
						$holidayArray=array();
						foreach($bookingHolidays as $holiday)
							$holidayArray[]=dateFormat($holiday['start']).' - '.dateFormat($holiday['end']);
						$value=implode(' | ',$holidayArray);	
					}
				}
			}
			elseif($v=='homestay_change')
				$value=$this->shaHomestayChangeReportField($shaOne['id']);
			
			$this->excel->getActiveSheet()->setCellValue($k.$x, $value);	
		}
		
		$x++;
	}

	
				$filename='Booking_allocation.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
				//force user to download the Excel file without writing it to server's HD
				//$objWriter->save('php://output');
				$objWriter->save('static/report/'.$filename);
				//$mpdf->Output('static/pdf/invoice.pdf','F');
		//header('location:'.site_url().'reports/hfa');
	}
	
	function wwcc()
	{
			if(checkLogin())
			{
				recentActionsAddData('report','wwcc','view');
				$data['page']='reports-wwcc';
				$this->load->view('system/header',$data);
				$this->load->view('system/reports/wwcc_report');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
	}
	
	function wwcc_submit()
	{
		$data=$_POST;
		//see($data);die(1);
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('test worksheet');
		
		$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
				'font'=>array(
				'name'      =>  'Arial',
				'size'      =>  10,
			)
		));
		
		$fields=array();
		$fieldIndex=$lastIndex='A';
		
		foreach($data['WR_field'] as $hr_field)
		{
			$fields[$fieldIndex]=$hr_field;
			$lastIndex=$fieldIndex;
			$fieldIndex++;
		}
		
		foreach ($fields as $fieldK=>$field)
	   	$this->excel->getActiveSheet()->getColumnDimension($fieldK)->setAutosize(true);
	   
	  $x_start=1;
	  $reportFields=wwcc_report_fields();
	  foreach($fields as $k=>$v)
	  {
		  $colHeading=$reportFields[$v];
		  $this->excel->getActiveSheet()->setCellValue($k.$x_start, $colHeading);
	  }
		  
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getFont()->setSize(10)->setBold(true);  
		
		$x=$x_start+1;
		
	$this->load->model('report_model');
	$members=$this->report_model->membersListForWwccReport($data);
	
	$wwccStatusList=wwccStatusList();
	
	foreach($members as $mem)
	{
		$memberage=exact_age_from_dob($mem['dob']);
		$wwccexpired=check_wwcc_expiry($mem['wwcc_expiry']);
		
		if($memberage<18 ) 
			$wwccStatus='6';
		elseif($mem['wwcc']=="0")
			$wwccStatus='1';
		elseif($mem['wwcc']=="1" && $mem['wwcc_file']=="")
		{
			if($wwccexpired!="expired")
				$wwccStatus='2';
			else
				$wwccStatus='4';
		}
		elseif($mem['wwcc']=="1" && $mem['wwcc_file']!="")
		{
			if($wwccexpired!="expired")
				$wwccStatus='3';
			else
				$wwccStatus='4';
		}
		elseif($memberage>17 && $mem['wwcc']=='')
			  $wwccStatus='5';
		
		if(!in_array($wwccStatus,$data['WR_wStatus']))
			continue;
								
		foreach($fields as $k=>$v)
		{
			$value='';
			if($v=='hfa_id')
				$value=$mem['application_id'];
			elseif($v=='hfa_name')
				$value=ucwords($mem['hfaOne_fname'].' '.$mem['hfaOne_lname']);
			elseif($v=='hfa_member_name')
				$value=ucwords($mem['fname'].' '.$mem['lname']);
			elseif($v=='clearence_number')
			{
				if($mem['wwcc']=='1' && $mem['wwcc_clearence']=='1')
					$value=$mem['wwcc_clearence_no'];
			}
			elseif($v=='expiry_date')
			{
				if($mem['wwcc']=='1' && $mem['wwcc_clearence']=='1' && $mem['wwcc_expiry']!='0000-00-00')
					$value=date('d M Y',strtotime($mem['wwcc_expiry']));
			}
			elseif($v=='application_number')
			{
				if($mem['wwcc']=='1' && $mem['wwcc_clearence']=='0')
					$value=$mem['wwcc_application_no'];
			}
			elseif($v=='document_uploaded')
			{
				if($wwccStatus=='2')
					$value='No';
				elseif($wwccStatus=='3')
					$value='Yes';	
			}
			elseif($v=='wwcc_status')
				$value=$wwccStatusList[$wwccStatus];
			
			$this->excel->getActiveSheet()->setCellValue($k.$x, $value);	
		}
		
		$x++;
	}

	
				$filename='wwcc_report.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
				//force user to download the Excel file without writing it to server's HD
				//$objWriter->save('php://output');
				$objWriter->save('static/report/'.$filename);
				//$mpdf->Output('static/pdf/invoice.pdf','F');
		//header('location:'.site_url().'reports/hfa');
	}
	
	function insurance()
	{
			if(checkLogin())
			{
				recentActionsAddData('report','insurance','view');
				$data['page']='reports-insurance';
				$this->load->view('system/header',$data);
				$this->load->view('system/reports/insurance_report');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
	}
	
	function insurance_submit()
	{
		$data=$_POST;
		//see($data);die(1);
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('test worksheet');
		
		$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
				'font'=>array(
				'name'      =>  'Arial',
				'size'      =>  10,
			)
		));
		
		$fields=array();
		$fieldIndex=$lastIndex='A';
		
		foreach($data['WR_field'] as $hr_field)
		{
			$fields[$fieldIndex]=$hr_field;
			$lastIndex=$fieldIndex;
			$fieldIndex++;
		}
		
		foreach ($fields as $fieldK=>$field)
	   	$this->excel->getActiveSheet()->getColumnDimension($fieldK)->setAutosize(true);
	   
	  $x_start=1;
	  $reportFields=insurance_report_fields();
	  foreach($fields as $k=>$v)
	  {
		  if($v=='id')
			  $colHeading='Host id';
		  else 
			  $colHeading=$reportFields[$v];
		  $this->excel->getActiveSheet()->setCellValue($k.$x_start, $colHeading);
	  }
		  
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getFont()->setSize(10)->setBold(true);  
		
		$x=$x_start+1;
		
	$this->load->model('report_model');
	$host=$this->report_model->hfaListForInsuranceReport($data);
	
	$insuranceStatusList=insuranceStatusList();
	
	foreach($host as $hfa)
	{
		$insurance=$hfa['insurance'];
		
		if($insurance=="0")
			$insStatus='2';
		elseif($insurance=="1")
		{
			if(($hfa['ins_expiry']!='0000-00-00') && strtotime($hfa['ins_expiry'])<strtotime(date('Y-m-d')))
					$insStatus='3';
			else
				$insStatus='1';
		}
		
		if(!in_array($insStatus,$data['WR_wStatus']))
			continue;
		
		$insProvider='';
		$insPolicyNo='';
		$insExpiry='';
		$docUploaded='No';
		$million20='No';
		
		if($insurance=="1")
		{
			$insProvider=$hfa['ins_provider'];
			$insPolicyNo=$hfa['ins_policy_no'];
			if($hfa['ins_expiry']!='0000-00-00')
				$insExpiry=date('d M Y',strtotime($hfa['ins_expiry']));
			if($hfa['ins_file']!='')	
				$docUploaded='Yes';	
			if($hfa['20_million']=='1')	
				$million20='Yes';	
		}
								
		foreach($fields as $k=>$v)
		{
			$value='';
			
			if($v=='id')
				$value=$hfa['id'];
			elseif($v=='hfa_name')
				$value=ucwords($hfa['fname'].' '.$hfa['fname']);
			elseif($v=='ins_provider')
				$value=$insProvider;
			elseif($v=='ins_policy_number')
				$value=$insPolicyNo;
			elseif($v=='expiry_date')
				$value=$insExpiry;
			elseif($v=='document_uploaded')
				$value=$docUploaded;
			elseif($v=='20_million')
				$value=$million20;
			elseif($v=='insurance_status')
				$value=$insuranceStatusList[$insStatus];
			
			$this->excel->getActiveSheet()->setCellValue($k.$x, $value);	
		}
		
		$x++;
	}

	
				$filename='insurance_report.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
				//force user to download the Excel file without writing it to server's HD
				//$objWriter->save('php://output');
				$objWriter->save('static/report/'.$filename);
				//$mpdf->Output('static/pdf/invoice.pdf','F');
		//header('location:'.site_url().'reports/hfa');
	}
	
	function feedback()
	{
			if(checkLogin())
			{
				recentActionsAddData('report','feedback','view');
				$data['page']='reports-feedback';
				$this->load->view('system/header',$data);
				$this->load->view('system/reports/feedback_report');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
	}
	
	function feedback_submit()
	{
		$data=$_POST;
		//see($data);die(1);
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('test worksheet');
		
		$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
				'font'=>array(
				'name'      =>  'Arial',
				'size'      =>  10,
			)
		));
		
		$fields=array();
		$fieldIndex=$lastIndex='A';
		
		foreach($data['IR_field'] as $hr_field)
		{
			$fields[$fieldIndex]=$hr_field;
			$lastIndex=$fieldIndex;
			$fieldIndex++;
		}
		
		foreach ($fields as $fieldK=>$field)
	   	$this->excel->getActiveSheet()->getColumnDimension($fieldK)->setAutosize(true);
	   
	  $x_start=1;
	  $reportFields=feedbacks_report_fields();
	  foreach($fields as $k=>$v)
	  {
		  $colHeading=$reportFields[$v];
		  $this->excel->getActiveSheet()->setCellValue($k.$x_start, $colHeading);
	  }
		  
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getFont()->setSize(10)->setBold(true);  
		
		$x=$x_start+1;
		
	$this->load->model('report_model');
	$feedbacks=$this->report_model->feedbackListForFeedbackReport($data);//echo $this->db->last_query();
	//see($feedbacks);see($reportFields);
	foreach($feedbacks as $feed)
	{	
		$shaOne=getShaOneAppDetails($feed['sha_id']);			
		foreach($fields as $k=>$v)
		{
			$value='';
			
			if($v=='sha_name')
				$value=$feed['student_name'];
			elseif($v=='sha_college_id')
				$value=$feed['sha_college_id'];
			elseif($v=='sha_college_name')
				$value=$feed['student_college'];
			elseif($v=='host_name')
				$value=$feed['host_name'];
			elseif($v=='host_address')
				$value=$feed['host_address'];
			elseif($v=='host_address')
				$value=date('d M Y',strtotime($feed['move_in_date']));
			elseif($v=='apu')
			{
				if($feed['apu']=='0')
					$value='No';
				else if($feed['apu']=='1')
					$value='Yes';
			}
			elseif($v=='apu_satisfied')
			{
				if($feed['apu_satisfied']=='0')
					$value='No';
				else if($feed['apu']=='1')
					$value='Yes';
				if($feed['apu_desc']!='' && $value!='')
					$value .=', ';
				if($feed['apu_desc']!='')
					$value .=$feed['apu_desc'];
			}
			elseif($v=='host_comfort')
				$value=ucfirst(str_replace('_',' ',$feed['host_comfort']));
			elseif($v=='host_friendly')
				$value=ucfirst(str_replace('_',' ',$feed['host_friendly']));
			elseif($v=='host_food')
				$value=ucfirst(str_replace('_',' ',$feed['host_food']));
			elseif($v=='host_overall')
				$value=ucfirst(str_replace('_',' ',$feed['host_overall']));
			elseif($v=='testimonial')
				$value=$feed['testimonials'];
			elseif($v=='comments'){
				$value=$feed['comments'];}
			elseif($v=='feedback_date')
				$value=date('d M Y',strtotime($feed['date']));
			elseif($v=='client')
				{	
					$clientDetail=clientDetail($shaOne['client']);
					$value=$clientDetail['bname'];
				}
			elseif($v=='client_group')
				{
					if($shaOne['client']!='0')
					{
						$clientGroupList=clientGroupList();
						$clientDetail=clientDetail($shaOne['client']);
						if($clientDetail['client_group']!='')
							$value=$clientGroupList[$clientDetail['client_group']];
					}
				}
			
			$this->excel->getActiveSheet()->setCellValue($k.$x, $value);	
		}
		
		$x++;
	}

	
				$filename='feedback_report.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
				//force user to download the Excel file without writing it to server's HD
				//$objWriter->save('php://output');
				$objWriter->save('static/report/'.$filename);
				//$mpdf->Output('static/pdf/invoice.pdf','F');
		//header('location:'.site_url().'reports/hfa');
	}
	
	function feedbackEmails_submit()
	{
		$data=$_POST;
		//see($data);die(1);
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('test worksheet');
		
		$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
				'font'=>array(
				'name'      =>  'Arial',
				'size'      =>  10,
			)
		));
		
		$fields=array();
		$fieldIndex=$lastIndex='A';
		
		foreach($data['FES_field'] as $hr_field)
		{
			$fields[$fieldIndex]=$hr_field;
			$lastIndex=$fieldIndex;
			$fieldIndex++;
		}
		
		foreach ($fields as $fieldK=>$field)
	   	$this->excel->getActiveSheet()->getColumnDimension($fieldK)->setAutosize(true);
	   
	  $x_start=1;
	  $reportFields=feedbackEmailsSent_report_fields();
	  foreach($fields as $k=>$v)
	  {
		  $colHeading=$reportFields[$v];
		  $this->excel->getActiveSheet()->setCellValue($k.$x_start, $colHeading);
	  }
		  
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getFont()->setSize(10)->setBold(true);  
		
		$x=$x_start+1;
		
	$this->load->model('report_model');
	$feedbacks=$this->report_model->feedbackListForFeedbackEmailsReport($data);//echo $this->db->last_query();
	//see($feedbacks);see($reportFields);
	foreach($feedbacks as $feed)
	{	
		$shaOne=getShaOneAppDetails($feed['sha_id']);			
		$shaThree=getShaThreeAppDetails($feed['sha_id']);			
		foreach($fields as $k=>$v)
		{
			$value='';
			
			if($v=='sha_name')
				$value=$shaOne['fname'].' '.$shaOne['lname'];
			elseif($v=='sha_college_name')
				$value=$shaThree['college'];
			elseif($v=='email_id')
				$value=$shaOne['email'];
			elseif($v=='email_date')
				$value=date('d M Y',strtotime($feed['sent_on']));
			elseif($v=='email_time')
				$value=date('g:i a',strtotime($feed['sent_on']));
			
			$this->excel->getActiveSheet()->setCellValue($k.$x, $value);	
		}
		
		$x++;
	}

	
				$filename='feedbackEmails_report.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
				//force user to download the Excel file without writing it to server's HD
				//$objWriter->save('php://output');
				$objWriter->save('static/report/'.$filename);
				//$mpdf->Output('static/pdf/invoice.pdf','F');
		//header('location:'.site_url().'reports/hfa');
	}
	
	function booking_duration()
	{
			if(checkLogin())
			{
				if(userAuthorisations('booking_duration_report'))
				{
					recentActionsAddData('report','booking_duration','view');
					$data['page']='reports-booking_duration';
					$this->load->view('system/header',$data);
					$this->load->view('system/reports/booking_duration_report');
					$this->load->view('system/footer');
				}
				else
					redirectToLogin();
			}
			else
				redirectToLogin();
	}
	
	function booking_duration_submit()
	{
		if(userAuthorisations('booking_duration_report'))
		{
				$data=$_POST;
				//see($data);die(1);
				$data['default_endDate']=normalToMysqlDate($data['default_endDate']);
				
				$this->load->library('excel');
				$this->excel->setActiveSheetIndex(0);
				$this->excel->getActiveSheet()->setTitle('test worksheet');
				
				$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
						'font'=>array(
						'name'      =>  'Arial',
						'size'      =>  10,
					)
				));
				
				$fields=array();
				$fieldIndex=$lastIndex='A';
				
				foreach($data['CaR_field'] as $hr_field)
				{
					$fields[$fieldIndex]=$hr_field;
					$lastIndex=$fieldIndex;
					$fieldIndex++;
				}
				
				foreach ($fields as $fieldK=>$field)
				$this->excel->getActiveSheet()->getColumnDimension($fieldK)->setAutosize(true);
			   
			  $x_start=1;
			  $reportFields=booking_duration_report_fields();
			  foreach($fields as $k=>$v)
			  {
				  $colHeading=$reportFields[$v];
				  $this->excel->getActiveSheet()->setCellValue($k.$x_start, $colHeading);
			  }
				  
				$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
				$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getFont()->setSize(10)->setBold(true);  
				
				$x=$x_start+1;
				
			$this->load->model('report_model');
			$bookings=$this->report_model->bookingListForAuditingReport($data);
			
			$stateList=stateList();
			$genderList=genderList();
			$bookingStatusList=bookingStatusList();
			
			foreach($bookings as $booking)
			{
				if($booking['serviceOnlyBooking']=='1')
					continue;
				$shaOne=getShaOneAppDetails($booking['student']);
				$shaTwo=getShaTwoAppDetails($booking['student']);
				$shaThree=getShaThreeAppDetails($booking['student']);
				$hfaOne=getHfaOneAppDetails($booking['host']);
				foreach($fields as $k=>$v)
				{
					$value='';
					if($v=='sha_name')
						$value=ucwords($shaOne['fname'].' '.$shaOne['lname']);
					elseif($v=='student_college_id')
						$value=$shaOne['sha_student_no'];
					elseif($v=='sha_dob')
						$value=date('d M Y',strtotime($shaOne['dob']));
					elseif($v=='sha_gender')
						$value=$genderList[$shaOne['gender']];
					elseif($v=='sha_age')
						$value=age_from_dob($shaOne['dob']);
					elseif($v=='booking_number')
						$value=$booking['id'];
					elseif($v=='booking_status')
						$value=$bookingStatusList[$booking['status']];
					elseif($v=='client_name')
						{	
							$clientDetail=clientDetail($shaOne['client']);
							$value=$clientDetail['bname'];
						}
					elseif($v=='client_group')
						{
							if($shaOne['client']!='0')
							{
								$clientGroupList=clientGroupList();
								$clientDetail=clientDetail($shaOne['client']);
								if($clientDetail['client_group']!='')
									$value=$clientGroupList[$clientDetail['client_group']];
							}
						}
					elseif($v=='college_name')
						$value=$shaThree['college'];
					elseif($v=='booking_start_date')
						$value=date('d M Y',strtotime($booking['booking_from']));
					elseif($v=='booking_end_date')
					{
						if($booking['booking_to']!='0000-00-00')
							$value=date('d M Y',strtotime($booking['booking_to'].' +1 day'));
						else
							$value='Not set';	
					}
					elseif($v=='hfa_name')
						$value=ucwords($hfaOne['fname'].' '.$hfaOne['lname']);
					elseif($v=='hfa_address')
					{
						if($hfaOne['street']!='')
							$value .=$hfaOne['street'].", ";
						$value .=ucfirst($hfaOne['suburb']).", ".$stateList[$hfaOne['state']].", ".$hfaOne['postcode'];	
					}
					elseif($v=='hfa_mobile')
						$value=$hfaOne['mobile'];
					elseif($v=='hfa_email')
						$value=$hfaOne['email'];
					elseif($v=='apu')
					{
						if($shaTwo['airport_pickup']=='1')
							$value='Yes';
						else
							$value='No';	
					}
					elseif($v=='apu_company')
					{
						if($shaTwo['apu_company']!='0')
						{
							$apuCompanyDetail=apuCompanyDetail($shaTwo['apu_company']);
							if(!empty($apuCompanyDetail))
								$value=$apuCompanyDetail['company_name'];	 
						}
					}
					elseif($v=='apu_arrival_date')
					{
						if($shaOne['arrival_date']!='0000-00-00')
							$value=dateFormat($shaOne['arrival_date']);
					}
					elseif($v=='apu_arrival_time')
					{
						if($shaTwo['airport_arrival_time']!='00:00:00')
							$value=date('h:i A',strtotime($shaTwo['airport_arrival_time']));
					}
					elseif($v=='apu_flight_number')
						$value=$shaTwo['airport_flightno'];
					elseif($v=='nominated_regular')
					{
							$value='Regular';
							if($shaOne['homestay_nomination']=='1')
							{
								$value='To be reviewed';	
								if($hfaOne['id']==$shaOne['nominated_hfa_id'])
									$value='Nominated';
							}
					}
					elseif($v=='duration')
					{
						if($booking['booking_to']!='0000-00-00')
							$bookingDuration=dayDiff($booking['booking_from'],$booking['booking_to']);
						else
							$bookingDuration=dayDiff($booking['booking_from'],$data['default_endDate']);	
						$value .=$bookingDuration.' day'.s($bookingDuration);
					}
					elseif($v=='homestay_change')
						$value=$this->shaHomestayChangeReportField($shaOne['id']);
					
					$this->excel->getActiveSheet()->setCellValue($k.$x, $value);	
				}
				
				$x++;
			}
		
			
						$filename='Booking_duration.xls'; //save our workbook as this file name
						header('Content-Type: application/vnd.ms-excel'); //mime type
						header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
						header('Cache-Control: max-age=0'); //no cache
									 
						//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
						//if you want to save it as .XLSX Excel 2007 format
						$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
						//force user to download the Excel file without writing it to server's HD
						//$objWriter->save('php://output');
						$objWriter->save('static/report/'.$filename);
						//$mpdf->Output('static/pdf/invoice.pdf','F');
				//header('location:'.site_url().'reports/hfa');
		}
		else
			redirectToLogin();
	}
	
	function parent_nominated_homestay()
	{
			if(checkLogin())
			{
					recentActionsAddData('report','parent_nominated_homestay','view');
					$data['page']='reports-parent_nominated_homestay';
					$this->load->view('system/header',$data);
					$this->load->view('system/reports/booking_duration_report');
					$this->load->view('system/footer');
			}
			else
				redirectToLogin();
	}
	
	function parent_nominated_homestay_submit()
	{
				$data=$_POST;
				//see($data);die(1);
				$data['default_endDate']=normalToMysqlDate($data['default_endDate']);
				
				$this->load->library('excel');
				$this->excel->setActiveSheetIndex(0);
				$this->excel->getActiveSheet()->setTitle('test worksheet');
				
				$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
						'font'=>array(
						'name'      =>  'Arial',
						'size'      =>  10,
					)
				));
				
				$fields=array();
				$fieldIndex=$lastIndex='A';
				
				foreach($data['CaR_field'] as $hr_field)
				{
					$fields[$fieldIndex]=$hr_field;
					$lastIndex=$fieldIndex;
					$fieldIndex++;
				}
				
				foreach ($fields as $fieldK=>$field)
				$this->excel->getActiveSheet()->getColumnDimension($fieldK)->setAutosize(true);
			   
			  $x_start=1;
			  $reportFields=booking_duration_report_fields();
			  foreach($fields as $k=>$v)
			  {
				  $colHeading=$reportFields[$v];
				  $this->excel->getActiveSheet()->setCellValue($k.$x_start, $colHeading);
			  }
				  
				$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
				$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getFont()->setSize(10)->setBold(true);  
				
				$x=$x_start+1;
				
			$this->load->model('report_model');
			$bookings=$this->report_model->bookingListForAuditingReport($data);
			
			$stateList=stateList();
			$genderList=genderList();
			$bookingStatusList=bookingStatusList();
			
			foreach($bookings as $booking)
			{
				if($booking['serviceOnlyBooking']=='1')
					continue;
				$shaOne=getShaOneAppDetails($booking['student']);
				$shaTwo=getShaTwoAppDetails($booking['student']);
				$shaThree=getShaThreeAppDetails($booking['student']);
				$hfaOne=getHfaOneAppDetails($booking['host']);
				
				if($shaOne['homestay_nomination']=='1')
				{
					if($hfaOne['id']!=$shaOne['nominated_hfa_id'] && $data['nominationSettingLink']=='yes')
						continue;
				}
				else
					continue;
				
				foreach($fields as $k=>$v)
				{
					$value='';
					if($v=='sha_name')
						$value=ucwords($shaOne['fname'].' '.$shaOne['lname']);
					elseif($v=='student_college_id')
						$value=$shaOne['sha_student_no'];
					elseif($v=='sha_dob')
						$value=date('d M Y',strtotime($shaOne['dob']));
					elseif($v=='sha_gender')
						$value=$genderList[$shaOne['gender']];
					elseif($v=='sha_age')
						$value=age_from_dob($shaOne['dob']);
					elseif($v=='booking_number')
						$value=$booking['id'];
					elseif($v=='booking_status')
						$value=$bookingStatusList[$booking['status']];
					elseif($v=='client_name')
						{	
							$clientDetail=clientDetail($shaOne['client']);
							$value=$clientDetail['bname'];
						}
					elseif($v=='client_group')
						{
							if($shaOne['client']!='0')
							{
								$clientGroupList=clientGroupList();
								$clientDetail=clientDetail($shaOne['client']);
								if($clientDetail['client_group']!='')
									$value=$clientGroupList[$clientDetail['client_group']];
							}
						}
					elseif($v=='college_name')
						$value=$shaThree['college'];
					elseif($v=='booking_start_date')
						$value=date('d M Y',strtotime($booking['booking_from']));
					elseif($v=='booking_end_date')
					{
						if($booking['booking_to']!='0000-00-00')
							$value=date('d M Y',strtotime($booking['booking_to'].' +1 day'));
						else
							$value='Not set';	
					}
					elseif($v=='hfa_name')
						$value=ucwords($hfaOne['lname']).' Family';
					elseif($v=='hfa_address')
					{
						if($hfaOne['street']!='')
							$value .=$hfaOne['street'].", ";
						$value .=ucfirst($hfaOne['suburb']).", ".$stateList[$hfaOne['state']].", ".$hfaOne['postcode'];	
					}
					elseif($v=='hfa_mobile')
						$value=$hfaOne['mobile'];
					elseif($v=='hfa_email')
						$value=$hfaOne['email'];
					elseif($v=='apu')
					{
						if($shaTwo['airport_pickup']=='1')
							$value='Yes';
						else
							$value='No';	
					}
					elseif($v=='apu_company')
					{
						if($shaTwo['apu_company']!='0')
						{
							$apuCompanyDetail=apuCompanyDetail($shaTwo['apu_company']);
							if(!empty($apuCompanyDetail))
								$value=$apuCompanyDetail['company_name'];	 
						}
					}
					elseif($v=='apu_arrival_date')
					{
						if($shaOne['arrival_date']!='0000-00-00')
							$value=dateFormat($shaOne['arrival_date']);
					}
					elseif($v=='apu_arrival_time')
					{
						if($shaTwo['airport_arrival_time']!='00:00:00')
							$value=date('h:i A',strtotime($shaTwo['airport_arrival_time']));
					}
					elseif($v=='apu_flight_number')
						$value=$shaTwo['airport_flightno'];
					elseif($v=='nominated_regular')
					{
							$value='Regular';
							if($shaOne['homestay_nomination']=='1')
							{
								$value='To be reviewed';	
								if($hfaOne['id']==$shaOne['nominated_hfa_id'])
									$value='Nominated';
							}
					}
					elseif($v=='duration')
					{
						if($booking['booking_to']!='0000-00-00')
							$bookingDuration=dayDiff($booking['booking_from'],$booking['booking_to']);
						else
							$bookingDuration=dayDiff($booking['booking_from'],$data['default_endDate']);	
						$value .=$bookingDuration.' day'.s($bookingDuration);
					}
					
					$this->excel->getActiveSheet()->setCellValue($k.$x, $value);	
				}
				
				$x++;
			}
		
			
						$filename='Parent_nominated_homestay.xls'; //save our workbook as this file name
						header('Content-Type: application/vnd.ms-excel'); //mime type
						header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
						header('Cache-Control: max-age=0'); //no cache
									 
						//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
						//if you want to save it as .XLSX Excel 2007 format
						$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
						//force user to download the Excel file without writing it to server's HD
						//$objWriter->save('php://output');
						$objWriter->save('static/report/'.$filename);
						//$mpdf->Output('static/pdf/invoice.pdf','F');
				//header('location:'.site_url().'reports/hfa');
	}
	
	function caregiving_service()
	{
			if(checkLogin())
			{
					recentActionsAddData('report','caregiving_service','view');
					$data['page']='reports-caregiving_service';
					$this->load->view('system/header',$data);
					$this->load->view('system/reports/caregiving_service_report');
					$this->load->view('system/footer');
			}
			else
				redirectToLogin();
	}
	
	function caregiving_service_submit()
	{
				$data=$_POST;
				//see($data);die(1);
				
				
				$this->load->library('excel');
				$this->excel->setActiveSheetIndex(0);
				$this->excel->getActiveSheet()->setTitle('test worksheet');
				
				$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
						'font'=>array(
						'name'      =>  'Arial',
						'size'      =>  10,
					)
				));
				
				$fields=array();
				$fieldIndex=$lastIndex='A';
				
				foreach($data['CaR_field'] as $hr_field)
				{
					$fields[$fieldIndex]=$hr_field;
					$lastIndex=$fieldIndex;
					$fieldIndex++;
				}
				
				foreach ($fields as $fieldK=>$field)
				$this->excel->getActiveSheet()->getColumnDimension($fieldK)->setAutosize(true);
			   
			  $x_start=1;
			  $reportFields=caregiving_service_report_fields();
			  foreach($fields as $k=>$v)
			  {
				  $colHeading=$reportFields[$v];
				  $this->excel->getActiveSheet()->setCellValue($k.$x_start, $colHeading);
			  }
				  
				$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
				$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getFont()->setSize(10)->setBold(true);  
				
				$x=$x_start+1;
				
			$this->load->model('report_model');
			$bookings=$this->report_model->bookingListForCGServiceReport($data);//die(0);
			
			$stateList=stateList();
			$genderList=genderList();
			$bookingStatusList=bookingStatusList();
			
			foreach($bookings as $booking)
			{
				if($booking['serviceOnlyBooking']=='1')
					continue;
				$shaOne=getShaOneAppDetails($booking['student']);
				$shaTwo=getShaTwoAppDetails($booking['student']);
				$shaThree=getShaThreeAppDetails($booking['student']);
				$hfaOne=getHfaOneAppDetails($booking['host']);
				$caregiver=getCaregiverDetail($shaTwo['guardian_assigned']);
				$caregiverCompany=getCaregiverCompanyDetail($caregiver['company']);
			
				foreach($fields as $k=>$v)
				{
					$value='';
					if($v=='sha_name')
						$value=ucwords($shaOne['fname'].' '.$shaOne['lname']);
					elseif($v=='student_college_id')
						$value=$shaOne['sha_student_no'];
					elseif($v=='sha_dob')
						$value=date('d M Y',strtotime($shaOne['dob']));
					elseif($v=='sha_gender')
						$value=$genderList[$shaOne['gender']];
					elseif($v=='sha_age')
						$value=age_from_dob($shaOne['dob']);
					elseif($v=='booking_number')
						$value=$booking['id'];
					elseif($v=='booking_status')
						$value=$bookingStatusList[$booking['status']];
					elseif($v=='client_name')
						{	
							$clientDetail=clientDetail($shaOne['client']);
							$value=$clientDetail['bname'];
						}
					elseif($v=='client_group')
						{
							if($shaOne['client']!='0')
							{
								$clientGroupList=clientGroupList();
								$clientDetail=clientDetail($shaOne['client']);
								if($clientDetail['client_group']!='')
									$value=$clientGroupList[$clientDetail['client_group']];
							}
						}
					elseif($v=='college_name')
						$value=$shaThree['college'];
					elseif($v=='booking_start_date')
						$value=date('d M Y',strtotime($booking['booking_from']));
					elseif($v=='booking_end_date')
					{
						if($booking['booking_to']!='0000-00-00')
							$value=date('d M Y',strtotime($booking['booking_to'].' +1 day'));
						else
							$value='Not set';	
					}
					elseif($v=='hfa_name')
						$value=ucwords($hfaOne['lname']).' Family';
					elseif($v=='hfa_address')
					{
						if($hfaOne['street']!='')
							$value .=$hfaOne['street'].", ";
						$value .=ucfirst($hfaOne['suburb']).", ".$stateList[$hfaOne['state']].", ".$hfaOne['postcode'];	
					}
					elseif($v=='hfa_mobile')
						$value=$hfaOne['mobile'];
					elseif($v=='hfa_email')
						$value=$hfaOne['email'];
					elseif($v=='cg_company')
						$value=$caregiverCompany['name'];
					elseif($v=='cg_name')
						$value=$caregiver['fname'].' '.$caregiver['lname'];
					elseif($v=='cg_mobile')
						$value=$caregiver['phone'];
					elseif($v=='cg_email')
						$value=$caregiver['email'];
					
					$this->excel->getActiveSheet()->setCellValue($k.$x, $value);	
				}
				
				$x++;
			}
		
			
						$filename='Caregiving_service.xls'; //save our workbook as this file name
						header('Content-Type: application/vnd.ms-excel'); //mime type
						header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
						header('Cache-Control: max-age=0'); //no cache
									 
						//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
						//if you want to save it as .XLSX Excel 2007 format
						$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
						//force user to download the Excel file without writing it to server's HD
						//$objWriter->save('php://output');
						$objWriter->save('static/report/'.$filename);
						//$mpdf->Output('static/pdf/invoice.pdf','F');
				//header('location:'.site_url().'reports/hfa');
	}
	
	function invoice()
	{
			if(checkLogin())
			{
				recentActionsAddData('report','invoice','view');
				$data['page']='reports-invoice';
				$this->load->view('system/header',$data);
				$this->load->view('system/reports/invoice_report');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
	}
	
	function booking_regularCheckups()
	{
			if(checkLogin())
			{
				recentActionsAddData('report','booking_regularCheckup','view');
				$data['page']='reports-bookings_regularCheckup';
				$this->load->view('system/header',$data);
				$this->load->view('system/reports/bookings_regularCheckups');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
	}
	
	function booking_regularCheckups_submit()
	{
		$data=$_POST;
		//see($data);die(1);
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('test worksheet');
		
		$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
				'font'=>array(
				'name'      =>  'Arial',
				'size'      =>  10,
			)
		));
		
		$fields=array();
		$fieldIndex=$lastIndex='A';
		
		foreach($data['CaR_field'] as $hr_field)
		{
			$fields[$fieldIndex]=$hr_field;
			$lastIndex=$fieldIndex;
			$fieldIndex++;
		}
		//see($fields);
		foreach ($fields as $fieldK=>$field){//echo $fieldK.', ';
	   	$this->excel->getActiveSheet()->getColumnDimension($fieldK)->setAutosize(true);}
	   
	  $x_start=1;
	  $reportFields=bookingsRegularCheckups_report_fields();
	  foreach($fields as $k=>$v)
	  {
		  $colHeading=$reportFields[$v];
		  $this->excel->getActiveSheet()->setCellValue($k.$x_start, $colHeading);
	  }
		  
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getFont()->setSize(10)->setBold(true);  
		
		$x=$x_start+1;
		
	$this->load->model('report_model');
	$bookings=$this->report_model->bookingListForBookingCheckupReport($data);//see($bookings);
	
	$stateList=stateList();
	$genderList=genderList();
	$bookingStatusList=bookingStatusList();
	//see($fields);
	foreach($bookings as $booking)
	{
		$shaOne=getShaOneAppDetails($booking['student']);
		$shaTwo=getShaTwoAppDetails($booking['student']);
		$shaThree=getShaThreeAppDetails($booking['student']);
		$hfaOne=getHfaOneAppDetails($booking['host']);
		foreach($fields as $k=>$v)
		{
			$value='';
			if($v=='sha_name')
				$value=ucwords($shaOne['fname'].' '.$shaOne['lname']);
			elseif($v=='student_college_id')
				$value=$shaOne['sha_student_no'];
			elseif($v=='college_name')
				$value=$shaThree['college'];
			elseif($v=='booking_number')
				$value=$booking['id'];
			elseif($v=='booking_start_date')
				$value=date('d M Y',strtotime($booking['booking_from']));
			elseif($v=='booking_end_date')
			{
				if($booking['booking_to']!='0000-00-00')
					$value=date('d M Y',strtotime($booking['booking_to'].' +1 day'));
				else
					$value='Not set';	
			}
			elseif($v=='hfa_name')
				$value=ucwords($hfaOne['lname']).' Family';
			elseif($v=='booking_checkupDate')
				$value=date('d M Y',strtotime($booking['checkup_date']));
			elseif($v=='booking_checkupNotes')
				$value=$booking['checkup_notes'];
			
			$this->excel->getActiveSheet()->setCellValue($k.$x, $value);	
		}
		
		$x++;
	}

	
				$filename='Booking_checkups.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
				//force user to download the Excel file without writing it to server's HD
				//$objWriter->save('php://output');
				$objWriter->save('static/report/'.$filename);
				//$mpdf->Output('static/pdf/invoice.pdf','F');
		//header('location:'.site_url().'reports/hfa');
	}
	
	function shaHomestayChangeReportField($shaId)
	{
		$return='No';
		$duplicateShaSet=getDuplicateShaSet($shaId);
		$homechangedCount=-1;
		foreach($duplicateShaSet as $sha)
		{
			$booking=bookingByShaId($sha);
			if(!empty($booking))
				$homechangedCount++;
		}
		if($homechangedCount>0)
			$return='Yes ('.$homechangedCount.' time'.s($homechangedCount).')';
		return $return;	
	}
	
	function profit()
	{
		if(checkLogin())
			{
				recentActionsAddData('report','profit','view');
				$data['page']='reports-profit';
				$this->load->view('system/header',$data);
				$this->load->view('system/reports/profit');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
	}
	
	function profit_submit()
	{
		$data=$_POST;
		//see($data);die(1);
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('test worksheet');
		
		$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
				'font'=>array(
				'name'      =>  'Arial',
				'size'      =>  10,
			)
		));
		
		$fields=array();
		$fieldIndex=$lastIndex='A';
		
		foreach($data['CaR_field'] as $hr_field)
		{
			$fields[$fieldIndex]=$hr_field;
			$lastIndex=$fieldIndex;
			$fieldIndex++;
		}
		//see($fields);
		foreach ($fields as $fieldK=>$field){//echo $fieldK.', ';
	   	$this->excel->getActiveSheet()->getColumnDimension($fieldK)->setAutosize(true);}
	   
	  $x_start=1;
	  $reportFields=profit_report_fields();
	  foreach($fields as $k=>$v)
	  {
		  $colHeading=$reportFields[$v];
		  $this->excel->getActiveSheet()->setCellValue($k.$x_start, $colHeading);
	  }
		  
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getFont()->setSize(10)->setBold(true);  
		
		$x=$x_start+1;
		
	$this->load->model('report_model');
	$bookings=$this->report_model->bookingListForProfitReport($data);//echo $this->db->last_query();see($bookings);die('dddd');
	
	
	$this->load->model('booking_model');
	$this->load->model('Bmargin_model');
	
	$stateList=stateList();
	$genderList=genderList();
	$bookingStatusList=bookingStatusList();
	//see($fields);
	foreach($bookings as $booking)
	{
		
	$_POST['marginBookingId']=$booking['id'];
	$_POST['marginFrom']=$data['CaR_activeFromDate'];
	$_POST['marginTo']=$data['CaR_activeToDate'];
	$bm4=$this->Bmargin_model->bm4();
	$bm4=json_decode($bm4);
	$bmPo=$this->Bmargin_model->bmPo();
	$bmPo=json_decode($bmPo);
	$_POST['accFeeInv']=$bm4->accFee;
	$_POST['accFeePo']=$bmPo->accFee;;
	$bmMargin=$this->Bmargin_model->bmMargin();
	$bmMargin=json_decode($bmMargin);
		foreach($fields as $k=>$v)
		{
			$value='';
			if($v=='booking_id')
				$value=$booking['id'];
			elseif($v=='accomodation_fee')
				$value='$'.add_decimal($bm4->accFee);
			elseif($v=='caregiving_fee')
				$value='$'.add_decimal($bm4->caregivingFee);
			elseif($v=='hostfamily_fee')
				$value='$'.add_decimal($bmPo->poTotalAmount);
			elseif($v=='admin_fee')
				$value='$'.add_decimal($bmPo->adminFeePo);
			elseif($v=='margin')
				$value='$'.add_decimal($bmMargin->profit);
			
			$this->excel->getActiveSheet()->setCellValue($k.$x, $value);	
		}
		
		$x++;
	}

	
				$filename='profit_margin.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
				//force user to download the Excel file without writing it to server's HD
				//$objWriter->save('php://output');
				$objWriter->save('static/report/'.$filename);
				//$mpdf->Output('static/pdf/invoice.pdf','F');
		//header('location:'.site_url().'reports/hfa');
	}
	
	function booking_holidayCheckups()
	{
			if(checkLogin())
			{
				recentActionsAddData('report','booking_holidayCheckup','view');
				$data['page']='reports-bookings_holidayCheckup';
				$this->load->view('system/header',$data);
				$this->load->view('system/reports/bookings_holidayCheckups');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
	}
	
	function booking_holidayCheckups_submit()
	{
		$data=$_POST;
		//see($data);die(1);
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('test worksheet');
		
		$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
				'font'=>array(
				'name'      =>  'Arial',
				'size'      =>  10,
			)
		));
		
		$fields=array();
		$fieldIndex=$lastIndex='A';
		
		foreach($data['CaR_field'] as $hr_field)
		{
			$fields[$fieldIndex]=$hr_field;
			$lastIndex=$fieldIndex;
			$fieldIndex++;
		}
		//see($fields);
		foreach ($fields as $fieldK=>$field){//echo $fieldK.', ';
	   	$this->excel->getActiveSheet()->getColumnDimension($fieldK)->setAutosize(true);}
	   
	  $x_start=1;
	  $reportFields=bookingsHolidayCheckups_report_fields();
	  foreach($fields as $k=>$v)
	  {
		  $colHeading=$reportFields[$v];
		  if($v=='booking_checkupDate')
		  {
			 if($data['CaR_holidayDateType']=='holiday_startDate')
				 $colHeading='Holiday reminder check date';
			 else	
				 $colHeading='Holiday return check date';
		  }
		  $this->excel->getActiveSheet()->setCellValue($k.$x_start, $colHeading);
	  }
		  
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getFont()->setSize(10)->setBold(true);  
		
		$x=$x_start+1;
		
	$this->load->model('report_model');
	$bookings=$this->report_model->bookingListForBookingHolidayCheckupReport($data);//see($bookings);
	
	$stateList=stateList();
	$genderList=genderList();
	$bookingStatusList=bookingStatusList();
	//see($fields);
	foreach($bookings as $booking)
	{
		$shaOne=getShaOneAppDetails($booking['student']);
		$shaTwo=getShaTwoAppDetails($booking['student']);
		$shaThree=getShaThreeAppDetails($booking['student']);
		$hfaOne=getHfaOneAppDetails($booking['host']);
		$checkup=$this->report_model->getLinkedHolidayCheckup($booking,$data['CaR_holidayDateType']);
		
		foreach($fields as $k=>$v)
		{
			$value='';
			if($v=='sha_name')
				$value=ucwords($shaOne['fname'].' '.$shaOne['lname']);
			elseif($v=='student_college_id')
				$value=$shaOne['sha_student_no'];
			elseif($v=='college_name')
				$value=$shaThree['college'];
			elseif($v=='booking_number')
				$value=$booking['id'];
			elseif($v=='booking_start_date')
				$value=date('d M Y',strtotime($booking['booking_from']));
			elseif($v=='booking_end_date')
			{
				if($booking['booking_to']!='0000-00-00')
					$value=date('d M Y',strtotime($booking['booking_to'].' +1 day'));
				else
					$value='Not set';	
			}
			elseif($v=='hfa_name')
				$value=ucwords($hfaOne['lname']).' Family';
			elseif($v=='booking_checkupDate')
			{
				if(!empty($checkup))
					$value=date('d M Y',strtotime($checkup['checkup_date']));
			}
			elseif($v=='booking_checkupNotes')
			{
				if(!empty($checkup))
					$value=$checkup['notes'];
			}
			
			$this->excel->getActiveSheet()->setCellValue($k.$x, $value);	
		}
		
		$x++;
	}

	
				$filename='Booking_holidayCheckups.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
							 
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
				//force user to download the Excel file without writing it to server's HD
				//$objWriter->save('php://output');
				$objWriter->save('static/report/'.$filename);
				//$mpdf->Output('static/pdf/invoice.pdf','F');
		//header('location:'.site_url().'reports/hfa');
	}

	function clients_report()
		{
				if(checkLogin())
				{
					recentActionsAddData('report','clients_report','view');
					$data['page']='reports-clients_report';
					$this->load->view('system/header',$data);
					$this->load->view('system/reports/clients_report');
					$this->load->view('system/footer');
				}
				else
					redirectToLogin();
		}
		
		function clients_report_submit()
		{
			$data=$_POST;
			$this->load->library('excel');
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle('Client List');
			$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
					'font'=>array(
					'name'      =>  'Arial',
					'size'      =>  10,
				)
			));
			
			$fields=array();
			$fieldIndex=$lastIndex='A';
			
			foreach($data['CaR_field'] as $hr_field)
			{
				$fields[$fieldIndex]=$hr_field;
				$lastIndex=$fieldIndex;
				$fieldIndex++;
			}
			//see($fields);
			foreach ($fields as $fieldK=>$field){//echo $fieldK.', ';
		   	$this->excel->getActiveSheet()->getColumnDimension($fieldK)->setAutosize(true);}
		   
		  $x_start=1;
		  $reportFields=clients_report_fields();
		  foreach($fields as $k=>$v)
		  {
			  $colHeading=$reportFields[$v];
			  $this->excel->getActiveSheet()->setCellValue($k.$x_start, $colHeading);
		  }
			  
			$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
			$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getFont()->setSize(10)->setBold(true);  
			
			$x=$x_start+1;
			
		$this->load->model('report_model');
		$clients=$this->report_model->ClientsReport($data);//echo $this->db->last_query();see($data);see($clients);//die('dddd');
		
		$this->load->model('Client_model');
		
		$stateList=stateList();
		
		//see($fields);
		foreach($clients as $client)
		{
			 $stringAddress='';
			 if(trim($client['street_address'])!='')
			 	$stringAddress.=trim($client['street_address']);
			  if(trim($client['suburb'])!='')
			  		$stringAddress .=', ';
				  $stringAddress .=trim($client['suburb']);
			  if(trim($client['state'])!='')
			  {
				  if($stringAddress!='')
					  $stringAddress .=', ';
				  $stringAddress .=trim($client['state']);
			  }
			  if(trim($client['postal_code'])!='' && $client['postal_code']!='0')
			  {
				  if($stringAddress!='')
					  $stringAddress .=', ';
				  $stringAddress .=trim($client['postal_code']);
			  }
			foreach($fields as $k=>$v)
			{
				$value='';
				if($v=='bname')
					$value=ucwords($client['bname']);
				elseif($v=='client_address'){
						$value=$stringAddress;
				}
				elseif($v=='primary_contact_name')
					$value=ucwords($client['primary_contact_name']." ".$client['primary_contact_lname']);
				elseif($v=='primary_email')
					$value=$client['primary_email'];
				elseif($v=='primary_phone')
					$value=$client['primary_phone'];

		
				
				$this->excel->getActiveSheet()->setCellValue($k.$x, $value);	
			}
			
			$x++;
		}

		
					$filename='client_report.xls'; //save our workbook as this file name
					header('Content-Type: application/vnd.ms-excel'); //mime type
					header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
					header('Cache-Control: max-age=0'); //no cache
					$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
					$objWriter->save('static/report/'.$filename);
		}
	

	function booking_comparison()
	{
			if(checkLogin())
			{
				recentActionsAddData('report','booking_comparison','view');
				$data['page']='reports-booking_comparison';
				$this->load->view('system/header',$data);
				$this->load->view('system/reports/booking_comparison_report');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
	}
	
	function booking_comparison_submit()
	{
		$data=$_POST;
		// see($data);die(1);
		$from1 = date_format(date_create_from_format("d/m/Y",$data['CaR_fromDate']),'d M Y');
		$from2 = date_format(date_create_from_format("d/m/Y",$data['CaR_fromDate_two']),'d M Y');
		$to1 = date_format(date_create_from_format("d/m/Y",$data['CaR_toDate']),'d M Y');
		$to2 = date_format(date_create_from_format("d/m/Y",$data['CaR_toDate_two']),'d M Y');
		$sheet1Title=$from1." to ".$to1;
		$sheet2Title=$from2." to ".$to2;
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle($sheet1Title);
		
		$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
				'font'=>array(
				'name'      =>  'Arial',
				'size'      =>  10,
			)
		));
		
		$fields=array();
		$fieldIndex=$lastIndex='A';
		
		foreach($data['CaR_field'] as $hr_field)
		{
			$fields[$fieldIndex]=$hr_field;
			$lastIndex=$fieldIndex;
			$fieldIndex++;
		}
		//see($fields);
		foreach ($fields as $fieldK=>$field){//echo $fieldK.', ';
	   	$this->excel->getActiveSheet()->getColumnDimension($fieldK)->setAutosize(true);}
	   
	  $x_start=1;
	  $reportFields=bookings_report_fields();
	  foreach($fields as $k=>$v)
	  {
		  $colHeading=$reportFields[$v];
		  $this->excel->getActiveSheet()->setCellValue($k.$x_start, $colHeading);
	  }
		  
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getFont()->setSize(10)->setBold(true);  
		
		$x=$x_start+1;
		
	$this->load->model('report_model');
	$bookings=$this->report_model->bookingListForComparisonReport($data);//echo $this->db->last_query();see($bookings);die('dddd');
	$count=$this->report_model->countBookings($data);//echo $this->db->last_query();see($count);die(11);
	$bookings1 = $bookings['sheet1'];
	$this->load->model('booking_model');
	$stateList=stateList();
	$genderList=genderList();
	$bookingStatusList=bookingStatusList();
	//see($fields);
	foreach($bookings1 as $booking)
	{	
		$shaOne=getShaOneAppDetails($booking['student']);
		$shaTwo=getShaTwoAppDetails($booking['student']);
		$shaThree=getShaThreeAppDetails($booking['student']);
		$hfaOne=getHfaOneAppDetails($booking['host']);
		$caregiver=getCaregiverDetail($shaTwo['guardian_assigned']);
		$caregiverCompany=getCaregiverCompanyDetail($caregiver['company']);
		foreach($fields as $k=>$v)
		{
			$value='';
			if($v=='sha_name')
				$value=ucwords($shaOne['fname'].' '.$shaOne['lname']);
			elseif($v=='student_college_id')
				$value=$shaOne['sha_student_no'];
			elseif($v=='sha_dob')
				$value=date('d M Y',strtotime($shaOne['dob']));
			elseif($v=='sha_gender')
				$value=$genderList[$shaOne['gender']];
			elseif($v=='sha_age')
				$value=age_from_dob($shaOne['dob']);
			elseif($v=='sha_email')
				$value=$shaOne['email'];
			elseif($v=='sha_mobile')
				$value=$shaOne['mobile'].' ';
			elseif($v=='booking_number')
				$value=$booking['id'];
			elseif($v=='booking_status')
				$value=$bookingStatusList[$booking['status']];
			elseif($v=='client_name')
				{	
					$clientDetail=clientDetail($shaOne['client']);
					$value=$clientDetail['bname'];
				}
			elseif($v=='client_group')
				{
					if($shaOne['client']!='0')
					{
						$clientGroupList=clientGroupList();
						$clientDetail=clientDetail($shaOne['client']);
						if($clientDetail['client_group']!='')
							$value=$clientGroupList[$clientDetail['client_group']];
					}
				}
			elseif($v=='college_name')
				$value=$shaThree['college'];
			elseif($v=='booking_start_date')
				$value=date('d M Y',strtotime($booking['booking_from']));
			elseif($v=='booking_end_date')
			{
				if($booking['booking_to']!='0000-00-00')
					$value=date('d M Y',strtotime($booking['booking_to'].' +1 day'));
				else
					$value='Not set';	
			}
			elseif($v=='hfa_name')
				$value=ucwords($hfaOne['fname'].' '.$hfaOne['lname']);
			elseif($v=='hfa_address')
			{
				if($hfaOne['street']!='')
					$value .=$hfaOne['street'].", ";
				$value .=ucfirst($hfaOne['suburb']).", ".$stateList[$hfaOne['state']].", ".$hfaOne['postcode'];	
			}
			elseif($v=='hfa_mobile')
				$value=$hfaOne['mobile'];
			elseif($v=='hfa_email')
				$value=$hfaOne['email'];
			elseif($v=='apu')
			{
				if($shaTwo['airport_pickup']=='1')
					$value='Yes';
				else
					$value='No';	
			}
			elseif($v=='apu_company')
			{
				if($shaTwo['apu_company']!='0')
				{
					$apuCompanyDetail=apuCompanyDetail($shaTwo['apu_company']);
					if(!empty($apuCompanyDetail))
						$value=$apuCompanyDetail['company_name'];	 
				}
			}
			elseif($v=='apu_arrival_date')
			{
				if($shaOne['arrival_date']!='0000-00-00')
					$value=dateFormat($shaOne['arrival_date']);
			}
			elseif($v=='apu_arrival_time')
			{
				if($shaTwo['airport_arrival_time']!='00:00:00')
					$value=date('h:i A',strtotime($shaTwo['airport_arrival_time']));
			}
			elseif($v=='apu_flight_number')
				$value=$shaTwo['airport_flightno'];
			elseif($v=='sha_pets')
			{
				  if($shaTwo['live_with_pets']=="0")
					  $value .="No";
				  elseif($shaTwo['live_with_pets']=="1")
					  $value .="Yes";
				  else
					  $value .="n/a";
				  
				  if($shaTwo['live_with_pets']==1)
				  {
						$pets=array();
						if($shaTwo['pet_dog']==1)
							$pets[]='Dog';
						if($shaTwo['pet_cat']==1)
							$pets[]='Cat';
						if($shaTwo['pet_bird']==1)
							$pets[]='Bird';
						if($shaTwo['pet_other']==1 && $shaTwo['pet_other_val']!='')
							$pets[]=ucfirst ($shaTwo['pet_other_val']);	
						
						if(!empty($pets))
							$value .=' - '.implode(', ',$pets);
						
						if($shaTwo['pet_live_inside']==1)
							$value .= ", can live with pets inside the house";
						elseif($shaTwo['pet_live_inside']=="0")
							$value .= ", cannot live with pets inside the house";	
					}
			}
			elseif($v=='sha_kids')
			{
				$value .='0-11 years old: ';
				if($shaThree['live_with_child11']==1)
					$value .="Yes";
				elseif($shaThree['live_with_child11']=="0")	
					$value .="No";
				else
					$value .='n/a';	
				$value .=', ';
				
				$value .='12-20 years old: ';
				if($shaThree['live_with_child20']==1)
					$value .= "Yes";
				elseif($shaThree['live_with_child20']=="0")	
					$value .= "No";
				else
					$value .= 'n/a';
				$value .='';	
				
				if(trim($shaThree['live_with_child_reason'])!='')
					$value .= ', Reason: '.ucfirst ($shaThree['live_with_child_reason']);
			}
			elseif($v=='sha_allergy')
			{
					if($shaThree['allergy_req']=='0')
						$value .="No";
					elseif($shaThree['allergy_req']=='1')
						$value .="Yes ";
					else
						$value .='n/a';
						
					if($shaThree['allergy_req']=='1')
						{
							$allergy=array();
							if($shaThree['allergy_hay_fever']==1)
								$allergy[]='Hay Fever';
							if($shaThree['allergy_asthma']==1)
								$allergy[]='Asthma';
							if($shaThree['allergy_lactose']==1)
								$allergy[]='Lactose Intolerance';
							if($shaThree['allergy_gluten']==1)
								$allergy[]='Gluten Intolerance';	
							if($shaThree['allergy_peanut']==1)
								$allergy[]='Peanut Allergies';	
							if($shaThree['allergy_dust']==1)
								$allergy[]='Dust Allergies';	
							if($shaThree['allergy_other']==1 && $shaThree['allergy_other_val']!='')
								$allergy[]=ucfirst ($shaThree['allergy_other_val']);		
							
							if(!empty($allergy))
								$value .='- '.implode(', ',$allergy);
						}	
			}
			elseif($v=='sha_dietry_requirement')
			{
					if($shaThree['diet_req']=='0')
					  $value .= "No";
				  elseif($shaThree['diet_req']=='1')
					  $value .= "Yes ";
				  else
					   $value .= 'n/a';
					  
				  if($shaThree['diet_req']=='1')
					  {
						  $dietReq=array();
						  if($shaThree['diet_veg']==1)
							  $dietReq[]='Vegetarian';
						  if($shaThree['diet_gluten']==1)
							  $diet[]='Gluten/Lactose Free';
						  if($shaThree['diet_pork']==1)
							  $dietReq[]='No Pork';
						  if($shaThree['diet_food_allergy']==1)
							  $dietReq[]='Food Allergies';	
						  if($shaThree['diet_other']==1 && $shaThree['diet_other_val']!='')
							  $dietReq[]=ucfirst ($shaThree['diet_other_val']);		
						  
						  if(!empty($dietReq))
							  $value .='- '.implode(', ',$dietReq);
					  }
			}
			elseif($v=='sha_medication')
			{
				  if($shaThree['medication']=='1')
					  $value .= 'Yes';
				  elseif($shaThree['medication']=='0')
					  $value .= "No";
				  else 
					  $value .= 'n/a';	
					  
				  if($shaThree['medication']=='1')
					  $value .='- '.$shaThree['medication_desc'];
			}
			elseif($v=='sha_disabilty')
			{
				  if($shaThree['disabilities']=='1')
					  $value .= 'Yes';
				  elseif($shaThree['disabilities']=='0')
					  $value .= "No";
				  else 
					  $value .= 'n/a';	
					  
				  if($shaThree['disabilities']=='1')
					  $value .='- '.$shaThree['disabilities_desc'];
			}
			elseif($v=='sha_smoke')
			{
				  $smokingHabbits=smokingHabbits();
				  if($shaThree['smoker']!='')
					  $value .= str_replace('&amp;','&',$smokingHabbits[$shaThree['smoker']]);
				  else
					  $value .= 'n/a';	
			}
			elseif($v=='sha_smoker_inside')
			{
				  $smokingHabbits=smokingHabbits();
				  if($shaThree['family_include_smoker']!='')
					  $value .= str_replace('&amp;','&',$smokingHabbits[$shaThree['family_include_smoker']]);
				  else
					  $value .= 'n/a';	
			}
			elseif($v=='sha_other_family_pref')
			{
				  if($shaThree['family_pref']!='')
					  $value .= $shaThree['family_pref'];
				  else
					  $value .= 'n/a';
			}
			elseif($v=='course_name')
			{
				if($shaThree['course_name'] && $shaThree['course_start_date'])
				{
				$value = 'Course: '.$shaThree['course_name'].' | Start date: '.date('d M Y',strtotime($shaThree['course_start_date']));
				}
				elseif($shaThree['course_start_date']=='0000-00-00' && !$shaThree['course_name'])
				{
				$value = 'Course not available | Start date not available';
				}
				elseif(!$shaThree['course_name'] && $shaThree['course_start_date'])
				{
				$value = 'Course not available'.' | Start Date: '.date('d M Y',strtotime($shaThree['course_start_date']));
				}
				if($shaThree['course_start_date']=='0000-00-00' && $shaThree['course_name'])
				{
				$value = 'Course: '.$shaThree['course_name'].' | Start date not available';
				}
			}
			elseif($v=='cg_company')
				$value=$caregiverCompany['name'];
			elseif($v=='cg_name')
				$value=$caregiver['fname'].' '.$caregiver['lname'];
			elseif($v=='cg_mobile')
				$value=$caregiver['phone'];
			elseif($v=='cg_email')
				$value=$caregiver['email'];
			elseif($v=='holidays_latest' || $v=='holidays')
			{
				$bookingHolidays=$this->booking_model->holidaysByBooking($booking['id']);
				if(empty($bookingHolidays))
					$value='N/A';
				else	
				{
					if($v=='holidays_latest')
							$value=dateFormat($bookingHolidays[0]['start']).' - '.dateFormat($bookingHolidays[0]['end']);
					elseif($v=='holidays')
					{
						$holidayArray=array();
						foreach($bookingHolidays as $holiday)
							$holidayArray[]=dateFormat($holiday['start']).' - '.dateFormat($holiday['end']);
						$value=implode(' | ',$holidayArray);	
					}
				}
			}
			elseif($v=='homestay_change')
				$value=$this->shaHomestayChangeReportField($shaOne['id']);
			
			$this->excel->getActiveSheet()->setCellValue($k.$x, $value);	
		}
		
		$x++;
	}
		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(1);
		$this->excel->getActiveSheet()->setTitle($sheet2Title);
		$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
				'font'=>array(
				'name'      =>  'Arial',
				'size'      =>  10,
			)
		));
		
		$fields=array();
		$fieldIndex=$lastIndex='A';
		
		foreach($data['CaR_field'] as $hr_field)
		{
			$fields[$fieldIndex]=$hr_field;
			$lastIndex=$fieldIndex;
			$fieldIndex++;
		}
		//see($fields);
		foreach ($fields as $fieldK=>$field){//echo $fieldK.', ';
	   	$this->excel->getActiveSheet()->getColumnDimension($fieldK)->setAutosize(true);}
	   
	  $x_start=1;
	  $reportFields=bookings_report_fields();
	  foreach($fields as $k=>$v)
	  {
		  $colHeading=$reportFields[$v];
		  $this->excel->getActiveSheet()->setCellValue($k.$x_start, $colHeading);
	  }
		  
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getFont()->setSize(10)->setBold(true);  
		
		$x=$x_start+1;
		
	$this->load->model('report_model');
	$bookings2 = $bookings['sheet2'];
	$this->load->model('booking_model');
	
	$stateList=stateList();
	$genderList=genderList();
	$bookingStatusList=bookingStatusList();
	//see($fields);
	foreach($bookings2 as $booking)
	{
		$shaOne=getShaOneAppDetails($booking['student']);
		$shaTwo=getShaTwoAppDetails($booking['student']);
		$shaThree=getShaThreeAppDetails($booking['student']);
		$hfaOne=getHfaOneAppDetails($booking['host']);
		$caregiver=getCaregiverDetail($shaTwo['guardian_assigned']);
		$caregiverCompany=getCaregiverCompanyDetail($caregiver['company']);
		foreach($fields as $k=>$v)
		{
			$value='';
			if($v=='sha_name')
				$value=ucwords($shaOne['fname'].' '.$shaOne['lname']);
			elseif($v=='student_college_id')
				$value=$shaOne['sha_student_no'];
			elseif($v=='sha_dob')
				$value=date('d M Y',strtotime($shaOne['dob']));
			elseif($v=='sha_gender')
				$value=$genderList[$shaOne['gender']];
			elseif($v=='sha_age')
				$value=age_from_dob($shaOne['dob']);
			elseif($v=='sha_email')
				$value=$shaOne['email'];
			elseif($v=='sha_mobile')
				$value=$shaOne['mobile'].' ';
			elseif($v=='booking_number')
				$value=$booking['id'];
			elseif($v=='booking_status')
				$value=$bookingStatusList[$booking['status']];
			elseif($v=='client_name')
				{	
					$clientDetail=clientDetail($shaOne['client']);
					$value=$clientDetail['bname'];
				}
			elseif($v=='client_group')
				{
					if($shaOne['client']!='0')
					{
						$clientGroupList=clientGroupList();
						$clientDetail=clientDetail($shaOne['client']);
						if($clientDetail['client_group']!='')
							$value=$clientGroupList[$clientDetail['client_group']];
					}
				}
			elseif($v=='college_name')
				$value=$shaThree['college'];
			elseif($v=='booking_start_date')
				$value=date('d M Y',strtotime($booking['booking_from']));
			elseif($v=='booking_end_date')
			{
				if($booking['booking_to']!='0000-00-00')
					$value=date('d M Y',strtotime($booking['booking_to'].' +1 day'));
				else
					$value='Not set';	
			}
			elseif($v=='hfa_name')
				$value=ucwords($hfaOne['fname'].' '.$hfaOne['lname']);
			elseif($v=='hfa_address')
			{
				if($hfaOne['street']!='')
					$value .=$hfaOne['street'].", ";
				$value .=ucfirst($hfaOne['suburb']).", ".$stateList[$hfaOne['state']].", ".$hfaOne['postcode'];	
			}
			elseif($v=='hfa_mobile')
				$value=$hfaOne['mobile'];
			elseif($v=='hfa_email')
				$value=$hfaOne['email'];
			elseif($v=='apu')
			{
				if($shaTwo['airport_pickup']=='1')
					$value='Yes';
				else
					$value='No';	
			}
			elseif($v=='apu_company')
			{
				if($shaTwo['apu_company']!='0')
				{
					$apuCompanyDetail=apuCompanyDetail($shaTwo['apu_company']);
					if(!empty($apuCompanyDetail))
						$value=$apuCompanyDetail['company_name'];	 
				}
			}
			elseif($v=='apu_arrival_date')
			{
				if($shaOne['arrival_date']!='0000-00-00')
					$value=dateFormat($shaOne['arrival_date']);
			}
			elseif($v=='apu_arrival_time')
			{
				if($shaTwo['airport_arrival_time']!='00:00:00')
					$value=date('h:i A',strtotime($shaTwo['airport_arrival_time']));
			}
			elseif($v=='apu_flight_number')
				$value=$shaTwo['airport_flightno'];
			elseif($v=='sha_pets')
			{
				  if($shaTwo['live_with_pets']=="0")
					  $value .="No";
				  elseif($shaTwo['live_with_pets']=="1")
					  $value .="Yes";
				  else
					  $value .="n/a";
				  
				  if($shaTwo['live_with_pets']==1)
				  {
						$pets=array();
						if($shaTwo['pet_dog']==1)
							$pets[]='Dog';
						if($shaTwo['pet_cat']==1)
							$pets[]='Cat';
						if($shaTwo['pet_bird']==1)
							$pets[]='Bird';
						if($shaTwo['pet_other']==1 && $shaTwo['pet_other_val']!='')
							$pets[]=ucfirst ($shaTwo['pet_other_val']);	
						
						if(!empty($pets))
							$value .=' - '.implode(', ',$pets);
						
						if($shaTwo['pet_live_inside']==1)
							$value .= ", can live with pets inside the house";
						elseif($shaTwo['pet_live_inside']=="0")
							$value .= ", cannot live with pets inside the house";	
					}
			}
			elseif($v=='sha_kids')
			{
				$value .='0-11 years old: ';
				if($shaThree['live_with_child11']==1)
					$value .="Yes";
				elseif($shaThree['live_with_child11']=="0")	
					$value .="No";
				else
					$value .='n/a';	
				$value .=', ';
				
				$value .='12-20 years old: ';
				if($shaThree['live_with_child20']==1)
					$value .= "Yes";
				elseif($shaThree['live_with_child20']=="0")	
					$value .= "No";
				else
					$value .= 'n/a';
				$value .='';	
				
				if(trim($shaThree['live_with_child_reason'])!='')
					$value .= ', Reason: '.ucfirst ($shaThree['live_with_child_reason']);
			}
			elseif($v=='sha_allergy')
			{
					if($shaThree['allergy_req']=='0')
						$value .="No";
					elseif($shaThree['allergy_req']=='1')
						$value .="Yes ";
					else
						$value .='n/a';
						
					if($shaThree['allergy_req']=='1')
						{
							$allergy=array();
							if($shaThree['allergy_hay_fever']==1)
								$allergy[]='Hay Fever';
							if($shaThree['allergy_asthma']==1)
								$allergy[]='Asthma';
							if($shaThree['allergy_lactose']==1)
								$allergy[]='Lactose Intolerance';
							if($shaThree['allergy_gluten']==1)
								$allergy[]='Gluten Intolerance';	
							if($shaThree['allergy_peanut']==1)
								$allergy[]='Peanut Allergies';	
							if($shaThree['allergy_dust']==1)
								$allergy[]='Dust Allergies';	
							if($shaThree['allergy_other']==1 && $shaThree['allergy_other_val']!='')
								$allergy[]=ucfirst ($shaThree['allergy_other_val']);		
							
							if(!empty($allergy))
								$value .='- '.implode(', ',$allergy);
						}	
			}
			elseif($v=='sha_dietry_requirement')
			{
					if($shaThree['diet_req']=='0')
					  $value .= "No";
				  elseif($shaThree['diet_req']=='1')
					  $value .= "Yes ";
				  else
					   $value .= 'n/a';
					  
				  if($shaThree['diet_req']=='1')
					  {
						  $dietReq=array();
						  if($shaThree['diet_veg']==1)
							  $dietReq[]='Vegetarian';
						  if($shaThree['diet_gluten']==1)
							  $diet[]='Gluten/Lactose Free';
						  if($shaThree['diet_pork']==1)
							  $dietReq[]='No Pork';
						  if($shaThree['diet_food_allergy']==1)
							  $dietReq[]='Food Allergies';	
						  if($shaThree['diet_other']==1 && $shaThree['diet_other_val']!='')
							  $dietReq[]=ucfirst ($shaThree['diet_other_val']);		
						  
						  if(!empty($dietReq))
							  $value .='- '.implode(', ',$dietReq);
					  }
			}
			elseif($v=='sha_medication')
			{
				  if($shaThree['medication']=='1')
					  $value .= 'Yes';
				  elseif($shaThree['medication']=='0')
					  $value .= "No";
				  else 
					  $value .= 'n/a';	
					  
				  if($shaThree['medication']=='1')
					  $value .='- '.$shaThree['medication_desc'];
			}
			elseif($v=='sha_disabilty')
			{
				  if($shaThree['disabilities']=='1')
					  $value .= 'Yes';
				  elseif($shaThree['disabilities']=='0')
					  $value .= "No";
				  else 
					  $value .= 'n/a';	
					  
				  if($shaThree['disabilities']=='1')
					  $value .='- '.$shaThree['disabilities_desc'];
			}
			elseif($v=='sha_smoke')
			{
				  $smokingHabbits=smokingHabbits();
				  if($shaThree['smoker']!='')
					  $value .= str_replace('&amp;','&',$smokingHabbits[$shaThree['smoker']]);
				  else
					  $value .= 'n/a';	
			}
			elseif($v=='sha_smoker_inside')
			{
				  $smokingHabbits=smokingHabbits();
				  if($shaThree['family_include_smoker']!='')
					  $value .= str_replace('&amp;','&',$smokingHabbits[$shaThree['family_include_smoker']]);
				  else
					  $value .= 'n/a';	
			}
			elseif($v=='sha_other_family_pref')
			{
				  if($shaThree['family_pref']!='')
					  $value .= $shaThree['family_pref'];
				  else
					  $value .= 'n/a';
			}
			elseif($v=='course_name')
			{
				if($shaThree['course_name'] && $shaThree['course_start_date'])
				{
				$value = 'Course: '.$shaThree['course_name'].' | Start date: '.date('d M Y',strtotime($shaThree['course_start_date']));
				}
				elseif($shaThree['course_start_date']=='0000-00-00' && !$shaThree['course_name'])
				{
				$value = 'Course not available | Start date not available';
				}
				elseif(!$shaThree['course_name'] && $shaThree['course_start_date'])
				{
				$value = 'Course not available'.' | Start Date: '.date('d M Y',strtotime($shaThree['course_start_date']));
				}
				if($shaThree['course_start_date']=='0000-00-00' && $shaThree['course_name'])
				{
				$value = 'Course: '.$shaThree['course_name'].' | Start date not available';
				}
			}
			elseif($v=='cg_company')
				$value=$caregiverCompany['name'];
			elseif($v=='cg_name')
				$value=$caregiver['fname'].' '.$caregiver['lname'];
			elseif($v=='cg_mobile')
				$value=$caregiver['phone'];
			elseif($v=='cg_email')
				$value=$caregiver['email'];
			elseif($v=='holidays_latest' || $v=='holidays')
			{
				$bookingHolidays=$this->booking_model->holidaysByBooking($booking['id']);
				if(empty($bookingHolidays))
					$value='N/A';
				else	
				{
					if($v=='holidays_latest')
							$value=dateFormat($bookingHolidays[0]['start']).' - '.dateFormat($bookingHolidays[0]['end']);
					elseif($v=='holidays')
					{
						$holidayArray=array();
						foreach($bookingHolidays as $holiday)
							$holidayArray[]=dateFormat($holiday['start']).' - '.dateFormat($holiday['end']);
						$value=implode(' | ',$holidayArray);	
					}
				}
			}
			elseif($v=='homestay_change')
				$value=$this->shaHomestayChangeReportField($shaOne['id']);
			
			$this->excel->getActiveSheet()->setCellValue($k.$x, $value);	
		}
		
		$x++;
	}

		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(2);
		$this->excel->getActiveSheet(2)->setTitle('Comparison');
		$this->excel->setActiveSheetIndex(2)->setCellValue('C2', $sheet1Title);
		$this->excel->setActiveSheetIndex(2)->setCellValue('D2', $sheet2Title);
		$this->excel->setActiveSheetIndex(2)->setCellValue('E2', 'Difference');
		$this->excel->getActiveSheet()->getStyle('B2:E2')->getFont()->setSize(10)->setBold(true);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setAutosize(true);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setAutosize(true);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setAutosize(true);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setAutosize(true);
		$count1=$count['year1'];
		$count2=$count['year2'];
		$x=3;
		foreach($count1 as $k=>$v){
			$bname = $k;
			$totalbookings=$v['count(*)'];
			$this->excel->setActiveSheetIndex(2)->setCellValue('B'.$x,$bname);
			$this->excel->setActiveSheetIndex(2)->setCellValue('C'.$x,$totalbookings);
			$x++;
		}
		$a=$x-1;
		$this->excel->setActiveSheetIndex(2)->setCellValue('C'.$x,'=SUM(C3:C'.$a.')');
		$y=3;
		foreach($count2 as $k=>$v )
		{
			$totalbookings=$v['count(*)'];
			$this->excel->setActiveSheetIndex(2)->setCellValue('D'.$y,$totalbookings);
			$this->excel->setActiveSheetIndex(2)->setCellValue('E'.$y,'=D'.$y.'-C'.$y);
			$y++;
		}
			$z=$y-1;
			$this->excel->setActiveSheetIndex(2)->setCellValue('D'.$y,'=SUM(D3:D'.$z.')');
			$this->excel->setActiveSheetIndex(2)->setCellValue('E'.$y,'=SUM(E3:E'.$z.')');
			$objConditionalStyle = new PHPExcel_Style_Conditional();
			$objConditionalStyle->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
		    ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_LESSTHAN)
		    ->addCondition(0);
			$objConditionalStyle->getStyle()->getFont()->getColor()->setRGB('FF0000');
			$conditionalStyles = $this->excel->getActiveSheet()->getStyle('E3:E'.$y)
				->getConditionalStyles();
			array_push($conditionalStyles, $objConditionalStyle);
			$this->excel->getActiveSheet()->getStyle('E3:E'.$y)
				->setConditionalStyles($conditionalStyles);

			$this->excel->getActiveSheet()->getStyle('B2:E'.$y)->applyFromArray(array(
				'font'=>array(
				'name'      =>  'Arial',
				'size'      =>  10,
				),
				'borders' => array(
					'allborders' => array(
					  'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				  )
			));

				$filename='Booking_comparison_test.xlsx'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');  
				$objWriter->save('static/report/'.$filename);
				
	}

	function training_event()
	{
			if(checkLogin())
			{
				recentActionsAddData('report','training_event','view');
				$data['page']='reports-training_event';
				$this->load->view('system/header',$data);
				$this->load->view('system/reports/training_event');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
	}
	
	function training_event_submit()
	{
		$data=$_POST;//see($data);die(111);
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('Family Training Attendence');
		$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
				'font'=>array(
				'name'      =>  'Arial',
				'size'      =>  10,
			)
		));

		$fields=array();
		$fieldIndex=$lastIndex='A';
		foreach($data['HR_field'] as $hr_field)
		{
			$fields[$fieldIndex]=$hr_field;
			$lastIndex=$fieldIndex;
			$fieldIndex++;
		}
		//see($fields);
		foreach ($fields as $fieldK=>$field){//echo $fieldK.', ';
		   $this->excel->getActiveSheet()->getColumnDimension($fieldK)->setAutosize(true);}
	  $x_start=1;
	  $reportFields=trainingreportFields();
	  foreach($fields as $k=>$v)
	  {
		$colHeading=$reportFields[$v];
		$this->excel->getActiveSheet()->setCellValue($k.$x_start, $colHeading);
	  }
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastIndex.$x_start)->getFont()->setSize(10)->setBold(true);  
		$x=$x_start+1;

		$this->load->model('report_model');
		$attendence=$this->report_model->familyTrainingAttendenceReport($data);//see($attendence);echo $this->db->last_query();die();
		$x=2;
		foreach($attendence as $attd)
		{
			foreach($fields as $k=>$v)
			{
				$value='';
				if($v=='hfa_id')
					$value=$attd['host'];
				elseif($v=='hfa_name')
					$value=ucwords($attd['fname'].' '.$attd['lname']);
				elseif($v=='hfa_mobile')
					$value=$attd['mobile'];
				elseif($v=='hfa_email')
					$value=$attd['email'];
				elseif($v=='sha_name')
					$value=ucwords($attd['shafname'].' '.$attd['shalname']);
				elseif($v=='sha_age')
					$value=age_from_dob($attd['shadob']);
				elseif($v=='sha_college')
					$value=$attd['college'];
				elseif($v=='past_event')
				{	$value='';
					$dates = gethfaTrainingDates($attd['host']);
					$len=count($dates);
					foreach($dates as $d=>$date)
					{	
						$value.=date('d M Y',strtotime($date['training_date']));
						if($d !== $len-1)
							$value.=', ';
					}
				}
				$this->excel->getActiveSheet()->setCellValue($k.$x, $value);

			}
			$x++;
		}
				$this->excel->getActiveSheet()->getStyle("I2:I".$x)->getNumberFormat()->setFormatCode('dd-mm-yyyy'); 
				$filename='family_training_attendence.xlsx'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');  
				$objWriter->save('static/report/'.$filename);
	}

	function uploadExcel()
	{
		if(checkLogin())
		{
			$data=$_POST;
			$file=$_FILES['importTrainingAttendenceFile']['tmp_name'];
			$this->load->library('excel');
			$objReader = PHPExcel_IOFactory::createReader('Excel2007');
			$objPHPExcel = $objReader->load($file);
			$res = array();
			foreach($objPHPExcel->getWorksheetIterator() as $worksheetK=>$worksheet)
			{
				//print_r($worksheet);
				if($worksheetK==0)
				{
					$group = $worksheet->toArray();
					// see($group);die();
					if(!empty($group))
					{
						foreach ($group as $key=>$line)
						{
							$len = count($line)-1;
							if(empty($line[$len]) || $line[$len]=='Current event attendence')
								continue;
							else
							{	
								$dates= explode(",",$line[$len]);
								foreach($dates as $date)
								{	$date=trim($date);
									$d = date('d-m-Y',strtotime($date));
									if($d != $date)
									{
										$res[$line[1]][]=$date;
									}
									else 
										continue;
								}
							}
						}
						if(empty($res))
						{	
							foreach ($group as $key=>$line){
								$len = count($line)-1;
								if(empty($line[$len]) || $line[$len]=='Current event attendence')
									continue;
								else
								{
									$this->load->model('report_model');
									$this->report_model->uploadTrainingAttendence($line[0],$line[$len]);//echo $this->db->last_query();
								}
							}
						}	
						else
						{	
							foreach($res as $k=>$V){
								echo "<tr>
								<td style='width:auto'>".$k."</td>
								<td>";
								foreach($V as $a=>$v){
									if($a !== count($V)-1)
									$v.=', ';
									echo 
									$v;
								}
								echo "</td></tr>";
								
							}
							
						}
					}
				}
			}

		}
	}
	
}