<?php

$choosed_post_type = 'post';
$taxonomy = 'category';

?>

<section class='page-section news'>
  <div class="container">
		<div class='container posts-front'>
			<header class="page-section-heading">
				<h2 class="page-section-heading__title"><?= __('Aktualności','sputnik-wp-theme'); ?></h2>

				<div class='page-section-heading__meta'>
					<a href='<?= get_the_permalink(get_page_by_path(__('aktualnosci', 'sputnik-wp-theme'))); ?>' class='page-section-heading__anchor' title='<?= __('Zobacz wszystkie','sputnik-wp-theme'); ?>'><?= __('Zobacz wszystkie','sputnik-wp-theme'); ?></a>

          <?php require get_stylesheet_directory() . '/inc/posts-ajax/posts-ajax-form.php'; ?>

				</div>
			</header>

      <?php

      $news_args = array(
          'post_type' => $choosed_post_type,
          'posts_per_page' => 4,
          'post_status' => 'publish',
          'orderby' => 'date',
          'order' => 'DESC',
      );

      $news_query = new WP_Query($news_args);

      if($news_query->have_posts()) : ?>
          <div class='posts-loop'>
              <?php $i = 0; while($news_query->have_posts()) : $news_query->the_post(); ?>
              <?php if( !is_front_page() && ( $i == 0 || $i == 2 ) ) echo '<div class="posts-loop__wrapper">'; ?>
              <article id="post-<?= get_the_ID(); ?>" <?php post_class() . ' post'; ?>>
                    <div class="post-others-left">
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
                          <!-- Category -->
                          <div class="category-list">
                          <?php

                          $categories = get_the_category();

                          $categories = get_the_terms(get_the_ID(), $taxonomy);

                          $output = '';
                          if ( ! empty( $categories ) ) {
                            echo '<div class="category-list">Kategoria:';
                              foreach( $categories as $category ) {
                                $output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( __( 'Zobacz wszystkie wpisy w kategorii: %s', 'textdomain' ), $category->name ) ) . '" class="category-link">' . esc_html( $category->name ) . '</a>';
                              }
                              echo trim( $output );
                            echo '</div>';
                          } ?>
                          </div>
                          <a href="<?= get_the_permalink(); ?>" class="post-footer__button btn btn--primary" title='<?= __('Czytaj','sputnik-wp-theme') . ' - ' . get_the_title(); ?>'><?= __('Czytaj','sputnik-wp-theme'); ?></a>
                        </footer><!-- .entry-footer -->
                    </div>
                </article><!-- #post-<?= get_the_ID(); ?> -->
                <?php if( !is_front_page() && ( $i == 1 || $i ==  3) ) echo '</div>'; ?>
              <?php $i++; endwhile; ?>
          </div>
      <?php endif; wp_reset_query(); wp_reset_postdata(); ?>
	  </div>
  </div>
</section>

<script src="<?= get_stylesheet_directory_uri() . '/inc/posts-ajax/posts-ajax.js'; ?>"></script>