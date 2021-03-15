<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sputnik_wp_theme
 */

$title_font_size = get_field('title_font_size');

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <div class="post-grid-top">
    <div class="post-grid-left">
      <div class="post-nav">
        <div class="post-nav__category">
          Kategoria:
        <?php
          $categories = get_the_category();
          $separator = ', ';
          $output = '';
          if ( ! empty( $categories ) ) {
              foreach( $categories as $category ) {
                  $output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '" class="category-color">' . esc_html( $category->name ) . '</a>' . $separator;

              }
              echo trim( $output, $separator );
          } ?>
        </div>
        <div class="post-nav__date">
          <?php echo '<i class="fas fa-clock"></i> Data publikacji: ' . get_the_date('d.m.Y') . 'r.'; ?>
        </div>
        <div class="post-nav__download">
          Pobierz
        </div>
        <div class="post-nav__print" onclick="window.print()" title="Drukuj <?php the_title(); ?>">
          Drukuj
        </div>
      </div>
      <header class="entry-header">
        <?php the_title('<h1 style="font-size:'. $title_font_size .'px">', '</h1>'); ?>
      </header><!-- .entry-header -->
      <div class="post-excerpt">
        <?php echo get_the_excerpt(); ?>
      </div>
    </div>
    <div class="post-grid-right">
      <figure>
        <?php sputnik_wp_theme_post_thumbnail('full'); ?>
      </figure>
    </div>
  </div>

  <div class="post-grid-bottom">
    <div class="entry-content">
      <?php the_content(); ?>
    </div><!-- .entry-content -->
    <aside class="posts-other">
      <div class="archive-sidebar">

        <?php
          $current = get_the_ID();

          $news_sidebar = array(
            'post_type' => 'post',
            'post__not_in' => array($current),
            'posts_per_page' => 4,
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
                      <?php if(has_post_thumbnail()) : ?>
                        <?php sputnik_wp_theme_post_thumbnail('medium'); ?>
                      <?php else : ?>
                        <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/app/public/images/dlugoleka-logo.png" title="<?php get_bloginfo() ?>" class="mock-img">
                      <?php endif; ?>
                      </figure>
                      <!-- <figure>
                          <?php// echo sputnik_wp_theme_post_thumbnail() ? sputnik_wp_theme_post_thumbnail('medium') : get_template_directory_uri(  ) . '/app/public/images/dlugoleka-logo.png'; ?>
                      </figure> -->
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
                            <?php  ?>

                            <a href="<?= get_the_permalink(); ?>" class="post-footer__button btn btn--primary" title='<?= __('Czytaj','sputnik-wp-theme'); ?>'><?= __('Czytaj','sputnik-wp-theme'); ?></a>
                        </footer><!-- .entry-footer -->
                    </section>
                </article><!-- #post-<?= get_the_ID(); ?> -->
              <?php	endwhile; ?>
            </div>
        <?php endif; wp_reset_query(); wp_reset_postdata(); ?>
      </div>
    </aside>
  </div>


	<footer class="entry-footer">
		<?php require CUSTOM_PARTS . '/modules/module-attachments.php'; ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
