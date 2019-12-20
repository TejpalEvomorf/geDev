<?php
$nameTitleList=nameTitleList();
$genderList=genderList();
$accomodationTypeList=accomodationTypeList();
$nationList=nationList();
$datePickerDobSettings=datePickerDobSettings();
?>

<!--Retriever application Pop Up STARTS-->
  <div class="modal fade successPop" id="retrieve_application"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h2 class="modal-title" style="text-align:center;font-size:20px;">Retrieve Saved Application</h2>
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
                            
                              <div class="modal-footer" id="ret_app_link" style="margin-top:0; display:none;">
                              <!--<p style="font-size:14px; color:#666666; margin-bottom: 8px; text-align: center;">Here is the application associated with <span id="ret_app_found_email"></span></p>
                              <a style="float: left; text-align: center; width: 100%;" id="ret_app_found_continue">CONTINUE TO NEXT STEP</a>
                             <span id="sha-step1" style="font-weight:bold; color:#1d7643; background:#eeeeee; margin-top:30px;">Step 1: Personal Details (Complete) <img src="<?=static_url()?>img/complete-tick.png" /></span>
                            <span>Step 2: Other Details</span>
                            <span>Step 3: Health Details and Preferences</span>-->
							</div>
							
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div>
<!--Retriever application Pop ENDS-->

<div id="student-homestay-application" class="wFormContainer new_forms add-hostfamily-application">
<legend class="headingHostForm">Student Homestay Application Form 
<span class="hand-written">All fields with red asterick<span class="reqField"> * </span>are mandatory</span></legend>
  <div style="background:none;" class="">
  <div class="wForm" id="tfa_0-WRPR" dir="ltr">
  
<form method="post"  class="hintsBelow labelsAbove" id="sha_oneForm">
<fieldset id="tfa_14" class="section column">
<fieldset id="" class="main-bfBlock_11 main-bfBlock_1 main-bfBlock_new">

<h3>Personal Details</h3>

<div class="hfa1_home_left">		

<div class=" full_width_field">
				<span class="hfa1_app_onefourth">
				<label class="onefourth_label full_label" for="sha_per_title_input">Title</label>
				 <select name="sha_name_title" class="onefourth_input" id="sha_name_title">
				<option value="">Select</option>
                <?php foreach($nameTitleList as $ntK=>$ntV){?>
                	<option value="<?=$ntK?>" class=""><?=$ntV?></option>
                    <?php } ?>
                </select>
				</span>
              <span class="hfa1_app_onefofth">
			<label class="full_label" for="sha_fname">First name <span class="reqField">*</span></label>
			<input type="text" class="full_input errorOnBlur" name="sha_fname" value="" id="sha_fname">
			</span>
</div>
		
<div class="hfa1_unit_street_name full_width_field">
            <span class="hfa1_app_half margin_10">
			<label for="sha_mname" class="half_label full_label">Middle name</label>
			<input type="text" id="sha_mname" value="" name="sha_mname" class="half_input">
			</span>
			<span class="hfa1_app_half">
			<label class="half_label full_label" for="sha_lname">Last name <span class="reqField">*</span></label>
			<input type="text" class="half_input errorOnBlur" name="sha_lname" value="" id="sha_lname">
			</span>
 </div>
        
<div class="hfa1_unit_street_name full_width_field">
			<span class="hfa1_app_half margin_10">
			<label for="sha_gender" class="half_label full_label">Gender <span class="reqField">*</span></label>
            <select id="sha_gender" class="half_input errorOnBlur" name="sha_gender">
            <option value="">Select</option>
            <?php foreach($genderList as $glK=>$glV){?>
	            <option value="<?=$glK?>"><?=$glV?></option>
			<?php } ?>
            </select>
			</span>
            <span class="hfa1_app_half">
			<label for="sha_dob" class="half_label full_label">Date of birth <span class="reqField">*</span></label>
			<input type="text" id="sha_dob" value="" name="sha_dob" class="half_input date-of-birth3 date-icon errorOnBlur"  readonly="readonly">
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="sha_email">Email <span class="reqField">*</span></label>
			<input type="text" class="full_input errorOnBlur" name="sha_email" value="" id="sha_email">
			</span>
            <span id="sha_email_error">Email format is wrong</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="sha_mobile">Mobile number </label>
			<input type="text" class="full_input errorOnBlur notReq" name="sha_mobile" value="" id="sha_mobile">
			</span>
