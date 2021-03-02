<?php

if(get_option('choose_cpt_wydarzenia')) require CUSTOM_INC . '/custom-post-types/custom-post-type-wydarzenia.php';

if(get_option('choose_cpt_galerie')) require CUSTOM_INC . '/custom-post-types/custom-post-type-galerie.php';

if(get_option('choose_cpt_komunikaty')) require CUSTOM_INC . '/custom-post-types/custom-post-type-komunikaty.php';

if(get_option('choose_cpt_atrakcje')) require CUSTOM_INC . '/custom-post-types/custom-post-type-atrakcje.php';

if(get_option('choose_cpt_dzialaj-lokalnie')) require CUSTOM_INC . '/custom-post-types/custom-post-type-dzialaj-lokalnie.php';

if(get_option('choose_cpt_ochrona-srodowiska')) require CUSTOM_INC . '/custom-post-types/custom-post-type-ochrona-srodowiska.php';