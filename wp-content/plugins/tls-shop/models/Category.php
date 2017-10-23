<?php
    class Tls_Sp_Category_Model{
        
        public function create() {
            $labels = array(
                'name'          => 'TS Categories',
                'singular'      => 'TS Category',
                'menu_name'     => 'TS Categories',
                //'all_items'     => chưa xác định
                //'view_item'     => chưa xác định
                'edit_item'     => 'Edit TS Category',
                'update_item'   => 'Update TS Category',
                'add_new_item'  => 'Add New TS Category',
                //'new_item_name'     => chưa xác định
                //'parent_item'     => chưa xác định
                //'parent_item_colon'     => chưa xác định
                'search_items'  => 'Search TS Category',
                'popular_items' => 'Popular TS Category',
                'separate_items_with_commas'    => 'Separate tags with commas',
                'choose_from_most_used'         => 'Choose from the most used tags',
                'not_found'                     => 'No Categories found'
            );
            
            $args = array(
                'labels'            => $labels,
                'public'            => true,
                //'show_ui'           => true, // Mặc định theo public, chọn false sẽ hide.
                //'show_in_menu'      => true, // Chọn false sẽ hide ở menu nhưng vẫn chạy ('show_ui' phải true).
                'show_in_nav_menus' => true, // Mặc định theo public, chọn false sẽ hide ở Appearance-Menu.
                'show_tagcloud'     => true, // Chọn true sẽ thêm tùy chọn Custom Taxonomy vào thẻ Tag trong Widget.
                'hierarchical'      => true, // Chọn true sẽ chuyển định dạng từ Tag sang Category (để phân cấp cho Custom Taxonomy).
                'show_admin_column' => true, // Chọn true sẽ thêm 1 cột Custom Taxonomy ở All Post (hoặc Page).
                'query_var'         => true, /*  Mặc định true. Lưu ý: Không nên thay đổi vì khi thay đổi sẽ phải viết 
                                                   lại câu truy vấn để hiển thị các giá trị ở phần Font-end, nên để WP tự xử lý. */
                'rewrite'           => array('slug' => 'ts-category')
            );
            
            register_taxonomy('ts-category', 'tsproduct', $args);
        }
    }