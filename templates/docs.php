<?php

get_header();

?>

<div class="wptoffeedocs-wrap wptoffeedocs-archive-wrap">

	<?php wptoffeedocs_get_template( 'search-form' ); ?>

    <div class="wptoffeedocs-archive-main">
		<?php

		$categories = get_terms( 'docs_category', array(
			'hide_empty' => false,
			'parent'   => 0,
			'meta_key' 	=> 'order',
			'orderby' 	=> 'meta_value_num',
			'order'		=> 'ASC'
		) );

		if ( ! empty( $categories ) ) {
			foreach ( $categories as $category ) {
				$name        = $category->name;
				$slug        = $category->slug;
				$count       = $category->count;
				$description = $category->description;
				$term_id     = $category->term_id;
				$term_link   = get_term_link( $category );
				$image_id    = get_term_meta( $term_id, 'category-image-id', true );

				$args = array(
					'post_type'      => 'docs',
					'posts_per_page' => 10,
					'orderby'        => array(
						'menu_order' => 'ASC',
						'date'       => 'ASC',
					),
					'order'          => 'ASC',
					'tax_query'      => array(
						array(
							'taxonomy' => 'docs_category',
							'field'    => 'slug',
							'terms'    => $slug,
						),
					),
				);

				$query = new WP_Query( $args );

				if ( $query->have_posts() ) {

					?>
                    <div class="wptoffeedocs-cat">

                        <div class="wptoffeedocs-cat-title">
                            <a href="<?php echo $term_link; ?>">
								<?php
								if ( $image_id ) {
									echo wp_get_attachment_image( $image_id );
								}
								?>
                                <span class="category-name"><?php echo $name ?></span>
                                <span class="docs-count"><?php echo $count; ?></span>
                        </div>

                        <div class="docs-list">
							<?php

							while ( $query->have_posts() ) {
								$query->the_post();
								$post_id = get_the_ID();
								$title   = get_the_title();
								$link    = get_the_permalink();
								$image   = get_the_post_thumbnail_url( $post_id, 'full' );
								?>
                                <a href="<?php echo $link; ?>" class="docs-list-item">
                                    <img class="doc-icon" src="<?php echo WPTOFFEE_DOCS_ASSETS; ?>/images/doc-icon.png"
                                         alt="doc">
                                    <span class="doc-title"><?php echo $title; ?></span>
                                </a>
								<?php
							}

							wp_reset_postdata();

							?>
                        </div>

                        <a href="<?php echo $term_link; ?>" class="wptoffeedocs-cat-btn">Explore More</a>

                    </div>
				<?php }
			}
		}

		?>
    </div>
</div>

<?php
get_footer();
?>
