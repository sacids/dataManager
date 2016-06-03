<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

class Db_exp
{
    public $table;
    public $default_action;
    public $pri_id;
    public $fields = array();
    public $actions = array();
    public $search_condition;
    public $form_action;
    public $form_attributes;
    public $form_id;
    public $form_hidden = array();

    public function __construct()
    {

        //$this->load->library('form_validation');
        $this->pri_id = 0;
        $this->form_id = uniqid('db_exp_');
        $this->form_action = uri_string();
        $this->default_action = 'edit';
        $this->search_condition = false;
        $this->actions['link'] = array();
        $this->fields = array();
        $this->form_attributes = array('id' => $this->form_id);
        $this->form_hidden['db_exp_submit_engaged'] = 1;
        $this->show_form_after_submit = true;
        $this->show_submit_button = true;
    }

    public function render($action = "default")
    {
        $CI = &get_instance();
        // echo 'render ' . $action . ' ' . $this->table;
        // check if it is a ajax submit
        $post = $CI->input->post();
        // check if action is only option

        if (array_key_exists('action', $post)) {
            $action = $post['action'];
        }
        if ($action == "default") {
            $action = $this->default_action;
        }


        if (array_key_exists('db_exp_submit_engaged', $post)) {
            // Execute submit
            $ret = $this->_process_submit($CI->input->post());

            // what to do after submit
            if (!$this->show_form_after_submit) {
                return $ret;
            }
        }


        switch (strtolower($action)) {

            case 'edit':
            case 'insert':
                $this->_render_edit();
                break;
            case 'view':
                $this->_set_readonly();
                $this->_render_edit();
                break;
            case 'col_list':
                $this->_render_list_col();
                break;
            case 'row_list':
                $this->_render_list_row();
                break;
        }

        return 2;

    }

    public function set_table($table)
    {
        $this->table = $table;
    }

    public function set_form_action($uri)
    {
        $this->form_action = $uri;
    }

    public function set_form_attribute($option, $value = '')
    {
        if (is_array($option)) {
            foreach ($option as $key => $val) {
                $this->form_attributes[$key] = $val;
            }
        } else {
            $this->form_attributes[$option] = $value;
        }
    }

    public function set_form_hidden_values($option, $value = 0)
    {
        if (is_array($option)) {
            foreach ($option as $key => $val) {
                $this->form_hidden[$key] = $val;
            }

            return;
        }
        if ($value) {
            $this->form_hidden[$option] = $value;
        }


    }

    public function set_pri_id($id)
    {
        $this->pri_id = $id;
    }

    public function set_search_condition($where)
    {

        $this->search_condition = $where;
    }

    public function set_hidden($index, $value = '')
    {

        if (is_array($index)) {
            foreach ($index as $key => $val) {

                if (is_int($key)) {
                    // value not set
                    $this->fields[$val]['hidden'] = '';
                } else {
                    $this->fields[$key]['hidden'] = $val;
                }
            }
        } else {
            $this->fields[$index]['hidden'] = $value;
        }
    }

    public function set_json_field($index, $options)
    {
        $this->fields[$index]['json'] = $options;
    }

    public function set_readonly($index)
    {
        $this->fields[$index]['view'] = true;
    }

    public function set_db_select($index, $table, $val, $label, $condition = false)
    {

        // get array values
        $CI = &get_instance();
        if ($condition) $CI->db->where($condition);
        $CI->db->select($val . ',' . $label);
        $query = $CI->db->get($table);
        $arr = array();

        foreach ($query->result_array() as $row) {
            $key = $row[$val];
            $lab = $row[$label];
            $arr[$key] = $lab;
        }

        $this->fields[$index]['db_select'] = $arr;
    }

    public function set_select($index, $options, $values_as_keys = false)
    {


        if ($values_as_keys) {
            $opt = array();
            foreach ($options as $val) {
                $opt[$val] = $val;
            }
            $options = $opt;
        }
        $this->fields[$index]['select'] = $options;
    }

    public function set_date($index)
    {
        $this->fields[$index]['date'] = 1;
    }

    public function set_input($index, $options = '')
    {
        $this->fields[$index]['input'] = $options;
    }

    public function set_password($index)
    {
        $this->fields[$index]['password'] = 1;
    }

    public function set_textarea($index, $options = '')
    {
        $this->fields[$index]['textarea'] = $options;
    }

    public function set_list($index, $options, $values_as_keys = false)
    {
        if ($values_as_keys) {
            $opt = array();
            foreach ($options as $val) {
                $opt[$val] = $val;
            }
            $options = $opt;
        }
        $this->fields[$index]['list'] = $options;
    }

