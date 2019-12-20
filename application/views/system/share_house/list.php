<?php
$shaStatusList=sharedHousesStatusList();
?>
<style type="text/css">
#shaList_filter
{
  margin:0 !important;
}
</style>

<div class="page-heading">
  <h1>
    <?php //die($house_status_page);
    if($house_status_page!="share_house_all")
    {
      echo $shaStatusList[$house_status_page];
      if($house_status_page=='new' || $house_status_page=='share_house_new')
        echo " applications";
    }
    else
      echo "All applications";;
    ?>
  </h1>

  <div class="m-n DTTT btn-group pull-right"  id="">
    <a class="btn btn-default" href="<?php echo site_url();?>houses/application_create" target="_blank">
      <i class="colorBlue fa fa-plus"></i> 
      <span class="colorBlue" onclick="">Add new</span>
    </a>
  </div>

  <div class="m-n DTTT btn-group pull-right">
    <a class="btn btn-default" id="shareHouseFiltersBtn">
      <i class="colorBlue fa fa-filter"></i> 
      <span class="colorBlue">Filters</span>
    </a>
  </div>

  <div class="relposition panel-ctrls pull-right" id="shaPanelCtrls">
    <div class="m-n DTTT btn-group pull-right" id="shaSearchBtn">
      <a class="btn btn-default">
       <i class="colorBlue fa fa-search"></i>
       <span class="colorBlue">Search</span>
     </a>
   </div>
 </div>
 <div class="options"></div>
</div>

<?php
if((isset($_GET['appStep']) && ($_GET['appStep']=='partial' || $_GET['appStep']=='complete')) || (isset($_GET['placement']) && ($_GET['placement']=='placed' || $_GET['placement']=='not_placed'))){?>
<div class="filterbtnhol">
  <button class="mt-n btn btn-xs btn-danger btn-label hfaRemoveFilter pull-right" href="#" filter="all">
    <i class="fa fa-close"></i>
    Reset filters
  </button>
  <?php if(isset($_GET['appStep']) &&($_GET['appStep']=='partial' ||$_GET['appStep']=='complete')){
    if($_GET['appStep']=='partial')
      $appStep="Partially filled";
    elseif($_GET['appStep']=='complete')
      $appStep="Complete";
    ?>
    <button class="mt-n btn btn-xs btn-danger btn-label hfaRemoveFilter pull-right" href="#" filter="appStep">
      <i class="fa fa-close"></i>
      <?=$appStep?>
    </button>
    <?php }?>
    
    <?php if(isset($_GET['placement']) &&($_GET['placement']=='placed' ||$_GET['placement']=='not_placed')){
      if($_GET['placement']=='placed')
        $placement="Already placed";
      elseif($_GET['placement']=='not_placed')
        $placement="Not placed yet";
      ?>
      <button class="mt-n btn btn-xs btn-danger btn-label hfaRemoveFilter pull-right" href="#" filter="placement">
        <i class="fa fa-close"></i>
        <?=$placement?>
      </button>
      <?php }?>
    </div>
    <?php } ?>

    <div class="container-fluid">
      <div data-widget-group="group1">
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default">
          <!--<div class="panel-heading">
            <h2>Data Tables</h2>
          </div>-->
          <div class="panel-body no-padding">
            <table id="shareHouseList" class="noborder0 table table-striped table-bordered table-fixed-header m-n" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th width="300px">Student</th>
                  <th width="">Service type</th>
                  <th width="100px">Sumitted</th>
                  <th width="210px">Status</th>
                  <th width="100px">Office use</th>
                  <th width="60px">Actions</th>
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
<div class="modal fade" id="model_ChangeStatusSha" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h2 class="modal-title">Change application status</h2>
      </div>

      <div class="modal-body">
        <form id="shaChangeStatus_form"></form>                
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-raised" id="shareHouseChangeStatusSubmit">Save</button>
        <img src="<?=loadingImagePath()?>" id="shaChangeStatusProcess" style="margin-right:16px;display:none;">
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</div>



<div class="modal fade" id="model_sendCompletionEmail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h2 class="modal-title">Email completion link</h2>
      </div>

      <div class="modal-body">
        <form id="model_sendCompletionEmail_form" data-parsley-validate></form>                
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-raised" id="sendCompletionEmailSubmit" onclick="sendEmailHalfApplicationSha();">Send</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</div>

<?php if($house_status_page=="confirmed"){?> 
<div class="modal fade" id="model_rescheduleVisit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h2 class="modal-title">Reschedule Visit</h2>
      </div>

      <div class="modal-body">
        <form id="model_rescheduleVisit_form" data-parsley-validate></form>                
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-raised" id="rescheduleVisitSubmit" >Reschedule</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</div>    
<?php } ?>

<!--Study tour pop up #STARTS-->
<div class="modal fade" id="model_ShaStudyTourInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        This application is a part of tour group: <h2 class="modal-title">Name</h2>
      </div>

      <div class="modal-body">
        <em>This application can only be managed through the above mentioned tour group section.</em>
        <button type="button" class="btn btn-success btn-raised">Manage applications</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</div>     
<!--Study tour pop up #ENDS-->

<form id="houseFiltersFormHidden">
  <input type="hidden" name="status" value="<?php echo $house_status_page;?>" />
</form>

<script type="text/javascript">
  var house_status_page='<?php echo $house_status_page?>';

  $(document).ready(function(){
    var tabToOpen=window.location.hash;
    if(tabToOpen!='' && tabToOpen=='#applicationCreated')
    {
      notiPop("success","Application created successfully","");
      window.location.hash = '';
    }
  });
</script>