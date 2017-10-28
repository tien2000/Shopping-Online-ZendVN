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

if(is_admin()){
    if(!class_exists('TlsHtml')){
        require_once TLS_SP_INLCUDE_PATH . DS . 'html.php';
    }
    
    require_once 'backend.php';
    new Tls_Sp_Backend();
    $tController->getHelper('AdminMenu');    
    $tController->getController('AdminCategory', 'backend');
    $tController->getController('AdminProduct', 'backend');
}else{
    require 'frontend.php';
    new Tls_Sp_Frontend();
}
