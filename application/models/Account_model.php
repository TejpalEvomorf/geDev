<?php 

class Account_model extends CI_Model { 

		function employeeList()
		{
			$sql="select * from `employees` order by `fname`";
			$query=$this->db->query($sql);
			return $query->result_array();
		}
		
		function createEmployee($data)
		{
			$sql="insert into `employees` (`fname`,`lname`,`designation`,`office`,`phone`,`email_company`,`email_personal`,`gender`,`phone_office`) values(?,?,?,?,?,?,?,?,?)";
			$this->db->query($sql,array($data['name'],$data['lname'],$data['designation'],$data['office'],$data['phone'],$data['company_email'],$data['personal_email'],$data['gender'],$data['office_phone']));
			$empid=$this->db->insert_id();
			
			$sqlUser="insert into `users` (`user_id`,`uname`,`password`,`user_type`) values(?,?,?,?)";
			$this->db->query($sqlUser,array($empid,$data['company_email'],passEncrypt($data['password']),2));

			return $empid;
		}
		
	function validateEmployee($data)
		{
			$sqlBname="Select * from `employees` where `email_company` = ?";
			if(isset($data['id']))
				$sqlBname .=" and `id`!='".$data['id']."'";
			$queryBname=	$this->db->query($sqlBname,$data['company_email']);
			//echo $this->db->last_query();
			if ($queryBname->num_rows() > 0)
				$company_email=1;
			else	
				$company_email=0;

			if($company_email==1)
				return array('company_email'=>$company_email);
			else
				return 'yes';
		}
		
		function editEmployee($data)
		{
			$sql="update `employees` set `fname`=?,`lname`=?,`phone`=?,`email_company`=?,`email_personal`=?,`gender`=?,`phone_office`=? where `id`=?";
			$this->db->query($sql,array($data['name'],$data['lname'],$data['phone'],$data['company_email'],$data['personal_email'],$data['gender'],$data['office_phone'],$data['id']));
			
			if(isset($data['password']))
			{
				$sqlUsers="update `users` set `uname`=?, `password`=? where `user_id`=?";
				$this->db->query($sqlUsers,array($data['company_email'],passEncrypt($data['password']),$data['id']));
			}
		}
		
		function deleteEmployee($id)
		{
			$this->deleteEmployeeImage($id);
			$sql="delete from `employees` where `id`='".$id."'";
			$this->db->query($sql);
			
			$sqlUser="delete from `users` where `user_id`='".$id."'";
			$this->db->query($sqlUser);
		}
		
		function employee_details($id)
		{
			$sql="select `employees`.*, `users`.`password` from `employees` JOIN `users` ON(`employees`.`id`=`users`.`user_id`) where `employees`.`id`='".$id."'";
			$query=$this->db->query($sql);
			//echo $this->db->last_query();
			return $query->row_array();
		}
		
		function employee_image_upload($id,$imagename)
		{
			$this->deleteEmployeeImage($id);
			$sql="update `employees` set `image`='".$imagename."' where `id`='".$id."'";
			$this->db->query($sql);
		}
		
		function deleteEmployeeImage($id)
		{
			$emp=$this->employee_details($id);
			if(!empty($emp) && $emp['image']!='')
				unlink('static/uploads/employee/'.$emp['image']);
		}
		
		function updateEmpDesignation($data)
		{
			$sql="update `employees` set `designation`='".$data['designation']."' where `id`='".$data['id']."'";
			$this->db->query($sql);
		}
		
		function updateEmpOffice($data)
		{
			$sql="update `employees` set `office`='".$data['office']."' where `id`='".$data['id']."'";
			$this->db->query($sql);
		}
		
		function checkEmpAppCount($data)
		{
			$sql="select * from `sha_one` where `employee`='".$data['id']."'";
			$query=$this->db->query($sql);
			//echo $this->db->last_query();
			return $query->num_rows();
		}
		
		function assignDiffEmpToAppSubmit($data)
		{
			$sql="update `sha_one` set `employee`='".$data['assignDiffEmpToApp_emp']."' where `employee`='".$data['id']."'";
			$query=$this->db->query($sql);
		}
		
		function changePasswordSubmit($data)
		{
			$loggedInUser=loggedInUser();
			$sql="update `users` set `password`='".passEncrypt($data['password'])."' where `user_id`='".$loggedInUser['id']."'";
			$query=$this->db->query($sql);
		}	
	
		function recentActionsAdd($data)
		{
			$loggedInUser=loggedInUser();
			$user_id=$loggedInUser['id'];
			$date=date('Y-m-d H:i:s');
			
			$add=false;
			$actionRepeated=$this->db->query("select * from `recent_actions` where `user_id`=? order by `date` DESC, `id` DESC limit 1",array($user_id))->row_array();
			if(!empty($actionRepeated))
			{
				if($actionRepeated['action_on_type']==$data['action_on_type'] && $actionRepeated['action_on']==$data['action_on'] && $actionRepeated['action']==$data['action'])
					$this->db->query("update `recent_actions` set `date`=? where `id`=?",array($date,$actionRepeated['id']));
				else
						$add=true;
			}
			else
				$add=true;	
			
			if($add && !empty($actionRepeated))
			{
				if(($actionRepeated['action_on_type']=='tour' || $actionRepeated['action_on_type']=='client') && $actionRepeated['action_on']==$data['action_on'] && $actionRepeated['action']=='add' && $data['action']=='view')
					$add=false;
			}
				
			if($add)
				$this->db->query("INSERT INTO `recent_actions`(`user_id`, `action_on_type`, `action_on`, `action`, `date`) VALUES (?,?,?,?,?)",array($user_id,$data['action_on_type'],$data['action_on'],$data['action'],$date));
		}
		
		
		function userRecentActivities()
		{
			$loggedInUser=loggedInUser();
			$user_id=$loggedInUser['id'];
			$res=$this->db->query("select * from `recent_actions` where `user_id`=$user_id order by `date` DESC, `id` DESC limit 0,15")->result_array();
			$rA=array();
			foreach($res as $r)
				$rA[]=$r['id'];
			if(!empty($rA))
			{
				$ids="'".implode("','",$rA)."'";
				$this->db->query("delete from `recent_actions` where `user_id`=$user_id and `id` NOT IN($ids)");
			}
			return $res; 
		}
}

?>