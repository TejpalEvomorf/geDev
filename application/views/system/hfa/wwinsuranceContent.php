<style type="text/css">
.wwcc_accordion{
    visibility: visible !important;
    opacity: 1;
    display: block;
    transform: translateY(0px);	
}
</style>
<?php 
$nameTitleList=nameTitleList(); 
$datePickerExpirySettings=datePickerExpirySettings();
?>
<div class="col-md-12 custom-accordion">
      <div class="mb-n panel-group panel-default" id="familyMemberAccordionPop">
           <?php for($fm=0;$fm<$formThree['family_members'];$fm++){?>
           <?php $memberage=exact_age_from_dob($formThree['memberDetails'][$fm]['dob']); ?>
           <?php $wwccexpired=check_wwcc_expiry($formThree['memberDetails'][$fm]['wwcc_expiry']); ?>
               <div class="wwcc_accordion panel panel-default" id="memberDiv-<?=$fm?>">
                      <div class="media-body pb-md">
                          <a data-toggle="collapse" data-parent="#familyMemberAccordionPop" href="#collapseFamilyMemberAccordionPop-<?=$fm+1?>">
                          <div class="panel-heading">
                          <h5 class="media-heading capitaltext colorBlue">
                          <?=$fm+1?>. <?php if($formThree['memberDetails'][$fm]['title']!=''){echo $nameTitleList[$formThree['memberDetails'][$fm]['title']]." ";}?><?=ucwords($formThree['memberDetails'][$fm]['fname'].' '.$formThree['memberDetails'][$fm]['lname'])?>, <?=$memberage?>
                          </h5>
                          <?php
						  if($memberage<18 ) {
						  	  $wwccColor='wwccCircleGrey btn-default';
						  }elseif($formThree['memberDetails'][$fm]['wwcc']=="0"){
							  $wwccColor='btn-danger';
						  }elseif($formThree['memberDetails'][$fm]['wwcc']=="1" && $formThree['memberDetails'][$fm]['wwcc_file']==""){
							  if($wwccexpired!="expired"){ $wwccColor='btn-warning'; } else { $wwccColor='btn-darkgrey'; } 
						  }elseif($formThree['memberDetails'][$fm]['wwcc']=="1" && $formThree['memberDetails'][$fm]['wwcc_file']!=""){
							  if($wwccexpired!="expired"){ $wwccColor='btn-success'; } else { $wwccColor='btn-darkgrey'; }
						  }elseif($memberage>17 && $formThree['memberDetails'][$fm]['wwcc']=='')
								$wwccColor='btn-info';  
						  ?>
                          <div class="wwccpopcircle btn <?=$wwccColor?> btn-fab"></div>                          
                          </div>
                          </a>
                      </div>
                      <div id="collapseFamilyMemberAccordionPop-<?=$fm+1?>" class="collapse">
                      
<div class="panel-body">
                            
                            
                            
<?php if($memberage >= 18 ){?>                         
 <form method="post" action="" class="hintsBelow labelsAbove" id="updateWWCCDetailsForm-<?=$fm?>">
                            
<div class="wwccWrapperHfa">

	<div class=" form-group full_width_field">
			<span class="hfa1_app_full">
			<label for="" class="control-label full_label">Do you have the "Working with Children" (WWCC) check completed? <span class="reqField">*</span></label>
				<select id="hfa_working_children-<?=$fm?>" name="wwcc" class="form-control full_input hfa_working_children errorOnBlur" required>
                <option value="">Select one</option>
                <option value="1" id="" class="" <?php if($formThree['memberDetails'][$fm]['wwcc']=='1'){echo 'selected';}?>>Yes</option>
                <option value="0" class=""  <?php if($formThree['memberDetails'][$fm]['wwcc']=='0'){echo 'selected';}?>>No</option>
                </select>
			</span>
    </div>
    
    <div <?php if($formThree['memberDetails'][$fm]['wwcc']!=1){echo 'style="display:none;"';}?> class="form-group  full_width_field left_margin" id="type_wwcc_clearance_<?=$fm?>" >
			<span class="hfa1_app_full">
			<label for="" class="control-label full_label hidden_label">Have you received clearance? <span class="reqField">*</span></label>
            <select id="hfa_type_wwcc_clearance-<?=$fm?>" name="wwcc_clear" class="form-control full_input_select hfa_type_wwcc_clearance errorOnBlur" <?php if($formThree['memberDetails'][$fm]['wwcc']==1){echo 'required';}?>>
            <option value="">Select one</option>
            <option value="1" class="" <?php if($formThree['memberDetails'][$fm]['wwcc_clearence']=='1'){echo 'selected';}?>>Yes</option>
            <option value="0" class=""  <?php if($formThree['memberDetails'][$fm]['wwcc_clearence']=='0'){echo 'selected';}?>>No</option>
            </select>
			</span>
   </div>

<div id="clearance_non_availability_<?=$fm?>" class=" full_width_field left_margin" <?php if($formThree['memberDetails'][$fm]['wwcc_clearence']!=0 || $formThree['memberDetails'][$fm]['wwcc_clearence']==''){echo 'style="display:none;"';}?>>
<div class="">
	<div  style="" class=" full_width_field left_margin">
            <div  class="form-group" >
			<span class="hfa1_app_full">
			<label class="control-label full_label hidden_label" for="hfa_type_wwcc_application_number">Provide application no. <?=$formThree['memberDetails'][$fm]['wwcc_clearence']?></label>
			<input type="text" class="form-control halfs_input" name="wwcc_appli_num" value="<?=$formThree['memberDetails'][$fm]['wwcc_application_no']?>" id="hfa_type_wwcc_application_number">
			</span>
            </div>
    </div>
</div>
</div>

<div id="clearance_availability_<?=$fm?>" class=" full_width_field left_margin" <?php if($formThree['memberDetails'][$fm]['wwcc_clearence']!=1){echo 'style="display:none;"';}?>>
<div class="">
	<div  style="" class=" full_width_field left_margin">
            <div  class="form-group width-fifty-left" >
			<span class="hfa1_app_halfs margin_10">
			<label class="control-label full_label hidden_label" for="hfa_type_wwcc_clearance_number">Clearance no.</label>
			<input type="text" class="form-control halfs_input" name="wwcc_clear_num" value="<?=$formThree['memberDetails'][$fm]['wwcc_clearence_no']?>" id="hfa_type_wwcc_clearance_number">
			</span>
            </div>
            
            <div  class="form-group width-fifty-right" >
            <span class="hfa1_app_halfs">
			<label class="control-label full_label hidden_label" for="">Expiry date</label>
			<input type="text" class="form-control halfs_input date-icon hfa_wwcc_expiry" name="wwcc_clear_expiry" value="<?php if($formThree['memberDetails'][$fm]['wwcc_expiry']!='0000-00-00'){echo date('d/m/Y',strtotime($formThree['memberDetails'][$fm]['wwcc_expiry']));}?>">
			</span>
            </div>
            
 </div>           
</div>
 
 <div class="wwcc-fifty-right-right wwinsuranceContentFileDiv" id="wwinsuranceContentFileDiv-<?=$fm?>">    
 
 <?php 
//print_r($formThree['memberDetails'][$fm]);

 //see($formThree['family_members']);
 $member['member']=$formThree['memberDetails'][$fm];
 $member['fm']=$fm;
 $this->load->view('system/hfa/wwinsuranceContentFileDiv',$member);?>       
</div>
</div>


</div>
 
 <div class="pl-button">
  <button type="button"  class="btn-raised btn-primary btn updateBtnWWCC" id="updateBtnWWCC-<?=$fm?>">Update</button>
  <img src="<?=loadingImagePath()?>" id="updateBtnProcessWWCC-<?=$fm?>" style="margin-right:16px;display:none;">
</div>
      
     <input type="hidden" name="member_id" value="<?=$formThree['memberDetails'][$fm]['id']?>" />
     <input type="hidden" name="hfa_id" value="<?=$formThree['memberDetails'][$fm]['application_id']?>" />
     <input type="hidden" name="fm" value="<?=$fm?>" />
 </form>
 <?php }else {echo "<p>WWCC doesn't apply to this person, as the age is under 18.</p>";}?>
                            </div>
                      </div>
               </div>
           <?php } ?>
      </div>
