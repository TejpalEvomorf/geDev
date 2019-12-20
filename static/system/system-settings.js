$(document).ready( function () {


   
window.ParsleyConfig = {
    	  successClass: 'has-success'
		, errorClass: 'has-error'
		, errorElem: '<span></span>'
		, errorsWrapper: '<span class="help-block"></span>'
		, errorTemplate: "<div></div>"
		, classHandler: function(el) {
    		return el.$element.closest(".form-group");
		}
	};

	if(page=='hfa' || page=='sha' || page=='client' || page=='account' || page=='guardian' || page=='caregiver_company_list' || page=='caregiver_manage'|| page=='apu_company' || page=='bookings' || page=='invoiceInitial' || page=='invoiceOngoing' || page=='invoiceInitialCancelled' || page=='po' || page=='groupInvoiceInitial' || page=='sha_application' || page=='hfa_application' || page=='bookings-view')
	{
		var dataTableEmptyMessage="No records found";	
	
			$.extend( true, $.fn.dataTable.defaults, {
				"oLanguage": {
						"sEmptyTable":dataTableEmptyMessage,
						"sZeroRecords":dataTableEmptyMessage
						},
			} );
	}
	
		if(page=='hfa')
		{
			var hfaSortTarget=[-1,-2,-3,-4];
			if(hfa_status_page=='approved')
				hfaSortTarget=[-1,-2,-3];
			else if(hfa_status_page=='all' || hfa_status_page=='new' || hfa_status_page=='no_response')
				hfaSortTarget=[-1,-2,-3];
			
		/*Data tables #STARTS*/
				/*$.fn.dataTable.moment( 'HH:mm MMM D, YY' );
				$.fn.dataTable.moment( 'd M Y' );*/
		
				 var oTable = $('#hfaList').dataTable({
				"language": {
					"lengthMenu": "_MENU_"
				},
				"drawCallback": function( settings ) {   
    					initializeToolTip();
				},
				"fnDrawCallback" : function() {
					initializeToolTip();
					setTimeout(function(){
  						redrawFixedTable();},500);
				},
				"sPaginationType": "full_numbers_no_ellipses",
				 "ajax": {
            	"url":site_url+"hfa/ajax_list",
            	"type": "POST",
				"data": function ( d ) {
                d.hfa_status_page = hfa_status_page;
				d.appStep = appStep;
				d.appState = appState;
				d.appReason = appReason;
				d.warning = warning;
				d.room = room;
				d.wwcc = wwcc;
				d.insurance = insurance;
				d.cApproval = cApproval;
				d.roomType = roomType;
				d.nation = nation;
				d.religion = religion;
				d.facility = facility;
				d.language = language;
                // d.custom = $('#myInput').val();
                // etc
            	}
        		},
				"processing": true, 
        		"serverSide": true,
				"order": [],
				"columnDefs": [
    				{ "searchable": false, "targets": -1 },
					{"targets": hfaSortTarget,"orderable": false},
					{ className: "middle-alignment", "targets": [ -2,-4 ] }
 					 ],
					 "pageLength": 50,
					 "bLengthChange": false,
					 initComplete : function() 
					 	{
			       	 		initializeToolTip();
							$('.dataTables_filter').css('width',0).hide();
							redrawFixedTable();
							$("#hfaSearchBtn").css("width","125px").show();
						}  
			});
			$('.dataTables_filter input').attr('placeholder','Search...');
		
		
			//DOM Manipulation to move datatable elements integrate to panel
			$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
			//$('.panel-ctrls').append("<i class='separator'></i>");
			$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center").attr('id', 'toprightsearch');
		
			$('.panel-footer').append($(".dataTable+.row"));
			$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
			$('.dataTables_filter').append($('<div class="m-n DTTT btn-group pull-right" id="hfaSearchBtnClose"><i class="colorLightgrey font18 material-icons">close</i></div>'));
	/*Data tables #ENDS*/
	
			
		//initialize FixedHeader
		// get header height if fixed
		var offsetTop = 0;
		if ($('.navbar-fixed-top').length>0)
			offsetTop = $('.navbar-fixed-top').eq(0).innerHeight();
		var oFH = new FixedHeader( oTable, {offsetTop: offsetTop} );
	}
	else if(page=='sha')
		{
					 var oTableSha = $('#shaList').dataTable({
					"language": {
						"lengthMenu": "_MENU_"
					},
					"sPaginationType": "full_numbers_no_ellipses",
					"drawCallback": function( settings ) {   
							initializeToolTip();
					},
				"fnDrawCallback" : function() {
					initializeToolTip();
					setTimeout(function(){
  						redrawFixedTable();},500);
				},
					 "ajax": {
            	"url":site_url+"sha/ajax_list",
            	"type": "POST",
				"data": function ( d ) {
                d.sha_status_page = sha_status_page;
				d.appStep = appStep;
				d.placement = placement;
				d.appTourType = appTourType;
				d.client=bookingFilter_client;
				d.college=bookingFilter_college;
				d.appDuplicate=appDuplicate;
				d.appCaregivingDuration=appCaregivingDuration;
				d.appMatchCollege=appMatchCollege;
                // d.custom = $('#myInput').val();
                // etc
            	}
        		},
					"processing": true, 
        			"serverSide": true,
					"order": [],
					"columnDefs": [
						{ "searchable": false, "targets": -1 },
						{"targets": [-1,-2,-3],"orderable": false},
						{ className: "middle-alignment", "targets": [ 1,2,4 ] }
						 ],
						 "pageLength": 50,
						 "bLengthChange": false,
						 initComplete : function() 
							{
								initializeToolTip();
								$('.dataTables_filter').css('width',0).hide();
								redrawFixedTable();
								$("#shaSearchBtn").css("width","125px").show();
							}  
				});
				$('.dataTables_filter input').attr('placeholder','Search...');
			
			
				//DOM Manipulation to move datatable elements integrate to panel
				$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
				//$('.panel-ctrls').append("<i class='separator'></i>");
				$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center").attr('id', 'toprightsearch');
			
				$('.panel-footer').append($(".dataTable+.row"));
				$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
				$('.dataTables_filter').append($('<div class="m-n DTTT btn-group pull-right" id="shaSearchBtnClose"><i class="colorLightgrey font18 material-icons">close</i></div>'));
		/*Data tables #ENDS*/
		
		//initialize FixedHeader
		// get header height if fixed
		var offsetTop = 0;
		if ($('.navbar-fixed-top').length>0)
			offsetTop = $('.navbar-fixed-top').eq(0).innerHeight();
		var oFH = new FixedHeader( oTableSha, {offsetTop: offsetTop} );
		
	}
	else if(page=='share_house_new')
	{
		var oTableSha = $('#shareHouseList').dataTable({
				"language": {
					"lengthMenu": "_MENU_"
				},
				"drawCallback": function( settings ) {   
						initializeToolTip();
				},
			"fnDrawCallback" : function() {
				
				setTimeout(function(){
						redrawFixedTable();},500);
			},
			"sPaginationType": "full_numbers_no_ellipses",
			"ajax": {
        	"url":site_url+"houses/ajax_list",
        	"type": "POST",
			"data": function ( d ) {
            d.house_status_page = house_status_page;
            d.custom = $('#myInput').val();
            // etc
        	}
    		},
			"processing": true, 
    		"serverSide": true,
			"order": [],
			"columnDefs": [
				{ "searchable": false, "targets": -1 },
				{"targets": [-1],"orderable": false}
			],
			"pageLength": 50,
			"bLengthChange": false,
			initComplete : function() 
			{
				initializeToolTip();
				$('.dataTables_filter').css('width',0).hide();
				redrawFixedTable();
				//alert('reach here');
				$("#shaSearchBtn").css("width","125px").show();
			}  
		});
			$('.dataTables_filter input').attr('placeholder','Search...');
			//DOM Manipulation to move datatable elements integrate to panel
			$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
			//$('.panel-ctrls').append("<i class='separator'></i>");
			$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center").attr('id', 'toprightsearch');
		
			$('.panel-footer').append($(".dataTable+.row"));
			$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
			$('.dataTables_filter').append($('<div class="m-n DTTT btn-group pull-right" id="shaSearchBtnClose"><i class="colorLightgrey font18 material-icons">close</i></div>'));
		/*Data tables #ENDS*/
		
		//initialize FixedHeader
		// get header height if fixed
		var offsetTop = 0;
		if ($('.navbar-fixed-top').length>0)
			offsetTop = $('.navbar-fixed-top').eq(0).innerHeight();
		var oFH = new FixedHeader( oTableSha, {offsetTop: offsetTop} );
	}
	else if(page=='share_house_all')
	{
		var oTableSha = $('#shareHouseList').dataTable({
				"language": {
					"lengthMenu": "_MENU_"
				},
				"drawCallback": function( settings ) {   
						initializeToolTip();
				},
			"fnDrawCallback" : function() {
				
				setTimeout(function(){
						redrawFixedTable();},500);
			},
			"sPaginationType": "full_numbers_no_ellipses",
			"ajax": {
	        	"url":site_url+"houses/ajax_list",
	        	"type": "POST",
				"data": function ( d ) {
	            	d.house_status_page = house_status_page;
	             	d.custom = $('#myInput').val();
	        	}
    		},
				"processing": true, 
    			"serverSide": true,
				"order": [],
				"columnDefs": [
					{ "searchable": false, "targets": -1 },
					{"targets": [-1],"orderable": false}
					 ],
					 "pageLength": 50,
					 "bLengthChange": false,
					 initComplete : function() 
						{
							initializeToolTip();
							$('.dataTables_filter').css('width',0).hide();
							redrawFixedTable();
							$("#shaSearchBtn").css("width","125px").show();
						}  
		});
			$('.dataTables_filter input').attr('placeholder','Search...');
		
		
			//DOM Manipulation to move datatable elements integrate to panel
			$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
			//$('.panel-ctrls').append("<i class='separator'></i>");
			$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center").attr('id', 'toprightsearch');
		
			$('.panel-footer').append($(".dataTable+.row"));
			$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
			$('.dataTables_filter').append($('<div class="m-n DTTT btn-group pull-right" id="shaSearchBtnClose"><i class="colorLightgrey font18 material-icons">close</i></div>'));
		/*Data tables #ENDS*/
		
		//initialize FixedHeader
		// get header height if fixed
		var offsetTop = 0;
		if ($('.navbar-fixed-top').length>0)
			offsetTop = $('.navbar-fixed-top').eq(0).innerHeight();
		var oFH = new FixedHeader( oTableSha, {offsetTop: offsetTop} );
	}
	else if(page=='client')
		{
					 var oTableClient = $('#clientList').dataTable({
					"language": {
						"lengthMenu": "_MENU_"
					},
					"drawCallback": function( settings ) {   
							initializeToolTip();
					},
					"fnDrawCallback" : function() {
					setTimeout(function(){
  						redrawFixedTable();},500);
				},
				"sPaginationType": "full_numbers_no_ellipses",
				"ajax": {
            	"url":site_url+"client/ajax_list",
            	"type": "POST",
				"data": function ( d ) {
                // d.custom = $('#myInput').val();
				 d.clientCategory = clientCategory;
                
            	}
        		},
				"processing": true, 
        		"serverSide": true,
				"order": [],
					//"aaSorting": [[1,'asc']],
				//	"oSearch": { "bSmart": false, "bRegex": true },
					"columnDefs": [
    				{ "searchable": false, "targets": -1 },
					{"targets": [-1,-1],"orderable": false},
					{ className: "middle-alignment", "targets": [ -2 ] }
 					 ],
						"pageLength": 50,
						"bLengthChange": false,
						initComplete : function() 
						{
							initializeToolTip();
							$('.dataTables_filter').css('width',0).hide();
							$("#clientSearchBtn").css("width","125px").show();
						}  
				});
				$('.dataTables_filter input').attr('placeholder','Search...');
			
			
				//DOM Manipulation to move datatable elements integrate to panel
				$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
				//$('.panel-ctrls').append("<i class='separator'></i>");
				$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center").attr('id', 'toprightsearch');
			
				$('.panel-footer').append($(".dataTable+.row"));
				$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
				$('.dataTables_filter').append($('<div class="m-n DTTT btn-group pull-right" id="clientSearchBtnClose"><i class="colorLightgrey font18 material-icons">close</i></div>'));
		/*Data tables #ENDS*/
		
		//initialize FixedHeader
		// get header height if fixed
		var offsetTop = 0;
		if ($('.navbar-fixed-top').length>0)
			offsetTop = $('.navbar-fixed-top').eq(0).innerHeight();
		var oFH = new FixedHeader( oTableClient, {offsetTop: offsetTop} );
		
	}
else if(page=='account')
	  {
				   var oTableEmployee = $('#employeeList').dataTable({
				  "language": {
					  "lengthMenu": "_MENU_"
				  },
				  "drawCallback": function( settings ) {   
						  initializeToolTip();
				  },
				  "aaSorting": [[1,'asc']],
				  "columnDefs": [
					  { "searchable": false, "targets": [-1, 0] },
					  {"targets": [0,2,-1],"orderable": false}
					   ],
					   "sPaginationType": "full_numbers_no_ellipses",
					   "pageLength": 50,
					   "bLengthChange": false,
					   initComplete : function() 
						  {
							  initializeToolTip();
							  $('.dataTables_filter').css('width',0).hide();
							}  
			  });
			  $('.dataTables_filter input').attr('placeholder','Search...');
		  
		  
			  //DOM Manipulation to move datatable elements integrate to panel
			  $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
			  //$('.panel-ctrls').append("<i class='separator'></i>");
			  $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center").attr('id', 'toprightsearch');
		  
			  $('.panel-footer').append($(".dataTable+.row"));
			  $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
			  $('.dataTables_filter').append($('<div class="m-n DTTT btn-group pull-right" id="shaSearchBtnClose"><i class="colorLightgrey font18 material-icons">close</i></div>'));
	  /*Data tables #ENDS*/
	  
	  //initialize FixedHeader
	  // get header height if fixed
	  /*var offsetTop = 0;
	  if ($('.navbar-fixed-top').length>0)
		  offsetTop = $('.navbar-fixed-top').eq(0).innerHeight();
	  var oFH = new FixedHeader( oTableEmployee, {offsetTop: offsetTop} );*/
	  
  }
  else if(page=='guardian')
	  {
				   var oTableGuardian = $('#guardianList').dataTable({
				  "language": {
					  "lengthMenu": "_MENU_"
				  },
				  "drawCallback": function( settings ) {   
						  initializeToolTip();
				  },
				  "aaSorting": [[0,'asc']],
				  "columnDefs": [
					  { "searchable": false, "targets": [-1] },
					  {"targets": [-1],"orderable": false}
					   ],
				       "sPaginationType": "full_numbers_no_ellipses",
					   "pageLength": 50,
					   "bLengthChange": false,
					   initComplete : function() 
						{
							initializeToolTip();
							$('.dataTables_filter').css('width',0).hide();
							$("#listTableSearchBtn").css("width","125px").show();
						}  
			  });
			  $('.dataTables_filter input').attr('placeholder','Search...');
		  
		  
			  //DOM Manipulation to move datatable elements integrate to panel
			  $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
			  //$('.panel-ctrls').append("<i class='separator'></i>");
			  $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center").attr('id', 'toprightsearch');
		  
			  $('.panel-footer').append($(".dataTable+.row"));
			  $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
			  $('.dataTables_filter').append($('<div class="m-n DTTT btn-group pull-right" id="listTableSearchBtnClose"><i class="colorLightgrey font18 material-icons">close</i></div>'));
	  /*Data tables #ENDS*/
	  
	  //initialize FixedHeader
	  // get header height if fixed
	  var offsetTop = 0;
	  if ($('.navbar-fixed-top').length>0)
		  offsetTop = $('.navbar-fixed-top').eq(0).innerHeight();
	  var oFH = new FixedHeader( oTableGuardian, {offsetTop: offsetTop} );
	  
	}
	else if(page=='caregiver_company_list')
	  {
				   var oTableGuardian = $('#guardianList').dataTable({
				  "language": {
					  "lengthMenu": "_MENU_"
				  },
				  "drawCallback": function( settings ) {   
						  initializeToolTip();
				  },
				  "aaSorting": [[0,'asc']],
				  "columnDefs": [
					  { "searchable": false, "targets": [-1] },
					  {"targets": [-1],"orderable": false}
					   ],
				       "sPaginationType": "full_numbers_no_ellipses",
					   "pageLength": 50,
					   "bLengthChange": false,
					   initComplete : function() 
						{
							initializeToolTip();
							$('.dataTables_filter').css('width',0).hide();
							$("#listTableSearchBtn").css("width","125px").show();
						}  
			  });
			  $('.dataTables_filter input').attr('placeholder','Search...');
		  
		  
			  //DOM Manipulation to move datatable elements integrate to panel
			  $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
			  //$('.panel-ctrls').append("<i class='separator'></i>");
			  $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center").attr('id', 'toprightsearch');
		  
			  $('.panel-footer').append($(".dataTable+.row"));
			  $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
			  $('.dataTables_filter').append($('<div class="m-n DTTT btn-group pull-right" id="listTableSearchBtnClose"><i class="colorLightgrey font18 material-icons">close</i></div>'));
	  /*Data tables #ENDS*/
	  
	  //initialize FixedHeader
	  // get header height if fixed
	  var offsetTop = 0;
	  if ($('.navbar-fixed-top').length>0)
		  offsetTop = $('.navbar-fixed-top').eq(0).innerHeight();
	  var oFH = new FixedHeader( oTableGuardian, {offsetTop: offsetTop} );
	  
	}
	else if(page=='caregiver_manage')
	  {
				   var oTableGuardian = $('#manageCaregivers').dataTable({
				  "language": {
					  "lengthMenu": "_MENU_"
				  },
				  "drawCallback": function( settings ) {   
						  initializeToolTip();
				  },
				  "aaSorting": [[0,'asc']],
				  "columnDefs": [
					  { "searchable": false, "targets": [-1] },
					  {"targets": [-1],"orderable": false}
					   ],
				       "sPaginationType": "full_numbers_no_ellipses",
					   "pageLength": 50,
					   "bLengthChange": false,
					   initComplete : function() 
						{
							initializeToolTip();
							$('.dataTables_filter').css('width',0).hide();
							$("#listTableSearchBtn").css("width","125px").show();
						}  
			  });
			  $('.dataTables_filter input').attr('placeholder','Search...');
		  
		  
			  //DOM Manipulation to move datatable elements integrate to panel
			  $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
			  //$('.panel-ctrls').append("<i class='separator'></i>");
			  $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center").attr('id', 'toprightsearch');
		  
			  $('.panel-footer').append($(".dataTable+.row"));
			  $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
			  $('.dataTables_filter').append($('<div class="m-n DTTT btn-group pull-right" id="listTableSearchBtnClose"><i class="colorLightgrey font18 material-icons">close</i></div>'));
	  /*Data tables #ENDS*/
	  
	  //initialize FixedHeader
	  // get header height if fixed
	  var offsetTop = 0;
	  if ($('.navbar-fixed-top').length>0)
		  offsetTop = $('.navbar-fixed-top').eq(0).innerHeight();
	  var oFH = new FixedHeader( oTableGuardian, {offsetTop: offsetTop} );
	  
	}
	else if(page=='apu_company')
	  {
				   var oTableGuardian = $('#apuCompanyList').dataTable({
				  "language": {
					  "lengthMenu": "_MENU_"
				  },
				  "drawCallback": function( settings ) {   
						  initializeToolTip();
				  },
				  "aaSorting": [[0,'asc']],
				  "columnDefs": [
					  { "searchable": false, "targets": [-1] },
					  {"targets": [-1],"orderable": false}
					   ],
				       "sPaginationType": "full_numbers_no_ellipses",
					   "pageLength": 50,
					   "bLengthChange": false,
					   initComplete : function() 
						{
							initializeToolTip();
							$('.dataTables_filter').css('width',0).hide();
							$("#listTableSearchBtn").css("width","125px").show();
						}  
			  });
			  $('.dataTables_filter input').attr('placeholder','Search...');
		  
		  
			  //DOM Manipulation to move datatable elements integrate to panel
			  $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
			  //$('.panel-ctrls').append("<i class='separator'></i>");
			  $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center").attr('id', 'toprightsearch');
		  
			  $('.panel-footer').append($(".dataTable+.row"));
			  $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
			  $('.dataTables_filter').append($('<div class="m-n DTTT btn-group pull-right" id="listTableSearchBtnClose"><i class="colorLightgrey font18 material-icons">close</i></div>'));
	  /*Data tables #ENDS*/
	  
	  //initialize FixedHeader
	  // get header height if fixed
	  var offsetTop = 0;
	  if ($('.navbar-fixed-top').length>0)
		  offsetTop = $('.navbar-fixed-top').eq(0).innerHeight();
	  var oFH = new FixedHeader( oTableGuardian, {offsetTop: offsetTop} );
	  
	}
	else if(page=='tour')
	{
		var oTableGuardian = $('#tourList').dataTable({
			"language": {
			  "lengthMenu": "_MENU_"
			},
			"drawCallback": function( settings ) {   
				  initializeToolTip();
			},
			 "order": [],
			/*"aaSorting": [[0,'asc']],*/
			"columnDefs": [
			  { "searchable": false, "targets": [-1] },
			  {"targets": [-1,-2,-3,-4],"orderable": false},
			  { className: "middle-alignment", "targets": [ 2,4 ] }
			],
			"sPaginationType": "full_numbers_no_ellipses",
			"pageLength": 50,
			"bLengthChange": false,
			initComplete : function() 
			{
			  initializeToolTip();
			  $('.dataTables_filter').css('width',0).hide();
			  $("#listTableSearchBtn").css("width","125px").show();
			}  
		});
		  $('.dataTables_filter input').attr('placeholder','Search...');
	  
	  
		  //DOM Manipulation to move datatable elements integrate to panel
		  $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
		  //$('.panel-ctrls').append("<i class='separator'></i>");
		  $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center").attr('id', 'toprightsearch');
	  
		  $('.panel-footer').append($(".dataTable+.row"));
		  $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
		  $('.dataTables_filter').append($('<div class="m-n DTTT btn-group pull-right" id="listTableSearchBtnClose"><i class="colorLightgrey font18 material-icons">close</i></div>'));
		  /*Data tables #ENDS*/
		  
		  //initialize FixedHeader
		  // get header height if fixed
		  var offsetTop = 0;
		  if ($('.navbar-fixed-top').length>0)
			  offsetTop = $('.navbar-fixed-top').eq(0).innerHeight();
		  var oFH = new FixedHeader( oTableGuardian, {offsetTop: offsetTop} );
	}
	else if(page=='pending_students')
	{
		var oTableGuardian = $('#clientList').dataTable({
			"language": {
			  "lengthMenu": "_MENU_"
			},
			"drawCallback": function( settings ) {   
				  initializeToolTip();
			},
			"order": [],
			"columnDefs": [
			  { "searchable": false, "targets": [-1] },
			  {"targets": [-1,-2,-3],"orderable": false},
			  { className: "middle-alignment", "targets": [ -2 ] }
			],
			"sPaginationType": "full_numbers_no_ellipses",
			"pageLength": 50,
			"bLengthChange": false,
			initComplete : function() 
			{
			  initializeToolTip();
			  $('.dataTables_filter').css('width',0).hide();
			}  
		});
		  $('.dataTables_filter input').attr('placeholder','Search...');
	  
	  
		  //DOM Manipulation to move datatable elements integrate to panel
		  $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
		  //$('.panel-ctrls').append("<i class='separator'></i>");
		  $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center").attr('id', 'toprightsearch');
	  
		  $('.panel-footer').append($(".dataTable+.row"));
		  $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
		  $('.dataTables_filter').append($('<div class="m-n DTTT btn-group pull-right" id="listTableSearchBtnClose"><i class="colorLightgrey font18 material-icons">close</i></div>'));
		  /*Data tables #ENDS*/
		  
		  //initialize FixedHeader
		  // get header height if fixed
		  var offsetTop = 0;
		  if ($('.navbar-fixed-top').length>0)
			  offsetTop = $('.navbar-fixed-top').eq(0).innerHeight();
		  var oFH = new FixedHeader( oTableGuardian, {offsetTop: offsetTop} );
	}
	else if(page=='palced_students')
	{
		var oTableGuardian = $('#clientList').dataTable({
			"language": {
			  "lengthMenu": "_MENU_"
			},
			"drawCallback": function( settings ) {   
				  initializeToolTip();
			},
			"order": [],
			"columnDefs": [
			  { "searchable": false, "targets": [-1] },
			  {"targets": [-1,-2,-3],"orderable": false},
			  { className: "middle-alignment", "targets": [ -2 ] }
			],
			"sPaginationType": "full_numbers_no_ellipses",
			"pageLength": 50,
			"bLengthChange": false,
			initComplete : function() 
			{
				initializeToolTip();
				$('.dataTables_filter').css('width',0).hide();
			}  
		});
			$('.dataTables_filter input').attr('placeholder','Search...');
			$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
			$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center").attr('id', 'toprightsearch');
	  
			$('.panel-footer').append($(".dataTable+.row"));
			$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
			$('.dataTables_filter').append($('<div class="m-n DTTT btn-group pull-right" id="listTableSearchBtnClose"><i class="colorLightgrey font18 material-icons">close</i></div>'));
		  
			var offsetTop = 0;
			if ($('.navbar-fixed-top').length>0)
				offsetTop = $('.navbar-fixed-top').eq(0).innerHeight();
			var oFH = new FixedHeader( oTableGuardian, {offsetTop: offsetTop} );
	}
	else if(page=='all_students')
	{
		var oTableGuardian = $('#clientList').dataTable({
			"language": {
			  "lengthMenu": "_MENU_"
			},
			"drawCallback": function( settings ) {   
				  initializeToolTip();
			},
			/*"aaSorting": [[0,'asc']],*/
			"order": [],
			"columnDefs": [
			  { "searchable": false, "targets": [-1] },
			  {"targets": [-1,-2,-3],"orderable": false},
			  { className: "middle-alignment", "targets": [ -2 ] }
			],
			"sPaginationType": "full_numbers_no_ellipses",
			"pageLength": 50,
			"bLengthChange": false,
			initComplete : function() 
			{
				initializeToolTip();
				$('.dataTables_filter').css('width',0).hide();
			}  
		});
		$('.dataTables_filter input').attr('placeholder','Search...');
	  
		  //DOM Manipulation to move datatable elements integrate to panel
		  $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
		  $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center").attr('id', 'toprightsearch');
	  
		  $('.panel-footer').append($(".dataTable+.row"));
		  $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
		  $('.dataTables_filter').append($('<div class="m-n DTTT btn-group pull-right" id="listTableSearchBtnClose"><i class="colorLightgrey font18 material-icons">close</i></div>'));
		  /*Data tables #ENDS*/
		  
		  var offsetTop = 0;
		  if ($('.navbar-fixed-top').length>0)
			  offsetTop = $('.navbar-fixed-top').eq(0).innerHeight();
		  var oFH = new FixedHeader( oTableGuardian, {offsetTop: offsetTop} );
	}
	else if(page=='bookings')
		{
			
		/*Data tables #STARTS*/
		
				 var oTable = $('#bookingList').dataTable({
				"language": {
					"lengthMenu": "_MENU_"
				},
				"drawCallback": function( settings ) {   
    					initializeToolTip();
				},
				"fnDrawCallback" : function() {
					setTimeout(function(){
  						redrawFixedTable();},500);
				},
				"sPaginationType": "full_numbers_no_ellipses",
				 "ajax": {
            	"url":site_url+"booking/ajax_list",
            	"type": "POST",
				"data": function ( d ) {
                // d.custom = $('#myInput').val();
                 d.booking_status_page = booking_status_page;
				 d.bookingWithWarnings=bookingFilter_bookingWithWarnings;
				 d.bookingTourType = bookingTourType;
				 d.bookingSortType = bookingSortType;
				 d.bookingProductType = bookingProductType;
				 
				 d.booking_id=bookingFilter_booking_id;d.booking_idSF=bookingFilter_booking_idSF;
				 d.student=bookingFilter_student;
				 d.host=bookingFilter_host;
				 d.from=bookingFilter_from;
				 d.to=bookingFilter_to;
				 d.client=bookingFilter_client;
				 d.study_tour=bookingFilter_study_tour;
				 d.activealboking=bookingFilter_active_record;
            	}
        		},
				"processing": true, 
        		"serverSide": true,
				"order": [],
				"columnDefs": [
    				{ "searchable": false, "targets": -1 },
					{"targets": [1,-1,-2,-3,-4],"orderable": false},
					{ className: "middle-alignment", "targets": [ -2 ] }
 					 ],
					 "pageLength": 50,
					 "bLengthChange": false,
					 initComplete : function() 
					 	{
			       	 		initializeToolTip();
							$('.dataTables_filter').css('width',0).hide();
							redrawFixedTable();
							$("#bookingSearchBtn").css("width","125px").show();
						},
						fnDrawCallback :function()
							{initializeToolTip();}    
			});
			$('.dataTables_filter input').attr('placeholder','Search...');
		
		
			//DOM Manipulation to move datatable elements integrate to panel
			$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
			//$('.panel-ctrls').append("<i class='separator'></i>");
			$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center").attr('id', 'toprightsearch');
			$('.panel-footer').append($(".dataTable+.row"));
			$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
			$('.dataTables_filter').append($('<div class="m-n DTTT btn-group pull-right" id="hfaSearchBtnClose"><i class="colorLightgrey font18 material-icons">close</i></div>'));
	/*Data tables #ENDS*/
	
		
		//initialize FixedHeader
		// get header height if fixed
		var offsetTop = 0;
		if ($('.navbar-fixed-top').length>0)
			offsetTop = $('.navbar-fixed-top').eq(0).innerHeight();
		var oFH = new FixedHeader( oTable, {offsetTop: offsetTop} );
	}
	else if(page=='invoiceInitial' || page=='invoiceOngoing' || page=='groupInvoiceInitial')
	  {
				   if(page=='invoiceInitial' || page=='invoiceOngoing')
				   {
							   var oTableGuardian = $('#pendingInvoiceList').dataTable({
							  "language": {
								  "lengthMenu": "_MENU_"
							  },
							  "drawCallback": function( settings ) {   
									  initializeToolTip();
							  },
							  "fnDrawCallback" : function() {
								  initializeToolTip();
								  setTimeout(function(){
									  redrawFixedTable();},500);
							  },
							   "sPaginationType": "full_numbers_no_ellipses",
							   "searching": false,
							   "ajax": {
							  "url":site_url+"invoice/ajax_list_"+page,
							  "type": "POST",
							  "data": function ( d ) {
								  if(page=='invoiceInitial')
									   d.initial_invoice_statusPage = initial_invoice_statusPage;
								  else
									  d.ongoing_invoice_statusPage = ongoing_invoice_statusPage;   
							   d.InoiceFilter_number=InoiceFilter_number;
							   d.InoiceFilter_from=InoiceFilter_from;
							   d.InoiceFilter_to=InoiceFilter_to;
							   d.InoiceFilter_client=InoiceFilter_client;
							   d.InoiceFilter_studyTour=InoiceFilter_studyTour;
							   d.InoiceFilter_student=InoiceFilter_student;
							   d.InoiceFilter_other=InoiceFilter_other;
							  }
							  },
							  "processing": true, 
							  "serverSide": true,
							  "order": [],
							  "columnDefs": [
								  { "searchable": false, "targets": [-1] },
								  {"targets": [0,-1,-2,-3,-4,-5],"orderable": false},
									{ className: "middle-alignment officeUseTd", "targets": [ -2] }
								   ],
								   "pageLength": 50,
								   "bLengthChange": false,
								   initComplete : function() 
									  {
										  initializeToolTip();
										  $('.dataTables_filter').css('width',0).hide();
									      redrawFixedTable();
										}  
						  });
				   }
				   
				   if(page=='groupInvoiceInitial')
				   {
						   var oTableGuardian = $('#pendingInvoiceList').dataTable({
						  "language": {
							  "lengthMenu": "_MENU_"
						  },
						  "drawCallback": function( settings ) {   
								  initializeToolTip();
						  },
						  "order": [],
						  "columnDefs": [
							  { "searchable": false, "targets": [-1] },
							  {"targets": [0,-1,-2,-3],"orderable": false}
							   ],
							   "sPaginationType": "full_numbers_no_ellipses",
							   "pageLength": 50,
							   "bLengthChange": false,
							   initComplete : function() 
								  {
									  initializeToolTip();
									  $('.dataTables_filter').css('width',0).hide();
									}  
					  });
				  }
			  
			  $('.dataTables_filter input').attr('placeholder','Search...');
		  
		  
			  //DOM Manipulation to move datatable elements integrate to panel
			  $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
			  //$('.panel-ctrls').append("<i class='separator'></i>");
			  $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center").attr('id', 'toprightsearch');
		  
			  $('.panel-footer').append($(".dataTable+.row"));
			  $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
			  $('.dataTables_filter').append($('<div class="m-n DTTT btn-group pull-right" id="listTableSearchBtnClose"><i class="colorLightgrey font18 material-icons">close</i></div>'));
	  /*Data tables #ENDS*/
	  
	  //initialize FixedHeader
	  // get header height if fixed
	  var offsetTop = 0;
	  if ($('.navbar-fixed-top').length>0)
		  offsetTop = $('.navbar-fixed-top').eq(0).innerHeight();
	  var oFH = new FixedHeader( oTableGuardian, {offsetTop: offsetTop} );
	  
  }
  else if(page=='invoiceInitialCancelled')
	{
				 var oTableSha = $('#invoiceInitialListCancelled').dataTable({
				"language": {
					"lengthMenu": "_MENU_"
				},
				"drawCallback": function( settings ) {   
						initializeToolTip();
				},
			"fnDrawCallback" : function() {
				setTimeout(function(){
					redrawFixedTable();},500);
			},
				 "ajax": {
			"url":site_url+"invoice/ajax_list",
			"type": "POST",
			"data": function ( d ) {
			// d.custom = $('#myInput').val();
			// etc
			}
			},
				"processing": true, 
				"serverSide": true,
				"order": [],
				"columnDefs": [
					{ "searchable": false, "targets": -1 },
					{"targets": [-1],"orderable": false}
					 ],
				     "sPaginationType": "full_numbers_no_ellipses",
					 "pageLength": 50,
					 "bLengthChange": false,
					 initComplete : function() 
						{
							initializeToolTip();
							$('.dataTables_filter').css('width',0).hide();
							redrawFixedTable();
							$("#shaSearchBtn").css("width","125px").show();
						}  
			});
			$('.dataTables_filter input').attr('placeholder','Search...');
		
		
			//DOM Manipulation to move datatable elements integrate to panel
			$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
			//$('.panel-ctrls').append("<i class='separator'></i>");
			$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center").attr('id', 'toprightsearch');
		
			$('.panel-footer').append($(".dataTable+.row"));
			$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
			$('.dataTables_filter').append($('<div class="m-n DTTT btn-group pull-right" id="shaSearchBtnClose"><i class="colorLightgrey font18 material-icons">close</i></div>'));
	/*Data tables #ENDS*/
	
	//initialize FixedHeader
	// get header height if fixed
	var offsetTop = 0;
	if ($('.navbar-fixed-top').length>0)
		offsetTop = $('.navbar-fixed-top').eq(0).innerHeight();
	var oFH = new FixedHeader( oTableSha, {offsetTop: offsetTop} );
	
}
else if(page=='po')
	  {
				   var oTableGuardian = $('#poList').dataTable({
				  "language": {
					  "lengthMenu": "_MENU_"
				  },
				  "drawCallback": function( settings ) {   
						  initializeToolTip();
				  },
				  "ajax": {
            	"url":site_url+"purchase_orders/ajax_list",
            	"type": "POST",
				"data": function ( d ) {
                d.po_status = po_status;
				d.number=number;
				d.host=host;
				d.study_tour=study_tour;
				d.other=other;
				d.poFrom=poFrom;
				d.poTo=poTo;
				d.poDueDate=poDueDate;
            	}
        		},
					"processing": true, 
        			"serverSide": true,
				  "order": [],
				  /*"aaSorting": [[0,'asc']],*/
				  "columnDefs": [
					  { "searchable": false, "targets": [-1,-2] },
					  {"targets": '_all',"orderable": false}
					   ],
	    			   "sPaginationType": "full_numbers_no_ellipses",
					   "pageLength": 50,
					   "bLengthChange": false,
					   initComplete : function() 
						{
							initializeToolTip();
							$('.dataTables_filter').css('width',0).hide();
							$("#listTableSearchBtn").css("width","125px").show();
						}  
			  });
			  $('.dataTables_filter input').attr('placeholder','Search...');
		  
		  
			  //DOM Manipulation to move datatable elements integrate to panel
			  $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
			  //$('.panel-ctrls').append("<i class='separator'></i>");
			  $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center").attr('id', 'toprightsearch');
		  
			  $('.panel-footer').append($(".dataTable+.row"));
			  $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
			  $('.dataTables_filter').append($('<div class="m-n DTTT btn-group pull-right" id="listTableSearchBtnClose"><i class="colorLightgrey font18 material-icons">close</i></div>'));
	  /*Data tables #ENDS*/
	  
	  //initialize FixedHeader
	  // get header height if fixed
	  var offsetTop = 0;
	  if ($('.navbar-fixed-top').length>0)
		  offsetTop = $('.navbar-fixed-top').eq(0).innerHeight();
	  var oFH = new FixedHeader( oTableGuardian, {offsetTop: offsetTop} );
	  
	}
else if(page=='sha_application')
	  {
				  /* var oTableBookingHistory = $('#bookingHistoryList').dataTable({
				  "language": {
					  "lengthMenu": "_MENU_"
				  },
				  "columnDefs": [
					   { "width": "20%", "targets": -1 },
					   {"targets": '_all',"orderable": false}
  					],
				  "drawCallback": function( settings ) {   
						  initializeToolTip();
				  },
					   "pageLength": 50,
					   "bLengthChange": false,
					   initComplete : function() 
						{
							initializeToolTip();
							$('.dataTables_filter').css('width',0).hide();
							$("#listTableSearchBtn").css("width","125px").show();
						}  
			  });*/
			  
			  var oTablePaymentHistory = $('#paymentHistoryList').dataTable({
				  "language": {
					  "lengthMenu": "_MENU_"
				  },
				  "columnDefs": [
					   { "width": "20%", "targets": -1 },
					   {"targets": '_all',"orderable": false}
  					],
				  "drawCallback": function( settings ) {   
						  initializeToolTip();
				  },
				       "sPaginationType": "full_numbers_no_ellipses",
					   "pageLength": 50,
					   "bLengthChange": false,
					   initComplete : function() 
						{
							initializeToolTip();
							$('.dataTables_filter').css('width',0).hide();
							$("#listTableSearchBtn").css("width","125px").show();
						}  
			  });
			  
			  
			  $('.dataTables_filter input').attr('placeholder','Search...');
		  
		  
			  //DOM Manipulation to move datatable elements integrate to panel
			  $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
			  //$('.panel-ctrls').append("<i class='separator'></i>");
			  $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center").attr('id', 'toprightsearch');
		  
			  //$('div#tab-90-1 .panel-footer').append($("#bookingHistoryList.dataTable+.row"));
			  $('div#tab-90-2 .panel-footer').append($("#paymentHistoryList.dataTable+.row"));
			  $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
			  $('.dataTables_filter').append($('<div class="m-n DTTT btn-group pull-right" id="listTableSearchBtnClose"><i class="colorLightgrey font18 material-icons">close</i></div>'));
	  /*Data tables #ENDS*/
	  
	  //initialize FixedHeader
	  // get header height if fixed
	  /*var offsetTop = 0;
	  if ($('.navbar-fixed-top').length>0)
		  offsetTop = $('.navbar-fixed-top').eq(0).innerHeight();
	  var oFH = new FixedHeader( oTableGuardian, {offsetTop: offsetTop} );*/
	  
	}
	else if(page=='bookings-view')
	{
			  var oTablePaymentHistory = $('#bookingPosList, #bookingInvoicesList').dataTable({
				  "ordering": false,
				  "language": {
					  "lengthMenu": "_MENU_"
				  },
				  "columnDefs": [
					   { "width": "100px", "targets": -1 },
					   { "width": "100px", "targets": -2 },
					   { "width": "300px", "targets": -4 },
					   { "width": "1051px", "targets": -3 },
					],
				  "drawCallback": function( settings ) {   
						  initializeToolTip();
				  },
				       "sPaginationType": "full_numbers_no_ellipses",
					   "pageLength": 50,
					   "bLengthChange": false,
					   initComplete : function() 
						{
							initializeToolTip();
							$('.dataTables_filter').css('width',0).hide();
							$("#listTableSearchBtn").css("width","125px").show();
						}  
			  });
			  
			  $('.dataTables_filter input').attr('placeholder','Search...');
		  
		  
			  //DOM Manipulation to move datatable elements integrate to panel
			  $('div#tab-booking-invoices .panel-footer').append($("#bookingInvoicesList.dataTable+.row"));
			  $('div#tab-booking-pos .panel-footer').append($("#bookingPosList.dataTable+.row"));
			  $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
			  
			  //initialize FixedHeader
	 	 // get header height if fixed
		  var offsetTop = 0;
		  if ($('.navbar-fixed-top').length>0)
			  offsetTop = $('.navbar-fixed-top').eq(0).innerHeight();
		  var oFH = new FixedHeader( oTablePaymentHistory, {offsetTop: offsetTop} );
	}


if(page=='hfa' || page=='sha' || page=='client' || page=='guardian'|| page=='apu_company' || page=='bookings' || page=='invoiceInitial' || page=='invoiceOngoing' || page=='invoiceInitialCancelled' || page=='share_house_new' || page=='share_house_all' || page=='tour' || page=='po' || page=='bookings-view')
{
	//redraw fixedHeaders as necessary
	$(window).resize(function () {
		redrawFixedTable();
	});

	function redrawFixedTable () {
		oFH._fnUpdateClones(true);
		oFH._fnUpdatePositions();
	}

	$( "#rightmenu-trigger, #leftmenu-trigger" ).click(function() {
		setTimeout( function () {
			redrawFixedTable();
			setTimeout( function () {
				$('body').scroll()
			}, 500);
		}, 50)
	});
	
	if(page=='bookings-view')
	{
		$(window).scroll(function() {
				redrawFixedTable();
		});
	}
	$('#booking-view-invoices').click(function(){
			$(window).scrollTop(1);
		});
}
	
// Tooltip
 initializeToolTip(); //bootstrap's tooltip	
 
$('#hfaSearchBtn, #shaSearchBtn,#shaSearchBtn, #clientSearchBtn, #empSearchBtn, #listTableSearchBtn, #bookingSearchBtn').click(function(){
	$(this).fadeOut('fast', function(){
		$(this).width(0);
		$('#hfaSearchBtnClose, #shaSearchBtnClose, #clientSearchBtnClose, #empSearchBtnClose, #listTableSearchBtnClose, #bookingSearchBtnClose').fadeIn("slow");
		$('.dataTables_filter').show().animate({
			width: "256px"
		},
		{
			duration: 300,
			complete: function(){
				$('#hfaPanelCtrls, #shaPanelCtrls, #clientPanelCtrls, #empPanelCtrls, #listTablePanelCtrls, #bookingPanelCtrls').width(256);
			}
		});
	});
});


$('#hfaSearchBtnClose, #shaSearchBtnClose, #clientSearchBtnClose, #empSearchBtnClose, #listTableSearchBtnClose, #bookingSearchBtnClose').click(function(){
		$(this).fadeOut("fast");
		$('.dataTables_filter').animate({
				width: "0px"
		},
		{
				duration: 300,
				complete: function(){
						$(this).hide();
						$('#hfaSearchBtn, #shaSearchBtn, #clientSearchBtn, #empSearchBtn, #listTableSearchBtn, #bookingSearchBtn').show().animate({
							width: "125px"
						},
						{
							duration: 200,
							complete: function(){
								$('#hfaPanelCtrls, #shaPanelCtrls, #clientPanelCtrls, #empPanelCtrls, #listTablePanelCtrls, #bookingPanelCtrls').width(125);
							}
						});
					  
				}
		});
});
var glselect=$("#glselect").val();
if(glselect=='hfa'){
	$("#hfaList_filter input").trigger("keyup",function(event) {
    if (event.keyCode === 13) {
     $(this).dblclick(); 
	}
})
}else if(glselect=='sha'){
		$("#shaList_filter input").trigger("keyup",function(event) {
    if (event.keyCode === 13) {
     $(this).dblclick(); 
	}
})	

}else if(glselect=='purchase_orders'){
$("#poList_filter input").trigger("keyup",function(event) {
    if (event.keyCode === 13) {
     $(this).dblclick(); 
	}
})		
}			
});






