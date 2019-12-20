<?php
$stateList=stateList();
$clientsList=clientsList();
$clientsListshause=clientsListshause();
?>
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
            	<input type="radio" name="appStep" value="partial" <?php if(isset($_POST['appStep']) && $_POST['appStep']=="partial"){echo "checked";}?> >
                <span class="circle"></span>
                <span class="check"></span>
                Partially filled
            </label>
       </div>
       <div class="radio block">
       		<label>
            	<input type="radio" name="appStep" value="complete" <?php if(isset($_POST['appStep']) && $_POST['appStep']=="complete"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Completed
            </label>
       </div>
    </div>	
    
    <?php $this->load->view('system/sha/filters_tours');?>
    <?php $this->load->view('system/sha/filters_duplicate_applications');?>
     <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Show application specific to client</label>
    
      <div class="form-group" style="margin:0;">
          <div class="">
                      <select name="client" class="form-control">
                          <option value="">Select One</option>
                          <?php foreach($clientsList as $cl){?>
                            <option value="<?=$cl['id']?>"<?php echo (!empty($_POST['client'])) && ($_POST['client']== $cl['id']) ? 'selected':'' ?>><?=$cl['bname']?></option>
                         <?php } ?>
                      </select>
          </div>
      </div>
      </div>
	  <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Show applications specific to School/College</label>
    
      <div class="form-group" style="margin:0;">
          <div class="">
                      <select name="college" class="form-control">
                          <option value="">Select One</option>
                          <?php foreach($clientsListshause as $cl){?>
                            <option value="<?=$cl['id']?>"<?php echo (!empty($_POST['college'])) && ($_POST['college']== $cl['id']) ? 'selected':'' ?>><?=$cl['bname']?></option>
                         <?php } ?>
                      </select>
					  
          </div>
      </div>
      </div>
    <div class="noborder0 widget-body" id="generalFiltersBtnDiv">
    <input type="submit" value="Update" class="m-n btn btn-raised btn-info">
    </div>
</form>