<?php
class GenerateProfile extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		//$this->load->model('Po_model');
	}
	
	function index()
	{
		
	}
	
	function generateFile($inputFileName,$outputFileName,$data)
	{
		$data=$this->removeSpecialCharFromAll($data);
		
		$fileFolder   = "./static/wordFiles/";
		
		$template_file_path = $fileFolder.'templates/'.$inputFileName.'.docx';
		$generated_file_folder = $fileFolder.'generated/';
 		$generated_file_path = $generated_file_folder.$outputFileName. ".docx";
		
 		try
		{
			if (!file_exists($generated_file_folder))
			{
				mkdir($generated_file_folder);
			}       
				 
			//Copy the Template file to the Result Directory
			copy($template_file_path, $generated_file_path);
		 
			// add calss Zip Archive
			$zip_val = new ZipArchive;
		 
			//Docx file is nothing but a zip file. Open this Zip File
			if($zip_val->open($generated_file_path) == true)
			{
				// In the Open XML Wordprocessing format content is stored.
				// In the document.xml file located in the word directory.
				 
				$key_file_name = 'word/document.xml';
				$message = $zip_val->getFromName($key_file_name);                
							 
				$timestamp = date('d-M-Y H:i:s');
				// see($message); 
				// see($data);
				 
				// this data Replace the placeholders with actual values
				foreach($data as $itemK=>$itemV)
				{
					$message = str_replace('{'.$itemK.'}', $itemV, $message);
				}
				//Replace the content with the new content created above.
				$zip_val->addFromString($key_file_name, $message);
				$zip_val->close();
			}
		}
		catch (Exception $exc) 
		{
			$error_message =  "Error creating the Word Document";
			var_dump($exc);
		}


		}
	
	function student_profile($id)
	{
		$inputFileName='studentProfile';
		
		$booking=bookingDetails($id);
		if(!empty($booking))
		{
			$host=getHfaOneAppDetails($booking['host']);
			$student=getShaOneAppDetails($booking['student']);
			$student['two']=getShaTwoAppDetails($booking['student']);
			$student['three']=getShaThreeAppDetails($booking['student']);
			
			//#find the type of student profile #STARTS
			$ageStudent=age_from_dob($student['dob']);
			if($ageStudent<18)
				  {
						if(trim($student['three']['college'])!='' && trim($student['three']['college_group'])!='' && in_array(trim($student['three']['college_group']),['pbs_nsw','pbs_vic','pbs_nt']))
						{
								$inputFileName='studentProfile-U18-PublicSchool';
						}
						else
						{
							if($student['two']['guardianship']=='1' && $student['two']['guardian_assigned']=='9')
								$inputFileName='studentProfile-U18-Host-Caregiver';
							else
								$inputFileName='studentProfile-U18-Host-Not-Caregiver';
						}
						
						
					}
			 //#find the type of student profile #ENDS  
			
			//$outputFileName='GE student profile - '.$booking['id'].' - '.$student['fname'].' '.$student['lname'];
			$outputFileName='ge Student Profile - '.ucwords($student['fname'].' '.$student['lname']).' - '.$host['fname'].' '.$host['lname'];
			$data=array();
			
			$nameTitleList=nameTitleList();
			$salutation='';
			if($student['title']!='')
				$salutation=$nameTitleList[$student['title']];	
			
			$genderList=genderList();
			
			$nation='';
			$nationList=nationList();
			if($student['nation']!=0)
			{
				$nation=$nationList[$student['nation']];
			}
			
			$religionList=religionList();
			if($student['two']['religion']!="0" && $student['two']['religion']!='')
				$religion=ucfirst ($religionList[$student['two']['religion']]);
			elseif($student['two']['religion']=="0")
				$religion=ucfirst ($student['two']['religion_other']);
			else
				$religion='not provided';
			
			$allergies='No allergies';
			if($student['three']['allergy_req']=='1')
				{
					$allergy=array();
					if($student['three']['allergy_hay_fever']==1)
						$allergy[]='Hay Fever';
					if($student['three']['allergy_asthma']==1)
						$allergy[]='Asthma';
					if($student['three']['allergy_lactose']==1)
						$allergy[]='Lactose Intolerance';
					if($student['three']['allergy_gluten']==1)
						$allergy[]='Gluten Intolerance';	
					if($student['three']['allergy_peanut']==1)
						$allergy[]='Peanut Allergies';	
					if($student['three']['allergy_dust']==1)
						$allergy[]='Dust Allergies';	
					if($student['three']['allergy_other']==1 && $student['three']['allergy_other_val']!='')
						$allergy[]=ucfirst ($student['three']['allergy_other_val']);		
					
					if(!empty($allergy))
						$allergies =implode(', ',$allergy);
				}
			
		  $dietReq='No special dietary requirements';
		  if($student['three']['diet_req']=='1')
			  {
				  $diet=array();
				  if($student['three']['diet_veg']==1)
					  $diet[]='Vegetarian';
				  if($student['three']['diet_gluten']==1)
					  $diet[]='Gluten/Lactose Free';
				  if($student['three']['diet_pork']==1)
					  $diet[]='No Pork';
				  if($student['three']['diet_food_allergy']==1)
					  $diet[]='Food Allergies';	
				  if($student['three']['diet_other']==1 && $student['three']['diet_other_val']!='')
					  $diet[]=ucfirst ($student['three']['diet_other_val']);		
				  
				  if(!empty($diet))
					  $dietReq =implode(', ',$diet);
			  }	
			
			$medication='n/a';
			if($student['three']['medication']=='1')
				$medication='Yes, '.ucfirst ($student['three']['medication_desc']);
			elseif($student['three']['medication']=='0')
				$medication="No";
			
			$liveWithPets='n/a';
			if($student['two']['live_with_pets']=="0")
				$liveWithPets="No";
			elseif($student['two']['live_with_pets']=="1")
			{
				$liveWithPets="Yes";
				$pets=array();
			  	if($student['two']['pet_dog']==1)
				  $pets[]='Dog';
			  	if($student['two']['pet_cat']==1)
				  $pets[]='Cat';
			  	if($student['two']['pet_bird']==1)
				  $pets[]='Bird';
			  	if($student['two']['pet_other']==1 && $student['two']['pet_other_val']!='')
				  $pets[]=ucfirst ($student['two']['pet_other_val']);	
			  
			  	if(!empty($pets))
				  $liveWithPets .=' - '.implode(', ',$pets);
			}
			
			$languageSpoken='';
			$languageList=languageList();
			$languagePrificiencyList=languagePrificiencyList();
			foreach($student['two']['language'] as $lK=>$language)
			  {
				  $languageSpoken .=$languageList[$language['language']];
					  
				  if($language['prof']!='')
						  $languageSpoken .= " (".$languagePrificiencyList[$language['prof']].")";
				  if(count($student['two']['language'])-1 != $lK)
					  $languageSpoken .= ", ";
			  }
			  
			$smokerStudent='n/a';
			$smokingHabbits=smokingHabbits();
			if($student['three']['smoker']!='')
				$smokerStudent=$smokingHabbits[$student['three']['smoker']];
			
			$studentArrivalDate='n/a';
			$studentArrivalTime='n/a';
			$studentFlightNo='n/a';
			$apu='';
			
			if($student['arrival_date']!='0000-00-00')
				$studentArrivalDate=date('d M Y',strtotime($student['arrival_date']));
			 
			 if($student['two']['airport_arrival_time']!='00:00:00')
				 $studentArrivalTime=date('H:i',strtotime($student['two']['airport_arrival_time']));
			
			 $studentFlightNo=ucfirst($student['two']['airport_flightno']);
			
			if($student['two']['airport_pickup']==1)
				 $apu='Yes';
			else
				$apu='No';
			
			$accomodationTypeList=accomodationTypeList();
			$bookingDuration=$bookingDurationU18='';
			if($booking['booking_to']!='0000-00-00')
				{
					$totalDays=dayDiff($booking['booking_from'],$booking['booking_to']);
					$getWeekNDays=getWeekNDays($totalDays);
					if(isset($getWeekNDays['week']))
						$bookingDuration.=$getWeekNDays['week'].' week'.s($getWeekNDays['week']).' ';
					if(isset($getWeekNDays['day']))
						$bookingDuration.=$getWeekNDays['day'].' day'.s($getWeekNDays['day']);
				}
				else
				{
					$bookingDuration='4 weeks initial booking';
					if($ageStudent<18)
					{
						$bookingDuration ='4 weeks';
						$bookingDurationU18=' (student may extend until age 18)';
					}
				}
				
			$checkInDate=dateFormat($booking['booking_from']);
			if($booking['booking_to']!='0000-00-00')
				$checkOutDate=dateFormat(date('Y-m-d',strtotime($booking['booking_to'].' + 1 day')));
			else
				$checkOutDate='Not set';
			
			$weeklyPrice='';
			/*$bookingYear=date('Y',strtotime($booking['booking_from']));
			$products=clientProductsList($student['client'],$bookingYear);
			$age=age_from_dob($student['dob']);
			foreach($products as $p)
				{
					$accomodation_fee=array();
					if($student['accomodation_type']==1)
						{
							if($p['name']=='Single Room 18-' && $age<18)
								$weeklyPrice=$p['price'];
							if($p['name']=='Single Room 18+' && $age>=18)
								$weeklyPrice=$p['price'];
						}
					else if($student['accomodation_type']==2)
						{
							if($p['name']=='Twin Share 18-' && $age<18)
								$weeklyPrice=$p['price'];
							if($p['name']=='Twin Share 18+' && $age>=18)
								$weeklyPrice=$p['price'];
						}
					else if($student['accomodation_type']==3)
						{
							if($p['name']=='Self-Catered')
								$weeklyPrice=$p['price'];
						}
					else if($student['accomodation_type']==4)
						{
							if($p['name']=='VIP Single Room')
								$weeklyPrice=$p['price'];
						}
					else if($student['accomodation_type']==5)
						{
							if($p['name']=='VIP Self-Catered')
								$weeklyPrice=$p['price'];
						}
				}*/
			
			if(trim($student['sha_student_no'])!='')
				$sha_student_no=$student['sha_student_no'];
			else	
				$sha_student_no='n/a';
				
			$data['DATE_TODAY']=date('d M Y');
			$data['STUDENT_SALUTATION']=$salutation;
			$data['STUDENT_NAME']=$student['fname'].' '.$student['lname'];
			$data['HOST_FAMILY_NAME']=$host['lname'];
			$data['HOST_FAMILY_SUBURB']=$host['suburb'];
			/*$data['STUDENT_ID']=$booking['student'];*/
			$data['STUDENT_ID']=$sha_student_no; 
			$data['STUDENT_BIRTHDATE']=date('d M Y',strtotime($student['dob']));
			$data['STUDENT_GENDER']=$genderList[$student['gender']];
			$data['STUDENT_NATIONALITY']=$nation;
			$data['STUDENT_RELIGION']=$religion;
			if(trim($student['email'])!='no-reply@globalexperience.com.au')
				$data['STUDENT_EMAIL']=$student['email'];
			else	
				$data['STUDENT_EMAIL']='n/a';	
			$data['STUDENT_MOBILE']=!empty($student['mobile']) && ($student['mobile']!='0000000000') ? mobileFormat($student['mobile']) :'n/a';
			
			$data['STUDENT_ALLERGY_TYPES']=$allergies;
			$data['STUDENT_DIETARY_REQUIREMENTS']=$dietReq;
			$data['STUDENT_MEDICATION']=$medication;
			
			$data['STUDENT_LIVE_WITH_PETS']=$liveWithPets;
			$data['STUDENT_LANGUAGE_PROFICIENCY']=$languageSpoken;
			$data['STUDENT_SMOKING']=$smokerStudent;
			
			if($student['two']['student_hobbies']!='')
               $hobbiesStudent=$student['two']['student_hobbies'];
			else
               $hobbiesStudent='n/a';
            $data['STUDENT_HOBBIES']=$hobbiesStudent;
			
			$data['ARRIVAL_DATE']=$studentArrivalDate;
			$data['ARRIVAL_TIME']=$studentArrivalTime;
			$data['FLIGHT_NUMBER']=$studentFlightNo;
			$data['AIRPORT_PICK_UP_SERVICE']=$apu;
			
			$data['BOOKING_SCHOOL']=ucfirst($student['three']['college']);
			if($data['BOOKING_SCHOOL']!='')
			{
				if(trim($student['three']['college_address'])!='' || trim($student['three']['campus'])!='')
					$data['BOOKING_SCHOOL'] .=' - ';
				$data['BOOKING_SCHOOL'] .=ucfirst ($student['three']['campus']);
				if(trim($student['three']['college_address'])!='' && trim($student['three']['campus'])!='')
					$data['BOOKING_SCHOOL'] .=', ';
				$data['BOOKING_SCHOOL'] .=ucfirst ($student['three']['college_address']);
			}
			else
				$data['BOOKING_SCHOOL'] .='Institution details not available';
			$data['BOOKING_DURATION_OF_STAY']=$bookingDuration;
			$data['BOOKING_DURATION_OF_STAY_U18']=$bookingDurationU18;
			$data['BOOKING_APPLICATION_TYPE']=$accomodationTypeList[$student['accomodation_type']];
			$data['BOOKING_ITEM_UNIT_PRICE']=$weeklyPrice;
			
			$cgLabel=$cgCompany=$cgName=$cgEmail=$cgPhone=$cgStart=$cgEnd='n/a';
			if(!empty($student['two']))
			{
				$cgLabel='Caregiver not applicable';
				if($ageStudent<18)
					{
						if($student['two']['guardianship']=='1')
						{
							$cgLabel='Caregiver required';
							
							if($student['two']['guardian_assigned']!=0)
								{
									$caregiverDetails=getCaregiverDetail($student['two']['guardian_assigned']);
									$cgCompanyDetails=getCaregiverCompanyDetail($caregiverDetails['company']);
									
									$cgCompany=$cgCompanyDetails['name'];
									$cgName=$caregiverDetails['fname'].' '.$caregiverDetails['lname'];
									if($caregiverDetails['email']!='')
										$cgEmail=$caregiverDetails['email'];
									$cgPhone=$caregiverDetails['phone'];
									if($student['two']['guardianship_startDate']!='0000-00-00')
										$cgStart=dateFormat($student['two']['guardianship_startDate']);
									if($student['two']['guardianship_endDate']!='0000-00-00')
										$cgEnd=dateFormat($student['two']['guardianship_endDate']);
								}
						}
						elseif($student['two']['guardianship']=='0')
							$cgLabel='Caregiver not required';
					}
			}
			$data['CG_LABEL']=$cgLabel;
			$data['CG_COMPANY']=$cgCompany;
			$data['CG_NAME']=$cgName;
			$data['CG_EMAIL']=$cgEmail;
			$data['CG_PHONE']=$cgPhone;
			$data['CG_START']=$cgStart;
			$data['CG_END']=$cgEnd;
			
			$data['BOOKING_CHECKIN_DATE']=$checkInDate;
			$data['BOOKING_CHECKOUT_DATE']=$checkOutDate;
			
			$this->generateFile($inputFileName,$outputFileName,$data);
			header('location:'.site_url().'static/wordFiles/generated/'.$outputFileName.'.docx');
		}
		else
			echo "Booking not found";
	}
	
	function student_profile_old($id)
	{
		$inputFileName='studentProfile';
		
		$booking=bookingDetails($id);
		if(!empty($booking))
		{
			$host=getHfaOneAppDetails($booking['host']);
			$student=getShaOneAppDetails($booking['student']);
			$student['two']=getShaTwoAppDetails($booking['student']);
			$student['three']=getShaThreeAppDetails($booking['student']);
			
			//#find the type of student profile #STARTS
			$ageStudent=age_from_dob($student['dob']);
			if($ageStudent<18)
				  {
					  $studentProfileU18Colleges=studentProfileU18Colleges();
					  
					  //$student['two']['guardian_assigned']=='4' .i.e HOST FAMILY
					  if($student['two']['guardianship']=='1' && $student['two']['guardian_assigned']=='9' && in_array($student['three']['college'],$studentProfileU18Colleges))
						$inputFileName='studentProfile-U18_with_carer';
				  }
			else
			{
				$clientDetail=clientDetail($student['client']);
				if(in_array($clientDetail['client_group'],['pbs_nsw','pbs_vic','pbs_nt']))
					$inputFileName='studentProfile-DE';
			}
			 //#find the type of student profile #ENDS  
			
			//$outputFileName='GE student profile - '.$booking['id'].' - '.$student['fname'].' '.$student['lname'];
			$outputFileName='ge Student Profile - '.ucwords($student['fname'].' '.$student['lname']).' - '.$host['fname'].' '.$host['lname'];
			$data=array();
			
			$nameTitleList=nameTitleList();
			$salutation='';
			if($student['title']!='')
				$salutation=$nameTitleList[$student['title']];	
			
			$genderList=genderList();
			
			$nation='';
			$nationList=nationList();
			if($student['nation']!=0)
			{
				$nation=$nationList[$student['nation']];
			}
			
			$allergies='No allergies';
			if($student['three']['allergy_req']=='1')
				{
					$allergy=array();
					if($student['three']['allergy_hay_fever']==1)
						$allergy[]='Hay Fever';
					if($student['three']['allergy_asthma']==1)
						$allergy[]='Asthma';
					if($student['three']['allergy_lactose']==1)
						$allergy[]='Lactose Intolerance';
					if($student['three']['allergy_gluten']==1)
						$allergy[]='Gluten Intolerance';	
					if($student['three']['allergy_peanut']==1)
						$allergy[]='Peanut Allergies';	
					if($student['three']['allergy_dust']==1)
						$allergy[]='Dust Allergies';	
					if($student['three']['allergy_other']==1 && $student['three']['allergy_other_val']!='')
						$allergy[]=ucfirst ($student['three']['allergy_other_val']);		
					
					if(!empty($allergy))
						$allergies =implode(', ',$allergy);
				}
			
		  $dietReq='No special dietary requirements';
		  if($student['three']['diet_req']=='1')
			  {
				  $diet=array();
				  if($student['three']['diet_veg']==1)
					  $diet[]='Vegetarian';
				  if($student['three']['diet_gluten']==1)
					  $diet[]='Gluten/Lactose Free';
				  if($student['three']['diet_pork']==1)
					  $diet[]='No Pork';
				  if($student['three']['diet_food_allergy']==1)
					  $diet[]='Food Allergies';	
				  if($student['three']['diet_other']==1 && $student['three']['diet_other_val']!='')
					  $diet[]=ucfirst ($student['three']['diet_other_val']);		
				  
				  if(!empty($diet))
					  $dietReq =implode(', ',$diet);
			  }	
			
			$medication='n/a';
			if($student['three']['medication']=='1')
				$medication='Yes, '.ucfirst ($student['three']['medication_desc']);
			elseif($student['three']['medication']=='0')
				$medication="No";
			
			$liveWithPets='n/a';
			if($student['two']['live_with_pets']=="0")
				$liveWithPets="No";
			elseif($student['two']['live_with_pets']=="1")
			{
				$liveWithPets="Yes";
				$pets=array();
			  	if($student['two']['pet_dog']==1)
				  $pets[]='Dog';
			  	if($student['two']['pet_cat']==1)
				  $pets[]='Cat';
			  	if($student['two']['pet_bird']==1)
				  $pets[]='Bird';
			  	if($student['two']['pet_other']==1 && $student['two']['pet_other_val']!='')
				  $pets[]=ucfirst ($student['two']['pet_other_val']);	
			  
			  	if(!empty($pets))
				  $liveWithPets .=' - '.implode(', ',$pets);
			}
			
			$languageSpoken='';
			$languageList=languageList();
			$languagePrificiencyList=languagePrificiencyList();
			foreach($student['two']['language'] as $lK=>$language)
			  {
				  $languageSpoken .=$languageList[$language['language']];
					  
				  if($language['prof']!='')
						  $languageSpoken .= " (".$languagePrificiencyList[$language['prof']].")";
				  if(count($student['two']['language'])-1 != $lK)
					  $languageSpoken .= ", ";
			  }
			  
			$smokerStudent='n/a';
			$smokingHabbits=smokingHabbits();
			if($student['three']['smoker']!='')
				$smokerStudent=$smokingHabbits[$student['three']['smoker']];
			
			$studentArrivalDate='n/a';
			$studentArrivalTime='n/a';
			$studentFlightNo='n/a';
			$apu='';
			
			if($student['arrival_date']!='0000-00-00')
				$studentArrivalDate=date('d M Y',strtotime($student['arrival_date']));
			 
			 if($student['two']['airport_arrival_time']!='00:00:00')
				 $studentArrivalTime=date('H:i',strtotime($student['two']['airport_arrival_time']));
			
			 $studentFlightNo=ucfirst($student['two']['airport_flightno']);
			
			if($student['two']['airport_pickup']==1)
				 $apu='Yes';
			else
				$apu='No';
			
			$accomodationTypeList=accomodationTypeList();
			$bookingDuration='';
			if($booking['booking_to']!='0000-00-00')
				{
					$totalDays=dayDiff($booking['booking_from'],$booking['booking_to']);
					$getWeekNDays=getWeekNDays($totalDays);
					if(isset($getWeekNDays['week']))
						$bookingDuration.=$getWeekNDays['week'].' week'.s($getWeekNDays['week']).' ';
					if(isset($getWeekNDays['day']))
						$bookingDuration.=$getWeekNDays['day'].' day'.s($getWeekNDays['day']);
				}
				else
				{
					$bookingDuration='4 weeks initial booking';
					if($ageStudent<18)
						$bookingDuration .=' with potential extending homestay service until '.$student['fname'].' '.$student['lname'].' turns 18 years old';
				}
			
			$weeklyPrice='';
			/*$bookingYear=date('Y',strtotime($booking['booking_from']));
			$products=clientProductsList($student['client'],$bookingYear);
			$age=age_from_dob($student['dob']);
			foreach($products as $p)
				{
					$accomodation_fee=array();
					if($student['accomodation_type']==1)
						{
							if($p['name']=='Single Room 18-' && $age<18)
								$weeklyPrice=$p['price'];
							if($p['name']=='Single Room 18+' && $age>=18)
								$weeklyPrice=$p['price'];
						}
					else if($student['accomodation_type']==2)
						{
							if($p['name']=='Twin Share 18-' && $age<18)
								$weeklyPrice=$p['price'];
							if($p['name']=='Twin Share 18+' && $age>=18)
								$weeklyPrice=$p['price'];
						}
					else if($student['accomodation_type']==3)
						{
							if($p['name']=='Self-Catered')
								$weeklyPrice=$p['price'];
						}
					else if($student['accomodation_type']==4)
						{
							if($p['name']=='VIP Single Room')
								$weeklyPrice=$p['price'];
						}
					else if($student['accomodation_type']==5)
						{
							if($p['name']=='VIP Self-Catered')
								$weeklyPrice=$p['price'];
						}
				}*/
			
			if(trim($student['sha_student_no'])!='')
				$sha_student_no=$student['sha_student_no'];
			else	
				$sha_student_no='n/a';
				
			$data['DATE_TODAY']=date('d M Y');
			$data['STUDENT_SALUTATION']=$salutation;
			$data['STUDENT_NAME']=$student['fname'].' '.$student['lname'];
			$data['HOST_FAMILY_NAME']=$host['lname'];
			$data['HOST_FAMILY_SUBURB']=$host['suburb'];
			/*$data['STUDENT_ID']=$booking['student'];*/
			$data['STUDENT_ID']=$sha_student_no; 
			$data['STUDENT_BIRTHDATE']=date('d M Y',strtotime($student['dob']));
			$data['STUDENT_GENDER']=$genderList[$student['gender']];
			$data['STUDENT_NATIONALITY']=$nation;
			if(trim($student['email'])!='no-reply@globalexperience.com.au')
				$data['STUDENT_EMAIL']=$student['email'];
			else	
				$data['STUDENT_EMAIL']='n/a';	
			$data['STUDENT_MOBILE']=!empty($student['mobile']) && ($student['mobile']!='0000000000') ? mobileFormat($student['mobile']) :'n/a';
			
			$data['STUDENT_ALLERGY_TYPES']=$allergies;
			$data['STUDENT_DIETARY_REQUIREMENTS']=$dietReq;
			$data['STUDENT_MEDICATION']=$medication;
			
			$data['STUDENT_LIVE_WITH_PETS']=$liveWithPets;
			$data['STUDENT_LANGUAGE_PROFICIENCY']=$languageSpoken;
			$data['STUDENT_SMOKING']=$smokerStudent;
			
			if($student['two']['student_hobbies']!='')
               $hobbiesStudent=$student['two']['student_hobbies'];
			else
               $hobbiesStudent='n/a';
            $data['STUDENT_HOBBIES']=$hobbiesStudent;
			
			$data['ARRIVAL_DATE']=$studentArrivalDate;
			$data['ARRIVAL_TIME']=$studentArrivalTime;
			$data['FLIGHT_NUMBER']=$studentFlightNo;
			$data['AIRPORT_PICK_UP_SERVICE']=$apu;
			
			$data['BOOKING_SCHOOL']=ucfirst($student['three']['college']);
			if($data['BOOKING_SCHOOL']!='')
			{
				if(trim($student['three']['college_address'])!='' || trim($student['three']['campus'])!='')
					$data['BOOKING_SCHOOL'] .=' - ';
				$data['BOOKING_SCHOOL'] .=ucfirst ($student['three']['campus']);
				if(trim($student['three']['college_address'])!='' && trim($student['three']['campus'])!='')
					$data['BOOKING_SCHOOL'] .=', ';
				$data['BOOKING_SCHOOL'] .=ucfirst ($student['three']['college_address']);
			}
			else
				$data['BOOKING_SCHOOL'] .='Institution details not available';
			$data['BOOKING_DURATION_OF_STAY']=$bookingDuration;
			$data['BOOKING_APPLICATION_TYPE']=$accomodationTypeList[$student['accomodation_type']];
			$data['BOOKING_ITEM_UNIT_PRICE']=$weeklyPrice;
			
			$cgCompany=$cgName=$cgEmail=$cgPhone=$cgStart=$cgEnd='n/a';
			if(!empty($student['two']))
			{
				$cgLabel='Caregiver not applicable';
				if($ageStudent<18)
					{
						if($student['two']['guardianship']=='1')
						{
							$cgLabel='Caregiver required';
							
							if($student['two']['guardian_assigned']!=0)
								{
									$caregiverDetails=getCaregiverDetail($student['two']['guardian_assigned']);
									$cgCompanyDetails=getCaregiverCompanyDetail($caregiverDetails['company']);
									
									$cgCompany=$cgCompanyDetails['name'];
									$cgName=$caregiverDetails['fname'].' '.$caregiverDetails['lname'];
									if($caregiverDetails['email']!='')
										$cgEmail=$caregiverDetails['email'];
									$cgPhone=$caregiverDetails['phone'];
									if($student['two']['guardianship_startDate']!='0000-00-00')
										$cgStart=dateFormat($student['two']['guardianship_startDate']);
									if($student['two']['guardianship_endDate']!='0000-00-00')
										$cgEnd=dateFormat($student['two']['guardianship_endDate']);
								}
						}
						elseif($student['two']['guardianship']=='0')
							$cgLabel='Caregiver not required';
					}
			}
			$data['CG_LABEL']=$cgLabel;
			$data['CG_COMPANY']=$cgCompany;
			$data['CG_NAME']=$cgName;
			$data['CG_EMAIL']=$cgEmail;
			$data['CG_PHONE']=$cgPhone;
			$data['CG_START']=$cgStart;
			$data['CG_END']=$cgEnd;
			
			$this->generateFile($inputFileName,$outputFileName,$data);
			header('location:'.site_url().'static/wordFiles/generated/'.$outputFileName.'.docx');
		}
		else
			echo "Booking not found";
	}
	
	function hostFamily_profile($id)
	{
		$inputFileName='hostFamilyProfile';
		
		$booking=bookingDetails($id);
		if(!empty($booking))
		{
			$host=getHfaOneAppDetails($booking['host']);
			$host['two']=getHfaTwoAppDetails($booking['host']);
			$host['three']=getHfaThreeAppDetails($booking['host']);
			$host['four']=getHfaFourAppDetails($booking['host']);
			$student=getShaOneAppDetails($booking['student']);
			$student['two']=getShaTwoAppDetails($booking['student']);
			$student['three']=getShaThreeAppDetails($booking['student']);
			$ageStudent=age_from_dob($student['dob']);
			
			//$outputFileName='GE homestay profile - '.ucfirst($host['lname']).' Family  - '.ucwords($student['fname'].' '.$student['lname']);
			$outputFileName='ge Homestay Profile - '.ucfirst($host['fname'].' '.$host['lname']).' - '.ucwords($student['fname'].' '.$student['lname']);
			
			$data=array();
			
			if($booking['booking_to']!='0000-00-00')
				$booking_to=date('d M Y',strtotime($booking['booking_to'].' + 1 day'));
			else
				$booking_to='Not set';	
			$bookingPeriodText=$bookingPeriodTextExtension='';
			if($booking['booking_to']!='0000-00-00')
				$bookingPeriodText=date('d M Y',strtotime($booking['booking_from'])).' - '.date('d M Y',strtotime($booking['booking_to'].' + 1 day'));
			else	
				$bookingPeriodText='4 weeks initial booking';
			if($ageStudent<18)
			{
				$bookingPeriodTextExtension .="<w:br/>".'*(U18 student are expected to remain in homestay until age 18)';
			}
				
			$accomodationTypeList=accomodationTypeList();
			
			$address='';
			$stateList=stateList();
			if($host['street']!='')
				$address .=$host['street'].", ".ucfirst($host['suburb']).", ".$stateList[$host['state']]." ".$host['postcode'];
				
			$petsList='';	
			if($host['three']['pets']=="0")
				$petsList .="No";
			elseif($host['three']['pets']=="1")
			{
				$petsList .="Yes ";
				
				$pets=array();
				if($host['three']['pet_dog']==1)
					$pets[]='Dog';
				if($host['three']['pet_bird']==1)
					$pets[]='Bird';
				if($host['three']['pet_cat']==1)
					$pets[]='Cat';
				if($host['three']['pet_other']==1)
					$pets[]=ucfirst ($host['three']['pet_other_val']);
					
				if(!empty($pets))
					$petsList .='- '.implode(', ',$pets);
				
				if($host['three']['pets']=="1" && trim($host['three']['pet_desc']!=""))
				{
					$newLinePets="                                                                                                                                                                                                                                                             ";
				 	$petsList .=$newLinePets.str_replace("\n",$newLinePets,$host['three']['pet_desc']);
				}
			}
			
			$internet='';
			if($host['two']['internet']=="1")
			  {
				  $internet .="Yes";
				  
				  /*if($host['two']['internet_type']==1)
					  $internet .=", Wireless broadband";
				  elseif($host['two']['internet_type']==2)	
					  $internet .=", Cable broadband";
				
				$internet	  .=" ($10 per week)";*/
			  }
			  elseif($host['two']['internet']=="0")
				$internet .="No";
			  else	
				$internet .="n/a";	
			
			$smoker='n/a';
			$smokerAccept='n/a';
			$smokingHabbits=smokingHabbits();	
			if($host['four']['smoker_students']!='')
				$smokerAccept=str_replace('amp;','',$smokingHabbits[$host['four']['smoker_students']]);
			
			$insuranceDetails='';
			if($host['three']['insurance']=='1')
			{
				$insuranceDetailsArray=array();
				if($host['three']['ins_provider']!='')
					$insuranceDetailsArray[]='Insurance provider: '.$host['three']['ins_provider'];	
				if($host['three']['ins_policy_no']!='')
					$insuranceDetailsArray[]='Policy no.: '.$host['three']['ins_policy_no'];
				if($host['three']['ins_expiry']!='0000-00-00')
					$insuranceDetailsArray[]='Expiry date: '.date('d M Y',strtotime($host['three']['ins_expiry']));	
				if($host['three']['20_million']!='')
				{
					if($host['three']['20_million']=='1')
						$million20='Yes';
					elseif($host['three']['20_million']=='0')
						$million20='No';
					else
						$million20='n/a';
					$insuranceDetailsArray[]='$20 million Public Liability cover: '.$million20;					
				}
				
				$insuranceDetails=implode(', ',$insuranceDetailsArray);	
			}
			elseif($host['three']['insurance']=='0')
				$insuranceDetails='No';
			else
				$insuranceDetails='n/a';
			
			$homeContentInsurance='';
			if($host['three']['ins_content']=='1')
				$homeContentInsurance='Yes';
			elseif($host['three']['ins_content']=='0')
				$homeContentInsurance='No';
			else
				$homeContentInsurance='n/a';
			
			$familiyDesc="Not available.";
			if($host['three']['family_desc']!='')
				$familiyDesc=$host['three']['family_desc'];
			
			$nameTitleList=nameTitleList();
			$salutation='';
			if($student['title']!='')
				$salutation=$nameTitleList[$student['title']];
			
			$this->load->model('GenerateProfile_model');
			//$otherStudentsInHouse=$this->GenerateProfile_model->otherStudentsInHouse($booking);
			$otherStudentsInHouse='None';
			if(count($host['two']['bedroomDetails'])>1)
			{
				$otherStudentsInHouseCount=count($host['two']['bedroomDetails'])-1;
				$otherStudentsInHouse='Up to '.$otherStudentsInHouseCount.' student'.s($otherStudentsInHouseCount);
			}
			
			
			$latestVisit=$this->GenerateProfile_model->getHfaLatestVisitReport($booking['host']);
			if(!empty($latestVisit))
				$latest_visit_date=date('d M Y',strtotime($latestVisit['date_visited']));
			else
				$latest_visit_date='';
			
			$data['HOST_FAMILY_NAME']=ucfirst($host['lname']).' Family';
			$data['STUDENT_NAME']=$salutation.' '.ucwords($student['fname'].' '.$student['lname']);
			$data['BOOKING_FROM']=date('d M Y',strtotime($booking['booking_from']));
			$data['BOOKING_TO']=$booking_to;
			$data['BOOKING_PERIOD_TEXT']=$bookingPeriodText;
			$data['BOOKING_PERIOD_TEXT_EXTENSION']=$bookingPeriodTextExtension;
			$data['ACCOMODATION_TYPE']=$accomodationTypeList[$student['accomodation_type']];
			$data['ADDRESS']=$address;
			$data['MOBILE']=$host['mobile'];
			$data['HOME_PHONE']=$host['home_phone'];
			$data['EMAIL']=$host['email'];
			$data['OTHER_STUDENT_NAME']=$otherStudentsInHouse;
			$data['PETS']=$petsList;
			$data['INTERNET_AVAILABLE']=$internet;
			$data['SMOKER']=& $smoker;
			$data['SMOKER_ACCEPT']=$smokerAccept;
			$data['LATEST_VISIT_DATE']=$latest_visit_date;
			
			$data['INSURANCE_DETAILS']=$insuranceDetails;
			$data['HOME_CONTENT_INSURANCE']=$homeContentInsurance;
			
			//$newLine="                                                                                                                                                                                                                                                             ";
			$newLine="<w:br/>";
			$familiyDesc=str_replace("\n",$newLine,$familiyDesc);
			$data['FAMILY_DESC']=str_replace('&','and',ucfirst($familiyDesc));
			
			$fname='FNAME';
			$role='ROLE';
			$gender='G';
			$age='AGE';
			$occupation='OCCU';
			$wwcc='WWCC_CLEARENCE_NO_DATE';
			
			$genderList=genderList();
			$family_role=family_role();
			
			$languageList=languageList();
			$memberLanguages=array();
			$newLine="                                                                                                                                                                                                                                                             ";
			$languageSpoken='English, ';
			
			foreach($host['three']['memberDetails'] as $memberK=>$member)
			{
				if($member['smoke']!='')
				{
					if($smoker!='Yes')
					{
						if($member['smoke']=='0')
							$smoker='No';
						else	
							$smoker='Yes';
					}
				}
				
				if(count($member['languages'])==1 && $member['languages'][0]['language']=='10')
				{}
				else
				{
					$languageSpoken .=$member['fname'].' - ';
					$languageCount=0;
					foreach($member['languages'] as $memLangK=>$memLang)
					{
						if($memLang['language']!='10')
						{
							if($languageCount>0)
								$languageSpoken .=', ';
							if($memLang['language']=='25')
								$languageSpoken .=$memLang['other_language'];	
							else	
								$languageSpoken .=$languageList[$memLang['language']];
							$languageCount++;
						}
					}
					
					$languageSpoken .='; ';
				}
				/*$languageSpoken .=$member['fname'].' - ';
				foreach($member['languages'] as $memLangK=>$memLang)
				{
					//$memberLanguages[]=$memLang['language'];
					if($memLangK!=0)
						$languageSpoken .=', ';
					if($memLang['language']=='25')
						$languageSpoken .=$memLang['other_language'];	
					else	
						$languageSpoken .=$languageList[$memLang['language']];
				}
				
				$languageSpoken .='; ';*/
				$memCount=$memberK+1;
				$FM1='FM'.$memCount.'_';
				
				if($member['role']!=''){
					if($member['role']==17){
						$memberRole=!empty($member['other_role']) ? $member['other_role']: $family_role[$member['role']];
					}else{
                   $memberRole=$family_role[$member['role']];
					}
				}else{
				   $memberRole='n/a';
				}
				   
			  if(trim($member['occu']) !='')
				  $memberOccu=ucfirst($member['occu']);
			  else 
				  $memberOccu='n/a';
				  
				$memberAge=exact_age_from_dob($member['dob']);
				
				$memberWWCCDetails="n/a";
				if($memberAge >17 ) 
				{
					if($member['wwcc']=="0")
                        $memberWWCCDetails="No";
				   elseif($member['wwcc']=="1")
				   {
						$memberWWCCDetails="";
						if($member['wwcc_clearence']=="1")
						{
							if(trim($member['wwcc_clearence_no'])!='')
								$memberWWCCDetails .=$member['wwcc_clearence_no'];
							
							if($member['wwcc_expiry']!="0000-00-00")
							{
								if($memberWWCCDetails!='')
									$memberWWCCDetails .=$newLine;
                                $memberWWCCDetails .=date('d M Y',strtotime($member['wwcc_expiry']));
							}
						}
				   }		
				}
				
				$data[$FM1.$fname]=$member['fname'];
				$data[$FM1.$role]=ucwords(strtolower($memberRole));
				$data[$FM1.$gender]=$genderList[$member['gender']];
				$data[$FM1.$age]=$memberAge;
				$data[$FM1.$occupation]=$memberOccu;
				$data[$FM1.$wwcc]=$memberWWCCDetails;	
			}
		
			$memNextNo=count($host['three']['memberDetails'])+1;
		
			for($x=$memNextNo;$x<=9;$x++)
			{
				$FM1='FM'.$x.'_';
				$data[$FM1.$fname]='';
				$data[$FM1.$role]='';
				$data[$FM1.$gender]='';
				$data[$FM1.$age]='';
				$data[$FM1.$occupation]='';
				$data[$FM1.$wwcc]='';
			}
			
			/*$memberLanguages=array_unique($memberLanguages);
			$languagesSpoken=array();
			foreach($memberLanguages as $mL)
				$languagesSpoken[]=$languageList[$mL];*/
			
			//$data['LANGUAGE']=implode(', ',$languagesSpoken);	
			$data['LANGUAGE']=$languageSpoken;
			
			$transportCollege=$transportType=$transportTravelTime=$transportDesc='n/a';
			if($booking['transportInfo']!=0)
			{
				$this->load->model('hfa_model');
				$transportInfo=$this->hfa_model->transportInfoDetails($booking['transportInfo']);
				if(!empty($transportInfo))
				{
					$transportCollegeDetail=collegeDetail($transportInfo['college_id']);
					$transportCollege=$transportCollegeDetail['bname'];
					$transportType=$transportInfo['type'];
					if($transportInfo['travel_time']!='')
						$transportTravelTime=$transportInfo['travel_time'];
					if($transportInfo['description']!='')	
						$transportDesc=$transportInfo['description'];
				}
			}
			
			$data['TRANSPORT_COLLEGE']=$transportCollege;
			$data['TRANSPORT_TYPE']=$transportType;
			$data['TRANSPORT_TRAVEL_TIME']=$transportTravelTime;
			$data['TRANSPORT_DESC']=$transportDesc;
			
			$institutionName=$institutionAddress='n/a';
			if(trim($student['three']['college'])!='')
			{
				$institutionName=$student['three']['college'];
				if(trim($student['three']['college_address'])!='')
					$institutionAddress=$student['three']['college_address'];
				if(trim($student['three']['college_group'])!='' && in_array(trim($student['three']['college_group']),['pbs_nsw','pbs_vic','pbs_nt']))
					{
						$inputFileName='hostFamilyProfile-PublicSchools';
						$dwellingTypeList=dwellingTypeList();
						$dwellingType='N/A';$bedroomCount=$bathroomCount='';
						if($host['two']['d_type']!='')
							$dwellingType=$dwellingTypeList[$host['two']['d_type']];
						if(!empty($host['two']['bathroomDetails']))
						{
							$bathroomCount=count($host['two']['bathroomDetails']);
							$bathroomsUsedCount=0;
							foreach($host['two']['bathroomDetails'] as $bathrooms)
							{
								if($bathrooms['avail_to_student']=='1')
									$bathroomsUsedCount++;
							}
						}
						$data['DWELLING_TYPE']=$dwellingType;
						$data['NO_OF_BEDROOMS']=$host['two']['bedrooms'];
						$data['NO_OF_BEDROOMS_USED']=$host['two']['bedrooms_avail'];
						$data['NO_OF_BATHROOM']=$bathroomCount;
						$data['NO_OF_BATHROOM_USED']=$bathroomsUsedCount;
					}
			}
			$data['INSTITUTION_NAME']=$institutionName;
			$data['INSTITUTION_ADDRESS']=$institutionAddress;
			
			$cgLabel=$cgEmail=$cgPhone='n/a';
			if(!empty($student['two']))
			{
				$cgLabel='Caregiver not applicable';
				if($ageStudent<18)
					{
						if($student['two']['guardianship']=='1')
						{
							$cgLabel='';
							
							if($student['two']['guardian_assigned']==9)
								{
									$caregiverDetails=getCaregiverDetail($student['two']['guardian_assigned']);
									
									if($caregiverDetails['email']!='')
										$cgEmail=$caregiverDetails['email'];
									$cgPhone=$caregiverDetails['phone'];
								}
						}
						elseif($student['two']['guardianship']=='0')
							$cgLabel='Caregiver not required';
					}
			}
			$data['CG_LABEL']=$cgLabel;
			$data['CG_EMAIL']=$host['email'];
			$data['CG_PHONE']=$cgPhone;
			
			$this->generateFile($inputFileName,$outputFileName,$data);
			header('location:'.site_url().'static/wordFiles/generated/'.$outputFileName.'.docx');
		}
		else
			echo "Booking not found";
	}
	
	function apu_profile($id)
	{
		$booking=bookingDetails($id);
		if(!empty($booking))
		{
			$host=getHfaOneAppDetails($booking['host']);
			$student=getShaOneAppDetails($booking['student']);
			$student['two']=getShaTwoAppDetails($booking['student']);
			
			$apu_companyPhone=$apuCompanyContactNamePhone=$apuCompany='';
			$apuCompanyDetail=apuCompanyDetail($student['two']['apu_company']);
			if(!empty($apuCompanyDetail))
			{
				$apuCompany=$apuCompanyDetail['company_name'];
				$apuCompanyContactNamePhone=$apuCompanyDetail['name'].' '.$apuCompanyDetail['phone'];
				$apu_companyPhone=$apuCompanyDetail['phone'];
			}
			
			
			if($student['two']['airport_pickup']=='0')
				$outputFileName=$inputFileName='apuProfileNotRequested - '.ucwords($student['fname'].' '.$student['lname']);
			$inputFileName='apuProfileNotRequested';
			
			
			if($student['two']['airport_pickup']=='1' || ($student['study_tour_id']!='0' && ($student['two']['airport_pickup']=='1' ||$student['two']['airport_pickup_meeting_point']=='1')) )
			{
				//$outputFileName='ge 2018 - '.$apuCompany.' - '.$booking['id'].' - '.ucwords($student['fname'].' '.$student['lname']).'.doc';
				$outputFileName='ge APU Profile - '.$apuCompany.' - '.ucwords($student['fname'].' '.$student['lname']);
				$inputFileName='apuProfile';
				
				if($student['two']['apu_company']!='')
				{
					if($student['two']['apu_company']=='1')
						$inputFileName='apuProfile-2Stay';
					elseif($student['two']['apu_company']=='2')	
						$inputFileName='apuProfile-Castle';
					elseif($student['two']['apu_company']=='3')	
						$inputFileName='apuProfile-Melbourne';
					elseif($student['two']['apu_company']=='4')		
						$inputFileName='apuProfile-Darwin';
					elseif($student['two']['apu_company']=='5')
						$inputFileName='apuProfile-2Stay_holmes';
					elseif($student['two']['apu_company']=='6')
						$inputFileName='apuProfile-RoyalLimousine';
				}
			}
			$nameTitleList=nameTitleList();
			$salutation='';
			if($student['title']!='')
				$salutation=$nameTitleList[$student['title']];	
			
			$studentArrivalDate=$studentArrivalTime=$studentFlightNo='Not available';
			if(in_array($student['two']['airport_pickup'],array(0,1))|| ($student['study_tour_id']!='0' && ($student['two']['airport_pickup']=='1' ||$student['two']['airport_pickup_meeting_point']=='1')) )
			{
				if($student['arrival_date']!='0000-00-00')
					$studentArrivalDate=date('d M Y',strtotime($student['arrival_date']));
				 
				 if($student['two']['airport_arrival_time']!='00:00:00')
					 $studentArrivalTime=date('H:i',strtotime($student['two']['airport_arrival_time']));
				
				if($student['two']['airport_flightno']!='')
					$studentFlightNo=ucfirst($student['two']['airport_flightno']);
			}
			
			$address='';
			$stateList=stateList();
			if($host['street']!='')
				$address .=$host['street'].", ".ucfirst($host['suburb']).", ".$stateList[$host['state']].", ".$host['postcode'];
			
			$clientDetail=clientDetail($student['client']);
			
			$studentAge=age_from_dob($student['dob']);
			if($studentAge<18)
				$u18='(U18)';
			else
				$u18='';
				
			$data=array();
			$data['DATE_TODAY']=date('d M Y');
			$data['SALUTATION']=$salutation;
			$data['STUDENT_NAME']=ucwords($student['fname'].' '.$student['lname']);
			$data['STUDENT_FNAME']=ucwords($student['fname']);
			$data['STUDENT_LNAME']=ucwords($student['lname']);
			$data['u18']=$u18;
			$data['ARRIVAL_DATE']=$studentArrivalDate;
			$data['ARRIVAL_TIME']=$studentArrivalTime;
			$data['FLIGHT_NO']=$studentFlightNo;
			$data['FAMILY_NAME']=str_replace('&','and',ucfirst($host['fname'].' '.$host['lname'])).', ';
			$data['HOMESTAY_ADDRESS']=$address;
			
			$homestay_phone='Not available';
			if($host['home_phone']!='')
				$homestay_phone=$host['home_phone'];
			//$data['HOMESTAY_PHONE']=$homestay_phone;
			$data['HOMESTAY_PHONE']=$host['mobile'];
			$data['HOMESTAY_MOBILE']=$host['mobile'];
			$data['EMERGENCY_PHONE']=phoneFormat($clientDetail['sec_phone']);
			//$data['APU_CONTACT_NUMBER']=mobileFormat($apuCompanyContactNamePhone);
			$data['APU_CONTACT_NUMBER']=$apu_companyPhone;
			
			//see($data);
			$this->generateFile($inputFileName,$outputFileName,$data);
			header('location:'.site_url().'static/wordFiles/generated/'.$outputFileName.'.docx');
		}
		else
			echo "Booking not found";
	}
	function dropoff_profile($id)
	{
		$booking=bookingDetails($id);
		if(!empty($booking))
		{
			$host=getHfaOneAppDetails($booking['host']);
			$student=getShaOneAppDetails($booking['student']);
			$student['two']=getShaTwoAppDetails($booking['student']);
			
			$apu_companyPhone=$apuCompanyContactNamePhone=$apuCompany='';
			$apuCompanyDetail=apuCompanyDetail($student['two']['apu_drop_company']);
			if(!empty($apuCompanyDetail))
			{
				$apuCompany=$apuCompanyDetail['company_name'];
				$apuCompanyContactNamePhone=$apuCompanyDetail['name'].' '.$apuCompanyDetail['phone'];
				$apu_companyPhone=$apuCompanyDetail['phone'];
			}
			
			//$outputFileName='ge 2018 - '.$apuCompany.' - '.$booking['id'].' - '.ucwords($student['fname'].' '.$student['lname']).'.doc';
			//$outputFileName='ge 2018 - drop Off sign '.$apuCompany.' - '.ucwords($student['fname'].' '.$student['lname']).'.doc';
			$outputFileName='ge ADO Profile - '.$apuCompany.' - '.ucwords($student['fname'].' '.$student['lname']);
			
		//	if($student['two']['airport_pickup']=='0')
			//	$outputFileName=$inputFileName='apuProfileNotRequested';
			
			
			//if($student['two']['airport_pickup']=='1')
		//	{
				$inputFileName='dropoffProfile';
				
				if($student['two']['apu_drop_company']!='')
				{
					if($student['two']['apu_drop_company']=='1')
						$inputFileName='dropoffProfile-2Stay';
					elseif($student['two']['apu_drop_company']=='2')	
						$inputFileName='dropoffProfile-Castle';
					elseif($student['two']['apu_drop_company']=='3')	
						$inputFileName='dropoffProfile-Melbourne';
					elseif($student['two']['apu_drop_company']=='4')
					{		
						$inputFileName='dropoffProfile-Darwin';
						$apu_companyPhone=$host['mobile'];
					}
					elseif($student['two']['apu_drop_company']=='5')
						$inputFileName='dropoffProfile-2Stay_holmes';
					elseif($student['two']['apu_drop_company']=='6')
						$inputFileName='dropoffProfile-RoyalLimousine';
				}
			//}
				
			$nameTitleList=nameTitleList();
			$salutation='';
			if($student['title']!='')
				$salutation=$nameTitleList[$student['title']];	
			
			$studentArrivalDate=$studentArrivalTime=$studentFlightNo='';
			if($student['two']['airport_dropoff']==1)
			{
				if($student['two']['airport_departure_date']!='0000-00-00')
					$studentArrivalDate=date('d M Y',strtotime($student['two']['airport_departure_date']));
				 
				 if($student['two']['airport_departure_time']!='00:00:00')
					 $studentArrivalTime=date('H:i',strtotime($student['two']['airport_departure_time']));
				
				 $studentFlightNo=ucfirst($student['two']['airport_drop_flightno']);
			}
			
			$address='';
			$stateList=stateList();
			if($host['street']!='')
				$address .=$host['street'].", ".ucfirst($host['suburb']).", ".$stateList[$host['state']].", ".$host['postcode'];
			
			$clientDetail=clientDetail($student['client']);
			
			$studentAge=age_from_dob($student['dob']);
			if($studentAge<18)
				$u18='(U18)';
			else
				$u18='';
				
			$data=array();
			$data['DATE_TODAY']=date('d M Y');
			$data['SALUTATION']=$salutation;
			$data['STUDENT_NAME']=ucwords($student['fname'].' '.$student['lname']);
			$data['u18']=$u18;
			$data['ARRIVAL_DATE']=$studentArrivalDate;
			$data['ARRIVAL_TIME']=$studentArrivalTime;
			$data['FLIGHT_NO']=$studentFlightNo;
			$data['FAMILY_NAME']=str_replace('&','and',ucfirst($host['fname'].' '.$host['lname'])).', ';
			$data['HOMESTAY_ADDRESS']=$data['FAMILY_NAME'].$address;
			$homestay_phone='Not available';
			if($host['home_phone']!='')
				$homestay_phone=$host['home_phone'];
			//$data['HOMESTAY_PHONE']=$homestay_phone;
			$data['HOMESTAY_PHONE']=$host['mobile'];
			$data['HOMESTAY_MOBILE']=$host['mobile'];
			$data['EMERGENCY_PHONE']=phoneFormat($clientDetail['sec_phone']);
			//$data['APU_CONTACT_NUMBER']=mobileFormat($apuCompanyContactNamePhone);
			$data['APU_CONTACT_NUMBER']=$apu_companyPhone;
			//see($data); die;
			
			$this->generateFile($inputFileName,$outputFileName,$data);
			header('location:'.site_url().'static/wordFiles/generated/'.$outputFileName.'.docx');
		}
		else
			echo "Booking not found";
	}
	
	function removeSpecialCharFromAll($data)
	{
		foreach($data as $k=>$v)
			$data[$k]=str_replace('&','and',ucfirst($v));
		return $data;
	}
}