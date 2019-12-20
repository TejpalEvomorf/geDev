<style>

.btn.btn-midnightblue.btn-sm1 {

    background: hsla(0, 0%, 0%, 0) none repeat scroll 0 0;

    color: hsl(358, 80%, 50%) !important;

    /* position: absolute; */

    right: 15px;

    top: 2px;

}
</style>

 <div class="container-fluid">                                

    <div data-widget-group="group1">

	<div class="row">

            <div class="col-md-12">

			<div class="panel panel-default">

<table id="bookingHistoryList" class="noborder0 table table-striped table-bordered table-fixed-header m-n" cellspacing="0" width="100%">
    <thead>
         <tr>
          <th>Booking info</th>
          <th>Student</th>
          <th>Status</th>
          <th width="120px">Office use</th>
          <th width="80px">Actions</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
</table>

						

			<div class="panel-footer"></div>			

</div></div></div></div></div>

<?php  
$this->load->view('system/booking/changeStatusPopUp'); 
$this->load->view('system/booking/editBookingPopUp');
?>