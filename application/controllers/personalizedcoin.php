<?php

Error_Reporting(E_ALL & ~E_NOTICE);
ob_start();

class Personalizedcoin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('cart');
        $this->load->helper('date');
        $this->load->library('session');
        $this->load->helper('cookie');
        $this->load->library('encrypt');
        $this->load->helper(array('form', 'url'));
        $this->load->model('personlised_model');
        $this->load->model('front_model');
        $this->load->model('category_model');
        $this->load->model('user_model');
        $this->load->helper('string');
    }
    
    public function logToFile($filename, $msg)
    {
    	// open file
    	$fd = fopen($filename, "a");
    	// append date/time to message
    	$str = "[" . date("Y/m/d h:i:s", time()) . "] " . $msg;
    	// write string
    	fwrite($fd, $str . "\n");
    	// close file
    	fclose($fd);
    }

    public function select_coin() {
        
        $data['title'] = "Choose Coin";
        $data['main_content'] = 'select_coin';
        $is_design_template = 'designtemplate';
        if(isset($this->uri->segments[3])) {
            
            $data['is_design_template'] = $is_design_template;
        }
        
        $this->load->view('include/template', $data);    
    }
    
    public function step1() {
        
        $coin_type = $this->uri->segments[3];
        $data['title'] = "Step1";
        $data['main_content'] = 'step1';
        $data['coin_type'] = $coin_type;
        
        if(isset($this->uri->segments[4]) && $this->uri->segments[4] == 'designtemplate' ) {
            header("Location: ".base_url()."personalizedcoin/step2/".$coin_type."/designtemplate");
        }

        $this->load->view('include/template', $data);
    }

    public function step2() {

        if (!empty($_FILES['upimg']['name'])) {
            $path = './assets/temp';
            $name = $this->uploadimages($_FILES, $path);
            // $data['img_name'] = $name;
            $imgname = base_url() . 'assets/temp/' . $name;
            $this->session->set_userdata('fbimg', $imgname);
        }
        $id = $this->session->userdata('templateid');
        if (!empty($id)) {
            $data['template_detail'] = $this->personlised_model->get_template($id);
            $templateimg = $data['template_detail'][0]['coin_image'];
            $templatename = $data['template_detail'][0]['coin_name'];
            $templateprice = $data['template_detail'][0]['coin_price'];
        } else {
            $newdata = array(
                'coin_name' => 'Personalized Coin'
            );
            $this->session->set_userdata($newdata);
        }

        $data['title'] = "Step 2";
        
        if ($this->uri->segment(3) == 'designtemplate') {
            if ($this->uri->segment(4) == 'step1') {
                $newdata = array(
                    'design_templatimg' => '',
                    'coin_name' => $templatename,
                    'coin_price' => $templateprice
                );
            } else {
                $newdata = array(
                    'design_templatimg' => $templateimg,
                    'coin_name' => $templatename,
                    'coin_price' => $templateprice
                );
            }
            $coin_type = $this->uri->segment(5);
            $data['category'] = $this->front_model->designcategory();
            $data['main_content'] = 'step2design';
        } else {
            $newdata = array(
                'templatimg' => $templateimg,
                'coin_name' => $templatename,
                'coin_price' => $templateprice
            );
            $data['category'] = $this->front_model->homecategorycoins();
            $data['main_content'] = 'step2';
            
            $coin_type = $this->uri->segments[3];
        }

        
        $data['coin_type'] = $coin_type;
        $this->session->set_userdata($newdata);
        $this->load->view('include/template', $data);
    }

    public function uploadimages($files, $folder) {
        $allfiles = "";
        $uploadefiles = $files;
        $this->load->helper('date');
        foreach ($uploadefiles as $file => $value) {
            $config['upload_path'] = $folder;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['encrypt_name'] = TRUE;
            $config['file_name'] = time().$_FILES['upimg']['name'];
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

    public function step3() {

        $coin_type = $this->uri->segments[3];
        if ($coin_type == '') $coin_type = 'kennedy';
        $data['coin_type'] = $coin_type;
        $data['title'] = "Step3";
        $data['box_price'] = $this->category_model->giftprice();
        $data['Gold_price'] = $this->category_model->goldprice();
        $data['main_content'] = 'step3';
        $this->load->view('include/template', $data);
    }

    public function addtocart() {
        
        $data['Gold_price'] = $this->category_model->goldprice();
        $gold_price = $data['Gold_price']->gold_price;
        $quantity = 0;
        if (isset($_POST['goldplated'])) {
            $gold_price = $_POST['coinquantity'] * $gold_price;
            $single_gold = $gold_price;
            $goldplating = 'yes';
        } else {
            $gold_price = 0;
            $single_gold = $gold_price;
            $goldplating = 'no';
        }
        // check Quantity start here
        foreach ($this->cart->contents() as $items):
            $quantity = $quantity + $items['qty'];
        endforeach;
        $coinname = preg_replace('/[^A-Za-z0-9\-]/', ' ', $this->session->userdata('coin_name'));
        if (empty($coinname)) {
            $coinname = 'Personalized Coin';
        }
        $quantity = $quantity + $_POST['coinquantity'];
        if ($quantity > '990') {
            $this->session->set_flashdata('erroe', 'Quantity should be less than 991.');
            redirect('personalizedcoin/step3/?qty=0');
        }
        
                
        $coin_type = $_POST['coin_type'];
        
        $quantity1 = $_POST['coinquantity'] * 1;
        foreach ($this->cart->contents() as $items):
            if  ($items['type_coin'] !=  $coin_type) continue;
            $qty =  $items['qty'];
            $quantity1 = $quantity1 + $qty;
        endforeach;
        
        if($coin_type == "eagle") {
             $coinprice = $this->personlised_model->american_eagle_price($quantity1);
        }else {
            $coinprice = $this->personlised_model->price($quantity1);  // Get price according to Quantity.
        }
        // Add coinbox items to session
         $data['box_price'] = $this->category_model->giftprice();
         
         if ($_POST['box_coin_type'] == 'American Eagle Coin Box') {
         	$coinbaox = array(
         			'eagle_coinbox1' => $this->session->userdata('eagle_coinbox1') + $_POST['single-coin-box'],
         			'eagle_price_box1' => $data['box_price']->single_coin_box,
         			'eagle_coinbox2' => $this->session->userdata('eagle_coinbox2') + $_POST['two-coin-box'],
         			'eagle_price_box2' => $data['box_price']->two_coin_box,
         			'eagle_coinbox3' => $this->session->userdata('eagle_coinbox3') + $_POST['three-coin-box'],
         			'eagle_price_box3' => $data['box_price']->three_coin_box,
         			'eagle_coinbox4' => $this->session->userdata('eagle_coinbox4') + $_POST['four-coin-box'],
         			'eagle_price_box4' => $data['box_price']->eight_coin_box,
         			'eagle_coinbox5' => $this->session->userdata('eagle_coinbox5') + $_POST['five-coin-box'],
         			'eagle_price_box5' => $data['box_price']->fifteen_coin_box);
         }else {
         	$coinbaox = array(
         			'jfk_coinbox1' => $this->session->userdata('jfk_coinbox1') + $_POST['single-coin-box'],
         			'jfk_price_box1' => $data['box_price']->single_coin_box,
         			'jfk_coinbox2' => $this->session->userdata('jfk_coinbox2') + $_POST['two-coin-box'],
         			'jfk_price_box2' => $data['box_price']->two_coin_box,
         			'jfk_coinbox3' => $this->session->userdata('jfk_coinbox3') + $_POST['three-coin-box'],
         			'jfk_price_box3' => $data['box_price']->three_coin_box,
         			'jfk_coinbox4' => $this->session->userdata('jfk_coinbox4') + $_POST['four-coin-box'],
         			'jfk_price_box4' => $data['box_price']->eight_coin_box,
         			'jfk_coinbox5' => $this->session->userdata('jfk_coinbox5') + $_POST['five-coin-box'],
         			'jfk_price_box5' => $data['box_price']->fifteen_coin_box);         	
         }

        $this->session->set_userdata($coinbaox);
        
        foreach ($this->cart->contents() as $item):  //Update pervious cart item according to price
            $id = $item['rowid'];
            $price = $item['price'];
            if ($item['type_coin'] == $coin_type) $price = $coinprice;
            $data = array(
                'rowid' => "$id",
                'qty' => $item['qty'],
                'price' => $price
            );
            $this->cart->update($data);
//print_r($data);
        endforeach;

        $rowid = time();
        $da = array(// Add new Item to cart.
            'id' => $rowid,
            'qty' => $_POST['coinquantity'],
            'price' => $coinprice,
            'eagle_coin_price' => $this->personlised_model->american_eagle_price(1),
            'name' => $coinname,
            'type_coin' => $coin_type,
            'options' => array('finalcoin' => $this->session->userdata('finalcoin'), 'Gold Plated' => $goldplating));
        $this->cart->insert($da);
        /*    Add Item to Database for Temp */
        $ip = $_SERVER['REMOTE_ADDR'];
        $pending_cart = array(
            'coin_image' => $this->session->userdata('finalcoin'),
            'item_id' => $rowid,
            'coin_name' => $coinname,
            'coin_price' => $coinprice,
            'gold' => $goldplating,
            'coin_qty' => $_POST['coinquantity'],
            'ip_address' => $ip,
            'user_id' => $this->session->userdata('user_id'),
            'type_coin' => $coin_type
        );
        $this->user_model->pendingcart($pending_cart);
        // Set coin Price for Previous items 
        $update_price = array(
            'coin_price' => $coinprice
        );
        $this->user_model->pendingcart_updateprice($update_price, $ip);
        /*   Add Item to Database for Temp end here */

        $data = array(
            'checkoutpage' => true
        );
        $this->session->set_userdata($data);
        //  echo '<pre>'; print_r($this->cart->contents()); die;
        // Secion to redirect user on checout page after login
        if ($quantity > 50) {
            redirect('personalizedcoin/shoppingcart/?qty=1');
        } else {
            redirect('personalizedcoin/shoppingcart');
        }
    }

    public function shoppingcart() {

        $data['title'] = "Shopping Cart";
        $data['box_price'] = $this->category_model->giftprice();
        $data['Gold_price'] = $this->category_model->goldprice();
        $data['main_content'] = 'cart';  
        $this->load->view('include/template', $data);
    }

}

?>
