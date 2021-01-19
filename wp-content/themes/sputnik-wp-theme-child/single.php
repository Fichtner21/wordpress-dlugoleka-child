<?php

get_header(); ?>

<main id="primary" class="site-main">
  <div class="container">	
    <?php require CUSTOM_PARTS . '/modules/module-breadcrumbs.php'; ?>
  </div>
  <div class="container">
  <?php while ( have_posts() ) : the_post();

    get_template_part( 'template-parts/content', 'single' );

    // the_post_navigation(
    //   array(
    //     'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Poprzedni:', 'sputnik-wp-theme' ) . '</span> <span class="nav-title">%title</span>',

    //     'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Następny:', 'sputnik-wp-theme' ) . '</span> <span class="nav-title">%title</span>',
    //   )
    // );

    // If comments are open or we have at least one comment, load up the comment template.
    // if ( comments_open() || get_comments_number() ) :
    //   comments_template();
    // endif;

    endwhile; // End of the loop. ?>
  </div>
</main>

<?php 

get_footer(); ?>