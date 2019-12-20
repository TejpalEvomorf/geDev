<?php
$hfaStatusList=hfaStatusList();
$stateList=stateList();
$reportFields=wwcc_report_fields();
$wwccStatusList=wwccStatusList();
?>

<div class="page-heading report-page-heading">
      <h1>WWCC report</h1>
</div>

<!--11111111111-->
	    <div class="col-md-12">

			<div class="panel panel-danger" data-widget='{"draggable": "false"}'>
			  
			  <div class="panel-body">
			  	
			  	<div class="tab-content">
					<div class="tab-pane active" id="domwizard">
						<form action="#" id="WR_form" class="form-horizontal">
							<fieldset title="Step 1">
								<legend style="display:none;">Report Options</legend>
								
                                		<!--000000000-->
                                        <div class="col-md-12">
                                              <div class="col-md-4  no-pad-lft">
                                                  <div class="panel panel-profile panel-bluegraylight">
                                                      <div class="panel-heading">
                                                          <h2>Select Status</h2>
                                                      </div>
                                                      <div class="panel-body">
                                                          <?php foreach($hfaStatusList as $statusK=>$statusV){?>
                                                              <div class="checkbox">
                                                                  <div class="checkbox block">
                                                                      <label><input type="checkbox" name="WR_status[]"  value="<?=$statusK?>" checked> 
                                                                      <?=$statusV?>
                                                                      </label>
                                                                  </div>
                                                              </div>
                                                          <?php } ?> 
                                                      </div>
                                                  </div>
                                              </div>
                                      
                                              <div class="col-md-4  no-pad">
                                                  <div class="panel panel-profile panel-bluegraylight">
                                                      <div class="panel-heading">
                                                          <h2>Select State</h2>
                                                      </div>
                                                      <div class="panel-body">
                                                          <?php foreach($stateList as $stateK=>$stateV){?>
                                                              <div class="checkbox">
                                                                  <div class="checkbox block">
                                                                      <label><input type="checkbox" name="WR_state[]"  value="<?=$stateK?>" checked> 
                                                                      <?=$stateV?>
                                                                      </label>
                                                                  </div>
                                                              </div>
                                                          <?php } ?> 
                                                      </div>
                                                  </div>
                                              </div>
                                      
                                              <div class="col-md-4  no-pad-ryt">
                                                  <div class="panel panel-profile panel-bluegraylight">
                                                      <div class="panel-heading">
                                                          <h2>Select WWCC Status</h2>
                                                      </div>
                                                      <div class="panel-body">
                                                          <?php foreach($wwccStatusList as $wStatusK=>$wStatusV){?>
                                                              <div class="checkbox">
                                                                  <div class="checkbox block">
                                                                      <label><input type="checkbox" name="WR_wStatus[]"  value="<?=$wStatusK?>" checked> 
                                                                      <?=$wStatusV?>
                                                                      </label>
                                                                  </div>
                                                              </div>
                                                          <?php } ?> 
                                                      </div>
                                                  </div>
                                              </div>
                                      
                                              </div>
                                        <!--000000000-->
                                
							</fieldset>
							<fieldset title="Step 2">
								<legend style="display:none;">Fields To Export</legend>
								
                                
                                <!--2222222222-->
                                 <div class="col-md-12  no-pad-lft">
                                      <div class="panel panel-profile panel-bluegraylight">
                                          <div class="panel-heading">
                                              <h2>Select Fields</h2>
                                          </div>
                                          <div class="panel-body" style="text-align:left;">
                                              <input type="hidden" name="RR_field[]" value="id">
                                              <?php foreach($reportFields as $fieldK=>$fieldV){?>
                                                  <div class="checkbox width-float">
                                                      <div class="checkbox block">
                                                          <label><input type="checkbox" name="WR_field[]"  value="<?=$fieldK?>" checked>
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
						<input type="submit" class="finish btn-primary btn" id="WR_submit" value="Export csv" onclick="return false;"/>
                        <img src="<?=loadingImagePath()?>" id="WR_submitProcess" style="margin:10px 1px 7px 0px;display:none; float: right;">
					</form>
				</div>
			
			  		
	
	</div>
				</div>
			</div>
</div>

<!--11111111111-->


<script type="text/javascript">

$(document).ready(function() {

    //Load Wizards
    $('#WR_form').stepy({finishButton: true, titleClick: true, block: true, validate: true});
	$('#WR_form').validate({
		rules:{RR_toDueDate:{greaterThanZero:true}},
        errorClass: "help-block",
        validClass: "help-block",
        highlight: function(element, errorClass,validClass) {
           $(element).closest('.form-group').addClass("has-error");
        },
        unhighlight: function(element, errorClass,validClass) {
            $(element).closest('.form-group').removeClass("has-error");
        }
    });
	
	$('.stepy-navigator').wrapInner('<div class="pull-right"></div>');
	
	
    $('#WR_submit').click(function(){
			
			$('#WR_submitProcess').show();
			$('#WR_submit').hide();
			var backBtn=$('#WR_form-step-1 a');
			backBtn.hide();
			
			var formdata=$('#WR_form').serialize();
			$.ajax({
					url:'<?=site_url()?>Reports/wwcc_submit',
					type:'POST',
					data:formdata,
					success:function(data){
						$('#WR_submitProcess').hide();
						$('#WR_submit').show();
						backBtn.show();
						window.open('<?=site_url()?>static/report/wwcc_report.xls');	
					}
				});
		});
    
});
</script>