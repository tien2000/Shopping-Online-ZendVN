<?php
    class Tls_Sp_AdminCategory_Controller{
        
        public function __construct() {
            ;
        }
        
        public function display() {
            //echo '<br>' . __METHOD__;
            
            global $tController;
            
            $tController->getCssUrl('style');
            $tController->getJSUrl('abc');
            
            $tController->getView('category/display.php', 'backend');
        }
    }
