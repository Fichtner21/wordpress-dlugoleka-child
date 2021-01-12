<!-- Site logo -->
<div class="site-branding">
    <?php the_custom_logo();

    if ( is_front_page() || is_home() ) : ?>
        <h1 class="site-branding__title">
            <a href="<?= esc_url( home_url( '/' ) ); ?>" rel="home" title='<?= get_bloginfo( 'name' ); ?>'><?= get_bloginfo( 'name' ); ?></a>
        </h1>
     <?php else : ?>
        <p class="site-branding__title">
            <a href="<?= esc_url( home_url( '/' ) ); ?>" rel="home" title='<?= get_bloginfo( 'name' ); ?>'><?= get_bloginfo( 'name' ); ?></a>
        </p>
    <?php endif;

    $sputnik_wp_theme_description = get_bloginfo( 'description', 'display' );

    if ( $sputnik_wp_theme_description || is_customize_preview() ) :  ?>
        <p class="site-branding__description"><?= $sputnik_wp_theme_description; ?></p>
    <?php endif; ?>
</div><!-- .site-branding -->