<?php

function static_url()
{
	return site_url().'static/';
}

function pageTitle($pageTitle)
{
	return $pageTitle." | Global Experience";
}

function hfaTitle()
{
	return "Host Family Application";
}

function shaTitle()
{
	return "Student Homestay Application";
}
function houseTitle()
{
	return "Share House Application";
}

function header_from_email()
{
	return "no-reply@globalexperience.com.au";
}
function update_sha1_md5($id)
{
	$sql_exist_query="select fname,lname,dob,gender,accomodation_type from `sha_one` where `id`='$id'";
	$query_exist=$this->db->query($sql_exist_query);
	$result=$query_exist->result_array();
	$row = $result[0];
	$unique_csv_record = md5($row['fname'].$row['lname'].$row['dob'].$row['gender'].$row['accomodation_type']);
	$update_query = "UPDATE `sha_one` SET `unique_csv_record`= '$unique_csv_record' WHERE id='$id'";
	$update_query_result=$this->db->query($update_query);
	return $update_query_result;
}
function header_from()
{
	return "Global Experience";
}

function normalToMysqlDate($date)
	{
		if($date=='')
			return '0000-00-00';
		
		$date_array=explode('/',$date);
		$mysqlDate=$date_array[2].'-'.$date_array[1].'-'.$date_array[0];
		return $mysqlDate;
	}
	
function mysqlToNormalDate($date)
	{
		$date_array=explode('-',$date);
		$mysqlDate=$date_array[2].'/'.$date_array[1].'/'.$date_array[0];
		return $mysqlDate;
	}

function normalToMysqlTime($time_input)
	{
		$date = DateTime::createFromFormat( 'H:i A', $time_input);
		return $formatted = $date->format( 'H:i:s');

		/*
		OR
		$date = date_create_from_format('j-M-Y', '15-Feb-2009');
		echo date_format($date, 'Y-m-d');
		*/
	}

function nameTitleList()
{
				return array(
				"1"=>"Mr.",
                "2"=>"Mrs.",
                "3"=>"Ms.",
                "4"=>"Master",
                "5"=>"Dr."
				);
}

function stateList()
{
				return array(
				"act"=>"ACT",
                "nsw"=>"NSW",
                "vic"=>"VIC",
                "qld"=>"QLD",
                "sa"=>"SA",
				"wa"=>"WA",
				"tas"=>"TAS",
				"nt"=>"NT",
				);
}

function dwellingTypeList()
{
	return array(
				"1"=>"House",
                "2"=>"Townhouse",
                "3"=>"Duplex/Semi",
                "4"=>"Apartment",
                "5"=>"Self Contained (e.g. Granny Flat)"
				);
}
function floorTypeList()
{
				return array(
				"1"=>"Carpet",
                "2"=>"Timber/Wood",
                "3"=>"Vinyl",
                "4"=>"Tiles",
                "5"=>"Others"
				);
}
function floorsList()
{
				return array(
				"1"=>"1 floor",
                "2"=>"2 floors",
                "3"=>"3 floors",
                "4"=>"4 floors",
                "5"=>"5 floors"
				);
}

function roomLocation()
{
				return array(
				"1"=>"Floor 1",
                "2"=>"Floor 2",
                "3"=>"Floor 3",
                "4"=>"Floor 4",
                "5"=>"Floor 5"
				);
}

function roomTypeList()
{
				return array(
				"1"=>"Single",
                "2"=>"Twin",
                "3"=>"Double",
                "4"=>"Single/Twin"
				);
}

function genderList()
{
				return array(
				"1"=>"Male",
                "2"=>"Female"
				);
}

function heShe($gender)
{
				if($gender=='1')
					$heShe='he';
				elseif($gender=='2')	
					$heShe='he';
					
				return $heShe;
}

