function sendEmailHalfApplicationHfaPopContent(id)
{
	$('#model_sendCompletionEmail_form').html('');
	$.ajax({
		url:site_url+'hfa/sendEmailHalfApplicationHfaPopContent/'+id,
		success:function(data)
			{
				$('#model_sendCompletionEmail_form').html(data);
			}
		});
}

function sendEmailHalfApplicationHfa()
{
	var formId="model_sendCompletionEmail_form";
	$('#'+formId).parsley().validate();
	if ($('#'+formId).parsley().isValid())
	{
		$('#sendCompletionEmailSubmit').hide();
		$('#sendCompletionEmailSubmitProcess').show();
		var formdata=$('#model_sendCompletionEmail_form').serialize();

		$.ajax({
			url:site_url+'hfa/sendEmailHalfApplication/',
			type:'POST',
			data:formdata,
			success:function(data)
				{
					notiPop("success","Email sent","Email sent to host successfully.");
					$('#sendCompletionEmailSubmit').show();
					$('#sendCompletionEmailSubmitProcess').hide();
					$('#model_sendCompletionEmail').modal('toggle');
				}
			});
	}
}

function hfaChangeStatusPopContent(id,pageStatus)
{
	$('#hfaChangeStatus_form').html('');
	$.ajax({
		url:site_url+'hfa/changeStatusPopContent/'+id+'/'+pageStatus,
		success:function(data)
			{
				$('#hfaChangeStatus_form').html(data);
			}
		});
}

function rescheduleVisitPopContent(id)
{
	$('#model_rescheduleVisit_form').html('');
	$.ajax({
		url:site_url+'hfa/rescheduleVisitPopContent/'+id,
		success:function(data)
			{
				if(data=='LO')
					redirectToLogin();
				else
					$('#model_rescheduleVisit_form').html(data);
			}
		});
}
function plreviewStatusModalInfoclick(id,plstatus)
{
	$('.pldescription').html('');
	$('#model_plinsuranceStatus_form').html('');
	if(plstatus==0){
		$('#approveHfaPlIns').show();
		$('#unapproveHfaPlIns').hide();
		$('.modal-title').text('Review PL Insurance status');
	}else if(plstatus==1){
		$('#approveHfaPlIns').hide();
		$('#unapproveHfaPlIns').show();
		$('.modal-title').text('PL Insurance status is approved');
	}
	
	$.ajax({
		url:site_url+'hfa/plreviewStatusModalInfo/'+id,
		dataType: 'json',
		success:function(data)
			{
				if(data.result=='LO')
					redirectToLogin();
				else
				{
					$('.pldescription').html(data.StatusHtml);
					$('#model_plinsuranceStatus_form').html(data.result);
				}
			}
		});
}

function approveHfaPlIns(s_url)
{	
	var formdata=$('#model_plinsuranceStatus_form').serialize();
	var hfa_id = $('input[name="hfa_id"]').val();
	
		$.ajax({
		url:site_url+'hfa/approveHfaPlIns/'+page,
		type:'POST',
		data:formdata,
		dataType: 'json',
		success:function(data)
			{
				if(data.result=='LO')
					redirectToLogin();
				else
				{
					 if(data.hasOwnProperty('appPageNotiHtml'))
					 	$( "#hfaAppPageNotiLi" ).replaceWith( data.appPageNotiHtml );
					 
					 notiPop("success","PL insurance status changed to APPROVED.",'');
					$('#mode_reviewPLIstatus').modal('toggle');
					$('#plstatusicon-'+hfa_id).attr("data-original-title", "PL Insurance status is approved");
					$('#plstatusicon-'+hfa_id).attr("src", s_url+"img/pl-approve-icon.png");
					$('#plstatusicon-'+hfa_id).parent().attr("onclick", "plreviewStatusModalInfoclick("+hfa_id+",1)");
				}
			}
		});
}
function unapproveHfaPlIns(s_url)
{	
	var formdata=$('#model_plinsuranceStatus_form').serialize();
	var hfa_id = $('input[name="hfa_id"]').val();
	$.ajax({
		url:site_url+'hfa/unapproveHfaPlIns/'+page,
		type:'POST',
		data:formdata,
		dataType: 'json',
		success:function(data)
			{
				if(data.result=='LO')
					redirectToLogin();
				else
				{
					if(data.hasOwnProperty('appPageNotiHtml'))
						$( "#hfaAppPageNotiLi" ).replaceWith( data.appPageNotiHtml );
						
					notiPop("success","PL insurance status changed to UNAPPROVED.",'');
					$('#mode_reviewPLIstatus').modal('toggle');
					$('#plstatusicon-'+hfa_id).attr("data-original-title", "Click to review PL Insurance status");
					$('#plstatusicon-'+hfa_id).attr("src", s_url+"img/pl-icon.png");
					$('#plstatusicon-'+hfa_id).parent().attr("onclick", "plreviewStatusModalInfoclick("+hfa_id+",0)");
				}
			}
		});
}

function wwreviewStatusModalInfoclick(id,wwstatus)
{
	$('#model_wwStatus_form').html('');
	if(wwstatus==0){
		$('#approveHfawwIns').show();
		$('#unapproveHfawwIns').hide();
		$('.modal-title').text('Review WWCC status');
	}else if(wwstatus==1){
		$('#approveHfawwIns').hide();
		$('#unapproveHfawwIns').show();
		$('.modal-title').text('WWCC status is approved');
	}
	
	$.ajax({
		url:site_url+'hfa/wwreviewStatusModalInfo/'+id,
		success:function(data)
			{
				if(data=='LO')
					redirectToLogin();
				else
					$('#model_wwStatus_form').html(data);
			}
		});
}

function approveHfawwIns(s_url)
{	
	var formdata=$('#model_wwStatus_form').serialize();
	var hfa_id = $('input[name="hfa_id_ww"]').val();
	$.ajax({
		url:site_url+'hfa/approveHfawwIns/'+page,
		type:'POST',
		data:formdata,
		dataType: 'json',
		success:function(data)
			{
				 if(data.result=='LO')
					redirectToLogin();
				else
				{
					if(data.hasOwnProperty('appPageNotiHtml'))
						$( "#hfaAppPageNotiLi" ).replaceWith( data.appPageNotiHtml );
					 
					notiPop("success","WWCC status changed to APPROVED.",'');
					$('#mode_reviewWWCCstatus').modal('toggle');
					$('#wwstatusicon-'+hfa_id).attr("data-original-title", "WWCC status is approved");
					$('#wwstatusicon-'+hfa_id).attr("src", s_url+"img/ww-approve-icon.png");
					$('#wwstatusicon-'+hfa_id).parent().attr("onclick", "wwreviewStatusModalInfoclick("+hfa_id+",1)");
				}
			}
		});
}
function unapproveHfawwIns(s_url)
{	
	var formdata=$('#model_wwStatus_form').serialize();
	var hfa_id = $('input[name="hfa_id_ww"]').val();
	$.ajax({
		url:site_url+'hfa/unapproveHfawwIns/'+page,
		type:'POST',
		data:formdata,
		dataType: 'json',
		success:function(data)
			{
				if(data.result=='LO')
					redirectToLogin();
				else
				{
					if(data.hasOwnProperty('appPageNotiHtml'))
						$( "#hfaAppPageNotiLi" ).replaceWith( data.appPageNotiHtml );
						
					notiPop("success","WWCC status changed to UNAPPROVED.",'');
					$('#mode_reviewWWCCstatus').modal('toggle');
					$('#wwstatusicon-'+hfa_id).attr("data-original-title", "Click to review WWCC status");
					$('#wwstatusicon-'+hfa_id).attr("src", s_url+"img/ww-icon.png");
					$('#wwstatusicon-'+hfa_id).parent().attr("onclick", "wwreviewStatusModalInfoclick("+hfa_id+",0)");
				}
			}
		});
}

function addErrorBorder(element)
{
	element.css('border-bottom','2px solid red');
}

function removeErrorBorder(element)
{
	element.css('border-bottom','');
}

function notiPop(type,title,text)
	{
		var statusChangeNotice = new PNotify({
								title:title,
								text:text,
								type:type,
								icon: 'ti ti-check',
								styling: 'fontawesome',
								delay:8000,
								buttons: {
       							closer: false,
						        sticker: false
    							}
							});

		statusChangeNotice.get().click(function() {
    							statusChangeNotice.remove();
								});
	}

function redirectToLogin()
  {
	  window.location.href=site_url+'admin';
  }



function shaChangeStatusCancelPopContent(id,pageStatus)
  {
	  $('#shaChangeStatus_form').html('');
	  $.ajax({
		  url:site_url+'sha/changeStatusCancelPopContent/'+id+'/'+pageStatus,
		  success:function(data)
			  {
				  $('#shaChangeStatus_form').html(data);
			  }
		  });
  }

function shaChangeStatusPopContent(id,pageStatus)
  {
	  $('#shaChangeStatus_form').html('');
	  $.ajax({
		  url:site_url+'sha/changeStatusPopContent/'+id+'/'+pageStatus,
		  success:function(data)
			  {
				  $('#shaChangeStatus_form').html(data);
			  }
		  });
  }



function sharedHousesChangeStatusPopContent(id,pageStatus)
  	{
	  	$('#shaChangeStatus_form').html('');
	  	$.ajax({
		  	url:site_url+'houses/changeStatusPopContent/'+id+'/'+pageStatus,
		  	success:function(data)
			{
				$('#shaChangeStatus_form').html(data);
			}	
		});
  	}




function tourChangeStatusPopContent(id,pageStatus)
{
	$('#shaChangeStatus_form').html('');
		$.ajax({
		  	url:site_url+'tour/changeStatusPopContent/'+id+'/'+pageStatus,
		  	success:function(data)
			{
				$('#model_ChangeStatusTour #shaChangeStatus_form').html(data);
				$('#study_tour_id').val(id);
			}
		});
}

function tourChangeWarningPopContent(id,pageStatus)
{
		$('#model_ChangeTourWarnings #shaChangeWarning_form').html('');
		$.ajax({
		  	url:site_url+'tour/changeWarningPopContent/'+id+'/'+pageStatus,
		  	success:function(data)
			{
				$('#model_ChangeTourWarnings #shaChangeWarning_form').html(data);
				$('#study_tour_id').val(id);
			}
		});
}

function sendEmailHalfApplicationShaPopContent(id)
{
	$('#model_sendCompletionEmail_form').html('');
	$.ajax({
		url:site_url+'sha/sendEmailHalfApplicationShaPopContent/'+id,
		success:function(data)
			{
				$('#model_sendCompletionEmail_form').html(data);
			}
		});
}

