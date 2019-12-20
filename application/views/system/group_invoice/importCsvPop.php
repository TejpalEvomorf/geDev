<div class="modal fade" id="model_ImportGroupInvCsv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h2 class="modal-title">Import CSV</h2>
      </div>
      <div class="modal-body">

        <form action="<?=site_url()?>group_invoice/invoice_upload" id="group-invoice-upload" class="dropzone">
            <input type="hidden" name="clientId" id="clientId" value="<?=$client['id']?>" />
        </form>
              
              <div id="paymentImportSummary" style="display:none;">
              
              <!--<div class="col-sm-6">
						<div class="panel-body">
							<div class="panel panel-primary" data-widget='{"draggable": "false"}'>
									<div class="col-md-12 col-sm-6 col-xs-12">
											<h5><b>Upload summary</b><span class=""></span></h5>
									</div>
							</div>
						</div>
				</div>-->
                
              <div class="col-sm-12" style="padding:0;">
                  <div class="panel-body">
	                  <span>Please find the import summary below</span>
                      <div style="margin-top:10px;" class="panel panel-primary" data-widget='{"draggable": "false"}'>
                              
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                      <div class="info-tile info-tile-alt tile-lime info-title-three">
                                              <div class="info">
                                                      <div class="tile-heading"><span>Items ignored</span></div>
                                                      <div class="tile-body "><span id="paymentImportSummary-ignored_noBooking"></span></div>
                                                      <span>Because related bookings not found in system</span>
                                              </div>
                                      </div>
                              </div>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                      <div class="info-tile info-tile-alt tile-lime info-title-three">
                                              <div class="info" style="background:#ff9800;">
                                                      <div class="tile-heading"><span>Items ignored</span></div>
                                                      <div class="tile-body "><span id="paymentImportSummary-ignored_0nights"></span></div>
                                                      <span>Because data include 0 nights</span>
                                              </div>
                                      </div>
                              </div>
                              
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                      <div class="info-tile info-tile-alt tile-lime info-title-two">
                                              <div class="info" style="background:#fbc02d;">
                                                      <div class="tile-heading"><span>Items ignored</span></div>
                                                      <div class="tile-body "><span id="paymentImportSummary-ignored_missing"></span></div>
                                                      <span>Because multiple bookngs found in system/Student id missing in system</span>
                                              </div>
                                      </div>
                              </div>
                              
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                      <div class="info-tile info-tile-alt tile-lime info-title-two">
                                              <div class="info">
                                                      <div class="tile-heading"><span>Items imported</span></div>
                                                      <div class="tile-body "><span id="paymentImportSummary-imported"></span></div>
                                                      <span>Excluding items with 0 nights</span>
                                              </div>
                                      </div>
                              </div>
                              
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                      <div class="info-tile info-tile-alt tile-lime info-title-one">
                                              <div class="info">
                                                      <div class="tile-heading"><span>Items in file</span></div>
                                                      <div class="tile-body "><span id="paymentImportSummary-total"></span></div>
                                                      <span>This is total number of items in file</span>
                                              </div>
                                      </div>
                              </div>
                              
                      </div>
                  </div>
          </div>
          </div>
        
      </div>
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-success btn-raised" id="shaChangeStatusSubmit">Save</button>
        <img src="<?=loadingImagePath()?>" id="shaChangeStatusProcess" style="margin-right:16px;display:none;">
        <button data-bb-handler="danger" type="button" class="ml5 btn btn-default" data-dismiss="modal" style="display:none;" id="shaChangeStatusClose">Close</button>-->
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
</div>


<script type="text/javascript">
$(document).ready(function(){

	Dropzone.options.groupInvoiceUpload = {
		maxFilesize: 5,
		acceptedFiles:'.xls',
			init: function () {
			 	  this.on("success", function(file, responseText) {
					  if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0)
						   {
							   notiPop('success','Document uploaded successfully','')
							   
							   setTimeout(function(){
								  $('.dz-preview').remove();
								  $('#group-invoice-upload').removeClass('dz-started');
								  $('#group-invoice-upload').hide();
								  
								  var responseTextSplit=responseText.split('-');
								  $('#paymentImportSummary-total').text(responseTextSplit[0]);
								  $('#paymentImportSummary-imported').text(responseTextSplit[1]);
								  $('#paymentImportSummary-ignored_noBooking').text(responseTextSplit[2]);
								  $('#paymentImportSummary-ignored_0nights').text(responseTextSplit[3]);
								  $('#paymentImportSummary-ignored_missing').text(responseTextSplit[4]);
								  $('#paymentImportSummary').show();
								  
								  },1500);
							}
				});
		  }
	};
	
	
	$('#model_ImportGroupInvCsv').on('hidden.bs.modal', function () {
    	window.location.reload();
})
	

});

function addInvoiceIdToImportFrom(id)
{
	var html='<input type="hidden" name="invoiceId" value="'+id+'">';
	$('#group-invoice-upload').append(html);
}
</script>