function nationList()
{
	return array(
				"1"=>"Afghan",
				"2"=>"Albanian",
				"3"=>"Algerian",
				"107"=>"Amsterdammer",
				"4"=>"Angolan",
				"108"=>"Arab",
				"5"=>"Argentine",
				"6"=>"Austrian",
				"7"=>"Australian",
				"109"=>"Azerbaijanis",
				"8"=>"Bangladeshi",
				"9"=>"Belarusian",
				"10"=>"Belgian",
				"11"=>"Bolivian",
				"12"=>"Bosnian/Herzegovinian",
				"13"=>"Brazilian",
				"14"=>"British",
				"15"=>"Bulgarian",
				"110"=>"Burmese",
				"111"=>"Caledonian",
				"16"=>"Cambodian",
				"17"=>"Cameroonian",
				"18"=>"Canadian",
				"19"=>"Central African",
				"20"=>"Chadian",
				"112"=>"Chilean",
				"21"=>"Chinese",
				"139"=>"Chinese (Hong Kong)",
				"22"=>"Colombian",
				"23"=>"Costa Rican",
				"24"=>"Croatian",
				"138"=>"Cyprian",
				"25"=>"Czech",
				"26"=>"Congolese",
				"113"=>"Cubans",
				"27"=>"Danish",
				"40"=>"Dutch",
				"28"=>"Ecuadorian",
				"29"=>"Egyptian",
				"30"=>"Salvadoran",
				"31"=>"English",
				"32"=>"Estonian",
				"33"=>"Ethiopian",
				"140"=>"Filipino",
				"34"=>"Finnish",
				"35"=>"French",
				"36"=>"German",
				"37"=>"Ghanaian",
				"38"=>"Greek",
				"39"=>"Guatemalan",
				"41"=>"Honduran",
				"42"=>"Hungarian",
				"43"=>"Icelandic",
				"44"=>"Indian",
				"45"=>"Indonesian",
				"46"=>"Iranian",
				"47"=>"Iraqi",
				"48"=>"Irish",
				"49"=>"Israeli",
				"50"=>"Italian",
				"51"=>"Ivorian",
				"52"=>"Jamaican",
				"53"=>"Japanese",
				"54"=>"Jordanian",
				"55"=>"Kazakh",
				"56"=>"Kenyan",
				"114"=>"Korean",
				"115"=>"Kuwaiti",
				"57"=>"Lao",
				"58"=>"Latvian",
				"116"=>"Lebanese",
				"59"=>"Libyan",
				"60"=>"Lithuanian",
				"117"=>"Liechtensteiner",
				"118"=>"Macanese",
				"119"=>"Macedonian",
				"61"=>"Malagasy",
				"62"=>"Malaysian",
				"63"=>"Malian",
				"141"=>"Malawi",
				"120"=>"Mauritian",
				"121"=>"Mongolian",
				"64"=>"Mauritanian",
				"65"=>"Mexican",
				"66"=>"Moroccan",
				"122"=>"Mozambican",
				"123"=>"Myanmarese",
				"67"=>"Namibian",
				"124"=>"Nepalese",
				"125"=>"New zealander",
				"68"=>"Nicaraguan",
				"69"=>"Nigerien",
				"70"=>"Nigerian",
				"126"=>"Ni-Vanuatu",
				"71"=>"Norwegian",
				"72"=>"Omani",
				"127"=>"Ozumba",
				"73"=>"Pakistani",
				"74"=>"Panamanian",
				"75"=>"Paraguayan",
				"128"=>"Persian",
				"76"=>"Peruvian",
				"77"=>"Philippine",
				"78"=>"Polish",
				"79"=>"Portuguese",
				"129"=>"Qatari",
				"130"=>"Quatari",
				"80"=>"Congolese",
				"131"=>"Reunion Islander",
				"81"=>"Romanian",
				"82"=>"Russian",
				"83"=>"Saudi, Saudi Arabian",
				"84"=>"Scottish",
				"85"=>"Senegalese",
				"86"=>"Serbian",
				"87"=>"Singaporean",
				"88"=>"Slovak",
				"89"=>"Somalian",
				"90"=>"South African",
				"91"=>"Spanish",
				"132"=>"Srilankan",
				"92"=>"Sudanese",
				"133"=>"Swedish",
				"93"=>"Swiss",
				"94"=>"Syrian",
				"134"=>"Taiwanese",
				"135"=>"Tanzanian",
				"95"=>"Thai",
				"96"=>"Tunisian",
				"97"=>"Turkish",
				"98"=>"Turkmen",
				"99"=>"Ukranian",
				"136"=>"Uzbek",
				"100"=>"Emirati",
				"101"=>"American",
				"102"=>"Uruguayan",
				"137"=>"Venezuelan",
				"103"=>"Vietnamese",
				"104"=>"Welsh",
				"105"=>"Zambian",
				"106"=>"Zimbabwean"
				);
}

