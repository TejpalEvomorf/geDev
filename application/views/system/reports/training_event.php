<?php
$hfaStatusList=hfaStatusList();
$stateList=stateList();
$reportFields=array(
	'hfaname'=>'HF Primary contact name',
	'mobile'=>'Mobile number',
	'email'=>'Email address',
	'shaname'=>'Student name',
  'age'=>'Student age',
  'pevent'=>'Past event attendence',
  'cevent'=>'Current event attendence'
);
?>

<div class="page-heading report-page-heading">
      <h1>Training Event report</h1>
</div>

<!--11111111111-->
	    <div class="col-md-12">

			<div class="panel panel-danger" data-widget='{"draggable": "false"}'>
			  
			  <div class="panel-body">
			  	
			  	<div class="tab-content">
					<div class="tab-pane active" id="domwizard">
						<form action="#" id="HR_form" class="form-horizontal">
							<fieldset title="Step 1">
								<legend style="display:none;">Report Options</legend>
								
                                		<!--000000000-->
                                              <div class="col-md-6  no-pad-lft">
                                                  <div class="panel panel-profile panel-bluegraylight">
                                                      <div class="panel-heading">
                                                          <h2>Select Status</h2>
                                                      </div>
                                                      <div class="panel-body">
                                                          <?php foreach($hfaStatusList as $statusK=>$statusV){?>
                                                              <div class="checkbox">
                                                                  <div class="checkbox block">
                                                                      <label><input type="checkbox" name="HR_status[]"  value="<?=$statusK?>" checked> 
                                                                      <?=$statusV?>
                                                                      </label>
                                                                  </div>
                                                              </div>
                                                          <?php } ?> 
                                                      </div>
                                                  </div>
                                              </div>
                                      
                                              <div class="col-md-6  no-pad-ryt">
                                                  <div class="panel panel-profile panel-bluegraylight">
                                                      <div class="panel-heading">
                                                          <h2>Select Booking Type</h2>
                                                      </div>
                                                      <div class="panel-body">
                                                              <div class="checkbox">
                                                                  <div class="checkbox block">
                                                                      <label><input type="checkbox" name=""  value="" checked> 
                                                                      Homestay nominated
                                                                      </label>
                                                                  </div>
                                                                  <div class="checkbox block">
                                                                      <label><input type="checkbox" name=""  value="" checked> 
                                                                      Under 18 bookings
                                                                      </label>
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
                                          <div class="panel-body margin-minus" style="text-align:left;">
                                              <input type="hidden" name="" value="id">
                                              <?php foreach($reportFields as $fieldK=>$fieldV){?>
                                                  <div class="checkbox width-float checkbox-width-float">
                                                      <div class="checkbox block">
                                                          <label><input type="checkbox" name=""  value="" checked>
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
						<input type="submit" class="finish btn-primary btn" id="HR_submit" value="Export csv" onclick="return false;"/>
                        <img src="<?=loadingImagePath()?>" id="HR_submitProcess" style="margin:10px 1px 7px 0px;display:none; float: right;">
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
    $('#HR_form').stepy();
    $('#wizard').stepy({finishButton: true, titleClick: true, block: true, validate: true});

    //Add Wizard Compability - see docs
    $('.stepy-navigator').wrapInner('<div class="pull-right"></div>');

    $('#HR_submit').click(function(){
			
			$('#HR_submitProcess').show();
			$('#HR_submit').hide();
			var backBtn=$('#HR_form-step-1 a');
			backBtn.hide();
			
			var formdata=$('#HR_form').serialize();
			$.ajax({
					url:'<?=site_url()?>Reports/hfa_submit',
					type:'POST',
					data:formdata,
					success:function(data){
						$('#HR_submitProcess').hide();
						$('#HR_submit').show();
						backBtn.show();
						window.open('<?=site_url()?>static/report/families.xls');	
					}
				});
		});
    
});
</script>