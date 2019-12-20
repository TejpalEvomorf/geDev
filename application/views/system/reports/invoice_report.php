<?php
$clientList=clientsList();
?>

<div class="page-heading report-page-heading">
      <h1>Invoice report</h1>
</div>


<!--11111111111-->
	    <div class="col-md-12">

			<div class="panel panel-danger" data-widget='{"draggable": "false"}'>
			  
			  <div class="panel-body">
			  	
			  	<div class="tab-content">
					<div class="tab-pane active" id="domwizard">
						<form action="#" id="invoiceReport_form" class="form-horizontal">
								
										<!--000000000-->
                                          <div class="col-md-6 no-pad">
                                          
                                          <div class="  no-pad">
                                                  <div class="panel panel-profile panel-bluegraylight">
                                                      <div class="panel-heading">
                                                          <h2>Select Client</h2>
                                                      </div>
                                                      <div class="panel-body">
                                                     <p style="margin-bottom:0;">Selelct the client you want to export report for</p>
                                                            <div class="form-group">
                                                                <select class="form-control" id="invoiceReport_client" name="invoiceReport_client">
                                                                    <option value="">Select Client</option>
                                                                    <?php foreach($clientList as $client){?>
                                                                        <option value="<?=$client['id']?>" ><?=str_replace("'","\'",$client['bname'])?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                      
                                                      </div>
                                                  </div>
                                              </div>
										  	  
                                          </div>
                                          
                                          <div class="col-md-6">
                                              <div class="  no-pad">
                                                  <div class="panel panel-profile panel-bluegraylight">
                                                      <div class="panel-heading">
                                                          <h2>Arrival Date Range</h2>
                                                      </div>
                                                      <div class="panel-body">
                                                      <p style="margin-bottom:0;">Only the students that have arrival start date between the selected date range will be exported.</p>
                                                          
                                                              <div class="m-n form-group col-xs-6" style="padding-left:0;">
                                                                  <label class="control-label" style="margin-top:0;">From date</label>
                                                                      <input type="text" class="form-control" id="invoiceReport_fromDate" name="invoiceReport_fromDate" value="<?=date('d/m/Y')?>" readonly="readonly" style="cursor:text;">
                                                              </div>
                                                              <div class="form-group col-xs-6" style="padding-right:0;">
                                                                  <label for="officeUse-changeEmployee" class="control-label" style="margin-top:0;">To date</label>
                                                                 <input type="text" class="form-control" id="invoiceReport_toDate" name="invoiceReport_toDate" readonly="readonly" style="cursor:text;" >
                                                              </div>
                      
                                                      </div>
                                                  </div>
                                              </div>
                                              </div>
                                              
                                        <!--000000000-->
							
						<input type="submit" class="finish btn-primary btn" id="invoiceReport_submit" value="Export" onclick="return false;" style="float:right;" />
                        <img src="<?=loadingImagePath()?>" id="invoiceReport_submitProcess" style="margin:10px 1px 7px 0px;display:none; float: right;">
					</form>
				</div>
			
			  		
	
	</div>
				</div>
			</div>
</div>

<!--11111111111-->

<script type="text/javascript">
$(document).ready(function(){
		
	$('#invoiceReport_client').change(function(){
		$('.parsley-clientFieldError').remove();
	});
		
	$('#invoiceReport_fromDate, #invoiceReport_toDate').datepicker({
			orientation: "bottom",
			todayHighlight: true,
	    	/*startDate: "-0d",*/
			format:'dd/mm/yyyy',
			autoclose:true
		});
		

	
	$('#invoiceReport_submit').click(function(){
			
			$('.parsley-toDateFieldError').remove();
			
			if($('#invoiceReport_client').val()=='')
			{
				$('#invoiceReport_client').focus();
			  	var clientField = $('#invoiceReport_client').parsley();
			  	window.ParsleyUI.removeError(clientField,'clientFieldError');
			 	window.ParsleyUI.addError(clientField, "clientFieldError", 'Please select a client');
				return false;
			}
						
			//date validation
			var endDate = $.datepicker.parseDate('dd/mm/yy', $('#invoiceReport_toDate').val());
			var startDate = $.datepicker.parseDate('dd/mm/yy', $('#invoiceReport_fromDate').val());
			if(startDate > endDate)
			{
				var toDateError='This field is required';
				if($('#invoiceReport_toDate').val()!='')
					toDateError='To date should be greater than From Date';
						
				var toDateField = $('#invoiceReport_toDate').parsley();
				window.ParsleyUI.removeError(toDateField,'toDateFieldError');
				window.ParsleyUI.addError(toDateField, "toDateFieldError", toDateError);
				$('#invoiceReport_toDate').focus();
				return false;
			}
			//date validation #Ends
			
			$('#invoiceReport_submitProcess').show();
			$('#invoiceReport_submit').hide();
			
			var formdata=$('#invoiceReport_form').serialize();
			$.ajax({
					url:'<?=site_url()?>phpword/invoiceReport',
					type:'POST',
					data:formdata,
					success:function(data){
						$('#invoiceReport_submitProcess').hide();
						$('#invoiceReport_submit').show();
						window.open('<?=site_url()?>static/report/InvoiceReport.docx');	
					}
				});
		});
});
</script>