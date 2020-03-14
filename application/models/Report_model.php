<?php 

class Report_model extends CI_Model { 


	function hfaListForReport($data)
	{
		$status=$data['HR_status'];
		$statusList="'".implode("','",$status)."'";
		
		$state=$data['HR_state'];
		$stateList="'".implode("','",$state)."'";
		
		$query=$this->db->query("select * from `hfa_one` where `status` IN(".$statusList.") and `state` IN(".$stateList.") order by `id`");
		$res=$query->result_array();
		return $res;
	}
	
	function clgUniOptionSelected($data)
	{
		//see($data);
		$res=['client'=>[],'college'=>[]];
		if(!empty($data['reportSelectClientClg']))
		{
			if(in_array('clients',$data['reportSelectClientClg']))
			{
				$res['client']=['option'=>$data['CaR_college_option']];	
				if($data['CaR_college_option']!='all')
				{
					if($data['CaR_college_option']=='client_group')
					{
						$optionVal=array_filter($data['CaR_clientGroup']);
						
						$sqlClientGroup="select `id` from `clients` where `client_group` ";
						$sqlClientGroup .="IN('".implode("','",$optionVal)."')";
						$clientsG=$this->db->query($sqlClientGroup)->result_array();	
						foreach($clientsG as $cG)
							$res['client']['clients'][]=$cG['id'];
					}
					elseif($data['CaR_college_option']=='selective')
					{
						$optionVal=array_filter($data['CaR_college']);
						$res['client']['clients']=$optionVal;
					}
					$res['client']['optionVal']=$optionVal;
				}
			}
			
			if(in_array('colleges',$data['reportSelectClientClg']))
			{
				$res['college']['option']=$data['CaR_clgUni_option'];	
				if($data['CaR_clgUni_option']!='all')
				{
					if($data['CaR_clgUni_option']=='clgUni_group')
						$optionVal=$data['CaR_clgUniGroup'];
					elseif($data['CaR_clgUni_option']=='selective')
						$optionVal=$data['CaR_clgUni'];
					$res['college']['optionVal']=array_filter($optionVal);
				}
			}
		}
		return $res;
	}

	function employeeOptionSelected($data){
		$res=['employee'=>''];
		//see($data);
		if(!empty($data))
		{
				$res['employee']=['option'=>$data['CaR_employee_option']];	
				//echo $data['CaR_employee_option'];
				if($data['CaR_employee_option']!='all')
				{
					if($data['CaR_employee_option']=='selective')
					{	
						$optionVal=array_filter($data['CaR_employee']);
						$res['employee']['employees']=$optionVal;
					}
					$res['employee']['optionVal']=$optionVal;
				}	
		}
		return $res;
	}

	function bookingListForAuditingReport($data)
	{
		if(!isset($data['CaR_status']))
			return array();
		
		$clgUniOption=$this->clgUniOptionSelected($data);//see($clgUniOption);
		
		$sql="select * from `bookings` where `serviceOnlyBooking`='0' and `status` IN('".implode("','",$data['CaR_status'])."') ";
		if(isset($data['CaR_fromDate']) && isset($data['CaR_toDate']))
		{
			$fromDate=normalToMysqlDate($data['CaR_fromDate']);
			$toDate=normalToMysqlDate($data['CaR_toDate']);
			$sql .=" and  `booking_from`>='".$fromDate."' and `booking_from`<='".$toDate."'";
		}
		
		if(isset($data['CaR_activeFromDate']) && isset($data['CaR_activeToDate']))
		{
			$fromDate=normalToMysqlDate($data['CaR_activeFromDate']);
			$toDate=normalToMysqlDate($data['CaR_activeToDate']);
			
			$sql .=" and  (";
			$sql .=" (`booking_from`>='".$fromDate."' and `booking_from`<='".$toDate."')";//start date b/w range
			$sql .=" OR ( `booking_to`>='".$fromDate."' and `booking_to`<='".$toDate."')";//end date b/w range
			$sql .=" OR ( `booking_from`<='".$fromDate."' and `booking_to`>='".$toDate."')";// range is b/w the start and end date
			$sql .=" OR ( `booking_to`='0000-00-00' and `booking_from`<='".$toDate."')";//when booking end date is not set and booking is active in the date range
			$sql .=" )";
		}
		
		if(!empty($clgUniOption['client']) && $clgUniOption['client']['option']!='all')
		{
			if(isset($clgUniOption['client']['clients']))
			{
				$shaClientSet="'".implode("','",$clgUniOption['client']['clients'])."'";	
				$sqlClient=" where `client` IN(".$shaClientSet.")";
				$sql .=" and `student` IN(select `id` from `sha_one` ".$sqlClient.") ";
			}
			else
				return 	array();
		}
		
		if(!empty($clgUniOption['college']) && $clgUniOption['college']['option']!='all')
		{
			$shaClgSet="'".implode("','",$clgUniOption['college']['optionVal'])."'";
			if($clgUniOption['college']['option']=='clgUni_group')
				$sqlColg=" where `college_group` IN(".$shaClgSet.")";
			elseif($clgUniOption['college']['option']=='selective')
				$sqlColg=" where `college` IN(".$shaClgSet.")";
				
			$sql .=" and `student` IN(select `id` from `sha_three` ".$sqlColg.") ";
		}
		
		$sql .="order by `bookings`.`id`";	
		$query=$this->db->query($sql); //echo $this->db->last_query();
		$bookings=$query->result_array();//return $this->db->query("select * from `bookings` where `student`='24922'")->result_array();
		return $bookings;
	}

