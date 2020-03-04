<?php
$reportFields=bookings_report_fields();
//$clientList=clientsList();
?>

<div class="page-heading report-page-heading">
      <h1>Booking comparison</h1>
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
                                          
                                          
                                          <div class="col-md-6 no-pad">
										  	<?php $this->load->view('system/reports/clientRadioBtn');?>
                                          </div>
                                          
                                          <div class="col-md-6">
                                              <div class="  no-pad">
                                                  <div class="panel panel-profile panel-bluegraylight">
                                                      <div class="panel-heading">
                                                          <h2>Booking Date Range</h2>
                                                      </div>
                                                      <div class="panel-body">
                                                      <p style="margin-bottom:0;">Only the bookings that have booking start date between the selected date range will be exported.</p>
                                                          
                                                              <div class="m-n form-group col-xs-6" style="padding-left:0;">
                                                                  <label class="control-label" style="margin-top:0;">From date</label>
                                                                      <input type="text" class="form-control" id="CaR_fromDate" name="CaR_fromDate" value="<?=date('d/m/Y')?>" readonly="readonly" style="cursor:text;">
                                                              </div>
                                                              <div class="form-group col-xs-6" style="padding-right:0;">
                                                                  <label for="officeUse-changeEmployee" class="control-label" style="margin-top:0;">To date</label>
                                                                 <input type="text" class="form-control" id="CaR_toDate" name="CaR_toDate" readonly="readonly" style="cursor:text;" >
                                                              </div>
                                                              <!----- compared year date ------>
                                                              <div class="m-n form-group col-xs-6" style="padding-left:0;">
                                                                  <label class="control-label" style="margin-top:0;">From date</label>
                                                                      <input type="text" class="form-control" id="CaR_fromDate_two" name="CaR_fromDate_two" value="<?=date('d/m/Y')?>" readonly="readonly" style="cursor:text;">
                                                              </div>
                                                              <div class="form-group col-xs-6" style="padding-right:0;">
                                                                  <label for="officeUse-changeEmployee" class="control-label" style="margin-top:0;">To date</label>
                                                                 <input type="text" class="form-control" id="CaR_toDate_two" name="CaR_toDate_two" readonly="readonly" style="cursor:text;" >
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
		
	$('#CaR_fromDate, #CaR_toDate').datepicker({
			orientation: "top",
			todayHighlight: true,
	    	/*startDate: "-0d",*/
			format:'dd/mm/yyyy',
			autoclose:true
		});
	$('#CaR_fromDate_two, #CaR_toDate_two').datepicker({
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
						$('.parsley-toDateFieldError').remove();
						
						var resultClient=validateSelectedClient();
						if(resultClient=='notValid'){return false;}
						var resultClientGroup=validateSelectedClientGroup();
						if(resultClientGroup=='notValid'){return false;}
						
						//date validation
						var endDate = $.datepicker.parseDate('dd/mm/yy', $('#CaR_toDate').val());
						var startDate = $.datepicker.parseDate('dd/mm/yy', $('#CaR_fromDate').val());
						var endDate_two = $.datepicker.parseDate('dd/mm/yy', $('#CaR_toDate_two').val());
						var startDate_two = $.datepicker.parseDate('dd/mm/yy', $('#CaR_fromDate_two').val());
						if(startDate > endDate)
						{
							var toDateError='This field is required';
							if($('#CaR_toDate').val()!='')
								toDateError='To date should be greater than From Date';
									
							var toDateField = $('#CaR_toDate').parsley();
							window.ParsleyUI.removeError(toDateField,'toDateFieldError');
							window.ParsleyUI.addError(toDateField, "toDateFieldError", toDateError);
							$('#CaR_toDate').focus();
							return false;
						}
						if(startDate_two > endDate_two)
						{
							var toDateError='This field is required';
							if($('#CaR_toDate_two').val()!='')
								toDateError='To date should be greater than From Date';
									
							var toDateField = $('#CaR_toDate_two').parsley();
							window.ParsleyUI.removeError(toDateField,'toDateFieldError');
							window.ParsleyUI.addError(toDateField, "toDateFieldError", toDateError);
							$('#CaR_toDate_two').focus();
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
					url:'<?=site_url()?>Reports/booking_comparison_submit',
					type:'POST',
					data:formdata,
					success:function(data){
						$('#CaR_submitProcess').hide();
						$('#CaR_submit').show();
						backBtn.show();
						window.open('<?=site_url()?>static/report/Booking_comparison.xls');	
					}
				});
		});
});
</script>