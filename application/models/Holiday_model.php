<?php 

class Holiday_model extends CI_Model { 

	function addHolidayDiscountPO($booking_id)
	{
		$adjustments=$this->getAdjustmentsForHolidayInPo($booking_id);
		if(!empty($adjustments))
		{	//see($adjustments);
		
			$items=$this->getHolidayDiscountItem($booking_id,$adjustments[0]);
			//see($items);
			
			//add adjustments to the table
			$this->addHolidayAdjustmentsPo($adjustments[0]);
			
			//add discount to po, remove previous discounts for holiday
			$this->addHolidayDiscountItemPo($adjustments[0]['poId'],$items);	
			
			//add dicount for admin fee in po: addHolidayAdminFeePo
			$this->load->model('booking_model');
			$this->booking_model->addHolidayAdminFeePo($adjustments[0]['poId']);
			$this->addHolidayDiscountPO($booking_id);//calling it again so that the $adjustments is created again and all the pos are adjusted according to holidays
		}
	}
	
	function getAdjustmentsForHolidayInPo($booking_id)
	{
		$notAdjustedHolidays=$this->getNotAdjustedHolidaysPO($booking_id);
		//see($notAdjustedHolidays);
		$adjustments=array();
		if(!empty($notAdjustedHolidays))
		{
			/*foreach($notAdjustedHolidays as $notAdjusted)
			{
				$purchaseOrders=$this->db->query("select * from `purchase_orders` where `booking_id`=? and `moved_to_xero`=? order by `from`",array($booking_id,'0'))->result_array();
				foreach($purchaseOrders as $po)
				{
					
				}
			}*/
			
			$purchaseOrders=$this->db->query("select * from `purchase_orders` where `booking_id`=? and `moved_to_xero`=? order by `from`",array($booking_id,'0'))->result_array();
			
			foreach($purchaseOrders as $po)
			{
				$adjustmentsPO=['poId'=>$po['id']];
				foreach($notAdjustedHolidays as $notAdjusted)
				{//echo '<br>not adjusted from= '.$notAdjusted['from'].', PO to= '.$po['to'];
					if(strtotime($notAdjusted['from']) <= strtotime($po['to']))
					{//$adjDate=$notAdjusted['from'];
					//if($notAdjusted['to'])
					//$adjDate=$notAdjusted['from'];
						//echo "<br>to be Adjusted ";see($po);
						
						$adjustmentFrom=$notAdjusted['from'];
						$adjustmentTo=$notAdjusted['to'];
						/*if(strtotime($po['to']) <= strtotime($adjustmentTo))
							$adjustmentTo=date('Y-m-d',strtotime($po['to'].'+ 1 day'));*/
						if(strtotime($po['to']) < strtotime($adjustmentTo))
							$adjustmentTo=date('Y-m-d',strtotime($po['to'].'+ 1 day'));	
						
						$adjustmentsPO['holidays'][]=['from'=>$adjustmentFrom,'to'=>$adjustmentTo,'holiday_id'=>$notAdjusted['holiday_id']];
					}//else{echo '1 ';}
				}
				if(count($adjustmentsPO)>1)
					$adjustments[]=$adjustmentsPO;
			}
		}
		//see($adjustments);
		return $adjustments;
	}
	
	function getNotAdjustedHolidaysPO($booking_id)
	{
		$notAdjustedHolidays=array();
		$holidays=$this->db->query("select * from `booking_holidays` where `booking_id`=? order by `start`",array($booking_id))->result_array();
		if(!empty($holidays))
		{
			foreach($holidays as $holiday)
			{
				$adjustments=$this->db->query("select * from `booking_holidays_poAdjustment` where `holiday_id`=? order by `holiday_from`",array($holiday['id']))->result_array();
				if(!empty($adjustments))
				{
					//find the not adjusted part from the adjustments for that particular holiday
					$notAdjustedPart=['from'=>$holiday['start'],'to'=>$holiday['end'],'holiday_id'=>$holiday['id']];//just a temparary value
					foreach($adjustments as $adjustment)
					{
						$notAdjustedPart['from']=$adjustment['holiday_to'];
					}
					if(strtotime($notAdjustedPart['from']) < strtotime($holiday['end']))
						$notAdjustedHolidays[]=$notAdjustedPart;
				}
				else//No adjustments means that full holiday is not adjusted yet
					$notAdjustedHolidays[]=['from'=>$holiday['start'],'to'=>$holiday['end'],'holiday_id'=>$holiday['id']];
			}
		}
		return $notAdjustedHolidays;
	}
	
