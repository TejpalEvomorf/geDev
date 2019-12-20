<?php 

class Zimport_model extends CI_Model {
	
	function importClients($clients)
	{
		foreach($clients as $client)
		{
			$sql="insert into `clients_remove` (`salesForce_id`,`bname`,`category`,`street_address`,`suburb`,`state`,`postal_code`,`country`,`primary_contact_name`,`primary_contact_lname`,`sec_phone`,`primary_phone`,`primary_email`,`notes`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$this->db->query($sql,$client);
		}
	}

	
	function importHosts($hosts)
	{
		foreach($hosts as $host)
		{
			$sql="insert into `hfa_one_remove` (`salesForce_id`,`salesForce_id_primary_contact`,`title`,`fname`,`lname`,`email`,`mobile`,`home_phone`,`work_phone`,`contact_way`,`family_members`,`street`,`suburb`,`postcode`,`state`,`postal_address`";
			
			if(isset($host['street_postal']))
				$sql .=",`street_postal`,`suburb_postal`,`postcode_postal`,`state_postal`";
			
			$sql .=") values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?";
			
			if(isset($host['street_postal']))
				$sql .=",?,?,?,?";
			
			$sql .=")";
			
			if(!isset($host['street_postal']))
				$this->db->query($sql, array($host['salesForceId_host'],$host['salesForceId_contact'],$host['title'],$host['fname'],$host['lname'],$host['email'],$host['mobile'],$host['homePhone'],$host['workPhone'],1,$host['members'],$host['street'],$host['suburb'],$host['post_code'],$host['state'],$host['postal_address_same']));
			else
				$this->db->query($sql, array($host['salesForceId_host'],$host['salesForceId_contact'],$host['title'],$host['fname'],$host['lname'],$host['email'],$host['mobile'],$host['homePhone'],$host['workPhone'],1,$host['members'],$host['street'],$host['suburb'],$host['post_code'],$host['state'],$host['postal_address_same'],$host['street_postal'],$host['suburb_postal'],$host['post_code_postal'],$host['state_postal']));
			
			$applicationId=$this->db->insert_id();
			$sqlMem="insert into `hfa_members_remove` (`salesForce_id`,`application_id`,`title`,`fname`,`lname`) values (?,?,?,?,?)";
			$this->db->query($sqlMem, array($host['salesForceId_member'],$applicationId,$host['title'],$host['fname'],$host['lname']));
					
		}
	}
	
		
	function importHosts2($hosts)
	{
		foreach($hosts as $host)
		{
			$sel="select `id` from `hfa_one_remove` where `salesForce_id`='".$host['salesForceId_host']."'";
			$querySel=$this->db->query($sel);
			if($querySel->num_rows()>0)
			{
				$hfa_one=$querySel->row_array();
				$sql="insert into `hfa_two` (`id`,`salesForce_id`,`d_type`,`flooring`,`flooring_other`,`internet`,`internet_type`,`s_detector`,`bedrooms`,`bedrooms_avail`,`bathrooms`,`laundry`,`laundry_outside`,`home_desc`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
				$this->db->query($sql,array($hfa_one['id'],$host['salesForceId_host'],$host['dwelling_type'],$host['main_flooring'],$host['main_flooringOthers'],$host['internet_students'],$host['internet_type'],$host['smoke_detector'],$host['rooms'],$host['rooms_students'],$host['bathrooms'],$host['laundry_students'],$host['laundry_out'],$host['home_desc']));
				
				$sqlFacility="insert into `hfa_facilities` (`id`,`pool`,`tennis`,`piano`,`gym`,`disable_access`,`other`,`other_val`) values (?,?,?,?,?,?,?,?)";
				$this->db->query($sqlFacility,array($hfa_one['id'],$host['facility_pool'],$host['facility_tennis'],$host['facility_piano'],$host['facility_gym'],$host['facility_disable_access'],$host['facility_other'],$host['facility_other_val']));
				
				$sqlBed="insert into `hfa_bedrooms` (`application_id`,`salesForce_id_host`,`type`,`flooring`) values (?,?,?,?)";
				$this->db->query($sqlBed,array($hfa_one['id'],$host['salesForceId_host'],$host['room_type'],$host['room_floor']));
				
				$sqlBed="insert into `hfa_bathrooms` (`application_id`,`salesForce_id_host`,`avail_to_student`) values (?,?,?)";
				$this->db->query($sqlBed,array($hfa_one['id'],$host['salesForceId_host'],$host['bathrooms_avail']));
			}
		}
	}	
	
	function csvHostsRooms($rooms)
	{
		foreach($rooms as $room)
		{
			$sel="select `id` from `hfa_one_remove` where `salesForce_id`='".$room['salesForceId_host']."'";
			$querySel=$this->db->query($sel);
			if($querySel->num_rows()>0)
			{
				$hfa_one=$querySel->row_array();
				
				$sql_del="delete from `hfa_bedrooms` where `application_id`='".$hfa_one['id']."' and `salesForce_id`=''";
				$this->db->query($sql_del);
				
				$sql="insert into `hfa_bedrooms` (`application_id`,`salesForce_id`,`salesForce_id_host`,`type`,`flooring`,`flooring_other`,`access`,`granny_flat`,`internal_ensuit`,`avail`,`avail_from`,`currently_hosting`,`date_leaving`,`age`,`gender`,`nation`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
				$this->db->query($sql,array($hfa_one['id'],$room['salesForceId_room'],$room['salesForceId_host'],$room['type'],$room['flooring'],$room['flooring_other'],$room['access'],$room['granny_flat'],$room['internal_ensuit'],$room['avail'],$room['avail_from'],$room['avail_currently_hosting'],$room['avail_date_leaving'],$room['avail_age'],$room['avail_gender'],$room['avail_country']));
			}
		}
	}
	
	function csvHostsRoomsCorrection($room)
	{
		$sql="update `hfa_bedrooms` set `granny_flat`='".$room['granny_flat']."' where `salesForce_id`='".$room['salesForceId_room']."'";
		//$this->db->query($sql);
	}
	
	function UpdateBedCounts()
	{
			$sqlSel="select * from `hfa_two` where `id`>'0' and `id`<='1000'";
			$sqlSel="select * from `hfa_two` where `id`>'1000' and `id`<='2000'";
			$sqlSel="select * from `hfa_two` where `id`>'2000' and `id`<='3000'";
			$sqlSel="select * from `hfa_two` where `id`>'3000' and `id`<='4000'";
			$sqlSel="select * from `hfa_two` where `id`>'4000' and `id`<='5000'";
			$sqlSel="select * from `hfa_two` where `id`>'5000' and `id`<='6000'";
			$query=$this->db->query($sqlSel);
			$hosts=$query->result_array();
			
			foreach($hosts as $host)
			{
				$sqlSel1="select count(*) as `count` from `hfa_bedrooms` where `application_id`='".$host['id']."'";
				$querySel1=$this->db->query($sqlSel1);
				$count=$querySel1->row_array();
				
				$sql="update `hfa_two` set `bedrooms_avail`='".$count['count']."' where `id`='".$host['id']."'";
				$this->db->query($sql);
			}
	}
	
	function UpdateBedCountsAll()
	{
			$sqlSel="select * from `hfa_two` where `id`>'0' and `id`<='1000'";
			$sqlSel="select * from `hfa_two` where `id`>'1000' and `id`<='2000'";
			$sqlSel="select * from `hfa_two` where `id`>'2000' and `id`<='3000'";
			$sqlSel="select * from `hfa_two` where `id`>'3000' and `id`<='4000'";
			$sqlSel="select * from `hfa_two` where `id`>'4000' and `id`<='5000'";
			$sqlSel="select * from `hfa_two` where `id`>'5000' and `id`<='6000'";
			$sqlSel="select * from `hfa_two`";
			$query=$this->db->query($sqlSel);
			$hosts=$query->result_array();
			
			foreach($hosts as $host)
			{
				if($host['bedrooms']<$host['bedrooms_avail'])
				{
					$sql="update `hfa_two` set `bedrooms`='".$host['bedrooms_avail']."' where `id`='".$host['id']."'";
					$this->db->query($sql);
				}
				
				
			}
	}
	
	
	function csvHostsBathRooms($rooms)
	{
		foreach($rooms as $room)
		{
			$sel="select `id` from `hfa_one_remove` where `salesForce_id`='".$room['salesForceId_host']."'";
			$querySel=$this->db->query($sel);
			if($querySel->num_rows()>0)
			{
				$hfa_one=$querySel->row_array();
				
				$sql_del="delete from `hfa_bathrooms_bks` where `application_id`='".$hfa_one['id']."' and `salesForce_id`=''";
				$this->db->query($sql_del);
				
				$sql="insert into `hfa_bathrooms_bks` (`application_id`,`salesForce_id`,`salesForce_id_host`,`avail_to_student`,`toilet`,`shower`,`bath`,`ensuit`,`in_out`) values (?,?,?,?,?,?,?,?,?)";
				$this->db->query($sql,array($hfa_one['id'],$room['salesForceId_bathroom'],$room['salesForceId_host'],$room['avail_to_student'],$room['toilet'],$room['shower'],$room['bath'],$room['ensuite'],$room['ensuite_external']));
			}
		}
	}
	
