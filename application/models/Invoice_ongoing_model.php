<?php 

class Invoice_ongoing_model extends CI_Model { 


////////////// For data table server side STARTS

	var $table = 'invoice_ongoing';
	var $column_order = array('invoice_ongoing.id'); //set column field database for datatable orderable
	var $column_search = array('invoice_ongoing.id'); //set column field database for datatable searchable
	var $order = array('invoice_ongoing.date' => 'desc'); // default order

	private function _get_datatables_query()
	{
		$this->db->select('invoice_ongoing.id'); 
		$this->db->from($this->table);
		if($_POST['ongoing_invoice_statusPage']!='0')
			$this->db->where('invoice_ongoing.status', $_POST['ongoing_invoice_statusPage']);
			
		$this->db->join('sha_one', 'invoice_ongoing.application_id = sha_one.id', 'left');
		$this->db->join('study_tours', 'invoice_ongoing.application_id = study_tours.id', 'left');
		
		$where='';
		if(isset($_POST['InoiceFilter_number']) && $_POST['InoiceFilter_number']!='')
		{
			$invoiceNumArray=explode('-',trim($_POST['InoiceFilter_number']));
			$_POST['InoiceFilter_number']=trim(end($invoiceNumArray));
			$where .="`invoice_ongoing`.`id` like '".$_POST['InoiceFilter_number']."%' and ";
		}
		
		if((isset($_POST['InoiceFilter_from']) && $_POST['InoiceFilter_from']!=''))
			$where .="date(`invoice_ongoing`.`date`)>='".normalToMysqlDate($_POST['InoiceFilter_from'])."' and ";	
		if((isset($_POST['InoiceFilter_to']) && $_POST['InoiceFilter_to']!=''))
			$where .="date(`invoice_ongoing`.`date`)<='".normalToMysqlDate($_POST['InoiceFilter_to'])."' and ";
			
		if(isset($_POST['InoiceFilter_client']) && $_POST['InoiceFilter_client']!='') 
			$where .="IF(`invoice_ongoing`.`study_tour` = '0', `sha_one`.`client`, `study_tours`.`client_id`) =  '".$_POST['InoiceFilter_client']."' and ";
		
		if(isset($_POST['InoiceFilter_studyTour']) && $_POST['InoiceFilter_studyTour']!='') 
			$where .="`invoice_ongoing`.`study_tour` = '1' and `invoice_ongoing`.`application_id`=  '".$_POST['InoiceFilter_studyTour']."' and ";
			
		 if(isset($_POST['InoiceFilter_student']) && $_POST['InoiceFilter_student']!='')
			 $where .="IF(`invoice_ongoing`.`study_tour` = '0', CONCAT(`sha_one`.`fname`,' ',`sha_one`.`lname`), `study_tours`.`group_name`) like '%".$_POST['InoiceFilter_student']."%' and ";	
		
			if(isset($_POST['InoiceFilter_other']))
			{
			  if($_POST['InoiceFilter_other']=='1')
				  $where .="`invoice_ongoing`.`study_tour` = '1' and ";
			  if($_POST['InoiceFilter_other']=='2')
				  $where .="`invoice_ongoing`.`study_tour` = '0' and ";
			  if($_POST['InoiceFilter_other']=='3')
				  $where .="`invoice_ongoing`.`cancelled` = '1' and ";
			  if($_POST['InoiceFilter_other']=='4')
				  $where .="`invoice_ongoing`.`moved_to_xero` = '1' and ";
			  if($_POST['InoiceFilter_other']=='5')
				  $where .="`invoice_ongoing`.`moved_to_xero` = '0' and ";													
			}
		$where .=	" 1=1 ";
		
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
		$query = $this->db->get();
		//echo $this->db->last_query(); //die;
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
		if($_POST['ongoing_invoice_statusPage']!='0')
			$this->db->where('invoice_ongoing.status', $_POST['ongoing_invoice_statusPage']);
		return $this->db->count_all_results();
	}


	////////////// For data table server side ENDS

}