function sendEmailHalfApplicationSha()
{
	var formId="model_sendCompletionEmail_form";
	$('#'+formId).parsley().validate();
	if ($('#'+formId).parsley().isValid())
	{
		$('#sendCompletionEmailSubmit').hide();
		$('#sendCompletionEmailSubmitProcess').show();
		var formdata=$('#model_sendCompletionEmail_form').serialize();

		$.ajax({
			url:site_url+'sha/sendEmailHalfApplication/',
			type:'POST',
			data:formdata,
			success:function(data)
				{
					notiPop("success","Email sent","Email sent to student successfully.");
					$('#sendCompletionEmailSubmit').show();
					$('#sendCompletionEmailSubmitProcess').hide();
					$('#model_sendCompletionEmail').modal('toggle');
				}
			});
	}
}

function selectProfilePhotoPopContent(id,hfaSha)
{
	$('#profilePicModelForm').html('');
	$.ajax({
		url:site_url+'admin/selectProfilePhotoPopContent/'+id+'/'+hfaSha,
		success:function(data)
			{
				if(data=='LO')
					redirectToLogin();
				else
					$('#profilePicModelForm').html(data);
			}
		});
}

function scrollToDIv(divId)
{
	$('html, body').animate({
        scrollTop: $("#"+divId).offset().top-80
    }, 1000);
}

function editEmployeeForm(id)
{

	window.location.href=site_url+"account/editEmployeeForm/"+id;
	/*$('#accountPageHeading').text('Edit employee');
	$('#tab-8-4-editEmployee').html('');
	$('.col-md-3').velocity('transition.slideUpIn', {stagger: 50});
	$.ajax({
		url:site_url+'account/editEmployeeForm/'+id,
		dataType: 'json',
		success:function(data)
			{
				if(data.hasOwnProperty('logout'))
					redirectToLogin();
				else
				{
					$('#empId, #empId_empUpdateDesignationForm').val(id);
					$('#designationUpdateForm').val(data.designation);
					$('#tab-8-4-editEmployee').html(data.form).velocity('transition.slideUpIn', {stagger: 50});
				}
			}
		});*/
}

function refreshEmployeeList(data)
{
	  var empTable = $('#employeeList').DataTable();
	  $('#employeeList').html(data);
	  empTable.draw();
}

function updateClientCategory(field)
{
	var category = $('#category').parsley();
	if($('#category').val()=='')
	{
		window.ParsleyUI.addError(category,'categoryError','This field is required');
	}
	else
	{
		window.ParsleyUI.removeError(category,'categoryError');
	$.ajax({
		url:site_url+'client/updateClientCategory',
		type:'POST',
		data:$('#updateClientCategoryForm').serialize(),
		success:function(data)
			{
				if(data=='LO')
					redirectToLogin();
				else
				{
					var msg='';
					if(field=='category')
						msg='Client category updated successfully';
					if(field=='commission')
						msg='Client commission enrollment updated successfully';	
					if(field=='commission_val')
						msg='Client commission value updated successfully';
					if(field=='groupInvEnroll')
						msg='Client group invoice enrollment updated successfully';
					if(field=='groupInvEnrollAPU' || field=='groupInvEnrollPlacementFee' || field=='groupInvEnrollAccomodationFee')
						msg='Options for group invoices updated successfully';
						
					notiPop("success",msg,"");
				}
			}
		});
	}
}

function updateClientGroup()
{
	$.ajax({
		url:site_url+'client/updateClientGroup',
		type:'POST',
		data:$('#updateClientCategoryForm').serialize(),
		success:function(data)
			{
				if(data=='LO')
					redirectToLogin();
				else
					notiPop("success",'Client group updated successfully',"");
			}
		});
}

function deleteClientAgreement(id,type)
{
	
	if(type=='hfadocument'){
		var msg="Are you sure you wish to delete this document?";
		var msg1="Document deleted successfully";
		var surl=site_url+'hfa/deletehfadocument'
		var sid='clientAgreement';
	}else 	if(type=='famdocument'){
		var msg="Are you sure you wish to delete this document?";
		var msg1="Document deleted successfully";
		var surl=site_url+'hfa/deletehfafamilydocument'
			var sid='clientfamlAgreements';
	}else if(type=='shadocument'){
		var msg="Are you sure you wish to delete this document?";
		var msg1="Document deleted successfully";
		var surl=site_url+'sha/deleteshadocument'
		var sid='clientAgreement';
	
	}else{
	var msg="Are you sure you wish to delete this agreement?";
	var msg1="Client agreement deleted successfully";
	var surl=site_url+'client/deleteClientAgreement'
		var sid='clientAgreement';
	}
	
		bootbox.dialog({
				message: msg,
				title: "Delete",
				buttons: {
					  danger: {
						label: "Delete",
						className: "btn-danger",
						callback: function() {

								$.ajax({
								  url:surl,
								  type:'POST',
								  data:{id:id},
								  success:function(data)
									  {
										  if(data=='LO')
											  redirectToLogin();
										  else
										  {
											  $('#'+sid+'-'+id).remove();
											  notiPop("success",msg1,"");
											  
											  //for hfa and sha documents
											  if($('#clientAgreements div.panel-body > p').length==0)
											  	$('#clientAgreements').html('');
												
												//for hfa notes documents
												if($('#clientfaAgreementsedit div.panel-body > p').length==0)
													$('#clientfaAgreementseditParent').hide();
												//for hfa notes documents
												if($('#clientfaAgreements div.panel-body > p').length==0)
													$('#clientfaAgreementsParent').hide();	
										  }
									  }
								  });

							}
						}
					}
				});
}

function updateEmpDesignation()
{
	var designationUpdateForm = $('#designationUpdateForm').parsley();
	if($('#designationUpdateForm').val()=='')
	{
		window.ParsleyUI.addError(designationUpdateForm,'designationUpdateFormError','This field is required');
	}
	else
	{
		window.ParsleyUI.removeError(designationUpdateForm,'designationUpdateFormError');
	$.ajax({
		url:site_url+'account/updateEmpDesignation',
		type:'POST',
		data:$('#empUpdateDesignationForm').serialize(),
		success:function(data)
			{
				if(data=='LO')
					redirectToLogin();
				else
				{
					notiPop("success","Employee designation updated successfully","");
					$('#employeeDesignation-'+$('#empId_empUpdateDesignationForm').val()).text($('#designationUpdateForm option:selected').text());
				}
			}
		});
	}
}

function updateEmpOffice()
{
	var officeUpdateForm = $('#officeUpdateForm').parsley();
	if($('#officeUpdateForm').val()=='')
	{
		window.ParsleyUI.addError(officeUpdateForm,'officeUpdateFormError','This field is required');
	}
	else
	{
		window.ParsleyUI.removeError(officeUpdateForm,'officeUpdateFormError');
		updateEmpOfficeSubmit();
	}
}

function assignDiffEmpToAppSubmit($process)
{
	var valid=$('#model_assignDiffEmpToApp_form').parsley().validate();
	if(valid)
	{
		$('#deleteEditEmpProcess').show();
		$('.deleteEditEmpBtn').hide();
		$.ajax({
			url:site_url+'account/assignDiffEmpToAppSubmit',
			type:'POST',
			data:$('#model_assignDiffEmpToApp_form').serialize(),
			success:function(data)
				{
					if($process=='updateEmpOffice')
						updateEmpOfficeSubmit();
					else
						deleteEmployee($process)
				}
		});
	}
}

function updateEmpOfficeSubmit()
{
	$.ajax({
		url:site_url+'account/updateEmpOffice',
		type:'POST',
		data:$('#empUpdateDesignationForm').serialize(),
		success:function(data)
			{
				$('#deleteEditEmpProcess').hide();
				$('#model_assignDiffEmpToApp').modal('hide');
				$('.deleteEditEmpBtn').show();
				notiPop("success","Employee office updated successfully","");
			}
	});
}

function officeUseChangeAttrFormSubmit()
{
	var valid=$('#officeUseChangeAttrForm').parsley().validate();
	if(valid && $('#officeUse-changeEmployee').val()!='')
	{
		var formdata=$('#officeUseChangeAttrForm').serialize();

		$.ajax({
				url:site_url+'sha/officeUseChangeAttrFormSubmit',
				type:'POST',
				data:formdata,
				success:function(data)
					{
						if(data=='LO')
						  redirectToLogin();
						else
						 notiPop('success','Employee assigned to student',"")
					}
			});
	}
}

function officeUseChangeAttrFormSubmit_changeClient()
{
	if($('#officeUse-changeClient').val()!='')
	{
		var formdata=$('#officeUseChangeAttrForm').serialize();

		$.ajax({
				url:site_url+'sha/officeUseChangeAttrFormSubmit_changeClient',
				type:'POST',
				data:formdata,
				success:function(data)
					{
						if(data=='LO')
						  redirectToLogin();
						else
						 notiPop('success','Client assigned to student',"")
					}
			});
			
			$('#clientDetailsDiv').html('');
			$.ajax({
				url:site_url+'sha/getClientsDetailsDiv/',
				type:'POST',
				data:formdata,
				success:function(data)	
				{
					if(data=='LO')
						  redirectToLogin();
					else
						$('#clientDetailsDiv').html(data);
				}
		});
		
	}
	else
	{
		$('#officeUseChangeAttrForm')[0].reset();
	}
}

function deleteEmployee(id)
{
	  $.ajax({
		url:site_url+'account/deleteEmployee',
		type:'post',
		data:{id:id},
		success:function(data){
				  $('#deleteEditEmpProcess').hide();
				  $('#model_assignDiffEmpToApp').modal('hide');
				  $('.deleteEditEmpBtn').show();
				  notiPop('success','Employee deleted successfully',"");
				  refreshEmployeeList(data);
			  }
		});
}

