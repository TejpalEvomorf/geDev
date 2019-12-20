<?php
$hfaStatusList=hfaStatusList();
$roomTypeList=roomTypeList();
$facilityList=getHfaFacilityList();
$nationList=nationList();
$religionList=religionList();
$languageList=languageList();
?>
<style type="text/css">
#hfaList_filter
{
	margin:0 !important;
}
</style>

<div class="page-heading">
      <h1>
      	<?php
		if($hfa_status_page!="all")
		{
        	echo $hfaStatusList[$hfa_status_page];
			if($hfa_status_page=='new')
				echo " applications";
		}
		else
			echo "All applications";;
		?>
      </h1>
      <div class="m-n DTTT btn-group pull-right" id="">
  <a class="btn btn-default" href="<?=site_url()?>hfa/application_create" target="_blank">
    <i class="colorBlue fa fa-plus"></i> 
    <span class="colorBlue" onclick="">Add new</span>
  </a>
</div>
        <div class="m-n DTTT btn-group pull-right">
              <a class="btn btn-default" id="hfaFiltersBtn">
                  <i class="colorBlue fa fa-filter"></i> 
                  <span class="colorBlue">Filters</span>
              </a>
        </div>
        
        <div class="relposition panel-ctrls pull-right" id="hfaPanelCtrls">
             <div class="m-n DTTT btn-group pull-right" id="hfaSearchBtn">
             	<a class="btn btn-default">
                   <i class="colorBlue fa fa-search"></i>
                   <span class="colorBlue">Search</span>
                </a>
			 </div>
         </div>
       	 <div class="options"></div>
</div>

