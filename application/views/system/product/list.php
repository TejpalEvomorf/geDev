<?php 
$tableId='clientProductList';
$editLinkClass='editProduct';
$codePrefix='';
$editLinkClientId='';
?>
<table id="<?=$tableId?>" class="noborder0 table table-striped table-bordered m-n" cellspacing="0" width="100%">
 <thead>
          <tr>
              <th>Product Name</th>
              <th>Product code</th>
              <th width="70px">Xero code</th>
              <th width="40px">GST</th>
              <th width="40px">Price</th>
              <th width="40px">Cost</th>
              <th width="60px">Actions</th>
          </tr>
      </thead>
      <tbody>
      <?php foreach($products as $product){
		  $gstVal='Free';
		  if($product['gst']==1)
				  $gstVal='Inc.';
		 
			  
			  if(isset($product['client']))
				{
					$editLinkClass='editClientProduct';
					$codePrefix=$product['client']['bname'].' ';
					if($client_id=='all')
						$codePrefix='';
					$editLinkClientId='-'.$product['client']['id'];
				}
		  ?>
                <tr class="odd gradeX" id="product-<?=$product['id']?>">
                    <td>
                      <?=ucwords($product['name'])?>
					  <?php if($client_id=='default'){?>
                      <br><i style="color:#b0b0b0;">Applies to <?php if($product['clients']==''){echo 'All clients';}else{echo 'Selected clients';}?></i>
                      <?php }?>
                    </td>
                    <td>
                      <?=$codePrefix.$product['code']?>
                    </td>
                    <td>
                      <?=$product['xero_code']?>
                    </td>
                    <td>
                      <?=$gstVal?>
                    </td>
                    <td>
                      <?='$'.$product['price']?>
                    </td>
                    <td>
			              <?='$'.$product['cost']?>
                    </td>
    		        <td>
                         <div class="btn-group dropdown table-actions">
                          <button class="btn btn-sm btn-midnightblue dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="true">
                              <i class="colorBlue material-icons">more_horiz</i>
                              <div class="ripple-container"></div>
                          </button>
                          <ul class="dropdown-menu dropdown-menu-sidebar" role="menu">
                              <li>
                              <a href="javascript:void(0);" class="<?=$editLinkClass?>" id="editProduct-<?=$product['id'].$editLinkClientId?>"><i class="font16 material-icons">edit</i>&nbsp;&nbsp;Edit</a>
                              </li>
                              <?php if(!isset($product['client'])){?>
                                  <li>
                                      <a href="javascript:void(0);" class="addProductToClient" id="addProductToClient-<?=$product['id']?>"><i class="font16 material-icons">assistant_photo</i>&nbsp;&nbsp;Applies to</a>
                                  </li>
                              <?php }?>
                             </ul>
                          </div>
                    </td>
                </tr>
      <?php }?>
      </tbody>
 </table>