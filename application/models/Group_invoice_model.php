<?php 

class Group_invoice_model extends CI_Model { 


	function initialInvoicesList($status,$client)
	{
		$sql="select * from `invoice_group` where `client`='".$client."' and ";
		
		if($status!='0')
			$sql .=" `status`='".$status."' and ";
		
		if(isset($_GET['number']) && $_GET['number']!='')
		{
			$invoiceNumArray=explode('-',trim($_GET['number']));
			$_GET['number']=trim(end($invoiceNumArray));
			$sql .="`invoice_group`.`id` like '".$_GET['number']."%' and ";
		}
			
		if((isset($_GET['from']) && $_GET['from']!=''))
		{
			$sql .="date(`invoice_group`.`date`)>='".normalToMysqlDate($_GET['from'])."' and ";	
		}
		
		if((isset($_GET['to']) && $_GET['to']!=''))
		{
			$sql .="date(`invoice_group`.`date`)<='".normalToMysqlDate($_GET['to'])."' and ";	
		}
		
		$sql .=" 1=1 order by `date` DESC";
		$query=$this->db->query($sql);//echo $this->db->last_query();
		
		$invoices=$query->result_array();
		foreach($invoices as $invK=>$inv)
		{
			$sqlItems="select * from `invoice_group_items` where `invoice_id`=? order by `id`";
			$queryItem=$this->db->query($sqlItems,array($inv['id']));
			$invoices[$invK]['items']=$queryItem->result_array();
			
			$payments=getGroupInvoicePayments($inv['id']);
			if(count($payments)>0)
				$invoices[$invK]['payments']=$payments;
		}
		return $invoices;
	}
	
	function initialInvoiceDetails($id)
	{
		$sql="select * from `invoice_group` where `id`='".$id."'";
		$query=$this->db->query($sql);
		$invoice=$query->row_array();
		
		if(!empty($invoice))
		{
			$sqlLatest="select * from `invoice_group` where `client`='".$invoice['client']."' and `date`>'".$invoice['date']."'";
			$queryLatest=$this->db->query($sqlLatest);
			if($queryLatest->num_rows()>0)
				$invoice['latest_invoice']='0';
			else
				$invoice['latest_invoice']='1';
			
			$sqlCustom="select * from `invoice_group_items` where `invoice_id`='".$id."' order by `sha_id`, `id`";
			$queryCustom=$this->db->query($sqlCustom);
			$invoice['items']=$queryCustom->result_array();
			
			$payments=getGroupInvoicePayments($id);
			if(count($payments)>0)
				$invoice['payments']=$payments;
		}
		
		return $invoice;
	}
	
	function initialInvoicesListForSync()
	{
		//$sql="select * from `invoice_group` where `status`!='3' order by `date` DESC";
		$sql="select * from `invoice_group` where `status`!='3' and `moved_to_xero`='1' order by `date` DESC limit 50";
		$query=$this->db->query($sql);
		$invoices=$query->result_array();
		return $invoices;
	}
		
	function getInitialInvoicePayments($invoiceId)
	{
		$sql="select * from `invoice_group_payments` where `invoice_id`='".$invoiceId."' order by `date`";
		$query=$this->db->query($sql);
		$res=$query->result_array();
		return $res;
	}
		
	function initialInvoiceInsertNewPayments($invoice_id,$payments)
	{
		$newPayment=false;
		foreach($payments as $pay)
		{
			$sqlCheck="select * from `invoice_group_payments` where `invoice_id`='".$invoice_id."' and `amount_paid`='".$pay->Amount."' and `payment_id`='".$pay->PaymentID."'";
			$query=$this->db->query($sqlCheck);
			if($query->num_rows()==0)
			{
				$newPayment=true;
				$sql="insert into `invoice_group_payments` (`invoice_id`,`amount_paid`,`payment_id`,`date`) values ('".$invoice_id."','".$pay->Amount."','".$pay->PaymentID."','".$pay->Date."')";
				$this->db->query($sql);
			}
		}
		
		if($newPayment)
			return 'newPayment';
		else	
			return 'noNewPayment';
	}
		
	function initialInvoiceChangeStatus($invoice_id,$status)
	{
		$return='';
		$sql="update `invoice_group` set `status`='".$status."' where `id`='".$invoice_id."'";
		$this->db->query($sql);
		
		if($status=='2')
			$statusSha='approved_without_payment';
			
		if($status=='3')
			$statusSha='approved_with_payment';
		
		$sqlSha="select distinct(`sha_id`) from `invoice_group_items` where `invoice_id`='".$invoice_id."'";
		$querySha=$this->db->query($sqlSha);
		$return=$querySha->num_rows();
		
		$sqlUpdate="update `sha_one` set `status`='".$statusSha."' where `id` IN (".$sqlSha.")";
		$this->db->query($sqlUpdate);
		
		return $return;
	}
	