	function UpdateBathroomCounts()
	{
			$sqlSel="select * from `hfa_two` where `id`>'0' and `id`<='1000'";
			$sqlSel="select * from `hfa_two` where `id`>'1000' and `id`<='2000'";
			$sqlSel="select * from `hfa_two` where `id`>'2000' and `id`<='3000'";
			$sqlSel="select * from `hfa_two` where `id`>'3000' and `id`<='4000'";
			$sqlSel="select * from `hfa_two` where `id`>'4000' and `id`<='5000'";
			$sqlSel="select * from `hfa_two` where `id`>'5000' and `id`<='6000'";
			$query=$this->db->query($sqlSel);
			$hosts=$query->result_array();
			
			foreach($hosts as $host)
			{
				$sqlSel1="select count(*) as `count` from `hfa_bathrooms` where `application_id`='".$host['id']."'";
				$querySel1=$this->db->query($sqlSel1);
				$count=$querySel1->row_array();
				
				$sql="update `hfa_two` set `bathrooms`='".$count['count']."' where `id`='".$host['id']."'";
				$this->db->query($sql);
			}
	}
	
	function importHosts3($hosts)
	{
		foreach($hosts as $host)
		{
			$sel="select `id` from `hfa_one_remove` where `salesForce_id`='".$host['salesForceId_host']."'";
			$querySel=$this->db->query($sel);
			if($querySel->num_rows()>0)
			{
				$hfa_one=$querySel->row_array();
				
				$sql="insert into `hfa_three` (`id`,`salesForce_id`,`pets`,`pet_dog`,`pet_cat`,`pet_bird`,`pet_other`,`pet_other_val`,`pet_inside`,`insurance`,`ins_provider`,`ins_policy_no`,`ins_expiry`,`20_million`,`ins_content`,`main_religion`,`main_religion_other`,`hosted_international_in_past`,`homestay_exp`,`family_desc`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
				$this->db->query($sql,array($hfa_one['id'],$host['salesForceId_host'],$host['pets'],$host['pet_dog'],$host['pet_cat'],$host['pet_bird'],$host['pet_other'],$host['pet_other_val'],$host['pets_inside'],$host['ins'],$host['ins_provider'],$host['ins_policy_no'],$host['ins_expiry'],$host['ins_20million'],$host['ins_home_content'],$host['main_religion'],$host['main_religion_other'],$host['hosted_international'],$host['hosted_international_exp'],$host['family_desc']));
				
				$sql="insert into `hfa_bank_details` (`id`,`salesForce_id_host`,`bank_name`,`acc_name`,`bsb`,`acc_no`) values (?,?,?,?,?,?)";
				$this->db->query($sql,array($hfa_one['id'],$host['salesForceId_host'],$host['bank_name'],$host['bank_acc_name'],$host['bank_bsb'],$host['bank_acc_no']));
			}
		}
	}	
	
	function csvHosts3_members($hosts)
	{
		foreach($hosts as $host)
		{
			$sel="select `id` from `hfa_one` where `salesForce_id`='".$host['salesForceId_host']."'";
			$querySel=$this->db->query($sel);
			if($querySel->num_rows()>0)
			{
				$hfa_one=$querySel->row_array();
				
				$sql_del="delete from `hfa_members` where `application_id`='".$hfa_one['id']."' and `salesForce_id_host`=''";
				$this->db->query($sql_del);
				
				$sql="insert into `hfa_members` (`salesForce_id`,`salesForce_id_host`,`application_id`,`title`,`fname`,`lname`,`dob`,`gender`,`role`,`occu`,`ethnicity`,`smoke`,`language`) values (?,?,?,?,?,?,?,?,?,?,?,?,?)";
				$this->db->query($sql,array($host['salesForceId_member'],$host['salesForceId_host'],$hfa_one['id'],$host['title'],$host['fname'],$host['lname'],$host['dob'],$host['gender'],$host['role'],$host['occupation'],$host['ethnicity'],$host['smoker'],$host['languages']));
				$memberId=$this->db->insert_id();
				
				for($x=1;$x<=$host['languages'];$x++)
				{
					$sql="insert into `hfa_members_language` (`application_id`,`member_id`,`language`,`prof`) values (?,?,?,?)";
					$this->db->query($sql,array($hfa_one['id'],$memberId,$host['language'.$x],$host['language'.$x.'_prof']));
				}
			}
		}
	}
	
	
	function UpdateMemberCounts()
	{
			$sqlSel="select * from `hfa_three` where `id`>'0' and `id`<='1000'";
			$sqlSel="select * from `hfa_three` where `id`>'1000' and `id`<='2000'";
			$sqlSel="select * from `hfa_three` where `id`>'2000' and `id`<='3000'";
			$sqlSel="select * from `hfa_three` where `id`>'3000' and `id`<='4000'";
			$sqlSel="select * from `hfa_three` where `id`>'4000' and `id`<='5000'";			
			$sqlSel="select * from `hfa_three` where `id`>'5000' and `id`<='6000'";
			
			$query=$this->db->query($sqlSel);
			$hosts=$query->result_array();
			
			foreach($hosts as $host)
			{
				$sqlSel1="select count(*) as `count` from `hfa_members` where `application_id`='".$host['id']."'";
				$querySel1=$this->db->query($sqlSel1);
				$count=$querySel1->row_array();
				
				$sql="update `hfa_three` set `family_members`='".$count['count']."' where `id`='".$host['id']."'";
				$this->db->query($sql);
			}
	}
	
	function UpdateMemberCountsHfaOne()
	{
			$sqlSel="select * from `hfa_three` where `id`>'0' and `id`<='1000'";
			$sqlSel="select * from `hfa_three` where `id`>'1000' and `id`<='2000'";
			$sqlSel="select * from `hfa_three` where `id`>'2000' and `id`<='3000'";
			$sqlSel="select * from `hfa_three` where `id`>'3000' and `id`<='4000'";
			$sqlSel="select * from `hfa_three` where `id`>'4000' and `id`<='5000'";			
			$sqlSel="select * from `hfa_three` where `id`>'5000' and `id`<='6000'";
			
			$query=$this->db->query($sqlSel);
			$hosts=$query->result_array();
			
			foreach($hosts as $host)
			{
				$sql="update `hfa_one` set `family_members`='".$host['family_members']."' where `id`='".$host['id']."'";
				$this->db->query($sql);
			}
	}
	
