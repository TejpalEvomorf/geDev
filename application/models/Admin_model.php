<?php 

class Admin_model extends CI_Model { 

	function login($data)
	{
		$sql="Select * from `users` where `uname` = ? and `password` = ? and `active`='1'";
		$query	=	$this->db->query($sql,array($data['uname'],passEncrypt($data['password'])));
		//echo $this->db->last_query();
		if ($query->num_rows() > 0)
				return $query->row_array(); 
		else
				return false;
	}
	
	function loggedInUser($id)
	{
		$sql="Select * from `users` where `id` = ? ";
		$query	=	$this->db->query($sql,$id);
		$user=$query->row_array(); 
		//echo $this->db->last_query();
		$user_type=$user['user_type'];
		$user_id=$user['user_id'];
		
		if($user_type==1)
			$table="`admin`";
		elseif($user_type==2)
			$table="`employees`";
			
		$sqlUser="select * from $table where `id`=?";
		$queryUser=$this->db->query($sqlUser,$user_id);
		//echo $this->db->last_query();
		$loggedInUser=$queryUser->row_array();
		$loggedInUser['uname']=$user['uname'];
		$loggedInUser['user_type']=$user['user_type'];
		$loggedInUser['user_id']=$user['id'];//from users table
		if($user_type==1)
		$loggedInUser['gender']='1';
		return $loggedInUser;
	}
	
	
	function selectProfilePhotoSubmit($data)
	{
		$sqlDel="update `".$data['hfaSha']."_photos` set `default`='0' where  `application_id`='".$data['id']."'";
		$this->db->query($sqlDel);
		
		$sql="update `".$data['hfaSha']."_photos` set `default`='1' where `id`='".$data['profilePic']."' and `application_id`='".$data['id']."'";
		$this->db->query($sql);
		
		$resSel=hfaShaProfilePic($data['id'],$data['hfaSha']);
		if(!empty($resSel))
			echo static_url().'uploads/'.$data['hfaSha'].'/photos/thumbs/'.$resSel['name'];
	}
	
	function hfaShaProfilePic($id,$hfaSha)
	{
		$sqlSel="select * from `".$hfaSha."_photos` where `application_id`='".$id."' and `default`='1'";
		$querySel=$this->db->query($sqlSel);
		//return $resSel=$querySel->row_array();
		$resSel=$querySel->row_array();
		/*if(empty($resSel))
		{
			$sql="select * from `".$hfaSha."_photos` where `application_id`='".$id."' order by `date` DESC";
			$query=$this->db->query($sql);
			$res=$query->row_array();
			return $res;
		}
		else*/
		return $resSel;
		
	}
	
	function hfaShaProfilePicLatest($id,$hfaSha)
	{
			$sql="select * from `".$hfaSha."_photos` where `application_id`='".$id."' order by `date` ASC";
			$query=$this->db->query($sql);
			$res=$query->row_array();
			return $res;
	}
	
	function deleteApplicationPhotos($data)
	{
		$id=$data['id'];
		$hfaSha=$data['hfaSha'];
		
		$sqlSel="select *  from `".$hfaSha."_photos` where `id`='".$id."'";
		$querySel=$this->db->query($sqlSel);
		if($querySel->num_rows()>0)
		{
			$res=$querySel->row_array();
			unlink('static/uploads/'.$hfaSha.'/photos/'.$res['name']);
			unlink('static/uploads/'.$hfaSha.'/photos/thumbs/'.$res['name']);
		}
		
		$sql="delete from `".$hfaSha."_photos` where `id`='".$id."'";
		$this->db->query($sql);
		
		$sqlSel="select * from `".$hfaSha."_photos` where `application_id`='".$data['application_id']."' order by `date` DESC";
		$querySel=$this->db->query($sqlSel);
		return $querySel->result_array();
	}
	
	function delete_remember_cookie($id)
	{
		$sql="delete from `remember_cookies` where `user_id`='$id'";
		$this->db->query($sql);
	}

	//saving cookie
	function remember_cookie($cookieemail,$cookieuserid)
	{	
		$sql = "INSERT INTO `remember_cookies` (user_id,cookie_name) VALUES (?,?) ";
		$this->db->query($sql,array($cookieuserid,$cookieemail));
	}
	
	//checking cookie
	function remember_cookie2_check($cookie2)
	{	
		$sql = "select * from users where `id`='$cookie2' LIMIT 0,1";
		$query=$this->db->query($sql);
		if ($query->num_rows() > 0)
		{		
			$row = $query->row_array(); 
		
			return $row;
		}
		else
			return false;
	}
	
  //checking cookie
	function remember_cookie_check($cookie1)
	{	
		$sql = "select * from `remember_cookies` where cookie_name='$cookie1'";
		$query=$this->db->query($sql);
		if($query)
		{
			if ($query->num_rows() > 0)
			{		
				$row = $query->row_array(); 
				return $row;
			}
			else
				return false;
		}
	}	
}