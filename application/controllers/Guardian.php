<?php
class Guardian extends CI_Controller {
	
		function __construct()
		{
			parent::__construct();
			$this->load->model('guardian_model');
		}
		
		
		function index()
		{
			if(checkLogin())
			{
				$data['page']='guardian';
			
				$data['guardian']=$this->guardian_model->guardianList();
				$this->load->view('system/header',$data);
				$this->load->view('system/guardian/guardian_list');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
		}
		
		function create()
		{
			if(checkLogin())
			{
				$data['page']='create_guardian';
				$this->load->view('system/header',$data);
				$this->load->view('system/guardian/create_guardian');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
		}
		
		function createSubmit()
		{
			if(checkLogin())
			{
				$data=$_POST;
				$data=trimArrayValues($data);
				$res=array();
				$valid=$this->guardian_model->validateGuardian($data);
				if(!is_array($valid) && $valid=='yes')
				{
					if(isset($data['id']))
						$res['done']['id']=$this->guardian_model->editGuardian($data);	
					else
						$res['done']['id']=$this->guardian_model->createGuardian($data);
				}
				else
					$res['notValid']=$valid;
			}
			else
				$res['logout']="LO";
				
			echo json_encode($res);	
		}
		
		function edit($id)
		{
			if(checkLogin())
			{
				$data['page']='create_guardian';
				$data['guardian']=$this->guardian_model->guardianDetail($id);
				if(empty($data['guardian']))
					header('location:'.site_url().'guardian');
				$this->load->view('system/header',$data);
				$this->load->view('system/guardian/edit_guardian');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
		}
		
		function deleteGuardian()
		{
			if(isset($_POST['id']))
			{
				$this->guardian_model->deleteGuardian($_POST['id']);
				echo "done";
			}
		}
		
}