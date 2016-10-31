<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Favicon -->
	<link rel="icon" type="image/png" href="<?php echo base_url(); ?>favicon.png"/>

	<title>AfyaData - <?php if (!empty($title)) echo $title; else "Taarifa kwa wakati!"; ?></title>

	<!-- Bootstrap core CSS -->
	<link href="<?= base_url() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- Google fonts - witch you want to use - (rest you can just remove) -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>

	<!-- Leaflet, marker cluster js and css -->
	<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7/leaflet.css"/>
	<script src="http://cdn.leafletjs.com/leaflet-0.7/leaflet.js"></script>
	<script type="text/javascript"
			src="<?php echo base_url(); ?>assets/public/leaflet/dist/leaflet.markercluster-src.js"></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/public/leaflet/dist/MarkerCluster.css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/public/leaflet/dist/MarkerCluster.Default.css"/>

	<!-- Custom CSS -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/public/css/afyadata.css" type="text/css">
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/public/js/afyadata.js"></script>


	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<link href="<?= base_url() ?>assets/bootstrap/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="<?= base_url() ?>assets/bootstrap/css/navbar-fixed-top.css" rel="stylesheet">

	<!-- Font awesome css -->
	<link href="<?php echo base_url(); ?>assets/bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet"
		  type="text/css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/public/css/perm.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/public/css/db_exp.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/public/iconfont/material-icons.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/public/css/jquery-ui.min.css">
	<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7/leaflet.css" />
	<link rel="stylesheet" href="http://127.0.0.1/dataManager/assets/public/leaflet/dist/MarkerCluster.css" />
	<link rel="stylesheet" href="http://127.0.0.1/dataManager/assets/public/leaflet/dist/MarkerCluster.Default.css" />

	<style>
		/* Remove the navbar's default margin-bottom and rounded borders */
		.navbar {
			margin-bottom: 0;
			border-radius: 0;
		}

		/* Set height of the grid so .sidenav can be 100% (adjust as needed) */
		.row.content {height: 750px}

		/* Set gray background color and 100% height */
		.sidenav {
			padding-top: 20px;
			background-color: #f1f1f1;
			height: 100%;
		}

		/* Set black background color, white text and some padding */
		footer {
			background-color: #555;
			color: white;
			padding: 15px;
		}

		/* On small screens, set height to 'auto' for sidenav and grid */
		@media screen and (max-width: 767px) {
			.sidenav {
				height: auto;
				padding: 15px;
			}
			.row.content {height:auto;}
		}
	</style>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
					aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="http://afyadata.sacids.org/demo/dashboard" class="navbar-brand"><img src="http://afyadata.sacids.org/demo/assets/public/images/logo.png" alt="AfyaData" height="30"/></a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">

				<?php

				if ($this->session->userdata ( "user_id" ) == 1) {

				?>

				<li class="">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
					   aria-expanded="false">Administration<span class="caret"></span></a>
					<ul class="dropdown-menu">

						<li>
							<a class="link"
							   target="list_wrp"
							   label="Manage Permission"
							   args="table_id=1&perm_id=1"
							   action="<?php echo site_url("perm/manage_table") ?>">
								<i class="material-icons md-dark" style="font-size:10px;">domain</i> Manage Permissions
							</a>
						</li>
						<li>
							<a class="link"
							   target="list_wrp"
							   label="Manage Filters"
							   args="table_id=7&perm_id=1"
							   action="<?php echo site_url("perm/manage_table") ?>">
								<i class="material-icons md-dark" style="font-size:10px;">filter_list</i> Manage Filters
							</a>
						<li>
							<a class="link"
							   target="list_wrp"
							   label="Manage Tables"
							   args="table_id=3&perm_id=1"
							   action="<?php echo site_url("perm/manage_table") ?>">
								<i class="material-icons md-light" style="font-size:10px;"> view_list</i>Manage Tables
							</a>
						</li>

						<li>
							<a class="link"
							   target="list_wrp"
							   label="Manage Users"
							   args="table_id=5&perm_id=1"
							   action="<?php echo site_url("perm/manage_table") ?>">
								<i class="material-icons md-light" style="font-size:10px;"> account_circle</i> Manage Users
							</a>
						</li>
						<li>
							<a class="link"
							   target="list_wrp"
							   label="Manage Groups"
							   args="table_id=6&perm_id=1"
							   action="<?php echo site_url("perm/manage_table") ?>">
								<i class="material-icons md-light " style="font-size:10px;">group</i> Manage Groups
							</a>
						</li>
						<li>
							<a class="link"
							   target="list_wrp"
							   label="Manage Modules"
							   args="table_id=4&perm_id=1"
							   action="<?php echo site_url("perm/manage_table") ?>">
								<i class="material-icons md-light" style="font-size:10px;">dashboard</i>  sManage Modules
							</a>
						</li>
					</ul>
				</li>
		<?php
		}

				foreach($this->data['modules'] as $val){

					$module_id		= $val['id'];
					if($module_id == 1) continue;
					$module_title	= $val['title'];

					$label 	= $this->Perm_model->get_tasks ($module_id);
					$parts	= array();

					echo '	<li class="">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$module_title.'<span class="caret"></span></a>
								<ul class="dropdown-menu">';

					foreach ( $label as $k => $v ) {

						$type = $v['perm_type'];
						$title = $v['title'];
						$icon = $v['icon_font'];

						//print_r($v);
						if (empty($icon)) $icon = 'open_in_new';

						$args = $v['perm_data'];
						$json = json_decode($v['perm_data'], true);
						$json['perm_id'] = $v['id'];


						$post_args = http_build_query($json);
						if ($type == 'table') {
							$url = 'perm/manage_table';
							$post_args = http_build_query($json);
						} else {
							//echo 'chocho';
							//print_r($v);
							parse_str($post_args, $parts);
							$url = $v['perm_data'];
						}

						echo '	<li><a href="#" target="' . $v ['perm_target'] . '" action="' . site_url($url) . '" args=\'' . $post_args . '\' label="' . $title . '">
									<i class="material-icons md-light">' . $icon . '</i>
									' . $title . '
								</li>';
					}

					echo '</ul></li>';
				}

				?>
			</ul>
		</div>
	</div>
</nav>




