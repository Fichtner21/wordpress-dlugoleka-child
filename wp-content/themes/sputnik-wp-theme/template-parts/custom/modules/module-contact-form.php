<form action="<?= get_template_directory_uri(); ?>/send-contact-form.php" method="POST" class="contact-form" id="contact-form-php">
    <h2 class="contact-form__title"><?= __('Zadaj pytanie Wójtowi','sputnik-wp-theme'); ?></h2>

    <div class="contact-form__wrapper">
        <div class="contact-form__row contact-form__row--2-col">
            <div class="contact-form__wrap">
                <label for="first-name" class="contact-form__label"><?= __('Imię','sputnik-wp-theme'); ?></label>
                <input type="text" id="first-name" name="first-name" class="contact-form__input" required>
            </div>

            <div class="contact-form__wrap">
                <label for="last-name" class="contact-form__label"><?= __('Nazwisko','sputnik-wp-theme'); ?></label>
                <input type="text" id="last-name" name="last-name" class="contact-form__input" required>
            </div>
        </div>

        <div class="contact-form__row">
            <div class="contact-form__wrap">
                <label for="email" class="contact-form__label"><?= __('Adres e-mail','sputnik-wp-theme'); ?></label>
                <input type="email" id="email" name="email" class="contact-form__input" required>
            </div>
        </div>

        <div class="contact-form__row">
            <div class="contact-form__wrap">
                <label for="topic" class="contact-form__label"><?=__('Temat','sputnik-wp-theme'); ?></label>
                <input type="text" id="topic" name="topic" class="contact-form__input" required>
            </div>
        </div>

        <div class="contact-form__row">
            <div class="contact-form__wrap">
                <label for="message" class="contact-form__label"><?= __('Wiadomość','sputnik-wp-theme'); ?></label>
                <textarea name="message" id="message" cols="30" rows="10" class="contact-form__input contact-form__input--textarea"></textarea required>
            </div>
        </div>

        <button type="submit" name="contact-form-submit" id="contact-form-submit" class="contact-form__submit" title="<?= __('Wyślij pytanie','sputnik-wp-theme'); ?>"><?= __('Wyślij pytanie','sputnik-wp-theme'); ?></button>

        <input type="hidden" name="token" id="token">
    </div>
</form>