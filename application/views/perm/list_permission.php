<?php

$this->db->where('module_id',$this->session->userdata('module_id'));
$this->db->where_in('parent_id','1');
$this->db->order_by('parent_id','ASC');
$query	= $this->db->get('perm_tree');

foreach($query->result_array() as $row){
		
	echo '<div  class="perm_list_link" target="detail_wrp" action="'.site_url('perm/manage_perm/').'/'.$row['id'].'">'.$row['title'].'</div>';
	_get_children($this,$row['id'],2);
}


function _get_children($obj,$parent_id,$level){
	
	
	$obj->db->where_in('parent_id',$parent_id);
	$obj->db->order_by('parent_id','ASC');
	$query	= $obj->db->get('perm_tree');
	
	if($obj->db->affected_rows() == 0){
		return;
	}else{
		$new_level 	= $level + 1;
		$spacer		= str_repeat('&nbsp',$new_level);
		echo '<div>';
	}
	
	foreach($query->result_array() as $row){
	
		echo '<div  class="perm_list_link" target="detail_wrp" action="'.site_url('perm/manage_perm/').'/'.$row['id'].'">'.$spacer.$row['title'].'</div>';
		_get_children($obj,$row['id'],$new_level);
	}
	
	echo '</div>';
}

	