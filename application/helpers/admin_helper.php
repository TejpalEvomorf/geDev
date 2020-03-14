<?php

function redirectToLogin()
{
		header("location:".site_url().'admin');
}

function checkLoginRedirect()
{
	if(!checkLogin())
		header("location:".site_url().'admin');
}

function checkLogin()
{
	$obj= &get_instance();
	if($obj->session->has_userdata('user_id'))
		return true;
	else
		return false;
}

function loggedInUser()
{
	if(checkLogin())
	{
		$obj= &get_instance();
		$user_id=$obj->session->userdata("user_id");
		$obj->load->model('admin_model');
		$user=$obj->admin_model->loggedInUser($user_id);
		return $user;
	}
}

function getLoggedInUserType()
{
	$obj= &get_instance();
	return $obj->session->userdata("user_type");
}

function userTasks()
{//1:Admin's account; 33: Stone's account, 32:Agnes
	$adminAccounts=[1,33,32];
	return array(
				'hfa_callLog_delete'=>array(1,33),
				'hfa_visitReport_delete'=>$adminAccounts,
				'hfa_visitReport_editDate'=>$adminAccounts,
				'latest_po_delete'=>array(1,33),
				'latest_ongInv_delete'=>array(1,33),
				'randomTask'=>array('admin','employee'),
				'adminTask'=>array('admin'),
				'employeeTask'=>array('employee'),
				'bookingFeedback_delete'=>$adminAccounts,
				'copyCancelledSha'=>$adminAccounts,
				'hfaTransportInfo_delete'=>$adminAccounts,
				'bookingHoliday_delete'=>$adminAccounts,
				'hfaWarning_delete'=>$adminAccounts,
				'bookingCGDocSent_unsend'=>$adminAccounts,
				'booking_duration_report'=>$adminAccounts,
				'triple_share_booking'=>$adminAccounts,
				'bookingHoldPayment_delete'=>$adminAccounts,
				'bookingCheckup_delete'=>$adminAccounts,
				'poDuedate_update'=>array(1,33)
			);
}

function userAuthorisations($task)
{
	$result=false;
	if(checkLogin())
	{
		$obj= &get_instance();
		$user_id=$obj->session->userdata("user_id");
		$obj->load->model('admin_model');
		$loggedInUser=$obj->admin_model->loggedInUser($user_id);
		
		if($loggedInUser['user_type']==1)
			$loggedInUser['type']="admin";
		elseif($loggedInUser['user_type']==2)
			$loggedInUser['type']="employee";
			
		$userTasks=userTasks();
		$usersAllowed=$userTasks[$task];
		if(in_array($loggedInUser['type'],$usersAllowed) || in_array($loggedInUser['user_id'],$usersAllowed))
			$result=true;
	}
	
	return $result;
}

function emailSendingProfile($emailType)
{//1:Admin's account; 33: Stone's account, 32:Agnes
	$profiles=[
	'plInsExpiry'=>'32',
	'wwccExpiry'=>'32',
	];
	
	$user_id=$profiles[$emailType];
	$obj= &get_instance();
	$obj->load->model('admin_model');
	$user=$obj->admin_model->loggedInUser($user_id);
	//see($profiles);
	//see($user);
	return $user;
}

function pageTitleS($page='')
{
	$pageTitleKey=array(
		'invoiceInitial'=>'Initial invoice',
		'groupInvoiceInitial'=>'Group Invoice',
		'invoiceOngoing'=>'Ongoing invoice',
		'invoice'=>'Invoice data',
		'all_students'=>'Manage Applications',
		'pending_students'=>'Pending Students',
		'palced_students'=>'Placed Students',		
		'sha'=>'Student homestay application',
		'sha_application'=>'Student profile',
		'dashboard'=>'Dashboard',
		'account'=>'Account',
		'bookings'=>'Bookings',
		'hfa'=>'Host family application',
		'hfa_application'=>'Host family profile',
		'tour'=>'Tour group list',
		'create_tour'=>'Add new tour group',
		'edit_tour'=>'Manage tour',
		'po'=>'Purchase orders',
		'poDetails'=>'Purchase order details',
		'client'=>'Client list',
		'create_client'=>'Add new client',
		'guardian'=>'Caregiver list',
		'create_guardian'=>'Add new Caregiver',
		'apu_company'=>'APU company list',
		'create_apu_company'=>'Add new APU company',
		'prices'=>'Pricing',
		'bookings-view'=>'View Booking',
		'bookings-changeHomestay'=>'Change homestay',
		'Search All'=>'Search All',
		'caregiver_company_list'=>'Caregiver companies list',
		'caregiver_create_company'=>'Add new caregiver company',
		'caregiver_edit_company'=>'Edit caregiver company',
		'caregiver_manage'=>'Manage caregivers',
		'Hfa-visitReports'=>'Homestay visit report',
		'reports-hfa'=>'Host family report',
		'reports-college_auditing'=>'College auditing report',
		'reports-tour_groups'=>'Tour groups report',
		'reports-revisits'=>'Revisits report',
		'reports-incidents'=>'Incidents report',
		'reports-bookings'=>'Bookings report',
		'reports-wwcc'=>'WWCC report',
		'reports-insurance'=>'Insurance report',
		'reports-feedback'=>'Feedback report',
		'reports-booking_duration'=>'Booking duration report',
		'reports-parent_nominated_homestay'=>'Parents nominated homestay report',
		'reports-caregiving_service'=>'Caregiving service report',
		'reports-invoice'=>'Invoice report',
		'reports-booking_allocation'=>'Booking allocation report',
		'reports-profit'=>'Profit report',
		'reports-bookings_regularCheckup'=>'Booking regular checkups report',
		'reports-bookings_holidayCheckup'=>'Holiday check-up',
		'reports-clients_report'=>'Clients Report',
		'reports-training_event'=>'Training Event',
		'reports-booking_comparison'=>'Booking Comparison'
	);
	
	$pageTitle='';
	if($page!='')
		$pageTitle=$pageTitleKey[$page].' - ';
	$pageTitle .='Global experience management system';
	return $pageTitle;
}

function hfaStatusList()
{
	return array(
		'new'=>'New',
		'no_response'=>'No response',
		'confirmed'=>'Confirmed',
		'pending_approval'=>'Pending approval',
		'approved'=>'Approved',
		'do_not_use'=>'Do not use',
		'unavailable'=>'Unavailable'
	);
}
function bookingSortList()
{
	return array(
		'studentnamea'=>'Student name (A-Z)',
		'studentnamez'=>'Student name (Z-A)',
		'hostfamilya'=>'Host Family last name (A-Z)',
		'hostfamilyz'=>'Host Family last name (Z-A)',
		'arrivaldate'=>'Arrival date'
	);
}

function sharedHousesStatusList()
{
	return array(
		'share_house_new'=>'New',
		//'share_house_all'=>'All',
		'share_house_pending_invoice'=>'Pending invoice',
		//'share_house_approved_with_payment'=>'Approved with payment',
		'share_house_room_reserved'=>'Reserved',
		'share_house_finalized'=>'Finalized',
		'share_house_payment_received'=>'Payment Received',
		'share_house_rejected'=>'Rejected',
		'share_house_cancelled'=>'Cancelled'/*,
		'share_house_active_students'=>'Active students'*/
	);
}
function shaStatusList()
{
	return array(
		'new'=>'New',
		'pending_invoice'=>'Pending invoice',
		//'approved_with_payment'=>'Approved with payment',
		'approved_with_payment'=>'Approved paid',
		//'approved_without_payment'=>'Approved without payment',
		'approved_without_payment'=>'Approved unpaid',
		'rejected'=>'Rejected',
		'cancelled'=>'Cancelled'/*,
		'active_students'=>'Active students'*/
	);
}

function ifHfaRescheduled($id)
{
	$obj=& get_instance();
	$obj->load->model('hfa_model');
	return $obj->hfa_model->ifHfaRescheduled($id);
}

function applicationCountByStatus($status,$type)
{
	$model=$type.'_model';
	$obj=& get_instance();
	$obj->load->model($model);
	$app=$obj->$model->applicationsList($status);
	return count($app);
}

function do_not_useOptions()
{
	return array(
		'distance'=>'Distance',
		'availability'=>'Availability',
		'brisbane_family'=>'Brisbane family',
		'other_states'=>'Other states',
		'not_suitable'=>'Not suitable',
		'other'=>'Other'
	);
}

function hfaDnuReason($id)
{
	$obj=& get_instance();
	$obj->load->model('hfa_model');
	$reason=$obj->hfa_model->hfaDnuReason($id);
	return $reason;
}

function getplstatus($id)
{
	$obj=& get_instance();
	$obj->load->model('hfa_model');
	$plstatus=$obj->hfa_model->plstatusvalue($id);
	return $plstatus;
}
function getwwstatus($id)
{
	$obj=& get_instance();
	$obj->load->model('hfa_model');
	$wwstatus=$obj->hfa_model->wwstatusvalue($id);
	return $wwstatus;
}

function hfaDocs($id)
{
	$obj=& get_instance();
	$obj->load->model('hfa_model');
	$docs=$obj->hfa_model->docsUploaded($id);
	return $docs;
}

function hfaPhotos($id)
{
	$obj=& get_instance();
	$obj->load->model('hfa_model');
	$docs=$obj->hfa_model->photos($id);
	return $docs;
}

