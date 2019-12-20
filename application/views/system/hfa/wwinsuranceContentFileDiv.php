

<div  class="form-group" >
            <span class="hfa1_app_full">
                <label style="" class="colorDarkgrey control-label wwcc-field full_label hidden_label" for="hfa_type_wwcc_photo">Upload a scanned copy of the WWCC for this person</label><br />
                
             
                <!--<input type="button" class="wwcc-choose-btn btn btn-default btn-raised" name="" value="Choose file" id="hfa_wwcc_file_btn-<?=$fm?>" onclick="$('#hfa_wwcc_file-<?=$fm?>').trigger('click');" <?php if($member['wwcc_file']!=""){?>style="display:none;"<?php }?>>-->
                
                <button data-placement="bottom"  data-toggle="tooltip"  data-original-title="Choose file" class="btn btn-raised btn-sm" id="hfa_wwcc_file_btn-<?=$fm?>" onclick="$('#hfa_wwcc_file-<?=$fm?>').trigger('click');return false;" <?php if($member['wwcc_file']!=""){?>style="display:none;"<?php }?>><i class="fa fa-upload"></i></button>             
                
                <input type="file" id="hfa_wwcc_file-<?=$fm?>" name="wwcc_file" class="hfa_wwcc_file" style="display:none;">
                
                <input type="hidden" name="wwcc_file_update" value="<?php if(isset($member) && $member['wwcc_file']!=''){?>0<?php }else{echo 1;} ?>" id="hfa_wwcc_file_update-<?=$fm?>" />             
                
                <?php if(isset($member) && $member['wwcc_file']!=''){?>
                 <input type="hidden" name="wwcc_file_name_update" value="<?=$member['wwcc_file']?>" id="hfa_wwcc_file_name_update-<?=$fm?>" />
                 <?php } ?>
                <p class="wwccUploadFileError" id="wwccUploadFileError-<?=$fm?>" style="display:none;"></p>
            </span>
            
            <span id="hfa_wwcc_file_name-<?=$fm?>" class="hfa_wwcc_file_name" <?php if($member['wwcc_file']==""){?>style="display:none;float:left;width:100%;"<?php }?>>
            	<p id="hfa_wwcc_file_name_text-<?=$fm?>" style="display:none;" class="hfa_wwcc_file_name_text"></p>
                
					<?php if(isset($member) && $member['wwcc_file']!='')
								{
                					echo '<span style="text-align:center;" class="hfa_wwcc_file_name_text_edit" id="hfa_wwcc_file_name_text_edit-'.$fm.'">';
										echo '<a data-placement="bottom"  data-toggle="tooltip"  data-original-title="Preview uploaded file" href="'.static_url().'uploads/hfa/wwcc/'.$member['wwcc_file'].'" target="_blank" class="btn btn-raised btn-sm"> <i class="fa fa-eye"></i></a>';
									echo "</span>";
								}
						?>
            	<a style="font-size:13px;" href="javascript:void(0);" id="hfa_upload_diff_file-<?=$fm?>" class="hfa_upload_diff_file_edit btn btn-raised btn-sm" data-placement="bottom"  data-toggle="tooltip"  data-original-title="Upload different file"><i class="fa fa-upload"></i></a>
            </span>
			  <?php if(isset($member) && $member['wwcc_file']!='')
                      {?>
                      <p style="text-align:center;"><a class="hfa_use_same_file" id="hfa_use_same_file-<?=$fm?>" href="javascript:void(0);" style="display:none;">Use the same file</a></p>
              <?php } ?>
</div>

<script type="application/javascript">
$( document ).ready(function() {
   initializeToolTip();
});
</script>