<?php
$warnings=tourWarningsLabel();
$nationList=nationList();
?>
<div>
<div class="warningRowParent">
  <div class="warningRow">
            <div class="warningCol warningColName" style="color:#424242; font-weight:bold;">Application</div>
            <div class="warningCol" style="color:#424242; font-weight:bold;">Warning</div>
            <div class="warningCol" style="color:#424242; font-weight:bold;">Value</div>
</div>
</div>
<?php foreach($students as $student){
	?>
    <div class="warningRowParent" id="warningRowParent-<?=$student['id']?>">
          <div class="warningRow">
            <div class="warningCol warningColName"><a href="<?=site_url()?>sha/application/<?=$student['sha_one_id']?>" target="_blank"><?=ucfirst($student['fname']),' ',ucfirst($student['lname'])?></a></div>
            <div class="warningCol"><?php  if (array_key_exists($student['column_name'],$warnings)) { if($student['column_name']!='guardianship_date'){echo 'Incorrect ';} echo $warnings[$student['column_name']]; if($student['column_name']=='guardianship_date'){echo ' not defined';}} else { echo 'Incorrect '.$student['column_name']; }; ?></div>
            <div class="warningCol"><?=$student['column_value']; ?></div>
            <div class="warningCol warningEdit" style="width:50px;"><i class="material-icons font14" style="cursor:pointer;">edit</i></div>
        </div>
        <div class="warningRow warningRowEditor">
        <form id="warningForm-<?=$student['id']?>">
                <div class="width-full">
                <?php if($student['column_name']!='guardianship_date'){?>
                    <label for="bname" class="control-label">Enter new value</label>
                    <?php if($student['column_name']=='nation'){?>
                        <select class="form-control" name="newValue" required>
                            <option value="">Select one</option>
                            <?php foreach($nationList as $nLK=>$nLV){?>
                            <option value="<?=$nLK?>"><?=$nLV?></option>
                            <?php } ?>
                        </select>
                    <?php }else{?>
                        <input type="text" class="form-control <?php if(in_array($student['column_name'],array('dob','booking_from','booking_to'))){?>warningRowEditorEmailField<?php } ?>" name="newValue" value="<?php if(!in_array($student['column_name'],array('dob','booking_from','booking_to'))){echo $student['column_value']; } ?>" placeholder="Enter new value"  <?php if($student['column_name']=='email'){?>data-parsley-type="email"<?php }?> required>
                    <?php }}else{ 
					if($student['dob']!='0000-00-00')
					{
						$guardianship_endDate=date('d/m/Y',strtotime($student['dob'].' + 18 years -1 day'));
						if($student['guardianship_endDate']!='0000-00-00')
							$guardianship_endDate=date('d/m/Y',strtotime($student['guardianship_endDate']));
					}
					else	
						$guardianship_endDate='';
					?>
                    
                    <div class="form-group col-xs-6 resolve-warning-parent" style="padding-left:0;">
                    	<label for="" class="control-label">Caregiving start date</label>
                        <input type="text" class="form-control warningRowEditorEmailField" name="guardianship_startDate" value="" placeholder="Enter value" required>
                        <p class="text-default resolve-hint">Caregiving duration: <span class="resolve-hint-gDuration">Not set</span></p>
                    </div>
                    <div class="form-group col-xs-6 resolve-warning-parent" style="padding-right:0;">
                    	<label for="" class="control-label">Caregiving end date</label>
                        <input type="text" class="form-control warningRowEditorEmailField" name="guardianship_endDate" value="<?=$guardianship_endDate?>" placeholder="Enter value"  required>
                        <?php if($student['dob']!='0000-00-00'){?><p class="text-default resolve-hint">Student turning 18 on <?=date('d M Y',strtotime($student['dob'].' + 18 years'))?></p><?php }?>
                    </div>
                    <input type="hidden" name="id" value="<?=$student['id']?>" />
                    <?php } ?>    
                </div>
                <input type="hidden" name="warning_id" value="<?=$student['id']?>" />
                <input type="hidden" name="type" value="<?=$type?>" />
                <input type="hidden" name="ids" value="<?=$ids?>" />
                
                <img src="<?=static_url()?>system/img/loader-blue.gif" class="warningEditorSubmitProcess" style="display:none;" />
                <button type="button" class="btn btn-raised btn-sm warningEditorSubmitBtn" style="margin-right:3px; background-color:#8bc34a;"><i class="fa fa-check" style="color:#ffffff;"></i></button>
                <button type="button" class="btn btn-raised btn-sm warningEditorCloseBtn" style="margin-left:3px;"><i class="colorLightgrey fa fa-times"></i></button>
       </form> 
        </div>
    </div>
 <?php } ?>   
</div>
<script type="text/javascript">
$(document).ready(function(){
	var thisPage='<?=$type?>';
	
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
							url:'<?=site_url()?>'+'tour/resolveWarning',
							type:'POST',
							data:warningFormData,
							dataType:'JSON',
							success:function(data){
												if(data.hasOwnProperty('logout'))
													redirectToLogin();
												else
												{
													if(data.result=='done')
														{
															$('.warningRowEditor').slideUp();
															$('#lbl_warning_count').text(data.count);
															if(data.count>0)
																$('#tour-'+<?=$students[0]['study_tour_id']?>+' td > a.anchor_count_warnings').attr('data-original-title',data.count+" Warning(s)");
															else
															{
																$('#tour-'+<?=$students[0]['study_tour_id']?>+' td > a.anchor_count_warnings').remove();	
																$('.warnings_toggle').remove();
																
																if(thisPage=='all')
																{
																	var lastChar = window.location.href.substr(-1); // Selects the last character
																	window.location=window.location.href.replace(/\/$/, "")+"/#warningsResolved";
																	
																	if (lastChar == '/') {         // If the last character is not a slash
																			window.location.reload();
																		}
																}
															}
															
															$('#'+warningRowParent).remove();
															notiPop('success','1 warning resolved.',"");
														}
												}
							}
						});
				}
		});
		
		$('.warningRowEditorEmailField').datepicker({
							orientation: "top",
							format:'dd/mm/yyyy',
							autoclose:true,
						});

		$('input[name=guardianship_startDate], input[name=guardianship_endDate]').change(function(){
			var formId=$(this).parents('form').attr('id');
			
			var guardianship_startDate=$('#'+formId+' input[name=guardianship_startDate]').val().trim();
			var guardianship_endDate=$('#'+formId+' input[name=guardianship_endDate]').val().trim();
			var hintDuration=$('#'+formId+' .resolve-hint-gDuration');
			
			if(guardianship_startDate=='' || guardianship_endDate=='')
				hintDuration.text('Not set');
			else
				{
					hintDuration.text('Calculating...');
					$.ajax({
						url:'<?=site_url()?>/sha/gShipDuratoinFromDates',
						type:'POST',
						data:{from:guardianship_startDate,to:guardianship_endDate},
						success:function(data)
							{
								hintDuration.text(data);
							}
					});
				}
		});
		
});


</script>