<?php
$totalDays=dayDiff($po['from'],$po['to']);
$getWeekNDays=getWeekNDays($totalDays);
?>
<style type="text/css">
.text-right {
    text-align: right !important;
}
.text-center {
    text-align: center !important;
}
</style>

<div class="page-heading">
   <h1>Purchase order data: <?php if($po['status']=='1'){echo "Pending";}elseif($po['status']=='2'){echo "Paid";}if($po['status']=='3'){echo "Partially paid";}?></h1>
   
   <?php if($po['moved_to_xero']=='0'){?>
   <div class="m-n DTTT btn-group pull-right" id="movePOToXero">
        <a  href="javascript:void(0);" class="btn btn-default" data-toggle="modal" data-target="#model_movePOToXero">
         <img src="<?=static_url().'img/xero-icon.png'?>" width="14">
         <span class="colorBlue">Move to xero</span>
       </a>
    </div>
    <?php } ?> 
    <?php if(ifPoIsLatest($po['id'])){?>   
       <div class="m-n DTTT btn-group pull-right">
            <a  href="javascript:void(0);" class="btn btn-default" data-toggle="modal" data-target="#model_resetPO">
             <span class="colorBlue">Reset Purchase Order</span>
            </a>
        </div>
        <?php } ?>
</div>
            
