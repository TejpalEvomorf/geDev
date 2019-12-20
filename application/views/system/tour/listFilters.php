<?php
$shaStatusList=shaStatusList();
?>
<ul class="nav nav-tabs material-nav-tabs stretch-tabs icon-tabs">
  <li class="active">
  <a class="prices-edit" href="javascript:;" data-toggle="tab">
      Filters
  </a></li>
  </ul>

<form id="hfaFiltersForm">
    	
    
    <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Select tour status:</label>
      
      <div class="radio block">
          <label>
              <input type="radio" name="tourStatus" value="" <?php if($_POST['tourStatus']==''){echo "checked";}?> />
                <span class="circle"></span>
                <span class="check"></span>
                All tours
          </label>
       </div>
       <?php foreach($shaStatusList as $statusK=>$statusV){?>
       <div class="radio block">
          <label>
              <input type="radio" name="tourStatus" value="<?=$statusK?>" <?php if(isset($_POST['tourStatus']) && $statusK==$_POST['tourStatus']){echo "checked";}?> />
                <span class="circle"></span>
                <span class="check"></span>
                <?=$statusV?>
          </label>
       </div>
       <?php } ?>
        
   </div>
   
   
     
    <div class="noborder0 widget-body" id="generalFiltersBtnDiv">
    <input type="submit" value="Update" class="m-n btn btn-raised btn-info">
    </div>
</form>