	function bookingListForEmployeesReport($data)
	{
		if(!isset($data['CaR_status']))
			return array();
		
		
		$empOption=$this->employeeOptionSelected($data);//see($empOption['employee']);
		
		$sql="select * from `bookings` where `serviceOnlyBooking`='0' and `status` IN('".implode("','",$data['CaR_status'])."') ";
		if(isset($data['CaR_fromDate']) && isset($data['CaR_toDate']))
		{
			$fromDate=normalToMysqlDate($data['CaR_fromDate']);
			$toDate=normalToMysqlDate($data['CaR_toDate']);
			$sql .=" and  `booking_from`>='".$fromDate."' and `booking_from`<='".$toDate."'";
		}
	
		if(!empty($empOption['employee']) && $empOption['employee']['option']!='all')
		{
			if(isset($empOption['employee']['employees']))
			{
				$shaEmpSet="'".implode("','",$empOption['employee']['employees'])."'";	
				$sqlEmp=" where `employee` IN(".$shaEmpSet.")";
				$sql .=" and `student` IN(select `id` from `sha_one` ".$sqlEmp.") ";
			}
			else
				return 	array();
		}
		

		$sql .="order by `bookings`.`id`";	
		$query=$this->db->query($sql); //echo $this->db->last_query();
		$bookings=$query->result_array();//return $this->db->query("select * from `bookings` where `student`='24922'")->result_array();
		return $bookings;
	}

	function hfaLastVisitDate($hostId)
	{
			  $hfaOne=getHfaOneAppDetails($hostId);
			  $visitQuery=$this->db->query("select * from `hfa_visitReport` where `hfa_id`='".$hostId."' order by `date_visited` DESC limit 1");
			  if($visitQuery->num_rows()>0)
			  {
				  $visitReport=$visitQuery->row_array();
				  $visitReportDate=$visitReport['date_visited'];
			  }
			  else
				  $visitReportDate='0000-00-00 00:00:00';	
			  $visit_date_time=$hfaOne['visit_date_time'];
			  $revisitQuery=$this->db->query("select * from `hfa_revisit_history` where `hfa_id`='".$hostId."' order by `date_visited` DESC limit 1");
			  if($revisitQuery->num_rows()>0)
			  {
				  $revisitHistory=$revisitQuery->row_array();
				  $revisitHistoryDate=$revisitHistory['date_visited'];
			  }
			  else
				  $revisitHistoryDate='0000-00-00 00:00:00';	
			  
			  if(strtotime($visitReportDate) > strtotime($visit_date_time))
				  $vDate=$visitReportDate;
			  else
				  $vDate=$visit_date_time;
			  
			  if(strtotime($revisitHistoryDate) > strtotime($vDate))
				  $vDate=$revisitHistoryDate;
			  if($vDate=='0000-00-00 00:00:00')
				  $vDate='';
			  else	
			  $vDate=date('d M Y',strtotime($vDate));
			  return $vDate;
	}
	
	function shaListForTourGroupsReport($data)
	{
		$data['tgR_tGroup']=array_filter($data['tgR_tGroup'], function($value) { return $value !== ''; });
		
		if(!empty($data['tgR_tGroup']))
		{
			$tGroups=$data['tgR_tGroup'];
			$tG="'".implode("','",$tGroups)."'";
			
			return $this->db->query("select * from `sha_one` where `study_tour_id` IN (".$tG.")")->result_array();
		}
		else
			return array();
	}
	
	function hfaListForRevisitsReport($data)
	{
		$dateFrom=normalToMysqlDate($data['RR_fromDueDate']);
		$dateTo=normalToMysqlDate($data['RR_toDueDate']);
		
		$sqlCommon=" and `status` IN('".implode("','",$data['RR_status'])."') and `state` IN('".implode("','",$data['RR_state'])."') order by `id`";
		
		$last_yearFrom=date('Y-m-d',strtotime($dateFrom." - 1 year"));
		$last_yearTo=date('Y-m-d',strtotime($dateTo." - 1 year"));
		$sql="select * from `hfa_one` where `status`='approved' and `revisit_duration`='12' and date(`date_status_changed`) >='".$last_yearFrom."' and date(`date_status_changed`) <='".$last_yearTo."' ".$sqlCommon;
		$query=$this->db->query($sql);//echo $this->db->last_query();
		$hfa=$query->result_array();
		
		$last_yearFrom6=date('Y-m-d',strtotime($dateFrom." - 6 months"));
		$last_yearTo6=date('Y-m-d',strtotime($dateTo." - 6 months"));
		$sql_6months="select * from `hfa_one` where `status`='approved' and `revisit_duration`='6' and date(`date_status_changed`) >='".$last_yearFrom6."' and date(`date_status_changed`) <='".$last_yearTo6."' ".$sqlCommon;;
		$query_6months=$this->db->query($sql_6months);//echo '<br>'.$this->db->last_query();
		$hfa_6months=$query_6months->result_array();
		
		$hfa_all=array_merge($hfa,$hfa_6months);
		return $hfa_all;
	}
	
	function incidentsListForReport($data)
	{
		if(!isset($data['IR_status']))
				return array();
		
		if($data['IR_for']=='sha')
		{
			if(!isset($data['IR_sha_status']))
				return array();
			
			$clgUniOption=$this->clgUniOptionSelected($data);//see($clgUniOption);
			
		$sqlClient='';	
		if(!empty($clgUniOption['client']) && $clgUniOption['client']['option']!='all')
		{
			if(isset($clgUniOption['client']['clients']))
			{
				$shaClientSet="'".implode("','",$clgUniOption['client']['clients'])."'";	
				$sqlClient=" and `client` IN(".$shaClientSet.")";
			}
			else
				return 	array();
		}
		
		$sqlColg='';
		if(!empty($clgUniOption['college']) && $clgUniOption['college']['option']!='all')
		{
			$shaClgSet="'".implode("','",$clgUniOption['college']['optionVal'])."'";
			if($clgUniOption['college']['option']=='clgUni_group')
				$sqlColg=" `college_group` IN(".$shaClgSet.")";
			elseif($clgUniOption['college']['option']=='selective')
				$sqlColg=" `college` IN(".$shaClgSet.")";
		}
			
			$shaStatusSet="'".implode("','",$data['IR_sha_status'])."'";
			
			$sql=" and `sha_id` IN(select `id` from `sha_one` where `status` IN(".$shaStatusSet.")".$sqlClient.")";
			if($sqlColg!='')
				$sql .=" and `sha_id` IN(select `id` from `sha_three` where ".$sqlColg.")";
		}
		else
		{
			if(!isset($data['IR_hfa_status']) || !isset($data['IR_hfa_state']))
				return array();
				
			$hfaStatusSet="'".implode("','",$data['IR_hfa_status'])."'";
			$hfaStateSet="'".implode("','",$data['IR_hfa_state'])."'";
			
			$sql=" and `hfa_id` IN(select `id` from `hfa_one` where `status` IN(".$hfaStatusSet.") and `state` IN(".$hfaStateSet."))";
		}
		
		$statusSet="'".implode("','",$data['IR_status'])."'";
		return $this->db->query("select * from `booking_incidents` where `status` IN(".$statusSet.") ".$sql." order by `incident_date` DESC")->result_array();
	}
	