	function UpdateMemberSId()
	{
			$sqlSel="select * from `hfa_members` where `salesForce_id_host`=''";
			
			$query=$this->db->query($sqlSel);
			$hosts=$query->result_array();
			
			foreach($hosts as $host)
			{
				$sqlSel1="select *  from `hfa_one` where `id`='".$host['application_id']."'";
				$querySel1=$this->db->query($sqlSel1);
				$count=$querySel1->row_array();
				
				$sql="update `hfa_members` set `salesForce_id_host`='".$count['salesForce_id']."' where `id`='".$host['application_id']."'";
				$this->db->query($sql);
			}
	}
	
	
	function csvHosts3_membersLang()
	{
		
			//$sqlSel="select * from `hfa_members` where `salesForce_id`=''";
			$sqlSel="select * from `hfa_members` where `language`='0'";
			$query=$this->db->query($sqlSel);
			$hosts=$query->result_array();
			
			foreach($hosts as $host)
			{
				$sql="update `hfa_members` set `language`='1' where `application_id`='".$host['application_id']."'";
				$this->db->query($sql);
				
				$sql="insert into `hfa_members_language` (`application_id`,`member_id`,`language`,`prof`) values (?,?,?,?)";
				$this->db->query($sql,array($host['application_id'],$host['id'],'10','3'));
			}
		
		//
		
	}
	
	
	function csvHosts3_wwcc($hosts)
	{
		foreach($hosts as $host)
		{
			$sqlSel="select * from `hfa_members` where `salesForce_id`='".$host['salesForceId_member']."' ";
			//$sqlSel .="and `id`>'0' and `id`<='5000'";
			//$sqlSel .="and `id`>'5000' and `id`<='10000'";
//			$sqlSel .="and `id`>'10000' and `id`<='15000'";
//			$sqlSel .="and `id`>'15000' and `id`<='20000'";
//			$sqlSel .="and `id`>'20000' and `id`<='25000'";
			$querySel=$this->db->query($sqlSel);
			if($querySel->num_rows()>0)
			{
				$resSel=$querySel->row_array();
				if(age_from_dob($resSel['dob'])>=18)
				{
					$sql="update `hfa_members` set `wwcc`='".$host['wwcc_complete']."', `wwcc_clearence`='".$host['wwcc_clearence']."', `wwcc_application_no`='".$host['wwcc_app_no']."', `wwcc_clearence_no`='".$host['wwcc_clearence_no']."', `wwcc_expiry`='".$host['wwcc_exp']."' where `id`='".$resSel['id']."'";
					$this->db->query($sql);
				}
			}
		}
	}
	
	
	function csvHosts4($hosts)
	{
		foreach($hosts as $host)
		{
			$sel="select `id` from `hfa_one_remove` where `salesForce_id`='".$host['salesForceId_host']."'";
			$querySel=$this->db->query($sel);
			if($querySel->num_rows()>0)
			{
				$hfa_one=$querySel->row_array();
				$sql="insert into `hfa_four` (`id`,`salesForce_id`,`other_pref`,`ref`,`ref_other`,`disable_students`,`reason_age_gender`) values (?,?,?,?,?,?,?)";
				$this->db->query($sql,array($hfa_one['id'],$host['salesForceId_host'],$host['other_preference'],$host['ge_referal'],$host['ge_referal_other'],$host['accomodate_disable'],$host['reason_gender_pref']));
			}
		}
	}
	
	
	function csvHosts4_pref($hosts)
	{
		foreach($hosts as $host)
		{
				$sqlUpdate="update `hfa_four_test` set  `age_pref`='".$host['age_pref']."',`gender_pref`='".$host['gender_pref']."',`reason_age_gender`=concat('".$host['reason_gender_pref']."',`reason_age_gender`),`smoker_students`='".$host['allow_smoker']."',`diet_student`='".$host['diet_req']."',`allergic_students`='".$host['allergy_pref']."',`diet_req_veg`='".$host['diet_req_veg']."',`diet_req_gluten`='".$host['diet_req_gluten']."',`diet_req_no_pork`='".$host['diet_req_pork']."',`diet_req_food_allergy`='".$host['diet_req_allergy']."',`allerry_hay_fever`='".$host['allergy_hay_fever']."',`allerry_asthma`='".$host['allergy_asthma']."',`allerry_lactose`='".$host['allergy_lactose']."',`allerry_gluten`='".$host['allergy_gluten']."',`allerry_peanut`='".$host['allergy_peanut']."',`allerry_dust`='".$host['allergy_dust']."',`allerry_other`='".$host['allergy_other']."',`allerry_other_val`='".$host['allergy_other_val']."' where `salesForce_id`='".$host['salesForceId_host']."'";				
				$this->db->query($sqlUpdate);
				
		}
	}
	
	function hostUpdatePrimaryMember()
	{
			$sqlSel="select * from `hfa_one` where `id`>'0' and `id`<='1000' ";
			$sqlSel="select * from `hfa_one` where `id`>'1000' and `id`<='2000'";
			$sqlSel="select * from `hfa_one` where `id`>'2000' and `id`<='3000'";
			$sqlSel="select * from `hfa_one` where `id`>'3000' and `id`<='4000'";
			$sqlSel="select * from `hfa_one` where `id`>'4000' and `id`<='5000'";			
			$sqlSel="select * from `hfa_one` where `id`>'5000' and `id`<='6000'";
			
			$sqlSel .=" and `salesForce_id_primary_contact`!=''";

			$querySel=$this->db->query($sqlSel);
			$resSel=$querySel->result_array();
			
			foreach($resSel as $host)
			{
				$sqlUpdate="update `hfa_members` set `primary_member`='1' where `salesForce_id`='".$host['salesForce_id_primary_contact']."'";
				$this->db->query($sqlUpdate);
				
				$update="update `hfa_members` set `primary_member`='0' where `salesForce_id`!='".$host['salesForce_id_primary_contact']."' and `application_id`='".$host['id']."'";
				$this->db->query($update);
			}
	}
	
	function hostUpdatePrimaryMemberByName()
	{
			/*$sqlSel="select * from `hfa_one` where `id`>'0' and `id`<='1000' ";
			$sqlSel="select * from `hfa_one` where `id`>'1000' and `id`<='2000'";
			$sqlSel="select * from `hfa_one` where `id`>'2000' and `id`<='3000'";
			$sqlSel="select * from `hfa_one` where `id`>'3000' and `id`<='4000'";
			$sqlSel="select * from `hfa_one` where `id`>'4000' and `id`<='5000'";			
			$sqlSel="select * from `hfa_one` where `id`>'5000' and `id`<='6000'";*/
			$sqlSel="select * from `hfa_one` where  ";
			$sqlSel .="`salesForce_id_primary_contact`=''";

			$querySel=$this->db->query($sqlSel);
			$resSel=$querySel->result_array();
			$count=1;
			foreach($resSel as $host)
			{
				//echo "<br>";
				$sql="select * from `hfa_members` where `fname` like ? and `application_id`='".$host['id']."'";
				$query=$this->db->query($sql,$host['fname']);
				$res=$query->row_array();
				if(!empty($res))
				{
						/*echo '<b>'.$count.'.</b> Found: '.$res['fname'];
						$count++;*/
						
						$sqlUpdate="update `hfa_members` set `primary_member`='1' where `id`='".$res['id']."'";
						$this->db->query($sqlUpdate);
						
						$update="update `hfa_members` set `primary_member`='0' where `id`!='".$res['id']."' and `application_id`='".$host['id']."'";
						$this->db->query($update);
				}
				/*else	
						echo 'Not Found';	*/
				
				
			}
	}	
	
	
	function hostUpdatePrimaryMemberByHFather()
	{
			/*$sqlSel="select * from `hfa_one` where `id`>'0' and `id`<='1000' ";
			$sqlSel="select * from `hfa_one` where `id`>'1000' and `id`<='2000'";
			$sqlSel="select * from `hfa_one` where `id`>'2000' and `id`<='3000'";
			$sqlSel="select * from `hfa_one` where `id`>'3000' and `id`<='4000'";
			$sqlSel="select * from `hfa_one` where `id`>'4000' and `id`<='5000'";			
			$sqlSel="select * from `hfa_one` where `id`>'5000' and `id`<='6000'";*/
			$sqlSel="select * from `hfa_one` where  ";
			$sqlSel .="`salesForce_id_primary_contact`=''";

			$querySel=$this->db->query($sqlSel);
			$resSel=$querySel->result_array();
			$count=1;
			foreach($resSel as $host)
			{
				/*echo "<br>";*/
				$sql="select * from `hfa_members` where `role` ='2' and `application_id`='".$host['id']."'";
				$query=$this->db->query($sql);
				$res=$query->row_array();
				if(!empty($res))
				{
						/*echo '<b>'.$count.'.</b> Found: '.$res['fname'];
						$count++;*/
						
						$sqlUpdate="update `hfa_members` set `primary_member`='1' where `id`='".$res['id']."'";
						$this->db->query($sqlUpdate);
						
						$update="update `hfa_members` set `primary_member`='0' where `id`!='".$res['id']."' and `application_id`='".$host['id']."'";
						$this->db->query($update);
				}
				/*else	
						echo 'Not Found';	*/
				
				/*$sqlUpdate="update `hfa_members` set `primary_member`='1' where `salesForce_id`='".$host['salesForce_id_primary_contact']."'";
				$this->db->query($sqlUpdate);
				
				$update="update `hfa_members` set `primary_member`='0' where `salesForce_id`!='".$host['salesForce_id_primary_contact']."' and `application_id`='".$host['id']."'";
				$this->db->query($update);*/
			}
	}	
	
