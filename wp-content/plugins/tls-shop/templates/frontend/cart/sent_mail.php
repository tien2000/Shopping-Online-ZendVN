<?php
	global $tController;
	//echo '<br/>' . __FILE__;
	$title 		= 'Your Infomation';
	$content 	= 'Xin vui lòng nhập đầy đủ thông tin vào form sau đó nhấn Submit';
	
	//Khoi tao doi tuong TlsHtml
	$htmlObj = new TlsHtml();
	
	$vFullName	= '';
	$fullName 	= $htmlObj->textbox('full_name',$vFullName,array('class'=>'regular-text'));
	
	$vPhone		= '';
	$phone 		= $htmlObj->textbox('phone',$vPhone,array('class'=>'regular-text'));
	
	$vEmail		= '';
	$email 		= $htmlObj->textbox('email',$vEmail,array('class'=>'regular-text'));	

	$vBillAddress	= '';
	$billAddress 	= $htmlObj->textbox('bill_address',$vBillAddress,array('class'=>'regular-text'));
	
	$vShippingAdress		= '';
	$shippingAddress 		= $htmlObj->textbox('shipping_address',$vShippingAdress,array('class'=>'regular-text'));
	
	$vComment	= '';
	$comment 	= $htmlObj->textarea('comment',$vComment,array('class'=>'regular-text','cols'=> 60, 'rows'=>4));
	
?>

<h1 class="entry-title">
	<?php echo $title;?>
</h1>
<div class="entry-content">
	<?php echo $content;?>
</div>

<div id="custom_infomation">
	<form method="post" id="custom_infomation" class="custom_infomation" action="">
	<input type="hidden" name="payment" value="send_mail"/>
	<input type="hidden" name="type" value="send"/>
	<table class="custom_infomation_table">
		<tr>
			<td class="label">Full name:</td>
			<td class="input"><?php echo $fullName;?></td>
		</tr>
		<tr>
			<td class="label">Phone:</td>
			<td class="input"><?php echo $phone;?></td>
		</tr>
		<tr>
			<td class="label">Email:</td>
			<td class="input"><?php echo $email;?></td>
		</tr>
		<tr>
			<td class="label">Bill address:</td>
			<td class="input"><?php echo $billAddress;?></td>
		</tr>
		<tr>
			<td class="label">Shipping adress:</td>
			<td class="input"><?php echo $shippingAddress;?></td>
		</tr>
		<tr>
			<td class="label">Comment:</td>
			<td class="input"><?php echo $comment;?></td>
		</tr>
	</table>
	
	<input type="submit" name="submit" id="submit" value="Submit">
	</form>
</div>












