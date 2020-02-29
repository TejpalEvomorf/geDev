<?php
$loggedInUser=loggedInUser();
$genderList=genderList();
if($loggedInUser['user_type']==1)
	$sidebarProfilePic=static_url()."system/demo/avatar/avatar_15.png";
else	
{
	if($loggedInUser['image']!='')
		$sidebarProfilePic=static_url()."uploads/employee/".$loggedInUser['image'];
	else
		$sidebarProfilePic=static_url().'system/img/default-'.strtolower($genderList[$loggedInUser['gender']]).'-employee.jpg';
}
?>

        <div id="wrapper">
            <div id="layout-static">
                <div class="static-sidebar-wrapper sidebar-light-green">
                    <div class="static-sidebar">
                        <div class="sidebar">
	<div class="widget" id="widget-profileinfo">
        <div class="widget-body">
            <div class="userinfo ">
                <div class="avatar pull-left">
                <?php if($sidebarProfilePic!=''){?>
	                    <img src="<?=$sidebarProfilePic?>" class="img-responsive img-circle" id="sidebarProfilePic"> 
                    <?php } ?>
                </div>
                <div class="info">
                    <span class="username" id="sidebarFnameLname"><?=ucwords($loggedInUser['fname'].' '.$loggedInUser['lname'])?></span>
                    <div class="userctrls">
                    	<a href="<?=site_url()?>account">Account</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?=site_url()?>admin/logout">Logout</a>
                    </div>
                </div>

                <div class="acct-dropdown clearfix dropdown">
                    <span class="pull-left"><span class="online-status online"></span>Online</span>
                    <!-- <span class="pull-right dropdown-toggle" data-toggle="dropdown"><a href="javascript:void(0)" class="btn btn-fab-caret btn-xs btn-fab"><i class="material-icons">arrow_drop_down</i><div class="ripple-container"></div></a></span>
                    <ul class="dropdown-menu">
                        <li><span class="online-status online"></span> Online</li>
                        <li><span class="online-status online"></span> Online</li>
                        <li><span class="online-status online"></span> Online</li>
                        <li><span class="online-status online"></span> Online</li>
                    </ul> -->
                </div>
            </div>
        </div>
    </div>
	<div class="widget stay-on-collapse" id="widget-sidebar">
        <nav role="navigation" class="widget-body">
	<ul class="acc-menu">
		<li class="nav-separator"><span>Navigation</span></li>
		<li>
        	<a  class="withripple" href="<?=site_url()?>dashboard"><span class="icon">
			<i class="material-icons">airplay</i></span>
            <span>Dashboard</span><span class="badge badge-teal"></span></a>
        </li>
		
        <li>
        	<a  class="withripple" href="javascript:;">
            	<span class="icon"><i class="material-icons">domain</i></span>
        		<span>Bookings</span>
                <span class="badge badge-teal">
					<?php 
						$expected_arrivalCount=bookingCountByStatus('expected_arrival');
						if($expected_arrivalCount>0)
							echo $expected_arrivalCount;
					?>
                </span>
            </a>
        	
            <ul class="acc-menu">
				<li><a  class="withripple" href="javascript:;"><span>Booking Manager</span></a>
					<ul class="acc-menu">
	                    <?php foreach(bookingStatusList() as $bSK=>$bSV){?>
							<li><a href="<?=site_url()?>booking/<?=$bSK?>" class="withripple"><?=$bSV.' '.bookingCountByStatus($bSK)?></a></li>
                        <?php } ?>
                        <li><a href="<?=site_url()?>booking" class="withripple">All bookings<?=' '.bookingCountByStatus('all')?></a></li>
					</ul>
				</li>
            </ul>
    	</li>
        
		<li>
            <a  class="withripple" href="javascript:;">
                <span class="icon"><i class="material-icons">home</i></span><span>Host Families</span>
                <span class="badge badge-teal"><?=applicationCountByStatus('new','hfa')?></span>
            </a>
			<ul class="acc-menu">
				<li><a  class="withripple" href="javascript:;"><span>Application Manager</span></a>
					<ul class="acc-menu">
						<li><a href="<?=site_url()?>hfa/new_application" class="withripple">New  <?=applicationCountByStatus('new','hfa')?></a></li>
						<li><a href="<?=site_url()?>hfa/no_response" class="withripple">No response  <?=applicationCountByStatus('no_response','hfa')?></a></li>
                        <li><a href="<?=site_url()?>hfa/confirmed" class="withripple">Confirmed  <?=applicationCountByStatus('confirmed','hfa')?></a></li>
                        <li><a href="<?=site_url()?>hfa/pending_approval" class="withripple">Pending approval  <?=applicationCountByStatus('pending_approval','hfa')?></a></li>
                        <li><a href="<?=site_url()?>hfa/approved" class="withripple">Approved  <?=applicationCountByStatus('approved','hfa')?></a></li>
                        <li><a href="<?=site_url()?>hfa/do_not_use" class="withripple">Do not use  <?=applicationCountByStatus('do_not_use','hfa')?></a></li>
                        <li><a href="<?=site_url()?>hfa/unavailable" class="withripple">Unavailable  <?=applicationCountByStatus('unavailable','hfa')?></a></li>
                        <li><a href="<?=site_url()?>hfa" class="withripple">All applications  <?=applicationCountByStatus('all','hfa')?></a></li>
					</ul>
				</li>
                 <!--<li>
                	<a  class="withripple" href="<?=site_url()?>booking/active_host_families"><span>Active host families</span></a>
				</li>-->
				<!--<li><a href="#" class="withripple" href="javascript:;">Active Host Families</a></li>
				<li><a href="#" class="withripple" href="javascript:;">Email Settings</a>
                	<ul class="acc-menu">
						<li><a href="#" class="withripple">New Families</a></li>
						<li><a href="#" class="withripple">Re-visits</a></li>
					</ul>
                </li>-->
			</ul>
		</li>
        <li>
        	<a  class="withripple" href="javascript:;">
            	<span class="icon"><i class="material-icons">face</i></span><span>Students</span>
                <span class="badge badge-teal"><?=applicationCountByStatus('new','sha')?></span>
            </a>
        	<ul class="acc-menu">
				<li><a  class="withripple" href="javascript:;"><span>Application Manager</span></a>
					<ul class="acc-menu">
						<li><a href="<?=site_url()?>sha/new_application" class="withripple">New  <?=applicationCountByStatus('new','sha')?></a></li>
						<li><a href="<?=site_url()?>sha/pending_invoice" class="withripple">Pending invoice  <?=applicationCountByStatus('pending_invoice','sha')?></a></li>
                        <li><a href="<?=site_url()?>sha/approved_without_payment" class="withripple">Approved - unpaid  <?=applicationCountByStatus('approved_without_payment','sha')?></a></li>
                        <li><a href="<?=site_url()?>sha/approved_with_payment" class="withripple">Approved - paid  <?=applicationCountByStatus('approved_with_payment','sha')?></a></li>
                        <li><a href="<?=site_url()?>sha/rejected" class="withripple">Rejected  <?=applicationCountByStatus('rejected','sha')?></a></li>
                        <li><a href="<?=site_url()?>sha/cancelled" class="withripple">Cancelled  <?=applicationCountByStatus('cancelled','sha')?></a></li>
                        <li><a href="<?=site_url()?>sha" class="withripple">All applications  <?=applicationCountByStatus('all','sha')?></a></li>
					</ul>
        </li>
        <!--<li>
            <a  class="withripple" href="<?=site_url()?>sha/active_students"><span>Active students</span></a>
		</li>-->
	</ul>
    </li>
