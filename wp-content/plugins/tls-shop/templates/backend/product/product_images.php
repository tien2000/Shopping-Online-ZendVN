<?php
    //echo '<br>' . __FILE__;
    $htmlObj = new TlsHtml();
    
    global $tController, $post;
    $controller = $tController->_data['controller'];      
    
    // Tạo phần tử chứa Button
    $inputId    = $controller->create_id('button');
    $inputName  = $controller->create_id('button');
    $inputValue = esc_attr('Media Library Images');
    $arr        = array('class' => 'button-secondary', 'id' => $inputId);
    $options    = array('type' => 'button');
    echo $btnMedia	= $htmlObj->pTag($htmlObj->button($inputName,$inputValue,$arr,$options));
    $arrOrdering = get_post_meta($post->ID, $controller->create_key('img-ordering'), true);     // Tham số thứ 3 là true nếu là mảng, false nếu lá chuỗi hoặc số.
    $arrPicture = get_post_meta($post->ID, $controller->create_key('img-url'), true);
        
    ?>
    
    <div id="tls-sp-tsproduct-show-images">	   
    	<?php 
    	   if (count($arrPicture) > 0){
    	       for ($i = 0; $i < count($arrPicture); $i++){
    	?>
                	<div class="content-img">
                		<img
                			src="<?php echo $arrPicture[$i];?>"
                			height="100" width="100">
                		<div>
                			<a class="remove-img">Remove</a>
                		</div>
                		<div class="div-ordering">
                			<input type="text" value="<?php echo $arrOrdering[$i];?>" class="ordering"
                				name="tls-sp-tsproduct-img-ordering[]"><input type="hidden"
                				name="tls-sp-tsproduct-img-url[]"
                				value="<?php echo $arrPicture[$i];?>">
                		</div>
                	</div>
		<?php 
    	       }
    	   }
    	?> 	
		<div class="clr"></div>
	</div>
    
    <?php    
    // Tạo phần tử chứa rotate360
    $inputId    = $controller->create_id('rotate360');
    $inputName  = $controller->create_id('rotate360');
    $inputValue = get_post_meta($post->ID, $controller->create_key('rotate360'), true);
    $arr        = array('id' => $inputId, 'rows' => 6, 'cols' => 60);
    $html		= $htmlObj->label(translate('Rotate 360')) 
                    . '<br/>'
                    . $htmlObj->textarea($inputName,$inputValue,$arr);
    
    echo $htmlObj->pTag($html);
?>

