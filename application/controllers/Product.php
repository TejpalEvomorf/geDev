<?php
class Product extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('product');
		$this->load->model('client_model');
		$this->load->model('product_model');
	}
	
	function price($year=0)
	{
			if(checkLogin())
			{
				if($year==0)
				$year=date('Y');
			
				if($year>date('Y',strtotime('+1 year')) || $year<date('Y'))
					die("Forbidden");
					
				$data['page']='prices';
				$data['year']=$year;
				//$data['clients']=$this->client_model->clientsList();
				$data['clients']=$this->product_model->clientsWithAgreementList($year);
				$data['products']=productsList($year);
				$this->load->view('system/header',$data);
				$this->load->view('system/product/price');
				$this->load->view('system/footer');
			}
			else
				redirectToLogin();
	}
	
	function clientProductsList($client_id,$year)
	{
		if(checkLogin())
			{
				if($year==0)
				$year=date('Y');
				if($client_id=='all')
				{
					$defaultProducts=array();
					//$clients=$this->client_model->clientsList();
					$clients=$this->product_model->clientsWithAgreementList($year);
					$products=array();
					foreach($clients as $clientK=>$clientV)
					{
						$products=$this->product_model->clientProductsList($clientV['id'],$year);
						foreach($products as $productK=>$productV)
						{
							$products[$productK]['code']=$clientV['bname'].' '.$products[$productK]['code'];
							$products[$productK]['client_id']=$clientV['id'];
						}
						$defaultProducts=array_merge($defaultProducts,$products);
					}
					$data['products']=$defaultProducts;
				}
				elseif($client_id=='default')
					$data['products']=productsList($year);
				else
					$data['products']=$this->product_model->clientProductsList($client_id,$year);

				$data['client_id']=$client_id;
				$this->load->view('system/product/list',$data);
			}
			else
				echo "LO";
	}
	
	
	function addNewDefaultProductSubmit()
	{
		if(checkLogin())
			{
				$data=trimArrayValues($_POST);
				if($data['product_name']!=''  && $data['product_price']!='')
				{
					$this->product_model->addNewDefaultProduct($data);
					$data['products']=productsList($data['year']);
					$this->load->view('system/product/list',$data);
				}
			}
			else
				echo "LO";
	}
	
	function editProductForm($id,$client_id=0)
	{
		if(isset($id) && $id!='')
		{
			$data['client_id']=$client_id;
			$data['product']=$this->product_model->product_details($id,$client_id);
			if(!empty($data['product']))
				$this->load->view('system/product/product_edit',$data);
		}
	}
	
	function editProductSubmit()
	{
		if(checkLogin())
			{
				$data=trimArrayValues($_POST);
				if($data['id']!='' && $data['product_price']!='')
				{
					$this->product_model->editProduct($data);
					if(!isset($data['client_id']))
					{
						$data['products']=productsList($data['year']);
						$this->load->view('system/product/list',$data);
					}
				}
			}
			else
				echo "LO";
	}
	
	
	function addProductToClient($id)
	{
		if($id!='')
		{
			$data['clients']=$this->client_model->clientsList();
			$data['product']=$this->product_model->product_details($id,0);
			if(!empty($data['product']))
				$this->load->view('system/product/addProductToClient',$data);
		}
	}
	
	function addProductToClientSubmit()
	{
		if(checkLogin())
			{
				$data=$_POST;
				if($data['id']!='' && $data['productClient']!='')
					$this->product_model->addProductToClient($data);
			}
			else
				echo "LO";
	}
	
	function export($year='')
	{
			if($year=='' || $year>date('Y',strtotime('+1 year')) || $year<date('Y'))
				die('Forbidden');
			
			$defaultProducts=productsList($year);
			//$clients=$this->client_model->clientsList();
			$clients=$this->product_model->clientsWithAgreementList($year);
			$products=array();
			foreach($clients as $clientK=>$clientV)
			{
				$products=$this->product_model->clientProductsList($clientV['id'],$year);
				foreach($products as $productK=>$productV)
				{
					$products[$productK]['code']=$clientV['bname'].' '.$products[$productK]['code'];
					$products[$productK]['client_id']=$clientV['id'];
				}
				$defaultProducts=array_merge($defaultProducts,$products);
			}
			//see($defaultProducts);
			
			$this->load->library('excel');
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle('Pricing '.$year);
	
			$this->excel->getActiveSheet()->getDefaultStyle()->applyFromArray(array(
				'font'=>array(
				'name'      =>  'Arial',
				'size'      =>  10,
			)
		));
		
		$excel_table_headings_array=array(
		  'A'=>'Product name',
		  'B'=>'Product code',
		  'C'=>'Price',
		  'D'=>'Cost',
		  'E'=>'Client Id',
		  'F'=>'Extra',
		  'G'=>'GST',
		  'H'=>'Xero code'
		  );
		  
		end($excel_table_headings_array);         // move the internal pointer to the end of the array
		$lastCol = key($excel_table_headings_array);
	
		for($c='A';$c<=$lastCol;$c++)
			$this->excel->getActiveSheet()->getColumnDimension($c)->setAutosize(true);	

		$this->excel->getActiveSheet()->setCellValue('A2', 'GLOBAL EXPERIENCE');
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(10)->setBold(true);
		$this->excel->getActiveSheet()->mergeCells('A2:'.$lastCol.'2');
		$this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$this->excel->getActiveSheet()->setCellValue('A3', 'Product prices for the year '.$year);
		$this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(10)->setBold(true);
		$this->excel->getActiveSheet()->mergeCells('A3:'.$lastCol.'3');
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
		
		$x_start=5;
		$x=$x_start;
		
		foreach($excel_table_headings_array as $k=>$v)
			$this->excel->getActiveSheet()->setCellValue($k.$x_start, $v);
		
		//$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastCol.$x_start)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border:: BORDER_THIN);
		$this->excel->getActiveSheet()->getStyle('A'.$x_start.':'.$lastCol.$x_start)->getFont()->setSize(10)->setBold(true);	
		
		$x++;
		foreach($defaultProducts as $dfV)
		{
			$this->excel->getActiveSheet()->setCellValue('A'.$x, $dfV['name']);
			$this->excel->getActiveSheet()->setCellValue('B'.$x, $dfV['code']);
			$this->excel->getActiveSheet()->setCellValue('C'.$x, $dfV['price']);
			
			$cost=$dfV['cost'];	
			$client_id='Default Product';
			
			if(isset($dfV['client_id']))
				$client_id=$dfV['client_id'];
			
			$gst=0;
			if(!isset($dfV['client_id']))
				{
					if($dfV['gst']=='1')
						$gst='Inc.';
					else	
						$gst='Free';
				}
				
				
			$this->excel->getActiveSheet()->setCellValue('D'.$x, $cost);
			$this->excel->getActiveSheet()->setCellValue('E'.$x, $client_id);
			
			$extra	='0';
			if(isset($dfV['clients']) && $dfV['clients']!='' && !isset($dfV['client_id']))
				$extra	=$dfV['clients'];
			
			$this->excel->getActiveSheet()->setCellValue('F'.$x, $extra);
			$this->excel->getActiveSheet()->setCellValue('G'.$x, $gst);
			
			$xero_code=0;
			if(!isset($dfV['client_id']))
			{
				$xero_code=$dfV['xero_code'];
				if($xero_code=='')
					$xero_code=0;
			}
			$this->excel->getActiveSheet()->setCellValue('H'.$x, $xero_code);
			
			$x++;
		}
		
		
	$filename='Pricing '.$year.'.xls'; //save our workbook as this file name
	header('Content-Type: application/vnd.ms-excel'); //mime type
	header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	header('Cache-Control: max-age=0'); //no cache
				 
	//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
	//if you want to save it as .XLSX Excel 2007 format
	$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
	//force user to download the Excel file without writing it to server's HD
	$objWriter->save('php://output');
		
	}
	
	function import()
	{
			if(checkLogin())
			{
				if($_FILES['importProductsFile']['name']!= "" && !empty($_POST))
				  {
						$path="./static/uploads/products"; 
						$imagename='products.xls';		
						move_uploaded_file($_FILES['importProductsFile']['tmp_name'],$path.'/'.$imagename);
						
						$data=$_POST;
						$data['products']=readCsv($path.'/'.$imagename);
						
						if(!empty($data['products']))
							$this->product_model->import($data);
						header('location:'.site_url().'product/price/'.$data['importProductsYear'].'/#imported');	
						
				  }
			}
			else
				redirectToLogin();
	}
	
	function import2()
	{
			if(checkLogin())
			{
				
						$path="./static/uploads/products"; 
						$imagename='products1.xls';		
						
						$_POST['importProductsYear']='2018';
						$data=$_POST;
						$data['products']=readCsv($path.'/'.$imagename);
						see($data['products']);die();
						if(!empty($data['products']))
							$this->product_model->import($data);
						else
							echo "empty";	
			}
			else
				redirectToLogin();
						
		
	}
	
}
		?>