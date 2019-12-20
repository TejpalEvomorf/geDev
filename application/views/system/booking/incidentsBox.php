<?php if(!empty($incidents) || $this->router->fetch_class()=='booking'){?>   
        <div class="panel panel-profile panel panel-bluegraylight">
            <div class="panel-heading">
                <h2>Incident report</h2>
            </div>
            <div class="panel-body">
            	<?php if($this->router->fetch_class()=='booking'){ ?>
	            	<button class="btn-raised btn-primary btn btn-sm" style="margin-bottom: 40px;" onclick="bookingIncidentPopContent(<?=$booking['id']?>,'add');">Add new incident</button> 
                <?php } ?>
                <div id="incidents" style="padding-left:20px;">
                    <?php $this->load->view('system/booking/incidents');?>
                </div>
            </div>
        </div> 
        
        
        
        <!--Add new incident Start-->
        <div class="modal fade" id="model_bookingIncident" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" id="model_bookingIncident_content">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h2 class="modal-title"><span id="model_bookingIncident_titlePart">Add new</span> incident report</h2>
                        </div>
                        
                        <div class="modal-body">
                            <form id="bookIncident_form"></form>
                        
                            <div class="m-n form-group" style="padding:0; display:none" id="editIncidentDocDiv">
                                  <label class="control-label">Upload Document</label>
                                  <form action="<?=site_url()?>booking/bookingIncidentDoc_upload" id="incident-doc-formEdit" class="dropzone">
                                      <input type="hidden" name="bookingIncident_idSecond" id="bookingIncidentEdit_id" value="" />
                                	  <input type="hidden" name="bookingIncident_bookingId" value="<?php if($this->router->fetch_class()=='booking'){echo $booking['id'];}else{if(!empty($incidents)){echo $incidents[0]['booking_id'];}}?>" />
                                  </form>    
                            </div> 
                            
                            <div id="editIncidentDocDivDocsParent" style="direction:none;">
	                            <div class="panel panel-profile panel-bluegraylight" id="editIncidentDocDivDocs"  style="margin-top:32px; margin-bottom:0;"></div>
                 			</div>
                           
                        </div>
                        <div class="modal-footer" id="bookIncident_submitDiv" >
                            <button type="button" class="btn btn-success btn-raised" id="bookIncident_submit">Next</button>
                            <img src="<?=loadingImagePath()?>" id="bookIncident_process" style="margin-right:16px;display:none;">
                        </div>                       
                        
                        <div class="modal-footer" id="editIncidentSubmitDiv" style="display:none;">
                            <button type="button" class="btn btn-success btn-raised" id="editIncidentSubmit" >Submit</button>
                            <img src="<?=loadingImagePath()?>" id="editIncidentSubmitProcess" style="margin-right:16px;display:none;">
                        </div>
                                                
                    </div><!-- /.modal-content -->
                </div>
                
                
                <div class="modal-dialog" id="model_bookingIncident_second" style="display:none;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h2 class="modal-title">Attach document to this incident</h2>
                        </div>
                    
                        <div class="modal-body">
                            <form action="<?=site_url()?>booking/bookingIncidentDoc_upload" id="incident-doc-form" class="dropzone">
                                <input type="hidden" name="bookingIncident_idSecond" id="bookingIncident_idSecond" value="" />
                                <input type="hidden" name="bookingIncident_bookingId" value="<?php if($this->router->fetch_class()=='booking'){echo $booking['id'];}?>" />	
                            </form>
                            
                            <div id="incidentDocDivDocsParent" style="direction:none;">
	                            <div class="panel panel-profile panel-bluegraylight" id="incidentDocDivDocs"  style="margin-top:32px; margin-bottom:0;"></div>
                 			</div>            
                            
                        </div>
                        <div class="modal-footer">
                        
                            <button style="float:left; background:#ebebeb;" type="button" class="btn btn-raised" id="editIncidentBackSecond">Back</button>
                            <button type="button" class="btn btn-success btn-raised" id="editIncidentSubmitSecond" data-dismiss="modal" aria-hidden="true">Done</button>
                        
                            <!--<button type="button" class="btn btn-success btn-raised" id="editnotSubmitSecond">Done</button>-->
                            <img src="<?=loadingImagePath()?>" id="editBookingIncidentProcessSecond" style="margin-right:16px;display:none;">
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->     
                
        </div><!-- /.modal -->
        <!--Add new incident end--> 
        
        <!--Add new follow up Start-->
        <div class="modal fade" id="model_bookingIncidentFollowUp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h2 class="modal-title">Add new follow up</h2>
                        </div>
                        
                        <div class="modal-body">
                            <form id="bookIncidentFollowUp_form"></form>   
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success btn-raised" id="bookIncidentFollowUp_submit">Submit</button>
                            <img src="<?=loadingImagePath()?>" id="bookIncidentFollowUp_process" style="margin-right:16px;display:none;">
                        </div>
                    </div><!-- /.modal-content -->
                </div>
        </div><!-- /.modal -->
        <!--Add new follow up end-->
        
        <!--Add new follow up Start-->
        <div class="modal fade" id="model_bookingIncidentViewFollowUp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h2 class="modal-title">View follow ups</h2>
                        </div>
                        
                        <div class="modal-body">
                            <div id="bookIncidentViewFollowUp"></div>   
                        </div>
                    </div><!-- /.modal-content -->
                </div>
        </div><!-- /.modal -->
        <!--Add new follow up end-->   


<script>
$(document).ready(function(){
	
	$('#editIncidentBackSecond').click(function(){
				$('#model_bookingIncident_second').hide();
				$('#model_bookingIncident_content').slideDown();
			});
			
			
	Dropzone.options.incidentDocForm = {
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
								  $('#incidents').html(returnedData.incidents);
								  notiPop('success','Document uploaded successfully','')
								  
								  $('#incidentDocDivDocs').html(returnedData.incident_documents);
								 if($('#incidentDocDivDocs div.panel-body > p').length>0)
										$('#incidentDocDivDocsParent').show();
							}
				});
		  }
	}
			
	Dropzone.options.incidentDocFormEdit = {
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
								  $('#incidents').html(returnedData.incidents);
								  notiPop('success','Document uploaded successfully','')
								 $('#editIncidentDocDivDocs').html(returnedData.incident_documents);
								 if($('#editIncidentDocDivDocs div.panel-body > p').length>0)
										$('#editIncidentDocDivDocsParent').show();
							}
				});
		  }
	}			
			
});
</script>
         
<?php } ?>