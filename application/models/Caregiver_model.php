<?php 

class Caregiver_model extends CI_Model { 


		function companyList()
		{
			$sql="select * from `caregiverCompany` order by `name`";
			$query=$this->db->query($sql);
			return $query->result_array();
		}
		
		function companyDetail($id)
		{
			$query=$this->db->query("select * from `caregiverCompany` where `id`='".$id."'");
			return $query->row_array();
		}
		
		function getCaregiversByCompany($id)
		{
			$query=$this->db->query("select * from `caregiver` where `company`='".$id."'");
			return $query->result_array();
		}
		
		function caregiverDetail($id)
		{
			$query=$this->db->query("select * from `caregiver` where `id`='".$id."'");
			return $query->row_array();
		}
	
		function validateCompany($data)
		{
			$sql="";
			if(isset($data['id']))
				$sql .=" and `id`!='".$data['id']."'";
				
			$sqlBname="Select * from `caregiverCompany` where `name` = ?".$sql;
			$queryBname=	$this->db->query($sqlBname,$data['CGCname']);
			//echo $this->db->last_query();
			if ($queryBname->num_rows() > 0)
				return array('cname'=>1);
			else
				return 'yes';
		}
		
		function createCompany($data)
		{
			$sql="insert into `caregiverCompany` (`name`,`abn`,`street_address`,`suburb`,`state`,`postcode`,`i_name`,`i_phone`,`i_email`,`date`) values(?,?,?,?,?,?,?,?,?,?)";
			$this->db->query($sql,array($data['CGCname'],$data['CGCabn'],$data['CGCaddress'],$data['CGCsuburb'],$data['CGCstate'],$data['CGCpostal_code'],$data['CGCi_name'],$data['CGCi_phone'],$data['CGCi_email'],date('Y-m-d H:i:s')));
			$id=$this->db->insert_id();
			
			recentActionsAddData('caregiver',$id,'add');
			return $id;
		}
		
		function editCompany($data)
		{
			$sql="update `caregiverCompany` set `name`=?,`abn`=?,`street_address`=?,`suburb`=?,`state`=?,`postcode`=?,`i_name`=?,`i_phone`=?,`i_email`=? where `id`=?";
			$this->db->query($sql,array($data['CGCname'],$data['CGCabn'],$data['CGCaddress'],$data['CGCsuburb'],$data['CGCstate'],$data['CGCpostal_code'],$data['CGCi_name'],$data['CGCi_phone'],$data['CGCi_email'],$data['id']));
			return $data['id'];
		}
		
		function addCG($data)
		{
			$sql="insert into `caregiver` (`company`,`fname`,`lname`,`phone`,`email`,`gender`,`date`) values (?,?,?,?,?,?,?)";
			$this->db->query($sql,array($data['company_id'],$data['addCG_fname'],$data['addCG_lname'],$data['addCG_phone'],$data['addCG_email'],$data['addCG_gender'],date('Y-m-d H:i:s')));
		}
		
		function editCG($data)
		{
			$sql="update `caregiver` set `fname`=?,`lname`=?,`phone`=?,`email`=?,`gender`=? where `id`=?";
			$this->db->query($sql,array($data['addCG_fname'],$data['addCG_lname'],$data['addCG_phone'],$data['addCG_email'],$data['addCG_gender'],$data['caregiver_id']));
			return $data['caregiver_id'];
		}
		
		function deleteCG($id)
		{
			$sql="delete from `caregiver` where `id`='".$id."'";
			$this->db->query($sql);
		}
		
		function deleteCompany($id)
		{
			$caregivers=$this->getCaregiversByCompany($id);
			if(empty($caregivers))
			{
				$sql="delete from `caregiverCompany` where `id`='".$id."'";
				$this->db->query($sql);
				echo 'done';
			}
		}
		
}