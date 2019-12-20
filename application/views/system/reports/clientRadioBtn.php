<?php
$clientList=clientsList();
$clientGroupList=clientGroupList();
?>
<div class="panel panel-profile panel-bluegraylight">
  <div class="panel-heading">
      <h2>Select Client / College / University</h2>
  </div>
  <div class="panel-body">
		  <label  class="mt-n control-label filterItemLabel">Selelct whether you want to export for clients or colleges/universities or both</label>
          <div class="checkbox">
                <div class="checkbox block">
                    <label><input type="checkbox" class="reportSelectClientClg" name="reportSelectClientClg[]"  value="clients" >Clients</label>
                </div>
                
                    <!--clients starts-->
                          <div id="reportClientSelectDiv" style="display:none;">
                          <label  class="mt-n control-label filterItemLabel">Is this report for all clients or selective clients?</label>
                          <div class="radio block">
                              <label>
                                  <input type="radio" name="CaR_college_option" value="all"  checked>
                                  <span class="circle"></span>
                                  <span class="check"></span>
                                  All clients
                              </label>
                          </div>
                        
                          <div class="radio block" style="margin-top: -12px;">
                              <label>
                                  <input type="radio" name="CaR_college_option" value="client_group"  >
                                  <span class="circle"></span>
                                  <span class="check"></span>
                                  Client groups
                              </label>
                          </div>
                          <div id="CaR_clientGroupSelectDiv" style="display:none;  position:relative; overflow:hidden;">
                            <div class="col-md-10" id="CaR_clientGroupSelect">
                            </div>
                            <button type="button" class="btn btn-fab btn-fab-mini m-n" id="CaR_clientGroupSelectAddNew" style="position: absolute;bottom: 15px;">
                            <i style="color:#00aac0;" class="material-icons">add</i>
                            </button>
                          </div>		
                        
                          <div class="radio block" style="margin-top: -12px;">
                              <label>
                                  <input type="radio" name="CaR_college_option" value="selective"  >
                                  <span class="circle"></span>
                                  <span class="check"></span>
                                  Selective clients
                              </label>
                          </div>
                  
                         <div id="CaR_collegeSelectDiv" style="display:none;  position:relative; overflow:hidden;">
                            <div class="col-md-10" id="CaR_collegeSelect">
                            </div>
                            <button type="button" class="btn btn-fab btn-fab-mini m-n" id="CaR_collegeSelectAddNew" style="position: absolute;bottom: 15px;">
                            <i style="color:#00aac0;" class="material-icons">add</i>
                            </button>
                        </div>
                        </div>
                    <!--clients ends-->
                
            </div>
            <div class="checkbox">
                <div class="checkbox block">
                    <label><input type="checkbox" class="reportSelectClientClg" name="reportSelectClientClg[]"  value="colleges" >Colleges/Universities</label>
                </div>
                
                    <!--Clg/uni starts-->
                          <div id="reportClgUniSelectDiv" style="display:none;">
                          <label  class="mt-n control-label filterItemLabel">Is this report for all colleges/universities or selective ones?</label>
                          <div class="radio block">
                              <label>
                                  <input type="radio" name="CaR_clgUni_option" value="all"  checked>
                                  <span class="circle"></span>
                                  <span class="check"></span>
                                  All colleges/universities
                              </label>
                          </div>
                        
                          <div class="radio block" style="margin-top: -12px;">
                              <label>
                                  <input type="radio" name="CaR_clgUni_option" value="clgUni_group"  >
                                  <span class="circle"></span>
                                  <span class="check"></span>
                                  College/university groups
                              </label>
                          </div>
                          <div id="CaR_clgUniGroupSelectDiv" style="display:none;  position:relative; overflow:hidden;">
                            <div class="col-md-10" id="CaR_clgUniGroupSelect">
                            </div>
                            <button type="button" class="btn btn-fab btn-fab-mini m-n" id="CaR_clgUniGroupSelectAddNew" style="position: absolute;bottom: 15px;">
                            <i style="color:#00aac0;" class="material-icons">add</i>
                            </button>
                          </div>		
                        
                          <div class="radio block" style="margin-top: -12px;">
                              <label>
                                  <input type="radio" name="CaR_clgUni_option" value="selective"  >
                                  <span class="circle"></span>
                                  <span class="check"></span>
                                  Selective colleges/universities
                              </label>
                          </div>
                  
                         <div id="CaR_clgUniSelectDiv" style="display:none;  position:relative; overflow:hidden;">
                            <div class="col-md-10" id="CaR_clgUniSelect">
                            </div>
                            <button type="button" class="btn btn-fab btn-fab-mini m-n" id="CaR_clgUniSelectAddNew" style="position: absolute;bottom: 15px;">
                            <i style="color:#00aac0;" class="material-icons">add</i>
                            </button>
                        </div>
                        </div>
                    <!--Clg/uni ends-->
            </div>
          <span id="clientClgUniCheckboxError">Please select at least one option</span>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	
	/////Client #STARTS
	collegeDropdownHtml();
	
	$('#CaR_collegeSelect').on('change',"select[name='CaR_college[]']",function(){
		$('#CaR_collegeSelect div').removeClass('has-error is-empty');
		$('.parsley-clientFieldError').remove();
		});
		
	$('#CaR_collegeSelectAddNew').click(function(){collegeDropdownHtml();});
	
	$('input:radio[name=CaR_college_option]').click(function(){
			var clgOption=$("input[name='CaR_college_option']:checked").val();
			if(clgOption=='selective')
				$('#CaR_collegeSelectDiv').show();
			else	
				$('#CaR_collegeSelectDiv').hide();
		});
	/////Clients #ENDS
	
	clientGroupDropdownHtml();
	$('#CaR_clientGroupSelect').on('change',"select[name='CaR_clientGroup[]']",function(){
		$('#CaR_clientGroupSelect div').removeClass('has-error is-empty');
		$('.parsley-clientFieldError').remove();
		});
	
	$('#CaR_clientGroupSelectAddNew').click(function(){clientGroupDropdownHtml();});
	
	$('input:radio[name=CaR_college_option]').click(function(){
			var clgOption=$("input[name='CaR_college_option']:checked").val();
			if(clgOption=='client_group')
				$('#CaR_clientGroupSelectDiv').show();
			else	
				$('#CaR_clientGroupSelectDiv').hide();
		});

	
	$('.reportSelectClientClg')	.click(function(){
		
		$('#clientClgUniCheckboxError').hide();
		
		$(this).parent('label').removeClass('has-error is-empty');
		$('.parsley-clientClgFieldError').remove();
		
		if($(this).is(':checked'))
			{
				if($(this).val()=='clients')
					$('#reportClientSelectDiv').show();
				else if($(this).val()=='colleges')
					$('#reportClgUniSelectDiv').show();	
			}
		else
			{
				if($(this).val()=='clients')
					$('#reportClientSelectDiv').hide();
				else if($(this).val()=='colleges')
					$('#reportClgUniSelectDiv').hide();	
			}
	});
	
	/////ClgUni #STARTS
	clgUniGroupDropdownHtml();
	clgUniDropdownHtml();
	
	$('input:radio[name=CaR_clgUni_option]').click(function(){
			var clgOption=$("input[name='CaR_clgUni_option']:checked").val();
			if(clgOption=='selective')
				$('#CaR_collegeSelectDiv').show();
			else	
				$('#CaR_collegeSelectDiv').hide();
		});
	
	$('input:radio[name=CaR_clgUni_option]').click(function(){
			var clgOption=$("input[name='CaR_clgUni_option']:checked").val();
			if(clgOption=='clgUni_group')
				$('#CaR_clgUniGroupSelectDiv').show();
			else	
				$('#CaR_clgUniGroupSelectDiv').hide();
		});	
	$('input:radio[name=CaR_clgUni_option]').click(function(){
			var clgOption=$("input[name='CaR_clgUni_option']:checked").val();
			if(clgOption=='selective')
				$('#CaR_clgUniSelectDiv').show();
			else	
				$('#CaR_clgUniSelectDiv').hide();
		});
		$('#CaR_clgUniGroupSelectAddNew').click(function(){clgUniGroupDropdownHtml();});
		$('#CaR_clgUniSelectAddNew').click(function(){clgUniDropdownHtml();});	
	/////ClgUni #ENDS
	
});


