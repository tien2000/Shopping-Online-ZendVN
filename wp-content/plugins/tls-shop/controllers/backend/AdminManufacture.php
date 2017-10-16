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
			case 'add'		: $this->add(); break;
			
			case 'edit'		: $this->edit(); break;
			
			case 'delete'	: $this->delete(); break;
			
			case 'active'	: 
			case 'inactive'	:
							  $this->status(); break;
							  
			default      	: $this->display(); break;
		}
	}
        
    public function display(){
        global $tController;
	    //echo '<br/>' . __METHOD__;		
		
		$tController->getView('display.php','backend/manufacturer');
	}
        
        public function add() {
            //echo '<br>' . __METHOD__;
            global $tController;            
            
            if($tController->isPost()){
                $validate = $tController->getValidate('Manufacturer');
                if($validate->isValidate() == false){
                    $tController->_error = $validate->getError();
                    $tController->_data = $validate->getData();
                    
                }else{
                    echo '<br>' . 'Lưu vào DB';
                }
            }
            
            $tController->getView('data_form.php', 'backend/manufacturer');
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
