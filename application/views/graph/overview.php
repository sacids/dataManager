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
			<a class="navbar-brand" href="#">Project name</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li class="active"><a href="#">Home</a></li>
				<li><a href="#about">About</a></li>
				<li><a href="#contact">Contact</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
					   aria-expanded="false">Dropdown <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#">Action</a></li>
						<li><a href="#">Another action</a></li>
						<li><a href="#">Something else here</a></li>
						<li role="separator" class="divider"></li>
						<li class="dropdown-header">Nav header</li>
						<li><a href="#">Separated link</a></li>
						<li><a href="#">One more separated link</a></li>
					</ul>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="../navbar/">Default</a></li>
				<li><a href="../navbar-static-top/">Static top</a></li>
				<li class="active"><a href="./">Fixed top <span class="sr-only">(current)</span></a></li>
			</ul>
		</div><!--/.nav-collapse -->
	</div>
</nav>


<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2 sidebar">
			<ul class="nav nav-sidebar">
				<li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a>

					<ul>
						<?php foreach ($xforms as $form) { ?>
							<li><a href="#" id="<?php echo $form->form_id ?>"><?php echo $form->title ?></a></li>
						<?php } ?>
					</ul>

				</li>
			</ul>
			<!--			<ul class="nav nav-sidebar">-->
			<!--				<li><a href="">Nav item</a></li>-->
			<!--				<li><a href="">Nav item again</a></li>-->
			<!--				<li><a href="">One more nav</a></li>-->
			<!--				<li><a href="">Another nav item</a></li>-->
			<!--				<li><a href="">More navigation</a></li>-->
			<!--			</ul>-->

		</div>
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header" id="xform-title"><?php echo $first_record->title ?></h1>
			<div class="col-sm-12 col-lg-12">
				<?php echo form_open("#", 'class="form-inline" role="form"'); ?>
				<?php
				$options = array("" => "Select column to use as X-axis field");
				foreach ($table_fields as $key => $value) {
					$options[$value] = $value;
				}
				?>

				<div class="form-group">
					<label for="X-Axis"></label>
					<?php echo form_dropdown("x-axis", $options, $table_fields[3], 'class="form-control"'); ?>
				</div>
				<div class="form-group">
					<label for="Y-Axis"></label>
					<?php $options[""] = "Select column to use as Y-axis";
					echo form_dropdown("y-axis", $options, $table_fields[4], 'class="form-control"'); ?>
				</div>

				<div class="form-group">
					<div class="input-group date startdate" data-link-field="dtp_input1">
						<input type="text" size="10" id="startdate" name="startdate" placeholder="Start date"
						       value="" readonly class="form-control">
						<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group date enddate" data-link-field="dtp_input1">
						<input type="text" size="10" id="startdate" name="startdate" placeholder="End date"
						       value="" readonly class="form-control">
						<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>

			<div id="graph-content">
				<!--TODO Insert graph code here -->
			</div>

			<div class="">
				<pre>
					<?php print_r($table_fields_data); ?>
				</pre>
				<pre>
					<?php print_r($results); ?>
				</pre>
			</div>
		</div>
	</div>
</div>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?=base_url()?>assets/bootstrap/js/vendor/jquery.min.js"><\/script>')</script>
<script src="<?= base_url() ?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="<?= base_url() ?>assets/bootstrap/js/ie10-viewport-bug-workaround.js"></script>
<script src="<?= base_url() ?>assets/public/js/highcharts.js"></script>
</body>
</html>

<script type="text/javascript">

	$(function() {
		$('#graph-content').highcharts({
				chart: {
					type: 'column'
				},
				title: {
					text: 'Views'
				},
				xAxis: {
					categories: ['Mbuzi','Ng\'ombe','Punda','Kondoo']
				},
				yAxis: {
					title: {
						text: 'Views Count'
					}
				},
				series: [{
					name: 'Views',
					data: [3,4,6,1]
				}],
				credits: {enabled: false}
			}
		);
	});

	$(document).ready(function () {
		//working fine
		// Ajax calls here.
	});
</script>

