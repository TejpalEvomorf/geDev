<?php
$itemIdArray=explode('_',$itemId);
$items=$invoice['items'];

foreach($items as $item)
{
	if($item['id']==$itemIdArray[1])
	{
?>
    <div class="m-n form-group">
              <label class="control-label">Description</label>
              <input type="text" class="form-control" id="addNewItem_description" name="description" value="<?=$item['desc']?>" required>
    </div>

    <div class="m-n form-group col-xs-4" style="padding-left:0;">
        <label class="control-label">Quantity</label>
        <input type="text" class="form-control" id="addNewItem_quantity" value="<?=$item['qty']?>"  name="quantity" required data-parsley-type="number" readonly="readonly">
    </div>
    
    <div class="m-n form-group col-xs-4">
    		<label class="control-label">Quantity unit</label>
        	<select class="form-control" id="addNewItem_qty_unit" name="qty_unit" disabled="disabled">
	            <option value="0" <?php if($item['qty_unit']=='0'){echo "selected";}?> disabled="disabled">N/A</option>
            	<option value="1" <?php if($item['qty_unit']=='1'){echo "selected";}?> disabled="disabled">Week</option>
                <option value="2" <?php if($item['qty_unit']=='2'){echo "selected";}?> disabled="disabled">Day</option>
        	</select>
    </div>
    
    <div class="m-n form-group col-xs-4" style="padding-right:0;">
        <label class="control-label">Unit price</label>
        <input type="text" class="form-control" id="addNewItem_unit_price" name="unit_price" value="<?=$item['unit']?>" required  data-parsley-type="number">
    </div>
    
    <input type="hidden" name="invoice_id" id="invoice_id" value="<?=$invoice['id']?>" />
    <input type="hidden" name="itemId" value="<?=$item['id']?>">
<?php }} ?>