<?php
ob_start();
class Personlisedcoin extends CI_Controller {

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
    }

    public function step1() {
        $data['title'] = "Step1";
        $data['main_content'] = 'step1';
        $this->load->view('include/template', $data);
    }

    public function step2() {
        if (!empty($_FILES['upimg']['name'])) {
            $path = './assets/temp';
            $name = $this->uploadimages($_FILES, $path);
            // $data['img_name'] = $name;
            $imgname = base_url() . 'assets/temp/' . $name;
            ?>
            <script>
                setCookie("fbimg", '<?php echo $imgname; ?>', 1);
            </script>
            <?php
        }
        $id = $this->session->userdata('templateid');
        if(!empty($id)) {
        $data['template_detail'] = $this->personlised_model->get_template($id);
        $templateimg = $data['template_detail'][0]['coin_image'];
        $templatename = $data['template_detail'][0]['coin_name'];
         $newdata = array(
            'templatimg' => $templateimg,
             'coin_name' => $templatename
        );
        }else {
             $newdata = array(
             'coin_name' => 'Personalized Coin'
        );
        }
        $this->session->set_userdata($newdata);
        
        $data['title'] = "Step 2";
        $data['main_content'] = 'step2';
        $data['category'] =$this->front_model->category();
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
        
        $data['title'] = "Step3";
        $data['main_content'] = 'step3';
        $this->load->view('include/template', $data);
    }

    public function addtocart() {
       $coinname= $this->session->userdata('coin_name');
        $quantity = $_POST['coinquantity'];
        $coinprice =  10;
        if (isset($_POST['coinbox'])) {
            $boxquantity = $_POST['metalboxquantity'];
            $boxprice = $boxquantity * 3.95;
            $singleboxprice=3.95;
        }
        if (isset($boxprice) && $boxprice != '') {
            $da = array(
                'id'=>time(),
                'qty' => $quantity,
                'price' => $coinprice,
                'name' =>  $coinname ,
                'options' => array('Metal Box' => 'Yes', 'Metal Box Quantity' => $boxquantity, 'Metal Box Price' => $singleboxprice,'Metal Box total Price' => $boxprice,'finalcoin' => $this->session->userdata('finalcoin')));
    
            $this->cart->insert($da);     
        }else{
           $da = array(
            'id'=>time(),
            'qty' => $quantity,
            'price' => $coinprice,
            'name' =>  $coinname,
             'options' => array('finalcoin' => $this->session->userdata('finalcoin'))
            ); 
      
           $this->cart->insert($da); 
        }
//     echo $coinname;   

   // echo '<pre>'; print_r($da); die;
    $data = array(
                     'checkoutpage' => true
                );
                $this->session->set_userdata($data);
				
				 // Secion to redirect user on checout page after login
  redirect('personlisedcoin/shoppingcart'); 
   }
public function shoppingcart(){
    
    $data['title'] = "Shopping Cart";
     $data['main_content'] = 'cart';
     $this->load->view('include/template', $data);
}

}
?>
<script>
    function setCookie(cname, cvalue, exdays)
    {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toGMTString();
        document.cookie = cname + "=" + cvalue + "; " + expires + ';domain=<?php echo  COOKIE_URL; ?>;path=/';
    }
</script>