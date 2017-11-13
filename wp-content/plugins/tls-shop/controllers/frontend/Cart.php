<?php 
    /* 
     * wp_mail(): Sử dụng phương thức mail() của PHP, đa số các host không cho sử dụng phương thức mail(),
     *            phải gửi thông qua 1 địa chỉ email nào đó trên Hosting.
     *            
     * PHPMailer(): Đối tượng dụng cho mail.
     *  */
?>

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
                
                case 'alert'      : $this->alert(); break;
                
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
            
            global $tController, $tls_sp_settings;
            
            $type = $tController->getParams('type');
            
            if ($type == 'send'){
                // Kiểm tra dữ liệu có hợp lệ hay ko (Viết hàm Validate)
                
            // Lấy ra sản phẩm của KH đã mua
                $tlsSs = $tController->getHelper('Session');
                $mailHTML = $tlsSs->get('tcart_mail', '');
                
                $content = 'We have received your order. 
    						We\'ll get back to you within 24 hours. 
    						Thank you very much<br/>';
    			$content .= '<br><h3>Your information';
    			$content .= '<br/>===============================</h3>';
    			$content .= 'Full name: ' 			    . $tController->getParams('full_name');
    			$content .= '<br/>Phone: ' 				. $tController->getParams('phone');
    			$content .= '<br/>Email: ' 				. $tController->getParams('email');
    			$content .= '<br/>Bill address: ' 		. $tController->getParams('bill_address');
    			$content .= '<br/>Shipping address: ' 	. $tController->getParams('shipping_address');
    			$content .= '<br/>Comment: ' 			. $tController->getParams('comment');			
    			$content .= '<br><br><h3>Your cart';
    			$content .= '<br/>===============================</h3>';
    			$content .=  '<div id="tls_sp_cart_table">' . $mailHTML . '</div>';
    			
    			//echo $content;
    			
    			
    			
			// ==================== Xử lý Email ===================== //
    			$flagSend = false;
                
                if ($tls_sp_settings['select_type'] == 'system'){
                    $flagSend = $this->mail_system($content);
                } else {
                    $flagSend = $this->mail_shopping($content);
                }
                
                if ($flagSend == true){
                    // Lưu vào DB.
                    $invoicesModel = $tController->getModel('Invoices');
    			    $invoicesModel->save_items($tController->getParams(), array('action' => 'add'));
                }
			// ======================================================= //
                
                $url = site_url('?page_id=' . get_query_var('page_id') . '&action=alert&mes=' . $flagSend);
                wp_redirect($url);
            }
            
            $tController->getView('display.php', 'frontend/cart');
            $tController->getView('sent_mail.php', 'frontend/cart');
        }
        
        public function alert(){
            global $tController;
            
            $mes = $tController->getParams('mes');
            
            if($mes == 1){
                echo '<div>Đơn đặt hàng của bạn đã được gửi. Chúng tôi sẽ liên lạc lại với bạn sớm nhất.</div>';
            } else {
                echo '<div>Hệ thống đang có vấn đề. Vui lòng thử lại sau.</div>';
            }
        }
        
        public function mail_system($content = null){
            //echo '<br>' . __METHOD__;
            
            global $tController, $tls_sp_settings;
            
            $to             = $tController->getParams('email');
            $subject        = 'Dead ' . $tController->getParams('full_name') . '! From TShopping ';
            $message        = $content;
            $headers[]      = 'Content-Type: text/html; charset=UTF-8';
            $headers[]      = 'From: tShopping <no-reply@abc.com>';
            $headers[]      = 'Cc: TienLe <tienls6589@gmail.com>';
            $headers[]      = 'Bcc: TienLe <'. $tls_sp_settings['alert_to_email'] .'>';            
            $attachments[]  = TLS_SP_PUBLIC_PATH . '/files/contract.zip';
            
            return wp_mail($to, $subject, $message, $headers, $attachments);    // Trả về 2 giá trị true/false, true: gửi được mail, false: không gửi được mail.
        }
        
        public function mail_shopping($content = null){
            echo '<br>' . __METHOD__;
            
            global $tController, $tls_sp_settings;
            
            require_once ABSPATH . WPINC . '/class-phpmailer.php';
            require_once ABSPATH . WPINC . '/class-smtp.php';
            
            $mail = new PHPMailer();
            
            $mail->isSMTP();            
            $mail->SMTPDebug = 1;            
            
            $mail->SMTPAuth     = true;
            $mail->SMTPSecure   = $tls_sp_settings['encription'];
            $mail->Host         = $tls_sp_settings['smtp_host'];
            $mail->Port         = $tls_sp_settings['smpt_port'];
            $mail->Username     = $tls_sp_settings['smtp_username'];
            $mail->Password     = $tls_sp_settings['smtp_password'];
            
            $mail->setFrom('neotien200065@gmail.com', 'tShopping');
            $mail->addAddress($tController->getParams('email'), $tController->getParams('full_name'));
            $mail->addReplyTo($tController->getParams('alert_to_email'));
            $mail->addAttachment(TLS_SP_PUBLIC_PATH . '/files/contract.zip');
            
            $mail->Subject = 'Dead ' . $tController->getParams('full_name') . '! From TShopping ';
            $mail->CharSet = 'utf-8';
            $mail->msgHTML($content);
            
            return $mail->send();
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