<style type="text/css">

#clientList_filter

{

	margin:0 !important;

}

</style>

<?php

	$nameTitleList=nameTitleList();

	$accomodationTypeList=accomodationTypeList();

	$shaStatusList=shaStatusList();

?>

	<div class="page-heading">

      <h1>Tour group list</h1>

      	<!-- div class="m-n DTTT btn-group pull-right">

              <a class="btn btn-default" id="tourFiltersBtn">

                  <i class="colorBlue fa fa-filter"></i>

                  <span class="colorBlue">Filters</span>

              </a>

        </div -->

	
        <div class="m-n DTTT btn-group pull-right">
          <a id="tourListFiltersBtn" class="btn btn-default" >
            <i class="colorBlue fa fa-filter"></i> 
            <span class="colorBlue">Filters</span>
          </a>
        </div>								

      	<div class="relposition panel-ctrls pull-right" id="listTablePanelCtrls">
             <div class="m-n DTTT btn-group pull-right" id="listTableSearchBtn">
             	<a class="btn btn-default">
                   <i class="colorBlue fa fa-search"></i>
                   <span class="colorBlue">Search</span>
                </a>
			 </div>
         </div>

       	 <div class="options"></div>

		</div>

<?php if(isset($_GET['tourStatus']) && ($_GET['tourStatus']=='new' ||$_GET['tourStatus']=='pending_invoice' ||$_GET['tourStatus']=='approved_with_payment' ||$_GET['tourStatus']=='approved_without_payment' ||$_GET['tourStatus']=='rejected' ||$_GET['tourStatus']=='cancelled')){?>
<div class="filterbtnhol">
  <button class="mt-n btn btn-xs btn-danger btn-label hfaRemoveFilter pull-right" href="#" filter="all">
    <i class="fa fa-close"></i> Reset filters
  </button>
  
    <?php if(isset($_GET['tourStatus']) && ($_GET['tourStatus']=='new' ||$_GET['tourStatus']=='pending_invoice' ||$_GET['tourStatus']=='approved_with_payment' ||$_GET['tourStatus']=='approved_without_payment' ||$_GET['tourStatus']=='rejected' ||$_GET['tourStatus']=='cancelled')){ 
		$filterStatus=$shaStatusList[$_GET['tourStatus']];
	?>
    	
    <button class="mt-n btn btn-xs btn-danger btn-label hfaRemoveFilter pull-right" href="#" filter="tourStatus">
      <i class="fa fa-close"></i>
      <?=$filterStatus?>
    </button>
    <?php }?>
    
</div>
<?php }?>

<div class="container-fluid">



    <div data-widget-group="group1">

        <div class="row">

            <div class="col-md-12">

                <div class="panel panel-default">

                    	<div class="panel-body no-padding">

                        <table  id="tourList" class="noborder0 table table-striped table-bordered table-fixed-header m-n" cellspacing="0" width="100%">

														<thead>

															<tr>

																<th>Group Name</th>

																<th>Group Contact Detail</th>

																<th>No of Students</th>

																<th>Status</th>

																<th>Office Use</th>

																<th width="60px">Actions</th>

															</tr>

														</thead>

							              <tbody>

							                  <?php foreach($tours as $tourK=>$tourV){
											  $tourV['no_of_warnings']=count(getTourWarnings('all',$tourV['id']));
											  ?>

																	<tr class="odd gradeX" id="tour-<?php echo $tourV['id'];?>">

																			<td><a href="<?=site_url()?>tour/edit/<?php echo $tourV['id'];?>" target="_blank"><?php echo ucfirst($tourV['group_name']);?></a> <?php echo '<br /><b>Organized by: </b>',$tourV['client_name']; ?><?php echo '<br><span style="color:#b0b0b0;">Created: '.date('d M Y',strtotime($tourV['created'])).'</span>'?></td>

																		<td><?php echo $tourV['group_contact_name'];

																		if(!empty($tourV['group_contact_email'])) { echo '<br /><a class="mailto" href="mailto:'.$tourV['group_contact_email'].'">',$tourV['group_contact_email'].'</a>';}

																		if($tourV['group_contact_phone_no']!='')
																				echo '<br />',$tourV['group_contact_phone_no'];

																			?></td>

																		<td>
																			<?php 
																				echo $tourV['no_of_studets']. " Total";
																				if($tourV['cancelled_students']!=0)
																					echo '<br><span style="color:#b0b0b0;">'.$tourV['cancelled_students']. ' Cancelled</span>'
																			?>
                                                                        </td>

																		<td>

																			<button data-no_of_warnings="0" class="anchor_click mt-n mb-xs btn btn-sm btn-label" data-toggle="modal" data-target="#model_ChangeStatusTour" onclick="tourChangeStatusPopContent(<?php echo $tourV['id'];?>,'all');" id="changeStatusHfaEditBtn-<?php echo $tourV['id'];?>">

																				<i class="material-icons font14">edit</i>

																				<span><?php  echo @$shaStatusList[$tourV['status']];?></span>

																			</button>

																			<br />

																			<span class="statusChangeDate" data-placement="bottom" data-toggle="tooltip" data-original-title="Status change date">

																				<?php

																				if($tourV['date_status_changed']!='0000-00-00 00:00:00'){

																					echo date('d M Y',strtotime($tourV['date_status_changed']));

																				}

																			?>

																			</span>

																		</td>

																		<td>

																			<?php if($tourV['no_of_warnings'] > 0) { ?>

																			<a data-no_of_warnings="<?=$tourV['no_of_warnings']?>" data-tour_id="<?php echo $tourV['id']; ?>" class="anchor_count_warnings" data-toggle="modal" data-target="#model_ChangeTourWarnings" onclick="tourChangeWarningPopContent(<?php echo $tourV['id'];?>,'all');" href="javascript:void(0);"><i class="material-icons font14 colorOrange" data-placement="bottom"  data-toggle="tooltip"  data-original-title="<?php echo $tourV['no_of_warnings'],' Warning(s)';?>" >new_releases</i></a> 

																			<?php } ?>

																		</td>

																		<td>

												                          <div class="btn-group dropdown table-actions">

												                            <button class="btn btn-sm btn-midnightblue dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="true">

												                                <i class="colorBlue material-icons">more_horiz</i>

												                                <div class="ripple-container"></div>

												                            </button>

																				<ul class="dropdown-menu" role="menu">

																					<li>

																						<a href="<?=site_url()?>tour/all_students/<?php echo $tourV['id'];?>" target="_blank"><i class="font16 material-icons">edit</i>&nbsp;&nbsp;Manage Applications</a>

																					</li>

																					<li>

																						<a href="<?=site_url()?>tour/edit/<?php echo $tourV['id']?>" target="_blank"><i class="font16 material-icons">edit</i>&nbsp;&nbsp;Manage tour</a>

																					</li>

																					<!-- li>

																						<a href="javascript:;" class="tourDelete"><i class="font16 material-icons">delete</i>&nbsp;&nbsp;Delete</a>

																					</li -->

														                        </ul>

															                </div>

							                      </td>

							                    </tr>

							                  <?php } ?>

							              </tbody>

                        </table>

                    </div>

                    <div class="panel-footer"></div>

                </div>

            </div>

        </div>

    </div>