	function membersListForWwccReport($data)
	{
		if(!isset($data['WR_status']) || !isset($data['WR_state']) || !isset($data['WR_wStatus']))
				return array();
		
		$hfaStatusSet="'".implode("','",$data['WR_status'])."'";
		$hfaStateSet="'".implode("','",$data['WR_state'])."'";
				
		return $this->db->query("select `hfa_members`.*, `hfa_one`.`fname` as `hfaOne_fname`, `hfa_one`.`lname` as `hfaOne_lname` from `hfa_members` join `hfa_one` on (`hfa_members`.`application_id`=`hfa_one`.`id`) where `hfa_one`.`step`='5' and `hfa_one`.`status` IN(".$hfaStatusSet.") and `hfa_one`.`state` IN(".$hfaStateSet.") order by `hfa_members`.`application_id`")->result_array();
	}
	
	function hfaListForInsuranceReport($data)
	{
		if(!isset($data['WR_status']) || !isset($data['WR_state']) || !isset($data['WR_wStatus']))
				return array();
		
		$hfaStatusSet="'".implode("','",$data['WR_status'])."'";
		$hfaStateSet="'".implode("','",$data['WR_state'])."'";
		
		return $this->db->query("select `hfa_three`.*, `hfa_one`.`fname`, `hfa_one`.`lname` from `hfa_three` join `hfa_one` ON (`hfa_three`.`id`=`hfa_one`.`id`) where `hfa_one`.`step`='5' and `hfa_one`.`status` IN(".$hfaStatusSet.") and `hfa_one`.`state` IN(".$hfaStateSet.") order by `hfa_three`.`id`")->result_array();
	}
	
	function feedbackListForFeedbackReport($data)
	{
		if($data['IR_fromDate']=='' || $data['IR_toDate']=='')
			return array();
				
		if($data['IR_for']=='sha')
		{
			if(!isset($data['IR_sha_status']))
				return array();
			
			$clgUniOption=$this->clgUniOptionSelected($data);//see($clgUniOption);
			
			$sqlClient='';	
		if(!empty($clgUniOption['client']) && $clgUniOption['client']['option']!='all')
		{
			if(isset($clgUniOption['client']['clients']))
			{
				$shaClientSet="'".implode("','",$clgUniOption['client']['clients'])."'";	
				$sqlClient=" and `client` IN(".$shaClientSet.")";
			}
			else
				return 	array();
		}
		
		$sqlColg='';
		if(!empty($clgUniOption['college']) && $clgUniOption['college']['option']!='all')
		{
			$shaClgSet="'".implode("','",$clgUniOption['college']['optionVal'])."'";
			if($clgUniOption['college']['option']=='clgUni_group')
				$sqlColg=" `college_group` IN(".$shaClgSet.")";
			elseif($clgUniOption['college']['option']=='selective')
				$sqlColg=" `college` IN(".$shaClgSet.")";
		}
			
			$shaStatusSet="'".implode("','",$data['IR_sha_status'])."'";
			
			$sql=" and `student` IN(select `id` from `sha_one` where `status` IN(".$shaStatusSet.")".$sqlClient.")";
			if($sqlColg!='')
				$sql .=" and `student` IN(select `id` from `sha_three` where ".$sqlColg.")";
		}
		else
		{
			if(!isset($data['IR_hfa_status']) || !isset($data['IR_hfa_state']))
				return array();
				
			$hfaStatusSet="'".implode("','",$data['IR_hfa_status'])."'";
			$hfaStateSet="'".implode("','",$data['IR_hfa_state'])."'";
			
			$sql=" and `host` IN(select `id` from `hfa_one` where `status` IN(".$hfaStatusSet.") and `state` IN(".$hfaStateSet."))";
		}
		
		$dateFrom=normalToMysqlDate($data['IR_fromDate']);
		$dateTo=normalToMysqlDate($data['IR_toDate']);		
		return $this->db->query("select `booking_feedbacks`.*, `sha_one`.`sha_student_no` as `sha_college_id`, `sha_one`.`id` as `sha_id`  from `booking_feedbacks` join `sha_one` on(`booking_feedbacks`.`student`=`sha_one`.`id`) where `booking_feedbacks`.`date` >='".$dateFrom."' and `booking_feedbacks`.`date` <='".$dateTo."'  ".$sql." order by `booking_feedbacks`.`date` DESC")->result_array();
	}
	
	function feedbackListForFeedbackEmailsReport($data)
	{
		if($data['FES_fromDate']=='' || $data['FES_toDate']=='')
			return array();
		
		$dateFrom=normalToMysqlDate($data['FES_fromDate']);
		$dateTo=normalToMysqlDate($data['FES_toDate']);		
		return $this->db->query("select `booking_feedbacks_emails`.*, `bookings`.`id` as `booking_id`, `bookings`.`student` as `sha_id`  from `booking_feedbacks_emails` join `bookings` on(`booking_feedbacks_emails`.`booking_id`=`bookings`.`id`) join `sha_one` on(`bookings`.`student`=`sha_one`.`id`) where date(`booking_feedbacks_emails`.`sent_on`) >='".$dateFrom."' and date(`booking_feedbacks_emails`.`sent_on`) <='".$dateTo."' order by `sha_one`.`fname`, `booking_feedbacks_emails`.`sent_on` DESC")->result_array();
	}
	
