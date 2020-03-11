<?php
$clientList=clientsList();
$clientGroupList=clientGroupList();
$clientTypes=clientCategories();
$stateList=stateList();
$reportFields=clients_report_fields();
?>

<div class="page-heading report-page-heading">
      <h1>Clients report</h1>
</div>


<!--11111111111-->
<div class="col-md-12">

<div class="panel panel-danger" data-widget='{"draggable": "false"}'>

<div class="panel-body">

<div class="tab-content">
<div class="tab-pane active" id="domwizard">
<form action="#" id="CaR_form" class="form-horizontal">
<fieldset title="Step 1">
<legend style="display:none;">Report Options</legend>

<!--000000000-->
 <div class="col-md-6 no-pad-lft">
  <div class="panel panel-profile panel-bluegraylight">
      <div class="panel-heading">
          <h2>Select States</h2>
      </div>
      <div class="panel-body">
          <?php foreach($stateList as $stateK=>$stateV){?>
              <div class="checkbox">
                  <div class="checkbox block">
                      <label><input type="checkbox" name="CaR_state[]"  value="<?=$stateK?>" checked> 
                      <?=$stateV?>
                      </label>
                  </div>
              </div>
          <?php } ?> 
      </div>
  </div>
</div>

<div class="col-md-6 no-pad">
	<div class="panel panel-profile panel-bluegraylight">
	<div class="panel-heading">
      <h2>Select Employee</h2>
  </div>
  <div class="panel-body">
	  <div>
                          
                <!--Client starts-->
                      <div id="reportEmployeeSelectDiv" >
                     
                      <div class="radio block">
                          <label>
                              <input type="radio" name="CaR_client_option" value="all"  checked>
                              <span class="circle"></span>
                              <span class="check"></span>
                              All Clients
                          </label>
                      </div>

                      <div class="radio block" style="margin-top: -12px;">
                          <label>
                              <input type="radio" name="CaR_client_option" value="allIndividuals"  >
                              <span class="circle"></span>
                              <span class="check"></span>
                              Individual Clients
                          </label>
                      </div>

                       <div class="radio block" style="margin-top: -12px;">
                          <label>
                              <input type="radio" name="CaR_client_option" value="allClientGroups"  >
                              <span class="circle"></span>
                              <span class="check"></span>
                              All Client Groups
                          </label>
                      </div>

                      <div class="radio block" style="margin-top: -12px;">
                          <label>
                              <input type="radio" name="CaR_client_option" value="selectiveClientGroup"  >
                              <span class="circle"></span>
                              <span class="check"></span>
                              Selective Client Groups
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
                              <input type="radio" name="CaR_client_option" value="selectiveClientType"  >
                              <span class="circle"></span>
                              <span class="check"></span>
                              Selective Client Types
                          </label>
                      </div>
              
                     <div id="CaR_clientTypeSelectDiv" style="display:none;  position:relative; overflow:hidden;">
                        <div class="col-md-10" id="CaR_clientTypeSelect">
                        </div>
                        <button type="button" class="btn btn-fab btn-fab-mini m-n" id="CaR_clientTypeSelectAddNew" style="position: absolute;bottom: 15px;">
                        <i style="color:#00aac0;" class="material-icons">add</i>
                        </button>
                    </div>
                    </div>


                     
                <!--clients ends-->
            
        </div>

  </div>
</div>
</div>
 
<!--000000000-->
                                
</fieldset>
<fieldset title="Step 2">
	<legend style="display:none;">Fields To Export</legend>
	
    
    <!--2222222222-->
        <div class="col-md-12 no-pad-lft">
          <div class="panel panel-profile panel-bluegraylight">
              <div class="panel-heading">
                  <h2>Select Fields</h2>
              </div>
              <div class="panel-body" style="text-align:left;">
                  <?php foreach($reportFields as $fieldK=>$fieldV){?>
                      <div class="checkbox width-float">
                          <div class="checkbox block">
                              <label><input type="checkbox" name="CaR_field[]"  value="<?=$fieldK?>" checked>
                              <?=$fieldV?>
                              </label>
                          </div>
                      </div>
                  <?php } ?> 
              </div>
          </div>
      </div>
    <!--2222222222-->

    
</fieldset>
<input type="submit" class="finish btn-primary btn" id="CaR_submit" value="Export csv" onclick="return false;"/>
<img src="<?=loadingImagePath()?>" id="CaR_submitProcess" style="margin:10px 1px 7px 0px;display:none; float: right;">
</form>
</div>

	

</div>
</div>
</div>
</div>

<!--11111111111-->

