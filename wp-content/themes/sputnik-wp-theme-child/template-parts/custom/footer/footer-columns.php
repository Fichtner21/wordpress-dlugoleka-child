<?php $column_data = array(); ?>

<?php if(have_rows('footer_columns', 'option')) : ?>
    <div class='footer-columns'>
        <?php while( have_rows('footer_columns', 'option') ) : the_row(); ?>
            <?php

            $column = array();
            $content = get_sub_field('content'); if(!empty($content)) :

            ?>
                <?php foreach($content as $element) : ?>
                    <?php foreach($element as $key => $el) : ?>
                        <?php switch($key) {
                            case 'image' :
                                $image = '<img src="'. $element['image']['url'] .'" alt="'. $element['image']['alt'] .'">';

                                array_push($column, $image);

                                break;
                            case 'title' :
                                $title = '<p>'. $element['title'] .'</p>';

                                array_push($column, $title);

                                break;
                            case 'content' :
                                $content = '<p>'. $element['content'] .'</p>';

                                array_push($column, $content);

                                break;
                            case 'menu' :
                                $menu = '<p>'. $element['menu'] .'</p>';

                                array_push($column, $menu);

                                break;
                        }; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php array_push($column_data, $column); endwhile; ?>

        <?php if(!empty($column_data)) {
            foreach($column_data as $data) {
                echo '<div class="footer-columns__column">';
                    foreach($data as $element) {
                        echo $element;
                    }
                echo '</div>';
            }
        } ?>
    </div>
<?php endif; ?>