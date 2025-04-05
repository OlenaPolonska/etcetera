<?php
/**
 * Single post partial template
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<h1 class="entry-title"><?php the_title() ?></h1>

		<div class="entry-meta">
			<?php understrap_posted_on(); ?>
		</div>

		<div class="real-estate-location">
			<?php 
				$location = intval( get_field('building') );
				$location_link = get_permalink( $location );
				$location_name = esc_textarea( get_field( 'name', $location ) );

			echo "<i class='fa-solid fa-building'></i> " . esc_html__( 'Is located here: ', 'etc' ) . "<a href='$location_link'>$location_name</a>" 
			?>
		</div>
	</header>
	
	<?php echo wp_get_attachment_image( esc_attr( get_field('photo') ), 'large', false, array( 'class' => 'real-estate-image') ); ?>

	<ul class="entry-options real-estate-options">
		<li>
			<i class="fa-solid fa-house"></i>
			<span><?php echo sprintf( esc_html__('Square, m<sup>2</sup>: %s', 'etc'), intval( get_field('square') ) ) ?></span>
		</li>
		<li>
			<i class="fa-solid fa-person-shelter"></i>
			<span><?php echo sprintf( esc_html__('Rooms: %s', 'etc'), intval( get_field('rooms') ) ) ?></span>
		</li>
		<li>
			<i class="fa-solid fa-door-open"></i>
			<span><?php echo sprintf( esc_html__('Balcony: %s', 'etc'), esc_textarea( get_field('balcony') ) ) ?></span>
		</li>
		<li>
			<i class="fa-solid fa-bath"></i>
			<span><?php echo sprintf( esc_html__('Bathroom: %s', 'etc'), esc_textarea( get_field('bathroom') ) ) ?></span>
		</li>
	</ul>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->