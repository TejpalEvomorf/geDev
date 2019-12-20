<!DOCTYPE html>
<html lang="en" class="coming-soon">
<head>
    <meta charset="utf-8">
    <title>Login Form</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="author" content="KaijuThemes">

    <link type='text/css' href='http://fonts.googleapis.com/css?family=Roboto:300,400,400italic,500' rel='stylesheet'>
    <link type='text/css'  href="https://fonts.googleapis.com/icon?family=Material+Icons"  rel="stylesheet"> 
    <link href="<?=static_url()?>system/plugins/progress-skylo/skylo.css" type="text/css" rel="stylesheet">                   <!-- Skylo -->

    <link href="<?=static_url()?>system/fonts/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet">
    <link href="<?=static_url()?>system/css/styles.css" type="text/css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Placeholdr.js enables the placeholder attribute -->
    <!--[if lt IE 9]>
        <link href="<?=static_url()?>system/css/ie8.css" type="text/css" rel="stylesheet">
        <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The following CSS are included as plugins and can be removed if unused-->
    
    </head>

    <body class="focused-form animated-content">
        
        
<div class="container" id="login-form">
	<a href="http://www.globalexperience.com.au" target="_blank" class="login-logo"><img src="<?=static_url()?>system/img/report-logo.png"></a>
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h2>Login Form</h2>
					</div>
					<div class="panel-body">
							<?php
									$error = $this->session->flashdata('error'); 
									if(!empty($error))
									{?>
														<div class="alert alert-dismissable alert-danger">
															<i class="fa fa-close"></i> <?=$error?>
															<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
														</div>
							<?php } ?>
						<form action="<?=site_url()?>admin/login" class="form-horizontal" id="loginForm" method="post">
							<div class="form-group mb-md">
		                        <div class="col-xs-12">
		                        	<div class="input-group">							
										<span class="input-group-addon">
											<i class="ti ti-user"></i>
										</span>
										<input type="text" class="form-control" placeholder="Username/Email Id" name="uname">
									</div>
		                        </div>
							</div>

							<div class="form-group mb-md">
		                        <div class="col-xs-12">
		                        	<div class="input-group">
										<span class="input-group-addon">
											<i class="ti ti-key"></i>
										</span>
										<input type="password" class="form-control"  placeholder="Password" name="password">
									</div>
		                        </div>
							</div>

							<div class="col-xs-12">
                                  <div class="checkbox-inline icheck pull-left p-n">
                                      <div class="checkbox">
                                          <div class="checkbox block"><label><input type="checkbox" name="remember" checked> Keep me logged in</label></div>
                                      </div>
                                  </div>
                              </div>
							
						</form>
					</div>
					<div class="panel-footer">
						<div class="clearfix">
							<!--<a href="extras-registration.html" class="btn btn-default pull-left">Register</a>-->
							<a href="javascript:void(0);" class="btn btn-success btn-raised pull-right" onClick="submitLoginForm();">Login</a>
						</div>
					</div>
				</div>
			</div>
		</div>
</div>

    
    
    <!-- Load site level scripts -->

<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script> -->

<script src="<?=static_url()?>system/js/jquery-1.10.2.min.js"></script> 							<!-- Load jQuery -->
<script src="<?=static_url()?>system/js/jqueryui-1.10.3.min.js"></script> 							<!-- Load jQueryUI -->
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
<script src="<?=static_url()?>system/demo/demo.js"></script>
<script src="<?=static_url()?>system/demo/demo-switcher.js"></script>

<!-- End loading site level scripts -->
    <!-- Load page level scripts-->
    

    <!-- End loading page level scripts-->
<script type="text/javascript">

	function submitLoginForm()
	{
		$('#loginForm').submit();
	}
	
</script>    
    </body>
</html>