<?php
class Tour_model extends CI_Model {
	function validateTour($data)
	{
			$sql="";
			if(isset($data['id']))
				$sql .=" and `id`!='".$data['id']."'";
			$sqlBname="Select * from `study_tours` where `group_name` = ?".$sql;
			$queryBname=	$this->db->query($sqlBname,$data['group_name']);

			//echo $this->db->last_query();
			if ($queryBname->num_rows() > 0)
				$bname=1;
			else
				$bname=0;
			if($bname==1)
				return array('group_name'=>$bname);
			else
				return 'yes';
		}
		function checkMissingBookingDates($data)
		{
			$sql="select * from `sha_one` where `status`!='cancelled' AND (`booking_from`='0000-00-00' OR `booking_to`='0000-00-00') AND study_tour_id=".$data['shaChangeStatus_id'];
			$query=$this->db->query($sql);
			if($query->num_rows()>0)
			{
				return $query->result_array();
			}
			else
			{
				return 'not_found';
			}
		}
		function changeStatus($data)
		{
			//print_r($data);exit;
			$tourDetail=tourDetail($data['shaChangeStatus_id']);

			if($data['shaChangeStatus_status']=='pending_invoice')
			{

			}
			if($data['shaChangeStatus_status']=='cancelled')
			{
				if($data['shaChangeStatus_date']!='')
					$shaChangeStatus_date=normalToMysqlDate($data['shaChangeStatus_date']);
				else
					$shaChangeStatus_date=date('Y-m-d');
			}
			else
			{
				$shaChangeStatus_date=date('Y-m-d');
			}
			$sql="update `study_tours` set `status`='".$data['shaChangeStatus_status']."', `date_status_changed`='$shaChangeStatus_date' where `id`='".$data['shaChangeStatus_id']."'";
			$this->db->query($sql);

			if(isset($data['hfaChangeStatus_reason']) && !empty($data['hfaChangeStatus_reason']))
			{
				$sql_update_reason="update `study_tours` set `reason`='".$data['hfaChangeStatus_reason']."' where `id`='".$data['shaChangeStatus_id']."'";
				$this->db->query($sql_update_reason);
			}
			//echo $this->db->last_query();
			//upate the status of students to only those whose status are not canceled

			$sqlSha_one="update `sha_one` set `status`='".$data['shaChangeStatus_status']."'  where `study_tour_id`='".$data['shaChangeStatus_id']."' and `status` != 'cancelled'";

			$this->db->query($sqlSha_one);

			//Group invoices
			if($data['shaChangeStatus_status']=='pending_invoice' && $tourDetail['status']!='pending_invoice')
					{
						$this->addPendingInvoice($data['shaChangeStatus_id']);
					}

		}

		function createTour($data)

		{

			$sql="insert into `study_tours` (`group_name`,`group_contact_name`,`no_of_chaperones`,`group_contact_email`,`group_contact_phone_no`,`client_id`,`employee_id`,`status`,`created`) values(?,?,?,?,?,?,?,?,?)";

			$this->db->query($sql,array($data['group_name'],$data['group_contact_name'],$data['no_of_chaperones'],$data['group_contact_email'],$data['group_contact_phone_no'],$data['client_id'],$data['employee_id'],'new',date('Y-m-d H:i:s')));

			return $this->db->insert_id();

		}



		function editTour($data)

		{

			$sql="update `study_tours` set `group_name`=?,`group_contact_name`=?,`no_of_chaperones`=?,`group_contact_email`=?,`group_contact_phone_no`=?,`client_id`=?,`employee_id`=? WHERE `id`=?";

			$this->db->query($sql,array($data['group_name'],$data['group_contact_name'],$data['no_of_chaperones'],$data['group_contact_email'],$data['group_contact_phone_no'],$data['client_id'],$data['employee_id'],$data['id']));
			
			$sqlSha="update `sha_one` set `employee`=?,`client`=? where `study_tour_id`=?";
			$this->db->query($sqlSha,array($data['employee_id'],$data['client_id'],$data['id']));
		}



