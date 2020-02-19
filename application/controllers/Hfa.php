<?php
class Hfa extends CI_Controller {
	
		function __construct()
		{
			parent::__construct();
			$this->load->model('hfa_model');
		}
		
		function index()
		{
			if(checkLogin())
			{
				$status='all';
				$this->applicationByStatus($status);
			}
			else
				redirectToLogin();
		}
		
		
		function new_application()
		{
			if(checkLogin())
			{
				$status='new';
				$this->applicationByStatus($status);
			}
			else
				redirectToLogin();
		}
		
		function no_response()
		{
			if(checkLogin())
			{
				$status='no_response';
				$this->applicationByStatus($status);
			}
			else
				redirectToLogin();
		}
		
		function confirmed()
		{
			if(checkLogin())
			{
				$status='confirmed';
				$this->applicationByStatus($status);
			}
			else
				redirectToLogin();
		}
		
		function pending_approval()
		{
			if(checkLogin())
			{
				$status='pending_approval';
				$this->applicationByStatus($status);
			}
			else
				redirectToLogin();
		}
		
		function approved()
		{
			if(checkLogin())
			{
				$status='approved';
				$this->applicationByStatus($status);
			}
			else
				redirectToLogin();
		}
		
		function do_not_use()
		{
			if(checkLogin())
			{
				$status='do_not_use';
				$this->applicationByStatus($status);
			}
			else
				redirectToLogin();
		}
		
		function unavailable()
		{
			if(checkLogin())
			{
				$status='unavailable';
				$this->applicationByStatus($status);
			}
			else
				redirectToLogin();
		}
		
		function applicationByStatus($status)
		{
			recentActionsAddData('hfa',$status,'view');
			$data['page']='hfa';

			$data['hfa_status_page']=$status;
			//see($data['list']);exit;
			$this->load->view('system/header',$data);
			$this->load->view('system/hfa/list');
			$this->load->view('system/footer');
		}
		
		function sendEmailHalfApplicationHfaPopContent($id)
		{
			$getHfaOneAppDetails=getHfaOneAppDetails($id);
			$this->load->view('system/hfa/sendAppCompletionEmailForm',$getHfaOneAppDetails);
		}
		
		function sendEmailHalfApplication()
		{
			  $id=$_POST['hfaSendEmail_id'];
			  $getHfaOneAppDetails=getHfaOneAppDetails($id);
			  $this->load->library('email');
			  $this->email->clear(); 	
			  $config['mailtype'] = 'html';
			  $this->email->initialize($config);
	  
			   $this->email->from(header_from_email(),header_from());
	  
			  $this->email->subject('Complete your Host Family Application');
			  $to =  $_POST['hfaEmail'];
			  $this->email->to($to);
			  //$this->email->to('tejpal@evomorf.com');
			  $emailData['hfa_fname']=$getHfaOneAppDetails['fname'];
			  
			  $link=codeEncode($id);
			  $link=site_url().'form/host_family_application_two/'.$link;
			  $emailData['link']=$link;
			  
			  $email_msg_user=$this->load->view('form/emails/hfa',$emailData,true);
			  $this->email->message($email_msg_user);
			  
			  $this->email->send();
		}
		
		function changeStatus()
		{
			$data=$_POST;
			if($data['hfaChangeStatus_id']!='')
			{
				$this->hfa_model->changeStatus($data);
				echo 'done';
			}
		}
		
		function changeStatusPopContent($id,$pageStatus)
		{
			 $getHfaOneAppDetails=getHfaOneAppDetails($id);
			 $getHfaOneAppDetails['pageStatus']=$pageStatus;
			 if($getHfaOneAppDetails['status']=='do_not_use')
				 $getHfaOneAppDetails['dnu']=hfaDnuReason($id);
			 if($getHfaOneAppDetails['status']=='unavailable' || $getHfaOneAppDetails['status']=='approved')
				 $getHfaOneAppDetails['unavailable']=hfaUnavailable($id);	 
			 $this->load->view('system/hfa/changeStatusForm',$getHfaOneAppDetails);
		}
		
		function filters()
		{
			
			echo $data['status']=$this->uri->segment(3); 
			 $this->load->view('system/hfa/filters',$data);
		}
		
		function deleteApplication()
		{
			if(isset($_POST['id']))
			{
				$this->hfa_model->deleteApplication($_POST['id']);
				echo "done";
			}
		}
		
		function rescheduleVisitPopContent($id)
		{
			if(checkLogin())
			{
				$getHfaOneAppDetails=getHfaOneAppDetails($id);
				$this->load->view('system/hfa/rescheduleVisitForm',$getHfaOneAppDetails);
			}
			else
				echo "LO";
		}
		
		function rescheduleVisitSubmit()
		{
			if(checkLogin())
			{
				$data=$_POST;
				if($data['hfaReschedule_id']!='')
					{
						$this->hfa_model->rescheduleVisitSubmit($data);
						echo 'done';
					}
			}
			else
				echo "LO";
		}
		
		function application($id)
		{
			if(checkLogin())
			{
				$getHfaOneAppDetails=getHfaOneAppDetails($id);
				if(empty($getHfaOneAppDetails))
					header('location:'.site_url().'hfa/');
				else
				{
					recentActionsAddData('hfa',$id,'view');
					$data['page']='hfa_application';
					$data['formOne']=getHfaOneAppDetails($id);
					$data['formTwo']=getHfaTwoAppDetails($id);
					$data['formThree']=getHfaThreeAppDetails($id);
					$data['formFour']=getHfaFourAppDetails($id);
					$data['photos']=$this->hfa_model->photos($id);
					$data['note']=$this->hfa_model->fanilynotedetail($id);
					if($data['formOne']['status']=='approved')
						$data['cApprovalList']=$this->hfa_model->collegeApprovalList($id);
					$data['nomination']=$this->hfa_model->nominatedstudentdetail($id);
					$data['nominationHistory']=$this->hfa_model->nominationHistory($id);
					$status='expected_arrival';
					$data['hfa_status_page']=$status;
					//$data['booking_history']=$this->hfa_model->booking_history($id);
					$data['client']=$this->hfa_model->hfaDetail($id);
					$data['callLog']=$this->hfa_model->callLog($id);
					$data['visits']=$this->hfa_model->visits($id);
					$data['revisit_history']=$this->hfa_model->revisit_history($id);
					$data['incidents']=$this->hfa_model->incidentsByHfaId($id);
					$data['feedbacks']=$this->hfa_model->feedbacksByHfaId($id);
					$data['transport']=$this->hfa_model->transportInfoByHfaId($id);
					$data['warnings']=$this->hfa_model->warningsByHfaId($id);
					$this->load->view('system/header',$data);
					$this->load->view('system/hfa/application');
					$this->load->view('system/footer');
				}
			}
			else
				redirectToLogin();
		}
		
		function application_edit_one($id)
		{
			force_ssl();
			if(checkLogin())
			{
				$data['pageTitle']=hfaTitle();
				$data['formOne']=getHfaOneAppDetails($id);
				$this->load->view('header',$data);
				$this->load->view('system/hfa/application_edit-1');
				$this->load->view('footer');
			}
			else
				redirectToLogin();
		}
		
