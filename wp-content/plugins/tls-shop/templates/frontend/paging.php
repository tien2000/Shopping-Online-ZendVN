<?php
	global $wpQuery, $tController;	
	$paging  = $tController->getHelper('Paging');

?>

<div class="nav-article">
	<span class="site-pagination-heading"><?php echo __('Pages: ');?></span>
	<?php echo $paging->getPaging($wpQuery);?>	
</div>