<style type="text/css">
/*
Full screen Modal 
*/
.fullscreen-modal .modal-dialog {
  /*margin: 0;
  margin-right: auto;
  margin-left: auto;
  width: 53%;
  height:45%;*/
}
.fullscreen-modal .modal-dialog .modal-content {
  height:100%;
}
.tooltip-inner {
  max-width: 500px;
}
</style>

<?php
$initialInvoiceStatusList=initialInvoiceStatusList();
$invoiceSyncSummary=$this->session->flashdata('invoiceSyncSummary');
?>
<div class="page-heading">
      <h1>
	  <?php 
	  	if($initial_invoice_status=='0')
	  		echo 'All initial invoices';
		else if($initial_invoice_status=='1')
	  		echo 'Pending';
		else if($initial_invoice_status=='2')	
			echo 'Partially paid';
		else
			echo 'Paid';
		?>
		</h1>
        
         <!--Sync button #STARTS-->
            <div class="pull-right syncInitialInvoicesBtn">
                <button class="btn btn-danger syncInitialInvoicesBtn" id="syncInitialInvoicesBtn" onclick="syncInitialInvoiceWithXero();">
                <i class="fa fa-refresh" style="font-size:11px; margin-right:3px;"></i>Sync with Xero</button>
            </div>
        <!--Sync status button #ENDS-->
        
        
          <div class="m-n DTTT btn-group pull-right" >
            <a class="btn btn-default" id="invoiceFiltersBtn">
             <i class="colorBlue fa fa-filter"></i>
             <span class="colorBlue">Filters</span>
           </a>
         </div>
        
        
</div>

<?php if(!empty($_GET['number']) || !empty($_GET['client']) || !empty($_GET['student']) || !empty($_GET['from']) || !empty ($_GET['to']) || (isset($_GET['other']) && $_GET['other']!='') || !empty($_GET['studyTour'])){?>
<div class="filterbtnhol">
  <button class="mt-n btn btn-xs btn-danger btn-label invoiceRemoveFilter pull-right" href="#" filter="all">
    <i class="fa fa-close"></i> Reset all
  </button>
  
    <?php if(!empty($_GET['number'])){ ?>
    <button class="mt-n btn btn-xs btn-danger btn-label invoiceRemoveFilter pull-right" href="#" filter="number">
      <i class="fa fa-close"></i>
      Invoice number
    </button>
    <?php }?>
    
    <?php if(!empty($_GET['client'])){ ?>
    <button class="mt-n btn btn-xs btn-danger btn-label invoiceRemoveFilter pull-right" href="#" filter="client">
      <i class="fa fa-close"></i>
      Client
    </button>
    <?php }?>
    
    <?php if(!empty($_GET['student'])){ ?>
    <button class="mt-n btn btn-xs btn-danger btn-label invoiceRemoveFilter pull-right" href="#" filter="student">
      <i class="fa fa-close"></i>
      Student name
    </button>
    <?php }?>
    
    <?php if(!empty($_GET['from']) || !empty($_GET['to'])){ ?>
    <button class="mt-n btn btn-xs btn-danger btn-label invoiceRemoveFilter pull-right" href="#" filter="from">
      <i class="fa fa-close"></i>
      Date range
    </button>
    <?php }?>
    
    <?php if(isset($_GET['other']) && $_GET['other']!=''){ 
		$otherFilterText='';
		if($_GET['other']=='1')
				$otherFilterText='Tour group invoices';
		if($_GET['other']=='2')
				$otherFilterText='Non tour group invoices';		
		if($_GET['other']=='3')
				$otherFilterText='Cancelled invoices';
		if($_GET['other']=='4')
				$otherFilterText='Invoices moved to xero';		
		if($_GET['other']=='5')
				$otherFilterText='Invoices not moved to xero';
		if($_GET['other']=='6')
				$otherFilterText='Invoices having seperate student invoice';		
		if($_GET['other']=='7')
				$otherFilterText='Invoices with warnings';				
	?>
    <button class="mt-n btn btn-xs btn-danger btn-label invoiceRemoveFilter pull-right" href="#" filter="other">
      <i class="fa fa-close"></i>
      <?=$otherFilterText?>
    </button>
    <?php }?>
    
   <?php if(!empty($_GET['studyTour'])){ 
	$tile_tourDetail=tourDetail($_GET['studyTour']);
	?>
    <button class="mt-n btn btn-xs btn-danger btn-label invoiceRemoveFilter pull-right" href="#" filter="studyTour">
      <i class="fa fa-close"></i>
      <?='Tour group: '.$tile_tourDetail['group_name']?>
    </button>
    <?php }?>
    
</div>
<?php } ?>

