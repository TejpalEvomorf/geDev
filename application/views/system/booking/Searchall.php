<?php 
//see($result);
$clientsList=clientsList();

?>


<div class="page-heading">
      <h1>	Search All</h1>
        
        
        
</div>




<div class="container-fluid">                                
    <div data-widget-group="group1">
        <div class="row">
            <div class="col-md-12">
                
        <div class="panel panel-default" style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
           
            <div class="panel-body no-padding table-responsive">
                <div class="p-md">
                        <h4 class="mb-n"><?=   @$_GET['value']  ?><small>Search value</small></h4>
                </div>
                
                <div class="list-group searchall-list">
				<?php  if(!empty($result)){ 
		foreach($result as $k=>$val1){
				if (is_numeric($_GET['value']) ){
			if($k=='host'){
				$surl=site_url().'hfa?type=global&host='.@$_GET['value'];	

			}else if($k=='student'){
				$surl=site_url().'sha?type=global&student='.@$_GET['value'];	
			}else if($k=='booking'){
				$surl=site_url().'booking?type=global&booking_id='.@$_GET['value'];	
			}else if($k=='client'){
				$surl=site_url().'client?type=global&client='.@$_GET['value'];	
			}else if($k=='initial invoice'){
				$surl=site_url().'invoice/initial_all?type=global&number='.@$_GET['value'];	
			}else if($k=='ongoing invoice'){
				$surl=site_url().'invoice/ongoing_all?type=global&number='.@$_GET['value'];	
			}else if($k=='purchase orders'){
				$surl=site_url().'purchase_orders/all?type=global&number='.@$_GET['value'];	
			}
			}else{
				
				if($k=='host'){
				$surl=site_url().'hfa?type=global&host='.@$_GET['value'];
				
			}else if($k=='student'){
				$surl=site_url().'sha?type=global&student='.@$_GET['value'];	
			}
			else if($k=='initial invoice'){
				$surl=site_url().'invoice/initial_all?type=global&student='.@$_GET['value'];	
			}else if($k=='ongoing invoice'){
				$surl=site_url().'invoice/ongoing_all?type=global&student='.@$_GET['value'];	
			}else if($k=='purchase orders'){
				$surl=site_url().'purchase_orders/all?type=global&host='.@$_GET['value'];	
			}
			}
			
			
			
			if($k=='host'){
				$result_icon="home";	
			}else if($k=='student'){
				$result_icon="face";	
			}else if($k=='client'){
				$result_icon="face";	
			}else if($k=='booking'){
				$result_icon="domain";	
			}else if($k=='initial invoice'){
				$result_icon="monetization_on";	
			}else if($k=='ongoing invoice'){
				$result_icon="monetization_on";	
			}else if($k=='purchase orders'){
				$result_icon="receipt";	
			}
						
			
				?>
                
                    <div class="list-group-item withripple">
                        <div class="row-action-primary">
                            <div class="progress-pie-chart"><i class="material-icons"><?php echo $result_icon; ?></i></div>
                        </div>
						<?php foreach( $result[$k] as  $val ) {
							if (!is_numeric($_GET['value']) ){
								if($k=='booking' &&  !empty($val['hostu'])){
									$surl=site_url().'booking?type=global&host='.@$_GET['value'];	
								}if($k=='booking' &&  !empty($val['shau'])){
									$surl=site_url().'booking?type=global&student='.@$_GET['value'];
									
								}if($k=='booking' &&  !empty($val['clientu'])){
									$surl=site_url().'booking?type=global&client='.@$_GET['value'];
									
								}
							}
							
							?>
					
                        <div class="row-content">
                            <div class="least-content">
                               <a href="<?php  echo @$surl ?>" class="btn btn-info">View</a>
                            </div>
							
                            <h4 class="list-group-item-heading"><?php  echo ucfirst($k) ?></h4>
                            <p class="list-group-item-text"><a href="<?php  echo @$surl ?>"><?=   @$_GET['value']  ?></a></p>
                        	<?php
                            if($k=='booking')
                             {?>
							<div><?php //echo see($val);
							echo 'Booking id: '.$val['id'];?></div>
                    <div>
                            <?php $hfaOne=getHfaOneAppDetails($val['host']);?>
                        <table>
                        <th><i class="material-icons"><?php echo $result_icon; ?></i>Host Details</th>
							<tr>
							<td><?php echo 'Host id: '.$hfaOne['id'];?></td>
							</tr>
                        <tr>
                            <td><?php echo 'Name: '.$hfaOne['fname'].' '.$hfaOne['lname'];?></td>
                        </tr>
                        <tr>
                          <td><a class="mailto" href=<?php echo 'mailto:'.$hfaOne['email'];?>><?php echo 'Email: '.$hfaOne['email'];?></a></td>
                        </tr>
                        <tr>
                            <td><?php 
							 $mobile = array($hfaOne['mobile'],$hfaOne['home_phone'],$hfaOne['work_phone']); 
							  foreach($mobile as $m){
								  if($m != ''){
									  echo $m.",";
								  }
								  else{}
							  }
							  //echo $hfaOne['mobile'].', '.$hfaOne['home_phone'].', '.$hfaOne['work_phone'];
								?>
							</td>
                        </tr>
                            <tr>
                                <td>
                                <?php
                              $hostaddress = $hfaOne['street'].', '.$hfaOne['suburb'].', '.$hfaOne['state'].', '.$hfaOne['postcode'];
                              echo getMapLocationLink($hostaddress);
                                ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div>
                            <?php	$shaOne=getshaOneAppDetails($val['student']);?>
								<table>
								<th><i class="material-icons"><?php echo $result_icon; ?></i>Student Details:</th>
									<tbody>
								<tr>
									<td><?php echo 'Student Id: '.$shaOne['id'];?></td>		
								</tr>	
								<tr>
									<td><?php echo 'Student college id/number: ';if($shaOne['sha_student_no'] != ''){echo $shaOne['sha_student_no'];}else{echo 'Not Available';}?></td>
								</tr>		
								<tr>
									<td><?php echo 'Name: '.$shaOne['fname'].' '.$shaOne['lname'];?></td>
								</tr>
								<tr>
									<td><a class="mailto" href=<?php echo 'mailto:'.$shaOne['email'];?>><?php echo 'Email: '.$shaOne['email'];?></a></td>
								</tr>
								<tr>
									<td><?php echo 'Tel: '.$shaOne['mobile'].', '.$shaOne['home_phone'];?></td>
								</tr>
								<tr><td><?php echo 'Client Id:'.$shaOne['client']; ?></td></tr>
											<tr>
										<td><?php 
							  foreach($clientsList as $cLK=>$cLV){
									if($shaOne['client'] == $cLV['id']){
										echo 'Client : '.$cLV['bname'];
									}		
								  
							  }?></td>
								</tr>
							
									</tbody>
								</table>
							</div>
									<?php 
									 }else if($k=='student'){
							?>	
							<div>
								<table>
								<th><i class="material-icons"><?php echo $result_icon; ?></i>Student Details:</th>
									<tbody>
								<tr>
									<td><?php echo 'Student Id: '.$val['id'];?></td>		
								</tr>	
								<tr>
									<td><?php echo 'Student college id/number: ';if($val['sha_student_no'] != ''){echo $val['sha_student_no'];}else{echo 'Not Available';}?></td>
								</tr>
								<tr>
									<td><?php echo 'Name: '.$val['fname'].' '.$val['lname'];?></td>
								</tr>
								<tr>
									<td><a class="mailto" href=<?php echo 'mailto:'.$val['email'];?>><?php echo 'Email: '.$val['email'];?></a></td>
								</tr>
								<tr>
									<td><?php echo 'Tel: '.$val['mobile'].', '.$val['home_phone'];?></td>
								</tr>
								<tr><td><?php echo 'Client Id:'.$val['client']; ?></td></tr>
								<tr>
										<td><?php 
							  foreach($clientsList as $cLK=>$cLV){
									if($val['client'] == $cLV['id']){
										echo 'Client: '.$cLV['bname'];
									}		
								  
							  }?></td>
								</tr>
									</tbody>
								</table>
							</div>
							<?php }else if($k=='host'){ ?>
							<div>
								<table>
								<th><i class="material-icons"><?php echo $result_icon; ?></i>Host Details</th>
									<tr>
							<td><?php echo 'Host id: '.$val['id'];?></td>
							</tr>
								<tr>
									<td><?php echo $val['fname'].' '.$val['lname'];?></td>
								</tr>
								<tr>
									<td><a class="mailto" href=<?php echo 'mailto:'.$val['email'];?>><?php echo $val['email'];?></a></td>
								</tr>
								<tr>
									<td><?php echo $val['mobile'].', '.$val['home_phone'].', '.$val['work_phone'];?></td>
								</tr>
									<tr>
										<td>
										<?php
									  $hostaddress = $val['street'].', '.$val['suburb'].', '.$val['state'].','.$val['postcode'];
									  echo getMapLocationLink($hostaddress);
										?>
										</td>
									</tr>
								</table>
							</div>
							
							<?php }else if($k=='client'){ ?>
							<div>
								<table>
								<th><i class="material-icons"><?php echo $result_icon; ?></i>Client Details</th>
									<tr>
							<td><?php echo 'Client id: '.$val['id'];?></td>
							</tr>
								<tr>
									<td><?php echo 'Bname: '.$val['bname'];?></td>
								</tr>
									<tr>
									<td><?php echo 'Name: '.$val['primary_contact_name'].$val['primary_contact_lname'];?></td>
									</tr>
								<tr>
									<td><a class="mailto" href=<?php echo 'mailto:'.$val['primary_email'];?>><?php echo 'Email: '.$val['primary_email'];?></a></td>
								</tr>
								<tr>
									<td><?php echo $val['primary_phone'].', '.$val['sec_phone'];?></td>
								</tr>
									
								</table>
							</div>
							
							<?php }elseif($k=='initial invoice'||$k=='ongoing invoice'){?>
							<div>
							<?php //echo see($val);
							$shaOne=getshaOneAppDetails($val['application_id']);	
							?>
								<table>
								<th><i class="material-icons"><?php echo $result_icon; ?></i>Details:</th>
									<tbody>
										<tr><td><?php echo 'Id: '.$val['id']; ?></td></tr>
										<tr><td><?php echo 'Invoice Number: '.$val['invoice_number']; ?></td></tr>
								<tr>
									<td><?php echo 'Student Id: '.$shaOne['id'];?></td>		
								</tr>	
								<tr>
									<td><?php echo 'Student college id/number: ';if($shaOne['sha_student_no'] != ''){echo $shaOne['sha_student_no'];}else{echo 'Not Available';}?></td>
								</tr>		
								<tr>
									<td><?php echo 'Name: '.$shaOne['fname'].' '.$shaOne['lname'];?></td>
								</tr>
								<tr>
									<td><a class="mailto" href=<?php echo 'mailto:'.$shaOne['email'];?>><?php echo 'Email: '.$shaOne['email'];?></a></td>
								</tr>
								<tr>
									<td><?php echo 'Tel: '.$shaOne['mobile'].', '.$shaOne['home_phone'];?></td>
								</tr>
								<tr><td><?php echo 'Client Id:'.$shaOne['client']; ?></td></tr>
											<tr>
										<td><?php 
							  foreach($clientsList as $cLK=>$cLV){
									if($shaOne['client'] == $cLV['id']){
										echo 'Client : '.$cLV['bname'];
									}		
								  
							  }?></td>
								</tr>
							
									</tbody>
								</table>
							</div>
							
							<?php }elseif($k=='purchase orders'){ ?>
							  <div>
                        <table>
							<th>Details: </th>
							<tr>
								<td>
                            <?php  echo 'Purchase Order Id: '.$val['id'];?>
								</td>
							</tr>
							<tr>
								  <td>
							<?php echo 'Booking Id: '.$val['booking_id']; ?>
								  </td>
							</tr>

							<tr>
								<td>
                            <?php echo 'From: '.$val['from'];?>
								</td>
							</tr>
							<tr>
								<td>
                            <?php echo 'To: '.$val['to'];?>
								</td>
							</tr>
							<tr>
								<td>
                            <?php echo 'Xero Id: '.$val['po_id_xero'];?>
								</td>
							</tr>
														
							<tr>
								  <td>
							<?php echo 'Due Date: '.$val['due_date']; ?>
								  </td>
							</tr>
							

                        <th><i class="material-icons"><?php echo $result_icon; ?></i>Host Details</th>
							<tr><td><?php echo 'Host Id: '.$val['host']; ?></td></tr>
                        <tr>
                            <td><?php echo $val['fname'].' '.$val['lname'];?></td>
                        </tr>
                        <tr>
                          <td><a class="mailto" href=<?php echo 'mailto:'.$val['email'];?>><?php echo $val['email'];?></a></td>
                        </tr>
                        <tr>
                            <td><?php 
							 $mobile = array($val['mobile'],$val['home_phone'],$val['work_phone']); 
							  foreach($mobile as $m){
								  if($m != ''){
									  echo $m.",";
								  }
								  else{}
							  }
							  //echo $hfaOne['mobile'].', '.$hfaOne['home_phone'].', '.$hfaOne['work_phone'];
								?>
							</td>
                        </tr>
                            <tr>
                                <td>
                                <?php
                              $hostaddress = $val['street'].', '.$val['suburb'].', '.$val['state'].', '.$val['postcode'];
                              echo getMapLocationLink($hostaddress);
                                ?>
                                </td>
                            </tr>
                            
                        </table>
                    </div>
                  
							<?php } ?>
						</div>
						<?php  } ?>
                        
                        
                    </div>
                    <div class="list-group-separator"></div>
                    
                    <?php  }}?>
                </div>
				
            </div>
        </div>
    
            </div>
        </div>
    </div>
</div>


