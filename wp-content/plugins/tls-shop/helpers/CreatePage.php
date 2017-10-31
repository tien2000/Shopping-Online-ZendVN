<?php 
    /* 
     * page_attributes_dropdown_pages_args: Hook hiển thị template page trong dropdown của Page Attributes.
     * get_theme_root(): Lấy đường dẫn chứa theme.
     * get_stylesheet(): Lấy tên theme.
     * wp_get_theme(): Gọi đối tượng WP_Theme
     * 
     * wp_insert_post_data: Hook lưu dữ liệu mới vào DB.
     *  */
?>

<?php
    class Tls_Sp_CreatePage_Helper{
    	
    	private $_templatePage;
    	
    	public function __construct(){    
    		add_filter('page_attributes_dropdown_pages_args', array($this,'register_template'));
    		
    		add_filter('wp_insert_post_data', array($this,'register_template'));
    		
    		$this->_templatePage = array(
    		    'page-tlsshopping.php' => 'Show all products',
    		    'page-tlscart.php'     => 'TShopping cart'
    		);
    	}
    	
    	public function register_template($attrs){
    		//echo '<br/>' . __METHOD__;
    	    /* echo '<br/>' . get_theme_root();
    	    echo '<br/>' . get_stylesheet(); */
    	    
    		$cache_key = 'page_templates-' . md5(get_theme_root() . '/' . get_stylesheet());
    		
    		//echo '<br/>' . $cache_key;
    		
    		$templates = wp_get_theme()->get_page_templates();
    		
    		$templates = array_merge($templates, $this->_templatePage);
    		
    		echo '<pre>';
    		print_r($templates);
    		echo '</pre>';
    		
    		wp_cache_delete($cache_key, 'themes');
    		
    		wp_cache_add($cache_key, $templates, 'themes', 1800);
    		
    		return $attrs;
    	}
    }