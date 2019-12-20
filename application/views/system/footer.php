<div class="extrabar-underlay"></div>
<div class="infobar-wrapper scroll-pane">
            <div class="infobar scroll-content" id="infoSidebar"></div>
            <div id="filtersLoadingDiv"><img src="<?=static_url()?>system/img/loading-filters.gif" /></div>
</div>
        </div>

    <!-- Load site level scripts -->

<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script> -->


<script src="<?=static_url()?>system/js/bootstrap.min.js"></script> 								<!-- Load Bootstrap -->
<script src="<?=static_url()?>system/js/enquire.min.js"></script> 									<!-- Load Enquire -->

<script src="<?=static_url()?>system/plugins/velocityjs/velocity.min.js"></script>					<!-- Load Velocity for Animated Content -->
<script src="<?=static_url()?>system/plugins/velocityjs/velocity.ui.min.js"></script>

<script src="<?=static_url()?>system/plugins/progress-skylo/skylo.js"></script> 		<!-- Skylo -->

<script src="<?=static_url()?>system/plugins/wijets/wijets.js"></script>     						<!-- Wijet -->

<script src="<?=static_url()?>system/plugins/sparklines/jquery.sparklines.min.js"></script> 			 <!-- Sparkline -->

<script src="<?=static_url()?>system/plugins/codeprettifier/prettify.js"></script> 				<!-- Code Prettifier  -->

<script src="<?=static_url()?>system/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js"></script>  <!-- Bootstrap Tabdrop -->

<script src="<?=static_url()?>system/plugins/nanoScroller/js/jquery.nanoscroller.min.js"></script> <!-- nano scroller -->

<script src="<?=static_url()?>system/plugins/dropdown.js/jquery.dropdown.js"></script> <!-- Fancy Dropdowns -->
<script src="<?=static_url()?>system/plugins/bootstrap-material-design/js/material.min.js"></script> <!-- Bootstrap Material -->
<script src="<?=static_url()?>system/plugins/bootstrap-material-design/js/ripples.min.js"></script> <!-- Bootstrap Material -->

<script src="<?=static_url()?>system/js/application.js"></script>
<!--<script src="<?=static_url()?>system/demo/demo.js"></script>
<script src="<?=static_url()?>system/demo/demo-switcher.js"></script>-->

<!-- Date Range Picker -->
<!--<script src="<?=static_url()?>system/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>-->               <!-- Datepicker -->
<script src="<?=static_url()?>system/plugins/bootstrap-datepicker/bootstrap-datepicker-1.7.1.js"></script>               <!-- Datepicker -->

<script src="<?=static_url()?>system/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>   <!--DateTime Picker--> 
<script src="<?=static_url()?>system/plugins/bootstrap-timepicker/bootstrap-timepicker.js"></script>

<script src="<?=static_url()?>system/plugins/form-parsley/parsley.js"></script>  					<!-- Validate Plugin / Parsley -->
<script src="<?=static_url()?>system/plugins/dropzone/dropzone.min.js"></script> <!-- Dropzone Plugin -->
<script src="<?=static_url()?>system/plugins/bootbox/bootbox.js"></script>

