<?php
$genderList=genderList();
?>
<div class="m-n form-group col-xs-6x">
        <label class="control-label">Firstname</label>
      <input type="text" class="form-control" id="addCG_fname"  name="addCG_fname" value="<?=$caregiver['fname']?>" required>
</div>
  
<div class="m-n form-group col-xs-6y">
    <label class="control-label">Lastname</label>
    <input type="text" class="form-control" id="addCG_lname"  name="addCG_lname" value="<?=$caregiver['lname']?>" required>
</div>

<div class="m-n form-group col-xs-6x">
        <label class="control-label">Phone</label>
      <input type="text" class="form-control" id="addCG_phone"  name="addCG_phone" value="<?=$caregiver['phone']?>" required>
</div>
  
<div class="m-n form-group col-xs-6y">
    <label class="control-label">Email</label>
    <input type="text" class="form-control" id="addCG_email"  name="addCG_email" value="<?=$caregiver['email']?>" data-parsley-type="email">
</div>

<div class="m-n form-group" style="clear:both;">
      <label class="control-label">Gender</label>
          <select class="form-control" id="addCG_gender" name="addCG_gender"  required>
                <option value="">Select gender</option>
                <?php foreach($genderList as $gK=>$gV){?>
                <option value="<?=$gK?>" <?php if($gK==$caregiver['gender']){echo 'selected';}?>><?=$gV?></option>
                <?php } ?>
          </select>
  </div>
<input type="hidden" id="caregiver_id" name="caregiver_id" value="<?=$caregiver['id']?>">