function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale)
{
		  list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		  $imageType = image_type_to_mime_type($imageType);

		  $newImageWidth = $scale['width'];
		  $newImageHeight =$scale['height'];
		  $newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);

		  switch($imageType) {
			  case "image/gif":
				  $source=imagecreatefromgif($image);
				  break;
			  case "image/pjpeg":
			  case "image/jpeg":
			  case "image/jpg":
				  $source=imagecreatefromjpeg($image);
				  break;
			  case "image/png":
			  case "image/x-png":
				  $source=imagecreatefrompng($image);
				  break;
		  }

		  imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
		 // imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,500,500);

		  switch($imageType) {
			  case "image/gif":
				  imagegif($newImage,$thumb_image_name);
				  break;
			  case "image/pjpeg":
			  case "image/jpeg":
			  case "image/jpg":
				  imagejpeg($newImage,$thumb_image_name,90);
				  break;
			  case "image/png":
			  case "image/x-png":
				  imagepng($newImage,$thumb_image_name);
				  break;
		  }
		  chmod($thumb_image_name, 0777);
		  return $thumb_image_name;
}

function hfaShaProfilePic($id,$hfaSha)
{
	$obj=& get_instance();
	$obj->load->model('admin_model');
	$docs=$obj->admin_model->hfaShaProfilePic($id,$hfaSha);
	return $docs;
}

function hfaShaProfilePicLatest($id,$hfaSha)
{
	$obj=& get_instance();
	$obj->load->model('admin_model');
	$docs=$obj->admin_model->hfaShaProfilePicLatest($id,$hfaSha);
	return $docs;
}

function clientCategories()
{
	return array(
		'1'=>'Default',
		'2'=>'Agent',
		'3'=>'College',
		'4'=>'University'
	);
}

function employeeDesignationList()
{
	return array(
		'1'=>'Managing Director',
		'2'=>'Business Development Manager',
		'3'=>'Relationship and Sales Manager',
		'4'=>'Account Manager',
		'5'=>'Liaison Manager',
		'6'=>'Homestay Coordinator',
		'7'=>'Marketing Assistant',
		'8'=>'Chief Financial Officer',
		'9'=>'Caregiver Coordinator'
	);
}

function cropImageFromSides($large_image_location,$thumb_image_location,$width,$height)
{
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

		resizeThumbnailImage($thumb_image_location, $large_image_location,$x2,$y2,$x1,$y1,array('width'=>$width,'height'=>$height));
}

function getFileTypeIcon($file)
{
	$array=explode('.',$file);
	$ext=$array[1];
	if($ext=='pdf')
		$class='fa-file-pdf-o';
	elseif($ext=='docx')
		$class='fa-file-word-o';
	elseif($ext=='xlsx')
		$class='fa-file-excel-o';
	elseif($ext=='jpeg' || $ext=='jpg' || $ext=='png')
		$class='fa-file-image-o';
	elseif($ext=='msg')
		$class='fa-envelope';
	else
		$class='fa-file';
	return '<i class="fa '.$class.'"></i>';
}

function randStrGen($len){
    $result = "";
    $chars = 'abcdefghijklmnopqrstuvwxyz$#@%&*_.?!0123456789';
    $charArray = str_split($chars);
    for($i = 0; $i < $len; $i++){
	    $randItem = array_rand($charArray);
	    $result .= "".$charArray[$randItem];
    }
    return $result;
}

function clientsList()
{
	$obj=& get_instance();
	$obj->load->model('client_model');
	$clientsfull=$obj->client_model->clientsList();

	return $clientsfull;
}
function clientsListshause()
{
	$obj=& get_instance();
	$obj->load->model('client_model');
	$clientsfull=$obj->client_model->clientsListshause();

	return $clientsfull;
}

function clientDetail($id)
{
	$obj=& get_instance();
	$obj->load->model('client_model');
	$clientsfull=$obj->client_model->clientDetail($id);

	return $clientsfull;
}
function collegeDetail($id)
{
	$obj=& get_instance();
	$obj->load->model('client_model');
	$clientsfull=$obj->client_model->collegeDetail($id);

	return $clientsfull;
}

function officeList()
{
	return array(
	'sydney'=>'Sydney',
	'melbourne'=>'Melbourne',
	'both'=>'Both'
	);
}

function employeeList()
{
	$obj=& get_instance();
	$obj->load->model('account_model');
	$empfull=$obj->account_model->employeeList();

	return $empfull;
}

function employee_details($id)
{
	$obj=& get_instance();
	$obj->load->model('account_model');
	$empfull=$obj->account_model->employee_details($id);

	return $empfull;
}

function otherEmployeesSameOffice($id,$office)
{
	$employeeListAll=employeeList();
	$employeeList=array();
	foreach($employeeListAll as $eLK=>$eLV)
	  {
		  if($eLV['id']!=$id && $eLV['office']==$office)
			$employeeList[]=$eLV;
	  }
	  return $employeeList;
}

function loadingImagePath()
{
	return static_url().'system/img/loading-filters.gif';
}

function passEncrypt($pass)
{
	return base64_encode($pass);
}

function passDecrypt($hash)
{
	return base64_decode($hash);
}

function hfaUnavailable($id)
{
	$obj=& get_instance();
	$obj->load->model('hfa_model');
	$reason=$obj->hfa_model->hfaUnavailable($id);
	return $reason;
}

function matchedAppStatusList()
{
	return array(
	'1'=>'To be reviewed',
	'2'=>'Shortlisted',
	'3'=>'Rejected'
	);
}

function shaMatchStatus($student,$host)
{
	$obj=& get_instance();
	$obj->load->model('sha_matches_model');
	$status=$obj->sha_matches_model->shaMatchStatus($student,$host);
	return $status;
}

function bookingStatusList()
{
	return array(
	'expected_arrival'=>'Expected arrival',
	'arrived'=>'Arrived',
	'progressive'=>'Progressive',
	'moved_out'=>'Moved out',
	'on_hold'=>'On hold',
	'cancelled'=>'Cancelled',
	);
}

function roomDetails($id)
{
	$obj=& get_instance();
	$obj->load->model('booking_model');
	return $obj->booking_model->roomDetails($id);
}

function bookingDetails($id)
{
	$obj=& get_instance();
	$obj->load->model('booking_model');
	return $obj->booking_model->bookingDetails($id);
}

function checkIfBedBooked($bed,$studentAcc,$dates)
{//see($bed);see($studentAcc);see($dates);
	$obj=& get_instance();
	$obj->load->model('booking_model');
	return $obj->booking_model->checkIfBedBooked($bed,$studentAcc,$dates);
}

function checkIfBedBookedExtraSql($dates)
{
	$sql='';
	if($dates['from']!='')
		{
			if($dates['to']=='')
			{
				$sql	.=" and (";
				$sql	.=" (`booking_from`>='".$dates['from']."')";
				$sql	.=" OR (`booking_from`<'".$dates['from']."' and (`booking_to`>'".$dates['from']."' OR `booking_to`='0000-00-00'))";
				$sql	.=" OR (`booking_to`>='".$dates['from']."')";
				$sql	.=" OR (`booking_to`='0000-00-00')";
				$sql	.=")";
			}
			else
			{
				$sql	.=" and (";
				$sql .="(`booking_from` between '".$dates['from']."' and '".$dates['to']."')";
				$sql .=" OR (`booking_to` between '".$dates['from']."' and '".$dates['to']."')";
				$sql .=" OR ('".$dates['from']."' between `booking_from` and `booking_to`)";
				$sql .=" OR ( `booking_from`='".$dates['from']."' OR `booking_from`='".$dates['to']."' OR `booking_to`='".$dates['from']."' OR `booking_to`='".$dates['to']."')";
				$sql	.=" OR (`booking_to`='0000-00-00')";
				$sql	.=")";
			}
		}
	return $sql;	
}

function bookingCountByStatus($status)
{
	$model='booking_model';
	$obj=& get_instance();
	$obj->load->model($model);
	$app=$obj->$model->bookingCountByStatus($status);
	return $app;
}

function checkIfStudentPlaced($student)
{
	$obj=& get_instance();
	$obj->load->model('booking_model');
	$app=$obj->booking_model->checkIfStudentPlaced($student);
	return $app;
}

function roomTypeByAccomodationType($accType)
{
	$roomType=array(
	'1'=>array(1,3,4),
	'2'=>array(2,3,4),
	'3'=>array(1,3,4),
	'4'=>array(1),
	'5'=>array(1)
	);

	return $roomType[$accType];
}

function roomTypeByAccomodationTypeDesc($roomType,$accType)
{
	$desc='';
	if(!empty($roomType) && $accType!='')
	{
		  $roomTypeList=roomTypeList();

		  $desc='Showing host families that have ';
		  foreach($roomType as $rtK=>$rt)
		  {
			  if($rtK>0)
				  $desc .=",";
			  $desc .=" ".$roomTypeList[$rt];
			  if($accType==4 || $accType==5)
				  $desc .=" VIP";
		  }
		  $desc .=" rooms available";

		  $desc_selfCatered="self catered provision";
		  if($accType==3)
			  $desc .=" with ".$desc_selfCatered;
		  /*if($accType==4 || $accType==5)
			  $desc .=" with an internal ensuit";*/
		  if($accType==5)
		  {
			  //$desc .=" and ".$desc_selfCatered;
			  $desc .=" with ".$desc_selfCatered;
		  }
		  $desc .=".";
	}
	return $desc ;
}

