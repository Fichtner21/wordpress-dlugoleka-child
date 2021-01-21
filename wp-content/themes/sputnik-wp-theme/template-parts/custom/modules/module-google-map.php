<?php if(get_field('google_map_api_key', 'option')) : ?>
    <div class="map">
        <header class="page-section-heading container">
            <h2 class="page-section-heading__title"><?= __('Jak dojechać?','sputnik-wp-theme'); ?></h2>
        </header>
        <?php if(get_field('location', 'option')) : $location = get_field('location', 'option'); ?>
            <div class="google-map-container">
                <div class="google-map-container__map" id='map' data-lat='<?= $location["lat"]; ?>' data-lng='<?= $location["lng"]; ?>' data-zoom='<?= $location["zoom"]; ?>' data-address='<?= $location["address"]; ?>'></div>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>