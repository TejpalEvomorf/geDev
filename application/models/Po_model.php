<?php
class Po_model extends CI_Model{
	
	function po_bookingsByDateDuration($dateDuration)
	{
		$sql="select * from `bookings` where `booking_from`>=? and `booking_from`<=? and `status` IN('arrived','moved_out') and `generate_po`=? and `serviceOnlyBooking`='0'";
		$query=$this->db->query($sql,array($dateDuration['dateFrom'],$dateDuration['dateTo'],'1'));
		//echo $this->db->last_query();
		//return $query->result_array();
		$bookings=$query->result_array();

		$queryMissed=$this->db->query("select * from `bookings` where `booking_from`>='".date('Y-m-d',strtotime($dateDuration['dateFrom'].'-4 weeks'))."' and `booking_from`<='".date('Y-m-d',strtotime($dateDuration['dateFrom'].'-1 day'))."' and `status` IN('arrived','moved_out') and `generate_po`='1' and `id` NOT IN(select `booking_id` from `purchase_orders` where `initial`='1') and `serviceOnlyBooking`='0'");
		$bookingsMissed=$queryMissed->result_array();
		$bookings=array_merge($bookings,$bookingsMissed);
		return $bookings;
	}
	
	function poNextOngoing($dateDuration)
	{
		$from=date('Y-m-d',strtotime($dateDuration['dateFrom'].' -1 day'));
		$to=date('Y-m-d',strtotime($dateDuration['dateTo'].' -1 day'));
		
		//$sql="select * from `purchase_orders` where `to`>=? and `to`<=?";
		$sql="select * from `purchase_orders` where `to`>=? and `to`<=?";
		$query=$this->db->query($sql,array($from,$to));
		//echo $this->db->last_query();
		return $query->result_array();
	}
	
	function changeBookingStatusToProgressive($booking_id)
	{
		$sql="update `bookings` set `status`='progressive' where `id`='".$booking_id."'";
		$this->db->query($sql);
	}
	
	function insertGeneratedPo($generatedPo)
	{
			foreach($generatedPo as $po)
			{
				if(!empty($po))
				{
					$query=$this->db->query("select * from `purchase_orders` where `booking_id`='".$po['booking_id']."' and `from`='".$po['po_from']."'");
					if($query->num_rows()==0)
					{
						$fromDate=$po['po_from'];
						$dueDate=date('Y-m-d',strtotime($fromDate.' next friday'));
						//$dueDate=date('Y-m-d',strtotime($dueDate.' next friday'));//commented according to the new rule, (Po starting between thu and wed will have due date on coming friday)
						$day=date('D',strtotime($fromDate));
						if($day=='Thu')
							$dueDate=date('Y-m-d',strtotime($dueDate.' next friday'));
							
						$sql="insert into `purchase_orders` (`booking_id`,`from`,`to`,`date`,`initial`,`due_date`) values(?,?,?,?,?,?)";
						$this->db->query($sql,array($po['booking_id'],$po['po_from'],$po['po_to'],date('Y-m-d H:i:s'),$po['initial'],$dueDate));
						$po_id=$this->db->insert_id();
						
						foreach($po['items'] as $pV)
						{
							$sqlItem="insert into `purchase_orders_items` (`po_id`,`desc`,`unit`,`qty_unit`,`qty`,`total`,`type`,`date`,`xero_code`) values(?,?,?,?,?,?,?,?,?)";
							$this->db->query($sqlItem,array($po_id,$pV['desc'],$pV['unit'],$pV['qty_unit'],$pV['qty'],$pV['total'],$pV['type'],date('Y-m-d H:i:s'),$pV['xero_code']));
						}
						//$this->addHolidayDiscountInPo($po_id);
						$this->load->model('holiday_model');
						$this->holiday_model->addHolidayDiscountPO($po['booking_id']);
					}
				}
			}
	}
	