</div>

<div class=" full_width_field">
            <span class="hfa1_app_full">
			<label class="full_label" for="sha_home_phone">Home phone number</label>
			<input type="text" class="full_input  errorOnBlur notReq" name="sha_home_phone" value="" id="sha_home_phone">
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="sha_nationality" class="full_label">Nationality</label>
            <select class="full_input" id="sha_nationality" name="sha_nationality">
				<option value="">Select one</option>
                <?php foreach($nationList as $nlK=>$nlV){?>
	                <option value="<?=$nlK?>" class=""><?=$nlV?></option>
               <?php } ?>
				</select>
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="sha_student_no">Student College id/number </label>
			<input type="text" class="full_input errorOnBlur notReq" name="sha_student_no" value=" " id="sha_student_no">
			</span>
</div>    

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label class="full_label" for="sha_accomodation">Accommodation type <span class="reqField">*</span></label>
            <select id="sha_accomodation" class="full_input errorOnBlur" name="sha_accomodation">
				<option value="">Select one</option>
                <?php foreach($accomodationTypeList as $atK=>$atV){?>
	                <option value="<?=$atK?>" class=""><?=$atV?></option>
                <?php } ?>
                </select>
			</span>
</div>
<div class=" full_width_field left_margin" id="type_accomodation" style="display:none;">
			<span class="hfa1_app_full smoke-yes">
			<label for="sha_name2" class="full_label hidden_label">Second student name</label>
			<input type="text" id="sha_name2" value="" name="sha_name2" class="full_inputss">
			</span>
</div>
</div>


<div class="hfa1_home_right">





<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="sha_passport" class="full_label">Passport number</label>
			<input type="text" id="sha_passport" value="" name="sha_passport" class="full_input">
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="sha_passport_expiry" class="full_label">Passport expiry date</label>
			<input type="text" id="sha_passport_expiry" value="" name="sha_passport_expiry" class="full_input date-icon date-of-birth3" readonly="readonly">
			</span>
</div>

<div class=" full_width_field">
			<span class="hfa1_app_full">
			<label for="sha_arrival_date" class="full_label">Arrival date</label>
			<input type="text" id="sha_arrival_date" value="" name="sha_arrival_date" class="full_input date-icon date-of-birth3" readonly="readonly">
			</span>
</div>

<div class=" full_width_field">
                                        <span class="hfa1_app_full">
                                        <label for="sha_arrival_date" class="full_label hidden_label">Duration of stay</label>
                                        </span>
                                        <span class="hfa1_app_half margin_10">
                                        <label for="sha_duration_week" class="half_label full_label">Weeks</label>
                                        <input type="text" id="sha_duration_week" value="" name="sha_duration_week" class="half_input">
                                        </span>
                                        <span class="hfa1_app_half">
                                        <label for="sha_duration_day" class="half_label full_label">Days</label>
                                        <input type="text" id="sha_duration_day" value="" name="sha_duration_day" class="half_input">
                                        </span>
                            </div>
                            
                            <!--1111111111-->
                            
                            <fieldset style="padding-top:0;">
                            <h3 style="margin: 32px 0;">Emergency contact details</h3>
								 <div class=" full_width_field">
                                <span class="hfa1_app_full">
										<label class="full_label" for="sha_EC_name">Name</label>
		                                <input style="float:left;" type="text" class="full_input " name="sha_EC_name" value="" id="sha_EC_name">
                                </span>
                                
                            </div>
                            <div class=" full_width_field">
                                <span class="hfa1_app_full">
										<label class="full_label" for="sha_EC_relation">Relationship to student </label>
                                <input type="text" class="full_input " name="sha_EC_relation" value="" id="sha_EC_relation">
                                </span>
                            </div>
                            <div class=" full_width_field">
                                <span class="hfa1_app_full">
										<label class="full_label" for="sha_EC_phone">Phone number</label>
										<input type="text" class="full_input " name="sha_EC_phone" value="" id="sha_EC_phone">
									</span>
                            </div>
                            <div class=" full_width_field">
                                <span class="hfa1_app_full">
										<label class="full_label" for="sha_EC_email">Email</label>
										<input type="text" class="full_input " name="sha_EC_email" value="" id="sha_EC_email">
                                		<span style="float:left; clear:both; padding-left: 0;" id="sha_EC_email_error">Email format is wrong</span>
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

