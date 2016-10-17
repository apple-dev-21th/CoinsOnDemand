<?php

ob_start();

class Updatecart extends CI_Controller {
    
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

    public function __construct() {
        parent::__construct();
        $this->load->library('cart');
        $this->load->helper('date');
        $this->load->library('session');
        $this->load->helper('cookie');
        $this->load->library('encrypt');
        $this->load->helper(array('form', 'url'));
        $this->load->model('personlised_model');
        $this->load->model('category_model');
        $this->load->library('session');
        $this->load->model('user_model');
    }

    public function removeitem() {
        $ip = $_SERVER['REMOTE_ADDR'];
        $row_id = $_POST['id'];
        $id = $_POST['cart'];
        $coin_type = $_POST['coin_type'];
        $data = array(
            'rowid' => "$id",
            'qty' => 0
        );
        $this->cart->update($data);
        $quantity = 0;
        foreach ($this->cart->contents() as $items):
            if ($items['type_coin'] == $coin_type) {
                $quantity = $quantity + $items['qty'];
            }
        endforeach;
        if ($coin_type == 'eagle') {
            $coinprice = $this->personlised_model->american_eagle_price($quantity);
        }else {
            $coinprice = $this->personlised_model->price($quantity);    
        }
        

        foreach ($this->cart->contents() as $item):
            if ($items['type_coin'] != $coin_type) continue;
            $id = $item['rowid'];
            $data = array(
                'rowid' => "$id",
                'qty' => $item['qty'],
                'price' => "$coinprice"
            );
            $this->cart->update($data);


        // Update coin Price.
        // Remove Item from database
        endforeach;
        if ($quantity > 0) {
            $update_price = array(
                'coin_price' => $coinprice
            );
            $this->user_model->pendingcart_updateprice($update_price, $ip);
        }
        $this->user_model->pendingcart_deleteitem($row_id);

        $disc_amount = array(
            'discount_type' => '',
            'disc_amount' => '',
            'discount_value' => '',
            'coupon_code' => '',
            'coupon_id' => ''
        );
        $this->session->set_userdata($disc_amount);

        echo "1";
    }

    public function updateitem() {

        $disc_amount = array(
            'discount_type' => '',
            'disc_amount' => '',
            'discount_value' => '',
            'coupon_code' => '',
            'coupon_id' => ''
        );
        $this->session->set_userdata($disc_amount);

        $ip = $_SERVER['REMOTE_ADDR'];
        $id = $_POST['cart'];
        $quantity = $_POST['quantity'];
        $coin_type = $_POST['coin_type'];
        $row_id = $_POST['rowid'];
        $data = array(
            'rowid' => "$id",
            'qty' => $quantity
        );
        $this->cart->update($data);
        
        

        $quantity1 = 0;
        foreach ($this->cart->contents() as $items):
            if  ($items['type_coin'] !=  $coin_type) continue;
            
            $qty =  $items['qty'];
            if ($items['rowid'] == $row_id) $qty = $quantity;
            
            $quantity1 = $quantity1 + $qty;
        endforeach;

        if($coin_type == "eagle") {
             $coinprice = $this->personlised_model->american_eagle_price($quantity1);
        }else {
            $coinprice = $this->personlised_model->price($quantity1);  // Get price according to Quantity.
        }
        
        
        foreach ($this->cart->contents() as $item):
        
            if  ($item['type_coin'] !=  $coin_type) continue;
                                  
            $id = $item['rowid'];
            $qty =  $item['qty'];
            
            if ($id == $row_id) $qty = $quantity;
            
            $data = array(
                'rowid' => "$id",
                'qty' => $item['qty'],
                'price' => $coinprice
            );
            
            $this->cart->update($data);
            
        endforeach;

        // Update Item Quantity
        $update_qty = array(
            'coin_qty' => $_POST['quantity'],
        );
        $this->user_model->pendingcart_updateqty($update_qty, $row_id);
        // Update coin Price.
        $update_price = array(
            'coin_price' => $coinprice
        );
        $this->user_model->pendingcart_updateprice($update_price, $ip);
    }

    public function updatecoinbox() {
        $ip = $_SERVER['REMOTE_ADDR'];
        $coinbaox = array($_POST['session'] => $_POST['quantity']
        );
        $this->session->set_userdata($coinbaox);
        echo 1;
        exit;
    }

    public function removegiftbox() {
        $ip = $_SERVER['REMOTE_ADDR'];
        $coinbaox = array($_POST['sessionid'] => 0
        );
        $this->session->set_userdata($coinbaox);
        echo 1;
        exit;
    }

