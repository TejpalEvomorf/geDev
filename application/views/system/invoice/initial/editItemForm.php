<?php
$itemIdArray=explode('_',$itemId);

if($invoiceType=='real')
	$items=$invoice['items'];
else	
	$items=$invoice['items_standard'];

$invoiceDateFrom=$invoice['booking_from'];
$invoiceDateTo=$invoice['booking_to'];


foreach($items as $item)
{
	if($item['id']==$itemIdArray[1])
	{
		$accomodationField=false;
		if($invoiceType!='standard' && in_array($item['xero_code'],array('42100','42300')) && $invoice['study_tour']=='0')
        	$accomodationField=true;
			
		$accomodationFieldStour=false;
		if($item['type']=='accomodation' && $invoice['study_tour']=='1')
			$accomodationFieldStour=true;
		
		$gaurdianshipField=false;
		if($invoiceType!='standard' && in_array($item['xero_code'],array('43200')))
        	$gaurdianshipField=true;	
		
		$itemType=$item['type'];
		$itemDesc=$item['desc'];
		$itemQty=$item['qty'];
?>
      <div class="m-n form-group">
          <label class="control-label">Description</label>
          <input type="text" class="form-control" id="addNewItem_description" name="description" value="<?=$item['desc']?>" required>
      </div>
      
      <div class="m-n form-group col-xs-4" style="padding-left:0;">
        <label class="control-label">Quantity</label>
        <input type="text" class="form-control" id="addNewItem_quantity" value="<?=$item['qty']?>"  name="quantity" required data-parsley-type="number" <?php if($accomodationField || $gaurdianshipField){?>readonly="readonly"<?php } ?>>
    </div>
      
      <div class="m-n form-group col-xs-4">
    		<label class="control-label">Quantity unit</label>
        	<select class="form-control" id="addNewItem_qty_unit" name="qty_unit" <?php if($accomodationField || $gaurdianshipField || $accomodationFieldStour){?>disabled="disabled"<?php } ?>>
	            <option value="0"  <?php if($item['qty_unit']==0){echo 'selected="selected"';}?>>N/A</option>
            	<option value="1"  <?php if($item['qty_unit']==1){echo 'selected="selected"';}?>>Week</option>
                <option value="2"  <?php if($item['qty_unit']==2){echo 'selected="selected"';}?>>Night</option>
        	</select>
            
            <?php if($accomodationField || $gaurdianshipField || $accomodationFieldStour){?>
	           <input type="hidden"  id="addNewItem_qty_unit" name="qty_unit" value="<?=$item['qty_unit']?>"/>
			<?php } ?>
    </div>

    <div class="m-n form-group col-xs-4" style="padding-right:0;">
        <label class="control-label">Unit price</label>
        <input type="text" class="form-control" id="addNewItem_unit_price" name="unit_price" value="<?=$item['unit']?>" required  data-parsley-type="number" >
    </div>

   
    
<!--1111111111111111111-->
<?php if($invoice['study_tour']=='1' && $item['type']=='accomodation')
{?>
	<input type="hidden" name="invoiceAddDaysAppId" value="<?=$item['application_id']?>" />
    <input type="hidden" name="invoiceAddDaysGst" value="<?=$item['gst']?>" />
     <input type="hidden" name="invoiceAddDaysXero_code" value="<?=$item['xero_code']?>" />

    <div class="m-n form-group col-xs-4" style="padding-left:0;">
        <label class="control-label">Quantity</label>
        <input type="text" class="form-control" id="invoiceAddDaysQuantity" value="<?php if(!empty($invoice['dayItemDetails'])){echo $invoice['dayItemDetails']['qty'];}else{echo '0';}?>"  name="invoiceAddDaysQuantity" required data-parsley-type="number">
    </div>
      
      <div class="m-n form-group col-xs-4">
    		<label class="control-label">Quantity unit</label>
        	<select class="form-control" id="invoiceAddDaysQty_unit_disabled" name="invoiceAddDaysQty_unit_disabled" disabled="disabled">
	            <option value="2">Night</option>
        	</select>
            <input type="hidden" id="invoiceAddDaysQty_unit" name="invoiceAddDaysQty_unit" value="2" />
    </div>

    <div class="m-n form-group col-xs-4" style="padding-right:0;">
        <label class="control-label">Unit price</label>
        <input type="text" class="form-control" id="invoiceAddDaysUnit_price" name="invoiceAddDaysUnit_price" value="<?php if(!empty($invoice['dayItemDetails'])){echo $invoice['dayItemDetails']['unit'];}else{echo add_decimal($item['unit']/7);}?>" required  data-parsley-type="number" >
        <input type="hidden" class="form-control" id="invoiceAddDaysOldUnit_price" name="invoiceAddDaysOldUnit_price" value="<?php if(!empty($invoice['dayItemDetails'])){echo $invoice['dayItemDetails']['unit'];}else{echo add_decimal($item['unit']/7);}?>" required  data-parsley-type="number" >
    </div>

<?php } ?>    
<!--1111111111111111111-->

    <input type="hidden" name="unit_priceTemp" id="addNewItem_unit_priceTemp" value="<?=$item['unit']?>" />
    <input type="hidden" name="invoice_id" id="invoice_id" value="<?=$invoice['id']?>" />
    <input type="hidden" name="itemId" value="<?=$item['id']?>">
    <input type="hidden" name="invoiceType" value="<?=$invoiceType?>">
     <?php if($invoice['study_tour']=='1' && $item['type'] == ('placement' || 'accomodation' || 'accomodation_ed')){ ?>
	    <input type="hidden" name="productType" value="<?=$item['type']?>"/>
	  	<div class="m-n custom-control custom-checkbox">
	    <label class="custom-control-label" ><input type="checkbox" class="custom-control-input" id="applytoAll" name="applytoAll" value="1"> 
	    Apply to all</label>
		</div>
   
<?php }}}?>

