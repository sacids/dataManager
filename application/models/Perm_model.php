<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');





class Perm_model extends CI_Model{
	
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->config('perm', TRUE);
		
		
		
		
		// initialise data
		$this->section_table		= $this->config->item('section_table','perm');
		$this->tree_table			= $this->config->item('tree_table', 'perm');
		$this->user_table			= $this->config->item('users','perm');
		$this->group_table			= $this->config->item('group','perm');
		$this->user_group_table		= $this->config->item('user_group','perm');		
	}
	
	
	public function get_perm_tree($parent_id = false){
		
		$perms	= array_flip($this->get_user_perms($this->session->userdata('user_id')));
		
		if(!$parent_id){
			$this->db->where_in('parent_id',array('0','1'));
		}else{
			$this->db->where('parent_id',$parent_id);
		}
		$this->db->where('module_id',$this->session->userdata('module_id'));
		
		$this->db->order_by('parent_id','ASC');
		$query	= $this->db->get('perm_tree');
		
		$holder	= array();
		
		foreach($query->result_array() as $row){
			
			if(array_key_exists('perms', $row)){
				$conds	= explode(",",$row['perms']);
				foreach($conds as $perm_cond){
					if(array_key_exists($perm_cond, $perms)){
						$holder[$row['id']] = $row;
					}
				}
			}else{
				$holder[$row['id']] = $row;
			}
			
		}	

		return $holder;
	}
	
	public function get_user_perms($user_id){
		
		$perms	= array('P'.$user_id.'P');
		$this->db->select('id');
		$query = $this->db->get('groups');
		
		foreach($query->result() as $row){
			$val	= 'G'.$row->id.'G';
			array_push($perms,$val);
		}
		return $perms;
	}
	
	public function paginate_table($table_name, $page_pos, $items_per_page,$cond = false){
		
		$this->db->order_by('id','ASC');
		$this->db->limit($page_pos,$items_per_page);
		if($cond) $this->db->where($cond);
		$query	= $this->db->get($table_name);
		
		return $query;	
	}
	
	public function get_tabs($posts){
		
		$table_id	= $posts['table_id'];
		
		$this->db->where('table_id',$table_id);
		$query	= $this->db->get('perm_tree_actions');
		
		$holder	= array();
		
	
		
		foreach($query->result_array() as $row){
			$tmp			= array();
			$tmp['ele_id']			= $posts['id'];
			$tmp['ele_table_name']	= $posts['table_name'];
			$tmp['ele_table_id']	= $posts['table_id'];
		
			//echo '<pre>'; print_r($row);
			foreach($row as $key => $val){
				
				if($key == 'id') continue;			
				$tmp[$key]	= $val;
			}
			if($row['table_action_id'] == 0){
				$tmp['link']	= $row['args'];
				
			}else{
				$tmp['link']	= 'perm/link_table_action';
			}
			
			array_push($holder,$tmp);		
		}		
		
		//echo '<pre>'; print_r($holder);
		return $holder;	
		
	}
	
	public function get_perms_array($perm_id){
		
		
		$all_perms	= array('X1X' => 'None');
		
		// set users perms
		$this->db->select('id, first_name, last_name');
		$query = $this->db->get('users');
		
		foreach($query->result() as $row){
			$key	= 'P'.$row->id.'P';
			$val	= $row->first_name.' '.$row->last_name;	
			$all_perms[$key]	= $val;
		}
		
		// set group perms
		$this->db->select('id, name');
		$query = $this->db->get('groups');
		
		foreach($query->result() as $row){
			$key	= 'G'.$row->id.'G';
			$val	= 'G - '.$row->name;
			$all_perms[$key]	= $val;
		}
		
		
		$this->db->where('id',$perm_id);
		//$this->db->select('parent_id');
		$query = $this->db->get('perm_tree');
		
		$row = $query->row();
		
		//print_r($row);
		if($row->parent_id == 1){
			// ROOT return all
			return $all_perms;
			
		}else{
			
			
			$this->db->where('id',$row->parent_id);
			$query = $this->db->get('perm_tree');
			$row = $query->row();
			
			if(trim($row->perms) == ''){
				return false;
			}
			
			$perms	= explode(",", 'X1X,'.$row->perms);
			$perms	= array_flip($perms);
			
			foreach($perms as $key => $val){
				$perms[trim($key)] = $all_perms[trim($key)];
			}
			
			
			return $perms;
		}
	}
	
	public function get_parent($perm_id){
		$this->db->where('id',$perm_id);
		$this->db->select('parent_id');
		$query = $this->db->get('perm_tree');
		
		$row = $query->result_array();
		return $row['parent_id'];
		
	}
	
	public function get_field_data($fields,$table,$tbl_id){
		
		//$tmp	= array();
		$this->db->where('id',$tbl_id);
		$this->db->select($fields);
		$query = $this->db->get($table);
		
		$row	= $query->row_array();
		
		//print_r($row);
		
		return $row;
	}
	
	public function get_table_fields($table_name){
		
		// get table fields
		echo $table_name;
		$fields = $this->db->list_fields($table_name);
		return $fields;
		
	}
	
	
	
	public function get_table_data($table,$key = false,$val = false){
		
		if($key && $val){
			$this->db->where($key,$val);
		}
		$query	= $this->db->get($table);
		
		if($query->num_rows() == 0) return false;
		
		return $query->result_array();
	}
	

	
	public function get_list_tree(){
	
		$this->db->where('module_id',$this->session->userdata('module_id'));
		$this->db->where_in('parent_id','1');
		$this->db->order_by('parent_id','ASC');
		$query	= $this->db->get('perm_tree');
	
		$holder	= array();
	
		foreach($query->result_array() as $row){
			
			$holder[$row['id']] = $row;
		}
	
		return $holder;
	}
	
	private function _get_children($holder, $parent_id){
		
		$this->db->where('parent_id',$parent_id);
		$this->db->order_by('parent_id','ASC');
		$query	= $this->db->get('perm_tree');
		
		if($this->db->affected_rows() == 0){
			return $holder;
		}else{
			$tmp	= array();
		}
		
		foreach($query->result_array() as $row){		
			$tmp[$row['id']] = $row;
			$this->_get_children($tmp, $row['id']);
		}
	}
	
	public function insert_into_table($table){
		
		$str = $this->db->insert_string($table, $this->input->post());
		if($this->db->simple_query($str)){
			return 'success';
		}else{
			return 'failed';
		}
		
	}
	
	
	public function get_user_groups(){

		$user_id			= $this->session->userdata("user_id");
		$user_field			= $this->user_group_table['user_id'];
		$group_field		= $this->user_group_table['group_id'];
		$user_group_table	= $this->user_group_table['table'];
		
		
		$this->db->where($user_field,$user_id);
		$this->db->select($group_field);
		$query	= $this->db->get($user_group_table);
		
		$holder	= array();
		
		foreach($query->result_array() as $row){
			
			array_push($holder,$row[$group_field]);		
		}	
	}
	
	public function get_modules(){
		
		$user_id	= $this->session->userdata('user_id');
		
		// get user permissions
		$perms		= $this->get_user_perms($user_id);
		
		$query		= $this->db->get('perm_module');
		$holder		= array();
		
		foreach($query->result_array() as $row){
			
			$module_perms	= $row['perms'];
			
			$pp		= explode(",", $module_perms);
			$diff	= array_diff($perms,$pp);
			
			if(sizeof($pp) != sizeof($diff)){
				array_push($holder,$row);				
			}
		}
		
		return $holder;
	}
	
	
	
}
