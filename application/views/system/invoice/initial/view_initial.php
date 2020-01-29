<?php
$stateList=stateList();
$notAvailable='Not available';

$totalDays=shaInitialInvoiceWeekDays($invoice['application_id']);
if($invoice['study_tour']==1)
	$totalDays=dayDiff($invoice['booking_from'],$invoice['booking_to']);
$getWeekNDays=getWeekNDays($totalDays);
$initialInvoiceUpdated=$this->session->flashdata('initialInvoiceUpdated');
$initialInvoiceReset=$this->session->flashdata('initialInvoiceReset');
?>
<style type="text/css">
.text-right {
    text-align: right !important;
}
.text-center {
    text-align: center !important;
}

table td > a > i.material-icons {
    font-size: 16px;
}

.alertGE {
    padding: 15px;
    margin-bottom: 0px;
    border: 1px solid transparent;
    border-radius: 2px;
}
.alertGE > p
{
	margin-bottom: 0;
}
.alertGE.alert-info {
    background-color: #00bcd4;
    color: rgba(255,255,255, 0.84);
}
</style>

<div class="page-heading">
   <h1>Invoice data: 
   <?php
	   if($invoice['cancelled']=='1')
	 	  	echo "Cancelled";
	   elseif($invoice['status']=='1')
	   		echo "Pending";
		elseif($invoice['status']=='2')
	   		echo "Partially paid";
		elseif($invoice['status']=='3')
	   		echo "Paid";		
   ?>
   </h1>
   
   
       <?php if($invoice['invoice_number']=='' && $invoice['status']=='1'){?>
    	<div class="m-n DTTT btn-group pull-right" id="moveInitialInvoiceToXero">
            <a  href="javascript:void(0);" class="btn btn-default" data-toggle="modal" data-target="#model_moveInitialInvoiceToXero">
             <img src="<?=static_url().'img/xero-icon.png'?>" width="14">
             <span class="colorBlue">Move to xero</span>
           </a>
        </div>
       <?php } ?>
       
       <div class="m-n DTTT btn-group pull-right">
            <a  href="javascript:void(0);" class="btn btn-default" data-toggle="modal" data-target="#model_resetInitialInvoice">
             <span class="colorBlue">Reset Invoice</span>
            </a>
        </div>
       
</div>
                           
<div class="container-fluid">
<div class="row">
				
      <div class="col-md-12 showOnMovedToXero" <?php if($invoice['moved_to_xero']=='0'){echo 'style="display:none;"';}?>>
        <div class="panel panel-transparent" style="margin-bottom:0;">
            <div class="panel-body">
      <div class="alertGE alert-info ">
          <p class="text-default" >Invoice moved to Xero. If you change anything here then make sure that you change it in Xero invoice too and vice versa. </p>
      </div>
</div></div></div>

