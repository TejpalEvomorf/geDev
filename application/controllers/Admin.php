<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		if(checkLogin())
			header("location:".site_url().'dashboard');
			
		 ///checking cookie
				 $this->load->model('admin_model');
				  if(isset($_COOKIE['email']) && isset($_COOKIE['userid']))
				  {
					  $cookie1=$_COOKIE['email'];
					  $usercookie	=$this->admin_model->remember_cookie_check($cookie1);
					  if($usercookie)
						  {
							  $cookie2=$_COOKIE['userid'];
							  $usercookieData	=$this->admin_model->remember_cookie2_check($cookie2);
							  if($usercookieData)
							  {
								$UserDataSession['id']=$usercookieData['id'];
								$this->session->set_userdata('user_id', $UserDataSession['id']);	
								
								header("location:".site_url().'dashboard');
							  }
						  }
				  }
		///checking cookie ends
			
			
		$this->load->view('system/login');
	}
	function encpwd(){echo passEncrypt('abhishek12');}
	function login()
	{
		 if(checkLogin())
			header("location:".site_url().'dashboard');
		 
		 $this->load->model('admin_model');

		if(isset($_POST['uname']))
		{
			if($_POST['uname']=='' || $_POST['password']=='')
			{
				$this->session->set_flashdata('error',"Invalid Username or password!");
				redirect(site_url().'admin');
			}
		
   			$AdminSigninData=$this->room=$this->admin_model->login($_POST);	

				if($AdminSigninData)
				{
					
					//remember me starts
					if(isset($_POST['remember']))
					{
						$cookieemail=md5($AdminSigninData['uname']);
						$cookieuserid=$AdminSigninData['id'];
					
						setcookie("email", $cookieemail,  time()+3600*24*7,"/");
						setcookie("userid", $cookieuserid,  time()+3600*24*7,"/");
						$this->admin_model->delete_remember_cookie($cookieuserid);
						$this->admin_model->remember_cookie($cookieemail,$cookieuserid);
					}
					//remember me ends
					
					$this->session->set_userdata('user_id', $AdminSigninData['id']);
					header("location:".site_url().'dashboard');
				}
				else
				{
				$this->session->set_flashdata('error',"Invalid Username or password!");
				header("location:".site_url().'admin');
				}
		}
	else
		header("location:".site_url().'admin');
	}
	
	function logout()
	{
		
		$session=$this->session->userdata("user_id");
		$user_id=$session;
		//deleting the cookies
		$this->load->model("admin_model");
		$this->admin_model->delete_remember_cookie($user_id);
		
		setcookie("email", "", time()-3600,"/");
		setcookie("userid", "", time()-3600,"/");
		
		$this->session->sess_destroy();
		header("location:".site_url().'admin');
	}
	
	function selectProfilePhotoPopContent($id,$hfaSha)
	{
		if(checkLogin())
			{
				$model=$hfaSha.'_model';
				$this->load->model($model);
				$data['id']=$id;
				$data['photos']=$this->$model->photos($id);
				$data['hfaSha']=$hfaSha;
				$this->load->view('system/selectProfilePhotoPopContent',$data);
			}
			else
				echo "LO";
	}
	
	function selectProfilePhotoSubmit()
	{
		if(checkLogin())
			{
				$data=$_POST;
				$this->load->model('admin_model');
				$this->admin_model->selectProfilePhotoSubmit($data);
			}
			else
				echo "LO";
	}
	
	function deleteApplicationPhotos()
	{
		if(checkLogin())
			{
				$data=$_POST;
				$this->load->model('admin_model');
				$data['photos']=$this->admin_model->deleteApplicationPhotos($data);
				$res['application_photos_list']=$this->load->view('system/'.$data['hfaSha'].'/application_photos_list',$data,true);
				$functionFormOne='get'.$data['hfaSha'].'OneAppDetails';
				$data['formOne']=$functionFormOne($data['application_id']);
				//see($data);
				$res['profilePic']=$this->load->view('system/'.$data['hfaSha'].'/profilePic',$data,true);
				echo json_encode($res);
			}
			else
			{
				echo json_encode(array('logout'=>"LO"));
			}
	}
	
}
