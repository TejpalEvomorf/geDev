<!--change status pop up #STATRS-->
            <div class="modal fade" id="model_ChangeStatusBooking" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h2 class="modal-title" id="bookingChangeStatus_statusTitle">Change booking status</h2>
                                <h2 class="modal-title" id="bookingChangeStatus_arrivalTitle" style="display:none;">Add arrival check</h2>
                            </div>
                            
                            <div class="modal-body">
                                <form id="bookingChangeStatus_form"></form>                
                            </div>
                            <div class="modal-footer">
	                            <button class="btn btn-default" id="bookingChangeStatusBack" style="display:none;">Back</button>
                                <button type="button" class="btn btn-success btn-raised" id="bookingChangeStatusSubmit">Change</button>
                                <button class="btn btn-primary" id="bookingChangeStatusNext" style="display:none;">Next</button>
                                <img src="<?=loadingImagePath()?>" id="bookingChangeStatusProcess" style="margin-right:16px;display:none;">
                                <button data-bb-handler="danger" type="button" class="ml5 btn btn-default" data-dismiss="modal" style="display:none;" id="bookingChangeStatusClose">Close</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            
            <!--</div>-->
<!--change status pop up #ENDS-->