<!--Cancel data #STARTS-->
<?php 
					    if($invoice['cancelled']=='1')
						{
							$initialInvoiceCancelledData=initialInvoiceCancelledData($invoice['id']);
						?>
<div class="col-md-12">
        <div class="panel panel-transparent">
            <div class="panel-body">
            
                <div class="row">
                    <div class="col-md-12">
                        
                        <div class="col-md-6" style="padding-left:1px;">
                           <div class="panel panel-default" style="">
                           <div class="panel-body no-padding table-responsive">
                           <div class="list-group">
                           
                       
                          <div class="list-group-item withripple">
                            <div class="row-action-primary">
                           <span class="icon"><i class="material-icons">date_range</i></span>
                            </div>
                            <div class="row-content">
                                <h4 class="list-group-item-heading">Cancel Reason</h4>
                                <p class="list-group-item-text"><?php if($initialInvoiceCancelledData['reason']!=''){echo $initialInvoiceCancelledData['reason'];}else{echo $notAvailable;;}?></p>
                            </div>
                           </div>
                            <div class="list-group-separator"></div>
                           
                           
                       <div class="list-group-item withripple">
                        <div class="row-action-primary">
                           <span class="icon"><i class="material-icons">account_box</i></span>
                        </div>
                        <div class="row-content">
                            <h4 class="list-group-item-heading">Invoice total</h4>
                            <address class="list-group-item-text">
                                $<?=add_decimal($initialInvoiceCancelledData['total_amount'])?>
                            </address>
                        </div>
                       </div>
                    
                    <div class="list-group-separator"></div>
                    
                    
                     <div class="list-group-item withripple">
                        <div class="row-action-primary">
                           <span class="icon"><i class="material-icons">contact_phone</i></span>
                        </div>
                        <div class="row-content">
                            <h4 class="list-group-item-heading">
                            <?php
                            				$due="due";
											$refund=" to be refund";
											if($initialInvoiceCancelledData['settle_type']=='0' || $initialInvoiceCancelledData['settle_type']=='1')
												$settle_type=$due;
											else	
												$settle_type=$refund;
											echo 'Amount '.$settle_type;
							?>
                            </h4>
                            <p class="list-group-item-text">
                            	<?='$'.add_decimal($initialInvoiceCancelledData['settle_amount']);?>
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
                       <span class="icon"><i class="material-icons">date_range</i></span>
                        </div>
                        <div class="row-content">
                            <h4 class="list-group-item-heading">Cancel Date</h4>
                            <p class="list-group-item-text"><?=date('d M Y',strtotime($initialInvoiceCancelledData['date_cancellation']))?></p>
                        </div>
                       </div>
                        <div class="list-group-separator"></div>
                    
                    
                    <div class="list-group-item withripple">
                        <div class="row-action-primary">
                      <span class="icon"><i class="material-icons">list</i></span>
                        </div>
                        <div class="row-content">
                            <h4 class="list-group-item-heading">Amount paid</h4>
                            <p class="list-group-item-text">$<?=add_decimal($initialInvoiceCancelledData['received'])?></p>
                        </div>
                       </div>
                    
                     </div>
                            </div>
                            </div>
                        </div>          
                        
                        
               
           <!--  ----------------------------------------------------------  -->
                        
                    </div>
                </div>
                
                


     </div>


        </div>

    </div>
   <?php }?> 
<!--Cancel data #ENDS-->

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
                            <h4 class="list-group-item-heading"><?php if($client['category']=='1'){
								echo 'Student';
								}else{?>Client<?php } ?></h4>
                            <p class="list-group-item-text">
                            <?php if($client['category']=='1'){
								echo $student['fname'].' '.$student['lname'];
								}else{?>
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
								}		
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
								if($client['category']=='1')
								{
									echo '<a class="mailto" href="mailto:'.$student['email'].'">'.$student['email'].'</a>';
									echo ', '.$student['mobile'];
								}
								else
								{
                                	echo '<a class="mailto" href="mailto:'.$client['primary_email'].'">'.$client['primary_email'].'</a>';
									echo ', '.$client['primary_phone'];
								}
								?>
                            </p>
                        </div>
                       </div>
                    
                    
                    <div class="list-group-separator"></div>
                      
                      <div class="list-group-item withripple">
                        <div class="row-action-primary">
                       <span class="icon"><i class="material-icons">date_range</i></span>
                        </div>
                        <div class="row-content" data-toggle="modal" data-target="#model_changeInvDuration" onclick="$('#initialInvoiceUpdateDurationForm')[0].reset();" style="cursor:pointer;">
                           
                            <h4 class="list-group-item-heading">Invoice duration</h4>
                            <p class="list-group-item-text">
                            <?php
                            if(isset($getWeekNDays['week']))
								echo $getWeekNDays['week'].' week'.s($getWeekNDays['week']).' ';
							if(isset($getWeekNDays['day']))
								echo $getWeekNDays['day'].' night'.s($getWeekNDays['day']).' ';
							
							if($invoice['booking_from']!='0000-00-00' && $invoice['booking_to']!='0000-00-00')
								echo '('.date('d M Y',strtotime($invoice['booking_from'])).' to '.date('d M Y',strtotime($invoice['booking_to'])).')';
							?>
                            </p>
                        </div>
                        <i class="material-icons updateInvDurationIcon" data-toggle="modal" data-target="#model_changeInvDuration" onclick="$('#initialInvoiceUpdateDurationForm')[0].reset();" style="cursor:pointer;">edit</i>
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
                            <p class="list-group-item-text">I-<?=$invoice['id']?></p>
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
                    
                    <div class="list-group-separator"></div>
                    
                      <div class="list-group-item withripple">
                        <div class="row-action-primary">
                         <span class="icon"><i class="material-icons">date_range</i></span>
                        </div>
                        <div class="row-content">
                            <h4 class="list-group-item-heading">Xero status</h4>
