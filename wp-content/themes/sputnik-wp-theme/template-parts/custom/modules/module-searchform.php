
<?php $ID = wp_unique_id(); ?>

<form id="searchform" method="get" action="<?= esc_url( home_url( '/' ) ); ?>">
    <label for="d-search-form-input-<?= $ID; ?>" class="screen-reader-text"><?= __('Szukaj','sputnik-wp-theme'); ?>-<?= $ID; ?></label>

    <input type="text" class="search-field" id='d-search-form-input-<?= $ID; ?>' name="s" placeholder="<?= __('Szukaj...','sputnik-wp-theme'); ?>" value="<?= get_search_query(); ?>">

    <button type="submit" title="<?= __('Szukaj','sputnik-wp-theme'); ?>"><?= __('Szukaj','sputnik-wp-theme'); ?><span class='screen-reader-text'>-<?= $ID; ?></span></button>
    <!-- /* Add There custom post types Example: <input type="hidden" name="post_type[]" value="book" /> -->
</form>