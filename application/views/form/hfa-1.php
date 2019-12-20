<?php
$nameTitleList=nameTitleList();
$stateList=stateList();
$geRefList=geRefList();
?>

<!--Retriever application Pop Up STARTS-->
  <div class="modal fade successPop" id="retrieve_application"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h2 class="modal-title" style="text-align:center; font-size:20px;">Retrieve your saved application</h2>
							</div>
							<div class="modal-body">
								<div id="retrieve_application_form">
                                  <fieldset class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new" style="background-color:#ffffff;">
                                    <form id="ret_app_form">
                                        <span class="hfa1_app_full">
                                            <label for="hfa_number" class="full_label" style=" font-family: Lucida Grande,Lucida Sans Unicode,sans-serif;">Enter your Email <span class="reqField">*</span></label>
                                            <input type="text" id="ret_app_email" value="" name="ret_app_email" class="full_input errorOnBlur" style="width:245px; margin-bottom:20px;">
                                        </span>
                                        <input type="button" value="Search" id="ret_app_btn" class="btn-btn-medium hfa_submit">
                                        <div id="ret_app_btn_process"  class="appFormProcess" style="display:none;   margin: 0 auto;  padding: 12px 25px 12px 29px; overflow:hidden; width: 130px;">
                                          <img style="margin:0 auto;" src="<?=str_replace('http:','https:',static_url())?>img/submitload.gif"   />
                                       </div>
                                        
                                    </form>
                                 </fieldset>
                              </div>
							</div>
                            
                            <div class="modal-footer" id="ret_app_error" style="display:none; text-align:center; margin-top:0;">
                            <p style="margin-bottom:0;"><b style=" color: hsl(0, 0%, 20%); font-size: 14px;">We cannot find any application associated with this Email Id.</b></p>
                            <p style="font-size:14px; color:#666666;">For help and support, please call +61 2 9264 4022 or email us at <a style="color:#666; font-size:14px; text-decoration:underline;" href="mailto:customerservice@globalexperience.com.au">customerservice@globalexperience.com.au</a></p>
							</div>
                            
                              <div class="modal-footer" id="ret_app_link" style="margin-top:0;display:none;">
                              <p style="font-size:14px; color:#666666; margin-bottom: 8px; text-align: center;">Here is the application associated with <span id="ret_app_found_email"></span></p>
                              <a style="float: left; text-align: center; width: 100%;" href="javascript:void(0)" id="ret_app_found_continue">CONTINUE TO NEXT STEP</a>
                            <span id="step1" style="font-weight:bold; color:#1d7643; background:#eeeeee; margin-top:30px;">Step 1: Personal details (Complete) <img src="<?=str_replace('http:','https:',static_url())?>img/complete-tick.png"></span>
                            <span id="step2">Step 2: Property details</span>
                            <span id="step3">Step 3: Family details</span>
                            <span id="step4">Step 4: Student preferences</span>
							</div>
							
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div>
<!--Retriever application Pop ENDS-->

<div id="add-hostfamily-application" class="wFormContainer new_forms add-hostfamily-application">
<legend class="headingHostForm">Host Family Application Form
<span class="hand-written">All fields with red asterick<span class="reqField"> * </span>are mandatory</span></legend>
  <div style="background:none;" class="">
  <div class="wForm" id="tfa_0-WRPR" dir="ltr">
  
<form method="post"  class="hintsBelow labelsAbove" id="host_family_application_oneForm">
<fieldset id="tfa_1" class="section column">
<fieldset id="" class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new">

<h3>Personal Details</h3>

<div class="hfa1_home_left">		

<div class=" full_width_field">
				<span class="hfa1_app_onefourth">
				<label class="onefourth_label full_label" for="hfa1_per_title">Title</label>
				 <select name="hfa_name_title" class="onefourth_input" id="hfa_name_title">
                    <option value="">Select</option>
                    <?php foreach($nameTitleList as $titleK=>$titleV){?>
                    	<option value="<?=$titleK?>"><?=$titleV?></option>
                    <?php } ?>
                </select>
				</span>
              <span class="hfa1_app_onefofth" style="width:191px;">
			<label class="full_label" for="hfa_fname">Primary contact first name <span class="reqField">*</span></label>
			<input type="text" class="full_input errorOnBlur" name="hfa_fname" value="" id="hfa_fname">
			</span>
</div>
        
		<div class=" full_width_field">
			<span class="hfa1_app_full">
				<label class="full_label" for="hfa_lname">Primary contact last name <span class="reqField">*</span></label>
				<input type="text" class="full_input errorOnBlur" name="hfa_lname" value="" id="hfa_lname">
			</span>
		</div>

		<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="hfa_email">Email <span class="reqField">*</span></label>
			<input type="text" class="full_input errorOnBlur" name="hfa_email" value="" id="hfa_email">
			</span>
            <span id="hfa_email_error">Email format is wrong</span>
		</div>

		<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="hfa_number">Mobile number <span class="reqField">*</span></label>
			<input type="text" class="full_input errorOnBlur" name="hfa_number" value="" id="hfa_number">
			</span>
		</div>
		<div class="hfa1_unit_street_name full_width_field">
			<span class="hfa1_app_half margin_10">
			<label class="half_label full_label" for="hfa_home">Home phone</label>
			<input type="text" class="half_input errorOnBlur notReq" name="hfa_home_phone" value="" id="hfa_home_phone">
			</span>
			<span class="hfa1_app_half">
			<label class="half_label full_label" for="hfa_work_phone">Work phone</label>
			<input type="text" class="half_input errorOnBlur notReq" name="hfa_work_phone" value="" id="hfa_work_phone">
			</span>
		</div>
		<div style="margin-top: 12px;" class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label"  style="margin-bottom:5px;">Preferred way to contact</label>
			<input type="radio" style="float:left;width:20px !important; margin-right:5px;" name="hfa_contact_way" value="1" checked="checked">
            <label style="float:left; margin-right:34px; margin-bottom:13px; " for="" class="selt">Phone</label>
            <input type="radio" style="float:left; width:20px !important; margin-right:5px;" name="hfa_contact_way" value="2">
            <label style="float:left; margin-right:35px; margin-bottom:13px; " for="" class="selttwo">Email</label>
			</span>
		</div>
		<div class=" full_width_field toggle_time_wrapper">
			<span class="hfa1_app_full">
			<label for="hfa_contact_time" class="full_label">Best time to call</label>
			<input type="text" id="hfa_contact_time" value="" name="hfa_contact_time" class="full_input best-time">
			</span>
		</div>
        
        <div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="hfa_family_member" class="full_label">Number of members in family</label>
			<input type="text" id="hfa_family_member" value="" name="hfa_family_member" class="full_input">
			</span>
		</div>
<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="hfa1_student_global" class="full_label">How did you hear about Global Experience?</label>
				<select class="full_input" id="hfa_ref" name="hfa_ref">
                <option value="">Select one</option>
               
               <?php foreach($geRefList as $refK=>$refV){?>
               <option value="<?=$refK?>" id="" class=""><?=$refV?></option>
	              <?php } ?>
				</select>
			</span>
</div>
<div class=" full_width_field left_margin" id="hfa_ref_other_div" style="display:none;">
			<span class="hfa1_app_full">
			<label for="" class="full_label hidden_label">Other referral, please specify</label>
			<input type="text" id="hfa_refff" value="" name="hfa_ref_other" class="full_inputss">
			</span>
</div>
<div class=" full_width_field left_margin" id="hfa_ref_homestay_family_div" style="display:none;">
			<span class="hfa1_app_full">
			<label for="" class="full_label hidden_label">Primary contact name</label>
			<input type="text" id="hfa_reffff" value="" name="hfa_ref_homestay_family" class="full_inputss">
			</span>
</div>
</div>


<div class="hfa1_home_right">




<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="hfa_street_address" class="full_label">Street address</label>
			<input type="text" id="hfa_street_address" value="" name="hfa_street_address" class="full_input">
			</span>
</div>

<div class="hfa1_unit_street_name full_width_field">
			<span class="hfa1_app_half margin_10">
			<label for="hfa_suburb" class="half_label full_label">Suburb <span class="reqField">*</span></label>
			<input type="text" style="margin-bottom:5px;" id="hfa_suburb" value="" name="hfa_suburb" class="half_input errorOnBlur">
			</span>
			<span class="hfa1_app_half">
			<label for="hfa_postcode" class="half_label full_label">Postcode <span class="reqField">*</span></label>
			<input type="text" style="margin-bottom:5px;" id="hfa_postcode" value="" name="hfa_postcode" class="half_input errorOnBlur">
			</span>
