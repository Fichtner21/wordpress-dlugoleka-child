<!-- Main navigation menu -->
<nav id="site-navigation" class="main-navigation">
    <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
        <span class='screen-reader-text'><?= __( 'Menu główne', 'sputnik-wp-theme' ); ?></span>

        <span class="menu-toggle__line"></span>
        <span class="menu-toggle__line"></span>
        <span class="menu-toggle__line"></span>
    </button>

    <?php echo function_exists('display_custom_theme_menu') ? display_custom_theme_menu('menu-1') : null; ?>
</nav><!-- #site-navigation -->