function collegeDropdownHtml()
{
	var collegeDropdownHtml='<div class="form-group"><select class="form-control" name="CaR_college[]">';
	collegeDropdownHtml +='<option value="">Select Client</option>';
		<?php foreach($clientList as $client)
		{?>
	collegeDropdownHtml +='<option value="<?=$client['id']?>" ><?=str_replace("'","\'",$client['bname'])?></option>';
		<?php } ?>
	collegeDropdownHtml +='</select></div>';
	$('#CaR_collegeSelect').append(collegeDropdownHtml);
}

function clientGroupDropdownHtml()
{
	var collegeDropdownHtml='<div class="form-group"><select class="form-control" name="CaR_clientGroup[]">';
	collegeDropdownHtml +='<option value="">Select client group</option>';
		<?php foreach($clientGroupList as $cGK=>$cG)
		{?>
	collegeDropdownHtml +='<option value="<?=$cGK?>" ><?=$cG?></option>';
		<?php } ?>
	collegeDropdownHtml +='</select></div>';
	$('#CaR_clientGroupSelect').append(collegeDropdownHtml);
}

function clgUniGroupDropdownHtml()
{
	var clgUniGroupDropdownHtml='<div class="form-group"><select class="form-control" name="CaR_clgUniGroup[]">';
	clgUniGroupDropdownHtml +='<option value="">Select College/University group</option>';
		<?php foreach($clientGroupList as $cGK=>$cG)
		{if(in_array($cGK,['a_nsw','a_nt','a_vic','a_o'])){continue;}?>
	clgUniGroupDropdownHtml +='<option value="<?=$cGK?>" ><?=$cG?></option>';
		<?php } ?>
	clgUniGroupDropdownHtml +='</select></div>';
	$('#CaR_clgUniGroupSelect').append(clgUniGroupDropdownHtml);
}

