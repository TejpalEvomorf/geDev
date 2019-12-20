<?php
$clientsList=clientsList();
?>
<style type="text/css">
.form-group
{
	margin:0;
}
</style>

<ul class="nav nav-tabs material-nav-tabs stretch-tabs icon-tabs">
  <li class="active">
  <a class="prices-edit" href="javascript:;" data-toggle="tab">
      Filters
  </a></li>
  </ul>
  
<form id="invoiceFiltersForm">

	<div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Filter by Invoice number</label>
       <div class="form-group">
          <!--<label for="poFrom" class="control-label">Search by Invoice number</label>-->
          <div class="input-group">
          	  <span class="input-group-addon addon-invoiceNo">G-</span>
              <input class="form-control" name="number" placeholder="Enter invoice number" value="<?=$_POST['number']?>" type="text">
          </div>
          <h4 style="margin:0 0 0 25px;"><small>Only enter the invoice number without I-</small></h4>
      </div>
      </div>      
      
      
     
     
     <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Filter by date range (based on invoice creation date)</label>  
      <div class="form-group">
         <!-- <label for="poFrom" class="control-label">Search by dates</label>-->
          <div style="width: 45%;float: left;">
              <input class="form-control" id="invoiceFrom" name="from" placeholder="From date" value="<?=$_POST['from']?>" type="text">
          </div>
          <div style="width: 45%;float: left;margin-left:20px;">
              <input class="form-control" id="invoiceTo" name="to" placeholder="To date" value="<?=$_POST['to']?>" type="text">
          </div>
      </div>
      
    </div>
    
    <div style="height:100px;"></div>
    
	<div class="noborder0 widget-body" id="generalFiltersBtnDiv">
   	 <input type="submit" value="Update" class="m-n btn btn-raised btn-info">
    </div>
</form>

<script type="text/javascript">
$(document).ready(function(){
	$('#invoiceFrom,#invoiceTo').datepicker({
							/*orientation: "top",*/
							format:'dd/mm/yyyy',
							autoclose:true
						});
});
</script>