		function toursList($get)

		{

			$sqlStatus='';
			if(!empty($get))
			{
				if(isset($get['tourStatus']) && $get['tourStatus']!='')
					$sqlStatus=" where `study_tours`.`status` like '".$get['tourStatus']."'";
			}
			//$sql="select * from `study_tours` order by `group_name`";

			/*$sql="SELECT study_tours.*,clients.bname AS client_name,COUNT(sha_one.id) AS no_of_studets,COUNT(CASE WHEN sha_one.status = 'cancelled' THEN 1 END) AS `cancelled_students`,COUNT(warnings_study_tours.id) as no_of_warnings FROM study_tours
			
			LEFT JOIN clients ON study_tours.client_id = clients.id
			LEFT JOIN sha_one ON study_tours.id = sha_one.study_tour_id
			LEFT JOIN warnings_study_tours ON warnings_study_tours.study_tour_id = sha_one.study_tour_id AND sha_one.id= warnings_study_tours.sha_one_id
			".$sqlStatus."
			GROUP BY study_tours.id
			ORDER BY study_tours.created DESC";*/
			
			$sql="SELECT study_tours.*,clients.bname AS client_name,COUNT(sha_one.id) AS no_of_studets,COUNT(CASE WHEN sha_one.status = 'cancelled' THEN 1 END) AS `cancelled_students` FROM study_tours
			
			LEFT JOIN clients ON study_tours.client_id = clients.id
			LEFT JOIN sha_one ON study_tours.id = sha_one.study_tour_id
			".$sqlStatus."
			GROUP BY study_tours.id
			ORDER BY study_tours.created DESC";

			$query=$this->db->query($sql);

			$list=$query->result_array();



			// foreach($list as $cK=>$cV)

			// {

				// $agreement=array();

				// $agreement=$this->clientAgreement($cV['id']);

				// if(!empty($agreement))

					// $list[$cK]['agreement']=$agreement;

			// }

			return $list;

		}



		function deleteTour($id)

		{
			$tour=$this->tourDetail($id);
			$sql="delete from `study_tours` where `id`='".$id."'";
			$this->db->query($sql);
			

			$sql_students="select id from `sha_one` where `study_tour_id`='".$id."'";
			$query_students=$this->db->query($sql_students);
			$rows_students=$query_students->result_array();
			$students_id_array = array();
			foreach($rows_students as $single_row) 
			{
				$students_id_array[]=$single_row['id'];
			}
			if(!empty($students_id_array))
			{
				// delete sha_three entries
				$sql_sha_three='delete from `sha_three` where `id` IN('.implode(',',$students_id_array).')' ;
				$this->db->query($sql_sha_three);	
				// delete sha_two entries
				$sql_sha_two='delete from `sha_two` where `id` IN('.implode(',',$students_id_array).')';
				$this->db->query($sql_sha_two);	
				// delete show_one entries
				$sql_sha_one="delete from `sha_one` where `study_tour_id`='".$id."'";
				$this->db->query($sql_sha_one);
			}
		}
		function deleteClientAgreement($id)
		{

			$sql="select * from `client_agreement` where `id`='".$id."'";

			$query=$this->db->query($sql);

			$row=$query->row_array();

			if(!empty($row))

			{

				unlink('static/uploads/client/'.$row['name']);

				$sqlDel="delete from `client_agreement` where `id`='".$id."'";

				$this->db->query($sqlDel);

			}

		}



		function tourDetail($id)