function see($array)
{
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}

function getHfaOneAppDetails($id)
{
	$obj=& get_instance();
	$obj->load->model('form_model');
	$res=$obj->form_model->getHfaOneAppDetails($id);
	return $res;
}

function getHfaTwoAppDetails($id)
{
	$obj=& get_instance();
	$obj->load->model('form_model');
	$obj->load->model('hfa_model');
	$res=$obj->form_model->hfaAppCheckStepTwo($id);
	if(!empty($res))
	{
		$res['facilities']=$obj->hfa_model->getHfaTwoAppDetailsFacilities($id);
		$res['bedroomDetails']=$obj->hfa_model->getHfaTwoAppDetailsBedrooms($id);
		$res['bathroomDetails']=$obj->hfa_model->getHfaTwoAppDetailsBathrooms($id);
		$res['hostbedroomDetails']=$obj->hfa_model->getHfaTwoAppDetailsHostBedroom($id);
	}
	return $res;
}

function getHfaThreeAppDetails($id)
{
	$obj=& get_instance();
	$obj->load->model('form_model');
	$obj->load->model('hfa_model');
	$res=$obj->form_model->hfaAppCheckStepThree($id);
	if(!empty($res))
	{
		$res['memberDetails']=$obj->hfa_model->getHfaTwoAppDetailsMemberDetails($id);
		$res['bankDetails']=$obj->hfa_model->getHfaTwoAppDetailsBank($id);
	}
	return $res;
}

function getHfaTwoAppDetailsBank($id)
{
	$obj=& get_instance();
	$obj->load->model('hfa_model');
	$res=$obj->hfa_model->getHfaTwoAppDetailsBank($id);
	return $res;
}

function getHfaFourAppDetails($id)
{
	$obj=& get_instance();
	$obj->load->model('form_model');
	$res=$obj->form_model->hfaAppCheckStepFour($id);
	if(!empty($res))
	{
		/*$res['memberDetails']=$obj->hfa_model->getHfaTwoAppDetailsMemberDetails($id);
		$res['bankDetails']=$obj->hfa_model->getHfaTwoAppDetailsBank($id);*/
	}
	return $res;
}

function hfaAppCheckStep($id)
{
	$obj=& get_instance();
	$obj->load->model('form_model');
	return $step=$obj->form_model->hfaAppCheckStep($id);
}

function hfaRedirectToCorrectStep($id,$page)
{
	$step=hfaAppCheckStep($id);

	$linkCode=codeEncode($id);
	$link=site_url().'Form/host_family_application';
	if($step==2 && $page!=2)
		header('location:'.$link.'_two/'.$linkCode);
	if($step==3 && $page!=3)
		header('location:'.$link.'_three/'.$linkCode);
	if($step==4 && $page!=4)
		header('location:'.$link.'_four/'.$linkCode);
	if($step==5)
		header('location:'.$link.'_completed');
}

function geRefList()
{
	return array(
					  '1'=>'Previous Global Experience student',
					  '2'=>'Previous Global Experience homestay family',
					  '3'=>'Facebook',
					  '4'=>'Google',
					  '5'=>'Global Experience website',
					  '6'=>'Agent',
					  '7'=>'Other'
					  );
}

function family_role()
{
	return array(
		'1'=>"Host Mother",
		'2'=>"Host Father",
		'3'=>"Daughter",
		'4'=>"Son",
		'5'=>"Grandmother",
		'6'=>"Grandfather",
		'7'=>"Relatives",
		'8'=>"Friends/Housemate",
		'9'=>"Casual visitor",
		'17'=>'Regular visitor',
		'10'=>"Partner",
		'11'=>'Brother',
		'12'=>'Sister',
		'13'=>'Daughter-in-law',
		'14'=>'Son-in-law',
		'15'=>'Granddaughter',
		'16'=>'Grandson',
		'17'=>'Other'
	);
	
}