	function getHolidayDiscountItem($bookingId,$adjustments)
	{
		$items=array();
		$poId=$adjustments['poId'];
		foreach($adjustments['holidays'] as $adjustment)
		{
		$itemDiscount=array();
		
		//DESC #STARTS
		$bookingDetails=bookingDetails($bookingId);
		$this->load->model('invoice_model');
		$pricingYear=$this->invoice_model->getPricingYearByDate($adjustment['from']);
		$products=productsList($pricingYear['year']);
		$desc='';
		
		$student=getShaOneAppDetails($bookingDetails['student']);
		$age=age_from_dob($student['dob']);
		if($student['accomodation_type']==1)
			  {
				if($age<18)
					$accomodation_type='Single Room 18-';
				if($age>=18)
					$accomodation_type='Single Room 18+';
			  }
		  else if($student['accomodation_type']==2)
			  {
					//$accomodation_type='Twin Share';
				if($age<18)
					$accomodation_type='Twin Share 18-';
				if($age>=18)
					$accomodation_type='Twin Share 18+';
			  }
		  else if($student['accomodation_type']==3)					
			  $accomodation_type='Self-Catered';		
		  else if($student['accomodation_type']==4)					
			  $accomodation_type='VIP Single Room';
		  else if($student['accomodation_type']==5)					
			  $accomodation_type='VIP Self-Catered';		
			  
		  $desc=$bookingId.', '.$student['fname'].' '.$student['lname'].', ';	
		  foreach($products as $p)
		  {
			  if($p['name']==$accomodation_type)
				  $desc .=$p['name'];
		  }
		  $desc .=" (Holidays: ".dateFormat($adjustment['from'])." - ".dateFormat($adjustment['to']).")";
		//DESC #ENDS
		
		
		$unit=0;
		$poDetails=poDetails($poId);
		foreach($poDetails['items'] as $item)
		{
			if($item['type']=='accomodation')
				$unit=$item['unit']/14;//divided by 7 and then by 2 to get half price
			if($unit==0 && $item['type']=='accomodation_ed')
				$unit=$item['unit']/2;//divided by 2 to get half price
		}
		$unit=add_decimal($unit)*-1;
		$days=dayDiff($adjustment['from'],$adjustment['to'])-1;	
		
		//$itemDiscount['po_id']=$invPoDetails['id'];	
		$itemDiscount['desc']=$desc;
		$itemDiscount['unit']=$unit;
		$itemDiscount['qty_unit']='2';//day
		$itemDiscount['qty']=$days;
		$itemDiscount['total']=$unit*$days;
		$itemDiscount['gst']='0';
		$itemDiscount['xero_code']='52100';
		$itemDiscount['type']='holidayDiscount';
		$itemDiscount['date']=date('Y-m-d H:i:s');	
		$items[]=$itemDiscount;
		}
		return $items;
	}
	
	function getItemsForHolidayDiscount1($invPo,$invPoDetails,$holiday)
	{
			$itemDiscount=array();
			$startDate=$holiday['start'];
			$endDate=$holiday['end'];
			$unit=0;
			foreach($invPoDetails['items'] as $item)
			{
				if($item['type']=='accomodation')
					$unit=$item['unit']/14;//divided by 7 and then by 2 to get half price
				if($unit==0 && $item['type']=='accomodation_ed')
					$unit=$item['unit']/2;//divided by 2 to get half price
			}
			if($unit!=0)
			{
				$this->load->model('invoice_model');
			    $pricingYear=$this->invoice_model->getPricingYearByDate($startDate);
				$products=productsList($pricingYear['year']);
				$student=getShaOneAppDetails($holiday['student']);
				$age=age_from_dob($student['dob']);
				
				
				if($student['accomodation_type']==1)
					{
					  if($age<18)
						  $accomodation_type='Single Room 18-';
					  if($age>=18)
						  $accomodation_type='Single Room 18+';
					}
				else if($student['accomodation_type']==2)
					{
						  //$accomodation_type='Twin Share';
					  if($age<18)
						  $accomodation_type='Twin Share 18-';
					  if($age>=18)
						  $accomodation_type='Twin Share 18+';
					}
				else if($student['accomodation_type']==3)					
					$accomodation_type='Self-Catered';		
				else if($student['accomodation_type']==4)					
					$accomodation_type='VIP Single Room';
				else if($student['accomodation_type']==5)					
					$accomodation_type='VIP Self-Catered';		
					
				if($invPo=='invoice')
					$desc=getStudentNameFromInvoiceId($invPoDetails['id'],'ongoing');
				else
					$desc=$invPoDetails['booking_id'].', '.$student['fname'].' '.$student['lname'].', ';	
				foreach($products as $p)
				{
					if($p['name']==$accomodation_type)
						$desc .=$p['name'];
				}
				$desc .=" (Holidays: ".dateFormat($startDate)." - ".dateFormat($endDate).")";
				
				$unit=add_decimal($unit)*-1;
				$days=dayDiff($startDate,$endDate)-1;
				if($invPo=='invoice')
					$itemDiscount['inv_id']=$invPoDetails['id'];
				else	
					$itemDiscount['po_id']=$invPoDetails['id'];	
				$itemDiscount['desc']=$desc;
				$itemDiscount['unit']=$unit;
				$itemDiscount['qty_unit']='2';//day
				$itemDiscount['qty']=$days;
				$itemDiscount['total']=$unit*$days;
				$itemDiscount['gst']='0';
				$itemDiscount['xero_code']='52100';
				$itemDiscount['type']='holidayDiscount';
				$itemDiscount['date']=date('Y-m-d H:i:s');
		
	}
	return $itemDiscount;
	}
	
	
	function addHolidayDiscountInPo($booking_id)
	{
		$notAdjustedHolidays=getNotAdjustedHolidaysPO($booking_id);
	}
	
