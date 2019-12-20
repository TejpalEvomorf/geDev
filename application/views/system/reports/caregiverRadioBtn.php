<?php
$getCaregiverCompanyList=getCaregiverCompanyList();
?>
<div class="panel panel-profile panel-bluegraylight">
  <div class="panel-heading">
      <h2>Select Caregiving company</h2>
  </div>
  <div class="panel-body">
          <label  class="mt-n control-label filterItemLabel">Is this report for all caregiving companies or selective companies?</label>
          <div class="radio block">
              <label>
                  <input type="radio" name="CaR_CG_option" value="all"  checked>
                  <span class="circle"></span>
                  <span class="check"></span>
                  All caregiving companies
              </label>
          </div>
        
         <div class="radio block" style="margin-top: -12px;">
              <label>
                  <input type="radio" name="CaR_CG_option" value="selective"  >
                  <span class="circle"></span>
                  <span class="check"></span>
                  Selective companies
              </label>
          </div>
  
         <div id="CaR_collegeSelectDiv" style="display:none;">
            <div class="col-md-10" id="CaR_collegeSelect">
            </div>
            <button type="button" class="btn btn-fab btn-fab-mini m-n" id="CaR_collegeSelectAddNew" style="position: absolute;bottom: 33px;">
            <i style="color:#00aac0;" class="material-icons">add</i>
            </button>
        </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	
	/////Client #STARTS
	collegeDropdownHtml();
		
	$('#CaR_collegeSelectAddNew').click(function(){collegeDropdownHtml();});
	
	$('input:radio[name=CaR_CG_option]').click(function(){
			var clgOption=$("input[name='CaR_CG_option']:checked").val();
			if(clgOption=='selective')
				$('#CaR_collegeSelectDiv').show();
			else	
				$('#CaR_collegeSelectDiv').hide();
		});
	/////Clients #ENDS
		
});


function collegeDropdownHtml()
{
	var collegeDropdownHtml='<div class="form-group"><select class="form-control" name="CaR_caregiverCompany[]">';
	collegeDropdownHtml +='<option value="">Select Caregiving companies</option>';
		<?php foreach($getCaregiverCompanyList as $cgc)
		{
			$cg=getCaregiversByCompany($cgc['id']);
			if(empty($cg))
				continue;
			?>
	collegeDropdownHtml +='<option value="<?=$cgc['id']?>" ><?=str_replace("'","\'",$cgc['name'])?></option>';
		<?php } ?>
	collegeDropdownHtml +='</select></div>';
	$('#CaR_collegeSelect').append(collegeDropdownHtml);
}

function validateSelectedClient()
{
	  var result='valid';
	  if($('#CaR_collegeSelectDiv').is(':visible'))
	  {
		  var clientSelected='';
		  $("select[name='CaR_caregiverCompany[]']").each(function(){
			  if($(this).val()!='')
				  clientSelected=$(this).val();
		  });
		  if(clientSelected=='')
		  {
			  $("select[name='CaR_caregiverCompany[]']:first").focus();
			  var clientField = $("select[name='CaR_caregiverCompany[]']:first").parsley();
			  window.ParsleyUI.removeError(clientField,'clientFieldError');
			  window.ParsleyUI.addError(clientField, "clientFieldError", 'Please select at least one caregiver company');
		  
			  //return false;
			  result='notValid';
		  }
	  }
	  return result;	
}
</script>