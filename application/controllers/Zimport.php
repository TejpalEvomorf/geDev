<?php
class Zimport extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('zimport_model');
	}
	
	
	
		  function readCsv($file)
		  {
			  //load the excel library
					  $this->load->library('excel');
					  
					  //read file from path
		  $objPHPExcel = PHPExcel_IOFactory::load($file);
		  //get only the Cell Collection
		  $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
		  //extract to a PHP readable array format
		  foreach ($cell_collection as $cell) {
			  $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			  $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
			  $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
			  //header will/should be in row 1 only. of course this can be modified to suit your need.
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
		  
		  
		  		
		function csvClients()
		{
				$file = './csvfile/Clients-Final.xlsx';
				$file = './csvfile/Clients.xlsx';
				$formOne=$this->readCsv($file);	
				//see($formOne);//exit;
				
				$clients=array();
				$count=1;
				foreach($formOne['values'] as $val)
				{
					$client=array();
					//echo $count;
					//echo '<div style="margin:5px 0 0 40px;"> ';
					//echo 'Bname: '.trim(str_replace('*','',$val['B']));
					$client['salesForce_id']=$val['A'];
					$client['bname']=trim(str_replace('*','',$val['B']));
					
					//echo '<br>Type: '.$val['C'];
					if($val['C']=='Agent')
						$client['type']='2';
					elseif($val['C']=='College')
						$client['type']='3';
					
					
					//echo '<br>Street: ';
						if(isset($val['D']) && trim($val['D'])!='')
							{
								//echo $val['D'];
								$client['street']=$val['D'];
							}
						elseif($val['P']!='' && $val['P']!='0')
						{
							//echo $val['P'];
							$client['street']=$val['P'];
						}
						else
							$client['street']='';
					//echo '<br>City: ';
						if(isset($val['E']) && trim($val['E'])!='')
						{
							//echo $val['E'];
							$client['city']=$val['E'];
						}
						elseif($val['Q']!='' && $val['Q']!='0')
						{
							//echo $val['Q'];
							$client['city']=$val['Q'];
						}
						else
						$client['city']='';
						//echo '<br>State: ';
						if(isset($val['F']) && trim($val['F'])!='')
						{
							//echo $val['F'];
							$client['state']=$val['F'];
						}
						elseif($val['R']!='' && $val['R']!='0')
						{
							//echo $val['R'];		
							$client['state']=$val['R'];
						}
						else
							$client['state']='';
						//echo '<br>Post code: ';
						if(isset($val['G']) && trim($val['G'])!='')
						{
							//echo $val['G'];
							$client['post_code']=$val['G'];
						}
						elseif($val['S']!='' && $val['S']!='0')
						{
							//echo $val['S'];
							$client['post_code']=$val['S'];
						}
						else
							$client['post_code']='';
						///echo '<br>Country: ';
						if(isset($val['H']) && trim($val['H'])!='')
						{
							//echo $val['H'];
							$client['country']=$val['H'];
						}
						elseif($val['T']!='' && $val['T']!='0')
						{
							//echo $val['T'];
							$client['country']=$val['T'];
						}
						else
							$client['country']='';
														
						//echo '<br>Fname: ';
						if(trim($val['N'])!='' && $val['N']!='0' && $val['N']!='-')
						{
							///echo $val['N'];
							$client['fname']=$val['N'];
						}
						else
						{
							//echo 'Unavailable';
							$client['fname']='Unavailable';
						}
						//echo '<br>Lname: ';
						if(trim($val['O'])!='' && $val['O']!='0' && $val['O']!='-')
						{
							//echo $val['O'];
							$client['lname']=$val['O'];
						}
						else
						{
							//echo 'Unavailable';
							$client['lname']='Unavailable';
						}
							
						//echo '<br>Phone: ';
						$client['phone_sec']='';
						if(isset($val['I']) && trim($val['I'])!='' && trim($val['I'])!='0')
						{
							//echo $val['I'];
							$client['phone']=$val['I'];
							if(isset($val['W']) && trim($val['W'])!='' && trim($val['W'])!='0')
								$client['phone_sec']=$val['W'];
						}
						elseif(isset($val['J']) && trim($val['J'])!='' && trim($val['J'])!='0')
						{
							//echo $val['J'];
							$client['phone']=$val['J'];
							if(isset($val['W']) && trim($val['W'])!='' && trim($val['W'])!='0')
								$client['phone_sec']=$val['W'];
						}
						elseif(isset($val['W']) && trim($val['W'])!='' && trim($val['W'])!='0')
						{
							//echo $val['W'];	
							$client['phone']=$val['W'];
						}
						else	
						{
							//echo '9999999999';
							$client['phone']='9999999999';
						}
					
						//echo '<br>Email: ';
						if(isset($val['X']) && trim($val['X'])!='' && trim($val['X'])!='0')
						{
							//echo $val['X'];
							$client['email']=$val['X'];
						}
						else	
						{
							//echo 'no-reply@globalexperience.com.au';
							$client['email']='no-reply@globalexperience.com.au';
						}
					
						//echo '<br>Description: ';
						$client['desc']='';
						if(isset($val['L']) && trim($val['L'])!='' && trim($val['L'])!='0')
						{
							//echo $val['L'];
							$client['desc'] .=$val['L'];
						}
							
						if(isset($val['K']) && trim($val['K'])!='' && trim($val['K'])!='0')
							{
								if(isset($val['L']) && trim($val['L'])!='' && trim($val['L'])!='0')
								{
									//echo " | ";
									$client['desc'] .=" | ";
								}
								//echo $val['K'];
								$client['desc'] .=$val['K'];
							}	
						
					//echo "</div>";
					//echo "<br>";
					
					$clients[]=$client;
					$count++;
				}
				
				//see($clients);
				//$this->zimport_model->importClients($clients);
				echo "Done";
				
		}
		
		
		function csvHosts()
		{
				$file = './csvfile/hosts1.xlsx';
				$file = './csvfile/hosts1-updated.xlsx';
				$formOne=$this->readCsv($file);	
				//see($formOne);//exit;
				
				$hosts=array();
				foreach($formOne['values'] as $valk=>$val)
				{
					if(!isset($val['S']))
						$val['S']='';
					if(!isset($val['Q']))
						$val['Q']='';	
					if(!isset($val['H']))
						$val['H']='';	
					if(!isset($val['I']))
						$val['I']='';	
					if(!isset($val['K']))
						$val['K']='';
					if(!isset($val['J']))
						$val['J']='';	
					if(!isset($val['M']))
						$val['M']='';
					if(!isset($val['E']))
						$val['E']='';
					if(!isset($val['P']))
						$val['P']='';
					if(!isset($val['C']))
						$val['C']='';
					if(!isset($val['D']))
						$val['D']='';	
					if(!isset($val['F']))
						$val['F']='';	
					if(!isset($val['X']))
						$val['X']='';
					if(!isset($val['R']))
						$val['R']='';
																	
						
					$host=array();
					
					$host['salesForceId_host']=$val['A'];
					$host['salesForceId_contact']=$val['R'];
					$host['salesForceId_member']=$val['T'];
					
					if($val['U']=='Mr.')
						$host['title']='1';
					elseif($val['U']=='Mrs.')
						$host['title']='2';
					elseif($val['U']=='Ms.')
						$host['title']='3';
					elseif($val['U']=='Master')
						$host['title']='4';
					elseif($val['U']=='Dr.')
						$host['title']='5';
					else
						$host['title']='';
					
					$name=explode(' ',$val['B']);
					$nameCount=count($name);
					$lname=$name[$nameCount-1];
					$host['fname']=str_replace($lname,'',$val['B']);
					$host['lname']=$lname;
					if($host['fname']=='')
					{
						$host['lname']=str_replace('Family','',$host['lname']);
						$host['fname']=$val['AF'];
						if($host['fname']=='')
							$host['fname']='unavailable';
					}
					
					if(trim($val['AE'])!='0' && trim($val['AE'])!='')
						$host['email']=$val['AE'];
					else
						$host['email']='no-reply@globalexperience.com.au';
					
					$mobile=$this->validateMobilePhone($val['AB']);
					if($mobile=='')
						$mobile=$this->validateMobilePhone($val['AA']);
					if($mobile=='')
						$mobile=$this->validateMobilePhone($val['M']);
					if($mobile=='')
						$mobile=$this->validateMobilePhone($val['AC']);
					if($mobile=='')
						$mobile=$this->validateMobilePhone($val['AD']);
					if($mobile=='')	
						$mobile='0000000000';
					$host['mobile']=$mobile;
					
					$homePhone=$this->validateHomePhone($val['AA']);
					if($homePhone=='')
						$homePhone=$this->validateHomePhone($val['AC']);
					if($homePhone=='')
						$homePhone=$this->validateHomePhone($val['M']);
					if($homePhone=='')
						$homePhone=$this->validateHomePhone($val['AD']);
					if($homePhone=='')
						$homePhone='0000000000';
					$host['homePhone']=$homePhone;
					
					$workPhone=$this->validateWorkPhone($val['AD']);
					if($workPhone=='')
						$workPhone=$this->validateWorkPhone($val['S']);
					if($workPhone=='')
						$workPhone='0000000000';
					$host['workPhone']=$workPhone;
					
					$host['members']=$val['P'];
					if($host['members']=='')
						$host['members']='1';
					
					if($val['C']!='')
						$host['street']=$val['C'];
					elseif($val['V']!='')
						$host['street']=$val['V'];
					else	
						$host['street']='Unavailable';
					
					if($val['D']!='')
						$host['suburb']=$val['D'];
					elseif($val['W']!='')
						$host['suburb']=$val['W'];
					else	
						$host['suburb']='n/a';	
					
					if($val['E']!='')
						$host['state']=$val['E'];
					elseif($val['X']!='')
						$host['state']=$val['X'];
					else	
						$host['state']='NSW';
					$host['state']=strtolower($host['state']);
											
					if($val['F']!='')
						$host['post_code']=$val['F'];
					elseif($val['Y']!='')
						$host['post_code']=$val['Y'];
					else	
						$host['post_code']='0000';	
					
					if($val['Q']=='' || $val['Q']=='Different from home address')
						$host['postal_address_same']='0';
					else
						{
							$host['postal_address_same']='1';
							
							if($val['H']!='')
								$host['street_postal']=$val['H'];
							else	
								$host['street_postal']='Unavailable';
							
							if($val['I']!='')
								$host['suburb_postal']=$val['I'];
							else	
								$host['suburb_postal']='n/a';	
							
							if($val['J']!='')
								$host['state_postal']=$val['J'];
							else	
								$host['state_postal']='NSW';
							$host['state_postal']=strtolower($host['state_postal']);		
													
							if($val['K']!='')
								$host['post_code_postal']=$val['K'];
							else	
								$host['post_code_postal']='0000';
						}

					
					$hosts[]=$host;
				}
				
				//see($hosts);
				//$this->zimport_model->importHosts($hosts);
				echo "done";
		}
	
	
	function validateMobilePhone($num)
	{
		$res=$this->removeExtraFromPhoneNo($num);
		
		$number='';
		$length=strlen($res);
		if($length==9)
			$number=$res;
		if($length>9)//if we have two numbers in one cell
			$number=substr($res, 0, 9);
		
		if($number!='' && $number[0]!='4')//if not starting with 4, then its not a mobile number
			$number='';
		return $number;	
	}
	
	
	function validateHomePhone($num)
	{
		$res=$this->removeExtraFromPhoneNo($num);
		
		$number='';
		if($res!='' && $res[0]!='4')//if starting with 4, then its a mobile number
		{
			$length=strlen($res);
			if($length==8)
				$number=$res;
			if($length==9)
				$number=$res;
		}	
		
		return $number;
	}
	
	function validateWorkPhone($num)
	{
		$res=$this->removeExtraFromPhoneNo($num);
		$number=$res;
		return $number;
	}
	
	function removeExtraFromPhoneNo($num)
	{	
		$phone =preg_replace('/[^\dxX]/', '', $num);//removing alphabets, special characters, spaces
		$phone = ltrim($phone,'0');//removing 0 from starting
		$phone = ltrim($phone,'61');//removing 61 from starting
		return $phone;
	}
	
	
	
	function csvHosts2()
		{
				$file = './csvfile/hosts2.xlsx';
				$formOne=$this->readCsv($file);	
				//see($formOne);
				
				$hosts=array();
				foreach($formOne['values'] as $valk=>$val)
				{
					if(!isset($val['Q']))
						$val['Q']='';
					if(!isset($val['B']))
						$val['B']='';	
					if(!isset($val['C']))
						$val['C']='';		
					if(!isset($val['D']))
						$val['D']='';		
					if(!isset($val['L']))
						$val['L']='';
					if(!isset($val['E']))
						$val['E']='';	
					if(!isset($val['M']))
						$val['M']='';					
					if(!isset($val['N']))
						$val['N']='';	
					if(!isset($val['P']))
						$val['P']='';					
					if(!isset($val['O']))
						$val['O']='';	
					if(!isset($val['F']))
						$val['F']='';
					if(!isset($val['R']))
						$val['R']='';
					if(!isset($val['G']))
						$val['G']='';			
						
						
							
					$host=array();
					$host['salesForceId_host']=$val['A'];
					$host['dwelling_type']=$this->getDwellingType(trim($val['B']));
					
					$host['main_flooring']='';
					$host['main_flooringOthers']='';	
					if(trim($val['C'])=='Carpet')
						$host['main_flooring']=1;
					elseif(trim($val['C'])=='Timber/Wood')
						$host['main_flooring']=2;
					elseif(trim($val['C'])=='Vinyl')
						$host['main_flooring']=3;
					elseif(trim($val['C'])=='Tiles')
						$host['main_flooring']=4;
					elseif(trim($val['C'])=='Other')
					{
						$host['main_flooring']=5;
						$host['main_flooringOthers']=str_replace(';',',',$val['R']);	
					}
						
					$host['internet_students']='';
					if(strtolower(trim($val['D']))=='yes')
						$host['internet_students']='1';	
					elseif(strtolower(trim($val['D']))=='no')
						$host['internet_students']='0';
						
					$host['internet_type']='';	
					
					$host['smoke_detector']='';
					if(strtolower(trim($val['E']))=='yes')
						$host['smoke_detector']='1';	
					elseif(strtolower(trim($val['E']))=='no')
						$host['smoke_detector']='0';

					$host['facility_pool']='';
					$host['facility_tennis']='';
					$host['facility_piano']='';
					$host['facility_gym']='';
					$host['facility_disable_access']='';
					$host['facility_other']='';
					$host['facility_other_val']='';
					if(trim($val['F'])!='')
					{
						$facilityTemp=strtolower(trim($val['F']));
						
						if(strchr(strtolower($facilityTemp),"swimming pool"))
							$host['facility_pool']='1';
						elseif($val['I']=='1')
							$host['facility_pool']='1';
						
						if(strchr($facilityTemp,"tennis court"))
							$host['facility_tennis']='1';
						elseif($val['J']=='1')
							$host['facility_tennis']='1';
								
						if(strchr($facilityTemp,"piano"))
							$host['facility_piano']='1';
						elseif($val['K']=='1')
							$host['facility_piano']='1';
								
						if(strchr($facilityTemp,"gym"))
							$host['facility_gym']='1';
						
						if(strchr($facilityTemp,"disabled access"))
							$host['facility_disable_access']='1';
						elseif($val['H']=='1')
							$host['facility_disable_access']='1';
								
						if(strchr($facilityTemp,"other"))
						{
							$host['facility_other']='1';						
							$host['facility_other_val']=$val['G'];
						}
					}
					//$host['facility_']='0';
					
					$host['rooms']=$val['L'];
					$host['rooms_students']=$val['M'];
					if($host['rooms']=='' || $host['rooms']=='0')
					{
						$host['rooms']='2';
						$host['rooms_students']='1';
					}
					$host['room_type']=$host['room_floor']=$host['room_avail']='1';
					
					$host['bathrooms']=$val['N'];
					$host['bathrooms_avail']='1';
					if($host['bathrooms']=='' || $host['bathrooms']=='0')
						$host['bathrooms']='1';
						
					
					
					$host['laundry_students']='1';
					$host['laundry_out']='';
					if($val['P']=='Yes')
					{
						//$host['laundry_students']='1';
						if($val['O']=='Yes')
							$host['laundry_out']='1';
						if($val['O']=='No')
							$host['laundry_out']='0';	
					}
					elseif($val['P']=='No')
						$host['laundry_students']='0';
					
					$host['home_desc']=$val['Q'];
					
					$hosts[]=$host;
				}
				
				//see($hosts);
				//$this->zimport_model->importHosts2($hosts);
				echo "done";
		}
	
	
	function getDwellingType($d)
	{
				$dwelling=array(
					'Large House'=>'House',
					'Unit'=>'Apartment',
					'House with flat'=>'Self Contained (e.g. Granny Flat)',
					'unit with ocean views'=>'Apartment',
					'House with Big backyard .'=>'House',
					'Townhouse    Bathroom downstai'=>'Townhouse',
					'Semi'=>'Duplex/Semi',
					'Terrace / Fully renovated'=>'Apartment',
					'House with granny flat'=>'Self Contained (e.g. Granny Flat)',
					'Two detatched House'=>'House',
					'Big House and a big backyard'=>'House',
					'Semi/ terrace'=>'Duplex/Semi',
					'Modern Unit'=>'Apartment',
					'House - villa'=>'House',
					'House (two level)'=>'House',
					'Brand New House'=>'House',
					'Duplex'=>'Duplex/Semi',
					'Terrace'=>'Apartment',
					'Flat'=>'Apartment',
					'house- there is swiming pool 1'=>'House',
					'Brand New Modern Unit'=>'Apartment',
					'Semi/Terrace'=>'Duplex/Semi',
					'home'=>'House',
					'Terrace, Decorated out the fro'=>'Apartment',
					'Unit?'=>'Apartment',
					'Large double storie h with swm'=>'House',
					'Large House-'=>'House',
					'Large free standing house'=>'House',
					'Apartment w/ air conditioned'=>'Apartment',
					'Town House'=>'Townhouse',
					'Terrace with loft'=>'Apartment',
					'House + extra flat'=>'House',
					'Large House with Swimming Pool'=>'House',
					'Semi- House'=>'Duplex/Semi',
					'very big house/BRAND NEW'=>'House',
					'Terrace (one floor)'=>'Apartment',
					'Appartment'=>'Apartment',
					'Modern Appartment across the b'=>'Apartment',
					'Semi House'=>'Duplex/Semi',
					'Appartmenment'=>'Apartment',
					'Villa/ Town House'=>'Townhouse',
					'Semi- detached house'=>'Duplex/Semi',
					'Luxury House'=>'House',
					'Huge House'=>'House',
					'2 terrace houses, joyned inter'=>'House',
					'They have a full bathroom in t'=>'House',
					'large, very modern home'=>'House',
					'Terrace (2 stories)'=>'Apartment',
					'Flat (Large Older Style Buildi'=>'Apartment',
					'Town House ; Very Modern Town'=>'Townhouse',
					'House (Simple house)'=>'House',
					'House with swimming pool'=>'House',
					'Semi Terrace'=>'Duplex/Semi',
					'Pen House'=>'Apartment',
					'2 storied House'=>'House',
					'House (Beautiful View)'=>'House',
					'Large Detached House'=>'House',
					'Freestanding'=>'House',
					'Unit (Pent house)'=>'Apartment',
					'Flat/unit'=>'Apartment',
					'semi / terrace'=>'Duplex/Semi',
					'unit flat'=>'Apartment',
					'Unit (Deplex - Townhouse)'=>'Apartment',
					'Flat / Unit'=>'Apartment',
					'Villa'=>'House',
					'Victoria House'=>'House',
					'2 Terrece'=>'Duplex/Semi',
					'Flag/Unit'=>'Apartment',
					'House Semi'=>'Duplex/Semi',
					'House in front of beach'=>'House',
					'Part House'=>'House',
					'House semi/terrace'=>'Duplex/Semi',
					'Unit with Indoor Swiiming Pool'=>'Apartment',
					'flat, terrace'=>'Apartment',
					'Large self contained unit'=>'Apartment',
					'House, she has another appartm'=>'House',
					'homestay'=>'House',
					'Flat/semi'=>'Apartment',
					'Terrace House'=>'Apartment',
					'A WOW House (new and beautiful'=>'House',
					'TBA'=>'Apartment',
					'Unit/House'=>'Apartment',
					'Villa/Town House'=>'Townhouse',
					'Apartment in a very huge compl'=>'Apartment',
					'House with granny flat- see no'=>'Self Contained (e.g. Granny Flat)',
					'Semi Terrace/Town House'=>'Townhouse',
					'Other (Villa )'=>'House',
					'Unit/Flat'=>'Apartment',
					'House- self contained room lik'=>'House',
					'House / Flat'=>'House',
					'house - semi'=>'Duplex/Semi',
					'Double storey home'=>'House',
					'Grammy flat'=>'Self Contained (e.g. Granny Flat)',
					'Town house/Semi terrace'=>'Townhouse',
					'house (big and nice)'=>'House',
					'2 room dwelling with swimming'=>'Apartment',
					'House - 2 storey'=>'House',
					'Purpose Buit Studio at rear of'=>'Apartment',
					'Flat/ Unit'=>'Apartment',
					'2 stories house'=>'House',
					'semi detached terrace house'=>'Duplex/Semi',
					'house, top floor duplex with o'=>'Duplex/Semi',
					'House with self-contained room'=>'Self Contained (e.g. Granny Flat)',
					'flat /unit'=>'Apartment',
					'Semi Terrace/ Duplex'=>'Duplex/Semi',
					'house (son is living at the ba'=>'House',
					'House with garden flat'=>'House',
					'House with self containted and'=>'Self Contained (e.g. Granny Flat)',
					'House (3 storied house)'=>'House',
					'Semi-Terrace'=>'Duplex/Semi',
					'House with Granny Flat  out ba'=>'Self Contained (e.g. Granny Flat)',
					'Apartment above business'=>'Apartment',
					'Semi-Terrace House'=>'Apartment',
					'Double storied house with self'=>'House',
					'semi dettached'=>'Duplex/Semi',
					'Split Terrace/ Granny Flat out'=>'Self Contained (e.g. Granny Flat)',
					'semi-terrace/apartment'=>'Apartment',
					'Apartment_Flat'=>'Apartment',
					'Semi terrace at the back of an'=>'Apartment',
					'Flat - Unit'=>'Apartment',
					'Flat- Unit'=>'Apartment',
					'Semi Terrace with granny flat'=>'Self Contained (e.g. Granny Flat)',
					'Home- to get the house is at t'=>'House',
					'Flat Unit/ Ground floor with c'=>'Apartment',
					'Flat Unit'=>'Apartment',
					'Falt/ Unit'=>'Apartment',
					'2 Story House'=>'House',
					'House with granny flat (see no'=>'Self Contained (e.g. Granny Flat)',
					'Flat_Unit'=>'Apartment',
					'Semi _Terrace'=>'Duplex/Semi',
					'House (two story older style w'=>'House',
					'semi terrace / duplex'=>'Duplex/Semi',
					'Semi Terraze - Town House'=>'House',
					'House (new and modern)'=>'House',
					'Like a Terraze'=>'Duplex/Semi',
					'House, newly renovated.'=>'House',
					'house/semi terrace'=>'Duplex/Semi',
					'Semi terrace townhouse'=>'Townhouse',
					'House with a granny flat'=>'Self Contained (e.g. Granny Flat)',
					'two level townhouse'=>'Townhouse',
					'Executive Apartment'=>'Apartment',
					'House (Duplex)'=>'Duplex/Semi',
					'unit (flat)'=>'Apartment',
					'Penthouse'=>'Apartment',
					'Flat (unit)'=>'Apartment',
					'House (semi)'=>'Duplex/Semi',
					'Flat -unit'=>'Apartment',
					'Flat-unit'=>'Apartment',
					'Three levels house'=>'House',
					'UNIT- FLAT'=>'Apartment',
					'Single storey'=>'House',
					'unit-flat'=>'Apartment',
					'Seme Terrace'=>'Duplex/Semi',
					'Unit /Flat'=>'Apartment',
					'House/ Town House'=>'Townhouse',
					'House with granny flat (living'=>'Self Contained (e.g. Granny Flat)',
					'House Duplex'=>'Duplex/Semi',
					'FLAT (Unit )'=>'Apartment',
					'House/ Townhouse'=>'Townhouse',
					'House / Villa'=>'House',
					'House / Separate Flat'=>'House',
					'House/Duplex'=>'Duplex/Semi',
					'Town House ( 4 levels )'=>'Townhouse',
					'Townhouse with private courtya'=>'Townhouse',
					'two-storey house; 2nd bathroom'=>'House',
					'Flat /  Unit'=>'Apartment',
					'Unit / flat'=>'Apartment',
			);
			
			if(isset($dwelling[$d]))
				$d1=$dwelling[$d];
			else
				$d1=$d;	
			
			$dT=array(
			'House'=>'1',
			'Apartment'=>'4',
			'Townhouse'=>'2',
			'Duplex/Semi'=>'3',
			'Self Contained (e.g. Granny Flat)'=>'5'
			);
			
			if($d1=='' || !isset($dT[$d1]))
				return '';
	
			return $dT[$d1];
	}


	
	function csvHostsRooms()
		{
				$file = './csvfile/hosts2-Room.csv';
				$formOne=$this->readCsv($file);	
				//see($formOne);
				
				$rooms=array();
				foreach($formOne['values'] as $valk=>$val)
				{
					if(!isset($val['X']))
						$val['X']='';
					if(!isset($val['O']))
						$val['O']='';	
					if(!isset($val['N']))
						$val['N']='';	
					if(!isset($val['Q']))
						$val['Q']='';
					if(!isset($val['K']))
						$val['K']='';
					if(!isset($val['L']))
						$val['L']='';
					if(!isset($val['T']))
						$val['T']='';
					if(!isset($val['U']))
						$val['U']='';
					if(!isset($val['V']))
						$val['V']='';
					if(!isset($val['W']))
						$val['W']='';
					if(!isset($val['R']))
						$val['R']='';
					
					$room=array();
					
					$room['salesForceId_room']=$val['A'];
					$room['salesForceId_host']=$val['J'];
					
					$room['type']='1';
					if($val['X']=='Single')
						$room['type']='1';
					elseif($val['X']=='Twin')
						$room['type']='2';
					elseif($val['X']=='Double')
						$room['type']='3';
					
					$room['flooring_other']=$room['flooring']='';
					if($val['W']=='Carpet')
						$room['flooring']='1';
					if($val['W']=='Timber/Wood')
						$room['flooring']='2';
					if($val['W']=='Vinyl')
						$room['flooring']='3';
					if($val['W']=='Tiles')
						$room['flooring']='4';
					if($val['W']=='Other')
					{
						$room['flooring']='5';
						$room['flooring_other']=$val['R'];	
					}
					
					if($room['flooring']=='')
					{
						$room['flooring']='5';
						$room['flooring_other']='Unavailable';
					}
					
					$room['granny_flat']=$room['access']='0';
					if($val['O']=='Yes')
					{
						$room['access']='1';
						if(strchr(strtolower($val['N']),"granny") || strchr(strtolower($val['N']),"grany") || strchr(strtolower($val['C']),"granny") || strchr(strtolower($val['C']),"grany"))
							$room['granny_flat']='1';
					}
					if($val['O']=='No')
						$room['access']='0';
					
					$room['internal_ensuit']='';
					if($val['Q']=='Yes')
						$room['internal_ensuit']='1';
					elseif($val['Q']=='No')
						$room['internal_ensuit']='0';
						
					if($room['internal_ensuit']=='')
						$room['internal_ensuit']=$val['AD'];
					
					$room['avail']='';
					$room['avail_date_leaving']=$room['avail_currently_hosting']=$room['avail_from']='';
					$room['avail_country']=$room['avail_gender']=$room['avail_age']='';
					
					if($val['K']=='' && $val['L']=='')
						$room['avail']='1';
					
					if($val['K']!='')
					{
						$availTempK=explode(' ',$val['K']);
						if(strtotime($availTempK[0]) < strtotime(date('Y-m-d')))
							$room=$this->roomAvailValues($val['L'],$val['T'],$val['U'],$val['V'],$room);
						else
						{
							$room['avail']='0';
							$room['avail_from']=$availTempK[0];
							if($val['L']!='')
							{
								$availTempL=explode(' ',$val['L']);
								if(strtotime($availTempL[0])< strtotime(date('Y-m-d')))
									$room['avail_currently_hosting']='0';
								else
								{
									$room['avail_currently_hosting']='1';
									if(strtotime($availTempL[0])>strtotime($availTempK[0]))
										$room['avail_from']=$room['avail_date_leaving']=$availTempL[0];
									else	
										$room['avail_from']=$room['avail_date_leaving']=$availTempK[0];
									
									if($val['T']=='Under 18')
										$room['avail_age']='1';
									elseif($val['T']=='Over 18')
										$room['avail_age']='0';	
									
									if($val['U']=='Male')
										$room['avail_gender']='1';
									elseif($val['U']=='Female')
										$room['avail_gender']='2';
									
									if($val['V']!='')
										$room['avail_country']=array_search($val['V'],nationList());
								}
							}
							else
								$room['avail_currently_hosting']='0';
						}	
					}
					else
						$room=$this->roomAvailValues($val['L'],$val['T'],$val['U'],$val['V'],$room);
					
					$rooms[]=$room;
				}
				
				///see($rooms);
				//$this->zimport_model->csvHostsRooms($rooms);
				echo "done";
		}
		
			function csvHostsRoomsCorrection()
		{
				$file = './csvfile/hosts2-Room.csv';
				$formOne=$this->readCsv($file);	
				//see($formOne);
				
				$rooms=array();
				foreach($formOne['values'] as $valk=>$val)
				{
					if(!isset($val['X']))
						$val['X']='';
					if(!isset($val['O']))
						$val['O']='';	
					if(!isset($val['N']))
						$val['N']='';	
					if(!isset($val['Q']))
						$val['Q']='';
					if(!isset($val['K']))
						$val['K']='';
					if(!isset($val['L']))
						$val['L']='';
					if(!isset($val['T']))
						$val['T']='';
					if(!isset($val['U']))
						$val['U']='';
					if(!isset($val['V']))
						$val['V']='';
					if(!isset($val['W']))
						$val['W']='';
					if(!isset($val['R']))
						$val['R']='';
					
					$room=array();
					
					$room['salesForceId_room']=$val['A'];
					$room['granny_flat']='0';
					if($val['O']=='Yes')
					{
						if(strchr(strtolower($val['N']),"granny") || strchr(strtolower($val['N']),"grany") || strchr(strtolower($val['C']),"granny") || strchr(strtolower($val['C']),"grany"))
							$room['granny_flat']='1';
					}
					
					//$this->zimport_model->csvHostsRoomsCorrection($room);
				}
				
				//see($rooms);
				
				echo "done";
		}
	
	
	function roomAvailValues($L,$T,$U,$V,$room)
	{
			  /*if($val['L']!='')	
							{
								$availTempL=explode(' ',$val['L']);
								if(strtotime($availTempL[0]) < strtotime(date('Y-m-d')))
									$room['avail']='1';
								else
								{
									$room['avail']='0';
									$room['avail_from']=date('Y-m-d',strtotime($availTempL[0].' + 1 day'));
									$room['avail_currently_hosting']='1';
									$room['avail_date_leaving']=$availTempL[0];
									
									if($val['T']=='Under 18')
										$room['avail_age']='1';
									elseif($val['T']=='Over 18')
										$room['avail_age']='0';	
									
									if($val['U']=='Male')
										$room['avail_gender']='1';
									elseif($val['U']=='Female')
										$room['avail_gender']='2';
									
									if($val['V']!='')
										$room['avail_country']=array_search($val['V'],nationList());
								}	
							}
							else
								$room['avail']='1';*/
			  
			  if($L!='')	
					  {
						  $availTempL=explode(' ',$L);
						  if(strtotime($availTempL[0]) < strtotime(date('Y-m-d')))
							  $room['avail']='1';
						  else
						  {
							  $room['avail']='0';
							  $room['avail_from']=date('Y-m-d',strtotime($availTempL[0].' + 1 day'));
							  $room['avail_currently_hosting']='1';
							  $room['avail_date_leaving']=$availTempL[0];
							  
							  if($T=='Under 18')
								  $room['avail_age']='1';
							  elseif($T=='Over 18')
								  $room['avail_age']='0';	
							  
							  if($U=='Male')
								  $room['avail_gender']='1';
							  elseif($U=='Female')
								  $room['avail_gender']='2';
							  
							  if($V!='')
								  $room['avail_country']=array_search($V,nationList());
						  }	
					  }
					  else
						  $room['avail']='1';
						  
				return $room;		  
	}
	
	function UpdateBedCounts()
	{
		//$this->zimport_model->UpdateBedCounts();
		echo "yes";
	}
	
	function UpdateBedCountsAll()
	{
		//$this->zimport_model->UpdateBedCountsAll();
		echo "yes";
	}
	
	
	function csvHostsBathrooms()
	{
		$file = './csvfile/hosts2-Bathroom.csv';
		$formOne=$this->readCsv($file);	
		///see($formOne);
		
		$bathrooms=array();
		foreach($formOne['values'] as $valk=>$val)
		{
			if(!isset($val['N']))
				$val['N']='';
			if(!isset($val['K']))
				$val['K']='';				
				
			$bathroom=array();
			
			$bathroom['salesForceId_bathroom']=$val['A'];
			$bathroom['salesForceId_host']=$val['J'];
			
			if($val['K']=='Yes')
				$bathroom['avail_to_student']='1';
			else
				$bathroom['avail_to_student']='0';
			
			$bathroom['bath']=$bathroom['shower']=$bathroom['toilet']='0';
			if($val['P']=='1')
				$bathroom['toilet']='1';
			elseif($val['P']=='0')
				$bathroom['toilet']='0';
			if($val['O']=='1')
				$bathroom['shower']='1';
			elseif($val['O']=='0')
				$bathroom['shower']='0';
			if($val['L']=='1')
				$bathroom['bath']='1';
			elseif($val['L']=='0')
				$bathroom['bath']='0';		
			
			
			$bathroom['ensuite']=$val['M'];
			$bathroom['ensuite_external']='1';
			if($val['N']!='' && $val['N']=='Yes')
				$bathroom['ensuite_external']='2';
					
			$bathrooms[]=$bathroom;
		}
		
		//see($bathrooms);
		
		//$this->zimport_model->csvHostsBathRooms($bathrooms);
	    echo "done";
	}
	
	function UpdateBathroomCounts()
	{
		//$this->zimport_model->UpdateBathroomCounts();
		echo "yes";
	}
	
	
	
		function csvHosts3()
	{
		$file = './csvfile/hosts3.xlsx';
		$formOne=$this->readCsv($file);	
		//see($formOne);die();
		
		$hosts=array();
		foreach($formOne['values'] as $valk=>$val)
		{
			if(!isset($val['R']))
				$val['R']='';
			if(!isset($val['E']))
				$val['E']='';
			if(!isset($val['D']))
				$val['D']='';
			if(!isset($val['B']))
				$val['B']='';
			if(!isset($val['C']))
				$val['C']='';
			if(!isset($val['T']))
				$val['T']='';
			if(!isset($val['I']))
				$val['I']='';
			if(!isset($val['J']))
				$val['J']='';
			if(!isset($val['Q']))
				$val['Q']='';
			if(!isset($val['P']))
				$val['P']='';
			if(!isset($val['O']))
				$val['O']='';
			if(!isset($val['N']))
				$val['N']='';
			if(!isset($val['L']))
				$val['L']='';
			if(!isset($val['M']))
				$val['M']='';
			if(!isset($val['F']))
				$val['F']='';
			if(!isset($val['G']))
				$val['G']='';
			if(!isset($val['K']))
				$val['K']='';
			if(!isset($val['U']))
				$val['U']='';
			if(!isset($val['S']))
				$val['S']='';
			
			$host=array();
			
			$host['salesForceId_host']=$val['A'];
			
			$host['pets']='';
			$host['pet_other']=$host['pet_cat']=$host['pet_bird']=$host['pet_dog']='0';
			$host['pets_inside']=$host['pet_other_val']='';
			if($val['R']=='Yes')
			{
				$host['pets']='1';
			
				if($val['U']!='' || $val['S']!='')	
				{
					
					$dogString='dog, English staffy, cavoodles, shitzu, Kelpie, Border Collie, Labradoodle,schnauzer, German Shepard, Cocker Spanish, cavalier king, Dig, Golden retriever, Beagle, Labrador, Bulldog, Jack Russel, Poodle, Puddles, Poodles, Terrier, Terriers, Malteese, Maltese, Maltesse, Malteze, Moltese, Puppy, puppie, puppies';
					$dogStringArray=explode(',',$dogString);
					foreach($dogStringArray as $dogV)
					{
						if(strchr(trim(strtolower($val['U'].' '.$val['S'])),trim(strtolower($dogV))))
							$host['pet_dog']='1';
						if($host['pet_dog']=='1')
							break;
					}
					
					$birdString='bird, quail, cockatoo, Rainbow Lorikeet,Parrot, Budgies, Budgie, duck';
					$birdStringArray=explode(',',$birdString);
					foreach($birdStringArray as $birdV)
					{
						if(strchr(trim(strtolower($val['U'].' '.$val['S'])),trim(strtolower($birdV))))
							$host['pet_bird']='1';
						if($host['pet_bird']=='1')
							break;
					}
					
					$catString='cat, kitty, kitten';
					$catStringArray=explode(',',$catString);
					foreach($catStringArray as $catV)
					{
						if(strchr(trim(strtolower($val['U'].' '.$val['S'])),trim(strtolower($catV))))
							$host['pet_cat']='1';
						if($host['pet_cat']=='1')
							break;
					}	
					
					$petOtherStirng='Guinea pig,Goldfish,Gold fish,Fish,Rabbit,Blue Tongue Lizard,Chicken,turtle,Lizard,Golden Fish,Hen,Australian python,Rat,Chinchilla,chicke,Chook,mouse,Hamster';
					$petOtherStirngArray=explode(',',$petOtherStirng);
					foreach($petOtherStirngArray as $petOtherV)
					{
						if(strchr(trim(strtolower($val['U'].' '.$val['S'])),strtolower($petOtherV)))	
						{
							$host['pet_other']='1';
							if($host['pet_other_val']!='')
								$host['pet_other_val'] .=', ';
							$host['pet_other_val'] .=$petOtherV;
						}
					}
				}
				
				if($val['T']=='Outdoors')
					$host['pets_inside']='0';
				elseif($val['T']=='Indoors' || $val['T']=='Indoors & Outdoors')
					$host['pets_inside']='1';
					
			}
			elseif($val['R']=='No' || $val['R']=='False')
				$host['pets']='0';
			
			
			$host['ins']='0';
			$host['ins_home_content']=$host['ins_20million']=$host['ins_expiry']=$host['ins_policy_no']=$host['ins_provider']='';
			
			if($val['Q']=='Yes')
			{
				$host['ins']='1';
				$host['ins_provider']=$val['N'];
				$host['ins_policy_no']=$val['P'];
				
				if($val['O']!='')
					$host['ins_expiry']=$this->excel_number_to_date($val['O']);
				
				if($val['L']=='Yes')
					$host['ins_20million']='1';
				elseif($val['L']=='No')
					$host['ins_20million']='0';
			}
			
			if($val['M']=='Yes')
				$host['ins_home_content']='1';
			elseif($val['M']=='No')
				$host['ins_home_content']='0';	
			
			$host['main_religion_other']=$host['main_religion']='';
			if($val['F']!='')
			{	
				$val['F']=trim($val['F']);
				if(strtolower($val['F'])=='athiest' || strtolower($val['F'])=='atheist' || strtolower($val['F'])=='atheistic')	
					$host['main_religion']='1';
				elseif(strtolower($val['F'])=='bhuddist' || strtolower($val['F'])=='buddism' || strtolower($val['F'])=='budhist' || strchr(strtolower($val['F']),"buddha") || strchr(strtolower(strtolower($val['F'])),"buddhism") || strchr(strtolower($val['F']),"buddhist") || strchr(strtolower($val['F']),"buddish") || strchr(strtolower($val['F']),"buddist") )	
					$host['main_religion']='2';
				elseif(strtolower($val['F'])=='cathalic' || strtolower($val['F'])=='cathelic' || strtolower($val['F'])=='cathlic' || strtolower($val['F'])=='cathloic' || strtolower($val['F'])=='chatholic' || strtolower($val['F'])=='chriatian' || strtolower($val['F'])=='christain' || strtolower($val['F'])=='christan' || strtolower($val['F'])=='chuirch of england' || strtolower($val['F'])=='coe' || strtolower($val['F'])=='cristian' || strtolower($val['F'])=='r / c' || strtolower($val['F'])=='r. c' || strtolower($val['F'])=='r.c' || strtolower($val['F'])=='r/c' || strtolower($val['F'])=='rc' || strchr(strtolower($val['F']),"catholic") || strchr(strtolower($val['F']),"christian") || strchr(strtolower($val['F']),"church") || strchr(strtolower($val['F']),"c of e"))	
					$host['main_religion']='3';
				elseif(strtolower($val['F'])=='Hindo' || strchr(strtolower($val['F']),"hindu"))	
					$host['main_religion']='4';
				elseif((strtolower($val['F'])=='islam' || strchr(strtolower($val['F']),"muslim")) && strtolower($val['F'])!='No muslim')	
					$host['main_religion']='5';
				elseif(strchr(strtolower($val['F']),"jewish"))	
					$host['main_religion']='6';
				elseif(strtolower($val['F'])=="other")
						{
							$val['G']=trim($val['G']);
							if((strtolower($val['G'])=='chatholic' || strtolower($val['G'])=='christian' || strchr(strtolower($val['G']),"catholic") || strchr(strtolower($val['G']),"church")) && strtolower($val['G'])!='non catholic')	
								$host['main_religion']='3';
							elseif(strchr(strtolower($val['G']),"muslim"))
								$host['main_religion']='5';
							elseif(strchr(strtolower($val['G']),"hindu"))
								$host['main_religion']='4';
							elseif(strchr(strtolower($val['G']),"buddhist"))
								$host['main_religion']='2';
							else
							{
								$host['main_religion']='0';
								$host['main_religion_other']=$val['G'];
							}
						}
				else
				{
					$host['main_religion']='0';
					$host['main_religion_other']=$val['F'];
				}		
			}
			
			
			$host['hosted_international_exp']=$host['hosted_international']='';
			if($val['J']=='Yes' || $val['J']=='Yes, please provide details')
			{
				$host['hosted_international']='1';
				$host['hosted_international_exp']=$val['I'];
			}
			elseif($val['J']=='No')
				$host['hosted_international']='0';
				
			$host['family_desc']=$val['K'];
			
			$host['bank_name']=$val['E'];
			$host['bank_bsb']=$val['D'];
			$host['bank_acc_name']=$val['B'];
			$host['bank_acc_no']=$val['C'];
			
			$hosts[]=$host;
		}
		
		//see($hosts);
		//$this->zimport_model->importHosts3($hosts);
	    echo "done";
	}
	
	function excel_number_to_date($num)

{

$num=$num-25570; //this is because php date function work only for date after 1/1/1970

return $this->addday('1970/01/02',$num);

}

    function addday($dat,$days)

    {

    $dat=str_replace('/','-',$dat);

    $dat=date('Y-m-d',strtotime($dat));

    return date('Y-m-d',strtotime($days.' days',strtotime($dat)));

    }
	

		function csvHosts3_members($part)
	{
		//$file = './csvfile/hosts3-members.xlsx';
		$file = './csvfile/hosts3-members -'.$part.'.xlsx';
		
		$formOne=$this->readCsv($file);	
		//see($formOne);die();
		
		$hosts=array();
		foreach($formOne['values'] as $valk=>$val)
		{
			if(!isset($val['C']))
				$val['C']='';
			if(!isset($val['D']))
				$val['D']='';
			if(!isset($val['E']))
				$val['E']='';
			if(!isset($val['G']))
				$val['G']='';
			if(!isset($val['F']))
				$val['F']='';
			if(!isset($val['H']))
				$val['H']='';
			if(!isset($val['J']))
				$val['J']='';
			if(!isset($val['K']))
				$val['K']='';
			if(!isset($val['I']))
				$val['I']='';
			if(!isset($val['L']))
				$val['L']='';
			if(!isset($val['M']))
				$val['M']='';
			if(!isset($val['N']))
				$val['N']='';
			if(!isset($val['O']))
				$val['O']='';
			if(!isset($val['P']))
				$val['P']='';
			if(!isset($val['Q']))
				$val['Q']='';
			if(!isset($val['R']))
				$val['R']='';
			if(!isset($val['S']))
				$val['S']='';
			if(!isset($val['T']))
				$val['T']='';
			if(!isset($val['U']))
				$val['U']='';
			if(!isset($val['V']))
				$val['V']='';
			if(!isset($val['W']))
				$val['W']='';
			if(!isset($val['X']))
				$val['X']='';
				
			
			if($val['I']=='distribute')	
				continue;
				
			$host=array();
			$host['salesForceId_member']=$val['A'];
			$host['salesForceId_host']=$val['B'];
			
			if($val['C']=='Mr.')
				$host['title']='1';
			elseif($val['C']=='Mrs.')
				$host['title']='2';
			elseif($val['C']=='Ms.')
				$host['title']='3';
			elseif($val['C']=='Master')
				$host['title']='4';
			elseif($val['C']=='Dr.')
				$host['title']='5';
			else
				$host['title']='';
			
			$host['fname']=$val['D'];
			if($host['fname']=='' || $host['fname']=='-')
				$host['fname']='Firstname';
			
			$host['lname']=$val['E'];
			if($host['lname']=='' || $host['lname']=='-')
				$host['lname']='Lastname';
			
			if($val['F']=='' && $val['G']=='')
				$host['dob']='1970-01-01';
			else	
			{
				if($val['F']!='')
					$host['dob']=$this->excel_number_to_date($val['F']);
				elseif($val['G']!='')
					$host['dob']=$this->excel_number_to_date($val['G']);

				if($host['dob']=='1899-12-30')
					$host['dob']='1970-01-01';	
			}
			
			
			if(trim($val['H'])=='Male' || trim($val['H'])=='M')
				$host['gender']='1';	
			elseif(trim($val['H'])=='Female' || trim($val['H'])=='F')
				$host['gender']='2';
			else
			{
				if($host['title']!='' && ($host['title']=='1' || $host['title']=='4'))
					$host['gender']='1';
				elseif($host['title']!='' && ($host['title']=='2' || $host['title']=='3'))
					$host['gender']='2';
				else
					$host['gender']='1';
			}		
			
			$host['role']=$this->getRoleType($val['I']);
			if($host['role']=='100')
			{
				if($host['gender']=='1')
					$host['role']='2';
				elseif($host['gender']=='2')
					$host['role']='1';
				else
					$host['role']='';
			}
			
			$host['occupation']=$val['J'];
			
			$host['smoker']='0';
			if(trim(strtolower($val['K']))=='no' || trim(strtolower($val['K']))=='false')
				$host['smoker']='0';
			elseif(trim(strtolower($val['K']))=='yes' || trim(strtolower($val['K']))=='true' || trim(strtolower($val['K']))==strtolower('Yes (Outside Only)') || trim(strtolower($val['K']))==strtolower('Yes (Outdoors)'))	
				$host['smoker']='1';
			elseif(trim(strtolower($val['K']))==strtolower('Yes (Indoors & Outdoors)') || trim(strtolower($val['K']))==strtolower('Yes (Inside & Outside)'))		
				$host['smoker']='2';
			
			$host['ethnicity']='';
			if($val['L']!='')
			{
				$host['ethnicity']=array_search($val['L'],nationList());
				if($val['L']=='other')
					$host['ethnicity']=array_search($val['M'],nationList());
			}
				
			$host['languages']=preg_replace('/[^0-9]/', '', $val['N']);
			if($host['languages']!='')
			{
				if($host['languages']=='1' || $host['languages']>1)
				{
					$getLanguageInfo1=$this->getLanguageInfo($val['O'],$val['T']);
					$host['language1']=$getLanguageInfo1['language'];
					$host['language1_prof']=$getLanguageInfo1['language_prof'];
				}
				if($host['languages']=='2' || $host['languages']>2)
				{
					$getLanguageInfo2=$this->getLanguageInfo($val['P'],$val['U']);
					$host['language2']=$getLanguageInfo2['language'];
					$host['language2_prof']=$getLanguageInfo2['language_prof'];
				}
				if($host['languages']=='3' || $host['languages']>3)
				{
					$getLanguageInfo3=$this->getLanguageInfo($val['Q'],$val['V']);
					$host['language3']=$getLanguageInfo3['language'];
					$host['language3_prof']=$getLanguageInfo3['language_prof'];
				}
				if($host['languages']=='4' || $host['languages']>4)
				{
					$getLanguageInfo4=$this->getLanguageInfo($val['R'],$val['W']);
					$host['language4']=$getLanguageInfo4['language'];
					$host['language4_prof']=$getLanguageInfo4['language_prof'];
				}
				if($host['languages']=='5')
				{
					$getLanguageInfo5=$this->getLanguageInfo($val['S'],$val['X']);
					$host['language5']=$getLanguageInfo5['language'];
					$host['language5_prof']=$getLanguageInfo5['language_prof'];
				}
			}
			else
			{
				$host['language1']='10';
				$host['language1_prof']='3';
			}
					
			$hosts[]=$host;
		}
		
		//see($hosts);
		//$this->zimport_model->csvHosts3_members($hosts);
	    echo "done";
	}
	
	function getLanguageInfo($valL,$valP)
	{
		$language=array_search($valL,languageList());
		$language_prof=array_search($valP,languagePrificiencyList());
					
		if($language=='')
			$language='10';
		if(	$language_prof=='')
			$language_prof='3';
		
		return 	array(
			'language'=>$language,
			'language_prof'=>$language_prof
		);
	}
	
	function getRoleType($d)
	{
		$role=array(
			'Host Father'=>'Host Father',
			'Host Mother'=>'Host Mother',
			'Daughter'=>'Daughter',
			'Son'=>'Son',
			'Grandmother'=>'Grandmother',
			'Partner'=>'Partner',
			'Relatives'=>'Relatives',
			'Grandfather'=>'Grandfather',
			'Friends/Housemate'=>'Friends/Housemate',
			'Brother'=>'Brother',
			'Sister'=>'Sister',
			'Casual visitor (which overnights regularly)	'=>'Casual visitor (which overnights regularly)',
			'Lives alone'=>'',
			'Owner of the house.	'=>'',
			'Homestay'=>'',
			'?'=>'',
			'(moved out)'=>'',
			'Contat person'=>'',
			'Friends/Housemates'=>'Friends/Housemate',
			'Casual Visitor'=>'Casual visitor (which overnights regularly)',
			'Host'=>'Hostfather or mother based on gender',
			'Wife of son'=>'Daughter-in-law',
			'distribute'=>'Daughter',
			'Mother'=>'Grandmother',
			'Wife, host'=>'Host Mother',
			'Wife'=>'Partner',
			'Husband, host'=>'Host Father',
			'Husband'=>'Partner',
			'Self'=>'Hostfather or mother based on gender',
			'Boy Friend'=>'Casual visitor (which overnights regularly)',
			'Girl Friend'=>'Casual visitor (which overnights regularly)',
			'Father'=>'Grandfather',
			'Son (sometimes visit)'=>'Son',
			'Spouse'=>'Partner',
			'Friend	'=>'Friends/Housemate',
			'Main contact'=>'Hostfather or mother based on gender',
			'Self-wife'=>'Host Mother',
			'Wife-host'=>'Host Mother',
			'Self, host'=>'Hostfather or mother based on gender',
			'Mother, host'=>'Host Mother',
			'Host, husband'=>'Host Father',
			'Father, host'=>'Host Father',
			'Mother, self'=>'Host Mother',
			'Mother, self, host'=>'Host Mother',
			'Daughter inn law'=>'Daughter-in-law',
			'Mum, host'=>'Host Mother',
			'Host, partner'=>'Partner',
			'Daughter, host'=>'Daughter',
			'De facto'=>'Partner',
			'Host Fathert'=>'Host Father',
			'House-mate, friend'=>'Friends/Housemate',
			'Partner, host'=>'Partner',
			'Border'=>'Friends/Housemate',
			'Son in law'=>'Son-in-law',
			'Grand Daughter'=>'Daughter',
			'Mother, wife'=>'Host Mother',
			'Daughter (Does not live at hom'=>'Casual visitor (which overnights regularly)',
			'Father, husband'=>'Host Father',
			'Grandaughter'=>'Granddaughter',
			'Daughter.'=>'Daughter',
			'Cousin'=>'Relatives',
			'Fiancee, host'=>'Partner',
			'Fiancee'=>'Partner',
			'Husband, Father'=>'Host Father',
			'Daughter in Law'=>'Daughter-in-law',
			'Eden'=>'Friends/Housemate',
			'Mother/Host'=>'Host Mother',
			'Client Relations Manager'=>'Casual visitor (which overnights regularly)',
			'Host, Self'=>'Hostfather or mother based on gender',
			'Host, Mother	Host'=>'Mother',
			"Karen's Brother"=>'Brother',
			'Holst'=>'Hostfather or mother based on gender',
			'Host, Father'=>'Host Father',
			'Host, Daughter'=>'Host Mother',
			'Mother Host'=>'Host Mother',
			'Main contact mother'=>'Host Mother',
			'Nephew'=>'Friends/Housemate',
			'Daugher'=>'Daughter',
			'Grand son'=>'Son',
			'Nece'=>'Relatives',
			'Host / Mother'=>'Host Mother',
			"Alix's Boyfriend	"=>'Casual visitor (which overnights regularly)',
			'Boarder'=>'Friends/Housemate',
			'Mohter'=>'Host Mother',
			'Partners / Host'=>'Partner',
			'Share Friend'=>'Friends/Housemate',
			'Host, wife'=>'Host Mother',
			'Host/ Wife	'=>'Host Mother',
			'Flat mate'=>'Friends/Housemate',
			'Daughter (Moved out)'=>'Daughter',
			'Fiance'=>'Partner',
			'Partner  1966'=>'Partner',
			'Host   1955'=>'Hostfather or mother based on gender',
			'Daughter   1996'=>'Daughter',
			'Daughter - Main host'=>'Host Mother',
			'Female'=>'Friends/Housemate',
			'DeFacto'=>'Partner',
			'Host    35 yo'=>'Hostfather or mother based on gender',
			'Mother    32yo'=>'Host Mother',
			'Son   4 yo'=>'Son',
			'Daughter 4yo'=>'Daughter',
			'Son  3 months'=>'Son',
			'Good Friend    30s'=>'Casual visitor (which overnights regularly)',
			'Host/ Daughter'=>'Host Mother',
			'Niece'=>'Relatives',
			'Visitor'=>'Casual visitor (which overnights regularly)',
			'Visitor part time'=>'Casual visitor (which overnights regularly)',
			'Hasband	'=>'Partner',
			'Hots'=>'Hostfather or mother based on gender',
			'head of the house	'=>'Host Father',
			'Mum'=>'Host Mother',
			'Head of the family'=>'Host Father',
			'Mother in law'=>'Relatives',
			'Auntie next door'=>'Casual visitor (which overnights regularly)',
			'Student'=>'Friends/Housemate',
			'Partner (Sometimes)'=>'Partner',
			'Partner (visit)	'=>'Partner',
			'Sib'=>'Son',
			'Grandson'=>'Son',
			'Granddaughter'=>'Granddaughter',
			'De Focto'=>'Partner',
			'Husband / father'=>'Host Father',
			'Cristian'=>'Friends/Housemate',
			'Grand Father'=>'Grandfather',
			'Grand Mother'=>'Grandmother',
			'Son-in-law'=>'Son-in-law',
			'Grandduaghter'=>'Granddaughter',
			'Mother of the Host'=>'Host Mother',
			'Bestfriend'=>'Friends/Housemate',
			'Daughter to Simon'=>'Daughter',
			'Single'=>'Hostfather or mother based on gender',
			'De-facto'=>'Partner',
			'Sister in law'=>'Relatives',
			'Daughter but not living here'=>'Daughter',
			'Husbad'=>'Host Father',
			'Mum of the Host'=>'Grandmother',
			"Jonita's Mother"=>'Grandmother',
			"Mother's Host"=>'Host Mother',
			'Child'=>'Daughter',
			'Flatmate'=>'Friends/Housemate',
			'Son (living at the back)	'=>'Son',
			'Son (moved out)'=>'Son',
			"Joan's Mother"=>'Grandmother',
			'Mother of Host'=>'Grandmother',
			'Father of Host'=>'Grandfather',
			'Mother of Eva'=>'Grandmother',
			'Son of Angela'=>'Son',
			'House mate'=>'Friends/Housemate',
			'Daughter(moving to Dubai)'=>'Daughter',
			'Host fafther'=>'Host Father',
			'Housewife'=>'Host Mother',
			'Host  Father'=>'Host Father',
			'Son (of Sarah)'=>'Son',
			'Partner of Alex'=>'Partner',
			'Daughter (of Sarah)'=>'Daughter',
			'Baby boy'=>'Son',
			'Mother of Host Mother'=>'Grandmother',
			'University Tutor'=>'Casual visitor (which overnights regularly)',
			'Son of Suzanne'=>'Son',
			'Friend (temporary)'=>'Friends/Housemate',
			'Homestay Student'=>'Friends/Housemate',
			"Melanie's Father"=>'Grandfather',
			'Retail Consultant'=>'Casual visitor (which overnights regularly)',
			'Hushand'=>'Host Father',
			"William's Mother"=>'Grandmother',
			'Host Coordinator'=>'Casual visitor (which overnights regularly)',
			'Hostmother'=>'Host Mother',
			'homeowner'=>'Relatives',
			'Live on her own'=>'Host Mother',
			'Host/ Father'=>'Host Father',
			'Student Wkend only'=>'Casual visitor (which overnights regularly)',
			'Hostomother'=>'Host Mother',
			'Son-moved out'=>'Son',
			'Daghter'=>'Daughter',
			'Son 25yrs'=>'Son',
			'Aunt'=>'Relatives',
			'visiter'=>'Casual visitor (which overnights regularly)',
			"Steve's daughter"=>'Daughter',
			"Jane's mother"=>'Grandmother',
			'daugther'=>'Daughter',
			'Niece partner'=>'Relatives',
			'Doughter'=>'Daughter',
			'Aunty'=>'Relatives',
			'First Son'=>'Son',
			'Host  Mother'=>'Host Mother',
			'Host Monther'=>'Host Mother',
			'Daughter - see notes'=>'Daughter',
			'Host mother'=>'(partner)	Host Mother',
			'Grandma'=>'Grandmother',
			'Brother in law'=>'Relatives',
			'Mother of Juana'=>'Grandmother',
			'Daughetr'=>'Daughter',
			'Son of Eduardo and Anna'=>'Son',
			'Nanny'=>'Casual visitor (which overnights regularly)',
			'Hostfather'=>'Host Father',
			'Stepdaughter'=>'Daughter',
			'Daughter-in -law'=>'Daughter-in-law',
			'daughter &son in law'=>'Relatives',
			'Son (8)'=>'Son',
			'Son (6)'=>'Son',
			'Daughter (3)'=>'Daughter',
			'Daughter 18'=>'Daughter',
			'Son 22'=>'Son',
			'Daughter (8)'=>'Daughter',
			"Jenny's Mum"=>'Grandmother',
			'De Facto Partner	Partner',
			'Friend/Partner'=>'Partner',
			'Daughter-Twin'=>'Daughter',
			'Tenant'=>'Friends/Housemate',
			'13 year old'=>'Son',
			'Family Friend'=>'Casual visitor (which overnights regularly)',
			'Wife - Host Mother'=>'Host Mother',
			'Cousin (temporary)'=>'Relatives',
			'Pet dog'=>'Relatives',
			'Homestay father'=>'Host Father',
			'Step Son'=>'Son',
			'Partner of Daughter'=>'Son-in-law',
			'Housekeeper'=>'Friends/Housemate',
			'Father in Law'=>'Relatives',
			"Linda's partner - see note"=>'Son-in-law',
			'Father of the Host'=>'Grandfather',
			'Host Female'=>'Host Mother',
			'Foster Child'=>'Son',
			'Partner (occassionally)'=>'Partner',
			'Mother of Nadia (62)'=>'Grandmother',
			'Son (1995)'=>'Son',
			'Son (1999)'=>'Son',
			'Daughter (2001)'=>'Daughter',
			'Daughter 15'=>'Daughter',
			'Son 13'=>'Son',
			'Mom of Host'=>'Grandmother',
			'Sister of Host'=>'Sister',
			'Son of Host'=>'Son',
			'Host Father Partner'=>'Partner',
			'host Mather'=>'Hostfather or mother based on gender',
			'Father of  the Host'=>'Grandfather',
			'Son - see notes'=>'Son',
			'Son (time to time)'=>'Son',
			'Hos Mother'=>'Host Mother',
			'Son (10 months old)'=>'Son',
			'Grand-daughter'=>'Granddaughter',
			'invisible friend'=>'Friends/Housemate',
			'Host Grand father'=>'Grandfather',
			'Son of the host'=>'Son',
			'Daughter (4mths)'=>'Daughter',
			"Florain's girlfriend"=>'Daughter-in-law',
			'Parter(Casual visitor)'=>'Casual visitor (which overnights regularly)',
			'Host Mother (Disability)'=>'Host Mother',
			'Host Father (Partner)'=>'Host Father',
			'Host Mother/ Nurse'=>'Host Mother',
			'Son (Born 2004)'=>'Son',
			'Host Mother (Wed-Mon)'=>'Host Mother',
			'House Keeper'=>'Casual visitor (which overnights regularly)',
			'Step Daughter'=>'Daughter',
			'Mom'=>'Grandmother',
			'Son(away travelling for a year'=>'Son',
			'Carmen'=>'Friends/Housemate',
			'Daughter (13 years)'=>'Daughter',
			'Son (11 years )'=>'Son',
			'Daughter (7 years)'=>'Daughter',
			'Daughter (5 years )'=>'Daughter',
			'Son ( 2 years)'=>'Son',
			'Visitor - see note'=>'Casual visitor (which overnights regularly)',
			'Occasional Visitor'=>'Casual visitor (which overnights regularly)',
			'Host Moter'=>'Host Mother',
			"Son (Jody's son)"=>'Grandson',
			"Daughter (Matt's daughter)"=>'Granddaughter',
			'Host Sister'=>'Sister',
			'Host Mother (sister)'=>'Sister',
			'Host Father (Brother )'=>'Brother',
			'Brother of the host'=>'Brother',
			'Mother of the host mother'=>'Grandmother',
			"Miguel's Sister"=>'Relatives',
			'Nephew (18)'=>'Relatives',
			'(Sometimes visit/partner)'=>'Casual visitor (which overnights regularly)',
			'Host brother in law'=>'Relatives',
			'Student Brother'=>'Casual visitor (which overnights regularly)',
			'Student Sister'=>'Casual visitor (which overnights regularly)',
			"Ryan wife's"=>'Daughter-in-law',
			"Amy's boyfriend"=>'Son-in-law',
			'Main Host'=>'Hostfather or mother based on gender',
			'Daughterr'=>'Daughter',
			'Host Mum'=>'Host Mother',
			'Second Son'=>'Son',
			'see details Daughter'=>'Daughter',
			'Partner *'=>'Partner',
			'Host Dad'=>'Host Father',
			'Sister of host mother	Sister',
			'Host Grandmother'=>'Grandmother',
			'Host Grandfather'=>'Grandfather',
			'Younger brother'=>'Brother',
			"Emilia's boy friend"=>'Friends/Housemate',
			'EX partner(regular visiter)'=>'Partner',
			"Host's Friend"=>'Friends/Housemate',
			'daughter -i n law'=>'Daughter-in-law',
			'Hosf Mother'=>'Host Mother',
			'Husband of daughter'=>'Son-in-law'
			);
			
			if($d!='' && isset($role[$d]))
				$r=$role[$d];
			else $r='';
			
			$roles=array(
			  strtolower('HOST MOTHER')=>"1",
			  strtolower('HOST FATHER')=>"2",
			  strtolower('Daughter')=>"3",
			  strtolower('Son')=>"4",
			  strtolower('Grandmother')=>"5",
			  strtolower('Grandfather')=>"6",
			  strtolower('Relatives')=>"7",
			  strtolower('Friends/Housemate')=>"8",
			  strtolower('Casual visitor (which overnights regularly)')=>"9",
			  strtolower('Partner')=>"10",
			  strtolower('Brother')=>"11",
			  strtolower('Sister')=>"12",
			  strtolower('Daughter-in-law')=>"13",
			  strtolower('Son-in-law')=>"14",
			  strtolower('Granddaughter')=>"15",
			  strtolower('Grandson')=>"16",
			  strtolower('Hostfather or mother based on gender')=>"100"
			);
            
			if($r!='')
				return $roles[strtolower($r)];
			else	
				return $r;
	}
	
	function UpdateMemberCounts()
	{
		//$this->zimport_model->UpdateMemberCounts();
		echo "yes";
	}
	
	function UpdateMemberCountsHfaOne()
	{
		//$this->zimport_model->UpdateMemberCountsHfaOne();
		echo "yes";
	}
	
	function UpdateMemberSId()
	{
		//$this->zimport_model->UpdateMemberSId();
		echo "yes";
	}
	
	function csvHosts3_membersLang()
	{
		//$this->zimport_model->csvHosts3_membersLang();
		echo "yes";
	}
	
	function hostUpdatePrimaryMember()
	{
		//$this->zimport_model->hostUpdatePrimaryMember();
		echo "yes";
	}
	
	function hostUpdatePrimaryMemberByName()
	{
		//$this->zimport_model->hostUpdatePrimaryMemberByName();
		echo "yes";
	}
	
	function hostUpdatePrimaryMemberByHFather()
	{
		//$this->zimport_model->hostUpdatePrimaryMemberByHFather();
		echo "yes";
	}
	
	function hostUpdatePrimaryMemberByHMother()
	{
		//$this->zimport_model->hostUpdatePrimaryMemberByHMother();
		echo "yes";
	}
	
	function hostUpdatePrimaryMemberById()
	{
		//$this->zimport_model->hostUpdatePrimaryMemberById();
		echo "yes";
	}
		
	function csvHosts3_wwcc($part)
	{
		//$file = './csvfile/hosts3-members.xlsx';
		//$file = './csvfile/hosts3 - wwcc.xlsx';
		$file = './csvfile/hosts3 - wwcc - '.$part.'.xlsx';
		
		$formOne=$this->readCsv($file);	
		//see($formOne);die();
		
		$hosts=array();
		foreach($formOne['values'] as $valk=>$val)
		{
			if(!isset($val['C']))
				$val['C']='';
			if(!isset($val['D']))
				$val['D']='';	
			if(!isset($val['E']))
				$val['E']='';
				
			
			
			$host=array();
			$host['salesForceId_member']=$val['A'];
			$host['salesForceId_host']=$val['B'];
			
			$host['wwcc_clearence']=$host['wwcc_complete']='0';
			$host['wwcc_app_no']=$host['wwcc_exp']=$host['wwcc_clearence_no']='';
			
			if($val['C']=='Yes')
			{
				$host['wwcc_complete']='1';
				if($val['E']!='')
				  {
					  if(strtolower($val['E'][0])=='w' && strtolower($val['E'][1])=='w')
					  {
						  $host['wwcc_clearence']='1';
						  $host['wwcc_clearence_no']=$val['E'];
						  if($val['D']=='')
							  $host['wwcc_exp']='2019-01-01';
						  else
							  $host['wwcc_exp']=$this->excel_number_to_date($val['D']);
					  }
					  else
					  {
						  if($val['D']!='')
						  {
							  $host['wwcc_clearence']='1';
							  $host['wwcc_clearence_no']=$val['E'];
							  $host['wwcc_exp']=$this->excel_number_to_date($val['D']);
						  }
						  else
						  	 $host['wwcc_app_no']=$val['E'];
						}
				  }
			}
				
			$hosts[]=$host;
		}
		
		//see($hosts);
		//$this->zimport_model->csvHosts3_wwcc($hosts);
	    echo "done";
	}
	
	
	function csvHosts4()
	{
		//$file = './csvfile/hosts3-members.xlsx';
		$file = './csvfile/hosts4.xlsx';
		
		$formOne=$this->readCsv($file);	
		//see($formOne);die();
		
		$hosts=array();
		foreach($formOne['values'] as $valk=>$val)
		{
			if(!isset($val['D']))
				$val['D']='';
			if(!isset($val['E']))
				$val['E']='';
			if(!isset($val['F']))
				$val['F']='';
			if(!isset($val['B']))
				$val['B']='';
			if(!isset($val['C']))
				$val['C']='';	
			
			$host=array();
			$host['salesForceId_host']=$val['A'];
			$host['other_preference']=$val['D'];
			
			$host['ge_referal_other']=$host['ge_referal']='';
			if($val['B']!='')
			{
				if(strtolower($val['B'])==strtolower('Previous Global Experience student'))
					$host['ge_referal']='1';
				elseif(strtolower($val['B'])==strtolower('Previous Global Experience homestay family'))
					$host['ge_referal']='2';
				elseif(strtolower($val['B'])==strtolower('Facebook'))
					$host['ge_referal']='3';
				elseif(strtolower($val['B'])==strtolower('Google'))
					$host['ge_referal']='4';
				elseif(strtolower($val['B'])==strtolower('Global Experience website'))
					$host['ge_referal']='5';
				elseif(strtolower($val['B'])==strtolower('Agent'))
					$host['ge_referal']='6';
				elseif(strtolower($val['B'])==strtolower('Other'))
				{
					$host['ge_referal']='7';
					$host['ge_referal_other']=$val['C'];
				}
			}
			
			$host['accomodate_disable']='';
			if($val['E']=='Yes')
				$host['accomodate_disable']='1';
			elseif($val['E']=='No')
				$host['accomodate_disable']='0';

			$host['reason_gender_pref']=$val['F'];

			$hosts[]=$host;
		}
		
		//see($hosts);
		//$this->zimport_model->csvHosts4($hosts);
	    echo "done";
	}	


	
	function csvHosts4_pref()
	{
		//$file = './csvfile/hosts3-members.xlsx';
		$file = './csvfile/hosts4-pref.xlsx';
		
		$formOne=$this->readCsv($file);	
		//see($formOne);die();
		
		$hosts=array();
		foreach($formOne['values'] as $valk=>$val)
		{
			if(!isset($val['C']))
				$val['C']='';
			if(!isset($val['B']))
				$val['B']='';
			if(!isset($val['D']))
				$val['D']='';
			if(!isset($val['E']))
				$val['E']='';
			if(!isset($val['F']))
				$val['F']='';
			if(!isset($val['H']))
				$val['H']='';
			if(!isset($val['I']))
				$val['I']='';
			if(!isset($val['L']))
				$val['L']='';
			if(!isset($val['K']))
				$val['K']='';
			
			$host=array();
			$host['salesForceId_host']=$val['A'];
			
			$host['age_pref']=$this->getAgePref($val['B']);
			$insertArray= array('16-19','15-25','25+','15+','16+','18-20 +','18-35','20+','18-45','Under 25','18-30','20-30','18 - 30','22 +','17+','15-30','20 +',
			'18-28','15 - 35','18-23','17','18-25','16 +','22+','16-30','under 30','15-40 y/o','over 20','16-25','16-20','13-16','Univ.  age.','21+','15 - 18','15 - 25',
			'16-60','16 - 50','20 - 30','13+','16-23','15 - 23','-30','20 - 26','15-18','16-35','20-40','18-22','21-25','17-28','around 18','20-25','20-39','15-24',
			'18-30+','Under 20','over 16yrs','18-40','16 - 30','19 - 25','up to 20','15 - 24','20-35','15 to 25','17-19','17-20','16-21','16/25','up to 25','16-22',
			'18 - 35','14-50','15-20','17-25','30','18-21','under35','19-30','22-','23+','17-23','14+','max 30','22*','20-22','15-19','18-60','17-50','18*25','18-99',
			'15-35','14-30','14/25','16 - 35','15 - 21','15 - 26','16 - 40','16 - 18','15 - 40','18 - 40','18 - 65','20 - 50','15-60','13-18','17-30','23-27','18-27',
			'school age','16-18','21-35','Under 35','school/uni','-38','18-24','18 - 24','20 - 40','14-25','25-55','Over 21','Over 19','12+','25-','17-19','14-18',
			'15-22','15 - 20','15 - 30','16 - 22','16-25+','21-30','30-50','18/25','17-22','18 - 23','19 +','upto 25','16 - 25','16- 23','20-60','17+','17-25','16-17',
			'25-35','17-32','17-24','19+','19-35','17-19');
			$host['reason_gender_pref']='';
			if(in_array($val['B'],$insertArray))
				$host['reason_gender_pref']='Age preference: '.$val['B'].' | ';
			
			$host['gender_pref']='';
			if($val['C']=='Male')
				$host['gender_pref']='1';
			elseif($val['C']=='Female')	
				$host['gender_pref']='2';
			if($val['C']=='No Preference' ||  $val['C']=='Flexible')
				$host['gender_pref']='3';
			
			if($val['D']!='')
				$host['allow_smoker']=$this->getSmokePref($val['D']);
			else
				$host['allow_smoker']=$this->smokePrefRandom($val['E']);
			
			$host['diet_req']='';
			if($val['F']=='Yes')
				$host['diet_req']='1';
			elseif($val['F']=='No')
				$host['diet_req']='0';
				
			$host['diet_req_allergy']=$host['diet_req_pork']=$host['diet_req_gluten']=$host['diet_req_veg']='0';
			$dieReqArray=explode(';',$val['H']);
			if(in_array('Vegetarian',$dieReqArray))
				$host['diet_req_veg']='1';
			if(in_array('Gluten/Lactose Free',$dieReqArray))
				$host['diet_req_gluten']='1';
			if(in_array('No Pork',$dieReqArray))
				$host['diet_req_pork']='1';
			if(in_array('Food Allergies',$dieReqArray))
				$host['diet_req_allergy']='1';
			if(($host['diet_req']=='' || $host['diet_req']=='0') && ($host['diet_req_allergy']=='1' || $host['diet_req_pork']=='1' || $host['diet_req_gluten']=='1' || $host['diet_req_veg']=='1'))
				$host['diet_req']='1';
			
			
			$host['allergy_pref']='';
			if($val['I']=='Yes')
				$host['allergy_pref']='1';
			elseif($val['I']=='No')
				$host['allergy_pref']='0';
				
			$host['allergy_other']=$host['allergy_dust']=$host['allergy_peanut']=$host['allergy_gluten']=$host['allergy_lactose']=$host['allergy_asthma']=$host['allergy_hay_fever']='0';
			$host['allergy_other_val']='';
			$allergyPrefArray=explode(';',$val['K']);
			if(in_array('Hay Fever',$allergyPrefArray))
				$host['allergy_hay_fever']='1';
			if(in_array('Asthma',$allergyPrefArray))
				$host['allergy_asthma']='1';
			if(in_array('Lactose Intolerance',$allergyPrefArray))
				$host['allergy_lactose']='1';
			if(in_array('Gluten Intolerance',$allergyPrefArray))
				$host['allergy_gluten']='1';
			if(in_array('Peanut Allergies',$allergyPrefArray))
				$host['allergy_peanut']='1';
			if(in_array('Dust Allergies',$allergyPrefArray))
				$host['allergy_dust']='1';
			/*if(in_array('Other',$allergyPrefArray))
			{
				$host['allergy_other']='1';
				$host['allergy_other_val']=str_replace("'","\'",$val['L']);
			}*/
			
			if(trim($val['L'])!='')
			{
				$host['allergy_other']='1';
				$host['allergy_other_val']=str_replace("'","\'",$val['L']);
			}
			
			if(($host['allergy_pref']=='' || $host['allergy_pref']=='0') && ($host['allergy_other']=='1' || $host['allergy_dust']=='1' || $host['allergy_peanut']=='1' || $host['allergy_gluten']=='1' || $host['allergy_lactose']=='1' || $host['allergy_asthma']=='1' || $host['allergy_hay_fever']=='1'))
				$host['allergy_pref']='1';	
			
			$hosts[]=$host;
		}
		
		//see($hosts);
		//$this->zimport_model->csvHosts4_pref($hosts);
	    echo "done";
	}	

	function getAgePref($pref)
	{
		$age_prefKey=array(
		'Over 18'=>'Over 18',
		'No Preference'=>'No Preference',
		'Under 18'=>'Under 18',
		'Any'=>'No Preference',
		'18+'=>'Over 18',
		'16-19'=>'No Preference',
		'15-25'=>'No Preference',
		'25+'=>'Over 18',
		'15+'=>'No Preference',
		'open'=>'No Preference',
		'16+'=>'No Preference',
		'18-20 +'=>'Over 18',
		'18-35'=>'Over 18',
		'20+'=>'Over 18',
		'18-45'=>'Over 18',
		'Under 25'=>'No Preference',
		'18-30'=>'Over 18',
		'20-30'=>'Over 18',
		'18 - 30'=>'Over 18',
		'Flexible'=>'No Preference',
		'22 +'=>'Over 18',
		'17+'=>'Over 18',
		'15-30'=>'No Preference',
		'20 +'=>'Over 18',
		'Older'=>'Over 18',
		'18'=>'Over 18',
		'18 -'=>'Under 18',
		'18-28'=>'Over 18',
		'15 - 35'=>'No Preference',
		'nil'=>'No Preference',
		'12/18/2015'=>'No Preference',
		'18 over'=>'Over 18',
		'younger'=>'Under 18',
		'young'=>'Under 18',
		'14'=>'Under 18',
		'18-23'=>'Over 18',
		'17'=>'Under 18',
		'18 +'=>'Over 18',
		'18 and over'=>'Over 18',
		'none'=>'No Preference',
		'18-25'=>'Over 18',
		'16 +'=>'No Preference',
		"don't mind	"=>'No Preference',
		'22+'=>'Over 18',
		'16-30'=>'No Preference',
		'n/a'=>'No Preference',
		'under 30'=>'No Preference',
		'Any age'=>'No Preference',
		'15-40 y/o'=>'No Preference',
		'over 20'=>'Over 18',
		'16-25'=>'No Preference',
		'All ages'=>'No Preference',
		'16-20'=>'No Preference',
		'13-16'=>'Under 18',
		'Univ.  age.'=>'Over 18',
		'21+'=>'Over 18',
		'15 - 18'=>'Under 18',
		'10/30/2015'=>'No Preference',
		'15 - 25'=>'No Preference',
		'Flexibles'=>'No Preference',
		'-18'=>'Under 18',
		'16-60'=>'No Preference',
		'16 - 50'=>'No Preference',
		'20'=>'Over 18',
		'20 - 30'=>'Over 18',
		'13+'=>'No Preference',
		'16-23'=>'No Preference',
		'15 - 23'=>'No Preference',
		'Adult'=>'Over 18',
		'-30'=>'No Preference',
		'20 - 26'=>'Over 18',
		'15-18'=>'Under 18',
		'16-35'=>'No Preference',
		'20-40'=>'Over 18',
		'18-22'=>'Over 18',
		'21-25'=>'Over 18',
		'17-28'=>'Over 18',
		'18-'=>'Under 18',
		'around 18'=>'Over 18',
		'20-25'=>'Over 18',
		'20-39'=>'Over 18',
		'Female'=>'No Preference',
		'15-24'=>'No Preference',
		'18-30+'=>'Over 18',
		'Under 20'=>'No Preference',
		'18?'=>'No Preference',
		'over 16yrs'=>'No Preference',
		'18-40'=>'Over 18',
		'16 - 30'=>'No Preference',
		'19 - 25'=>'Over 18',
		'up to 20'=>'No Preference',
		'Opne'=>'No Preference',
		'12/24/2015'=>'No Preference',
		'15 - 24'=>'No Preference',
		'na'=>'No Preference',
		'> 18 yrs'=>'Under 18',
		'> 18'=>'Under 18',
		'10/20/2015'=>'No Preference',
		'17'=>'Under 18',
		'15'=>'Under 18',
		'20-35'=>'Over 18',
		'19'=>'Over 18',
		'15 to 25'=>'No Preference',
		'17-19'=>'Under 18',
		'17-20'=>'No Preference',
		'16-21'=>'No Preference',
		'>18'=>'Under 18',
		'16/25'=>'No Preference',
		'18*'=>'Over 18',
		'up to 25'=>'No Preference',
		'16-22'=>'No Preference',
		'18plus'=>'Over 18',
		'18 - 35'=>'Over 18',
		'-18'=>'Under 18',
		'14-50'=>'No Preference',
		'15-20'=>'No Preference',
		'12-01-1935'=>'No Preference',
		'17-25'=>'Over 18',
		'30'=>'Over 18',
		'under18'=>'Under 18',
		'Under17'=>'Under 18',
		'18'=>'Over 18',
		'18-21'=>'Over 18',
		'under35'=>'No Preference',
		'Over18'=>'Over 18',
		'19-30'=>'Over 18',
		'22-'=>'No Preference',
		'above 18'=>'Over 18',
		'perfer +18'=>'Over 18',
		'16'=>'Under 18',
		'23+'=>'Over 18',
		'-17'=>'Under 18',
		'-18'=>'Under 18',
		'17-23'=>'No Preference',
		'14+'=>'No Preference',
		'max 30'=>'No Preference',
		'18-'=>'Under 18',
		'Fexible'=>'No Preference',
		'-18'=>'Under 18',
		'22*'=>'Over 18',
		'20-22'=>'Over 18',
		'15-19'=>'Under 18',
		'18-60'=>'Over 18',
		'17-50'=>'Over 18',
		'18*25'=>'Over 18',
		'11/30/2015'=>'No Preference',
		'18-99'=>'Over 18',
		'15-35'=>'No Preference',
		'14-30'=>'No Preference',
		'14/25'=>'No Preference',
		'18'=>'Over 18',
		'16 - 35'=>'No Preference',
		'15 - 21'=>'No Preference',
		'15 - 26'=>'No Preference',
		'16 - 40'=>'No Preference',
		'17+'=>'Over 18',
		'16 - 18'=>'Under 18',
		'15 - 40'=>'No Preference',
		'18 - 40'=>'Over 18',
		'18 - 65'=>'Over 18',
		'20 - 50'=>'Over 18',
		'15-60'=>'No Preference',
		'13-18'=>'Under 18',
		'17-30'=>'Over 18',
		'23-27'=>'Over 18',
		'18-27'=>'Over 18',
		'U18'=>'Under 18',
		'school age'=>'Under 18',
		'16-18'=>'Under 18',
		'21-35'=>'Over 18',
		'12/26/2015'=>'No Preference',
		'Under 35'=>'No Preference',
		'school/uni'=>'No Preference',
		'-38'=>'No Preference',
		'18-24'=>'Over 18',
		'18 - 24'=>'Over 18',
		'20 - 40'=>'Over 18',
		'14-25'=>'No Preference',
		'25-55'=>'Over 18',
		'Over 21'=>'Over 18',
		'Over 19'=>'Over 18',
		'12+'=>'No Preference',
		'25-'=>'No Preference',
		'17-19'=>'No Preference',
		'12/21/2015'=>'No Preference',
		'14-18'=>'Under 18',
		'15-22'=>'No Preference',
		'15 - 20'=>'No Preference',
		'15 - 30'=>'No Preference',
		'16 - 22'=>'No Preference',
		'16-25+'=>'No Preference',
		'21-30'=>'Over 18',
		'12/17/2015'=>'No Preference',
		'30-50'=>'Over 18',
		'08/20/2015'=>'No Preference',
		'18/25'=>'Over 18',
		'17-22'=>'Over 18',
		'12/28/2015'=>'No Preference',
		'18 - 23'=>'Over 18',
		'12/30/2015'=>'No Preference',
		'19 +'=>'Over 18',
		'upto 18'=>'Under 18',
		'-18'=>'Under 18',
		'upto 25'=>'No Preference',
		'16 - 25'=>'No Preference',
		'16- 23'=>'No Preference',
		'20-60'=>'Over 18',
		'18-'=>'Under 18',
		'17+'=>'Over 18',
		'17-25'=>'Over 18',
		'16-17'=>'Under 18',
		'25-35'=>'Over 18',
		'17-32'=>'Over 18',
		'17-24'=>'Over 18',
		'19+'=>'Over 18',
		'19-35'=>'Over 18',
		'17-19'=>'No Preference'
		);
		
		if(isset($age_prefKey[$pref]))
			$p1=$age_prefKey[$pref];
		else
			$p1=$pref;
		
		$pT=array(
		'Under 18'=>'1',
		'Over 18'=>'2',
		'No Preference'=>'3'
		);
		
		if($p1=='' || !isset($pT[$p1]))
			return '';

		return $pT[$p1];	
		
	}
	
	
	function smokePrefRandom($smoke)
	{
			$smokeRandom=array('Outside Only'=>'Yes (Outdoors)','none'=>'','Not allowed'=>'No','outside Only, Balcony'=>'Yes (Outdoors)','None Student ; NOT ALLOWED'=>'No',
			'In the bedroom with the window open'=>'Yes (Indoors & Outdoors)','In the room with the window open, but prefers not.'=>'Yes (Indoors & Outdoors)',
			'None/ Outside only'=>'Yes (Outdoors)','Not specified'=>'','no, outside only'=>'Yes (Outdoors)','None / Student; Outside Only'=>'Yes (Outdoors)',
			'None / Student; Outside Only'=>'Yes (Outdoors)','Non (allowed only outside)'=>'Yes (Outdoors)','None Student;Outside Only'=>'Yes (Outdoors)',
			'No smoking at all'=>'No','None Student; Outside Only'=>'Yes (Outdoors)','Outside Only (Harry smokes Outside)'=>'Yes (Outdoors)','No'=>'No',
			'no, students have to smoke Outside Only'=>'Yes (Outdoors)','Smoking is not allowed'=>'No','No smoker (student; only outside )'=>'Yes (Outdoors)',
			'outside Only, but preffers not to.'=>'Yes (Outdoors)','None, Student; Outside Only'=>'Yes (Outdoors)','None/ Student; Outside Only'=>'Yes (Outdoors)',
			'smoking is not allowed.'=>'No','No, students outside Only.'=>'Yes (Outdoors)','None / Outside Only'=>'Yes (Outdoors)',
			'None (student can smoke only outside)'=>'Yes (Outdoors)','no smoking allowed in or outside'=>'No','permitted outside only'=>'Yes (Outdoors)',
			'None / Student ; Outside only'=>'Yes (Outdoors)','None / Student;Outside only'=>'Yes (Outdoors)','None/ not allowed.'=>'No','No smoking'=>'No',
			'No, somking is not allowed.'=>'No','student can smoke in the house'=>'Yes (Indoors & Outdoors)','Liny smokes, Outside'=>'Yes (Outdoors)',
			'Students have to smoke outsdie.'=>'Yes (Outdoors)','allowed to smoke outside'=>'Yes (Outdoors)','No smokers, smoking is not allowed.'=>'No',
			'Sutdnets have to smoke outside.'=>'Yes (Outdoors)','Students have to smoke outside the house.'=>'Yes (Outdoors)','None/ NOT ALLOWED'=>'No',
			'Students have to smoke outside.'=>'Yes (Outdoors)','No, smoking is not allowed.'=>'No','None/ Smoking outside only'=>'Yes (Outdoors)',
			'Michelle smokes, outside only'=>'Yes (Outdoors)','No. Smoking outside only'=>'Yes (Outdoors)','None, outside only'=>'Yes (Outdoors)',
			'Anna is a smoker, She allows smoking inside the h'=>'Yes (Indoors & Outdoors)','no, students have to smoke outside.'=>'Yes (Outdoors)',
			'no, smoking is not allowed'=>'No','yes, smoking is allowed inside the house.'=>'Yes (Indoors & Outdoors)','Only outside'=>'Yes (Outdoors)',
			'No , smoking is not allowed in this house'=>'No','Host Mother smokes'=>'Yes (Indoors & Outdoors)','No smoker in the house'=>'No',
			'No smokers in the house, can smoke outside'=>'Yes (Outdoors)','Non Smoker'=>'No','No smokers please'=>'No',
			'Allowed to smoke outside only'=>'Yes (Outdoors)','Can smoke outside only'=>'Yes (Outdoors)','NO, Allows to smoke only outside'=>'Yes (Outdoors)',
			'No, only outside'=>'Yes (Outdoors)','None/ Student Only outside'=>'Yes (Outdoors)','none only outside'=>'Yes (Outdoors)',
			'None / Student; only outside'=>'Yes (Outdoors)','None/ Student ; Outside Only'=>'Yes (Outdoors)','None/ Student Outside Only'=>'Yes (Outdoors)',
			'non smoker please'=>'No','None smoking is allowed'=>'No','Yes/ Outside Only'=>'Yes (Outdoors)','no smoking is allowed'=>'No',
			'Smoking is not allowed in the house'=>'Yes (Outdoors)','Not allowed to smoke in the house'=>'Yes (Outdoors)','She smokes'=>'Yes (Outdoors)',
			'Husband smokes outside'=>'Yes (Outdoors)','Non/ student outside only'=>'Yes (Outdoors)','Smoking Outside Only'=>'Yes (Outdoors)',
			'None Allowed Outside Only'=>'Yes (Outdoors)','None Student; Outside Only'=>'Yes (Outdoors)','None/ Student ;Outside Only'=>'Yes (Outdoors)',
			'n/allowed'=>'No','None / Student ;Outside Only'=>'Yes (Outdoors)','None/ Student; outside Only, balcony on bedroom'=>'Yes (Outdoors)',
			'Smoking not allowed'=>'No','None Outside Only'=>'Yes (Outdoors)','smoke in the back room only'=>'Yes (Indoors & Outdoors)','Upstairs'=>'Yes (Outdoors)',
			'Definetly Smoking is not allowed'=>'No','None Student;Outside Only'=>'Yes (Outdoors)','None/ Student;Outside Only'=>'Yes (Outdoors)',
			'None/ Outside only (balcony)'=>'Yes (Outdoors)','No smokers, students have to smoke outside.'=>'Yes (Outdoors)','non smoking'=>'No',
			'Outside preferred'=>'Yes (Outdoors)','outside Only, possibly'=>'Yes (Outdoors)','None (Outside Only)'=>'Yes (Outdoors)',
			'None/ Student : Outside only'=>'Yes (Outdoors)','None (Student; Outside Only)'=>'Yes (Outdoors)','no smoking inside or outside'=>'No',
			'None (St outside only)'=>'Yes (Outdoors)','None Outside Only'=>'Yes (Outdoors)','None / Student: Outside Only'=>'Yes (Outdoors)',
			'none Only outside'=>'Yes (Outdoors)','Margaret is smoker (Only Outside)'=>'Yes (Outdoors)','Outside/ other side'=>'Yes (Outdoors)',
			'None (allowed outside)'=>'Yes (Outdoors)','None/ Student; Only outside'=>'Yes (Outdoors)','Yes'=>'Yes (Indoors & Outdoors)',
			'None (student; outside only)'=>'Yes (Outdoors)','Smokers in Homestay / Student only outside'=>'Yes (Outdoors)',
			'Yes (Mary smokes outside only) Student ; No'=>'No','No , only outside'=>'Yes (Outdoors)','None/Student; Allowed outside only'=>'Yes (Outdoors)',
			'None/ Student can smoke outside'=>'Yes (Outdoors)','None Student; only outside'=>'Yes (Outdoors)','None / Not allowed'=>'No',
			'None/ Student can smoke at home'=>'Yes (Indoors & Outdoors)','None / Can smoke inside'=>'Yes (Indoors & Outdoors)','No smokers'=>'No',
			'Yes/ Student;Outside Only'=>'Yes (Outdoors)','(Sara is smoker, but outside only)'=>'Yes (Outdoors)','Yes Outside Only'=>'Yes (Outdoors)',
			'Yes outside'=>'Yes (Outdoors)','None / Student ; Not Allowed'=>'No','No outside only'=>'Yes (Outdoors)',
			'Yes / Student can smoke inside'=>'Yes (Indoors & Outdoors)','None Student; Outside only'=>'Yes (Outdoors)',
			'None / Smoking is not allowed'=>'No','No Student; Outside Only'=>'Yes (Outdoors)','None Student; Not Allowed'=>'No',
			'Yes(Always outside) Student; Outside only'=>'Yes (Outdoors)','Yes/ Outside Only'=>'Yes (Outdoors)','None / Student; Not Allowed'=>'No',
			'None / Student is not allowed smoking'=>'No','None / Studeint is not allowed to smoke'=>'No','None/ Smoking is not allowed'=>'No',
			'None Student;Outside Only'=>'Yes (Outdoors)','Mary is smoker'=>'Yes (Indoors & Outdoors)','Outside'=>'Yes (Outdoors)',
			'Yes / Student; Outside Only'=>'Yes (Outdoors)','Yes (Outside Only)'=>'Yes (Outdoors)','None / Student; Outside Only'=>'Yes (Outdoors)',
			'None (Son smoke) Student; Outside Only'=>'Yes (Outdoors)','None / Student; Not allowed'=>'No','None / Strictly Non Smoking In and Out'=>'No',
			'None/ only outside'=>'Yes (Outdoors)','Yes (Can Smoke Inside)'=>'Yes (Indoors & Outdoors)','None (No Smoker)'=>'No',
			'None (student; outside/garden Only)'=>'Yes (Outdoors)','Student; Outside only'=>'Yes (Outdoors)','None (Smoking is not allowed)'=>'No',
			'None (in or out)'=>'No','no smoking outside only'=>'Yes (Outdoors)','no only outside downstairs'=>'Yes (Outdoors)',
			'smoking only outside'=>'Yes (Outdoors)','no only outside'=>'Yes (Outdoors)','outside onlt'=>'Yes (Outdoors)','None (Not allowed)'=>'No',
			'Smoking outside only.'=>'Yes (Outdoors)','no smoking only outside'=>'Yes (Outdoors)','None (st; outside only)'=>'Yes (Outdoors)',
			'Occasionally/ Outside only'=>'Yes (Outdoors)','No not even outside'=>'No','Not permitted'=>'No','None (Student; Smoking is not allowed)'=>'No',
			'None smoker/ Not allowed'=>'No','Outside only.'=>'Yes (Outdoors)','None / Student can smoke outside'=>'Yes (Outdoors)',
			'Allow smoking.'=>'Yes (Indoors & Outdoors)','None/Outside only'=>'Yes (Outdoors)','None (outside only)'=>'Yes (Outdoors)',
			'No smoking.'=>'No','None/ Student ; Outside only.'=>'Yes (Outdoors)','None / Smoking outside only.'=>'Yes (Outdoors)',
			'None/ Smoking outside only.'=>'Yes (Outdoors)','None (student; Outside Only)'=>'Yes (Outdoors)','Yes / Outside Only'=>'Yes (Outdoors)',
			'Allow smoking inside.'=>'Yes (Indoors & Outdoors)','None/ smoke outside only'=>'Yes (Outdoors)','None/ Student; Smoking outside only.'=>'Yes (Outdoors)',
			'Outside only / Smoking ouside only.'=>'Yes (Outdoors)','No smoking or smoking outside.'=>'Yes (Outdoors)',
			'None/ Student ; Smoking outside only.'=>'Yes (Outdoors)','none, student outside only'=>'Yes (Outdoors)',
			'None/ Student smoke outside only'=>'Yes (Outdoors)','smoke outside only'=>'Yes (Outdoors)','none/ if smoke, outside only'=>'Yes (Outdoors)',
			'none/ Student smokes outside only'=>'Yes (Outdoors)','the host is smoker/ outside only'=>'Yes (Outdoors)',
			'none/ student smoke outside'=>'Yes (Outdoors)','Quit smoking'=>'No','none. student outside only'=>'Yes (Outdoors)',
			'None/ Student ; Not Allowed'=>'No','None/ Student;'=>'No','No/ Student; Outside Only'=>'Yes (Outdoors)','None/ Student; Not Allowed'=>'No',
			'None/ Student; Outside'=>'Yes (Outdoors)','Robyn is a social smoker (not much)'=>'Yes (Outdoors)','None / Student outside only'=>'Yes (Outdoors)',
			'David is a moker - outside only'=>'Yes (Outdoors)','None`'=>'','No/ Not allowed'=>'No','None. (No smoking)'=>'No',
			'None (Student: Outside only)'=>'Yes (Outdoors)','see note/ Outside only'=>'Yes (Outdoors)','None (Student: Outside only)'=>'Yes (Outdoors)',
			'only allow to smoke outside'=>'Yes (Outdoors)','No/ Smoking not permited'=>'No','None / Outside'=>'Yes (Outdoors)',
			'None (No smoking)'=>'No','none/ student not allowed to smoke'=>'No','none/ students not allowed to smoke'=>'No',
			'None/ No students allowed to smoke'=>'No','none/ students-outside only'=>'Yes (Outdoors)','none/ no'=>'No','no/none'=>'No','None / No'=>'No',
			'Christine smoke outside'=>'Yes (Outdoors)','No / No'=>'No','yes, outside'=>'Yes (Outdoors)','No/ Outside only'=>'Yes (Outdoors)',
			'No/Outside Only'=>'Yes (Outdoors)','No/ Outsid only'=>'Yes (Outdoors)','No/ No'=>'No','No / Outside'=>'Yes (Outdoors)','No /No'=>'No','None /No'=>'No',
			'Not mentioned / Outside only'=>'Yes (Outdoors)','None /Outside only'=>'Yes (Outdoors)','No / Outside only'=>'Yes (Outdoors)',
			'No / No or Outside only'=>'Yes (Outdoors)','Yes/Outside only'=>'Yes (Outdoors)','Yes/ No or Outside only'=>'Yes (Outdoors)',
			'Yes / Yes or Outside Only'=>'Yes (Outdoors)','None / Student; Non Smoker please'=>'No','See note'=>'','None/ St; Outside Only'=>'Yes (Outdoors)',
			'if smoking, outside only'=>'Yes (Outdoors)','allow smoking outside only'=>'Yes (Outdoors)','None/ Strictly not allowed'=>'No',
			'none/ student ouside only'=>'Yes (Outdoors)','student smoke outside only'=>'Yes (Outdoors)','outdoors only'=>'Yes (Outdoors)',
			'student no smoking in bedroom'=>'Yes (Outdoors)','student outside only'=>'Yes (Outdoors)','Yes / Either'=>'Yes (Indoors & Outdoors)',
			'occasionally'=>'Yes (Outdoors)','homestay allows smoking in the house'=>'Yes (Indoors & Outdoors)','Yes, Outside only'=>'Yes (Outdoors)',
			'None/ Strictly not accept a smoker in/out'=>'No','Yes, outside only (husband smokes outside sometime'=>'Yes (Outdoors)','Nonw'=>'',
			'none/ somking outside only'=>'Yes (Outdoors)','Outside Only (husband)'=>'Yes (Outdoors)','Yes, but smoke outside only'=>'Yes (Outdoors)',
			'Yes, son smokes outside'=>'Yes (Outdoors)','None/ Student; Strictly not permitted'=>'No','None / Student ; Smoke outside'=>'Yes (Outdoors)',
			'None/ Strictly not allowed to smoke'=>'No','adjastable'=>'Yes (Outdoors)','Stephanie is smoker (outside)'=>'Yes (Outdoors)',
			'None/ Student is not allowed to smoke'=>'No','NA/ Outside Only'=>'Yes (Outdoors)','None/ None'=>'','yes/ Outsdie only'=>'Yes (Outdoors)',
			'none (Calburn smokes outside only)'=>'Yes (Outdoors)','he smokes occassionally outside'=>'Yes (Outdoors)',
			'Yes / Can smoke inside'=>'Yes (Indoors & Outdoors)','None . Not Allowed'=>'No','None ( student; Outside Only)'=>'Yes (Outdoors)',
			'None / Not Allowed at all'=>'No','None / Not allowed'=>'No',"Don't place smoker to this HS"=>'No','No / None'=>'No','None (socially)'=>'No',
			'None / Not allowed'=>'No','smoker (outside only)'=>'Yes (Outdoors)','But smoking is allow outside only'=>'Yes (Outdoors)',
			'allow outside only'=>'Yes (Outdoors)','but outside only'=>'Yes (Outdoors)','None/student outside only'=>'Yes (Outdoors)',
			'None/ students (outside only)'=>'Yes (Outdoors)','None/ students outside only'=>'Yes (Outdoors)','yes, inside'=>'Yes (Indoors & Outdoors)',
			'no smoker'=>'No','None/Students outside only'=>'Yes (Outdoors)',
			'no/students outside only'=>'Yes (Outdoors)','smokers in the house/students outside only'=>'Yes (Outdoors)',
			'None / student (outside only)'=>'Yes (Outdoors)','None / No smoker in or out'=>'No','None/ Outside'=>'Yes (Outdoors)','ouitside only'=>'Yes (Outdoors)',
			'no smokers at home'=>'No','Yes but outside only'=>'Yes (Outdoors)','Outside Only/ Not allowed to smoke inside'=>'Yes (Outdoors)',
			'Host Mother (occasionally outside only)'=>'Yes (Outdoors)','Outsiode only'=>'Yes (Outdoors)','Outsie only'=>'Yes (Outdoors)','none at all'=>'No',
			'Outside Only - there are other smokers in house'=>'Yes (Outdoors)','None/ (outside only)'=>'Yes (Outdoors)','David smoke only outside'=>'Yes (Outdoors)',
			'Yes, Outside Only/ Student Outside only'=>'Yes (Outdoors)','outside only/ william smoke outside'=>'Yes (Outdoors)','None, only outside'=>'Yes (Outdoors)',
			'Ian smoke, smoke only outside'=>'Yes (Outdoors)','only outside, Kathryn smoke - outside'=>'Yes (Outdoors)','yes, outside (in the garage)'=>'Yes (Outdoors)',
			'none/ student is not allowed'=>'No','Chela is a smoker but outside only'=>'Yes (Outdoors)','yes, outside (husband)'=>'Yes (Outdoors)',
			'yes (David smokes outside)'=>'Yes (Outdoors)','None/ Not permitted'=>'No','yes (son, outside)'=>'Yes (Outdoors)','None/ Outisde Only'=>'Yes (Outdoors)',
			'nonce/ Outside only'=>'Yes (Outdoors)','no smokers in the house. Std only outside.'=>'Yes (Outdoors)','no, but std can smoke outside'=>'Yes (Outdoors)',
			'none/student; outside only'=>'Yes (Outdoors)','Non smokers please'=>'No','Ouside only'=>'Yes (Outdoors)','Non smokers'=>'No',
			'no smokers in the house, outside only'=>'Yes (Outdoors)','/Outside Only (see note)'=>'Yes (Outdoors)','Only outside (Husband)'=>'Yes (Outdoors)',
			'none smokers'=>'No','allow smokers, outside'=>'Yes (Outdoors)','None/ Outside only.'=>'Yes (Outdoors)',"none, doesn't allow smokers in the house"=>'No',
			'none / allows smokers in the house'=>'Yes (Indoors & Outdoors)',"None / Doesn't allow smoking"=>'No','none / Allows smokers outside'=>'Yes (Outdoors)',
			'None / Does no t alllow smoking in the house'=>'No','none/ allow smokers outside only'=>'Yes (Outdoors)',
			'none/ does not allow smokers in the house'=>'Yes (Outdoors)','None / Allow smokers outside only'=>'Yes (Outdoors)',
			'None/ Allows smokers in the house outside only'=>'Yes (Outdoors)','None / Does not allow smoking in the house'=>'Yes (Outdoors)',
			'None / Does not allow smoking in the house'=>'Yes (Outdoors)','None / Allows smoking outside only'=>'Yes (Outdoors)',
			'Yes / Allows smoking outside only'=>'Yes (Outdoors)','None/ Allows smoking outside only'=>'Yes (Outdoors)',
			'none (social smoker host father, outside the house'=>'Yes (Outdoors)','yes (outside)'=>'Yes (Outdoors)',
			'yes (occasionally/ outside only)'=>'Yes (Outdoors)','yes, outside only (Host Mother)'=>'Yes (Outdoors)',
			'Allows smokers in the house'=>'Yes (Indoors & Outdoors)','None / Does not allow smoking'=>'No','None - Outside only.'=>'Yes (Outdoors)',
			'None - outside only'=>'Yes (Outdoors)','None / Student; Outside Only'=>'Yes (Outdoors)','No/ Not available'=>'No',
			'none, outside only.'=>'Yes (Outdoors)','Strictly no smoking permitted'=>'No',
			'yes (both parents, outside)'=>'Yes (Outdoors)','yes (Host, outside only)'=>'Yes (Outdoors)','yes, partner is a social smoker'=>'Yes (Outdoors)',
			'Yes (host father outside only)'=>'Yes (Outdoors)','not allow'=>'No','No. Outside only.'=>'Yes (Outdoors)','yes (Host Mother) only outside'=>'Yes (Outdoors)',
			'None/ Note'=>'No','none/ not allowed to smoke'=>'No','none/ see note'=>'No','Yes, host father smokes outside'=>'Yes (Outdoors)','hone'=>'',
			'yes (Host Mother)'=>'Yes (Indoors & Outdoors)','None (students can smoke outside)'=>'Yes (Outdoors)','Students can smoke only outside'=>'Yes (Outdoors)',
			'nones'=>'','Sabrina is a social smoker'=>'Yes (Outdoors)','None/ not allowed'=>'No','None smoker/ Outside only'=>'Yes (Outdoors)',
			'None/No smoking at home'=>'No','Allow'=>'Yes (Indoors & Outdoors)','Yes Outside only/ Allowed to smoke outside only'=>'Yes (Outdoors)',
			'none (outside only'=>'Yes (Outdoors)','None/ Student: Outside only'=>'Yes (Outdoors)','None ( outside only)'=>'Yes (Outdoors)',
			'none (outside only )'=>'Yes (Outdoors)','out side only'=>'Yes (Outdoors)','Non smoking house'=>'No','(Smokers allowed outside only)'=>'Yes (Outdoors)',
			'non'=>'','none (out side only )'=>'Yes (Outdoors)','None/ Strictly not allowed to smoke inside'=>'Yes (Outdoors)','no smoker at home'=>'No',
			'no smoker at homestay'=>'No','noe'=>'','Smoker (outside) outside only'=>'Yes (Outdoors)','yes (outside only )'=>'Yes (Outdoors)',
			'none ( outside only )'=>'Yes (Outdoors)','none (ouside only)'=>'Yes (Outdoors)','(outside only)'=>'Yes (Outdoors)','none(outside only)'=>'Yes (Outdoors)',
			'none (outside )'=>'Yes (Outdoors)','No smokers allowed anywhere.'=>'No','No smokers allowed'=>'No','none (smokers not allowed)'=>'No',
			'None, no smoking allowed'=>'No','Non smoking environment'=>'No','Smoking, smokers outside only'=>'Yes (Outdoors)',
			'Smoking out side only'=>'Yes (Outdoors)','Strictly no smoking'=>'No','Non smoking enviroment'=>'No','None/ No smokers permitted in the home'=>'No',
			'Smoking not permitted'=>'No','Yes/Somking allowed indoors'=>'Yes (Indoors & Outdoors)','None/Non-smoking environment'=>'No',
			'Non-smoker/Non-smoking environment'=>'No','None/Smoking not permitted'=>'No','None/ No smoking permitted'=>'No','No smoking permitted'=>'No');
			
			if(!isset($smokeRandom[$smoke]))
				return '';
			return $this->getSmokePref($smokeRandom[$smoke]);
	}
	
	function getSmokePref($smoke)
	{
			$allow_smoker='';
			if($smoke=='No')
				$allow_smoker='0';	
			elseif($smoke=='Yes (Outdoor)' || $smoke=='Yes (Outdoors)')
				$allow_smoker='1';	
			elseif($smoke=='Yes (Indoor & Outdoor)' || $smoke=='Yes (Indoors & Outdoors)')
				$allow_smoker='2';
			return $allow_smoker;	
	}

	function csvHostsNotes()
	{
		//$file = './csvfile/hosts3-members.xlsx';
		$file = './csvfile/hostsLastStep.xlsx';
		
		$formOne=$this->readCsv($file);	
		//see($formOne);die();
		
		$hosts=array();
		foreach($formOne['values'] as $valk=>$val)
		{
			if(!isset($val['I']))
				$val['I']='';
			if(!isset($val['H']))
				$val['H']='';
				
			$host=array();
			$host['salesForceId_host']=$val['A'];
			$host['family_notes']=$val['H'];
			$host['internal_notes']=$val['I'];
			
			$hosts[]=$host;
		}
		
		//see($hosts);
		//$this->zimport_model->csvHostsNotes($hosts);
	    echo "done";
	} 
	
	function csvHostsVipRooms()
	{
		//$file = './csvfile/hosts3-members.xlsx';
		$file = './csvfile/hostsLastStep-vip.xlsx';
		
		$formOne=$this->readCsv($file);	
		//see($formOne);die();
		
		$hosts=$formOne['values'];
		//see($hosts);
		//$this->zimport_model->csvHostsVipRooms($hosts);
	    echo "done";
	} 
	
	
		function csvHostsStatus($part)
	{
		$saveTimeZone = date_default_timezone_get();
		date_default_timezone_set('UTC');


		//$file = './csvfile/hosts3-members.xlsx';
		//$file = './csvfile/hostsLastStep.xlsx';
		$file = './csvfile/hostsLastStep - '.$part.'.xlsx';
		
		$formOne=$this->readCsv($file);	
		//see($formOne);die();
		
		$hosts=array();
		foreach($formOne['values'] as $valk=>$val)
		{
			if(!isset($val['I']))
				$val['I']='';
			if(!isset($val['H']))
				$val['H']='';
			if(!isset($val['F']))
				$val['F']='';
			if(!isset($val['A']))
				$val['A']='';
			if(!isset($val['C']))
				$val['C']='';
			if(!isset($val['E']))
				$val['E']='';
			if(!isset($val['B']))
				$val['B']='';
			if(!isset($val['D']))
				$val['D']='';
				
			$host=array();
			$host['salesForceId_host']=$val['A'];
			
			
			$created_date = PHPExcel_Shared_Date::ExcelToPHP( $val['B'] );
			$host['date_created']=date('Y-m-d H:i:s', $created_date);

			$modified_date = PHPExcel_Shared_Date::ExcelToPHP( $val['C'] );
			$host['date_modified']=date('Y-m-d H:i:s', $modified_date);

			$host['visit_date']=$host['reason_other']=$host['reason']='';
			
			if($val['D']=='Approved')
				$host['status']='approved';
			elseif($val['D']=='Confirmed')	
			{
				$host['status']='confirmed';
				$host['visit_date']=$host['date_modified'];
			}
			elseif($val['D']=='Pending Approval')	
				$host['status']='pending_approval';
			elseif($val['D']=='Far away')
			{
				$host['status']='do_not_use';
				$host['reason']='distance';
			}
			else
			{
				$host['status']='new';
				$host['date_modified']='';
			}
			
			if($val['E']=='1')
			{
				$host['status']='do_not_use';
				$host['reason']='other';
				$host['reason_other']=$val['F'];
			}
			
			$hosts[]=$host;
		}
		
		//see($hosts);
		//$this->zimport_model->csvHostsStatus($hosts);
	    echo "done";
		date_default_timezone_set($saveTimeZone);
	}
	
	function csvStudentsContactId($part)
	{
		$file = './csvfile/StudentsContactId - '.$part.'.xlsx';
		$formOne=$this->readCsv($file);	
		//see($formOne);die();
		
		$hosts=array();
		foreach($formOne['values'] as $valk=>$val)
		{
			$host['salesForceId']=$val['A'];
			$host['PersonContactId']=$val['B'];
			
			$hosts[]=$host;
		}
		
		see($hosts);
		//$this->zimport_model->csvStudentsContactId($hosts);
	    echo "done";
	}
	
	function csvStudents($part)
	{
		$saveTimeZone = date_default_timezone_get();
		date_default_timezone_set('UTC');
		
		//$file = './csvfile/students1 - '.$part.'.xlsx';
		$file = './csvfile/stu -1'.$part.'.xlsx';
		
		$formOne=$this->readCsv($file);	
		//see($formOne);die();
		
		$hosts=array();
		foreach($formOne['values'] as $valk=>$val)
		{
			if(!isset($val['I']))
				$val['I']='';
			if(!isset($val['B']))
				$val['B']='';
			if(!isset($val['C']))
				$val['C']='';
				
			$host=array();
			$host['salesForceId']=$val['A'];
			if($val['B']=='Mr.')
				$host['title']='1';
			elseif($val['B']=='Mrs.')
				$host['title']='2';
			elseif($val['B']=='Ms.')
				$host['title']='3';
			elseif($val['B']=='Master')
				$host['title']='4';
			elseif($val['B']=='Dr.')
				$host['title']='5';
			else
				$host['title']='';
			
			$host['fname']=$val['C'];
			$host['lname']=$val['D'];
			
			if(trim($val['E'])=='Male' || trim($val['E'])=='M')
				$host['gender']='1';	
			elseif(trim($val['E'])=='Female' || trim($val['E'])=='F')
				$host['gender']='2';
			else
			{
				if($host['title']!='' && ($host['title']=='1' || $host['title']=='4'))
					$host['gender']='1';
				elseif($host['title']!='' && ($host['title']=='2' || $host['title']=='3'))
					$host['gender']='2';
				else
					$host['gender']='1';
			}		
			
			if($val['F']!='0')
			{
				$birth = PHPExcel_Shared_Date::ExcelToPHP( $val['F'] );
				$host['dob']=date('Y-m-d', $birth);
				if($host['dob']=='1905-03-13')
					$host['dob']='1970-01-01';
			}
			else
				$host['dob']='1970-01-01';
				
			$host['email']=$val['G'];
			if($host['email']=='')
				$host['email']='no-reply@globalexperience.com.au';
			
/*			$phone=$this->getPhone(trim($val['H']));
			if($phone=='')
				$phone=$this->getPhone(trim($val['I']));
			if($phone=='')
				$phone=$this->getPhone(trim($val['J']));	
			if($phone=='')
				$phone='0000000000';	
			$host['mobile']=$phone;*/
			
			$phone=$this->getPhone(trim($val['O']));
			if($phone=='')
				$phone=$this->getPhone(trim($val['P']));
			if($phone=='')
				$phone='0000000000';	
			$host['mobile']=$phone;
			
			
			$host['accType']='1';
			$host['nation']=$this->getStudentCountry($val['L']);
			$host['passport_no']=$val['M'];
			if($host['passport_no']=='0')
				$host['passport_no']='';
			if($val['N']!='0')
			{
				$passport_date = PHPExcel_Shared_Date::ExcelToPHP( $val['N'] );
				$host['passport_expiry']=date('Y-m-d', $passport_date);
			}
			else
				$host['passport_expiry']='0000-00-00';
			$hosts[]=$host;
		}
		
		see($hosts);
		//$this->zimport_model->csvStudents($hosts);
	    echo "done";
		
		date_default_timezone_set($saveTimeZone);
	}

	function getStudentCountry($c)
	{
		$country=array(
			'Chinese'=>'Chinese',
			'German'=>'German',
			'Vietnamese'=>'Vietnamese',
			'French'=>'French',
			'Taiwanese'=>'Taiwanese',
			'Japanese'=>'Japanese',
			'Belgian'=>'Belgian',
			'Korean'=>'Korean',
			'Swiss'=>'Swiss',
			'Colombian'=>'Colombian',
			'Brazilian'=>'Brazilian',
			'Turkish'=>'Turkish',
			'Saudi, Saudi Arabian'=>'Saudi, Saudi Arabian',
			'Australian'=>'Australian',
			'Italian'=>'Italian',
			'Czech'=>'Czech',
			'Thai'=>'Thai',
			'Indonesian'=>'Indonesian',
			'Argentine'=>'Argentine',
			'Irish'=>'Irish',
			'American'=>'American',
			'Chinese (Hong Kong)'=>'Chinese',
			'Japan'=>'Japanese',
			'Dutch'=>'Dutch',
			'Ecuadorian'=>'Ecuadorian',
			'Republic of Korea'=>'Korean',
			'Lao'=>'Lao',
			'China'=>'Chinese',
			'Argentina'=>'Argentine',
			'Indonesia'=>'Indonesian',
			'Malaysian'=>'Malaysian',
			'Bolivian'=>'Bolivian',
			'Mongolian'=>'Mongolian',
			'Spanish'=>'Spanish',
			'Cambodian'=>'Cambodian',
			'Bangladeshi'=>'Bangladeshi',
			'Norwegian'=>'Norwegian',
			'Indian'=>'Indian',
			'Chilean'=>'Chilean',
			'Peruvian'=>'Peruvian',
			'Pakistani'=>'Pakistani',
			'Singaporean'=>'Singaporean',
			'Russian'=>'Russian',
			'Mexican'=>'Mexican',
			'Germany'=>'German',
			'Colombia'=>'Colombian',
			'Russia'=>'Russian',
			'Taiwan'=>'Taiwanese',
			'Tailand'=>'Thai',
			'Italy'=>'Italian',
			'Hong Kong'=>'Chinese',
			'Portugal'=>'Portuguese',
			'Korea'=>'Korean',
			'Turkey'=>'Turkish',
			'Vietnam'=>'Vietnamese',
			'Brazil'=>'Brazilian',
			'Vit Nam'=>'Vietnamese',
			'China/ Alan SmithPrg'=>'Chinese',
			'Viet Nam'=>'Vietnamese',
			'Saudi Arabia'=>'Saudi, Saudi Arabian',
			'Iran'=>'Iranian',
			'Kuwait'=>'Kuwaiti',
			'Frence'=>'French',
			'France'=>'French',
			'Macedonia'=>'Macedonian',

			'Switzerland'=>'Swiss',
			'Myanmar'=>'Myanmarese',
			'Mongolia'=>'Mongolian',
			'Saudi'=>'Saudi, Saudi Arabian',
			'German/ Brazil'=>'German',
			'Thailand'=>'Thai',
			'UAE'=>'Emirati',
			'Italia'=>'Italian',
			'Belgium'=>'Belgian',
			'Nepal'=>'Nepalese',
			'Columbia'=>'Colombian',
			'Ukraine'=>'Ukranian',
			'Mexico'=>'Mexican',
			'Columbian'=>'Colombian',
			'Polish'=>'Polish',
			'Sweden'=>'Swedish',
			'Spain'=>'Spanish',
			'United States'=>'American',
			'South Korea'=>'Korean',
			'Chile'=>'Chilean',
			'Hong Kong, China'=>'Chinese',
			'Dubai'=>'Emirati',
			'Mauritian'=>'Mauritian',
			'Swedish'=>'Swedish',
			'Ecuador'=>'Ecuadorian',
			'United States of Ame'=>'Emirati',
			'Poland'=>'Polish',
			'HKSAR, China'=>'Chinese',
			'New Caledonian'=>'Caledonian',
			'Begium'=>'Belgian',
			'Franch'=>'French',
			'China/Hong Kong'=>'Chinese',
			'India'=>'Indian',
			'Australia'=>'Australian',
			'Malaysia'=>'Malaysian',
			'Colombia (Brazil)'=>'Colombian',
			'Kenyan'=>'Kenyan',
			'Iranian'=>'Iranian',
			'Kazakhstan'=>'Kazakh',
			'Uzhekistan'=>'Uzbek',
			'Rusia'=>'Russian',
			'Bangladesh'=>'Bangladeshi',
			'Uzbekistan'=>'Uzbek',
			'Taksim ,Istanbul'=>'Turkish',
			'Macau'=>'Portuguese',
			'Singapore'=>'Singaporean',
			'SaudiArabia'=>'Saudi, Saudi Arabian',
			'Slovakia'=>'Slovak',
			'Slovak'=>'Slovak',
			'Belarus'=>'Belarusian',
			'Swiss/ Age 19'=>'Swiss',
			'United Kingdom'=>'British',
			'Peru'=>'Peruvian',
			'Portugal/ Macau'=>'Portuguese',
			'Oman'=>'Omani',
			'Kazakh'=>'Kazakh',
			'US'=>'American',
			'UK'=>'British',
			'Austria'=>'Austrian',
			'Latvia'=>'Latvian',
			'HongKong SAR'=>'Chinese',
			'HongKong'=>'Chinese',
			'Netherlands'=>'Dutch',
			'Vitnam'=>'Vietnamese',
			'Macau Sar'=>'Portuguese',
			'HK'=>'Chinese',
			'USA'=>'American',
			'Netherland'=>'Dutch',
			'Saudi Arab'=>'Saudi, Saudi Arabian',
			'United State'=>'American',
			'Myanmar / Burma'=>'Myanmarese',
			'Jordan'=>'Jordanian',
			'Vietnamesse'=>'Vietnamese',
			'Emiratia'=>'Emirati',
			'Czech Republic'=>'Czech',
			'Colonbia'=>'Colombian',
			'Shanghai'=>'Chinese',
			'Argentina/ Smoker'=>'Argentine',
			'Reunion Island'=>'Reunion Islander',
			'Liechtenstein'=>'Liechtensteiner',
			'New Caledonia'=>'Caledonian',
			'Swiss (Swiss German)'=>'Swiss',
			'Zatibia (Russia)'=>'Russian',
			'Turky'=>'Turkish',
			'Argentin'=>'Argentine',
			'Myanmmar'=>'Myanmarese',
			'China/HK'=>'Chinese',
			'United Arab of Emira'=>'Emirati',
			'Kora'=>'Korean',
			'Venezuela'=>'Venezuelan',
			'Chinaq'=>'Chinese',
			'Israel'=>'Israeli',
			'Egypt'=>'Egyptian',
			'Zambia'=>'Zambian',
			'Burma'=>'Burmese',
			'Pakistan'=>'Pakistani',
			'Libya'=>'Libyan',
			'Ukrania'=>'Ukranian',
			'2Turkish'=>'Turkish',
			'Balgium'=>'Belgian',
			'Saudi Arabian'=>'Saudi, Saudi Arabian',
			'France/ New Caredoni'=>'Caledonian',
			'Switzerland/ Japanes'=>'Swiss',
			'China HK'=>'Chinese',
			'Gerrmany'=>'German',
			'Switzerland/ Germany'=>'German',
			'Canada'=>'Canadian',
			'Hungary'=>'Hungarian',
			'Switzerland German'=>'German',
			'Brazil (Japanese Bra'=>'Brazilian',
			'Iraq'=>'Iraqi',
			'Jordania'=>'Jordanian',
			'21 Brazil'=>'Brazilian',
			'18 Brazil'=>'Brazilian',
			'25 Japan'=>'Brazilian',
			'19 Swiss'=>'Swiss',
			'27 Japan'=>'Japanese',
			'16 Brazil'=>'Brazilian',
			'26 Swiss'=>'Swiss',
			'22 Brazil'=>'Brazilian',
			'20 Brazil'=>'Brazilian',
			'32 Brazil'=>'Brazilian',
			'UKR'=>'Ukranian',
			'46 Swiss'=>'Swiss',
			'19 Japan'=>'Japanese',
			'Switzerland (German)'=>'German',
			'Switzerland (German'=>'German',
			'Kuwai'=>'Kuwaiti',
			'17 Brazil'=>'Brazilian',
			'Abu Dhabi'=>'Emirati',
			'21 Japan'=>'Japanese',
			'23 Brazil'=>'Brazilian',
			'35 Brazil'=>'Brazilian',
			'Japan 23'=>'Japanese',
			'Japan 19'=>'Japanese',
			'Canada / Hongkong'=>'Canadian',
			'Switzerland, 32'=>'Swiss',
			'P.R. China'=>'Chinese',
			'Myanmer'=>'Myanmarese',
			'Mxico'=>'Mexican',
			'China/Macau'=>'Chinese',
			'Lebanon'=>'Lebanese',
			'Russina'=>'Russian',
			'Japan (Pfizer Group)'=>'Japanese',
			'Japan (2011 Pfizer G'=>'Japanese',
			'Japan (20)'=>'Japanese',
			'Lithuania'=>'Lithuanian',
			'Beigium'=>'Belgian',
			'Syria'=>'Syrian',
			'Portugal/Hong Kong'=>'Portuguese',
			'Lithuanian'=>'Lithuanian',
			'Blegium'=>'Belgian',
			'Russian Federation'=>'Russian',
			'England'=>'British',
			'Turkish/Swiss (Germa'=>'German',
			'Norway'=>'Norwegian',
			'Japan (29)'=>'Japanese',
			'Japan (27)'=>'Japanese',
			'Denmark'=>'Danish',
			'Netherlands (43)'=>'Dutch',
			'China/ Hong Kong'=>'Chinese',
			'Belgium (native lang'=>'Belgian',
			'Switzerland (French'=>'Swiss',
			'Philippines'=>'Philippine',
			'Ukranian'=>'Ukranian',
			'Equador'=>'Ecuadorian',
			'Swiss (German speake'=>'Swiss',
			'Switzerland 20'=>'Swiss',
			'Swiss/French'=>'Swiss',
			'Chile (DOB 1984)'=>'Chilean',
			'Gemany'=>'German',
			'Cuba'=>'Cubans',
			'Reunion'=>'Reunion Islander',
			'Japanses'=>'Japanese',
			'Persia'=>'Persian',
			'Uzbek'=>'Uzbek',
			'Hong Kong (Pakistani'=>'Chinese',
			'Korea (can speak Jap'=>'Korean',
			'America'=>'American',
			'Equadorian'=>'Ecuadorian',
			'Brazillian'=>'Brazilian',
			'Swiss/German'=>'Swiss',
			'Austrian'=>'Austrian',
			'Japanese Pfizer grou'=>'Japanese',
			'Siwss'=>'Swiss',
			'Braqzil'=>'Brazilian',
			'China/ HK'=>'Chinese',
			'Beigum'=>'Belgian',
			'Beogium'=>'Belgian',
			'Croatia / Swiss'=>'Croatian',
			'China / Shenzhen'=>'Chinese',
			'German (19)'=>'German',
			'Ukrainian'=>'Ukranian',
			'20 Japan'=>'Japanese',
			'Hong Kong/China'=>'Chinese',
			'19 (Japan)'=>'Japanese',
			'Omani'=>'Omani',
			'Bangradeshi'=>'Bangladeshi',
			'Brazilia'=>'Brazilian',
			'Brazi;'=>'Brazilian',
			'Paraguay'=>'Paraguayan',
			'Argentinian'=>'Argentine',
			'Vanuatu'=>'Ni-Vanuatu',
			'Qatari (22 years old'=>'Quatari',
			'Brazil 24'=>'Brazilian',
			'Qatari'=>'Qatari',
			'Japan 15'=>'Japanese',
			'Turkey 40'=>'Turkish',
			'Brazill'=>'Brazilian',
			'Portugese'=>'Portuguese',
			'Vitenam'=>'Vietnamese',
			'Vitetnam'=>'Vietnamese',
			'South African'=>'South African',
			'Laotian'=>'Lao',
			'Laos'=>'Lao',
			'Canadian'=>'Canadian',
			'Korea 34'=>'Korean',
			'Korea, 52'=>'Korean',
			'China 32'=>'Chinese',
			'China 10'=>'Chinese',
			'China (Hong Kong)'=>'Chinese',
			'China (HK)'=>'Chinese',
			'Czech Repblic'=>'Czech',
			'Beilgium'=>'Belgian',
			'Hong-Kong'=>'Chinese',
			'Czechoslovakia'=>'Czech',
			'Suede'=>'Swedish',
			'Amsterdam'=>'Amsterdammer',
			'Qatar'=>'Quatari',
			'HONG KONG (China)'=>'Chinese',
			'Viet Name'=>'Vietnamese',
			'New Caledonia/ Frenc'=>'Caledonian',
			'Swiss-German'=>'Swiss',
			'Tai Wan'=>'Taiwanese',
			'Bangla Desh'=>'Bangladeshi',
			'China 21'=>'Chinese',
			'China 19'=>'Chinese',
			'China 22'=>'Chinese',
			'China 23'=>'Chinese',
			'Russia 21'=>'Russian',
			'China 20'=>'Chinese',
			'China 24'=>'Chinese',
			'China 25'=>'Chinese',
			'Japan 22'=>'Japanese',
			'Korea 23'=>'Korean',
			'Korea 22'=>'Korean',
			'Korea 19'=>'Korean',
			'Korea 20'=>'Korean',
			'South Korea 22'=>'Korean',
			'Chili'=>'Chilean',
			'Brazil, 32'=>'Brazilian',
			'Brazil 18 year old'=>'Brazilian',
			'Brazil 29'=>'Brazilian',
			'Swiss (German)'=>'Swiss',
			'HK/ Macau'=>'Chinese',
			'Japan - 20'=>'Japanese',
			'Japan - 19'=>'Japanese',
			'Swiss German'=>'Swiss',
			'Swiss - German'=>'Swiss',
			'France/ New Caledoni'=>'French',
			'Egyptian'=>'Egyptian',
			'Swiss Germany'=>'Swiss',
			'Azerbaijan'=>'Azerbaijanis',
			'Albani'=>'Albanian',
			'Emirati'=>'Emirati',
			'Japan 20'=>'Japanese',
			'Japan 18'=>'Japanese',
			'Japanese-Korean'=>'Japanese',
			'China (20s)'=>'Chinese',
			'China (20)'=>'Chinese',
			'Myanma'=>'Myanmarese',
			'Algeri'=>'Algerian',
			'Ukraina'=>'Ukranian',
			'Korean/Japanese'=>'Korean',
			'Mongola'=>'Mongolian',
			'China (speak Japanes'=>'Chinese',
			'Germany (Vietnamese)'=>'German',
			'Swiss French'=>'Swiss',
			'Napal'=>'Nepalese',
			'Bulgarian'=>'Bulgarian',
			'Czezh Republic'=>'Czech',
			'Mozambican'=>'Mozambican',
			'China Age 19'=>'Chinese',
			'Mongo'=>'Mongolian',
			'Belgum'=>'Belgian',
			'Holland'=>'Dutch',
			'Geman'=>'German',
			'Brasil'=>'Brazilian',
			'Swiss Geman'=>'Swiss',
			'Barmala'=>'Burmese',
			'The United States'=>'American',
			'Cambodia (U18)'=>'Cambodian',
			'Britain'=>'British',
			'Ozuomba'=>'Ozumba',
			'Vietnames'=>'Vietnamese',
			'Hong Kong China'=>'Chinese',
			'Mongalia'=>'Mongolian',
			'MACAO'=>'Macanese',
			'Jordanian'=>'Jordanian',
			'United Status of Ame'=>'American',
			'Swiitzerland (German'=>'Swiss',
			'Hong Kong SAR'=>'Chinese',
			'Finland'=>'Finnish',
			'Srilanka'=>'Srilankan',
			'Vietnemese'=>'Vietnamese',
			'Japan - 18'=>'Japanese',
			'Japan - 22'=>'Japanese',
			'Arabic'=>'Arab',
			'Thialand'=>'Thai',
			'Arabia'=>'Arab',
			'Golombia'=>'Colombian',
			'Nepalese'=>'Nepalese',
			'HONG KONG, CHINESE'=>'Chinese',
			'Portuguese / Hong Ko'=>'Portuguese',
			'Switserland'=>'Swiss',
			'Switderland'=>'Swiss',
			'Colombia / Turkey'=>'Colombian',
			'Saudi Arabic'=>'Saudi, Saudi Arabian',
			'South Korean'=>'Korean',
			'Chna'=>'Chinese',
			'Tanzanian'=>'Tanzanian',
			'Nigeria'=>'Nigerian',
			'British'=>'British',
			'Reunion Ireland (Fre'=>'Reunion Islander',
			'Vietname'=>'Vietnamese',
			'Portgal/ from Hong K'=>'Portuguese',
			'British (Hong Kon'=>'British',
			'China ; HK'=>'Chinese',
			'Tanzania'=>'Tanzanian',
			'Hong Kong/ (British)'=>'British',
			'Cambodia'=>'Cambodian',
			'Deatsch'=>'Dutch',
			'Brazilian, from Japa'=>'Brazilian',
			'HK, China'=>'Chinese',
			'Kroea'=>'Korean',
			'Latvian'=>'Latvian',
			'BNO / Hong Kong?'=>'Chinese',
			'Greek'=>'Greek',
			'Switzerland (speak G'=>'Swiss',
			'Macau / China'=>'Chinese',
			'Saudi?'=>'Saudi, Saudi Arabian',
			'Japan 19years old'=>'Japanese',
			'Czech, age 41'=>'Czech',
			'Brazil;'=>'Brazilian',
			'Chinese (HK)'=>'Chinese',
			'Swiss/ German Speake'=>'Swiss',
			'Mongoria'=>'Mongolian',
			'Mynmar'=>'Myanmarese',
			'Malysian'=>'Malaysian',
			'Vietam'=>'Vietnamese',
			'Chiense'=>'Chinese',
			'Chille'=>'Chilean',
			'P.R China'=>'Chinese',
			'Brazilain'=>'Brazilian',
			'Netherlands / US'=>'Dutch',
			'Vietnmese'=>'Vietnamese',
			'HKSAR China'=>'Chinese',
			'French (Reunion Irel'=>'French',
			'Sri Lanka'=>'Srilankan',
			'New Zealand'=>'New zealander',
			'Singapoorean'=>'Singaporean',
			'Tuckey'=>'Turkish',
			'Mexica'=>'Mexican',
			'Vienam'=>'Vietnamese',
			'China (30)'=>'Chinese',
			'Chinese/ Hong Kong?'=>'Chinese',
			'French / New Caledo'=>'French',
			'Brrazil'=>'Brazilian',
			'France?'=>'French',
			'Belgium,'=>'Belgian',
			'CHINA (Macau SAR)'=>'Chinese',
			'Burma/ Myanmar'=>'Burmese',
			'Hungarian'=>'Hungarian',
			'Japan 21'=>'Japanese',
			'Ukraine 17'=>'Ukranian',
			'Portuguese'=>'Portuguese',
			'CHN'=>'Chinese',
			'Nigerian'=>'Nigerian',
			'Chadian'=>'Canadian',
			'Sudanese'=>'Sudanese',
			'Philippine'=>'Philippine',
			'Finnish'=>'Finnish',
			'Namibian'=>'Namibian',
			'Angolan'=>'Angolan',
			'Albanian'=>'Albanian',
			'Danish'=>'Danish',
		);
		
		if(!isset($country[$c]))
			return '';
		else
		{	
			$nationKey=$country[$c];
			return array_search($nationKey,nationList());
		}
	}

	function getPhone($text)
	{
		if($text=='0')
			$phone="";
		elseif(filter_var($text, FILTER_VALIDATE_EMAIL))
		{
        	$phone="";
			if(strchr($text,"@qq.com"))
				$phone=preg_replace('/[^\dxX]/', '', $text);;
		}
    	else 
    	    {
				if (preg_match('#[0-9]#',$text))
					$phone = preg_replace('/[a-zA-Z]/', '', $text);
				else
					$phone="";
			}
		return $phone;
    }
	
	function csvStudents2P1($part)
	{
		$file = './csvfile/students2part1 - '.$part.'.xlsx';
		$formOne=$this->readCsv($file);	
		//see($formOne);die();
		
		$hosts=array();
		foreach($formOne['values'] as $valk=>$val)
		{
			$host=array();
			
			$host['salesForceId']=$val['A'];
			if($val['B']=='0' || $val['B']=='1' || $val['B']=='1 language')
				$host['languages']='1';
			elseif($val['B']=='2' || $val['B']=='2 languages')
				$host['languages']='2';
			elseif($val['B']=='3 languages')
				$host['languages']='3';
			elseif($val['B']=='4 languages')
				$host['languages']='4';
			elseif($val['B']=='5 languages')
				$host['languages']='5';

			if($val['B']=='0')
				$lang1=$this->getStudentLangInfo('0','0');
			else
				$lang1=$this->getStudentLangInfo($val['C'],$val['H']);	
				
			$host['language1']=$lang1['lang'];
			$host['languageProf1']=$lang1['prof'];
			
			if($host['languages']>1)
			{
				$lang2=$this->getStudentLangInfo($val['D'],$val['I']);
				$host['language2']=$lang2['lang'];
				$host['languageProf2']=$lang2['prof'];
			}
			
			if($host['languages']>2)
			{
				$lang3=$this->getStudentLangInfo($val['E'],$val['J']);
				$host['language3']=$lang3['lang'];
				$host['languageProf3']=$lang3['prof'];
			}
			
			if($host['languages']>3)
			{
				$lang4=$this->getStudentLangInfo($val['F'],$val['K']);
				$host['language4']=$lang4['lang'];
				$host['languageProf4']=$lang4['prof'];
			}
			
			if($host['languages']>4)
			{
				$lang5=$this->getStudentLangInfo($val['G'],$val['L']);
				$host['language5']=$lang5['lang'];
				$host['languageProf5']=$lang5['prof'];
			}
			
			$ethnicity=trim($val['M']);
			if($ethnicity=='Chinese (Hong Kong)')
				$ethnicity='Chinese';
			elseif($ethnicity=='Filipino')	
				$ethnicity='Philippine';
			elseif($ethnicity=='Other')
			{
				$ethnicity=trim($val['N']);
				if($ethnicity=='Nepali')	
					$ethnicity='Nepalese';
				elseif($ethnicity=='Sri Lankan')	
					$ethnicity='Srilankan';
				elseif($ethnicity=='Bahraini')	
					$ethnicity='CheckNationality';
			}
	
			if($ethnicity=='0' || $ethnicity=='CheckNationality')	
				$host['ethnicity']='CheckNationality';
			else	
				$host['ethnicity']=array_search($ethnicity,nationList());
			
			$religion=trim($val['O']);
			if($religion=='Other')
				$religion=trim($val['P']);
				
			$studentReligion=$this->getStudentReligionInfo($religion);
			$host['religion']=$studentReligion['rel'];
			$host['religion_other']=$studentReligion['rel_other'];
			
			$hosts[]=$host;
		}
		
		see($hosts);
		//$this->zimport_model->csvStudents2P1($hosts);
	    echo "done";
	}
	
	function getStudentLangInfo($lang,$prof)
	{
		if($lang=='0')
		{	
			$lang='Other';
			$prof='Native';
		}
		
		if($prof=='Advanced')
			$prof='Advance';
			
		$stu['lang']=array_search($lang,languageList());
		$stu['prof']=array_search($prof,languagePrificiencyList());
		return $stu;
	}
	
	function getStudentReligionInfo($rel)
	{
			if($rel=='Muslim' || $rel=='Moslem' || $rel=='Eslam')
				$religion='Islam';
			elseif($rel=='Budditist' || $rel=='buddhist' || $rel=='Buddha' || $rel=='Buddish' || $rel=='Buddism')
				$religion='Buddhism';
			//elseif(in_array($rel,array('Catholic','christian','Catholicism','Christian, Roman Catholic','Christ','chritian','protestan','Protestant','Anglican','Roman Catholic','Evangelican')))
			elseif(in_array($rel,array('Catholic','Agnostic','christian','Catholicism','Christian, Roman Catholic','Christ','chritian','protestan','Protestant','Anglican','Roman Catholic','Evangelican')))
				$religion='Christianity';
			elseif($rel=='Hindu' || $rel=='Jain')
				$religion='Hinduism';
			elseif($rel=='Mus')
				$religion=$rel;
			elseif(in_array($rel,array('zz','Allergic to cats and dust','Allergic to house dust.','No religion','no','N/A','Do not have any region','None','Na','not applicable','0')))
				$religion='';
			else
				$religion=$rel;
				
			$religionStudent['rel_other']='';
			if(in_array($religion,array('Taoism','Hillsong','Tenrikyo','Judaism','Sikh','Mus','I believe in God, but I do not belong in any religion','non-religious, searching','FREE THINKER','free thinker')))
			{
				$religionStudent['rel']='0';
				$religionStudent['rel_other']=$religion;
			}
			else
			{
				$res=array_search($religion,religionList());
				if($res)
					$religionStudent['rel']=$res;
				else	
					$religionStudent['rel']='';
			}
			
				
			return 	$religionStudent;
	}
	
	function csvStudents2P2($part)
	{
		$file = './csvfile/students2part2 - '.$part.'.xlsx';
		$formOne=$this->readCsv($file);	
		//see($formOne);die();
		
		$hosts=array();
		foreach($formOne['values'] as $valk=>$val)
		{
			$host=array();
			
			if(!isset($val['C']))
				$val['C']='';
			if(!isset($val['D']))
				$val['D']='';
				if(!isset($val['E']))
				$val['E']='';
			
			for($x='A';$x<='J';$x++)
				$val[$x]=trim($val[$x]);
				
			if($val['I']=='0')
				$val['I']='';
			if($val['J']=='0')
				$val['J']='';
				
			$host['salesForceId']=$val['A'];
			
			$host['live_with_pets']='0';
			$host['live_with_pets_inside']='';
			$host['pet_other_val']=$host['pet_other']=$host['pet_cat']=$host['pet_bird']=$host['pet_dog']='';
			if(in_array($val['B'],array('Yes','TRUE','Y','1')))
			{
				$host['live_with_pets']='1';
				
				if($val['C']!='0' && $val['C']!='')
				{
					$petsArray=explode(';',$val['C']);
					if(in_array('Dog',$petsArray))
						$host['pet_dog']='1';
					if(in_array('Bird',$petsArray))
						$host['pet_bird']='1';
					if(in_array('Cat',$petsArray))
						$host['pet_cat']='1';
					if(in_array('Other',$petsArray))
					{
						$host['pet_other']='1';
						if($val['D']!='0' && $val['D']!='')
							$host['pet_other_val']=$val['D'];
					}
				}
				
				if($val['E']=='Indoors & Outdoors' || $val['E']=='Indoors')
					$host['live_with_pets_inside']='1';
				elseif($val['E']=='Outdoors')	
					$host['live_with_pets_inside']='0';
			}
			
			$host['travel_insurance']='0';
			if($val['F']=='Yes')
				$host['travel_insurance']='1';
			
			$host['apu']='0';
			
			$host['in_homestay_in_past']='';
			$host['in_homestay_in_past_exp']='';
			if($val['G']=='Yes')
			{
				$host['in_homestay_in_past']='1';
				if($val['H']!='0')	
					$host['in_homestay_in_past_exp']=$val['H'];
			}
			elseif($val['G']=='No')
				$host['in_homestay_in_past']='0';
			
			
			$host['desc_student']=$val['I'];
			$host['desc_family']=$val['J'];
			
			$hosts[]=$host;
		}
		
		see($hosts);
		//$this->zimport_model->csvStudents2P2($hosts);
	    echo "done";
	}
	
	
	function csvStudents3P1($part)
	{
		$file = './csvfile/students3part1 - '.$part.'.xlsx';
		$formOne=$this->readCsv($file);	
		//see($formOne);die();
		
		$hosts=array();
		foreach($formOne['values'] as $valk=>$val)
		{
			$host=array();
			
			if(!isset($val['G']))
				$val['G']='';
			if(!isset($val['E']))
				$val['E']='';
			if(!isset($val['F']))
				$val['F']='';
			if(!isset($val['J']))
				$val['J']='';			
				
			for($x='A';$x<='K';$x++)
				$val[$x]=trim($val[$x]);
				
				
			$host['salesForceId']=$val['A'];
			
			$host['diet_req']='';
			$host['diet_req_other']=$host['diet_req_foodAllergy']=$host['diet_req_noPork']=$host['diet_req_gluten']=$host['diet_req_vegetarian']='0';
			$host['diet_req_other_val']='';
			if($val['B']=='Yes')
			{
				$host['diet_req']='1';
				
				if($val['C']!='0' && $val['C']!='')
				{
					$dietArray=explode(';',$val['C']);
					if(in_array('Vegetarian',$dietArray))
						$host['diet_req_vegetarian']='1';
					if(in_array('Gluten/Lactose Free',$dietArray))
						$host['diet_req_gluten']='1';
					if(in_array('No Pork',$dietArray))
						$host['diet_req_noPork']='1';
					if(in_array('Food Allergies',$dietArray))
						$host['diet_req_foodAllergy']='1';
					if(in_array('Other',$dietArray))
					{
						$host['diet_req_other']='1';
						if($val['D']!='0' && $val['D']!='')
							$host['diet_req_other_val']=$val['D'];
						else
							$host['diet_req_other_val']='No info provided';
					}
					if($val['D']!='0' && $val['D']!='')
					{
						$host['diet_req_other']='1';
						$host['diet_req_other_val']=$val['D'];
					}
				}
			}
			elseif($val['B']=='No')
				$host['diet_req']='0';
			
			$host['allergy']='';
			$host['allergy_other']=$host['allergy_dust']=$host['allergy_peanut']=$host['allergy_gluten']=$host['allergy_lactose']=$host['allergy_asthma']=$host['allergy_hay_fever']='0';
			$host['allergy_other_val']='';
			
			if($val['E']=='Yes')
			{
				$host['allergy']='1';
				
				if($val['F']!='0' && $val['F']!='')
				{
					$allergyArray=explode(';',$val['F']);
					if(in_array('Hay Fever',$allergyArray))
						$host['allergy_hay_fever']='1';
					if(in_array('Asthma',$allergyArray))
						$host['allergy_asthma']='1';
					if(in_array('Lactose Intolerance',$allergyArray))
						$host['allergy_lactose']='1';
					if(in_array('Gluten Intolerance',$allergyArray))
						$host['allergy_gluten']='1';
					if(in_array('Peanut Allergies',$allergyArray))
						$host['allergy_peanut']='1';
					if(in_array('Dust Allergies',$allergyArray))
						$host['allergy_dust']='1';
					if(in_array('Other',$allergyArray))
					{
						$host['allergy_other']='1';
						if($val['G']!='0' && $val['G']!='')
							$host['allergy_other_val']=$val['D'];
						else
							$host['allergy_other_val']='No info provided';
					}
					
					if($val['G']!='0' && $val['G']!='')
					{
						$host['allergy_other']='1';
						$host['allergy_other_val']=$val['G'];
					}
				}
			}
			elseif($val['E']=='No')
				$host['allergy']='0';
			
			$host['smoker']='';
			if(in_array($val['H'],array('No','')))
				$host['smoker']='0';
			elseif(in_array($val['H'],array('Yes (Outside Only)','YES','1','Yes (Outdoors)')))
				$host['smoker']='1';
			elseif(in_array($val['H'],array('Yes (Indoors & Outdoors)','YES','1','Yes (Outdoors)')))
				$host['smoker']='2';
			
			$host['medication_info']=$host['medication']='';
			if($val['I']=='Yes')
			{
				$host['medication']='1';
				if($val['J']!='0' && $val['J']!='')
					$host['medication_info']=$val['J'];
				else
					$host['medication_info']='Medication information unavailable';
			}
			elseif($val['I']=='No')
				$host['medication']='0';
			
			$host['disability_info']=$host['disability']='';
			if($val['K']=='Yes')
			{
				$host['disability']='1';
				$host['disability_info']='Disability details unavailable';
			}
			elseif($val['K']=='No')
				$host['disability']='0';	
				
			$hosts[]=$host;
		}
		
		see($hosts);
		//$this->zimport_model->csvStudents3P1($hosts);
	    echo "done";
	}
	
	
	function csvStudents3P2($part)
	{
		$file = './csvfile/students3part2 - '.$part.'.xlsx';
		$formOne=$this->readCsv($file);	
		//see($formOne);die();
		
		$hosts=array();
		foreach($formOne['values'] as $valk=>$val)
		{
			$host=array();
			
			if(!isset($val['H']))
				$val['H']='';		
				
			for($x='A';$x<='F';$x++)
				$val[$x]=trim($val[$x]);
				
				
			$host['salesForceId']=$val['A'];
			
			$host['children0To11']='';	
			if(in_array($val['B'],array('Yes','Y')))
				$host['children0To11']='1';
			if(in_array($val['B'],array('No','N')))
				$host['children0To11']='0';
			
			$host['children12To20']='';	
			if(in_array($val['C'],array('Yes','Y')))
				$host['children12To20']='1';
			if(in_array($val['C'],array('No','N')))
				$host['children12To20']='0';		
			
			$host['childrenPrefReason']='';
			if($val['D']!='' && $val['D']!='0')
				$host['childrenPrefReason']=$val['D'];
			
			$host['smokerFamily']='';
			if(in_array($val['E'],array('No')))
				$host['smokerFamily']='0';
			elseif(in_array($val['E'],array('Yes','Yes (Outdoors)')))
				$host['smokerFamily']='1';
			elseif(in_array($val['E'],array('Yes (Indoors & Outdoors)')))
				$host['smokerFamily']='2';
			
			$host['family_pref']='';
			if($val['F']!='' && $val['F']!='0')
				$host['family_pref']=$val['F'];	
				
			$hosts[]=$host;
		}
		
		see($hosts);
		//$this->zimport_model->csvStudents3P2($hosts);
	    echo "done";
	}
	
	function csvStudentsMissing()
	{
		$saveTimeZone = date_default_timezone_get();
		date_default_timezone_set('UTC');
		
		$file = './csvfile/student-missing.xlsx';
		$file = './csvfile/student-missing-duplicate.xlsx';
		$formOne=$this->readCsv($file);	
		//see($formOne);die();
		
		$hosts=array();
		foreach($formOne['values'] as $valk=>$val)
		{
			$host=array();
			if(!isset($val['A']))
				continue;
			
			if(!isset($val['C']))
				$val['C']='';
			if(!isset($val['G']))
				$val['G']='';
			if(!isset($val['H']))
				$val['H']='';
			if(!isset($val['I']))
				$val['I']='';
			if(!isset($val['J']))
				$val['J']='';
			if(!isset($val['K']))
				$val['K']='';
			if(!isset($val['L']))
				$val['L']='';
			if(!isset($val['M']))
				$val['M']='';
			if(!isset($val['N']))
				$val['N']='';
			if(!isset($val['O']))
				$val['O']='';
			if(!isset($val['Q']))
				$val['Q']='';
			if(!isset($val['R']))
				$val['R']='';
			if(!isset($val['P']))
				$val['P']='';
			if(!isset($val['F']))
				$val['F']='';
			if(!isset($val['D']))
				$val['D']='';
			if(!isset($val['A']))
				$val['A']='';
			if(!isset($val['B']))
				$val['B']='';
			if(!isset($val['E']))
				$val['E']='';				
				
			for($x='A';$x<='R';$x++)
				$val[$x]=trim($val[$x]);
				
				
			$host['personContactId']=$val['A'];
			
			$accomodationType=$val['B'];
			if($accomodationType=='Homestay Single Room' || $accomodationType=='')
				$accomodationTypeVal='1';
			elseif($accomodationType=='Homestay Twin Share')
				$accomodationTypeVal='2';	
			elseif($accomodationType=='Homestay Self-Catered')
				$accomodationTypeVal='3';	
			elseif($accomodationType=='Homestay VIP Single Room')
				$accomodationTypeVal='4';	
			elseif($accomodationType=='Homestay VIP Self-Catered')
				$accomodationTypeVal='5';	
			
			$secondStudent='';
            if($accomodationTypeVal=='2')
            	$secondStudent=$val['C'];	    	                
                	                
            $host['accomodationType']=$accomodationTypeVal;
			$host['secondStudent']=$secondStudent;
			
			$host['arrival_date']=$host['arrival_time']=$host['arrival_carrier']=$host['arrival_flight_no']='';
			if($val['D']=='No' || $val['D']=='')
				$host['airpirtPickup']='0';
			elseif($val['D']=='Yes')
			{
				$host['airpirtPickup']='1';
				
				$arrival_date = PHPExcel_Shared_Date::ExcelToPHP( $val['E'] );
				$host['arrival_date']=date('Y-m-d', $arrival_date);
				
				$cell_value = PHPExcel_Style_NumberFormat::toFormattedString($val['F'], 'hh:mm:ss');
				$host['arrival_time']=$cell_value;
				$host['arrival_carrier']=$val['G'];
				$host['arrival_flight_no']=$val['H'];
			}
			
			if($val['I']=='No' || $val['I']=='')
				$caregiving='0';
			elseif($val['I']=='Yes')
				$caregiving='1';	
			$host['caregiving']=$caregiving;
			$caregivingDesc=$val['J'];
			if($caregivingDesc=='Other' && $val['K']!='')
			{
				$caregivingDesc .=' - '.$val['K'];
				$host['caregiving']='1';
			}
			$host['caregivingDesc']=$caregivingDesc;
			
			$host['campus']=$val['M'];
			$host['college_name']=$val['O'];
			$host['college_address']=$val['N'];
			
			$ge_reason='';
			if($val['P']=='Study')
				$ge_reason='1';
			$host['ge_reason']=$ge_reason;
			
			$ge_hear_about=$ge_hear_about_other_val='';
			if($val['Q']=='Agent')
				$ge_hear_about='6';
			elseif($val['Q']=='Other')
			{
				$ge_hear_about='7';	
				$ge_hear_about_other_val=$val['R'];
			}
			$host['ge_hear_about']=$ge_hear_about;
			$host['ge_hear_about_other_val']=$ge_hear_about_other_val;
				
			$hosts[]=$host;
		}
		
		see($hosts);
		//$this->zimport_model->csvStudentsMissing($hosts);
	    echo "done";
		date_default_timezone_set($saveTimeZone);
	}
	
	function csvStudentsMissing2nd()
	{
		$file = './csvfile/student-missing.xlsx';
		$file = './csvfile/student-missing-duplicate.xlsx';
		$formOne=$this->readCsv($file);	
		//see($formOne);die();
		
		$hosts=array();
		foreach($formOne['values'] as $valk=>$val)
		{
			$host=array();
			if(!isset($val['A']))
				continue;
			
			if(!isset($val['C']))
				$val['C']='';
			if(!isset($val['G']))
				$val['G']='';
			if(!isset($val['H']))
				$val['H']='';
			if(!isset($val['I']))
				$val['I']='';
			if(!isset($val['J']))
				$val['J']='';
			if(!isset($val['K']))
				$val['K']='';
			if(!isset($val['L']))
				$val['L']='';
			if(!isset($val['M']))
				$val['M']='';
			if(!isset($val['N']))
				$val['N']='';
			if(!isset($val['O']))
				$val['O']='';
			if(!isset($val['Q']))
				$val['Q']='';
			if(!isset($val['R']))
				$val['R']='';
			if(!isset($val['P']))
				$val['P']='';
			if(!isset($val['F']))
				$val['F']='';
			if(!isset($val['D']))
				$val['D']='';
			if(!isset($val['A']))
				$val['A']='';
			if(!isset($val['B']))
				$val['B']='';
			if(!isset($val['E']))
				$val['E']='';				
				
			for($x='A';$x<='R';$x++)
				$val[$x]=trim($val[$x]);
				
				
			$host['personContactId']=$val['A'];
			
			
			
			if($val['I']=='No' || $val['I']=='')
				$caregiving='0';
			elseif($val['I']=='Yes')
				$caregiving='1';	
			$host['caregiving']=$caregiving;
			$caregivingDesc=$val['J'];
			if($caregivingDesc=='Other' && $val['K']!='')
			{
				$caregivingDesc .=' - '.$val['K'];
				$host['caregiving']='1';
			}
			$host['caregivingDesc']=$caregivingDesc;
			
			$caregiverId='';
			if($host['caregiving']=='1')
			{
				if($val['J']=='Global Experience')
					$caregiverId='8';
				elseif($val['J']=='Other')
				{
					if($val['K']=='ISA' || $val['K']=='Caregiver ISA')
						$caregiverId='17';
					elseif($val['K']=='ISA - Yining Chen and her contact number is 0468 824 028.')	
						$caregiverId='20';
					elseif($val['K']=='ISA - Jenny Zhang and her contact number is 0432 495 440.')	
						$caregiverId='18';
					elseif($val['K']=='ISA - Ms. Christine Lee 0405 168 568')	
						$caregiverId='19';
					elseif($val['K']=='Caroline')	
						$caregiverId='28';
					elseif($val['K']=='HS Family' || $val['K']=='Host family')	
						$caregiverId='25';
					elseif($val['K']=='Jojo')	
						$caregiverId='23';
					elseif($val['K']=='Le Le WANG')	
						$caregiverId='21';
					elseif($val['K']=='LLW')	
						$caregiverId='24';
					elseif($val['K']=='PSC')	
						$caregiverId='22';
					elseif($val['K']=='Sonder')	
						$caregiverId='29';
					elseif($val['K']=='Sophie NGUYEN Thi Thuy Dung  0413 721 783')	
						$caregiverId='27';
					elseif($val['K']=='TOM')	
						$caregiverId='26';
					elseif($val['K']=='WLL')	
						$caregiverId='30';
				}
				if($caregiverId=='')
					continue;
				$host['caregiverId']=$caregiverId;
				$arrival_date = PHPExcel_Shared_Date::ExcelToPHP( $val['E'] );
				$host['caregiving_start']=date('Y-m-d', $arrival_date);
			}
			else
				continue;
			
				
			$hosts[]=$host;
		}
		
		see($hosts);
		//$this->zimport_model->csvStudentsMissing2nd($hosts);
	    echo "done";
	}
	
	function csvStudentsStatus()
	{
		$file = './csvfile/Student-status.xlsx';
		$file = './csvfile/Student-status-duplicate.xlsx';
		$formOne=$this->readCsv($file);	
		//see($formOne);die();
		
		$hosts=array();
		foreach($formOne['values'] as $valk=>$val)
		{
			$host=array();
			if(!isset($val['A']))
				continue;
			
			for($x='A';$x<='F';$x++)
			{
				if(!isset($val[$x]))
					$val[$x]='';
				$val[$x]=trim($val[$x]);
			}
			$host['personContactId']=$val['A'];
			
			$booking_from = PHPExcel_Shared_Date::ExcelToPHP( $val['B'] );
			$host['booking_from']=date('Y-m-d', $booking_from);
			
			$booking_from = PHPExcel_Shared_Date::ExcelToPHP( $val['C'] );
			$host['booking_to']=date('Y-m-d', $booking_from);
			
			$host['notes']=$val['D'];
			$host['client_salesForce_id']=$val['E'];
			
			$host['status']='approved_with_payment';
			if($val['F']=='Cancelled')
				$host['status']='cancelled';
				
			$hosts[]=$host;
		}
		
		see($hosts);
		//$this->zimport_model->csvStudentsStatus($hosts);
	    echo "done";
	}
	
	
	
	function csvBookings()
	{
		$file = './csvfile/Bookings-step1.xlsx';
		$file = './csvfile/Bookings-step1-duplicate.xlsx';
		$formOne=$this->readCsv($file);	
		//see($formOne);die();
		
		$hosts=array();
		foreach($formOne['values'] as $valk=>$val)
		{
			$host=array();
			if(!isset($val['P']))
				continue;
			
			for($x='A';$x<='Z';$x++)
			{
				if(!isset($val[$x]))
					$val[$x]='';
				$val[$x]=trim($val[$x]);
			}
			
			$host['salesForceId_booking']=$val['A'];
			$host['salesForce_bookingNo']=$val['B'];
			$host['personContactId']=$val['P'];
			$host['host']=$val['T'];
			
			$booking_from = PHPExcel_Shared_Date::ExcelToPHP( $val['F'] );
			$host['booking_from']=date('Y-m-d', $booking_from);
			
			$booking_from = PHPExcel_Shared_Date::ExcelToPHP( $val['G'] );
			$host['booking_to']=date('Y-m-d', $booking_from);
			
			$host['room']=$val['V'];
			
			$apu='';
			if($val['Z']!='')
			{
				if($val['Z']=='2Stay')
					$apu='1';
				elseif($val['Z']=='Castle Tours')
					$apu='2';
				elseif($val['Z']=='Elite Tennis Academy (in Melbourne)')
					$apu='3';
			}
			$host['apu']=$apu;
			
			$creation_date = PHPExcel_Shared_Date::ExcelToPHP( $val['C'] );
			$host['creation_date']=date('Y-m-d', $creation_date);	
				
			$hosts[]=$host;
		}
		
		see($hosts);
		//$this->zimport_model->csvBookings($hosts);
	    echo "done";
	}
	
	function mobileFormatHfa()
	{
		$hfaList=$this->zimport_model->getHfaPhoneList();
		//see($hfaList);
		
		foreach($hfaList as $hfaK=>$hfa)
		{
			$hfaList[$hfaK]['mobile']=mobileFormat($hfa['mobile']);
			$hfaList[$hfaK]['home_phone']=phoneFormat($hfa['home_phone']);
			$hfaList[$hfaK]['work_phone']=phoneFormat($hfa['work_phone']);
			
			if($hfaList[$hfaK]['mobile']==$hfa['mobile'])
				$hfaList[$hfaK]['mobile_same']='same';
		}
		see($hfaList);
	}
	
	
	
	
	function csvPO($no)
	{
		$file = './csvfile/po-'.$no.'.csv';
		$formOne=$this->readCsv($file);	
		//see($formOne);die();
		
		$hosts=array();
		foreach($formOne['values'] as $valk=>$val)
		{
			$host=array();
			
			for($x='A';$x<='Q';$x++)
			{
				if(!isset($val[$x]))
					$val[$x]='';
				$val[$x]=trim($val[$x]);
			}
			
			$host['salesForceId_booking']=$val['Q'];
			$booking=$this->zimport_model->booking($host['salesForceId_booking']);
			if(!empty($booking))
			{
				$host['booking']=$booking;
				$desc=explode(' ',str_replace('holiday from','',str_replace('Holiday from','',$val['E'])));
				$searchPos=array_search("from",$desc);
				if($searchPos==FALSE || $searchPos==0)
					continue;
				
				$host['desc']=$val['E'];
				$host['sent']=$val['P'];
				$host['amount']=$val['G'];
				$host['from']=$desc[$searchPos+1];
				$host['to']=$desc[$searchPos+3];
				
				$creation_date=explode(' ',$val['D']);
				$host['creation_date']=$this->normalToMysqlDate($creation_date[0]);
				
				if($host['from']=='')
					continue;
			}
			else	
				continue;
				
			$hosts[]=$host;
		}
		
		//see($hosts);
		$pos=array();
		$salesForceId_booking='';
		foreach($hosts as $hK=>$hV)
		{
				if($hK!='0')
				{
					if($hV['salesForceId_booking']==$salesForceId_booking)
					{
						$thisDate=$this->normalToMysqlDate($hV['creation_date']);
						//$prevDate=$this->normalToMysqlDate($hosts[$hK-1]['creation_date']);
						
							end($pos);
							$key = key($pos);
							//$pos[$key]=$hV;
						$prevDate=$this->normalToMysqlDate($pos[$key]['creation_date']);
					
						if(strtotime($thisDate)>strtotime($prevDate))
						{
							end($pos);
							$key = key($pos);
							$pos[$key]=$hV;
						}
					}
					else
						$pos[]=$hV;
				}
				else
					$pos[]=$hV;
				$salesForceId_booking=$hV['salesForceId_booking'];
				
		}
		//see($pos);
		
		//getting pos before 2018
		$po2017=array();
		$po2018=array();
		foreach($pos as $p)
		{
			$poFrom=normalToMysqlDate($p['from']);
			if(date('Y',strtotime($poFrom))!='2018')
			{
				$po2017[]=$this->skippedPoDetails($p);
				/*$po_2017['salesForceId_booking']=$p['salesForceId_booking'];
				$po_2017['from']=$p['from'];
				$po_2017['to']=$p['to'];
				$po2017[]=$po_2017;*/
			}
			else
			{
				if(in_array(date('m',strtotime($poFrom)),array('01','02','03')))
				{
					//$po2018[]=$p;
					if(strtotime($poFrom) >= strtotime($p['booking']['booking_from']) && strtotime($poFrom) < strtotime($p['booking']['booking_to']) )
						$po2018[]=$p;
					else
						$po2017[]=$this->skippedPoDetails($p);
				}
				else
				{
					$po2017[]=$this->skippedPoDetails($p);
					/*$po_2017['salesForceId_booking']=$p['salesForceId_booking'];
					$po_2017['from']=$p['from'];
					$po_2017['to']=$p['to'];
					$po2017[]=$po_2017;*/
				}
			}
		}
		
		//see($po2017);
		//see($po2018);
		
		foreach($po2018 as $p2018K => $p2018)
		{
			$po_structure=$this->poChangeDuration_structure($p2018['booking']['id'],normalToMysqlDate($p2018['from']),normalToMysqlDate($p2018['to']),1);
			$po2018[$p2018K]['po_structure']=$po_structure;
		}
		see($po2018);
		
		//$this->zimport_model->csvPO($po2018);
	    echo "done";
	}
	
	function skippedPoDetails($p)
	{
		$po_2017=array();
		$po_2017['salesForceId_booking']=$p['salesForceId_booking'];
		$po_2017['from']=$p['from'];
		$po_2017['to']=$p['to'];
		return $po_2017;
	}
	
	function normalToMysqlDate($date)
	{
		if($date=='')
			return '0000-00-00';
		
		$date_array=explode('-',$date);
		$mysqlDate=$date_array[2].'-'.$date_array[1].'-'.$date_array[0];
		return $mysqlDate;
	}
	
	
	function poChangeDuration_structure($booking_id,$po_from,$po_to,$nextOngoing=0)
	{
		$bookingDetails=bookingDetails($booking_id);
		//see($bookingDetails);
		
		//Accomodation type
		$accomodation_type=po_structure_accomodationType($bookingDetails);
		
		//Getting the duration of PO
		$po_endDate=$bookingDetails['moveout_date'];	
		if($po_endDate=='0000-00-00')
			$po_endDate=$bookingDetails['booking_to'];
			
		if($po_endDate!='0000-00-00' && strtotime($po_to) > strtotime($po_endDate))	
			$po_to=$po_endDate;
			
		if(strtotime($po_from) == strtotime($po_to))//in case if booking end date ahs arrived and we cannot create next PO
			return array();
		//
		
		$structure=po_structure2ndPart($po_from,$po_to,$accomodation_type,$bookingDetails,$nextOngoing);
		return $structure;
	}
	
	function studentDates()
	{
		
		$file = './csvfile/students_with_dates.csv';
		$formOne=$this->readCsv($file);	
		//see($formOne);die();
		
		$hosts=array();
		foreach($formOne['values'] as $valk=>$val)
		{
			$host=array();
			
			for($x='A';$x<='C';$x++)
			{
				if(!isset($val[$x]))
					$val[$x]='';
				$val[$x]=trim($val[$x]);
			}
			
			$host['salesForceId_booking']=$val['A'];
			//$creation_date = PHPExcel_Shared_Date::ExcelToPHP( $val['C'] );
			//$host['creation_date']=date('Y-m-d', $creation_date);	
			$dateArray=explode(' ',$val['C']);
			$dateNormal=str_replace('-','/',$dateArray[0]);
			$host['creation_date']=normalToMysqlDate($dateNormal);
			
			//$this->zimport_model->studentDates($host);
			//$hosts[]=$host;
		}
		
		
		//see($hosts);
		
	    echo "done";
	
	}
	
	function clientsWithStar()
	{
		
		$file = './csvfile/Clients_with_star_name.xlsx';
		$formOne=$this->readCsv($file);	
		//see($formOne);die();
		
		$hosts=array();
		foreach($formOne['values'] as $valk=>$val)
		{
			$host=array();
			
			for($x='A';$x<='B';$x++)
			{
				if(!isset($val[$x]))
					$val[$x]='';
				$val[$x]=trim($val[$x]);
			}
			
			$host['salesForceId_booking']=$val['A'];
			//$host['name']=$val['B'];
			
			if (strpos($val['B'], '*') !== false)
			{
    			$host['name']=$val['B'];
				//$this->zimport_model->clientsWithStar($host);
			}
			else
				continue;	
				
			
			//$this->zimport_model->studentDates($host);
			//$hosts[]=$host;
		}
		
		
		//see($hosts);
		
	    echo "done";
	
	}
	
	function bookingInSystem()
	{
		
		$file = './csvfile/Bookings-in-system.xls';
		$formOne=$this->readCsv($file);	
		//see($formOne);die();
		
		$hosts=array();
		foreach($formOne['values'] as $valk=>$val)
		{
			$host=array();
			
			for($x='A';$x<='H';$x++)
			{
				if(!isset($val[$x]))
					$val[$x]='';
				$val[$x]=trim($val[$x]);
			}
			
			$host['salesForceId_booking']=$val['A'];
			
			if($val['B']!='')
			{
				$start_date = PHPExcel_Shared_Date::ExcelToPHP( $val['B'] );
				$host['start_date']=date('Y-m-d', $start_date);
			}
			else
				$host['start_date']=$val['B'];
			
			if($val['C']!='')
			{
				$end_date = PHPExcel_Shared_Date::ExcelToPHP( $val['C'] );
				$host['end_date']=date('Y-m-d', $end_date);
			}
			else
				$host['end_date']=$val['C'];
			
			if($val['D']!='')
			{
				$po_start_date = PHPExcel_Shared_Date::ExcelToPHP( $val['D'] );
				$host['po_start_date']=date('Y-m-d', $po_start_date);
			}
			else
				$host['po_start_date']=$val['D'];
			
			if($val['E']!='')
			{
				$po_end_date = PHPExcel_Shared_Date::ExcelToPHP( $val['E'] );
				$host['po_end_date']=date('Y-m-d', $po_end_date);
			}
			else
				$host['po_end_date']=$val['E'];
			
			$host['arrival_date']=$val['F'];
			
			$host['status']=$val['G'];
			$host['notes']=$val['H'];
			
			$hosts[]=$host;
		}
		
		
		see($hosts);
		//$this->zimport_model->bookingInSystem($hosts);
		
	    echo "done";
	
	}
	
	function deleteOldPos()
	{
		//$this->zimport_model->deleteOldPos();
		echo 'done';
	}
	
	
	function bookingInSystemPo()
	{
		$file = './csvfile/Bookings-in-system.xls';
		$formOne=$this->readCsv($file);	
		//see($formOne);die();
		
		$hosts=array();
		foreach($formOne['values'] as $valk=>$val)
		{
			$host=array();
			
			for($x='A';$x<='H';$x++)
			{
				if(!isset($val[$x]))
					$val[$x]='';
				$val[$x]=trim($val[$x]);
			}
			
			$host['salesForceId_booking']=$val['A'];
			
			if($val['B']!='')
			{
				$start_date = PHPExcel_Shared_Date::ExcelToPHP( $val['B'] );
				$host['start_date']=date('Y-m-d', $start_date);
			}
			else
				$host['start_date']=$val['B'];
			
			if($val['C']!='')
			{
				$end_date = PHPExcel_Shared_Date::ExcelToPHP( $val['C'] );
				$host['end_date']=date('Y-m-d', $end_date);
			}
			else
				$host['end_date']=$val['C'];
			
			if($val['D']!='')
			{
				$po_start_date = PHPExcel_Shared_Date::ExcelToPHP( $val['D'] );
				$host['po_start_date']=date('Y-m-d', $po_start_date);
			}
			else
				$host['po_start_date']=$val['D'];
			
			if($val['E']!='')
			{
				$po_end_date = PHPExcel_Shared_Date::ExcelToPHP( $val['E'] );
				$host['po_end_date']=date('Y-m-d', $po_end_date);
			}
			else
				$host['po_end_date']=$val['E'];
			
			$host['arrival_date']=$val['F'];
			
			$host['status']=$val['G'];
			$host['notes']=$val['H'];
			
			$hosts[]=$host;
		}
		
		
		//see($hosts);
		
		foreach($hosts as $hK=>$host)
		{
			if($host['po_start_date']!='')
			{
				$booking=$this->zimport_model->booking($host['salesForceId_booking']);
				
				$po_structure=$this->poChangeDuration_structure($booking['id'],$host['po_start_date'],$host['po_end_date'],1);
				$hosts[$hK]['po_structure']=$po_structure;
			}
		}
		
		see($hosts);
		//$this->zimport_model->bookingInSystemPo($hosts);
		
	    echo "done";
	
	
	}
	
	
	function invoiceName()
	{
		$booking=$this->zimport_model->invoiceName();
	}
	
	function invoiceNameOngoing()
	{
		$booking=$this->zimport_model->invoiceNameOngoing();
	}
	
	
	function bookingImport()
	{
		$file = './csvfile/bookingMissed-13july2018.xlsx';
		$formOne=$this->readCsv($file);	
		see($formOne);die();
		
		/*foreach($formOne['values'] as $o)
		{
			if(isset($o['D']) && $o['D']!='')
			{
			$po_end_date = PHPExcel_Shared_Date::ExcelToPHP( $o['D'] );
			echo date('Y-m-d', $po_end_date).'<br>';
			}
			
			
			$room=str_replace('room ','',trim(strtolower($o['E'])));
			$roomId=$this->zimport_model->getRoomId($o['B'],$room);
			echo $o['B'].' => '.$roomId.' '.$o['F'].'<br>';
		}*/
		//die();
		
		/*$dateFrom[]='06/07/2018';
		$dateFrom[]='13/04/2018';
		$dateFrom[]='07/07/2018';
		$dateFrom[]='12/05/2018';
		$dateFrom[]='12/05/2018';
		$dateFrom[]='10/04/2018';
		$dateFrom[]='07/07/2018';
		$dateFrom[]='08/07/2018';
		$dateFrom[]='19/03/2018';
		$dateFrom[]='11/07/2018';
		$dateFrom[]='16/05/2018';
		$dateFrom[]='17/07/2018';
		
		$dateTo[]='';
		$dateTo[]='24-03-2019';
		$dateTo[]='04-08-2018';
		$dateTo[]='';
		$dateTo[]='25-07-2018';
		$dateTo[]='';
		$dateTo[]='';
		$dateTo[]='05-05-2018';
		$dateTo[]='';
		$dateTo[]='';
		$dateTo[]='';
		$dateTo[]='';
		$dateTo[]='';*/
		 
		$hosts=array();
		$count=0;
		foreach($formOne['values'] as $valk=>$val)
		{
			$host=array();
			
			$host['student']=$val['A'];
			$host['host']=$val['B'];
			
			
			if(isset($val['C']) && $val['C']!='')
			{
				$from = PHPExcel_Shared_Date::ExcelToPHP( $val['C'] );
				$host['from']= date('Y-m-d', $from);
			}
			
			if(isset($val['D']) && $val['D']!='')
			{
				$to = PHPExcel_Shared_Date::ExcelToPHP( $val['D'] );
				$host['to']= date('Y-m-d', $to);
			}
			else
				$host['to']= '0000-00-00';
			
			$host['status']=str_replace(' ','_',strtolower($val['H']));
			
			$room=str_replace('room ','',trim(strtolower($val['E'])));
			$host['room']=$this->zimport_model->getRoomId($val['B'],$room);
			/*$room=str_replace('room ','',strtolower(trim($val'E'])));
			$host['room']=$this->zimport_model->getRoomId($val['B'],$room);*/
			
			
			$hosts[]=$host;
		}
		
		
		see($hosts);die();
		$this->zimport_model->bookingImport11($hosts);
		
		
	    echo "done";
	
	
	}
	
	
	function newOng()
	{
		$file = './csvfile/newOngIni-16july.xlsx';
		$formOne=$this->readCsv($file);	
		//see($formOne);die();
		
		$bookings=array();
		foreach($formOne['values'] as $vK=>$val)
		{
			$booking=array();
			
			/*if($vK<102)
				$col="`salesForce_id`";
			else
				$col="`id`";*/
			//$col="`salesForce_id`";
			$col="`id`";
			$sql="select * from `bookings` where ".$col."='".$val['A']."'";
			$query=$this->db->query($sql);
			$res=$query->row_array();//if($val['A']=='a0u0K00000GJe4OQAT'){echo $this->db->last_query();see($res);}
			
			if(empty($res)){continue;}
			$booking['id']=$res['id'];
			$booking['from']=$res['booking_from'];
			$booking['to']=$res['booking_to'];
			$booking['student']=$res['student'];
			
			$on_start_date = PHPExcel_Shared_Date::ExcelToPHP( $val['D'] );
			$booking['onFrom']=date('Y-m-d', $on_start_date);
			$bookings[]=$booking;
			
			///
			//$getshaOneAppDetails=getshaOneAppDetails($res['student']);
			//$sqlSha="update `sha_one` set `booking_from`='".$res['booking_from']."', `booking_to`='".$res['booking_to']."' where `id`='".$res['student']."'";
			//$this->db->query($sqlSha);
			///
			
		}
		//see($bookings);die();
		/*foreach($bookings as $bK=>$book)
		{
			//if($book['to']!='0000-00-00')
				echo $book['id'].' > '.$book['from'].' - '.$book['to'].'<br>';
		}
		die();*/
		
		foreach($bookings as $bK=>$book)
		{
			$data['shaChangeStatus_id']=$book['student'];
			$data['booking_from']=$book['from'];
			$data['booking_to']=date('Y-m-d',strtotime($book['onFrom'].' -1 day'));
			$data['dates_available']=1;
			$bookings[$bK]['data']=$data;
			$bookings[$bK]['invoice']=$this->zimport_model->updatePendingInvoice11($data);
		}
		echo "done";
		//see($bookings);
	}
	
	
	function newOngTest()
	{
		$file = './csvfile/newOngIni-16july.xlsx';
		$formOne=$this->readCsv($file);	
		//see($formOne);die();
		$count=0;
		$bookings=array();
		foreach($formOne['values'] as $vK=>$val)
		{
			$booking=array();
			
			/*if($vK<102)
				$col="`salesForce_id`";
			else
				$col="`id`";*/
			//$col="`salesForce_id`";
			$booking['id']=$val['A'];
			$start_date = PHPExcel_Shared_Date::ExcelToPHP( $val['B'] );
			$booking['from']=date('Y-m-d', $start_date);
			
			if($val['C']!='')
			{
				$end_date = PHPExcel_Shared_Date::ExcelToPHP( $val['C'] );
				$booking['to']=date('Y-m-d', $end_date);
			}
			else
				$booking['to']='0000-00-00';
			
			$on_start_date = PHPExcel_Shared_Date::ExcelToPHP( $val['D'] );
			$booking['onFrom']=date('Y-m-d', $on_start_date);
			
			$bookingDetails=bookingDetails($booking['id']);
			$sha=getshaOneAppDetails($bookingDetails['student']);
			
			/*echo 'From > '.$bookingDetails['booking_from'].' == '.$row['booking_from'].', To > '.$bookingDetails['booking_to'].' == '.$row['booking_to'];
			if($bookingDetails['booking_from']!=$row['booking_from']){echo '---FROM---';}
			if($bookingDetails['booking_to']!=$row['booking_to'] && $bookingDetails['booking_to']!='0000-00-00'){echo '---TO---';}
			echo "<br>";*/
			$count++;
			echo $count.'<br>';
			echo $booking['id'].' > '.$booking['from'].' to '.$booking['to'].'    csv<br>';
			echo $bookingDetails['id'].' > '.$bookingDetails['booking_from'].' to '.$bookingDetails['booking_to'].'    booking<br>';
			echo $sha['id'].' > '.$sha['booking_from'].' to '.$sha['booking_to'].'    student<br><br>';
			
			//if(date('Y-m-d',strtotime($booking['onFrom'].' -1 day')) !=$row['booking_to'])
			//echo 'Booking id='.$booking['id'].',  Inovice id='.$row['id'].',   '.$booking['onFrom'].' '.$row['booking_to'].'<br>';
			///
			//$getshaOneAppDetails=getshaOneAppDetails($res['student']);
			//$sqlSha="update `sha_one` set `booking_from`='".$res['booking_from']."', `booking_to`='".$res['booking_to']."' where `id`='".$res['student']."'";
			//$this->db->query($sqlSha);
			///
			
		}
		//see($bookings);
		die();
		/*foreach($bookings as $bK=>$book)
		{
			//if($book['to']!='0000-00-00')
				echo $book['id'].' > '.$book['from'].' - '.$book['to'].'<br>';
		}
		die();*/
		
		
		echo "done";
		//see($bookings);
	}
	
	function roomIdChanged()
	{
		$file = './csvfile/Bookings-RoomIdChanged.xls';
		$formOne=$this->readCsv($file);	
		//see($formOne);die();
		
		foreach($formOne['values'] as $val)
		{
			if($val['D']=='')
			{
				//$this->load->model('sha_model');
				$limit=' '.$val['C']-1;
				$limit .=','.$val['C'];
				$sql="select * from `hfa_bedrooms` where `application_id`='".$val['B']."' order by `id` limit ".$limit;
				//$query=$this->db->query($sql);echo $this->db->last_query();
				$row=$query->row_array();
				
				//$this->db->query("update `bookings` set `room`='".$row['id']."' where `id`='".$val['A']."'");
				echo "done=".$val['A'].", ";
			}
		}
		
		
	}
	
	
	function poDD()
	{
		$query=$this->db->query("select * from `purchase_orders` where `moved_to_xero`='0'");
		$res=$query->result_array();
		foreach($res as $po)
		{
			$fromDate=$po['from'];
			$dueDate=date('Y-m-d',strtotime($fromDate.' next friday'));
			$dueDate=date('Y-m-d',strtotime($dueDate.' next friday'));
			$day=date('D',strtotime($fromDate));
			if($day=='Thu')
				$dueDate=date('Y-m-d',strtotime($dueDate.' next friday'));
			
			//echo 	$po['id'].' => '.$po['from'].' =====> '.$dueDate.'<br>';
			$query=$this->db->query("update `purchase_orders`  set `due_date`='".$dueDate."' where `id`='".$po['id']."'");
			echo 'Done for '.$po['id'].' => '.$po['from'].' =====> '.$dueDate.'<br>';
		}
	}
	
	
	
	
	
	function hfaVisitReport()
	{
		$file = './csvfile/account-test.xlsx';
		$formOne=$this->readCsv($file);	
		see($formOne);die();
		$count=1;
		$Hosts=array();
		foreach($formOne['values'] as $vK=>$val)
		{
			$hfa=array();
			
			$hfa['SF_id']=$val['A'];
			$on_start_date = PHPExcel_Shared_Date::ExcelToPHP( $val['B'] );
			$hfa['visit_date']=date('Y-m-d', $on_start_date);
			
			$hfaQuery=$this->db->query("select `id` from `hfa_one` where `salesForce_id`='".$hfa['SF_id']."'");
			if($hfaQuery->num_rows()>0)
			{
				$hfa['host']=$hfaQuery->row_array();//echo $hfa['host']['id'].'<br>';
				$vRQuery=$this->db->query("select * from `hfa_visitReport` where `hfa_id`='".$hfa['host']['id']."'");
				if($vRQuery->num_rows()==0)
				{
					echo $count.'   > '.$hfa['host']['id'].'   > '.$hfa['SF_id'].'<br>';
					$count++;
					
					//$this->db->query("insert into `hfa_visitReport` (`hfa_id`, `date_visited`, `employee`, `date`) values('".$hfa['host']['id']."','".$hfa['visit_date']." 01:00:00','10','".date('Y-m-d H:i:s')."') ");
				}
			}//else{echo "notFound = ".$hfa['SF_id'];}
			//$Hosts[]=$hfa;
		}
		
		
	}
	
	function test()
	{
		$bed='13876';
		$studentAcc='1';
		$dates['from']="2019-02-12";
		$dates['to']="2019-02-22";
		if(checkIfBedBooked($bed,$studentAcc,$dates))
		echo "Yes";
		else
		echo "No";
		}
		
	function groupC()
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
	
	function dC()
	{
		$file = './csvfile/aadd.xlsx';
		$formOne=$this->readCsv($file);	
		//see($formOne);die();
		
		foreach($formOne['values'] as $vK=>$val)
		{
			if(isset($val['E']) &&trim($val['E'])!='')
			{
				echo "<br>";
				
				$college=$this->db->query("select * from `clients` where `bname` LIKE ?",$val['E'])->row_array();
				
				if(!empty($college))
				{
					$college_group=$college['client_group'];
					$bname=$college['bname']; 
					$sub=$college['suburb']; 
					
					
					$row1='';
					$stringAddress='';
					if(trim($college['suburb'])!='')
						$stringAddress .=' '.trim($college['suburb']);
					if(trim($college['state'])!='')
					{
						if($stringAddress!='')
							$stringAddress .='*';
						$stringAddress .=trim($college['state']);
					}
					if(trim($college['postal_code'])!='' && $college['postal_code']!='0')
					{
						$stringAddress .=' '.trim($college['postal_code']);
					}
							
				  $row1 .= $college['street_address'];
				  if($college['street_address']!='' && $stringAddress!='')
					$row1.=',';
				  $row1.=str_replace('*',', ',$stringAddress);
		
				  $add=$row1 ;
				
				  $this->db->query("update `sha_three` set `college`=?, `college_group`=?, `campus`=?, `college_address`=? where `college` like ?",array($bname, $college_group, $sub, $add,$val['C']));
				  echo $this->db->last_query().'<br>';
				}
				
			}
		}
		
		
	}
		
}