	function poList($data)
	{
		if($data['pOFilter_host']!='')
		{
			$sqlHost="select `bookings`.`id` as `booking_id` from `bookings` join `hfa_one` ON (`hfa_one`.`id`=`bookings`.`host`) where CONCAT(`hfa_one`.`fname`,' ',`hfa_one`.`lname`) like '%".$data['pOFilter_host']."%'";
			$queryHost=$this->db->query($sqlHost);//echo $this->db->last_query();
			$resHost=$queryHost->result_array();
			if(empty($resHost))
				$bookingIdsArrayHost[]=0;
			foreach($resHost as $rH)
					$bookingIdsArrayHost[]=$rH['booking_id'];
		}
		else
			$bookingIdsArrayHost=array();
		
		if($data['pOFilter_studyTour']!='')
		{
			$sqlSTour="SELECT `bookings`.`id` as `booking_id`, `sha_one`.`id` FROM `bookings` join `sha_one` ON (`bookings`.`student`=`sha_one`.`id`) where `sha_one`.`study_tour_id`='".$data['pOFilter_studyTour']."'  and `sha_one`.`study_tour_id`!='0'";
			if(!empty($bookingIdsArrayHost))
				$sqlSTour .=" and `bookings`.`id` IN ('".implode("','",$bookingIdsArrayHost)."')";
			
			$querySTour=$this->db->query($sqlSTour);
			$resSTour=$querySTour->result_array();
			if(empty($resSTour))
				$bookingIdsArraySTour[]=0;
			foreach($resSTour as $rST)
				$bookingIdsArraySTour[]=$rST['booking_id'];
		}
		else
			$bookingIdsArraySTour=$bookingIdsArrayHost;
		
		if($data['pOFilter_other']!='' && ($data['pOFilter_other']=='1' || $data['pOFilter_other']=='2'))
		{
			$sqlOther="SELECT `bookings`.`id` as `booking_id`, `sha_one`.`id` FROM `bookings` join `sha_one` ON (`bookings`.`student`=`sha_one`.`id`)  where ";
			if($data['pOFilter_other']=='1')
				$sqlOther .="`sha_one`.`study_tour_id`!='0'";
			else
				$sqlOther .="`sha_one`.`study_tour_id`='0'";
				
			if(!empty($bookingIdsArraySTour))
				$sqlOther .=" and `bookings`.`id` IN ('".implode("','",$bookingIdsArraySTour)."')";
			
			$queryOther=$this->db->query($sqlOther);
			$resOther=$queryOther->result_array();
			if(empty($resOther))
				$bookingIdsArrayOther[]=0;
			foreach($resOther as $rO)
				$bookingIdsArrayOther[]=$rO['booking_id'];
		}
		else
			$bookingIdsArrayOther=$bookingIdsArraySTour;
		
		//final booking list
		$bookingIdsArray=$bookingIdsArrayOther;
		
		
		//$sql="select * from `purchase_orders` where `status`='".$status."' order by `date` DESC";
		$sql="SELECT `purchase_orders`.*, `bookings`.`student`, `bookings`.`host`,`sha_one`.`fname` as `student_fname`,`sha_one`.`lname` as `student_lname`,`sha_one`.`email` as `student_email`,`sha_one`.`mobile` as `student_mobile`,`sha_one`.`study_tour_id` as `study_tour_id`,`hfa_one`.`fname` as `host_fname`,`hfa_one`.`lname` as `host_lname`,`hfa_one`.`email` as `host_email`,`hfa_one`.`street` as `host_street`,`hfa_one`.`suburb` as `host_suburb`,`hfa_one`.`postcode` as `host_postcode`,`hfa_one`.`state` as `host_state` FROM `purchase_orders` JOIN `bookings` ON(`purchase_orders`.`booking_id`=`bookings`.`id`) JOIN `sha_one` ON(`bookings`.`student`=`sha_one`.`id`) JOIN `hfa_one` ON(`bookings`.`host`=`hfa_one`.`id`) where ";
		
		if($data['po_status']!='0')
			$sql .=" `purchase_orders`.`status`='".$data['po_status']."' and ";
			
		if($data['pOFilter_number']!='')
			$sql .="`purchase_orders`.`id` like '".$data['pOFilter_number']."%' and ";
		
		if($data['pOFilter_other']!='' && ($data['pOFilter_other']=='4' || $data['pOFilter_other']=='5'))
		{
			$sql .="`purchase_orders`.`moved_to_xero` = ";
			if($data['pOFilter_other']=='4')
				$sql .="'1' and ";
			else
				$sql .="'0' and ";			
		}
		
		if($data['poDueDate']!='')
			$sql .="`purchase_orders`.`due_date` = '".normalToMysqlDate($data['poDueDate'])."' and ";
			
		if(!empty($bookingIdsArray))
			$sql .="`purchase_orders`.`booking_id` IN ('".implode("','",$bookingIdsArray)."') and ";
			
		if($data['poFrom']!='')
			$sql .=" date(`purchase_orders`.`from`)>='".normalToMysqlDate($data['poFrom'])."' and ";
		
		if($data['poTo']!='')	
			$sql .=" date(`purchase_orders`.`from`)<='".normalToMysqlDate($data['poTo'])."' and ";
			
		$sql .=" 1=1 order by `date` DESC";
		$query=$this->db->query($sql);
		$pos=$query->result_array();
		//echo $this->db->last_query();
		foreach($pos as $poK=>$po)
		{
			$pos[$poK]['items']=$this->poItems($po['id']);
			
			/*$payments=getInitialInvoicePayments($invoice['id']);
			if(count($payments)>0)
				$invoices[$invoiceK]['payments']=$payments;*/
		}
		return $pos;
	}
	
