<?php
$employeeList=employeeList();
?>

<div class="modal fade" id="model_hfaRevisitPop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" id="model_hfafamilynote_content">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h2 class="modal-title">Provide revisit info</h2>
                </div>
                
                <div class="modal-body">
                    <form id="hfaRevisitPop_form">
                    
                        <div class="pl-n m-n form-group col-xs-6">
                            <label class="control-label">Revisit date</label>
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
                                <input type="text" class="form-control"  name="hfaRevisitPop_date" id="hfaRevisitPop_date" required>
                            </div>
                        </div>
                                              
                        <div class="pr-n m-n form-group">
                            <label class="control-label">Revisit time</label>
                            <div class="input-group bootstrap-timepicker">
                                  <div class="input-group-addon"><i class="colorDarkgreen material-icons">query_builder</i></div>
                                  <input type="text" class="form-control" id="hfaRevisitPop_time"  name="hfaRevisitPop_time" value="" required>
                            </div>
                        </div>
                    
                    <div class="m-n form-group">
                          <label class="control-label">Person who revisited</label>
                              <select class="form-control" id="hfaRevisitPop_emp" name="hfaRevisitPop_emp" required>
                              <option value="" >Select employee</option>
                                  <?php
                                  foreach($employeeList as $emp)
								  {
								  	?>
                                  <option value="<?=$emp['id']?>" ><?=$emp['fname'].' '.$emp['lname']?></option>
                                  <?
								  }
								  ?>
                               </select>
                      </div>
                    
                    
                        <div class="m-n form-group">
                            <label class="control-label">Revisit comments</label>
                            <textarea class="form-control" name="hfaRevisitPop_comments"></textarea>
                        </div>
						<input type="hidden" name="hfaRevisitPop_hfaId" id="hfaRevisitPop_hfaId" value="" />
                    </form>   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-raised" id="hfaRevisitPop_submit">Submit</button>
                    <img src="<?=loadingImagePath()?>" id="hfaRevisitPop_process" style="margin-right:16px;display:none;">
                </div>
            </div><!-- /.modal-content -->
        </div>
</div><!-- /.modal -->

<script type="text/javascript">

$(document).ready(function(){

		$('#hfaRevisitPop_time').timepicker({
			minuteStep: 15/*,
			defaultTime:false*/
		});
		
		$('#hfaRevisitPop_date').datepicker({
			orientation: "bottom",
			todayHighlight: true,
	    	/*startDate: "-0d",*/
			format:'dd/mm/yyyy',
			autoclose:true
		});
		
	});
</script>