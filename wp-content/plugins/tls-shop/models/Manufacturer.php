<?php 
    /* 
     * array_map($callback, array $array1, array $_): Biến các phần tử bên trong mảng được chọn thành số nguyên.
     *  */
?>

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
            $columns    = $this->get_columns();        
            
            $this->_column_headers = array($columns, $hidden, $sortTable);
            $this->items = $this->table_data();
            
            $total_items = $this->total_items();
            $per_page    = $this->_per_page;
            $total_pages = ceil($total_items/$per_page);
            
            $this->set_pagination_args(array(
                'total_items' => $total_items,
                'per_page'    => $per_page,
                'total_pages' => $total_pages,        
            ));
        }
        
        public function get_bulk_actions(){
            $action = array(
                'delete'    => 'Delete',
                'active'    => 'Active',
                'inactive'  => 'Inactive'
            );
        
            return $action;
        }
        
        protected function extra_tablenav($which){
            /* echo '<pre>';
             print_r($which);
             echo '</pre>'; */
        
            if($which == 'top'){
                $htmlObj = new TlsHtml();
                $filterVal = @$_REQUEST['filter_status'];
                $options['data'] = array(
                    '0'         => 'Status filter',
                    'active'    => 'Active',
                    'inactive'  => 'Inactive',
                );
        
                $attr = array(
                    'id'    => 'filter_action',
                    'class' => 'button'
                );
        
                $btnFilter = $htmlObj->button('filter_action', 'Filter', $attr);
                $slbFilter = $htmlObj->selectbox('filter_status', $filterVal, array(), $options);
        
                $html = '<div class="alignleft actions bulkactions">'
                        . $slbFilter
                        . $btnFilter
                        . '</div>';
        
                    echo $html;
            }
        }
        
        public function column_status( $item ){
            global $tController;
            $page  = $tController->getParams('page');
            $paged = max(1, @$_REQUEST['paged']);       //Phân trang
        
            if($item['status'] == 1){
                $action = 'inactive';
                $src    = $tController->getImagesUrl('active.png', 'icons/');
            }else{
                $action = 'active';
                $src    = $tController->getImagesUrl('inactive.png', 'icons/');
            }
        
            $lnkStatus = add_query_arg(array('action' => $action, 
                                        'id' => $item['id'], 'paged' => $paged));
            
            $action     = $action . '_id_' . $item['id'];
            $name       = 'security_code';
            $lnkStatus  = wp_nonce_url($lnkStatus, $action, $name);        
        
            $html = '<img src=' . $src . ' />';                    
            $html = '<a href="' . $lnkStatus .'">'.$html.'</a>';
        
            return $html;
        }
        
        public function column_name($item){
        
            global $tController;
        
            $page = $tController->getParams('page');        
            $name = 'security_code';
        
            $lnkDelete  =  add_query_arg(array('action'=>'delete','id'=>$item['id']));
            $action 	= 'delete_id_' . $item['id'];
            $lnkDelete  = wp_nonce_url($lnkDelete,$action,$name);
        
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
                $whereArr[] = " (m.name LIKE '%$s%' OR m.slug LIKE '%$s%') ";
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
        
        public function deleteItem($arrData = array(), $options = array()){
            global $wpdb;
            $table    = $wpdb->prefix . 'sp_manufacture';
            
            if (!is_array($arrData['id'])){
                $where = array('id' => absint($arrData['id']));
                $wpdb->delete($table, $where);
            }else {
                $arrData['id'] = array_map('absint', $arrData['id']);
                $ids = join(',', $arrData['id']);
            
                $sql = "DELETE FROM $table WHERE id IN ($ids)";            
                $wpdb->query($sql);
            }
        }
        
        public function changeStatus($arrData = array(), $options = array()){
            global $wpdb;
            
            /* echo '<pre>';
            print_r($arrData);
            echo '</pre>'; */
            
            $status = ($arrData['action'] == 'active')?1:0;
            $table    = $wpdb->prefix . 'sp_manufacture';
            
            if (!is_array($arrData['id'])){
                $data = array('status' => absint($status));
                $where = array('id' => absint($arrData['id']));
                $wpdb->update($table, $data, $where);
            }else {
                $arrData['id'] = array_map('absint', $arrData['id']);
                $ids = join(',', $arrData['id']);
                //echo '<br>' . $ids;
                
                $sql = "UPDATE $table SET status = $status WHERE id IN ($ids)";                
                $wpdb->query($sql);
            }
        }        
        
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
        
        public function get_columns() {
            $columns = array(
                'cb'        => '<input type="checkbox" />',                
                'name'      => 'Name',
                'slug'      => 'Slug',
                'status'    => 'Status',
                'id'        => 'ID',
            );
            return $columns;
        }
        
        public function get_hidden_columns(){
            return array();
        }
        
        public function get_sortable_columns(){
            $sortTable = array(
                'name' => array('name', true),      // Tạo mũi tên sắp xếp cho Title, Id
                'id'   => array('id', true),        // false: mũi tên lên, true: mũi tên xuống
            );
            return $sortTable;
        }
        
        public function save_items($arrData = array() , $options = array()){
            global $wpdb, $tController;
            
            $slug = '';
            $action = $arrData['action'];
            
            if (empty($arrData['slug'])){
                $slug = sanitize_title($arrData['name']);
            }else {
                $slug = sanitize_title($arrData['slug']);
            }
            
            $slugHelper = $tController->getHelper('CreateSlug');
            
            if ($action == 'add'){
                $optionSlug  = array('table' => 'sp_manufacture', 'field' => 'slug');
            }else if ($action == 'edit'){
                $optionSlug  = array('table' => 'sp_manufacture', 
                                     'field' => 'slug',
                                     'exception' => array('field' => 'id', 
                                                          'value' => absint($arrData['id'])
                                                    )
                                 );
            }
            
            $slug  = $slugHelper->getSlug($slug, $optionSlug);

            $table = $wpdb->prefix . 'sp_manufacture';
            $data  = array(
                        'name'   => $arrData['name'],
                        'slug'   => $slug,
                        'status' => $arrData['status']
                    );
            $format = array('%s','%s','%s','%d');
            
            if ($action == 'add'){
                $wpdb->insert($table, $data, $format);
            }
            if ($action == 'edit'){
                $where = array('id' => absint($arrData['id']));
                $wpdb->update($table, $data, $where);
            }
        }
    }
    
    
    
    