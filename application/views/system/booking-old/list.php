<?php
$bookingStatusList=bookingStatusList();
$accomodationTypeList=accomodationTypeList();
$bookingSortList=bookingSortList();
?>

<style type="text/css">
#bookingList_filter
{
	margin:0 !important;
}
.tooltip-inner {
  max-width: 1000px;
}
</style>

<div class="page-heading">
      <h1>	<?php
		if($booking_status_page!="all")
			echo $bookingStatusList[$booking_status_page];
		else
			echo "All bookings";
		?></h1>
        
        <div class="m-n DTTT btn-group pull-right">
          <a class="btn btn-default" id="bookingListFiltersBtn">
            <i class="colorBlue fa fa-filter"></i> 
            <span class="colorBlue">Filters</span>
          </a>
        </div>
        <div class="m-n DTTT btn-group pull-right">
          <a class="btn btn-default" id="bookingsortListFiltersBtn">
            <i class="colorBlue fa fa-filter"></i> 
            <span class="colorBlue">Sort</span>
          </a>
        </div>
        <!--<div class="m-n DTTT btn-group pull-right" id="">
          <a class="btn btn-default dropdown-toggle"   href="javascript:void(0);" data-toggle="dropdown">
            <span class="colorBlue" onclick="">Create new booking</span>
            <span class="caret colorBlue"></span>
          </a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="javascript:void(0);" data-toggle="modal" data-target="#model_createNewBooking_inPast" onclick="resetBookingForms();">Create booking in past</a></li>
            <li><a href="javascript:void(0);" data-toggle="modal" data-target="#model_createNewBooking_inFuture" onclick="resetBookingForms();">Move student to different family</a></li>
        </ul>
        </div>-->
            
        <!--<div class="m-n DTTT btn-group pull-right">
          <a class="btn btn-default" href="<?=site_url()?>booking/changeHomestay">
            <i class="colorBlue fa fa-filter"></i> 
            <span class="colorBlue">Change homestay</span>
          </a>
        </div>-->
                                   
        <!--<div class="relposition panel-ctrls pull-right" id="bookingPanelCtrls">
             <div class="m-n DTTT btn-group pull-right" id="bookingSearchBtn">
             	<a class="btn btn-default">
                   <i class="colorBlue fa fa-search"></i>
                   <span class="colorBlue">Search</span>
                </a>
			 </div>
         </div>-->
        
</div>


<?php
$tile_bookingId=false;
if(isset($_GET['booking_id']) && $_GET['booking_id']!='')
	$tile_bookingId=true;
$tile_studentName=false;
if(isset($_GET['student']) && $_GET['student']!='')
	$tile_studentName=true;	
$tile_hostName=false;
if(isset($_GET['host']) && $_GET['host']!='')
	$tile_hostName=true;
$tile_bookingFrom=false;
if(isset($_GET['from']) && $_GET['from']!='')
	$tile_bookingFrom=true;	
$tile_bookingTo=false;
if(isset($_GET['to']) && $_GET['to']!='')
	$tile_bookingTo=true;
$tile_client=false;
if(isset($_GET['client']) && $_GET['client']!='')
	$tile_client=true;
$tile_studyTour=false;
if(isset($_GET['study_tour']) && $_GET['study_tour']!='')
	$tile_studyTour=true;
$tile_bookingWithWarnings=false;
if(($booking_status_page=='expected_arrival' || $booking_status_page=='all') && isset($_GET['bookingWithWarnings']) && $_GET['bookingWithWarnings']!='' && isset($_GET['bookingTourType']))
	$tile_bookingWithWarnings=true;			

