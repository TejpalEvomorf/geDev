<?php 

class Xero_model extends CI_Model {
	
		function moveInitialInvoiceToXero($data)
		{
			$sql="update `invoice_initial` set `moved_to_xero`='1', `moved_to_xero_date`='".date('Y-m-d')."', `invoice_number`='".$data['invoiceNumber']."', `xero_invoiceId`='".$data['xero_invoiceId']."' where `id`='".$data['invoiceId']."'";
			$this->db->query($sql);
			//echo $this->db->last_query();
		}
		
		function getInvoiceIdFromInvoiceNumber($invoiceNumber)
		{
			$sql="select * from `invoice_initial` where `invoice_number`='".$invoiceNumber."' order by `date` DESC";
			$query=$this->db->query($sql);
			if($query->num_rows()>0)
			{
				$res=$query->row_array();
				return $res['id'];
			}
			else
				return false;
		}
		
		function getInitialInvoicePayments($invoiceId)
		{
			$sql="select * from `invoice_initial_payments` where `invoice_id`='".$invoiceId."' order by `date`";
			$query=$this->db->query($sql);
			$res=$query->result_array();
			return $res;
		}
		
		function initialInvoiceInsertNewPayments($invoice_id,$payments)
		{
			$newPayment=false;
			foreach($payments as $pay)
			{
				$sqlCheck="select * from `invoice_initial_payments` where `invoice_id`='".$invoice_id."' and `amount_paid`='".$pay->Amount."' and `payment_id`='".$pay->PaymentID."'";
				$query=$this->db->query($sqlCheck);
				if($query->num_rows()==0)
				{
					$newPayment=true;
					$sql="insert into `invoice_initial_payments` (`invoice_id`,`amount_paid`,`payment_id`,`date`) values ('".$invoice_id."','".$pay->Amount."','".$pay->PaymentID."','".$pay->Date."')";
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
			$sql="update `invoice_initial` set `status`='".$status."' where `id`='".$invoice_id."'";
			$this->db->query($sql);
			
			if($status=='2')
			{
				$sqlSel="select * from `invoice_initial` where `id`='".$invoice_id."'";
				$query=$this->db->query($sqlSel);
				
				if($query->num_rows()>0)
				{
					$invoice=$query->row_array();
					
					if($invoice['study_tour']=='0')
						$table='`sha_one`';
					else	
						$table='`study_tours`';
						
					$sqlSha="select `id` from ".$table." where `status`='pending_invoice' and `id`='".$invoice['application_id']."'";
					$querySha=$this->db->query($sqlSha);
					if($querySha->num_rows()>0)
					{
						$sqlUpdate="update ".$table." set `status`='approved_without_payment' where `id`='".$invoice['application_id']."'";
						$this->db->query($sqlUpdate);
						
						$return='partial_p2u';
						if($invoice['study_tour']=='1')
							$return .='T';
					}
				}
			}
			
			if($status=='3')
			{
				$sqlSel="select * from `invoice_initial` where `id`='".$invoice_id."'";
				$query=$this->db->query($sqlSel);
				
				if($query->num_rows()>0)
				{
					$invoice=$query->row_array();
					
					if($invoice['study_tour']=='0')
						$table='`sha_one`';
					else	
						$table='`study_tours`';
					
					$sqlSha="select * from ".$table." where `id`='".$invoice['application_id']."'";
					$querySha=$this->db->query($sqlSha);
					if($querySha->num_rows()>0)
					{
						$resSha=$querySha->row_array();
						$sqlUpdate="update ".$table." set `status`='approved_with_payment' where `id`='".$invoice['application_id']."'";
						$this->db->query($sqlUpdate);
					
						if($resSha['status']=='pending_invoice')
							$return='paid_p2p';
						elseif($resSha['status']=='approved_without_payment')
							$return='paid_u2p';
						if($invoice['study_tour']=='1')
							$return .='T';
					}
				}
			}
			
			return $return;
		}
		
		function moveOngoingInvoiceToXero($data)
		{
			$sql="update `invoice_ongoing` set `moved_to_xero`='1', `moved_to_xero_date`='".date('Y-m-d')."', `invoice_number`='".$data['invoiceNumber']."', `xero_invoiceId`='".$data['xero_invoiceId']."' where `id`='".$data['invoiceId']."'";
			$this->db->query($sql);
			//echo $this->db->last_query();
		}
		
		function getOngoingInvoiceIdFromInvoiceNumber($invoiceNumber)
		{
			$sql="select * from `invoice_ongoing` where `invoice_number`='".$invoiceNumber."' order by `date` DESC";
			$query=$this->db->query($sql);
			if($query->num_rows()>0)
			{
				$res=$query->row_array();
				return $res['id'];
			}
			else
				return false;
		}
		
		function getOngoingInvoicePayments($invoiceId)
		{
			$sql="select * from `invoice_ongoing_payments` where `invoice_id`='".$invoiceId."' order by `date`";
			$query=$this->db->query($sql);
			$res=$query->result_array();
			return $res;
		}
		
		function ongoingInvoiceInsertNewPayments($invoice_id,$payments)
		{
			$newPayment=false;
			foreach($payments as $pay)
			{
				$sqlCheck="select * from `invoice_ongoing_payments` where `invoice_id`='".$invoice_id."' and `amount_paid`='".$pay->Amount."' and `payment_id`='".$pay->PaymentID."'";
				$query=$this->db->query($sqlCheck);
				if($query->num_rows()==0)
				{
					$newPayment=true;
					$sql="insert into `invoice_ongoing_payments` (`invoice_id`,`amount_paid`,`payment_id`,`date`) values ('".$invoice_id."','".$pay->Amount."','".$pay->PaymentID."','".$pay->Date."')";
					$this->db->query($sql);
				}
			}
			
			if($newPayment)
				return 'newPayment';
			else	
				return 'noNewPayment';
		}
		
		function ongoingInvoiceChangeStatus($invoice_id,$status)
		{
			$sql="update `invoice_ongoing` set `status`='".$status."' where `id`='".$invoice_id."'";
			$this->db->query($sql);
		}
		
		function movePoToXeroUpdateDatabase($moveData)
		{
			//$po=explode(',',$po_idXero);
			$sql="update `purchase_orders` set `moved_to_xero`=?, `moved_to_xero_date`=?, `po_id_xero`=? where `id`=?";
			$this->db->query($sql,array('1',date('Y-m-d H:i:s'),$moveData['xero_poId'],$moveData['poId']));
			//echo $this->db->last_query();
		}
		
		function getPOPayments($invoiceId)
		{
			$sql="select * from `purchase_orders_payments` where `po_id`='".$invoiceId."' order by `date`";
			$query=$this->db->query($sql);
			$res=$query->result_array();
			return $res;
		}
		
		function pOInsertNewPayments($invoice_id,$payments)
		{
			$newPayment=false;
			foreach($payments as $pay)
			{
				$sqlCheck="select * from `purchase_orders_payments` where `po_id`='".$invoice_id."' and `amount_paid`='".$pay->Amount."' and `payment_id`='".$pay->PaymentID."'";
				$query=$this->db->query($sqlCheck);
				if($query->num_rows()==0)
				{
					$newPayment=true;
					$sql="insert into `purchase_orders_payments` (`po_id`,`amount_paid`,`payment_id`,`date`) values ('".$invoice_id."','".$pay->Amount."','".$pay->PaymentID."','".$pay->Date."')";
					$this->db->query($sql);
				}
			}
			
			if($newPayment)
				return 'newPayment';
			else	
				return 'noNewPayment';
		}
		
		
		function pOChangeStatus($invoice_id,$status)
		{
			$return='';
			$sql="update `purchase_orders` set `status`='".$status."' where `id`='".$invoice_id."'";
			$this->db->query($sql);
		}

		
		function moveInitialGroupInvToXero($data)
		{
			$sql="update `invoice_group` set `moved_to_xero`='1', `moved_to_xero_date`='".date('Y-m-d')."', `invoice_number`='".$data['invoiceNumber']."', `xero_invoiceId`='".$data['xero_invoiceId']."' where `id`='".$data['invoiceId']."'";
			$this->db->query($sql);
			//echo $this->db->last_query();
		}
		
		
		
	 }
