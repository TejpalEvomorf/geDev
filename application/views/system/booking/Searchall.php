<div class="page-heading">
      <h1>Search All</h1>        
</div>

<div class="container-fluid">                                
    <!-- <div data-widget-group="group1"> -->
        <!-- <div class="row"> -->
            <!-- <div class="col-md-12"> -->
                
        <div class="panel panel-default " style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
           
            <div class="panel-body no-padding table-responsive list-group-item withripple">
                 <div class="p-md">
                        <h4 class="mb-n"><?=   @$_GET['value']  ?><small>Search value</small></h4>
                </div>
                
    <div class="list-group searchall-list panel-body">
	<table class="table about-table" >
	<tbody  >
         	
		<tr>
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
				$result_icon="account_box";	
			}else if($k=='booking'){
				$result_icon="domain";	
			}else if($k=='initial invoice'){
				$result_icon="monetization_on";	
			}else if($k=='ongoing invoice'){
				$result_icon="monetization_on";	
			}else if($k=='purchase orders'){
				$result_icon="receipt";	
			}?>
					<!-- <div class="list-group-item withripple"> -->
						<?php foreach( $result[$k] as  $val ) {
							if (!is_numeric($_GET['value']) ){
								if($k=='booking' &&  !empty($val['hostu'])){
									$surl=site_url().'booking?type=global&host='.@$_GET['value'];	
								}if($k=='booking' &&  !empty($val['shau'])){
									$surl=site_url().'booking?type=global&student='.@$_GET['value'];
								}if($k=='booking' &&  !empty($val['clientu'])){
									$surl=site_url().'booking?type=global&client='.@$_GET['value'];}
						}?>

		<?php if($k=="booking"){ $hfaOne=getHfaOneAppDetails($val['host']); $shaOne=getshaOneAppDetails($val['student']);?>
		</tr>

		<tr data-toggle="collapse" data-target="#bookings<?=$val['id']?>" class="bookingresult" >
		<td ><div class="material-icons" ><?=$result_icon; ?></div></td>
		<!-- Bookings detail Table Starts-->
		<td>
		<div data-toggle="collapse" data-target="#bookings<?=$val['id']?>" class="bookingresult" >
		<h4><?=ucfirst($k)." Id: "?><a href='<?=site_url().'booking/view/'.$val['id'] ?>' target="_blank"><?=$val['id']?></a></h4>
		</div>
		<div id="bookings<?=$val['id']?>" class="collapse">
		<p class="exactResult"><strong><?='Booking id: ';?></strong><?=$val['id'];?></p>
		<!-- Host & Student  TR in Bookings Starts -->
		<h5>Host Details</h5>
		<p><?='Host id: '.$hfaOne['id'];?></p>
		<p><?='Name: '.$hfaOne['fname'].' '.$hfaOne['lname'];?></p>
		<p><a class="mailto" href=<?='mailto:'.$hfaOne['email'];?>><?='Email: '.$hfaOne['email'];?></a></p>
		<p><?php echo "Tel: ";if($hfaOne['mobile']!=''){echo $hfaOne['mobile'];}if($hfaOne['home_phone']!=""){echo ", ".$hfaOne['home_phone']; } ?></p>
		<!-------------------------------------------------------------------------------------------------------------------------------------------->
		<h5>Student </h5>
		<p><?='Student Id: '.$shaOne['id'];?></p>	
		<p><?='Student college id/number: ';if($shaOne['sha_student_no'] != ''){echo $shaOne['sha_student_no'];}else{echo 'Not Available';}?></p>		
		<p><?='Name: '.$shaOne['fname'].' '.$shaOne['lname'];?></p>
		<p><a class="mailto" href=<?='mailto:'.$shaOne['email'];?>><?='Email: '.$shaOne['email'];?></a></p>
		<p><?php echo "Tel: ";if($shaOne['mobile']!=''){echo $shaOne['mobile'];}if($shaOne['home_phone']!=""){echo ", ".$shaOne['home_phone']; } ?></p>
		<p><?='College: '.$val['college']?></p>
		<p><?='Client Id:'.$shaOne['client']; ?></p>
		<p><?='Client: '.$val['bname']?></p>
		</div>
		</td>
		<td class=" bookingresult" data-toggle="collapse" data-target="#bookings<?=$val['id']?>"  ><h4><a>Details</a></h4></td>
		<td><?php }elseif ($k=='host') {?> </td>
		</tr>
		<!-- Host & Student Detalis TR in Bookings Ends -->
			
		<!-- Host Search Result  Starts -->
		<tr data-toggle="collapse" data-target="#host<?=$val['id']?>" class="hostresult">
			<td ><div class="material-icons" ><?=$result_icon; ?></div></td>
			<td data-toggle="collapse" data-target="#host<?=$val['id']?>" class="hostresult">
			<h4><?=ucfirst($k)." Id: "?><a href='<?=site_url().'hfa/application/'.$val['id'] ?>' target="_blank"><?=$val['id']?></a></h4>
			<div id="host<?=$val['id']?>" class="collapse">						
			<p><?='Host id: ';?><?=$val['id'];?></p>
			<p><?=$val['fname'].' '.$val['lname'];?></p>
			<p><a class="mailto" href=<?='mailto:'.$val['email'];?>><?=$val['email'];?></a></p>
			<p><?php echo "Tel: ";if($val['mobile']!=''){echo $val['mobile'];}if($val['home_phone']!=""){echo ", ".$val['home_phone']; } ?></p>
			</div>
			</td>
			<td data-toggle="collapse" data-target="#host<?=$val['id']?>" class="hostresult"><h4><a>Details</a></h4></td>
			<td><?php }else if($k=='student'){?></td>
		</tr>
		<!-- Host Search Result  Ends -->
		
		<!-- Student Search Result  Starts -->
		<tr data-toggle="collapse" data-target="#student<?=$val['id']?>" class="studentresult">
			<td ><div class="material-icons" ><?=$result_icon; ?></div></td>
			<td data-toggle="collapse" data-target="#student<?=$val['id']?>" class="studentresult">
			<h4><?=ucfirst($k)." Id: "?><a href='<?=site_url().'sha/application/'.$val['id'] ?>' target="_blank"><?=$val['id']?></a></h4>	
			<div id="student<?=$val['id']?>" class="collapse">
			<p><?='Student Id: ';?><?=$val['id'];?></p>
			<p><?='Student college id/number: ';if($val['sha_student_no'] != ''){echo $val['sha_student_no'];}else{echo 'Not Available';}?></p>
			<p><?='Name: '.$val['fname'].' '.$val['lname'];?></p>
			<p><a class="mailto" href=<?='mailto:'.$val['email'];?>><?='Email: '.$val['email'];?></a></p>
			<p><?php echo "Tel: ";if($val['mobile']!=''){echo $val['mobile'];}if($val['home_phone']!=""){echo ", ".$val['home_phone']; } ?></p>
			<p><?='College: '.$val['college']?></p>
			<p><?='Client Id:'.$val['client']; ?></p>
			<p><?='Client: '.$val['bname']?></p>
			</div>
			</td>
			<td data-toggle="collapse" data-target="#student<?=$val['id']?>" class="studentresult "><h4><a>Details</a></h4></td>
			<td><?php }else if($k=='client'){ ?></td>
		</tr>
		<!-- Student Search Results Details Ends -->
		
		<!-- Client Search Results Details Starts -->
		<tr data-toggle="collapse" data-target="#client<?=$val['id']?>" class="clientresult">
			<td ><div class="material-icons" ><?=$result_icon; ?></div></td>
			<td data-toggle="collapse" data-target="#client<?=$val['id']?>" class="clientresult">
			<h4><?=ucfirst($k)." Id: "?><a href="<?=site_url().'client/edit/'.$val['id']; ?>" target="_blank"><?=$val['id']?></a></h4>
			<div id="client<?=$val['id']?>" class="collapse">
			<p><?='Client id: ';?><?=$val['id'];?></p>
			<p><?='Bname: '.$val['bname'];?></p>
			<p><?='Name: '.$val['primary_contact_name'].$val['primary_contact_lname'];?></p>
			<p><?=$val['primary_phone'].', '.$val['sec_phone'];?></p>	
			<p><a class="mailto" href=<?='mailto:'.$val['primary_email'];?>><?='Email: '.$val['primary_email'];?></a></p>
			</div>
			</td>
			<td data-toggle="collapse" data-target="#client<?=$val['id']?>" class="clientresult "><h4><a>Details</a></h4></td>
			<td><?php }elseif($k=='initial invoice'||$k=='ongoing invoice'){$shaOne=getshaOneAppDetails($val['application_id']);?></td>
		</tr>
		<!-- Clients Search Results Detals Starts -->
		
		<!-- Initial and Ongoing Invoice Search Result  Start -->
		<tr data-toggle="collapse" data-target="#invoice<?=$val['id']?>" class="invoiceresult">
			<td ><div class="material-icons" ><?=$result_icon; ?></div></td>
			<td data-toggle="collapse" data-target="#invoice<?=$val['id']?>" class="invoiceresult">
			<h4><?=ucfirst($k)." Id: "?><a href="<?php if($k=='initial invoice'){$invoice = 'view_initial';}else{$invoice = 'view_ongoing';}echo site_url().'invoice/'.$invoice.'/'.$val['id']; ?>" target="_blank"><?=$val['id']?></a></h4>
			<div id="invoice<?=$val['id']?>" class="collapse">
			<p><?='Invoice Id: ';?><?=$val['id']; ?></p>
			<p><?='Invoice Number: '.$val['invoice_number']; ?></p>
			<p><?='Xero Id: '.$val['xero_invoiceId']; ?></p>
			<p><?='Student Id: '.$shaOne['id'];?></p>	
			<p><?='Student college id/number: ';if($shaOne['sha_student_no'] != ''){echo $shaOne['sha_student_no'];}else{echo 'Not Available';}?></p>		
			<p><?='Name: '.$shaOne['fname'].' '.$shaOne['lname'];?></p>
			<p><a class="mailto" href=<?='mailto:'.$shaOne['email'];?>><?='Email: '.$shaOne['email'];?></a></p>
			<p><?='Tel: '.$shaOne['mobile'].', '.$shaOne['home_phone'];?></p>
			<p><?='College: '.$val['college']?></p>
			<p><?='Client Id:'.$shaOne['client']; ?></p>
			<p><?='Client: '.$val['bname']?></p>
			</div>
			</td>
			<td  data-toggle="collapse" data-target="#invoice<?=$val['id']?>" class="invoiceresult "><h4><a>Details</a></h4></td>
			<td><?php }elseif($k=='purchase orders'){ ?></td>
		</tr> 
		<!-- Initial and Ongoing Invoice Search Result Deatils Ends -->
		
		<!-- Purchase Order Search Results Details Starts -->
		<tr data-toggle="collapse" data-target="#po<?=$val['id']?>" class="poresult">
			<td ><div class="material-icons" ><?=$result_icon; ?></div></td>
			<td data-toggle="collapse" data-target="#po<?=$val['id']?>" class="poresult">
			<h4><?=ucfirst($k)." Id: "?><a href="<?=site_url().'purchase_orders/view/'.$val['id'] ?>" target="_blank"><?=$val['id']?></a></h4>
			<div id="po<?=$val['id']?>" class="collapse">
			<p><?='Purchase Order Id: ';?><a href="<?=site_url().'purchase_orders/view/'.$val['id'] ?>" target="_blank"><?=$val['id'];?></a></p>
			<p><?='Booking Id: '.$val['booking_id']; ?></p>
			<p><?='From: '.$val['from'];?></p>
			<p><?='To: '.$val['to'];?></p>
			<p><?='Xero Id: '.$val['po_id_xero'];?></p>							
			<p><?='Due Date: '.$val['due_date']; ?></p>
			<p><h4>Host Details</h4></p>
			<p><?='Host Id: '.$val['host']; ?></p>
	    	<p><?=$val['fname'].' '.$val['lname'];?></p>
	    	<p><a class="mailto" href=<?='mailto:'.$val['email'];?>><?=$val['email'];?></a></p>
	    	<p><?php $mobile = array($val['mobile'],$val['home_phone'],$val['work_phone']); foreach($mobile as $m){if($m != ''){echo $m.",";}}?></p>
	       	</div>
			</td>
			<td data-toggle="collapse" data-target="#po<?=$val['id']?>" class="poresult "><h4><a>Details</a></h4></td>
		</tr>
		<!-- Purchase Order Search Results Details Ends-->
		
		<tr>
			<?php }}}}if(!empty($result1)){ 
		foreach($result1 as $k=>$val1){
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
				$result_icon="account_box";	
			}else if($k=='booking'){
				$result_icon="domain";	
			}else if($k=='initial invoice'){
				$result_icon="monetization_on";	
			}else if($k=='ongoing invoice'){
				$result_icon="monetization_on";	
			}else if($k=='purchase orders'){
				$result_icon="receipt";	
			}?>
			<?php foreach( $result1[$k] as  $val ){
			if (!is_numeric($_GET['value']) ){
					if($k=='booking' &&  !empty($val['hostu'])){
						$surl=site_url().'booking?type=global&host='.@$_GET['value'];	
					}if($k=='booking' &&  !empty($val['shau'])){
						$surl=site_url().'booking?type=global&student='.@$_GET['value'];
					}if($k=='booking' &&  !empty($val['clientu'])){
						$surl=site_url().'booking?type=global&client='.@$_GET['value'];}
			}?>
			<?php if($k=="booking"){ $hfaOne=getHfaOneAppDetails($val['host']); $shaOne=getshaOneAppDetails($val['student']); ?> 
	</tr>
		<tr data-toggle="collapse" data-target="#bookingo<?=$val['id']?>" class="bookingoresult">
			<td><div class="material-icons" ><?=$result_icon; ?></div></td>
			<td  data-toggle="collapse" data-target="#bookingo<?=$val['id']?>" class="bookingoresult">
			<h4><?=ucfirst($k)." Id: "?><a href='<?=site_url().'booking/view/'.$val['id'] ?>' target="_blank"><?=$val['id']?></a></h4>
			<div id="bookingo<?=$val['id']?>" class="collapse">
			<p class="otherResult"><strong><?='Booking id: ';?></strong><?=$val['id'];?></p>
			<!-- Host & Student  TR in Bookings Starts -->
			<h5>Host Details</h5>
			<p><?='Host id: '.$hfaOne['id'];?></p>
			<p><?='Name: '.$hfaOne['fname'].' '.$hfaOne['lname'];?></p>
			<a class="mailto" href=<?='mailto:'.$hfaOne['email'];?>><p><?='Email: '.$hfaOne['email'];?></p></a>
			<p><?php echo "Tel: ";if($hfaOne['mobile']!=''){echo $hfaOne['mobile'];}if($hfaOne['home_phone']!=""){echo ", ".$hfaOne['home_phone']; } ?></p>
			<!--------------------------------------------------------------------------------------------------------->
			<h5>Student </h5>
			<p><?='Student Id: '.$shaOne['id'];?></p>	
			<p><?='Student college id/number: ';if($shaOne['sha_student_no'] != ''){echo $shaOne['sha_student_no'];}else{echo 'Not Available';}?></p>		
			<p><?='Name: '.$shaOne['fname'].' '.$shaOne['lname'];?></p>
			<a class="mailto" href=<?='mailto:'.$shaOne['email'];?>><p><?='Email: '.$shaOne['email'];?></p></a>
			<p><?php echo "Tel: ";if($shaOne['mobile']!=''){echo $shaOne['mobile'];}if($shaOne['home_phone']!=""){echo ", ".$shaOne['home_phone']; } ?></p>
			<p><?='College: '.$val['college']?></p>
			<p><?='Client Id:'.$shaOne['client']; ?></p>
			<p><?='Client: '.$val['bname']?></p>
			</div>
			</td>
			<td data-toggle="collapse" data-target="#bookingo<?=$val['id']?>" class="bookingoresult "><h4><a>Details</a></h4></td>
			<td><?php }elseif ($k=='host') { ?></td>
		</tr>
		<!-- Host & Student Detalis TR in Bookings Ends -->
		
		<!-- Host Search Result  Starts -->	
		<tr data-toggle="collapse" data-target="#hosto<?=$val['id']?>" class="hostoresult" >
			<td ><div class="material-icons" ><?=$result_icon; ?></div></td>
			<td  data-toggle="collapse" data-target="#hosto<?=$val['id']?>" class="hostoresult">
			<h4><?=ucfirst($k)." Id: "?><a href='<?=site_url().'hfa/application/'.$val['id'] ?>' target="_blank"><?=$val['id']?></a></h4>	
			<div id="hosto<?=$val['id']?>" class="collapse">					
			<p><?='Host id: ';?><?=$val['id'];?></p>
			<p><?="Name: ".$val['fname'].' '.$val['lname'];?></p>
			<a class="mailto" href=<?='mailto:'.$val['email'];?>><p><?="Email: ".$val['email'];?></p></a>
			<p><?php echo "Tel: ";if($val['mobile']!=''){echo $val['mobile'];}if($val['home_phone']!=""){echo ", ".$val['home_phone']; } ?></p>
			</div>
			</td>
			<td data-toggle="collapse" data-target="#hosto<?=$val['id']?>" class="hostoresult "><h4><a>Details</a></h4></td>
			<td><?php }else if($k=='student'){?></td>
		</tr>
		<!-- Host Search Result  Ends -->
		
		<!-- Student Search Result  Starts -->
		<tr  data-toggle="collapse" data-target="#studento<?=$val['id']?>" class="studentoresult">
			<td ><div class="material-icons" ><?=$result_icon; ?></div></td>
			<td data-toggle="collapse" data-target="#studento<?=$val['id']?>" class="studentoresult">
			<h4><?=ucfirst($k)." Id: "?><a href='<?=site_url().'sha/application/'.$val['id'] ?>' target="_blank"><?=$val['id']?></a></h4>	
			<div id="studento<?=$val['id']?>" class="collapse">
			<p><?='Student Id: ';?><?=$val['id'];?></p>
			<p><?='Student college id/number: ';if($val['sha_student_no'] != ''){echo $val['sha_student_no'];}else{echo 'Not Available';}?></p>
			<p><?='Name: '.$val['fname'].' '.$val['lname'];?></p>
			<a class="mailto" href=<?='mailto:'.$val['email'];?>><p><?='Email: '.$val['email'];?></p></a>
			<p><?php echo "Tel: ";if($val['mobile']!=''){echo $val['mobile'];}if($val['home_phone']!=""){echo ", ".$val['home_phone']; } ?></p>
			<p><?='College: '.$val['college']?></p>
			<p><?='Client Id:'.$val['client']; ?></p>
			<p><?='Client: '.$val['bname']?></p>
			</div>
			</td>
			<td data-toggle="collapse" data-target="#studento<?=$val['id']?>" class="studentoresult "><h4><a>Details</a></h4></td>
			<td><?php }else if($k=='client'){ ?></td>
		</tr>
		<!-- Student Search Results Details Ends -->
		
		<!-- Client Search Results Details Starts -->
		<tr data-toggle="collapse" data-target="#cliento<?=$val['id']?>" class="clientoresult">
			<td ><div class="material-icons" ><?=$result_icon; ?></div></td>
			<td data-toggle="collapse" data-target="#cliento<?=$val['id']?>" class="clientoresult">
			<h4><?=ucfirst($k)." Id: "?><a href="<?=site_url().'client/edit/'.$val['id']; ?>" target="_blank"><?=$val['id']?></a></h4>
			<div id="cliento<?=$val['id']?>" class="collapse">
			<p><?='Client id: ';?><?=$val['id'];?></p>
			<p><?='Bname: '.$val['bname'];?></p>
			<p><?='Name: '.$val['primary_contact_name'].$val['primary_contact_lname'];?></p>
			<a class="mailto" href=<?='mailto:'.$val['primary_email'];?>><p><?='Email: '.$val['primary_email'];?></p></a>
			<p><?=$val['primary_phone'].', '.$val['sec_phone'];?></p>
			</div>
			</td>
			<td data-toggle="collapse" data-target="#cliento<?=$val['id']?>" class="clientoresult "><h4><a>Details</a></h4></td>
			<td><?php }elseif($k=='initial invoice'||$k=='ongoing shaOne'){$shaOne=getshaOneAppDetails($val['application_id']);?></td>
		</tr>
		<!-- Clients Search Results Detals Starts -->
		
		<!-- Initial and Ongoing Invoice Search Result  Start -->
		<tr data-toggle="collapse" data-target="#invoiceo<?=$val['id']?>" class="invoiceoresult">
			<td ><div class="material-icons" ><?=$result_icon; ?></div></td>
			<td  data-toggle="collapse" data-target="#invoiceo<?=$val['id']?>" class="invoiceoresult">
			<h4><?=ucfirst($k)." Id: "?><a href="<?php if($k=='initial invoice'){$invoice = 'view_initial';}else{$invoice = 'view_ongoing';}echo site_url().'invoice/'.$invoice.'/'.$val['id']; ?>" target="_blank"><?=$val['id']?></a></h4>
			<div id="invoiceo<?=$val['id']?>" class="collapse">
			<p><?='Invoice Id: ';?><?=$val['id']; ?></p>
			<p><?='Invoice Number: '.$val['invoice_number']; ?></p>
			<p><?='Xero Id: '.$val['xero_invoiceId']; ?></p>
			<p><?='Student Id: '.$shaOne['id'];?></p>	
			<p><?='Student college id/number: ';if($shaOne['sha_student_no'] != ''){echo $shaOne['sha_student_no'];}else{echo 'Not Available';}?></p>		
			<p><?='Name: '.$shaOne['fname'].' '.$shaOne['lname'];?></p>
			<a class="mailto" href=<?='mailto:'.$shaOne['email'];?>><p><?='Email: '.$shaOne['email'];?></p></a>
			<p><?php echo "Tel: ";if($shaOne['mobile']!=''){echo $shaOne['mobile'];}if($shaOne['home_phone']!=""){echo ", ".$shaOne['home_phone']; } ?></p>
			<p><?='College: '.$val['college']?></p>
			<p><?='Client Id:'.$shaOne['client']; ?></p>
			<p><?='Client: '.$val['bname']?></p>
			</div>
			
			</td>
			<td data-toggle="collapse" data-target="#invoiceo<?=$val['id']?>" class="invoiceoresult "><h4><a>Details</a></h4></td>
			<td><?php }elseif($k=='purchase orders'){ ?></td>
		</tr> 
		<!-- Initial and Ongoing Invoice Search Result Deatils Ends -->
		
		<!-- Purchase Order Search Results Details Starts -->
		<tr data-toggle="collapse" data-target="#poo<?=$val['id']?>" class="pooresult">
			<td ><div class="material-icons" ><?=$result_icon; ?></div></td>
			<td  data-toggle="collapse" data-target="#poo<?=$val['id']?>" class="pooresult">
			<h4><?=ucfirst($k)." Id: "?><a href="<?=site_url().'purchase_orders/view/'.$val['id'] ?>" target="_blank"><?=$val['id']?></a></h4>
			<div id="poo<?=$val['id']?>" class="collapse">
			<p><?='Purchase Order Id: ';?><?=$val['id'];?></p>
			<p><?='Booking Id: '.$val['booking_id']; ?></p>
			<p><?='From: '.$val['from'];?></p>
			<p><?='To: '.$val['to'];?></p>
			<p><?='Xero Id: '.$val['po_id_xero'];?></p>							
			<p><?='Due Date: '.$val['due_date']; ?></p>
			<!--------------------------------------------------------------------------------------------------------->
			<p><h4>Host Details</h4></p>
			<p><?='Host Id: '.$val['host']; ?></p>
	    	<p><?="Name: ".$val['fname'].' '.$val['lname'];?></p>
			<p><a class="mailto" href=<?='mailto:'.$val['email'];?>><?="Email: ".$val['email'];?></a></p>
			<p><?php echo "Tel: ";if($val['mobile']!=''){echo $val['mobile'];}if($val['home_phone']!=""){echo ", ".$val['home_phone']; } ?></p>
			</div>
	        
			</td>
			<td data-toggle="collapse" data-target="#poo<?=$val['id']?>" class="pooresult "><h4><a>Details</a></h4></td>
		</tr>
		<tr><?php }}}}?></tr>
		<!-- Purchase Order Search Results Details Ends-->
</tbody>
</table>						


                <!-- </div> -->
            </div>
        </div>
    
            </div>
        </div>
    <!-- </div> -->
</div>

<script>

$(document).ready(function(){
	 
	var searchedText = <?php echo json_encode($_GET['value']); ?>;
	searchedText = searchedText.replace(/(\s+)/,"(<[^>]+>)*$1(<[^>]+>)*");
	var simpletext = new RegExp("("+searchedText+")" ,"gi");
	var highlight = '<span class="search-found">' + searchedText + '</span>';
	
	$("table tr td p").each( function(  ) {
      var content = $(this).text();
	  content = content.replace(simpletext, "<span class=\"search-found\">$1</span>");
	  content = content.replace(/(<span>[^<>]*)((<[^>]+>)+)([^<>]*<\/span>)/,"$1</span>$2<span>$4");
       $(this).html( content );
 });


});

</script>

<style type="text/css">
	.search-found {
		background-color: #8bc34a;//#ffecb3;
		color: #ffffff;
	}
	
</style>