<script type="text/javascript">
$(document).ready(function(){

	clientTypeDropdownHtml();
	clientGroupDropdownHtml();
	


	$('#CaR_clientTypeSelect').on('change', "select[name='CaR_client_type[]']",function(){
		$('#CaR_clientTypeSelect div').removeClass('has-error is-empty');
		$('.parsley-clientFieldError').remove();
	});

	$('#CaR_clientTypeSelectAddNew').click(function(){clientTypeDropdownHtml();});

	$('input:radio[name=CaR_client_option]').click(function(){
		var clientType = $("input[name='CaR_client_option']:checked").val();
		if(clientType=='selectiveClientType')
				$('#CaR_clientTypeSelectDiv').show();
			else	
				$('#CaR_clientTypeSelectDiv').hide();
	});


	$('#CaR_clientGroupSelect').on('change', "select[name='CaR_client_group[]']",function(){
		$('#CaR_clientGroupSelect div').removeClass('has-error is-empty');
		$('.parsley-clientFieldError').remove();
	});

	$('#CaR_clientGroupSelectAddNew').click(function(){clientGroupDropdownHtml();});

	$('input:radio[name=CaR_client_option]').click(function(){
		var clientGroup = $("input[name='CaR_client_option']:checked").val();
		if(clientGroup=='selectiveClientGroup')
				$('#CaR_clientGroupSelectDiv').show();
			else	
				$('#CaR_clientGroupSelectDiv').hide();
	});




function clientTypeDropdownHtml()
{
	var clientTypeDropdownHtml='<div class="form-group"><select class="form-control" name="CaR_client_type[]">';
	clientTypeDropdownHtml+='<option value="">Select Client Type</option>';
	<?php foreach($clientTypes as $clientK=>$clientV)
		{?>
	clientTypeDropdownHtml +='<option value="<?=$clientK?>" ><?=str_replace("'","\'",$clientV)?></option>';
		<?php } ?>
	clientTypeDropdownHtml +='</select></div>';
	$('#CaR_clientTypeSelect').append(clientTypeDropdownHtml);
	
}


function clientGroupDropdownHtml()
{
	var clientGroupDropdownHtml='<div class="form-group"><select class="form-control" name="CaR_client_group[]">';
	clientGroupDropdownHtml +='<option value="">Select Client Group</option>';
		<?php foreach($clientGroupList as $clientK=>$clientV)
		{?>
	clientGroupDropdownHtml +='<option value="<?=$clientK?>" ><?=str_replace("'","\'",$clientV)?></option>';
		<?php } ?>
	clientGroupDropdownHtml +='</select></div>';
	$('#CaR_clientGroupSelect').append(clientGroupDropdownHtml);


}

		
    //Load Wizards
    $('#CaR_form').stepy({
		finishButton: true, titleClick: true, block: true, 
		next:function()
			{
			var resultClientType=validateSelectedClientType();
			var resultClientGroup=validateSelectedClientGroup();
			if(resultClientType=='notValid' || resultClientGroup=='notValid'){return false;} 				
								
			}
	});
    

    //Add Wizard Compability - see docs
    $('.stepy-navigator').wrapInner('<div class="pull-right"></div>');
	
	$('#CaR_submit').click(function(){
			
			$('#CaR_submitProcess').show();
			$('#CaR_submit').hide();
			var backBtn=$('#CaR_form-step-1 a');
			backBtn.hide();
			
			var formdata=$('#CaR_form').serialize();
			$.ajax({
					url:'<?=site_url()?>Reports/clients_report_submit',
					type:'POST',
					data:formdata,
					success:function(data){
						$('#CaR_submitProcess').hide();
						$('#CaR_submit').show();
						backBtn.show();
						window.open('<?=site_url()?>static/report/client_report.xls');	
					}
				});
		});
});





function validateSelectedClientType()
{	  
	  var result='valid';
	  if($('#CaR_clientTypeSelectDiv').is(':visible'))
	  {
		  var clientTypeSelected='';
		  $("select[name='CaR_client_type[]']").each(function(){
			  if($(this).val()!='')
				  clientTypeSelected=$(this).val();

		  });
		  if(clientTypeSelected=='')
		  {
			  $("select[name='CaR_client_type[]']:first").focus();
			  var clientField = $("select[name='CaR_client_type[]']:first").parsley();
			  window.ParsleyUI.removeError(clientField,'clientFieldError');
			  window.ParsleyUI.addError(clientField, 'clientFieldError', 'Please select at least one type');
		  
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
		  $("select[name='CaR_client_group[]']").each(function(){
			  if($(this).val()!='')
				  clientGroupSelected=$(this).val();

		  });
		  if(clientGroupSelected=='')
		  {
			  $("select[name='CaR_client_group[]']:first").focus();
			  var clientField = $("select[name='CaR_client_group[]']:first").parsley();
			  window.ParsleyUI.removeError(clientField,'clientFieldError');
			  window.ParsleyUI.addError(clientField, 'clientFieldError', 'Please select at least one client group');
		  
			  //return false;
			  result='notValid';
		  }
	  }
	  return result;	
	  
}
</script>