<!--<legend class="headingHostForm">THE TERMS AND CONDITIONS AGREED BETWEEN GLOBAL EXPERIENCE AND THE STUDENT HOMESTAY</legend>-->
<ul type="disc" style="list-style-type:disc; margin-left:16px;">

	<li>Please be advised that the accomodation placement fee, first 4 weeks of homestay and airport pick-up will not be confirmed unless fees are fully paid in advance.</li>

	<li>Students must book their accomodation for the first 4 weeks unless certain circumstances apply (please speak to us to see if an alternative arrangement can be made).</li>

	<li>Students are committed to stay in their accomodation for at least the first 4 weeks, unless if it is under extreme circumstances.</li>

	<li>Students must inform Global experience and the family if they wish to change their accomodation. Two week's notice will apply for any homestay changes.</li>

	<li>Accomodation placement fee is non-refundable.</li>

	<li>Full homestay accomodation fees are only refundable if cancellation recieved prior to 2 working days of student's arrival. Cancellation made after this period will incur 2 weeks cancellation fee.</li>

	<li>Airport pick-up fee is only refundable if cancellation received prior to 2 working days of student's arrival otherwise full airport pick-up fee will still apply.</li>

	<li>If you are using our airport pick-up service and your arrival details have changed, you must notify us at least 48 hours in advance otherwise full airport pick-up fee will still apply.</li>

	<li>If you do not use our airport pick-up service and choose to make your own way to your homestay, please do not ask or expect your homestay family to pick you up from the airport as that is not part of the arrangement we had with your homestay.</li>
</ul>

</div>

<input type="checkbox" name="tnc" id="tnc" value="terms" class="errorOnBlur" style="margin-top:-3px; margin-right:5px;">
<span>I accept the terms &amp; conditions <span class="reqField">*</span></span>
<p id="tncError"  style="display:none;color:#F00; float:right;">Please accept the terms &amp; conditions</pn>

</fieldset>
</fieldset>


<fieldset id="" class="section column tfa_3">
<fieldset id="" class="main-bfBlock_new">

<h3>Important Homestay Guidelines for Guests</h3>


<div id="myModal" class="reveal-modal">

<p>Welcome to Australia! We hope you have a rewarding and memorable experience with your host family and that life-long friendships will be made. </p>


<legend class="headingHostForm">Arriving to a warm welcome </legend>

<p>The first 48 hours are very important and will have a lasting impression on you and your host family. We suggest you do these things with your new host family:  </p>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

	<li>Talk to your hosts, show an interest in them and spend time getting to know them. </li>

	<li>Call your family back home and ask your host family for assistance in making the call if you need to.</li>

	<li>Try to listen to the family's house rules to avoid any misunderstandings. </li>

	<li>Bring a small gift for your host. It is a nice thing to do and can be a topic of conversation if it is something that is from your home country. </li>

	<li>Get a mobile phone to make sure you are contactable by your family back home and your host. </li>

</ul>

<p>Below are the guidelines that you need to follow during your homestay.</p> 

<legend class="headingHostForm">1. Arrivals and Departures </legend>

<p>At the time of booking you need to decide whether you want to be picked up at the airport or make your own way to the host family. If you wish to be picked up, Global Experience will arrange this for you. Your host family will wait for you at their home. They are not the ones to pick you up.
If you are delayed, you will need to ring and let your host family know. Their details will be on the profile sent to you and/or your agent. </p>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

	<li>Bring a good attitude with you and smile when you arrive. First impressions are important. </li>

	<li>You will either be escorted to your home by our transport provider or make your own way. </li>

	<li>Global Experience will either arrange the guest to be dropped off at your home or the guest will make his or her own way to your home. </li>
    
