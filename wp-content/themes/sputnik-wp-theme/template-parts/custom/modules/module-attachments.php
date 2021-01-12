<?php if(have_rows('attachments')) : ?>
    <div class='attachments'>
        <?php while(have_rows('attachments')) : the_row();
            $title = get_sub_field('title');
            $attachment = get_sub_field('attachment');
        ?>
            <div class="attachment">
                <p class="attachment__title"><?= $title; ?></p>

                <?php echo '<pre>';
                var_dump($attachment);
                echo '</pre>'; ?>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>