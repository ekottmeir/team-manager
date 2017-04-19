<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package ThemeGrill
 * @subpackage SingleApp
 * @since SingleApp 1.0
 */

if ( ! function_exists( 'singleapp_posted_on' ) ) {
	/**
	 * Shows meta information of post.
	 */
	function singleapp_posted_on() {
		if ( 'post' == get_post_type() ) :
			echo '<div class="entry-meta">'; ?>
			<?php
		      $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
		      if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		         $time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
		      }
		      $time_string = sprintf( $time_string,
		         esc_attr( get_the_date( 'c' ) ),
		         esc_html( get_the_date() ),
		         esc_attr( get_the_modified_date( 'c' ) ),
		         esc_html( get_the_modified_date() )
		      );

		    if ( get_theme_mod( 'singleapp_post_date_disable', '' ) == '' ) :
		   	printf( __( '<span class="posted-on"><a href="%1$s" title="%2$s" rel="bookmark"><i class="fa fa-calendar-o"></i> %3$s</a></span>', 'singleapp' ),
		   		esc_url( get_permalink() ),
		   		esc_attr( get_the_time() ),
		   		$time_string
		   	); endif; ?><!--end of post date-->

			<?php if ( get_theme_mod( 'singleapp_post_author_disable', '' ) == '' ) : ?>
				<span class="byline author vcard"><i class="fa fa-user" aria-hidden="true"></i> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo get_the_author(); ?>"><?php echo esc_html( get_the_author() ); ?></a></span>
			<?php endif; ?><!--end of post author-->

			<?php if ( get_theme_mod( 'singleapp_post_comment_disable', '' ) == '' ) : ?>
				<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
					<span class="comments-link"><i class="fa fa-comments" aria-hidden="true"></i> <?php comments_popup_link( __( '0', 'singleapp' ), __( '1', 'singleapp' ), __( ' % Comments', 'singleapp' ) ); ?></span>
				<?php } ?>
			<?php endif; ?><!--end of post comment count-->

			<?php

			echo '</div>';
		endif;
	}
}

/**************************************************************************************/
if ( ! function_exists( 'singleapp_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function singleapp_entry_footer() {
	global $post;

	if ( is_single() ) {

		if ( has_category()  &&  ( get_theme_mod( 'singleapp_post_category_disable', '' ) == '' ) ) : ?>
         <span class="cat-links"><i class="fa fa-folder" aria-hidden="true"></i> <?php the_category(', '); ?></span>
       <?php endif; /* end of post category */

        if ( get_the_tag_list() && ( get_theme_mod( 'singleapp_post_tags_disable', '' ) == '' ) ) :
		    echo get_the_tag_list( '<span class="tag-links"><i class="fa fa-tags" aria-hidden="true"></i> ', ', ', '</span>' );
		endif;  /* end of post tag */

		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'singleapp' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}

	if ( ! is_single() ) { ?>

	<?php if ( $post->post_content !=="" ) : ?>

	<!-- Do stuff with empty posts (or leave blank to skip empty posts) -->
	<span class="read-more pull-right"><a href="<?php the_permalink(); ?>" class="btn btn-theme" title="" rel="bookmark"><?php echo esc_html_e('Read More','singleapp')?> <i class="fa fa-angle-double-right"></i></a></span>


	<?php endif; ?>

	<?php }
}
endif;

/**************************************************************************************/
/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function singleapp_categorized_blog() {

	if ( false === ( $all_the_cool_cats = get_transient( 'singleapp_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'singleapp_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so singleapp_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so singleapp_categorized_blog should return false.
		return false;
	}
}
/**************************************************************************************/

if ( ! function_exists( 'singleapp_category_transient_flusher' ) ) {
	/**
	 * Flush out the transients used in singleapp_categorized_blog.
	 */
	function singleapp_category_transient_flusher() {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		// Like, beat it. Dig?
		delete_transient( 'singleapp_categories' );
	}
}
add_action( 'edit_category', 'singleapp_category_transient_flusher' );

add_action( 'save_post',     'singleapp_category_transient_flusher' );
/**************************************************************************************/

if ( ! function_exists( 'singleapp_cloud_tag_args' ) ) {
	/**
	 * Custom style for cloud tag args.
	 */
	function singleapp_cloud_tag_args( $args ) {
	    $args['number'] = 20; // Your extra arguments go here
	    $args['largest'] = 18;
	    $args['smallest'] = 12;
	    $args['unit'] = 'px';
	    return $args;
	}
}
add_filter( 'widget_tag_cloud_args', 'singleapp_cloud_tag_args' );
