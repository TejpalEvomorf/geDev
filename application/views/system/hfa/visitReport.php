<style>
.vr_FeildComments{
	display:none;
}
</style>

<?php
if(is_numeric($visitReport['employee']))
{
	$employee=employee_details($visitReport['employee']);
	$empName=$employee['fname'].' '.$employee['lname'];
}
else
	$empName=$visitReport['employee'];

$bedSizeList=bedSizeList();
$createUpdate='Updated';
if($visitReport['exterior']=='' && $visitReport['exterior_commnets']=='' && $visitReport['interior']=='' && $visitReport['interior_comments']=='' && $visitReport['homeliness']=='' && $visitReport['homeliness_comments']=='' && $visitReport['cleanliness']=='' && $visitReport['cleanliness_comments']=='' && $visitReport['family_warmth']=='' && $visitReport['family_warmth_comments']=='' && $visitReport['floor_type']=='' && $visitReport['no_of_bedrooms']=='' && $visitReport['no_of_bedrooms_used']=='' && $visitReport['no_of_bathrooms']=='' && $visitReport['no_of_bathrooms_used']=='' && $visitReport['smoke_alarm']=='' && $visitReport['smoke_alarm_info']=='' && $visitReport['living_area']=='' && $visitReport['living_area_comments']=='' && $visitReport['dining_area']=='' && $visitReport['dining_area_comments']=='' && $visitReport['kitchen_area']=='' && $visitReport['kitchen_area_comments']=='' && $visitReport['laundry']=='' && $visitReport['laundry_location']=='' && $visitReport['laundry_comments']=='' && $visitReport['floor_type_SF']=='' && $visitReport['no_of_bedrooms_SF']=='' && $visitReport['no_of_bedrooms_used_SF']=='' && $visitReport['no_of_bathrooms_SF']=='' && $visitReport['no_of_bathrooms_used_SF']=='' && $visitReport['smoke_alarm_SF']=='' && $visitReport['smoke_alarm_info_SF']=='' && $visitReport['living_area_SF']=='' && $visitReport['living_area_comments_SF']=='' && $visitReport['dining_area_SF']=='' && $visitReport['dining_area_comments_SF']=='' && $visitReport['kitchen_area_SF']=='' && $visitReport['kitchen_area_comments_SF']=='' && $visitReport['laundry_SF']=='' && $visitReport['laundry_location_SF']=='' && $visitReport['laundry_comments_SF']==''&& $visitReport['floor_type_TF']=='' && $visitReport['no_of_bedrooms_TF']=='' && $visitReport['no_of_bedrooms_used_TF']=='' && $visitReport['no_of_bathrooms_TF']=='' && $visitReport['no_of_bathrooms_used_TF']=='' && $visitReport['smoke_alarm_TF']=='' && $visitReport['smoke_alarm_info_TF']=='' && $visitReport['living_area_TF']=='' && $visitReport['living_area_comments_TF']=='' && $visitReport['dining_area_TF']=='' && $visitReport['dining_area_comments_TF']=='' && $visitReport['kitchen_area_TF']=='' && $visitReport['kitchen_area_comments_TF']=='' && $visitReport['laundry_TF']=='' && $visitReport['laundry_location_TF']=='' && $visitReport['laundry_comments_TF']=='' &&  $visitReport['sa_backyard']=='' && $visitReport['sa_backyard_comments']=='' && $visitReport['sa_internet']=='' && $visitReport['sa_internet_comments']=='' && $visitReport['sa_key']=='' && $visitReport['sa_key_comments']=='' && $visitReport['granny_flat']=='' && $visitReport['granny_flat_comments']=='' && $visitReport['sep_entrance']=='' && $visitReport['sep_entrance_comments']=='' && $visitReport['pool']=='' && $visitReport['pool_comments']=='' && $visitReport['anything']=='' && $visitReport['anything_comments']=='' && $visitReport['camera']=='' && $visitReport['camera_comments']=='' && $visitReport['host_exp']=='' && $visitReport['multicultural']==''  && $visitReport['interest']=='' && $visitReport['religious']=='' && $visitReport['u18_compatible']=='' && $visitReport['here_referral']=='' && $visitReport['here_adv_media']==''  && $visitReport['here_fb']=='' && $visitReport['comments']=='' && empty($visitReport['bedrooms']))
$createUpdate='Created';
?>
<div class="page-heading">
      <h1>Visit Report
      <small><?='visited by: '.$empName.' on '.date('d M Y, h:i A',strtotime($visitReport['date_visited']))?></small>
      </h1>
      
      <div class="m-n DTTT btn-group pull-right">
      
              <a class="btn btn-default" href="javascript:hfaVisitReportPrintWindow(<?=$visitReport['id']?>);">
                  <i class="colorBlue fa fa-print"></i> 
                  <span class="colorBlue">Print</span>
              </a>
            <div class="btn-group dropdown">
                <button class="btn btn-inverse" data-toggle="dropdown">
                    <i class="fa fa-download colorBlue"></i>
                    <span class="colorBlue">Export</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="<?=site_url().'hfa/pdfVisitReport/'.$visitReport['id']?>" target="_blank"><i class="material-icons" style="font-size:16px;">picture_as_pdf</i> Pdf</a></li>
                    <li><a href="<?=site_url().'hfa/wordVisitReport/'.$visitReport['id']?>" target="_blank"><i class="material-icons" style="font-size:16px;">insert_drive_file</i> Word</a></li>
                </ul>
            </div>
              
       </div>
</div>