<!-- End loading site level scripts -->
    
  <?php if($page=='dashboard'){?>
        <!-- Load page level scripts-->
        
        <!-- Charts -->
        <script src="<?=static_url()?>system/plugins/charts-flot/jquery.flot.min.js"></script>                 <!-- Flot Main File -->
        <script src="<?=static_url()?>system/plugins/charts-flot/jquery.flot.pie.min.js"></script>             <!-- Flot Pie Chart Plugin -->
        <script src="<?=static_url()?>system/plugins/charts-flot/jquery.flot.stack.min.js"></script>           <!-- Flot Stacked Charts Plugin -->
        <script src="<?=static_url()?>system/plugins/charts-flot/jquery.flot.resize.min.js"></script>          <!-- Flot Responsive -->
        <script src="<?=static_url()?>system/plugins/charts-flot/jquery.flot.tooltip.min.js"></script>         <!-- Flot Tooltips -->
        <script src="<?=static_url()?>system/plugins/charts-flot/jquery.flot.spline.js"></script>              <!-- Flot Curved Lines -->
        <script src="<?=static_url()?>system/plugins/easypiechart/jquery.easypiechart.min.js"></script>        <!-- EasyPieChart-->
        <script src="<?=static_url()?>system/plugins/curvedLines-master/curvedLines.js"></script>              <!-- marvinsplines -->
        
        <script src="<?=static_url()?>system/plugins/form-daterangepicker/moment.min.js"></script>             <!-- Moment.js for Date Range Picker -->
        
        <!-- <script src="<?=static_url()?>system/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>   -->    <!-- jVectorMap -->
        <!-- <script src="<?=static_url()?>system/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>  --> <!--World Map-->
        <script src="<?=static_url()?>system/plugins/chartist/dist/chartist.min.js"></script>  chartist 
        <script src="<?=static_url()?>system/demo/demo-index.js"></script>                                     <!-- Initialize scripts for this page-->
        
        <!-- End loading page level scripts-->
 
 <?php } elseif($page=='hfa' || $page=='sha' || $page=='client' || $page=='account' || $page=='guardian' || $page=='caregiver_company_list' || $page=='caregiver_manage' || $page=='apu_company' || $page=='sha_application' || $page=='hfa_application' || $page=='prices' || $page=='bookings' || $page=='invoiceInitial' || $page=='invoiceOngoing' || $page=='invoiceInitialCancelled' || $page=='tour' || $page=='pending_students' || $page=='all_students' || $page=='palced_students' || $page=='create_tour' || $page=='edit_tour' || $page=='share_house_new'|| $page=='share_house_all'|| $page=='po' || $page=='groupInvoiceInitial' || $page=='bookings-view'){ ?>   
		  <script src="<?=static_url()?>system/plugins/datatables/jquery.dataTables.js"></script> 						<!-- Data Tables -->
          <script src="<?=static_url()?>system/plugins/datatables/dataTables.bootstrap.js"></script> 					<!-- Bootstrap Support for Datatables -->
          <script src="<?=static_url()?>system/plugins/tables-fixedheader/js/dataTables.fixedHeader.js"></script> 
          <script src="<?=static_url()?>system/plugins/form-xeditable/bootstrap3-editable/js/bootstrap-editable.js"></script> 		<!-- Fixed Header -->
          <script src="<?=static_url()?>system/js/full_numbers_no_ellipses.js"></script>
              
<?php } elseif($page=='hfa_application' || $page=='sha_application'){?>   
		  <script src="<?=static_url()?>system/plugins/form-fseditor/jquery.fseditor-min.js"></script>            			<!-- Fullscreen Editor -->
		  <script src="<?=static_url()?>system/plugins/bootbox/bootbox.js"></script> 	<!-- Bootbox -->
		  <!--<script src="<?=static_url()?>system/demo/demo-profile.js"></script>-->

<?php } elseif($page=='create_client'){?>
	    <script src="<?=static_url()?>system/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js"></script>
        
<?php } elseif($this->router->fetch_class()=='reports'){?>
		<script src="<?=static_url()?>system/plugins/form-validation/jquery.validate.min.js"></script>  					<!-- Validate Plugin -->
	    <script src="<?=static_url()?>system/plugins/form-stepy/jquery.stepy.js"></script>
        <script src="<?=static_url()?>system/plugins/form-daterangepicker/moment.min.js"></script>              			<!-- Moment.js for Date Range Picker -->
        <script src="<?=static_url()?>system/plugins/form-daterangepicker/daterangepicker.js"></script>
<?php } ?>

 <!--<script src="<?=static_url()?>system/plugins/pines-notify/jquery.pnotify.min.js"></script>-->
<script src="<?=static_url()?>system/system-settings.js"></script> 
<script src="<?=static_url()?>system/system-ready.js"></script> 
<script src="<?=static_url()?>system/system-functions.js"></script> 
<script src="<?=static_url()?>system/plugins/pines-notify/pnotify.min.js"></script> 		<!-- PNotify -->

    </body>
</html>