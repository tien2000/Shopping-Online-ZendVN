<?php
    class Tls_Sp_Backend{
        private $_menuSlug = 'tls-sp-manager';
        private $_page     = '';
        
        public function __construct() {
            //echo '<br>' . __FILE__;
            global $tController;
            
            if(isset($_GET['page'])) $this->_page = $_GET['page'];
            
            add_action('admin_menu', array($this, 'menus'));
            
            if ($this->_page == 'tls-sp-manager-manufactures' || $this->_page == 'tls-sp-manager-settings'){
                add_action('admin_init', array($this, 'do_output_buffer'));
            }
            
            add_action('admin_enqueue_scripts', array($this, 'add_css_file'));
            
            $tController->getHelper('CreatePage');
        }
        
        public function add_css_file(){
            global $tController;
            if($tController->getParams('page') == 'tls-sp-manager-settings'){
                wp_register_style('tls_sp_product_setting_be', $tController->getCssUrl('setting-be'),
                    array(), '1.0');
                wp_enqueue_style('tls_sp_product_setting_be');
            }
        }
        
        public function menus() {
            global $tController;
            $iconUrl = $tController->getImagesUrl('shopping.png', 'icons/');
            
            add_menu_page('tShopping', 'tShopping', 'manage_options', $this->_menuSlug, 
                            array($this, 'dispatch_function'), $iconUrl, 3);
            
            add_submenu_page($this->_menuSlug, 'Dashboard', 'Dashboard', 'manage_options',
                            $this->_menuSlug, array($this, 'dispatch_function'));
            
            add_submenu_page($this->_menuSlug, 'Categories', 'Categories', 'manage_options', 
                                $this->_menuSlug . '-categories', array($this, 'dispatch_function'));
            
            add_submenu_page($this->_menuSlug, 'Products', 'Products', 'manage_options',
                                $this->_menuSlug . '-products', array($this, 'dispatch_function'));
            
            add_submenu_page($this->_menuSlug, 'Manufactures', 'Manufactures', 'manage_options',
                                $this->_menuSlug . '-manufactures', array($this, 'dispatch_function'));
            
            add_submenu_page($this->_menuSlug, 'Invoices', 'Invoices', 'manage_options',
                                $this->_menuSlug . '-invoices', array($this, 'dispatch_function'));
            
            add_submenu_page($this->_menuSlug, 'Settings', 'Settings', 'manage_options',
                                $this->_menuSlug . '-settings', array($this, 'dispatch_function'));
        }
        
        public function dispatch_function() {
            //echo '<br>' . __METHOD__;
            
            global $tController;
            $page = $this->_page;
            
            if ($page == 'tls-sp-manager'){
                $obj = $tController->getController('AdminShopping', 'backend');
                //$obj->display();
            }
            
            if ($page == 'tls-sp-manager-categories'){
                $obj = $tController->getController('AdminCategory', 'backend');
                //$obj->display();
            }
            
            if ($page == 'tls-sp-manager-products'){
                $obj = $tController->getController('AdminProduct', 'backend');
                //$obj->display();
            }
            
            if ($page == 'tls-sp-manager-manufactures'){
                $obj = $tController->getController('AdminManufacture', 'backend');
                //$obj->display();
            }
            
            if ($page == 'tls-sp-manager-invoices'){
                $obj = $tController->getController('AdminInvoice', 'backend');
                $obj->display();
            }
            
            if ($page == 'tls-sp-manager-settings'){
                $obj = $tController->getController('AdminSetting', 'backend');
                //$obj->display();
            }
        }
        
        public function do_output_buffer(){
            ob_start();
        }
    }