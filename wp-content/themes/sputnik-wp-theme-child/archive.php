<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sputnik_wp_theme
 */

get_header(); ?>

	<main id="primary" class="site-main">
		<div class="container">
			<?php require CUSTOM_PARTS . '/modules/module-breadcrumbs.php'; ?>			
			
			<div class="container-news">
				<div class='archive-posts'>
					<header class="page-section-heading">
						<h1 class="page-section-heading__title"><?= get_the_archive_title(); ?></h1>
					</header>
					<?php
					$exclude = array();

					if(have_posts()) : ?>
							<div class='posts-loop'>
									<?php while(have_posts()) : the_post();
											array_push( $exclude, get_the_ID());
											custom_post_loop_template_dlugoleka();
									endwhile; ?>
							</div>
					<?php endif; wp_reset_query(); wp_reset_postdata(); ?>
				</div>

				<div class="archive-sidebar">
					<?php
						$news_sidebar = array(
							'post_type' => 'post',
							'post__not_in' => $exclude,
							'posts_per_page' => 8,
							'post_status' => 'publish',
							'orderby' => 'date',
							'order' => 'DESC',
						);

						$news_others = new WP_Query($news_sidebar);
						if($news_others->have_posts()) : ?>
							<h2>Inne aktualności</h2>
							<div class='posts-loop'>
									<?php while($news_others->have_posts()) : $news_others->the_post(); ?>
											<article id="post-<?= get_the_ID(); ?>" <?php post_class(); ?>>
											<div class="post-others-left">
												<div class="post-others-left__category">
													<?php
													$categories = get_the_category();
													$separator = ', ';
													$output = '';
													if ( ! empty( $categories ) ) {
															foreach( $categories as $category ) {
																	$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '" style="background-color:'.get_field('category_color', $category).'" class="category-color">' . esc_html( $category->name ) . '</a>' . $separator;

															}
															echo trim( $output, $separator );
													} ?>
												</div>
												<figure>
														<?php sputnik_wp_theme_post_thumbnail('medium'); ?>
												</figure>
											</div>
											<div class="post-bulk">
													<header class="post-heading">
															<div class="post-heading-meta">
																	<?php echo '<i class="fas fa-clock"></i> Data publikacji: ' . get_the_date('d.m.Y') . 'r.'; ?>
															</div>
															<?php the_title( '<div class="post-heading__title"><h3><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3></div>' ); ?>

													</header><!-- .entry-header -->

													<div class="post-content">
															<?= get_custom_excerpt(200); ?>

													</div><!-- .entry-content -->

													<footer class="post-footer">
															<!-- Category -->
															<?php  ?>

															<a href="<?= get_the_permalink(); ?>" class="post-footer__button btn btn--primary" title='<?= __('Czytaj','sputnik-wp-theme') . ' - ' . get_the_title(); ?>'><?= __('Czytaj','sputnik-wp-theme'); ?></a>
													</footer><!-- .entry-footer -->
											</div>
									</article><!-- #post-<?= get_the_ID(); ?> -->
								<?php	endwhile; ?>
							</div>
					<?php endif; wp_reset_query(); wp_reset_postdata(); ?>
				</div>
			</div>
			<?php require CUSTOM_PARTS . '/modules/module-pagination.php'; ?>
		</div>
	</main><!-- #main -->

<?php get_footer();