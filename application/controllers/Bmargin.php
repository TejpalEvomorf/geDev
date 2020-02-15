<?php
class Bmargin extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Bmargin_model');
	}
	
	function bm4()
	{
		$method=$this->router->fetch_method();
		$output=$this->Bmargin_model->$method();
		echo $output;return;
	}
	
	function bmPo()
	{
		$method=$this->router->fetch_method();
		$output=$this->Bmargin_model->$method();
		echo $output;return;
	}
	
	function bmMargin()
	{
		$method=$this->router->fetch_method();
		$output=$this->Bmargin_model->$method();
		echo $output;return;
	}
	
	function bmPaidTill()
	{
		$method=$this->router->fetch_method();
		$output=$this->Bmargin_model->$method();
		echo  $output;return;
	}
}