function initialInvoiceStatusList()
{
	return array(
		'1'=>'Pending',
		'2'=>'Partial',
		'3'=>'Paid'
	);
}

function bookingByShaId($id)
{
	$obj= &get_instance();
	$obj->load->model("booking_model");
	$booking=$obj->booking_model->bookingByShaId($id);
	return $booking;
}

function initialInvoiceUnmovedCount()
	{
			$obj= &get_instance();
			$obj->load->model("invoice_model");
			$intialInvoice=$obj->invoice_model->initialInvoiceUnmovedCount();
			return $intialInvoice;
	}

function tourDetail($id)
{
		  $obj= &get_instance();
		  $obj->load->model("tour_model");
		  $tour=$obj->tour_model->tourDetail($id);
		  return $tour;
}

function studyTourInitialInvoiceItems($id)
{
		$obj= &get_instance();
		$obj->load->model('sha_model');
		$obj->load->model('invoice_model');
		$obj->load->helper('product');
		$students=$obj->sha_model->getStudentsByTourIdForInvoice($id);
		foreach($students as $student)
		{
			if($student['booking_from']=='0000-00-00' || $student['booking_to']=='0000-00-00')
				continue;
			$inv=$obj->invoice_model->initialInvoiceBefore($student['id']);
			$inv['student']=$student['fname'].' '.$student['lname'];
			$inv['student_id']=$student['id'];
			
			$invoice[]=$inv;
		}
		return $invoice;
}

function studyTourInitialInvoiceItemsUpdate($id,$from,$to)
{
		$obj= &get_instance();
		$obj->load->model('sha_model');
		$obj->load->model('invoice_model');
		$obj->load->helper('product');
		$students=$obj->sha_model->getPendingStudentsByTourId($id);
		foreach($students as $student)
		{
			if($student['booking_from']=='0000-00-00' || $student['booking_to']=='0000-00-00')
				continue;
			$inv=$obj->invoice_model->initialInvoiceBeforeUpdate($student['id'],$from,$to);
			$inv['student']=$student['fname'].' '.$student['lname'];
			$inv['student_id']=$student['id'];
			
			$invoice[]=$inv;
		}
		return $invoice;
}

function ongoingInvoiceUnmovedCount()
	{
			$obj= &get_instance();
			$obj->load->model("invoice_model");
			$intialInvoice=$obj->invoice_model->ongoingInvoiceUnmovedCount();
			return $intialInvoice;
	}
	
function shaInitialInvoiceWeekDays($id)
{
			$obj= &get_instance();
			$obj->load->helper('product');
			$initialInvoice=initialInvoiceByShaId($id);
			$initialInvoiceDetails=initialInvoiceDetails($initialInvoice['id']);
			
			$days=0;
			if(!empty($initialInvoiceDetails))
			{
				foreach($initialInvoiceDetails['items'] as $item)
				{
					if($item['type']=='accomodation')
						$days +=$item['qty']*7;
					
					if($item['type']=='accomodation_ed')
						$days +=$item['qty'];
				}
			}
			return $days;
}

function tourInitialInvoiceWeekDays($tour_id,$student_id)
{
			$obj= &get_instance();
			$obj->load->helper('product');
			$initialInvoice=initialInvoiceByTourId($tour_id);
			$initialInvoiceDetails=initialInvoiceDetails($initialInvoice['id']);
			
			$days=0;
			if(!empty($initialInvoiceDetails))
			{
				foreach($initialInvoiceDetails['items'] as $item)
				{
					if($item['application_id']==$student_id)
					{
						if($item['type']=='accomodation')
							$days +=$item['qty']*7;
						
						if($item['type']=='accomodation_ed')
							$days +=$item['qty'];
					}
				}
			}
			return $days;
}

function shaOngoingInvoiceWeekDays($id)
{
			$obj= &get_instance();
			$obj->load->helper('product');
			$initialInvoiceDetails=ongoingInvoiceDetails($id);
			
			$days=0;
			if(!empty($initialInvoiceDetails))
			{
				foreach($initialInvoiceDetails['items'] as $item)
				{
					if($item['type']=='accomodation')
						$days +=$item['qty']*7;
					
					if($item['type']=='accomodation_ed')
						$days +=$item['qty'];
				}
			}
			return $days;
}

function plInsStatusText($formThree)
{
	$insurance=$formThree['insurance'];
	if($insurance=="0")
		$return='<p class="text-danger"><b>Not available</b></p>';
	elseif($insurance=="1"){
		if(($formThree['ins_expiry']!='0000-00-00') && strtotime($formThree['ins_expiry'])<strtotime(date('Y-m-d')))
				$return='<p class="colorOrange"><b>Expired</b></p>';	
		else
			$return='<p class="text-success"><b>Available</b></p>';	
	}else
		$return='<p class="text-info"><b>No info provided</b></p>';
	return $return;	
}

function guardianList()
{
	$obj= &get_instance();
	$obj->load->model('guardian_model');
	$guardianList=$obj->guardian_model->guardianList();
	return $guardianList;
}

function getTourWarnings($type,$ids)
{
	$obj= &get_instance();
	$obj->load->model('tour_model');
	$warnings=$obj->tour_model->getTourWarnings($type,$ids);
	return $warnings;
}

function tourWarningsLabel()
{
	$warnings = array();
	$warnings['dob']="Date of Birth";
	$warnings['booking_from']="Booking From Date";
	$warnings['booking_to']="Booking To Date";
	$warnings['email']="Email";
	$warnings['nation']="Nationality";
	$warnings['guardianship_date']="Caregiving duration";
	
	return $warnings;
}

function guardianshipDurationOfficeUsePage($from,$to)
{
	$weeks='Not set';
	if(!in_array($from,array('','0000-00-00')))
	{
		$guardianshipDurationWeeks=guardianshipDurationWeeks($from,$to);
		$weeks=$guardianshipDurationWeeks.' weeks';
	}
	return 'Caregiving duration: '.$weeks;
}

function guardianshipDurationWeeks($from,$to)
{
		$dayDiff=dayDiff($from,$to)-1;
		$weeks=($dayDiff/7);
		return ceil($weeks);
}

function adjustPlacementFee_shaInitialInvoice($invoice,$studentId)
{
	$student=getShaOneAppDetails($studentId);
	if(!empty($student))
	{
		$clientDetail=clientDetail($student['client']);
		if($clientDetail['commission']==1)
		{
			$year=date('Y');
			if($clientDetail['category']==2 && $clientDetail['commission']=='1')
			{
				$checkIfClientHasAgreement=checkIfClientHasAgreement($student['client'],$year);
				if($checkIfClientHasAgreement)
				{
					if(isset($invoice['standard']['placement_fee']))
					{	
						$invoice['standard']['placement_fee']['unit']=$invoice['placement_fee']['unit']+$clientDetail['commission_val'];
						$invoice['standard']['placement_fee']['total']=$invoice['standard']['placement_fee']['unit']*$invoice['standard']['placement_fee']['qty'];
					}
				}
				else
				{
					if(isset($invoice['placement_fee']))
					{
						$invoice['placement_fee']['unit']=$invoice['placement_fee']['unit']-$clientDetail['commission_val'];
						$invoice['placement_fee']['total']=$invoice['placement_fee']['unit']*$invoice['placement_fee']['qty'];
					}
				}
			}
		}
	}
	//see($invoice);
	return $invoice;
}


function getShaIdByNameNTourId($name,$tour_id)
  {
	  $obj= &get_instance();
	  $obj->load->model('tour_model');
	  $obj->tour_model->getShaIdByNameNTourId($name,$tour_id);
  }
  
 function apuCompanyList()
 {
	 $obj= &get_instance();
	 $obj->load->model('apu_company_model');
	 return $obj->apu_company_model->apuCompanyList();
 }

  function apuCompanyDetail($id)
  {
	 $obj= &get_instance();
	 $obj->load->model('apu_company_model');
	 return $obj->apu_company_model->apuCompanyDetail($id);
  }
  
  function getStudentNameFromInvoiceId($id,$type)
  {
	  $obj= &get_instance();
	 $obj->load->model('invoice_model');
	 return $obj->invoice_model->getStudentNameFromInvoiceId($id,$type);
  }

	function profilechecklist()
		{
			return array(
			'student_profile'=>'Student homestay profile',
			'hostFamily_profile'=>'Host family profile',
			'Apu_profile'=>'APU profile',
			'No_Apu_profile'=>'No APU requested profile',
			'dropoff_profile'=>'Drop off requested profile'
			);
		}
	

	function clientsListGroupInv()
	{
		$obj=& get_instance();
		$obj->load->model('client_model');
		$clientsfull=$obj->client_model->clientsListGroupInv();
	
		return $clientsfull;
	}	
	
	function getDuplicateShaSet($id)
	{
		$obj=& get_instance();
		$obj->load->model('sha_model');
		$shaIds=$obj->sha_model->getDuplicateShaSet($id);
	
		return $shaIds;
	}
		
	function getDuplicateShaFirst($id)
	{
		$obj=& get_instance();
		$obj->load->model('sha_model');
		$shaIds=$obj->sha_model->getDuplicateShaFirst($id);
	
		return $shaIds;
	}
	
	function getActiveStudentFromDupliates($id)
	{
		$shaIds=getDuplicateShaSet($id);
		if(count($shaIds)>1)
			{
				$studentId=0;
				foreach($shaIds as $sha)
				{
					$booking=bookingByShaId($sha);
					if($booking['booking_from']<=date('Y-m-d') && ($booking['booking_to']>=date('Y-m-d') || $booking['booking_to']=='0000-00-00'))
					{
						$studentId=$sha;
						break;
					}
				}
				if($studentId==0)
					$studentId=max($shaIds);
			}
			else
				$studentId=$id;
		return $studentId;	
	}
	
	function nextInvoiceId()
	{
		$obj=& get_instance();
		$obj->load->model('invoice_model');
		$nextInvoiceId=$obj->invoice_model->nextInvoiceId();
		return $nextInvoiceId;
	}
	function nominatedfmailyname($id)
{
	$obj=& get_instance();
	$obj->load->model('hfa_model');
	return $obj->hfa_model->nominatedfmailyname($id);
}
	function totalnominatedfmaily($id)
{
	$obj=& get_instance();
	$obj->load->model('hfa_model');
	return $obj->hfa_model->totalnominatedfmaily($id);
}
function booking_bedroom($id){
	$obj=& get_instance();
	$query = $obj->db->query("SELECT * FROM `bookings` WHERE room='".$id."'");
  return  $query->num_rows();
  
	

}

