<?php
$shaStatusList=shaStatusList();
$hfaStatusList=hfaStatusList();
$stateList=stateList();
$reportFields=feedbacks_report_fields();
$feedbackEmailsSent_report_fields=feedbackEmailsSent_report_fields();
$clientList=clientsList();
?>
<style>
.checkbox .help-block{display:none;}

.chartjs-size-monitor { position: relative !important;}
#canvas {
    height: 500px !important;
}
</style>

<div class="page-heading report-page-heading">
      <h1>Feedback report</h1>
</div>

<!--feedback graph-->
  <script src="https://www.chartjs.org/dist/2.8.0/Chart.min.js"></script>
	<script src="https://www.chartjs.org/samples/latest/utils.js"></script>
<div class="container-fluid">
                                
	<div data-widget-group="group1">    
      <div class="row">
          <div class="col-md-12">
              <div class="panel panel-default panel-danger" >
                  
                  
                  <div class="panel-body no-padding table-responsive">
                      <!--<div class="p-md">
                             <h4 class="mb-n">Feedbacks<small>Assigned to various people</small></h4>
                      </div>-->
                      <div class="col-md-12">
                        <div class="panel panel-profile panel-bluegraylight" style="margin:16px 0; box-shadow: 0 1px 6px 0 rgba(0, 0, 0, 0.12), 0px 0px 1px 0 rgba(0, 0, 0, 0.12) !important;">
                            <div class="panel-heading" style="background-color: #eceff1;">
                            <h2>Feedback Statistics</h2>
                            </div>
                        </div>
</div>



<div class="dropdown">
                      <div>
                          <!-- <label class="col-sm-2 control-label">Advanced Range Selector</label>-->
                          <div class="col-sm-6">
                              <button class="btn btn-sm btn-raised btn-default" id="daterangepicker2">
                                  <i class="material-icons" style="float: left;">date_range</i> 
                                  <span style="float: left;margin: 5px 5px 0 5px;"><?php echo date("F j, Y", strtotime('-30 day')); ?> - <?php echo date("F j, Y"); ?></span> <b class="caret" style="float: left;margin: 10px 0 0 0;"></b>
                              </button>
                              <input type="hidden" id="chartStartDate">
                              <input type="hidden" id="chartEndDate">
                          </div>
                      </div>
                      <div style="float:right;margin-right:16px;">
                          <button class="btn btn-sm chartBtn btn-raised btn-label" href="void(0);" onclick="loadFeedbackChart('m');" data-cat="m"> Months</button>
                          <button class="btn btn-sm chartBtn btn-raised btn-label" href="void(0);" onclick="loadFeedbackChart('w');" data-cat="w"> Weeks</button>
                          <button class="btn btn-sm chartBtn btn-raised btn-label btn-primary" href="void(0);" onclick="loadFeedbackChart('d');" data-cat="d"> Days</button>
                      </div>
                  </div>

                      <div style="padding:15px;" id="canvasDIv"></div>
                  </div>
                  
              </div>
          </div>
      </div>
    </div>


</div> <!-- .container-fluid -->
<!--feedback graph ends-->

<!--11111111111-->
	    <div class="col-md-12">

			<div class="panel panel-danger" data-widget='{"draggable": "false"}'>

                        <div class="panel panel-profile panel-bluegraylight" style="margin:16px 16px 0px 16px;">
                            <div class="panel-heading">
                            <h2>Export Feedback submissions report</h2>
                            </div>
                        </div>

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
                                                          <h2>Booking Date Range</h2>
                                                      </div>
                                                      <div class="panel-body">
                                                      <p style="margin-bottom:0;">Only the families/students that have booking start date between the selected date range will be exported.</p>
                                                          
                                                              <div class="m-n form-group col-xs-6" style="padding-left:0;">
                                                                  <label class="control-label" style="margin-top:0;">From date</label>
                                                                      <input type="text" class="form-control" id="IR_fromDate" name="IR_fromDate" value="<?=date('d/m/Y')?>" readonly="readonly" style="cursor:text;">
                                                              </div>
                                                              <div class="form-group col-xs-6" style="padding-right:0;">
                                                                  <label for="officeUse-changeEmployee" class="control-label" style="margin-top:0;">To date</label>
                                                                 <input type="text" class="form-control" id="IR_toDate" name="IR_toDate" readonly="readonly" style="cursor:text;" >
                                                              </div>
                      
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


