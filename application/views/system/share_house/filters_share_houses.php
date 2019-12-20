<ul class="nav nav-tabs material-nav-tabs stretch-tabs icon-tabs">
  <li class="active">
    <a class="prices-edit" href="javascript:;" data-toggle="tab">
      Filters
    </a>
  </li>
</ul>
  
<form id="hfaFiltersForm">
    <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Only show houses that are:</label>
       <div class="radio block">
       		<label>
            	<input type="radio" name="status" value="not_placed" <?php if(isset($_POST['status']) && $_POST['status']=="share_house_new"){echo "checked";}?> >
                <span class="circle"></span>
                <span class="check"></span>
                New
            </label>
       </div>
       <div class="radio block">
       		<label>
            	<input type="radio" name="status" value="placed" <?php if(isset($_POST['status']) && $_POST['status']=="share_house_pending_invoice"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Pending Invoice
            </label>
       </div>
       <div class="radio block">
       		<label>
            	<input type="radio" name="status" value="both" <?php if(isset($_POST['status']) && $_POST['status']=="share_house_approved_with_payment"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Approved With Payment
            </label>
       </div>
       <div class="radio block">
          <label>
              <input type="radio" name="status" value="both" <?php if(isset($_POST['status']) && $_POST['status']=="share_house_approved_without_payment"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Approved Without Payment
            </label>
       </div>
       <div class="radio block">
          <label>
              <input type="radio" name="status" value="both" <?php if(isset($_POST['status']) && $_POST['status']=="share_house_rejected"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Share House Rejected
            </label>
       </div>
       <div class="radio block">
          <label>
              <input type="radio" name="status" value="both" <?php if(isset($_POST['status']) && $_POST['status']=="share_house_cancelled"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Share House Cancelled
            </label>
       </div>
    </div>	
    <div class="noborder0 widget-body" id="generalFiltersBtnDiv">
    <input type="submit" value="Update" class="m-n btn btn-raised btn-info">
    </div>
</form>