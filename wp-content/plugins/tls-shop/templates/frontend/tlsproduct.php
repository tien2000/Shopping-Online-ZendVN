<?php
get_header(); ?>
<style type="text/css">
	#content{
		margin-right: 20px;
	}
</style>
		<div id="container">
			<div id="content" role="main">

			<?php 
			     //echo '<br>' . __FILE__;
			     global $tController;
			     $tController->getController('Product', 'frontend');
			
			?>
			</div><!-- #content -->
		</div><!-- #container -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