<div class="container-fluid">                                

    <div data-widget-group="group1">
        <div class="row">
        
                                <form id="vr_Form">
        <!--11111111111 #STARTS-->
            <div class="col-md-12">
                <div class="panel panel-bluegraylight">
                    <div class="panel-heading">                                
                          <h2>Facilities</h2>
                    </div>
                    <div class="panel-body">
                    
            <div class="col-md-6">
            
                    <div>  
                    <div class="form-group col-xs-12" style="padding-left:0;">
                            <label class="control-label">Homestay exterior appearance</label>
                            <select class="form-control vr_Feild" id="vr_exterior" name="vr_exterior" >
                              <option value="">None</option>
                              <option value="A" <?php if($visitReport['exterior']=='A'){echo 'selected';}?>>A</option>
                              <option value="B" <?php if($visitReport['exterior']=='B'){echo 'selected';}?>>B</option>
                              <option value="C" <?php if($visitReport['exterior']=='C'){echo 'selected';}?>>C</option>
                            </select>
                    </div>
                    
                    <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                            <label class="control-label">Comments for homestay exterior appearance</label>
                            <textarea class="form-control" name="vr_exterior_comments"><?=$visitReport['exterior_commnets']?></textarea>
                    </div>
                </div>
            
                <div>
                  <div class="form-group col-xs-12" style="padding-left:0;">
                            <label class="control-label">Homestay interior appearance</label>
                            <select class="form-control vr_Feild" id="vr_interior" name="vr_interior" >
                              <option value="">None</option>
                              <option value="A" <?php if($visitReport['interior']=='A'){echo 'selected';}?>>A</option>
                              <option value="B" <?php if($visitReport['interior']=='B'){echo 'selected';}?>>B</option>
                              <option value="C" <?php if($visitReport['interior']=='C'){echo 'selected';}?>>C</option>
                            </select>
                   </div>
                 
                 <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                            <label class="control-label">Comments for homestay interior appearance</label>
                            <textarea class="form-control" name="vr_interior_comments"><?=$visitReport['interior_comments']?></textarea>
                   </div>
                </div>
                
            
                <div>
                 <div class="form-group col-xs-12" style="padding-left:0;">
                            <label class="control-label">Home cleanliness</label>
                            <select class="form-control vr_Feild" id="vr_clean" name="vr_clean" >
                              <option value="">None</option>
                              <option value="A" <?php if($visitReport['cleanliness']=='A'){echo 'selected';}?>>A</option>
                              <option value="B" <?php if($visitReport['cleanliness']=='B'){echo 'selected';}?>>B</option>
                              <option value="C" <?php if($visitReport['cleanliness']=='C'){echo 'selected';}?>>C</option>
                            </select>
                   </div>
                 
                 <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                            <label class="control-label">Comments for home cleanliness</label>
                            <textarea class="form-control" name="vr_clean_comments"><?=$visitReport['cleanliness_comments']?></textarea>
                   </div>
                </div>
                
            </div>
            
            <div class="col-md-6">
            
            <div>
                <div class="form-group col-xs-12" style="padding-left:0;">
                        <label class="control-label">Feeling of homeliness</label>
                        <select class="form-control vr_Feild" id="vr_homeliness" name="vr_homeliness" >
                          <option value="">None</option>
                          <option value="A" <?php if($visitReport['homeliness']=='A'){echo 'selected';}?>>A</option>
                          <option value="B" <?php if($visitReport['homeliness']=='B'){echo 'selected';}?>>B</option>
                          <option value="C" <?php if($visitReport['homeliness']=='C'){echo 'selected';}?>>C</option>
                        </select>
                </div>
                
                <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                        <label class="control-label">Comments for feeling of homeliness</label>
                        <textarea class="form-control" name="vr_homeliness_comments"><?=$visitReport['homeliness_comments']?></textarea>
                </div>
            </div>
            
            <div>
                <div class="form-group col-xs-12" style="padding-left:0;">
                        <label class="control-label">Warmth of parent/family</label>
                        <select class="form-control vr_Feild" id="vr_familyWarmth" name="vr_familyWarmth" >
                          <option value="">None</option>
                          <option value="A" <?php if($visitReport['family_warmth']=='A'){echo 'selected';}?>>A</option>
                          <option value="B" <?php if($visitReport['family_warmth']=='B'){echo 'selected';}?>>B</option>
                          <option value="C" <?php if($visitReport['family_warmth']=='C'){echo 'selected';}?>>C</option>
                        </select>
                </div>
                
                <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                        <label class="control-label">Comments for warmth of parent/family</label>
                        <textarea class="form-control" name="vr_familyWarmth_comments"><?=$visitReport['family_warmth_comments']?></textarea>
                </div>
            </div> 
                       
           </div>    

       </div>
      </div>
  </div>
            <!--111111111111 #END-->
          
          <!--Interior Layout #STATRS-->
          
            <div class="col-md-12">
                <div class="panel panel-bluegraylight">
                    <div class="panel-heading">                                
                        <h2>Interior layout</h2>
                    </div>
                    <div class="panel-body">
                    
                    <div class="col-md-4">
                    <div class="panel panel-bluegraylight">
                            <div class="panel-heading">                                
                                <h2>Ground Floor/ First floor</h2>
                            </div>
                            <div class="panel-body">
                            
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                        <label class="control-label">Type of flooring (wood, carpet, tiles)</label>
                                        <textarea style="height: 120px;" class="form-control" name="vr_floor_Type"><?=$visitReport['floor_type']?></textarea>
                                    </div>
                                                                
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                        <label class="control-label">Total number of bedrooms</label>
                                        <textarea style="height: 120px;" class="form-control" name="vr_no_of_bedrooms"><?=$visitReport['no_of_bedrooms']?></textarea>
                                    </div>
                                                                
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                        <label class="control-label">Total number of bedrooms used for students</label>
                                        <textarea style="height: 120px;" class="form-control" name="vr_no_of_bedrooms_used"><?=$visitReport['no_of_bedrooms_used']?></textarea>
                                    </div>
                                                                
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                        <label class="control-label">Total number of bathrooms</label>
                                        <textarea style="height: 120px;" class="form-control" name="vr_no_of_bathrooms"><?=$visitReport['no_of_bathrooms']?></textarea>
                                    </div>
                                                                
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                        <label class="control-label">Total number of bathrooms used for students</label>
                                        <textarea style="height: 120px;" class="form-control" name="vr_no_of_bathrooms_used"><?=$visitReport['no_of_bathrooms_used']?></textarea>
                                    </div>
                                                                
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                        <label class="control-label">Smoke Alarm</label>
                                        <textarea style="height: 120px;" class="form-control" name="vr_smoke_alarm"><?=$visitReport['smoke_alarm']?></textarea>
                                    </div>
                                                                
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                        <label class="control-label">Number of alarms and location of alarms</label>
                                        <textarea style="height: 120px;" class="form-control" name="vr_smoke_alarm_info"><?=$visitReport['smoke_alarm_info']?></textarea>
                                    </div>
                                    
                                   <div>  
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                            <label class="control-label">Living Area </label>
                                            <select class="form-control vr_Feild" id="living_area" name="living_area" >
                                              <option value="">Select one</option>
                                              <option value="1" <?php if($visitReport['living_area']=='1'){echo 'selected';}?>>Yes</option>
                                              <option value="0" <?php if($visitReport['living_area']=='0'){echo 'selected';}?>>No</option>
                                            </select>
                                    </div>
                                    
                                    <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                                            <label class="control-label">Comments for living area </label>
                                            <textarea class="form-control" name="living_area_comments"><?=$visitReport['living_area_comments']?></textarea>
                                    </div>
                                </div>
                                    
                                   <div>  
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                            <label class="control-label">Dining Area</label>
                                            <select class="form-control vr_Feild" id="dining_area" name="dining_area" >
                                              <option value="">Select one</option>
                                              <option value="1" <?php if($visitReport['dining_area']=='1'){echo 'selected';}?>>Yes</option>
                                              <option value="0" <?php if($visitReport['dining_area']=='0'){echo 'selected';}?>>No</option>
                                            </select>
                                    </div>
                                    
                                    <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                                            <label class="control-label">Comments for dining area </label>
                                            <textarea class="form-control" name="dining_area_comments"><?=$visitReport['dining_area_comments']?></textarea>
                                    </div>
                                </div>
                                    
                                   <div>  
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                            <label class="control-label">Kitchen Area</label>
                                            <select class="form-control vr_Feild" id="kitchen_area" name="kitchen_area" >
                                              <option value="">Select one</option>
                                              <option value="1" <?php if($visitReport['kitchen_area']=='1'){echo 'selected';}?>>Yes</option>
                                              <option value="0" <?php if($visitReport['kitchen_area']=='0'){echo 'selected';}?>>No</option>
                                            </select>
                                    </div>
                                    
                                    <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                                            <label class="control-label">Comments for kitchen area </label>
                                            <textarea class="form-control" name="kitchen_area_comments"><?=$visitReport['kitchen_area_comments']?></textarea>
                                    </div>
                                </div>
                                    
                                   <div>  
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                            <label class="control-label">Laundry</label>
                                            <select class="form-control vr_Feild vr_FeildYesNextParent" id="laundry" name="laundry" >
                                              <option value="">Select one</option>
                                              <option value="1" <?php if($visitReport['laundry']=='1'){echo 'selected';}?>>Yes</option>
                                              <option value="0" <?php if($visitReport['laundry']=='0'){echo 'selected';}?>>No</option>
                                            </select>
                                    </div>
                                    <div class="form-group col-xs-12 vr_FeildYesNextChild" style="display:none;padding-left:0;">
                                            <label class="control-label">Laundry location</label>
                                            <select class="form-control" id="laundry_location" name="laundry_location" >
                                              <option value="">Select one</option>
                                              <option value="1" <?php if($visitReport['laundry_location']=='1'){echo 'selected';}?>>Indoor</option>
                                              <option value="2" <?php if($visitReport['laundry_location']=='2'){echo 'selected';}?>>Outdoor</option>
                                            </select>
                                    </div>
                                    <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                                            <label class="control-label">Comments for laundry</label>
                                            <textarea class="form-control" name="vr_laundry_comments"><?=$visitReport['laundry_comments']?></textarea>
                                    </div>
                                </div>

                            </div>
                    </div>
                    </div>
                    
                    <div class="col-md-4">
                    <div class="panel panel-bluegraylight">
                            <div class="panel-heading">                                
                                <h2>Second floor</h2>
                            </div>
                            <div class="panel-body">
                            
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                        <label class="control-label">Type of flooring (wood, carpet, tiles)</label>
                                        <textarea style="height: 120px;" class="form-control" name="vr_floor_TypeSF"><?=$visitReport['floor_type_SF']?></textarea>
                                    </div>
                                                                
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                        <label class="control-label">Total number of bedrooms</label>
                                        <textarea style="height: 120px;" class="form-control" name="vr_no_of_bedroomsSF"><?=$visitReport['no_of_bedrooms_SF']?></textarea>
                                    </div>
                                                                
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                        <label class="control-label">Total number of bedrooms used for students</label>
                                        <textarea style="height: 120px;" class="form-control" name="vr_no_of_bedrooms_usedSF"><?=$visitReport['no_of_bedrooms_used_SF']?></textarea>
                                    </div>
                                                                
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                        <label class="control-label">Total number of bathrooms</label>
                                        <textarea style="height: 120px;" class="form-control" name="vr_no_of_bathroomsSF"><?=$visitReport['no_of_bathrooms_SF']?></textarea>
                                    </div>
                                                                
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                        <label class="control-label">Total number of bathrooms used for students</label>
                                        <textarea style="height: 120px;" class="form-control" name="vr_no_of_bathrooms_usedSF"><?=$visitReport['no_of_bathrooms_used_SF']?></textarea>
                                    </div>
                                                                
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                        <label class="control-label">Smoke Alarm</label>
                                        <textarea style="height: 120px;" class="form-control" name="vr_smoke_alarmSF"><?=$visitReport['smoke_alarm_SF']?></textarea>
                                    </div>
                                                                
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                        <label class="control-label">Number of alarms and location of alarms</label>
                                        <textarea style="height: 120px;" class="form-control" name="vr_smoke_alarm_infoSF"><?=$visitReport['smoke_alarm_info_SF']?></textarea>
                                    </div>
                                    
                                   <div>  
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                            <label class="control-label">Living Area </label>
                                            <select class="form-control vr_Feild" id="living_areaSF" name="living_areaSF" >
                                              <option value="">Select one</option>
                                              <option value="1" <?php if($visitReport['living_area_SF']=='1'){echo 'selected';}?>>Yes</option>
                                              <option value="0" <?php if($visitReport['living_area_SF']=='0'){echo 'selected';}?>>No</option>
                                            </select>
                                    </div>
                                    
                                    <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                                            <label class="control-label">Comments for living area </label>
                                            <textarea class="form-control" name="living_area_commentsSF"><?=$visitReport['living_area_comments_SF']?></textarea>
                                    </div>
                                </div>
                                    
                                   <div>  
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                            <label class="control-label">Dining Area</label>
                                            <select class="form-control vr_Feild" id="dining_areaSF" name="dining_areaSF" >
                                              <option value="">Select one</option>
                                              <option value="1" <?php if($visitReport['dining_area_SF']=='1'){echo 'selected';}?>>Yes</option>
                                              <option value="0" <?php if($visitReport['dining_area_SF']=='0'){echo 'selected';}?>>No</option>
                                            </select>
                                    </div>
                                    
                                    <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                                            <label class="control-label">Comments for dining area </label>
                                            <textarea class="form-control" name="dining_area_commentsSF"><?=$visitReport['dining_area_comments_SF']?></textarea>
                                    </div>
                                </div>
                                    
                                   <div>  
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                            <label class="control-label">Kitchen Area</label>
                                            <select class="form-control vr_Feild" id="kitchen_areaSF" name="kitchen_areaSF" >
                                              <option value="">Select one</option>
                                              <option value="1" <?php if($visitReport['kitchen_area_SF']=='1'){echo 'selected';}?>>Yes</option>
                                              <option value="0" <?php if($visitReport['kitchen_area_SF']=='0'){echo 'selected';}?>>No</option>
                                            </select>
                                    </div>
                                    
                                    <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                                            <label class="control-label">Comments for kitchen area </label>
                                            <textarea class="form-control" name="kitchen_area_commentsSF"><?=$visitReport['kitchen_area_comments_SF']?></textarea>
                                    </div>
                                </div>
                                    
                                   <div>  
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                            <label class="control-label">Laundry</label>
                                            <select class="form-control vr_Feild vr_FeildYesNextParent" id="laundrySF" name="laundrySF" >
                                              <option value="">Select one</option>
                                              <option value="1" <?php if($visitReport['laundry_SF']=='1'){echo 'selected';}?>>Yes</option>
                                              <option value="0" <?php if($visitReport['laundry_SF']=='0'){echo 'selected';}?>>No</option>
                                            </select>
                                    </div>
                                    <div class="form-group col-xs-12 vr_FeildYesNextChild" style="display:none;padding-left:0;">
                                            <label class="control-label">Laundry location</label>
                                            <select class="form-control" id="laundry_locationSF" name="laundry_locationSF" >
                                              <option value="">Select one</option>
                                              <option value="1" <?php if($visitReport['laundry_location_SF']=='1'){echo 'selected';}?>>Indoor</option>
                                              <option value="2" <?php if($visitReport['laundry_location_SF']=='2'){echo 'selected';}?>>Outdoor</option>
                                            </select>
                                    </div>
                                    <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                                            <label class="control-label">Comments for laundry</label>
                                            <textarea class="form-control" name="vr_laundry_commentsSF"><?=$visitReport['laundry_comments_SF']?></textarea>
                                    </div>
                                </div>
                            
                            </div>
                    </div>
                    </div>
                    
                    <div class="col-md-4">
                    <div class="panel panel-bluegraylight">
                            <div class="panel-heading">                                
                                <h2>Third floor</h2>
                            </div>
                            <div class="panel-body">
                            
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                        <label class="control-label">Type of flooring (wood, carpet, tiles)</label>
                                        <textarea style="height: 120px;" class="form-control" name="vr_floor_TypeTF"><?=$visitReport['floor_type_TF']?></textarea>
                                    </div>
                                                                
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                        <label class="control-label">Total number of bedrooms</label>
                                        <textarea style="height: 120px;" class="form-control" name="vr_no_of_bedroomsTF"><?=$visitReport['no_of_bedrooms_TF']?></textarea>
                                    </div>
                                                                
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                        <label class="control-label">Total number of bedrooms used for students</label>
                                        <textarea style="height: 120px;" class="form-control" name="vr_no_of_bedrooms_usedTF"><?=$visitReport['no_of_bedrooms_used_TF']?></textarea>
                                    </div>
                                                                
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                        <label class="control-label">Total number of bathrooms</label>
                                        <textarea style="height: 120px;" class="form-control" name="vr_no_of_bathroomsTF"><?=$visitReport['no_of_bathrooms_TF']?></textarea>
                                    </div>
                                                                
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                        <label class="control-label">Total number of bathrooms used for students</label>
                                        <textarea style="height: 120px;" class="form-control" name="vr_no_of_bathrooms_usedTF"><?=$visitReport['no_of_bathrooms_used_TF']?></textarea>
                                    </div>
                                                                
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                        <label class="control-label">Smoke Alarm</label>
                                        <textarea style="height: 120px;" class="form-control" name="vr_smoke_alarmTF"><?=$visitReport['smoke_alarm_TF']?></textarea>
                                    </div>
                                                                
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                        <label class="control-label">Number of alarms and location of alarms</label>
                                        <textarea style="height: 120px;" class="form-control" name="vr_smoke_alarm_infoTF"><?=$visitReport['smoke_alarm_info_TF']?></textarea>
                                    </div>
                                    
                                   <div>  
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                            <label class="control-label">Living Area </label>
                                            <select class="form-control vr_Feild" id="living_areaTF" name="living_areaTF" >
                                              <option value="">Select one</option>
                                              <option value="1" <?php if($visitReport['living_area_TF']=='1'){echo 'selected';}?>>Yes</option>
                                              <option value="0" <?php if($visitReport['living_area_TF']=='0'){echo 'selected';}?>>No</option>
                                            </select>
                                    </div>
                                    
                                    <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                                            <label class="control-label">Comments for living area </label>
                                            <textarea class="form-control" name="living_area_commentsTF"><?=$visitReport['living_area_comments_TF']?></textarea>
                                    </div>
                                </div>
                                    
                                   <div>  
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                            <label class="control-label">Dining Area</label>
                                            <select class="form-control vr_Feild" id="dining_areaTF" name="dining_areaTF" >
                                              <option value="">Select one</option>
                                              <option value="1" <?php if($visitReport['dining_area_TF']=='1'){echo 'selected';}?>>Yes</option>
                                              <option value="0" <?php if($visitReport['dining_area_TF']=='0'){echo 'selected';}?>>No</option>
                                            </select>
                                    </div>
                                    
                                    <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                                            <label class="control-label">Comments for dining area </label>
                                            <textarea class="form-control" name="dining_area_commentsTF"><?=$visitReport['dining_area_comments_TF']?></textarea>
                                    </div>
                                </div>
                                    
                                   <div>  
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                            <label class="control-label">Kitchen Area</label>
                                            <select class="form-control vr_Feild" id="kitchen_areaTF" name="kitchen_areaTF" >
                                              <option value="">Select one</option>
                                              <option value="1" <?php if($visitReport['kitchen_area_TF']=='1'){echo 'selected';}?>>Yes</option>
                                              <option value="0" <?php if($visitReport['kitchen_area_TF']=='0'){echo 'selected';}?>>No</option>
                                            </select>
                                    </div>
                                    
                                    <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                                            <label class="control-label">Comments for kitchen area </label>
                                            <textarea class="form-control" name="kitchen_area_commentsTF"><?=$visitReport['kitchen_area_comments_TF']?></textarea>
                                    </div>
                                </div>
                                    
                                   <div>  
                                    <div class="form-group col-xs-12" style="padding-left:0;">
                                            <label class="control-label">Laundry</label>
                                            <select class="form-control vr_Feild vr_FeildYesNextParent" id="laundryTF" name="laundryTF" >
                                              <option value="">Select one</option>
                                              <option value="1" <?php if($visitReport['laundry_TF']=='1'){echo 'selected';}?>>Yes</option>
                                              <option value="0" <?php if($visitReport['laundry_TF']=='0'){echo 'selected';}?>>No</option>
                                            </select>
                                    </div>
                                    <div class="form-group col-xs-12 vr_FeildYesNextChild" style="display:none;padding-left:0;">
                                            <label class="control-label">Laundry location</label>
                                            <select class="form-control" id="laundry_locationTF" name="laundry_locationTF" >
                                              <option value="">Select one</option>
                                              <option value="1" <?php if($visitReport['laundry_location_TF']=='1'){echo 'selected';}?>>Indoor</option>
                                              <option value="2" <?php if($visitReport['laundry_location_TF']=='2'){echo 'selected';}?>>Outdoor</option>
                                            </select>
                                    </div>
                                    <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                                            <label class="control-label">Comments for laundry</label>
                                            <textarea class="form-control" name="vr_laundry_commentsTF"><?=$visitReport['laundry_comments_TF']?></textarea>
                                    </div>
                                </div>
                            
                            </div>
                    </div>
                    </div>
                    
                    </div>
                </div>
            </div>
          
          <!--Interior Layout #ENDS-->

        <!--Student bedrooms #STARTS-->
