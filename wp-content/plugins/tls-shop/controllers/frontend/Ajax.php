<?php
    class Tls_Sp_Ajax_Controller{
        
        public function __construct() {
            add_action('wp_ajax_add_to_cart', array($this, 'add_to_cart'));
            add_action('wp_ajax_nopriv_add_to_cart', array($this, 'add_to_cart'));  // Bổ sung thêm nếu ajax ko hoạt động.
            
            add_action('wp_ajax_update_cart', array($this, 'update_cart'));
            add_action('wp_ajax_nopriv_update_cart', array($this, 'update_cart'));
            
            add_action('wp_ajax_delete_cart', array($this, 'delete_cart'));
            add_action('wp_ajax_nopriv_delete_cart', array($this, 'delete_cart'));
            
            add_action('wp_enqueue_scripts', array($this, 'add_js_file'));
            add_action('wp_head', array($this, 'add_ajax_library'));
        }
        
        // ================ Find in Controller Ajax ================ //        
        public function delete_cart(){
            global $tController;
            $tController->getController('Cart', 'frontend');
            die();
        }
        
        public function update_cart(){
            global $tController;
            $tController->getController('Cart', 'frontend');
            die();
        }
        
        public function add_to_cart(){
            global $tController;
            $tController->getController('Cart', 'frontend');
            die();
        }
        // ======================================================== //
        
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