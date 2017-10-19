<?php 
    /* 
     * getSlug(): Chỉnh lại đường dẫn khi add hoặc edit
     * 
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
            $table = $wpdb->prefix . 'sp_manufacture';
            $field = $options['field'];     // Cột trong bảng
            
            for ($i = 0; $i < 999; $i++){
                if ( $i >0 ){
                    $newVal = $val . '-' . $i;      // Tạo slug mới khi đã tồn tại slug.
                }
                if (!isset($options['exception'])){
                    $sql = "SELECT COUNT(id) 
                            FROM $table 
                            WHERE $field = '$newVal'";
                    $sql = $wpdb->prepare($sql, '%s', '%s', '%s');
                    $result = $wpdb->get_col($sql);
                } else {
                    $excep_field = $options['exception']['field'];
                    $excep_value = $options['exception']['value'];
                    
                    $sql = "SELECT COUNT(id) 
                            FROM $table 
                            WHERE $field = '$newVal'
                            AND $excep_field != $excep_value";
                    
                    $sql = $wpdb->prepare($sql, '%s', '%s', '%s', '%s', '%s');
                    echo '<br>' . $sql;
                    $result = $wpdb->get_col($sql);
                }
                if ($result[0] == 0) return $newVal;
            }
            
            
        }
    }