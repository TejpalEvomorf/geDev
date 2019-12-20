<?php 

class Guardian_model extends CI_Model { 

function validateGuardian($data)
		{
			$sql="";
			if(isset($data['id']))
				$sql .=" and `id`!='".$data['id']."'";
				
			$sqlBname="Select * from `guardians` where `company_name` = ?".$sql;
			$queryBname=	$this->db->query($sqlBname,$data['cname']);
			//echo $this->db->last_query();
			if ($queryBname->num_rows() > 0)
				$cname=1;
			else	
				$cname=0;

			$sqlPEmail="Select * from `guardians` where `email` = ?".$sql;
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
		
		function createGuardian($data)
		{
			$sql="insert into `guardians` (`fname`,`lname`,`company_name`,`abn`,`street_address`,`suburb`,`state`,`postal_code`,`phone`,`email`,`gender`,`incharge_name`,`incharge_email`,	`incharge_phone`,`date_added`) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$this->db->query($sql,array($data['fname'],$data['lname'],$data['cname'],$data['abn'],$data['address'],$data['suburb'],$data['state'],$data['postal_code'],$data['phone'],$data['email'],$data['gender'],$data['i_name'],$data['i_email'],$data['i_phone'],date('Y-m-d H:i:s')));
			return $this->db->insert_id();
		}
		
		function editGuardian($data)
		{
			$sql="update `guardians` set `fname`=?,`lname`=?,`company_name`=?,`abn`=?,`street_address`=?,`suburb`=?,`state`=?,`postal_code`=?,`phone`=?,`email`=?,`gender`=?,`incharge_name`=?,`incharge_email`=?,`incharge_phone`=? where `id`=?";
			$this->db->query($sql,array($data['fname'],$data['lname'],$data['cname'],$data['abn'],$data['address'],$data['suburb'],$data['state'],$data['postal_code'],$data['phone'],$data['email'],$data['gender'],$data['i_name'],$data['i_email'],$data['i_phone'],$data['id']));
		}
		
		function guardianDetail($id)
		{
			$sql="select * from `guardians` where `id`='".$id."'";
			$query=$this->db->query($sql);
			$client=$query->row_array();
			
			return $client;
		}
		
		function guardianList()
		{
			$sql="select * from `guardians` order by `fname`";
			$query=$this->db->query($sql);
			$list=$query->result_array();
			
			return $list;
		}
		
		function deleteGuardian($id)
		{
			if($id!=8)
			{
				$sql="delete from `guardians` where `id`='".$id."'";
				$this->db->query($sql);
			}
		}
		
}