		{

			$sql="select * from `study_tours` where `id`='".$id."'";

			$query=$this->db->query($sql);

			$tour=$query->row_array();



			/*

			if(!empty($client))

			{

				$agreement=$this->clientAgreement($id);

				if(!empty($agreement))

					$client['agreement']=$agreement;

			}

			*/

			return $tour;

		}

		
		function resetInitialInvoice($invoice_id,$tour_id)
		{
			$items=studyTourInitialInvoiceItems($tour_id);
			
			$sql="update `invoice_initial` set `booking_from`=?, `booking_to`=? where `id`=?";
			$this->db->query($sql, array($items[0]['booking_from'],date('Y-m-d',strtotime($items[0]['booking_from'].' + 4 weeks -1 day')),$invoice_id));
			
			$sqlDel="delete from `invoice_initial_items` where `invoice_id`='".$invoice_id."'";
			$this->db->query($sqlDel);
			
			$this->addPendingInvoice2ndPart($items,$invoice_id);
		}

		function addPendingInvoice($id)
		{
			$items=studyTourInitialInvoiceItems($id);
			//see($items);
			$invoice_id=nextInvoiceId();
			$sql="insert into `invoice_initial` (`id`,`application_id`,`study_tour`, `booking_from`, `booking_to`, `date`) values (?,?,?,?,?,?)";
			$this->db->query($sql, array($invoice_id,$id,'1',$items[0]['booking_from'],date('Y-m-d',strtotime($items[0]['booking_from'].' + 4 weeks -1 day')),date('Y-m-d H:i:s')));
			//$invoice_id=$this->db->insert_id();
			
			$this->addPendingInvoice2ndPart($items,$invoice_id);
		}
		
