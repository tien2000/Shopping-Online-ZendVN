<?php
    class Tls_Sp_Manufacturer2_Model{
        
        //array('status'=> 1), array('type' => 'all')        
        public function getItem($arrData = array(), $options = array()){
            global $wpdb;
            $table = $wpdb->prefix . 'sp_manufacture';
            
            /* echo '<pre>';
            print_r($arrData);
            echo '</pre>'; */
            
            if (isset($options['type']) && $options['type'] == 'all'){
                // Nếu tồn tại status thì lấy giá trị status (status=1), ko thì lấy tất cả status (status = 1 và 0)
                $status = (isset($arrData['status']))?absint($arrData['status']):'all';
                
                $sql = "SELECT * FROM $table";
                if ($status != 'all'){
                    $sql .= " WHERE status = $status ORDER BY name ASC";
                }
                $result = $wpdb->get_results($sql, ARRAY_A);
            }else {
                $id = absint($arrData['id']);
                $sql = "SELECT * FROM $table WHERE id = $id";
                $result = $wpdb->get_row($sql, ARRAY_A);           // ARRAY_A: Biến đối tượng thành mảng
            }
            return $result;
        }
    }
    
    
    
    