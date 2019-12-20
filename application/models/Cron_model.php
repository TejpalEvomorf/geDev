<?php 

class Cron_model extends CI_Model { 

	function hfaToUnavailable()
	{
		$sql="select * from `hfa_unavailable` where `date_from`='".date('Y-m-d')."'";
		$query=$this->db->query($sql);
		$hfa=$query->result_array();
		if(!empty($hfa))
		{
			$hfaUnvail=array();
			foreach($hfa as $hfaV)
			{
				$hfaUnvail	[]=$hfaV['application_id'];
			}
			
			  $sqlUpdate="update `hfa_one` set `status`='unavailable', `date_status_changed`='".date('Y-m-d H:i:s')."' where `id` IN('".implode("','",$hfaUnvail)."')";
			  $this->db->query($sqlUpdate);
		}
	}
	
	
	function hfaUnavailableToApproved()
	{
		$sql="select * from `hfa_unavailable` where `date_to`<='".date('Y-m-d')."'";
		$query=$this->db->query($sql);
		$hfa=$query->result_array();
		if(!empty($hfa))
		{
			$hfaUnvail=array();
			foreach($hfa as $hfaV)
			{
				$hfaUnvail	[]=$hfaV['application_id'];
			}
			
			  $sqlUpdate="update `hfa_one` set `status`='approved', `date_status_changed`='".date('Y-m-d H:i:s')."' where `id` IN('".implode("','",$hfaUnvail)."')";
			  $this->db->query($sqlUpdate);
			  
			  $sqlDel="delete from `hfa_unavailable` where `application_id` IN('".implode("','",$hfaUnvail)."')";
			  $this->db->query($sqlDel);
		}
	}
	
	function bookingArrived()
	{
		$date_today=date('Y-m-d');
		$sql="update `bookings` set `status`='arrived' where `booking_from`='".$date_today."' and `status`!='on_hold'";
		$this->db->query($sql);
	}
	
	
	function bookingMovedOut()
	{
		$date_today=date('Y-m-d');
		//$sql="update `bookings` set `status`='moved_out', `date_status_changed`='".date('Y-m-d H:i:s')."' where (`moveout_date`<'".$date_today."' && `moveout_date`!='0000-00-00') or (`moveout_date`='0000-00-00' and `booking_to`<'".$date_today."' and `booking_to`!='0000-00-00')";
		$sql="update `bookings` set `status`='moved_out', `date_status_changed`='".date('Y-m-d H:i:s')."' where 	((`moveout_date`<'".$date_today."' && `moveout_date`!='0000-00-00') or (`moveout_date`='0000-00-00' and `booking_to`<'".$date_today."' and `booking_to`!='0000-00-00')) and `status`!='moved_out' ";
		$this->db->query($sql);
	}
	
	
	function ongoingBooking($date)
	{
		$sql="select * from `bookings` where (`booking_to`>='".$date."' OR `booking_to`='0000-00-00') and `status` NOT IN('expected_arrival','on_hold','cancelled','moved_out') and `serviceOnlyBooking`='0' and `generate_ongInv`='1'";
		//$sql="select * from `bookings` where `status` NOT IN('expected_arrival','on_hold','cancelled','moved_out')";
		$query=$this->db->query($sql);
		//echo $this->db->last_query();
		return $query->result_array();
	}
	
	function ongoingBookingDirect($date)
	{
		$sql="select * from `bookings` where `ongoing_invoice_on`='".$date."' and `status` NOT IN('on_hold','cancelled','moved_out') and `generate_ongInv`='1'";
		$query=$this->db->query($sql);//echo $this->db->last_query();
		return $query->result_array();
	}
	
