<?php
$genderList=genderList();
?>
<div class="page-heading">
        <h1>
            Manage caregivers
            <small><?php echo $company['name']; ?></small>
        </h1>
        <div class="m-n DTTT btn-group pull-right" id="">
            <a href="#" class="btn btn-default" data-toggle="modal" data-target="#model_addCaregiver">
                <i class="colorBlue fa fa-plus"></i> 
                <span class="colorBlue">Add new caregiver</span>
            </a>
        </div>
</div>

<div class="container-fluid">
    <div data-widget-group="group1">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body no-padding">
                        <table id="manageCaregivers" class="noborder0 table table-striped table-bordered table-fixed-header m-n" cellspacing="0" width="100%">
                          <thead>
								<tr>
								  <th>Caregiver</th>
								  <th>Created</th>
								  <th width="60px">Actions</th>
								</tr>
							  </thead>
                  <tbody>
                      <?php foreach($caregivers as $cgK=>$cgV){ 
					  	$manageCGTd=manageCGTd($cgV);
					  ?>
                                          <tr id="caregiver-<?php echo $cgV['id'];?>" role="row" class="odd">
                                              <td class="caregiver-td1"><?=$manageCGTd['td1']?></td>
                                              <td><?=date('j M Y',strtotime($cgV['date']))?></td>
                                              <td>
                                                  <div class="btn-group dropdown table-actions">
                                                      <button class="btn btn-sm btn-midnightblue dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="true">
                                                          <i class="colorBlue material-icons">more_horiz</i>
                                                          <div class="ripple-container"></div>
                                                      </button>
                                                      <ul class="dropdown-menu" role="menu">
                                                          <!--<li><a href="javascript:void(0);" class="btn btn-default" data-toggle="modal" data-target="#model_editCaregiver"><i class="font16 material-icons" onClick="editCGgetPopContent(<?=$cgV['id']?>);">edit</i>&nbsp;&nbsp;Edit</a></li>-->
                                                          <li><a href="javascript:void(0);" data-toggle="modal" data-target="#model_editCaregiver" onClick="editCGgetPopContent(<?=$cgV['id']?>);"><i class="font16 material-icons">edit</i>&nbsp;&nbsp;Edit</a></li>
                                                          <li><a href="javascript:;" class="cgDelete" id="cgDelete-<?php echo $cgV['id'];?>"><i class="font16 material-icons">delete</i>&nbsp;&nbsp;Delete</a></li>
                                                      </ul>
                                                  </div>
                                              </td>
                                          </tr>
                                   <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer"></div>
                </div>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
  $(document).ready(function() {
    var tabToOpen = window.location.hash;
    if (tabToOpen != '' && tabToOpen == '#CGCreated') {
      notiPop('success',"New caregiver assigned to <?=$company['name']?> successfully",'');
      window.location.hash = '';
    }
  });
</script>

<!--Add new CG #STARTS-->
<div class="modal fade" id="model_addCaregiver" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h2 class="modal-title">Add new caregiver</h2>
        <small>This caregiver will be assigned to <b><?=$company['name']?></b></small>
      </div>
      <div class="modal-body">
        <form id="model_addCG_form">
        		
                		<div class="m-n form-group col-xs-6x">
                    	        <label class="control-label">Firstname</label>
					          <input type="text" class="form-control" id="addCG_fname"  name="addCG_fname" value="" required>
                        </div>
                          
                        <div class="m-n form-group col-xs-6y">
                            <label class="control-label">Lastname</label>
                            <input type="text" class="form-control" id="addCG_lname"  name="addCG_lname" value="" required>
                        </div>
                        
                        <div class="m-n form-group col-xs-6x">
                    	        <label class="control-label">Phone</label>
					          <input type="text" class="form-control" id="addCG_phone"  name="addCG_phone" value="" required>
                        </div>
                          
                        <div class="m-n form-group col-xs-6y">
                            <label class="control-label">Email</label>
                            <input type="text" class="form-control" id="addCG_email"  name="addCG_email" value="" data-parsley-type="email">
                        </div>
                        
                        <div class="m-n form-group" style="clear:both;">
                              <label class="control-label">Gender</label>
                                  <select class="form-control" id="addCG_gender" name="addCG_gender"  required>
                                  		<option value="">Select gender</option>
										<?php foreach($genderList as $gK=>$gV){?>
                                        <option value="<?=$gK?>"><?=$gV?></option>
                                        <?php } ?>
                                  </select>
                          </div>
  					<input type="hidden" id="company_id" name="company_id" value="<?=$company['id']?>">
                    <input type="hidden" id="company_name" name="company_name" value="<?=$company['name']?>">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-raised" id="addCG_submit">Submit</button>
        <img src="<?=loadingImagePath()?>" id="addCG_process" style="display:none;">
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
</div>
<!--Add new CG #ENDS-->


<!--Edit CG #STARTS-->
<div class="modal fade" id="model_editCaregiver" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h2 class="modal-title">Edit caregiver</h2>
        <small>This caregiver is assigned to <b><?=$company['name']?></b></small>
      </div>
      <div class="modal-body">
        <form id="model_editCG_form">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-raised" id="editCG_submit">Submit</button>
        <img src="<?=loadingImagePath()?>" id="editCG_process" style="display:none;">
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
</div>
<!--Edit CG #ENDS-->