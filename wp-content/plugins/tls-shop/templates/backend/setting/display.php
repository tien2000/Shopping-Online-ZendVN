<?php
    global $tController;    
    $lbl            = __('TShopping Settings');    
    $option_name    = 'tls_sp_setting';
    
    if (!$tController->isPost()){
        $data = get_option($option_name, array());
        if (count($data) == 0){
            $data = $tController->getConfig('Setting')->get();      // Biến đối tượng thành mảng
        }
    }
    
    /* echo '<pre>';
    print_r($data);
    echo '</pre>'; */    
    
    $htmlObj        = new TlsHtml();
    //=====================================================
    //Tao phan tu chua Price
    //=====================================================
    $inputID 	= $option_name . '_product_number';
    $inputName 	= $option_name . '[product_number]';
    $inputValue = $data['product_number'];
    
    $arr 		= array('size' => '5', 'id' => $inputID);
    $productNumber 		= $htmlObj->label(translate('Price')) . '<br/>'
        . $htmlObj->textbox($inputName, $inputValue, $arr);
?>

<div class="wrap">
	<h2>
		<?php echo $lbl;?>
	</h2>
	<form method="post" action="" name="<?php echo $option_name;?>" id="<?php echo $option_name;?>" enctype= multipart/form-data>
		<!--Show product in FrontEnd -->
    		<h3 class="title">
    			<?php echo __('Show product in FrontEnd')?>
    		</h3>
    		<div class="tls-sp-form-table">
        		<table class="form-table">
        			<tbody>
        				<tr>
        					<th scope="row">
        						<label for="mailserver_url"><?php echo __('Products in a page')?> : </label>
        					</th>
        					<td><?php echo $productNumber;?></td>
        				</tr>				
        			</tbody>
        			
        		</table>
    		</div>		
		<!--Show product in FrontEnd -END -->
		
	<?php 
		//========================================
		//Tạo các phần tử INPUT
		//========================================
		
		//Tao phan tu chua productNumber
		$inputID 	= $option_name . '_currency_unit';
		$inputName 	= $option_name . '[currency_unit]';
		$inputValue = $data['currency_unit'];
		$arr 		= array('size' =>'5', 'id' => $inputID);
		$currencyUnit	= $htmlObj->textbox($inputName, $inputValue, $arr);			
			
		//Tao phan tu chua productNumber
		$inputID 	= $option_name . '_payment';
		$inputName 	= $option_name . '[payment][]';
		$inputValue = $data['payment'];
		$arr 		= array('id' => $inputID, 'multiple'=>'multiple');
		$options['data'] = array(
                    		    'send_mail' => __('Send mail'),
                    		    'paypal' 	=> 'Paypal',
                    		    'vcb'		=> 'Vietcombank pay online',
                    		    'vietin' 	=> 'Vietinbank pay online',
                    		);
		$payment	= $htmlObj->selectbox($inputName,$inputValue,$arr,$options);
	?>
	
    	<!--Money & Pay -->
    		<h3 class="title">
    			<?php echo __('Currency & Payment')?>
    		</h3>
    		<div class="tls-sp-form-table">
        		<table class="form-table">
        			<tbody>
        				<tr>
        					<th scope="row">
        						<label for="mailserver_url"><?php echo __('Currency unit')?> : </label>
        					</th>
        					<td><?php echo $currencyUnit;?></td>
        				</tr>
        				<tr>
        					<th scope="row">
        						<label for="mailserver_url"><?php echo __('Method of payment')?> : </label>
        					</th>
        					<td><?php echo $payment;?></td>
        				</tr>
        			</tbody>    			
        		</table>
    		</div>
		<!--Money & Pay - End -->
		
	<?php 
		//========================================
		//Tạo các phần tử INPUT
		//========================================
			
		//Tao phan tu chua $alertToEmail
		$inputID 	= $option_name . '_alert_to_email';
		$inputName 	= $option_name . '[alert_to_email]';
		$inputValue = $data['alert_to_email'];
		$arr 		= array('size' =>'25','id' => $inputID);
		$alertToEmail	= $htmlObj->textbox($inputName,$inputValue,$arr,$options);
		//. $htmlObj->pTag('Nhập vào 1 chuỗi khoảng 20 ký tự',array('class'=>'description'));
			
		//Tao phan tu chua $selectType
		$inputID 		= $option_name . '_select_type';
		$inputName 		= $option_name . '[select_type]';
		$inputValue 	= $data['select_type'];
		$arr 			= array('size' =>'25','id' => $inputID);
		$options		= array('data' => array('system'=> 'System','tshopping'=>'tShopping'),
		    'separator' => ' ');
		$selectType 	= $htmlObj->radio($inputName,$inputValue,$arr,$options);
			
		//Tao phan tu chua $emailAddress
		$inputID 		= $option_name . '_email_address';
		$inputName 		= $option_name . '[email_address]';
		$inputValue 	= $data['email address'];
		$arr 			= array('size' =>'25','id' => $inputID);
		$emailAddress	= $htmlObj->textbox($inputName,$inputValue,$arr);
			
			
		//Tao phan tu chua $fromName
		$inputID 	= $option_name . '_from_name';
		$inputName 	= $option_name . '[from_name]';
		$inputValue = $data['from_name'];
		$arr 		= array('size' =>'25','id' => $inputID);
		$fromName	= $htmlObj->textbox($inputName,$inputValue,$arr);
			
		//Tao phan tu chua $smtpHost
		$inputID 	= $option_name . '_smtp_host';
		$inputName 	= $option_name . '[smtp_host]';
		$inputValue = $data['smtp_host'];
		$arr 		= array('size' =>'25','id' => $inputID);
		$smtpHost	= $htmlObj->textbox($inputName,$inputValue,$arr);
			
		//Tao phan tu chua $encription
		$inputID 	= $option_name . '_encription';
		$inputName 	= $option_name . '[encription]';
		$inputValue = $data['encription'];
		$options	= array('data' => array('none'=> 'None','ssl'=>'SSL','tls'=>'TLS'),
		    'separator' => ' ');
		$arr 		= array('size' =>'25','id' => $inputID);
		$encription	= $htmlObj->radio($inputName,$inputValue,$arr,$options);
			
		//Tao phan tu chua $smptPort
		$inputID 	= $option_name . '_smpt_port';
		$inputName 	= $option_name . '[smpt_port]';
		$inputValue = $data['smpt_port'];
		$arr 		= array('size' =>'25','id' => $inputID);
		$smptPort	= $htmlObj->textbox($inputName,$inputValue,$arr);
			
		//Tao phan tu chua $smtpAuth
		$inputID 	= $option_name . '_smtp_auth';
		$inputName 	= $option_name . '[smtp_auth]';
		$inputValue = $data['smtp_auth'];
		$options	= array('data' => array('no'=> 'No','yes'=>'Yes'),
		    'separator' => ' ');
		$arr 		= array('size' =>'25','id' => $inputID);
		$smtpAuth	= $htmlObj->radio($inputName,$inputValue,$arr,$options);
			
		//Tao phan tu chua $smtpPassword
		$inputID 	= $option_name . '_smtp_password';
		$inputName 	= $option_name . '[smtp_password]';
		$inputValue = $data['smtp_password'];
		$arr 		= array('size' =>'25','id' => $inputID);
		$smtpPassword	= $htmlObj->textbox($inputName,$inputValue,$arr);
			
		//Tao phan tu chua $smtpUsername
		$inputID 	= $option_name . '_smtp_username';
		$inputName 	= $option_name . '[smtp_username]';
		$inputValue = $data['smtp_username'];
		$arr 		= array('size' =>'25','id' => $inputID);
		$smtpUsername	= $htmlObj->password($inputName,$inputValue,$arr);
	?>
	
	<!--Send mail -->
		<h3 class="title">
			<?php echo __('Email configs')?>
		</h3>
		<div class="tls-sp-form-table">
    		<table class="form-table">
    			<tbody>
    				<tr>
    					<th scope="row">
    						<label for="mailserver_url"><?php echo __('Alert to email')?> : </label>
    					</th>
    					<td><?php echo $alertToEmail;?></td>
    				</tr>
    				<tr>
    					<th scope="row">
    						<label for="mailserver_url"><?php echo __('Select email type')?> : </label>
    					</th>
    					<td><?php echo $selectType;?></td>
    				</tr>
    				<tr>
    					<th scope="row">
    						<label for="mailserver_url"><?php echo __('From Email Address')?> : </label>
    					</th>
    					<td><?php echo $emailAddress;?></td>
    				</tr>
    				
    				<tr>
    					<th scope="row">
    						<label for="mailserver_url"><?php echo __('From Name')?> : </label>
    					</th>
    					<td><?php echo $fromName;?></td>
    				</tr>
    				<tr>
    					<th scope="row">
    						<label for="mailserver_url"><?php echo __('SMTP Host')?> : </label>
    					</th>
    					<td><?php echo $smtpHost;?></td>
    				</tr>
    				<tr>
    					<th scope="row">
    						<label for="mailserver_url"><?php echo __('Type of Encription')?> : </label>
    					</th>
    					<td><?php echo $encription;?></td>
    				</tr>
    				<tr>
    					<th scope="row">
    						<label for="mailserver_url"><?php echo __('SMTP Port')?> : </label>
    					</th>
    					<td><?php echo $smptPort;?></td>
    				</tr>
    				<tr>
    					<th scope="row">
    						<label for="mailserver_url"><?php echo __('SMTP Authentication')?> : </label>
    					</th>
    					<td><?php echo $smtpAuth;?></td>
    				</tr>
    				<tr>
    					<th scope="row">
    						<label for="mailserver_url"><?php echo __('SMTP Password')?> : </label>
    					</th>
    					<td><?php echo $smtpPassword;?></td>
    				</tr>
    				
    				<tr>
    					<th scope="row">
    						<label for="mailserver_url"><?php echo __('SMTP Username')?> : </label>
    					</th>
    					<td><?php echo $smtpUsername;?></td>
    				</tr>
    			</tbody>    			
    		</table>
		</div>
		<!--Send mail - End -->
		<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
	
	</form>
</div>