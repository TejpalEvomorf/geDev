<?php
/* @property phpword_model $phpword_model */
include_once(APPPATH."third_party/PhpWord/Autoloader.php");
include_once(APPPATH."core/Front_end.php");

use PhpOffice\PhpWord\Autoloader;
use PhpOffice\PhpWord\Settings;
Autoloader::register();
Settings::loadConfig();
class Phpword extends Front_end {

	function __construct(){
	  parent::__construct();
		//$this->load->model('phpword_model');

    }

	
	function invoiceReport()
	{
		$data=$_POST;
		/*$data['invoiceReport_fromDate']='2019-02-01';
		$data['invoiceReport_toDate']='2019-05-01';
		$data['invoiceReport_client']='1472';*/
		$this->load->model('report_model');
		$res['invoiceItems']=$this->report_model->invoiceReportResult($data);//echo $this->db->last_query();
		$res['client']=clientDetail($data['invoiceReport_client']);
		
		$phpWord = new \PhpOffice\PhpWord\PhpWord();
		$phpWord->getCompatibility()->setOoxmlVersion(14);
		$phpWord->getCompatibility()->setOoxmlVersion(15);
		
		//Client details #STARTS
		$section = $phpWord->addSection();
		$section->addText('Client: '.$res['client']['bname'], array('name'=> 'calibri','size' => 18),array('align' => 'left', 'spaceAfter' => 10));
		$section->addTextBreak(1);
		$section->addText('Primary contact details', array('bold' => true,'name'=> 'calibri','size' => 10),array('align' => 'left', 'spaceAfter' => 10));
		$section->addText($res['client']['primary_contact_name'].' '.$res['client']['primary_contact_lname'], array('name'=> 'calibri','size' => 10),array('align' => 'left', 'spaceAfter' => 10));
		$section->addText($res['client']['primary_email'].', '.$res['client']['primary_phone'], array('name'=> 'calibri','size' => 10),array('align' => 'left', 'spaceAfter' => 10));
		$section->addTextBreak(1);
		
		$textrun = $section->addTextRun();
		$textrun->addText("Date of issue: ",array('bold' => true,'name'=> 'calibri','size' => 12),array('align' => 'left', 'spaceAfter' => 10));
		$textrun->addText(dateFormat(date('Y-m-d')),array('name'=> 'calibri','size' => 12),array('align' => 'right', 'spaceAfter' => 10));
		//Client details #ENDS
		
		//Table styles #STARTS
		$styleTable = array('borderColor'=>'#CCC', 'borderSize'=> 2, 'cellMargin'=>50, 'valign'=>'center');
		$styleFirstRow = array('name'=> 'calibri','bgColor'=>'#CCC', 'bold'=>true, 'size'=>12, 'valign'=>'center');
		$styleContentRow = array('name'=> 'calibri','bgColor'=>'#CCC', 'size'=>10, 'valign'=>'center');
		$styleCell = array('valign'=>'center');
		$fontStyle = array('bold'=>false, 'align'=>'center', 'color'=>'ccc');
		$phpWord->addTableStyle('myTable', $styleTable, $styleFirstRow);
		//Table styles #ENDS
		
		
		//Tax invoice Table #STARTS
		$section = $phpWord->createSection();
		$section->addTextBreak(1);
		$section->addLine(
			array(
			'width' => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(16),
			'height' => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(0),
			)
		);
		$section->getStyle()->setBreakType('continuous');
		$section->addTextBreak(1);
		$section->addText('Tax Invoice', array('name'=> 'calibri','size' => 18),array('align' => 'left', 'spaceAfter' => 10));
		$section->addTextBreak(1);
		
		
		/////
		$gstPercent=gstPercent();
		$placementFee=0;
		$accomodationFee=0;
		$apuFee=0;
		foreach($res['invoiceItems'] as $iItem)
		{
			if($iItem['type']=='placement')
				$placementFee +=$iItem['total'];
			if($iItem['type']=='accomodation' || $iItem['type']=='accomodation_ed')
				$accomodationFee +=$iItem['total'];
			if($iItem['type']=='apu' || $iItem['type']=='accomodation_ed')
				$apuFee +=$iItem['total'];
		}
		
		$placementFeeExclAmount=getGstExclAmount($placementFee,$gstPercent);
		$placementFeeGstAmount=getGstAmount($placementFee,$gstPercent);
		$accomodationFeeExclAmount=getGstExclAmount($accomodationFee,$gstPercent);
		$accomodationFeeGstAmount=getGstAmount($accomodationFee,$gstPercent);
		$apuFeeExclAmount=getGstExclAmount($apuFee,$gstPercent);
		$apuFeeGstAmount=getGstAmount($apuFee,$gstPercent);
		
		$amoutGstExclTotal=$placementFeeExclAmount+$accomodationFeeExclAmount+$apuFeeExclAmount;
		$amoutGstTotal=$placementFeeGstAmount+$accomodationFeeGstAmount+$apuFeeGstAmount;
		$amoutTotal=$placementFee+$accomodationFee+$apuFee;
		//////
		
		
		$table = $section->addTable('myTable');
		$table->addRow(100);
		$table->addCell(5000, $styleCell)->addText('Description',$styleFirstRow);
		$table->addCell(1500, $styleCell)->addText('Subtotal', $styleFirstRow);
		$table->addCell(1500, $styleCell)->addText('Tax', $styleFirstRow);
		$table->addCell(1500, $styleCell)->addText('Total', $styleFirstRow);
		
		
		
			$table->addRow(100);
			$table->addCell(5000, $styleCell)->addText('Placement fee',$styleContentRow);
			$table->addCell(1500, $styleCell)->addText('$'.add_decimal($placementFeeExclAmount),$styleContentRow);
			$table->addCell(1500, $styleCell)->addText('$'.add_decimal($placementFeeGstAmount),$styleContentRow);
			$table->addCell(1500, $styleCell)->addText('$'.add_decimal($placementFee),$styleContentRow);
			
			$table->addRow(100);
			$table->addCell(5000, $styleCell)->addText('Homestay service fee',$styleContentRow);
			$table->addCell(1500, $styleCell)->addText('$'.add_decimal($accomodationFeeExclAmount),$styleContentRow);
			$table->addCell(1500, $styleCell)->addText('$'.add_decimal($accomodationFeeGstAmount),$styleContentRow);
			$table->addCell(1500, $styleCell)->addText('$'.add_decimal($accomodationFee),$styleContentRow);
			
			$table->addRow(100);
			$table->addCell(5000, $styleCell)->addText('Airport pickup service',$styleContentRow);
			$table->addCell(1500, $styleCell)->addText('$'.add_decimal($apuFeeExclAmount),$styleContentRow);
			$table->addCell(1500, $styleCell)->addText('$'.add_decimal($apuFeeGstAmount),$styleContentRow);
			$table->addCell(1500, $styleCell)->addText('$'.add_decimal($apuFee),$styleContentRow);
		
		
		$table->addRow(100);
		$table->addCell(5000, $styleCell)->addText('Subtotal',$styleFirstRow);
		$table->addCell(1500, $styleCell)->addText('$'.add_decimal($amoutGstExclTotal),$styleFirstRow);
		$table->addCell(1500, $styleCell)->addText('$'.add_decimal($amoutGstTotal),$styleFirstRow);
		$table->addCell(1500, $styleCell)->addText('$'.add_decimal($amoutTotal),$styleFirstRow);
		//Tax invoice Table #ENDS
		
		/////Guest table #STARTS
		$section = $phpWord->createSection();
		$section->addTextBreak(1);
		$section->addLine(
			array(
			'width' => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(16),
			'height' => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(0),
			)
		);
		$section->getStyle()->setBreakType('continuous');
		
		$section->addText('Guests', array('name'=> 'calibri','size' => 18),array('align' => 'left', 'spaceAfter' => 10));
		$section->addTextBreak(1);
		
		$table = $section->addTable('myTable');
		$table->addRow(100);
		$table->addCell(1500, $styleCell)->addText('Invoice no.',$styleFirstRow);
		$table->addCell(5500, $styleCell)->addText('Item description', $styleFirstRow);
		$table->addCell(1000, $styleCell)->addText('Amount', $styleFirstRow);
		$table->addCell(1000, $styleCell)->addText('Tax', $styleFirstRow);
		$table->addCell(1000, $styleCell)->addText('Total', $styleFirstRow);
	
		$amountTotal=$amountGstExclTotal=$amountGstTotal=0;
		foreach($res['invoiceItems'] as $item)
		{
			$gstExclAmount=getGstExclAmount($item['total'],$gstPercent);
			$gstAmount=getGstAmount($item['total'],$gstPercent);
			
			$amountTotal +=$item['total'];
			$amountGstExclTotal +=$gstExclAmount;
			$amountGstTotal +=$gstAmount;
		
			$table->addRow(100);
			$table->addCell(1500, $styleCell)->addText('I-'.$item['invoice_id'],$styleContentRow);
			$table->addCell(5500, $styleCell)->addText($item['desc'],$styleContentRow);
			$table->addCell(1000, $styleCell)->addText('$'.add_decimal($gstExclAmount),$styleContentRow);
			$table->addCell(1000, $styleCell)->addText('$'.add_decimal($gstAmount),$styleContentRow);
			$table->addCell(1000, $styleCell)->addText('$'.add_decimal($item['total']),$styleContentRow);
		}
		
		
		$table->addRow(100);
		$table->addCell(1500, $styleCell)->addText('Total',$styleFirstRow);
		$table->addCell(5500, $styleCell)->addText('',$styleFirstRow);
		$table->addCell(1000, $styleCell)->addText('$'.add_decimal($amountGstExclTotal), $styleFirstRow);
		$table->addCell(1000, $styleCell)->addText('$'.add_decimal($amountGstTotal), $styleFirstRow);
		$table->addCell(1000, $styleCell)->addText('$'.add_decimal($amountTotal), $styleFirstRow);
		/////Guest table #ENDS
		
		
		
		header('Content-Type: application/octet-stream');
		//header('Content-Disposition: attachment;filename="convert.docx"');
		header('Content-Disposition: attachment;filename="static/report/InvoiceReport.docx"');
		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
		//$objWriter->save('php://output');
		$objWriter->save('static/report/InvoiceReport.docx');
	}
	
	
}
/* End of file dashboard.php */
/* Location: ./system/application/modules/matchbox/controllers/dashboard.php */