	function revisitRequired($date)
	{
		$last_year=date('Y-m-d',strtotime($date." - 1 year"));
		$sql="select * from `hfa_one` where `status`='approved' and `revisit_duration`='12' and date(`date_status_changed`) <='".$last_year."' ";
		$query=$this->db->query($sql);
		//echo $this->db->last_query();
		//echo $query->num_rows();
		
		$hfa=$query->result_array();
		
		$last_6months=date('Y-m-d',strtotime($date." - 6 months"));
		$sql_6months="select * from `hfa_one` where `status`='approved' and `revisit_duration`='6' and date(`date_status_changed`) <='".$last_6months."' ";
		$query_6months=$this->db->query($sql_6months);
		
		$hfa_6months=$query_6months->result_array();
		
		$hfa_all=array_merge($hfa,$hfa_6months);
		
		foreach($hfa_all as $hf)
		{
			$sqlBooking="select * from `bookings` where `status`='arrived' and `host`='".$hf['id']."'";
			$queryBooking=$this->db->query($sqlBooking);
			if($queryBooking->num_rows()==0)
			{
				//$sqlRevisit="update `hfa_one` set `status`='new',`revisit`='1',`visit_date_time`='0000-00-00 00:00:00' where `id`='".$hf['id']."'";
				//$sqlRevisit="update `hfa_one` set `revisit`='1',`visit_date_time`='0000-00-00 00:00:00' where `id`='".$hf['id']."'";
				$sqlRevisit="update `hfa_one` set `revisit`='1' where `id`='".$hf['id']."'";
				$this->db->query($sqlRevisit);
				
				$sqlWwccPl="update `hfa_three` set `wwcc_status`='0',`pl_ins_status`='0' where `id`='".$hf['id']."'";
				$this->db->query($sqlWwccPl);
			}
		}
		
	}
	
	function initialInvoiceEndingWithDate($date)
	{
		$sql="select *, '1' as `initial_invoice` from `invoice_initial` where `booking_to`='".$date."' and `study_tour`='1' and `cancelled`='0'";
		$query=$this->db->query($sql);
		$res=$query->result_array();
		foreach($res as $reK=>$reV)
		{
			$sqlItem="select * from `invoice_initial_items` where `invoice_id`='".$reV['id']."' order by `id`";
			$queryItem=$this->db->query($sqlItem);
			$res[$reK]['items']=$queryItem->result_array();
		}
		
		return $res;
	}
	
	function ongoingInvoiceEndingWithDate($date)
	{
		$sql="select *, '0' as `initial_invoice`  from `invoice_ongoing` where `end_date`='".$date."' and `study_tour`='1'";
		$query=$this->db->query($sql);
		$res=$query->result_array();
		foreach($res as $reK=>$reV)
		{
			$sqlItem="select * from `invoice_ongoing_items` where `invoice_id`='".$reV['id']."' order by `id`";
			$queryItem=$this->db->query($sqlItem);
			$res[$reK]['items']=$queryItem->result_array();
		}
		
		return $res;
	}
	
