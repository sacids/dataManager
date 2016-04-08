<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Perm extends CI_Controller {
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * http://sacids.com/index.php/start
	 * - or -
	 * http://example.com/index.php/welcome/index
	 * - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/dashboard/<method_name>
	 */
	var $module_id;
	public function __construct() {
		parent::__construct ();
		
		$this->load->model ( 'Perm_model' );
		$this->load->library ( 'db_exp' );
		// $this->perm_cond = $this->_get_perm_query_condition('perms');
	}
	function _remap($method_name = 'index') {
		if (! method_exists ( $this, $method_name )) {
			$this->index ();
		} else {
			$this->{$method_name} ();
		}
	}
	function _get_perm_query_condition($field) {
		$perms = $this->Perm_model->get_user_perms ( $this->session->userdata ( 'user_id' ) );
		$cond = ' ( false ';
		foreach ( $perms as $val ) {
			$cond .= " OR `" . $field . "` LIKE '%" . $val . "%'";
		}
		$cond .= " )";
		return $cond;
	}
	public function index() {
		
		// set module id
		$this->session->set_userdata ( 'module_id', $this->uri->segment ( 3, 0 ) );
		
		$modules	= $this->Perm_model->get_modules();
		
		// create within function
		$this->data ['sections'] = array ();
		$this->data ['sections'] ['0'] = array (
				'id' => '3',
				'title' => 'Administration',
				'display' => '7' 
		);
		$this->data ['sections'] ['1'] = array (
				'id' => '4',
				'title' => 'Sera',
				'display' => '5' 
		);
		$this->data['modules']	= $modules;
		$this->load->view ( 'perm/header', $this->data );
		
		// get all users options
		$this->load->view ( 'perm/body', $this->data );
	}
	public function new_perm() {
		$this->db_exp->set_table ( 'perm_tree' );
		$this->db_exp->set_db_select ( 'parent_id', 'perm_tree', 'id', 'title', 'parent_id in (0,1)' );
		$this->db_exp->set_select ( 'perm_target', array (
				'detail_wrp' => 'detail',
				'list_wrp' => 'list' 
		) );
		$this->db_exp->set_select ( 'perm_type', array (
				'link' => 'link',
				'label' => 'label',
				'table' => 'table',
				'select' => 'select',
				'db_select' => 'Db Select' 
		) );
		$this->db_exp->set_hidden ( 'perm_data' );
		$this->db_exp->set_hidden ( 'perms' );
		$this->db_exp->set_hidden ( 'module_id', $this->session->userdata ( 'module_id' ) );
		$this->db_exp->render ();
	}
	public function delete_row() {
		$table = $this->input->post ( 'table' );
		$tbl_id = $this->input->post ( 'id' );
		$sql = "Delete from $table where id = '$tbl_id'";
		if ($this->db->simple_query ( $sql )) {
			echo "Delete Success!";
		} else {
			echo "Delete failed!";
		}
	}
	public function list_perms() {
		// echo 'lists';
		// echo phpinfo();
		$this->db_exp->set_table ( 'perm_tree' );
		$this->db_exp->set_search_condition ( "module_id = '" . $this->session->userdata ( 'module_id' ) . "'" );
		$this->db_exp->set_hidden ( 'module_id' );
		$this->db_exp->set_hidden ( 'parent_id' );
		
		$link = array (
				'action' => 'perm/manage_perm',
				'target' => 'detail_wrp',
				'label' => 'view',
				'icon' => 'view',
				'args' => 'id' 
		);
		
		// $this->db_exp->set_permission(true,true,true,true);
		$this->db_exp->set_row_link ( $link );
		$this->db_exp->render ( 'col_list' );
	}
	public function set_perms() {
		
		$perm_id	= $this->session->userdata ( 'perm_id' );
		
		
		$options	= $this->get_perm_items($perm_id);
		$available_perms = $this->Perm_model->get_perms_array ( $this->session->userdata ( 'perm_id' ) );
		// print_r($available_perms);
		
		$this->db_exp->set_table ( 'perm_tree_details' );
		$this->db_exp->set_hidden ('perm_tree_id', $this->session->userdata ( 'perm_id' ) );	
		$this->db_exp->set_list ( 'perms', $available_perms );
		
		if(is_array($options)){
			$this->db_exp->set_search_condition ( "perm_tree_id = '" . $perm_id . "'" );
			$this->db_exp->set_select("items",$options);
			$this->db_exp->set_default_action("row_list");	
		}else{
			$res	= $this->Perm_model->get_table_data('perm_tree_details','perm_tree_id',$perm_id);
			print_r($res);
			$id		= $res[0]['id'];
			$this->db_exp->set_pri_id($id);
			$this->db_exp->set_hidden("items");
			$this->db_exp->set_default_action("insert");
		}
		
		$this->db_exp->render ();
	}
	
	private function get_perm_items($perm_id){
		
		$res = $this->Perm_model->get_field_data ( 'perm_type,perm_data', 'perm_tree', $this->session->userdata ( 'perm_id' ) );
		$perm_type = trim ( $res ['perm_type'] );
		$data	= json_decode($res['perm_data'],true);
		
		switch($perm_type){
			case 'db_select':
				
				$table	= $data['table'];
				$value	= $data['value'];
				$label	= $data['label'];
				
				$res	= $this->Perm_model->get_table_data($table);
				$options	= array();
				foreach($res as $val){
					$v	= $val[$value];
					$l	= $val[$label];
					$options[$v]	= $l;
				}
				break;
			default:
				return false;
		}
		
		return $options;
	}
	public function setup_perms() {
		$res = $this->Perm_model->get_field_data ( 'perm_type', 'perm_tree', $this->session->userdata ( 'perm_id' ) );
		$perm_type = trim ( $res ['perm_type'] );
		
		echo $perm_type;
		$fields = array ();
		
		switch ($perm_type) {
			
			case 'query' :
				$fields ['table'] ['type'] = 'select';
				$fields ['select'] ['type'] = 'text';
				break;
			case 'table':
				$this->db_exp->set_json_field('perm_data',array('table_id','controller'));
				$this->db_exp->set_db_select ( 'table_id', 'perm_tables', 'id', 'label', 'module_id = "'.$this->session->userdata ( 'module_id' ).'"' );
				$this->db_exp->set_hidden('controller','perm/manage_table');
				break;
			case 'table_list':
				$this->db_exp->set_json_field('perm_data',array('table_id','show','controller'));	
				$this->db_exp->set_db_select ( 'table_id', 'perm_tables', 'id', 'label', 'module_id = "'.$this->session->userdata ( 'module_id' ).'"' );
				$this->db_exp->set_input('show');
				$this->db_exp->set_hidden('controller','perm/list_table_data');
				break;
			case 'db_select':
				$this->db_exp->set_json_field('perm_data',array('table','value','label','name','controller'));
				$this->db_exp->set_input('table');
				$this->db_exp->set_input('value');
				$this->db_exp->set_input('label');
				$this->db_exp->set_input('name');
				$this->db_exp->set_input('controller');
				break;
			default:
				$this->db_exp->set_label ( 'perm_data', 'Set controler route' );
				break;
		}
		
		$this->db_exp->set_table ( 'perm_tree' );
		$this->db_exp->set_pri_id ( $this->session->userdata ( 'perm_id' ) );
		$this->db_exp->set_hidden ( array (
				'perms',
				'perm_target',
				'parent_id',
				'module_id',
				'title',
				'perm_type' 
		) );
		
		$this->db_exp->render ();
	}
	public function edit_perm() {
		$this->db_exp->set_table ( 'perm_tree' );
		$this->db_exp->set_pri_id ( $this->session->userdata ( 'perm_id' ) );
		$this->db_exp->set_db_select ( 'parent_id', 'perm_tree', 'id', 'title', 'parent_id in (0,1)' );
		$this->db_exp->set_select ( 'perm_target', array (
				'detail_wrp' => 'detail',
				'list_wrp' => 'list' 
		) );
		$this->db_exp->set_select ( 'perm_type', array (
				'link' => 'link',
				'label' => 'label',
				'table' => 'table',
				'controller' => 'controller',
				'table_list' => 'table list',
				'db_select' => 'db select',
				'select' => 'select' 
		) );
		$this->db_exp->set_hidden ( 'perm_data' );
		$this->db_exp->set_hidden ( 'perms' );
		$this->db_exp->render ();
	}
	public function manage_perm() {
		echo 'manage perm ';
		
		// print_r ( $this->input->post () );
		$this->session->set_userdata ( 'perm_id', $this->input->post ( 'id' ) );
		
		// print_r(get_class_methods($this));
		
		$uri = uri_string ();
		echo '<br>' . $uri;
		
		$this->do_perms_tabs ();
	}
	public function do_perms_tabs() {
		$this->data ['tabs'] = array (
				array (
						'title' => 'edit',
						'icon' => 'edit',
						'link' => 'perm/edit_perm' 
				),
				array (
						'title' => 'setup ',
						'icon' => 'settings',
						'link' => 'perm/setup_perms' 
				),
				array (
						'title' => 'Permissions ',
						'icon' => 'database',
						'link' => 'perm/set_perms' 
				) 
		);
		
		$this->load->view ( 'perm/show_tabs' );
	}
	public function new_table() {
		echo 'new table';
		$res = $this->Perm_model->get_field_data ( 'tables', 'perm_module', $this->session->userdata ( 'module_id' ) );
		$tables = explode ( ",", $res ['tables'] );
		
		$this->db_exp->set_table ( 'perm_tables' );
		
		echo ' module id ' . $this->session->userdata ( 'module_id' );
		
		$this->db_exp->set_hidden ( 'module_id', $this->session->userdata ( 'module_id' ) );
		$this->db_exp->set_select ( 'table_name', $tables, true );
		$this->db_exp->render ();
	}
	public function list_tables() {
		echo 'list tables dd';
		$this->load->library('pagination');
		
		$config['base_url'] = site_url('perm/list_tables');
		$config['total_rows'] = 1;
		$config['per_page'] = 1;
		
		$this->pagination->initialize($config);
		
		echo "jojo ".$this->pagination->create_links();
		
		// echo phpinfo();
		$this->db_exp->set_table ( 'perm_tables' );
		$this->db_exp->set_search_condition ( "module_id = '" . $this->session->userdata ( 'module_id' ) . "'" );
		$this->db_exp->set_hidden ( 'module_id' );
		
		$link = array (
				'action' => 'perm/manage_tables',
				'target' => 'detail_wrp',
				'label' => 'view',
				'icon' => 'view',
				'args' => 'id' 
		);
		
		// $this->db_exp->set_permission(true,true,true,true);
		$this->db_exp->set_row_link ( $link );
		$this->db_exp->render ( 'col_list' );
	}
	public function manage_tables() {
		echo 'manage tables ';
		$this->session->set_userdata ( 'table_id', $this->input->post ( 'id' ) );
		
		echo $this->session->userdata ( 'table_id' );
		$uri = uri_string ();
		echo '<br>' . $uri;
		
		$this->do_tables_tabs ();
	}
	public function do_tables_tabs() {
		$this->data ['tabs'] = array (
				array (
						'title' => 'edit',
						'icon' => 'edit',
						'link' => 'perm/edit_table' 
				),
				array (
						'title' => 'setup ',
						'icon' => 'settings',
						'link' => 'perm/setup_table' 
				),
				array (
						'title' => 'Filter ',
						'icon' => 'filter_list',
						'link' => 'perm/set_table_filters' 
				),
				array (
						'title' => 'Tabs ',
						'icon' => 'view_array',
						'link' => 'perm/set_table_actions'
				),
				array (
						'title' => 'Insert ',
						'icon' => 'input',
						'link' => 'perm/insert_table_data' 
				),
				array (
						'title' => 'View ',
						'icon' => 'view_module',
						'link' => 'perm/view_table_data' 
				) 
		);
		
		$this->load->view ( 'perm/show_tabs' );
	}
	public function edit_table() {
		echo 'edit table';
		
		$res = $this->Perm_model->get_field_data ( 'tables', 'perm_module', $this->session->userdata ( 'module_id' ) );
		$tables = explode ( ",", $res ['tables'] );
		
		$this->db_exp->set_table ( 'perm_tables' );
		$this->db_exp->set_pri_id ( $this->session->userdata ( 'table_id' ) );
		$this->db_exp->set_hidden ( 'module_id' );
		$this->db_exp->set_select ( 'table_name', $tables, true );
		$this->db_exp->render ( 'edit' );
	}
	public function setup_table() {
		
		print_r($this->input->post());
		
		$this->db_exp->set_table ( 'perm_tables_conf' );
		$this->db_exp->set_search_condition ( "table_id = '" . $this->session->userdata ( 'table_id' ) . "'" );
		$this->db_exp->set_hidden ( 'table_id', $this->session->userdata ( 'table_id' ) );
		
		$res = $this->Perm_model->get_field_data ( 'table_name', 'perm_tables', $this->session->userdata ( 'table_id' ) );
		$table_name = $res ['table_name'];
		
		$fields = $this->Perm_model->get_table_fields ( $table_name );
		
		$this->db_exp->set_select ( 'field_name', $fields, true );
		
		$field_property = array (
				'input',
				'hidden',
				'password',
				'upload',
				'textarea',
				'dropdown',
				'db_dropdown',
				'multiselect',
				'db_multiselect',
				'checkbox',
				'radio',
				'CI db_func',
				'date' 
		);
		$this->db_exp->set_select ( 'field_property', $field_property, true );
		
		$action = $this->input->post ( 'action' );
		switch ($action) {
			
			case 'edit' :
			case 'insert' :
				$act = 'insert';
				
				break;
			default :
				$act = 'row_list';
				break;
		}
		
		$this->db_exp->render ( $act );
	}
	public function set_table_filters(){

		$post	= $this->input->post();
		echo 'filters';
		print_r($post);
	
		
	}
	public function insert_table_data() {
		
		$table_id	= $this->session->userdata ( 'table_id' );
		$this->db_table_render($table_id);
		/*
		$res = $this->Perm_model->get_field_data ( 'table_name', 'perm_tables', $this->session->userdata ( 'table_id' ) );
		$table_name = $res ['table_name'];
		
		$fields = $this->Perm_model->get_table_data ( 'perm_tables_conf', 'table_id', $this->session->userdata ( 'table_id' ) );
		
		$this->db_exp->set_table ( $table_name );
		// print_r($fields);
		foreach ( $fields as $field ) {
			
			switch ($field ['field_property']) {
				
				case 'date' :
					$this->db_exp->set_date ( $field ['field_name'] );
					break;
			}
		}*/
		$this->db_exp->render ( 'insert' );
	}
	
	public function view_table_data() {
		$res = $this->Perm_model->get_field_data ( 'table_name', 'perm_tables', $this->session->userdata ( 'table_id' ) );
		$table_name = $res ['table_name'];
		
		// $fields = $this->Perm_model->get_table_data('perm_tables_conf','table_id',$this->session->userdata('table_id'));
		
		$this->db_exp->set_table ( $table_name );
		// print_r($fields);
		// foreach($fields as $field){
		
		// switch ($field['field_property']){
		
		// }
		
		// }
		
		$this->db_exp->render ( 'row_list' );
	}
	private function list_table_data() {
		
		echo 'salama';
		$post	= $this->input->post();
		print_r($post);
		
		$table_id	= $this->input->post('table_id');
		$show 		= $this->input->post('show');
		
		foreach($post as $key => $val){
			$$key = $val;
		}
		
		
		if(NULL !== $this->input->post('table_id')){
			$this->session->set_userdata('perm_tables_table_id',$this->input->post('table_id'));
		}
		if(NULL !== $this->session->userdata('perm_tables_table_id')){
			$table_id = $this->session->userdata('perm_tables_table_id');
		}
		
		if(!empty($table_id)){
			$res = $this->Perm_model->get_field_data ( 'table_name', 'perm_tables', $table_id);
			$table_name = $res ['table_name'];
		}
		
		if(!empty($table_name)){
		
			if(empty($show)){
				// get field names
				$fields	= $this->Perm_model->get_table_fields($table_name);
			}else{
				$fields		= explode(",",$show);
			}
			
			$data = $this->Perm_model->get_table_data($table_name);
			echo '<div class="db_exp_list_wrp">';
			foreach($data as $row){
				$args	= http_build_query($row);
				echo '<div class="perm_list_row group perm_list_link" action="'.site_url('perm/view_table').'" target="detail_wrp" args="'.$args.'">';
				foreach($fields as $val){
					echo '<div class="left perm_list_row_field">'.$row[$val].'</div>';
				}	
				echo '</div>';
			}
			echo '</div>';
		}else{
			
			echo 'table name not known';
		}
	
	}
	
	private function view_table(){
		
		$post	= $this->input->post();
		echo '<pre>'; print_r($post);
	}
	
	private function new_table_data() {
		
		//$this->load_points('build_Dalili_za_Binadamu_1418894655');
		$this->do_map();
		
		return;
		
		
		
		$table_id	= $this->input->post('table_id');
		if(!empty($table_id)){
			$this->session->set_userdata('table_id',$table_id);
		}
		
		$table_id	= $this->session->userdata('table_id');
		
		
		$this->db_table_render($table_id);
		
		
		$this->db_exp->render ( 'insert' );
	
	}
	
	
	public function load_points($form_id){
		
		$fields = $this->db->field_data($form_id);

		foreach ($fields as $field){
			
			if($field->type == 'point'){
				$gps_prefix	= substr($field->name,0,-6);
				break;
			}
		}
		
		$data	= $this->Perm_model->get_table_data($form_id);
		$str	= '<script type="text/javascript"> var addressPoints = [';
		$first	= 0;
		foreach($data as $val){			
			
			$lat	= $val[$gps_prefix.'_lat'];
			$lng	= $val[$gps_prefix.'_lng'];
			if(!$first++){
				//$str	.= '['.$lat.', '.$lng.', "a"]';
			}else{
				//$str	.= ',['.$lat.', '.$lng.', "a"]';
			}
		}

		
		$str	.= ']; </script>';
		echo $str;
	}
	public function do_map(){
		echo '	
				<div style="width:100%; height:100%" id="map"></div>
				<script type="text/javascript">
				
				
				
				
				
				
				
				
				
				
				var tiles = L.tileLayer("http://{s}.tile.osm.org/{z}/{x}/{y}.png", {
						maxZoom: 18,
						attribution: \'&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors, Points &copy 2012 LINZ\'
					}),
					latlng = L.latLng(-37.82, 175.24);
		
					var map = L.map("map", {center: latlng, zoom: 13, layers: [tiles]});
		
					var markers = L.markerClusterGroup();
		
				for(var i = 0; i < addressPoints.length; i++){
					var a = addressPoints[i];
					var title = a[2];
					var marker	= L.marker(new L.LatLng(a[0], a[1],{title: title}));
					marker.bindPopup(title);
					markers.addLayer(marker);
				}
				
				map.addLayer(markers);
				
				
				
				
				
				
				
				
				
				/*
				
					latlng = L.latLng(-37.82, 175.24);
		
					var map = L.map("map", {center: latlng, zoom: 13});
				
     			 var googleLayer = new L.Google("ROADMAP");
      			 map.addLayer(googleLayer);
		
					var markers = L.markerClusterGroup(); */
		
				</script>
				';
	}
	
	private function set_table_actions(){
		
		$post	= $this->input->post();
		//print_r($post);
		
		//echo 'mambo '.$this->session->userdata ( 'table_id' ) ;
		if(array_key_exists('ele_id', $post)){
			$this->db_exp->set_search_condition ( "table_id = '" . $post['ele_id']. "'" );
		}else{
			$this->db_exp->set_search_condition ( "table_id = '" . $this->session->userdata ( 'table_id' ) . "'" );
		}
		
		$this->db_exp->set_table ( 'perm_tree_actions' );
		
		$this->db_exp->set_hidden ( 'table_id', $this->session->userdata ( 'table_id' ) );
		
		
		$tables	= $this->Perm_model->get_table_data('perm_tables','module_id',$this->session->userdata('module_id'));
		$options	= array('0' => 'Controller');
		foreach($tables as $table){
			$key	= $table['id'];
			$val	= $table['label'];
			$options[$key]	= $val;
		}
		
		$table_A		= $this->Perm_model->get_field_data('table_name','perm_tables',$this->session->userdata ( 'table_id' ));
		$table_A_fields	= $this->Perm_model->get_table_fields ( $table_A['table_name'] );
		
		
		if(array_key_exists('id', $post)){
			$id				= $post['id'];
			$new_table_id	= $this->Perm_model->get_field_data('table_action_id','perm_tree_actions',$id);
			$new_table_id	= $new_table_id['table_action_id'];
			
			if($new_table_id == 0){
				$this->db_exp->set_hidden('perms');
				
			}else{
			
				$table_B		= $this->Perm_model->get_field_data('table_name','perm_tables',$new_table_id);
				$table_B_fields	= $this->Perm_model->get_table_fields ( $table_B['table_name'] );
				
				//$table_B_fields	= $this->Perm_model->get_table_fields ( $table_B['table_name'] );
				$this->db_exp->set_select('to',$table_B_fields,TRUE);
				
	
				$this->db_exp->set_json_field('args',array('match','oper','to','rend'));
				$this->db_exp->set_select('match',$table_A_fields,TRUE);
				$this->db_exp->set_select('oper',array('like','=','!=','<','>'),TRUE);
				$this->db_exp->set_select('rend',array('list','insert','edit'),TRUE);
			}
		}
		
		

		
		
		
		$action = $this->input->post ( 'action' );
		
		
		switch ($action) {
				
			case 'edit' :
				echo 'edito '.$id;
				$this->db_exp->set_hidden('id',$id);
				$this->db_exp->set_hidden(array('title','icon','table_action_id','perms'));
				
				$act = 'edit';
				break;
			case 'insert' :
				//echo 'inserto';
				$this->db_exp->set_select('table_action_id',$options);
				$this->db_exp->set_hidden('args');
				$act = 'insert';	
				break;
			default :
				//echo 'listo';
				$this->db_exp->set_select('table_action_id',$options);			
				$this->db_exp->set_hidden('args');
				$act = 'row_list';
				break;
		}
		
		$this->db_exp->render ( $act );
		
	}
	
	
	public function list_forms(){
		
		$forms	= $this->Perm_model->get_table_data('xforms');
		foreach($forms as $form){
			
			$args	= http_build_query($form);
			echo '<div class="perm_list_row perm_list_link" target="detail_wrp" action="'.site_url('perm/form_detail').'" args="'.$args.'">'.$form['title'].'</div>';
		}
	}
	
	public function form_detail(){
		
		$form_data	= $this->input->post();
		foreach($form_data as $key => $val){
			$this->session->set_userdata($key,$val);
		}

		$this->do_form_details_tabs();
	}
	public function do_form_details_tabs() {
		$this->data ['tabs'] = array (
				array (
						'title' => 'show',
						'icon' => 'edit',
						'link' => 'perm/form_detail_show'
				),
				array (
						'title' => 'filters ',
						'icon' => 'settings',
						'link' => 'perm/form_detail_filters'
				),
				array (
						'title' => 'List Perms ',
						'icon' => 'settings',
						'link' => 'perm/form_detail_list_perm'
				),
				array (
						'title' => 'Detail Perms ',
						'icon' => 'settings',
						'link' => 'perm/form_detail_detail_perm'
				)
		);
		
		$this->load->view ( 'perm/show_tabs' );
	}
	
	public function form_detail_show(){
		echo 'show <br><br>';
		print_r($this->session->userdata());
		
		$res = $this->Perm_model->get_field_data ( 'perm_type', 'perm_tree', $this->session->userdata ( 'perm_id' ) );
		$perm_type = trim ( $res ['perm_type'] );
		
		echo $perm_type;
		$fields = array ();
		
		switch ($perm_type) {
				
			case 'query' :
				$fields ['table'] ['type'] = 'select';
				$fields ['select'] ['type'] = 'text';
				break;
			case 'table_list':
				$this->db_exp->set_json_field('perm_data',array('table_id','show','controller'));
				$this->db_exp->set_db_select ( 'table_id', 'perm_tables', 'id', 'label', 'module_id = "'.$this->session->userdata ( 'module_id' ).'"' );
				$this->db_exp->set_input('show');
				$this->db_exp->set_hidden('controller','perm/list_table_data');
				break;
			case 'db_select':
				$this->db_exp->set_json_field('perm_data',array('table','value','label','name','controller'));
				$this->db_exp->set_input('table');
				$this->db_exp->set_input('value');
				$this->db_exp->set_input('label');
				$this->db_exp->set_input('name');
				$this->db_exp->set_input('controller');
				break;
			default:
				$this->db_exp->set_label ( 'perm_data', 'Set controler route' );
				break;
		}
		
		$this->db_exp->set_table ( 'perm_tree' );
		$this->db_exp->set_pri_id ( $this->session->userdata ( 'perm_id' ) );
		$this->db_exp->set_hidden ( array (
				'perms',
				'perm_target',
				'parent_id',
				'module_id',
				'title',
				'perm_type'
		) );
		
		$this->db_exp->render ();
	}
	public function form_detail_filters(){
		echo 'detail filters <br><br>';
		print_r($this->session->userdata());
	}
	public function form_detail_list_perm(){
		echo 'Detail list perm <br><br>';
		print_r($this->session->userdata());
	}
	public function form_detail_detail_perm(){
		echo 'Detail Perm <br><br>';
		print_r($this->session->userdata());
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function manage_table($table_id = false){
		
		
		$post		=  $this->input->post();
		print_r($post);
		echo 'jembe';
		$table_id	= $this->input->post('table_id');
		
		if(NULL !== $this->input->post('table_id')){
			$this->session->set_userdata('perm_tables_table_id',$this->input->post('table_id'));
		}
		if(NULL !== $this->session->userdata('perm_tables_table_id')){
			$table_id = $this->session->userdata('perm_tables_table_id');
		}
		
		$res = $this->Perm_model->get_field_data ( 'table_name', 'perm_tables', $table_id);
		$table_name = $res ['table_name'];
		
		// get filters
		
		// jquery to load initial results
		
		echo '<div class="">';
		echo '<div class="group">';
		
		// search box
		$data = array(
				'name'          => 'search',
				'id'            => 'search',
				'value'         => '',
				'class'			=> 'manage_table_searchbox',
				'content'       => ''
		);
		echo '	<div 	class="left">'
							 .form_input($data).'
				</div>';
		// new icon
		
		echo '	<div 	target="detail_wrp"
						action="'.site_url('perm/new_table_data').'"
						args="table_id='.$table_id.'"
						class="perm_btn right m_link" >
							<i class="material-icons md-dark">add_box</i>
				</div>';
		
		// close group
		echo '</div>';
		
		// advance search link
		echo '<div id="adv_search_link">advance search</div>';
		
		// advance search div
		echo '<div id="adv_search" class="hidden">';
		$this->db_exp->set_table ( $table_name );
		$this->db_exp->set_form_hidden_values('table_id',$table_id);
		$this->db_exp->set_form_action('perm/do_advance_search');
		$this->db_exp->set_form_attribute('target','manage_table_search_results');
		$this->db_exp->render('edit');
		echo '</div>';
		// list results div
		echo '<div id="manage_table_search_results" class="perm_target_divs">';
		
		// initial results
		$this->table_results($table_id, 10);
		
		
		// end of results div
		echo '</div>'; 
		
		
		
		
		
	}
	function table_results($table_id, $items_per_page = 5, $cond = false){
		
		$res = $this->Perm_model->get_field_data ( 'table_name', 'perm_tables', $table_id);
		$table_name = trim($res ['table_name']);
		
		// get page
		$page	= $this->input->post();
		if( NULL !== $this->input->post('page')){
			$page_num = $this->input->post('page');
		}else{
			$page_num = 1;
		}
		
		$total_rows		= $this->db->count_all($table_name);
		$total_pages	= ceil($total_rows/$items_per_page);
		$page_pos		= ($page_num - 1)*$items_per_page;
		
		$results		= $this->Perm_model->paginate_table($table_name, $page_pos, $items_per_page, $cond);
		
		$start			= true;
		echo '<table class="table_wrp" table_id="'.$table_id.'" table_name="'.$table_name.'" action="'.site_url('perm/table_data_detail').'">';
		foreach($results->result_array() as $row){		
		
			$hd	= '';
			$bd	= '';
			foreach($row as $key => $val){
				
				if($key == 'id') 		continue;
				if(strstr($key,'_id')) 	continue;
				
				if($start){
					$label	= str_replace("_", " ", str_replace("_id","",$key));
					$hd	.= '<td class="left table_res_header cell_'.$key.'" tag="'.$key.'">'.$label.'</td>';
				}
					
				$bd	.= '<td class="left table_res_cell cell_'.$key.'" tag="'.$key.'">'.$val.'</td>';				
			}
			
			if($start){
				echo '<tr class="group table_res_row">'.$hd.'</tr>';
				$start	= false;
			}
			echo '<tr class="group table_res_row" id="'.$row['id'].'">'.$bd.'</tr>';						
		}	
		echo '</div>';
	}
	function do_advance_search(){
		$post	= $this->input->post();
		echo '<pre>';
		//print_r($post);
		
		$cond	= array();
		foreach($post as $key => $val){
			
			if($key == 'table_id'){
				$table_id	= $val;
			}elseif($key == 'db_exp_submit_engaged'){
				// do nothing
			}else{
				if(empty($val)) continue;
				$tmp	= '`'.$key.'`'." = '$val'";
				array_push($cond,$tmp);
			}
			
		}
		
		$str	= implode(" OR ",$cond);
		$this->table_results($table_id, 5, $str);
		
	}
	
	function table_data_detail(){
		
		$post	= $this->input->post();
		echo '<pre>';
		print_r($post);
		echo '</pre>';
		
		$this->data ['tabs']	= $this->Perm_model->get_tabs($post);
		$this->load->view ( 'perm/show_tabs' );
		
	}
	
	public function table_set_perms() {
	
		echo 'table set pers';
		
		$post	= $this->input->post();
		print_r($post);
		$perm_id	= $post['ele_id'];
		if(!empty($perm_id)){
			$this->session->set_userdata('perm_id',$perm_id);
		}
		$perm_id	= $this->session->userdata('perm_id');
	
		$available_perms = $this->Perm_model->get_perms_array ( $perm_id );
		// print_r($available_perms);
	
		$this->db_exp->set_table ( 'perm_tree_details' );
		$this->db_exp->set_hidden ('perm_tree_id', $perm_id );
		$this->db_exp->set_list ( 'perms', $available_perms );
		$this->db_exp->set_hidden('ele_id',$perm_id);
	
		
		$res	= $this->Perm_model->get_table_data('perm_tree_details','perm_tree_id',$perm_id);
		if(is_array($res)){
			$id		= $res[0]['id'];
			$this->db_exp->set_pri_id($id);
		}
		$this->db_exp->set_hidden("items");
		$this->db_exp->set_default_action("insert");
	
	
		$this->db_exp->render ();
	}
	
	function link_table_action(){
		
		$post	= $this->input->post();
		
		//return;
		
		if(count($post) != 0){
			$this->session->set_userdata('post',$post);
			echo ' chachacha';
			//return;		
		}

		print_r($this->session->userdata['post']);
		
		$args 		= $this->session->userdata['post']['args'];
		$ele_id		= $this->session->userdata['post']['ele_id'];
		$table_id	= $this->session->userdata['post']['table_id'];
		//print_r($post);
		
		$args	= json_decode($args,true);
		//print_r($post);
		//print_r($args);
		
		
		$this->db_table_render($table_id);
		if($args['rend'] == 'edit'){
			$this->db_exp->set_pri_id($ele_id);		
		}
		
		//echo '<pre>'; print_r($this->db_exp);
		$this->db_exp->render('edit');
		
	}
	
	
	
	
	
	
	
	function page_not_found(){
		
		echo 'page not found';
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function db_table_render($table_id){
		
		$res = $this->Perm_model->get_field_data ( 'table_name', 'perm_tables', $table_id);
		$table_name = $res ['table_name'];
		
		$fields = $this->Perm_model->get_table_data ( 'perm_tables_conf', 'table_id', $table_id );
		
		$this->db_exp->set_table ( $table_name );
		
		foreach ( $fields as $field ) {
		
			parse_str($field['field_value'], $args);
				
			switch ($field ['field_property']) {
		
				case 'date' :
					$this->db_exp->set_date ( $field ['field_name'] );
					break;
				case 'CI db_func':
					$func_name	= $args['name'];
					if($func_name == 'list_tables'){
						$options	= $this->db->list_tables();
					}
					$this->db_exp->set_list($field ['field_name'],$options);
					break;
				case 'dropdown':
					$options	= explode(",", $field ['field_value']);
					$this->db_exp->set_select($field ['field_name'] ,$options,true);
					break;
				case 'db_dropdown':
					$options	= explode(":",$field ['field_value']);
					print_r($options);
					$cond	= false;
					if(array_key_exists(3, $options)) $cond = $options[3];
					$this->db_exp->set_db_select($field ['field_name'], $options[0], $options[1], $options[2],$cond); 
					break;
				case 'hidden':
					$this->db_exp->set_hidden($field ['field_name'] ,$field ['field_value']);
					break;
						
			}
		}	
	}
}

/* End of file start.php */
/* Location: ./application/controllers/start.php */