<?php
$itemIdArray=explode('_',$itemId);
$items=$po['items'];

$poDateFrom=$po['from'];
$poDateTo=$po['to'];


foreach($items as $item)
{
	if($item['id']==$itemIdArray[1])
	{
		$itemType=$item['type'];
		$itemDesc=$item['desc'];
		$itemQty=$item['qty'];
		
		$accomodationField=false;
		if(in_array($itemType,array('accomodation','accomodation_ed')))
        	$accomodationField=true;
?>
    <div class="m-n form-group">
              <label class="control-label">Description</label>
              <input type="text" class="form-control" id="addNewItem_description" name="description" value="<?=$item['desc']?>" required>
    </div>
    <div class="m-n form-group col-xs-4" style="padding-left:0;">
        <label class="control-label">Quantity</label>
        <input type="text" class="form-control" id="addNewItem_quantity" value="<?=$item['qty']?>"  name="quantity" required data-parsley-type="number" <?php if($item['type']!='custom'){?>readonly="readonly"<?php } ?>>
    </div>
    
    <div class="m-n form-group col-xs-4">
    		<label class="control-label">Quantity unit</label>
        	<select class="form-control" id="addNewItem_qty_unit" name="qty_unit" <?php if($accomodationField){?>disabled="disabled"<?php } ?>>
            <?php if($accomodationField){?>
	            <option value="0"  <?php if($item['qty_unit']==0){echo 'selected="selected"';}?>>N/A</option>
            	<option value="1"  <?php if($item['qty_unit']==1){echo 'selected="selected"';}?>>Week</option>
                <option value="2"  <?php if($item['qty_unit']==2){echo 'selected="selected"';}?>>Night</option>
             <?php }else{?>
	             <?php if($item['qty_unit']==2){?>
		            <option value="2"  <?php if($item['qty_unit']==2){echo 'selected="selected"';}?>>Night</option> 
                <?php } else{?>
        	        <option value="3"  <?php if($item['qty_unit']==3){echo 'selected="selected"';}?>>Percent</option>
            	    <option value="4"  <?php if($item['qty_unit']==4){echo 'selected="selected"';}?>>Flat</option>
                <?php } ?>
             <?php }?>
        	</select>
            
            <?php if($accomodationField){?>
	           <input type="hidden"  id="addNewItem_qty_unit" name="qty_unit" value="<?=$item['qty_unit']?>"/>
			<?php } ?>
    </div>

    <div class="m-n form-group col-xs-4" style="padding-right:0;">
        <label class="control-label">Unit price</label>
        <input type="text" class="form-control" id="addNewItem_unit_price" name="unit_price" value="<?=abs($item['unit'])?>" required  data-parsley-type="number">
    </div>
     <input type="hidden" name="po_id" id="po_id" value="<?=$po['id']?>" />
     <input type="hidden" name="itemId" id="itemId" value="<?=$item['id']?>">
<?php }}?>

<script type="text/javascript">
	$(document).ready(function(){
		
		if('<?=$itemType?>'=='custom')
		{
			$("input#addNewItem_quantity").TouchSpin({
			  verticalbuttons: true,
			  min: 1
			});
		}
	});
</script>