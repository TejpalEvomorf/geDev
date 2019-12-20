<?php

class Sha_model extends CI_Model {

	function applicationsList($status)
	{

		$sql="Select * from `sha_one` ";

		if($status!='all')
		$sql .="where `status` = ?";

		$sort=" `date` DESC";
		$sql .=" order by ".$sort;
		$query	=	$this->db->query($sql,$status);
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getStudentsByMissingBookingDate($tour_id)
	{
		$sql="Select * from `sha_one` where `study_tour_id` = ? AND `booking_from`='0000-00-00' AND `booking_to` ='0000-00-00' AND `status`!='cancelled'";
		$sort=" `date` DESC";
		$sql .=" order by ".$sort;
		$query	=	$this->db->query($sql,$tour_id);
		return $query->result_array();
	}
	function getStudentsByTourId($tour_id)
	{

		$sql="Select * from `sha_one` where `study_tour_id` = ?";
		$sort=" `date` DESC";
		$sql .=" order by ".$sort;
		$query	=	$this->db->query($sql,$tour_id);
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getPlacedStudentsByTourId($tour_id)
	{

		$sql="SELECT sha_one.* from `sha_one` JOIN `bookings` ON sha_one.id = bookings.student WHERE sha_one.study_tour_id=? AND bookings.status <> 'cancelled' AND bookings.status <> 'moved_out' AND sha_one.status <> 'cancelled'";

		$sort=" `date` DESC";
		$sql .=" order by ".$sort;
		$query	=	$this->db->query($sql,$tour_id);
		//echo $this->db->last_query();
		return $query->result_array();
	}
	function getPendingStudentsByTourId($tour_id)
	{

		$sql="SELECT sha_one.* FROM `sha_one`
  WHERE NOT EXISTS (SELECT student FROM bookings WHERE sha_one.id = bookings.student) AND sha_one.study_tour_id=? AND sha_one.status <> 'cancelled'";
		$sort=" `date` DESC";
		$sql .=" order by ".$sort;
		$query	=	$this->db->query($sql,$tour_id);
		//echo $this->db->last_query();
		return $query->result_array();
	}
	
	function getStudentsByTourIdForInvoice($tour_id)
	{
		$sql="SELECT sha_one.* FROM `sha_one` WHERE  `sha_one`.`study_tour_id`=? and `sha_one`.`status` <> 'cancelled'";
		$sort=" `date` DESC";
		$sql .=" order by ".$sort;
		$query	=	$this->db->query($sql,$tour_id);
		//echo $this->db->last_query();
		return $query->result_array();
	}

	function changeStatus($data)
	{
		if($data['shaChangeStatus_status']=='cancelled')
		{
			if($data['shaChangeStatus_date']!='')
				$date_cancelled=normalToMysqlDate($data['shaChangeStatus_date']);
			else
				$date_cancelled=date('Y-m-d');
		}
		
		$reason='';
		$sql="update `sha_one` set `status`='".$data['shaChangeStatus_status']."', `date_status_changed`='".date('Y-m-d H:i:s')."' ";
		if($data['shaChangeStatus_status']!='rejected')
		{
			if($data['shaChangeStatus_status']!='new')
			{
				$sql .=", `client`='".$data['shaChangeStatus_client']."',  `employee`='".$data['shaChangeStatus_employee']."'";

				if($data['shaChangeStatus_status']=='cancelled')
				{
					$reason=trim($data['hfaChangeStatus_reason']);
					$sql .=", `reason`=? ,`date_cancelled`='".$date_cancelled."'";
				}
				else
				{
					$reason='';
					$sql .=", `reason`=?";
				}
			}
			else
			{
				$reason='';
				$sql .=", `client`=0,  `employee`=0, `reason`=?";
			}
		}
		else
		{
			$reason=trim($data['hfaChangeStatus_reason']);
			$sql .=", `reason`=?";
			$sql .=", `client`=0,  `employee`=0";
		}

		$sql .=" where `id`='".$data['shaChangeStatus_id']."'";

		$this->db->query($sql,array($reason));
		//echo $this->db->last_query();

		//change the status of booking to cancelled if student placed and then application is cancelled
		if($data['shaChangeStatus_status']=='cancelled' && !isset($data['study_tour_id']))
		{
			//Adding to cancelled invoices table
			sha_cancellationDataProcess($data['shaChangeStatus_id']);

			$checkIfStudentPlaced=checkIfStudentPlaced($data['shaChangeStatus_id']);
			if($checkIfStudentPlaced)
			{
				$sqlBooking="update `bookings` set `status`='cancelled' , `date_cancelled`='".$date_cancelled."' , `comments`=? where `student`='".$data['shaChangeStatus_id']."'";
				$this->db->query($sqlBooking,array(trim($data['hfaChangeStatus_reason'])));
			}
		}
	}

	function deleteApplication($id)
	{
		$sql_exiting_booking="select 1 from `bookings` where `student`='".$id."'";
		$query_exist_booking=$this->db->query($sql_exiting_booking);
		if($query_exist_booking->num_rows()==0) {
			$sql="delete from `sha_one` where `id`='".$id."'";
			$this->db->query($sql);
			$sql="delete from `sha_two` where `id`='".$id."'";
			$this->db->query($sql);
			$sql="delete from `sha_three` where `id`='".$id."'";
			$this->db->query($sql);
			$sql="delete from `sha_language` where `application_id`='".$id."'";
			$this->db->query($sql);
			$sql="delete from `warnings_study_tours` where `sha_one_id`='".$id."'";
			$this->db->query($sql);
		}
	}

	function getShaTwoAppDetailsLanguage($id)
	{
		$sql="select * from `sha_language` where `application_id`='".$id."' order by `id`";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	function application_edit_one_submit($data)
	{
		if($data['sha_dob']!='')
					$data['sha_dob']=normalToMysqlDate($data['sha_dob']);
		if($data['sha_passport_expiry']!='')
					$data['sha_passport_expiry']=normalToMysqlDate($data['sha_passport_expiry']);
		if($data['sha_arrival_date']!='')
					$data['sha_arrival_date']=normalToMysqlDate($data['sha_arrival_date']);
		
		if($data['sha_accomodation']!=2)
			$data['sha_name2']=''; 
			
		$study_group=$sha_study_group='';
		if(isset($_POST['study_group']))
		{
			$study_group=$_POST['study_group'];
			if($study_group==1)
				$sha_study_group=$_POST['sha_study_group'];
		}
		$data['sha_mobile']=!empty($data['sha_mobile'])?$data['sha_mobile']:'0000000000';

		$sql="update `sha_one` set `title`=?, `fname`=?, `mname`=?, `lname`=?, `gender`=?, `dob`=?, `email`=?, `mobile`=?, `home_phone`=?, `accomodation_type`=?, `student_name2`=?, `nation`=?, `passport_no`=?, `passport_exp`=?, `arrival_date`=?,`study_group`=?, `study_tour_id`=? ,`sha_student_no`=? ,`ec_name`=? ,`ec_relation`=? ,`ec_phone`=? ,`ec_email`=? where `id`=?";
		$this->db->query($sql,array($data['sha_name_title'],ucwords($data['sha_fname']),ucwords($data['sha_mname']),strtoupper($data['sha_lname']),$data['sha_gender'],$data['sha_dob'],$data['sha_email'],$data['sha_mobile'],$data['sha_home_phone'],$data['sha_accomodation'],$data['sha_name2'],$data['sha_nationality'],$data['sha_passport'],$data['sha_passport_expiry'],$data['sha_arrival_date'],$study_group,$sha_study_group,$data['sha_student_no'],$data['sha_EC_name'],$data['sha_EC_relation'],$data['sha_EC_phone'],$data['sha_EC_email'],$data['id']));
		
		if($data['sha_accomodation']=='6' && $data['sha_arrival_date']!='')
			$this->db->query("update `sha_one` set `booking_from`=?, `booking_to`=? where `id`=?",array($data['sha_arrival_date'],$data['sha_arrival_date'],$data['id']));
	}
	

	function application_edit_two_submit($data)
	{
		//Main table #STARTS
		$sql="select * from `sha_two` where `id`='".$data['id']."'";
		$query=$this->db->query($sql);
		if($query->num_rows()==0)
		{
			$sqlInsert="insert into `sha_two` (`id`) values (?)";
			$this->db->query($sqlInsert,array($data['id']));
		}

		//////

		if($data['sha_file_update']==1)
		{
			$data['insPolicyFile']='';
			if(isset($_FILES['insPolicyFile']) && $_FILES['insPolicyFile']['name']!= "")
				{
					  $path="./static/uploads/sha/ins";
					  $t1=time();
					  $data['insPolicyFile']=$t1.$_FILES['insPolicyFile']['name'];
					  move_uploaded_file($_FILES['insPolicyFile']['tmp_name'],$path.'/'.$data['insPolicyFile']);
				}
		}
		else
				$data['insPolicyFile']=$data['sha_ins_file_name_update'];
		/////////////

		$pets=$data['sha_pets'];
		if(!isset($pets['dog']))
			$pets['dog']=0;
		if(!isset($pets['cat']))
			$pets['cat']=0;
		if(!isset($pets['bird']))
			$pets['bird']=0;
		if(!isset($pets['other']))
			$pets['other']=0;

		if($data['sha_live_with_pets']!=1)
		{
			$pets['dog']=$pets['cat']=$pets['bird']=$pets['other']=0;
			$data['sha_pet_live_inside']='';
		}

		if($data['sha_insurance']!=1)
			$data['sha_insurance_provider']=$data['sha_insurance_policy_number']=$data['sha_insurance_policy_expiry']=$data['insPolicyFile']='';

		/*if($data['sha_airport_pickup']!=1 && !isset($data['airport_pickup_to_meeting_point']))
			$data['sha_airport_arrival_date']=$data['sha_airport_arrival_time']=$data['sha_airport_carrier']=$data['sha_airport_flightno']='';*/

		if($data['sha_insurance_policy_expiry']!='')
					$data['sha_insurance_policy_expiry']=normalToMysqlDate($data['sha_insurance_policy_expiry']);
		if($data['sha_airport_arrival_date']!='')
					$data['sha_airport_arrival_date']=normalToMysqlDate($data['sha_airport_arrival_date']);

		if($data['sha_student_religion']!=0)
			$data['sha_religion_other_val']=='';

		if($pets['other']=="0")
			$pets['other_val']="";

		if($data['sha_guardian']!=1)
			$data['sha_guardian_requirements']='';

		if(!isset($data['family_pickup_from_meeting_point']))
			$data['family_pickup_from_meeting_point']='';

		if(!isset($data['airport_pickup_to_meeting_point']))
			$data['airport_pickup_to_meeting_point']='';

		//$data['insPolicyFile']='';
		//see($data);
		/*$sqlUpdate="update `sha_two` set `languages`='".$data['sha_student_language']."', `ethnicity`='".$data['sha_student_ethnicity']."', `religion`='".$data['sha_student_religion']."', `religion_other`='".$data['sha_religion_other_val']."', `live_with_pets`='".$data['sha_live_with_pets']."', `pet_dog`='".$pets['dog']."', `pet_cat`='".$pets['cat']."', `pet_bird`='".$pets['bird']."', `pet_other`='".$pets['other']."', `pet_other_val`='".$pets['other_val']."', `pet_live_inside`='".$data['sha_pet_live_inside']."', `insurance`='".$data['sha_insurance']."', `ins_provider`='".$data['sha_insurance_provider']."', `ins_policy_no`='".$data['sha_insurance_policy_number']."', `ins_expiry`='".$data['sha_insurance_policy_expiry']."', `airport_pickup`='".$data['sha_airport_pickup']."', `airport_arrival_time`='".$data['sha_airport_arrival_time']."', `airport_carrier`='".$data['sha_airport_carrier']."', `airport_flightno`='".$data['sha_airport_flightno']."', `home_student_past`='".$data['sha_home_student_past']."', `home_student_exp`='".$data['sha_home_student_exp']."', `student_desc`='".$data['sha_student_desc']."', `student_family_desc`='".$data['sha_student_family_desc']."', `guardianship`='".$data['sha_guardian']."', `guardianship_type`='".$data['sha_guardian_type']."', `guardianship_other_val`='".$data['sha_other_guardian_val']."', `ins_file`='".$data['insPolicyFile']."' , `family_pickup_meeting_point`='".$data['family_pickup_from_meeting_point']."' , `airport_pickup_meeting_point`='".$data['airport_pickup_to_meeting_point']."'   where `id`='".$data['id']."'";
		$this->db->query($sqlUpdate);*/
		
		
		$sqlUpdate="update `sha_two` set `languages`=?, `ethnicity`=?, `religion`=?, `religion_other`=?, `live_with_pets`=?, `pet_dog`=?, `pet_cat`=?, `pet_bird`=?, `pet_other`=?, `pet_other_val`=?, `pet_live_inside`=?, `insurance`=?, `ins_provider`=?, `ins_policy_no`=?, `ins_expiry`=?, `airport_pickup`=?, `airport_arrival_time`=?, `airport_carrier`=?, `airport_flightno`=?, `home_student_past`=?, `home_student_exp`=?, `student_desc`=?, `student_family_desc`=?, `student_hobbies`=?, `guardianship`=?, `guardianship_requirements`=?, `ins_file`=? , `family_pickup_meeting_point`=? , `airport_pickup_meeting_point`=?   where `id`=?";
		$this->db->query($sqlUpdate,array($data['sha_student_language'],$data['sha_student_ethnicity'],$data['sha_student_religion'],$data['sha_religion_other_val'],$data['sha_live_with_pets'],$pets['dog'],$pets['cat'],$pets['bird'],$pets['other'],$pets['other_val'],$data['sha_pet_live_inside'],$data['sha_insurance'],$data['sha_insurance_provider'],$data['sha_insurance_policy_number'],$data['sha_insurance_policy_expiry'],$data['sha_airport_pickup'],$data['sha_airport_arrival_time'],$data['sha_airport_carrier'],$data['sha_airport_flightno'],$data['sha_home_student_past'],$data['sha_home_student_exp'],$data['sha_student_desc'],$data['sha_student_family_desc'],$data['sha_student_hobbies'],$data['sha_guardian'],trim($data['sha_guardian_requirements']),$data['insPolicyFile'],$data['family_pickup_from_meeting_point'],$data['airport_pickup_to_meeting_point'],$data['id']));

		/*if($data['sha_airport_arrival_date']!='')
		{*/
			$sqlUpdateOne="update `sha_one` set `arrival_date`='".$data['sha_airport_arrival_date']."'  where `id`='".$data['id']."'";
			$this->db->query($sqlUpdateOne);
		/*}*/
		if($data['sha_airport_arrival_date']!='')
		{
			$shaOne=getShaOneAppDetails($data['id']);
			if($shaOne['accomodation_type']=='6')
				$this->db->query("update `sha_one` set `booking_from`=?, `booking_to`=? where `id`=?",array($data['sha_airport_arrival_date'],$data['sha_airport_arrival_date'],$data['id']));
		}

		$sqlUpdateStep="update `sha_one` set `step`='3'  where `id`='".$data['id']."' and `step`='2'";
		$this->db->query($sqlUpdateStep);

		//Main table #ENDS

		//Language #STARTS
			$lang=$data['sha_language'];
			//see($lang);
			$sqlDelLang="delete from `sha_language` where `application_id`='".$data['id']."'";
			$this->db->query($sqlDelLang);
			//see($data);
				for($y=1;$y<=$data['sha_student_language'];$y++)
				{
					$languages=$lang['language-'.$y];
				//	see($languages);
				 	$other=!empty($languages['other_language']) ? $languages['other_language'] : '';

					$insertLang="insert into `sha_language` (`application_id`, `language`,`other_language`, `prof`) values (?,?,?,?)";
					$this->db->query($insertLang, array($data['id'], $languages['language'],$other,$languages['prof']));
				}
		//Language #ENDS
	}

	function application_edit_three_submit($data)
	{
		//Main table #STARTS
		$sql="select * from `sha_three` where `id`='".$data['id']."'";
		$query=$this->db->query($sql);
		if($query->num_rows()==0)
		{
			$sqlInsert="insert into `sha_three` (`id`) values (?)";
			$this->db->query($sqlInsert,array($data['id']));
		}

		$diet=$data['sha_diet'];
		if(!isset($diet['veg']))
			$diet['veg']=0;
		if(!isset($diet['gluten']))
			$diet['gluten']=0;
		if(!isset($diet['pork']))
			$diet['pork']=0;
		if(!isset($diet['food_allergy']))
			$diet['food_allergy']=0;
		if(!isset($diet['other']))
			$diet['other']=0;

		if($diet['other']==0)
			$diet['other_val']='';

		$allergy=$data['sha_allergy'];
		if(!isset($allergy['hay_fever']))
			$allergy['hay_fever']=0;
		if(!isset($allergy['asthma']))
			$allergy['asthma']=0;
		if(!isset($allergy['lactose']))
			$allergy['lactose']=0;
		if(!isset($allergy['gluten']))
			$allergy['gluten']=0;
		if(!isset($allergy['peanut']))
			$allergy['peanut']=0;
		if(!isset($allergy['dust']))
			$allergy['dust']=0;
		if(!isset($allergy['other']))
			$allergy['other']=0;

		if($allergy['other']==0)
			$allergy['other_val']='';

		if($data['sha_student_medication']==0)
			$data['sha_student_medication_details']='';

		if($data['sha_student_disabilities']==0)
			$data['sha_disabilities_details']='';

		if($data['sha_student_course_start_date']!='')
			$data['sha_student_course_start_date']=normalToMysqlDate($data['sha_student_course_start_date']);

/*		$sqlUpdate="update `sha_three` set `diet_req`='".$data['sha_student_diet']."', `diet_veg`='".$diet['veg']."', `diet_gluten`='".$diet['gluten']."', `diet_pork`='".$diet['pork']."', `diet_food_allergy`='".$diet['food_allergy']."', `diet_other`='".$diet['other']."', `diet_other_val`='".$diet['other_val']."', `allergy_req`='".$data['sha_student_allergies']."', `allergy_hay_fever`='".$allergy['hay_fever']."', `allergy_asthma`='".$allergy['asthma']."', `allergy_lactose`='".$allergy['lactose']."', `allergy_gluten`='".$allergy['gluten']."', `allergy_peanut`='".$allergy['peanut']."', `allergy_dust`='".$allergy['dust']."', `allergy_other`='".$allergy['other']."', `allergy_other_val`='".$allergy['other_val']."', `smoker`='".$data['sha_student_smoke']."', `medication`='".$data['sha_student_medication']."', `medication_desc`='".$data['sha_student_medication_details']."', `disabilities`='".$data['sha_student_disabilities']."', `disabilities_desc`='".$data['sha_disabilities_details']."', `live_with_child11`='".$data['sha_live_with_child11']."', `live_with_child20`='".$data['sha_live_with_child20']."', `live_with_child_reason`='".$data['sha_live_with_child_reason']."', `family_include_smoker`='".$data['family_include_smoker']."', `family_pref`='".$data['sha_family_pref']."', `college`='".$data['sha_student_college']."', `campus`='".$data['sha_student_campus']."', `college_address`='".$data['sha_student_college_address']."', `homestay_choosing_reason`='".$data['homestay_choosing_reason']."', `homestay_choosing_reason_other`='".$data['homestay_choosing_reason_other']."', `homestay_hear_ref`='".$data['homestay_hear_ref']."', `homestay_hear_ref_other_val`='".$data['homestay_hear_ref_other_val']."'  where `id`='".$data['id']."'";
		$this->db->query($sqlUpdate);*/
		
		$sqlUpdate="update `sha_three` set `diet_req`=?, `diet_veg`=?, `diet_gluten`=?, `diet_pork`=?, `diet_food_allergy`=?, `diet_other`=?, `diet_other_val`=?, `allergy_req`=?, `allergy_hay_fever`=?, `allergy_asthma`=?, `allergy_lactose`=?, `allergy_gluten`=?, `allergy_peanut`=?, `allergy_dust`=?, `allergy_other`=?, `allergy_other_val`=?, `smoker`=?, `medication`=?, `medication_desc`=?, `disabilities`=?, `disabilities_desc`=?, `live_with_child11`=?, `live_with_child20`=?, `live_with_child_reason`=?, `family_include_smoker`=?, `family_pref`=?, `college`=?, `campus`=?, `college_address`=?, `course_name`=?, `course_start_date`=?, `homestay_choosing_reason`=?, `homestay_choosing_reason_other`=?, `homestay_hear_ref`=?, `homestay_hear_ref_other_val`=?  where `id`=?";
		$this->db->query($sqlUpdate,array($data['sha_student_diet'],$diet['veg'],$diet['gluten'],$diet['pork'],$diet['food_allergy'],$diet['other'],$diet['other_val'],$data['sha_student_allergies'],$allergy['hay_fever'],$allergy['asthma'],$allergy['lactose'],$allergy['gluten'],$allergy['peanut'],$allergy['dust'],$allergy['other'],$allergy['other_val'],$data['sha_student_smoke'],$data['sha_student_medication'],$data['sha_student_medication_details'],$data['sha_student_disabilities'],$data['sha_disabilities_details'],$data['sha_live_with_child11'],$data['sha_live_with_child20'],$data['sha_live_with_child_reason'],$data['family_include_smoker'],$data['sha_family_pref'],$data['sha_student_college'],$data['sha_student_campus'],$data['sha_student_college_address'],$data['sha_student_course_name'],$data['sha_student_course_start_date'],$data['homestay_choosing_reason'],$data['homestay_choosing_reason_other'],$data['homestay_hear_ref'],$data['homestay_hear_ref_other_val'],$data['id']));

		$sqlUpdateStep="update `sha_one` set `step`='4'  where `id`='".$data['id']."' and `step`='3'";
		$this->db->query($sqlUpdateStep);

		//Main table #ENDS
	}

	function application_image_upload_insert($id,$imagename)
	{
		$date=date('Y-m-d H:i:s');
		$sql="insert into `sha_photos`  (`application_id`,`name`,`date`) values('".$id."','".$imagename."','".$date."')";
		$this->db->query($sql);
	}

	function photos($id)
	{
		$sql="select * from `sha_photos` where `application_id`='".$id."' order by `date` DESC";
		$query=$this->db->query($sql);
		return $query->result_array();
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

	var $table = 'sha_one';
	var $column_order = array('fname','accomodation_type','date','date_status_changed'); //set column field database for datatable orderable
	var $column_search = array("CONCAT(`fname`,' ',`lname`)",'fname','mname','lname','email','mobile','sha_student_no'); //set column field database for datatable searchable
	var $order = array('date' => 'desc'); // default order

	private function _get_datatables_query()
	{
		if($_POST['sha_status_page']!='new')
			$this->order=array('date_status_changed'=>'desc');

		$this->db->from($this->table);
		if($_POST['sha_status_page']!='all')
			$this->db->where('status', $_POST['sha_status_page']);

		if($_POST['appStep']!='')
		{
			if($_POST['appStep']=='partial')
				$this->db->where('step !=', 4, FALSE);
			else
				$this->db->where('step',4);
		}
if(!empty($_POST['client'])){
	$this->db->where('client', $_POST['client']);
	

}
if(!empty($_POST['college'])){
	
	$this->db->where('college', $_POST['college']);
}

		if($_POST['appDuplicate']!='0')
			{
					$queryuDuplicate=$this->db->query("select DISTINCT `duplicate` from `sha_one` where `duplicate`!='0'");
					if($queryuDuplicate->num_rows()>0)
					{
						$resDuplicate=$queryuDuplicate->result_array();
						foreach($resDuplicate as $rDup)
							$duplicates[]=$rDup['duplicate'];
						$this->db->where_in('id',$duplicates);
					}
			}
		
		if($_POST['placement']!='' && $_POST['placement']!='both')
		{
			/*$sql="select `student` from `bookings` where `status` IN('expected_arrival','on_hold','arrived','progressive')";

			$query=$this->db->query($sql);
			$placement_res=$query->result_array();
			$placement=array();
			foreach($placement_res as $plmnt)
				$placement[]=$plmnt['student'];

			if($_POST['placement']=='placed')
				$this->db->where_in('id',$placement);
			elseif($_POST['placement']=='not_placed')
				$this->db->where_not_in('id',$placement);*/
				
			if($_POST['placement']=='placed')
				$this->db->where("`sha_one`.`id` IN (select `student` from `bookings` )", NULL, FALSE);
			elseif($_POST['placement']=='not_placed')
				$this->db->where("`sha_one`.`id` NOT IN (select `student` from `bookings` )", NULL, FALSE);
		}
		
		if($_POST['appTourType']!='')
		{
			if($_POST['appTourType']=='no')
				$this->db->where('study_tour_id =', 0);
			else
				$this->db->where('study_tour_id !=', 0, FALSE);
		}
		
		$this->db->where('duplicate',0);
		
		
		if($_POST['appMatchCollege']!='0')
		{
			$amcShaArray=[];
			$appMatchCollegeSha=$this->db->query("SELECT `id` FROM `sha_three` WHERE `college`!='' and trim(`college`) NOT IN(select `bname` from `clients` where `category` IN(3,4))")->result_array();
			foreach($appMatchCollegeSha as $amcSha)
				$amcShaArray[]=$amcSha['id'];
			
			if(!empty($amcShaArray))
			$this->db->where_in('`sha_one`.`id`', $amcShaArray);	
		}
		if($_POST['appCaregivingDuration']!='0')
		{
			$acdShaArray=[];
			$appCaregivingDurationSha=$this->db->query("select `id` from `sha_two` where `guardianship`='1' and (`guardianship_startDate`='0000-00-00' OR `guardianship_endDate`='0000-00-00')")->result_array();
			foreach($appCaregivingDurationSha as $acdSha)
				$acdShaArray[]=$acdSha['id'];
				
			if(!empty($acdShaArray))
			$this->db->where_in('`sha_one`.`id`', $acdShaArray);	
		}

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
		if($_POST['sha_status_page']!='all')
			$this->db->where('status', $_POST['sha_status_page']);

		if($_POST['appStep']!='')
		{
			if($_POST['appStep']=='partial')
				$this->db->where('step !=', 4, FALSE);
			else
				$this->db->where('step',4);
		}
		
		if($_POST['appTourType']!='')
		{
			if($_POST['appTourType']=='no')
				$this->db->where('study_tour_id =', 0);
			else
				$this->db->where('study_tour_id !=', 0, FALSE);
		}
		
		$this->db->where('duplicate',0);

		return $this->db->count_all_results();
	}
	
	function check_bookings_on_delete_action($id)
	{
		$sql_exiting_booking="select 1 from `bookings` where `student`='".$id."'";
		$query_exist_booking=$this->db->query($sql_exiting_booking);
		if($query_exist_booking->num_rows()>0) {
			return 1;	
		}
		else {
			return 0;	
		}
	}


	////////////// For data table server side ENDS


	function bookingDatesSubmit($data)
	{
		$sql="update `sha_one` set `booking_from`='".normalToMysqlDate($data['shaBooking_startDate'])."', `booking_to`='".date('Y-m-d',strtotime(normalToMysqlDate($data['shaBooking_endDate']).' - 1 day'))."', `weeks`='".$data['shaBooking_week']."', `days`='".$data['shaBooking_day']."' where `id`='".$data['id']."'";
		$this->db->query($sql);
	}

	function homestayNominationSubmit($data)
	{
		$sql="update `sha_one` set `nominated_hfa_id`='' ,`nominaton_created`='', `homestay_nomination`='0' where `id`='".$data['id']."'";
		$this->db->query($sql);
	}
	
	function NominationfamilySubmit($data)
	{
		$sql="update `sha_one` set `homestay_nomination`='1', `nominated_hfa_id`='".$data['nominated_hfa_id']."' ,`nominaton_created`= '".date('Y-m-d ')."' where `id`='".$data['id']."'";
		$this->db->query($sql);echo $this->db->last_query();
	}
	function notesSubmit($data)
	{
		$sql="update `sha_one` set `special_request_notes`=? where `id`=?";
		$this->db->query($sql,array($data['special_request_notes'],$data['id']));
	}
	
	function guardianshipOfficeUseFormSubmit($data,$field)
	{
		$sql="update `sha_two` set ";
		if($field=='guardianship')
			$sql .="`guardianship`='".$data['guardianship']."',`guardian_assigned`='0' ";
		elseif($field=='guardian_assigned')
			$sql .="`guardian_assigned`='".$data['guardian_assigned']."' ";	
		$sql .="where `id`='".$data['id']."'";
		$this->db->query($sql);
		//echo $this->db->last_query();
	}
	
	function guardianshipOfficeUseDurationSubmit($data)
	{
		if($data['guardianship_startDate']=='')
			$guardianship_startDate='0000-00-00';
		else	
			$guardianship_startDate=normalToMysqlDate($data['guardianship_startDate']);
		$guardianship_endDate=normalToMysqlDate($data['guardianship_endDate']);
		$sql="update `sha_two` set ";
		$sql .="`guardianship_startDate`='".$guardianship_startDate."', ";
		$sql .="`guardianship_endDate`='".$guardianship_endDate."' ";	
		$sql .="where `id`='".$data['id']."'";
		$this->db->query($sql);
		
		$shaOne=getShaOneAppDetails($data['id']);
		if($shaOne['accomodation_type']=='7')
		{
			if($guardianship_startDate=='0000-00-00')
				$guardianship_endDate='0000-00-00';
			$this->db->query("update `sha_one` set `arrival_date`=?,`booking_from`=?, `booking_to`=? where `id`=?",array($guardianship_startDate,$guardianship_startDate,$guardianship_endDate,$data['id']));
		}
		//echo $this->db->last_query();
	}
				/**
     * Function for get  booking history data 
     * @author Amit kumar
     */
		function booking_history($id,$sortBy){
			
			$shaIds=getDuplicateShaSet($id);
		$sql="SELECT bookings.id as bookid,bookings.host,bookings.student,bookings.booking_from,bookings.booking_to,bookings.status,bookings.serviceOnlyBooking, hfa_one.lname as hlname,hfa_one.email as hemail,
			hfa_one.suburb,hfa_one.street,hfa_one.state,hfa_one.postcode, sha_one.fname,sha_one.lname,sha_one.email,sha_one.arrival_date,sha_one.study_tour_id,sha_one.accomodation_type FROM `bookings` 
			left join sha_one on bookings.student=sha_one.id 
			left join hfa_one on bookings.host=hfa_one.id where bookings.student IN (".implode(',',$shaIds).") ";
		
		if($sortBy=='startDate')	
			$sql .="order by bookings.booking_from";
		if($sortBy=='startDateDesc')	
			$sql .="order by bookings.booking_from desc";
		if($sortBy=='status')	
			$sql .="ORDER BY FIELD(`bookings`.`status`,'expected_arrival','arrived','progressive','moved_out','on_hold','cancelled'), `bookings`.`booking_from` DESC";
			
		$queryDoc=$this->db->query($sql);
			return $queryDoc->result_array();
		}
		
		function saveaddressdetail($data,$id){
			$this->db->where('id',$id);
			$this->db->update('sha_three',$data);
			
		}
		function getcountdata($id){
			$query = $this->db->query("SELECT * FROM sha_three where id='".$id."'");
       return  $query->num_rows();
		}
		 /**
     * Function for data insert uploading document
     * @author Amit kumar
     */
	function sha_document_upload($id,$file)
		{
			$sql="insert into `sha_documents`  (`sha_id`,`name`,`date`) value(?,?,?)";
			$this->db->query($sql,array($id,$file,date('Y-m-d H:i:s')));
		}
		function shadocument($id)
		{
			$sqlDoc="select * from `sha_documents` where `sha_id`='".$id."' order by `date` DESC";
			$queryDoc=$this->db->query($sqlDoc);
			return $queryDoc->result_array();
		}
			function deleteshadocument($id)
		{
			$sql="select * from `sha_documents` where `id`='".$id."'";
			$query=$this->db->query($sql);
			$row=$query->row_array();
			if(!empty($row))
			{
				unlink('static/uploads/shadocument/'.$row['name']);
				$sqlDel="delete from `sha_documents` where `id`='".$id."'";
				$this->db->query($sqlDel);
			}
		}
	
	function payment_history($id)
	{
		$sql="select sum(`total`) as `total_amount`, count(`total`) as `no_of_items`, `booking_id`,`invoice_id`,`sha_id`, `invoice_group`.`status`, MIN(`invoice_group_items`.`date_from`) as `payment_from`, MAX(`invoice_group_items`.`date_to`) as `payment_to` from `invoice_group_items` join `invoice_group` on (`invoice_group_items`.`invoice_id`=`invoice_group`.`id`) where `sha_id`='".$id."' group by `invoice_id` order by `invoice_group_items`.`date` DESC";
		//$sql="select sum(`total`) as `total_amount`, count(`total`) as `no_of_items`, `booking_id`,`invoice_id`,`sha_id`, `invoice_group`.`status`, MIN(`invoice_group_items`.`date_from`) as `payment_from`, MAX(`invoice_group_items`.`date_to`) as `payment_to` from `invoice_group_items` join `invoice_group` on (`invoice_group_items`.`invoice_id`=`invoice_group`.`id`) group by `invoice_id` order by `invoice_group_items`.`date` DESC";
		$query=$this->db->query($sql);//echo $this->db->last_query();
		return $query->result_array();
	}
	
	function getDuplicateShaSet($id)
	{
		$sha=getShaOneAppDetails($id);
		if($sha['duplicate']!=0)
		{
			$shaO=getShaOneAppDetails($sha['duplicate']);
			if(!empty($shaO));
				$id=$shaO['id'];
		}
		
		$sql="select `id` from `sha_one` where `id`='".$id."' or `duplicate`='".$id."'";
		$query=$this->db->query($sql);
		$res=$query->result_array();
		$shaIds=array();
		foreach($res as $r)
			$shaIds[]=$r['id'];
		
		return $shaIds;
	}
	
	
	function getDuplicateShaFirst($shaId)
	{
		$queryDup=$this->db->query("select `duplicate` from `sha_one` where `id`='".$shaId."'");
		$shaDup=$queryDup->row_array();
		if($shaDup['duplicate']=='0')
			$duplicateId=$shaId;
		else
			$duplicateId=$shaDup['duplicate'];
		
		return $duplicateId;	
	}
	
	function notedetail($id){
			
			$id=getDuplicateShaFirst($id);
			$query=$this->db->query("SELECT sha_notes.*,count(sha_notedocuments.note_id) as totaldoc FROM `sha_notes` left join sha_notedocuments on sha_notes.id=sha_notedocuments.note_id where sha_notes.sha_id='".$id."' GROUP by sha_notes.id order by sha_notes.id DESC");
			return $query->result_array();
			
		}
		function getnoteinfo($not){
			$this->db->from('sha_notes');

    $this->db->where('id', $not );

    $query = $this->db->get();
	return $query->row_array();
			
		}
		function sha_notedocument_upload($id,$file,$notid)
		{
			$sql="insert into `sha_notedocuments`  (`sha_id`,`note_id`,`name`,`date`) value(?,?,?,?)";
			$this->db->query($sql,array($id,$notid,$file,date('Y-m-d H:i:s')));
		}
		function notedocumentDetail($id,$notid)
		{
			$sql="select * from `sha_one` where `id`='".$id."'";
			$query=$this->db->query($sql);
			$client=$query->row_array();
			
			if(!empty($client))
			{if(!empty($notid)){
				$agreement=$this->notedocument($notid);
				if(!empty($agreement))
					$client['agreement']=$agreement;
			}
			}
			return $client;
		}
		function notedocument($id)
		{
			$sqlDoc="select * from `sha_notedocuments` where `note_id`='".$id."' order by `date` DESC";
			$queryDoc=$this->db->query($sqlDoc);
			return $queryDoc->result_array();
		}
		function savenote($data){
		
			$this->db->insert('sha_notes',$data);
			return $this->db->insert_id();
		
		}
		function editnote($data,$id){
			$this->db->where('id', $id);
    $this->db->update('sha_notes',$data);
	return $id;
		}
		function deletenotedocument($id)
		{
			$sql="select * from `sha_notedocuments` where `id`='".$id."'";
			$query=$this->db->query($sql);
			$row=$query->row_array();
			if(!empty($row))
			{
				unlink('static/uploads/shanotedocument/'.$row['name']);
				$sqlDel="delete from `sha_notedocuments` where `id`='".$id."'";
				$this->db->query($sqlDel);
			}
		}
			function deletenote($id){
			$this->db->select("name,id");
			$this->db->from('sha_notedocuments');

    $this->db->where('note_id', $id );

    $query = $this->db->get();
	$doc= $query->result_array();
	if(!empty($doc)){
		foreach($doc as $val){
			@unlink('static/uploads/shanotedocument/'.$val['name']);
				
			

		}
	}
		$sqlDel1="delete from `sha_notedocuments` where `note_id`='".$id."'";
				$this->db->query($sqlDel1);
		$sqlDel="delete from `sha_notes` where `id`='".$id."'";
				$this->db->query($sqlDel);
			

	
			

		}
	
	function incidentsByShaId($id)
	{
		$shaSet=getDuplicateShaSet($id);
		$shaIds="'".implode("','",$shaSet)."'";
		return $this->db->query("select * from `booking_incidents` where `sha_id` IN (".$shaIds.") order by `incident_date` DESC, `id` DESC")->result_array();
	}
	
	function feedbacksByShaId($id)
	{
		$shaSet=getDuplicateShaSet($id);
		$shaIds="'".implode("','",$shaSet)."'";
		return $this->db->query("select * from `booking_feedbacks` where `student` IN (".$shaIds.") order by `date` DESC")->result_array();
	}
	
	function copyCancelledRepair($id)
	{
		  $sqlSha="update `sha_one` set `arrival_date`='', `booking_from`='', `booking_to`='', `status`=?, `duplicate`='0', `date`=?, `date_status_changed`='0000-00-00 00:00:00', `date_cancelled`='0000-00-00', `nominaton_created`='0000-00-00' where `id`=?";
		  $this->db->query($sqlSha,array('new',date('Y-m-d H:i:s'),$id));
			
		  $sqlSha2="update `sha_two` set `airport_pickup`=?, `airport_arrival_date`=?, `airport_arrival_time`=?, `airport_carrier`=?, `airport_flightno`=?, `apu_company`=?,`airport_dropoff`=?, `airport_departure_date`=?, `airport_departure_time`=?, `airport_drop_carrier`=?, `airport_drop_flightno`=?,`apu_drop_company`=? where `id`=?";
		  $this->db->query($sqlSha2,array('0','0000-00-00','00:00:00','','','','0','0000-00-00','00:00:00','','','',$id));
	}
	
	function holidaysByShaId($id)
	{
		return $this->db->query("select * from `booking_holidays` where `student` ='".$id."' order by `date` DESC")->result_array();
	}	
	
	function nominationHistory($id)
	{
		$shaSet=getDuplicateShaSet($id);
		$shaIds="'".implode("','",$shaSet)."'";
		
		$sql="select * from `bookings` where student IN (select `id` from `sha_one` where `homestay_nomination`='1' and `nominated_hfa_id`=`bookings`.`host` and `id` IN(".$shaIds."))";
		return $this->db->query($sql)->result_array();
	}
	
	function shaCollegeNameMatched($shaId)
	{
		$shaThree=getShaThreeAppDetails($shaId);
		if(!empty($shaThree) && trim($shaThree['college'])!='')
		{
			$rows=$this->db->query("select * from `clients` where `bname` like ?", array(trim($shaThree['college'])))->num_rows();
			if($rows>0)
				return true;
			else
				return false;	
		}
		else//if college information is not entered or if 3rd form is not filled than it will be considered as a match
			return true;
	}
}