if((isset($_GET['bookingTourType']) &&($_GET['bookingTourType']=='yes' ||$_GET['bookingTourType']=='no'  || $_GET['bookingTourType']=='U18' )) ||(isset($_GET['bookingSortType']) &&($_GET['bookingSortType']=='studentnamea' ||$_GET['bookingSortType']=='arrivaldate'||$_GET['bookingSortType']=='studentnamez' ||$_GET['bookingSortType']=='hostfamilya' || $_GET['bookingSortType']=='hostfamilyz'))|| (isset($_GET['bookingProductType']) &&($_GET['bookingProductType']!='')) || $tile_bookingId || $tile_studentName || $tile_hostName || $tile_bookingFrom || $tile_bookingTo || $tile_client || $tile_studyTour || $tile_bookingWithWarnings){?>
<div class="filterbtnhol">
  <button class="mt-n btn btn-xs btn-danger btn-label bookingRemoveFilter pull-right" href="#" filter="all">
    <i class="fa fa-close"></i> Reset filters
  </button>
  <?php if(isset($_GET['bookingTourType']) &&($_GET['bookingTourType']=='yes' ||$_GET['bookingTourType']=='no'  ||$_GET['bookingTourType']=='U18')){
    if($_GET['bookingTourType']=='yes')
      $bookingTourType="Only tour group bookings";
    elseif($_GET['bookingTourType']=='no')
      $bookingTourType="Non tour group bookings";
	  elseif($_GET['bookingTourType']=='U18')
      $bookingTourType="Under 18 student booking";
    ?>
    <button class="mt-n btn btn-xs btn-danger btn-label bookingRemoveFilter pull-right" href="#" filter="bookingTourType">
      <i class="fa fa-close"></i>
      <?=$bookingTourType?>
    </button>
    <?php }?>
    <?php if(isset($_GET['bookingSortType']) &&($_GET['bookingSortType']=='studentnamea' ||$_GET['bookingSortType']=='arrivaldate'||$_GET['bookingSortType']=='studentnamez' ||$_GET['bookingSortType']=='hostfamilya' || $_GET['bookingSortType']=='hostfamilyz'))
	{   $bookingSortType =$_GET['bookingSortType'];?>
<button class="mt-n btn btn-xs btn-danger btn-label bookingRemoveFilter pull-right" href="#" filter="bookingSortType">
      <i class="fa fa-close"></i>
      <?=$bookingSortList[$bookingSortType]?>
    </button>

<?php }?>
     <?php if($tile_bookingWithWarnings){?>
     <button class="mt-n btn btn-xs btn-danger btn-label bookingRemoveFilter pull-right" href="#" filter="bookingWithWarnings">
      <i class="fa fa-close"></i>
      <?='Bookings with warnings'?>
    </button>
     <?php } ?>
    
    
    <?php if(isset($_GET['bookingProductType']) &&($_GET['bookingProductType']!='')){
    	$bookingProductType=$accomodationTypeList[$_GET['bookingProductType']];
    ?>
    <button class="mt-n btn btn-xs btn-danger btn-label bookingRemoveFilter pull-right" href="#" filter="bookingProductType">
      <i class="fa fa-close"></i>
      <?=$bookingProductType?>
    </button>
    <?php }?>
     
     <?php if($tile_bookingId){?>
     <button class="mt-n btn btn-xs btn-danger btn-label bookingRemoveFilter pull-right" href="#" filter="booking_id">
      <i class="fa fa-close"></i>
      <?='Booking id: '.$_GET['booking_id']?>
    </button>
     <?php } ?>
     
     <?php if($tile_studentName){?>
     <button class="mt-n btn btn-xs btn-danger btn-label bookingRemoveFilter pull-right" href="#" filter="student">
      <i class="fa fa-close"></i>
      <?='Student: '.$_GET['student']?>
    </button>
     <?php } ?>
     
     <?php if($tile_hostName){?>
     <button class="mt-n btn btn-xs btn-danger btn-label bookingRemoveFilter pull-right" href="#" filter="host">
      <i class="fa fa-close"></i>
      <?='Host: '.$_GET['host']?>
    </button>
     <?php } ?>
     
     <?php if($tile_bookingTo){?>
     <button class="mt-n btn btn-xs btn-danger btn-label bookingRemoveFilter pull-right" href="#" filter="to">
      <i class="fa fa-close"></i>
      <?='To: '.dateFormat(normalToMysqlDate($_GET['to']))?>
    </button>
     <?php } ?>
     
	 <?php if($tile_bookingFrom){?>
     <button class="mt-n btn btn-xs btn-danger btn-label bookingRemoveFilter pull-right" href="#" filter="from">
      <i class="fa fa-close"></i>
      <?='From: '.dateFormat(normalToMysqlDate($_GET['from']))?>
    </button>
     <?php } ?>  
     
     <?php if($tile_client){
		 $clientDetail=clientDetail($_GET['client']);
		 ?>
     <button class="mt-n btn btn-xs btn-danger btn-label bookingRemoveFilter pull-right" href="#" filter="client">
      <i class="fa fa-close"></i>
      <?='Client: '.$clientDetail['bname']?>
    </button>
     <?php } ?>
     
     <?php if($tile_studyTour){
		 $tile_tourDetail=tourDetail($_GET['study_tour'])
		 ?>
     <button class="mt-n btn btn-xs btn-danger btn-label bookingRemoveFilter pull-right" href="#" filter="study_tour">
      <i class="fa fa-close"></i>
      <?='tour group: '.$tile_tourDetail['group_name']?>
    </button>
     <?php } ?>                  
      
    </div>
    <?php } ?>

<div class="container-fluid">                                
    <div data-widget-group="group1">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body no-padding">
                        <table id="bookingList" class="noborder0 table table-striped table-bordered table-fixed-header m-n" cellspacing="0" width="100%">
                          <thead>
                              <tr>
                                  <th width="300px">Booking info</th>
                                  <th width="300px">Host</th>
                                  <th>Student</th>
                                  <th width="60px">Status</th>
                                  <th width="100px">Office use</th>
                                  <th width="60px">Actions</th>
                              </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                    </div>
                    <div class="panel-footer"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
$this->load->view('system/booking/changeStatusPopUp'); 
$this->load->view('system/booking/editBookingPopUp');
$this->load->view('system/booking/checkupPopUp');
//$this->load->view('system/booking/createNewBookingPopUp');
?>


