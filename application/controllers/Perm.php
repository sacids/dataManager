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
	var $perm_id;
	public function __construct() {
		
		parent::__construct ();
		
		$this->load->model ( array (
				'Perm_model',
				'User_model' 
		) );
		// $this->load->model ( 'Perm_model' );
		$this->load->library ( 'db_exp' );


	}
	function _remap($method_name = 'index') {
		if (! method_exists ( $this, $method_name )) {
			$this->index ();
		} else {
			$this->{$method_name} ();
		}
		
		
	}
	
	public function index() {

		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		}
		// set module id
		$this->session->set_userdata ( 'module_id', $this->uri->segment ( 3, 0 ) );
		
		$modules = $this->Perm_model->get_modules ();
		$this->data['modules'] = $modules;
		$this->load->view ( 'perm/header', $this->data );
		// get all users options
		$this->load->view ( 'perm/body', $this->data );
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
	
	public function save_dbexp_post_vars() {
		$post = $this->input->post ();
		$db_exp_submit = $this->input->post ( 'db_exp_submit_engaged' );
		if (! empty ( $db_exp_submit ) || @$post ['action'] == 'insert' || @$post ['action'] == 'edit') {
		} else {
			$this->session->set_userdata ( 'post', $post );
		}
	}
	public function setup_perms() {
		$this->save_dbexp_post_vars ();
		
		
		$args = $this->session->userdata ['post'] ['args'];
		$ele_id = $this->session->userdata ['post'] ['ele_id'];
		$table_id = $this->session->userdata ['post'] ['table_id'];
		
		$perm_id = $ele_id;
		
		$res = $this->Perm_model->get_field_data ( 'perm_type', 'perm_tree', $perm_id );
		$perm_type = trim ( $res ['perm_type'] );
		
		// echo $perm_type;
		$fields = array ();
		
		switch ($perm_type) {
			
			case 'query' :
				$fields ['table'] ['type'] = 'select';
				$fields ['select'] ['type'] = 'text';
				break;
			case 'table' :
				$this->db_exp->set_json_field ( 'perm_data', array (
						'table_id',
						'controller',
						'add_controller' 
				) );
				$this->db_exp->set_db_select ( 'table_id', 'perm_tables', 'id', 'label', 'module_id = "' . $this->session->userdata ( 'module_id' ) . '"' );
				$this->db_exp->set_hidden ( 'controller', 'perm/manage_table' );
				$this->db_exp->set_input ( 'add_controller' );
				$this->db_exp->set_hidden ( array (
						'id',
						'icon_font' 
				) );
				break;
			case 'table_list' :
				$this->db_exp->set_json_field ( 'perm_data', array (
						'table_id',
						'show',
						'controller' 
				) );
				$this->db_exp->set_db_select ( 'table_id', 'perm_tables', 'id', 'label', 'module_id = "' . $this->session->userdata ( 'module_id' ) . '"' );
				$this->db_exp->set_input ( 'show' );
				$this->db_exp->set_hidden ( 'controller', 'perm/list_table_data' );
				break;
			case 'db_select' :
				$this->db_exp->set_json_field ( 'perm_data', array (
						'table',
						'value',
						'label',
						'name',
						'controller' 
				) );
				$this->db_exp->set_input ( 'table' );
				$this->db_exp->set_input ( 'value' );
				$this->db_exp->set_input ( 'label' );
				$this->db_exp->set_input ( 'name' );
				$this->db_exp->set_input ( 'controller' );
				break;
			default :
				$this->db_exp->set_label ( 'perm_data', 'Set controler route' );
				break;
		}
		
		$this->db_exp->set_table ( 'perm_tree' );
		$this->db_exp->set_pri_id ( $perm_id );
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
	
	

	
	public function setup_table() {
		$this->save_dbexp_post_vars ();
		
		
		$args = $this->session->userdata ['post'] ['args'];
		$ele_id = $this->session->userdata ['post'] ['ele_id'];
		$table_id = $this->session->userdata ['post'] ['table_id'];
		
		$this->db_exp->set_table ( 'perm_tables_conf' );
		$this->db_exp->set_search_condition ( "table_id = '" . $ele_id . "'" );
		$this->db_exp->set_hidden ( 'table_id', $ele_id );
		
		$res = $this->Perm_model->get_field_data ( 'table_name', 'perm_tables', $ele_id );
		$table_name = $res ['table_name'];
		
		$fields = $this->Perm_model->get_table_fields ( $table_name );
		
		$this->db_exp->set_select ( 'field_name', $fields, true );
		
		$field_property = array (
				'input',
				'hidden',
				'view',
				'password',
				'label',
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
	
	
	private function list_table_data_xxx() {
		echo 'salama';
		$post = $this->input->post ();
		print_r ( $post );
		
		$table_id = $this->input->post ( 'table_id' );
		$show = $this->input->post ( 'show' );
		
		foreach ( $post as $key => $val ) {
			$$key = $val;
		}
		
		if (NULL !== $this->input->post ( 'table_id' )) {
			$this->session->set_userdata ( 'perm_tables_table_id', $this->input->post ( 'table_id' ) );
		}
		if (NULL !== $this->session->userdata ( 'perm_tables_table_id' )) {
			$table_id = $this->session->userdata ( 'perm_tables_table_id' );
		}
		
		if (! empty ( $table_id )) {
			$res = $this->Perm_model->get_field_data ( 'table_name', 'perm_tables', $table_id );
			$table_name = $res ['table_name'];
		}
		
		if (! empty ( $table_name )) {
			
			if (empty ( $show )) {
				// get field names
				$fields = $this->Perm_model->get_table_fields ( $table_name );
			} else {
				$fields = explode ( ",", $show );
			}
			
			$data = $this->Perm_model->get_table_data ( $table_name );
			echo '<div class="db_exp_list_wrp">';
			foreach ( $data as $row ) {
				$args = http_build_query ( $row );
				echo '<div class="perm_list_row group perm_list_link" action="' . site_url ( 'perm/view_table' ) . '" target="detail_wrp" args="' . $args . '">';
				foreach ( $fields as $val ) {
					echo '<div class="left perm_list_row_field">' . $row [$val] . '</div>';
				}
				echo '</div>';
			}
			echo '</div>';
		} else {
			
			echo 'table name not known';
		}
		
	}
	private function new_table_data() {
		
		$table_id = $this->input->post ( 'table_id' );
		if (! empty ( $table_id )) {
			$this->session->set_userdata ( 'table_id', $table_id );
		}		
		$table_id = $this->session->userdata ( 'table_id' );
		$this->db_exp->set_form_attribute('class','view_table_row');
		$this->db_table_render ( $table_id );		
		$this->db_exp->render ( 'insert' );
		
		
		
	}
	private function set_table_actions() {
		$post = $this->input->post ();
		
		if (array_key_exists ( 'ele_id', $post )) {
			$this->db_exp->set_search_condition ( "table_id = '" . $post ['ele_id'] . "'" );
			$this->session->set_userdata ( 'table_id', $post ['ele_id'] );
		} else {
			$this->db_exp->set_search_condition ( "table_id = '" . $this->session->userdata ( 'table_id' ) . "'" );
		}
		
		$this->db_exp->set_table ( 'perm_tabs' );
		
		$this->db_exp->set_hidden ( 'table_id', $this->session->userdata ( 'table_id' ) );
		
		$tables = $this->Perm_model->get_table_data ( 'perm_tables', 'module_id', $this->session->userdata ( 'module_id' ) );
		$options = array (
				'0' => 'Controller' 
		);
		foreach ( $tables as $table ) {
			$key = $table ['id'];
			$val = $table ['label'];
			$options [$key] = $val;
		}
		
		$table_A = $this->Perm_model->get_field_data ( 'table_name', 'perm_tables', $this->session->userdata ( 'table_id' ) );
		$table_A_fields = $this->Perm_model->get_table_fields ( $table_A ['table_name'] );
		
		// echo 'sema';
		
		if (array_key_exists ( 'id', $post )) {
			$id = $post ['id'];
			$new_table_id = $this->Perm_model->get_field_data ( 'table_action_id', 'perm_tabs', $id );
			$new_table_id = $new_table_id ['table_action_id'];
			
			if ($new_table_id == 0) {
				$this->db_exp->set_hidden ( 'perms' );
			} else {
				
				$table_B = $this->Perm_model->get_field_data ( 'table_name', 'perm_tables', $new_table_id );
				$table_B_fields = $this->Perm_model->get_table_fields ( $table_B ['table_name'] );
				
				// $table_B_fields = $this->Perm_model->get_table_fields ( $table_B['table_name'] );
				$this->db_exp->set_select ( 'to', $table_B_fields, TRUE );
				
				$this->db_exp->set_json_field ( 'args', array (
						'match',
						'oper',
						'to',
						'rend' 
				) );
				$this->db_exp->set_select ( 'match', $table_A_fields, TRUE );
				$this->db_exp->set_select ( 'oper', array (
						'like',
						'=',
						'!=',
						'<',
						'>' 
				), TRUE );
				$this->db_exp->set_select ( 'rend', array (
						'list',
						'insert',
						'edit',
						'flush table' 
				), TRUE );
			}
		}
		
		$action = $this->input->post ( 'action' );
		
		switch ($action) {
			
			case 'edit' :
				echo 'edito ' . $id;
				$this->db_exp->set_hidden ( 'id', $id );
				$this->db_exp->set_hidden ( array (
						'title',
						'icon',
						'table_action_id',
						'perms' 
				) );
				
				$act = 'edit';
				break;
			case 'insert' :
				// echo 'inserto';
				$this->db_exp->set_select ( 'table_action_id', $options );
				$this->db_exp->set_hidden ( 'args' );
				$act = 'insert';
				break;
			default :
				// echo 'listo';
				$this->db_exp->set_select ( 'table_action_id', $options );
				$this->db_exp->set_hidden ( 'args' );
				$act = 'row_list';
				break;
		}
		
		$this->db_exp->render ( $act );
	}

	public function manage_table($table_id = false) {
		$post = $this->input->post ();
		$p_id = $post ['perm_id'];
		$this->perm_id = $p_id;

		//print_r($post);

		$table_id = $this->input->post ( 'table_id' );
		
		if (NULL !== $this->input->post ( 'table_id' )) {
			$this->session->set_userdata ( 'perm_tables_table_id', $this->input->post ( 'table_id' ) );
		}
		if (NULL !== $this->session->userdata ( 'perm_tables_table_id' )) {
			$table_id = $this->session->userdata ( 'perm_tables_table_id' );
		}
		
		$res = $this->Perm_model->get_field_data ( 'table_name', 'perm_tables', $table_id );
		$table_name = $res ['table_name'];
		
		// get filters
		
		// jquery to load initial results
		
		echo '<div class="">';
		echo '<div class="group">';
		
		// search box
		$data = array (
				'name' => 'search',
				'id' => 'filter',
				'value' => '',
				'class' => 'manage_table_searchbox',
				'content' => '' 
		);
		echo '	<div 	class="left">' . form_input ( $data ) . '
				</div>';
		
		// check if has permissions to add
		if ($this->check_add_perm ()) {
			
			// check if add is via controller
			$add_controller	= trim(@$post['add_controller']);
			if(!$add_controller){
				$add_controller	= 'perm/new_table_data';
			}
			// new icon
			echo '	<div 	target="detail_wrp"
							action="' . site_url ( $add_controller ) . '"
							args="table_id=' . $table_id . '"
							class="perm_btn right m_link" >
								<i class="material-icons md-dark">add_box</i>
					</div>';
		}
		// close group
		echo '</div>';
		
		// advance search link
		echo '<div id="adv_search_link">advance search</div>';
		
		// get filter conditions
		$cond = $this->get_list_cond ();
		
		// echo $cond;
		
		// advance search div
		echo '<div id="adv_search" class="hidden">';
		$this->db_exp->set_table ( $table_name );
		$this->db_exp->set_form_hidden_values ( array (
				'table_id' => $table_id,
				'_COND_' => $cond 
		) );
		$this->db_exp->set_form_action ( 'perm/do_advance_search' );
		$this->db_exp->set_form_attribute ( 'target', 'manage_table_search_results' );
		$this->db_exp->render ( 'edit' );
		echo '</div>';
		// list results div
		echo '<div id="manage_table_search_results" class="perm_target_divs">';
		
		// initial results
		$this->table_results ( $table_id, 10, $cond );
		
		// end of results div
		echo '</div>';
	}
	private function check_add_perm() {
		return $this->check_ad_perm ( 'add' );
	}
	private function check_del_perm() {
		return $this->check_ad_perm ( 'delete' );
	}
	private function check_ad_perm($cat = 'add') {
		if ($this->session->userdata ( 'user_id' ) == 1) {
			// super user
			return 1;
		}
		
		$my_perms = $this->Perm_model->get_my_perms ();
		$cond = "FALSE OR (`perms` LIKE '%" . implode ( "%' OR `perms` LIKE '%", $my_perms ) . "%')";
		$cond .= " AND `perm_tree_id` = '" . $this->perm_id . "' AND `category` = '" . $cat . "'";
		$res = $this->Perm_model->get_data_from_table ( 'perm_config', $cond );
		
		if (! $res) {
			return false;
		} else {
			return true;
		}
	}
	private function get_tab_cond() {
		$my_perms = $this->Perm_model->get_my_perms ();
		$tabs = $this->get_filters ( $my_perms, 'tab' );
		
		if (! $tabs) {
			$cond = '1 = 2';
		} else {
			
			$cond = implode ( ",", $tabs );
			$cond = ' id in (' . $cond . ')';
		}
		
		return $cond;
	}
	private function get_list_cond() {
		if ($this->session->userdata ( 'user_id' ) == 1) {
			$cond = '1 = 1';
		} else {
			$my_perms = $this->Perm_model->get_my_perms ();
			$filters = $this->get_filters ( $my_perms );
			
			if (! $filters) {
				$cond = '1 = 1';
			} else {
				$cond = $this->filter2condition ( $filters );
			}
		}
		return $cond;
	}
	private function get_filters($my_perms, $cat = 'list') {
		$cond = "FALSE OR (`perms` LIKE '%" . implode ( "%' OR `perms` LIKE '%", $my_perms ) . "%')";
		$cond .= " AND `perm_tree_id` = '$this->perm_id' AND `category` = '" . $cat . "'";
		$filters = $this->Perm_model->get_data_from_table ( 'perm_config', $cond );
		
		if (! $filters) {
			return false;
		}
		
		$holder = array ();
		foreach ( $filters as $val ) {
			// print_r($val);
			array_push ( $holder, $val ['filters'] );
		}
		
		// print_r($holder);
		
		return $holder;
	}
	private function filter2condition($filters) {
		$holder = array ();
		foreach ( $filters as $filter ) {
			$tmp = $this->get_condition ( $filter );
			array_push ( $holder, $tmp );
		}		
		$cond = " FALSE OR ( " . implode ( " OR ", $holder ) . " )";
		return $cond;
	}
	private function get_condition($filter_list) {
		$filter_ids = explode ( ',', $filter_list );
		
		$holder = array ();
		foreach ( $filter_ids as $filter_id ) {
			
			$filter_id = trim ( $filter_id );
			
			$tmp_a1 = array ();
			$results = $this->Perm_model->get_table_data ( 'perm_filter_config', 'perm_filter_id', $filter_id );
			foreach ( $results as $val ) {
				
				$field_name = $val ['field_name'];
				$oper = $val ['oper'];
				$field_value = $val ['field_value'];
				
				$tmp = "`" . $field_name . "` " . $oper . " '" . $field_value . "'";
				array_push ( $tmp_a1, $tmp );
			}
			
			$tmp2 = "( " . implode ( ' AND ', $tmp_a1 ) . " )";
			array_push ( $holder, $tmp2 );
		}
		
		$cond = "( " . implode ( ' OR ', $holder ) . " )";
		return $cond;
	}
	private function get_table_config($table_id) {
		$holder = array ();
		if ($res = $this->Perm_model->get_table_data ( 'perm_tables_conf', 'table_id', $table_id )) {
			
			foreach ( $res as $val ) {
				$index = $val ['field_name'];
				foreach ( $val as $k => $v ) {
					$holder [$index] [$k] = $v;
				}
			}
		}
		
		return $holder;
	}
	public function table_results($table_id, $items_per_page = 5, $cond = false) {
		$res = $this->Perm_model->get_field_data ( 'table_name', 'perm_tables', $table_id );
		$table_name = trim ( $res ['table_name'] );
		
		// get field properties
		$field_configs = $this->get_table_config ( $table_id );
		
		// echo '<pre>';print_r($field_configs);
		
		// get page
		$page = $this->input->post ();
		if (NULL !== $this->input->post ( 'page' )) {
			$page_num = $this->input->post ( 'page' );
		} else {
			$page_num = 1;
		}
		
		$total_rows = $this->db->count_all ( $table_name );
		$total_pages = ceil ( $total_rows / $items_per_page );
		$page_pos = ($page_num - 1) * $items_per_page;
		
		$results = $this->Perm_model->paginate_table ( $table_name, $page_pos, $items_per_page, $cond );
		
		$start = true;
		
		//$this->get_table_field_value($table_id, 'specie', '1');
		
		echo '<table class="table_wrp" table_id="' . $table_id . '" table_name="' . $table_name . '" action="' . site_url ( 'perm/table_data_detail' ) . '">';
		foreach ( $results->result_array () as $row ) {
			
			if ($this->check_del_perm ()) {
				$hd = '<td class="cell_del_hd" style="width: 16px"> </td>';
				$bd = '<td class="cell_del" tbl_id="' . $row ['id'] . '" tbl_name="' . $table_name . '" action="' . site_url ( 'perm/delete_row' ) . '"><i class="material-icons md-light" style="font-size:14px">delete</i></td>';
			}
			foreach ( $row as $key => $val ) {
				
				// if($key == 'id') continue;
				// if(strstr($key,'_id')) continue;
				
				if (array_key_exists ( $key, $field_configs ) && $field_configs [$key] ['field_property'] == 'hidden') {
					continue; // do not show
				}
				
				$val	= $this->display_field($table_id, $key, $val);
				
				if ($start) {
					$label = str_replace ( "_", " ", str_replace ( "_id", "", $key ) );
					$hd .= '<td class="table_res_header cell_' . $key . '" tag="' . $key . '">' . $label . '</td>';
				}
				
				
				$bd .= '<td class="table_res_cell cell_' . $key . '" tag="' . $key . '">' . $val . '</td>';
			}
			
			if ($start) {
				
				echo '<thead><tr class="table_res_row">' . $hd . '</tr></thead><tbody>';
				$start = false;
			}
			echo '<tr class="table_res_row row_' . $row ['id'] . '" id="' . $row ['id'] . '">' . $bd . '</tr>';
		}
		echo '</tbody></table></div>';
	}
	function do_advance_search() {
		$post = $this->input->post ();
		// echo '<pre>';print_r($post);
		
		$cond = array ();
		foreach ( $post as $key => $val ) {
			
			if ($key == 'table_id') {
				$table_id = $val;
			} elseif ($key == 'db_exp_submit_engaged') {
				// do nothing
			} else {
				if (empty ( $val ))
					continue;
				if ($key == '_COND_') {
					$perm_cond = $val;
					continue;
				} else {
					$tmp = '`' . $key . '`' . " = '$val'";
				}
				array_push ( $cond, $tmp );
			}
		}
		
		$str = $perm_cond . ' AND (' . implode ( " AND ", $cond ) . ' )';
		
		// echo $str;
		
		$this->table_results ( $table_id, 5, $str );
	}
	
	private function display_field($table_id, $field_name, $field_val){
		
		if(!$map	= $this->get_field_value_map($table_id)){
			return $field_val;
		};
		//echo '<pre>'; print_r($map);
		if(array_key_exists($field_name,$map) && array_key_exists($field_val,$map[$field_name])){
			return $map[$field_name][$field_val];
		}else{
			return $field_val;
		}
		
		
	}
	private function get_field_value_map($table_id = 14){
		
		unset($this->session->userdata['table_map'][$table_id]);
		if(isset($this->session->userdata['table_map'][$table_id])){
			return $this->session->userdata['table_map'][$table_id];
		}
		
		// set the array
		$holder	= array();
		if(!$table_conf	= $this->Perm_model->get_table_data('perm_tables_conf','table_id',$table_id)){
			return false;
		}

		foreach($table_conf as $row){
			$field_property	= $row['field_property'];
			$field_name		= $row['field_name'];
			if($field_property == 'db_dropdown'){
				
				
				$tmp	= explode(":",$row['field_value']);
				$tbl	= $tmp[0];
				$key	= $tmp[1];
				$lbl	= $tmp[2];
				
				// get all results
				$res	= $this->Perm_model->get_data_from_table($tbl);
				foreach($res as $v){
					$k	= $v[$key];
					$l	= $v[$lbl];
					$holder[$field_name][$k]	= $l;
				}
			}else{
				$holder[$field_name]	= array();
			}
		}
		
		//print_r($holder);
		$this->session->userdata['table_map'][$table_id]	= $holder;
		
		return $this->session->userdata['table_map'][$table_id];
		
	}
	
	public function table_data_detail() {
		$post = $this->input->post ();
		
		$id = $post ['table_id'];
		$this->perm_id = $post ['id'];
		
		$this->view_table_row ( $post ['table_id'], $post ['id'] );
		
		// get
		if ($this->session->userdata ( 'user_id' ) == '1') {
			$cond = false;
		} else {
			$cond = $this->get_tab_cond ();
		}
		
		$this->data ['tabs'] = $this->Perm_model->get_tabs ( $post, $cond );
		
		$this->load->view ( 'perm/show_tabs' );
	}
	public function view_table_row($table_id, $row_id) {
		$this->db_table_render ( $table_id );
		$this->db_exp->set_form_attribute('class','view_table_row');
		$this->db_exp->set_pri_id ( $row_id );
		$this->db_exp->render ( 'view' );
	}
	public function table_set_perms() {
		$post = $this->input->post ();
		// print_r($post);
		$perm_id = $post ['ele_id'];
		if (! empty ( $perm_id )) {
			$this->session->set_userdata ( 'perm_id', $perm_id );
		}
		$perm_id = $this->session->userdata ( 'perm_id' );
		
		$available_perms = $this->Perm_model->get_all_permsy ( $perm_id );
		// print_r($available_perms);
		
		$this->db_exp->set_table ( 'perm_tree_details' );
		$this->db_exp->set_hidden ( 'perm_tree_id', $perm_id );
		$this->db_exp->set_list ( 'perms', $available_perms );
		$this->db_exp->set_hidden ( 'ele_id', $perm_id );
		
		$res = $this->Perm_model->get_table_data ( 'perm_tree_details', 'perm_tree_id', $perm_id );
		if (is_array ( $res )) {
			$id = $res [0] ['id'];
			$this->db_exp->set_pri_id ( $id );
			$this->db_exp->set_hidden ( 'id', $id );
		}
		$this->db_exp->set_hidden ( "items" );
		$this->db_exp->set_default_action ( "insert" );
		
		$this->db_exp->render ();
	}
	function link_table_action() {
		$this->save_dbexp_post_vars ();
		
		$args = $this->session->userdata ['post'] ['args'];
		$ele_id = $this->session->userdata ['post'] ['ele_id'];
		$table_id = $this->session->userdata ['post'] ['table_action_id'];
		$table_name = $this->session->userdata ['post'] ['ele_table_name'];

		$args = json_decode ( $args, true );
		$to = $args ['to'];
		$oper = $args ['oper'];
		$match = $args ['match'];
		
		$res = $this->Perm_model->get_table_data ( $table_name, $match, $ele_id );
		$match_val = $res [0] [$match];
		
		$rend = $args ['rend'];

		$this->db_table_render ( $table_id );
		
		switch ($rend) {
			case 'edit' :
				$this->db_exp->set_pri_id ( $ele_id );
				$this->db_exp->render ( $rend );
				break;
			case 'list' :
				$rend = 'row_list';

				$this->db_exp->set_hidden($to,$match_val);
				$this->db_exp->set_search_condition ( "`" . $to . "` " . $oper . " '" . $match_val . "'" );
				$this->db_exp->render ( $rend );
				break;
			case 'flush table' :
				$cond = $this->get_list_cond ();
				$this->table_results ( $table_id, 10, $cond );
				break;
		}
	}
	function page_not_found() {
		echo 'page not found';
	}
	function db_table_render($table_id) {
		$res = $this->Perm_model->get_field_data ( 'table_name', 'perm_tables', $table_id );
		$table_name = $res ['table_name'];
		
		$fields = $this->Perm_model->get_table_data ( 'perm_tables_conf', 'table_id', $table_id );
		
		//echo '<pre>'; print_r($fields);
		$this->db_exp->set_table ( $table_name );
		if (! $fields) {
			log_message ( 'debug', 'in db_table_render: table has no configs' );
			return;
		}
		
		foreach ( $fields as $field ) {
			
			parse_str ( $field ['field_value'], $args );
			
			switch ($field ['field_property']) {
				
				case 'date' :
					$this->db_exp->set_date ( $field ['field_name'] );
					break;
				case 'CI db_func' :
					$func_name = $args ['name'];
					if ($func_name == 'list_tables') {
						$options = $this->db->list_tables ();
						$this->db_exp->set_list ( $field ['field_name'], $options,TRUE );
					}
					if ($func_name == 'select_tables') {
						$options = $this->db->list_tables ();
						$this->db_exp->set_select ( $field ['field_name'], $options, TRUE );
					}
					
					break;
				case 'password' :
					$this->db_exp->set_password ( $field ['field_name'] );
					break;
				case 'label' :
					$this->db_exp->set_label( $field ['field_name'], $field ['field_value']);
					break;
				case 'view' :
					$this->db_exp->set_readonly( $field ['field_name']);
					break;
				case 'dropdown' :
					$options = explode ( ",", $field ['field_value'] );
					$this->db_exp->set_select ( $field ['field_name'], $options, true );
					break;
				case 'db_dropdown' :
					$options = explode ( ":", $field ['field_value'] );
					$cond = false;
					if (array_key_exists ( 3, $options ))
						$cond = $options [3];
					$this->db_exp->set_db_select ( $field ['field_name'], $options [0], $options [1], $options [2], $cond );
					break;
				case 'textarea' :
					$this->db_exp->set_textarea ( $field ['field_name'], $field ['field_value'] );
					break;
				case 'hidden' :
					$this->db_exp->set_hidden ( $field ['field_name'], $field ['field_value'] );
					break;
			}
		}
	}
	public function filter_config() {
		echo 'filter config';
		
		$this->save_dbexp_post_vars ();
		
		$args = $this->session->userdata ['post'] ['args'];
		$ele_id = $this->session->userdata ['post'] ['ele_id'];
		$table_id = $this->session->userdata ['post'] ['table_id'];
		
		$res = $this->Perm_model->get_field_data ( 'table_name', 'perm_filter', $ele_id );
		$table_name = $res ['table_name'];
		
		$this->db_exp->set_table ( 'perm_filter_config' );
		$this->db_exp->set_search_condition ( "perm_filter_id = '" . $ele_id . "'" );
		$this->db_exp->set_hidden ( 'perm_filter_id', $ele_id );
		$this->db_exp->set_select ( 'oper', array (
				'>',
				'<',
				'=',
				'in',
				'not in' 
		), true );
		$this->db_exp->set_select ( 'field_name', $this->Perm_model->get_table_fields ( $table_name ), true );
		$this->db_exp->set_default_action ( 'row_list' );
		$this->db_exp->render ();
	}
	public function set_option_perms() {
		$this->save_dbexp_post_vars ();
		
		$perm_id = $this->session->userdata ['post'] ['ele_id'];
		$available_perms = $this->Perm_model->get_all_perms ();
		
		// print_r($available_perms);
		
		$this->db_exp->set_table ( 'perm_tree' );
		$this->db_exp->set_list ( 'perms', $available_perms );
		$this->db_exp->set_hidden ( array (
				'title',
				'icon_font',
				'perm_target',
				'perm_type',
				'perm_data',
				'id',
				'module_id',
				'parent_id' 
		) );
		$this->db_exp->set_pri_id ( $perm_id );
		$this->db_exp->set_default_action ( "edit" );
		
		$this->db_exp->render ();
	}
	public function set_add_perms() {
		$this->set_ad_perms ( 'add' );
	}
	public function set_del_perms() {
		$this->set_ad_perms ( 'delete' );
	}
	public function set_ad_perms($cat = 'add') {
		$this->save_dbexp_post_vars ();
		
		$perm_id = $this->session->userdata ['post'] ['ele_id'];
		// get id with perm id
		$res = $this->Perm_model->get_data_from_table ( 'perm_config', "perm_tree_id = '" . $perm_id . "' and category = '" . $cat . "'" );
		if ($res) {
			$pkey = $res [0] ['id'];
			$this->db_exp->set_pri_id ( $pkey );
			$this->db_exp->set_default_action ( "edit" );
		} else {
			$this->db_exp->set_default_action ( "insert" );
		}
		
		$available_perms = $this->Perm_model->get_all_perms ();
		
		$this->db_exp->set_table ( 'perm_config' );
		$this->db_exp->set_list ( 'perms', $available_perms );
		$this->db_exp->set_hidden ( array (
				'perm_tree_id' => $perm_id,
				'description',
				'filters',
				'id' 
		) );
		$this->db_exp->set_hidden ( 'category', $cat );
		
		$this->db_exp->render ();
	}
	public function set_list_perms() {
		
		$this->save_dbexp_post_vars ();
		// print_r($post);
		
		$perm_id = $this->session->userdata ['post'] ['ele_id'];
		
		// get table id
		$res = $this->Perm_model->get_field_data ( 'perm_data', 'perm_tree', $perm_id );
		$json = json_decode ( $res ['perm_data'], true );
		$tbl_id = $json ['table_id'];
		
		// get table name
		$res = $this->Perm_model->get_field_data ( 'table_name', 'perm_tables', $tbl_id );
		$table_name = $res ['table_name'];
		
		// get available filters
		$res = $this->Perm_model->get_table_data ( 'perm_filter', 'table_name', $table_name );
		
		if (! $res) {
			
			// no filters available
			echo '<br>No filters available for ' . $table_name;
			return;
		}
		
		$available_filters = array ();
		foreach ( $res as $val ) {
			$key = $val ['id'];
			$label = $val ['title'] . ' : ' . $val ['description'];
			$available_filters [$key] = $label;
		}
		
		$available_perms = $this->Perm_model->get_all_perms ();
		
		$this->db_exp->set_table ( 'perm_config' );
		$this->db_exp->set_hidden ( 'perm_tree_id', $perm_id );
		$this->db_exp->set_hidden ( 'category', 'list' );
		$this->db_exp->set_textarea ( 'description' );
		$this->db_exp->set_search_condition ( "perm_tree_id = '" . $perm_id . "' AND category = 'list'" );
		$this->db_exp->set_list ( 'filters', $available_filters );
		$this->db_exp->set_list ( 'perms', $available_perms );
		$this->db_exp->set_default_action ( "row_list" );
		$this->db_exp->render ();
	}
	public function set_tab_perms() {
		$post = $this->input->post ();
		// get perm data
		$this->save_dbexp_post_vars ();
		
		$perm_id = $this->session->userdata ['post'] ['ele_id'];
		
		$res = $this->Perm_model->get_field_data ( 'perm_data', 'perm_tree', $perm_id );
		$data = json_decode ( $res ['perm_data'], true );
		
		if (empty ( $data ['table_id'] )) {
			
			echo 'no tabs available';
			return;
		}
		
		$table_id = $data ['table_id'];
		// get available filters
		$res = $this->Perm_model->get_table_data ( 'perm_tabs', 'table_id', $table_id );
		if (! $res) {
			// no filters available
			echo '<br>No Tabs available';
			return;
		}
		
		$available_tabs = array ();
		foreach ( $res as $val ) {
			$key = $val ['id'];
			$label = $val ['title'];
			$available_tabs [$key] = $label;
		}
		
		$available_perms = $this->Perm_model->get_all_perms ();
		
		$this->db_exp->set_table ( 'perm_config' );
		$this->db_exp->set_hidden ( 'perm_tree_id', $perm_id );
		$this->db_exp->set_hidden ( 'category', 'tab' );
		$this->db_exp->set_textarea ( 'description' );
		$this->db_exp->set_search_condition ( "perm_tree_id = '" . $perm_id . "' AND category = 'tab'" );
		$this->db_exp->set_list ( 'filters', $available_tabs );
		$this->db_exp->set_list ( 'perms', $available_perms );
		$this->db_exp->set_default_action ( "row_list" );
		$this->db_exp->render ();
	}
	public function set_manage_perms() {
		echo 'manage perms';
		$post = $this->input->post ();
		print_r ( $post );
	}
	
	
	
	
	
	private function css_demo(){
		
		$post = $this->input->post ();
		// get css
		$data	= $this->Perm_model->get_field_data('title,css', 'ob_css', $post['ele_id']);
		echo '<style>.'.$data['title'].'{ background-color: #999;'.$data['css'].'}</style>';
		echo '<div class="'.$data['title'].'"> .. </div>';
		
	}
}

/* End of file start.php */
/* Location: ./application/controllers/start.php */