	function bookingListForCGServiceReport($data)
	{//see($data);
		if(!isset($data['CaR_status']))
			return array();
		
		//$clgUniOption=$this->clgUniOptionSelected($data);//see($clgUniOption);
		
		$sql="select * from `bookings` where `serviceOnlyBooking`='0' and `status` IN('".implode("','",$data['CaR_status'])."') ";
		if(isset($data['CaR_fromDate']) && isset($data['CaR_toDate']))
		{
			$fromDate=normalToMysqlDate($data['CaR_fromDate']);
			$toDate=normalToMysqlDate($data['CaR_toDate']);
			$sql .=" and  `booking_from`>='".$fromDate."' and `booking_from`<='".$toDate."'";
		}
		
		if($data['CaR_CG_option']=='all')
			$sqlCG="select `id` from `sha_two` where `guardianship`='1' and `guardian_assigned`!='0'";	
		else//$data['CaR_CG_option']==selective
		{
			$data['CaR_caregiverCompany']=array_filter($data['CaR_caregiverCompany']);
			$caregivers=array();
			foreach($data['CaR_caregiverCompany'] as $caregiverCompany)
			{
				$cgs=getCaregiversByCompany($caregiverCompany);
				if(!empty($cgs))
				{
					$cgIds=array();
					foreach($cgs as $cg)
						$cgIds[]=$cg['id'];
					$caregivers=array_merge($caregivers,$cgIds);
				}
			}
			if(empty($caregivers))
				return array();
			$caregiversList="'".implode("','",$caregivers)."'";
			$sqlCG="select `id` from `sha_two` where `guardianship`='1' and `guardian_assigned` IN(".$caregiversList.")";	
		}
		
		$sql .=" and `student` IN(".$sqlCG.") ";
		
		$sql .="order by `bookings`.`id`";	
		$query=$this->db->query($sql);//echo $this->db->last_query();
		$bookings=$query->result_array();
		return $bookings;
	}
	
	function invoiceReportResult($data)
	{
		//$students=$this->db->query("select * from `sha_one` where `arrival_date`>=? and `arrival_date`<=? and `client`=?",array($data['invoiceReport_fromDate'],$data['invoiceReport_toDate'],$data['invoiceReport_client']))->result_array();
		
		//return $this->db->query("select * from `invoice_initial` where `application_id` IN(select `id` from `sha_one` where `arrival_date`>=? and `arrival_date`<=? and `client`=?) and `study_tour`=?",array($data['invoiceReport_fromDate'],$data['invoiceReport_toDate'],$data['invoiceReport_client'],'0'))->result_array();
		
		return $this->db->query("select * from `invoice_initial_items` where `invoice_id` IN (select `id` from `invoice_initial` where `application_id` IN(select `id` from `sha_one` where `arrival_date`>=? and `arrival_date`<=? and `client`=?) and `study_tour`=?) order by `invoice_id`, `id`",array(normalToMysqlDate($data['invoiceReport_fromDate']),normalToMysqlDate($data['invoiceReport_toDate']),$data['invoiceReport_client'],'0'))->result_array();
	}
	
	function bookingListForBookingCheckupReport($data)
	{
		if(!isset($data['CaR_status']))
			return array();
		
		$clgUniOption=$this->clgUniOptionSelected($data);//see($clgUniOption);
		
		$sql="select `bookings`.*, `booking_checkups`.`checkup_date` as `checkup_date`, `booking_checkups`.`notes` as `checkup_notes` from `bookings` JOIN `booking_checkups` ON(`bookings`.`id`=`booking_checkups`.`booking`)  where `serviceOnlyBooking`='0' and `status` IN('".implode("','",$data['CaR_status'])."') ";
		if(isset($data['CaR_fromDate']) && isset($data['CaR_toDate']))
		{
			$fromDate=normalToMysqlDate($data['CaR_fromDate']);
			$toDate=normalToMysqlDate($data['CaR_toDate']);
			$sql .=" and  `booking_from`>='".$fromDate."' and `booking_from`<='".$toDate."'";
		}
		
		if(isset($data['CaR_activeFromDate']) && isset($data['CaR_activeToDate']))
		{
			$fromDate=normalToMysqlDate($data['CaR_activeFromDate']);
			$toDate=normalToMysqlDate($data['CaR_activeToDate']);
			
			$sql .=" and  (";
			$sql .=" (`booking_from`>='".$fromDate."' and `booking_from`<='".$toDate."')";//start date b/w range
			$sql .=" OR ( `booking_to`>='".$fromDate."' and `booking_to`<='".$toDate."')";//end date b/w range
			$sql .=" OR ( `booking_from`<='".$fromDate."' and `booking_to`>='".$toDate."')";// range is b/w the start and end date
			$sql .=" OR ( `booking_to`='0000-00-00' and `booking_from`<='".$toDate."')";//when booking end date is not set and booking is active in the date range
			$sql .=" )";
		}
		
		if(!empty($clgUniOption['client']) && $clgUniOption['client']['option']!='all')
		{
			if(isset($clgUniOption['client']['clients']))
			{
				$shaClientSet="'".implode("','",$clgUniOption['client']['clients'])."'";	
				$sqlClient=" where `client` IN(".$shaClientSet.")";
				$sql .=" and `student` IN(select `id` from `sha_one` ".$sqlClient.") ";
			}
			else
				return 	array();
		}
		
		if(!empty($clgUniOption['college']) && $clgUniOption['college']['option']!='all')
		{
			$shaClgSet="'".implode("','",$clgUniOption['college']['optionVal'])."'";
			if($clgUniOption['college']['option']=='clgUni_group')
				$sqlColg=" where `college_group` IN(".$shaClgSet.")";
			elseif($clgUniOption['college']['option']=='selective')
				$sqlColg=" where `college` IN(".$shaClgSet.")";
				
			$sql .=" and `student` IN(select `id` from `sha_three` ".$sqlColg.") ";
		}
		
		$sql .=" and `booking_checkups`.`type`='3' ";
		$sql .="order by `bookings`.`id`";	
		$query=$this->db->query($sql);//echo $this->db->last_query();
		$bookings=$query->result_array();
		return $bookings;
	}
	