function smokingHabbits()
{
	           return array(
			    '0'=>'No',
            	'1'=>'Yes (Outdoors)',
	            '2'=>'Yes (Indoors &amp; Outdoors)'
			   );
}

function smokingHabbitsFilters()
{
	           return array(
			    '0'=>'Non-smoker',
            	'1'=>'Smoker (Outside)',
	            '2'=>'Smoker (In & out)'
			   );
}

function languageList()
{
	
				return array(
				'1'=>'Albanian',
                '2'=>'Arabic',
				'41'=>'Bahasa',
                '3'=>'Balinese',
                '4'=>'Bengali',
                '5'=>'Burmese',
                '6'=>'Chinese (Cantonese)',
                '7'=>'Chinese (Mandarin)',
				'46'=>'Czech',
                '8'=>'Dari',
                '9'=>'Dutch',
                '10'=>'English',
				'43'=>'Farsi',
				'42'=>'Filipino',
                '11'=>'French',
                '12'=>'German',
                '13'=>'Greek',
                '14'=>'Hazaragi',
				'15'=>'Hindi',
				'39'=>'Hungarian',
                '16'=>'Indonesian',
                '17'=>'Italian',
                '18'=>'Japanese',
				'44'=>'Khmer',
                '19'=>'Korean',
                '20'=>'Kurdish (Kurmanji)',
                '21'=>'Kurdish (Sorani)',
                '22'=>'Macedonian',
                '47'=>'Malawi',
                '23'=>'Malay',
				'40'=>'Nepali ',
                '24'=>'None',
                '25'=>'Other',
                '26'=>'Pashto',
                '27'=>'Persian',
                '28'=>'Polish',
                '29'=>'portuguese',
                '30'=>'Russian',
                '31'=>'Sinhalese',
				'45'=>'Slovak',
                '32'=>'Spanish',
                '33'=>'Tagalog',
                '34'=>'Tamil',
                '35'=>'Thai',
                '36'=>'Turkish',
                '37'=>'Urdu',
                '38'=>'Vietnamese'
				);
}

function languagePrificiencyList()
{
	return array(
	                '1'=>'Beginner',
                	'2'=>'Intermediate',
                	'3'=>'Advance',
                	'4'=>'Native'
				);
}

function religionList()
{
	return array(
				'1'=>'Atheist',
                '2'=>'Buddhism',
                '3'=>'Christianity',
                '4'=>'Hinduism',
	            '5'=>'Islam',
                '6'=>'Jewish'
				);
}

function hfaAppCheckByEmail($email)
{
	$obj=& get_instance();
	$obj->load->model('form_model');
	return $obj->form_model->hfaAppCheckByEmail($email);
}

function wwccTypeList()
{
	return array(
	'1'=>'Paid',
	'0'=>'Voluntary'
	);
}

function houseTypeList()
{
	return array(
				'1'=>'Single (shared bathroom)',
                '2'=>'Double (shared bathroom)'
				);
}
function accomodationTypeList()
{
	return array(
				'1'=>'Homestay Single Room',
                '2'=>'Homestay Twin Share',
                '3'=>'Homestay Self-Catered',
                '4'=>'Homestay VIP Single Room',
                '5'=>'Homestay VIP Self-Catered',
                '6'=>'Transfer Service',
                '7'=>'Caregiving Only'
				);
}

function allergyTypeList()
{
	return array(
		'allergy_hay_fever'=>'Hay Fever',
		'allergy_asthma'=>'Asthma',
		'allergy_lactose'=>'Lactose Intolerance',
		'allergy_gluten'=>'Gluten Intolerance',
		'allergy_peanut'=>'Peanut Allergies',
		'allergy_dust'=>'Dust Allergies',
	);
}


function codeEncode($id)
{
	return urlencode(base64_encode(json_encode($id)));
}

function codeDecode($link)
{
	return json_decode(base64_decode(urldecode($link)));
}

