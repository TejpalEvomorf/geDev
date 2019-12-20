<script type="text/javascript">
$(document).ready(function(){
		var tabToOpen = window.location.hash;
		if (tabToOpen != '' && tabToOpen == '#tourCreated') {
		  notiPop('success','Tour added successfully','')
		  window.location.hash = '';
		}
	});
</script>

<style type="text/css">
	.sortable tr {
    cursor: pointer;
}
</style>
<?php
$stateList=stateList();
$clientCategories=clientsList();
$employeeList=employeeList();
$nationList=nationList();
$loggedInUser=loggedInUser();
$clientsListshause=clientsListshause();
//echo $tour['college_id'];
if(!empty($tour['college_id'])){
$collegedetail=clientDetail($tour['college_id']);
if(!empty($collegedetail)){
 $row2='';
				$stringAddress1='';
											  if(trim($collegedetail['suburb'])!='')
												  $stringAddress1 .=' '.trim($collegedetail['suburb']);
											  if(trim($collegedetail['state'])!='')
											  {
												  if($stringAddress1!='')
													  $stringAddress1 .='*';
												  $stringAddress1 .=trim($collegedetail['state']);
											  }
											  if(trim($collegedetail['postal_code'])!='' && $collegedetail['postal_code']!='0')
											  {
												  //if($stringAddress!='')
													 // $stringAddress .='*';
												  
												  $stringAddress1 .=' '.trim($collegedetail['postal_code']);
											  }
					
			  
				  $row2 .= $collegedetail['street_address'];
				if($collegedetail['street_address']!='' && $stringAddress1!='')
					$row2.=',';
					$row2.=str_replace('*',', ',$stringAddress1);
					$add2=$row2 ;
}
}
?>
<div class="page-heading"><h1>Manage tour</h1></div>

