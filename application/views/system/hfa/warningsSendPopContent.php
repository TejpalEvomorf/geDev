<?php
$employeeList=employeeList();
$loggedInUser=loggedInUser();
$sentByList=hfaWarningSentByOptionList();
?>

<div class="pl-n m-n form-group col-xs-6">
  <label class="control-label">Sent by</label>

      <select class="form-control" id="hfaWarningSend_emp" name="hfaWarningSend_emp" required <?php if($loggedInUser['user_type']=='2'){echo "disabled";}?>>
             <option value="" >Select employee</option>
                  <?php
                  foreach($employeeList as $emp)
                  {
                    ?>
                  <option value="<?=$emp['id']?>" <?php if(isset($warningDetails)){if($warningDetails['emp']==$emp['id']){echo 'selected';}}elseif($loggedInUser['user_type']=='2' && $loggedInUser['id']==$emp['id']){echo 'selected';}?>><?=$emp['fname'].' '.$emp['lname']?></option>
                  <?
                  }
                  ?>
       </select>
	   <?php if($loggedInUser['user_type']=='2'){?>
        <input type="hidden" name="hfaWarningSend_emp" value="<?php if(isset($warningDetails)){ echo $warningDetails['emp'];}else{ echo $loggedInUser['id'];}?>" />
       <?php } ?>
</div>

<div class="pl-n m-n form-group col-xs-6">
    <label class="control-label">Sent to email id</label>
    <input type="text" class="form-control"  id="hfaWarningSend_to" name="hfaWarningSend_to" value="<?php if(isset($warningDetails) && !empty($warningDetails)){echo $warningDetails['to'];}?>" data-parsley-type="email" required/>
</div>

<div class="pl-n m-n form-group col-xs-6">
  <label class="control-label">Method</label>
      <select class="form-control" id="hfaWarningSend_method" name="hfaWarningSend_method" required>
             <option value="" >Select method</option>
             <?php foreach($sentByList as $sblK=>$sblV){?>
	             <option value="<?=$sblK?>" <?php if(isset($warningDetails) && !empty($warningDetails) && $warningDetails['method']==$sblK){?>selected<?php } ?>><?=$sblV?></option>
             <?php } ?>
       </select>
</div>

<div class="pl-n m-n form-group col-xs-6">
    <label class="control-label">Subject</label>
    <input type="text" class="form-control"  id="hfaWarningSend_subject" name="hfaWarningSend_subject" value="<?php if(isset($warningDetails) && !empty($warningDetails)){echo $warningDetails['subject'];}?>" required/>
</div>
                
<div class="m-n form-group" style="clear:both;">
    <label class="control-label">Email content</label>
    <textarea  rows="4" class="form-control" id="hfaWarningSend_emailContent" name="hfaWarningSend_emailContent" required><?php if(isset($warningDetails) && !empty($warningDetails)){echo $warningDetails['content'];}?></textarea>
</div>


<!--<?php if(isset($warningDetails)){?>
	<input type="hidden" name="warningId" id="warningId" value="<?=$warningDetails['id']?>" />
	<input type="hidden" name="hfaWarningSend_hfaId" value="<?=$warningDetails['hfa_id']?>" />
<?php }else{ ?>
	<input type="hidden" name="hfaWarningSend_hfaId" value="<?=$hfa_id?>" />
<?php } ?>     -->       

<input type="hidden" name="warningId" id="warningId" value="<?php if(isset($warningDetails)){echo $warningDetails['id'];}?>" />
<input type="hidden" name="hfaWarningSend_hfaId" value="<?=$hfa_id?>" />