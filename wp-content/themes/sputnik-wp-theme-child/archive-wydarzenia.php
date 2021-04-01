<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sputnik_wp_theme
 */

 function eventTemplate() { ?>
	<article id="post-<?= get_the_ID(); ?>" <?php post_class(); ?>>
		<figure>
			<?php sputnik_wp_theme_post_thumbnail(); ?>
		</figure>

		<div class="post-bulk">
			<header class="post-heading">
				<div class="post-heading-meta">
					<?php sputnik_wp_theme_posted_on_dlugoleka(); ?>

					<?php if(get_field('oneday_event')[0]['localization']) : $localization = get_field('oneday_event')[0]['localization']; ?>
						<p class="post-localization"><i class="fas fa-map-marker-alt"></i> <?= __('Gdzie?', 'sputnik-wp-theme'); ?> <?= $localization; ?></p>
					<?php elseif(get_field('multiple_event')[0]['localization']) : $localization = get_field('multiple_event')[0]['localization']; ?>
						<p class="post-localization"><i class="fas fa-map-marker-alt"></i> <?= __('Gdzie?', 'sputnik-wp-theme'); ?> <?= $localization; ?></p>
					<?php elseif(get_field('endless_event')[0]['localization']) : $localization = get_field('endless_event')[0]['localization']; ?>
						<p class="post-localization"><i class="fas fa-map-marker-alt"></i> <?= __('Gdzie?', 'sputnik-wp-theme'); ?> <?= $localization; ?></p>
					<?php endif; ?>
				</div>

				<?php the_title( '<h2 class="post-heading__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
			</header><!-- .entry-header -->

			<div class="post-content">
				<?= get_custom_excerpt(128); ?>
			</div><!-- .entry-content -->

			<footer class="post-footer">
				<a href="<?= get_the_permalink(); ?>" class="post-footer__button btn btn--primary" title='<?= __('Czytaj','sputnik-wp-theme') . ' - ' . get_the_title(); ?>'><?= __('Czytaj','sputnik-wp-theme'); ?></a>
			</footer><!-- .entry-footer -->
		</div>
	</article><!-- #post-<?= get_the_ID(); ?> -->
 <?php }

get_header(); ?>

	<main id="primary" class="site-main events-archive">
		<div class='container'>
			<?php require CUSTOM_PARTS . '/modules/module-breadcrumbs.php'; ?>

			<div class="events-archive__wrapper">
				<div class='events-archive__content'>
					<header class="entry-header">
						<h1 class='entry-title'><?= __('Kalendarz wydarzeń','sputnik-wp-theme'); ?></h1>
					</header><!-- .entry-header -->

					<div class="events__wrapper">
						<?php require CUSTOM_PARTS . '/modules/module-calendar.php'; ?>

						<?php

						$now = date('Y-m-d');

						$now_value = intval(strtotime($now));

						$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

						$events_args = array(
							'post_type' => 'wydarzenia',
							'posts_per_page' => 2,
							'post_status' => 'publish',
							'orderby' => 'date',
							'order' => 'ASC',
							'paged' => $paged,
						);

						$events_query = new WP_Query($events_args); ?>

						<p class="events__wrapper__title">Wydarzenia w dniu <span class='event-date-choosed'><?= $now; ?></span></p>

						<div class="posts-loop archive-calendar-results">

							<?php while($events_query->have_posts()) : $events_query->the_post();
								$oneday_event_date_start = get_field('oneday_event', get_the_ID())[0]['date_start'];
								$multiple_event_date_start = get_field('multiple_event', get_the_ID())[0]['date_start'];
								$endless_event_date_start = get_field('endless_event', get_the_ID())[0]['date_start'];

								if($now === $oneday_event_date_start || $now === $multiple_event_date_start || $now === $endless_event_date_start) echo eventTemplate();
							endwhile; ?>

						</div>

						<?php if($events_query->have_posts()) : ?>

						<p class="events__wrapper__title">Najbliższe wydarzenia</p>

						<div class='posts-loop'>
							<?php while($events_query->have_posts()) : $events_query->the_post();
								$oneday_event_date_start = get_field('oneday_event')[0]['date_start'];
								$multiple_event_date_start = get_field('multiple_event')[0]['date_start'];
								$endless_event_date_start = get_field('endless_event')[0]['date_start'];

								$date_start_value;

								if($oneday_event_date_start != null) {
									$date_start_value = intval(strtotime($oneday_event_date_start));
								} elseif($multiple_event_date_start != null) {
									$date_start_value = intval(strtotime($multiple_event_date_start));
								} elseif($endless_event_date_start != null) {
									$date_start_value = intval(strtotime($endless_event_date_start));
								}

								if($now_value <= $date_start_value) echo eventTemplate(); endwhile; ?>
						</div>

						<?php require CUSTOM_PARTS . '/modules/module-pagination.php'; ?>

						<?php endif; wp_reset_query(); wp_reset_postdata(); ?>
					</div>


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

					<h2>Aktualności</h2>

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
									<a href="<?= get_the_permalink(); ?>" class="post-footer__button btn btn--primary" title='<?= __('Czytaj','sputnik-wp-theme') . ' - ' . get_the_title(); ?>'><?= __('Czytaj','sputnik-wp-theme'); ?></a>
								</footer><!-- .entry-footer -->
							</div>
						</article><!-- #post-<?= get_the_ID(); ?> -->

						<?php endwhile; ?>
					</div>

					<?php endif; wp_reset_query(); wp_reset_postdata(); ?>
				</div>
			</div>
		</div>
	</main><!-- #main -->

<?php get_footer();
