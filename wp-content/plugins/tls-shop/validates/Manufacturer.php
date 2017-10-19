<?php
    class Tls_Sp_Manufacturer_Validate{
        private $_errors = array();        
        private $_data   = array();
        
        public function isValidate($options = array()) {
            global $tController;
            
            $flag = false;
            
            $action = $tController->getParams('action');
            if(check_admin_referer($action, 'security_code')){
                $this->_data = $tController->getParams();
                
                // =========== Kiểm tra Input 'name' =============//
                $name = $tController->getParams('name');
                if (mb_strlen($name) < 2){
                    $this->_errors['name'] = __('Manufacturer name: Value must be greater than 1 character');
                    $this->_data['name'] = '';
                }
                
                // =========== Kiểm tra Input 'slug' =============//
                $slug = $tController->getParams('slug');
                if (!empty($slug)){
                    $this->_data['slug'] = sanitize_title($slug);
                }
                
                if (count($this->_errors) == 0){
                    $flag = true;
                }
            }
            
            return $flag;
        }
        
        public function getError($name = ''){
            if(empty($name)){
                return $this->_errors;
            }else{
                return (isset($this->_errors[$name])?$this->_errors[$name]:'');
            }
        }
        
        public function getData($name = ''){
            if(empty($name)){
                return $this->_data;
            }else{
                return (isset($this->_data[$name])?$this->_data[$name]:'');
            }
        }
    }