 <?php
$nationList=nationList();
$genderList=genderList();
$houseTypeList=houseTypeList();
?>
                       	 
            <div class="col-md-3">
				<div class="panel panel-profile panel-bluegraylight" style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
					<div class="panel-heading">
						<h2>General Details</h2>
					</div>
					<div class="panel-body">
						<div>
                        
                         <div class="personel-info pt-n">
							<span class="icon"><i class="material-icons">person</i></span>
							<span><?php echo ucwords($formOne['first_name'].' '.$formOne['last_name']);?></span>
						</div>
                        
						<div class="personel-info">
							<span class="icon"><i class="material-icons">phone_iphone</i></span>
							<span class="phone-icon-phone"><?php echo $formOne['mobile'];?></span>
						</div>
                        
							<div class="personel-info">
								<span class="icon"><i class="fa fa-<?=strtolower($genderList[$formOne['gender']])?>"></i></span>
								<span><?php echo $genderList[$formOne['gender']]; ?></span>
							</div>
                            
							<div class="personel-info">
								<span class="icon"><i class="material-icons">email</i></span>
								<span><?php echo $formOne['email'];?></span>
							</div>
                            
                            <div class="personel-info">
								<span class="icon"><i class="material-icons">flag</i></span>
								<span><?php echo $nationList[$formOne['nationality']];?></span>
							</div>
						</div>
					</div>
				</div>
                                   

</div>
                        
<div class="col-md-9 panel-profile">
		<div class="sha-details">
         
				  <div class="property-details-all tab-pane panel panel-success" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">                     
				<div class="panel-heading">
					<h2>ALL DETAILS</h2>
                  </div>
					                                
                           <div class="about-area p-md">
                            <div class="table-responsive panel panel-default" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                                    <div class="panel-body">
									<?php 
										//echo "<pre>";
										//print_r($formOne);
									?>
									<table class="table about-table">
										<tbody>
											<tr>
												<th>Service type</th>
												<td><?php if(!empty($formOne['service_type'])) { echo $houseTypeList[$formOne['service_type']]; } else { echo 'n/a'; } ?></td>
											</tr>
                                            <tr>
												<th>Arrival date / Time</th>
                                                <td><?php echo date('d M Y',strtotime($formOne['arrival_date']));
													if($formOne['arrival_time']!='00:00:00') {
														echo ', ',date('h:i A',strtotime($formOne['arrival_time']));
													}
												
												?></td>
											</tr>
											<tr>
												<th>Flight number</th>
												<td><?php if(!empty($formOne['flight_no'])) { echo ucfirst($formOne['flight_no']); } else { echo 'n/a'; }?></td>
											</tr>
                                            <tr>
												<th>College name</th>
												<td><?php if(!empty($formOne['college_name'])) {  echo ucfirst($formOne['college_name']); } else { echo 'n/a'; } ?></td>
											</tr>
                                            
                                            <tr>
												<th>College address</th>
												<td><?php if(!empty($formOne['college_address'])) { echo ucfirst($formOne['college_address']); } else { echo 'n/a';}?></td>
											</tr>
										</tbody>
									</table>
                                    </div>
								</div>
							</div>
                                                 
      </div>
           
                           
   </div>                 
		</div>
 
