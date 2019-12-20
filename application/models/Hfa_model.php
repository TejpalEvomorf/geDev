<?php 

class Hfa_model extends CI_Model { 

function applicationsList($status)
	{
		
		$sql="Select * from `hfa_one` ";
		
		if($status!='all')
		$sql .="where `status` = ?";
		
		$sort=" `date` DESC";
		if($status=='no_response')
			$sort=" `date_status_changed` DESC";
		elseif($status=='confirmed')
			$sort=" `visit_date_time` ASC";	
		
		$sql .=" order by ".$sort;
		//$sql .="  limit 100";
		$query	=	$this->db->query($sql,$status);
		//echo $this->db->last_query();
		return $query->result_array(); 
	}


	
function changeStatus($data)
	{
		if($data['hfaChangeStatus_date']!='')
		{
		$date=normalToMysqlDate($data['hfaChangeStatus_date']);
		$time=normalToMysqlTime($data['hfaChangeStatus_time']);
		$datetime=$date.' '.$time;
		}
		else
			$datetime='0000-00-00 00:00:00';
		
		if($data['hfaChangeStatus_status']=='do_not_use'){
			$this->db->where('id', $data['hfaChangeStatus_id']);
    $this->db->update('hfa_one',array("hfa_bookmark"=>'0'));
			
		}
		
		$sql="update `hfa_one` set `status`='".$data['hfaChangeStatus_status']."', `date_status_changed`='".date('Y-m-d H:i:s')."' ";
		
		if($data['hfaChangeStatus_status']=='confirmed')
		$sql .=",`visit_date_time` ='".$datetime."', `visitor_name` ='".$data['hfaChangeStatus_visitor']."', `comments` =?";
		
		$sql .=" where `id`='".$data['hfaChangeStatus_id']."'";
		
		$this->db->query($sql,array($data['hfaChangeStatus_comment']));
		//echo $this->db->last_query();
		
		$sqlDel="delete from `hfa_dnu` where `application_id`='".$data['hfaChangeStatus_id']."'";
		$this->db->query($sqlDel);
		if($data['hfaChangeStatus_status']=='do_not_use')
		{
			$sqlInsert="insert into `hfa_dnu` (`application_id`, `reason`, `comment`) values ('".$data['hfaChangeStatus_id']."', ?, ?)";
			$this->db->query($sqlInsert,array($data['hfaChangeStatus_dnuReason'],$data['hfaChangeStatus_dnuComment']));
		}
		
		$sqlDelUnavailable="delete from `hfa_unavailable` where `application_id`='".$data['hfaChangeStatus_id']."'";
		$this->db->query($sqlDelUnavailable);
		
		//Add visit
		if($data['hfaChangeStatus_status']=='confirmed')
		{
			$dataAddNewVisit['hfaAddNewVisit_date']=$data['hfaChangeStatus_date'];
			$dataAddNewVisit['hfaAddNewVisit_time']=$data['hfaChangeStatus_time'];
			$dataAddNewVisit['hfaAddNewVisit_hfaId']=$data['hfaChangeStatus_id'];
			$dataAddNewVisit['hfaAddNewVisit_emp']=$data['hfaChangeStatus_visitor'];
			$this->addNewVisit($dataAddNewVisit);
		}
	}	
	
	function deleteApplication($id)
	{
		$sql="delete from `hfa_one` where `id`='".$id."'";
		$this->db->query($sql);
		
		$sql="delete from `hfa_two` where `id`='".$id."'";
		$this->db->query($sql);
		
		$sql="delete from `hfa_three` where `id`='".$id."'";
		$this->db->query($sql);
		
		$sql="delete from `hfa_four` where `id`='".$id."'";
		$this->db->query($sql);
		
		$sql="delete from `hfa_bank_details` where `id`='".$id."'";
		$this->db->query($sql);
		
		$sql="delete from `hfa_bathrooms` where `application_id`='".$id."'";
		$this->db->query($sql);
		
		$sql="delete from `hfa_bedrooms` where `application_id`='".$id."'";
		$this->db->query($sql);
		
		$sql="delete from `hfa_facilities` where `id`='".$id."'";
		$this->db->query($sql);
		
		$sql="delete from `hfa_members` where `application_id`='".$id."'";
		$this->db->query($sql);
		
		$sql="delete from `hfa_members_language` where `application_id`='".$id."'";
		$this->db->query($sql);
	}
	
	function rescheduleVisitSubmit($data)
	{
		$date=normalToMysqlDate($data['hfaReschedule_date']);
		$time=normalToMysqlTime($data['hfaReschedule_time']);
		$datetime=$date.' '.$time;
		
		$sql="update `hfa_one` set `rescheduled`='1', `visit_date_time`='".$datetime."', `comments`=? ";
		$sql .=" where `id`='".$data['hfaReschedule_id']."'";
		$this->db->query($sql,array($data['hfaReschedule_comment']));
	}
	
	function ifHfaRescheduled($id)
	{
		$sql="select * from `hfa_one` where `rescheduled`='1' and `id`='".$id."'";
		$query=$this->db->query($sql);
		if($query->num_rows()>0)
			return true;
		else
			return false;	
	}
	