</div>


<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="hfa_state" class="full_label">State <span class="reqField">*</span></label>
            <select class="full_input errorOnBlur" id="hfa_state" name="hfa_state">
				<option value="">Select one</option>
                <?php foreach($stateList as $stateK=>$stateV){?>
                	<option value="<?=$stateK?>" ><?=$stateV?></option>
                <?php } ?>
                </select>
			</span>
</div>

<div class=" full_width_field" style="margin-top: 12px;">
			<span class="hfa1_app_full">
			<label style="margin-bottom:5px;" for="" class="full_label">Postal address</label>
			<input type="radio" value="0" checked="checked" name="hfa_postal_address" id="postal_address_same" style="float:left;width:20px !important; margin-right:5px;">
            <label class="selt seltlft" for="postal_address_same" style="float:left; width:91%; margin-bottom:3px; margin-top:1px;  ">Same as home address</label><br>
            <input type="radio" value="1" name="hfa_postal_address" id="postal_address_provide" style="float:left; width:20px !important; margin-right:5px;">
            <label class="selttwo seltrt" for="postal_address_provide" style="float:left; margin-right:120px; margin-bottom:3px; margin-top:1px; ">Provide postal address</label>
			</span>
</div>

<div id="postal_address_provideDiv" style="display:none;" class="full_width_field">
                  <div class=" full_width_field">
                      <span class="hfa1_app_full">
                      <label for="hfa_street_address" class="full_label">Street address</label>
                      <input type="text" id="hfa_street_address_postal" value="" name="hfa_street_address_postal" class="full_input">
                      </span>
                  </div>
      
                  <div class="hfa1_unit_street_name full_width_field">
                              <span class="hfa1_app_half margin_10">
                              <label for="hfa_suburb" class="half_label full_label ">Suburb <span class="reqField">*</span></label>
                              <input type="text" style="margin-bottom:5px;" id="hfa_suburb_postal" value="" name="hfa_suburb_postal" class="half_input errorOnBlur">
                              </span>
                              <span class="hfa1_app_half">
                              <label for="hfa_postcode" class="half_label full_label">Postcode <span class="reqField">*</span></label>
                              <input type="text" style="margin-bottom:5px;" id="hfa_postcode_postal" value="" name="hfa_postcode_postal" class="half_input errorOnBlur">
                              </span>
                  </div>
                  
                  
                  <div class=" full_width_field">
                              <span class="hfa1_app_full">
                              <label for="hfa_state" class="full_label">State <span class="reqField">*</span></label>
                              <select class="full_input errorOnBlur" id="hfa_state_postal" name="hfa_state_postal">
                                  <option value="">Select one</option>
                                  <?php foreach($stateList as $stateK=>$stateV){?>
                                      <option value="<?=$stateK?>" ><?=$stateV?></option>
                                  <?php } ?>
                                  </select>
                              </span>
                  </div>
            </div>
                            
                            <!--1111111111-->
                            
                           <fieldset style="padding-top:0;">
                            <h3 style="margin: 32px 0;">Emergency contact details</h3>
								 <div class=" full_width_field">
                                <span class="hfa1_app_full">
										<label class="full_label" for="sha_EC_name">Name</label>
		                                <input style="float:left;" type="text" class="full_input " name="hfa_EC_name" value="" id="hfa_EC_name">
                                </span>
                                
                            </div>
                            <div class=" full_width_field">
                                <span class="hfa1_app_full">
										<label class="full_label" for="sha_EC_relation">Your relationship to this person </label>
                                <input type="text" class="full_input " name="hfa_EC_relation" value="" id="hfa_EC_relation">
                                </span>
                            </div>
                            <div class=" full_width_field">
                                <span class="hfa1_app_full">
										<label class="full_label" for="sha_EC_phone">Phone number</label>
										<input type="text" class="full_input " name="hfa_EC_phone" value="" id="hfa_EC_phone">
									</span>
                            </div>
                            <div class=" full_width_field">
                                <span class="hfa1_app_full">
										<label class="full_label" for="sha_EC_email">Email</label>
										<input type="text" class="full_input " name="hfa_EC_email" value="" id="hfa_EC_email">
                                		<span style="float:left; clear:both; padding-left: 0;" id="hfa_EC_email_error">Email format is wrong</span>
									</span>
                            </div>

						</fieldset>
                            <!--1111111111-->
                      
        
</div>


</fieldset>
</fieldset>

<div class="actions add_new_submission" id="tfa_0-A"><a href="javascript:void(0);" data-target="#retrieve_application" data-toggle="modal" data-backdrop="static" data-keyboard="false"><input type="submit" class="new-buttn" value="Retrieve Saved Application" onclick="clearRetAppFrom();"></a></div>

<fieldset class="section column tfa_2" id="">
<fieldset class="main-bfBlock_new" id="">

<h3>Terms &amp; Conditions</h3>


<div class="reveal-modal" id="myModal">

<legend class="headingHostForm">THE TERMS AND CONDITIONS AGREED BETWEEN GLOBAL EXPERIENCE AND THE HOMESTAY HOST</legend>
<ul type="disc" style="list-style-type:disc; margin-left:16px;">

	<li>Please be advised that the accommodation placement fee, first 4 weeks of Home Stay and Airport pick-up will NOT be confirmed UNLESS fees are fully paid in advance.</li>

	<li>Students must book their accommodation for the first 4 weeks unless certain circumstances apply (please speak to us to see if an alternative arrangement can be made).</li>

	<li>Students are committed to stay in their accommodation for the first 4 weeks at least, unless extreme circumstances apply in which case Global Experience will act immediately.</li>

	<li>Full Home Stay fees are only refundable if cancelled within 48 hours of receiving details.</li>

	<li>Cancellations after 48 hours of details received incur a 2 weeks cancellation fee.</li>

	<li>Accommodation Placement Fee and Airport pick-up are non refundable.</li>

	<li>If you are using our Airport pick-up service and your arrival details have changed, you MUST notify us at least 48 hours in advnace otherwise full Airport pick-up fee will still apply.</li>

	<li>If you do not use our Airport pick-up service and choose to make your own way to your Home Stay, please do NOT ask or expect your Home Stay family to pick you up from the airport as that is not part of the arrangement we had with your Home Stay.</li>

	<li>Internet fee is not included in your accommodation price UNLESS if it is a VIP Home Stay. Internet fee is $10 per week and you need to make this arrangement directly with your host. Please note that movie and music downloads are NOT permitted. If you wish to do so, we suggest you to obtain a pre-paid internet wireless from an internet provider such as Optus, Vodafone, Telstra, Dodo, etc.</li>

</ul>

<legend style="margin-top:20px;" class="headingHostForm">GLOBAL EXPERIENCE </legend>

<p>Global Experience is a homestay and accommodation agency dedicated to providing a high quality of service to our international students and guests. </p>

<p>Global Experience identifies homestay families who offer a warm, home environment and show genuine interest in their guest. These families become a member of our register of homestay families. </p>

<p>This agreement sets out the terms and conditions by which Global Experience retains families on its register and the board arrangements between the homestay family and any guest who may board with them. </p>

<legend style="margin-top:20px;" class="headingHostForm">1.  GLOBAL EXPERIENCE FAMILY REGISTRATION </legend>

<p>1.1 Registration by the homestay family with Global Experience is accepted subject to the terms and conditions set out in this agreement. </p>

<p>1.2 Global Experience has the right to retain the homestay family on its register and to refer guests to the homestay family or to refrain from referring guests to the homestay family. This is done at the sole discretion of Global Experience. </p>

<p>Global Experience will not be required to provide any reason for their referral or failure to refer. Global Experience is under no obligation to continue to refer students or guests. </p>

<p>Global Experience may specify conditions or guidelines for the referral which the homestay family must comply with if the referral is accepted by it. An example condition is that the homestay family will use its best endeavours to ensure a guest under the age of 18 years does not stay out of home at night beyond a specified time. </p>

<p>1.3 Global Experience retains the right to collect information from the family and photos of the residence to support the written outline of hosts and the accommodation ready to be offered. This report is always kept in strict confidence between Global Experience and its clients.</p>

