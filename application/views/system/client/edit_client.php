<?php
$stateList=stateList();
$clientCategories=clientCategories();
$clientGroupList=clientGroupList();
?>
<div class="page-heading"><h1>Edit client</h1></div>

<div class="container-fluid">
                                
<div data-widget-group="group1">
	<div class="row">
    
      <div class="col-md-3">
          <div class="panel panel-profile panel-bluegraylight" data-widget='{"draggable": "false"}'>
          <div class="panel-heading">
                                          <h2>Client Type</h2>
                                      </div>
              <div class="panel-body">
                  <form id="updateClientCategoryForm" action="<?=site_url()?>client/updateClientCategory" method="post">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="category">Type</label>
                        <select class="form-control" id="category" name="category" onchange="updateClientCategory('category');$('#clientCategory').val(this.value);" required>
		                        <!--<option value="">Select one</option>-->
                                <?php foreach($clientCategories as $catK=>$catV){?>	
                                   <option value="<?=$catK?>" <?php if($client['category']==$catK){echo 'selected="selected"';}?>><?=$catV?></option>
                                <?php } ?>
                        </select>
                        <input type="hidden" name="id" value="<?=$client['id']?>" />
                    </div>
                    
                    <div class="form-group client-checkbox" id="create_client_commissionDiv" <?php if($client['category']!='2'){?>style="display:none;"<?php } ?>>
					
						<div class="checkbox checkbox-primary">
							<label>
								<input type="checkbox" name="commission" id="commission" <?php if($client['commission']=='1'){?>checked<?php } ?> onclick="updateClientCategory('commission');">
								This agent is enrolled for commission program
							</label>
						</div>
                        
                        <div id="create_client_commissionValDiv"  <?php if($client['commission']=='0'){?>style="display:none;"<?php } ?>>
                            <label>Enter commission rate($)</label>
                            <input id="commission_value" value="<?php if($client['commission_val']!=0){echo $client['commission_val'];}else{echo 50;}?>"  name="commission_value"  onchange="updateClientCategory('commission_val');" required data-parsley-type="number">
                        </div>
				</div>
                
                    <div class="form-group client-checkbox" id="create_client_GroupInvDiv" <?php if($client['category']!='3' && $client['category']!='4'){?>style="display:none;"<?php } ?>>
					
						<div class="checkbox checkbox-primary">
							<label>
								<input type="checkbox" name="groupInvEnroll" id="groupInvEnroll"  onclick="updateClientCategory('groupInvEnroll');" <?php if($client['group_invoice']=='1'){?>checked<?php } ?>>
								This client is enrolled for group invoices
							</label>
						</div>
                        
                        <div id="create_client_GroupInvValDiv" class="checkbox checkbox-primary child" <?php if($client['group_invoice']=='0'){?>style="display:none;"<?php } ?>>
                        	<label>
								Options for invoices
							</label><br />
                            <label style="margin-bottom:5px;">
								<input type="checkbox" name="groupInvEnrollPlacementFee" id="groupInvEnrollPlacementFee"  <?php if($client['group_invoice_placement_fee']=='1' || $client['group_invoice']=='0'){?>checked<?php } ?>  onclick="updateClientCategory('groupInvEnrollPlacementFee');">
								Placement fee
							</label><br />
                            <label>
								<input type="checkbox" name="groupInvEnrollAPU" id="groupInvEnrollAPU"  <?php if($client['group_invoice_apu']=='1' || $client['group_invoice']=='0'){?>checked<?php } ?>  onclick="updateClientCategory('groupInvEnrollAPU');">
								APU
							</label><br />
                            <label>
								<input type="checkbox" name="groupInvEnrollAccomodationFee" id="groupInvEnrollAccomodationFee"   <?php if($client['group_invoice_accomodation_fee']=='1' || $client['group_invoice']=='0'){?>checked<?php } ?>  onclick="updateClientCategory('groupInvEnrollAccomodationFee');">
								Accomodation fee
							</label>
                        </div>
				</div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="clientGroup">Group</label>
                        <select class="form-control" id="clientGroup" name="clientGroup" onchange="updateClientGroup();">
		                        <option value="">Select one</option>
                                <?php foreach($clientGroupList as $groupK=>$groupV){?>	
                                   <option value="<?=$groupK?>" <?php if($client['client_group']==$groupK){echo 'selected="selected"';}?>><?=$groupV?></option>
                                <?php } ?>
                        </select>
                    </div>
                    
                  </form>
              </div>
          </div>
          
          <div class="panel panel-profile panel-bluegraylight" id="uploadClientLogoPanel" data-widget='{"draggable": "false"}'>
       <div class="panel-heading">
          <h2>Client Logo</h2>
       </div>
       <div class="panel-body">
       
       <div id="uploadClientLogoImage">
         	<?php $this->load->view('system/client/client_edit_page_logo');?>
         </div>
       
         <form id="uploadClientLogoForm" method="post"  action="<?=site_url()?>client/client_logo_upload" enctype="multipart/form-data">
            <input type="button" class="btn btn-primary btn-raised btn-sm" id="uploadClientLogoBtn" value="<?php if($client['image']!=''){echo 'Change Logo';}else {echo 'Upload Logo';}?>" />
            <input type="file" id="picture" name="file"   style="display:none;">
            <input type="hidden" name="clientId" id="clientId-Logo" value="<?=$client['id']?>" />
            <div id="progressbox" style="display:none;"><div id="progressbar"></div>Uploading <div id="statustxt" style="display:inline;">0%</div></div>
         </form>
       </div>
    </div>
          
                <div class="panel panel-profile panel-bluegraylight">
                    <div class="panel-heading">
                        <h2>UPLOAD AGREEMENT</h2>
                    </div>
                    <div class="panel-body">
                        <form action="<?=site_url()?>client/client_agreement_upload" id="hf-photos-form" class="dropzone">
                            <input type="hidden" name="clientId" id="clientId" value="<?=$client['id']?>" />
                        </form>
                    </div>
                </div>
                
                <div class="panel panel-profile panel-bluegraylight" id="clientAgreements">
                <?php $this->load->view('system/client/agreement_list');?>
                 </div>                 
      </div>
    
	<div class="col-sm-9">
			
			<div class="panel panel-primary" data-widget='{"draggable": "false"}'>
				<div class="panel-body">
							
							<form class="" id="formCreateClient">
                            <div class="form-group width-fifty-left">
								<label for="bname" class="control-label">Business name</label>
								<input type="text" class="form-control" id="bname" name="bname" value="<?=$client['bname']?>" placeholder="Business name" required>
							</div>
							<div class="form-group width-fifty-right">
								<label for="abn" class="control-label">ABN</label>
								<input type="text" class="form-control" id="abn" name="abn" value="<?=$client['abn']?>"  placeholder="ABN">
							</div>
							
                            <div class="form-group width-full">
                            	<label for="address" class="control-label">Street address</label>
								<input type="text" class="form-control" id="address" name="address" value="<?=$client['street_address']?>"  placeholder="Street address" >
							</div>
                            
                            <div class="form-group width-fifty-left">
                            	<label for="suburb" class="control-label">Suburb</label>
								<input type="text" class="form-control" id="suburb" name="suburb" value="<?=$client['suburb']?>"  placeholder="Suburb" >
							</div>
							
                          <div class="form-group width-fifty-right">
                              <label class="col-sm-2 control-label" for="state">State</label>
                              <input type="text" class="form-control" id="state" name="state"  placeholder="State" value="<?=$client['state']?>">
                              <!--<select class="form-control" id="state" name="state">
	                              <option value="">Select one</option>
                                <?php foreach($stateList as $stateK=>$stateV){?>
                                          <option value="<?=$stateK?>" <?php if($client['state']==$stateK){echo 'selected="selected"';}?>><?=$stateV?></option>
                                <?php } ?>
                              </select>-->
                          </div>
                          
                          <div class="form-group width-fifty-left" style="clear:both;">
                              <label class="col-sm-2 control-label" for="country">Country</label>
                              <input type="text" class="form-control" id="country" name="country"  placeholder="Country" value="<?=$client['country']?>">
                          </div>
                          
                          <div class="form-group width-fifty-right">
                            	<label for="postal_code" class="control-label">Postcode</label>
								<input type="text" class="form-control" id="postal_code" name="postal_code" value="<?php if($client['postal_code']!=0){echo $client['postal_code'];}?>"  placeholder="Postcode" >
						 </div>
                            
							<div class="form-group width-fifty-left">
								<label for="p_name" class="control-label">Primary contact first name</label>
                                <input type="text" class="form-control" id="p_name" name="p_name"  value="<?=$client['primary_contact_name']?>" placeholder="First name" required>
							</div>
                            
                            <div class="form-group width-fifty-right">
								<label for="p_lname" class="control-label">Primary contact last name</label>
                            	<input type="text" class="form-control" id="p_lname" name="p_lname"  value="<?=$client['primary_contact_lname']?>"  placeholder="Last name" required>
                            </div>
                            
                            <div class="form-group width-fifty-left">
								<label for="p_phone" class="control-label">Primary contact phone</label>
								<input type="text" class="form-control" id="p_phone" name="p_phone"  value="<?=$client['primary_phone']?>"  placeholder="Primary contact phone" required>
							</div>
							
                            <div class="form-group width-fifty-right">
								<label for="p_email" class="control-label">Primary contact email</label>
								<input type="text" class="form-control" id="p_email" name="p_email"   value="<?=$client['primary_email']?>" placeholder="Primary contact email" data-parsley-type="email" required>
							</div>
							
							<div class="form-group width-fifty-left">
								<label for="s_name" class="control-label">Secondary contact first name</label>
								<input type="text" class="form-control" id="s_name" name="s_name"  value="<?=$client['sec_contact_name']?>"  placeholder="Secondary contact first name">
							</div>
                            <div class="form-group width-fifty-right">
								<label for="s_lname" class="control-label">Secondary contact last name</label>
								<input type="text" class="form-control" id="s_lname" name="s_lname"  value="<?=$client['sec_contact_lname']?>"  placeholder="Secondary contact last name">
							</div>
                            
                            <div class="form-group width-fifty-left">
								<label for="s_phone" class="control-label">Emergency contact phone</label>
								<input type="text" class="form-control" id="s_phone" name="s_phone"   value="<?=$client['sec_phone']?>" placeholder="Emergency contact phone">
							</div>
                            
                            <div class="form-group width-fifty-right">
								<label for="abn" class="control-label">Secondary contact email</label>
								<input type="text" class="form-control" id="s_email" name="s_email"   value="<?=$client['sec_email']?>"  placeholder="Secondary contact email" data-parsley-type="email">
							</div>
                            
                             <div class="form-group" style="clear:both;">
								<label class="control-label">Notes</label>
								<textarea  rows="4" class="form-control" id="notes" name="notes"><?=$client['notes']?></textarea>
							</div>
                            
                            <input type="hidden" name="category" id="clientCategory" value="<?=$client['category']?>" />
                            <input type="hidden" name="id" id="id" value="<?=$client['id']?>" />
                            </form>
						</div>
						
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-sm-8">
                                    <button class="btn-raised btn-primary btn" id="submitBtnCreateClient">Submit</button>
                                    <img src="<?=loadingImagePath()?>" id="formCreateClientProcess" style="display:none;">
                                </div>
                            </div>
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
<script src="<?=static_url()?>system/jquery.form.min.js" type="application/javascript"></script>
<script type="text/javascript">

