<?php
//$shaStatusList=shaStatusList();
$shaStatusList=sharedHousesStatusList();
$loggedInUser=loggedInUser();
$user_type=$loggedInUser['user_type'];
if($user_type==2)
	$employee_details=employee_details($loggedInUser['id'])
?>
                      <div class="m-n form-group">
                          <label class="control-label">Status</label>
                              <select class="form-control" id="houseChangeStatus_status" name="houseChangeStatus_status">
                                  <?php foreach($shaStatusList as $sK=>$sV){?>
                                            <option value="<?=$sK?>" <?php if($status==$sK){echo 'selected="selected"';}?>><?=$sV?></option>
                                        <?php } ?>
                              </select>
                      </div>
                     <div id="shaAssignClientDiv" style="display:none;">
                      <?php
                      	$clientsList=clientsList();
						$officeList=officeList();
						$employeeList=employeeList();
					  ?>
                      </div>


                      <div class="pl-n m-n form-group col-xs-12"  id="shaChangeStatus_dateDiv" <?php if($status!='cancelled'){?>style="display:none;"<?php } ?>>
                          <label class="control-label">Date</label>
                          <div class="input-group date">
                              <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
                              <input type="text" class="form-control"  name="status_update_date" id="dateChangeStatus_date" value="<?php if($status_update_date=='0000-00-00'){echo date('d/m/Y');}else{echo date('d/m/Y',strtotime($status_update_date));}?>">
                          </div>
                      </div>

                     <div class="m-n form-group" id="shaChangeStatus_reasonDiv" <?php if($status!='rejected' && $status!='cancelled'){?>style="display:none;clear:both;"<?php } ?>>
                          <label class="control-label">Reason</label>
                            <textarea class="form-control" name="status_update_reason"><?php echo $status_update_reason;?></textarea>
                      </div>

	   <input type="hidden" name="id" id="id" value="<?=$id?>" />
       <input type="hidden" name="status" value="<?php echo $pageStatus;?>" id="status" />

       <script type="text/javascript">
		   	$(document).ready(function(){
			   $('#dateChangeStatus_date').datepicker({
					orientation: "top",
					todayHighlight: true,
			    	startDate: "-0d",
					format:'dd/mm/yyyy',
					autoclose:true
				});

			   $('#shaChangeStatus_office').change(function(){
			   		var submitBtn=$('#shaChangeStatusSubmit');
					submitBtn.hide();
			   		$.ajax({
						url:site_url+'account/getEmployeeByOffice/'+$(this).val(),
						success:function(data)
						{
							$('#shaChangeStatus_employee').html(data);
							submitBtn.show();
						}
					});
			   });

			});
	   </script>
