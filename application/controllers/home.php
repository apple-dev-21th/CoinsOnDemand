<?php
ob_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {
   public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('front_model');
        $this->load->helper('cookie');
        $this->load->helper('date');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->model('user_model');
        $this->load->library('cart');
    }

    public function index() {
          $slug = $this->uri->segment(1);
          if($slug == 'faq'){
              redirect('faq');
          }else if($slug == 'contact-us'){
              redirect('contactus');
          } else if(empty ($slug)) {
            $session_items = array('templateid' => '','templatimg' => '','coin_price'=>'','coin_name'=>'');
            $this->session->unset_userdata($session_items);

            /* Update cart if customer return back */
           $ip= $_SERVER['REMOTE_ADDR'];
           $user_id = $this->session->userdata('user_id');
           if(empty($user_id)){
             //  $pending_cart = $this->user_model-> pending_cartitems_ip($ip);
           }else {
            $pending_cart = $this->user_model-> pending_cartitems($user_id);
           }
          // echo '<pre>';
           //print_r($pending_cart);
            $checkout = $this->session->userdata('checkoutpage');
            if(empty($checkout)){
                if(!empty($pending_cart)) {
            foreach ($pending_cart as $cart):
                $da = array(
                'id' => $cart['item_id'],
                'qty' => $cart['coin_qty'],
                'price' => $cart['coin_price'],
                'name' => $cart['coin_name'],
                'options' => array('finalcoin' => $cart['coin_image'], 'Gold Plated' => $cart['gold']));
            $this->cart->insert($da);
            endforeach;
            $data = array(
                'checkoutpage' => true
            );
            $this->session->set_userdata($data);
                }
            }
            /* Update cart ends here */
            $data['title']='Personalized Coins | Create Your Coin Today';
            $data['slider'] = $this->front_model->slider();
            $data['category'] =$this->front_model->category();
            $data['home'] =$this->front_model->boxes();
            $data['main_content'] = 'home';
            $this->load->view('include/template',$data);
            } else {
            $data['content']=$this->front_model->getpagedata($slug);
            //echo '<pre>'; print_r($data['content']);
            $data['title'] = $data['content']['0']['page_title'];
            $data['main_content'] = 'about';
            $this->load->view('include/template',$data);
            }
    }

}

?>