<p class="list-group-item-text" id="invoicePageXeroStatus" style="opacity:unset;"><?php if($invoice['moved_to_xero']=='1'){echo "<span style='opacity:0.5;'>Moved - ".date('d M Y',strtotime($invoice['moved_to_xero_date'])).'</span> <a href="https://go.xero.com/AccountsReceivable/View.aspx?InvoiceID='.$invoice['xero_invoiceId'].'" target="_blank">('.$invoice['invoice_number'].')</a>';}else{echo '<span style="opacity:0.5;">Not moved</span>';}?></p>                        </div>
                       </div>
                   
                    
                      

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
															$accomodationWeekItem='';
															if($item['type']=='accomodation')
																$accomodationWeekItem='accomodationWeekItem';
													?>
                                                              <tr id="iI_<?=$item['id']?>" class="<?=$accomodationWeekItem?>">
                                                                  <td><?=$item['desc']?></td>
                                                                  <td class="text-right"><?=$item['qty'].' '?><?php if($item['qty_unit']!='0'){if($item['qty_unit']=='1'){echo "week";}elseif($item['qty_unit']=='2'){echo "night";} echo s($item['qty']);}?></td>
                                                                  <td class="text-right">$<?=$item['unit']?></td>
                                                                  <td class="text-right">$<?=$item['total']?></td>
                                                                  <td class="text-right"><?php if($item['gst']=='0'){echo 'Free';}else {echo "Inc.";}?></td>
                                                                  <td class="text-right" style="color:#03a9f4;">
	                                                                  <?php //if($item['type']!='accomodation_ed'){?>
																         <a class="deleteInvoiceItem"><i class="font16 material-icons">delete</i></a> |                                                             
                                                                       <?php //}?>
																  		 <a class="editInvoiceItem" href="javascript:void(0);" data-toggle="modal" data-target="#model_editInitialInvoiceItem"><i class="font16 material-icons">edit</i></a>
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
                        <a class="btn btn-default" href="javascript:void(0);" data-toggle="modal" data-target="#model_addNewInitialInvoiceItem" onclick="addNewInitialInvoiceItemPopContent(<?=$invoice['id']?>,'real');">
                            <i class="colorBlue fa fa-plus"></i> 
                            <span class="colorBlue" onclick="">Add new item</span>
                        </a>
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



<div class="modal fade" id="model_addNewInitialInvoiceItem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h2 class="modal-title">Add new item</h2>
              </div>
              
              <div class="modal-body">
                  <form id="addNewInitialInvoiceItem_form"></form>                
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-success btn-raised" id="addNewInitialInvoiceItemSubmit">Save</button>
                  <img src="<?=loadingImagePath()?>" id="addNewInitialInvoiceItemProcess" style="margin-right:16px;display:none;">
              </div>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

</div>
            
<link href="<?=static_url()?>system/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" type="text/css" rel="stylesheet"> <!-- Touchspin -->
<script src="<?=static_url()?>system/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js"></script>


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
                  <button type="button" class="btn btn-success btn-raised" id="editInitialInvoiceItemSubmit">Save</button>
                  <img src="<?=loadingImagePath()?>" id="editInitialInvoiceItemProcess" style="margin-right:16px;display:none;">
              </div>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

</div>

