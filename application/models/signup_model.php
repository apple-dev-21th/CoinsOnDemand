<?php

class Signup_model extends CI_Model {

    function register($data) {
        $insert = $this->db->insert('user', $data);
        return $this->db->insert_id();
    }

    function validate($user_name, $password) {
        $this->db->where('email_id', $user_name);
        $this->db->where('password', $password);
        $query = $this->db->get('user');
        $result = $query->result_array();
        return $result;
    }

}

?>
