<?php if(have_rows('attachments')) : ?>
    <div class='attachments'>
        <?php while(have_rows('attachments')) : the_row();
            $title = get_sub_field('title');
            $attachment = get_sub_field('attachment');
        ?>
            <div class="attachment">
                <p class="attachment__title"><?= $title; ?></p>

                <?php foreach($attachment as $file) :
                    $file_ID = $file['file']['ID'];
                    $file_title = $file['file']['title'];
                    $file_size = $file['file']['filesize'];
                    $file_size_converted = formatSizeUnits($file_size);
                    $file_url = $file['file']['url'];
                    ?>
                    <a target="_blank" href='<?= $file_url; ?>' class='attachment__file' title='<?= $file_title; ?>'>
                        <span><i class="fas fa-file-download"></i> <?= $file_title; ?></span>
                        <em><?= $file_size_converted; ?></em>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>