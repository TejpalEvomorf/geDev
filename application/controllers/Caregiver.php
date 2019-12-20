<?php
class Caregiver extends CI_Controller {
	
		function __construct()
		{
			parent::__construct();
			$this->load->model('caregiver_model');
		}
	
		function index()
		{
			if(checkLogin())
			{
				recentActionsAddData('caregiver','list','view');
			
				$data['page']='caregiver_company_list';
				$data['companies']=$this->caregiver_model->companyList();
				$this->load->view('system/header',$data);
				$this->load->view('system/caregiver/companyList');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
		}
		
		function create_company()
		{
			if(checkLogin())
			{
				$data['page']='caregiver_create_company';
				$this->load->view('system/header',$data);
				$this->load->view('system/caregiver/create_company');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
		}
		
		function create_companySubmit()
		{
			if(checkLogin())
			{
				$data=$_POST;
				$data=trimArrayValues($data);
				$res=array();
				$valid=$this->caregiver_model->validateCompany($data);
				if(!is_array($valid) && $valid=='yes')
				{
					if(isset($data['id']))
						$res['done']['id']=$this->caregiver_model->editCompany($data);	
					else
						$res['done']['id']=$this->caregiver_model->createCompany($data);
				}
				else
					$res['notValid']=$valid;
			}
			else
				$res['logout']="LO";
				
			echo json_encode($res);	
		}
		
		function edit_company($id=0)
		{
			if(checkLogin())
			{
				if($id==0)
				header('location:'.site_url().'caregiver');
			
				recentActionsAddData('caregiver',$id,'view');
				$data['page']='caregiver_edit_company';
				$data['company']=$this->caregiver_model->companyDetail($id);
				if(empty($data['company']))
					header('location:'.site_url().'caregiver');
					
				$this->load->view('system/header',$data);
				$this->load->view('system/caregiver/create_company');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
		}
		
		function manage($id=0)
		{
			if(checkLogin())
			{
				if($id==0)
				header('location:'.site_url().'caregiver');
			
				$data['page']='caregiver_manage';
				$data['company']=$this->caregiver_model->companyDetail($id);
				if(empty($data['company']))
					header('location:'.site_url().'caregiver');
					
				$data['caregivers']=$this->caregiver_model->getCaregiversByCompany($id);
				
				$this->load->view('system/header',$data);
				$this->load->view('system/caregiver/manageCaregivers');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
		}
		
		function addCG()
		{
			if(checkLogin())
			{
				$data=$_POST;
				$data=trimArrayValues($data);
				$this->caregiver_model->addCG($data);
				echo 'done';
			}
			else
				echo "LO";
		}
		
		function editCGgetPopContent($id)
		{
			if(checkLogin())
			{
				$data['caregiver']=$this->caregiver_model->caregiverDetail($id);
				$this->load->view('system/caregiver/editCaregiver',$data);
			}
			else
				echo "LO";
		}
		
		function editCG()
		{
			if(checkLogin())
			{
				$data=$_POST;
				$data=trimArrayValues($data);
				$this->caregiver_model->editCG($data);
				$cg=$this->caregiver_model->caregiverDetail($data['caregiver_id']);
				$return['tdHtml']=manageCGTd($cg);
			}
			else
				$return['logout']="LO";
			echo json_encode($return);
		}
		
		function deleteCG()
		{
			if(checkLogin())
			{
				$data=$_POST;
				$this->caregiver_model->deleteCG($data['id']);
			}
			else
				echo "LO";
		}
		
		function deleteCompany()
		{
			if(checkLogin())
			{
				$data=$_POST;
				$this->caregiver_model->deleteCompany($data['id']);
			}
			else
				echo "LO";
		}
		
		function getCGListShaOfficeusePage($id)
		{
			$caregivers=$this->caregiver_model->getCaregiversByCompany($id);
			$options='<option value="">Select caregiver company</option>';
			foreach($caregivers as $cg)
				$options .='<option value="'.$cg['id'].'">'.$cg['fname'].' '.$cg['lname'].'</option>';	
				
			$return['cgList']=$options;
			echo json_encode($return);
		}
		
}