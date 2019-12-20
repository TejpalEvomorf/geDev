<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
			if(checkLogin())
			{
				$data['page']='dashboard';
				$this->load->view('system/header',$data);
				$this->load->view('system/dashboard');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
	}
	
	function getchartData()
	{
		$data=$_POST;
		$this->load->model('dashboard_model');
		$chartData=$this->dashboard_model->getchartData($data);//echo $this->db->last_query();
		
		foreach($chartData as $cd)
		{
			if($data['xAxis']=='m')
				$xAxis[]=date('M Y',strtotime($cd['month']));
			elseif($data['xAxis']=='w')
			{	
				//$xAxis[]=date('d M Y',strtotime($cd['week_beginning'])).' - '.date('d M Y',strtotime($cd['week_beginning'].' +6 days'));
				$label='';
				if(strtotime($cd['week_beginning']) >= strtotime($data['feedFrom']))	
					$label .=date('d M Y',strtotime($cd['week_beginning']));
				else		
					$label .=date('d M Y',strtotime($data['feedFrom']));
				$label .=' - ';
				if(strtotime($cd['week_beginning'].' +6 days') <= strtotime($data['feedTo']))	
					$label .=date('d M Y',strtotime($cd['week_beginning'].' +6 days'));
				else		
					$label .=date('d M Y',strtotime($data['feedTo']));
				$xAxis[]=$label;
			}
			elseif($data['xAxis']=='d')	
				$xAxis[]=date('d M Y',strtotime($cd['date']));
			$sent[]=$cd['total_sent'];
			$visits[]=$cd['total_visits'];
			$submissions[]=$cd['total_submissions'];
		}
		
		$returnData['xAxis']=$xAxis;
		$returnData['total_sent']=$sent;
		$returnData['total_visits']=$visits;
		$returnData['total_submissions']=$submissions;
		
		echo json_encode($returnData);
	}
}
