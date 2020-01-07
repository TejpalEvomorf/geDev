<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends CI_Controller {

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
	 
	function __construct()  {
        parent::__construct();
		$this->load->model('form_model');
		$this->load->model('share_house_model');
    }
	
	public function index()
	{
		//$this->load->view('welcome_message');
	}
	function share_house_application()
	{
		$data['pageTitle']=houseTitle();
		$this->load->view('header',$data);
		$this->load->view('form/share-house');
		$this->load->view('footer');
	}

	function share_house_application_submit()
	{
		$data=$_POST;
		//see($data);exit;
		if($data['email']!='')
		{
			$id=$this->share_house_model->insert_share_house($data);
			echo $id;
		}
	}
	function share_house_application_submit_rename()
	{
			$data=$_POST;
			
			if($data['hfa_email']!='')
			{
				//First check if email already user or not
				$hfaAppCheckByEmail=hfaAppCheckByEmail($data['hfa_email']);
				if(empty($hfaAppCheckByEmail))
				{
					$id=$this->form_model->host_family_application_one_submit($data);
					$link=codeEncode($id);
					$link=site_url().'form/host_family_application_two/'.$link;
					//////
					$this->load->library('email');
					$this->email->clear(); 	
					$config['mailtype'] = 'html';
					$this->email->initialize($config);
			
	       			 $this->email->from(header_from_email(),header_from());
			
					$this->email->subject('Complete your Share House Application');
					$to =  $data['hfa_email'];
					$this->email->to($to);
					$emailData['hfa_fname']=$data['hfa_fname'];
					$emailData['link']=$link;
					
					$email_msg_user=$this->load->view('form/emails/hfa',$emailData,true);
				 	$this->email->message($email_msg_user);
					
					$this->email->send();
					echo $link;
					///////////
				}
				else
					echo 'duplicate-email';
			}
	}
	function host_family_application()
	{
		force_ssl();
		$data['pageTitle']=hfaTitle();
		$this->load->view('header',$data);
		$this->load->view('form/hfa-1');
		$this->load->view('footer');
	}

	function host_family_application_one_submit()
	{
			$data=$_POST;
			if($data['hfa_number']!='')
			{
				
				$num1=str_replace('-','',$data['hfa_number']);
				$num1=str_replace(' ','',$num1);
				$data['hfa_number']=mobileFormat($num1);
			}
			 if($data['hfa_home_phone']!='')
			{
				
				$hnum1=str_replace('-','',$data['hfa_home_phone']);
				$hnum1=str_replace(' ','',$hnum1);
				$data['hfa_home_phone']=phoneFormat($hnum1);
			}
			 if($data['hfa_work_phone']!='')
			{
				
				$wnum1=str_replace('-','',$data['hfa_work_phone']);
				$wnum1=str_replace(' ','',$wnum1);
				$data['hfa_work_phone']=phoneFormat($wnum1);
			}
			if(!empty($data['filled_by'])){
				$data['hfa_registered_status']='Offline';
			}else{
				$data['hfa_registered_status']='Online';
			}
			if($data['hfa_email']!='')
			{
				//First check if email already user or not
				//$hfaAppCheckByEmail=hfaAppCheckByEmail($data['hfa_email']);
				if(!empty($data))
				{
					$id=$this->form_model->host_family_application_one_submit($data);
					$link=codeEncode($id);
					$link=site_url().'form/host_family_application_two/'.$link;
					if(!isset($data['filled_by'])){
					$this->load->library('email');
					$this->email->clear(); 	
					$config['mailtype'] = 'html';
					$this->email->initialize($config);
			
	       			 $this->email->from(header_from_email(),header_from());
			
					$this->email->subject('Complete your Host Family Application');
					$to =  $data['hfa_email'];
					$this->email->to($to);
					$emailData['hfa_fname']=$data['hfa_fname'];
					$emailData['link']=$link;
					
					$email_msg_user=$this->load->view('form/emails/hfa',$emailData,true);
				 	$this->email->message($email_msg_user);
					
					$this->email->send();
					echo $link;
					///////////
				}
				}
				else
					echo 'duplicate-email';
			}
			
	}
	
	
	function host_family_application_two($link='', $popUp='')
	{
		force_ssl();
		$id=codeDecode($link);
		if($id!='')
		{
			$getHfaOneAppDetails=getHfaOneAppDetails($id);
			if(!empty($getHfaOneAppDetails))
			{
				hfaRedirectToCorrectStep($id,2);
				
				$data['id']=$id;
				$data['link']=$link;
				$data['popUp']=$popUp;
				$data['pageTitle']=hfaTitle();
				$this->load->view('header',$data);
				$this->load->view('form/hfa-2');
				$this->load->view('footer');
			}
			else
				header('location:'.site_url().'form/host_family_application');
		}
		else
			header('location:'.site_url().'form/host_family_application');
	}
	
	function host_family_application_two_submit()
	{
			$data=$_POST;
			//see($data);
			if($data['id']!='')
			{
				//First check if email already user or not
				
				$this->form_model->host_family_application_two_submit($data);
				echo 'next';
			}
	}
	
	function host_family_application_three($link='', $popUp='')
	{
		force_ssl();
		$id=codeDecode($link);
		if($id!='')
		{
			$getHfaOneAppDetails=getHfaOneAppDetails($id);
			if(!empty($getHfaOneAppDetails))
			{
				hfaRedirectToCorrectStep($id,3);
				
				$data['id']=$id;
				$data['link']=$link;
				$data['popUp']=$popUp;
				$data['form_one']=$getHfaOneAppDetails;
				$data['pageTitle']=hfaTitle();
				$this->load->view('header',$data);
				$this->load->view('form/hfa-3');
				$this->load->view('footer');
			}
			else
				header('location:'.site_url().'form/host_family_application');
		}
		else
			header('location:'.site_url().'form/host_family_application');
	}
	
	function host_family_application_three_submit()
	{
			$data=$_POST;
			//see($data);
			if($data['id']!='')
			{
				//First check if email already user or not
				
				$this->form_model->host_family_application_three_submit($data);
				echo 'next';
			}
	}
	
	function host_family_application_four($link='', $popUp='')
	{
		force_ssl();
		$id=codeDecode($link);
		if($id!='')
		{
			$getHfaOneAppDetails=getHfaOneAppDetails($id);
			if(!empty($getHfaOneAppDetails))
			{
				hfaRedirectToCorrectStep($id,4);
				
				$data['id']=$id;
				$data['link']=$link;
				$data['popUp']=$popUp;
				$data['pageTitle']=hfaTitle();
				$this->load->view('header',$data);
				$this->load->view('form/hfa-4');
				$this->load->view('footer');
			}
			else
				header('location:'.site_url().'form/host_family_application');
		}
		else
			header('location:'.site_url().'form/host_family_application');
	}
	
	function host_family_application_four_submit()
	{
			$data=$_POST;
			//see($data);
			if($data['id']!='')
			{
				//First check if email already user or not
				
				$this->form_model->host_family_application_four_submit($data);
				echo 'next';
			}
	}
	
	function host_family_application_complete()
	{
		force_ssl();
		$data['pageTitle']=hfaTitle();
		$this->load->view('header',$data);
		$this->load->view('form/hfa-complete');
		$this->load->view('footer');
	}

	function host_family_application_completed()
	{
		force_ssl();
		$data['pageTitle']=hfaTitle();
		$this->load->view('header',$data);
		$this->load->view('form/hfa-already-complete');
		$this->load->view('footer');
	}	
	
	function ret_app_form_hfa_submit()
	{
		$data=$_POST;
		if(isset($data['ret_app_email']) && $data['ret_app_email']!='')
		{
			$email=$data['ret_app_email'];
			$hfaAppCheckByEmail=hfaAppCheckByEmail($email);
			if(!empty($hfaAppCheckByEmail))
			{
				$step = $hfaAppCheckByEmail['step'];
				$link=codeEncode($hfaAppCheckByEmail['id']);
				$link=site_url().'form/host_family_application_two/'.$link;
				echo json_encode(array('error'=>0,'step'=>$step,'link'=>$link));
			}
			else
					echo json_encode(array('error'=>1,'message'=>'Email Not Found'));
		}
	}
	
	
	function student_homestay_application()
	{
		force_ssl();
		$data['pageTitle']=shaTitle();
		$this->load->view('header',$data);
		$this->load->view('form/sha-1');
		$this->load->view('footer');
	}
	
	function sha_one_submit()
	{
		$data=$_POST;
		//see($data);exit;
			if($data['sha_email']!='' || isset($data['filled_by']))
			{
				
				if(!empty($data['filled_by'])){
				$data['sha_registered_status']='Offline';
			}else{
				$data['sha_registered_status']='Online';
			}
				//First check if email already user or not
			if(isset($data['filled_by'])) //if user or admin logged then it will return empty array so that it wont check for duplicate email
					$shaAppCheckByEmail=array();
				else	
					$shaAppCheckByEmail=array();
					//$shaAppCheckByEmail=shaAppCheckByEmail($data['sha_email']);
				if(empty($shaAppCheckByEmail))
				{
					$id=$this->form_model->sha_one_submit($data);
					$link=codeEncode($id);
					$link=site_url().'form/student_homestay_application_two/'.$link;
					
					//////
					if(!isset($data['filled_by']))
					{
					  $this->load->library('email');
					  $this->email->clear(); 	
					  $config['mailtype'] = 'html';
					  $this->email->initialize($config);
			  
					   $this->email->from(header_from_email(),header_from());
			  
					  $this->email->subject('Complete your Student Homestay Application');
					  $to =  $data['sha_email'];
					  $this->email->to($to);
					  $emailData['name']=$data['sha_fname'];
					  $emailData['link']=$link;
					  
					  $email_msg_user=$this->load->view('form/emails/sha',$emailData,true);
					  $this->email->message($email_msg_user);
			  
					  $this->email->send();
					  echo $link;
					}
					///////////
				}
				else
					echo 'duplicate-email';
			}
	}
	
function student_homestay_application_two($link='',$popUp='')
	{
		force_ssl();
		$id=codeDecode($link);
		if($id!='')
		{
			$getShaOneAppDetails=getShaOneAppDetails($id);
			if(!empty($getShaOneAppDetails))
			{
				shaRedirectToCorrectStep($id,2);
				
				$data['id']=$id;
				$data['link']=$link;
				$data['popUp']=$popUp;
				$data['form_one']=$getShaOneAppDetails;
				$data['pageTitle']=shaTitle();
				$this->load->view('header',$data);
				$this->load->view('form/sha-2');
				$this->load->view('footer');
			}
			else
				header('location:'.site_url().'form/student_homestay_application');
		}
		else
			header('location:'.site_url().'form/student_homestay_application');
	}

function sha_two_submit()
{
			$data=$_POST;
			/*see($data);
			see($_FILES);
			exit;*/
			if($data['id']!='')
			{
				$this->form_model->sha_two_submit($data);
				echo 'next';
			}
}	


function student_homestay_application_three($link='', $popUp='')
	{
		force_ssl();
		$id=codeDecode($link);
		if($id!='')
		{
			$getShaOneAppDetails=getShaOneAppDetails($id);
			if(!empty($getShaOneAppDetails))
			{
				shaRedirectToCorrectStep($id,3);
				
				$data['id']=$id;
				$data['link']=$link;
				$data['popUp']=$popUp;
				$data['pageTitle']=shaTitle();
				$this->load->view('header',$data);
				$this->load->view('form/sha-3');
				$this->load->view('footer');
			}
			else
				header('location:'.site_url().'form/student_homestay_application');
		}
		else
			header('location:'.site_url().'form/student_homestay_application');
	}

	function sha_three_submit()
	{
			$data=$_POST;
			//see($data);
			if($data['id']!='')
			{
				//First check if email already user or not
				
				$this->form_model->sha_three_submit($data);
				echo 'next';
			}
	}

	function share_house_application_complete()
	{
		$data['pageTitle']=houseTitle();
		$this->load->view('header',$data);
		$this->load->view('form/share-house-complete');
		$this->load->view('footer');
	}
	function student_homestay_application_complete()
	{
		force_ssl();
		$data['pageTitle']=shaTitle();
		$this->load->view('header',$data);
		$this->load->view('form/sha-complete');
		$this->load->view('footer');
	}

	function student_homestay_application_completed()
	{
		force_ssl();
		$data['pageTitle']=shaTitle();
		$this->load->view('header',$data);
		$this->load->view('form/sha-already-complete');
		$this->load->view('footer');
	}
	
	
	function ret_app_form_sha_submit()
	{
		$data=$_POST;
		if(isset($data['ret_app_email']) && $data['ret_app_email']!='')
		{
			$email=$data['ret_app_email'];
			$hfaAppCheckByEmail=shaAppCheckByEmail($email);
			if(!empty($hfaAppCheckByEmail))
			{
					$step = $hfaAppCheckByEmail['step'];
					$link=codeEncode($hfaAppCheckByEmail['id']);
					$link=site_url().'form/student_homestay_application_two/'.$link;
					
					
					$htmlStepStyle="font-weight:bold; color:#1d7643; background:#eeeeee;";
					$htmlStepImg='<img src="'.str_replace('http:','https:',static_url()).'img/complete-tick.png" />';
					$html='<p style="font-size:14px; color:#666666; margin-bottom: 8px; text-align: center;">Here is the application associated with <span id="ret_app_found_email"></span></p>
                              <a href="'.$link.'" style="float: left; text-align: center; width: 100%;" id="ret_app_found_continue">CONTINUE TO NEXT STEP</a>
                             <span style="'.$htmlStepStyle.'margin-top:30px;">Step 1: Personal Details (Complete) '.$htmlStepImg.'</span>
                            <span';
					if($step>2)
						$html .=' style="'.$htmlStepStyle.'"';
					$html .='>Step 2: Other Details';
					if($step>2)
						$html .=' (Complete) '.$htmlStepImg;
					$html .='</span><span';
					if($step>3)
						$html .=' style="'.$htmlStepStyle.'"';
					$html .='>Step 3: Health Details and Preferences';
					if($step>3)
						$html .=' (Complete) '.$htmlStepImg;
					$html .='</span>';
					
					echo json_encode(array('error'=>0,'html'=>$html));
			}
			else
					echo json_encode(array('error'=>1,'message'=>'Email Not Found'));
		}
	}	
	
	function link($linkdata)
	{
		
		echo $link=codeEncode($linkdata);
		
		echo "<br> ".codeDecode($link);
	}
	
	function linkD($linkdata)
	{
		echo $id=codeDecode($link);
		echo '<br>Step='.hfaAppCheckStep($id);
		
	}
	
	function f2()
	{
				$data['popUp']='';
				$data['id']=22;
				$data['link']='asdfasdf';
				$getHfaOneAppDetails=getHfaOneAppDetails($data['id']);
				$data['form_one']=$getHfaOneAppDetails;
				
				$this->load->view('header',$data);
				$this->load->view('form/hfa-2');
				$this->load->view('footer');
	}
	function f3()
	{
				$data['popUp']='';
				$data['id']=22;
				$data['link']='asdfasdf';
				$getHfaOneAppDetails=getHfaOneAppDetails($data['id']);
				$data['form_one']=$getHfaOneAppDetails;
				
				$this->load->view('header',$data);
				$this->load->view('form/hfa-3');
				$this->load->view('footer');
	}
	function f4()
	{
				$data['id']=22;
				$data['link']='asdfasdf';
				
				$this->load->view('header',$data);
				$this->load->view('form/hfa-4');
				$this->load->view('footer');
	}
	
	function exact_age_from_dob_jquery($dob)
	{			
		$today = date("Y-m-d");
		$diff = date_diff(date_create($dob), date_create($today));
		$age_calculate = $diff->format('%y');
		echo $age_calculate;
	}
	
	function studentFeedback($link='')
	{
		$id=codeDecode($link);
		if($id!='')
		{
			$booking=bookingDetails($id);
			if(!empty($booking))
			{
				$feeds=$this->form_model->feedbacksByShaId($booking['student']);
				if(count($feeds)==0)
				{
					$this->load->model('dashboard_model');
					$this->dashboard_model->bookingFeedbackVisited($booking['booking_from']);
					$data['shaOne']=getShaOneAppDetails($booking['student']);
					$data['shaThree']=getShaThreeAppDetails($booking['student']);
					$data['hfaOne']=getHfaOneAppDetails($booking['host']);
					$data['booking']=$booking;
					$data['id']=$id;
				}
				else
					$data['submitted']='yes';
					
				$data['pageTitle']='Feedback';
				$this->load->view('header',$data);
				$this->load->view('form/autoFeedback');
				$this->load->view('footer');
			}
			else
				header('location:'.site_url());
		}
		else
			header('location:'.site_url());
	}
	
	function feedbackSubmit()
	{
		$data=$_POST;
		
		if($data['booking']!='')
				$this->form_model->feedbackSubmit($data);
	}
	
	function studentFeedbackView($id='')
	{
		if($id!='')
		{
			$this->load->model('booking_model');
			$data['feedback']=$this->booking_model->feedbackDetails($id);
			if(!empty($data['feedback']))
			{
				$data['pageTitle']='Feedback';
				$this->load->view('header',$data);
				$this->load->view('form/autoFeedbackView');
				$this->load->view('footer');
			}
			else
				header('location:'.site_url());
		}
		else
			header('location:'.site_url());
	}
	
	function unsubscribeFeedbackEmail($link='')
	{
		$email=codeDecode($link);
		if($email!='')
		{
				$this->load->model('cron_model');
				$this->cron_model->unsubscribeFeedbackEmail($email);
				$data['pageTitle']='Unsubscribe feedback emails';
				$data['type']='do';
				$linkUnsub=codeEncode($email);
				$linkUnsub=site_url().'form/undoUnsubscribeFeedbackEmail/'.$linkUnsub;
				$data['linkUndoUnsub']=$linkUnsub;
				$this->load->view('header',$data);
				$this->load->view('form/unsubscribeFeedbackEmails');
				$this->load->view('footer');
		}
		else
			header('location:'.site_url());
	}
	
	function undoUnsubscribeFeedbackEmail($link='')
	{
		$email=codeDecode($link);
		if($email!='')
		{
				$this->load->model('cron_model');
				$this->cron_model->undoUnsubscribeFeedbackEmail($email);
				$data['pageTitle']='Unsubscribe feedback emails';
				$data['type']='undo';
				$data['linkUndoUnsub']='';
				$this->load->view('header',$data);
				$this->load->view('form/unsubscribeFeedbackEmails');
				$this->load->view('footer');
		}
		else
			header('location:'.site_url());
	}
	
	function header_iframe($controller,$function,$pageTitle)
	{
		$data['controller']=$controller;
		$data['function']=$function;
		$data['pageTitle']=$pageTitle;
		$this->load->view('header_iframe',$data);
	}
	
	function footer_iframe()
	{
		$this->load->view('footer_iframe');
	}
	
}