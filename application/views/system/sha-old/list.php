<?php
$shaStatusList=shaStatusList();
?>
<style type="text/css">
#shaList_filter {
  margin: 0 !important;
}
</style>
<div class="page-heading">
  <h1>
   <?php
   if($sha_status_page!="all")
   {
     echo $shaStatusList[$sha_status_page];
     if($sha_status_page=='new')
      echo " applications";
  }
  else
   echo "All applications";;
 ?>
</h1>
<div class="m-n DTTT btn-group pull-right" id="">
  <a class="btn btn-default" href="<?=site_url()?>sha/application_create" target="_blank">
    <i class="colorBlue fa fa-plus"></i> 
    <span class="colorBlue" onclick="">Add new</span>
  </a>
</div>
<div class="m-n DTTT btn-group pull-right">
  <a class="btn btn-default" <?php if($sha_status_page=='approved_with_payment' || $sha_status_page=='approved_without_payment' ){?>id="hfaFiltersBtn_approved"<?php }else{?>id="shaFiltersBtn"<?php }?>>
    <i class="colorBlue fa fa-filter"></i> 
    <span class="colorBlue">Filters</span>
  </a>
</div>
<div class="relposition panel-ctrls pull-right" id="shaPanelCtrls">
  <div class="m-n DTTT btn-group pull-right" id="shaSearchBtn">
    <a class="btn btn-default">
     <i class="colorBlue fa fa-search"></i>
     <span class="colorBlue">Search</span>
   </a>
 </div>
</div>
<div class="options"></div>
</div>
<?php
if((isset($_GET['appStep']) && ($_GET['appStep']=='partial' || $_GET['appStep']=='complete')) || (isset($_GET['placement']) && ($_GET['placement']=='placed' || $_GET['placement']=='not_placed')) || (isset($_GET['appTourType']) &&($_GET['appTourType']=='yes' ||$_GET['appTourType']=='no')) || !empty($_GET['client']) || !empty($_GET['college']) || isset($_GET['appDuplicate'])){?>
<div class="filterbtnhol">
  <button class="mt-n btn btn-xs btn-danger btn-label hfaRemoveFilter pull-right" href="#" filter="all">
    <i class="fa fa-close"></i> Reset filters
  </button>
  <?php if(isset($_GET['appStep']) &&($_GET['appStep']=='partial' ||$_GET['appStep']=='complete')){
    if($_GET['appStep']=='partial')
      $appStep="Partially filled";
    elseif($_GET['appStep']=='complete')
      $appStep="Complete";
    ?>
    <button class="mt-n btn btn-xs btn-danger btn-label hfaRemoveFilter pull-right" href="#" filter="appStep">
      <i class="fa fa-close"></i>
      <?=$appStep?>
    </button>
    <?php }?>
    <?php if(isset($_GET['placement']) &&($_GET['placement']=='placed' ||$_GET['placement']=='not_placed')){
      if($_GET['placement']=='placed')
        $placement="Already placed";
      elseif($_GET['placement']=='not_placed')
        $placement="Not placed yet";
      ?>
      <button class="mt-n btn btn-xs btn-danger btn-label hfaRemoveFilter pull-right" href="#" filter="placement">
        <i class="fa fa-close"></i>
        <?=$placement?>
      </button>
      <?php }?>
      
    <?php if(isset($_GET['appTourType']) &&($_GET['appTourType']=='yes' ||$_GET['appTourType']=='no')){
    if($_GET['appTourType']=='yes')
      $appTourType="Only tour group applications";
    elseif($_GET['appTourType']=='no')
      $appTourType="Non tour group applications";
    ?>
    <button class="mt-n btn btn-xs btn-danger btn-label hfaRemoveFilter pull-right" href="#" filter="appTourType">
      <i class="fa fa-close"></i>
      <?=$appTourType?>
    </button>
    <?php }?>
      <?php if(!empty($_GET['client'])){
		//  see(clientDetail());
		 $clientDetail=clientDetail($_GET['client']);
		
		 ?>
     <button class="mt-n btn btn-xs btn-danger btn-label hfaRemoveFilter pull-right" href="#" filter="client">
      <i class="fa fa-close"></i>
      <?='Client: '.$clientDetail['bname']?>
    </button>
     <?php } ?>
	  <?php if(!empty($_GET['college'])){
		 $collegeDetail=collegeDetail($_GET['college']);
		// see($clientsListshause);
		 ?>
     <button class="mt-n btn btn-xs btn-danger btn-label hfaRemoveFilter pull-right" href="#" filter="college">
      <i class="fa fa-close"></i>
      <?='college: '.$collegeDetail['bname']?>
    </button>
     <?php } ?>
     
     
	  <?php if(!empty($_GET['appDuplicate'])){
		 $collegeDetail=collegeDetail($_GET['appDuplicate']);
		// see($clientsListshause);
		 ?>
     <button class="mt-n btn btn-xs btn-danger btn-label hfaRemoveFilter pull-right" href="#" filter="appDuplicate">
      <i class="fa fa-close"></i>
      Duplicate applications
    </button>
     <?php } ?>
     
    </div>
    <?php } ?>
    <div class="container-fluid">
      <div data-widget-group="group1">
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default">
                        <!--<div class="panel-heading">
            <h2>Data Tables</h2>
          </div>-->
          <div class="panel-body no-padding">
            <table id="shaList" class="noborder0 table table-striped table-bordered table-fixed-header m-n" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th width="">Student</th>
                  <th width="">
                 <?php 
                 if(!in_array($sha_status_page,array('rejected','cancelled')))
                  echo 'Accommodation type';
                else  
                 echo 'Other information';
               ?>
             </th>
             <th width="120px">Submitted</th>
             <th width="200px">Status</th>
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
<div class="modal fade" id="model_ChangeStatusSha" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h2 class="modal-title">Change application status</h2>
      </div>
      <div class="modal-body">
        <form id="shaChangeStatus_form"></form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-raised" id="shaChangeStatusSubmit">Save</button>
        <img src="<?=loadingImagePath()?>" id="shaChangeStatusProcess" style="margin-right:16px;display:none;">
        <button data-bb-handler="danger" type="button" class="ml5 btn btn-default" data-dismiss="modal" style="display:none;" id="shaChangeStatusClose">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
