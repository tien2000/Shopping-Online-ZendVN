<div class="tls-mb-wrap">
	<p>
		<b><i><?php echo __('Please enter the following information in the following boxes')?>:</i> </b>
	</p>
	<?php 
	global $tController, $post;
	$htmlObj = new TlsHtml();
	
	$controller = $tController->_data['controller'];
	
	//=====================================================
	//Tao phan tu chua Price
	//=====================================================
	$inputID 	= $controller->create_id('price');
	$inputName 	= $controller->create_id('price');
	$inputValue = get_post_meta($post->ID, $controller->create_key('price'), true);
	$inputValue	= filter_var($inputValue, FILTER_VALIDATE_FLOAT);
	
	$arr 		= array('size' => '25', 'id' => $inputID);
	$html 		= $htmlObj->label(translate('Price')) . '<br/>'
				    . $htmlObj->textbox($inputName, $inputValue, $arr);
	echo $htmlObj->pTag($html);
	
	//=====================================================
	//Tao phan tu chua Sale Off
	//=====================================================
	$inputID 	= $controller->create_id('sale-off');
	$inputName 	= $controller->create_id('sale-off');
	$inputValue = get_post_meta($post->ID, $controller->create_key('sale-off'), true);
	$inputValue	= filter_var($inputValue, FILTER_VALIDATE_FLOAT);
	
	$arr 		= array('size' => '25','id' => $inputID);
	$html 		= $htmlObj->label(translate('Sale Off')) . '<br/>'
					. $htmlObj->textbox($inputName, $inputValue, $arr);
	echo $htmlObj->pTag($html);
	
	//=====================================================
	//Tao phan tu chua Manufacturer
	//=====================================================
	$modelManufacturer = $tController->getModel('Manufacturer');
	
	$manufacturer = $modelManufacturer->getItem(array('status'=> 1), array('type' => 'all'));
	
	$options['data'] = array();
	foreach ($manufacturer as $key => $val){
		$options['data'][$val['id']] = $val['name'];
	}
	
	$inputID 	= $controller->create_id('manufacturer');
	$inputName 	= $controller->create_id('manufacturer');
	$inputValue = get_post_meta($post->ID, $controller->create_key('manufacturer'), true);	
	
	$arr 		= array('style' => 'width: 150px;', 'id' => $inputID);
	$html 		= $htmlObj->label(translate('Manufacturer')) . '<br/>'
				  . $htmlObj->selectbox($inputName, $inputValue, $arr, $options);
	echo $htmlObj->pTag($html);
	
	//=====================================================
	//Tao phan tu chua Gift
	//=====================================================
	$inputID 	= $controller->create_id('gift');
	$inputName 	= $controller->create_id('gift');
	$inputValue = get_post_meta($post->ID, $controller->create_key('gift'), true);
	$arr 		= array('id' => $inputID,'rows' => 6, 'cols' => 60);
	$html		= $htmlObj->label(translate('Gift for customer')) . '<br/>'
					. $htmlObj->textarea($inputName, $inputValue, $arr);
	echo $htmlObj->pTag($html);
	
	?>
</div>
