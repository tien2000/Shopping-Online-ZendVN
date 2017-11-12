<?php 
	global $tController, $wp_query;
	
	$tlsSs 	   = $tController->getHelper('Session');
	$tlsSsCart = $tlsSs->get('tcart',array());	
	$idArr     = array_keys($tlsSsCart);	
?>
<?php if(have_posts()): while (have_posts()): the_post();?>
<h1 class="entry-title"><?php the_title();?></h1>
<div class="entry-content">
	<?php the_content();?>
</div>
<div id="tls_sp_cart_table">
	<div class="show-alert"></div>
	
	<?php 
	   $cartHTML = '';
	   $cartHTML .='<table>
                		<thead>
                			<tr>
                				<td class="id">ID</td>
                				<td class="name">Name</td>
                				<td class="quality">Price</td>
                				<td class="quality">Quality</td>
                				<td class="money">Money</td>
                				<td class="control">Action</td>
                			</tr>
                		</thead>                
                		<tbody>';	
    $meta_key = '_tls_sp_tlsproduct_';
    if (count($idArr)){
        $args = array(
            'post_type'    => 'tlsproduct',
            'post__in'      => $idArr
        );
        
        $wpQuery = new WP_Query($args);
        
        while ($wpQuery->have_posts()){
            $wpQuery->the_post();
            $post = $wpQuery->post;
            $postID = $post->ID;
            $title = $post->post_title;
            
            $price = get_post_meta($postID, $meta_key . 'price', true);
            //echo '<br>' . $price;
            
            $saleOff = get_post_meta($postID, $meta_key . 'sale-off', true);
            //echo '<br>' . $saleOff;
            
            if (absint($saleOff) > 0){
                $price = $saleOff;
            }
            
            $quality = $tlsSsCart[$postID];
            $money = $price * $quality;
            $linkUpdate = '<a class="update-product" product-id="' . $postID . '" product-price="'. $price .'">Update</a>';
            $linkRemove = '<a class="remove-product" product-id="' . $postID . '">Remove</a>';
        	
       $cartHTML .= '<tr>
        				<td>'. $postID .'</td>
        				<td>'. $title .'</td>
        				<td>'. $price .'</td>
        				<td><input type="text" name="price['. $postID .']" size="5"
                					id="price-'. $postID .'" style="text-align: center;"
                					value="'. $quality .'">
        				</td>
        				<td class="money-pay">'. $money .'</td>
        				<td class="control">'. $linkUpdate .' | '. $linkRemove .'</td>
        			</tr>';        	
            }
        }	
    	$cartHTML .= '</tbody>
                	</table>
                	<div id="total">
                		<b>Total:</b> <span class="pay"></span>
                	</div>
                ';
	?>
	
	<?php 	   
	   
	   if ($tController->getParams('payment') != 'send_mail'){
	       echo $cartHTML;
	   } else {
	       
	       $pattern = '#<td class="control">.*</td>#imU';      // Xóa cột Action trong List Product.
	       $cartHTML = preg_replace($pattern, $replacement, $cartHTML);
	       echo $cartHTML;
	       
	       $tlsSs = $tController->getHelper('Session');
	       $tlsSs->set('tcart_mail', $cartHTML);
	   }	   
	?>
	
</div>		
<?php endwhile; endif;?>








