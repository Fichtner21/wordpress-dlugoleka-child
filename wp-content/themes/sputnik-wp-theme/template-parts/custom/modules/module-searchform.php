<form id="searchform" method="get" action="<?= esc_url( home_url( '/' ) ); ?>">
    <label for="d-search-form-input" class="screen-reader-text"><?= __('Szukaj','sputnik-wp-theme'); ?></label>

    <input type="text" class="search-field" id='d-search-form-input' name="s" placeholder="<?= __('Szukaj...','sputnik-wp-theme'); ?>" value="<?= get_search_query(); ?>">

    <input type="submit" value="<?= __('Szukaj','sputnik-wp-theme'); ?>">
    <!-- /* Add There custom post types Example: <input type="hidden" name="post_type[]" value="book" /> -->
</form>