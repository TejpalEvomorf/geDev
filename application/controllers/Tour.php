<?php
class Tour extends CI_Controller {
		function __construct()
		{
			parent::__construct();
			$this->load->model('tour_model');
			$this->load->model('sha_model');
		}
		function updateWarning()
		{
			$id = $_REQUEST['pk'];
			$value = $_REQUEST['value'];
			$name = $_REQUEST['name'];
			$sql="select sha_one_id from `warnings_study_tours` where `id`='".$id."'";
			$query=$this->db->query($sql);
			$row=$query->row_array();
			if(!empty($row))
			{
				$student_id = $row['sha_one_id'];
				if ($name=='dob' || $name=='booking_to' || $name=='booking_from')
				{
					$value = normalToMysqlDate($value);
				}	
				$SqlUpdate_sha_one="UPDATE `sha_one` SET `$name`='$value' WHERE id='$student_id'";
				$this->db->query($SqlUpdate_sha_one);
			}
			$sqlDel="delete from `warnings_study_tours` where `id`='".$id."'";
			$this->db->query($sqlDel);
			echo 'success';
		}

		function index()

		{
			if(checkLogin())
			{
				recentActionsAddData('tour','list','view');
				$get=$_GET;
				
				$data['page']='tour';
	
				$data['toursTemp']=$this->tour_model->toursList($get);
	
				$data['tours']=$data['toursTemp'];
	
				//echo "<pre>";
	
				//print_r($data);
	
				$this->load->view('system/header',$data);
	
				$this->load->view('system/tour/tour_list');
	
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();

		}

		function changeStatus()

		{

			$data=$_POST;

			$response='';

			if($data['shaChangeStatus_status']=='pending_invoice')

			{

				$response = $this->tour_model->checkMissingBookingDates($data);

				if($response=='not_found')

				{

					$this->tour_model->changeStatus($data);

					echo 'done';

				}

				else

				{

					$data['students']=$response;

					$this->load->view('system/tour/invalid_booking_date',$data);

				}

			}

			else

			{

				$this->tour_model->changeStatus($data);

				echo 'done';

			}

		}

		function filters($tour_id)

		{

			$data=$_POST;

			$data['tour_id']=$tour_id;

			$this->load->view('system/tour/filters',$data);

		}
		
		function listFilters()
		{
			$data=$_POST;
			//$data['tour_id']=$tour_id;
			$this->load->view('system/tour/listFilters',$data);
		}



		function create()

		{
			if(checkLogin())
			{
				$data['page']='create_tour';
	
				$this->load->view('system/header',$data);
	
				$this->load->view('system/tour/create_tour');
	
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();

		}

		function changeWarningPopContent($id,$type)
		{
			$getTourWarningsData['type']=$type;
			$getTourWarningsData['ids']=$id;
		  	$getTourWarningsData['students']=getTourWarnings($getTourWarningsData['type'],$getTourWarningsData['ids']);
			$this->load->view('system/tour/warningsCsv',$getTourWarningsData);
        }

		function changeStatusPopContent($id,$pageStatus)

		{

		 	$data=$this->tour_model->tourDetail($id);

		 	$data['pageStatus']=$pageStatus;

		 	$this->load->view('system/tour/changeStatusCancelForm',$data);

		}

		function getTourCSVHeader()

		{

			$headers_csv = array();

			

			$headers_csv[0]['column_name']='booking_from';

			$headers_csv[0]['label']='Start Date';



			$headers_csv[1]['column_name']='booking_to';

			$headers_csv[1]['label']='End Date';



			$headers_csv[2]['column_name']='fname';

			$headers_csv[2]['label']='First name';



			$headers_csv[3]['column_name']='lname';

			$headers_csv[3]['label']='Surname';



			$headers_csv[4]['column_name']='email';

			$headers_csv[4]['label']='Email';



			$headers_csv[5]['column_name']='mobile';

			$headers_csv[5]['label']='Phone';



			$headers_csv[6]['column_name']='dob';

			$headers_csv[6]['label']='Date of Birth';



			$headers_csv[7]['column_name']='gender';

			$headers_csv[7]['label']='Gender';



			$headers_csv[8]['column_name']='nation';

			$headers_csv[8]['label']='Nationality';



			$headers_csv[9]['column_name']='allergy_req';

			$headers_csv[9]['label']='Allergies';



			$headers_csv[10]['column_name']='allergy_hay_fever';

			$headers_csv[10]['label']='If yes, please specify';



			$headers_csv[11]['column_name']='live_with_pets';

			$headers_csv[11]['label']='Pets Yes/No';



			$headers_csv[12]['column_name']='pet_other_val';

			$headers_csv[12]['label']='If yes, please specify';



			$headers_csv[13]['column_name']='live_with_child11';

			$headers_csv[13]['label']='Stay with Kids Yes/No';



			$headers_csv[14]['column_name']='live_with_child_reason';

			$headers_csv[14]['label']='If no, please specify';

			

			$headers_csv[15]['column_name']='family_pickup_meeting_point';

			$headers_csv[15]['label']='Family to pick up from the meeting point';



			$headers_csv[16]['column_name']='airport_pickup_meeting_point';

			$headers_csv[16]['label']='Airport pick up to meeting point';



			$headers_csv[17]['column_name']='airport_pickup_homestay';

			$headers_csv[17]['label']='Airport pick up to homestay';



			$headers_csv[18]['column_name']='accomodation_type';

			$headers_csv[18]['label']='Type of Accommodation';



			$headers_csv[19]['column_name']='special_request_notes';

			$headers_csv[19]['label']='Special Request or notes';



			$headers_csv[20]['column_name']='arrival_date';

			$headers_csv[20]['label']='Arrival Date';
			
			$headers_csv[21]['column_name']='pickup_time';
			$headers_csv[21]['label']='Pick up time';
			
			$headers_csv[22]['column_name']='dropoff_time';
				$headers_csv[22]['label']='Drop off time';

			return $headers_csv;

			

		}

		function readCsv($file)

		{

			$this->load->library('excel');

			

			$excelFile =$file;

		 

			$objReader = PHPExcel_IOFactory::createReader('Excel2007');

			$objPHPExcel = $objReader->load($excelFile);

			 

			//Itrating through all the sheets in the excel workbook and storing the array data

			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {

			    $arrayData[$worksheet->getTitle()] = $worksheet->toArray();

			}

			 

			//see($arrayData['Sheet1']);

			//return $arrayData['Sheet1'];

			return $arrayData;

		}

		

		function uploadExcel()

		{

			$res=array();

			if(checkLogin())
			{
				$nationList=nationList();
				$nationList=array_map('strtolower', $nationList);

				$data=$_POST;

				$file=$_FILES['importStudentFile']['tmp_name'];

				$study_tour_id = $_POST['study_tour_id'];

				$client_id = $_POST['client_id'];
				$employee_id = $_POST['employee_id'];

				$total_records = 0;

				$duplicate_records = 0;

				$inserted_records = 0;



				$this->load->library('excel');

				$objReader = PHPExcel_IOFactory::createReader('Excel2007');

				$objPHPExcel = $objReader->load($file);

				$accomodation_types =  array(

					'1'=>'Homestay Single Room',

					'2'=>'Homestay Twin Share',

					'3'=>'Homestay Self-Catered',

					'4'=>'Homestay VIP Single Room',

					'5'=>'Homestay VIP Self-Catered'/*,

					'6'=>'Student Shared Apartment',

					'7'=>'Student Shared House'*/

				);

				$allergy_types =  array(

					'allergy_hay_fever'=>'Hay Fever',

					'allergy_asthma'=>'Asthma',

					'allergy_lactose'=>'Lactose Intolerance',

					'allergy_gluten'=>'Gluten Intolerance',

					'allergy_peanut'=>'Peanut Allergies',

					'allergy_dust'=>'Dust Allergies',

				);


				foreach ($objPHPExcel->getWorksheetIterator() as $worksheetK=>$worksheet) {

					//print_r($worksheet);
					if($worksheetK==0)
					{
					$last_row = $worksheet->getHighestRow();

					$worksheet->getStyle("F2:F".$last_row)->getNumberFormat()->setFormatCode('0000000000'); 

					$worksheet->getStyle("A2:A".$last_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2); 

					$worksheet->getStyle("B2:B".$last_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2); 

					$worksheet->getStyle("G2:G".$last_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2); 

					$worksheet->getStyle("U2:U".$last_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2); 
					$worksheet->getStyle("V2:V".$last_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME1); 
					$worksheet->getStyle("W2:W".$last_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME1); 
					
					
					$group = $worksheet->toArray();

				    //see($group);die();



				    if(!empty($group)) {

				    	$csv_header = array_shift($group);

				    	$csv_tour_list_header = $this->getTourCSVHeader();

						if(count($csv_header)<21)

						{

							ob_start();

							$this->session->set_flashdata('csv_summary_status',json_encode(array('error'=>count($csv_header).' Invalid CSV File Header Length')));

							redirect('tour/edit/'.$study_tour_id);

						}



						$notmatch=false;

						foreach($csv_tour_list_header as $key=>$record)

						{

							if(trim($csv_header[$key])!=$csv_tour_list_header[$key]['label'])

							{

								$notmatch=true;	

							}	

						}

						if($notmatch)

						{

							ob_start();

							$this->session->set_flashdata('csv_summary_status',json_encode(array('error'=>'Invalid CSV File Header Labels Mismatch with Our System or database')));

							redirect('tour/edit/'.$study_tour_id);

						}

						$inserted_csv_warnings = array();

						$i=0;

						$invalid_student_arr = array();

						foreach($group as $key=>$line) {

							$insert = array();

							if(empty($line[2]))
								continue;
							else	
								$total_records++;

							$invalid_booking_from=false;

							$invalid_booking_to=false;

							$invalid_dob=false;

							$invalid_email=false;
							$invalid_nation=false;
							
							$line[18]=trim($line[18]);
							if (in_array($line[18],$accomodation_types)) {

								$accomodation_key = array_search($line[18], $accomodation_types);

								$line[18] = $accomodation_key;

							}

							$allergy_key='';

							$allergy_other='';

							$allergy_other_val='';

							if(strtolower(trim($line[9]))=='yes') {

								if (in_array(strtolower(trim($line[10])),$allergy_types)) {

									$allergy_key = array_search(strtolower(trim($line[10])),$allergy_types);

								}

								else {

									$allergy_other=1;

									$allergy_other_val=$line[10];

								}

							}

							$insert['booking_from'] = $line[0];	// table sha_one.booking_from

							$d = DateTime::createFromFormat('Y-m-d', $insert['booking_from']);
$d1 = DateTime::createFromFormat('d/m/Y', $insert['booking_from']);
    						//$result =  $d && $d->format('Y-m-d') === $insert['booking_from'];
							
	  if(!empty($d1))
				$insert['booking_from']=$d1->format('Y-m-d') ;
$result =  ($d || $d1);
    						if(!$result) {

    							$invalid_booking_from=true;

    							$insert['booking_from']='0000-00-00';

    						}

							 $insert['booking_to'] = $line[1];	// table sha_one.booking_to

							$d = DateTime::createFromFormat('Y-m-d', $insert['booking_to']);
							$d1 = DateTime::createFromFormat('d/m/Y', $insert['booking_to']);
$result =  ($d || $d1);
    						//$result =  $d && $d->format('Y-m-d') === $insert['booking_to'];
    						//$result1=  $d1 && $d1->format('d/m/Y') === $insert['booking_to'];

	  if(!empty($d1)){
				$insert['booking_to']=$d1->format('Y-m-d') ;
	  }
			
    						if(!$result) {

    							$invalid_booking_to=true;

    							$insert['booking_to']='0000-00-00';

    						}
//see($insert); die;
							$insert['fname'] = !empty($line[2])?$line[2]:'';	// table sha_one.fname

							$insert['lname'] = !empty($line[3])?$line[3]:''; 	// table sha_one.lname

							$insert['email'] = !empty($line[4])?$line[4]:'no-reply@globalexperience.com.au';		// table sha_one.email

							if(!empty($insert['email'])) {

								if (!filter_var($insert['email'], FILTER_VALIDATE_EMAIL)) 

								{

									$invalid_email=true;

									$insert['email'] = '';	

								}

							}
							
							
							$insert['mobile'] = !empty($line[5])?$line[5]:'0000000000';		// table sha_one.dob

							// number_format($line[5],0,'','');

							$insert['dob'] = !empty($line[6])?$line[6]:'';		// table sha_one.dob
							//$insert['dob'] =normalToMysqlDate($insert['dob']);//see($insert['dob']);
							$d = DateTime::createFromFormat('Y-m-d', $insert['dob']);
$d1 = DateTime::createFromFormat('d/m/Y', $insert['dob']);
    						//$result =  $d && $d->format('Y-m-d') === $insert['dob'];
							if(!empty($d1))
				$insert['dob']=$d1->format('Y-m-d') ;
							$result =  ($d || $d1);

    						if(!$result) {

    							$invalid_dob=true;

    							$insert['dob']='0000-00-00';
//echo "yes";
    						}//else{echo "no";}

							$insert['gender'] = $line[7]=='Male'?1:2;	// table sha_one.gender
							$insert['title']= $line[7]=='Male'?1:3;

							$insert['nation'] = !empty($line[8])?$line[8]:'';	// table sha_one.nation

							if(!empty($insert['nation'])) {
									if(!in_array(trim(strtolower($insert['nation'])),$nationList))
									{
										$invalid_nation=true;
										$insert['nation'] = '';
									}
									else
										$insert['nation'] = array_search(trim(strtolower($insert['nation'])),$nationList);
							}

							 $insert['arrival_date'] = !empty($line[20])?$line[20]:'';	// table sha_one.arrival_date
							

							$d = DateTime::createFromFormat('Y-m-d', $insert['arrival_date']);
							$d1 = DateTime::createFromFormat('d/m/Y', $insert['arrival_date']);
            if(!empty($d1))
				$insert['arrival_date']=$d1->format('Y-m-d') ;
			
    						$result =  ($d || $d1);

    						if(!$result) {

    							

    							$insert['arrival_date']='0000-00-00';

    						}

							$insert['accomodation_type'] = !empty($line[18])?$line[18]:'';	// table sha_one.accomodation_type

							$insert['special_request_notes'] = !empty($line[19])?$line[19]:'';	// table sha_one.special_request_notes

							$date_created = date('Y-m-d H:i:s');

							// check uniqueness

							$unique_csv_record = md5($insert['fname'].$insert['lname'].$insert['dob']);

							$sql_exist_query="select 1 from `sha_one` where `unique_csv_record`='$unique_csv_record'";

							$query_exist=$this->db->query($sql_exist_query);

							if($query_exist->num_rows() > 0 ) {
								//echo $this->db->last_query().'<br>';;
								$duplicate_records++;

							}

							else {

								$inserted_records++;
							

								$sqlInsert_sha_one = "insert into `sha_one` (`booking_from`,`booking_to`,`title`,`fname`,`lname`,`email`,`mobile`,`dob`,`gender`,`nation`,`arrival_date`,`accomodation_type`,`special_request_notes`,`client`,`employee`,`study_tour_id`,`date`,`unique_csv_record`,`step`,`study_group`,`filled_by`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
							//	see($insert);
								if($insert['booking_to']!='0000-00-00')
									$insert['booking_to']=date('Y-m-d',strtotime($insert['booking_to'].' -1 day'));//to make last day move out day
							//$insert['booking_to']=	date('Y-m-d', strtotime('-1 day', strtotime($insert['booking_to'])));
								//see($insert);die;
								$this->db->query($sqlInsert_sha_one,array($insert['booking_from'],$insert['booking_to'],$insert['title'],ucwords($insert['fname']),ucwords($insert['lname']),$insert['email'],$insert['mobile'],$insert['dob'],$insert['gender'],$insert['nation'],$insert['arrival_date'],$insert['accomodation_type'],$insert['special_request_notes'],$client_id,$employee_id,$study_tour_id,$date_created,$unique_csv_record,4,'1',2));



								$student_id = $this->db->insert_id();

								//$insert['live_with_pets'] = (strtolower($line[11])=='yes'?1:0);;	// table sha_two.live_with_pets
								if(strtolower($line[11])=='yes')
									$insert['live_with_pets']=1;
								elseif(strtolower($line[11])=='no')
									$insert['live_with_pets']=0;
								else
									$insert['live_with_pets']='';
								
								$insert['pet_other_val'] = !empty($line[12])?$line[12]:'';	// table sha_two.pet_other_val
								$insertPetValCat=$insertPetValDog=$insertPetValBird='0';
								$insertPetValOther='0';
								$insertPetValOtherVal='';
								if($insert['live_with_pets']==1 && trim($insert['pet_other_val'])!='')
								{
									$insertPetVal=explode(',',$insert['pet_other_val']);
									$insertPetVal=array_map('strtolower', $insertPetVal);
									$insertPetVal=array_map('trim', $insertPetVal);
									
									if(in_array('cat',$insertPetVal))
										$insertPetValCat='1';
									if(in_array('dog',$insertPetVal))
										$insertPetValDog='1';
									if(in_array('bird',$insertPetVal))
										$insertPetValBird='1';
									
									foreach($insertPetVal as $ipv)
									{
										if(!in_array($ipv,array('cat','dog','bird')))
										{
											$insertPetValOther='1';
											$insertPetValOtherVal .=$ipv.' ';
										}
									}
								}

								
								if(strtolower($line[15])=='yes')
									$insert['family_pickup_meeting_point']='1';
								elseif(strtolower($line[15])=='no')
									$insert['family_pickup_meeting_point']='0';
								else
									$insert['family_pickup_meeting_point']='';
								
								if(strtolower($line[16])=='yes')
									$insert['airport_pickup_meeting_point']='1';
								elseif(strtolower($line[16])=='no')
									$insert['airport_pickup_meeting_point']='0';
								else
									$insert['airport_pickup_meeting_point']='';
								
								if(strtolower($line[17])=='yes')
									$insert['airport_pickup_homestay']='1';
								elseif(strtolower($line[17])=='no')
									$insert['airport_pickup_homestay']='0';
								else
									$insert['airport_pickup_homestay']='';

								$guardianship='';
								if($insert['dob']!='0000-00-00')
								{
									$ageStudent=age_from_dob($insert['dob']);
									if($ageStudent<18)
										$guardianship='0';
								}
								
								$insert['airport_arrival_time'] = !empty($line[21])? normalToMysqlTime(str_replace('+',' ',$line[21])) :'';	
								$insert['airport_departure_time'] = !empty($line[22])? normalToMysqlTime(str_replace('+',' ',$line[22])) :'';	
								$sqlInsert_sha_two = "insert into `sha_two` (`id`,`live_with_pets`,`pet_dog`,`pet_cat`,`pet_bird`,`pet_other`,`pet_other_val`,`family_pickup_meeting_point`,`airport_pickup_meeting_point`,`airport_pickup`,`guardianship`,`ethnicity`,`insurance`,`airport_arrival_time`,`airport_departure_time`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

								$this->db->query($sqlInsert_sha_two,array($student_id,$insert['live_with_pets'],$insertPetValDog,$insertPetValCat,$insertPetValBird,$insertPetValOther,$insertPetValOtherVal,$insert['family_pickup_meeting_point'],$insert['airport_pickup_meeting_point'],$insert['airport_pickup_homestay'],$guardianship,$insert['nation'],'0',$insert['airport_arrival_time'],$insert['airport_departure_time']));



								//$insert['allergy_req'] = strtolower($line[9])=='yes'?'1':'0';		// table sha_three.allergy_req
								if(strtolower($line[9])=='yes')
									$insert['allergy_req']='1';
								elseif(strtolower($line[9])=='no')
									$insert['allergy_req']='0';
								else
									$insert['allergy_req']='';
								$insert['allergy_yes_val'] = !empty($line[10])?$line[10]:'';		// table sha_three.college
								$insertAllergyValHayfever=$insertAllergyValAsthma=$insertAllergyValLactose=$insertAllergyValGluten=$insertAllergyValPeanut=$insertAllergyValDust='0';
								$insertAllergyValOther='0';
								$insertAllergyValOtherVal='';
								if($insert['allergy_req']=='1' && trim($insert['allergy_yes_val'])!='')
								{
									$insertAllergyVal=explode(',',$insert['allergy_yes_val']);
									$insertAllergyVal=array_map('strtolower', $insertAllergyVal);
									$insertAllergyVal=array_map('trim', $insertAllergyVal);
									
									if(in_array('hay fever',$insertAllergyVal))
										$insertAllergyValHayfever='1';
									if(in_array('asthma',$insertAllergyVal))
										$insertAllergyValAsthma='1';
									if(in_array('lactose intolerance',$insertAllergyVal))
										$insertAllergyValLactose='1';
									if(in_array('gluten intolerance',$insertAllergyVal))
										$insertAllergyValGluten='1';
									if(in_array('peanut allergies',$insertAllergyVal))
										$insertAllergyValPeanut='1';
									if(in_array('dust allergies',$insertAllergyVal))
										$insertAllergyValDust='1';
									
									
									foreach($insertAllergyVal as $iav)
									{
										if(!in_array($iav,array('hay fever','asthma','lactose intolerance','gluten intolerance','peanut allergies','dust allergies')))
										{
											$insertAllergyValOther='1';
											$insertAllergyValOtherVal .=$iav.' ';
										}
									}
								}

								if(trim(strtolower($line[13]))=='yes')
									$insert['live_with_child11']=$insert['live_with_child20']=1;
								elseif(trim(strtolower($line[13]))=='no')
									$insert['live_with_child11']=$insert['live_with_child20']=0;
								else	
									$insert['live_with_child11']=$insert['live_with_child20']='';

								$insert['live_with_child_reason'] = !empty($line[14])?$line[14]:'';	// table sha_three.live_with_child_reason



								$sqlInsert_sha_three = "insert into `sha_three` (`id`,`allergy_req`,`allergy_hay_fever`,`allergy_asthma`,`allergy_lactose`,`allergy_gluten`,`allergy_peanut`,`allergy_dust`,`allergy_other`,`allergy_other_val`,`live_with_child11`,`live_with_child20`,`live_with_child_reason`) values (?,?,?,?,?,?,?,?,?,?,?,?,?)";



								$this->db->query($sqlInsert_sha_three,array($student_id,$insert['allergy_req'],$insertAllergyValHayfever,$insertAllergyValAsthma,$insertAllergyValLactose,$insertAllergyValGluten,$insertAllergyValPeanut,$insertAllergyValDust,$insertAllergyValOther,$insertAllergyValOtherVal,$insert['live_with_child11'],$insert['live_with_child20'],$insert['live_with_child_reason']));


								if($invalid_booking_from || $invalid_booking_to || $invalid_dob || $invalid_email || $invalid_nation)

								{

									

									$insert_invalid_booking_from='';

									$insert_invalid_booking_to='';

									$insert_invalid_dob='';

									$insert_invalid_email='';
									$insert_invalid_nation='';

									

									$inserted_csv_warnings[$i]['record']=$line;

									if($invalid_booking_from)

									{

										$insert_invalid_booking_from = $line[0];

										$inserted_csv_warnings[$i]['record']['error'][]='booking_from';

										$invalid_student_arr[] = $student_id;

									}

									if($invalid_booking_to)

									{

										$insert_invalid_booking_to = $line[1];

										$inserted_csv_warnings[$i]['record']['error'][]='booking_to';

										$invalid_student_arr[] = $student_id;

									}

									if($invalid_dob)

									{

										$insert_invalid_dob = $line[6];	

										$inserted_csv_warnings[$i]['record']['error'][]='dob';

										$invalid_student_arr[] = $student_id;

									}

									if($invalid_email)

									{

										$insert_invalid_email = $line[4];	

										$inserted_csv_warnings[$i]['record']['error'][]='email';

										$invalid_student_arr[] = $student_id;

									}
									
									if($invalid_nation)

									{

										$insert_invalid_nation = $line[8];	

										$inserted_csv_warnings[$i]['record']['error'][]='nation';

										$invalid_student_arr[] = $student_id;

									}



									$student_warning_exist="Select 1 from `warnings_study_tours` where `id` = ?";

									$row_warning_exist=	$this->db->query($student_warning_exist,$student_id);

									if ($row_warning_exist->num_rows() > 0)

									{

										$sql_delete_student="DELETE from `warnings_study_tours` where `id`='".$student_id."'";

										$this->db->query($sql_delete_student);

									}

									

									if($insert_invalid_booking_to) {

										$sqlInsert_warnings_csv_booking_to = "insert into `warnings_study_tours` (`sha_one_id`,`study_tour_id`,`column_name`,`column_value`) values (?,?,?,?)";

										$this->db->query($sqlInsert_warnings_csv_booking_to,array($student_id,$study_tour_id,'booking_to',$insert_invalid_booking_to));	

									}



									if($insert_invalid_booking_from) {

										$sqlInsert_warnings_csv_booking_from = "insert into `warnings_study_tours` (`sha_one_id`,`study_tour_id`,`column_name`,`column_value`) values (?,?,?,?)";

										$this->db->query($sqlInsert_warnings_csv_booking_from,array($student_id,$study_tour_id,'booking_from',$insert_invalid_booking_from));	

									}



									if($insert_invalid_dob) {

										$sqlInsert_warnings_csv_dob = "insert into `warnings_study_tours` (`sha_one_id`,`study_tour_id`,`column_name`,`column_value`) values (?,?,?,?)";

										$this->db->query($sqlInsert_warnings_csv_dob,array($student_id,$study_tour_id,'dob',$insert_invalid_dob));	

									}

									if($insert_invalid_email) {

										$sqlInsert_warnings_csv_email = "insert into `warnings_study_tours` (`sha_one_id`,`study_tour_id`,`column_name`,`column_value`) values (?,?,?,?)";

										$this->db->query($sqlInsert_warnings_csv_email,array($student_id,$study_tour_id,'email',$insert_invalid_email));	

									}
									
									if($insert_invalid_nation) {

										$sqlInsert_warnings_csv_nation = "insert into `warnings_study_tours` (`sha_one_id`,`study_tour_id`,`column_name`,`column_value`) values (?,?,?,?)";

										$this->db->query($sqlInsert_warnings_csv_nation,array($student_id,$study_tour_id,'nation',$insert_invalid_nation));	

									}



								}	



							} // if inserted 

							$i++;

						} // foreach loop

					} else {

						ob_start();

						$this->session->set_flashdata('csv_summary_status',json_encode(array('error'=>'Blank worksheet Found')));

						redirect('tour/edit/'.$study_tour_id);

					}

				}	
			}

			}	

				ob_start();

				if($total_records==0)
					$this->session->set_flashdata('csv_summary_status',json_encode(array('error'=>'No records in worksheet')));
				else	
					$this->session->set_flashdata('csv_summary_status',json_encode(array('total_records'=>$total_records,'duplicate_records'=>$duplicate_records,'inserted_records'=>$inserted_records,'warnings'=>!empty($inserted_csv_warnings)?$inserted_csv_warnings:'','invalid_student_arr'=>!empty($invalid_student_arr)?$invalid_student_arr:'')));

				redirect('tour/edit/'.$study_tour_id);

		}

		function warningSubmit()

		{	



			$id = $_POST['id'];

			$dob = $_POST['insert_invalid_dob'];

			$email = $_POST['insert_invalid_email'];

			$booking_from = $_POST['invalid_booking_from'];

			$booking_to = $_POST['invalid_booking_to'];



			$update_string_arr = array();

			if(!empty($dob))

			{

				$dob = normalToMysqlDate($dob);

				$update_string_arr[]= "`dob`='$dob'";

			}

			if(!empty($email))

			{

				$update_string_arr[]= "`email`='$email'";

			}

			if(!empty($booking_from))

			{

				$booking_from = normalToMysqlDate($booking_from);

				$update_string_arr[]= "`booking_from`='$booking_from'";

			}

			if(!empty($booking_to))

			{

				$booking_to = normalToMysqlDate($booking_to);

				$update_string_arr[]= "`booking_to`='$booking_to'";

			}

			$update_string = implode(',',$update_string_arr);

			$sql_update="UPDATE `sha_one` set $update_string WHERE `id`='$id'";

			$this->db->query($sql_update);



			$sqlfetch_study_group_id ="Select study_tour_id from `warnings_study_tours` where `id` = ".$id;

			$result_fetch_study_grp=$this->db->query($sqlfetch_study_group_id);

			$row_study_group_id=$result_fetch_study_grp->row_array();



			$sql_delete_warning = "DELETE from `warnings_study_tours` WHERE `id`='".$id."'";

			$this->db->query($sql_delete_warning);



			$count_study_group_id ="Select study_tour_id from `warnings_study_tours` where `study_tour_id` = ".$row_study_group_id['study_tour_id'];

			$result_count = $this->db->query($count_study_group_id);

			//echo $this->db->last_query();

			$warnings_count = $result_count->num_rows();



			echo json_encode(array('msg'=>'success','query'=>$sql_update,'count_warnings'=>$warnings_count));

		}

		function createSubmit()

		{

			if(checkLogin())

			{

				$data=$_POST;

				$data=trimArrayValues($data);

				$res=array();

				$valid=$this->tour_model->validateTour($data);

				if(!is_array($valid) && $valid=='yes')

				{

					if(isset($data['id']))

						$res['done']['id']=$this->tour_model->editTour($data);

					else

						$res['done']['id']=$this->tour_model->createTour($data);

				}

				else
					{
						$res['done']['id']=$this->tour_model->createTour($data);
						recentActionsAddData('tour',$res['done']['id'],'add');
					}

			}

			else

				$res['logout']="LO";



			echo json_encode($res);

		}



		function placed_students($tour_id)

		{
			if(checkLogin())
			{
				$data['page']='palced_students';

				$data['students']=$this->sha_model->getPlacedStudentsByTourId($tour_id);
	
				$data['tour']=$this->tour_model->tourDetail($tour_id);
	
	
	
	
	
				if(empty($data['tour']))
	
					header('location:'.site_url().'tour');
	
				$this->load->view('system/header',$data);
	
				$this->load->view('system/tour/placed_students');
	
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();

		}

		function pending_students($tour_id)

		{
			if(checkLogin())
			{
				$data['page']='pending_students';

				$data['students']=$this->sha_model->getPendingStudentsByTourId($tour_id);
	
				$data['tour']=$this->tour_model->tourDetail($tour_id);
	
	
	
	
	
				if(empty($data['tour']))
	
					header('location:'.site_url().'tour');
	
				$this->load->view('system/header',$data);
	
				$this->load->view('system/tour/pending_students');
	
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();

		}



		function all_students($tour_id)

		{
			if(checkLogin())
			{
				recentActionsAddData('tour',$tour_id,'view_manage');

				$data['page']='all_students';
	
				$data['students']=$this->sha_model->getStudentsByTourId($tour_id);
	
				$data['tour']=$this->tour_model->tourDetail($tour_id);
	
	
	
				if(empty($data['tour']))
	
					header('location:'.site_url().'tour');
	
				$this->load->view('system/header',$data);
	
				$this->load->view('system/tour/all_students');
	
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();

		}

		function edit($id)

		{
			if(checkLogin())
			{
				recentActionsAddData('tour',$id,'view');

				$data['page']='edit_tour';
	
				$data['tour']=$this->tour_model->tourDetail($id);
	
				if(empty($data['tour']))
	
					header('location:'.site_url().'tour');
	
				$this->load->view('system/header',$data);
	
				$this->load->view('system/tour/edit_tour');
	
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();

		}



		function deleteTour()

		{

			if(isset($_POST['id']))

			{

				$this->tour_model->deleteTour($_POST['id']);

				echo "done";

			}

		}



		function tour_agreement_upload()

		{

			if($_FILES['file']['name']!= "")

				  {

						$path="./static/uploads/tour";

						$t1=time();

						$imagename=$t1.$_FILES['file']['name'];

						move_uploaded_file($_FILES['file']['tmp_name'],$path.'/'.$imagename);



						$this->tour_model->client_agreement_upload($_POST['clientId'],$imagename);

						$data['tour']=$this->tour_model->clientDetail($_POST['clientId']);

						$this->load->view('system/tour/agreement_list',$data);

					}

		}



		function updateTourCategory()

		{

			if(checkLogin())

			{

				if(isset($_POST['id']))

				{

					$this->tour_model->updateClientCategory($_POST);

					echo "done";

				}

			}

			else

				echo "LO";

		}



	function deleteTourAgreement()

	{

		if(checkLogin())

		{

			if(isset($_POST['id']))

			{

				$this->tour_model->deleteTourAgreement($_POST['id']);

				echo "done";

			}

		}

		else

			echo "LO";

	}



	function tour_logo_upload()

	{

		if($_FILES['file']['name']!= "")

		{

			$path="./static/uploads/tour/logo";

			$t1=time();

			$imagename=$t1.$_FILES['file']['name'];

			move_uploaded_file($_FILES['file']['tmp_name'],$path.'/'.$imagename);



			$large_image_location=$path.'/'.$imagename;

			$thumb_image_location=$path.'/thumbs/'.$imagename;



			cropImageFromSides($large_image_location,$thumb_image_location,'250','250');

			$this->tour_model->tour_logo_upload($_POST['tourId'],$imagename);

			$data['tour']=$this->tour_model->clientDetail($_POST['tourId']);

			$this->load->view('system/tour/tour_edit_page_logo',$data);

		}

	}

	function resolveWarning()
	{
		if(checkLogin())
			{
				$data=$_POST;
				if(trim($data['warning_id'])!='')
				{
					if(!isset($data['guardianship_startDate']))
						$this->tour_model->resolveWarning($data);
					else	
						$this->sha_model->guardianshipOfficeUseDurationSubmit($data);
					
					$warnings=getTourWarnings($data['type'],$data['ids']);
					echo json_encode(array('result'=>"done",'count'=>count($warnings)));
				}
			}
			else
				echo json_encode(array('logout'=>"LO"));
	}
	
	
	function initialInvoiceUpdateDuration()
	{
		$data=$_POST;
		$tour=tourDetail($data['shaChangeStatus_id']);
		$totalDays=($data['weeks']*7)+($data['days'])-1;
		$invoice=initialInvoiceDetails($data['invoice_id']);
		$data['booking_from']=$invoice['booking_from'];
		$data['booking_to']=date('Y-m-d',strtotime($data['booking_from'].' +'.$totalDays.' days'));
		$this->tour_model->updatePendingInvoice($data);
	}
	
	function resetInitialInvoice($invoiceId)
	{
		$initialInvoiceDetails=initialInvoiceDetails($invoiceId);
		$tour=tourDetail($initialInvoiceDetails['application_id']);
		/*if($tour['status']=='pending_invoice')
		  {*/
			  $this->tour_model->resetInitialInvoice($invoiceId,$initialInvoiceDetails['application_id']);
			  $this->session->set_flashdata('initialInvoiceReset','yes');
		  /*}*/
	}
	
	function resetOngoingInvoice_old($invoiceId)
	{
		$ongoingInvoiceDetailsCurrent=ongoingInvoiceDetails($invoiceId);
		//see($ongoingInvoiceDetailsCurrent);
		$duration['from']=$from=$ongoingInvoiceDetailsCurrent['booking_from'];
			
		$ongoingInvoiceDetails=$this->tour_model->lastInvoiceWithEndingDate($ongoingInvoiceDetailsCurrent['application_id'],date('Y-m-d',strtotime($ongoingInvoiceDetailsCurrent['booking_from'].' - 1 day')));
		$initialInvoices[]=$ongoingInvoiceDetails;
		$date=date('Y-m-d',strtotime($ongoingInvoiceDetailsCurrent['booking_from'].' - 1 day'));
		//see($initialInvoices);
		$tours=array();
			foreach($initialInvoices as $invoice)
			{
				$application=array();
				$prevItemAppId='';
				$prevItemDesc='';
				
				foreach($invoice['items'] as $itemK => $item)
				{
					if($item['type']=='accomodation' || $item['type']=='accomodation_ed')
					{
						if($item['type']=='accomodation_ed')
						{
							$currentItemAppId=$item['application_id'];
							$prevItemDescArray=explode('(',$prevItemDesc);
							$currentItemDescArray=explode('(',$item['desc']);
							
							if($prevItemAppId==$currentItemAppId)
							{
								$datesCurrent=explode('to',getTextBetweenBrackets($item['desc']));
								$datesPrev=explode('to',getTextBetweenBrackets($prevItemDesc));
								end($application);         // move the internal pointer to the end of the array
								$keyApp = key($application);
								$application[$keyApp]['dates']=$datesPrev[0].'to ';
								if(isset($datesCurrent[1]))
									$application[$keyApp]['dates'] .=trim($datesCurrent[1]);
								else	
									$application[$keyApp]['dates'] .=trim($datesCurrent[0]);
							}
						}
						else
						{
							$app['application_id']=$item['application_id'];
							$app['dates']=getTextBetweenBrackets($item['desc']);
							$application[]=$app;
						}
						$prevItemAppId=$item['application_id'];
						$prevItemDesc=$item['desc'];
					}
				}
				$tour['tour_id']=$invoice['application_id'];
				$tour['applications']=$application;
				$tours[]=$tour;
			}
			//see($tours);
			
			foreach($tours as $tourK=>$tour)
			{
				$duration=array();
				foreach($tour['applications'] as $appK=>$app)
				{
					$dates=datesFromText($app['dates']);
					$bookingDetails=bookingByShaId($app['application_id']);
					if(!empty($bookingDetails))
					{
						$from=date('Y-m-d',strtotime($dates['to'].' + 1 day'));
						if($bookingDetails['booking_to']=='0000-00-00')
							$to=date('Y-m-d',strtotime($from.' +4 weeks -1 day'));
						else	
							{
								$dayDiff=dayDiff($from,$bookingDetails['booking_to']);
								//$dayDiff--;// dec 1 day as last day is checkout date
						
								if($dayDiff>28)
								{
									$to=date('Y-m-d',strtotime($from.' +4 weeks -1 day'));
									
									if($dayDiff<35)
										$to=$bookingDetails['booking_to'];
								}
								else	
									$to=$bookingDetails['booking_to'];
							}
							
							$tours[$tourK]['applications'][$appK]['from']=$from;
							$tours[$tourK]['applications'][$appK]['to']=$to;
							
							$duration['from']=date('Y-m-d',strtotime($date.' + 1 day'));
							if(!isset($duration['to']) || (isset($duration['to']) && strtotime($to)>strtotime($duration['to'])))
								$duration['to']=$to;
							
							$tours[$tourK]['applications'][$appK]['items']=$ongInvItems=ongInvItems($from,$to,$app['application_id']);
							//see($ongInvItems);
					}
				}
				$tours[$tourK]['duration']=$duration;
				
			}
			//see($tours);
			$this->tour_model->resetOngoingInvoice($tours,$invoiceId);
	}
	
	
	function ongoingInvoiceUpdateDuration_old()
	{
		$data=$_POST;
		
		$data['invoiceId']=$data['invoice_id'];
		$ongoingInvoiceDetailsCurrent=ongoingInvoiceDetails($data['invoiceId']);
		$sha=getShaOneAppDetails($data['shaChangeStatus_id']);
		$totalDays=($data['weeks']*7)+($data['days'])-1;
		
		$duration['from']=$fromInvoice=$ongoingInvoiceDetailsCurrent['booking_from'];
		
		$ongoingInvoiceDetails=$this->tour_model->lastInvoiceWithEndingDate($ongoingInvoiceDetailsCurrent['application_id'],date('Y-m-d',strtotime($ongoingInvoiceDetailsCurrent['booking_from'].' - 1 day')));
		$initialInvoices[]=$ongoingInvoiceDetails;
		$date=date('Y-m-d',strtotime($ongoingInvoiceDetailsCurrent['booking_from'].' - 1 day'));
		
		$tours=array();
			foreach($initialInvoices as $invoice)
			{
				$application=array();
				$prevItemAppId='';
				$prevItemDesc='';
				
				foreach($invoice['items'] as $itemK => $item)
				{
					if($item['type']=='accomodation' || $item['type']=='accomodation_ed')
					{
						if($item['type']=='accomodation_ed')
						{
							$currentItemAppId=$item['application_id'];
							$prevItemDescArray=explode('(',$prevItemDesc);
							$currentItemDescArray=explode('(',$item['desc']);
							
							if($prevItemAppId==$currentItemAppId)
							{
								$datesCurrent=explode('to',getTextBetweenBrackets($item['desc']));
								$datesPrev=explode('to',getTextBetweenBrackets($prevItemDesc));
								end($application);         // move the internal pointer to the end of the array
								$keyApp = key($application);
								$application[$keyApp]['dates']=$datesPrev[0].'to ';
								if(isset($datesCurrent[1]))
									$application[$keyApp]['dates'] .=trim($datesCurrent[1]);
								else	
									$application[$keyApp]['dates'] .=trim($datesCurrent[0]);
							}
						}
						else
						{
							$app['application_id']=$item['application_id'];
							$app['dates']=getTextBetweenBrackets($item['desc']);
							$application[]=$app;
						}
						$prevItemAppId=$item['application_id'];
						$prevItemDesc=$item['desc'];
					}
				}
				$tour['tour_id']=$invoice['application_id'];
				$tour['applications']=$application;
				$tours[]=$tour;
			}
			//see($tours);
			
			foreach($tours as $tourK=>$tour)
			{
				$duration=array();
				foreach($tour['applications'] as $appK=>$app)
				{
					$dates=datesFromText($app['dates']);
					$bookingDetails=bookingByShaId($app['application_id']);
					if(!empty($bookingDetails))
					{
						$from=date('Y-m-d',strtotime($dates['to'].' + 1 day'));
						if($bookingDetails['booking_to']=='0000-00-00')
						{
							//$to=date('Y-m-d',strtotime($from.' +4 weeks -1 day'));
							$to=date('Y-m-d',strtotime($from.' +'.$totalDays.' days'));
							
						}
						else	
							{
								if(strtotime($from.' +'.$totalDays.' days') > strtotime($bookingDetails['booking_to']))
									$to=$bookingDetails['booking_to'];
								else
									$to=date('Y-m-d',strtotime($from.' +'.$totalDays.' days'));
							}
							
							$tours[$tourK]['applications'][$appK]['from']=$from;
							$tours[$tourK]['applications'][$appK]['to']=$to;
							
							$duration['from']=date('Y-m-d',strtotime($date.' + 1 day'));
							if(!isset($duration['to']) || (isset($duration['to']) && strtotime($to)>strtotime($duration['to'])))
								$duration['to']=$to;
							
							$tours[$tourK]['applications'][$appK]['items']=$ongInvItems=ongInvItems($from,$to,$app['application_id']);
							//see($ongInvItems);
					}
				}
				$tours[$tourK]['duration']=$duration;
				
			}
			//see($tours);
			$this->tour_model->resetOngoingInvoice($tours,$data['invoice_id']);
			
	}
	
	function resetOngoingInvoice($invoiceId)
	{
		$ongoingInvoiceDetailsCurrent=ongoingInvoiceDetails($invoiceId);
		//see($ongoingInvoiceDetailsCurrent);
		
		//get the last invoice before this one	
		$ongoingInvoiceDetails=$this->tour_model->lastInvoice($ongoingInvoiceDetailsCurrent['application_id'],$invoiceId);
		$initialInvoices[]=$ongoingInvoiceDetails;
		
		//see($initialInvoices);
		
			if($ongoingInvoiceDetails['initial_invoice']=='1')
			{
				$date=$ongoingInvoiceDetails['booking_to'];
				$duration['from']=date('Y-m-d',strtotime($date.' + 1 day'));
				$duration['to']=date('Y-m-d',strtotime($date.' + 4 weeks'));
			}
			else
			{
				$date=$ongoingInvoiceDetails['end_date'];
				$duration['from']=date('Y-m-d',strtotime($date.' + 1 day'));
				$duration['to']=date('Y-m-d',strtotime($date.' + 4 weeks'));
			}
			
			$tours=array();
			foreach($initialInvoices as $invoice)
			{
				$application=array();
				$prevItemAppId='';
				$prevItemDesc='';
				
				foreach($invoice['items'] as $itemK => $item)
				{
					if($item['type']=='accomodation' || $item['type']=='accomodation_ed')
					{
						if($item['type']=='accomodation_ed')
						{
							$currentItemAppId=$item['application_id'];
							$prevItemDescArray=explode('(',$prevItemDesc);
							$currentItemDescArray=explode('(',$item['desc']);
							
							if($prevItemAppId==$currentItemAppId)
							{
								$datesCurrent=explode('to',getTextBetweenBrackets($item['desc']));
								$datesPrev=explode('to',getTextBetweenBrackets($prevItemDesc));
								end($application);         // move the internal pointer to the end of the array
								$keyApp = key($application);
								$application[$keyApp]['dates']=$datesPrev[0].'to ';
								if(isset($datesCurrent[1]))
									$application[$keyApp]['dates'] .=trim($datesCurrent[1]);
								else	
									$application[$keyApp]['dates'] .=trim($datesCurrent[0]);
							}
						}
						else
						{
							$app['application_id']=$item['application_id'];
							$app['dates']=getTextBetweenBrackets($item['desc']);
							$application[]=$app;
						}
						$prevItemAppId=$item['application_id'];
						$prevItemDesc=$item['desc'];
					}
				}
				$tour['tour_id']=$invoice['application_id'];
				$tour['applications']=$application;
				$tour['initial_invoice']=$invoice['initial_invoice'];
				$tours[]=$tour;
			}
			//see($tours);
			
			foreach($tours as $tourK=>$tour)
			{
				foreach($tour['applications'] as $appK=>$app)
				{
					$dates=datesFromText($app['dates']);
					$bookingDetails=bookingByShaId($app['application_id']);
					if(!empty($bookingDetails))
					{
						$from=date('Y-m-d',strtotime($dates['to'].' + 1 day'));
						
						//If last invoice was initial invoice then we have to calculate the start date of the ongoing invoice from the booking
						if($tour['initial_invoice']=='1')
						  {	
						  	$shaInitialInvoiceWeekDays=tourInitialInvoiceWeekDays($tour['tour_id'],$bookingDetails['student']);
							$from=date('Y-m-d',strtotime($bookingDetails['booking_from'].' + '.$shaInitialInvoiceWeekDays.' days'));
						  }
						  //
						  
						if($bookingDetails['booking_to']=='0000-00-00')
							$to=date('Y-m-d',strtotime($from.' +4 weeks -1 day'));
						else	
							{
								$dayDiff=dayDiff($from,$bookingDetails['booking_to']);
								if($dayDiff>28)
									$to=date('Y-m-d',strtotime($from.' +4 weeks -1 day'));
								else	
									$to=$bookingDetails['booking_to'];
							}
							
							$tours[$tourK]['applications'][$appK]['from']=$from;
							$tours[$tourK]['applications'][$appK]['to']=$to;
							
							if(!isset($duration['end_date']) || (isset($duration['end_date']) && strtotime($to)<strtotime($duration['end_date'])))
								$duration['end_date']=$to;	
							
							$tours[$tourK]['applications'][$appK]['items']=$ongInvItems=ongInvItems($from,$to,$app['application_id']);
							//see($ongInvItems);
					}
				}
				$tours[$tourK]['duration']=$duration;
				
			}
			//see($tours);
			
			
			$this->tour_model->resetOngoingInvoice($tours,$invoiceId);
	}
	
	
	function ongoingInvoiceUpdateDuration()
	{
		$data=$_POST;
		
		/*$data['days']='3';
		$data['invoice_id']='608';
		$data['shaChangeStatus_id']='78';
		$data['study_tour']='1';
		$data['weeks']='4';*/
		
		$data['invoiceId']=$data['invoice_id'];
		$ongoingInvoiceDetailsCurrent=ongoingInvoiceDetails($data['invoiceId']);
		$sha=getShaOneAppDetails($data['shaChangeStatus_id']);
		$totalDays=($data['weeks']*7)+($data['days'])-1;
		
		$ongoingInvoiceDetails=$this->tour_model->lastInvoice($ongoingInvoiceDetailsCurrent['application_id'],$data['invoiceId']);
		
		$initialInvoices[]=$ongoingInvoiceDetails;
		
		if($ongoingInvoiceDetails['initial_invoice']=='1')
			{
				$date=$ongoingInvoiceDetails['booking_to'];
				$duration['from']=date('Y-m-d',strtotime($date.' + 1 day'));
				$duration['to']=date('Y-m-d',strtotime($duration['from'].' + '.$totalDays.' days'));
			}
			else
			{
				$date=$ongoingInvoiceDetails['end_date'];
				$duration['from']=date('Y-m-d',strtotime($date.' + 1 day'));
				$duration['to']=date('Y-m-d',strtotime($duration['from'].' + '.$totalDays.' days'));
			}
			
			$tours=array();
			foreach($initialInvoices as $invoice)
			{
				$application=array();
				$prevItemAppId='';
				$prevItemDesc='';
				
				foreach($invoice['items'] as $itemK => $item)
				{
					if($item['type']=='accomodation' || $item['type']=='accomodation_ed')
					{
						if($item['type']=='accomodation_ed')
						{
							$currentItemAppId=$item['application_id'];
							$prevItemDescArray=explode('(',$prevItemDesc);
							$currentItemDescArray=explode('(',$item['desc']);
							
							if($prevItemAppId==$currentItemAppId)
							{
								$datesCurrent=explode('to',getTextBetweenBrackets($item['desc']));
								$datesPrev=explode('to',getTextBetweenBrackets($prevItemDesc));
								end($application);         // move the internal pointer to the end of the array
								$keyApp = key($application);
								$application[$keyApp]['dates']=$datesPrev[0].'to ';
								if(isset($datesCurrent[1]))
									$application[$keyApp]['dates'] .=trim($datesCurrent[1]);
								else	
									$application[$keyApp]['dates'] .=trim($datesCurrent[0]);
							}
						}
						else
						{
							$app['application_id']=$item['application_id'];
							$app['dates']=getTextBetweenBrackets($item['desc']);
							$application[]=$app;
						}
						$prevItemAppId=$item['application_id'];
						$prevItemDesc=$item['desc'];
					}
				}
				$tour['tour_id']=$invoice['application_id'];
				$tour['applications']=$application;
				$tour['initial_invoice']=$invoice['initial_invoice'];
				$tours[]=$tour;
			}
			//see($tours);
			
			foreach($tours as $tourK=>$tour)
			{
				foreach($tour['applications'] as $appK=>$app)
				{
					$dates=datesFromText($app['dates']);
					$bookingDetails=bookingByShaId($app['application_id']);
					if(!empty($bookingDetails))
					{
						$from=date('Y-m-d',strtotime($dates['to'].' + 1 day'));
						
						//If last invoice was initial invoice then we have to calculate the start date of the ongoing invoice from the booking
						if($tour['initial_invoice']=='1')
						  {	
						  	$shaInitialInvoiceWeekDays=tourInitialInvoiceWeekDays($tour['tour_id'],$bookingDetails['student']);
							$from=date('Y-m-d',strtotime($bookingDetails['booking_from'].' + '.$shaInitialInvoiceWeekDays.' days'));
						  }
						  //
						  
						  $to=date('Y-m-d',strtotime($from.' + '.$totalDays.' days'));
						  if(strtotime($bookingDetails['booking_to'])<strtotime($to))	
							  $to=$bookingDetails['booking_to'];
							
							
						  $tours[$tourK]['applications'][$appK]['from']=$from;
						  $tours[$tourK]['applications'][$appK]['to']=$to;
						  
						  if(!isset($duration['end_date']) || (isset($duration['end_date']) && strtotime($to)<strtotime($duration['end_date'])))
							  $duration['end_date']=$to;	
						  
						  $tours[$tourK]['applications'][$appK]['items']=$ongInvItems=ongInvItems($from,$to,$app['application_id']);
						  //see($ongInvItems);
					}
				}
				$tours[$tourK]['duration']=$duration;
				
			}
			//see($tours);
			
			$this->tour_model->resetOngoingInvoice($tours,$data['invoice_id']);
			
	}
	
	
	function test()
{
	echo "tyes";

			$res=array();

			if(checkLogin())
			{
				
				$this->load->library('excel');

				$objReader = PHPExcel_IOFactory::createReader('Excel2007');
				$file = './tourTest.xlsx';
				$objPHPExcel = $objReader->load($file);

				$accomodation_types =  array(

					'1'=>'Homestay Single Room',

					'2'=>'Homestay Twin Share',

					'3'=>'Homestay Self-Catered',

					'4'=>'Homestay VIP Single Room',

					'5'=>'Homestay VIP Self-Catered'/*,

					'6'=>'Student Shared Apartment',

					'7'=>'Student Shared House'*/

				);

				$allergy_types =  array(

					'allergy_hay_fever'=>'Hay Fever',

					'allergy_asthma'=>'Asthma',

					'allergy_lactose'=>'Lactose Intolerance',

					'allergy_gluten'=>'Gluten Intolerance',

					'allergy_peanut'=>'Peanut Allergies',

					'allergy_dust'=>'Dust Allergies',

				);


				foreach ($objPHPExcel->getWorksheetIterator() as $worksheetK=>$worksheet) {

					//print_r($worksheet);
					if($worksheetK==0)
					{
					$last_row = $worksheet->getHighestRow();

					$worksheet->getStyle("F2:F".$last_row)->getNumberFormat()->setFormatCode('0000000000'); 

					$worksheet->getStyle("A2:A".$last_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2); 

					$worksheet->getStyle("B2:B".$last_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2); 

					$worksheet->getStyle("G2:G".$last_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2); 

					$worksheet->getStyle("U2:U".$last_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2); 

					$group = $worksheet->toArray();

				    //see($group);die();



				    if(!empty($group)) {

				    	$csv_header = array_shift($group);

				    	$csv_tour_list_header = $this->getTourCSVHeader();


						$notmatch=false;

						foreach($csv_tour_list_header as $key=>$record)

						{

							if(trim($csv_header[$key])!=$csv_tour_list_header[$key]['label'])

							{

								$notmatch=true;	

							}	

						}

						$inserted_csv_warnings = array();

						$i=0;

						$invalid_student_arr = array();
						$students=array();
						foreach($group as $key=>$line) {

							$insert = array();

							if(empty($line[2]))
								continue;
							
							$invalid_booking_from=false;

							$invalid_booking_to=false;

							$invalid_dob=false;

							$invalid_email=false;
							$invalid_nation=false;
							
							$line[18]=trim($line[18]);
							if (in_array($line[18],$accomodation_types)) {

								$accomodation_key = array_search($line[18], $accomodation_types);

								$line[18] = $accomodation_key;

							}

							$allergy_key='';

							$allergy_other='';

							$allergy_other_val='';

							if(strtolower(trim($line[9]))=='yes') {

								if (in_array(strtolower(trim($line[10])),$allergy_types)) {

									$allergy_key = array_search(strtolower(trim($line[10])),$allergy_types);

								}

								else {

									$allergy_other=1;

									$allergy_other_val=$line[10];

								}

							}

							$insert['booking_from'] = $line[0];	// table sha_one.booking_from

							$d = DateTime::createFromFormat('Y-m-d', $insert['booking_from']);

    						$result =  $d && $d->format('Y-m-d') === $insert['booking_from'];

    						if(!$result) {

    							$invalid_booking_from=true;

    							$insert['booking_from']='0000-00-00';

    						}

							$insert['booking_to'] = $line[1];	// table sha_one.booking_to

							$d = DateTime::createFromFormat('Y-m-d', $insert['booking_to']);

    						$result =  $d && $d->format('Y-m-d') === $insert['booking_to'];

    						if(!$result) {

    							$invalid_booking_to=true;

    							$insert['booking_to']='0000-00-00';

    						}

							$insert['fname'] = !empty($line[2])?$line[2]:'';	// table sha_one.fname

							$insert['lname'] = !empty($line[3])?$line[3]:''; 	// table sha_one.lname

							$insert['dob'] = !empty($line[6])?$line[6]:'';		// table sha_one.dob
							//$insert['dob'] =normalToMysqlDate($insert['dob']);//see($insert['dob']);
							$d = DateTime::createFromFormat('Y-m-d', $insert['dob']);

    						//$result =  $d && $d->format('Y-m-d') === $insert['dob'];
							$result =  $d;

    						if(!$result) {

    							$invalid_dob=true;

    							$insert['dob']='0000-00-00';
//echo "yes";
    						}//else{echo "no";}

							

							

						$students[]=$insert;

							$i++;

						} // foreach loop
					} 

				}	
			}
				see($students);
			}else{echo "jkjkjkjkj";}	

				
		
}

function savecollegeaddressdetail(){
	$data=$_POST;
	$this->tour_model->savecollegeaddressdetail($data);
	
}
	
	
}
?>