function shaAppCheckByEmail($email)
{
	$obj=& get_instance();
	$obj->load->model('form_model');
	return $obj->form_model->shaAppCheckByEmail($email);
}

function getshaOneAppDetails($id)
{
	$obj=& get_instance();
	$obj->load->model('form_model');
	$res=$obj->form_model->getShaOneAppDetails($id);
	return $res;
}
function getshareHouseDetail($id)
{
	$obj=& get_instance();
	$obj->load->model('share_house_model');
	$res=$obj->share_house_model->getshareHouseDetail($id);
	return $res;
}

function shaAppCheckStep($id)
{
	$obj=& get_instance();
	$obj->load->model('form_model');
	return $step=$obj->form_model->shaAppCheckStep($id);
}

function shaRedirectToCorrectStep($id,$page)
{
	$step=shaAppCheckStep($id);

	$linkCode=codeEncode($id);
	$link=site_url().'Form/student_homestay_application';
	if($step==2 && $page!=2)
		header('location:'.$link.'_two/'.$linkCode);
	if($step==3 && $page!=3)
		header('location:'.$link.'_three/'.$linkCode);
	if($step==4)
		header('location:'.$link.'_completed');
}

function guardianshipTypeList()
{
	return array(
		'1'=>'Global Experience',
		'2'=>'Other'
	);
}

function homestayChooseReasonList()
{
	return array(
		'1'=>'Study',
		'2'=>'Internship',
		'3'=>'Other, please specify'
	);
}

function age_from_dob($dob)
	{
		if($dob!='0000-00-00')
		    return floor((time() - strtotime($dob)) / 31556926);
		return 0;
	}

function exact_age_from_dob($dob)
	{
		if($dob!='0000-00-00'){
		    $today = date("Y-m-d");
			$diff = date_diff(date_create($dob), date_create($today));
			$age_calculate = $diff->format('%y');
			return $age_calculate;
		}
		return 0;
	}	
	
function check_wwcc_expiry($expirydate)
	{
		if($expirydate!='0000-00-00'){
		    $today = date("Y-m-d");
			if($today > $expirydate)
				return "expired";
			else
				return "notexpired";
		}
		return "empty";
	}


function getShaTwoAppDetails($id)
	{
		$obj=& get_instance();
		$obj->load->model('form_model');
		$obj->load->model('sha_model');
		$res=$obj->form_model->shaAppCheckStepTwo($id);
		if(!empty($res))
			$res['language']=$obj->sha_model->getShaTwoAppDetailsLanguage($id);
		return $res;
	}

function getShaThreeAppDetails($id)
	{
		$obj=& get_instance();
		$obj->load->model('form_model');
		$res=$obj->form_model->shaAppCheckStepThree($id);
		return $res;
	}

function trimArrayValues($array)
	{
		$trimmed_array=array_map('trim',$array);
		return $trimmed_array;
	}

function readCsv($file)
{
	$obj=& get_instance();
	$obj->load->library('excel');

	//read file from path
	$objPHPExcel = PHPExcel_IOFactory::load($file);
	//get only the Cell Collection
	$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
	//extract to a PHP readable array format
	foreach ($cell_collection as $cell)
	{
		$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
		$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
		$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
		//header will/should be in row 1 only. of course this can be modified to suit your need.
		$header='';
		if ($row == 1) {
			$header[$row][$column] = $data_value;
		} else {
			$arr_data[$row][$column] = $data_value;
		}
	}
	//send the data in an array format
	$data['header'] = $header;
	$data['values'] = $arr_data;
	return $data;
}

function dayDiff($from,$to)
{
	date_default_timezone_set('Asia/Kolkata');
	$days=(floor((strtotime($to)-strtotime($from))/86400))+1;
	date_default_timezone_set('Australia/Sydney');
	return $days;
}

function dayCount($from,$to)
{
	$dayDiff=dayDiff($from,$to);
	$dayDiff++;
	return $dayDiff;
}

function add_decimal($num)
{
	return number_format((float)$num, 2, '.', '');
}

function s($n)
{
	if($n!=1)
	return 's';
}

function dateFormat($date)
{
	return date('d M Y',strtotime($date));
}