</ul>

<legend class="headingHostForm" style="margin-top:20px;">2. Bedroom  </legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

	<li>Your room will have a bed, wardrobe, desk and chair. </li>

	<li>Adequate heating and cooling equipment will also be provided during winter and summer. However, you MUST make sure that you do not abuse this facility. Remember to switch the lights off before you go to bed and before you leave any room or the house itself. Please note that electricity in Australia is expensive so please be considerate of your host's good nature. </li>

	<li>Lights must be switched off before you go to sleep. </li>

	<li>You CANNOT eat in your bedroom. You need to eat in the dining room provided. It is unhygienic to eat inside the room as it attracts insects such as cockroaches, ants, etc. </li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">3. Meals </legend>

<p><i>If you have requested Standard Full Board Homestay: </i></p>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

	<li>You will have seven (7) days of breakfast and dinner, plus lunches on the weekend, provided..</li>

	<li>Breakfast is self serve, e.g. toast, cereals, milk and yoghurt. </li>

	<li>Lunch is only provided on weekends and it may be a light meal such as sandwiches.  </li>

	<li>Dinner is the most important meal of the day. Dinner should offer the following: carbohydrate (bread, rice or pasta), protein (meat, poultry or fish), vegetables and fruits. Evening meals are normally served around 6.30 pm -7 pm.</li>

	<li>If your hosts have evening commitments and they cannot sit with you at dinner, they will normally leave your meal in the fridge for you. </li>
    
	<li>If you don't come home for dinner, as a courtesy you need to let your host know as soon as possible. The earlier the better as they will be preparing dinner for you otherwise. </li>
    
	<li>Dinner is the best time to get to know your family and share your experience with them. It is your responsibility to come home at the time allocated by your host for dinner if you wish to interact with them. </li>
    
	<li>Do not expect your host to wait until you come home around 8-9 pm to have dinner with you. </li>
    
	<li>Do not expect your host to cook for you after 9 pm. </li>
    
	<li>If you missed dinner, the host will normally leave the food in the fridge and you can just heat it up in the microwave. </li>
    
	<li>You need to make sure you wash your dishes after dinner. Remember that in Australia, most households don't have servants. By helping, you are showing goodwill to your host family. </li>

</ul>

<p>Please note that if you are taking your guest out for dinner or a weekend lunch, this should be treated as a meal at home and paid for by you. If they are over 18 and would like to drink some alcoholic beverages, they will have to pay their own drinks. </p>

<p>If you have requested Half Board Homestay: </p>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

<li>You will have the opportunity to cook your own meals and the host will provide the kitchen facilities. </li>

<li>You will have to provide your own ingredients to cook your meal, for example you must supply your own cooking oil, salt and pepper, etc.</li>

<li>You need to keep the kitchen neat and tidy after using it. </li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">4. Transport  </legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

	<li>Your hosts are responsible for showing you how to get to the college on your first day. They might do this by driving you there or going with you on public transport. Make sure you ask questions about where to catch public transport and where to go if you don't understand. Your hosts will be worried if you get lost and don't come home on time. </li>

	<li>All students are responsible for paying for their own transportation. </li>
    
    <li>In the case of a medical emergency involving yourself, where your hosts are unable to provide transport to a doctor or hospital, you will be responsible for the costs of any emergency transport</li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">5. Key </legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

	<li>You will be given a set of keys to enter the house. You need to make sure you look after the keys and return them upon leaving your homestay. If you lose the keys, you need to replace them or pay to have them replaced. </li>

   <li>When you enter or leave the house make sure you lock the door. Although Australia is a relatively safe country it is customary for the doors to be locked. </li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">6. Smoking  </legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

	<li>Smoking is NOT allowed inside the home at any time. You are liable or responsible for stains or damage caused by your smoking inside. Please smoke outside only. </li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">7. Housekeeping   </legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

	<li>Your host will provide you with adequate bed linen and towels. </li>
    
    <li>Personal toiletries, such as shampoo, soap etc, are the guest's responsibility.</li>
    
    <li>For hygiene, make sure you change the bed linen once a week. </li>
    
     <li>Personal toiletries, such as shampoo, soap, etc, are your responsibility. </li>
     
      <li>Toilet paper will always be supplied by the hosts. </li>
      
      <li>There should always be sufficient hot water for a bath or shower at least once a day. The allowable time for a shower is normally around 10 minutes. There is a focus in Australia on using water wisely as it is a limited resource. </li>

      <li>Please consider others when using the bathroom by keeping it clean, neat and dry after use. </li>
      
      <li>You are responsible for keeping your room neat and tidy at all times. The host family will provide you with a vacuum cleaner and cleaning supplies so that you can clean your room. Sometimes your host will offer to clean your room but this is not always the case. If you prefer to clean your own room, you just need to let them know. </li>
      
      <li>If you share the bathroom with other guests, it is expected that you and the other guest(s) take turns cleaning the bathroom. </li>
      
      <li>Laundry can be done once a week only. Make sure you understand how to do laundry and ask your host to show you if you don't know how. </li>
      
      <li>If more assistance than usual is required of your host by way of housekeeping or support for you, Global Experience reserves the right to charge an additional fee for your homestay.</li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">8. Courtesy and Supervision   </legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

