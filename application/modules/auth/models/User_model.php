<?php

/**
 * User_model.php
 * model for users
 * Author : Renfrid Ngolongolo
 */
class User_model extends CI_Model
{
    private static $table_name = "users";
    private static $groups_table_name = "groups";
    private static $users_groups_table_name = "users_groups";

    function __construct()
    {
        parent::__construct();
    }

    public function create($user)
    {
        return $this->db->insert(self::$table_name, $user);
    }

    function count_users()
    {
        return $this->db->get(self::$table_name)->num_rows();
    }

    //count data collectors
    function count_data_collectors()
    {
        return $this->db
            ->group_start()
            ->where('groups.name', 'members')
            ->or_where('groups.name', 'chr')
            ->group_end()
            ->join('users_groups', 'users_groups.user_id = users.id')
            ->join('groups', 'groups.id = users_groups.group_id')
            ->get('users')->num_rows();
    }

    /**
     * @return mixed
     */
    function find_all()
    {
        $users = $this->db
            ->get(self::$table_name)->result();
        return $users;
    }

    /**
     * @param $num
     * @param $start
     * @return mixed
     */
    function get_users_list($num = 100, $start = 0)
    {
        return $this->db
            ->select('*, users.id as user_id')
            ->limit($num, $start)
            ->get(self::$table_name)->result();
    }

    /**
     * @param $user_id
     * @return mixed
     */
    function get_user_by_id($user_id)
    {
        $users = $this->db->get_where('users', array('users.id' => $user_id))->row();
        return $users;
    }

    function delete_user($user_id)
    {
        $this->db->delete('users', array('users.id' => $user_id));
    }

    /**
     * @param $user_id
     * @return mixed
     */
    function find_by_id($user_id)
    {
        $this->db->where("id", $user_id);
        return $this->db->get(self::$table_name)->row(1);
    }

    /**
     * @param $user_id
     * @return string
     */
    function get_user_details($user_id)
    {
        $query = $this->db->get_where(self::$table_name, array('id' => $user_id))->row();
        return ($query) ? $query->first_name . ' ' . $query->last_name : FALSE;
    }

    /**
     * @param $username
     * @return mixed
     */
    function find_by_username($username)
    {
        $query = $this->db->get_where(self::$table_name, array('username' => $username));
        return $query->row();
    }

    public function find_user_groups()
    {
        return $this->db->get(self::$groups_table_name)->result();
    }

    public function get_user_groups_by_id($user_id)
    {
        $this->db->select("ug.*,g.*");
        $this->db->from(self::$users_groups_table_name . " ug");
        $this->db->join(self::$table_name . " u", "u.id = ug.user_id");
        $this->db->join(self::$groups_table_name . " g", "g.id = ug.group_id");
        $this->db->where("ug.user_id", $user_id);
        return $this->db->get()->result();
    }

    /**
     * @param null $name
     * @param null $phone
     * @param null $status
     * @return mixed
     */
    public function search_users($name = NULL, $phone = NULL, $status = NULL)
    {
        if ($name != NULL) {
            $this->db->group_start()
                ->or_like("first_name", $name)
                ->or_like("last_name", $name)
                ->group_end();
        }

        if ($phone != NULL)
            $this->db->or_where("phone", $phone);

        if ($status != NULL)
            $this->db->where("active", $status);

        return $this->db
            ->select('*, users.id as user_id')
            ->get(self::$table_name)->result();
    }

    /**
     * @param null $name
     * @param null $phone
     * @param null $status
     * @return mixed
     */
    public function count_users_by_search_terms($name = NULL, $phone = NULL, $status = NULL)
    {
        if ($name != NULL) {
            $this->db->group_start()
                ->or_like("first_name", $name)
                ->or_like("last_name", $name)
                ->group_end();
        }

        if ($phone != NULL)
            $this->db->or_where("phone", $phone);

        if ($status != NULL)
            $this->db->where("active", $status);

        return $this->db->get(self::$table_name)->num_rows();
    }


