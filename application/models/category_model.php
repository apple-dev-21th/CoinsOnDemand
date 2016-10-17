<?php

class Category_model extends CI_Model {

    function addcategory($data) {
        $insert = $this->db->insert('category', $data);
        return $insert;
    }

    function getcategory() {
        $this->db->from('category');
        $this->db->order_by('category_name', 'ASC');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function categorycoins($id) {
        $this->db->from('coins');
        $this->db->like('category_id', $id);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function deactcateg($id) {
        $data = array('featured_catg' => '0');
        $this->db->where('id', $id);
        $this->db->update('category', $data);
        return true;
    }

    function inactcateg($id) {
        $data = array('status' => '0');
        $this->db->where('id', $id);
        $this->db->update('category', $data);
        return true;
    }

    function activatecateg($id) {
        $data = array('status' => '1');
        $this->db->where('id', $id);
        $this->db->update('category', $data);
        return true;
    }

    function actcateg($id) {
        $data = array('featured_catg' => '1');
        $this->db->where('id', $id);
        $this->db->update('category', $data);
        return true;
    }

    function deletecatg($id) {
        $this->db->where('id', $id);
        $this->db->delete('category');
        return true;
    }

    function delete_coinsfromrelation($id) {
        $this->db->where('cat_id', $id);
        $this->db->delete('coin_category');
        return true;
    }

    function delete_coinrelation($id) {
        $this->db->where('coin_id', $id);
        $this->db->delete('coin_category');
        return true;
    }

    public function delete_coins($id) {
        $this->db->where('category_id', $id);
        $this->db->delete('coins');
        return true;
    }

    function category_detail($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('category');
        $result = $query->result_array();
        return $result;
    }

    function updatecategory($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('category', $data);
        return true;
    }

    function addcoin($data) {
        $this->db->insert('coins', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function createrelation($data) {
        $insert = $this->db->insert('coin_category', $data);
        return $insert;
    }

    function selectcoins() {

//        $this->db->select('coins.*, category.id as catid, category.category_name as catname');
//        $this->db->join('coin_category', 'coins.id = coin_category.coin_id', 'left');
//        $this->db->join('category', 'coin_category.cat_id = category.id ', 'right');
//        $this->db->group_by('coin_category.coin_id');
//        $this->db->order_by('coins.id', 'DESC');
//        return $this->db->get('coins')->result_array();
//        
        //   select `coins`.*,`category`.`category_name` from coins , coin_category, category where coins.`id`=coin_category.`coin_id` and coin_category.`cat_id`=category.`id`
        $this->db->from('coins');
        $this->db->order_by("id", "ASC");
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function deactive_coin($id) {
        $data = array('status' => '0');
        $this->db->where('id', $id);
        $this->db->update('coins', $data);
        return true;
    }

    function active_coin($id) {
        $data = array('status' => '1');
        $this->db->where('id', $id);
        $this->db->update('coins', $data);
        return true;
    }

    function delete_coin($id) {
        $this->db->where('id', $id);
        $this->db->delete('coins');
        return true;
    }

    public function coindetail($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('coins');
        $result = $query->result_array();
        return $result;
    }

    public function updatecoin($id, $data) {

        $this->db->where('id', $id);
        $this->db->update('coins', $data);
        return true;
    }

    public function addbox($data) {
        $insert = $this->db->insert('boxes', $data);
        return $insert;
    }

    function deactbox($id) {
        $data = array('show_home' => '0');
        $this->db->where('id', $id);
        $this->db->update('boxes', $data);
        return true;
    }

    function actbox($id) {
        $data = array('show_home' => '1');
        $this->db->where('id', $id);
        $this->db->update('boxes', $data);
        return true;
    }

    function box_detail($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('boxes');
        $result = $query->result_array();
        return $result;
    }

    function deletebox($id) {
        $this->db->where('id', $id);
        $this->db->delete('boxes');
        return true;
    }

    function getboxes() {
        $this->db->from('boxes');
        $this->db->order_by("id", "DESC");
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function updatebox($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('boxes', $data);
        return true;
    }

    function coinprice() {
        $this->db->from('coin_pricing');
        $this->db->order_by("min", "ASC");
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    
    function americaneaglecoinprice() {
        
        $this->db->from('coin_american_eagle_pricing');
        $this->db->order_by("min", "ASC");
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function giftprice() {
        $this->db->from('gift_box_pricing');
        $query = $this->db->get();
        $result = $query->first_row();
        return $result;
    }

    function goldprice() {
        $this->db->from('gold_price');
        $query = $this->db->get();
        $result = $query->first_row();
        return $result;
    }

    function updatecoinprice($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('coin_pricing', $data);
        return true;
    }
    
    function updateamericancoinprice($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('coin_american_eagle_pricing', $data);
        return true;
    }
    
    function updategiftboxprice($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('gift_box_pricing', $data);
        return true;
    }

    function updategoldprice($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('gold_price', $data);
        return true;
    }

    function addcoupon($data) {
        $this->db->insert('coupons', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function addcoupondetail($data) {
        return $this->db->insert('coupon_detail', $data);
    }

    function couponlist() {
        $this->db->from('coupons');
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function delete_coupon($id) {
        $this->db->where('id', $id);
        $this->db->delete('coupons');
        return true;
    }

    function delete_coupondetail($id) {
        $this->db->where('coupon_id', $id);
        $this->db->delete('coupon_detail');
        return true;
    }

    function coupon_detail($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('coupons');
        $result = $query->result_array();
        return $result;
    }

    function coupon_subdetail($id) {
        $this->db->where('coupon_id', $id);
        $query = $this->db->get('coupon_detail');
        $result = $query->result_array();
        return $result;
    }

    function updatecoupon($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('coupons', $data);
        return true;
    }

    function discount_coupon($code) {
        $this->db->join('coupon_detail', 'coupon_detail.coupon_id = coupons.id', 'left');
        $this->db->where('coupon_detail.coupon_code', $code);
        $this->db->where('coupon_detail.u_status', '1');
        $query = $this->db->get('coupons');
        $result = $query->result_array();
        return $result;
    }

    function deact_coupon($id) {
        $data = array('status' => '0');
        $this->db->where('id', $id);
        $this->db->update('coupons', $data);
        return true;
    }

    function deact_subcoupon($id) {
        $data = array('status' => '0');
        $this->db->where('coupon_id', $id);
        $this->db->update('coupon_detail', $data);
        return true;
    }

    function act_coupon($id) {
        $data = array('status' => '1');
        $this->db->where('id', $id);
        $this->db->update('coupons', $data);
        return true;
    }

    function act_subcoupon($id) {
        $data = array('status' => '1');
        $this->db->where('coupon_id', $id);
        $this->db->update('coupon_detail', $data);
        return true;
    }

    function countcoins() {
        $this->db->from('coins');
        $this->db->order_by("id", "DESC");
        $query = $this->db->get();
        return $query->num_rows();
    }

    function countboxes() {
        $this->db->from('boxes');
        $this->db->order_by("id", "DESC");
        $query = $this->db->get();
        return $query->num_rows();
    }

    function update_distributed($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('coupon_detail', $data);
        return true;
    }
     function unique_coupons($pId,$cId){
       $this->db->where('coupon_code', $cId);
        $this->db->where('coupon_id', $pId);
        $query = $this->db->get('coupon_detail');
        if ($query->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
 }

}

 
?>
