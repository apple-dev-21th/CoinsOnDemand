<?php

ob_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Order extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('order_model');
        $this->load->model('pdf_model');
        $this->load->helper('date');
        $this->load->library('cart');
        $this->load->library('session');
        $this->load->helper('cookie');
        $this->load->library('encrypt');
        $this->load->model('user_model');
        $this->load->model('category_model');
        $this->load->library('email');
        $this->load->library('pagination');
        $this->load->library('zip');
        $this->load->helper(array('form', 'url'));
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin/login');
        }
    }

    public function exportselection() {
//        print_r($_POST);die;
//        $selections = $this->input->post('selection');
        $pdf_array = array();
//
//        if (empty($selections)) {
//            echo 'Empty records!';
//            return;
//        }
//
//        if ($this->input->post('selection') == '') {
//            echo 'Please select at least one record';
//        } else {
//            $orders = json_decode($this->input->post('selection'));
        $orders = $_POST['chk'];
      //  print_r($orders);
            $root = $_SERVER['DOCUMENT_ROOT'];
            $path = $root . "/pdf/";
            $newPath = time() . ".pdf";

            foreach ($orders as $order) {
                $order_detail = $this->order_model->order_status($order);

                if (isset($order_detail[0]['pdf_name']) && $order_detail[0]['pdf_name'] != "") {
                    array_push($pdf_array, $path . $order_detail[0]['pdf_name']);
                }
            }
            $pdf_array = array_unique($pdf_array);

            $this->pdf_model->setFiles($pdf_array);
            $this->pdf_model->concat();
            $this->pdf_model->Output($path . $newPath, "F");

            $json = array('pdf_src' => base_url() . "pdf/" . $newPath);

            echo json_encode($json);
        //}
    }

    public function manageorder() {
        $limit1 = '0';
        if (isset($_REQUEST['limit']) && $_REQUEST['limit'] != '') {
            $limit1 = $this->input->post('limit');
        } else {
            $limit1 = $this->session->userdata('limit1');
        }

        if (empty($limit1)) {
            $limit1 = 10;
        }
        $this->session->set_userdata('limit1', $limit1);
        $pid = $this->uri->segment(4);
        $config['per_page'] = $limit1;
        $config['base_url'] = base_url() . 'admin/order/manageorder/';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 20;
        $config['full_tag_open'] = '<ul class="pagination pull-right">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['next_link'] = '»';
        $config['prev_link'] = '«';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['uri_segment'] = 4;
        $page = $this->uri->segment(4);
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0) {
            $limit_end = 0;
        }
        $data['count_products'] = $this->order_model->count_orders($pid);
        $config['total_rows'] = $data['count_products'];
        $this->pagination->initialize($config);

        $data['order'] = $this->order_model->getorder($config['per_page'], $limit_end);
        $data['main_content'] = 'admin/order/order';
        $this->load->view('admin/include/template', $data);
    }

    public function downloadallpdf() {
        $ids = $_REQUEST['chk'];
       $this->downloadallpdfs($ids);

        
    }

    public function downloadallpdfs($iDs){
        $root = $_SERVER['DOCUMENT_ROOT'];
        $file = "pdffiles.zip";
        $pdf = $root . "pdf/";
        $this->zip->archive($file);
         foreach ($iDs as $id) {
            $this->zip->read_file($pdf . $id . '.pdf');
        }
       $this->zip->download($file);
    }
    public function combinecoins() {
        $root = $_SERVER['DOCUMENT_ROOT'];
        $img1 = '';               // Combine all coins to one array
        $ids = $_REQUEST['chk'];
       // $ids = json_decode($this->input->post('selection'));
        foreach ($ids as $id) {
            $order_detail = $this->order_model->getCoins_detail($id);
            foreach ($order_detail as $items):
                $coin = $items['img_name'];
                $lastpostion = strripos($coin, '/') + 1;
                $img = trim(substr($coin, $lastpostion));
                $coin_img = $root . "/coins/" . $img;
                for ($i = 1; $i <= $items['coin_quantity']; $i++) {
                    $img1 [].= $coin_img;
                }
            endforeach;
        }
        require_once $root . "/application/libraries/tcpdf/tcpdf.php";
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
        $pdf->SetMargins(6.09, 19.5, 5);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->AddPage();
        $pdf->SetMargins(6.1, 19.3, 5);
        $pdf->SetAutoPageBreak(TRUE, 0);
        $html1 = '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="text-align:center;">';
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
                @$html1 .= '<tr height="113.1"><td height="113.1" ><table width="100%" border="0px" cellspacing="0" cellpadding="0" style="text-align:center;"><tr >';
                for ($l = 1; $l <= 8; $l++) {
                    @$html1 .='<td style="text-align:left" width="12.745%"><img src="' . $img1[$z] . '"  width="109"  height="109"  /></td>';
                    $z++;
                }
                $html1 .= '</tr></table></td></tr>';  // 8 coins end here
            } else {
                @$html1 .= '<tr height="113.1px"><td height="113.1px"><table width="100%" border="0px" cellspacing="0" cellpadding="0" style="text-align:center;"><tr style="text-align:center;"><td width="6.35%">&nbsp;&nbsp;</td>';
                for ($l = 1; $l <= 7; $l++) {
                    @$html1 .='<td style="text-align:left" width="12.75%"><img src="' . $img1[$z] . '"  width="109"  height="109" style="margin-bottom:0px;" /></td>';
                    $z++;
                }
                @$html1 .= '</tr></table></td></tr>'; // 7coins ends here
            }
        }
        @$html1 .='</table> ';
        // echo $html1; die;
        $pdf->writeHTML($html1, true, false, true, false, '');
