<div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Filter applications according to:</label>
       <div class="radio block">
       		<label>
            	<input type="radio" name="appTourType" value="no" <?php if(isset($_POST['appTourType']) && $_POST['appTourType']=="no"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Non tour group applications
            </label>
       </div>
       <div class="radio block">
       		<label>
            	<input type="radio" name="appTourType" value="yes" <?php if(isset($_POST['appTourType']) && $_POST['appTourType']=="yes"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Only tour group applications
            </label>
       </div>
    </div>