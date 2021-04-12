<?php /* Template Name: Kontakt */

get_header(); ?>

	<main id="primary" class="site-main">
        <div class='container'>
            <?php require CUSTOM_PARTS . '/modules/module-breadcrumbs.php'; ?>

            <div class="contact-page">
                <header class="entry-header">
                    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                </header><!-- .entry-header -->

                <div class="contact-page__wrapper">
                    <div class="contact-page__col">
                        <?php require CUSTOM_PARTS . '/modules/module-contact-informations.php'; ?>
                    </div>

                    <div class="contact-page__col">
                        <?php if(!shortcode_exists('contact-form-7')) {
                            require CUSTOM_PARTS . '/modules/module-contact-form.php';
                        } else {
                            echo do_shortcode('[contact-form-7 id="1365" title="Formularz kontaktowy"]');
                        } ?>
                    </div>
                </div>

                <?php require CUSTOM_PARTS . '/modules/module-google-map.php'; ?>
            </div>
        </div>
	</main><!-- #main -->

<?php get_footer();