function filterMatchesFormSubmit(form)
{
	//$('#filtersLoadingDiv').show();
	//$('#infoSidebar').hide();
	if(form=='#filterMatchesForm2')
			Utility.toggle_rightbar();
			
	$.ajax({
						url:site_url+'sha_matches',
						type:'POST',
						data:$(form).serialize(),
						success:function(data)
							{

								$('#filtersLoadingDiv').hide();
								$('#infoSidebar').show();

								if(data=='LO')
									redirectToLogin();
								else
									{
										/*if(form=='#filterMatchesForm2')
											Utility.toggle_rightbar();*/

											//##//
											
											if($('#hostName2').length>0)
											{
												if($('#hostName2').is(':checked'))
													$('#hostName').val(1);
												else
													$('#hostName').val(0);

												$('#filterMatchesEditFname').val($('#filterMatchesEditFname2').val());
												$('#filterMatchesEditLname').val($('#filterMatchesEditLname2').val());
												
												$('#hostNameSearchAll').val($('input[name=hostNameSearchAll]:checked').val());
											}
											
											if($('#suburb2').length>0)
											{
												if($('#suburb2').is(':checked'))
													$('#suburb').val(1);
												else
													$('#suburb').val(0);

												$('#filterMatchesEditSuburb').val($('#filterMatchesEditSuburb2').val());
												$('#filterMatchesEditSuburbId').val($('#filterMatchesEditSuburbId2').val());
											}
											

											if($('#filterMatchesEditAccomodation_type2').length>0)
											{
												if($('#accomodation_type2').is(':checked'))
													$('#accomodation_type').val(1);
												else
													$('#accomodation_type').val(0);

												$('#filterMatchesEditAccomodation_type').val($('#filterMatchesEditAccomodation_type2').val());

												var filterMatchesEditAccomodation_typeRoomType2='';
												$("input[name='filterMatchesEditAccomodation_typeRoomType2[]']:checked").each( function () {
													filterMatchesEditAccomodation_typeRoomType2 +=' '+$(this).val();
												});

												filterMatchesEditAccomodation_typeRoomType2=filterMatchesEditAccomodation_typeRoomType2.trim().replace(/ /g , ',');

												$('#filterMatchesEditAccomodation_typeRoomType').val(filterMatchesEditAccomodation_typeRoomType2);
												
												$('#filterMatchesEditAccomodation_typeGrannyFlat').val($('input[name=filterMatchesEditAccomodation_typeGrannyFlat2]:checked').val());
											}

											if($('#arrival_date2').length>0)
											{
												if($('#arrival_date2').is(':checked'))
													$('#arrival_date').val(1);
												else
													$('#arrival_date').val(0);

												$('#filterMatchesEditArrivalDate').val($('#filterMatchesEditArrivalDate2').val());
											}

											if($('#pets2').length>0)
											{
												if($('#pets2').is(':checked'))
													$('#pets').val(1);
												else
													$('#pets').val(0);

												if($('#pets2').is(':checked'))
												{
													$('#filterMatchesEditPets').val($('#filterMatchesEditPets2').val());
													
													////
													var filterMatchesEditPetsType='';
													$("input[name='filterMatchesEditPetsType[]']:checked").each( function () {
														filterMatchesEditPetsType +=' '+$(this).val();
													});
	
													filterMatchesEditPetsType=filterMatchesEditPetsType.trim().replace(/ /g , ',');
													$('#filterMatchesEditPetsType').val(filterMatchesEditPetsType);
													$('#filterMatchesEditPetsInside').val($('#filterMatchesEditPetsInside2').val());
													////
												}
												
												
											}

											if($('#child2').length>0)
											{
												if($('#child2').is(':checked'))
													$('#child').val(1);
												else
													$('#child').val(0);

												$('#filterMatchesEditChild11').val($('#filterMatchesEditChild112').val());
												$('#filterMatchesEditChild20').val($('#filterMatchesEditChild202').val());
											}

											if($('#age2').length>0)
											{
												if($('#age2').is(':checked'))
													$('#age').val(1);
												else
													$('#age').val(0);
											}

											if($('#wwcc2').length>0)
											{
												if($('#wwcc2').is(':checked'))
													$('#wwcc').val(1);
												else
													$('#wwcc').val(0);
													
												if($('#filterMatchesEditWWCC_expired2').is(':checked'))
													$('#filterMatchesEditWWCC_expired').val(1);
												else
													$('#filterMatchesEditWWCC_expired').val(0);

												if($('#filterMatchesEditWWCC_clearence2').is(':checked'))
													$('#filterMatchesEditWWCC_clearence').val(1);
												else
													$('#filterMatchesEditWWCC_clearence').val(0);
													
												if($('#filterMatchesEditWWCC_oneMember2').is(':checked'))
													$('#filterMatchesEditWWCC_oneMember').val(1);
												else
													$('#filterMatchesEditWWCC_oneMember').val(0);																								
											}
											if($('#state2').length>0)
											{
												if($('#state2').is(':checked'))
													$('#state').val(1);
												else
													$('#state').val(0);
												var filterMatchesEditState='';
												$("input[name='filterMatchesEditState[]']:checked").each( function () {
													filterMatchesEditState +=' '+$(this).val();
												});

												filterMatchesEditState=filterMatchesEditState.trim().replace(/ /g , ',');

												$('#filterMatchesEditState').val(filterMatchesEditState);
											}
											
											if($('#cApproval2').length>0)
											{
												if($('#cApproval2').is(':checked'))
													$('#cApproval').val(1);
												else
													$('#cApproval').val(0);
												var filterMatchesEditCApproval='';
												$("input[name='filterMatchesEditCApproval[]']:checked").each( function () {
													filterMatchesEditCApproval +=' '+$(this).val();
												});

												filterMatchesEditCApproval=filterMatchesEditCApproval.trim().replace(/ /g , ',');

												$('#filterMatchesEditCApproval').val(filterMatchesEditCApproval);
											}
											
											if($('#gender2').length>0)
											{
												if($('#gender2').is(':checked'))
													$('#gender').val(1);
												else
													$('#gender').val(0);
											}

											if($('#smoker2').length>0)
											{
												if($('#smoker2').is(':checked'))
													$('#smoker').val(1);
												else
													$('#smoker').val(0);

												$('#filterMatchesEditSmoker').val($('#filterMatchesEditSmoker2').val());
											}

											if($('#smokerFamily2').length>0)
											{
												if($('#smokerFamily2').is(':checked'))
													$('#smokerFamily').val(1);
												else
													$('#smokerFamily').val(0);

												$('#filterMatchesEditSmokerFamily').val($('#filterMatchesEditSmokerFamily2').val());
											}

											if($('#dietReq2').length>0)
											{
												if($('#dietReq2').is(':checked'))
													$('#dietReq').val(1);
												else
													$('#dietReq').val(0);

												$('#filterMatchesEditDietReq').val($('#filterMatchesEditDietReq2').val());
											}

											if($('#allergy2').length>0)
											{
												if($('#allergy2').is(':checked'))
													$('#allergy').val(1);
												else
													$('#allergy').val(0);

												$('#filterMatchesEditAllergy').val($('#filterMatchesEditAllergy2').val());
											}

											if($('#disability2').length>0)
											{
												if($('#disability2').is(':checked'))
													$('#disability').val(1);
												else
													$('#disability').val(0);

												$('#filterMatchesEditDisability').val($('#filterMatchesEditDisability2').val());
											}

											if($('#religion2').length>0)
											{
												if($('#religion2').is(':checked'))
													$('#religion').val(1);
												else
													$('#religion').val(0);

												$('#filterMatchesEditReligion').val($('#filterMatchesEditReligion2').val());
											}
											
											if($('#language2').length>0)
											{
												if($('#language2').is(':checked'))
													$('#language').val(1);
												else
													$('#language').val(0);

												$('#filterMatchesEditLanguage').val($('#filterMatchesEditLanguage2').val());
											}
											//##//

												  $('.col-md-12').show();
												  $('#tab-8-5 .panel-body').html('');
												  $('#tab-8-5 .panel-footer').html('');
												  $('#tab-8-5 .panel-body').html(data);

													  /*Data tables #STARTS*/
													   var oTable = $('#hostMatchList').dataTable({
													  "language": {
														  "lengthMenu": "_MENU_",
													  },
						                              "sPaginationType": "full_numbers_no_ellipses",
													  "oLanguage": {
        "sEmptyTable":     "My Custom Message On Empty Table"
    },
													  "drawCallback": function( settings ) {
															  $('.tooltips, [data-toggle="tooltip"]').tooltip()
													  },
													   "ajax": {
													  "url":site_url+"sha_matches/ajax_list",
													  "type": "POST",
													  "data":function ( d )
																	{
																		d.hostName=$('#hostName').val();
																		d.filterMatchesEditFname=$('#filterMatchesEditFname').val();
																		d.filterMatchesEditLname=$('#filterMatchesEditLname').val();
																		d.hostNameSearchAll=$('#hostNameSearchAll').val();
																		d.suburb=$('#suburb').val();
																		d.filterMatchesEditSuburb=$('#filterMatchesEditSuburb').val();
																		d.filterMatchesEditSuburbId=$('#filterMatchesEditSuburbId').val();
																		d.arrival_date=$('#arrival_date').val();
																		d.filterMatchesEditArrivalDate=$('#filterMatchesEditArrivalDate').val();
																		d.pets=$('#pets').val();
																		d.petsType=$('#filterMatchesEditPetsType').val();
																		d.petsLiveInside=$('#filterMatchesEditPetsInside').val();
																		d.filterMatchesEditPets=$('#filterMatchesEditPets').val();
																		d.child=$('#child').val();
																		d.filterMatchesEditChild11=$('#filterMatchesEditChild11').val();
																		d.filterMatchesEditChild20=$('#filterMatchesEditChild20').val();
																		d.age=$('#age').val();
																		d.wwcc=$('#wwcc').val();
																		d.state=$('#state').val();
																		d.cApproval=$('#cApproval').val();
																		d.filterMatchesEditWWCC_expired=$('#filterMatchesEditWWCC_expired').val();
																		d.filterMatchesEditWWCC_clearence=$('#filterMatchesEditWWCC_clearence').val();
																		d.filterMatchesEditWWCC_oneMember=$('#filterMatchesEditWWCC_oneMember').val();
																		d.gender=$('#gender').val();
																		d.smoker=$('#smoker').val();
																		d.filterMatchesEditSmoker=$('#filterMatchesEditSmoker').val();
																		d.smokerFamily=$('#smokerFamily').val();
																		d.filterMatchesEditSmokerFamily=$('#filterMatchesEditSmokerFamily').val();
																		d.deitReq=$('#dietReq').val();
																		d.filterMatchesEditDeitReq=$('#filterMatchesEditDietReq').val();
																		d.allergy=$('#allergy').val();
																		d.filterMatchesEditAllergy=$('#filterMatchesEditAllergy').val();
																		d.disability=$('#disability').val();
																		d.filterMatchesEditDisability=$('#filterMatchesEditDisability').val();
																		d.religion=$('#religion').val();
																		d.filterMatchesEditReligion=$('#filterMatchesEditReligion').val();
																		d.language=$('#language').val();
																		d.filterMatchesEditLanguage=$('#filterMatchesEditLanguage').val();
																		d.filterMatchesStatus=$('#filterMatchesStatus').val();

																		d.accomodation_type=$('#accomodation_type').val();
																		d.filterMatchesEditAccomodation_type=$('#filterMatchesEditAccomodation_type').val();
																		d.filterMatchesEditAccomodation_typeRoomType=$('#filterMatchesEditAccomodation_typeRoomType').val();
																		d.filterMatchesEditState=$('#filterMatchesEditState').val();
																		d.filterMatchesEditCApproval=$('#filterMatchesEditCApproval').val();
																		d.filterMatchesEditAccomodation_typeGrannyFlat=$('#filterMatchesEditAccomodation_typeGrannyFlat').val();
																		d.id=$(form+" input[name=id]").val();
																	}
													  },
													  "language": {
    "infoFiltered": '',
  },
													"searching": false,
													"processing": true,
													"serverSide": true,
													  "order": [],
													  "columnDefs": [
														  {"targets": [-1,-2],"orderable": false}
														   ],
														   "pageLength": 50,
														   "bLengthChange": false,
														   initComplete : function()
															  {
																  $('.dataTables_filter').css('width',0).hide();
															  }
												  });

											  	  //DOM Manipulation to move datatable elements integrate to panel
												  $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
												  $('#tab-8-5 .panel-footer').append($(".dataTable+.row"));
												  $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
											//$("#bookingHistoryList_paginate").hide();
											//$("#paymentHistoryList_paginate").hide();
										//	$("#bookingHistoryList_info").hide();
										//	$("#paymentHistoryList_info").hide();
												  /*Data tables #ENDS*/

									}
							}
			});
}

