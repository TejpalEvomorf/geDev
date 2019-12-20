<?php 

class Apu_company_model extends CI_Model { 

function validateApuCompany($data)
		{
			$sql="";
			if(isset($data['id']))
				$sql .=" and `id`!='".$data['id']."'";
				
			$sqlBname="Select * from `apu_company` where `company_name` = ?".$sql;
			$queryBname=	$this->db->query($sqlBname,$data['cname']);
			//echo $this->db->last_query();
			if ($queryBname->num_rows() > 0)
				$cname=1;
			else	
				$cname=0;

			$sqlPEmail="Select * from `apu_company` where `email` = ?".$sql;
			$queryPEmail=	$this->db->query($sqlPEmail,$data['email']);
			//echo $this->db->last_query();
			if ($queryPEmail->num_rows() > 0)
				$email=1;
			else	
				$email=0;

			if($cname==1 || $email==1)
				return array('cname'=>$cname, 'email'=>$email);
			else
				return 'yes';
		}
		
		function createApuCompany($data)
		{
			$sql="insert into `apu_company` (`name`,`company_name`,`phone`,`email`,`date_added`) values(?,?,?,?,?)";
			$this->db->query($sql,array(trim($data['name']),$data['cname'],$data['phone'],$data['email'],date('Y-m-d H:i:s')));
			$id=$this->db->insert_id();
			recentActionsAddData('apuCompany',$id,'add');
			return $id;
		}
		
		function editApuCompany($data)
		{
			$sql="update `apu_company` set `name`=?,`company_name`=?,`phone`=?,`email`=? where `id`=?";
			$this->db->query($sql,array(trim($data['name']),$data['cname'],$data['phone'],$data['email'],$data['id']));
		}
		
		function apuCompanyDetail($id)
		{
			$sql="select * from `apu_company` where `id`='".$id."'";
			$query=$this->db->query($sql);
			$client=$query->row_array();
			
			return $client;
		}
		
		function apuCompanyList()
		{
			$sql="select * from `apu_company` order by `company_name`";
			$query=$this->db->query($sql);
			$list=$query->result_array();
			
			return $list;
		}
		
		function deleteApuCompany($id)
		{
				$sql="delete from `apu_company` where `id`='".$id."'";
				$this->db->query($sql);
		}
		
}