	function groupInvoiceClients($date,$resetData=array())
	{
		if(empty($resetData))
		{
			$dateFrom=date('Y-m-d',strtotime($date.' last Monday'));
			$dateTo=date('Y-m-d',strtotime($date.' last Sunday'));
		}
		else
		{
			//$dateFrom=date('Y-m-d',strtotime($resetData['date_from'].' -6 days'));
			//$dateTo=date('Y-m-d',strtotime($resetData['date_to'].' -6 days'));
			$dateFrom=$resetData['date_from'];
			$dateTo=$resetData['date_to'];
		}
		
		$sql="select `id`,`group_invoice`,`group_invoice_placement_fee`, `group_invoice_apu`, `group_invoice_accomodation_fee`, '".$dateFrom."' as `date_from`, '".$dateTo."' as `date_to` from `clients` where `group_invoice`='1' ";
		$sql .="and (`group_invoice_placement_fee`='1' OR `group_invoice_apu`='1' OR `group_invoice_accomodation_fee`='1') ";
		if(!empty($resetData))
			$sql .="and `id`='".$resetData['client']."' ";

		$query=$this->db->query($sql);//echo $this->db->last_query();
		$clients=$query->result_array();
		
		foreach($clients as $cK=>$client)
		{
			$sqlBooking="select `bookings`.`id`, `bookings`.`student`, `bookings`.`booking_from`, `bookings`.`booking_to` from `bookings` join `sha_one` ON (`bookings`.`student`=`sha_one`.`id`) where `sha_one`.`client`='".$client['id']."' and `sha_one`.`study_tour_id`='0' and `sha_one`.`status` IN('pending_invoice','approved_with_payment','approved_without_payment')";
			$sqlBooking .=" and `bookings`.`booking_from`>='".$dateFrom."' and `bookings`.`booking_from`<='".$dateTo."'";
			//$sqlBooking .=" and `sha_one`.`id` IN(1326,1327,1334,1348,1353)";
			
			$queryBookings=$this->db->query($sqlBooking);//echo $this->db->last_query();
			$bookingList=$queryBookings->result_array();
			if(!empty($bookingList))
			{
				foreach($bookingList as $bL)
					$clients[$cK]['bookings'][]=$bL;
			}
			
			$sqlBookingOng="select `invoice_group_items`.`id`, `invoice_group_items`.`booking_id`,`invoice_group_items`.`sha_id`, max(`invoice_group_items`.`date_to`) as `paid_till`, `invoice_group`.`client` from `invoice_group_items` join `invoice_group` on (`invoice_group_items`.`invoice_id`=`invoice_group`.`id`) where `invoice_group_items`.`date_to`!='0000-00-00' and `invoice_group`.`client`='".$client['id']."' ";
			if(empty($resetData))
				$sqlBookingOng .="and `invoice_group_items`.`date_to`>='".$date."' and `invoice_group_items`.`date_to`<='".date('Y-m-d',strtotime($date.' + 1 week -1 day'))."' ";
			else
				$sqlBookingOng .="and `invoice_group_items`.`date_to`>='".date('Y-m-d',strtotime($resetData['date_from'].' +6 days'))."' and `invoice_group_items`.`date_to`<='".date('Y-m-d',strtotime($resetData['date_to'].' +6 days'))."' and `invoice_id`!='".$resetData['id']."'";
			$sqlBookingOng .=" group by `booking_id`";
			
			$queryBookingOng=$this->db->query($sqlBookingOng);//if($client['id']=='41'){echo $this->db->last_query();}
			if($queryBookingOng->row_array()>0)
				$clients[$cK]['bookings_ong'][]=$queryBookingOng->result_array();
		}
		return $clients;
		
	}
	
	function insertGroupInvItems($groupInvStructure,$date)
	{
		foreach($groupInvStructure as $inv)
		{
			if(isset($inv['invoice']['items']) && !empty($inv['invoice']['items']))
			{
				$sql="insert into `invoice_group` (`client`,`date_from`,`date_to`,`date`) values (?,?,?,?)";
				$this->db->query($sql,array($inv['id'],$inv['date_from'],$inv['date_to'],$date.' '.date('H:i:s')));
				$invoice_id=$this->db->insert_id();
				
				foreach($inv['invoice']['items'] as $invItem)
				{
					$student=getshaOneAppDetails($invItem['sha_id']);
					$studentNo='';
					if($student['sha_student_no']!='')
						$studentNo=' '.$student['sha_student_no'].' ';
					$itemDesc=$student['fname'].' '.$student['lname'].$studentNo.' - '.$invItem['desc'];
					if($invItem['type']=='apu')
					{
						if($student['arrival_date']!='0000-00-00')
							$itemDesc .=' '.dateFormat($student['arrival_date']);
						else
							$itemDesc .=' '.dateFormat($student['booking_from']);
					}
					
					$itemDate=dateFormat($invItem['from']);
					if($invItem['to']!='')
						$itemDate .=' to '.dateFormat($invItem['to']);
						
					$itemDesc=$student['fname'].' '.$student['lname'].' - '.$invItem['desc'].' ('.$itemDate.')';
					
					
					$sql="insert into `invoice_group_items` (`invoice_id`,`sha_id`,`booking_id`,`date_from`,`date_to`,`desc`,`unit`,`qty`,`qty_unit`,`total`,`gst`,`xero_code`,`type`,`date`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
					$this->db->query($sql,array($invoice_id,$invItem['sha_id'],$invItem['booking_id'],$invItem['from'],$invItem['to'],$itemDesc,$invItem['unit'],$invItem['qty'],$invItem['qty_unit'],$invItem['total'],$invItem['gst'],$invItem['xero_code'],$invItem['type'],$date.' '.date('H:i:s')));	
				}
			}
		}
	}
	