function hfaChangeStatusSubmitUnavail()
{
	var id=$('#hfaChangeStatus_id').val();
	var statusText=$('#hfaChangeStatus_status option:selected').text();
	var dateFrom=$('#hfaChangeStatus_unavailableDateFrom').val().trim();
	var dateTo=$('#hfaChangeStatus_unavailableDateTo').val().trim();

	var dateFromValid= $('#hfaChangeStatus_unavailableDateFrom').parsley();
	var  dateToValid= $('#hfaChangeStatus_unavailableDateTo').parsley();

	window.ParsleyUI.removeError(dateFromValid,'dateFromValidError');
	window.ParsleyUI.removeError(dateToValid,'dateToValidError');

	if(dateFrom=='' || dateTo=='')
	{
		if(dateFrom=='')
			window.ParsleyUI.addError(dateFromValid,'dateFromValidError','This is required');
		if(dateTo=='')
			window.ParsleyUI.addError(dateToValid,'dateToValidError','This is required');
	}
	else
	{
		var formdata=$('#hfaChangeStatus_form').serialize();
		$('#hfaChangeStatusSubmit').hide();
		$('#hfaChangeStatusProcess').show();
		$.ajax({
					  url:site_url+'hfa/changeStatusUnavailable',
					  type:'post',
					  data:formdata,
					  success:function(data)
					  	{
							$('#hfaChangeStatusProcess').hide();
							$('#hfaChangeStatusSubmit').show();

							if(data=='LO')
								redirectToLogin();
							else
								  {
									  $('#model_rescheduleVisit_form').html(data);
									  if(data=='invalid')
										  {}
									  else if(data=='opposite' || data=='same')
										  window.ParsleyUI.addError(dateToValid,'dateToValidError','To date should be greater than from date');
									  else if(data=='today')
									  {
										  $('#model_ChangeStatusHfa').modal('toggle');
										  notiPop('success','Status changed',"Status changed to <b>"+statusText+"</b> successfully.");
										  var hfaTable = $('#hfaList').DataTable();
								  		 hfaTable.row($('#hfaApplication-'+id)).remove().draw();
									  }
									  else
									  {
										  $('#model_ChangeStatusHfa').modal('toggle');
									  	  dataSplit=data.split('-');
										  if(dataSplit[0]=='future')
										  {
											  notiPop('success','Success',"Application will move to unavailable on <b>"+dataSplit[1]+"</b>.");
											  window.location.reload();
										  }
									  }
								  }
						}
			});
	}
}


function changeUnavailableToDatePopContent(id)
{
	$('#model_changeUnavailableToDate_form').html('');
	$('#changeUnavailableToDateProcess').hide();
	$.ajax({
		url:site_url+'hfa/changeUnavailableToDatePopContent/'+id,
		success:function(data)
			{
				if(data=='LO')
					redirectToLogin();
				else
					$('#model_changeUnavailableToDate_form').html(data);
			}
		});
}

function clientProductsList(client_id,year)
{
	if(client_id!='default')
		scrollToDIv('layout-static');
	$('.about-area .panel-body, .about-area .panel-footer').html('').hide();
	$('.productClient').removeClass('productClient-selected');
	$('#productClient-'+client_id).addClass('productClient-selected');
	$('#clientProductList_processing').show();

	$('#addDefaultProduct').hide();
	$('#addGuardianshipProduct').hide();

	$.ajax({
		url:site_url+'product/clientProductsList/'+client_id+'/'+year,
		success:function(data)
			{
				if(data=='LO')
					redirectToLogin();
				else
				{
					$('#clientProductList_processing').hide();
					$('.about-area .panel-body, .about-area .panel-footer').show();
					$('.about-area .panel-body').html(data);

					/*Data tables #STARTS*/
						   var oTable = $('#clientProductList').dataTable({
						  "language": {
							  "lengthMenu": "_MENU_"
						  },
						  "sPaginationType": "full_numbers_no_ellipses",
						  /*"order": [],*/
						  "drawCallback": function( settings ) {
								  $('.tooltips, [data-toggle="tooltip"]').tooltip()
						  },
						  "language": {
						 "infoFiltered": '',
							},
						"searching": false,
						"columnDefs": [
							 {"targets": [-1],"orderable": false}
							   ],
							   "pageLength": 50,
							   "bLengthChange": false,
							   initComplete : function()
								  {
									  $('.dataTables_filter').css('width',0).hide();
								  }
					  });

					  //DOM Manipulation to move datatable elements integrate to panel
					  $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
					  $('.panel-footer').append($(".dataTable+.row"));
					  $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");

					  /*Data tables #ENDS*/

					if(client_id=='default')
						$('#addDefaultProduct').show();
				}
			}
	});
}


function addNewDefaultProductSubmit()
{
	$('#addNewDefaultProductForm').parsley().validate();
	if ($('#addNewDefaultProductForm').parsley().isValid())
	{
		$('#addNewDefaultProductSubmitProcess').show();
		$('#addNewDefaultProductSubmitBtn').hide();

		$.ajax({
			url:site_url+'product/addNewDefaultProductSubmit/',
			type:'POST',
			data:$('#addNewDefaultProductForm').serialize(),
			success:function(data){
				if(data=='LO')
						redirectToLogin();
				else
					{
						$('.panel-footer').html('');
						$('#productList').replaceWith(data);
						productListDatatable();
						$('.productClient-selected').trigger('click');
						$('#addNewDefaultProductForm')[0].reset();

						$('#model_AddNewProduct').modal('toggle');
						$('#addNewDefaultProductSubmitProcess').hide();
						$('#addNewDefaultProductSubmitBtn').show();
						notiPop('success','Product added',"New default product added successfully");
					}
			}
		});
	}
}

function editProductSubmit()
{
	$('#editProductForm').parsley().validate();
	if ($('#editProductForm').parsley().isValid())
	{
		$('#filtersLoadingDiv').show();
		$('#infoSidebar').hide();

		$.ajax({
			url:site_url+'product/editProductSubmit/',
			type:'POST',
			data:$('#editProductForm').serialize(),
			success:function(data){
				if(data=='LO')
						redirectToLogin();
				else
					{
							Utility.toggle_rightbar();
							$('#filtersLoadingDiv').hide();
							$('.productClient-selected').trigger('click');

							/*if(data!='')
							{
								$('.panel-footer').html('');
								$('#productList').replaceWith(data);
								productListDatatable();
							}*/
							notiPop('success','Product edited successfully',"");
					}
			}
		});
	}
}

function productListDatatable()
{
				 var oTableGuardian = $('#productList').dataTable({
				  "language": {
					  "lengthMenu": "_MENU_"
				  },
				  "drawCallback": function( settings ) {
						  $('.tooltips, [data-toggle="tooltip"]').tooltip()
				  },
				  "sPaginationType": "full_numbers_no_ellipses",
				  "order": [],
				  "columnDefs": [
					  { "width": "100px", "targets": [-1] },
					  {"targets": [-1],"orderable": false}
					   ],
					   "pageLength": 50,
					   "bLengthChange": false,
					   initComplete : function()
						  {}
			  });

	  /*Data tables #ENDS*/
}

function addProductToClientSubmit()
{
	$('#addProductToClientForm').parsley().validate();
	if ($('#addProductToClientForm').parsley().isValid())
	{
		$('#filtersLoadingDiv').show();
		$('#infoSidebar').hide();

		var productClient=$('input[name=productClient]:checked').val();

		$.ajax({
			url:site_url+'product/addProductToClientSubmit/',
			type:'POST',
			data:$('#addProductToClientForm').serialize(),
			success:function(data){
				if(data=='LO')
						redirectToLogin();
				else
					{
							Utility.toggle_rightbar();
							$('#filtersLoadingDiv').hide();
							$('.productClient-selected').trigger('click');
							if(productClient==0)
								notiPop('success','Product applied to all clients',"");
							else
								notiPop('success','Product applied to selected clients',"");
					}
			}
		});
	}
}


