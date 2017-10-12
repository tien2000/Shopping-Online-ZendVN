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
    require_once 'backend.php';
    new Tls_Sp_Backend();
}else{
    require 'frontend.php';
    new Tls_Sp_Frontend();
}

$tController->getController('AdminProduct', 'backend');
$tController->getController('AdminCategory', 'backend');