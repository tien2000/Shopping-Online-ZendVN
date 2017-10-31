<?php
    class Tls_Sp_Product_Model{
        
        public function getAllProduct(){
            global $tls_sp_setting;
            
            $paged = max(1, get_query_var('paged'));
            $offset = ($paged - 1)* $tls_sp_setting['product_number'];
            $args = array(
                'post_type' => 'tlsproduct',
                'posts_per_page'=> $tls_sp_setting['product_number'],
                'offset'        => $offset,
                'paged'         => $paged
            );
            
            $productQuery = new WP_Query($args);
            return $productQuery;
        }
        
        public function create() {
                $labels = array(
                    'name'                  => __('TS Products'),
                    'singular_name'         => __('TS Product'),
                    'menu_name'             => __('TS Product'),
                    'name_admin_bar'        => __('TS Product'),
                    'add_new'               => __('Add TS Product'),
                    'add_new_item'          => __('Add New TS Product'),
                    'search_items'          => __('Search TS Product'),
                    'not_found'             => __('No Book found.'),
                    'not_found_in_trash'    => __('No Book found in Trash'),
                    'view_item'             => __('View Product'),
                    'edit_item'             => __('Edit Product')
                );
                
                $args = array(
        			'labels'                => $labels,
        			'description'           => __('Show products list'),
        			'public'                => true,
         			'hierarchical'          => true,
        // 			'exclude_from_search'   => null, // kế thừa từ phần public
        // 			'publicly_queryable'    => null, // kế thừa từ phần public
        // 			'show_ui'               => null, // kế thừa từ phần public
        //      	'show_in_menu'          => null,
         			'show_in_nav_menus'     => true, // kế thừa từ phần public, hiển thị ở Appearance-Menu
         			'show_in_admin_bar'     => false, // kế thừa từ phần public, hiển thị ở AdminBar-New
         			'menu_position'         => 5,     // Vị trí xuất hiện trên menu left
        //      	'menu_icon'             => TLS_PLUGIN_IMAGES_URL . 'icon-setting16x16.png',
         			'capability_type'       => 'post',
        // 			'capabilities'          => array(),
        // 			'map_meta_cap'          => null,
         			'supports'              => array('title', 'editor','author','custom-fields' ,'comments', 'thumbnail'),
        // 			'register_meta_box_cb'  => null,
         			'taxonomies'            => array('tls-category'),
         			'has_archive'           => true,
         			'rewrite'               => array('slug'=>'tlsproduct'),
        // 			'query_var'             => true,
        // 			'can_export'            => true,
        // 			'delete_with_user'      => null,
        // 			'show_in_rest'          => false,
        // 			'rest_base'             => false,
        // 			'rest_controller_class' => false,
        // 			'_builtin'              => false,
         			'_edit_link'            => 'post.php?post_type=tlsproduct&post=%d',
    		    );
                
                register_post_type('tlsproduct', $args);
        }
    }