<div class="col-md-12">
    <div class="panel panel-bluegraylight">
        <div class="panel-heading">                                
        	<h2>Student bedrooms</h2>
        </div>
        <div class="panel-body">
        
              <?php 
			  $bedCounts=count($hfaTwo['bedroomDetails']);
			  if($bedCounts==1)
			  	$bedClass='12';
			  elseif($bedCounts==2)
			  	$bedClass='6';
			  else
			  	$bedClass='4';	
			  foreach($hfaTwo['bedroomDetails'] as $bedK => $bed)
			  {
				  ?>
              <input type="hidden" name="vr_bed[<?=$bedK?>][id]" value="<?=$bed['id']?>" />
              <div class="col-md-<?=$bedClass?>">
              <div class="panel panel-bluegraylight">
                      <div class="panel-heading">                                
                          <h2>Bedroom <?=$bedK+1?></h2>
                      </div>
                      <div class="panel-body">
                      
                          <div>  
                              <div class="form-group col-xs-12" style="padding-left:0;">
                                      <label class="control-label">Bed</label>
                                      <select class="form-control vr_Feild" name="vr_bed[<?=$bedK?>][bed]">
                                        <option value="">Select one</option>
                                        <option value="1" <?php if(isset($visitReport['bedrooms'][$bedK]) && $visitReport['bedrooms'][$bedK]['bed']=='1'){echo 'selected';}?>>Yes</option>
                                        <option value="0" <?php if(isset($visitReport['bedrooms'][$bedK]) && $visitReport['bedrooms'][$bedK]['bed']=='0'){echo 'selected';}?>>No</option>
                                     </select>
                              </div>
                              
                              <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                                      <label class="control-label">Comments for bed</label>
                                      <textarea class="form-control" name="vr_bed[<?=$bedK?>][bed_comments]"><?php if(isset($visitReport['bedrooms'][$bedK])){echo $visitReport['bedrooms'][$bedK]['bed_comments'];}?></textarea>
                              </div>
                          </div>                
                          <div>  
                              <div class="form-group col-xs-12" style="padding-left:0;">
                                      <label class="control-label">Wardrobe</label>
                                      <select class="form-control vr_Feild" name="vr_bed[<?=$bedK?>][wardrobe]">
                                        <option value="">Select one</option>
                                        <option value="1" <?php if(isset($visitReport['bedrooms'][$bedK]) && $visitReport['bedrooms'][$bedK]['wardrobe']=='1'){echo 'selected';}?>>Yes</option>
                                        <option value="0" <?php if(isset($visitReport['bedrooms'][$bedK]) && $visitReport['bedrooms'][$bedK]['wardrobe']=='0'){echo 'selected';}?>>No</option>
                                     </select>
                              </div>
                              
                              <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                                      <label class="control-label">Comments for wardrobe</label>
                                      <textarea class="form-control" name="vr_bed[<?=$bedK?>][wardrobe_comments]"><?php if(isset($visitReport['bedrooms'][$bedK])){echo $visitReport['bedrooms'][$bedK]['wardrobe_comments'];}?></textarea>
                              </div>
                          </div>                
                          <div>  
                              <div class="form-group col-xs-12" style="padding-left:0;">
                                      <label class="control-label">Window</label>
                                      <select class="form-control vr_Feild" name="vr_bed[<?=$bedK?>][window]">
                                        <option value="">Select one</option>
                                        <option value="1" <?php if(isset($visitReport['bedrooms'][$bedK]) && $visitReport['bedrooms'][$bedK]['window']=='1'){echo 'selected';}?>>Yes</option>
                                        <option value="0" <?php if(isset($visitReport['bedrooms'][$bedK]) && $visitReport['bedrooms'][$bedK]['window']=='0'){echo 'selected';}?>>No</option>
                                     </select>
                              </div>
                              
                              <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                                      <label class="control-label">Comments for window</label>
                                      <textarea class="form-control" name="vr_bed[<?=$bedK?>][window_comments]"><?php if(isset($visitReport['bedrooms'][$bedK])){echo $visitReport['bedrooms'][$bedK]['window_comments'];}?></textarea>
                              </div>
                          </div>                
                          <div>  
                              <div class="form-group col-xs-12" style="padding-left:0;">
                                      <label class="control-label">Desk and chair + desk lamp</label>
                                      <select class="form-control vr_Feild" name="vr_bed[<?=$bedK?>][desk_chair]">
                                        <option value="">Select one</option>
                                        <option value="1" <?php if(isset($visitReport['bedrooms'][$bedK]) && $visitReport['bedrooms'][$bedK]['desk_chair']=='1'){echo 'selected';}?>>Yes</option>
                                        <option value="0" <?php if(isset($visitReport['bedrooms'][$bedK]) && $visitReport['bedrooms'][$bedK]['desk_chair']=='0'){echo 'selected';}?>>No</option>
                                     </select>
                              </div>
                              
                              <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                                      <label class="control-label">Comments for desk and chair + desk lamp</label>
                                      <textarea class="form-control" name="vr_bed[<?=$bedK?>][desk_chair_comments]"><?php if(isset($visitReport['bedrooms'][$bedK])){echo $visitReport['bedrooms'][$bedK]['desk_chair_comments'];}?></textarea>
                              </div>
                          </div>                
                          <div>  
                              <div class="form-group col-xs-12" style="padding-left:0;">
                                      <label class="control-label">Size of the bedroom</label>
                                      <select class="form-control vr_Feild" name="vr_bed[<?=$bedK?>][bedroom_size]">
                                        <option value="">Select one</option>
                                        <?php foreach($bedSizeList as $bedSizeK=>$bedSize){?>
                                        <option value="<?=$bedSizeK?>" <?php if(isset($visitReport['bedrooms'][$bedK]) && $visitReport['bedrooms'][$bedK]['bedroom_size']==$bedSizeK){echo 'selected';}?>><?=$bedSize?></option>
                                        <?php } ?>
                                     </select>
                              </div>
                              
                              <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                                      <label class="control-label">Comments for size of the bedroom</label>
                                      <textarea class="form-control" name="vr_bed[<?=$bedK?>][bedroom_size_comments]"><?php if(isset($visitReport['bedrooms'][$bedK])){echo $visitReport['bedrooms'][$bedK]['bedroom_size_comments'];}?></textarea>
                              </div>
                          </div>                
                          <div>  
                              <div class="form-group col-xs-12" style="padding-left:0;">
                                      <label class="control-label">Door lock</label>
                                      <select class="form-control vr_Feild" name="vr_bed[<?=$bedK?>][door_lock]">
                                        <option value="">Select one</option>
                                        <option value="1" <?php if(isset($visitReport['bedrooms'][$bedK]) && $visitReport['bedrooms'][$bedK]['door_lock']=='1'){echo 'selected';}?>>Yes</option>
                                        <option value="0" <?php if(isset($visitReport['bedrooms'][$bedK]) && $visitReport['bedrooms'][$bedK]['door_lock']=='0'){echo 'selected';}?>>No</option>
                                     </select>
                              </div>
                              
                              <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                                      <label class="control-label">Comments for door lock</label>
                                      <textarea class="form-control" name="vr_bed[<?=$bedK?>][door_lock_comments]"><?php if(isset($visitReport['bedrooms'][$bedK])){echo $visitReport['bedrooms'][$bedK]['door_lock_comments'];}?></textarea>
                              </div>
                          </div>                
                          <div>  
                              <div class="form-group col-xs-12" style="padding-left:0;">
                                      <label class="control-label">Private bathroom</label>
                                      <select class="form-control vr_Feild" name="vr_bed[<?=$bedK?>][private_bathroom]">
                                        <option value="">Select one</option>
                                        <option value="1" <?php if(isset($visitReport['bedrooms'][$bedK]) && $visitReport['bedrooms'][$bedK]['private_bathroom']=='1'){echo 'selected';}?>>Yes</option>
                                        <option value="0" <?php if(isset($visitReport['bedrooms'][$bedK]) && $visitReport['bedrooms'][$bedK]['private_bathroom']=='0'){echo 'selected';}?>>No</option>
                                     </select>
                              </div>
                              
                              <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                                      <label class="control-label">Comments for private bathroom</label>
                                      <textarea class="form-control" name="vr_bed[<?=$bedK?>][private_bathroom_comments]"><?php if(isset($visitReport['bedrooms'][$bedK])){echo $visitReport['bedrooms'][$bedK]['private_bathroom_comments'];}?></textarea>
                              </div>
                          </div>                
                      
                      </div>
              </div>
              </div>
        <?php } ?>
        
        </div>
    </div>
