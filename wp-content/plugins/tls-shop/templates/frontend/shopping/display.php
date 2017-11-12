<?php 
    /* 
     * single_post_thumbnail: Hiển thị hình ảnh kích thước gốc.
     *  */
?>

<?php 
    global $tController, $tls_sp_settings, $wp_query, $wpQuery;
    
    $tController->getHelper('Session')->set('abcCart', 'ABC 123');
    
    
    /* echo '<pre>';
    print_r($wp_query);
    echo '</pre>'; */
?>
<?php if(have_posts()) while(have_posts()) : the_post();?>
    <h1 class="entry-title">
    	<?php the_title();?>
    </h1>
    <div class="entry-content">
    	<?php the_content();?>
    	
    	<?php 
    	   $productQuery = $tController->getModel('Product')->getAllProduct();
    	   $wpQuery = $productQuery;
    	   echo '<ul id="tls_sp_products">';
    	   while ($productQuery->have_posts()){
    	       $productQuery->the_post();
    	       $postID = $productQuery->post->ID;
    	       $title = get_the_title($postID);
    	       
    	       $imgThumbnail = $tController->getHelper('ImgThumbnail');
    	       $width = 160;
    	       $height = 160;
    	       $img = $imgThumbnail->getImages($postID, array('type' => 'resize', 
    	                                                   'width' => $width, 'height' => $height));
    	       $meta_key = '_tls_sp_tlsproduct_';
    	       $price = get_post_meta($postID, $meta_key . 'price',true) . ' ' . $tls_sp_settings['currency_unit'];
    	       $saleOff = get_post_meta($postID, $meta_key . 'sale-off',true) . ' ' . $tls_sp_settings['currency_unit'];
    	       
    	       $cssPrice = '';
    	       if (get_post_meta($postID, $meta_key . 'sale-off',true) > 0){
    	           $cssPrice = 'text-decoration: line-through';
    	       }
    	       
    	       $gift = get_post_meta($postID, $meta_key . 'gift',true);
    	       if (strlen($gift) > 0){
    	           $gift = 'Có quà tặng';
    	       }else {
    	           $gift = '&nbsp;';
    	       }
    	       
    	       $linkProduct = get_permalink($postID);
    	?>
    		<li>
    			<div class="product">
    				<a href="<?php echo $linkProduct;?>"title="<?php echo $title;?>">
    					<img src="<?php echo $img;?>" alt="" width="<?php echo $width;?>px" height="<?php echo $height;?>px">
    					<div class="name"><?php echo $title;?></div>
    				</a>
    				<div class="price">
    					<span class="plft" style="<?php echo $cssPrice?>"><?php echo $price;?></span>
    					<span class="prt"><?php echo $saleOff;?></span>
    				</div>
    				<div class="gift clr"><?php echo $gift;?></div>
    			</div>
    		</li>    	
    	<?php 
            }
    	   echo '</ul>';
    	?>
    	<div class="clr"></div>
    </div>
<?php endwhile;?>

<?php 
	if($wpQuery->max_num_pages > 1){
		$tController->getView('paging.php','frontend');
	}
?>






