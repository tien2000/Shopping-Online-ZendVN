<?php 
    /* 
     * wp_enqueue_media(): Hàm WP, Bật popup Media.
     *  */
?>

<?php
    class Tls_Sp_AdminProduct_Controller{
        
        private $_meta_box_id   = 'tls-sp-tsproduct';
        private $_prefix_key 	= '_tls_sp_tsproduct_';
        private $_prefix_id 	= 'tls-sp-tsproduct-';
        
        public function __construct() {
            //echo '<br>'. __METHOD__;
            global $tController;
            
            $model = $tController->getModel('Product');            
            add_action('init', array($model, 'create'));
            
            if ($tController->getParams('post_type') == 'tsproduct'){
                add_action('add_meta_boxes', array($this, 'display'));
                add_action('admin_enqueue_scripts', array($this, 'add_css_file'));
                add_action('admin_enqueue_scripts', array($this, 'media_button_js_file'));
                
                if ($tController->isPost()){
                    add_action('save_post', array($this, 'save'));
                }
            }
        }       
        
        public function display() {
            add_meta_box($this->_meta_box_id, 'Images of Product', 
                            array($this, 'product_images'), 'tsproduct');
            
            add_meta_box($this->_meta_box_id . '-detail', 'Detail Product',
                array($this, 'detail_product'), 'tsproduct');
        }
        
        public function save($post_id){
            global $tController;
            $arrParams = $tController->getParams();
            $wpnonce_name = $this->_meta_box_id . '-nonce';
            $wpnonce_action = $this->_meta_box_id;
            
            // Kiểm tra bảo mật với wpnonce 
            // tls-sp-tsproduct-nonce            
            if (!isset($arrParams[$wpnonce_name])) return $post_id;            
            if (!wp_verify_nonce($arrParams[$wpnonce_name], $wpnonce_action)) return $post_id;            
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;            
            if (!current_user_can('edit_post')) return $post_id;
            
            /* echo '<br>' . $post_id;
            echo '<pre>';
            print_r($tController->getParams());
            echo '</pre>'; */
            
            $arrData = array(
                'img-ordering'  => array_map('absint', $arrParams[$this->create_id('img-ordering')]),
                'img-url'       => $arrParams[$this->create_id('img-url')],
                'rotate360'     => esc_textarea($arrParams[$this->create_id('rotate360')]),
                'price'         => filter_var($arrParams[$this->create_id('price')], FILTER_VALIDATE_FLOAT),
                'sale-off'      => filter_var($arrParams[$this->create_id('sale-off')], FILTER_VALIDATE_FLOAT),
                'manufacturer'  => absint($arrParams[$this->create_id('manufacturer')]),
                'gift'          => esc_textarea($arrParams[$this->create_id('gift')]),
            );
            
            // Nếu ko tồn tại phần tử 'save' trong $arrParams thì nó đang ở trường hợp Add New.
            if (!isset($arrParams['save'])){
                $arrData['view'] = 0;
            }
            
            foreach ($arrData as $key => $val){
                update_post_meta($post_id, $this->create_key($key), $val);
            }
            
            //die();
        }
        
        public function detail_product() {
            global $tController;
            wp_nonce_field($this->_meta_box_id, $this->_meta_box_id . '-nonce');
            $tController->_data['controller'] = $this;
            
            $tController->getView('detail_product.php', 'backend/product');
        }
        
        public function product_images() {
            global $tController;            
            wp_nonce_field($this->_meta_box_id, $this->_meta_box_id . '-nonce');
            $tController->_data['controller'] = $this;
            
            $tController->getView('product_images.php', 'backend/product');
        }
        
        public function create_key($val){
            return $this->_prefix_key . $val;
        }        
        
        public function create_id($val){
            return $this->_prefix_id . $val;
        }
        
        public function media_button_js_file(){
            global $tController;
            
            wp_enqueue_media();
            
            wp_register_script('tls_sp_product_media_button', $tController->getJSUrl('media_button'), 
                                array('jquery'), '1.0', true);
            wp_enqueue_script('tls_sp_product_media_button');
        }
        
        public function add_css_file() {
            global $tController;
            wp_register_style('tls_sp_product_product_bk', $tController->getCssUrl('product-bk'), 
                                array(), '1.0');
            wp_enqueue_style('tls_sp_product_product_bk');
        }
    }