<p>Global Experience advises that the requirements to become a registered homestay family may change from time to time.</p>

<p>1.4 Global Experience cannot guarantee a regular supply of guests to be placed with the registered families due to factors beyond Global Experience's control, for example international economic factors, visa regulations, educational policies, etc. </p>

<p>1.5 Global Experience is not responsible for the late or non-arrival guest who is referred to the homestay family. </p>

<p>1.6 Global Experience retains the right to remove a homestay family from its register at its sole discretion. </p>

<p>1.7 Wherever possible, the homestay family will give Global Experience at least two (2) weeks' notice of a guest leaving their premises. </p>

<p>1.8 Under new Government regulations from the New South Wales Office of the Children's Caregiver, the following requirement must be met before a guest can be placed with a host family: </p>

<p>The main host of the homestay family, a person being over the age of 18, must pass a paid Working with Children Check (WWCC) with the NSW Office of the Children's Caregiver or other responsible government body, if requested, every five (5) years or more frequently if required by law (or requested by Global Experience). </p>

<p>The person nominated as the "main host" is fully responsible to affirm that no member of the host family or persons over the age of 18 residing in the household has ever committed any child-related offences. </p>

<p>All other members of the household over the age of 18 years must pass a volunteer (unpaid) WWCC. </p>

<p>The WWCC clearance number of the host and all other members of the household must be submitted to Global Experience. </p>

<p>1.9 It is a Global Experience requirement that where the guest is under 18 years of age the female host must always be present in the home overnight. A guest under 18 years of age must not be left overnight with only a male host present.</p>

<legend style="margin-top:20px;" class="headingHostForm">2.  WARRANTIES &amp; UNDERTAKINGS BY THE GLOBAL EXPERIENCE HOMESTAY FAMILY </legend>

<p>2.1 The homestay family represents and warrants that no person who will be staying in their home whilst a guest is residing there, has been charged or convicted with any criminal offence. </p>

<p>2.2 If the homestay family gives a guest a termination notice or receives notice of termination from a guest, the homestay family agrees to immediately inform Global Experience on 02 9264 4022 or send an email to:enquiry@globalexperience.com.au. This assists Global Experience in providing additional guests to your home. </p>

<legend style="margin-top:20px;" class="headingHostForm">3.  GLOBAL EXPERIENCE ACTS AS AN AGENT  </legend>

<p>3.1 This document sets out the terms and conditions of the relationship between the Global Experience homestay family and any guest/s who may board with them. </p>

<p>3.2 Global Experience represents many different educational institutions and agents. Each may have their own unique requirements. Their needs will be discussed at the time of placing the guest. The homestay family acknowledges its acceptance of these terms when they agree to host the guest. </p>

<p>3.3 It is acknowledged and agreed that Global Experience acts as an agent on behalf of its guests and Global Experience is not responsible to the homestay family or the guest other than is expressly provided for in this agreement. In each instance when a guest boards with the homestay family the parties to that agreement are and will be deemed to be the homestay family and the guest. </p>

<legend style="margin-top:20px;" class="headingHostForm">4.  TERMS &amp; CONDITIONS OF HOMESTAY   </legend>

<p>4.1 The homestay family agrees that the relationship between them and each guest of Global Experience who boards with them will be subject to the terms and conditions of homestay set out in this agreement. </p>

<p>4.2 Global Experience advises that all registered families are required to: </p>

<p style="margin-left:20px;">a) Carry $20 million public liability insurance and provide a copy of their current insurance certificate to Global Experience each year.  </p>

<p style="margin-left:20px;">b) Make sure a working smoke alarm is located on each level in the house, compliant with State legislation. </p>

<p style="margin-left:20px;">c) Provide a current WWCC Clearance number for the main host and for every other member of the household over the age of 18 years. </p>

<p style="margin-left:20px;">d) Allow a Global Experience representative to inspect the home from time to time. </p>

<p style="margin-left:20px;">e) Work constructively with Global Experience to resolve any issues that may arise from time to time. </p>

<p style="margin-left:20px;">f) Communicate with Global Experience on a regular basis regarding the guest's length of stay and advise if the guest intends to extend their homestay.</p>

<legend style="margin-top:20px;" class="headingHostForm">4.  TERMS &amp; CONDITIONS OF HOMESTAY   </legend>

<p>4.3.1 Global Experience will collect the guest's four (4) week payment prior to the commencement of the homestay pursuant to the terms and agreement of homestay. </p>

<p>A 10% administration fee for the four (4) week stay will be deducted by Global Experience from this payment. A 5% administration fee will be deducted by Global Experience if the homestay booking is for less than three (3) weeks. </p>

<p>If the guest extends their stay an ongoing administration fee will be charged by Global Experience for each week thereafter. </p>

<p>Global Experience will make the first payment to the homestay family on or about two (2) weeks after the guest's arrival at the homestay. This timing has been chosen to avoid the inconvenience of requesting a refund from the family if within the first few days of the guest's arrival to the homestay the guest chooses to leave for any reason. </p>

<p>All payments are made via online banking. Payment may not be received up to three (3) days later depending on the banking institutions involved.</p>

<p>4.3.2 If a guest wishes to stay in a homestay longer than the initial contract period paid for, the host family and/or the guest must advise Global Experience of the extension of their stay. Notice of the extension must be given to Global Experience in the third week of the guest's stay, and a week before any extension thereafter.</p>

<p>Global Experience will manage payments for the whole period of the guest's stay in homestay.  </p>

<p>Private financial arrangements are not to be made between the guest and the host. This policy is in place for the protection of both the guest and the host and to meet with the minimum industry standards set out in the <i>Education Services for Overseas Students Act 2000, the National Code of Practice 2007</i> and as required by the NSW Office of the Children's Caregiver.</p>

<p>4.3.3 Global Experience is to pay the host family directly for the full duration of the guest's stay. The host family is not to take payment directly from the guest. </p>

<p>If the host family repeatedly accepts payments from their guest, Global Experience reserves the right to remove the host family from its register. </p>

<p>4.3.4 For all guests there is an administration fee retained by Global Experience for every week a guest stays in homestay. Global Experience reserves the right to charge a higher fee and a higher homestay rate for the guest where the guest requires additional care. </p>

<p>Prior to a host family accepting a guest, the fees will be explained by one of Global Experience's team members. By accepting the guest the host family agrees to observe the payment process applicable.</p>

<p>4.3.5 Global Experience will be responsible for paying the Goods &amp; Services Tax to the Australian Tax Office on any commissions earned.</p>

<legend style="margin-top:20px;" class="headingHostForm">4.4 Global Experience acts as mediator</legend>

<p>4.4.1 Upon request, Global Experience will assist either party with any problem they may experience with any particular homestay arrangement made by Global Experience and while Global Experience is responsible for the payment to the host family. </p>

<p>Global Experience will assist the guest and the homestay family by acting as a mediator to facilitate a resolution of any problem. It is acknowledged however that Global Experience is not responsible for any act or omission of either party. </p>

<p>4.4.2 All queries or problems should be addressed or referred to The Manager at Global Experience. </p>

<legend style="margin-top:20px;" class="headingHostForm">4.5 Insurance </legend>

<p>4.5.1 All homestay families are required to have a minimum of $20 million of public liability insurance. A copy of their policy must be provided at the time of registering. </p>

<p>Each year thereafter a valid certificate of currency must be sent to Global Experience. This cover protects the family in case of incidence and is mandatory. </p>

<p>4.5.2 A policy to cover the guests, homestay family members, property and other guests to the homestay home is the sole responsibility of the homestay family. The homestay host is responsible for informing their insurance provider that they are hosting paying guests. </p>

<p>4.5.3 The homestay family will indemnify against, and keep Global Experience harmless from, all law suits, actions or claims arising from or incidental to any personal damage occasioned to or caused by a homestay guest, the homestay family or any of their respective guests. </p>

<p>4.5.4 If requested by the host family, Global Experience will organise and pay on behalf of the host their first year of host insurance. Global Experience will charge a small fee for this service. The cost of this insurance and the fee will be deducted from the first homestay payment made to the host family by Global Experience.</p>

<p>4.5.5 The family is responsible for reading and agreeing to the terms and conditions of their insurance. </p>

