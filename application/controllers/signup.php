<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<?php

class Signup extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('date');
        $this->load->helper(array('form', 'url'));
        $this->load->model('signup_model');
        $this->load->library('email');
    }

    function __encrip_password($password) {
        return md5($password);
    }

    public function index() {
        $data['title'] = 'Sign up';
        $data['main_content'] = 'signup';
        $this->load->view('include/template', $data);
    }

    public function register() {
        $data = array(
            array('field' => 'fistname',
                'label' => 'First Name',
                'rules' => 'required'
            ),
            array('field' => 'lastname',
                'label' => 'Last Name',
                'rules' => 'required'
            ),
            array('field' => 'email',
                'label' => 'Emai ID',
                'rules' => 'required|is_unique[user.email_id]|valid_email'
            ),
            array('field' => 'password',
                'label' => 'Password',
                'rules' => 'required'
            ),
            array('field' => 'conpassword',
                'label' => 'Confirm Password',
                'rules' => 'required|matches[password]'
            )
        );
        $this->form_validation->set_rules($data);
        $this->form_validation->set_message('is_unique', '%s already exists, Kindly provide another email');
        if ($this->form_validation->run() == FALSE) {
             
            $data['title'] = 'Sign up';
            $data['main_content'] = 'signup';
            $this->load->view('include/template', $data);
        } else {
            $now = date("Y-m-d H:i:s");
            $data_to_save = array(
                'first_name' => $this->input->post('fistname'),
                'last_name' => $this->input->post('lastname'),
                'password' => $this->__encrip_password($this->input->post('password')),
                'email_id' => $this->input->post('email'),
                'date' => $now
            );
            $lastinsert = $this->signup_model->register($data_to_save);

            if ($lastinsert) {
                $name = $this->input->post('fistname');
                $email = $this->input->post('email');
                $this->register_mail($name, $email);
                $data = array(
                    'user' => $this->input->post('fistname'),
                    'last_name' => $this->input->post('lastname'),
                    'emailid' => $this->input->post('email'),
                    'user_id' => $this->db->insert_id(),
                    'is_logged_in' => true
                );
                $this->session->set_userdata($data);
                if ($this->session->userdata('checkoutpage')) {
                    redirect('checkout');
                } else {
                    
                    $data['title'] = "Registarion Complete!!";
                    $data['main_content'] = 'registrationcomplete';
                    $this->load->view('include/template', $data);
                }
            }
        }
    }

    public function register_mail($name, $email) {
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
                                        <img src="' . BASE_URL() . 'assets/img/logo.png" alt="Personalizedcoins.com" title="Personalizedcoins.com">
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
                                        <span style="font-size: 20px; line-height: 30px; color: #00B9EB;"> Order registered on <strong style="color: #00B9EB; text-decoration:none;">Personalizedcoins.com</strong> </span><br />
                                        <p>Dear  ' . $name . ',</p>
                                        <p>Your account on Personalizedcoins.com has been successfully created. </p>
                                        <p> For detail kindly login to you account on Personalizedcoins.com </p>    
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
        $this->email->subject('Account created on Personalizedcoins.com ');
        $this->email->message($message);
        $this->email->send();
    }
}

?>
