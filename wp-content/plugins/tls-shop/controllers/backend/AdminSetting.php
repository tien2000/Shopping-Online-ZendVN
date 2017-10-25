<?php
    class Tls_Sp_AdminSetting_Controller{
        
        public function __construct() {
            $this->display();            
        }
        
        public function display() {
            //echo '<br>' . __METHOD__;
            global $tController;
            
            if ($tController->isPost()){
                $tls_sp_setting = $tController->getParams('tls_sp_setting');
                update_option('tls_sp_setting', $tls_sp_setting, 'yes');    // Lưu vào DB
                
                $url = 'admin.php?page=' . $tController->getParams('page') . '&mes=1';
                wp_redirect($url);
                
                /* echo '<pre>';
                print_r($tController->getParams());
                echo '</pre>'; */
            }
            
            $tController->getView('display.php', 'backend/setting');
        }        
        
        
    }