<li>Students are expected to tell the host parent where they are going and what time they will be home. Please give your host your mobile number so that they can contact you any time. </li>

<li>You need to understand that you are living with another family. <b>If you are over 18 years of age, try to come home at a reasonable time, namely by 10.30 pm on weekdays and 12 am on weekends. If you are under 18 years, you will have a different curfew time.</b> Please refer to point 14. </li>

<li>After 10 pm on weekdays, please be quiet in the house as your hosts may need to sleep well to be prepared to go to work the next day. If you have to make phone calls to your family, try to minimise the noise as much as possible. </li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">9. Insurance </legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

<li>You need to make sure that you are fully protected while you are staying in Australia. We recommend you have some form of insurance that will cover your health and belongings. Please check with your homestay coordinator at your college for advice.  </li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">10. Telephones and Internet </legend>

<p>In Australia charges apply for Internet and phone usage. You will be expected to pay for the services you use and this can be very expensive. </p>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

<li>Internet access and usage is NOT included in your homestay accommodation package. </li>

<li>The availability of Internet access might vary depending on the family. If your family has limited Internet access at home one solution could be pre-paid dongles. Your host will assist you with the process of purchasing the dongle and teach you how to use it. </li>

<li>If you share Internet access with your host family, your host will normally charge $10 per week. You can use the Internet for browsing, emailing and chatting. However, downloading movies and music and conducting video conferencing is not usually included. </li>

<li>You are strictly forbidden from accessing inappropriate websites on the Internet, such as adult material, during your homestay.</li>

<li>You may receive calls made to the host's landline telephone during reasonable hours that is after 7 am weekdays and 9 am weekends and before 10 pm daily, except by prior arrangement with your host family. It's important you check with your host family about using the phone. Most families only have one landline telephone and it may need to be shared with many people. </li>

<li>You may use the landline telephone to make local calls only. You may be charged 40-50 cents per call. Calling mobile phones is normally not allowed except by prior arrangement with the host family. </li>

<li>You are responsible for complying with the arrangements made with your host family. </li>

</ul>

<legend class="headingHostForm">12. Homestay Changes  </legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

<li>Each request to change a homestay arrangement is assessed on a case-by-case basis. </li>

<li>The standard homestay booking is for four (4) weeks, unless otherwise indicated. If you wish to extend your homestay, please contact Global Experience at least one week before the end of your stay. </li>

<li>If things do not work out between you and the hosts, you need to give two (2) weeks' notice of your intention to leave. Please make sure that you let your host, the college and Global Experience know so that we are all aware of what is happening. Hosts are also required to give you two weeks' notice if they cannot host you any longer.  </li>

<li>Please note on those occasions where you choose to leave without giving two weeks' notice, two weeks of homestay fees will still apply unless otherwise agreed. </li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">13. Holiday</legend>

<p>If you are going on holiday and expect your host to hold the room for you, there will be a holding fee of approximately 50% of the homestay rate.</p>


