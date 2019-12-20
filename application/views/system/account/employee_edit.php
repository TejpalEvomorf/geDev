<?php
$loggedInUser=loggedInUser();
if($loggedInUser['user_type']==1)
{
$employeeDesignationList=employeeDesignationList();
$genderList=genderList();
$officeList=officeList();
?>


<div class="page-heading">
      <h1 id="accountPageHeading">Edit employee</h1>
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
$employeeList=otherEmployeesSameOffice($employee['id'],$employee['office']);
?>
<div class="col-md-3">
    <div class="panel panel-profile panel-bluegraylight" data-widget='{"draggable": "false"}'>
       <div class="panel-heading">
          <h2>Employee status</h2>
       </div>
       <div class="panel-body">
          <form id="empUpdateDesignationForm">
              <div class="form-group">
                <label for="designation" class="col-sm-2 control-label">Designation</label>
                <select name="designation" id="designationUpdateForm" class="form-control" required  onchange="updateEmpDesignation();">
                  <!--<option value="">Select one</option>-->
                  <?php foreach($employeeDesignationList as $eDK=>$eDV){?>
                      <option value="<?=$eDK?>" <?php if($employee['designation']==$eDK){echo 'selected="selected"';}?>><?=$eDV?></option>
                  <?php } ?>
              </select>
              </div>
              
              <div class="form-group">
                <label for="officeUpdateForm" class="col-sm-2 control-label">Office</label>
                <select name="office" id="officeUpdateForm" class="form-control" required  onchange="updateEmpOffice();">
                  <?php foreach($officeList as $oLK=>$oLV){?>
                      <option value="<?=$oLK?>" <?php if($employee['office']==$oLK){echo 'selected="selected"';}?>><?=$oLV?></option>
                  <?php } ?>
              </select>
              </div>
              
              <input type="hidden" name="id" id="empId_empUpdateDesignationForm" value="<?=$employee['id']?>"/>
          </form>
       </div>
    </div>
    
    <div class="panel panel-profile panel-bluegraylight" id="uploadEmpPhotoPanel" data-widget='{"draggable": "false"}'>
       <div class="panel-heading">
          <h2>Employee Photo</h2>
       </div>
       <div class="panel-body">
       
       <div id="uploadEmpPhotoImage">
         	<?php $this->load->view('system/account/employee_edit_page_photo');?>
         </div>
       
         <form id="uploadEmpPhotoForm" method="post"  action="<?=site_url()?>account/employee_image_upload" enctype="multipart/form-data">
            <input type="button" class="btn btn-primary btn-raised btn-sm" id="uploadEmpPhotoBtn" value="<?php if($employee['image']!=''){echo 'Change Photo';}else {echo 'Upload Photo';}?>" />
            <input type="file" id="picture" name="file"   style="display:none;">
            <input type="hidden" name="empId" id="empId" value="<?=$employee['id']?>" />
            <div id="progressbox" style="display:none;"><div id="progressbar"></div>Uploading <div id="statustxt" style="display:inline;">0%</div></div>
         </form>
       </div>
    </div>
    
</div>
<div class="col-md-9">

    <div class="tab-pane p-md panel panel-default" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">

    	<form class="tabular-form" id="editEmployeeForm">
        		<input type="hidden" name="id"  value="<?=$employee['id']?>">
                
                <div class="form-group width-fifty-left">
                    <label for="company_emailEdit" class="control-label">Company email id/Username</label>
                    <input type="text" class="form-control" id="company_emailEdit" name="company_email" placeholder="Email id" value="<?=$employee['email_company']?>" data-parsley-type="email" required >
                </div>
                
                 <div class="form-group width-fifty-right">
                  <label for="password" class="control-label">Password</label>
                  <input type="text" class="form-control" id="password" name="password"  value="<?=passDecrypt($employee['password'])?>" placeholder="Password" required>
				</div>
                
                <div class="form-group width-fifty-left">
                    <label for="name" class="control-label">First name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Fisrt name" value="<?=$employee['fname']?>" required>
                </div>
                
                <div class="form-group width-fifty-right">
                    <label for="name" class="control-label">Last name</label>
                    <input type="text" class="form-control" id="lname" name="lname" placeholder="Last name" value="<?=$employee['lname']?>" required>
                </div>
              
               <div class="form-group width-fifty-left">
                    <label for="phone" class="control-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone number" value="<?=$employee['phone']?>" required>
                </div>
               
                <div class="form-group width-fifty-right">
                    <label for="personal_emailEdit" class="control-label">Personal email id</label>
                    <input type="text" class="form-control" id="personal_emailEdit" name="personal_email" placeholder="Email id" value="<?=$employee['email_personal']?>" data-parsley-type="email">
                </div> 
               
               <div class="form-group width-fifty-left">
                  <label for="gender" class="control-label">Gender</label>
                  <select name="gender" id="gender" class="form-control" required>
                      <option value="">Select one</option>
                      <?php foreach($genderList as $gK=>$gV){?>
                      <option value="<?=$gK?>" <?php if($employee['gender']==$gK){echo 'selected="selected"';}?>><?=$gV?></option>
                      <?php } ?>
                  </select>
              </div>
               
                <div class="form-group width-fifty-right">
                    <label for="office_phone" class="control-label">Office phone extension</label>
                    <input type="text" class="form-control" id="office_phone" name="office_phone" placeholder="Office phone" value="<?=$employee['phone_office']?>">
                </div> 
         </form>
         <div class="row">
            <div class="col-sm-8">
                <button class="btn-raised btn-primary btn" id="submitBtnEditEmployee">Submit</button>
                <img src="<?=loadingImagePath()?>" id="editEmployeeFormProcess" style="display:none;">
            </div>
         </div>
    
    </div>
</div>
					</div>

	</div>
</div>
</div>

<script src="<?=static_url()?>system/jquery.form.min.js" type="application/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	
	$('#uploadEmpPhotoBtn').click(function(){
		  $('#picture').trigger('click');
		  });
		  
		  
		  $("#picture").change(function() {
			
			if (this.files && this.files[0]) 
			{
					if(!checkFileExt($(this).val()))
					  	notiPop('error','Only .jpg, .jpeg or .png files are allowed',"");
					else if(!checkFileSize($(this)[0].files[0].size))
					  	notiPop('error','Please select file less than 5MB',"");
					else
						   imageSize(this.files[0],100);
			}
        });
		
		
		function imageSize(image,imgWidth)
		{
			var _URL = window.URL || window.webkitURL;
			var file, img;
		    if ((file = image)) 
			{
        		img = new Image();
        		img.onload = function () 
				{
					  if(this.width>=imgWidth)
							$('#uploadEmpPhotoForm').submit();      
                  	  else
							 notiPop('error','Upload image that is minimum 100px wide',"");
        		};
        		img.src = _URL.createObjectURL(file);
    		}
			
		}
		
		 function checkFileExt(file)
		{
				var result=false;
				//var exts = ['gif','png','jpg','jpeg'];
				var exts = ['png','jpg','jpeg'];
			 
				if ( file ) {
									var get_ext = file.split('.');
									get_ext = get_ext.reverse();
										
									if ( $.inArray ( get_ext[0].toLowerCase(), exts ) > -1 )
											result=true;
									else 
											result=false;
							 }
				return result;			 
		}
		
function checkFileSize(fsize)
		{
			var result=false;
			if(fsize!='')
			{
				var size=eval(fsize/1048576)
				if(size>5)
					result=false;
				else
					result=true;
			}
			return result;
		}
		
		
		
		
		 
    var progressbox     = $('#progressbox');
	var progressbar     = $('#progressbar');
	var statustxt       = $('#statustxt');
	var completed       = '0%';
	
	var options = { 
			//target:   '#output',   // target element(s) to be updated with server response 
			beforeSubmit:  beforeSubmit,  // pre-submit callback 
			uploadProgress: OnProgress,
			success:       afterSuccess,  // post-submit callback 
			resetForm: true        // reset the form after successful submit 
		};
		
	$('#uploadEmpPhotoForm').submit(function() { 
			$(this).ajaxSubmit(options);  			
			// return false to prevent standard browser submit and page navigation 
			return false; 
		});		
		
		//when upload progresses	
	function OnProgress(event, position, total, percentComplete)
	{
		$('#uploadEmpPhotoImage').html('');
		statustxt.html(percentComplete + '%'); //update status text
	}	
	
	//after succesful upload
	function afterSuccess(data)
	{
		progressbox.hide();
		$('#uploadEmpPhotoImage').html(data);
		$('#uploadEmpPhotoBtn').val('Change Photo');
	}
	
	
	//function to check file size before uploading.
	  function beforeSubmit(){
		  //check whether browser fully supports all File API
		 if (window.File && window.FileReader && window.FileList && window.Blob)
		  {
	  
			  //Progress bar
			  progressbox.show(); //show progressbar
			  progressbar.width(completed); //initial value 0% of progressbar
			  statustxt.html(completed); //set status text
			  statustxt.css('color','#000'); //initial color of status text
	  	}
		  else
		  {
			  //Output error to older unsupported browsers that doesn't support HTML5 File API
			  alert("Please upgrade your browser, because your current browser lacks some new features we need!");
			  return false;
		  }
	  } 
		  
	});
</script>

<?php }?>