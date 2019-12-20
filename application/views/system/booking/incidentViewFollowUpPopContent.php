<style type="text/css">
.incidentFollowUp_accordion{
    visibility: visible !important;
    opacity: 1;
    display: block;
    transform: translateY(0px);	
}
</style>

<div class="col-md-12 custom-accordion">
    <div class="mb-n panel-group panel-default" id="incidentFollowUpAccordionPop">
    <?php
    foreach($followUps as $fuK=>$fu)
    {
    ?>
    
    <div class="incidentFollowUp_accordion panel panel-default">
    <div class="media-body pb-md">
    	<a data-toggle="collapse" data-parent="#incidentFollowUpAccordionPop" href="#collapseIncidentFollowUpAccordionPop-<?=$fuK?>">
            <div class="panel-heading">
            <h5 style="font-weight: bold;" class="media-heading" id="followUpHeader-<?=$fu['id']?>"><?=viewFollowUpHeader($fu)?>
            </h5>
            </div>
        </a>
    </div>
    <div id="collapseIncidentFollowUpAccordionPop-<?=$fuK?>" class="collapse <?php if($fuK=='0'){echo " in";}?>">
    
      <div class="panel-body">
      
      <div class="m-n form-group">
    	<label class="control-label">Incident follow up</label>
      	<textarea  rows="4" class="form-control bookIncident_followUp" id="bookIncident_followUp-<?=$fu['id']?>" required><?=$fu['text']?></textarea>
	  </div> 

      </div>
    </div>
    </div>
    <?php } ?>
    </div>
</div>

<div class="incidentFollowUp-addBtnDiv" style="margin-top:10px;width:100%;display:inline-block;">
<button class="btn-raised btn-primary btn btn-sm" onClick="$('#model_bookingIncidentViewFollowUp').modal('toggle');bookingIncidentAddFollowUpPopContent(<?=$incident_id?>);">Add new follow up</button> 
</div>