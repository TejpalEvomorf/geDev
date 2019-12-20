<?php //see($result);?>


<div class="page-heading">
      <h1>	Search All</h1>
        
        
        
        
</div>




<div class="container-fluid">                                
    <div data-widget-group="group1">
        <div class="row">
            <div class="col-md-12">
                
        <div class="panel panel-default" style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
           
            <div class="panel-body no-padding table-responsive">
                <div class="p-md">
                        <h4 class="mb-n"><?=   @$_GET['value']  ?><small>Search value</small></h4>
                </div>
                
                <div class="list-group">
				<?php  if(!empty($result)){ 
		foreach($result as $k=>$val1){
				if (is_numeric($_GET['value']) ){
			if($k=='host'){
				$surl=site_url().'hfa?type=global&host='.@$_GET['value'];	

			}else if($k=='student'){
				$surl=site_url().'sha?type=global&student='.@$_GET['value'];	
			}else if($k=='booking'){
				$surl=site_url().'booking?type=global&booking_id='.@$_GET['value'];	
			}else if($k=='initial invoice'){
				$surl=site_url().'invoice/initial_all?type=global&number='.@$_GET['value'];	
			}else if($k=='ongoing invoice'){
				$surl=site_url().'invoice/ongoing_all?type=global&number='.@$_GET['value'];	
			}else if($k=='purchase orders'){
				$surl=site_url().'purchase_orders/all?type=global&number='.@$_GET['value'];	
			}
			}else{
				
				if($k=='host'){
				$surl=site_url().'hfa?type=global&host='.@$_GET['value'];
				
			}else if($k=='student'){
				$surl=site_url().'sha?type=global&student='.@$_GET['value'];	
			}
			else if($k=='initial invoice'){
				$surl=site_url().'invoice/initial_all?type=global&student='.@$_GET['value'];	
			}else if($k=='ongoing invoice'){
				$surl=site_url().'invoice/ongoing_all?type=global&student='.@$_GET['value'];	
			}else if($k=='purchase orders'){
				$surl=site_url().'purchase_orders/all?type=global&host='.@$_GET['value'];	
			}
			}
			
			
			
			if($k=='host'){
				$result_icon="home";	
			}else if($k=='student'){
				$result_icon="face";	
			}else if($k=='booking'){
				$result_icon="domain";	
			}else if($k=='initial invoice'){
				$result_icon="monetization_on";	
			}else if($k=='ongoing invoice'){
				$result_icon="monetization_on";	
			}else if($k=='purchase orders'){
				$result_icon="receipt";	
			}
						
			
				?>
                
                    <div class="list-group-item withripple">
                        <div class="row-action-primary">
                            <div class="progress-pie-chart"><i class="material-icons"><?php echo $result_icon; ?></i></div>
                        </div>
						<?php foreach( $result[$k] as  $val ) {
							if (!is_numeric($_GET['value']) ){
								if($k=='booking' &&  !empty($val['hostu'])){
									$surl=site_url().'booking?type=global&host='.@$_GET['value'];	
								}if($k=='booking' &&  !empty($val['shau'])){
									$surl=site_url().'booking?type=global&student='.@$_GET['value'];	
									
								}
							}
							
							?>
                        <div class="row-content">
                            <div class="least-content">
                               <a href="<?php  echo @$surl ?>" class="btn btn-info">View</a>
                            </div>
							
                            <h4 class="list-group-item-heading"><?php  echo ucfirst($k) ?></h4>
                            <p class="list-group-item-text"><a href="<?php  echo @$surl ?>"><?=   @$_GET['value']  ?></a></p>
                        </div>
						<?php  } ?>
                        
                        
                    </div>
                    <div class="list-group-separator"></div>
                    
                  
                    <?php  }}?>
                </div>
				
            </div>
        </div>
    
            </div>
        </div>
    </div>
</div>


