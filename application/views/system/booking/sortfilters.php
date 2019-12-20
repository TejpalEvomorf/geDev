
<style type="text/css">
.form-group
{
	margin:0;
}
</style>

<ul class="nav nav-tabs material-nav-tabs stretch-tabs icon-tabs">
  <li class="active">
  <a class="prices-edit" href="javascript:;" data-toggle="tab">
      Sort List
  </a></li>
  </ul>

<form id="hfasortFiltersForm">

	
            
    <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Sort according to:</label>
       <div class="radio block">
       		<label>
            	<input type="radio" name="bookingSortType" value="arrivaldate" <?php if(isset($_POST['bookingSortType']) && $_POST['bookingSortType']=="arrivaldate"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Arrival date
            </label>
       </div>
	   <div class="radio block">
       		<label>
            	<input type="radio" name="bookingSortType" value="studentnamea" <?php if(isset($_POST['bookingSortType']) && $_POST['bookingSortType']=="studentnamea"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Student name (A-Z)
            </label>
       </div><div class="radio block">
       		<label>
            	<input type="radio" name="bookingSortType" value="studentnamez" <?php if(isset($_POST['bookingSortType']) && $_POST['bookingSortType']=="studentnamez"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Student name (Z-A)
            </label>
       </div><div class="radio block">
       		<label>
            	<input type="radio" name="bookingSortType" value="hostfamilya" <?php if(isset($_POST['bookingSortType']) && $_POST['bookingSortType']=="hostfamilya"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Host Family last name (A-Z)
            </label>
       </div><div class="radio block">
       		<label>
            	<input type="radio" name="bookingSortType" value="hostfamilyz" <?php if(isset($_POST['bookingSortType']) && $_POST['bookingSortType']=="hostfamilyz"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Host Family last name (Z-A)
            </label>
       </div>

</div>

    <div class="noborder0 widget-body" id="generalsortFiltersBtnDiv">
    <input type="submit" value="Update" class="m-n btn btn-raised btn-info">
    </div>
</form>


<script type="text/javascript">
$(document).ready(function(){
	
});
</script>