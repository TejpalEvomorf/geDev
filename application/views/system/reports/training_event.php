<?php
$bookingStatusList=bookingStatusList();
$reportFields=trainingreportFields();
?>

<div class="page-heading report-page-heading">
    <h1>Training Event report</h1>
</div>

<!--11111111111-->
<a href="#" class="btn btn-primary pull-right" id="importCSVBtn">IMPORT CSV</a>

        <div class="col-sm-12" id="uploadDiv" style="display:none;">
        <form id="formUploadAttendenceCSV">
            <div class="panel panel-primary panel-bluegraylight" data-widget='{"draggable": "false"}'>
            
            <div class="panel-heading">                                
        <h2>Upload Attendence csv</h2>
        </div>
            
                <div class="panel-body" style="padding-bottom:12px;">
                    <div class="form-group is-empty is-fileinput">
                        <label class="control-label" for="importTrainingAttendenceFile">Click to select excel/csv file to upload</label>
                        <input type="file" id="importTrainingAttendencetFile" name="importTrainingAttendenceFile">

                        <div class="col-sm-13 input-group">
                            <input type="text" readonly="" id="importAttendenceText" name="importAttendenceFileText" class="form-control" placeholder="Select file" required="">
                            <span class="input-group-btn input-group-sm">
                                <button type="button" class="btn btn-fab btn-fab-mini">
                                    <i class="material-icons">attach_file</i>
                                </button>
                            </span>
                        </div>
                        <span class="material-input"></span>
                    </div>
                </div>
                <div class="panel-footer" style="padding-top:0;">
                    <div class="row">
                        <div class="col-sm-8">
                            <input type="submit" class="btn-raised btn-primary btn" id="submitBtnUploadCSV" value="Upload Now" />
                            <img src="<?=loadingImagePath()?>" id="formCreateTourProcess" style="display:none;">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-12 " id="errorsDiv" style="display:none;">
    <div class="panel panel-profile panel-bluegraylight">
        <div class="panel-heading">                                
        <h2>Family Training Attendence File has the following Hosts with wrong date format</h2>
       </div>
        <div class="panel-body margin-minus" style="text-align:left;">
            <table >
                <th>Host Name</th>
                <th>Dates</th>
                <tbody  id="result"> 
                </tbody>
            </table>
            </div>
        </div>
    </div>


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
                                                          <?php foreach($bookingStatusList as $statusK=>$statusV){?>
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
                                                                      <label><input type="checkbox" name="HR_type[]"  value="HSN" checked> 
                                                                      Homestay nominated
                                                                      </label>
                                                                  </div>
                                                                  <div class="checkbox block">
                                                                      <label><input type="checkbox" name="HR_type[]"  value="U18" checked> 
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
                                                      <label><input type="checkbox" name="HR_field[]"  value="<?=$fieldK?>" checked>
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
					url:'<?=site_url()?>Reports/training_event_submit',
					type:'POST',
					data:formdata,
					success:function(data){
						$('#HR_submitProcess').hide();
						$('#HR_submit').show();
						backBtn.show();
						window.open('<?=site_url()?>static/report/family_training_attendence.xlsx');	
					}
				});
		});

        $("#submitBtnUploadCSV").click(function (event) {

            event.preventDefault();
            var form = $('#formUploadAttendenceCSV')[0];
            var data =  new FormData(form);
            $("#submitBtnUploadCSV").hide();
            $("#formCreateTourProcess").show();
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: "<?php echo site_url();?>"+"reports/uploadExcel",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                success: function (data) {

                    $("#result").html(data);
                    if(data.length === 0)
                      {
                        notiPop('success','Attendence updated successfully','');
                        $('#errorsDiv').slideUp();
                      }
                      else 
                      {
                        $('#errorsDiv').slideDown();
                      }
                    $("#submitBtnUploadCSV").show();
                     $("#formCreateTourProcess").hide();

                },
                error: function (e) {

                    $("#result").text(e.responseText);
                    console.log("ERROR : ", e);
                    $("#submitBtnUploadCSV").prop("disabled", false);

                }
            });

            });

        $("form#formUploadTourCSV").on('submit', function () {
			var importStudentFileField = $('input#importTrainingAttendencetFile').parsley();
			window.ParsleyUI.removeError(importStudentFileField,'importStudentFileFieldError');
			var valid=$('#formUploadTourCSV').parsley().validate();

			var ext = $('#importTrainingAttendencetFile').val().split('.').pop().toLowerCase();
			if($.inArray(ext, ['xlsx','XLSX','Xlsx']) == -1) {
				$(".show_error_file_type").remove();
				$('#importTrainingAttendencetFile').after('<span class="show_error_file_type" style="color:#f00;"><br />Please upload valid excel file </span>');
				//alert('invalid extension!');
				return false;
			}
		});

        $('#importCSVBtn').click(function(){
            $('#uploadDiv').slideToggle();
        })

});
</script>