	function hfaDnuReason($id)
	{
		$sql="select * from `hfa_dnu` where `application_id`='".$id."'";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	
	function plstatusvalue($id)
	{
		$sql="select `pl_ins_status` from `hfa_three` where `id`='".$id."'";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	
	function wwstatusvalue($id)
	{
		$sql="select `wwcc_status` from `hfa_three` where `id`='".$id."'";
		$query=$this->db->query($sql);
		return $query->row_array();
	}

	function docsUploaded($id)
	{
		$sql="select * from `hfa_members` where `application_id`='".$id."' order by `id` ";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	
	function application_edit_one_submit($data)
	{
		if($data['hfa_ref']!=7)
			$data['hfa_ref_other']='';
		if($data['hfa_ref']!=2)
			$data['hfa_ref_homestay_family']='';
		
		if($data['hfa_postal_address']==0)
			$data['hfa_street_address_postal']=$data['hfa_suburb_postal']=$data['hfa_postcode_postal']=$data['hfa_state_postal']='';
		
		$sql="update `hfa_one` set `title`=?, `fname`=?, `lname`=?, `email`=?, `mobile`=?, `home_phone`=?, `work_phone`=?, `contact_way`=?, `contact_time`=?, `family_members`=?, `street`=?, `suburb`=?, `postcode`=?, `state`=?, `postal_address`=?, `street_postal`=?, `suburb_postal`=?, `postcode_postal`=?, `state_postal`=?, `ref`=?, `ref_other`=? , `ref_homestay_family`=? , `EC_name`=? , `EC_relation`=? , `EC_phone`=? , `EC_email`=? where `id`=?";
		$this->db->query($sql,array($data['hfa_name_title'],ucwords($data['hfa_fname']),strtoupper($data['hfa_lname']),$data['hfa_email'],$data['hfa_number'],$data['hfa_home_phone'],$data['hfa_work_phone'],$data['hfa_contact_way'],$data['hfa_contact_time'],$data['hfa_family_member'],$data['hfa_street_address'],$data['hfa_suburb'],$data['hfa_postcode'],$data['hfa_state'],$data['hfa_postal_address'],$data['hfa_street_address_postal'],$data['hfa_suburb_postal'],$data['hfa_postcode_postal'],$data['hfa_state_postal'],$data['hfa_ref'],$data['hfa_ref_other'],$data['hfa_ref_homestay_family'],$data['hfa_EC_name'],$data['hfa_EC_relation'],$data['hfa_EC_phone'],$data['hfa_EC_email'],$data['id']));	
	}
	
	function application_edit_two_submit($data)
	{//see($data);die();
		//Main table #STARTS
		$sql="select * from `hfa_two` where `id`='".$data['id']."'";
		$query=$this->db->query($sql);
		if($query->num_rows()==0)
		{
			$sqlInsert="insert into `hfa_two` (`id`) values (?)";
			$this->db->query($sqlInsert,array($data['id']));	
		}
		
		if($data['hfa_internet_to_students']!=1)
			$data['hfa_internet_to_students_type']='';
		//$data['hfa_home_desc'] = $this->db->escape_like_str($data['hfa_home_desc']);
		
		/*$sqlUpdate="update `hfa_two` set `d_type`='".$data['hfa_dwellingType']."', `flooring`='".$data['hfa_flooring_select']."', `flooring_other`='".$data['hfa_flooring_other']."', `internet`='".$data['hfa_internet_to_students']."', `internet_type`='".$data['hfa_internet_to_students_type']."', `s_detector`='".$data['smoke_detector']."', `bedrooms`='".$data['hfa_bedroom']."', `bedrooms_avail`='".$data['hfa_bedroom_avail']."', `bathrooms`='".$data['hfa_bathroom_input']."', `laundry`='".$data['hfa_laundry_avail']."', `laundry_outside`='".$data['hfa_laundry_avail_outside']."', `home_desc`='".$data['hfa_home_desc']."'  where `id`='".$data['id']."'";
		$this->db->query($sqlUpdate);*/
		
		$sqlUpdate="update `hfa_two` set `d_type`=?, `flooring`=?, `flooring_other`=?, `internet`=?, `internet_type`=?, `s_detector`=?, `bedrooms`=?, `bedrooms_avail`=?, `bathrooms`=?, `laundry`=?, `laundry_outside`=?, `home_desc`=?  where `id`=?";
		$this->db->query($sqlUpdate,array($data['hfa_dwellingType'],$data['hfa_flooring_select'],$data['hfa_flooring_other'],$data['hfa_internet_to_students'],$data['hfa_internet_to_students_type'],$data['smoke_detector'],$data['hfa_bedroom'],$data['hfa_bedroom_avail'],$data['hfa_bathroom_input'],$data['hfa_laundry_avail'],$data['hfa_laundry_avail_outside'],$data['hfa_home_desc'],$data['id']));
		
		$sqlUpdateStep="update `hfa_one` set `step`='3'  where `id`='".$data['id']."' and `step`='2'";
		$this->db->query($sqlUpdateStep);
		
		//Main table #ENDS
		
		//Facilities table #STARTS
		
		if(isset($data['hfa_facility_pool']) || isset($data['hfa_facility_tennis']) || isset($data['hfa_facility_piano']) || isset($data['hfa_facility_gym']) || isset($data['hfa_facility_disable']) || isset($data['hfa_facility_other']))
		{
			$sql="select * from `hfa_facilities` where `id`='".$data['id']."'";
			$query=$this->db->query($sql);
			if($query->num_rows()==0)
			{
				$sqlInsert="insert into `hfa_facilities` (`id`) values (?)";
				$this->db->query($sqlInsert,array($data['id']));	
			}
			
			if(!isset($data['hfa_facility_pool']))
				$data['hfa_facility_pool']='0';
			if(!isset($data['hfa_facility_tennis']))
				$data['hfa_facility_tennis']='0';			
			if(!isset($data['hfa_facility_piano']))
				$data['hfa_facility_piano']='0';			
			if(!isset($data['hfa_facility_gym']))
				$data['hfa_facility_gym']='0';			
			if(!isset($data['hfa_facility_disable']))
				$data['hfa_facility_disable']='0';			
			if(!isset($data['hfa_facility_other']))
			{
				$data['hfa_facility_other']='0';
				$data['hfa_facility_other_val']='';
			}
				
			/*$sqlUpdateFacility="update `hfa_facilities` set `pool`='".$data['hfa_facility_pool']."', `tennis`='".$data['hfa_facility_tennis']."', `piano`='".$data['hfa_facility_piano']."', `gym`='".$data['hfa_facility_gym']."', `disable_access`='".$data['hfa_facility_disable']."', `other`='".$data['hfa_facility_other']."', `other_val`='".$data['hfa_facility_other_val']."'  where `id`='".$data['id']."'";
			$this->db->query($sqlUpdateFacility);*/
			
			$sqlUpdateFacility="update `hfa_facilities` set `pool`=?, `tennis`=?, `piano`=?, `gym`=?, `disable_access`=?, `other`=?, `other_val`=?  where `id`=?";
			$this->db->query($sqlUpdateFacility,array($data['hfa_facility_pool'],$data['hfa_facility_tennis'],$data['hfa_facility_piano'],$data['hfa_facility_gym'],$data['hfa_facility_disable'],$data['hfa_facility_other'],$data['hfa_facility_other_val'],$data['id']));
		}
		else
		{
			$sqlDelFacility="delete from `hfa_facilities` where `id`='".$data['id']."'";
			$this->db->query($sqlDelFacility);
		}
		
		//Facilities table #ENDS
		
		//Bedrooms table #STARTS
		for($xD=$data['hfa_bedroom_avail']+1;$xD<=6; $xD++)
		{
			if($data['bedroom-'.$xD]['bed_id']!='')
			{
				$sqlDelBed="delete from `hfa_bedrooms` where `id`='".$data['bedroom-'.$xD]['bed_id']."' and `application_id`='".$data['id']."'";
				$this->db->query($sqlDelBed);
			}
		}
			//$sqlDelBed="delete from `hfa_bedrooms` where `application_id`='".$data['id']."'";
			//$this->db->query($sqlDelBed);
			//bedrooms
			for($x=1;$x<=$data['hfa_bedroom_avail']; $x++)
			{
				if($data['bedroom-'.$x]['hfa_room_avail_from']!='')
					$data['bedroom-'.$x]['hfa_room_avail_from']=normalToMysqlDate($data['bedroom-'.$x]['hfa_room_avail_from']);
				
				if($data['bedroom-'.$x]['hfa_room_avail_to']!='')
					$data['bedroom-'.$x]['hfa_room_avail_to']=normalToMysqlDate($data['bedroom-'.$x]['hfa_room_avail_to']);
				
				if($data['bedroom-'.$x]['hfa_room_date_leaving']!='')
					$data['bedroom-'.$x]['hfa_room_date_leaving']=normalToMysqlDate($data['bedroom-'.$x]['hfa_room_date_leaving']);
				
				if($data['bedroom-'.$x]['hfa_hosting_student']!=1)
					$data['bedroom-'.$x]['hfa_room_date_leaving']=$data['bedroom-'.$x]['student_age']=$data['bedroom-'.$x]['student_gender']=$data['bedroom-'.$x]['student_nation']='';
					
				if($data['bedroom-'.$x]['room_flooring_select']!=5)
					$data['bedroom-'.$x]['hfa_bed_flooring_other_val']='';
					
				if($data['bedroom-'.$x]['hfa_access_room']!="1")
					$data['bedroom-'.$x]['flat_grany']="1";
				
				if($data['bedroom-'.$x]['hfa_room_availability']=="1")
					$data['bedroom-'.$x]['hfa_room_avail_from']=$data['bedroom-'.$x]['hfa_room_avail_to']=$data['bedroom-'.$x]['hfa_hosting_student']=$data['bedroom-'.$x]['hfa_room_date_leaving']=$data['bedroom-'.$x]['student_age']=$data['bedroom-'.$x]['student_gender']=$data['bedroom-'.$x]['student_nation']='';
				
				if($data['bedroom-'.$x]['bed_id']!="")
				{
					$sql="update `hfa_bedrooms` set `application_id`=?,`type`=?,`flooring`=?,`flooring_other`=?,`access`=?,`granny_flat`=?,`internal_ensuit`=?,`avail`=?,`avail_from`=?,`avail_to`=?,`currently_hosting`=?,`date_leaving`=?,`age`=?,`gender`=?,`nation`=? where `id`='".$data['bedroom-'.$x]['bed_id']."'";
					$this->db->query($sql,array($data['id'],$data['bedroom-'.$x]['room_select'],$data['bedroom-'.$x]['room_flooring_select'],$data['bedroom-'.$x]['hfa_bed_flooring_other_val'],$data['bedroom-'.$x]['hfa_access_room'],$data['bedroom-'.$x]['flat_grany'],$data['bedroom-'.$x]['internal_ensuite'],$data['bedroom-'.$x]['hfa_room_availability'],$data['bedroom-'.$x]['hfa_room_avail_from'],$data['bedroom-'.$x]['hfa_room_avail_to'],$data['bedroom-'.$x]['hfa_hosting_student'],$data['bedroom-'.$x]['hfa_room_date_leaving'],$data['bedroom-'.$x]['student_age'],$data['bedroom-'.$x]['student_gender'],$data['bedroom-'.$x]['student_nation']));
				}
				else
				{
					$sql="insert into `hfa_bedrooms` (`application_id`,`type`,`flooring`,`flooring_other`,`access`,`granny_flat`,`internal_ensuit`,`avail`,`avail_from`,`avail_to`,`currently_hosting`,`date_leaving`,`age`,`gender`,`nation`)values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
					$this->db->query($sql,array($data['id'],$data['bedroom-'.$x]['room_select'],$data['bedroom-'.$x]['room_flooring_select'],$data['bedroom-'.$x]['hfa_bed_flooring_other_val'],$data['bedroom-'.$x]['hfa_access_room'],$data['bedroom-'.$x]['flat_grany'],$data['bedroom-'.$x]['internal_ensuite'],$data['bedroom-'.$x]['hfa_room_availability'],$data['bedroom-'.$x]['hfa_room_avail_from'],$data['bedroom-'.$x]['hfa_room_avail_to'],$data['bedroom-'.$x]['hfa_hosting_student'],$data['bedroom-'.$x]['hfa_room_date_leaving'],$data['bedroom-'.$x]['student_age'],$data['bedroom-'.$x]['student_gender'],$data['bedroom-'.$x]['student_nation']));
				}
			}
		//Bedrooms table #ENDS
		
		//Bathrooms table #STARTS
			$sqlDelBed="delete from `hfa_bathrooms` where `application_id`='".$data['id']."'";
			$this->db->query($sqlDelBed);
			//bedrooms
			for($x=1;$x<=$data['hfa_bathroom_input']; $x++)
			{
				if(!isset($data['bathroom-'.$x]['bathroomHas_toilet']))
					$data['bathroom-'.$x]['bathroomHas_toilet']='0';
				if(!isset($data['bathroom-'.$x]['bathroomHas_shower']))
					$data['bathroom-'.$x]['bathroomHas_shower']='0';					
				if(!isset($data['bathroom-'.$x]['bathroomHas_bath']))
					$data['bathroom-'.$x]['bathroomHas_bath']='0';
				
				if($data['bathroom-'.$x]['hfa_room_ensuite']!=0)
					$data['bathroom-'.$x]['flat_grany_bathroom']=1;
										
				$sql="insert into `hfa_bathrooms` (`application_id`,`avail_to_student`,`toilet`,`shower`,`bath`,`ensuit`,`in_out`)values(?,?,?,?,?,?,?)";
				$this->db->query($sql,array($data['id'],$data['bathroom-'.$x]['hfa_bathroom_avail'],$data['bathroom-'.$x]['bathroomHas_toilet'],$data['bathroom-'.$x]['bathroomHas_shower'],$data['bathroom-'.$x]['bathroomHas_bath'],$data['bathroom-'.$x]['hfa_room_ensuite'],$data['bathroom-'.$x]['flat_grany_bathroom']));
				//echo $this->db->last_query()."<br>";
			}
		//Bathrooms table #ENDS
	
	}
	
	function application_edit_three_submit($data)
	{
		//see($data);exit;
		//Main table #STARTS
		$sql="select * from `hfa_three` where `id`='".$data['id']."'";
		$query=$this->db->query($sql);
		if($query->num_rows()==0)
		{
			$sqlInsert="insert into `hfa_three` (`id`) values (?)";
			$this->db->query($sqlInsert,array($data['id']));	
		}
		
		
		if(isset($data['hfa_pet']))
		{
			$pets=$data['hfa_pet'];
			if(!isset($pets['dog']))
				$pets['dog']=0;
			if(!isset($pets['cat']))
				$pets['cat']=0;			
			if(!isset($pets['bird']))
				$pets['bird']=0;			
			if(!isset($pets['other']))
				$pets['other']=0;
		}
		else
		{
				$pets['dog']=0;
				$pets['cat']=0;			
				$pets['bird']=0;			
				$pets['other']=0;
		}	
		
		if($data['hfa_pets']!=1)
		{	
			$pets['dog']=0;
			$pets['cat']=0;			
			$pets['bird']=0;			
			$pets['other']=0;
			$data['hfa_pet_in']='';
			$data['hfa_pet_desc']='';
		}
		
		if($data['hfa_policy_expiry']!='')
					$data['hfa_policy_expiry']=normalToMysqlDate($data['hfa_policy_expiry']);
		
		if(!isset($pets['other']) || $pets['other']==0)
			$pets['other_val']='';
		
		if($data['hfa_insurance']!=1)
			$data['hfa_insurance_provider']=$data['hfa_policy_number']=$data['hfa_policy_expiry']=$data['hfa_liability_insurance']='';
		
		$imagename_ins_file='';
		if($data['hfa_ins_file_update']==1) {
			if(isset($_FILES['hfa_ins_file']) && $_FILES['hfa_ins_file']['name'] != "")
				{
					  $path="./static/uploads/hfa/ins"; 
					  $t1=time();
					  $imagename_ins_file=$t1.$_FILES['hfa_ins_file']['name'];
					  move_uploaded_file($_FILES['hfa_ins_file']['tmp_name'],$path.'/'.$imagename_ins_file);
				}
		}
		else 
		{
				$imagename_ins_file=$data['hfa_ins_file_name_update'];
		}
		
			
		if($data['hfa_international_student']!=1)
			$data['hfa_exp']='';
		
		if($data['hfa_religion']!="0" && $data['hfa_religion']!="")
			$data['hfa_religion_other']='';

		/*$sqlUpdate="update `hfa_three` set `family_members`='".$data['hfa_family_member']."', `pets`='".$data['hfa_pets']."', `pet_dog`='".$pets['dog']."', `pet_cat`='".$pets['cat']."', `pet_bird`='".$pets['bird']."', `pet_other`='".$pets['other']."', `pet_other_val`='".$pets['other_val']."', `pet_inside`='".$data['hfa_pet_in']."'";
		$sqlUpdate .=", `insurance`='".$data['hfa_insurance']."', `ins_provider`='".$data['hfa_insurance_provider']."', `ins_policy_no`='".$data['hfa_policy_number']."', `ins_expiry`='".$data['hfa_policy_expiry']."', `20_million`='".$data['hfa_liability_insurance']."', `ins_content`='".$data['hfa_content_insurance']."', `main_religion`='".$data['hfa_religion']."', `main_religion_other`='".$data['hfa_religion_other']."', `hosted_international_in_past`='".$data['hfa_international_student']."', `homestay_exp`='".$data['hfa_exp']."', `family_desc`='".$data['hfa_family_desc']."'";
		$sqlUpdate .=" where `id`='".$data['id']."'";
		$this->db->query($sqlUpdate);	*/
		
		$sqlUpdate="update `hfa_three` set `family_members`=?, `pets`=?, `pet_dog`=?, `pet_cat`=?, `pet_bird`=?, `pet_other`=?, `pet_other_val`=?, `pet_inside`=?, `pet_desc`=?";
		$sqlUpdate .=", `insurance`=?, `ins_provider`=?, `ins_policy_no`=?, `ins_expiry`=?, `ins_file`=?, `20_million`=?, `ins_content`=?, `main_religion`=?, `main_religion_other`=?, `hosted_international_in_past`=?, `homestay_exp`=?, `family_desc`=?";
		$sqlUpdate .=" where `id`=?";
		$this->db->query($sqlUpdate,array($data['hfa_family_member'],$data['hfa_pets'],$pets['dog'],$pets['cat'],$pets['bird'],$pets['other'],$pets['other_val'],$data['hfa_pet_in'],$data['hfa_pet_desc'],$data['hfa_insurance'],$data['hfa_insurance_provider'],$data['hfa_policy_number'],$data['hfa_policy_expiry'],$imagename_ins_file,$data['hfa_liability_insurance'],$data['hfa_content_insurance'],$data['hfa_religion'],$data['hfa_religion_other'],$data['hfa_international_student'],$data['hfa_exp'],$data['hfa_family_desc'],$data['id']));	
		
		//echo $this->db->last_query();
		
		
		$sqlUpdateStep="update `hfa_one` set `step`='4'  where `id`='".$data['id']."' and `step`='3'";
		$this->db->query($sqlUpdateStep);
		
		//Main table #ENDS
		
		//Bank details #STARTS
		$sqlDelBank="delete from `hfa_bank_details` where `id`='".$data['id']."'";
		$this->db->query($sqlDelBank);
		
		$sqlInsBank="insert into `hfa_bank_details` (`id`, `bank_name`, `acc_name`, `bsb`, `acc_no`) values (?,?,?,?,?)";
		$this->db->query($sqlInsBank, array($data['id'],$data['hfa_bank'],$data['hfa_account_name'],$data['hfa_bsb'],$data['hfa_account_num']));
		//Bank details #ENDS
		
		//Members #STARTS
			$sqlDelMember="delete from `hfa_members` where `application_id`='".$data['id']."'";
			$this->db->query($sqlDelMember);
			
			$sqlDelLang="delete from `hfa_members_language` where `application_id`='".$data['id']."'";
			$this->db->query($sqlDelLang);
			
			for($x=1;$x<=$data['hfa_family_member'];$x++)
			{
				$primary_member='0';
				if($x==1)
					$primary_member='1';
					
				$member=$data['hfa_family-'.$x];
				
				$imagename='';
				if($member['dob']!='') {
					$member['dob']=normalToMysqlDate($member['dob']);	
					$today = date("Y-m-d");
					$diff = date_diff(date_create($member['dob']), date_create($today));
					$age_calculate = $diff->format('%y');
					
					if($age_calculate<18) {
						
						// reset fields  wwcc wwcc_clear wwcc_appli_num wwcc_clear_num wwcc_clear_expiry wwcc_file
						$member['wwcc'] = '';
						$member['wwcc_clear'] = '';
						$member['wwcc_appli_num'] = '';
						$member['wwcc_clear_num'] = '';
						$member['wwcc_clear_expiry'] = '0000-00-00';
						$member['wwcc_file'] = '';
					}else {
						
						if($data['hfa_family-'.$x]['wwcc_file_update']==1) {
							if(isset($_FILES['hfa_family-'.$x]['name']['wwcc_file']) && $_FILES['hfa_family-'.$x]['name']['wwcc_file'] != "") {
								$path="./static/uploads/hfa/wwcc"; 
								$t1=time();
								$imagename=$t1.$_FILES['hfa_family-'.$x]['name']['wwcc_file'];		
								move_uploaded_file($_FILES['hfa_family-'.$x]['tmp_name']['wwcc_file'],$path.'/'.$imagename);
							}
						}
						else {
							$imagename=$data['hfa_family-'.$x]['wwcc_file_name_update'];
						}
						if($member['wwcc_clear_expiry']!='') {
							$member['wwcc_clear_expiry']=normalToMysqlDate($member['wwcc_clear_expiry']);
						}
					}
					if($member['contact_number']!=''){
				$num1=str_replace('-','',$member['contact_number']);
				$num1=str_replace(' ','',$num1);
				$member['contact_number']=mobileFormat($num1);
				
				}
				
				}
	$member['other_role']=!empty($member['other_role']) ? $member['other_role'] :'';
				//echo "<pre>";
				//print_r($member);
				$insertMember="insert into `hfa_members` (`application_id`, `title`, `fname`, `lname`, `dob`, `gender`, `role`,`other_role`, `occu`, `ethnicity`, `smoke`, `language`, `wwcc`, `wwcc_clearence`, `wwcc_application_no`, `wwcc_clearence_no`, `wwcc_expiry`, `wwcc_file`,`primary_member`,`contact_number`) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
				$this->db->query($insertMember, array($data['id'], $member['title'], $member['fname'], $member['lname'], $member['dob'], $member['gender'], $member['role'],$member['other_role'], $member['occu'], $member['nation'], $member['smoke'], $member['languages'], $member['wwcc'], $member['wwcc_clear'], $member['wwcc_appli_num'], $member['wwcc_clear_num'], $member['wwcc_clear_expiry'], $imagename,$primary_member,$member['contact_number']));
				$member_id=$this->db->insert_id();
				
				for($y=1;$y<=$member['languages'];$y++)
				{
					$languages=$member['languages-'.$y];
					$other=!empty($languages['other_language']) ? $languages['other_language'] : '';
					$insertLang="insert into `hfa_members_language` (`application_id`, `member_id`, `language`, `other_language`,`prof`) values (?,?,?,?,?)";
					$this->db->query($insertLang, array($data['id'], $member_id, $languages['language'],$other,$languages['prof']));
				}
			}
		//Members #ENDS
	}
	
	function application_edit_four_submit($data)
	{
		//Main table #STARTS
		$sql="select * from `hfa_four` where `id`='".$data['id']."'";
		$query=$this->db->query($sql);
		if($query->num_rows()==0)
		{
			$sqlInsert="insert into `hfa_four` (`id`) values (?)";
			$this->db->query($sqlInsert,array($data['id']));	
		}
		
		if(isset($data['diet']))
		{
			$diet=$data['diet'];
			if(!isset($diet['veg']))
				$diet['veg']=0;
			if(!isset($diet['gluten']))
				$diet['gluten']=0;
			if(!isset($diet['no_pork']))
				$diet['no_pork']=0;
			if(!isset($diet['food_allergies']))
				$diet['food_allergies']=0;
		}
		else
		{
				$diet['veg']=0;
				$diet['gluten']=0;
				$diet['no_pork']=0;
				$diet['food_allergies']=0;
		}
		
		if(isset($data['allergy']))
		{
			$allergy=$data['allergy'];
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
			if(!isset($allergy['veg']))
				$allergy['veg']=0;
			if(!isset($allergy['dust']))
				$allergy['dust']=0;
			if(!isset($allergy['other']))
				$allergy['other']=0;
		}
		else
		{
			$allergy['hay_fever']=0;
			$allergy['asthma']=0;
			$allergy['lactose']=0;
			$allergy['gluten']=0;
			$allergy['peanut']=0;
			$allergy['veg']=0;
			$allergy['dust']=0;
			$allergy['other']=0;
		}
		
		if($data['hfa_allergic_student_accomodate']!=1)
		{
			$allergy['hay_fever']=0;
			$allergy['asthma']=0;
			$allergy['lactose']=0;
			$allergy['gluten']=0;
			$allergy['peanut']=0;
			$allergy['veg']=0;
			$allergy['dust']=0;
			$allergy['other']=0;
		}
		
		if($data['hfa_diet_student_accomodate']!=1)		
		{
			$diet['veg']=0;
			$diet['gluten']=0;
			$diet['no_pork']=0;
			$diet['food_allergies']=0;
		}
			
		if($allergy['other']==0)
			$allergy['hfa_other_allergies']='';
	
		
		/*$sqlUpdate="update `hfa_four` set `age_pref`='".$data['hfa_student_age_pref']."', `gender_pref`='".$data['hfa_student_gender_pref']."', `reason_age_gender`='".$data['hfa_age_pref_reason']."', `disable_students`='".$data['hfa_disable_student_accomodate']."', `smoker_students`='".$data['hfa_smoker_student_accomodate']."', `diet_student`='".$data['hfa_diet_student_accomodate']."', `allergic_students`='".$data['hfa_allergic_student_accomodate']."', `other_pref`='".$data['other_pref']."', `ref`='".$data['hfa_ref']."', `ref_other`='".$data['hfa_ref_other']."'";
		$sqlUpdate .=", `diet_req_veg`='".$diet['veg']."', `diet_req_gluten`='".$diet['gluten']."', `diet_req_no_pork`='".$diet['no_pork']."', `diet_req_food_allergy`='".$diet['food_allergies']."', `allerry_hay_fever`='".$allergy['hay_fever']."', `allerry_asthma`='".$allergy['asthma']."', `allerry_lactose`='".$allergy['lactose']."', `allerry_gluten`='".$allergy['gluten']."', `allerry_peanut`='".$allergy['peanut']."', `allerry_dust`='".$allergy['dust']."', `allerry_other`='".$allergy['other']."', `allerry_other_val`='".$allergy['hfa_other_allergies']."'";
		$sqlUpdate .=" where `id`='".$data['id']."'";
		$this->db->query($sqlUpdate);	*/
		
		$sqlUpdate="update `hfa_four` set `age_pref`=?, `gender_pref`=?, `reason_age_gender`=?, `disable_students`=?, `smoker_students`=?, `diet_student`=?, `allergic_students`=?, `other_pref`=?";
		$sqlUpdate .=", `diet_req_veg`=?, `diet_req_gluten`=?, `diet_req_no_pork`=?, `diet_req_food_allergy`=?, `allerry_hay_fever`=?, `allerry_asthma`=?, `allerry_lactose`=?, `allerry_gluten`=?, `allerry_peanut`=?, `allerry_dust`=?, `allerry_other`=?, `allerry_other_val`=?";
		$sqlUpdate .=" where `id`=?";
		$this->db->query($sqlUpdate,array($data['hfa_student_age_pref'],$data['hfa_student_gender_pref'],$data['hfa_age_pref_reason'],$data['hfa_disable_student_accomodate'],$data['hfa_smoker_student_accomodate'],$data['hfa_diet_student_accomodate'],$data['hfa_allergic_student_accomodate'],$data['other_pref'],$diet['veg'],$diet['gluten'],$diet['no_pork'],$diet['food_allergies'],$allergy['hay_fever'],$allergy['asthma'],$allergy['lactose'],$allergy['gluten'],$allergy['peanut'],$allergy['dust'],$allergy['other'],$allergy['hfa_other_allergies'],$data['id']));	
		//echo $this->db->last_query();
		
		
		$sqlUpdateStep="update `hfa_one` set `step`='5'  where `id`='".$data['id']."' and `step`='4'";
		$this->db->query($sqlUpdateStep);
		
		//Main table #ENDS
	}
	
	function getHfaTwoAppDetailsFacilities($id)
	{
		$sql="select * from `hfa_facilities` where `id`='".$id."'";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	
	function getHfaTwoAppDetailsBedrooms($id)
	{
		$sql="select * from `hfa_bedrooms` where `application_id`='".$id."' order by `id`";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	
	function getHfaTwoAppDetailsBathrooms($id)
	{
		$sql="select * from `hfa_bathrooms` where `application_id`='".$id."' order by `id`";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	
	function getHfaTwoAppDetailsBank($id)
	{
		$sql="select * from `hfa_bank_details` where `id`='".$id."'";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	
	function getHfaTwoAppDetailsMemberDetails($id)
	{
		//$sql="select * from `hfa_members` where `application_id`='".$id."' order by `primary_member` DESC, `id`";
		$sql="select * from `hfa_members` where `application_id`='".$id."' order by `member_order` , `id`";
		$query=$this->db->query($sql);
		$res=$query->result_array();
		
		foreach($res as $k=>$v)
		{
			$sqlLang="select * from `hfa_members_language` where `application_id`='".$id."' and `member_id`='".$v['id']."' order by `id`";
			$queryLang=$this->db->query($sqlLang);
			$res[$k]['languages']=$queryLang->result_array();	
		}
		return $res;
	}	
	
	function application_image_upload_insert($id,$imagename)
	{
		$date=date('Y-m-d H:i:s');
		$sql="insert into `hfa_photos`  (`application_id`,`name`,`date`) values('".$id."','".$imagename."','".$date."')";
		$this->db->query($sql);
	}
	
	function photos($id)
	{
		$sql="select * from `hfa_photos` where `application_id`='".$id."' order by `date` DESC";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	
	
	////////////// For data table server side STARTS
	
	var $table = 'hfa_one';
	var $column_order = array('lname','email','date','date_status_changed'); //set column field database for datatable orderable
	var $column_search = array("CONCAT(`fname`,' ',`lname`)",'fname','lname','email','mobile','street','suburb','state','postcode'); //set column field database for datatable searchable 
	var $order = array('date' => 'desc'); // default order
	
	private function _get_datatables_query()
	{
		if($_POST['hfa_status_page']!='new')
			$this->order=array('date_status_changed'=>'desc');
		/*elseif($_POST['hfa_status_page']=='confirmed')
			$this->order=array('visit_date_time'=>'asc');*/
		
		if($_POST['hfa_status_page']=='confirmed' || $_POST['hfa_status_page']=='pending_approval' || $_POST['hfa_status_page']=='do_not_use' || $_POST['hfa_status_page']=='unavailable')
			$this->column_order = array('lname','email',null,'date_status_changed');
		if($_POST['hfa_status_page']=='approved' || $_POST['hfa_status_page']=='all')
			$this->column_order = array('lname','email','date_status_changed');
		
		if(isset($_POST['appReason']) && $_POST['appReason']!='')
			$this->db->select($this->table.'.*, `hfa_dnu`.`reason`');
		$this->db->from($this->table);
		if($_POST['hfa_status_page']!='all')
			$this->db->where('status', $_POST['hfa_status_page']);
			
		if($_POST['appStep']!='')
		{
			if($_POST['appStep']=='partial')
				$this->db->where('step !=', 5, FALSE);
			else if($_POST['appStep']=='bookmarked')
				$this->db->where('hfa_bookmark', '1');
			else if($_POST['appStep']=='revisited')
				$this->db->where('revisit', '1');
			else
				$this->db->where('step',5);
		}
		if(!empty($_POST['room'])){
			$this->db->join('hfa_two', 'hfa_one.id = hfa_two.id');
			$this->db->where('bedrooms_avail',$_POST['room']);
		}
		
		if(isset($_POST['appReason']) && $_POST['appReason']!='')
		{
			$this->db->join('hfa_dnu', 'hfa_one.id = hfa_dnu.application_id');
			$this->db->where('reason',$_POST['appReason']);
		//$this->db->where('reason',$_POST['appReason']);
		}
		if($_POST['appState']!='')
			$this->db->where_in('state', explode(',',$_POST['appState']));
		
		if($_POST['cApproval']!='')
		{
			$queryCApproval=$this->db->query("select `hfa_id` from `hfa_college_approval` where `college_id` IN (".$_POST['cApproval'].")");
			$cAHfa=array();
			foreach($queryCApproval->result_array() as $cAH)
				$cAHfa[]=$cAH['hfa_id'];
			$cAHfa[]=0;	
			$this->db->where_in('id',$cAHfa);
			
		}
		
		if(!empty($_POST['insurance']))
		{
			$this->db->join('hfa_three', 'hfa_one.id = hfa_three.id');
			if($_POST['insurance']=='na')
				$this->db->where('insurance','0');
			elseif($_POST['insurance']=='expired')
			{
				$this->db->where('insurance','1');
				$this->db->where('ins_expiry !=','0000-00-00');
				$this->db->where('ins_expiry <=',date('Y-m-d'));
			}
		}
		
		if(!empty($_POST['wwcc']) && ($_POST['wwcc']=='na' || $_POST['wwcc']=='expired' || $_POST['wwcc']=='turned18'))
		{
			if($_POST['wwcc']=='na')
				$query_wwcc=$this->db->query("select distinct(`application_id`) from `hfa_members` where `wwcc` ='0'");
			elseif($_POST['wwcc']=='expired')
				$query_wwcc=$this->db->query("select distinct(`application_id`) from `hfa_members` where `wwcc`='1' and `wwcc_clearence`='1' and  `wwcc_expiry`<='".date('Y-m-d')."' and `wwcc_expiry`!='0000-00-00'");
			elseif($_POST['wwcc']=='turned18')
			{
				$date_18yearsBack=date('Y-m-d',strtotime('-18 years'));
				$query_wwcc=$this->db->query("select distinct(`hfa_members`.`application_id`) from `hfa_members` join `hfa_three` ON (`hfa_members`.`application_id`=`hfa_three`.`id`) where `hfa_members`.`wwcc`='' and `hfa_three`.`wwcc_status`='1' and  `hfa_members`.`dob`<='".$date_18yearsBack."'");
			}
			//echo $this->db->last_query();
			$memberWWCC=$query_wwcc->result_array();
			$mWWCC=array('0');
			
			foreach($memberWWCC as $mW)
				$mWWCC[]=$mW['application_id'];
			
			$this->db->where_in('`hfa_one`.`id`', $mWWCC);
		}
		
		if(!empty($_POST['warning']))
		{
			$warningHfa=array(0);
			if(in_array($_POST['warning'],array('1','2','3')))
				$sqlWarning=" HAVING COUNT(*)='".$_POST['warning']."'";
			else
				$sqlWarning='';
				
			$warningRes=$this->db->query("select COUNT( * ) as `warningCount`, `hfa_id` from `hfa_warnings` group by `hfa_id` ".$sqlWarning)->result_array();//echo $this->db->last_query();
			foreach($warningRes as $warningR)
				$warningHfa[]=$warningR['hfa_id'];	
			$this->db->where_in('`hfa_one`.`id`', $warningHfa);
		}
		
		if($_POST['roomType']!='')
		{
			$this->db->where("`hfa_one`.`id` IN (select DISTINCT `application_id` from `hfa_bedrooms` where `type` IN(".$_POST['roomType']."))", NULL, FALSE);
		}
		
		if($_POST['religion']!='')
		{
			$this->db->where("`hfa_one`.`id` IN (select DISTINCT `id` from `hfa_three` where `main_religion` =".$_POST['religion'].")", NULL, FALSE);
		}
		
		if($_POST['nation']!='')
		{
			$this->db->where("`hfa_one`.`id` IN (select DISTINCT `application_id` from `hfa_members` where `ethnicity` =".$_POST['nation'].")", NULL, FALSE);
		}
		
		if($_POST['language']!='')
		{
			$this->db->where("`hfa_one`.`id` IN (select DISTINCT `application_id` from `hfa_members_language` where `language` =".$_POST['language'].")", NULL, FALSE);
		}
		
		if($_POST['facility']!='')
		{
			$facilitiesReq=explode(',',$_POST['facility']);
			$facilityPool=false;
			if(in_array('1',$facilitiesReq))
				$facilityPool=true;
			$facilityTennis=false;
			if(in_array('2',$facilitiesReq))
				$facilityTennis=true;
			$facilityPiano=false;
			if(in_array('3',$facilitiesReq))
				$facilityPiano=true;
			$facilityGym=false;
			if(in_array('4',$facilitiesReq))
				$facilityGym=true;
			$facilityDisableA=false;
			if(in_array('5',$facilitiesReq))
				$facilityDisableA=true;
			
			$hfaPool=$hfaTennis=$hfaPiano=$hfaGym=$hfaDA=array();
			if($facilityPool)		
				$hfaPool=$this->db->query("select `id` from `hfa_facilities` where `pool`='1'")->result_array();
			if($facilityTennis)	
				$hfaTennis=$this->db->query("select `id` from `hfa_facilities` where `tennis`='1'")->result_array();
			if($facilityPiano)	
				$hfaPiano=$this->db->query("select `id` from `hfa_facilities` where `piano`='1'")->result_array();
			if($facilityGym)	
				$hfaGym=$this->db->query("select `id` from `hfa_facilities` where `gym`='1'")->result_array();
			if($facilityDisableA)	
				$hfaDA=$this->db->query("select `id` from `hfa_facilities` where `disable_access`='1'")->result_array();
			$hfaFacility=array_merge($hfaPool, $hfaTennis, $hfaPiano, $hfaGym, $hfaDA);
			$hFArray=array();
			foreach($hfaFacility as $hF)
			{
				if(!in_array($hF['id'],$hFArray))
					$hFArray[]=$hF['id'];		
			}
			
			if(!empty($hFArray))
				$this->db->where_in('`hfa_one`.`id`', $hFArray);
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
		//echo $this->db->last_query();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();//echo $this->db->last_query();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		if($_POST['hfa_status_page']!='all')
			$this->db->where('status', $_POST['hfa_status_page']);
		
		if($_POST['appStep']!='')
		{
			if($_POST['appStep']=='partial')
				$this->db->where('step !=', 5, FALSE);
			else
				$this->db->where('step',5);
		}
		
	//	if($_POST['appReason']!=''){
		//	$this->db->where('status', $_POST['appReason']);
		//}
		
		if($_POST['appState']!='')
			$this->db->where_in('state', explode(',',$_POST['appState']));
			
		return $this->db->count_all_results();
	}
	
	////////////// For data table server side ENDS
	
	
	function changeStatusUnavailable($data)
	{
		$dateFrom=normalToMysqlDate($data['hfaChangeStatus_unavailableDateFrom']);
		$dateTo=normalToMysqlDate($data['hfaChangeStatus_unavailableDateTo']);
		$dateToday=date('Y-m-d');
		$dateFromStr=strtotime($dateFrom);
		$dateToStr=strtotime($dateTo);
		$dateTodayStr=strtotime($dateToday);
		
		if($dateFromStr<$dateToStr && $dateFromStr>=$dateTodayStr)
		{
			if($dateFromStr==$dateTodayStr)
			{
				  $sql="update `hfa_one` set `status`='".$data['hfaChangeStatus_status']."', `date_status_changed`='".date('Y-m-d H:i:s')."' ";
				  $sql .=", `comments` =?";
				  $sql .=" where `id`='".$data['hfaChangeStatus_id']."'";
				  $this->db->query($sql,array($data['hfaChangeStatus_unavailableComment']));
				  echo "today";
			}
			else
			{
				echo "future-".date('d M Y',strtotime($dateFrom));
				
				 $sqlComment="update `hfa_one` set ";
				 $sqlComment.="`comments` =?";
				 $sqlComment .=" where `id`='".$data['hfaChangeStatus_id']."'";
				 $this->db->query($sqlComment,array($data['hfaChangeStatus_unavailableComment']));
			}
			
			$sqlDel="delete from `hfa_unavailable` where `application_id`='".$data['hfaChangeStatus_id']."'";
			$this->db->query($sqlDel);
		
			$sqlInsert="insert into `hfa_unavailable` (`application_id`, `date_from`, `date_to`, `date`) values ('".$data['hfaChangeStatus_id']."','".$dateFrom."', '".$dateTo."', '".date('Y-m-d H:i:s')."')";
			$this->db->query($sqlInsert);
		}
	}	
	
		
	function hfaUnavailable($id)
	{
		$sql="select * from `hfa_unavailable` where `application_id`='".$id."'";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	
	function changeUnavailableToDateSubmit($data)
	{
		$dateTo=normalToMysqlDate($data['hfaUnavailableDateTo']);
		
		$sql="update `hfa_unavailable` set `date_to`='".$dateTo."'";
		$sql .=" where `application_id`='".$data['hfaUnavailable_id']."'";
		$this->db->query($sql);
		
		$sqlOne="update `hfa_one` set  `comments`='".$data['hfaUnavailable_comment']."' ";
		$sqlOne .=" where `id`='".$data['hfaUnavailable_id']."'";
		$this->db->query($sqlOne);
		
	}
	
	function hfaOfficeUseSelfCateredFormSubmit($data)
	{
		$sql="update `hfa_one` set `self_catered`='".$data['self_catered']."' where `id`='".$data['id']."'";
		$this->db->query($sql);
	}
	
	function approveHfaPlIns($host)
	{
		$sql="update `hfa_three` set `pl_ins_status`='1' where `id`='".$host."'";
		$this->db->query($sql);
	}
	function unapproveHfaPlIns($host)
	{
		$sql="update `hfa_three` set `pl_ins_status`='0' where `id`='".$host."'";
		$this->db->query($sql);
	}
	function approveHfawwIns($host)
	{
		$sql="update `hfa_three` set `wwcc_status`='1' where `id`='".$host."'";
		$this->db->query($sql);
	}
	function unapproveHfawwIns($host)
	{
		$sql="update `hfa_three` set `wwcc_status`='0' where `id`='".$host."'";
		$this->db->query($sql);
	}
	
	function updatePLInsDetails($data)
	{
		$host=$data['hfa_id'];
		$insurance=$data['hfa_insurance'];
		if($data['hfa_insurance']==0 || $data['hfa_insurance']=='')
		  $ins_provider=$ins_policy_no=$ins_expiry=$Ins20_million='';
		else
		{
			$ins_provider=$data['hfa_insurance_provider'];
			$ins_policy_no=$data['hfa_policy_number'];
			$ins_expiry=$data['hfa_policy_expiry'];
			$Ins20_million=$data['hfa_liability_insurance'];
		}
		
		
		$imagename_ins_file='';
		if($data['ins_file_update']==1) 
			{
				if($_FILES['ins_file']['name'] != "")
				{
					  $path="./static/uploads/hfa/ins"; 
					  $t1=time();
					  $imagename_ins_file=$t1.$_FILES['ins_file']['name'];
					  move_uploaded_file($_FILES['ins_file']['tmp_name'],$path.'/'.$imagename_ins_file);
				}
			}
			else 
				$imagename_ins_file=$data['ins_file_name_update'];
		
		$sql="update `hfa_three` set `insurance`=?, `ins_provider`=?, `ins_policy_no`=?, `ins_expiry`=?, `ins_file`=?, `20_million`=? where `id`=?";
		$this->db->query($sql,array($insurance,$ins_provider,$ins_policy_no, normalToMysqlDate($ins_expiry),$imagename_ins_file,$Ins20_million,$host));
		//echo $this->db->last_query();
		
		/*$sqlSel="select * from `hfa_three` where `id`='".$host."'";
		$query=$this->db->query($sqlSel);
		if($query->num_rows()>0)
		{
			$hfa_three=$query->row_array();
			echo plInsStatusText($hfa_three);
		}*/
	}
	
	function updateWWCCDetails($data)
	{
		  $imagename='';
		  if($data['wwcc_file_update']==1) 
			  {
				  if($_FILES['wwcc_file']['name'] != "") 
					  {
						  $path="./static/uploads/hfa/wwcc"; 
						  $t1=time();
						  $imagename=$t1.$_FILES['wwcc_file']['name'];		
						  move_uploaded_file($_FILES['wwcc_file']['tmp_name'],$path.'/'.$imagename);
					  }
			  }
			  else 
				  $imagename=$data['wwcc_file_name_update'];
			if(trim($data['wwcc_clear_expiry'])=='')
				$data['wwcc_clear_expiry']='00/00/0000';
			
			if($data['wwcc']=='0')
			{
				$data['wwcc_clear'] = '';
				$data['wwcc_appli_num'] = '';
				$data['wwcc_clear_num'] = '';
				$data['wwcc_clear_expiry'] = '00/00/0000';
				$imagename='';
			}
		  if($data['wwcc_clear']=='0')
			{
				$data['wwcc_clear_num'] = '';
				$data['wwcc_clear_expiry'] = '00/00/0000';
				$imagename='';
			}
			if($data['wwcc_clear']=='1')
			{
				$data['wwcc_appli_num'] = '';
			}
			
		  $sql="update `hfa_members`  set `wwcc`=?, `wwcc_clearence`=?, `wwcc_application_no`=?, `wwcc_clearence_no`=?, `wwcc_expiry`=?, `wwcc_file`=? where `id`=? and `application_id`=?";
		  $this->db->query($sql,array($data['wwcc'],$data['wwcc_clear'],$data['wwcc_appli_num'],$data['wwcc_clear_num'],normalToMysqlDate($data['wwcc_clear_expiry']),$imagename,$data['member_id'],$data['hfa_id']));
	}
	
	function notesSubmit($data)
	{
		$sql="update `hfa_one` set `special_request_notes`=? where `id`='".$data['id']."'";
		$this->db->query($sql,array($data['special_request_notes']));
	}
	
	function notesFamilySubmit($data)
	{
		$sql="update `hfa_one` set `notes_family`=? where `id`='".$data['id']."'";
		$this->db->query($sql,$data['notes_family']);
	}
	
	function vipCheckBedroom($data)
	{
		$bed=explode('-',$data['bed']);
		$sql="update `hfa_bedrooms` set `vip`='".$data['val']."' where `id`='".trim($bed[1])."'";
		$this->db->query($sql);
	}
	
	function findSuburb($text)
	{
		$sql="select * from `suburb_aus` where `Locality` like '".$text."%'";
		$query=$this->db->query($sql);
		//echo $this->db->last_query().'<br>';
		return $query->result_array();
	}
	
	function getSuburbNameFromId($id)
	{
		$sql="select * from `suburb_aus` where `id`='".$id."'";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	 /**
     * Function for data insert uploading document
     * @author Amit kumar
     */
	function hfa_document_upload($id,$file)
		{
			$sql="insert into `hfa_documents`  (`hfa_id`,`name`,`date`) value(?,?,?)";
			$this->db->query($sql,array($id,$file,date('Y-m-d H:i:s')));
		}
		
		/**
     * Function for get  data host family detail
     * @author Amit kumar
     */
			function hfaDetail($id)
		{
			$sql="select * from `hfa_one` where `id`='".$id."'";
			$query=$this->db->query($sql);
			$client=$query->row_array();
			
			if(!empty($client))
			{
				$agreement=$this->hfadocument($id);
				if(!empty($agreement))
					$client['agreement']=$agreement;
			}
			return $client;
		}
			/**
     * Function for get  data host family document detail
     * @author Amit kumar
     */
		function hfadocument($id)
		{
			$sqlDoc="select * from `hfa_documents` where `hfa_id`='".$id."' order by `date` DESC";
			$queryDoc=$this->db->query($sqlDoc);
			return $queryDoc->result_array();
		}
		
		function deletehfadocument($id)
		{
			$sql="select * from `hfa_documents` where `id`='".$id."'";
			$query=$this->db->query($sql);
			$row=$query->row_array();
			if(!empty($row))
			{
				unlink('static/uploads/hfadocument/'.$row['name']);
				$sqlDel="delete from `hfa_documents` where `id`='".$id."'";
				$this->db->query($sqlDel);
			}
		}
			/**
     * Function for get  booking history data 
     * @author Amit kumar
     */
		function booking_history($id,$sortBy){
			
		$sql="SELECT bookings.id as bookid,bookings.host,bookings.student,bookings.booking_from,bookings.booking_to,bookings.status, hfa_one.lname as hlname,hfa_one.email as hemail,
			hfa_one.suburb,hfa_one.street,hfa_one.state,hfa_one.postcode, sha_one.title as `sha_title`, sha_one.fname,sha_one.lname,sha_one.email,sha_one.dob as `sha_dob`,sha_one.gender as `sha_gender`,sha_one.arrival_date,sha_one.study_tour_id,sha_one.accomodation_type,sha_three.college as `sha_college` FROM `bookings` 
			left join sha_one on bookings.student=sha_one.id 
			left join sha_three on bookings.student=sha_three.id 
			left join hfa_one on bookings.host=hfa_one.id where bookings.host='".$id."' ";
		if($sortBy=='startDate')	
			$sql .="order by bookings.booking_from";
		if($sortBy=='startDateDesc')	
			$sql .="order by bookings.booking_from desc";
		if($sortBy=='status')	
			$sql .="ORDER BY FIELD(`bookings`.`status`,'expected_arrival','arrived','progressive','moved_out','on_hold','cancelled');";
			
		$queryDoc=$this->db->query($sql);
			return $queryDoc->result_array();
		}
		
	/**
     * Function for get  mobile   data 
     * @author Amit kumar
     */
		function hfamobileformat(){
			$this->db->select("id,mobile,home_phone,work_phone");	
			 $this->db->limit('10');
			 $query=$this->db->get('hfa_one');
			$ret = $query->result_array();
			
			return $ret;
			
	
		}
		
		function hfafamilydocument($id)
		{
			$sqlDoc="select * from `hfa_familydocuments` where `note_id`='".$id."' order by `date` DESC";
			$queryDoc=$this->db->query($sqlDoc);
			return $queryDoc->result_array();
		}
		
		function deletehfafamilydocument($id)
		{
			$sql="select * from `hfa_familydocuments` where `id`='".$id."'";
			$query=$this->db->query($sql);
			$row=$query->row_array();
			if(!empty($row))
			{
				unlink('static/uploads/hfafamilydocument/'.$row['name']);
				$sqlDel="delete from `hfa_familydocuments` where `id`='".$id."'";
				$this->db->query($sqlDel);
			}
		}
		
		function hfafamilyDetail($id,$notid)
		{
			$sql="select * from `hfa_one` where `id`='".$id."'";
			$query=$this->db->query($sql);
			$client=$query->row_array();
			
			if(!empty($client))
			{if(!empty($notid)){
				$agreement=$this->hfafamilydocument($notid);
				if(!empty($agreement))
					$client['agreement']=$agreement;
			}
			}
			return $client;
		}
		function hfa_familydocument_upload($id,$file,$notid)
		{
			$sql="insert into `hfa_familydocuments`  (`hfa_id`,`note_id`,`name`,`date`) value(?,?,?,?)";
			$this->db->query($sql,array($id,$notid,$file,date('Y-m-d H:i:s')));
		}
		
		function savefamilynote($data){
		
			$this->db->insert('hfa_family_notes',$data);
			return $this->db->insert_id();
		
		}
		function editfamilynote($data,$id){
			$this->db->where('id', $id);
    $this->db->update('hfa_family_notes',$data);
	return $id;
		}
		
		function fanilynotedetail($id){
			$query=$this->db->query("SELECT hfa_family_notes.*,count(hfa_familydocuments.note_id) as totaldoc FROM `hfa_family_notes` left join hfa_familydocuments on hfa_family_notes.id=hfa_familydocuments.note_id where hfa_family_notes.hfa_id='".$id."' GROUP by hfa_family_notes.id order by hfa_family_notes.id DESC");
			return $query->result_array();
			
		}
		function getfamilynoteinfo($not){
			$this->db->from('hfa_family_notes');

    $this->db->where('id', $not );

    $query = $this->db->get();
	return $query->row_array();
			
		}
		function deletenote($id){
			$this->db->select("name,id");
			$this->db->from('hfa_familydocuments');

    $this->db->where('note_id', $id );

    $query = $this->db->get();
	$doc= $query->result_array();
	if(!empty($doc)){
		foreach($doc as $val){
			@unlink('static/uploads/hfafamilydocument/'.$val['name']);
				
			

		}
	}
		$sqlDel1="delete from `hfa_familydocuments` where `note_id`='".$id."'";
				$this->db->query($sqlDel1);
		$sqlDel="delete from `hfa_family_notes` where `id`='".$id."'";
				$this->db->query($sqlDel);
			

	
			

		}
		function bookmarkstatuschangesubmit($data){
			$this->db->where('id', $data['host']);
    $this->db->update('hfa_one',array("hfa_bookmark"=>$data['status']));
			
		}
		function deletehfadetail($data){
			$c=$data['c']-1;
			if($data['type']=='bedroom'){
				
				$this->db->where('id',$data['bid']);
				$this->db->delete('hfa_bedrooms');
				$this->db->where('id', $data['id']);
			$this->db->update('hfa_two',array("bedrooms_avail"=>$c));
				
			}else if($data['type']=='member'){
				$this->db->where('id',$data['bid']);
				$this->db->delete('hfa_members');
				$this->db->where('id', $data['id']);
			$this->db->update('hfa_three',array("family_members"=>$c));
				

			}
			
			else{
				$c=$data['c']-1;
				$this->db->where('id',$data['bid']);
				$this->db->delete('hfa_bathrooms');
				$this->db->where('id', $data['id']);
			$this->db->update('hfa_two',array("bathrooms"=>$c));
			}	
		}
		function nominatedfmailyname($id){
			$this->db->select("fname,lname");
			$query=$this->db->get_where("hfa_one",array("id"=>$id));
			$d=$query->row_array();
			return ucfirst(@$d['fname']).' '.@$d['lname'];
			
			
		}
		function nominatedstudentdetail($id){
			$this->db->select("id,fname,lname,nominaton_created");
			$query=$this->db->get_where("sha_one",array("nominated_hfa_id"=>$id));
			return $query->result_array();
			
			
		}
		function deletenominationstudent($id){
			$sql="update `sha_one` set `nominated_hfa_id`='' ,`nominaton_created`='' where `id`='".$id."'";
			$this->db->query($sql);
			$sql1="update `sha_one` set `homestay_nomination`='0' where `id`='".$id."'";
		$this->db->query($sql1);
		}
		function totalnominatedfmaily($id){
			$sql="select * from `sha_one` where  `nominated_hfa_id`='".$id."'";
		$query=$this->db->query($sql);
		return $query->num_rows();
			
		}
		
	function canDeactivateRoom($roomId)
	{
		$queryRoom=$this->db->query("select * from `hfa_bedrooms` where `id`='".$roomId."'");
		$room=$queryRoom->row_array();
		if($room['avail']=='1' ||($room['avail']=='0' && $room['avail_from'] < date('Y-m-d')))
		{
				$query=$this->db->query("select * from `bookings` where `room`='".$roomId."'");
				if($query->num_rows()>0)
				{
					$bookings=$query->result_array();
					$movedCancelled=false;
					$others=false;
					foreach($bookings as $book)
					{
						if(in_array($book['status'],array('moved_out','cancelled')))
							$movedCancelled=true;
						else
							$others=true;
					}
					if($movedCancelled && !$others)
						$return=true;
					else
						$return=false;
				}
				else
					$return=false;
		}
		else
			$return=false;
		
		return $return;	
	}
	
	function hfaRoomDeactivate($roomId)
	{
		$availFrom=date('Y-m-d',strtotime('+50 years'));
		$this->db->query("update `hfa_bedrooms` set `avail`='0', `avail_from`='".$availFrom."', `avail_to`='0000-00-00' where `id`='".$roomId."'");
	}
	
	function callLog($id)
	{
		$query=$this->db->query("select * from `hfa_call_log` where `hfa_id`='".$id."' order by `date` DESC");
		return $query->result_array();
	}
	
	function visits($id)
	{
		$query=$this->db->query("select * from `hfa_visitReport` where `hfa_id`='".$id."' order by `date` DESC");
		return $query->result_array();
	}
	
	function addCallLog($data)
	{
		$date=normalToMysqlDate($data['hfaCallLog_date']);
		$time=normalToMysqlTime($data['hfaCallLog_time']);
		$dateCalled=$date.' '.$time;
		
		$sql="insert into `hfa_call_log` (`hfa_id`,`date_called`,`employee`,`reason`,`date`) values (?,?,?,?,?)";
		$this->db->query($sql,array($data['hfaCallLog_hfaId'],$dateCalled,$data['hfaCallLog_emp'],trim($data['hfaCallLog_reason']),date('Y-m-d H:i:s')));
	}
	
	function addNewVisit($data)
	{
		$date=normalToMysqlDate($data['hfaAddNewVisit_date']);
		$time=normalToMysqlTime($data['hfaAddNewVisit_time']);
		$dateCalled=$date.' '.$time;
		
		$revisit='0';
		$getHfaOneAppDetails=getHfaOneAppDetails($data['hfaAddNewVisit_hfaId']);
		if($getHfaOneAppDetails['revisit']=='1')
			$revisit='1';
			
		$sqlRevisit="update `hfa_one` set `revisit`='0',`date_status_changed`='".$dateCalled."' where `id`='".$data['hfaAddNewVisit_hfaId']."'";
		$this->db->query($sqlRevisit);
		
		$sql="insert into `hfa_visitReport` (`hfa_id`,`date_visited`,`employee`,`revisit`,`date`) values (?,?,?,?,?)";
		$this->db->query($sql,array($data['hfaAddNewVisit_hfaId'],$dateCalled,$data['hfaAddNewVisit_emp'],$revisit,date('Y-m-d H:i:s')));
	}
	
	function revisitInfoSubmit($data)
	{
		$date=normalToMysqlDate($data['hfaRevisitPop_date']);
		$time=normalToMysqlTime($data['hfaRevisitPop_time']);
		$dateCalled=$date.' '.$time;
		
		/*$sql="insert into `hfa_revisit_history` (`hfa_id`,`date_visited`,`employee`,`comments`,`date`) values (?,?,?,?,?)";
		$this->db->query($sql,array($data['hfaRevisitPop_hfaId'],$dateCalled,$data['hfaRevisitPop_emp'],trim($data['hfaRevisitPop_comments']),date('Y-m-d H:i:s')));*/
		
		$sql="insert into `hfa_visitReport` (`hfa_id`,`date_visited`,`employee`,`revisit`,`comments`,`date`) values (?,?,?,?,?,?)";
		$this->db->query($sql,array($data['hfaRevisitPop_hfaId'],$dateCalled,$data['hfaRevisitPop_emp'],'1',trim($data['hfaRevisitPop_comments']),date('Y-m-d H:i:s')));
		$visitId=$this->db->insert_id();
		
		
		$sqlRevisit="update `hfa_one` set `revisit`='0',`date_status_changed`='".$dateCalled."' where `id`='".$data['hfaRevisitPop_hfaId']."'";
		$this->db->query($sqlRevisit);
	}
	
	function revisit_history($id)
	{
		$query=$this->db->query("select * from `hfa_revisit_history` where `hfa_id`='".$id."' order by `date` DESC");
		return $query->result_array();
	}
	
	function hfaOfficeUseRevisitDurationFormSubmit($data)
	{
		$sql="update `hfa_one` set `revisit_duration`='".$data['revisit_duration']."' where `id`='".$data['id']."'";
		$this->db->query($sql);
	}
	
	function visitReport($id)
	{
		$res=$this->db->query("select * from `hfa_visitReport` where `id`='".$id."' order by `date` DESC")->row_array();
		if(!empty($res))
			$res['bedrooms']=$this->db->query("select * from `hfa_visitReport_beds` where `report_id`='".$id."' and  `bed_id` IN(select `id` from `hfa_bedrooms` where `application_id`='".$res['hfa_id']."') order by `id`")->result_array();
		return $res;
	}
	
	function visitReport_submit($data)
	{
		foreach($data as $index=>$input)
		{
			if($index!='vr_bed')
				$data[$index]=trim($data[$index]);
			if($data[$index]=='')
			{
				if(isset($data[$index.'_comments']))
					$data[$index.'_comments']='';	
			}
		}
		
		if($data['living_areaSF']=='')
			$data['living_area_commentsSF']='';
		if($data['living_areaTF']=='')
			$data['living_area_commentsTF']='';
		if($data['dining_areaSF']=='')
			$data['dining_area_commentsSF']='';
		if($data['dining_areaTF']=='')
			$data['dining_area_commentsTF']='';	
		if($data['kitchen_areaSF']=='')
			$data['kitchen_area_commentsSF']='';
		if($data['kitchen_areaTF']=='')
			$data['kitchen_area_commentsTF']='';
		if($data['laundrySF']=='')
			$data['vr_laundry_commentsSF']='';
		if($data['laundryTF']=='')
			$data['vr_laundry_commentsTF']='';	
		if($data['laundry']=='')
			$data['vr_laundry_comments']='';	
				
		$newFieldWithComments=['living_area','dining_area','kitchen_area'];
		foreach($newFieldWithComments as $nFWC)
		{
			if($data[$nFWC]=='')
				$data[$nFWC.'_comments']='';
		}
		
		if($data['laundry']=='' || $data['laundry']=='0')
			$data['laundry_location']='';
		if($data['laundrySF']=='' || $data['laundrySF']=='0')
			$data['laundry_locationSF']='';
		if($data['laundryTF']=='' || $data['laundryTF']=='0')
			$data['laundry_locationTF']='';		
					
			
		//$sql="UPDATE `hfa_visitReport` SET `exterior`=?,`exterior_commnets`=?,`interior`=?,`interior_comments`=?,`homeliness`=?,`homeliness_comments`=?,`cleanliness`=?,`cleanliness_comments`=?,`family_warmth`=?,`family_warmth_comments`=?,`floor_type`=?,`no_of_bedrooms`=?,`no_of_bedrooms_used`=?,`no_of_bathrooms`=?,`no_of_bathrooms_used`=?,`smoke_alarm`=?,`smoke_alarm_info`=?,`floor_type_SF`=?,`no_of_bedrooms_SF`=?,`no_of_bedrooms_used_SF`=?,`no_of_bathrooms_SF`=?,`no_of_bathrooms_used_SF`=?,`smoke_alarm_SF`=?,`smoke_alarm_info_SF`=?,`sa_living`=?,`sa_living_comments`=?,`sa_dining`=?,`sa_dining_comments`=?,`sa_kitchen`=?,`sa_kitchen_comments`=?,`sa_laundry`=?,`sa_laundry_comments`=?,`sa_backyard`=?,`sa_backyard_comments`=?,`sa_internet`=?,`sa_internet_comments`=?,`sa_key`=?,`sa_key_comments`=?,`granny_flat`=?,`granny_flat_comments`=?,`sep_entrance`=?,`sep_entrance_comments`=?,`pool`=?,`pool_comments`=?,`anything`=?,`anything_comments`=?,`camera`=?,`camera_comments`=?,`host_exp`=?,`multicultural`=?,`interest`=?,`religious`=?,`here_referral`=?,`here_adv_media`=?,`here_fb`=?,`comments`=? where `id`=?";
		$sql="UPDATE `hfa_visitReport` SET `exterior`=?,`exterior_commnets`=?,`interior`=?,`interior_comments`=?,`homeliness`=?,`homeliness_comments`=?,`cleanliness`=?,`cleanliness_comments`=?,`family_warmth`=?,`family_warmth_comments`=?,`floor_type`=?,`no_of_bedrooms`=?,`no_of_bedrooms_used`=?,`no_of_bathrooms`=?,`no_of_bathrooms_used`=?,`smoke_alarm`=?,`smoke_alarm_info`=?,`living_area`=?,`living_area_comments`=?,`dining_area`=?,`dining_area_comments`=?,`kitchen_area`=?,`kitchen_area_comments`=?,`laundry`=?,`laundry_location`=?,`laundry_comments`=?,`floor_type_SF`=?,`no_of_bedrooms_SF`=?,`no_of_bedrooms_used_SF`=?,`no_of_bathrooms_SF`=?,`no_of_bathrooms_used_SF`=?,`smoke_alarm_SF`=?,`smoke_alarm_info_SF`=?,`living_area_SF`=?,`living_area_comments_SF`=?,`dining_area_SF`=?,`dining_area_comments_SF`=?,`kitchen_area_SF`=?,`kitchen_area_comments_SF`=?,`laundry_SF`=?,`laundry_location_SF`=?,`laundry_comments_SF`=?,`floor_type_TF`=?,`no_of_bedrooms_TF`=?,`no_of_bedrooms_used_TF`=?,`no_of_bathrooms_TF`=?,`no_of_bathrooms_used_TF`=?,`smoke_alarm_TF`=?,`smoke_alarm_info_TF`=?,`living_area_TF`=?,`living_area_comments_TF`=?,`dining_area_TF`=?,`dining_area_comments_TF`=?,`kitchen_area_TF`=?,`kitchen_area_comments_TF`=?,`laundry_TF`=?,`laundry_location_TF`=?,`laundry_comments_TF`=?,`sa_backyard`=?,`sa_backyard_comments`=?,`sa_internet`=?,`sa_internet_comments`=?,`sa_key`=?,`sa_key_comments`=?,`granny_flat`=?,`granny_flat_comments`=?,`sep_entrance`=?,`sep_entrance_comments`=?,`pool`=?,`pool_comments`=?,`anything`=?,`anything_comments`=?,`camera`=?,`camera_comments`=?,`host_exp`=?,`multicultural`=?,`interest`=?,`religious`=?,`u18_compatible`=?,`here_referral`=?,`here_adv_media`=?,`here_fb`=?,`comments`=? where `id`=?";
		//$this->db->query($sql,array($data['vr_exterior'], $data['vr_exterior_comments'],$data['vr_interior'], $data['vr_interior_comments'],$data['vr_homeliness'], $data['vr_homeliness_comments'], $data['vr_clean'], $data['vr_clean_comments'], $data['vr_familyWarmth'], $data['vr_familyWarmth_comments'], $data['vr_floor_Type'], $data['vr_no_of_bedrooms'], $data['vr_no_of_bedrooms_used'], $data['vr_no_of_bathrooms'], $data['vr_no_of_bathrooms_used'], $data['vr_smoke_alarm'], $data['vr_smoke_alarm_info'], $data['vr_floor_TypeSF'], $data['vr_no_of_bedroomsSF'], $data['vr_no_of_bedrooms_usedSF'], $data['vr_no_of_bathroomsSF'], $data['vr_no_of_bathrooms_usedSF'], $data['vr_smoke_alarmSF'], $data['vr_smoke_alarm_infoSF'], $data['vr_sa_living_area'], $data['vr_sa_living_area_comments'], $data['vr_sa_dining_area'], $data['vr_sa_dining_area_comments'], $data['vr_sa_kitchen'], $data['vr_sa_kitchen_comments'], $data['vr_sa_laundry'], $data['vr_sa_laundry_comments'], $data['vr_sa_backyard'], $data['vr_sa_backyard_comments'], $data['vr_sa_internet'], $data['vr_sa_internet_comments'], $data['vr_sa_key'], $data['vr_sa_key_comments'], $data['vr_granny_flat'], $data['vr_granny_flat_comments'], $data['vr_sep_entrance'], $data['vr_sep_entrance_comments'], $data['vr_pool'], $data['vr_pool_comments'], $data['vr_anything'], $data['vr_anything_comments'], $data['vr_camera'], $data['vr_camera_comments'],$data['vr_host_exp'], $data['vr_multicultural'], $data['vr_interest'], $data['vr_religious'], $data['vr_referral'], $data['vr_adv_media'], $data['vr_fb'], $data['vr_comments']  , $data['visit_id']));
		$this->db->query($sql,array($data['vr_exterior'], $data['vr_exterior_comments'],$data['vr_interior'], $data['vr_interior_comments'],$data['vr_homeliness'], $data['vr_homeliness_comments'], $data['vr_clean'], $data['vr_clean_comments'], $data['vr_familyWarmth'], $data['vr_familyWarmth_comments'], $data['vr_floor_Type'], $data['vr_no_of_bedrooms'], $data['vr_no_of_bedrooms_used'], $data['vr_no_of_bathrooms'], $data['vr_no_of_bathrooms_used'], $data['vr_smoke_alarm'], $data['vr_smoke_alarm_info'],$data['living_area'],$data['living_area_comments'],$data['dining_area'],$data['dining_area_comments'],$data['kitchen_area'],$data['kitchen_area_comments'],$data['laundry'],$data['laundry_location'],$data['vr_laundry_comments'], $data['vr_floor_TypeSF'], $data['vr_no_of_bedroomsSF'], $data['vr_no_of_bedrooms_usedSF'], $data['vr_no_of_bathroomsSF'], $data['vr_no_of_bathrooms_usedSF'], $data['vr_smoke_alarmSF'], $data['vr_smoke_alarm_infoSF'],$data['living_areaSF'],$data['living_area_commentsSF'],$data['dining_areaSF'],$data['dining_area_commentsSF'],$data['kitchen_areaSF'],$data['kitchen_area_commentsSF'],$data['laundrySF'],$data['laundry_locationSF'],$data['vr_laundry_commentsSF'],$data['vr_floor_TypeTF'],$data['vr_no_of_bedroomsTF'],$data['vr_no_of_bedrooms_usedTF'],$data['vr_no_of_bathroomsTF'],$data['vr_no_of_bathrooms_usedTF'],$data['vr_smoke_alarmTF'],$data['vr_smoke_alarm_infoTF'],$data['living_areaTF'],$data['living_area_commentsTF'],$data['dining_areaTF'],$data['dining_area_commentsTF'],$data['kitchen_areaTF'],$data['kitchen_area_commentsTF'],$data['laundryTF'],$data['laundry_locationTF'],$data['vr_laundry_commentsTF'], $data['vr_sa_backyard'], $data['vr_sa_backyard_comments'], $data['vr_sa_internet'], $data['vr_sa_internet_comments'], $data['vr_sa_key'], $data['vr_sa_key_comments'], $data['vr_granny_flat'], $data['vr_granny_flat_comments'], $data['vr_sep_entrance'], $data['vr_sep_entrance_comments'], $data['vr_pool'], $data['vr_pool_comments'], $data['vr_anything'], $data['vr_anything_comments'], $data['vr_camera'], $data['vr_camera_comments'],$data['vr_host_exp'], $data['vr_multicultural'], $data['vr_interest'], $data['vr_religious'], $data['vr_u18_compatible'], $data['vr_referral'], $data['vr_adv_media'], $data['vr_fb'], $data['vr_comments']  , $data['visit_id']));
		
		foreach($data['vr_bed'] as $beds)
		{
			foreach($beds as $bIndex=>$bed)
			{
				if($beds[$bIndex]=='')
				{
					if(isset($beds[$bIndex.'_comments']))
						$beds[$bIndex.'_comments']='';
				}
			}
			
			if($beds['bed']=='' && $beds['wardrobe']=='' && $beds['window']=='' && $beds['desk_chair']=='' && $beds['bedroom_size']=='' && $beds['door_lock']=='' && $beds['private_bathroom']=='')
				$this->db->query("delete from `hfa_visitReport_beds`  where `report_id`=? and  `bed_id`=?",array($data['visit_id'], $beds['id']));
			else
			{	
				$querySel=$this->db->query("select * from `hfa_visitReport_beds` where `report_id`=? and `bed_id`=?",array($data['visit_id'], $beds['id']));
				if($querySel->num_rows()>0)
				{
					$sqlUdate="update `hfa_visitReport_beds` set `bed`=?, `bed_comments`=?, `wardrobe`=?, `wardrobe_comments`=?, `window`=?, `window_comments`=?, `desk_chair`=?, `desk_chair_comments`=?, `bedroom_size`=?, `bedroom_size_comments`=?, `door_lock`=?, `door_lock_comments`=?, `private_bathroom`=?, `private_bathroom_comments`=? where `report_id`=? and  `bed_id`=?";
					$this->db->query($sqlUdate,array($beds['bed'], $beds['bed_comments'], $beds['wardrobe'], $beds['wardrobe_comments'], $beds['window'], $beds['window_comments'], $beds['desk_chair'], $beds['desk_chair_comments'], $beds['bedroom_size'], $beds['bedroom_size_comments'], $beds['door_lock'], $beds['door_lock_comments'], $beds['private_bathroom'], $beds['private_bathroom_comments'],$data['visit_id'], $beds['id']));
				}
				else
				{
					$sqlBed="INSERT INTO `hfa_visitReport_beds`(`report_id`, `bed_id`, `bed`, `bed_comments`, `wardrobe`, `wardrobe_comments`, `window`, `window_comments`, `desk_chair`, `desk_chair_comments`, `bedroom_size`, `bedroom_size_comments`, `door_lock`, `door_lock_comments`, `private_bathroom`, `private_bathroom_comments`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
					$this->db->query($sqlBed, array($data['visit_id'], $beds['id'], $beds['bed'], $beds['bed_comments'], $beds['wardrobe'], $beds['wardrobe_comments'], $beds['window'], $beds['window_comments'], $beds['desk_chair'], $beds['desk_chair_comments'], $beds['bedroom_size'], $beds['bedroom_size_comments'], $beds['door_lock'], $beds['door_lock_comments'], $beds['private_bathroom'], $beds['private_bathroom_comments']));
				}
			}
		}
		
	}
	
	function callLog_delete($id)
	{
		$this->db->query("delete from `hfa_call_log` where `id`='".$id."'");
	}
	
	function visitReport_delete($id)
	{
		$this->db->query("delete from `hfa_visitReport` where `id`='".$id."'");
	}
	
	function collegeApprovalList($id)
	{
		$query=$this->db->query("select * from `hfa_college_approval` where `hfa_id`='".$id."' order by `date_submitted` DESC");
		return $query->result_array();
	}
	
	function addCApprovalSubmit($data)
	{
		$date=normalToMysqlDate($data['addCApproval_date']);
		$this->db->query("insert into `hfa_college_approval` (`hfa_id`,`college_id`,`date`,`date_submitted`) values('".$data['hfa_id']."','".$data['addCApproval_college']."','".$date."','".date('Y-m-d H:i:s')."')");
	}
	
	function cApprovalDel($id)
	{
		$this->db->query("delete from `hfa_college_approval` where `id`='".$id."'");
	}
	
	function incidentsByHfaId($id)
	{
		return $this->db->query("select * from `booking_incidents` where `hfa_id`='".$id."' order by `incident_date` DESC, `id` DESC")->result_array();
	}
	
	function getVisitReportBedInfo($reportId)
	{
		return $this->db->query("select * from `hfa_visitReport_beds` where `report_id`='".$reportId."' order by `id`")->result_array();
	}
	
	function feedbacksByHfaId($id)
	{
		return $this->db->query("select * from `booking_feedbacks` where `host`='".$id."' order by `date` DESC")->result_array();
	}
	
	function addNewTransportInfo($data)
	{
		if(isset($data['transportId']))
		{
			$sql="update `hfa_transport` set `college_id`=?,`type`=?,`travel_time`=?,`description`=?,`gmap_link`=? where `id`=?";
			$this->db->query($sql,array($data['transportClg'],$data['transportType'],$data['transportTravelTime'],$data['transportDesc'],$data['transportGMapLink'],$data['transportId']));
		}
		else
		{
			$sql="insert into `hfa_transport` (`hfa_id`,`college_id`,`type`,`travel_time`,`description`,`gmap_link`,`date`) values (?,?,?,?,?,?,?)";
			$this->db->query($sql,array($data['transportHfaId'],$data['transportClg'],$data['transportType'],$data['transportTravelTime'],$data['transportDesc'],$data['transportGMapLink'],date('Y-m-d H:i:s')));
		}
	}
	
	function transportInfoByHfaId($id)
	{
		return $this->db->query("select * from `hfa_transport` where `hfa_id`='".$id."' order by `date` DESC")->result_array();
	}
	
	function transportInfoDetails($id)
	{
		return $this->db->query("select * from `hfa_transport` where `id`='".$id."' ")->row_array();
	}
	
	function hfaTransportInfo_delete($id)
	{
		$this->db->query("delete from `hfa_transport` where `id`='".$id."'");
	}
	
	function addNewWarning($data)
	{
		if($data['warningId']!='')
		{
			$sql="update `hfa_warnings` set `emp`=?,`to`=?,`method`=?,`subject`=?,`content`=? where `id`=?";
			$this->db->query($sql,array($data['hfaWarningSend_emp'],$data['hfaWarningSend_to'],$data['hfaWarningSend_method'],$data['hfaWarningSend_subject'],$data['hfaWarningSend_emailContent'],$data['warningId']));
			return $data['warningId'];
		}
		else
		{
			$sql="insert into `hfa_warnings` (`hfa_id`,`emp`,`to`,`method`,`subject`,`content`,`date`) values (?,?,?,?,?,?,?)";
			$this->db->query($sql,array($data['hfaWarningSend_hfaId'],$data['hfaWarningSend_emp'],$data['hfaWarningSend_to'],$data['hfaWarningSend_method'],$data['hfaWarningSend_subject'],$data['hfaWarningSend_emailContent'],date('Y-m-d H:i:s')));
			//echo $this->db->last_query();
			return $this->db->insert_id();
		}
	}
	
	function warningsByHfaId($id)
	{
		return $this->db->query("select * from `hfa_warnings` where `hfa_id`='".$id."' order by `date` DESC")->result_array();
	}
	
	function hfaWarningDetails($id)
	{
		return $this->db->query("select * from `hfa_warnings` where `id`='".$id."' ")->row_array();
	}
	
	function hfaWarningDoc_upload($id,$file)
	{
		$sql="insert into `hfa_warnings_docs`  (`warning_id`,`name`,`date`) value(?,?,?)";
		$this->db->query($sql,array($id,$file,date('Y-m-d H:i:s')));
	}

	function hfaWarningDocs($id)
	{
		return $this->db->query("select * from `hfa_warnings_docs` where `warning_id`='".$id."' order by `date` DESC")->result_array();
	}

	function deleteHfaWarningDoc($id)
	{
		$hfaId='0';
		$sql="select * from `hfa_warnings_docs` where `id`='".$id."'";
		$query=$this->db->query($sql);
		$row=$query->row_array();
		if(!empty($row))
		{
			$warning=$this->db->query("select * from `hfa_warnings` where `id`='".$row['warning_id']."'")->row_array();
			unlink('static/uploads/hfaWarningDoc/'.$row['name']);
			$sqlDel="delete from `hfa_warnings_docs` where `id`='".$id."'";
			$this->db->query($sqlDel);
			$hfaId=$warning['hfa_id'];
		}
		return $hfaId;
	}

	function hfaWarning_delete($id)
	{
		$this->db->query("delete from `hfa_warnings` where `id`='".$id."'");
		
		$docs=$this->db->query("select * from `hfa_warnings_docs` where `warning_id`=?",array($id))->result_array();
		foreach($docs as $doc)
		{
			unlink('static/uploads/hfaWarningDoc/'.$doc['name']);
			$this->db->query("delete from `hfa_warnings_docs` where `id`='".$doc['id']."'");
		}
	}
	
	function visitReportDateEditSubmit($data)
	{
		$date=normalToMysqlDate($data['hfaEditVisitReportDate_date']);
		$time=normalToMysqlTime($data['hfaEditVisitReportDate_time']);
		$dateCalled=$date.' '.$time;		
		$this->db->query("update `hfa_visitReport` set `date_visited`=? where `id`=?",array($dateCalled,$data['hfaEditVisitReportDate_id']));
	}
	
	function visitReportCopySubmit($data)
	{
		$date=normalToMysqlDate($data['hfaCopyVisitReport_date']);
		$time=normalToMysqlTime($data['hfaCopyVisitReport_time']);
		$dateCalled=$date.' '.$time;		
		
		$visitReport=$this->visitReport($data['hfaCopyVisitReport_reportId']);
		if(!empty($visitReport))
		{
			$insertData=$visitReport;
			unset($insertData['id']);
			unset($insertData['bedrooms']);
			$insertData['date_visited']=$dateCalled;
			$insertData['employee']=$data['hfaCopyVisitReport_emp'];
			$insertData['date']=date('Y-m-d H:i:s');
			$sql="INSERT INTO `hfa_visitReport`(`hfa_id`, `date_visited`, `revisit`, `employee`, `exterior`, `exterior_commnets`, `interior`, `interior_comments`, `homeliness`, `homeliness_comments`, `cleanliness`, `cleanliness_comments`, `family_warmth`, `family_warmth_comments`, `floor_type`, `no_of_bedrooms`, `no_of_bedrooms_used`, `no_of_bathrooms`, `no_of_bathrooms_used`, `smoke_alarm`, `smoke_alarm_info`, `floor_type_SF`, `no_of_bedrooms_SF`, `no_of_bedrooms_used_SF`, `no_of_bathrooms_SF`, `no_of_bathrooms_used_SF`, `smoke_alarm_SF`, `smoke_alarm_info_SF`, `sa_living`, `sa_living_comments`, `sa_dining`, `sa_dining_comments`, `sa_kitchen`, `sa_kitchen_comments`, `sa_laundry`, `sa_laundry_comments`, `sa_backyard`, `sa_backyard_comments`, `sa_internet`, `sa_internet_comments`, `sa_key`, `sa_key_comments`, `granny_flat`, `granny_flat_comments`, `sep_entrance`, `sep_entrance_comments`, `pool`, `pool_comments`, `anything`, `anything_comments`, `camera`, `camera_comments`, `host_exp`, `multicultural`, `interest`, `religious`, `here_referral`, `here_adv_media`, `here_fb`, `someone_at_home`, `someone_at_home_comments`, `single_parent`, `single_parent_comments`, `2parents`, `2parents_comments`, `strength`, `weakness`, `comments`, `date`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$this->db->query($sql,$insertData);
			$reportId=$this->db->insert_id();
			
			if(!empty($visitReport['bedrooms']))
			{
				$inserDataBeds=$visitReport['bedrooms'];
				foreach($inserDataBeds as $bedData)
				{
					unset($bedData['id']);
					$bedData['report_id']=$reportId;
					
					$sqlBed="INSERT INTO `hfa_visitReport_beds`(`report_id`, `bed_id`, `bed`, `bed_comments`, `wardrobe`, `wardrobe_comments`, `window`, `window_comments`, `desk_chair`, `desk_chair_comments`, `bedroom_size`, `bedroom_size_comments`, `door_lock`, `door_lock_comments`, `private_bathroom`, `private_bathroom_comments`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
					$this->db->query($sqlBed, $bedData);
				}
			}
		}
	}	
	
	function nominationHistory($id)
	{
		$sql="select * from `bookings` where student IN (select `id` from `sha_one` where `homestay_nomination`='1' and `nominated_hfa_id`=?) and `host`=?";
		return $this->db->query($sql,array($id,$id))->result_array();
	}
	
	function swapFamilyMember($memberId, $swapOrder)
	{
		$memberFirst=$this->db->query("select * from `hfa_members` where `id`='".$memberId."'")->row_array();
		//$this->rearrangeFamilyMembers($memberFirst['application_id']);//if there is no sort order set on members( means all have value 0 for member_order) then we have to set its value first
		//$memberFirst=$this->db->query("select * from `hfa_members` where `id`='".$memberId."'")->row_array();//fetching this again as menu order have changed after rearranging
		
		$memberSecond=$this->db->query("select * from `hfa_members` where `member_order`='".$swapOrder."' and `application_id`='".$memberFirst['application_id']."'")->row_array();
		
		$this->db->query("update `hfa_members` set `member_order`='".$memberSecond['member_order']."' where `id`='".$memberId."'");
		$this->db->query("update `hfa_members` set `member_order`='".$memberFirst['member_order']."' where `id`='".$memberSecond['id']."'");
		
		if($swapOrder=='1')
		{
			$this->db->query("update `hfa_members` set `primary_member`='1' where `id`='".$memberId."'");
			$this->db->query("update `hfa_members` set `primary_member`='0' where `id`='".$memberSecond['id']."'");
			
			$this->db->query("update `hfa_one` set `title`=?, `fname`=?, `lname`=? where `id`=?", array($memberFirst['title'],$memberFirst['fname'],$memberFirst['lname'],$memberFirst['application_id']));
			if(trim($memberFirst['contact_number'])!='')
			{
				$this->db->query("update `hfa_one` set `mobile`=? where `id`=?", array($memberFirst['contact_number'],$memberFirst['application_id']));	
			}
			else
			{
				$this->db->query("update `hfa_members` set `contact_number`=? where `id`=?", array($memberSecond['contact_number'],$memberFirst['id']));	
			}
		}
		return $memberFirst['application_id'];
	}
	
	function rearrangeFamilyMembers($id)
	{
		$members=$this->db->query("select * from `hfa_members` where `application_id`='".$id."' order by `primary_member` DESC, `id`")->result_array();
		if(!empty($members))
		{
			if($members[0]['member_order']==0)
			{
				foreach($members as $memK=>$mem)
				{
					$memberOrder=$memK+1;
					$this->db->query("update `hfa_members` set `member_order`=? where `id`=?",array($memberOrder,$mem['id']));
				}
			}
		}
	}
}