<div class="container-fluid">
                                
    <div data-widget-group="group1">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <!--<div class="panel-heading">
                        <h2>Data Tables</h2>
                        
                    </div>-->
                    <div class="panel-body no-padding">
                        <table id="pendingInvoiceList" class="noborder0 table table-striped table-bordered table-fixed-header m-n" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                        <th>Invoice no.</th>
                                        <th>Client</th>
                                        <th>Student</th>
                                        <th>Invoice details</th>
                                        <th>Office use</th>
                                        <th width="60px">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
								/*$gst=0;
                                foreach($invoices as $invoice)
								{
									$initialInvoiceListTd=initialInvoiceListTd($invoice,$initial_invoice_status);
									
									if($invoice['study_tour']=='0')
									{
										$student=getShaOneAppDetails($invoice['application_id']);
										if(empty($student))
											continue;
										$student['three']=getShaThreeAppDetails($invoice['application_id']);
										$client=clientDetail($student['client']);											
									}
									else	
									  {
										  $tourDetail=tourDetail($invoice['application_id']);
										  $client=clientDetail($tourDetail['client_id']);
									  }

								?>
                                <tr class="odd gradeX" id="invoice-<?=$invoice['id']?>">
                                  <td><?=$initialInvoiceListTd['td1']?></td>
                                  <td>
                                  		<a href="<?=site_url()?>client/edit/<?=$client['id']?>" target="_blank"><?=$client['bname']?></a>
										<?='<br>'.$client['primary_contact_name'].' '.$client['primary_contact_lname']?>
										<?='<br>'.$client['primary_phone']?>
									</td>
                                  <td>
                                  <?php if($invoice['study_tour']=='0'){?>
	                                    <a href="<?=site_url()?>sha/application/<?=$invoice['application_id']?>" target="_blank"><?=$student['fname'].' '.$student['lname']?></a>
                                        <?php 
												echo '<br><a class="mailto" href="mailto:'.$student['email'].'">'.$student['email'].'</a>';
												echo "<br>";
                                        	echo $student['mobile'];
								  }
								  else
								  {?>
	                                    
                                        Tour: <a href="<?=site_url()?>tour/all_students/<?=$tourDetail['id']?>" target="_blank"><?=$tourDetail['group_name']?></a>
                                        <?php 
												echo '<br><a class="mailto" href="mailto:'.$tourDetail['group_contact_email'].'">'.$tourDetail['group_contact_email'].'</a><br>'.$tourDetail['group_contact_phone_no'];
										}
										?>
                                  </td>
                                  <td><?=$initialInvoiceListTd['td4']?></td>
                                  <td class="middle-alignment officeUseTd"><?=$initialInvoiceListTd['td_officeUse']?></td>
                                  <td>
                                       <div class="btn-group dropdown table-actions">
                                        <button class="btn btn-sm btn-midnightblue dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="true">
                                            <i class="colorBlue material-icons">more_horiz</i>
                                            <div class="ripple-container"></div>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-sidebar" role="menu">
                                            <li>
                                            	<?php if($invoice['moved_to_xero']==0 && $invoice['cancelled']!='1'){?>
	                                            	<a href="javascript:void(0);" class="moveInvoiceToXero" data-toggle="modal" data-target="#model_moveInitialInvoiceToXero" onclick="$('#moveInitialInvoiceToXero_id').val($(this).parents('tr').attr('id'));"><i class="font16 material-icons">redo</i>&nbsp;&nbsp;Move to Xero</a>
                                                <?php } ?>
                                            </li>
                                            <li>
                                                <a href="<?=site_url()?>invoice/view_initial/<?=$invoice['id']?>" target="_blank"><i class="font16 material-icons">view_quilt</i>&nbsp;&nbsp;View invoice data</a>
                                            </li>
                                            <?php 
											if(isset($invoice['items_standard']))
											{
											?>
                                             <li>
                                                <a href="<?=site_url()?>invoice/view_initial_student/<?=$invoice['id']?>" target="_blank"><i class="font16 material-icons">view_quilt</i>&nbsp;&nbsp;View student invoice data</a>
                                            </li>
                                            <?php } ?>
                                            </ul>
                                        </div>
                                  </td>
                              </tr>
                                <?php } */?>
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<form id="invoiceFiltersFormHidden">
  <?php
  if(isset($_GET['number']))
   $InoiceFilter_number=$_GET['number'];
 else
   $InoiceFilter_number=''; 

   if(isset($_GET['client']))
  	 $InoiceFilter_client=$_GET['client'];
	else
   	$InoiceFilter_client='';

   if(isset($_GET['student']))
  	 $InoiceFilter_student=$_GET['student'];
	else
   	$InoiceFilter_student='';

   if(isset($_GET['from']))
  	 $InoiceFilter_from=$_GET['from'];
	else
   	$InoiceFilter_from='';	

   if(isset($_GET['to']))
  	 $InoiceFilter_to=$_GET['to'];
	else
   	$InoiceFilter_to='';	
	
	if(isset($_GET['other']))
  	 $InoiceFilter_other=$_GET['other'];
	else
   	$InoiceFilter_other='';		

   if(isset($_GET['studyTour']))
  	 $InoiceFilter_studyTour=$_GET['studyTour'];
	else
   	$InoiceFilter_studyTour='';	
 ?>
    <input type="hidden" name="number" value="<?=$InoiceFilter_number?>" />
    <input type="hidden" name="client" value="<?=$InoiceFilter_client?>" />
    <input type="hidden" name="student" value="<?=$InoiceFilter_student?>" />
    <input type="hidden" name="from" value="<?=$InoiceFilter_from?>" />
    <input type="hidden" name="to" value="<?=$InoiceFilter_to?>" />
    <input type="hidden" name="other" value="<?=$InoiceFilter_other?>" />
    <input type="hidden" name="invoiceType" value="initial" />
    <input type="hidden" name="studyTour" value="<?=$InoiceFilter_studyTour?>" />
