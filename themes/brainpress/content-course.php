<?php
/**
 * @package BrainPress
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	$course_media = do_shortcode( '[course_media wrapper="figure" list_page="yes"]' );

	if ( $course_media ) {
		$extended_class = '';
	} else {
		$extended_class = 'quick-course-info-extended';
	}
	?>

	<?php
	// Course thumbnail
	echo $course_media;
	?>

	<section class="article-content-right <?php echo $extended_class; ?> course-archive">
		<header class="entry-header">
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
		</header><!-- .entry-header -->

		<?php if ( is_search() ) : // Only display Excerpts for Search   ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
		<?php else : ?>
			<div class="entry-content <?php echo $extended_class; ?>">
				<div class="instructors-content">
					<?php
					// Flat hyperlinked list of instructors
					echo do_shortcode( '[course_instructors style="list-flat" link="true"]' );
					?>
				</div>
				<?php
				// Course summary/excerpt
				echo do_shortcode( '[course_summary length="50" class="' . $extended_class . '"]' );
				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . __( 'Seiten:', 'brainpress' ),
						'after' => '</div>',
					)
				);
				?>
				<div class="quick-course-info <?php echo ( isset( $extended_class ) ? $extended_class : '' ); ?>">
					<?php
					echo do_shortcode( '[course_start label="" class="course-time"]' );
					echo do_shortcode( '[course_language label="" class="course-lang"]' );
					echo do_shortcode( '[course_cost label="" class="course-cost" show_icon="true"]' );
					echo do_shortcode( '[course_join_button details_text="' . __( 'Details', 'brainpress' ) . '" course_expired_text="' . __( 'Nicht verfügbar', 'brainpress' ) . '" list_page="yes"]' );
					?>
					<!--go-to-course-button-->
				</div>
			</div><!-- .entry-content -->

		<?php endif; ?>

		<footer class="entry-meta">
			<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search  ?>
				<?php
				// Translators: Used between list items, there is a space after the comma.
				$categories_list = get_the_category_list( __( ', ', 'brainpress' ) );
				if ( $categories_list && brainpress_categorized_blog() ) :
					?>
					<span class="cat-links">
						<?php printf( __( 'Kurse in %1$s', 'brainpress' ), $categories_list ); ?>
					</span>
					<?php
				endif; // End if categories

				// Translators: Used between list items, there is a space after the comma.
				$tags_list = get_the_tag_list( '', __( ', ', 'brainpress' ) );
				if ( $tags_list ) :
					?>
					<span class="tags-links">
						<?php printf( __( 'Tagged %1$s', 'brainpress' ), $tags_list ); ?>
					</span>
					<?php
				endif; // End if $tags_list
			endif; // End if 'post' == get_post_type()
			?>
		</footer><!-- .entry-meta -->
    </section>
</article><!-- #post-## -->
<br style="clear: both;" />