    public function set_label($index, $options)
    {
        $this->fields[$index]['label'] = $options;
    }

    public function set_row_link($link)
    {
        array_push($this->actions['link'], $link);
    }

    public function set_default_action($act)
    {
        $this->default_action = $act;
    }

    public function set_view($index)
    {
        $this->fields[$index]['view'] = true;
    }


    public function get_field($field, $id)
    {

        $CI = &get_instance();
        $CI->db->where('id', $id);
        $query = $this->db->get($this->table);
        $row = $query->result_array();
        return $row[$field];
    }

    private function _process_submit($posts)
    {

        $CI = &get_instance();

        //print_r($posts);
        //print_r($this->fields);
        $post_to_db = array();
        $del_keys = array();

        // loop through table fields
        $q = 'describe ' . $this->table;
        $query = $CI->db->query($q);
        foreach ($query->result_array() as $row) {

            $key = $row['Field'];
            if (array_key_exists($key, $posts)) {
                $val = $posts[$key];
            } else {
                continue;
            }

            if ($key == 'db_exp_submit_engaged') {
                continue;
            }

            if (array_key_exists($key, $this->fields) && array_key_exists('json', $this->fields[$key])) {
                // json variable
                $catch = $this->fields[$key]['json'];
                $tmp = array();
                foreach ($catch as $check) {
                    $tmp[$check] = $posts[$check];
                }

                //echo 'tuliingia <pre>'; print_r($tmp);
                $json = json_encode($tmp);
                $post_to_db[$key] = $json;
                continue;
            }

            if (is_array($val)) {
                $post_to_db[$key] = implode(",", $val);
            } else {
                $post_to_db[$key] = $val;
            }

        }


        if (array_key_exists('id', $post_to_db)) {
            $where = "id = " . $post_to_db['id'];
            $str = $CI->db->update_string($this->table, $post_to_db, $where);
        } else {
            $str = $CI->db->insert_string($this->table, $post_to_db);
        }
        //echo $str;

        if ($CI->db->simple_query($str)) {
            echo "Success!";
            return 1;
        } else {
            echo "Query failed! " . $str;
            return 0;
        }

    }

    private function _render_edit()
    {
        $CI = &get_instance();

        $hidden = array();


        $id = $CI->input->post('id');
        if (!empty($id)) {
            $this->set_pri_id($id);
            $hidden['id'] = $id;

        }

        $vals = '';
        if ($this->pri_id) {
            // get values
            $hidden['id'] = $this->pri_id;
            $query = $CI->db->get_where($this->table, array(
                'id' => $this->pri_id
            ));
            $vals = $query->row_array();
        }


        //print_r($vals);
        $q = 'describe ' . $this->table;

        $query = $CI->db->query($q);

        $uri = $this->form_action;
        $attributes = $this->form_attributes;
        if (empty($attributes)) $attributes = '';

        $hidden = $this->form_hidden;

        // echo '<br>' . $uri;
        echo form_open($uri, $attributes, $hidden);
        echo '<table class="db_exp_table">';
        foreach ($query->result_array() as $row) {

            $fn = $row ['Field'];

            //echo '<pre>';print_r($this->fields);
            //print_r($vals);

            if (is_array($vals) && array_key_exists($fn, $vals)) {

                // check if its a multiselct field
                if (array_key_exists($fn, $this->fields) && array_key_exists('list', $this->fields[$fn])) {
                    if (trim($vals[$fn]) != '') {
                        $val = explode(",", $vals [$fn]);
                    } else {
                        $val = array();
                    }
                } else {
                    $val = $vals [$fn];
                }


            } else {
                $val = '';
            }
            //echo $fn; print_r($val); echo "\n";


            $this->_edit_field($row, $val);

        }

        if ($this->show_submit_button) {
            echo '<tr><td></td><td></td><td>' . form_submit('submit', 'submit') . '</td></tr>';
        }

        echo '</table>';
        echo form_close();
    }