<legend class="headingHostForm" style="margin-top:20px;">14. If You Are Under 18 </legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

    <li>If you are under 16 years, you must be home by 7.30 pm Sunday to Thursday, and by 9 pm on Friday and Saturday nights. </li>
    
   <li> If you are over 16 years, you must be home by 9 pm Sunday to Thursday, and by 10.30 pm Friday and Saturday nights. </li>
   
    <li>Staying overnight at any other accommodation is not allowed unless approved in advance by the college or your appointed caregiver. </li>
    
    <li>There will always be a female host in the home overnight. You will not be left overnight with only a male host in the home. </li>
    
    <li>You must not bring friends into the host's home without first gaining permission from the host. </li>
    
    <li>You must not enter premises where alcohol is sold, e.g. bars, nightclubs and casinos. </li>
    
   <li> You must maintain a minimum of 80% attendance at college and make good progress in your college studies. If you refuse to follow these rules, your caregiver and Global Experience will be notified. Your host family is obliged to tell your caregiver, your college and Global Experience. Breaking these rules may put you in breach of your visa and you will be expelled from Australia if that's the case.</li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">15. Damage </legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

<li>If you damage anything in the house, you need to let your hosts know. You are responsible for paying for the cost of the damage done.</li>

</ul>

<legend class="headingHostForm" style="margin-top:20px;">16. Emergency Contact </legend>

<ul type="disc" style="list-style-type:disc; margin-left:16px;">

<li>Our office is open Monday to Friday between 10am - 5.30 pm, except during Public Holidays. </li>

<li>If you need to contact us outside these hours, please call our emergency number 0430 008 448. </li>

<li>Worldcare also provides a 24-7 interpreter service for Homestay Hosts and Students with Worldcare Overseas Student Health Cover. Please contact 1800 814 781.</li>

</ul>

</div>

<span class="sha_guidelinesss">
<input type="checkbox" style="margin-top:-3px; margin-right:5px;" value="terms" id="sha_guidelines" name="tnc" class="errorOnBlur">
<span>I  accept the Homestay Guidelines for Hosts <span class="reqField">*</span></span>
</span>
<p id="sha_guidelinesError" style="display:none;color:#F00; float:right; margin-bottom:0;">Please accept the Guidelines for Hosts</p>

</fieldset>
</fieldset>

<div class="end-options">
<input type="button" value="Submit &amp; continue" id="shaOneSubmitBtn" class="btn-btn-medium hfa_submit">

