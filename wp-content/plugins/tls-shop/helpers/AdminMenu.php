<?php
    class Tls_Sp_AdminMenu_Helper{
        
        public function __construct() {
            add_action('admin_menu', array($this, 'modify_admin_menus'));
        }
        
        // ================= Viết lại đường dẫn cho Product & Category =================== //
        public function modify_admin_menus(){
            global $menu, $submenu;
            $tls_sp_manager = $submenu['tls-sp-manager'];
        
            foreach ($tls_sp_manager as $key => $val){
                if($val[2] == 'tls-sp-manager-categories'){
                    $tls_sp_manager[$key][2] = 'edit-tags.php?taxonomy=ts-category&post_type=tsproduct';
                }
                if($val[2] == 'tls-sp-manager-products'){
                    $tls_sp_manager[$key][2] = 'edit.php?post_type=tsproduct';
                }
            }
            $submenu['tls-sp-manager'] = $tls_sp_manager;
            remove_menu_page('edit.php?post_type=tsproduct');
        }
    }