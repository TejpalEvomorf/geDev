<div class="modal fade" id="profilePicModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            		<h2 class="modal-title">Select Profile Photo</h2>
            </div>
            <div class="modal-body">
                <form id="profilePicModelForm">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="selectProfilePicCancel">Cancel</button>
                <button type="button" class="btn btn-success btn-raised" id="selectProfilePicSubmit">Done</button>
                <img src="<?=loadingImagePath()?>" id="selectProfilePicSubmitProcess" style="margin-right:16px;display:none;">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
