<?php 
//see($result);
$clientsList=clientsList();

?>

<div class="page-heading">
      <h1>Search All</h1>        
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
	<table class="list-group-item withripple">
	<tbody>
         	
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
				$result_icon="face";	
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

					</tr>

		<tr >
		<td><div class="material-icons" ><?=$result_icon; ?></div><p><?=ucfirst($k)?></td>
		<!-- Bookings detail Table Starts-->
		<?php if($k=="booking"){ $hfaOne=getHfaOneAppDetails($val['host']); $shaOne=getshaOneAppDetails($val['student']);?>
		<td>
		<h4>Booking Details</h4>
		<p class="exactResult"><strong><?='Booking id: ';?></strong><a href='<?=site_url().'booking/view/'.$val['id'] ?>' target="_blank"><?=$val['id'];?></a></p>
		<!-- Host & Student Details TR in Bookings Starts -->
		<h5>Host Details</h5>
		<p><?='Host id: '.$hfaOne['id'];?></p>
		<p><?='Name: '.$hfaOne['fname'].' '.$hfaOne['lname'];?></p>
		<p><a class="mailto" href=<?='mailto:'.$hfaOne['email'];?>><?='Email: '.$hfaOne['email'];?></a></p>
		<p><?php echo "Tel: ";if($hfaOne['mobile']!=''){echo $hfaOne['mobile'];}if($hfaOne['home_phone']!=""){echo ", ".$hfaOne['home_phone']; } ?></p>
		<!-------------------------------------------------------------------------------------------------------------------------------------------->
		<h5>Student Details</h5>
		<p><?='Student Id: '.$shaOne['id'];?></p>	
		<p><?='Student college id/number: ';if($shaOne['sha_student_no'] != ''){echo $shaOne['sha_student_no'];}else{echo 'Not Available';}?></p>		
		<p><?='Name: '.$shaOne['fname'].' '.$shaOne['lname'];?></p>
		<p><a class="mailto" href=<?='mailto:'.$shaOne['email'];?>><?='Email: '.$shaOne['email'];?></a></p>
		<p><?php echo "Tel: ";if($shaOne['mobile']!=''){echo $shaOne['mobile'];}if($shaOne['home_phone']!=""){echo ", ".$shaOne['home_phone']; } ?></p>
		<p><?='Client Id:'.$shaOne['client']; ?></p>
		<p><?php foreach($clientsList as $cLK=>$cLV){if($shaOne['client'] == $cLV['id']){echo 'Client : '.$cLV['bname'];}}?></p>
		<hr>
		</td>
		<td></td>
		</tr>
		<!-- Host & Student Detalis TR in Bookings Ends -->
			
		<!-- Host Search Result Details Starts -->
		<tr>
			<?php }elseif ($k=='host') {?>
			<td>
			<h4>Host Details</h4>						
			<p><?='Host id: ';?><a href='<?=site_url().'hfa/application/'.$val['id'] ?>' target="_blank"><?=$val['id'];?></a></p>
			<p><?=$val['fname'].' '.$val['lname'];?></p>
			<p><a class="mailto" href=<?='mailto:'.$val['email'];?>><?=$val['email'];?></a></p>
			<p><?php echo "Tel: ";if($val['mobile']!=''){echo $val['mobile'];}if($val['home_phone']!=""){echo ", ".$val['home_phone']; } ?></p>
			<p><?//=$hostaddress = $val['street'].', '.$val['suburb'].', '.$val['state'].','.$val['postcode'];echo getMapLocationLink($hostaddress);?></p>
			<hr>
			</td>
			<td></td>
		</tr>
		<!-- Host Search Result Details Ends -->
		
		<!-- Student Search Result Details Starts -->
		<tr>
			<?php }else if($k=='student'){?>
			<td>
			<h4>Student Detatils</h4>	
			<p><?='Student Id: ';?><a href='<?=site_url().'sha/application/'.$val['id'] ?>' target="_blank"><?=$val['id'];?></a></p>
			<p><?='Student college id/number: ';if($val['sha_student_no'] != ''){echo $val['sha_student_no'];}else{echo 'Not Available';}?></p>
			<p><?='Name: '.$val['fname'].' '.$val['lname'];?></p>
			<p><a class="mailto" href=<?='mailto:'.$val['email'];?>><?='Email: '.$val['email'];?></a></p>
			<p><?php echo "Tel: ";if($val['mobile']!=''){echo $val['mobile'];}if($val['home_phone']!=""){echo ", ".$val['home_phone']; } ?></p>
			<p><?='Client Id:'.$val['client']; ?></p>
			<p><?php foreach($clientsList as $cLK=>$cLV){if($val['client'] == $cLV['id']){echo 'Client: '.$cLV['bname'];}}?></p>
			<hr>
			</td>
			<td></td>
		</tr>
		<!-- Student Search Results Details Ends -->
		
		<!-- Client Search Results Details Starts -->
		<tr>
			<?php }else if($k=='client'){ ?>
			<td>
			<h4>Client Details</h4>
			<p><?='Client id: ';?><a href="<?=site_url().'client/edit/'.$val['id']; ?>" target="_blank"><?=$val['id'];?></a></p>
			<p><?='Bname: '.$val['bname'];?></p>
			<p><?='Name: '.$val['primary_contact_name'].$val['primary_contact_lname'];?></p>
			<p><a class="mailto" href=<?='mailto:'.$val['primary_email'];?>><?='Email: '.$val['primary_email'];?></a></p>
			<hr>
			<p><?=$val['primary_phone'].', '.$val['sec_phone'];?></p>	
			</td>
			<td></td>
		</tr>
		<!-- Clients Search Results Detals Starts -->
		
		<!-- Initial and Ongoing Invoice Search Result Details Start -->
		<tr>
			<?php }elseif($k=='initial invoice'||$k=='ongoing invoice'){$shaOne=getshaOneAppDetails($val['application_id']);?>
			<td>
			<h4>Invoice Details</h4>
			<p><?='Invoice Id: ';?><a href="<?php if($k=='initial invoice'){$invoice = 'view_initial';}else{$invoice = 'view_ongoing';}echo site_url().'invoice/'.$invoice.'/'.$val['id']; ?>" target="_blank"><?=$val['id']; ?></a></p>
			<p><?='Invoice Number: '.$val['invoice_number']; ?></p>
			<p><?='Xero Id: '.$val['xero_invoiceId']; ?></p>
			<p><?='Student Id: '.$shaOne['id'];?></p>	
			<p><?='Student college id/number: ';if($shaOne['sha_student_no'] != ''){echo $shaOne['sha_student_no'];}else{echo 'Not Available';}?></p>		
			<p><?='Name: '.$shaOne['fname'].' '.$shaOne['lname'];?></p>
			<p><a class="mailto" href=<?='mailto:'.$shaOne['email'];?>><?='Email: '.$shaOne['email'];?></a></p>
			<p><?='Tel: '.$shaOne['mobile'].', '.$shaOne['home_phone'];?></p>
			<p><?='Client Id:'.$shaOne['client']; ?></p>
			<p><?php foreach($clientsList as $cLK=>$cLV){if($shaOne['client'] == $cLV['id']){echo 'Client : '.$cLV['bname'];}}?></p>
			<hr>
			</td>
			<td></td>
		</tr> 
		<!-- Initial and Ongoing Invoice Search Result Deatils Ends -->
		
		<!-- Purchase Order Search Results Details Starts -->
		<tr>
			<?php }elseif($k=='purchase orders'){ ?>
			<td>
			<h4>Purchase Order Details</h4>
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
	        <p><?//=$hostaddress = $val['street'].', '.$val['suburb'].', '.$val['state'].', '.$val['postcode'];echo getMapLocationLink($hostaddress);?></p>
	        <hr>
			</td>
			<td></td>
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
				$result_icon="face";	
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
	</tr>
		<tr>
		<td><div class="material-icons" ><?=$result_icon; ?></div><p><?=ucfirst($k);?></p></td>
		<td>
		<?php if($k=="booking"){ $hfaOne=getHfaOneAppDetails($val['host']); $shaOne=getshaOneAppDetails($val['student']);?>
		<h4>Booking Details</h4>
		<p class="otherResult"><strong><?='Booking id: ';?></strong><a href='<?=site_url().'booking/view/'.$val['id'] ?>' target="_blank"><?=$val['id'];?></a></p>
		<!-- Host & Student Details TR in Bookings Starts -->
		<h5>Host Details</h5>
		<p><?='Host id: '.$hfaOne['id'];?></p>
		<p><?='Name: '.$hfaOne['fname'].' '.$hfaOne['lname'];?></p>
		<p><a class="mailto" href=<?='mailto:'.$hfaOne['email'];?>><?='Email: '.$hfaOne['email'];?></a></p>
		<p><?php echo "Tel: ";if($hfaOne['mobile']!=''){echo $hfaOne['mobile'];}if($hfaOne['home_phone']!=""){echo ", ".$hfaOne['home_phone']; } ?></p>
		<!--------------------------------------------------------------------------------------------------------->
		<h5>Student Details</h5>
		<p><?='Student Id: '.$shaOne['id'];?></p>	
		<p><?='Student college id/number: ';if($shaOne['sha_student_no'] != ''){echo $shaOne['sha_student_no'];}else{echo 'Not Available';}?></p>		
		<p><?='Name: '.$shaOne['fname'].' '.$shaOne['lname'];?></p>
		<p><a class="mailto" href=<?='mailto:'.$shaOne['email'];?>><?='Email: '.$shaOne['email'];?></a></p>
		<p><?php echo "Tel: ";if($shaOne['mobile']!=''){echo $shaOne['mobile'];}if($shaOne['home_phone']!=""){echo ", ".$shaOne['home_phone']; } ?></p>
		<p><?='Client Id:'.$shaOne['client']; ?></p>
		<p><?php foreach($clientsList as $cLK=>$cLV){if($shaOne['client'] == $cLV['id']){echo 'Client : '.$cLV['bname'];}}?></p>
		<hr>
		</td>
		<td></td>
		</tr>
		<!-- Host & Student Detalis TR in Bookings Ends -->
		
		<!-- Host Search Result Details Starts -->	
		<tr>
			<td>
			<?php }elseif ($k=='host') {?>
			<h4>Host Details</h4>						
			<p><?='Host id: ';?><a href='<?=site_url().'hfa/application/'.$val['id'] ?>' target="_blank"><?=$val['id'];?></a></p>
			<p><?="Name: ".$val['fname'].' '.$val['lname'];?></p>
			<p><a class="mailto" href=<?='mailto:'.$val['email'];?>><?="Email: ".$val['email'];?></a></p>
			<p><?php echo "Tel: ";if($val['mobile']!=''){echo $val['mobile'];}if($val['home_phone']!=""){echo ", ".$val['home_phone']; } ?></p>
	        <p><?php //if($val['street'] != ""){$hostaddress = $val['street'];}if($val['suburb']!=""){$hostaddress.=', '.$val['suburb'];}if($val['state']!=""){$hostaddress.=', '.$val['state'];}if($val['postcode']!=""){$hostaddress.=', '.$val['postcode'];}echo getMapLocationLink($hostaddress);?></p>
			<hr>
			</td>
			<td></td>
		</tr>
		<!-- Host Search Result Details Ends -->
		
		<!-- Student Search Result Details Starts -->
		<tr>
			<td>
			<?php }else if($k=='student'){?>
			<h4>Student Detatils</h4>	
			<p><?='Student Id: ';?><a href='<?=site_url().'sha/application/'.$val['id'] ?>' target="_blank"><?=$val['id'];?></a></p>
			<p><?='Student college id/number: ';if($val['sha_student_no'] != ''){echo $val['sha_student_no'];}else{echo 'Not Available';}?></p>
			<p><?='Name: '.$val['fname'].' '.$val['lname'];?></p>
			<p><a class="mailto" href=<?='mailto:'.$val['email'];?>><?='Email: '.$val['email'];?></a></p>
			<p><?php echo "Tel: ";if($val['mobile']!=''){echo $val['mobile'];}if($val['home_phone']!=""){echo ", ".$val['home_phone']; } ?></p>
			<p><?='Client Id:'.$val['client']; ?></p>
			<p><?php foreach($clientsList as $cLK=>$cLV){if($val['client'] == $cLV['id']){echo 'Client: '.$cLV['bname'];}}?></p>
			<hr>
			</td>
			<td></td>
		</tr>
		<!-- Student Search Results Details Ends -->
		
		<!-- Clinet Search Results Details Starts -->
		<tr>
			<td>
			<?php }else if($k=='client'){ ?>
			<h4>Client Details</h4>
			<p><?='Client id: ';?><a href="<?=site_url().'client/edit/'.$val['id']; ?>" target="_blank"><?=$val['id'];?></a></p>
			<p><?='Bname: '.$val['bname'];?></p>
			<p><?='Name: '.$val['primary_contact_name'].$val['primary_contact_lname'];?></p>
			<p><a class="mailto" href=<?='mailto:'.$val['primary_email'];?>><?='Email: '.$val['primary_email'];?></a></p>
			<p><?=$val['primary_phone'].', '.$val['sec_phone'];?></p>
			<hr>	
			</td>
			<td></td>
		</tr>
		<!-- Clients Search Results Detals Starts -->
		
		<!-- Initial and Ongoing Invoice Search Result Details Start -->
		<tr style="display:<?php //if($k=='initial invoice'||$k=='ongoing invoice'){$shaOne=getshaOneAppDetails($val['application_id']);}if(in_array(@$_GET['value'],$shaOne)){echo "none";}?>">
			<td>
			<?php }elseif($k=='initial invoice'||$k=='ongoing invoice'){$shaOne=getshaOneAppDetails($val['application_id']);?>
			<h4>Invoice Details</h4>
			<p><?='Invoice Id: ';?><a href="<?php if($k=='initial invoice'){$invoice = 'view_initial';}else{$invoice = 'view_ongoing';}echo site_url().'invoice/'.$invoice.'/'.$val['id']; ?>" target="_blank"><?=$val['id']; ?></a></p>
			<p><?='Invoice Number: '.$val['invoice_number']; ?></p>
			<p><?='Xero Id: '.$val['xero_invoiceId']; ?></p>
			<p><?='Student Id: '.$shaOne['id'];?></p>	
			<p><?='Student college id/number: ';if($shaOne['sha_student_no'] != ''){echo $shaOne['sha_student_no'];}else{echo 'Not Available';}?></p>		
			<p><?='Name: '.$shaOne['fname'].' '.$shaOne['lname'];?></p>
			<p><a class="mailto" href=<?='mailto:'.$shaOne['email'];?>><?='Email: '.$shaOne['email'];?></a></p>
			<p><?php echo "Tel: ";if($shaOne['mobile']!=''){echo $shaOne['mobile'];}if($shaOne['home_phone']!=""){echo ", ".$shaOne['home_phone']; } ?></p>
			<p><?='Client Id:'.$shaOne['client']; ?></p>
			<p><?php foreach($clientsList as $cLK=>$cLV){if($shaOne['client'] == $cLV['id']){echo 'Client : '.$cLV['bname'];}}?></p>
			<hr>
			</td>
			<td></td>
		</tr> 
		<!-- Initial and Ongoing Invoice Search Result Deatils Ends -->
		
		<!-- Purchase Order Search Results Details Starts -->
		<tr style="display:<?php //if($k=='purchase orders'){ if($val['id']=='' && $val['booking_id'] == ''){echo "none";}  }?> ">
			<td>
			<?php }elseif($k=='purchase orders'){ ?>
			<h4>Purchase Order Details</h4>
			<p><?='Purchase Order Id: ';?><a href="<?=site_url().'purchase_orders/view/'.$val['id'] ?>" target="_blank"><?=$val['id'];?></a></p>
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
	        <p><?php// if($val['street'] != ""){$hostaddress = $val['street'];}if($val['suburb']!=""){$hostaddress.=', '.$val['suburb'];}if($val['state']!=""){$hostaddress.=', '.$val['state'];}if($val['postcode']!=""){$hostaddress.=', '.$val['postcode'];}echo getMapLocationLink($hostaddress);?></p>
	        <hr>
			</td>
			<td></td>
		</tr>
		<tr><?php }}}}?></tr>
		<!-- Purchase Order Search Results Details Ends-->
</tbody>
</table>						


                </div>
            </div>
        </div>
    
            </div>
        </div>
    </div>
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