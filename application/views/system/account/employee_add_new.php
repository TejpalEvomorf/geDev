<?php
$loggedInUser=loggedInUser();
if($loggedInUser['user_type']==1)
{
$employeeDesignationList=employeeDesignationList();
$officeList=officeList();
?>
<div class="page-heading">
      <h1 id="accountPageHeading">Add new employee</h1>
</div>

<div class="container-fluid">
                                 
<div data-widget-group="group1">
	<div class="row">
	<div class="ge-app-submenu col-md-12 pl-n pr-n ul-tabs">
			<ul class="nav nav-tabs material-nav-tabs mb-lg">
				<li  id="myAccountTab"><a href="<?=site_url()?>account"> My Account </a></li>
				<li id="employeeTab"><a href="<?=site_url()?>account/#tab-8-2"> Employee List</a></li>
			</ul>
    </div>

					<div class="p-n col-md-12">
						<?php
$employeeDesignationList=employeeDesignationList();
$genderList=genderList();
?>
<div class="col-md-3">
    <div class="panel panel-profile panel-bluegraylight" data-widget='{"draggable": "false"}'>
       <div class="panel-heading">
          <h2>Designation</h2>
       </div>
       <div class="panel-body">
          <form id="empDesignationForm">
              <div class="form-group">
                <label for="designation" class="col-sm-2 control-label">Designation</label>
                <select name="designation" id="designation" class="form-control" required  onchange="$('#empDesignation').val(this.value);">
                  <option value="">Select one</option>
                  <?php foreach($employeeDesignationList as $eDK=>$eDV){?>
                      <option value="<?=$eDK?>"><?=$eDV?></option>
                  <?php } ?>
              </select>
              </div>
              
              <div class="form-group">
                <label for="office" class="col-sm-2 control-label">Office</label>
                <select name="office" id="office" class="form-control" required  onchange="$('#empOffice').val(this.value);">
                  <option value="">Select one</option>
                  <?php foreach($officeList as $oLK=>$oLV){?>
                      <option value="<?=$oLK?>"><?=$oLV?></option>
                  <?php } ?>
              </select>
              </div>
              
          </form>
       </div>
    </div>
</div>
<div class="col-md-9">
    <div>
    
    	<form class="tabular-form" id="addEmployeeForm">
                
                <div class="tab-pane p-md panel panel-default" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                
                <div class="form-group width-fifty-left">
                  <label for="company_email" class="control-label">Company email id/Username</label>
                  <input type="text" class="form-control" id="company_email" name="company_email"  placeholder="Email id" data-parsley-type="email" required>
				</div>
                
                <div class="form-group width-fifty-right">
                  <label for="password" class="control-label">Password</label>
                  <input type="text" class="form-control" id="password" name="password"  value="<?=randStrGen(10)?>" placeholder="Password" required>
				</div>
                
                </div>
                
                <div class="tab-pane p-md panel panel-default" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                
                <div class="form-group width-fifty-left">
                  <label for="name" class="control-label">First name</label>
                  <input type="text" class="form-control" id="name" name="name"  placeholder="First name" required>
				</div>
                
                <div class="form-group width-fifty-right">
                  <label for="name" class="control-label">Last name</label>
                  <input type="text" class="form-control" id="lname" name="lname"  placeholder="Last name" required>
				</div>
                
                <div class="form-group width-fifty-left">
                  <label for="phone" class="control-label">Phone</label>
                  <input type="text" class="form-control" id="phone" name="phone"  placeholder="Phone number" required>
				</div>
                
                <div class="form-group width-fifty-right">
                  <label for="personal_email" class="control-label">Personal email id</label>
                  <input type="text" class="form-control" id="personal_email" name="personal_email"  placeholder="Email id" data-parsley-type="email">
				</div>
                
                <div class="form-group width-fifty-left">
                  <label for="gender" class="control-label">Gender</label>
                  <select name="gender" id="gender" class="form-control" required>
                      <option value="">Select one</option>
                      <?php foreach($genderList as $gK=>$gV){?>
                      <option value="<?=$gK?>"><?=$gV?></option>
                      <?php } ?>
                  </select>
              </div>
                
                <div class="form-group width-fifty-right">
                  <label for="office_phone" class="control-label">Office phone extension</label>
                  <input type="text" class="form-control" id="office_phone" name="office_phone" placeholder="Office phone">
				</div>
                <input type="hidden" name="designation" id="empDesignation" value="" />
                <input type="hidden" name="office" id="empOffice" value="" />
         
         <div class="row">
            <div class="col-sm-8">
                <input type="button" class="btn-raised btn-primary btn" id="submitBtnAddEmployee" value="Submit">
                <img src="<?=loadingImagePath()?>" id="addEmployeeFormProcess" style="display:none;">
            </div>
         </div>
    
    </div>
    
    </form>
    
    </div>
</div>
					</div>

	</div>
</div>
</div>

<script type="text/javascript">

$(document).ready(function(){
	
	Dropzone.options.hfPhotosForm = {
		maxFilesize: 5,
		acceptedFiles:'.jpeg,.jpg,.png',
			init: function () {
			 	  this.on("success", function(file, responseText) {
					  if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0)
						   {
							  setTimeout(function(){
								  $('.dz-preview').remove();
								  },1500);
								  notiPop('success','Employee image uploaded successfully','')
							}
					refreshEmployeeList(responseText);
 				});
		  }
	};
	
	});
</script>
<?php } ?>