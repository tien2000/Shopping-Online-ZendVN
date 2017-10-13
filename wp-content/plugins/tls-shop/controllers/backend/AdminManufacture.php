<?php 
    /* 
     * dispatch_function(): Hàm điều hướng những hàm khác
     *  */
?>

<?php
    class Tls_Sp_AdminManufacture_Controller{
        
        public function __construct() {
            $this->dispatch_function();
        }
        
        public function dispatch_function(){
            global $tController;
            echo $tController->getParams('action');
        }
        
        public function display() {
            echo '<br>' . __METHOD__;
        }
        
        public function add() {
            echo '<br>' . __METHOD__;
        }
        
        public function edit() {
            echo '<br>' . __METHOD__;
        }
        
        public function delete() {
            echo '<br>' . __METHOD__;
        }
        
        public function status() {
            echo '<br>' . __METHOD__;
        }
        
        public function no_access() {
            echo '<br>' . __METHOD__;
        }
    }