function getWeekNDays($totalDays)
{
	$weeks=(int)($totalDays/7);
	$days=(int)($totalDays%7);
	$return=array();
	if($weeks!=0)
		$return['week']=$weeks;
	if($days!=0)	
		$return['day']=$days;
	return $return;
}

function studyTourList()
{
	$obj=& get_instance();
	$obj->load->model('tour_model');
	return $obj->tour_model->tourListHelper();
}

function datePickerDobSettings()
{
	return array(
		'year_from'=>1910,
		'year_to'=>date('Y'),
		'default_date'=>'01/01/1970'
	);
}

function datePickerExpirySettings()
{
	$pastY="-5";
	$futureY="+20";
	return array(
		'year_from'=>date('Y',strtotime($pastY.' years')),
		'year_to'=>date('Y',strtotime($futureY.' years')),
		'default_date'=>date('d/m/y'),
		'system'=>array(
			'year_from'=>$pastY.'y',
			'year_to'=>$futureY.'y',
			)
	);
}

function getTextBetweenBrackets($text)
	{
		preg_match('#\((.*?)\)#', $text, $match);
		if(!empty($match))
			return $match[1];
		else	
			return $text;
	}

function datesFromText($dates)
	  {
		  $datesArray=explode('to',$dates);
		  if(isset($datesArray[0]))
			  $datesReturn['from']=date('Y-m-d',strtotime(trim($datesArray[0])));
		  if(isset($datesArray[1]))
			  $datesReturn['to']=date('Y-m-d',strtotime(trim($datesArray[1])));
		  return $datesReturn;
	  }	
	  
function getSuburbNameFromId($id)
	{
		$obj=& get_instance();
		$obj->load->model('hfa_model');
		$res=$obj->hfa_model->getSuburbNameFromId($id);
		$result='';
		if(!empty($res))
			$result=$res['locality'];
		return $result;	
	}
	
function getStateNameFromSuburbId($id)
	{
		$obj=& get_instance();
		$obj->load->model('hfa_model');
		$res=$obj->hfa_model->getSuburbNameFromId($id);
		$result='';
		if(!empty($res))
			$result=$res['region1'];
		return $result;	
	}	

function mobileFormat($num='')
	{
		$num= str_replace(' ','',$num);
		if(trim($num)=='')
			return '';
		$num= str_replace(' ','',$num);
		$numArray=pFormat($num);
		
		if(count($numArray)!=10)
			return $num;
		
		$result=$numArray[0].$numArray[1].$numArray[2].$numArray[3].' '.$numArray[4].$numArray[5].$numArray[6].' '.$numArray[7].$numArray[8].$numArray[9];
		
		return $result;
	}
	
	function phoneFormat($num='')
	{
		$num= str_replace(' ','',$num);
		if(trim($num)=='')
			return '';
		
		$numArray=pFormat($num);
		
		if(count($numArray)!=10)
			return $num;
		
		$result=$numArray[0].$numArray[1].' '.$numArray[2].$numArray[3].$numArray[4].$numArray[5].' '.$numArray[6].$numArray[7].$numArray[8].$numArray[9];
		
		return $result;
	}
	
	function pFormat($num)
	{
		$num=str_replace(' ','',$num);
		$num=str_replace('+61','0',$num);
		
		$strlen=strlen($num);
		if($strlen<10)
			$num='0'.$num;
		
		return $numArray=str_split($num);
	}
	
	function ssl_support() 
	{
		return true;
    	$CI = & get_instance();
    	return $CI->config->item('ssl_support');
	}

	if (!function_exists('force_ssl')) 
	{
		function force_ssl()
		{
			if (ssl_support() && (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off')) 
			{
				$CI = & get_instance();
				$CI->config->config['base_url'] = str_replace('http://', 'https://', $CI->config->config['base_url']);
				redirect($CI->uri->uri_string());
			}
		}
	}

	if (!function_exists('remove_ssl')) 
	{
		function remove_ssl() 
			{
				if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') 
				{
					$CI = & get_instance();
					$CI->config->config['base_url'] = str_replace('https://', 'http://', $CI->config->config['base_url']);
					redirect($CI->uri->uri_string());
				}
    		}
	}

?>
