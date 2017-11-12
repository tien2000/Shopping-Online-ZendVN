<?php
/*
 Plugin Name: TienLS Shopping
 Plugin URI: http://www.zend.vn
 Description: Xây dựng Shopping Online đơn giản với Wordpress.
 Version: 1.0
 Author: TienLS
 Author URI: http://www.zend.vn
 */

require_once 'define.php';

require_once TLS_SP_INLCUDE_PATH . DS . 'Controller.php';
global $tController;
$tController = new tController();
if(!class_exists('TlsHtml')){
    require_once TLS_SP_INLCUDE_PATH . DS . 'html.php';
}
if(is_admin()){       
    require_once 'backend.php';
    new Tls_Sp_Backend();
    $tController->getHelper('AdminMenu');    
    $tController->getController('AdminCategory', 'backend');
    $tController->getController('AdminProduct', 'backend');
}else{
    global $tls_sp_settings;
    
    $tls_sp_settings = get_option('tls_sp_setting', array());
    
    if (count($tls_sp_settings) == 0){
        $tls_sp_settings = $tController->getConfig('Setting')->get();
    }      
    
    require 'frontend.php';
    new Tls_Sp_Frontend();
}

// =================== Add Session =================== //
add_action('init', 'tls_sp_session_start');

function tls_sp_session_start(){
    if (!session_id()){
        session_start();
    }
}

// =================== Ajax Frontend =================== //
$tController->getController('Ajax', 'frontend');



