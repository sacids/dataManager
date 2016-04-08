
<?php


$hidden = array('module_id' => $this->data['module_id']);

echo form_open('perm/new_perm/','',$hidden);

$options	= array('1' => 'Root');
foreach($this->data['parent_tree'] as $key => $val){
	$options[$key]	= '&nbsp&nbsp&nbsp'.$val['title'];
}
echo form_label('Parent', 'parent_id');
echo form_dropdown('parent_id', $options, '0');
echo '</br>';

$data = array(
		'name'        => 'title',
		'id'          => 'title',
		'maxlength'   => '100',
		'size'        => '50',
		'style'       => 'width:50%',
);
echo form_label('Title', 'title');
echo form_input($data);
echo '</br>';

$options = array(
		'link'         => 'Link to controller',
		'label'        => 'label'
);
echo form_label('Permission type', 'perm_type');
echo form_dropdown('perm_type', $options, 'link');
echo '</br>';

$options = array(
		'list_wrp'         => 'List',
		'detail_wrp'        => 'Detail'
);
echo form_label('Target', 'perm_target');
echo form_dropdown('perm_target', $options, 'detail_wrp');
echo '</br>';

$data = array(
		'name'        => 'perm_data',
		'id'          => 'perm_data',
		'maxlength'   => '200',
		'size'        => '50',
		'style'       => 'width:80%',
);
echo form_label('Link to controller', 'perm_data');
echo form_input($data);
echo '</br>';


echo form_submit('submit','submit');
echo form_close();
