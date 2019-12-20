<ul class="nav nav-tabs material-nav-tabs stretch-tabs icon-tabs">
  <li class="active">
  <a class="prices-edit" href="javascript:;" data-toggle="tab">
      Filters
  </a></li>
  </ul>
  
<form id="hfaFiltersForm">
    <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Only show applications that are:</label>
       <div class="radio block">
       		<label>
            	<input type="radio" name="placement" value="not_placed" <?php if(isset($_POST['placement']) && $_POST['placement']=="not_placed"){echo "checked";}?> >
                <span class="circle"></span>
                <span class="check"></span>
                Not placed yet
            </label>
       </div>
       <div class="radio block">
       		<label>
            	<input type="radio" name="placement" value="placed" <?php if(isset($_POST['placement']) && $_POST['placement']=="placed"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Already placed
            </label>
       </div>
       <div class="radio block">
       		<label>
            	<input type="radio" name="placement" value="both" <?php if(isset($_POST['placement']) && $_POST['placement']=="both"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Both placed and unplaced
            </label>
       </div>
    </div>	
    
    <?php $this->load->view('system/sha/filters_tours');?>
    <?php $this->load->view('system/sha/filters_duplicate_applications');?>
    
    <div class="noborder0 widget-body" id="generalFiltersBtnDiv">
    <input type="submit" value="Update" class="m-n btn btn-raised btn-info">
    </div>
</form>