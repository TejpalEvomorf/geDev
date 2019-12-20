<div class="panel panel-profile panel panel-bluegraylight">
    <div class="panel-heading">
        <h2>Family warnings</h2>
    </div>
    <div class="panel-body">
            <button class="btn-raised btn-primary btn btn-sm" style="margin-bottom: 40px;" onclick="hfaWarningSendPopContent(<?=$formOne['id']?>,'add');">Send warning</button> 
        <div id="warningsListDiv" style="padding-left:20px;">
            <?php $this->load->view('system/hfa/warningsList');?>
        </div>
    </div>
</div>
        
        
        
<!--Add new incident Start-->
<div class="modal fade" id="model_hfaWarningSend" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" id="model_hfaWarningSend_content">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h2 class="modal-title"><span id="model_hfaWarningSend_titlePart">Add new</span> warning</h2>
                </div>
                
                <div class="modal-body">
                    <form id="hfaWarningSend_form"></form>
                        
                            <div class="m-n form-group" style="padding:0; display:none" id="editHfaWarningSendDocDiv">
                                  <label class="control-label">Upload Document</label>
                                  <form action="<?=site_url()?>hfa/hfaWarningDoc_upload" id="hfa-warning-doc-formEdit" class="dropzone">
                                      <input type="hidden" name="hfaWarning_idSecond" id="bookingHfaWarningSendEdit_id" value="" />
                                	  <input type="hidden" name="hfaWarning_hfaId" value="<?=$formOne['id']?>" />
                                  </form>    
                            </div> 
                            
                            <div id="editHfaWarningSendDocDivDocsParent" style="direction:none;">
	                            <div class="panel panel-profile panel-bluegraylight" id="editHfaWarningSendDocDivDocs"  style="margin-top:32px; margin-bottom:0;"></div>
                 			</div>
                              
                </div>
                <div class="modal-footer" id="hfaWarningSend_submitDiv" >
                    <button type="button" class="btn btn-success btn-raised" id="hfaWarningSend_submit">Next</button>
                    <img src="<?=loadingImagePath()?>" id="hfaWarningSend_process" style="margin-right:16px;display:none;">
                </div>                 
                        
                <div class="modal-footer" id="editHfaWarningSubmitDiv" style="display:none;">
                    <button type="button" class="btn btn-success btn-raised" id="editHfaWarningSend" >Submit</button>
                    <img src="<?=loadingImagePath()?>" id="edithfaWarningSendProcess" style="margin-right:16px;display:none;">
                </div>
            </div><!-- /.modal-content -->
        </div>
        
        <div class="modal-dialog" id="model_hfaWarningSend_second" style="display:none;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h2 class="modal-title">Attach document to this warning</h2>
                        </div>
                    
                        <div class="modal-body">
                            <form action="<?=site_url()?>hfa/hfaWarningDoc_upload" id="warning-doc-form" class="dropzone">
                                <input type="hidden" name="hfaWarning_idSecond" id="hfaWarning_idSecond" value="" />
                                <input type="hidden" name="hfaWarning_hfaId" value="<?=$formOne['id']?>" />	
                            </form>
                            
                            <div id="hfaWarningDocDivParent" style="direction:none;">
	                            <div class="panel panel-profile panel-bluegraylight" id="hfaWarningDocDiv"  style="margin-top:32px; margin-bottom:0;"></div>
                 			</div>            
                            
                        </div>
                        <div class="modal-footer">
                        
                            <button style="float:left; background:#ebebeb;" type="button" class="btn btn-raised" id="editHfaWarningsBackSecond">Back</button>
                            <button type="button" class="btn btn-success btn-raised" id="editHfaWarningsSubmitSecond" data-dismiss="modal" aria-hidden="true">Done</button>
                        
                            <img src="<?=loadingImagePath()?>" id="editHfaWarningsProcessSecond" style="margin-right:16px;display:none;">
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->    
        
</div><!-- /.modal -->
<!--Add new incident end-->   



<script>
$(document).ready(function(){
	
	$('#editHfaWarningsBackSecond').click(function(){
				$('#model_hfaWarningSend_second').hide();
				$('#model_hfaWarningSend_content').slideDown();
			});
			
			
	Dropzone.options.warningDocForm = {
		maxFilesize: 5,
		acceptedFiles:'.pdf,.PDF,.docx,.xlsx,.jpeg,.jpg,.png,.JPG,.JPEG',
			init: function () {
			 	  this.on("success", function(file, responseText) {
					  if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0)
						   {
							  setTimeout(function(){
								  $('.dz-preview').remove();
								  },1500);
								  var returnedData = JSON.parse(responseText);
								  $('#warningsListDiv').html(returnedData.warnings);
								  notiPop('success','Document uploaded successfully','')
								  
								  $('#hfaWarningDocDiv').html(returnedData.warning_documents);
								 if($('#hfaWarningDocDiv div.panel-body > p').length>0)
										$('#hfaWarningDocDivParent').show();
							}
				});
		  }
	}
			
	Dropzone.options.hfaWarningDocFormEdit = {
		maxFilesize: 5,
		acceptedFiles:'.pdf,.PDF,.docx,.xlsx,.jpeg,.jpg,.png,.JPG,.JPEG',
			init: function () {
			 	  this.on("success", function(file, responseText) {
					  if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0)
						   {
							  setTimeout(function(){
								  $('.dz-preview').remove();
								  },1500);
								  var returnedData = JSON.parse(responseText);
								  $('#warningsListDiv').html(returnedData.warnings);
								  notiPop('success','Document uploaded successfully','')
								 $('#editHfaWarningSendDocDivDocs').html(returnedData.warning_documents);
								 if($('#editHfaWarningSendDocDivDocs div.panel-body > p').length>0)
										$('#editHfaWarningSendDocDivDocsParent').show();
							}
				});
		  }
	}			
			
});
</script>