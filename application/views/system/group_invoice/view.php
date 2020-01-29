<div class="page-heading">
   <h1>Invoice data:  <?php 
	  	if($invoice['status']=='1')
		  echo "Pending";
		elseif($invoice['status']=='2')
		  echo "Partially paid";
		elseif($invoice['status']=='3')
		  echo "Paid";
		?></h1>
   
   
       <?php if($invoice['invoice_number']=='' && $invoice['status']=='1'){?>
    	<div class="m-n DTTT btn-group pull-right" id="moveInitialInvoiceToXero">
            <a  href="javascript:void(0);" class="btn btn-default" data-toggle="modal" data-target="#model_moveInitialInvoiceToXero">
             <img src="<?=static_url().'img/xero-icon.png'?>" width="14">
             <span class="colorBlue">Move to xero</span>
           </a>
        </div>
       <?php } ?>
       
       <?php 
	   if($invoice['latest_invoice']=='1')
	   {
	   if($invoice['imported']=='0'){?>
       <div class="m-n DTTT btn-group pull-right">
            <a  href="javascript:void(0);" class="btn btn-default" data-toggle="modal" data-target="#model_resetGroupInvoiceInvoice">
             <span class="colorBlue">Reset Invoice</span>
            </a>
        </div>
        <?php }
		if($invoice['imported']=='1'){
		?>
        <div class="m-n DTTT btn-group pull-right">
            <a  href="javascript:void(0);" class="btn btn-default"data-toggle="modal" data-target="#model_ImportGroupInvCsv" data-backdrop="static" data-keyboard="false" onclick="$('#paymentImportSummary').hide();$('#group-invoice-upload').show();addInvoiceIdToImportFrom(<?=$invoice['id']?>);">
             <span class="colorBlue">Reimport Invoice</span>
            </a>
        </div>
        <?php }} ?>
        
</div>