//// reset pointer to the last page
        $pdf->lastPage();
        $pdfname = time() . '.pdf';
        $path = $root . "/pdf/" . $pdfname;
        $pdf->Output($path, 'F');
        $file = $root . "/pdf/" . $pdfname;
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Content-Length: ' . filesize($file));
        readfile($file);
    }

    public function printjigs() {
        $root = $_SERVER['DOCUMENT_ROOT'];
        // Combine all coins to one array
        $ids = $_REQUEST['chk'];
        foreach ($ids as $id) {
            $img1 = array();
            $img2 = array();
            $order_detail = $this->order_model->getCoins_detail($id);
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

            require_once $root . "/application/libraries/tcpdf/tcpdf.php";
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
            $pdf->SetMargins(5.5, 10.9, -1, true);
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
                require_once(dirname(__FILE__) . '/lang/eng.php');
                $pdf->setLanguageArray($l);
            }
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(TRUE, 0);
            $html1 = '';
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

            if(count($img2) > 0) {
                /*  PDF 3rd page to show coins start here */
                $html2 = '';
                if (count($img1) > 0) {
                    $pdf->AddPage();
//            $pdf->SetMargins(20, 2, 5, true);
                    $pdf->SetAutoPageBreak(TRUE, 0);
                }

                $html2 .= '<div style="width: 100%;"><table width="98%" border="0" cellspacing="0" cellpadding="0" style="text-align:center; margin-left: 1%;">';
                $totaleaglecoins = count($img2);

                $loop = intval($totaleaglecoins / 5.5) + 1;  // Rows count

                $actual_link = "https://$_SERVER[HTTP_HOST]";
                $z = 0;   // array position

                for ($i = 1; $i <= $loop; $i++) {



                    $pieces = explode("/", $img2[$z]);
                    $filename = $actual_link . "/coins/" . $pieces[count($pieces) - 1];


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
            $pdfname = $id . '.pdf';
            $path = $root . "/jigpdf/" . $pdfname;
            $pdf->Output($path, 'F');
        }
        $file = "pdffiles.zip";
        $pdf = $root . "jigpdf/";
        $this->zip->archive($file);
        foreach ($ids as $id) {
            $this->zip->read_file($pdf . $id . '.pdf');
        }
        $this->zip->download($file);
    }

    public function printOrder() {
        $html = '';
        $ids = $_REQUEST['chk'];
        foreach ($ids as $order_id) {
            $detal = $this->order_model->getOrder_detail($order_id);
            $order_detail = $this->order_model->getCoins_detail($order_id);
            $giftBox_detail = $this->order_model->getgiftbox_detail($order_id);
            $data['box_price'] = $this->category_model->giftprice();
            $data['gold_price'] = $this->category_model->goldprice();
            $gold_price = $data['gold_price']->gold_price;
            $coinbaox = array(
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
            $this->session->set_userdata($coinbaox);  // Save Gift box to session
            $root = $_SERVER['DOCUMENT_ROOT'];
            $img1 = '';               // Combine all coins to one array
            foreach ($order_detail as $items):
                $coin = $items['img_name'];
                $lastpostion = strripos($coin, '/') + 1;
                $img = trim(substr($coin, $lastpostion));
                $coin_img = $root . "coins/" . $img;
                for ($i = 1; $i <= $items['coin_quantity']; $i++) {
                    $img1 [].= $coin_img;
                }
            endforeach;
            $totalcoins = count($img1);
            $gtotoal = $detal['0']['total_paid'];
            $tax = $detal['0']['tax'];
            $shipping = $detal['0']['shipping_amount'];
            $discount = $detal['0']['discount'];
            $subtotal = $detal['0']['sub_total'];
            $transactionid = $detal['0']['transaction_id'];
            $user_id = $detal['0']['user_id'];
            $now = date('m/d/Y g:i a', strtotime($detal['0']['order_date']));
            ;
            $data['userdetail'] = $this->user_model->user_profile($user_id);
            $data['shipping'] = $this->user_model->shipingaddress($user_id);
            $data['Billing'] = $this->user_model->billingaddress($user_id);
            $name = $data['userdetail']['0']['first_name'] . ' ' . $data['userdetail']['0']['last_name'];
            $state_shipping = explode('-', $data['shipping']['0']['state']);
            $ctry_shipping = explode('-', $data['shipping']['0']['country']);
            $state_billing = explode('-', $data['Billing']['0']['state']);
            $ctry_billing = explode('-', $data['Billing']['0']['country']);
            $shipping_date = date('Y-m-d', strtotime('+5 days'));
            $newdata = array(
                'gtotal' => $gtotoal,
                'userId' => $user_id,
                'OrderId' => $order_id
            );
            $this->session->set_userdata($newdata);
            /*             * ************************  PDF generate start here  ******************************** */

            $root = $_SERVER['DOCUMENT_ROOT'];
            require_once $root . "/application/libraries/tcpdf/tcpdf.php";
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
            $pdf->SetMargins(6.09, 19.5, 5);
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
                require_once(dirname(__FILE__) . '/lang/eng.php');
                $pdf->setLanguageArray($l);
            }
           $pdf->AddPage();
            /* ========================== HTML for PDF fist page ================== */
            $html .= '<table style="width:100%;">
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
            foreach ($order_detail as $items):  // Add coins to email and pdf.
                //$totalp = $totalp + $items['subtotal'];
                $coin = $items['img_name'];
                $lastpostion = strripos($coin, '/') + 1;
                $img = trim(substr($coin, $lastpostion));
                $coin_img = $root . "coins/" . $img;
                // print_r($items);
                if (strpos($items['coin_type'], '24KT Gold Plated') !== false) {
                    $cointype = '24KT Gold Plated <br >Personalized Coin ';
                    $coin_price = $items['coin_cost'] + $gold_price;
                } else {
                    $cointype = 'Standard <br > Personalized Coin';
                    $coin_price = $items['coin_cost'];
                }
                $html .= '<tr>
           <td width="28%;"><img src="' . $coin_img . '" width="80;height:60px" > </td>
           <td width="18%;"> ' . $cointype . '</td>
           <td width="18%;"> $' . number_format($coin_price, 2) . ' </td>
         <td width="18%;"> ' . $items['coin_quantity'] . '</td>
           <td width="18%;">$' . number_format($coin_price * $items['coin_quantity'], 2) . ' </td>
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
          <td width="18%;">' . $boxtype . ' Coin Box </td>
          <td width="18%;"> ' . $this->session->userdata("price_box$i") . '</td>
           <td width="18%;"> ' . $this->session->userdata("coinbox$i") . '</td>
          <td width="18%;"> $' . number_format($this->session->userdata("price_box$i") * $this->session->userdata("coinbox$i"), 2) . ' </td></tr>';
                }
            }

            $html .= '<tr>
          <td colspan="5" style="text-align:right;"><span style="font-weight:bold;margin-right:20px;">Subtotal : </span> $' . number_format($subtotal, 2) . ' <br />
            <span style="font-weight:bold;margin-right:20px;">Tax : </span>$' . number_format($tax, 2) . '<br />
            <span style="font-weight:bold;margin-right:20px;">Discount : </span>$' . number_format($discount, 2) . ' <br />
                <span style="font-weight:bold;margin-right:20px;">Shipping : </span>$' . number_format($shipping, 2) . ' <br />
            <span style="font-weight:bold;margin-right:20px;">Grand Total : </span>$' . number_format($gtotoal, 2) . ' <br /></td>
        </tr>
      </table>
      </td>
  </tr>
</table><br pagebreak="true" />';
            
             $pdf->writeHTML($html, true, false, true, false, '');
             $pdf->SetMargins(6.1, 19.3, 5);
             $pdf->SetAutoPageBreak(TRUE, 0);
        }
