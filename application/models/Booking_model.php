<?php 

class Booking_model extends CI_Model { 

	////////////// For data table server side STARTS
	
	var $table = 'bookings';
	var $column_order = array('id'); //set column field database for datatable orderable
	var $column_search = array('id'); //set column field database for datatable searchable 
	var $order = array('date_added' => 'desc'); // default order
	
	private function _get_datatables_query()
	{
		if(in_array($_POST['booking_status_page'],array('arrived', 'progressive','moved_out','cancelled')))
			$this->order=array('date_status_changed'=>'desc');
			
		$this->db->select('bookings.*');
		$this->db->from($this->table);
		
		
		if($_POST['student']!='' || $_POST['client']!='' || $_POST['study_tour']!='' || (($_POST['booking_status_page']=='expected_arrival' || $_POST['booking_status_page']=='all') && $_POST['bookingWithWarnings']=='1'))
			$this->db->join('sha_one', 'bookings.student = sha_one.id');
		if($_POST['host']!='')	
			$this->db->join('hfa_one', 'bookings.host = hfa_one.id');
		
		$where="'1'='1'";
		if($_POST['booking_status_page']!='all')
		{
			//$this->db->where('status', $_POST['booking_status_page']);
			$where .=" and `bookings`.`status`='".$_POST['booking_status_page']."'";
		}
		
		if(($_POST['booking_status_page']=='expected_arrival' || $_POST['booking_status_page']=='all') && $_POST['bookingWithWarnings']=='1')
			$where .=" and `bookings`.`status`='expected_arrival' and `sha_one`.`arrival_date`!='0000-00-00' and DATEDIFF('".date('Y-m-d')."', `sha_one`.`arrival_date`) / 365.25 <5";
		
		if($_POST['booking_id']!='')
			$where .=" and `bookings`.`id`='".$_POST['booking_id']."'";
		
		if($_POST['booking_idSF']!='')
			$where .=" and `bookings`.`salesForce_id`='".$_POST['booking_idSF']."'";	
		
if($_POST['activealboking']=='activealboking'){
		if($_POST['from']!='')
			$where .=" and `bookings`.`booking_from`<='".normalToMysqlDate($_POST['from'])."' and `bookings`.`booking_to`>='".normalToMysqlDate($_POST['from'])."'";
		
		if($_POST['to']!='')
			$where .=" and `bookings`.`booking_from`<='".normalToMysqlDate($_POST['to'])."' and `bookings`.`booking_to`>='".normalToMysqlDate($_POST['to'])."'";	
}else if($_POST['activealboking']=='activestratboking'){
	if($_POST['from']!='')
			$where .=" and `bookings`.`booking_from`>='".normalToMysqlDate($_POST['from'])."'";
		
		if($_POST['to']!='')
			$where .=" and `bookings`.`booking_from`<='".normalToMysqlDate($_POST['to'])."' ";	
	
}else if($_POST['activealboking']=='activeendboking'){
	
	if($_POST['from']!='')
			$where .=" and `bookings`.`booking_to`>='".normalToMysqlDate($_POST['from'])."'";
		
		if($_POST['to']!='')
			$where .=" and `bookings`.`booking_to`<='".normalToMysqlDate($_POST['to'])."' ";	
}
//echo $where;
		if($_POST['student']!='')
			$where .=" and CONCAT(trim(`sha_one`.`fname`),' ',trim(`sha_one`.`lname`))  LIKE '%".$_POST['student']."%'";
		
		if($_POST['host']!='')
			$where .=" and CONCAT(trim(`hfa_one`.`fname`),' ',trim(`hfa_one`.`lname`)) LIKE '%".$_POST['host']."%'";	
			
		if($_POST['client']!='')
			$where .=" and `sha_one`.`client`='".$_POST['client']."'";
		
		if($_POST['study_tour']!='')	
			$where .=" and `sha_one`.`study_tour_id`='".$_POST['study_tour']."'";
		
		if($_POST['bookingTourType']!='' || $_POST['bookingProductType']!='')
		{
			/*$sql="select `id` from `sha_one` where `study_tour_id`";
			
			if($_POST['bookingTourType']=='yes')
				$sql .=" !='0'";
			elseif($_POST['bookingTourType']=='no')
				$sql .=" ='0'";	
			$query=$this->db->query($sql);
			$bookingTourType_res=$query->result_array();
			$bookingTourType=array();
			foreach($bookingTourType_res as $plmnt)
				$bookingTourType[]=$plmnt['id'];

			if($_POST['bookingTourType']=='yes' || $_POST['bookingTourType']=='no')
				$this->db->where_in('student',$bookingTourType);*/
				
			$sql="select `id` from `sha_one` where ";
			
			if($_POST['bookingTourType']=='yes')
				$sql .="`study_tour_id` !='0'";
			elseif($_POST['bookingTourType']=='no')
				$sql .="`study_tour_id`='0'";
			elseif($_POST['bookingTourType']=='U18')
			$sql .="FLOOR(ABS(DATEDIFF(CURRENT_TIMESTAMP, dob))/365.25)<'18'";
			if($_POST['bookingProductType']!='')
			{
				  if($_POST['bookingTourType']=='yes' || $_POST['bookingTourType']=='no')
					  $sql .=" and ";
				  $sql .=" `accomodation_type` ='".$_POST['bookingProductType']."'";
			}
				
			$query=$this->db->query($sql);
			//echo $this->db->last_query(); die;
			$bookingTourType_res=$query->result_array();
			$bookingTourType=array();
			foreach($bookingTourType_res as $plmnt)
				$bookingTourType[]=$plmnt['id'];
			if(empty($bookingTourType))
				$bookingTourType[]='0';
			
			if($_POST['bookingTourType']=='yes' || $_POST['bookingTourType']=='no' || $_POST['bookingTourType']=='U18'  || $_POST['bookingProductType']!='')
				$this->db->where_in('student',$bookingTourType);
		}
		
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
		}else if(isset($_POST['bookingSortType']) &&  ($_POST['bookingSortType']=='hostfamilya')){
			$order=array('hfa_one.lname'=>"ASC");
			$this->db->join('hfa_one', 'bookings.host = hfa_one.id');
			$this->db->order_by(key($order), $order[key($order)]);	
	}else if(isset($_POST['bookingSortType']) &&  ($_POST['bookingSortType']=='hostfamilyz')){
			$order=array('hfa_one.lname'=>"desc");
			$this->db->join('hfa_one', 'bookings.host = hfa_one.id');
			$this->db->order_by(key($order), $order[key($order)]);	
	}else if(isset($_POST['bookingSortType']) &&  ($_POST['bookingSortType']=='studentnamea')){
			$order=array('sha_one.fname'=>"ASC");
			$this->db->join('sha_one', 'bookings.student = sha_one.id');
			$this->db->order_by(key($order), $order[key($order)]);	
	}else if(isset($_POST['bookingSortType']) &&  ($_POST['bookingSortType']=='studentnamez')){
			$order=array('sha_one.fname'=>"desc");
			$this->db->join('sha_one', 'bookings.student = sha_one.id');
			$this->db->order_by(key($order), $order[key($order)]);	
	}else if(isset($_POST['bookingSortType']) &&  ($_POST['bookingSortType']=='arrivaldate')){
				$order=array('sha_one.arrival_date'=>"desc");
			$this->db->join('sha_one', 'bookings.student = sha_one.id');
			$this->db->order_by(key($order), $order[key($order)]);	
	}
	elseif($_POST['booking_status_page']=='all')
	{
		$order=array('bookings.date_status_changed'=>"desc");
		$this->db->order_by(key($order), $order[key($order)]);	
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
		$query = $this->db->get();//echo $this->db->last_query();
		
		
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
		if($_POST['booking_status_page']!='all')
			$this->db->where('status', $_POST['booking_status_page']);
		
		/*if($_POST['bookingTourType']!='')
		{
			$sql="select `id` from `sha_one` where `study_tour_id`";
			
			if($_POST['bookingTourType']=='yes')
				$sql .=" !='0'";
			elseif($_POST['bookingTourType']=='no')
				$sql .=" ='0'";	
			$query=$this->db->query($sql);
			$bookingTourType_res=$query->result_array();
			$bookingTourType=array();
			foreach($bookingTourType_res as $plmnt)
				$bookingTourType[]=$plmnt['id'];

			if($_POST['bookingTourType']=='yes' || $_POST['bookingTourType']=='no')
				$this->db->where_in('student',$bookingTourType);
		}*/
		
		if($_POST['bookingTourType']!='' || $_POST['bookingProductType']!='')
		{
			$sql="select `id` from `sha_one` where ";
			
			if($_POST['bookingTourType']=='yes')
				$sql .="`study_tour_id` !='0'";
			elseif($_POST['bookingTourType']=='no')
				$sql .="`study_tour_id`='0'";
			elseif($_POST['bookingTourType']=='U18')
				$sql .="FLOOR(ABS(DATEDIFF(CURRENT_TIMESTAMP, dob))/365.25)<'18'";
			if($_POST['bookingProductType']!='')
			{
				  if($_POST['bookingTourType']=='yes' || $_POST['bookingTourType']=='no')
					  $sql .=" and ";
				  $sql .=" `accomodation_type` ='".$_POST['bookingProductType']."'";
			}
				
			$query=$this->db->query($sql);
			$bookingTourType_res=$query->result_array();
			$bookingTourType=array();
			foreach($bookingTourType_res as $plmnt)
				$bookingTourType[]=$plmnt['id'];
			if(empty($bookingTourType))
				$bookingTourType[]='0';	

			if($_POST['bookingTourType']=='yes' || $_POST['bookingTourType']=='no' || $_POST['bookingTourType']=='U18' || $_POST['bookingProductType']!='')
				$this->db->where_in('student',$bookingTourType);
		}
			
		return $this->db->count_all_results();
	}
	
	////////////// For data table server side ENDS
	
	
	function addBooking($data)
	{
		$getShaOneAppDetails=getShaOneAppDetails($data['student']);
			
		$studentBookingDates['from']=normalToMysqlDate($data['placeBooking_startDate']);
		if($data['placeBooking_endDate']!='')
			$studentBookingDates['to']=normalToMysqlDate($data['placeBooking_endDate']);
		else
			$studentBookingDates['to']='';	
		
		$bedAvailable=true;
		if(checkIfBedBooked($data['placeBooking_bedroom'],$getShaOneAppDetails['accomodation_type'],$studentBookingDates))
		{
			if(checkIfBedEligibleForTripleShare($data['placeBooking_bedroom'],$getShaOneAppDetails['accomodation_type'],$studentBookingDates))
				$bedAvailable=true;
			else
				$bedAvailable=false;	
		}
		
		//if(checkIfBedBooked($data['placeBooking_bedroom'],$getShaOneAppDetails['accomodation_type'],$studentBookingDates))
		if(!$bedAvailable)
			echo 'notAvail';
		else
		{
			$date=date('Y-m-d H:i:s');
			$startDate=$data['placeBooking_startDate'];
			if($data['placeBooking_startDate']!='')
				$startDate=normalToMysqlDate($data['placeBooking_startDate']);
			$endDate=$data['placeBooking_endDate'];
			if($data['placeBooking_endDate']!='')
				{
					$endDate=normalToMysqlDate($data['placeBooking_endDate']);
					$endDate=date('Y-m-d',strtotime($endDate.' - 1 day'));// to make the last day move out day
				}
			
			$sql="insert into `bookings` (`host`,`student`,`owner`,`booking_from`,`booking_to`,`room`,`date_added`)values(?,?,?,?,?,?,?)";
			$this->db->query($sql,array($data['host'],$data['student'],$data['placeBooking_owner'],$startDate,$endDate,$data['placeBooking_bedroom'],$date));
			
			$booking_id=$this->db->insert_id();
			$by_user_id=$this->session->userdata("user_id");
			$sqlIns="insert into `bookings_date_history` (`booking_id`,`booking_end_date`,`by_user_id`, `date`) values(?,?,?,?)";
			$by_user_id=$this->session->userdata("user_id");
			$this->db->query($sqlIns, array($booking_id,$endDate,$by_user_id,date('Y-m-d H:i:s')));
			echo $booking_id;
			//echo 'done';
		}
	}
	
	function editBooking($data)
	{
		$date=date('Y-m-d H:i:s');
		$startDate=$data['placeBooking_startDate'];
		if($data['placeBooking_startDate']!='')
			$startDate=normalToMysqlDate($data['placeBooking_startDate']);
		$endDate=$data['placeBooking_endDate'];
		if($data['placeBooking_endDate']!='')
			{
				$endDate=normalToMysqlDate($data['placeBooking_endDate']);
				$endDate=date('Y-m-d',strtotime($endDate.' - 1 day'));// to make the last day move out day
			}
		
		$noticeDate=$data['placeBooking_noticeDate'];
		$moveoutDate=$data['placeBooking_moveoutDate'];
		if($noticeDate!='' && $moveoutDate!='')
		{
			$noticeDate=normalToMysqlDate($data['placeBooking_noticeDate']);
			$moveoutDate=normalToMysqlDate($data['placeBooking_moveoutDate']);
			$moveoutDate=date('Y-m-d',strtotime($moveoutDate.' - 1 day'));// to make the last day move out day
		}
		
		$sql="update `bookings` set `owner`=?,`booking_from`=?,`booking_to`=?,`notice_date`=?,`moveout_date`=?,`room`=? where `id`=?";
		$this->db->query($sql,array($data['placeBooking_owner'],$startDate,$endDate,$noticeDate,$moveoutDate,$data['placeBooking_bedroom'],$data['booking_id']));
		
		$sqlSel="select * from `bookings_date_history` where `booking_id`='".$data['booking_id']."' and `booking_end_date`='".$endDate."'";
		$query=$this->db->query($sqlSel);
		if($query->num_rows()==0)
		{
			$sqlIns="insert into `bookings_date_history` (`booking_id`,`booking_end_date`,`by_user_id`, `date`) values(?,?,?,?)";
			$by_user_id=$this->session->userdata("user_id");
			$this->db->query($sqlIns, array($data['booking_id'],$endDate,$by_user_id,date('Y-m-d H:i:s')));
			//echo $this->db->last_query();
		}
		
		echo date('d M Y',strtotime($startDate)).' - ';
		if($endDate!='')
			echo date('d M Y',strtotime($endDate.' +1 day'));
		else
			echo 'Not set';
		
		//If a moved out booking is extended
		$bookingDetails=bookingDetails($data['booking_id']);
		if($bookingDetails['status']=='moved_out' && strtotime(date('Y-m-d')) < strtotime($bookingDetails['booking_to']))
			$this->db->query("update `bookings` set `status`=? where `id`=?",array('progressive',$data['booking_id']));
	}
	
