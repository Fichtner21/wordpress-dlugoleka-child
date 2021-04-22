<section class='page-section news'>
    <div id="response"></div>

    <script>
      jQuery(function($){
        $('#filter').submit(function() {
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

                  echo '<label for="categoryfilter" class="screen-reader-text">Wybierz kategorię</label><select name="categoryfilter" id="categoryfilter" aria-label="Choose category"><option value="'.$terms.'">Wybierz kategorie...</option>';
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
              <button><?= __('Filtruj','sputnik-wp-theme'); ?></button>

              <input type="hidden" name="action" value="myfilter">
            </form>
					</div>
				</header>

      <?php

      $news_args = array(
          'post_type' => 'post',
          'posts_per_page' => 3,
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
                          <?php
                          $categories = get_the_category();
                          $separator = ', ';
                          $output = '';
                          if ( ! empty( $categories ) ) {
                            $i = 0;
                            foreach( $categories as $category ) {
                              $output .= '<div class="category-list">Kategoria: <a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '" class="category-link">' . esc_html( $category->name ) . '</a></div>';
                            }
                              echo trim( $output, $separator );
                              echo $i;
                            $i++;
                          } 
                          ?>
                          <a href="<?= get_the_permalink(); ?>" class="post-footer__button btn btn--primary" title='<?= __('Czytaj','sputnik-wp-theme') . ' - ' . get_the_title(); ?>'><?= __('Czytaj','sputnik-wp-theme'); ?></a>
                        </footer><!-- .entry-footer -->
                    </div>
                </article><!-- #post-<?= get_the_ID(); ?> -->
              <?php $i++; endwhile; ?>
          </div>
      <?php endif; wp_reset_query(); wp_reset_postdata(); ?>
</section>