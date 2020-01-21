<?php 

class Form_model extends CI_Model { 

	function hfaAppCheckByEmail($email)
	{
		$sql="select * from `hfa_one` where `email`='".$email."'";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	
	function getHfaOneAppDetails($id)
	{
		$sql="select * from `hfa_one` where `id`='".$id."'";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	
	
	function hfaAppCheckStepTwo($id)
	{
		$sql="select * from `hfa_two` where `id`='".$id."'";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	
	function hfaAppCheckStepThree($id)
	{
		$sql="select * from `hfa_three` where `id`='".$id."'";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	
	function hfaAppCheckStepFour($id)
	{
		$sql="select * from `hfa_four` where `id`='".$id."'";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	
	function hfaAppCheckStep($id)
	{
		$step=0;
		$one=getHfaOneAppDetails($id);
		if(!empty($one))
		{
			$two=$this->hfaAppCheckStepTwo($id);
			if(!empty($two))
			{
				$three=$this->hfaAppCheckStepThree($id);
				if(!empty($three))
				{
					$four=$this->hfaAppCheckStepFour($id);
					if(!empty($four))
						$step=5;
					else
						$step=4;
				}
				else
					$step=3;
			}
			else
				$step=2;
		}
		else
			$step=1;
			
		return $step;	
	}
	
	function host_family_application_one_submit($data)
	{
		if($data['hfa_ref']!=7)
			$data['hfa_ref_other']='';
		if($data['hfa_ref']!=2)
			$data['hfa_ref_homestay_family']='';
			
		$date=date('Y-m-d H:i:s');
		$sql="insert into `hfa_one` (`title`, `fname`, `lname`, `email`, `mobile`, `home_phone`, `work_phone`, `contact_way`, `contact_time`, `family_members`, `street`, `suburb`, `postcode`, `state`, `postal_address`, `street_postal`, `suburb_postal`, `postcode_postal`, `state_postal`, `date`,`hfa_registered_status`, `ref`, `ref_other`, `ref_homestay_family`, `EC_name`, `EC_relation`, `EC_phone`, `EC_email`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$this->db->query($sql,array($data['hfa_name_title'],ucwords($data['hfa_fname']),strtoupper($data['hfa_lname']),$data['hfa_email'],$data['hfa_number'],$data['hfa_home_phone'],$data['hfa_work_phone'],$data['hfa_contact_way'],$data['hfa_contact_time'],$data['hfa_family_member'],$data['hfa_street_address'],$data['hfa_suburb'],$data['hfa_postcode'],$data['hfa_state'],$data['hfa_postal_address'],$data['hfa_street_address_postal'],$data['hfa_suburb_postal'],$data['hfa_postcode_postal'],$data['hfa_state_postal'],$date,$data['hfa_registered_status'],$data['hfa_ref'],$data['hfa_ref_other'],$data['hfa_ref_homestay_family'],$data['hfa_EC_name'],$data['hfa_EC_relation'],$data['hfa_EC_phone'],$data['hfa_EC_email']));	
		$appId=$this->db->insert_id();
		
		if($data['hfa_registered_status']=='Offline')
			recentActionsAddData('hfa',$appId,'add');
		
		return $appId;
	}
	
	function host_family_application_two_submit($data)
	{
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
		
		$sqlUpdate="update `hfa_two` set `d_type`=?, `floors`=?, `granny_flat`=?, `flooring`=?, `flooring_other`=?, `internet`=?, `internet_type`=?, `s_detector`=?, `bedrooms`=?, `bedrooms_avail`=?, `bathrooms`=?, `laundry`=?, `laundry_outside`=?, `home_desc`=?  where `id`=?";
		$this->db->query($sqlUpdate,array($data['hfa_dwellingType'],$data['hfa_floors'],$data['granny_flat'],$data['hfa_flooring_select'],$data['hfa_flooring_other'],$data['hfa_internet_to_students'],$data['hfa_internet_to_students_type'],$data['smoke_detector'],$data['hfa_bedroom'],$data['hfa_bedroom_avail'],$data['hfa_bathroom_input'],$data['hfa_laundry_avail'],$data['hfa_laundry_avail_outside'],$data['hfa_home_desc'],$data['id']));
		
		$sqlUpdateStep="update `hfa_one` set `step`='3'  where `id`='".$data['id']."'";
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
			$sqlDelBed="delete from `hfa_bedrooms` where `application_id`='".$data['id']."'";
			$this->db->query($sqlDelBed);
			//bedrooms
			for($x=1;$x<=$data['hfa_bedroom_avail']; $x++)
			{
				if($data['bedroom-'.$x]['hfa_room_avail_from']!='')
					$data['bedroom-'.$x]['hfa_room_avail_from']=normalToMysqlDate($data['bedroom-'.$x]['hfa_room_avail_from']);
				
				if($data['bedroom-'.$x]['hfa_room_avail_to']!='')
					$data['bedroom-'.$x]['hfa_room_avail_to']=normalToMysqlDate($data['bedroom-'.$x]['hfa_room_avail_to']);
				
				if($data['bedroom-'.$x]['hfa_room_date_leaving']!='')
					$data['bedroom-'.$x]['hfa_room_date_leaving']=normalToMysqlDate($data['bedroom-'.$x]['hfa_room_date_leaving']);
				
				if($data['bedroom-'.$x]['hfa_room_availability']=="1")
					$data['bedroom-'.$x]['hfa_room_avail_from']=$data['bedroom-'.$x]['hfa_room_avail_to']=$data['bedroom-'.$x]['hfa_hosting_student']='';
				
				if($data['bedroom-'.$x]['hfa_hosting_student']!=1)
					$data['bedroom-'.$x]['hfa_room_date_leaving']=$data['bedroom-'.$x]['student_age']=$data['bedroom-'.$x]['student_gender']=$data['bedroom-'.$x]['student_nation']='';	
					
				if($data['bedroom-'.$x]['room_flooring_select']!=5)
					$data['bedroom-'.$x]['hfa_bed_flooring_other_val']='';
				
				$sql="insert into `hfa_bedrooms` (`application_id`,`type`,`flooring`,`flooring_other`,`floor`,`access`,`granny_flat`,`internal_ensuit`,`avail`,`avail_from`,`avail_to`,`currently_hosting`,`date_leaving`,`age`,`gender`,`nation`)values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
				$this->db->query($sql,array($data['id'],$data['bedroom-'.$x]['room_select'],$data['bedroom-'.$x]['room_flooring_select'],$data['bedroom-'.$x]['hfa_bed_flooring_other_val'],$data['bedroom-'.$x]['student_room'],$data['bedroom-'.$x]['hfa_access_room'],$data['bedroom-'.$x]['flat_grany'],$data['bedroom-'.$x]['internal_ensuite'],$data['bedroom-'.$x]['hfa_room_availability'],$data['bedroom-'.$x]['hfa_room_avail_from'],$data['bedroom-'.$x]['hfa_room_avail_to'],$data['bedroom-'.$x]['hfa_hosting_student'],$data['bedroom-'.$x]['hfa_room_date_leaving'],$data['bedroom-'.$x]['student_age'],$data['bedroom-'.$x]['student_gender'],$data['bedroom-'.$x]['student_nation']));
			}
		//Bedrooms table #ENDS
		//Host Bedrooom table #STARTS

			for($x=1;$x<=($data['hfa_bedroom'] - $data['hfa_bedroom_avail']); $x++){
				if($data['hbedroom-'.$x]['hbed_id']!="")
				{
					$sql="update `hfa_bedrooms_hostfamily` set `application_id`=?,`floor`=? where `id`='".$data['hbedroom-'.$x]['hbed_id']."'";
					$this->db->query($sql,array($data['id'],$data['hbedroom-'.$x],$data['hbedroom-'.$x]['host_room']));
				}
				else
				{
					$sql="insert into `hfa_bedrooms_hostfamily` (`application_id`,`floor`)values(?,?)";
					$this->db->query($sql,array($data['id'],$data['hbedroom-'.$x]['host_room']));
				}
			}
		//Host Bedroom table #End
		
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
										
				$sql="insert into `hfa_bathrooms` (`application_id`,`avail_to_student`,`floor`,`toilet`,`shower`,`bath`,`ensuit`,`in_out`)values(?,?,?,?,?,?,?,?)";
				$this->db->query($sql,array($data['id'],$data['bathroom-'.$x]['hfa_bathroom_avail'],$data['bathroom-'.$x]['bathroom_floor'],$data['bathroom-'.$x]['bathroomHas_toilet'],$data['bathroom-'.$x]['bathroomHas_shower'],$data['bathroom-'.$x]['bathroomHas_bath'],$data['bathroom-'.$x]['hfa_room_ensuite'],$data['bathroom-'.$x]['flat_grany_bathroom']));
				//echo $this->db->last_query()."<br>";
			}
		//Bathrooms table #ENDS
	}
	
	function host_family_application_three_submit($data)
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
		
		
		if(is_array($data['hfa_pet']))
		{
			$pets = $data['hfa_pet'];
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
			$data['hfa_pet_in']='';	
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
		if(isset($_FILES['hfa_ins_file']) && $_FILES['hfa_ins_file']['name'] != "")
			{
				  $path="./static/uploads/hfa/ins"; 
				  $t1=time();
				  $imagename_ins_file=$t1.$_FILES['hfa_ins_file']['name'];
				  move_uploaded_file($_FILES['hfa_ins_file']['tmp_name'],$path.'/'.$imagename_ins_file);
			}
			
		if($data['hfa_international_student']!=1)
			$data['hfa_exp']='';
		
		if($data['hfa_religion']!="0" && $data['hfa_religion']!="")
			$data['hfa_religion_other']='';
		//echo "<pre>";
		//print_r($_POST);
		/*$sqlUpdate="update `hfa_three` set `family_members`='".$data['hfa_family_member']."', `pets`='".$data['hfa_pets']."', `pet_dog`='".$pets['dog']."', `pet_cat`='".$pets['cat']."', `pet_bird`='".$pets['bird']."', `pet_other`='".$pets['other']."', `pet_other_val`='".$pets['other_val']."', `pet_inside`='".$data['hfa_pet_in']."'";
		$sqlUpdate .=", `insurance`='".$data['hfa_insurance']."', `ins_provider`='".$data['hfa_insurance_provider']."', `ins_policy_no`='".$data['hfa_policy_number']."', `ins_expiry`='".$data['hfa_policy_expiry']."', `20_million`='".$data['hfa_liability_insurance']."', `ins_content`='".$data['hfa_content_insurance']."', `main_religion`='".$data['hfa_religion']."', `main_religion_other`='".$data['hfa_religion_other']."', `hosted_international_in_past`='".$data['hfa_international_student']."', `homestay_exp`='".$data['hfa_exp']."', `family_desc`='".$data['hfa_family_desc']."'";
		$sqlUpdate .=" where `id`='".$data['id']."'";
		$this->db->query($sqlUpdate);	*/
		
		$sqlUpdate="update `hfa_three` set `family_members`=?, `pets`=?, `pet_dog`=?, `pet_cat`=?, `pet_bird`=?, `pet_other`=?, `pet_other_val`=?, `pet_inside`=?, `pet_desc`=?";
		$sqlUpdate .=", `insurance`=?, `ins_provider`=?, `ins_policy_no`=?, `ins_expiry`=?, `ins_file`=?, `20_million`=?, `ins_content`=?, `main_religion`=?, `main_religion_other`=?, `hosted_international_in_past`=?, `homestay_exp`=?, `family_desc`=?";
		$sqlUpdate .=" where `id`=?";
		$this->db->query($sqlUpdate,array($data['hfa_family_member'],$data['hfa_pets'],$pets['dog'],$pets['cat'],$pets['bird'],$pets['other'],$pets['other_val'],$data['hfa_pet_in'],$data['hfa_pet_desc'],$data['hfa_insurance'],$data['hfa_insurance_provider'],$data['hfa_policy_number'],$data['hfa_policy_expiry'],$imagename_ins_file,$data['hfa_liability_insurance'],$data['hfa_content_insurance'],$data['hfa_religion'],$data['hfa_religion_other'],$data['hfa_international_student'],$data['hfa_exp'],$data['hfa_family_desc'],$data['id']));	
		//echo $this->db->last_query();
		
		
		$sqlUpdateStep="update `hfa_one` set `step`='4'  where `id`='".$data['id']."'";
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
				
				$imagename='';
				if(isset($_FILES['hfa_family-'.$x]['name']['wwcc_file']) && $_FILES['hfa_family-'.$x]['name']['wwcc_file'] != "")
					{
						  $path="./static/uploads/hfa/wwcc"; 
						  $t1=time();
						  $imagename=$t1.$_FILES['hfa_family-'.$x]['name']['wwcc_file'];		
						  move_uploaded_file($_FILES['hfa_family-'.$x]['tmp_name']['wwcc_file'],$path.'/'.$imagename);
					}
				
				
				$member=$data['hfa_family-'.$x];
				
				if($member['dob']!='')
					$member['dob']=normalToMysqlDate($member['dob']);
				
				if($member['wwcc_clear_expiry']!='')
					$member['wwcc_clear_expiry']=normalToMysqlDate($member['wwcc_clear_expiry']);
				if($member['contact_number']!=''){
				$num1=str_replace('-','',$member['contact_number']);
				$num1=str_replace(' ','',$num1);
				$member['contact_number']=mobileFormat($num1);
				}
	$member['other_role']=!empty($member['other_role']) ? $member['other_role'] :'';
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
	
	function host_family_application_four_submit($data)
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
		
		
		$sqlUpdateStep="update `hfa_one` set `step`='5'  where `id`='".$data['id']."'";
		$this->db->query($sqlUpdateStep);
		
		//Main table #ENDS
	}

	function shaAppCheckByEmail($email)
	{
		$sql="select * from `sha_one` where `email`='".$email."'";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	
	function sha_one_submit($data)
	{
		$date=date('Y-m-d H:i:s');
		
		if($data['sha_dob']!='')
					$data['sha_dob']=normalToMysqlDate($data['sha_dob']);
		if($data['sha_passport_expiry']!='')
					$data['sha_passport_expiry']=normalToMysqlDate($data['sha_passport_expiry']);
		if($data['sha_arrival_date']!='')
					$data['sha_arrival_date']=normalToMysqlDate($data['sha_arrival_date']);
		
		if(trim($data['sha_duration_week'])=='')
			$data['sha_duration_week']=0;			
		
		if(trim($data['sha_duration_day'])=='')
			$data['sha_duration_day']=0;
		
		$bookingTo='0000-00-00';
		if($data['sha_arrival_date']!='')
		{
			$totalDurationDays=0;
			$totalDurationDays=($data['sha_duration_week']*7)+$data['sha_duration_day'];
			if($totalDurationDays!=0)
				$bookingTo=date('Y-m-d',strtotime($data['sha_arrival_date'].' + '.$totalDurationDays.' days -1 day'));
		}
		
		$filled_by=1;
		if(isset($_POST['filled_by']))
		{
			$filled_by=$_POST['filled_by'];
			if($data['sha_email']=='')
				$data['sha_email']='no-reply@globalexperience.com.au';
		}
			
		$study_group=$sha_study_group='';
		if(isset($_POST['study_group']))
		{
			$study_group=$_POST['study_group'];
			if($study_group==1)
				$sha_study_group=$_POST['sha_study_group'];
		}
		$data['sha_mobile']=!empty($data['sha_mobile'])?$data['sha_mobile']:'0000000000';
		$sql="insert into `sha_one` (`title`, `fname`, `mname`, `lname`, `gender`, `dob`, `email`, `mobile`, `home_phone`, `accomodation_type`, `student_name2`, `nation`, `passport_no`, `passport_exp`, `arrival_date`, `booking_from`,`booking_to`, `weeks`, `days`, `date`, `filled_by`,`study_group`,`study_tour_id`,`sha_registered_status`,`sha_student_no`,`EC_name`,`EC_relation`,`EC_phone`,`EC_email`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$this->db->query($sql,array($data['sha_name_title'],ucwords($data['sha_fname']),ucwords($data['sha_mname']),strtoupper($data['sha_lname']),$data['sha_gender'],$data['sha_dob'],$data['sha_email'],$data['sha_mobile'],$data['sha_home_phone'],$data['sha_accomodation'],$data['sha_name2'],$data['sha_nationality'],$data['sha_passport'],$data['sha_passport_expiry'],$data['sha_arrival_date'],$data['sha_arrival_date'],$bookingTo,$data['sha_duration_week'],$data['sha_duration_day'],$date, $filled_by,$study_group,$sha_study_group,$data['sha_registered_status'],$data['sha_student_no'],trim($data['sha_EC_name']),trim($data['sha_EC_relation']),trim($data['sha_EC_phone']),trim($data['sha_EC_email'])));	
		$appId=$this->db->insert_id();
		
		if($data['sha_accomodation']=='6' && $data['sha_arrival_date']!='')
			$this->db->query("update `sha_one` set `booking_from`=?, `booking_to`=? where `id`=?",array($data['sha_arrival_date'],$data['sha_arrival_date'],$appId));
		if($data['sha_accomodation']=='6' || $data['sha_accomodation']=='7')
			$this->db->query("update `sha_one` set `client`=? where `id`=?",array('363',$appId));	
			
		
		if($data['sha_registered_status']=='Offline')
			recentActionsAddData('sha',$appId,'add');
		
		//Auto assigning employee to application if filled by employee
		/*if(checkLogin())
		{
			$loggedInUser=loggedInUser();
			if($loggedInUser['user_type']==2)
			{
				$sqlOffice="update `sha_one` set `office`=?, `employee`=? where `id`=?";
				$this->db->query($sqlOffice,array($loggedInUser['office'],$loggedInUser['id'],$appId));
			}
		}*/
		return $appId;
	}
	
	
	function sha_two_submit($data)
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
		$data['insPolicyFile']='';
		if(isset($_FILES['insPolicyFile']) && $_FILES['insPolicyFile']['name']!= "")
			{
				  $path="./static/uploads/sha/ins"; 
				  $t1=time();
				  $data['insPolicyFile']=$t1.$_FILES['insPolicyFile']['name'];		
				  move_uploaded_file($_FILES['insPolicyFile']['tmp_name'],$path.'/'.$data['insPolicyFile']);
			}
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

		/*if($data['sha_airport_pickup']!=1)
			$data['sha_airport_arrival_date']=$data['sha_airport_arrival_time']=$data['sha_airport_carrier']=$data['sha_airport_flightno']='';	*/
		
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
		
		//$data['insPolicyFile']='';	
																		
		/*$sqlUpdate="update `sha_two` set `languages`='".$data['sha_student_language']."', `ethnicity`='".$data['sha_student_ethnicity']."', `religion`='".$data['sha_student_religion']."', `religion_other`='".$data['sha_religion_other_val']."', `live_with_pets`='".$data['sha_live_with_pets']."', `pet_dog`='".$pets['dog']."', `pet_cat`='".$pets['cat']."', `pet_bird`='".$pets['bird']."', `pet_other`='".$pets['other']."', `pet_other_val`='".$pets['other_val']."', `pet_live_inside`='".$data['sha_pet_live_inside']."', `insurance`='".$data['sha_insurance']."', `ins_provider`='".$data['sha_insurance_provider']."', `ins_policy_no`='".$data['sha_insurance_policy_number']."', `ins_expiry`='".$data['sha_insurance_policy_expiry']."', `airport_pickup`='".$data['sha_airport_pickup']."'";
		$sqlUpdate .=", `airport_arrival_time`='".$data['sha_airport_arrival_time']."', `airport_carrier`='".$data['sha_airport_carrier']."', `airport_flightno`='".$data['sha_airport_flightno']."', `home_student_past`='".$data['sha_home_student_past']."', `home_student_exp`='".$data['sha_home_student_exp']."', `student_desc`='".$data['sha_student_desc']."', `student_family_desc`='".$data['sha_student_family_desc']."', `guardianship`='".$data['sha_guardian']."', `guardianship_type`='".$data['sha_guardian_type']."', `guardianship_other_val`='".$data['sha_other_guardian_val']."', `ins_file`='".$data['insPolicyFile']."'  where `id`='".$data['id']."'";
		$this->db->query($sqlUpdate);*/
		
		$sqlUpdate="update `sha_two` set `languages`=?, `ethnicity`=?, `religion`=?, `religion_other`=?, `live_with_pets`=?, `pet_dog`=?, `pet_cat`=?, `pet_bird`=?, `pet_other`=?, `pet_other_val`=?, `pet_live_inside`=?, `insurance`=?, `ins_provider`=?, `ins_policy_no`=?, `ins_expiry`=?, `airport_pickup`=?";
		$sqlUpdate .=", `airport_arrival_time`=?, `airport_carrier`=?, `airport_flightno`=?, `home_student_past`=?, `home_student_exp`=?, `student_desc`=?, `student_family_desc`=?, `student_hobbies`=?, `guardianship`=?, `guardianship_requirements`=?, `ins_file`=?  where `id`=?";
		$this->db->query($sqlUpdate,array($data['sha_student_language'],$data['sha_student_ethnicity'],$data['sha_student_religion'],$data['sha_religion_other_val'],$data['sha_live_with_pets'],$pets['dog'],$pets['cat'],$pets['bird'],$pets['other'],$pets['other_val'],$data['sha_pet_live_inside'],$data['sha_insurance'],$data['sha_insurance_provider'],$data['sha_insurance_policy_number'],$data['sha_insurance_policy_expiry'],$data['sha_airport_pickup'],$data['sha_airport_arrival_time'],$data['sha_airport_carrier'],$data['sha_airport_flightno'],$data['sha_home_student_past'],$data['sha_home_student_exp'],$data['sha_student_desc'],$data['sha_student_family_desc'],$data['sha_student_hobbies'],$data['sha_guardian'],trim($data['sha_guardian_requirements']),$data['insPolicyFile'],$data['id']));
		
		if($data['sha_airport_arrival_date']!='')
		{
			$sqlUpdateOne="update `sha_one` set `arrival_date`='".$data['sha_airport_arrival_date']."'  where `id`='".$data['id']."'";
			$this->db->query($sqlUpdateOne);
			
			$shaOne=getShaOneAppDetails($data['id']);
			if($shaOne['accomodation_type']=='6')
				$this->db->query("update `sha_one` set `booking_from`=?, `booking_to`=? where `id`=?",array($data['sha_airport_arrival_date'],$data['sha_airport_arrival_date'],$data['id']));
		}
		
		$sqlUpdateStep="update `sha_one` set `step`='3'  where `id`='".$data['id']."'";
		$this->db->query($sqlUpdateStep);
		//Main table #ENDS
		
		//Language #STARTS
			$lang=$data['sha_language'];
			//see($lang);
			$sqlDelLang="delete from `sha_language` where `application_id`='".$data['id']."'";
			$this->db->query($sqlDelLang);
				for($y=1;$y<=$data['sha_student_language'];$y++)
				{
					$languages=$lang['language-'.$y];
					$other=!empty($languages['other_language']) ? $languages['other_language'] : '';
					$insertLang="insert into `sha_language` (`application_id`, `language`, `other_language`,`prof`) values (?,?,?,?)";
					$this->db->query($insertLang, array($data['id'], $languages['language'],$other,$languages['prof']));
				}
		//Language #ENDS
	}

	function sha_three_submit($data)
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
																								
		/*$sqlUpdate="update `sha_three` set `diet_req`='".$data['sha_student_diet']."', `diet_veg`='".$diet['veg']."', `diet_gluten`='".$diet['gluten']."', `diet_pork`='".$diet['pork']."', `diet_food_allergy`='".$diet['food_allergy']."', `diet_other`='".$diet['other']."', `diet_other_val`='".$diet['other_val']."', `allergy_req`='".$data['sha_student_allergies']."', `allergy_hay_fever`='".$allergy['hay_fever']."', `allergy_asthma`='".$allergy['asthma']."', `allergy_lactose`='".$allergy['lactose']."', `allergy_gluten`='".$allergy['gluten']."', `allergy_peanut`='".$allergy['peanut']."', `allergy_dust`='".$allergy['dust']."', `allergy_other`='".$allergy['other']."', `allergy_other_val`='".$allergy['other_val']."', `smoker`='".$data['sha_student_smoke']."', `medication`='".$data['sha_student_medication']."', `medication_desc`='".$data['sha_student_medication_details']."', `disabilities`='".$data['sha_student_disabilities']."', `disabilities_desc`='".$data['sha_disabilities_details']."', `live_with_child11`='".$data['sha_live_with_child11']."', `live_with_child20`='".$data['sha_live_with_child20']."', `live_with_child_reason`='".$data['sha_live_with_child_reason']."', `family_include_smoker`='".$data['family_include_smoker']."', `family_pref`='".$data['sha_family_pref']."', `college`='".$data['sha_student_college']."', `campus`='".$data['sha_student_campus']."', `college_address`='".$data['sha_student_college_address']."', `homestay_choosing_reason`='".$data['homestay_choosing_reason']."', `homestay_choosing_reason_other`='".$data['homestay_choosing_reason_other']."', `homestay_hear_ref`='".$data['homestay_hear_ref']."', `homestay_hear_ref_other_val`='".$data['homestay_hear_ref_other_val']."'  where `id`='".$data['id']."'";
		$this->db->query($sqlUpdate);*/
		
		$sqlUpdate="update `sha_three` set `diet_req`=?, `diet_veg`=?, `diet_gluten`=?, `diet_pork`=?, `diet_food_allergy`=?, `diet_other`=?, `diet_other_val`=?, `allergy_req`=?, `allergy_hay_fever`=?, `allergy_asthma`=?, `allergy_lactose`=?, `allergy_gluten`=?, `allergy_peanut`=?, `allergy_dust`=?, `allergy_other`=?, `allergy_other_val`=?, `smoker`=?, `medication`=?, `medication_desc`=?, `disabilities`=?, `disabilities_desc`=?, `live_with_child11`=?, `live_with_child20`=?, `live_with_child_reason`=?, `family_include_smoker`=?, `family_pref`=?, `college`=?, `campus`=?, `college_address`=?, `course_name`=?, `course_start_date`=?, `homestay_choosing_reason`=?, `homestay_choosing_reason_other`=?, `homestay_hear_ref`=?, `homestay_hear_ref_other_val`=?  where `id`=?";
		$this->db->query($sqlUpdate,array($data['sha_student_diet'],$diet['veg'],$diet['gluten'],$diet['pork'],$diet['food_allergy'],$diet['other'],$diet['other_val'],$data['sha_student_allergies'],$allergy['hay_fever'],$allergy['asthma'],$allergy['lactose'],$allergy['gluten'],$allergy['peanut'],$allergy['dust'],$allergy['other'],$allergy['other_val'],$data['sha_student_smoke'],$data['sha_student_medication'],$data['sha_student_medication_details'],$data['sha_student_disabilities'],$data['sha_disabilities_details'],$data['sha_live_with_child11'],$data['sha_live_with_child20'],$data['sha_live_with_child_reason'],$data['family_include_smoker'],$data['sha_family_pref'],$data['sha_student_college'],$data['sha_student_campus'],$data['sha_student_college_address'],$data['sha_student_course_name'],$data['sha_student_course_start_date'],$data['homestay_choosing_reason'],$data['homestay_choosing_reason_other'],$data['homestay_hear_ref'],$data['homestay_hear_ref_other_val'],$data['id']));
		
		$sqlUpdateStep="update `sha_one` set `step`='4'  where `id`='".$data['id']."'";
		$this->db->query($sqlUpdateStep);
		
		//Main table #ENDS
	}

	function getShaOneAppDetails($id)
	{
		$sql="select * from `sha_one` where `id`='".$id."'";
		$query=$this->db->query($sql);
		$shaOne=$query->row_array();
		
		if(!empty($shaOne))
			{	$shaId=getDuplicateShaFirst($id);
				if($shaId!=$id)
				{
					$sqlDup=$this->db->query("select `special_request_notes` from `sha_one` where `id`='".$shaId."'");
					$notes=$sqlDup->row_array();
					$shaOne['special_request_notes']=$notes['special_request_notes'];
				}
			}
		
		return $shaOne;
	}


/////////////
	function shaAppCheckStepTwo($id)
	{
		$sql="select * from `sha_two` where `id`='".$id."'";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	
	function shaAppCheckStepThree($id)
	{
		$sql="select * from `sha_three` where `id`='".$id."'";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	
	function shaAppCheckStep($id)
	{
		$step=0;
		$one=getshaOneAppDetails($id);
		if(!empty($one))
		{
			$two=$this->shaAppCheckStepTwo($id);
			if(!empty($two))
			{
				$three=$this->shaAppCheckStepThree($id);
				if(!empty($three))
					$step=4;
				else
					$step=3;
			}
			else
				$step=2;
		}
		else
			$step=1;
			
		return $step;	
	}
	
	function feedbacksByShaId($shaId)
	{
		return $this->db->query("select * from `booking_feedbacks` where `student`=?",$shaId)->result_array();
	}
	
	function feedbackSubmit($data)
	{
		  $feeds=$this->feedbacksByShaId($data['student']);
		  $rows=count($feeds);
		  if($rows==0)
		  {
			  $date=date('Y-m-d H:i:s');
			  $move_in_date=normalToMysqlDate($data['move_in_date']);
			  $apu_satisfied=$apu_desc='';
			  $apu=$data['apu'];
			  if($apu=='1')
			  {
				  if(isset($data['apu_satisfied']))
					  $apu_satisfied=$data['apu_satisfied'];
				  $apu_desc=$data['apu_desc'];	
			  }
			  
			  if(!isset($data['hfa_comfort']))
			  $data['hfa_comfort']='';
			  if(!isset($data['hfa_friendly']))
			  $data['hfa_friendly']='';
			  if(!isset($data['hfa_food']))
			  $data['hfa_food']='';
			  if(!isset($data['hfa_overall']))
			  $data['hfa_overall']='';
			  
			  $sql="INSERT INTO `booking_feedbacks` (`booking`, `student`, `host`, `student_name`, `student_college`, `host_name`, `host_address`, `move_in_date`, `apu`, `apu_satisfied`, `apu_desc`, `host_comfort`, `host_friendly`, `host_food`, `host_overall`, `testimonials`, `comments`, `date`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			  $this->db->query($sql,array($data['booking'],$data['student'],$data['host'],$data['sha_name'],$data['sha_college'],$data['host_name'],$data['host_address'],$move_in_date,$apu,$apu_satisfied,$apu_desc,$data['hfa_comfort'],$data['hfa_friendly'],$data['hfa_food'],$data['hfa_overall'],$data['testimonial'],$data['comments'],$date));	
			  
			  $booking=bookingDetails($data['booking']);
			  $dateSent=date('Y-m-d',strtotime($booking['booking_from'].' + 1 week'));
			  $this->db->query("update `booking_feedbacks_count` set `submissions`=`submissions`+1 where `date`=?",array($dateSent));
			  
			  $fes=$this->db->query("select * from `booking_feedbacks_emails` where `booking_id`='".$data['booking']."' order by `id` DESC limit 1")->row_array();
			  $this->db->query("update `booking_feedbacks_emails` set `submit_on`='".$date."' where `id`='".$fes['id']."'");
		  }
	}

/////////////////
	
}