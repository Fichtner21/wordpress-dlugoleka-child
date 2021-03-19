<?php

/*
Template Name: Mapa interaktywna
*/

get_header();
?>
<div class="container">
<?php
  require CUSTOM_PARTS . '/modules/module-breadcrumbs.php'; 
?>
</div>
<?php

require CUSTOM_PARTS . '/modules/module-map.php'; 

get_footer();