	function poItems($id)
	{
		//$sql_item="select * from `purchase_orders_items` where `po_id`='".$id."'order by `id`";
		$sql_item="select * from `purchase_orders_items` where `po_id`='".$id."' ORDER BY FIELD(`type`, 'accomodation', 'accomodation_ed', 'holidayDiscount','adminFee','holidayAdminFeeDiscount','custom')";
		 $queryItem=$query=$this->db->query($sql_item);
		return $queryItem->result_array();
	}
	
	function poDetails($id)
	{
		$sql="SELECT `purchase_orders`.*, `bookings`.`student`, `bookings`.`host`,`sha_one`.`fname` as `student_fname`,`sha_one`.`lname` as `student_lname`,`sha_one`.`email` as `student_email`,`sha_one`.`mobile` as `student_mobile`,`sha_one`.`study_tour_id` as `study_tour_id`,`hfa_one`.`fname` as `host_fname`,`hfa_one`.`lname` as `host_lname`,`hfa_one`.`email` as `host_email`,`hfa_one`.`mobile` as `host_mobile`,`hfa_one`.`street` as `host_street`,`hfa_one`.`suburb` as `host_suburb`,`hfa_one`.`postcode` as `host_postcode`,`hfa_one`.`state` as `host_state` FROM `purchase_orders` JOIN `bookings` ON(`purchase_orders`.`booking_id`=`bookings`.`id`) JOIN `sha_one` ON(`bookings`.`student`=`sha_one`.`id`) JOIN `hfa_one` ON(`bookings`.`host`=`hfa_one`.`id`) where `purchase_orders`.`id`='".$id."'";
		$query=$this->db->query($sql);
		$po=$query->row_array();
		$items=$this->poItems($id);
		if(!empty($items))
			$po['items']=$items;
	
		return $po;
	}
	
	function poListForSync($limit='')
	{
		$limitText='';
		if($limit!='')
			$limitText=$limit*50 .', ';
		$sql="select * from `purchase_orders` where `status`!='2' and `moved_to_xero`='1' order by `date` DESC limit ".$limitText."50";
		$query=$this->db->query($sql);
		//echo $this->db->last_query();
		$invoices=$query->result_array();
		return $invoices;
	}
	