</div>        
        <!--Student bedrooms #ENDS-->
 
 
 <!--Student access and extras #STARS-->
<div class="col-md-12" style="padding:0;">
        <div class="col-md-6">
            <div class="panel panel-bluegraylight">
                <div class="panel-heading">                                
                    <h2>Student’s Access</h2>
                </div>
                <div class="panel-body">
                                 
                    <div>  
                        <div class="form-group col-xs-12" style="padding-left:0;">
                                <label class="control-label">Backyard</label>
                                <select class="form-control vr_Feild" name="vr_sa_backyard" >
                                  <option value="">Select one</option>
                                  <option value="1" <?php if($visitReport['sa_backyard']=='1'){echo 'selected';}?>>Yes</option>
                                  <option value="0" <?php if($visitReport['sa_backyard']=='0'){echo 'selected';}?>>No</option>
                               </select>
                        </div>
                        
                        <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                                <label class="control-label">Comments for backyard</label>
                                <textarea class="form-control" name="vr_sa_backyard_comments"><?=$visitReport['sa_backyard_comments']?></textarea>
                        </div>
                    </div>                
                                    
                    <div>  
                        <div class="form-group col-xs-12" style="padding-left:0;">
                                <label class="control-label">Internet Access</label>
                                <select class="form-control vr_Feild" name="vr_sa_internet" >
                                  <option value="">Select one</option>
                                  <option value="1" <?php if($visitReport['sa_internet']=='1'){echo 'selected';}?>>Yes</option>
                                  <option value="0" <?php if($visitReport['sa_internet']=='0'){echo 'selected';}?>>No</option>
                               </select>
                        </div>
                        
                        <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                                <label class="control-label">Comments for internet Access</label>
                                <textarea class="form-control" name="vr_sa_internet_comments"><?=$visitReport['sa_internet_comments']?></textarea>
                        </div>
                    </div>                
                                    
                    <div>  
                        <div class="form-group col-xs-12" style="padding-left:0;">
                                <label class="control-label">A set of house keys</label>
                                <select class="form-control vr_Feild" name="vr_sa_key" >
                                  <option value="">Select one</option>
                                  <option value="1" <?php if($visitReport['sa_key']=='1'){echo 'selected';}?>>Yes</option>
                                  <option value="0" <?php if($visitReport['sa_key']=='0'){echo 'selected';}?>>No</option>
                               </select>
                        </div>
                        
                        <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                                <label class="control-label">Comments for a set of house keys</label>
                                <textarea class="form-control" name="vr_sa_key_comments"><?=$visitReport['sa_key_comments']?></textarea>
                        </div>
                    </div>                
                
                </div>
            </div>
        </div>	
        <div class="col-md-6">
            <div class="panel panel-bluegraylight">
                <div class="panel-heading">                                
                    <h2>Extras</h2>
                </div>
                <div class="panel-body">
                
                    <div>  
                        <div class="form-group col-xs-12" style="padding-left:0;">
                                <label class="control-label">Do they have a granny flat? Does anyone live there? Please specify!</label>
                                <select class="form-control vr_Feild" id="" name="vr_granny_flat" >
                                  <option value="">Select one</option>
                                  <option value="1" <?php if($visitReport['granny_flat']=='1'){echo 'selected';}?>>Yes</option>
                                  <option value="0" <?php if($visitReport['granny_flat']=='0'){echo 'selected';}?>>No</option>
                               </select>
                        </div>
                        
                        <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                                <label class="control-label">Comments</label>
                                <textarea class="form-control" name="vr_granny_flat_comments"><?=$visitReport['granny_flat_comments']?></textarea>
                        </div>
                    </div>                
                                    
                    <div>  
                        <div class="form-group col-xs-12" style="padding-left:0;">
                                <label class="control-label">Does it have a separate entrance?</label>
                                <select class="form-control vr_Feild" id="" name="vr_sep_entrance" >
                                  <option value="">Select one</option>
                                  <option value="1" <?php if($visitReport['sep_entrance']=='1'){echo 'selected';}?>>Yes</option>
                                  <option value="0" <?php if($visitReport['sep_entrance']=='0'){echo 'selected';}?>>No</option>
                               </select>
                        </div>
                        
                        <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                                <label class="control-label">Comments</label>
                                <textarea class="form-control" name="vr_sep_entrance_comments"><?=$visitReport['sep_entrance_comments']?></textarea>
                        </div>
                    </div>                
                                    
                    <div>  
                        <div class="form-group col-xs-12" style="padding-left:0;">
                                <label class="control-label">Does it have a swimming pool?</label>
                                <select class="form-control vr_Feild" id="" name="vr_pool" >
                                  <option value="">Select one</option>
                                  <option value="1" <?php if($visitReport['pool']=='1'){echo 'selected';}?>>Yes</option>
                                  <option value="0" <?php if($visitReport['pool']=='0'){echo 'selected';}?>>No</option>
                               </select>
                        </div>
                        
                        <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                                <label class="control-label">Comments</label>
                                <textarea class="form-control" name="vr_pool_comments"><?=$visitReport['pool_comments']?></textarea>
                        </div>
                    </div>                
                                    
                    <div>  
                        <div class="form-group col-xs-12" style="padding-left:0;">
                                <label class="control-label">Anything else?</label>
                                <select class="form-control vr_Feild" id="" name="vr_anything" >
                                  <option value="">Select one</option>
                                  <option value="1" <?php if($visitReport['anything']=='1'){echo 'selected';}?>>Yes</option>
                                  <option value="0" <?php if($visitReport['anything']=='0'){echo 'selected';}?>>No</option>
                               </select>
                        </div>
                        
                        <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                                <label class="control-label">Comments</label>
                                <textarea class="form-control" name="vr_anything_comments"><?=$visitReport['anything_comments']?></textarea>
                        </div>
                    </div>                
                                    
                    <div>  
                        <div class="form-group col-xs-12" style="padding-left:0;">
                                <label class="control-label">Security cameras?</label>
                                <select class="form-control vr_Feild" id="" name="vr_camera" >
                                  <option value="">Select one</option>
                                  <option value="1" <?php if($visitReport['camera']=='1'){echo 'selected';}?>>Yes</option>
                                  <option value="0" <?php if($visitReport['camera']=='0'){echo 'selected';}?>>No</option>
                               </select>
                        </div>
                        
                        <div class="form-group col-xs-12 vr_FeildComments" style="padding-left:0;">
                                <label class="control-label">Comments</label>
                                <textarea class="form-control" name="vr_camera_comments"><?=$visitReport['camera_comments']?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>	