<div id="shaOneProcess" style="display:none;" class="appFormProcess">
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
						url:site_url()+'form/ret_app_form_sha_submit',
						type:'POST',
						dataType: 'json',
						data:ret_app_form_data,
						success:function(data)
							{
								$ret_app_btn_process.hide();
								$ret_app_btn.show();
								if(data.error==1)
										$('#ret_app_error').show();
								else
										$('#ret_app_link').html(data.html).show();
							}
					});
			}		
			
		});
		
		$('#sha_dob').datepicker({
		  changeMonth: true,
		  changeYear: true,
		  yearRange: "<?=$datePickerDobSettings['year_from'].':'.$datePickerDobSettings['year_to']?>",
		  defaultDate:"<?=$datePickerDobSettings['default_date']?>",
		  dateFormat: 'dd/mm/yy'
		});

		$('#sha_passport_expiry').datepicker({
		  changeMonth: true,
		  changeYear: true,
		   yearRange: "c-5:c+30",
		  dateFormat: 'dd/mm/yy'
		});		
		
		$('#sha_arrival_date').datepicker({
		  changeMonth: true,
		  changeYear: true,
		   yearRange: "c-5:c+10",
		  dateFormat: 'dd/mm/yy'
		});		
	
	$('#shaOneSubmitBtn').click(function(){
		
			var $shaOneProcess=$('#shaOneProcess');
			var $shaOneSubmitBtn=$('#shaOneSubmitBtn');
			
			var $sha_fname=$('#sha_fname');
			var $sha_lname=$('#sha_lname');
			var $sha_gender=$('#sha_gender');
			var $sha_dob=$('#sha_dob');
			var $sha_email=$('#sha_email');
			var $sha_mobile=$('#sha_mobile');
			var $sha_home_phone=$('#sha_home_phone');
			var $sha_accomodation=$('#sha_accomodation');
			var $tnc=$('#tnc');
			var $sha_guidelines=$('#sha_guidelines');
			var $sha_EC_email=$('#sha_EC_email');
			
			var sha_fname=$sha_fname.val().trim();
			var sha_lname=$sha_lname.val().trim();;
			var sha_gender=$sha_gender.val();
			var sha_dob=$sha_dob.val().trim();
			var sha_email=$sha_email.val().trim();
			var sha_mobile=$sha_mobile.val().trim();
			var sha_home_phone=$sha_home_phone.val().trim();
			var sha_accomodation=$sha_accomodation.val().trim();
			var tnc=$tnc.is(':checked');
			var sha_guidelines=$sha_guidelines.is(':checked');
			var sha_EC_email=$sha_EC_email.val().trim();
			
			var $tncError=$('#tncError');
			var $homestayGuidlinesError=$('#sha_guidelinesError');
			var $hfaOneError=$('#hfaOneError');
			
			$tncError.hide();
			$homestayGuidlinesError.hide();
			$hfaOneError.hide();
			
			removeFieldError($sha_fname);
			removeFieldError($sha_lname);
			removeFieldError($sha_gender);
			removeFieldError($sha_dob);
			removeFieldError($sha_email);
			removeFieldError($sha_mobile);
			removeFieldError($sha_home_phone);
			removeFieldError($sha_accomodation);
			removeFieldError($sha_EC_email);
			$('#sha_email_error, #sha_EC_email_error').hide();
			
			if(sha_fname=='' || sha_lname=='' || sha_gender=='' || sha_dob=='' || sha_email=='' || !isValidEmailAddress(sha_email)  || sha_accomodation=='' || !tnc || !sha_guidelines || (sha_EC_email != '' && !isValidEmailAddress(sha_EC_email)))
			{
				if(sha_fname=='')	
					addFieldError($sha_fname);
				else	
					removeFieldError($sha_fname);
						
				if(sha_lname=='')	
					addFieldError($sha_lname);
				else	
					removeFieldError($sha_lname);
					
				if(sha_gender=='')	
					addFieldError($sha_gender);
				else	
					removeFieldError($sha_gender);
					
				if(sha_dob=='')	
					addFieldError($sha_dob);
				else	
					removeFieldError($sha_dob);
					
				if(sha_email=='' || !isValidEmailAddress(sha_email))	
				{
					if(sha_email!='' && !isValidEmailAddress(sha_email))
						$('#sha_email_error').show();
					addFieldError($sha_email);
				}
				else	
					removeFieldError($sha_email);
					
				/*if(sha_mobile=='')	
					addFieldError($sha_mobile);
				else	
					removeFieldError($sha_mobile);
					*/
					
				if(sha_accomodation=='')	
					addFieldError($sha_accomodation);
				else	
					removeFieldError($sha_accomodation);
				
				if(!tnc)
					$tncError.show();
				else
					$tncError.hide();
					
				if(!sha_guidelines)
					$homestayGuidlinesError.show();
				else
					$homestayGuidlinesError.hide();
				
				if(sha_EC_email != '' && !isValidEmailAddress(sha_EC_email))
				{
					$('#sha_EC_email_error').show();
					addFieldError($sha_EC_email);
				}
				else
					removeFieldError($sha_EC_email);
					
					//$hfaOneError.show();
					scrollToDiv('#student-homestay-application');
					errorBar('All fields marked with red are required');
			}
			else
			{
				$shaOneProcess.show();
				$shaOneSubmitBtn.hide();
				
				var sha_oneForm=$('#sha_oneForm').serialize();
				$.ajax({
						url:site_url()+'form/sha_one_submit',
						type:'POST',
						data:sha_oneForm,
						success:function(data)
							{
									if(data=='duplicate-email')
									{
										scrollToDiv('#student-homestay-application');
										errorBar('Email id already used, use some other email id');
										addFieldError($sha_email);
										$shaOneSubmitBtn.show();
										$shaOneProcess.hide();
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