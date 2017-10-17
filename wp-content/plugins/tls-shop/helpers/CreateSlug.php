<?php 
    /* 
     * $options = array[
     *                'table' => 'sp_manufacture',
     *                'field' => 'slug',
     *                'exception' => 'array('field' => 'id', 'value' => 2)'
     *            ]
     *  */
?>

<?php
    class Tls_Sp_CreateSlug_Helper{
        
        public function getSlug($val = '', $options = array()) {
            global $wpdb, $tController;
            
            //echo '<br>' . __METHOD__;
            /* echo '<pre>';
            print_r($val);
            echo '</pre>'; */
            
            $newVal = $val;
            
            for ($i = 0; $i < 999; $i++){
                if ( $i >0 ){
                    $newVal = $val . '-' . $i;
                }
                $table = $wpdb->prefix . 'sp_manufacture';
                
                $field = $options['field'];     // Cột trong bảng
                
                $sql = "SELECT COUNT(id) FROM $table WHERE $field = '$newVal'";
                $sql = $wpdb->prepare($sql, '%s', '%s', '%s');
                $result = $wpdb->get_col($sql);
                
                if ($result['0'] == 0) return $newVal;
            }
            
            
        }
    }