<input type="hidden" id="invoiceTypePage" value="real">



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
                     <input type="hidden" id="moveInitialInvoiceToXero_Page" value="initial" />
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-success btn-raised" id="moveOngoingInvoiceToXeroSubmitPage">Yes</button>
                      <img src="<?=loadingImagePath()?>" id="moveInitialInvoiceToXeroProcess" style="margin-right:16px;display:none;">
                  </div>
              </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

  </div>
  
  
  <div class="modal fade " id="model_changeInvDuration" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h2 class="modal-title">Set invoice duration</h2>
                  </div>
                  
                  <div class="modal-body">
                     <form id="initialInvoiceUpdateDurationForm">
                      
                      <div class="m-n form-group col-xs-6" style="padding-left:0;">
                          <label class="control-label">Weeks</label>
                          <input id="weeks_changeDuration" value="<?php if(isset($getWeekNDays['week'])){echo $getWeekNDays['week'];}else{echo 4;}?>"  name="weeks" required data-parsley-type="number">
                      </div>
                                            
                      <div class="m-n form-group col-xs-6" style="padding-left:0;">
                          <label class="control-label">nights</label>
                          <input id="days_changeDuration" value="<?php if(isset($getWeekNDays['day'])){echo $getWeekNDays['day'];}else{echo 0;}?>"  name="days" required data-parsley-type="number">
                      </div>
                     
                     <input type="hidden" name="invoice_id" value="<?=$invoice['id']?>" />
                     <?php if($invoice['study_tour']==1){?>
	                     <input type="hidden" name="study_tour" value="<?=$invoice['study_tour']?>" />
                     <?php } ?>
                     <input type="hidden" name="shaChangeStatus_id" value="<?=$invoice['application_id']?>" />
                     
                     <p id="" class="changeStatusWarningMsg">Changing the duration of the invoice will regenerate invoice data according to new duration. Any invoice item that is manually added, will be lost.</p>
                     
                     </form>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-success btn-raised" id="initialInvoiceUpdateDuration">Update</button>
                      <img src="<?=loadingImagePath()?>" id="initialInvoiceUpdateDurationProcess" style="margin-right:16px;display:none;">
                  </div>
              </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

  </div>
  
  
  <div class="modal fade " id="model_resetInitialInvoice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h2 class="modal-title">Reset Invoice</h2>
                  </div>
                  
                  <div class="modal-body">
                     <p>If you reset the invoice then it will recreate the invoice items based on the latest data in the student application.<?php if(isset($invoice['items_standard'])){?> It will also Reset the Student invoice along with it.<?php } ?></p>
                     <p class="changeStatusWarningMsg">You will loose any custom invoice items that you added manually. Take a note of those items before you Reset Invoice.</p>
                     <p>Are you sure you want to Reset the Invoice?</p>
                     <input type="hidden" id="resetInitialInvoiceId" value="<?=$invoice['id']?>" />
                     <input type="hidden" id="resetInitialInvoiceTour" value="<?=$invoice['study_tour']?>" />
                  </div>
                  <div class="modal-footer">
	                  <button type="button" class="btn  btn-raised" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-success btn-raised" id="resetInitialInvoiceSubmit">Reset</button>
                      <img src="<?=loadingImagePath()?>" id="resetInitialInvoiceProcess" style="margin-right:16px;display:none;">
                  </div>
              </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

  </div>
  
  <script type="text/javascript">
$(document).ready(function(){

		$('#invoice_startDate, #invoice_endDate').datepicker({
			orientation: "top",
			todayHighlight: true,
	    	startDate: "-0d",
			format:'dd/mm/yyyy',
			autoclose:true
		});
		
		$("input#weeks_changeDuration").TouchSpin({
		  verticalbuttons: true/*,
		  min: 1*/
		});
		$("input#days_changeDuration").TouchSpin({
		  verticalbuttons: true,
		  min: 0
		});
		
		
		if('<?=$initialInvoiceUpdated?>'=='yes')
			notiPop('success','Invoice updated successfully',"")
		if('<?=$initialInvoiceReset?>'=='yes')
			notiPop('success','Invoice reset successfully',"")	
	
	});
</script>