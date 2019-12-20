<?php 

class Invoice_model extends CI_Model { 

	function initialInvoiceBefore($id)
	{
		$student=getShaOneAppDetails($id);
		$studentTwo=getShaTwoAppDetails($id);
		
		$invoice=array();
		if(!empty($student) && !empty($studentTwo))
		{
				$year=date('Y');
				$client_id=$student['client'];
				if($client_id==0)
					$products=productsList($year);
				else
				{
					/*
					$checkIfClientHasAgreement=checkIfClientHasAgreement($client_id,$year);
					$clientDetail=clientDetail($client_id);
					if($checkIfClientHasAgreement && $clientDetail['category']==2 && $clientDetail['commission']=='1')
					{
						$productsStandard=productsList($year);
						$invoice['standard']=$this->initialInvoiceBeforeItems($productsStandard,$student,$studentTwo);
					}
						
					$products=clientProductsList($client_id,$year);*/
					
					$products=clientProductsList($client_id,$year);
					$clientDetail=clientDetail($client_id);
					if($clientDetail['category']==2 && $clientDetail['commission']=='1')
					{
						$checkIfClientHasAgreement=checkIfClientHasAgreement($client_id,$year);
						if($checkIfClientHasAgreement)
							$productsStandard=productsList($year);
						else	
							$productsStandard=$products;
						$invoice['standard']=$this->initialInvoiceBeforeItems($productsStandard,$student,$studentTwo);
					}
				}
				
				$invoiceItemsReal=$this->initialInvoiceBeforeItems($products,$student,$studentTwo);
				foreach($invoiceItemsReal as $iRK=>$iIRV)
					$invoice[$iRK]=$iIRV;
			
			$invoice['booking_from']=$student['booking_from'];
			$invoice['booking_to']=$student['booking_to'];
			
			if($student['study_tour_id']==0 && $invoice['booking_from']!='0000-00-00' && $invoice['booking_to']!='0000-00-00')
			{
				/*$dayDiff=dayDiff($invoice['booking_from'],$invoice['booking_to'])-1;
				if($dayDiff>28)	
					$invoice['booking_to']=date('Y-m-d',strtotime($invoice['booking_from'].' + 4 weeks'));*/
					$dayDiff=dayDiff($invoice['booking_from'],$invoice['booking_to']);
				if($dayDiff>28)	
					$invoice['booking_to']=date('Y-m-d',strtotime($invoice['booking_from'].' + 4 weeks -1 day'));
			}
			elseif($student['study_tour_id']!=0 && $invoice['booking_from']!='0000-00-00' && $invoice['booking_to']!='0000-00-00')
			{
				/*$dayDiff=dayDiff($invoice['booking_from'],$invoice['booking_to'])-1;
				if($dayDiff>28)	
					$invoice['booking_to']=date('Y-m-d',strtotime($invoice['booking_from'].' + 4 weeks'));*/
				$dayDiff=dayDiff($invoice['booking_from'],$invoice['booking_to']);
				if($dayDiff>28)	
					$invoice['booking_to']=date('Y-m-d',strtotime($invoice['booking_from'].' + 4 weeks -1 day'));	
			}
			else
				$invoice['booking_from']=$invoice['booking_to']='0000-00-00';
			//echo $student['study_tour_id'].', '.$invoice['booking_from'].', '.$invoice['booking_to'].'<br>';
		}
		return $invoice;
	}
	
	function initialInvoiceBeforeUpdate($id,$from,$to)
	{
		$student=getShaOneAppDetails($id);
		$studentTwo=getShaTwoAppDetails($id);
		
		if($student['booking_from']!='0000-00-00' && $student['booking_to']!='0000-00-00')
			{
				if(strtotime($student['booking_to'])<strtotime($to))
					$to=$student['booking_to'];	
			}
		
		$invoice=array();
		if(!empty($student) && !empty($studentTwo))
		{
				$year=date('Y');
				$client_id=$student['client'];
				if($client_id==0)
					$products=productsList($year);
				else
				{
					/*$checkIfClientHasAgreement=checkIfClientHasAgreement($client_id,$year);
					if($checkIfClientHasAgreement)
					{
						$productsStandard=productsList($year);
						$invoice['standard']=$this->initialInvoiceBeforeItemsUpdate($productsStandard,$student,$studentTwo,$from,$to);
					}
						
					$products=clientProductsList($client_id,$year);*/
					
					$products=clientProductsList($client_id,$year);
					$clientDetail=clientDetail($client_id);
					if($clientDetail['category']==2 && $clientDetail['commission']=='1')
					{
						$checkIfClientHasAgreement=checkIfClientHasAgreement($client_id,$year);
						if($checkIfClientHasAgreement)
							$productsStandard=productsList($year);
						else	
							$productsStandard=$products;
						$invoice['standard']=$this->initialInvoiceBeforeItemsUpdate($productsStandard,$student,$studentTwo,$from,$to);
					}
				}
				
				$invoiceItemsReal=$this->initialInvoiceBeforeItemsUpdate($products,$student,$studentTwo,$from,$to);
				foreach($invoiceItemsReal as $iRK=>$iIRV)
					$invoice[$iRK]=$iIRV;
			
				$invoice['booking_from']=$from;
				$invoice['booking_to']=$to;
		}
		return $invoice;
	}	
	
	function initialInvoiceBeforeItems($products,$student,$studentTwo)
	{
		/*if($student['booking_from']!='0000-00-00' && $student['booking_to']!='0000-00-00')
			$dayDiff=dayDiff($student['booking_from'],$student['booking_to'])-1;
		else
			$dayDiff=28;*/
		
		if($student['booking_from']!='0000-00-00' && $student['booking_to']!='0000-00-00')
			$dayDiff=dayDiff($student['booking_from'],$student['booking_to']);
		else
			$dayDiff=28;	
		
		//If duration more than 4 weeks then generate only for 4 weeks	
		if($dayDiff>28)	
			$dayDiff=28;
		
		$invoice=$this->initialInvoiceBeforeItems2ndPart($products,$student,$studentTwo,$dayDiff);
		return $invoice;
	}
	
	function initialInvoiceBeforeItemsUpdate($products,$student,$studentTwo,$from,$to)
	{
		/*$dayDiff=dayDiff($from,$to)-1;*/
		$dayDiff=dayDiff($from,$to);
		$invoice=$this->initialInvoiceBeforeItems2ndPart($products,$student,$studentTwo,$dayDiff);
			return $invoice;
	}
	
