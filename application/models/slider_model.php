<?php

class Slider_model extends CI_Model{
    function addslider($data){
        $insert = $this->db->insert('slider', $data);
        return $insert;
    }
    function slides(){
        $this->db->from('slider');
        $this->db->order_by("id", "DESC");
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    function delete_slider($id){
        $this->db->where('id', $id);
        $this->db->delete('slider');
        return true;
        
    }
    function deact_slider($id){
        $data = array('status' => '0');
        $this->db->where('id', $id);
        $this->db->update('slider', $data);
        return true;
    }
    function active_slider($id){
        $data = array('status' => '1');
        $this->db->where('id', $id);
        $this->db->update('slider', $data);
        return true;
    }
    function count_slider(){
        $this->db->from('slider');
        $this->db->order_by("id", "DESC");
        $query = $this->db->get();
         return $query->num_rows();
    }
    function updateslider($id,$data){
        $this->db->where('id', $id);
        $this->db->update('slider', $data);
        return true;
    }
}
?>