<form id="bookingFiltersFormHidden">
  <?php
	$bookingFilter_bookingWithWarnings='';
    if(isset($_GET['bookingTourType']) && ($_GET['bookingTourType']=='yes' || $_GET['bookingTourType']=='no' || $_GET['bookingTourType']=='U18'))
	{
   		$bookingTourType=$_GET['bookingTourType'];
		
		if(isset($_GET['bookingWithWarnings']))
			$bookingFilter_bookingWithWarnings='1';
	}
	else
   		$bookingTourType=''; 
		
	if(isset($_GET['bookingProductType']) &&($_GET['bookingProductType']!=''))
    	$bookingProductType=$_GET['bookingProductType'];
	else	
		$bookingProductType='';
		
	
if(isset($_GET['booking_id']))
   $bookingFilter_booking_id=$_GET['booking_id'];
 else
   $bookingFilter_booking_id='';
   
if(isset($_GET['booking_idSF']))
   $bookingFilter_booking_idSF=$_GET['booking_idSF'];
 else
   $bookingFilter_booking_idSF=''; 		

	if(isset($_GET['student']))
  	 $bookingFilter_student=$_GET['student'];
	else
   	$bookingFilter_student='';   

	if(isset($_GET['host']))
  	 $bookingFilter_host=$_GET['host'];
	else
	 $bookingFilter_host='';	

   if(isset($_GET['from']))
  	 $bookingFilter_from=$_GET['from'];
	else
   	$bookingFilter_from='';	

   if(isset($_GET['to']))
  	 $bookingFilter_to=$_GET['to'];
	else
   	$bookingFilter_to='';	

   if(isset($_GET['client']))
  	 $bookingFilter_client=$_GET['client'];
	else
   	$bookingFilter_client='';

   if(isset($_GET['study_tour']))
  	 $bookingFilter_study_tour=$_GET['study_tour'];
	else
   	$bookingFilter_study_tour='';		
   if(isset($_GET['activealboking']))
  	 $bookingFilter_active_record=$_GET['activealboking'];
	else
   	$bookingFilter_active_record='activealboking';
	
 ?>
  <input type="hidden" name="bookingTourType" value="<?=$bookingTourType?>" />
  <input type="hidden" name="bookingWithWarnings" value="<?=$bookingFilter_bookingWithWarnings?>" />  
  <input type="hidden" name="bookingProductType" value="<?=$bookingProductType?>" />

  <input type="hidden" name="booking_id" value="<?=$bookingFilter_booking_id?>" /><input type="hidden" name="booking_idSF" value="<?=$bookingFilter_booking_idSF?>" />
  <input type="hidden" name="student" value="<?=$bookingFilter_student?>" />
  <input type="hidden" name="host" value="<?=$bookingFilter_host?>" />
  <input type="hidden" name="from" value="<?=$bookingFilter_from?>" />
  <input type="hidden" name="to" value="<?=$bookingFilter_to?>" />
  <input type="hidden" name="client" value="<?=$bookingFilter_client?>" />
  <input type="hidden" name="study_tour" value="<?=$bookingFilter_study_tour?>" />
  <input type="hidden" name="booking_status_page" value="<?=$booking_status_page?>" />
  <input type="hidden" name="activealboking" value="<?=$bookingFilter_active_record?>" />
          
</form>

<form id="bookingsortFiltersFormHidden">
  <?php
	$bookingFilter_bookingWithWarnings='';
    if(isset($_GET['bookingSortType']) &&($_GET['bookingSortType']=='studentnamea' ||$_GET['bookingSortType']=='arrivaldate'||$_GET['bookingSortType']=='studentnamez' ||$_GET['bookingSortType']=='hostfamilya' || $_GET['bookingSortType']=='hostfamilyz'))
	{
   		$bookingSortType=$_GET['bookingSortType'];
		
		
	}
	else
   		$bookingSortType=''; 
		
		
	
 ?>
  <input type="hidden" name="bookingSortType" value="<?= @$bookingSortType?>" />
 
          
</form>
<script type="text/javascript">
var booking_status_page='<?=$booking_status_page?>';
var bookingFilter_bookingWithWarnings='<?=$bookingFilter_bookingWithWarnings?>';
var bookingTourType='<?=$bookingTourType?>';
var bookingSortType='<?=@$bookingSortType?>';
var bookingProductType='<?=$bookingProductType?>';

var bookingFilter_booking_id='<?=$bookingFilter_booking_id?>';var bookingFilter_booking_idSF='<?=$bookingFilter_booking_idSF?>';
var bookingFilter_student='<?=$bookingFilter_student?>';
var bookingFilter_host='<?=$bookingFilter_host?>';
var bookingFilter_from='<?=$bookingFilter_from?>';
var bookingFilter_to='<?=$bookingFilter_to?>';
var bookingFilter_client='<?=$bookingFilter_client?>';
var bookingFilter_study_tour='<?=$bookingFilter_study_tour?>';
var bookingFilter_active_record='<?=$bookingFilter_active_record?>';

$(document).ready(function(){
	var tabToOpen=window.location.hash;
	if(tabToOpen=='#bookingPlaced')
		{
			notiPop('success','Booking placed successfully',"");
			//window.location.hash='';
			history.pushState('', document.title, window.location.pathname);
		}
});
</script>