

<div class="col-md-12"><p class="lead" style="color: #cccccc;">Showing prices for <span id="clientProductListHeading">Default products</span></p></div>

<div class="col-md-9 panel-profile eighty-percent">
<div class="">
							  
   
                        
          <div class="property-details-all tab-pane panel panel-success"  data-widget='{"draggable": "false"}'>                     
				<!--<div class="panel-heading">
					<h2 id="clientProductListHeading">All clients products pricing</h2>
                    <?php if($year==date('Y') || $year==date('Y', strtotime("+1 year"))){?>
                    <button class="btn btn-sm btn-default " id="addGuardianshipProduct">Add guardianship</button>
                    <?php } ?>
				</div>-->
							
                                <div class="about-area">
								<div id="clientProductList_processing" class="dataTables_processing">Processing...</div>
                                      <div class="panel-default">
                                        <div class="panel-body no-padding">
                                       
                                        </div>
                                        <div class="panel-footer"></div>
                                        </div>
                                  
							</div>
                           
                      </div>
                      
         </div>
</div>


<div class="col-md-3 twenty-percent">

<div class="panel panel-bluegraylight">


    <div class="submenu">
                               <div class="panel-heading">                                
                                      <h2 style="color:#9e9e9e;">Client-wise Products</h2>
                               </div>

              
                  <div class="panel-margin about-area panel-body" style="background: #eceff1;">
                        <div class="submenu-child">
                        

<div class="pt-n productClient custom" id="productClient-default" style="" onclick="clientProductsList('default',<?=$year?>);$('#clientProductListHeading').text('Default products');">
          <span>Default products</span>          
</div>
                        
                        	<div class="pt-n productClient custom" id="productClient-all" onclick="clientProductsList('all',<?=$year?>);$('#clientProductListHeading').text('All clients');">
                                <span >All clients</span>
                            </div>
                            
                        <?php foreach($clients as $clientK=>$clientV){
							if($clientK==0)
								$firstClient=$clientV['id'];
							?>
                            <div class="pt-n productClient custom" id="productClient-<?=$clientV['id']?>" onclick="clientProductsList(<?=$clientV['id']?>,<?=$year?>);$('#clientProductListHeading').text($(this).text());">
                                <span><?=$clientV['bname']?></span>
                            </div>
                           <?php } ?> 
                        </div>
                  </div>
                  
             
                  
    </div>
    
    <!--<div class="panel panel-profile panel panel-bluegraylight">
          <div class="panel-heading">
              <h2>Default prices</h2>
          </div>
          <div class="panel-body">
                <div>
                    <div class="personel-info pt-n productClient" id="productClient-default">
                        <span class="icon"><i class="material-icons">person</i></span>
                        <span onclick="clientProductsList('default',<?=$year?>);">Default prices</span>
                    </div>
                </div>
          </div>
    </div>-->
  
  </div>  
</div>


<script type="text/javascript">
$(document).ready(function(){
	clientProductsList('default',<?=$year?>);
	productListDatatable();
});
</script>