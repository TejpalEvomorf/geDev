<?php
class Apu_company extends CI_Controller {
	
		function __construct()
		{
			parent::__construct();
			$this->load->model('apu_company_model');
		}
		
		
		function index()
		{
			if(checkLogin())
			{
				recentActionsAddData('apuCompany','list','view');
			
				$data['page']='apu_company';
				
				$data['apuCompany']=$this->apu_company_model->apuCompanyList();
				$this->load->view('system/header',$data);
				$this->load->view('system/apu_company/apu_company_list');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
		}
		
		function create()
		{
			if(checkLogin())
			{
				$data['page']='create_apu_company';
				$this->load->view('system/header',$data);
				$this->load->view('system/apu_company/create_apu_company');
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
				$valid=$this->apu_company_model->validateApuCompany($data);
				if(!is_array($valid) && $valid=='yes')
				{
					if(isset($data['id']))
						$res['done']['id']=$this->apu_company_model->editApuCompany($data);	
					else
						$res['done']['id']=$this->apu_company_model->createApuCompany($data);
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
				recentActionsAddData('apuCompany',$id,'view');
			
				$data['page']='create_apu_company';
				$data['apu_company']=$this->apu_company_model->apuCompanyDetail($id);
				if(empty($data['apu_company']))
					header('location:'.site_url().'apu_company');
				$this->load->view('system/header',$data);
				$this->load->view('system/apu_company/edit_apu_company');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
		}
		
		function deleteGuardian()
		{
			if(isset($_POST['id']))
			{
				$this->apu_company_model->deleteApuCompany($_POST['id']);
				echo "done";
			}
		}
		
}