<div class="col-md-12">

			<div class="panel panel-danger" data-widget='{"draggable": "false"}'>

                        <div class="panel panel-profile panel-bluegraylight" style="margin:16px 16px 0px 16px;">
                            <div class="panel-heading">
                            <h2>Export feedback emails sent report</h2>
                            </div>
                        </div>

			  <div class="panel-body">
			  	
			  	<div class="tab-content">
					<div class="tab-pane active" id="domwizard">
						<form action="#" id="FES_report" class="form-horizontal">
							<fieldset title="Step 1">
								<legend style="display:none;">Report Options</legend>
								
                               <div class="col-md-4 no-pad-ryt" style="float:unset;margin:0 auto;">
                                              <div class="  no-pad">
                                                  <div class="panel panel-profile panel-bluegraylight">
                                                      <div class="panel-heading">
                                                          <h2>Date Range</h2>
                                                      </div>
                                                      <div class="panel-body">
                                                      <p style="margin-bottom:0;">Only the feedback emails sent between the selected date range will be exported.</p>
                                                          
                                                              <div class="m-n form-group col-xs-6" style="padding-left:0;">
                                                                  <label class="control-label" style="margin-top:0;">From date</label>
                                                                      <input type="text" class="form-control" id="FES_fromDate" name="FES_fromDate" value="<?=date('d/m/Y')?>" readonly="readonly" style="cursor:text;">
                                                              </div>
                                                              <div class="form-group col-xs-6" style="padding-right:0;">
                                                                  <label for="officeUse-changeEmployee" class="control-label" style="margin-top:0;">To date</label>
                                                                 <input type="text" class="form-control" id="FES_toDate" name="FES_toDate" readonly="readonly" style="cursor:text;" >
                                                              </div>
                      
                                                      </div>
                                                  </div>
                                              </div>
                                              </div>
                                
                                
                               
                                
                                
							</fieldset>
							<fieldset title="Step 2">
								<legend style="display:none;">Fields To Export</legend>
								
                                <div class="col-md-12 no-pad-lft IR_field">
                                      <div class="panel panel-profile panel-bluegraylight">
                                          <div class="panel-heading">
                                              <h2>Select Fields</h2>
                                          </div>
                                          <div class="panel-body" style="text-align:left;">
                                              <?php foreach($feedbackEmailsSent_report_fields as $fieldK=>$fieldV){?>
                                                  <div class="checkbox width-float">
                                                      <div class="checkbox block">
                                                          <label><input type="checkbox" name="FES_field[]"  value="<?=$fieldK?>" checked>
                                                          <?=$fieldV?>
                                                          </label>
                                                      </div>
                                                  </div>
                                              <?php } ?> 
                                          </div>
                                      </div>
                                  </div>
                                
                                
							</fieldset>
						<input type="submit" class="finish btn-primary btn" id="FES_submit" value="Export csv" onclick="return false;"/>
                        <img src="<?=loadingImagePath()?>" id="FES_submitProcess" style="margin:10px 1px 7px 0px;display:none; float: right;">
					</form>
				</div>
			
			  		
	
	</div>
				</div>
			</div>
</div>

<script type="text/javascript">

