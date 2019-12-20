<?php
$clientCategories=clientCategories();
$stateList=stateList();
?>
<style type="text/css">
#clientList_filter
{
	margin:0 !important;
}
</style>
<div class="page-heading">
      <h1>Client list</h1>
      
        <div class="m-n DTTT btn-group pull-right">
              <a class="btn btn-default" id="clientFiltersBtn">
                  <i class="colorBlue fa fa-filter"></i> 
                  <span class="colorBlue">Filters</span>
              </a>
        </div>
        
        <div class="relposition panel-ctrls pull-right" id="clientPanelCtrls">
             <div class="m-n DTTT btn-group pull-right" id="clientSearchBtn">
             	<a class="btn btn-default">
                   <i class="colorBlue fa fa-search"></i>
                   <span class="colorBlue">Search</span>
                </a>
			 </div>
         </div>
       	 <div class="options"></div>
</div>


<?php
if(isset($_GET['clientCategory']) && ($_GET['clientCategory']!='')){?>
<div class="filterbtnhol">
<button class="mt-n btn btn-xs btn-danger btn-label clientRemoveFilter pull-right" href="#" filter="all">
<i class="fa fa-close"></i>
Reset filters
</button>
	<?php if($_GET['clientCategory']!=''){
				$clientCategory=$clientCategories[$_GET['clientCategory']];
		?>
        <button class="mt-n btn btn-xs btn-danger btn-label clientRemoveFilter pull-right" href="#" filter="clientCategory">
<i class="fa fa-close"></i>
<?=$clientCategory?>
</button>
<?php }?>
</div>
<?php } ?>

<div class="container-fluid">
    <div data-widget-group="group1">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body no-padding">
                        <table id="clientList" class="noborder0 table table-striped table-bordered table-fixed-header m-n" cellspacing="0" width="100%">
                          <thead>
                              <tr>
	                              <th>Logo</th>	
                                  <th>Business</th>
                                  <th>Contact</th>
                                  <th width="120px">Client type</th>
                                  <th width="300px">Agreement</th>
                                  <th width="60px" >Actions</th>
                              </tr>
                          </thead>
                          <tbody>
                                <?php foreach($clients as $clientK=>$clientV){
                                    ?>
                                      <tr class="odd gradeX" id="client-<?=$clientV['id']?>">
                                      
                                        <td>
                                            <?php if($clientV['image']!=''){?>
                                            <img src="<?=static_url()?>uploads/client/logo/thumbs/<?=$clientV['image']?>" height="70"/>
                                            <?php } ?>
                                        </td>
                                          
                                          <td>
                                              <a href="<?=site_url()?>client/edit/<?=$clientV['id']?>" target="_blank"><?=$clientV['bname']?></a>
                                              <br />
                                              <?php
											  $stringAddress='';
											  if(trim($clientV['suburb'])!='')
												  $stringAddress .=trim($clientV['suburb']);
											  if(trim($clientV['state'])!='')
											  {
												  if($stringAddress!='')
													  $stringAddress .='*';
												  $stringAddress .=trim($clientV['state']);
											  }
											  if(trim($clientV['postal_code'])!='' && $clientV['postal_code']!='0')
											  {
												  if($stringAddress!='')
													  $stringAddress .='*';
												  $stringAddress .=trim($clientV['postal_code']);
											  }
											
											echo $clientV['street_address'];
											if($clientV['street_address']!='' && $stringAddress!='')
												echo ', ';
											echo str_replace('*',', ',$stringAddress);
											?>
                                          </td>
                                            
                                          <td>
                                          	<?=ucwords($clientV['primary_contact_name'].' '.$clientV['primary_contact_lname'])?>
                                          	<br>
                                         	<a class="mailto" href="mailto:<?=$clientV['primary_email']?>"><?=$clientV['primary_email']?></a>
                                            <br />
                                            <?=$clientV['primary_phone']?>
                                         </td>
                                         
                                          <td><?=$clientCategories[$clientV['category']]?><?php if($clientV['category']==2 && $clientV['commission']=='1'){echo '<br><span style="color:#b0b0b0;">Commission: $'.$clientV['commission_val'].'</span>';}?></td>
                                         
                                         <td>
                                         	<?php
											if(isset($clientV['agreement'])){
                                            foreach($clientV['agreement'] as $agree)
              								{?>
                  								<p><a href="<?=static_url().'uploads/client/'.$agree['name']?>" target="_blank"><?=getFileTypeIcon($agree['name']).' '.$agree['name']?></a></p>
              							<?php }}?>
										</td>
                                         
                                           <td>
                                            <div class="btn-group dropdown table-actions">
                                              <button class="btn btn-sm btn-midnightblue dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="true">
                                                  <i class="colorBlue material-icons">more_horiz</i>
                                                  <div class="ripple-container"></div>
                                              </button>
                                              <ul class="dropdown-menu" role="menu">
                                                  <li>
                                                  <a href="<?=site_url()?>client/edit/<?=$clientV['id']?>" target="_blank"><i class="font16 material-icons">edit</i>&nbsp;&nbsp;Edit</a>
                                                  </li>
                                                  <li>
                                                  <a href="javascript:;" class="clientDelete"><i class="font16 material-icons">delete</i>&nbsp;&nbsp;Delete</a>
                                                  </li>
                                                </ul>
                                              </div>
                                           </td>
                                         </tr>
                                   <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="clientFiltersFormHidden">
<?php
if(isset($_GET['clientCategory']) && $_GET['clientCategory']!='')
	$clientCategory=$_GET['clientCategory'];
else
	$clientCategory='';	
?>
	<input type="hidden" name="clientCategory" value="<?=$clientCategory?>" />
</form>
