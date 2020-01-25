<?php
if(is_numeric($visitReport['employee']))
{
	$employee=employee_details($visitReport['employee']);
	$empName=$employee['fname'].' '.$employee['lname'];
}
else
	$empName=$visitReport['employee'];

$host=getHfaOneAppDetails($visitReport['hfa_id']);
$stateList=stateList();

$address='';
if($host['street']!='')
	$address .=$host['street'].", ";
$address .=ucfirst($host['suburb']).", ".$stateList[$host['state']].", ".$host['postcode'];
								
$notMentionedText='Not mentioned';
$yesNo=array('No','Yes');
$bedSizeList=bedSizeList();

$styleTextLeftAlign=' style="text-align:left;font-family: barlow;"';
$styleTextLeftAlignWhite=' style="text-align:left;color:#fff;font-family: barlow;"';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	<title>Visit Report: <?=ucwords($host['lname']).' Family';?></title>
	<link rel='stylesheet' type='text/css' href='<?=static_url()?>system/css/print-style.css' />
    <link rel='stylesheet' type='text/css' href='<?=static_url()?>system/css/ge-system.css' />
	<link rel='stylesheet' type='text/css' href='<?=static_url()?>system/css/media-print.css' media="print" />
     <link type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,400,400italic,500' rel='stylesheet'>

</head>

<style>
#table th.lalalal {
	border-top:0px !important;
}
</style>

<body>