	function bookingListForProfitReport($data)
	{
		if(!isset($data['CaR_status']))
			return array();
		
		//$clgUniOption=$this->clgUniOptionSelected($data);//see($clgUniOption);
		
		$sql="select * from `bookings` where `serviceOnlyBooking`='0' and `status` IN('".implode("','",$data['CaR_status'])."') ";
		
		if(isset($data['CaR_activeFromDate']) && isset($data['CaR_activeToDate']))
		{
			$fromDate=normalToMysqlDate($data['CaR_activeFromDate']);
			$toDate=normalToMysqlDate($data['CaR_activeToDate']);
			
			$sql .=" and  (";
			$sql .=" (`booking_from`>='".$fromDate."' and `booking_from`<='".$toDate."')";//start date b/w range
			$sql .=" OR ( `booking_to`>='".$fromDate."' and `booking_to`<='".$toDate."')";//end date b/w range
			$sql .=" OR ( `booking_from`<='".$fromDate."' and `booking_to`>='".$toDate."')";// range is b/w the start and end date
			$sql .=" OR ( `booking_to`='0000-00-00' and `booking_from`<='".$toDate."')";//when booking end date is not set and booking is active in the date range
			$sql .=" )";
		}
		
		$sql .="order by `bookings`.`id`";	
		$query=$this->db->query($sql); //echo $this->db->last_query();
		$bookings=$query->result_array();//return $this->db->query("select * from `bookings` where `student`='24922'")->result_array();
		return $bookings;
	}
	
	function bookingListForBookingHolidayCheckupReport($data)
	{
		if(!isset($data['CaR_status']))
			return array();
		
		$clgUniOption=$this->clgUniOptionSelected($data);//see($clgUniOption);
		
		$sql="select `bookings`.*, `booking_holidays`.`id` as `holiday_id`, `booking_holidays`.`start` as `holiday_start`, `booking_holidays`.`end` as `holiday_end` from `bookings` JOIN `booking_holidays` ON(`bookings`.`id`=`booking_holidays`.`booking_id`)  where `serviceOnlyBooking`='0' and `status` IN('".implode("','",$data['CaR_status'])."') ";
		if(isset($data['CaR_fromDate']) && isset($data['CaR_toDate']))
		{
			if($data['CaR_holidayDateType']=='holiday_startDate')
				$holidayFromTo='start';
			else	
				$holidayFromTo='end';
			$fromDate=normalToMysqlDate($data['CaR_fromDate']);
			$toDate=normalToMysqlDate($data['CaR_toDate']);
			$sql .=" and  `booking_holidays`.`".$holidayFromTo."`>='".$fromDate."' and `booking_holidays`.`".$holidayFromTo."`<='".$toDate."'";
		}
		
		if(!empty($clgUniOption['client']) && $clgUniOption['client']['option']!='all')
		{
			if(isset($clgUniOption['client']['clients']))
			{
				$shaClientSet="'".implode("','",$clgUniOption['client']['clients'])."'";	
				$sqlClient=" where `client` IN(".$shaClientSet.")";
				$sql .=" and `student` IN(select `id` from `sha_one` ".$sqlClient.") ";
			}
			else
				return 	array();
		}
		
		if(!empty($clgUniOption['college']) && $clgUniOption['college']['option']!='all')
		{
			$shaClgSet="'".implode("','",$clgUniOption['college']['optionVal'])."'";
			if($clgUniOption['college']['option']=='clgUni_group')
				$sqlColg=" where `college_group` IN(".$shaClgSet.")";
			elseif($clgUniOption['college']['option']=='selective')
				$sqlColg=" where `college` IN(".$shaClgSet.")";
				
			$sql .=" and `student` IN(select `id` from `sha_three` ".$sqlColg.") ";
		}
		
		$sql .="order by `bookings`.`id`";	
		$query=$this->db->query($sql);//echo $this->db->last_query();
		$bookings=$query->result_array();
		return $bookings;
	}
	
	function getLinkedHolidayCheckup($booking,$holidayDateType)
	{
		if($holidayDateType=='holiday_startDate')
		{
			$type='4';
			$date=$booking['holiday_start'];
		}
		else
		{
			$type='5';
			$date=$booking['holiday_end'];
		}
		$sql="select * from `booking_checkups` where `booking`=? and `type`=?";
		$checkups=$this->db->query($sql,array($booking['id'],$type))->result_array();
		
		$allDates=array();
		foreach($checkups as $checkup)
			$allDates	[]=$checkup['checkup_date'];
		
		$closestDate=find_closestDate($allDates, $date);
		$linkedCheckup=array();
		foreach($checkups as $checkup)
		{
			if($checkup['checkup_date']==$closestDate)
			{
				$linkedCheckup=$checkup;
				break;
			}
		}
		return $linkedCheckup;
	}

function ClientsReport($data)
{
	$sql ="select * from `clients` where `state` IN ('".implode("','",$data['CaR_state'])."')";

	if(count($data['CaR_state']) == 8 )
	{
		$sql =" select * from `clients`";

		if(!empty($data) && $data['CaR_client_option']!='all' )
		{
			if($data['CaR_client_option'] == 'allClientGroups')
			{
				$sql.=" where `client_group`!=''";
			}
			elseif($data['CaR_client_option'] == 'allIndividuals')
			{
				$sql.=" where `client_group`=''";
			}
			elseif($data['CaR_client_option'] == 'selectiveClientGroup')
			{	$clientGroups=array_filter($data['CaR_client_group']);
				$sql.=" where `client_group` IN('".implode("','",$clientGroups)."')";
			}
			elseif($data['CaR_client_option'] == 'selectiveClientType')
			{	$clientTypes=array_filter($data['CaR_client_type']);
				$sql.=" where `category` IN('".implode("','",$clientTypes)."')";
			}
			else
				return array();
		}
	}
	else
	{
		if(!empty($data) && $data['CaR_client_option']!='all' )
		{
			if($data['CaR_client_option'] == 'allClientGroups')
			{
				$sql.=" and `client_group`!=''";
			}
			elseif($data['CaR_client_option'] == 'allIndividuals')
			{
				$sql.=" and `client_group`=''";
			}
			elseif($data['CaR_client_option'] == 'selectiveClientGroup')
			{	$clientGroups=array_filter($data['CaR_client_group']);
				$sql.=" and `client_group` IN('".implode("','",$clientGroups)."')";
			}
			elseif($data['CaR_client_option'] == 'selectiveClientType')
			{	$clientTypes=array_filter($data['CaR_client_type']);
				$sql.=" and `category` IN('".implode("','",$clientTypes)."')";
			}
			else
				return array();
		}
	}

	$sql .="order by `clients`.`bname`";
	$query=$this->db->query($sql); //echo $this->db->last_query();
	$clients=$query->result_array();
	return $clients;
}