//// reset pointer to the last page
        $pdf->lastPage();
        $pdfname = time() . '.pdf';
        $path = $root . "/pdf/" . $pdfname;
        $pdf->Output($path, 'F');
        $file = $root . "/pdf/" . $pdfname;
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Content-Length: ' . filesize($file));
        readfile($file);
    }

    public function deleteorder() {
        $id = $this->uri->segment(4);
        if ($this->order_model->delete_order($id)) {
            $this->session->set_flashdata('success', 'Order deleted succesfully.');
            redirect('admin/order/manageorder');
        }
    }

    public function orderdetail() {
        $id = $this->uri->segment(4);
        $data['order_status'] = $this->order_model->order_status($id);
        $data['giftbox'] = $this->order_model->giftbox($id);
        $data['order_detail'] = $this->order_model->order_detail($id);
        $user_id = $data['order_status']['0']['user_id'];
        $data['userdetail'] = $this->user_model->user_profile($user_id);
        $data['shipping'] = $this->user_model->shipingaddress($user_id);
        $data['billing'] = $this->user_model->billingaddress($user_id);
        $data['main_content'] = 'admin/order/order_detail';
        $this->load->view('admin/include/template', $data);
    }

    // Get Shipping Rates...
    public function getrates() {

        $shipping_date = date('Y-m-d');
        $content = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
              <soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\"
              xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
              xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\"
              xmlns:tns=\"http://stamps.com/xml/namespace/2014/05/swsim/swsimv36\">
              <soap:Body>
             <tns:GetRates>
              <tns:Credentials>
              <tns:IntegrationID>60b81f53-cb40-4875-96a9-6ad82e10970a</tns:IntegrationID>
              <tns:Username>poloblade</tns:Username>
              <tns:Password>polo6920</tns:Password>
              </tns:Credentials>
              <tns:Rate>
              <tns:FromZIPCode>11520</tns:FromZIPCode>";
        if ($_POST['tocountry'] == 'US') {
            $content .="<tns:ToZIPCode>" . $_POST['tozip'] . "</tns:ToZIPCode>";
        } else {
            $content .="<tns:ToCountry>" . $_POST['tocountry'] . "</tns:ToCountry>";
        }
        $content .= "
                <tns:ServiceType>" . $_POST['services'] . "</tns:ServiceType>               
                <tns:WeightLb>" . $_POST['weightlb'] . "</tns:WeightLb>
                <tns:WeightOz>" . $_POST['weightoz'] . "</tns:WeightOz>
                <tns:PackageType>" . $_POST['package'] . "</tns:PackageType>
               <tns:ShipDate>" . $shipping_date . "</tns:ShipDate>";
        if (isset($_POST['insurance'])) {
            $content .= " <tns:InsuredValue>" . $_POST['ins_amt'] . "</tns:InsuredValue>";
        }
        $content .= "</tns:Rate>
              </tns:GetRates>
              </soap:Body>
              </soap:Envelope>";

        $headers = array("User-Agent: Crosscheck Networks SOAPSonar",
            "Content-Type: text/xml; charset=utf-8",
            "SOAPAction:\"http://stamps.com/xml/namespace/2014/05/swsim/swsimv36/GetRates\"",
            "Content-Length:" . strlen($content));
        $soap_do = curl_init();
        curl_setopt($soap_do, CURLOPT_URL, 'https://swsim.stamps.com/swsim/swsimv36.asmx');
        //curl_setopt($soap_do, CURLOPT_HEADER, true);
        curl_setopt($soap_do, CURLINFO_HEADER_OUT, true);
        curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 7200);
        curl_setopt($soap_do, CURLOPT_TIMEOUT, 7200);
        curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($soap_do, CURLOPT_POST, true);
        curl_setopt($soap_do, CURLOPT_POSTFIELDS, $content);
        curl_setopt($soap_do, CURLOPT_HTTPHEADER, $headers);
        $res = curl_exec($soap_do);
        //echo $res; die;
        $doc = new DOMDocument('1.0', 'utf-8');
        $doc->loadXML($res);
        $telefon = $doc->getElementsByTagName('Rate');
        if ($telefon->length == 0) {
            $telefon = $doc->getElementsByTagName('faultstring');
        }
        $arr = array();
        foreach ($telefon as $keys => $t) {

            foreach ($t->childNodes as $key => $value) {
                $arr[$value->nodeName] = $value->nodeValue;
            }
        }
        if (key_exists("Amount", $arr)) {
            $amount = $arr['Amount'];
            $reult = '<table class="table table-bordered table-striped">
    <tbody>
        <tr class="odd gradeX">
            <td class="text-center">Shipping Amount</td>
            <td class="text-center">$' . $amount . '</td>
        </tr>
        <tr>
            <td>
                <div style="margin: 15px;" class="widget-content">
                    <form enctype="multipart/form-data" class="form uniformForm" accept-charset="utf-8" method="post" action="https://personalizedcoins.com/admin/order/swscalculation/' . $_POST['id'] . '">   
                        <input type="hidden" value="' . $_POST['id'] . '" name="id" id="id">
                        <input type="hidden" value="' . $_POST['services'] . '" name="services" id="id">
                        <input type="hidden" value="' . $_POST['weightlb'] . '" name="weightlb" id="id">
                        <input type="hidden" value="' . $_POST['weightoz'] . '" name="weightoz" id="id">
                        <input type="hidden" value="' . $_POST['package'] . '" name="package" id="id">';
            if (isset($_POST['insurance'])) {
                $reult .= '<input type="hidden" value="' . $_POST['ins_amt'] . '" name="insamt" id="id">';
            }
            $reult .= '<div class="actions">
                            <button type="submit" value="generate" name="generate" class="btn btn-primary">Generate</button>
                        </div>
                    </form>                                       
                </div> 
            </td>
        </tr>
    </tbody>
</table>';
        } else {
            $error = $arr['#text'];
            $reult = '<table class="table table-bordered table-striped">
    <tbody>
        <tr class="odd gradeX">
            <td >Error:</td>
            <td>' . $error . '</td>
        </tr>
       </tbody>
                    </table>';
        }
        echo $reult;
    }

    // for calculating shipping by sonu sindhu
    public function swscalculation($order_id = NULL) {
        //die("HERE");
        if ($order_id == NULL) {
            die('Order Id is blank');
        }
        $weightOZ = 0;
        $weightLB = 0;

        $services = $this->input->post('services');
        $package = $this->input->post('package');
        $weightLb = $this->input->post('weightlb');
        $weightOZ = $this->input->post('weightoz');
        $insAmt = $this->input->post('insamt');

        //$shipping_date = $this->input->post('shipping_date');
        $detal = $this->order_model->getOrder_detail($order_id);
        $order_detail = $this->order_model->getCoins_detail($order_id);
        $giftBox_detail = $this->order_model->getgiftbox_detail($order_id);
        $transactionid = $order_id;
        $user_id = $detal['0']['user_id'];
        $data['userdetail'] = $this->user_model->user_profile($user_id);
        $data['shipping'] = $this->user_model->shipingaddress($user_id);
        $data['Billing'] = $this->user_model->billingaddress($user_id);
        $name = $data['userdetail']['0']['first_name'] . ' ' . $data['userdetail']['0']['last_name'];
        $emailto = $data['userdetail']['0']['email_id'];
        $state_shipping = explode('-', $data['shipping']['0']['state']);
        $ctry_shipping = explode('-', $data['shipping']['0']['country']);
        $state_billing = explode('-', $data['Billing']['0']['state']);
        $ctry_billing = explode('-', $data['Billing']['0']['country']);
        //$shipping_date = date('Y-m-d', strtotime('+5 days'));
        $shipping_date = date('Y-m-d');
        $root = $_SERVER['DOCUMENT_ROOT'];
        $img1 = '';               // Combine all coins to one array                                           
        foreach ($order_detail as $items):
            $coin = $items['img_name'];
            $lastpostion = strripos($coin, '/') + 1;
            $img = trim(substr($coin, $lastpostion));
            $coin_img = $root . "/coins/" . $img;
            for ($i = 1; $i <= $items['coin_quantity']; $i++) {
                $img1 [].= $coin_img;
            }
        endforeach;
        $totalcoins = count($img1);
        $gtotoal = $detal['0']['total_paid'];



        if ($ctry_shipping['1'] == 'US') { // For Domestic
            $content = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
              <soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\"
              xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
              xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\"
              xmlns:tns=\"http://stamps.com/xml/namespace/2014/05/swsim/swsimv36\">
              <soap:Body>
              <tns:CreateIndicium>
              <tns:Credentials>
              <tns:IntegrationID>60b81f53-cb40-4875-96a9-6ad82e10970a</tns:IntegrationID>
              <tns:Username>poloblade</tns:Username>
              <tns:Password>polo6920</tns:Password>
              </tns:Credentials>
              <tns:IntegratorTxID>$transactionid</tns:IntegratorTxID>
              <tns:TrackingNumber/>
              <tns:Rate>
              <tns:FromZIPCode>11520</tns:FromZIPCode>
              <tns:ToZIPCode>" . $data['shipping']['0']['zip'] . "</tns:ToZIPCode>
              <tns:Amount>0</tns:Amount>
              <tns:ServiceType>$services</tns:ServiceType>
              <tns:WeightLb>$weightLb</tns:WeightLb>
              <tns:WeightOz>$weightOZ</tns:WeightOz>
              <tns:PackageType>$package</tns:PackageType>
              <tns:ShipDate>$shipping_date</tns:ShipDate>";
            if ($insAmt > 0) {
                $content .="<tns:InsuredValue>$insAmt</tns:InsuredValue>";
            }
            $content .= "<tns:RectangularShaped>false</tns:RectangularShaped>";

            if ($insAmt > 0) {
                $content .= "<tns:AddOns>
              <tns:AddOnV6>
              <tns:AddOnType>SC-A-INS</tns:AddOnType>
              </tns:AddOnV6>
              </tns:AddOns>";
            }
            $content .="</tns:Rate>
              <tns:From>
              <tns:FullName>eCoins</tns:FullName>
              <tns:Address1>14 Maple Place</tns:Address1>
              <tns:Address2/>
              <tns:City>Freeport</tns:City>
              <tns:State>NY</tns:State>
              <tns:ZIPCode>11520</tns:ZIPCode>
              </tns:From>
              <tns:To>
              <tns:FullName>" . $data['shipping']['0']['fname'] . ' ' . $data['shipping']['0']['lname'] . "</tns:FullName>        <tns:NamePrefix/>
              <tns:FirstName/>
              <tns:MiddleName/>
              <tns:LastName/>
              <tns:NameSuffix/>
              <tns:Title/>
              <tns:Department/>
              <tns:Company/>
              <tns:Address1>" . $data['shipping']['0']['address'] . "</tns:Address1>
              <tns:Address2>" . $data['shipping']['0']['address2'] . "</tns:Address2>
              <tns:City>" . $data['shipping']['0']['city'] . "</tns:City>
              <tns:State>" . $state_shipping['1'] . "</tns:State>
              <tns:ZIPCode>" . $data['shipping']['0']['zip'] . "</tns:ZIPCode>
              <tns:ZIPCodeAddOn/>
              <tns:DPB>59</tns:DPB>
              <tns:CheckDigit>6</tns:CheckDigit>
              <tns:Province/>
              <tns:PostalCode/>
              <tns:Country/>
              <tns:Urbanization/>
              <tns:PhoneNumber>" . $data['shipping']['0']['phone'] . "</tns:PhoneNumber>
              <tns:Extension/>
              </tns:To>
              </tns:CreateIndicium>
              </soap:Body>
              </soap:Envelope>";
        } else { // For International
            $content = "<?xml version=\"1.0\" encoding=\"utf-8\"?><soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:sws=\"http://stamps.com/xml/namespace/2014/05/swsim/swsimv36\"><soapenv:Header/>
              <soapenv:Body>
              <sws:CreateIndicium>
              <sws:Credentials>
              <sws:IntegrationID>60b81f53-cb40-4875-96a9-6ad82e10970a</sws:IntegrationID>
              <sws:Username>poloblade</sws:Username>
              <sws:Password>polo6920</sws:Password>
              </sws:Credentials>
              <sws:IntegratorTxID>$transactionid</sws:IntegratorTxID>
              <sws:Rate>
              <sws:FromZIPCode>11520</sws:FromZIPCode>
              <sws:ToZIPCode>" . $data['shipping']['0']['zip'] . "</sws:ToZIPCode>
              <sws:ToCountry>" . $ctry_shipping['1'] . "</sws:ToCountry>
              <sws:ServiceType>$services</sws:ServiceType>
              <sws:WeightLb>$weightLb</sws:WeightLb>
              <sws:WeightOz>$weightOZ</sws:WeightOz>
              <sws:PackageType>$package</sws:PackageType>
              <sws:ShipDate>$shipping_date</sws:ShipDate>";
            if ($insAmt > 0) {
                $content .="<sws:InsuredValue>$insAmt</sws:InsuredValue>";
            }
            $content .="<sws:DeclaredValue>$totalpaid</sws:DeclaredValue>";
            if ($insAmt > 0) {
                $content .="<sws:AddOns>
              <sws:AddOnV6>
              <sws:AddOnType>SC-A-INS</sws:AddOnType>
              </sws:AddOnV6>
              </sws:AddOns>";
            }
            $content .="</sws:Rate>
              <sws:From>
              <sws:FullName>eCoins</sws:FullName>
              <sws:Address1>14 Maple Place</sws:Address1>
              <sws:City>Freeport</sws:City>
              <sws:State>NY</sws:State>
              <sws:ZIPCode>11520</sws:ZIPCode>
              <sws:Country>US</sws:Country>
              <sws:PhoneNumber>8888662451</sws:PhoneNumber>
              </sws:From>
              <sws:To>
              <sws:FullName>" . $data['shipping']['0']['fname'] . ' ' . $data['shipping']['0']['lname'] . "</sws:FullName>
              <sws:Address1>" . $data['shipping']['0']['address'] . "</sws:Address1>
              <sws:Address2>" . $data['shipping']['0']['address2'] . "</sws:Address2>
              <sws:City>" . $data['shipping']['0']['city'] . "</sws:City>
              <sws:Province>" . $state_shipping['0'] . "</sws:Province>
              <sws:PostalCode>" . $data['shipping']['0']['zip'] . "</sws:PostalCode>
              <sws:Country>" . $ctry_shipping['1'] . "</sws:Country>
              <sws:PhoneNumber>" . $data['shipping']['0']['phone'] . "</sws:PhoneNumber>
              </sws:To>
              <sws:Customs>
              <sws:ContentType>Personalized coins</sws:ContentType>
              <sws:Comments>ecommerce</sws:Comments>
              <sws:CustomsLines>
              <sws:CustomsLine>
              <sws:Description>Personalized coins</sws:Description>
              <sws:Quantity>$totalcoins</sws:Quantity>
              <sws:Value>$totalpaid</sws:Value>
              <sws:WeightLb>$weightLb</sws:WeightLb>
              <sws:WeightOz>$weightOZ</sws:WeightOz>
              </sws:CustomsLine>
              </sws:CustomsLines>
              </sws:Customs>
              <sws:SampleOnly>false</sws:SampleOnly>
              <sws:ImageType>Auto</sws:ImageType>
              <sws:PaperSize>Default</sws:PaperSize>
              </sws:CreateIndicium>
              </soapenv:Body>
              </soapenv:Envelope>";
        }
        $headers = array("User-Agent: Crosscheck Networks SOAPSonar",
            "Content-Type: text/xml; charset=utf-8",
            "SOAPAction:\"http://stamps.com/xml/namespace/2014/05/swsim/swsimv36/CreateIndicium\"",
            "Content-Length:" . strlen($content));
        $soap_do = curl_init();
        curl_setopt($soap_do, CURLOPT_URL, 'https://swsim.stamps.com/swsim/swsimv36.asmx');
        //curl_setopt($soap_do, CURLOPT_HEADER, true);
        curl_setopt($soap_do, CURLINFO_HEADER_OUT, true);
        curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 7200);
        curl_setopt($soap_do, CURLOPT_TIMEOUT, 7200);
        curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($soap_do, CURLOPT_POST, true);
        curl_setopt($soap_do, CURLOPT_POSTFIELDS, $content);
        curl_setopt($soap_do, CURLOPT_HTTPHEADER, $headers);
        $res = curl_exec($soap_do);
        //  echo '<br />result is=' . $res;
        //echo htmlentities($res);
        //echo $content;
        //die();

        $doc = new DOMDocument('1.0', 'utf-8');
        $doc->loadXML($res);
        $XMLresults = $doc->getElementsByTagName("TrackingNumber");

        if ($XMLresults->length) {
            $trackingnumber = $XMLresults->item(0)->nodeValue; // Shipping tracking number
            $stampurl = $doc->getElementsByTagName("URL");
            $stamp = $stampurl->item(0)->nodeValue;    // Stamp path 
        } else {
            @$Errroresults = $doc->getElementsByTagName("sdcerror");
            if ($Errroresults->length) {
                $Errroresults1 = $Errroresults->item(0)->nodeValue;
                $errMsg = explode('.', $Errroresults1);
                $errorMessage = $errMsg[0];
            } else {
                $errorMessage = 'Invalid shipping address';
            }
        }

        if (!empty($trackingnumber) && !empty($stamp)) {
            $update_order_stamps = array(
                'stamp_link' => $stamp,
                'shipping_number' => $trackingnumber,
            );
            $this->session->set_flashdata('success', 'Order status updated succesfully.');
            $this->order_model->updateorder_status($order_id, $update_order_stamps);
            $this->sendemailtouser($order_id, $trackingnumber, $services);
        } else {
            $this->session->set_flashdata('fail', $errorMessage);
        }

        //$this->session->set_flashdata('success', 'fgdjfkg dfgkjdfl');
        redirect("admin/order/orderdetail/$order_id");
    }

    public function manualupdate($id = null) {
        $trackingnumber = $this->input->post('trachingnumber');
        $update_order_stamps = array(
            'shipping_number' => $this->input->post('trachingnumber')
        );
        $this->session->set_flashdata('success', 'Order status updated succesfully.');
        $this->order_model->updateorder_status($id, $update_order_stamps);
        $this->sendemailtouser($id, $trackingnumber, '');
        $this->session->set_flashdata('success', 'Order status updated succesfully.');
        redirect("admin/order/orderdetail/$id");
    }

    public function changestatus() {
        $id = $this->uri->segment(4);
        $status = $this->input->post('orderstatus');
        $data = array(
            'order_status' => $status
        );
        if ($this->order_model->updateorder_status($id, $data)) {
            $this->session->set_flashdata('success', 'Order status updated succesfully.');

            if ($this->uri->segment(5) == 'manage') {
                redirect("admin/order/manageorder/");
            } else {
                redirect("admin/order/orderdetail/$id");
            }
        }
    }
    public function changebulkstatus(){
        $status = $this->input->post('status');
        $data = array(
            'order_status' => $status
        ); 
        $ids = $_REQUEST['chk'];
        foreach ($ids as $id) {
          $this->order_model->updateorder_status($id, $data);  
        }
        $this->session->set_flashdata('success', 'Order\'s status updated succesfully.');
        redirect("admin/order/manageorder/");
    }

    public function sendemailtouser($orderId, $trackingnumber, $method) {
        if ($method == 'US-FC') {
            $way = 'First Mail Class';
        } elseif ($method == 'US-PM') {
            $way = 'Priority Mail';
        } elseif ($method == 'US-XM') {
            $way = 'Priority Mail Express';
        } elseif ($method == 'US-FCI') {
            $way = 'First Class Mail International';
        } elseif ($method == 'US-MM') {
            $way = 'Media Mail';
        } elseif ($method == 'US-EMI') {
            $way = 'Priority Mail Express International';
        } elseif ($method == 'US-PMI') {
            $way = 'Priority Mail International';
        } elseif ($method == 'US-PS') {
            $way = 'Parcel Select';
        }

        $detal = $this->order_model->getOrder_detail($orderId);
        $user_id = $detal['0']['user_id'];
        $data['userdetail'] = $this->user_model->user_profile($user_id);
        $data['shipping'] = $this->user_model->shipingaddress($user_id);
        $state_shipping = explode('-', $data['shipping']['0']['state']);
        $ctry_shipping = explode('-', $data['shipping']['0']['country']);
        $name = $data['userdetail']['0']['first_name'] . ' ' . $data['userdetail']['0']['last_name'];
        $emailto = $data['userdetail']['0']['email_id'];

        $email = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>eCoins</title>
</head>
<body>
<body bgcolor="#ffffff" text="#979288" style="padding:0; margin:0;">
<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
<style type="text/css">
    </style>
<div style="background: #ffffff; color:#979288; font-family: "Open Sans", sans-serif;" align="center">
  <table style=" color: #979288; font-size: 15px; line-height: 23px; width: 650px;" border="0" cellspacing="0" cellpadding="0" align="center">
    <tbody>
      <tr>
        <td style="font-size: 0px; line-height: 0px;" width="650" height="5" bgcolor="#FFCC33"></td>
      </tr>
      <tr>
        <td width="650" height="150" align="center" valign="middle" style="background:rgb(0,0,0);"><table style="width: 575px;" border="0" cellspacing="0" cellpadding="0" align="center">
            <tbody>
              <tr>
                <td style="font-family: "Open Sans", sans-serif; color: #3b3b3b; font-size: 40px; text-align: left; line-height: 45px;"><img src="' . base_url() . 'assets/img/logo.png" alt="Personalizedcoins.com" title="Personalizedcoins.com"> </td>
              </tr>
            </tbody>
          </table></td>
      </tr>
      <tr>
        <td width="650" align="center" valign="top" bgcolor="#ffffff"><table width="100%" border="0" cellspacing="0" cellpadding="00">
            <tr>
              <td align="left"><table style="font-family: "Open Sans", sans-serif; color: #979288; font-size: 15px; text-align: left; line-height: 23px;" border="0" cellspacing="0" cellpadding="0" align="center" width="100%">
                  <tbody>
                    <tr>
                      <td height="10"></td>
                    </tr>
                    <tr>
                      <td><h1 style="font-weight:normal; font-size:20px; font-family:Arial, Helvetica, sans-serif; color:#B35919; margin:0px;">Hello, ' . $name . '</h1>
                        <h2 style="font-weight:normal; font-size:14px; font-family:Arial, Helvetica, sans-serif; color:#000000; margin:0px; ">Thank you for your order from personalizedcoins.com. Your shipping confirmation is below. Thank you again for your business</h2></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            <tr>
              <td align="left" valign="top"><h5>Your Shipment #' . $trackingnumber . ' for Order # ' . $orderId . '</h5></td>
            </tr>
            <tr>
              <td height="10"></td>
            </tr>
            <tr>
              <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><table width="100%" border="0" cellspacing="5" cellpadding="0">
                        <tr>
                          <th align="left" scope="col" style="background:#EAEAEA; color:#000;">Shipping information </th>
                        </tr>
                        <tr>
   ' . ucfirst($data['shipping']['0']['fname']) . ' ' . ucfirst($data['shipping']['0']['lname']) . '<br />
   ' . ucfirst($data['shipping']['0']['address']) . ' ' . ucfirst($data['shipping']['0']['address2']) . '<br />
   ' . ucfirst($data['shipping']['0']['city']) . ',' . $state_shipping['0'] . ',' . $data['shipping']['0']['zip'] . '<br/>
    ' . $ctry_shipping['0'] . '<br />
   T ' . $data['shipping']['0']['phone'] . '<br />
                        </tr>
                      
                      </table></td>';
        if (!empty($method)) {
            $email .=' <td><table width="100%" border="0" cellspacing="5" cellpadding="0">
                        <tr>
                          <th align="left" scope="col" style="background:#EAEAEA; color:#000;">Shipping Method </th>
                        </tr>
                        <tr>
                          <th align="left" scope="col">' . $way . '</th>
                        </tr>
                            </table></td>';
        }
        $email .='</tr>
                </table></td>
            </tr>
            <tr>
              <td align="left" valign="top">&nbsp;</td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td style="font-size: 15px; line-height: 0px;color:#FFFFFF; text-align:center" width="100%" height="25" bgcolor="#000000" >Thank you Personalizedcoins.com</td>
      </tr>
    </tbody>
  </table>
  <br>
  <br>
</div>
</body>
</body>
</html>';
        $this->email->set_mailtype("html");
        $this->email->from('info@personalizedcoins.com', 'Order shipped');
        $this->email->to($emailto);
        $this->email->subject('Your order shipped');
        $this->email->message($email);
        $this->email->send();
    }

}

?>