<div class="container-fluid">
<div class="row">
		
    <div class="col-md-12">
        <div class="panel panel-transparent">
            <div class="panel-body">

            
            	<div class="row" style="">
                    <!-- <div class="col-md-12">
                        <h1 class="text-primary text-center" style="font-weight: normal;">INVOICE</h1>
                    </div> -->
                    <div class="col-md-12">
                        
                        <div class="col-md-6" style="padding-left:1px;">
                           <div class="panel panel-default" style="">
                           <div class="panel-body no-padding table-responsive">
                           <div class="list-group">
                           
                      
                       <div class="list-group-item withripple">
                        <div class="row-action-primary">
                           <span class="icon"><i class="material-icons">account_box</i></span>
                        </div>
                        <div class="row-content">
                            <h4 class="list-group-item-heading">Client</h4>
                            <p class="list-group-item-text">
                                <?= ucfirst($client['bname'])?>
                                <?php if(trim($client['street_address'])!='' || trim($client['suburb'])!='' || trim($client['state'])!='' || trim($client['postal_code'])!=''){echo ",";}?>
                                <?php if(trim($client['street_address'])!=''){echo $client['street_address'].",";}?>
                                <?php
									if(trim($client['suburb'])!='')
    	                            	echo $client['suburb'];
									if(trim($client['suburb'])!='' && trim($client['state'])!='')	
										echo ', ';
									if(trim($client['state'])!='')
										echo $client['state']; 
									if($client['postal_code']!='0')
										echo ' '.$client['postal_code'];
								?>
                            </p>
                        </div>
                       </div>
                    
                    <div class="list-group-separator"></div>
                    
                    
                     <div class="list-group-item withripple">
                        <div class="row-action-primary">
                           <span class="icon"><i class="material-icons">contact_phone</i></span>
                        </div>
                        <div class="row-content">
                            <h4 class="list-group-item-heading">Contact</h4>
                            <p class="list-group-item-text">
                            	<?php
                                	echo '<a class="mailto" href="mailto:'.$client['primary_email'].'">'.$client['primary_email'].'</a>';
									echo ', '.$client['primary_phone'];
								?>
                            </p>
                        </div>
                       </div>
                    
                    
                    <div class="list-group-separator"></div>
                      
                      <div class="list-group-item withripple">
                        <div class="row-action-primary">
                       <span class="icon"><i class="material-icons">date_range</i></span>
                        </div>
                        <div class="row-content" >
                           
                            <h4 class="list-group-item-heading">Invoice duration</h4>
                            <p class="list-group-item-text">
                            Not applicable
                            </p>
                        </div>
                       </div>
                    
                            </div>
                            </div>
                            </div>
                        </div>
                        
             <!--  ------------------------------------------   -->      
                        
              <div class="col-md-6" style="padding-right:0px;">
                           <div class="panel panel-default" style="">
                           <div class="panel-body no-padding table-responsive">
                           <div class="list-group">
                  
                    <div class="list-group-item withripple">
                        <div class="row-action-primary">
                      <span class="icon"><i class="material-icons">list</i></span>
                        </div>
                        <div class="row-content">
                            <h4 class="list-group-item-heading">Invoice Number</h4>
                            <p class="list-group-item-text">G-<?=$invoice['id']?></p>
                        </div>
                       </div>
                    
                    <div class="list-group-separator"></div>
                    
                    <div class="list-group-item withripple">
                        <div class="row-action-primary">
                       <span class="icon"><i class="material-icons">date_range</i></span>
                        </div>
                        <div class="row-content">
                            <h4 class="list-group-item-heading">Invoice Date</h4>
                            <p class="list-group-item-text"><?=date('d M Y',strtotime($invoice['date']))?></p>
                        </div>
                       </div>
                    
                    <?php if($invoice['imported']!='1'){?>
                    <div class="list-group-separator"></div>
                    
                      <div class="list-group-item withripple">
                        <div class="row-action-primary">
                         <span class="icon"><i class="material-icons">date_range</i></span>
                        </div>
                        <div class="row-content">
                            <h4 class="list-group-item-heading">Xero status</h4>
<p class="list-group-item-text" id="invoicePageXeroStatus" style="opacity:unset;"><?php if($invoice['moved_to_xero']=='1'){echo "<span style='opacity:0.5;'>Moved - ".date('d M Y',strtotime($invoice['moved_to_xero_date'])).'</span> <a href="https://go.xero.com/AccountsReceivable/View.aspx?InvoiceID='.$invoice['xero_invoiceId'].'" target="_blank">('.$invoice['invoice_number'].')</a>';}else{echo '<span style="opacity:0.5;">Not moved</span>';}?></p>                        </div>
                       </div>
                   <?php } ?>
                    
                      

                            </div>
                            </div>
                            </div>
                        </div>          
                        
                        
               
           <!--  ----------------------------------------------------------  -->
                        
                    </div>
                </div>
                <div class="row">

                    
                    <div class="col-md-12">
	                    <h3 style="font-size:26px;" class="colorLightgreen">Invoice items</h3>
                        <div class="panel">
                            <div class="panel-body no-padding">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered m-n" id="viewIntialInvoice-<?=$invoice['id']?>">
                                        <thead>
                                            <tr>
                                                <th>Item description</th>
                                                <th class="text-right">Quantity</th>
                                                <th class="text-right">Unit price</th>
                                                <th class="text-right">Total price</th>
                                                <th class="text-right">GST</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        			<?php 
														$total_amount=0;
														
														foreach($invoice['items'] as $item)
														{
															$total_amount +=$item['total'];
													?>
                                                              <tr id="iI_<?=$item['id']?>">
                                                                  <td><?=$item['desc']?></td>
                                                                  <td class="text-right"><?=$item['qty'].' '?><?php if($item['qty_unit']!='0'){if($item['qty_unit']=='1'){echo "week";}elseif($item['qty_unit']=='2'){echo "night";} echo s($item['qty']);}?></td>
                                                                  <td class="text-right">$<?=$item['unit']?></td>
                                                                  <td class="text-right">$<?=$item['total']?></td>
                                                                  <td class="text-right"><?php if($item['gst']=='0'){echo 'Free';}else {echo "Inc.";}?></td>
                                                                  <td class="text-right" style="color:#03a9f4;">
	                                                                  <a class="deleteGroupInvoiceItem"><i class="font16 material-icons">delete</i></a> |
	                                                                  <a class="editGroupInvoiceItem" href="javascript:void(0);" data-toggle="modal" data-target="#model_editInitialInvoiceItem"><i class="font16 material-icons">edit</i></a>
                                                                  </td>
                                                              </tr>
													<?php
														}
													?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <div class="col-md-12">
                        <div class="row" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px;">
                            <div class="col-md-9 pull-left">
                            <div class="m-n DTTT btn-group" id="">
                        <!--<a class="btn btn-default" href="javascript:void(0);" data-toggle="modal" data-target="#model_addNewInitialInvoiceItem" onclick="addNewInitialInvoiceItemPopContent(<?=$invoice['id']?>,'real');">
                            <i class="colorBlue fa fa-plus"></i> 
                            <span class="colorBlue" onclick="">Add new item</span>
                        </a>-->
                    </div>
                            </div>
                            <div class="col-md-3 pull-ight" id="viewIntialInvoiceTotal">
                            	<h4 class="text-right" style="font-weight: bold;">Total amount: $<?=$total_amount?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            


    	
       <!--Payments #STARTS-->
       <?php if(isset($invoice['payments'])){?>
 <div class="row" style="margin-top:27px;">
                
       <div class="col-md-12">
       <h3 style="font-size:26px;" class="colorLightgreen">Payments received</h3>
                        <div class="panel ">
                            <div class="panel-body no-padding">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered m-n" id="viewIntialInvoicePayments-<?=$invoice['id']?>">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th class="text-right">Amount received</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        			<?php 
														$total_amount_paid=0;
														foreach($invoice['payments'] as $payment)
														{
															$total_amount_paid +=$payment['amount_paid'];
													?>
                                                              <tr id="iI_<?=$item['id']?>">
                                                                  <td><?=date('d M Y',strtotime($payment['date']))?></td>
                                                                  <td class="text-right">$<?=$payment['amount_paid']?></td>
                                                              </tr>
													<?php
														}
													?>
                                       </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px;">
                            <div class="col-md-9 pull-left">
                            </div>
                            <div class="col-md-3 pull-ight" id="viewIntialInvoiceTotal">
                            	<h4 class="text-right" style="font-weight: bold;">Total amount recieved: $<?=$total_amount_paid?></h4>
                                <h4 class="text-right" style="font-weight: bold;">Total amount due: $<?=$total_amount-$total_amount_paid?></h4>
                            </div>
                        </div>
                    </div>

</div>

         <?php } ?> 
       <!--Payments #ENDS-->
       
       
                   </div>

        </div>
			
    </div>
       
        
	</div> <!-- .container-fluid -->