function canDeactivateRoom($roomId)
{
	$obj=& get_instance();
	$obj->load->model('hfa_model');
	return $obj->hfa_model->canDeactivateRoom($roomId);
}

function stateabrivation(){
	
	return array(
				"ACT"=>"Australian Capital Territory",
                "NSW"=>"New South Wales",
                "VIC"=>"Victoria",
                "QLD"=>"Queensland",
                "SA"=>"South Australia",
				"WA"=>"Western Australia",
				"TAS"=>"Tasmania",
				"NT"=>"Northern Territory",
				);
}

function bookingBedNumber($booking_id)
{
	$obj=& get_instance();
	$obj->load->model('booking_model');
	return $obj->booking_model->bookingBedNumber($booking_id);
}

function ongoinginvoicedate($id){
	$obj=& get_instance();
	$tmp=array();
	$query = $obj->db->query("SELECT * FROM `invoice_ongoing` WHERE `application_id`='".$id."' ORDER by date desc limit 1");
  $data=  $query->row_array();
  if(!empty($data)){
  $tmp['from']=$data['booking_from'];
  $tmp['to']=$data['booking_to'];
  $tmp['type']="Ongoing Invoice";
  if($data['status']=='2')
	  $st='Partial';
  else if($data['status']=='3')
  $st='Paid';
else
    $st='Pending';
	$tmp['status']=$st;
	
  }else{
	  $query = $obj->db->query("SELECT * FROM `invoice_initial` WHERE `application_id`='".$id."' ");
  $data1=  $query->row_array();
  
  if(!empty($data1)){
  $tmp['from']=$data1['booking_from'];
  $tmp['to']=$data1['booking_to'];
  $tmp['type']="Initial Invoice";
  if($data1['status']=='2')
	  $st='Partial';
  else if($data1['status']=='3')
  $st='Paid';
else
    $st='Pending';
	$tmp['status']=$st;
	
  }
	  
  }
  return $tmp;

}

function checkIfFirstPoMovedToXero($id){
	$return=array();
	$obj=& get_instance();
	$query = $obj->db->query("SELECT * FROM `purchase_orders` WHERE `booking_id`='".$id."' and `initial`='1'");
  	$res=$query->row_array();
	if(empty($res))
		$return['id']=0;
	else
	{
		$return['moved_to_xero']=$res['moved_to_xero'];
		$return['id']=$res['id'];
	}
	return $return;
}

function checkIfInitialinvoiceMovedToXero($id,$studyTourId)
{
	$return=array();
	$obj=& get_instance();
	if($studyTourId==0)
		$sql="SELECT * FROM `invoice_initial` WHERE `application_id`='".$id."' and `study_tour`='0'";
	else
		$sql="SELECT * FROM `invoice_initial` WHERE `application_id`='".$studyTourId."' and `study_tour`='1'";	
		
	$query = $obj->db->query($sql);
  	$res=$query->row_array();//echo $obj->db->last_query();
	
	if(empty($res))//for study tour inovoices
	{
		$queryItem = $obj->db->query("SELECT * FROM `invoice_group_items` WHERE `sha_id`='".$id."' order by `date`");
		$resItem=$queryItem->row_array();//echo $obj->db->last_query();
		if(!empty($resItem))
		{
			$query = $obj->db->query("SELECT * FROM `invoice_group` WHERE `id`='".$resItem['invoice_id']."'");
			$res=$query->row_array();//echo $obj->db->last_query();
		}
	}
	
	if(empty($res))
		$return['id']=0;
	else
	{
		$return['moved_to_xero']=$res['moved_to_xero'];
		$return['id']=$res['id'];
	}
	return $return;
}

function getStudentStateForSuggestions($id)
{
	$state='';
	$shaOne=getShaOneAppDetails($id);
	if($shaOne['client']!=0)
	{
		$clientDetail=clientDetail($shaOne['client']);
		if($clientDetail['state']!='')
			$state=getStudentStateForSuggestionsMatch($clientDetail['state']);
		else
		{
			$shaThree=getShaThreeAppDetails($id);
			$state=getStudentStateForSuggestionsMatch($shaThree['campus']);
			if($state=='')
				$state=getStudentStateForSuggestionsMatch($shaThree['college_address']);
		}	
	}
	return $state;
}

function getStudentStateForSuggestionsMatch($text)
{
	$text=strtolower(trim($text));
	$stateabrivation=stateabrivation();
	$state='';
	foreach($stateabrivation as $k=>$v)
	{
		if(strstr($text,strtolower($k)) || strstr($text,strtolower($v)))
		{
			$state=$k;
			break;
		}
	}
	return $state;
}

function getCaregiversByCompany($id)
{
	$obj=& get_instance();
	$obj->load->model('caregiver_model');
	$caregivers=$obj->caregiver_model->getCaregiversByCompany($id);
	return $caregivers;
}

function getCaregiverCompanyList()
{
	$obj=& get_instance();
	$obj->load->model('caregiver_model');
	$companyList=$obj->caregiver_model->companyList();
	return $companyList;
}

function getCaregiverDetail($id)
{
	$obj=& get_instance();
	$obj->load->model('caregiver_model');
	$cg=$obj->caregiver_model->caregiverDetail($id);
	return $cg;
}

function getCaregiverCompanyDetail($id)
{
	$obj=& get_instance();
	$obj->load->model('caregiver_model');
	return $obj->caregiver_model->companyDetail($id);
}

function getStudentLanguageForFilter($formTwo)
{
	$studentLang='';
	$studentLangProf='0';
	if(isset($formTwo['language']))
	{
		foreach($formTwo['language'] as $lang)
		{
			if($lang['language']!='10' && $lang['language']!='25')
			{
				if($studentLangProf<$lang['prof'] || $studentLang=='')
				{
					$studentLangProf=$lang['prof'];
					$studentLang=$lang['language'];
				}
			}
		}
	}
	return $studentLang;
}

function getMapLocationLink($address)
{
	$link='<a href="https://www.google.com/maps/search/'.urlencode($address).'" target="_blank" class="mapLocationLink"><span>'.$address.'</span></a>';
	return $link;
}

function ifOngInvIsLatest($id)
{
	$obj=& get_instance();
	$obj->load->model('invoice_model');
	$cg=$obj->invoice_model->ifOngInvIsLatest($id);
	return $cg;
}

function ifPoIsLatest($id)
{
	$obj=& get_instance();
	$obj->load->model('invoice_model');
	$cg=$obj->po_model->ifPoIsLatest($id);
	return $cg;
}

function college_auditing_report_fields()
{
	$reportFields=array(
	'office'=>'Office',
	'host_name'=>'Host Name',
	'host_email'=>'Host Email Id',
	'host_address'=>'Host Address',
	'resident'=>'Resident',
	'wwcc'=>'WWCC',
	'insurance'=>'Insurance',
	'student_number'=>'Student Number',
	'student_name'=>'Guest',
	'student_dob'=>'Guest Dob',
	'student_age'=>'Guest Age',
	'student_gender'=>'Guest Gender',
	'college'=>'College/University name',
	'course_name' => 'Course Details',
	'last_visit_date'=>'Last visit Date',
	'client'=>'Client',
	'client_group'=>'Client Group',
	'booking_start_date'=>'Booking start date',
	'booking_end_date'=>'Booking end date',
	'booking_status'=>'Booking status'
	);
	return $reportFields;
}

function tour_groups_report_fields()
{
	$reportFields=array(
	'sha_name'=>'Student Name',
	'sha_dob'=>'DOB',
	'sha_age'=>'Age',
	'sha_gender'=>'Gender',
	'sha_college'=>'College',
	'checking_date'=>'Checking In Date',
	'checking_out_date'=>'Checking Out Date',
	'sha_tour_group'=>'Tour Group Name',
	'hfa_name'=>'Host Family Name',
	'hfa_email'=>'Host Family Email',
	'hfa_address'=>'Host Family Address',
	'hfa_mobile'=>'Host Family Mobile',
	'sha_nation'=>'Nationality',
	'sha_allergy'=>'Allergies',
	'sha_pets'=>'Pets',
	'sha_kids'=>'Stay with kids or not',
	'sha_accomodationType'=>'Types Of Homestay',
	'sha_notes'=>'Special Request Or Notes'
	);
	return $reportFields;
}

