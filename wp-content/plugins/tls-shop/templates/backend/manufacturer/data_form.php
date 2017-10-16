<?php    
    global $tController;
    
    echo '<pre>';
    print_r($tController);
    echo '</pre>';
    
    $page = $tController->getParams('page');
    $action     = ($tController->getParams('action') != '')?$tController->getParams('action'):'add';
    
    // Label
    $lbl = __('Add New Manufacturer');
    
    $htmlObj    = new TlsHtml();
    
    $name       = $htmlObj->textbox('name', @$vName, array('class' => 'regular-text'));
    $slug       = $htmlObj->textbox('slug', @$vSlug, array('class' => 'regular-text'));
    
    $options['data'] = array('Inactive', 'Active');
    $status     = $htmlObj->selectbox('status', @$vStatus, array('class' => 'regular-text'), $options);
?>

<div class="wrap">
	<h1><?php echo $lbl;?></h1>
	<?php echo $mes;?>
	<form method="post" action="" id="<?php echo $page;?>" name="<?php echo $page;?>" enctype="multipart/form-data">
		<input type="hidden" name="action" value="<?php echo $action;?>">
		
		<?php wp_nonce_field($action, 'security_code', true); // true thì đóng dòng dưới, false thì mở ra?>		
		<?php //wp_referer_field();?>
		<h3>Information:</h3>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><label><?php echo __('Manufacturer name') . ': '; ?></label></th>
					<td><?php echo $name;?></td>
				</tr>
				<tr>
					<th scope="row"><label><?php echo __('Slug') . ': '; ?></label></th>
					<td><?php echo $slug;?></td>
				</tr>
				<tr>
					<th scope="row"><label><?php echo __('Status') . ': '; ?></label></th>
					<td><?php echo $status;?></td>
				</tr>
			</tbody>
		</table>
		<p class="submit">
			<input type="submit" name="submit" id="submit"
				class="button button-primary" value="Save Changes">
		</p>
	</form>
</div>