<?php
	global $wpQuery, $zController;	
	$paging  = $zController->getHelper('Paging');

?>

<div class="nav-article">
	<span class="site-pagination-heading">Pages</span>
	<?php echo $paging->getPaging($wpQuery);?>	
</div>