    private function _edit_field($field, $value)
    {
        $type = $field ['Type'];
        $name = $field ['Field'];
        $label = ucfirst(str_replace("_", " ", str_ireplace("_id", "", $name)));

        // check if its primary key
        if ($field ['Key'] === 'PRI' && $value == '') {
            return;
        }

        $data = array();
        $data['name'] = $name;
        $options = false;

        if (array_key_exists($name, $this->fields)) {

            foreach ($this->fields[$name] as $key => $val) {
                switch ($key) {
                    case 'db_select':
                        $type = 'db_select';
                        $options = $val;
                        break;
                    case 'select':
                        $type = 'select';
                        $options = $val;
                        break;
                    case 'json':
                        //echo $value;
                        $type = 'json';
                        $json_data = json_decode($value, true);
                        $json_keys = $this->fields[$name]['json'];
                        //print_r($json_keys);
                        foreach ($json_keys as $fk) {

                            $fn = array('Field' => $fk, 'Type' => '', 'Key' => '');
                            $fv = '';
                            if (is_array($json_data) && array_key_exists($fk, $json_data)) $fv = $json_data[$fk];
                            $this->_edit_field($fn, $fv);
                        }
                        break;
                    case 'list':
                        $type = 'list';
                        $options = $val;
                        break;
                    case 'textarea':
                        $type = 'textarea';
                        break;
                    case 'password':
                        $type = 'password';
                        break;
                    case 'hidden':
                        $type = 'hidden';
                        if ($val != '') $value = $val;
                        break;
                    case 'date':
                        $type = 'date';
                        break;
                    case 'label':
                        //$type	= 'label';
                        $label = $val;
                        break;
                    case 'view';
                        $type = 'view';
                        break;
                }

                $data['class'] = 'db_exp_' . $type;
            }
        }
        // print_r ( $field );

        $pre = '<tr><td>' . $label . '</td><td> : </td><td>';
        $end = '</td></tr>';

        // check if field is set to view
        //if(array_key_exists('view', $this->fields[$name]) && $this->fields[$name]['view']){
        //echo $pre.$value.$end;
        //return;
        //}

        switch ($type) {

            case 'int' :
                echo $pre . form_input($data, $value) . $end;
                break;
            case 'password' :
                echo $pre . form_password($data, $value) . $end;
                $data['name'] = $data['name'] . '_repeat';
                $pre = '<tr><td>Repeat ' . $label . '</td><td> : </td><td>';
                echo $pre . form_password($data, $value) . $end;
                break;
            case 'textarea':
                echo $pre . form_textarea($data, $value) . $end;
                break;
            case 'date':
                echo $pre . form_input($data, $value) . $end;
                break;
            case 'db_select':
                echo $pre . form_dropdown($data, $options, $value) . $end;
                break;
            case 'list':
            case 'multiselect':
                $data['name'] = $name . '[]';
                echo $pre . form_multiselect($data, $options, $value) . $end;
                break;
            case 'select':
                echo $pre . form_dropdown($data, $options, $value) . $end;
                break;
            case 'json':
            case 'hidden':
                echo form_hidden($name, $value);
                break;
            case 'view':
                if (array_key_exists('hidden', $this->fields[$name])) {
                    echo form_hidden($name, $value);
                } else {
                    $s = '';
                    if (is_array($options)) {
                        if (is_array($value)) {
                            $v = $value;
                        } else {
                            $v = explode(',', $value);
                        }

                        foreach ($v as $kk) {
                            $s .= $options[$kk] . ',';
                        }
                    } else {
                        $s = $value;
                    }
                    echo $pre . $s . $end;
                }
                break;
            default :
                echo $pre . form_input($name, $value) . $end;
                break;
        }
    }

    private function _render_list_col()
    {
        $CI = &get_instance();

        $fields = $CI->db->list_fields($this->table);
        $show = array();
        foreach ($fields as $field) {
            if (array_key_exists($field, $this->fields) && is_array($this->fields[$field]) && array_key_exists('hidden', $this->fields[$field])) {

            } else {
                array_push($show, $field);
            }
        }
        if (sizeof($show) != 0) {
            $CI->db->select(implode(",", $show));
        }

        if ($this->search_condition) {
            // get values
            $query = $CI->db->get_where($this->table, $this->search_condition);
        } else {
            $query = $CI->db->get($this->table);
        }


        echo '<table width="100%" cellpadding="2" cellspacing="2">';
        foreach ($query->result_array() as $row) {
            //print_r($row);
            echo '<tr class="perm_list">';

            foreach ($this->actions['link'] as $v1) {

                $opts = '';
                $link_label = false;
                foreach ($v1 as $opt_key => $opt_val) {

                    switch ($opt_key) {

                        case 'args':
                            $arguments = explode(",", $opt_val);
                            $tmp = array();
                            foreach ($arguments as $v2) {
                                if (array_key_exists($v2, $row)) {
                                    array_push($tmp, $v2 . "=" . $row[$v2]);
                                }
                            }
                            $opts .= ' args="' . implode("&", $tmp) . '"';
                            break;
                        case 'target':
                            $opts .= ' target="' . $opt_val . '"';
                            break;
                        case 'action':
                            $opts .= ' action ="' . site_url($opt_val) . '"';
                            break;
                        case 'label':
                            $link_label = $opt_val;
                            break;

                    }

                }

                if ($link_label) {
                    echo '<td class="perm_list_link" ' . $opts . '>' . $link_label . '</td>';
                }
            }


            echo '<td class="perm_list_link" action="' . site_url('perm/delete_row') . '" args="table=' . $this->table . '&id=' . $row['id'] . '">Delete</td>';

            foreach ($row as $key => $val) {

                $label = ucfirst(str_replace("_", " ", str_ireplace("_id", "", $key)));

                if ($key === 'id') continue;
                //echo '<td>' . $label . '</td>';
                echo '<td> | </td>';
                echo '<td>' . $val . '</td>';

            }


            echo '</tr>';
        }
        echo '</table>';
    }


