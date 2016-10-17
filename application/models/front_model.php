<?php

class front_model extends CI_Model {

    function getpagedata($id) {
        $this->db->where('slug', $id);
        $query = $this->db->get('pages');
        $result = $query->result_array();
        return $result;
    }

    function getfaq() {
        $this->db->where('status', '1');
        $this->db->order_by('order', 'ASC');
        $this->db->order_by('date', 'DESC');
        $query = $this->db->get('faq');
        $result = $query->result_array();
        return $result;
    }

    function slider() {
        $this->db->where('status', '1');
        $this->db->order_by('order', 'ASC');
        $query = $this->db->get('slider');
        $result = $query->result_array();
        return $result;
    }

    function contactquery($data) {
        $insert = $this->db->insert('contactquery', $data);
        return $insert;
    }

    function category() {
        $this->db->where('featured_catg', '1');
        $this->db->where('status', '1');
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('category');
        $result = $query->result_array();
        return $result;
    }

    function categoryname($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('category');
        $this->db->order_by('category_name', 'ASC');
        $result = $query->result_array();
        return $result;
    }

    function templates($id, $limit_start, $limit_end, $search) {
        if ($id) {
            $ids = ',' . $id;
            $ids1 = $id . ',';
            $this->db->join('coin_category', 'coins.id = coin_category.coin_id', 'left');
            $this->db->where('coin_category.cat_id', $id);
             $this->db->where('coins.design_lib !=', '1');
        }
        if ($search) {
            $this->db->like('keyword', $search);
            $this->db->or_like('coin_name', $search);
            $this->db->join('coin_category', 'coins.id = coin_category.coin_id', 'left');
        }
        $this->db->limit($limit_start, $limit_end);
        $this->db->order_by('coins.position', 'ASC');
        $this->db->order_by('coins.id', 'ASC');
        $this->db->where('coins.status', '1');
        $query = $this->db->get('coins');
        $result = $query->result_array();
        return $result;
    }
    function designtemplates($id, $limit_start=null, $limit_end=null) {
        $this->db->join('coin_category', 'coins.id = coin_category.coin_id', 'left');
        $this->db->where('coin_category.cat_id', $id);
        $this->db->where('coins.design_lib', '1');
        $this->db->limit($limit_start, $limit_end);
        $this->db->order_by('coins.position', 'ASC');
        $this->db->order_by('coins.id', 'ASC');
        $this->db->where('coins.status', '1');
        $query = $this->db->get('coins');
        $result = $query->result_array();
        return $result;
    }

