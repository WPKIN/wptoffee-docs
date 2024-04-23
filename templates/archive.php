<?php

get_header();

$category = get_queried_object();

?>

<div class="wptoffeedocs-wrap wptoffeedocs-single-wrap">

	<?php wptoffeedocs_get_template( 'search-form' ); ?>

	<div class="wptoffeedocs-content-area">

		<?php wptoffeedocs_get_template( 'sidebar', [ 'category' => $category ] ); ?>

		<main id="wptoffeedocs-signle-main" <?php post_class( 'wptoffeedocs-single-main' ); ?>>

			<?php wptoffeedocs_get_template( 'breadcrumb' ); ?>

			<h3 class="wptoffeedocs-cat-title"><?php echo $category->name; ?></h3>

			<div class="docs-list">
				<?php

				$args = array(
					'post_type'      => 'docs',
					'posts_per_page' => - 1,
					'tax_query'      => array(
						array(
							'taxonomy' => 'docs_category',
							'field'    => 'slug',
							'terms'    => $category->slug,
						),
					),
					'orderby'        => array(
						'menu_order' => 'ASC',
						'date'       => 'ASC',
					),
					'order'          => 'ASC',
				);

				$query = new WP_Query( $args );

				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						$query->the_post();
						$post_id = get_the_ID();
						$title   = get_the_title();
						$link    = get_the_permalink();
						$image   = get_the_post_thumbnail_url( $post_id, 'full' );
						?>
						<a href="<?php echo $link; ?>" class="docs-list-item">
							<img class="doc-icon" src="<?php echo WPTOFFEE_DOCS_ASSETS; ?>/images/doc-icon.png" alt="doc">
							<span class="doc-title"><?php echo $title; ?></span>
						</a>
						<?php
					}

					wp_reset_postdata();
				}

				?>
			</div>

		</main>
	</div>
</div>

<?php get_footer(); ?>