</div>
<div class="modal fade" id="model_sendCompletionEmail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h2 class="modal-title">Email completion link</h2>
      </div>
      <div class="modal-body">
        <form id="model_sendCompletionEmail_form" data-parsley-validate></form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-raised" id="sendCompletionEmailSubmit" onclick="sendEmailHalfApplicationSha();">Send</button>
        <img src="<?=loadingImagePath()?>" id="sendCompletionEmailSubmitProcess" style="margin-right:16px;display:none;">
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
</div>
<?php if($sha_status_page=="confirmed"){?>
<div class="modal fade" id="model_rescheduleVisit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h2 class="modal-title">Reschedule Visit</h2>
      </div>
      <div class="modal-body">
        <form id="model_rescheduleVisit_form" data-parsley-validate></form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-raised" id="rescheduleVisitSubmit">Reschedule</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
</div>
<?php } ?>
<!--Study tour pop up #STARTS-->
<div class="modal fade" id="model_ShaStudyTourInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        This application is a part of tour group:
        <h2 class="modal-title"></h2>
      </div>
      <div class="modal-body">
        <em>It can only be managed through the above mentioned tour group section.</em>
        <button type="button" class="btn btn-success btn-raised">Manage application</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
</div>
<!--Study tour pop up #ENDS-->
<form id="hfaFiltersFormHidden">
  <?php
  if(isset($_GET['appStep']) && ($_GET['appStep']=='partial' || $_GET['appStep']=='complete'))
   $appStep=$_GET['appStep'];
 else
   $appStep=''; 

 if(isset($_GET['placement']) && ($_GET['placement']=='not_placed' || $_GET['placement']=='placed' || $_GET['placement']=='both'))
   $placement=$_GET['placement'];
 else
   $placement=''; 
   
    if(isset($_GET['appTourType']) && ($_GET['appTourType']=='yes' || $_GET['appTourType']=='no'))
   		$appTourType=$_GET['appTourType'];
	else
   		$appTourType=''; 
	 if(isset($_GET['client']))
  	 $bookingFilter_client=$_GET['client'];
	else
   	$bookingFilter_client='';
if(isset($_GET['college']))
  	 $bookingFilter_college=$_GET['college'];
	else
   	$bookingFilter_college='';
	
	$appDuplicate=0;
	if(isset($_GET['appDuplicate']))
		$appDuplicate=1;
 ?>
 <input type="hidden" name="appStep" value="<?=$appStep?>" />
 <input type="hidden" name="placement" value="<?=$placement?>" />
 <input type="hidden" name="appTourType" value="<?=$appTourType?>" />
 <input type="hidden" name="client" value="<?=$bookingFilter_client?>" />
 <input type="hidden" name="college" value="<?=$bookingFilter_college?>" />
 <input type="hidden" name="appDuplicate" value="<?=$appDuplicate?>" />
</form>
<script type="text/javascript">
  var sha_status_page = '<?=$sha_status_page?>';
  var appStep = '<?=$appStep?>';
  var placement = '<?=$placement?>';
  var appTourType = '<?=$appTourType?>';
  var bookingFilter_client='<?=$bookingFilter_client?>';
  var bookingFilter_college='<?=$bookingFilter_college?>';
  var appDuplicate='<?=$appDuplicate?>';

  $(document).ready(function() {
    var tabToOpen = window.location.hash;
    if (tabToOpen != '' && tabToOpen == '#applicationCreated') {
      notiPop("success", "Application created successfully", "");
      window.location.hash = '';
    }
	else if (tabToOpen != '' && tabToOpen == '#duplicateStudentCreated') {
      notiPop("success", "Cancelled application copied to New successfully", "");
      window.location.hash = '';
    }
  });
</script>