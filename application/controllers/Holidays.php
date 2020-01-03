<?php
class Holidays extends CI_Controller {

		function __construct()
		{
			parent::__construct();
			$this->load->model('holiday_model');
		}
		
		function index(){echo "yes";}
		
		function notAdjusted($booking_id)
		{
			$this->holiday_model->addHolidayDiscountPO($booking_id);
		}
		
		function addAdminDiscount($po_id)
		{
			$this->load->model('booking_model');
			$this->booking_model->addHolidayAdminFeePo($po_id);
		}
		
}
