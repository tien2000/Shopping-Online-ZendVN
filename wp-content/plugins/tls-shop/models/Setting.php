<?php
if(!class_exists('WP_List_Table')){
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

    class Tls_Sp_Setting_Model extends WP_List_Table{
    
        public function __construct() {
            // echo '<br>' . __METHOD__;
            
        }
    }