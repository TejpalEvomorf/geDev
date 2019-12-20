<?php
$stateList=stateList();
$clientCategories=clientsList();
$employeeList=employeeList();
$loggedInUser=loggedInUser();
?>



	<div class="page-heading"><h1>Add new Tour group</h1></div>

	<div class="container-fluid">

		<div data-widget-group="group1">

			<div class="row">

				<div class="col-sm-12">

					<div class="panel panel-primary" data-widget='{"draggable": "false"}'>

						<div class="panel-body">

							<form class="" id="formCreateTour">

								<div class="form-group width-full">

									<label for="group_name" class="control-label">Tour Name</label>

									<input type="text" class="form-control" id="group_name" name="group_name" placeholder="Group Name" required>

								</div>

								<div class="form-group width-full">

									<label for="group_contact_name" class="control-label">Tour contact name</label>

									<input type="text" class="form-control" id="group_contact_name" name="group_contact_name"  placeholder="Group Contact Name" required>

								</div>

								<div class="form-group width-full">

									<label for="no_of_chaperones" class="control-label">Number of chaperones</label>

									<input type="text" class="form-control" id="no_of_chaperones" name="no_of_chaperones"  placeholder="Number of Chaperones">

								</div>

								<div class="form-group width-full">

									<label for="group_contact_email" class="control-label">Tour contact email</label>

									<input type="text" class="form-control" id="group_contact_email" name="group_contact_email"  placeholder="Tour Group Contact Email" required>

								</div>

								<div class="form-group width-full">

									<label for="group_contact_phone_no" class="control-label">Tour contact phone number</label>

									<input type="text" class="form-control" id="group_contact_phone_no" name="group_contact_phone_no"  placeholder="Contact Phone Number" required>

								</div>

								<div class="form-group width-full">

									<label class="control-label" for="client_id">Tour organised by</label>

									<select class="form-control" id="client_id" name="client_id" required>

											<option value="">Select one</option>

											<?php foreach($clientCategories as $catK=>$catV){?>

											   <option value="<? echo $catV['id'];?>"><? echo $catV['bname'];?></option>

											<?php } ?>

									</select>

								</div>
                                
                                
                                <div class="form-group width-full">
									<label class="control-label" for="employee_id">Tour owner (employee)</label>
									<select class="form-control" id="employee_id" name="employee_id" required>
										<option value="">Select one</option>
											<?php foreach($employeeList as $emp){?>
												<option value="<?=$emp['id']?>" <?php if($loggedInUser['user_type']==2 && $loggedInUser['id']==$emp['id']){?>selected="selected"<?php } ?>><?=$emp['fname'].' '.$emp['lname']?></option>
											<?php } ?>
									</select>
								</div>

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

			</div>

		</div>

	</div>

<script type="text/javascript">

	$(document).ready(function(){

		$('#submitBtnCreateTour').on('click', function () {

			//alert('reach here');return false;

			var group_nameField = $('input#group_name').parsley();

			var group_contact_nameField = $('input#group_contact_name').parsley();



			var group_contact_emailField = $('input#group_contact_email').parsley();

			var group_contact_phone_noField = $('input#group_contact_phone_no').parsley();

			//var client_idField = $('input#client_id').parsley();



			window.ParsleyUI.removeError(group_nameField,'group_nameFieldError');

			window.ParsleyUI.removeError(group_contact_nameField,'group_contact_nameFieldError');



			window.ParsleyUI.removeError(group_contact_emailField,'group_contact_emailFieldError');

			window.ParsleyUI.removeError(group_contact_phone_noField,'group_contact_phone_noFieldError');

			//window.ParsleyUI.removeError(client_idField,'Error');

			var valid=$('#formCreateTour').parsley().validate();

			if(valid)

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
								{
										window.ParsleyUI.addError(group_nameField, "group_nameFieldError", 'Group Name already registered with us');
								}
								
								if(data.notValid.group_name=='1')
											scrollToDIv('group_name');
							}

							else

							{

								if($('#id').length==0)

								{
									window.location.href=site_url+'tour/edit/'+data.done.id+'/#tourCreated';
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

