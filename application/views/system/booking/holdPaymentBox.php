<?php
$employeeList=employeeList();
$loggedInUser=loggedInUser();
?>
<div class="panel panel-profile panel panel-bluegraylight">
    <div class="panel-heading">
        <h2>PAYMENT HOLDING</h2>
    </div>
    <div id="hpContent">
    <?php $this->load->view('system/booking/holdPaymentBtns');?>
    </div>
</div>



<!--Add new incident Start-->
        <div class="modal fade" id="model_bookingHoldPos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" id="model_bookingHoldPos_content">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h2 class="modal-title">Hold current and future POs</h2>
                        </div>
                        
                        <div class="modal-body">
                            <form id="bookingHoldPos_form">
                            	
                                    <div class="pl-n m-n form-group col-xs-12">
                                        <label class="control-label">Held by</label>
                                        <select class="form-control" id="bookingHoldPos_emp" name="bookingHoldPos_emp" required <?php if($loggedInUser['user_type']=='2'){echo "disabled";}?>>
                                        <option value="" >Select employee</option>
                                          <?php
                                          foreach($employeeList as $emp)
                                          {
                                            ?>
                                          <option value="<?=$emp['id']?>" <?php if($loggedInUser['user_type']=='2' && $loggedInUser['id']==$emp['id']){echo 'selected';}?>><?=$emp['fname'].' '.$emp['lname']?></option>
                                          <?php
                                          }
                                          ?>
                                        </select>
                                        <?php if($loggedInUser['user_type']=='2'){?>
                                        <input type="hidden" name="bookingHoldPos_emp" value="<?=$loggedInUser['id']?>" />
                                        <?php } ?>
                                    </div>                     
                                    <div class="m-n form-group" style="clear:both;">
                                        <label class="control-label">Reason</label>
                                        <textarea  rows="4" class="form-control" name="bookingHoldPos_reason"></textarea>
                                    </div>
                            		<input type="hidden" name="bookingHoldPos_booking_id" value="<?=$booking['id']?>" />
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success btn-raised" id="bookingHoldPosSubmit" >Submit</button>
                            <img src="<?=loadingImagePath()?>" id="bookingHoldPosSubmitProcess" style="margin-right:16px;display:none;">
                        </div>
                                                
                    </div><!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->     
                
        </div><!-- /.modal -->
        <!--Add new incident end-->