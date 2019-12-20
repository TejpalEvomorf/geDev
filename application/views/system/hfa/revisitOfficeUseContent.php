<div class="panel panel-profile panel-bluegraylight">
        <div class="panel-heading">
            <h2>Revisit management</h2>
        </div>
        <div class="panel-body">
		 <div class="row">
						  <div class="col-sm-8">
							  
                                    <form id="hfaOfficeUseRevisitDurationForm">
                                        <input type="hidden" name="id" value="<?=$formOne['id']?>" />
                                        
                                        <label  class="mt-n control-label filterItemLabel">Select revisit duration</label>
                                        <div class="radio block">
                                        <label>
                                            <input type="radio" name="revisit_duration" value="6" <?php if($formOne['revisit_duration']=='6'){echo 'checked';}?>>
                                            <span class="circle"></span>
                                            <span class="check"></span>
                                            6 months
                                        </label>
                                        </div>
                                        <div class="radio block">
                                        <label>
                                            <input type="radio" name="revisit_duration" value="12" <?php if($formOne['revisit_duration']=='12'){echo 'checked';}?>>
                                            <span class="circle"></span>
                                            <span class="check"></span>
                                            12 months
                                        </label>
                                        </div>
                                    </form>
							 
						  </div>
					  </div>
					  
					   <div class="widget referral-info-widget infobar" id="revisitManagementBox">
					   <div class="widget-heading" style="padding-left:0;">Revisit history</div>
         <div class="widget-body" style="border-bottom:0px; padding: 16px;"> 
         <?php
				if(!empty($revisit_history))
				{  ?>
                
                <?php
				foreach($revisit_history as $rH)
				  {
					  $employee=employee_details($rH['employee']);
					  ?>
                      
					  <ul class="timeline" style="margin-top: 0 !important; margin-left: -24px ;">
						  <li class="timeline-grey">
							  <div class="timeline-icon"><i class="material-icons">alarm</i></div>
							  <div class="timeline-body">
								  <div class="timeline-header">
									  <span  class="notes-list-head author tyuedit" ><?=$employee['fname'].' '.$employee['lname']?></span>
									  <span class="date"><?=date('d M Y, h:i A',strtotime($rH['date_visited']));?></span>
									  <?php if($rH['comments']!=''){?>
										  <br><span class="date" style="color:#616161;"><?=nl2br($rH['comments'])?></span>
									  <?php } ?>
								  </div>
							  </div>
						  </li>   
					  </ul>
				<?php } ?>
                 
                 <?php
                 }else {?>
				<div class="m-n form-group" style="margin-left: -16px !important;">No revisit history yet</div>
				<?php }?>	
                </div>
                
            </div>
			
           
        </div>
    </div>