</div>



<div class="modal fade" id="model_ChangeTourWarnings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-dialog">

 	 <div class="modal-content">

 		 <div class="modal-header">

 			 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

 			 <h2 class="modal-title">Resolve Warnings</h2>

 			 <h5>You can only change the tour group status after resolving all warnings</h5>

 		 </div>

 		 <div class="modal-body">

 			 <form id="shaChangeWarning_form"></form>

 		 </div>

 		 <div class="modal-footer">

 		</div>

 	 </div><!-- /.modal-content -->

  </div><!-- /.modal-dialog -->

</div><!-- /.modal -->



<div class="modal fade" id="model_ChangeStatusTour" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-dialog">

 	 <div class="modal-content">

 		 <div class="modal-header">

 			 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

 			 <h2 class="modal-title">Change Tour Status</h2>

 		 </div>



 		 <div class="modal-body">

 			 <form id="shaChangeStatus_form"></form>

 		 </div>

 		 <div class="modal-footer">

 			 <button type="button" class="btn btn-success btn-raised" id="tourChangeStatusSubmit">Save</button>

 			 <img src="<?php echo loadingImagePath();?>" id="shaChangeStatusProcess" style="margin-right:16px;display:none;">
             <button data-bb-handler="danger" type="button" class="ml5 btn btn-default" data-dismiss="modal" style="display:none;" id="shaChangeStatusClose">Close</button>

 		 </div>

 	 </div><!-- /.modal-content -->

  </div><!-- /.modal-dialog -->

</div><!-- /.modal -->



<div class="modal fade" id="modal_MissingBookingDates" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-dialog">

 	 <div class="modal-content">

 		 <div class="modal-header">

 			 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

 			 <h2 class="modal-title">Missing booking dates</h2>

 		 </div>

		 <div class="modal-body">



 		 </div>

 		 <div class="modal-footer">

 			 <button type="button" class="btn btn-success btn-raised" data-dismiss="modal">Close</button>

 		 </div>

 	 </div><!-- /.modal-content -->

  </div><!-- /.modal-dialog -->

</div><!-- /.modal -->



<form id="tourFiltersFormHidden">

	<input type="hidden" name="tourStudents" value="1" />

</form>

<form id="tourListFiltersFormHidden">
  <?php
  $tourStatus='';
  if(isset($_GET['tourStatus']))
	$tourStatus=$_GET['tourStatus'];
 ?>
 <input type="hidden" name="tourStatus" value="<?=$tourStatus?>" />
</form>

<form id="hfaFiltersFormHidden">
  <?php
	if(isset($_GET['tourStatus']) && ($_GET['tourStatus']=='new' ||$_GET['tourStatus']=='pending_invoice' ||$_GET['tourStatus']=='approved_with_payment' ||$_GET['tourStatus']=='approved_without_payment' ||$_GET['tourStatus']=='rejected' ||$_GET['tourStatus']=='cancelled'))
		$filterStatus=$shaStatusList[$_GET['tourStatus']];
	else
		$filterStatus='';	
 ?>
 <input type="hidden" name="tourStatus" value="<?=$filterStatus?>" />
</form>

<script type="text/javascript">
$(document).ready(function(){
		var tabToOpen = window.location.hash;
		if (tabToOpen != '' && tabToOpen == '#warningsResolved') {
		  notiPop('success','All warnings resolved','')
		  
			  // remove fragment as much as it can go without adding an entry in browser history:
				window.location.replace("#");
				
	
			// slice off the remaining '#' in HTML5:    
			if (typeof window.history.replaceState == 'function') {
			history.replaceState({}, '', window.location.href.slice(0, -1));
			}
		  
		}
	});
</script>