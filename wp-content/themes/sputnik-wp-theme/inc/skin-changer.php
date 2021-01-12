<?php
/* add change skin buttons */
if(is_admin()) {
	if(!function_exists('skin_buttons')) {
		function skin_buttons() {
			// Create custom_theme meta in options table
			update_option('custom_theme', 'default-page');
			// Update theme with radio value
			if(isset($_POST['skin-changer'])) {
				update_option('custom_theme', $_POST['skin-changer']);
			}
			// Check active theme
			$active_theme = get_option('custom_theme');

			?>

			<div class="skin-changer-buttons" id='js-skin-changer'>
				<button class="skin-changer-toggle" title="<?= __('Zmień Motyw okolicznościowy strony','sputnik-wp-theme'); ?>" aria-label="<?= __('Zmień Motyw okolicznościowy strony','sputnik-wp-theme'); ?>"><?= __('Zmień Motyw okolicznościowy strony','sputnik-wp-theme'); ?></button>

				<form action="" method="POST" class="skin-changer-form">
					<div class="skin-changer-form__row">
						<input id="default-page" type="radio" data-name="<?= __('Domyślny','sputnik-wp-theme'); ?>" class="skin-changer-form__input" name="skin-changer" value="default-page" <?php if($active_theme === 'default-page'): ?>checked<?php endif; ?>>
						<label for="default-page" class="skin-changer-form__label"><?= __('Domyślny','sputnik-wp-theme'); ?></label>
					</div>

					<div class="skin-changer-form__row">
						<input id="christmas-page" type="radio" data-name="<?= __('Świąteczny','sputnik-wp-theme'); ?>" class="skin-changer-form__input" name="skin-changer" value="christmas-page" <?php if($active_theme === 'christmas-page'): ?>checked<?php endif; ?>>
						<label for="christmas-page" class="skin-changer-form__label"><?= __('Świąteczny','sputnik-wp-theme'); ?></label>
					</div>

					<div class="skin-changer-form__row">
						<input id="easter-page" type="radio" data-name="<?= __('Wielkanocny','sputnik-wp-theme'); ?>" class="skin-changer-form__input" name="skin-changer" value="easter-page" <?php if($active_theme === 'easter-page'): ?>checked<?php endif; ?>>
						<label for="easter-page" class="skin-changer-form__label"><?= __('Wielkanocny','sputnik-wp-theme'); ?></label>
					</div>

					<div class="skin-changer-form__row">
						<input id="mourning-page" type="radio" data-name="<?= __('Żałobny','sputnik-wp-theme'); ?>" class="skin-changer-form__input" name="skin-changer" value="mourning-page" <?php if($active_theme === 'mourning-page'): ?>checked<?php endif; ?>>
						<label for="mourning-page" class="skin-changer-form__label"><?= __('Żałobny','sputnik-wp-theme'); ?></label>
					</div>

					<button class="button button-primary skin-changer-form__submit" type="submit" title='<?= __('Zapisz','sputnik-wp-theme'); ?>'><?= __('Zapisz','sputnik-wp-theme'); ?></button>
				</form>
			</div>

			<?php
		}
	}
	add_action('welcome_panel', 'skin_buttons');
}