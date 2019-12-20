 <div  class="form-group" >
            <span class="hfa1_app_full">
                <label style="" class="colorDarkgrey control-label wwcc-field full_label hidden_label" for="hfa_type_wwcc_photo">Upload a scanned copy of the Public Liability Insurance</label><br />
                
                <button data-placement="bottom"  data-toggle="tooltip"  data-original-title="Choose file" class="btn btn-raised btn-sm" id="hfa_ins_file_btn" onclick="$('#hfa_ins_file').trigger('click');return false;" <?php if($formThree['ins_file']!=""){?>style="display:none;"<?php }?>><i class="fa fa-upload"></i></button>             
                
                <input type="file" id="hfa_ins_file" name="ins_file" class="hfa_ins_file" style="display:none;">
                
                <input type="hidden" name="ins_file_update" value="<?php if($formThree['ins_file']!=''){?>0<?php }else{echo 1;} ?>" id="hfa_ins_file_update" />             
                
                <?php if($formThree['ins_file']!=''){?>
                 <input type="hidden" name="ins_file_name_update" value="<?=$formThree['ins_file']?>" id="hfa_ins_file_name_update" />
                 <?php } ?>
                <p class="insUploadFileError" id="insUploadFileError" style="display:none;"></p>
            </span>
            
            <span id="hfa_ins_file_name" class="hfa_ins_file_name" <?php if($formThree['ins_file']==""){?>style="display:none;float:left;width:100%;"<?php }?>>
            	<p id="hfa_ins_file_name_text" style="display:none;" class="hfa_ins_file_name_text"></p>
                
					<?php if($formThree['ins_file']!='')
								{
                					echo '<span style="text-align:center;" class="hfa_ins_file_name_text_edit" id="hfa_ins_file_name_text_edit">';
										echo '<a data-placement="bottom"  data-toggle="tooltip"  data-original-title="Preview uploaded file" href="'.static_url().'uploads/hfa/ins/'.$formThree['ins_file'].'" target="_blank" class="btn btn-raised btn-sm"> <i class="fa fa-eye"></i></a>';
									echo "</span>";
								}
						?>
            	<a style="font-size:13px;" href="javascript:void(0);" id="hfa_upload_diff_file_ins" class="hfa_upload_diff_file_edit_ins btn btn-raised btn-sm" data-placement="bottom"  data-toggle="tooltip"  data-original-title="Upload different file"><i class="fa fa-upload"></i></a>
            </span>
			  <?php if($formThree['ins_file']!='')
                      {?>
                      <p style="text-align:center;"><a class="hfa_use_same_file_ins" id="hfa_use_same_file_ins" href="javascript:void(0);" style="display:none;">Use the same file</a></p>
              <?php } ?>
</div>