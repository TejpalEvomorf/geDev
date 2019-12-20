 
 $(document).ready(function() {
	
			$('#hfa_flooring_select').change(function(){
				var room_value=$('#hfa_flooring_select').val();
				if(room_value==5)
					$('#type_flooring').slideDown();
				if(room_value!=5)
					$('#type_flooring').slideUp();
			});
			
			
			$('#hfa_internet_to_students').change(function(){
				var internetType=$(this).val();
				if(internetType==1)
					$('#hfa_internet_to_students_type').slideDown();
				else
					$('#hfa_internet_to_students_type').slideUp();
			});	 
			
			
			$('.room_flooring_select').change(function(){
				var room_value=$(this).val();
				var room_valueParent=$(this).attr('id');
				var memberSplit=room_valueParent.split('-');
				
				if(room_value==5)
				$('#bedroom_flooring_'+memberSplit[1]).slideDown();
				if(room_value!=5)
				$('#bedroom_flooring_'+memberSplit[1]).slideUp();
			});		
			
			$('.hfa_access_room').change(function(){
				var room_value=$(this).val();
				var room_valueParent=$(this).attr('id');
				var memberSplit=room_valueParent.split('-');
				
				if(room_value==1)
				$('#access_room_outside_'+memberSplit[1]).slideDown();
				if(room_value!=1)
				$('#access_room_outside_'+memberSplit[1]).slideUp();
			});	
			
			$('.hfa_room_availability').change(function(){
				var room_value=$(this).val();
				var room_valueParent=$(this).attr('id');
				var memberSplit=room_valueParent.split('-');
				
				if(room_value=="0")
				$('#room_availability_'+memberSplit[1]).slideDown();
				if(room_value!="0")
				$('#room_availability_'+memberSplit[1]).slideUp();
			});		
			
			$('.hfa_hosting_student').change(function(){
				var room_value=$(this).val();
				var room_valueParent=$(this).attr('id');
				var memberSplit=room_valueParent.split('-');
				
				if(room_value==1)
				$('#hosting_details_'+memberSplit[1]).slideDown();
				if(room_value!=1)
				$('#hosting_details_'+memberSplit[1]).slideUp();
			});		
			
			$('.hfa_room_ensuite').change(function(){
				var room_value=$(this).val();
				var room_valueParent=$(this).attr('id');
				var memberSplit=room_valueParent.split('-');
				
				if(room_value=="0")
				$('#access_room_ensuite_'+memberSplit[1]).slideDown();
				if(room_value!="0")
				$('#access_room_ensuite_'+memberSplit[1]).slideUp();
			});		
			
			$('#hfa1_laundry_available').change(function(){
				var room_value=$('#hfa1_laundry_available').val();
				if(room_value==1)
				$('#laundry_outside_house, #hfa_laundry_avail_outsideP').slideDown();
				if(room_value!=1)
				$('#laundry_outside_house, #hfa_laundry_avail_outsideP').slideUp();
			});		
			
			$('.hfa_type_wwcc_clearance').change(function(){
				var room_value=$(this).val();
				var room_valueParent=$(this).attr('id');
				var memberSplit=room_valueParent.split('-');
				if(room_value==''){
					$('#clearance_availability_'+memberSplit[1]).slideUp();
					$('#clearance_non_availability_'+memberSplit[1]).slideUp();
				}else{
					if(room_value==1){
						$('#clearance_availability_'+memberSplit[1]).slideDown();
						$('#clearance_non_availability_'+memberSplit[1]).slideUp();
					}else if(room_value==0){
						$('#clearance_availability_'+memberSplit[1]).slideUp();
						$('#clearance_non_availability_'+memberSplit[1]).slideDown();
					}
				}
			});		
			
			$('.hfa_working_children').change(function(){
				
				var room_value=$(this).val();
				var room_valueParent=$(this).attr('id');
				var memberSplit=room_valueParent.split('-');
				if(room_value==1)
				$('#type_wwcc_clearance_'+memberSplit[1]).slideDown();
				if(room_value!=1)
				{
					$('#type_wwcc_clearance_'+memberSplit[1]).slideUp();
					$('#clearance_availability_'+memberSplit[1]).slideUp();
					
					$('#type_wwcc_clearance_'+memberSplit[1]+' select').val('');
				}
			});	
			
			$('.hfa_type_wwcc').change(function(){
				
				var room_value=$(this).val();
				var room_valueParent=$(this).attr('id');
				var memberSplit=room_valueParent.split('-');
				if(room_value=="1")
				$('#type_wwcc_clearance_'+memberSplit[1]).slideDown();
				if(room_value!="1")
				{
					$('#type_wwcc_clearance_'+memberSplit[1]).slideUp();
					$('#clearance_availability_'+memberSplit[1]).slideUp();
					
					$('#type_wwcc_clearance_'+memberSplit[1]+' select').val('');
				}
			});		
			
			$('#hfa_pet').change(function(){
				var room_value=$('#hfa_pet').val();
				if(room_value==1)
				{
					$('#pets_lives, #what_pets_lives, #pet_desc').slideDown();
					if($('#pet_other').is(':checked'))
						$('#type_pet').show();
					else	
						$('#type_pet').hide();
				}
				if(room_value!=1)
				{
					$('#pets_lives, #what_pets_lives, #pet_desc').slideUp();
					$('#type_pet').hide();
				}
			});		
			
			$('#hfa_insurance').change(function(){
				var room_value=$('#hfa_insurance').val();
				if(room_value==1)
				{
					$('#type_insurance').slideDown();
					$('#type_insurance_info').hide();
				}
				if(room_value!=1)
				{
					if(room_value=="0")
					{
						$('#type_insurance_info').slideDown();
						$('#type_insurance').hide();
					}
					else	
					{
						$('#type_insurance_info, #type_insurance').slideUp();
					}
					
				}
			});		
			
			/*$('#hfa_Liability_insurance').change(function(){
				var room_value=$('#hfa_Liability_insurance').val();
				if(room_value==1)
				$('#content-insurance').slideDown();
				if(room_value!=1)
				$('#content-insurance').slideUp();
			});*/		
			
			$('#hfa_international_student').change(function(){
				var room_value=$('#hfa_international_student').val();
				if(room_value==1)
				$('#international_student').slideDown();
				if(room_value!=1)
				$('#international_student').slideUp();
			});		
			
			$('#hfa_diet_student_accomodate').change(function(){
				var room_value=$('#hfa_diet_student_accomodate').val();
				if(room_value==1)
				$('#type_of_dietary').slideDown();
				if(room_value!=1)
				$('#type_of_dietary').slideUp();
			});		
			
			$('#hfa_allergic_student_accomodate').change(function(){
				var room_value=$('#hfa_allergic_student_accomodate').val();
				if(room_value==1)
				$('#type_of_allergies').slideDown();
				if(room_value!=1)
				$('#type_of_allergies').slideUp();
			});		
			
			
			$('#sha_accomodation').change(function(){
				var room_value=$('#sha_accomodation').val();
				if(room_value=="2")
				$('#type_accomodation').slideDown();
				if(room_value!="2")
				$('#type_accomodation').slideUp();
			});		
			
			$('#sha_student_religion').change(function(){
				var room_value=$('#sha_student_religion').val();
				if(room_value=='0')
				$('#type_religion').slideDown();
				if(room_value!='0')
				$('#type_religion').slideUp();
			});		
			
			$('#sha_live_with_pets').change(function(){
				var room_value=$('#sha_live_with_pets').val();
				if(room_value==1)
				{
					$('#pets_lives_can, #what_pets_lives_can').slideDown();
					if($('#sha_pet_other').is(':checked'))
						$('#sha_type_pet').slideDown();	
				}
				if(room_value!=1)
					$('#pets_lives_can, #what_pets_lives_can, #sha_type_pet').slideUp();
				
			});	
			
			$('#sha_insurance').change(function(){
				var room_value=$('#sha_insurance').val();
				if(room_value==1)
				$('#sha_type_insurance, #content_insurance_upload').slideDown();
				if(room_value!=1)
				$('#sha_type_insurance, #content_insurance_upload').slideUp();
			});	
			
//			$('#sha_airport_pickup').change(function(){
//				var room_value=$('#sha_airport_pickup').val();
//				if(room_value==1)
//				$('#airport_pickup_options').slideDown();
//				if(room_value!=1)
//				$('#airport_pickup_options').slideUp();
//			});	
			
			$('#sha_home_student_past').change(function(){
				var room_value=$('#sha_home_student_past').val();
				if(room_value==1)
				$('#homestay_student').slideDown();
				if(room_value!=1)
				$('#homestay_student').slideUp();
			});	
			
			$('#sha_guardian').change(function(){
				var room_value=$('#sha_guardian').val();
				if(room_value=="1")
				$('#sha_guardian_requirementsDiv').slideDown();
				if(room_value!="1")
				$('#sha_guardian_requirementsDiv').slideUp();
			});	
			

		$('#sha_guardian_type').change(function(){
				var room_value=$('#sha_guardian_type').val();
				if(room_value==2)
				$('#guardian_types_insurance').slideDown();
				if(room_value!=2)
				$('#guardian_types_insurance').slideUp();
			});	
			
			$('#sha_student_diet').change(function(){
				
				$('#dietError').hide();
				$('.sha_diet').each(function(){
					$(this).attr('checked', false);
				});
				
				$('#sha_dietary_requirements').hide();
				$('#sha_diet_other_val').val('');

				var room_value=$('#sha_student_diet').val();
				if(room_value==1)
				$('#sha_type_of_dietary').slideDown();
				if(room_value!=1)
				$('#sha_type_of_dietary').slideUp();
			});		
			
			$('#sha_student_allergies').change(function(){
				
				$('#allergyError').hide();
				$('.sha_allergy').each(function(){
					$(this).attr('checked', false);
				});
				
				$('#sha_allergy_requirements').hide();
				$('#sha_allergy_other_val').val('');
				
				var room_value=$('#sha_student_allergies').val();
				if(room_value==1)
				$('#sha_type_of_allergies').slideDown();
				if(room_value!=1)
				$('#sha_type_of_allergies').slideUp();
			});		
			
			$('#sha_student_smoke').change(function(){
				var room_value=$('#sha_student_smoke').val();
				if(room_value==2)
				$('#sha_smoking_requirements').slideDown();
				if(room_value!=2)
				$('#sha_smoking_requirements').slideUp();
			});		
			
			$('#sha_student_medication').change(function(){
				var room_value=$('#sha_student_medication').val();
				if(room_value==1)
				$('#sha_student_medication_requirement').slideDown();
				if(room_value!=1)
				$('#sha_student_medication_requirement').slideUp();
			});	
			
			$('#sha_student_disabilities').change(function(){
				var room_value=$('#sha_student_disabilities').val();
				if(room_value==1)
				$('#sha_student_disabilities_requirement').slideDown();
				if(room_value!=1)
				$('#sha_student_disabilities_requirement').slideUp();
			});		
			
			
			$('#homestay_choosing_reason').change(function(){
				var room_value=$('#homestay_choosing_reason').val();
				if(room_value==3)
				$('#homestay_reason').slideDown();
				if(room_value!=3)
				$('#homestay_reason').slideUp();
			});	
			
			$('#homestay_hear_ref').change(function(){
				var room_value=$('#homestay_hear_ref').val();
				if(room_value==7)
				$('#hearabout_reason').slideDown();
				if(room_value!=7)
				$('#hearabout_reason').slideUp();
			});
			
			$('#hfa_ref').change(function(){
			
				var room_value=$('#hfa_ref').val();
				//alert(room_value);
				if(room_value==7)
				$('#hfa_ref_other_div').slideDown();
				if(room_value!=7)
				$('#hfa_ref_other_div').slideUp();
				if(room_value==2)
				$('#hfa_ref_homestay_family_div').slideDown();
				if(room_value!=2)
				$('#hfa_ref_homestay_family_div').slideUp();
			});					
			
			
			$('#sha_other_allergies').click(function() {
			$('#sha_allergy_requirements').slideToggle(this.checked);
			});	
			
			
			$('#sha_other_dietary').click(function() {
			$('#sha_dietary_requirements').slideToggle(this.checked);
			});	
			
			
			$('#sha_pet_other').click(function() {
			$('#sha_type_pet').slideToggle(this.checked);
			});	
			
			
			$('#facility_others').click(function() {
			$('#type_facility').slideToggle(this.checked);
			});
			
			$('#pet_other').click(function() {
			$('#type_pet').slideToggle(this.checked);
			});
			
			$('#other_allergy_type').click(function() {
			$('#other_allergies').slideToggle(this.checked);
			});
			
			$('.errorOnBlur').change(function(event){
					var type=event.target.type;
					//alert(type);
					var elem=$(this);
					var thisVal=elem.val().trim();
					//alert(thisVal);
					if(type=='text' || type=='select-one' || type=='textarea')
					{
					  if(thisVal!='' || elem.hasClass('notReq'))
						  removeFieldError(elem);
					}
					else if(type=='checkbox')
					{
						if(elem.is(':checked'))
							$('#'+elem.attr('id')+'Error').hide();
					}
				});
				
			$('#hfa_religion')	.change(function(){
				var hfa_religion=$(this).val();
				if(hfa_religion=="0")
					$('#religion_other').slideDown();
				else
					$('#religion_other').slideUp();
				});
				
			$('.hfa_wwcc_file').change(function(){
				
				if (window.File && window.FileReader && window.FileList && window.Blob)
		  			{
						var $btn=$(this);
						var id=$btn.attr('id').split('-');
				
						if (this.files && this.files[0]) 
							{
									if(!checkFileExt($(this).val()))
									  {
										   errorBar("Only .jpg, .jpeg or .png  or .pdf or .docx files are allowed");
									  }
									 else if(!checkFileSize($(this)[0].files[0].size))
									  {
										   errorBar("Please select file less than 2MB");
									  }
									  else
										{
											$('#hfa_wwcc_file_btn-'+id[1]).hide();
											$('#hfa_wwcc_file_name-'+id[1]).show();
											
											 $('#hfa_wwcc_file_name_text-'+id[1]).text($btn.val()).show();
										}
							}
					}
		  		else
					{
						alert("Please upgrade your browser, because your current browser lacks some new features we need!");
						return false;
					}
				});
				
			$('.hfa_upload_diff_file').click(function(){
						var $btn=$(this);
						var id=$btn.attr('id').split('-');
						$('#hfa_wwcc_file_name-'+ id[1]).hide();
						$('#hfa_wwcc_file_name_text-'+ id[1]).text('').hide();
						$('#hfa_wwcc_file-'+ id[1]).val('');
						$('#hfa_wwcc_file_btn-'+ id[1]).show();
						
				});
			
			$('.hfa_upload_diff_file_edit').click(function(){
						var $btn=$(this);
						var id=$btn.attr('id').split('-');
						$('#hfa_wwcc_file_name-'+ id[1]).hide();
						$('#hfa_wwcc_file_name_text_edit-'+ id[1]).hide();
						$('#hfa_wwcc_file-'+ id[1]).val('');
						$('#hfa_wwcc_file_btn-'+ id[1]).show();
						$('#hfa_use_same_file-'+ id[1]).show();
						$('#hfa_wwcc_file_update-'+id[1]).val(1);
				});
				
				$('.hfa_use_same_file').click(function(){
						var $btn=$(this);
						var id=$btn.attr('id').split('-');
						
						$btn.hide();
						$('#hfa_wwcc_file_btn-'+ id[1]).hide();
						$('#hfa_use_same_file-'+ id[1]).hide();
						$('#hfa_wwcc_file_name-'+ id[1]).show();
						$('#hfa_wwcc_file_name_text_edit-'+ id[1]).show();
						$('#hfa_wwcc_file_name_text-'+ id[1]).text('').hide();
						$('#hfa_wwcc_file_update-'+id[1]).val(0);
				});
				
				
				
				/////////PL ins files
				$('#hfa_ins_file').change(function(){
				
				if (window.File && window.FileReader && window.FileList && window.Blob)
		  			{
						var $btn=$(this);
						//var id=$btn.attr('id').split('-');
				
						if (this.files && this.files[0]) 
							{
									if(!checkFileExt($(this).val()))
									  {
										   errorBar("Only .jpg, .jpeg or .png  or .pdf or .docx files are allowed");
									  }
									 else if(!checkFileSize($(this)[0].files[0].size))
									  {
										   errorBar("Please select file less than 2MB");
									  }
									  else
										{
											$('#hfa_ins_file_btn').hide();
											$('#hfa_ins_file_name').show();
											
											 $('#hfa_ins_file_name_text').text($btn.val()).show();
										}
							}
					}
		  		else
					{
						alert("Please upgrade your browser, because your current browser lacks some new features we need!");
						return false;
					}
				});
		
			  $('#hfa_upload_diff_file_ins').click(function(){
							  $('#hfa_ins_file_name').hide();
							  $('#hfa_ins_file_name_text').text('').hide();
							  $('#hfa_ins_file').val('');
							  $('#hfa_ins_file_btn').show();
							  
					  });
			  
			  $('.hfa_upload_diff_file_edit_ins').click(function(){
							  $('#hfa_ins_file_name').hide();
							  $('#hfa_ins_file_name_text_edit').hide();
							  $('#hfa_ins_file').val('');
							  $('#hfa_ins_file_btn').show();
							  $('#hfa_use_same_file_ins').show();
							  $('#hfa_ins_file_update').val(1);
					  });
					  
			  $('#hfa_use_same_file_ins').click(function(){
							  $(this).hide();
							  $('#hfa_ins_file_btn').hide();
							  $('#hfa_use_same_file_ins').hide();
							  $('#hfa_ins_file_name').show();
							  $('#hfa_ins_file_name_text_edit').show();
							  $('#hfa_ins_file_name_text').text('').hide();
							  $('#hfa_ins_file_update').val(0);
					  });
				////////PL ins files
					
			
});


