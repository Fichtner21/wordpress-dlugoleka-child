<?php

$location = get_field('location', 'option');
$map_or_image = get_field('map_or_image', 'option');

if( !empty($map_or_image) && $map_or_image != false ): ?>

<div class="acf-map">
    <div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
</div>

<?php else :
    $google_map_image = get_field('google_map_image', 'option');
    $google_map_link = get_field('google_map_link', 'option');
?>

<a href="<?= $google_map_link['url']; ?>" class="google-map-image" target="_blank" title="<?= $google_map_link['title']; ?>">
    <span class="screen-reader-text"><?= $google_map_link['title']; ?></span>
    <img src='<?= $google_map_image['url']; ?>' alt='<?= $google_map_image['alt']; ?>' class='google-map-image__image'>
</a>

<?php endif; ?>