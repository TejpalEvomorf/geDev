<!-- /.PL Insurance status modal -->
            <div class="modal fade" id="mode_reviewPLIstatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h2 class="modal-title"></h2>
							</div>
                            
                            <div class="modal-body">
                            <div class="table-responsive panel panel-default" data-widget='{"draggable": "false"}'>
                                <div class="about-area">
                                    <div class="media-body panel-heading">
										<h2> Public Liability insurance </h2>
                                        <div class="pldescription"></div>
									</div>
                                  <div class="panel-body">
                                   <form id="model_plinsuranceStatus_form" data-parsley-validate></form>
                                  </div>
                              </div>
                              </div>
							</div>
                            
							<div class="modal-footer">
                            	<button data-bb-handler="danger" type="button" class="ml5 btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-success btn-raised" id="approveHfaPlIns" onclick="approveHfaPlIns('<?=static_url()?>');">Approve PL Insurance</button> 
                                <button type="button" class="btn btn-danger" id="unapproveHfaPlIns" onclick="unapproveHfaPlIns('<?=static_url()?>');">un-Approve PL Insurance</button> 
                                <!--<img src="<?=loadingImagePath()?>" id="approveHfaPlInsProcess" style="margin-right:16px;display:none;">-->
                                
                            </div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->

			</div>
            
            
            <!-- /.WWCC status modal -->
            <div class="modal fade" id="mode_reviewWWCCstatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h2 class="modal-title"></h2>
                                <ul class="fa-ul mt-md">
                                    <li class="width-fifty-left"><i class="fa fa-li fa-circle font18 text-danger"></i><span class="pt-xs block colorLightgrey">Doesn't have WWCC</span></li>
                                    <li class="width-fifty-right"><i class="fa fa-li fa-circle font18 text-warning"></i><span class="pt-xs block colorLightgrey">Has WWCC but file not uploaded</span></li>
                                    <li class="width-fifty-left"><i class="fa fa-li fa-circle font18 text-success"></i><span class="pt-xs block colorLightgrey">WWCC file uploaded</span></li>
                                    <li class="width-fifty-right"><i class="fa fa-li fa-circle font18 text-default"></i><span class="pt-xs block colorLightgrey">WWCC expired</span></li>
                                    <li class="width-fifty-left"><i class="fa fa-li fa-circle font18 text-info"></i><span class="pt-xs block colorLightgrey">Member turned 18</span></li>
                                    <li class="width-fifty-right"><i class="fa fa-li fa-circle font18 text-muted"></i><span class="pt-xs block colorLightgrey">Not applicable, age under 18</span></li>
                                </ul>
							</div>
                            
                            <div class="modal-body" style="clear:both;">
                            <div class="table-responsive panel panel-default" data-widget='{"draggable": "false"}'>
                                <div class="about-area">
                                  <div class="panel-body">
                                   <form id="model_wwStatus_form" data-parsley-validate></form>
                                  </div>
                              </div>
                              </div>
							</div>
                            
							<div class="modal-footer">
                            	<button data-bb-handler="danger" type="button" class="ml5 btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-success btn-raised" id="approveHfawwIns" onclick="approveHfawwIns('<?=static_url()?>');">Approve WWCC</button> 
                                <button type="button" class="btn btn-danger" id="unapproveHfawwIns" onclick="unapproveHfawwIns('<?=static_url()?>');">un-Approve WWCC</button> 
                                <!--<img src="<?=loadingImagePath()?>" id="approveHfaPlInsProcess" style="margin-right:16px;display:none;">-->
                                
                            </div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->

			</div>