</div>
<!--Student access and extras #ENDS-->


<!--Host attributes #STARTS-->
<div class="col-md-12">
    <div class="panel panel-bluegraylight">
        <div class="panel-heading">                                
        	<h2>Host's attributes</h2>
        </div>
        <div class="panel-body">
        
            <div class="col-md-6">
            		<div class="form-group col-xs-12" style="padding-left:0;">
                        <label class="control-label">Experienced host? How many years of experience do you have?</label>
                        <textarea style="height: 120px;" class="form-control" name="vr_host_exp"><?=$visitReport['host_exp']?></textarea>
                    </div>
            		<div class="form-group col-xs-12" style="padding-left:0;">
                        <label class="control-label">Multicultural family? How long have you been staying in Australia for? What language do you speak? Please specify who speak what!</label>
                        <textarea style="height: 120px;" class="form-control" name="vr_multicultural"><?=$visitReport['multicultural']?></textarea>
                    </div>
            </div>
            <div class="col-md-6">
            		<div class="form-group col-xs-12" style="padding-left:0;">
                        <label class="control-label">Interest/hobbies</label>
                        <textarea style="height: 120px;" class="form-control" name="vr_interest"><?=$visitReport['interest']?></textarea>
                    </div>
            		<div class="form-group col-xs-12" style="padding-left:0;">
                        <label class="control-label">Overtly religious household?</label>
                        <textarea style="height: 120px;" class="form-control" name="vr_religious"><?=$visitReport['religious']?></textarea>
                    </div>
            </div>
            
            <div class="col-md-12">
            		<div class="form-group col-xs-12" style="padding-left:0;">
                        <label class="control-label">Does host have the capability to look after U18 students? Is there anything that Ge needs to be aware of regarding the host current situation i.e. host mother works night shift, host mother travels on business trips frequently etc.)?</label>
                        <textarea style="height: 120px;" class="form-control" name="vr_u18_compatible"><?=$visitReport['u18_compatible']?></textarea>
                    </div>
            </div>
        
        </div>
    </div>