	function roomDetails($id)
	{
		$sql="select * from `hfa_bedrooms` where `id`='".$id."'";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	
	function deleteBooking($id)
	{
		$booking=$this->bookingDetails($id);
		if(!empty($booking))
		{
			$sqlUpdate="update `sha_one` set `status`='approved_with_payment' where `id`='".$booking['student']."'";
			$this->db->query($sqlUpdate);
		}
		
		$sql="delete from `bookings` where `id`='".$id."' and `status` IN('expected_arrival','on_hold','cancelled')";
		$this->db->query($sql);
		//echo $this->db->last_query();
	}
	
	function bookingDetails($id)
	{
		$sql="select * from `bookings` where `id`='".$id."'";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	
	function changeStatus($data)
	{
		$bookST=array();
		$bookSTImplode='';
		
		if(isset($data['bookingsWarning']))
		{
			$bookST=$data['bookingsWarning'];
			$bookSTImplode="'".implode("','",$bookST)."'";
		}
		
		if($data['bookingChangeStatus_status']=='cancelled')
		{
			if($data['bookingChangeStatus_date']!='')
				$date_cancelled=normalToMysqlDate($data['bookingChangeStatus_date']);
			else	
				$date_cancelled=date('Y-m-d');
		}
		
		if($data['bookingChangeStatus_status']=='cancelled')
		{
			$bookingDetails=bookingDetails($data['bookingChangeStatus_id']);
			$sqlUpdate="update `sha_one` set `status`='cancelled', `date_cancelled`='".$date_cancelled."', `reason`='".$data['bookingChangeStatus_comment']."' where `id`='".$bookingDetails['student']."'";
			$this->db->query($sqlUpdate);
			
			//Adding to cancelled invoices
			sha_cancellationDataProcess($bookingDetails['student']);
			
			//In case of study tours
			if(!empty($bookST))
			{
				foreach($bookST as $book)
				{
					$bookingDetails=bookingDetails($book);
					$sqlUpdate="update `sha_one` set `status`='cancelled', `date_cancelled`='".$date_cancelled."', `reason`='".$data['bookingChangeStatus_comment']."' where `id`='".$bookingDetails['student']."'";
					$this->db->query($sqlUpdate);
				
					//Adding to cancelled invoices
					sha_cancellationDataProcess($bookingDetails['student']);
				}
			}
		}
		
		if($data['bookingChangeStatus_status']=='expected_arrival')
		{
			$sqlSelPo="select * from `purchase_orders` where `booking_id`='".$data['bookingChangeStatus_id']."'";
			$queryPo=$this->db->query($sqlSelPo);
			if($queryPo->num_rows()>0)
			{
				$bookingPo=$queryPo->row_array();
				
				$sqlDelPoItems="delete from `purchase_orders_items` where `po_id`='".$bookingPo['id']."'";
				$this->db->query($sqlDelPoItems);
				
				$sqlDelPo="delete from `purchase_orders` where `id`='".$bookingPo['id']."'";
				$this->db->query($sqlDelPo);
			}
			
			//In case of study tours
			if(!empty($bookST))
			{
				$sqlSelPo="select * from `purchase_orders` where `booking_id` IN(".$bookSTImplode.")";
				$queryPo=$this->db->query($sqlSelPo);
				if($queryPo->num_rows()>0)
				{
					$bookingPos=$queryPo->result_array();
					
					foreach($bookingPos as $bookingPo)
					{
						$sqlDelPoItems="delete from `purchase_orders_items` where `po_id`='".$bookingPo['id']."'";
						$this->db->query($sqlDelPoItems);
						
						$sqlDelPo="delete from `purchase_orders` where `id`='".$bookingPo['id']."'";
						$this->db->query($sqlDelPo);
					}
				}
			}
		}
		
		
		$sql="update `bookings` set `status`='".$data['bookingChangeStatus_status']."', `date_status_changed`='".date('Y-m-d H:i:s')."' ";
		
		if($data['bookingChangeStatus_status']=='on_hold' || $data['bookingChangeStatus_status']=='cancelled')
		{
			$sql .=", `comments` ='".$data['bookingChangeStatus_comment']."'";
			
			if($data['bookingChangeStatus_status']=='cancelled')
				$sql .=", `date_cancelled` ='".$date_cancelled."'";
		}
		
		//Generate PO if booking status changed to ARRIVED on friday
		if(date('D')=='Fri' && $data['bookingChangeStatus_status']=='arrived')
		{
			$bookingDetails=bookingDetails($data['bookingChangeStatus_id']);
			if($bookingDetails['status']!='arrived' && $bookingDetails['generate_po']=='1' && $bookingDetails['serviceOnlyBooking']=='0')
			{
				 $po_structure=array();
				  $po_structure[]=po_structure($data['bookingChangeStatus_id']);
				  if(!empty($po_structure))
					  {
						  $this->load->model('Po_model');
						  $bookings=$this->Po_model->insertGeneratedPo($po_structure);
					  }
			}
		}
		
		//In case of study tours
		if(!empty($bookST))
		{
			$sqlST=$sql." where `id` IN (".$bookSTImplode.")";
			$this->db->query($sqlST);
			//echo $sqlST.'<br>';
		}
		
		$sql .=" where `id`='".$data['bookingChangeStatus_id']."'";
		//echo $sql;
		$this->db->query($sql);
		//echo $this->db->last_query();
		
		if(!isset($data['studyTourId']) && $data['bookingChangeStatus_status']=='arrived')
		{
			$data['bookingCheckup_type']='1';
			$this->addNewCheckup($data);
		}
	}	
	
	function checkIfBedBooked($bed,$studentAcc,$dates)
	{
		//$sql="select * from `bookings` where `room`='".$bed."' and `status`!='cancelled' and `status`!='moved_out'";
		$sql="select * from `bookings` where `room`='".$bed."' and `status`!='cancelled'";
		$sql .=checkIfBedBookedExtraSql($dates);
		
		
		$query=$this->db->query($sql);//echo $this->db->last_query();
		if($query->num_rows()>0)
		{
			$sqlBed="select * from `hfa_bedrooms` where `id`='".$bed."' and `type` IN('2','3')";
			//check if bed is twin
			$sqlBedQuery=$this->db->query($sqlBed);
			if($sqlBedQuery->num_rows()>0)
			{
				$bookings=$query->result_array();
				$thisIsBooked=false;
				foreach($bookings as $booking)
				{
					$sqlStudent=getshaOneAppDetails($booking['student']);
					if($sqlStudent['accomodation_type']=='1' || $sqlStudent['accomodation_type']=='4')//if a student with single room as acc type is placed in a double room then that room will not be shown in search till that student is living there
						$thisIsBooked=true;
				}
				if($thisIsBooked==true)
					return true;
				if($studentAcc=='1' || $studentAcc=='3' || $studentAcc=='4' || $studentAcc=='5')//if a student with double room as acc type is placed in a double room then that room will not be shown in search for a student with acc type single till that student is living there
					return true;
				if($query->num_rows()>1)
					return true;
				else	
					return false;
			}
			else
			{
				$sqlBed="select * from `hfa_bedrooms` where `id`='".$bed."' and `type` IN('4')";
				//check if bed is Single/Twin
				$sqlBedQuery=$this->db->query($sqlBed);
				if($sqlBedQuery->num_rows()>0)
				{
					///////
						$singleTwinBookings=$query->row_array();
						$studentSingleTwinBed=getshaOneAppDetails($singleTwinBookings['student']);
						if($studentSingleTwinBed['accomodation_type']=='2')
						{
							if($query->num_rows()==1 && $studentAcc=='2')
								return false;
							else
								return true;	
						}
						else
							return true;
					////////
					
					
					
					
				}
				else
					return true;
				/*return true;	*/
			}
		}
		else
			return false;	
	}
	
	function bookingCountByStatus($status)
	{
		$sql="select count(*) as `count` from `bookings` ";
		if($status!='all')
		$sql .="where `status`='".$status."'";
		$query=$this->db->query($sql);
		$row=$query->row_array();
		return $row['count'];
	}
	
	function checkIfStudentPlaced($student)
	{
		//$sql="select * from `bookings` where `student`='".$student."' and `status`!='cancelled' and `status`!='moved_out'";
		$sql="select * from `bookings` where `student`='".$student."' and `status`!='cancelled' ";
		$query=$this->db->query($sql);
		if($query->num_rows()>0)
			return true;
		else
			return false;	
	}
	
	function bookingByShaId($id)
	{
		$sql="select * from `bookings` where `student`='".$id."'";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	
	function booking_endDate_history($id)
	{
		$sql="select * from `bookings_date_history` where `booking_id`='".$id."' order by `date` DESC";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	
	function selectApuCompany($data)
	{
		$sql="update `sha_two` set `apu_company`=? where `id`=?";
		$this->db->query($sql,array($data['apuCompanyId'],$data['sha_id']));
	}
	function selectdropApuCompany($data)
	{
		$sql="update `sha_two` set `apu_drop_company`=? where `id`=?";
		$this->db->query($sql,array($data['apuCompanyId'],$data['sha_id']));
	}
	function selectApuOption($data)
	{
		$sql="update `sha_two` set `airport_pickup`=? where `id`=?";
		$this->db->query($sql,array($data['apuOption'],$data['sha_id']));
	}
	function selectApuStOption($data)
	{
		$sql="update `sha_two` set `family_pickup_meeting_point`=?,`airport_pickup_meeting_point`=?,`airport_pickup`=? where `id`=?";
		$this->db->query($sql,array($data['apuRadioFamily'],$data['apuRadioAirport'],$data['apuRadio'],$data['sha_id']));
	}
	function selectdropApuOption($data)
	{
		$sql="update `sha_two` set `airport_dropoff`=? where `id`=?";
		$this->db->query($sql,array($data['apuOption'],$data['sha_id']));
	}
	function arrivalDateUpdate($data)
	{
		$sql="update `sha_one` set `arrival_date`=? where `id`=?";
		$this->db->query($sql,array(normalToMysqlDate($data['arrival_date']),$data['sha_id']));
	}
	function departureDateUpdate($data)
	{
		$sql="update `sha_two` set `airport_departure_date`=? where `id`=?";
		$this->db->query($sql,array(normalToMysqlDate($data['arrival_date']),$data['sha_id']));
	}
	function departureTimeUpdate($data)
	{
		$arrival_time=normalToMysqlTime(str_replace('+',' ',$data['arrival_time']));
		$sql="update `sha_two` set `airport_departure_time`=? where `id`=?";
		$this->db->query($sql,array($arrival_time,$data['sha_id']));
	}
	function arrivalTimeUpdate($data)
	{
		if($data['arrival_time']!='')
			$arrival_time=normalToMysqlTime(str_replace('+',' ',$data['arrival_time']));
		else
			$arrival_time='';	
		
		$sql="update `sha_two` set `airport_arrival_time`=? where `id`=?";
		$this->db->query($sql,array($arrival_time,$data['sha_id']));
	}
	
	function airportCarrierUpdate($data)
	{
		$sql="update `sha_two` set `airport_carrier`=? where `id`=?";
		$this->db->query($sql,array($data['airport_carrier'],$data['sha_id']));
	}
	
	function airportFlightNoUpdate($data)
	{
		$sql="update `sha_two` set `airport_flightno`=? where `id`=?";
		$this->db->query($sql,array($data['airport_flightno'],$data['sha_id']));
	}
	function airportdropCarrierUpdate($data)
	{
		$sql="update `sha_two` set `airport_drop_carrier`=? where `id`=?";
		$this->db->query($sql,array($data['airport_carrier'],$data['sha_id']));
	}
	
	function airportdropFlightNoUpdate($data)
	{
		$sql="update `sha_two` set `airport_drop_flightno`=? where `id`=?";
		$this->db->query($sql,array($data['airport_flightno'],$data['sha_id']));
	}
	function updateBookingNotes($data)
	{
		$sql="update `bookings` set `notes`=? where `id`=?";
		$this->db->query($sql,array($data['notes'],$data['booking_id']));
	}
	function savechecklistinfo($data){
		$this->db->insert("bookings_profile_checklist",$data);
		return $this->db->insert_id();
		
	}
	function getchecklistinfo($type,$id){
		
		$query = $this->db->get_where('bookings_profile_checklist', array('booking_id'=>$id,'type'=>$type));
       return  $query->num_rows();
	}
	function updatechecklistinfo($data,$id,$type){

		$this->db->where(array('booking_id'=> $id,"type"=>$type));
      $this->db->update('bookings_profile_checklist', $data);
		
		
	}
	function getallprofilechecklist($id){
		$this->db->where('booking_id',$id);
        $query=$this->db->get('bookings_profile_checklist');
        return $query->result_array();
		
	}
	function getchecklistprofileinfo($id,$type){
		$query = $this->db->get_where('bookings_profile_checklist', array('booking_id'=>$id,'type'=>$type));
       return  $query->row_array();
		
	}

	//////exact search starts/////

	//////Global Search /////////
	
	function globalsearch($type,$val){
		$where="'1'='1'";
		$this->db->select('bookings.*');
			$this->db->from($this->table);
		
		if($type=='booking'){
					
				if (is_numeric($val)) {
				

				//$where .="  `bookings`.`id`='".$val."'";
				$where =" '".$val."' IN (`bookings`.`id`,' ',`bookings`.`host`,' ',`bookings`.`student`)";		
				$this->db->where($where);
				$this->db->order_by('date_status_changed','DESC ');
				$query = $this->db->get();
				@$bookid= $query->row()->id;
				return  "booking_id=".$val."" ;
				}else{
				$this->db->join('hfa_one', 'bookings.host = hfa_one.id');
				$where .=" and '".$val."' IN(`hfa_one`.`fname`,' ',`hfa_one`.`lname`,' ',`hfa_one`.`email`,' ',`hfa_one`.`mobile`,' ',`hfa_one`.`home_phone`,' ',`hfa_one`.`work_phone`)";
				$this->db->where($where);
				$this->db->order_by('date_status_changed','DESC ');
				$query = $this->db->get();
				@$hid= $query->row()->id;
				if(!empty($hid)){
				return  "host=".$val."" ;
				}else{
				$this->db->join('sha_one', 'bookings.student = sha_one.id');
				$where .=" and'".$val."' IN(`sha_one`.`fname`,' ',`sha_one`.`lname`,' ',`sha_one`.`email`,' ',`sha_one`.`mobile`,' ',`sha_one`.`home_phone`,' ',`sha_one`.`client`)";
				$this->db->order_by('date_status_changed','DESC ');
				return  "student=".$val."" ;
				
		}
				}
	
		}else 	if($type=='hfa'){
			
			return  "host=".$val."" ;
			
		}
		else 	if($type=='sha'){
			
			return  "student ".$val."" ;
			
		}
		else 	if($type=='purchase_orders/all'){
			
			return  "host=".$val."" ;
			
		}else 	if($type=='invoice/initial_all'){
			if (is_numeric($val)) {
			
			
		
		return  "number=".$val."" ;
		
		
			
		}else{
		return  "student=".$val."" ;	
		}
		}else 	if($type=='invoice/ongoing_all'){
		if (is_numeric($val)) {	
		return  "number=".$val."" ;
		}else{
		return  "student=".$val."" ;
		}
	}else 	if($type=='booking/searchall'){
	
	  return  "value=".$val."" ;
		return "id=".$val."";
}
}

function searchall($val){
	//$where="'1'='1'";
	
	$data=array();
	if (is_numeric($val)) {	
		$this->db->select('bookings.*,hfa_one.id as hostu,sha_one.id as shau');
		$this->db->from($this->table);
		$this->db->join('hfa_one', 'bookings.host = hfa_one.id', 'LEFT');
		$this->db->join('sha_one', 'bookings.student = sha_one.id', 'LEFT');
		$where =" '".$val."' IN  (`bookings`.`id`,' ',`bookings`.`host`,' ',`bookings`.`student`,' ',`hfa_one`.`mobile`,' ',`hfa_one`.`home_phone`,' ',`hfa_one`.`work_phone`,' ',`hfa_one`.`mobile`,' ',`hfa_one`.`work_phone`,' ',`sha_one`.`mobile`,' ',`sha_one`.`home_phone`,' ',`sha_one`.`sha_student_no`,' ',`sha_one`.`client`)";
		$this->db->where($where);
		$this->db->order_by('date_status_changed','DESC ');
		$query = $this->db->get();
		$datab= $query->result_array();
		if(!empty($datab)){
			$data['booking']=$datab;
		}
		$this->db->select('hfa_one.*');
		$this->db->from('hfa_one');
		$where=" '".$val."' IN (`hfa_one`.`id`,' ',`hfa_one`.`mobile`,' ',`hfa_one`.`home_phone`,' ',`hfa_one`.`work_phone`,' ',`hfa_one`.`mobile`,' ',`hfa_one`.`work_phone`)";
		$this->db->where($where);
		$this->db->order_by('date_status_changed','DESC ');
		$query = $this->db->get();
		$datah= $query->result_array();
		if(!empty($datah)){
			$data['host']=$datah;
		}
		$this->db->select('sha_one.*');
		$this->db->from('sha_one');
		$where="'".$val."' IN (`sha_one`.`id`,' ',`sha_one`.`mobile`,' ',`sha_one`.`home_phone`,' ',`sha_one`.`sha_student_no`,' ',`sha_one`.`client`)";
		$this->db->where($where);
		$this->db->order_by('date_status_changed','DESC ');
		$query = $this->db->get();
		$datas=$query->result_array();
		if(!empty($datas)){
			$data['student']=$datas;
		}
		$this->db->select('clients.*');
		$this->db->from('clients');
		$where=" '".$val."' IN (`clients`.`id`,' ',`clients`.`primary_email`,' ',`clients`.`primary_phone`,' ',`clients`.`sec_phone`)";
		$this->db->where($where);
		$this->db->order_by('date_added','DESC ');
		$query = $this->db->get();
		 $datac=$query->result_array();
		 if(!empty($datac)){
		 $data['client']=$datac;
		 }
		$this->db->select('invoice_initial.*,sha_one.id as shau');
		$this->db->from('invoice_initial');
		$this->db->join('sha_one','invoice_initial.application_id = sha_one.id');
		$where=" '".$val."' IN (`invoice_initial`.`id`,' ',`invoice_initial`.`application_id`,' ',`invoice_initial`.`invoice_number`,' ',`sha_one`.`mobile`,' ',`sha_one`.`home_phone`,' ',`sha_one`.`sha_student_no`,' ',`sha_one`.`client`)";
		$this->db->where($where);
		$this->db->order_by('date','DESC ');
		$query = $this->db->get();
		 $datainvoice=$query->result_array();
		 if(!empty($datainvoice)){
		 $data['initial invoice']=$datainvoice;
		 }
		$this->db->select('invoice_ongoing.*, sha_one.id as shau');
		$this->db->from('invoice_ongoing');
		$this->db->join('sha_one','invoice_ongoing.application_id = sha_one.id');
		$where=" '".$val."' IN (`invoice_ongoing`.`id`,' ',`invoice_ongoing`.`application_id`,' ',`invoice_ongoing`.`invoice_number`,' ',`sha_one`.`mobile`,' ',`sha_one`.`home_phone`,' ',`sha_one`.`sha_student_no`,' ',`sha_one`.`client`)";
		$this->db->where($where);
		$this->db->order_by('date','DESC ');
		$query = $this->db->get();
		 $dataoninvoice=$query->result_array();
		 if(!empty($dataoninvoice)){
		 $data['ongoing invoice']=$dataoninvoice;
		 }
	$this->db->select('bookings.id as booking_id,bookings.host,hfa_one.*,purchase_orders.*');
	$this->db->from('bookings');
	$this->db->join('purchase_orders','purchase_orders.booking_id = bookings.id','LEFT');
	$this->db->join('hfa_one','hfa_one.id = bookings.host','LEFT');
	$where =" '".$val."' IN(`purchase_orders`.`id`,' ',`bookings`.`id`,' ',`bookings`.`host`,' ',`hfa_one`.`id`,' ',`hfa_one`.`home_phone`,' ',`hfa_one`.`mobile`,' ',`hfa_one`.`work_phone`,' ',`purchase_orders`.`id`,' ',`purchase_orders`.`po_id_xero`)";
	$this->db->where($where);
	$this->db->order_by('`purchase_orders`.`date`','DESC ');
	$query = $this->db->get();
	@$dataporder = $query->result_array();
if(!empty($dataporder)){
	$data['purchase orders'] = $dataporder;
}
		
	}
	
	/////////////numeric ends/////////
	
	else {
		
		$this->db->select('bookings.*,hfa_one.id as hostu');
		$this->db->from($this->table);
		$this->db->join('hfa_one', 'bookings.host = hfa_one.id');
		$where =" '".$val."' IN(`hfa_one`.`fname`,' ',`hfa_one`.`lname`,' ',`hfa_one`.`email`,' ',`hfa_one`.`state`,' ',`hfa_one`.`home_phone`,' ',`hfa_one`.`mobile`,' ',`hfa_one`.`work_phone`)";
		$this->db->where($where);
		$this->db->order_by('date_status_changed','DESC ');
		$query = $this->db->get();
		@$bookinghost= $query->result_array();//echo $this->db->last_query();
		if(!empty($bookinghost)){
		$data['booking']=$bookinghost;
		}

	 $this->db->select('bookings.*, sha_one.id as shau, clients.bname');
	 $this->db->from('bookings');
	 $this->db->join('sha_one', 'sha_one.id = bookings.student', 'LEFT');
	 $this->db->join('clients', 'clients.id = sha_one.client', 'LEFT');
	 $where =" '".$val."' IN(`sha_one`.`fname`,' ',`sha_one`.`lname`,' ',`sha_one`.`email`,' ',`clients`.`bname`)";
	 $this->db->where($where);
	 $this->db->order_by('date_status_changed','DESC ');
	 $query = $this->db->get();

			@$bookingstudent= $query->result_array();//echo $this->db->last_query();
			if(!empty($bookingstudent)){
		 $data['booking']=$bookingstudent;
		 }
		

	$this->db->select('hfa_one.*');
	$this->db->from("hfa_one");	
	$where =" '".$val."' IN(`hfa_one`.`fname`,' ',`hfa_one`.`lname`,' ',`hfa_one`.`email`,' ',`hfa_one`.`home_phone`,' ',`hfa_one`.`mobile`,' ',`hfa_one`.`work_phone`)";
	$this->db->where($where);
	$this->db->order_by('date_status_changed','DESC ');
	$query = $this->db->get();
	@$datah= $query->result_array();//echo $this->db->last_query();	
	if(!empty($datah)){
		 $data['host']=$datah;
		 }	

	$this->db->select('sha_one.*,clients.bname');
	$this->db->join('clients', 'clients.id = sha_one.client','LEFT');
	$this->db->from("sha_one");	
	$where ="  '".$val."' IN(`sha_one`.`fname`,' ',`sha_one`.`lname`,' ',`sha_one`.`email`,' ',`sha_one`.`mobile`,' ',`sha_one`.`home_phone`,' ',`clients`.`bname`)";
	$this->db->where($where);
	$this->db->order_by('date_status_changed','DESC ');
	$query = $this->db->get();			
	@$datas= $query->result_array();//echo $this->db->last_query();
		
	if(!empty($datas)){
		 $data['student']=$datas;
		 }	
	$this->db->select('clients.*');
	$this->db->from('clients');
	$where ="'".$val."' IN(`clients`.`bname`,' ',`clients`.`primary_contact_name`,' ',`clients`.`primary_contact_lname`,' ',`clients`.`primary_email`,' ',`clients`.`primary_phone`,' ',`clients`.`sec_phone`)";
	$this->db->where($where);
	$this->db->order_by('date_added','DESC ');
	$query = $this->db->get();
	@$datac = $query->result_array();
	if(!empty($datac)){
	$data['client'] = $datac;
	}		

	$sql="select `invoice_initial`.*  FROM `invoice_initial` left join `sha_one` ON (`invoice_initial`.`application_id`=`sha_one`.`id`) left join `study_tours` ON (`invoice_initial`.`application_id`=`study_tours`.`id`) left join `clients` ON (`clients`.`id`=`sha_one`.`client`) ";
		
	$sql .="where ";
	$sql .="IF(`invoice_initial`.`study_tour` = '0', '".$val."' IN(`sha_one`.`fname`,' ',`sha_one`.`lname`,' ',`sha_one`.`email`,' ',`sha_one`.`mobile`,' ',`sha_one`.`home_phone`,' ',`clients`.`bname`), `study_tours`.`group_name`)";// like '".$val."' ";
 	$sql .=" order by `invoice_initial`.`date` DESC";
 	$query=$this->db->query($sql);
		//echo $this->db->last_query();//die;
	$datainvoice=$query->result_array();
	 if(!empty($datainvoice)){
	 $data['initial invoice']=$datainvoice;
	}		
	$sql1="select `invoice_ongoing`.*  FROM `invoice_ongoing` left join `sha_one` ON (`invoice_ongoing`.`application_id`=`sha_one`.`id`) left join `study_tours` ON (`invoice_ongoing`.`application_id`=`study_tours`.`id`) left join `clients` ON (`clients`.`id`=`sha_one`.`client`)";
	$sql1 .="where ";
 	$sql1 .="IF(`invoice_ongoing`.`study_tour` = '0', '".$val."' IN(`sha_one`.`fname`,' ',`sha_one`.`lname`,' ',`sha_one`.`email`,' ',`sha_one`.`mobile`,' ',`sha_one`.`home_phone`,' ',`clients`.`bname`), `study_tours`.`group_name`)";// like '".$val."' ";
 	$sql1 .=" order by `invoice_ongoing`.`date` DESC ";
 	$query=$this->db->query($sql1);
		//echo $this->db->last_query();//die;
	$datainvoiceon=$query->result_array();
	 if(!empty($datainvoiceon)){
	 $data['ongoing invoice']=$datainvoiceon;
	 }

		 
	$this->db->select('bookings.id as booking_id,bookings.host,hfa_one.*,purchase_orders.*');
	$this->db->from('bookings');
	$this->db->join('purchase_orders','purchase_orders.booking_id = bookings.id','LEFT');
	$this->db->join('hfa_one','hfa_one.id = bookings.host','LEFT');
	$where =" '".$val."' IN(`hfa_one`.`fname`,' ',`hfa_one`.`lname`,' ',`hfa_one`.`email`,' ',`hfa_one`.`home_phone`,' ',`hfa_one`.`mobile`,' ',`hfa_one`.`work_phone`,' ',`purchase_orders`.`po_id_xero`)";
	$this->db->where($where);
	$this->db->order_by('`purchase_orders`.`date`','DESC ');
	$query = $this->db->get();
	@$datapo = $query->result_array();//echo $this->db->last_query();
	if(!empty($datapo)){
	$data['purchase orders'] = $datapo;
	}
	}
	
	return $data;


}
///////exact search ends/////
	
// 	//////Global parts match Search /////////
	
	function globalsearch2($type,$val){
		$where="'1'='1'";
		$this->db->select('bookings.*');
			$this->db->from($this->table);
		
		if($type=='booking'){
					
				if (is_numeric($val)) {
				

				$where .="  `bookings`.`id`='".$val."'";
				//$where .="  `bookings`.`id` LIKE '%".$val."%'";
				 $where =" CONCAT (`bookings`.`id`,' ',`bookings`.`host`,' ',`bookings`.`student`) LIKE '%".$val."%' and '".$val."' NOT IN(`bookings`.`id`,' ',`bookings`.`host`,' ',`bookings`.`student`) ";
				$this->db->where($where);
				$this->db->order_by('date_status_changed','DESC ');
				$query = $this->db->get();
		@$bookid= $query->row()->id;
		return  "booking_id=".$val."" ;
					}else{
					$this->db->join('hfa_one', 'bookings.host = hfa_one.id');
					$where .=" and CONCAT(`hfa_one`.`fname`,' ',`hfa_one`.`lname`,' ',`hfa_one`.`email`,' ',`hfa_one`.`mobile`,' ',`hfa_one`.`home_phone`,' ',`hfa_one`.`work_phone`) LIKE '%".$val."%'  and '".$val."' NOT IN(`hfa_one`.`fname`,' ',`hfa_one`.`lname`,' ',`hfa_one`.`email`,' ',`hfa_one`.`mobile`,' ',`hfa_one`.`home_phone`,' ',`hfa_one`.`work_phone`) ";	
					$this->db->where($where);
					$this->db->order_by('date_status_changed','DESC ');
				$query = $this->db->get();
		@$hid= $query->row()->id;
		if(!empty($hid)){
		return  "host=".$val."" ;
		}else{
		$this->db->join('sha_one', 'bookings.student = sha_one.id');
		$where .=" and CONCAT(`sha_one`.`fname`,' ',`sha_one`.`lname`,' ',`sha_one`.`email`,' ',`sha_one`.`mobile`,' ',`sha_one`.`home_phone`,' ',`sha_one`.`client`)  LIKE '%".$val."%' and '".$val."' NOT IN(`sha_one`.`fname`,' ',`sha_one`.`lname`,' ',`sha_one`.`email`,' ',`sha_one`.`mobile`,' ',`sha_one`.`home_phone`,' ',`sha_one`.`client`) ";
		return  "student=".$val."" ;
		
		}
				}
	
		}else 	if($type=='hfa'){
			
			return  "host=".$val."" ;
			
		}
		else 	if($type=='sha'){
			
			return  "student ".$val."" ;
			
		}
		else 	if($type=='purchase_orders/all'){
			
			return  "host=".$val."" ;
			
		}else 	if($type=='invoice/initial_all'){
			if (is_numeric($val)) {
			
			
		
		return  "number=".$val."" ;
		
		
			
		}else{
			
		return  "student=".$val."" ;
		
		
			
	}
	
		}else 	if($type=='invoice/ongoing_all'){
		if (is_numeric($val)) {
			
		return  "number=".$val."" ;
			
		
		
	}else{
		
		return  "student=".$val."" ;
	}
	
	
	
}else 	if($type=='booking/searchall'){
	
	  return  "value=".$val."" ;
		return "id=".$val."";
}
}

function searchall2($val){
	//$where="'1'='1'";
	
		$data=array();
	if (is_numeric($val)) {
		
		$this->db->select('bookings.*,hfa_one.id as hostu,sha_one.id as shau');
		
		$this->db->from($this->table);
		$this->db->join('hfa_one', 'bookings.host = hfa_one.id', 'LEFT');
		$this->db->join('sha_one', 'bookings.student = sha_one.id', 'LEFT');
		//$where ="  `bookings`.`id`='".$val."'";
		$where =" CONCAT  (`bookings`.`id`,' ',`bookings`.`host`,' ',`bookings`.`student`,' ',`hfa_one`.`mobile`,' ',`hfa_one`.`home_phone`,' ',`hfa_one`.`work_phone`,' ',`hfa_one`.`mobile`,' ',`hfa_one`.`work_phone`,' ',`sha_one`.`mobile`,' ',`sha_one`.`home_phone`,' ',`sha_one`.`sha_student_no`,' ',`sha_one`.`client`) LIKE '%".$val."%' and '".$val."' NOT IN(`bookings`.`id`,' ',`bookings`.`host`,' ',`bookings`.`student`,' ',`hfa_one`.`mobile`,' ',`hfa_one`.`home_phone`,' ',`hfa_one`.`work_phone`,' ',`hfa_one`.`mobile`,' ',`hfa_one`.`work_phone`,' ',`sha_one`.`mobile`,' ',`sha_one`.`home_phone`,' ',`sha_one`.`sha_student_no`,' ',`sha_one`.`client`)    ";
		$this->db->where($where);
		$this->db->order_by('date_status_changed','DESC ');
		$query = $this->db->get();
		$datab= $query->result_array();
		if(!empty($datab)){
			$data['booking']=$datab;
		}
		$this->db->select('hfa_one.*');
		$this->db->from('hfa_one');
		//$where="  `hfa_one`.`id`='".$val."'";
		$where=" CONCAT (`hfa_one`.`id`,' ',`hfa_one`.`mobile`,' ',`hfa_one`.`home_phone`,' ',`hfa_one`.`work_phone`,' ',`hfa_one`.`mobile`,' ',`hfa_one`.`work_phone`) LIKE '%".$val."%' and '".$val."' NOT IN(`hfa_one`.`id`,' ',`hfa_one`.`mobile`,' ',`hfa_one`.`home_phone`,' ',`hfa_one`.`work_phone`,' ',`hfa_one`.`mobile`,' ',`hfa_one`.`work_phone`) ";
		$this->db->where($where);
		$this->db->order_by('date_status_changed','DESC ');
		$query = $this->db->get();
		$datah= $query->result_array();//echo $this->db->last_query();
		if(!empty($datah)){
			$data['host']=$datah;
		}
		$this->db->select('sha_one.*');
		$this->db->from('sha_one');
	//	$where="  `sha_one`.`id`='".$val."'";
		$where=" CONCAT (`sha_one`.`id`,' ',`sha_one`.`mobile`,' ',`sha_one`.`home_phone`,' ',`sha_one`.`sha_student_no`,' ',`sha_one`.`client`) LIKE '%".$val."%' and '".$val."' NOT IN(`sha_one`.`id`,' ',`sha_one`.`mobile`,' ',`sha_one`.`home_phone`,' ',`sha_one`.`sha_student_no`,' ',`sha_one`.`client`) "; 
		$this->db->where($where);
		$this->db->order_by('date_status_changed','DESC ');
		$query = $this->db->get();
		 $datas=$query->result_array();
		if(!empty($datas)){
			$data['student']=$datas;
		}
		$this->db->select('clients.*');
		$this->db->from('clients');
		$where=" CONCAT (`clients`.`id`,' ',`clients`.`primary_email`,' ',`clients`.`primary_phone`,' ',`clients`.`sec_phone`) LIKE '%".$val."%' and '".$val."' NOT IN (`clients`.`id`,' ',`clients`.`primary_email`,' ',`clients`.`primary_phone`,' ',`clients`.`sec_phone`) ";
		$this->db->where($where);
		$this->db->order_by('date_added','DESC ');
		$query = $this->db->get();
		 $datac=$query->result_array();
		 if(!empty($datac)){
		 $data['client']=$datac;
		 }
		 $this->db->select('invoice_initial.*,sha_one.id as shau');
			$this->db->from('invoice_initial');
			$this->db->join('sha_one','invoice_initial.application_id = sha_one.id');
			$where=" CONCAT (`invoice_initial`.`id`,' ',`invoice_initial`.`application_id`,' ',`invoice_initial`.`invoice_number`,' ',`sha_one`.`mobile`,' ',`sha_one`.`home_phone`,' ',`sha_one`.`sha_student_no`,' ',`sha_one`.`client`) LIKE '%".$val."%' and '".$val."' NOT IN(`invoice_initial`.`id`,' ',`invoice_initial`.`application_id`,' ',`invoice_initial`.`invoice_number`,' ',`sha_one`.`mobile`,' ',`sha_one`.`home_phone`,' ',`sha_one`.`sha_student_no`,' ',`sha_one`.`client`)" ;
			$this->db->where($where);
			$this->db->order_by('date','DESC ');
			$query = $this->db->get();
		 $datainvoice=$query->result_array();
		 if(!empty($datainvoice)){
		 $data['initial invoice']=$datainvoice;
		 }
		  $this->db->select('invoice_ongoing.*, sha_one.id as shau');
			$this->db->from('invoice_ongoing');
			$this->db->join('sha_one','invoice_ongoing.application_id = sha_one.id');
			$where=" CONCAT (`invoice_ongoing`.`id`,' ',`invoice_ongoing`.`application_id`,' ',`invoice_ongoing`.`invoice_number`,' ',`sha_one`.`mobile`,' ',`sha_one`.`home_phone`,' ',`sha_one`.`sha_student_no`,' ',`sha_one`.`client`) LIKE '%".$val."%' and '".$val."' NOT IN(`invoice_ongoing`.`id`,' ',`invoice_ongoing`.`application_id`,' ',`invoice_ongoing`.`invoice_number`,' ',`sha_one`.`mobile`,' ',`sha_one`.`home_phone`,' ',`sha_one`.`sha_student_no`,' ',`sha_one`.`client`)";
			$this->db->where($where);
			$this->db->order_by('date','DESC ');
			$query = $this->db->get();
		 $dataoninvoice=$query->result_array();
		 if(!empty($dataoninvoice)){
		 $data['ongoing invoice']=$dataoninvoice;
		 }
	$this->db->select('bookings.id as booking_id,bookings.host,hfa_one.*,purchase_orders.*');
	$this->db->from('bookings');
	$this->db->join('purchase_orders','purchase_orders.booking_id = bookings.id','LEFT');
	$this->db->join('hfa_one','hfa_one.id = bookings.host','LEFT');
	$where =" CONCAT(`purchase_orders`.`id`,' ',`bookings`.`id`,' ',`bookings`.`host`,' ',`hfa_one`.`id`,' ',`hfa_one`.`home_phone`,' ',`hfa_one`.`mobile`,' ',`hfa_one`.`work_phone`,' ',`purchase_orders`.`id`,' ',`purchase_orders`.`po_id_xero`) LIKE '%".$val."%' and '".$val."' NOT IN(`purchase_orders`.`id`,' ',`bookings`.`id`,' ',`bookings`.`host`,' ',`hfa_one`.`id`,' ',`hfa_one`.`home_phone`,' ',`hfa_one`.`mobile`,' ',`hfa_one`.`work_phone`,' ',`purchase_orders`.`id`,' ',`purchase_orders`.`po_id_xero`) "  ;
		$this->db->where($where);
		$this->db->order_by('`purchase_orders`.`date`','DESC ');
		$query = $this->db->get();
		@$dataporder = $query->result_array();
if(!empty($dataporder)){
	$data['purchase orders'] = $dataporder;
}
		
	// echo $this->db->last_query();
	}
	/////////////numeric ends/////////
	
	else {
		
	$this->db->select('bookings.*,hfa_one.id as hostu');
	$this->db->from($this->table);
	$this->db->join('hfa_one', 'bookings.host = hfa_one.id');
	$where =" CONCAT(`hfa_one`.`fname`,' ',`hfa_one`.`lname`,' ',`hfa_one`.`email`,' ',`hfa_one`.`state`,' ',`hfa_one`.`home_phone`,' ',`hfa_one`.`mobile`,' ',`hfa_one`.`work_phone`) LIKE '%".$val."%' and '".$val."' NOT IN(`hfa_one`.`fname`,' ',`hfa_one`.`lname`,' ',`hfa_one`.`email`,' ',`hfa_one`.`state`,' ',`hfa_one`.`home_phone`,' ',`hfa_one`.`mobile`,' ',`hfa_one`.`work_phone`) ";	
	$this->db->where($where);
	$this->db->order_by('date_status_changed','DESC ');
	$query = $this->db->get();
	@$bookinghost= $query->result_array();
	if(!empty($bookinghost)){
	$data['booking']=$bookinghost;
	}

	 $this->db->select('bookings.*, sha_one.id as shau, clients.bname');
	 $this->db->from('bookings');
	 $this->db->join('sha_one', 'sha_one.id = bookings.student', 'LEFT');
	 $this->db->join('clients', 'clients.id = sha_one.client', 'LEFT');
	 $where =" CONCAT(`sha_one`.`fname`,' ',`sha_one`.`lname`,' ',`sha_one`.`email`,' ',`clients`.`bname`) LIKE '%".$val."%' and '".$val."' NOT IN(`sha_one`.`fname`,' ',`sha_one`.`lname`,' ',`sha_one`.`email`,' ',`clients`.`bname`) ";
	 $this->db->where($where);
	 $this->db->order_by('date_status_changed','DESC ');
	 $query = $this->db->get();

			@$bookingstudent= $query->result_array();
			if(!empty($bookingstudent)){
		 $data['booking']=$bookingstudent;
		 }
		

	$this->db->select('hfa_one.*');
	$this->db->from("hfa_one");	
	$where ="  CONCAT(`hfa_one`.`fname`,' ',`hfa_one`.`lname`,' ',`hfa_one`.`email`,' ',`hfa_one`.`home_phone`,' ',`hfa_one`.`mobile`,' ',`hfa_one`.`work_phone`)  LIKE '%".$val."%' and '".$val."' NOT IN(`hfa_one`.`fname`,' ',`hfa_one`.`lname`,' ',`hfa_one`.`email`,' ',`hfa_one`.`home_phone`,' ',`hfa_one`.`mobile`,' ',`hfa_one`.`work_phone`) ";
	$this->db->where($where);
	$this->db->order_by('date_status_changed','DESC ');
	$query = $this->db->get();		
	@$datah= $query->result_array();	
	if(!empty($datah)){
		 $data['host']=$datah;
	}	

	$this->db->select('sha_one.*,clients.bname');
	$this->db->join('clients', 'clients.id = sha_one.client','LEFT');
	$this->db->from("sha_one");	
	$where ="  CONCAT(`sha_one`.`fname`,' ',`sha_one`.`lname`,' ',`sha_one`.`email`,' ',`sha_one`.`mobile`,' ',`sha_one`.`home_phone`,' ',`clients`.`bname`)  LIKE '%".$val."%' and '".$val."' NOT IN(`sha_one`.`fname`,' ',`sha_one`.`lname`,' ',`sha_one`.`email`,' ',`sha_one`.`mobile`,' ',`sha_one`.`home_phone`,' ',`clients`.`bname`) ";

	$this->db->where($where);
	$this->db->order_by('date_status_changed','DESC ');
	$query = $this->db->get();
	@$datas= $query->result_array();
			
	if(!empty($datas)){$data['student']=$datas;}

	$this->db->select('clients.*');
	$this->db->from('clients');
	$where =" CONCAT(`clients`.`bname`,' ',`clients`.`primary_contact_name`,' ',`clients`.`primary_contact_lname`,' ',`clients`.`primary_email`,' ',`clients`.`primary_phone`,' ',`clients`.`sec_phone`) like '%".$val."%' and '".$val."' NOT IN(`clients`.`bname`,' ',`clients`.`primary_contact_name`,' ',`clients`.`primary_contact_lname`,' ',`clients`.`primary_email`,' ',`clients`.`primary_phone`,' ',`clients`.`sec_phone`) ";
	$this->db->where($where);
	$this->db->order_by('date_added','DESC ');
	$query = $this->db->get();
	@$datac = $query->result_array();
	if(!empty($datac)){$data['client'] = $datac;}		

	$sql="select `invoice_initial`.*  FROM `invoice_initial` left join `sha_one` ON (`invoice_initial`.`application_id`=`sha_one`.`id`) left join `study_tours` ON (`invoice_initial`.`application_id`=`study_tours`.`id`) left join `clients` ON (`clients`.`id`=`sha_one`.`client`) ";
	$sql .="where ";
	$sql .="IF(`invoice_initial`.`study_tour` = '0', CONCAT(`sha_one`.`fname`,' ',`sha_one`.`lname`,' ',`sha_one`.`email`,' ',`sha_one`.`mobile`,' ',`sha_one`.`home_phone`,' ',`clients`.`bname`), `study_tours`.`group_name`) like '%".$val."%'and '".$val."' NOT IN (`sha_one`.`fname`,' ',`sha_one`.`lname`,' ',`sha_one`.`email`,' ',`sha_one`.`mobile`,' ',`sha_one`.`home_phone`,' ',`clients`.`bname`)";
	$sql .=" order by `invoice_initial`.`date` DESC";
	$query=$this->db->query($sql);
	//echo $this->db->last_query();die;
	$datainvoice=$query->result_array();
	if(!empty($datainvoice)){
	$data['initial invoice']=$datainvoice;}		
	$sql1="select `invoice_ongoing`.*  FROM `invoice_ongoing` left join `sha_one` ON (`invoice_ongoing`.`application_id`=`sha_one`.`id`) left join `study_tours` ON (`invoice_ongoing`.`application_id`=`study_tours`.`id`) left join `clients` ON (`clients`.`id`=`sha_one`.`client`)";
	$sql1 .="where ";
	$sql1 .="IF(`invoice_ongoing`.`study_tour` = '0', CONCAT(`sha_one`.`fname`,' ',`sha_one`.`lname`,' ',`sha_one`.`email`,' ',`sha_one`.`mobile`,' ',`sha_one`.`home_phone`,' ',`clients`.`bname`), `study_tours`.`group_name`) like '%".$val."%' and '".$val."' NOT IN(`sha_one`.`fname`,' ',`sha_one`.`lname`,' ',`sha_one`.`email`,' ',`sha_one`.`mobile`,' ',`sha_one`.`home_phone`,' ',`clients`.`bname`)";
	$sql1 .=" order by `invoice_ongoing`.`date` DESC";
	$query=$this->db->query($sql1);
			//echo $this->db->last_query();die;
			$datainvoiceon=$query->result_array();
			 if(!empty($datainvoiceon)){
			 $data['ongoing invoice']=$datainvoiceon;
			 }

			 
		$this->db->select('bookings.id as booking_id,bookings.host,hfa_one.*,purchase_orders.*');
		$this->db->from('bookings');
		$this->db->join('purchase_orders','purchase_orders.booking_id = bookings.id','LEFT');
		$this->db->join('hfa_one','hfa_one.id = bookings.host','LEFT');
		$where =" CONCAT(`hfa_one`.`fname`,' ',`hfa_one`.`lname`,' ',`hfa_one`.`email`,' ',`hfa_one`.`home_phone`,' ',`hfa_one`.`mobile`,' ',`hfa_one`.`work_phone`,' ',`purchase_orders`.`po_id_xero`) LIKE '%".$val."%' and '".$val."' NOT IN(`hfa_one`.`fname`,' ',`hfa_one`.`lname`,' ',`hfa_one`.`email`,' ',`hfa_one`.`home_phone`,' ',`hfa_one`.`mobile`,' ',`hfa_one`.`work_phone`,' ',`purchase_orders`.`po_id_xero`) "  ;
			$this->db->where($where);
			$this->db->order_by('`purchase_orders`.`date`','DESC ');
			$query = $this->db->get();
			@$datapo = $query->result_array();
	if(!empty($datapo)){
		$data['purchase orders'] = $datapo;
	}
		}
		
		return $data;
		

	}




	
	function cBP($data)
	{
		$booking_from=normalToMysqlDate($data['CBP_bookingFrom']);
		if($data['CBP_bookingTo']!='')
		{
			$booking_to=normalToMysqlDate($data['CBP_bookingTo']);
			$booking_to=date('Y-m-d',strtotime($booking_to.' -1 day'));
		}
		else
			$booking_to='0000-00-00';
		
		$dates['from']=$booking_from;
		$dates['to']='';
		if($booking_to!='0000-00-00')
			$dates['to']=$booking_to;
		if(checkIfBedBooked($data['CBP_room'],$data['CBP_product'],$dates))
			$return['notAvail']='1';
		else
		 {
			$cBData['host']=$data['CBP_hostIdFound'];
			$cBData['student']=$data['CBP_studentIdFound'];
			$cBData['owner']='10';
			$cBData['booking_from']=$booking_from;
			$cBData['booking_to']=$booking_to;
			$cBData['room']=$data['CBP_room'];
			$cBData['status']='expected_arrival';
			$cBData['product']=$data['CBP_product'];
			
			$booking_id=$this->cB($cBData);	
			$return['booked']='1';
			
			$invoiceData['shaChangeStatus_id']=$data['CBP_studentIdFound'];
			
			//Create update initial invoice #STARTS
			$sqlIi="select * from `invoice_initial` where `application_id`='".$data['CBP_studentIdFound']."' and `cancelled`='0'";
			$queryIi=$this->db->query($sqlIi);
			if($queryIi->num_rows()>0)
			{
				$iI=$queryIi->row_array();
				//if initial invoice already present then we have to update it 
				$invoiceData['invoice_id']=$iI['id'];//find invoice id
				$invoiceData['dates_available']=1;
				$invoiceData['booking_from']=$booking_from;
				$invoiceData['booking_to']=date('Y-m-d',strtotime($invoiceData['booking_from'].' +4 weeks -1 day'));
				if($booking_to!='0000-00-00')
				{
					if(strtotime($booking_to) < strtotime($invoiceData['booking_to']))
					$invoiceData['booking_to']=$booking_to;
				}
				
				$this->invoice_model->updatePendingInvoice($invoiceData);
				$return['initialInvoiceUpdated']='1';
			}
			else
			{
				//if no initial invoice generated earlier
				$this->invoice_model->addPendingInvoice($invoiceData);
				
				$queryIi=$this->db->query("select * from `invoice_initial` where `application_id`='".$data['CBP_studentIdFound']."' and `cancelled`='0'");
				$iI=$queryIi->row_array();
				$invoiceData['booking_to']=$iI['booking_to'];
				$return['initialInvoiceCreated']='1';
			}
			//Create update initial invoice #ENDS
			
			//Create update ongoing invoice #STARTS
			if($booking_to=='0000-00-00' || strtotime($booking_to) > strtotime($invoiceData['booking_to']))
			{
				$dateOngoingInvoice=date('Y-m-d',strtotime('+2 week'));
				if(strtotime($dateOngoingInvoice) >= strtotime($invoiceData['booking_to'].' +1 day'))
				{
					addNewOngoingInvoice($booking_id);
					$this->addNextOngInvoicesForCreateBooking($booking_id);
					$return['ongoingInvoiceCreated']='1';
				}
			}
			//Create update ongoing invoice #ENDS
			
			//Create PO #STARTS
			$dateDuration=getPoDateByPoCreateDate(date('Y-m-d',strtotime('next Friday')),'initial');
			if(strtotime($dateDuration['dateFrom']) > strtotime($cBData['booking_from']))
			{
				$this->load->model('po_model');
				$po_structureInitial[]=po_structure($booking_id);
				$po_id=$this->po_model->insertGeneratedPo($po_structureInitial);
				
				$this->addNextPOForCreateBooking($po_id);
				$return['purchaseOrderCreated']='1';
			}
			//Create PO #ENDS
		}
		return $return;
	}
	
	function cB($data)
	{
		$sql="insert into `bookings` (`host`,`student`,`owner`,`booking_from`,`booking_to`,`room`,`status`,`date_added`) values(?,?,?,?,?,?,?,?)";
		$this->db->query($sql,array($data['host'],$data['student'],$data['owner'],$data['booking_from'],$data['booking_to'],$data['room'],$data['status'],date('Y-m-d H:i:s')));
		$booking_id=$this->db->insert_id();//echo $this->db->last_query();
		
		return $booking_id;
	}
	
	
	
	function createShaCopy($shaId)
	{
		//create duplication SHA
		$sqlSha="insert into `sha_one` (`title`,`fname`,`mname`,`lname`,`gender`,`dob`,`email`,`mobile`,`home_phone`,`accomodation_type`,`student_name2`,`nation`,`passport_no`,`passport_exp`,`arrival_date`,`client`,`employee`,`reason`,`filled_by`,`booking_from`,`booking_to`,`status`,`date_cancelled`,`step`,`date`,`date_status_changed`,`study_group`,`study_tour_id`,`special_request_notes`,`unique_csv_record`,`sha_registered_status`,`sha_student_no`) ";
		$sqlSha .=" SELECT `title`,`fname`,`mname`,`lname`,`gender`,`dob`,`email`,`mobile`,`home_phone`,`accomodation_type`,`student_name2`,`nation`,`passport_no`,`passport_exp`,`arrival_date`,`client`,`employee`,`reason`,`filled_by`,`booking_from`,`booking_to`,`status`,`date_cancelled`,`step`,`date`,`date_status_changed`,`study_group`,`study_tour_id`,`special_request_notes`,`unique_csv_record`,`sha_registered_status`,`sha_student_no` FROM `sha_one` WHERE `id` = '".$shaId."'";
		$this->db->query($sqlSha);
		$newShaId=$this->db->insert_id();
		
		$duplicateId=getDuplicateShaFirst($shaId);
		
		$sqlDuplicate="update `sha_one` set `duplicate`='".$duplicateId."', `status`='approved_without_payment' where `id`='".$newShaId."'";
		$this->db->query($sqlDuplicate);
		
		$shaTwo=getShaTwoAppDetails($shaId);
		if(!empty($shaTwo))
		{
			$sqlShaTwoArray=array();
			$sqlShaTwoArray[]=$newShaId;
			$sqlShaTwo="insert into `sha_two` (`id` ";
			foreach($shaTwo as $s2K=>$s2)
			{
				if($s2K=='id' || $s2K=='language')
					continue;
				$sqlShaTwo .=", `".$s2K."`";
			}
			$sqlShaTwo .=" ) values (? ";
			foreach($shaTwo as  $s2K=>$s2)
			{
				if($s2K=='id' || $s2K=='language')
					continue;
				$sqlShaTwo .=", ?";
				$sqlShaTwoArray[]=$s2;
			}
			$sqlShaTwo .=" ) ";
			$this->db->query($sqlShaTwo,$sqlShaTwoArray);
			
			foreach($shaTwo['language'] as $lang)
			{
					$insertLangArray=array();
					$insertLangArray[]=$newShaId;
					$insertLang="insert into `sha_language` (`application_id` ";
					foreach($lang as $lK=>$l)
					{
						if($lK=='id' || $lK=='application_id' || ($lK=='prof' && $l==''))
							continue;
						$insertLang .=", `".$lK."` ";
					}
					$insertLang .=") values (?";
					foreach($lang as $lK=>$l)
					{
						if($lK=='id' || $lK=='application_id' || ($lK=='prof' && $l==''))
							continue;
						$insertLang .=", ?";
						$insertLangArray[]=$l;
					}
					$insertLang .=")";
					$this->db->query($insertLang, $insertLangArray);
			}
			
			$shaThree=getShaThreeAppDetails($shaId);
			if(!empty($shaThree))
			{
				$sqlShaThreeArray=array();
				$sqlShaThreeArray[]=$newShaId;
				$sqlShaThree="insert into `sha_three` (`id` ";
				foreach($shaThree as $s3K=>$s3)
				{
					if($s3K=='id')
						continue;
					$sqlShaThree .=", `".$s3K."`";
				}
				$sqlShaThree .=" ) values (? ";
				foreach($shaThree as  $s3K=>$s3)
				{
					if($s3K=='id')
						continue;
					$sqlShaThree .=", ?";
					$sqlShaThreeArray[]=$s3;
				}
				$sqlShaThree .=" ) ";
				$this->db->query($sqlShaThree, $sqlShaThreeArray);
			}
		}
		
		$sqlDoc="select * from `sha_documents` where `sha_id`=?";
		$queryDoc=$this->db->query($sqlDoc,array($shaId));
		$resDoc=$queryDoc->result_array();
		
		$sqlShaDocArray=array();
		$sqlShaDocArray[]=$newShaId;
		$sqlShaDoc="insert into `sha_documents` (`sha_id`";
		
		foreach($resDoc as $resd)
		{
			$sqlShaDoc="insert into `sha_documents` (`sha_id`";
			foreach($resd as $rK=>$rV)
			{
				if($rK=='id' || $rK=='sha_id')
					continue;
				$sqlShaDoc .=",".$rK;	
			}
			$sqlShaDoc .=") values(".$newShaId;
			foreach($resd as $rK=>$rV)
			{
				if($rK=='id' || $rK=='sha_id')
					continue;
				$sqlShaDoc .=",'".$rV."'";	
			}
			$sqlShaDoc .=") ";
			$this->db->query($sqlShaDoc);
		}
		return $newShaId;
	}
	function savebookinghliday($data){
		$startDate=normalToMysqlDate($data['sdate']);
		if($data['type']=='start'){
			$this->db->where("id",$data['id']);
			$this->db->update("bookings",array("booking_holidaystart"=>$startDate));
		}else{
			$this->db->where("id",$data['id']);
			$this->db->update("bookings",array("booking_holidayend"=>$startDate));
		}
	}
	
	function bookingBedNumber($booking_id)
	{
		$bookingDetails=bookingDetails($booking_id);
		$query=$this->db->query("select * from `hfa_bedrooms` where `application_id`='".$bookingDetails['host']."' order by `id`");
		$rooms=$query->result_array();
		
		$roomCount=1;
		$roomNo=0;
		foreach($rooms as $room)
		{
			if($room['id']==$bookingDetails['room'])
			{
				$roomNo=$roomCount;
				break;
			}
			$roomCount++;
		}
		return $roomNo;
	}
	
	function addNextOngInvoicesForCreateBooking($booking_id)
		{
			$bookingDetails=bookingDetails($booking_id);
			$this->load->model('model/invoice_model');
			$lastInvoice=$this->invoice_model->getLastOngoingInvoiceByStudentId($bookingDetails['student']);
			if(!empty($lastInvoice))
			{
				if(strtotime($lastInvoice['booking_to']) < strtotime($bookingDetails['booking_to']))//check if there is space for next ongoing invoice
				{
					$dateOngoingInvoice=date('Y-m-d',strtotime('+2 week'));
					if(strtotime($lastInvoice['booking_to']) <= strtotime($dateOngoingInvoice))
					{
						addNewOngoingInvoice($booking_id);
						$this->db->query("update `bookings` set `status`='progressive' where `id`='".$booking_id."'");
						
						$this->addNextOngInvoicesForCreateBooking($booking_id);
					}
				}
			}
		}
		
		function addNextPOForCreateBooking($po_id)
		{
			$dateDurationOng=getPoDateByPoCreateDate(date('Y-m-d',strtotime('next Friday')),'ongoing');
			$poDetails=$this->po_model->poDetails($po_id);
			if(strtotime($poDetails['to'].' + 1 day') < strtotime($dateDurationOng['dateFrom']))
			{
				$po_structureOng[]=po_structure($poDetails['booking_id'],$poDetails);
				$po_id=$this->po_model->insertGeneratedPo($po_structureOng);
				$this->addNextPOForCreateBooking($po_id);
			}
		}
		
	function generatePoBookingOption($data)
	{
		$generate_po	='1';
		if(isset($data['generatePoOption']))
			$generate_po	='0';
		$generate_ongInv='1';
		if(isset($data['generateOngInvOption']))
			$generate_ongInv='0';
			
		$this->db->query("update `bookings` set `generate_po`=?, `generate_ongInv`=? where `id`=?",array($generate_po,$generate_ongInv,$data['generatePoOption_booking_id']));echo $this->db->last_query();
	}	
	
	function getRoomListForCreateBooking($data)
	{
		$dates['from']=normalToMysqlDate($data['from']);
		$dates['to']=normalToMysqlDate($data['to']);
		
		if($data['product']=='1')
			$bedTypes=array('1','4');
		elseif($data['product']=='2')
			$bedTypes=array('2','3','4');
		elseif($data['product']=='3')
			$bedTypes=array('1','3','4');
		elseif($data['product']=='4' || $data['product']=='5')
			$bedTypes=array('1');
			
		$formTwo=getHfaTwoAppDetails($data['host']);
		$beds=array();
		foreach($formTwo['bedroomDetails'] as $bed)
		{
			if(in_array($bed['type'],$bedTypes))
			{
				if(!checkIfBedBooked($bed['id'],$bed['type'],$dates))
					$beds[]=$bed;
			}
		}
		return $beds;
	}
	
	function cBF($data)
	{
		$newShaId=$this->createShaCopy($data['CBF_studentIdFound']);//create sha copy
		
		$booking_from=normalToMysqlDate($data['CBF_bookingFrom']);
		if($data['CBF_bookingFrom']!='')
			$booking_to=normalToMysqlDate($data['CBF_bookingTo']);
		else
			$booking_to='0000-00-00';
		
		$cBData['host']=$data['CBF_hostIdFound'];
		$cBData['student']=$newShaId;
		$cBData['owner']='10';
		$cBData['booking_from']=$booking_from;
		$cBData['booking_to']=$booking_to;
		$cBData['room']=$data['CBF_room'];
		$cBData['status']='expected_arrival';
		$cBData['product']=$data['CBF_product'];
		
		$this->cB($cBData);//create booking
		
		//create initial invoice
		$invoiceData['shaChangeStatus_id']=$newShaId;
		$this->invoice_model->addPendingInvoice($invoiceData);
	}
	
	function changeHomestaySubmit($data)
	{
		$return=array();
		
		$newShaId=$this->createShaCopy($data['CHB_studentIdFound']);//create sha copy
		
		$booking_from=normalToMysqlDate($data['CHB_bookingFrom']);
		if($data['CHB_bookingTo']!='')
		{
			$booking_to=normalToMysqlDate($data['CHB_bookingTo']);
			$booking_to=date('Y-m-d',strtotime($booking_to.' - 1 day'));
		}
		else
			$booking_to='0000-00-00';
			
		$cBData['host']=$data['CHB_hfaIdFound'];
		$cBData['student']=$newShaId;
		$cBData['owner']='10';
		$cBData['booking_from']=$booking_from;
		$cBData['booking_to']=$booking_to;
		$cBData['room']=$data['CHB_hfaRoom'];
		$cBData['status']='expected_arrival';
		$cBData['product']=$data['CHB_product'];	
		
		$studentBookingDates['from']=$cBData['booking_from'];
		$studentBookingDates['to']=$cBData['booking_to'];	
		if($cBData['booking_to']=='0000-00-00')
			$studentBookingDates['to']='';
			
		if(checkIfBedBooked($cBData['room'],$cBData['product'],$studentBookingDates))
			$return['result']='notAvail';
		else
		{
			$sqlSha="update `sha_one` set `accomodation_type`=?, `arrival_date`=?, `booking_from`=?, `booking_to`=?, `status`=? where `id`=?";
			$this->db->query($sqlSha,array($cBData['product'],$cBData['booking_from'],$cBData['booking_from'],$cBData['booking_to'],'approved_without_payment',$cBData['student']));
			
			$sqlSha2="update `sha_two` set `airport_pickup`=?, `airport_arrival_date`=?, `airport_arrival_time`=?, `airport_carrier`=?, `airport_flightno`=?, `apu_company`=?,`airport_dropoff`=?, `airport_departure_date`=?, `airport_departure_time`=?, `airport_drop_carrier`=?, `airport_drop_flightno`=?,`apu_drop_company`=? where `id`=?";
			$this->db->query($sqlSha2,array('0','0000-00-00','00:00:00','','','','0','0000-00-00','00:00:00','','','',$cBData['student']));
			
			//caregiving details
			$shaOne=getShaOneAppDetails($cBData['student']);
			$age=age_from_dob($shaOne['dob']) ;
			if($age<18)
			{
				$query=$this->db->query("select * from `sha_two` where `id`='".$cBData['student']."'");
				$shaTwo=$query->row_array();
				if($shaTwo['guardianship']=='1')
				{
					if($shaTwo['guardianship_endDate']!='0000-00-00')
						$guardianship_endDate=$shaTwo['guardianship_endDate'];
					else
						$guardianship_endDate=date('Y-m-d',strtotime($shaOne['dob'].' + 18 years -1 day'));
					
					$this->db->query("update `sha_two` set `guardianship_startDate`='".$cBData['booking_from']."', `guardianship_endDate`='".$guardianship_endDate."' where `id`='".$cBData['student']."'");
				}
			}
			//caregiving details #ENDS
			
			$booking_id=$this->cB($cBData);//create booking
			$return['booking_id']=$booking_id;
			
			$getShaOneAppDetailsAfter=getShaOneAppDetails($cBData['student']);
			$client_id=$getShaOneAppDetailsAfter['client'];
			$clientDetail=clientDetail($client_id);
			if($clientDetail['group_invoice']=='0' && $getShaOneAppDetailsAfter['study_tour_id']==0)
			{				
					$this->load->model('invoice_model');
					if(isset($data['CHB_initial_invoice']))
					{
						//create initial invoice
						$invoiceData['shaChangeStatus_id']=$cBData['student'];
						$initialInvoiceId=$this->invoice_model->addPendingInvoice($invoiceData);
						$return['initial_invoice']='done-'.$initialInvoiceId;
					}
					else
					{
						//create ongoing invoice
						
						$ongoing_invoice_on=date('Y-m-d',strtotime($cBData['booking_from'].' - 2 weeks'));
						if(strtotime($ongoing_invoice_on) > strtotime(date('Y-m-d')))
						{
							$this->db->query("update `bookings` set `ongoing_invoice_on`='".$ongoing_invoice_on."' where `id`='".$booking_id."'");
							$return['ongoing_invoice']='future-'.date('d M Y',strtotime($ongoing_invoice_on));
						}
						else
						{	
						  $ongFrom=$cBData['booking_from'];
						  if($cBData['booking_to']=='0000-00-00')
							  $ongTo=date('Y-m-d',strtotime($ongFrom.' +4 weeks -1 day'));
						  else
							  {
								  $dayDiff=dayDiff($ongFrom,$cBData['booking_to']);
								  
								  if($dayDiff>28)
								  {
									  $ongTo=date('Y-m-d',strtotime($ongFrom.' +4 weeks -1 day'));
									  
									  if($dayDiff<35)
										  $ongTo=$cBData['booking_to'];
								  }
								  else	
									  $ongTo=$cBData['booking_to'];
							  }
							  
							  $items=ongInvItems($ongFrom,$ongTo,$cBData['student']);
							  if(!empty($items))
								  {
									  $ongoingInvoice['application_id']=$cBData['student'];
									  $ongoingInvoice['from']=$ongFrom;
									  $ongoingInvoice['to']=$ongTo;
									  $ongoingInvoice['items']=$items;
									  //see($ongoingInvoice);
									 $ongoingInvoiceId= $this->invoice_model->addNewOngoingInvoice($ongoingInvoice);
									  $return['ongoing_invoice']='done-'.$ongoingInvoiceId;
								  }
						}
					}
			}
			$return['result']='done';
		}
		return $return;
	}
	
	function posByBooking($id)
	{
		$sql="SELECT `purchase_orders`.*, `bookings`.`student`, `bookings`.`host`,`sha_one`.`fname` as `student_fname`,`sha_one`.`lname` as `student_lname`,`sha_one`.`email` as `student_email`,`sha_one`.`mobile` as `student_mobile`,`sha_one`.`study_tour_id` as `study_tour_id`,`hfa_one`.`fname` as `host_fname`,`hfa_one`.`lname` as `host_lname`,`hfa_one`.`email` as `host_email`,`hfa_one`.`street` as `host_street`,`hfa_one`.`suburb` as `host_suburb`,`hfa_one`.`postcode` as `host_postcode`,`hfa_one`.`state` as `host_state` FROM `purchase_orders` JOIN `bookings` ON(`purchase_orders`.`booking_id`=`bookings`.`id`) JOIN `sha_one` ON(`bookings`.`student`=`sha_one`.`id`) JOIN `hfa_one` ON(`bookings`.`host`=`hfa_one`.`id`) where `booking_id`='".$id."' order by `purchase_orders`.`from` DESC";
		$query=$this->db->query($sql);
		$pos=$query->result_array();
		return $pos;
	}
	
	function invoicesByBooking($id)
	{
		$invoicesInitial=array();
		$invoicesOngoing=array();
		$queryBooking=$this->db->query("select `student` from `bookings` where `id`='".$id."'");
		$booking=$queryBooking->row_array();
		
		if(!empty($booking))
		{
			$shaIds=getDuplicateShaSet($booking['student']);
			
		  //Initial
		  $sql="SELECT `invoice_initial`.* from `invoice_initial` where `application_id` IN (".implode(',',$shaIds).") order by `booking_from` DESC";
		  $query=$this->db->query($sql);
		  $invoicesInitial=$query->result_array();
		  
		  foreach($invoicesInitial as $iK=>$invoice)
		  {
				$sql_item="select * from `invoice_initial_items` where `invoice_id`='".$invoice['id']."'order by `id`";
				$queryItem=$query=$this->db->query($sql_item);
				$invoicesInitial[$iK]['items']=$queryItem->result_array();
		  }
		  
		  //Ongoing
		  $sql="SELECT `invoice_ongoing`.* from `invoice_ongoing` where `application_id` IN (".implode(',',$shaIds).") order by `booking_from` DESC";
		  $query=$this->db->query($sql);
		  $invoicesOngoing=$query->result_array();
		  
		  foreach($invoicesOngoing as $iK=>$invoice)
		  {
				$sql_item="select * from `invoice_ongoing_items` where `invoice_id`='".$invoice['id']."'order by `id`";
				$queryItem=$query=$this->db->query($sql_item);
				$invoicesOngoing[$iK]['items']=$queryItem->result_array();
		  }		  
		}
		
		$invoices['initial']=$invoicesInitial;
		$invoices['ongoing']=$invoicesOngoing;
		return $invoices;
	}
	
function changeHomestaySubmitCH($data)
{
		$return=array();
			
		//$newShaId=$this->createShaCopy($data['student']);//create sha copy
		
		$booking_from=normalToMysqlDate($data['placeBooking_startDate']);
		if($data['placeBooking_endDate']!='')
		{
			$booking_to=normalToMysqlDate($data['placeBooking_endDate']);
			$booking_to=date('Y-m-d',strtotime($booking_to.' - 1 day'));
		}
		else
			$booking_to='0000-00-00';
				
		  $cBData['host']=$data['host'];
		  //$cBData['student']=$newShaId;
		  $cBData['owner']=$data['owner'];
		  $cBData['booking_from']=$booking_from;
		  $cBData['booking_to']=$booking_to;
		  $cBData['room']=$data['placeBooking_bedroom'];
		  $cBData['status']='expected_arrival';
		  $cBData['product']=$data['accomodation_type'];
		  
		  $studentBookingDates['from']=$cBData['booking_from'];
		  $studentBookingDates['to']=$cBData['booking_to'];	
		  if($cBData['booking_to']=='0000-00-00')
			  $studentBookingDates['to']='';
		
		$bedAvailable=true;
		if(checkIfBedBooked($cBData['room'],$cBData['product'],$studentBookingDates))
		{
			if(checkIfBedEligibleForTripleShare($cBData['room'],$cBData['product'],$studentBookingDates))
				$bedAvailable=true;
			else
				$bedAvailable=false;	
		}
			
		//if(checkIfBedBooked($cBData['room'],$cBData['product'],$studentBookingDates))
		if(!$bedAvailable)
			$return['result']='notAvail';
		elseif(checkIfStudentBookedInDates($data['student'],$studentBookingDates))
			$return['result']='alreadyBooked';
		else
		{
			$newShaId=$this->createShaCopy($data['student']);//create sha copy
			$cBData['student']=$newShaId;
			
			$sqlSha="update `sha_one` set `accomodation_type`=?, `arrival_date`=?, `booking_from`=?, `booking_to`=?, `status`=? where `id`=?";
			$this->db->query($sqlSha,array($cBData['product'],$cBData['booking_from'],$cBData['booking_from'],$cBData['booking_to'],'approved_without_payment',$cBData['student']));
			
			$sqlSha2="update `sha_two` set `airport_pickup`=?, `airport_arrival_date`=?, `airport_arrival_time`=?, `airport_carrier`=?, `airport_flightno`=?, `apu_company`=?,`airport_dropoff`=?, `airport_departure_date`=?, `airport_departure_time`=?, `airport_drop_carrier`=?, `airport_drop_flightno`=?,`apu_drop_company`=? where `id`=?";
			$this->db->query($sqlSha2,array('0','0000-00-00','00:00:00','','','','0','0000-00-00','00:00:00','','','',$cBData['student']));
			
			//caregiving details
			$shaOne=getShaOneAppDetails($cBData['student']);
			$age=age_from_dob($shaOne['dob']) ;
			if($age<18)
			{
				$query=$this->db->query("select * from `sha_two` where `id`='".$cBData['student']."'");
				$shaTwo=$query->row_array();
				if($shaTwo['guardianship']=='1')
				{
					if($shaTwo['guardianship_endDate']!='0000-00-00')
						$guardianship_endDate=$shaTwo['guardianship_endDate'];
					else
						$guardianship_endDate=date('Y-m-d',strtotime($shaOne['dob'].' + 18 years -1 day'));
					
					$this->db->query("update `sha_two` set `guardianship_startDate`='".$cBData['booking_from']."', `guardianship_endDate`='".$guardianship_endDate."' where `id`='".$cBData['student']."'");
				}
			}
			//caregiving details #ENDS
			
			$booking_id=$this->cB($cBData);//create booking
			$return['booking_id']=$booking_id;
			
			$getShaOneAppDetailsAfter=getShaOneAppDetails($cBData['student']);
			$client_id=$getShaOneAppDetailsAfter['client'];
			$clientDetail=clientDetail($client_id);
			if($clientDetail['group_invoice']=='0' && $getShaOneAppDetailsAfter['study_tour_id']==0)
			{				
					$this->load->model('invoice_model');
					if(isset($data['CHB_initial_invoice']))
					{
						//create initial invoice
						$invoiceData['shaChangeStatus_id']=$cBData['student'];
						$initialInvoiceId=$this->invoice_model->addPendingInvoice($invoiceData);
						$return['initial_invoice']='done-'.$initialInvoiceId;
					}
					else
					{
						//create ongoing invoice
						
						$ongoing_invoice_on=date('Y-m-d',strtotime($cBData['booking_from'].' - 2 weeks'));
						if(strtotime($ongoing_invoice_on) > strtotime(date('Y-m-d')))
						{
							$this->db->query("update `bookings` set `ongoing_invoice_on`='".$ongoing_invoice_on."' where `id`='".$booking_id."'");
							$return['ongoing_invoice']='future-'.date('d M Y',strtotime($ongoing_invoice_on));
						}
						else
						{	
						  $ongFrom=$cBData['booking_from'];
						  if($cBData['booking_to']=='0000-00-00')
							  $ongTo=date('Y-m-d',strtotime($ongFrom.' +4 weeks -1 day'));
						  else
							  {
								  $dayDiff=dayDiff($ongFrom,$cBData['booking_to']);
								  
								  if($dayDiff>28)
								  {
									  $ongTo=date('Y-m-d',strtotime($ongFrom.' +4 weeks -1 day'));
									  
									  if($dayDiff<35)
										  $ongTo=$cBData['booking_to'];
								  }
								  else	
									  $ongTo=$cBData['booking_to'];
							  }
							  
							  $items=ongInvItems($ongFrom,$ongTo,$cBData['student']);
							  if(!empty($items))
								  {
									  $ongoingInvoice['application_id']=$cBData['student'];
									  $ongoingInvoice['from']=$ongFrom;
									  $ongoingInvoice['to']=$ongTo;
									  $ongoingInvoice['items']=$items;
									  //see($ongoingInvoice);
									 $ongoingInvoiceId= $this->invoice_model->addNewOngoingInvoice($ongoingInvoice);
									  $return['ongoing_invoice']='done-'.$ongoingInvoiceId;
								  }
						}
					}
			}
			$return['result']='done';
		}
		return $return;
}

function checkIfStudentBookedInDates($studentID,$bookingDates)
{
	$from=$bookingDates['from'];
	$to=$bookingDates['to'];
	if($to=='')//if To date is not entered then using a date that is far in future
		$to=date('Y-m-d',strtotime($from.' + 100 years'));
		
	$duplicateShaSet=getDuplicateShaSet($studentID);
	//see($duplicateShaSet);
	$shaSet="'".implode("','",$duplicateShaSet)."'";
	$sql="select * from `bookings` where   ";
	$sql .=" ( ";
		$sql .="('".$from."'>=`booking_from` and ('".$from."'<=`booking_to` OR '0000-00-00'=`booking_to`))  ";
		$sql .=" OR ('".$to."'>=`booking_from` and '".$to."'<=`booking_to`)  ";
		$sql .=" OR (`booking_from`>='".$from."' and `booking_from`<='".$to."')  ";
	$sql .=" ) ";
	$sql .=" AND `student` IN(".$shaSet.")";
	$query=$this->db->query($sql);
	//echo $this->db->last_query();
	//$res=$query->result_array();
	//see($res);
	if($query->row_array()>0)
		return true;
	else
		return false;	
}


function getBookingsByTourForChangeStatusWarnings($tourId,$booking_id)
{
	$bookingDetails=bookingDetails($booking_id);
	
	$sql="select `bookings`.*, `sha_one`.`fname` as `sha_fname`, `sha_one`.`lname` as `sha_lname`, `sha_one`.`duplicate`, `hfa_one`.`lname` as `hfa_lname` from `bookings` join `sha_one` ON (`bookings`.`student`=`sha_one`.`id`) join `hfa_one` ON(`bookings`.`host`=`hfa_one`.`id`) where `student` IN(select `id` from `sha_one` where `study_tour_id`='".$tourId."') and `bookings`.`id`!='".$booking_id."'";
	$query=$this->db->query($sql);//echo $this->db->last_query();
	
	return $query->result_array();
}
	
function addNewIncident($data)
{
	if($data['bookIncident_level']!='9')
		$data['bookIncident_levelOther']='';
	
	if($data['bookingIncident_id']!='')
	{
			$indicdentDate=normalToMysqlDate($data['bookIncident_date']);
			
			$sql="update `booking_incidents` set `employee`=?,`details`=?,`outcome`=?,`level`=?,`level_other`=?,`status`=?,`incident_date`=? where `id`=?";
			$this->db->query($sql,array($data['bookIncident_emp'],$data['bookIncident_details'],$data['bookIncident_outcome'],$data['bookIncident_level'],$data['bookIncident_levelOther'],$data['bookIncident_status'],$indicdentDate,$data['bookingIncident_id']));
			return $data['bookingIncident_id'];
	}
	else
	{
		$booking=bookingDetails($data['bookingIncident_bookingId']);
		if(!empty($booking))
		{
			$hfaId=$booking['host'];
			$shaId=$booking['student'];
			
			$indicdentDate=normalToMysqlDate($data['bookIncident_date']);
			
			$sql="insert into `booking_incidents` (`booking_id`,`hfa_id`,`sha_id`,`employee`,`details`,`outcome`,`level`,`level_other`,`status`,`incident_date`,`date`) values (?,?,?,?,?,?,?,?,?,?,?)";
			$this->db->query($sql,array($data['bookingIncident_bookingId'],$hfaId,$shaId,$data['bookIncident_emp'],$data['bookIncident_details'],$data['bookIncident_outcome'],$data['bookIncident_level'],$data['bookIncident_levelOther'],$data['bookIncident_status'],$indicdentDate,date('Y-m-d H:i:s')));
			return $this->db->insert_id();
		}
	}
}
		
function bookingIncidentDoc_upload($id,$file)
{
	$sql="insert into `booking_incidents_docs`  (`incident_id`,`name`,`date`) value(?,?,?)";
	$this->db->query($sql,array($id,$file,date('Y-m-d H:i:s')));
}
	
function addNewIncidentFollowUp($data)
{
	  $followUpDate=normalToMysqlDate($data['bookIncidentFollowUp_date']);
	  
	  $sql="insert into `booking_incidents_followups` (`incident_id`,`text`,`followup_date`,`date`) values (?,?,?,?)";
	  $this->db->query($sql,array($data['bookingIncident_Id'],$data['bookIncident_followUp'],$followUpDate,date('Y-m-d H:i:s')));
}

function incidentFollowUpUpdate($data)
{
	$this->db->query("update `booking_incidents_followups` set `text`=? where `id`=?",array($data['followUpText'],$data['followUpId']));
	return $this->db->query("select * from `booking_incidents_followups` where `id`=?",$data['followUpId'])->row_array();
}

function incidentsByBooking($id)
{
	return $this->db->query("select * from `booking_incidents` where `booking_id`='".$id."' order by `incident_date` DESC, `id` DESC")->result_array();
}

function incidentFollowUps($id)
{
	return $this->db->query("select * from `booking_incidents_followups` where `incident_id`='".$id."' order by `followup_date` DESC, `id` DESC")->result_array();
}

function incidentDocs($id)
{
	return $this->db->query("select * from `booking_incidents_docs` where `incident_id`='".$id."' order by `date` DESC")->result_array();
}

function bookingIncident_delete($id)
{
	$this->db->query("delete from `booking_incidents` where `id`='".$id."'");
	$this->db->query("delete from `booking_incidents_followups` where `incident_id`='".$id."'");
	
	$docs=$this->db->query("select * from `booking_incidents_docs` where `incident_id`=?",array($id))->result_array();
	foreach($docs as $doc)
	{
		unlink('static/uploads/bookingIncidentDoc/'.$doc['name']);
		$this->db->query("delete from `booking_incidents_docs` where `id`='".$doc['id']."'");
	}
}

function deleteBookingIncidentDoc($id)
{
	$bookingId='0';
	$sql="select * from `booking_incidents_docs` where `id`='".$id."'";
	$query=$this->db->query($sql);
	$row=$query->row_array();
	if(!empty($row))
	{
		$incident=$this->db->query("select * from `booking_incidents` where `id`='".$row['incident_id']."'")->row_array();
		unlink('static/uploads/bookingIncidentDoc/'.$row['name']);
		$sqlDel="delete from `booking_incidents_docs` where `id`='".$id."'";
		$this->db->query($sqlDel);
		$bookingId=$incident['booking_id'];
	}
	return $bookingId;
}

function bookingIncident_details($id)
{
	return $this->db->query("select * from `booking_incidents` where `id`='".$id."'")->row_array();
}

function feedbacksByBooking($id)
{
	return $this->db->query("select * from `booking_feedbacks` where `booking`='".$id."' order by `date` DESC")->result_array();
}

function bookingFeedback_delete($id)
{
	$this->db->query("delete from `booking_feedbacks` where `id`='".$id."'");
}

function feedbackDetails($id)
{
	return $this->db->query("select * from `booking_feedbacks` where `id`='".$id."'")->row_array();
}

function checkupsByBooking($id)
{
	return $this->db->query("select * from `booking_checkups` where `booking`='".$id."' order by `checkup_date` DESC, `id` DESC")->result_array();
}
	
function addNewCheckup($data)
{	
	$bookCheckup_notes='';
	if(isset($data['bookCheckup_notes']))
		$bookCheckup_notes=$data['bookCheckup_notes'];
	
	if(isset($data['bookingCheckup_id']))
	{
		$checkup=$this->bookingCheckup_details($data['bookingCheckup_id']);
		if(!empty($checkup))
		{
			
			$checkupDate=normalToMysqlDate($data['bookCheckup_date']);
			
			$sql="update `booking_checkups` set `employee`=?,`checkup_date`=?,`method`=?,`notes`=? where `id`=?";
			$this->db->query($sql,array($data['bookCheckup_emp'],$checkupDate,$data['bookCheckup_method'],$bookCheckup_notes,$data['bookingCheckup_id']));
		}
	}
	else
	{
			$checkupDate=normalToMysqlDate($data['bookCheckup_date']);
			
			$sql="INSERT INTO `booking_checkups`(`booking`, `type`, `employee`, `checkup_date`, `method`, `notes`, `date`) VALUES (?,?,?,?,?,?,?)";
			$this->db->query($sql,array($data['bookingCheckup_bookingId'],$data['bookingCheckup_type'],$data['bookCheckup_emp'],$checkupDate,$data['bookCheckup_method'],$bookCheckup_notes,date('Y-m-d H:i:s')));
	}
}

function bookingCheckup_details($id)
{
	return $this->db->query("select * from `booking_checkups` where `id`='".$id."'")->row_array();
}

function getArrivalCheckupInfoByBookingId($id)
{
	return $this->db->query("select * from `booking_checkups` where `booking`='".$id."' and `type`='1'")->row_array();
}

function bookingCheckup_delete($id)
{
	$this->db->query("delete from `booking_checkups` where `id`='".$id."'");
}

function addNewHolidayValidation($data)
{
	$return['fromDate']='ok';
	$return['toDate']='ok';
	$startDate=strtotime(normalToMysqlDate($data['bookHoliday_startDate']));
	$endDate=strtotime(normalToMysqlDate($data['bookHoliday_endDate']).' -1 day');
	if($startDate>$endDate)
		$return['toDate']='wrong';
	else
	{
		$booking=bookingDetails($data['bookingHoliday_bookingId']);
		if(!empty($booking))
		{
			$bookingFrom=strtotime($booking['booking_from']);
			$bookingTo=strtotime($booking['booking_to']);
			
			if(($startDate>=$bookingFrom) && (($bookingTo!=strtotime('0000-00-00') && $startDate<=$bookingTo) || ($bookingTo==strtotime('0000-00-00'))))
				{}
			else
				$return['fromDate']='datesNotInBooking';
			
			if(($endDate>=$bookingFrom) && (($bookingTo!=strtotime('0000-00-00') && $endDate<=$bookingTo) || ($bookingTo==strtotime('0000-00-00'))))
				{}
			else
				$return['toDate']='datesNotInBooking';
				
			if($return['fromDate']=='ok' && $return['toDate']=='ok')
			{
				$valid=$this->addNewHolidayValidationPrevHolidays($data);
				if(!$valid)
					$return['fromDate']='dateOverlaping';
			}
		}
	}
	return $return;
}

function addNewHolidayValidationPrevHolidays($data)
{
	$startDate=normalToMysqlDate($data['bookHoliday_startDate']);
	$endDate=normalToMysqlDate($data['bookHoliday_endDate']);
	
	$sql="select * from `booking_holidays` where `booking_id`='".$data['bookingHoliday_bookingId']."' and ";
	$sql .="(";
	$sql .="  ((`start`<='".$startDate."' && `end`>='".$startDate."') OR (`start`<='".$endDate."' && `end`>='".$endDate."')) OR";//4
	$sql .="  (('".$startDate."'<=`start` && '".$endDate."'>=`start`) OR ('".$startDate."'<=`end` && '".$endDate."'>=`end`))";//4
	$sql .=")";
	
	//$sql .="`end`>='".$startDate."'";
	
	if(isset($data['bookingHoliday_id']))
		$sql .=" and `id`!='".$data['bookingHoliday_id']."'";
	$query=$this->db->query($sql);//echo $this->db->last_query();
	$return=true;
	if($query->num_rows()>0)
		$return=false;
	return $return;	
}

function addNewHoliday($data)
{
	$return=$this->addNewHolidayValidation($data);
	if($return['fromDate']!='ok' || $return['toDate']!='ok')
		$return['result']='error';
	else
	{
			if(isset($data['bookingHoliday_id']))
			{
				$holiday=$this->bookingHoliday_details($data['bookingHoliday_id']);
				if(!empty($holiday))
				{
					$startDate=normalToMysqlDate($data['bookHoliday_startDate']);
					$endDate=normalToMysqlDate($data['bookHoliday_endDate']);
					
					$sql="update `booking_holidays` set `employee`=?,`start`=?,`end`=?,`notes`=? where `id`=?";
					$this->db->query($sql,array($data['bookHoliday_emp'],$startDate,$endDate,$data['bookHoliday_notes'],$data['bookingHoliday_id']));
					
			    	$data['holiday_id']=$data['bookingHoliday_id'];
					//$this->updateDiscountForHolidayInPo($data);
					$this->load->model('holiday_model');
					$this->holiday_model->deleteHolidayProcess($data['bookingHoliday_id']);
					$this->holiday_model->addHolidayDiscountPO($data['bookingHoliday_bookingId']);
					
					$this->updateDiscountForHolidayInInvoice($data);
				}
			}
			else
			{
				$booking=bookingDetails($data['bookingHoliday_bookingId']);
				if(!empty($booking))
				{
					$shaId=$booking['student'];
					
					$startDate=normalToMysqlDate($data['bookHoliday_startDate']);
					$endDate=normalToMysqlDate($data['bookHoliday_endDate']);
					
					$sql="insert into `booking_holidays` (`booking_id`,`student`,`employee`,`start`,`end`,`notes`,`date`) values (?,?,?,?,?,?,?)";
					$this->db->query($sql,array($data['bookingHoliday_bookingId'],$shaId,$data['bookHoliday_emp'],$startDate,$endDate,$data['bookHoliday_notes'],date('Y-m-d H:i:s')));
					
					//$data['holiday_id']=$this->db->insert_id();
					//$this->addDiscountForHolidayInPo($data);
					$this->load->model('holiday_model');
					$this->holiday_model->addHolidayDiscountPO($data['bookingHoliday_bookingId']);
					$this->addDiscountForHolidayInInvoice($data);
				}
			}
			$return['result']='done';
	}
	return $return;

}

function holidaysByBooking($id)
{
	return $this->db->query("select * from `booking_holidays` where `booking_id`='".$id."' order by `date` DESC")->result_array();
}

function bookingHoliday_delete($id)
{
	$holiday=$this->db->query("select * from `booking_holidays` where `id`=?",array($id))->row_array();
	if(!empty($holiday))
	{
	    //$this->db->query("delete from `purchase_orders_items` where `po_id`=? and `id`=? and `type`=?",array($holiday['po_id'],$holiday['po_item_id'],'holidayDiscount'));
		//$this->db->query("delete from `purchase_orders_items` where `po_id`=? and `type`=?",array($holiday['po_id'],'holidayAdminFeeDiscount'));
		$this->db->query("delete from `invoice_ongoing_items` where `invoice_id`=? and `id`=? and `type`=?",array($holiday['invoice_id'],$holiday['invoice_item_id'],'holidayDiscount'));
	    $this->db->query("delete from `booking_holidays` where `id`='".$id."'");
		
		$this->load->model('holiday_model');
		$this->holiday_model->deleteHolidayProcess($id);
	}
}

function bookingHoliday_details($id)
{
	return $this->db->query("select * from `booking_holidays` where `id`='".$id."'")->row_array();
}

function addDiscountForHolidayInPo($data)
{
	$startDate=normalToMysqlDate($data['bookHoliday_startDate']);
	$endDate=normalToMysqlDate($data['bookHoliday_endDate']);
	
	$holiday=$this->db->query("select * from `booking_holidays` where `booking_id`=? and `start`=? and `end`=?",array($data['bookingHoliday_bookingId'], $startDate,$endDate))->row_array();
	if(!empty($holiday))
	{
		$po=$this->db->query("select * from `purchase_orders` where `booking_id`=? and `from`<=? and `to`>=? and `moved_to_xero`=?", array($data['bookingHoliday_bookingId'],$startDate,$startDate,'0'))->row_array();
		if(empty($po))
		{
			if(!isset($data['bookingHoliday_poId']))
				$data['bookingHoliday_poId']=0;
			$po=$this->db->query("select * from `purchase_orders` where `booking_id`=? and (`from`>? OR `id`=?) and `moved_to_xero`=?", array($data['bookingHoliday_bookingId'],$startDate,$data['bookingHoliday_poId'],'0'))->row_array();	
		}
		if(!empty($po))
		{
			$poDetails=poDetails($po['id']);
			
			$itemDiscount=$this->getItemsForHolidayDiscount('po',$poDetails,$holiday);
			if(!empty($itemDiscount))
			{
				$this->db->query("insert into `purchase_orders_items` (`po_id`,`desc`, `unit`, `qty_unit`, `qty`, `total`, `gst`, `xero_code`, `type`, `date`) values (?,?,?,?,?,?,?,?,?,?)",$itemDiscount);
				$itemId=$this->db->insert_id();
				$this->db->query("update `booking_holidays` set `po_id`=?, `po_item_id`=? where `id`=?", array($po['id'],$itemId,$holiday['id']));
			}
			$this->addHolidayAdminFeePo($po['id']);
		}
	}
}

function updateDiscountForHolidayInPo($data)
    {
        $itemDiscount['po_id']=$data['bookingHoliday_poId'];
		$itemDiscount['po_item_id']=$data['bookingHoliday_poItemId'];
		$itemDiscount['type']='holidayDiscount';
		
		if($itemDiscount['po_id']!=0)
    		$this->db->query("delete from `purchase_orders_items` where `po_id`=? and `id`=? and `type`=?",$itemDiscount);
            
		$this->addDiscountForHolidayInPo($data);
    }

function addDiscountForHolidayInInvoice($data)
{
	$startDate=normalToMysqlDate($data['bookHoliday_startDate']);
	$endDate=normalToMysqlDate($data['bookHoliday_endDate']);
	
	$holiday=$this->db->query("select * from `booking_holidays` where `booking_id`=? and `start`=? and `end`=?",array($data['bookingHoliday_bookingId'], $startDate,$endDate))->row_array();
	if(!empty($holiday))
	{
		$student=getshaOneAppDetails($holiday['student']);
		$groupInvClient=groupInvClient($student['client']);
		if(!$groupInvClient)
		{
			$inv=$this->db->query("select * from `invoice_ongoing` where `application_id`=? and `booking_from`<=? and `booking_to`>=? and `moved_to_xero`=?", array($holiday['student'],$startDate,$startDate,'0'))->row_array();
			if(empty($inv))//in case if invoice in current month is not found then we find invoice that is in the next month
			{
				if(!isset($data['bookingHoliday_invoiceId']))
					$data['bookingHoliday_invoiceId']=0;
				$inv=$this->db->query("select * from `invoice_ongoing` where `application_id`=? and (`booking_from`>? OR `id`=?)  and `moved_to_xero`=?", array($holiday['student'],$startDate,$data['bookingHoliday_invoiceId'],'0'))->row_array();
			}
			if(!empty($inv))
			{
				$invDetails=ongoingInvoiceDetails($inv['id']);
				
				$itemDiscount=$this->getItemsForHolidayDiscount('invoice',$invDetails,$holiday);
				if(!empty($itemDiscount))
				{
					$this->db->query("insert into `invoice_ongoing_items` (`invoice_id`,`desc`, `unit`, `qty_unit`, `qty`, `total`, `gst`, `xero_code`, `type`, `date`) values (?,?,?,?,?,?,?,?,?,?)",$itemDiscount);
					$itemId=$this->db->insert_id();
					$this->db->query("update `booking_holidays` set `invoice_id`=?, `invoice_item_id`=? where `id`=?", array($invDetails['id'],$itemId,$holiday['id']));
				}
			}
		}
	}
}

function updateDiscountForHolidayInInvoice($data)
    {
        $itemDiscount['invoice_id']=$data['bookingHoliday_invoiceId'];
		$itemDiscount['invoice_item_id']=$data['bookingHoliday_invoiceItemId'];
		$itemDiscount['type']='holidayDiscount';
		
		if($itemDiscount['invoice_id']!=0)
    		$this->db->query("delete from `invoice_ongoing_items` where `invoice_id`=? and `id`=? and `type`=?",$itemDiscount);
            
		$this->addDiscountForHolidayInInvoice($data);
    }
	
	
	function getItemsForHolidayDiscount($invPo,$invPoDetails,$holiday)
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
	
	function addBookingService($data)
	{
		$owner=10;
		$startDate=normalToMysqlDate($data['placeBooking_startDate']);
		$endDate=date('Y-m-d',strtotime(normalToMysqlDate($data['placeBooking_endDate']).' - 1 day'));// to make the last day move out day
		$date=date('Y-m-d H:i:s');
		
		$sql="insert into `bookings` (`student`,`owner`,`booking_from`,`booking_to`,`date_added`,`generate_po`,`serviceOnlyBooking`)values(?,?,?,?,?,?,?)";
		$this->db->query($sql,array($data['student'],$owner,$startDate,$endDate,$date,'0','1'));
		$booking_id=$this->db->insert_id();
		echo $booking_id;
	}
	
	function addHolidayAdminFeePo($po_id)
	{
		$poDetails=poDetails($po_id);
		$holidayQty=0;
		foreach($poDetails['items'] as $poItems)
		{
			if($poItems['type']=='holidayDiscount')
				$holidayQty +=$poItems['qty'];
		}
		
		$itemType='holidayAdminFeeDiscount';
		$this->db->query("delete from `purchase_orders_items` where `po_id`=? and `type`=?",array($po_id,$itemType));
		if($holidayQty>0)
		{
				$unit='1';
				
				$bookingDetails=bookingDetails($poDetails['booking_id']);
				$student=getshaOneAppDetails($bookingDetails['student']);
				$studentNo='';
				if($student['sha_student_no']!='')
					$studentNo=' - '.$student['sha_student_no'];
				$bookingInfoForItems=$poDetails['booking_id'].', '.$student['fname'].' '.$student['lname'].$studentNo.', ';
				$desc=$bookingInfoForItems.'Administration Fee discount for holidays ($1 per day)';
				
				$itemDiscount['po_id']=$po_id;	
				$itemDiscount['desc']=$desc;
				$itemDiscount['unit']=$unit;
				$itemDiscount['qty_unit']='2';//day
				$itemDiscount['qty']=$holidayQty;
				$itemDiscount['total']=$unit*$holidayQty;
				$itemDiscount['gst']='0';
				$itemDiscount['xero_code']='52100';
				$itemDiscount['type']=$itemType;
				$itemDiscount['date']=date('Y-m-d H:i:s');
				$this->db->query("insert into `purchase_orders_items` (`po_id`,`desc`, `unit`, `qty_unit`, `qty`, `total`, `gst`, `xero_code`, `type`, `date`) values (?,?,?,?,?,?,?,?,?,?)",$itemDiscount);
		}
	}
	
	function CGDocSent_submit($data)
	{
		    $this->db->query("update `bookings` set `cgDocSent`='".date('Y-m-d H:i:s')."',`cgDocSentBy`='".$data['bookCGDocSent_emp']."' where `id`='".$data['bookCGDocSent_bookingId']."'");
	}

	function CGDocSent_unsend($data)
	{
		if(userAuthorisations('bookingCGDocSent_unsend'))
			$this->db->query("update `bookings` set `cgDocSent`='0000-00-00 00:00:00',`cgDocSentBy`='0' where `id`='".$data['booking_id']."'");
	}
	
	function CGDocRec_submit($data)
	{
		$this->db->query("update `bookings` set `cgDocRec`='".date('Y-m-d H:i:s')."' where `id`='".$data['bookCGDocRec_bookingId']."'");
		foreach($data['bookCGDocRec_images'] as $doc)
				{
					$imagename=$doc;		
					$this->db->query("insert into `booking_cgDocs` (`booking_id`,`name`,`date`) values(?,?,?)",array($data['bookCGDocRec_bookingId'],$doc,date('Y-m-d H:i:s')));
				}
	}
	
	function cgDocList($id)
	{
		return $this->db->query("select * from  `booking_cgDocs` where `booking_id`=?",array($id))->result_array();
	}
	
	function deleteBookingCGDoc($data)
	{
		$doc=$this->db->query("select * from `booking_cgDocs` where `id`=?",array($data['id']))->row_array();
		if(!empty($doc))
		{
			$this->db->query("delete from `booking_cgDocs` where `id`=?",array($data['id']));
			unlink('static/uploads/bookingCGDoc/'.$doc['name']);
		}
	}	
	
	function checkIfBedEligibleForTripleShare($bed,$studentAcc,$dates)
	{
		$return=false;
		if($this->db->query("select * from `hfa_bedrooms` where `id`='".$bed."' and `type` IN('2','3')")->num_rows()>0)
		{
			$sql="select * from `bookings` where `room`='".$bed."' and `status`!='cancelled'";
			$sql .=checkIfBedBookedExtraSql($dates);
			
			$query=$this->db->query($sql);//echo $this->db->last_query();
			if($query->num_rows()==2)
				$return=true;
		}
		return $return;	
	}
	
	function updateTransportInfo($data)
	{
		$this->db->query("update `bookings` set `transportInfo`=? where `id`=?",array($data['transportInfo'],$data['booking_id']));//echo $this->db->last_query();
	}
	
	function paymentHoldSubmit($data)
	{
		$date=date('Y-m-d H:i:s');
		$this->db->query("update `bookings` set `hold_payment`='1' where `id`=?",$data['bookingHoldPos_booking_id']);
		$this->db->query("insert into `bookings_hold_payment_history` (`booking_id`,`employee`,`reason`,`date`)values(?,?,?,?)",array($data['bookingHoldPos_booking_id'],$data['bookingHoldPos_emp'],$data['bookingHoldPos_reason'],$date));
	}
	
	function booking_unholdPayments($bid,$holdId)
	{
		$date=date('Y-m-d H:i:s');
		$this->db->query("update `bookings` set `hold_payment`='0' where `id`=?",$bid);
		$this->db->query("update `bookings_hold_payment_history` set `unhold_on`=? where `id`=?",array($date,$holdId));
	}
	
	function getBookingHoldPaymentHistory($bid,$type)
	{
		if($type=='held')
			return $this->db->query("select * from `bookings_hold_payment_history` where `booking_id`=? and `unhold_on`='0000-00-00 00:00:00'",$bid)->row_array();
		else
			return $this->db->query("select * from `bookings_hold_payment_history` where `booking_id`=? and `unhold_on`!='0000-00-00 00:00:00' order by `date` DESC",$bid)->result_array();
	}
	
	function bookingHoldPayment_delete($holdId)
	{
		$this->db->query("delete from `bookings_hold_payment_history` where `id`=?",$holdId);
	}
}
