<?php
get_header(); ?>

		<div id="container">
			<div id="content" role="main">

			<?php 
			     echo '<br>' . __FILE__;
			     global $tController;
			     $tController->getController('Cart', 'frontend');
			
			?>
			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
