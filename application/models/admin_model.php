<?php
class Admin_model extends CI_Model {
    function validate($user_name, $password) {
        $this->db->where('user_name', $user_name);
        $this->db->where('password', $password);
        $query = $this->db->get('admin');
         $result = $query->result_array();
        return $result;
    }

    function updatepassword($user_id, $old_password,$data){
       $this->db->where('id', $user_id);
       $this->db->where('password', $old_password);
       $result= $this->db->update('admin', $data);
        return $result;
    }

    function getoldpassword($user_id) {
        $this->db->where('id', $user_id);
        $query = $this->db->get('admin');
        $result = $query->result_array();
        return $result;
    }
}
?>