function revisits_report_fields()
{
	$reportFields=array(
	'primary_host'=>'Primary host',
	'mobile'=>'Mobile',
	'email_id'=>'Email Id',
	'address'=>'Address',
	'last_visit_date'=>'Last visit date',
	'revisit_due_date'=>'Revisit due date'
	);
	return $reportFields;
}

function incidents_report_fields()
{
	$reportFields=array(
	'student_college_id'=>'Student college id',
	'student_name'=>'Student name',
	'host_family_name'=>'Host family',
	'hfa_id'=>'Host id',
	'detail'=>'Incident detail',
	'follow_up'=>'Follow up',
	'outcome'=>'Outcome',
	'incident_date'=>'Incident date',
	'status'=>'Incident status',
	'level'=>'Incident type',
	'college'=>'College',
	'client'=>'Client',
	'client_group'=>'Client Group'
	);
	return $reportFields;
}

function bookings_report_fields()
{
	$reportFields=array(
	'sha_name'=>'Student Name',
	'student_college_id'=>'Student college id',
	'sha_dob'=>'Student DOB',
	'sha_gender'=>'Student Gender',
	'sha_age'=>'Student Age',
	'sha_email'=>'Student Email',
	'sha_mobile'=>'Student Mobile',
	'booking_number'=>'Booking Number',
	'booking_status'=>'Booking Status',
	'client_name'=>'Client Name',
	'client_group'=>'Client Group',
	'college_name'=>'College Name',
	'booking_start_date'=>'Booking Start Date',
	'booking_end_date'=>'Booking End Date',
	'sha_pets'=>'Pets',
	'sha_allergy'=>'Allergies',
	'sha_kids'=>'Can you live with children',
	'sha_dietry_requirement'=>'Special dietary requirements',
	'sha_medication'=>'Any medication',
	'sha_disabilty'=>'Any disability',
	'sha_smoke'=>'Smoker',
	'sha_smoker_inside'=>'Can stay with a family that includes a smoker?',
	'sha_other_family_pref'=>'Other family preferences',
	'hfa_name'=>'Host Family Name',
	'hfa_address'=>'Host Family Address',
	'hfa_mobile'=>'Host Family Mobile',
	'hfa_email'=>'Host Family Email',
	'apu'=>'Airport Pickup',
	'apu_company'=>'APU Company',
	'apu_arrival_date'=>'Arrival Date',
	'apu_arrival_time'=>'Arrival Time',
	'apu_flight_number'=>'Flight Number',
	'course_name' => 'Course Details',
	'cg_company'=>'Caregiver company',
	'cg_name'=>'Caregiver name',
	'cg_mobile'=>'Caregiver mobile',
	'cg_email'=>'Caregiver email',
	'holidays_latest'=>'Latest holiday',
	'holidays'=>'All holidays',
	'homestay_change'=>'Homestay change'
	);
	return $reportFields;
}

function bookings_allocation_report_fields()
{
	$reportFields=array(
	'employee'=>'Employee',	
	'sha_name'=>'Student Name',
	'student_college_id'=>'Student college id',
	'sha_dob'=>'Student DOB',
	'sha_gender'=>'Student Gender',
	'sha_age'=>'Student Age',
	'sha_email'=>'Student Email',
	'sha_mobile'=>'Student Mobile',
	'booking_number'=>'Booking Number',
	'booking_status'=>'Booking Status',
	'client_name'=>'Client Name',
	'client_group'=>'Client Group',
	'college_name'=>'College Name',
	'booking_start_date'=>'Booking Start Date',
	'booking_end_date'=>'Booking End Date',
	'sha_pets'=>'Pets',
	'sha_allergy'=>'Allergies',
	'sha_kids'=>'Can you live with children',
	'sha_dietry_requirement'=>'Special dietary requirements',
	'sha_medication'=>'Any medication',
	'sha_disabilty'=>'Any disability',
	'sha_smoke'=>'Smoker',
	'sha_smoker_inside'=>'Can stay with a family that includes a smoker?',
	'sha_other_family_pref'=>'Other family preferences',
	'hfa_name'=>'Host Family Name',
	'hfa_address'=>'Host Family Address',
	'hfa_mobile'=>'Host Family Mobile',
	'hfa_email'=>'Host Family Email',
	'apu'=>'Airport Pickup',
	'apu_company'=>'APU Company',
	'apu_arrival_date'=>'Arrival Date',
	'apu_arrival_time'=>'Arrival Time',
	'apu_flight_number'=>'Flight Number',
	'course_name' => 'Course Details',
	'cg_company'=>'Caregiver company',
	'cg_name'=>'Caregiver name',
	'cg_mobile'=>'Caregiver mobile',
	'cg_email'=>'Caregiver email',
	'holidays_latest'=>'Latest holiday',
	'holidays'=>'All holidays',
	'homestay_change'=>'Homestay change'
	);
	return $reportFields;
}

function clients_report_fields()
{
	$reportFields=array(
	'bname'=>'Business name',
	'client_address'=>'Address',
	'primary_contact_name'=>'Primary contact name',
	'primary_phone'=>'Primary contact phone',
	'primary_email'=>'Primary contact email',
	
	);
	return $reportFields;
}

function wwcc_report_fields()
{
	$reportFields=array(
	'hfa_id'=>'Family Id',
	'hfa_name'=>'Host Name',
	'hfa_member_name'=>'Member Name',
	'clearence_number'=>'Clearance Number',
	'expiry_date'=>'Expiry Date',
	'application_number'=>'Application Number',
	'document_uploaded'=>'Document Uploaded',
	'wwcc_status'=>'WWCC Status'
	);
	return $reportFields;
}

function caregiving_service_report_fields()
{
	$reportFields=array(
	'sha_name'=>'Student Name',
	'student_college_id'=>'Student college id',
	'sha_dob'=>'Student DOB',
	'sha_gender'=>'Student Gender',
	'sha_age'=>'Student Age',
	'booking_number'=>'Booking Number',
	'booking_status'=>'Booking Status',
	'client_name'=>'Client Name',
	'client_group'=>'Client Group',
	'college_name'=>'College Name',
	'booking_start_date'=>'Booking Start Date',
	'booking_end_date'=>'Booking End Date',
	'hfa_name'=>'Host Family Name',
	'hfa_address'=>'Host Family Address',
	'hfa_mobile'=>'Host Family Mobile',
	'hfa_email'=>'Host Family Email',
	'cg_company'=>'Caregiver company',
	'cg_name'=>'Caregiver name',
	'cg_mobile'=>'Caregiver mobile',
	'cg_email'=>'Caregiver email',
	);
	return $reportFields;
}

function wwccStatusList()
{
	$wwccStatus=array(
	'1'=>"Doesn't have WWCC",
	'2'=>"Has WWCC but file not uploaded",
    '3'=>"WWCC file uploaded",
    '4'=>"WWCC expired",
    '5'=>"Member turned 18",
    '6'=>"Not applicable, age under 18"
	);
	return $wwccStatus;
}

function insurance_report_fields()
{
	$reportFields=array(
	'hfa_name'=>'Host Name',
	'ins_provider'=>'Insurance Provider Name',
	'ins_policy_number'=>'Policy Number',
	'expiry_date'=>'Expiry Date',
	'document_uploaded'=>'Document Uploaded',
	'20_million'=>'$20 million public liability cover',
	'insurance_status'=>'Insurance Status'
	);
	return $reportFields;
}

function booking_duration_report_fields()
{
	//$reportFields=bookings_report_fields();
	$reportFields=array(
	'sha_name'=>'Student Name',
	'student_college_id'=>'Student college id',
	'sha_dob'=>'Student DOB',
	'sha_gender'=>'Student Gender',
	'sha_age'=>'Student Age',
	'sha_email'=>'Student Email',
	'sha_mobile'=>'Student Mobile',
	'booking_number'=>'Booking Number',
	'booking_status'=>'Booking Status',
	'client_name'=>'Client Name',
	'client_group'=>'Client Group',
	'college_name'=>'College Name',
	'booking_start_date'=>'Booking Start Date',
	'booking_end_date'=>'Booking End Date',
	'hfa_name'=>'Host Family Name',
	'hfa_address'=>'Host Family Address',
	'hfa_mobile'=>'Host Family Mobile',
	'hfa_email'=>'Host Family Email',
	'apu'=>'Airport Pickup',
	'apu_company'=>'APU Company',
	'apu_arrival_date'=>'Arrival Date',
	'apu_arrival_time'=>'Arrival Time',
	'apu_flight_number'=>'Flight Number'
	);
	$reportFields['nominated_regular']='Nominated/Regular';
	$reportFields['duration']='Duration';
	$reportFields['homestay_change']='Homestay change';
	return $reportFields;
}

function bookingsRegularCheckups_report_fields()
{
	$reportFields=array(
	'sha_name'=>'Student Name',
	'student_college_id'=>'Student college id',
	'college_name'=>'College Name',
	'hfa_name'=>'Host Family Name',
	'booking_number'=>'Booking Number',
	'booking_start_date'=>'Booking Start Date',
	'booking_end_date'=>'Booking End Date',
	'booking_checkupDate'=>'Checkup date',
	'booking_checkupNotes'=>'Notes'
	);
	return $reportFields;
}

