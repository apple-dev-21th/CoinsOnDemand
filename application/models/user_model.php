<?php

class User_model extends CI_Model {
function pendingcart($data){
        $insert = $this->db->insert('pending_cart', $data);
        return $insert;
    }
    function pendingcart_updateprice($data,$id){
        $this->db->where('ip_address', $id);
        $this->db->update('pending_cart', $data);
        return true;
    }
    function pendingcart_deleteitem($id){
        $this->db->where('item_id', $id);       
        $this->db->delete('pending_cart');
        return true;
    }
    function pendingcart_updateqty($data,$id){
        $this->db->where('item_id', $id);
        $this->db->update('pending_cart', $data);
        return true;
    }
    function pending_cartitems($user_id = NULL){
       $this->db->where("user_id =  '$user_id' ");
        $query = $this->db->get('pending_cart');
        $result = $query->result_array();
        return $result;  
    }
    function pending_cartitems_ip($ip,$user_id = NULL){
       $this->db->where("ip_address = '$ip'");
        $query = $this->db->get('pending_cart');
        $result = $query->result_array();
        return $result;  
    }
    function update_user_pendingcart($ip,$data){
       $this->db->where('ip_address', $ip);
        $this->db->update('pending_cart', $data);
        return true; 
    }
    function deletepending_cart($user_id){
       $this->db->where('user_id', $user_id);       
       $this->db->delete('pending_cart');
       return true;
    }
            function user_profile($id) {
        $this->db->where('user_id', $id);
        $query = $this->db->get('user');
        $result = $query->result_array();
        return $result;
    }

    function checkmail($id, $email) {
        $this->db->where('email_id', $email);
        $this->db->where('user_id !=', $id);
        $query = $this->db->get('user');
        return $query->num_rows();
    }
    function checkshippingadrees($id){
        $this->db->where('user_id', $id);
        $query = $this->db->get('shipping_address');
        return $query->num_rows();
    }

    function updateemail($id, $data) {
        $this->db->where('user_id', $id);
        $this->db->update('user', $data);
        return true;
    }
function updateprofile($id, $data) {
        $this->db->where('user_id', $id);
        $this->db->update('user', $data);
        return true;
    }
    function updatepassword($id, $data) {
        $this->db->where('user_id', $id);
        $this->db->update('user', $data);
        return true;
    }

    function billingaddress($id) {
     //   $this->db->select('billing_address.*');
        $this->db->where('user_id', $id);
        $query = $this->db->get('billing_address');
        //$this->db->join('regions', 'billing_address.country = regions.id ', 'left');
        //$this->db->join('subregions', 'billing_address.state = subregions.region_id ', 'left');
        $result = $query->result_array();
        return $result;
    }
    function shipingaddress($id) {
        $this->db->where('user_id', $id);
        $query = $this->db->get('shipping_address');
        $result = $query->result_array();
        return $result;
    }

    function updateadd($id, $data) {
        $this->db->where('user_id', $id);
        $this->db->update('billing_address', $data);
        return true;
    }
function updateshipping($id, $data){
      $this->db->where('user_id', $id);
        $this->db->update('shipping_address', $data);
        return true;
}
    function add_address($data) {
        $insert = $this->db->insert('billing_address', $data);
        return $insert;
    }
    function add_shipping($data) {
        $insert = $this->db->insert('shipping_address', $data);
        return $insert;
    }

    function user_detail($email) {
        $this->db->where('email_id', $email);
        $query = $this->db->get('user');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
    }
    function insertforgotpwd($data){
        $insert = $this->db->insert('forgotpassword', $data);
        return $insert;
    }
    function checknumvalid($id) {
        
        $this->db->where('randomnumber', $id);
        $this->db->where('status', '1');
        $query = $this->db->get('forgotpassword');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return FALSE;
        }
    }
    function getuser(){
        $this->db->select('user.*,billing_address.state as st,billing_address.address as adr,billing_address.post_code as zip,billing_address.city as ct,billing_address.phone as ph,billing_address.country as ctry');
          $this->db->where('user.user_type !=', 'guest');
        $this->db->join('billing_address', 'user.user_id = billing_address.user_id ', 'left');
        $this->db->group_by('billing_address.user_id'); 
        $this->db->order_by('user.user_id', 'DESC');
        return $this->db->get('user')->result_array();
    }
    function delete_user($id){
        $this->db->delete('user', array('user_id' => $id));
        $this->db->delete('billing_address', array('user_id' => $id));
        $this->db->delete('shipping_address', array('user_id' => $id));
         return true;        
    }
    function getstates() {
        $this->db->from('subregions');
        $this->db->order_by("name", "ASC");
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    function getstatesbycountry($id){
         $this->db->from('subregions');
        $this->db->order_by("name", "ASC");
        $this->db->where('region', $id);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
     function getcountries() {
        $this->db->from('regions');
        $this->db->order_by("country", "ASC");
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    function updateforgotpwd($id){
          $data = array('status' => '0');
        $this->db->where('user_id', $id);
        $this->db->update('forgotpassword', $data);
        return true;
    }

}

?>