<legend style="margin-top:20px;" class="headingHostForm">4.6 The Homestay Family's Responsibilities </legend>

<p>4.6.1 Bedroom: The homestay family must provide the guest a bedroom in which there is the following: a good quality bed and mattress, a desk, a chair, a lamp and a wardrobe, and suitable lighting for study and heating/cooling where necessary. It is required that a high standard of cleanliness and hygiene is maintained within the room. </p>

<p>4.6.2 Sheets/Linen: The homestay family must provide clean bed linen and bath towels on a weekly basis at a minimum. </p>

<p>4.6.3 Facilities: The homestay family must make available to the guest the use of all common domestic facilities including: power, water, bathroom, toilet, laundry, kitchen and dining and lounge/family room. </p>

<p>4.6.4 Laundry: The homestay family has the option of teaching the guest how to use the laundry facilities for themselves and giving them free access or to include the guest's washing, if the guest agrees, as part of the family's regular load. </p>

<p>4.6.5 Meals: The host must provide the guest with ingredients for breakfast and offer a prepared dinner (i.e. an evening meal) every day of the week. On weekends, the family is also required to serve lunches for the guest, if the guest is at home. </p>

<p>4.6.6 Visitors: The homestay family must permit the guest to have visitors from time to time.</p>

<p>4.6.7 Telephone and Internet usage: If the home has a landline, the homestay family must permit the guest to receive incoming telephone calls on the landline. The guest must also be permitted to use this landline to make calls to local landline numbers. The host may charge the guest the standard local call rate. If the homestay family has Internet access, it is at their discretion to provide Internet access to their guest. The host is responsible for setting out the conditions of Internet use and may charge the guest the standard weekly rate for Internet access. Global Experience will not be held liable for any Internet use by the guest which is considered illegal under State, Commonwealth and International law. </p>

<p>4.6.8 More generally: The homestay family is to: </p>

<p style="margin-left:20px;">a) Provide a safe and friendly home to the guest and to make the guest feel welcome.</p>

<p style="margin-left:20px;">b) Have house rules in place, and ensure that they are clearly understood. Global Experience recommends the use of its "Important Homestay Guidelines for Hosts" as a guide. </p>

<p style="margin-left:20px;">c) Take the guest on public transport to their place of study on their first day so that the guest will know how to get to their place of study and home again. </p>

<p style="margin-left:20px;">d) Respect the guest's privacy, property and culture. </p>

<p style="margin-left:20px;">e) Encourage the guest to speak English as often as possible and to provide opportunities for English conversation.</p>

<p style="margin-left:20px;">f) Assist with homework, if required, and be patient in conversation with the guest. </p>

<p style="margin-left:20px;">g) Care for the guest's health and wellbeing while staying with the host family, where reasonably possible. </p>

<p style="margin-left:20px;">h) Have the contact numbers of Global Experience at hand, including the emergency phone numbers, should they need to contact the Global Experience office.</p>

<p style="margin-left:20px;">i) Communicate with Global Experience's office when required. This may be to advise when a guest has arrived or departed or simply to share any concerns for the guest's welfare that you observe. </p>

<legend style="margin-top:20px;" class="headingHostForm">4.7 The Guest's Obligations </legend>

<p>The guest must follow the house rules as stated by the host family and to treat the host with courtesy and appreciation for the kindness and care shown. </p>

<p>4.7.1 Cleanliness: The guest must: </p>

<p style="margin-left:20px;">a) Keep their bedroom tidy and not eat in the bedroom. </p>

<p style="margin-left:20px;">b) Keep their clothes in the wardrobe provided. </p>

<p style="margin-left:20px;">c) Make their own bed each morning. </p>

<p style="margin-left:20px;">d) Change their own sheets once a week. </p>

<p style="margin-left:20px;">e) Leave in a clean and tidy state any facilities they use including the bathroom, toilet, laundry and kitchen.</p>

<p>4.7.3 Damage: The guest must report to the homestay family any accidents in or about the home and to pay for any breakages or damage caused by the guest. Normal wear and tear is excluded. </p>

<p>4.7.4 Visitors: The guest must advise the homestay family in advance of any proposed visits by a friend or friends and only allow friends to attend when suitable and convenient to the homestay family. The guest must ensure all visitors abide by the reasonable requests and requirements of the homestay family. </p>

<p>4.7.5 Telephone usage: The guest must limit incoming calls to the host family's landline in number and time so that phone calls do not inconvenience the homestay family. The guest may only make outgoing calls by prior arrangement with the homestay family. The call must be a local call. If the call is a regional, inter-State or international call, the guest must use a pre-paid call card. The host may charge the guest the standard call rate for making local calls. </p>

<p>4.7.6 Internet usage: The provision of Internet access is not a requirement of the homestay. If the homestay family provides Internet access, they may charge the guest the standard weekly rate for access. </p>

<p>4.7.7 Advise of late arrival: The guest must advise the homestay family, in advance, if they are arriving home late or not attending any prepared meal. </p>

<p>4.8 Termination: Either party may terminate the homestay at any time. Two (2) weeks' notice must be given in writing or verbally in a clear and mutually understood manner to the other party. </p>

<p>4.8.1 While every effort is made to secure two (2) weeks' notice, there are occasions where this is not possible due to a dispute over the situation. These situations will be dealt with by Global Experience on a case-by-case basis. </p>

<p>4.8.2 Global Experience relies on the families and guests to deal with each other with integrity and fairness.</p>

<p>4.8.3 If the homestay is terminated and the homestay family has been paid fees which cover a period beyond the two (2) weeks' notice, those funds must be refunded to the guest or to Global Experience on the guest's behalf. </p>

<p>4.8.4 In the event that a homestay is terminated as a result of the homestay family's failure to comply with these terms and conditions (or any variation of them evidenced in writing and signed by the guest and the homestay family) the full amount of all moneys paid in advance will be refunded to the guest or to Global Experience on behalf of the guest.</p>

<legend style="margin-top:20px;" class="headingHostForm">5. Notice</legend>

<p>5.1 Any notice given or served pursuant to this Agreement will be either: </p>

<p style="margin-left:20px;">a) Sent by email which will be deemed to be received at the time the email is sent </p>

<p style="margin-left:20px;">b) Personally served on the person to whom it is given in which case it will be deemed to be received immediately upon delivery </p>

<p style="margin-left:20px;">c) Mailed to the person by pre-paid post in which case it will be deemed to be received on the second business day following the date of posting, or </p>

<p style="margin-left:20px;">d) Sent by facsimile transmission which will be deemed to be received at the time the transmitting machine displays or records confirmation that the transmission has been completed to the person to whom it was sent.</p>

<legend style="margin-top:20px;" class="headingHostForm">EXECUTION OF AGREEMENT </legend>

<p>If the host family agrees with the terms set out in this document and wishes to be included on the Global Experience host family database, the host parent(s) are invited to formally agree to these terms by completing and executing the agreement as follows. </p>

<p>I/We confirm that all information provided to Global Experience is to my/our knowledge true. </p>

<p>In addition I confirm that the main language used within the home amongst family members is English. </p>

<p>I/We confirm that we do not accommodate more than four (4) guests at one time, unless there are exceptional circumstances in which Global Experience is informed and is in full agreement. </p>

<p>I/We agree to inform Global Experience of any alterations in any of the circumstances or information of the following: </p>

<p style="margin-left:20px;">1. The homestay address or contact details. </p>

<p style="margin-left:20px;">2. The household members living in the house either permanently or temporarily. </p>

<p style="margin-left:20px;">3. The occupations or significant lifestyle changes within the household. </p>

<p style="margin-left:20px;">4. The smoking or attitudes to smoking of household members. </p>

<p style="margin-left:20px;">5. The facilities available to the guest(s).</p>

<p style="margin-left:20px;">6. The loss or addition of pets. </p>

<p style="margin-left:20px;">7. The contraction of any illness, physical, mental or emotional of a member of the household. </p>

<p style="margin-left:20px;">8. Any criminal conviction of a member of the household.</p>

<p style="margin-left:20px;">9. Any plans of the family or host parent(s) to go on vacation without the guest, in particular where the guest is a minor.</p>

<p>I/We are willing to undergo a police check when deemed necessary by Global Experience and/or the education provider. </p>

<p>I/We affirm that there has never been a criminal conviction made against any person living in the household. </p>

