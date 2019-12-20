<div class="page-heading">
      <h1>APU company list</h1>
      
        <div class="m-n DTTT btn-group pull-right">
          <a class="btn btn-default" >
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
                        <table id="apuCompanyList" class="noborder0 table table-striped table-bordered table-fixed-header m-n" cellspacing="0" width="100%">
                          <thead>
                              <tr>
                                  <th>Company</th>
                                  <th>Contact details</th>
                                  <th width="60px">Actions</th>
                              </tr>
                          </thead>
                          <tbody>
                                <?php foreach($apuCompany as $apuCompanyK=>$apuCompanyV){
                                    ?>
                                      <tr class="odd gradeX" id="apuCompany-<?=$apuCompanyV['id']?>">
                                      
                                          <td>
                                              <a href="<?=site_url()?>apu_company/edit/<?=$apuCompanyV['id']?>"><?=ucwords($apuCompanyV['company_name'])?></a>
                                          </td>
                                            
                                          <td>
                                          	<?php echo $apuCompanyV['name']; if(trim($apuCompanyV['name'])!=''){echo "<br>";}?>
                                              <?=$apuCompanyV['phone']?>
                                              <br />
                                               <a class="mailto" href="mailto:<?=$apuCompanyV['email']?>"><?=$apuCompanyV['email']?></a>
                                         </td>
                                         
                                          <td>
                                            <div class="btn-group dropdown table-actions">
                                              <button class="btn btn-sm btn-midnightblue dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="true">
                                                  <i class="colorBlue material-icons">more_horiz</i>
                                                  <div class="ripple-container"></div>
                                              </button>
                                              <ul class="dropdown-menu" role="menu">
                                                  <li>
                                                  <a href="<?=site_url()?>apu_company/edit/<?=$apuCompanyV['id']?>" target="_blank"><i class="font16 material-icons">edit</i>&nbsp;&nbsp;Edit</a>
                                                  </li>
                                                  <!--<li>
                                                  <a href="javascript:;" class="apuCompanyDelete"><i class="font16 material-icons">delete</i>&nbsp;&nbsp;Delete</a>
                                                  </li>-->
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
    if (tabToOpen != '' && tabToOpen == '#apuCreated') {
      notiPop('success','APU Company added successfully','')
      window.location.hash = '';
    }
  });
</script>