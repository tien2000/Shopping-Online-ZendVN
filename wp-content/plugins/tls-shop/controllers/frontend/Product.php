<?php
    class Tls_Sp_Product_Controller{
        
        public function __construct() {
            $this->dispath_function();
        }
        
        public function dispath_function(){
            global $tController;
            $action = $tController->getParams('action');
            
            switch ($action){
                default         : $this->display(); break;
                case 'add_cart' : $this->add_cart(); break;
            }
        }
        
        public function add_cart(){
            //echo '<br>' . __METHOD__;
            
            global $tController;      
            
            $id    = (int)$tController->getParams('id');            
            if ($id > 0){
                $tlsSs = $tController->getHelper('Session');
                
                $tlsSsCart = $tlsSs->get('tcart', array());
                
                if (count($tlsSsCart) == 0){
                    $tlsSsCart[$id] = 1;
                }else {
                    if (!isset($tlsSsCart[$id])){
                        $tlsSsCart[$id] = 1;
                    }else {
                        $tlsSsCart[$id] = $tlsSsCart[$id] + 1;
                    }
                }                
                $tlsSs->set('tcart', $tlsSsCart);
            }
            $url = site_url('?tlsproduct=' . get_query_var('tlsproduct'));
            wp_redirect($url);
            
            /* echo '<pre>';
            print_r($tlsSs->get('tcart'));
            echo '</pre>'; */
        }
        
        public function display(){
            global $tController;
            
            $tController->getView('display.php', 'frontend/product');
        }
        
    }