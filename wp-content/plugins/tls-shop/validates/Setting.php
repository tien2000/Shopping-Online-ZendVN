<?php
    class Tls_Sp_Setting_Validate{
        private $_errors = array();        
        private $_data   = array();
        
        public function isValidate($options = array()) {
            global $tController;
            
            $flag = false;            
            
            $tls_sp_settings = $tController->getParams('tls_sp_setting');
            
            // =========== Kiểm tra Input 'Price' =============//
            $product_number = $tls_sp_settings['product_number'];
            if (!absint($product_number) || mb_strlen($product_number) < 1){
                $this->_errors['product_number'] = __('Product_number: Value must be number or must be greater than 1 character');
                $this->_data['product_number'] = '';
            }
            
            // =========== Kiểm tra Input 'currency_unit' =============//
            $currency_unit = $tls_sp_settings['currency_unit'];
            if (mb_strlen($currency_unit) < 2 || absint($currency_unit)){
                $this->_errors['currency_unit'] = __('Currency Unit: Value must be greater than 1 character');
                $this->_data['currency_unit'] = '';
            }
            
            // =========== Kiểm tra Input 'payment' =============//
            /* $payment = $tls_sp_settings['payment'];
            if (!isset($payment)){
                $this->_errors['payment'] = __('Payment: Value must be greater than 1 character');
                $this->_data['payment'] = '';
            } */
            
            // =========== Kiểm tra Input 'alert_to_email' =============//
            $alert_to_email = $tls_sp_settings['alert_to_email'];
            if (mb_strlen($alert_to_email) < 2){
                $this->_errors['alert_to_email'] = __('Email: Value must be greater than 1 character');
                $this->_data['alert_to_email'] = '';
            }
            
            // =========== Kiểm tra Input 'select_type' =============//
            $select_type = $tls_sp_settings['select_type'];
            if (!isset($select_type)){
                $this->_errors['select_type'] = __('Email type: Email type must be choise');
                $this->_data['select_type'] = '';
            }
            
            // =========== Kiểm tra Input 'email_address' =============//
            $email_address = $tls_sp_settings['email_address'];
            if (mb_strlen($email_address) < 2){
                $this->_errors['email_address'] = __('Email: Value must be greater than 1 character');
                $this->_data['email_address'] = '';
            }
            
            // =========== Kiểm tra Input 'from_name' =============//
            $from_name = $tls_sp_settings['from_name'];
            if (mb_strlen($from_name) < 2){
                $this->_errors['from_name'] = __('From name: Value must be greater than 1 character');
                $this->_data['from_name'] = '';
            }
            
            // =========== Kiểm tra Input 'smtp_host' =============//
            $smtp_host = $tls_sp_settings['smtp_host'];
            if (mb_strlen($smtp_host) < 2){
                $this->_errors['smtp_host'] = __('SMTP Host: Value must be greater than 1 character');
                $this->_data['smtp_host'] = '';
            }
            
            // =========== Kiểm tra Input 'encription' =============//
            $encription = $tls_sp_settings['encription'];
            if (!isset($encription)){
                $this->_errors['encription'] = __('Encription: Value must be greater than 1 character');
                $this->_data['encription'] = '';
            }
            
            // =========== Kiểm tra Input 'smpt_port' =============//
            $smpt_port = $tls_sp_settings['smpt_port'];
            if (mb_strlen($smpt_port) < 2){
                $this->_errors['smpt_port'] = __('SMTP Port: Value must be greater than 1 character');
                $this->_data['smpt_port'] = '';
            }
            
            // =========== Kiểm tra Input 'smtp_auth' =============//
            $smtp_auth = $tls_sp_settings['smtp_auth'];
            if (!isset($smtp_auth)){
                $this->_errors['smtp_auth'] = __('SMTP Auth: Value must be greater than 1 character');
                $this->_data['smtp_auth'] = '';
            }
            
            // =========== Kiểm tra Input 'smtp_username' =============//
            $smtp_username = $tls_sp_settings['smtp_username'];
            if (mb_strlen($smtp_username) < 2){
                $this->_errors['smtp_username'] = __('SMTP Username: Value must be greater than 1 character');
                $this->_data['smtp_username'] = '';
            }
            
            // =========== Kiểm tra Input 'smtp_password' =============//
            $smtp_password = $tls_sp_settings['smtp_password'];
            if (mb_strlen($smtp_password) < 2){
                $this->_errors['smtp_password'] = __('SMTP Password: Value must be greater than 1 character');
                $this->_data['smtp_password'] = '';
            }
            
            if (count($this->_errors) == 0){
                $flag = true;
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