<?php
$stateList=stateList();
$do_not_useOptions=do_not_useOptions();
$clientList=clientsList();
$roomTypeList=roomTypeList();
$nationList=nationList();
$religionList=religionList();
$facilityList=getHfaFacilityList();
$languageList=languageList();
?>
<ul class="nav nav-tabs material-nav-tabs stretch-tabs icon-tabs">
  <li class="active">
  <a class="prices-edit" href="javascript:;" data-toggle="tab">
      Filters
  </a></li>
  </ul>

<form id="hfaFiltersForm">
    <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Only show applications that are:</label>
       <div class="radio block">
       		<label>
            	<input type="radio" name="appStep" value="partial" <?php if(isset($_POST['appStep']) && $_POST['appStep']=="partial"){echo "checked";}?> >
                <span class="circle"></span>
                <span class="check"></span>
                Partially filled
            </label>
       </div>
       <div class="radio block">
       		<label>
            	<input type="radio" name="appStep" value="complete" <?php if(isset($_POST['appStep']) && $_POST['appStep']=="complete"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Completed
            </label>
       </div>
	     <div class="radio block">
       		<label>
            	<input type="radio" name="appStep" value="bookmarked" <?php if(isset($_POST['appStep']) && $_POST['appStep']=="bookmarked"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Bookmarked
            </label>
       </div>
	     <div class="radio block">
       		<label>
            	<input type="radio" name="appStep" value="revisited" <?php if(isset($_POST['appStep']) && $_POST['appStep']=="revisited"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                To be revisited
            </label>
       </div>
    </div>		
  <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Filter families according to no. of warnings:</label>
      
      	<div class="form-group" style="margin-top:0;">
          <div class="">
                      <select name="warning" class="form-control">
                          <option value="">Select One</option>
                          <?php for($i=1;$i<=3;$i++){?>
                            <option value="<?=$i?>" <?php if(!empty($_POST['warning']) && ($i==$_POST['warning'])){?>selected<?php }?>><?=$i?></option>
                         <?php } ?>
                         <option value="any" <?php if(!empty($_POST['warning']) && ('any'==$_POST['warning'])){?>selected<?php }?>>Any no of warnings</option>
                      </select>
          </div>
      </div>
     
   </div>
  <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Filter families according to no. of rooms:</label>
      
      	<div class="form-group" style="margin-top:0;">
          <div class="">
                      <select name="room" class="form-control">
                          <option value="">Select One</option>
                          <?php for($i=1;$i<=10;$i++){?>
                            <option value="<?=$i?>" <?php if(!empty($_POST['room']) && ($i==$_POST['room'])){?>selected<?php }?>><?=$i?></option>
                         <?php } ?>
                      </select>
          </div>
      </div>
     
   </div>
    <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Filter applications according to the state:</label>
      <?php foreach($stateList as $stateK=>$stateV){?>
      	<div class="checkbox">
         	<div class="checkbox block">
            	<label><input type="checkbox" name="appState[]"  value="<?=$stateK?>" <?php if(isset($_POST['appState']) && in_array($stateK,explode(',',$_POST['appState']))){echo "checked";}?>> 
					<span class="checkbox-material"><span class="check"></span></span>
					<?=$stateV?>
                </label>
            </div>
        </div>
      <?php } ?> 
   </div>
   
   
   <?php  if(isset($_POST['cstatus']) &&$_POST['cstatus']=='do_not_use'){  ?>
      <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Filter applications according to reason:</label>
      <?php foreach($do_not_useOptions as $stateK=>$stateV){?>
      	
         	<div class="radio block">
            	<label><input type="radio" name="appReason"  value="<?=$stateK?>" <?php if(isset($_POST['appReason']) && ($_POST['appReason']==$stateK)){echo "checked";}?>> 
					
					<span class="circle"></span>
                <span class="check"></span>
					<?=$stateV?>
                </label>
            </div>
        
      <?php } ?> 
   </div>
   <?php }?>
   
   
   <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">WWCC:</label>
       <div class="radio block">
       		<label>
            	<input type="radio" name="wwcc" value="na" <?php if(isset($_POST['wwcc']) && $_POST['wwcc']=="na"){echo "checked";}?> >
                <span class="circle"></span>
                <span class="check"></span>
                Doesn't have WWCC
            </label>
       </div>
       <div class="radio block">
       		<label>
            	<input type="radio" name="wwcc" value="expired" <?php if(isset($_POST['wwcc']) && $_POST['wwcc']=="expired"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                WWCC expired
            </label>
       </div>
	     <div class="radio block">
       		<label>
            	<input type="radio" name="wwcc" value="turned18" <?php if(isset($_POST['wwcc']) && $_POST['wwcc']=="turned18"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Member turned 18
            </label>
       </div>
	</div>
     
     <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">PL Insurance:</label>
       <div class="radio block">
       		<label>
            	<input type="radio" name="insurance" value="na" <?php if(isset($_POST['insurance']) && $_POST['insurance']=="na"){echo "checked";}?> >
                <span class="circle"></span>
                <span class="check"></span>
                Not available
            </label>
       </div>
       <div class="radio block">
       		<label>
            	<input type="radio" name="insurance" value="expired" <?php if(isset($_POST['insurance']) && $_POST['insurance']=="expired"){echo "checked";}?>>
                <span class="circle"></span>
                <span class="check"></span>
                Expired
            </label>
       </div>
	</div>
    
    
    <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Filter families that are approved by college:</label>
       <div class="form-group" style="margin-top:0;">
          <div class="">
                      <select name="cApproval" class="form-control">
                          <option value="">Select One</option>
							<?php 
                            foreach($clientList as $client)
                            {
                                if($client['category']=='1' || $client['category']=='2')
                                continue;
                                ?>
                                <option value="<?=$client['id']?>" <?php if(isset($_POST['cApproval']) && $client['id']==$_POST['cApproval']){echo "selected";}?>><?=$client['bname']?></option>
                            <?php } ?>
                      </select>
          </div>
      </div>
   </div>
   
    <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Filter applications according to the room type:</label>
      <?php foreach($roomTypeList as $rTypeK=>$rTypeV){?>
      	<div class="checkbox">
         	<div class="checkbox block">
            	<label><input type="checkbox" name="roomType[]"  value="<?=$rTypeK?>" <?php if(isset($_POST['roomType']) && in_array($rTypeK,explode(',',$_POST['roomType']))){echo "checked";}?>> 
					<span class="checkbox-material"><span class="check"></span></span>
					<?=$rTypeV?>
                </label>
            </div>
        </div>
      <?php } ?> 
   </div>
   
   
    <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Filter families according to the nationality of the family members:</label>
       <div class="form-group" style="margin-top:0;">
          <div class="">
                      <select name="nation" class="form-control">
                          <option value="">Select One</option>
							<?php 
                            foreach($nationList as $nationK=>$nationV)
                            {
                                ?>
                                <option value="<?=$nationK?>" <?php if(isset($_POST['nation']) && $nationK==$_POST['nation']){echo "selected";}?>><?=$nationV?></option>
                            <?php } ?>
                      </select>
          </div>
      </div>
   </div>
   
   
    <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Filter families according to the religion of the family members:</label>
       <div class="form-group" style="margin-top:0;">
          <div class="">
                      <select name="religion" class="form-control">
                          <option value="">Select One</option>
							<?php 
                            foreach($religionList as $religionK=>$religionV)
                            {
                                ?>
                                <option value="<?=$religionK?>" <?php if(isset($_POST['religion']) && $religionK==$_POST['religion']){echo "selected";}?>><?=$religionV?></option>
                            <?php } ?>
                      </select>
          </div>
      </div>
   </div>
   
    <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Filter applications according to the facilities:</label>
      <?php foreach($facilityList as $facilityK=>$facilityV){?>
      	<div class="checkbox">
         	<div class="checkbox block">
            	<label><input type="checkbox" name="facility[]"  value="<?=$facilityK?>" <?php if(isset($_POST['facility']) && in_array($facilityK,explode(',',$_POST['facility']))){echo "checked";}?>> 
					<span class="checkbox-material"><span class="check"></span></span>
					<?=$facilityV?>
                </label>
            </div>
        </div>
      <?php } ?> 
   </div>
   
   
    <div class="widget-body mt-n form-group">
       <label  class="mt-n control-label filterItemLabel">Filter families according to the language spoken by the family members:</label>
       <div class="form-group" style="margin-top:0;">
          <div class="">
                      <select name="language" class="form-control">
                          <option value="">Select One</option>
							<?php 
                            foreach($languageList as $langK=>$langV)
                            {
                                ?>
                                <option value="<?=$langK?>" <?php if(isset($_POST['language']) && $langK==$_POST['language']){echo "selected";}?>><?=$langV?></option>
                            <?php } ?>
                      </select>
          </div>
      </div>
   </div>
    
    
    <div style="height:150px;"></div>
    <div class="noborder0 widget-body" id="generalFiltersBtnDiv">
	
    <input type="submit" value="Update" class="m-n btn btn-raised btn-info">
    </div>
</form>