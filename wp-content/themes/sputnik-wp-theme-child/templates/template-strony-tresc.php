<?php /* Template Name: Treść */

get_header();

$choosed_post_type = get_field('posts_sections');
$taxonomy = get_option($choosed_post_type);

?>

	<main id="primary" class="site-main content-template">

		<div class='container'>
			<?php require CUSTOM_PARTS . '/modules/module-breadcrumbs.php'; ?>

			<div class="post-nav">
				<div class="post-nav__download" title="Pobierz do PDF <?php echo the_title(); ?>">
					<?= shortcode_exists('dkpdf-button') ? do_shortcode('[dkpdf-button]') : false; ?>
				</div>

				<div class="post-nav__print" onclick="window.print()" title="Drukuj <?php the_title(); ?>">Drukuj</div>
			</div>

			<div class="post-wrapper">
				<div class="post-content">
					<h1><?= get_the_title(); ?></h1>

					<?php echo apply_filters( 'the_content', get_the_content() ); ?>

					<footer class="entry-footer">
						<?php require CUSTOM_PARTS . '/modules/module-attachments.php'; ?>
					</footer><!-- .entry-footer -->
				</div>

				<div class="archive-sidebar">
					<?php
					$news_sidebar = array(
						'post_type' => $choosed_post_type,
						'post__not_in' => $exclude,
						'posts_per_page' => 8,
						'post_status' => 'publish',
						'orderby' => 'date',
						'order' => 'DESC',
					);

					$news_others = new WP_Query($news_sidebar);
					if($news_others->have_posts()) : ?>
					<h2>Aktualności</h2>

          <?php require get_stylesheet_directory() . '/inc/posts-ajax/posts-ajax-form.php'; ?>
          <script src="<?= get_stylesheet_directory_uri() . '/inc/posts-ajax/posts-ajax.js'; ?>"></script>

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
												$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '" style="background-color:'.get_field('category_color', $category).'" class="category-color">' . esc_html( $category->name ) . '</a>';
												// . $separator;
											}
											echo trim( $output, $separator );
										} ?>
									</div>

									<?php if (has_post_thumbnail( get_the_ID() ) ) { ?>
										<figure><?php sputnik_wp_theme_post_thumbnail('medium');  ?></figure>
									<?php } else { ?>
										<figure>
												<img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/app/public/images/dlugoleka-logo.png" title="<?php get_bloginfo('name'); ?>" alt="<?php get_bloginfo('name'); ?>"/>
										</figure>
										<?php } ?>
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
										<a href="<?= get_the_permalink(); ?>" class="post-footer__button btn btn--primary" title='<?= __('Czytaj','sputnik-wp-theme') . ' - ' . get_the_title(); ?>'><?= __('Czytaj','sputnik-wp-theme'); ?></a>
									</footer><!-- .entry-footer -->
								</div>
							</article><!-- #post-<?= get_the_ID(); ?> -->
						<?php	endwhile; ?>
					</div>
					<?php endif; wp_reset_query(); wp_reset_postdata(); ?>
				</div>
			</div>
		</div>
	</main><!-- #main -->

<?php get_footer();