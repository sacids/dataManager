<?php
/**
 * Created by PhpStorm.
 * User: Godluck Akyoo
 * Date: 3/31/2016
 * Time: 10:13 AM
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="../../favicon.ico">

	<title><?php if (!empty($title)) echo $title; else "AfyaData Manager"; ?></title>

	<!-- Bootstrap core CSS -->
	<link href="<?= base_url() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<link href="<?= base_url() ?>assets/bootstrap/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="<?= base_url() ?>assets/bootstrap/css/navbar-fixed-top.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>

<body>

<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
			        aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo base_url() ?>">AfyaData Manager</a>

		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
					   aria-expanded="false">Forms <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><?php echo anchor('xform/forms', "List forms"); ?></li>
						<li><?php echo anchor('xform/add_new', "Add new form"); ?></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
					   aria-expanded="false">Manage users <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><?php echo anchor('auth/users_list', "List Users"); ?></li>
						<li><?php echo anchor('auth/create_user', "Create User"); ?></li>
						<li class="divider"></li>
						<li class="dropdown-header">Manage user groups</li>
						<li><?php echo anchor('auth/create_group', "Create Group"); ?></li>
						<li><?php echo anchor('auth/group_list', "List Groups"); ?></li>
					</ul>
				</li>

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
					   aria-expanded="false">OHKR <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li class="dropdown-header">Manage diseases</li>
						<li><?php echo anchor('xform/forms', "List diseases"); ?></li>
						<li><?php echo anchor('xform/add_new', "Add new disease"); ?></li>
						<li class="dropdown-header">Manage symptoms</li>
						<li><?php echo anchor('auth/group_list', "List symptoms"); ?></li>
						<li><?php echo anchor('auth/create_group', "Add new symptoms"); ?></li>
						<li class="dropdown-header">Manage species</li>
						<li><?php echo anchor('auth/group_list', "List species"); ?></li>
						<li><?php echo anchor('auth/group_list', "Add new specie"); ?></li>
					</ul>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="../navbar/">Default</a></li>
				<li class=""><a href="./" class="dropdown-toggle" data-toggle="dropdown" role="button"
				                aria-haspopup="true"
				                aria-expanded="false"><?php echo ucfirst($this->session->userdata("username")) ?>
						<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><?php echo anchor('auth/profile', "My Profile"); ?></li>
						<li><a href="#">Change password</a></li>
						<li><?php echo anchor('auth/logout', "Logout"); ?></li>
					</ul>
				</li>
			</ul>
		</div><!--/.nav-collapse -->
	</div>
</nav>