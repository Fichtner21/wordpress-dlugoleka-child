<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sputnik_wp_theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<?php sputnik_wp_theme_post_thumbnail(); ?>

	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php require CUSTOM_PARTS . '/modules/module-attachments.php'; ?>
  </footer><!-- .entry-footer -->

	<?php
    $args = array(
      'post_type'      => 'page',
      'posts_per_page' => -1,
      'post_parent'    => $post->ID,
      'order'          => 'ASC',
      'orderby'        => 'menu_order'
    );

    $parent = new WP_Query( $args );
      if ( $parent->have_posts() ) : ?>
      <div class="pages__children">
        <?php
        if(isset($parent)){
    		  echo "<div class='children__title'><span>Strony w dziale: </span></div>";
        }
        ?>
        <div class="child-page-container">
          <?php while ( $parent->have_posts() ) : $parent->the_post(); ?>
          <div id="parent-<?php the_ID(); ?>" class="child-page">
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
	            <div class="child-page-thumb">
	            	<div class="child-page-title">
            			<div class="child-page-title-main">
						      <?php
	            			$title = get_the_title();

							      if (strlen($title) > 60)
						        	echo mb_substr($title, 0, 60,"utf-8") . '...' . "<style type='text/css'>.child-page-title a {margin-bottom: 0}</style>";
						        else
								    echo $title . ' ';
						      ?>
						      </div>
						    <?php if(get_the_excerpt()){ ?>
							  <div class="child-page-excerpt-main">
								  <?php echo strip_tags(get_the_excerpt()); ?>
							  </div>
						    <?php } else { ?>

						    <?php } ?>
	            	</div>
	            	<figure>
						    <?php if(has_post_thumbnail()): ?>
							    <img src="<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
							  <?php else : ?>
							    <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/app/public/images/dlugoleka-logo.png" title="<?php get_bloginfo('name'); ?>" alt="<?php get_bloginfo('name'); ?>" style="margin-left: 20px; margin-bottom: 75px;"/>
						    <?php endif; ?>
					      </figure>
				  </div>
			  </a>
      </div>

    <?php endwhile; ?>
    </div>
<?php endif; wp_reset_postdata(); ?>
</article><!-- #post-<?php the_ID(); ?> -->
