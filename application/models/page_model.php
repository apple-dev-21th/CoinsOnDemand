<?php

class Page_model extends CI_Model {

    function add_page($data) {
        $insert = $this->db->insert('pages', $data);
        return $insert;
    }

    function pages() {
        $this->db->from('pages');
        $this->db->order_by("id", "DESC");
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function activepage($id) {
        $data = array('page_status' => '1');
        $this->db->where('id', $id);
        $this->db->update('pages', $data);
        return true;
    }

    function deavtivatepage($id) {
        $data = array('page_status' => '0');
        $this->db->where('id', $id);
        $this->db->update('pages', $data);
        return true;
    }

    function getpagedata($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('pages');
        $result = $query->result_array();
        return $result;
    }

    function updatepage($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('pages', $data);
        return true;
    }

    function deltepages($id) {
        $this->db->where('id', $id);
        $this->db->delete('pages');
        return true;
    }

    function addfaq($data) {
        $insert = $this->db->insert('faq', $data);
        return $insert;
    }

    function faqs() {
        $this->db->from('faq');
        $this->db->order_by("id", "DESC");
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function getfaqdata($id) {
         $this->db->where('id', $id);
        $query = $this->db->get('faq');
        $result = $query->result_array();
        return $result;
    }

    function deactfaq($id) {
        $data = array('status' => '0');
        $this->db->where('id', $id);
        $this->db->update('faq', $data);
        return true;
    }

    function activefaq($id) {
        $data = array('status' => '1');
        $this->db->where('id', $id);
        $this->db->update('faq', $data);
        return true;
    }

    function deltefaq($id) {
        $this->db->where('id', $id);
        $this->db->delete('faq');
        return true;
    }

    function updatefaq($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('faq', $data);
        return true;
    }
    function countfaq(){
        $this->db->from('faq');
        $this->db->order_by("id", "DESC");
        $query = $this->db->get();
         return $query->num_rows();
    }

}

?>
