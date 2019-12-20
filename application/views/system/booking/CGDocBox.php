<?php //if(!empty($feedbacks)){?>   
        <div class="panel panel-profile panel panel-bluegraylight" id="feedbacksBox">
            <div class="panel-heading">
                <h2>Caregiving Documents</h2>
            </div>
            <div class="panel-body col-xs-12" id="cgDocSentModalBody">
                <?php $this->load->view('system/booking/CGDocBoxBtns');?>
            </div>
        </div> 
<?php //} ?>

<?php
$employeeList=employeeList();
$loggedInUser=loggedInUser();
?>

<!--Add new incident Start-->
<div class="modal fade" id="model_bookingCGDocSent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h2 class="modal-title">Confirm</h2>
                </div>
                
                <div class="modal-body">
                    <form id="bookCGDocSent_form">
                    
                    	<div class="pl-n m-n form-group col-xs-12">
                        <p>Do you confirm that you have sent the caregiving service documents?</p>
                          <label class="control-label">Sent by</label>
                              <select class="form-control" id="bookCGDocSent_emp" name="bookCGDocSent_emp" required <?php if($loggedInUser['user_type']=='2'){echo "disabled";}?>>
                              <option value="" >Select employee</option>
                                  <?php
                                  foreach($employeeList as $emp)
								  {
								  	?>
                                  <option value="<?=$emp['id']?>" <?php if($loggedInUser['user_type']=='2' && $loggedInUser['id']==$emp['id']){echo 'selected';}?>><?=$emp['fname'].' '.$emp['lname']?></option>
                                  <?
								  }
								  ?>
                               </select>
                      </div>
                      <?php if($loggedInUser['user_type']=='2'){?>
                      <input type="hidden" name="bookCGDocSent_emp" value="<?=$loggedInUser['id']?>">
					  <?php } ?>
                      <input type="hidden" name="bookCGDocSent_bookingId" value="<?=$booking['id']?>">
                    </form>   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-raised" id="bookCGDocSent_submit">Confirm</button>
                    <img src="<?=loadingImagePath()?>" id="bookCGDocSent_process" style="margin-right:16px;display:none;">
                </div>
            </div><!-- /.modal-content -->
        </div>
</div><!-- /.modal -->
<!--Add new incident end--> 

<!--Add new incident Start-->
<div class="modal fade" id="model_bookingCGDocRec" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h2 class="modal-title">Upload caregiving documents</h2>
                    <p>Please upload all the caregiving documents before marking it as recieved.</p>
                </div>
                
                <div class="modal-body">
                <form action="<?=site_url()?>booking/bookingCGDocUpload" id="book-CG-Doc-Rec-form" class="dropzone">
                  <input type="hidden" name="bookCGDocRec_bookingId" value="<?=$booking['id']?>">
                  
                </form>
                <div id="CGDocBoxTempDocs"></div>
                </div>
                <div class="modal-footer">
	                <p id="bookingCGDocTempHiddenError" style="display:none;float: left;margin-left: 20px;color: #e51c23;">Please upload caregiving documents first</p>
                    <button type="button" class="btn btn-success btn-raised" id="bookCGDocRec_submit">Confirm</button>
                    <img src="<?=loadingImagePath()?>" id="bookCGDocRec_process" style="margin-right:16px;display:none;">
                </div>
            </div><!-- /.modal-content -->
        </div>
</div><!-- /.modal -->
<!--Add new incident end--> 

