<?php
    class Tls_Sp_Invoices_Model{
        
        public function __construct() {
            ;
        }
        
    // ================== Được gọi vào frontend/Cart.php hàm send_mail() ==================== //
        public function save_items($arrData = array(), $options = array()){
            //echo '<br>' . __METHOD__;
            
            global $tController, $wpdb;
            
            $action = $options['action'];
            $table = $wpdb->prefix . 'sp_invoices';
            
            $data = array(
                'full_name' 		=> $arrData['full_name'],
                'phone' 			=> $arrData['phone'],
                'email' 			=> $arrData['email'],
                'bill_address' 		=> $arrData['bill_address'],
                'shipping_address' 	=> $arrData['shipping_address'],
                'comment' 			=> $arrData['comment'],
                'date_order'		=> time(),    // Lấy ra số giây từ 1/1/1970 -> nay.
                'status' 			=> 'pedding', // approve - shipping - close
            );
            
            $format = array('%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s');
            
            if ($action == 'add'){
                $wpdb->insert($table, $data, $format);
                $lastID = $wpdb->insert_id;
                //echo '<br>lastID: ' . $lastID;
                
                $detailInvoices = $tController->getModel('DetailInvoices');
                $detailInvoices->save_items(array('invoices_id' => $lastID), array('action' => 'add'));
            }
        }
    }