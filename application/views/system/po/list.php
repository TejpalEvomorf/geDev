<style type="text/css">
/*
Full screen Modal 
*/
.fullscreen-modal .modal-dialog {
/*  width: 53%;
  height:45%;*/
}
.fullscreen-modal .modal-dialog .modal-content {
  height:100%;
}
</style>

<?php
//$initialInvoiceStatusList=initialInvoiceStatusList();
$invoiceSyncSummary=$this->session->flashdata('invoiceSyncSummary');
?>
<div class="page-heading">
      <h1><?php if($po_status=='1'){echo 'Pending';}elseif($po_status=='2'){echo 'Paid';}elseif($po_status=='3'){echo 'Partial';}elseif($po_status=='all'){echo 'All';}?> purchase orders</h1>
        
         <!--Sync button #STARTS-->
            <div class="m-n btn-group pull-right">
                <button class="btn btn-danger syncInitialInvoicesBtn" id="syncPoBtn"  data-toggle="modal" data-target="#model_syncPoXero" onclick="syncPoWithXero();">
                 <i class="material-icons" style="font-size:14px;">sync</i>Sync with Xero</button>
                <img src="<?=loadingImagePath()?>" id="syncPoProcess" style="display:none;margin: 8px 1px;">
            </div>
        <!--Sync status button #ENDS-->
        
        <div class="m-n DTTT btn-group pull-right">
            <a class="btn btn-default" id="poFiltersBtn">
                <i class="colorBlue fa fa-filter"></i> 
                <span class="colorBlue">Filters</span>
            </a>
        </div>
        
        <div class="relposition panel-ctrls pull-right" id="listTablePanelCtrls">
             <div class="m-n DTTT btn-group pull-right" id="listTableSearchBtn">
             	<a class="btn btn-default">
                   <i class="colorBlue fa fa-search"></i>
                   <span class="colorBlue">Search</span>
                </a>
			 </div>
         </div>
        <div class="options"></div>
        
</div>

<?php
$tile_POId=false;
if($pOFilter_number!='')
	$tile_POId=true;
$tile_POHost=false;
if($pOFilter_host!='')
	$tile_POHost=true;
$tile_POFrom=false;
if($poFrom!='' && isset($poFromCustom))
	$tile_POFrom=true;//$tile_POFrom=false;
$tile_POTo=false;
if($poTo!='' && isset($poToCustom))
	$tile_POTo=true;//$tile_POTo=false;
$tile_PODueDate=false;	
if($poDueDate!='')
	$tile_PODueDate=true;
$tile_POstudyTour=false;
if($pOFilter_studyTour!='')
	$tile_POstudyTour=true;
$tile_POOther=false;
if($pOFilter_other!='')
	$tile_POOther=true;			