	function initialInvoiceBeforeItems2ndPart($products,$student,$studentTwo,$dayDiff)
	{
		$age=age_from_dob($student['dob']);
		$weeks=($dayDiff/7);
		$weeks_only=(int)($dayDiff/7);
		$days=($dayDiff%7);
		
		foreach($products as $p)
				{
					//Placement fee
					$placement_fee['qty_unit']='0';
					$placement_fee['qty']=1;
					$placement_fee['gst']='1';
					
					if($student['accomodation_type']==1 || $student['accomodation_type']==2 || $student['accomodation_type']==3)
					{
						if($p['name']=='Placement fee')
						{
							$placement_fee['desc']='Placement fee';
							$placement_fee['total']=$placement_fee['unit']=$p['price'];
							$placement_fee['xero_code']=$p['xero_code'];	
						}
					}
					else
					{
						if($p['name']=='VIP Placement Fee' && !in_array($student['accomodation_type'],array(6,7)))
						{
							$placement_fee['desc']='VIP Placement fee';
							$placement_fee['total']=$placement_fee['unit']=add_decimal($p['price']);
							$placement_fee['xero_code']=$p['xero_code'];
						}
					}
					if(!in_array($student['accomodation_type'],array(6,7)))
						$invoice['placement_fee']=$placement_fee;
					
					//Accomodation fee
					$accomodation_fee=array();
					if($student['accomodation_type']==1)
						{
							if($p['name']=='Single Room 18-' && $age<18)
							{
								$invoice['accomodation_fee']=$this->accomodation_feeArray($p,$weeks_only);
								
								if($days!=0)
									$invoice['accomodation_fee_ed']=$this->accomodation_fee_edArray($p,$days);
							}
							if($p['name']=='Single Room 18+' && $age>=18)
							{
								$invoice['accomodation_fee']=$this->accomodation_feeArray($p,$weeks_only);
								
								if($days!=0)
									$invoice['accomodation_fee_ed']=$this->accomodation_fee_edArray($p,$days);
							}
						}
						else if($student['accomodation_type']==2)
						{
							/*if($p['name']=='Twin Share')
							{
								$invoice['accomodation_fee']=$this->accomodation_feeArray($p,$weeks_only);
								
								if($days!=0)
									$invoice['accomodation_fee_ed']=$this->accomodation_fee_edArray($p,$days);
							}*/
							
							if($p['name']=='Twin Share 18-' && $age<18)
							{
								$invoice['accomodation_fee']=$this->accomodation_feeArray($p,$weeks_only);
								
								if($days!=0)
									$invoice['accomodation_fee_ed']=$this->accomodation_fee_edArray($p,$days);
							}
							if($p['name']=='Twin Share 18+' && $age>=18)
							{
								$invoice['accomodation_fee']=$this->accomodation_feeArray($p,$weeks_only);
								
								if($days!=0)
									$invoice['accomodation_fee_ed']=$this->accomodation_fee_edArray($p,$days);
							}
						}
						else if($student['accomodation_type']==3)
						{
							if($p['name']=='Self-Catered')
							{
								$invoice['accomodation_fee']=$this->accomodation_feeArray($p,$weeks_only);
								
								if($days!=0)
									$invoice['accomodation_fee_ed']=$this->accomodation_fee_edArray($p,$days);
							}
						}
						else if($student['accomodation_type']==4)
						{
							if($p['name']=='VIP Single Room')
							{
								$invoice['accomodation_fee']=$this->accomodation_feeArray($p,$weeks_only);
								
								if($days!=0)
									$invoice['accomodation_fee_ed']=$this->accomodation_fee_edArray($p,$days);
							}
						}
						else if($student['accomodation_type']==5)
						{
							if($p['name']=='VIP Self-Catered')
							{
								$invoice['accomodation_fee']=$this->accomodation_feeArray($p,$weeks_only);
								
								if($days!=0)
									$invoice['accomodation_fee_ed']=$this->accomodation_fee_edArray($p,$days);
							}
						}
						
					
					//Airport pickup
					if($p['name']=='Airport Pickup Service' && $studentTwo['airport_pickup']==1)
					{
							$apu_fee['desc']=$p['name'];
							$apu_fee['unit']=$p['price'];
							$apu_fee['qty_unit']='0';
							$apu_fee['qty']=1;		
							$apu_fee['total']=add_decimal($p['price']);
							$apu_fee['gst']=$p['gst'];
							$apu_fee['xero_code']=$p['xero_code'];
						$invoice['apu_fee']=$apu_fee;
					}
							
					//Guardianship fee
					if($age<18 && $studentTwo['guardianship']==1)
					{
						if($studentTwo['guardianship_startDate']!='0000-00-00' && $studentTwo['guardianship_endDate']!='0000-00-00')
						{
							$weeks=guardianshipDurationWeeks($studentTwo['guardianship_startDate'],$studentTwo['guardianship_endDate']);
							if($p['name']=='Guardianship')
							{
								$guardianship_fee['desc']=$p['name'];
								$guardianship_fee['unit']=$p['price'];
								$guardianship_fee['qty_unit']='1';
								$guardianship_fee['qty']=$weeks;
								$guardianship_fee['total']=add_decimal($p['price']*$weeks);
								$guardianship_fee['gst']=$p['gst'];
								$guardianship_fee['xero_code']=$p['xero_code'];
								$guardianship_fee['guardianship_startDate']=$studentTwo['guardianship_startDate'];
								$guardianship_fee['guardianship_endDate']=$studentTwo['guardianship_endDate'];
								$invoice['guardianship_fee']=$guardianship_fee;
							}
						}
					}
					
					//Nomination fee
					if($student['homestay_nomination']=='1')
					{
						if($p['name']=='Nomination Fee')
						{
							$nomination_fee['desc']='Homestay '.$p['name'];
							$nomination_fee['unit']=$p['price'];
							$nomination_fee['qty_unit']='0';
							$nomination_fee['qty']=1;
							$nomination_fee['total']=add_decimal($p['price']);
							$nomination_fee['gst']=$p['gst'];
							$nomination_fee['xero_code']=$p['xero_code'];
							$invoice['nomination_fee']=$nomination_fee;
						}
					}
				}
			return $invoice;
	}	
	
	function accomodation_feeArray($p,$weeks)
	{
		$accomodation_fee=array();
		$accomodation_fee['desc']=$p['name'];
		$accomodation_fee['qty_unit']='1';
		$accomodation_fee['qty']=$weeks;
		$accomodation_fee['unit']=$p['price'];
		$accomodation_fee['total']=add_decimal($p['price']*$weeks);
		$accomodation_fee['gst']=$p['gst'];
		$accomodation_fee['xero_code']=$p['xero_code'];
		return $accomodation_fee;
	}
	
	function accomodation_fee_edArray($p,$days)
	{
		$accomodation_fee=array();
		$accomodation_fee['desc']=$p['name'];
		$accomodation_fee['qty_unit']='2';
		$accomodation_fee['qty']=$days;
		$accomodation_fee['unit']=add_decimal($p['price']/7);
		$accomodation_fee['total']=add_decimal(($p['price']/7)*$days);
		$accomodation_fee['gst']=$p['gst'];
		$accomodation_fee['xero_code']=$p['xero_code'];
		return $accomodation_fee;
	}

	function resetInitialInvoice($invoice_id,$shaId)
	{
		$invoice=$this->initialInvoiceBefore($shaId);
		if(!empty($invoice))
		{
			$sql="update `invoice_initial` set `booking_from`=?, `booking_to`=? where `id`=?";
			$this->db->query($sql, array($invoice['booking_from'],$invoice['booking_to'],$invoice_id));
			
			$sqlDel="delete from `invoice_initial_items` where `invoice_id`='".$invoice_id."'";
			$this->db->query($sqlDel);
			$sqlDel="delete from `invoice_initial_items_standard` where `invoice_id`='".$invoice_id."'";
			$this->db->query($sqlDel);
			
			$invoice=adjustPlacementFee_shaInitialInvoice($invoice,$shaId);
			$this->addPendingInvoice2ndPart($invoice,$invoice_id);
		}
	}

	function addPendingInvoice($data)
	{
		$invoice=$this->initialInvoiceBefore($data['shaChangeStatus_id']);
		if(!empty($invoice))
		{
			$invoice_id=nextInvoiceId();
			$sql="insert into `invoice_initial` (`id`,`application_id`, `booking_from`, `booking_to`, `date`) values (?,?,?,?,?)";
			$this->db->query($sql, array($invoice_id,$data['shaChangeStatus_id'],$invoice['booking_from'],$invoice['booking_to'],date('Y-m-d H:i:s')));
			//$invoice_id=$this->db->insert_id();
			
			$invoice=adjustPlacementFee_shaInitialInvoice($invoice,$data['shaChangeStatus_id']);
			$this->addPendingInvoice2ndPart($invoice,$invoice_id);
			return $invoice_id;
		}
	}
	