		function application_edit_one_submit()
		{
			if(checkLogin())
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
				if($data['hfa_email']!='')
				{
					$formOne=getHfaOneAppDetails($data['id']);
					//First check if email already user or not
					$hfaAppCheckByEmail=hfaAppCheckByEmail($data['hfa_email']);
					//if(empty($hfaAppCheckByEmail) || $formOne['email']==$data['hfa_email'])
					if(!empty($formOne) )
					{
						$this->hfa_model->application_edit_one_submit($data);
						echo "done";
					}
					else
						echo 'duplicate-email';
				}
			}
			else
				redirectToLogin();
		}
		
		function application_edit_two($id)
		{
			force_ssl();
			if(checkLogin())
			{
				$data['pageTitle']=hfaTitle();
				$data['formOne']=getHfaOneAppDetails($id);
				$data['formTwo']=getHfaTwoAppDetails($id);
				$this->load->view('header',$data);
				$this->load->view('system/hfa/application_edit-2');
				$this->load->view('footer');
			}
			else
				redirectToLogin();	
		}
		
		function application_edit_two_submit()
		{
			if(checkLogin())
			{
				$data=$_POST;
			//see($data);
				if($data['id']!='')
				{
					$this->hfa_model->application_edit_two_submit($data);
					echo 'done';
				}	
			}
			else
				redirectToLogin();	
		}
		
		function application_edit_three($id)
		{
			force_ssl();
			if(checkLogin())
			{
				$data['pageTitle']=hfaTitle();
				$data['formOne']=getHfaOneAppDetails($id);
				$this->hfa_model->rearrangeFamilyMembers($id);
				$data['formThree']=getHfaThreeAppDetails($id);
				$this->load->view('header',$data);
				$this->load->view('system/hfa/application_edit-3');
				$this->load->view('footer');
			}
			else
				redirectToLogin();	
		}
		
		function application_edit_three_submit()
		{
			if(checkLogin())
			{
				$data=$_POST;
				//see($data); die; //see($_FILES);die(0); 
				if($data['id']!='')
				{
					$this->hfa_model->application_edit_three_submit($data);
					echo 'done';
				}	
			}
			else
				redirectToLogin();	
		}
		
		function application_edit_four($id)
		{
			force_ssl();
			if(checkLogin())
			{
				$data['pageTitle']=hfaTitle();
				$data['formOne']=getHfaOneAppDetails($id);
				$data['formFour']=getHfaFourAppDetails($id);
				//see($data);
				$this->load->view('header',$data);
				$this->load->view('system/hfa/application_edit-4');
				$this->load->view('footer');
			}
			else
				redirectToLogin();	
		}
		
		function application_edit_four_submit()
		{
			if(checkLogin())
			{
				$data=$_POST;
				//see($data);
				if($data['id']!='')
				{
					$this->hfa_model->application_edit_four_submit($data);
					echo 'done';
				}	
			}
			else
				redirectToLogin();	
		}
		
		function application_image_upload()
		{
			if($_FILES['file']['name']!= "")
				  {
						$path="./static/uploads/hfa/photos"; 
						$t1=time();
						$imagename=$t1.$_FILES['file']['name'];		
						
						//////// Rotate image #STARTS
						   $imageType=$_FILES['file']['type'];
						   if(in_array($imageType,array("image/pjpeg","image/jpeg","image/jpg")))
						   {
								$exif = exif_read_data($_FILES['file']['tmp_name']);   
								if (!empty($exif['Orientation'])) 
								{
									$imageResource=imagecreatefromjpeg($_FILES['file']['tmp_name']); 
									
									switch ($exif['Orientation']) 
									  {
											  case 3:
											  $image = imagerotate($imageResource, 180, 0);
											  break;
											  case 6:
											  $image = imagerotate($imageResource, -90, 0);
											  break;
											  case 8:
											  $image = imagerotate($imageResource, 90, 0);
											  break;
											  default:
											  $image = $imageResource;
									  } 
									  
									  imagejpeg($image, $_FILES['file']['tmp_name'], 100);
								}
						   }
					////////// Rotate image #ENDS
						
						move_uploaded_file($_FILES['file']['tmp_name'],$path.'/'.$imagename);
						
						$large_image_location=$path.'/'.$imagename;
						$thumb_image_location=$path.'/thumbs/'.$imagename;
						
						list($imagewidth, $imageheight, $imageType) = getimagesize($large_image_location);
						$imgRatio=$imagewidth/$imageheight;
						if($imgRatio==1)
						{
							$x1=$y1=0;
							$x2=$y2=$imagewidth;
						}
						elseif($imgRatio>1)//width is graeter, Landscape
						{
							$diff=$imagewidth-$imageheight;
							$x1=$diff/2;
							$y1=0;
							$x2=$imageheight;
							$y2=$imageheight;
						}
						else//height is graeter, Portrait
						{	
							$diff=$imageheight-$imagewidth;
							$x1=0;
							$y1=$diff/2;
							$x2=$imagewidth;
							$y2=$imagewidth;							
						}
						
						resizeThumbnailImage($thumb_image_location, $large_image_location,$x2,$y2,$x1,$y1,array('width'=>252,'height'=>252));
						
						$this->hfa_model->application_image_upload_insert($_POST['appId'],$imagename);
				  }
		}
		
		function appPagePhotosBoxRefresh()
		{
			if($_POST['id']!='')
			{
				$id=$_POST['id'];
				$data['photos']=$this->hfa_model->photos($id);
				$this->load->view('system/hfa/application_photos_list',$data);
			}
		}
		
		function plreviewStatusModalInfo($id){			
			if(checkLogin())
			{  
				$data['formThree']=getHfaThreeAppDetails($id);
				$result['result']=$this->load->view('system/hfa/plinsuranceContent',$data,true);
				$result['StatusHtml']=plInsStatusText($data['formThree']);
				echo json_encode($result);	
			}
			else
				echo json_encode(array('result'=>"LO"));
		}
		
		function approveHfaPlIns($page)
		{
			if(checkLogin())
				{  
					if(isset($_POST['hfa_id']))
					{
						$this->hfa_model->approveHfaPlIns($_POST['hfa_id']);
						$return=array();
						$return['result']=array();
						if($page=='hfa_application')
							{
								$formOne=getHfaOneAppDetails($_POST['hfa_id']);
								$formThree=getHfaThreeAppDetails($_POST['hfa_id']);
								$input['formOne']=$formOne;
								$input['formThree']=$formThree;
								$return['appPageNotiHtml']=$this->load->view('system/hfa/hfaAppPageNotiLi',$input,true);
							}
						echo json_encode($return);
					}
				}
				else
					echo json_encode(array('result'=>"LO"));
		}
		function unapproveHfaPlIns($page)
		{
			if(checkLogin())
				{
					if(isset($_POST['hfa_id'])){
						$this->hfa_model->unapproveHfaPlIns($_POST['hfa_id']);
						$return=array();
						$return['result']=array();
						if($page=='hfa_application')
							{
								$formOne=getHfaOneAppDetails($_POST['hfa_id']);
								$formThree=getHfaThreeAppDetails($_POST['hfa_id']);
								$input['formOne']=$formOne;
								$input['formThree']=$formThree;
								$return['appPageNotiHtml']=$this->load->view('system/hfa/hfaAppPageNotiLi',$input,true);
							}
						echo json_encode($return);
					}
				}
				else
					echo json_encode(array('result'=>"LO"));
		}
				
		function wwreviewStatusModalInfo($id){			
			if(checkLogin())
			{  
				$data['formThree']=getHfaThreeAppDetails($id);
				$this->load->view('system/hfa/wwinsuranceContent',$data);
			}
			else
				echo "LO";
		}
		
		function approveHfawwIns($page)
		{
			if(checkLogin())
				{  
					if(isset($_POST['hfa_id_ww']))
					{
						$this->hfa_model->approveHfawwIns($_POST['hfa_id_ww']);
						$return=array();
						$return['result']=array();
						if($page=='hfa_application')
							{
								$formOne=getHfaOneAppDetails($_POST['hfa_id_ww']);
								$formThree=getHfaThreeAppDetails($_POST['hfa_id_ww']);
								$input['formOne']=$formOne;
								$input['formThree']=$formThree;
								$return['appPageNotiHtml']=$this->load->view('system/hfa/hfaAppPageNotiLi',$input,true);
							}
						echo json_encode($return);
					}
				}
				else
					echo json_encode(array('result'=>"LO"));
		}
		function unapproveHfawwIns($page)
		{
			if(checkLogin())
				{  
					if(isset($_POST['hfa_id_ww']))
					{
						$this->hfa_model->unapproveHfawwIns($_POST['hfa_id_ww']);
						$return=array();
						$return['result']=array();
						if($page=='hfa_application')
							{
								$formOne=getHfaOneAppDetails($_POST['hfa_id_ww']);
								$formThree=getHfaThreeAppDetails($_POST['hfa_id_ww']);
								$input['formOne']=$formOne;
								$input['formThree']=$formThree;
								$return['appPageNotiHtml']=$this->load->view('system/hfa/hfaAppPageNotiLi',$input,true);
							}
						echo json_encode($return);
					}
				}
				else
					echo json_encode(array('result'=>"LO"));
		}
		
		
	////////////// For data table server side STARTS
	public function ajax_list()
	{
		$list = $this->hfa_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		
		$nameTitleList=nameTitleList();
		$stateList=stateList();
		$hfa_status_page=$_POST['hfa_status_page'];
		$hfaStatusList=hfaStatusList();
		$do_not_useOptions=do_not_useOptions();
		$genderList=genderList();
		
		foreach ($list as $host) {
			//$step=hfaAppCheckStep($host->id);
			$step=$host->step;
			$docs=hfaDocs($host->id);
			$nominateduser=totalnominatedfmaily($host->id);
			if($nominateduser>1){
				$nominatetooltip="Family nominated by ".$nominateduser." students";
				
			}else{
				$nominatetooltip="Family nominated by ".$nominateduser." student";
			}
			if($host->hfa_bookmark=='0'){
	$matchStatusShortlistedClass='matchStatusGrey';
			$matchStatusShortlistedToolTip='Click to bookmark';
			
			}else{
				$matchStatusShortlistedClass='matchStatusGreen';
			$matchStatusShortlistedToolTip='Click to unmark';

			}
			if($hfa_status_page=='unavailable' || $hfa_status_page=='approved' || $hfa_status_page=='all')
				$hfaUnavailable=hfaUnavailable($host->id);	 
	
			$row = array();
			
			  //1st Column: HOST #STATRS
			  $row1='<a target="_blank" href="'.site_url().'hfa/application/'.$host->id.'" >'.ucfirst($host->lname).' Family'.'</a>';
			  $row1 .='<br />';
			   
			  if($host->title!=0)
				  $row1 .=$nameTitleList[$host->title].' ';
			  $row1 .=ucwords($host->fname.' '.$host->lname);
				
			  $row1 .='<br />';
				
			  $addressForMap='';
			  if($host->street!='')
				$addressForMap .=$host->street.", ";
			  $addressForMap .=ucfirst($host->suburb).", ".$stateList[$host->state].", ".$host->postcode;
			  $row1 .=getMapLocationLink($addressForMap);
			
			//1st Column: HOST #ENDS
			
			$row[] = $row1;
			
			//2nd Column: CONTACT #STARTS
			$row2='<span class="hold-inline-icon"><a class="mailto" href="mailto:'.$host->email.'">'.$host->email.'</a>';
            if($host->contact_way==2)
				$row2 .='<i class="material-icons contactWayGreenTic" data-placement="bottom"  data-toggle="tooltip"  data-original-title="Email preferred"  style="cursor:default;">chevron_left</i>';
			
			$row2 .='</span>';
            $row2 .='<br>';
            $row2 .='<span class="hold-inline-icon">'.$host->mobile;
            if($host->contact_way==1)
                    $row2 .='<i class="material-icons contactWayGreenTic" data-placement="bottom"  data-toggle="tooltip"  data-original-title="Phone call preferred" style="cursor:default;">chevron_left</i>';
			
			$row2 .='</span>';
            if($host->contact_time!='00:00:00')
					$row2 .='<br>Best time to call: '.date('H:i',strtotime($host->contact_time));
			
			if(($hfa_status_page=='approved' || $hfa_status_page=='all') && !empty($hfaUnavailable))
				$row2 .='<br><strong>Unavailable: '.date('d M Y',strtotime($hfaUnavailable['date_from'])).' - '.date('d M Y',strtotime($hfaUnavailable['date_to']))."</strong>";
												
			//2nd Column: CONTACT #ENDS
			
			$row[] = $row2;
			
			//3rd Column: STATUS #STARTS
			if($hfa_status_page=='confirmed' || $hfa_status_page=='pending_approval' || $hfa_status_page=='approved' || $hfa_status_page=='do_not_use' || $hfa_status_page=='new' || $hfa_status_page=='no_response' || $hfa_status_page=='all')
			{
			$row3='';
				
				if($hfa_status_page=='confirmed' || $hfa_status_page=='pending_approval' || $hfa_status_page=='approved' || $hfa_status_page=='do_not_use')
				{
                    if($hfa_status_page=='confirmed')
					{
						$row3 .='<span class="hold-inline-icon">';
						$row3 .=date('d M Y, h:i A',strtotime($host->visit_date_time));
						
						if(ifHfaRescheduled($host->id))
						{
							$row3 .='<i class="material-icons rescheduledGreenTic" data-placement="bottom"  data-toggle="tooltip"  data-original-title="Rescheduled" style="cursor:default;">chevron_left</i>';
						}
						$row3 .='</span>';
						if($host->visitor_name!='')
							$row3 .='<br><span data-placement="bottom"  data-toggle="tooltip"  data-original-title="Person visiting this family" style="cursor:default;">'.ucwords($host->visitor_name).'</span>';
						if($host->comments!='')
							$row3 .="<br>".$host->comments;
					}
					elseif($hfa_status_page=='pending_approval' || $hfa_status_page=='approved')
					{
						$plstatusval=getplstatus($host->id);
						if(!empty($plstatusval))
						{
							$pltooltp='';
							$plstatusicon='';
							if($plstatusval['pl_ins_status']==0){
								$pltooltp='Click to review PL Insurance status';
								$plstatusicon='<img src="'.static_url().'img/pl-icon.png" id="plstatusicon-'.$host->id.'" data-placement="bottom" data-toggle="tooltip" data-original-title="'.$pltooltp.'" width="20">';
							}elseif($plstatusval['pl_ins_status']==1){
								$pltooltp='PL Insurance status is approved';
								$plstatusicon='<img src="'.static_url().'img/pl-approve-icon.png" id="plstatusicon-'.$host->id.'" data-placement="bottom" data-toggle="tooltip" data-original-title="'.$pltooltp.'" width="22">';
							}
							$row3 .='<a href="javascript:void(0);" class="mr-sm margin-right-5" data-toggle="modal" data-target="#mode_reviewPLIstatus" onclick="plreviewStatusModalInfoclick('.$host->id.','.$plstatusval['pl_ins_status'].');">'.$plstatusicon.'</a>';
						}
						else
						{
							$row3 .='<span class="hfaAppIncomp">Application incomplete</span>';
						}
						
						
						
						$wwstatusval=getwwstatus($host->id);
						if(!empty($wwstatusval))
						{
							$wwtooltp='';
							$wwstatusicon='';
							if($wwstatusval['wwcc_status']==0){
								$wwtooltp='Click to review WWCC status';
								$wwstatusicon='<img src="'.static_url().'img/ww-icon.png" id="wwstatusicon-'.$host->id.'" data-placement="bottom" data-toggle="tooltip" data-original-title="'.$wwtooltp.'" width="20">';
							}elseif($wwstatusval['wwcc_status']==1){
								$wwtooltp='WWCC status is approved';
								$wwstatusicon='<img src="'.static_url().'img/ww-approve-icon.png" id="wwstatusicon-'.$host->id.'" data-placement="bottom" data-toggle="tooltip" data-original-title="'.$wwtooltp.'" width="22">';
							}
							$row3 .='<a href="javascript:void(0);" data-toggle="modal" data-target="#mode_reviewWWCCstatus" onclick="wwreviewStatusModalInfoclick('.$host->id.','.$wwstatusval['wwcc_status'].');">'.$wwstatusicon.'</a>';
						}
						
						
				
						
						/*$wwccFile=false;
						if(isset($docs[0]['wwcc_file']) && $docs[0]['wwcc_file']!='')
							$wwccFile=true;
					
						$row3 .='<span><i class="material-icons ';
							if($wwccFile){$row3 .='documentsGreenTic';}else{$row3 .="documentsGreyTic";}
							$row3 .='" data-placement="bottom"  data-toggle="tooltip"  data-original-title="';
								if($wwccFile){$row3 .= "Submitted";}else{$row3 .= "Not submitted";}
								$row3 .='" style="cursor:default;">check</i>WWCC</span>';
						$row3 .='<br>';
						$row3 .='<span><i class="material-icons documentsGreyTic" data-placement="bottom"  data-toggle="tooltip"  data-original-title="Not submitted" style="cursor:default;">check</i>PL Insurance</span>';*/
					}
					elseif($hfa_status_page=='do_not_use')
					{
						$hfaDnuReason=hfaDnuReason($host->id);
						if(!empty($hfaDnuReason))
						{
							$row3 .=$do_not_useOptions[$hfaDnuReason['reason']];
							if($hfaDnuReason['comment']!='')
								$row3 .="<br>".$hfaDnuReason['comment'];
						}
						}
                   
				   $row3 .='</td>';
                  } else if($hfa_status_page=='all'){
					  				$row3 .='<td>'.date('d M Y',strtotime($host->date)).'</td>';
					
					
			if(@ucfirst($host->hfa_registered_status)=='Online'){
				$row3 .='<br />';
				$row3 .='Online';
}else if(@ucfirst($host->hfa_registered_status)=='Offline'){
	$row3 .='<br />';
	$row3 .='By Admin';
}
					  
				  }
                                     
				if($hfa_status_page=='new' || $hfa_status_page=='no_response' )
				{
					$row3 .='<td>'.date('d M Y',strtotime($host->date)).'</td>';
					$row3 .='<br />';
					
			if(@ucfirst($host->hfa_registered_status)=='Online'){
				$row3 .='Online';
}else if(@ucfirst($host->hfa_registered_status)=='Offline'){
	$row3 .='By Admin';
}
				} 
				
			
			$row[] = $row3;
			}
			//3rd Column: STATUS #ENDS
				
			if($hfa_status_page=='unavailable')
				{
					$rowUnavailable ='<td>'.date('d M Y',strtotime($hfaUnavailable['date_from'])).' to '.date('d M Y',strtotime($hfaUnavailable['date_to'])).'<p>'.$host->comments.'</p></td>';
					$row[] = $rowUnavailable;
				} 			
			
			
			//////////////
			$row4='<button class="mt-n mb-xs btn btn-sm btn-label" data-toggle="modal" ';
			if($host->status!='do_not_use')
				$row4 .='data-target="#model_ChangeStatusHfa"  onclick="hfaChangeStatusPopContent('.$host->id.','.'\''.$hfa_status_page.'\''.');" ';
			else
				//$row4 .='data-target="#model_doNotUseChangeStatus"  ';	
				$row4 .='data-target="#model_ChangeStatusHfa" onclick="hfaChangeStatusPopContent('.$host->id.','.'\''.$hfa_status_page.'\''.');" ';	
		$row4 .=' id="changeStatusHfaEditBtn-'.$host->id.'">';
                                                  $row4 .='<i class="material-icons font14">edit</i>';
                                                  $row4 .='<span>';
												  if($hfa_status_page=='all')
												  		$row4 .=$hfaStatusList[$host->status];
													else
														$row4 .="Change";
												 
                                                 $row4 .='</span>';
                                           $row4 .='</button>';
                                          
                                                  if($host->date_status_changed!='0000-00-00 00:00:00'){
            	                                        $row4 .='<br />';
			                                           $row4 .='<span class="statusChangeDate" data-placement="bottom" data-toggle="tooltip"  data-original-title="Status change date">';
													  		$row4 .=date('d M Y',strtotime($host->date_status_changed));
                                                        $row4 .='</span>';
												}
                                            
                                                  
                                            if($hfa_status_page=='new' || $hfa_status_page=='no_response' || $hfa_status_page=='confirmed')
										   			{
														if($step>4)
														{$stepStatus="Full application submitted";}
														else{if($step>3)
														{$stepStatus= "Third";}
														elseif($step>2)
															{$stepStatus= "Second";}
														elseif($step>1)
														{$stepStatus= "First";} 
														$stepStatus .= " step completed";}
                                                       $row4 .='<br />';
                                                        $row4 .='<span class="ml-lg steps-indicator-hol" data-placement="bottom" data-toggle="tooltip"  data-original-title="'.$stepStatus.'">';
                                                            $row4 .='<i class="fa fa-stop'; 
																if($step>1){$row4 .=' completed-app-step';}
																$row4 .='"></i>';
                                                            $row4 .='<i class="fa fa-stop';
																if($step>2){$row4 .=' completed-app-step';}
																$row4 .='"></i>';
                                                            $row4 .='<i class="fa fa-stop';
																if($step>3){$row4 .=' completed-app-step';}
																$row4 .='"></i>';
                                                            $row4 .='<i class="fa fa-stop';
															    if($step>4){$row4 .=' completed-app-step';}
																$row4 .='"></i>';
                                                        $row4 .='</span>';
                                            } 
			////////////////////
			$row[] = $row4;
			
			
			/////////////
			//4th Column: Office use #STARTS
			 $row6 ='';
			
			 $row6 ='<i style="float:left;" class="fa fa-bookmark '.$matchStatusShortlistedClass.'" data-placement="bottom"  data-toggle="tooltip"  data-original-title="'.$matchStatusShortlistedToolTip.'" onclick="hostfamilybookmark($(this),'.$host->id.');"></i>';
			
			if($host->step==5)
			 {
				 $hostFour=getHfaFourAppDetails($host->id);
				 if(in_array($hostFour['gender_pref'],array(1,2)))
					 $row6.='<span class="icon" style="float:left;"><i class="matchStatusGrey fa fa-'.strtolower($genderList[$hostFour['gender_pref']]).'" data-placement="bottom"  data-toggle="tooltip"  data-original-title="'.$genderList[$hostFour['gender_pref']].' preferred" style="font-size:18px;"></i></span>';
			 }
			
			if($host->revisit=='1')
			{
				if($host->status=='do_not_use' || $host->status=='unavailable')
					{
						$revisitColorClass='matchStatusGrey';
						$revisitStyleColor='';
						$revisitIconToolTip="Revisit doesn't apply";
						$revisitAnchorAttr='href="javascript:void(0);"';
					}
					else
					{
						$revisitColorClass='';
						$revisitStyleColor='color:#03a9f4;';
						$revisitIconToolTip="Revisit required";
						$revisitAnchorAttr='data-toggle="modal" data-target="#model_hfaRevisitPop" onclick="openRevistPopResetForm('.$host->id.');"';
					}
					$row6 .='<a  '.$revisitAnchorAttr.' id="revistPopLink_'.$host->id.'"><i style="'.$revisitStyleColor.' font-size:22px; float:left; margin-top:-2px; cursor: pointer;" class="font16 material-icons '.$revisitColorClass.'" data-placement="bottom" data-toggle="tooltip"  data-original-title="'.$revisitIconToolTip.'">restore</i></a>';	
			}
			 if($nominateduser>0)
				$row6.='<i class="fa fa-external-link-square matchStatusGreen" data-placement="bottom"  data-toggle="tooltip"  data-original-title="'.$nominatetooltip.'"></i>';
			 
			 $row6 .='';
			//4th Column: Office use #ENDS

			$row[]=$row6;
			/////////////////
			
			
			/////////////////
			$row5='<div class="btn-group dropdown table-actions">';
            $row5 .='<button class="btn btn-sm btn-midnightblue dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="true">';
                                                $row5 .='<i class="colorBlue material-icons">more_horiz</i>';
                                                $row5 .='<div class="ripple-container"></div>';
                                            $row5 .='</button>';
                                            $row5 .='<ul class="dropdown-menu" role="menu">';
                                                $row5 .='<li>';
                                                $row5 .='<a href="'.site_url().'hfa/application/'.$host->id.'/#tab-8-3"><i class="font16 material-icons">edit</i>&nbsp;&nbsp;Edit</a>';
                                                $row5 .='</li>';
                                                $row5 .='<li>';
												
												$sql_exiting_booking="select 1 from `bookings` where `host`='".$host->id."'";
													$query_exist_booking=$this->db->query($sql_exiting_booking);
													if($query_exist_booking->num_rows()>0) {
														$booking_exist=1;	
													}
													else {
														$booking_exist=0;	
													}
													
                                                $row5 .='<a data-booking="'.$booking_exist.'" href="javascript:;" class="hfaDeleteApp" id="hfaDeleteApp-'.$host->id.'"><i class="font16 material-icons">delete</i>&nbsp;&nbsp;Delete</a>';
                                                $row5 .='</li>';
                                                
                                                if($step!=5 && ($hfa_status_page=='new' || $hfa_status_page=='no_response' || $hfa_status_page=='confirmed')){
                                                
													$row5 .='<li>';
													
													
													$row5 .='<a  href="javascript:void(0);" data-toggle="modal" data-target="#model_sendCompletionEmail" onclick="sendEmailHalfApplicationHfaPopContent('.$host->id.')" id="sendEmailHalfApplicationHfa-'.$host->id.'"><i class="font16 material-icons">email</i>&nbsp;&nbsp;Email completion link</a>';
													$row5 .='</li>';
                                                } 
                                                
                                                if($hfa_status_page=="confirmed"){
                                                    $row5 .='<li>';
                                                    	$row5 .='<a href="javascript:void(0);" data-toggle="modal" data-target="#model_rescheduleVisit" onclick="rescheduleVisitPopContent('.$host->id.')"><i class="font16 material-icons">date_range</i>&nbsp;&nbsp;Reschedule </a>';
                                                     $row5 .='</li>';
                                                 }
												 
												if($hfa_status_page=='unavailable') {
                                                    $row5 .='<li>';
                                                    	$row5 .='<a href="javascript:void(0);" data-toggle="modal" data-target="#model_changeUnavailableToDate" onclick="changeUnavailableToDatePopContent('.$host->id.')"><i class="font16 material-icons">date_range</i>&nbsp;&nbsp;Change date </a>';
                                                     $row5 .='</li>';
                                                 }
                                                
                                            $row5 .='</ul>';
                                            $row5 .='</div>';
			///////////////////////
			
			$row[] = $row5;
			/*$row[] = $customers->email;*/
			/*$row[] = $customers->mobile;
			$row[] = $customers->suburb;*/

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->hfa_model->count_all(),
						"recordsFiltered" => $this->hfa_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	////////////// For data table server side ENDS	
		
		
	function changeStatusUnavailable()
		{
			if(checkLogin())
			{
				$data=$_POST;
				if($data['hfaChangeStatus_id']!='')
				{
					$dateFrom=strtotime(normalToMysqlDate($data['hfaChangeStatus_unavailableDateFrom']));
					$dateTo=strtotime(normalToMysqlDate($data['hfaChangeStatus_unavailableDateTo']));
					$dateToday=strtotime(date('Y-m-d'));
					if($dateFrom<$dateToday || $dateTo<$dateToday)
						echo 'invalid';
					elseif($dateFrom>$dateTo)
						echo 'opposite';
					elseif($dateFrom==$dateTo)
						echo 'same';	
					else
						{
							$this->hfa_model->changeStatusUnavailable($data);
						}
				}
			}
			else
				echo "LO";
		}
		
		
		
		function changeUnavailableToDatePopContent($id)
		{
			if(checkLogin())
			{
				$getHfaOneAppDetails=getHfaOneAppDetails($id);
				$getHfaOneAppDetails['hfaUnavailable']=hfaUnavailable($id);
				$this->load->view('system/hfa/changeUnavailableToDateForm',$getHfaOneAppDetails);
			}
			else
				echo "LO";
		}
		
		function changeUnavailableToDateSubmit()
		{
			if(checkLogin())
			{
				$data=$_POST;
				if($data['hfaUnavailable_id']!='')
					{
						$this->hfa_model->changeUnavailableToDateSubmit($data);
						echo 'done';
					}
			}
			else
				echo "LO";
		}
		
		function hfaOfficeUseSelfCateredFormSubmit()
		{
			if(checkLogin())
			{
				$data=$_POST;
				if(isset($data['id']))
					$this->hfa_model->hfaOfficeUseSelfCateredFormSubmit($data);
			}
			else
				echo "LO";
		}
		
		function exact_age_from_dob_jquery($dob)
		{			
			$today = date("Y-m-d");
			$diff = date_diff(date_create($dob), date_create($today));
			$age_calculate = $diff->format('%y');
			echo $age_calculate;
		}
		
		function updatePLInsDetails($page)
		{
			if(checkLogin())
			{
				$data=$_POST;
				if(isset($data['hfa_id'])){
					$this->hfa_model->updatePLInsDetails($data);
					
					$return['formThree']=$dataRec['formThree']=getHfaThreeAppDetails($data['hfa_id']);
					$return['plColor']=plInsStatusText($dataRec['formThree']);
					$return['divContent']=$this->load->view('system/hfa/plinsuranceContentFileDiv',$return,true);
					/*$insurance=$formThree['insurance'];
					if($insurance=="0")
						$return['plColor']='<p class="text-danger"><b>Not available</b></p>';
					elseif($insurance=="1"){
						if(($formThree['ins_expiry']!='0000-00-00') && strtotime($formThree['ins_expiry'])<strtotime(date('Y-m-d')))
								$return['plColor']='<p class="colorOrange"><b>Expired</b></p>';	
						else
							$return['plColor']='<p class="text-success"><b>Available</b></p>';	
					}else
						$return['plColor']='<p class="text-info"><b>No info provided</b></p>';*/
					
					
					if($page=='hfa_application')
					{
						
						$formOne=getHfaOneAppDetails($data['hfa_id']);
						$formThree=getHfaThreeAppDetails($data['hfa_id']);
						$input['formOne']=$formOne;
						$input['formThree']=$formThree;
						$return['appPageNotiHtml']=$this->load->view('system/hfa/hfaAppPageNotiLi',$input,true);
					} 
					echo json_encode($return); 
				}
			}
			else
				echo json_encode(array('result'=>"LO"));
		}
		
		function updateWWCCDetails($page)
		{
			if(checkLogin())
			{
				$data=$_POST;
				if(isset($data['hfa_id']))
				{
					$this->hfa_model->updateWWCCDetails($data);
					$formOne=getHfaOneAppDetails($data['hfa_id']);
					$formThree=getHfaThreeAppDetails($data['hfa_id']);
					 $member['member']=$formThree['memberDetails'][$data['fm']];
					 $member['fm']=$data['fm'];
 					 $return['divContent']=$this->load->view('system/hfa/wwinsuranceContentFileDiv',$member,true);
					 $wwccexpired=check_wwcc_expiry($member['member']['wwcc_expiry']);
					 
					 if($member['member']['wwcc']=="0"){
						$wwccColor='btn-danger';
					 }elseif($member['member']['wwcc']=="1" && $member['member']['wwcc_file']==""){
						if($wwccexpired!="expired"){ $wwccColor='btn-warning'; } else { $wwccColor='btn-darkgrey'; }
					 }elseif($member['member']['wwcc']=="1" && $member['member']['wwcc_file']!=""){
						if($wwccexpired!="expired"){ $wwccColor='btn-success'; } else { $wwccColor='btn-darkgrey'; }
					 }
					$return['wwccColor']=$wwccColor;
					
					if($page=='hfa_application')
					{
						$input['formOne']=$formOne;
						$input['formThree']=$formThree;
						$return['appPageNotiHtml']=$this->load->view('system/hfa/hfaAppPageNotiLi',$input,true);
					}
					echo json_encode($return); 
				}
			}
			else
				echo json_encode(array('result'=>"LO"));
		}
		
	function notesSubmit()
	{
		if(checkLogin())
			{
				$data=$_POST;
				if(isset($data['special_request_notes']))
					$this->hfa_model->notesSubmit($data);
			}
			else
				echo "LO";
	}
	
	function notesFamilySubmit()
	{
		if(checkLogin())
			{
				$data=$_POST;
				if(isset($data['notes_family']))
					$this->hfa_model->notesFamilySubmit($data);
			}
			else
				echo "LO";
	}
	
	function vipCheckBedroom()
	{
		$data=$_POST;
		$this->hfa_model->vipCheckBedroom($data);
		echo 'done';
	}
	
	function findSuburb()
	{
		$text=$_POST['input'];
		$suburb=$this->hfa_model->findSuburb($text);
		$resHtml='';
		if(!empty($suburb))
		{
			foreach($suburb as $sub)
			{
				$resHtml	 .='<p id="'.$sub['id'].'">'.$sub['locality'].', '.str_replace('AU-','',$sub['iso2']).', '.$sub['postcode'].'</p>';	
			}
		}
		else
			$resHtml	='<span>No results found</span>';
		echo $resHtml;
	}
			/**
     * Function for upload document 
     * @author Amit kumar
     */
		function hfa_document_upload()
		{
			if($_FILES['file']['name']!= "")
				  {
						$path="./static/uploads/hfadocument"; 
						$t1=time();
						$imagename=$t1.$_FILES['file']['name'];		
						move_uploaded_file($_FILES['file']['tmp_name'],$path.'/'.$imagename);
						
						$this->hfa_model->hfa_document_upload($_POST['clientId'],$imagename);
						$data['client']=$this->hfa_model->hfaDetail($_POST['clientId']);
						//print_r($data);
						$this->load->view('system/hfa/document_list',$data);
					}
		}
		/**
     * Function for delete document
     * @author Amit kumar
     */
     function deletehfadocument()
		{
			if(checkLogin())
			{
				if(isset($_POST['id']))
				{
					$this->hfa_model->deletehfadocument($_POST['id']);
					echo "done";
				}
			}
			else
				echo "LO";
		}
  function deletehfafamilydocument()
		{
			if(checkLogin())
			{
				if(isset($_POST['id']))
				{
					$this->hfa_model->deletehfafamilydocument($_POST['id']);
					echo "done";
				}
			}
			else
				echo "LO";
		}
	/**
     * Function for change the mobile no in db
     * @author Amit kumar
     */		
	 function hfamobileformat(){
				$data=$this->hfa_model->hfamobileformat();
				//echo "<pre>";
				//print_r($data);exit;
				foreach($data as $val){
					$mo=mobileFormat($val['mobile']);
					$hmo=phoneFormat($val['home_phone']);
					$wmo=phoneFormat($val['work_phone']);
					 $data = array(
				'mobile' => $mo,
				'home_phone' => $hmo,
				'work_phone' => $wmo
                );

                 $this->db->where('id', $val['id']);
					$this->db->update('hfa_one', $data);
					echo $val['id']."Sucess"."<br>";
				}
	 }
	 	/**
     * Function for family note form view
     * @author Amit kumar
     */		
	 
	 function familynoteContent($id='', $notid=''){
	 $data['formOne']=$id;
		 
		
		 if($notid!=''){
			
			 $data['not']=$this->hfa_model->getfamilynoteinfo($notid);
			 
		 }
		 
		 $this->load->view('system/hfa/familynotecontent',$data);
	 }
	 function familynotedocumentlist($id,$notid=''){
		 
		  if($notid!=''){
			
			 $data['not']=$this->hfa_model->hfafamilyDetail($id,$notid);
			  $this->load->view('system/hfa/familydocument_list',$data);
		 }
		 
		 
	 }
	 
	 function hfa_familydocument_upload()
		{
			
		
			if($_FILES['file']['name']!= "")
				  {
						$path="./static/uploads/hfafamilydocument"; 
						$t1=time();
						$imagename=$t1.$_FILES['file']['name'];		
						move_uploaded_file($_FILES['file']['tmp_name'],$path.'/'.$imagename);
						$notid=$_POST['notesid'];
						$this->hfa_model->hfa_familydocument_upload($_POST['clientId'],$imagename,$notid);
						$data['not']=$this->hfa_model->hfafamilyDetail($_POST['clientId'],$notid);
						//print_r($data);
						$this->load->view('system/hfa/familydocument_list',$data);
					}
					
		}
		function savefamilynote(){
			
			$data=$_POST;
			$this->session->unset_userdata('notid');
			if($data['not_id']=='')
			{
				$not['note_title']=$_POST['note_title'];
				$not['notes_family']=$_POST['notes_family'];
				$not['hfa_id']=$_POST['hfa_id'];
				$not['employee']=$_POST['notes_emp'];
				$not['note_date']=normalToMysqlDate($_POST['notes_date']);
				$not['note_created']=date('Y-m-d H:i:s');
				$id=$this->hfa_model->savefamilynote($not);
			
				echo $id."-add";
			}else{
				$not['note_title']=$_POST['note_title'];
				$not['notes_family']=$_POST['notes_family'];
				$not['employee']=$_POST['notes_emp'];
				$not['note_date']=normalToMysqlDate($_POST['notes_date']);
				$id=$this->hfa_model->editfamilynote($not,$data['not_id']);
				
				echo $id."-edit";
			}
		
		}
		function application_create()
		{
			if(checkLogin())
			{
				$data['pageTitle']=hfaTitle();
				$this->load->view('header',$data);
				$this->load->view('system/hfa/application_create');
				$this->load->view('footer');
			}
			else
				redirectToLogin();	
		}
		function allhfanote(){
			if(!empty($_POST['hid'])){
			$data['note']=$this->hfa_model->fanilynotedetail($_POST['hid']);
			$this->load->view('system/hfa/allhfanote',$data);
			}
		}
		function deletenote($id){
			$this->hfa_model->deletenote($id);
		echo 1;
		exit;
			
	}
	function bookmarkstatuschangesubmit(){
		
	if(checkLogin())
					$this->hfa_model->bookmarkstatuschangesubmit($_POST);
		else
				echo "LO";	
		

	}
	function deletehfadetail(){
		if(checkLogin())
					$this->hfa_model->deletehfadetail($_POST);
		else
				echo "LO";
		
	}
	
	function printProfileDetails($id)
		{
			if(checkLogin())
			{
				$data['formOne']=getHfaOneAppDetails($id);
				$data['formTwo']=getHfaTwoAppDetails($id);
				$data['formThree']=getHfaThreeAppDetails($id);
				$data['formFour']=getHfaFourAppDetails($id);
				$this->load->view('system/hfa/printProfileDetails',$data);
			}
			else
			{
				echo "Please login to see content of this page";
			}
		}
		function deletenominationstudent($id,$hfaId){
			if(checkLogin())
			{
				$this->hfa_model->deletenominationstudent($id);
				$data['nominationHistory']=$this->hfa_model->nominationHistory($hfaId);
				$this->load->view('system/hfa/homestayNominationHistory',$data);
			}else{
				echo "LO";
			}
		
	}
	
	function hfaRoomDeactivate()
	{
		if(checkLogin())
			{
				$data=$_POST;
				$this->hfa_model->hfaRoomDeactivate($data['id']);
			}
			else
				echo "LO";
	}
	
	function addCallLog()
	{
		if(checkLogin())
			{
				$data=$_POST;
				$this->hfa_model->addCallLog($data);
				$res['callLog']=$this->hfa_model->callLog($data['hfaCallLog_hfaId']);
				$this->load->view('system/hfa/callLog',$res);
			}
		else
			echo "LO";
	}
			
	function revisitInfoSubmit()
	{
		if(checkLogin())
			{
				$data=$_POST;
				if($data['hfaRevisitPop_hfaId']!='')
				{
					$this->hfa_model->revisitInfoSubmit($data);
					echo 'done';
				}
			}
		else
			echo "LO";
	}
			
	function hfaOfficeUseRevisitDurationFormSubmit()
	{
			if(checkLogin())
			{
				$data=$_POST;
				if(isset($data['id']))
					$this->hfa_model->hfaOfficeUseRevisitDurationFormSubmit($data);
			}
			else
				echo "LO";
	}
	
	function addNewVisit()
	{
		if(checkLogin())
			{
				$data=$_POST;
				$this->hfa_model->addNewVisit($data);
				$res['visits']=$this->hfa_model->visits($data['hfaAddNewVisit_hfaId']);
				$this->load->view('system/hfa/visits',$res);
			}
		else
			echo "LO";
	}
	
	function viewVisitReport($id)
	{
			if(checkLogin())
			{
				$data['page']='Hfa-visitReports';
				$data['visitReport']=$this->hfa_model->visitReport($id);
				if(!empty($data['visitReport']))
				{//see($data['visitReport']);
					$data['hfaTwo']=getHfaTwoAppDetails($data['visitReport']['hfa_id']);
				
					$this->load->view('system/header',$data);
					$this->load->view('system/hfa/visitReport');
					$this->load->view('system/footer');
				}
			}
			else
				redirectToLogin();	
	}
	
	function visitReport_submit()
	{
		if(checkLogin())
			{
				$data=$_POST;
				$this->hfa_model->visitReport_submit($data);
			}
		else
			echo "LO";
	}
	
	function appHistoryTabContent()
	{
		$id=$_POST['id'];
		$sortBy=$_POST['sortBy'];
		$data['booking_history']=$this->hfa_model->booking_history($id,$sortBy);
		$this->load->view('system/hfa/application_history_list',$data);
	}
	
	function printVisitReport($id)
		{
			if(checkLogin())
			{
				$data['visitReport']=$this->hfa_model->visitReport($id);
				if(!empty($data['visitReport']))		
					$this->load->view('system/hfa/printVisitReport',$data);
			}
			else
			{
				echo "Please login to see content of this page";
			}
		}
	
	function pdfVisitReport($id)
		{
			if(checkLogin())
			{
				$data['visitReport']=$this->hfa_model->visitReport($id);
				if(!empty($data['visitReport']))
				{
					$this->load->library('pdf');
					$this->pdf->load_view('system/hfa/printVisitReportPdf',$data,true);
					$this->pdf->Output();
				}
			}
			else
			{
				echo "Please login to see content of this page";
			}
		}
	
	function wordVisitReport($id)
		{
			if(checkLogin())
			{
				$data['visitReport']=$this->hfa_model->visitReport($id);
				if(!empty($data['visitReport']))
				{
					header("Content-type: application/vnd.ms-word");
					header("Content-Disposition: attachment;Filename=Visit_report.doc");
					header("Pragma: no-cache");
					header("Expires: 0");
					$this->load->view('system/hfa/printVisitReportWord',$data);
				}
			}
			else
			{
				echo "Please login to see content of this page";
			}
		}
	
	function mapLocation()
	{
		$this->load->view('system/hfa/mapLocationIframe');
	}
		
	function callLog_delete($id,$hfa_id)
	{
		if(checkLogin())
			{
				if(userAuthorisations('hfa_callLog_delete'))
				{
					$this->hfa_model->callLog_delete($id);
					$res['callLog']=$this->hfa_model->callLog($hfa_id);
					$this->load->view('system/hfa/callLog',$res);
				}
			}
		else
			echo "LO";
	}
		
	function visitReport_delete($id,$hfa_id)
	{
		if(checkLogin())
			{
				if(userAuthorisations('hfa_visitReport_delete'))
				{
					$this->hfa_model->visitReport_delete($id);
					$res['visits']=$this->hfa_model->visits($hfa_id);
					$this->load->view('system/hfa/visits',$res);
				}
			}
		else
			echo "LO";
	}	
	
	function addCApprovalSubmit()
	{
		if(checkLogin())
			{
				$data=$_POST;
				$this->hfa_model->addCApprovalSubmit($data);
				$res['cApprovalList']=$this->hfa_model->collegeApprovalList($data['hfa_id']);
				$this->load->view('system/hfa/collegeApprovalList',$res);
			}
		else
			echo "LO";
	}
		
	function cApprovalDel($id,$hfa_id)
	{
		if(checkLogin())
			{
				$this->hfa_model->cApprovalDel($id);
				$res['cApprovalList']=$this->hfa_model->collegeApprovalList($hfa_id);
				$this->load->view('system/hfa/collegeApprovalList',$res);
			}
		else
			echo "LO";
	}
	
	function hfaTransportInfoPopContent($id,$type)
	{
		if(checkLogin())
			{
				$res=array();
				if($type=='edit')
					$res['transportInfo']=$this->hfa_model->transportInfoDetails($id);
				else
					$res['hfa_id']=$id;
				$this->load->view('system/hfa/transportInfoPopContent',$res);
			}
		else
			echo "LO";
	}
	
	function addNewTransportInfo()
	{
		if(checkLogin())
			{
				$data=$_POST;
				$this->hfa_model->addNewTransportInfo($data);
				$res['transport']=$this->hfa_model->transportInfoByHfaId($data['transportHfaId']);
				$this->load->view('system/hfa/transportList',$res);
			}
		else
			echo "LO";
	}
	
	function hfaTransportInfo_delete($id,$hfa_id)
	{
		if(checkLogin())
			{
				if(userAuthorisations('hfaTransportInfo_delete'))
				{
					$this->hfa_model->hfaTransportInfo_delete($id);
					$res['transport']=$this->hfa_model->transportInfoByHfaId($hfa_id);
					$this->load->view('system/hfa/transportList',$res);
				}
			}
		else
			echo "LO";
	}
	
	function hfaWarningSendPopContent($id,$type)
	{
		if(checkLogin())
			{
				$res=array();
				if($type=='edit')
				{
					$res['warningDetails']=$this->hfa_model->hfaWarningDetails($id);
					$res['hfa_id']=$res['warningDetails']['hfa_id'];
					$resDoc['warning_documents']=hfaWarningDocs($id);
					$return['warning_documents']=$this->load->view('system/hfa/warningDocuments',$resDoc,true);
				}
				else
					$res['hfa_id']=$id;
				$return['content']=$this->load->view('system/hfa/warningsSendPopContent',$res,true);
			}
		else
			$return['logout']="LO";
		echo json_encode($return);	
	}
	
	function addNewWarning()
	{
		if(checkLogin())
			{
				$data=$_POST;//see($data);
				$return['warning_id']=$this->hfa_model->addNewWarning($data);
				$res['warnings']=$this->hfa_model->warningsByHfaId($data['hfaWarningSend_hfaId']);
				$return['warnings']=$this->load->view('system/hfa/warningsList',$res,true);
			}
		else
			$return['logout']="LO";
		echo json_encode($return);	
	}
	 
	 function hfaWarningDoc_upload()
		{
			//see($_POST);
			//see($_FILES);
			if($_FILES['file']['name']!= "")
				  {
						$path="./static/uploads/hfaWarningDoc"; 
						$t1=time();
						$imagename=$t1.$_FILES['file']['name'];		
						move_uploaded_file($_FILES['file']['tmp_name'],$path.'/'.$imagename);
						$warning_id=$_POST['hfaWarning_idSecond'];
						$this->hfa_model->hfaWarningDoc_upload($warning_id,$imagename);
		
						$res['warnings']=$this->hfa_model->warningsByHfaId($_POST['hfaWarning_hfaId']);
						$return['warnings']=$this->load->view('system/hfa/warningsList',$res,true);
						
						$resDoc['warning_documents']=hfaWarningDocs($warning_id);
						$return['warning_documents']=$this->load->view('system/hfa/warningDocuments',$resDoc,true);
						echo json_encode($return);
					}
					
		}
		
	function deleteHfaWarningDoc()
		{
			if(checkLogin())
			{
				if(isset($_POST['id']))
				{
					$hfaId=$this->hfa_model->deleteHfaWarningDoc($_POST['id']);
					if($hfaId!='0')
					{
						$res['warnings']=$this->hfa_model->warningsByHfaId($hfaId);
						$this->load->view('system/hfa/warningsList',$res);
					}
				}
			}
			else
				echo "LO";
		}
		
	function hfaWarning_delete($id,$hfaId)
	{
		if(checkLogin())
			{
					$this->hfa_model->hfaWarning_delete($id);
					$res['warnings']=$this->hfa_model->warningsByHfaId($hfaId);
					$this->load->view('system/hfa/warningsList',$res);
			}
		else
			echo "LO";
	}
	
	function visitReportDateEditPopContent()
	{
		if(userAuthorisations('hfa_visitReport_editDate'))
		{
			if(checkLogin())
				{
					$data=$_POST;
					$res['visitReport']=$this->hfa_model->visitReport($data['visitReportId']);
					if(!empty($res['visitReport']))
						$this->load->view('system/hfa/visitReportEditDate',$res);
				}
			else
				echo "LO";
		}
	}
	
	function visitReportDateEditSubmit()
	{
		if(userAuthorisations('hfa_visitReport_editDate'))
		{
			if(checkLogin())
				{
					$data=$_POST;
					$this->hfa_model->visitReportDateEditSubmit($data);
					$res['visits']=$this->hfa_model->visits($data['hfaEditVisitReportDate_hfaId']);
					$this->load->view('system/hfa/visits',$res);
				}
			else
				echo "LO";
		}
	}
	
	function visitReportCopySubmit()
	{
			if(checkLogin())
				{
					$data=$_POST;
					$this->hfa_model->visitReportCopySubmit($data);
					$res['visits']=$this->hfa_model->visits($data['hfaCopyVisitReport_hfaId']);
					$this->load->view('system/hfa/visits',$res);
				}
			else
				echo "LO";
	}
	
	function swapFamilyMember($memberId, $swapOrder)
	{
		if(checkLogin())
				{
					$application_id=$this->hfa_model->swapFamilyMember($memberId, $swapOrder);
					header('location:'.site_url().'hfa/application_edit_three/'.$application_id.'/#memberSwapped');
				}
			else
				header('location:'.site_url(),'refresh');
	}


	function deletehostbed(){
		if(checkLogin())
					$this->hfa_model->deletehostbed($_POST);
		else
				echo "LO";
		
	}




}



