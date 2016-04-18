<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');





class Perm_model extends CI_Model{
	
	
	public function __construct(){
		parent::__construct();
		$this->load->database();	
	}
	
	public function get_tasks(){
		
		$perms	= array_flip($this->get_user_perms($this->session->userdata('user_id')));
		
		$this->db->where('module_id',$this->session->userdata('module_id'));
		
		$query	= $this->db->get('perm_tree');
		
		//echo $this->db->last_query();
		
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
		
		//echo 'somo '.$cond;
		$this->db->order_by('id','ASC');
		$this->db->limit($page_pos,$items_per_page);
		if($cond) $this->db->where($cond);
		$query	= $this->db->get($table_name);
		//echo $str = $this->db->last_query();
		return $query;	
	}
	
	public function get_tabs($posts, $cond = 'false'){
		
		if(!$cond){
			$table_id	= $posts['table_id'];
			$this->db->where('table_id',$table_id);
		}else{
			$this->db->where($cond);
		}
		
		$query	= $this->db->get('perm_tabs');
		
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
	
	public function get_all_perms(){
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
		
		return $all_perms;
	}
	public function get_my_perms(){
	
		$my_id		= $this->session->userdata('user_id');
		//$my_name	= $this->session->userdata('first_name');
		$my_perms	= array('X'.$my_id.'X' => 'X'.$my_id.'X');
	
	
		// set group perms
		//$this->db->select('id, name');
		$this->db->where('user_id',$my_id);
		$query = $this->db->get('users_groups');
	
		foreach($query->result() as $row){
			$key	= 'G'.$row->group_id.'G';
			$val	= 'G'.$row->group_id.'G';
			$my_perms[$key]	= $val;
		}
		
		return $my_perms;
	}
	
	
	
	public function get_data_from_table($table_name,$cond = false){
		$where	= '';
		if($cond){
			$where = ' where '.$cond;
		}
		
		$q	= 'SELECT * FROM '.$table_name.' '.$where;
		//echo $q;
		$query = $this->db->query($q);
		
		if($query->num_rows() == 0){
			return false;
		}else{
			return $query->result_array();
		}
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
		//echo $table_name;
		$fields = $this->db->list_fields($table_name);
		return $fields;
		
	}
	
	
	public function get_table_data($table,$key = false,$val = false){
		
		if($key && $val){
			$this->db->where($key,$val);
		}
		$query	= $this->db->get($table);
		//echo $this->db->last_query();
		if($query->num_rows() == 0) return false;
		
		return $query->result_array();
	}
	

	public function insert_into_table($table){
		
		$str = $this->db->insert_string($table, $this->input->post());
		if($this->db->simple_query($str)){
			return 'success';
		}else{
			return 'failed';
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


/*
 * 
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
	
	
	
	
	
	
	
	

 */