function checkFileExtension(file,exts)
		{
				var result=false;
				//var exts = ['gif','png','jpg','jpeg'];
				//var exts = ['png','jpg','jpeg'];

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



function matchedAppPlaceBookingPopContent(host,student)
{
	$('#matchedAppPlaceBooking_form').html('');
	$.ajax({
		url:site_url+'booking/matchedAppPlaceBookingPopContent/'+host+'/'+student,
		type:'POST',
		data:$('#filterMatchesForm').serialize(),
		success:function(data)
			{
				$('#matchedAppPlaceBooking_form').html(data);
			}
		});
}

function matchedAppPlaceBookingPopContentCH(host,student)
{
	$('#matchedAppPlaceBooking_form').html('');
	$('#matchedAppPlaceBookingSubmitCH').show();
	$('#matchedAppPlaceBookingProcess').hide();
	
	$('#matchedAppPlaceBooking_form, #model_PlaceBookingMatchedApp .modal-footer').show();
	$('#CHB_alerts').hide();
	
	$('#errorsCH').hide().text('');	
									
	$.ajax({
		url:site_url+'booking/matchedAppPlaceBookingPopContentCH/'+host+'/'+student,
		type:'POST',
		data:$('#filterMatchesForm').serialize(),
		success:function(data)
			{
				$('#matchedAppPlaceBooking_form').html(data);
			}
		});
}

function editBookingPopContent(id)
{
	$('#editBooking_form').html('');
	$('#editBooking_form_msgs > p').text('').hide();
	$('#model_editBooking_first').show();
	$('#model_editBooking_second').hide();
	
	$.ajax({
		url:site_url+'booking/eidtBookingPopContent/'+id,
		dataType:'json',
		success:function(data)
			{
				$('#editBooking_form').html(data.first);
				$('#editBooking_form_second').html(data.second);
				$('#editBookingEndDateBtn').attr('onclick','bookingEndDateHistory('+id+')');
			}
		});
}

function matchedAppShorlist(thisObj,student, host)
{
	var ch='Shortlist';
	if(thisObj.hasClass('matchStatusGrey'))
		ch='Shortlisted';
	thisObj.toggleClass('matchStatusGrey').toggleClass('matchStatusGreen').attr('data-original-title',ch);
	thisObj.siblings('.fa').removeClass('matchStatusRed').addClass('matchStatusGrey').attr('data-original-title','Reject');

	var status=2;
	if(thisObj.hasClass('matchStatusGrey'))
		status=1;
	matchedAppChangeStatusSubmit(student, host,status);
}
function hostfamilybookmark(thisObj, host)
{
	//var msg=Family bookmarked successfully";
	var boo='Click to bookmark';
	if(thisObj.hasClass('matchStatusGrey'))
		boo='Click to unmark';
	 //msg=Family unmarked successfully";
	thisObj.toggleClass('matchStatusGrey').toggleClass('matchStatusGreen').attr('data-original-title',boo);
	//thisObj.toggleClass('matchStatusGreen').toggleClass('matchStatusGrey').attr('data-original-title','Click to bookmark');
	

	var status=1;
	if(thisObj.hasClass('matchStatusGrey'))
		status=0;
	bookmarkstatuschangesubmit(host,status);
}
function matchedAppReject(thisObj,student, host)
{
	var rea='Reject';
	if(thisObj.hasClass('matchStatusGrey'))
		rea='Rejected';
	thisObj.toggleClass('matchStatusGrey').toggleClass('matchStatusRed').attr('data-original-title',rea);
	thisObj.siblings('.fa').removeClass('matchStatusGreen').addClass('matchStatusGrey').attr('data-original-title','Shortlist');

	var status=3;
	if(thisObj.hasClass('matchStatusGrey'))
		status=1;
	matchedAppChangeStatusSubmit(student, host,status);
}


function matchedAppChangeStatusSubmit(student, host,status)
{
	$.ajax({
		url:site_url+'sha_matches/matchedAppChangeStatus/',
		type:'POST',
		data:{student:student, host:host, status:status},
		success:function(data)
			{
				
			}
	});
}
function bookmarkstatuschangesubmit(host,status)
{
	$.ajax({
		url:site_url+'hfa/bookmarkstatuschangesubmit/',
		type:'POST',
		data:{ host:host, status:status},
		success:function(data)
			{
				if(status==1)
					notiPop("success","Family bookmarked successfully","");
				else
					notiPop("success","Family unmarked successfully","");
			}
	});
}

function filterMatchesStatusSubmit(thisObj,status)
{
	$('#filterMatchesStatus').val(status);
	filterMatchesFormSubmit('#filterMatchesForm');
	$('#filterMatchesStatusBtnDiv li a').removeClass('selected');
	thisObj.addClass('selected');
}
function filterMatchesglobalsearch(thisObj,type)
{
	//console.log(thisObj);
	//$('#globalsearchmenu li a').removeClass('selected');
	//thisObj.addClass('selected');
	var sval=$("#search-input").val();
	$.ajax({
		url:site_url+'booking/globalsearch',
		type:'POST',
		async: false,
		dataType: "json",
			data:{'type':type,'val':sval},
		success:function(data)
			{
				window.open(site_url+data.type+"?type=global&"+data.meth);
				//if(data.type=='booking'){
				//	window.location.href=site_url+data.type+"?type=global&"+data.meth
			//	}else if(data.type=='hfa'){
					
					
			//	}
					
			//	alert(str.replace(/\s/g, ''));
				//alert(data.meth);
			}
		});
	//window.location.href="http://www.gediculture.com/ge/booking?booking_id=80";
	//console.log(thisObj);
	//alert(type);
}

function bookingChangeStatusPopContent(id,pageStatus)
{
	$('#bookingChangeStatus_form').html('');
	$('#bookingChangeStatusSubmit, #ChangeStatusPopContentDiv, #bookingChangeStatus_statusTitle').show();
	$('#bookingChangeStatusNext, #checkupPopContentDiv, #bookingChangeStatus_arrivalTitle, #bookingChangeStatusBack').hide();
	$.ajax({
		url:site_url+'booking/changeStatusPopContent/'+id+'/'+pageStatus,
		success:function(data)
			{
				$('#bookingChangeStatus_form').html(data);
			}
		});
}




function updateShaBookingDates(fromTo)
{
	var fromDateField = $('input#shaBooking_startDate').parsley();
	window.ParsleyUI.removeError(fromDateField,'fromDateFieldError');
		
	if((fromTo=='week' || fromTo=='day' || fromTo=='from') && $("#shaBooking_startDate").val()!='')
	{
		var w =$("#shaBooking_week").val();
		var d =$("#shaBooking_day").val();
		if(d=='')
		{
	 		d=0;
	 		$("#shaBooking_day").val(0);
		}
		if(w=='')
		{
			$("#shaBooking_week").val(0);
	 		w=0;
		}
		/*if(w==0 && d==0)
		{
			$("#shaBooking_day").val(1);
			d=1;
		}*/

		var weekday=parseInt(7*w)+parseInt(d);
		//console.log(parseInt(d));
		if(weekday!=0)
		{
			var  bto=$("#shaBooking_startDate").val();
			var tt = bto.replace(/^(\d{1,2}\/)(\d{1,2}\/)(\d{4})$/,"$2$1$3");
			  
			var someDate = new Date(tt);
	
			someDate.setDate(someDate.getDate() + weekday);
			
			console.log(someDate.toLocaleDateString('en-GB'));
	
			//$("#shaBooking_endDate").val(someDate.toLocaleDateString('en-GB'));
			$("#shaBooking_endDate").datepicker("setDate",someDate.toLocaleDateString('en-GB'));
			var shaBooking_endDate = $('#shaBooking_endDate').parsley();
			window.ParsleyUI.removeError(shaBooking_endDate,'shaBooking_endDateError');
		}
		else
			$("#shaBooking_endDate").datepicker("setDate",'');
	}
		
		
		
	if((/*fromTo=='from' ||*/ fromTo=='to') && ($("#shaBooking_startDate").val()!='' && $("#shaBooking_endDate").val()!=''))
	{
		var bfrom=$("#shaBooking_startDate").val();
		var  bto=$("#shaBooking_endDate").val();
		
		var fromdate = bfrom.replace(/^(\d{1,2}\/)(\d{1,2}\/)(\d{4})$/,"$2$1$3");
		var todate = bto.replace(/^(\d{1,2}\/)(\d{1,2}\/)(\d{4})$/,"$2$1$3");
		
		var date1 = new Date(fromdate);
		var date2 = new Date(todate);
		var timeDiff = Math.abs(date2.getTime() - date1.getTime());
		//alert(timeDiff);
		if(date2.getTime() - date1.getTime()>0)
			{
				var weekDays = Math.floor(timeDiff / (1000 * 3600 * 24*7));
			
				var tweek=weekDays * 7;
				var Days = Math.ceil(timeDiff / (1000 * 3600 * 24));
				var remaningdays=Days - tweek;
		
				if(isNaN(weekDays))
					$("#shaBooking_week").val(0);
				else
					$("#shaBooking_week").val(weekDays);
				
				if(isNaN(remaningdays))
					$("#shaBooking_day").val(0);
				else
					$("#shaBooking_day").val(remaningdays);
			}
		var shaBooking_endDate = $('#shaBooking_endDate').parsley();
		window.ParsleyUI.removeError(shaBooking_endDate,'shaBooking_endDateError');
	}
		
		var formId="updateShaBookingDatesForm";
		var formdata=$('#'+formId).serialize();
		
		if(fromTo=='from' && $("#shaBooking_startDate").val()=='')
			$('#shaBooking_endDate').val('');
		
		if(fromTo=='to' && $("#shaBooking_endDate").val()=='')
		{
			$("#shaBooking_week").val(0);
			$("#shaBooking_day").val(0);
		}
		
		if(fromTo=='to' && $("#shaBooking_startDate").val()=='')
			window.ParsleyUI.addError(fromDateField, "fromDateFieldError", 'Please fill Booking from date first');
		else
		{
			$.ajax({
				url:site_url+'sha/bookingDatesSubmit/',
				type:'POST',
				data:formdata,
				success:function(data)
					{
						if(data=='wrongDates')
						{
							window.ParsleyUI.addError(shaBooking_endDate,'shaBooking_endDateError','To date should be greater than From date');
							notiPop("error","To date should be greater than From date","");
						}
						else
							notiPop("success","Booking date updated","");
					}
				});
		}
}

function updateClientProductsBookingPop(client)
{
	$('#clientProductsBookingPop').html('<p>Refreshing product list</p>');
	$('#matchedAppPlaceBookingSubmit').hide();
	$.ajax({
			url:site_url+'booking/updateClientProductsBookingPop/'+client,
			success:function(data)
				{
					$('#clientProductsBookingPop').html(data);
					$('#matchedAppPlaceBookingSubmit').show();
				}
			});
}

function selectRoomTypeByAccomodationType(accType)
{
	$.ajax({
			url:site_url+'sha_matches/selectRoomTypeByAccomodationType/'+accType,
			dataType: "json",
			success:function(data)
				{
					var roomTypeData=data.checkboxes;
					var roomType=roomTypeData.split(',');
					$("input[name='filterMatchesEditAccomodation_typeRoomType2[]']").each( function () {
									if($.inArray( $(this).val(), roomType )>=0)
										$(this).prop('checked',true);
									else
										$(this).prop('checked',false);
								});

					if(accType=='')
						$('#accomodation_typeRoomTypeDesc, .filterMatchesEdit-accomodation_typeRoomType').hide();
					else
					{
						$('#accomodation_typeRoomTypeDescSpan').text(data.desc);
						$('#accomodation_typeRoomTypeDesc').show();
					}
				}
			});
}

function changeDescByRoomTypeFilterMatches()
{
	var accType=$('#filterMatchesEditAccomodation_type2').val();
	var roomType='';
	$("input[name='filterMatchesEditAccomodation_typeRoomType2[]']:checked").each( function () {
		roomType +=' '+$(this).val();
	});
	roomType=roomType.trim().replace(/ /g , ',');

	$.ajax({
			url:site_url+'sha_matches/changeDescByRoomTypeFilterMatches',
			type:'POST',
			data:{accType:accType,roomType:roomType},
			success:function(data)
				{
					if(data=='')
						$('#accomodation_typeRoomTypeDesc').hide();
					else
					{
						$('#accomodation_typeRoomTypeDescSpan').text(data);
						$('#accomodation_typeRoomTypeDesc').show();
					}
				}
			});
}



function editInvoiceDataPopContent(id)
  {
	  $('#editInvoiceData_form').html('');
	  $.ajax({
		  url:site_url+'invoice/editInvoiceDataPopContent/'+id,
		  success:function(data)
			  {
				  if(data!='')
				  	$('#editInvoiceData_form').html(data);
				else
					$('#model_editInvoiceData').modal('toggle');
			  }
		  });
  }


  function addNewInitialInvoiceItemPopContent(id,invoiceType)
  {
	  $('#addNewInitialInvoiceItemProcess').hide();
	  $('#addNewInitialInvoiceItemSubmit').show();
	  
	  var url=site_url;
	  if(invoiceType=='po')
		  url +='purchase_orders/addNewItemPopContent/'+id;
	  else	  
		  url +='invoice/addNewInitialInvoiceItemPopContent/'+id+"/"+invoiceType;
	  
	  $('#addNewInitialInvoiceItem_form').html('');
	  $.ajax({
		  url:url,
		  success:function(data)
			  {
				  if(data!='')
				  	$('#addNewInitialInvoiceItem_form').html(data);
				else
					$('#model_addNewInitialInvoiceItem').modal('toggle');
			  }
		  });
  }


	function checkInitialInvoiceStatus(invoiceNumber)
	{
		var checkBtn=$('#checkInitialInvoiceStatusBtn');
		var checkBtnProcess=$('#checkInitialInvoiceStatusProcess');

		checkBtn.hide();
		checkBtnProcess.show();

		$.ajax({
				url:site_url+'xero_api/checkInitialInvoiceStatus',
				type:'POST',
				data:{invoiceNumber:invoiceNumber},
				success:function(data)
					{
						if(data=='LO')
							redirectToLogin();
					   else
						{
							if(data=='newPayment')
							{
								alert('Payment received');
								window.location.reload();
							}
							else if(data=='noNewPayment')
								alert('No payment received');
							checkBtn.show();
							checkBtnProcess.hide();
						}
					}
			});

	}


	function syncInitialInvoiceWithXero()
	{
		if(!$('#syncInitialInvoicesBtn i').hasClass('fa-spin'))
		{
			$('#syncInitialInvoicesBtn i').addClass('fa-spin');
			
			$('#syncInvoicesPartial, #syncInvoicesPaid, #syncInvoicesAppMoved').text('');
			$.ajax({
					url:site_url+'xero_api/syncInitialInvoice',
					success:function(data)
						{
							if(data=='LO')
								redirectToLogin();
						   else
							window.location.reload();
						}
				});
		}
	}
	
	
	function syncPoWithXero()
	{
		var syncBtn=$('#syncPoBtn');
		var syncBtnProcess=$('#syncPoProcess');
		var syncPopProcess=$('#syncPoPopProcess');
		var syncSuccess=$('#syncPoSuccess');

		syncBtn.hide();
		syncBtnProcess.show();
		syncPopProcess.show();
		syncSuccess.hide();

		$.ajax({
				url:site_url+'xero_api/syncPo',
				success:function(data)
					{
						if(data=='LO')
							redirectToLogin();
					   else
						{
							syncBtn.show();
							syncBtnProcess.hide();
							syncPopProcess.hide();
							syncSuccess.show();
							//window.location.reload();
						}
					}
			});
	}

	function initializeToolTip()
	{
		$('.tooltips, [data-toggle="tooltip"]').tooltip();
	}


	function shaStudyTourInfo_popContent(id)
	{
		$('#model_ShaStudyTourInfo .modal-title').text('');
		$.ajax({
				url:site_url+'sha/shaStudyTourInfo_popContent/'+id,
				type:'POST',
				success:function(data)
					{
						if(data=='LO')
							redirectToLogin();
					   else
						{
							if(data!='')
								$('#model_ShaStudyTourInfo .modal-title').text(data);
							else
								$('#model_ShaStudyTourInfo .modal-title').text('This tour doesn\'t exist.	');
							$('#model_ShaStudyTourInfo .modal-body > .btn').attr('onclick','goToTourManageApp('+id+')');
						}
					}
			});
	}

	function goToTourManageApp(id)
	{
		window.open(site_url+"tour/all_students/"+id, '_blank');
	}

	function initialInvoiceCancelInfoPopContent(id)
	{
		$('#model_initialInvoiceCancelInfo .modal-body').html('');
		$.ajax({
				url:site_url+'invoice/initialInvoiceCancelInfo_popContent/'+id,
				type:'POST',
				success:function(data)
					{
						if(data=='LO')
							redirectToLogin();
					   else
							$('#model_initialInvoiceCancelInfo .modal-body').html(data);
					}
			});
	}
	
	
	 function addNewOngoingInvoiceItemPopContent(id)
	  {
		  $('#addNewInitialInvoiceItemProcess').hide();
		  $('#addNewInitialInvoiceItemSubmit').show();
	
		  $('#addNewInitialInvoiceItem_form').html('');
		  $.ajax({
			  url:site_url+'invoice/addNewOngoingInvoiceItemPopContent/'+id,
			  success:function(data)
				  {
					  if(data!='')
						$('#addNewInitialInvoiceItem_form').html(data);
					else
						$('#model_addNewInitialInvoiceItem').modal('toggle');
				  }
			  });
	  }

	function bookingEndDateHistory(id)
	{
		$('#filtersLoadingDiv').show();
			  $('#infoSidebar').html('');
			  Utility.toggle_rightbar();
			  
			  
			  $.ajax({
				  url:site_url+'booking/booking_endDate_history/'+id,
				  type:'POST',
				  success:function(data)
					  {
						  $('#filtersLoadingDiv').hide();
						  $('#infoSidebar').html(data);
					  }
				  });
	}
	
	
	
	function checkOngoingInvoiceStatus(invoiceNumber)
	{
		var checkBtn=$('#checkInitialInvoiceStatusBtn');
		var checkBtnProcess=$('#checkInitialInvoiceStatusProcess');

		checkBtn.hide();
		checkBtnProcess.show();

		$.ajax({
				url:site_url+'xero_api/checkOngoingInvoiceStatus',
				type:'POST',
				data:{invoiceNumber:invoiceNumber},
				success:function(data)
					{
						if(data=='LO')
							redirectToLogin();
					   else
						{
							if(data=='newPayment')
							{
								alert('Payment received');
								window.location.reload();
							}
							else if(data=='noNewPayment')
								alert('No payment received');
							checkBtn.show();
							checkBtnProcess.hide();
						}
					}
			});

	}
	
	
	function syncOngoingInvoiceWithXero()
	{
		if(!$('#syncInitialInvoicesBtn i').hasClass('fa-spin'))
		{
			$('#syncInitialInvoicesBtn i').addClass('fa-spin');
			
			$('#syncInvoicesPartial, #syncInvoicesPaid, #syncInvoicesAppMoved').text('');
			$.ajax({
					url:site_url+'xero_api/syncOngoingInvoice',
					success:function(data)
						{
							if(data=='LO')
								redirectToLogin();
						   else
							window.location.reload();
						}
				});
		}
	}
	
	
	function changeStudentInvStatus(id)
	{
		$.ajax({
			url:site_url+'invoice/changeStudentInvStatus/'+id,
			success:function(data)
				{
					$('#invoice-'+id).find('.officeUseTd > a').toggleClass("colorLightgrey").toggleClass("colorLightgreen");
					$('#invoice-'+id).find('.officeUseTd > a > i').attr('data-original-title',data);
				}
		});
	}
	
	function removeHasFromUrl()
	{
		 	// remove fragment as much as it can go without adding an entry in browser history:
				window.location.replace("#");
				
			// slice off the remaining '#' in HTML5:    
			if (typeof window.history.replaceState == 'function') {
			history.replaceState({}, '', window.location.href.slice(0, -1));
			}
	}


	function syncGroupInvoiceWithXero()
	{
		if(!$('#syncInitialInvoicesBtn i').hasClass('fa-spin'))
		{
			$('#syncInitialInvoicesBtn i').addClass('fa-spin');
			
			$('#syncInvoicesPartial, #syncInvoicesPaid, #syncInvoicesAppMoved').text('');
			$.ajax({
					url:site_url+'xero_api/syncGroupInitialInvoice',
					success:function(data)
						{
							if(data=='LO')
								redirectToLogin();
						   else
							window.location.reload();
						}
				});
		}
	}
	
	function shaPrintWindow(id)
	{
		window.open(site_url+'sha/printProfileDetails/'+id,'jav','width=843,height=590,resizable=yes,location=no,resizable=1'); 
	}
	
	function hfaPrintWindow(id)
	{
		window.open(site_url+'hfa/printProfileDetails/'+id,'jav','width=843,height=590,resizable=yes,location=no,resizable=1'); 
	}
	
	function hfaVisitReportPrintWindow(id)
	{
		window.open(site_url+'hfa/printVisitReport/'+id,'jav','width=843,height=590,resizable=yes,location=no,resizable=1'); 
	}
	
	function generatePoBookingOption()
	{
		var formdata=$('#generatePoOptionForm').serialize();
		
		$.ajax({
					url:site_url+'booking/generatePoBookingOption',
					type:'POST',
					data:formdata,
					success:function(data)
						{
							if(data=='LO')
								redirectToLogin();
						   else
								notiPop("success","Homestay nomination setting updated","");
						}
				});
	}
	
	/*function cBPGetRoomList()
	{
		var CBP_hostIdFound=$('#CBP_hostIdFound').val();
		var CBP_bookingFrom=$('#CBP_bookingFrom').val();
		var CBP_bookingTo=$('#CBP_bookingTo').val();
		var CBP_product=$('#CBP_product').val();
		
		$("#CBP_room").html("<option value=''>Select Room</option>");
		
		if(CBP_hostIdFound!='' && CBP_bookingFrom!='' && CBP_bookingTo!='' && CBP_product!='')
		{
			$.ajax({
					url:site_url+'booking/getRoomListForCreateBooking',
					type:'POST',
					data:{host:CBP_hostIdFound,from:CBP_bookingFrom,to:CBP_bookingTo,product:CBP_product},
					dataType: 'json',
					success:function(data)
						{
							if(data.result=='LO')
								redirectToLogin();
							else
								$('#CBP_room').html(data.roomsHtml);
						}
				});
		}
	}*/
	
	
	function alertMsg(divId,type,text)
	{
		  var iconClass='';
		  if(type=='success')
			  iconClass='fa-check';
		  else if(type=='info')
			  iconClass='fa-info';
		  else if(type=='info_orange')
			  iconClass='fa-info';
		  else if(type=='warning')
			  iconClass='fa-exclamation-triangle';
		  else if(type=='danger')
			  iconClass='fa-close';
		  
		  var  html='<div class="alert alert-dismissable alert-'+type+'" style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);"><i class="fa fa-'+iconClass+'"></i>&nbsp; '+text;
			  html +='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>';
		  
		  $('#'+divId).append(html);
	}
	
	function openRevistPopResetForm(id)
	{
		$('#hfaRevisitPop_form')[0].reset();
		$('#hfaRevisitPop_process').hide();
		$('#hfaRevisitPop_submit').show();
		$('#hfaRevisitPop_hfaId').val(id);
	}
	
	function editCGgetPopContent(id)
	{
		$('#model_editCG_form').html('');
		$('#editCG_process').hide();
		$('#editCG_submit').show();
		
		$.ajax({
					url:site_url+'caregiver/editCGgetPopContent/'+id,
					type:'POST',
					data:$('#model_editCG_form').serialize(),
					success:function(data)
						{
							if(data.result=='LO')
								redirectToLogin();
							else
								$('#model_editCG_form').html(data);
						}
				});
	}
	
	function getCGListShaOfficeusePage(id)
	{
		$('#officeUse-guardian_assigned').html('');
		$.ajax({
					url:site_url+'caregiver/getCGListShaOfficeusePage/'+id,
					type:'GET',
					dataType:'json',
					success:function(data)
						{
							$('#officeUse-guardian_assigned').html(data.cgList);
						}
				});
	}
	
	function hfa_callLog_delete(id,hfa_id)
	{
		bootbox.dialog({
	
					message: "Are you sure you wish to delete this call log?",
					title: "Delete",
					buttons: {
					danger: {
					label: "Delete",
					className: "btn-danger",
					callback: function() 
							{
									$.ajax({
												url:site_url+'hfa/callLog_delete/'+id+'/'+hfa_id,
												success:function(data)
													{
														if(data=='LO')
																redirectToLogin();
														else
														  {
																$('#callLog').html(data);
																notiPop('success','Call log deleted successfully',"");
														  }
													}
										});
							}
					}
					}
			});
	}
	
	function hfa_visitReport_delete(id,hfa_id)
	{
		bootbox.dialog({
	
					message: "Are you sure you wish to delete this visit report?",
					title: "Delete",
					buttons: {
					danger: {
					label: "Delete",
					className: "btn-danger",
					callback: function() 
							{
									$.ajax({
												url:site_url+'hfa/visitReport_delete/'+id+'/'+hfa_id,
												success:function(data)
													{
														if(data=='LO')
																redirectToLogin();
														else
														  {
																$('#visits').html(data);
																notiPop('success','Visit report deleted successfully',"");
														  }
													}
										});
							}
					}
					}
			});
	}
	
	function cApprovalDel(id,hfa_id)
	{
		bootbox.dialog({
	
					message: "Are you sure you wish to delete this College approval?",
					title: "Delete",
					buttons: {
					danger: {
					label: "Delete",
					className: "btn-danger",
					callback: function() 
							{
									$.ajax({
												url:site_url+'hfa/cApprovalDel/'+id+'/'+hfa_id,
												success:function(data)
													{
														if(data=='LO')
																redirectToLogin();
														else
														  {
																$('#cApprovalList').html(data);
																notiPop('success','College approval deleted successfully',"");
														  }
													}
										});
							}
					}
					}
			});
	}
	
	function deleteOngoingInvoice(id)
	{
		bootbox.dialog({
	
					message: "Are you sure you wish to delete this invoice?",
					title: "Delete",
					buttons: {
					danger: {
					label: "Delete",
					className: "btn-danger",
					callback: function() 
							{
									$.ajax({
												url:site_url+'invoice/deleteOngoingInvoice/'+id,
												success:function(data)
													{
														if(data=='LO')
																redirectToLogin();
														else
														  {
															 notiPop('success','Invoice deleted successfully',"");
															 var invTable = $('#pendingInvoiceList').DataTable();
															  invTable.row($('#invoice-'+id)).remove().draw();
															}
													}
										});
							}
					}
					}
			});
	}
	
	function deletePo(id)
	{
		bootbox.dialog({
	
					message: "Are you sure you wish to delete this purchase order?",
					title: "Delete",
					buttons: {
					danger: {
					label: "Delete",
					className: "btn-danger",
					callback: function() 
							{
									$.ajax({
												url:site_url+'purchase_orders/deletePo/'+id,
												success:function(data)
													{
														if(data=='LO')
																redirectToLogin();
														else
														  {
															 notiPop('success','Purchase order deleted successfully',"");
															 var poTable = $('#poList').DataTable().draw();
															}
													}
										});
							}
					}
					}
			});
	}
	
	function bookingIncident_delete(id,bookId)
	{
		bootbox.dialog({
	
					message: "Are you sure you wish to delete this incident?",
					title: "Delete",
					buttons: {
					danger: {
					label: "Delete",
					className: "btn-danger",
					callback: function() 
							{
									$.ajax({
												url:site_url+'booking/bookingIncident_delete/'+id+'/'+bookId,
												success:function(data)
													{
														if(data=='LO')
																redirectToLogin();
														else
														  {
																$('#incidents').html(data);
																notiPop('success','Incident deleted successfully',"");
														  }
													}
										});
							}
					}
					}
			});
	}
	
	function bookingIncidentPopContent(id,type)
	{
		$.ajax({
				url:site_url+'booking/bookingIncidentPopContent/'+id+'/'+type,
				dataType: 'json',
				success:function(data)
					{
						if(data.hasOwnProperty('logout'))
							redirectToLogin();
						else
						{
							$('#bookIncident_form').html(data.content);
							$("#model_bookingIncident").modal('show');
							
							var title;
							if(type=='add')
								title='Add new';
							else
								title='Edit';
							$('#model_bookingIncident_titlePart').text(title);
							initializeToolTip();
							
							$('#model_bookingIncident_content').show();
							$('#model_bookingIncident_second').hide();
							if(type=='add')
							{
								$('#bookIncident_submitDiv').show();
								$('#editIncidentSubmitDiv, #editIncidentDocDiv').hide();
							}
							else
							{
								$('#bookingIncidentEdit_id').val(id);
								$('#bookIncident_submitDiv').hide();
								$('#editIncidentSubmitDiv, #editIncidentDocDiv').show();
							}
							
							if(data.hasOwnProperty('incident_documents'))
								{
									$('#editIncidentDocDivDocs').html(data.incident_documents);
									 if($('#editIncidentDocDivDocs div.panel-body > p').length>0)
										$('#editIncidentDocDivDocsParent').show();
									 else
									 {
										$('#editIncidentDocDivDocsParent').hide();
										$('#editIncidentDocDivDocs div.panel-body > p').remove();
									 }
								}
								else
								{
									$('#editIncidentDocDivDocsParent').hide();
									$('#incidentDocDivDocsParent').hide();
									$('#incidentDocDivDocs div.panel-body > p').remove();
								}
						}
					}
		});
	}
	
	function deleteBookingIncidentDoc(id){
			
				bootbox.dialog({
				message: "Are you sure you wish to delete this document?",
				title: "Delete",
				buttons: {
					  danger: {
						label: "Delete",
						className: "btn-danger",
						callback: function() {

								$.ajax({
		url:site_url+'booking/deleteBookingIncidentDoc/',
		type:'POST',
		data:{id:id},
		success:function(data)
			{
				if(data=='LO')
					redirectToLogin();
				else
				{	
					$('p#bookingIncidentDoc-'+id).remove();
					notiPop('success','Document deleted successfully','');
					if($('#editIncidentDocDivDocs div.panel-body > p').length==0)
						$('#editIncidentDocDivDocsParent').hide();
					
					$('#incidents').html(data)	
				}
			}
		});

							}
						}
					}
				});
		}
	
	function bookingIncidentAddFollowUpPopContent(id)
	{
		$.ajax({
				url:site_url+'booking/bookingIncidentFollowUpPopContent/'+id,
				success:function(data)
					{
						if(data=='LO')
							redirectToLogin();
						else
						{
							$('#bookIncidentFollowUp_form').html(data);
							$("#model_bookingIncidentFollowUp").modal('show');
						}
					}
		});
	}
	
	function bookingIncidentViewFollowUpPopContent(id)
	{
		$.ajax({
				url:site_url+'booking/bookingIncidentViewFollowUpPopContent/'+id,
				success:function(data)
					{
						if(data=='LO')
							redirectToLogin();
						else
						{
							$('#bookIncidentViewFollowUp').html(data);
							$("#model_bookingIncidentViewFollowUp").modal('show');
						}
					}
		});
	}
	
	function bookingFeedback_delete(id,bookId)
	{
		bootbox.dialog({
	
					message: "Are you sure you wish to delete this feedback?",
					title: "Delete",
					buttons: {
					danger: {
					label: "Delete",
					className: "btn-danger",
					callback: function() 
							{
									$.ajax({
												url:site_url+'booking/bookingfeedback_delete/'+id+'/'+bookId,
												success:function(data)
													{
														if(data=='LO')
																redirectToLogin();
														else
														  {
																$('#feedbacks').html(data);
																notiPop('success','Feedback deleted successfully',"");
																if(data=='')
																	$('#feedbacksBox').remove();
														  }
													}
										});
							}
					}
					}
			});
	}
	
	function bookingCheckupPopContent(id,method,type)
	{
		$.ajax({
				url:site_url+'booking/bookingCheckupPopContent/'+id+'/'+type,
				success:function(data)
					{
						if(data=='LO')
							redirectToLogin();
						else
						{
							$('#bookCheckup_form').html(data);
							$('#bookingCheckup_type').val(method);
							$("#model_bookingCheckup").modal('show');
							
							var title;
							if(type=='add')
							{
								title='Add ';
								if(method==3)
									title +='new ';
							}
							else
								title='Edit ';
							
							if(method==1)
								title +='arrival';
							else if(method==2)
								title +='reminder';
							else if(method==3)
								title +='regular';	
							
							$('#model_bookingCheckup_titlePart').text(title);
							initializeToolTip();
						}
					}
		});
	}
	
	function hfaTransportInfoPopContent(id,type)
	{
		$.ajax({
				url:site_url+'hfa/hfaTransportInfoPopContent/'+id+'/'+type,
				success:function(data)
					{
						if(data=='LO')
							redirectToLogin();
						else
						{
							$('#hfaTransportInfo_form').html(data);
							$("#model_hfaTransportInfo").modal('show');
							
							var title;
							if(type=='add')
								title='Add new';
							else
								title='Edit';
							$('#model_hfaTransportInfo_titlePart').text(title);
							initializeToolTip();
						}
					}
		});
	}
	
	function hfaTransportInfo_delete(id,hfa_id)
	{
		bootbox.dialog({
	
					message: "Are you sure you wish to delete this transport info?",
					title: "Delete",
					buttons: {
					danger: {
					label: "Delete",
					className: "btn-danger",
					callback: function() 
							{
									$.ajax({
												url:site_url+'hfa/hfaTransportInfo_delete/'+id+'/'+hfa_id,
												success:function(data)
													{
														if(data=='LO')
																redirectToLogin();
														else
														  {
																$('#transportListDiv').html(data);
																notiPop('success','Transport info deleted successfully',"");
															}
													}
										});
							}
					}
					}
			});
	}
	
	function bookingHolidayPopContent(id,type)
	{
		$.ajax({
				url:site_url+'booking/bookingHolidayPopContent/'+id+'/'+type,
				success:function(data)
					{
						if(data=='LO')
							redirectToLogin();
						else
						{
							$('#bookHoliday_form').html(data);
							$("#model_bookingHoliday").modal('show');
							
							var title;
							if(type=='add')
								title='Add new';
							else
								title='Edit';
							$('#model_bookingHoliday_titlePart').text(title);
							initializeToolTip();
						}
					}
		});
	}
	
	function bookingHoliday_delete(id,bookId)
	{
		bootbox.dialog({
	
					message: "Are you sure you wish to delete this holiday?",
					title: "Delete",
					buttons: {
					danger: {
					label: "Delete",
					className: "btn-danger",
					callback: function() 
							{
									$.ajax({
												url:site_url+'booking/bookingHoliday_delete/'+id+'/'+bookId,
												success:function(data)
													{
														if(data=='LO')
																redirectToLogin();
														else
														  {
																$('#holidays').html(data);
																notiPop('success','Holiday deleted successfully',"");
														  }
													}
										});
							}
					}
					}
			});
	}
	
	
function placeBookingServicePopContent(student)
{
	$.ajax({
		url:site_url+'booking/placeBookingServicePopContentValidate/'+student,
		success:function(data)
			{
				if(data=='transfer')
					notiPop('error','Arrival date not available',"Arrival date is required to place a transfer only application");
				else if(data=='guardianship')
					notiPop('error','Guardianship duration not available',"Guardianship duration is required to place a caregiving only application");
				else
					{
						$("#model_PlaceBookingService").modal('show');
						$('#placeBookingService_form').html('');
						$.ajax({
							url:site_url+'booking/placeBookingServicePopContent/'+student,
							type:'POST',
							success:function(data)
								{
									$('#placeBookingService_form').html(data);
								}
							});
					}
			}
		});
}


function getBookingMargn()
{
	$('#tab-booking-margin .panel-body > #tab-booking-margin-html').html('Calculating');
	var formdata=$('#bookingMarginForm').serialize();
	$.ajax({
		url:site_url+'Bmargin/bm4/',
		type:'POST',
		data:formdata,
		dataType: 'json',
		success:function(data)
			{
				$('#tab-booking-margin .panel-body > div > #tab-booking-margin-html >  #tab-booking-margin-html-data').html(data.html);
				var accFeeInv=data.accFee;
				
		
					$.ajax({
						url:site_url+'Bmargin/bmPo/',
						type:'POST',
						data:formdata,
						dataType: 'json',
						success:function(data)
							{
								$('#tab-booking-margin .panel-body > div > #tab-booking-poData-html >  #tab-booking-poData-html-data').html(data.html);
								var accFeePo=data.accFee;
								
								//alert(accFeeInv+'  -  '+accFeePo);
								$.ajax({
									url:site_url+'Bmargin/bmMargin/',
									type:'POST',
									data:{accFeeInv:accFeeInv,accFeePo:accFeePo},
									dataType: 'json',
									success:function(data)
									{
										$('#tab-booking-margin .panel-body > div > #tab-booking-marginData-html >  #tab-booking-marginData-html-data').html(data.html);
									}
								});
								
							}
						});
			}
		});
		
		////////////paid till #STARTS
		$.ajax({
						url:site_url+'Bmargin/bmPaidTill/',
						type:'POST',
						data:formdata,
						dataType: 'json',
						success:function(data)
							{
								$('#tab-booking-margin .panel-body > div > #tab-booking-paidTill-html >  #tab-booking-paidTill-html-data').html(data.html);
							}
					});
		///////////paid till #ENDS
			
}

function hfaWarningSendPopContent(id,type)
	{
		$.ajax({
				url:site_url+'hfa/hfaWarningSendPopContent/'+id+'/'+type,
				dataType: 'json',
				success:function(data)
					{
						if(data.hasOwnProperty('logout'))
							redirectToLogin();
						else
						{
							$('#hfaWarningSend_form').html(data.content);
							$("#model_hfaWarningSend").modal('show');
							
							var title;
							if(type=='add')
								title='Add new';
							else
								title='Edit';
							$('#model_hfaWarningSend_titlePart').text(title);
							initializeToolTip();
							
							$('#model_hfaWarningSend_content').show();
							$('#model_hfaWarningSend_second').hide();
							if(type=='add')
							{
								$('#hfaWarningSend_submitDiv').show();
								$('#editHfaWarningSubmitDiv, #editHfaWarningSendDocDiv').hide();
							}
							else
							{
								$('#bookingHfaWarningSendEdit_id').val(id);
								$('#hfaWarningSend_submitDiv').hide();
								$('#editHfaWarningSubmitDiv, #editHfaWarningSendDocDiv').show();
							}
							
							if(data.hasOwnProperty('warning_documents'))
								{
									$('#editHfaWarningSendDocDivDocs').html(data.warning_documents);
									 if($('#editHfaWarningSendDocDivDocs div.panel-body > p').length>0)
										$('#editHfaWarningSendDocDivDocsParent').show();
									 else
									 {
										$('#editHfaWarningSendDocDivDocsParent').hide();
										$('#editHfaWarningSendDocDivDocs div.panel-body > p').remove();
									 }
								}
								else
								{
									$('#editHfaWarningSendDocDivDocsParent').hide();
									$('#hfaWarningDocDivParent').hide();
									$('#hfaWarningDocDiv div.panel-body > p').remove();
								}
						}
					}
		});
	}
	
	function deleteHfaWarningDoc(id){
			
				bootbox.dialog({
				message: "Are you sure you wish to delete this document?",
				title: "Delete",
				buttons: {
					  danger: {
						label: "Delete",
						className: "btn-danger",
						callback: function() {

								$.ajax({
		url:site_url+'hfa/deleteHfaWarningDoc/',
		type:'POST',
		data:{id:id},
		success:function(data)
			{
				if(data=='LO')
					redirectToLogin();
				else
				{	
					$('p#hfaWarningDoc-'+id).remove();
					notiPop('success','Document deleted successfully','');
					if($('#editHfaWarningSendDocDivDocs div.panel-body > p').length==0)
						$('#editHfaWarningSendDocDivDocsParent').hide();
					
					$('#warningsListDiv').html(data)	
				}
			}
		});

							}
						}
					}
				});
		}
	
	function hfaWarning_delete(id,hfaId)
	{
		bootbox.dialog({
	
					message: "Are you sure you wish to delete this warning?",
					title: "Delete",
					buttons: {
					danger: {
					label: "Delete",
					className: "btn-danger",
					callback: function() 
							{
									$.ajax({
												url:site_url+'hfa/hfaWarning_delete/'+id+'/'+hfaId,
												success:function(data)
													{
														if(data=='LO')
																redirectToLogin();
														else
														  {
																$('#warningsListDiv').html(data);
																notiPop('success','Warning deleted successfully',"");
														  }
													}
										});
							}
					}
					}
			});
	}
	
	function bookingHoldPosUnhold(bookingId,holdId)
	{
		bootbox.dialog({
	
					message: "Are you sure you wish to unhold POs for this booking?",
					title: "Unhold POs",
					buttons: {
					danger: {
					label: "Unhold POs",
					className: "btn-success",
					callback: function() 
							{
									$.ajax({
												url:site_url+'booking/booking_unholdPayments/'+bookingId+'/'+holdId,
												success:function(data)
													{
														if(data=='LO')
																redirectToLogin();
														else
														  {
																$('#hpContent').html(data);
																notiPop('success','Payments to host family unheld successfully',"");
														  }
													}
										});
							}
					}
					}
			});
		}
		
	function bookingHoldPayment_delete(bookingId,holdId)
	{
		bootbox.dialog({
	
					message: "Are you sure you wish to delete this payment hold history?",
					title: "Delete",
					buttons: {
					danger: {
					label: "Delete",
					className: "btn-danger",
					callback: function() 
							{
									$.ajax({
												url:site_url+'booking/bookingHoldPayment_delete/'+bookingId+'/'+holdId,
												success:function(data)
													{
														if(data=='LO')
																redirectToLogin();
														else
														  {
																$('#hpContent').html(data);
																notiPop('success','Payment hold history deleted successfully',"");
														  }
													}
										});
							}
					}
					}
			});
	}	