<?php

class Order_model extends CI_Model {
    function getOrder_detail($id){
         $this->db->where('order_id', $id);
        $query = $this->db->get('order');
        $result = $query->result_array();
        return $result;
    }
    function getCoins_detail($id){
        $this->db->where('order_id', $id);
        $query = $this->db->get('order_detail');
        $result = $query->result_array();
        return $result;
    }
    function geteaglegiftbox_detail($id){
        $this->db->where('order_id', $id);
        $query = $this->db->get('eagle_gift_box');
        $result = $query->result_array();
        return $result;
    }
    function getgiftbox_detail($id){
        $this->db->where('order_id', $id);
        $query = $this->db->get('gift_box');
        $result = $query->result_array();
        return $result;
    }
            function add_temp($data){
     $insert = $this->db->insert('temp_order', $data);
       return TRUE;
}
function delete_temporder($id){
    $this->db->delete('temp_order', array('user_id' => $id));
        return TRUE;
}
function deleteorder_detail($id){
    $this->db->delete('order_detail', array('order_id' => $id));
        return TRUE;
}
function deletegiftbox_detail($id){
    $this->db->delete('gift_box', array('order_id' => $id));
        return TRUE;
}
        function get_txn($id){
      $this->db->where('user_id', $id);
        $query = $this->db->get('temp_order');
        $result = $query->result_array();
        return $result;
}
        function add_order($data) {
        $insert = $this->db->insert('order', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    function order_status($id){
        $this->db->where('order_id', $id);
        $query = $this->db->get('order');
        $result = $query->result_array();
        return $result;
    }
    function order_detail_insert($data) {
        $insert = $this->db->insert('order_detail', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    
      function eagle_giftbox_insert($data) {
        $insert = $this->db->insert('eagle_gift_box', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
      function giftbox_insert($data) {
        $insert = $this->db->insert('gift_box', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function getorder($limit_start, $limit_end) {
        $this->db->select('order.*,user.first_name as fn,user.last_name as ln');
         $this->db->limit($limit_start, $limit_end);
        $this->db->join('user', 'user.user_id = order.user_id ', 'left');
        $this->db->order_by('order_id', 'DESC');
        return $this->db->get('order')->result_array();
    }

    function delete_order($id) {
        $this->db->delete('order', array('order_id' => $id));
        return TRUE;
    }
    function giftbox($id){
   $this->db->where('order_id', $id);
   $query = $this->db->get('gift_box');
   $result = $query->result_array();
   return $result;     
    }
            function order_detail($id) {
        $this->db->where('order_id', $id);
        $query = $this->db->get('order_detail');
        $result = $query->result_array();
        return $result;
    }

    function getuserorder($id) {
        $this->db->select('order.*,user.first_name as fn,user.last_name as ln');
        $this->db->join('user', 'user.user_id = order.user_id ', 'left');
        $this->db->where('order.user_id', $id);
        $this->db->order_by('order.order_id', 'DESC');
        return $this->db->get('order')->result_array();
    }

    function userorderdetail($id) {
        $this->db->select('order_detail.*,order.shipping_amount as shpamt,order.total_paid as tpaid,order.order_status as status,order.tax as tax, order.discount as disc ');
        $this->db->join('order', 'order.order_id = order_detail.order_id ', 'left');
        $this->db->where('order_detail.order_id', $id);
        return $this->db->get('order_detail')->result_array();
    }
    function count_order($id){
        $this->db->select('*');
        $this->db->where('user_id', $id);
        $this->db->from('order');
        $query = $this->db->get();
        return $query->num_rows();
    }
    function getuserorderdetail($id, $limit_start, $limit_end) {
        $this->db->select('order.*,user.first_name as fn,user.last_name as ln');
        $this->db->join('user', 'user.user_id = order.user_id ', 'left');
        $this->db->where('order.user_id', $id);
        $this->db->order_by('order.order_id', 'DESC');
        $this->db->limit($limit_start, $limit_end);
        return $this->db->get('order')->result_array();
    }
    function updateorder_status($id,$data){
       $this->db->where('order_id', $id);
       return $this->db->update('order', $data);
       
    }
    function setcouponused($couponcode,$CId,$userid){
        $data = array('u_status' => '0','used_by'=>$userid,'used_date'=>  date('Y-m-d'));
        $this->db->where('multi_use !=', 'yes');
        $this->db->where('coupon_type !=', 'unlimited');
        $this->db->where('coupon_code', $couponcode);
        $this->db->where('id', $CId);
        $this->db->update('coupon_detail', $data);
        return true;
    }
       function count_orders() {
        $this->db->select('*');
        $this->db->from('order');
        $query = $this->db->get();
        return $query->num_rows();
    }

}

?>