$(document).ready(function() {

	$('#IR_fromDate, #IR_toDate, #FES_fromDate, #FES_toDate').datepicker({
			orientation: "top",
			todayHighlight: true,
	    	/*startDate: "-0d",*/
			format:'dd/mm/yyyy',
			autoclose:true
		});

    //Load Wizards
    //$('#IR_form').stepy({finishButton: true, titleClick: true, block: true/*, validate: true*/});
	
	$('#IR_form').stepy({
		finishButton: true, titleClick: true, block: true, /*validate: true,*/
		next:function()
			{
				$('.parsley-toDateFieldError').remove();
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
					
					//date validation
					var endDate = $.datepicker.parseDate('dd/mm/yy', $('#IR_toDate').val());
  				    var startDate = $.datepicker.parseDate('dd/mm/yy', $('#IR_fromDate').val());
					if(startDate > endDate)
					{
						var toDateError='This field is required';
						if($('#IR_toDate').val()!='')
							toDateError='To date should be greater than From Date';
								
						var toDateField = $('#IR_toDate').parsley();
						window.ParsleyUI.removeError(toDateField,'toDateFieldError');
						window.ParsleyUI.addError(toDateField, "toDateFieldError", toDateError);
						$('#IR_toDate').focus();
						return false;
					}
					//date validation #Ends
				}
			}
	});
	
		
	$('#FES_report').stepy({
		finishButton: true, titleClick: true, block: true, /*validate: true,*/
		next:function()
			{
					//date validation
					var endDate = $.datepicker.parseDate('dd/mm/yy', $('#FES_toDate').val());
  				    var startDate = $.datepicker.parseDate('dd/mm/yy', $('#FES_fromDate').val());
					if(startDate > endDate)
					{
						var toDateError='This field is required';
						if($('#FES_toDate').val()!='')
							toDateError='To date should be greater than From Date';
								
						var toDateField = $('#FES_toDate').parsley();
						window.ParsleyUI.removeError(toDateField,'toDateFieldError');
						window.ParsleyUI.addError(toDateField, "toDateFieldError", toDateError);
						$('#FES_toDate').focus();
						return false;
					}
					//date validation #Ends
				
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
					url:'<?=site_url()?>Reports/feedback_submit',
					type:'POST',
					data:formdata,
					success:function(data){
						$('#IR_submitProcess').hide();
						$('#IR_submit').show();
						backBtn.show();
						window.open('<?=site_url()?>static/report/feedback_report.xls');	
					}
				});
		});	
	
    $('#FES_submit').click(function(){
			
			$('#FES_submitProcess').show();
			$('#FES_submit').hide();
			var backBtn=$('#FES_report-step-1 a');
			backBtn.hide();
			
			var formdata=$('#FES_report').serialize();
			$.ajax({
					url:'<?=site_url()?>Reports/feedbackEmails_submit',
					type:'POST',
					data:formdata,
					success:function(data){
						$('#FES_submitProcess').hide();
						$('#FES_submit').show();
						backBtn.show();
						window.open('<?=site_url()?>static/report/feedbackEmails_report.xls');	
					}
				});
		});
    
});
</script>



<script type="text/javascript">

		
		function loadFeedbackChart(xAxis)
		{
			var feedFrom=$('#chartStartDate').val();
			var feedTo=$('#chartEndDate').val();
			
			$.ajax({
				url:site_url+'dashboard/getchartData',
				type:'POST',
				data:{xAxis:xAxis,feedFrom:feedFrom,feedTo:feedTo},
				dataType: 'json',
				success:function(data){
						setChartOptions(data);
					}
			});
		}
		
		function setChartOptions(data)
		{
			var config = {
			type: 'line',
			data: {
				labels: data.xAxis,
				datasets: [{
					label: 'Emails sent',
					backgroundColor: window.chartColors.red,
					borderColor: window.chartColors.red,
					data: data.total_sent,
					fill: false,
				}, {
					label: 'Page visits',
					fill: false,
					backgroundColor: window.chartColors.blue,
					borderColor: window.chartColors.blue,
					data: data.total_visits,
				}, {
					label: 'Submissions',
					fill: false,
					backgroundColor: window.chartColors.green,
					borderColor: window.chartColors.green,
					data:data.total_submissions,
				}]
			},
			options: {
				maintainAspectRatio: false,
				responsive: true/*,
				title: {
					display: true,
					text: 'Chart.js Line Chart'
				}*/,
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					xAxes: [{
						display: true,
						/*scaleLabel: {
							display: true,
							labelString: 'Month'
						}*/
					}],
					yAxes: [{
						display: true,
						/*scaleLabel: {
							display: true,
							labelString: 'Value'
						}*//*,
						ticks: {
							min: 0,
							max: <?=$limit?>,

							// forces step size to be 5 units
							//stepSize: 5
						}*/
					}]
				}
			}
		};
		
		$('#canvasDIv').html('<canvas id="canvas"></canvas>');
		var ctx = document.getElementById('canvas').getContext('2d');
		window.myLine = new Chart(ctx, config);
		}
		
		$(document).ready(function(){
			
			
			
			$('#daterangepicker2').daterangepicker({
		ranges: {
			'Last 7 Days': [moment().subtract('days', 6), moment()],
			'Last 30 Days': [moment().subtract('days', 29), moment()],
			'This Month': [moment().startOf('month'), moment().endOf('month')],
			'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
		},
		opens: 'left',
		startDate: moment().subtract('days', 6),
		endDate: moment()
		},
		function(start, end) {
			$('#daterangepicker2 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
			$('#chartStartDate').val(start.format('YYYY-MM-DD'));
			$('#chartEndDate').val(end.format('YYYY-MM-DD'));
			
			$('.chartBtn').each(function(){
				if($(this).hasClass('btn-primary'))
				{
					 var chartCat=$(this).data("cat");
					 loadFeedbackChart(chartCat);
				}
			});
			
		});
		
		
		$('.chartBtn').click(function(){
			$('.chartBtn').removeClass('btn-primary');
			$(this).addClass('btn-primary');
		});
			
		});
		
</script>