 <?php
 /*
$stateList=stateList();
$nationList=nationList();
$nameTitleList=nameTitleList();
$genderList=genderList();
$smokingHabbits=smokingHabbits();

$religionList=religionList();
$languageList=languageList();
$languagePrificiencyList=languagePrificiencyList();
$geRefList=geRefList();
$accomodationTypeList=accomodationTypeList();
$guardianshipTypeList=guardianshipTypeList();
$age=age_from_dob($formOne['dob']) ;

$homestayChooseReasonList=homestayChooseReasonList();

$officeList=officeList();
$employeeList=employeeList();
$clientsList=clientsList();
?>

<div class="col-md-3">
	<div class="panel panel-profile panel-bluegraylight">
		<div class="panel-heading">
			<h2>Booking Details</h2>
		</div>
		<div class="panel-body">
			<div>
				<form id="updateShaBookingDatesForm">
					<input type="hidden" name="id" value="<?=$formOne['id']?>" />
					  <div class="m-n form-group">
						  <label class="control-label">From date</label>
							  <input type="text" class="form-control" id="shaBooking_startDate" name="shaBooking_startDate" value="" required>
					  </div>
					  <div class="form-group">
						  <label for="officeUse-changeEmployee" class="control-label">To date</label>
						 <input type="text" class="form-control" id="shaBooking_endDate" name="shaBooking_endDate"  value="" required>
					  </div>
					  <div class="row">
						  <div class="col-sm-8">
							  <input type="button" class="btn-raised btn-primary btn" id="updateShaBookingDatesSubmit" value="Submit" onclick="updateShaBookingDates();">
							  <img src="<?=loadingImagePath()?>" id="updateShaBookingDatesProcess" style="display:none;">
						  </div>
					  </div>
				</form>
			</div>
		</div>
	</div>
</div>


<div class="col-md-3">
	<div class="panel panel-profile panel-bluegraylight">
		<div class="panel-heading">
			<h2>Ownership Details</h2>
		</div>
		<div class="panel-body">
			<div>
			<form id="officeUseChangeAttrForm">
			<input type="hidden" name="id" value="<?=$formOne['id']?>" />
				  
				  <div class="m-n form-group">
					  <label class="control-label">Assign client</label>
						  <select class="form-control" id="officeUse-changeClient" name="client" onchange="officeUseChangeAttrFormSubmit_changeClient();">
							  <option value="">Select client</option>
							  <?php foreach($clientsList as $cLK=>$cLV){?>
										  <option value="<?=$cLV['id']?>"><?php echo $cLV['bname'];?></option>
									  <?php } ?>
						  </select>
				  </div>
				  
				  <div class="form-group">
					  <label for="officeUse-changeEmployee" class="control-label">Employee</label>
					  <select name="employee" id="officeUse-changeEmployee" class="form-control" onchange="officeUseChangeAttrFormSubmit();" required>
						  <option value="">Select employee</option>
						  <?php foreach($employeeList as $eLK=>$eLV){?>
						  <option value="<?=$eLV['id']?>"><?=ucwords($eLV['fname'].' '.$eLV['lname'])?></option>
					  <?php } ?>
					  </select>
				  </div>
			</form>
			</div>
		</div>
	</div>
	  <div class="panel panel-profile panel-bluegraylight">
		<div class="panel-heading">
		  <h2>Files</h2>
		</div>
		<div class="panel-body">
		  anchor
		</div>
	  </div>
</div>


<div class="col-md-3">
    <div class="panel panel-profile panel-bluegraylight">
        <div class="panel-heading">
            <h2>Homestay nomination</h2>
        </div>
        <div class="panel-body">
           <form id="updateShaHNForm">
                <input type="hidden" name="id" value="<?=$formOne['id']?>" />
				<div class="m-n form-group">
					<label class="control-label">Has student nominated a host family?</label>
					<div class="col-sm-8">
						<div class="radio block"><label><input type="radio" name="homestayNomination" value="1" checked> Yes</label></div>
						<div class="radio block"><label><input type="radio" name="homestayNomination" value="0" checked> No</label></div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-8">
						<input type="button" class="btn-raised btn-primary btn" id="updateShaHNSubmit" value="Submit" onclick="updateShaHomestayNomination();">
						<img src="<?=loadingImagePath()?>" id="updateShaHNProcess" style="display:none;">
					</div>
				</div>
            </form>
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="panel panel-profile panel-bluegraylight">
        <div class="panel-heading">
            <h2>Notes</h2>
        </div>
        <div class="panel-body">
           <form id="updateShaNotesForm">
                <input type="hidden" name="id" value="<?=$formOne['id']?>" />
				<div class="m-n form-group">
					<label class="control-label">Any Special Requests or Notes</label>
					<input type="text" class="form-control" id="special_request_notes" name="special_request_notes" value="special notes" required />
				</div>
				<div class="row">
					<div class="col-sm-8">
						<input type="button" class="btn-raised btn-primary btn" id="updateShaNotesSubmit" value="Submit" onclick="updateShaNotes();">
						<img src="<?php echo loadingImagePath();?>" id="updateShaNotesProcess" style="display:none;">
					</div>
				</div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#shaBooking_startDate, #shaBooking_endDate').datepicker({
			orientation: "top",
			todayHighlight: true,
	    	startDate: "-0d",
			format:'dd/mm/yyyy',
			autoclose:true
		});
	});
</script>

<?php */ ?>