	function markPoBilled($id)
	{
		$sql="update `purchase_orders` set `status`='2' where `id`='".$id."'";
		$this->db->query($sql);
	}
	
	function updateGeneratedPo($po_id,$po_structure)
	{
		$sqlDel="delete from `purchase_orders_items` where `po_id`=?";
		$this->db->query($sqlDel,$po_id);
		
		$sqlUpdate="update `purchase_orders` set `to`=? where `id`=?";
		$this->db->query($sqlUpdate,array($po_structure['po_to'],$po_id));
		
		foreach($po_structure['items'] as $item)
		{
			$sql="insert into `purchase_orders_items` (`po_id`,`desc`,`unit`,`qty_unit`,`qty`,`total`,`type`,`xero_code`) values (?,?,?,?,?,?,?,?)";
			$this->db->query($sql,array($po_id,$item['desc'],$item['unit'],$item['qty_unit'],$item['qty'],$item['total'],$item['type'],$item['xero_code']));
		}
			  
		//$this->addHolidayDiscountInPo($po_id);
		$this->load->model('holiday_model');
		$this->holiday_model->changeDurationPoProcess($po_id);
	}
	
	function editPoItem($data)
	{
		  $item=$data['itemId'];
		  $total=add_decimal($data['unit_price']*$data['quantity']);
		  $sqlDel="update `purchase_orders_items` set `desc`='".$data['description']."', `unit`='".$data['unit_price']."', `qty_unit`='".$data['qty_unit']."', `qty`='".$data['quantity']."', `total`='".$total."' where `id`='".$item."' and `po_id`='".$data['po_id']."'";
		  $this->db->query($sqlDel);
	}
	
	function addNewItem($data)
	{
		$total=$data['unit_price']*$data['quantity'];
		$sql="insert into `purchase_orders_items` (`po_id`, `desc`, `unit`, `qty_unit`, `qty`, `total`, `gst`, `xero_code`,`type`, `date`) values (?,?,?,?,?,?,?,?,?,?)";
		$this->db->query($sql,array($data['po_id'],$data['description'],$data['unit_price'],$data['qty_unit'],$data['quantity'],$total,$data['gst'],$data['xero_code'],$data['product_type'],date('Y-m-d H:i:s')));
	}
	
	function deleteItem($data)
	{
		$itemId=explode('_',$data['itemId']);
		$item=$itemId[1];
		
		$sqlDel="delete from `purchase_orders_items` where `po_id`='".$data['id']."' and `id`='".$item."'";
		$this->db->query($sqlDel);
	}
	
	////////////// For data table server side STARTS

	var $table = 'purchase_orders';
	var $column_order = array('id'); //set column field database for datatable orderable
	var $column_search = array('purchase_orders.id', 'hfa_one.lname', 'hfa_one.email', "CONCAT(`sha_one`.`fname`,' ',`sha_one`.`lname`)"); //set column field database for datatable searchable
	var $order = array('date' => 'desc'); // default order

