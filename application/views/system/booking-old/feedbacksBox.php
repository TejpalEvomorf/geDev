<?php if(!empty($feedbacks)){?>   
        <div class="panel panel-profile panel panel-bluegraylight" id="feedbacksBox">
            <div class="panel-heading">
                <h2>Feedback</h2>
            </div>
            <div class="panel-body">
                <div id="feedbacks" style="padding-left:20px;">
                    <?php $this->load->view('system/booking/feedbacks');?>    
                </div>
            </div>
        </div> 
<?php } ?>