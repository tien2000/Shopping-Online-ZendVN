<?php
    class Tls_Sp_AdminShopping_Controller{
        
        public function __construct() {
            ;
        }
        
        public function display() {
            //echo '<br>' . __METHOD__;
            
            global $tController;
            $tController->getView('shopping/display.php', 'backend');
        }
    }