<div class="container-fluid">
<div class="row">


    <div class="col-md-12">
        <div class="panel panel-transparent">
            <div class="panel-body">
                <div class="row mb-xl">
                    <!-- <div class="col-md-12">
                        <h1 class="text-primary text-center" style="font-weight: normal;">INVOICE</h1>
                    </div> -->
                    <div class="col-md-12">
                        
                        <div class="col-md-6" style="padding-left:1px;">
                           <div class="panel panel-default" style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                           <div class="panel-body no-padding table-responsive">
                           <div class="list-group">
                           
                      
                       <div class="list-group-item withripple">
                        <div class="row-action-primary">
                           <span class="icon"><i class="material-icons">home</i></span>
                        </div>
                        <div class="row-content">
                            <h4 class="list-group-item-heading">Host</h4>
                            <p class="list-group-item-text">
                            	<?=ucfirst($po['host_lname']).' Family' ?>
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
                            	<?=$po['host_email'];?>, <?=$po['host_mobile'];?>
                            </p>
                        </div>
                       </div>
                    
                    
                    <div class="list-group-separator"></div>
                      
                      <div class="list-group-item withripple">
                        <div class="row-action-primary">
                       <span class="icon"><i class="material-icons">date_range</i></span>
                        </div>
                        <div class="row-content" data-toggle="modal" data-target="#model_changePoDuration" onclick="$('#poUpdateDurationForm')[0].reset();" style="cursor:pointer;">
                            <h4 class="list-group-item-heading">Purchase order duration</h4>
                            <p class="list-group-item-text">
								<?php
										if(isset($getWeekNDays['week']))
											echo $getWeekNDays['week'].' week'.s($getWeekNDays['week']).' ';
										if(isset($getWeekNDays['day']))
											echo $getWeekNDays['day'].' day'.s($getWeekNDays['day']).' ';
								?>
								<?php
								if($po['from']!='0000-00-00' && $po['to']!='0000-00-00')
								echo '('.date('d M Y',strtotime($po['from'])).' to '.date('d M Y',strtotime($po['to'])).')';
							?>
                            </p>
                        </div>
                        <i class="material-icons updateInvDurationIcon" data-toggle="modal" data-target="#model_changePoDuration" onclick="$('#poUpdateDurationForm')[0].reset();" style="cursor:pointer;">edit</i>
                       </div>
                    
                            </div>
                            </div>
                            </div>
                        </div>
                        
             <!--  ------------------------------------------   -->      
                        
              <div class="col-md-6" style="padding-right:0px;">
                           <div class="panel panel-default" style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                           <div class="panel-body no-padding table-responsive">
                           <div class="list-group">
                  
                    <div class="list-group-item withripple">
                        <div class="row-action-primary">
                      <span class="icon"><i class="material-icons">list</i></span>
                        </div>
                        <div class="row-content">
                            <h4 class="list-group-item-heading">Purchase order number</h4>
                            <p class="list-group-item-text">PO-<?=$po['id'].' (created: '.date('d M Y',strtotime($po['date'])).')'?></p>
                        </div>
                       </div>
                    
                    <div class="list-group-separator"></div>
                    
                    <div class="list-group-item withripple">
                        <div class="row-action-primary">
                       <span class="icon"><i class="material-icons">date_range</i></span>
                        </div>
                        <div class="row-content">
                            <h4 class="list-group-item-heading">Purchase due date</h4>
                            <p class="list-group-item-text"><?=date('d M Y',strtotime($po['due_date']))?></p>
                        </div>
                       </div>
                    
                    <div class="list-group-separator"></div>
                    
                      <div class="list-group-item withripple">
                        <div class="row-action-primary">
                         <span class="icon"><i class="material-icons">date_range</i></span>
                        </div>
                        <div class="row-content">
                            <h4 class="list-group-item-heading">Xero status</h4>
                            <!--<p class="list-group-item-text" id="poPageXeroStatus"> <?php if($po['moved_to_xero']=='1'){echo "Moved - ".date('d M Y',strtotime($po['moved_to_xero_date']));}else{echo 'Not moved';}?></p>-->
                            <p class="list-group-item-text" id="poPageXeroStatus" style=""><?php if($po['moved_to_xero']=='1'){echo "<span>Moved - ".date('d M Y',strtotime($po['moved_to_xero_date'])).'</span> <a href="https://go.xero.com/AccountsPayable/View.aspx?InvoiceID='.$po['po_id_xero'].'" target="_blank">(Xero)</a>';}else{echo 'Not moved';}?></p>
                        </div>
                       </div>
                   
                    
                      

                            </div>
                            </div>
                            </div>
                        </div>          
                        
                        
               
           <!--  ----------------------------------------------------------  -->
                        
                    </div>
                </div>
                <div class="row mb-xl">

                    
                    <div class="col-md-12">
	                    <h3 class="colorLightgreen" style="font-size:26px;">Purchase order data</h3>
                        <div class="panel">
                            <div class="panel-body no-padding">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered m-n" id="viewPurchase-<?=$po['id']?>">
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
														$getPoAdminFee=getPoAdminFee($po['items']);
														
														$total_amount=0;
														foreach($po['items'] as $item)
														{
															$adminFeeInPercent=false;
															if($item['type']=='adminFee' && $item['qty_unit']=='3')
																$adminFeeInPercent=true;
															
															if($adminFeeInPercent)	
																$total_amount -=$getPoAdminFee;
															elseif($item['type']=='adminFee' && $item['qty_unit']=='4')
																	$total_amount -=$item['total'];
															else
																$total_amount +=$item['total'];
															
													?>
                                                              <tr id="iI_<?=$item['id']?>">
                                                                  <td><?=$item['desc']?></td>
                                                                  <td class="text-right"><?=$item['qty'].' '?><?php if($item['qty_unit']!='0'){if($item['qty_unit']=='1'){echo "week";}elseif($item['qty_unit']=='2'){echo "day";} if(in_array($item['type'],array('1','2','holidayDiscount'))){echo s($item['qty']);}}?></td>
                                                                  <td class="text-right"><?php if($item['qty_unit']!='3'){echo '$';}?><?=abs($item['unit']);?><?php if($item['type']=='adminFee' && $item['qty_unit']=='3'){echo '%';}?></td>
                                                                  <td class="text-right">$<?php if($adminFeeInPercent){echo add_decimal($getPoAdminFee);}else{echo abs($item['total']);}?></td>
                                                                  <td class="text-right"><?php if($item['gst']=='0'){echo 'Free';}else {echo "Inc.";}?></td>
                                                                  <td class="text-right" style="color:#03a9f4;">
	                                                                  <?php if($item['type']!='accomodation' && $item['type']!='accomodation_ed'){?>
																         <a class="deleteInvoiceItem"><i class="font16 material-icons">delete</i></a> |                                                             
                                                                       <?php }?>
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
                            <a class="btn btn-default" href="javascript:void(0);" data-toggle="modal" data-target="#model_addNewInitialInvoiceItem" onclick="addNewInitialInvoiceItemPopContent(<?=$po['id']?>,'po');">
                                <i class="colorBlue fa fa-plus"></i> 
                                <span class="colorBlue" onclick="">Add new item</span>
	                        </a>
                    		</div>
                            </div>
                            <div class="col-md-3 pull-ight" id="viewIntialInvoiceTotal">
                            	<h4 class="text-right" style="font-weight: bold;">Total amount: $<?=add_decimal($total_amount)?></h4>
                            </div>
                        </div>
                    </div>
                </div>
                

            </div>

        </div>

    </div>
</div> <!-- .container-fluid -->
</div>

<link href="<?=static_url()?>system/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" type="text/css" rel="stylesheet"> <!-- Touchspin -->
<script src="<?=static_url()?>system/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js"></script>

<div class="modal fade " id="model_movePOToXero" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h2 class="modal-title">Move to xero</h2>
                  </div>
                  
                  <div class="modal-body">
                     Are you sure you wish to move this purchase order to Xero?
                     <input type="hidden" id="movePOToXero_id" value="po-<?=$po['id']?>" />
                     <input type="hidden" id="movePoToXero_pageStatus" value="all" />
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-success btn-raised" id="movePOToXeroSubmitPage">Yes</button>
                      <img src="<?=loadingImagePath()?>" id="movePOToXeroProcess" style="margin-right:16px;display:none;">
                  </div>
              </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

  </div>
 
 
   <div class="modal fade " id="model_changePoDuration" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h2 class="modal-title">Set purchase order duration</h2>
                  </div>
                  
                  <div class="modal-body">
                     <form id="poUpdateDurationForm">
                      
                      <div class="m-n form-group col-xs-6" style="padding-left:0;">
                          <label class="control-label">Weeks</label>
                          <input id="weeks_changeDuration" value="<?php if(isset($getWeekNDays['week'])){echo $getWeekNDays['week'];}else{echo 0;}?>"  name="weeks" required data-parsley-type="number">
                      </div>
                                            
                      <div class="m-n form-group col-xs-6" style="padding-left:0;">
                          <label class="control-label">days</label>
                          <input id="days_changeDuration" value="<?php if(isset($getWeekNDays['day'])){echo $getWeekNDays['day'];}else{echo 0;}?>"  name="days" required data-parsley-type="number">
                      </div>
                     
                     <input type="hidden" name="po_id" value="<?=$po['id']?>" />
                     
                     <p id="" class="changeStatusWarningMsg">Changing the duration of the purchase order will regenerate purchase order data according to new duration.</p>
                     
                     </form>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-success btn-raised" id="poUpdateDuration">Update</button>
                      <img src="<?=loadingImagePath()?>" id="initialInvoiceUpdateDurationProcess" style="margin-right:16px;display:none;">
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
                  <button type="button" class="btn btn-success btn-raised" id="editPoItemSubmit">Save</button>
                  <img src="<?=loadingImagePath()?>" id="editInitialInvoiceItemProcess" style="margin-right:16px;display:none;">
              </div>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

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
                  <button type="button" class="btn btn-success btn-raised" id="addNewPoItemSubmit">Save</button>
                  <img src="<?=loadingImagePath()?>" id="addNewInitialInvoiceItemProcess" style="margin-right:16px;display:none;">
              </div>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

</div>

<div class="modal fade " id="model_resetPO" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h2 class="modal-title">Reset Purchase order</h2>
                  </div>
                  
                  <div class="modal-body">
                     <p>If you reset the purchase order then it will recreate the purchase order items.</p>
                     <p class="changeStatusWarningMsg">You will loose any custom items that you added manually. Take a note of those items before you Reset purchase order.</p>
                     <p>Are you sure you want to Reset the Purchase order?</p>
                     <input type="hidden" id="resetPOId" value="<?=$po['id']?>" />
                  </div>
                  <div class="modal-footer">
	                  <button type="button" class="btn  btn-raised" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-success btn-raised" id="resetPOSubmit">Reset</button>
                      <img src="<?=loadingImagePath()?>" id="resetPOProcess" style="margin-right:16px;display:none;">
                  </div>
              </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

  </div>

<input type="hidden" id="invoiceTypePage" value="po">
  
  <script type="text/javascript">
  $(document).ready(function(){
	  
	 	$('#movePOToXeroSubmitPage').click(function(){
				var invoiceId=$('#movePOToXero_id').val();
				var moveLink=$('#movePOToXero');
				var movePoToXero_pageStatus=$('#movePoToXero_pageStatus').val();
				$('#movePOToXeroSubmitPage').hide();
				$('#movePOToXeroProcess').show();
				
				$.ajax({
								url:site_url+'xero_api/movePoToXero',
								type:'post',
								data:{poId:invoiceId,pageStatus:movePoToXero_pageStatus},
								dataType: 'json',
								success:function(data){
										if(data.result=='LO')
											redirectToLogin();
										else if(data.result=='success')
										{
										  notiPop('success','Purchase order moved to xero successfully',"");
										  moveLink.remove();
										  $('#poPageXeroStatus').html(data.xero_status);
										  $('.showOnMovedToXero').show();
										}
										else if(data.result=='noBankDetails')
										{
										  notiPop('error','Please enter host family bank details before moving PO to Xero',"");
										}
										else if(data.result=='error')
											notiPop('error','Some problem occured, please try after sometime.',"");
	
										  $('#movePOToXeroSubmitPage').show();
										  $('#movePOToXeroProcess').hide();
										  $('#model_movePOToXero').modal('toggle');
	
										}
								});
				});
				
				
			$("input#weeks_changeDuration").TouchSpin({
		  		verticalbuttons: true,
		 	 	min: 0
			});
			$("input#days_changeDuration").TouchSpin({
		  		verticalbuttons: true,
		  		min: 0
			});
			
			
			$('#poUpdateDuration').click(function(){
				
					$('#poUpdateDuration').hide();
					$('#initialInvoiceUpdateDurationProcess').show();
					var url='purchase_orders/poUpdateDuration';
					
					var formdata=$('#poUpdateDurationForm').serialize();
					$.ajax({
							url:site_url+url,
							type:'POST',
							data:formdata,
							success:function(data)
								{
									window.location.reload();
								}
						});
				
			});
					
	 });
  </script>