    function get_perms_list($group_id)
    {
        $array = array();
        $module = array();

        $perms_module = $this->db->order_by('perms_module.name', 'ASC')->get('perms_module')->result();

        foreach ($perms_module as $key => $value) {

            $perms = $this->db->get_where('perms', array('module_id' => $value->id))->result();

            foreach ($perms as $k => $v) {

                $check = $this->db->get_where('perms_group', array('group_id' => $group_id, 'module_id' => $value->id, 'perm_slug' => $v->perm_slug))->row();

                //perm module array
                $module[$value->name][$v->perm_slug] = array($value->id, $v->id, $v->name);

                if (count($check) == 1) {
                    $array[$value->name][$v->perm_slug] = $check->allow;
                } else {
                    $array[$value->name][$v->perm_slug] = 0;
                }
            }
        }

        return array($array, $module);
    }

    /**
     * Count module
     *
     * @return mixed
     */
    public function count_module()
    {
        $this->db->from("perms_module");
        return $this->db->count_all_results();
    }

    /**
     * Find all module
     *
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    public function find_all_module($limit = 30, $offset = 0)
    {
        $this->db
            ->limit($limit, $offset);
        return $this->db
            ->order_by('perms_module.name', 'ASC')
            ->get("perms_module")->result();
    }

    /**
     * get module by id
     *
     * @param $module_id
     * @return mixed
     */
    function get_module_by_id($module_id)
    {
        return $this->db->get_where('perms_module', array('id' => $module_id))->row();
    }

    /**
     * Count perms
     *
     * @return mixed
     */
    public function count_perms()
    {
        $this->db->from("perms");
        return $this->db->count_all_results();
    }

    /**
     * Find all module
     *
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    public function find_all_perms($limit = 30, $offset = 0)
    {
        $this->db
            ->limit($limit, $offset);
        return $this->db
            ->select('perms.id as p_id, perms.name as p_name, perms_module.name as m_name, perms.perm_slug')
            ->order_by('perms_module.name', 'ASC')
            ->join('perms_module', 'perms_module.id = perms.module_id')
            ->get("perms")->result();
    }

    /**
     * @param $perm_id
     * @return mixed
     */
    public function get_perm_by_id($perm_id)
    {
        return $this->db->get_where("perms", array('perms.id' => $perm_id))->row();
    }


    /**
	 * @param type
	 * @return int
	 */
	function count_all()
	{
		//$this->where_condition();

		return $this->db
			->group_by('users.id')
			->join('users_groups', 'users_groups.user_id = users.id')
			->get('users')->num_rows();
	}

	/**
	 * @param $num
	 * @param $start
	 * @return mixed
	 */
	function get_all($num = null, $start = null)
	{
		//$this->where_condition();

		if ($num != null && $start != null)
			$this->db->limit($num, $start);

		return $this->db
			->select('*, users.id as user_id')
			->order_by('users.first_name')
			->get('users')->result();
	}

	/**
	 * @param null $group_id
	 * @param null $keyword
	 * @return mixed
	 */
	function search_all($group_id = null, $keyword = null)
	{
		//$this->where_condition();

		if ($group_id != null)
			$this->db->where('users_groups.group_id', $group_id);

		if ($keyword != NULL) {
			$this->db->group_start();
			$this->db->like('users.first_name', $keyword);
			$this->db->or_like('users.last_name', $keyword);
			$this->db->or_like('users.username', $keyword);
			$this->db->group_end();
		}

		return $this->db
			->select('*, users.id as user_id')
			->group_by('users.id')
			->order_by('users.first_name')
			->join('users_groups', 'users_groups.user_id = users.id')
			->get('users')->result();
	}

	/**
	 * @param $group_id
	 * @return mixed
	 */
	function get_users_by_group_id($group_id)
	{
		//$this->where_condition();

		return $this->db
			->select('*, users.id as user_id')
			->order_by('users.first_name', 'asc')
			->group_by('users.id')
			->join('users_groups', 'users_groups.user_id = users.id')
			->get_where('users', array('users_groups.group_id' => $group_id))->result();
	}

	/**
	 * @param $where_ids
	 * @return mixed
	 */
	function get_users_by_ids($where_ids)
	{
		//$this->where_condition();

		return $query = $this->db
			->order_by('first_name', 'asc')
			->where_in('id', $where_ids)
			->get($this->table)
			->result();
	}

	//get by
	function get_by($where)
	{
		return $this->db->get_where($this->table, $where)->row();
	}
}

/* End of file users_model.php */
/* Location: ./application/model/survey_model.php */