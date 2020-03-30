<?php
$bookingStatusList=bookingStatusList();
$tmpFields=bookingsHolidayCheckups_report_fields();
$reportFields = array_slice($tmpFields,0,-2);
?>

<div class="page-heading report-page-heading">
      <h1>Active bookings report</h1>
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
                                                      <div class="widget-body mt-n form-group">
                                                              <!-- <label  class="mt-n control-label filterItemLabel">Only show applications that are:</label>-->
                                                               <div class="radio block">
                                                                    <label>
                                                                        <input type="radio" name="CaR_holidayDateType" value="booking_startDate" data-label="start" checked>
                                                                        <span class="circle"></span>
                                                                        <span class="check"></span>
                                                                        Apply to booking start date
                                                                    </label>
                                                               </div>
                                                               <div class="radio block">
                                                                    <label>
                                                                        <input type="radio" name="CaR_holidayDateType" data-label="end" value="booking_endDate">
                                                                        <span class="circle"></span>
                                                                        <span class="check"></span>
                                                                        Apply to booking end date
                                                                    </label>
                                                               </div>
                                                               <div class="radio block">
                                                                    <label>
                                                                        <input type="radio" name="CaR_holidayDateType" data-label="active" value="booking_activeDate">
                                                                        <span class="circle"></span>
                                                                        <span class="check"></span>
                                                                        Apply to active bookings
                                                                    </label>
                                                               </div>
                                                            </div>
                                                      
                                                      <p style="margin-bottom:0;">Only the bookings that have <span id="dateRangeTypeLabelPart">start/end/active</span> date between the selected date range will be exported.</p>
                                                          
                                                              <div class="m-n form-group col-xs-6" style="padding-left:0;">
                                                                  <label class="control-label" style="margin-top:0;">From date</label>
                                                                      <input type="text" class="form-control" id="CaR_fromDate" name="CaR_fromDate" value="<?=date('d/m/Y')?>" readonly="readonly" style="cursor:text;">
                                                              </div>
                                                              <div class="form-group col-xs-6" style="padding-right:0;">
                                                                  <label for="officeUse-changeEmployee" class="control-label" style="margin-top:0;">To date</label>
                                                                 <input type="text" class="form-control" id="CaR_toDate" name="CaR_toDate" readonly="readonly" style="cursor:text;" >
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
					url:'<?=site_url()?>Reports/active_bookings_submit',
					type:'POST',
					data:formdata,
					success:function(data){
						$('#CaR_submitProcess').hide();
						$('#CaR_submit').show();
						backBtn.show();
						window.open('<?=site_url()?>static/report/Active_bookings_report.xlsx');	
					}
				});
		});
		
		$("input[name='CaR_holidayDateType']").click(function(){
			$('#dateRangeTypeLabelPart').text($("input[name='CaR_holidayDateType']:checked").data('label'));
        });
		        
});
</script>