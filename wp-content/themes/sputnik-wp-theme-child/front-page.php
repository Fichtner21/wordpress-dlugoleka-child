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

$choosed_elements = get_field('choose_elements');

get_header(); ?>

	<main id="primary" class="site-main">
		<div class="hero-and-links">
			<?php if(in_array('slider-hero', $choosed_elements)) require CUSTOM_PARTS . '/modules/sliders/slider-hero.php'; ?>

			<div class='slider-icon-links container'>
				<?php require CUSTOM_PARTS . '/modules/sliders/slider-icon-links.php'; ?>

				<?php function_exists('custom_swiper_arrows') ? custom_swiper_arrows() : null; ?>
			</div>
		</div>

		<section class='page-section news'>
      <div class="container">

    <div id="response"></div>
      <script>
      jQuery(function($){
        $('#filter').submit(function(){
        var filter = $('#filter');
        $.ajax({
          url:filter.attr('action'),
          data:filter.serialize(), // form data
          type:filter.attr('method'), // POST
          beforeSend:function(xhr){
            filter.find('button').text('W toku...'); // changing the button label
          },
          success:function(data){
            filter.find('button').text('Filtruj'); // changing the button label back

            $('.posts-front .posts-loop').html(data); // insert data
          }
        });
        return false;
        });
      });
  </script>
<?php