</div>
<!--Host attributes #ENDS-->

<!--Hear about us #STARTS-->
    <div class="col-md-12">
        <div class="panel panel-bluegraylight">
            <div class="panel-heading">                                
                <h2>How did you hear about us</h2>
            </div>
            <div class="panel-body">
	            <div class="col-md-4">
            		<div class="form-group col-xs-12" style="padding-left:0;">
                        <label class="control-label">Referral</label>
                        <textarea style="height: 120px;" class="form-control" name="vr_referral"><?=$visitReport['here_referral']?></textarea>
                    </div>
    			</div> 
	            <div class="col-md-4">
            		<div class="form-group col-xs-12" style="padding-left:0;">
                        <label class="control-label">Advertising media (flyer distribution, cinema advertising, newspaper) - please specify!</label>
                        <textarea style="height: 120px;" class="form-control" name="vr_adv_media"><?=$visitReport['here_adv_media']?></textarea>
                    </div>
    			</div> 
	            <div class="col-md-4">
            		<div class="form-group col-xs-12" style="padding-left:0;">
                        <label class="control-label">Other (Facebook, google, website, etc.) - please specify!</label>
                        <textarea style="height: 120px;" class="form-control" name="vr_fb"><?=$visitReport['here_fb']?></textarea>
                    </div>
    			</div>        
            </div>
        </div>
    </div>