	function bookingListForComparisonReport($data)
	{
		$clgUniOption=$this->clgUniOptionSelected($data);//see($clgUniOption);		
		$sql="select * from `bookings` where `serviceOnlyBooking`='0'";
		$sql1="select * from `bookings` where `serviceOnlyBooking`='0'";
		if(isset($data['CaR_fromDate']) && isset($data['CaR_toDate']) && isset($data['CaR_fromDate_two']) && isset($data['CaR_toDate_two']))
		{
			$fromDate=normalToMysqlDate($data['CaR_fromDate']);
			$fromDate1=normalToMysqlDate($data['CaR_fromDate_two']);
			$toDate=normalToMysqlDate($data['CaR_toDate']);
			$toDate1=normalToMysqlDate($data['CaR_toDate_two']);
			$sql .=" and  `booking_from`>='".$fromDate."' and `booking_from`<='".$toDate."'";
			$sql1 .=" and  `booking_from`>='".$fromDate1."' and `booking_from`<='".$toDate1."'";
		}
		 
		
		if(!empty($clgUniOption['client']) && $clgUniOption['client']['option']!='all')
		{
			if(isset($clgUniOption['client']['clients']))
			{
				$shaClientSet="'".implode("','",$clgUniOption['client']['clients'])."'";	
				$sqlClient=" where `client` IN(".$shaClientSet.")";
				$sql .=" and `student` IN(select `id` from `sha_one` ".$sqlClient.") ";
				$sql1 .=" and `student` IN(select `id` from `sha_one` ".$sqlClient.") ";
			}
			else
				return 	array();
		}
		
		if(!empty($clgUniOption['college']) && $clgUniOption['college']['option']!='all')
		{
			$shaClgSet="'".implode("','",$clgUniOption['college']['optionVal'])."'";
			if($clgUniOption['college']['option']=='clgUni_group')
				$sqlColg=" where `college_group` IN(".$shaClgSet.")";
			elseif($clgUniOption['college']['option']=='selective')
				$sqlColg=" where `college` IN(".$shaClgSet.")";
				
			$sql .=" and `student` IN(select `id` from `sha_three` ".$sqlColg.") ";
			$sql1 .=" and `student` IN(select `id` from `sha_three` ".$sqlColg.") ";
		}
		
		$sql .="order by `bookings`.`id`";	
		$sql1 .="order by `bookings`.`id`";	
		$query=$this->db->query($sql);//echo $this->db->last_query();
		$query1=$this->db->query($sql1);//echo $this->db->last_query();
		$bookings['sheet1']=$query->result_array();
		$bookings['sheet2']=$query1->result_array();
		return $bookings;

	}

