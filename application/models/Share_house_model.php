<?php

class Share_house_model extends CI_Model {

	function applicationsList($status)
	{

		$sql="Select * from `share_houses` ";

		if($status!='all')
		$sql .="where `status` = ?";

		$sort=" `created` DESC";
		$sql .=" order by ".$sort;
		$query	=	$this->db->query($sql,$status);
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function changeStatus($data)
	{
		$sql="UPDATE `share_houses` set `status`='".$data['houseChangeStatus_status']."', `status_update_date`='".date('Y-m-d H:i:s')."' ";
		if($data['houseChangeStatus_status']=='share_house_rejected' || $data['houseChangeStatus_status']=='share_house_finalized') {
				$sql .=", `status_update_reason`='".trim($data['status_update_reason'])."'";
		}
		$sql .=" WHERE `id`='".$data['id']."'";
		$this->db->query($sql);
		//echo $this->db->last_query();
	}
	function update_share_house($data)
	{
		$data['arrival_date']=normalToMysqlDate($data['arrival_date']);
		$sql="UPDATE `share_houses` set `first_name`=?, `last_name`=?,`mobile`=?, `gender`=?, `email`=?, `nationality`=?, `arrival_date`=?, `arrival_time`=?, `flight_no`=?, `college_name`=?, `college_address`=?, `service_type`=?, `created`=? WHERE `id`=?";
		$this->db->query($sql,array($data['first_name'],$data['last_name'],$data['mobile'],$data['gender'],$data['email'],$data['nationality'],$data['arrival_date'],$data['arrival_time'],$data['flight_no'],$data['college_name'],$data['college_address'],$data['service_type'],date('Y-m-d H:i:s'),$data['id']));
	}
	function deleteApplication($id)
	{
		$sql_delete="DELETE from `share_houses` where `id`='".$id."'";
		$this->db->query($sql_delete);
	}

	function getShaTwoAppDetailsLanguage($id)
	{
		$sql="select * from `sha_language` where `application_id`='".$id."' order by `id`";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	function application_edit_one_submit($data)
	{
		if($data['sha_passport_expiry']!='')
					$data['sha_passport_expiry']=normalToMysqlDate($data['sha_passport_expiry']);
		if($data['sha_arrival_date']!='')
					$data['sha_arrival_date']=normalToMysqlDate($data['sha_arrival_date']);

		if($data['sha_accomodation']!=2)
			$data['sha_name2']='';

		$sql="update `sha_one` set `title`=?, `fname`=?, `mname`=?, `lname`=?, `gender`=?, `email`=?, `mobile`=?, `home_phone`=?, `accomodation_type`=?, `student_name2`=?, `nation`=?, `passport_no`=?, `passport_exp`=?, `arrival_date`=? where `id`=?";
		$this->db->query($sql,array($data['sha_name_title'],$data['sha_fname'],$data['sha_mname'],$data['sha_lname'],$data['sha_gender'],$data['sha_email'],$data['sha_mobile'],$data['sha_home_phone'],$data['sha_accomodation'],$data['sha_name2'],$data['sha_nationality'],$data['sha_passport'],$data['sha_passport_expiry'],$data['sha_arrival_date'],$data['id']));
	}

	function insert_share_house($data)
	{
		$data['arrival_date']=normalToMysqlDate($data['arrival_date']);
		//$data['arrival_date_time']=date('Y-m-d H:i:s',strtotime($data['arrival_date_time']));

		$sql="INSERT INTO `share_houses`(`first_name`, `last_name`, `mobile`, `gender`, `email`, `nationality`, `arrival_date`,`arrival_time`, `flight_no`, `college_name`,`college_address`, `service_type`, `status`, `created`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		//echo "<pre>";
		//print_r($data);
		$query=$this->db->query($sql,array($data['first_name'],$data['last_name'],$data['mobile'],$data['gender'],$data['email'],$data['nationality'],$data['arrival_date'],$data['arrival_time'],$data['flight_no'],$data['college_name'],$data['college_address'],$data['service_type'],'share_house_new',date('Y-m-d H:i:s')));
		return $this->db->insert_id();
	}
	
	

	function officeUseChangeAttrFormSubmit($data)
	{
		$sql="update `sha_one` set `employee`=? where `id`=?";
		$this->db->query($sql,array($data['employee'],$data['id']));
		//Uecho $this->db->last_query();
	}

	function officeUseChangeAttrFormSubmit_changeClient($data)
	{
		$sql="update `sha_one` set `client`=? where `id`=?";
		$this->db->query($sql,array($data['client'],$data['id']));
		//Uecho $this->db->last_query();
	}

////////////// For data table server side STARTS

	var $table = 'share_houses';
	var $column_order = array('first_name','service_type','created','status','status_update_date'); //set column field database for datatable orderable
	var $column_search = array('first_name','last_name','email','mobile','status'); //set column field database for datatable searchable
	var $order = array('created' => 'desc'); // default order

	private function _get_datatables_query()
	{

		$this->order=array('created'=>'desc');

		$this->db->from($this->table);
		if(isset($_POST['house_status_page'])) {
			if($_POST['house_status_page']=='share_house_all') {
				$this->db->where('1', 1);
			}
			else {
				$this->db->where('status', $_POST['house_status_page']);	
			}
		}

			
		/*
		if($_POST['sha_status_page']!='all')
			$this->db->where('status', $_POST['sha_status_page']);

		if($_POST['appStep']!='')
		{
			if($_POST['appStep']=='partial')
				$this->db->where('step !=', 4, FALSE);
			else
				$this->db->where('step',4);
		}

		if($_POST['placement']!='' && $_POST['placement']!='both')
		{
			$sql="select `student` from `bookings` where `status` IN('expected_arrival','on_hold','arrived','progressive')";

			$query=$this->db->query($sql);
			$placement_res=$query->result_array();
			$placement=array();
			foreach($placement_res as $plmnt)
				$placement[]=$plmnt['student'];

			if($_POST['placement']=='placed')
				$this->db->where_in('id',$placement);
			elseif($_POST['placement']=='not_placed')
				$this->db->where_not_in('id',$placement);
		}
		*/
		$i = 0;

		foreach ($this->column_search as $item) // loop column
		{
			if(isset($_POST['search']['value'])) // if datatable send POST for search
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

		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}
	function getshareHouseDetail($id)
	{
		$sql="select * from `share_houses` where `id`='".$id."'";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	function get_datatables()
	{
		$this->_get_datatables_query();
		if(isset($_POST['length']) &&  $_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
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
		if($_POST['house_status_page']!='all')
			$this->db->where('status', $_POST['house_status_page']);

		return $this->db->count_all_results();
	}

	////////////// For data table server side ENDS


	function bookingDatesSubmit($data)
	{
		$sql="update `sha_one` set `booking_from`='".normalToMysqlDate($data['shaBooking_startDate'])."', `booking_to`='".normalToMysqlDate($data['shaBooking_endDate'])."' where `id`='".$data['id']."'";
		$this->db->query($sql);
	}

	function homestayNominationSubmit($data)
	{
		$sql="update `sha_one` set `homestay_nomination`='".$data['homestayNomination']."' where `id`='".$data['id']."'";
		$this->db->query($sql);
	}
	function notesSubmit($data)
	{
		$sql="update `sha_one` set `special_request_notes`='".$data['special_request_notes']."' where `id`='".$data['id']."'";
		$this->db->query($sql);
	}
}
