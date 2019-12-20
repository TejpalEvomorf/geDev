<?php
$shaStatusList=shaStatusList();
$hfaStatusList=hfaStatusList();
$stateList=stateList();
$incidentStatusList=incidentStatusList();
$reportFields=incidents_report_fields();
$clientList=clientsList();
?>
<style>
.checkbox .help-block{display:none;}
</style>

<div class="page-heading report-page-heading">
      <h1>Incidents report</h1>
</div>

<!--11111111111-->
	    <div class="col-md-12">

			<div class="panel panel-danger" data-widget='{"draggable": "false"}'>
			  
			  <div class="panel-body">
			  	
			  	<div class="tab-content">
					<div class="tab-pane active" id="domwizard">
						<form action="#" id="IR_form" class="form-horizontal">
							<fieldset title="Step 1">
								<legend style="display:none;">Report Options</legend>
								
                               
                                <div class="col-md-4 no-pad-ryt" style="float:unset;margin:0 auto;">
                                    <div class="panel panel-profile panel-bluegraylight">
                                        <div class="panel-body">
                                        <div class="form-group m-n">
                                            <label  class="mt-n control-label filterItemLabel">Is this incident report being generated for students or families?</label>
                                            <div class="radio block">
                                                <label>
                                                    <input type="radio" name="IR_for" value="sha"  required>
                                                    <span class="circle"></span>
                                                    <span class="check"></span>
                                                    Students
                                                </label>
                                            
                                                <label>
                                                    <input type="radio" name="IR_for" value="hfa"  required>
                                                    <span class="circle"></span>
                                                    <span class="check"></span>
                                                    Families
                                                </label>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                               
                                
                                		<!--000000000-->
                                        <div class="col-md-12">
                                        <div class="col-md-8 no-pad-ryt" id="step1_hfa" style="display:none;">
                                              <div class="col-md-6  no-pad-lft">
                                                  <div class="panel panel-profile panel-bluegraylight">
                                                      <div class="panel-heading">
                                                          <h2>Select Status</h2>
                                                      </div>
                                                      <div class="panel-body">
                                                          <?php foreach($hfaStatusList as $statusK=>$statusV){?>
                                                              <div class="checkbox">
                                                                  <div class="checkbox block">
                                                                      <label><input type="checkbox" name="IR_hfa_status[]"  value="<?=$statusK?>" checked> 
                                                                      <?=$statusV?>
                                                                      </label>
                                                                  </div>
                                                              </div>
                                                          <?php } ?> 
                                                      </div>
                                                  </div>
                                              </div>
                                      
                                              <div class="col-md-6  no-pad">
                                                  <div class="panel panel-profile panel-bluegraylight">
                                                      <div class="panel-heading">
                                                          <h2>Select State</h2>
                                                      </div>
                                                      <div class="panel-body">
                                                          <?php foreach($stateList as $stateK=>$stateV){?>
                                                              <div class="checkbox">
                                                                  <div class="checkbox block">
                                                                      <label><input type="checkbox" name="IR_hfa_state[]"  value="<?=$stateK?>" checked> 
                                                                      <?=$stateV?>
                                                                      </label>
                                                                  </div>
                                                              </div>
                                                          <?php } ?> 
                                                      </div>
                                                  </div>
                                              </div>
                                      </div>
                                        <div class="col-md-8 no-pad-ryt" id="step1_sha" style="display:none;">
                                              <div class="col-md-6  no-pad-lft">
                                                  <div class="panel panel-profile panel-bluegraylight">
                                                      <div class="panel-heading">
                                                          <h2>Select Status</h2>
                                                      </div>
                                                      <div class="panel-body">
                                                          <?php foreach($shaStatusList as $statusK=>$statusV){?>
                                                              <div class="checkbox">
                                                                  <div class="checkbox block">
                                                                      <label><input type="checkbox" name="IR_sha_status[]"  value="<?=$statusK?>" checked> 
                                                                      <?=$statusV?>
                                                                      </label>
                                                                  </div>
                                                              </div>
                                                          <?php } ?> 
                                                      </div>
                                                  </div>
                                              </div>
                                      
                                              <div class="col-md-6  no-pad">
											  <?php $this->load->view('system/reports/clientRadioBtn');?>
                                              </div>
                                      </div>
                                      <div class="col-md-4" id="step1_IR_status" style="display:none;">
                                              <div class="  no-pad">
                                                  <div class="panel panel-profile panel-bluegraylight">
                                                      <div class="panel-heading">
                                                          <h2>Incident Status</h2>
                                                      </div>
                                                      <div class="panel-body">
                                                          <?php foreach($incidentStatusList as $statusK=>$statusV){?>
                                                              <div class="checkbox">
                                                                  <div class="checkbox block">
                                                                      <label><input type="checkbox" name="IR_status[]"  value="<?=$statusK?>" checked> 
                                                                      <?=$statusV?>
                                                                      </label>
                                                                  </div>
                                                              </div>
                                                          <?php } ?> 
                                                      </div>
                                                  </div>
                                              </div>
                                              </div>
                                              </div>
                                        <!--000000000-->
                                
							</fieldset>
							<fieldset title="Step 2">
								<legend style="display:none;">Fields To Export</legend>
								
                                
                                <!--2222222222-->
                                 <div class="col-md-12 no-pad-lft IR_field">
                                      <div class="panel panel-profile panel-bluegraylight">
                                          <div class="panel-heading">
                                              <h2>Select Fields</h2>
                                          </div>
                                          <div class="panel-body" style="text-align:left;">
                                             <!-- <input type="hidden" name="IR_field[]" value="id">-->
                                              <?php foreach($reportFields as $fieldK=>$fieldV){?>
                                                  <div class="checkbox width-float">
                                                      <div class="checkbox block">
                                                          <label><input type="checkbox" name="IR_field[]"  value="<?=$fieldK?>" checked>
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
						<input type="submit" class="finish btn-primary btn" id="IR_submit" value="Export csv" onclick="return false;"/>
                        <img src="<?=loadingImagePath()?>" id="IR_submitProcess" style="margin:10px 1px 7px 0px;display:none; float: right;">
					</form>
				</div>
			
			  		
	
	</div>
				</div>
			</div>
</div>

<!--11111111111-->


<script type="text/javascript">

$(document).ready(function() {
	
	$('#IR_form').stepy({
		finishButton: true, titleClick: true, block: true, /*validate: true,*/
		next:function()
			{
				$('#IR_form').parsley().validate();
				var shaHfa=$("input[name='IR_for']:checked").val();
				if(shaHfa==undefined)
					return false;
				else
				{
					if($('#step1_sha').is(':visible'))	
					{
						var resultClient=validateSelectedClient();
						if(resultClient=='notValid'){return false;}
						var resultClientGroup=validateSelectedClientGroup();
						if(resultClientGroup=='notValid'){return false;}
					}
				}
			}
	});

	$('.stepy-navigator').wrapInner('<div class="pull-right"></div>');
	
	$('input:radio[name=IR_for]').click(function(){
			var shaHfa=$("input[name='IR_for']:checked").val();
			if(shaHfa=='sha')
			{
				$('#step1_sha').show();
				$('#step1_hfa').hide();
			}
			else	
			{
				$('#step1_hfa').show();	
				$('#step1_sha').hide();
			}
			$('#step1_IR_status').show();
		});
	
	
    $('#IR_submit').click(function(){
			
			$('#IR_submitProcess').show();
			$('#IR_submit').hide();
			var backBtn=$('#IR_form-step-1 a');
			backBtn.hide();
			
			var formdata=$('#IR_form').serialize();
			$.ajax({
					url:'<?=site_url()?>Reports/incidents_submit',
					type:'POST',
					data:formdata,
					success:function(data){
						$('#IR_submitProcess').hide();
						$('#IR_submit').show();
						backBtn.show();
						window.open('<?=site_url()?>static/report/incidents.xls');	
					}
				});
		});
    
});
</script>