<?php
class Houses extends CI_Controller {

		function __construct()
		{
			parent::__construct();
			$this->load->model('share_house_model');
		}

		function index()
		{
			checkLoginRedirect();
			$status='share_house_all';
			//$status='share_house_new'; // temporary purpose to run the page
			$this->applicationByStatus($status);
		}

		function new_application()
		{
			checkLoginRedirect();
			$status='share_house_new';
			$this->applicationByStatus($status);
		}

		function pending_invoice()
		{
			checkLoginRedirect();
			$status='share_house_pending_invoice';
			$this->applicationByStatus($status);
		}
		function finalized()
		{
			checkLoginRedirect();
			$status='share_house_finalized';
			$this->applicationByStatus($status);
		}
		function payment_received()
		{
			checkLoginRedirect();
			$status='share_house_payment_received';
			$this->applicationByStatus($status);
		}
		function room_reserved()
		{
			checkLoginRedirect();
			$status='share_house_room_reserved';
			$this->applicationByStatus($status);
		}

		function approved_with_payment()
		{
			checkLoginRedirect();
			$status='share_house_approved_with_payment';
			$this->applicationByStatus($status);
		}

		function approved_without_payment()
		{
			checkLoginRedirect();
			$status='share_house_approved_without_payment';
			$this->applicationByStatus($status);
		}

		function rejected()
		{
			checkLoginRedirect();
			$status='share_house_rejected';
			$this->applicationByStatus($status);
		}

		function cancelled()
		{
			checkLoginRedirect();
			$status='share_house_cancelled';
			$this->applicationByStatus($status);
		}

		function applicationByStatus($status)
		{
			$data['page']='share_house_new';
			//$data['page']=$status;
			$data['house_status_page']=$status;
			//see($data['list']);
			$this->load->view('system/header',$data);
			$this->load->view('system/share_house/list');
			$this->load->view('system/footer');
		}

		function application_edit_one_submit()
		{

			checkLoginRedirect();
			
			$data=$_POST;
			
			if($data['email']!='')
			{
				$id=$this->share_house_model->update_share_house($data);
				echo "done";
			}
		}
		function changeStatusCancelPopContent($id,$pageStatus)
		{
			 $getHfaOneAppDetails=getShaOneAppDetails($id);
			 $getHfaOneAppDetails['pageStatus']=$pageStatus;
			 $this->load->view('system/share_house/changeStatusCancelForm',$getHfaOneAppDetails);
		}


		function changeStatusPopContent($id,$pageStatus)
		{
			$getHfaOneAppDetails=getshareHouseDetail($id);
			$getHfaOneAppDetails['pageStatus']=$pageStatus;
			$this->load->view('system/share_house/changeStatusForm',$getHfaOneAppDetails);
		}

		function changeStatus()
		{
			$data=$_POST;
			if($data['id']!='')
			{
				$this->share_house_model->changeStatus($data);
				echo 'done';
			}
		}

		function sendEmailHalfApplicationShaPopContent($id)
		{
			$getHfaOneAppDetails=getShaOneAppDetails($id);
			$this->load->view('system/houses/sendAppCompletionEmailForm',$getHfaOneAppDetails);
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

			  $this->email->subject('Complete your Share House Application');
			  $to =  $_POST['shaEmail'];
			  $this->email->to($to);
			  //$this->email->to('tejpal@evomorf.com');
			  $emailData['name']=$getShaOneAppDetails['fname'];

			  $link=codeEncode($id);
			  $link=site_url().'form/student_homestay_application_two/'.$link;
			  $emailData['link']=$link;

			  $email_msg_user=$this->load->view('form/emails/houses',$emailData,true);
			  $this->email->message($email_msg_user);

			  $this->email->send();
		}

		function deleteApplication()
		{
			if(isset($_POST['id']))
			{
				$this->share_house_model->deleteApplication($_POST['id']);
				echo "done";
			}
		}

		function profile($id)
		{
			checkLoginRedirect();
			$getshareHouseDetail=getshareHouseDetail($id);
			if(empty($getshareHouseDetail))
				header('location:'.site_url().'houses/new_application');
			$data['page']='house_application';
			$data['formOne']=getshareHouseDetail($id);
			//$data['formTwo']=getShaTwoAppDetails($id);
			//$data['formThree']=getShaThreeAppDetails($id);
			//$data['photos']=$this->share_house_model->photos($id);
			//see($data);
			$this->load->view('system/header',$data);
			$this->load->view('system/share_house/profile');
			$this->load->view('system/footer');
		}