	function addPendingInvoice2ndPart($invoice,$invoice_id)
	{
			$studentname=getStudentNameFromInvoiceId($invoice_id,'initial');
			
			foreach($invoice as $itemK=>$itemV)
			{
				if($itemK!='booking_from' && $itemK!='booking_to' && $itemK!='standard' && $itemK!='student' && $itemK!='student_id')
				{
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
							else{
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
						
						/*$itemV['desc'] .=dateFormat(date('Y-m-d',strtotime($invoice['booking_to'].' - 1 days')));*/
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
								
				  	$sql_item="insert into `invoice_initial_items` (`invoice_id`,`desc`,`unit`,`qty_unit`,`qty`,`total`,`gst`,`xero_code`,`type`,`date`) values (?,?,?,?,?,?,?,?,?,?)";
				  	$this->db->query($sql_item,array($invoice_id,$studentname.$itemV['desc'],$itemV['unit'],$itemV['qty_unit'],$itemV['qty'],$itemV['total'],$itemV['gst'],$itemV['xero_code'],$type,date('Y-m-d H:i:s')));
				}
			}
			
			if(isset($invoice['standard']))
			{
				foreach($invoice['standard'] as $itemSK=>$itemSV)
				{
					$typeS="";
					if($itemSK=='placement_fee')
					{
						$typeS="placement";
						if($invoice['booking_from']!='0000-00-00')
							$itemSV['desc'] .=' ('.dateFormat($invoice['booking_from']).')';
					}
					elseif($itemSK=='accomodation_fee')
					{	
						$typeS="accomodation";
						if($invoice['booking_from']!='0000-00-00' || $invoice['booking_to']!='0000-00-00')
						{
							$itemSV['desc'] .=' ('.dateFormat($invoice['booking_from']).' to ';
							if(isset($invoice['standard']['accomodation_fee_ed']))
							{
								/*$minusDays=$invoice['standard']['accomodation_fee_ed']['qty']+1;*/
								$minusDays=$invoice['standard']['accomodation_fee_ed']['qty'];
								$itemSV['desc'] .=dateFormat(date('Y-m-d',strtotime($invoice['booking_to'].' - '.$minusDays.' days')));	
							}
							else	
							{				
								/*$itemSV['desc'] .=dateFormat(date('Y-m-d',strtotime($invoice['booking_to'].' - 1 days')));*/
								$itemSV['desc'] .=dateFormat(date('Y-m-d',strtotime($invoice['booking_to'])));
							}
							$itemSV['desc'] .=')';	
						}
					}
					elseif($itemSK=='accomodation_fee_ed')	
					{
						$typeS="accomodation_ed";	
						$itemSV['desc'] .=' (';
						if($invoice['standard']['accomodation_fee_ed']['qty'] > 1)
						{
							/*$minusDays=$invoice['standard']['accomodation_fee_ed']['qty'];*/
							$minusDays=$invoice['standard']['accomodation_fee_ed']['qty']-1;
							$itemSV['desc'] .=dateFormat(date('Y-m-d',strtotime($invoice['booking_to'].' - '.$minusDays.' days'))).' to ';
						}
						
						/*$itemSV['desc'] .=' '.dateFormat(date('Y-m-d',strtotime($invoice['booking_to'].' - 1 days'))).')';*/
						$itemSV['desc'] .=' '.dateFormat(date('Y-m-d',strtotime($invoice['booking_to']))).')';	
					}
					elseif($itemSK=='apu_fee')	
						$typeS="apu";
					elseif($itemSK=='guardianship_fee')	
					{
						$typeS="guardianship";
							$itemSV['desc'] .=' ('.dateFormat($itemSV['guardianship_startDate']).' to '.dateFormat($itemSV['guardianship_endDate']).')';	
					}
					elseif($itemSK=='nomination_fee')	
						$typeS="nomination";
						
					 $sql_item="insert into `invoice_initial_items_standard` (`invoice_id`,`desc`,`unit`,`qty_unit`,`qty`,`total`,`gst`,`type`,`date`) values (?,?,?,?,?,?,?,?,?)";
					 $this->db->query($sql_item,array($invoice_id,$studentname.$itemSV['desc'],$itemSV['unit'],$itemSV['qty_unit'],$itemSV['qty'],$itemSV['total'],$itemSV['gst'],$typeS,date('Y-m-d H:i:s')));
				}
			}
	}	
	
	function updatePendingInvoice($data)
	{
		$invoice=$this->initialInvoiceBeforeUpdate($data['shaChangeStatus_id'],$data['booking_from'],$data['booking_to']);
		//see($invoice);die();
		$studentname=getStudentNameFromInvoiceId($data['invoice_id'],'initial');
		if(!empty($invoice))
		{
			$invoice=adjustPlacementFee_shaInitialInvoice($invoice,$data['shaChangeStatus_id']);
			
			if($data['dates_available']=='0')
				$invoice['booking_from']=$invoice['booking_to']='0000-00-00';
				
			$sql="update `invoice_initial` set `booking_from`=?, `booking_to`=? where `id`=?";
			$this->db->query($sql, array($invoice['booking_from'],$invoice['booking_to'],$data['invoice_id']));
			$invoice_id=$data['invoice_id'];
			
			$sqlDel="delete from `invoice_initial_items` where `invoice_id`='".$data['invoice_id']."'";
			$this->db->query($sqlDel);
			$sqlDel="delete from `invoice_initial_items_standard` where `invoice_id`='".$data['invoice_id']."'";
			$this->db->query($sqlDel);
			
			foreach($invoice as $itemK=>$itemV)
			{
				if($itemK!='booking_from' && $itemK!='booking_to' && $itemK!='standard' && $itemK!='student' && $itemK!='student_id')
				{
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
						if($invoice['booking_from']!='0000-00-00' || $invoice['booking_to']!='0000-00-00')
						{		
							$itemV['desc'] .=' (';
							if($invoice['accomodation_fee_ed']['qty'] > 1)
							{
								/*$minusDays=$invoice['accomodation_fee_ed']['qty'];*/
								$minusDays=$invoice['accomodation_fee_ed']['qty']-1;
								$itemV['desc'] .=dateFormat(date('Y-m-d',strtotime($invoice['booking_to'].' - '.$minusDays.' days'))).' to ';
							}
							
							/*$itemV['desc'] .=dateFormat(date('Y-m-d',strtotime($invoice['booking_to'].' - 1 days')));*/
							$itemV['desc'] .=dateFormat(date('Y-m-d',strtotime($invoice['booking_to'])));	
							$itemV['desc'] .=')';
						}
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
								
				  	$sql_item="insert into `invoice_initial_items` (`invoice_id`,`desc`,`unit`,`qty_unit`,`qty`,`total`,`gst`,`xero_code`,`type`,`date`) values (?,?,?,?,?,?,?,?,?,?)";
				  	$this->db->query($sql_item,array($invoice_id,$studentname.$itemV['desc'],$itemV['unit'],$itemV['qty_unit'],$itemV['qty'],$itemV['total'],$itemV['gst'],$itemV['xero_code'],$type,date('Y-m-d H:i:s')));
				}
			}
			
			if(isset($invoice['standard']))
			{
				foreach($invoice['standard'] as $itemSK=>$itemSV)
				{
					$typeS="";
					if($itemSK=='placement_fee')
					{
						$typeS="placement";
						if($invoice['booking_from']!='0000-00-00')
							$itemSV['desc'] .=' ('.dateFormat($invoice['booking_from']).')';
					}
					elseif($itemSK=='accomodation_fee')
					{	
						$typeS="accomodation";
						if($invoice['booking_from']!='0000-00-00' || $invoice['booking_to']!='0000-00-00')
						{
							$itemSV['desc'] .=' ('.dateFormat($invoice['booking_from']).' to ';
							if(isset($invoice['standard']['accomodation_fee_ed']))
							{
								/*$minusDays=$invoice['standard']['accomodation_fee_ed']['qty']+1;*/
								$minusDays=$invoice['standard']['accomodation_fee_ed']['qty'];
								$itemSV['desc'] .=dateFormat(date('Y-m-d',strtotime($invoice['booking_to'].' - '.$minusDays.' days')));	
							}
							else		
							{			
								/*$itemSV['desc'] .=dateFormat(date('Y-m-d',strtotime($invoice['booking_to'].' - 1 days')));*/
								$itemSV['desc'] .=dateFormat(date('Y-m-d',strtotime($invoice['booking_to'])));
							}
							$itemSV['desc'] .=')';	
						}
					}
					elseif($itemSK=='accomodation_fee_ed')	
					{
						$typeS="accomodation_ed";	
						if($invoice['booking_from']!='0000-00-00' || $invoice['booking_to']!='0000-00-00')
						{
							$itemSV['desc'] .=' (';
							if($invoice['standard']['accomodation_fee_ed']['qty'] > 1)
							{
								/*$minusDays=$invoice['standard']['accomodation_fee_ed']['qty'];*/
								$minusDays=$invoice['standard']['accomodation_fee_ed']['qty']-1;
								$itemSV['desc'] .=dateFormat(date('Y-m-d',strtotime($invoice['booking_to'].' - '.$minusDays.' days'))).' to ';
							}
							
							/*$itemSV['desc'] .=' '.dateFormat(date('Y-m-d',strtotime($invoice['booking_to'].' - 1 days'))).')';*/
							$itemSV['desc'] .=' '.dateFormat(date('Y-m-d',strtotime($invoice['booking_to']))).')';	
						}
					}
					elseif($itemSK=='apu_fee')	
						$typeS="apu";
					elseif($itemSK=='guardianship_fee')	
					{
						$typeS="guardianship";
							$itemSV['desc'] .=' ('.dateFormat($itemSV['guardianship_startDate']).' to '.dateFormat($itemSV['guardianship_endDate']).')';	
					}
					elseif($itemSK=='nomination_fee')	
						$typeS="nomination";
						
					 $sql_item="insert into `invoice_initial_items_standard` (`invoice_id`,`desc`,`unit`,`qty_unit`,`qty`,`total`,`gst`,`type`,`date`) values (?,?,?,?,?,?,?,?,?)";
					 $this->db->query($sql_item,array($invoice_id,$studentname.$itemSV['desc'],$itemSV['unit'],$itemSV['qty_unit'],$itemSV['qty'],$itemSV['total'],$itemSV['gst'],$typeS,date('Y-m-d H:i:s')));
				}
			}
			
		}
		$this->session->set_flashdata('initialInvoiceUpdated','yes');
	}
	
		
	/*function initialInvoicesList1($status=0)
	{
		$sql="select `invoice_initial`.* from `invoice_initial` ";
		
		if((isset($_GET['client']) && $_GET['client']!='') || (isset($_GET['student']) && $_GET['student']!=''))
			$sql .=" join `sha_one` on (`invoice_initial`.`application_id`=`sha_one`.`id`)";	
		
		$sql .="where ";
		if($status!=0)
			$sql .="`invoice_initial`.`status`='".$status."' and ";
			
		if(isset($_GET['number']) && $_GET['number']!='')
		{
			$invoiceNumArray=explode('-',trim($_GET['number']));
			$_GET['number']=trim(end($invoiceNumArray));
			$sql .="`invoice_initial`.`id` like '".$_GET['number']."%' and ";
		}
			
		if((isset($_GET['from']) && $_GET['from']!=''))
		{
			$sql .="date(`invoice_initial`.`date`)>='".normalToMysqlDate($_GET['from'])."' and ";	
		}
		
		if((isset($_GET['to']) && $_GET['to']!=''))
		{
			$sql .="date(`invoice_initial`.`date`)<='".normalToMysqlDate($_GET['to'])."' and ";	
		}
		
		if(isset($_GET['client']) && $_GET['client']!='') 
			$sql .="`sha_one`.`client`='".$_GET['client']."' and ";
			
		 if(isset($_GET['student']) && $_GET['student']!='')
			 $sql .=" CONCAT(`sha_one`.`fname`,' ',`sha_one`.`lname`) like '%".$_GET['student']."%' and ";
		
		$sql .=" 1=1 ";
		$sql .=" order by `invoice_initial`.`date` DESC";
		//$sql="select `invoice_initial`.* from `invoice_initial` JOIN `sha_one` on(`invoice_initial`.`application_id`=`sha_one`.`id`) JOIN `study_tours` ON (`invoice_initial`.`application_id`=`study_tours`.`id`) where (`invoice_initial`.`study_tour`='1' and `invoice_initial`.`application_id`=`study_tours`.`id`and `study_tours`.`client_id`='14') OR (`invoice_initial`.`study_tour`='0' and `invoice_initial`.`application_id`=`sha_one`.`id` and `sha_one`.`client`='14')";
		$query=$this->db->query($sql);
		//echo $this->db->last_query();
		$invoices=$query->result_array();
		foreach($invoices as $invoiceK=>$invoice)
		{
			$sql_item="select * from `invoice_initial_items` where `invoice_id`='".$invoice['id']."'order by `id`";
			$queryItem=$query=$this->db->query($sql_item);
			$invoices[$invoiceK]['items']=$queryItem->result_array();
			
			$sql_itemS="select * from `invoice_initial_items_standard` where `invoice_id`='".$invoice['id']."'order by `id`";
			$queryItemS=$query=$this->db->query($sql_itemS);
			if($queryItemS->num_rows()>0)
				$invoices[$invoiceK]['items_standard']=$queryItemS->result_array();
			
			$payments=getInitialInvoicePayments($invoice['id']);
			if(count($payments)>0)
				$invoices[$invoiceK]['payments']=$payments;
		}
		return $invoices;
	}*/
	
	function initialInvoicesList($status=0)
	{
		$sql="select `invoice_initial`.*  FROM `invoice_initial` left join `sha_one` ON (`invoice_initial`.`application_id`=`sha_one`.`id`) left join `study_tours` ON (`invoice_initial`.`application_id`=`study_tours`.`id`) ";
		
		$sql .="where ";
		if($status!=0)
			$sql .="`invoice_initial`.`status`='".$status."' and ";
			
		if(isset($_GET['number']) && $_GET['number']!='')
		{
			$invoiceNumArray=explode('-',trim($_GET['number']));
			$_GET['number']=trim(end($invoiceNumArray));
			$sql .="`invoice_initial`.`id` like '".$_GET['number']."%' and ";
		}
			
		if((isset($_GET['from']) && $_GET['from']!=''))
		{
			$sql .="date(`invoice_initial`.`date`)>='".normalToMysqlDate($_GET['from'])."' and ";	
		}
		
		if((isset($_GET['to']) && $_GET['to']!=''))
		{
			$sql .="date(`invoice_initial`.`date`)<='".normalToMysqlDate($_GET['to'])."' and ";	
		}
		
		if(isset($_GET['client']) && $_GET['client']!='') 
			$sql .="IF(`invoice_initial`.`study_tour` = '0', `sha_one`.`client`, `study_tours`.`client_id`) =  '".$_GET['client']."' and ";
		
		if(isset($_GET['studyTour']) && $_GET['studyTour']!='') 
			$sql .="`invoice_initial`.`study_tour` = '1' and `invoice_initial`.`application_id`=  '".$_GET['studyTour']."' and ";
			
		 if(isset($_GET['student']) && $_GET['student']!='')
			 $sql .="IF(`invoice_initial`.`study_tour` = '0', CONCAT(`sha_one`.`fname`,' ',`sha_one`.`lname`), `study_tours`.`group_name`) like '%".$_GET['student']."%' and ";
		
		if(isset($_GET['other']))
		{
			if($_GET['other']=='1')
				$sql .="`invoice_initial`.`study_tour` = '1' and ";
			if($_GET['other']=='2')
				$sql .="`invoice_initial`.`study_tour` = '0' and ";
			if($_GET['other']=='3')
				$sql .="`invoice_initial`.`cancelled` = '1' and ";
			if($_GET['other']=='4')
				$sql .="`invoice_initial`.`moved_to_xero` = '1' and ";
			if($_GET['other']=='5')
				$sql .="`invoice_initial`.`moved_to_xero` = '0' and ";
			if($_GET['other']=='6')
				$sql .=" exists (select * from `invoice_initial_items_standard` where `invoice_initial_items_standard`.`invoice_id`=`invoice_initial`.`id`) and ";																
		}
			 
		
		$sql .=" 1=1 ";
		$sql .=" order by `invoice_initial`.`date` DESC";
		
		$query=$this->db->query($sql);
		//echo $this->db->last_query();die;
		$invoices=$query->result_array();
		foreach($invoices as $invoiceK=>$invoice)
		{
			$sql_item="select * from `invoice_initial_items` where `invoice_id`='".$invoice['id']."'order by `id`";
			$queryItem=$query=$this->db->query($sql_item);
			$invoices[$invoiceK]['items']=$queryItem->result_array();
			
			$sql_itemS="select * from `invoice_initial_items_standard` where `invoice_id`='".$invoice['id']."'order by `id`";
			$queryItemS=$query=$this->db->query($sql_itemS);
			if($queryItemS->num_rows()>0)
				$invoices[$invoiceK]['items_standard']=$queryItemS->result_array();
			
			$payments=getInitialInvoicePayments($invoice['id']);
			if(count($payments)>0)
				$invoices[$invoiceK]['payments']=$payments;
		}
		return $invoices;
	}
	
	function initialInvoicesListForSync($limit='')
	{
		$limitText='';
		if($limit!='')
			$limitText=$limit*50 .', ';
		$sql="select * from `invoice_initial` where `status`!='3' and `cancelled`='0' and `moved_to_xero`='1' order by `date` DESC limit ".$limitText."50";
		$query=$this->db->query($sql);
		$invoices=$query->result_array();
		return $invoices;
	}
	
	function initialInvoiceDetails($id)
	{
		$sql="select * from `invoice_initial` where `id`='".$id."'";
		$query=$this->db->query($sql);
		$invoice=$query->row_array();
		
		if(!empty($invoice))
		{
			$sqlCustom="select * from `invoice_initial_items` where `invoice_id`='".$id."' order by `application_id`,`id`";
			$queryCustom=$this->db->query($sqlCustom);
			$invoice['items']=$queryCustom->result_array();
			
			$sqlCustomS="select * from `invoice_initial_items_standard` where `invoice_id`='".$id."' order by `id`";
			$queryCustomS=$this->db->query($sqlCustomS);
			if($queryCustomS->num_rows()>0)
				$invoice['items_standard']=$queryCustomS->result_array();
			
			$payments=getInitialInvoicePayments($id);
			if(count($payments)>0)
				$invoice['payments']=$payments;
		}
		
		return $invoice;
	}

	function deleteInvoiceItem($data)
	{
		$tableSuffix="";
		if($data['invoiceType']=='standard')
				$tableSuffix="_standard";
					
		$itemId=explode('_',$data['itemId']);
		
		$item=$itemId[1];
		
		$this->db->query("delete from `invoice_initial_items".$tableSuffix."` where `id`='".$item."' and `invoice_id`='".$data['id']."'");
		/*$sqlsel="select * from `invoice_initial_items".$tableSuffix."` where `id`='".$item."' and `invoice_id`='".$data['id']."'";
		$querySel=$this->db->query($sqlsel);
		$rowSel=$querySel->row_array();
		if(!empty($rowSel))
		{
				$name=explode('(',$rowSel['desc']);
				$sqlDayDel="delete from `invoice_initial_items".$tableSuffix."` where `desc` like '%".$name['0']."%' and `invoice_id`='".$data['id']."'";
				$this->db->query($sqlDayDel);
		}*/
		
		$sqlDel="delete from `invoice_initial_items".$tableSuffix."` where `id`='".$item."' and `invoice_id`='".$data['id']."'";
		$this->db->query($sqlDel);
	}
	
	function deleteOngoingInvoiceItem($data)
	{
		$itemId=explode('_',$data['itemId']);
		$item=$itemId[1];
		
		$this->db->query("delete from `invoice_ongoing_items` where `id`='".$item."' and `invoice_id`='".$data['id']."'");
		/*$sqlsel="select * from `invoice_ongoing_items` where `id`='".$item."' and `invoice_id`='".$data['id']."'";
		$querySel=$this->db->query($sqlsel);
		$rowSel=$querySel->row_array();
		if(!empty($rowSel))
		{
				$name=explode('(',$rowSel['desc']);
				$sqlDayDel="delete from `invoice_ongoing_items` where `desc` like '%".$name['0']."%' and `invoice_id`='".$data['id']."'";
				$this->db->query($sqlDayDel);
		}*/
		
		$ongoingInvoiceDetails=ongoingInvoiceDetails($data['id']);
		if($ongoingInvoiceDetails['study_tour']=='1')
		  {
			  $end_date=$ongoingInvoiceDetails['end_date'];
			  foreach($ongoingInvoiceDetails['items'] as $oIDItem)
				{	
					if($oIDItem['type']=='accomodation')
					{
						$total_days=0;
						$weeks=$oIDItem['qty'];
						$days=0;
						$dates=datesFromText(getTextBetweenBrackets($oIDItem['desc']));
						$sqlSel="select * from `invoice_ongoing_items` where `type`='accomodation_ed' and `application_id`='".$oIDItem['application_id']."' and `invoice_id`='".$data['id']."'";
						$querySel=$this->db->query($sqlSel);
						if($querySel->num_rows()>0)
						{
							$res=$querySel->row_array();
							$days=$res['qty'];
						}
						$total_days=($weeks*7)+$days;
						$end_dateNew=date('Y-m-d',strtotime($dates['from'].' + '.$total_days.' days -1 day'));
						if(strtotime($ongoingInvoiceDetails['end_date']) > strtotime($end_dateNew))
							$end_date=$end_dateNew;
					}
				}
				
				if(strtotime($end_date)<strtotime($ongoingInvoiceDetails['end_date']))
				{
					$sqlUp="update `invoice_ongoing` set `end_date`='".$end_date."' where `id`='".$data['id']."'";
					$this->db->query($sqlUp);
				}
		  }
		
		/*$sqlDel="delete from `invoice_ongoing_items` where `id`='".$item."' and `invoice_id`='".$data['id']."'";
		$this->db->query($sqlDel);*/
	}
	
	function addNewInvoiceItem($data)
	{
		$total=$data['unit_price']*$data['quantity'];
		if($data['invoiceType']=='real')
		{
			if($data['product_type']=='ott' || $data['product_type']=='ccs')
				$data['xero_code']='43400';
			
			if($data['product_type']=='')	
			{
				if(in_array($data['product_name'],array('Extra Night', 'Self-Catered', 'Single Room 18+', 'Single Room 18-', 'Twin Share 18-', 'Twin Share 18+', 'VIP Extra Night', 'VIP Self-Catered', 'VIP Single Room')))
				{
					if($data['qty_unit']==1)
						$data['product_type']='accomodation';
					elseif($data['qty_unit']==2)
						$data['product_type']='accomodation_ed';	
				}
			}
			$sql="insert into `invoice_initial_items` (`invoice_id`, `desc`, `unit`, `qty_unit`, `qty`, `total`, `gst`, `xero_code`,`type`, `date`) values (?,?,?,?,?,?,?,?,?,?)";
			$this->db->query($sql,array($data['invoice_id'],$data['description'],$data['unit_price'],$data['qty_unit'],$data['quantity'],$total,$data['gst'],$data['xero_code'],$data['product_type'],date('Y-m-d H:i:s')));
			
			$checkIfClientHasAgreement=checkIfClientHasAgreement($data['client'],date('Y'));
			if($checkIfClientHasAgreement)
			{
				$products=productsList(date('Y'));
				$unit_price=$data['unit_price'];
				
				foreach($products as $p)
				{
					if($p['id']==$data['product_id'])
					{
						$unit_price=$p['price'];
						$total=$p['price']*$data['quantity'];
					}
				}
				
				$sql="insert into `invoice_initial_items_standard` (`invoice_id`, `desc`, `unit`, `qty_unit`, `qty`, `total`, `gst`, `date`) values (?,?,?,?,?,?,?,?)";
				$this->db->query($sql,array($data['invoice_id'],$data['description'],$unit_price,$data['qty_unit'],$data['quantity'],$total,$data['gst'],date('Y-m-d H:i:s')));	
			}
		}
		else
		{
			$sql="insert into `invoice_initial_items_standard` (`invoice_id`, `desc`, `unit`, `qty_unit`, `qty`, `total`, `gst`, `date`) values (?,?,?,?,?,?,?,?)";
			$this->db->query($sql,array($data['invoice_id'],$data['description'],$data['unit_price'],$data['qty_unit'],$data['quantity'],$total,$data['gst'],date('Y-m-d H:i:s')));
			
			$checkIfClientHasAgreement=checkIfClientHasAgreement($data['client'],date('Y'));
			if($checkIfClientHasAgreement)
			{
				$products=clientProductsList($data['client'],date('Y'));
				$unit_price=$data['unit_price'];
				foreach($products as $p)
				{
					if($p['id']==$data['product_id'])
					{
						$unit_price=$p['price'];
						$total=$p['price']*$data['quantity'];
					}
				}
				
				$sql="insert into `invoice_initial_items` (`invoice_id`, `desc`, `unit`, `qty_unit`, `qty`, `total`, `gst`,`xero_code`,`type`, `date`) values (?,?,?,?,?,?,?,?,?,?)";
				$this->db->query($sql,array($data['invoice_id'],$data['description'],$unit_price,$data['qty_unit'],$data['quantity'],$total,$data['gst'],$data['xero_code'],$data['product_type'],date('Y-m-d H:i:s')));
			}
		}
	}
	
	function editInvoiceItem($data)
	{
			$tableSuffix="";
			if($data['invoiceType']=='standard')
			$tableSuffix="_standard";
			
			$item=$data['itemId'];
			$total=add_decimal($data['unit_price']*$data['quantity']);
			
			//updating the invoice end date in case of study tours
			$initialInvoiceDetails=initialInvoiceDetails($data['invoice_id']);
			if($initialInvoiceDetails['study_tour']=='1' && $data['quantity']=='0')
			{
				$sqlDel="delete from `invoice_initial_items".$tableSuffix."` where `id`='".$item."' and `invoice_id`='".$data['invoice_id']."'";
				$this->db->query($sqlDel);
			}
			else
			{
				if($item=='week')
				{
					$sqlDel="insert into `invoice_initial_items".$tableSuffix."` (`invoice_id`, `application_id`, `desc`, `unit`, `qty_unit`, `qty`, `total`, `gst`, `xero_code`, `type`, `date`) values (?,?,?,?,?,?,?,?,?,?,?)";
					$this->db->query($sqlDel,array($data['invoice_id'],$data['invoiceAddDaysAppId'],$data['description'],$data['unit_price'],$data['qty_unit'],$data['quantity'],$total,$data['invoiceAddDaysGst'],$data['invoiceAddDaysXero_code'],'accomodation',date('Y-m-d H:i:s') ));
				}
				else
				{
					$sqlDel="update `invoice_initial_items".$tableSuffix."` set `desc`='".$data['description']."', `unit`='".$data['unit_price']."', `qty_unit`='".$data['qty_unit']."', `qty`='".$data['quantity']."', `total`='".$total."' where `id`='".$item."' and `invoice_id`='".$data['invoice_id']."'";
					$this->db->query($sqlDel);
				}
			}
			
			$this->invoiceItemAddDays($data,'initial');
	}
	
	function initialInvoiceByShaId($id)
	{
		$sql="select * from `invoice_initial` where `application_id`='".$id."'";
		$query=$this->db->query($sql);
		//echo $this->db->last_query();
		return $query->row_array();
	}
	
	function initialInvoiceByTourId($id)
	{
		$sql="select * from `invoice_initial` where `application_id`='".$id."' and `study_tour`='1'";
		$query=$this->db->query($sql);
		//echo $this->db->last_query();
		return $query->row_array();
	}	
	
	function sha_cancellationDataProcess($data)
	{
		if(!empty($data))
		{
			$sql="insert into `invoice_initial_cancelled` (`invoice_id`,`total_amount`,`received`,`forfeited_tobe`,`settle_type`,`settle_amount`,`date`) values (?,?,?,?,?,?,?)";
			$this->db->query($sql,array($data['invoice_id'],$data['total_amount'],$data['amount_paid'],$data['forfeited_tobe'],$data['settle_type'],$data['settle_amount'],date('Y-m-d')));
			
			$sqlUpdate="update `invoice_initial` set `cancelled`='1' where `id`='".$data['invoice_id']."'";
			$this->db->query($sqlUpdate);
		}
	}
	
	function initialInvoiceCancelledData($invoice_id)
	{
		$sql="select * from `invoice_initial_cancelled` where `invoice_id`='".$invoice_id."'";
		$query=$this->db->query($sql);
		$return=$query->row_array();
		if(!empty($return))
		{
			$sqlInvoice="select * from `invoice_initial` where `id`='".$invoice_id."'";
			$queryInvoice=$this->db->query($sqlInvoice);
			$inv=$queryInvoice->row_array();
			
			$student=getshaOneAppDetails($inv['application_id']);
			$return['reason']=$student['reason'];
			$return['date_cancellation']=$student['date_cancelled'];
		}
		return $return;
	}
	
	function initialInvoiceUnmovedCount()
	{
		$sql="select count(*) as `count` from `invoice_initial` where `moved_to_xero`='0'";
		$query=$this->db->query($sql);
		$res=$query->row_array();
		return $res['count'];
	}

	function getPricingYearByDate($date)
	{
		$sql="SELECT * FROM `products_price_date` WHERE `date`<='".$date."' order by `date` DESC LIMIT 1";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	
	function getLastOngoingInvoiceByStudentId($id)
	{
		$sql="SELECT * FROM `invoice_ongoing` WHERE `application_id`='".$id."' order by `date` DESC, `id` DESC LIMIT 1";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	
	function addNewOngoingInvoice($ongoingInvoice)
	{
		$invoice_id=nextInvoiceId();
		$sql="insert into `invoice_ongoing` (`id`,`application_id`,`booking_from`,`booking_to`,`date`) values('".$invoice_id."','".$ongoingInvoice['application_id']."','".$ongoingInvoice['from']."','".$ongoingInvoice['to']."','".date('Y-m-d H:i:s')."')";
		$this->db->query($sql);
		//$invoice_id=$this->db->insert_id();
		
		$studentname=getStudentNameFromInvoiceId($invoice_id,'ongoing');
		
		foreach($ongoingInvoice['items'] as $item)
		{
			$sqlIns="insert into `invoice_ongoing_items` (`invoice_id`,`desc`,`unit`,`qty_unit`,`qty`,`total`,`xero_code`,`type`,`date`) values(?,?,?,?,?,?,?,?,?)";
			$this->db->query($sqlIns,array($invoice_id,$studentname.$item['desc'],$item['unit'],$item['qty_unit'],$item['qty'],$item['total'],$item['xero_code'],$item['type'],date('Y-d-m H:i:s')));
		}
		$ongoingInvoice['id']=$invoice_id;
		$this->addHolidayDiscountInInvoice($ongoingInvoice);
		return $invoice_id;
	}
	
	
	function ongoingInvoicesList($status=0)
	{
		$sql="select `invoice_ongoing`.* from `invoice_ongoing`  left join `sha_one` ON (`invoice_ongoing`.`application_id`=`sha_one`.`id`) left join `study_tours` ON (`invoice_ongoing`.`application_id`=`study_tours`.`id`) ";
			
		$sql .=" where ";
		
		if($status!=0)
			$sql .="`invoice_ongoing`.`status`='".$status."' and ";
			
		if(isset($_GET['number']) && $_GET['number']!='')
		{
			$invoiceNumArray=explode('-',trim($_GET['number']));
			$_GET['number']=trim(end($invoiceNumArray));
			$sql .="`invoice_ongoing`.`id` like '".$_GET['number']."%' and ";
		}
			
		if((isset($_GET['from']) && $_GET['from']!=''))
		{
			$sql .="date(`invoice_ongoing`.`date`)>='".normalToMysqlDate($_GET['from'])."' and ";	
		}
		
		if((isset($_GET['to']) && $_GET['to']!=''))
		{
			$sql .="date(`invoice_ongoing`.`date`)<='".normalToMysqlDate($_GET['to'])."' and ";	
		}
		
		if(isset($_GET['client']) && $_GET['client']!='') 
			$sql .="IF(`invoice_ongoing`.`study_tour` = '0', `sha_one`.`client`, `study_tours`.`client_id`) =  '".$_GET['client']."' and ";
		
		if(isset($_GET['studyTour']) && $_GET['studyTour']!='') 
			$sql .="`invoice_ongoing`.`study_tour` = '1' and `invoice_ongoing`.`application_id` = '".$_GET['studyTour']."' and ";
			
		 if(isset($_GET['student']) && $_GET['student']!='')
			 			 $sql .="IF(`invoice_ongoing`.`study_tour` = '0', CONCAT(`sha_one`.`fname`,' ',`sha_one`.`lname`), `study_tours`.`group_name`) like '%".$_GET['student']."%' and ";
		
		if(isset($_GET['other']))
		{
			if($_GET['other']=='1')
				$sql .="`invoice_ongoing`.`study_tour` = '1' and ";
			if($_GET['other']=='2')
				$sql .="`invoice_ongoing`.`study_tour` = '0' and ";
			if($_GET['other']=='4')
				$sql .="`invoice_ongoing`.`moved_to_xero` = '1' and ";
			if($_GET['other']=='5')
				$sql .="`invoice_ongoing`.`moved_to_xero` = '0' and ";
		}
		
		$sql .=" 1=1 ";
		$sql .=" order by `invoice_ongoing`.`date` DESC";
		
		$query=$this->db->query($sql); 
		$invoices=$query->result_array();
		foreach($invoices as $invoiceK=>$invoice)
		{
			$sql_item="select * from `invoice_ongoing_items` where `invoice_id`='".$invoice['id']."'order by `id`";
			$queryItem=$query=$this->db->query($sql_item);
			$invoices[$invoiceK]['items']=$queryItem->result_array();
			
			$payments=getOngoingInvoicePayments($invoice['id']);
			if(count($payments)>0)
				$invoices[$invoiceK]['payments']=$payments;
		}
		return $invoices;
	}
	
	
	function ongoingInvoiceDetails($id)
	{
		$sql="select * from `invoice_ongoing` where `id`='".$id."'";
		$query=$this->db->query($sql);
		$invoice=$query->row_array();
		
		if(!empty($invoice))
		{
			$sqlCustom="select * from `invoice_ongoing_items` where `invoice_id`='".$id."' order by `application_id`,`id`";
			$queryCustom=$this->db->query($sqlCustom);
			$invoice['items']=$queryCustom->result_array();
			
			/*$sqlCustomS="select * from `invoice_ongoing_items_standard` where `invoice_id`='".$id."'";
			$queryCustomS=$this->db->query($sqlCustomS);
			if($queryCustomS->num_rows()>0)
				$invoice['items_standard']=$queryCustomS->result_array();*/
			
			$payments=getOngoingInvoicePayments($id);
			if(count($payments)>0)
				$invoice['payments']=$payments;
		}
		
		return $invoice;
	}
	
	function ongoingInvoicesListForSync($limit='')
	{
		$limitText='';
		if($limit!='')
			$limitText=$limit*50 .', ';
		$sql="select * from `invoice_ongoing` where `status`!='3' and `moved_to_xero`='1'  order by `date` DESC limit ".$limitText."50";
		$query=$this->db->query($sql);
		$invoices=$query->result_array();
		return $invoices;
	}
	
	function ongoingInvoiceUnmovedCount()
	{
		$sql="select count(*) as `count` from `invoice_ongoing` where `moved_to_xero`='0'";
		$query=$this->db->query($sql);
		$res=$query->row_array();
		return $res['count'];
	}
	
	function addNewOngoingInvoiceItem($data)
	{
		$total=$data['unit_price']*$data['quantity'];

		if($data['product']=='custom')
			$data['xero_code']='43400';
			
		$sql="insert into `invoice_ongoing_items` (`invoice_id`, `desc`, `unit`, `qty_unit`, `qty`, `total`, `gst`, `xero_code`,`type`, `date`) values (?,?,?,?,?,?,?,?,?,?)";
		$this->db->query($sql,array($data['invoice_id'],$data['description'],$data['unit_price'],$data['qty_unit'],$data['quantity'],$total,$data['gst'],$data['xero_code'],$data['product_type'],date('Y-m-d H:i:s')));
	}
	
	/*function deleteOngoingInvoiceItem($data)
	{
		$itemId=explode('_',$data['itemId']);
		
		$item=$itemId[1];
		$sqlDel="delete from `invoice_ongoing_items` where `id`='".$item."' and `invoice_id`='".$data['id']."'";
		$this->db->query($sqlDel);
	}*/
	
	
	function invoiceItemAddDays($data, $invoiceType)
	{
		//if(isset($data['invoiceAddDays']))
		if(isset($data['invoiceAddDaysQuantity']))
			{
				$getTextBetweenBrackets=getTextBetweenBrackets($data['description']);
				$dayDesc=str_replace('('.$getTextBetweenBrackets.')','',$data['description']);
				$dayTotal=add_decimal($data['invoiceAddDaysUnit_price']*$data['invoiceAddDaysQuantity']);
				$dayType='accomodation_ed';
				
				$this->db->query('delete from `invoice_'.$invoiceType.'_items` where `application_id`=? and `type`=?', array($data['invoiceAddDaysAppId'],$dayType));
				if($data['invoiceAddDaysQuantity']!='0')				
				{
					$sql="insert into `invoice_".$invoiceType."_items` (`invoice_id`,`application_id`, `desc`, `unit`, `qty_unit`, `qty`, `total`, `gst`, `xero_code`,`type`, `date`) values (?,?,?,?,?,?,?,?,?,?,?)";
					$this->db->query($sql,array($data['invoice_id'],$data['invoiceAddDaysAppId'],$dayDesc,$data['invoiceAddDaysUnit_price'],$data['invoiceAddDaysQty_unit'],$data['invoiceAddDaysQuantity'],$dayTotal,$data['invoiceAddDaysGst'],$data['invoiceAddDaysXero_code'],$dayType,date('Y-m-d H:i:s')));
					//echo $this->db->last_query();
				}
			}
	}
	
	function editOngoingInvoiceItem($data)
	{
			$item=$data['itemId'];
			
			$total=add_decimal($data['unit_price']*$data['quantity']);
			
			$ongoingInvoiceDetails=ongoingInvoiceDetails($data['invoice_id']);
			if($ongoingInvoiceDetails['study_tour']=='1' && $data['quantity']=='0')
			{
				$sqlDel="delete from `invoice_ongoing_items` where `id`='".$item."' and `invoice_id`='".$data['invoice_id']."'";
				$this->db->query($sqlDel);
			}
			else
			{
				if($item=='week')
				{
					$sqlDel="insert into `invoice_ongoing_items` (`invoice_id`, `application_id`, `desc`, `unit`, `qty_unit`, `qty`, `total`, `gst`, `xero_code`, `type`, `date`) values (?,?,?,?,?,?,?,?,?,?,?)";
					$this->db->query($sqlDel,array($data['invoice_id'],$data['invoiceAddDaysAppId'],$data['description'],$data['unit_price'],$data['qty_unit'],$data['quantity'],$total,$data['invoiceAddDaysGst'],$data['invoiceAddDaysXero_code'],'accomodation',date('Y-m-d H:i:s') ));
				}
				else
				{
					$sqlDel="update `invoice_ongoing_items` set `desc`='".$data['description']."', `unit`='".$data['unit_price']."', `qty_unit`='".$data['qty_unit']."', `qty`='".$data['quantity']."', `total`='".$total."' where `id`='".$item."' and `invoice_id`='".$data['invoice_id']."'";
					$this->db->query($sqlDel);
				}
			}
			
			$this->invoiceItemAddDays($data, 'ongoing');
			
			//updating the invoice end date in case of study tours
			$ongoingInvoiceDetails=ongoingInvoiceDetails($data['invoice_id']);
			if($ongoingInvoiceDetails['study_tour']=='1')
			{
				//
				$sel="select * from `invoice_ongoing_items` where `id`='".$item."'";
				$query=$this->db->query($sel);
				$itemDetails=$query->row_array();
				if(!empty($itemDetails))
				{
					$accomodationItem=$accomodationItem_ed=array();
					foreach($ongoingInvoiceDetails['items'] as $oIDItem)
						{
							if($oIDItem['application_id']==$itemDetails['application_id'])
							{
								if($oIDItem['type']=='accomodation')
									$accomodationItem=$oIDItem;
								elseif($oIDItem['type']=='accomodation_ed')
									$accomodationItem_ed=$oIDItem;
							}
						}
						
						$weeks=0;
						$days=0;
						if(!empty($accomodationItem))
						{
							$dates=datesFromText(getTextBetweenBrackets($accomodationItem['desc']));
							$weeks=$accomodationItem['qty'];
						}
						if(!empty($accomodationItem_ed))
						{
							if(empty($accomodationItem))
								$dates=datesFromText(getTextBetweenBrackets($accomodationItem_ed['desc']));
							$days=$accomodationItem_ed['qty'];
						}
						$total_days=($weeks*7)+$days;
						$end_date=date('Y-m-d',strtotime($dates['from'].' + '.$total_days.' days -1 day'));
					///
					if($ongoingInvoiceDetails['end_date']=='0000-00-00' || strtotime($ongoingInvoiceDetails['end_date'])>strtotime($end_date))
					{
						$sqlUp="update `invoice_ongoing` set `end_date`='".$end_date."' where `id`='".$data['invoice_id']."'";
						$this->db->query($sqlUp);
					}
				}
			}
	}
	
	function deleteOngoingInvoice($id)
	{
		$sql="delete from `invoice_ongoing_items` where `invoice_id`='".$id."'";
		$this->db->query($sql);
		
		$sqlDel="delete from `invoice_ongoing` where `id`='".$id."'";
		$this->db->query($sqlDel);
	}
	
	function updateInitialInvItems($bookingDetails,$invoice_id)
	{
		$studentname=getStudentNameFromInvoiceId($invoice_id,'initial');
		$student=$bookingDetails['student'];
		$sqlUpdate="update `sha_one` set `booking_from`='".$bookingDetails['booking_from']."', `booking_to`='".$bookingDetails['booking_to']."' where `id`='".$student."'";
		$this->db->query($sqlUpdate);
		
		$sqlUpdateInv="update `invoice_initial` set `booking_from`='".$bookingDetails['booking_from']."', `booking_to`='".$bookingDetails['booking_to']."' where `id`='".$invoice_id."'";
		$this->db->query($sqlUpdateInv);
		
		$invoice=initialInvoiceBefore($student);
		
		$sql="delete from `invoice_initial_items` where `invoice_id`='".$invoice_id."' and `type` IN('accomodation','accomodation_ed','guardianship')";
		$this->db->query($sql);
		
		foreach($invoice as $itemK=>$itemV)
			{
				if($itemK!='booking_from' && $itemK!='booking_to' && $itemK!='standard')
				{
					$type="";
					if($itemK=='accomodation_fee')	
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
								//$itemV['desc'] .=dateFormat(date('Y-m-d',strtotime($invoice['booking_to'].' - 1 days')));	
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
					elseif($itemK=='guardianship_fee')
					{	
						$type="guardianship_fee";		
						$itemV['desc'] .=' ('.dateFormat($invoice['booking_from']).' to '.dateFormat($invoice['booking_to']).')';	
					}
					else
						continue;
								
				  	$sql_item="insert into `invoice_initial_items` (`invoice_id`,`desc`,`unit`,`qty_unit`,`qty`,`total`,`gst`,`xero_code`,`type`,`date`) values (?,?,?,?,?,?,?,?,?,?)";
				  	$this->db->query($sql_item,array($invoice_id,$studentname.$itemV['desc'],$itemV['unit'],$itemV['qty_unit'],$itemV['qty'],$itemV['total'],$itemV['gst'],$itemV['xero_code'],$type,date('Y-m-d H:i:s')));
				}
			}
	}
	
	function updateOngInvItems($from,$to,$student,$invoice_id)
	{
		$ongInvItems=ongInvItems($from,$to,$student);
		
		$sql="delete from `invoice_ongoing_items` where `invoice_id`='".$invoice_id."' and `type` IN('accomodation','accomodation_ed')";
		$this->db->query($sql);
		
		$studentname=getStudentNameFromInvoiceId($invoice_id,'ongoing');
		
		foreach($ongInvItems as $item)
		{
			$sqlIns="insert into `invoice_ongoing_items` (`invoice_id`,`desc`,`unit`,`qty_unit`,`qty`,`total`,`xero_code`,`type`,`date`) values(?,?,?,?,?,?,?,?,?)";
			$this->db->query($sqlIns,array($invoice_id,$studentname.$item['desc'],$item['unit'],$item['qty_unit'],$item['qty'],$item['total'],$item['xero_code'],$item['type'],date('Y-d-m H:i:s')));
		}
	}
	
	function changeStudentInvStatus($id)
	{
		$sql="select * from `invoice_initial` where `id`='".$id."'";
		$query=$this->db->query($sql);
		if($query->num_rows()>0)
		{
			$invoice=$query->row_array();
			if($invoice['studentInvSent']=='0000-00-00 00:00:00')
			{
				$newDate=date('Y-m-d H:i:s');
				$StudentIconToolTip='Student invoice sent on '.date('d M Y g:i A',strtotime($newDate));
			}
			else	
			{
				$newDate='0000-00-00 00:00:00';
				$StudentIconToolTip='Student invoice not sent. Click to change status.';
			}
			
			$update="update `invoice_initial` set `studentInvSent`='".$newDate."' where `id`='".$id."'";
			$this->db->query($update);
			return $StudentIconToolTip;
		}
	}
	
	function resetOngoingInvoice($invoice)
	{
		$sqlDel="delete from `invoice_ongoing_items` where `invoice_id`='".$invoice['id']."'";
		$this->db->query($sqlDel);
		
		$studentname=getStudentNameFromInvoiceId($invoice['id'],'ongoing');
		
		if(!empty($invoice['items']))
		{
			$sql="update `invoice_ongoing` set `booking_from`=?, `booking_to`=? where `id`=?";
			$this->db->query($sql, array($invoice['from'],$invoice['to'],$invoice['id']));
			
			foreach($invoice['items'] as $item)
			  {
				  $sqlIns="insert into `invoice_ongoing_items` (`invoice_id`,`desc`,`unit`,`qty_unit`,`qty`,`total`,`xero_code`,`type`,`date`) values(?,?,?,?,?,?,?,?,?)";
				  $this->db->query($sqlIns,array($invoice['id'],$studentname.$item['desc'],$item['unit'],$item['qty_unit'],$item['qty'],$item['total'],$item['xero_code'],$item['type'],date('Y-d-m H:i:s')));
			  }
			  
			  $this->addHolidayDiscountInInvoice($invoice);
		}
		else
		{
			$sql="delete from `invoice_ongoing` where `id`=?";
			$this->db->query($sql, array($invoice['id']));
		}
	}
	
	function lastInvoiceWithEndingDate($application_id,$date)
	{
		$sql="select `id` from `invoice_ongoing` where `study_tour`='0' and `application_id`='".$application_id."' and `booking_to`='".$date."'";
		$query=$this->db->query($sql);
		$result=array();
		if($query->num_rows()>0)
			{
				$res=$query->row_array();
				$ongoingInvoiceDetails=ongoingInvoiceDetails($res['id']);
				$ongoingInvoiceDetails['initial_invoice']='0';
				$result=$ongoingInvoiceDetails;
			}
		else
		{
			$sqlInitial="select `id` from `invoice_initial` where `study_tour`='0' and `application_id`='".$application_id."'";//no need to check date here as initial invoice always one
			$queryInitial=$this->db->query($sqlInitial);
			if($queryInitial->num_rows()>0)
			{
				$res=$queryInitial->row_array();
				$initialInvoiceDetails=initialInvoiceDetails($res['id']);
				$initialInvoiceDetails['initial_invoice']='1';
				$result=$initialInvoiceDetails;
			}
		}	
		return $result;
	}
	
	function getStudentNameFromInvoiceId($invoice_id,$type)
	{
		$studentname='';
		$sqlInvoice="select * from `invoice_".$type."` where `id`='".$invoice_id."'";
		$queryInvoice=$this->db->query($sqlInvoice);
		$invoiceInvoice=$queryInvoice->row_array();
		if(!empty($invoiceInvoice))
		{
			$student=getshaOneAppDetails($invoiceInvoice['application_id']);
			if(!empty($student))
			{
				$sha_student_no='';
				if(trim($student['sha_student_no'])!='')
					$sha_student_no=', '.$student['sha_student_no'];
				$studentname=$student['fname'].' '.$student['lname'].$sha_student_no.' - ';
			}
		}
		return $studentname;	
	}
	
	function nextInvoiceId()
	{
		$initial="select max(`id`) as `maxId` from `invoice_initial`";
		$query=$this->db->query($initial);
		$resInitial=$query->row_array();
		$maxInitial=0;
		if(!empty($resInitial))
			$maxInitial=$resInitial['maxId'];
			
		$ongoing="select max(`id`) as `maxId` from `invoice_ongoing`";
		$queryOng=$this->db->query($ongoing);
		$resOng=$queryOng->row_array();
		$maxIOng=0;
		if(!empty($resOng))
			$maxIOng=$resOng['maxId'];
		
		if($maxInitial>$maxIOng)
			$nextInvoiceId=$maxInitial+1;
		else
			$nextInvoiceId=$maxIOng+1;
		
		return 	$nextInvoiceId;
	}
	
	function ifOngInvIsLatest($id)
	{
		$res=false;
		$query=$this->db->query("select * from `invoice_ongoing` where `id`='".$id."'");
		if($query->num_rows()>0)
		{
			$invoice=$query->row_array();
			
			$qL=$this->db->query("select * from `invoice_ongoing` where `application_id`='".$invoice['application_id']."' order by `date` DESC limit 1");
			$invL=$qL->row_array();
			if($invL['id']==$invoice['id'])
				$res=true;
		}
		return $res;
	}
	
	function getInitialInvItemDetails($itemId)
	{
		return $this->db->query("select * from `invoice_initial_items` where `id`='".$itemId."'")->row_array();
	}
	
	function getWeekItemIdInitialStour($itemId)
	{
		return $this->db->query("select * from `invoice_initial_items` where `application_id` IN (select `application_id` from `invoice_initial_items` where `id`='".$itemId."') and `type`='accomodation'")->row_array();
	}
	
	function getDayItemIdInitialStour($itemId)
	{
		return $this->db->query("select * from `invoice_initial_items` where `application_id` IN (select `application_id` from `invoice_initial_items` where `id`='".$itemId."') and `type`='accomodation_ed'")->row_array();
	}
	
	function getOngInvItemDetails($itemId)
	{
		return $this->db->query("select * from `invoice_ongoing_items` where `id`='".$itemId."'")->row_array();
	}
	
	function getWeekItemIdOngStour($itemId)
	{
		return $this->db->query("select * from `invoice_ongoing_items` where `application_id` IN (select `application_id` from `invoice_ongoing_items` where `id`='".$itemId."') and `type`='accomodation'")->row_array();
	}
	
	function getDayItemIdOngStour($itemId)
	{
		return $this->db->query("select * from `invoice_ongoing_items` where `application_id` IN (select `application_id` from `invoice_ongoing_items` where `id`='".$itemId."') and `type`='accomodation_ed'")->row_array();
	}
	
	
	////////////// For data table server side STARTS

	var $table = 'invoice_initial';
	var $column_order = array('invoice_initial.id'); //set column field database for datatable orderable
	var $column_search = array('invoice_initial.id'); //set column field database for datatable searchable
	var $order = array('invoice_initial.date' => 'desc'); // default order

	private function _get_datatables_query()
	{
		$this->db->select('invoice_initial.id'); 
		$this->db->from($this->table);
		if($_POST['initial_invoice_statusPage']!='0')
			$this->db->where('invoice_initial.status', $_POST['initial_invoice_statusPage']);
			
		$this->db->join('sha_one', 'invoice_initial.application_id = sha_one.id', 'left');
		$this->db->join('study_tours', 'invoice_initial.application_id = study_tours.id', 'left');
		
		$where='';
		if(isset($_POST['InoiceFilter_number']) && $_POST['InoiceFilter_number']!='')
		{
			$invoiceNumArray=explode('-',trim($_POST['InoiceFilter_number']));
			$_POST['InoiceFilter_number']=trim(end($invoiceNumArray));
			$where .="`invoice_initial`.`id` like '".$_POST['InoiceFilter_number']."%' and ";
		}
		
		if((isset($_POST['InoiceFilter_from']) && $_POST['InoiceFilter_from']!=''))
			$where .="date(`invoice_initial`.`date`)>='".normalToMysqlDate($_POST['InoiceFilter_from'])."' and ";	
		if((isset($_POST['InoiceFilter_to']) && $_POST['InoiceFilter_to']!=''))
			$where .="date(`invoice_initial`.`date`)<='".normalToMysqlDate($_POST['InoiceFilter_to'])."' and ";
			
		if(isset($_POST['InoiceFilter_client']) && $_POST['InoiceFilter_client']!='') 
			$where .="IF(`invoice_initial`.`study_tour` = '0', `sha_one`.`client`, `study_tours`.`client_id`) =  '".$_POST['InoiceFilter_client']."' and ";
		
		if(isset($_POST['InoiceFilter_studyTour']) && $_POST['InoiceFilter_studyTour']!='') 
			$where .="`invoice_initial`.`study_tour` = '1' and `invoice_initial`.`application_id`=  '".$_POST['InoiceFilter_studyTour']."' and ";
			
		 if(isset($_POST['InoiceFilter_student']) && $_POST['InoiceFilter_student']!='')
			 $where .="IF(`invoice_initial`.`study_tour` = '0', CONCAT(`sha_one`.`fname`,' ',`sha_one`.`lname`), `study_tours`.`group_name`) like '%".$_POST['InoiceFilter_student']."%' and ";	
		
			if(isset($_POST['InoiceFilter_other']))
			{
			  if($_POST['InoiceFilter_other']=='1')
				  $where .="`invoice_initial`.`study_tour` = '1' and ";
			  if($_POST['InoiceFilter_other']=='2')
				  $where .="`invoice_initial`.`study_tour` = '0' and ";
			  if($_POST['InoiceFilter_other']=='3')
				  $where .="`invoice_initial`.`cancelled` = '1' and ";
			  if($_POST['InoiceFilter_other']=='4')
				  $where .="`invoice_initial`.`moved_to_xero` = '1' and ";
			  if($_POST['InoiceFilter_other']=='5')
				  $where .="`invoice_initial`.`moved_to_xero` = '0' and ";
			  if($_POST['InoiceFilter_other']=='6')
				  $where .=" exists (select * from `invoice_initial_items_standard` where `invoice_initial_items_standard`.`invoice_id`=`invoice_initial`.`id`) and ";																
			}
		$where .=	" 1=1 ";
		
		$this->db->where($where);
		$i = 0;

		foreach ($this->column_search as $item) // loop column
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{

				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}

		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		//echo $this->db->last_query(); //die;
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		if($_POST['initial_invoice_statusPage']!='0')
			$this->db->where('invoice_initial.status', $_POST['initial_invoice_statusPage']);
		return $this->db->count_all_results();
	}


	////////////// For data table server side ENDS
	
	function addHolidayDiscountInInvoice($invoice)
	{
		$student=getshaOneAppDetails($invoice['application_id']);
		$groupInvClient=groupInvClient($student['client']);
		if(!$groupInvClient)
		{
			//$holidays=$this->db->query("select * from `booking_holidays` where `student`=? and `start`>=? and `start`<=?",array($invoice['application_id'], $invoice['from'],$invoice['to']))->result_array();
			$holidays=$this->db->query("select * from `booking_holidays` where `student`=? and ((`start`>=? and `start`<=?) OR (`start`<? and `invoice_id`=?) OR (`invoice_id`=?))",array($invoice['application_id'], $invoice['from'],$invoice['to'], $invoice['from'], 0, $invoice['id'] ))->result_array();
			//sql explaination: select holiday in current month OR in previous month that is to be added in this month OR holiday from previous month that is added in this month(this is the case when invoice is updated)
			foreach($holidays as $holiday)
			{
				$discountData['bookHoliday_startDate']=mysqlToNormalDate($holiday['start']);
				$discountData['bookHoliday_endDate']=mysqlToNormalDate($holiday['end']);
				$discountData['bookingHoliday_bookingId']=$holiday['booking_id'];
				$discountData['bookingHoliday_invoiceId']=$holiday['invoice_id'];
				$this->load->model('booking_model');
				$this->booking_model->addDiscountForHolidayInInvoice($discountData);
			}
		}
	}
	
}