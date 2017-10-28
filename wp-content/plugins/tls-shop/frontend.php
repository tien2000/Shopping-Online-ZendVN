<?php
    class Tls_Sp_Frontend{
        
        public function __construct() {
            //echo '<br>' . __METHOD__;
            global $tController;
            
            //$model = $tController->getModel('Category');
            
            add_action('init', array($tController->getModel('Category'), 'create'));
            add_action('init', array($tController->getModel('Product'), 'create'));
        }
    }