<p>I/We affirm that no member of the household is the subject of a continuing Apprehended Violence Order (Restraining Order). </p>

<p>I/We affirm that no member of the household has ever been convicted of any child-related offences and I/we also affirm that no member of the household uses illicit drugs. </p>

<legend style="margin-top:20px;" class="headingHostForm">APPLICABLE LAW </legend>

<p>This agreement will be governed by and construed in accordance with the law in force in the State of New South Wales Australia and the parties agree to submit to the jurisdiction of the courts in that State.</p>

</div>

<input type="checkbox" name="tnc" id="tnc" class="errorOnBlur" value="terms" style="margin-top:-3px; margin-right:5px;">
<span>I accept the terms &amp; conditions <span class="reqField">*</span></span>
<p id="tncError" style="display:none;color:#F00; float:right;">Please accept the terms &amp; conditions</p>

</fieldset>
</fieldset>


<fieldset id="" class="section column tfa_3">
<fieldset id="" class="main-bfBlock_new lol">

<h3>Homestay Guidelines for Hosts</h3>


<div id="myModal" class="reveal-modal myModal2">

<p>Thank you for agreeing to share your home and family with international guests and guests. We hope you have a rewarding and memorable experience and that life-long friendships are made.</p>


<legend class="headingHostForm">Delivering a warm welcome </legend>

<p>The first 48 hours are critical to minimise the culture shock your guest may experience. Here are some helpful ideas on welcoming them: </p>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

	<li>Talk to your guest. Show an interest in them and spend time getting to know them. </li>

	<li>Ask what food they would like to eat. </li>

	<li>Encourage them to phone home. They may use Skype to call home or alternatively you can help them buy a calling card.</li>

	<li>Try to introduce them to someone their own age. They may feel more comfortable talking to someone their own age. </li>

	<li>Every culture needs to be treated differently. If you are unfamiliar with your guest's culture, consider doing some research beforehand. For instance, in Italian or Spanish culture it is okay to hug and kiss your guest to welcome them. This might not be the case with Asian guests as they are more reserved. Please be careful and sensitive with this issue as it can cause great offense without meaning to. </li>

</ul>

<p>The main benefit of homestay for the guest is to be able to interact with Australian families and experience the Australian way of living. The expectation is that all Global Experience guests will live as full members of your home, sharing the same meals, living areas and more generally feel 'at home'. You are expected to treat them as members of your own family and the guest is also expected to respect family rules.</p> 

<p>Under new Government regulations from the NSW Office of the Children's Caregiver, the following step must be met before a guest can be placed with a host family. </p>

<p><i>The main host of the homestay family, being a person over the age of 18, must pass a paid "Working with Children Check" (WWCC) with the NSW Office of the Children's Caregiver or other responsible government body if requested, every five (5) years or more frequently if required by law or requested by Global Experience. All other members of the household over the age of 18 years must pass a volunteer (unpaid) WWCC. </i></p>

<p><i>The person nominated as the "main host" is fully responsible to affirm that no member of the host family or persons over the age of 18 residing in the household has ever been convicted of any child-related offences. </i></p>

<p><i>The WWCC clearance numbers of the main host and all other household members must be submitted to Global Experience. </i></p>

<p><i>In addition, no guest under the age of 18 can be left overnight with only a male host in the house.</i> </p>

<p>What follows is a list of guidelines for hosting international guests. We encourage you to discuss them with your guest on the day of their arrival to avoid any misunderstandings in the future. </p>

<legend class="headingHostForm">1. Arrivals and Departures </legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

	<li>Global Experience will advise you of your guest's arrival date and time. These details will be sent to you either via email or postal mail. </li>

	<li>You need to make sure that someone is home on the day of arrival to greet your guest.</li>

	<li>Global Experience will either arrange the guest to be dropped off at your home or the guest will make his or her own way to your home. </li>

	<li>Please note that you are not required to pick up the guest from the airport or their place of arrival, unless requested by Global Experience. We will NOT reimburse any transport and/or parking fee if you choose to do so. </li>

	<li>If expected guests fail to arrive or contact you within three hours of their expected arrival, please contact Global Experience at the emergency number 0430 008 448. If we are unreachable at that time, please leave us a message with your name and contact details and details of what has happened. If you have a commitment elsewhere, we respect your need to fulfill it. Unfortunately our visitors sometimes unexpectedly change their plans and don't let us know!</li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">2. Bedroom  </legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

	<li>The guest must have their own room and privacy. Please do not enter the guest's room without their permission. </li>

	<li>The bedroom should have a comfortable bed, wardrobe, study desk and chair. Adequate lighting, including a desk lamp for study and a heater/fan, must also be supplied. </li>

	<li>Unless a twin bed room is specifically requested, you cannot ask your guest to share the room with another guest(s).</li>

	<li>All family member(s) must have their own bedroom. However well meant, it's not acceptable for you or other family member(s) to sleep in the lounge room and give up your room for the guest</li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">3. Meals </legend>

<p><i>If you are providing FULL BOARD:</i></p>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

	<li>You need to provide breakfast and dinner seven (7) days a week, plus lunch on the weekends.</li>

	<li>Breakfast is self serve, e.g. toast, cereals, milk and yoghurt. </li>

	<li>Lunch is only required on the weekends. Light meals are sufficient though if you choose to cook full meals it is your choice as it is not mandatory. </li>

	<li>Dinner is the most important meal of the day. You need to make sure that you cook a variety of fresh, healthy meals every day. Dinner should offer the following: carbohydrate (bread, rice or pasta), protein (meat, poultry or fish), vegetables and fruits. It is recommended that the evening meal should not commence before 6-6.30 pm if at all possible. </li>

</ul>

<p>Please note that if you are taking your guest out for dinner or a weekend lunch, this should be treated as a meal at home and paid for by you. If they are over 18 and would like to drink some alcoholic beverages, they will have to pay their own drinks. </p>

<p>If you are providing HALF BOARD:</p>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

<li>The guest must be given the opportunity to cook their own meals. You need to allow your guest to use the kitchen facilities. Please explain to them the basic rules around cleaning the kitchen after its use. </li>

<li>The guest will provide their own ingredients to cook the meals, for example they must supply their own cooking oil, salt and pepper, etc. </li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">4. Transport  </legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

	<li>As your guest will be a total stranger to this country, you will need to accompany him or her on their first day, showing them how to travel to and from the college either by public transport or car. You cannot simply provide them with a map or directions as it will be too difficult to understand, especially for those with limited English skills. </li>

	<li>All guests are responsible for paying for their own transport costs unless otherwise advised by Global Experience. </li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">5. Key </legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

	<li>A key to enter the house must be given to the guest as soon as they arrive.  </li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">6. Smoking  </legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

	<li>If you host a smoker, you need to remind them not to smoke inside at all times.   </li>
    
    <li>If you are a smoker, we suggest you smoke outside at all times whilst you host a guest. It is standard practice for each family to provide a smoke-free environment. </li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">7. Housekeeping   </legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

	<li>You are required to provide adequate bed linen and towels for your guest. The guest is to change the bed linen once a week for hygienic purpose unless otherwise agreed with you. </li>
    
    <li>Personal toiletries, such as shampoo, soap etc, are the guest's responsibility.</li>
    
    <li>Toilet paper is supplied by the hosts. </li>
    
     <li>There should always be sufficient hot water for a bath or shower at least once a day. The allowable shower time should be between 10-15 minutes with 10 minutes being the minimum time. </li>
     
      <li>Guests are responsible for cleaning their own room. The host must provide a vacuum cleaner and adequate cleaning supplies to allow this to be done.<br>
      If you share the bathroom with the guest, you're responsible for cleaning the bathroom. If the bathroom is for the guest only, we suggest the guest clean it in turn. </li>
      
      <li>Laundry can be done either by the host or guest once a week. If the guest is okay with doing their own laundry, you need to teach them how to use the washing machine and hang their clothes. Washing powder must be supplied by the host. Please do not charge your guest for washing and drying their own clothes at your household. </li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">8. Courtesy and Supervision   </legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

<li>The guest must inform the host parent where they are going and what time they will be home. For under 18's please refer to point 20 in page 8. Over 18's are to be home by 10.30 pm during weekdays and 12 am during weekends, unless otherwise agreed with you. </li>

