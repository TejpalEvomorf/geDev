<?php
$bookingStatusList=bookingStatusList();
$stateList=stateList();
$reportFields=tour_groups_report_fields();
$studyTourList=studyTourList();
?>

<div class="page-heading report-page-heading">
      <h1>Tour group report</h1>
</div>


<!--11111111111-->
	    <div class="col-md-12">

			<div class="panel panel-danger" data-widget='{"draggable": "false"}'>
			  
			  <div class="panel-body">
			  	
			  	<div class="tab-content">
					<div class="tab-pane active" id="domwizard">
						<form action="#" id="tgR_form" class="form-horizontal">
							<fieldset title="Step 1">
								<legend style="display:none;">Report Options</legend>
								
                                		<!--000000000-->
                                             <div class="col-md-6 no-pad-ryt" style="float:unset;margin:0 auto;">
                                              <div class="panel panel-profile panel-bluegraylight">
                                                  <div class="panel-heading">
                                                      <h2>Select Tour groups</h2>
                                                  </div>
                                                  <div class="panel-body">
                                                        <div class="col-md-10" id="CaR_collegeSelect">
                                                        </div>
                                                        <button type="button" class="btn btn-fab btn-fab-mini m-n" id="tgR_collegeSelectAddNew" style="position: absolute;bottom: 33px;">
                                                        <i style="color:#00aac0;" class="material-icons">add</i>
                                                        </button>
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
                                              <input type="hidden" name="tgR_field[]" value="id">
                                              <?php foreach($reportFields as $fieldK=>$fieldV){?>
                                                  <div class="checkbox width-float">
                                                      <div class="checkbox block">
                                                          <label><input type="checkbox" name="tgR_field[]"  value="<?=$fieldK?>" checked>
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
						<input type="submit" class="finish btn-primary btn" id="tgR_submit" value="Export csv" onclick="return false;"/>
                        <img src="<?=loadingImagePath()?>" id="tgR_submitProcess" style="margin:10px 1px 7px 0px;display:none; float: right;">
					</form>
				</div>
			
			  		
	
	</div>
				</div>
			</div>
</div>

<!--11111111111-->

<script type="text/javascript">
$(document).ready(function(){
		
	collegeDropdownHtml();
	$('#CaR_collegeSelect').on('change',"select[name='tgR_tGroup[]']",function(){
		$('#CaR_collegeSelect div').removeClass('has-error is-empty');
		$('.parsley-clientFieldError').remove();
		});
	$('#tgR_collegeSelectAddNew').click(function(){collegeDropdownHtml();});
		
    //Load Wizards
    $('#tgR_form').stepy({
		finishButton: true, titleClick: true, block: true, 
		next:function()
			{
					var groupSelected='';
					$("select[name='tgR_tGroup[]']").each(function(){
						if($(this).val()!='')
							groupSelected=$(this).val();
					});
					if(groupSelected=='')
					{
						$("select[name='tgR_tGroup[]']:first").focus();
						var clientField = $("select[name='tgR_tGroup[]']:first").parsley();
						window.ParsleyUI.removeError(clientField,'clientFieldError');
						window.ParsleyUI.addError(clientField, "clientFieldError", 'Please select at least one tour group');
					
						return false;
					}
			}
	});

    //Add Wizard Compability - see docs
    $('.stepy-navigator').wrapInner('<div class="pull-right"></div>');

    $('#tgR_submit').click(function(){
			
			$('#tgR_submitProcess').show();
			$('#tgR_submit').hide();
			var backBtn=$('#tgR_form-step-1 a');
			backBtn.hide();
			
			var formdata=$('#tgR_form').serialize();
			$.ajax({
					url:'<?=site_url()?>Reports/tour_groups_submit',
					type:'POST',
					data:formdata,
					success:function(data){
						$('#tgR_submitProcess').hide();
						$('#tgR_submit').show();
						backBtn.show();
						window.open('<?=site_url()?>static/report/tour_group.xls');	
					}
				});
		});
});

function collegeDropdownHtml()
{
	var collegeDropdownHtml='<div class="form-group"><select class="form-control" name="tgR_tGroup[]">';
	collegeDropdownHtml +='<option value="">Select Tour group</option>';
		<?php foreach($studyTourList as $tour)
		{
		?>
	collegeDropdownHtml +='<option value="<?=$tour['id']?>" ><?=str_replace("'","\'",$tour['group_name'])?></option>';
		<?php } ?>
	collegeDropdownHtml +='</select></div>';
	$('#CaR_collegeSelect').append(collegeDropdownHtml);
}
</script>