<script>
$(document).ready(function(){
	
	$('#bookCGDocSent_submit').click(function(){
		
		$('#bookCGDocSent_form').parsley().validate();
		if($('#bookCGDocSent_form').parsley().isValid())
		{
			$('#bookCGDocSent_submit').hide();
			$('#bookCGDocSent_process').show();
			var formdata=$('#bookCGDocSent_form').serialize();
			
			$.ajax({
					url:site_url+'booking/CGDocSent_submit',
					type:'POST',
					data:formdata,
					success:function(data)
						{
							if(data=='LO')
						  		redirectToLogin();
							else
							{
								$('#bookCGDocSent_form')[0].reset();
								$('#model_bookingCGDocSent').modal('toggle');
								$('#bookCGDocSent_submit').show();
								$('#bookCGDocSent_process').hide();
								notiPop('success','Caregiving service documents mark as sent successfully',"");
								$('#cgDocSentModalBody').html(data);
							}
						}
			});
		}
		
	});
	
	$('#bookCGDocRec_submit').click(function(){
		
		
		if($('input.bookingCGDocTempHidden').length==0)
			$('#bookingCGDocTempHiddenError').show();
		else
		{
			$('#bookingCGDocTempHiddenError').hide();
			$('#bookCGDocRec_submit').hide();
			$('#bookCGDocRec_process').show();
			var formdata=$('#book-CG-Doc-Rec-form').serialize();
			
			$.ajax({
					url:site_url+'booking/CGDocRec_submit',
					type:'POST',
					data:formdata,
					success:function(data)
						{
							if(data=='LO')
						  		redirectToLogin();
							else
							{
								$('#book-CG-Doc-Rec-form')[0].reset();
								$('#model_bookingCGDocRec').modal('toggle');
								$('#bookCGDocRec_submit').show();
								$('#bookCGDocRec_process').hide();
								notiPop('success','Caregiving service documents received successfully',"");
								$('#cgDocSentModalBody').html(data);
							}
						}
			});
		}
		
	});
	
			Dropzone.options.bookCGDocRecForm = {
		maxFilesize: 5,
		acceptedFiles:'.pdf,.PDF,.docx,.xlsx,.jpeg,.jpg,.png,.JPG,.JPEG',
			init: function () {
			 	  this.on("success", function(file, responseText) {
					  $('#bookingCGDocTempHiddenError').hide();
					  if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0)
						   {
							  setTimeout(function(){
								  $('.dz-preview').remove();
								  },1500);
								  
						 		  $('#book-CG-Doc-Rec-form').append('<input type="hidden" class="bookingCGDocTempHidden" name="bookCGDocRec_images[]" value="'+responseText+'">');
								  notiPop('success','Document uploaded successfully','')
								 
								 var docsTemp = [];  
								 $('input.bookingCGDocTempHidden').each(function(){
									docsTemp.push($(this).val());
								});
								
								cgDocListTempHtml(docsTemp);
							}
				});
		  }
	}
	
});

function cgDocListTempHtml(docsTemp)
{
	  $.ajax({
			  url:site_url+'booking/cgDocListTempHtml/',
			  type:'POST',
			  data:{docs:docsTemp},
			  success:function(data){
				  $('#CGDocBoxTempDocs').html(data);
			  }
		   });
}

function bookCGDocSentUnsend(bid)
{
	bootbox.dialog({
				message: "Are you sure you wish to mark it as unsent?",
				title: "Mark as unsent",
				buttons: {
					  danger: {
						label: "Confirm",
						className: "btn-danger",
						callback: function() {

								$.ajax({
					  url:site_url+'booking/CGDocSent_unsend',
					  type:'post',
					  data:{booking_id:bid},
					  success:function(data){
									if(data=='LO')
										redirectToLogin();
									else
									{
										 notiPop('success','Caregiving document mark as unset successfully',"");
										 $('#cgDocSentModalBody').html(data);
									}
							}
					  });
							}
						}
					}
				});
}

function deleteBookingCGDocTemp(doc)
{
		var docsTemp = [];  
	   $('input.bookingCGDocTempHidden').each(function(){
		  if($(this).val()==doc)
			  $(this).remove();
		  else
			  docsTemp.push($(this).val());
	  });
	   cgDocListTempHtml(docsTemp);
}

function deleteBookingCGDoc(docId,bookingId)
{
		bootbox.dialog({
				message: "Are you sure you wish to delete this document?",
				title: "Delete",
				buttons: {
					  danger: {
						label: "Delete",
						className: "btn-danger",
						callback: function() {
								$('#bookingCGDoc-'+docId).remove();
								$.ajax({
								  url:site_url+'booking/deleteBookingCGDoc',
								  type:'post',
								  data:{id:docId},
								  success:function(data){
												if(data=='LO')
													redirectToLogin();
												else
												{
													 notiPop('success','Document deleted successfully',"");
													  $.ajax({
														  url:site_url+'booking/cgDocListHtml/',
														  type:'POST',
														  data:{bookingId:bookingId},
														  success:function(data){
															  $('#CGDocBoxDocs').html(data);
														  }
													   });
												}
										}
					  });
							}
						}
					}
				});
}
</script>