</div>




<div class="modal fade " id="model_moveInitialInvoiceToXero" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h2 class="modal-title">Move to xero</h2>
                  </div>
                  
                  <div class="modal-body">
                     Are you sure you wish to move this invoice to Xero?
                     <input type="hidden" id="moveInitialInvoiceToXero_id" value="invoice-<?=$invoice['id']?>" />
                     <input type="hidden" id="moveInitialInvoiceToXero_Page" value="groupInvInitial" />
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-success btn-raised" id="moveOngoingInvoiceToXeroSubmitPage">Yes</button>
                      <img src="<?=loadingImagePath()?>" id="moveInitialInvoiceToXeroProcess" style="margin-right:16px;display:none;">
                  </div>
              </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

  </div>
  
  
  <div class="modal fade" id="model_editInitialInvoiceItem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h2 class="modal-title">Edit invoice item</h2>
              </div>
              
              <div class="modal-body">
                  <form id="editInitialInvoiceItem_form"></form>                
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-success btn-raised" id="editInitialGroupInvoiceItemSubmit">Save</button>
                  <img src="<?=loadingImagePath()?>" id="editInitialInvoiceItemProcess" style="margin-right:16px;display:none;">
              </div>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

</div>


  <div class="modal fade " id="model_resetGroupInvoiceInvoice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h2 class="modal-title">Reset Invoice</h2>
                  </div>
                  
                  <div class="modal-body">
                     <p>If you reset the invoice then it will recreate the invoice items based on the latest data in the booking.<?php if(isset($invoice['items_standard'])){?> It will also Reset the Student invoice along with it.<?php } ?></p>
                     <p>Are you sure you want to Reset the Invoice?</p>
                     <input type="hidden" id="resetGroupInvoiceId" value="<?=$invoice['id']?>" />
                  </div>
                  <div class="modal-footer">
	                  <button type="button" class="btn  btn-raised" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-success btn-raised" id="resetGroupInvoiceSubmit">Reset</button>
                      <img src="<?=loadingImagePath()?>" id="resetGroupInvoiceProcess" style="margin-right:16px;display:none;">
                  </div>
              </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

  </div>
  
<?php 
if($invoice['latest_invoice']=='1' && $invoice['imported']=='1')
	$this->load->view('system/group_invoice/importCsvPop');
?>