<?php
/**
 * The Sidebar containing the footer widget areas.
 *
 * @package BrainPress
 */
?>
<div id="third" class="widget-area footer-widget-area clearf" role="complementary">
	<?php
	do_action( 'before_sidebar' );

	if ( ! dynamic_sidebar( 'sidebar-2' ) ) :
		// No default content...
	endif; // end sidebar widget area
	?>
</div><!-- #secondary -->