<!--    <li>
        <a class="withripple" href="javascript:;">
            <span class="icon"><i class="material-icons">face</i></span><span>Share Houses</span>
            <span class="badge badge-teal"><?php echo applicationCountByStatus('share_house_new','share_house')?></span>
        </a>
        <ul class="acc-menu">
            <li><a  class="withripple" href="javascript:;"><span>Application Manager</span></a>
                <ul class="acc-menu">
                    <li><a href="<?=site_url()?>houses/new_application" class="withripple">New  <?php echo applicationCountByStatus('share_house_new','share_house')?></a></li>
                    <li><a href="<?=site_url()?>houses/pending_invoice" class="withripple">Pending invoice  <?php echo applicationCountByStatus('share_house_pending_invoice','share_house')?></a></li>
                    <li><a href="<?=site_url()?>houses/room_reserved" class="withripple">Room - reserved  <?php echo applicationCountByStatus('share_house_room_reserved','share_house')?></a></li>
                    <li><a href="<?=site_url()?>houses/payment_received" class="withripple">Payment Received <?php echo applicationCountByStatus('share_house_payment_received','share_house')?></a></li>
                    <li><a href="<?=site_url()?>houses/finalized" class="withripple">Finalized <?php echo applicationCountByStatus('share_house_finalized','share_house')?></a></li>
                    <li><a href="<?php echo site_url()?>houses/rejected" class="withripple">Rejected  <?php echo applicationCountByStatus('share_house_rejected','share_house')?></a></li>
                    <li><a href="<?php echo site_url()?>houses" class="withripple">All applications <?php echo applicationCountByStatus('all','share_house')?></a></li>
                </ul>
            </li>
            <li>
                <a class="withripple" href="<?=site_url()?>houses/active_houses"><span>Active Share Houses</span></a>
            </li>
        </ul>
    </li>-->
    
    <li>
		<a class="withripple" href="javascript:;"><span class="icon"><i class="material-icons">stars</i></span><span>Tour groups</span></a>
		<ul class="acc-menu">
			<li><a  class="withripple" href="<?=site_url()?>tour"><span>Tour list</span></a></li>
			<li><a  class="withripple" href="<?=site_url()?>tour/create"><span>Add New Tour</span></a></li>
		</ul>
    </li>
    
    <li><a  class="withripple" href="javascript:;"><span class="icon"><i class="material-icons">monetization_on</i></span><span>Invoices</span></a>
        	<ul class="acc-menu">
	            <li>
                	<a  class="withripple" href="javascript:;"><span>Initial</span></a>
                    <ul class="acc-menu">
						<li>
                        	<a href="<?=site_url()?>invoice/initial" class="withripple">
                        		<span class="badge-submenu1 badge badge-teal"><?=initialInvoiceUnmovedCount()?></span>Pending
                            </a>
                        </li>
						<li><a href="<?=site_url()?>invoice/initial_partial" class="withripple">Partially paid</a></li>
                        <li><a href="<?=site_url()?>invoice/initial_paid" class="withripple">Paid</a></li>
                         <li><a href="<?=site_url()?>invoice/initial_all" class="withripple">All initial</a></li>
					</ul>
                </li>
                <li>
                    <a  class="withripple" href="javascript:;"><span>On going</span></a>
                        <ul class="acc-menu">
                            <li>
                                <a href="<?=site_url()?>invoice/ongoing" class="withripple">
                                    <span class="badge-submenu1 badge badge-teal"><?=ongoingInvoiceUnmovedCount()?></span>Pending
                                </a>
                            </li>
                            <li><a href="<?=site_url()?>invoice/ongoing_partial" class="withripple">Partially paid</a></li>
                            <li><a href="<?=site_url()?>invoice/ongoing_paid" class="withripple">Paid</a></li>
                            <li><a href="<?=site_url()?>invoice/ongoing_all" class="withripple">All ongoing</a></li>
                        </ul>
                </li>
			</ul>
    </li>
    
    <?php
    $clientsListGroupInv=clientsListGroupInv();
	?>
    <li><a  class="withripple" href="javascript:;"><span class="icon"><i class="material-icons">monetization_on</i></span><span>Group Invoices</span></a>
        <ul class="acc-menu">
        <?php foreach($clientsListGroupInv as $cl){?>
            <li>
                <a  class="withripple" href="javascript:;"><span><?=$cl['bname']?></span></a>
                <ul class="acc-menu">
                    <li>
                        <a href="<?=site_url()?>group_invoice/pending/<?=$cl['id']?>" class="withripple">
                            <span class="badge-submenu1 badge badge-teal"><?php //initialInvoiceUnmovedCount()?></span>Pending
                        </a>
                    </li>
                    <li><a href="<?=site_url()?>group_invoice/partial/<?=$cl['id']?>" class="withripple">Partially paid</a></li>
                    <li><a href="<?=site_url()?>group_invoice/paid/<?=$cl['id']?>" class="withripple">Paid</a></li>
                    <li><a href="<?=site_url()?>group_invoice/all/<?=$cl['id']?>" class="withripple">All invoices</a></li>
                </ul>
            </li>
            <?php } ?>
        </ul>
	</li>
    
    <li><a  class="withripple" href="javascript:;"><span class="icon"><i class="material-icons">receipt</i></span><span>Purchase Orders</span></a>
        	<ul class="acc-menu">
	            <li><a  class="withripple" href="<?=site_url()?>purchase_orders"><span>Pending</span></a></li>
                <li><a  class="withripple" href="<?=site_url()?>purchase_orders/partial"><span>Partially paid</span></a></li>
				<li><a  class="withripple" href="<?=site_url()?>purchase_orders/paid"><span>Paid</span></a></li>
                <li><a  class="withripple" href="<?=site_url()?>purchase_orders/all"><span>All purchase orders</span></a></li>
			</ul>
    </li>
    
    <li><a  class="withripple" href="javascript:;"><span class="icon"><i class="material-icons">account_box</i></span><span>Clients</span></a>
        	<ul class="acc-menu">
	            <li><a  class="withripple" href="<?=site_url()?>client"><span>Client list</span></a></li>
				<li><a  class="withripple" href="<?=site_url()?>client/create"><span>Add new client</span></a></li>
			</ul>
    </li>
    
    
     <li><a  class="withripple" href="javascript:;"><span class="icon"><i class="material-icons">group_work</i></span><span>Caregivers</span></a>
        	<ul class="acc-menu">
	            <!--<li><a  class="withripple" href="<?=site_url()?>guardian"><span>Caregiver list</span></a></li>
				<li><a  class="withripple" href="<?=site_url()?>guardian/create"><span>Add new caregiver</span></a></li>-->
	            <li><a  class="withripple" href="<?=site_url()?>caregiver"><span>Companies list</span></a></li>
				<li><a  class="withripple" href="<?=site_url()?>caregiver/create_company"><span>Add new caregiver company</span></a></li>
			</ul>
    </li>
    
    <li><a  class="withripple" href="javascript:;"><span class="icon"><i class="material-icons">flight</i></span><span>APU Companies</span></a>
        	<ul class="acc-menu">
	            <li><a  class="withripple" href="<?=site_url()?>apu_company"><span>APU company list</span></a></li>
				<li><a  class="withripple" href="<?=site_url()?>apu_company/create"><span>Add new APU company</span></a></li>
			</ul>
    </li>
    
    <li><a  class="withripple" href="javascript:;"><span class="icon"><i class="material-icons">local_offer</i></span><span>Pricing</span></a>
        	<ul class="acc-menu">
	            <li><a  class="withripple" href="<?=site_url()?>product/price"><span>Current year - <?=date('Y')?></span></a></li>
				<li><a  class="withripple" href="<?=site_url()?>product/price/<?=date('Y', strtotime("+1 year"));?>"><span>Next year - <?=date('Y', strtotime("+1 year"));?></span></a></li>
			</ul>
    </li>
    
    <li><a  class="withripple" href="javascript:;"><span class="icon"><i class="material-icons">insert_drive_file</i></span><span>Reports</span></a>
        	<ul class="acc-menu">
                 <li><a  class="withripple" href="<?=site_url()?>reports/bookings"><span>Bookings</span></a></li>
                  <li><a  class="withripple" href="<?=site_url()?>reports/booking_allocation"><span>Booking allocation</span></a></li>
                <?php if(userAuthorisations('booking_duration_report')){?>
                    <li><a  class="withripple" href="<?=site_url()?>reports/booking_duration"><span>Booking duration</span></a></li>
                <?php } ?>
                 <li><a  class="withripple" href="<?=site_url()?>reports/caregiving_service"><span>Caregiving service report</span></a></li>
                 <li><a  class="withripple" href="<?=site_url()?>reports/clients_report"><span>Clients</span></a></li>
                 <li><a  class="withripple" href="<?=site_url()?>reports/college_auditing"><span>College audit</span></a></li>
                 <li><a  class="withripple" href="<?=site_url()?>reports/feedback"><span>Feedback</span></a></li>   
                 <li><a  class="withripple" href="<?=site_url()?>reports/booking_holidayCheckups"><span>Holiday check-up</span></a></li>   
                 <li><a  class="withripple" href="<?=site_url()?>reports/hfa"><span>Host family</span></a></li>
                <li><a  class="withripple" href="<?=site_url()?>reports/incidents"><span>Incidents</span></a></li>
                <li><a  class="withripple" href="<?=site_url()?>reports/insurance"><span>Insurance</span></a></li>
	            <li><a  class="withripple" href="<?=site_url()?>reports/invoice"><span>Invoice</span></a></li>
	            <li><a  class="withripple" href="<?=site_url()?>reports/parent_nominated_homestay"><span>Parents nominated homestay</span></a></li>
	            <li><a  class="withripple" href="<?=site_url()?>reports/profit"><span>Profit report</span></a></li>
	            <li><a  class="withripple" href="<?=site_url()?>reports/booking_regularCheckups"><span>Regular checkups</span></a></li>
                <li><a  class="withripple" href="<?=site_url()?>reports/revisits"><span>Revisits</span></a></li>
               <li><a  class="withripple" href="<?=site_url()?>reports/training_event"><span>Training event</span></a></li>
                <li><a  class="withripple" href="<?=site_url()?>reports/tour_groups"><span>Tour groups</span></a></li>
               <li><a  class="withripple" href="<?=site_url()?>reports/wwcc"><span>WWCC</span></a></li>
            </ul>
    </li>
    
    </ul>
</nav>
    </div>
</div>
                    </div>
                </div>