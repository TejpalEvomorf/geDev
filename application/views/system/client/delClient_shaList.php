<?php
$clientsList=clientsList();//see($clientsList);
?>
<div>
<div class="warningRowParent">
  <div class="warningRow">
            <div class="warningCol warningColName" style="color:#424242; font-weight:bold; width:auto;">List of student applications</div>
            <input type="hidden" id="client_id_old" value="<?=$client_id?>" />
</div>
</div>
<?php foreach($students as $student){
	?>
    <div class="warningRowParent" id="warningRowParent-<?=$student['id']?>">
          <div class="warningRow">
            <div class="warningCol warningColName" style="width:auto;"><a href="<?=site_url()?>sha/application/<?=$student['id']?>" target="_blank"><?=ucfirst($student['fname']),' ',ucfirst($student['lname'])?></a></div>
            <div class="warningCol warningEdit" style="width:auto;"><i class="material-icons font14" style="cursor:pointer;">edit</i></div>
        </div>
        <div class="warningRow warningRowEditor">
        <form id="warningForm-<?=$student['id']?>" class="form-group" style="margin:0;">
                <div class="width-full">
                    <label for="client" class="control-label">Select client</label>
                        <select class="form-control" name="client" required>
                            <option value="">Select one</option>
                            	<?php foreach($clientsList as $client){
									if($client_id==$client['id'])
										continue;
								?>
                            	<option value="<?=$client['id']?>"><?=$client['bname']?></option>
                            <?php } ?>
                        </select>    
                </div>
                <input type="hidden" name="sha_id" value="<?=$student['id']?>">
                <img src="<?=static_url()?>system/img/loader-blue.gif" class="warningEditorSubmitProcess" style="display:none;" />
                <button type="button" class="btn btn-raised btn-sm warningEditorSubmitBtn" style="margin-right:3px;margin-top:20px;background-color:#8bc34a;"><i class="fa fa-check" style="color:#ffffff;"></i></button>
                <button type="button" class="btn btn-raised btn-sm warningEditorCloseBtn" style="margin-left:3px;margin-top:20px;"><i class="colorLightgrey fa fa-times"></i></button>
       </form> 
        </div>
    </div>
 <?php } ?>   
</div>
<script type="text/javascript">
$(document).ready(function(){
	
	
		  $('.warningCol').not('.warningColName').click(function(){
			  var parentDiv=$(this).parents('.warningRowParent');
			  $('.warningRowParent').not(parentDiv).find('.warningRowEditor').slideUp();
			  parentDiv.find('.warningRowEditor').slideToggle();
		  });
		  
		$('.warningEditorCloseBtn').click(function(){
			$('.warningRowEditor').slideUp();
		});
		
		$('.warningEditorSubmitBtn').click(function(){
			var warningFormId=$(this).parents('form').attr('id');
			var warningForm=$('#'+warningFormId);
			var valid=warningForm.parsley().validate();
			if(valid)
				{
					$(this).hide();//hide submit button
					warningForm.find('.warningEditorSubmitProcess').show();
					var formIdSplit=warningForm.attr('id').split('-');
					var warningRowParent='warningRowParent-'+formIdSplit[1];
					
					var warningFormData=warningForm.serialize();
					
					$.ajax({
							url:'<?=site_url()?>'+'client/delClient_assignClient',
							type:'POST',
							data:warningFormData,
							success:function(data){
												if(data=='LO')
													redirectToLogin();
												else
												{
													if(data=='done')
														{
															$('.warningRowEditor').slideUp();
															$('#'+warningRowParent).remove();
															notiPop('success','Student client updated successfully',"");
															
															if($('.warningRowParent').length==1)
															{
																$('#model_deleteClient').modal('toggle');
																$('#clientDelete-'+$('#client_id_old').val()).trigger('click');
															}
														}
												}
							}
						});
				}
		});
		
});


</script>