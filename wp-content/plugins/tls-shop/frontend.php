<?php 
    /* 
     * template_include: Filter Hook hiển thị $wp_query (ko hiển thị được trong __construct)
     *  */
?>

<?php
    class Tls_Sp_Frontend{
        
        private $_cssFlag = false;
        
        public function __construct() {
            //echo '<br>' . __METHOD__;
            global $tController;             
            
            //$model = $tController->getModel('Category');
            
            add_action('init', array($tController->getModel('Category'), 'create'));
            add_action('init', array($tController->getModel('Product'), 'create'));
            add_action('wp_enqueue_scripts', array($this, 'add_css_file'));
            add_filter('template_include', array($this, 'load_template'));          
        }
        
        public function add_css_file(){
            if ($this->_cssFlag == true){
                global $tController;
                wp_register_style('tls_sp_product_fe', $tController->getCssUrl('product_fe'), array(), '1.0');
                wp_enqueue_style('tls_sp_product_fe');
            }
        }
        
        public function load_template($templates) {
            global $wp_query, $post;
            
            echo '<br>is_page: ' . is_page();       // Nếu là page thì hiển thị giá trị 1.
            if(is_page() == 1){
                /* echo '<pre>';
                print_r($post);
                echo '</pre>'; */
                
                $page_template = get_post_meta($post->ID, '_wp_page_template', true);
                
                $file = TLS_SP_TEMPLATE_PATH . '/frontend/' . $page_template;                
                if(file_exists($file)){
                    $this->_cssFlag = true;
                    return $file;
                }
            }
            
            if (get_query_var('tls-category') != ''){
                $file = TLS_SP_TEMPLATE_PATH . '/frontend/' . 'tls-category.php';
                if(file_exists($file)){
                    $this->_cssFlag = true;
                    return $file;
                }
            }
            
            if (get_query_var('tlsproduct') != ''){
                $file = TLS_SP_TEMPLATE_PATH . '/frontend/' . 'tlsproduct.php';
                if(file_exists($file)){
                    $this->_cssFlag = true;
                    return $file;
                }
            }
            
            /* echo '<br>get_query_var(tls-category): ' . get_query_var('tls-category');
            echo '<br>get_query_var(tlsproduct): ' . get_query_var('tlsproduct'); */
            
            /* echo '<pre>';
            print_r($wp_query);
            echo '</pre>'; */
            
            return $templates;      // Hiển thị lại giao diện fontend
        }
    }