</form>

<script type="text/javascript">
$(document).ready(function(){
	if('<?=$invoiceSyncSummary?>'!='')
		{
			$('#model_syncInitialInvoicesXero').modal('toggle');
			$('#syncInvoicesUpToDate, #syncInvoicesPartial, #syncInvoicesAppMovedP2U, #syncInvoicesSTourMovedP2U, #syncInvoicesPartialUpdated, #syncInvoicesPaid, #syncInvoicesAppMovedP2P, #syncInvoicesAppMovedU2P, #syncInvoicesSTourMovedP2P, #syncInvoicesSTourMovedU2U').hide()
		
		  var dataSplit='<?=$invoiceSyncSummary?>'.split(',');
		  if(dataSplit[0]!=0)
			  $('#syncInvoicesPartial').text(dataSplit[0]+' invoice(s) moved to partially paid invoices').show();
		  if(dataSplit[1]!=0)
			  $('#syncInvoicesAppMovedP2U').text(dataSplit[1]+' student application(s) moved from Pending to Approved unpaid').show();
		  if(dataSplit[2]!=0)
			  $('#syncInvoicesSTourMovedP2U').text(dataSplit[2]+' tour group(s) moved from Pending to Approved unpaid').show();		  
		  if(dataSplit[3]!=0)
			  $('#syncInvoicesPartialUpdated').text(dataSplit[3]+' invoice(s) updated in partially paid invoices').show();		  
		  if(dataSplit[4]!=0)
			  $('#syncInvoicesPaid').text(dataSplit[4]+' invoice(s) moved to paid invoices').show();		  
		  if(dataSplit[5]!=0)
			  $('#syncInvoicesAppMovedP2P').text(dataSplit[5]+' student application(s) moved from Approved unpaid to Approved paid').show();
		  if(dataSplit[6]!=0)
			  $('#syncInvoicesAppMovedU2P').text(dataSplit[6]+' student application(s) moved from Pending to Approved paid').show();
		  if(dataSplit[7]!=0)
			  $('#syncInvoicesSTourMovedP2P').text(dataSplit[7]+' tour group(s) moved from Approved unpaid to Approved paid').show();
		  if(dataSplit[8]!=0)
			  $('#syncInvoicesSTourMovedU2P').text(dataSplit[8]+' tour group(s) moved from Pending to Approved paid').show();
		  
		 if(dataSplit[0]==0 && dataSplit[1]==0 && dataSplit[2]==0 && dataSplit[3]==0 && dataSplit[4]==0 && dataSplit[5]==0 && dataSplit[6]==0 && dataSplit[7]==0 && dataSplit[8]==0)
			  $('#syncInvoicesUpToDate').show();
			
			$('#syncInitialInvoicesPopProcess').hide();
			$('#syncInitialInvoicesSuccess').show();
		}
});
</script>

			<div class="modal fade " id="model_moveInitialInvoiceToXero" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h2 class="modal-title">Move to xero</h2>
							</div>
                            
                            <div class="modal-body">
                               Are you sure you wish to move this invoice to Xero?
                               <input type="hidden" id="moveInitialInvoiceToXero_id" value="" />
                               <input type="hidden" id="moveInitialInvoiceToXero_pageStatus" value="<?=$initial_invoice_status?>" />
                            </div>
							<div class="modal-footer">
								<button type="button" class="btn btn-success btn-raised" id="moveInitialInvoiceToXeroSubmit">Yes</button>
                                <img src="<?=loadingImagePath()?>" id="moveInitialInvoiceToXeroProcess" style="margin-right:16px;display:none;">
                            </div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->

			</div>
            
         
         <div class="modal fade fullscreen-modal " id="model_syncInitialInvoicesXero" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
                         <div class="modal-header">
                         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                         <h2 class="modal-title">Sync With Xero Successful</h2>
 		                 </div>
							<div class="modal-body">
                              <div id="syncInitialInvoicesSuccess" class="syncInitialInvoicesSuccess" style="display:none;">
                              
                              <div class="warningRowParentSync">
                              <div class="warningRow">
                                <div class="warningColSnc" id="syncInvoicesUpToDate">All invoice data is already upto date</div>
                              </div>                              
                              </div>
                              
                              <div class="warningRowParentSync">
                              <div class="warningRow">
                                <div class="warningColSnc" id="syncInvoicesPartial"></div>
                              </div>
                              <div class="warningRowSnc colorLightgrey" id="syncInvoicesAppMovedP2U"></div>
                              <div class="warningRowSnc colorLightgrey" id="syncInvoicesSTourMovedP2U"></div>                              
                              </div>
                              
                              <div class="warningRowParentSync">
                               <div class="warningRow">
                                <div class="warningColSnc"  id="syncInvoicesPartialUpdated"></div>
                              </div>
                              </div>
                              
                              <div class="warningRowParentSync">
                               <div class="warningRow">
                                <div class="warningColSnc"  id="syncInvoicesPaid"></div>
                              </div>
                              
                              <div class="warningRowSnc colorLightgrey" id="syncInvoicesAppMovedU2P"></div>
                              <div class="warningRowSnc colorLightgrey" id="syncInvoicesAppMovedP2P"></div>
                              <div class="warningRowSnc colorLightgrey" id="syncInvoicesSTourMovedU2P"></div>                              
                              <div class="warningRowSnc colorLightgrey" id="syncInvoicesSTourMovedP2P"></div>

                              </div>
                              
                              </div>
							</div>
							<div class="modal-footer">
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
		</div>
        
        
        <!--cancel info pop #STARTS-->
          <div class="modal fade " id="model_initialInvoiceCancelInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h2 class="modal-title">Cancel information</h2>
							</div>
                            
                            <div class="modal-body">
                            </div>
							
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->

			</div>
        <!--cancel info pop #ENDS-->
<script type="text/javascript">
var initial_invoice_statusPage='<?=$initial_invoice_status?>';
var InoiceFilter_number='<?=$InoiceFilter_number?>';
var InoiceFilter_from='<?=$InoiceFilter_from?>';
var InoiceFilter_to='<?=$InoiceFilter_to?>';
var InoiceFilter_client='<?=$InoiceFilter_client?>';
var InoiceFilter_studyTour='<?=$InoiceFilter_studyTour?>';
var InoiceFilter_student='<?=$InoiceFilter_student?>';
var InoiceFilter_other='<?=$InoiceFilter_other?>';
</script>        