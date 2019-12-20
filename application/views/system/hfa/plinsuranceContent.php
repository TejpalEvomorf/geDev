<?php
$datePickerExpirySettings=datePickerExpirySettings();
?>

<style type="text/css">
.pl_accordion{
    visibility: visible !important;
    opacity: 1;
    display: block;
    transform: translateY(0px);	
}
</style>

                           
<form method="post" action="" class="hintsBelow labelsAbove" id="updatePLInsDetailsForm">                           
<fieldset id="tfa_10" class="section column">
<fieldset id="" class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new">

<div class="hfa1_home_left">		

<div class="form-group full_width_field">
			<span class="hfa1_app_full">
			<label for="hfa_insurance" class="full_label control-label" style="">Do you have Public Liability insurance that covers the paying guests? <span class="reqField">*</span></label>
				<select class="form-control full_input errorOnBlur" id="hfa_insurance" name="hfa_insurance" required>
                <option value="">Select one</option>
                <option class="" id="" value="1" <?php if($formThree['insurance']=="1"){?>selected="selected"<?php }?>>Yes</option>
                <option class="" id="" value="0" <?php if($formThree['insurance']=="0"){?>selected="selected"<?php }?>>No</option>
				</select>
			</span>
</div>

<div id="hfa_insuranceDetails" class="full_width_field left_margin" <?php if($formThree['insurance']!="1"){echo 'style="display:none;"';}?>>
            <div  id="" class="form-group width-fifty-left">
			<span class="hfa1_app_full">
			<label class="control-label full_label hidden_label" for="hfa1_insurance_provider">Insurance provider</label>
			<input type="text" class="form-control full_inputss" name="hfa_insurance_provider" value="<?=$formThree['ins_provider']?>" id="hfa1_insurance_provider">
			</span>
            </div>
            
            <div  id="" class="form-group width-fifty-right">
            <span class="hfa1_app_halfs margin_10">
			<label for="hfa1_type_policy_number" class="control-label full_label hidden_label">Policy no.</label>
			<input type="text" id="hfa1_type_policy_number" value="<?=$formThree['ins_policy_no']?>" name="hfa_policy_number" class="form-control halfs_input">
			</span>
            </div>
            
            <div  id="" class="form-group width-fifty-left">
            <span class="hfa1_app_halfs">
			<label for="hfa1_type_wwcc_policy_expiry" class="control-label full_label hidden_label">Expiry date</label>
			<input type="text" id="hfa1_type_wwcc_policy_expiry" value="<?php if(isset($formThree['ins_expiry'])){if($formThree['ins_expiry']!='0000-00-00'){echo date('d/m/Y',strtotime($formThree['ins_expiry']));}}?>" name="hfa_policy_expiry" class="form-control halfs_input date-icon hfa_policy_expiry">
			</span>
            </div>
            
            <div  id="" class="form-group width-fifty-right">
            <span class="hfa1_app_full">
			<label class="control-label full_label hidden_label" for="hfa1_type_Liability_insurance" style="">Does it provide $20 million Public Liability cover?</label>
            <select class="form-control full_input_select" name="hfa_liability_insurance" id="hfa_Liability_insurance">
            <option value="">Select one</option>
            <option class="" id=" " value="1" <?php if($formThree['20_million']=="1"){?>selected="selected"<?php }?>>Yes</option>
            <option class="" value="0" <?php if($formThree['20_million']=="0"){?>selected="selected"<?php }?>>No</option>
            </select>
			</span>
            </div>
            
            <!--PL ins file-->
            <div class="wwcc-fifty-right-right plinsuranceContentFileDiv" id="plinsuranceContentFileDiv">  
           <?php $this->load->view('system/hfa/plinsuranceContentFileDiv');?>
           </div>
            <!--PL ins file-->
            
            
</div>
      

</div>


</fieldset>
</fieldset>
 

<div class="pl-button">
  <button type="button" class="btn-raised btn-primary btn" id="updateBtnPLIns">Update</button>
  <img src="<?=loadingImagePath()?>" id="updateBtnPLInsProcess" style="display:none;">
</div>
					
<input type="hidden" name="hfa_id" value="<?=$formThree['id']?>" />                            
</form>                         
<input type="hidden" name="hfa_id" value="<?=$formThree['id']?>" />                            

