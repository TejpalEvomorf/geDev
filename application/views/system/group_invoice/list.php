<?php
$invoiceSyncSummary=$this->session->flashdata('invoiceSyncSummary');
?>
<div class="page-heading">
      <h1>
      <?php
	  	if($initial_invoice_status=='1')
		  echo "Pending";
		elseif($initial_invoice_status=='2')
		  echo "Partially paid";
		elseif($initial_invoice_status=='3')
		  echo "Paid";
	    else
		  echo "All invoices"; 
		?>
      </h1>
        
         <!--Sync button #STARTS-->
            <div class="pull-right syncInitialInvoicesBtn">
                <button class="btn btn-danger syncInitialInvoicesBtn" id="syncInitialInvoicesBtn" onclick="syncGroupInvoiceWithXero();">
                <i class="fa fa-refresh" style="font-size:11px; margin-right:3px;"></i>Sync with Xero</button>
            </div>
        <!--Sync status button #ENDS-->
        
        
          <div class="m-n DTTT btn-group pull-right" >
            <a class="btn btn-default" id="GroupInvoiceFiltersBtn">
             <i class="colorBlue fa fa-filter"></i>
             <span class="colorBlue">Filters</span>
           </a>
         </div>
         
         <?php if($client['group_invoice_accomodation_fee']=='0'){?>
		  <div class="m-n DTTT btn-group pull-right" data-toggle="modal" data-target="#model_ImportGroupInvCsv" data-backdrop="static" data-keyboard="false" onclick="$('#paymentImportSummary').hide();$('#group-invoice-upload').show();">
            <a class="btn btn-default" id="GroupInvoiceImportBtn">
             <i class="colorBlue fa fa-upload"></i>
             <span class="colorBlue">Import CSV</span>
           </a>
         </div>
        <?php } ?>
        
</div>