function clgUniDropdownHtml()
{
	var clgUniDropdownHtml='<div class="form-group"><select class="form-control" name="CaR_clgUni[]">';
	clgUniDropdownHtml +='<option value="">Select College/University</option>';
		<?php foreach($clientList as $client)
		{if(!in_array($client['category'],['3','4'])){continue;}?>
	clgUniDropdownHtml +='<option value="<?=addslashes($client['bname'])?>" ><?=str_replace("'","\'",$client['bname'])?></option>';
		<?php } ?>
	clgUniDropdownHtml +='</select></div>';
	$('#CaR_clgUniSelect').append(clgUniDropdownHtml);
}

function validateClientClgUniCheckbox()
{
	  $('#clientClgUniCheckboxError').hide();
	  var result='notValid';
	  $('.reportSelectClientClg').each(function(){
				if($(this).is(':checked'))
					result='valid';
		 });
	  
	  if(result=='notValid')
		$('#clientClgUniCheckboxError').show();
	  return result;
}

function validateSelectedClient()
{	  
	  var resultValidate=validateClientClgUniCheckbox();
	  if(resultValidate=='notValid')
	  	return resultValidate;
		
	  var result='valid';
	  if($('#CaR_collegeSelectDiv').is(':visible'))
	  {
		  var clientSelected='';
		  $("select[name='CaR_college[]']").each(function(){
			  if($(this).val()!='')
				  clientSelected=$(this).val();
		  });
		  if(clientSelected=='')
		  {
			  $("select[name='CaR_college[]']:first").focus();
			  var clientField = $("select[name='CaR_college[]']:first").parsley();
			  window.ParsleyUI.removeError(clientField,'clientFieldError');
			  window.ParsleyUI.addError(clientField, "clientFieldError", 'Please select at least one client');
		  
			  //return false;
			  result='notValid';
		  }
	  }
	  return result;	
}

function validateSelectedClientGroup()
{
	var result='valid';
		if($('#CaR_clientGroupSelectDiv').is(':visible'))
						{
							var clientGroupSelected='';
							$("select[name='CaR_clientGroup[]']").each(function(){
								if($(this).val()!='')
									clientGroupSelected=$(this).val();
							});
							if(clientGroupSelected=='')
							{
								$("select[name='CaR_clientGroup[]']:first").focus();
								var clientGroupField = $("select[name='CaR_clientGroup[]']:first").parsley();
								window.ParsleyUI.removeError(clientGroupField,'clientGroupFieldError');
								window.ParsleyUI.addError(clientGroupField, "clientGroupFieldError", 'Please select at least one client group');
							
								//return false;
								result='notValid';
							}
						}
						if(result=='valid')
						result=validateSelectedClgUniGroup()
					return result;	
}

function validateSelectedClgUniGroup()
{
	var result='valid';
		if($('#CaR_clgUniGroupSelectDiv').is(':visible'))
						{
							var clientGroupSelected='';
							$("select[name='CaR_clgUniGroup[]']").each(function(){
								if($(this).val()!='')
									clientGroupSelected=$(this).val();
							});
							if(clientGroupSelected=='')
							{
								$("select[name='CaR_clgUniGroup[]']:first").focus();
								var clientGroupField = $("select[name='CaR_clgUniGroup[]']:first").parsley();
								window.ParsleyUI.removeError(clientGroupField,'clgUniGroupFieldError');
								window.ParsleyUI.addError(clientGroupField, "clgUniGroupFieldError", 'Please select at least one college/university group');
							
								//return false;
								result='notValid';
							}
						}
						if(result=='valid')
						result=validateSelectedClgUni();
					return result;	
}


function validateSelectedClgUni()
{
	var result='valid';
		if($('#CaR_clgUniSelectDiv').is(':visible'))
						{
							var clientGroupSelected='';
							$("select[name='CaR_clgUni[]']").each(function(){
								if($(this).val()!='')
									clientGroupSelected=$(this).val();
							});
							if(clientGroupSelected=='')
							{
								$("select[name='CaR_clgUni[]']:first").focus();
								var clientGroupField = $("select[name='CaR_clgUni[]']:first").parsley();
								window.ParsleyUI.removeError(clientGroupField,'clgUniFieldError');
								window.ParsleyUI.addError(clientGroupField, "clgUniFieldError", 'Please select at least one college/university');
							
								//return false;
								result='notValid';
							}
						}
					return result;	
}
</script>