<li>It's understood that you may be away from time to time. When this happens you will need to ensure there is an adult at your home to supervise the guest, provide the guest meals and generally be available. You also need to clearly explain the situation to Global Experience and the guest so we understand what is happening. If you are going to be away for an extended period of time, you must contact Global Experience so that another homestay can be arranged for the guest. </li>

<li>If you are hosting guests under the age of 18, you need to make sure that you do not leave your guest at home alone overnight without any supervision from an adult person. The host mother must always be present in the home. A guest under the age of 18 must never be left overnight with only a male host in the home. Please refer to point 21 for more details. </li>

<li>Where the guest has an appointed caregiver, you are entitled to have the caregiver's contact details in case of emergency or to discuss any issues the guest may have. </li>

<li>Guests under the age of 18 years must sign an agreement with the college agreeing to be home before 9 pm (the actual time may vary depending on the college) and attend 80% of their classes. They are also not to enter bars or places where alcohol is sold. If you have a guest that is not complying with these guidelines, do contact the caregiver and Global Experience so that appropriate action can be taken. 

</li></ul>

<legend class="headingHostForm" style="margin-top:20px;">9. Insurance </legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

<li>Having the correct insurance is mandatory to be a host family with Global Experience and many of the educational providers. </li>

<li>When you are hosting a guest at your home, you are required to have Public Liability insurance cover of up to $20 million. Please check with your insurance provider to confirm they provide this cover for a 'paying guest' and provide us with a copy of your current insurance certificate or visit http://www.homestayhostinsuranceplus.com. This homestay host insurance is specifically designed for homestay and provides cover for all guests staying with you over a 12-month period.  </li>

<li>Contents insurance is optional, however, it's suggested you have it as well.  </li>

<li>Guests are expected to have their own travel insurance.  </li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">10. Smoke Alarms  </legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

<li>It is compulsory to have smoke alarms installed at your home on each level.  </li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">NSW Smoke Alarms - It's the law </legend>

<p><i>From 1 May 2006, all New South Wales residents must have at least one working smoke alarm installed on each level of their home. This includes owner occupied, rental properties, relocatable homes or any other residential building where people sleep. Smoke alarms are already mandatory for all new buildings and in some instances when buildings are being renovated. Smoke alarms are life-saving devices that provide benefits for occupants. They detect smoke well before any sleeping occupant would and provide critical seconds to implement actions to save life and property. Smoke alarms are designed to detect fire smoke and emit a loud and distinctive sound to alert occupants of potential danger.</i></p>

<legend class="headingHostForm">11. Telephones and Internet </legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

<li>Many guests come from countries where the Internet and phone calls are free. Make sure the guest understands the rules regarding telephone and Internet usage from the very beginning.</li>

<li>The standard charge for Internet Access for guests in a homestay situation is $10 per week. This arrangement is made between you and the guest. Global Experience is not responsible for collecting the Internet fee on your behalf. You are responsible for making sure you have the right Internet plan and that the guest is using the service correctly. Make sure whatever Internet plan you have, no over-usage fees apply.  </li>

<li>For telephone calls, you need to advise the guest to use his or her own mobile to make calls. If you have a landline, it is expected the guest is allowed to receive incoming calls. </li>

<li>Global Experience suggests that the guest may receive calls after 7 am weekdays and 9 am weekends and before 10 pm daily, except by prior arrangement.  </li>

<li>Guests may use your telephone to make local calls only. You are allowed to charge them around 40-50 cents per call. To avoid any confusion, advise them to use their own mobile when calling other mobile phones.</li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">12. Homestay Changes</legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

<li>The standard homestay booking is for four (4) weeks, unless indicated otherwise. </li>

<li>If things do not work out between you and the guest, you need to give two (2) weeks' notice to allow the guest to secure alternative accommodation. Please make sure you let us know about this situation so that we are aware of what has been happening. Guests must also give you two (2) weeks' notice if they wish to move out.   </li>

<li>Please note there are circumstances where two weeks' notice may not apply and these are dealt with on a case-by-case basis. </li>

<li>When booking changes occur, a booking fee and notice period will apply unless the change occurred because the guest's visa was cancelled or not approved, or for some other extraordinary event such as illness or accident.   </li>

<li>Every endeavour is made to secure two weeks' notice from guests when a change of homestay is requested. However, where there is a dispute or issue between the guest and the host this may not be possible. </li>

<li>If the homestay is terminated and the homestay family has been paid fees which cover a period beyond the two (s) weeks' notice, those funds must be refunded by the homestay family to the guest or to Global Experience on the guest's behalf. </li>

<li>When there is an issue or dispute, notice periods are assessed on a case-by-case basis. All parties are required to behave with integrity and fairness. </li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">13. Holiday</legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

<li>If the guest is going on holiday the homestay payment will normally be half of the regular accommodation fee. </li>

<li>During their absence, if you wish to rent the room to other guests, you must check first with your guest if that arrangement is okay. You need to respect their privacy. If they disagree with your proposal you must respect that they have paid you to keep the room until their return.</li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">14. Payments and Your Responsibilities </legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

<li>Homestay rates vary according to the age of the guest and the college they are attending. The rate may be higher where the guest requires additional care. We will always confirm the weekly rate with you. The choice is yours as to whether you accept the guest or not. </li>

<li>All payments are made via online banking. We require your banking details in writing and you can email them to admin@globalexperience.com.au or fax them to 02 9264 9322. If you change your bank account, remember to advise us in writing of the new account details. Global Experience takes no responsibility for payments made to the old account. </li>

<li>For all guests there is an administration fee retained by Global Experience for every week a guest stays in homestay. A 10% administration fee for the four (4) week stay will be deducted from the first week's payment to the host family. A 5% administration fee will be deducted if the homestay booking is less than three (3) weeks. If the guest extends their stay an ongoing administration fee will be charged for each week thereafter. </li>

<li>Global Experience will make the first payment to the homestay family on or about two (2) weeks after notice of the guest's arrival at the homestay. This timing has been chosen to avoid the inconvenience of requesting a refund from the family if within the first few days of the guest's arrival to the homestay they choose to leave for any reason. </li>

<li>Payment may not be received up to three (3) days later, depending on the banking institutions involved. </li>

<li>If a guest wishes to stay in homestay longer than the initial contract period paid for, the host family and/or the guest must advise Global Experience of the extension of their stay. Please contact us by phone on 02 9264 4022 or email admin@globalexperience.com.au during the third week of the guest's four week stay, and a week before any extension thereafter. </li>

<li>Private financial arrangements are not to be made between the guest and the host. This policy is in place for the protection of both the guest and the host, and to meet with the minimum homestay industry standards set out in the Education Services for Overseas Students Act 2000, the National Code of Practice 2007, and as required by the NSW Office of the Children's Caregiver. </li>

<li>Global Experience will manage payments for the whole period of the guest's stay in homestay. The host family is not to take payments directly from the guest. If the guest suggests a "private" arrangement and you agree, Global Experience reserves the right not to place guests with you in the future. </li>

<li>Homestay is a business about people. We rely on our families to work with us in the spirit of goodwill and integrity. The ripple effect of people "breaking" these rules is time consuming, disruptive and impacts many different parties. Global Experience relies on families to have integrity and work within the guidelines given.</li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">15. Homestay and Tax </legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

<li>The Australian Taxation Office (ATO) has indicated that you can have up to two (2) guests at your home without paying tax. Please call the ATO on 13 28 61 if you wish to obtain further information. ATO legislation does change from time to time and we suggest you contact them to ensure the information is still current.</li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">16. Guests and Visitors </legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

<li>If your guest would like to bring a visitor into your home, they need to ask for your permission first. If you give permission, they are only allowed to bring that visitor to your home when you are home, unless you have given permission otherwise. </li>

<li>If they have guests from overseas, i.e. a mother, sister, etc, who would like to stay overnight at your home, please discuss the rate you wish to charge with us.</li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">17. Accident or Illness </legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

<li>If your guest becomes ill or has an accident, do help them obtain medical assistance by taking them to the nearest GP or hospital as appropriate. </li>

<li>If your guest is under 18 and has an appointed caregiver, the caregiver needs to be contacted as soon as possible. </li>

<li>Guests will pay their own medical expenses. Hosts are not required to pay these expenses. Remember, the college does not reimburse for any expenditure you choose to make. </li>

