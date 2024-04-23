<?php

$name        = $category->name;
$slug        = $category->slug;
$count       = $category->count;
$description = $category->description;
$term_id     = $category->term_id;
$term_link   = get_term_link( $category );
$image_id    = get_term_meta( $term_id, 'category-image-id', true );
$taxonomy 	 = $category->taxonomy;
$current_post_id = get_the_ID();

?>


<aside class="wptoffeedocs-sidebar">
    <div class="sidebar-title">
        <a href="<?php echo $term_link; ?>">
			<?php
			if ( $image_id ) {
				echo wp_get_attachment_image( $image_id );
			}
			?>
            <span class="category-name"><?php echo $name ?></span>
            <span class="docs-count"><?php echo $count; ?></span>
        </a>
    </div>

	<div class="docs-list">
		<?php 
			$child_terms = get_terms(array(
				'taxonomy' 	=> $taxonomy,
				'parent' 	=> $term_id,
				'meta_key' 	=> 'order',
				'orderby' 	=> 'meta_value_num',
				'order'		=> 'ASC'
			));

			// check has child terms
			if( count($child_terms) > 0){
				foreach ($child_terms as $child_term) {
					?>
					<div class="docs-section">
						<div class="docs-section-title">
							<?php echo esc_html__($child_term->name, 'wptoffee-docs'); ?> <span class="docs-caret"></span>
						</div>
						<div class="docs-section-content">
							<?php
								$args = array(
									'post_type' => 'docs',
									'tax_query' => array(
										array(
											'taxonomy' 	=> $taxonomy,
											'field' 	=> 'id',
											'terms' 	=> $child_term->term_id,
										),
									),
									'orderby'        => array(
										'menu_order' => 'ASC',
										'date'       => 'ASC',
									),
									'order'          => 'ASC',
									'posts_per_page' => -1
								);
							
								$query = new WP_Query($args);
							
								// Loop through the query results
								if ($query->have_posts()) {
									while ($query->have_posts()) {
										$query->the_post();
										$post_id = get_the_ID();
										$title   = get_the_title();
										$link    = get_the_permalink();
										$image   = get_the_post_thumbnail_url( $post_id, 'full' );
						
										$active = $current_post_id == $post_id ? 'active' : '';
										?>
										<a href="<?php echo $link; ?>"
										class="docs-list-item <?php echo esc_attr( $active ); ?>">
										 <img class="doc-icon" src="<?php echo WPTOFFEE_DOCS_ASSETS; ?>/images/doc-icon.png" alt="doc">
										 <span class="doc-title"><?php echo esc_html__($title, 'wptoffee-docs'); ?></span>
									 </a>
									<?php
									}
									// Reset post data
									wp_reset_postdata();
								}
							?>
						</div>
					</div>
					<?php
				}
			}else{ ?>
				<div class="docs-section">
					<div class="docs-section-content-alt">
						<?php
							$args = array(
								'post_type' => 'docs',
								'tax_query'      => array(
									array(
										'taxonomy' => $taxonomy,
										'field'    => 'slug',
										'terms'    => $category->slug,
									),
								),
								'orderby'        => array(
									'menu_order' => 'ASC',
									'date'       => 'ASC',
								),
								'order'          => 'ASC',
								'posts_per_page' => -1	
							);
						
							$query = new WP_Query($args);
						
							// Loop through the query results
							if ($query->have_posts()) {
								while ($query->have_posts()) {
									$query->the_post();
									$post_id = get_the_ID();
									$title   = get_the_title();
									$link    = get_the_permalink();
									$image   = get_the_post_thumbnail_url( $post_id, 'full' );
					
									$active = $current_post_id == $post_id ? 'active' : '';
									?>
									<a href="<?php echo $link; ?>"
									class="docs-list-item <?php echo esc_attr( $active ); ?>">
										<img class="doc-icon" src="<?php echo WPTOFFEE_DOCS_ASSETS; ?>/images/doc-icon.png" alt="doc">
										<span class="doc-title"><?php echo esc_html__($title, 'wptoffee-docs'); ?></span>
									</a>
								<?php
								}
								// Reset post data
								wp_reset_postdata();
							}
						?>
					</div>
				</div>
			<?php
			}
		?>
	</div>
</aside>