		function addPendingInvoice2ndPart($items,$invoice_id)
		{
			foreach($items as $item)
			{
				$invoice=$item;
				/////////////
				foreach($item as $itemK=>$itemV)
				{
					  if($itemK!='booking_from' && $itemK!='booking_to' && $itemK!='standard' && $itemK!='student' && $itemK!='student_id')
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
									  /*$minusDays=$invoice['accomodation_fee_ed']['qty']+1;*/
									  $minusDays=$invoice['accomodation_fee_ed']['qty'];
									  $itemV['desc'] .=dateFormat(date('Y-m-d',strtotime($invoice['booking_to'].' - '.$minusDays .' days')));	
								  }
								  else
								  {
									  /*$itemV['desc'] .=dateFormat(date('Y-m-d',strtotime($invoice['booking_to'].' - 1 days')));*/	
									  $itemV['desc'] .=dateFormat(date('Y-m-d',strtotime($invoice['booking_to'])));	
								  }
								  $itemV['desc'] .=')';	
							  }
						  }
						  elseif($itemK=='accomodation_fee_ed')
						  {	
							  $type="accomodation_ed";		
							  $itemV['desc'] .=' (';
							  if($invoice['accomodation_fee_ed']['qty'] > 1)
							  {
								  /*$minusDays=$invoice['accomodation_fee_ed']['qty'];*/
								  $minusDays=$invoice['accomodation_fee_ed']['qty']-1;
								  $itemV['desc'] .=dateFormat(date('Y-m-d',strtotime($invoice['booking_to'].' - '.$minusDays.' days'))).' to ';
							  }
							  
							  /*$itemV['desc'] .=dateFormat(date('Y-m-d',strtotime($invoice['booking_to'].' - 1 days')));	*/
							  $itemV['desc'] .=dateFormat(date('Y-m-d',strtotime($invoice['booking_to'])));	
							  $itemV['desc'] .=')';
						  }
						  elseif($itemK=='apu_fee')	
							  $type="apu";
						  elseif($itemK=='guardianship_fee')	
						  {
							  $type="guardianship";
								  $itemV['desc'] .=' ('.dateFormat($itemV['guardianship_startDate']).' to '.dateFormat($itemV['guardianship_endDate']).')';	
						  }
						  elseif($itemK=='nomination_fee')	
							  $type="nomination";
									  
						  
						  $sql_item="insert into `invoice_initial_items` (`invoice_id`,`application_id`,`desc`,`unit`,`qty_unit`,`qty`,`total`,`gst`,`xero_code`,`type`,`date`) values (?,?,?,?,?,?,?,?,?,?,?)";
	    				  $this->db->query($sql_item,array($invoice_id,$item['student_id'],$itemV['desc'],$itemV['unit'],$itemV['qty_unit'],$itemV['qty'],$itemV['total'],$itemV['gst'],$itemV['xero_code'],$type,date('Y-m-d H:i:s')));
					     //echo $this->db->last_query().'<br>';
						}
			
				////////////////////
			}
			}
		}
		
		function updatePendingInvoice($data)
		{
			$invoice_id=$data['invoice_id'];
			$tour_id=$data['shaChangeStatus_id'];
			$from=$data['booking_from'];
			$to=$data['booking_to'];
			$items=studyTourInitialInvoiceItemsUpdate($tour_id,$from,$to);
			
			$sql="update `invoice_initial` set `booking_from`=?, `booking_to`=? where `id`=?";
			$this->db->query($sql, array($from,$to,$invoice_id));
			
			$sqlDel="delete from `invoice_initial_items` where `invoice_id`='".$invoice_id."'";
			$this->db->query($sqlDel);
			
			foreach($items as $item)
			{
				$invoice=$item;
				/////////////
				foreach($item as $itemK=>$itemV)
				{
					  if($itemK!='booking_from' && $itemK!='booking_to' && $itemK!='standard' && $itemK!='student' && $itemK!='student_id')
					  {
						  if(isset($itemV['desc']))
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
									  /*$minusDays=$invoice['accomodation_fee_ed']['qty']+1;*/
									  $minusDays=$invoice['accomodation_fee_ed']['qty'];
									  $itemV['desc'] .=dateFormat(date('Y-m-d',strtotime($invoice['booking_to'].' - '.$minusDays .' days')));	
								  }
								  else
								  {
									  /*$itemV['desc'] .=dateFormat(date('Y-m-d',strtotime($invoice['booking_to'].' - 1 days')));	*/
									  $itemV['desc'] .=dateFormat(date('Y-m-d',strtotime($invoice['booking_to'])));	
								  }
								  $itemV['desc'] .=')';	
							  }
						  }
						  elseif($itemK=='accomodation_fee_ed')
						  {	
							  $type="accomodation_ed";		
							  $itemV['desc'] .=' (';
							  if($invoice['accomodation_fee_ed']['qty'] > 1)
							  {
								  /*$minusDays=$invoice['accomodation_fee_ed']['qty'];*/
								  $minusDays=$invoice['accomodation_fee_ed']['qty']-1;
								  $itemV['desc'] .=dateFormat(date('Y-m-d',strtotime($invoice['booking_to'].' - '.$minusDays.' days'))).' to ';
							  }
							  
							  /*$itemV['desc'] .=dateFormat(date('Y-m-d',strtotime($invoice['booking_to'].' - 1 days')));	*/
							  $itemV['desc'] .=dateFormat(date('Y-m-d',strtotime($invoice['booking_to'])));	
							  $itemV['desc'] .=')';
						  }
						  elseif($itemK=='apu_fee')	
							  $type="apu";
						  elseif($itemK=='guardianship_fee')	
						  {
							  $type="guardianship";
								  $itemV['desc'] .=' ('.dateFormat($itemV['guardianship_startDate']).' to '.dateFormat($itemV['guardianship_endDate']).')';	
						  }
						  elseif($itemK=='nomination_fee')	
							  $type="nomination";
									  
						  
						  $sql_item="insert into `invoice_initial_items` (`invoice_id`,`application_id`,`desc`,`unit`,`qty_unit`,`qty`,`total`,`gst`,`xero_code`,`type`,`date`) values (?,?,?,?,?,?,?,?,?,?,?)";
	    				  $this->db->query($sql_item,array($invoice_id,$item['student_id'],$itemV['desc'],$itemV['unit'],$itemV['qty_unit'],$itemV['qty'],$itemV['total'],$itemV['gst'],$itemV['xero_code'],$type,date('Y-m-d H:i:s')));
						}
			
				////////////////////
			}
			}
			$this->session->set_flashdata('initialInvoiceUpdated','yes');
		}
		
		function tourListHelper()
		{
			$sql="select * from `study_tours` order by `group_name` ";
			$query=$this->db->query($sql);
			return $query->result_array();
		}
		
		function resolveWarning($data)
		{
			$sql="select * from `warnings_study_tours` where `id`='".$data['warning_id']."'";
			$query=$this->db->query($sql);
			if($query->num_rows()>0)
			{
				$warning=$query->row_array();
				$newValue=$data['newValue'];
				if(in_array($warning['column_name'],array('dob','booking_from','booking_to')))
					$newValue=normalToMysqlDate($data['newValue']);
					
				$sqlUpdate="update `sha_one` set `".$warning['column_name']."`='".$newValue."' where `id`='".$warning['sha_one_id']."'";
				$this->db->query($sqlUpdate);
				
				$sqlDel="delete from `warnings_study_tours` where `id`='".$data['warning_id']."'";
				$this->db->query($sqlDel);
			}
		}
		
		function getTourWarnings($type,$ids)
		{
			$sql="select warnings_study_tours.*, sha_one.fname,sha_one.lname from `warnings_study_tours` LEFT JOIN sha_one ON warnings_study_tours.sha_one_id = sha_one.id where ";
			if($type=='current')
				$sql .=" sha_one.id IN(".$ids.")";
			else if($type=='all')
			$sql .=" sha_one.study_tour_id='".$ids."'";       
			$query=$this->db->query($sql);
			$result=$query->result_array();
			//echo $this->db->last_query();
			 if($type=='all')
			 {
			 	$res=$this->studyTourGuardianshipDateWarnings($ids);
				$result=array_merge($res,$result);
			 }
			return $result;
		}	
		
		function studyTourGuardianshipDateWarnings($id)
		{
			$sql="select `sha_one`.`id`,`sha_one`.`id` as `sha_one_id`,`sha_one`.`study_tour_id`,`sha_one`.`fname`,`sha_one`.`lname`,`sha_one`.`dob`,`sha_two`.`guardianship_startDate`,`sha_two`.`guardianship_endDate`, 'guardianship_date' as `column_name`, '' as `column_value` from `sha_one` JOIN `sha_two` ON(`sha_one`.`id`=`sha_two`.`id`) where `sha_one`.`study_tour_id`='".$id."' and  `sha_one`.`status` NOT IN('cancelled','rejected') and  `sha_two`.`guardianship`='1' and (`sha_two`.`guardianship_startDate`='0000-00-00' OR `sha_two`.`guardianship_endDate`='0000-00-00')";
			$query=$this->db->query($sql);
			$result=$query->result_array();
			return $result;
		}
		
		function addOngoingInvoiceSTour($tour)
		{
			if(!empty($tour['applications']))
			{
				$invoice_id=nextInvoiceId();
				$sql="insert into `invoice_ongoing` (`id`,`application_id`,`study_tour`,`booking_from`,`booking_to`,`end_date`,`date`) values(?,?,?,?,?,?,?)";
				$this->db->query($sql,array($invoice_id,$tour['tour_id'],'1',$tour['duration']['from'],$tour['duration']['to'],$tour['duration']['end_date'],date('Y-m-d H:i:s')));
				$invoice_id=$this->db->insert_id();
				
				$this->addOngoingInvoiceSTour2ndPart($tour,$invoice_id);
			}
		}
		
		function addOngoingInvoiceSTour2ndPart($tour,$invoice_id)
		{
			foreach($tour['applications'] as $application)
			{
				if(isset($application['items']) && !empty($application['items']))
				{
					foreach($application['items'] as $item)
					{
						$student=getShaOneAppDetails($application['application_id']);
						$descArray=explode('(',$item['desc']);
						$desc=trim($descArray[0]).', '.str_replace(')','',str_replace('(','',trim($student['fname']))).' '.str_replace(')','',str_replace('(','',trim($student['lname']))).' ('.trim($descArray[1]);
						$sqlItem="insert into `invoice_ongoing_items` (`invoice_id`,`application_id`,`desc`,`unit`,`qty_unit`,`qty`,`total`,`gst`,`xero_code`,`type`,`date`) values(?,?,?,?,?,?,?,?,?,?,?)";
						$this->db->query($sqlItem,array($invoice_id,$application['application_id'],$desc,$item['unit'],$item['qty_unit'],$item['qty'],$item['total'],'0',$item['xero_code'],$item['type'],date('Y-m-d H:i:s')));
					}
				}
			}
		}
		
		function resetOngoingInvoice($tours,$invoice_id)
		{	
			$tour=$tours[0];
			$sql="update `invoice_ongoing` set `booking_from`='".$tour['duration']['from']."', `booking_to`='".$tour['duration']['to']."', `end_date`='".$tour['duration']['end_date']."' where `id`='".$invoice_id."'";
			$this->db->query($sql);
			//echo $sql.'<br>';
			
			$sqlDel="delete from `invoice_ongoing_items` where `invoice_id`='".$invoice_id."'";
			$this->db->query($sqlDel);
			//echo $sqlDel.'<br>';
			$this->addOngoingInvoiceSTour2ndPart($tour,$invoice_id);
		}
		
	function lastInvoice($application_id,$invoice_id)
	{
		$sql="select `id` from `invoice_ongoing` where `study_tour`='1' and `application_id`='".$application_id."' and `id`!='".$invoice_id."' and `id`<='".$invoice_id."'  order by `id` DESC limit 0,1";
		$query=$this->db->query($sql);
		$result=array();
		if($query->num_rows()>0)
			{
				$res=$query->row_array();
				$result=ongoingInvoiceDetails($res['id']);
				$result['initial_invoice']='0';
			}
		else
		{
			$sqlInitial="select `id` from `invoice_initial` where `study_tour`='1' and `application_id`='".$application_id."'";
			$queryInitial=$this->db->query($sqlInitial);
			if($queryInitial->num_rows()>0)
			{
				$res=$queryInitial->row_array();
				$result=initialInvoiceDetails($res['id']);
				$result['initial_invoice']='1';
			}
		}	
		return $result;
	}
	
	function lastInvoiceWithEndingDate($application_id,$date)
	{
		$sql="select `id` from `invoice_ongoing` where `study_tour`='1' and `application_id`='".$application_id."' and `booking_to`='".$date."'";
		$query=$this->db->query($sql);
		$result=array();
		if($query->num_rows()>0)
			{
				$res=$query->row_array();
				$result=ongoingInvoiceDetails($res['id']);
			}
		else
		{
			$sqlInitial="select `id` from `invoice_initial` where `study_tour`='1' and `application_id`='".$application_id."' and `booking_to`='".$date."'";
			$queryInitial=$this->db->query($sqlInitial);
			if($queryInitial->num_rows()>0)
			{
				$res=$queryInitial->row_array();
				$result=initialInvoiceDetails($res['id']);
			}
		}	
		return $result;
	}
function savecollegeaddressdetail($data){
	$this->db->where('id', $data['id']);
    $this->db->update('study_tours',array('college_id'=>$data['cid']));
	
		$this->db->from('sha_one');
    $this->db->where('study_tour_id', $data['id'] );
    $query = $this->db->get();
	$studentdetail= $query->result_array();
	$data1=array('campus'=>$data['sub'],'college_address'=>$data['add'],'college'=>$data['college']);
	if(!empty($studentdetail)){
		foreach($studentdetail as $val){
			$this->db->where('id', $val['id']);
    $this->db->update('sha_one',array('college'=>$data['cid']));
			$query = $this->db->query("SELECT * FROM sha_three where id='".$val['id']."'");
         if($query->num_rows()>0){
			 
			 $this->db->where('id', $val['id']);
    $this->db->update('sha_three',$data1);
		 }else{
			 $this->db->insert("sha_three",$data1);
			 
		 }
		}
		
	}
}
				
}
?>