		function application_edit_one($id)
		{
			checkLoginRedirect();
			$data['pageTitle']=houseTitle();
			$data['formOne']=getshareHouseDetail($id);
			$this->load->view('header',$data);
			$this->load->view('system/share_house/application_edit-1');
			$this->load->view('footer');
		}

		function frm_share_house_submit()
		{
			checkLoginRedirect();
			$data=$_POST;
			//see($data);exit;
			if($data['email']!='')
			{
				$id=$this->share_house_model->insert_share_house($data);
				echo $id;
			}
		}

		function application_edit_two($id)
		{
			checkLoginRedirect();
			$data['pageTitle']=shaTitle();
			$data['formOne']=getShaOneAppDetails($id);
			$data['formTwo']=getShaTwoAppDetails($id);
			//see($data);
			$this->load->view('header',$data);
			$this->load->view('system/houses/application_edit-2');
			$this->load->view('footer');
		}

		function application_edit_two_submit()
		{
			checkLoginRedirect();
			$data=$_POST;
			//see($data);
			if($data['id']!='')
			{
				$this->share_house_model->application_edit_two_submit($data);
				echo 'done';
			}
		}

		function application_edit_three($id)
		{
			checkLoginRedirect();
			$data['pageTitle']=shaTitle();
			$data['formOne']=getShaOneAppDetails($id);
			$data['formThree']=getShaThreeAppDetails($id);
			//see($data);
			$this->load->view('header',$data);
			$this->load->view('system/houses/application_edit-3');
			$this->load->view('footer');
		}

		function application_edit_three_submit()
		{
			checkLoginRedirect();
			$data=$_POST;
			//see($data);
			if($data['id']!='')
			{
				$this->share_house_model->application_edit_three_submit($data);
				echo 'done';
			}
		}

		function application_image_upload()
		{
			if($_FILES['file']['name']!= "")
		  	{
				$path="./static/uploads/houses/photos";
				$t1=time();
				$imagename=$t1.$_FILES['file']['name'];
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

				$this->share_house_model->application_image_upload_insert($_POST['appId'],$imagename);
		  	}
		}

		function appPagePhotosBoxRefresh()
		{
			if($_POST['id']!='')
			{
				$id=$_POST['id'];
				$data['photos']=$this->share_house_model->photos($id);
				$this->load->view('system/houses/application_photos_list',$data);
			}
		}

		function application_create()
		{
			checkLoginRedirect();
			$data['pageTitle']=shaTitle();
			$this->load->view('header',$data);
			$this->load->view('system/share_house/application_create');
			$this->load->view('footer');
		}

		function officeUseChangeAttrFormSubmit()
		{
			if(checkLogin())
			{
				$this->load->model('share_house_model');
				$this->share_house_model->officeUseChangeAttrFormSubmit($_POST);
				echo "Done";
			}
			else
				echo "LO";
		}