    private function _render_list_row()
    {
        $CI = &get_instance();

        $fields = $CI->db->list_fields($this->table);
        $show = array();
        $uri = uri_string();

        //print_r($fields);

        foreach ($fields as $field) {
            if (array_key_exists($field, $this->fields) && is_array($this->fields[$field]) && array_key_exists('hidden', $this->fields[$field])) {


            } else {
                array_push($show, $field);
            }
        }
        if (sizeof($show) != 0) {
            $CI->db->select('id,' . implode(",", $show));
        }

        if ($this->search_condition) {
            // get values
            $query = $CI->db->get_where($this->table, $this->search_condition);
        } else {
            $query = $CI->db->get($this->table);
        }

        // get row count for rowspan
        $rowspan = $query->num_rows();

        echo '<div class="db_exp_wrapper">';
        foreach ($query->result_array() as $row) {

            echo '<div class="group db_exp_row">';
            echo '<div class="db_exp_left db_exp_checkbox">' . form_checkbox('checkbox_' . $row['id'], 'accept') . '</div>';

            echo '<div class="db_exp_left db_exp_fields">';

            foreach ($row as $key => $val) {

                $label = ucfirst(str_replace("_", " ", str_ireplace("_id", "", $key)));

                $val = $this->display_field($key, $val);

                if ($key === 'id') continue;
                echo '<div class="db_exp_field_row group">';
                echo '<div class="db_exp_left db_exp_label">' . $label . '</div>';
                echo '<div class="db_exp_left db_exp_sep"> : </div>';
                echo '<div class="db_exp_left db_exp_value">' . $val . '</div>';
                echo '</div>';
            }
            echo '</div>';

            echo '	<div class="db_exp_right db_exp_links">
						<div class="perm_detail_link db_exp_icon_btn" action="' . site_url($uri) . '" args="action=edit&id=' . $row['id'] . '"><i class="material-icons md-light" style="font-size: 16px;">edit</i></div>
						<div class="perm_detail_link db_exp_icon_btn" action="' . site_url('perm/delete_row') . '" args="table=' . $this->table . '&id=' . $row['id'] . '"><i class="material-icons md-light" style="font-size: 16px;">delete</i></div>
						
					
					</div>';
            echo '</div>';
        }
        echo '</div>';

        //<div class="perm_detail_link" action="'.site_url($uri).'" args="action=edit"> A </div>

        echo '<div class="perm_detail_link db_exp_button" action="' . site_url($uri) . '" args="action=insert"> Insert </div>';
    }

    private function display_field($key, $val)
    {

        if (array_key_exists($key, $this->fields)) {

            $tmp = $this->fields[$key];
            //print_r($tmp);
            foreach ($tmp as $k => $v) {

                if ($k == 'db_select' || $k == 'db_multiselect' || $k == 'select' || $k == 'multiselect') {
                    $options = $this->fields[$key][$k];
                    $val = $options[$val];
                    break;
                }

                if ($k == 'password') {
                    $val = '*************';
                    break;
                }
            }

        }

        return $val;
    }

    private function _set_readonly()
    {

        $this->show_submit_button = false;

        $CI = &get_instance();

        $q = 'describe ' . $this->table;
        $query = $CI->db->query($q);

        foreach ($query->result_array() as $row) {

            $fn = $row ['Field'];
            if (array_key_exists($fn, $this->fields)) {
                $this->fields[$fn]['view'] = true;
            } else {
                $this->fields[$fn] = array('view' => true);
            }
        }
    }
}