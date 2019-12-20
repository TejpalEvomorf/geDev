<?php
$stateList=stateList();
$accomodationTypeList=accomodationTypeList();
$bookingStatusList=bookingStatusList();

							  foreach($booking_history as $k1=>$val){
									$bookingBedNumber=bookingBedNumber($val['bookid']);
								   if($val['booking_from']!='0000-00-00')
			 {
				 $st=date('d M Y',strtotime($val['booking_from']));
					 
			 }else	{
						$st ='Not set';
			 }
			  if($val['booking_to']!='0000-00-00')
			 {
				 $endd=' - '.date('d M Y',strtotime($val['booking_to'].' +1 day'));
					 
			 }else	{
						$endd =' - Not set';
			 }
			  $row1 ='';
			  $addressForMap='';
			  if($val['street']!='')
				$addressForMap .=$val['street'].", ";
			  $addressForMap .=ucfirst($val['suburb']).", ".$stateList[$val['state']].", ".$val['postcode'];
			  $row1 .=getMapLocationLink($addressForMap);
				
			  $row4='<button class="mt-n mb-xs btn btn-sm btn-label" data-toggle="modal" data-target="#model_ChangeStatusBooking"  onclick="bookingChangeStatusPopContent('.$val['bookid'].','.'\'all\''.');" id="changeStatusBookingEditBtn-'.$val['bookid'].'">';
			  $row4 .='<i class="material-icons font14">edit</i>';
			  $row4 .='<span>';
			  $row4 .=$bookingStatusList[$val['status']];
			  $row4 .='</span>';
			  $row4 .='</button>';	
			
			  $row6='';
			 if($val['study_tour_id']!=0)
			 {
				$tourDetail=tourDetail($val['study_tour_id']);
				$row6 .='<a href="javascript:void(0);"><i class="material-icons" data-placement="bottom" data-toggle="tooltip"  data-original-title="Part of a tour group: '.ucwords($tourDetail['group_name']).'">stars</i></a>';
			 }
			 
			 if($val['status']=='expected_arrival' && $val['arrival_date']!='0000-00-00')
			 {
				 //$daysToCheckIn=daydiff(date('Y-m-d'),$booking->booking_from)-1;
				 //$daysToCheckIn=daydiff(date('Y-m-d'),'2018-02-25')-1;
				 $daysToCheckIn=daydiff(date('Y-m-d'),$val['arrival_date'])-1;
				 if($daysToCheckIn<5 && $daysToCheckIn>=0)
				 {
					 $toolTipText='Student arriving ';
					 if($daysToCheckIn<5)
					 {
					 	if($daysToCheckIn>0)
							$toolTipText .='in '.$daysToCheckIn.' day'.s($daysToCheckIn);
						if($daysToCheckIn==0)
						 	$toolTipText .='today';
					 }
					 
					$row6 .='<a href="javascript:void(0);"><i class="material-icons colorOrange" data-placement="bottom" data-toggle="tooltip"  data-original-title="'.$toolTipText.'">new_releases</i></a>';
				 }
				 if($daysToCheckIn<0)
					 $row6 .='<a href="javascript:void(0);"><i class="material-icons colorRed" data-placement="bottom" data-toggle="tooltip"  data-original-title="Arrival check">new_releases</i></a>';
			 }
			 
			 	if($val['status']=='expected_arrival'|| $val['status']=='arrived' || $val['status']=='progressive'){
				 $row6 .='<i data-toggle="tooltip" data-original-title="Active Booking" data-placement="bottom" class="fa fa-circle" style="color:green; font-size:22px; vertical-align: middle; margin-left: 3px;"></i>';
               }
			 $row6 .='';
			 
			 
			 
			 
						  ?>
						  
				
						
                          <tr role="row" id="booking-<?= $val['bookid']?>">
						  <td><strong>Booking id: <?= $val['bookid']?></strong><br>Duration: <span id="viewBooking_duration"><?=$st.$endd ?></span><br><?=  $accomodationTypeList[$val['accomodation_type']].' (Room '.$bookingBedNumber.')' ?></td>
						  <td><a href='<?= site_url() ?>hfa/application/<?=  $val['host'] ?>' target="_blank"><?=  ucfirst($val['hlname']).' Family' ?></a><br><a class="mailto" href="mailto:<?=$val['hemail']?>"><?=   $val['hemail']  ?></a><br><?=  $row1 ?></td>
						  <td class=" middle-alignment" style="text-transform: uppercase; font-weight: 500;"><?=$row4?> </td>
						  <td class=" middle-alignment"><?=  $row6; ?></td>
						  <td class=" middle-alignment"><div class="btn-group dropdown table-actions">
						  <button class="btn btn-sm1 btn-midnightblue dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="true" style="top: -5px;"><i class="colorBlue material-icons">more_horiz</i>
						  <div class="ripple-container"></div></button>
                          <ul class="dropdown-menu" role="menu">
						  <li><a href="<?=site_url()?>booking/view/<?=$val['bookid']?>" target="_blank"><i class="font16 material-icons">remove_red_eye</i>&nbsp;&nbsp;View</a></li>
                          <li><a href="javasctipt:;" onclick="editBookingPopContent(<?=$val['bookid']?>)" data-toggle="modal" data-target="#model_editBooking"><i class="font16 material-icons">edit</i>&nbsp;&nbsp;Edit</a></li>
                          <?php if($val['status']=='expected_arrival'){?>
                          	<li><a href="javascript:;" class="bookingDelete" id="bookingDelete-<?=$val['bookid']?>"><i class="font16 material-icons">delete</i>&nbsp;&nbsp;Delete</a></li>
                          <?php } ?>
                          </ul></div></td></tr>
						 <?php  } ?>