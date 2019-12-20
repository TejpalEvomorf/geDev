<?php
class Sha extends CI_Controller {

		function __construct()
		{
			parent::__construct();
			$this->load->model('sha_model');
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

		function pending_invoice()
		{
			if(checkLogin())
			{
				$status='pending_invoice';
				$this->applicationByStatus($status);
			}
			else
				redirectToLogin();
		}

		function approved_with_payment()
		{
			if(checkLogin())
			{
				$status='approved_with_payment';
				$this->applicationByStatus($status);
			}
			else
				redirectToLogin();
		}

		function approved_without_payment()
		{
			if(checkLogin())
			{
				$status='approved_without_payment';
				$this->applicationByStatus($status);
			}
			else
				redirectToLogin();
		}

		function rejected()
		{
			if(checkLogin())
			{
				$status='rejected';
				$this->applicationByStatus($status);
			}
			else
				redirectToLogin();
		}

		function cancelled()
		{
			if(checkLogin())
			{
				$status='cancelled';
				$this->applicationByStatus($status);
			}
			else
				redirectToLogin();
		}

		function applicationByStatus($status)
		{
			recentActionsAddData('sha',$status,'view');
			$data['page']='sha';

			/*$data['listTemp']=$this->sha_model->applicationsList($status);
			if(isset($_GET['appStep']) && ($_GET['appStep']=='partial' || $_GET['appStep']=='complete'))
				{
					$data['list']=array();
					foreach($data['listTemp'] as $listK=>$listV)
					{
						if($_GET['appStep']=='partial')
						{
							if(shaAppCheckStep($listV['id'])<4)
								$data['list'][]=$listV;
						}
						elseif($_GET['appStep']=='complete')
						{
							if(shaAppCheckStep($listV['id'])==4)
									$data['list'][]=$listV;
						}
					}
				}
			`	else
				$data['list']=$data['listTemp'];
				*/
			$data['sha_status_page']=$status;
			//see($data['list']);
			$this->load->view('system/header',$data);
			$this->load->view('system/sha/list');
			$this->load->view('system/footer');
		}

		function changeStatusCancelPopContent($id,$pageStatus)
		{
			 $getHfaOneAppDetails=getShaOneAppDetails($id);
			 $getHfaOneAppDetails['pageStatus']=$pageStatus;
			 $this->load->view('system/sha/changeStatusCancelForm',$getHfaOneAppDetails);
		}


		function changeStatusPopContent($id,$pageStatus)
		{
			 $getHfaOneAppDetails=getShaOneAppDetails($id);
			 $getHfaOneAppDetails['formTwo']=getShaTwoAppDetails($id);
			 $getHfaOneAppDetails['pageStatus']=$pageStatus;
			 $this->load->view('system/sha/changeStatusForm',$getHfaOneAppDetails);
		}

		function changeStatus()
		{
			$this->load->helper('product');
			$data=$_POST;
			if($data['shaChangeStatus_id']!='')
			{
				$getShaOneAppDetails=getShaOneAppDetails($data['shaChangeStatus_id']);
				
				$clientSel=$data['shaChangeStatus_client'];
				$clientSelDetail=clientDetail($clientSel);
				
				$changeStatus=false;
				if($clientSelDetail['group_invoice']=='1' && $getShaOneAppDetails['booking_from']!='0000-00-00')
					$changeStatus=true;
				elseif($clientSelDetail['group_invoice']=='1' && $getShaOneAppDetails['booking_from']=='0000-00-00' && $data['shaChangeStatus_status']!='pending_invoice')
					$changeStatus=true;	
				elseif($clientSelDetail['group_invoice']=='0')	
					$changeStatus=true;
					
				if($changeStatus)
				{
					$this->sha_model->changeStatus($data);
				
					if($data['shaChangeStatus_status']=='pending_invoice' && $getShaOneAppDetails['status']!='pending_invoice')
						{
							$getShaOneAppDetailsAfter=getShaOneAppDetails($data['shaChangeStatus_id']);
							$client_id=$getShaOneAppDetailsAfter['client'];
							$clientDetail=clientDetail($client_id);
							if($clientDetail['group_invoice']=='0')
								{
									  $this->load->model('invoice_model');
									  $this->invoice_model->addPendingInvoice($data);
									  echo 'done';
								}
						}
				}
				else
				{
					if($clientSelDetail['group_invoice']=='1' && $getShaOneAppDetails['booking_from']=='0000-00-00' && $data['shaChangeStatus_status']=='pending_invoice')
						echo 'groupInvoice-bookingFrom';
				}
				
			}
		}

		function sendEmailHalfApplicationShaPopContent($id)
		{
			$getHfaOneAppDetails=getShaOneAppDetails($id);
			$this->load->view('system/sha/sendAppCompletionEmailForm',$getHfaOneAppDetails);
		}

		function sendEmailHalfApplication()
		{
			  $id=$_POST['shaSendEmail_id'];
			  $getShaOneAppDetails=getShaOneAppDetails($id);
			  $this->load->library('email');
			  $this->email->clear();
			  $config['mailtype'] = 'html';
			  $this->email->initialize($config);

			   $this->email->from(header_from_email(),header_from());

			  $this->email->subject('Complete your Student Homestay Application');
			  $to =  $_POST['shaEmail'];
			  $this->email->to($to);
			  //$this->email->to('tejpal@evomorf.com');
			  $emailData['name']=$getShaOneAppDetails['fname'];

			  $link=codeEncode($id);
			  $link=site_url().'form/student_homestay_application_two/'.$link;
			  $emailData['link']=$link;

			  $email_msg_user=$this->load->view('form/emails/sha',$emailData,true);
			  $this->email->message($email_msg_user);

			  $this->email->send();
		}

		function deleteApplication()
		{
			if(isset($_POST['id']))
			{
				$this->sha_model->deleteApplication($_POST['id']);
				echo "done";
			}
		}

		function application($id)
		{
			if(checkLogin())
			{
				$getShaOneAppDetails=getShaOneAppDetails($id);
				if(empty($getShaOneAppDetails))
					header('location:'.site_url().'sha/');
				else
				{
					recentActionsAddData('sha',$id,'view');
					$data['page']='sha_application';
					$data['formOne']=getShaOneAppDetails($id);
					$data['formTwo']=getShaTwoAppDetails($id);
					$data['formThree']=getShaThreeAppDetails($id);
					$data['photos']=$this->sha_model->photos($id);
					//$data['booking_history']=$this->sha_model->booking_history($id);
					$data['payment_history']=$this->sha_model->payment_history($id);
					$data['client']=$this->sha_model->shadocument($id);
					$data['note']=$this->sha_model->notedetail($id);
					$data['incidents']=$this->sha_model->incidentsByShaId($id);
					$data['feedbacks']=$this->sha_model->feedbacksByShaId($id);
					$data['holidays']=$this->sha_model->holidaysByShaId($id);
					$data['nominationHistory']=$this->sha_model->nominationHistory($id);
					$this->load->view('system/header',$data);
					$this->load->view('system/sha/application');
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
				$data['pageTitle']=shaTitle();
				$data['formOne']=getShaOneAppDetails($id);
				$this->load->view('header',$data);
				$this->load->view('system/sha/application_edit-1');
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
				//see($data);exit;
				if($data['sha_email']!='')
				{
					$formOne=getShaOneAppDetails($data['id']);
					$id=$this->sha_model->application_edit_one_submit($data);
						echo "done";
					
					//First check if email already user or not
					/*$shaAppCheckByEmail=shaAppCheckByEmail($data['sha_email']);
					if(empty($shaAppCheckByEmail) || $formOne['email']==$data['sha_email'])
					{
						$id=$this->sha_model->application_edit_one_submit($data);
						echo "done";
					}
					else
						echo 'duplicate-email';*/
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
				$data['pageTitle']=shaTitle();
				$data['formOne']=getShaOneAppDetails($id);
				$data['formTwo']=getShaTwoAppDetails($id);
				//see($data);
				$this->load->view('header',$data);
				$this->load->view('system/sha/application_edit-2');
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
					$this->sha_model->application_edit_two_submit($data);
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
				$data['pageTitle']=shaTitle();
				$data['formOne']=getShaOneAppDetails($id);
				$data['formThree']=getShaThreeAppDetails($id);
				//see($data);
				$this->load->view('header',$data);
				$this->load->view('system/sha/application_edit-3');
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
				//see($data);
				if($data['id']!='')
				{
					$this->sha_model->application_edit_three_submit($data);
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
						$path="./static/uploads/sha/photos";
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

						$this->sha_model->application_image_upload_insert($_POST['appId'],$imagename);
				  }
		}

		function appPagePhotosBoxRefresh()
		{
			if($_POST['id']!='')
			{
				$id=$_POST['id'];
				$data['photos']=$this->sha_model->photos($id);
				$this->load->view('system/sha/application_photos_list',$data);
			}
		}

		function application_create()
		{
			if(checkLogin())
			{
				$data['pageTitle']=shaTitle();
				$this->load->view('header',$data);
				$this->load->view('system/sha/application_create');
				$this->load->view('footer');
			}
			else
				redirectToLogin();
		}

		function officeUseChangeAttrFormSubmit()
		{
			if(checkLogin())
			{
				$this->load->model('sha_model');
				$this->sha_model->officeUseChangeAttrFormSubmit($_POST);
				echo "Done";
			}
			else
				echo "LO";
		}

		function officeUseChangeAttrFormSubmit_changeClient()
		{
			if(checkLogin())
			{
				$this->load->model('sha_model');
				$this->sha_model->officeUseChangeAttrFormSubmit_changeClient($_POST);
				echo "Done";
			}
			else
				echo "LO";
		}

		function filterMatches()
		{
			$data['input']=$_POST;
			$data['formOne']=getShaOneAppDetails($_POST['id']);
			$data['formTwo']=getShaTwoAppDetails($_POST['id']);
			$data['formThree']=getShaThreeAppDetails($_POST['id']);
			$this->load->view('system/sha/filterMatches',$data);
		}

		////////////// For data table server side STARTS
		public function ajax_list()
	{
		$list = $this->sha_model->get_datatables();
		$data = array();
		$no = $_POST['start'];

		$accomodationTypeList=accomodationTypeList();
		$shaStatusList=shaStatusList();
		$nameTitleList=nameTitleList();

		foreach ($list as $student) {
			//see($student);
			$row = array();
			//$step=shaAppCheckStep($student->id);
			$step=$student->step;
			$sha_status_page=$_POST['sha_status_page'];
			$shaFormTwo=getShaTwoAppDetails($student->id);
			$shaAge=age_from_dob($student->dob);

			//1st Column: STUDENT #STATRS
			 $studentId=getActiveStudentFromDupliates($student->id);
			 if($studentId!=$student->id)
			 {
				 $studentActive=getShaOneAppDetails($studentId);
				 $student->id=$studentActive['id'];
				 $student->accomodation_type=$studentActive['accomodation_type'];
				 $student->date_cancelled=$studentActive['date_cancelled'];
				 $student->reason=$studentActive['reason'];
				 $student->status=$studentActive['status'];
				 $student->date_status_changed=$studentActive['date_status_changed'];
				 $student->study_tour_id=$studentActive['study_tour_id'];
			 }
			 
			 $studentTitle='';
			 if($student->title!='')
				$studentTitle=$nameTitleList[$student->title];	
				
			 $row1='<a target="_blank" href="'.site_url().'sha/application/'.$student->id.'" >'.$studentTitle.' '.ucwords($student->fname.' '.$student->lname).'</a>';
             $row1 .='<br />';
         	//    $row1 .='<a class="mailto" href="mailto:'.$student->email.'">'.$student->email.'</a>';
			 $row1 .=date('d M Y',strtotime($student->dob)).' '.'(age '.age_from_dob($student->dob).')';
             $row1 .='<br />';
             $row1 .=@$student->sha_student_no;
			//1st Column: STUDENT #ENDS
			$row[]=$row1;


			//2nd Column: ACCOMODATION TYPE #STATRS
			$row2='';
			if(in_array($sha_status_page,array('rejected','cancelled')))
				$row2 .='Accomodation type: ';
			if($student->accomodation_type!='')
				$row2 .=str_replace('Homestay ','',$accomodationTypeList[$student->accomodation_type]);

			if($sha_status_page=='cancelled')
				$row2 .='<br>Cancelled: '.date('d M Y',strtotime($student->date_cancelled));

			if(in_array($sha_status_page,array('rejected','cancelled')) && $student->reason!='')
				$row2 .='<br>Reason: '.$student->reason;
			//2nd Column: ACCOMODATION TYPE #ENDS
			$row[]=$row2;


			//3rd Column: SUBMITTED #STATRS
			$row3=date('j M Y',strtotime($student->date));
			
			if(@$student->sha_registered_status=='Online'){
				$row3 .='<br />';
				$row3 .='Online';
}else if(@$student->sha_registered_status=='Offline'){
	$row3 .='<br />';
	$row3 .='By Admin';
}else{
	$row3 .='<br />';
	$row3 .='By Admin';
}
             
			//3rd Column: SUBMITTED #ENDS
			$row[]=$row3;

			//3rd Column: STATUS #STATRS
			$row4='';
			if($student->study_tour_id >0)
			{

				//$row4 .='<a href="javascript:void(0);" data-toggle="modal" data-target="#model_ShaStudyTourInfo" onClick="shaStudyTourInfo_popContent('.$student->study_tour_id.');"><i class="font16 material-icons" data-placement="bottom" data-toggle="tooltip"  data-original-title="Part of a study tour, click for more info">group</i></a>';



			 $row4 .='<button class="mt-n mb-xs btn btn-sm btn-label" data-toggle="modal" data-target="#model_ShaStudyTourInfo"  onclick="shaStudyTourInfo_popContent(\''.$student->study_tour_id.'\');">';
                $row4 .='<i class="material-icons font14">edit</i>';
			}
			else{
				$row4 .='<button class="mt-n mb-xs btn btn-sm btn-label" data-toggle="modal" data-target="#model_ChangeStatusSha"  onclick="shaChangeStatusPopContent('.$student->id.',\''.$sha_status_page.'\');" id="changeStatusHfaEditBtn-'.$student->id.'">';
                $row4 .='<i class="material-icons font14">edit</i>';
				//$row4 .='<button class="mt-n mb-xs btn btn-sm btn-label" >';
			}
				$row4 .='<span>';
					if($sha_status_page=='all')
						$row4 .=$shaStatusList[$student->status];
					else
					{
						//if($student->study_group=='')
							$row4 .="Change";
					}
						$row4 .='</span>';
			$row4 .='</button>';


           if($student->date_status_changed!='0000-00-00 00:00:00')
		   {
				$row4 .='<br />';
                $row4 .='<span class="statusChangeDate" data-placement="bottom" data-toggle="tooltip"  data-original-title="Status change date">';
					$row4 .=date('d M Y',strtotime($student->date_status_changed));
				$row4 .='</span>';
			}

            if($sha_status_page=='new')
			{
                 $row4 .='<br />';
				 if($step>3)
				 $data_original_title="Full application submitted";
				 else
				 {
					 if($step>2)
					 $data_original_title="Second";
					 elseif($step>1)
					 $data_original_title="First";
					 $data_original_title .=" step completed";
					 }
                 $row4 .='<span class="ml-lg steps-indicator-hol" data-placement="bottom" data-toggle="tooltip"  data-original-title="'.$data_original_title.'">';

					   $row4 .='<i class="fa fa-stop ';
					   if($step>1){$row4 .=' completed-app-step';}
					   $row4 .='"></i>';

                       $row4 .='<i class="fa fa-stop ';
					   	if($step>2){$row4 .=' completed-app-step';}
						$row4 .='"></i>';

					   $row4 .='<i class="fa fa-stop ';
					   if($step>3){$row4 .=' completed-app-step';}
					   $row4 .='"></i>';
                 $row4 .='</span>';
             }
			//3rd Column: STATUS #ENDS

			$row[]=$row4;

			//4th Column: Office use #STARTS
			 $row6='';
			 if($student->study_tour_id!=0)
				$row6 .='<a href="javascript:void(0);" data-toggle="modal" data-target="#model_ShaStudyTourInfo" onClick="shaStudyTourInfo_popContent('.$student->study_tour_id.');"><i class="font16 material-icons" data-placement="bottom" data-toggle="tooltip"  data-original-title="Part of a tour group, click for more info">stars</i></a>';
			if(!empty($shaFormTwo) && $shaFormTwo['guardianship']=='1' && ($shaFormTwo['guardianship_startDate']=='0000-00-00' || $shaFormTwo['guardianship_endDate']=='0000-00-00'))
				$row6 .='<a href="'.site_url().'sha/application/'.$student->id.'/#tab-8-4" target="_black"><i class="font16 material-icons colorOrange" data-placement="bottom" data-toggle="tooltip"  data-original-title="Caregiving duration not defined">group_work</i></a>';	
			 $shaCollegeNameMatched=shaCollegeNameMatched($student->id);
			if(!$shaCollegeNameMatched)
				$row6 .='<a href="'.site_url().'sha/application/'.$student->id.'/#tab-8-4" target="_black"><i class="font16 material-icons colorOrange" data-placement="bottom" data-toggle="tooltip"  data-original-title="College/Institution not selected">school</i></a>';	
			 $row6 .='';
			//4th Column: Office use #ENDS

			$row[]=$row6;

			//4th Column: ACTIONS #STARTS
			 $row5='<div class="btn-group dropdown table-actions">';
                 $row5 .='<button class="btn btn-sm btn-midnightblue dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="true">';
                                                $row5 .='<i class="colorBlue material-icons">more_horiz</i>';
                                                $row5 .='<div class="ripple-container"></div>';
                                            	$row5 .='</button>';
                                            	$row5 .='<ul class="dropdown-menu" role="menu">';
                                                $row5 .='<li>';
                                                $row5 .='<a href="'.site_url().'sha/application/'.$student->id.'/#tab-8-3"><i class="font16 material-icons">edit</i>&nbsp;&nbsp;Edit</a>';
                                                $row5 .='</li>';
                                                $row5 .='<li>';
												
												if($student->study_tour_id!=0){
													$row5 .='<a href="javascript:;" data-toggle="modal" data-target="#model_ShaStudyTourInfo" onClick="shaStudyTourInfo_popContent('.$student->study_tour_id.');" data-booking="2" class="shaDeleteApp" id="shaDeleteApp-'.$student->id.'"><i class="font16 material-icons">delete</i>&nbsp;&nbsp;Delete</a>';
												}else{
													$booking_exist=$this->sha_model->check_bookings_on_delete_action($student->id);
													$row5 .='<a data-booking="'.$booking_exist.'" href="javascript:;" class="shaDeleteApp" id="shaDeleteApp-'.$student->id.'"><i class="font16 material-icons">delete</i>&nbsp;&nbsp;Delete</a>';
												}
                                                $row5 .='</li>';
												
												
												
                                                if($step!=4 && $sha_status_page=='new'){
                                                    $row5 .='<li>';
                                                    $row5 .='<a href="javascript:void(0);" data-toggle="modal" data-target="#model_sendCompletionEmail" onclick="sendEmailHalfApplicationShaPopContent('.$student->id.')" id="sendEmailHalfApplicationSha-'.$student->id.'"><i class="font16 material-icons">email</i>&nbsp;&nbsp;Email completion link</a>';
                                                    $row5 .='</li>';
                                                 }
												 
												  if(userAuthorisations('copyCancelledSha') && $sha_status_page=='cancelled'){
													$row5 .='<li class="divider"></li>';
                                                    $row5 .='<li>';
                                                    $row5 .='<a href="javascript:;" class="shaCopyApp" id="shaCopyApp-'.$student->id.'"><i class="font16 material-icons">add_to_photos</i>&nbsp;&nbsp;Duplicate as New</a>';
                                                    $row5 .='</li>';
                                                 }

                                            $row5 .='</ul>';
                                            $row5 .='</div>';
			//4th Column: ACTIONS #ENDS

			$row[]=$row5;

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->sha_model->count_all(),
						"recordsFiltered" => $this->sha_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	////////////// For data table server side ENDS


	function filters_approved()
	{
		$this->load->view('system/sha/filters_approved');
	}


	function active_students()
		{
			if(checkLogin())
			{
				$data['page']='active_students';

				//$data['sha_status_page']=$status;
				//see($data['list']);
				$this->load->view('system/header',$data);
				$this->load->view('system/sha/active_students');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
		}

	function bookingDatesSubmit()
	{
		$data=$_POST;
		if(strtotime(normalToMysqlDate($data['shaBooking_endDate']))<=strtotime(normalToMysqlDate($data['shaBooking_startDate'])) && ($data['shaBooking_startDate']!='' && $data['shaBooking_endDate']!=''))
			echo "wrongDates";
		else
			$this->sha_model->bookingDatesSubmit($data);
	}

	function notesSubmit()
	{
		if(checkLogin())
			{
				$data=$_POST;
				if(isset($data['special_request_notes']))
					$this->sha_model->notesSubmit($data);
			}
			else
				echo "LO";
	}
	function homestayNominationSubmit()
	{
		if(checkLogin())
			{
				$data=$_POST;
				if(isset($data['homestayNomination']))
					$this->sha_model->homestayNominationSubmit($data);
					
				$boxData['nominationHistory']=$this->sha_model->nominationHistory($data['id']);
				$returnData['nominationHistory']=$this->load->view('system/sha/homestayNominationBoxContent',$boxData,true);
				$returnData['alertMessage']=0;
			}
			else
				$returnData['result']="LO";
			echo json_encode($returnData);	
	}
function NominationfamilySubmit()
	{
		if(checkLogin())
			{
				$data=$_POST;
				if(isset($data['nominated_hfa_id']))
				{
					$this->sha_model->NominationfamilySubmit($data);
					
					$boxData['nominationHistory']=$this->sha_model->nominationHistory($data['id']);
					$returnData['nominationHistory']=$this->load->view('system/sha/homestayNominationBoxContent',$boxData,true);
					$bookingByShaId=bookingByShaId($data['id']);
		            if(!empty($bookingByShaId) && $data['nominated_hfa_id']==$bookingByShaId['host'])
						$returnData['alertMessage']=1;
					else
						$returnData['alertMessage']=0;
				}
			}
			else
				$returnData['result']="LO";
			echo json_encode($returnData);	
	}
	function filters()
		{
			 $this->load->view('system/sha/filters');
		}

	function app_cancel($id)
	{
		$this->load->helper('product');
		$result=sha_cancellationData($id);
		//see($result);
	}

	function shaStudyTourInfo_popContent($id)
	{
		if(checkLogin())
			{
				$tourDetail=tourDetail($id);
				if(!empty($tourDetail))
					echo $tourDetail['group_name'];
			}
			else
				echo "LO";
	}
	
	function guardianshipOfficeUseFormSubmit($field)
	{
		if(checkLogin())
			{
				$data=$_POST;
				if(isset($data['id']))
				{
					$this->sha_model->guardianshipOfficeUseFormSubmit($data,$field);
					$formOne=getShaOneAppDetails($_POST['id']);
					$formTwo=getShaTwoAppDetails($_POST['id']);
					$input['formOne']=$formOne;
					$input['formTwo']=$formTwo;
					$return=array();
					$return['result']=array();
					$return['appPageNotiHtml']=$this->load->view('system/sha/shaAppPageNotiLi',$input,true);
					echo json_encode($return);
				}
			}
			else
				echo json_encode(array('result'=>"LO"));
	}
	
	function guardianshipOfficeUseDurationSubmit()
	{
		if(checkLogin())
			{
				$data=$_POST;
				if(isset($data['id']))
				{
					$this->sha_model->guardianshipOfficeUseDurationSubmit($data);
					$formOne=getShaOneAppDetails($_POST['id']);
					$formTwo=getShaTwoAppDetails($_POST['id']);
					$input['formOne']=$formOne;
					$input['formTwo']=$formTwo;
					$return=array();
					$return['result']=array();
					$return['appPageNotiHtml']=$this->load->view('system/sha/shaAppPageNotiLi',$input,true);
					$return['durationText']=guardianshipDurationOfficeUsePage(normalToMysqlDate($data['guardianship_startDate']),normalToMysqlDate($data['guardianship_endDate']));
					echo json_encode($return);
				}
			}
			else
				echo json_encode(array('result'=>"LO"));
	}
	
	function gShipDuratoinFromDates()
	{
		$data=$_POST;
		if($data['from']=='' || $data['to']=='')
			echo 'Not set';
		else
		{
			$guardianshipDurationWeeks=guardianshipDurationWeeks(normalToMysqlDate($data['from']),normalToMysqlDate($data['to']));
			echo $guardianshipDurationWeeks.' weeks';
		}
	}
	function saveaddressdetail(){
		$cd=$this->sha_model->getcountdata($_POST['id']);
		
		if($cd>0){
		$data=array('campus'=>$_POST['sub'],'college_address'=>$_POST['add'],'college'=>$_POST['college'],'college_group'=>$_POST['college_group']);
		$this->sha_model->saveaddressdetail($data,$_POST['id']);
		
		}else{
			$data=array('id'=>$_POST['id'],'campus'=>$_POST['sub'],'college_address'=>$_POST['add'],'college'=>$_POST['college'],'college_group'=>$_POST['college_group']);
			$this->db->insert("sha_three",$data);
		}
		$this->db->where('id',$_POST['id']);
		$this->db->update("sha_one",array('college'=>$_POST['cid']));
		echo 'done';
		
	}
	
		/**
     * Function for upload document 
     * @author Amit kumar
     */
		function sha_document_upload()
		{
			if($_FILES['file']['name']!= "")
				  {
						$path="./static/uploads/shadocument"; 
						$t1=time();
						$imagename=$t1.$_FILES['file']['name'];		
						move_uploaded_file($_FILES['file']['tmp_name'],$path.'/'.$imagename);
						
						$this->sha_model->sha_document_upload($_POST['clientId'],$imagename);
						$data['client']=$this->sha_model->shadocument($_POST['clientId']);
						//print_r($data);
						$this->load->view('system/sha/document_list',$data);
					}
		}
			/**
     * Function for delete document
     * @author Amit kumar
     */
     function deleteshadocument()
		{
			if(checkLogin())
			{
				if(isset($_POST['id']))
				{
					$this->sha_model->deleteshadocument($_POST['id']);
					echo "done";
				}
			}
			else
				echo "LO";
		}
		function savestudentnoinfo(){
			$data=$_POST;
		//	print_r($data);
			//if(!empty($data['sha_studentid'])){
				$tmp['sha_student_no']=$data['sha_studentid'];
				$this->db->where("id",$data['id']);
				$this->db->update("sha_one",$tmp);
				echo 1; exit;
				
			//}else{
				//echo 2; exit;
			
			
		}
		//}
		
		
		function printProfileDetails($id)
		{
			if(checkLogin())
			{
				$data['formOne']=getShaOneAppDetails($id);
				$data['formTwo']=getShaTwoAppDetails($id);
				$data['formThree']=getShaThreeAppDetails($id);
				$this->load->view('system/sha/printProfileDetails',$data);
			}
			else
			{
				echo "Please login to see content of this page";
			}
		}
		function allhfanote(){
			if(!empty($_POST['hid'])){
			$data['note']=$this->sha_model->notedetail($_POST['hid']);
			$this->load->view('system/sha/allnote',$data);
			}
		}
		
		function noteContent($id='', $notid=''){
	 $data['formOne']=$id;
		 
		
		 if($notid!=''){
			
			 $data['not']=$this->sha_model->getnoteinfo($notid);
			 
		 }
		 
		 $this->load->view('system/sha/notecontent',$data);
	 }
	 
	 function sha_notedocument_upload()
		{
			
		
			if($_FILES['file']['name']!= "")
				  {
						$path="./static/uploads/shanotedocument"; 
						$t1=time();
						$imagename=$t1.$_FILES['file']['name'];		
						move_uploaded_file($_FILES['file']['tmp_name'],$path.'/'.$imagename);
						$notid=$_POST['notesid'];
						$this->sha_model->sha_notedocument_upload($_POST['clientId'],$imagename,$notid);
						$data['not']=$this->sha_model->notedocumentDetail($_POST['clientId'],$notid);
						//print_r($data);
						$this->load->view('system/sha/notedocument_list',$data);
					}
					
		}
		function savenote(){
			
			$data=$_POST;
			$this->session->unset_userdata('notid');
			if($data['not_id']=='')
			{
				$not['note_title']=$_POST['note_title'];
				$not['notes_family']=$_POST['notes_family'];
				$not['sha_id']=$_POST['sha_id'];
				$not['employee']=$_POST['notes_emp'];
				$not['note_date']=normalToMysqlDate($_POST['notes_date']);
				$not['note_created']=date('Y-m-d H:i:s');
				$id=$this->sha_model->savenote($not);
			
				echo $id."-add";
			}else{
				$not['note_title']=$_POST['note_title'];
				$not['notes_family']=$_POST['notes_family'];
				$not['employee']=$_POST['notes_emp'];
				$not['note_date']=normalToMysqlDate($_POST['notes_date']);
				$id=$this->sha_model->editnote($not,$data['not_id']);
				
				echo $id."-edit";
			}
		
		}
		
		function deletenotedocument()
		{
			if(checkLogin())
			{
				if(isset($_POST['id']))
				{
					$this->sha_model->deletenotedocument($_POST['id']);
					echo "done";
				}
			}
			else
				echo "LO";
		}
		function notedocumentlist($id,$notid=''){
		 
		  if($notid!=''){
			
			 $data['not']=$this->sha_model->notedocumentDetail($id,$notid);
			  $this->load->view('system/sha/notedocument_list',$data);
		 }
		 
		 
	 }
	 function deletenote($id){
			$this->sha_model->deletenote($id);
		echo 1;
		exit;
			
	}
	function getnominatedinfo(){
		if(checkLogin())
			{
				$query=$this->db->get_where("hfa_one",array("id"=>$_POST['hid']));//echo $this->db->last_query();
				@$fname=$query->row()->fname;
				@$lname=$query->row()->lname;
				echo !empty($lname) ? @ucfirst(@$fname)." ".@$lname : 'notid';
				exit;
				
			}
			else{
				echo "LO";
		}
		
	}
	
	function bookingHistoryTabContent()
	{
		$id=$_POST['id'];
		$sortBy=$_POST['sortBy'];
		$data['booking_history']=$this->sha_model->booking_history($id,$sortBy);
		$this->load->view('system/sha/application_bookingHistory',$data);
	}
	
	function copyCancelled()
	{
		if(userAuthorisations('copyCancelledSha'))
		{
			$shaId=$_POST['shaId'];
			$this->load->model('booking_model');
			$newShaId=$this->booking_model->createShaCopy($shaId);
			$this->sha_model->copyCancelledRepair($newShaId);
			echo $newShaId;
		}
	}
	
	function getClientsDetailsDiv()
	{
		if(checkLogin())
			{
				$data=$_POST;
				$input['formOne']['client']=$data['client'];
				$this->load->view('system/sha/clientDetailsDiv',$input);
			}
			else
				echo "LO";
	}
}