<div class="container-fluid">
	<div data-widget-group="group1">
		<div class="row">
			<div class="col-sm-6">
				<div class="panel panel-primary panel-bluegraylight" data-widget='{"draggable": "false"}'>
                
                <div class="panel-heading">                                
                <h2>Tour details</h2>
               </div>
                
					<div class="panel-body">
						<form class="" id="formCreateTour">
							<div class="form-group width-full">
								<label for="bname" class="control-label">Tour name</label>
								<input type="text" class="form-control" id="group_name" name="group_name" value="<?php echo $tour['group_name'];?>" placeholder="Group Name" required>
							</div>
							<div class="form-group width-full">
								<label for="bname" class="control-label">Tour contact name</label>
								<input type="text" class="form-control" id="group_contact_name" name="group_contact_name" value="<? echo $tour['group_contact_name']?>" placeholder="Group Contact Name" required>
							</div>
							<div class="form-group width-full">
								<label for="bname" class="control-label">Number of chaperones</label>
								<input type="text" class="form-control" id="no_of_chaperones" name="no_of_chaperones" value="<? echo $tour['no_of_chaperones']?>" placeholder="No of Chaperones">
							</div>
							<div class="form-group width-full">
								<label for="bname" class="control-label">Tour contact email</label>
								<input type="text" class="form-control" id="group_contact_email" name="group_contact_email" value="<? echo $tour['group_contact_email']?>" placeholder="Group Contact Email" required>
							</div>
							<div class="form-group width-full">
								<label for="bname" class="control-label">Tour contact phone number</label>
								<input type="text" class="form-control" id="group_contact_phone_no" name="group_contact_phone_no" value="<? echo $tour['group_contact_phone_no']?>" placeholder="Group Contact Phone No" required>
							</div>
							<div class="form-group width-full">
								<label for="abn" class="control-label">Tour organised by</label>
								<select class="form-control" id="client_id" name="client_id" required>
											<option value="">Select one</option>
											<?php foreach($clientCategories as $catK=>$catV){ ?>
											   <option <?php if ($tour['client_id'] == $catV['id']) { echo 'selected'; }?> value="<? echo $catV['id'];?>"><? echo $catV['bname'];?></option>
											<?php } ?>
								</select>
							</div>
                            <div class="form-group width-full">
									<label class="control-label" for="employee_id">Tour owner (employee)</label>
									<select class="form-control"  id="employee_id" name="employee_id" required>
										<option value="">Select one</option>
											<?php foreach($employeeList as $emp){?>
												<option value="<?=$emp['id']?>" <?php if($tour['employee_id']==$emp['id']){?>selected="selected"<?php } ?>><?=$emp['fname'].' '.$emp['lname']?></option>
											<?php } ?>
									</select>
								</div>
                            
							<input type="hidden" name="id" id="id" value="<?=$tour['id']?>" />
						</form>
					</div>
					<div class="panel-footer">
						<div class="row">
							<div class="col-sm-8">
								<button class="btn-raised btn-primary btn" id="submitBtnCreateTour">Submit</button>
								<img src="<?=loadingImagePath()?>" id="formCreateTourProcess" style="display:none;">
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-6">
				<form action="<?php echo site_url();?>tour/uploadExcel" method="post" class="formUploadTourCSV" enctype="multipart/form-data" id="formUploadTourCSV">
					<div class="panel panel-primary panel-bluegraylight" data-widget='{"draggable": "false"}'>
                    
                    <div class="panel-heading">                                
                <h2>Upload tour csv</h2>
               </div>
                    
						<div class="panel-body" style="padding-bottom:12px;">
							<div class="form-group is-empty is-fileinput">
								  <label class="control-label" for="importStudentFile">Click to select excel/csv file to upload</label>
								  <input type="file" id="importStudentFile" name="importStudentFile">
								  <input type="hidden" name="study_tour_id" id="study_tour_id" value="<?php echo $tour['id']?>" />
								  <input type="hidden" name="client_id" id="client_id" value="<?=$tour['client_id']?>" />
                                  <input type="hidden" name="employee_id" value="<?=$tour['employee_id']?>" />
								  <div class="col-sm-13 input-group">
									  <input type="text" readonly="" id="importProductsFileText" name="importProductsFileText" class="form-control" placeholder="Select file" required="">
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
			<?php //$this->session->set_flashdata('csv_summary_status',json_encode(array('total_records'=>20,'duplicate_records'=>8,'inserted_records'=>12)));
			//print_r(@$this->session->flashdata('csv_summary_status'));
			$uploaded_status = json_decode(@$this->session->flashdata('csv_summary_status'));
			
			if(isset($uploaded_status->error) && !empty($uploaded_status->error)) { ?>
				<div class="col-sm-6">
						<div class="panel-body">
							<div class="panel panel-primary" data-widget='{"draggable": "false"}'>
									<div class="col-md-12 col-sm-6 col-xs-12">
											<h5><b>Error : </b><span class=""><?php echo $uploaded_status->error; ?></span></h5>
									</div>
							</div>
						</div>
				</div>
			<?php }
			if(isset($uploaded_status) && !empty($uploaded_status) && !empty($uploaded_status->total_records)) {
			?>
			<div class="col-sm-6">
					<div class="panel-body">
						<div class="panel panel-primary" data-widget='{"draggable": "false"}'>
								<div class="col-md-4 col-sm-6 col-xs-12">
										<div class="info-tile info-tile-alt tile-lime info-title-one">
												<div class="info">
														<div class="tile-heading"><span>No. of Applications in Excel</span></div>
														<div class="tile-body "><span><?php echo $uploaded_status->total_records; ?></span></div>
												</div>
										</div>
								</div>
								<div class="col-md-4 col-sm-6 col-xs-12">
										<div class="info-tile info-tile-alt tile-lime info-title-two">
												<div class="info">
														<div class="tile-heading"><span>No. of Applications Imported</span></div>
														<div class="tile-body "><span><?php echo $uploaded_status->inserted_records; ?></span></div>
												</div>
										</div>
								</div>
								<div class="col-md-4 col-sm-6 col-xs-12">
										<div class="info-tile info-tile-alt tile-lime info-title-three">
												<div class="info">
														<div class="tile-heading"><span>Applications already in System</span></div>
														<div class="tile-body "><span><?php echo $uploaded_status->duplicate_records; ?></span></div>
												</div>
										</div>
								</div>
						</div>
						<?php
							$uploaded_status_warning = json_decode(@$this->session->flashdata('csv_summary_status'),true);

							if(isset($uploaded_status_warning['invalid_student_arr']) && !empty($uploaded_status_warning['invalid_student_arr']))
							{
								$getTourWarningsData['type']='current';
								$getTourWarningsData['ids']=implode(',',$uploaded_status_warning['invalid_student_arr']);
		  						$getTourWarningsData['students']=getTourWarnings($getTourWarningsData['type'],$getTourWarningsData['ids']);
						?>
						<div class="warnings_toggle panel warning-heading"><h4>Please resolve <span id="lbl_warning_count"><?=count($getTourWarningsData['students'])?></span> Warnings</h4></div>
						<div class="warnings_toggle">
							<div class="panel panel-default" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
								<div class="panel-body">
									<?php $this->load->view('system/tour/warningsCsv',$getTourWarningsData);?>
								</div>
							</div>
						</div>

						<?php }	?>

						<div class="row">
							<div class="col-sm-8 panel warning-heading">
								<?php //print_r($uploaded_status->warnings); ?>
								<a href="<?=site_url()?>tour/all_students/<?php echo $tour['id'];?>" target="_blank"><input type="button" class="btn-raised btn-success btn" id="manage_application" value="Manage Applications" /></a>
							</div>
						</div>
					</div>
					<div class="panel-footer">

					</div>
			</div>
			<?php } ?>
			<div class="col-sm-6">
			<!--<div class="page-heading"><h1>Tour group college details</h1></div>-->
			<div class="panel panel-primary panel-bluegraylight" data-widget='{"draggable": "false"}'>
            
             <div class="panel-heading">                                
                <h2>Tour group College/Institution details</h2>
               </div>
            
			<div class="panel-body" style="padding-bottom:12px;">
						
				<div class="form-group width-full">
								<label for="abn" class="control-label">Select College/Institutions</label>
								<select class="form-control" id="officeClient" name="client" >
							  <option value="">Select </option>
							  <?php foreach($clientsListshause as $cLK=>$cLV){
								  $row1='';
				$stringAddress='';
											  if(trim($cLV['suburb'])!='')
												  $stringAddress .=' '.trim($cLV['suburb']);
											  if(trim($cLV['state'])!='')
											  {
												  if($stringAddress!='')
													  $stringAddress .='*';
												  $stringAddress .=trim($cLV['state']);
											  }
											  if(trim($cLV['postal_code'])!='' && $cLV['postal_code']!='0')
											  {
												  //if($stringAddress!='')
													 // $stringAddress .='*';
												  
												  $stringAddress .=' '.trim($cLV['postal_code']);
											  }
					
			  
				  $row1 .= $cLV['street_address'];
				if($cLV['street_address']!='' && $stringAddress!='')
					$row1.=',';
					$row1.=str_replace('*',', ',$stringAddress);
			  //$add=$cLV['street_address'] .!empty($cLV['suburb']) ? ',' .$cLV['suburb'] :''.!empty($stateList[@$cLV['state']]) ? ','.$stateList[@$cLV['state']] :''.!empty($cLV['postal_code']) ? ','.$cLV['postal_code'] :'';								  
			  $add=$row1 ;
			  //$add.=!empty($cLV['suburb']) ? ',' .$cLV['suburb'] :'';
			  //$add.=!empty($stateList[@$cLV['state']]) ? ',' .$stateList[@$cLV['state']]:'';
			  //$add.=!empty($cLV['postal_code']) ? ',' .$cLV['postal_code']:'';
			  
			  ?>
										  <option data-bname="<?php echo @$cLV['bname']?>" data-sub="<?php  echo @$cLV['suburb']  ?>" data-add="<?php echo @$add ?>" value="<?=$cLV['id']?>" <?php echo !empty($collegedetail['id']) && ($collegedetail['id']==$cLV['id'])? "selected" :''?> ><?=$cLV['bname']?></option>
									  <?php } ?>
						  </select>
							</div>
					
						<div class="form-group width-full">
								<label for="bname" class="control-label">Name of College/Institutions</label>
								 <input type="text" class="form-control" id="officeUse-student_college" name="student_college"  value="<?php echo @$collegedetail['bname']?>"   >
							</div>
							<div class="form-group width-full">
								<label for="officeUse-sha_student_campus" class="control-label">Campus</label>
					   
							  <input type="text" class="form-control" id="officeUse-sha_student_campus" name="sha_student_campus" value="<?php echo @$collegedetail['suburb']?>" >
							</div>
							<div class="form-group width-full">
								<label for="officeUse-student_college_address" class="control-label">Address</label>
				  <textarea  class="form-control"  name="sha_student_college_address" id="officeUse-student_college_address"><?php  echo @$add2 ?></textarea>
							</div>
							</div>
							</div>
						
					
				
			</div>
			
        </div>
	</div>
