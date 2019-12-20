<?php
$bookingStatusList=bookingStatusList();
$stateList=stateList();
$reportFields=college_auditing_report_fields();
$clientList=clientsList();
?>

<div class="page-heading report-page-heading">
      <h1>College audit report</h1>
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
                                             <div class="col-md-4 no-pad-lft">
                                              <div class="panel panel-profile panel-bluegraylight">
                                                  <div class="panel-heading">
                                                      <h2>Select Status</h2>
                                                  </div>
                                                  <div class="panel-body">
                                                      <?php foreach($bookingStatusList as $statusK=>$statusV){?>
                                                          <div class="checkbox">
                                                              <div class="checkbox block">
                                                                  <label><input type="checkbox" name="CaR_status[]"  value="<?=$statusK?>" checked> 
                                                                  <?=$statusV?>
                                                                  </label>
                                                              </div>
                                                          </div>
                                                      <?php } ?> 
                                                  </div>
                                              </div>
                                          </div>
                                  
                                          <div class="col-md-4 no-pad">
										  <?php $this->load->view('system/reports/clientRadioBtn');?>
                                          </div>
                                          
                                          <div class="col-md-4">
                                              <div class="  no-pad">
                                                  <div class="panel panel-profile panel-bluegraylight">
                                                      <div class="panel-heading">
                                                          <h2>Booking Date Range</h2>
                                                      </div>
                                                      <div class="panel-body">
                                                      <p style="margin-bottom:0;">Only the bookings that are active between the selected date range will be exported.</p>
                                                          
                                                              <div class="m-n form-group col-xs-6" style="padding-left:0;">
                                                                  <label class="control-label" style="margin-top:0;">From date</label>
                                                                      <input type="text" class="form-control" id="CaR_activeFromDate" name="CaR_activeFromDate" value="<?=date('d/m/Y')?>" readonly="readonly" style="cursor:text;">
                                                              </div>
                                                              <div class="form-group col-xs-6" style="padding-right:0;">
                                                                  <label for="officeUse-changeEmployee" class="control-label" style="margin-top:0;">To date</label>
                                                                 <input type="text" class="form-control" id="CaR_activeToDate" name="CaR_activeToDate" readonly="readonly" style="cursor:text;" >
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
                                    <div class="col-md-12 no-pad-lft">
                                      <div class="panel panel-profile panel-bluegraylight">
                                          <div class="panel-heading">
                                              <h2>Select Fields</h2>
                                          </div>
                                          <div class="panel-body" style="text-align:left;">
                                              <input type="hidden" name="CaR_field[]" value="id">
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
		
	$('#CaR_activeFromDate, #CaR_activeToDate').datepicker({
			orientation: "top",
			todayHighlight: true,
	    	/*startDate: "-0d",*/
			format:'dd/mm/yyyy',
			autoclose:true
		});
		
    //Load Wizards
    $('#CaR_form').stepy({
		finishButton: true, titleClick: true, block: true, 
		next:function()
			{
						var resultClient=validateSelectedClient();
						if(resultClient=='notValid'){return false;}
						var resultClientGroup=validateSelectedClientGroup();
						if(resultClientGroup=='notValid'){return false;}	
						
						//date validation
						var endDate = $.datepicker.parseDate('dd/mm/yy', $('#CaR_activeToDate').val());
						var startDate = $.datepicker.parseDate('dd/mm/yy', $('#CaR_activeFromDate').val());
						if(startDate > endDate)
						{
							var toDateError='This field is required';
							if($('#CaR_activeToDate').val()!='')
								toDateError='To date should be greater than From Date';
									
							var toDateField = $('#CaR_activeToDate').parsley();
							window.ParsleyUI.removeError(toDateField,'toDateFieldError');
							window.ParsleyUI.addError(toDateField, "toDateFieldError", toDateError);
							$('#CaR_activeToDate').focus();
							return false;
						}
						//date validation #Ends		
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
					url:'<?=site_url()?>Reports/college_auditing_submit',
					type:'POST',
					data:formdata,
					success:function(data){
						$('#CaR_submitProcess').hide();
						$('#CaR_submit').show();
						backBtn.show();
						window.open('<?=site_url()?>static/report/college_auditing.xls');	
					}
				});
		});
});
</script>