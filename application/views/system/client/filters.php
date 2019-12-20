<?php
$clientCategories=clientCategories();
?>

<ul class="nav nav-tabs material-nav-tabs stretch-tabs icon-tabs">
  <li class="active">
  <a class="prices-edit" href="javascript:;" data-toggle="tab">
      Filters
  </a></li>
  </ul>
  
<form id="clientFiltersForm">
    <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Only show clients with category:</label>

       <?php foreach($clientCategories as $cCK=>$cCV){?>
              <div class="radio block">
       		<label>
            	<input type="radio" name="clientCategory" value="<?=$cCK?>" <?php if(isset($_POST['clientCategory']) && $_POST['clientCategory']==$cCK){echo "checked";}?> >
                <span class="circle"></span>
                <span class="check"></span>
                <?=$cCV?>
            </label>
       </div>
       <?php } ?>
	</div>	
    <div class="noborder0 widget-body" id="generalFiltersBtnDiv">
    <input type="submit" value="Update" class="m-n btn btn-raised btn-info">
    </div>
</form>