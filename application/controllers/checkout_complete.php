<?php
ob_start();
class Checkout_complete extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('cart');
        $this->load->helper('date');
        $this->load->library('session');
        $this->load->helper('cookie');
        $this->load->library('encrypt');
        $this->load->helper(array('form', 'url'));
        $this->load->model('order_model');
        $this->load->model('personlised_model');
        $this->load->model('category_model');
        $this->load->model('user_model');
        $this->load->library('email');
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

    public function redirect(){
        $data['title'] = "Wait";
        $data['main_content'] = 'wait';
        $this->load->view('include/template', $data);
    }

    public function index1() { // For Paypal
        $order_id= $_GET['OrderId'];
        $update_order = array(
              'transaction_id' => $_REQUEST['txn_id'],
              'transaction_type'=> 'PayPal',
              'payer_id' => $_REQUEST['payer_email'],
              'checkout_status' =>'completed'
        );
        $this->order_model->updateorder_status($order_id,$update_order);
        $this->complete_order($order_id);
    }
    public function index() { // For Authorize.net
        $order_id   = $this->session->userdata('order_id');
        $transaction_id = $this->session->userdata('transaction_id');
         $update_order = array(
              'transaction_id' => $transaction_id,
             'card_digit'=> $this->session->userdata('card_digits'),
             'card_type'=> $this->session->userdata('card_type'),
             'transaction_type'=> 'Authorize.net',
              'checkout_status' =>'completed'
        );
        $this->order_model->updateorder_status($order_id,$update_order);
        $this->complete_order($order_id);
    }



    public function free() { // For free payment
        $order_id   = $this->session->userdata('order_id');
        $transaction_id = $this->session->userdata('transaction_id');
         $update_order = array(
             'transaction_id' => $transaction_id,
             'card_digit'=> '',
             'card_type'=> '',
             'transaction_type'=> 'Free',
             'checkout_status' =>'completed'
        );
        $this->order_model->updateorder_status($order_id,$update_order);
        $this->complete_order($order_id);
    }
    public function success() {
       $amt= $this->cart->format_number($this->session->userdata('gtotal'));
       $user = $this->session->userdata('userId');
       $Order = $this->session->userdata('OrderId');
$a ='<img src="https://shareasale.com/sale.cfm?amount='.$amt.'&tracking='.$Order.'&transtype=sale&merchantID=55310" width="1" height="1" >';
        $this->cart->destroy();
        $this->session->sess_destroy();
        $data['title'] = "Checkout Complete";
        $data['img'] = $a;
        $data['main_content'] = 'checkout_complete';
        $this->load->view('include/template', $data);
    }
    public function complete_order($order_id =NULL) {
        $detal = $this->order_model->getOrder_detail($order_id);
        $order_detail = $this->order_model->getCoins_detail($order_id);
        $giftBox_detail = $this->order_model->getgiftbox_detail($order_id);
        $eagle_giftBox_detail = $this->order_model->geteaglegiftbox_detail($order_id);   
        $data['box_price'] = $this->category_model->giftprice();
        $data['gold_price'] = $this->category_model->goldprice();
        $gold_price= $data['gold_price']->gold_price;
        $eagle_coin_price = $this->personlised_model->american_eagle_price(1);
        $coinbox = array(
            'coinbox1' => $giftBox_detail['0']['single_coin_box'],
            'price_box1' => $data['box_price']->single_coin_box,
            'coinbox2' => $giftBox_detail['0']['two_coin_box'],
            'price_box2' => $data['box_price']->two_coin_box,
            'coinbox3' => $giftBox_detail['0']['three_coin_box'],
            'price_box3' => $data['box_price']->three_coin_box,
            'coinbox4' => $giftBox_detail['0']['eight_coin_box'],
            'price_box4' => $data['box_price']->eight_coin_box,
            'coinbox5' => $giftBox_detail['0']['fifteen_coin_box'],
            'price_box5' => $data['box_price']->fifteen_coin_box);
        $eaglecoinbox = array(
            'eagle_coinbox1' => $eagle_giftBox_detail['0']['single_coin_box'],
            'eagle_coinbox2' => $eagle_giftBox_detail['0']['two_coin_box'],
            'eagle_coinbox3' => $eagle_giftBox_detail['0']['three_coin_box'],
            'eagle_coinbox4' => $eagle_giftBox_detail['0']['eight_coin_box'],
            'eagle_coinbox5' => $eagle_giftBox_detail['0']['fifteen_coin_box']);
        $this->session->set_userdata($coinbox);  // Save Gift box to session
        $this->session->set_userdata($eaglecoinbox);  // Save Gift box to session   
        $root = "/home2/ab87757/public_html/";
        $img1 = '';  // Combine all keneddy coins to one array
        $img2 = '';  // Combine all eagle coins to one array
        foreach ($order_detail as $items):
            $coin = $items['img_name'];
            $lastpostion = strripos($coin, '/') + 1;
            $img = trim(substr($coin, $lastpostion));
            $coin_img = $root . "/coins/" . $img;
            for ($i = 1; $i <= $items['coin_quantity']; $i++) {
                
                if($items['coin_selected'] == 'eagle') { 
                    $img2 [].= $coin_img;
                }else {
                    $img1 [].= $coin_img;
                }
            }
        endforeach;
        
        $totalcoins = count($img1);
        $totaleaglecoins = count($img2);
        $gtotoal = $detal['0']['total_paid'];
        $tax= $detal['0']['tax'];
        $shipping = $detal['0']['shipping_amount'];
        $discount = $detal['0']['discount'];
        $subtotal= $detal['0']['sub_total'];
        $transactionid = $detal['0']['transaction_id'];
        $user_id = $detal['0']['user_id'];
        $now = date('m/d/Y g:i a', strtotime($detal['0']['order_date']));  ;
        $data['userdetail'] = $this->user_model->user_profile($user_id);
        $data['shipping'] = $this->user_model->shipingaddress($user_id);
        $data['Billing'] = $this->user_model->billingaddress($user_id);
        $name = $data['userdetail']['0']['first_name'].' '.$data['userdetail']['0']['last_name'];
        $emailto = $data['userdetail']['0']['email_id'];
        $state_shipping = explode('-', $data['shipping']['0']['state']);
        $ctry_shipping = explode('-', $data['shipping']['0']['country']);
        $state_billing = explode('-', $data['Billing']['0']['state']);
        $ctry_billing = explode('-', $data['Billing']['0']['country']);
        $shipping_date = date('Y-m-d', strtotime('+5 days'));
          $newdata = array(
                   'gtotal'  => $gtotoal,
                   'userId'     => $user_id,
                   'OrderId' => $order_id
               );
        $this->session->set_userdata($newdata);
        /*         * ************************  PDF generate start here  ******************************** */
        $html = '';
        $root = "/home2/ab87757/public_html/";
        require_once $root."application/libraries/tcpdf/tcpdf.php";
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(300.23, 420.12), true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('PNF');
        $pdf->SetTitle('Personalizedcoin');
        $pdf->SetSubject('PNF Dev');
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->AddPage();
        $pdf->SetMargins(5.5, 10.9, -1, true);
        $email = '';
        /* ========================== HTML for PDF fist page ================== */
        $html .= '<table style="width:100%; margin-top: 15;">
  <tr style="height:150px;color:#000;border-bottom:4px solid #FC3;">
    <td colspan="2"><table cellpadding="10" cellspacing="10" >
        <tr>
          <td style="padding:20px;" width="50%"><img src="' . $root . '/assets/img/pdflogo.png" /></td>
          <td style="padding:20px;text-align:right;font-size:20px;"  width="50%">eCoins<br />
            14 Maple Place<br />
             Freeport, NY 11520</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td colspan="2"><div style="border-top:4px solid #FC3;height:0px;"></div></td>
  </tr>
  <tr>
    <td colspan="2" width="270px" style="text-align:center;" ><table style="border:1px solid #333333; " cellpadding="10">
        <tr>
          <td style="font-size:20px;color:#F07822;text-transform:uppercase;"> Purchase Order</td>
        </tr>
      </table>
      <table style="border:1px solid #333333; width:100%;margin-top:-1px;" cellpadding="10">
        <tr>
          <td style="font-size:18px;color:#000;">' . $order_id . ' </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td colspan="2"></td>
  </tr>
  <tr width="1000px">
    <td width="500px" ><table style="border:1px solid #333333;" cellpadding="10">
        <tr>
          <td style="font-size:20px;color:#F07822;text-transform:uppercase;">Billing Information</td>
        </tr>
      </table>
      <table style="border:1px solid #333333;margin-top:-1px;" cellpadding="10">
        <tr>
          <td style="font-size:18px;color:#000;"><span style="font-weight:bold;margin-right:20px;">Name :</span> ' . ucfirst($data['userdetail']['0']['first_name']) . ' ' . ucfirst($data['userdetail']['0']['last_name']) . '<br />
            <span style="font-weight:bold;margin-right:20px;">Address :</span> ' . ucfirst($data['Billing']['0']['address']) . '<br />
            <span style="font-weight:bold;margin-right:20px;">City :</span> ' . ucfirst($data['Billing']['0']['city']) . '<br />
            <span style="font-weight:bold;margin-right:20px;">State :</span> ' . $state_billing['0'] . '<br />
                <span style="font-weight:bold;margin-right:20px;">Country :</span> ' . $ctry_billing['0'] . '<br />
            <span style="font-weight:bold;margin-right:20px;">Zip Code :</span> ' . $data['Billing']['0']['post_code'] . '<br> <span style="font-weight:bold;margin-right:20px;">Phone :</span> ' . $data['Billing']['0']['phone'] . '<br /><span style="font-weight:bold;margin-right:20px;">Email :</span> ' . $data['userdetail']['0']['email_id'] . '</td>
        </tr>
      </table></td>
    <td width="500px"><table style="border:1px solid #333333;" cellpadding="10">
        <tr>
          <td style="font-size:20px;color:#F07822;text-transform:uppercase;">Shipping Information</td>
        </tr>
      </table>
      <table style="border:1px solid #333333;margin-top:-1px;" cellpadding="10">
        <tr>
          <td style="font-size:18px;color:#000;"><span style="font-weight:bold;margin-right:20px;">Name :</span> ' . ucfirst($data['shipping']['0']['fname']) . ' ' . ucfirst($data['shipping']['0']['lname']) . '<br />
            <span style="font-weight:bold;margin-right:20px;">Address :</span>' . ucfirst($data['shipping']['0']['address']) . ' ' . ucfirst($data['shipping']['0']['address2']) . '<br />
            <span style="font-weight:bold;margin-right:20px;">City :</span>' . ucfirst($data['shipping']['0']['city']) . '<br />
            <span style="font-weight:bold;margin-right:20px;">State :</span>' . $state_shipping['0'] . '<br />
                 <span style="font-weight:bold;margin-right:20px;">Country :</span>' . $ctry_shipping['0'] . '<br />
            <span style="font-weight:bold;margin-right:20px;">Zip Code :</span>' . $data['shipping']['0']['zip'] . '<br><span style="font-weight:bold;margin-right:20px;">Phone:</span>' . $data['shipping']['0']['phone'] . '<br />
           </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td colspan="2"></td>
  </tr>
  <tr>
    <td colspan="2" width="1000px" ><table style="border:1px solid #333333; " cellpadding="10">
        <tr>
          <td style="font-size:20px;color:#F07822;text-transform:uppercase;"> Payment Details</td>
        </tr>
      </table>
      <table style="border:1px solid #333333; width:100%;margin-top:-1px;" cellpadding="10">
        <tr>
          <td style="font-size:18px;color:#000;"><span style="font-weight:bold;margin-right:20px;">Transaction Id :</span>' . $transactionid . ' <br />
            <span style="font-weight:bold;margin-right:20px;">Amount Paid :</span> $' . number_format($gtotoal, 2) . '<br />
            <span style="font-weight:bold;margin-right:20px;">Shipping Charges :</span> $' . number_format($shipping, 2) . '<br />
            <span style="font-weight:bold;margin-right:20px;">Payment Date :</span>' . $now . '</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td colspan="2"></td>
  </tr>
  <tr>
    <td width="1000px" colspan="2"><table style="border:1px solid #333333; width:100%;" cellpadding="10">
        <tr>
          <td style="font-size:20px;color:#F07822;text-transform:uppercase;"> Coin Details</td>
        </tr>
      </table>
      <table cellpadding="10" style="text-align:center;border:1px solid #626200;margin-top:-1px;" width="100%;">
        <tr>
          <td width="28%;" style="text-transform:uppercase;font-weight:bold;">Description</td>
          <td width="18%;" style="text-transform:uppercase;font-weight:bold;"> </td>
          <td width="18%;" style="text-transform:uppercase;font-weight:bold;">Price</td>
          <td width="18%;" style="text-transform:uppercase;font-weight:bold;"> Quantity</td>
          <td width="18%;" style="text-transform:uppercase;font-weight:bold;">Total</td>
        </tr>';
        $totalp = NULL;
        $box = NULL;
        $gold = NULL;
      //  $boxprice = 0.00;
  //$boxquantity = 0;
//        for ($i = 1; $i <= 5; $i++) {  // Giftbox price
//            $boxprice1 = $this->session->userdata("price_box$i") * $this->session->userdata("coinbox$i");
//            $boxprice = $boxprice + $boxprice1;
//        }

        $flag = 0;
        foreach ($order_detail as $items):  // Add coins to email and pdf.
            //$totalp = $totalp + $items['subtotal'];
            $coin = $items['img_name'];
            $lastpostion = strripos($coin, '/') + 1;
            $img = trim(substr($coin, $lastpostion));
            $coin_img = $root . "/coins/" . $img;
            $mailimg = base_url() . 'coins/' . $img;
            // print_r($items);
            //2015.02.25 changed by frank
            if (strpos($items['coin_type'],'24KT Gold Plated') !== false) {
                $cointype = '24KT Gold Plated <br >JFK Personalized Coin ';
                $coin_price = $items['coin_cost'] + $gold_price;

                $totalprice = $coin_price * $items['coin_quantity'];
            } else {
            	if ($items['coin_selected'] == 'eagle') {
	                $cointype = 'Silver Eagle';
	                $coin_price = $items['coin_cost'];

                    if ($flag == 0) {
                        $totalprice =  $coin_price * ($items['coin_quantity'] - 1) + $eagle_coin_price;
                        $coin_price = $totalprice / $items['coin_quantity'];
                        $flag = 1;
                    }else {
                        $totalprice = $coin_price * $items['coin_quantity'];
                    }
            	}else {
            		$cointype = 'Standard <br >JFK Personalized Coin';
            		$coin_price = $items['coin_cost'];
                    $totalprice = $coin_price * $items['coin_quantity'];
            	}
            }
            $html .= '<tr>
           <td width="28%;"><img src="' . $coin_img . '" width="80;height:60px" > </td>
           <td width="18%;"> ' . $cointype . '</td>
           <td width="18%;"> $' . number_format($coin_price, 2) . ' </td>
         <td width="18%;"> ' . $items['coin_quantity'] . '</td>
           <td width="18%;">$' . number_format($totalprice, 2) . ' </td>
        </tr>';
            $email .= '<tr>
          <td><img src=" ' . $mailimg . '" style="width:100px; height:100px;" ></td>
          <td style="font-size:12px;"> ' . $cointype . '</td>
           <td style="font-size:12px;">$' . number_format($coin_price, 2) . '</td>
             <td style="font-size:12px;">' . $items['coin_quantity'] . '</td>
           <td style="font-size:12px;">$' . number_format($coin_price * $items['coin_quantity'], 2) . '  </td>
        </tr>';
        endforeach; // Fiftbox

        for ($i = 1; $i <= 5; $i++) {    // Add giftbox to email and pdf.
            if ($this->session->userdata("coinbox$i") != 0) {
                if ($i == 1) {
                    $boxtype = "Single";
                } elseif ($i == 2) {
                    $boxtype = "Two";
                } elseif ($i == 3) {
                    $boxtype = "Three";
                } elseif ($i == 4) {
                    $boxtype = "Eight";
                } else {
                    $boxtype = "Fifteen";
                }
                $box_img = $root . "/assets/img/coinbox" . $i . ".png";
                $mail_box_img = base_url() . 'assets/img/coinbox' . $i . ".png";
                $html .= '<tr>
          <td width="28%;"><img src="' . $box_img . '" width="50px;height:30px;" > </td>
          <td width="18%;">' . $boxtype . ' Coin Box : JFK Half Dollar Coin Box </td>
          <td width="18%;"> ' . $this->session->userdata("price_box$i") . '</td>
           <td width="18%;"> ' . $this->session->userdata("coinbox$i") . '</td>
          <td width="18%;"> $' . number_format($this->session->userdata("price_box$i") * $this->session->userdata("coinbox$i"), 2) . ' </td></tr>';
                $email .= '<tr>
          <td><img src="' . $mail_box_img . '" width="100px;height:80px;" > </td>
          <td style="font-size:12px;">' . $boxtype . ' Coin Box : JFK Half Dollar Coin Box </td>
          <td style="font-size:12px;"> ' . $this->session->userdata("price_box$i") . '</td>
           <td style="font-size:12px;"> ' . $this->session->userdata("coinbox$i") . '</td>
          <td style="font-size:12px;"> $' . number_format($this->session->userdata("price_box$i") * $this->session->userdata("coinbox$i"), 2) . '</td></tr>';
            }
        }
        
        for ($i = 1; $i <= 5; $i++) {    // Add giftbox to email and pdf.
            if ($this->session->userdata("eagle_coinbox$i") != 0) {
                if ($i == 1) {
                    $boxtype = "Single";
                } elseif ($i == 2) {
                    $boxtype = "Two";
                } elseif ($i == 3) {
                    $boxtype = "Three";
                } elseif ($i == 4) {
                    $boxtype = "Eight";
                } else {
                    $boxtype = "Fifteen";
                }
                $box_img = $root . "/assets/img/coinbox" . $i . ".png";
                $mail_box_img = base_url() . 'assets/img/coinbox' . $i . ".png";
                $html .= '<tr>
          <td width="28%;"><img src="' . $box_img . '" width="50px;height:30px;" > </td>
          <td width="18%;">' . $boxtype . ' Coin Box : American Eagle Coin Box </td>
          <td width="18%;"> ' . $this->session->userdata("price_box$i") . '</td>
           <td width="18%;"> ' . $this->session->userdata("eagle_coinbox$i") . '</td>
          <td width="18%;"> $' . number_format($this->session->userdata("price_box$i") * $this->session->userdata("eagle_coinbox$i"), 2) . ' </td></tr>';
                $email .= '<tr>
          <td><img src="' . $mail_box_img . '" width="100px;height:80px;" > </td>
          <td style="font-size:12px;">' . $boxtype . ' Coin Box : American Eagle Coin Box </td>
          <td style="font-size:12px;"> ' . $this->session->userdata("price_box$i") . '</td>
           <td style="font-size:12px;"> ' . $this->session->userdata("eagle_coinbox$i") . '</td>
          <td style="font-size:12px;"> $' . number_format($this->session->userdata("price_box$i") * $this->session->userdata("eagle_coinbox$i"), 2) . '</td></tr>';
            }
        }

        $html .= '<tr>
          <td colspan="5" style="text-align:right;"><span style="font-weight:bold;margin-right:20px;">Subtotal : </span> $' . number_format($subtotal, 2) . ' <br />
            <span style="font-weight:bold;margin-right:20px;">Tax : </span>$'.number_format($tax, 2) .'<br />
            <span style="font-weight:bold;margin-right:20px;">Discount : </span>$'.number_format($discount, 2) . ' <br />
                <span style="font-weight:bold;margin-right:20px;">Shipping : </span>$'.number_format($shipping, 2) . ' <br />
            <span style="font-weight:bold;margin-right:20px;">Grand Total : </span>$'.number_format($gtotoal, 2) . ' <br /></td>
        </tr>
      </table>
      </td>
  </tr>
</table>';
        $email .= '<tr>
          <td colspan="5" align="right" style="border-top:1px solid rgb(0,0,0);" >
          <table width="40%" border="0" cellspacing="0" cellpadding="5" style="font-size:12px; font-family:Arial, Helvetica, sans-serif; line-height:14px;">
          <tr>
            <td align="right" valign="middle" style="color:rgb(0,0,0);">Subtotal</td>
            <td align="right" valign="middle">$' . number_format($subtotal, 2) . ' </td>
          </tr>
          <tr>
            <td align="right" valign="middle" style="color:rgb(0,0,0);">Tax: </td>
            <td align="right" valign="middle">$' . number_format($tax, 2) . '</td>
          </tr>
          <tr>
            <td align="right" valign="middle" style="color:rgb(0,0,0);">Discount : </td>
            <td align="right" valign="middle"> $' . number_format($discount, 2) . '</td>
          </tr>
          <tr>
            <td align="right" valign="middle" style="color:rgb(0,0,0);">Shipping : </td>
            <td align="right" valign="middle"> $' . number_format($shipping, 2) . '</td>
          </tr>
          <tr>
            <td align="right" valign="middle" style="color:rgb(0,0,0);">Grand Total</td>
            <td align="right" valign="middle">$' . number_format($gtotoal, 2) . ' </td>
          </tr>
        </table>
        </td>
        </tr>
      </table>
                            </td>
                          </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 0px; line-height: 0px;" width="100%" height="20" bgcolor="#000000"></td>
                </tr>
            </tbody>
        </table>
        <br>
        <br>
</div>
</body>';
        // Page 1 ends here
        /*  PDF 2nd page to show coins start here */
        $pdf->writeHTML($html, true, false, false, false, '');
        
        if(count($img1) > 0) {
            $html1 = NULL;
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(TRUE, 0);
            $html1 .= '<div style="width: 100%;"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="text-align:center; margin-top: 15;">';
            $totalcoins = count($img1);
    
            $loop = intval($totalcoins / 7.5) + 1;  // Rows count
            $z = 0;   // array position
            for ($i = 1; $i <= $loop; $i++) {
    
                if ($i % 2 == 0) {
                    $k = 7;
                } else {
                    $k = 8;
                }
                if ($k == 8) {
                    if ($i == 1) {
                    	@$html1 .='<tr height="29"><td height="29" ></td></tr>';
                        @$html1 .= '<tr height="113.1"><td height="113.1" ><table width="100%" border="0px" cellspacing="0" cellpadding="0" style="text-align:center;"><tr >';    
                    }else {
                        @$html1 .= '<tr height="113.1"><td height="113.1" ><table width="100%" border="0px" cellspacing="0" cellpadding="0" style="text-align:center;"><tr >';
                    }
                    
                    for ($l = 1; $l <= 8; $l++) {
                    	if ($l == 1) {
                    		@$html1 .='<td style="text-align:left" width="2"></td>';
                    	}
                        @$html1 .='<td style="text-align:left" width="12.745%"><img src="' . $img1[$z] . '"  width="108"  height="108"  /></td>';
                        $z++;
                    }
                    $html1 .= '</tr></table></td></tr>';  // 8 coins end here
                } else {
                    @$html1 .= '<tr height="113.1px"><td height="113.1px"><table width="100%" border="0px" cellspacing="0" cellpadding="0" style="text-align:center;"><tr style="text-align:center;"><td width="6.35%">&nbsp;&nbsp;</td>';
                    for ($l = 1; $l <= 7; $l++) {
                    	if ($l == 1) {
                    		@$html1 .='<td style="text-align:left" width="2"></td>';
                    	}
                        @$html1 .='<td style="text-align:left" width="12.75%"><img src="' . $img1[$z] . '"  width="108"  height="108" style="margin-bottom:0px;" /></td>';
                        $z++;
                    }
                    @$html1 .= '</tr></table></td></tr>'; // 7coins ends here
                }
            }
            @$html1 .='</table></div> ';
            

            // echo $html1; die;
            $pdf->writeHTML($html1, true, false, true, false, '');
        }
        
        if(count($img2) > 0) {
            /*  PDF 3rd page to show coins start here */
            $html2 = NULL;
            $pdf->AddPage();
//            $pdf->SetMargins(20, 2, 5, true);
            $pdf->SetAutoPageBreak(TRUE, 0);
            $html2 .= '<div style="width: 100%;"><table width="98%" border="0" cellspacing="0" cellpadding="0" style="text-align:center; margin-left: 1%;">';
            $totaleaglecoins = count($img2);
    
            $loop = intval($totaleaglecoins / 5.5) + 1;  // Rows count
            
            $actual_link = "https://$_SERVER[HTTP_HOST]";
            $z = 0;   // array position
            
            $this->logToFile('checkout.log', $actual_link);
            
            for ($i = 1; $i <= $loop; $i++) {
                $pieces = explode("/", $img2[$z]);
                $filename = $actual_link . "/coins/" . $pieces[count($pieces) - 1];
                
                $this->logToFile('checkout.log', $filename);
    
                if ($i % 2 == 0) {
                    $k = 5;
                } else {
                    $k = 6;
                }
                if ($k == 6) {
                    @$html2 .= '<tr height="142"><td height="142" style="padding:0px; display: inline-block;"><table border="0px" cellspacing="0" cellpadding="0" style="text-align:center; width: 987px; height:142px;"><tr><td width="19.5px">&nbsp;&nbsp;</td>';
                    for ($l = 1; $l <= 6; $l++) {
                        @$html2 .='<td style="text-align:center; vertical-align: top;" width="164.5px"><img src="' . $img2[$z] . '"  width="132.5"  height="132.2" style="margin-bottom:30px;" /></td>';
                        $z++;
                    }
                    $html2 .= '</tr></table></td></tr>';  // 6 coins end here
                } else {
                    @$html2 .= '<tr height="142"><td height="142" style="padding:0px; display: inline-block;"><table border="0px" cellspacing="0" cellpadding="0" style="text-align:center; width: 987px;height:142px;"><tr style="text-align:center;"><td width="101.75px">&nbsp;&nbsp;</td>';
                    for ($l = 1; $l <= 5; $l++) {
                        @$html2 .='<td style="text-align:center; vertical-align: top;" width="164.5px"><img src="' . $img2[$z] . '"  width="132.5"  height="132.2" style="margin-bottom:30px;" /></td>';
                        $z++;
                    }
                    @$html2 .= '</tr></table></td></tr>'; // 5coins ends here
                }
            }
            @$html2 .='</table></div> ';
            
            
            // echo $html1; die;
            $pdf->writeHTML($html2, true, false, true, false, '');
     }

//// reset pointer to the last page
        $pdf->lastPage();
        $pdfname = $order_id.'.pdf';
        $path = $root . "/pdf/" . $pdfname;
        $pdf->Output($path, 'F');
        // Update Pdf Name to database
        $update_order = array(
            'pdf_name' => $pdfname
        );
        $this->order_model->updateorder_status($order_id, $update_order);

        if(!empty($trackingnumber) && !empty($stamp) )
        {
          $update_order_stamps = array(
            'stamp_link' => $stamp,
            'shipping_number' => $trackingnumber,
        );
        $this->order_model->updateorder_status($order_id, $update_order_stamps);
        }else {
            $trackingnumber = '000';
        }


        /* Email HTML 1st part Start here  */
        $email1 = '<body bgcolor="#ffffff" text="#979288" style="padding:0; margin:0;">
                    <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
                    <style type="text/css">
                    </style>
                    <div style="background: #ffffff; color:#979288; font-family: Open Sans, sans-serif;" align="center">
                <table style=" color: #979288; font-size: 15px; line-height: 23px; width: 650px;" border="0" cellspacing="0" cellpadding="0" align="center">
                    <tbody>
                        <tr>
                            <td style="font-size: 0px; line-height: 0px;" width="650" height="5" bgcolor="#FFCC33"></td>
                        </tr>

                        <tr>
                            <td width="650" height="150" align="center" valign="middle" style="background:rgb(0,0,0);"><table style="width: 575px;" border="0" cellspacing="0" cellpadding="0" align="center">
                                    <tbody>
                                        <tr>
                                            <td style="font-family: Open Sans, sans-serif; color: #3b3b3b; font-size: 40px; text-align: left; line-height: 45px;">
                                                <img src="' . base_url() . 'assets/img/logo.png" alt="Personalizedcoins.com" title="Personalizedcoins.com">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table></td>
                        </tr>
                        <tr>
                            <td width="650" align="center" valign="top" bgcolor="#ffffff">
                                <table width="100%" border="0" cellspacing="0" cellpadding="00">
                                  <tr>
                                    <td align="left">
                                        <table style="font-family:Open Sans, sans-serif;  color: #979288; font-size: 15px; text-align: left; line-height: 23px;" border="0" cellspacing="0" cellpadding="0" align="center" width="100%">
                                                            <tbody>
                                                                <tr>
                                                                  <td height="10" colspan="2"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="50%">
                                                                    <h1 style="font-weight:normal; font-size:20px; font-family:Arial, Helvetica, sans-serif; color:#B35919; margin:0px;">Thank You ' . $name . '!..</h1>
                                                                    <h2 style="font-weight:normal; font-size:14px; font-family:Arial, Helvetica, sans-serif; color:#000000; margin:0px; ">Your Order has been submitted.</h2>

                                                                  </td>
                                                                    <td width="50%" align="right" style="color:rgb(0,0,0); text-transform:uppercase; font-family:Arial, Helvetica, sans-serif;"></td>
                                                                </tr>
                                                                <tr>
                                                                  <td height="10" colspan="2"></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td align="left">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border:1px solid rgb(0,0,0); line-height:16px;">
                                          <tr>
                                            <td align="left" valign="top" width="50%" style="font-family:Arial, Helvetica, sans-serif;">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                  <tr>
                                    <td colspan="3" style="font-size:16px;color:#F07822;text-transform:uppercase; border-bottom:1px solid rgb(0,0,0); line-height:22px;" >Payment Details</td>
                                    </tr>
                                     <tr>
                                    <td width="36%" style="font-size:12px;color:#000;">Order Id</td>
                                    <td width="4%" align="center">:</td>
                                    <td width="60%" style="font-size:12px;" > ' . $order_id . ' </td>
                                  </tr>
                                  <tr>
                                    <td width="36%" style="font-size:12px;color:#000;">Transaction Id</td>
                                    <td width="4%" align="center">:</td>
                                    <td width="60%" style="font-size:12px;" > ' . $transactionid . ' </td>
                                  </tr>
                                  <tr>
                                    <td style="font-size:12px;color:#000;">Amount Paid</td>
                                    <td align="center">:</td>
                                    <td style="font-size:12px;" >$' . number_format($gtotoal, 2) . '</td>
                                  </tr>
                                  <tr>
                                    <td style="font-size:12px;color:#000;">Shipping Charges</td>
                                    <td align="center">:</td>
                                    <td style="font-size:12px;" >'.$shipping.'</td>
                                  </tr>
                                  <tr>
                                    <td style="font-size:12px;color:#000;">Payment Date</td>
                                    <td align="center">:</td>
                                    <td style="font-size:12px;" > ' . $now . ' </td>
                                  </tr>
                                  <tr>
                                    <td style="font-size:12px;color:#000;">&nbsp;</td>
                                    <td align="center">&nbsp;</td>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td style="font-size:12px;color:#000;">&nbsp;</td>
                                    <td align="center">&nbsp;</td>
                                    <td>&nbsp;</td>
                                  </tr>
                                                </table>
                                            </td>
                                            <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif;">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                  <tr>
                                    <td colspan="3" style="font-size:16px;color:#F07822;text-transform:uppercase; border-bottom:1px solid rgb(0,0,0); line-height:22px;" >Billing Information</td>
                                    </tr>
                                  <tr>
                                    <td width="31%" style="font-size:12px;color:#000;">Name</td>
                                    <td width="4%" align="center">:</td>
                                    <td width="65%" style="font-size:12px;">' . $data['userdetail']['0']['first_name'] . ' ' . $data['userdetail']['0']['last_name'] . '</td>
                                  </tr>
                                  <tr>
                                    <td style="font-size:12px;color:#000;">Address</td>
                                    <td align="center">:</td>
                                    <td style="font-size:12px;" >' . $data['Billing']['0']['address'] . '</td>
                                  </tr>
                                  <tr>
                                    <td style="font-size:12px;color:#000;">City</td>
                                    <td align="center">:</td>
                                    <td style="font-size:12px;" >' . $data['Billing']['0']['city'] . '</td>
                                  </tr>
                                  <tr>
                                    <td style="font-size:12px;color:#000;">State</td>
                                    <td align="center">:</td>
                                    <td style="font-size:12px;" >' . $state_billing['0'] . '</td>
                                  </tr>
                                  <tr>
                                    <td style="font-size:12px;color:#000;">Zip Code</td>
                                    <td align="center">:</td>
                                    <td style="font-size:12px;">' . $data['Billing']['0']['post_code'] . '</td>
                                  </tr>
                                  <tr>
                                    <td style="font-size:12px;color:#000;">Country</td>
                                    <td align="center">:</td>
                                    <td style="font-size:12px;">' . $ctry_billing['0'] . '</td>
                                  </tr>
                                  <tr>
                                    <td style="font-size:12px;color:#000;">Mobile Number</td>
                                    <td align="center">:</td>
                                    <td style="font-size:12px;" >' . $data['Billing']['0']['phone'] . '</td>
                                  </tr>
                                </table>
                                            </td>
                                          </tr>
                                        </table>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top">
                                          <table cellpadding="5" cellspacing="0" style="text-align:center;border:1px solid rgb(0,0,0); font-family:Arial, Helvetica, sans-serif;" width="100%" >
                <tr>
                  <td colspan="5" align="left" style="font-size:16px; color:#F07822; text-transform:uppercase; border-bottom:1px solid rgb(0,0,0); line-height:22px;">Order Details</td>
                </tr>
                <tr>
                  <td width="20%" style="text-transform:uppercase; font-size:12px; color:#000;">Description</td>
                  <td width="20%" style="text-transform:uppercase; font-size:12px; color:#000;"></td>
                  <td width="20%" style="text-transform:uppercase; font-size:12px; color:#000;">Price</td>
                  <td width="20%" style="text-transform:uppercase; font-size:12px; color:#000;"> Quantity</td>
                  <td width="20%" style="text-transform:uppercase; font-size:12px; color:#000;">Total</td>
                </tr>';
        $emailtouser = $email1;   // Add part to combine mail content
        $emailtouser .= $email;
        /*
         * Send mail to User
         */
        $this->email->set_mailtype("html");
        $this->email->from('info@personalizedcoins.com', 'Order placed');
        $this->email->to($emailto);
        $this->email->subject('Order created on www.coinsondemand.com');
        $this->email->message($emailtouser);
        $this->email->send();
        $this->mailtoadmin($order_id, $transactionid, $pdfname);
        /* user Email ends here */
        /*  Set coupon as used */
        $c_code = $detal['0']['coupon_code'];
         $c_Id = $detal['0']['coupon_id'];
        if (!empty($c_Id)) {
            $this->order_model->setcouponused("$c_code", $c_Id,$user_id);
        }
         $this->order_model->delete_temporder( $user_id);
        /*  Set coupon as used ends here */
        $this->user_model->deletepending_cart($user_id);
        redirect('checkout_complete/success');
    }

    // Admin Mail.
    public function mailtoadmin($order_id, $transactionid, $pdfname) {
        // $this->email->set_mailtype("text");
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
                                        <img src="' . BASE_URL() . 'assets/img/logo.png" alt="www.coinsondemand.com" title="www.coinsondemand.com">
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
                                        <span style="font-size: 20px; line-height: 30px; color: #00B9EB;"> Order registered on <strong style="color: #00B9EB; text-decoration:none;">Coinsondemand.com</strong> </span><br />
                                        <p>Dear  Admin</p>
                                        <p>An order has been placed by customer on Personalizedcoins.com </p>
                                        <p> Order id is <strong> ' . $order_id . '</strong> and Transaction ID is <strong> ' . $transactionid . '</strong> </p>
                                        <p> For detail kindly login to you amin panel on www.coinsondemand.com </p>
                                        <p>From,
                                        </p>
                                        <p><b>Admin</b></p>
                                        <p><b>www.coinsondemand.com</b></p>
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
        $root = "/home2/ab87757/public_html/";
        $this->email->set_mailtype("html");
        $this->email->from('info@personalizedcoins.com', 'Order created');
//        $list = array('info@personalizedcoins.com, digitaladvertising2@gmail.com');
//         $list = array('info@personalizedcoins.com, eric.aiello@gmail.com');
        $list = array('ggoldong@gmail.com, eric.aiello@gmail.com');
//         $list = array('ggoldong@gmail.com');
        $this->email->to($list); //alexadagostino@gmail.com
        $this->email->subject("Order Placed on www.coinsondemand.com, Order No.$order_id");
        $this->email->message($message);
        $this->email->attach($root . '/pdf/' . $pdfname);
        $this->email->send();
        //show_error($this->email->print_debugger());
    }

}

?>