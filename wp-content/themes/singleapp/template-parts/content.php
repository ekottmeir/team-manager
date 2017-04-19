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

	<header class="entry-header">

		<?php
			if ( is_single() ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
			} else {
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			} ?>

	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php if ( has_post_thumbnail() ) : ?>

			<figure>

		        <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail(); ?></a>

		    	<figcaption><?php the_post_thumbnail_caption(); ?></figcaption>

			</figure>

		<?php endif; ?>

		<?php if ( 'post' === get_post_type() ) : ?>

			<div class="entry-meta">

				<?php singleapp_posted_on(); ?>

			</div><!-- .entry-meta -->

		<?php endif; ?>

		<div class="entry-summary">

			<?php if ( is_single() ) : ?>

				<?php
					the_content( sprintf(
						/* translators: %s: Name of current post. */
						wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'singleapp' ), array( 'span' => array( 'class' => array() ) ) ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					) );

					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'singleapp' ),
						'after'  => '</div>',
					) );
				?>

			<?php else :?>

				<?php the_excerpt(); ?>

			<?php endif; ?>

   		</div><!-- .entry-summary -->

   		<footer class="entry-footer">

			<?php singleapp_entry_footer(); ?>

		</footer><!-- .entry-footer -->

	</div><!-- .entry-content -->

</article><!-- #post-## -->