		function officeUseChangeAttrFormSubmit_changeClient()
		{
			if(checkLogin())
			{
				$this->load->model('share_house_model');
				$this->share_house_model->officeUseChangeAttrFormSubmit_changeClient($_POST);
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
			$this->load->view('system/houses/filterMatches',$data);
		}

		////////////// For data table server side STARTS
	public function ajax_list()
	{
		$list = $this->share_house_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		//$no = 0;

		$accomodationTypeList=houseTypeList();
		$houseStatusList=sharedHousesStatusList();
		foreach ($list as $student) {
			$row = array();
			//$step=shaAppCheckStep($student->id);
			//$step=$student->step;
			$house_status_page=$_POST['house_status_page'];

			//1st Column: STUDENT #STATRS
			//$row1='<a href="'.site_url().'houses/application/'.$student->id.'" target="_blank">'.ucwords($student->first_name.' '.$student->last_name).'</a>';
			$row1='<a href="'.site_url().'houses/profile/'.$student->id.'" target="_blank">'.ucwords($student->first_name.' '.$student->last_name).'</a>';
            if(!empty($student->email)) {
            	$row1 .='<br />';
            	$row1 .=$student->email;
            }
			if(!empty($student->mobile)) {
	            $row1 .='<br />';
	            $row1 .=$student->mobile;
	        }
			//1st Column: STUDENT #ENDS
			$row[]=$row1;


			//2nd Column: ACCOMODATION TYPE #STATRS
			$row2=$accomodationTypeList[$student->service_type];
			$row[]=$row2;


			//3rd Column: SUBMITTED #STATRS
			$row3=date('j M Y',strtotime($student->created));
			//3rd Column: SUBMITTED #ENDS
			$row[]=$row3;

			
			

			$row4='';
			$row4 .='<button class="mt-n mb-xs btn btn-sm btn-label" data-toggle="modal" data-target="#model_ChangeStatusSha"  onclick="sharedHousesChangeStatusPopContent('.$student->id.',\''.$student->status.'\');" id="changeStatusHfaEditBtn-'.$student->id.'">';
            $row4 .='<i class="material-icons font14">edit</i><span> ';
            if($house_status_page=='share_house_all')
            {
				$row4 .=$houseStatusList[$student->status];
            }
            else 
            {
            	$row4 .="Change";
            }
			
			$row4 .='</span>';
			$row4 .='</button>';
			
			if(!empty($student->status_update_date) && ($student->status_update_date !='0000-00-00 00:00:00'))
				
			{
				$row4 .='<br /><span class="statusChangeDate" data-placement="bottom" data-toggle="tooltip" data-original-title="Status change date">'.date('j M Y',strtotime($student->status_update_date)).'</span>';
			}
			$row[]=$row4;

			
			$row5=$houseStatusList[$student->status];
			$row[]='';

			//4th Column: ACTIONS #STARTS
			 $row6='Actions';
			//4th Column: ACTIONS #ENDS


			$row6='<div class="btn-group dropdown table-actions">';
                 $row6 .='<button class="btn btn-sm btn-midnightblue dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="true">';
                $row6 .='<i class="colorBlue material-icons">more_horiz</i>';
                $row6 .='<div class="ripple-container"></div>';
            $row6 .='</button>';
            $row6 .='<ul class="dropdown-menu" role="menu">';
                $row6 .='<li>';
                $row6 .='<a href="'.site_url().'houses/application_edit_one/'.$student->id.'"><i class="font16 material-icons">edit</i>&nbsp;&nbsp;Edit</a>';
                $row6 .='</li>';
                $row6 .='<li>';
                $row6 .='<a href="javascript:;" class="houseDeleteApp" id="houseDeleteApp-'.$student->id.'"><i class="font16 material-icons">delete</i>&nbsp;&nbsp;Delete</a>';
                $row6 .='</li>';

                if($house_status_page=='share_house_new'){
                    //$row6 .='<li>';
                    //$row6 .='<a href="javascript:void(0);" data-toggle="modal" data-target="#model_sendCompletionEmail" onclick="sendEmailHalfApplicationShaPopContent('.$student->id.')" id="sendEmailHalfApplicationSha-'.$student->id.'"><i class="font16 material-icons">email</i>&nbsp;&nbsp;Email completion link</a>';
                    //$row6 .='</li>';
                 }

            $row6 .='</ul>';
            $row6 .='</div>';



			$row[]=$row6;

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->share_house_model->count_all(),
						"recordsFiltered" => $this->share_house_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	////////////// For data table server side ENDS


	function filters_share_houses()
	{
		$this->load->view('system/share_house/filters_share_houses');
	}

	function active_houses()
	{
		checkLoginRedirect();
		$data['page']='active_students';

		//$data['sha_status_page']=$status;
		//see($data['list']);
		$this->load->view('system/header',$data);
		$this->load->view('system/share_house/active_students');
		$this->load->view('system/footer');
	}

	function bookingDatesSubmit()
	{
		$data=$_POST;
		if(strtotime(normalToMysqlDate($data['shaBooking_endDate']))<=strtotime(normalToMysqlDate($data['shaBooking_startDate'])))
			echo "wrongDates";
		else
			$this->share_house_model->bookingDatesSubmit($data);
	}

	function notesSubmit()
	{
		if(checkLogin())
			{
				$data=$_POST;
				if(isset($data['special_request_notes']))
					$this->share_house_model->notesSubmit($data);
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
					$this->share_house_model->homestayNominationSubmit($data);
			}
			else
				echo "LO";
	}

	function filters()
		{
			 $this->load->view('system/houses/filters');
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
	
	function test($id)
	{
		$this->load->model('invoice_model');
		$this->load->helper('product');
		$invoice=$this->invoice_model->initialInvoiceBefore($id);
		see($invoice);
	}
}
