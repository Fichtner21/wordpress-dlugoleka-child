<?php

$address = get_option('address');
$open_hours = get_option('open_hours');
$phone = get_option('phone');
$phone_trimmed = trim(str_replace(' ', '', $phone));
$fax = get_option('fax');
$email = get_option('email');
$bank_account_1 = get_option('bank_account_1');
$bank_account_2 = get_option('bank_account_2');

?>

<div class="contact-informations">
    <h3 class="contact-informations__title"><?= __('Dane kontaktowe urzędu','sputnik-wp-theme'); ?></h3>

    <div class="contact-informations__row">
        <?php if(is_page('kontakt')) echo '<i class="fas fa-globe"></i>'; ?>

        <p class="contact-informations__subtitle"><?= __('Adres urzędu','sputnik-wp-theme'); ?>:</p>
        <p class="contact-informations__data"><?= __($address,'sputnik-wp-theme'); ?></p>
    </div>

    <div class="contact-informations__row">
        <?php if(is_page('kontakt')) echo '<i class="far fa-clock"></i>'; ?>

        <p class="contact-informations__subtitle"><?= __('Godziny otwarcia','sputnik-wp-theme'); ?>:</p>
        <p class="contact-informations__data"><?= __($open_hours,'sputnik-wp-theme'); ?></p>
    </div>

    <div class="contact-informations__row">
        <?php if(is_page('kontakt')) echo '<i class="fas fa-phone-volume"></i>'; ?>

        <p class="contact-informations__subtitle"><?= __('Kontakt','sputnik-wp-theme'); ?>:</p>
        <p class="contact-informations__data"><?= __('tel.','sputnik-wp-theme'); ?><a href="tel:<?= $phone_trimmed; ?>" title="<?= $phone; ?>"><?= $phone; ?></a> <?= __('fax.','sputnik-wp-theme'); ?><span><?= $fax; ?></span></p>
    </div>

    <div class="contact-informations__row">
        <?php if(is_page('kontakt')) echo '<i class="far fa-credit-card"></i>'; ?>

        <p class="contact-informations__subtitle"><?= __('Nr. konta bankowego','sputnik-wp-theme'); ?>:</p>
        <p class="contact-informations__data"><?= $bank_account_1; ?></p>
        <p class="contact-informations__data"><?= $bank_account_2; ?></p>
    </div>
</div>