	function editInvoiceItem($data)
	{
			$item=$data['itemId'];
			$total=add_decimal($data['unit_price']);
			$sqlDel="update `invoice_group_items` set `desc`='".$data['description']."', `unit`='".$total."', `total`='".$total."' where `id`='".$item."' and `invoice_id`='".$data['invoice_id']."'";
			$this->db->query($sqlDel);
	}
	
	function findBookingForInvoiceUpload($data)
	{//if(!isset($data['I'])){echo $data['F'].'<br>';}
		preg_match_all('/\b([A-Z]+)\b/', $data['G'], $hostLname);
		preg_match_all('/\b([A-Z]+)\b/', $data['I'], $studentLname);
		
		$booking=array();
		
		$sqlStudentNo="select `bookings`.* from `bookings` join `sha_one` on(`bookings`.`student`=`sha_one`.`id`) join `hfa_one` on (`bookings`.`host`=`hfa_one`.`id`) where `sha_one`.`sha_student_no` = '".$data['H']."' and  `hfa_one`.`lname` like '".implode(' ',$hostLname[0])."'";
		$queryStudentNo=$this->db->query($sqlStudentNo);
		if($queryStudentNo->num_rows()>0)
			$booking=$queryStudentNo->row_array();
		else
		{
			$sql="select `bookings`.* from `bookings` join `sha_one` on(`bookings`.`student`=`sha_one`.`id`) join `hfa_one` on (`bookings`.`host`=`hfa_one`.`id`) where `sha_one`.`lname` like '".implode(' ',$studentLname[0])."' and  `hfa_one`.`lname` like '".implode(' ',$hostLname[0])."' and `sha_one`.`client`='1179'";
			$query=$this->db->query($sql);
			
			if($query->num_rows()>0)
			{
				$booking=$query->row_array();
				if($query->num_rows()>1)
					$booking=2;
			}
		}
		return $booking;	
	}
	
	function invoiceUploadInsert($invoice,$postData)
	{
		if(!isset($postData['invoiceId']))
		{
			$sql="insert into `invoice_group` (`client`,`date_from`,`date_to`,`status`,`imported`,`date`) values(?,?,?,?,?,?)";
			$this->db->query($sql,array($postData['clientId'],$invoice['date_from'],$invoice['date_to'],'3','1',date('Y-m-d H:i:s')));
			$invoiceId=$this->db->insert_id();
		}
		else
		{
			$invoiceId=$postData['invoiceId'];
			$sqlDel="delete from `invoice_group_items` where `invoice_id`='".$invoiceId."'";
			$this->db->query($sqlDel);
		}
		
		foreach($invoice['items'] as $item)
		{
			$sqlItem="insert into `invoice_group_items` (`invoice_id`,`sha_id`,`booking_id`,`date_from`,`date_to`,`desc`,`unit`,`qty`,`qty_unit`,`total`,`gst`,`type`,`date`) values(?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$this->db->query($sqlItem,array($invoiceId, $item['sha_id'], $item['booking_id'], $item['date_from'], $item['date_to'], $item['desc'], $item['unit'], $item['qty'], $item['qty_unit'], $item['total'], $item['gst'], $item['type'],date('Y-m-d H:i:s')));
		}
	}
	
	
	function updateGroupInvItems($groupInvStructure)
	{
		foreach($groupInvStructure as $inv)
		{
			if(isset($inv['invoice']['items']) && !empty($inv['invoice']['items']))
			{
				$invoice_id=$inv['invoice_id'];
				
				$sqlDel="delete from `invoice_group_items` where `invoice_id`='".$invoice_id."'";
				$this->db->query($sqlDel);
				
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
					$this->db->query($sql,array($invoice_id,$invItem['sha_id'],$invItem['booking_id'],$invItem['from'],$invItem['to'],$itemDesc,$invItem['unit'],$invItem['qty'],$invItem['qty_unit'],$invItem['total'],$invItem['gst'],$invItem['xero_code'],$invItem['type'],date('Y-m-d H:i:s')));	
				}
			}
		}
	}

	function deleteInvoiceItem($data)
	{
		$itemId=explode('_',$data['itemId']);
		$item=$itemId[1];
		
		$sqlDel="delete from `invoice_group_items` where `id`='".$item."' and `invoice_id`='".$data['id']."'";
		$this->db->query($sqlDel);
	}
}