</div>

<link href="<?=static_url()?>system/js/photoswipe/photoswipe.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=static_url()?>system/js/photoswipe/klass.min.js"></script>
<script type="text/javascript" src="<?=static_url()?>system/js/photoswipe/code.photoswipe.jquery-3.0.4.min.js"></script>
<script src="<?php echo static_url();?>system/jquery.form.min.js" type="application/javascript"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#officeClient').change(function(){
	var va=$(this).find(':selected').attr('data-sub');
	var add=$(this).find(':selected').attr('data-add');
	var bname=$(this).find(':selected').attr('data-bname');
	var cid=$(this).val();
	$('#officeUse-sha_student_campus').val(va);
	$('#officeUse-student_college_address').val(add);
	$('#officeUse-student_college').val(bname);
})


$("#officeClient,#officeUse-student_college_address,#officeUse-student_college,#officeUse-sha_student_campus").change(function(){
	//var formdata=$("Adddressstudentupdate").serialize();
	$.ajax({
			url:site_url+'tour/savecollegeaddressdetail/',
			type:'POST',
			data:{'college':$('#officeUse-student_college').val(),'sub':$('#officeUse-sha_student_campus').val(),'add':$('#officeUse-student_college_address').val(),'id':$('#id').val(),'cid':$('#officeClient').val()},
			success:function(data){
				notiPop("success","College details have been updated successfully.","");
				
			}
			})
})

		$("form#formUploadTourCSV").on('submit', function () {
			var importStudentFileField = $('input#importStudentFile').parsley();
			window.ParsleyUI.removeError(importStudentFileField,'importStudentFileFieldError');
			var valid=$('#formUploadTourCSV').parsley().validate();

			var ext = $('#importStudentFile').val().split('.').pop().toLowerCase();
			if($.inArray(ext, ['xlsx','XLSX','Xlsx']) == -1) {
				$(".show_error_file_type").remove();
				$('#importStudentFile').after('<span class="show_error_file_type" style="color:#f00;"><br />Please upload valid excel file </span>');
				//alert('invalid extension!');
				return false;
			}
		});

		$('#submitBtnCreateTour').on('click', function () {

			var group_nameField = $('input#group_name').parsley();
			var group_contact_emailField = $('input#group_contact_email').parsley();

			window.ParsleyUI.removeError(group_nameField,'group_nameFieldError');
			window.ParsleyUI.removeError(group_contact_emailField,'group_contact_emailError');

			var valid=$('#formCreateTour').parsley().validate();
			var valid2=true;
			if($('#formCreateClientCategory').length>0)
				var valid2=$('#formCreateClientCategory').parsley().validate();
			if(valid && valid2)
			{
				$('#submitBtnCreateTour').hide();
				$('#formCreateTourProcess').show();
				$.ajax({
					url:site_url+'tour/createSubmit',
					type:'POST',
					data:$('#formCreateTour').serialize(),
					dataType: 'json',
					success:function(data)
						{
							$('#formCreateTourProcess').hide();
							if(data.hasOwnProperty('logout'))
								redirectToLogin();
							else if(data.hasOwnProperty('notValid'))
							{
								$('#submitBtnCreateTour').show();
								if(data.notValid.group_name=='1')
									window.ParsleyUI.addError(group_nameField, "group_nameFieldError", 'Group name already registered with us');
								if(data.notValid.group_contact_email=='1')
										window.ParsleyUI.addError(abnField, "group_contact_emailFieldError", 'Group Contact Email already registered with us');

								if(data.notValid.group_name=='1')
									scrollToDIv('group_name');
								else if(data.notValid.group_contact_email=='1')
									scrollToDIv('group_contact_email');
							}
							else
							{
								if($('#id').length==0)
								{
									notiPop('success','Tour added successfully','')
									window.location.href=site_url+'tour/edit/'+data.done.id;
								}
								else
								{
									notiPop('success','Tour edited successfully','')
									$('#submitBtnCreateTour').show();
								}
							}
						}
				});
			}
		});
		
	});
</script>