<div id="page-wrap">

  <div id="identity">
      <div id="logo" >
     <!-- <img style="margin: 15px 0 20px 0; height:100px;" src="<?=static_url()?>system/img/report-logo-new1.jpg" />-->
     <img style="margin: 15px 0 20px 0; height:100px; width:auto;" src="<?=static_url()?>system/img/report-logo.jpg" />
            <h4 id="media-heading" style="font-family: barlow">Homestay Interview Report</h4>
      <span style="font-family: barlow">(Confidential)</span>
      </div>
  </div>
  <div style="clear:both"></div>
  
  <div id="col-md-12">
  
    <!--Intro box #STARTS-->
        <div id="about-area">
            <div id="table-responsive" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" style="background:#888;opacity:0.75;">
		        <div id="panel-body" class="">
                  
                      <table id="table">
                          <tbody>
                      
                              <tr>
                                  <th class="lalalal" <?=$styleTextLeftAlignWhite?>>Name: <span style="font-weight:normal;"><?=ucwords($host['lname']).' Family';?></span></th>
                              </tr>
                              
                              <tr>
                                  <th <?=$styleTextLeftAlignWhite?>>Address: <span style="font-weight:normal;"><?=$address?></span></th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlignWhite?>>Phone: <span style="font-weight:normal;"><?=$host['mobile']?></span></th>
                              </tr>
                      
                              
                      
                              <tr>
                                  <th <?=$styleTextLeftAlignWhite?>>Interviewer: <span style="font-weight:normal;"><?=$empName?></span></th>
                              </tr>
                              
                              <tr>
                                  <th <?=$styleTextLeftAlignWhite?>>Date of visit/revisit: <span style="font-weight:normal;"><?=date('d M Y, h:i A',strtotime($visitReport['date_visited']))?></span></th>
                              </tr>

                           </tbody>
                      </table>
                  
                  </div>
            </div>   
        </div>
    <!--Intro box #ENDS-->
    
    <!--1st box #STARTS-->
        <div id="about-area">
            <div id="table-responsive" data-widget="{&quot;draggable&quot;: &quot;false&quot;}">
              <table id="panel-heading" cellspacing="0" cellpadding="0">
              <thead>
              <tr>
              <th <?=$styleTextLeftAlign?>>Facilities</th>
              </tr>
              </thead>
              </table>                            

                <div id="panel-body">
                  
                      <table id="table">
                          <tbody>
                      
                              <tr>
                                  <th class="lalalal" <?=$styleTextLeftAlign?>>Homestay exterior appearance: 

                                  	<?php
                                    	if($visitReport['exterior']!='')
											echo $visitReport['exterior'];
										else
											echo $notMentionedText;
											
										if($visitReport['exterior_commnets']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['exterior_commnets']).'</p>';
                                    ?>
                                 </th>
                              </tr>
                              
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Homestay interior appearance: 
                                  <?php
                                    	if($visitReport['interior']!='')
											echo $visitReport['interior'];
										else
											echo $notMentionedText;
											
										if($visitReport['interior_comments']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['interior_comments']).'</p>';
									?>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Home cleanliness: 
                                  	<?php
                                    	if($visitReport['cleanliness']!='')
											echo $visitReport['cleanliness'];
										else
											echo $notMentionedText;
											
										if($visitReport['cleanliness_comments']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['cleanliness_comments']).'</p>';
                                    ?>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Feeling of homeliness: 

                                  	<?php
                                    	if($visitReport['homeliness']!='')
											echo $visitReport['homeliness'];
										else
											echo $notMentionedText;
											
										if($visitReport['homeliness_comments']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['homeliness_comments']).'</p>';
                                    ?>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Warmth of parent/family: 
                                  	<?php
                                    	if($visitReport['family_warmth']!='')
											echo $visitReport['family_warmth'];
										else
											echo $notMentionedText;
											
										if($visitReport['family_warmth_comments']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['family_warmth_comments']).'</p>';
                                    ?>
                                  </th>
                              </tr>
                      
                           </tbody>
                      </table>
                  
                  </div>
            </div>   
        </div>
    <!--1st bix #ENDS-->
  
    <!--2nd box #STARTS-->
        <div id="about-area">
            <div id="table-responsive" data-widget="{&quot;draggable&quot;: &quot;false&quot;}">
                    <table id="panel-heading" cellspacing="0" cellpadding="0">
              <thead>
              <tr>
              <th <?=$styleTextLeftAlign?>>Interior layout</th>
              </tr>
              </thead>
              </table> 
                <div id="panel-body">
                  
                      <table id="table">
                          <tbody>
                      
                              <tr ><th class="lalalal" <?=$styleTextLeftAlign?>><h2>Ground Floor/ First floor</h2></th></tr>
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Type of flooring (wood, carpet, tiles): 
                                  <?php if($visitReport['floor_type']==''){echo $notMentionedText;}?>
										<p style="font-weight:normal;"><?=nl2br($visitReport['floor_type'])?></p>
                                 </th>
                              </tr>
                              
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Total number of bedrooms:  
                                  <?php if($visitReport['no_of_bedrooms']==''){echo $notMentionedText;}?>
										<p style="font-weight:normal;"><?=nl2br($visitReport['no_of_bedrooms'])?></p>
                                  </th>
                              </tr>
                              
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Total number of bedrooms used for students:  
                                  <?php if($visitReport['no_of_bedrooms_used']==''){echo $notMentionedText;}?>
										<p style="font-weight:normal;"><?=nl2br($visitReport['no_of_bedrooms_used'])?></p>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Total number of bathrooms: 
                                  <?php if($visitReport['no_of_bathrooms']==''){echo $notMentionedText;}?>
										<p style="font-weight:normal;"><?=nl2br($visitReport['no_of_bathrooms'])?></p>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Total number of bathrooms used for students: 
                                  <?php if($visitReport['no_of_bathrooms_used']==''){echo $notMentionedText;}?>
										<p style="font-weight:normal;"><?=nl2br($visitReport['no_of_bathrooms_used'])?></p>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Smoke Alarm:  
                                  <?php if($visitReport['smoke_alarm']==''){echo $notMentionedText;}?>
										<p style="font-weight:normal;"><?=nl2br($visitReport['smoke_alarm'])?></p>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Number of alarms and location of alarms:  
                                  <?php if($visitReport['smoke_alarm_info']==''){echo $notMentionedText;}?>
										<p style="font-weight:normal;"><?=nl2br($visitReport['smoke_alarm_info'])?></p>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Living area:  
                                  
                                  <?php
                                    	if($visitReport['living_area']!='')
											echo $yesNo[$visitReport['living_area']];
										else
											echo $notMentionedText;
											
										if($visitReport['living_area_comments']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['living_area_comments']).'</p>';
                                    ?>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Dining Area:  
                                  
                                  <?php
                                    	if($visitReport['dining_area']!='')
											echo $yesNo[$visitReport['dining_area']];
										else
											echo $notMentionedText;
											
										if($visitReport['dining_area_comments']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['dining_area_comments']).'</p>';
                                    ?>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Kitchen area:  
                                  
                                  <?php
                                    	if($visitReport['kitchen_area']!='')
											echo $yesNo[$visitReport['kitchen_area']];
										else
											echo $notMentionedText;
											
										if($visitReport['kitchen_area_comments']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['kitchen_area_comments']).'</p>';
                                    ?>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Laundry:  
                                  
                                  <?php
                                    	if($visitReport['laundry']!='')
										{
											echo $yesNo[$visitReport['laundry']];
											if($visitReport['laundry']=='1')
												{
													if($visitReport['laundry_location']=='1')
														echo ' (Indoor)';
													elseif($visitReport['laundry_location']=='2')
														echo ' (Outdoor)';	
												}
										}
										else
											echo $notMentionedText;
											
										if($visitReport['laundry_comments']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['laundry_comments']).'</p>';
                                    ?>
                                  </th>
                              </tr>
                      
		                      <tr><th <?=$styleTextLeftAlign?>><h2>Second floor</h2></th></tr>
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Type of flooring (wood, carpet, tiles):  
                                  <?php if($visitReport['floor_type_SF']==''){echo $notMentionedText;}?>
										<p style="font-weight:normal;"><?=nl2br($visitReport['floor_type_SF'])?></p>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Total number of bedrooms:  
                                  <?php if($visitReport['no_of_bedrooms_SF']==''){echo $notMentionedText;}?>
										<p style="font-weight:normal;"><?=nl2br($visitReport['no_of_bedrooms_SF'])?></p>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Total number of bedrooms used for students:  
                                  <?php if($visitReport['no_of_bedrooms_used_SF']==''){echo $notMentionedText;}?>
										<p style="font-weight:normal;"><?=nl2br($visitReport['no_of_bedrooms_used_SF'])?></p>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Total number of bathrooms:  
                                  <?php if($visitReport['no_of_bathrooms_SF']==''){echo $notMentionedText;}?>
										<p style="font-weight:normal;"><?=nl2br($visitReport['no_of_bathrooms_SF'])?></p>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Total number of bathrooms used for students:  
                                  <?php if($visitReport['no_of_bathrooms_used_SF']==''){echo $notMentionedText;}?>
										<p style="font-weight:normal;"><?=nl2br($visitReport['no_of_bathrooms_used_SF'])?></p>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Smoke Alarm: 
                                  <?php if($visitReport['smoke_alarm_SF']==''){echo $notMentionedText;}?>
										<p style="font-weight:normal;"><?=nl2br($visitReport['smoke_alarm_SF'])?></p>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Number of alarms and location of alarms:  
                                  <?php if($visitReport['smoke_alarm_info_SF']==''){echo $notMentionedText;}?>
										<p style="font-weight:normal;"><?=nl2br($visitReport['smoke_alarm_info_SF'])?></p>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Living area:  
                                  
                                  <?php
                                    	if($visitReport['living_area_SF']!='')
											echo $yesNo[$visitReport['living_area_SF']];
										else
											echo $notMentionedText;
											
										if($visitReport['living_area_comments_SF']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['living_area_comments_SF']).'</p>';
                                    ?>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Dining Area:  
                                  
                                  <?php
                                    	if($visitReport['dining_area_SF']!='')
											echo $yesNo[$visitReport['dining_area_SF']];
										else
											echo $notMentionedText;
											
										if($visitReport['dining_area_comments_SF']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['dining_area_comments_SF']).'</p>';
                                    ?>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Kitchen area:  
                                  
                                  <?php
                                    	if($visitReport['kitchen_area_SF']!='')
											echo $yesNo[$visitReport['kitchen_area_SF']];
										else
											echo $notMentionedText;
											
										if($visitReport['kitchen_area_comments_SF']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['kitchen_area_comments_SF']).'</p>';
                                    ?>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Laundry:  
                                  
                                  <?php
                                    	if($visitReport['laundry_SF']!='')
										{
											echo $yesNo[$visitReport['laundry_SF']];
											if($visitReport['laundrySF']=='1')
												{
													if($visitReport['laundry_location_SF']=='1')
														echo ' (Indoor)';
													elseif($visitReport['laundry_location_SF']=='2')
														echo ' (Outdoor)';	
												}
										}
										else
											echo $notMentionedText;
											
										if($visitReport['laundry_comments_SF']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['laundry_comments_SF']).'</p>';
                                    ?>
                                  </th>
                              </tr>
                      
		                      <tr><th <?=$styleTextLeftAlign?>><h2>Third floor</h2></th></tr>
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Type of flooring (wood, carpet, tiles):  
                                  <?php if($visitReport['floor_type_TF']==''){echo $notMentionedText;}?>
										<p style="font-weight:normal;"><?=nl2br($visitReport['floor_type_TF'])?></p>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Total number of bedrooms:  
                                  <?php if($visitReport['no_of_bedrooms_TF']==''){echo $notMentionedText;}?>
										<p style="font-weight:normal;"><?=nl2br($visitReport['no_of_bedrooms_TF'])?></p>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Total number of bedrooms used for students:  
                                  <?php if($visitReport['no_of_bedrooms_used_TF']==''){echo $notMentionedText;}?>
										<p style="font-weight:normal;"><?=nl2br($visitReport['no_of_bedrooms_used_TF'])?></p>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Total number of bathrooms:  
                                  <?php if($visitReport['no_of_bathrooms_TF']==''){echo $notMentionedText;}?>
										<p style="font-weight:normal;"><?=nl2br($visitReport['no_of_bathrooms_TF'])?></p>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Total number of bathrooms used for students:  
                                  <?php if($visitReport['no_of_bathrooms_used_TF']==''){echo $notMentionedText;}?>
										<p style="font-weight:normal;"><?=nl2br($visitReport['no_of_bathrooms_used_TF'])?></p>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Smoke Alarm: 
                                  <?php if($visitReport['smoke_alarm_TF']==''){echo $notMentionedText;}?>
										<p style="font-weight:normal;"><?=nl2br($visitReport['smoke_alarm_TF'])?></p>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Number of alarms and location of alarms:  
                                  <?php if($visitReport['smoke_alarm_info_TF']==''){echo $notMentionedText;}?>
										<p style="font-weight:normal;"><?=nl2br($visitReport['smoke_alarm_info_TF'])?></p>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Living area:  
                                  
                                  <?php
                                    	if($visitReport['living_area_TF']!='')
											echo $yesNo[$visitReport['living_area_TF']];
										else
											echo $notMentionedText;
											
										if($visitReport['living_area_comments_TF']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['living_area_comments_TF']).'</p>';
                                    ?>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Dining Area:  
                                  
                                  <?php

                                    	if($visitReport['dining_area_TF']!='')
											echo $yesNo[$visitReport['dining_area_TF']];
										else
											echo $notMentionedText;
											
										if($visitReport['dining_area_comments_TF']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['dining_area_comments_TF']).'</p>';
                                    ?>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Kitchen area:  
                                  
                                  <?php
                                    	if($visitReport['kitchen_area_TF']!='')
											echo $yesNo[$visitReport['kitchen_area_TF']];
										else
											echo $notMentionedText;
											
										if($visitReport['kitchen_area_comments_TF']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['kitchen_area_comments_TF']).'</p>';
                                    ?>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Laundry:  
                                  
                                  <?php
                                    	if($visitReport['laundry_TF']!='')
										{
											echo $yesNo[$visitReport['laundry_TF']];
											if($visitReport['laundrySF']=='1')
												{
													if($visitReport['laundry_location_TF']=='1')
														echo ' (Indoor)';
													elseif($visitReport['laundry_location_TF']=='2')
														echo ' (Outdoor)';	
												}
										}
										else
											echo $notMentionedText;
											
										if($visitReport['laundry_comments_TF']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['laundry_comments_TF']).'</p>';
                                    ?>
                                  </th>
                              </tr>
                      
                           </tbody>
                      </table>
                  
                  </div>
            </div>   
        </div>
    <!--2nd bix #ENDS-->
  
    <!--3rd box #STARTS-->
    <?php if(isset($visitReport['bedrooms']) && !empty($visitReport['bedrooms'])){?>
        <div id="about-area">
            <div id="table-responsive" data-widget="{&quot;draggable&quot;: &quot;false&quot;}">
                     <table id="panel-heading" cellspacing="0" cellpadding="0">
              <thead>
              <tr>
              <th <?=$styleTextLeftAlign?>>Student bedrooms</th>
              </tr>
              </thead>
              </table>
                <div id="panel-body">
                  
                      <table id="table">
                          <tbody>
                      
                      	<?php foreach($visitReport['bedrooms'] as $bedK=>$bed)
						{?>
                              <tr><th  class="lalalal" <?=$styleTextLeftAlign?>><h2>Bedroom <?=$bedK+1?></h2></th></tr>
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Bed: 
										<?php
                                    	if($visitReport['bedrooms'][$bedK]['bed']!='')
											echo $yesNo[$visitReport['bedrooms'][$bedK]['bed']];
										else
											echo $notMentionedText;
											
										if($visitReport['bedrooms'][$bedK]['bed_comments']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['bedrooms'][$bedK]['bed_comments']).'</p>';
										?>
                                 </th>
                              </tr>
                              
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Wardrobe: 
										<?php
                                    	if($visitReport['bedrooms'][$bedK]['wardrobe']!='')
											echo $yesNo[$visitReport['bedrooms'][$bedK]['wardrobe']];
										else
											echo $notMentionedText;
											
										if($visitReport['bedrooms'][$bedK]['wardrobe_comments']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['bedrooms'][$bedK]['wardrobe_comments']).'</p>';
										?>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Window: 
										<?php
                                    	if($visitReport['bedrooms'][$bedK]['window']!='')
											echo $yesNo[$visitReport['bedrooms'][$bedK]['window']];
										else
											echo $notMentionedText;
											
										if($visitReport['bedrooms'][$bedK]['window_comments']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['bedrooms'][$bedK]['window_comments']).'</p>';
										?>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Desk and chair + desk lamp:  
										<?php
                                    	if($visitReport['bedrooms'][$bedK]['desk_chair']!='')
											echo $yesNo[$visitReport['bedrooms'][$bedK]['desk_chair']];
										else
											echo $notMentionedText;
											
										if($visitReport['bedrooms'][$bedK]['desk_chair_comments']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['bedrooms'][$bedK]['desk_chair_comments']).'</p>';
										?>
                                  </th>
                              </tr>
                      
		                     
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Size of the bedroom:  
										<?php
                                    	if($visitReport['bedrooms'][$bedK]['bedroom_size']!='')
											echo $bedSizeList[$visitReport['bedrooms'][$bedK]['bedroom_size']];
										else
											echo $notMentionedText;
											
										if($visitReport['bedrooms'][$bedK]['bedroom_size_comments']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['bedrooms'][$bedK]['bedroom_size_comments']).'</p>';
										?>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Door lock:  
										<?php
                                    	if($visitReport['bedrooms'][$bedK]['door_lock']!='')
											echo $yesNo[$visitReport['bedrooms'][$bedK]['door_lock']];
										else
											echo $notMentionedText;
											
										if($visitReport['bedrooms'][$bedK]['door_lock_comments']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['bedrooms'][$bedK]['door_lock_comments']).'</p>';
										?>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Private bathroom:  
										<?php
                                    	if($visitReport['bedrooms'][$bedK]['private_bathroom']!='')
											echo $yesNo[$visitReport['bedrooms'][$bedK]['private_bathroom']];
										else
											echo $notMentionedText;
											
										if($visitReport['bedrooms'][$bedK]['private_bathroom_comments']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['bedrooms'][$bedK]['private_bathroom_comments']).'</p>';
										?>
                                  </th>
                              </tr>
                      	<?php } ?>
                           </tbody>
                      </table>
                  
                  </div>
            </div>   
        </div>
        <?php } ?>        
    <!--3rd bix #ENDS-->
  
    <!--4th box #STARTS-->
        <div id="about-area">
            <div id="table-responsive" data-widget="{&quot;draggable&quot;: &quot;false&quot;}">
		            <!--<div class="panel-heading">                                
                        <h2>Student's Access</h2>
                    </div>-->
                     <table id="panel-heading" cellspacing="0" cellpadding="0">
              <thead>
              <tr>
              <th <?=$styleTextLeftAlign?>>Student's Access</th>
              </tr>
              </thead>
              </table>
                <div id="panel-body">
                  
                      <table id="table">
                          <tbody>
                      
                              <!--<tr>
                                  <th class="lalalal" <?=$styleTextLeftAlign?>>Living area: 
										<?php
                                    	if($visitReport['sa_living']!='')
											echo $yesNo[$visitReport['sa_living']];
										else
											echo $notMentionedText;
											
										if($visitReport['sa_living_comments']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['sa_living_comments']).'</p>';
                                    ?>
                                 </th>
                              </tr>
                              
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Dining area: 
										<?php
                                    	if($visitReport['sa_dining']!='')
											echo $yesNo[$visitReport['sa_dining']];
										else
											echo $notMentionedText;
											
										if($visitReport['sa_dining_comments']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['sa_dining_comments']).'</p>';
                                    ?>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Kitchen area: 
										<?php
                                    	if($visitReport['sa_kitchen']!='')
											echo $yesNo[$visitReport['sa_kitchen']];
										else
											echo $notMentionedText;
											
										if($visitReport['sa_living_comments']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['sa_kitchen_comments']).'</p>';
                                    ?>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Laundry (inside or outside): 
										<?php
                                    	if($visitReport['sa_laundry']!='')
											echo $yesNo[$visitReport['sa_laundry']];
										else
											echo $notMentionedText;
											
										if($visitReport['sa_laundry_comments']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['sa_laundry_comments']).'</p>';
                                    ?>
                                  </th>
                              </tr>-->
                      
		                      <tr>
                                  <th class="lalalal" <?=$styleTextLeftAlign?>>Backyard: 
										<?php
                                    	if($visitReport['sa_backyard']!='')
											echo $yesNo[$visitReport['sa_backyard']];
										else
											echo $notMentionedText;
											
										if($visitReport['sa_backyard_comments']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['sa_backyard_comments']).'</p>';
                                    ?>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Internet Access: 
										<?php
                                    	if($visitReport['sa_internet']!='')
											echo $yesNo[$visitReport['sa_internet']];
										else
											echo $notMentionedText;
											
										if($visitReport['sa_internet_comments']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['sa_internet_comments']).'</p>';
                                    ?>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>A set of house keys: 
										<?php
                                    	if($visitReport['sa_key']!='')
											echo $yesNo[$visitReport['sa_key']];
										else
											echo $notMentionedText;
											
										if($visitReport['sa_key_comments']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['sa_key_comments']).'</p>';
                                    ?>
                                  </th>
                              </tr>
                      
                           </tbody>
                      </table>
                  
                  </div>
            </div>   
        </div>        
    <!--4th bix #ENDS-->
  
    <!--5th box #STARTS-->
        <div id="about-area">
            <div id="table-responsive" data-widget="{&quot;draggable&quot;: &quot;false&quot;}">
		            <table id="panel-heading" cellspacing="0" cellpadding="0">
              <thead>
              <tr>
              <th <?=$styleTextLeftAlign?>>Extras</th>
              </tr>
              </thead>
              </table>
                <div id="panel-body">
                  
                      <table id="table">
                          <tbody>
                      
                              <tr>
                                  <th class="lalalal" <?=$styleTextLeftAlign?>>Do they have a granny flat? Does anyone live there? Please specify!: 
										<?php
                                    	if($visitReport['granny_flat']!='')
											echo $yesNo[$visitReport['granny_flat']];
										else
											echo $notMentionedText;
											
										if($visitReport['granny_flat_comments']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['granny_flat_comments']).'</p>';
                                    ?>
                                 </th>
                              </tr>
                              
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Does it have a separate entrance?: 
										<?php
                                    	if($visitReport['sep_entrance']!='')
											echo $yesNo[$visitReport['sep_entrance']];
										else
											echo $notMentionedText;
											
										if($visitReport['sep_entrance_comments']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['sep_entrance_comments']).'</p>';
                                    ?>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Does it have a swimming pool?: 
										<?php
                                    	if($visitReport['pool']!='')
											echo $yesNo[$visitReport['pool']];
										else
											echo $notMentionedText;
											
										if($visitReport['pool_comments']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['pool_comments']).'</p>';
                                    ?>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Anything else?: 
										<?php
                                    	if($visitReport['anything']!='')
											echo $yesNo[$visitReport['anything']];
										else
											echo $notMentionedText;
											
										if($visitReport['anything_comments']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['anything_comments']).'</p>';
                                    ?>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Security cameras?: 
										<?php
                                    	if($visitReport['camera']!='')
											echo $yesNo[$visitReport['camera']];
										else
											echo $notMentionedText;
											
										if($visitReport['camera_comments']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['camera_comments']).'</p>';
                                    ?>
                                  </th>
                              </tr>
                              
                           </tbody>
                      </table>
                  
                  </div>
            </div>   
        </div>        
    <!--5th bix #ENDS-->
  
    <!--Host attributes box #STARTS-->
        <div id="about-area">
            <div id="table-responsive" data-widget="{&quot;draggable&quot;: &quot;false&quot;}">
                    <table id="panel-heading" cellspacing="0" cellpadding="0">
              <thead>
              <tr>
              <th <?=$styleTextLeftAlign?>>Host's Attributes</th>
              </tr>
              </thead>
              </table>
                <div id="panel-body">
                  
                      <table id="table">
                          <tbody>
                      
                              <!--<tr>
                                  <th class="lalalal" <?=$styleTextLeftAlign?>>Experienced host? How many years of experience do you have?: 
										<p style="font-weight:normal;"><?=nl2br($visitReport['host_exp'])?></p>
                                 </th>
                              </tr>
                              
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Multicultural family? How long have you been staying in Australia for? What language do you speak? Please specify who speak what!:  
										<p style="font-weight:normal;"><?=nl2br($visitReport['multicultural'])?></p>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Interest/hobbies: 
										<p style="font-weight:normal;"><?=nl2br($visitReport['interest'])?></p>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Overtly religious household?:  
										<p style="font-weight:normal;"><?=nl2br($visitReport['religious'])?></p>
                                  </th>
                              </tr>-->
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Does the host have the capability to look after U18 students section (as requested by some institutions)?:  
										<p style="font-weight:normal;"><?php if(trim($visitReport['u18_compatible']!='')){echo nl2br($visitReport['u18_compatible']);}else{ echo $notMentionedText;}?></p>
                                  </th>
                              </tr>
                      
                           </tbody>
                      </table>
                  
                  </div>
            </div>   
        </div>
    <!--Host attributes bix #ENDS-->  
  
    <!--Here about us box #STARTS-->
        <!--<div id="about-area">
            <div id="table-responsive" data-widget="{&quot;draggable&quot;: &quot;false&quot;}">
                     <table id="panel-heading" cellspacing="0" cellpadding="0">
              <thead>
              <tr>
              <th <?=$styleTextLeftAlign?>>How did you hear about us</th>
              </tr>
              </thead>
              </table>
                <div id="panel-body">
                  
                      <table id="table">
                          <tbody>
                      
                              <tr>
                                  <th class="lalalal" <?=$styleTextLeftAlign?>>Referral: 
										<p style="font-weight:normal;"><?=nl2br($visitReport['here_referral'])?></p>
                                 </th>
                              </tr>
                              
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Advertising media (flyer distribution, cinema advertising, newspaper) - please specify!:  
										<p style="font-weight:normal;"><?=nl2br($visitReport['here_adv_media'])?></p>
                                  </th>
                              </tr>
                      
                              <tr>
                                  <th <?=$styleTextLeftAlign?>>Other (Facebook, google, website, etc.) - please specify!: 
										<p style="font-weight:normal;"><?=nl2br($visitReport['here_fb'])?></p>
                                  </th>
                              </tr>
                              
                           </tbody>
                      </table>
                  
                  </div>
            </div>   
        </div>-->
    <!--Here about us box #ENDS-->  
  
    <!--6th box #STARTS-->
        <!--<div id="about-area">
            <div id="table-responsive" data-widget="{&quot;draggable&quot;: &quot;false&quot;}">
            <table id="panel-heading" cellspacing="0" cellpadding="0">
              <thead>
              <tr>
              <th <?=$styleTextLeftAlign?>>Additional comments</th>
              </tr>
              </thead>
              </table>
                <div id="panel-body">
                  
                      <table id="table">
                          <tbody>
                      
                              <tr>
                                  <th class="lalalal" <?=$styleTextLeftAlign?>>

                                  	<?php
                                    	if($visitReport['comments']!='')
											echo '<p style="font-weight:normal;">'.nl2br($visitReport['comments']).'</p>';
										else
											echo $notMentionedText;
									?>
                                  </th>
                              </tr>
                      
                          </tbody>
                      </table>
                  
                  </div>
            </div>   
        </div>-->
    <!--6th bix #ENDS-->
  
  </div>
    
</div>
	
</body>

</html>