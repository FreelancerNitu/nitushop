<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Nitu_shop
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

  <?php nitu_shop_post_thumbnail(); ?>

  <div class="post-content image-caption">

    <header class="entry-header">
      <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

      <?php if ( 'post' === get_post_type() ) : ?>
      <div class="entry-meta meta">
        <?php
					nitu_shop_post_date();
					nitu_shop_post_category();
					nitu_shop_posted_author();
					nitu_shop_post_comments_count();
					nitu_shop_post_edit_link();
				?>
      </div><!-- .entry-meta -->
      <?php endif; ?>
    </header><!-- .entry-header -->


    <div class="entry-summary">
      <?php 
				the_excerpt(); 
					
				$read_more_link = sprintf(
					// translators: %s: Name of current post. 
					wp_kses( __( 'Continue reading %s', 'nitu-shop' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				);
				
				echo '<a href="' . esc_url( get_permalink() ) . '" class="more" rel="bookmark">' . $read_more_link . '</a>';	
			?>
    </div><!-- .entry-summary -->


  </div><!-- .post-content .image-caption -->
</article><!-- #post-<?php the_ID(); ?> -->