<!--Heat about us #ENDS-->

<!--Additional comments #STARTS-->
    <div class="col-md-12">
        <div class="panel panel-bluegraylight">
        <div class="panel-heading">                                
        	<h2>Additional comments</h2>
        </div>
            <div class="panel-body">
            		<div class="form-group col-xs-12" style="padding-left:0;">
                        <!--<label class="control-label">Additional comments (check any changes in the family circumstances i.e. pets, family member(s) details, occupancy, WWCC, public liability insurance):</label>-->
                        <label class="control-label">Do you work with another homestay provider? Any additional comments?</label>
                        <textarea style="height: 120px;" class="form-control" name="vr_comments"><?=$visitReport['comments']?></textarea>
                    </div>
            </div>
        </div>
    </div>
<!--Additional comments #ENDS-->

            <input type="hidden" name="visit_id" value="<?=$visitReport['id']?>">
            <input type="hidden" id="vr_hfa_id" value="<?=$visitReport['hfa_id']?>">
            <input type="hidden" id="vr_createUpdate" value="<?=$createUpdate?>">
       			<div class="col-md-12">     
                    <img src="<?=loadingImagePath()?>" id="vr_SubmitProcess" style="margin:10px 1px 7px 0px;display:none;">
                    <button type="button" class="btn btn-success btn-raised m-n btn-info" id="vr_Submit">Submit</button>
                </div>
            </form>
           
            
        </div>
    </div>

</div>


<script type="text/javascript">
$(document).ready(function(){
	
	$('.vr_Feild').each(function(){
		
		var commentsDiv=$(this).parent('div').parent('div').find('.vr_FeildComments')
		if($(this).val()!='')
			commentsDiv.show();
			
		
		if($(this).hasClass('vr_FeildYesNextParent'))
		{
			var yesNextChildDiv=$(this).parent('div').parent('div').find('.vr_FeildYesNextChild')
			if($(this).val()=='1')
				yesNextChildDiv.show();
		}
			
	});
	
	$('.vr_Feild').change(function(){
		
		var commentsDiv=$(this).parent('div').parent('div').find('.vr_FeildComments')
		if($(this).val()!='')
			commentsDiv.slideDown();
		else	
			commentsDiv.slideUp();
		
		if($(this).hasClass('vr_FeildYesNextParent'))
		{
			var yesNextChildDiv=$(this).parent('div').parent('div').find('.vr_FeildYesNextChild')
			if($(this).val()=='1')
				yesNextChildDiv.slideDown();
			else	
				yesNextChildDiv.slideUp();
		}
		
	});
	
	
});
</script>