?>

			<div class='container posts-front'>
				<header class="page-section-heading">
					<h2 class="page-section-heading__title"><?= __('Aktualności','sputnik-wp-theme'); ?></h2>

					<div class='page-section-heading__meta'>
						<a href='<?= get_the_permalink(get_page_by_path(__('aktualnosci', 'sputnik-wp-theme'))); ?>' class='page-section-heading__anchor' title='<?= __('Zobacz wszystkie','sputnik-wp-theme'); ?>'><?= __('Zobacz wszystkie','sputnik-wp-theme'); ?></a>

						<!-- <div class="page-section-heading__terms">
							<span><?= __('Filtry','sputnik-wp-theme'); ?>:</span>
							<?= function_exists('show_terms_with_childrens') ? show_terms_with_childrens('category') : null; ?>
            </div> -->
            <form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php"     method="POST" id="filter">
              <?php
                if( $terms = get_terms( array( 'taxonomy' => 'category', 'orderby' => 'name' ) ) ) :

                  echo '<select name="categoryfilter"><option value="'.$terms.'">Wybierz kategorie...</option>';
                  foreach ( $terms as $term ) :
                    echo '<option value="' . $term->term_id . '">' . $term->name . '</option>'; // ID of the category as the value of an option
                  endforeach;
                  echo '</select>';
                endif;
              ?>

              <!-- <label>
                <input type="radio" name="date" value="ASC" /> Data: rosnąco
              </label>
              <label>
                <input type="radio" name="date" value="DESC" selected="selected" /> Data: malęjąco
              </label>
              <label>
                <input type="checkbox" name="featured_image" /> Tylko posty z miniaturką
              </label> -->
              <button>Filtruj</button>
              <input type="hidden" name="action" value="myfilter">
            </form>
					</div>
				</header>

				<?php //require CUSTOM_PARTS . '/loops/loop-news.php'; ?>
        <?php
        $news_args = array(
          'post_type' => 'post',
          'posts_per_page' => 4,
          'post_status' => 'publish',
          'orderby' => 'date',
          'order' => 'DESC',
      );

      $news_query = new WP_Query($news_args);

      if($news_query->have_posts()) : ?>
          <div class='posts-loop'>
              <?php while($news_query->have_posts()) : $news_query->the_post(); ?>
              <article id="post-<?= get_the_ID(); ?>" <?php post_class() . ' post'; ?>>
                    <div class="post-others-left">
                    <?php
                        if (has_post_thumbnail( get_the_ID() ) ){ ?>
                            <figure>
                            <?php
                                sputnik_wp_theme_post_thumbnail('medium');
                            ?>
                            </figure>
                            <?php
                        } else { ?>
                            <figure>
                                <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/app/public/images/dlugoleka-logo.png" title="<?php get_bloginfo('name'); ?>" alt="<?php get_bloginfo('name'); ?>"/>
                            </figure>
                        <?php
                        }
                    ?>

                    </div>
                    <section class="post-bulk">
                        <header class="post-heading">
                                <div class="post-heading-meta">
                                        <?php echo '<i class="fas fa-clock"></i> Data publikacji: ' . get_the_date('d.m.Y') . 'r.'; ?>
                                </div>
                                <?php the_title( '<div class="post-heading__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></div>' ); ?>

                        </header><!-- .entry-header -->

                        <div class="post-content">
                                <?= get_custom_excerpt(200); ?>

                        </div><!-- .entry-content -->

                        <footer class="post-footer">
                                <!-- Category -->

                          <?php
                          $categories = get_the_category();
                          $separator = ', ';
                          $output = '';
                          if ( ! empty( $categories ) ) {
                                  foreach( $categories as $category ) {
                                          $output .= '<div class="category-list">Kategoria: <a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '" class="category-link">' . esc_html( $category->name ) . '</a></div>';

                                  }
                                  echo trim( $output, $separator );
                          } ?>


                          <a href="<?= get_the_permalink(); ?>" class="post-footer__button btn btn--primary" title='<?= __('Czytaj','sputnik-wp-theme'); ?>'><?= __('Czytaj','sputnik-wp-theme'); ?></a>
                        </footer><!-- .entry-footer -->
                    </section>
                </article><!-- #post-<?= get_the_ID(); ?> -->
              <?php
              endwhile; ?>
          </div>
      <?php endif; wp_reset_query(); wp_reset_postdata(); ?>
			</div>
		</section>

		<section class='page-section events'>
			<div class='container'>
				<header class="page-section-heading">
					<h2 class="page-section-heading__title"><?= __('Wydarzenia','sputnik-wp-theme'); ?></h2>
				</header>

				<div class='events__wrapper'>
					<?php require CUSTOM_PARTS . '/modules/module-calendar.php'; ?>

					<?php require CUSTOM_PARTS . '/loops/loop-events.php'; ?>
				</div>
			</div>
		</section>

		<div class='page-sections-wrapper container'>
			<section class='page-section attractions'>
				<header class="page-section-heading">
					<h2 class="page-section-heading__title"><?= __('Atrakcje','sputnik-wp-theme'); ?></h2>
				</header>

				<?php require CUSTOM_PARTS . '/loops/loop-attractions.php'; ?>
			</section>

			<section class='page-section act-locally'>
				<header class="page-section-heading">
					<h2 class="page-section-heading__title"><?= __('Działaj lokalnie','sputnik-wp-theme'); ?></h2>
				</header>

				<?php require CUSTOM_PARTS . '/loops/loop-act-locally.php'; ?>
			</section>
		</div>

		<section class='page-section emergency-numbers'>
			<div class='container'>
				<header class="page-section-heading">
					<h2 class="page-section-heading__title"><?= __('Numery alarmowe','sputnik-wp-theme'); ?></h2>
				</header>

				<?php require CUSTOM_PARTS . '/modules/sliders/slider-emergency-numbers.php'; ?>

				<?php function_exists('custom_swiper_arrows') ? custom_swiper_arrows() : null; ?>
			</div>
		</section>

		<section class="page-section poll-map-apps">
			<div class='container'>
				<?php if(get_option('choose_poll_shortcode')) :
					$choose_poll_shortcode = get_option('choose_poll_shortcode');
					?>
					<div class='col-4 poll'>
						<header class="page-section-heading">
							<h2 class="page-section-heading__title"><?= __('Ankieta','sputnik-wp-theme'); ?></h2>
						</header>

						<?= do_shortcode( get_option('choose_poll_shortcode') ); ?>
					</div>
				<?php endif; ?>

				<?php if(get_option('google_maps_key') || (get_option('google_play_link') || get_option('app_store_link'))) : ?>
					<div class='col-8 map-apps'>
						<?php require CUSTOM_PARTS . '/modules/module-google-map.php'; ?>

						<?php require CUSTOM_PARTS . '/modules/module-mobile-apps.php'; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
	</main><!-- #main -->

<?php get_footer();