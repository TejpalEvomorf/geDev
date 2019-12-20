<ul class="nav nav-tabs material-nav-tabs stretch-tabs icon-tabs">
  <li class="active">
  <a href="#filterMatches-primaryTab" data-toggle="tab" class="prices-edit">
      Edit product
  </a></li>
  </ul>
  
<form id="editProductForm">
    <table class="table">
        <tbdody>
              <tr>
                  <td>
                      <div class="width-full">
                          <label for="p_name" class="control-label">Product name</label>
                          <input type="text" class="form-control" id="product_name" name="product_name"  placeholder="Name" value="<?=$product['name']?>" disabled>
                      </div>
                  </td>
              </tr> 
              <tr>
                  <td>  
                      <div class="width-full">
                          <label for="p_name" class="control-label">Product code</label>
                          <input type="text" class="form-control" id="product_code" name="product_code"  placeholder="Code" value="<?=$product['code']?>" disabled>
                      </div>
                  </td>
              </tr> 
              <tr>
                  <td>
                      <div class="width-full m-n form-group">
                          <label for="p_name" class="control-label">Product price</label>
                          <input type="text" class="form-control" id="product_price" name="product_price"  placeholder="Price" value="<?=$product['price']?>" required data-parsley-type="number">
                      </div>
                  </td>
              </tr> 
              <?php //if($client_id=='0'){?>
             <tr>
                  <td>
                      <div class="width-full m-n form-group">
                          <label for="p_name" class="control-label">Product Cost</label>
                          <input type="text" class="form-control" id="product_cost" name="product_cost"  placeholder="Cost" value="<?=$product['cost']?>" required data-parsley-type="number">
                      </div>
                  </td>
              </tr>
              <tr>
                  <td> 
                  <?php if($client_id==0){?>
                  <div class="width-full m-n form-group">
                          <label for="p_name" class="control-label">GST</label>
                          
                          <div class="radio block radio_block">
                              <label>
                                        <input type="radio" name="product_gst" value="1"  <?php if($product['gst']==1){echo 'checked';}?>>
                                        <span class="circle"></span>
                                        <span class="check"></span>
                                       GST Inc.
                                </label>
                         </div>
                         <div class="radio block radio_block">
                                <label>
                                        <input type="radio" name="product_gst" value="0"  <?php if($product['gst']==0){echo 'checked';}?>>
                                        <span class="circle"></span>
                                        <span class="check"></span>
                                        GST Free
                                </label>
                         </div>
                          
                      </div> 
                      <?php }else{?>
                      <div class="width-full">
                          <label for="p_name" class="control-label">GST</label>
                          <input type="text" class="form-control" value="GST <?php  if($product['gst']==0){echo 'free';}else{echo 'Inc.';}?>" disabled>
                      </div>
                      <?php } ?>
                </td>
              </tr>
              
              <tr>
                  <td>
                      <div class="width-full m-n form-group">
                          <label for="p_name" class="control-label">Xero code</label>
                          <input type="text" class="form-control" value="<?=$product['xero_code']?>"  disabled>
                      </div>
                  </td>
              </tr>
              
               <tr height="150">
                  <td></td>
              </tr>
              <?php //} ?>
                 
        </tbdody>
    </table>   
    <input type="hidden" name="year" value="<?=$product['year']?>" />
    <input type="hidden" name="id" value="<?=$product['id']?>" />
    <?php if($client_id!=0){?>
	    <input type="hidden" name="client_id" value="<?=$client_id?>" />
        <?php } ?>
</form>
  
  <div id="addNewDefaultProductSubmitBtnDiv">
	<input type="button" value="Update" class="m-n btn btn-raised btn-info" onclick="editProductSubmit();">
</div>