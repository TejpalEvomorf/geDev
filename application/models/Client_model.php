<?php 

class Client_model extends CI_Model { 
	var $table = 'clients';
	var $column_order = array('id'); //set column field database for datatable orderable
var $column_search = array("CONCAT(`primary_contact_name`,' ',`primary_contact_lname`)",'primary_contact_name','primary_contact_lname','bname','primary_email','primary_phone','street_address','suburb','state','postal_code','category');
	var $order = array('date_added' => 'desc'); // default order
	function validateClient($data)
		{
			$sql="";
			if(isset($data['id']))
				$sql .=" and `id`!='".$data['id']."'";
				
			$sqlBname="Select * from `clients` where `bname` = ?".$sql;
			$queryBname=	$this->db->query($sqlBname,$data['bname']);
			//echo $this->db->last_query();
			if ($queryBname->num_rows() > 0)
				$bname=1;
			else	
				$bname=0;

			/*$sqlAbn="Select * from `clients` where `abn` = ?".$sql;
			$queryAbn=	$this->db->query($sqlAbn,$data['abn']);
			//echo $this->db->last_query();
			if ($queryAbn->num_rows() > 0)
				$abn=1;
			else	*/
				$abn=0;

			/*$sqlPEmail="Select * from `clients` where `primary_email` = ?".$sql;
			$queryPEmail=	$this->db->query($sqlPEmail,$data['p_email']);
			//echo $this->db->last_query();
			if ($queryPEmail->num_rows() > 0)
				$pEmail=1;
			else	*/
				$pEmail=0;

			/*$sqlSEmail="Select * from `clients` where `sec_email` = ?".$sql;
			$querySEmail=	$this->db->query($sqlSEmail,$data['s_email']);
			//echo $this->db->last_query();
			if ($querySEmail->num_rows() > 0)
				$sEmail=1;
			else	*/
				$sEmail=0;	
				
			if($bname==1 || $abn==1 || $pEmail==1 || $sEmail==1)
				return array('bname'=>$bname, 'abn'=>$abn, 'pEmail'=>$pEmail, 'sEmail'=>$sEmail);
			else
				return 'yes';
		}
		
		function createClient($data)
		{
			if($data['category']=='2' && isset($data['commission']))
			{
				$commission='1';
				$commission_value=$data['commission_value'];
			}
			else
			{
				$commission='0';
				$commission_value='0';
			}
			
			$groupInvoice=$groupInvoicePlacementFee=$groupInvoiceAPU=$groupInvEnrollAccomodationFee='0';
			if(($data['category']=='3' || $data['category']=='4') && (isset($data['groupInvEnroll']) && (isset($data['groupInvEnrollPlacementFee']) || isset($data['groupInvEnrollAPU']) || isset($data['groupInvEnrollAccomodationFee'])) ))
			{
				$groupInvoice='1';
				if(isset($data['groupInvEnrollPlacementFee']))
					$groupInvoicePlacementFee='1';
				if(isset($data['groupInvEnrollAPU'])	)
					$groupInvoiceAPU='1';
				if(isset($data['groupInvEnrollAccomodationFee'])	)
					$groupInvEnrollAccomodationFee='1';
			}
			
			$sql="insert into `clients` (`bname`,`abn`,`category`,`client_group`,`commission`,`commission_val`,`group_invoice`,`group_invoice_placement_fee`,`group_invoice_apu`,`group_invoice_accomodation_fee`,`street_address`,`suburb`,`state`,`postal_code`,`country`,`primary_contact_name`,`primary_contact_lname`,`primary_phone`,`primary_email`,`sec_contact_name`,`sec_contact_lname`,	`sec_phone`,`sec_email`,`notes`,`date_added`) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$this->db->query($sql,array($data['bname'],$data['abn'],$data['category'],$data['clientGroup'],$commission,$commission_value,$groupInvoice,$groupInvoicePlacementFee,$groupInvoiceAPU,$groupInvEnrollAccomodationFee,$data['address'],$data['suburb'],$data['state'],$data['postal_code'],$data['country'],$data['p_name'],$data['p_lname'],$data['p_phone'],$data['p_email'],$data['s_name'],$data['s_lname'],$data['s_phone'],$data['s_email'],$data['notes'],date('Y-m-d H:i:s')));
			return $this->db->insert_id();
		}
		
		function editClient($data)
		{
			$sql="update `clients` set `bname`=?,`abn`=?,`category`=?,`street_address`=?,`suburb`=?,`state`=?,`postal_code`=?,`country`=?,`primary_contact_name`=?,`primary_contact_lname`=?,`primary_phone`=?,`primary_email`=?,`sec_contact_name`=?,`sec_contact_lname`=?,	`sec_phone`=?,`sec_email`=?,`notes`=? where `id`=?";
			$this->db->query($sql,array($data['bname'],$data['abn'],$data['category'],$data['address'],$data['suburb'],$data['state'],$data['postal_code'],$data['country'],$data['p_name'],$data['p_lname'],$data['p_phone'],$data['p_email'],$data['s_name'],$data['s_lname'],$data['s_phone'],$data['s_email'],$data['notes'],$data['id']));
		}
			private function _get_datatables_query()
	{
		$this->db->select('clients.*');
		$this->db->from($this->table);
		
		if(!empty($_POST['clientCategory']))
			$this->db->where('category', $_POST['clientCategory']);
		
			$i = 0;

	
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
					//echo $this->db->last_query();
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
		$this->_get_datatables_query();
		$query = $this->db->get();
		//echo $this->db->last_query(); //die;
		return $query->num_rows();
		}
			
		
	
