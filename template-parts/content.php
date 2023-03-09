<?php
/**
 * Template part for displaying posts
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
      <?php
			
			$nitu_shop_sticky_post_icon = ( is_sticky() ) ? '<i class="fa fa-thumb-tack" title="Sticky Post" style="color: #3f8dbf;"></i>' : '' ;
			
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title post-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title post-title">' . $nitu_shop_sticky_post_icon . ' <a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;

			if ( 'post' === get_post_type() ) : ?>
      <div class="entry-meta meta">
        <?php
					nitu_shop_post_date();
					nitu_shop_post_category();
					nitu_shop_posted_author();
					nitu_shop_post_comments_count();
					nitu_shop_post_edit_link();
				?>
      </div><!-- .entry-meta -->
      <?php
			endif; ?>
    </header><!-- .entry-header -->


    <?php
				
				if ( is_singular() ) { // Return full post content for an existing post of any single post type
					
					echo '<div class="entry-content">';
						the_content( sprintf(
						wp_kses(
							// translators: %s: Name of current post. Only visible to screen readers 
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'nitu-shop' ),
								array(
									'span' => array(
										'class' => array(),
									),
								)
							),
							get_the_title()
						) );

						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'nitu-shop' ),
							'after'  => '</div>',
						) );
					echo '</div><!-- .entry-content -->';
					
					echo '<footer class="entry-footer">';
						nitu_shop_entry_footer();
					echo '</footer><!-- .entry-footer -->';
					
				}else{ // Return excerpt content for each post in a list when not a single post type
					
					echo '<div class="entry-content">';
						
						the_excerpt();
							
						$read_more_link = sprintf(
							// translators: %s: Name of current post. 
							wp_kses( __( 'Continue reading %s', 'nitu-shop' ), array( 'span' => array( 'class' => array() ) ) ),
							the_title( '<span class="screen-reader-text">"', '"</span>', false )
						);
						
						echo '<a href="' . esc_url( get_permalink() ) . '" class="more" rel="bookmark">' . $read_more_link . '</a>';
						
					echo '</div><!-- .entry-content -->';
				}
			?>


  </div><!-- .post-content .image-caption -->
</article><!-- #post-<?php the_ID(); ?> -->