	function countBookings($data)
	{	$count = [];
		$clgUniOption=$this->clgUniOptionSelected($data);//see($clgUniOption);//die();
		if(!empty($clgUniOption['client']))
		{	
			if($clgUniOption['client']['option']!='all')
			{
				if($clgUniOption['client']['option']=='client_group')
				{	
					if(isset($clgUniOption['client']['clients']))
					{
					foreach($clgUniOption['client']['clients'] as $k )
					{
						$sql="select count(*),`clients`.`bname` from `bookings` left JOIN `sha_one` on `bookings`.`student` = `sha_one`.`id` left join `clients` on `sha_one`.`client`=`clients`.`id` where `serviceOnlyBooking`='0'";
						$sql1="select count(*),`clients`.`bname` from `bookings` left JOIN `sha_one` on `bookings`.`student` = `sha_one`.`id` left join `clients` on `sha_one`.`client`=`clients`.`id` where `serviceOnlyBooking`='0'";
						if(isset($data['CaR_fromDate']) && isset($data['CaR_toDate']) && isset($data['CaR_fromDate_two']) && isset($data['CaR_toDate_two']))
						{
							$fromDate=normalToMysqlDate($data['CaR_fromDate']);
							$fromDate1=normalToMysqlDate($data['CaR_fromDate_two']);
							$toDate=normalToMysqlDate($data['CaR_toDate']);
							$toDate1=normalToMysqlDate($data['CaR_toDate_two']);
							$sql .=" and  `bookings`.`booking_from`>='".$fromDate."' and `bookings`.`booking_from`<='".$toDate."'";
							$sql1 .=" and  `bookings`.`booking_from`>='".$fromDate1."' and `bookings`.`booking_from`<='".$toDate1."'";
						$sql .="and  `clients`.`id` in ('".$k."') order by `clients`.`bname`"	;
						$sql1 .="and  `clients`.`id` in ('".$k."') order by `clients`.`bname`";	
						}
						else
							return 	array();
					
						$query=$this->db->query($sql);//echo $this->db->last_query();
						$query1=$this->db->query($sql1);//echo $this->db->last_query();
						$count['year1'][]=$query->row_array();
						$count['year2'][]=$query1->row_array();
					}
					}	
				}
				elseif($clgUniOption['client']['option']=='selective')
				{
					foreach($clgUniOption['client']['clients'] as $k )
					{
						$sql="select count(*),`clients`.`bname` from `bookings` left JOIN `sha_one` on `bookings`.`student` = `sha_one`.`id` left join `clients` on `sha_one`.`client`=`clients`.`id` where `serviceOnlyBooking`='0'";
						$sql1="select count(*),`clients`.`bname` from `bookings` left JOIN `sha_one` on `bookings`.`student` = `sha_one`.`id` left join `clients` on `sha_one`.`client`=`clients`.`id` where `serviceOnlyBooking`='0'";
						if(isset($data['CaR_fromDate']) && isset($data['CaR_toDate']) && isset($data['CaR_fromDate_two']) && isset($data['CaR_toDate_two']))
						{
							$fromDate=normalToMysqlDate($data['CaR_fromDate']);
							$fromDate1=normalToMysqlDate($data['CaR_fromDate_two']);
							$toDate=normalToMysqlDate($data['CaR_toDate']);
							$toDate1=normalToMysqlDate($data['CaR_toDate_two']);
							$sql .=" and  `bookings`.`booking_from`>='".$fromDate."' and `bookings`.`booking_from`<='".$toDate."'";
							$sql1 .=" and  `bookings`.`booking_from`>='".$fromDate1."' and `bookings`.`booking_from`<='".$toDate1."'";
						$sql .="and  `clients`.`id` in ('".$k."') order by `clients`.`bname`"	;
						$sql1 .="and  `clients`.`id` in ('".$k."') order by `clients`.`bname`";	
						}
						else
							return 	array();
					
						$query=$this->db->query($sql);//echo $this->db->last_query();
						$query1=$this->db->query($sql1);//echo $this->db->last_query();
						$count['year1'][]=$query->row_array();
						$count['year2'][]=$query1->row_array();
					}	
				}
			}
			elseif(!empty($clgUniOption['client']) && $clgUniOption['client']['option']=='all')
			{
				// $sqlClient="select `id` from `clients` where `category` IN ('1','2')";
				$sqlClient="select `id` from `clients` ";
				$clgUniOption['client']['clients']=$this->db->query($sqlClient)->result_array();
				foreach($clgUniOption['client']['clients'] as $k )
				{
					$sql="select count(*),`clients`.`bname` from `bookings` left JOIN `sha_one` on `bookings`.`student` = `sha_one`.`id` left join `clients` on `sha_one`.`client`=`clients`.`id` where `serviceOnlyBooking`='0'";
					$sql1="select count(*),`clients`.`bname` from `bookings` left JOIN `sha_one` on `bookings`.`student` = `sha_one`.`id` left join `clients` on `sha_one`.`client`=`clients`.`id` where `serviceOnlyBooking`='0'";
					if(isset($data['CaR_fromDate']) && isset($data['CaR_toDate']) && isset($data['CaR_fromDate_two']) && isset($data['CaR_toDate_two']))
					{
						$fromDate=normalToMysqlDate($data['CaR_fromDate']);
						$fromDate1=normalToMysqlDate($data['CaR_fromDate_two']);
						$toDate=normalToMysqlDate($data['CaR_toDate']);
						$toDate1=normalToMysqlDate($data['CaR_toDate_two']);
						$sql .=" and  `bookings`.`booking_from`>='".$fromDate."' and `bookings`.`booking_from`<='".$toDate."'";
						$sql1 .=" and  `bookings`.`booking_from`>='".$fromDate1."' and `bookings`.`booking_from`<='".$toDate1."'";
					$sql .="and  `clients`.`id` in ('".$k['id']."') order by `clients`.`bname`"	;
					$sql1 .="and  `clients`.`id` in ('".$k['id']."') order by `clients`.`bname`";	
					}
					else
						return 	array();
				
					$query=$this->db->query($sql);//echo $this->db->last_query();
					$query1=$this->db->query($sql1);//echo $this->db->last_query();
					$count['year1'][]=$query->row_array();
					$count['year2'][]=$query1->row_array();
				}		
			}
		}

		elseif(!empty($clgUniOption['college']))
		{
			if($clgUniOption['college']['option']!='all')
			{
				if($clgUniOption['college']['option']=='clgUni_group')
				{
					$optionVal=array_filter($clgUniOption['college']['optionVal']);
					$sqlCollegeGroup="select `id` from `clients` where `client_group` ";
					$sqlCollegeGroup .="IN('".implode("','",$optionVal)."')";
					$clgUniOption['college']['colleges']=$this->db->query($sqlCollegeGroup)->result_array();
					foreach($clgUniOption['college']['colleges'] as $k )
					{
						$sqlclg="select count(*),`clients`.`bname` from `bookings` left JOIN `sha_one` on `bookings`.`student` = `sha_one`.`id` left join `clients` on `sha_one`.`college`=`clients`.`id` where `serviceOnlyBooking`='0'";
						$sqlclg1="select count(*), `clients`.`bname` from `bookings` left JOIN `sha_one` on `bookings`.`student` = `sha_one`.`id` left join `clients` on `sha_one`.`college`=`clients`.`id` where `serviceOnlyBooking`='0'";
						if(isset($data['CaR_fromDate']) && isset($data['CaR_toDate']) && isset($data['CaR_fromDate_two']) && isset($data['CaR_toDate_two']))
						{
							$fromDate=normalToMysqlDate($data['CaR_fromDate']);
							$fromDate1=normalToMysqlDate($data['CaR_fromDate_two']);
							$toDate=normalToMysqlDate($data['CaR_toDate']);
							$toDate1=normalToMysqlDate($data['CaR_toDate_two']);
							$sqlclg .=" and  `bookings`.`booking_from`>='".$fromDate."' and `bookings`.`booking_from`<='".$toDate."'";
							$sqlclg1 .=" and  `bookings`.`booking_from`>='".$fromDate1."' and `bookings`.`booking_from`<='".$toDate1."'";
						$sqlclg .="and  `clients`.`id` in ('".$k['id']."') order by `clients`.`bname`";
						$sqlclg1 .="and  `clients`.`id` in ('".$k['id']."') order by `clients`.`bname`";	
						}
						else
							return 	array();
					
						$query=$this->db->query($sqlclg);//echo $this->db->last_query();
						$query1=$this->db->query($sqlclg1);//echo $this->db->last_query();
						$count['year1'][]=$query->row_array();
						$count['year2'][]=$query1->row_array();
					}		
				}
				elseif($clgUniOption['college']['option']=='selective')
				{
					$optionVal=array_filter($clgUniOption['college']['optionVal']);
					$sqlCollegeGroup="select `id` from `clients` where `bname` ";
					$sqlCollegeGroup .="IN('".implode("','",$optionVal)."')";
					$clgUniOption['college']['colleges']=$this->db->query($sqlCollegeGroup)->result_array();see($clgUniOption['college']['colleges']);
					foreach($clgUniOption['college']['colleges'] as $k )
					{
						$sqlclg="select count(*),`clients`.`bname` from `bookings`left JOIN `sha_one` on `bookings`.`student` = `sha_one`.`id` left join `clients` on `sha_one`.`college`=`clients`.`id` where `serviceOnlyBooking`='0'";
						$sqlclg1="select count(*), `clients`.`bname` from `bookings` left JOIN `sha_one` on `bookings`.`student` = `sha_one`.`id` left join `clients` on `sha_one`.`college`=`clients`.`id` where `serviceOnlyBooking`='0'";
						if(isset($data['CaR_fromDate']) && isset($data['CaR_toDate']) && isset($data['CaR_fromDate_two']) && isset($data['CaR_toDate_two']))
						{
							$fromDate=normalToMysqlDate($data['CaR_fromDate']);
							$fromDate1=normalToMysqlDate($data['CaR_fromDate_two']);
							$toDate=normalToMysqlDate($data['CaR_toDate']);
							$toDate1=normalToMysqlDate($data['CaR_toDate_two']);
							$sqlclg .=" and  `bookings`.`booking_from`>='".$fromDate."' and `bookings`.`booking_from`<='".$toDate."'";
							$sqlclg1 .=" and  `bookings`.`booking_from`>='".$fromDate1."' and `bookings`.`booking_from`<='".$toDate1."'";
						$sqlclg .="and  `clients`.`id` in ('".$k['id']."') order by `clients`.`bname`"	;
						$sqlclg1 .="and  `clients`.`id` in ('".$k['id']."') order by `clients`.`bname`";	
						}
						else
							return 	array();
					
						$query=$this->db->query($sqlclg);//echo $this->db->last_query();
						$query1=$this->db->query($sqlclg1);//echo $this->db->last_query();
						$count['year1'][]=$query->row_array();
						$count['year2'][]=$query1->row_array();
					}		
				}
			}
			elseif(!empty($clgUniOption['college']) && $clgUniOption['college']['option']=='all')
			{
				$sqlClient="select `id` from `clients` where `category` IN ('3','4')";
				$clgUniOption['college']['colleges']=$this->db->query($sqlClient)->result_array();
				foreach($clgUniOption['college']['colleges'] as $k )
				{
					$sqlclg="select count(*),`clients`.`bname` from `bookings`left JOIN `sha_one` on `bookings`.`student` = `sha_one`.`id` left join `clients` on `sha_one`.`college`=`clients`.`id` where `serviceOnlyBooking`='0'";
					$sqlclg1="select count(*),`clients`.`bname` from `bookings` left JOIN `sha_one` on `bookings`.`student` = `sha_one`.`id` left join `clients` on `sha_one`.`college`=`clients`.`id` where `serviceOnlyBooking`='0'";
					if(isset($data['CaR_fromDate']) && isset($data['CaR_toDate']) && isset($data['CaR_fromDate_two']) && isset($data['CaR_toDate_two']))
					{
						$fromDate=normalToMysqlDate($data['CaR_fromDate']);
						$fromDate1=normalToMysqlDate($data['CaR_fromDate_two']);
						$toDate=normalToMysqlDate($data['CaR_toDate']);
						$toDate1=normalToMysqlDate($data['CaR_toDate_two']);
						$sqlclg .=" and  `bookings`.`booking_from`>='".$fromDate."' and `bookings`.`booking_from`<='".$toDate."'";
						$sqlclg1 .=" and  `bookings`.`booking_from`>='".$fromDate1."' and `bookings`.`booking_from`<='".$toDate1."'";
					$sqlclg .="and  `clients`.`id` in ('".$k['id']."') order by `clients`.`bname`"	;
					$sqlclg1 .="and  `clients`.`id` in ('".$k['id']."') order by `clients`.`bname`";	
					}
					else
						return 	array();
				
					$query=$this->db->query($sqlclg);//echo $this->db->last_query();
					$query1=$this->db->query($sqlclg1);//echo $this->db->last_query();
					$count['year1'][]=$query->row_array();
					$count['year2'][]=$query1->row_array();
				}		
			}
		}
		return $count;
	}

