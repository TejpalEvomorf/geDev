
$(document).ready(function(){
var gl=$("#globalsearch").val();
var glv=$("#search-input").val();
var glselect=$("#glselect").val();
var glmethod=$("#glmethod").val();
if(gl!=''){
	$('#headerSearchDropdown').show();
	$("#topnav").addClass('search-active');
	if(glselect=='hfa'){
		$('#hfaList_filter').find('input').val(glv);
		$("#hfaList_filter input").trigger("keyup",function(event) {
    if (event.keyCode === 13) {
     $(this).dblclick(); 
	}
		

		})
	$("#headerSearchDropdownText").text("Search host families");
		}else if(glselect=='sha'){
			
			$('#shaList_filter').find('input').val(glv);
				$("#shaList_filter input").trigger("keyup",function(event) {
    if (event.keyCode === 13) {
     $(this).dblclick(); 
	}
				})
				
		$("#headerSearchDropdownText").text("Search students");
		}
		else if(glselect=='purchase_orders'){
			
			$('#poList_filter').find('input').val(glv);
				$("#poList_filter input").trigger("keyup",function(event) {
    if (event.keyCode === 13) {
     $(this).dblclick(); 
	}
				})
				
		$("#headerSearchDropdownText").text("Search POs");
		}else if(glmethod=='ongoing_all'){
			$("#headerSearchDropdownText").text("Search ongoing invoices");
		}else if(glmethod=='initial_all'){
			$("#headerSearchDropdownText").text("Search initial invoices");
		}
		else if(glmethod=='searchall'){
			$("#headerSearchDropdownText").text("Search All");
		}
	
}
	
		$('#hfaChangeStatus_form').on('change','#hfaChangeStatus_status',function(){
			$('#shaChangeStatusApprovedInfoMsg').hide();
			if($(this).val()=='confirmed')
				{
					$('#hfaChangeStatus_dateDiv, #hfaChangeStatus_timeDiv, #hfaChangeStatus_visitorDiv, #hfaChangeStatus_commentDiv').show();
					$('#changeStatusDnuOptionsDiv, #changeStatusUnavailableOptionsDiv').hide();
				}
			else if($(this).val()=='do_not_use')
				{
					$('#changeStatusDnuOptionsDiv').show();
					$('#hfaChangeStatus_dateDiv, #hfaChangeStatus_timeDiv, #hfaChangeStatus_visitorDiv, #hfaChangeStatus_commentDiv, #changeStatusUnavailableOptionsDiv').hide();
				}
			else if($(this).val()=='unavailable')
				{
					$('#changeStatusUnavailableOptionsDiv').show();
					$('#changeStatusDnuOptionsDiv').hide();
					$('#hfaChangeStatus_dateDiv, #hfaChangeStatus_timeDiv, #hfaChangeStatus_visitorDiv, #hfaChangeStatus_commentDiv').hide();
				}
			else
				{
					if($(this).val()=='approved')
						$('#shaChangeStatusApprovedInfoMsg').show();
					$('#changeStatusDnuOptionsDiv, #changeStatusUnavailableOptionsDiv').hide();
					$('#hfaChangeStatus_dateDiv, #hfaChangeStatus_timeDiv, #hfaChangeStatus_visitorDiv, #hfaChangeStatus_commentDiv').hide();
				}
			});
	/*$('#tourList').on('click','.anchor_count_warnings',function(){
		var clicked_id = $(this).attr("data-tour_id");
		$('#tourList tr#tour-'+clicked_id+' td button.anchor_click').trigger("click");
	});*/
	

	
	
	
	
	$('#hfaChangeStatusSubmit').click(function(){

			var id=$('#hfaChangeStatus_id').val();
			var statusVal=$('#hfaChangeStatus_status').val();
			var statusText=$('#hfaChangeStatus_status option:selected').text()
			var formdata=$('#hfaChangeStatus_form').serialize();

			var $date=$('#hfaChangeStatus_date');
			var $time=$('#hfaChangeStatus_time');

			if(statusVal=='confirmed')
			{
				var visitDateValid= $('#hfaChangeStatus_date').parsley();
				var visitTimeValid= $('#hfaChangeStatus_time').parsley();
				var visiterNameValid= $('#hfaChangeStatus_visitor').parsley();
				window.ParsleyUI.removeError(visitDateValid,'visitDateValidError');
				window.ParsleyUI.removeError(visitTimeValid,'visitTimeValidError');
				window.ParsleyUI.removeError(visiterNameValid,'visiterNameValidError');
			}

			if(statusVal=='do_not_use')
			{
				var dnuReasonValid= $('#hfaChangeStatus_dnuReason').parsley();
				window.ParsleyUI.removeError(dnuReasonValid,'dnuReasonValidError');
			}

			var date=$date.val();
			var time=$time.val();
			if(1==0)
			{
				if(($date.is(':visible') && date==''))
					{addErrorBorder($date);}
				else
					removeErrorBorder($date);

				if($time.is(':visible') && time==''){
					addErrorBorder($time);}
				else
					removeErrorBorder($time);
			}
			else if(statusVal=='unavailable')
					hfaChangeStatusSubmitUnavail();
			else
			{
				if(statusVal=='confirmed' && ($('#hfaChangeStatus_date').val()=='' || $('#hfaChangeStatus_time').val()=='' || $('#hfaChangeStatus_visitor').val()==''))
				{
					if($('#hfaChangeStatus_date').val()=='')
						window.ParsleyUI.addError(visitDateValid,'visitDateValidError','This is required');
					if($('#hfaChangeStatus_time').val()=='')
						window.ParsleyUI.addError(visitTimeValid,'visitTimeValidError','This is required');
					if($('#hfaChangeStatus_visitor').val()=='')
						window.ParsleyUI.addError(visiterNameValid,'visiterNameValidError','This is required');
				}
				else if(statusVal=='do_not_use' && $('#hfaChangeStatus_dnuReason').val()=='')
					window.ParsleyUI.addError(dnuReasonValid,'dnuReasonValidError','This is required');
				else
				{
				$('#hfaChangeStatusSubmit').hide();
				$('#hfaChangeStatusProcess').show();
				var pageStatus=$('#pageStatus').val();

				  $.ajax({
					  url:site_url+'hfa/changeStatus',
					  type:'post',
					  data:formdata,
					  success:function(data){
						  	  $('#hfaChangeStatusProcess').hide();
							  if(pageStatus=='all' || statusVal==pageStatus)
							  {
								 // $('#hfaStatusText-'+id).text(statusText);
								 //$("#changeStatusHfaEditBtn-"+id+" span").text(statusText);
								 window.location.reload();
							  }
							  else
							  {
							  	  //$('#hfaApplication-'+id).remove();
								  var hfaTable = $('#hfaList').DataTable();
								  hfaTable.row($('#hfaApplication-'+id)).remove().draw();
								}

							  $('#model_ChangeStatusHfa').modal('toggle');
							  $('#hfaChangeStatusSubmit').show();
							  // bootbox.alert("Status changed to "+statusText+" successfully");
							 	notiPop('success','Status changed',"Status changed to <b>"+statusText+"</b> successfully.")
						  }
					  });
			}
			}
		});

		$('a#hfaFiltersBtn').click(function () {

			  $('#filtersLoadingDiv').show();
			  $('#infoSidebar').html('');
			  Utility.toggle_rightbar();

			  var filterData=$('#hfaFiltersFormHidden').serialize();
			  $.ajax({
				  url:site_url+'hfa/filters',
				  type:'POST',
				  data:filterData,
				  success:function(data)
					  {
						  $('#filtersLoadingDiv').hide();
						  $('#infoSidebar').html(data);
					  }
				  });
			  });


		$('a#shaFiltersBtn').click(function () {

			  $('#filtersLoadingDiv').show();
			  $('#infoSidebar').html('');
			  Utility.toggle_rightbar();

			  var filterData=$('#hfaFiltersFormHidden').serialize();
			  $.ajax({
				  url:site_url+'sha/filters',
				  type:'POST',
				  data:filterData,
				  success:function(data)
					  {
						  $('#filtersLoadingDiv').hide();
						  $('#infoSidebar').html(data);
					  }
				  });
			  });


		$('a#hfaFiltersBtn_approved').click(function () {

		  $('#filtersLoadingDiv').show();
		  $('#infoSidebar').html('');
		  Utility.toggle_rightbar();

		  var filterData=$('#hfaFiltersFormHidden').serialize();
		  $.ajax({
			  url:site_url+'sha/filters_approved',
			  type:'POST',
			  data:filterData,
			  success:function(data)
				  {
					  $('#filtersLoadingDiv').hide();
					  $('#infoSidebar').html(data);
				  }
			  });
		});
		$('a#shareHouseFiltersBtn').click(function () {

		  $('#filtersLoadingDiv').show();
		  $('#infoSidebar').html('');
		  Utility.toggle_rightbar();

		  var filterData=$('#houseFiltersFormHidden').serialize();
		  $.ajax({
			  url:site_url+'houses/filters_share_houses',
			  type:'POST',
			  data:filterData,
			  success:function(data)
				  {
					  $('#filtersLoadingDiv').hide();
					  $('#infoSidebar').html(data);
				  }
			  });
		});

			$('.tourPendingRemoveFilter,.tourPlacedRemoveFilter').click(function(){
				var tour_id = $(this).data("tour_id");
				//alert(tour_id);return false;
				$(location).attr('href', site_url+'tour/all_students/'+tour_id);
			});
			$('.hfaRemoveFilter').click(function(){
					var filter=$(this).attr('filter');

					if(filter=='appState')
					{
						var appState=$('#hfaFiltersFormHidden > input[name='+filter+']').val().split(',');
						var appStateVal=$(this).text().trim();
						appState.splice($.inArray( appStateVal, appState),1);
						$('#hfaFiltersFormHidden > input[name='+filter+']').val(appState.join());
						$(this).remove();
					}
					else if(filter=='roomType' || filter=='facility')
					{
						var appState=$('#hfaFiltersFormHidden > input[name='+filter+']').val().split(',');
						//var appStateVal=$(this).val();alert(appStateVal);
						var appStateVal=$(this).attr('filterVal');
						appState.splice($.inArray( appStateVal, appState),1);
						$('#hfaFiltersFormHidden > input[name='+filter+']').val(appState.join());
						$(this).remove();
					}
					else if(filter=='appStep' || filter=='appTourType' || filter=='wwcc' || filter=='insurance' || filter=='appDuplicate' || filter=='appCaregivingDuration' || filter=='appMatchCollege')
					{
						$(this).remove();
						//$('#hfaFiltersFormHidden > input[name='+filter+']').val('');
						$('#hfaFiltersFormHidden > input[name='+filter+']').remove();
					}else if(filter=='appReason'){
						$(this).remove();
						$('#hfaFiltersFormHidden > input[name='+filter+']').remove();
					}else if(filter=='bookmark'){
						$(this).remove();
						$('#hfaFiltersFormHidden > input[name='+filter+']').remove();
					}else if(filter=='client'){
						$(this).remove();
						$('#hfaFiltersFormHidden > input[name='+filter+']').remove();
					}else if(filter=='college'){
						$(this).remove();
						$('#hfaFiltersFormHidden > input[name='+filter+']').remove();
					}else if(filter=='room' || filter=='warning'){
						$(this).remove();
						$('#hfaFiltersFormHidden > input[name='+filter+']').remove();
					}else if(filter=='appDuplicate' || filter=='appCaregivingDuration' || filter=='appMatchCollege'){
						$(this).remove();
						$('#hfaFiltersFormHidden > input[name='+filter+']').remove();
					}else if(filter=='cApproval'){
						$(this).remove();
						$('#hfaFiltersFormHidden > input[name='+filter+']').remove();
					}else if(filter=='religion' || filter=='nation' || filter=='language'){
						$(this).remove();
						$('#hfaFiltersFormHidden > input[name='+filter+']').remove();
					}
					else
					{
						//$(this).parent().html('');
						$('#hfaFiltersFormHidden').html('');
					}

					if($('#hfaFiltersFormHidden > input[name=appStep]').val()=='')
						$('#hfaFiltersFormHidden > input[name=appStep]').remove();
					if($('#hfaFiltersFormHidden > input[name=appState]').val()=='')
						$('#hfaFiltersFormHidden > input[name=appState]').remove();
					if($('#hfaFiltersFormHidden > input[name=placement]').val()=='')
						$('#hfaFiltersFormHidden > input[name=placement]').remove();
					if($('#hfaFiltersFormHidden > input[name=appReason]').val()=='')
						$('#hfaFiltersFormHidden > input[name=appReason]').remove();
					if($('#hfaFiltersFormHidden > input[name=bookmark]').val()=='')
						$('#hfaFiltersFormHidden > input[name=bookmark]').remove();
					if($('#hfaFiltersFormHidden > input[name=client]').val()=='')
						$('#hfaFiltersFormHidden > input[name=client]').remove();
					if($('#hfaFiltersFormHidden > input[name=college]').val()=='')
						$('#hfaFiltersFormHidden > input[name=college]').remove();
					if($('#hfaFiltersFormHidden > input[name=room]').val()=='')
						$('#hfaFiltersFormHidden > input[name=room]').remove();
					if($('#hfaFiltersFormHidden > input[name=warning]').val()=='')
						$('#hfaFiltersFormHidden > input[name=warning]').remove();
					if($('#hfaFiltersFormHidden > input[name=wwcc]').val()=='')
						$('#hfaFiltersFormHidden > input[name=wwcc]').remove();
					if($('#hfaFiltersFormHidden > input[name=insurance]').val()=='')
						$('#hfaFiltersFormHidden > input[name=insurance]').remove();
					if($('#hfaFiltersFormHidden > input[name=appDuplicate]').val()=='')
						$('#hfaFiltersFormHidden > input[name=appDuplicate]').remove();
					if($('#hfaFiltersFormHidden > input[name=appCaregivingDuration]').val()=='')
						$('#hfaFiltersFormHidden > input[name=appCaregivingDuration]').remove();
					if($('#hfaFiltersFormHidden > input[name=appMatchCollege]').val()=='')
						$('#hfaFiltersFormHidden > input[name=appMatchCollege]').remove();
					if($('#hfaFiltersFormHidden > input[name=cApproval]').val()=='')
						$('#hfaFiltersFormHidden > input[name=cApproval]').remove();
					if($('#hfaFiltersFormHidden > input[name=religion]').val()=='')
						$('#hfaFiltersFormHidden > input[name=religion]').remove();
					if($('#hfaFiltersFormHidden > input[name=nation]').val()=='')
						$('#hfaFiltersFormHidden > input[name=nation]').remove();
					if($('#hfaFiltersFormHidden > input[name=roomType]').val()=='')
						$('#hfaFiltersFormHidden > input[name=roomType]').remove();
					if($('#hfaFiltersFormHidden > input[name=facility]').val()=='')
						$('#hfaFiltersFormHidden > input[name=facility]').remove();
					if($('#hfaFiltersFormHidden > input[name=language]').val()=='')
						$('#hfaFiltersFormHidden > input[name=language]').remove();
							
					$('#hfaFiltersFormHidden').submit();
				});

	$('#hfaList').on('click','.hfaDeleteApp',function(){
			var has_booking=$(this).attr('data-booking');
			var hfaId=$(this).attr('id');
			var hfaIdSplit=hfaId.split('-');
			var id=hfaIdSplit[1];
			if(has_booking==1) {
				bootbox.dialog({
				message: "Because this host family application has an active or inactive booking related to it.",
				title: "Cannot delete this application",
				className:'shaHfaCannotDelAlert',
				buttons: {
					  danger: {
						label: "Close",
						className: "btn-default",
						callback: function() {}
						}
					}
				});
			}
			else {
				bootbox.dialog({
				message: "Are you sure you wish to delete this application?",
				title: "Delete",
				buttons: {
					  danger: {
						label: "Delete",
						className: "btn-danger",
						callback: function() {

								$.ajax({
					  url:site_url+'hfa/deleteApplication',
					  type:'post',
					  data:{id:id},
					  success:function(data){
								 notiPop('success','Application deleted successfully',"");
								 var hfaTable = $('#hfaList').DataTable();
								  hfaTable.row($('#hfaApplication-'+id)).remove().draw();
							}
					  });
							}
						}
					}
				});
			}
    	});


		$('#rescheduleVisitSubmit').click(function(){

			$('#model_rescheduleVisit_form').parsley().validate();

			if ($('#model_rescheduleVisit_form').parsley().isValid())
			{
				$('#rescheduleVisitSubmit').hide();
				var formdata=$('#model_rescheduleVisit_form').serialize();
				 $.ajax({
						  url:site_url+'hfa/rescheduleVisitSubmit',
						  type:'post',
						  data:formdata,
						  success:function(data){
								if(data=='LO')
									redirectToLogin();
								else
								  {
									   /*var hfaTable = $('#hfaList').DataTable();
										hfaTable.draw();*/
										$('#model_rescheduleVisit').modal('toggle');
										$('#rescheduleVisitSubmit').show();
										notiPop('success','Visit rescheduled',"")
										window.location.reload();
								  }
								}
						  });
				}

		});


		$('#shaChangeStatus_form').on('change','#houseChangeStatus_status',function(){
			if($(this).val()!='share_house_rejected')
			{
				$('#shaAssignClientDiv').show();
				if($(this).val()=='share_house_cancelled')
				{
					$('#shaChangeStatus_reasonDiv, #shaChangeStatus_dateDiv').show();
				}
				else
					$('#shaChangeStatus_reasonDiv, #shaChangeStatus_dateDiv').hide();

				if($(this).val()=='share_house_new')
					$('#shaAssignClientDiv, #shaChangeStatus_reasonDiv').hide();
			}
			else
			{
				$('#shaAssignClientDiv, #shaChangeStatus_reasonDiv, #shaChangeStatus_dateDiv').hide();
				$('#shaChangeStatus_reasonDiv').show();
			}
		});
		
		$('#shaChangeStatus_form').on('change','#shaChangeStatus_status',function(){
			$('#shaChangeStatusPendingInvInfoMsg, #shaChangeStatusGshipDateInfoMsg, #tourChangeStatusWarningsInfoMsg').hide();
			$('#shaChangeStatusSubmit, #tourChangeStatusSubmit').show();
			
			if($(this).val()!='rejected')
			{
				$('#shaAssignClientDiv').show();
				$('#shaChangeStatus_client, #shaChangeStatus_employee').attr('required','required');
				
				if($(this).val()=='cancelled')
				{
					$('#shaChangeStatus_reasonDiv, #shaChangeStatus_dateDiv').show();
				}
				else
					$('#shaChangeStatus_reasonDiv, #shaChangeStatus_dateDiv').hide();

				if($(this).val()=='new')
					$('#shaAssignClientDiv, #shaChangeStatus_reasonDiv').hide();
					
				if($(this).val()=='pending_invoice')
				{
					if($('#shaChangeStatus_form input[name=guardianshipDateNotSet]').length>0)
						{
							$('#shaAssignClientDiv').hide();
							$('#shaChangeStatusSubmit').hide();
							$('#shaChangeStatusGshipDateInfoMsg').show();
							$('#shaChangeStatusPendingInvInfoMsg').hide();
						}
						else if($('#shaChangeStatus_form input[name=warningsNotReloved]').length>0)
						{
							$('#shaAssignClientDiv').hide();
							$('#tourChangeStatusSubmit').hide();
							$('#tourChangeStatusWarningsInfoMsg').show();
							$('#shaChangeStatusPendingInvInfoMsg').hide();
						}
						else
							$('#shaChangeStatusPendingInvInfoMsg').show();	
				}
			}
			else
			{
				$('#shaAssignClientDiv, #shaChangeStatus_reasonDiv, #shaChangeStatus_dateDiv').hide();
				$('#shaChangeStatus_reasonDiv').show();
				$('#shaChangeStatus_client, #shaChangeStatus_employee').removeAttr('required');
			}
		});


		$('#shaChangeStatusSubmit').click(function(){
		var valid=$('#shaChangeStatus_form').parsley().validate();
		if(valid)
		{
			var id=$('#shaChangeStatus_id').val();
			var statusVal=$('#shaChangeStatus_status').val();
			var statusText=$('#shaChangeStatus_status option:selected').text()
			var appStep=$('#shaChangeStatusAppStep').val();
			
			if(statusVal=='pending_invoice' && appStep!='4')
				notiPop("error","Cannot change status","Student application is not complete");
			else
					{
						var formdata=$('#shaChangeStatus_form').serialize();
					
						$('#shaChangeStatusSubmit').hide();
						$('#shaChangeStatusProcess').show();
						$('#shaChangeStatusBookingFromErrorMsg').hide();
						var pageStatus=$('#pageStatus').val();
					
						  $.ajax({
							  url:site_url+'sha/changeStatus',
							  type:'post',
							  data:formdata,
							  success:function(data){
								  $('#shaChangeStatusProcess').hide();
								  if(data=='groupInvoice-bookingFrom')
								  	{
										$('#shaChangeStatusBookingFromErrorMsg').show();
									}
								  else
									  {
										   if(pageStatus=='all' || statusVal==pageStatus)
												window.location.reload();
										   else
											  {
												  var hfaTable = $('#shaList').DataTable();
												  hfaTable.row($('#shaApplication-'+id)).remove().draw();
											  }
											
										  $('#model_ChangeStatusSha').modal('toggle');
										  $('#shaChangeStatusSubmit').show();
										  $('#shaSearchBtn').show();
										  notiPop('success','Status changed',"Status changed to <b>"+statusText+"</b> successfully.");
										  if(statusVal=='pending_invoice' && data=='done')
											notiPop('success','Initial invoice generated',"Initial invoice has been generated for this student.");
										}
								  }
							  });
					}
				}
		});
		$('#shareHouseChangeStatusSubmit').click(function(){
			var valid=$('#shaChangeStatus_form').parsley().validate();
			if(valid)
			{
				var id=$('#shaChangeStatus_id').val();
				var statusVal=$('#shaChangeStatus_status').val();
				var statusText=$('#shaChangeStatus_status option:selected').text()
				var formdata=$('#shaChangeStatus_form').serialize();

					$('#shareHouseChangeStatusSubmit').hide();
					$('#shaChangeStatusProcess').show();
					var pageStatus=$('#pageStatus').val();

					  $.ajax({
						  url:site_url+'houses/changeStatus',
						  type:'post',
						  data:formdata,
						  success:function(data){
							  $('#shaChangeStatusProcess').hide();
								   if(pageStatus=='all' || statusVal==pageStatus)
										window.location.reload();
								   else
									  {
										  var hfaTable = $('#shaList').DataTable();
										  hfaTable.row($('#shaApplication-'+id)).remove().draw();
									  }

								  $('#model_ChangeStatusSha').modal('toggle');
								  $('#shareHouseChangeStatusSubmit').show();
								  notiPop('success','Status changed',"Status changed to <b>"+statusText+"</b> successfully.");
								  if(statusVal=='pending_invoice')
								  	notiPop('success','Initial invoice generated',"Initial invoice has been generated for this student.");
							  }
						  });
				}
		});

		$('#tourChangeStatusSubmit').click(function(){
			//alert('reach here 123');return false;
			var valid=$('#shaChangeStatus_form').parsley().validate();
			if(valid)
			{
				var id=$('#study_tour_id').val();
				var statusVal=$('#shaChangeStatus_status').val();
				var statusText=$('#shaChangeStatus_status option:selected').text()
				var formdata=$('#shaChangeStatus_form').serialize();

						$('#tourChangeStatusSubmit').hide();
						$('#tourChangeStatusProcess').show();

						$.ajax({
							url:site_url+'tour/changeStatus',
							type:'post',
							data:formdata,
							success:function(data){
								if(data=='done')
								{
									$('#tourChangeStatusProcess').hide();
									//var hfaTable = $('#tourList').DataTable();
									//hfaTable.row($('#shaApplication-'+id)).remove().draw();

									$('#model_ChangeStatusTour').modal('toggle');
									$('#tourChangeStatusSubmit').show();
									notiPop('success','Status changed',"Status changed successfully.");
									if(statusVal=='pending_invoice')
									  	notiPop('success','Initial invoice generated',"Initial invoice has been generated for all applications in this tour.");
									setTimeout(function(){
										window.location.reload();
									}, 3000);
								}
								else
								{
									$("#model_ChangeStatusTour").modal('hide');
									$("#modal_MissingBookingDates").modal('toggle');
									$("#modal_MissingBookingDates").modal('show');
									$('#modal_MissingBookingDates .modal-body').html(data);
									$('#tourChangeStatusSubmit').show();
								}
							}
						});
				}

		});




		$('#shaList').on('click','.shaDeleteApp',function(){
		 	var has_booking=$(this).attr('data-booking');
		 	var hfaId=$(this).attr('id');
			var hfaIdSplit=hfaId.split('-');
			var id=hfaIdSplit[1];
			if(has_booking==2) {
				return;
			}else if(has_booking==1) {
				bootbox.dialog({
				message: "Because this student application has an active or inactive booking related to it.",
				title: "Cannot delete this application",
				className:'shaHfaCannotDelAlert',
				buttons: {
					  danger: {
						label: "Close",
						className: "btn-default",
						callback: function() {}
						}
					}
				});
			}else {
				bootbox.dialog({
				message: "Are you sure you wish to delete this application?",
				title: "Delete",
				buttons: {
					  danger: {
						label: "Delete",
						className: "btn-danger",
						callback: function() {

								$.ajax({
					  url:site_url+'sha/deleteApplication',
					  type:'post',
					  data:{id:id},
					  success:function(data){
								notiPop('success','Application deleted successfully',"");
						  		 var hfaTable = $('#shaList').DataTable();
								  hfaTable.row($('#shaApplication-'+id)).remove().draw();
								  $("#shaSearchBtn").show();
							}
					  });
							}
						}
					}
				});
			}
			
    	});
		$('#shareHouseList').on('click','.houseDeleteApp',function(){
		 	var hfaId=$(this).attr('id');
			var hfaIdSplit=hfaId.split('-');
			var id=hfaIdSplit[1];

			bootbox.dialog({
				message: "Are you sure you wish to delete this application?",
				title: "Delete",
				buttons: {
					  danger: {
						label: "Delete",
						className: "btn-danger",
						callback: function() {

								$.ajax({
					  url:site_url+'houses/deleteApplication',
					  type:'post',
					  data:{id:id},
					  success:function(data){
								notiPop('success','Application deleted successfully',"");
						  		 var hfaTable = $('#shareHouseList').DataTable();
								  hfaTable.row($('#shaApplication-'+id)).remove().draw();
							}
					  });
							}
						}
					}
				});
    	});
		$('#clientList').on('click','.shaDeleteApp',function(){
			var has_booking=$(this).attr('data-booking');
		 	var hfaId=$(this).attr('id');
			var hfaIdSplit=hfaId.split('-');
			var id=hfaIdSplit[1];
			
			if(has_booking==1) 
			{
				bootbox.dialog({
				message: "Because this student application has an active or inactive booking related to it.",
				title: "Cannot delete this application",
				className:'shaHfaCannotDelAlert',
				buttons: {
					  danger: {
						label: "Close",
						className: "btn-default",
						callback: function() {}
						}
					}
				});
			}
			else
			{
				bootbox.dialog({
				message: "Are you sure you wish to delete this application?",
				title: "Delete",
				buttons: {
					danger: {
						label: "Delete",
						className: "btn-danger",
						callback: function() {
								$.ajax({
										url:site_url+'sha/deleteApplication',
										type:'post',
										data:{id:id},
										success:function(data){
											notiPop('success','Application deleted successfully',"");
											var hfaTable = $('#clientList').DataTable();
											hfaTable.row($('#shaApplication-'+id)).remove().draw();
										}
								});
							}
					}
				}
			});
			}
		});

	$('#selectProfilePicSubmit').click(function(){
			var $submitBtn=$(this);


			if($('.profilePicClass').length>0)
			{
				$submitBtn.hide();
				$('#selectProfilePicCancel').hide();
				$('#selectProfilePicSubmitProcess').show();

				$.ajax({
					url:site_url+'admin/selectProfilePhotoSubmit',
					type:'POST',
					data:$('#profilePicModelForm').serialize(),
					success:function(data)
						{
							$('#selectProfilePicSubmitProcess').hide();
							if(data=='LO')
								redirectToLogin();
							else
							{
								if(data!='')
									 $('#appProfilePic img').attr('src',data).addClass('profilPicSet');
								 $('#selectProfilePhotoBtn').text('Change profile photo');
								 $('#selectProfilePicCancel').show();
								 $submitBtn.show();
								 $('#profilePicModel').modal('toggle');
								 notiPop('success','Profile photo updated',"");
							}
						}
					});
			}
			else
				notiPop('error','Please select a photo',"");
		});


		////////Delete App photo #STARTS
		$('.material-nav-tabs	li a').click(function(){
			if($(this).attr('href')=='#tab-8-2')
			{
				if($('.profile-photos .col-md-3').length>0)
					$('#deleteAppPhotos').show();

			}
			else
			{
				if($(this).attr('href')!=undefined)
					$('#deleteAppPhotos').hide();
			}
			
			if($(this).attr('href')=='#tab-8-1')
				$('#printProfieBtn').show();
			else
				$('#printProfieBtn').hide();

		});


		$('.material-nav-tabs	li > a').click(function(){
			if($(this).attr('href')=='#tab-8-5')
			{
				$('#filterMatches, #filterMatchesStatusBtnDiv, #sortHfaBookingHistory').show();
				if(page=='sha_application')
					filterMatchesFormSubmit('#filterMatchesForm');
			}
			else if($(this).attr('href')=='#tab-8-6' || $(this).attr('href')=='#tab-90-1')
			{
				$('#sortShaBookingHistory').show();
			}
			else
				{
					if($(this).attr('href')!='javascript:void(0);')
						$('#filterMatches, #filterMatchesStatusBtnDiv, #sortHfaBookingHistory, #sortShaBookingHistory').hide();
				}
		});

	$('#deleteAppPhotos').click(function(){
			$('.delAppPhotosIconSingle').toggle();
		});


	$('.profile-photos').on('click','.delAppPhotosIconSingle',function(){
	//$('.delAppPhotosIconSingle').click(function(){
			var id=$(this).attr('id');
			var idArray=id.split('-');

			bootbox.dialog({
				message: "Are you sure you wish to delete this photo?",
				title: "Delete",
				buttons: {
					  danger: {
						label: "Delete",
						className: "btn-danger",
						callback: function() {

										  //$('#'+id).parent().remove();
										  $.ajax({
								url:site_url+'admin/deleteApplicationPhotos',
								type:'post',
								data:{id:idArray[2],hfaSha:idArray[1],application_id:idArray[3]},
								dataType: 'json',
								success:function(data){
															if(data.hasOwnProperty('logout'))
																redirectToLogin();
															else
															{
																$('.profile-photos').html(data.application_photos_list);
																$('#appProfilePic').html(data.profilePic);
																$('#changeProfilePicDiv').show();
																$('#deleteAppPhotos').show();
																$('.delAppPhotosIconSingle').show();

																//Show/Hide delete btn
																if($('.profile-photos .col-md-3').length>0)
																	$('#deleteAppPhotos').show();
																else
																$('#deleteAppPhotos, #changeProfilePicDiv').hide();
															}
									}
								});
							}
						}
					}
				});

		});
		//////////Delete App photo  #ENDS

	$('#submitBtnCreateClient').on('click', function () {

		var bnameField = $('input#bname').parsley();
		var abnField = $('input#abn').parsley();
		var pEmailField = $('input#p_email').parsley();
		var sEmailField = $('input#s_email').parsley();
		window.ParsleyUI.removeError(bnameField,'bnameFieldError');
		window.ParsleyUI.removeError(abnField,'abnFieldError');
		window.ParsleyUI.removeError(pEmailField,'pEmailFieldError');
		window.ParsleyUI.removeError(sEmailField,'sEmailFieldError');

        var valid=$('#formCreateClient').parsley().validate();
		var valid2=true;
		if($('#formCreateClientCategory').length>0)
			var valid2=$('#formCreateClientCategory').parsley().validate();

		if(valid && valid2)
		{
			$('#submitBtnCreateClient').hide();
			$('#formCreateClientProcess').show();
			$.ajax({
				url:site_url+'client/createSubmit',
				type:'POST',
				data:$('#formCreateClientCategory').serialize()+'&'+$('#formCreateClient').serialize(),
				dataType: 'json',
				success:function(data)
					{
						$('#formCreateClientProcess').hide();
						if(data.hasOwnProperty('logout'))
							redirectToLogin();
						else if(data.hasOwnProperty('notValid'))
							{
								$('#submitBtnCreateClient').show();

								if(data.notValid.bname=='1')
									window.ParsleyUI.addError(bnameField, "bnameFieldError", 'Business name already registered with us');
								if(data.notValid.abn=='1')
										window.ParsleyUI.addError(abnField, "abnFieldError", 'ABN already registered with us');
								if(data.notValid.pEmail=='1')
										window.ParsleyUI.addError(pEmailField, "pEmailFieldError", 'Email already registered with us');
								if(data.notValid.sEmail=='1')
										window.ParsleyUI.addError(sEmailField, "sEmailFieldError", 'Email already registered with us');

								if(data.notValid.bname=='1')
									scrollToDIv('bname');
								else if(data.notValid.abn=='1')
										scrollToDIv('abn');
								else if(data.notValid.pEmail=='1')
										scrollToDIv('p_email');
								else if(data.notValid.sEmail=='1')
										scrollToDIv('s_email');
							}
						else
						{
							if($('#id').length==0)
							{
								window.location.href=site_url+'client/edit/'+data.done.id+'/#clientCreated';
							}
							else
							{
								notiPop('success','Client edited successfully','')
								$('#submitBtnCreateClient').show();
							}
						}
					}
			});
		}
    });


$('#clientList').on('click','.clientDelete',function(){
			var hfaId=$(this).attr('id');
			var hfaIdSplit=hfaId.split('-');
			var id=hfaIdSplit[1];

		$.ajax({
				url:site_url+'client/shaListByClientId',
				type:'POST',
				data:{id:id},
				success:function(data)
					{
						$('#model_deleteClientProcess').modal('toggle');
						if(data=='LO')
							redirectToLogin();
						else if(data=='noStudent')
						{
										bootbox.dialog({
										message: "Are you sure you wish to delete this client?",
										title: "Delete",
										buttons: {
											  danger: {
												label: "Delete",
												className: "btn-danger",
												callback: function() {
						
														$.ajax({
											  url:site_url+'client/deleteClient',
											  type:'post',
											  data:{id:id},
											  success:function(data){
														 notiPop('success','Client deleted successfully',"");
														 var hfaTable = $('#clientList').DataTable();
														  hfaTable.row($('#client-'+id)).remove().draw();
													}
											  });
													}
												}
											}
										});
						}
						else
						{
							$('#model_deleteClient').modal('toggle');
							$('#delClient_shaListDiv').html(data);
						}
						
					}
			});
    	});


		$('#tourList').on('click', '.tourDelete', function (e) {
			e.preventDefault();
			//$('.tourDelete').click(function(){
			var hfaId=$(this).parents('tr').attr('id');
			var hfaIdSplit=hfaId.split('-');
			var id=hfaIdSplit[1];

			bootbox.dialog({
				message: "Are you sure you wish to delete this tour?",
				title: "Delete",
				buttons: {
					  danger: {
						label: "Delete",
						className: "btn-danger",
						callback: function() {
								$.ajax({
								  url:site_url+'tour/deleteTour',
								  type:'post',
								  data:{id:id},
								  success:function(data){
											notiPop('success','Tour deleted successfully',"");
											var tourTable = $('#tourList').DataTable();
											tourTable.row($('tr #tour-'+id)).remove().draw();
											//$('#mestypeTable').ajax.reload( null, false );
										}
					  		});
							}
						}
					}
				});
		});


		$('#submitBtnAddEmployee').on('click', function () {

			var company_email = $('input#company_email').parsley();
			window.ParsleyUI.removeError(company_email,'company_emailFieldError');

			var valid=$('#addEmployeeForm').parsley().validate();
			var valid_designation=$('#empDesignationForm').parsley().validate();

			if(valid && valid_designation)
				{
					$('#submitBtnAddEmployee').hide();
					$('#addEmployeeFormProcess').show();
					$.ajax({
						url:site_url+'account/createEmployee',
						type:'POST',
						data:$('#addEmployeeForm').serialize(),
						dataType: 'json',
						success:function(data)
							{
								$('#addEmployeeFormProcess').hide();
								if(data.hasOwnProperty('logout'))
									redirectToLogin();
								else if(data.hasOwnProperty('notValid'))
									{
										$('#submitBtnAddEmployee').show();

										if(data.notValid.company_email=='1')
											window.ParsleyUI.addError(company_email, "company_emailFieldError", 'Company email already registered with us');

										if(data.notValid.company_email=='1')
											scrollToDIv('company_email');
									}
								else
								{
									$('#submitBtnAddEmployee').show();
									notiPop('success','Employee added successfully','')
									editEmployeeForm(data.done.id);
								}
							}
					});
				}

		});


			//$('.employeeDelete').click(function(){
			$('#employeeList').on('click','.employeeDelete',function(){
			var hfaId=$(this).parents('tr').attr('id');
			var hfaIdSplit=hfaId.split('-');
			var id=hfaIdSplit[1];

					$.ajax({
					  url:site_url+'account/checkEmpAppCountDelEmp',
					  type:'POST',
					  data:{id:id},
					  success:function(data)
						  {
							  if(data=='LO')
								  redirectToLogin();
							  else
							  {
								  if(data!=0)
								  {
									  $('#model_assignDiffEmpToAppContent').html(data);
									  $('#model_assignDiffEmpToApp').modal('show');
									}
								  else
								  {
									  bootbox.dialog({
									  message: "Are you sure you wish to delete this employee?",
									  title: "Delete",
									  buttons: {
											danger: {
											  label: "Delete",
											  className: "btn-danger",
											  callback: function() {
													deleteEmployee(id);
												  }
											  }
										  }
										});
								  }
							  }
						  }
				});
			    	});


	$('#submitBtnEditEmployee').click(function () {
			if($('#company_emailEdit').attr('type')=='text')
			{
				var company_email = $('input#company_emailEdit').parsley();
				window.ParsleyUI.removeError(company_email,'company_emailFieldError');
			}

			var valid=$('#editEmployeeForm').parsley().validate();

			if(valid)
				{
					$('#submitBtnEditEmployee').hide();
					$('#editEmployeeFormProcess').show();
					$.ajax({
						url:site_url+'account/editEmployee',
						type:'POST',
						data:$('#editEmployeeForm').serialize(),
						dataType: 'json',
						success:function(data)
							{
								$('#editEmployeeFormProcess').hide();
								if(data.hasOwnProperty('logout'))
									redirectToLogin();
								else if(data.hasOwnProperty('notValid'))
									{
										$('#submitBtnEditEmployee').show();

										if(data.notValid.company_email=='1')
											window.ParsleyUI.addError(company_email, "company_emailFieldError", 'Company email already registered with us');

										if(data.notValid.company_email=='1')
											scrollToDIv('company_emailEdit');
									}
								else
								{
									notiPop('success','Employee edited successfully','')
									$('#submitBtnEditEmployee').show();
									if($('#name-my_account').length>0)
										$('#sidebarFnameLname').text($('#name-my_account').val()+' '+$('#lname-my_account').val());
								}
							}
					});
				}

		});


			$('a#tourFiltersBtn').click(function () {

			  $('#filtersLoadingDiv').show();
			  $('#infoSidebar').html('');
			  Utility.toggle_rightbar();
				var tour_id = $("#tourFiltersBtn").data("tour_id");
		  	var filterData=$('#tourFiltersFormHidden').serialize();

			  $.ajax({
				  url:site_url+'tour/filters/'+tour_id,
				  type:'POST',
				  data:filterData,
				  success:function(data)
					{
						  $('#filtersLoadingDiv').hide();
						  $('#infoSidebar').html(data);
					}
				 });
			 });

			$('a#clientFiltersBtn').click(function () {

			  $('#filtersLoadingDiv').show();
			  $('#infoSidebar').html('');
			  Utility.toggle_rightbar();

			  var filterData=$('#clientFiltersFormHidden').serialize();
			  $.ajax({
				  url:site_url+'client/filters',
				  type:'POST',
				  data:filterData,
				  success:function(data)
					  {
						  $('#filtersLoadingDiv').hide();
						  $('#infoSidebar').html(data);
					  }
				  });
			  });


			$('.clientRemoveFilter').click(function(){
					var filter=$(this).attr('filter');
					if(filter!='all')
					{
						$(this).remove();
						$('#clientFiltersFormHidden > input[name='+filter+']').remove();
					}
					else
						$('#clientFiltersFormHidden').html('');

					$('#clientFiltersFormHidden').submit();
				});
				
				
				$('.invoiceRemoveFilter').click(function(){
					var filter=$(this).attr('filter');
					if(filter!='all')
					{
						$(this).remove();
						$('#invoiceFiltersFormHidden > input[name='+filter+']').val('');
						if(filter=='from' || filter=='to')
							$('#invoiceFiltersFormHidden > input[name=from], #invoiceFiltersFormHidden > input[name=to]').val('');	
					}
					else
						$('#invoiceFiltersFormHidden').html('');

					$('#invoiceFiltersFormHidden').submit();
				});
				
				$('.bookingRemoveFilter').click(function(){
					var filter=$(this).attr('filter');
					if(filter!='all')
					{
						$(this).remove();
						$('#bookingFiltersFormHidden > input[name='+filter+']').remove();
					}
					else
						$('#bookingFiltersFormHidden').html('');

					$('#bookingFiltersFormHidden').submit();
				});
				
				$('.pORemoveFilter').click(function(){
					var filter=$(this).attr('filter');
					if(filter!='all')
					{
						$(this).remove();
						$('#poFiltersFormHidden > input[name='+filter+']').remove();
					}
					else
						$('#poFiltersFormHidden').html('');

					$('#poFiltersFormHidden').submit();
				});

			 $('#officeUse-changeOffice').change(function(){
			   		$.ajax({
							url:site_url+'account/getEmployeeByOffice/'+$(this).val(),
							success:function(data)
								{
									$('#officeUse-changeEmployee').html(data);
								}
						});
			   });



		/*$('#submitBtnCreateGuardian').on('click', function () {

		var cnameField = $('input#cname').parsley();
		var emailField = $('input#email').parsley();

		window.ParsleyUI.removeError(cnameField,'cnameFieldError');
		window.ParsleyUI.removeError(emailField,'emailFieldError');


        var valid=$('#formCreateGuardian').parsley().validate();

		if(valid)
		{
			$('#submitBtnCreateGuardian').hide();
			$('#formCreateGuardianProcess').show();
			$.ajax({
				url:site_url+'guardian/createSubmit',
				type:'POST',
				data:$('#formCreateGuardian').serialize(),
				dataType: 'json',
				success:function(data)
					{
						$('#formCreateGuardianProcess').hide();

						if(data.hasOwnProperty('logout'))
							redirectToLogin();
						else if(data.hasOwnProperty('notValid'))
							{
								$('#submitBtnCreateGuardian').show();

								if(data.notValid.cname=='1')
									window.ParsleyUI.addError(cnameField, "cnameFieldError", 'Company name already registered with us');
								if(data.notValid.email=='1')
										window.ParsleyUI.addError(emailField, "emailFieldError", 'Email already registered with us');

								if(data.notValid.cname=='1')
									scrollToDIv('cname');
								else if(data.notValid.email=='1')
										scrollToDIv('email');
							}
						else
						{
							if($('#id').length==0)
							{
								window.location.href=site_url+'guardian/#guardianCreated'; 
							}
							else
							{
								notiPop('success','Caregiver edited successfully','')
								$('#submitBtnCreateGuardian').show();
							}
						}
					}
			});
		}
    });*/

	$('.guardianDelete').click(function(){
			var hfaId=$(this).parents('tr').attr('id');
			var hfaIdSplit=hfaId.split('-');
			var id=hfaIdSplit[1];

			bootbox.dialog({
				message: "Are you sure you wish to delete this caregiver?",
				title: "Delete",
				buttons: {
					  danger: {
						label: "Delete",
						className: "btn-danger",
						callback: function() {

								$.ajax({
					  url:site_url+'guardian/deleteGuardian',
					  type:'post',
					  data:{id:id},
					  success:function(data){
								 notiPop('success','Caregiver deleted successfully',"");
						  		 var guardianTable = $('#guardianList').DataTable();
								  guardianTable.row($('#guardian-'+id)).remove().draw();
							}
					  });
							}
						}
					}
				});
    	});

	$('#changePasswordFormSubmit').click(function(){
			var valid=$('#changePasswordForm').parsley().validate();

			if(valid)
			{
			  var c_passwordField = $('input#c_password').parsley();
			  window.ParsleyUI.removeError(c_passwordField,'c_passwordFieldError');

			  if($('input#c_password').val()!=$('input#password').val())
				  window.ParsleyUI.addError(c_passwordField, "c_passwordFieldError", 'Both the passwords should be equal');
			  else
			  {
				  $('#changePasswordFormSubmit').hide();
				  $('#changePasswordFormProcess').show();
					var formdata=$('#changePasswordForm').serialize();
					$.ajax({
						url:site_url+'account/changePasswordSubmit',
						data:formdata,
						type:'POST',
						success:function(data)
							{
								if(data=='LO')
									redirectToLogin();
								else
								{
								   $('#changePasswordForm')[0].reset();
								   $('#changePasswordFormProcess').hide();
								   $('#changePasswordFormSubmit').show();
									notiPop('success','Password changed successfully',"");
								}
							}
						});
			  }
			}

		});


		$('#filterMatches').click(function () {

			  $('#filtersLoadingDiv').show();
			  $('#infoSidebar').html('');
			  Utility.toggle_rightbar();

			  $.ajax({
				  url:site_url+'sha/filterMatches',
				  type:'POST',
				  data:$('#filterMatchesForm').serialize(),
				  success:function(data)
				  	{
						$('#filtersLoadingDiv').hide();
						$('#infoSidebar').html(data);
						$.material.init();

						$('#filterMatchesEditArrivalDate2').datepicker({
							orientation: "top",
							format:'dd/mm/yyyy',
							autoclose:true
						});
					}
				  });

		});


		$('#infoSidebar').on('click','.filterMatchesEditBtn',function(){
				if($(this).hasClass('filterMatchesEditBtn-arrivalDate'))
					$('.filterMatchesEdit-arrivalDate').slideToggle();
				else if($(this).hasClass('filterMatchesEditBtn-pets'))
					$('.filterMatchesEdit-pets').slideToggle();
				else if($(this).hasClass('filterMatchesEditBtn-wwcc'))
					$('.filterMatchesEdit-wwcc').slideToggle();	
				else if($(this).hasClass('filterMatchesEditBtn-state'))
					$('.filterMatchesEdit-state').slideToggle();	
				else if($(this).hasClass('filterMatchesEditBtn-cApproval'))
					$('.filterMatchesEdit-cApproval').slideToggle();	
				else if($(this).hasClass('filterMatchesEditBtn-child'))
					$('.filterMatchesEdit-child').slideToggle();
				else if($(this).hasClass('filterMatchesEditBtn-smoker'))
					$('.filterMatchesEdit-smoker').slideToggle();
				else if($(this).hasClass('filterMatchesEditBtn-smokerFamily'))
					$('.filterMatchesEdit-smokerFamily').slideToggle();
				else if($(this).hasClass('filterMatchesEditBtn-dietReq'))
					$('.filterMatchesEdit-dietReq').slideToggle();
				else if($(this).hasClass('filterMatchesEditBtn-allergy'))
					$('.filterMatchesEdit-allergy').slideToggle();
				else if($(this).hasClass('filterMatchesEditBtn-disability'))
					$('.filterMatchesEdit-disability').slideToggle();
				else if($(this).hasClass('filterMatchesEditBtn-religion'))
					$('.filterMatchesEdit-religion').slideToggle();
				else if($(this).hasClass('filterMatchesEditBtn-language'))
					$('.filterMatchesEdit-language').slideToggle();
				else if($(this).hasClass('filterMatchesEditBtn-accomodation_type'))
					$('.filterMatchesEdit-accomodation_type').slideToggle();
				else if($(this).hasClass('filterMatchesEditBtn-accomodation_typeRoomType'))
					$('.filterMatchesEdit-accomodation_typeRoomType').slideToggle();
				else if($(this).hasClass('filterMatchesEditBtn-suburb'))
					$('.filterMatchesEdit-suburb').slideToggle();
				else if($(this).hasClass('filterMatchesEditBtn-hostName'))
					$('.filterMatchesEdit-hostName').slideToggle();		
			});

												
												
												
												
	$('#infoSidebar').on('change','#hostName2',function(){
			if($(this).is(':checked'))
			{
				if($('#filterMatchesEditFname2').val()=='' && $('#filterMatchesEditLname2').val()=='')
					$('.filterMatchesEdit-hostName').slideDown();
			}
			else
			$('.filterMatchesEdit-hostName').slideUp();
	});
	
	$('#infoSidebar').on('change','#suburb2',function(){
			if($(this).is(':checked'))
			{
				if($('#filterMatchesEditSuburb2').val()=='')
					$('.filterMatchesEdit-suburb').slideDown();
			}
			else
			$('.filterMatchesEdit-suburb').slideUp();
	});

	$('#infoSidebar').on('change','#arrival_date2',function(){
			if($(this).is(':checked'))
			{
				if($('#filterMatchesEditArrivalDate2').val()=='')
					$('.filterMatchesEdit-arrivalDate').slideDown();
			}
			else
			$('.filterMatchesEdit-arrivalDate').slideUp();
	});

	$('#infoSidebar').on('change','#pets2',function(){
			if($(this).is(':checked'))
			{
				if($('#filterMatchesEditPets2').val()=='')
					$('.filterMatchesEdit-pets').slideDown();
			}
			else
			$('.filterMatchesEdit-pets').slideUp();
	});

	$('#infoSidebar').on('change','#child2',function(){
			if($(this).is(':checked'))
			{
				if($('#filterMatchesEditChild112').val()=='' && $('#filterMatchesEditChild202').val()=='')
					$('.filterMatchesEdit-child').slideDown();
			}
			else
			$('.filterMatchesEdit-child').slideUp();
	});

	$('#infoSidebar').on('change','#smoker2',function(){
			if($(this).is(':checked'))
			{
				if($('#filterMatchesEditSmoker2').val()=='')
					$('.filterMatchesEdit-smoker').slideDown();
			}
			else
			$('.filterMatchesEdit-smoker').slideUp();
	});

	$('#infoSidebar').on('change','#smokerFamily2',function(){
			if($(this).is(':checked'))
			{
				if($('#filterMatchesEditSmokerFamily2').val()=='')
					$('.filterMatchesEdit-smokerFamily').slideDown();
			}
			else
			$('.filterMatchesEdit-smokerFamily').slideUp();
	});

	$('#infoSidebar').on('change','#dietReq2',function(){
			if($(this).is(':checked'))
			{
				if($('#filterMatchesEditDietReq2').val()=='')
					$('.filterMatchesEdit-dietReq').slideDown();
			}
			else
			$('.filterMatchesEdit-dietReq').slideUp();
	});

	$('#infoSidebar').on('change','#allergy2',function(){
			if($(this).is(':checked'))
			{
				if($('#filterMatchesEditAllergy2').val()=='')
					$('.filterMatchesEdit-allergy').slideDown();
			}
			else
			$('.filterMatchesEdit-allergy').slideUp();
	});

	$('#infoSidebar').on('change','#disability2',function(){
			if($(this).is(':checked'))
			{
				if($('#filterMatchesEditDisability2').val()=='')
					$('.filterMatchesEdit-disability').slideDown();
			}
			else
			$('.filterMatchesEdit-disability').slideUp();
	});

	$('#infoSidebar').on('change','#religion2',function(){
			if($(this).is(':checked'))
			{
				if($('#filterMatchesEditReligion2').val()=='')
					$('.filterMatchesEdit-religion').slideDown();
			}
			else
			$('.filterMatchesEdit-religion').slideUp();
	});

	$('#infoSidebar').on('change','#language2',function(){
			if($(this).is(':checked'))
			{
				if($('#filterMatchesEditLanguage2').val()=='')
					$('.filterMatchesEdit-language').slideDown();
			}
			else
			$('.filterMatchesEdit-language').slideUp();
	});


		$('#changeUnavailableToDateSubmit').click(function(){

			$('#hfaUnavailableDateTo').parsley().validate();
			var hfaUnavailableDateToValid= $('#hfaUnavailableDateTo').parsley();

			if ($('#hfaUnavailableDateTo').parsley().isValid())
			{
				if($('#hfaUnavailableDateFrom').val()==$('#hfaUnavailableDateTo').val())
					window.ParsleyUI.addError(hfaUnavailableDateToValid,'dateFromValidError','To date should be greater than from date');
				else
					{
					$('#changeUnavailableToDateSubmit').hide();
					$('#changeUnavailableToDateProcess').show();
					var formdata=$('#model_changeUnavailableToDate_form').serialize();
					 $.ajax({
							  url:site_url+'hfa/changeUnavailableToDateSubmit',
							  type:'post',
							  data:formdata,
							  success:function(data){
									if(data=='LO')
										redirectToLogin();
									else
									  {
										   $('#model_changeUnavailableToDate').modal('toggle');
											$('#changeUnavailableToDateSubmit').show();
											$('#changeUnavailableToDateProcess').hide();
											notiPop('success','Date changed',"")
											window.location.reload();
									  }
									}
							  });
					}
				}

		});


			$('.tab-content').on('click','.editProduct, .editClientProduct',function(){

			  $('#filtersLoadingDiv').show();
			  $('#infoSidebar').html('');
			  Utility.toggle_rightbar();

			  var id=$(this).attr('id');
			  var ids=id.split('-');

			  var url=site_url+'product/editProductForm/'+ids[1];
			  if($(this).attr('class')=='editProductGuardianship')
				   url=site_url+'product/editProductFormGuardianship/'+ids[1]+'/'+ids[2];
			  if($(this).attr('class')=='editClientProduct')
				   url=site_url+'product/editProductForm/'+ids[1]+'/'+ids[2];

			  $.ajax({
				  url:url,
				  success:function(data)
				  	{
						$('#filtersLoadingDiv').hide();
						$('#infoSidebar').html(data).show();
					}
				  });
		});



		$('.tab-content').on('click','.addProductToClient',function(){

			  $('#filtersLoadingDiv').show();
			  $('#infoSidebar').html('');
			  Utility.toggle_rightbar();

			  var id=$(this).attr('id');
			  var ids=id.split('-');

			  var url=site_url+'product/addProductToClient/'+ids[1];
			  $.ajax({
				  url:url,
				  success:function(data)
				  	{
						$('#filtersLoadingDiv').hide();
						$('#infoSidebar').html(data).show();
					}
				  });
		});


		$('#importProductsSubmit').click(function(){

			var importProductsFileText= $('#importProductsFileText').parsley();
			window.ParsleyUI.removeError(importProductsFileText,'importProductsFileTextError');

			$('#importProductsForm').parsley().validate();
			if ($('#importProductsForm').parsley().isValid())
			{
				//alert($('#importProductsFile')+' '+('#importProductsFile'));
				var excelFile=document.getElementById("importProductsFile");
				var $excelFile=$('#importProductsFile');
				if (excelFile.files && excelFile.files[0])
				{
							var exts = ['xls'];
							if(!checkFileExtension($excelFile.val(),exts))
							{
								window.ParsleyUI.addError(importProductsFileText, "importProductsFileTextError", 'Only excel file is allowed.');
								notiPop('error','Only excel file is allowed.',"");
								$excelFile.val('');
								$('#importProductsFileText').val('');
							}
							else
								$('#importProductsForm').submit();
				}
				
			}
		});

		$('#importProductsFile').change(function(){
			setTimeout(function(){
				$('#importProductsForm').parsley().validate();
				},10);
		});


		$('#matchedAppPlaceBookingSubmit').click(function(){
		var valid=$('#matchedAppPlaceBooking_form').parsley().validate();
		if(valid)
		{
			var formdata=$('#matchedAppPlaceBooking_form').serialize();

			var endDateValid= $('#placeBooking_endDate').parsley();
			window.ParsleyUI.removeError(endDateValid,'endDateValidError');

				$('#matchedAppPlaceBookingSubmit').hide();
				$('#matchedAppPlaceBookingProcess').show();

				  $.ajax({
					  url:site_url+'booking/add',
					  type:'post',
					  data:formdata,
					  success:function(data){
						  if(data=='LO')
									redirectToLogin();
						  else if(data=='properDate')
									{
										window.ParsleyUI.addError(endDateValid,'endDateValidError','Enter proper dates');

										$('#matchedAppPlaceBookingProcess').hide();
		    							$('#matchedAppPlaceBookingSubmit').show();
									}
						  else if(data=='notAvail')
									{
										$('#roomsAvailRadioList').hide();
										$('#roomsUnAvailErrorMessage').show();
										$('#matchedAppPlaceBookingProcess').hide();
		    						}
						  else
							{
								  $('#matchedAppPlaceBookingProcess').hide();
								  $('#model_PlaceBookingMatchedApp').modal('toggle');
								  $('#matchedAppPlaceBookingSubmit').show();
								  window.location=site_url+'booking/view/'+data+'#bookingPlaced';
						  }
					  }
					  });
				}
		});


		$('#matchedAppPlaceBookingSubmitCH').click(function(){
		
		$('#errorsCH').hide().text('');	
		var valid=$('#matchedAppPlaceBooking_form').parsley().validate();
		if(valid)
		{
			var formdata=$('#matchedAppPlaceBooking_form').serialize();

			var endDateValid= $('#placeBooking_endDate').parsley();
			window.ParsleyUI.removeError(endDateValid,'endDateValidError');

				$('#matchedAppPlaceBookingSubmitCH').hide();
				$('#matchedAppPlaceBookingProcess').show();

				  $.ajax({
					  url:site_url+'booking/addCH',
					  type:'post',
					  data:formdata,
					  dataType: 'json',
					  success:function(data){
						  if(data.result=='LO')
									redirectToLogin();
						  else if(data.result=='properDate' || data.result=='alreadyBooked' || data.result=='notAvail')
						  {
							  	if(data.result=='properDate')
										window.ParsleyUI.addError(endDateValid,'endDateValidError','Enter proper dates');
									else if(data.result=='alreadyBooked')
										$('#errorsCH').show().text('Student already booked on these dates');
									else if(data.result=='notAvail')
										$('#errorsCH').show().text('This room is not available on these dates');
										
									$('#matchedAppPlaceBookingSubmitCH').show();
									$('#matchedAppPlaceBookingProcess').hide();
						  }
						  else if(data.result=='done')
						  {
							  $('#matchedAppPlaceBookingSubmitCH').show();
							  $('#matchedAppPlaceBookingProcess').hide();
									
							  $('#matchedAppPlaceBooking_form, #model_PlaceBookingMatchedApp .modal-footer').hide();
							  $('#CHB_alerts').show();
							  
							  alertMsg('CHB_alerts','success','Booking placed successfully, click <b><a target="_blank" href="'+site_url+'booking/view/'+data.booking_id+'">here</a></b> to view the booking');
							  if($('#CHB_initial_invoice').is(':checked'))
							  {
								  if(data.hasOwnProperty('initial_invoice'))
								  {
									  var initialInvoice=data.initial_invoice.split('-');
									  alertMsg('CHB_alerts','success','Initial invoice created, click <b><a target="_blank" href="'+site_url+'invoice/view_initial/'+initialInvoice[1]+'">here</a></b> to view the invoice');
								  }
							  }
							  else	
							  {
								  if(data.hasOwnProperty('ongoing_invoice'))
								  {
									  var ongoingInvoice=data.ongoing_invoice.split('-');
									  alertMsg('CHB_alerts','info','Initial invoice not created');
									  if(ongoingInvoice[0]=='done')
										  alertMsg('CHB_alerts','success','Ongoing invoice created, click <b><a target="_blank" href="'+site_url+'invoice/view_ongoing/'+ongoingInvoice[1]+'">here</a></b> to view the invoice');
									  else if(ongoingInvoice[0]=='future')
										  alertMsg('CHB_alerts','info_orange','Ongoing invoice will be created on '+ongoingInvoice[1]);	
								  }
							  }
							  
							  //Study tour booking #STARTS
							  if($('#CHB_studyTourBooking').val()=='1')
							  {
								  alertMsg('CHB_alerts','success','Initial invice is not generated, please refer to the original initial invoice and make changes if required.');	
							  }
							  //Study tour booking #ENDS
						  }
						}
					  });
				}
		});

		
		$('#editBookingSubmit').click(function(){
		var valid=$('#editBooking_form').parsley().validate();
		if(valid)
		{
			var formdataFirst=$('#editBooking_form').serialize();
			var formdataSecond=$('#editBooking_form_second').serialize();
			var formdata=formdataFirst+'&'+formdataSecond
			
			//var formdata=$('#editBooking_form').serialize();

			var endDateValid= $('#placeBooking_endDate').parsley();
			window.ParsleyUI.removeError(endDateValid,'endDateValidError');

				$('#editBookingSubmit').hide();
				$('#editBookingProcess').show();

				  $.ajax({
					  url:site_url+'booking/edit',
					  type:'post',
					  data:formdata,
					  success:function(data){
						  if(data=='LO')
									redirectToLogin();
						 else if(data=='properDate')
							  {
								  window.ParsleyUI.addError(endDateValid,'endDateValidError','Enter proper dates');

								  $('#editBookingProcess').hide();
								  $('#editBookingSubmit').show();
							  }
						  else
							{
								  /*$('#editBookingProcess').hide();
								  $('#model_editBooking').modal('toggle');
								  $('#editBookingSubmit').show();
								  notiPop('success','Booking edited successfully',"");
						  		  var bookingTable = $('#bookingList').DataTable();
								  bookingTable.draw();*/
								  
								  if($('#bookingList').length>0)
								  {
								  	 		var bookingTable = $('#bookingList').DataTable();
								  			bookingTable.draw();
								  }
								  else
										$('#viewBooking_duration').text(data);
										
								  var editBooking_form_msgsP=$('#editBooking_form_msgs > p');
								  $.ajax({
										url:site_url+'booking/afterBookingEdit/'+$('#booking_id').val(),
										type:'post',
										success:function(data){
											if(data=='InvUp')
												editBooking_form_msgsP.text('Previous invoice has been adjusted, it is ready to be transferred to xero.').show();
											else if(data=='InvUpXero')
												editBooking_form_msgsP.text('Previous invoice has been adjusted, you have to manually edit the invoice in Xero.').show();
											else if(data=='InvAdd')
												editBooking_form_msgsP.text('A new invoice has been created, it is ready to be transferred to xero.').show();
											
													$('#editBookingProcess').hide();
								  					//$('#model_editBooking').modal('toggle');
								  					$('#editBookingSubmit').show();
								  					notiPop('success','Booking edited successfully',"");
												}
											});
						  	}
					  }
					  });
				}
		});
		
		
			$('#editBookingSubmitSecond, #editBookingBackSecond').click(function(){
				$('#model_editBooking_second').hide();
				$('#model_editBooking_first').slideDown();
			});
			
		$('#bookingList, #bookingHistoryList').on('click','.bookingDelete',function(){
			var hfaId=$(this).attr('id');
			var hfaIdSplit=hfaId.split('-');
			var id=hfaIdSplit[1];

			bootbox.dialog({
				message: "Are you sure you wish to delete this booking?",
				title: "Delete",
				buttons: {
					  danger: {
						label: "Delete",
						className: "btn-danger",
						callback: function() {

								$.ajax({
					  url:site_url+'booking/deleteBooking',
					  type:'post',
					  data:{id:id},
					  success:function(data){
								 notiPop('success','Booking deleted successfully',"");
								 notiPop('success','Student application moved to Approved paid',"");
								 if($('#bookingList').length>0)
								 {
						  		 	var bookingTable = $('#bookingList').DataTable();
									bookingTable.draw();
								 }
								 else
								 {
								 	var bookingTable = $('#bookingHistoryList').DataTable();
									bookingTable.row( '#booking-'+id ).remove().draw();
								 }
							}
					  });
							}
						}
					}
				});
    	});



		$('#bookingChangeStatusSubmit').click(function(){

			var id=$('#bookingChangeStatus_id').val();
			var statusVal=$('#bookingChangeStatus_status').val();
			var statusText=$('#bookingChangeStatus_status option:selected').text()
			var formdata=$('#bookingChangeStatus_form').serialize();
			
			var proceed=true;
			if(statusVal=='arrived')
			{
				proceed=false;
				$('#bookingChangeStatus_form').parsley().validate();
				if($('#bookingChangeStatus_form').parsley().isValid())
					proceed=true;
			}
			
			if(proceed)
			{
				$('#bookingChangeStatusSubmit').hide();
				$('#bookingChangeStatusProcess').show();
				var pageStatus=$('#pageStatus').val();

				  $.ajax({
					  url:site_url+'booking/changeStatus',
					  type:'post',
					  data:formdata,
					  success:function(data){
						  	  $('#bookingChangeStatusProcess').hide();
							  
							 
								  var bookingTable = $('#bookingList').DataTable();
								  bookingTable.draw(false);
								
							  $('#model_ChangeStatusBooking').modal('toggle');
							  $('#bookingChangeStatusSubmit').show();
							  notiPop('success','Status changed',"Status changed to <b>"+statusText+"</b> successfully.")
							  if(statusVal=='cancelled')
								  notiPop('success',"Student application moved to cancelled successfully",'');
							  if($('#bookingHistoryList').length>0)
							   	shaBookingHistory('status',2);
						  }
					  });
			}
					});


			$('#bookingChangeStatus_form').on('change','#bookingChangeStatus_status',function(){

				$('#bookingChangeStatus_dateDiv').hide();
				if( $(this).val()=='on_hold' || $(this).val()=='cancelled')
				{
					$('#changeStatusCommentDiv').show();

					if($(this).val()=='cancelled')
						$('#bookingChangeStatus_dateDiv').show();
				}
				else
					$('#changeStatusCommentDiv').hide();
				
				if($('#checkupPopContentDiv').length>0)
				{	
					if( $(this).val()=='arrived')	
						{
							$('#bookingChangeStatusNext').show();
							$('#bookingChangeStatusSubmit').hide();
						}
					else	
						{
							$('#bookingChangeStatusNext').hide();
							$('#bookingChangeStatusSubmit').show();
						}
				}
			});


			$("input[name='self_catered']").change(function(){

					var formdata=$('#hfaOfficeUseSelfCateredForm').serialize();
					$.ajax({
					  url:site_url+'hfa/hfaOfficeUseSelfCateredFormSubmit',
					  type:'post',
					  data:formdata,
					  success:function(data){
						   	if(data=='LO')
									redirectToLogin();
							else
							  	 	notiPop('success','Self catered provision updated',"")
						  }
					  });

				});


		 $('.container-fluid').on('click','.deleteInvoiceItem',function(){
		 	var itemId=$(this).parents('tr').attr('id');
			var tableId=$(this).parents('table').attr('id');
			var id=tableId.split('-')[1]
			var invoiceTypePage=$('#invoiceTypePage').val();
			var url=site_url;
			
			if(invoiceTypePage=='po')
			{
				var message="Are you sure you wish to delete this PO item?";
				url +='purchase_orders/deleteItem';
				var tableId='viewPurchase-';
			}
			else
			{
				var message="";
				if($(this).parents('tr').hasClass('accomodationWeekItem'))
					message +="<p class='colorRed' style='font-weight:bold;'>If you delete this accomodation item, you will not be able to add it back. To get it back on invoice you will have to reset the invoice.</p>";	
				message +="Are you sure you wish to delete this invoice item?";
				url +='invoice/deleteInvoiceItem';
				var tableId='viewIntialInvoice-';
			}
			
			bootbox.dialog({
				message: message,
				title: "Delete",
				buttons: {
					  danger: {
						label: "Delete",
						className: "btn-danger",
						callback: function() {

								$.ajax({
					  url:url,
					  type:'post',
					  data:{id:id,itemId:itemId,invoiceType:invoiceTypePage},
					  dataType: 'json',
					  success:function(data){
								notiPop('success','Item deleted successfully',"");

								 $('#'+tableId+id).html($(data.page).find('#'+tableId+id).html());
								 $('#viewIntialInvoiceTotal').html($(data.page).find('#viewIntialInvoiceTotal').html());
							}
					  });
							}
						}
					}
				});
    	});
		
		
		$('.container-fluid').on('click','.deleteOngoingInvoiceItem',function(){
		 	var itemId=$(this).parents('tr').attr('id');
			var tableId=$(this).parents('table').attr('id');
			var id=tableId.split('-')[1]
			var invoiceTypePage=$('#invoiceTypePage').val();

			var message="";
			if($(this).parents('tr').hasClass('accomodationWeekItem'))
				message +="<p class='colorRed' style='font-weight:bold;'>If you delete this accomodation item, you will not be able to add it back. To get it back on invoice you will have to reset the invoice.</p>";	
			message +="Are you sure you wish to delete this invoice item?";
			
			bootbox.dialog({
				message: message,
				title: "Delete",
				buttons: {
					  danger: {
						label: "Delete",
						className: "btn-danger",
						callback: function() {
								$.ajax({
								  url:site_url+'invoice/deleteOngoingInvoiceItem',
								  type:'post',
								  data:{id:id,itemId:itemId,invoiceType:invoiceTypePage},
								  dataType: 'json',
								  success:function(data){
											notiPop('success','Item deleted successfully',"");
			
											 $('#viewIntialInvoice-'+id).html($(data.page).find('#viewIntialInvoice-'+id).html());
											 $('#viewIntialInvoiceTotal').html($(data.page).find('#viewIntialInvoiceTotal').html());
										}
								  });
							}
						}
					}
				});
    	});
		

		$('#addNewInitialInvoiceItemSubmit').click(function(){

				var valid=$('#addNewInitialInvoiceItem_form').parsley().validate();
				if(valid)
				{
					$('#addNewInitialInvoiceItemProcess').show();
					$('#addNewInitialInvoiceItemSubmit').hide();
					var invoice_id=$('#invoice_id').val();

					var formdata=$('#addNewInitialInvoiceItem_form').serialize();
					$.ajax({
						url:site_url+'invoice/addNewInitialInvoiceItemPopContentSubmit',
						type:'post',
						dataType: 'json',
						data:formdata,
						success:function(data){
							     notiPop('success','Item added successfully',"");

								 $('#viewIntialInvoice-'+invoice_id).html($(data.page).find('#viewIntialInvoice-'+invoice_id).html());
								 $('#viewIntialInvoiceTotal').html($(data.page).find('#viewIntialInvoiceTotal').html());

								$('#addNewInitialInvoiceItemProcess').hide();
								$('#addNewInitialInvoiceItemSubmit').show();
								$('#model_addNewInitialInvoiceItem').modal('toggle');
						   }
						});

				}

			});


			$('.container-fluid').on('click','.editInvoiceItem',function(){
		 	var itemId=$(this).parents('tr').attr('id');
			var tableId=$(this).parents('table').attr('id');
			var id=tableId.split('-')[1];
			var invoiceTypePage=$('#invoiceTypePage').val();
			//alert(invoiceTypePage);
			if(invoiceTypePage=='po')
				var url=site_url+'purchase_orders/editItemPopContent/';
			else
				var url=site_url+'invoice/editInitialInvoiceItemPopContent/'+invoiceTypePage;

			  $('#editInitialInvoiceItemProcess').hide();
			  $('#editInitialInvoiceItemSubmit').show();

			  $('#editInitialInvoiceItem_form').html('');
			  $.ajax({
				  url:url,
				  type:'POST',
				  data:{itemId:itemId,id:id},
				  success:function(data)
					  {
						  if(data!='')
							$('#editInitialInvoiceItem_form').html(data);
						else
							$('#model_editInitialInvoiceItem').modal('toggle');
					  }
				  });

    	});


		$('#editInitialInvoiceItemSubmit').click(function(){

				var valid=$('#editInitialInvoiceItem_form').parsley().validate();
				if(valid)
				{
					$('#editInitialInvoiceItemProcess').show();
					$('#editInitialInvoiceItemSubmit').hide();
					var invoice_id=$('#invoice_id').val();

					var formdata=$('#editInitialInvoiceItem_form').serialize();
					$.ajax({
						url:site_url+'invoice/editInitialInvoiceItemPopContentSubmit',
						type:'post',
						dataType: 'json',
						data:formdata,
						success:function(data){
							     notiPop('success','Item edited successfully',"");

								 $('#viewIntialInvoice-'+invoice_id).html($(data.page).find('#viewIntialInvoice-'+invoice_id).html());
								 $('#viewIntialInvoiceTotal').html($(data.page).find('#viewIntialInvoiceTotal').html());

								$('#editInitialInvoiceItemProcess').hide();
								$('#editInitialInvoiceItemSubmit').show();
								$('#model_editInitialInvoiceItem').modal('toggle');
						   }
						});

				}

			});


		$('#moveInitialInvoiceToXeroSubmit').click(function(){
			var invoiceId=$('#moveInitialInvoiceToXero_id').val();
			var moveInitialInvoiceToXero_pageStatus=$('#moveInitialInvoiceToXero_pageStatus').val();
			var moveLink=$('#'+invoiceId).find('.moveInvoiceToXero').parents('li');
			var invoiceIdTd=$('#'+invoiceId+" td:nth-child(1)");
			var invoiceDetailsTd=$('#'+invoiceId+" td:nth-child(4)");
			var invoiceOfficeUseTd=$('#'+invoiceId+" td:nth-child(5)");
			$('#moveInitialInvoiceToXeroSubmit').hide();
			$('#moveInitialInvoiceToXeroProcess').show();

				$.ajax({
										url:site_url+'xero_api/moveInitialInvoiceToXero',
										type:'post',
										data:{invoiceId:invoiceId,pageStatus:moveInitialInvoiceToXero_pageStatus},
										dataType: 'json',
										success:function(data){
												if(data.result=='LO')
													redirectToLogin();
												else if(data.result=='success')
												{
												  invoiceIdTd.html(data.invoiceTd.td1);
												  invoiceDetailsTd.html(data.invoiceTd.td4);
												  invoiceOfficeUseTd.html(data.invoiceTd.td_officeUse);
												  notiPop('success','Invoice moved to xero successfully',"");
				  								  moveLink.remove();
												}
												else if(data.result=='error')
													notiPop('error','Some problem occured, please try after sometime.',"");

												  $('#moveInitialInvoiceToXeroSubmit').show();
									   			  $('#moveInitialInvoiceToXeroProcess').hide();
												  $('#model_moveInitialInvoiceToXero').modal('toggle');

												}
										});

		});
		
		
			$('#moveOngoingInvoiceToXeroSubmit').click(function(){
			var invoiceId=$('#moveInitialInvoiceToXero_id').val();
			var moveLink=$('#'+invoiceId).find('.moveInvoiceToXero').parents('li');
			var invoiceIdTd=$('#'+invoiceId+" td:nth-child(1)");
			var invoiceDetailsTd=$('#'+invoiceId+" td:nth-child(4)");
			var invoiceOfficeUseTd=$('#'+invoiceId+" td:nth-child(5)");
			$('#moveOngoingInvoiceToXeroSubmit').hide();
			$('#moveInitialInvoiceToXeroProcess').show();
			var moveInitialInvoiceToXero_pageStatus=$('#moveInitialInvoiceToXero_pageStatus').val();

				$.ajax({
										url:site_url+'xero_api/moveOngoingInvoiceToXero',
										type:'post',
										data:{invoiceId:invoiceId,pageStatus:moveInitialInvoiceToXero_pageStatus},
										dataType: 'json',
										success:function(data){
												if(data.result=='LO')
													redirectToLogin();
												else if(data.result=='success')
												{
												  invoiceIdTd.html(data.invoiceTd.td1);
												  invoiceDetailsTd.html(data.invoiceTd.td4);
												  invoiceOfficeUseTd.html(data.invoiceTd.td_officeUse);
												  notiPop('success','Invoice moved to xero successfully',"");
				  								  moveLink.remove();
												}
												else if(data.result=='error')
													notiPop('error','Some problem occured, please try after sometime.',"");

												  $('#moveOngoingInvoiceToXeroSubmit').show();
									   			  $('#moveInitialInvoiceToXeroProcess').hide();
												  $('#model_moveInitialInvoiceToXero').modal('toggle');

												}
										});

		});


		$('#moveGroupInitialInvoiceToXeroSubmit').click(function(){
			var invoiceId=$('#moveInitialInvoiceToXero_id').val();
			var moveInitialInvoiceToXero_pageStatus=$('#moveInitialInvoiceToXero_pageStatus').val();
			var moveLink=$('#'+invoiceId).find('.moveInvoiceToXero').parents('li');
			var invoiceIdTd=$('#'+invoiceId+" td:nth-child(1)");
			//var invoiceDetailsTd=$('#'+invoiceId+" td:nth-child(4)");
			var invoiceOfficeUseTd=$('#'+invoiceId+" td:nth-child(4)");
			$('#moveGroupInitialInvoiceToXeroSubmit').hide();
			$('#moveInitialInvoiceToXeroProcess').show();

				$.ajax({
										url:site_url+'xero_api/moveGroupInvInitialInvoiceToXero',
										type:'post',
										data:{invoiceId:invoiceId,pageStatus:moveInitialInvoiceToXero_pageStatus},
										dataType: 'json',
										success:function(data){
												if(data.result=='LO')
													redirectToLogin();
												else if(data.result=='success')
												{
												  invoiceIdTd.html(data.invoiceTd.td1);
												  //invoiceDetailsTd.html(data.invoiceTd.td4);
												  invoiceOfficeUseTd.html(data.invoiceTd.td_officeUse);
												  notiPop('success','Invoice moved to xero successfully',"");
				  								  moveLink.remove();
												}
												else if(data.result=='error')
													notiPop('error','Some problem occured, please try after sometime.',"");

												  $('#moveGroupInitialInvoiceToXeroSubmit').show();
									   			  $('#moveInitialInvoiceToXeroProcess').hide();
												  $('#model_moveInitialInvoiceToXero').modal('toggle');

												}
										});

		});
		
		
		$('#addNewOngoingInvoiceItemSubmit').click(function(){

				var valid=$('#addNewInitialInvoiceItem_form').parsley().validate();
				if(valid)
				{
					$('#addNewInitialInvoiceItemProcess').show();
					$('#addNewOngoingInvoiceItemSubmit').hide();
					var invoice_id=$('#invoice_id').val();

					var formdata=$('#addNewInitialInvoiceItem_form').serialize();
					$.ajax({
						url:site_url+'invoice/addNewOngoingInvoiceItemPopContentSubmit',
						type:'post',
						dataType: 'json',
						data:formdata,
						success:function(data){
							     notiPop('success','Item added successfully',"");

								 $('#viewIntialInvoice-'+invoice_id).html($(data.page).find('#viewIntialInvoice-'+invoice_id).html());
								 $('#viewIntialInvoiceTotal').html($(data.page).find('#viewIntialInvoiceTotal').html());

								$('#addNewInitialInvoiceItemProcess').hide();
								$('#addNewOngoingInvoiceItemSubmit').show();
								$('#model_addNewInitialInvoiceItem').modal('toggle');
						   }
						});

				}

			});
			
			$("input[name='homestayNomination']").click(function(){
				
				if($(this).val()==1){
					
					$(".nominatedfamilyfinfo").slideDown();
				}else{
					$(".nominatedfamilyfinfo").slideUp();
					
				}
				
			})
			
			$("input[name='homestayNomination']").change(function(){
				  $('#homestayNominationBoxSha_alertMsg').hide();
				  //$('#homestayNominationBoxSha').html('');
				  
				  var nominationVal=$(this).val();
				  if(nominationVal=='0')
				  {
					  $('#nominated_hfa_id, #hostfamily_name').val('');
					  
					  var formdata=$('#updateShaHNForm').serialize();
					  $.ajax({
							url:site_url+'sha/homestayNominationSubmit/',
							type:'POST',
							data:formdata,
							dataType: 'json',
							success:function(data)
								{
									if(data.result=='LO')
										redirectToLogin();
								   else
								   {
										notiPop("success","Homestay nomination setting updated","");
										$('#homestayNominationBoxSha').html(data.nominationHistory);
										if(data.alertMessage=='1')
											$('#homestayNominationBoxSha_alertMsg').show();
										else
											$('#homestayNominationBoxSha_alertMsg').hide();	
								   }
								}
							});
				  }
			});
			
			
			$("#nominated_hfa_id").change(function(){
				var hfaId=$(this).val();
				if(hfaId=='')
				{
					$(".nominatedfamilyfinfo").slideUp();
					$('input:radio[name=homestayNomination]')[1].checked = true;
					$('#nominated_hfa_id, #hostfamily_name').val('');
					$("input[name='homestayNomination']").trigger('change');
				}
				else
				{
					if(isNaN(hfaId))
					{
						notiPop('error','Host family not found.',"");
					}
					else
					{
					$.ajax({
						url:site_url+'sha/getnominatedinfo',
						type:'POST',
						data:{hid:hfaId},
						success:function(data)
							{
								if(data !='notid')
								{
									$("#hostfamily_name").val(data);
									var formdata=$('#nominated_hfa_idform').serialize();
									
									$.ajax({
											url:site_url+'sha/NominationfamilySubmit',
											type:'POST',
											data:formdata,
											dataType: 'json',
											success:function(data)
											{
												if(data.result=='LO')
													redirectToLogin();
							   					else
												{
													notiPop("success","Family nominated successfully","");
													$('#homestayNominationBoxSha').html(data.nominationHistory);
													if(data.alertMessage=='1')
													{
														$('#homestayNominationBoxSha_alertMsg').show();
														$("input[name=homestayNomination]").attr('disabled', true);
														$("#nominated_hfa_id").attr('readonly', true);
													}
													else
														$('#homestayNominationBoxSha_alertMsg').hide();	
												}
											}
									});
								}
								else
								{
									$('#nominated_hfa_id, #hostfamily_name').val('');
									notiPop('error','Host family not found.',"");
									$('#nominated_hfa_idform')[0].reset();
								}
							}
						
					});
				}
			}
			});
			
			
			$('#special_request_notes').change(function(){
				
				if($('#updateShaNotesForm').length>0)
				{
					var formdata=$('#updateShaNotesForm').serialize();
					var controller='sha';
				}
				else	
				{
					var formdata=$('#updateHfaNotesForm').serialize();
					var controller='hfa';
				}
				
					
					  $.ajax({
							url:site_url+controller+'/notesSubmit/',
							type:'POST',
							data:formdata,
							success:function(data)
								{
									if(data=='LO')
										redirectToLogin();
								   else
								   {
										notiPop("success","Notes have been updated","");
										var special_request_notes='<p class="pre-wrap" style="margin-bottom:0px;  margin-top:0;">'+$('#special_request_notes').val()+'</p>';
										if($('#special_request_notes').val().trim()=='')
											special_request_notes='<p>Not available</p>';
										$('#profile_internal_notes').html(special_request_notes);
										
								   }
								}
							});
			});
			
			$('#notes_family').change(function(){
				
					var formdata=$('#updateHfaNotesFamilyForm').serialize();
					var controller='hfa';
				
					 $.ajax({
							url:site_url+controller+'/notesFamilySubmit/',
							type:'POST',
							data:formdata,
							success:function(data)
								{
									if(data=='LO')
										redirectToLogin();
								   else
										notiPop("success","Family notes have been updated","");
								}
							});
			});
			
			
			$('#movePoToXeroSubmit').click(function(){
			var invoiceId=$('#movePoToXero_id').val();
			var movePoToXero_pageStatus=$('#movePoToXero_pageStatus').val();
			var moveLink=$('#'+invoiceId).find('.movePoToXero').parents('li');
			var invoiceIdTd=$('#'+invoiceId+" td:nth-child(1)");
			var invoiceDetailsTd=$('#'+invoiceId+" td:nth-child(4)");
			var invoiceOfficeUseTd=$('#'+invoiceId+" td:nth-child(5)");
			$('#movePoToXeroSubmit').hide();
			$('#movePoToXeroProcess').show();
			
			  $.ajax({
								  url:site_url+'xero_api/movePoToXero',
								  type:'post',
								  data:{poId:invoiceId,pageStatus:movePoToXero_pageStatus},
								  dataType: 'json',
								  success:function(data){
										  if(data.result=='LO')
											  redirectToLogin();
										  else if(data.result=='error')
										  {
											  $('#model_movePoToXeroContentMove').hide();
											  $('#model_movePoToXeroContentError .modal-body').html('Some problem occured, please try after sometime.');
											  $('#model_movePoToXeroContentError').show();
											}
  										  else if(data.result=='noBankDetails')
										  {
											  $('#model_movePoToXeroContentMove').hide();
											  $('#model_movePoToXeroContentError .modal-body').html('Enter bank details in host family profile.');
											  $('#model_movePoToXeroContentError').show();
										  }
										  else if(data.result=='success')
										  {
											  $('#model_movePoToXeroContentMove').show();
											  $('#model_movePoToXeroContentError .modal-body').html('');
											  $('#model_movePoToXeroContentError').hide();
											  
											  invoiceIdTd.html(data.poTd.td1);
											  invoiceDetailsTd.html(data.poTd.td4);
											  invoiceOfficeUseTd.html(data.poTd.td_officeUse);
											  notiPop('success','Purchase order moved to xero successfully',"");
											  moveLink.remove();
											  $('#model_movePoToXero').modal('toggle');
										  }
										  else
										  {
											  $('#model_movePoToXero').modal('toggle');
											  window.location.reload();
											}
							
										$('#movePoToXeroSubmit').show();
										$('#movePoToXeroProcess').hide();	  
  										}
								});

		});	
		
		
		
		$('a#poFiltersBtn').click(function () {

		  $('#filtersLoadingDiv').show();
		  $('#infoSidebar').html('');
		  Utility.toggle_rightbar();

		  var filterData=$('#poFiltersFormHidden').serialize();
		  $.ajax({
			  url:site_url+'purchase_orders/filters',
			  type:'POST',
			  data:filterData,
			  success:function(data)
				  {
					  $('#filtersLoadingDiv').hide();
					  $('#infoSidebar').html(data);
					  
					  $('#poFrom,#poTo,#poDueDate').datepicker({
							orientation: "top",
							format:'dd/mm/yyyy',
							autoclose:true
						});
						
				  }
			  });
		});
		
		
		
		$("input[name='guardianship'], #officeUse-guardian_assigned").change(function(){
				  
				  var field=$(this).attr('name');
				  if(field=='guardianship')
				  {
					  if($(this).val()=='0')
					  {
						  $('#officeUse-guardian_assignedDiv').slideUp();
						  $('#officeUse-guardian_assigned').val('');
					  }
					  else if($(this).val()=='1')
					      $('#officeUse-guardian_assignedDiv').slideDown();
				  }
				  
				  var formdata=$('#guardianshipOfficeUseFormSubmit').serialize();
			
				  $.ajax({
						url:site_url+'sha/guardianshipOfficeUseFormSubmit/'+field,
						type:'POST',
						data:formdata,
						dataType:'json',
						success:function(data)
							{
							   if(data.result=='LO')
										redirectToLogin();
							   else
							   {
								   if(data.hasOwnProperty('appPageNotiHtml'))
									    $( "#shaAppPageNotiLi" ).replaceWith( data.appPageNotiHtml );
								   
								   if(field=='guardianship')
										notiPop("success","Caregiving setting updated","");
									else if(field=='guardian_assigned')
									{
										notiPop("success","Caregiver assigned successfully","");
										$.ajax({
													url: site_url+'caregiver/getCGDetailsDiv/',
													type:'POST',
													data:formdata,
													success: function(data2){
														$("#careGiverDiv").html(data2).show();
													}
												});
									}
							   }
							}
						});
			});
		
		
		$("#officeUse-guardianship_startDate, #officeUse-guardianship_endDate").change(function(){		 
				  var formdata=$('#guardianshipOfficeUseFormSubmit').serialize();
			
				  $.ajax({
						url:site_url+'sha/guardianshipOfficeUseDurationSubmit',
						type:'POST',
						data:formdata,
						dataType:'json',
						success:function(data)
							{
							   if(data.result=='LO')
										redirectToLogin();
							   else
							   {
								  if(data.hasOwnProperty('appPageNotiHtml'))
									    $( "#shaAppPageNotiLi" ).replaceWith( data.appPageNotiHtml );
								  $('#officeUse-guardianshipDurationText').text(data.durationText);
								  notiPop("success","Caregiving date updated","");
								  
								  if($('#accomodation_typeGOUFS').val()=='7')
								  {
									  $('#shaBooking_startDate').val($('#officeUse-guardianship_startDate').val());
									  $('#shaBooking_endDate').val($('#officeUse-guardianship_endDate').val());
								  }
								}
							}
						});
			});
		
		
	$('#submitBtnCreateApuCompany').on('click', function () {

		var cnameField = $('input#cname').parsley();
		var emailField = $('input#email').parsley();

		window.ParsleyUI.removeError(cnameField,'cnameFieldError');
		window.ParsleyUI.removeError(emailField,'emailFieldError');


        var valid=$('#formCreateApuCompany').parsley().validate();

		if(valid)
		{
			$('#submitBtnCreateApuCompany').hide();
			$('#formCreateApuCompanyProcess').show();
			$.ajax({
				url:site_url+'apu_company/createSubmit',
				type:'POST',
				data:$('#formCreateApuCompany').serialize(),
				dataType: 'json',
				success:function(data)
					{
						$('#formCreateApuCompanyProcess').hide();

						if(data.hasOwnProperty('logout'))
							redirectToLogin();
						else if(data.hasOwnProperty('notValid'))
							{
								$('#submitBtnCreateApuCompany').show();

								if(data.notValid.cname=='1')
									window.ParsleyUI.addError(cnameField, "cnameFieldError", 'Company name already registered with us');
								if(data.notValid.email=='1')
										window.ParsleyUI.addError(emailField, "emailFieldError", 'Email already registered with us');
							}
						else
						{
							if($('#id').length==0)
								window.location.href=site_url+'apu_company/#apuCreated';
							else
							{
								notiPop('success','APU edited successfully','')
								$('#submitBtnCreateApuCompany').show();
							}
						}
					}
			});
		}
    });
	
	
	$('.apuCompanyDelete').click(function(){
			var hfaId=$(this).parents('tr').attr('id');
			var hfaIdSplit=hfaId.split('-');
			var id=hfaIdSplit[1];

			bootbox.dialog({
				message: "Are you sure you wish to delete this APU company?",
				title: "Delete",
				buttons: {
					  danger: {
						label: "Delete",
						className: "btn-danger",
						callback: function() {

								$.ajax({
					  url:site_url+'apu_company/deleteGuardian',
					  type:'post',
					  data:{id:id},
					  success:function(data){
								 notiPop('success','APU company deleted successfully',"");
						  		 var apuCompanyTable = $('#apuCompanyList').DataTable();
								  apuCompanyTable.row($('#apuCompany-'+id)).remove().draw();
							}
					  });
							}
						}
					}
				});
    	});
		
		
		$('a#tourListFiltersBtn').click(function () {

			  $('#filtersLoadingDiv').show();
			  $('#infoSidebar').html('');
			  Utility.toggle_rightbar();

			  var filterData=$('#tourListFiltersFormHidden').serialize();
			  $.ajax({
				  url:site_url+'tour/listFilters',
				  type:'POST',
				  data:filterData,
				  success:function(data)
					  {
						  $('#filtersLoadingDiv').hide();
						  $('#infoSidebar').html(data);
					  }
				  });
			  });
			  
			  
			  
		$('a#bookingListFiltersBtn').click(function () {

			  $('#filtersLoadingDiv').show();
			  $('#infoSidebar').html('');
			  Utility.toggle_rightbar();

			  var filterData=$('#bookingFiltersFormHidden').serialize();
			  $.ajax({
				  url:site_url+'booking/filters',
				  type:'POST',
				  data:filterData,
				  success:function(data)
					  {
						  $('#filtersLoadingDiv').hide();
						  $('#infoSidebar').html(data);
					  }
				  });
			  });
			  $('a#bookingsortListFiltersBtn').click(function () {

			  $('#filtersLoadingDiv').show();
			  $('#infoSidebar').html('');
			  Utility.toggle_rightbar();

			  var filterData=$('#bookingsortFiltersFormHidden').serialize();
			  $.ajax({
				  url:site_url+'booking/sortfilters',
				  type:'POST',
				  data:filterData,
				  success:function(data)
					  {
						  $('#filtersLoadingDiv').hide();
						  $('#infoSidebar').html(data);
					  }
				  });
			  });
			  
			  
		$('a#invoiceFiltersBtn, a#GroupInvoiceFiltersBtn').click(function () {

			  $('#filtersLoadingDiv').show();
			  $('#infoSidebar').html('');
			  Utility.toggle_rightbar();

			  if($(this).attr('id')=='invoiceFiltersBtn')
					var controller='invoice';
			  else if($(this).attr('id')=='GroupInvoiceFiltersBtn')
					var controller='group_invoice';	
			
			  var filterData=$('#invoiceFiltersFormHidden').serialize();
			  $.ajax({
				  url:site_url+controller+'/filters',
				  type:'POST',
				  data:filterData,
				  success:function(data)
					  {
						  $('#filtersLoadingDiv').hide();
						  $('#infoSidebar').html(data);
					  }
				  });
			  });	
			  
			  
			  
			$('#moveOngoingInvoiceToXeroSubmitPage').click(function(){
				var invoiceId=$('#moveInitialInvoiceToXero_id').val();
				var moveLink=$('#moveInitialInvoiceToXero');
				
				$('#moveOngoingInvoiceToXeroSubmitPage').hide();
				$('#moveInitialInvoiceToXeroProcess').show();
				var moveInitialInvoiceToXero_Page=$('#moveInitialInvoiceToXero_Page').val();
				if(moveInitialInvoiceToXero_Page=='initial')
					var moveInitialInvoiceToXero_url='xero_api/moveInitialInvoiceToXero';
				else if(moveInitialInvoiceToXero_Page=='groupInvInitial')
					var moveInitialInvoiceToXero_url='xero_api/moveGroupInvInitialInvoiceToXero';	
				else
					var moveInitialInvoiceToXero_url='xero_api/moveOngoingInvoiceToXero';
				
				$.ajax({
								url:site_url+moveInitialInvoiceToXero_url,
								type:'post',
								data:{invoiceId:invoiceId,pageStatus:'1'},
								dataType: 'json',
								success:function(data){
										if(data.result=='LO')
											redirectToLogin();
										else if(data.result=='success')
										{
										  notiPop('success','Invoice moved to xero successfully',"");
										  moveLink.remove();
										  $('#invoicePageXeroStatus').html(data.xero_status);
										  $('.showOnMovedToXero').show();
										}
										else if(data.result=='error')
											notiPop('error','Some problem occured, please try after sometime.',"");
	
										  $('#moveOngoingInvoiceToXeroSubmitPage').show();
										  $('#moveInitialInvoiceToXeroProcess').hide();
										  $('#model_moveInitialInvoiceToXero').modal('toggle');
	
										}
								});
				});
				
				
			$('#initialInvoiceUpdateDuration').click(function(){
				
					$('#initialInvoiceUpdateDuration').hide();
					$('#initialInvoiceUpdateDurationProcess').show();
					var study_tour=$('#initialInvoiceUpdateDurationForm input[name=study_tour]').val();
					if(study_tour==1)
						var url='tour/initialInvoiceUpdateDuration';
					else
						var url='invoice/initialInvoiceUpdateDuration';
					
					var formdata=$('#initialInvoiceUpdateDurationForm').serialize();
					$.ajax({
							url:site_url+url,
							type:'POST',
							data:formdata,
							success:function(data)
								{
									window.location.reload();
								}
						});
				
			});
			
			
			
			$('#resetInitialInvoiceSubmit').click(function(){
					var studyTour=$('#resetInitialInvoiceTour').val();
					if(studyTour==1)
						var url='tour/resetInitialInvoice/';
					else	
						var url='invoice/resetInitialInvoice/';
					url +=$('#resetInitialInvoiceId').val();
						
					$('#resetInitialInvoiceProcess').show();
					$('#resetInitialInvoiceSubmit').hide();
					
					$.ajax({
							url:site_url+url,
							type:'POST',
							success:function(data)
								{
									window.location.reload();
								}
						});
				});
				
			$('#resetOngoingInvoiceSubmit').click(function(){
					var studyTour=$('#resetOngoingInvoiceTour').val();
					if(studyTour==1)
						var url='tour/resetOngoingInvoice/';
					else	
						var url='invoice/resetOngoingInvoice/';
					url +=$('#resetOngoingInvoiceId').val();
						
					$('#resetOngoingInvoiceProcess').show();
					$('#resetOngoingInvoiceSubmit').hide();
					
					$.ajax({
							url:site_url+url,
							type:'POST',
							success:function(data)
								{
									window.location.reload();
								}
						});
				});
				
				
				
				$('#ongoingInvoiceUpdateDuration').click(function(){
				
					$('#ongoingInvoiceUpdateDuration').hide();
					$('#initialInvoiceUpdateDurationProcess').show();
					var study_tour=$('#initialInvoiceUpdateDurationForm input[name=study_tour]').val();
					if(study_tour==1)
						var url='tour/ongoingInvoiceUpdateDuration';
					else
						var url='invoice/ongoingInvoiceUpdateDuration';
					
					var formdata=$('#initialInvoiceUpdateDurationForm').serialize();
					$.ajax({
							url:site_url+url,
							type:'POST',
							data:formdata,
							success:function(data)
								{
									window.location.reload();
								}
						});
				
			});
			
			
				$('.container-fluid').on('click','.editOngoingInvoiceItem',function(){
		 	var itemId=$(this).parents('tr').attr('id');
			var tableId=$(this).parents('table').attr('id');
			var id=tableId.split('-')[1];
			//alert(itemId+' '+id);

			  $('#editInitialInvoiceItemProcess').hide();
			  $('#editOngoingInvoiceItemSubmit').show();

			  $('#editInitialInvoiceItem_form').html('');
			  $.ajax({
				  url:site_url+'invoice/editOngoingInvoiceItemPopContent/',
				  type:'POST',
				  data:{itemId:itemId,id:id},
				  success:function(data)
					  {
						  if(data!='')
							$('#editInitialInvoiceItem_form').html(data);
						else
							$('#model_editInitialInvoiceItem').modal('toggle');
					  }
				  });

    	});
		
		
		$('#editOngoingInvoiceItemSubmit').click(function(){

				var valid=$('#editInitialInvoiceItem_form').parsley().validate();
				if(valid)
				{
					$('#editInitialInvoiceItemProcess').show();
					$('#editOngoingInvoiceItemSubmit').hide();
					var invoice_id=$('#invoice_id').val();

					var formdata=$('#editInitialInvoiceItem_form').serialize();
					$.ajax({
						url:site_url+'invoice/editOngoingInvoiceItemPopContentSubmit',
						type:'post',
						dataType: 'json',
						data:formdata,
						success:function(data){
							     notiPop('success','Item edited successfully',"");

								 $('#viewIntialInvoice-'+invoice_id).html($(data.page).find('#viewIntialInvoice-'+invoice_id).html());
								 $('#viewIntialInvoiceTotal').html($(data.page).find('#viewIntialInvoiceTotal').html());

								$('#editInitialInvoiceItemProcess').hide();
								$('#editOngoingInvoiceItemSubmit').show();
								$('#model_editInitialInvoiceItem').modal('toggle');
						   }
						});

				}

			});


			$('.container-fluid').on('click','.editGroupInvoiceItem',function(){
		 	var itemId=$(this).parents('tr').attr('id');
			var tableId=$(this).parents('table').attr('id');
			var id=tableId.split('-')[1];
			//alert(itemId+' '+id);

			  $('#editInitialInvoiceItemProcess').hide();
			  $('#editInitialGroupInvoiceItemSubmit').show();

			  $('#editInitialInvoiceItem_form').html('');
			  $.ajax({
				  url:site_url+'group_invoice/editInitialInvoiceItemPopContent/',
				  type:'POST',
				  data:{itemId:itemId,id:id},
				  success:function(data)
					  {
						  if(data!='')
							$('#editInitialInvoiceItem_form').html(data);
						else
							$('#model_editInitialInvoiceItem').modal('toggle');
					  }
				  });

    	});
		
		
		


		$('#editInitialGroupInvoiceItemSubmit').click(function(){

				var valid=$('#editInitialInvoiceItem_form').parsley().validate();
				if(valid)
				{
					$('#editInitialInvoiceItemProcess').show();
					$('#editInitialGroupInvoiceItemSubmit').hide();
					var invoice_id=$('#invoice_id').val();

					var formdata=$('#editInitialInvoiceItem_form').serialize();
					$.ajax({
						url:site_url+'group_invoice/editInitialGroupInvoiceItemPopContentSubmit',
						type:'post',
						dataType: 'json',
						data:formdata,
						success:function(data){
							     notiPop('success','Item edited successfully',"");

								 $('#viewIntialInvoice-'+invoice_id).html($(data.page).find('#viewIntialInvoice-'+invoice_id).html());
								 $('#viewIntialInvoiceTotal').html($(data.page).find('#viewIntialInvoiceTotal').html());

								$('#editInitialInvoiceItemProcess').hide();
								$('#editInitialGroupInvoiceItemSubmit').show();
								$('#model_editInitialInvoiceItem').modal('toggle');
						   }
						});

				}

			});	
			
			
			$('#resetGroupInvoiceSubmit').click(function(){
					
					var url='group_invoice/resetInvoice/';
					var resetGroupInvoiceId=$('#resetGroupInvoiceId').val();
						
					$('#resetGroupInvoiceProcess').show();
					$('#resetGroupInvoiceSubmit').hide();
					
					$.ajax({
							url:site_url+url,
							type:'POST',
							data:{resetGroupInvoiceId:resetGroupInvoiceId},
							success:function(data)
								{
									window.location.reload();
								}
						});
				});
				
		$('#trigger-search').click(function(){
				$('#headerSearchDropdown').show();
			});
					
		$('#trigger-search-close').click(function(){
				$('#headerSearchDropdown').hide();
			});
		
		$('#headerSearchDropdown ul>li>a').click(function(){
				$('#headerSearchDropdownText').text($(this).text());
			});
			
			
		$('#editPoItemSubmit').click(function(){

				var valid=$('#editInitialInvoiceItem_form').parsley().validate();
				if(valid)
				{
					$('#editInitialInvoiceItemProcess').show();
					$('#editPoItemSubmit').hide();
					var invoice_id=$('#po_id').val();
					var itemId=$('#itemId').val();

					var formdata=$('#editInitialInvoiceItem_form').serialize();
					$.ajax({
						url:site_url+'purchase_orders/editPoItemPopContentSubmit',
						type:'post',
						dataType: 'json',
						data:formdata,
						success:function(data){
							     notiPop('success','Item edited successfully',"");

								 $('#viewPurchase-'+invoice_id).html($(data.page).find('#viewPurchase-'+invoice_id).html());
								 $('#viewIntialInvoiceTotal').html($(data.page).find('#viewIntialInvoiceTotal').html());
								 //$('#iI_'+itemId).html($(data.page).find('#iI_'+itemId).html());

								$('#editInitialInvoiceItemProcess').hide();
								$('#editPoItemSubmit').show();
								$('#model_editInitialInvoiceItem').modal('toggle');
						   }
						});

				}

			});	
			
			
		$('#addNewPoItemSubmit').click(function(){

				var valid=$('#addNewInitialInvoiceItem_form').parsley().validate();
				if(valid)
				{
					$('#addNewInitialInvoiceItemProcess').show();
					$('#addNewPoItemSubmit').hide();
					var po_id=$('#po_id').val();

					var formdata=$('#addNewInitialInvoiceItem_form').serialize();
					$.ajax({
						url:site_url+'purchase_orders/addNewPoItemPopContentSubmit',
						type:'post',
						dataType: 'json',
						data:formdata,
						success:function(data){
							     notiPop('success','Item added successfully',"");

								 $('#viewPurchase-'+po_id).html($(data.page).find('#viewPurchase-'+po_id).html());
								 $('#viewIntialInvoiceTotal').html($(data.page).find('#viewIntialInvoiceTotal').html());

								$('#addNewInitialInvoiceItemProcess').hide();
								$('#addNewPoItemSubmit').show();
								$('#model_addNewInitialInvoiceItem').modal('toggle');
						   }
						});

				}

			});
			
		
		$('#hfaCallLog_submit').click(function(){
			
			$('#hfaCallLog_form').parsley().validate();

			if ($('#hfaCallLog_form').parsley().isValid())
				{	
					$('#hfaCallLog_submit').hide();
					$('#hfaCallLog_process').show();
					
					var callLogData=$('#hfaCallLog_form').serialize();
					$.ajax({
						url:site_url+'hfa/addCallLog',
						type:'POST',
						data:callLogData,
						success:function(data){
							if(data=='LO')
									redirectToLogin();
							else
							  {
									$('#callLog').html(data);
									notiPop('success','Call log added successfully',"");
									
									$('#hfaCallLog_form')[0].reset();
									$('#model_hfaCallLog').modal('toggle');
									$('#hfaCallLog_submit').show();
									$('#hfaCallLog_process').hide();
							  }
						}
					});
				}
		});
		
		
		$('#hfaRevisitPop_submit').click(function(){
			
			$('#hfaRevisitPop_form').parsley().validate();

			if ($('#hfaRevisitPop_form').parsley().isValid())
				{	
					var id=$('#hfaRevisitPop_hfaId').val();
					$('#hfaRevisitPop_submit').hide();
					$('#hfaRevisitPop_process').show();
					
					var callLogData=$('#hfaRevisitPop_form').serialize();
					$.ajax({
						url:site_url+'hfa/revisitInfoSubmit',
						type:'POST',
						data:callLogData,
						success:function(data){
							if(data=='LO')
									redirectToLogin();
							else
							  {
								  if(data=='done')
								  {
									$('#revistPopLink_'+id).remove()
									notiPop('success','Revisit information has been submitted successfully',"");
								  }
									$('#hfaRevisitPop_form')[0].reset();
									$('#model_hfaRevisitPop').modal('toggle');
									$('#hfaRevisitPop_submit').show();
									$('#hfaRevisitPop_process').hide();
							  }
						}
					});
				}
		});
		
		
		$('#submitBtnCGC').on('click', function () {

		var cnameField = $('input#CGCname').parsley();
		
		window.ParsleyUI.removeError(cnameField,'cnameFieldError');
		
        var valid=$('#formCreateCGCompany').parsley().validate();

		if(valid)
		{
			$('#submitBtnCGC').hide();
			$('#submitBtnCGCProcess').show();
			$.ajax({
				url:site_url+'caregiver/create_companySubmit',
				type:'POST',
				data:$('#formCreateCGCompany').serialize(),
				dataType: 'json',
				success:function(data)
					{
						$('#submitBtnCGCProcess').hide();

						if(data.hasOwnProperty('logout'))
							redirectToLogin();
						else if(data.hasOwnProperty('notValid'))
							{
								$('#submitBtnCreateGuardian').show();

								if(data.notValid.cname=='1')
								{
									window.ParsleyUI.addError(cnameField, "cnameFieldError", 'Company name already registered with us');
									scrollToDIv('CGCname');
									$('#submitBtnCGC').show();
									$('#submitBtnCGCProcess').hide();
								}
							}
						else
						{
							if($('#id').length==0)
							{
								window.location.href=site_url+'caregiver/#CGCCreated'; 
							}
							else
							{
								notiPop('success','Caregiver company edited successfully','')
								$('#submitBtnCGC').show();
							}
						}
					}
			});
		}
    });
	
	
	$('#addCG_submit').click(function(){
		
		var valid=$('#model_addCG_form').parsley().validate();
		if(valid)
			{
				$('#addCG_process').show();
		 		$('#addCG_submit').hide();
		 
				$.ajax({
						url:site_url+'caregiver/addCG',
						type:'POST',
						data:$('#model_addCG_form').serialize(),
						success:function(data)
							{
									if(data=='LO')
											redirectToLogin();
									else
									  {
										  window.location.href=site_url+'caregiver/manage/'+$('#company_id').val()+'#CGCreated';
										  window.location.reload();
									  }
							}
					});
			}
		
	});
	
	
	$('#editCG_submit').click(function(){
		
		var valid=$('#model_editCG_form').parsley().validate();
		if(valid)
			{
				$('#editCG_process').show();
		 		$('#editCG_submit').hide();
				var caregiver_id=$('#caregiver_id').val();
				
				$.ajax({
						url:site_url+'caregiver/editCG',
						type:'POST',
						data:$('#model_editCG_form').serialize(),
						dataType: 'json',
						success:function(data)
							{
									if(data.hasOwnProperty('logout'))
										redirectToLogin();
									else
									{
										$('#editCG_process').hide();
								 		$('#editCG_submit').show();
										$('#model_editCaregiver').modal('toggle');
										$('#caregiver-'+caregiver_id+' > .caregiver-td1').html(data.tdHtml.td1);
										notiPop('success',"Caregiver edited successfully",'');
									}	
							}
					});
			}
		
	});
	
	$('.cgDelete').click(function(){
		
				var idSplit=$(this).attr('id').split('-');
				bootbox.dialog({
				message: "Are you sure you wish to delete this caregiver?",
				title: "Delete",
				buttons: {
					  danger: {
						label: "Delete",
						className: "btn-danger",
						callback: function() {

								$.ajax({
								  url:site_url+'caregiver/deleteCG',
								  type:'post',
								  data:{id:idSplit[1]},
								  success:function(data){
									  		if(data=='LO')
												redirectToLogin();
											else
											{
												 notiPop('success','Caregiver deleted successfully',"");
												 var oTableGuardian = $('#manageCaregivers').DataTable();
												  oTableGuardian.row($('#caregiver-'+idSplit[1])).remove().draw();
											}
										}
					 			 });
							}
						}
					}
				});
			
				
	});
	
	$('.CGCompanyDelete').click(function(){
		
			var idSplit=$(this).attr('id').split('-');
				bootbox.dialog({
				message: "Are you sure you wish to delete this caregiver company?",
				title: "Delete",
				buttons: {
					  danger: {
						label: "Delete",
						className: "btn-danger",
						callback: function() {

								$.ajax({
								  url:site_url+'caregiver/deleteCompany',
								  type:'post',
								  data:{id:idSplit[1]},
								  success:function(data){
									  		if(data=='LO')
												redirectToLogin();
									  		else if(data=='done')
												{
													 notiPop('success','Caregiver company deleted successfully',"");
													 var oTableGuardian = $('#guardianList').DataTable();
													  oTableGuardian.row($('#CGCompany-'+idSplit[1])).remove().draw();
												}
										}
					 			 });
							}
						}
					}
				});
		
	});
	
	
	$("input[name='revisit_duration']").change(function(){

					var formdata=$('#hfaOfficeUseRevisitDurationForm').serialize();
					$.ajax({
					  url:site_url+'hfa/hfaOfficeUseRevisitDurationFormSubmit',
					  type:'post',
					  data:formdata,
					  success:function(data){
						   	if(data=='LO')
									redirectToLogin();
							else
							  	 	notiPop('success','Revisit duration updated',"")
						  }
					  });

				});
			
		
		$('#hfaAddNewVisit_submit').click(function(){
			
			$('#hfaAddNewVisit_form').parsley().validate();

			if ($('#hfaAddNewVisit_form').parsley().isValid())
				{	
					$('#hfaAddNewVisit_submit').hide();
					$('#hfaAddNewVisit_process').show();
					
					var callLogData=$('#hfaAddNewVisit_form').serialize();
					$.ajax({
						url:site_url+'hfa/addNewVisit',
						type:'POST',
						data:callLogData,
						success:function(data){
							if(data=='LO')
									redirectToLogin();
							else
							  {
									$('#visits').html(data);
									notiPop('success','New visit added successfully',"");
									
									$('#hfaAddNewVisit_form')[0].reset();
									$('#model_hfaVisits').modal('toggle');
									$('#hfaAddNewVisit_submit').show();
									$('#hfaAddNewVisit_process').hide();
							  }
						}
					});
				}
		});
		
		$('#vr_Submit').click(function(){
		
			$('#vr_SubmitProcess').show();
			$('#vr_Submit').hide();
			var formdata=$('#vr_Form').serialize();
			
			var vrHash='#visitReport'+$('#vr_createUpdate').val();
			
			$.ajax({
				url:site_url+'hfa/visitReport_submit',
				type:'POST',
				data:formdata,
				success:function(data){
					if(data=='LO')
						redirectToLogin();
					else
						window.location.href=site_url+'hfa/application/'+$('#vr_hfa_id').val()+'/'+vrHash;
				}
			});
		
	});
	
	
	$('#addCApproval_date').datepicker({
			todayHighlight: true,
			format:'dd/mm/yyyy',
			autoclose:true
		});
	
	$('#addCApprovalSubmit').click(function(){
		var valid=$('#addCApprovalForm').parsley().validate();
		if(valid)
		{
			$('#addCApprovalSubmit').hide();
			$('#addCApprovalProcess').show();
			var formdata=$('#addCApprovalForm').serialize();
			$.ajax({
				url:site_url+'hfa/addCApprovalSubmit',
				type:'POST',
				data:formdata,
				success:function(data)
					{
							if(data=='LO')
									redirectToLogin();
							else
							  {
									$('#cApprovalList').html(data);
									notiPop('success','College approval added successfully',"");
									
									$('#addCApprovalForm')[0].reset();
									$('#model_addCApproval').modal('toggle');
									$('#addCApprovalSubmit').show();
									$('#addCApprovalProcess').hide();
							  }
					}
			});
		}
	});
			
		
		$('#bookIncident_submit, #editIncidentSubmit').click(function(){
			
			$('#bookIncident_form').parsley().validate();

			if ($('#bookIncident_form').parsley().isValid())
				{	
					if($(this).attr('id')=='bookIncident_submit')
					{
						var submitType='add';
						var submitBtn=$('#bookIncident_submit');
						var submitBtnProcess=$('#bookIncident_process');
					}
					else
					{
						var submitType='edit';
						var submitBtn=$('#editIncidentSubmit');
						var submitBtnProcess=$('#editIncidentSubmitProcess');
					}
					
					submitBtn.hide();
					submitBtnProcess.show();
					
					var incidentData=$('#bookIncident_form').serialize();
					$.ajax({
						url:site_url+'booking/addNewIncident',
						type:'POST',
						data:incidentData,
						dataType: 'json',
						success:function(data){
							if(data.hasOwnProperty('logout'))
									redirectToLogin();
							else
							  {
									$('#incidents').html(data.incidents);
									initializeToolTip();
									if(submitType=='add' && $('#bookingIncident_id').val()=='')
										notiPop('success','New incident added successfully',"");
									else	if(submitType=='edit')
										notiPop('success','Incident edited successfully',"");
									
									submitBtn.show();
									submitBtnProcess.hide();
									if(submitType=='add')
									{
										$('#model_bookingIncident_content').hide();
										$("#model_bookingIncident_second").slideDown();
									}
									else
									{
										$('#bookIncident_form')[0].reset();
										$('#model_bookingIncident').modal('toggle');
									}
									$('#bookingIncident_id, #bookingIncident_idSecond').val(data.incident_id);
							  }
						}
					});
				}
		});
			
		
		$('#bookIncidentFollowUp_submit').click(function(){
			
			$('#bookIncidentFollowUp_form').parsley().validate();

			if ($('#bookIncidentFollowUp_form').parsley().isValid())
				{	
					$('#bookIncidentFollowUp_submit').hide();
					$('#bookIncidentFollowUp_process').show();
					
					var incidentData=$('#bookIncidentFollowUp_form').serialize();
					$.ajax({
						url:site_url+'booking/addNewIncidentFollowUp',
						type:'POST',
						data:incidentData,
						success:function(data){
							if(data=='LO')
									redirectToLogin();
							else
							  {
									$('#incidents').html(data);
									
									notiPop('success','New incident follow up added successfully',"");
									
									$('#bookIncidentFollowUp_form')[0].reset();
									$('#model_bookingIncidentFollowUp').modal('toggle');
									$('#bookIncidentFollowUp_submit').show();
									$('#bookIncidentFollowUp_process').hide();
									
									if($('input[name=bookingIncident_Id]').length>0)
									{
										var incidentId=$('input[name=bookingIncident_Id]').val();
										$('#viewFollowUps-'+incidentId).trigger('click');
									}
							  }
						}
					});
				}
		});
		
		$('#model_bookingIncidentViewFollowUp').on('change','.bookIncident_followUp',function(){
				var followUpId=$(this).attr('id').split('-');
				var followUpText=$(this).val();
				
				$.ajax({
					url:site_url+'booking/incidentFollowUpUpdate',
					type:'POST',
					data:{followUpId:followUpId[1],followUpText:followUpText},
					success:function(data){
						if(data=='LO')
						  	redirectToLogin();
						else
						{
							$('#followUpHeader-'+followUpId[1]).text(data);
							notiPop('success','Incident follow up updated successfully',"");
						}
					}
				});
				
			});
		
		$('#shaList').on('click','.shaCopyApp',function(){
			var shaId=$(this).attr('id').split('-')[1];
			
				$.ajax({
					url:site_url+'sha/copyCancelled',
					type:'POST',
					data:{shaId:shaId},
					success:function(data){
							window.location.href=site_url+'sha/new_application/'+data+'/#duplicateStudentCreated';				
					}
				});
		});
		
		$('#bookCheckup_submit').click(function(){
			
			$('#bookCheckup_form').parsley().validate();
			if($('#bookCheckup_form').parsley().isValid())
			{
				$('#bookCheckup_submit').hide();
				$('#bookCheckup_process').show();
				var bookingId=$('#bookCheckup_form #bookingCheckup_bookingId').val();
				var checkUpType=$('#bookCheckup_form #bookingCheckup_type').val();
				
				$.ajax({
					url:site_url+'booking/addNewCheckup',
					type:'POST',
					data:$('#bookCheckup_form').serialize(),
					success:function(data)
						{
							$('#checkups').html(data);
							if($('#bookingCheckup_id').length==0)
								notiPop('success','New Check added successfully',"");
							else	
								notiPop('success','Check info updated successfully',"");
							
							$('#bookCheckup_form')[0].reset();
							$('#model_bookingCheckup').modal('toggle');
							$('#bookCheckup_submit').show();
							$('#bookCheckup_process').hide();
							
							$('#booking_'+bookingId+' .bookingCheckupPopContent').remove();
							if(checkUpType=='1' || checkUpType=='2')
								$('.checkUpType_'+checkUpType).remove();
						}
				});	
			}
			
		});
		
		$('#userRecentActivityBtn').click(function(){
			

			  $('#filtersLoadingDiv').show();
			  $('#infoSidebar').html('');
			  Utility.toggle_rightbar();

			  $.ajax({
				  url:site_url+'account/userRecentActivities',
				  success:function(data)
					  {
							if(data=='LO')
								redirectToLogin();
							else
							{			
								$('#filtersLoadingDiv').hide();
								$('#infoSidebar').html(data);
							}
					  }
				  });
			  
		});
		
		$('.container-fluid').on('click','.deleteGroupInvoiceItem',function(){
	
	
			var itemId=$(this).parents('tr').attr('id');
			var tableId=$(this).parents('table').attr('id');
			var id=tableId.split('-')[1];
		
			bootbox.dialog({
				message: "Are you sure you wish to delete this invoice item?",
				title: "Delete",
				buttons: {
					  danger: {
						label: "Delete",
						className: "btn-danger",
						callback: function() {

						$.ajax({
					  url:site_url+'group_invoice/deleteInvoiceItem',
					  type:'post',
					  data:{id:id,itemId:itemId},
					  dataType: 'json',
					  success:function(data){
								  notiPop('success','Item deleted successfully',"");
								  $('#'+tableId).html($(data.page).find('#'+tableId).html());
								  $('#viewIntialInvoiceTotal').html($(data.page).find('#viewIntialInvoiceTotal').html());
							}
					  });
							}
						}
					}
				});
	
});

	$('#hfaTransportInfo_submit').click(function(){
		
			$('#hfaTransportInfo_form').parsley().validate();

			if ($('#hfaTransportInfo_form').parsley().isValid())
				{
					$('#hfaTransportInfo_submit').hide();
					$('#hfaTransportInfo_process').show();	
					var transportId=$('#transportId').length;
					
					var transferData=$('#hfaTransportInfo_form').serialize();
					$.ajax({
						url:site_url+'hfa/addNewTransportInfo',
						type:'POST',
						data:transferData,
						success:function(data){
							if(data=='LO')
									redirectToLogin();
							else
							  {
									$('#transportListDiv').html(data);
									if(transportId==0)
										notiPop('success','Transport info added successfully',"");
									else
										notiPop('success','Transport info updated successfully',"");	
									
									$('#hfaTransportInfo_form')[0].reset();
									$('#model_hfaTransportInfo').modal('toggle');
									$('#hfaTransportInfo_submit').show();
									$('#hfaTransportInfo_process').hide();
							  }
						}
					});
				}
		
	});
			
		
		$('#bookHoliday_submit').click(function(){
			
			var startDateValid= $('#bookHoliday_startDate').parsley();
			var endDateValid= $('#bookHoliday_endDate').parsley();
			window.ParsleyUI.removeError(startDateValid,'startDateValidError');
			window.ParsleyUI.removeError(endDateValid,'endDateValidError');
			
			$('#bookHoliday_form').parsley().validate();

			if ($('#bookHoliday_form').parsley().isValid())
				{	
					$('#bookHoliday_submit').hide();
					$('#bookHoliday_process').show();
					
					var holidayData=$('#bookHoliday_form').serialize();
					$.ajax({
						url:site_url+'booking/addNewHoliday',
						type:'POST',
						data:holidayData,
						dataType: 'json',
						success:function(data){
							
							if(data.result=='LO')
								redirectToLogin();
							else
							{
								$('#bookHoliday_submit').show();
								$('#bookHoliday_process').hide();
								
								if(data.result=='error')
								{
										if(data.toDate=='wrong')
										{
											window.ParsleyUI.addError(endDateValid,'endDateValidError','End date should be greater than Start date');
											$('#bookHoliday_endDate').focus();
										}
										else if(data.fromDate=='datesNotInBooking' || data.toDate=='datesNotInBooking')
										{
											if(data.fromDate=='datesNotInBooking')
											{
												window.ParsleyUI.addError(startDateValid,'startDateValidError','Start date should be between Booking start and Booking end date');
												$('#bookHoliday_startDate').focus();
											}
											else
												$('#bookHoliday_endDate').focus();
											if(data.toDate=='datesNotInBooking')
												window.ParsleyUI.addError(endDateValid,'endDateValidError','End date should be between Booking start and Booking end date');
										}
										else if(data.fromDate=='dateOverlaping')
										{
											if(data.fromDate=='dateOverlaping')
											{
												window.ParsleyUI.addError(startDateValid,'startDateValidError','Dates overlaping with already added holidays');
												window.ParsleyUI.addError(endDateValid,'endDateValidError','Dates overlaping with already added holidays');
												$('#bookHoliday_endDate').focus();
											}
										}	
								}
								else
								{
									$('#holidays').html(data.holidays);
									initializeToolTip();
									if($('input[name=bookingHoliday_id]').length==0)
										notiPop('success','New holidays added successfully',"");
									else
										notiPop('success','Holidays updated successfully',"");	
									
									$('#bookHoliday_form')[0].reset();
									$('#model_bookingHoliday').modal('toggle');
								}
							}	
						}
					});
				}
		});


		$('#placeBookingServiceSubmit').click(function(){
		
			var formdata=$('#placeBookingService_form').serialize();

			$('#placeBookingServiceSubmit').hide();
			$('#placeBookingServiceProcess').show();

				  $.ajax({
					  url:site_url+'booking/addBookingService',
					  type:'post',
					  data:formdata,
					  success:function(data){
						  if(data=='LO')
									redirectToLogin();
						  else
							{
								  $('#placeBookingServiceProcess').hide();
								  $('#model_PlaceBookingService').modal('toggle');
								  $('#placeBookingServiceSubmit').show();
								  window.location=site_url+'booking/view/'+data+'#bookingPlaced';
						  }
					  }
					  });
				
		});
		
		

	$('#hfaWarningSend_submit, #editHfaWarningSend').click(function(){
		
			$('#hfaWarningSend_form').parsley().validate();

			if ($('#hfaWarningSend_form').parsley().isValid())
				{
					if($(this).attr('id')=='hfaWarningSend_submit')
					{
						var submitType='add';
						var submitBtn=$('#hfaWarningSend_submit');
						var submitBtnProcess=$('#hfaWarningSend_process');
					}
					else
					{
						var submitType='edit';
						var submitBtn=$('#editHfaWarningSend');
						var submitBtnProcess=$('#edithfaWarningSendProcess');
					}
					
					submitBtn.hide();
					submitBtnProcess.show();
					
					var warningData=$('#hfaWarningSend_form').serialize();
					$.ajax({
						url:site_url+'hfa/addNewWarning',
						type:'POST',
						data:warningData,
						dataType: 'json',
						success:function(data){
							if(data.hasOwnProperty('logout'))
									redirectToLogin();
							else
							  {
									$('#warningsListDiv').html(data.warnings);
									if(submitType=='add' && $('#hfaWarning_idSecond').val()=='')
										notiPop('success','New incident added successfully',"");
									else	if(submitType=='edit')
										notiPop('success','Incident edited successfully',"");
									
									submitBtn.show();
									submitBtnProcess.hide();
									
									if(submitType=='add')
									{
										$('#model_hfaWarningSend_content').hide();
										$("#model_hfaWarningSend_second").slideDown();
									}
									else
									{
										$('#hfaWarningSend_form')[0].reset();
										$('#model_hfaWarningSend').modal('toggle');
									}
									$('#warningId, #hfaWarning_idSecond').val(data.warning_id);
							  }
						}
					});
				}
		
	});
	
	$('#visits').on('click','.visitReportDateEdit',function(){
		var visitReportId=$(this).attr('id').split('-')[1];
		
		$.ajax({
						url:site_url+'hfa/visitReportDateEditPopContent',
						type:'POST',
						data:{visitReportId:visitReportId},
						success:function(data){
								if(data=='LO')
									redirectToLogin();
								else
								{	
									$('#hfaEditVisitReportDate_form').html(data);
									$("#model_hfaEditVisitReportDate").modal('show');
								}
							}
					});
	});
	
	$('#model_hfaEditVisitReportDate_submit').click(function(){
		
		$('#hfaEditVisitReportDate_form').parsley().validate();
		if ($('#hfaEditVisitReportDate_form').parsley().isValid())
			{
				var formdata=$('#hfaEditVisitReportDate_form').serialize();
				
				$('#model_hfaEditVisitReportDate_process').show();
				$('#model_hfaEditVisitReportDate_submit').hide();
				$.ajax({
								url:site_url+'hfa/visitReportDateEditSubmit',
								type:'POST',
								data:formdata,
								success:function(data){
										if(data=='LO')
											redirectToLogin();
										else
										{	
											$('#visits').html(data);
											notiPop('success','Visit report Date/Time updated successfully',"");
											$('#model_hfaEditVisitReportDate_process').hide();
											$('#model_hfaEditVisitReportDate_submit').show();
											$('#model_hfaEditVisitReportDate').modal('toggle');
											$('#hfaEditVisitReportDate_form')[0].reset();
										}
									}
							});
			}
	});
	
	$('#visits').on('click','.visitReportCopy',function(){
		var visitReportId=$(this).attr('id').split('-')[1];
		
		$('#hfaCopyVisitReport_reportId').val(visitReportId);
		$("#model_hfaCopyVisitReport").modal('show');
	});
	
	$('#hfaCopyVisitReport_submit').click(function(){
		
		$('#hfaCopyVisitReport_form').parsley().validate();
		if ($('#hfaCopyVisitReport_form').parsley().isValid())
			{
				var formdata=$('#hfaCopyVisitReport_form').serialize();
				
				$('#hfaCopyVisitReport_process').show();
				$('#hfaCopyVisitReport_submit').hide();
				$.ajax({
								url:site_url+'hfa/visitReportCopySubmit',
								type:'POST',
								data:formdata,
								success:function(data){
										if(data=='LO')
											redirectToLogin();
										else
										{	
											$('#visits').html(data);
											notiPop('success','Visit report copied successfully',"");
											$('#hfaCopyVisitReport_process').hide();
											$('#hfaCopyVisitReport_submit').show();
											$('#model_hfaCopyVisitReport').modal('toggle');
											$('#hfaCopyVisitReport_form')[0].reset();
										}
									}
							});
			}
	});
	
	
	$('#bookingHoldPosSubmit').click(function(){
			
				$('#bookingHoldPos_form').parsley().validate();
				if ($('#bookingHoldPos_form').parsley().isValid())
				{
					$('#bookingHoldPosSubmit').hide();
					$('#bookingHoldPosSubmitProcess').show();
					
					var formdata=$('#bookingHoldPos_form').serialize();
					$.ajax({
								url:site_url+'booking/paymentHoldSubmit',
								type:'POST',
								data:formdata,
								success:function(data){
										if(data=='LO')
											redirectToLogin();
										else
										{	
											$('#hpContent').html(data);
											notiPop('success','Corrent and future POs held successfully',"");
											$('#bookingHoldPosSubmit').show();
											$('#bookingHoldPosSubmitProcess').hide();
											$('#model_bookingHoldPos').modal('toggle');
											$('#bookingHoldPos_form')[0].reset();
										}
									}
							});
				}
		
		});
		
			$('#resetPOSubmit').click(function(){
					
					var url='purchase_orders/resetPO/';
					url +=$('#resetPOId').val();
						
					$('#resetPOProcess').show();
					$('#resetPOSubmit').hide();
					
					$.ajax({
							url:site_url+url,
							type:'GET',
							success:function(data)
								{		
										if(data=='LO')
											redirectToLogin();
										else
										{	
											window.location.href=site_url+'purchase_orders/view/'+data;
										}
								}
						});
				});

	});