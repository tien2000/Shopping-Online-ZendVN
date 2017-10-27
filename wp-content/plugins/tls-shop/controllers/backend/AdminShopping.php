<?php
    class Tls_Sp_AdminShopping_Controller{
        
        public function __construct() {
            $this->display();
        }
        
        public function display() {
            //echo '<br>' . __METHOD__;
            
            global $tController;            
            $tController->getView('display.php', 'backend/shopping');
        }
    }