	function ongp()
	{
		$sql="select `invoice_group_items`.`id`, `invoice_group_items`.`booking_id`,`invoice_group_items`.`sha_id`, max(`invoice_group_items`.`date_to`) as `paid_till`, `invoice_group`.`client` from `invoice_group_items` join `invoice_group` on (`invoice_group_items`.`invoice_id`=`invoice_group`.`id`) where `invoice_group_items`.`date_to`!='0000-00-00' group by `booking_id`";
		$query=$this->db->query($sql);
		$res=$query->result_array();see($res);
		return $res;
	}
	
	function autoFeedbackEmailBookingList($date)
	{
		$booking_from=date('Y-m-d',strtotime($date.' - 2 week'));
		//$query=$this->db->query("select * from `bookings` where `booking_from`='".$booking_from."' order by `id`");
		$query=$this->db->query("(select `id`,`student`, '0' as `stop` from `bookings` where `booking_from`='".$booking_from."' order by `id`) UNION (SELECT `booking_id`, `bookings`.`student`, '1' as `stop` FROM `booking_feedbacks_emails` JOIN `bookings` ON(`booking_feedbacks_emails`.`booking_id`=`bookings`.`id`) where date(`sent_on`)='".$booking_from."' and `submit_on`='0000-00-00 00:00:00' and `stop`='0')");
		//echo $this->db->last_query();
		$sent=$query->num_rows();
		
		$this->db->query("insert into `booking_feedbacks_count` (`sent`,`date`) values(?,?)",array($sent,$date));
		
		return $query->result_array();
	}
	
	function CGServiceDocEmail($date)
	{
		$date3dayBack=date('Y-m-d H:i:s',strtotime($date.' - 3 days'));
		$day=date('N',strtotime($date));
		if(in_array($day,array('1','2','3')))
			$date3dayBack=date('Y-m-d H:i:s',strtotime($date.' - 5 days'));
		
		$bookings=$this->db->query("select * from `bookings` where `CGDocSent`!='0000-00-00 00:00:00' and `CGDocSent`<'".$date3dayBack."' and `CGDocRec`='0000-00-00 00:00:00' and `cgDocEmailSent`='0'")->result_array();//echo $this->db->last_query().'<br>';
		$this->db->query("update `bookings` SET `cgDocEmailSent`='1' where `CGDocSent`!='0000-00-00 00:00:00' and `CGDocSent`<'".$date3dayBack."' and `CGDocRec`='0000-00-00 00:00:00' and `cgDocEmailSent`='0'");
		return $bookings;
	}
	
	function feedbackEmailSent($bId,$stop)
	{
		$date=date('Y-m-d H:i:s');
		$this->db->query("insert into `booking_feedbacks_emails` (`booking_id`,`sent_on`,`stop`)values(?,?,?)",array($bId,$date,$stop));
	}
	
	function unsubscribedFeedbackEmailList()
	{
	    return $this->db->query("select `email_id` from `unsubscribe_emails`")->result_array();
	}
	
	function unsubscribeFeedbackEmail($email)
	{
	    $res=$this->db->query("select * from `unsubscribe_emails` where `email_id`=?",array($email))->row_array();
	    if(empty($res))
	    {
	        $date=date('Y-m-d H:i:s');
		    $this->db->query("insert into `unsubscribe_emails` (`email_id`,`date`)values(?,?)",array($email,$date));
	    }
	}
	
	function undoUnsubscribeFeedbackEmail($email)
	{
	    $this->db->query("delete from `unsubscribe_emails` where `email_id`=?",array($email));
	}
	
	function wwccExpiryMemberList($date)
	{
		return $this->db->query("select `id`,`application_id`,`title`,`fname`,`lname`,`dob`,`wwcc_clearence_no`,`wwcc_expiry` from `hfa_members` where `wwcc`='1' and `wwcc_clearence`='1' and `wwcc_expiry`=?",array($date))->result_array();
	}
	
	function plInsExpiryMemberList($date)
	{
		return $this->db->query("select `id`,`ins_provider`,`ins_policy_no`,`ins_expiry` from `hfa_three` where `insurance`='1' and `ins_expiry`=?",array($date))->result_array();
	}


}
