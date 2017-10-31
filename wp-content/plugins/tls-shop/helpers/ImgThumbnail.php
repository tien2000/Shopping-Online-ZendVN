<?php 
    /* 
     * explode($delimiter, $string, $limit): Tách đường dẫn thành 2 phần tử của mảng.
     *  */
?>

<?php
    class Tls_Sp_ImgThumbnail_Helper{
        
        // $options['type']: original | thumbnail | resize
        //$options['width'] - $options['height']
        
        public function getImages($postID = 0, $options = array()){
            $img = TLS_SP_PRODUCT_URL . 'default.jpg';
            
            if($postID > 0){
                $imgType        = (!isset($options['type']))?'thumbnail':$options['type'];
                $thumbnail_id   = get_post_thumbnail_id($postID);
                
                if ($imgType == 'thumbnail') {
    	           $image = wp_get_attachment_image_src($thumbnail_id);
    	           if (is_array($image)) $img = $image[0];
                }else if ($imgType == 'original'){
                    $image = wp_get_attachment_image_src($thumbnail_id, 'single-post-thumbnail');                    
                    if (is_array($image)) $img = $image[0];
                }else if ($imgType == 'resize'){                    
                    $image = wp_get_attachment_image_src($thumbnail_id, 'single-post-thumbnail');
                    if (!is_array($image)){
                        return $img;
                    }else {
                        $img = $this->resize($image[0], $options['width'], $options['height']);
                    }
                }
            }            
            return $img;
        }
        
        public function resize($imgURL = null, $width = 0, $height = 0){
            //echo '<br>' . __METHOD__;
            //echo '<br>' . $imgUrl;
            
            $tmp = explode('/wp-content/', $imgURL);
    		$imgDir =ABSPATH . 'wp-content/' . $tmp[1];
    				
    		//Lấy tên hình hiện thời.
    		preg_match("/[^\/|\\\]+$/", $imgURL, $currentName);
    		$currentName = $currentName[0];
    		
    		//Đường dẫn thư mục lưu hình ảnh mới
    		$storeFolder = TLS_SP_PRODUCT_PATH . '/p' . $width .'x' . $height;
    		
    		if(!file_exists($storeFolder)){
    			mkdir($storeFolder, 0755); //CMOD
    		}
    		
    		$newImgPath = $storeFolder . '/' . $currentName;
    		//echo '<br/>' . $newImgPath;
    		if(!file_exists($newImgPath)){
    			$wpImageEditor = wp_get_image_editor($imgDir);
    			if(!is_wp_error($wpImageEditor)){
    				$wpImageEditor->resize($width, $height, array('center','center'));
    				$wpImageEditor->save($newImgPath);
    			}
    		}
    		
    		$newImgUrl = TLS_SP_PRODUCT_URL . 'p' . $width .'x' . $height . '/' . $currentName;
    		
    		/* echo '<pre>';
    		print_r($newImgUrl);
    		echo '</pre>'; */
    		
    		return $newImgUrl;
            
            /* echo '<pre>';
            print_r($newImgPath);
            echo '</pre>'; */
        }
    }