	function hostUpdatePrimaryMemberByHMother()
	{
			/*$sqlSel="select * from `hfa_one` where `id`>'0' and `id`<='1000' ";
			$sqlSel="select * from `hfa_one` where `id`>'1000' and `id`<='2000'";
			$sqlSel="select * from `hfa_one` where `id`>'2000' and `id`<='3000'";
			$sqlSel="select * from `hfa_one` where `id`>'3000' and `id`<='4000'";
			$sqlSel="select * from `hfa_one` where `id`>'4000' and `id`<='5000'";			
			$sqlSel="select * from `hfa_one` where `id`>'5000' and `id`<='6000'";*/
			$sqlSel="select * from `hfa_one` where  ";
			$sqlSel .="`salesForce_id_primary_contact`=''";

			$querySel=$this->db->query($sqlSel);
			$resSel=$querySel->result_array();
			$count=1;
			foreach($resSel as $host)
			{
				/*echo "<br>";*/
				$sql="select * from `hfa_members` where `role` ='1' and `application_id`='".$host['id']."'";
				$query=$this->db->query($sql);
				$res=$query->row_array();
				if(!empty($res))
				{
						/*echo '<b>'.$count.'.</b> Found: '.$res['fname'];
						$count++;*/
						
						$sqlUpdate="update `hfa_members` set `primary_member`='1' where `id`='".$res['id']."'";
						$this->db->query($sqlUpdate);
						
						$update="update `hfa_members` set `primary_member`='0' where `id`!='".$res['id']."' and `application_id`='".$host['id']."'";
						$this->db->query($update);
				}
				/*else	
						echo 'Not Found';*/	
				
				/*$sqlUpdate="update `hfa_members` set `primary_member`='1' where `salesForce_id`='".$host['salesForce_id_primary_contact']."'";
				$this->db->query($sqlUpdate);
				
				$update="update `hfa_members` set `primary_member`='0' where `salesForce_id`!='".$host['salesForce_id_primary_contact']."' and `application_id`='".$host['id']."'";
				$this->db->query($update);*/
			}
	}
	
	function hostUpdatePrimaryMemberById()
	{
			
			$sqlSel="select * from `hfa_one` where  ";
			$sqlSel .="`salesForce_id_primary_contact`=''";

			$querySel=$this->db->query($sqlSel);
			$resSel=$querySel->result_array();
			$count=1;
			foreach($resSel as $host)
			{
				/*echo "<br>";*/
				$sql="select * from `hfa_members` where `application_id`='".$host['id']."' order by `id`";
				$query=$this->db->query($sql);
				$res=$query->row_array();
				if(!empty($res))
				{
						/*echo '<b>'.$count.'.</b> Found: '.$res['fname'];
						$count++;*/
						
						$sqlUpdate="update `hfa_members` set `primary_member`='1' where `id`='".$res['id']."'";
						$this->db->query($sqlUpdate);
						
						$update="update `hfa_members` set `primary_member`='0' where `id`!='".$res['id']."' and `application_id`='".$host['id']."'";
						$this->db->query($update);
				}
			}
	}
	
	function csvHostsNotes($hosts)
	{
		foreach($hosts as $host)
		{
				$sqlUpdate="update `hfa_one` set  `notes_family`=?,`special_request_notes`=? where `salesForce_id`='".$host['salesForceId_host']."'";
				$this->db->query($sqlUpdate,array($host['family_notes'],$host['internal_notes']));
		}
	}
	
	function csvHostsVipRooms($hosts)
	{
		
		foreach($hosts as $host)
		{
				$sel="select * from `hfa_bedrooms` where `salesForce_id_host`=? and `internal_ensuit`=?";
				$query=$this->db->query($sel,array($host['A'],'1'));
				if($query->num_rows()>0)
				{//ensuit
					$sqlUpdate="update `hfa_bedrooms` set  `vip`=? where `salesForce_id_host`=? and `internal_ensuit`=?";
					$this->db->query($sqlUpdate,array('1',$host['A'],'1'));
				}
				else
				{
					$selSingle="select * from `hfa_bedrooms` where `salesForce_id_host`=? and `type`=?";
					$querySingle=$this->db->query($selSingle,array($host['A'],'1'));
					if($querySingle->num_rows()>0)
					{//Single
						$resSingle=$querySingle->row_array();
						$sqlUpdate="update `hfa_bedrooms` set  `vip`=? where `salesForce_id_host`=? and `type`=? and `id`=?";
						$this->db->query($sqlUpdate,array('1',$host['A'],'1',$resSingle['id']));
					}
					else
					{
						$selTwin="select * from `hfa_bedrooms` where `salesForce_id_host`=? and `type`=?";
						$queryTwin=$this->db->query($selTwin,array($host['A'],'2'));
						if($queryTwin->num_rows()>0)
						{//Twin
							$resTwin=$queryTwin->row_array();
							$sqlUpdate="update `hfa_bedrooms` set  `vip`=? where `salesForce_id_host`=? and `type`=? and `id`=?";
							$this->db->query($sqlUpdate,array('1',$host['A'],'2',$resTwin['id']));
						}
						else
						{
							$selFrist="select * from `hfa_bedrooms` where `salesForce_id_host`=? order by `id`";
							$queryFirst=$this->db->query($selFrist,array($host['A']));
							if($queryFirst->num_rows()>0)
							{//First room
								$resFirst=$queryFirst->row_array();
								$sqlUpdate="update `hfa_bedrooms` set  `vip`=? where `salesForce_id_host`=? and `id`=?";
								$this->db->query($sqlUpdate,array('1',$host['A'],$resFirst['id']));
							}
						}
					}
				}
		}
	}
	
	function csvHostsStatus($hosts)
	{
		foreach($hosts as $host)
		{
			$update="update `hfa_one` set `status`=?,`date`=?,`date_status_changed`=?,`visit_date_time`=? where `salesForce_id`=?";
			$this->db->query($update,array($host['status'],$host['date_created'],$host['date_modified'],$host['visit_date'],$host['salesForceId_host']));
			
			if($host['status']=='do_not_use')
			{
				$sel="select * from `hfa_one` where `salesForce_id`=?";
				$query=$this->db->query($sel,array($host['salesForceId_host']));
				if($query->num_rows()>0)
				{
					$res=$query->row_array();
					$sql="insert into `hfa_dnu` (`application_id`,`reason`,`comment`) values(?,?,?)";
					$this->db->query($sql,array($res['id'],$host['reason'],$host['reason_other']));
				}
			}
		}
	}
	
	function csvStudents($students)
	{
		foreach($students as $student)
		{
			$sql="insert into `sha_one` (`salesForce_id`,`title`,`fname`,`lname`,`gender`,`dob`,`email`,`mobile`,`accomodation_type`,`nation`,`passport_no`,`passport_exp`) values (?,?,?,?,?,?,?,?,?,?,?,?)";
			$this->db->query($sql,array($student['salesForceId'],$student['title'],$student['fname'],$student['lname'],$student['gender'],$student['dob'],$student['email'],$student['mobile'],$student['accType'],$student['nation'],$student['passport_no'],$student['passport_expiry']));
		}
	}
	
	function csvStudents2P1($students)
	{
		foreach($students as $student)
		{
			$sel="select * from `sha_one` where `salesForce_id`='".$student['salesForceId']."'";
			$querySel=$this->db->query($sel);
			if($querySel->num_rows()>0)
			{
				$stu=$querySel->row_array();
				
				if($student['ethnicity']=='CheckNationality')
					$student['ethnicity']=$stu['nation'];
				
				$sql="insert into `sha_two_remove` (`id`,`salesForce_id`,`languages`,`ethnicity`,`religion`,`religion_other`) values(?,?,?,?,?,?)";
				$this->db->query($sql,array($stu['id'],$student['salesForceId'],$student['languages'],$student['ethnicity'],$student['religion'],$student['religion_other']));
				
				for($x=1;$x<=$student['languages'];$x++)
				{
					$sql="insert into `sha_language` (`application_id`,`language`,`prof`) values (?,?,?)";
					$this->db->query($sql,array($stu['id'],$student['language'.$x],$student['languageProf'.$x]));
				}
			}
		}
	}
	
	function csvStudents2P2($students)
	{
		foreach($students as $student)
		{
			$sel="select * from `sha_one_remove` where `salesForce_id`='".$student['salesForceId']."'";
			$querySel=$this->db->query($sel);
			
			if($querySel->num_rows()>0)
			{
				$stu=$querySel->row_array();
				
				$sql="update `sha_two` set `live_with_pets`=?, `pet_dog`=?, `pet_cat`=?, `pet_bird`=?, `pet_other`=?, `pet_other_val`=?, `pet_live_inside`=?, `insurance`=?, `airport_pickup`=?, `home_student_past`=?, `home_student_exp`=?, `student_desc`=?, `student_family_desc`=?  where `id`=?";
				$this->db->query($sql,array($student['live_with_pets'],$student['pet_dog'],$student['pet_cat'],$student['pet_bird'],$student['pet_other'],$student['pet_other_val'],$student['live_with_pets_inside'],$student['travel_insurance'],$student['apu'],$student['in_homestay_in_past'],$student['in_homestay_in_past_exp'],$student['desc_student'],$student['desc_family'],$stu['id']));
			}
		}
	}
	
