<?php $student=getshaOneAppDetails($po['student']);
$products=clientProductsList($student['client'],date('Y',strtotime($po['date'])));
$age=age_from_dob($student['dob']);
if($student['accomodation_type']==1)
	{
		if($age<18)
			$accomodation_type='Single Room 18-';
		if($age>=18)
			$accomodation_type='Single Room 18+';
	}
else if($student['accomodation_type']==2)
	{
			//$accomodation_type='Twin Share';
		if($age<18)
			$accomodation_type='Twin Share 18-';
		if($age>=18)
			$accomodation_type='Twin Share 18+';
	}
else if($student['accomodation_type']==3)					
		$accomodation_type='Self-Catered';		
else if($student['accomodation_type']==4)					
		$accomodation_type='VIP Single Room';
else if($student['accomodation_type']==5)					
		$accomodation_type='VIP Self-Catered';
				
$accomodationItemNameDesc=$po['booking_id'].', '.$student['fname'].' '.$student['lname'].', ';
foreach($products as $p)
				{
					if($p['name']==$accomodation_type)
					{
						$product=$p;
						$accomodationItemNameDesc .=$p['name'];
						break;
					}
					else
					continue;
				}					
?>

<div class="m-n form-group col-xs-9x">
    <label class="control-label">Product</label>
        <select class="form-control" id="addNewItem_product" name="product" onchange="productOnChange();" required>
            <option value="">Select one</option>
            <option value="<?=$product['cost'].'-'.$product['gst'].'-'.$accomodationItemNameDesc.'-accomodation'?>" ><?=$product['name'];?></option>
            <option value="custom-extra" >Family pickup service</option>
            <option value="custom-extra" >Dropoff service</option>
            <option value="custom-extra" >Internet service</option>
			<option value="custom" >Custom</option>
        </select>
</div>

<div class="m-n form-group col-xs-9x">
    <label class="control-label">Description</label>
    <input type="text" class="form-control" id="addNewItem_description" name="description" value="Custom" required>
</div>

<div class="m-n form-group col-xs-4" style="padding-left:0;">
    <label class="control-label">Quantity</label>
    <input id="addNewItem_quantity" value="1"  name="quantity" required data-parsley-type="number">
</div>

<div class="m-n form-group col-xs-4" style="padding-right:0;">
    <label class="control-label">Quantity unit</label>
    <select class="form-control" id="addNewItem_qty_unit" name="qty_unit" >
			    <option value="0" >N/A</option>
                <option value="1" >Weeks</option>
                <option value="2" >Days</option>
        </select>
</div>

<div class="m-n form-group col-xs-4">
    <label class="control-label">Unit price</label>
    <input type="text" class="form-control" id="addNewItem_unit_price" name="unit_price" value="" required  data-parsley-type="number">
</div>

<input type="hidden" name="po_id" id="po_id" value="<?=$po['id']?>" />
<input type="hidden" name="gst" id="gst" value="0"/>
<input type="hidden" name="xero_code" id="xero_code" value="52100"/>
<input type="hidden" name="product_type" id="product_type" value="custom"/>

<script type="text/javascript">
	$(document).ready(function(){
		$("input#addNewItem_quantity").TouchSpin({
		  verticalbuttons: true,
		  min: 1
		});
		
		$('#addNewItem_qty_unit').change(function(){
			if($(this).val()=='1')
				{
					var id="#addNewItem_product";
					var price=$(id).val();
					var priceVal=price.split('-')[0];
					$('#addNewItem_unit_price').val(priceVal);
				}
			else if($(this).val()=='2')
				{
					$('#addNewItem_unit_price').val(parseFloat(parseFloat($('#addNewItem_unit_price').val()/7).toFixed(2)));
				}
		});
	});
	
function productOnChange()
{
	var id="#addNewItem_product";
	var price=$(id).val();
	if(price.includes("custom"))
	{
		if(price!='custom')
			$('#addNewItem_description').val($(id+' option:selected').text());
		else
			$('#addNewItem_description').val('');	
		
		$('#addNewItem_unit_price').val('');
		$('#gst').val(0);
		//$('#product_type').val('custom');
		
	$("select#addNewItem_qty_unit option[value='1']").attr('disabled', true); 
	$("select#addNewItem_qty_unit option[value='2']").attr('disabled', true); 
	$("select#addNewItem_qty_unit option[value='0']").attr('disabled', false); 
	$("select#addNewItem_qty_unit").val('0'); 
	}
	else if(price!='')
	{
		var priceVal=price.split('-')[0];
		var gst=price.split('-')[1];
		var desc=price.split('-')[2];
		//var productType=price.split('-')[3];
		
		$('#addNewItem_description').val(desc);	
		$('#addNewItem_unit_price').val(priceVal);
		$('#gst').val(gst);
		//$('#product_type').val(productType);
		
		$("select#addNewItem_qty_unit option[value='1']").attr('disabled', false); 
		$("select#addNewItem_qty_unit option[value='2']").attr('disabled', false); 
		$("select#addNewItem_qty_unit option[value='0']").attr('disabled', true); 
		$("select#addNewItem_qty_unit").val('1'); 
	}
	else
	{
		$('#addNewItem_description').val('');	
		$('#addNewItem_unit_price').val('');
		$('#gst').val(0);
		//$('#product_type').val('custom');
		
		$("select#addNewItem_qty_unit option[value='1']").attr('disabled', false);
		$("select#addNewItem_qty_unit option[value='2']").attr('disabled', false);  
		$("select#addNewItem_qty_unit option[value='0']").attr('disabled', false); 
		$("select#addNewItem_qty_unit").val('0'); 
	}
}	
</script>