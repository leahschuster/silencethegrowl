<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Quarter_Campaign
 * @since Quarter Campaign 1.0 2015
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		// Post thumbnail.
		silencethegrowl_post_thumbnail();
		
		the_title( '<h1 class="entry-title">', '</h1>' );

		the_content();
		
	?>


</article><!-- #post-## -->
