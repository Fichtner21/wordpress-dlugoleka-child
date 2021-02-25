<?php

get_header(); ?>

<main id="primary" class="site-main">
  <div class="container">
    <?php require CUSTOM_PARTS . '/modules/module-breadcrumbs.php'; ?>
  </div>
  <div class="container">
  <?php while ( have_posts() ) : the_post();

    get_template_part( 'template-parts/content', 'single' );

    endwhile; // End of the loop. ?>
  </div>
</main>

<?php

get_footer(); ?>