function profit_report_fields()
{
	$reportFields=array(
	'booking_id'=>'Booking id',
	'accomodation_fee'=>'Accommodation income',
	'caregiving_fee'=>'Caregiving income',
	'hostfamily_fee'=>'Cost we paid to host family',
	'admin_fee'=>'Administration fee',
	'margin'=>'Profit margin'
	);
	return $reportFields;
}

function bookingsHolidayCheckups_report_fields()
{
	$reportFields=array(
	'sha_name'=>'Student Name',
	'student_college_id'=>'Student college id',
	'college_name'=>'College Name',
	'hfa_name'=>'Host Family Name',
	'booking_number'=>'Booking Number',
	'booking_start_date'=>'Booking Start Date',
	'booking_end_date'=>'Booking End Date',
	'booking_checkupDate'=>'Checkup date',
	'booking_checkupNotes'=>'Notes'
	);
	return $reportFields;
}

function insuranceStatusList()
{
	$wwccStatus=array(
	'1'=>"Available",
	'2'=>"Not Availale",
    '3'=>"Expired"
	);
	return $wwccStatus;
}

function checkIfStudentBookedInDates($studentID,$bookingDates)
{
	$obj=& get_instance();
	$obj->load->model('booking_model');
	$cg=$obj->booking_model->checkIfStudentBookedInDates($studentID,$bookingDates);
	return $cg;
}

function bedSizeList()
{
	return array(
	'1'=>'Small',
	'2'=>'Regular',
	'3'=>'Large'
	);
}

function incidentStatusList()
{
	return array(
		'0'=>'Open',
		'1'=>'Closed'
	);
}

function incidentLevelList()
{
	return array(
		'1'=>'Financial Arrangement',
		'2'=>'Meals Arrangement',
		'3'=>'Students Breaking the House Rules',
		'4'=>'Hosts Breaking their Obligations as a Carer',
		'5'=>'Host misconduct/Inappropriate Behaviour',
		'6'=>'Student misconduct/Inappropriate Behaviour',
		'7'=>'Personality Clash/cultural differences',
		'8'=>'Unsuitable House Arrangement',
		'9'=>'Other'
	);
}

function incidentLevelDescList()
{
	return array(
		'0'=>'Please select the incident type from the dropdown list',
		'1'=>'This includes: private arrangement after the end of four weeks, asking student to pay for washing powder, charging higher internet fees, etc.',
		'2'=>'This include: not eating dinner together, ask student to purchase meals outside when they are not home, cooking frozen meals, etc.',
		'3'=>'This include: breaking curfew time, staying overnight at friend’s house with no approval, COE suspension, bringing unexpected visitor home',
		'4'=>'This include: leaving the students at home with stranger while they are going on holiday, hosts allow students to stay overnight at friend’s house during school holiday',
		'5'=>'This include: sexual harassment, domestic violence',
		'6'=>'This include: sexual harassment, domestic violence',
		'7'=>'This include: continuous arguments between host and student',
		'8'=>'This include placing students in a granny flat when they are U18, untidy house, etc.',
		'9'=>'Please mention other type of incident level in the field below'
	);
}

function incidentsByHfaId($hfaId)
{
	$obj=& get_instance();
	$obj->load->model('hfa_model');
	$cg=$obj->hfa_model->incidentsByHfaId($hfaId);
	return $cg;
}

function getVisitReportBedInfo($reportId)
{
	$obj=& get_instance();
	$obj->load->model('hfa_model');
	$cg=$obj->hfa_model->getVisitReportBedInfo($reportId);
	return $cg;
}

function feedbacks_report_fields()
{
	$reportFields=array(
	'sha_name'=>'Student Name',
	'sha_college_id'=>'Student College Id',
	'sha_college_name'=>'College Name',
	'host_name'=>'Host Name',
	'host_address'=>'Host Address',
	'move_in_date'=>'Move In Date',
	'apu'=>'Airport Pickup',
	'apu_satisfied'=>'Satisfied',
	'host_comfort'=>'Homestay Comfort',
	'host_friendly'=>'Homestay Friendliness',
	'host_food'=>'Homestay Food',
	'host_overall'=>'Overall Experience',
	'testimonial'=>'Testimonial',
	'comments'=>'Other Comments',
	'feedback_date'=>'Feedback Date',
	'client'=>'Client',
	'client_group'=>'Client Group'
	);
	return $reportFields;
}

function feedbackEmailsSent_report_fields()
{
	$reportFields=array(
	'sha_name'=>'Student Name',
	'sha_college_name'=>'College Name',
	'email_id'=>'Email Id',
	'email_date'=>'Email Date',
	'email_time'=>'Email Time'
	);
	return $reportFields;
}

function bookingCheckupTypeList()
{
	return array(
		'1'=>'Arrival check',
		'2'=>'Reminder check',
		'3'=>'Regular check',
		'4'=>'Holiday reminder check',
		'5'=>'Holiday return check'
	);
}

function checkupMethodList()
{
	return array(
		'email'=>'Email',
		'phone'=>'Phone',
		'text'=>'Text message'
	);
}

function recentActionsAdd($data)
{
	$obj=& get_instance();
	$obj->load->model('account_model');
	$cg=$obj->account_model->recentActionsAdd($data);
}

function recentActionsAddData($onType,$on,$action)
{
	$actionData['action_on_type']=$onType;
	$actionData['action_on']=$on;
	$actionData['action']=$action;
	recentActionsAdd($actionData);
}

function recentActivityIconList()
{
	return array(
		'booking'=>'domain',
		'booking_regularCheckup'=>'domain',
		'hfa'=>'home',
		'sha'=>'face',
		'tour'=>'stars',
		'po'=>'receipt',
		'client'=>'account_box',
		'caregiver'=>'group_work',
		'apuCompany'=>'flight',
		'report'=>'insert_drive_file',
		'invoice_initial'=>'monetization_on',
		'invoice_ongoing'=>'monetization_on',
		'homestay_servicesGI'=>'monetization_on',
		'taylors_collegeGI'=>'monetization_on'
	);
}

function recentActivityTitleList()
{
	return array(
		'booking'=>'Bookings',
		'booking_regularCheckup'=>'Regular checkups',
		'hfa'=>'Host families',
		'sha'=>'Students',
		'tour'=>'Tour groups',
		'po'=>'Purchase orders',
		'client'=>'Clients',
		'caregiver'=>'Caregivers',
		'apuCompany'=>'APU Companies',
		'report'=>'Reports',
		'invoice_initial'=>'Initial invoices',
		'invoice_ongoing'=>'Ongoing invoices',
		'homestay_servicesGI'=>'Family homestay services',
		'taylors_collegeGI'=>'Taylor\'s college'
	);
}

function timeAgoRA($date)
{
	$nowdate = date('Y-m-d H:i:s');
	$tdifference = $date;              
	$date1 = date_create($nowdate);
	$date2 = date_create($tdifference);
	$diff12 = date_diff($date2, $date1);
	$hours = $diff12->h; 
	$mint = $diff12->i;
	$days = $diff12->d;
	$months = $diff12->m;   
	$years = $diff12->y;
	$weeks=floor($days/7);
	//echo $mint.' mins, '.$hours.' hours ,'.$days.' days, '.$weeks.' weeks, '.$months.' months, '.$years.' years ';
	
	if($years > 0 || $months > 0 || $weeks > 0)
		$ago= date('Y-m-d',strtotime($date));
	else
	{
		if($hours > 0)
			$ago=$hours .' hour'.s($hours).' ago';
		elseif($mint > 0)
			$ago=$mint .' minute'.s($mint).' ago';
		elseif($mint ==0)
			$ago='Just now';
	}
		
	return $ago;	
}

function actionDescRA($activity)
{
	if($activity['action_on_type']=='booking')
		$descLink=bookingActivityDesc($activity);
	elseif($activity['action_on_type']=='hfa')
		$descLink=hfaActivityDesc($activity);
	elseif($activity['action_on_type']=='sha')
		$descLink=shaActivityDesc($activity);
	elseif($activity['action_on_type']=='tour')
		$descLink=tourGroupActivityDesc($activity);
	elseif($activity['action_on_type']=='po')
		$descLink=poActivityDesc($activity);
	elseif($activity['action_on_type']=='client')
		$descLink=clientActivityDesc($activity);
	elseif($activity['action_on_type']=='caregiver')
		$descLink=caregiverActivityDesc($activity);
	elseif($activity['action_on_type']=='apuCompany')
		$descLink=apuCompanyActivityDesc($activity);
	elseif($activity['action_on_type']=='report')
		$descLink=reportActivityDesc($activity);
	elseif($activity['action_on_type']=='invoice_initial' || $activity['action_on_type']=='invoice_ongoing')
		$descLink=invoiceActivityDesc($activity);
	elseif($activity['action_on_type']=='homestay_servicesGI' || $activity['action_on_type']=='taylors_collegeGI')
		$descLink=groupInvoiceActivityDesc($activity);
	
	$res['desc']=$descLink['desc'];
	$res['link']=$descLink['link'];
	$res['timeAgo']=timeAgoRA($activity['date']);
	return $res;
}

