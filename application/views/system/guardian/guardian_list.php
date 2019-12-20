<?php
$stateList=stateList();
?>
<style type="text/css">
#guardianFiltersBtn
{
	margin:0 !important;
}
</style>
<div class="page-heading">
      <h1>Caregiver list</h1>
      
        <div class="m-n DTTT btn-group pull-right">
              <a class="btn btn-default" id="guardianFiltersBtn">
                  <i class="colorBlue fa fa-filter"></i> 
                  <span class="colorBlue">Filters</span>
              </a>
        </div>
        
        <div class="relposition panel-ctrls pull-right" id="listTablePanelCtrls">
             <div class="m-n DTTT btn-group pull-right" id="listTableSearchBtn">
             	<a class="btn btn-default">
                   <i class="colorBlue fa fa-search"></i>
                   <span class="colorBlue">Search</span>
                </a>
			 </div>
         </div>
       	 <div class="options"></div>
</div>


<div class="container-fluid">
    <div data-widget-group="group1">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body no-padding">
                        <table id="guardianList" class="noborder0 table table-striped table-bordered table-fixed-header m-n" cellspacing="0" width="100%">
                          <thead>
                              <tr>
                                  <th>Caregiver</th>
                                  <th>Company</th>
                                  <th>Incharge</th>
                                  <th width="60px">Actions</th>
                              </tr>
                          </thead>
                          <tbody>
                                <?php foreach($guardian as $guardianK=>$guardianV){
                                    ?>
                                      <tr class="odd gradeX" id="guardian-<?=$guardianV['id']?>">
                                      
                                          <td>
                                              <a href="<?=site_url()?>guardian/edit/<?=$guardianV['id']?>"><?=ucwords($guardianV['fname'].' '.$guardianV['lname'])?></a>
                                              <br />
                                              <?=$guardianV['phone']?>
                                              <br />
                                             <a class="mailto" href="mailto:<?=$guardianV['email']?>"><?=$guardianV['email']?></a>
                                          </td>
                                            
                                          <td>
                                          <?php
                                          $companyDetail=array();
										  $companyDetail[]=$guardianV['company_name'];
										   if($guardianV['street_address']!='' || $guardianV['suburb']!='' || $guardianV['state']!='' || $guardianV['postal_code']!='')
										   {
											   if(trim($guardianV['street_address']!=''))
											  		$companyDetail[]=$guardianV['street_address'];
												if(trim($guardianV['suburb']!=''))	
													$companyDetail[]=$guardianV['suburb'];
												if(trim($guardianV['state']!=''))
													$companyDetail[]=$stateList[$guardianV['state']];
												if(trim($guardianV['postal_code']!=0))	
													$companyDetail[]=$guardianV['postal_code'];
										   }
										   echo implode(', ',$companyDetail);
										  ?>
                                          <br />
                                            <?=$guardianV['abn']?>
                                         </td>
                                         
                                          <td>
										  	<?php
                                            echo ucwords($guardianV['incharge_name']);
											if($guardianV['incharge_phone']!='')
	                                            echo "<br>".$guardianV['incharge_phone'];
                                            if($guardianV['incharge_email']!='')
												echo "<br>".$guardianV['incharge_email'];
                                            ?>
                                          </td>
                                         
                                           <td>
                                            <div class="btn-group dropdown table-actions">
                                              <button class="btn btn-sm btn-midnightblue dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="true">
                                                  <i class="colorBlue material-icons">more_horiz</i>
                                                  <div class="ripple-container"></div>
                                              </button>
                                              <ul class="dropdown-menu" role="menu">
                                                  <li>
                                                  <a href="<?=site_url()?>guardian/edit/<?=$guardianV['id']?>" target="_blank"><i class="font16 material-icons">edit</i>&nbsp;&nbsp;Edit</a>
                                                  </li>
                                                  <?php if($guardianV['id']!=8){?>
                                                      <li>
                                                      <a href="javascript:;" class="guardianDelete"><i class="font16 material-icons">delete</i>&nbsp;&nbsp;Delete</a>
                                                      </li>
                                                  <?php } ?>
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
<script type="text/javascript">
  $(document).ready(function() {
    var tabToOpen = window.location.hash;
    if (tabToOpen != '' && tabToOpen == '#guardianCreated') {
      notiPop('success','Caregiver added successfully','')
      window.location.hash = '';
    }
  });
</script>