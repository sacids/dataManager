<?php
/**
 * Created by PhpStorm.
 * User: Renfrid-Sacids
 * Date: 2/4/2016
 * Time: 9:44 AM
 */

class Xform_model extends CI_Model {



    public function create_table($statement){

        if ($this->db->simple_query($statement))
        {
            echo "Success!";
        }
        else
        {
            //echo "Query failed!";
            $error = $this->db->error(); // Has keys 'code' and 'message'
            echo $statement;
            print_r($error);
        }
    }

    public function insert_data($statement){

        if ($this->db->simple_query($statement))
        {
            echo "Success!";
        }
        else
        {
            //echo "Query failed!";
            $error = $this->db->error(); // Has keys 'code' and 'message'
            echo $statement;
            print_r($error);
        }
    }
}