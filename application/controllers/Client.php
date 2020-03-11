<?php
class Client extends CI_Controller {
	
		function __construct()
		{
			parent::__construct();
			$this->load->model('client_model');
		}
		
		
		function index()
		{
			if(checkLogin())
			{
				recentActionsAddData('client','list','view');
			
				$data['page']='client';
				$this->load->view('system/header',$data);
				$this->load->view('system/client/list');
				$this->load->view('system/footer');
				/*$data['clientsTemp']=$this->client_model->clientsList();
				if(isset($_GET['clientCategory']) && ($_GET['clientCategory']!=''))
					{
						$data['clients']=array();
						foreach($data['clientsTemp'] as $listK=>$listV)
						{
								if($listV['category']==$_GET['clientCategory'])
									$data['clients'][]=$listV;
						}
					}
					else
					$data['clients']=$data['clientsTemp'];
				
				$this->load->view('system/header',$data);
				$this->load->view('system/client/client_list');
				$this->load->view('system/footer');*/
			}
			else
				redirectToLogin();
		}
		function ajax_list(){
			$list = $this->client_model->get_datatables();
			$clientCategories=clientCategories();
		$stateList=stateList();
		//print_r($list);
		$data = array();
		foreach($list as $clientK=>$clientV)
		{
			$row = array();
			if(!empty($clientV['image'])){
			 $row3='<img src="'.static_url().'uploads/client/logo/thumbs/'.$clientV['image'].' " height="70" />';
			}else{
				$row3='<img src="'.static_url().'uploads/client/logo/thumbs/default-clientlogo.jpg " height="70" />';
			}
			 
			 $row[]=$row3;
			 $row1='<a href="'.site_url().'client/edit/'.$clientV['id'].'" target="_blank">'.$clientV['bname'].'</a>';
			 $row1 .='<br />';
			  $stringAddress='';
											  if(trim($clientV['suburb'])!='')
												  $stringAddress .=trim($clientV['suburb']);
											  if(trim($clientV['state'])!='')
											  {
												  if($stringAddress!='')
													  $stringAddress .='*';
												  $stringAddress .=trim($clientV['state']);
											  }
											  if(trim($clientV['postal_code'])!='' && $clientV['postal_code']!='0')
											  {
												  if($stringAddress!='')
													  $stringAddress .='*';
												  $stringAddress .=trim($clientV['postal_code']);
											  }
					
			   $addressForMap='';
			   $addressForMap .= $clientV['street_address'];
			   if($clientV['street_address']!='' && $stringAddress!='')
					$addressForMap.=',';
			   $addressForMap.=str_replace('*',', ',$stringAddress);
			   $row1.=getMapLocationLink($addressForMap);	
			//1st Column: HOST #ENDS
			
			$row[]=$row1;
			$row2=ucwords($clientV['primary_contact_name'].' '.$clientV['primary_contact_lname']);
			$row2.="<br/>";
			$row2.='<a class="mailto" href="mailto:'.$clientV['primary_email'].'">'.$clientV['primary_email'].'</a>';
			 $row2.="<br/>";
			 $row2.=$clientV['primary_phone'];
			 $row[]=$row2;
			 $row4=$clientCategories[$clientV['category']];
			if($clientV['category']==2 && $clientV['commission']=='1'){
				$row4.="<br/>";
				$row4.='<span style="color:#b0b0b0;">Commission: $'.$clientV['commission_val'].'</span>';
				
			}
			$row[]=$row4;
			$row6='';
			if(isset($clientV['agreement'])){
                                            foreach($clientV['agreement'] as $agree)
              								{
                  								$row6.="<p>";
												$row6.='<a  href="'.static_url().'uploads/client/'.$agree['name'].'" target="_blank">'.getFileTypeIcon($agree['name']).' '.$agree['name'].'</a>';
												$row6.="</p>";
												              							 }
																					$row[]=$row6;	 
																						 
																						 
																						 }else{
													
													$row[]=$row6;
													

												}
												$row5='<div class="btn-group dropdown table-actions">';
												$row5.='<button class="btn btn-sm btn-midnightblue dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="true">';
												$row5.='<i class="colorBlue material-icons">more_horiz</i>';
												$row5.='<div class="ripple-container"></div>';
												$row5.='</button>';
												$row5 .='<ul class="dropdown-menu" role="menu">';
					  $row5 .='<li>';
					  $row5 .='<a href="'.site_url().'client/edit/'.$clientV['id'].'" ><i class="font16 material-icons">edit</i>&nbsp;&nbsp;Edit</a>';
					  $row5 .='</li>';
					  $row5 .='<li>';
					  	$row5 .='<a href="javascript:;" class="clientDelete" id="clientDelete-'.$clientV['id'].'" data-toggle="modal" data-target="#model_deleteClientProcess"><i class="font16 material-icons">delete</i>&nbsp;&nbsp;Delete</a>';
					  	$row5 .='</li>';
					 
					   $row5 .='</ul>';
             $row5 .='</div>';
			//5th Column: ACTIONS #ENDS
			
			$row[] = $row5;
			$data[] = $row;
			
		}
			
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->client_model->count_all(),
						"recordsFiltered" => $this->client_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
			

		}
		
