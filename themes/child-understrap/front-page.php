<?php

defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="archive-wrapper">	
	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">
			<div id="home-sidebar" class="sidebar">
				<?php dynamic_sidebar( 'home-sidebar' ); ?>
			</div>
			<main class="site-main" id="main">

				<?php
				if ( have_posts() ) {
					?>
					<header class="page-header">
						<h1 class="page-title"><?php _e('The latest posts', 'etc') ?></h1>
					</header><!-- .page-header -->
					<?php
					// Start the loop.
					while ( have_posts() ) {
						the_post();
						get_template_part( 'loop-templates/content' );
					}
				} else {
					get_template_part( 'loop-templates/content', 'none' );
				}
				?>

			</main>

			<?php understrap_pagination(); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div>

<?php
get_footer();