</div> 
                                        
<input type="hidden" name="hfa_id_ww" value="<?=$formThree['id']?>" />


<script type="text/javascript">
$(document).ready(function(){
			$('.hfa_wwcc_expiry').datepicker({
		 	    startDate: '<?=$datePickerExpirySettings['system']['year_from']?>',
				endDate: '<?=$datePickerExpirySettings['system']['year_to']?>',
				todayHighlight: true,
				orientation: "top",
				format:'dd/mm/yyyy',
				autoclose:true
			});
			$('.hfa_type_wwcc_clearance').change(function(){
				var room_value=$(this).val();
				var room_valueParent=$(this).attr('id');
				var memberSplit=room_valueParent.split('-');
				if(room_value==''){
					$('#clearance_availability_'+memberSplit[1]).slideUp();
					$('#clearance_non_availability_'+memberSplit[1]).slideUp();
				}else{
					if(room_value==1){
						$('#clearance_availability_'+memberSplit[1]).slideDown();
						$('#clearance_non_availability_'+memberSplit[1]).slideUp();
					}else if(room_value==0){
						$('#clearance_availability_'+memberSplit[1]).slideUp();
						$('#clearance_non_availability_'+memberSplit[1]).slideDown();
					}
				}
			});		
			$('.hfa_working_children').change(function(){
				
				var room_value=$(this).val();
				var room_valueParent=$(this).attr('id');
				var memberSplit=room_valueParent.split('-');
				if(room_value==1)
				{
					$('#type_wwcc_clearance_'+memberSplit[1]).slideDown();
					$('#hfa_type_wwcc_clearance-'+memberSplit[1]).attr('required','required');
				}
				if(room_value!=1)
				{
					$('#type_wwcc_clearance_'+memberSplit[1]).slideUp();
					$('#hfa_type_wwcc_clearance-'+memberSplit[1]).removeAttr('required');
					$('#clearance_availability_'+memberSplit[1]).slideUp();
					$('#clearance_non_availability_'+memberSplit[1]).slideUp();
					
					$('#type_wwcc_clearance_'+memberSplit[1]+' select').val('');
				}
			});	
			
		$('.updateBtnWWCC').click(function(){
				
				 var btnId=$(this).attr('id').split('-');
				$('#updateWWCCDetailsForm-'+btnId[1]).parsley().validate();
				if ($('#updateWWCCDetailsForm-'+btnId[1]).parsley().isValid())
				{
					  $('#updateBtnWWCC-'+btnId[1]).hide();
					  $('#updateBtnProcessWWCC-'+btnId[1]).show();
					  
					  $.ajax({
						  url:'<?=site_url()?>'+'hfa/updateWWCCDetails/'+page,
						  type:'POST',
						  data:new FormData($('#updateWWCCDetailsForm-'+btnId[1])[0]),
						  dataType: 'json',
						  cache:false,
						  contentType: false,
						  processData: false,
						  success:function(data)
							  {
								   if(data.result=='LO')
										redirectToLogin();
									else
									{
									  $('#wwinsuranceContentFileDiv-'+btnId[1]).html(data.divContent);
									  $('#updateBtnWWCC-'+btnId[1]).show();
									  $('#updateBtnProcessWWCC-'+btnId[1]).hide();

									  if(data.wwccColor!='')
									  {
									  	$('#memberDiv-'+btnId[1]+' div.wwccpopcircle').removeClass('btn-danger btn-warning btn-success btn-info btn-darkgrey').addClass(data.wwccColor).show();
										$('#memberDiv-'+btnId[1]+' span.mem18wwcc').remove();
									  }
									  
									  if(data.hasOwnProperty('appPageNotiHtml'))
									    $( "#hfaAppPageNotiLi" ).replaceWith( data.appPageNotiHtml );
									  
										notiPop('success','WWCC details updated successfully',"");
										
										var accPopId=+btnId[1] + +1;//adding 1
										$('#collapseFamilyMemberAccordionPop-'+accPopId).collapse('hide');
									}	
							  }
					  });
				}
			
			});
			
			
			
			//$('.hfa_wwcc_file').change(function(){
			$('.wwinsuranceContentFileDiv').on('change','.hfa_wwcc_file',function(){
				if (window.File && window.FileReader && window.FileList && window.Blob)
		  			{
						var exts = ['png','jpg','jpeg','pdf','docx'];
						var $btn=$(this);
						var id=$btn.attr('id').split('-');
						
						$('#wwccUploadFileError-'+id[1]).text('').hide();
						if (this.files && this.files[0]) 
							{
									if(!checkFileExtension($(this).val(),exts))
									  {
										   //alert("Only .jpg, .jpeg or .png  or .pdf or .docx files are allowed");
										   $('#wwccUploadFileError-'+id[1]).text("Only .jpg, .jpeg or .png  or .pdf or .docx files are allowed").show();
									  }
									 else if(!checkFileSize($(this)[0].files[0].size))
									  {
										   //alert("Please select file less than 2MB");
										   $('#wwccUploadFileError-'+id[1]).text("Please select file less than 2MB").show();
									  }
									  else
										{
											$('#hfa_wwcc_file_btn-'+id[1]).hide();
											$('#hfa_wwcc_file_name-'+id[1]).show();
											$('#hfa_wwcc_file_name_text-'+id[1]).text($btn.val()).show();
											
											$('#hfa_upload_diff_file-'+id[1]).removeClass('btn btn-default btn-raised').removeAttr('data-original-title').html('Upload different file');
										}
							}
					}
		  		else
					{
						alert("Please upgrade your browser, because your current browser lacks some new features we need!");
						return false;
					}
				});
				
				
				//$('.hfa_upload_diff_file_edit').click(function(){
				$('.wwinsuranceContentFileDiv').on('click','.hfa_upload_diff_file_edit',function(){
						var $btn=$(this);
						var id=$btn.attr('id').split('-');
						$('#hfa_wwcc_file_name-'+ id[1]).hide();
						$('#hfa_wwcc_file_name_text_edit-'+ id[1]).hide();
						$('#hfa_wwcc_file-'+ id[1]).val('');
						$('#hfa_wwcc_file_btn-'+ id[1]).show();
						$('#hfa_use_same_file-'+ id[1]).show();
						$('#hfa_wwcc_file_update-'+id[1]).val(1);
				});
				
				//$('.hfa_use_same_file').click(function(){
				$('.wwinsuranceContentFileDiv').on('click','.hfa_use_same_file',function(){
						var $btn=$(this);
						var id=$btn.attr('id').split('-');
						
						$btn.hide();
						$('#hfa_wwcc_file_btn-'+ id[1]).hide();
						$('#hfa_use_same_file-'+ id[1]).hide();
						$('#hfa_wwcc_file_name-'+ id[1]).show();
						$('#hfa_wwcc_file_name_text_edit-'+ id[1]).show();
						$('#hfa_wwcc_file_name_text-'+ id[1]).text('').hide();
						$('#hfa_wwcc_file_update-'+id[1]).val(0);
						
						$('#hfa_upload_diff_file-'+id[1]).addClass('btn btn-default btn-raised').attr('data-original-title','Upload different file').html('<i class="fa fa-upload"></i>');
				});
			
});

function checkFileSize(fsize)
		{
			var result=false;
			if(fsize!='')
			{
				var size=eval(fsize/1048576)
				if(size>2)
					result=false;
				else
					result=true;
			}
			return result;
		}
</script>