<?php
//if((isset($_GET['appStep']) && ($_GET['appStep']=='partial' || $_GET['appStep']=='complete' || $_GET['appStep']=='bookmarked' || $_GET['appStep']=='revisited')) || (isset($_GET['appState']) && $_GET['appState']!='' || (isset($_GET['appReason']) && $_GET['appReason']!=''  )) || !empty($_GET['room']) || (isset($_GET['wwcc']) && ($_GET['wwcc']=='na' || $_GET['wwcc']=='expired' || $_GET['wwcc']=='turned18')) || (isset($_GET['insurance']) && ($_GET['insurance']=='na' || $_GET['insurance']=='expired')) || (isset($_GET['cApproval']) && $_GET['cApproval']!='') || !empty($_GET['warning'])){?>
<?php if((isset($_GET['appStep']) && ($_GET['appStep']=='partial' || $_GET['appStep']=='complete' || $_GET['appStep']=='bookmarked' || $_GET['appStep']=='revisited')) || (isset($_GET['appState']) && $_GET['appState']!='' || (isset($_GET['appReason']) && $_GET['appReason']!=''  )) || !empty($_GET['room']) || (isset($_GET['wwcc']) && ($_GET['wwcc']=='na' || $_GET['wwcc']=='expired' || $_GET['wwcc']=='turned18')) || (isset($_GET['insurance']) && ($_GET['insurance']=='na' || $_GET['insurance']=='expired')) || (isset($_GET['cApproval']) && $_GET['cApproval']!='') || !empty($_GET['warning']) || (isset($_GET['roomType']) && $_GET['roomType']!='') || (isset($_GET['facility']) && $_GET['facility']!='') || (isset($_GET['religion']) && $_GET['religion']!='') || (isset($_GET['nation']) && $_GET['nation']!='') || (isset($_GET['language']) && $_GET['language']!='')){?>
<div class="filterbtnhol">
<button class="mt-n btn btn-xs btn-danger btn-label hfaRemoveFilter pull-right" href="#" filter="all">
<i class="fa fa-close"></i>
Reset filters
</button>
	<?php if(isset($_GET['appStep']) && ($_GET['appStep']=='partial' ||$_GET['appStep']=='complete' ||$_GET['appStep']=='bookmarked' || $_GET['appStep']=='revisited'  ) ){
			if($_GET['appStep']=='partial')
				$appStep="Partially filled";
			elseif($_GET['appStep']=='complete')
				$appStep="Complete";
				elseif($_GET['appStep']=='bookmarked')
				$appStep="Bookmarked";
				elseif($_GET['appStep']=='revisited')
				$appStep="Revisited";
					
		?>
        <button class="mt-n btn btn-xs btn-danger btn-label hfaRemoveFilter pull-right" href="#" filter="appStep">
<i class="fa fa-close"></i>
<?=$appStep?>
</button>

<?php }?>
<?php if(isset($_GET['appState']) && $_GET['appState']!=''){?>
		<?php 
			if(!is_array($_GET['appState']))
				$_GET['appState']=explode(',',$_GET['appState']);
        	foreach($_GET['appState'] as $appStateV)
			{?>
             <button class="mt-n btn btn-xs btn-danger btn-label hfaRemoveFilter pull-right" href="#" filter="appState">
             <i class="fa fa-close"></i>
<?=$appStateV?>
</button>
			<?php }
		?>
<?php } ?>
<?php if(isset($_GET['appReason']) && ($_GET['appReason']!='')){
	 $appReason=$_GET['appReason'];
			
		?>
        <button class="mt-n btn btn-xs btn-danger btn-label hfaRemoveFilter pull-right" href="#" filter="appReason">
<i class="fa fa-close"></i>
<?=$appReason?>
</button>
<?php }?>

<?php if(!empty($_GET['warning'])){
	 $warning=$_GET['warning'];
			
		?>
        <button class="mt-n btn btn-xs btn-danger btn-label hfaRemoveFilter pull-right" href="#" filter="warning">
<i class="fa fa-close"></i>
No of warnings-<?=$warning?>
</button>
<?php }?>

<?php if(!empty($_GET['room'])){
	 $room=$_GET['room'];
			
		?>
        <button class="mt-n btn btn-xs btn-danger btn-label hfaRemoveFilter pull-right" href="#" filter="room">
<i class="fa fa-close"></i>
Room-<?=$room?>
</button>
<?php }?>

<?php if(isset($_GET['wwcc']) && ($_GET['wwcc']=='na' || $_GET['wwcc']=='expired' || $_GET['wwcc']=='turned18')){
			if($_GET['wwcc']=='na')
				$wwcc="WWCC: Not available";
			elseif($_GET['wwcc']=='expired')
				$wwcc="WWCC: Expired";
			elseif($_GET['wwcc']=='turned18')
				$wwcc="WWCC: Member turned 18";
		?>
        <button class="mt-n btn btn-xs btn-danger btn-label hfaRemoveFilter pull-right" href="#" filter="wwcc">
<i class="fa fa-close"></i>
<?=$wwcc?>
</button>

<?php }?>

<?php if(isset($_GET['insurance']) && ($_GET['insurance']=='na' || $_GET['insurance']=='expired')){
			if($_GET['insurance']=='na')
				$insruance="Insurance: Not available";
			elseif($_GET['insurance']=='expired')
				$insruance="Insurance: Expired";
		?>
        <button class="mt-n btn btn-xs btn-danger btn-label hfaRemoveFilter pull-right" href="#" filter="insurance">
<i class="fa fa-close"></i>
<?=$insruance?>
</button>

<?php }?>

	<?php if(isset($_GET['cApproval']) && $_GET['cApproval']!=''){
			$clientDetail=clientDetail($_GET['cApproval']);
			$cApproval="Approved by ".$clientDetail['bname'];
		?>
        <button class="mt-n btn btn-xs btn-danger btn-label hfaRemoveFilter pull-right" href="#" filter="cApproval">
			<i class="fa fa-close"></i>
			<?=$cApproval?>
		</button>

<?php }?>

<?php if(isset($_GET['roomType']) && $_GET['roomType']!=''){?>
		<?php 
			if(!is_array($_GET['roomType']))
				$_GET['roomType']=explode(',',$_GET['roomType']);
        	foreach($_GET['roomType'] as $rTypeV)
			{?>
             <button class="mt-n btn btn-xs btn-danger btn-label hfaRemoveFilter pull-right" href="#" filter="roomType" filterVal="<?=$rTypeV?>">
             <i class="fa fa-close"></i>
<?=$roomTypeList[$rTypeV].' Room'?>
</button>
			<?php }
		?>
<?php } ?>

<?php if(isset($_GET['facility']) && $_GET['facility']!=''){?>
		<?php 
			if(!is_array($_GET['facility']))
				$_GET['facility']=explode(',',$_GET['facility']);
        	foreach($_GET['facility'] as $facilityV)
			{?>
             <button class="mt-n btn btn-xs btn-danger btn-label hfaRemoveFilter pull-right" href="#" filter="facility" filterVal="<?=$facilityV?>">
             <i class="fa fa-close"></i>
<?=$facilityList[$facilityV]?>
</button>
			<?php }
		?>
<?php } ?>

	<?php if(isset($_GET['nation']) && $_GET['nation']!=''){
		?>
        <button class="mt-n btn btn-xs btn-danger btn-label hfaRemoveFilter pull-right" href="#" filter="nation">
			<i class="fa fa-close"></i>
			<?=$nationList[$_GET['nation']]?>
		</button>

<?php }?>

	<?php if(isset($_GET['religion']) && $_GET['religion']!=''){
		?>
        <button class="mt-n btn btn-xs btn-danger btn-label hfaRemoveFilter pull-right" href="#" filter="religion">
			<i class="fa fa-close"></i>
			<?=$religionList[$_GET['religion']]?>
		</button>

<?php }?>

	<?php if(isset($_GET['language']) && $_GET['language']!=''){
		?>
        <button class="mt-n btn btn-xs btn-danger btn-label hfaRemoveFilter pull-right" href="#" filter="language">
			<i class="fa fa-close"></i>
			<?='Language: '.$languageList[$_GET['language']]?>
		</button>

<?php }?>

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
					<table id="hfaList" class="noborder0 table table-striped table-bordered table-fixed-header m-n" cellspacing="0" width="100%">
						<thead>
							<tr>
									<th>Host</th>
									<th>Contact</th>
                                    <?php 
												if($hfa_status_page=='confirmed' || $hfa_status_page=='pending_approval' || $hfa_status_page=='approved' || $hfa_status_page=='do_not_use'){?>
									<th>
                                    		<?php 
												if($hfa_status_page=='confirmed')
			                                	    echo "Visit info";
												elseif($hfa_status_page=='pending_approval' || $hfa_status_page=='approved')	
													echo "Documents";
												elseif($hfa_status_page=='do_not_use')	
													echo "Reason";	
        		                            ?>
                                    </th>
                                    <?php } ?>
                                    
                                    <?php 
												if($hfa_status_page=='new' || $hfa_status_page=='no_response' || $hfa_status_page=='all'){?>
													<th width="120px">Submitted</th>
                                    <?php } ?>
                                    
                                    <?php 
												if($hfa_status_page=='unavailable'){?>
													<th>Unavailable</th>
                                    <?php } ?>
                                    
                                    
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
                            
                            
                       <div class="modal fade" id="model_ChangeStatusHfa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h2 class="modal-title">Change application status</h2>
							</div>
                            
                            <div class="modal-body">
                                <form id="hfaChangeStatus_form"></form>                
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-success btn-raised" id="hfaChangeStatusSubmit">Save</button>
                                <img src="<?=loadingImagePath()?>" id="hfaChangeStatusProcess" style="margin-right:16px;display:none;">
                            </div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->

			</div>
            
            <!--Loading the wwcc and PL insurance pop ups-->
			<?php $this->load->view('system/hfa/wwccPlInsPopups.php');?>
            
            <!-- /.Email completion modal -->
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
								<button type="button" class="btn btn-success btn-raised" id="sendCompletionEmailSubmit" onclick="sendEmailHalfApplicationHfa();">Send</button>
                                <img src="<?=loadingImagePath()?>" id="sendCompletionEmailSubmitProcess" style="margin-right:16px;display:none;">
                            </div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->

			</div>
           
            <?php if($hfa_status_page=="confirmed"){?> 
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
                                    <button type="button" class="btn btn-success btn-raised" id="rescheduleVisitSubmit" >Reschedule</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
    
                </div>    
            <?php } ?>
            
            
            <?php if($hfa_status_page=="unavailable"){?> 
                 <div class="modal fade" id="model_changeUnavailableToDate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h2 class="modal-title">Change date</h2>
                                </div>
                                
                                <div class="modal-body">
                                    <form id="model_changeUnavailableToDate_form" data-parsley-validate></form>                
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success btn-raised" id="changeUnavailableToDateSubmit" >Update</button>
                                    <img src="<?=loadingImagePath()?>" id="changeUnavailableToDateProcess" style="margin-right:16px;display:none;">
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
    
                </div>    
            <?php } ?>
            
            <div class="modal fade" id="model_doNotUseChangeStatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h2 class="modal-title">Change application status</h2>
                                </div>
                                
                                <div class="modal-body" style="margin-top: 16px;">
                                    <!--<span>You cannot change the status of a Do not use application.</span>-->
                                </div>
                                <div class="modal-footer">
                                    <button data-bb-handler="danger" type="button" class="ml5 btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
    
                </div>
 
<?php $this->load->view('system/hfa/revisitPop');?>           
 
<form id="hfaFiltersFormHidden">
<?php
if(isset($_GET['appStep']) && ($_GET['appStep']=='partial' || $_GET['appStep']=='complete' || $_GET['appStep']=='bookmarked' || $_GET['appStep']=='revisited'))
	$appStep=$_GET['appStep'];
else
	$appStep='';	
	
if(isset($_GET['appState']) && $_GET['appState']!='')
	$appState=implode(',',$_GET['appState']);
else
	$appState='';
if(isset($_GET['appReason']) && ($_GET['appReason']!=''))
	$appReason=$_GET['appReason'];
else
	$appReason='';	

if(!empty($_GET['warning']))
		$warning=$_GET['warning'];
else
	$warning='';	

if(!empty($_GET['room']))
		$room=$_GET['room'];
else
	$room='';
	
if(isset($_GET['wwcc']) && ($_GET['wwcc']=='na' || $_GET['wwcc']=='expired' || $_GET['wwcc']=='turned18'))
	$wwcc=$_GET['wwcc'];
else
	$wwcc='';
	
if(isset($_GET['insurance']) && ($_GET['insurance']=='na' || $_GET['insurance']=='expired'))
	$insurance=$_GET['insurance'];
else
	$insurance='';
	
if(isset($_GET['cApproval']) && $_GET['cApproval']!='')
	$cApproval=$_GET['cApproval'];
else
	$cApproval='';
	
if(isset($_GET['roomType']) && $_GET['roomType']!='')
	$roomType=implode(',',$_GET['roomType']);
else
	$roomType='';
	
if(isset($_GET['nation']) && $_GET['nation']!='')
	$nation=$_GET['nation'];
else
	$nation='';
	
if(isset($_GET['religion']) && $_GET['religion']!='')
	$religion=$_GET['religion'];
else
	$religion='';
	
if(isset($_GET['facility']) && $_GET['facility']!='')
	$facility=implode(',',$_GET['facility']);
else
	$facility='';
	
if(isset($_GET['language']) && $_GET['language']!='')
	$language=$_GET['language'];
else
	$language='';
?>
	<input type="hidden" name="appStep" value="<?=$appStep?>" />
    <input type="hidden" name="appState" value="<?=$appState?>" />
    <input type="hidden" name="appReason" value="<?=$appReason?>" />
    <input type="hidden" name="cstatus" value="<?=$hfa_status_page?>" />
    <input type="hidden" name="warning" value="<?=$warning?>" />
    <input type="hidden" name="room" value="<?=$room?>" />
    <input type="hidden" name="wwcc" value="<?=$wwcc?>" />
    <input type="hidden" name="insurance" value="<?=$insurance?>" />
    <input type="hidden" name="cApproval" value="<?=$cApproval?>" />
    <input type="hidden" name="roomType" value="<?=$roomType?>" />
    <input type="hidden" name="nation" value="<?=$nation?>" />
    <input type="hidden" name="religion" value="<?=$religion?>" />
    <input type="hidden" name="facility" value="<?=$facility?>" />
    <input type="hidden" name="language" value="<?=$language?>" />
    

</form>

<script type="text/javascript">
var hfa_status_page='<?=$hfa_status_page?>';
var appStep='<?=$appStep?>';
var appState='<?=$appState?>';
var appReason='<?=$appReason?>';
var warning='<?=$warning?>';
var room='<?=$room?>';
var wwcc='<?=$wwcc?>';
var insurance='<?=$insurance?>';
var cApproval='<?=$cApproval?>';
var roomType='<?=$roomType?>';
var nation='<?=$nation?>';
var religion='<?=$religion?>';
var facility='<?=$facility?>';
var language='<?=$language?>';


$(document).ready(function(){
	
	$('#hfaChangeStatus_time').timepicker({
			minuteStep: 15
			/*defaultTime:'current',
			autoUpdateInput:false,
	        showInputs: false,
	        disableFocus: false*/
		});

		
		$('#hfaChangeStatus_date').datepicker({
			orientation: "top",
			todayHighlight: true,
	    	startDate: "-0d",
			format:'dd/mm/yyyy',
			autoclose:true
		});
		
		 var tabToOpen = window.location.hash;
    if (tabToOpen != '' && tabToOpen == '#applicationCreated') {
      notiPop("success", "Host Family application created successfully.", "");
      window.location.hash = '';
    }


	});
	
	
</script>