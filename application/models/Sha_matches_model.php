<?php 

class Sha_matches_model extends CI_Model { 


	////////////// For data table server side STARTS
	
	var $table = 'hfa_one';
	var $column_order = array('lname','email'); //set column field database for datatable orderable
	var $column_search = array(); //set column field database for datatable searchable 
	var $order = array('date_status_changed' => 'desc'); // default order
	
	private function _get_datatables_query()
	{//see($_POST);
		$formOne=getShaOneAppDetails($_POST['id']);
		$ageStudent=age_from_dob($formOne['dob']);
		$stateabrivation=stateabrivation();
		$excludeHost=array(0);
		
		$studentBookingDates['from']=$studentBookingDates['to']='';
		if($formOne['booking_from']!='0000-00-00')
	  		$studentBookingDates['from']=$formOne['booking_from'];
  		if($formOne['booking_to']!='0000-00-00')
	  		$studentBookingDates['to']=$formOne['booking_to'];
		
		//wwcc condtion starts
		//if((isset($_POST['wwcc']) && $_POST['wwcc']!='0') && $ageStudent<18 && ($_POST['filterMatchesEditWWCC_clearence']=='0' || $_POST['filterMatchesEditWWCC_expired']=='0' || $_POST['filterMatchesEditWWCC_oneMember']=='0'))
		if((isset($_POST['wwcc']) && $_POST['wwcc']!='0') && $ageStudent<18 /*&& ($_POST['filterMatchesEditWWCC_clearence']=='0' || $_POST['filterMatchesEditWWCC_expired']=='0' )*/ /*&& $_POST['filterMatchesEditWWCC_oneMember']!='1'*/)
			{
				/*$sql_wwcc="select `application_id` from `hfa_members` where (DATEDIFF('".date('Y-m-d')."', `hfa_members`.`dob`) / 365.25  > 18) and (";
				
				$sql_wwcc .="`wwcc`='0' ";
				if($_POST['filterMatchesEditWWCC_clearence']=='0')				
					$sql_wwcc .="OR `wwcc_clearence`='0' ";
				if($_POST['filterMatchesEditWWCC_expired']=='0')
					$sql_wwcc .="OR `wwcc_expiry`<'".date('Y-m-d')."'";
				$sql_wwcc .=")  group by `application_id`";
				$query_wwcc=$this->db->query($sql_wwcc);//echo $this->db->last_query();
				$res_wwcc=$query_wwcc->result_array();*/
				
				$resOneMember=array();
				if($_POST['filterMatchesEditWWCC_oneMember']=='1')
				{
						$sqlOneMember="SELECT `hfa_members`.`application_id` FROM `hfa_members` WHERE `hfa_members`.`wwcc`='1' and `hfa_members`.`wwcc_clearence`='1' and `hfa_members`.`wwcc_expiry`>'".date('Y-m-d')."'";
						$queryOneMember=$this->db->query($sqlOneMember);
						
						if($queryOneMember->num_rows()>0)
						{
							$resOneMember=$queryOneMember->result_array();
							foreach($resOneMember as $resOM)
								$resOneM[]=$resOM['application_id'];
						}
				}
				
				$sql_wwcc="select `application_id` from `hfa_members` where (DATEDIFF('".date('Y-m-d')."', `hfa_members`.`dob`) / 365.25  > 18) and (";
				
				$sql_wwcc .="`wwcc`='0' ";
				if($_POST['filterMatchesEditWWCC_clearence']=='0')				
					$sql_wwcc .="OR `wwcc_clearence`='0' ";
				if($_POST['filterMatchesEditWWCC_expired']=='0')
					$sql_wwcc .="OR (`wwcc_expiry`<'".date('Y-m-d')."' and `wwcc_clearence`='1')";
				$sql_wwcc .=")  ";
				if(!empty($resOneMember))
					$sql_wwcc .=" and   `application_id` NOT IN('".implode("','",$resOneM)."')";
				$sql_wwcc .=" group by `application_id`";
				
				$query_wwcc=$this->db->query($sql_wwcc);//echo $this->db->last_query();
				$res_wwcc=$query_wwcc->result_array();
				
				
				foreach($res_wwcc as $res_wwccV)
					$excludeHost[]=$res_wwccV['application_id'];
			}
		//wwcc condition ends
		
		
		if((isset($_POST['child']) && $_POST['child']!='0') && ($_POST['filterMatchesEditChild11']=="0" || $_POST['filterMatchesEditChild20']=="0"))
		{
			$sqlChild="select `application_id` from `hfa_members` ";
			
			if($_POST['filterMatchesEditChild11']=="0")
			{
				$sqlChild11=$sqlChild." where  (DATEDIFF('".date('Y-m-d')."', `hfa_members`.`dob`) / 365.25  < 12) ";
				$query11=$this->db->query($sqlChild11);
				$res11=$query11->result_array();
				//echo $this->db->last_query();
				foreach($res11 as $res11V)
				$excludeHost[]=$res11V['application_id'];
			}
			
			if($_POST['filterMatchesEditChild20']=="0")
			{
				$sqlChild20=$sqlChild." where  (DATEDIFF('".date('Y-m-d')."', `hfa_members`.`dob`) / 365.25   BETWEEN 12 and 21) ";
				$query20=$this->db->query($sqlChild20);
				$res20=$query20->result_array();
				//echo $this->db->last_query();
				foreach($res20 as $res20V)
				$excludeHost[]=$res20V['application_id'];
			}
		}
		
		if((isset($_POST['smokerFamily']) && $_POST['smokerFamily']!='0')  && !in_array($_POST['filterMatchesEditSmokerFamily'],array('','2')))
		{
			if($_POST['filterMatchesEditSmokerFamily']=='0')
				$smokeConditionFamily="'1','2'";
			elseif($_POST['filterMatchesEditSmokerFamily']=='1')
				$smokeConditionFamily="'2'";
			$sqlSmokerFamily="select `application_id` from `hfa_members` where `smoke` IN (".$smokeConditionFamily.")";
			$querySmokerFamily=$this->db->query($sqlSmokerFamily);
			$resSmokerFamily=$querySmokerFamily->result_array();
			//echo $this->db->last_query();
			foreach($resSmokerFamily as $resSmokerFamilyV)
				$excludeHost[]=$resSmokerFamilyV['application_id'];
		}
		
		
		//Exclude booked beds #STARTS
			$sqlBookedBooking="select * from `bookings` where `status`!='cancelled' and `status`!='moved_out'";
			////
			$sqlBookedBooking .=checkIfBedBookedExtraSql($studentBookingDates);
			
			/////
			//$sqlBookedBooking="select * from `bookings` ";
			$queryBookedBooking=$this->db->query($sqlBookedBooking);//echo $sqlBookedBooking;
			$resBookedBooking=$queryBookedBooking->result_array();
			foreach($resBookedBooking as $rbbV)
			{
				///////
				$excludeThisBed=true;
				//check if bed is twin or double
				$sqlTwinBed="select * from `hfa_bedrooms` where `id`='".$rbbV['room']."' and `type` IN('2','3')";
				$sqlTwinBedQuery=$this->db->query($sqlTwinBed);
				if($sqlTwinBedQuery->num_rows()>0)
				{
					$sqlStudent=getshaOneAppDetails($rbbV['student']);
					if($sqlStudent['accomodation_type']=='1' || $sqlStudent['accomodation_type']=='4')//if a student with single room as acc type is placed in a double room then that room will not be shown in search till that student is living there
						$excludeThisBed=true;
					else
					{
						//check if twin bed is booked in another booking
						$sqlTwinBedBooking="select * from `bookings` where `host`='".$rbbV['host']."' and `room`='".$rbbV['room']."' and `id`!='".$rbbV['id']."' and `status`!='cancelled' and `status`!='moved_out'";
						$sqlTwinBedBookingQuery=$this->db->query($sqlTwinBedBooking);
						if($sqlTwinBedBookingQuery->num_rows()>0)
							$excludeThisBed=true;
						else
							$excludeThisBed=false;
							
						if(in_array($_POST['filterMatchesEditAccomodation_type'],array('1','3','4','5')))//if a student with double room as acc type is placed in a double room then that room will not be shown in search for a student with acc type single till that student is living there
							$excludeThisBed=true;
					}
				}
				else
				{// the case of single/twin bed type
					$sqlSingleTwinBed="select * from `hfa_bedrooms` where `id`='".$rbbV['room']."' and `type` IN('4')";
					$sqlSingleTwinBedQuery=$this->db->query($sqlSingleTwinBed);
					if($sqlSingleTwinBedQuery->num_rows()>0)
					{
						$studentSingleTwinBed=getshaOneAppDetails($rbbV['student']);
						if($studentSingleTwinBed['accomodation_type']=='2')
						{
							$sqlBookedBookingSingleTwin="select * from `bookings` where `room`='".$rbbV['room']."' and `status`!='cancelled' and `status`!='moved_out'";
							$sqlBookedBookingSingleTwinQuery=$this->db->query($sqlBookedBookingSingleTwin);
							if($sqlBookedBookingSingleTwinQuery->num_rows()>1)
								$excludeThisBed=true;
							else	
							{
								//$excludeThisBed=false;
								
								if($_POST['filterMatchesEditAccomodation_type']=='2')
								$excludeThisBed=false;
								else
								$excludeThisBed=true;
							}
						}
						else
							$excludeThisBed=true;
					}
					
				}
				//////
				
				$sqlBookedBookingBeds="select * from `hfa_bedrooms` where `id`!='".$rbbV['room']."' and `application_id`='".$rbbV['host']."'";
				//Check if there is any other room with the same host
				$queryBookedBookingBeds=$this->db->query($sqlBookedBookingBeds);
				if($queryBookedBookingBeds->num_rows()==0)
					{
						if($excludeThisBed)
							$excludeHost[]=$rbbV['host'];
					}
				else
				{
					$resBookedBookingBeds=$queryBookedBookingBeds->result_array();
					$resBookedBookingBedsLeft=array();
					foreach($resBookedBookingBeds as $rbbbV)
						$resBookedBookingBedsLeft[]=$rbbbV['id'];
					

					$sql="select * from `bookings` where `host`='".$rbbV['host']."' and `room` IN('".implode("','",$resBookedBookingBedsLeft)."')";
					$sql_left=checkIfBedBookedExtraSql($studentBookingDates);
					$sql .=$sql_left;
					//check if all the rooms of the host are booked or not
					$query=$this->db->query($sql);
					//echo $this->db->last_query();
					if($query->num_rows()==count($resBookedBookingBedsLeft))
						$excludeHost[]=$rbbV['host'];
				}	
			}
		//Exclude booked beds #ENDS
		
		$includeHost=array();
		$includeHostAType=array();
		
		$whereSelf_catered='';
		if((isset($_POST['accomodation_type']) && $_POST['accomodation_type']!='0' && $_POST['filterMatchesEditAccomodation_type']!='0'))
		{
			$aType=$_POST['filterMatchesEditAccomodation_typeRoomType'];
				
			if($_POST['filterMatchesEditAccomodation_type']=='4' || $_POST['filterMatchesEditAccomodation_type']=='5')
				$aInEnsuit='1';
			else
				$aInEnsuit='';
				
			$sqlAType="select * from `hfa_bedrooms` where `type`  IN (".$aType.") ";
			/*if($aInEnsuit=='1')
				$sqlAType .=" and  `internal_ensuit`='1'";					
			else	
				$sqlAType .=" and (`internal_ensuit`='0'  OR `internal_ensuit`='')";*/
			if($aInEnsuit=='1')
				$sqlAType .=" and  `vip`='1'";					
			/*else	
				$sqlAType .=" and `vip`='0'";*/
			
			if($_POST['filterMatchesEditAccomodation_typeGrannyFlat']=='0')
				$sqlAType .=" and (`access`='0' OR `access`='' OR (`access`='1' and `granny_flat`='0'))";
			
			if($_POST['filterMatchesEditAccomodation_type']=='3' || $_POST['filterMatchesEditAccomodation_type']=='5')
				$whereSelf_catered=" and `hfa_one`.`self_catered`='1'";
			
			$queryAType=$this->db->query($sqlAType);
			//echo $this->db->last_query();
			$resAType=$queryAType->result_array();
			if(empty($resAType))
				$includeHostAType=array(0);
			else	
				foreach($resAType as $resATV)
				{
					if(!checkIfBedBooked($resATV['id'],$_POST['filterMatchesEditAccomodation_type'],$studentBookingDates))
					{
						///////
						/*if($resATV['type']=='4')
							{
								if($_POST['filterMatchesEditAccomodation_type']=='2')
								
							}
						else
							$includeHostAType[]=$resATV['application_id'];*/
						/////
						
						$includeHostAType[]=$resATV['application_id'];
					}
				}
		}
		
		if($_POST['filterMatchesStatus']!='all')
		{
			$sqlStatus="select * from `sha_matches_status` where `id`='".$_POST['id']."'";
			$queryStatus=$this->db->query($sqlStatus);
			$resStatus=$queryStatus->row_array();
			if(!empty($resStatus))
			{
				if($_POST['filterMatchesStatus']==1)
					$excludeHost=array_merge($excludeHost,explode(',',$resStatus['shortlisted']),explode(',',$resStatus['rejected']));
				elseif($_POST['filterMatchesStatus']==2)
					$includeHost=explode(',',$resStatus['shortlisted']);
				elseif($_POST['filterMatchesStatus']==3)
					$includeHost=explode(',',$resStatus['rejected']);
			}
		}
		
		//Language
		$includeHostLanguage=array();
		if((isset($_POST['language']) && $_POST['language']!='0') && $_POST['filterMatchesEditLanguage']!="")
		{
			//$sqlLang="select * from `hfa_members_language` where `language`='".$_POST['filterMatchesEditLanguage']."'";
			$sqlLang="select `hfa_members_language`.* from `hfa_members_language` JOIN `hfa_members` ON (`hfa_members`.`id`=`hfa_members_language`.`member_id`) where `hfa_members_language`.`language`='".$_POST['filterMatchesEditLanguage']."' order by `hfa_members_language`.`id`";
			$queryLang=$this->db->query($sqlLang);//echo $this->db->last_query();
			$resQueryLang=$queryLang->result_array();
			
			foreach($resQueryLang as $rLang)
				$includeHostLanguage[]=$rLang['application_id'];
			//see($includeHostLanguage);
			if(!empty($includeHostLanguage))
			{
				if(!empty($includeHostAType))
					$includeHostAType=array_intersect($includeHostAType,$includeHostLanguage);
				else
					$includeHostAType=$includeHostLanguage;
			}
			else
				$includeHostAType=array(0);	
		}
		
		//see($includeHost);
		//see($includeHostAType);
		if(!empty($includeHost) && !empty($includeHostAType))
			$includeHost=array_intersect($includeHost,$includeHostAType);//to get common from results acc to accomodation type and status filters
		elseif(empty($includeHost))
			$includeHost=$includeHostAType;
		
		if(empty($includeHost) && $_POST['filterMatchesStatus']!='all' && $_POST['filterMatchesStatus']!=1)
			$includeHost=array(0);
			
		//echo 'res';see($includeHost);
		$this->db->select('hfa_one.*');
		$this->db->distinct();
		$this->db->from($this->table);
		
		$where=	" `status` like 'approved' and `step`='5' ";
		
		$whereHostName='';
		if( !empty($_POST['filterMatchesStatus']) && $_POST['filterMatchesStatus']==4 ){
			$whereHostName.= "and (`hfa_one`.`hfa_bookmark`='1')";
		}
		if((isset($_POST['hostName']) && $_POST['hostName']!='0'))
		{
			if(trim($_POST['filterMatchesEditFname'])!="")
				$whereHostName .=	" and (`hfa_one`.`fname` like'%".trim($_POST['filterMatchesEditFname'])."%' ) ";
			if(trim($_POST['filterMatchesEditLname'])!="")
				$whereHostName .=	" and (`hfa_one`.`lname` like '%".trim($_POST['filterMatchesEditLname'])."%' ) ";
		}
		
		$hostNameSearchAll='0';
		if((isset($_POST['hostName']) && $_POST['hostName']!='0') && ($_POST['filterMatchesEditFname']!="" || $_POST['filterMatchesEditLname']!=""))
		{
			if($_POST['hostNameSearchAll']=='all')
				$hostNameSearchAll='1';
			else
				$hostNameSearchAll='0';
		}
		
		if($hostNameSearchAll!='1')
		{
			  if((isset($_POST['cApproval']) && $_POST['cApproval']!='0') && !empty($_POST['filterMatchesEditCApproval']))
				  {
					  $queryCApproval=$this->db->query("select `hfa_id` from `hfa_college_approval` where `college_id` IN (".$_POST['filterMatchesEditCApproval'].")");
					  $cAHfa=array();
					  foreach($queryCApproval->result_array() as $cAH)
						  $cAHfa[]=$cAH['hfa_id'];
					  $cAHfa[]=0;	
					  $this->db->where_in('`hfa_one`.`id`',$cAHfa);						
				  }
			
		if((isset($_POST['arrival_date']) && $_POST['arrival_date']!='0') && $_POST['arrival_date']=="1" && $_POST['filterMatchesEditArrivalDate']!='')
			$this->db->join('hfa_bedrooms', 'hfa_one.id = hfa_bedrooms.application_id');
		
		if(((isset($_POST['pets']) && $_POST['pets']!='0') /*&& $_POST['filterMatchesEditPets']=="0"*/) || ((isset($_POST['religion']) && $_POST['religion']!='0') && $_POST['filterMatchesEditReligion']!="") )
			$this->db->join('hfa_three', 'hfa_one.id = hfa_three.id');
			
		if((isset($_POST['age']) && $_POST['age']!='0')  || (isset($_POST['gender']) && $_POST['gender']!='0') || ((isset($_POST['smoker']) && $_POST['smoker']!='0') && $_POST['filterMatchesEditSmoker']!='' && $_POST['filterMatchesEditSmoker']!='0')  || ((isset($_POST['dietReq']) && $_POST['dietReq']!='0') && $_POST['filterMatchesEditDietReq']!='' && $_POST['filterMatchesEditDietReq']!='0')   || ((isset($_POST['allergy']) && $_POST['allergy']!='0') && $_POST['filterMatchesEditAllergy']!='' && $_POST['filterMatchesEditAllergy']!='0')    || ((isset($_POST['disability']) && $_POST['disability']!='0') && $_POST['filterMatchesEditDisability']!='' && $_POST['filterMatchesEditDisability']!='0') )
			$this->db->join('hfa_four', 'hfa_one.id = hfa_four.id');
			
		//if(((isset($_POST['wwcc']) && $_POST['wwcc']!='0') && $ageStudent<18))
		//if((isset($_POST['wwcc']) && $_POST['wwcc']!='0') && $ageStudent<18 && $_POST['filterMatchesEditWWCC_oneMember']=='1')
/*		if((isset($_POST['wwcc']) && $_POST['wwcc']!='0') && ($ageStudent<18 && $_POST['filterMatchesEditWWCC_oneMember']=='1' && ($_POST['filterMatchesEditWWCC_clearence']=='0' || $_POST['filterMatchesEditWWCC_expired']=='0')))
			$this->db->join('hfa_members', 'hfa_one.id = hfa_members.application_id');
		else if((isset($_POST['wwcc']) && $_POST['wwcc']!='0') && $ageStudent<18 && ($_POST['filterMatchesEditWWCC_clearence']=='1' && $_POST['filterMatchesEditWWCC_expired']=='1' && $_POST['filterMatchesEditWWCC_oneMember']=='1'))
			$this->db->join('hfa_members', 'hfa_one.id = hfa_members.application_id');*/
		
		if( (isset($_POST['wwcc']) && $_POST['wwcc']!='0') &&  $ageStudent<18 && $_POST['filterMatchesEditWWCC_oneMember']=='1' )
			$this->db->join('hfa_members', 'hfa_one.id = hfa_members.application_id');	
		
		}
		
		$where .=$whereHostName;
		
		if($hostNameSearchAll!='1')
		{
				$whereSuburb='';
				$getStateNameFromSuburbId='';
				if((isset($_POST['suburb']) && $_POST['suburb']!='0') && $_POST['filterMatchesEditSuburb']!="")
				{
					//$where .=	" and (`suburb` like '".$_POST['filterMatchesEditSuburb']."') ";
					$getSuburbNameFromId=getSuburbNameFromId($_POST['filterMatchesEditSuburbId']);
					/*if($getSuburbNameFromId!='')
						$where .=	" and (`suburb` like '".$getSuburbNameFromId."') ";*/
						
					if($getSuburbNameFromId!='')
						$whereSuburb .=	" (`suburb` like '".$getSuburbNameFromId."') ";	
					
					$getStateNameFromSuburbId=getStateNameFromSuburbId($_POST['filterMatchesEditSuburbId']);
				}
				
					$whereState='';
					if((isset($_POST['state']) && $_POST['state']!='0') && !empty($_POST['filterMatchesEditState'])){
					$stat= $_POST['filterMatchesEditState'] ;
					
					$d=explode(",",$_POST['filterMatchesEditState']);
					$tmp=array();
					foreach($d as $v){
						if($getStateNameFromSuburbId!=$stateabrivation[$v])
							$tmp[]=$stateabrivation[$v];
					}
					 $strav = "'" . implode ( "', '", $tmp ) . "'";
					
					$tempSta=array();
					foreach(explode(',',$stat) as $sta)
					{
						if($getStateNameFromSuburbId!=$stateabrivation[$sta])
							$tempSta[]=$sta;
					}
					$result_string = "'" .implode("','",$tempSta)."'"; 
				 	//$result_string = "'" . str_replace(",", "','", @$stat) . "'"; 
		/*
					$where .=" and  (`hfa_one`.`state` IN ($result_string)  or `hfa_one`.`state` IN ($strav)  ";
					 foreach($d as $v){
						//$tmp[]=$stateabrivation[$v];
						$where .=" or  `hfa_one`.`street` like '%".$v."'  or `hfa_one`.`street`  like '%".$stateabrivation[$v]."' ";
					}
					$where .=")";*/
					
					if($result_string!="''")
					{
						$whereState .=" (`hfa_one`.`state` IN ($result_string)  or `hfa_one`.`state` IN ($strav)  ";
					 	foreach($d as $v){
							if($getStateNameFromSuburbId!=$stateabrivation[$v])
								$whereState .=" or  `hfa_one`.`street` like '%".$v."'  or `hfa_one`.`street`  like '%".$stateabrivation[$v]."' ";
					 	}
						$whereState .=")";
					}
					
				}
				
				if($whereSuburb!='' || $whereState!='')
				{
					$where .=" and ";
					$suburbState=false;
					if($whereSuburb!='' && $whereState!='')
						$suburbState=true	;
					if($suburbState)	
						$where .="(";	
					$where .=$whereSuburb;
					if($suburbState)	
						$where .=" OR ";	
					$where .=$whereState;
					if($suburbState)	
						$where .=")";	
				}
			}
		
		if($hostNameSearchAll!='1')
		{
		if((isset($_POST['arrival_date']) && $_POST['arrival_date']!='0') && $_POST['arrival_date']=="1" && $_POST['filterMatchesEditArrivalDate']!='')
			$where .=	" and ((`avail`='1') OR (`avail`='0' and `avail_from`<='".normalToMysqlDate($_POST['filterMatchesEditArrivalDate'])."')) ";

		//if((isset($_POST['pets']) && $_POST['pets']!='0') && $_POST['filterMatchesEditPets']=="0")
			//$where .=	" and (`pets`='".$_POST['filterMatchesEditPets']."') ";
			
		
		if((isset($_POST['pets']) && $_POST['pets']!='0'))
		{
			if($_POST['filterMatchesEditPets']=="0")
				$where .=	" and (`pets`='".$_POST['filterMatchesEditPets']."') ";
			if($_POST['filterMatchesEditPets']=="1")
			{
				$where .=	" and (`pets`='0' OR (`pets`='".$_POST['filterMatchesEditPets']."' ";
				$petsType=explode(',',$_POST['petsType']);
				$petsNotSelected=array_diff(['dog','bird','cat'], $petsType);
				if(!empty($petsNotSelected))
				{
					if(count($petsNotSelected)!=3)
					{
						$where .=	" and ( 1=1 ";
						if(in_array('dog',$petsNotSelected))
							$where .=	" and `pet_dog`!='1' ";
						if(in_array('bird',$petsNotSelected))
							$where .=	" and `pet_bird`!='1' ";
						if(in_array('cat',$petsNotSelected))
							$where .=	" and `pet_cat`!='1' ";	
						$where .=	") ";		
					}
				}
				if($_POST['petsLiveInside']=='0')
					$where .=	" and (`pet_inside`!='1') ";	
				$where .=	"))";
			}
		}
		
		if(isset($_POST['age']) && $_POST['age']!='0')
		{
			if($ageStudent<18)
				$agePref=2;
			else	
				$agePref=1;
			
			$where .=	" and (`hfa_four`.`age_pref` !='".$agePref."') ";
		}
		
		///if((isset($_POST['wwcc']) && $_POST['wwcc']!='0') && $ageStudent<18)
		//if((isset($_POST['wwcc']) && $_POST['wwcc']!='0') && $ageStudent<18 && ($_POST['filterMatchesEditWWCC_clearence']=='1' && $_POST['filterMatchesEditWWCC_expired']=='1' && $_POST['filterMatchesEditWWCC_oneMember']=='1'))
		/*if((isset($_POST['wwcc']) && $_POST['wwcc']!='0') && ($ageStudent<18 && $_POST['filterMatchesEditWWCC_oneMember']=='1' && ($_POST['filterMatchesEditWWCC_clearence']=='0' || $_POST['filterMatchesEditWWCC_expired']=='0')))
			$where .=	" and ((`hfa_members`.`wwcc`='1' and `hfa_members`.`wwcc_expiry`>='".date('Y-m-d')."' and `hfa_members`.`wwcc_clearence`='1') OR (DATEDIFF('".date('Y-m-d')."', `hfa_members`.`dob`) / 365.25  <= 18) ) ";
		else if((isset($_POST['wwcc']) && $_POST['wwcc']!='0') && $ageStudent<18 && ($_POST['filterMatchesEditWWCC_clearence']=='1' && $_POST['filterMatchesEditWWCC_expired']=='1' && $_POST['filterMatchesEditWWCC_oneMember']=='1'))
			$where .=	" and (`hfa_members`.`wwcc`='1' OR (DATEDIFF('".date('Y-m-d')."', `hfa_members`.`dob`) / 365.25  <= 18) ) ";*/
		if( (isset($_POST['wwcc']) && $_POST['wwcc']!='0') &&  $ageStudent<18 && $_POST['filterMatchesEditWWCC_oneMember']=='1' )
			$where .=" and ((`hfa_members`.`wwcc`='1' and `hfa_members`.`wwcc_expiry`>='".date('Y-m-d')."' and `hfa_members`.`wwcc_clearence`='1') OR (DATEDIFF('".date('Y-m-d')."', `hfa_members`.`dob`) / 365.25  <= 18) ) ";
		
		if((isset($_POST['smoker']) && $_POST['smoker']!='0') && $_POST['filterMatchesEditSmoker']!='' && $_POST['filterMatchesEditSmoker']!='0')
		{
			$smokeCondition="'2',''";
			if($_POST['filterMatchesEditSmoker']=='1')
				$smokeCondition .=",'1'";
			$where .=	" and (`hfa_four`.`smoker_students` IN(".$smokeCondition.")) ";
		}
		
		if((isset($_POST['deitReq']) && $_POST['deitReq']!='0') && $_POST['filterMatchesEditDeitReq']=="1")
		{
			$where .=	" and (`hfa_four`.`diet_student`='".$_POST['filterMatchesEditDeitReq']."' OR `hfa_four`.`diet_student`='' ) ";
		}
		
		if((isset($_POST['allergy']) && $_POST['allergy']!='0') && $_POST['filterMatchesEditAllergy']=="1")
		{
			$where .=	" and (`hfa_four`.`allergic_students`='".$_POST['filterMatchesEditAllergy']."' OR `hfa_four`.`allergic_students`='' ) ";
		}
		
		if((isset($_POST['disability']) && $_POST['disability']!='0') && $_POST['filterMatchesEditDisability']=="1")
		{
			$where .=	" and (`hfa_four`.`disable_students`='".$_POST['filterMatchesEditDisability']."'  OR `hfa_four`.`disable_students`='' ) ";
		}
		
		if((isset($_POST['gender']) && $_POST['gender']!='0'))
		{
			if($formOne['gender']==1)
				$genderPrefNot=2;
			else	
				$genderPrefNot=1;
				
			$where .=	" and (`hfa_four`.`gender_pref` !=('".$genderPrefNot."')) ";
		}
		
		if((isset($_POST['religion']) && $_POST['religion']!='0') && $_POST['filterMatchesEditReligion']!="")
		{
			 $where .=	" and (`hfa_three`.`main_religion`='".$_POST['filterMatchesEditReligion']."'  OR `hfa_three`.`main_religion`='' ) ";	
		}
		
		//$where .=" and `hfa_one`.`id` NOT IN ('".implode("','",$excludeHost)."')";
		$excludeHostHostpieces = array_chunk($excludeHost, ceil(count($excludeHost) / 2));//see($excludeHost);
		if(empty($excludeHostHostpieces))
			$excludeHostHostpieces[0]=$excludeHostHostpieces[1]=array();
		$where .=" and `hfa_one`.`id` NOT IN ('".implode("','",$excludeHostHostpieces[0])."')";
		$where .=" and `hfa_one`.`id` NOT IN ('".implode("','",$excludeHostHostpieces[1])."')";
		
		if(!empty($includeHost))
		{
			//$where .=" and `hfa_one`.`id` IN ('".implode("','",$includeHost)."')";
			//divided $includeHost into two parts to solve the issue: Message: preg_match(): Compilation failed: regular expression is too large at offset
			$includeHostpieces = array_chunk($includeHost, ceil(count($includeHost) / 2));
			if(empty($includeHostpieces))
				$includeHostpieces[0]=$includeHostpieces[1]=array();
			$where .=" and (`hfa_one`.`id` IN ('".implode("','",$includeHostpieces[0])."')";
			if(!isset($includeHostpieces[1]))
				$includeHostpieces[1]=array();
			$where .=" OR `hfa_one`.`id` IN ('".implode("','",$includeHostpieces[1])."'))";
		}
		
		$where .=$whereSelf_catered;
		}
		
		$this->db->where($where);
						
		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if( !empty($_POST['filterMatchesStatus']) && $_POST['filterMatchesStatus']==10){
			$order=array('hfa_one.suburb'=>"ASC");
			$this->db->order_by(key($order), $order[key($order)]);
		} else if( !empty($_POST['filterMatchesStatus']) && $_POST['filterMatchesStatus']==11){
			$order=array('hfa_one.suburb'=>"DESC");
			$this->db->order_by(key($order), $order[key($order)]);
		}
		
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get(); //echo $this->db->last_query();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
	
	////////////// For data table server side ENDS
	
	
	function shaMatchStatus($student,$host)
	{
		$sql="select * from `sha_matches_status` where `id`='".$student."' and (FIND_IN_SET('".$host."', `shortlisted`) OR FIND_IN_SET('".$host."', `rejected`))";
		$query=$this->db->query($sql);
		$row=$query->row_array();
		
		if(!empty($row))
		{
			$shortlisted=explode(',',$row['shortlisted']);
			if(in_array($host,$shortlisted))
				return '2';
			else
				return '3';
		}
		else
			return '1';
	}
	
	function matchedAppChangeStatusSubmit($data)
	{
		$currentStatus=$this->shaMatchStatus($data['student'],$data['host']);
		if($currentStatus != $data['status'])
		{
			$sql="select * from `sha_matches_status` where `id`='".$data['student']."'";
			$query=$this->db->query($sql);
			$row=$query->row_array();
			
			
				if(empty($row))
				{
					$shortlisted=$rejected='';
					if($data['status']=='2')
						$shortlisted=$data['host'];
					else
						$rejected=$data['host'];	
						
					$sqlIns="insert into `sha_matches_status` (`id`,`shortlisted`,`rejected`) values(?,?,?)";
					$this->db->query($sqlIns,array($data['student'],$shortlisted,$rejected));
				}
				else
				{
					$shortlistedArray=array();
					if($row['shortlisted']!='')
						$shortlistedArray=explode(',',$row['shortlisted']);
					
					$rejectedArray=array();
					if($row['rejected']!='')
						$rejectedArray=explode(',',$row['rejected']);
					
					if($data['status']=='1')
					{
						$rejectedArrayKey = array_search ($data['host'], $rejectedArray);
						if($rejectedArrayKey!==false)
							unset($rejectedArray[$rejectedArrayKey]);
						
						$shortlistedArrayKey = array_search ($data['host'], $shortlistedArray);
						if($shortlistedArrayKey!==false)
							unset($shortlistedArray[$shortlistedArrayKey]);
						
						$rejected=implode(',',$rejectedArray);
						$shortlisted=implode(',',$shortlistedArray);
					}
					
					if($data['status']=='2')
					{
						$rejectedArrayKey = array_search ($data['host'], $rejectedArray);
						if($rejectedArrayKey!==false)
							unset($rejectedArray[$rejectedArrayKey]);
						
						$rejected=implode(',',$rejectedArray);
						$shortlistedArray[]=$data['host'];
						$shortlisted=implode(',',$shortlistedArray);
					}
					
					if($data['status']=='3')
					{
						$shortlistedArrayKey = array_search ($data['host'], $shortlistedArray);
						if($shortlistedArrayKey!==false)
							unset($shortlistedArray[$shortlistedArrayKey]);
						
						$shortlisted=implode(',',$shortlistedArray);
						$rejectedArray[]=$data['host'];
						$rejected=implode(',',$rejectedArray);
					}
					
					$sqlUpdate="update `sha_matches_status` set `shortlisted`=?, `rejected`=? where `id`=?";
					$this->db->query($sqlUpdate,array($shortlisted,$rejected,$data['student']));
					
					$sqlDel="delete from `sha_matches_status` where `shortlisted`='' and `rejected`=''";
					$this->db->query($sqlDel);
				}
		
		}
	}
}