	function csvStudentsContactId($students)
	{	
		$counter=1;
		foreach($students as $student)
		{
				$sql="update `sha_one` set `PersonContactId`=?  where `salesForce_id`=?";
				$this->db->query($sql,array($student['PersonContactId'],$student['salesForceId']));
				///echo $counter.' '.$this->db->last_query().'<br>';
				
				echo $counter.', ';
				$counter++;
		}
	}
	
	function csvStudents3P1($students)
	{
		$counter=1;
		foreach($students as $student)
		{
			$sel="select * from `sha_one` where `salesForce_id`='".$student['salesForceId']."'";
			$querySel=$this->db->query($sel);
			if($querySel->num_rows()>0)
			{
				$stu=$querySel->row_array();
				
				$sql="insert into `sha_three` (`id`,`salesForce_id`,`diet_req`,`diet_veg`,`diet_gluten`,`diet_pork`,`diet_food_allergy`,`diet_other`,`diet_other_val`,`allergy_req`,`allergy_hay_fever`,`allergy_asthma`,`allergy_lactose`,`allergy_gluten`,`allergy_peanut`,`allergy_dust`,`allergy_other`,`allergy_other_val`,`smoker`,`medication`,`medication_desc`,`disabilities`,`disabilities_desc`) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
				$this->db->query($sql,array($stu['id'],$student['salesForceId'],$student['diet_req'],$student['diet_req_vegetarian'],$student['diet_req_gluten'],$student['diet_req_noPork'],$student['diet_req_foodAllergy'],$student['diet_req_other'],$student['diet_req_other_val'],$student['allergy'],$student['allergy_hay_fever'],$student['allergy_asthma'],$student['allergy_lactose'],$student['allergy_gluten'],$student['allergy_peanut'],$student['allergy_dust'],$student['allergy_other'],$student['allergy_other_val'],$student['smoker'],$student['medication'],$student['medication_info'],$student['disability'],$student['disability_info']));
			
				echo $counter.', ';
				$counter++;
			}
		}
	}
	
	function csvStudents3P2($students)
	{
		$counter=1;
		foreach($students as $student)
		{
			$sel="select * from `sha_one` where `salesForce_id`='".$student['salesForceId']."'";
			$querySel=$this->db->query($sel);
			if($querySel->num_rows()>0)
			{
				$stu=$querySel->row_array();
				
				$sql="update `sha_three` set `live_with_child11`=?, `live_with_child20`=?, `live_with_child_reason`=?, `family_include_smoker`=?, `family_pref`=? where `id`=?";
				$this->db->query($sql,array($student['children0To11'],$student['children12To20'],$student['childrenPrefReason'],$student['smokerFamily'],$student['family_pref'],$stu['id']));
			
				echo $counter.', ';
				$counter++;
			}
		}
	}
	
	
	function csvStudentsMissing($students)
	{
		foreach($students as $sK=>$student)
		{
			$sel="select * from `sha_one_remove` where `PersonContactId`='".$student['personContactId']."'";
			$querySel=$this->db->query($sel);
			if($querySel->num_rows()>0)
			{
				$row=$querySel->row_array();
				
				$shaOne="update `sha_one` set `accomodation_type`=?, `student_name2`=? where `id`=?";
				$this->db->query($shaOne,array($student['accomodationType'],$student['secondStudent'],$row['id']));
				
				
				$age=age_from_dob($row['dob']);
				if($row<18)
				{
					$caregiving	='0';
					$caregivingDesc='';
				}
				else
				{
					$caregiving	=$student['caregiving'];
					$caregivingDesc=$student['caregivingDesc'];
				}
				$shaTwo="update `sha_two` set `airport_pickup`=?, `airport_arrival_date`=?, `airport_arrival_time`=?, `airport_carrier`=?, `airport_flightno`=?, `guardianship`=?, `guardianship_requirements`=? where `id`=?";
				$this->db->query($shaTwo,array($student['airpirtPickup'],$student['arrival_date'],$student['arrival_time'],$student['arrival_carrier'],$student['arrival_flight_no'],$caregiving,$caregivingDesc,$row['id']));
				
				$shaThree="update `sha_three` set `campus`=?, `college`=?, `college_address`=?, `homestay_choosing_reason`=?, `homestay_hear_ref`=?, `homestay_hear_ref_other_val`=? where `id`=?";
				$this->db->query($shaThree,array($student['campus'],$student['college_name'],$student['college_address'],$student['ge_reason'],$student['ge_hear_about'],$student['ge_hear_about_other_val'],$row['id']));
			}
		}
	}
	
	
	function csvStudentsMissing2nd($students)
	{
		foreach($students as $sK=>$student)
		{
			$sel="select * from `sha_one_remove` where `PersonContactId`='".$student['personContactId']."'";
			$querySel=$this->db->query($sel);
			if($querySel->num_rows()>0)
			{
				$row=$querySel->row_array();
				
				$caregiving_end=date('Y-m-d',strtotime($row['dob'].' + 18 years'));
				$shaTwo="update `sha_two` set `guardian_assigned`=?, `guardianship_startDate`=?, `guardianship_endDate`=? where `id`=?";
				$this->db->query($shaTwo,array($student['caregiverId'],$student['caregiving_start'],$caregiving_end,$row['id']));
			}
		}
	}
	
	function csvStudentsStatus($students)
	{
		foreach($students as $sK=>$student)
		{
			$sel="select * from `sha_one_remove` where `PersonContactId`='".$student['personContactId']."'";
			$querySel=$this->db->query($sel);
			if($querySel->num_rows()>0)
			{
				$row=$querySel->row_array();
				
				$sqlClient="select * from `clients` where `salesForce_id`=?";
				$queryClient=$this->db->query($sqlClient,array($student['client_salesForce_id']));
				$clientArray=$queryClient->row_array();
				
				if(empty($clientArray))
					$client='7';
				else	
					$client=$clientArray['id'];
				$employee='10';
					
				$sha="update `sha_one` set `special_request_notes`=?, `client`=?, `employee`=?, `status`=?, `booking_from`=?, `booking_to`=? where `id`=?";
				$this->db->query($sha,array($student['notes'],$client,$employee,$student['status'],$student['booking_from'],$student['booking_to'],$row['id']));
			}
		}
	}
	
	function csvBookings($bookings)
	{
		foreach($bookings as $sK=>$booking)
		{
			$sel="select * from `sha_one_remove` where `PersonContactId`='".$booking['personContactId']."'";
			$querySel=$this->db->query($sel);
			if($querySel->num_rows()>0)
			{
				$row=$querySel->row_array();
				
				if($booking['host']=='')
				{
					$sha="update `sha_one` set `status`=? where `id`=?";
					$this->db->query($sha,array('cancelled',$row['id']));
				}
				else
				{
					if($booking['room']!='')
					{
						$hfa="select * from `hfa_one` where `salesForce_id`=?";
						$queryHfa=$this->db->query($hfa,$booking['host']);
						if($queryHfa->num_rows()>0)
						{
							$rowHfa=$queryHfa->row_array();
							
							$room="select * from `hfa_bedrooms` where `salesForce_id`=? and `application_id`=?";
							$queryRoom=$this->db->query($room,array($booking['room'],$rowHfa['id']));
							
							if($queryRoom->num_rows()>0)
							{
								$rowRoom=$queryRoom->row_array();
								$sqlBook="insert into `bookings` (`salesForce_id`,`salesForce_bookingNo`,`host`, `student`, `owner`, `booking_from`, `booking_to`,`room`, `status`,`date_added`) values(?,?,?,?,?,?,?,?,?,?)";
								$this->db->query($sqlBook,array($booking['salesForceId_booking'],$booking['salesForce_bookingNo'],$rowHfa['id'],$row['id'],$row['employee'],$booking['booking_from'],$booking['booking_to'],$rowRoom['id'],'progressive',$booking['creation_date']));
							
								if($booking['apu']!='')
								{
									$shaApu="update `sha_two` set `apu_company`=? where `id`=?";
									$this->db->query($shaApu,array($booking['apu'],$row['id']));
								}
							}
						}
					}
				}
			}
		}
	}
	
