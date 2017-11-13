<?php
    class Tls_Sp_DetailInvoices_Model{
        
        public function __construct() {
            ;
        }
        
    // ================== Được gọi vào frontend/Cart.php hàm send_mail() ==================== //
        public function save_items($arrData = array(), $options = array()){
            //echo '<br>' . __METHOD__;
            
            global $tController, $wpdb;
            
            $meta_key   = '_tls_sp_tlsproduct_';
            
            $tlsSs 	    = $tController->getHelper('Session');
            $tlsSsCart  = $tlsSs->get('tcart',array());
            $idArr      = array_keys($tlsSsCart);
            
            $table      = $wpdb->prefix . 'sp_detail_invoices';
            $action = $options['action'];
            
            if ($action == 'add'){
                if (count($idArr) > 0){
                    $args = array(
                        'post_type'    => 'tlsproduct',
                        'post__in'      => $idArr
                    );
                
                    $wpQuery = new WP_Query($args);
            
                    while ($wpQuery->have_posts()){
                        $wpQuery->the_post();
                        $post    = $wpQuery->post;
                        $postID  = $post->ID;
                        $quality = $tlsSsCart[$postID];
                        
                        $data['invoice_id'] = $arrData['invoices_id'];
                        $data['product_id'] = $postID;
                
                        $price   = get_post_meta($postID, $meta_key . 'price', true);                
                        $saleOff = get_post_meta($postID, $meta_key . 'sale-off', true);
                
                        if (absint($saleOff) > 0){
                            $price = $saleOff;
                        }                                               
                        
                        $data['price']      = $price;
                        $data['quality']    = $quality;
                        
                        $format = array('%d', '%d', '%s', '%d');
                        $wpdb->insert($table, $data, $format);
                        
                        $tlsSs->set('tcart', array());
                    }
                }
            }
        }
    }