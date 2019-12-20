<?php
$stateList=stateList();
?>
<div class="page-heading">
      <h1>Caregiver companies list</h1>
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
                                  <th>Caregiver companies</th>
                                  <th>Incharge</th>
                                  <th>No of caregivers</th>
                                  <th width="60px">Actions</th>
                              </tr>
                          </thead>
                          <tbody>
                                <?php foreach($companies as $cK=>$cV){
									$caregivers=getCaregiversByCompany($cV['id']);
                                    ?>
                                      <tr class="odd gradeX" id="CGCompany-<?=$cV['id']?>">
                                      
                                          <td>
                                              <a href="<?=site_url()?>caregiver/edit_company/<?=$cV['id']?>" target="_blank"><?=$cV['name']?></a>
                                              <?php if($cV['abn']!=''){echo '<br>'.$cV['abn'];}?>
                                              <?php 
											  	$companyDetail=array();
											  	if($cV['street_address']!='' || $cV['suburb']!='' || $cV['state']!='' || $cV['postcode']!='')
											  	{
													if(trim($cV['street_address']!=''))
											  			$companyDetail[]=$cV['street_address'];
													if(trim($cV['suburb']!=''))	
														$companyDetail[]=$cV['suburb'];
													if(trim($cV['state']!=''))
														$companyDetail[]=$stateList[$cV['state']];
													if(trim($cV['postcode']!=0))	
														$companyDetail[]=$cV['postcode'];
											  	}
												if(!empty($companyDetail))
													echo '<br>';
												echo implode(', ',$companyDetail);
												?>
                                          </td>
                                           
                                           <td><?=$cV['i_name'].'<br>'.$cV['i_email'].'<br>'.$cV['i_phone']?></td>
                                           <td><?=count($caregivers)?></td>
                                            
                                          <td>
                                            <div class="btn-group dropdown table-actions">
                                              <button class="btn btn-sm btn-midnightblue dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="true">
                                                  <i class="colorBlue material-icons">more_horiz</i>
                                                  <div class="ripple-container"></div>
                                              </button>
                                              <ul class="dropdown-menu" role="menu">
                                                  <li>
                                                  <a href="<?=site_url()?>caregiver/edit_company/<?=$cV['id']?>" target="_blank"><i class="font16 material-icons">edit</i>&nbsp;&nbsp;Edit</a>
                                                  </li>
                                                  <?php if(empty($caregivers)){?>
                                                      <li>
                                                      <a href="javascript:;" class="CGCompanyDelete" id="CGC-<?=$cV['id']?>"><i class="font16 material-icons">delete</i>&nbsp;&nbsp;Delete</a>
                                                      </li>
                                                  <?php } ?>
                                                    <li>
                                                        <a href="<?=site_url()?>caregiver/manage/<?php echo $cV['id'];?>" target="_blank"><i class="font16 material-icons">edit</i>&nbsp;&nbsp;Manage caregivers</a>
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

<script type="text/javascript">
  $(document).ready(function() {
    var tabToOpen = window.location.hash;
    if (tabToOpen != '' && tabToOpen == '#CGCCreated') {
      notiPop('success','Caregiver company added successfully','')
      window.location.hash = '';
    }
  });
</script>