    function count_products($id, $search = NULL) {
        $this->db->select('*');
        if ($id) {
            $ids = ',' . $id;
            $ids1 = $id . ',';
            //  $this->db->where("category_id =  '$id' OR category_id LIKE '%$ids%' OR category_id LIKE '%$ids1%'");

            $this->db->join('coin_category', 'coins.id = coin_category.coin_id', 'left');
            $this->db->where('coin_category.cat_id', $id);
            $this->db->where('coins.design_lib !=', '1');
        }
        if ($search) {
            $this->db->like('coin_name', $search);
            $this->db->or_like('keyword', $search);
        }
        $this->db->from('coins');
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_designproducts($id) {
        $this->db->select('*');
            //  $this->db->where("category_id =  '$id' OR category_id LIKE '%$ids%' OR category_id LIKE '%$ids1%'");
            $this->db->join('coin_category', 'coins.id = coin_category.coin_id', 'left');
            $this->db->where('coin_category.cat_id', $id);
            $this->db->where('coins.design_lib', '1');
           $this->db->from('coins');
          $query = $this->db->get();
          return $query->num_rows();
    }

    function count_category() {
        $this->db->select('*');
        $this->db->where('status', '1');
        $this->db->from('category');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function homecategory($limit_start = NULL, $limit_end = NULL) {
        $this->db->where('status', '1');
        $this->db->order_by('category_name', 'ASC');
        if ($limit_start) {
            $this->db->limit($limit_start, $limit_end);
        }
        $query = $this->db->get('category');
        $result = $query->result_array();
        return $result;
    }

    function countcoincategory() {
        $this->db->join('coin_category', 'category.id = coin_category.cat_id', 'left');
        $this->db->join('coins', 'coins.id = coin_category.coin_id', 'left');
        $this->db->where('coins.design_lib !=', '1');
        $this->db->group_by('category.id');
        $this->db->where('category.status', '1');
        $this->db->where('category.art_frame', '1');
        $this->db->order_by('category.category_name', 'ASC');
        $query = $this->db->get('category');
        return $query->num_rows();
    }

    function countdesigncategory() {
        $this->db->join('coin_category', 'category.id = coin_category.cat_id', 'left');
        $this->db->join('coins', 'coins.id = coin_category.coin_id', 'left');
        $this->db->where('coins.design_lib', '1');
        $this->db->group_by('category.id');
        $this->db->where('category.status', '1');
        $this->db->where('category.design_temp', '1');
        $this->db->order_by('category.category_name', 'ASC');
      
        $query = $this->db->get('category');
        return $query->num_rows();
    }

    function designcategory($limit_start = NULL, $limit_end = NULL) {
        if ($limit_start) {
            $this->db->limit($limit_start, $limit_end);
        }
        $this->db->where('category.status', '1');
        $this->db->order_by('category_name', 'ASC');
        $this->db->join('coin_category', 'category.id = coin_category.cat_id', 'left');
        $this->db->join('coins', 'coins.id = coin_category.coin_id', 'left');
        $this->db->where('coins.design_lib', '1');
        $this->db->where('category.design_temp', '1');
        $this->db->group_by('category.id');
        $this->db->order_by('category.category_name', 'ASC');
        $query = $this->db->get('category');
         $result = $query->result_array();
        return $result;
    }

    function coincategory($limit_start = NULL, $limit_end = NULL) {
        if ($limit_start) {
            $this->db->limit($limit_start, $limit_end);
        }
        $this->db->where('category.status', '1');
         $this->db->where('category.art_frame', '1');
        $this->db->order_by('category_name', 'ASC');
        $this->db->join('coin_category', 'category.id = coin_category.cat_id', 'left');
        $this->db->join('coins', 'coins.id = coin_category.coin_id', 'left');
        $this->db->where('coins.design_lib !=', '1');
        $this->db->group_by('category.id');
        $this->db->order_by('category.category_name', 'ASC');
        $query = $this->db->get('category');
        $result = $query->result_array();
        return $result;
    }

    function homecategorycoins() {
        $this->db->where('category.status', '1');
        $this->db->where('category.art_frame', '1');
        $this->db->order_by('category_name', 'ASC');
        $this->db->join('coin_category', 'category.id = coin_category.cat_id', 'left');
        $this->db->join('coins', 'coins.id = coin_category.coin_id', 'left');
        $this->db->where('coins.design_lib !=', '1');
        $this->db->group_by('category.id');
        $this->db->order_by('category.category_name', 'ASC');
        $query = $this->db->get('category');
        $result = $query->result_array();
        return $result;
    }

    function templatesname($id) {
        $this->db->join('coin_category', 'coins.id = coin_category.coin_id', 'left');
        $this->db->where('coin_category.cat_id', $id);
        $this->db->order_by('position', 'ASC');
        $this->db->where('design_lib !=', '1');
        $query = $this->db->get('coins');
        $result = $query->result_array();
        return $result;
    }

    function designtemplatesname($id) {
        $this->db->join('coin_category', 'coins.id = coin_category.coin_id', 'left');
        $this->db->where('coin_category.cat_id', $id);
        $this->db->where('design_lib', '1');
        $this->db->order_by('position', 'ASC');
        $query = $this->db->get('coins');
        $result = $query->result_array();
        return $result;
    }

    function boxes() {
        $this->db->where('show_home', '1');
        $this->db->order_by('position', 'ASC');
        $query = $this->db->get('boxes');
        $result = $query->result_array();
        return $result;
    }

    function headermenu() {
        $this->db->where('menu', 'header');
        $this->db->order_by('menu_position', 'ASC');
        $this->db->order_by('date', 'DESC');
        $query = $this->db->get('pages');
        $result = $query->result_array();
        return $result;
    }

    function footermenu() {
        $this->db->where('menu', 'footer');
        $this->db->order_by('menu_position', 'ASC');
        $this->db->order_by('date', 'DESC');
        $query = $this->db->get('pages');
        $result = $query->result_array();
        return $result;
    }

}

?>