	// function familyTrainingAttendenceReport($data)
	// {
	// 	see($data);//die();
	// 	//echo $data['HR_type'];
	// 	if(isset($data['HR_type']))
	// 	{
	// 	$status=$data['HR_status'];
	// 	$statusList="'".implode("','",$status)."'";
	// 	if(in_array('HSN',$data['HR_type']))
	// 	{
	// 	$sql="select `hfa_one`.`id`,`hfa_one`.`fname`,`hfa_one`.`lname`,`hfa_one`.`email`,`hfa_one`.`mobile`,`sha_one`.`id` as shaid,`sha_one`.`fname` as shafname,`sha_one`.`lname` as shalname,`sha_one`.`dob` as shadob,`sha_one`.`nominated_hfa_id`,`sha_three`.`college` from `hfa_one` left JOIN `sha_one` ON `sha_one`.`nominated_hfa_id`=`hfa_one`.`id` LEFT JOIN `sha_three` on `sha_three`.`id`=`sha_one`.`id` where";
	// 	$sql.=" `hfa_one`.`status` IN (".$statusList.") ";
	// 	$sql.=" and `sha_one`.`homestay_nomination`='1' ";
	// 	}
	// 	if(in_array('U18',$data['HR_type']))
	// 	{
	// 		$sql.=" and FLOOR(ABS(DATEDIFF(CURRENT_TIMESTAMP, `sha_one`.`dob`))/365.25)<'18' ";
	// 	}
		
	// 	$query=$this->db->query($sql);
	// 	$res=$query->result_array();echo $this->db->last_query();
	// }else{
	// 	$res=array();
	// }
	// 	see($res);die();
	// }

}