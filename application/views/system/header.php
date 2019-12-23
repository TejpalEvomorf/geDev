<?php checkLoginRedirect();?>
<!DOCTYPE html >
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?=pageTitleS($page)?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="description" content="Management system for Global Experience">
    <meta name="author" content="EvoMorf">

    <link rel="shortcut icon" href="<?=static_url()?>system/img/logo-icon-dark.png">

    <link type='text/css' href='https://fonts.googleapis.com/css?family=Roboto:300,400,400italic,500' rel='stylesheet'>
    <link type='text/css'  href="https://fonts.googleapis.com/icon?family=Material+Icons"  rel="stylesheet"> 

    <link href="<?=static_url()?>system/fonts/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet">        <!-- Font Awesome -->
    <link href="<?=static_url()?>system/css/styles.css" type="text/css" rel="stylesheet">                                     <!-- Core CSS with all styles -->
    
    <link href="<?=static_url()?>system/css/ge-system.css" type="text/css" rel="stylesheet">                                     <!-- Custom css styles for GE system -->

    <link href="<?=static_url()?>system/plugins/codeprettifier/prettify.css" type="text/css" rel="stylesheet">                <!-- Code Prettifier -->

    <link href="<?=static_url()?>system/plugins/dropdown.js/jquery.dropdown.css" type="text/css" rel="stylesheet">            <!-- iCheck -->
    <link href="<?=static_url()?>system/plugins/progress-skylo/skylo.css" type="text/css" rel="stylesheet">                   <!-- Skylo -->

    <!--[if lt IE 10]>
        <script src="<?=static_url()?>system/js/media.match.min.js"></script>
        <script src="<?=static_url()?>system/js/respond.min.js"></script>
        <script src="<?=static_url()?>system/js/placeholder.min.js"></script>
    <![endif]-->
    <!-- The following CSS are included as plugins and can be removed if unused-->
    
<link href="<?=static_url()?>system/plugins/form-daterangepicker/daterangepicker-bs3.css" type="text/css" rel="stylesheet">    <!-- DateRangePicker -->
<link href="<?=static_url()?>system/plugins/fullcalendar/fullcalendar.css" type="text/css" rel="stylesheet">                   <!-- FullCalendar -->
<link href="<?=static_url()?>system/plugins/jvectormap/jquery-jvectormap-2.0.2.css" type="text/css" rel="stylesheet">
<link href="<?=static_url()?>system/less/card.less" type="text/css" rel="stylesheet"> 

<!--<link href="static/system/plugins/chartist/dist/chartist.min.css" type="text/css" rel="stylesheet">--> <!-- chartist -->


<link href="<?=static_url()?>system/plugins/datatables/dataTables.bootstrap.css" type="text/css" rel="stylesheet">
<link href="<?=static_url()?>system/plugins/datatables/dataTables.themify.css" type="text/css" rel="stylesheet">
<link href="<?=static_url()?>system/plugins/datatables/dataTables.fontAwesome.css" type="text/css" rel="stylesheet">                  <!-- FontAwesome Support for Datatables -->
<link href="<?=static_url()?>system/plugins/tables-fixedheader/css/dataTables.fixedHeader.min.css" type="text/css" rel="stylesheet">  <!-- FixedHeader CSS -->
<link href="<?=static_url()?>system/plugins/pines-notify/pnotify.css" type="text/css" rel="stylesheet">

<!--[if lt IE 10]>
        <script src="assets/js/media.match.min.js"></script>
        <script src="assets/js/respond.min.js"></script>
        <script src="assets/js/placeholder.min.js"></script>
    <![endif]-->
    <!-- The following CSS are included as plugins and can be removed if unused-->
    
<link href="<?=static_url()?>system/plugins/dropzone/css/dropzone.css" type="text/css" rel="stylesheet"> <!-- Dropzone Plugin -->

<script src="<?=static_url()?>system/js/jquery-1.10.2.min.js"></script> 							<!-- Load jQuery -->
<script src="<?=static_url()?>system/js/jqueryui-1.10.3.min.js"></script> 							<!-- Load jQueryUI -->
<script src="<?=static_url()?>system/plugins/bootstrap-timepicker/bootstrap-timepicker.js"></script>

<?php if($page=='create_client'){?>
	<link href="<?=static_url()?>system/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" type="text/css" rel="stylesheet"> <!-- Touchspin -->
<?php } ?>

<script type="text/javascript">
	var site_url='<?=site_url()?>';
	var page='<?=$page?>';

</script>

    </head>


    <body class="animated-content infobar-overlay">
        
        
