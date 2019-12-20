<?php
 
$stateList=stateList();
$accomodationTypeList=accomodationTypeList();
$bookingStatusList=bookingStatusList();
?>
<style>
.btn.btn-midnightblue.btn-sm1 {
    background: hsla(0, 0%, 0%, 0) none repeat scroll 0 0;
    color: hsl(358, 80%, 50%) !important;
    /* position: absolute; */
    right: 15px;
    top: 2px;
}
</style>

<div class="ge-app-submenu col-md-12 pl-n pr-n">
    <ul class="nav nav-tabs material-nav-tabs mb-lg" style="width: auto;margin: 0 auto;">
        <li class="active"><a href="#tab-90-1" data-toggle="tab"> Booking history </a></li>
        <li><a href="#tab-90-2" data-toggle="tab"> Payment history</a></li>
    </ul>
</div>


<div class="container-fluid">                                
    <div data-widget-group="group1">
	<div class="row">
            <div class="col-md-12">
            
            		<div class="p-n col-md-12 tab-content">
                    	<div class="tab-pane active" id="tab-90-1">
                        	
                            <div class="panel panel-default">
                        		<div class="panel-body no-padding">
                                	
                        			<table id="bookingHistoryList" class="noborder0 table table-striped table-bordered table-fixed-header m-n" cellspacing="0" width="100%">
                                    <thead>
                                      <tr>
                                      <th>Booking info</th>
                                      <th>Host</th>
                                      <th>Status</th>
                                      <th width="120px">Office use</th>
                                      <th width="80px">Actions</th>
                                      </tr>
                                  </thead>
                                    <tbody>
                                  </tbody>
                                   </table>           
                                
                                </div>
     							<div class="panel-footer"></div>
   							</div>
							<?php 
							$this->load->view('system/booking/changeStatusPopUp');
                            $this->load->view('system/booking/editBookingPopUp');
                            ?>
   
                        </div>
                        
                        <div class="tab-pane" id="tab-90-2">
                        	
                            <div class="panel panel-default">
                        		<div class="panel-body no-padding">
                                	
                        			<table id="paymentHistoryList" class="noborder0 table table-striped table-bordered table-fixed-header m-n" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                        <th >Booking info</th>
                                        <th >Payment info</th>
                                        <th >Status</th>
                                        <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                    <?php
							  foreach($payment_history as $pHK=>$pH){
								
								$bookingDetailspH=bookingDetails($pH['booking_id']);//see($bookingDetailspH);
							  $studentPH=getShaOneAppDetails($pH['sha_id']);
							  if($bookingDetailspH['booking_from']!='0000-00-00')
							 	 $st=date('d M Y',strtotime($bookingDetailspH['booking_from']));
							  else
								 $st ='Not set';
							  if($bookingDetailspH['booking_to']!='0000-00-00')
							 	$endd=' - '.date('d M Y',strtotime($bookingDetailspH['booking_to'].' +1 day'));
							  else
								$endd =' - Not set';
								
								
								$paymentDuration=date('d M Y',strtotime($pH['payment_from']));
								if($pH['payment_to']!='0000-00-00')
									$paymentDuration .=' - '.date('d M Y',strtotime($pH['payment_to']));
							?>
						  
                          <tr role="row">
						  <td><strong>Booking id: <?= $pH['booking_id']?></strong><br>Duration: <?=$st.$endd ?><br><?=$accomodationTypeList[$studentPH['accomodation_type']] ?></td>
						  <td><?='$'.add_decimal($pH['total_amount'])?><br><?=$paymentDuration?><br><?=$pH['no_of_items'].' invoice item'.s($pH['no_of_items'])?></td>
						  <td>
						  	<?php 
								if($pH['status']=='1')
									echo "Pending";
								elseif($pH['status']=='2')
									echo "Partially paid";
								elseif($pH['status']=='3')
									echo "Paid";
							?>
                          </td>
						  <td class=" middle-alignment"><div class="btn-group dropdown table-actions">
						  <button class="btn btn-sm1 btn-midnightblue dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="true" style="top: -5px;"><i class="colorBlue material-icons">more_horiz</i>
						  <div class="ripple-container"></div></button><ul class="dropdown-menu" role="menu">
						  	
						  <li><a href="<?=site_url()?>group_invoice/view/<?=$pH['invoice_id']?>" target="_blank"><i class="font16 material-icons">remove_red_eye</i>&nbsp;&nbsp;View invoice</a></li></ul></div></td></tr>
						 <?php  } ?>
                                     </tbody>
                                   </table>           
                                
                                </div>
     							<div class="panel-footer"></div>
   							</div>
   
   
                        </div>
                        
                    </div>    
                    
			</div>
    </div>
    </div>
</div>