	function getHfaPhoneList()
	{
		$sql="select `mobile`, `home_phone`, `work_phone` from `hfa_one`";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	
	function booking($id)
	{
		$sql="select * from `bookings` where `salesForce_id`='".$id."'";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	
	function csvPO($pos)
	{
		foreach($pos as $po)
		{
			$sql="insert into `purchase_orders` (`booking_id`,`from`,`to`,`initial`,`status`,`date`) values (?,?,?,?,?,?)";
			$this->db->query($sql,array($po['po_structure']['booking_id'],$po['po_structure']['po_from'],$po['po_structure']['po_to'],'0','2',$po['creation_date']));
			
			$poId=$this->db->insert_id();
			
			foreach($po['po_structure']['items'] as $st)
			{
				$sqlIns="insert into `purchase_orders_items` (`po_id`,`desc`,`unit`,`qty_unit`,`qty`,`total`,`type`,`date`) values (?,?,?,?,?,?,?,?)";
				$this->db->query($sqlIns,array($poId,$st['desc'],$st['unit'],$st['qty_unit'],$st['qty'],$st['total'],$st['type'],$po['creation_date']));
			}
			
		}
	}
	
	function bookingListForCsv()
	{
		/*$sql="select `bookings`.*,`sha_one`.`arrival_date`, `purchase_orders`.`from` as `PO_from`, `purchase_orders`.`to` as `PO_to` from `bookings` join `sha_one` ON (`bookings`.`student`=`sha_one`.`id`) left join `purchase_orders` ON (`bookings`.`id`=`purchase_orders`.`booking_id`) where `bookings`.`salesForce_id`!='' and `bookings`.`status`!='cancelled'";
		$sql="select * from `bookings` where `salesForce_id`!=''";		
		$sql="select * from `bookings` where `id` NOT IN(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167,168,169,170,171,172,173,174,175,176,177,178,179,180,181,182,183,184,185,186,187,188,189,190,191,192,193,194,195,196,197,198,199,200,201,202,204,205,206,207,208,209,210,211,212,213,214,215,216,217,218,219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,240,241,242,243,244,245,246,247,248,249,250,251,252,253,254,255,256,257,258,259,260,261,262,263,264,265,266,267,268,269,270,271,272,273,274,275,276,277,278,279,280,281,282,283,284,285,286,287,288,289,290,291,292,293,294,295,296,297,298,299,300,301,302,303,304,305,306,307,308,309,310,311,312,313,314,315,316,317,318,319,320,321,322,323,324,325,326,327,328,329,330,331,332,333,334,335,336,337,338,339,340,341,342,343,344,345,346,347,348,349,350,351,352,353,354,355,356,357,358,359,360,361,362,363,364,365,366,367,368,369,370,371,372,373,374,375,376,377,378,379,380,381,382,383,384,385,386,387,388,389,390,391,392,393,394,395,396,397,398,399,400,401,402,403,404,405,406,407,408,409,410,411,412,413,414,415,416,417,419,420,423,424,425,426,427,428,429,430,431,432,433,434,435,436,437,438,439,440,441,442,443,444,445,446,447,448,449,450,451,452,453,454,455,456,457,458,459,460,461,462,463,464,465,466,467,468,469,470,471,472,473,474,475,476,477,478,479,480,481,482,483,484,485,486,487,488,489,490,491,492,493,495,496,497,498,499,500,501,503,504,505,506,507,508,509,510,511,512,513,514,515,516,517,518,519,520,521,522,523,525,526,527,528,529,530,533,534,535,537,538,539,540,541,542,543,544,545,546,547,548,549,550,551,552,553,554,555,556,557,558,559,560,561,562,564,565,567,568,569,572,573,574,575,576,577,578,579,580,581,582,583,584,585,586,587,588,591,592,595,596,597,598,599,600,601,602,603,604,605,606,607,608,613,614,615,616,617,618,619,620,622,631,632,633,634,635,636,637,645,646,647,650,651,652,653,654,655,656,657,658,659,660,661,662,663,665,667,668,669,670,672,673,674,675,676,677,678,679,680,681,682,683,684,686,687,688,689,690,691,692,693,694,695,696,697,698,699,700,701,702,705,706,707,708,709,710,711,712,713,714,717,718,719,720,721,722,723,724,725,726,727,728,729,730,731,733,734,735,736,737,738,739,740,741,742,743,744,745,746,747,749,750,751,752,753,755,759,763,764,767,769,770,771,772,773,774,775,776,777,778,779,781,782,784,785,786,787,788,789,790,791,792,793,794,795,796,797,798,799,800,801,803,804,805,806,808,809,811,812,813,815,816,817,819,821,822,823,824,825,826,827,828,830,831,832,833,834,837,838,840,841,842,843,845,846,847,848,849,852,854,855,856,857,858,859,862,863,865,866,867,868,869,870,873,874,875,876,877,878,879,880,881,882,883,885,886,887,889,891,892,894,895,896,898,899,900,901,902,903,904,905,906,907,908,909,910,911,912,913,914,915,916,917,918,919,922,923,924,925,926,927,928,931,932,933,934,935,936,937,938,939,940,941,942,943,944,945,946,947,949,950,951,952,953,954,955,956,957,958,960,961,962,963,964,965,966,967,970,971,972,973,974,975,976,977,978,979,980,981,982,983,984,985,986,987,988,989,990,991,992,993,994,995,996,998,999,1001,1002,1003,1005,1007,1008,1009,1010,1011,1012,1013,1015,1016,1017,1018,1019,1022,1026,1027,1028,1029,1030,1031,1032,1033,1034,1035,1036,1038,1039,1042,1043,1044,1045,1046,1047,1048,1049,1050,1051,1052,1053,1055,1056,1057,1058,1059,1060,1061,1062,1063,1064,1066,1067,1068,1070,1071,1072,1073,1074,1075,1076,1077,1078,1079,1080,1081,1082,1083,1084,1085,1086,1087,1088,1089,1090,1091,1092,1093,1094,1095,1096,1097,1098,1099,1100,1101,1102,1103,1104,1105,1106,1107,1108,1109,1110,1111,1112,1113,1114,1115,1116,1117,1118,1119,1120,1121,1122,1123,1124,1125,1126,1127,1128,1129,1130,1131,1132,1133,1134,1135,1136,1137,1138,1139,1140,1141,1142,1143,1144,1145,1146,1147,1148,1149,1150,1151,1152,1153,1154,1155,1156,1157,1158,1159,1160,1161,1162,1163,1164,1166,1167,1168,1169,1170,1171,1172,1173,1174,1175,1176,1177,1178,1179,1182,1183,1184,1185,1186,1187,1188,1189,1190,1191,1192,1193,1194,1195,1196,1197,1198,1199,1200,1201,1202,1203,1204,1205,1206,1207,1208,1209,1210,1211,1212,1213,1214,1215,1216,1217,1219,1220,1221,1222,1223,1224,1225,1226,1227,1228,1229,1230,1231,1232,1235,1236,1238,1239,1240,1241,1242,1243,1244,1245,1246,1247,1248,1249,1250,1251,1252,1253,1254,1255,1256,1257,1258,1259,1260,1261,1262,1263,1264,1265,1267,1268,1269,1270,1271,1272,1273,1274,1275,1276,1277,1278,1279,1280,1281,1282,1283,1284,1285,1286,1287,1289,1290,1291,1292,1293,1295,1296,1297,1298,1300,1301,1302,1303,1304,1305,1306,1307,1308,1309,1311,1312,1314,1315,1316,1317,1318,1319,1320,1321,1322,1323,1324,1325,1327,1329,1330,1331,1332,1333,1334,1335,1336,1337,1338,1339,1340,1341,1342,1343,1344,1345,1346,1347,1348,1349,1351,1352,1354,1355,1356,1358,1359,1360,1361,1362,1363,1364,1365,1366,1367,1368,1369,1370,1371,1372,1373,1374,1376,1377,1378,1379,1380,1381,1382,1383,1384,1385,1386,1387,1388,1390,1391,1392,1393,1394,1395,1396,1397,1400,1401,1402,1403,1404,1405,1406,1407,1408,1409,1410,1411,1412,1413,1414,1415,1416,1417,1418,1419,1420,1421,1422,1423,1424,1425,1426,1427,1428,1429,1430,1431) order by `id`";		*/
		
		$sql="select `bookings`.`id`, concat(`sha_one`.`fname`,' ',`sha_one`.`lname`) as `student`, `sha_one`.`arrival_date`, `sha_three`.`college`, concat(`hfa_one`.`fname`,' ',`hfa_one`.`lname`) as `host` from `bookings` join `sha_one` ON (`bookings`.`student`=`sha_one`.`id`) join `sha_three`   ON (`bookings`.`student`=`sha_three`.`id`) join `hfa_one`   ON (`bookings`.`host`=`hfa_one`.`id`) where ";
		$sql .="(`bookings`.`booking_to` > '2018-06-31' and `bookings`.`booking_from` <= '2018-08-31')";
		$sql .=" order by `bookings`.`id` ";		
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	
	function toUcwords()
	{
		$sql="select * from `hfa_one`";
		//$sql .=" where `id`>='0' and `id`<='5000'";
		//$sql .=" where `id`>='5000' and `id`<='10000'";
		//$sql .=" where `id`>='10000' and `id`<='15000'";
		//$sql .=" where `id`>='15000' and `id`<='20000'";
		//$sql .=" where `id`>='20000' and `id`<='25000'";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		//see($result);
		
		foreach($result as $res)
		{
			$fname=ucwords($res['fname']);
			$update ="update `hfa_one` set `fname`=? where `id`='".$res['id']."'";
			$this->db->query($update,array($fname));
		}
	}
	
	function studentDates1($student)
	{
		$sql="update `sha_one` set `date`=? where `salesForce_id`=? and `status`='new'";
		$this->db->query($sql,array($student['creation_date'],$student['salesForceId_booking']));
		
		$sql2="update `sha_one` set `date`=?, `date_status_changed`=? where `salesForce_id`=? and  `status`!='new'";
		$this->db->query($sql2,array($student['creation_date'],$student['creation_date'],$student['salesForceId_booking']));
		
	}
	
	function clientsWithStar1($client)
	{
		$sql="update `clients` set `bname`=concat(`bname`,' *') where `salesForce_id`=?";
		$this->db->query($sql,array($client['salesForceId_booking']));
	}
	
	function bookingInSystem($bookings)
	{
		foreach($bookings as $booking)
		{
			//$sql="update `bookings1` set `booking_from`=?, `booking_to`=?, `notes`=? where `salesForce_id`=?";
			//$this->db->query($sql,array($booking['start_date'],$booking['end_date'],$booking['notes'],$booking['salesForceId_booking']));
			//echo $booking['start_date'].', '.$booking['end_date'].', '.$booking['notes'].', '.$booking['salesForceId_booking'].'<br>';
			
			//$sql="update `bookings1` set `date_added`=? where `salesForce_id`=?";
			//$this->db->query($sql,array(date('Y-m-d',strtotime($booking['start_date'].' - 1 week')),$booking['salesForceId_booking']));
			
			//echo date('Y-m-d',strtotime($booking['start_date'].' - 1 week')).' '.$booking['salesForceId_booking'].'<br>';
			
			$statusChangeDate='';
			if($booking['status']=='Arrived')
			{
				$status='arrived';
				$statusChangeDate=$booking['start_date'];
			}
			elseif($booking['status']=='Cancelled' || $booking['status']=='Cancenlled')
			{
				$status='cancelled';
				$statusChangeDate=date('Y-m-d',strtotime($booking['start_date'].' - 1 day'));
			}
			elseif($booking['status']=='Expected Arrival')
			{
				$status='expected_arrival';
				$statusChangeDate='';
			}
			elseif($booking['status']=='Moved out')
			{
				$status='moved_out';
				$statusChangeDate=$booking['end_date'];
			}
			elseif($booking['status']=='Processive')
			{
				$status='progressive';
				$statusChangeDate=date('Y-m-d',strtotime($booking['start_date'].' + 1 week'));
			}
			
			$sql="update `bookings1` set `status`=?, `date_status_changed`=? where `salesForce_id`=?";
			$this->db->query($sql,array($status,$statusChangeDate,$booking['salesForceId_booking']));
		}
	}
	
	function deleteOldPos()
	{
		$sql="select * from `bookings11` where `salesForce_id`!=''";
		$query=$this->db->query($sql);
		if($query->num_rows()>0)
		{
			$bookings=$query->result_array();see($bookings);
			
			foreach($bookings as $booking)
			{
				$sqlPo="select * from `purchase_orders` where `booking_id`='".$booking['id']."'";
				$queryPo=$this->db->query($sqlPo);
				if($queryPo->num_rows()>0)
				{
					$po=$queryPo->row_array();
					
					$sqlDel="delete from `purchase_orders_items` where `po_id`='".$po['id']."'";
					$this->db->query($sqlDel);
					
					$sqlDelPo="delete from `purchase_orders` where `booking_id`='".$booking['id']."'";
					$this->db->query($sqlDelPo);
					
				}
				
			}
		}
	}
	
	function bookingInSystemPo($pos)
	{
		foreach($pos as $po)
		{	
			if(!empty($po['po_structure']))
			{
				$sql="insert into `purchase_orders1` (`booking_id`,`from`,`to`,`initial`,`status`,`date`) values (?,?,?,?,?,?)";
				$this->db->query($sql,array($po['po_structure']['booking_id'],$po['po_structure']['po_from'],$po['po_structure']['po_to'],'0','2',$po['po_structure']['po_from']));
				//echo '<br><br>'.$po['po_structure']['booking_id'].'  '.$po['po_structure']['po_from'].' '.$po['po_structure']['po_to'].' '.$po['po_structure']['po_from'].'<br>';
				
				$poId=$this->db->insert_id();
				
				foreach($po['po_structure']['items'] as $st)
				{
					$sqlIns="insert into `purchase_orders_items1` (`po_id`,`desc`,`unit`,`qty_unit`,`qty`,`total`,`type`,`date`) values (?,?,?,?,?,?,?,?)";
					$this->db->query($sqlIns,array($poId,$st['desc'],$st['unit'],$st['qty_unit'],$st['qty'],$st['total'],$st['type'],$po['po_structure']['po_from']));
					
					//echo '>>>>>>>>>      '.$st['desc'].' '.$st['unit'].' '.$st['qty_unit'].' '.$st['qty'].' '.$st['total'].' '.$st['type'].' '.$po['po_structure']['po_from'].'<br>';
				}
			}
		}
	}
	
	
	function invoiceName1243()
	{
		$sql="select a.*, b.`application_id` as `sha_id`, b.`study_tour` from `invoice_initial_items` a  join `invoice_initial` b ON(a.`invoice_id`=b.`id`) where a.`application_id`='0'";
		$query=$this->db->query($sql);
		$inv=$query->result_array();
		
		//see($inv);
		foreach($inv as $inK=>$in)
		{
			$sqlInv="select * from `sha_one` where `id`='".$in['sha_id']."'";
			$queryInv=$this->db->query($sqlInv);
			$res=$queryInv->row_array();
			//echo $this->db->last_query().'<br>';
			//see($res);
			$inv[$inK]['fname']=$res['fname'];
			$inv[$inK]['lname']=$res['lname'];
			
			/*$sqlInv="select * from `invoice_initial_items` where `id`='".$in['id']."' and `desc` like '%".$in['fname']."%'";
			$queryInv=$this->db->query($sqlInv);
			$res=$queryInv->row_array();
			see($res);*/
		}
		
		//see($inv);
		$count=0;
		foreach($inv as $ins)
		{
			$sqlInv1="select * from `invoice_initial_items` where `id`='".$ins['id']."' and `desc` like '%".$ins['fname']."%'";
			$queryInv1=$this->db->query($sqlInv1);
			$res=$queryInv1->row_array();
			//echo $this->db->last_query().'<br>';
			if(!empty($res))
			{
				//see($ins);
				$count++;
			}
			else
			{
				/*$name=$ins['fname'].' '.$ins['lname'].' - ';
				$sqlUp="update `invoice_initial_items` set `desc`=concat('".$name."',`desc`) where `id`='".$ins['id']."'";
				$this->db->query($sqlUp);
				echo $this->db->last_query().'<br>';*/
			}
		}
		echo 'count ='.$count;
	}
	
	
	
	function invoiceNameOngoing124()
	{
		$sql="select a.*, b.`application_id` as `sha_id`, b.`study_tour` from `invoice_ongoing_items` a  join `invoice_ongoing` b ON(a.`invoice_id`=b.`id`) where a.`application_id`='0'";
		$query=$this->db->query($sql);
		$inv=$query->result_array();
		
		//see($inv);
		foreach($inv as $inK=>$in)
		{
			$sqlInv="select * from `sha_one` where `id`='".$in['sha_id']."'";
			$queryInv=$this->db->query($sqlInv);
			$res=$queryInv->row_array();
			//echo $this->db->last_query().'<br>';
			//see($res);
			$inv[$inK]['fname']=$res['fname'];
			$inv[$inK]['lname']=$res['lname'];
			
			/*$sqlInv="select * from `invoice_initial_items` where `id`='".$in['id']."' and `desc` like '%".$in['fname']."%'";
			$queryInv=$this->db->query($sqlInv);
			$res=$queryInv->row_array();
			see($res);*/
		}
		
		//see($inv);
		$count=0;
		foreach($inv as $ins)
		{
			$sqlInv1="select * from `invoice_ongoing_items` where `id`='".$ins['id']."' and `desc` like '%".$ins['fname']."%'";
			$queryInv1=$this->db->query($sqlInv1);
			$res=$queryInv1->row_array();
			//echo $this->db->last_query().'<br>';
			if(!empty($res))
			{
				//see($ins);
				$count++;
			}
			else
			{
				see($ins);
				/*$name=$ins['fname'].' '.$ins['lname'].' - ';
				$sqlUp="update `invoice_ongoing_items` set `desc`=concat('".$name."',`desc`) where `id`='".$ins['id']."'";
				$this->db->query($sqlUp);
				echo $this->db->last_query().'<br>';*/
			}
		}
		echo 'count ='.$count;
	}
	
	
	function findStudentForInvoiceUpload($data)
	{
		/*$host=explode(' ',str_replace('(Global)','',$data['G']));
		$student=explode(' ',$data['I']);*/
		
		preg_match_all('/\b([A-Z]+)\b/', $data['G'], $hostLname);
		preg_match_all('/\b([A-Z]+)\b/', $data['I'], $studentLname);
		
		$booking=array();
		//$sql="select `bookings`.* from `bookings` join `sha_one` on(`bookings`.`student`=`sha_one`.`id`) join `hfa_one` on (`bookings`.`host`=`hfa_one`.`id`) where concat(`sha_one`.`fname`,' ',`sha_one`.`lname`) like '".$data['I']."' and  `hfa_one`.`lname` like '".$host[0]."'";
		
		$sqlStudentNo="select `bookings`.* from `bookings` join `sha_one` on(`bookings`.`student`=`sha_one`.`id`) join `hfa_one` on (`bookings`.`host`=`hfa_one`.`id`) where `sha_one`.`sha_student_no` = '".$data['H']."' and  `hfa_one`.`lname` like '".implode(' ',$hostLname[0])."'";
		$queryStudentNo=$this->db->query($sqlStudentNo);
		if($queryStudentNo->num_rows()>0)
			$booking=$queryStudentNo->row_array();
		else
		{
			$sql="select `bookings`.* from `bookings` join `sha_one` on(`bookings`.`student`=`sha_one`.`id`) join `hfa_one` on (`bookings`.`host`=`hfa_one`.`id`) where `sha_one`.`lname` like '".implode(' ',$studentLname[0])."' and  `hfa_one`.`lname` like '".implode(' ',$hostLname[0])."' and `sha_one`.`client`='1179'";
			//$sql="select `bookings`.`id` from `bookings` join `sha_one` on(`bookings`.`student`=`sha_one`.`id`) join `hfa_one` on (`bookings`.`host`=`hfa_one`.`id`) where `sha_one`.`fname` like '%".$student[0]."%' and  `hfa_one`.`lname` like '".$host[0]."'";
			$query=$this->db->query($sql);
			
			if($query->num_rows()>0)
			{
				$booking=$query->row_array();
				if($query->num_rows()>1)
					$booking=2;
			}
		}
		return $booking;
		
		
		
		$host=explode(' ',str_replace('(Global)','',$data['G']));
		$student=explode(' ',$data['I']);
		$sql="select `bookings`.`id` from `bookings` join `sha_one` on(`bookings`.`student`=`sha_one`.`id`) join `hfa_one` on (`bookings`.`host`=`hfa_one`.`id`) where concat(`sha_one`.`fname`,' ',`sha_one`.`lname`) like '".$data['I']."' and  `hfa_one`.`lname` like '".$host[0]."'";
		$sql="select `bookings`.`id` from `bookings` join `sha_one` on(`bookings`.`student`=`sha_one`.`id`) join `hfa_one` on (`bookings`.`host`=`hfa_one`.`id`) where `sha_one`.`fname` like '%".$student[0]."%' and  `hfa_one`.`lname` like '".$host[0]."'";
		$query=$this->db->query($sql);
		if($query->num_rows()>0)
		{
			$booking=$query->row_array();
			echo $data['H'].' => '.$booking['id'].'<br>';
		}
		else
			echo '0----'.$data['H'].'   -> '.$this->db->last_query().'<br>';
		
		/*
		$sqlSha="select * from 	`sha_one` where concat(`fname`,' ',`lname`) like '".$data['I']."'";
		$querySha=$this->db->query($sqlSha);//echo $this->db->last_query().'<br>';
		
		$host=explode(' ',str_replace('(Global)','',$data['G']));
		$sqlHfa="select * from 	`hfa_one` where `lname` like '".$host[0]."'";
		$queryHfa=$this->db->query($sqlHfa);//echo $this->db->last_query().'<br><br>';
			
		if($querySha->num_rows()>0 && $queryHfa->num_rows()>0)
		{
			if($querySha->num_rows()>1 && $queryHfa->num_rows()>1)	
				echo $data['H'].'<br>';
			
		}*/
	}
	
	
	
	function invoiceUploadInsert($invoice)
	{
		$sql="insert into `invoice_group` (`client`,`date_from`,`date_to`,`status`,`imported`,`date`) values(?,?,?,?,?,?)";
		$this->db->query($sql,array('41',$invoice['date_from'],$invoice['date_to'],'3','1',date('Y-m-d H:i:s')));
		$invoiceId=$this->db->insert_id();
		
		foreach($invoice['items'] as $item)
		{
			$sqlItem="insert into `invoice_group_items` (`invoice_id`,`sha_id`,`booking_id`,`date_from`,`date_to`,`desc`,`unit`,`qty`,`qty_unit`,`total`,`gst`,`type`,`date`) values(?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$this->db->query($sqlItem,array($invoiceId, $item['sha_id'], $item['booking_id'], $item['date_from'], $item['date_to'], $item['desc'], $item['unit'], $item['qty'], $item['qty_unit'], $item['total'], $item['gst'], $item['type'],date('Y-m-d H:i:s')));
		}
	}
	
	function bookingsWithSFId()
	{
		$sql="select * from `bookings` where `salesForce_id`!=''";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		return $result;
	}
	
	function bookingImport($data)
	{
		foreach($data as $book)
		{
			$sql="insert into `bookings` (`host`,`student`,`owner`,`booking_from`,`booking_to`,`room`,`status`,`date_added`)values(?,?,?,?,?,?,?,?)";
			$this->db->query($sql,array($book['host'],$book['student'],10,$book['from'],$book['to'],$book['room'],$book['status'],$book['from']));
			//echo $this->db->last_query().'<br>';
			echo $book['student'].' > '.$this->db->insert_id().'<br>';
		}
	}
	
	
	
	
	
	function updatePendingInvoice($data)
	{
		$this->load->model('invoice_model');
		$invoice=$this->invoice_model->initialInvoiceBeforeUpdate($data['shaChangeStatus_id'],$data['booking_from'],$data['booking_to']);
		//see($invoice);die();
		$studentnameArr=getShaOneAppDetails($data['shaChangeStatus_id']);
		$studentname=$studentnameArr['fname'].' '.$studentnameArr['lname'].' - ';
		if(!empty($invoice))
		{
			$invoice=adjustPlacementFee_shaInitialInvoice($invoice,$data['shaChangeStatus_id']);
			
			if($data['dates_available']=='0')
				$invoice['booking_from']=$invoice['booking_to']='0000-00-00';
				
			$invoice_id=nextInvoiceId();
			$sql="insert into `invoice_initial` (`id`,`application_id`,`booking_from`,`booking_to`,`date`) values(?,?,?,?)";
			$this->db->query($sql,array($invoice_id,$data['shaChangeStatus_id'],$invoice['booking_from'],$invoice['booking_to'],date('Y-m-d H:i:s')));
			//$invoice_id=$this->db->insert_id();
			/*$sql="update `invoice_initial` set `booking_from`=?, `booking_to`=? where `id`=?";
			$this->db->query($sql, array($invoice['booking_from'],$invoice['booking_to'],$data['invoice_id']));
			$invoice_id=$data['invoice_id'];
			
			$sqlDel="delete from `invoice_initial_items` where `invoice_id`='".$data['invoice_id']."'";
			$this->db->query($sqlDel);
			$sqlDel="delete from `invoice_initial_items_standard` where `invoice_id`='".$data['invoice_id']."'";
			$this->db->query($sqlDel);*/
			
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
		return $invoice;
	}
	
	function getRoomId($host,$room)
	{
		$roomTypeList=roomTypeList();
		$sql="select * from `hfa_bedrooms` where `application_id`='".$host."' order by `id`";
		$query=$this->db->query($sql);
		$res=$query->result_array();//see($res);
		$index=$room-1;
		return $res[$index]['id'];
		return $res[$index]['id'].' ('.$roomTypeList[$res[$index]['type']].')';
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
		}
		else
		{
			/*$sql="delete `invoice_ongoing` where `id`=?";
			$this->db->query($sql, array($invoice['id']));*/
		}
	}
}