function bookingActivityDesc($activity)
{
	$desc='';
	$link=$activity['action_on_type'];
	if($activity['action']=='view')
		{
			if(is_numeric($activity['action_on']))
			{
				$desc='Booking viewed: '.$activity['action_on'];
				$link .='/view/'.$activity['action_on'];
			}
			else
			{
				$list=' list viewed';
				$booking=array(
					'all'=>'All bookings'.$list,
					'expected_arrival'=>'Expected'.$list,
					'arrived'=>'Arrived'.$list,
					'progressive'=>'Progressive'.$list,
					'moved_out'=>'Moved out'.$list,
					'on_hold'=>'On hold'.$list,
					'cancelled'=>'Cancelled'.$list
				);
				
				if(in_array($activity['action_on'],array('all','expected_arrival','arrived','progressive','moved_out','on_hold','cancelled')))
					$desc=$booking[$activity['action_on']];
					
				if($activity['action_on']!='all')
					$link .='/'.$activity['action_on'];	
			}
		}
		return compact('desc','link');
}

function hfaActivityDesc($activity)
{
	$desc='';
	$link=$activity['action_on_type'];
	/*if($activity['action']=='view')
		{*/
			if(is_numeric($activity['action_on']))
			{
				$hfa=getHfaOneAppDetails($activity['action_on']);
				if(!empty($hfa))
				{
					if($activity['action']=='view')
							$desc='Host family application viewed: ';
						else
							$desc='New application added by admin: ';
					$desc .=$hfa['lname'].' Family';
				}
				$link .='/application/'.$activity['action_on'];	
			}
			else
			{
				$list=' list viewed';
				$hfa=array(
						'all'=>'All host families'.$list,
						'new'=>'New'.$list,
						'no_response'=>'No response'.$list,
						'confirmed'=>'Confirmed'.$list,
						'pending_approval'=>'Pending approval'.$list,
						'approved'=>'Approved'.$list,
						'do_not_use'=>'Do not use'.$list,
						'unavailable'=>'Unavailable'.$list
					);
				
				if(in_array($activity['action_on'],array('all','new','no_response','confirmed','pending_approval','approved','do_not_use','unavailable')))
					$desc=$hfa[$activity['action_on']];
					
				if($activity['action_on']!='all')
				{
					if($activity['action_on']=='new')
						$link .='/new_application';
					else	
						$link .='/'.$activity['action_on'];
				}	
			}
		/*}*/
		return compact('desc','link');
}

