<?php
    class Tls_Sp_Cart_Controller{
        
        public function __construct() {
            $this->dispath_function();
        }
        
        public function dispath_function(){
            global $tController;
        
            $action = $tController->getParams('action');
            $payment = $tController->getParams('payment');
            
            /* echo '<pre>';
            print_r($tController->getParams());
            echo '</pre>'; */
            
            if ($action == '' && $payment != ''){
                $action = $payment;
            }
            
            switch ($action){
                case 'add_to_cart' : $this->add_to_cart(); break;
                case 'update_cart' : $this->update_cart(); break;
                case 'delete_cart' : $this->delete_cart(); break;
                
                case 'send_mail'   : $this->send_mail(); break;
                case 'paypal'      : $this->paypal(); break;
                
                default: $this->display(); break;
            }
        }
        
        public function display(){
            global $tController;
            
            $tController->getView('display.php', 'frontend/cart');
            $tController->getView('payment.php', 'frontend/cart');
        }
        
        public function send_mail(){
            //echo '<br>' . __METHOD__;
            
            global $tController;
            
            $type = $tController->getParams('type');
            if ($type == 'send'){
                // Kiểm tra dữ liệu có hợp lệ hay ko (Viết hàm Validate)
            }
            
            $tController->getView('display.php', 'frontend/cart');
            $tController->getView('sent_mail.php', 'frontend/cart');
        }
        
        public function paypal(){
            echo '<br>' . __METHOD__;
        }
        
        public function delete_cart(){
            check_ajax_referer('ajax-security-code', 'security');       // Kiểm tra mã bảo mật của ajax.
        
            //echo __METHOD__;
        
            global $tController;
        
            $postID     = $tController->getParams('value');
        
            if (absint($postID) > 0){
                $tlsSs = $tController->getHelper('Session');
                $tlsSsCart = $tlsSs->get('tcart', array());
        
                unset($tlsSsCart[$postID]);
        
                $tlsSs->set('tcart', $tlsSsCart);
            }
        
            die();
        }
        
        public function update_cart(){
            check_ajax_referer('ajax-security-code', 'security');       // Kiểm tra mã bảo mật của ajax.
        
            //echo __METHOD__;
        
            global $tController;
        
            $postID     = $tController->getParams('value');
            $price      = $tController->getParams('price');
            $quality    = $tController->getParams('quality');
        
            if (absint($postID) > 0){
                $tlsSs = $tController->getHelper('Session');
                $tlsSsCart = $tlsSs->get('tcart', array());
        
                $tlsSsCart[$postID] = $quality;
        
                $tlsSs->set('tcart', $tlsSsCart);
            }
        
            echo ($price * $quality);
        
            die();          // Hàm hỗ trợ Ajax nên phải hỗ trợ lệnh die()
        }
        
        public function add_to_cart(){
            check_ajax_referer('ajax-security-code', 'security');       // Kiểm tra mã bảo mật của ajax.
            //echo '<br>Hàm ajax thêm sản phẩm vào giỏ hàng';
        
            global $tController;
        
            $id    = (int)$tController->getParams('value');
        
            //echo 'id: ' . $id;
        
            if ($id > 0){
                $tlsSs = $tController->getHelper('Session');
                $tlsSsCart = $tlsSs->get('tcart', array());
        
                if (count($tlsSsCart) == 0){
                    $tlsSsCart[$id] = 1;
                }else {
                    if (!isset($tlsSsCart[$id])){
                        $tlsSsCart[$id] = 1;
                    }else {
                        $tlsSsCart[$id] = $tlsSsCart[$id] + 1;
                    }
                }
                $tlsSs->set('tcart', $tlsSsCart);
            }
        
            $tlsSsCart = $tlsSs->get('tcart', array());
        
            $total_items = 0;
            if (count($tlsSsCart) > 0){
                foreach ($tlsSsCart as $key => $val){
                    $total_items += $val;
                }
            }
            $str_items = $total_items . ' product';
            if ($total_items > 1){
                $str_items = $total_items . ' products';
            }
            echo $str_items;
            die();          // Hàm hỗ trợ Ajax nên phải hỗ trợ lệnh die()
        }
    }