function addFieldError($field)
	{
		$field.addClass('fieldError');
	}

function removeFieldError($field)
	{
		$field.removeClass('fieldError');
	}
	
function isValidEmailAddress(emailAddress) 
	{
		var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
		return pattern.test(emailAddress);
	};
	
function multipleFieldValidation(elementClass)
{
	if(elementClass=='hfa_dob_family')
		$('.hfaFamilyMember_dob_error').hide();
	var returnVal=true;
	$('.'+elementClass).each(function(){
								if($(this).is(':visible') && $(this).val()=='')
									{
										addFieldError($(this));
										returnVal=false;
									}
								else if(elementClass=='hfa_dob_family' && $(this).val()!='' && !isValidDate($(this).val()))
									{
										var DateFieldId=$(this).attr('id').split('-');
										$('#hfaFamilyMember_dob_error-'+DateFieldId[1]).show();
										addFieldError($(this));
										returnVal=false;
									}
								else	
									removeFieldError($(this));
							});
		return returnVal;					
}

function scrollToDiv(idClass)
{
	$('html, body').animate({
        scrollTop: $(idClass).offset().top
    }, 1000);
}

var notiTimeOut1, notiTimeOut2;
function successBar(text)
{
	clearTimeout(notiTimeOut1);
	clearTimeout(notiTimeOut2);
	var html='<div id="successBar" ><p><img src="'+site_url()+'static/img/success-bar-tick.png">'+text+'</p></div>';
	$('#successBar').remove();
	$('body').append(html);
	$('#successBar').show().animate({bottom:0}, 1000);
	
	notiTimeOut1=setTimeout(function(){ 	
			$('#successBar').animate({bottom:-40}, 1000, function() {}); },
		8000);
	notiTimeOut2=setTimeout(function(){ 	$('#successBar').remove(); }, 6000);
}



