<div class="widget">
                <div class="widget-heading">Booking end date history</div>
                <div class="widget-body">
                <?php if(!empty($history)){?>
                    <ul class="timeline">
                        
                        <?php foreach($history as $his){
							$user=$this->admin_model->loggedInUser($his['by_user_id']);
							?>
                        <li class="timeline-sky">
                            <div class="timeline-icon"><i class="material-icons">date_range</i></div>
                            <div class="timeline-body">
                                <div class="timeline-header">
                                   <span class="author"><?=ucwords($user['fname'].' '.$user['lname'])?> changed booking end date to <?php if($his['booking_end_date']!='0000-00-00'){echo date('d M Y',strtotime($his['booking_end_date'].' + 1 day'));}else{ echo 'Not set';}?></span>
                                    <span class="date"><?=date('d M Y g:i A', strtotime($his['date']));?></span>
                                </div>
                            </div>
                        </li>
                      <?php } ?>    
                    </ul>
                    <?php }
					else { ?>
		                    <div class="media-body">
                              <span class="text-gray">No booking end history yet</span>
                            </div>
                    <?php } ?>
                </div>
            </div>