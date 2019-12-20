<?php
class Sha_matches extends CI_Controller {
	
		function __construct()
		{
			parent::__construct();
			$this->load->model('sha_matches_model');
		}
		
		function index()
		{
			if(checkLogin())
				$this->load->view('system/sha/filterMatchesResults');
			else
				echo "LO";
		}
	
		
	////////////// For data table server side STARTS
	public function ajax_list()
	{
		$list = $this->sha_matches_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		//echo $this->db->last_query();
		
		$checkIfStudentPlaced=false;
		$getDuplicateShaSet=getDuplicateShaSet($_POST['id']);
		foreach($getDuplicateShaSet as $duplicate)
		{
			$checkIfStudentPlaced=checkIfStudentPlaced($duplicate);
			if($checkIfStudentPlaced)
				break;
		}

		$shaOne=getshaOneAppDetails($_POST['id']);
		
		$nameTitleList=nameTitleList();
		$stateList=stateList();
		$hfaStatusList=hfaStatusList();
		$religionList=religionList();
		$matchedAppStatusList=matchedAppStatusList();
		$roomTypeList=roomTypeList();
		foreach ($list as $host) {
			//$step=hfaAppCheckStep($host->id);
			$step=$host->step;
			$docs=hfaDocs($host->id);
			$row = array();
			$hfaOne=getHfaOneAppDetails($host->id);
			$hfaTwo=getHfaTwoAppDetails($host->id);
			$hfaThree=getHfaThreeAppDetails($host->id);
			$hfaFour=getHfaFourAppDetails($host->id);
			//$getHfaThreeAppDetails=getHfaThreeAppDetails($host->id);
			
			$matchStatus=shaMatchStatus($_POST['id'],$host->id);
			//$matchStatusText=$matchedAppStatusList[$matchStatus];
			$matchStatusShortlistedClass=$matchStatusRejectedClass='matchStatusGrey';
			$matchStatusShortlistedToolTip='Shortlist';
			$matchStatusRejectedToolTip='Reject';
			if($matchStatus==2)
			{
				$matchStatusShortlistedClass='matchStatusGreen';
				$matchStatusShortlistedToolTip='Shortlisted';
			}
			if($matchStatus==3)
			{
				$matchStatusRejectedClass='matchStatusRed';
				$matchStatusRejectedToolTip='Rejected';
			}
			
			  //1st Column: HOST #STATRS
			  $row1='<a href="'.site_url().'hfa/application/'.$host->id.'" target="_blank">'.ucfirst($host->lname).' Family'.'</a>';
			  $row1 .='<br />';
			   
			  if($host->title!=0)
				  $row1 .=$nameTitleList[$host->title].' ';
			  $row1 .=ucwords($host->fname.' '.$host->lname);
				
			  $row1 .='<br>';
				
			  $addressForMap='';
			  if($host->street!='')
				$addressForMap .=$host->street.", ";
			  $addressForMap .=ucfirst($host->suburb).", ".$stateList[$host->state].", ".$host->postcode;
			  $row1 .=getMapLocationLink($addressForMap);
			  
			  //testing
			  /*if(isset($hfaThree['memberDetails']))
			  {
				 foreach($hfaThree['memberDetails'] as $sd)
				 {
					 $expired='';
					 if($sd['wwcc']=='1' && $sd['wwcc_clearence']=='1' && strtotime($sd['wwcc_expiry'])<strtotime(date('Y-m-d')))
						 $expired	=' - Expired';
					$row1 .='<br>age='.age_from_dob($sd['dob']).',wwcc='.$sd['wwcc'].', clearence='.$sd['wwcc_clearence'].', expiry='.$sd['wwcc_expiry'].$expired; 
				}
			  }*/
			  //testing #ENDS
			  
			//1st Column: HOST #ENDS
			
			$row[] = $row1;
			
			//2nd Column: CONTACT #STARTS
			$row2='<span class="hold-inline-icon">'.$host->email;
            if($host->contact_way==2)
				$row2 .='<i class="material-icons contactWayGreenTic" data-placement="bottom"  data-toggle="tooltip"  data-original-title="Email preferred"  style="cursor:default;">chevron_left</i>';
			
			$row2 .='</span>';
            $row2 .='<br>';
            $row2 .='<span class="hold-inline-icon">'.$host->mobile;
            if($host->contact_way==1)
                    $row2 .='<i class="material-icons contactWayGreenTic" data-placement="bottom"  data-toggle="tooltip"  data-original-title="Phone call preferred" style="cursor:default;">chevron_left</i>';
			
			$row2 .='</span>';
            if($host->contact_time!='00:00:00')
					$row2 .='<br>Best time to call: '.date('g:i A',strtotime($host->contact_time));
			
			/*$row2='Pets: ';
			if($hfaThree['pets']=="0")
                $row2 .= "No";
			elseif($hfaThree['pets']=="1")
				$row2 .="Yes";
			
			$row2 .="<br>Age: ";	
			if($hfaFour['age_pref']=='1')
				$row2 .= "Under 18";
			elseif($hfaFour['age_pref']=='2')
				$row2 .= "Over 18";
			elseif($hfaFour['age_pref']=='3')
				$row2 .= "No preference";	
			
			$row2 .="<br>Smoking: ";
			if($hfaFour['smoker_students']!="")
                 $row2 .= $smokingHabbits[$hfaFour['smoker_students']];
			else
				$row2 .= 'n/a';
			
			$row2 .="<br>Gender: ";
			if($hfaFour['gender_pref']=='1')
				$row2 .= "Male";
			elseif($hfaFour['gender_pref']=='2')
				$row2 .= "Female";
			elseif($hfaFour['gender_pref']=='3')
				$row2 .= "No preference";	
			
			$row2 .="<br> Members age: ";
			$ddobsql="select * from `hfa_members` where `application_id`='".$host->id."'";
			$ddobquery=$this->db->query($ddobsql);
			$dobqueryResult=$ddobquery->result_array();
			foreach($dobqueryResult as $rrs)
			{
				$row2 .=age_from_dob($rrs['dob']).", ";
			}*/
												
			//2nd Column: CONTACT #ENDS
			
			$row[] = $row2;
			
			
			//3rd Column: STATUS #STARTS
				/*$row4='<button class="mt-n mb-xs btn btn-sm btn-label" data-toggle="modal" data-target="#model_ChangeStatusMatchedApp"  onclick="matchedAppChangeStatusPopContent('.$_POST['id'].','.$host->id.');" id="changeStatusHfaEditBtn-">';
					  $row4 .='<i class="material-icons font14">edit</i>';
					  $row4 .='<span>Change</span>';
				$row4 .='</button>';
				$row4 .='<br />';
				$row4 .='<span class="ml-lg shaMatchStatus-hol shaMatchStatus-'.str_replace(' ','_',$matchStatusText).'">';
					$row4 .='<i class="fa fa-stop"></i>';
					$row4 .='<span>'.$matchStatusText.'</span>';
				$row4 .='</span>';*/
				
				$row4 ='<i class="fa fa-check '.$matchStatusShortlistedClass.'" data-placement="bottom"  data-toggle="tooltip"  data-original-title="'.$matchStatusShortlistedToolTip.'" onclick="matchedAppShorlist($(this),'.$_POST['id'].','.$host->id.');"></i>';
				$row4 .='<i class="fa fa-times '.$matchStatusRejectedClass.'" data-placement="bottom"  data-toggle="tooltip"  data-original-title="'.$matchStatusRejectedToolTip.'" onclick="matchedAppReject($(this),'.$_POST['id'].','.$host->id.');"></i>';
				if($host->hfa_bookmark=='0')
				{
					$matchStatusShortlistedClass='matchStatusGrey';
					$matchStatusShortlistedToolTip='Click to bookmark';
				}
				else
				{
					$matchStatusShortlistedClass='matchStatusGreen';
					$matchStatusShortlistedToolTip='bookmarked';
				}
				$row4.='<i class="fa fa-bookmark '.$matchStatusShortlistedClass.'" data-placement="bottom"  data-toggle="tooltip"  data-original-title="'.$matchStatusShortlistedToolTip.'"  onclick="hostfamilybookmark($(this),'.$host->id.');"></i>';
				$incidentsByHfaId=incidentsByHfaId($host->id);
				if(!empty($incidentsByHfaId))
					$row4.='<i class="fa fa fa-info actionIconOrange" data-placement="bottom"  data-toggle="tooltip"  data-original-title="'.count($incidentsByHfaId).' incident'.s(count($incidentsByHfaId)).' reported"></i>';
				
				$warningsSent=warningsByHfaIdCount($host->id);
				if($warningsSent>0)
				{
					if($warningsSent>3)
						$warningIconToolTip ='More than 3';
					else
						$warningIconToolTip =$warningsSent;	
					$warningIconToolTip .=' warning'.s($warningsSent).' sent';	
					$row4.='<i class="fa fa fa-warning actionIconOrange" data-placement="bottom"  data-toggle="tooltip"  data-original-title="'.$warningIconToolTip.'"></i>';
				}
						
				$row[] = $row4;                      
			//3rd Column: STATUS #ENDS
			
			
			//4th Column: ACTIONS #STARTS
			$row3='<div class="btn-group dropdown table-actions">';
			if($shaOne['step']=='4')
			{
                          $row3 .='<button class="btn btn-sm btn-midnightblue dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="true">';
                              $row3 .='<i class="colorBlue material-icons">more_horiz</i>';
                              $row3 .='<div class="ripple-container"></div>';
                          $row3 .='</button>';
                          $row3 .='<ul class="dropdown-menu" role="menu">';
						  if(!$checkIfStudentPlaced)
							  $row3 .='<li><a href="javascript:;" data-toggle="modal" data-target="#model_PlaceBookingMatchedApp" onclick="matchedAppPlaceBookingPopContent('.$_POST['id'].','.$host->id.');"><i class="font16 material-icons">place</i>&nbsp;&nbsp;Place booking</a></li>';
						  else
							  $row3 .='<li><a href="javascript:void(0);" data-toggle="modal" data-target="#model_PlaceBookingMatchedApp" onclick="matchedAppPlaceBookingPopContentCH('.$_POST['id'].','.$host->id.');"><i class="font16 material-icons">place</i>&nbsp;&nbsp;Change homestay</a></li>';
							  
                            $row3 .='</ul>';
			}
			else
				$row3 .='<i class=" material-icons matchStatusGrey">more_horiz</i>';
                          $row3 .='</div>';
			//4th Column: ACTIONS #ENDS
			
			$row[] = $row3;
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->sha_matches_model->count_all(),
						"recordsFiltered" => $this->sha_matches_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	////////////// For data table server side ENDS	
	
	function matchedAppChangeStatusSubmit()
	{
		if(checkLogin())
				{
					$this->sha_matches_model->matchedAppChangeStatusSubmit($_POST);
				}
			else
				echo "LO";
	}	

	function matchedAppChangeStatus()
	{
		if(checkLogin())
					$this->sha_matches_model->matchedAppChangeStatusSubmit($_POST);
		else
				echo "LO";
	}
	
	function selectRoomTypeByAccomodationType($accType='')
	{
		if($accType=='')
			{
				$checkboxes='0';
				$desc='';
			}
		else	
			{
				$roomTypeList=roomTypeList();
				$roomType=roomTypeByAccomodationType($accType);
				$checkboxes=implode(',',roomTypeByAccomodationType($accType));
				
				$desc=roomTypeByAccomodationTypeDesc($roomType,$accType);
			}
			
		$return['checkboxes']=$checkboxes;
		$return['desc']=$desc;
		echo json_encode($return);
	}
	
	function changeDescByRoomTypeFilterMatches()
	{
		if($_POST['roomType']!='')
			$roomType=explode(',',$_POST['roomType']);
		else	
			$roomType=array();
		$desc=roomTypeByAccomodationTypeDesc($roomType,$_POST['accType']);
		echo $desc;
	}
		
}
