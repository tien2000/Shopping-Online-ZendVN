<?php
    if(!class_exists('WP_List_Table')){
        require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
    }

    class Tls_Sp_Manufacturer_Model extends WP_List_Table{
        private $_per_page = 5;
        private $_sql;
        
        public function __construct() {
           // echo '<br>' . __METHOD__;
           $args = array(
                        'plural'    => 'id',       
                        'singular'  => 'id',       
                        'ajax'      => false,
                        'screen'    => null,
                    );
           parent::__construct($args);
        }
        
        public function prepare_items() {
            $hidden     = $this->get_hidden_columns();
            $sortTable  = $this->get_sortable_columns();
            $columns     = $this->get_columns();        
            
            $this->_column_headers = array($columns, $hidden, $sortTable);
            $this->items = $this->table_data();
            
            $total_items = $this->total_items();
            $per_page = $this->_per_page;
            $total_pages = ceil($total_items/$per_page);
            
            $this->set_pagination_args(array(
                'total_items' => $total_items,
                'per_page' => $per_page,
                'total_pages' => $total_pages,        
            ));
        }
        
        /* public function get_bulk_actions(){
            $action = array(
                'delete'    => 'Delete',
                'active'    => 'Active',
                'inactive'  => 'Inactive'
            );
        
            return $action;
        } */
        
        public function column_name($item){
        
            global $tController;
        
            $page = $tController->getParams('page');
        
            $name = 'security_code';
        
            $lnkDelete =  add_query_arg(array('action'=>'delete','id'=>$item['id']));
            $action 	= 'delete_id_' . $item['id'];
            $lnkDelete = wp_nonce_url($lnkDelete,$action,$name);
        
            $actions = array(
                'edit' 		=> '<a href="?page=' . $page . '&action=edit&id=' . $item['id'] . '">Edit</a>',
                'delete' 	=> '<a href="' . $lnkDelete . '">Delete</a>',
                'view' 		=> '<a href="#">View</a>'
            );
        
            $html = '<strong><a href="?page=' . $page . '&action=edit&id=' . $item['id'] . '">' . $item['name'] .'</a></strong>'
                        . $this->row_actions($actions);
            
            return $html;
        }
        
        public function column_cb($item){
            $singular = $this->_args['singular'];
            $cb = '<input type="checkbox" name="'.$singular.'[]" value="'.$item['id'].'"/>';
            return $cb;
        }
        
        public function column_default( $item, $column_name ) {        
            return $item[$column_name];
        }

        private function total_items(){
            global $wpdb;
            return $wpdb->query($this->_sql);
        }
        
        private function table_data(){
            $data = array();
            global $wpdb, $tController;
        
            //&orderby=title&order=asc
            $orderby            = ($tController->getParams('orderby') == '')?'id':$_GET['orderby'];
            $order              = ($tController->getParams('order') == '')?'DESC':$_GET['order'];
            
            $tblManufacturer    = $wpdb->prefix . 'sp_manufacture';
            $sql                = 'SELECT m.* FROM ' . $tblManufacturer . ' AS m ';
        
            //========== Lọc theo status hoặc search hoặc cả 2 =============//
            $whereArr = array();        
            
            if($tController->getParams('filter_status') != ''){
                $status = ($tController->getParams('filter_status') == 'active')?1:0;
                $whereArr[] = " (m.status = $status) ";                
            }
        
            if($tController->getParams('s') != ''){
                $s = esc_sql($tController->getParams('s'));
                $whereArr[] = " (m.name LIKE '%$s%') ";
            }
        
            if(count($whereArr) > 0){
                $sql .= " WHERE " . join(" AND ", $whereArr);
            }
        
            $sql .= ' ORDER BY m.' . esc_sql($orderby) . ' ' . esc_sql($order);
            
            $this->_sql = $sql;
            
            $paged = max(1, @$_REQUEST['paged']);
            $offset = ($paged - 1) * $this->_per_page;
            
            $sql .= ' LIMIT ' . $this->_per_page . ' OFFSET ' . $offset;
        
            $data = $wpdb->get_results($sql, ARRAY_A);
        
            return $data;
        }
        
        public function get_columns() {
            $columns = array(
                'cb'        => '<input type="checkbox" />',                
                'name'      => 'Name',
                'slug'    => 'Slug',
                'status'        => 'Status',
                'id'      => 'ID',
            );
            return $columns;
        }
        
        public function get_hidden_columns(){
            return array();
        }
        
        public function get_sortable_columns(){
            $sortTable = array(
                'name'     => array('name', true),    // Tạo mũi tên sắp xếp cho Title, Id
                'id'        => array('id', true),        // false: mũi tên lên, true: mũi tên xuống
            );
            return $sortTable;
        }
    }