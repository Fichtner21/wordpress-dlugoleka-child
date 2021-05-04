<?php

$page_ID = get_the_ID();
$nonce = wp_create_nonce("filter_posts_nonce");
$link = admin_url('admin-ajax.php?action=filter_posts&page_id='. $page_ID .'&nonce='. $nonce);

?>

<form action="<?= $link; ?>" method="POST" id="filter">
    <?php if( $terms = get_terms( array( 'taxonomy' => $taxonomy, 'orderby' => 'name' ) ) ) :
        echo '<label for="categoryfilter" class="screen-reader-text">Wybierz kategorię</label><select name="categoryfilter" id="categoryfilter" aria-label="Wybierz kategorie"><option value="'. $terms[0]->id .'">Wybierz kategorie...</option>';

        foreach ( $terms as $term ) :
            echo '<option value="' . $term->term_id . '">' . $term->name . '</option>';
        endforeach;

        echo '</select>';
    endif; ?>

    <button><?= __('Filtruj','sputnik-wp-theme'); ?></button>

    <input type="hidden" name="action" value="filter_posts">
</form>