<?php if((isset($_GET['number']) && isset($_GET['from']) && isset($_GET['to'])) && ($_GET['number']!='' || $_GET['from']!='' || $_GET['to']!='')){?>
<div class="filterbtnhol">
  <button class="mt-n btn btn-xs btn-danger btn-label invoiceRemoveFilter pull-right" href="#" filter="all">
    <i class="fa fa-close"></i> Reset all
  </button>
  
    <?php if($_GET['number']!=''){ ?>
    <button class="mt-n btn btn-xs btn-danger btn-label invoiceRemoveFilter pull-right" href="#" filter="number">
      <i class="fa fa-close"></i>
      Invoice number
    </button>
    <?php }?>
    
    <?php if($_GET['from']!='' || $_GET['to']!=''){ ?>
    <button class="mt-n btn btn-xs btn-danger btn-label invoiceRemoveFilter pull-right" href="#" filter="from">
      <i class="fa fa-close"></i>
      Date range
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
                                        <th>Invoice details</th>
                                        <th>Office use</th>
                                        <th width="60px">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
								$gst=0;
                                foreach($invoices as $invoice)
								{
									$initialInvoiceListTd=initialGroupInvoiceListTd($invoice,$initial_invoice_status);
									
									//$client=clientDetail($invoice['client']);
								?>
                                <tr class="odd gradeX" id="invoice-<?=$invoice['id']?>">
                                  <td><?=$initialInvoiceListTd['td1']?></td>
                                  <td>
                                  		<a href="<?=site_url()?>client/edit/<?=$client['id']?>" target="_blank"><?=$client['bname']?></a>
										<?='<br>'.$client['primary_contact_name'].' '.$client['primary_contact_lname']?>
										<?='<br>'.$client['primary_phone']?>
									</td>
                                  
                                  <td><?=$initialInvoiceListTd['td_invDetails']?></td>
                                  <td class="middle-alignment officeUseTd"><?=$initialInvoiceListTd['td_officeUse']?></td>
                                  <td>
                                       <div class="btn-group dropdown table-actions">
                                        <button class="btn btn-sm btn-midnightblue dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="true">
                                            <i class="colorBlue material-icons">more_horiz</i>
                                            <div class="ripple-container"></div>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-sidebar" role="menu">
                                            <li>
                                            	<?php if($invoice['moved_to_xero']==0 && $invoice['imported']!='1'){?>
	                                            	<a href="javascript:void(0);" class="moveInvoiceToXero" data-toggle="modal" data-target="#model_moveInitialInvoiceToXero" onclick="$('#moveInitialInvoiceToXero_id').val($(this).parents('tr').attr('id'));"><i class="font16 material-icons">redo</i>&nbsp;&nbsp;Move to Xero</a>
                                                <?php } ?>
                                            </li>
                                            <li>
                                                <a href="<?=site_url()?>group_invoice/view/<?=$invoice['id']?>" target="_blank"><i class="font16 material-icons">view_quilt</i>&nbsp;&nbsp;View invoice data</a>
                                            </li>
                                            </ul>
                                        </div>
                                  </td>
                              </tr>
                                <?php } ?>
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

   if(isset($_GET['from']))
  	 $InoiceFilter_from=$_GET['from'];
	else
   	$InoiceFilter_from='';	

   if(isset($_GET['to']))
  	 $InoiceFilter_to=$_GET['to'];
	else
   	$InoiceFilter_to='';	
 ?>
    <input type="hidden" name="number" value="<?=$InoiceFilter_number?>" />
    <input type="hidden" name="from" value="<?=$InoiceFilter_from?>" />
    <input type="hidden" name="to" value="<?=$InoiceFilter_to?>" />
</form>




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
                    <button type="button" class="btn btn-success btn-raised" id="moveGroupInitialInvoiceToXeroSubmit">Yes</button>
                    <img src="<?=loadingImagePath()?>" id="moveInitialInvoiceToXeroProcess" style="margin-right:16px;display:none;">
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</div>

		<script type="text/javascript">
        $(document).ready(function(){
            if('<?=$invoiceSyncSummary?>'!='')
                {
                    $('#model_syncInitialInvoicesXero').modal('toggle');
                    $('#syncInvoicesUpToDate, #syncInvoicesPartial, #syncInvoicesAppMovedP2U, #syncInvoicesPartialUpdated, #syncInvoicesPaid, #syncInvoicesAppMovedP2P').hide()
                
                  var dataSplit='<?=$invoiceSyncSummary?>'.split(',');
                  if(dataSplit[0]!=0)
                      $('#syncInvoicesPartial').text(dataSplit[0]+' invoice(s) moved to partially paid invoices').show();
                  if(dataSplit[1]!=0)
                      $('#syncInvoicesAppMovedP2U').text(dataSplit[1]+' student application(s) moved to Approved unpaid').show();
                  if(dataSplit[2]!=0)
                      $('#syncInvoicesPartialUpdated').text(dataSplit[2]+' invoice(s) updated in partially paid invoices').show();		  
                  if(dataSplit[3]!=0)
                      $('#syncInvoicesPaid').text(dataSplit[3]+' invoice(s) moved to paid invoices').show();		  
                  if(dataSplit[4]!=0)
                      $('#syncInvoicesAppMovedP2P').text(dataSplit[4]+' student application(s) moved to Approved paid').show();
                  
                 if(dataSplit[0]==0 && dataSplit[1]==0 && dataSplit[2]==0 && dataSplit[3]==0 && dataSplit[4]==0)
                      $('#syncInvoicesUpToDate').show();
                    
                    $('#syncInitialInvoicesPopProcess').hide();
                    $('#syncInitialInvoicesSuccess').show();
                }
        });
        </script>

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

                              </div>
                              
                              </div>
							</div>
							<div class="modal-footer">
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
		</div>


<?php 
if($client['group_invoice_accomodation_fee']=='0')
 $this->load->view('system/group_invoice/importCsvPop');
?>