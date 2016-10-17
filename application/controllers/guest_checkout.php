<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<?php

class Guest_checkout extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('date');
        $this->load->helper(array('form', 'url'));
        $this->load->model('signup_model');
        $this->load->model('user_model');
        $this->load->library('email');
    }
    public function index() {
        $data['title'] = "Guest Checkout";
        $data['states'] = $this->user_model->getstatesbycountry('United States-US');
        $data['country'] = $this->user_model->getcountries();
        $data['main_content'] = 'gueststep1';
        $this->load->view('include/template', $data);
    }

    public function register() {
        if ($this->input->post('guest_shippingadrs') == 'on') {
            $data = array(
                array('field' => 'fname',
                    'label' => 'First name for Shipping address ',
                    'rules' => 'required'
                ),
                array('field' => 'lname',
                    'label' => 'Last name for Shipping address ',
                    'rules' => 'required'
                ),
                array('field' => 'address1',
                    'label' => 'Address1  for Shipping address ',
                    'rules' => 'required'
                ),
                array('field' => 'address2',
                    'label' => 'Address2  for Shipping address ',
                    'rules' => ''
                ),
                array('field' => 'city',
                    'label' => 'City  for Shipping address ',
                    'rules' => 'required'
                ),
                array('field' => 'state_shipping',
                    'label' => 'State  for Shipping address ',
                    'rules' => 'required'
                ),
                array('field' => 'zip',
                    'label' => 'Zip Code  for Shipping address ',
                    'rules' => 'required'
                ),
                array('field' => 'phone',
                    'label' => 'Phone number for Shipping address ',
                    'rules' => 'required'
                ),
                array('field' => 'country_shipping',
                    'label' => 'Country for Shipping address ',
                    'rules' => 'required'
            ),array('field' => 'guest_fname',
                    'label' => 'First Name',
                    'rules' => 'required'
                ),
                array('field' => 'guest_lname',
                    'label' => 'Last Name',
                    'rules' => 'required'
                ),
                array('field' => 'guest_email',
                    'label' => 'Emai ID',
                    'rules' => 'required|valid_email'
                ),
                array('field' => 'guest_phone',
                    'label' => 'Phone',
                    'rules' => 'required'
                ),
                array('field' => 'guest_adrs1',
                    'label' => 'Address1 ',
                    'rules' => 'required'
                ),
                array('field' => 'guest_adrs2',
                    'label' => 'Address2 ',
                    'rules' => ''
                ),
                array('field' => 'guest_company',
                    'label' => 'Company Name ',
                    'rules' => ''
                ),
                array('field' => 'guest_city',
                    'label' => 'City ',
                    'rules' => 'required'
                ),
                array('field' => 'guest_postcode',
                    'label' => 'Postal Code ',
                    'rules' => 'required'
                ),
                array('field' => 'country',
                    'label' => 'Country ',
                    'rules' => 'required'
                ),
                array('field' => 'state',
                    'label' => 'State ',
                    'rules' => 'required'
                ));
        } else {
            $data = array(
                array('field' => 'guest_fname',
                    'label' => 'First Name',
                    'rules' => 'required'
                ),
                array('field' => 'guest_lname',
                    'label' => 'Last Name',
                    'rules' => 'required'
                ),
                array('field' => 'guest_email',
                    'label' => 'Emai ID',
                    'rules' => 'required|valid_email'
                ),
                array('field' => 'guest_phone',
                    'label' => 'Phone',
                    'rules' => 'required'
                ),
                array('field' => 'guest_adrs1',
                    'label' => 'Address1 ',
                    'rules' => 'required'
                ),
                array('field' => 'guest_adrs2',
                    'label' => 'Address2 ',
                    'rules' => ''
                ),
                array('field' => 'guest_company',
                    'label' => 'Company Name ',
                    'rules' => ''
                ),
                array('field' => 'guest_city',
                    'label' => 'City ',
                    'rules' => 'required'
                ),
                array('field' => 'guest_postcode',
                    'label' => 'Postal Code ',
                    'rules' => 'required'
                ),
                array('field' => 'country',
                    'label' => 'Country ',
                    'rules' => 'required'
                ),
                array('field' => 'state',
                    'label' => 'State ',
                    'rules' => 'required'
                )
            );
        }
        $this->form_validation->set_rules($data);
        if ($this->form_validation->run() == FALSE) {
            if ($this->input->post('guest_shippingadrs') == 'on') {
                $data['guest_shipping'] = "1";
            }
            $data['title'] = "Guest Checkout";
            $data['states'] = $this->user_model->getstatesbycountry('United States-US');
            $data['country'] = $this->user_model->getcountries();
            $data['main_content'] = 'gueststep1';
            $this->load->view('include/template', $data);
        } else {
            $now = date("Y-m-d H:i:s");
            $password = time();
            $name= $this->input->post('guest_fname');
            $email = $this->input->post('guest_email');
            $data_to_save = array(
                'first_name' => $this->input->post('guest_fname'),
                'last_name' => $this->input->post('guest_lname'),
                'email_id' => $this->input->post('guest_email'),
                'user_type' =>'guest',
                'date' => $now
            );
            $lastinsert = $this->signup_model->register($data_to_save);
            // Mail to Guest User with User name and password.
            //$this->sendmailtoguest($password,$name,$email);         
            // Guest Billing address updatoion
            if ($lastinsert) {
                $billing_address = array(
                    'user_id' => $lastinsert,
                    'address' => $this->input->post('guest_adrs1') . ' ' . $this->input->post('guest_adrs2'),
                    'phone' => $this->input->post('guest_phone'),
                    'post_code' => $this->input->post('guest_postcode'),
                    'city' => $this->input->post('guest_city'),
                    'state' => $this->input->post('state'),
                    'country' => $this->input->post('country'),
                    'date' => $now
                );
                $this->user_model->add_address($billing_address);
                // Guest Shipping address updation. 
                if ($this->input->post('guest_shippingadrs') == 'on') {
                    $shipping_address = array(
                        'user_id' => $lastinsert,
                        'fname' => $this->input->post('fname'),
                        'lname' => $this->input->post('lname'),
                        'address' => $this->input->post('address1'),
                        'address2' => $this->input->post('address2'),
                        'phone' => $this->input->post('phone'),
                        'zip' => $this->input->post('zip'),
                        'city' => $this->input->post('city'),
                        'state' => $this->input->post('state_shipping'),
                        'country' => $this->input->post('country_shipping'),
                        'date' => $now
                    );
                } else {
                    $shipping_address = array(
                        'user_id' => $lastinsert,
                        'fname' => $this->input->post('guest_fname'),
                        'lname' => $this->input->post('guest_lname'),
                        'address' => $this->input->post('guest_adrs1'),
                        'address2' => $this->input->post('guest_adrs2'),
                        'phone' => $this->input->post('guest_phone'),
                        'zip' => $this->input->post('guest_postcode'),
                        'city' => $this->input->post('guest_city'),
                        'state' => $this->input->post('state'),
                        'country' => $this->input->post('country'),
                        'date' => $now
                    );
                }
                $this->user_model->add_shipping($shipping_address);

                $data = array(
                    'user' => $this->input->post('guest_fname'),
                    'last_name' => $this->input->post('guest_lname'),
                    'emailid' => $this->input->post('guest_email'),
                    'user_type'=>'guest',
                    'user_id' => $lastinsert,
                    'is_logged_in' => true
                );
                $this->session->set_userdata($data);
                redirect('review_order');
            }
        }
    }
    function __encrip_password($password) {
        return md5($password);
    }
    public function sendmailtoguest($password,$name,$email) {
        $this->email->set_mailtype("html");
        $message = '<body bgcolor="#ffffff" text="#979288" style="padding:0; margin:0;">
   <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
    <style type="text/css">
    </style>
    <div style="background: #ffffff; color:#979288; font-family: "Open Sans", sans-serif;" align="center">
        <table style=" color: #979288; font-size: 15px; line-height: 23px; width: 650px;" border="0" cellspacing="0" cellpadding="0" align="center">
            <tbody>
                <tr>
                    <td style="font-size: 0px; line-height: 0px;" width="650" height="5" bgcolor="#0088CC"></td>
                </tr>
                <tr>
                    <td style="font-size: 0px; line-height: 0px; border-bottom: 1px solid #fffffffff;" width="650" height="5" bgcolor="#DA4F49"></td>
                </tr>
                <tr>
                    <td width="650" height="150" align="center" valign="middle" style="background:rgba(233, 233, 233, 0.9);"><table style="width: 575px;" border="0" cellspacing="0" cellpadding="0" align="center">
                            <tbody>
                                <tr>
                                    <td style="font-family: "Open Sans", sans-serif; color: #3b3b3b; font-size: 40px; text-align: left; line-height: 45px;">
                                        <img src="'.BASE_URL().'assets/img/logo.png" width="150" alt="Personalizedcoins.com" title="Personalizedcoins.com">
                                    </td>
                                </tr>
                            </tbody>
                        </table></td>
                </tr>
                <tr>
                    <td width="650" align="center" valign="middle" bgcolor="#ffffff"><table style="font-family: "Open Sans", sans-serif; color: #979288; font-size: 15px; text-align: left; line-height: 23px; width: 575px;" border="0" cellspacing="0" cellpadding="0" align="center">
                            <tbody>
                                <tr>
                                    <td><br />
                                        <span style="font-size: 20px; line-height: 30px; color: #00B9EB;"> Account Registration on <strong style="color: #00B9EB; text-decoration:none;">Personalizedcoins.com</strong> </span><br />
                                        <p>Dear  '.$name.',</p>
                                        <p>Your account on Personalizedcoins.com has been successfully created. </p>
                                        <p> User Name for your a/c is your email id and password is <strong> '.$password.'</strong></p>
                                            
                                        <p>From, 
                                        </p>
                                        <p><b>Admin</b></p>
                                        <p><b>Personalizedcoins.com</b></p>
                                        <br />
                                        <br /></td>
                                </tr>
                            </tbody>
                        </table></td>
                </tr> 
                <tr>
                    <td style="font-size: 0px; line-height: 0px;" width="650" height="5" bgcolor="#0088CC"></td>
                </tr>
                <tr>
                    <td style="font-size: 0px; line-height: 0px;" width="650" height="20" bgcolor="#00B9EB"></td>
                </tr>
            </tbody>
        </table>
        <br>
        <br>
    </div>
</body>';
        $this->email->from('info@personalizedcoins.com', 'admin');
        $this->email->to($email);
        $this->email->subject('Guest Account created with Personalizedcoins.com ');
        $this->email->message($message);
        $this->email->send();
    }
    
    public function getstates() {
    
        $states = $this->user_model->getstatesbycountry($_POST['regionid']);
        if(!empty($states)) {
        $data = '<select  required class="form-control shop_select wdth_100" name="state"><option value="">Select state</option>';
        foreach ($states as $state) :
            $data .= '<option value="' . $state['name'].'-'.$state['iso'].'"> ' . $state['name'] . '</option>';
        endforeach;
        $data .= '</select>';
        }else {
            $data ='<input type="text" name="state" value="" class="form-control contact_text" id="inputEmail3">';
        }
        echo $data;
    }
    public function getstates_guest_shipping() {
        $states = $this->user_model->getstatesbycountry($_POST['regionid']);
        if(!empty($states)) {
        $data = '<select  required class="form-control shop_select wdth_100" name="state_shipping"><option value="">Select state</option>';
        foreach ($states as $state) :
            $data .= '<option value="' . $state['name'].'-'.$state['iso'].'"> ' . $state['name'] . '</option>';
        endforeach;
        $data .= '</select>';
        }else {
            $data ='<input type="text" name="state_shipping" value="" class="form-control contact_text" id="inputEmail3">';
        }
        echo $data;
        
    }
}
?>