function errorBar(text)
{
	clearTimeout(notiTimeOut1);
	clearTimeout(notiTimeOut2);
	var html='<div id="errorBar" ><p><img src="'+site_url()+'static/img/success-bar-tick.png">'+text+'</p></div>';
	$('#errorBar').remove();
	$('body').append(html);
	
	$('#errorBar').show().animate({bottom:0}, 1000);
	
	notiTimeOut1 = setTimeout(function(){ 	
			$('#errorBar').animate({bottom:-40}, 1000, function() {}); },
		 8000);
	notiTimeOut2=setTimeout(function(){ 	$('#errorBar').remove(); }, 10000);
}


		
function checkFileSize(fsize)
		{
			var result=false;
			if(fsize!='')
			{
				var size=eval(fsize/1048576)
				if(size>2)
					result=false;
				else
					result=true;
			}
			return result;
		}	

function checkFileExt(file)
		{
				var result=false;
				//var exts = ['gif','png','jpg','jpeg'];
				var exts = ['png','jpg','jpeg','pdf','docx'];
			 
				if ( file ) {
									var get_ext = file.split('.');
									get_ext = get_ext.reverse();
										
									if ( $.inArray ( get_ext[0].toLowerCase(), exts ) > -1 )
											result=true;
									else 
											result=false;
							 }
				return result;			 
		}

function isValidDate(s) {
  var bits = s.split('/');
  var d = new Date(bits[2] + '/' + bits[1] + '/' + bits[0]);
  return !!(d && (d.getMonth() + 1) == bits[1] && d.getDate() == Number(bits[0]));
}

function isTimeValid(time)	
{
	var regexp = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;
    var correct = regexp.test(time);
	return correct;
}		