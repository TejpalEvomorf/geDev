<?php
$hfaStatusList=hfaStatusList();
if($status!='approved' && $status!='unavailable')
	unset($hfaStatusList['unavailable']);
$do_not_useOptions=do_not_useOptions();
$loggedInUser=loggedInUser();

?>
                      <div class="m-n form-group">
                          <label class="control-label">Status</label>
                              <select class="form-control" id="hfaChangeStatus_status" name="hfaChangeStatus_status">
                                  <?php foreach($hfaStatusList as $sK=>$sV){
									   if($status=='new' && ($sK=='approved'))
									  	continue;
									   if(($status=='no_response' || $status=='confirmed') && ($sK=='new' || $sK=='approved'))
									  	continue;
									  if($status=='pending_approval' && ($sK=='new'))
									  	continue;
									  if($status=='approved' && ($sK=='new' || $sK=='no_response' || $sK=='confirmed' || $sK=='pending_approval'))
									  	continue;
									 if($status=='do_not_use' && (  $sK=='approved'))
									  	continue;	
										?>
                                              <option value="<?=$sK?>" <?php if($status==$sK){echo 'selected="selected"';}?>><?=$sV?></option>
                                          <?php } ?>
                              </select>
                      </div>
                      
                         
                                            
                      <div class="pl-n m-n form-group col-xs-6"  id="hfaChangeStatus_dateDiv" <?php if($status!='confirmed'){?>style="display:none;"<?php } ?>>
  <label class="control-label">Visit date</label>
      <div class="input-group date">
          <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
          <input type="text" class="form-control"  name="hfaChangeStatus_date" id="hfaChangeStatus_date" value="<?php if($visit_date_time!='0000-00-00 00:00:00'){echo date('d/m/Y',strtotime($visit_date_time));}?>">
      </div>
</div>
                      
                     <div class="pr-n m-n form-group" id="hfaChangeStatus_timeDiv" <?php if($status!='confirmed'){?>style="display:none;"<?php } ?>>
  <label class="control-label">Visit time</label>
  <div class="input-group bootstrap-timepicker">
          <div class="input-group-addon"><i class="colorDarkgreen material-icons">query_builder</i></div>
          <input type="text" class="form-control" id="hfaChangeStatus_time"  name="hfaChangeStatus_time" value="<?php if($visit_date_time!='0000-00-00 00:00:00'){echo date('h:i A',strtotime($visit_date_time));}?>">
	</div>
</div>


<div class="pr-n m-n form-group" id="hfaChangeStatus_visitorDiv" <?php if($status!='confirmed'){?>style="display:none;"<?php } ?>>
  <label class="control-label">Name of person who is visiting this family</label>
          <input type="text" class="form-control" id="hfaChangeStatus_visitor"  name="hfaChangeStatus_visitor" value="<?php if(trim($visitor_name)!=''){echo trim($visitor_name);}else{if($status!='confirmed'){echo ucwords($loggedInUser['fname'].' '.$loggedInUser['lname']);}}?>">
</div>

<div class="m-n form-group" id="hfaChangeStatus_commentDiv"  <?php if($status!='confirmed'){?>style="display:none;"<?php } ?>>
<label class="control-label">Comments</label>
<textarea class="form-control" name="hfaChangeStatus_comment">
<?=$comments?>
</textarea>
</div>
  
<div id="changeStatusDnuOptionsDiv" <?php if($status!='do_not_use'){?>style="display:none;"<?php } ?>>
        <div class="m-n form-group">
              <label class="control-label">Reason</label>
                  <select class="form-control" name="hfaChangeStatus_dnuReason" id="hfaChangeStatus_dnuReason">
                  <option value="">Select reason</option>
                      <?php foreach($do_not_useOptions as $dnuK=>$dnuV){?>
                                  <option value="<?=$dnuK?>" <?php if(isset($dnu) && $status=='do_not_use' && $dnuK==$dnu['reason']){echo 'selected="selected"';}?>><?=$dnuV?></option>
                              <?php } ?>
                  </select>
          </div>
          <div class="form-group m-n">
					<label class="control-label">Comments</label>
					<textarea class="form-control" name="hfaChangeStatus_dnuComment"><?php if(isset($dnu)){echo $dnu['comment'];}?></textarea>
			</div>
</div>                      
 
 <?php if($status=='approved' || $status=='unavailable'){
	 ?>
    <div id="changeStatusUnavailableOptionsDiv" <?php if($status!='unavailable'){?>style="display:none;"<?php } ?>>
        <div class="pl-n m-n form-group col-xs-6"  id="hfaChangeStatus_unavailableDateFromDiv">
          <label class="control-label">Unavailable From</label>
              <div class="input-group date">
                  <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
                  <input type="text" class="form-control"  name="hfaChangeStatus_unavailableDateFrom" id="hfaChangeStatus_unavailableDateFrom" value="<?php if(!empty($unavailable)){echo date('d/m/Y',strtotime($unavailable['date_from']));}?>">
              </div>
        </div>     
        <div class="pl-n m-n form-group col-xs-6"  id="hfaChangeStatus_unavailableDateToDiv">
          <label class="control-label">Unavailable To</label>
              <div class="input-group date">
                  <span class="input-group-addon"><i class="colorDarkgreen material-icons">date_range</i></span>
                  <input type="text" class="form-control"  name="hfaChangeStatus_unavailableDateTo" id="hfaChangeStatus_unavailableDateTo" value="<?php if(!empty($unavailable)){echo date('d/m/Y',strtotime($unavailable['date_to']));}?>">
              </div>
        </div>
        <div class="form-group m-n">
                <label class="control-label">Comments</label>
                <textarea class="form-control" name="hfaChangeStatus_unavailableComment"><?=$comments?></textarea>
        </div>
    </div>
<?php } ?>                                  
                      
       <input type="hidden" name="hfaChangeStatus_id" id="hfaChangeStatus_id" value="<?=$id?>" />
       <input type="hidden" name="pageStatus" value="<?=$pageStatus?>" id="pageStatus" />
	  <p id="shaChangeStatusApprovedInfoMsg" style="display:none;">Please make sure that you have reviewed and approved the WWCC and PL Insurance status.</p>      
<script type="text/javascript">
$(document).ready(function(){
	
	$('#hfaChangeStatus_time').timepicker({
			minuteStep: 15,
			defaultTime:'9:00 AM'
		});
		
		$('#hfaChangeStatus_date, #hfaChangeStatus_unavailableDateFrom,#hfaChangeStatus_unavailableDateTo').datepicker({
			orientation: "top",
			todayHighlight: true,
	    	startDate: "-0d",
			format:'dd/mm/yyyy',
			autoclose:true
		});
		
	});
</script>