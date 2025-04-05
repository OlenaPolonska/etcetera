<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<?php
		the_title(
			sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
			'</a></h2>'
		);
		?>
	</header><!-- .entry-header -->

	<div class="entry-content-container">
		<?php echo get_the_post_thumbnail( $post->ID, 'medium' ); ?>
		<div class="entry-content">

			<div class="entry-meta">
				<?php $tags = get_tags(); ?>
				<div class="tags">
					<?php foreach ( $tags as $tag ) { ?>
					<a href="<?php echo get_tag_link( $tag->term_id ); ?> " rel="tag">
						#<?php echo $tag->name; ?></a>
					<?php } ?>
				</div>

				<?php $categories = get_categories(); ?>
				<div class="categories">
					<?php foreach ( $categories as $category ) { ?>
					<a href="<?php echo get_category_link( $category->term_id ); ?> " rel="tag">
						<?php echo $category->name; ?></a>
					<?php } ?>
				</div>
			</div><!-- .entry-meta -->
			<hr/>
			<?php
			the_excerpt();
			understrap_link_pages();
			?>
		</div><!-- .entry-content -->
	</div>

</article><!-- #post-<?php the_ID(); ?> -->