$(document).ready(function(){
	
	setTimeout(function(){
		$('#updateClientCategoryForm #category').parents('.form-group').find('ul').hide();
		},500);
	
	
	$("input#commission_value").TouchSpin({
		  verticalbuttons: true,
		  min: 1
		});
		
	$('#category')	.change(function(){
		if($(this).val()=='2')
		{
			$('#create_client_commissionDiv').slideDown();
			$('#create_client_GroupInvDiv, #create_client_GroupInvValDiv').slideUp();
			$('#groupInvEnroll').prop('checked', false);
		}
		else if($(this).val()=='3' || $(this).val()=='4')
		{
			$('#create_client_GroupInvDiv').slideDown();
			$('#create_client_commissionDiv, #create_client_commissionValDiv').slideUp();
			$('#commission').prop('checked', false);
		}
		else	
		{
			$('#create_client_commissionDiv, #create_client_commissionValDiv').slideUp();
			$('#create_client_GroupInvDiv, #create_client_GroupInvValDiv').slideUp();
			$('#commission').prop('checked', false);
			$('#groupInvEnroll').prop('checked', false);
		}
	});
	
	$('#commission').click(function(){
		if($(this).is(':checked'))
			$('#create_client_commissionValDiv').slideDown();
		else
			$('#create_client_commissionValDiv').slideUp();
	});
	
	$('#groupInvEnroll').click(function(){
		if($(this).is(':checked'))
			$('#create_client_GroupInvValDiv').slideDown();
		else
			$('#create_client_GroupInvValDiv').slideUp();
	});
	
	
	var tabToOpen = window.location.hash;
    if (tabToOpen != '' && tabToOpen == '#clientCreated') {
      notiPop('success','Client added successfully','')
      window.location.hash = '';
    }
	
	Dropzone.options.hfPhotosForm = {
		maxFilesize: 5,
		acceptedFiles:'.pdf,.PDF,.docx,.xlsx,.jpeg,.jpg,.png,.JPG,.JPEG',
			init: function () {
			 	  this.on("success", function(file, responseText) {
					  if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0)
						   {
							  setTimeout(function(){
								  $('.dz-preview').remove();
								  },1500);
								  notiPop('success','Agreement uploaded successfully','')
								  $('#clientAgreements').html(responseText);
							}
				});
		  }
	};
	
	
	/////////////Upload Logo #STARTS
	$('#uploadClientLogoBtn').click(function(){
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
							$('#uploadClientLogoForm').submit();      
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
		
	$('#uploadClientLogoForm').submit(function() { 
			$(this).ajaxSubmit(options);  			
			// return false to prevent standard browser submit and page navigation 
			return false; 
		});
		
	//when upload progresses	
	function OnProgress(event, position, total, percentComplete)
	{
		$('#uploadClientLogoImage').html('');
		statustxt.html(percentComplete + '%'); //update status text
	}	
	
	//after succesful upload
	function afterSuccess(data)
	{
		progressbox.hide();
		$('#uploadClientLogoImage').html(data);
		$('#uploadClientLogoBtn').val('Change Logo');
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
	/////////////Upload Logo #ENDS
	
	});
</script>