if($tile_POId || $tile_POHost || $tile_POFrom || $tile_POTo || $tile_PODueDate || $tile_POstudyTour || $tile_POOther)	
{
?>
<div class="filterbtnhol">
  <button class="mt-n btn btn-xs btn-danger btn-label pORemoveFilter pull-right" href="#" filter="all">
    <i class="fa fa-close"></i> Reset filters
  </button>
     <?php if($tile_POId){?>
     <button class="mt-n btn btn-xs btn-danger btn-label pORemoveFilter pull-right" href="#" filter="number">
      <i class="fa fa-close"></i>
      <?='PO id: '.$pOFilter_number?>
    </button>
     <?php } ?>
     
     <?php if($tile_POHost){?>
     <button class="mt-n btn btn-xs btn-danger btn-label pORemoveFilter pull-right" href="#" filter="host">
      <i class="fa fa-close"></i>
      <?='Host: '.$pOFilter_host?>
    </button>
     <?php } ?>
     
     <?php if($tile_POTo){?>
     <button class="mt-n btn btn-xs btn-danger btn-label pORemoveFilter pull-right" href="#" filter="poTo">
      <i class="fa fa-close"></i>
      <?='To: '.dateFormat(normalToMysqlDate($poTo))?>
    </button>
     <?php } ?>
     
	 <?php if($tile_POFrom){?>
     <button class="mt-n btn btn-xs btn-danger btn-label pORemoveFilter pull-right" href="#" filter="poFrom">
      <i class="fa fa-close"></i>
      <?='From: '.dateFormat(normalToMysqlDate($poFrom))?>
    </button>
     <?php } ?>
     
	 <?php if($tile_PODueDate){?>
     <button class="mt-n btn btn-xs btn-danger btn-label pORemoveFilter pull-right" href="#" filter="poDueDate">
      <i class="fa fa-close"></i>
      <?='Due date: '.dateFormat(normalToMysqlDate($poDueDate))?>
    </button>
     <?php } ?>  
     
     <?php if($tile_POstudyTour){
		 $tile_tourDetail=tourDetail($pOFilter_studyTour)
		 ?>
     <button class="mt-n btn btn-xs btn-danger btn-label pORemoveFilter pull-right" href="#" filter="study_tour">
      <i class="fa fa-close"></i>
      <?='Tour group: '.$tile_tourDetail['group_name']?>
    </button>
     <?php } ?> 
    
    <?php if($tile_POOther){?>
     <button class="mt-n btn btn-xs btn-danger btn-label pORemoveFilter pull-right" href="#" filter="other">
      <i class="fa fa-close"></i>
      <?php
      	if($pOFilter_other=='1')
			echo "Tour group purchase orders";
		elseif($pOFilter_other=='2')
			echo "Non tour group purchase orders";
		elseif($pOFilter_other=='4')
			echo "Purchase orders moved to xero";		
		else
			echo "Purchase orders not moved to xero";			
      ?>
    </button>
     <?php } ?>                   
      
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
                        <table id="poList" class="noborder0 table table-striped table-bordered table-fixed-header m-n" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                        <th width="7%">PO no.</th>
                                        <th width="30%">Family</th>
                                        <th width="30%">Student</th>
                                        <th>PO details</th>
                                        <th width="10%">Office use</th>
                                        <th width="5%">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="panel-footer"></div>
                </div>
            </div>
        </div>
    </div>
</div>


			<div class="modal fade " id="model_movePoToXero" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h2 class="modal-title">Move to xero</h2>
							</div>
                            
                            <div id="model_movePoToXeroContentMove">
                                <div class="modal-body">
                                   Are you sure you wish to move this purchase order to Xero?
                                   <input type="hidden" id="movePoToXero_id" value="" />
                                   <input type="hidden" id="movePoToXero_pageStatus" value="<?=$po_status?>" />
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success btn-raised" id="movePoToXeroSubmit">Yes</button>
                                    <img src="<?=loadingImagePath()?>" id="movePoToXeroProcess" style="margin-right:16px;display:none;">
                                </div>
                            </div>
                            
                            <div id="model_movePoToXeroContentError" style="display:none;color:#e51c23;">
                            	 <div class="modal-body">
                                </div>
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-default btn-raised" onclick=" $('#model_movePoToXero').modal('toggle');">Close</button>
                                </div>
                            </div>
                            

						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->

			</div>
            
         
         <div class="modal fade fullscreen-modal " id="model_syncPoXero" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
                        <div class="modal-header">
                         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                         <h2 class="modal-title">Sync With Xero Successful</h2>
 		                 </div>
							<div class="modal-body">
                              <img src="<?=loadingImagePath()?>" id="syncPoPopProcess" height="150" style="margin: 0px 39%;"">
                              <div id="syncPoSuccess" class="syncPoSuccess" style="display:none;">
                              
                              <div class="warningRowParentSync">
                              <div class="warningRow">
                                <div class="warningColSnc" id="syncInvoicesUpToDate">All purchase orders data is already upto date</div>
                              </div>                              
                              </div>
                              
                              <div class="warningRowParentSync">
                              <div class="warningRow">
                                <div class="warningColSnc" id="syncInvoicesPartial"></div>
                              </div>                              
                              </div>
                              
                              <div class="warningRowParentSync">
                               <div class="warningRow">
                                <div class="warningColSnc"  id="syncInvoicesPartialUpdated"></div>
                              </div>
                              </div>
                              
                              <div class="warningRowParentSync">
                               <div class="warningRow">
                                <div class="warningColSnc"  id="syncInvoicesPaid"></div>
                              </div>
                              </div>
                              
                              </div>
                              
							</div>
							<div class="modal-footer">
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
		</div>

 
<form id="poFiltersFormHidden">
 <input type="hidden" name="number" value="<?=$pOFilter_number?>" />
 <input type="hidden" name="host" value="<?=$pOFilter_host?>" />
 <input type="hidden" name="study_tour" value="<?=$pOFilter_studyTour?>" />
 <input type="hidden" name="other" value="<?=$pOFilter_other?>" />
 <input type="hidden" name="poFrom" value="<?=$poFrom?>" />
 <input type="hidden" name="poTo" value="<?=$poTo?>" />
 <input type="hidden" name="poDueDate" value="<?=$poDueDate?>" />
</form>



<script type="text/javascript">
var po_status=<?=$po_status?>;
var number='<?=$pOFilter_number?>';
var host="<?=$pOFilter_host?>";
var study_tour="<?=$pOFilter_studyTour?>";
var other="<?=$pOFilter_other?>";
var poFrom="<?=$poFrom?>";
var poTo="<?=$poTo?>";
var poDueDate="<?=$poDueDate?>";

$(document).ready(function(){
	if('<?=$invoiceSyncSummary?>'!='')
		{
			var invoiceSyncSummary='<?=$invoiceSyncSummary?>';
			$('#model_syncPoXero').modal('toggle');
			$('#syncInvoicesUpToDate, #syncInvoicesPartial, #syncInvoicesPaid, #syncInvoicesPartialUpdated').hide();
			
			  var dataSplit=invoiceSyncSummary.split(',');
			  if(dataSplit[0]!=0)
				  $('#syncInvoicesPartial').text(dataSplit[0]+' PO(s) moved to partially paid PO(s)').show();
			  if(dataSplit[1]!=0)
				  $('#syncInvoicesPaid').text(dataSplit[1]+' PO(s) moved to Paid PO(s)').show();
			  if(dataSplit[2]!=0)
				  $('#syncInvoicesPartialUpdated').text(dataSplit[2]+' PO(s) updated in Partially paid PO(s)').show();
			 if(dataSplit[0]==0 && dataSplit[1]==0 && dataSplit[2]==0)
			  	$('#syncInvoicesUpToDate').show();
			  
				$('#syncPoPopProcess').hide();
				$('#syncPoSuccess').show();
			
		}
});
</script>