		function clientsList()
		{
			$sql="select * from `clients` order by `bname`";
			$query=$this->db->query($sql);
			$list=$query->result_array();
			
			foreach($list as $cK=>$cV)
			{
				$agreement=array();
				$agreement=$this->clientAgreement($cV['id']);
				if(!empty($agreement))
					$list[$cK]['agreement']=$agreement;
			}
			return $list;
		}
		function clientsListshause()
		{
			$sql="select * from `clients` where `category`!=1 and `category`!=2 order by `bname`";
			$query=$this->db->query($sql);
			$list=$query->result_array();
			
			foreach($list as $cK=>$cV)
			{
				$agreement=array();
				$agreement=$this->clientAgreement($cV['id']);
				if(!empty($agreement))
					$list[$cK]['agreement']=$agreement;
			}
			return $list;
		}
		function deleteClient($id)
		{
			$client=$this->clientDetail($id);
			if(isset($client['agreement']))
			{
				foreach($client['agreement'] as $agree)
					{
						$this->deleteClientAgreement($agree['id']);
					}
			}
			
			$sql="delete from `clients` where `id`='".$id."'";
			$this->db->query($sql);
		}
		
		function deleteClientAgreement($id)
		{
			$sql="select * from `client_agreement` where `id`='".$id."'";
			$query=$this->db->query($sql);
			$row=$query->row_array();
			if(!empty($row))
			{
				unlink('static/uploads/client/'.$row['name']);
				$sqlDel="delete from `client_agreement` where `id`='".$id."'";
				$this->db->query($sqlDel);
			}
		}
		
		function clientDetail($id)
		{
			$sql="select * from `clients` where `id`='".$id."'";
			$query=$this->db->query($sql);
			$client=$query->row_array();
			
			if(!empty($client))
			{
				$agreement=$this->clientAgreement($id);
				if(!empty($agreement))
					$client['agreement']=$agreement;
			}
			return $client;
		}
		function collegeDetail($id)
		{
			$sql="select * from `clients` where `category`!=1 and `category`!=2 and  `id`='".$id."'";
			$query=$this->db->query($sql);
			$client=$query->row_array();
			
			if(!empty($client))
			{
				$agreement=$this->clientAgreement($id);
				if(!empty($agreement))
					$client['agreement']=$agreement;
			}
			return $client;
		}
		function client_agreement_upload($id,$file)
		{
			$sql="insert into `client_agreement`  (`client_id`,`name`,`date`) value(?,?,?)";
			$this->db->query($sql,array($id,$file,date('Y-m-d H:i:s')));
		}
		
		function clientAgreement($id)
		{
			$sqlDoc="select * from `client_agreement` where `client_id`='".$id."' order by `date` DESC";
			$queryDoc=$this->db->query($sqlDoc);
			return $queryDoc->result_array();
		}
		
		function updateClientCategory($data)
		{
			if($data['category']=='2' && isset($data['commission']))
			{
				$commission='1';
				$commission_value=$data['commission_value'];
			}
			else
			{
				$commission='0';
				$commission_value='0';
			}
			
			$groupInvoice=$groupInvoicePlacementFee=$groupInvoiceAPU=$groupInvEnrollAccomodationFee='0';
			if(($data['category']=='3' || $data['category']=='4') && (isset($data['groupInvEnroll']) && (isset($data['groupInvEnrollPlacementFee']) || isset($data['groupInvEnrollAPU']) || isset($data['groupInvEnrollAccomodationFee'])) ))
			{
				$groupInvoice='1';
				if(isset($data['groupInvEnrollPlacementFee']))
					$groupInvoicePlacementFee='1';
				if(isset($data['groupInvEnrollAPU'])	)
					$groupInvoiceAPU='1';
				if(isset($data['groupInvEnrollAccomodationFee'])	)
					$groupInvEnrollAccomodationFee='1';
			}
			
			$sql="update `clients` set `category`='".$data['category']."', `commission`='".$commission."', `commission_val`='".$commission_value."', `group_invoice`='".$groupInvoice."', `group_invoice_placement_fee`='".$groupInvoicePlacementFee."', `group_invoice_apu`='".$groupInvoiceAPU."', `group_invoice_accomodation_fee`='".$groupInvEnrollAccomodationFee."' where `id`='".$data['id']."'";
			$this->db->query($sql);
		}
		
		function updateClientGroup($data)
		{
			$sql="update `clients` set `client_group`='".$data['clientGroup']."' where `id`='".$data['id']."'";
			$this->db->query($sql);
		}
		
		function client_logo_upload($id,$imagename)
		{
			$this->deleteClientLogo($id);
			$sql="update `clients` set `image`='".$imagename."' where `id`='".$id."'";
			$this->db->query($sql);
		}
		
		function deleteClientLogo($id)
		{
			$emp=$this->clientDetail($id);
			if(!empty($emp) && $emp['image']!='')
				unlink('static/uploads/client/logo/'.$emp['image']);
		}
		
		function clientsListGroupInv()
		{
			$sql="select * from `clients` where `group_invoice`='1' and (`group_invoice_placement_fee`='1' OR `group_invoice_apu`='1' OR `group_invoice_accomodation_fee`='1') order by `bname`";
			$query=$this->db->query($sql);
			$list=$query->result_array();
			return $list;
		}
		
		function shaListByClientId($id)
		{
			$sql="select * from `sha_one` where `client`='".$id."'";
			$query=$this->db->query($sql);
			$res=$query->result_array();
			return $res;
		}
		
		function delClient_assignClient($data)
		{
			$sql="update `sha_one` set `client`='".$data['client']."' where `id`='".$data['sha_id']."'";
			$query=$this->db->query($sql);
		}
}

?>