    public function addgiftbox() {
    	
        $ip = $_SERVER['REMOTE_ADDR'];
        if ($_POST['box_coin_type'] == 'American Eagle Coin Box') {
        	$coinbaox = array(
        			'eagle_coinbox1' => $this->session->userdata('eagle_coinbox1') + $_POST['single-coin-box'],
        			'eagle_coinbox2' => $this->session->userdata('eagle_coinbox2') + $_POST['two-coin-box'],
        			'eagle_coinbox3' => $this->session->userdata('eagle_coinbox3') + $_POST['three-coin-box'],
        			'eagle_coinbox4' => $this->session->userdata('eagle_coinbox4') + $_POST['four-coin-box'],
        			'eagle_coinbox5' => $this->session->userdata('eagle_coinbox5') + $_POST['five-coin-box']
        	);        	
        }else {
        	$coinbaox = array(
        			'jfk_coinbox1' => $this->session->userdata('jfk_coinbox1') + $_POST['single-coin-box'],
        			'jfk_coinbox2' => $this->session->userdata('jfk_coinbox2') + $_POST['two-coin-box'],
        			'jfk_coinbox3' => $this->session->userdata('jfk_coinbox3') + $_POST['three-coin-box'],
        			'jfk_coinbox4' => $this->session->userdata('jfk_coinbox4') + $_POST['four-coin-box'],
        			'jfk_coinbox5' => $this->session->userdata('jfk_coinbox5') + $_POST['five-coin-box']
        	);        	
        }

        $this->session->set_userdata($coinbaox);
        redirect('personalizedcoin/shoppingcart');
    }

    public function add_dsicount() {
        $totalprice = $_POST['total'];
        $coinprice = $this->category_model->discount_coupon($_POST['coupon_code']);
        $jfk_count = $_POST['jfk_count'];
        //    print_r($coinprice);        exit();
        // print_r($this->session->userdata);exit;
        $amt_dic = $this->session->userdata('disc_amount');
        if (empty($amt_dic) or $amt_dic = '0.00') {
            if (!empty($coinprice)) {
                if ($coinprice['0']['status'] == 1) {
                    if ($coinprice['0']['u_status'] == 1) {
                        if ($coinprice['0']['discount_type'] == '%') {
                            $discount = $this->cart->format_number($totalprice * $coinprice['0']['discount_value'] / 100);
                            $gtotal = $this->cart->format_number($totalprice - $discount);
                            $discount_type = '%';
                        } elseif ($coinprice['0']['discount_type'] == 'fixed')  {
                            $discount = $this->cart->format_number($coinprice['0']['discount_value']);
                            if ($totalprice > $coinprice['0']['discount_value']) {
                                $gtotal = $this->cart->format_number($totalprice - $coinprice['0']['discount_value']);
                            } else {
                                $gtotal = '0.00';
                            }
                            $discount_type = 'fixed';
                        }else {
                            if ($jfk_count == 0) {
                                echo 10;
                                exit;
                            }else {
                                $discount = $this->personlised_model->price($jfk_count);
                                if ($totalprice > $discount) {
                                    $gtotal = $this->cart->format_number($totalprice - $discount);
                                } else {
                                    $gtotal = '0.00';
                                }
                                $discount_type = 'jfk';

                                $coinprice['0']['discount_value'] = $discount;
                            }
                        }
                        $disc_amount = array(
                            'discount_type' => $discount_type,
                            'disc_amount' => $discount,
                            'discount_value' => $coinprice['0']['discount_value'],
                            'coupon_id' => $coinprice['0']['id'],
                            'coupon_code' => $_POST['coupon_code']
                        );
                        $this->session->set_userdata($disc_amount);
                        echo $discount . '&' . $gtotal;
                        //  redirect('personalizedcoin/shoppingcart');
                        exit();
                    } else {
                        echo 4; // Coupon already used.
                        exit();
                    }
                } else {
                    echo 1; //'Coupon inactive';
                    exit();
                }
            } else {
                echo 2; //'Invalid Coupon'    ;
                exit();
            }
        } else {
            echo 3;  // You have already used the coupon for this cart
            exit();
        }
        redirect('personalizedcoin/shoppingcart');
    }

    public function removediscount() {
        $disc_amount = array(
            'discount_type' => '',
            'disc_amount' => '',
            'discount_value' => '',
            'coupon_code' => '',
            'coupon_id' => ''
        );
        $this->session->set_userdata($disc_amount);
        redirect('personalizedcoin/shoppingcart');
    }

}

?>
