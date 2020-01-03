<?php
$clientList=clientsList();
?>
					<div class="pl-n m-n form-group col-xs-12">
                          <label class="control-label">College/Institution</label>
                              <select class="form-control" id="transportClg" name="transportClg" required>
                              <option value="" >Select college/institution</option>
                                  <?php
                                  foreach($clientList as $clg)
								  {
									  if(!in_array($clg['category'],array('3','4')))
									  	continue;
								  	?>
                                  <option value="<?=$clg['id']?>" <?php if(isset($transportInfo) && !empty($transportInfo) && $transportInfo['college_id']==$clg['id']){echo "selected";}?>><?=$clg['bname']?></option>
                                  <?php
								  }
								  ?>
                               </select>
                      </div>
                      
                        <div class="pl-n m-n form-group col-xs-6">
                            <label class="control-label">Type of transport</label>
                        	<input type="text" class="form-control"  id="transportType" name="transportType" value="<?php if(isset($transportInfo) && !empty($transportInfo)){echo $transportInfo['type'];}?>" required/>
                        </div>
                      
                        <div class="pl-n m-n form-group col-xs-6">
                            <label class="control-label">Travel time</label>
                        	<input type="text" class="form-control"  id="transportTravelTime" name="transportTravelTime" value="<?php if(isset($transportInfo) && !empty($transportInfo)){echo $transportInfo['travel_time'];}?>"/>
                        </div>
                        
                    <div class="m-n form-group" style="clear:both;">
                        <label class="control-label">Transport description</label>
                        <textarea  rows="4" class="form-control" id="transportDesc" name="transportDesc"><?php if(isset($transportInfo) && !empty($transportInfo)){echo $transportInfo['description'];}?></textarea>
                    </div>      
                      
                        <div class="pl-n m-n form-group col-xs-12">
                            <label class="control-label">Google map link</label>
                        	<input type="text" class="form-control"  id="transportGMapLink" name="transportGMapLink" value="<?php if(isset($transportInfo) && !empty($transportInfo)){echo $transportInfo['gmap_link'];}?>"/>
                        </div>                     
                                          
                    
                        
					<?php if(isset($transportInfo)){?>
                        <input type="hidden" name="transportId" id="transportId" value="<?=$transportInfo['id']?>" />
                        <input type="hidden" name="transportHfaId" value="<?=$transportInfo['hfa_id']?>" />
                    <?php }else{ ?>
	                    <input type="hidden" name="transportHfaId" value="<?=$hfa_id?>" />
                    <?php } ?>                   
                    