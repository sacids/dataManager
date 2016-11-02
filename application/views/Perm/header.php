<!DOCTYPE div PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Sacids Research Portal</title>
	<!--<link rel="icon" type="image/png" href="<?php echo base_url(); ?>favicon.png" />-->

	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/public/css/perm.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/public/css/db_exp.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/public/iconfont/material-icons.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/public/css/jquery-ui.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/obox/obox.css">

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/public/js/jquery-1.12.1.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/public/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/public/js/perms.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/public/js/db_exp.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/obox/obox.js"></script>
	
	
	<script src="http://cdn.leafletjs.com/leaflet-0.7/leaflet.js"></script>
	<script type="text/javascript" src="http://127.0.0.1/dataManager/assets/public/leaflet/dist/leaflet.markercluster-src.js"></script>
	
	<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7/leaflet.css" />
	<link rel="stylesheet" href="http://127.0.0.1/dataManager/assets/public/leaflet/dist/MarkerCluster.css" />
	<link rel="stylesheet" href="http://127.0.0.1/dataManager/assets/public/leaflet/dist/MarkerCluster.Default.css" />
	

</head>
<body>
<div id="header_wrp" class="header_wrp group box_shadow topnav">
		&nbsp;
		<?php 
		
			//echo '<pre>'; print_r($this->data);
			foreach($this->data['modules'] as $val){
				
				if($this->session->userdata('module_id') == $val['id']){
					$class = 'active';
				}else{
					$class = 'inactive';
				}
				
				echo '<a class="'.$class.'" href="'. site_url('perm').'/'.$val['title'].'/'.$val['id'].'">'.$val['title'].'</a>';
			}
		?>
		<a class="right" href="<?php echo site_url('auth/logout'); ?>">Logout</a>
		&nbsp;&nbsp;
</div>

 </body>



