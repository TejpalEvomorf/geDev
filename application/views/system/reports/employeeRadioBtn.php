<?php
//$clientList=clientsList();
//clientGroupList=clientGroupList();
$employeeList=employeeList();

?>
<div class="panel panel-profile panel-bluegraylight">
  <div class="panel-heading">
      <h2>Select Employee</h2>
  </div>
  <div class="panel-body">
		  <div>
                              
                    <!--employee starts-->
                          <div id="reportEmployeeSelectDiv" >
                          	 <p>Is this report for all employees or selective employees?</p>
                         
                          <div class="radio block">
                              <label>
                                  <input type="radio" name="CaR_employee_option" value="all"  checked>
                                  <span class="circle"></span>
                                  <span class="check"></span>
                                  All Employees
                              </label>
                          </div>
                        
                         
                         
                          <div class="radio block" style="margin-top: -12px;">
                              <label>
                                  <input type="radio" name="CaR_employee_option" value="selective"  >
                                  <span class="circle"></span>
                                  <span class="check"></span>
                                  Selective Employees
                              </label>
                          </div>
                  
                         <div id="CaR_employeeSelectDiv" style="display:none;  position:relative; overflow:hidden;">
                            <div class="col-md-10" id="CaR_employeeSelect">
                            </div>
                            <button type="button" class="btn btn-fab btn-fab-mini m-n" id="CaR_employeeSelectAddNew" style="position: absolute;bottom: 15px;">
                            <i style="color:#00aac0;" class="material-icons">add</i>
                            </button>
                        </div>
                        </div>
                    <!--employee ends-->
                
            </div>
    
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){

	/////Employee #STARTS
	employeeDropdownHtml();
	
	$('#CaR_employeeSelect').on('change',"select[name='CaR_employee[]']",function(){
		$('#CaR_employeeSelect div').removeClass('has-error is-empty');
		$('.parsley-clientFieldError').remove();
		});
		
	$('#CaR_employeeSelectAddNew').click(function(){employeeDropdownHtml();});
	
	$('input:radio[name=CaR_employee_option]').click(function(){
			var empOption=$("input[name='CaR_employee_option']:checked").val();
			if(empOption=='selective')
				$('#CaR_employeeSelectDiv').show();
			else	
				$('#CaR_employeeSelectDiv').hide();
		});
	/////Employee #ENDS
	
	

function employeeDropdownHtml()
{
	var employeeDropdownHtml='<div class="form-group"><select class="form-control" name="CaR_employee[]">';
	employeeDropdownHtml +='<option value="">Select Employee</option>';
		<?php foreach($employeeList as $employee)
		{?>
	employeeDropdownHtml +='<option value="<?=$employee['id']?>" ><?=str_replace("'","\'",$employee['fname'].' '.$employee['lname'])?></option>';
		<?php } ?>
	employeeDropdownHtml +='</select></div>';
	$('#CaR_employeeSelect').append(employeeDropdownHtml);


}


})


function validateSelectedEmployee()
{	  
	  var result='valid';
	  if($('#CaR_employeeSelectDiv').is(':visible'))
	  {
		  var employeeSelected='';
		  $("select[name='CaR_employee[]']").each(function(){
			  if($(this).val()!='')
				  employeeSelected=$(this).val();

		  });
		  if(employeeSelected=='')
		  {
			  $("select[name='CaR_employee[]']:first").focus();
			  var employeeField = $("select[name='CaR_employee[]']:first").parsley();
			  window.ParsleyUI.removeError(employeeField,'employeeFieldError');
			  window.ParsleyUI.addError(employeeField, 'employeeFieldError', 'Please select at least one employee');
		  
			  //return false;
			  result='notValid';
		  }
	  }
	  return result;	
	  
}
</script>