	private function _get_datatables_query()
	{
		$this->db->select('purchase_orders.*, `bookings`.`student`, `bookings`.`host`,`sha_one`.`fname` as `student_fname`,`sha_one`.`lname` as `student_lname`,`sha_one`.`email` as `student_email`,`sha_one`.`mobile` as `student_mobile`,`sha_one`.`study_tour_id` as `study_tour_id`,`hfa_one`.`fname` as `host_fname`,`hfa_one`.`lname` as `host_lname`,`hfa_one`.`email` as `host_email`,`hfa_one`.`street` as `host_street`,`hfa_one`.`suburb` as `host_suburb`,`hfa_one`.`postcode` as `host_postcode`,`hfa_one`.`state` as `host_state`');
		$this->db->join('bookings', 'purchase_orders.booking_id = bookings.id');
		$this->db->join('sha_one', 'bookings.student = sha_one.id');
		$this->db->join('hfa_one', 'bookings.host = hfa_one.id');
		$this->db->from($this->table);
		
		$data=$_POST;
		
		
		
		if($data['host']!='')
		{
			$sqlHost="select `bookings`.`id` as `booking_id` from `bookings` join `hfa_one` ON (`hfa_one`.`id`=`bookings`.`host`) where CONCAT(`hfa_one`.`fname`,' ',`hfa_one`.`lname`) like '%".$data['host']."%'";
			$queryHost=$this->db->query($sqlHost);//echo $this->db->last_query();
			$resHost=$queryHost->result_array();
			if(empty($resHost))
				$bookingIdsArrayHost[]=0;
			foreach($resHost as $rH)
					$bookingIdsArrayHost[]=$rH['booking_id'];
		}
		else
			$bookingIdsArrayHost=array();
		
		if($data['study_tour']!='')
		{
			$sqlSTour="SELECT `bookings`.`id` as `booking_id`, `sha_one`.`id` FROM `bookings` join `sha_one` ON (`bookings`.`student`=`sha_one`.`id`) where `sha_one`.`study_tour_id`='".$data['study_tour']."'  and `sha_one`.`study_tour_id`!='0'";
			if(!empty($bookingIdsArrayHost))
				$sqlSTour .=" and `bookings`.`id` IN ('".implode("','",$bookingIdsArrayHost)."')";
			
			$querySTour=$this->db->query($sqlSTour);
			$resSTour=$querySTour->result_array();
			if(empty($resSTour))
				$bookingIdsArraySTour[]=0;
			foreach($resSTour as $rST)
				$bookingIdsArraySTour[]=$rST['booking_id'];
		}
		else
			$bookingIdsArraySTour=$bookingIdsArrayHost;
		
		if($data['other']!='' && ($data['other']=='1' || $data['other']=='2'))
		{
			$sqlOther="SELECT `bookings`.`id` as `booking_id`, `sha_one`.`id` FROM `bookings` join `sha_one` ON (`bookings`.`student`=`sha_one`.`id`)  where ";
			if($data['other']=='1')
				$sqlOther .="`sha_one`.`study_tour_id`!='0'";
			else
				$sqlOther .="`sha_one`.`study_tour_id`='0'";
				
			if(!empty($bookingIdsArraySTour))
				$sqlOther .=" and `bookings`.`id` IN ('".implode("','",$bookingIdsArraySTour)."')";
			
			$queryOther=$this->db->query($sqlOther);
			$resOther=$queryOther->result_array();
			if(empty($resOther))
				$bookingIdsArrayOther[]=0;
			foreach($resOther as $rO)
				$bookingIdsArrayOther[]=$rO['booking_id'];
		}
		else
			$bookingIdsArrayOther=$bookingIdsArraySTour;
		
		//final booking list
		$bookingIdsArray=$bookingIdsArrayOther;
		
		
		$where='';
		if($_POST['po_status']!='0')
			$where .=" `purchase_orders`.`status`='".$data['po_status']."' and ";
		
		if($data['number']!='')
			$where .="`purchase_orders`.`id` like '".$data['number']."%' and ";
		
		if($data['other']!='' && ($data['other']=='4' || $data['other']=='5'))
		{
			$where .="`purchase_orders`.`moved_to_xero` = ";
			if($data['other']=='4')
				$where .="'1' and ";
			else
				$where .="'0' and ";			
		}
		
		if($data['poDueDate']!='')
			$where .="`purchase_orders`.`due_date` = '".normalToMysqlDate($data['poDueDate'])."' and ";
			
		if(!empty($bookingIdsArray))
			$where .="`purchase_orders`.`booking_id` IN ('".implode("','",$bookingIdsArray)."') and ";
			
		if($data['poFrom']!='')
			$where .=" date(`purchase_orders`.`from`)>='".normalToMysqlDate($data['poFrom'])."' and ";
		
		if($data['poTo']!='')	
			$where .=" date(`purchase_orders`.`from`)<='".normalToMysqlDate($data['poTo'])."' and ";
			
		$where .=" 1=1";
		
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
		//echo $this->db->last_query(); 
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
		$this->db->join('bookings', 'purchase_orders.booking_id = bookings.id');
		$this->db->join('sha_one', 'bookings.student = sha_one.id');
		$this->db->join('hfa_one', 'bookings.host = hfa_one.id');
		
		if($_POST['po_status']!='0')
			$this->db->where('purchase_orders.status', $_POST['po_status']);

		return $this->db->count_all_results();
	}


