<?php
$clientsList=clientsList();
$studyTourList=studyTourList();//see($studyTourList);
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
          	  <span class="input-group-addon addon-invoiceNo">I-</span>
              <input class="form-control" name="number" placeholder="Enter invoice number" value="<?=$_POST['number']?>" type="text">
          </div>
          <h4 style="margin:0 0 0 25px;"><small>Only enter the invoice number without I-</small></h4>
      </div>
      </div>      
      
      
     <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Filter by student name</label> 
      <div class="form-group">
          <!--<label for="poFrom" class="control-label">Search by student name</label>-->
          <div class="">
              <input class="form-control" name="student" placeholder="Enter student name" value="<?=$_POST['student']?>" type="text">
          </div>
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
    
    <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Show invoices specific to client</label>
    
      <div class="form-group">
          <!--<label for="poFrom" class="control-label">Search by client</label>-->
          <div class="">
                      <select name="client" class="form-control">
                          <option value="">Select One</option>
                          <?php foreach($clientsList as $cl){?>
                            <option value="<?=$cl['id']?>" <?php if($cl['id']==$_POST['client']){?>selected<?php }?>><?=$cl['bname']?></option>
                         <?php } ?>
                      </select>
          </div>
      </div>
      </div>
    
    <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Show invoices specific to tour group</label>
    
      <div class="form-group">
          <!--<label for="poFrom" class="control-label">Search by client</label>-->
          <div class="">
                      <select name="studyTour" class="form-control">
                          <option value="">Select One</option>
                          <?php foreach($studyTourList as $sTL){?>
                            <option value="<?=$sTL['id']?>" <?php if($sTL['id']==$_POST['studyTour']){?>selected<?php }?>><?=$sTL['group_name']?></option>
                         <?php } ?>
                      </select>
          </div>
      </div>
      </div>
      
      
      <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Show only:</label>
       <div class="radio block">
       		<label>
            	<input type="radio" name="other" value="1" <?php if(isset($_POST['other']) && $_POST['other']=="1"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Tour group invoices
            </label>
       </div>
       <div class="radio block">
       		<label>
            	<input type="radio" name="other" value="2" <?php if(isset($_POST['other']) && $_POST['other']=="2"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Non tour group invoices
            </label>
       </div>
       <?php if(isset($_POST['invoiceType']) && $_POST['invoiceType']=="initial"){?>  
       <div class="radio block">
       		<label>
            	<input type="radio" name="other" value="7" <?php if(isset($_POST['other']) && $_POST['other']=="7"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Invoices with warnings
            </label>
       </div>     
       <div class="radio block">
       		<label>
            	<input type="radio" name="other" value="3" <?php if(isset($_POST['other']) && $_POST['other']=="3"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Cancelled invoices
            </label>
       </div>
      <?php } ?> 
       <div class="radio block">
       		<label>
            	<input type="radio" name="other" value="4" <?php if(isset($_POST['other']) && $_POST['other']=="4"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Invoices moved to xero
            </label>
       </div>

       <div class="radio block">
       		<label>
            	<input type="radio" name="other" value="5" <?php if(isset($_POST['other']) && $_POST['other']=="5"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Invoices not moved to xero
            </label>
       </div>
       
	   <?php if(isset($_POST['invoiceType']) && $_POST['invoiceType']=="initial"){?>
           <div class="radio block">
                <label>
                    <input type="radio" name="other" value="6" <?php if(isset($_POST['other']) && $_POST['other']=="6"){echo "checked";}?>>
                    <span class="circle"></span>
                    <span class="check"></span>
                    Invoices having seperate student invoice
                </label>
           </div>
       <?php }?>
       
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