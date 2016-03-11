<!DOCTYPE div PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Sacids Research Portal</title>
	<!--<link rel="icon" type="image/png" href="<?php echo base_url(); ?>favicon.png" />-->

	<link type="text/css" rel="stylesheet"
	      href="<?php echo base_url(); ?>assets/public/font-awesome/css/font-awesome.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/public/css/960.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/public/css/reset.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/public/css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/public/css/superfish.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/public/css/tipsy.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/public/css/text.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/public/css/base.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/public/css/grid.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/public/css/buttons.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/public/css/form.css">
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/public/js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/public/js/superfish.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/public/js/tipsy.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/public/js/chain.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/public/js/ajax.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/public/js/sacids.js"></script>


	<script type="text/javascript">
		$(document).ready(function () {
			var h = $(window).height() - $('div#content-middle-home').offset().top - 50;
			$('div#content-middle').css({"min-height": h + "px"});
		});
		$(document).ready(function () {
			$('#nav > li > a').click(function () {
				if ($(this).attr('class') != 'active') {
					$('#nav li ul').slideUp();
					$(this).next().slideToggle();
					$('#nav li a').removeClass('active');
					$(this).addClass('active');
				}
			});
		});
	</script>
</head>

<body>


<div id="navbar">
	<div class="container_12">
		<ul class="sf-menu">
			<li><a href="<?php echo site_url('dashboard'); ?>">Dashboard</a></li>
			<li><a href="#">Settings</a></li>
			<li><a href="<?php echo site_url('xform/forms'); ?>">Forms</a></li>
			<li><a href="<?php echo site_url('disease/diseases'); ?>">Diseases</a></li>
			<li><a href="#">Feedback</a></li>
			<li><a href="#">Reports and Analysis</a></li>
			<li><a href="<?php echo site_url('auth/profile'); ?>">My Profile</a></li>
			<li><a href="<?php echo site_url('auth/users_list'); ?>">Manage Users</a></li>
			<li><a href="<?php echo site_url('auth/logout'); ?>">Logout</a></li>
		</ul>

		<div style="clear: both;"></div>
	</div>
</div>

 



