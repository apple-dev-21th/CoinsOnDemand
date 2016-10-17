<?php
ob_start();
class Review_order extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('cart');
        $this->load->helper('date');
        $this->load->library('session');
        $this->load->helper('cookie');
        $this->load->library('encrypt');
        $this->load->helper(array('form', 'url'));
        $this->load->model('user_model');
        $this->load->model('order_model');
        $this->load->model('category_model');
    }

    public function index() {
        if ($this->session->userdata('user')) {
            $data['Gold_price'] = $this->category_model->goldprice();
            $user_id = $this->session->userdata('user_id');
            $data['shipping'] = $this->user_model->shipingaddress($user_id);
            $data['address'] = $this->user_model->billingaddress($user_id);
            if(empty($data['address'])) {
            $this->session->set_flashdata('error', 'Kindly Update billing address.');
             redirect('checkout');
            }if(empty($data['shipping'])) {
            $this->session->set_flashdata('error', 'Kindly Update shipping address.');
              redirect('shipping');
            }else
            $this->saveorder();
            $data['title'] = 'Review Order';
            $user_id = $this->session->userdata('user_id');
            $data['main_content'] = 'review_order';
            $this->load->view('include/template', $data);
        } else {
            redirect('signin');
        }
    }

    public function saveorder() {

        $tax = '0.00';
        $shipping = '0.00';
        $subtotal = $this->session->userdata('sub_total');
        $discount = $this->session->userdata('disc_amount');
        $user_id = $this->session->userdata('user_id');
        $shipping_adr = $this->user_model->shipingaddress($user_id);
        $st_s = explode('-', $shipping_adr['0']['state']);
        $ctry_s = explode('-', $shipping_adr['0']['country']);
        if ($ctry_s['1'] == 'US' || $ctry_s['1'] == 'PR') {
            $shipping = '0.00';
        } elseif ($ctry_s['1'] == 'CA') {
            $shipping = '9.95';
        } else {
            $shipping = '24.95';
        }

        $jfk_count = 0;
        foreach ($this->cart->contents() as $items):
            if ($items['options']['Gold Plated'] == 'yes') {
                $jfk_count = $jfk_count + $items['qty'];
            } else {
                //2015.02.25 changed by frank
                if ($items['type_coin'] == 'eagle') {
                }else {
                    $jfk_count = $jfk_count + $items['qty'];
                }
            }
        endforeach;

        if (isset($st_s['1']) && $st_s['1'] == 'NY') {
            $tax = $subtotal * 8.625 / 100;

            if ($this->session->userdata('discount_type')) {
                if ($this->session->userdata('discount_type') == 'jfk') {
                    if ($jfk_count == 1) $tax = '0.00';
                }
            }
        }
        $total = $subtotal + $tax + $shipping - $discount;
        if($total > 0){
            $grandtotal = $total;
        }else {
            $grandtotal = '0.00';
        }
        $orderId = $this->session->userdata('order_id');
        $broswer = $this->getBrowser();
        $browser1 =  $broswer['name'].$broswer['version'] ;

        $data_to_save = array(
            'user_id' => $user_id,
            'total_paid' => $this->cart->format_number($grandtotal),
            'order_status' => 'Pending',
            'order_date' => date("Y-m-d H:i:s"),
            'tax' => $this->cart->format_number($tax),
            'discount' => $this->cart->format_number($discount),
            'checkout_status' => 'pending',
            'shipping_amount' => $shipping,
            'coupon_code' => $this->session->userdata("coupon_code"),
            'coupon_id' => $this->session->userdata("coupon_id"),
            'sub_total'=> $subtotal,
            'browser'=>$browser1
        );
        if (empty($orderId)) {
            $orderId = $this->order_model->add_order($data_to_save);
            $this->session->set_userdata('order_id', $orderId);
        } else {
            $this->order_model->updateorder_status($orderId, $data_to_save);   // Update Order If order already therein session
            $this->order_model->deleteorder_detail($orderId); // Remove order detail to update new
            $this->order_model->deletegiftbox_detail($orderId); // Remove giftbox to update new
        }
        $newdata = array(
                   'gtotal'  => $grandtotal,
                   'userId'     => $user_id,
                   'OrderId' => $orderId
               );
     $this->session->set_userdata($newdata);
        // Save order detail to database
        foreach ($this->cart->contents() as $items):
            if ($items['options']['Gold Plated'] == 'yes') {
                $cointype = '24KT Gold Plated Personalized Coin';
            } else {
                //2015.02.25 changed by frank
                if ($items['type_coin'] == 'eagle') {
                    $cointype = 'Silver Eagle';
                }else {
                    $cointype = 'Standard JFK Personalized Coin';
                }
            }
            $order_detail = array(
                'order_id' => $orderId,
                'coin_name' => $items['name'],
                'coin_type' => $cointype,
                'coin_quantity' => $items['qty'],
                'img_name' => $items['options']['finalcoin'],
                'date' => date("Y-m-d H:i:s"),
                'coin_cost' => $items['price'],
                'coin_selected' => $items['type_coin']
            );
            $this->order_model->order_detail_insert($order_detail);
        endforeach;
        // Save Gift box to database
        $data_giftbox = array(
            'order_id' => $orderId,
            'single_coin_box' => $this->session->userdata("eagle_coinbox1"),
            'two_coin_box' => $this->session->userdata("eagle_coinbox2"),
            'three_coin_box' => $this->session->userdata("eagle_coinbox3"),
            'eight_coin_box' => $this->session->userdata("eagle_coinbox4"),
            'fifteen_coin_box' => $this->session->userdata("eagle_coinbox5"),
        );
        $this->order_model->eagle_giftbox_insert($data_giftbox);
        
        $data_giftbox = array(
            'order_id' => $orderId,
            'single_coin_box' => $this->session->userdata("jfk_coinbox1"),
            'two_coin_box' => $this->session->userdata("jfk_coinbox2"),
            'three_coin_box' => $this->session->userdata("jfk_coinbox3"),
            'eight_coin_box' => $this->session->userdata("jfk_coinbox4"),
            'fifteen_coin_box' => $this->session->userdata("jfk_coinbox5"),
        );
        $this->order_model->giftbox_insert($data_giftbox);
    }

    // free order payment
    public function free_pay() {
        $length = 8;
        $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
        $randTransaction = "FREE".$randomString;
        $paymentdetail = array(
            'transaction_id' => $randTransaction,
            'payement_status' => 'approved',
            'payment_gross' => '0',
            'card_type' => '',
            'card_digits' => ''
        );
        $this->session->set_userdata($paymentdetail);
        redirect("checkout_complete/free");
    }

    public function authorizenet_pay() {
        $data = array(
            array('field' => 'card_type',
                'label' => 'Card Type',
                'rules' => 'required'
            ), array('field' => 'card_number',
                'label' => 'Card Number',
                'rules' => 'required'
            ), array('field' => 'exp_month',
                'label' => 'Expiary Month',
                'rules' => 'required'
            ), array('field' => 'exp_year',
                'label' => 'Expiary Year',
                'rules' => 'required'
            ), array('field' => 'cvv',
                'label' => 'Card CVV number',
                'rules' => 'required')
        );
        $this->form_validation->set_rules($data);
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Review Order';
            $user_id = $this->session->userdata('user_id');

            $data['shipping'] = $this->user_model->shipingaddress($user_id);
            $data['address'] = $this->user_model->billingaddress($user_id);
            $data['main_content'] = 'review_order';
            $this->load->view('include/template', $data);
        } else {
            define("AUTHORIZENET_SANDBOX", false);
            $root = $_SERVER['DOCUMENT_ROOT'];
            require_once $root . "/authorize/anet_php_sdk/AuthorizeNet.php";
          $transaction = new AuthorizeNetAIM('2rUg5L3xsPs', '6W6m358YYUjQUc9f');
        //    $transaction = new AuthorizeNetAIM('7Te95f85Xj', '6Zt6S9DQ4p9P67d5'); //Sandbox
            $transaction->amount = $this->input->post('amount');
            $transaction->card_num = $this->input->post('card_number');
            $transaction->exp_date = $this->input->post('exp_month') . '/' . $this->input->post('exp_year');
            $transaction->card_code = $this->input->post('cvv');

            $customer = (object) array();
            $customer->first_name = $this->session->userdata('user');
            $customer->last_name = $this->session->userdata('last_name');
            $customer->email = $this->session->userdata('emailid');
            $transaction->setFields($customer);

            $response = $transaction->authorizeAndCapture();
            //  echo '<pre>';  print_r($response); die;
            if ($response->approved == '1') {
                $paymentdetail = array(
                    'transaction_id' => $response->transaction_id,
                    'payement_status' => 'approved',
                    'payment_gross' => $response->amount,
                    'card_type' => $this->input->post('card_type'),
                    'card_digits' => substr($this->input->post('card_number'), -4)
                );
                $this->session->set_userdata($paymentdetail);
                redirect("checkout_complete/");
            } else {
                $error = $response->response_reason_text;
                $this->session->set_flashdata('error', $error);
                redirect("review_order");
                //$data['title'] = "Transaction Failed";
                //$data['main_content'] = 'transaction_failed';
                //$this->load->view('include/template', $data);
            }
        }
    }

    public function getcardtype() {
        $cc = $_POST['creditcard_number'];
        $type = $_POST['type'];
        $cardNumber = preg_replace('/\D/', '', $cc);
        $len = strlen($cardNumber);
        if (preg_match('/^4/', $cardNumber) >= 1) {
            $t = 'Visa';
        } else if (preg_match('/^5[1-5]/', $cardNumber) >= 1) {
            $t = 'Mastercard';
        } else if (preg_match('/^3[47]/', $cardNumber) >= 1) {
            $t = 'American Express';
        } else if (preg_match('/^3(?:0[0-5]|[68])/', $cardNumber) >= 1) {
            $t = 'Diners Club';
        } else if (preg_match('/^6(?:011|5)/', $cardNumber) >= 1) {
            $t = 'Discover';
        } else if (preg_match('/^(?:2131|1800|35\d{3})/', $cardNumber) >= 1) {
            $t = 'JCB';
        } else {
            $t = 'Invalid';
        }
        if ($t == $type) {
            echo 1;
        } else {
            echo 0;
        }
    }
    
    public function getBrowser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";
    $ub='';

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'IE';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $bname = 'Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $bname = 'Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $bname = 'Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$u_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }else{
      $bname =  $u_agent;
      $ub = $u_agent;
    }
   
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
   
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
          @$version= $matches['version'][0];
        }
        else {
          @$version= $matches['version'][1];
        }
    }
    else {
        @$version= $matches['version'][0];
    }
   
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
   
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}

}

?>