<?php if($accomodationField){?>
    <p class="changeStatusWarningMsg">To change the duration of this invoice item you have to change the invoice duration.</p>
<?php }
elseif($gaurdianshipField){
 ?>
	 <p class="changeStatusWarningMsg">Visit <?php if($invoice['study_tour']=='0'){?><a target="_blank" href="<?=site_url().'sha/application/'.$invoice['application_id'].'#tab-8-4'?>"><?php } ?>Office use<?php if($invoice['study_tour']=='0'){?></a><?php } ?> section to update caregiving duration and then click on Reset button to update invoice.</p>
<?php } ?>

<?php if($invoice['study_tour']=='1'){?>
	<div class="alert alert-info_orange ui-pnotify-container" style="displaY:none;clear:both;" id="weekDayZeroAlert">Quantity for both weeks and nights can't be zero.<br>If you want to delete this accomodation item, use delete button.</div>
<?php } ?>

<script type="text/javascript">
$(document).ready(function(){
	
		var accomodationField='<?=$accomodationField?>';
		var gaurdianshipField='<?=$gaurdianshipField?>';
		if(!accomodationField && !gaurdianshipField)
		{
			$("input#addNewItem_quantity").TouchSpin({
			  verticalbuttons: true,
			  <?php if($invoice['study_tour']=='1' && $accomodationFieldStour){?>
			  min: 0
			  <?php }else{?>
			  min: 1
			  <?php }?>
			});
		}
		$("input#invoiceAddDaysQuantity").TouchSpin({
			  verticalbuttons: true,
			  min: 0
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
		
		$('#addNewItem_quantity').change(function(){
				if('<?=$itemType?>'=='accomodation' && '<?=$invoiceDateFrom?>'!='0000-00-00')
					{
						$('#editInitialInvoiceItemSubmit').hide();
						$.ajax({
								url:'<?=site_url()?>invoice/getToDateOnQtyChange',
								type:'POST',
								data:  {qty:$(this).val(),invoiceDateFrom:'<?=$invoiceDateFrom?>',itemDesc:'<?=$itemDesc?>'},
								success:function(data)
									{
										$('#addNewItem_description').val(data);
										if($('#weekDayZeroAlert').length==0)
											$('#editInitialInvoiceItemSubmit').show();
										else
										{
											 if($('#weekDayZeroAlert').is(':hidden'))
												 $('#editInitialInvoiceItemSubmit').show();
										}
									}
						});
					}
					else if('<?=$itemType?>'=='accomodation_ed' && '<?=$invoiceDateFrom?>'!='0000-00-00')
					{
						$('#editInitialInvoiceItemSubmit').hide();
						$.ajax({
								url:'<?=site_url()?>invoice/getEDDateOnQtyChange',
								type:'POST',
								data:  {qty:$(this).val(),qtyOld:'<?=$itemQty?>',invoiceDateTo:'<?=$invoiceDateTo?>',itemDesc:'<?=$itemDesc?>'},
								success:function(data)
									{
										$('#addNewItem_description').val(data);
										$('#editInitialInvoiceItemSubmit').show();
									}
						});
					}
			});
	
	
	<?php if($invoice['study_tour']=='1'){?>
	
		$('#addNewItem_quantity, #invoiceAddDaysQuantity').change(function(){
				var weekChange=$('#addNewItem_quantity').val();
				var dayChange=$('#invoiceAddDaysQuantity').val();
				
				if(weekChange=='0' && dayChange=='0')
				{
					$('#editInitialInvoiceItemSubmit').hide();
					$('#weekDayZeroAlert').show();
				}
				else
				{
					$('#editInitialInvoiceItemSubmit').show();
					$('#weekDayZeroAlert').hide();
				}
			})
	
	<?php } ?>
		
	});
	
</script>