<?php
$clientCategories=clientCategories();
$stateList=stateList();
?>
<style type="text/css">
#clientList_filter
{
	margin:0 !important;
}
</style>
<div class="page-heading">
      <h1>Client list</h1>
      
        <div class="m-n DTTT btn-group pull-right">
              <a class="btn btn-default" id="clientFiltersBtn">
                  <i class="colorBlue fa fa-filter"></i> 
                  <span class="colorBlue">Filters</span>
              </a>
        </div>
        
        <div class="relposition panel-ctrls pull-right" id="clientPanelCtrls">
             <div class="m-n DTTT btn-group pull-right" id="clientSearchBtn">
             	<a class="btn btn-default">
                   <i class="colorBlue fa fa-search"></i>
                   <span class="colorBlue">Search</span>
                </a>
			 </div>
         </div>
       	 <div class="options"></div>
</div>


<?php
if(isset($_GET['clientCategory']) && ($_GET['clientCategory']!='')){?>
<div class="filterbtnhol">
<button class="mt-n btn btn-xs btn-danger btn-label clientRemoveFilter pull-right" href="#" filter="all">
<i class="fa fa-close"></i>
Reset filters
</button>
	<?php if($_GET['clientCategory']!=''){
				$clientCategory=$clientCategories[$_GET['clientCategory']];
		?>
        <button class="mt-n btn btn-xs btn-danger btn-label clientRemoveFilter pull-right" href="#" filter="clientCategory">
<i class="fa fa-close"></i>
<?=$clientCategory?>
</button>
<?php }?>
</div>
<?php } ?>

<div class="container-fluid">
    <div data-widget-group="group1">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body no-padding">
                        <table id="clientList" class="noborder0 table table-striped table-bordered table-fixed-header m-n" cellspacing="0" width="100%">
                          <thead>
                              <tr>
	                              <th>Logo</th>	
                                  <th>Business</th>
                                  <th>Contact</th>
                                  <th width="120px">Client type</th>
                                  <th width="300px">Agreement</th>
                                  <th width="60px" >Actions</th>
                              </tr>
                          </thead>
                          <tbody>
                               
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="model_deleteClientProcess" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-dialog">

 	 <div class="modal-content">

 		 <div class="modal-header">

 			 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

 			 <h2 class="modal-title">Delete</h2>
		</div>

 		 <div class="modal-body">

 			 <img src="<?=loadingImagePath()?>" height="150" style="margin: 0px 39%;"">

 		 </div>

 		 <div class="modal-footer">

 		</div>

 	 </div><!-- /.modal-content -->

  </div><!-- /.modal-dialog -->

</div><!-- /.modal -->



<div class="modal fade" id="model_deleteClient" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-dialog">

 	 <div class="modal-content">

 		 <div class="modal-header">

 			 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

 			 <h2 class="modal-title">Delete</h2>

 			 <h5>This client cannot be deleted. Following is the list of student applications that are assigned to this client.</h5>
             <h5>Please assign different client to these appliations to be able to delete this client.</h5>

 		 </div>

 		 <div class="modal-body" id="delClient_shaListDiv">

 			 

 		 </div>

 		 <div class="modal-footer">

 		</div>

 	 </div><!-- /.modal-content -->

  </div><!-- /.modal-dialog -->

</div><!-- /.modal -->

<form id="clientFiltersFormHidden">
<?php
if(isset($_GET['clientCategory']) && $_GET['clientCategory']!='')
	$clientCategory=$_GET['clientCategory'];
else
	$clientCategory='';	
?>
	<input type="hidden" name="clientCategory" value="<?=$clientCategory?>" />
</form>
<script>
var clientCategory='<?=$clientCategory?>';

</script>
