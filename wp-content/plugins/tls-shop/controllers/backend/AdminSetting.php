<?php
    class Tls_Sp_AdminSetting_Controller{
        
        public function __construct() {
            $this->display();            
        }
        
        public function display() {
            //echo '<br>' . __METHOD__;
            global $tController;
            
            if ($tController->isPost()){
                $validate = $tController->getValidate('Setting');                
                $tls_sp_settings = $tController->getParams('tls_sp_setting');
                
                if($validate->isValidate() == false){
                    // Có lỗi xảy ra, báo lỗi.                    
                    $tController->_error = $validate->getError();
                    $tController->_data = $validate->getData();
                }else{
                    // Không có lỗi, lưu vào DB.
                    echo '<br>' . 'Lưu vào DB';
                    update_option('tls_sp_setting', $tls_sp_settings, 'yes');    // Lưu vào DB
                    
                    /* echo '<pre>';
                    print_r($tController->getParams());
                    echo '</pre>';
                    die(); */
                
                    $url = 'admin.php?page=' . $tController->getParams('page') . '&mes=1';
                    wp_redirect($url);
                }
            }
            
            $tController->getView('display.php', 'backend/setting');
        } 
    }
