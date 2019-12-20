<?php
$studyTourList=studyTourList();
?>
<ul class="nav nav-tabs material-nav-tabs stretch-tabs icon-tabs">
  <li class="active">
  <a class="prices-edit" href="javascript:;" data-toggle="tab">
      Filters
  </a></li>
  </ul>
<form id="poFiltersForm">
		
	<div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Filter by PO number</label>
       <div class="form-group">
          <div class="input-group">
          	  <span class="input-group-addon addon-invoiceNo">PO-</span>
              <input class="form-control" name="number" placeholder="Enter invoice number" value="<?=$_POST['number']?>" type="text">
          </div>
          <h4 style="margin:0 0 0 25px;"><small>Only enter the PO number without PO-</small></h4>
      </div>
      </div>
      
      
     <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Filter by host name</label> 
      <div class="form-group">
          <!--<label for="poFrom" class="control-label">Search by student name</label>-->
          <div class="">
              <input class="form-control" name="host" placeholder="Enter host name" value="<?=$_POST['host']?>" type="text">
          </div>
      </div>
     </div>
     
     <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Show POs within duration (filters according to PO start date)</label>  
      <div class="form-group">
         <!-- <label for="poFrom" class="control-label">Search by dates</label>-->
          <div style="width: 45%;float: left;">
              <input class="form-control" id="poFrom" name="poFrom" placeholder="From date" value="<?=$_POST['poFrom']?>" type="text">
          </div>
          <div style="width: 45%;float: left;margin-left:20px;">
              <input class="form-control" id="poTo" name="poTo" placeholder="To date" value="<?=$_POST['poTo']?>" type="text">
          </div>
      </div>
      
    </div>
    
    
    <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Filter by due date</label>  
      <div class="form-group">
         <!-- <label for="poFrom" class="control-label">Search by dates</label>-->
          <div>
              <input class="form-control" id="poFrom" name="poDueDate" placeholder="Due date" value="<?=$_POST['poDueDate']?>" type="text">
          </div>
      </div>
      
    </div>
    
    <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Show purchase orders specific to tour group</label>
    
      <div class="form-group">
          <div class="">
                      <select name="study_tour" class="form-control">
                          <option value="">Select One</option>
                          <?php foreach($studyTourList as $sT){?>
                            <option value="<?=$sT['id']?>" <?php if($sT['id']==$_POST['study_tour']){?>selected<?php }?>><?=$sT['group_name']?></option>
                         <?php } ?>
                      </select>
          </div>
      </div>
      </div>                 

    <!--<div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Show purchase orders within duration:</label>
       
     <div class="form-group">
          <label for="poFrom" class="control-label">From</label>
          <div class="">
              <input class="form-control" id="poFrom" name="poFrom" placeholder="From date" value="<?=$_POST['poFrom']?>" type="text">
          </div>
      </div>
      
      <div class="form-group">
          <label for="poTo" class="control-label">To</label>
          <div class="">
              <input class="form-control" id="poTo" name="poTo" placeholder="To date" value="<?=$_POST['poTo']?>" type="text">
          </div>
      </div>
  </div>-->
  
  <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Show only:</label>
       <div class="radio block">
       		<label>
            	<input type="radio" name="other" value="1" <?php if(isset($_POST['other']) && $_POST['other']=="1"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Tour group purchase orders
            </label>
       </div>
       <div class="radio block">
       		<label>
            	<input type="radio" name="other" value="2" <?php if(isset($_POST['other']) && $_POST['other']=="2"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Non tour group purchase orders
            </label>
       </div>

       <div class="radio block">
       		<label>
            	<input type="radio" name="other" value="4" <?php if(isset($_POST['other']) && $_POST['other']=="4"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Purchase orders moved to xero
            </label>
       </div>

       <div class="radio block">
       		<label>
            	<input type="radio" name="other" value="5" <?php if(isset($_POST['other']) && $_POST['other']=="5"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Purchase orders not moved to xero
            </label>
       </div>

       
    </div>
    
    <div style="height:120px;"></div>
  	
    <div class="noborder0 widget-body" id="generalFiltersBtnDiv">
    <input type="submit" value="Update" class="m-n btn btn-raised btn-info">
    </div>
</form>