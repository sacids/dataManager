<!DOCTYPE div PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/public/js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/public/js/ajax.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/public/js/perms.js"></script>

</head>



<?php

// list fields of table
//$query 	= $this->db->query('DESCRIBE '.$table);



echo form_open('perm/submitted_data/');


$attributes = array(
		'class' 	=> 'ajax_submit',
		'style' 	=> 'color: #000;',
		'form_id'	=> 'tbl_1'
);
echo form_submit('submit','sumbit', $attributes);
echo form_close();