<li>The guest should have up-to-date Overseas Student Health Cover (OSHC) as it is a condition of their visa. </li>

<li>In the case of an incident such as a robbery, please make sure you report it to the police and let Global Experience know at the same time. </li>

<li>Make sure you keep a record of what's happening and inform Global Experience at the same time. In case of emergency please call 0430 008 448. </li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">18. Cancellations  </legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

<li>Occasionally, due to unforeseen circumstances, guests cancel their course and their homestay accommodation. We will let you know if this is the case and will endeavour to place another guest with you as soon as possible. Cancellation fees do not apply when this occurs. </li>

<li>Please note that we do not pay cancellation fees if the guest's visa is not approved. </li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">19. Authority </legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

<li>Make sure that you do not accept any other authority, i.e. of the guest, their agent or friend etc, speaking on the guest's behalf regarding accommodation without first consulting Global Experience. </li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">20. Hosting Guests Under 18 Years </legend>

<p>The rules for hosting guests under the age of 18 are as follows.</p>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

<li>Guests under 16 years must be home by 7.30 pm Sunday to Thursday, and by 9 pm on Friday and Saturday nights. </li>

<li>Guests over 16 years must be home by 9 pm Sunday to Thursday, and by 10.30 pm on Friday and Saturday nights. </li>

<li>The guest must contact the host family if they are not going to be home for dinner. </li>

<li>Staying overnight at any other accommodation is NOT allowed unless approved in advance by the college or caregiver. Please make sure you check with Global Experience before allowing your guest to stay overnight at someone's house. </li>

<li>Guests under 18 years must NOT bring friends into the host's home without first gaining permission from the host. </li>

<li>Guests must NOT enter premises where alcohol is sold, e.g. bars, nightclubs and casinos. </li>

<li>Guests must maintain a minimum of 80% attendance at college and make good progress in their studies. </li>

</ul>

<p>If your guest refuses to follow any of the above rules, please make sure you notify the caregiver as well as Global Experience. </p>

<legend class="headingHostForm">21. Emergency Contact </legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

<li>Our office is open Monday to Friday between 10am - 5.30pm, except during Public Holidays.  </li>

<li>If you need to contact us outside those hours, please call our emergency number 0430 008 448. </li>

<li>Worldcare also provides a 24-7 interpreter service for homestay hosts and students with Worldcare OSHC. Please call 1800 814 781. </li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">GLOBAL EXPERIENCE POLICY </legend>
<legend class="headingHostForm">STUDENTS' HOMESTAY EXTENSION</legend>

