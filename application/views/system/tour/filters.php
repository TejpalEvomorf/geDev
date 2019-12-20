<ul class="nav nav-tabs material-nav-tabs stretch-tabs icon-tabs">
  <li class="active">
    <a class="prices-edit" href="javascript:;" data-toggle="tab">
      Filters <?php //echo $filterOption; ?>
    </a>
  </li>
</ul>
<form id="frm_tour_filter">
    <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Only show applications that are:</label>
          <div class="radio block">
         		<label>
              	<input type="radio" name="tourStudents" value="placed_students" checked />
                  <span class="circle"></span>
                  <span class="check"></span>
                  Placed
              </label>
         </div>
         <div class="radio block">
           <label>
               <input type="radio" name="tourStudents" value="pending_students" checked />
                 <span class="circle"></span>
                 <span class="check"></span>
                 Pending Placement
             </label>
        </div>
        <div class="radio block">
          <label>
              <input type="radio" name="tourStudents" value="all_students" checked />
                <span class="circle"></span>
                <span class="check"></span>
                All Applications
          </label>
       </div>
    </div>
    <div class="noborder0 widget-body" id="generalFiltersBtnDiv">
      <input type="button" id="btn_submit" value="Update" class="m-n btn btn-raised btn-info">
      <input type="hidden" value="<?php echo $tour_id;?>" name="tour_id" id="tour_id" />
    </div>
</form>
<script language="javascript">
  $(function(){
    var selected_filter='<?php echo $filterOption;?>';
    $("input[name=tourStudents][value=" + selected_filter + "]").prop('checked', true);
    $("#btn_submit").on("click",function(){
      var filter_value = $("input[name='tourStudents']:checked"). val();
      var tour_id = $("#tourFiltersBtn").data("tour_id");
      $(location).attr('href', site_url+'tour/'+filter_value+'/'+tour_id);
      return false;
    });
  });
</script>
