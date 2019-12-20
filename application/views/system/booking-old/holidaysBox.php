        <div class="panel panel-profile panel panel-bluegraylight">
            <div class="panel-heading">
                <h2>Student Holiday Info</h2>
            </div>
            <div class="panel-body">
            	<?php if($this->router->fetch_class()=='booking'){ ?>
	            	<button class="btn-raised btn-primary btn btn-sm" style="margin-bottom: 40px;" onclick="bookingHolidayPopContent(<?=$booking['id']?>,'add');">Add new holiday</button> 
                <?php } ?>
                <div id="holidays" style="padding-left:20px;">
                    <?php $this->load->view('system/booking/holidays');?>
                </div>
            </div>
        </div> 
        
        
        
        <!--Add new incident Start-->
        <div class="modal fade" id="model_bookingHoliday" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h2 class="modal-title"><span id="model_bookingHoliday_titlePart">Add new</span> holiday</h2>
                        </div>
                        
                        <div class="modal-body">
                            <form id="bookHoliday_form"></form>   
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success btn-raised" id="bookHoliday_submit">Submit</button>
                            <img src="<?=loadingImagePath()?>" id="bookHoliday_process" style="margin-right:16px;display:none;">
                        </div>
                    </div><!-- /.modal-content -->
                </div>
        </div><!-- /.modal -->
        <!--Add new incident end-->   
