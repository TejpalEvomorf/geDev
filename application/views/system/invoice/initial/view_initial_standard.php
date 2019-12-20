<?php
$stateList=stateList();

$totalDays=shaInitialInvoiceWeekDays($invoice['application_id']);
if($invoice['study_tour']==1)
	$totalDays=dayDiff($invoice['booking_from'],$invoice['booking_to']);
$getWeekNDays=getWeekNDays($totalDays);
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

</style>

<div class="page-heading">
   <h1>Student invoice data</h1>
   
   <!--Download as PDF button #STARTS-->
        	<div class="pull-right">
                <a style="margin:0px;" class="btn btn-danger" href="<?=site_url()?>invoice/downloadStudentInvoicePdf/<?=$invoice['id']?>" target="_blank"><i class="material-icons colorBlue" style="font-size:14px; margin-right:1px;">picture_as_pdf</i><span class="colorBlue" style="font-size:13px;">Download as PDF</span></a>
            </div>
        <!--Download as PDF button #ENDS-->
</div>

<div class="container-fluid">
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-transparent">
            <div class="panel-body">
                <div class="row">
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
                            <span class="icon"><i class="material-icons">face</i></span>
                        </div>
                        <div class="row-content">
                            <h4 class="list-group-item-heading">Student</h4>
                            <p class="list-group-item-text">
                               <?= ucfirst($student['fname'])?><?php if($student['mname']!=''){echo ' '.$student['mname'];}?><?=' '.$student['lname']?>
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
                            if($student['email']=='' && $student['mobile']=='' && $student['home_phone']=='')
								echo 'Not available';
							else
							{
							echo '<a class="mailto" href="mailto:'.$student['email'].'">'.$student['email'].'</a>';
								echo ', '.$student['mobile'];
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
                        <div class="row-content">
                            <h4 class="list-group-item-heading">Invoice duration</h4>
                            <p class="list-group-item-text">
							<?php //if($invoice['booking_from']=='0000-00-00' || $invoice['booking_to']=='0000-00-00'){echo '4 weeks';}else{echo date('d M Y',strtotime($invoice['booking_from'])).' to '.date('d M Y',strtotime($invoice['booking_to']));}
							
								 if(isset($getWeekNDays['week']))
								echo $getWeekNDays['week'].' week'.s($getWeekNDays['week']).' ';
							if(isset($getWeekNDays['day']))
								echo $getWeekNDays['day'].' day'.s($getWeekNDays['day']).' ';
							
							if($invoice['booking_from']!='0000-00-00' && $invoice['booking_to']!='0000-00-00')
								echo '('.date('d M Y',strtotime($invoice['booking_from'])).' to '.date('d M Y',strtotime($invoice['booking_to'])).')';
							?>
                            
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
                            <h4 class="list-group-item-heading">Due Date</h4>
                            <p class="list-group-item-text"> <?=date('d M Y',strtotime($invoice['date'].' + 7 days'))?></p>
                        </div>
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
														foreach($invoice['items_standard'] as $item)
														{
															$total_amount +=$item['total'];
													?>
                                                              <tr id="iI_<?=$item['id']?>">
                                                                  <td><?=$item['desc']?></td>
                                                                  <td class="text-right"><?=$item['qty'].' '?><?php if($item['qty_unit']!='0'){if($item['qty_unit']=='1'){echo "week";}elseif($item['qty_unit']=='2'){echo "day";} echo s($item['qty']);}?></td>
                                                                  <td class="text-right">$<?=$item['unit']?></td>
                                                                  <td class="text-right">$<?=$item['total']?></td>
                                                                  <td class="text-right"><?php if($item['gst']=='0'){echo 'Free';}else {echo "Inc.";}?></td>
                                                                  <td class="text-right" style="color:#03a9f4;">
                                                                  <?php if($item['type']!='accomodation_ed'){?>
	                                                                  <a class="deleteInvoiceItem"><i class="font16 material-icons">delete</i></a> | 
                                                                  <?php } ?>
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
                        <a class="btn btn-default" href="javascript:void(0);" data-toggle="modal" data-target="#model_addNewInitialInvoiceItem" onclick="addNewInitialInvoiceItemPopContent(<?=$invoice['id']?>,'standard');">
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

<input type="hidden" id="invoiceTypePage" value="standard">