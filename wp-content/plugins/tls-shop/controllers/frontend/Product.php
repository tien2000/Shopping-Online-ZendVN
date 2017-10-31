<?php
    class Tls_Sp_Product_Controller{
        
        public function __construct() {
            $this->display();
        }
        
        public function display(){
            global $tController;
            
            $tController->getView('display.php', 'frontend/product');
        }
        
    }