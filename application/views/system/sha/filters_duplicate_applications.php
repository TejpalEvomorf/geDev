<div class="widget-body mt-n form-group">
     <label  class="mt-n control-label filterItemLabel">Only show applications:</label>
      <div class="checkbox">
          <div class="checkbox block">
              <label><input type="checkbox" name="appDuplicate"  value="1" <?php if($_POST['appDuplicate']=='1'){?>checked<?php } ?>> 
                  <span class="checkbox-material"><span class="check"></span></span>
                  Where homestay is changed
              </label>
          </div>
      </div>
      <div class="checkbox">
          <div class="checkbox block">
              <label><input type="checkbox" name="appCaregivingDuration"  value="1" <?php if($_POST['appCaregivingDuration']=='1'){?>checked<?php } ?>> 
                  <span class="checkbox-material"><span class="check"></span></span>
                  Where caregiving duration not defined
              </label>
          </div>
      </div>
      <div class="checkbox">
          <div class="checkbox block">
              <label><input type="checkbox" name="appMatchCollege"  value="1" <?php if($_POST['appMatchCollege']=='1'){?>checked<?php } ?>> 
                  <span class="checkbox-material"><span class="check"></span></span>
                  Where college/institution not selected
              </label>
          </div>
      </div>
 </div>