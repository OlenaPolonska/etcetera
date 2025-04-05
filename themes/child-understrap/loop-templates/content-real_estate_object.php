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

		<h1 class="entry-title"><?php echo esc_html( get_field('name') ) ?></h1>

		<div class="entry-meta">
			<?php understrap_posted_on(); ?>
		</div>

		<div class="real-estate-location">
			<?php 
				$location = esc_textarea( get_field('location') );
				$location_link = add_query_arg( 'q', $location, 'https://maps.google.com' );
				echo "<i class='fa-solid fa-location-dot'></i> <a href='$location_link'>$location</a>" 
			?>
		</div>

	</header>
	
	<?php echo wp_get_attachment_image( esc_attr( get_field('photo') ), 'large', false, array( 'class' => 'real-estate-image') ); ?>

	<ul class="entry-options real-estate-options">
		<li>
			<i class="fa-solid fa-building" aria-hidden="true"></i>
			<span><?php echo sprintf( esc_html__('Floors: %s', 'etc'), intval( get_field('floors') ) ) ?></span>
		</li>
		<li>
			<i class="fa-solid fa-trowel-bricks"></i>
			<span><?php echo sprintf( esc_html__('Type of the building: %s', 'etc'), esc_textarea( get_field('type') ) ) ?></span>
		</li>
		<li>
			<span>
				<i class="fa-solid fa-leaf"></i>
				<?php 
				_e('Environmental friendly: ', 'etc'); 
				echo etcetera_get_stars( intval( get_field('environmental') ) ) ?>
			</span>
		</li>
	</ul>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>

	<ul class="entry-content" id="apartaments-list">
		<?php foreach ( get_field('apartaments') as $apartament ) : $id = $apartament->ID ?>
		<li>
			<h4><a href="<?php echo get_permalink($id) ?>">
				<?php echo $apartament->post_title ?></a>
			</h4>

			<?php echo wp_get_attachment_image( esc_attr( get_field( 'photo', $id ) ), 'thumbnail' ); ?>
			
			<ul class="entry-options apartment-options">
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
		</li>
		<?php endforeach; ?>
	</ul>

</article><!-- #post-<?php the_ID(); ?> -->