<style>
.dropdown-menu > li > a, .tt-dropdown-menu > li > a, .tt-suggestion > p {

    display: block !important;
    padding: 3px 20px !important;
    clear: both;
    font-weight: normal;
    line-height: 1.45 !important;
    color: #424242 !important;
    white-space: nowrap;
    font-size: 13px !important;

}
</style>

<?php 
$bookingCheckupTypeList=bookingCheckupTypeList();
?>   
        <div class="panel panel-profile panel panel-bluegraylight">
            <div class="panel-heading">
                <h2>Check-up info</h2>
            </div>
            <div class="panel-body">
            <div class="btn-group dropdown" style="margin-bottom: 0;">
	            	<button class="btn-raised btn-primary btn btn-sm" data-toggle="dropdown" style="margin-bottom: 0px;">Add new check</button> 
                    <ul class="dropdown-menu" role="menu" style="margin-top: 1px !important;">
                    <?php foreach($bookingCheckupTypeList as $typeK=>$typeV){
						if($typeK==1 && ifArrivalCheckupAdded($booking['id']))
							continue;
						elseif($typeK==2 && ifReminderCheckupAdded($booking['id']))
							continue;
						?>
	                    <li><a href="javascript:void(0);" onclick="bookingCheckupPopContent(<?=$booking['id']?>,'<?=$typeK?>','add');"  style="color:black;" class="checkUpType_<?=$typeK?>"><?=$typeV?></a></li>
                    <?php } ?>
                </ul>
               </div>     
                <div id="checkups" style="padding-left:20px; margin-top: 40px;">
                    <?php $this->load->view('system/booking/checkups');?>
                </div>
            </div>
        </div> 
     
<?php $this->load->view('system/booking/checkupPopUp');?>