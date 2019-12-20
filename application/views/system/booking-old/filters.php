<?php
$accomodationTypeList=accomodationTypeList();
$clientsList=clientsList();
$studyTourList=studyTourList();
?>
<style type="text/css">
.form-group
{
	margin:0;
}
</style>

<ul class="nav nav-tabs material-nav-tabs stretch-tabs icon-tabs">
  <li class="active">
  <a class="prices-edit" href="javascript:;" data-toggle="tab">
      Filters
  </a></li>
  </ul>

<form id="hfaFiltersForm">

	<div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Filter by booking id</label>
       <div class="form-group">
          <div class="">
          	  <input class="form-control" name="booking_id" placeholder="Enter booking id" value="<?=$_POST['booking_id']?>" type="text">
          </div>
      </div>
      </div>
      
      <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Filter by student name</label> 
      <div class="form-group">
          <div class="">
              <input class="form-control" name="student" placeholder="Enter student name" value="<?=$_POST['student']?>" type="text">
          </div>
      </div>
     </div>
           
      <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Filter by family host name</label> 
      <div class="form-group">
          <div class="">
              <input class="form-control" name="host" placeholder="Enter host name" value="<?=$_POST['host']?>" type="text">
          </div>
      </div>
     </div>
     
     <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Filter by date range (based on booking date)</label>  
      <div class="form-group">
          <div style="width: 45%;float: left;">
              <input class="form-control" id="bookingFrom" name="from" placeholder="From date" value="<?=$_POST['from']?>" type="text">
          </div>
          <div style="width: 45%;float: left;margin-left:20px;">
              <input class="form-control" id="bookingTo" name="to" placeholder="To date" value="<?=$_POST['to']?>" type="text">
          </div>
      </div>
      
    </div>
	<div class="radio block">
       		<label>
            	<input type="radio" name="activealboking" value="activealboking" <?php if(isset($_POST['activealboking']) && $_POST['activealboking']=="activealboking"){echo "checked";}?> >
                <span class="circle"></span>
                <span class="check"></span>
                show bookings that are active between these dates
            </label>
       </div>
	   	<div class="radio block">
       		<label>
            	<input type="radio" name="activealboking" value="activestratboking" <?php if(isset($_POST['activealboking']) && $_POST['activealboking']=="activestratboking"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
               show bookings that start between these dates
            </label>
       </div>
	   <div class="radio block">
       		<label>
            	<input type="radio" name="activealboking" value="activeendboking" <?php if(isset($_POST['activealboking']) && $_POST['activealboking']=="activeendboking"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
             show bookings that end between these dates
            </label>
       </div>
     
    <div class="widget-body mt-n form-group" style="border-top:1px solid #f5f5f5;">
       <label  class="mt-n control-label filterItemLabel">Show bookings specific to client</label>
    
      <div class="form-group">
          <div class="">
                      <select name="client" class="form-control">
                          <option value="">Select One</option>
                          <?php foreach($clientsList as $cl){?>
                            <option value="<?=$cl['id']?>" <?php if($cl['id']==$_POST['client']){?>selected<?php }?>><?=$cl['bname']?></option>
                         <?php } ?>
                      </select>
          </div>
      </div>
      </div>
     
    <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Show bookings specific to tour group</label>
    
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
            
    <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Show only:</label>
       <div class="radio block">
       		<label>
            	<input type="radio" name="bookingTourType" value="no" <?php if(isset($_POST['bookingTourType']) && $_POST['bookingTourType']=="no"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Non tour group bookings
            </label>
       </div>
       <div class="radio block">
       		<label>
            	<input type="radio" name="bookingTourType" value="yes" <?php if(isset($_POST['bookingTourType']) && $_POST['bookingTourType']=="yes"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Only tour group bookings
            </label>
       </div>
	     <div class="radio block">
       		<label>
            	<input type="radio" name="bookingTourType" value="U18" <?php if(isset($_POST['bookingTourType']) && $_POST['bookingTourType']=="U18"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Under 18 student bookings
            </label>
       </div>

</div>

<div class="widget-body mt-n form-group">

		<div class="checkbox">
          <div class="checkbox block">
              <label><input type="checkbox" name="bookingWithWarnings"  value="1" <?php if($_POST['bookingWithWarnings']=='1' && ($_POST['booking_status_page']=='expected_arrival' || $_POST['booking_status_page']=='all')){?>checked="checked"<?php } ?>> 
              <span class="checkbox-material"><span class="check"></span></span>
                  Show bookings with warnings
              </label>
          </div>
      </div>
                                 
    </div>	
    
    <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Show bookings with product:</label>
       <?php foreach($accomodationTypeList as $aTLK=>$aTL){?>
       <div class="radio block">
       		<label>
            	<input type="radio" name="bookingProductType" value="<?=$aTLK?>" <?php if(isset($_POST['bookingProductType']) && $_POST['bookingProductType']==$aTLK){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
               <?=$aTL?>
            </label>
       </div>
       <?php } ?>
    </div>
   
   <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Filter by SalesForce booking id</label>
    
      <div class="form-group">
          <div class="">
          	  <input class="form-control" name="booking_idSF" placeholder="Enter booking id" value="<?=$_POST['booking_idSF']?>" type="text">
          </div>
      </div>
      </div>
    
    
    <div style="height:120px;"></div>
    
    <div class="noborder0 widget-body" id="generalFiltersBtnDiv">
    <input type="submit" value="Update" class="m-n btn btn-raised btn-info">
    </div>
</form>


<script type="text/javascript">
$(document).ready(function(){
	$('#bookingFrom,#bookingTo').datepicker({
							/*orientation: "top",*/
							format:'dd/mm/yyyy',
							autoclose:true
						});
});
</script>