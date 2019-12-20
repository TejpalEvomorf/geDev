<?php

$employeeList=employeeList();
?>
                    
                        <div class="pl-n m-n form-group col-xs-6">
                            <label class="control-label">Date of the Visit</label>
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
                                <input type="text" class="form-control"  name="hfaEditVisitReportDate_date" id="hfaEditVisitReportDate_date" value="<?=date('d/m/Y',strtotime($visitReport['date_visited']))?>" required>
                            </div>
                        </div>
                                              
                        <div class="pr-n m-n form-group">
                            <label class="control-label">Time of the visit</label>
                            <div class="input-group bootstrap-timepicker">
                                  <div class="input-group-addon"><i class="colorDarkgreen material-icons">query_builder</i></div>
                                  <input type="text" class="form-control" id="hfaEditVisitReportDate_time"  name="hfaEditVisitReportDate_time" value="<?=date('h:i A',strtotime($visitReport['date_visited']))?>" required>
                            </div>
                        </div>
                    
                    <div class="m-n form-group">
                          <label class="control-label">Name of the person who visited this family</label>
                              <select class="form-control" disabled>
                              <option value="" >Select employee</option>
                                  <?php
                                  foreach($employeeList as $emp)
								  {
								  	?>
                                  <option value="<?=$emp['id']?>" <?php if($visitReport['employee']==$emp['id']){?>selected<?php } ?>><?=$emp['fname'].' '.$emp['lname']?></option>
                                  <?
								  }
								  ?>
                               </select>
                      </div>
                      
	                    <input type="hidden" id="hfaEditVisitReportDate_id" name="hfaEditVisitReportDate_id" value="<?=$visitReport['id']?>" />
						<input type="hidden" id="hfaEditVisitReportDate_hfaId" name="hfaEditVisitReportDate_hfaId" value="<?=$visitReport['hfa_id']?>" />

<script type="text/javascript">
$(document).ready(function(){
	
	$('#hfaEditVisitReportDate_time').timepicker({
			minuteStep: 15/*,
			defaultTime:false*/
		});
		
		$('#hfaEditVisitReportDate_date').datepicker({
			orientation: "bottom",
			todayHighlight: true,
	    	/*startDate: "-0d",*/
			format:'dd/mm/yyyy',
			autoclose:true
		});
});
</script> 