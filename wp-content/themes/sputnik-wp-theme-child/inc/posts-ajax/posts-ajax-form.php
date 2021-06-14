<?php

$choosed_post_type; $taxonomy;

if(get_field('posts_sections') && !is_front_page()) {
   $choosed_post_type = get_field('posts_sections');
   $taxonomy = get_option($choosed_post_type);
} else {
  $choosed_post_type = 'post';
  $taxonomy = 'category';
}

$page_ID = get_the_ID();
$nonce = wp_create_nonce("filter_posts_nonce");
$link = admin_url('admin-ajax.php?action=filter_posts&page_id='. $page_ID .'&nonce='. $nonce);
$terms;

?>

<form action="<?= $link; ?>" method="POST" id="filter">
    <?php

    if($taxonomy !== false) {
      $terms = get_terms( array( 'taxonomy' => $taxonomy, 'orderby' => 'name' ) );
    } else {
      $terms = get_terms( array( 'taxonomy' => 'category', 'orderby' => 'name' ) );
    }

    if( is_array($terms) && !empty($terms) ) :
        echo '<label for="categoryfilter" class="screen-reader-text">Wybierz kategorię</label><select name="categoryfilter" id="categoryfilter" aria-label="Wybierz kategorie"><option value="'. $terms[0]->id .'">Wybierz kategorie...</option>';

        foreach ( $terms as $term ) :
            echo '<option value="' . $term->term_id . '">' . $term->name . '</option>';
        endforeach;

        echo '</select>'; ?>

        <button><?= __('Filtruj','sputnik-wp-theme'); ?></button>

        <input type="hidden" name="action" value="filter_posts">
    <?php else :
        echo __('Nie zostały dodane żadne kategorie.','sputnik-wp-theme');
    endif; ?>
</form>