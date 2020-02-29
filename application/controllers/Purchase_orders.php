<?php
class Purchase_orders extends CI_Controller{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('po_model');
	}
	
	function index()
		{
			recentActionsAddData('po','pending','view');
			$this->poList(1);
		}
	
	function paid()
		{
			recentActionsAddData('po','paid','view');
			$this->poList(2);
		}
		
	function all()
		{
			recentActionsAddData('po','all','view');
			$this->poList(0);
		}
	
	function partial()
		{
			recentActionsAddData('po','partial','view');
			$this->poList(3);
		}			
		
	function poList($status)
		{
			if(checkLogin())
			{
					if(isset($_GET['poFrom']))
					{
						$data['poFrom']=$_GET['poFrom'];
						$data['poFromCustom']='1';
					}
					else
					{
						$data['poFrom']='';
						/*$day=date('D');
						if($day=='Fri')
							$data['poFrom']=date('d/m/Y');
						else
							$data['poFrom']=date('d/m/Y',strtotime(' previous Friday'));*/
					}
					
					if(isset($_GET['poTo']))
					{
						$data['poTo']=$_GET['poTo'];
						$data['poToCustom']='1';
					}
					else
					{
						$data['poTo']='';
						/*$day=date('D');
						if($day=='Thu')
							$data['poTo']=date('d/m/Y');
						else
							$data['poTo']=date('d/m/Y',strtotime(' next Thursday'));*/
					}
					
					if(isset($_GET['poDueDate']))
						$data['poDueDate']=$_GET['poDueDate'];
					else
						$data['poDueDate']='';
					
					$data['pOFilter_number']='';
					if(isset($_GET['number']))
					{
						$poNumArray=explode('-',trim($_GET['number']));
						$_GET['number']=trim(end($poNumArray));
						$data['pOFilter_number']=$_GET['number'];
					}
						
					$data['pOFilter_studyTour']='';
					if(isset($_GET['study_tour']))
						$data['pOFilter_studyTour']=$_GET['study_tour'];
					
					$data['pOFilter_host']='';
					if(isset($_GET['host']))
						$data['pOFilter_host']=$_GET['host'];
					
					$data['pOFilter_host']='';
					if(isset($_GET['host']))
						$data['pOFilter_host']=$_GET['host'];		
						
					$data['pOFilter_other']='';
					if(isset($_GET['other']))
						$data['pOFilter_other']=$_GET['other'];		
					
					$data['page']='po';
					$data['po_status']=$status;
					
					$this->load->view('system/header',$data);
					$this->load->view('system/po/list');
					$this->load->view('system/footer');
			}
			else
				redirectToLogin();
		}
		
		////////////// For data table server side STARTS
	public function ajax_list()
	{
		$list = $this->po_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		$po_status=$_POST['po_status'];
		
		foreach ($list as $po) {
			$po=(array) $po;
			$poListTd=poListTd($po,$po_status);
			$row = array();

			//1st Column: STUDENT #STATRS
			 $row1='';
			 $row1 .=$poListTd['td1'];
			//1st Column: STUDENT #ENDS
			$row[]=$row1;

			//2nd Column: ACCOMODATION TYPE #STATRS
			$row2='';
			$row2 .='<a href="'.site_url().'hfa/application/'.$po['host'].'" target="_blank">'.ucfirst($po['host_lname']).' Family</a>';
			$row2 .='<br>'.$po['host_email'];
			//2nd Column: ACCOMODATION TYPE #ENDS
			$row[]=$row2;

			//3rd Column: SUBMITTED #STATRS
			$row3='';
			$row3 .='<a href="'.site_url().'sha/application/'.$po['student'].'" target="_blank">'.ucwords($po['student_fname'].' '.$po['student_lname']).'</a>';
			$row3 .="<br>";   $d=ongoinginvoicedate($po['student']);
			if(!empty($d))
			{
				$row3 .='<span class="InvoiceChangeDate" data-placement="bottom" data-toggle="tooltip"  data-original-title="'. @$d['type'].', '.@$d['status'].'">';
				$row3 .=date('d M Y',strtotime($d['from'])).' to '.date('d M Y',strtotime($d['to'])).'</span>';
			}
			//3rd Column: SUBMITTED #ENDS
			$row[]=$row3;

			//4th Column: STATUS #STATRS
			$row4='';
			if($po['from']!='0000-00-00' && $po['to']!='0000-00-00')
				$row4 .= date('d M Y',strtotime($po['from'])).' to '.date('d M Y',strtotime($po['to'])).'<br>'.$poListTd['td4'];
			//4th Column: STATUS #ENDS
			$row[]=$row4;

			//5th Column: Office use #STARTS
			 $row5='';
			 $row5 .=$poListTd['td_officeUse'];
			//5th Column: Office use #ENDS
			$row[]=$row5;

			//4th Column: ACTIONS #STARTS
			 $row6='';
			 $row6 .='<div class="btn-group dropdown table-actions">';
                                        $row6 .='<button class="btn btn-sm btn-midnightblue dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="true" style="top: -5px;">';
                                            $row6 .='<i class="colorBlue material-icons">more_horiz</i>';
                                            $row6 .='<div class="ripple-container"></div>';
                                        $row6 .='</button>';
                                        $row6 .='<ul class="dropdown-menu dropdown-menu-sidebar" role="menu">';
                                            if($po_status=='1'){
                                            $row6 .='<li>';
                                            	 if($po['moved_to_xero']==0){
	                                            	$row6 .='<a href="javascript:void(0);" class="movePoToXero" data-toggle="modal" data-target="#model_movePoToXero" onclick="$(\'#movePoToXero_id\').val(\'po-'.$po['id'].'\');$(\'#model_movePoToXeroContentMove\').show();$(\'#model_movePoToXeroContentError .modal-body\').html(\'\');$(\'#model_movePoToXeroContentError\').hide();"><i class="font16 material-icons">redo</i>&nbsp;&nbsp;Move to Xero</a>';
                                                 } 
                                            $row6 .='</li>';
                                             }
                                            $row6 .='<li>';
                                                $row6 .='<a href="'.site_url().'purchase_orders/view/'.$po['id'].'" target="_blank"><i class="font16 material-icons">view_quilt</i>&nbsp;&nbsp;View purchase order data</a>';
                                            $row6 .='</li>';
											
											if(userAuthorisations('latest_po_delete') && ifPoIsLatest($po['id']))
											{
												$row6 .='<li id="deletePo-'.$po['id'].'">';
													$row6 .='<a href="javascript:void(0);" onclick="deletePo('.$po['id'].')"><i class="font16 material-icons">delete</i>&nbsp;&nbsp;Delete</a>';
												$row6 .='</li>';
											}
                                           $row6 .='</ul>';
                                        $row6 .='</div>';
            //4th Column: ACTIONS #ENDS
			$row[]=$row6;

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->po_model->count_all(),
						"recordsFiltered" => $this->po_model->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	////////////// For data table server side ENDS	
		
	function view($id)
		{
			if(checkLogin())
			{
				recentActionsAddData('po',$id,'view');
			
				$data['page']='poDetails';
				$data['po']=$this->po_model->poDetails($id);
				
				if(!empty($data['po']))
				{
					$this->load->view('system/header',$data);
					$this->load->view('system/po/view_po');
					$this->load->view('system/footer');
				}
				else
					header('location:'.site_url().'purchase_orders');
			}
			else
				redirectToLogin();
		}
		
	function filters()
	  {
		  $this->load->view('system/po/filters');
	  }
	  
	  
	function poUpdateDuration()
	{
		$data=$_POST;
		$totalDays=($data['weeks']*7)+($data['days']);
		
		$this->load->model('po_model');
		$poDetails=$this->po_model->poDetails($data['po_id']);
		
		$po_from=$poDetails['from'];
		$po_to=date('Y-m-d',strtotime($po_from.' + '.$totalDays.' days -1 day'));
		
		if($poDetails['initial']=='1')
			$nextOngoing='0';
		else	
			$nextOngoing='1';
		
		$po_structure=$this->poChangeDuration_structure($poDetails['booking_id'],$po_from,$po_to,$nextOngoing);//see($po_structure);
		
		if(!empty($po_structure))
			 $bookings=$this->po_model->updateGeneratedPo($data['po_id'],$po_structure);
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
			
		/*if(strtotime($po_from) == strtotime($po_to))//in case if booking end date ahs arrived and we cannot create next PO
			return array();*/
		if(strtotime($po_from) > strtotime($po_to))//in case if booking end date ahs arrived and we cannot create next PO
			return array();
		//
		
		$structure=po_structure2ndPart($po_from,$po_to,$accomodation_type,$bookingDetails,$nextOngoing);
		return $structure;
	}
	
	
	function editItemPopContent()
	{
		if(isset($_POST['itemId']))
		{
			$data=$_POST;
			$data['po']=$this->po_model->poDetails($data['id']);
			$this->load->view('system/po/editItemForm',$data);
		}
	}
	
	function editPoItemPopContentSubmit()
	{
		$data=$_POST;
		$this->po_model->editPoItem($data);
		
		$data['po']=$this->po_model->poDetails($data['po_id']);
			
		if(!empty($data['po']))
		{
			$view_po=$this->load->view('system/po/view_po',$data,true);
			$return['page']=$view_po;
			echo json_encode($return);
		  }
	}
	
	function addNewItemPopContent($id)
	{
		$data=array();
		$data['po']=$this->po_model->poDetails($id);
		$this->load->view('system/po/addNewItemForm',$data);
	}
	
	function addNewPoItemPopContentSubmit()
	{
		$data=$_POST;
		$this->po_model->addNewItem($data);
		
		$data['po']=$this->po_model->poDetails($data['po_id']);
		$view_po=$this->load->view('system/po/view_po',$data,true);
		$return['page']=$view_po;
		echo json_encode($return);
	}
	
	function deleteItem()
	{
			$data=$_POST;
			if($data['itemId']!='')
			{
				$this->po_model->deleteItem($data);
				$data['po']=$this->po_model->poDetails($data['id']);
				$view_po=$this->load->view('system/po/view_po',$data,true);
				$return['page']=$view_po;
				echo json_encode($return);
			}
	}
	
	function deletePo($id)
	{
		if(checkLogin())
			{
				if(userAuthorisations('latest_po_delete') && ifPoIsLatest($id))
					$this->po_model->deletePo($id);
			}
		else
			echo "LO";
	}
	
	function resetPO($id)
	{
		if(checkLogin())
			{ 
				if(ifPoIsLatest($id))
				{
					$poDetails=$this->po_model->poDetails($id);
					$this->po_model->deletePo($id);
					
					$latestPo=$this->po_model->getLastPoForBooking($poDetails['booking_id']);
					$nextOngoing['to']=$latestPo['to'];//date of previous po(to date)
					$po_structure[]=po_structure($poDetails['booking_id'],$nextOngoing);
					$this->po_model->insertGeneratedPo($po_structure);
					$latestPoNew=$this->po_model->getLastPoForBooking($poDetails['booking_id']);
					echo $latestPoNew['id'];
				}
			}
		else
			echo "LO";
	}


	function poUpdateDueDate()
	{
		$data = $_POST;
		$po_id = $data['po_id'];
		$po_due_date = normalToMysqlDate($data['po_dueDate']);
		$this->load->model('po_model');

		$this->po_model->updatePoDueDate($po_id,$po_due_date);
	}
}