	////////////// For data table server side ENDS
	
	function getLastPoForBooking($booking_id)
	{
		$query=$this->db->query("select * from `purchase_orders` where `booking_id`='".$booking_id."' order by `to` DESC limit 1");
		$po=$query->row_array();
		return $po;
	}
	
	function ifPoIsLatest($id)
	{
		$res=false;
		$queryPo=$this->db->query("select * from `purchase_orders` where `id`='".$id."'");
		if($queryPo->num_rows()>0)
		{
			$po=$queryPo->row_array();
			
			$qL=$this->db->query("select * from `purchase_orders` where `booking_id`='".$po['booking_id']."' order by `date` DESC limit 1");
			$poL=$qL->row_array();
			if($poL['id']==$po['id'])
				$res=true;
		}
		return $res;
	}
	
	function deletePo($id)
	{
		$this->db->query("delete from `purchase_orders_items` where `po_id`='".$id."'");
		$this->db->query("delete from `purchase_orders` where `id`='".$id."'");
		
		$this->load->model('holiday_model');
		$this->holiday_model->deletePoProcess($id);
	}
	
	function addHolidayDiscountInPo($po_id)
	{
			$poDetails=$this->db->query("select * from `purchase_orders` where `id`='".$po_id."'")->row_array();
			if(!empty($poDetails))
			{
				//$holidays=$this->db->query("select * from `booking_holidays` where `booking_id`=? and `start`>=? and `start`<=?",array($poDetails['booking_id'], $poDetails['from'],$poDetails['to']))->result_array();
				$holidays=$this->db->query("select * from `booking_holidays` where `booking_id`=? and ((`start`>=? and `start`<=?) OR (`start`<? and `po_id`=?) OR (`po_id`=?))",array($poDetails['booking_id'], $poDetails['from'],$poDetails['to'], $poDetails['from'], 0, $poDetails['id']))->result_array();
				//sql explaination: select holiday in current month OR in previous month that is to be added in this month OR holiday from previous month that is added in this month(this is the case when po is updated)
				foreach($holidays as $holiday)
				{
					$discountData['bookHoliday_startDate']=mysqlToNormalDate($holiday['start']);
					$discountData['bookHoliday_endDate']=mysqlToNormalDate($holiday['end']);
					$discountData['bookingHoliday_bookingId']=$holiday['booking_id'];
					$discountData['bookingHoliday_poId']=$po_id;
					$this->load->model('booking_model');
					$this->booking_model->addDiscountForHolidayInPo($discountData);
				}
			}
	}
	
	function poPaymentDetails($id)
	{
		return $this->db->query("select * from `purchase_orders_payments` where `po_id`='".$id."'")->result_array();
	}
	
	function generate2ndPoFind1stPo($date)
	{
		return $this->db->query("select * from `purchase_orders` where `to`=? and `initial`='1'",$date)->result_array();
	}
	
	function checkIfBookingHaveOngPos($booking_id)
	{
		$rows=$this->db->query("select * from `purchase_orders` where `booking_id`=? and `initial`='0'",$booking_id)->num_rows();
		$return=true;
		if($rows==0)
			$return=false;
		return $return;	
	}

	function updatePoDueDate($po_id, $po_due_date)
	{
		$sql ="update `purchase_orders` set `due_date`=? where `id`=?";
		$this->db->query($sql,array($po_due_date,$po_id));
	}
	
}