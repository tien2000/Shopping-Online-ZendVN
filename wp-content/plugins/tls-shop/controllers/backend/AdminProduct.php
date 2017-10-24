<?php 
    /* 
     * wp_enqueue_media(): Hàm WP, Bật popup Media.
     * add_filter->manage_posts_columns: Hook thêm cột vào danh sách sản phẩm. 
     * add_filter->manage_edit-tsproduct_sortable_columns: Hook thêm link sort vào cột.
     * add_action->manage_tsproduct_posts_custom_column: Hook đưa giá trị vào cột.
     * add_action->pre_get_posts: 
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
            
            preg_match('#(?:.+\/)(.+)#', $_SERVER['SCRIPT_NAME'],$matches);
            $phpFile = $matches[1];
            
            if ($tController->getParams('post_type') == 'tsproduct'){
                add_action('admin_enqueue_scripts', array($this, 'add_css_file'));
                
                
                if ($phpFile == 'post.php' || $phpFile == 'post-new.php'){
                    add_action('add_meta_boxes', array($this, 'display'));       
                    if ($tController->isPost()){
                        add_action('save_post', array($this, 'save'));
                        add_action('admin_enqueue_scripts', array($this, 'media_button_js_file'));
                    }
                }
                
                if ($phpFile == 'edit.php'){
                    add_filter('manage_posts_columns', array($this, 'add_columns'));
                    
                    add_action('manage_tsproduct_posts_custom_column',
                        array($this, 'display_value_column'), 10, 2);
                    
                    add_filter('manage_edit-tsproduct_sortable_columns', array($this, 'sortable_cols'));
                    
                    add_action('pre_get_posts', array($this, 'modify_query'));
                    
                    add_action('restrict_manage_posts', array($this, 'ts_category_list'));
                }
                
            }
        }
        
        public function ts_category_list(){
            global $tController;
            wp_dropdown_categories(array(
                    'show_option_all'   => __('Show All TS Category'),
                    'taxonomy'          => 'ts-category',
                    'name'              => 'ts-category',
                    'orderby'           => 'name',
                    'selected'          => $tController->getParams('ts-category'),
                    'hierarchical'      => true,
                    'depth'             => 3,
                    'show_count'        => true,
                    'hide_empty'        => true    
                ));
        }
        
        public function modify_query($query){
            global $tController;
            
            // Mặc định sắp xếp theo chiều giảm dần của ID.
            if ($tController->getParams('orderby') == ''){
                $query->set('orderby', 'ID');
                $query->set('order', 'DESC');
            }
            
            $orderby = $query->get('orderby');
            //echo $orderby;
            
            // Sắp xếp trong trường hợp $_GET['orderby'] = view && meta_key = _tls_sp_tsproduct_view  
            if ($orderby == 'view'){
                $query->set('meta_key', $this->create_key('view'));
                $query->set('orderby', 'meta_value_num');
            }
            
            $query->tax_query->queries['0']['field'] = 'term_id';
            
            if ($tController->getParams('ts-category') > 0){
                // ================= Test another case ===================//
                /* $query->tax_query->queries['0']['field'] = 'term_id';
                   $query->tax_query->queries['0']['terms'] = $tController->getParams('ts-category'); */
                // ================= Not Working. ===================//
                
                //Thay đổi giá trị trong đối tượng WP_Tax_Query (Lọc theo Category).
                $tax_query = array(
                        'relation'      => 'OR',
                        array(
                                'taxonomy'      => 'ts-category',
                                'field'         =>  'term_id',
                                'terms'         => $tController->getParams('ts-category')
                            )
                    );                
                $query->set('tax_query', $tax_query);
            }
            
            /* echo '<pre>';
            print_r($query);
            echo '</pre>'; */
        }
        
        public function sortable_cols($column){
            /* echo '<pre>';
            print_r($column);
            echo '</pre>'; */
            
            $column['id'] = 'id';
            $column['view'] = 'view';
            
            return $column;
        }
        
        public function display_value_column($column, $post_id){
            /* echo '<pre>';
            print_r($column);            
            echo '</pre>';            
            echo '<pre>';
            print_r($post_id);
            echo '</pre>'; */

            if ($column == 'id'){
                echo $post_id;
            }
            
            if ($column == 'view'){
                $view = get_post_meta($post_id, $this->create_key('view'), true);
                if ($view == null){
                    update_post_meta($post_id, $this->create_key('view'), 0);
                    echo '0';
                }else {
                    echo $view;
                }                
            }
            
            if ($column == 'category'){
                echo get_the_term_list($post_id, 'ts-category', '', ', ');
            }
        }
        
        
        public function add_columns($columns) {
            /* echo '<pre>';
            print_r($columns);
            echo '</pre>'; */
            
            
            $new_columns = array(
                    'view'  => __('View'),
                    'id'    => __('ID')
                );
            
            
            // ================= Add column Category ============= //
            $newArr = array();
            foreach ($columns as $key => $title){
                $newArr[$key] = $title;
                if ($key == 'author'){
                    $newArr['category'] = __('Category');
                }
            }           
            $newArr = array_merge($newArr, $new_columns);  
            // ================= End of Add column Category ============= //
            
            //$newArr = array_merge($columns, $new_columns);
            
            return $newArr;
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
