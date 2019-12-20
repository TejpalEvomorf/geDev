<div class="ge-app-submenu col-md-12 pl-n pr-n">
    <ul class="nav nav-tabs material-nav-tabs mb-lg" style="width: auto;margin: 0 auto;">
        <li class="active"><a href="#tab-booking-pos" data-toggle="tab"> Purchase orders </a></li>
        <li><a href="#tab-booking-invoices" data-toggle="tab" id='booking-view-invoices'> Invoices</a></li>
        <!--<li><a href="#tab-booking-margin" data-toggle="tab" onclick="getBookingMargn(<?=$booking['id']?>);"> Margin</a></li>-->
        <!--<li><a href="#tab-booking-margin" data-toggle="tab" onclick="getBookingMargn(<?=$booking['id']?>,'<?=$booking['booking_from']?>','<?=date('Y-m-d',strtotime($booking['booking_from'].' + 10 days'))?>');"> Margin</a></li>-->
        <li><a href="#tab-booking-margin" data-toggle="tab" onclick="getBookingMargn();"> Margin</a></li>
    </ul>
</div>


<div class="container-fluid">                                
    <div data-widget-group="group1">
	<div class="row">
            <div class="col-md-12">
            
            		<div class="p-n col-md-12 tab-content">
                    	<div class="tab-pane active" id="tab-booking-pos">
                        	
                            <div class="panel panel-default">
                        		<div class="panel-body no-padding">
                                	
                                        <table id="bookingPosList" class="noborder0 table table-striped table-bordered table-fixed-header m-n" cellspacing="0" width="100%">
                                          <thead>
                                            <tr>
                                              <th>PO no.</th>
                                              <th>PO details</th>
                                              <th>PO type</th>
                                              <th>Office use</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                          <?php
												foreach($pos as $po)
												{
													$poListTd=poListTd($po,'all');
											?>
                                                <tr>
                                                    <td>
														<?=$poListTd['td1']?>
                                                        <br><a href="javascript:void(0);" data-placement="bottom" data-toggle="tooltip"  data-original-title="Booking id"><?=$po['booking_id']?></a>
                                                    </td>
                                                    <td>
                                                   		<?php
                                                        if($po['from']!='0000-00-00' && $po['to']!='0000-00-00')
														{
																echo date('d M Y',strtotime($po['from'])).' to '.date('d M Y',strtotime($po['to'])).'<br>'.$poListTd['td4'];
														}
														?>
                                                   </td>
                                                   <td class="middle-alignment">
														<?php
                                                            if($po['initial']=='1')
																echo "First PO";
															else	
																echo "Ongoing PO";
                                                        ?>
                                                   </td>
                                                  <td class="middle-alignment">
                                                  		<?=$poListTd['td_officeUse']?>
                                                  </td>
                                                </tr>
                                            <?php }?>
                                          </tbody>
                                        </table>           
                                
                                </div>
     							<div class="panel-footer"></div>
   							</div>
							
   
                        </div>
                        
                        <div class="tab-pane" id="tab-booking-invoices">
                        	
                            <div class="panel panel-default">
                        		<div class="panel-body no-padding">
                                	
                                        <table id="bookingInvoicesList" class="noborder0 table table-striped table-bordered table-fixed-header m-n" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Invoice no.</th>
                                                    <th>Invoice details</th>
                                                    <th>Invoice type</th>
                                                    <th>Office use</th>
                                                </tr>
                                            </thead>
                                            <tbody> 
                                            <?php
                                            
                                            foreach($invoices['ongoing'] as $invoice)
											{
												$ongoingInvoiceListTd=ongoingInvoiceListTd($invoice,'0');
												
												 $total_amount=0;
												  foreach($invoice['items'] as $item)
													  $total_amount +=$item['total'];
												  $td4='';
												  $td4=date('d M Y',strtotime($invoice['booking_from'])).' to '.date('d M Y',strtotime($invoice['booking_to']))."<br>";  
												 
												  if($invoice['status']=='1')
												  {
															$amountColor="style=' color:#e51c23; '";
															$amountTootip='Pending';
												  }
												  elseif($invoice['status']=='2')
												  {
														  $amountColor="style=' color:#ff9800; '";
														  $amountTootip='Partially paid';
												  }
												  elseif($invoice['status']=='3')
												  {
														  $amountColor="style=' color:#8bc34a; '";
														  $amountTootip='Paid';
												  }
														
												  $td4 .="<b ".$amountColor." data-placement='left'  data-toggle='tooltip' data-original-title='".$amountTootip."'>Total: $".add_decimal($total_amount)."</b>";;
			                                      $td4.='<br><span style="color:#b0b0b0;">Created: '.date('d M Y',strtotime($invoice['date'])).'</span>';	
											?>
                                            <tr>
                                                <td><?=$ongoingInvoiceListTd['td1']?></td>
                                                <td><?= $td4?></td>
                                                <td class="middle-alignment">Ongoing invoice</td>
                                                <td class="middle-alignment officeUseTd"><?=$ongoingInvoiceListTd['td_officeUse']?></td>
                                            </tr>
                                            <?php } 
											
											 foreach($invoices['initial'] as $invoice)
											{
												$initialInvoiceListTd=initialInvoiceListTd($invoice,'0');
												
												$total_amount=0;
												foreach($invoice['items'] as $item)
													$total_amount +=$item['total'];
												$td4='';
												if($invoice['booking_from']!='0000-00-00' && $invoice['booking_from']!='0000-00-00')
													$td4=date('d M Y',strtotime($invoice['booking_from'])).' to '.date('d M Y',strtotime($invoice['booking_to']))."<br>";  
											   
												if($invoice['status']=='1')
												{
														  $amountColor="style=' color:#e51c23; '";
														  $amountTootip='Pending';
												}
												elseif($invoice['status']=='2')
												{
														$amountColor="style=' color:#ff9800; '";
														$amountTootip='Partially paid';
												}
												elseif($invoice['status']=='3')
												{
														$amountColor="style=' color:#8bc34a; '";
														$amountTootip='Paid';
												}
													  
												$td4 .="<b ".$amountColor." data-placement='left'  data-toggle='tooltip' data-original-title='".$amountTootip."'>Total: $".add_decimal($total_amount)."</b>";;
												$td4.='<br><span style="color:#b0b0b0;">Created: '.date('d M Y',strtotime($invoice['date'])).'</span>';
											?>
                                            <tr>
                                                <td><?=$initialInvoiceListTd['td1']?></td>
                                                <td><?=$td4?></td>
                                                <td class="middle-alignment">Initial invoice</td>
                                                <td class="middle-alignment officeUseTd"><?=$initialInvoiceListTd['td_officeUse']?></td>
                                            </tr>
                                            <?php }?>
                                            </tbody>
                                        </table>           
                                
                                </div>
     							<div class="panel-footer"></div>
   							</div>
   
   
                        </div>
                        
                        
                        <div class="tab-pane" id="tab-booking-margin">
                        	
                            <div class="panel panel-default">
                        		<div class="panel-body no-padding">
                <form id="bookingMarginForm">
                <input type="hidden" id="marginBookingId" name="marginBookingId" value="<?=$booking['id']?>" >                	
                <div class="form-group col-xs-6" style="padding-left:0;">
                    <label class="control-label">From</label>
                    <input type="text" class="form-control" id="marginFrom" name="marginFrom" value="<?=date('d/m/Y',strtotime($booking['booking_from']))?>" onChange="" >
                </div>
                <div class="form-group col-xs-6" style="padding-left:0;">
                    <label class="control-label">To</label>
                    <input type="text" class="form-control" id="marginTo" name="marginTo" value="<?=date('d/m/Y',strtotime($booking['booking_from'].' + 9 days'))?>" onChange="" >
                </div>
                
                </form>
                <button class="btn-raised btn-primary btn btn-sm" style="margin-bottom: 40px;" onclick="getBookingMargn();">Submit</button>                    
                                        <div>
                                        <div id="tab-booking-margin-html" style="padding:10px;float:left;">
                                        	<h4>Invoice data</h4>
                                        	<div id="tab-booking-margin-html-data">Calculating booking margin</div>
                                        </div>            
                                        <div id="tab-booking-poData-html" style="padding:10px;float:left;">
                                        	<h4>Purcahse order data</h4>
                                        	<div id="tab-booking-poData-html-data">Calculating booking purchase order data</div>
                                        </div>            
                                        <div id="tab-booking-marginData-html" style="padding:10px;float:left;">
                                        	<h4>Margin</h4>
                                        	<div id="tab-booking-marginData-html-data">Calculating booking margin</div>
                                        </div>            
                                        <div id="tab-booking-paidTill-html" style="padding:10px;float:left;">
                                        	<h4>Paid till</h4>
                                        	<div id="tab-booking-paidTill-html-data">Calculating...</div>
                                        </div>       
                                        </div>   
                                
                                </div>
                                
                                
     							<div class="panel-footer"></div>
   							</div>
   
   
                        </div>
                        
                    </div>    
                    
			</div>
    </div>
    </div>
</div>

<script>
$(document).ready(function(){
	
	$('#marginFrom, #marginTo').datepicker({
			orientation: "top",
			todayHighlight: true,
	    	startDate: "<?=date('d/m/Y',strtotime($booking['booking_from']))?>",
			format:'dd/mm/yyyy',
			autoclose:true
		});
	
});
</script>