<?php
class Account extends CI_Controller {
	
		function __construct()
		{
			parent::__construct();
			$this->load->model('account_model');
		}
		
		
		function index()
		{
			if(checkLogin())
			{
				$data['page']='account';
				$data['loggedInUser']=loggedInUser();
				if($data['loggedInUser']['user_type']==1)
					$data['employees']=$this->account_model->employeeList();
				else
					$data['employee']=$this->account_model->employee_details($data['loggedInUser']['id']);
				$this->load->view('system/header',$data);
				$this->load->view('system/account/account');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
		}
		
		function employeeList()
		{
			$loggedInUser=loggedInUser();
			if($loggedInUser['user_type']==1)
			{
			  $res['employees']=$this->account_model->employeeList();
			  return $this->load->view('system/account/employee_list',$res,true);
			}
		}
		
		function new_employee()
		{
			if(checkLogin())
			{
				$loggedInUser=loggedInUser();
				if($loggedInUser['user_type']==1)
				{
				  $data['page']='account';
				  $this->load->view('system/header',$data);
				  $this->load->view('system/account/employee_add_new');
				  $this->load->view('system/footer');
				}
			}
			else
				redirectToLogin();
		}
		
		function createEmployee()
		{
			if(checkLogin())
			{
				$loggedInUser=loggedInUser();
				if($loggedInUser['user_type']==1)
				{
					$data=$_POST;
					$data=trimArrayValues($data);
					$res=array();
					$valid=$this->account_model->validateEmployee($data);
					if(!is_array($valid) && $valid=='yes')
					{
						$res['done']['id']=$this->account_model->createEmployee($data);
						$res['done']['employee_list']=$this->employeeList();
						
						$this->sendEmployeeCreateEmail($res['done']['id'],$data['password']);
					}
					else
						$res['notValid']=$valid;
				}
			}
			else
				$res['logout']="LO";
				
			echo json_encode($res);	
		}
		
		
		function editEmployee()
		{
			if(checkLogin())
			{
				$loggedInUser=loggedInUser();
				$data=$_POST;
				if($loggedInUser['user_type']==1 || $loggedInUser['id']==$data['id'])
				{
					$data=trimArrayValues($data);
					$res=array();
					$valid=$this->account_model->validateEmployee($data);
					//$valid='yes';
					if(!is_array($valid) && $valid=='yes')
						{
							$this->account_model->editEmployee($data);
							$res['done']['id']='1';
						}
					else
						$res['notValid']=$valid;
				}
			}
			else
				$res['logout']="LO";
				
			echo json_encode($res);	
		}
		
		function deleteEmployee()
		{
			$loggedInUser=loggedInUser();
			if($loggedInUser['user_type']==1)
			{
				if(isset($_POST['id']))
				{
					$this->account_model->deleteEmployee($_POST['id']);
					echo $this->employeeList();
				}
			}
		}
		
		function editEmployeeForm($id)
		{
			if(checkLogin())
			{
				$loggedInUser=loggedInUser();
				if($loggedInUser['user_type']==1)
				{
					$data['page']='account';
					$data['employee']=$this->account_model->employee_details($id);
					if(empty($data['employee']))
						header('location:'.site_url().'account#tab-8-2');
					$this->load->view('system/header',$data);
					$this->load->view('system/account/employee_edit');
					$this->load->view('system/footer');
				}
			}
			else
				redirectToLogin();
		}
		
		
		function employee_image_upload()
		{
			if($_FILES['file']['name']!= "")
				  {
						$path="./static/uploads/employee"; 
						$t1=time();
						$imagename=$t1.$_FILES['file']['name'];		
						move_uploaded_file($_FILES['file']['tmp_name'],$path.'/'.$imagename);
						
						$large_image_location=$path.'/'.$imagename;
						//$thumb_image_location=$path.'/thumbs/'.$imagename;
						$thumb_image_location=$large_image_location;
						
						cropImageFromSides($large_image_location,$thumb_image_location,'250','250');
						$this->account_model->employee_image_upload($_POST['empId'],$imagename);
						$data['employee']=$this->account_model->employee_details($_POST['empId']);
						$this->load->view('system/account/employee_edit_page_photo',$data);
					}
		}

		function updateEmpDesignation()
		{
			if(checkLogin())
			{
				if(isset($_POST['id']))
				{
					$this->account_model->updateEmpDesignation($_POST);
					echo "done";
				}
			}
			else
				echo "LO";
		}
		
		function updateEmpOffice()
		{
			if(checkLogin())
			{
				if(isset($_POST['id']))
				{
					$this->account_model->updateEmpOffice($_POST);
					echo "done";
				}
			}
			else
				echo "LO";
		}
		
		function checkEmpAppCount()
		{
			if(checkLogin())
			{
				if(isset($_POST['id']))
				{
					$count=$this->account_model->checkEmpAppCount($_POST);
					echo $count;
				}
			}
			else
				echo "LO";
		}
		
		
		function checkEmpAppCountDelEmp()
		{
			if(checkLogin())
			{
				if(isset($_POST['id']))
				{
					$data=$_POST;
					$count=$this->account_model->checkEmpAppCount($_POST);
					if($count==0)
						echo $count;
					else
					{	
						$data['count']=$count;
						$this->load->view('system/account/delEmpAssignDeffEmpPopContent',$data);
					}
				}
			}
			else
				echo "LO";
		}
		
	function sendEmployeeCreateEmail($id,$password)
	{
			  $employee=$this->account_model->employee_details($id);
			  $employee['password']=$password;
			  $this->load->library('email');
			  $this->email->clear(); 	
			  $config['mailtype'] = 'html';
			  $this->email->initialize($config);
	  
			   $this->email->from(header_from_email(),header_from());
	  
			  $this->email->subject('Employee account created');
			  $to =  $employee['email_company'];
			  $this->email->to($to);
			  //$this->email->to('tejpal@evomorf.com');
			  
			  $email_msg_user=$this->load->view('system/account/emails/employee_create',$employee,true);
			  $this->email->message($email_msg_user);
			  
			  $this->email->send();
	}
	
	function assignDiffEmpToAppSubmit()
	{
			$this->account_model->assignDiffEmpToAppSubmit($_POST);
	}
	
	function getEmployeeByOffice($office)
	{
		$empList=otherEmployeesSameOffice(0,$office);
		echo '<option value="">Select employee</option>';
		foreach($empList as $eLK=>$eLV)
		{
			echo '<option value="'.$eLV['id'].'">'.ucwords($eLV['fname'].' '.$eLV['lname']).'</option>';
		}
	}
	
	function changePasswordSubmit()
	{
		if(checkLogin())
		{
			$data=$_POST;
			$this->account_model->changePasswordSubmit($data);
		}
		else
			echo "LO";
	}
	
	function userRecentActivities()
	{
		if(checkLogin())
		{
			 $this->load->model('account_model');
			 $activities=$this->account_model->userRecentActivities();
			 $this->load->view('system/account/recent_activities',compact('activities'));
		}
		else
			echo "LO";
	}

}
