<?php
/*

Image attachment template

It looks very similar to the single project template
Should it be differentiated more?

*/
?>

<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

					<div id="main" class="clearfix" role="main">

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

						<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

							<h1 class="single-title project-title"><?php the_title(); ?></h1>

							<section class="entry-content clearfix">

								<div class="attachment">
								<?php
									
									$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
									foreach ( $attachments as $k => $attachment ) {
										if ( $attachment->ID == $post->ID )
											break;
									}
									$k++;
									// If there is more than 1 attachment in a gallery
									if ( count( $attachments ) > 1 ) {
										if ( isset( $attachments[ $k ] ) )
											// get the URL of the next image attachment
											$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
										else
											// or get the URL of the first image attachment
											$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
									} else {
										// or, if there's only 1 image, get the URL of the image
										$next_attachment_url = wp_get_attachment_url();
									}
								?>

								<a href="<?php echo $next_attachment_url; ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php
								$attachment_size = apply_filters( 'portfoliopress_attachment_size', 1200 );
								echo wp_get_attachment_image( $post->ID, array( $attachment_size, $attachment_size ) ); // filterable image width with, essentially, no limit for image height.
								?></a>
							</div><!-- .attachment -->
							</section>

							<footer class="article-footer">

								<p class="attachment-meta">
									<?php
										// TODO there is some extra information being pulled in here (i.e. width, height)
										// Remove it!
										$metadata = wp_get_attachment_metadata();
										printf( __( '<span class="entry-date"><abbr class="published" title="%1$s">%2$s</abbr></span> | <a href="%6$s" title="Return to %7$s" rel="gallery">%7$s</a>', 'portfoliopress' ),
											esc_attr( get_the_time() ),
											get_the_date('Y'),
											wp_get_attachment_url(),
											$metadata['width'],
											$metadata['height'],
											get_permalink( $post->post_parent ),
											get_the_title( $post->post_parent )
										);
									?>
									<?php edit_post_link( __( 'Edit', 'portfoliopress' ), ' | <span class="edit-link">', '</span>' ); ?>
								</p>

								<nav class="prev-next widemargins">
									<span class="prev"><?php previous_image_link( false, __( '&larr; Previous' , 'portfoliopress' ) ); ?></span>
									<span class="next"><?php next_image_link( false, __( 'Next &rarr;' , 'portfoliopress' ) ); ?></span>
								</nav><!-- .prev-next -->
								
							</footer>

						</article>

						<?php endwhile; ?>

						<?php else : ?>

								<?php get_template_part('include/post', 'notfound'); ?>

						<?php endif; ?>

					</div>

				</div>

			</div>

<?php get_footer(); ?>