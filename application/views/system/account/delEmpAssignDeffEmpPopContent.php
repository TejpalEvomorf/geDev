<?php 
$officeList=officeList();
$employee=employee_details($id);

//$employeeList=otherEmployeesSameOffice($employee['id'],$employee['office']);
$employeeList=employeeList();
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="$('#empUpdateDesignationForm')[0].reset();">&times;</button>
    <h2 class="modal-title">Delete</h2>
</div>
   
<div class="modal-body">
  This employee is linked to <span id="assignDiffEmpToAppCount"><?=$count?></span> student application<?php if($count!=1){echo 's';}?>. Before deleting you have to assign <?php if($count!=1){echo 'these applications';}else{echo 'this application';}?> to a different employee.
   <?php if(empty($employeeList)){?>
   <p>But there is no employee to assign <?php if($count!=1){echo 'these applications';}else{echo 'this application';}?> to. So you have to add an employee first.</p>
   <?php }else{?>
      <form id="model_assignDiffEmpToApp_form" data-parsley-validate>
          <div class="m-n form-group">
            <label class="control-label">Choose employee</label>
              <select class="form-control" id="assignDiffEmpToApp_emp" name="assignDiffEmpToApp_emp" required>
              <option value="">Select employee</option>
              <?php foreach($employeeList as $eLK=>$eLV){
				  if($employee['id']==$eLV['id'])
				  	continue;
				  ?>
              <option value="<?=$eLV['id']?>"><?=ucwords($eLV['fname'].' '.$eLV['lname'])?></option>
              <?php } ?>
            </select>
          </div>
          <input type="hidden" name="id" value="<?=$employee['id']?>"/>
      </form>
      <?php } ?>
</div>
<div class="modal-footer">
    <?php if(!empty($employeeList)){?>
    <button data-bb-handler="danger" type="button" class="ml5 btn btn-default deleteEditEmpBtn" onclick="$('#model_assignDiffEmpToApp').modal('hide');">Cancel</button>
    <button data-bb-handler="main" type="button" class="ml5 btn btn-danger deleteEditEmpBtn" onclick="assignDiffEmpToAppSubmit(<?=$employee['id']?>);">Delete</button>
    <img src="<?=loadingImagePath()?>" id="deleteEditEmpProcess" style="margin-right:16px;display:none;">
    <?php }
    else{ ?>
    <button data-bb-handler="danger" type="button" class="ml5 btn btn-default" onclick="$('#model_assignDiffEmpToApp').modal('hide');">Close</button>
    <?php }?>
</div>