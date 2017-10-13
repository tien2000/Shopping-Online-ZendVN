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
            
            $action = $tController->getParams('action');
            switch ($action){
                case 'add'      : $this->add(); break;
                case 'edit'     : $this->edit(); break;
                case 'delete'   : $this->delete(); break;
                
                case 'active'   : 
                case 'inactive' : $this->status(); break;
                
                default         : $this->display(); break;
            }
        }
        
        public function display() {
            //echo '<br>' . __METHOD__;
            global $tController;
            
            $tController->getView('display.php', 'backend/manufacturer');            
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