	function addHolidayAdjustmentsPo($adjustments)
	{
		foreach($adjustments['holidays'] as $adj)
		{
			$this->db->query("insert into `booking_holidays_poAdjustment` (`holiday_id`,`holiday_from`,`holiday_to`,`po_id`) values(?,?,?,?)",array($adj['holiday_id'],$adj['from'],$adj['to'],$adjustments['poId']));
		}
	}
	
	function addHolidayDiscountItemPo($poId,$items)
	{
		//$this->db->query("delete from `purchase_orders_items` where `po_id`=? and `type`=?",array($poId,'holidayDiscount'));
		foreach($items as $item)
		{
			$this->db->query("insert into `purchase_orders_items` (`po_id`,`desc`,`unit`,`qty_unit`,`qty`,`total`,`gst`,`xero_code`	,`type`,`date`) values (?,?,?,?,?,?,?,?,?,?)",array($poId,$item['desc'],$item['unit'],$item['qty_unit'],$item['qty'],$item['total'],$item['gst'],$item['xero_code'],$item['type'],$item['date']));
		}
	}
	
	function deleteHolidayDiscountProcess($poId)
	{
		$this->db->query("delete from `booking_holidays_poAdjustment` where `po_id`=?",array($poId));
		$poDetails=poDetails($poId);
		if($poDetails['moved_to_xero']=='0')
			$this->db->query("delete from `purchase_orders_items` where `po_id`=? and `type` IN(?,?)",array($poId,'holidayDiscount','holidayAdminFeeDiscount'));
	}
	
	function deleteHolidayProcess($holiday_id)
	{
		$holidayAdjustment=$this->db->query("select * from `booking_holidays_poAdjustment` where `holiday_id`=?",array($holiday_id))->result_array();
		foreach($holidayAdjustment as $adj)
		{
			$this->deleteHolidayDiscountProcess($adj['po_id']);
		}
		//Now we have to again add the adjustements because in above process holiday discount Po items from some other holiday might have been deleted as sometime we have two holiday discount items from different holidays in a single Po
		if(!empty($holidayAdjustment))
		{
			$poDetails=poDetails($adj['po_id']);
			$this->addHolidayDiscountPO($poDetails['booking_id']);
		}
	}
	
	function editHolidayProcess($holiday_id)
	{
		$holiday=$this->db->query("select * from `booking_holidays` where `id`=?",array($holiday_id))->row_array();
		if(!empty($holiday))
		{
			$this->deleteHolidayProcess($holiday_id);
			$this->addHolidayDiscountPO($holiday['booking_id']);
		}
	}
	
	function deletePoProcess($poId)
	{
		//here we only need to delete the holiday adjustment from the table, purchase order will be already deleted
		$this->deleteHolidayDiscountProcess($poId);
	}
	
	function changeDurationPoProcess($poId)
	{
		$poDetails=poDetails($poId);
		if(!empty($poDetails))
		{
			$this->deleteHolidayDiscountProcess($poId);
			$this->addHolidayDiscountPO($poDetails['booking_id']);
		}
	}
}
