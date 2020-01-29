<?php
	  $products=clientProductsList($student['client'],date('Y'));
	  //see($products);
?>
<div class="m-n form-group col-xs-9x">
    <label class="control-label">Product</label>
        <select class="form-control" id="addNewItem_product" name="product" onchange="productOnChange();" required>
            <option value="">Select one</option>
			<?php foreach($products as $sK=>$sV){?>
                        <!--<option value="<?=$sV['price'].'-'.$sV['gst'].'-'.$sV['id'].'-'.$sV['xero_code']?>" ><?=$sV['name']?></option>-->
                    <?php } ?>
                    <option value="0-0-0-42100-custom" >Internet Fee</option>
                    <option value="0-0-0-42100-custom" >Caregiving Service Fee</option>
                    <option value="custom" >Custom</option>
        </select>
</div>

<div class="m-n form-group col-xs-9x">
    <label class="control-label">Description</label>
    <input type="text" class="form-control" id="addNewItem_description" name="description" value="" required>
</div>

<div class="m-n form-group col-xs-4" style="padding-left:0;">
    <label class="control-label">Quantity</label>
    <input id="addNewItem_quantity" value="1"  name="quantity" required data-parsley-type="number">
</div>

<div class="m-n form-group col-xs-4">
    <label class="control-label">Quantity unit</label>
    <select class="form-control" id="addNewItem_qty_unit" name="qty_unit" >
			    <option value="0" >N/A</option>
            	<option value="1" >Week</option>
                <option value="2" >Night</option>
        </select>
</div>

<div class="m-n form-group col-xs-4" style="padding-right:0;">
    <label class="control-label">Unit price</label>
    <input type="text" class="form-control" id="addNewItem_unit_price" name="unit_price" value="" required  data-parsley-type="number">
</div>

<input type="hidden" name="unit_priceTemp" id="addNewItem_unit_priceTemp" />
<input type="hidden" name="invoice_id" id="invoice_id" value="<?=$invoice['id']?>" />
<input type="hidden" name="gst" id="gst"/>
<input type="hidden" name="xero_code" id="xero_code"/>
<input type="hidden" name="product_id" id="product_id"/>
<input type="hidden" name="product_name" id="product_name"/>
<input type="hidden" name="product_type" id="product_type" value=""/>
<input type="hidden" name="client" value="<?=$student['client']?>"/>

<script type="text/javascript">
$(document).ready(function(){
		$("input#addNewItem_quantity").TouchSpin({
		  verticalbuttons: true,
		  min: 1
		});
		
		$('#addNewItem_qty_unit').data('val', $('#addNewItem_qty_unit').val());
		$('#addNewItem_qty_unit').on('focusin', function(){
   			 $(this).data('val', $(this).val());
		});
		
		$('#addNewItem_qty_unit').change(function(){
			var prev = $(this).data('val');
			var current=$(this).val();
			$(this).data('val', $(this).val());
			
			if(prev!='2' && current=='2')
			{
				$('#addNewItem_unit_priceTemp').val($('#addNewItem_unit_price').val()/7);
				$('#addNewItem_unit_price').val(parseFloat(parseFloat($('#addNewItem_unit_price').val()/7).toFixed(2)));
			}
			else if(prev=='2' && current!='2')
			{
				$('#addNewItem_unit_priceTemp').val($('#addNewItem_unit_priceTemp').val()*7)
				$('#addNewItem_unit_price').val(parseFloat(parseFloat($('#addNewItem_unit_priceTemp').val()).toFixed(2)));
			}
		});
		
		
		$('#addNewItem_unit_price').change(function(){
				$('#addNewItem_unit_priceTemp').val($(this).val());
			});
		
	});

function productOnChange()
{
	var id="#addNewItem_product";
	var price=$(id).val();
	var priceVal=price.split('-')[0];
	var gst=price.split('-')[1];
	var product_id=price.split('-')[2];
	var xero_code=price.split('-')[3];
	var productType=price.split('-')[4];
	
	$('#addNewItem_qty_unit').val(0);
	
	if(price!='' && price!='custom')
	{
		$('#addNewItem_unit_price, #addNewItem_unit_priceTemp').val(priceVal);
		$('#addNewItem_description').val($(id+' option:selected').text());
		$('#gst').val(gst);
		$('#product_id').val(product_id);
		$('#xero_code').val(xero_code);
		$('#product_name').val($('#addNewItem_product option:selected').text());
		$('#product_type').val(productType);
		
		if(price=='-0')
		{
			if($(id+' option:selected').text()=='Overseas Telegraphic Transfer')
				$('#product_type').val('ott');
			else if($(id+' option:selected').text()=='Credit Card Surcharge')
				$('#product_type').val('ccs');
		}
	}
	else
	{
		if(price=='custom')
			$('#product_type').val(price);
		$('#addNewItem_unit_price, #addNewItem_description, #gst').val('');
	}
}	
</script>