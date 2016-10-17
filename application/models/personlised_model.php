<?php

class Personlised_model extends CI_Model{
    function get_template($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('coins');
        $result = $query->result_array();
        return $result;
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
    
    public function price($quantity){
        $this->db->select('*');
        $this->db->from('coin_pricing');
        $query = $this->db->get();
        $result = $query->result_array();
      //  echo '<pre>'; print_r($result); die;
    $coinprice = NULL;
    foreach ($result as $price):
       if($quantity >= $price['min'] && $quantity <= $price['max'] ){ $coinprice = $price['price']; }
    endforeach;
    
    return $coinprice; 
//    
//         if($quantity == '1'){
//             $coinprice = 14.95;
//        }elseif($quantity == '2'){
//            $coinprice = 12.95;
//        }elseif ($quantity > '2' && $quantity <= '10' ) {
//            $coinprice = 9.95;
//        }elseif ($quantity > '10' &&  $quantity <= '30' ) {
//            $coinprice = 8.95;
//        }elseif ($quantity > '30' && $quantity <= '50'   ) {
//            $coinprice = 7.95;
//        }elseif ($quantity > '50' && $quantity <= '90'   ) {
//            $coinprice = 6.95;
//        }elseif ($quantity > '90' && $quantity <= '150'   ) {
//            $coinprice = 5.95;
//        }elseif ($quantity > '151' && $quantity <= '180'   ) {
//            $coinprice = 4.95;
//        }elseif ($quantity > '181' && $quantity <= '450'   ) {
//            $coinprice = 4.70;
//        }elseif ($quantity > '450' && $quantity <= '630'   ) {
//            $coinprice = 4.35;
//        }elseif ($quantity > '630' && $quantity <= '990'   ) {
//            $coinprice = 3.95;
//        }
//        return $coinprice;
// 
   }
   
       public function american_eagle_price($quantity){

        $this->db->select('*');
        $this->db->from('coin_american_eagle_pricing');
        $query = $this->db->get();
        $result = $query->result_array();;
       // echo '<pre>'; print_r($result); die;
    $coinprice = NULL;
    foreach ($result as $price):
       if($quantity >= $price['min'] && $quantity <= $price['max'] ){ $coinprice = $price['price']; }
    endforeach;
    
    return $coinprice; 

   }
}
?>
