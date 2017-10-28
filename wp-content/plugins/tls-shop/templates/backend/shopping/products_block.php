<?php 
    $args = array(
        'post_type'     => 'tlsproduct',
        'post_per_page' => 8,
        'oderby'        => 'date',
        'order'         => 'DESC',
        );

    $the_query = new WP_Query($args);
    
    /* echo '<pre>';
    print_r($the_query);
    echo '</pre>'; */
?>

<div id="normal-sortables" class="meta-box-sortables ui-sortable">
	<div id="dashboard_right_now" class="postbox ">
		<button type="button" class="handlediv" aria-expanded="true">
			<span class="screen-reader-text">Toggle panel: At a Glance</span><span
				class="toggle-indicator" aria-hidden="true"></span>
		</button>
		<h2 class="hndle ui-sortable-handle">
			<span><?php echo __('Lastest Product')?></span>
		</h2>
		<div class="inside">
			<div class="main">
				<ul>
					<?php 
					   $i = 1;
					   if ($the_query->have_posts()): while ($the_query->have_posts()): $the_query->the_post();
					   $link = 'post.php?post_type=tlsproduct&post='. get_the_ID() .'&action=edit';
					?>
				
						<li class="page-count">
							<a href="<?php echo $link;?>"><?php echo $i . ' - ' . get_the_title();?></a>
						</li>
					
					<?php 
					   $i++; 
					   endwhile; endif; 
					   wp_reset_postdata();
					?>
				</ul>
				<p id="wp-version-message">
					<span id="wp-version">View all Products <a href="edit.php?post_type=tlsproduct">Click Here.</a>
					</span>
				</p>
			</div>			
		</div>
	</div>
</div>