		function filters()
		{
			 $this->load->view('system/client/filters');
		}
		
		function create()
		{
			if(checkLogin())
			{
				$data['page']='create_client';
				$this->load->view('system/header',$data);
				$this->load->view('system/client/create_client');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
		}
		
		function createSubmit()
		{
			if(checkLogin())
			{
				$data=$_POST;
				$data=trimArrayValues($data);
				$res=array();
				$valid=$this->client_model->validateClient($data);
				if(!is_array($valid) && $valid=='yes')
				{
					if(isset($data['id']))
						$res['done']['id']=$this->client_model->editClient($data);	
					else
					{
						$res['done']['id']=$this->client_model->createClient($data);
						recentActionsAddData('client',$res['done']['id'],'add');
					}
				}
				else
					$res['notValid']=$valid;
			}
			else
				$res['logout']="LO";
				
			echo json_encode($res);	
		}
		
		function edit($id)
		{
			if(checkLogin())
			{
				recentActionsAddData('client',$id,'view');
			
				$data['page']='create_client';
				$data['client']=$this->client_model->clientDetail($id);
				if(empty($data['client']))
					header('location:'.site_url().'client');
				$this->load->view('system/header',$data);
				$this->load->view('system/client/edit_client');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
		}
		
		function deleteClient()
		{
			if(isset($_POST['id']))
			{
				$this->client_model->deleteClient($_POST['id']);
				echo "done";
			}
		}
		
		function client_agreement_upload()
		{
			if($_FILES['file']['name']!= "")
				  {
						$path="./static/uploads/client"; 
						$t1=time();
						$imagename=$t1.$_FILES['file']['name'];		
						move_uploaded_file($_FILES['file']['tmp_name'],$path.'/'.$imagename);
						
						$this->client_model->client_agreement_upload($_POST['clientId'],$imagename);
						$data['client']=$this->client_model->clientDetail($_POST['clientId']);
						$this->load->view('system/client/agreement_list',$data);
					}
		}
		
		function updateClientCategory()
		{
			if(checkLogin())
			{
				if(isset($_POST['id']))
				{
					$this->client_model->updateClientCategory($_POST);
					echo "done";
				}
			}
			else
				echo "LO";
		}
		
		function updateClientGroup()
		{
			if(checkLogin())
			{
				if(isset($_POST['id']))
				{
					$this->client_model->updateClientGroup($_POST);
					echo "done";
				}
			}
			else
				echo "LO";
		}
		
	function client_logo_upload()
	{
		if($_FILES['file']['name']!= "")
				  {
						$path="./static/uploads/client/logo"; 
						$t1=time();
						$imagename=$t1.$_FILES['file']['name'];		
						move_uploaded_file($_FILES['file']['tmp_name'],$path.'/'.$imagename);
						
						$large_image_location=$path.'/'.$imagename;
						$thumb_image_location=$path.'/thumbs/'.$imagename;
						
						cropImageFromSides($large_image_location,$thumb_image_location,'250','250');
						$this->client_model->client_logo_upload($_POST['clientId'],$imagename);
						$data['client']=$this->client_model->clientDetail($_POST['clientId']);
						$this->load->view('system/client/client_edit_page_logo',$data);
					}
	}
	
	
	function shaListByClientId()
	{
			if(checkLogin())
			{
				if(isset($_POST['id']))
				{
					$students=$this->client_model->shaListByClientId($_POST['id']);
					if(!empty($students))
					{
						$data['client_id']=$_POST['id'];
						$data['students']=$students;
						$res=$this->load->view('system/client/delClient_shaList',$data,true);
					}
					else
						$res='noStudent';
					echo $res;	
				}
			}
			else
				echo "LO";
	}
	
	function delClient_assignClient()
	{
		if(checkLogin())
			{
				$data=$_POST;
				$students=$this->client_model->delClient_assignClient($data);
				echo 'done';
			}
			else
				echo "LO";
	}
		
}