<p>If a Student wishes to stay in their Homestay for any period longer than the initial agreed period paid for (either paid to Global Experience or to a Student's Education Provider/Agent), the Student must advise Global Experience. </p>

<p>Extension and payment must be made directly to Global Experience or the Student's Education Provider/Agent. </p>

<p>Private financial agreements are not to be made between the student and the Host family. This policy is in place to meet the new minimum standards for Homestay and for the protection of both parties, the Student and the Host. </p>

<legend class="headingHostForm">BENEFITS OF THIS POLICY:</legend>

<img src="https://www.globalexperience.com.au/wp-content/themes/ge/img/c72504762594b947cc6286f9d1122ae9-Benefit.png">

<p>Please contact Global Experience if and when you plan on extending your Homestay </p>

<p>Please email: accounts@globalexperience.com.au </p>

<p>Office: +61 2 9264 4022 </p>

<p>Fax: +61 2 9264 9322 </p>

<p>Mobile: 0430 008 448 </p>


</div>

<span class="homestayGuidlinesss">
<input type="checkbox" style="margin-top:-3px; margin-right:5px;" value="terms" id="homestayGuidlines" name="homestayGuidlines" class="errorOnBlur">
<span>I  accept the Homestay Guidelines for Hosts <span class="reqField">*</span></span>
</span>
<p id="homestayGuidlinesError" style="display:none;color:#F00; float:right;">Please accept the Homestay Guidelines</p>

</fieldset>
</fieldset>

<div class="end-options">
<input type="button" value="Submit &amp; continue" id="hfaOneSubmitBtn" class="btn-btn-medium hfa_submit">

<div id="hfaOneProcess" style="display:none;" class="appFormProcess">
	<img src="<?=str_replace('http:','https:',static_url())?>img/submitload.gif"   />
</div>

<span id="hfaOneError" style="display:none;color:#F00;">The form is incomplete. Fields outlined with red are required in the right format.</span>
</div>

<p class="end-options-para">After submitting the application, you can continue to fill the application form further or you can fill the full application form later, using the link 
sent in your email.</p>

</form>
</div>
</div>


</div>
<script type="text/javascript">
$(document).ready(function(){
	//$('#retrieve_application').modal({backdrop: 'static', keyboard: false});
	var preferred_way_current_value = $("input[name='hfa_contact_way']:checked").val();
	
	if(parseInt(preferred_way_current_value)==2) {
		$(".toggle_time_wrapper").hide();
	}
	
	$("input[name='hfa_contact_way']").click(function(){
		var current_value = $(this).val();
		if(parseInt(current_value)==2) {
			$(".toggle_time_wrapper").slideUp();
		}
		else {
			$(".toggle_time_wrapper").slideDown();
		}
	});	
	
	$('#ret_app_btn').click(function(){
		
		var $ret_app_btn_process=$('#ret_app_btn_process');
		var $ret_app_btn=$('#ret_app_btn');
								
			$('#ret_app_link, #ret_app_error, #ret_app_btn_process').hide();
			$ret_app_btn_process.hide()
			
			
			var $ret_app_email=$('#ret_app_email');
			var ret_app_email=$ret_app_email.val().trim();
			
			removeFieldError($ret_app_email);
			if(ret_app_email=='')
					addFieldError($ret_app_email);
			else
			{
				$ret_app_btn_process.show();
				$ret_app_btn.hide();
				
				var ret_app_form_data=$('#ret_app_form').serialize();
				$.ajax({
						url:site_url()+'form/ret_app_form_hfa_submit',
						type:'POST',
						dataType: 'json',
						data:ret_app_form_data,
						success:function(data)
							{
								$ret_app_btn_process.hide();
								$ret_app_btn.show();
									data.step = data.step - 1;
									if(data.error==1)
										$('#ret_app_error').show();
									else
									{
										$("#step1,#step2,#step3,#step4").css({'background':'','color':'','font-weight':''});
										
										if(data.step==1)
										{
											$("#step1 img, #step2 img,#step3 img,#step4 img").remove();
											$("#step1").css({'font-weight':'bold','color':'#1d7643','background':'#eee'}).append('<img src="<?=str_replace('http:','https:',static_url())?>img/complete-tick.png" />');
										}
										if(data.step==2)
										{
											$("#step1 img, #step2 img,#step3 img,#step4 img").remove();
											$("#step1").css({'font-weight':'bold','color':'#1d7643','background':'#eee'}).append('<img src="<?=str_replace('http:','https:',static_url())?>img/complete-tick.png" />');
											$("#step2").css({'font-weight':'bold','color':'#1d7643','background':'#eee'}).append('<img src="<?=str_replace('http:','https:',static_url())?>img/complete-tick.png" />');
										}
										if(data.step==3)
										{
											$("#step1 img, #step2 img,#step3 img,#step4 img").remove();
											$("#step1").css({'font-weight':'bold','color':'#1d7643','background':'#eee'}).append('<img src="<?=str_replace('http:','https:',static_url())?>img/complete-tick.png" />');
											$("#step2").css({'font-weight':'bold','color':'#1d7643','background':'#eee'}).append('<img src="<?=str_replace('http:','https:',static_url())?>img/complete-tick.png" />');	
											$("#step3").css({'font-weight':'bold','color':'#1d7643','background':'#eee'}).append('<img src="<?=str_replace('http:','https:',static_url())?>img/complete-tick.png" />');
										}
										if(data.step==4)
										{
											$("#step1 img, #step2 img,#step3 img,#step4 img").remove();
											$("#step1").css({'font-weight':'bold','color':'#1d7643','background':'#eee'}).append('<img src="<?=str_replace('http:','https:',static_url())?>img/complete-tick.png" />');
											$("#step2").css({'font-weight':'bold','color':'#1d7643','background':'#eee'}).append('<img src="<?=str_replace('http:','https:',static_url())?>img/complete-tick.png" />');	
											$("#step3").css({'font-weight':'bold','color':'#1d7643','background':'#eee'}).append('<img src="<?=str_replace('http:','https:',static_url())?>img/complete-tick.png" />');
											$("#step4").css({'font-weight':'bold','color':'#1d7643','background':'#eee'}).append('<img src="<?=str_replace('http:','https:',static_url())?>img/complete-tick.png" />');
										}
										$('#ret_app_found_email').text(ret_app_email);
										$('#ret_app_found_continue').attr('href',data.link);
										$('#ret_app_link').show();
									}
							}
					});
			}		
			
		});
	
	
	$('#hfa_contact_time').timepicker();
	
	
	$('#postal_address_same, #postal_address_provide').click(function(){
			if($('input[name=hfa_postal_address]:checked').val()==0)
				$('#postal_address_provideDiv').slideUp();
			else	
				$('#postal_address_provideDiv').slideDown();
		});
	
	$('#hfaOneSubmitBtn').click(function(){
			
			var $hfaOneProcess=$('#hfaOneProcess');
			var $hfaOneSubmitBtn=$('#hfaOneSubmitBtn')
			
			var $hfa_name_title=$('#hfa_name_title');
			var $hfa_fname=$('#hfa_fname');
			var $hfa_lname=$('#hfa_lname');
			var $hfa_email=$('#hfa_email');
			var $hfa_number=$('#hfa_number');
			var $hfa_suburb=$('#hfa_suburb');
			var $hfa_postcode=$('#hfa_postcode');
			var $hfa_state=$('#hfa_state');
			var $tnc=$('#tnc');
			var $homestayGuidlines=$('#homestayGuidlines');
			
			var $hfa_home_phone=$('#hfa_home_phone');
			var $hfa_work_phone=$('#hfa_work_phone');
			var $hfa_suburb_postal=$('#hfa_suburb_postal');
			var $hfa_postcode_postal=$('#hfa_postcode_postal');
			var $hfa_state_postal=$('#hfa_state_postal');
			var $hfa_EC_email=$('#hfa_EC_email');
			
			var hfa_name_title=$hfa_name_title.val();
			var hfa_fname=$hfa_fname.val().trim();
			var hfa_lname=$hfa_lname.val().trim();
			var hfa_email=$hfa_email.val().trim();
			var hfa_number=$hfa_number.val().trim();
			var hfa_suburb=$hfa_suburb.val().trim();
			var hfa_postcode=$hfa_postcode.val().trim();
			var hfa_state=$hfa_state.val().trim();
			var tnc=$tnc.is(':checked');
			var homestayGuidlines=$homestayGuidlines.is(':checked');
			
			var hfa_home_phone=$hfa_home_phone.val().trim();
			var hfa_work_phone=$hfa_work_phone.val().trim();
			var hfa_suburb_postal=$hfa_suburb_postal.val().trim();
			var hfa_postcode_postal=$hfa_postcode_postal.val().trim();
			var hfa_state_postal=$hfa_state_postal.val();
			var hfa_postal_address=$('input[name=hfa_postal_address]:checked').val();
			var hfa_EC_email=$hfa_EC_email.val().trim();
			
			removeFieldError($hfa_fname);
			removeFieldError($hfa_lname);
			removeFieldError($hfa_email);
			removeFieldError($hfa_number);
			removeFieldError($hfa_suburb);
			removeFieldError($hfa_postcode);
			removeFieldError($hfa_state);	
			$('#tncError').hide()
			$('#homestayGuidlinesError').hide()
			$('#hfaOneError').hide();
			
			removeFieldError($hfa_home_phone);
			removeFieldError($hfa_work_phone);
			removeFieldError($hfa_suburb_postal);
			removeFieldError($hfa_postcode_postal);
			removeFieldError($hfa_state_postal);
			removeFieldError($hfa_EC_email);
			$('#hfa_email_error, #hfa_EC_email_error').hide();
			
			if(hfa_fname=='' || hfa_lname=='' || hfa_email=='' || !isValidEmailAddress(hfa_email) || hfa_number=='' /*|| isNaN(hfa_number)*/ || hfa_suburb=='' || hfa_postcode=='' || isNaN(hfa_postcode) || hfa_state=='' || tnc==false || homestayGuidlines==false /*|| (hfa_home_phone!='' && isNaN(hfa_home_phone))*/ /*|| (hfa_work_phone!='' && isNaN(hfa_work_phone))*/ || (hfa_postal_address==1 && hfa_suburb_postal=='') || (hfa_postal_address==1 && (hfa_postcode_postal=='' || isNaN(hfa_postcode_postal))) || (hfa_postal_address==1 && hfa_state_postal=='')|| (hfa_EC_email != '' && !isValidEmailAddress(hfa_EC_email)))
			{
					if(hfa_fname=='')
						addFieldError($hfa_fname);
					else	
						removeFieldError($hfa_fname);

					if(hfa_lname=='')
						addFieldError($hfa_lname);
					else	
						removeFieldError($hfa_lname);
												
					if(hfa_email=='' || !isValidEmailAddress(hfa_email))
						{
							if(hfa_email!='' && !isValidEmailAddress(hfa_email))
								$('#hfa_email_error').show();
							addFieldError($hfa_email);
						}
					else	
						removeFieldError($hfa_email);
						
					if(hfa_number=='' /*|| isNaN(hfa_number)*/)
						addFieldError($hfa_number);
					else	
						removeFieldError($hfa_number);
					
					if(hfa_suburb=='')
						addFieldError($hfa_suburb);
					else	
						removeFieldError($hfa_suburb);
					
					if(hfa_postcode=='' || isNaN(hfa_postcode))
						addFieldError($hfa_postcode);
					else	
						removeFieldError($hfa_postcode);
					
					if(hfa_state=='')
						addFieldError($hfa_state);
					else	
						removeFieldError($hfa_state);	
					
					if(tnc==false)
						$('#tncError').show()
					else	
						$('#tncError').hide()
						
					if(homestayGuidlines==false)	
						$('#homestayGuidlinesError').show()
					else	
						$('#homestayGuidlinesError').hide()
						
					///	
					/*if(hfa_home_phone!='' && isNaN(hfa_home_phone))
						addFieldError($hfa_home_phone);
					else	
						removeFieldError($hfa_home_phone);	
					
					if(hfa_work_phone!='' && isNaN(hfa_work_phone))
						addFieldError($hfa_work_phone);
					else	
						removeFieldError($hfa_work_phone);*/
						
					if(hfa_postal_address==1 && hfa_suburb_postal=='')
						addFieldError($hfa_suburb_postal);
					else	
						removeFieldError($hfa_suburb_postal);
						
					if(hfa_postal_address==1 && (hfa_postcode_postal=='' || isNaN(hfa_postcode_postal)))
						addFieldError($hfa_postcode_postal);
					else	
						removeFieldError($hfa_postcode_postal);
						
					if(hfa_postal_address==1 && hfa_state_postal=='')
						addFieldError($hfa_state_postal);
					else	
						removeFieldError($hfa_state_postal);
				
					if(hfa_EC_email != '' && !isValidEmailAddress(hfa_EC_email))
					{
						$('#hfa_EC_email_error').show();
						addFieldError($hfa_EC_email);
					}
					else
						removeFieldError($hfa_EC_email);
						
			//$('#hfaOneError').show();
			scrollToDiv('#add-hostfamily-application');
			errorBar('All fields marked with red are required');
			}
			else
			{
				$hfaOneProcess.show();
				$hfaOneSubmitBtn.hide();
				
				var host_family_application_oneData=$('#host_family_application_oneForm').serialize();
				$.ajax({
					url:site_url()+'form/host_family_application_one_submit',
					type:'POST',
					data:host_family_application_oneData,
					success:function(data)
					{
						//$hfaOneSubmitBtn.show();
						if(data=='duplicate-email')
						{
							scrollToDiv('#add-hostfamily-application');
							errorBar('Email id already used, use some other email id');
							addFieldError($hfa_email);
							$hfaOneSubmitBtn.show();
							$hfaOneProcess.hide();
						}
						else
							window.location.href=data+'/pop';
					}
				});
			}
			
		});
		
	});

function clearRetAppFrom()
	{
		$('#ret_app_form')[0].reset();
		$('#ret_app_error, #ret_app_link').hide();
	}		
</script>