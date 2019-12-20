<!--Add new incident Start-->
<div class="modal fade" id="model_bookingCheckup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h2 class="modal-title"><span id="model_bookingCheckup_titlePart">Add new</span> check</h2>
                </div>
                
                <div class="modal-body">
                    <form id="bookCheckup_form"></form>   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-raised" id="bookCheckup_submit">Submit</button>
                    <img src="<?=loadingImagePath()?>" id="bookCheckup_process" style="margin-right:16px;display:none;">
                </div>
            </div><!-- /.modal-content -->
        </div>
</div><!-- /.modal -->
<!--Add new incident end--> 