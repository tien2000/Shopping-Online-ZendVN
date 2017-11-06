<?php
    class Tls_Sp_Ajax_Controller{
        
        public function __construct() {
            add_action('wp_ajax_add_to_cart', array($this, 'add_to_cart'));
            //add_action('wp_ajax_nopriv_add_to_cart', array($this, 'add_to_cart'));  // Bổ sung thêm nếu ajax ko hoạt động.
            
            add_action('wp_ajax_update_cart', array($this, 'update_cart'));
            
            add_action('wp_enqueue_scripts', array($this, 'add_js_file'));
            add_action('wp_head', array($this, 'add_ajax_library'));
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
        
        public function add_js_file(){
            global $tController;
            
            $pageID = $tController->getHelper('GetPageId')->get('_wp_page_template', 'page-tlscart.php');
            if (get_query_var('tlsproduct') != '' || $pageID != false){
                wp_register_script('tls_sp_add_to_cart', $tController->getJSUrl('ajax_add_cart'),
                    array('jquery'), '1.0', true);
                wp_enqueue_script('tls_sp_add_to_cart');
                
                wp_register_script('tls_sp_accounting', $tController->getJSUrl('accounting.min'),
                    array('jquery'), '1.0', true);
                wp_enqueue_script('tls_sp_accounting');
            }
        }
        
        // ========== Ajax trong WP ko hoạt động ở frontend nên phải add admin-ajax.php vào ================== //
        public function add_ajax_library(){
            $ajax_nonce = wp_create_nonce('ajax-security-code');
        
            $html = '<script type="text/javascript">';
            $html .= ' var ajaxurl = "' . admin_url('admin-ajax.php') . '"; ';
            $html .= ' var security_code = "' . $ajax_nonce . '"; ';
            $html .= '</script>';
        
            echo $html;
        }
    }