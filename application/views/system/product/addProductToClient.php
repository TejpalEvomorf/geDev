<ul class="nav nav-tabs material-nav-tabs stretch-tabs icon-tabs">
  <li class="active">
  <a href="#filterMatches-primaryTab" data-toggle="tab" class="prices-edit">
      Apply product to clients
  </a></li>
  </ul>
  
<form id="addProductToClientForm">
    <table class="table">
        <tbdody>
              <tr>
                  <td style="padding:0 10px;">
                      <div class="width-full">
                          <label for="p_name" class="control-label">Product name</label>
                          <p class="widget-heading"><?=$product['name']?></p>
                      </div>
                  </td>
              </tr> 
              <tr>
                  <td> 
                  <div class="width-full">
                          <label class="control-label author checkbox transparent">This product applies to</label>
                      </div> 
                      <div class="radio block radio_block">
                      
                        <label>
                                <input type="radio" name="productClient" value="0"  <?php if($product['clients']==''){echo 'checked';}?>>
                                <span class="circle"></span>
                                <span class="check"></span>
                                All Clients
                        </label>
                         </div>
                         <div class="radio block radio_block">
                        <label>
                                <input type="radio" name="productClient" value="1"    <?php if($product['clients']!=''){echo 'checked';}?>>
                                <span class="circle"></span>
                                <span class="check"></span>
                                Selected clients
                        </label>
     			 </div>
                 <div class="col-xs-12 productClientListDiv" <?php if($product['clients']==''){echo 'style="display:none;"';}?>>
                 <label class="control-label author transparent">Select specific clients</label>
                                  <div class="checkbox-inline icheck pull-left p-n">
                                  <?php 
								  $productClients=explode(',',$product['clients']);
								  foreach($clients as $client){?>
                                      <div class="checkbox">
                                          <div class="checkbox block"><label><input name="productClientList[]" <?php if(in_array($client['id'],$productClients)){echo 'checked';}?> type="checkbox" value="<?=$client['id']?>"><span class="checkbox-material"><span class="check"></span></span> <?=$client['bname']?></label></div>
                                      </div>
                                      <?php } ?>
                                  </div>
                              </div>
                  </td>
              </tr> 
               <tr height="150">
               <td></td>
               </tr>
      </tbdody>
    </table>
    
   <input type="hidden" name="id" value="<?=$product['id']?>" />
</form>
  
  <div id="addNewDefaultProductSubmitBtnDiv">
	<input type="button" value="Apply" class="m-n btn btn-raised btn-info" onclick="addProductToClientSubmit();">
</div>

<script type="text/javascript">
$(document).ready(function(){
	$('input[name=productClient]').click(function(){
	if($('input[name=productClient]:checked').val()==1)
		$('.productClientListDiv').show();
	else	
		$('.productClientListDiv').hide();
	});
});
</script>