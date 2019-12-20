<?php
$hfaStatusList=hfaStatusList();
$stateList=stateList();
$reportFields=revisits_report_fields();
?>

<div class="page-heading report-page-heading">
      <h1>Revisits report</h1>
</div>

<!--11111111111-->
	    <div class="col-md-12">

			<div class="panel panel-danger" data-widget='{"draggable": "false"}'>
			  
			  <div class="panel-body">
			  	
			  	<div class="tab-content">
					<div class="tab-pane active" id="domwizard">
						<form action="#" id="RR_form" class="form-horizontal">
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
                                                                      <label><input type="checkbox" name="RR_status[]"  value="<?=$statusK?>" checked> 
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
                                                                      <label><input type="checkbox" name="RR_state[]"  value="<?=$stateK?>" checked> 
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
                                                          <h2>Revisit due date range</h2>
                                                      </div>
                                                      <div class="panel-body">
                                                      <p style="margin-bottom:0;">Only the families that have revisit due date between the selected date range will be exported.</p>
                                                          
                                                              <div class="m-n form-group col-xs-6" style="padding-left:0;">
                                                                  <label class="control-label" style="margin-top:0;">From date</label>
                                                                      <input type="text" class="form-control" id="RR_fromDueDate" name="RR_fromDueDate" value="<?=date('d/m/Y')?>" readonly="readonly" style="cursor:text;" required>
                                                              </div>
                                                              <div class="form-group col-xs-6" style="padding-right:0;">
                                                                  <label for="officeUse-changeEmployee" class="control-label" style="margin-top:0;">To date</label>
                                                                 <input type="text" class="form-control" id="RR_toDueDate" name="RR_toDueDate" readonly="readonly" style="cursor:text;" required>
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
                                                          <label><input type="checkbox" name="RR_field[]"  value="<?=$fieldK?>" checked>
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
						<input type="submit" class="finish btn-primary btn" id="RR_submit" value="Export csv" onclick="return false;"/>
                        <img src="<?=loadingImagePath()?>" id="RR_submitProcess" style="margin:10px 1px 7px 0px;display:none; float: right;">
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
    $('#RR_form').stepy({finishButton: true, titleClick: true, block: true, validate: true});
	$('#RR_form').validate({
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
	
	$.validator.addMethod("greaterThanZero", function(value, element) {
	  var endDate = $.datepicker.parseDate('dd/mm/yy', value);
      var startDate = $.datepicker.parseDate('dd/mm/yy', $('#RR_fromDueDate').val());
	  return startDate < endDate;
	}, "To date should be greater than From Date");
	
	
	$('.stepy-navigator').wrapInner('<div class="pull-right"></div>');
	
	$('#RR_fromDueDate, #RR_toDueDate').datepicker({
			orientation: "top",
			todayHighlight: true,/*
	    	startDate: "-0d",*/
			format:'dd/mm/yyyy',
			autoclose:true
		});
	
    $('#RR_submit').click(function(){
			
			$('#RR_submitProcess').show();
			$('#RR_submit').hide();
			var backBtn=$('#RR_form-step-1 a');
			backBtn.hide();
			
			var formdata=$('#RR_form').serialize();
			$.ajax({
					url:'<?=site_url()?>Reports/revisits_submit',
					type:'POST',
					data:formdata,
					success:function(data){
						$('#RR_submitProcess').hide();
						$('#RR_submit').show();
						backBtn.show();
						window.open('<?=site_url()?>static/report/revisits.xls');	
					}
				});
		});
    
});
</script>