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
                    // Có lỗi xảy ra, báo lỗi.
                    $tController->_error = $validate->getError();
                    $tController->_data = $validate->getData();
                    
                }else{
                    // Không có lỗi, lưu vào DB.
                    //echo '<br>' . 'Lưu vào DB';
                    $model = $tController->getModel('Manufacturer');
                    $model->save_items($validate->getData());
                    
                    $url = 'admin.php?page=' . $_REQUEST['page'] . '&mes=1';
                    wp_redirect($url);
                }
            }
            
            $tController->getView('data_form.php', 'backend/manufacturer');
        }
        
        public function edit() {
            //echo '<br>' . __METHOD__;
            global $tController;
            
            if($tController->isPost() == false){
                $model = $tController->getModel('Manufacturer');
                $tController->_data = $model->getItem($tController->getParams());
                
                /* echo '<pre>';
                print_r($tController->_data);
                echo '</pre>'; */
            }else {
                $validate = $tController->getValidate('Manufacturer');
                if($validate->isValidate() == false){
                    // Có lỗi xảy ra, báo lỗi.
                    $tController->_error = $validate->getError();
                    $tController->_data = $validate->getData();
                
                }else{
                    // Không có lỗi, lưu vào DB.
                    //echo '<br>' . 'Lưu vào DB';
                    $model = $tController->getModel('Manufacturer');
                    $model->save_items($validate->getData());
                
                    $url = 'admin.php?page=' . $_REQUEST['page'] . '&mes=1';
                    wp_redirect($url);
                }
            }
            
            $tController->getView('data_form.php', 'backend/manufacturer');
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
