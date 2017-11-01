<?php 
    /* 
     * asort(): Sắp xếp lại mảng.
     * key(): Lấy phần tử đầu tiên trong mảng.
     *  */
?>

<?php 
    global $wp_query, $post, $tController, $tls_sp_setting;    
    $meta_key = '_tls_sp_tlsproduct_';
?>
<?php if (have_posts()): while (have_posts()): the_post();?>
	<?php 	   
	   $manufacturerID = get_post_meta($post->ID, $meta_key . 'manufacturer', true);
	   //echo '<br>' . $manufacturerID;
	   
	   $result = $tController->getModel('Manufacturer2')->getItem(array('id' => $manufacturerID));
	   /* echo '<pre>';
	    print_r($result);
	    echo '</pre>'; */
	   
	   $manufacturer = $result['name'];
	   
	   $price      = get_post_meta($post->ID, $meta_key . 'price',true) . ' ' . $tls_sp_setting['currency_unit'];
	   $saleOff    = get_post_meta($post->ID, $meta_key . 'sale-off',true) . ' ' . $tls_sp_setting['currency_unit'];
	   
	   $cssPrice = '';
	   if (get_post_meta($post->ID, $meta_key . 'sale-off',true) > 0){
	       $cssPrice = 'text-decoration: line-through';
	   }else {
	       $saleOff = '';
	   }
	   
	   $gift = get_post_meta($post->ID, $meta_key . 'gift', true);
	   
	   $arrOrdering = get_post_meta($post->ID, $meta_key . 'img-ordering', true);	   
	   $arrPicture = get_post_meta($post->ID, $meta_key . 'img-url', true);;
	   
	   $newPicArray = array();
	   foreach ($arrPicture as $key => $val){
	       $newPicArray[$val] = $arrOrdering[$key];
	   }
	   asort($newPicArray);
	   
	   $firstImg = key($newPicArray);      // Lấy phần tử đầu tiên trong mảng
	   
	   echo '<pre>';
	   print_r($firstImg);
	   echo '</pre>';
	?>
    <div id="tls_sp_product_detail">
    	<div class="product_imgs">
    		<img class="firstImg" width="480px" height="320px"
    			src="<?php echo $firstImg;?>"
    			alt="<?php the_title();?>">
    		<ul class="product-thumbs">
    			<?php 
    			 foreach ($newPicArray as $key => $val){  	
    			     $imgThumbnail = $tController->getHelper('ImgThumbnail');
    			     $imgUrl = $imgThumbnail->resize($key, 80, 53);
    			?>
        			<li><img width="80px" height="53px"
        				src="<?php echo $imgUrl;?>"
        				alt=""
        				data-img="<?php echo $key;?>">
        			</li>
    			<?php }?>
    
    		</ul>
    		<div class="clr"></div>
    	</div>
    	<div class="product_text">
    		<ul>
    			<li class="title"><h1>
    					<?php the_title();?>
    				</h1>
    			</li>
    			<li class="manufacturer">Manufacturer: <?php echo $manufacturer;?>
    			</li>
    			<li class="price" style="<?php echo $cssPrice;?>">Price: <?php echo $price;?></li>
    			<li class="sale-off">Sale Off: <?php echo $saleOff;?></li>
    			<li class="gift">
    				<div>Gift: <?php echo $gift;?></div>
    			</li>
    			<li><a id="add_to_cart" class="order" product-id="259">Giỏ hàng</a></li>
    			<li><a href="#" class="r360">Xoay ảnh 360</a>
    			</li>
    			<li class="detail-cart">
    				<div class="alert-cart">Your cart updated</div>
    				<div>
    					Currently, <span class="number_product">6 products</span> in your
    					cart
    				</div>
    				<div>
    					View details of your cart <a href="#">click here</a>
    				</div>
    
    			</li>
    		</ul>
    	</div>
    	<div class="clr"></div>
    </div>
	<?php the_content();?>
<?php endwhile; endif;?>




