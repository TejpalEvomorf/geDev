<?php
$loggedInUser=loggedInUser();
if($loggedInUser['user_type']==1)
{
$employeeDesignationList=employeeDesignationList();
$genderList=genderList();
$officeList=officeList();

?>

      <thead>
          <tr>
              <th width="100px">Image</th>
              <th>Employee</th>
              <th>Contact</th>
              <th>Office</th>
              <th width="60px">Actions</th>
          </tr>
      </thead>
      <tbody>
            <?php foreach($employees as $clientK=>$clientV){
                ?>
                  <tr class="odd gradeX" id="employee-<?=$clientV['id']?>">
                  
                      <td>
						 <?php if($clientV['image']!=''){?>
                                <img src="<?=static_url()?>uploads/employee/<?=$clientV['image']?>" height="70"/>
                         <?php } else{?>
                         <img src="<?=static_url().'system/img/default-'.strtolower($genderList[$clientV['gender']]).'-employee.jpg'?>" height="70"/>
                         <?php } ?>
                     </td>
                     
                      <td>
                          <a href="javascript:void(0);" onclick="editEmployeeForm(<?=$clientV['id']?>);"><?=ucwords($clientV['fname'].' '.$clientV['lname'])?></a>
                          <p id="employeeDesignation-<?=$clientV['id']?>" class="employeeListTdP"><?=$employeeDesignationList[$clientV['designation']]?></p>
                          <p data-placement="bottom"  data-toggle="tooltip"  data-original-title="Extension number" style="width:95px;"><?=$clientV['phone_office']?></p>
                      </td>
                        
                      <td>
                      	<span class="employeeListTdP"><?=$clientV['phone']?></span><br />
                        <span class="employeeListTdP" style="position:relative;"><?=$clientV['email_company']?><i class="material-icons contactWayGreenTic" data-placement="bottom"  data-toggle="tooltip"  data-original-title="EMAIL ID used for login"  style="cursor:default;right:unset;">chevron_left</i></span><br />
                        <span class="employeeListTdP"><?=$clientV['email_personal']?></span>
                      </td>
                      
                      <td>
                      	<span class="employeeListTdP"><?=$officeList[$clientV['office']]?></span><br />
                      </td>
                      
                        <td>
                        <div class="btn-group dropdown table-actions">
                          <button class="btn btn-sm btn-midnightblue dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="true">
                              <i class="colorBlue material-icons">more_horiz</i>
                              <div class="ripple-container"></div>
                          </button>
                          <ul class="dropdown-menu" role="menu">
                              <li>
                              <a href="javascript:void(0)" onclick="$('#employee-<?=$clientV['id']?> td:nth-child(2) > a').trigger('click');"><i class="font16 material-icons">edit</i>&nbsp;&nbsp;Edit</a>
                              </li>
                              <li>
                              <a href="javascript:;" class="employeeDelete"><i class="font16 material-icons">delete</i>&nbsp;&nbsp;Delete</a>
                              </li>
                            </ul>
                          </div>
                       </td>
                     </tr>
               <?php } ?>
       </tbody>
<?php } ?>       