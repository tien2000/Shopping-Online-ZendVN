<?php 
    $taxonomy = array(
        'hide_empty'    => false,      // Lấy những category ko có sản phẩm
        'number'        => 8,
        'oderby'        => 'id',
        'order'         => 'DESC',
        'hierarchical'   => false
        );
    $ts_category = get_terms('tls-category', $taxonomy);
    
    /* echo '<pre>';
    print_r($ts_category);
    echo '</pre>'; */
?>

<div id="normal-sortables" class="meta-box-sortables ui-sortable">
	<div id="dashboard_right_now" class="postbox ">
		<button type="button" class="handlediv" aria-expanded="true">
			<span class="screen-reader-text">Toggle panel: At a Glance</span><span
				class="toggle-indicator" aria-hidden="true"></span>
		</button>
		<h2 class="hndle ui-sortable-handle">
			<span><?php echo __('Lastest Categories')?></span>
		</h2>
		<div class="inside">
			<div class="main">
				<ul>
					<?php 
					   $i = 1;
					   if (count($ts_category) > 0){
					       foreach ($ts_category as $key => $val){
					           $link = 'term.php?taxonomy=tls-category&tag_ID='. $val->term_id 
					                       .'&post_type=tlsproduct';
					           echo '<li class="page-count">
							             <a href="'. $link .'">'. $i . ' - ' . $val->name . '</a>
						             </li>';
					           $i++;
					       }
					   }
					?>
				</ul>
				<p id="wp-version-message">
					<span id="wp-version">View all Categories <a href="edit-tags.php?taxonomy=tls-category&post_type=tlsproduct">Click Here.</a>
					</span>
				</p>
			</div>
		</div>
	</div>
</div>