<header id="topnav" class="navbar navbar-default navbar-fixed-top" role="banner">
	<!-- <div id="page-progress-loader" class="show"></div> -->

	<div class="logo-area">
		<a class="navbar-brand navbar-brand-inverse" href="index.html">
			<!--<img class="show-on-collapse img-logo-white" alt="Paper" src="<?=static_url()?>system/img/logo-icon-white.png">-->
			<img class="show-on-collapse img-logo-dark" alt="Paper" src="<?=static_url()?>system/img/logo-icon-dark.png">
			<!--<img class="img-white" alt="Paper" src="<?=static_url()?>system/img/logo-white.png">-->
			<img class="img-dark" alt="Paper" src="<?=static_url()?>system/img/logo-dark.png">
            <img class="show-on-collapse img-logo-white" alt="Paper" src="<?=static_url()?>system/img/logo-icon-white-new.png">
            <img class="img-white" alt="Paper" src="<?=static_url()?>system/img/logo-white-new.png">
		</a>

		<span id="trigger-sidebar" class="toolbar-trigger toolbar-icon-bg stay-on-search">
			<a data-toggle="tooltips" data-placement="right" title="Toggle Sidebar">
				<span class="icon-bg">
					<i class="material-icons">menu</i>
				</span>
			</a>
		</span>
        
        <span id="trigger-search" class="toolbar-trigger toolbar-icon-bg ov-h">
			<a data-toggle="tooltips" data-placement="right" title="Toggle Sidebar">
				<span class="icon-bg">
					<i class="material-icons">search</i>
				</span>
			</a>
		</span>
        <?php   
		if(!empty($_GET['type'])){
			$val='';
			if(!empty($_GET['booking_id'] )){
				$val=$_GET['booking_id'];
				
			}else if(!empty($_GET['host'] )){
				$val=$_GET['host'];
			}else if(!empty($_GET['student'] )){
				$val=$_GET['student'];
			}
	else if(!empty($_GET['po'] )){
				$val=$_GET['po'];
			}
			else if(!empty($_GET['number'] )){
				$val=$_GET['number'];
			}
			else if(!empty($_GET['value'] )){
				$val=$_GET['value'];
			}
		}
		
		
		?>
        <div id="search-box">
			<div class="form-group is-empty"><input class="form-control" value="<?php echo  @$val; ?>" placeholder="Search..." id="search-input" type="text"><span class="material-input"></span></div>
		</div>
		<input type="hidden" id="glselect" value="<?php echo  @$this->uri->segment(1) ; ?>"/>
		<input type="hidden" id="glmethod" value="<?php echo  @$this->uri->segment(2) ; ?>"/>
	</div><!-- logo-area -->
	<ul class="nav navbar-nav toolbar pull-right">
    
    <li class="hidden-xs search-filter-status" id="headerSearchDropdown" style="display:none;">
     <button type="button" class="btn btn-sm btn-primary btn-raised dropdown-toggle" data-toggle="dropdown" aria-expanded="true" style="margin: 19px 0;">
     <span id="headerSearchDropdownText">Search </span> <span class="caret"></span><div class="ripple-container"></div>
     </button>
      <ul class="dropdown-menu" id="globalsearchmenu" role="menu">
	  <li><a data-id="booking" href="javascript:void(0);" onclick="filterMatchesglobalsearch($(this),'booking/searchall');" class="selected">Search All</a></li>
        <li><a data-id="booking" href="javascript:void(0);" onclick="filterMatchesglobalsearch($(this),'booking');" class="selected">Search bookings</a></li>
        <li><a data-id="hfa" href="javascript:void(0);" onclick="filterMatchesglobalsearch($(this),'hfa');">Search host families</a></li>
        <li><a data-id="sha" href="javascript:void(0);" onclick="filterMatchesglobalsearch($(this),'sha');">Search students</a></li>
        <li><a href="javascript:void(0);" onclick="filterMatchesglobalsearch($(this),'invoice/initial_all');">Search initial invoices</a></li>
        <li><a href="javascript:void(0);" onclick="filterMatchesglobalsearch($(this),'invoice/ongoing_all');">Search ongoing invoices</a></li>
        <li><a href="javascript:void(0);" onclick="filterMatchesglobalsearch($(this),'purchase_orders/all');">Search POs</a></li>
        <li><a href="javascript:void(0);" onclick="">Search group invoices</a></li>
      </ul>
      </li>

		<li class="toolbar-icon-bg appear-on-search ov-h" id="trigger-search-close">
	        <a class="toggle-fullscreen"><span class="icon-bg">
	        	<i class="material-icons">close</i>
	        </span></a>
	    </li>
        <input type="hidden" id="globalsearch"  value="<?php echo @$_GET['type']?>"/>
               
		<li class="toolbar-icon-bg hidden-xs" id="trigger-fullscreen">
	        <a href="#" class="toggle-fullscreen"><span class="icon-bg">
	        	<i class="material-icons">fullscreen</i>
	        </span></a>
	    </li>
       
        <li class="toolbar-icon-bg" id="trigger-infobar">
			<a data-toggle="tooltips" data-placement="right" title="Recent activity" id="userRecentActivityBtn">
				<span class="icon-bg">
					<i class="material-icons">replay_10</i>
				</span>
			</a>
		</li>
</ul>

</header>

<?php 
	$this->load->view('system/sidebar');
?>

            <div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                           <!-- <ol class="breadcrumb">
                                
<li class=""><a href="index.html">Home</a></li>
<li class="active"><a href="index.html">Dashboard</a></li>

                            </ol>-->
