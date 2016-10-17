<?php

class Category extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('date');
        $this->load->helper(array('form', 'url'));
        $this->load->model('category_model');
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin/login');
        }
    }
    public function addcateg() {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $baseurl = base_url();
            $path = './assets/uploads';
            $config['upload_path'] = './assets/uploads';
            $config['allowed_types'] = 'gif|jpg|png';
            $this->load->library('upload', $config);
            if (empty($_FILES['front_image']['name'])) {
                $this->form_validation->set_rules('front_image', 'Category Image', '');
            }
            $this->form_validation->set_rules('categ_name', 'Category Name ', 'required');
            if ($this->form_validation->run() == FALSE) {
                $data['main_content'] = 'admin/category/addcategory';
                $this->load->view('admin/include/template', $data);
            } else {
                //$name = $this->uploadimages($_FILES, $path);
                $category_img = $this->copyimage('front_image');
                $template_img = $this->copyimage('design_lib_img');
                $now = date("Y-m-d H:i:s");
                $condetail = array(
                    'category_image' => $category_img,
                    'template_img' => $template_img,
                    'design_temp' => $this->input->post('design_lib'),
                    'art_frame' => $this->input->post('art_frame'),
                    'category_name' => $this->input->post('categ_name'),
                    'featured_catg' => $this->input->post('featuredcatg'),
                    'status' => $this->input->post('categ_status'),
                    'date' => $now
                );
                if ($this->category_model->addcategory($condetail)) {
                    $this->session->set_flashdata('success', 'Category Inserted Succesfully');
                    redirect('admin/category/addcateg');
                }
            }
        } else {
            $data['main_content'] = 'admin/category/addcategory';
            $this->load->view('admin/include/template', $data);
        }
    }

    public function managecateg() {
        $data['category'] = $this->category_model->getcategory();
        $data['main_content'] = 'admin/category/managecategory';
        $this->load->view('admin/include/template', $data);
    }

    public function copyimage($name) {
        $path = './assets/uploads/';
        if (!empty($_FILES[$name])) {
            $imgname = basename(time() . $_FILES[$name]['name']);
            $uploadfile = $path . $imgname;
            //echo $uploadfile; die;
            if (move_uploaded_file($_FILES[$name]['tmp_name'], $uploadfile)) {
                return $imgname;
            }
        } else {
            return '';
        }
    }

    public function uploadimages($files, $folder) {
        $allfiles = "";
        $uploadefiles = $files;
        $this->load->helper('date');
        foreach ($uploadefiles as $file => $value) {
            $config['upload_path'] = $folder;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload($file)) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = $this->upload->data();
                $allfiles .= $data['file_name'] . ";";
            }
        }
        return substr($allfiles, 0, -1);
    }

    public function deact_catg() {
        $id = $this->uri->segment(4);
        if ($this->category_model->deactcateg($id)) {
            $this->session->set_flashdata('success', 'Category status changed succesfully.');
            redirect('admin/category/managecateg');
        }
    }

    public function inact_cat() {
        $id = $this->uri->segment(4);
        if ($this->category_model->inactcateg($id)) {
            $this->session->set_flashdata('success', 'Category status changed succesfully.');
            redirect('admin/category/managecateg');
        }
    }

    public function act_cat() {
        $id = $this->uri->segment(4);
        if ($this->category_model->activatecateg($id)) {
            $this->session->set_flashdata('success', 'Category status changed succesfully.');
            redirect('admin/category/managecateg');
        }
    }

    public function activate_catg() {
        $id = $this->uri->segment(4);
        if ($this->category_model->actcateg($id)) {
            $this->session->set_flashdata('success', 'Category status changed succesfully.');
            redirect('admin/category/managecateg');
        }
    }

    public function delete_catg() {
        $id = $this->uri->segment(4);
        /*  Delete where coin belong to 1 category only. */
        $data['detail'] = $this->category_model->category_detail($id);
        if ($this->category_model->deletecatg($id)) {
            unlink('./assets/uploads/' . $data['detail'][0]['category_image']);
        }

        /*  remove coin belong to category */
        $this->category_model->delete_coins($id);
        $this->category_model->delete_coinsfromrelation($id);

        /*  Remove category for multiple categories */
        $coins = $this->category_model->categorycoins($id);
        foreach ($coins as $coin) {
            $catids = explode(",", $coin['category_id']);
            $category_id = '';
            foreach ($catids as $cat) {
                if ($cat != $id) {
                    $category_id .=$cat . ',';
                }
            }
            $coindetail = array(
                'category_id' => $category_id,
                'date' => date("Y-m-d H:i:s")
            );

            $coinid = $coin['id'];
            $this->category_model->updatecoin($coinid, $coindetail);
        }
        $this->session->set_flashdata('success', 'Category deleted succesfully.');
        redirect('admin/category/managecateg');
    }

    public function edit_catg() {
        $id = $this->uri->segment(4);
        $data['detail'] = $this->category_model->category_detail($id);
        $data['main_content'] = 'admin/category/editcategory';
        $this->load->view('admin/include/template', $data);
    }

    public function updatecateg() {
        $id = $this->input->post('cate_id');
        $this->form_validation->set_rules('categ_name', 'Category Name ', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['detail'] = $this->category_model->category_detail($id);
            $data['main_content'] = 'admin/category/editcategory';
            $this->load->view('admin/include/template', $data);
        } else {
            if (empty($_FILES['front_image']['name'])) {
                $now = date("Y-m-d H:i:s");
                $condetail = array(
                    'featured_catg' => $this->input->post('featuredcatg'),
                    'design_temp' => $this->input->post('design_lib'),
                    'art_frame' => $this->input->post('art_frame'),
                    'category_name' => $this->input->post('categ_name'),
                    'status' => $this->input->post('categ_status'),
                    'date' => $now
                );
            }
            if (!empty($_FILES['front_image']['name']) && !empty($_FILES['design_lib_img']['name'])) {
                $category_img = $this->copyimage('front_image');
                $template_img = $this->copyimage('design_lib_img');
                $path = './assets/uploads';
                //  $name = $this->uploadimages($_FILES, $path);
                $now = date("Y-m-d H:i:s");
                $condetail = array(
                    'category_image' => $category_img,
                    'template_img' => $template_img,
                    'design_temp' => $this->input->post('design_lib'),
                    'art_frame' => $this->input->post('art_frame'),
                    'featured_catg' => $this->input->post('featuredcatg'),
                    'category_name' => $this->input->post('categ_name'),
                    'status' => $this->input->post('categ_status'),
                    'date' => $now
                );
            }
            if (!empty($_FILES['front_image']['name']) && empty($_FILES['design_lib_img']['name'])) { // No Design template Igm
                $category_img = $this->copyimage('front_image');

                $path = './assets/uploads';
                //  $name = $this->uploadimages($_FILES, $path);
                $now = date("Y-m-d H:i:s");
                $condetail = array(
                    'category_image' => $category_img,
                    'design_temp' => $this->input->post('design_lib'),
                    'art_frame' => $this->input->post('art_frame'),
                    'featured_catg' => $this->input->post('featuredcatg'),
                    'category_name' => $this->input->post('categ_name'),
                    'status' => $this->input->post('categ_status'),
                    'date' => $now
                );
            }
            if (empty($_FILES['front_image']['name']) && !empty($_FILES['design_lib_img']['name'])) { // No category Image
                $template_img = $this->copyimage('design_lib_img');
                $path = './assets/uploads';
                //  $name = $this->uploadimages($_FILES, $path);
                $now = date("Y-m-d H:i:s");
                $condetail = array(
                    'template_img' => $template_img,
                    'design_temp' => $this->input->post('design_lib'),
                    'art_frame' => $this->input->post('art_frame'),
                    'featured_catg' => $this->input->post('featuredcatg'),
                    'category_name' => $this->input->post('categ_name'),
                    'status' => $this->input->post('categ_status'),
                    'date' => $now
                );
            }
            if ($this->category_model->updatecategory($id, $condetail)) {
                $this->session->set_flashdata('success', 'Category updated succesfully.');
                redirect('admin/category/managecateg');
            }
        }
    }

    public function addcoins() {
        $data['total_coin'] = $this->category_model->countcoins();
        $data['category'] = $this->category_model->getcategory();
        $data['main_content'] = 'admin/category/addcoin';
        $this->load->view('admin/include/template', $data);
    }

    public function insertcoin() {
        $path = './assets/uploads';
        $config['upload_path'] = './assets/uploads';
        $config['allowed_types'] = 'gif|jpg|png';
        $this->load->library('upload', $config);
        if (empty($_FILES['coin_image']['name'])) {
            $this->form_validation->set_rules('coin_image', 'Coin Image', 'required');
        }
        $this->form_validation->set_rules('categoryid[]', 'Coin Category ', 'required');
        $this->form_validation->set_rules('coin_name', 'Coin Name ', 'required');
        $this->form_validation->set_rules('key_word', 'Key Words ', '');
        $this->form_validation->set_rules('design_lib', 'design_lib', '');
        $this->form_validation->set_rules('coin_order', 'coin_order', '');
        if ($this->form_validation->run() == FALSE) {
            $data['total_coin'] = $this->category_model->countcoins();
            $data['category'] = $this->category_model->getcategory();
            $data['main_content'] = 'admin/category/addcoin';
            $this->load->view('admin/include/template', $data);
        } else {
            $name = $this->uploadimages($_FILES, $path);
            $now = date("Y-m-d H:i:s");
            $coindetail = '';
            $category_id = '';
            foreach ($this->input->post('categoryid') as $catid):
                $category_id .= $catid . ',';
            endforeach;
            $pos = $this->input->post('coin_order');
            if (empty($pos)) {
                $pos = '9999';
            }
            $coindetail = array(
                'coin_name' => $this->input->post('coin_name'),
                //'coin_price' => $this->input->post('coin_price'),
                'keyword' => $this->input->post('key_word'),
                'coin_image' => $name,
                'status' => '1',
                'date' => $now,
                'category_id' => $category_id,
                'design_lib' => $this->input->post('design_lib'),
                'position' => $pos
            );
            $coin_id = $this->category_model->addcoin($coindetail);

            foreach ($this->input->post('categoryid') as $catid):
                $coin_relation = array(
                    'coin_id' => $coin_id,
                    'cat_id' => $catid,
                );
                $this->category_model->createrelation($coin_relation);
            endforeach;
            if ($coin_id) {
                $this->session->set_flashdata('success', 'Coin Inserted Succesfully');
                redirect('admin/category/addcoins');
            }
        }
    }

    public function managecoins() {
        // $data['category_name'] = $this->category_model->categoryname($catid);
        $data['coins'] = $this->category_model->selectcoins();
        // echo '<pre>';
        //print_r($data); die;
        $data['main_content'] = 'admin/category/managecoins';
        $data['category'] = $this->category_model->getcategory();
        $this->load->view('admin/include/template', $data);
    }

    public function deact_coin() {
        $id = $this->uri->segment(4);
        if ($this->category_model->deactive_coin($id)) {
            $this->session->set_flashdata('success', 'Coin status changed succesfully.');
            redirect('admin/category/managecoins');
        }
    }

    public function activate_coin() {
        $id = $this->uri->segment(4);
        if ($this->category_model->active_coin($id)) {
            $this->session->set_flashdata('success', 'Coin status changed succesfully.');
            redirect('admin/category/managecoins');
        }
    }

    public function delete_coin() {
        $id = $this->uri->segment(4);
        if ($this->category_model->delete_coin($id)) {
            $this->category_model->delete_coinrelation($id);
            $this->session->set_flashdata('success', 'Coin deleted succesfully.');
            redirect('admin/category/managecoins');
        }
    }

    public function edit_coin() {
        $id = $this->uri->segment(4);
        $data['total_coin'] = $this->category_model->countcoins();
        $data['coin_detail'] = $this->category_model->coindetail($id);
        $data['category'] = $this->category_model->getcategory();
        $data['main_content'] = 'admin/category/editcoin';
        $this->load->view('admin/include/template', $data);
    }

    public function updatecoin() {
//        if(count($_POST)>0){
//            print_r('<pre>');
//            print_r($_POST);
//            die;
//        }
        $now = date("Y-m-d H:i:s");
        $id = $this->input->post('coin_id');
        $path = './assets/uploads';
        $config['upload_path'] = './assets/uploads';
        $config['allowed_types'] = 'gif|jpg|png';
        $this->load->library('upload', $config);
        $this->form_validation->set_rules('categoryid[]', 'Coin Category ', 'required');
        $this->form_validation->set_rules('coin_name', 'Coin Name ', 'required');
        $this->form_validation->set_rules('coin_price', 'Coin Price ', '');
        if ($this->form_validation->run() == FALSE) {
            $data['coin_detail'] = $this->category_model->coindetail($id);
            $data['category'] = $this->category_model->getcategory();
            $data['main_content'] = 'admin/category/editcoin';
            $this->load->view('admin/include/template', $data);
        } else {
            $category_id = '';
            foreach ($this->input->post('categoryid') as $catid):
                $category_id .= $catid . ',';
            endforeach;
            $postion = $this->input->post('coin_order');
            if (empty($postion)) {
                $postion = '9999';
            }
            if (empty($_FILES['coin_image']['name'])) {
                $coindetail = array(
                    'category_id' => $category_id,
                    'coin_name' => $this->input->post('coin_name'),
                    //  'coin_price' => $this->input->post('coin_price'),
                    'keyword' => $this->input->post('key_word'),
                    'status' => $this->input->post('status'),
                    'position' => $postion,
                    'design_lib' => $this->input->post('design_lib'),
                    'date' => $now
                );
            } if (!empty($_FILES['coin_image']['name'])) {
                $name = $this->uploadimages($_FILES, $path);
                $coindetail = array(
                    'category_id' => $category_id,
                    'coin_name' => $this->input->post('coin_name'),
                    //  'coin_price' => $this->input->post('coin_price'),
                    'coin_image' => $name,
                    'status' => $this->input->post('status'),
                    'position' => $this->input->post('coin_order'),
                    'design_lib' => $this->input->post('design_lib'),
                    'date' => $now
                );
            }
            /*             * ***********Update coin relation table********************** */
            $this->category_model->delete_coinrelation($id);  // Delete coin
            foreach ($this->input->post('categoryid') as $catid):
                $coin_relation = array(
                    'coin_id' => $id,
                    'cat_id' => $catid,
                );
                $this->category_model->createrelation($coin_relation);
            endforeach;
            /*             * ***********Update coin relation table ends here ******************** */
            if ($this->category_model->updatecoin($id, $coindetail)) {
                $this->session->set_flashdata('success', 'Coin updated succesfully.');
                redirect('admin/category/managecoins');
            }
        }
    }

    public function managecoinprice() {
        $data['price_list'] = $this->category_model->coinprice();
        $data['american_eagle_price_list'] = $this->category_model->americaneaglecoinprice();
        $data['main_content'] = 'admin/category/coinpricing';
        $this->load->view('admin/include/template', $data);
    }

    public function updatecoinprice() {
        for ($i = 1; $i <= 11; $i++) {
            $price = array(
                'id' => $i,
                'price' => $this->input->post("range$i")
            );
            $this->category_model->updatecoinprice($i, $price);
        }
        $this->session->set_flashdata('success', 'JFK Coins pricing updated succesfully.');
        redirect('admin/category/managecoinprice');
    }
    
    public function updateamericancoinprice() {
        
        for ($i = 1; $i <= 11; $i++) {
            $price = array(
                'id' => $i,
                'price' => $this->input->post("range$i")
            );
            $this->category_model->updateamericancoinprice($i, $price);
        }
        $this->session->set_flashdata('success', 'American Eagle Coins pricing updated succesfully.');
        redirect('admin/category/managecoinprice');
    }
    
    public function managegiftboxprice() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $id = $this->input->post('id');
            $gift_box_array = array(
                'single_coin_box' => $this->input->post('single_coin_box'),
                'two_coin_box' => $this->input->post('two_coin_box'),
                'three_coin_box' => $this->input->post('three_coin_box'),
                'eight_coin_box' => $this->input->post('eight_coin_box'),
                'fifteen_coin_box' => $this->input->post('fifteen_coin_box')
            );
            if ($this->category_model->updategiftboxprice($id, $gift_box_array)) {
                $this->session->set_flashdata('success', 'Gift Box price updated succesfully.');
                redirect('admin/category/managegiftboxprice');
            }
        } else {
            $data['box_price'] = $this->category_model->giftprice();
            $data['main_content'] = 'admin/category/giftboxpricing';
            $this->load->view('admin/include/template', $data);
        }
    }

    function managegoldprice() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $id = $this->input->post('id');
            $gold_price = array(
                'gold_price' => $this->input->post('gold_plated')
            );
            if ($this->category_model->updategoldprice($id, $gold_price)) {
                $this->session->set_flashdata('success', 'Gold price updated succesfully.');
                redirect('admin/category/managegoldprice');
            }
        } else {
            $data['Gold_price'] = $this->category_model->goldprice();
            $data['main_content'] = 'admin/category/goldpricing';
            $this->load->view('admin/include/template', $data);
        }
    }

    public function addcoupon() {
        $this->form_validation->set_rules('c_code', 'Coupon Code', 'required|is_unique[coupons.code]');
        $this->form_validation->set_rules('disc_type', 'Discount Type', 'required');
        if ($this->input->post('disc_type') !== 'jfk') {
            $this->form_validation->set_rules('disc_value', 'Discount Value', 'required|numeric');
        }
        $this->form_validation->set_rules('max_uses', 'Maximum Uses', 'required|numeric');
        $this->form_validation->set_rules('unique_name', 'Unique Name', 'required');
        $this->form_validation->set_message('is_unique', 'The %s already exist please enter a new coupon code');
        if ($this->form_validation->run() == false) {
            $data['main_content'] = 'admin/coupon/addcoupon';
            $this->load->view('admin/include/template', $data);
        } else {
            $coupon_array = array(
                'code' => $this->input->post('c_code'),
                'discount_type' => $this->input->post('disc_type'),
                'discount_value' => $this->input->post('disc_value'),
                'max_usage' => $this->input->post('max_uses'),
                'multi_use' => $this->input->post('multi_use'),
                'unique_name' => $this->input->post('unique_name'),
                'date' => date("Y-m-d H:i:s")
            );
            $coupon_id = $this->category_model->addcoupon($coupon_array);
            $maxusage = $this->input->post('max_uses');
            if ($this->input->post('unique_name') == 'yes' && $maxusage > 0) {
                for ($i = 1; $i <= $maxusage; $i++) {
                    $number = $this->randomnumber();
                    $coupon_code = $this->input->post('c_code') . '-' . $number;
                    $coupon_detail = array(
                        'coupon_id' => $coupon_id,
                        'coupon_code' => $coupon_code,
                        'multi_use' => $this->input->post('multi_use'),
                        'u_status' => '1'
                    );
                    $unique = $this->category_model->unique_coupons($coupon_id,$coupon_code);
                    if ($unique == 0) {
                        $this->category_model->addcoupondetail($coupon_detail);
                    }
                }
            } if ($this->input->post('unique_name') == 'no' && $maxusage > 0) {
                $coupon_detail = array(
                    'coupon_id' => $coupon_id,
                    'coupon_code' => $this->input->post('c_code'),
                    'multi_use' => $this->input->post('multi_use'),
                    'u_status' => '1'
                );
                $this->category_model->addcoupondetail($coupon_detail);
            }if ($this->input->post('unique_name') == 'no' && $maxusage == 0) {
                $coupon_detail = array(
                    'coupon_id' => $coupon_id,
                    'coupon_code' => $this->input->post('c_code'),
                    'multi_use' => $this->input->post('multi_use'),
                    'coupon_type' => 'unlimited',
                    'u_status' => '1'
                );
                $this->category_model->addcoupondetail($coupon_detail);
            }

            $this->session->set_flashdata('success', 'Coupon Inserted succesfully.');
            redirect('admin/category/addcoupon');
        }
    }

    public function managecoupon() {
        $data['coupons'] = $this->category_model->couponlist();
        $data['main_content'] = 'admin/coupon/managecoupon';
        $this->load->view('admin/include/template', $data);
    }

    public function delete_coupon() {
        $id = $this->uri->segment(4);
        if ($this->category_model->delete_coupon($id)) {
            $this->category_model->delete_coupondetail($id);
            $this->session->set_flashdata('success', 'Coupon deleted succesfully.');
            redirect('admin/category/managecoupon');
        }
    }

    public function updatedistributed() {
        $id = $_POST['id'];
        $value = $_POST['value'];
        $distributed = array(
            'coupon_status' => $value
        );
        if ($this->category_model->update_distributed($id, $distributed)) {
            echo '1';
        }
    }

    public function edit_coupon() {
        $id = $this->uri->segment(4);
        $data['coupon_detail'] = $this->category_model->coupon_detail($id);
        $data['main_content'] = 'admin/coupon/editcoupon';
        $this->load->view('admin/include/template', $data);
    }

    public function coupondetail() {
        $id = $this->uri->segment(4);
        $data['parent_detail'] = $this->category_model->coupon_detail($id);
        $data['coupon_detail'] = $this->category_model->coupon_subdetail($id);
        $data['main_content'] = 'admin/coupon/coupon_detail';
        $this->load->view('admin/include/template', $data);
    }

    public function updatecoupon() {
        $id = $this->input->post('coupon_id');
        $this->form_validation->set_rules('c_code', 'Coupon Code', 'required');
        $this->form_validation->set_rules('disc_type', 'Discount Type', 'required');
        $this->form_validation->set_rules('disc_value', 'Discount Value', 'required|numeric');
        $this->form_validation->set_rules('max_uses', 'Maximum Uses', 'required|numeric');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required');
        $this->form_validation->set_rules('end_date', 'End Date', 'required');
        $this->form_validation->set_message('is_unique', 'The %s already exist please enter a new coupon code');
        if ($this->form_validation->run() == false) {
            $data['coupon_detail'] = $this->category_model->coupon_detail($id);
            $data['main_content'] = 'admin/coupon/editcoupon';
            $this->load->view('admin/include/template', $data);
        } else {
            $coupon_array = array(
                'code' => $this->input->post('c_code'),
                'discount_type' => $this->input->post('disc_type'),
                'discount_value' => $this->input->post('disc_value'),
                'max_usage' => $this->input->post('max_uses'),
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
                'date' => date("Y-m-d H:i:s")
            );
            $this->category_model->updatecoupon($id, $coupon_array);
            $this->session->set_flashdata('success', 'Coupon Updated succesfully.');
            redirect("admin/category/edit_coupon/$id");
        }
    }

    function randomnumber() {
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $res = "";
        for ($i = 1; $i < 5; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $res;
    }

    public function deact_coupon() {
        $id = $this->uri->segment(4);
        if ($this->category_model->deact_coupon($id)) {
            // $this->category_model->deact_subcoupon($id);
            $this->session->set_flashdata('success', 'Coupon deactivated succesfully.');
            redirect('admin/category/managecoupon');
        }
    }

    public function activate_coupon() {
        $id = $this->uri->segment(4);
        if ($this->category_model->act_coupon($id)) {
            //   $this->category_model->act_subcoupon($id);
            $this->session->set_flashdata('success', 'Coupon activated succesfully.');
            redirect('admin/category/managecoupon');
        }
    }

    function export_csv($id = null) {
        $id = $this->uri->segment(4);
        //echo $id;
        if ($id) {
            $name = $this->uri->segment(5);
            $filename = $name . '.csv';
            $delimiter = ",";
            $newline = "\r\n";
            $this->load->dbutil();
            $this->load->helper('download');
            $query = $this->db->query("SELECT * from coupon_detail where coupon_id = $id ");
            $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
            force_download("$filename", $data);
        }
    }

}

?>
