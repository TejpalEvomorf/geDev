<?php 

class Product_model extends CI_Model { 

	function productsList($year)
	{
		$sql="select * from `products` where `year`='".$year."' order by `name`";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	
	function clientProductsList($client_id,$year)
	{
		$productsList=productsList($year);
		
		$this->load->model('client_model');
		$client=$this->client_model->clientDetail($client_id);
		
		foreach($productsList as $plsK=>$plsV)
		{
			$productsList[$plsK]['client']=$client;
		}
		
		$sqlClient="select * from `products_clients` where `client_id`='".$client_id."'";
		$queryClient=$this->db->query($sqlClient);
		$productsListClient=$queryClient->result_array();
		
		if(!empty($productsListClient))
		{
				foreach($productsListClient as  $plc)
				{
					foreach($productsList as $plK=>$plV)
					{
						if($plV['id']==$plc['product_id'])
						{
							if($plc['price']!=0)
								$productsList[$plK]['price']=$plc['price'];
							if($plc['cost']!=0)
								$productsList[$plK]['cost']=$plc['cost'];
						}
					}
				}
		}
		
		foreach($productsList as $pK=>$pV)
		{
			if($pV['clients']!='')
			{
			  $pClient=explode(',',$pV['clients']);
			  if(!in_array($client_id,$pClient))
				  unset($productsList[$pK]);
			}
		}
		
		return $productsList;
	}
	
	function addNewDefaultProduct($data)
	{
		$year=$data['year'];
		$date=date('Y-m-d H:i:s');
		$sql="insert into `products` (`name`,`code`,`price`,`cost`,`gst`,`year`,`xero_code`,`date`)values(?,?,?,?,?,?,?,?)";
		$this->db->query($sql,array($data['product_name'],$data['product_name'],$data['product_price'],$data['product_cost'],$data['product_gst'],$year,$data['product_xero_code'],$date));
	}
	
	function product_details($id,$client_id)
	{
		$sql="select * from `products` where `id`='".$id."'";
		$query=$this->db->query($sql);
		$product=$query->row_array();
		
		if($client_id!=0)
		{
			$sqlClient="select * from `products_clients` where `product_id`='".$id."' and `client_id`='".$client_id."'";
			$queryClient=$this->db->query($sqlClient);
			$productClient=$queryClient->row_array();
			if(!empty($productClient))
			{
				if($productClient['price']!=0)
					$product['price']=$productClient['price'];
				if($productClient['cost']!=0)
					$product['cost']=$productClient['cost'];
			}
			return $product;
		}
		else
			return $product;
	}
	
	function editProduct($data)
	{
		if(!isset($data['client_id']))
		{
			$sql="update `products` set `price`='".$data['product_price']."', `cost`='".$data['product_cost']."', `gst`='".$data['product_gst']."' where `id`='".$data['id']."'";
			$this->db->query($sql);
		}
		else
		{
				$date=date('Y-m-d H:i:s');
				$sql="select * from `products` where `id`='".$data['id']."'";
				$query=$this->db->query($sql);
				$product=$query->row_array();
				
				if($product['price']!=$data['product_price'] || $product['cost']!=$data['product_cost'])
				{
					$sqlSel="select * from `products_clients` where `product_id`='".$data['id']."' and `client_id`='".$data['client_id']."'";
					$querySel=$this->db->query($sqlSel);
					
					if($product['price']==$data['product_price'] && $product['cost']!=$data['product_cost'])
					{
								$updatePrice=0;
								$updateCost=$data['product_cost'];
					}
					elseif($product['price']!=$data['product_price'] && $product['cost']==$data['product_cost'])
					{
								$updatePrice=$data['product_price'];
								$updateCost=0;
					}
					else
					{
								$updatePrice=$data['product_price'];
								$updateCost=$data['product_cost'];
					}
					
					
					if($querySel->num_rows()>0)
						{
							$sql="update `products_clients` set `price`='".$updatePrice."', `cost`='".$updateCost."' where `product_id`='".$data['id']."' and `client_id`='".$data['client_id']."'";
							$this->db->query($sql);
						}
						else
						{
							$sqlIns="insert into `products_clients` (`client_id`,`product_id`,`price`,`cost`,`date`) values(?,?,?,?,?)";
							$queryIns=$this->db->query($sqlIns,array($data['client_id'],$data['id'],$updatePrice,$updateCost,$date));
						}
					}
					else
					{
							$sqlDel="delete from `products_clients` where `product_id`='".$data['id']."' and `client_id`='".$data['client_id']."'";
							$this->db->query($sqlDel);
					}
		}
	}
	
	
	function addProductToClient($data)
	{
		if($data['productClient']=='0')
			$clients='';
		else
			{
				$clients=implode(',',$data['productClientList']);
				
				$sqlDel="delete from `products_clients` where `client_id` NOT IN (".$clients.") and `product_id`='".$data['id']."'";
				$this->db->query($sqlDel);
			}
		$sql="update `products` set `clients`='".$clients."' where `id`='".$data['id']."'";
		$this->db->query($sql);
	}
	
	function import($data)
	{
		$year=$data['importProductsYear'];
		$start_date=normalToMysqlDate($data['importProductsDate']);
		 
		 $sqlDate="insert into `products_price_date` (`year`, `date`)values(?,?)";
		 $this->db->query($sqlDate,array($year,$start_date));
		
		foreach($data['products']['values'] as $productK=>$product)
		{
			if($productK<6)
				continue;
			
			if($product['E']=='Default Product')
			{
				$sql="insert into `products` (`name`,`code`,`year`,`price`,`cost`,`date`,`clients`,`gst`,`xero_code`) values (?,?,?,?,?,?,?,?,?)";
				$productF=$product['F'];
				if($productF==0)
					$productF='';
				
				if($product['G']=='Inc.')
					$gst='1';
				else
					$gst='0';	
				
				$xero_code=$product['H'];
				if($xero_code==0)
					$xero_code='';
					
				$this->db->query($sql,array($product['A'], $product['A'], $year,$product['C'], $product['D'], date('Y-m-d H:i:s'), $productF, $gst, $xero_code));
			}
			else
			{
					$sqlSel="select * from`products` where `year`='".$year."' and `name`='".$product['A']."'";
					$querySel=$this->db->query($sqlSel);
					$resSel=$querySel->row_array();
					if(!empty($resSel))
					{
						
						if($resSel['price']!=$product['C'] || $resSel['cost']!=$product['D'])
						{
							$priceClient=$costClient=0;
							if($resSel['price']!=$product['C'])
								$priceClient=$product['C'];
							if($resSel['cost']!=$product['D']	)
								$costClient=$product['D'];
							
							$sql="insert into `products_clients` (`client_id`,`product_id`,`price`,`cost`,`date`) values (?,?,?,?,?)";
							$this->db->query($sql,array($product['E'], $resSel['id'], $priceClient, $costClient, date('Y-m-d H:i:s')));
						}
					}
			 }
		}
	}
	
	
	
	function clientsWithAgreementList($year)
	{
		$sql="select DISTINCT(`products_clients`.`client_id`) as `id`, `clients`.`bname` AS `bname`  from `products_clients` join `products` on(`products_clients`.`product_id`=`products`.`id`) JOIN `clients` ON ( `products_clients`.`client_id` = `clients`.`id` )  where `products`.`year`='".$year."' order by `bname`";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	
}