<script type="text/javascript">
$(document).ready(function(){
	
	$('#hfa1_type_wwcc_policy_expiry').datepicker({
		 	    startDate: '<?=$datePickerExpirySettings['system']['year_from']?>',
				endDate: '<?=$datePickerExpirySettings['system']['year_to']?>',
				todayHighlight: true,
				orientation: "top",
				format:'dd/mm/yyyy',
				autoclose:true
		});
	
/*$('#hfa_insurance').change(function(){
				var room_value=$('#hfa_insurance').val();
				if(room_value==1)
				{
					$('#type_insurance').slideDown();
				}
				if(room_value!=1)
				{
					if(room_value=="0")
					{
						$('#type_insurance').slideUp();
					}
					else	
					{
						$('#type_insurance').slideUp();
					}
					
				}
	});*/
	
	$('#updateBtnPLIns').click(function(){
		
		$('#updatePLInsDetailsForm').parsley().validate();
		if ($('#updatePLInsDetailsForm').parsley().isValid())
		  {
				  $('#updateBtnPLIns').hide();
				  $('#updateBtnPLInsProcess').show();
				  $('#updatePLInsDetailsForm .form-group').removeClass('has-success');
				  //var pLInsDetails=$('#updatePLInsDetailsForm').serialize('');
				 		  
				  $.ajax({
						  url:'<?=site_url()?>'+'hfa/updatePLInsDetails/'+page,
						  type:'POST',
						  data:new FormData($('#updatePLInsDetailsForm')[0]),
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
									  $('#plinsuranceContentFileDiv').html(data.divContent);
									  $('.pldescription').html(data.plColor);	
									  $('#updateBtnPLIns').show();
									  $('#updateBtnPLInsProcess').hide();
									  
									  if(data.hasOwnProperty('appPageNotiHtml'))
									    $( "#hfaAppPageNotiLi" ).replaceWith( data.appPageNotiHtml );
									  
									  notiPop('success','PL insurance details updated successfully',"");
								  }
							  }
				  });
		  }
	});
	
	$('#hfa_insurance').change(function(){
			
			var hfa_insurance=$('#hfa_insurance').val();
			
			if(hfa_insurance==1)
				$('#hfa_insuranceDetails').slideDown();
			else if(hfa_insurance==0 || hfa_insurance=='')
				$('#hfa_insuranceDetails').slideUp();
		});
		
		
		
		
	//	$('#hfa_ins_file').change(function(){
			$('#plinsuranceContentFileDiv').on('change','#hfa_ins_file', function(){
				if (window.File && window.FileReader && window.FileList && window.Blob)
		  			{
						var exts = ['png','jpg','jpeg','pdf','docx'];
						var $btn=$(this);
						//var id=$btn.attr('id').split('-');
						
						$('#insUploadFileError').text('').hide();
						if (this.files && this.files[0]) 
							{
									if(!checkFileExtension($(this).val(),exts))
									  {
										   //alert("Only .jpg, .jpeg or .png  or .pdf or .docx files are allowed");
										   $('#insUploadFileError').text("Only .jpg, .jpeg or .png  or .pdf or .docx files are allowed").show();
									  }
									 else if(!checkFileSize($(this)[0].files[0].size))
									  {
										   //alert("Please select file less than 2MB");
										   $('#insUploadFileError').text("Please select file less than 2MB").show();
									  }
									  else
										{
											$('#hfa_ins_file_btn').hide();
											$('#hfa_ins_file_name').show();
											$('#hfa_ins_file_name_text').text($btn.val()).show();
											
											$('#hfa_upload_diff_file_ins').removeClass('btn btn-default btn-raised').removeAttr('data-original-title').html('Upload different file');
										}
							}
					}
		  		else
					{
						alert("Please upgrade your browser, because your current browser lacks some new features we need!");
						return false;
					}
				});
				
			//$('.hfa_upload_diff_file_edit_ins').click(function(){
				$('#plinsuranceContentFileDiv').on('click','.hfa_upload_diff_file_edit_ins', function(){
						var $btn=$(this);
						$('#hfa_ins_file_name').hide();
						$('#hfa_ins_file_name_text_edit').hide();
						$('#hfa_ins_file').val('');
						$('#hfa_ins_file_btn').show();
						$('#hfa_use_same_file_ins').show();
						$('#hfa_ins_file_update').val(1);
				});
				
				
				//$('#hfa_use_same_file_ins').click(function(){
					$('#plinsuranceContentFileDiv').on('click','#hfa_use_same_file_ins', function(){
						var $btn=$(this);
						$btn.hide();
						$('#hfa_ins_file_btn').hide();
						$('#hfa_use_same_file_ins').hide();
						$('#hfa_ins_file_name').show();
						$('#hfa_ins_file_name_text_edit').show();
						$('#hfa_ins_file_name_text').text('').hide();
						$('#hfa_ins_file_update').val(0);
						
						$('#hfa_upload_diff_file_ins').addClass('btn btn-default btn-raised').attr('data-original-title','Upload different file').html('<i class="fa fa-upload"></i>');
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