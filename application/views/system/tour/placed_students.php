<style type="text/css">

#clientList_filter

{

	margin:0 !important;

}

</style>

<?php $nameTitleList=nameTitleList();

$accomodationTypeList=accomodationTypeList();

$shaStatusList=shaStatusList();
$stateList=stateList();
?>

<div class="page-heading">

    <h1>Placed Students

			<small><?php echo $tour['group_name'];?></small>

		</h1>

		<div class="m-n DTTT btn-group pull-right">

					<a data-tour_id="<?php echo $tour['id'];?>" class="btn btn-default" id="tourFiltersBtn">

							<i class="colorBlue fa fa-filter"></i>

							<span class="colorBlue">Filters</span>

					</a>

		</div>

	<div class="relposition panel-ctrls pull-right" id="clientPanelCtrls">

		 <div class="m-n DTTT btn-group pull-right" id="clientSearchBtn">

			<a class="btn btn-default">

			   <i class="colorBlue fa fa-search"></i>

			   <span class="colorBlue">Search</span>

			</a>

		 </div>

	</div>

	<div class="options"></div>

</div>

<div class="filterbtnhol">

    <button data-tour_id="<?php echo $tour['id'];?>" class="mt-n btn btn-xs btn-danger btn-label tourPlacedRemoveFilter pull-right" href="#" filter="all">

    <i class="fa fa-close"></i>

    			Reset filters

    </button>

    <button data-tour_id="<?php echo $tour['id'];?>" class="mt-n btn btn-xs btn-danger btn-label tourPlacedRemoveFilter pull-right" href="#" filter="appStep">

      <i class="fa fa-close"></i>

							Placed

		</button>

</div>

<div class="container-fluid">

    <div data-widget-group="group1">

        <div class="row">

            <div class="col-md-12">

                <div class="panel panel-default">

                    <div class="panel-body no-padding">

                        <table id="clientList" class="noborder0 table table-striped table-bordered table-fixed-header m-n" cellspacing="0" width="100%">

							<thead>

								<tr>

								  <th width="300px">Student</th>

								  <th>Homestay details</th>

								  <th width="100px">Sumitted</th>

								  <th width="210px">Status</th>

									<th width="210px">Office use</th>

								  <th width="60px">Actions</th>

								</tr>

							</thead>

							<tbody>

                  <?php foreach($students as $studentK=>$studentV){ 
						  	$booking_exist=$this->sha_model->check_bookings_on_delete_action($studentV['id']);
				  ?>

										<tr id="shaApplication-<?php echo $studentV['id'];?>" role="row" class="odd">

											<td>
                                            	<a href="<?php echo site_url(),'sha/application/',$studentV['id'];?>" target="_blank"><?php echo $studentV['fname'],' ',$studentV['lname']; ?> </a><br><?php echo $studentV['email']; ?>
                                               <?php 
															if($studentV['sha_student_no']!='')
																echo '<br>'.$studentV['sha_student_no'];
															$accomodation_type = $studentV['accomodation_type'];
															echo '<br>'.str_replace('Homestay ','',$accomodationTypeList[$accomodation_type]);
												?>
                                            </td>

											<td>
                                            		<?php
                                                        	if(checkIfStudentPlaced($studentV['id']))
															{
																$booking=bookingByShaId($studentV['id']);
																$host=getHfaOneAppDetails($booking['host']);
																
																echo '<a href="'.site_url().'/hfa/application/'.$host['id'].'" target="_blank">';
																if($host['title']!='')
																	echo $nameTitleList[$host['title']]." ";
																echo ucwords($host['fname'].' '.$host['lname']).'</a><br>';
																
																echo $host['mobile'].'<br>';
																
																$addressForMap='';
																if($host['street']!='')
																	$addressForMap .=$host['street'].", ";
																$addressForMap .=ucfirst($host['suburb']).", ".$stateList[$host['state']].", ".$host['postcode'];
																echo getMapLocationLink($addressForMap);
															}
														?>
											</td>

											<td>

												<?php echo date('j M Y',strtotime($studentV['date'])); ?>

											</td>

											<td>

												<button class="mt-n mb-xs btn btn-sm btn-label" data-toggle="modal" data-target="#model_ChangeStatusSha" onclick="shaChangeStatusPopContent(<?php echo $studentV['id'];?>,'all');" id="changeStatusHfaEditBtn-<?php echo $studentV['id'];?>">

													<i class="material-icons font14">edit</i>

													<span><?php echo $shaStatusList[$studentV['status']];?></span>

												</button>

												<br />

												<span class="statusChangeDate" data-placement="bottom" data-toggle="tooltip" data-original-title="Status change date">

													<?php

													if($studentV['date_status_changed']!='0000-00-00 00:00:00'){



														echo date('d M Y',strtotime($studentV['date_status_changed']));

													}

												?>

												</span>

											</td>

											<td><?php if(($studentV['status']=='approved_with_payment' || $studentV['status']=='approved_without_payment') && checkIfStudentPlaced($studentV['id'])==true) { ?><i data-toggle="tooltip" data-original-title="Student placed" data-placement="bottom" class="fa fa-circle" style="color:green; font-size:22px;"></i> <?php } else if ($studentV['status']=='approved_with_payment' || $studentV['status'] == 'approved_without_payment' ) { ?>&nbsp;<i data-toggle="tooltip" data-original-title="Pending Placement" data-placement="bottom" class="font16 fa fa-circle" style="color:#ff9800;"></i><?php } ?></td>

											<td>

												<div class="btn-group dropdown table-actions">

													<button class="btn btn-sm btn-midnightblue dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="true">

														<i class="colorBlue material-icons">more_horiz</i>

														<div class="ripple-container"></div>

													</button>

													<ul class="dropdown-menu" role="menu">

														<li><a href="<?php echo site_url().'sha/application/',$studentV['id'],'/#tab-8-3';?>"><i class="font16 material-icons">edit</i>&nbsp;&nbsp;Edit</a></li>

														<li><a href="javascript:;" data-booking="<?=$booking_exist?>"  class="shaDeleteApp" id="shaDeleteApp-<?php echo $studentV['id'];?>"><i class="font16 material-icons">delete</i>&nbsp;&nbsp;Delete</a></li>

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

				<img src="<?echo loadingImagePath();?>" id="shaChangeStatusProcess" style="margin-right:16px;display:none;">

			</div>

		</div><!-- /.modal-content -->

	</div><!-- /.modal-dialog -->

</div><!-- /.modal -->



<form id="tourFiltersFormHidden">

<?php

if(isset($_GET['clientCategory']) && $_GET['clientCategory']!='')

	$clientCategory=$_GET['clientCategory'];

else

	$clientCategory='';

?>

	<input type="hidden" name="clientCategory" value="<?=$clientCategory?>" />

	<input type="hidden" name="filterOption" value="placed_students" />

</form>

