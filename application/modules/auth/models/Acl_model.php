<?php
/**
 * Created by PhpStorm.
 * User: akyoo
 * Date: 25/10/2017
 * Time: 08:09
 */

class Acl_model extends CI_Model
{

    /**
     * @var string
     */
    private static $table_name_permissions = "acl_permissions";
    /**
     * @var string
     */
    private static $table_name_filters = "acl_filters";
    /**
     * @var string
     */
    private static $table_name_users_permissions = "acl_users_permissions";


    /**
     * @param $permission
     * @return mixed
     */
    public function create_permission($permission)
    {
        return $this->db->insert(self::$table_name_permissions, $permission);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    public function find_permissions($limit = 100, $offset = 0)
    {
        $this->db->limit($limit, $offset);
        return $this->db->get(self::$table_name_permissions)->result();
    }

    /**
     * @param $filter
     * @return mixed
     */
    public function create_filter($filter)
    {
        return $this->db->insert(self::$table_name_filters, $filter);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param null $permission_id
     * @return mixed
     */
    public function find_filters($limit = 100, $offset = 0, $permission_id = null)
    {
        if ($permission_id != null) {
            $this->db->where("permission_id", $permission_id);
        }
        $this->db->limit($limit, $offset);
        return $this->db->get(self::$table_name_filters)->result();
    }

    /**
     * @param $permission_id
     * @return mixed
     */
    public function count_permission_filters($permission_id)
    {
        $this->db->from(self::$table_name_filters);
        $this->db->where("permission_id", $permission_id);
        return $this->db->count_all_results();
    }

    /**
     * @param $user_id
     * @param $table_name
     * @return null|string
     */
    public function find_user_permissions($user_id, $table_name)
    {
        $this->db->select("where_condition");
        $this->db->from(self::$table_name_permissions . "  p");
        $this->db->join(self::$table_name_users_permissions . " up", "up.permission_id=p.id");
        $this->db->join(self::$table_name_filters . " f", "f.permission_id=p.id");
        $this->db->where("up.user_id", $user_id);
        $this->db->where("f.table_name", $table_name);
        $perms = $this->db->get()->result();

        if ($perms) {
            $count = count($perms);
            $condition = "";
            $i = 0;
            foreach ($perms as $p) {
                $condition .= $p->where_condition;
                if ($count > 1 && $i < ($count - 1)) {
                    $condition .= " AND ";
                }
                $i++;
            }
            return $condition;
        } else {
            return null;
        }
    }
}