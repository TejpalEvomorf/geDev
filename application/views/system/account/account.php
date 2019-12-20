<?php
$employeeDesignationList=employeeDesignationList();
?>
<style type="text/css">
#employeeList_filter
{
	margin:0 !important;
}
</style>
<div class="page-heading" style="margin-bottom:0;">
      <h1 id="accountPageHeading">My Account</h1>
      
     <div class="m-n DTTT btn-group pull-right"  id="addNewEmployeeTab">
              <a class="btn btn-default" href="<?=site_url()?>account/new_employee">
                  <i class="colorBlue fa fa-plus"></i> 
                  <span class="colorBlue" onclick="">Add new employee</span>
              </a>
        </div>
        
        <div class="relposition panel-ctrls pull-right" id="empPanelCtrls" style="display:none">
             <div class="m-n DTTT btn-group pull-right" id="empSearchBtn">
             	<a class="btn btn-default">
                   <i class="colorBlue fa fa-search"></i>
                   <span class="colorBlue">Search</span>
                </a>
			 </div>
         </div>
        
</div>

<div class="container-fluid">
                                 
<div data-widget-group="group1">
	<div class="row">
	<div class="ge-app-submenu col-md-12 pl-n pr-n ul-tabs">
			<ul class="nav nav-tabs material-nav-tabs mb-lg">
				<li  id="myAccountTab" class="active"><a href="#tab-8-1" data-toggle="tab" onClick="$('#addNewEmployeeTab, #empPanelCtrls').hide();$('#accountPageHeading').text($(this).text());history.pushState(null, null, '/manager/account#tab-8-1');"> My Account </a></li>
				
				<?php if($loggedInUser['user_type']==1){?>
                <li id="employeeTab"><a href="#tab-8-2" data-toggle="tab" onClick="$('#addNewEmployeeTab, #empPanelCtrls').show();$('#accountPageHeading').text($(this).text());history.pushState(null, null, '/manager/account#tab-8-2');"> Employee List</a></li>
                <?php } ?>
                
			</ul>
    </div>

					<div class="p-n col-md-12 tab-content">
						<div class="tab-pane active" id="tab-8-1">
                       	<?php $this->load->view('system/account/my_account');?> 
                       </div>
						
                        <?php if($loggedInUser['user_type']==1){?>
                        <div class="tab-pane" id="tab-8-2">	
                        	<div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body no-padding">
                                            <table id="employeeList" class="noborder0 table table-striped table-bordered m-n" cellspacing="0" width="100%">
                                                <?php $this->load->view('system/account/employee_list');?> 		
                                            </table>
                                        </div>
                                    <div class="panel-footer"></div>
                                    </div>
                                </div>
						</div>
                        <div class="tab-pane" id="tab-8-3">
							<?php $this->load->view('system/account/employee_add_new');?> 					
						</div>
                        <?php } ?>
                    </div>

	</div>
</div>
</div>

<div class="modal fade" id="model_assignDiffEmpToApp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="model_assignDiffEmpToAppContent">
      	</div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script type="text/javascript">

$(document).ready(function(){
	
	var tabToOpen=window.location.hash;
	if(tabToOpen!='')
	{
		$('.nav-tabs a[href="'+tabToOpen+'"]').tab('show');
		if(tabToOpen=='#tab-8-2')
		{
			$('#addNewEmployeeTab, #empPanelCtrls').show();
			$('#accountPageHeading').text('Employee List');
		}
	}

	
	Dropzone.options.hfPhotosForm = {
		maxFilesize: 5,
		acceptedFiles:'.jpeg,.jpg,.png,.JPG,.JPEG',
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