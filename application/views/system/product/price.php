<style type="text/css">
#tab-price-1 .about-area table > tbody > tr > td
{
	padding:10px;
}
</style>

<div class="page-heading pricing-page-heading">
      <h1 id="pricePageHeading"><?php if($year==date('Y')){echo 'Current';}else{echo 'Next';} echo ' year - '.$year;?></h1> 
      
       <? //php if(!empty($products)){?>
<!--      <div class="client-button pull-right">
      <button class="btn btn-primary custom-button" id="productClient-default" style="" onclick="clientProductsList('default',<?=$year?>);$('#clientProductListHeading').text('Default products pricing');">
                 <i class="colorBlue fa fa-eye custom-i-icon-eye"></i>
                <span class="colorBlue">Default products</span>          
      </button>
      </div>-->
      <? //php } ?>
           
       <div class="pull-right">
      <?php if(!empty($products)){?>
	      <a href="<?=site_url()?>product/export/<?=$year?>">
          <button id="exportProducts" class="btn btn-default" href="#">
          <i class="fa fa-download colorBlue custom-i-icon"></i>
          <span class="colorBlue">Export</span>
          </button></a>
      <?php } ?>
      </div>
      
      <?php if(!empty($products)){?>
          
          <div class="pull-right pricing-new-product">
          <?php if($year==date('Y') || $year==date('Y', strtotime("+1 year"))){?>
              <button class="btn btn-primary" id="addDefaultProduct"  data-toggle="modal" data-target="#model_AddNewProduct" style="display:none">
               <i class="colorBlue fa fa-plus" style="font-size:13px;"></i>
              <span class="colorBlue">Add new product</span>          
              </button>
          <?php } ?>
          </div>
      <?php } ?>
</div>

<div class="container-fluid">
  <?php if(!empty($products)){?>                               
          <div data-widget-group="group1">
              <div class="row">
                  
                  
          
                              <div class="p-n col-md-12 tab-content">
                                  <div class="tab-pane active" id="tab-price-1">
                                      <?php $this->load->view('system/product/clients');?> 
                                  </div>
                                  
                              </div>
                          
              </div>
          </div>
<?php }else { ?>
<div class="col-md-6 col-md-6-pricing">
        <div class="panel panel-profile panel panel-bluegraylight">
            <div class="panel-heading">
                <h2>Import products</h2>
            </div>
            <div class="panel-body">
                  
              <form class="tabular-form" id="importProductsForm" action="<?=site_url()?>product/import" method="post" enctype="multipart/form-data">
              <div class="form-group">
                  <label for="importProductsDate" class="control-label">Date</label>
                  <input type="text" class="form-control" id="importProductsDate" name="importProductsDate" placeholder="Date" required autocomplete="OFF">
              </div>
              <div class="form-group">
                  <label class="control-label" for="importProductsFile">Select file</label>
                  <input type="file" id="importProductsFile" name="importProductsFile">
                  <div class="col-sm-13 input-group">
                      <input type="text" readonly="" id="importProductsFileText" name="importProductsFileText" class="form-control" placeholder="Select file"  required>
                      <span class="input-group-btn input-group-sm">
                        <button type="button" class="btn btn-fab btn-fab-mini">
                            <i class="material-icons">attach_file</i>
                        </button>
                      </span>
                  </div>
              </div>	
              <div class="row">
                  <div class="col-sm-8">
                      <input type="button" class="btn-raised btn-primary btn" id="importProductsSubmit" value="Import">
                      <img src="<?=loadingImagePath()?>" id="importProductsFormProcess" style="display:none;">
                  </div>
              </div>	
              <input type="hidden" name="importProductsYear"	value="<?=$year?>" />
              </form>
                  
            </div>
        </div>
    </div>
<?php } ?>
                            </div>

<script type="text/javascript">
var pageYear='<?=$year?>';	
$(document).ready(function(){
	var tabToOpen=window.location.hash;
	if(tabToOpen!='')
		$('.nav-tabs a[href="'+tabToOpen+'"]').tab('show');
		
		if(tabToOpen=='#imported')
		{
			notiPop('success','Products imported successfully',"");
			//window.location.hash='';
			history.pushState('', document.title, window.location.pathname);
		}
		
		$('#importProductsDate').datepicker({
			orientation: "top",
			todayHighlight: true,
	    	startDate: "1/1/<?=$year?>",
			format:'dd/mm/yyyy',
			autoclose:true
		});
		
		$('#product_name').change(function(){
				$('#product_code').val($(this).val());
			});
});
</script>

<?php if(!empty($products)){?>
      <div class="modal fade" id="model_AddNewProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h2 class="modal-title">Add new default product</h2>
                      </div>
                      
                      <div class="modal-body">
                          <form id="addNewDefaultProductForm">
                          
                               <div class="form-group m-n">
                                    <label for="product_name" class="control-label">Product name</label>
                                    <input type="text" class="form-control"  id="product_name" name="product_name"   placeholder="Name" required>
                                </div>
                          
                               <div class="form-group m-n col-xs-6 left">
                                  <label for="product_code" class="control-label">Product code</label>
                                  <input type="text" class="form-control" id="product_code" name="product_code"   placeholder="Code" disabled required>
                              </div>
                              
                              <div class="form-group m-n col-xs-6 right">
                                  <label for="product_xero_code" class="control-label">Xero code</label>
                                  <input type="text" class="form-control" id="product_xero_code" name="product_xero_code"   placeholder="Xero code"  required data-parsley-type="number">
                              </div>
                              
                              <div class="form-group m-n col-xs-6 left">
                                  <label for="product_price" class="control-label">Product price</label>
                                  <input type="text" class="form-control" id="product_price" name="product_price"   placeholder="Price" required data-parsley-type="number">
                              </div>
                              
                              <div class="form-group m-n col-xs-6 right">
                                  <label for="product_cost" class="control-label">Product cost</label>
                                  <input type="text" class="form-control" id="product_cost" name="product_cost"   placeholder="Cost" required data-parsley-type="number">
                              </div>
                          
                              <div class="form-group m-n" style="position:unset;">
                                  <label for="radio" class="control-label">GST</label>
                                  <div class="col-sm-12">
                                      <div class="radio block">
                                          <label>
                                              <input type="radio" name="product_gst" value="1"  required>
                                              <span class="circle"></span>
                                              <span class="check"></span>
                                              Inc.
                                          </label>
                                          
                                          <label>
                                              <input type="radio" name="product_gst"value="0" required>
                                              <span class="circle"></span>
                                              <span class="check"></span>
                                              Free
                                          </label>
                                      </div>
                                  </div>
                              </div>
                          
                             <input type="hidden" name="year" value="<?=$year?>" />
                          </form>                
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-success btn-raised" id="addNewDefaultProductSubmitBtn" onclick="addNewDefaultProductSubmit();">Submit</button>
                          <img src="<?=loadingImagePath()?>" id="addNewDefaultProductSubmitProcess" style="margin-right:16px;display:none;">
                      </div>
                  </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->
      
      </div>
<?php } ?>