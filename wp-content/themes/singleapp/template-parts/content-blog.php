<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ThemeGrill
 * @subpackage SingleApp
 * @since SingleApp 1.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">

		<?php if ( has_post_thumbnail() ) : ?>

			<div class="content-left">
 
				<figure>

					<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail( $size = 'singleapp-archive-thumbnail', $attr = '' ); ?></a>

				    <figcaption><?php the_post_thumbnail_caption(); ?></figcaption>

				</figure>

			</div><!-- .content-left -->

		<?php endif; ?>

		<div class="content-right">

			<header class="entry-header">

				<?php
					
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
					

				if ( 'post' === get_post_type() ) : ?>

					<div class="entry-meta">

						<?php singleapp_posted_on(); ?>

					</div><!-- .entry-meta -->

				<?php endif; ?>

			</header><!-- .entry-header -->


			<div class="entry-summary">

				<?php the_excerpt(); ?>

	   		</div><!-- .entry-summary -->

	   		<footer class="entry-footer">

				<?php singleapp_entry_footer(); ?>

			</footer><!-- .entry-footer -->
			
		</div><!-- .content-right -->

	</div><!-- .entry-content -->

</article><!-- #post-## -->