<?php 
	global $tController;
	$tblManufacturer = $tController->getModel('Manufacturer');	
	$tblManufacturer->prepare_items();
	
	$lbl = 'Manufacturer List';
	
	$page = $tController->getParams('page');
	
	$linkAdd = admin_url('admin.php?page=' . $page . '&action=add') ;
	$lblAdd = 'Add a Manufacturer';
	
	if($tController->getParams('mes') == 1){
		$mes .='<div class="updated"><p>Update finish</p></div>';
	}
	
?>
<div class="wrap">
	<h2><?php echo esc_html__($lbl);?>
		<a href="<?php echo esc_url($linkAdd);?>" class="add-new-h2"><?php echo esc_html__($lblAdd);?></a>
	</h2>
	<?php echo $mes;?>
	<form action="" method="post" name="<?php echo $page;?>" id="<?php echo $page;?>">
    	<?php $tblManufacturer->search_box('search', 'search_id');?>
    	<?php $tblManufacturer->display();?>
	</form>
</div>