function shaActivityDesc($activity)
{
		$desc='';
		$link=$activity['action_on_type'];
		/*if($activity['action']=='view')
			{*/
				if(is_numeric($activity['action_on']))
				{
					$sha=getShaOneAppDetails($activity['action_on']);
					if(!empty($sha))
					{
						if($activity['action']=='view')
							$desc='Student application viewed: ';
						else
							$desc='New application added by admin: ';
						$desc .=$sha['fname'].' '.$sha['lname'];
					}
					$link .='/application/'.$activity['action_on'];	
				}
				else
				{
					$list=' list viewed';
					$sha=array(
						'all'=>'All students'.$list,
						'new'=>'New'.$list,
						'pending_invoice'=>'Pending invoice'.$list,
						'approved_without_payment'=>'Approved - unpaid'.$list,
						'approved_with_payment'=>'Approved - paid'.$list,
						'rejected'=>'Rejected'.$list,
						'cancelled'=>'Cancelled'.$list
					);
				
					if(in_array($activity['action_on'],array('all','new','pending_invoice','approved_without_payment','approved_with_payment','rejected','cancelled')))
						$desc=$sha[$activity['action_on']];
					
					if($activity['action_on']!='all')
					{
						if($activity['action_on']=='new')
							$link .='/new_application';
						else	
							$link .='/'.$activity['action_on'];
					}	
				}
			/*}*/
			return compact('desc','link');
	}
	
	function tourGroupActivityDesc($activity)
	{
		$desc='';
		$link=$activity['action_on_type'];
		if(is_numeric($activity['action_on']))
		{
			$tour=tourDetail($activity['action_on']);
			if(!empty($tour))
			{
				if($activity['action']=='view' || $activity['action']=='add')
				{
					if($activity['action']=='view')
						$desc='Tour group viewed: ';
					else
						$desc='Tour group added: ';	
					$desc .=$tour['group_name'];
					$link .='/edit/'.$activity['action_on'];
				}
				elseif($activity['action']=='view_manage')
				{
					$desc='Manage applications viewed: '.$tour['group_name'];	
					$link .='/all_students/'.$activity['action_on'];
				}
			}
		}
		else
		{			
			$list=' list viewed';
			$tourGroup=array(
				'list'=>'Tour'.$list
			);
		
			$desc=$tourGroup[$activity['action_on']];
		}
		return compact('desc','link');
	}
	
	function poActivityDesc($activity)
	{
		$desc='';
		$link='purchase_orders';
		if(is_numeric($activity['action_on']))
		{
			$obj=& get_instance();
			$obj->load->model('po_model');
			$po=$obj->po_model->poDetails($activity['action_on']);
			if($po['status']=='1')
				$desc='Pending';	
			elseif($po['status']=='2')
				$desc='Paid';	
			elseif($po['status']=='3')
				$desc='Partially paid';	
			$desc .=' purchase order viewed: '.$activity['action_on'];
			$link .='/view/'.$activity['action_on'];
		}
		else
		{
			$list=' list viewed';
			$po=array(
				'all'=>'All purchase orders'.$list,
				'pending'=>'Pending'.$list,
				'partial'=>'Partially paid'.$list,
				'paid'=>'Paid'.$list
			);
		
			$desc=$po[$activity['action_on']];
			
			if($activity['action_on']!='pending')
				$link .='/'.$activity['action_on'];
		}
		return compact('desc','link');
	}
	
	function clientActivityDesc($activity)
	{
		$desc='';
		$link=$activity['action_on_type'];
		if(is_numeric($activity['action_on']))
		{
			$client=clientDetail($activity['action_on']);
			if(!empty($client))
			{
				if($activity['action']=='view')
					$desc='Client viewed: '.$client['bname'];
				else
					$desc='Client added: '.$client['bname'];
				
				$link .='/edit/'.$activity['action_on'];
			}
		}
		else
		{
			$list=' list viewed';
			$client=array(
				'list'=>'Client'.$list
			);
		
			$desc=$client[$activity['action_on']];
		}
		return compact('desc','link');
	}
	
	function caregiverActivityDesc($activity)
	{
		$desc='';
		$link=$activity['action_on_type'];
		if(is_numeric($activity['action_on']))
		{
			$obj=& get_instance();
			$obj->load->model('caregiver_model');
			$cg=$obj->caregiver_model->companyDetail($activity['action_on']);
			if(!empty($cg))
			{
				$viewAdd='';
				if($activity['action']=='view')
					$viewAdd='viewed';
				elseif($activity['action']=='add')
					$viewAdd='added';
				$desc='Caregiver company '.$viewAdd.': '.$cg['name'];
			}
			$link .='/edit_company/'.$activity['action_on'];
		}
		else
		{
			$list=' list viewed';
			$cg=array(
				'list'=>'Company'.$list
			);
		
			$desc=$cg[$activity['action_on']];
		}
		return compact('desc','link');
	}
	
	function apuCompanyActivityDesc($activity)
	{
		$desc='';
		$link='apu_company';
		if(is_numeric($activity['action_on']))
		{
			$apu=apuCompanyDetail($activity['action_on']);
			if(!empty($apu))
			{
				$viewAdd='';
				if($activity['action']=='view')
					$viewAdd='viewed';
				elseif($activity['action']=='add')
					$viewAdd='added';
				$desc='APU company '.$viewAdd.': '.$apu['company_name'];
			}
			$link .='/edit/'.$activity['action_on'];
		}
		else
		{
			$list=' list viewed';
			$cg=array(
				'list'=>'APU company'.$list
			);
		
			$desc=$cg[$activity['action_on']];
		}
		return compact('desc','link');
	}
	
	function reportActivityDesc($activity)
	{
		$desc='';
		$link='reports/'.$activity['action_on'];
		$reportText=' report viewed';
		$report=array(
			'hfa'=>'Host family'.$reportText,
			'college_auditing'=>'College audit'.$reportText,
			'tour_groups'=>'Tour group'.$reportText,
			'revisits'=>'Revisit'.$reportText,
			'incidents'=>'Incident'.$reportText,
			'bookings'=>'Booking'.$reportText,
			'booking_regularCheckup'=>'Booking regular checkup'.$reportText,
			'wwcc'=>'WWCC'.$reportText,
			'insurance'=>'Insurance'.$reportText,
			'feedback'=>'Feedback'.$reportText,
			'booking_duration'=>'Booking duration'.$reportText,
			'parent_nominated_homestay'=>'Parent nominated homestay'.$reportText,
			'caregiving_service'=>'Caregiving service'.$reportText,
			'invoice'=>'Invoice'.$reportText,
			'booking_allocation'=>'Booking allocation'.$reportText,
			'profit'=>'Profit'.$reportText,
			'booking_holidayCheckup'=>'Holiday check-up'.$reportText,
			'clients_report'=>'Clients'.$reportText,
			'training_event'=>'Training Event'.$reportText,
			'booking_comparison'=>'Booking Comparison'.$reportText
		);
	
		$desc=$report[$activity['action_on']];
		
		return compact('desc','link');
	}
	
	function invoiceActivityDesc($activity)
	{
		$desc='';
		$link='invoice';
		if(is_numeric($activity['action_on']))
			{
				if($activity['action_on_type']=='invoice_initial')
				{
					$invoice=initialInvoiceDetails($activity['action_on']);
					$link .='/view_initial';
				}
				else
				{
					$invoice=ongoingInvoiceDetails($activity['action_on']);
					$link .='/view_ongoing';
				}
				if($invoice['status']=='1')
					$desc='Pending';
				elseif($invoice['status']=='2')
					$desc='Partially paid';
				elseif($invoice['status']=='3')
					$desc='Paid';	
				$desc .=' invoice viewed: '.$activity['action_on'];
				$link .='/'.$activity['action_on'];
			}
		else
			{
				$list=' invoice list viewed';
				$po=array(
					'all'=>'All invoices list viewed',
					'pending'=>'Pending'.$list,
					'partial'=>'Partially paid'.$list,
					'paid'=>'Paid'.$list
				);
			
				$desc=$po[$activity['action_on']];
			
				if($activity['action_on_type']=='invoice_initial')
					$link .='/initial';
				else
					$link .='/ongoing';
				if($activity['action_on']!='pending')
					$link .='_'.$activity['action_on'];
			}
		return compact('desc','link');
	}
	
	function groupInvoiceActivityDesc($activity)
	{
		$desc='';
		$link='group_invoice';
		if(is_numeric($activity['action_on']))
		{
			$invoice=groupInvoiceDetails($activity['action_on']);
			if($invoice['status']=='1')
				$desc='Pending';
			elseif($invoice['status']=='2')
				$desc='Partially paid';
			elseif($invoice['status']=='3')
				$desc='Paid';	
			$desc .=' invoice viewed: '.$activity['action_on'];
			$link .='/view/'.$activity['action_on'];
		}
		else
		{
			$list=' invoice list viewed';
			$po=array(
				'all'=>'All invoices list viewed',
				'pending'=>'Pending'.$list,
				'partial'=>'Partially paid'.$list,
				'paid'=>'Paid'.$list
			);
		
			$desc=$po[$activity['action_on']];
			$link .='/'.$activity['action_on'];
			if($activity['action_on_type']=='homestay_servicesGI')
				$link .='/26';
			else
				$link .='/1179';
		}
		return compact('desc','link');
	}

	function ifReminderCheckupAdded($id)
	{
		$obj=& get_instance();
		$obj->load->model('booking_model');
		$checkups=$obj->booking_model->checkupsByBooking($id);
		$added=false;
		foreach($checkups as $checkup)
		{
			if($checkup['type']=='2')
			{
				$added=true;
				break;
			}
		}
		return $added;
	}

	function ifArrivalCheckupAdded($id)
	{
		$obj=& get_instance();
		$obj->load->model('booking_model');
		$checkups=$obj->booking_model->checkupsByBooking($id);
		$added=false;
		foreach($checkups as $checkup)
		{
			if($checkup['type']=='1')
			{
				$added=true;
				break;
			}
		}
		return $added;
	}

	function getArrivalCheckupInfoByBookingId($id)
	{
		$obj=& get_instance();
		$obj->load->model('booking_model');
		$checkups=$obj->booking_model->getArrivalCheckupInfoByBookingId($id);
		return $checkups;
	}
	
	function poDetails($id)
	{
		  $obj=& get_instance();
		  $obj->load->model('po_model');
		  return $po=$obj->po_model->poDetails($id);
	}
	
	function bookingIncidentFollowUps($id)
	{
		  $obj=& get_instance();
		  $obj->load->model('booking_model');
		  return $po=$obj->booking_model->incidentFollowUps($id);
	}
	
	function bookingIncidentDocs($id)
	{
		  $obj=& get_instance();
		  $obj->load->model('booking_model');
		  return $po=$obj->booking_model->incidentDocs($id);
	}
	
	function ifAccTypeIsServiceOnly($type)
	{
		$res=false;
		if(in_array($type,array('6','7')))
			$res=true;
		return $res;	
	}
	
	function viewFollowUpHeader($followUp)
	{
		return dateFormat($followUp['followup_date']).' - '.substr($followUp['text'],0,70);
	}
	
	function getWeekDayTextForXero($unitType)
	{
		$text='';
		if($unitType=='1')
			$text=' [Weeks]';
		elseif($unitType=='2')
			$text=' [Days]';
			
		return $text;
	}
	
	function nAText()
	{
		return 'Not applicable';
	}
	
	function hfaWarningSentByOptionList()
	{
		return array(
			'1'=>'by email',
			'2'=>'by post',
			'3'=>'by both (email and post)'
		);
	}
	
	function hfaWarningDocs($id)
	{
		  $obj=& get_instance();
		  $obj->load->model('hfa_model');
		  return $po=$obj->hfa_model->hfaWarningDocs($id);
	}
	
	function warningsByHfaIdCount($id)
	{
		  $obj=& get_instance();
		  $obj->load->model('hfa_model');
		  $warnings=$obj->hfa_model->warningsByHfaId($id);
		  return count($warnings);
	}
	
	function cgDocList($bid)
	{
		$obj=& get_instance();
		$obj->load->model('booking_model');
		return $obj->booking_model->cgDocList($bid);
	}
	
	function getHfaFacilityList()
	{
		return array('1'=>'Swimming pool', '2'=>'Tennis court', '3'=>'Piano', '4'=>'Gym', '5'=>'Disable access');
	}
	
	function studentProfileU18Colleges()
	{
		return array(
			'Insearch - UTS',
			'IH Darwin',
			'IH Melbourne',
			'IH Sydney',
			'IH Bondi',
			'Western Sydney University - Paramatta',
			'Western Sydney University - Campbelltown',
			'Western Sydney University - Bankstown',
			'Western Sydney University - Penrith',
			'Western Sydney University - Westmead',
			'Western Sydney University - Blacktown',
			'Western Sydney University - SOP',
			'ELS Universal English College'
		);
	}
	
	function groupInvClient($client)
	{
		$clientDetail=clientDetail($client);
		$groupInvClient=false;
		if($clientDetail['group_invoice']=='1' && ($clientDetail['group_invoice_placement_fee']=='1' || $clientDetail['group_invoice_apu']=='1' || $clientDetail['group_invoice_accomodation_fee']=='1'))
			 $groupInvClient=true;
		return $groupInvClient;	 
	}
		
	function clientGroupList()
	{
		return [
			'uc_nsw'=>'University/College - NSW',
			'uc_vic'=>'University/College - VIC',
			'uc_nt'=>'University/College - NT',
			'pbs_nsw'=>'Public Schools - NSW',
			'pbs_vic'=>'Public Schools - VIC',
			'pbs_nt'=>'Public Schools - NT',
			'a_nsw'=>'Agent - NSW',
			'a_vic'=>'Agent - VIC',
			'a_nt'=>'Agent - NT',
			'a_o'=>'Agent - Overseas',
			'pvs_nsw'=>'Private Schools - NSW',
			'pvs_vic'=>'Private Schools - VIC',
			'pvs_nt'=>'Private Schools - NT'
			];
	}
		
	function clientGroupXeroAccountCodeList()
	{
		return [
			'uc_nsw'=>['invoice'=>'42120','po'=>'52420'],
			'uc_vic'=>['invoice'=>'42115','po'=>'52415'],
			'uc_nt'=>['invoice'=>'42125','po'=>'52425'],
			'pbs_nsw'=>['invoice'=>'42110','po'=>'52410'],
			'pbs_vic'=>['invoice'=>'42111','po'=>'52411'],
			'pbs_nt'=>['invoice'=>'42112','po'=>'52412'],
			'a_nsw'=>['invoice'=>'42120','po'=>'52420'],
			'a_vic'=>['invoice'=>'42115','po'=>'52415'],
			'a_nt'=>['invoice'=>'42125','po'=>'52425'],
			'a_o'=>['invoice'=>'42100','po'=>'52100'],
			'pvs_nsw'=>['invoice'=>'42120','po'=>'52420'],
			'pvs_vic'=>['invoice'=>'42115','po'=>'52415'],
			'pvs_nt'=>['invoice'=>'42125','po'=>'52425']
			];
	}

function checkIfBedEligibleForTripleShare($bed,$studentAcc,$dates)
{
	if(!userAuthorisations('triple_share_booking'))
		return false;
	if($studentAcc!=2)	
		return false;
		
	$obj=& get_instance();
	$obj->load->model('booking_model');
	return $obj->booking_model->checkIfBedEligibleForTripleShare($bed,$studentAcc,$dates);
}

function getBookingHoldPaymentInfo($bid,$type)
{
	$hp=array();
	$bookingDetails=bookingDetails($bid);
		
	$hp['hold_payment']=$bookingDetails['hold_payment'];
	
	$obj=& get_instance();
	$obj->load->model('booking_model');
	$hp['history']=$obj->booking_model->getBookingHoldPaymentHistory($bid,$type);
	
	return $hp;	
}

function shaCollegeNameMatched($shaId)
{
	$obj=& get_instance();
	$obj->load->model('sha_model');
	return $obj->sha_model->shaCollegeNameMatched($shaId);
}
	
function gstPercent()//GST on accomodation fee
  {
	  return 10;
  }

function find_closestDate($array, $date)
  {
	  foreach($array as $day)
		  $interval[] = abs(strtotime($date) - strtotime($day));
  
	  asort($interval);
	  $closest = key($interval);
  
	  return $array[$closest];
  }
?>