<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 * @package ThemeGrill
 * @subpackage SingleApp
 * @since SingleApp 1.0
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function singleapp_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	// Add a class of home to front and home pages.
	if ( is_front_page() && is_home() ) {
		$classes[] = 'home';
	}
	// Add a class of home to front and home pages.
	if ( singleapp_theme_style() == 'onepage' ) {
		$classes[] = 'onepage_layout';
	} else {
		$classes[] = 'fullpage_layout';
	}

	return $classes;
}
add_filter( 'body_class', 'singleapp_body_classes' );


/***************************************************************************************************************/
/**
 * Sets the post excerpt length to 35 words.
 *
 * function tied to the excerpt_length filter hook.
 *
 * @uses filter excerpt_length
 */
function singleapp_excerpt_length( $length ) {
  return 35;
}
add_filter( 'excerpt_length', 'singleapp_excerpt_length' );

/***************************************************************************************************************/
/**
 * Returns a "Continue Reading" link for excerpts
 */
function singleapp_continue_reading() {
  return '';
}
add_filter( 'excerpt_more', 'singleapp_continue_reading' );

/***************************************************************************************************************/
/**
 * function to show the footer info, copyright information
 */
function singleapp_footer_copyright_info() {
   $site_link = '<span><a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" >' . get_bloginfo( 'name', 'display' ) . '</a></span>';
   $tg_link =  '<span><a href="'.esc_url( 'http://themegrill.com/themes/singleapp', 'singleapp' ).'" target="_blank" title="'.esc_html__( 'ThemeGrill', 'singleapp' ).'" rel="designer">'.esc_html__( 'ThemeGrill', 'singleapp') .'</a></span>';
   $default_footer_value = '<h4 class="copyright-desc wow fadeInUp">'.sprintf( esc_html__( 'Copyright &copy; %1$s %2$s', 'singleapp' ), date( 'Y' ), $site_link ).'</h4><h4 class="design-by wow fadeInUp">'.sprintf( esc_html__( 'Theme by: %1$s', 'singleapp' ), $tg_link ).'</h4>';
   echo $default_footer_value;
}
add_action( 'singleapp_footer_copyright', 'singleapp_footer_copyright_info', 10 );

/****************************************************************************************/
if ( ! function_exists( 'singleapp_layout_class' ) ) :
/**
 * Generate layout class for sidebar based on customizer and post meta settings.
 */
function singleapp_layout_class() {
    global $post;
    $layout = get_theme_mod( 'singleapp_global_layout', 'right_sidebar' );
    // Front page displays in Reading Settings
    $page_for_posts = get_option('page_for_posts');
    // Get Layout meta
    if($post) {
        $layout_meta = get_post_meta( $post->ID, 'singleapp_page_specific_layout', true );
    }
    // Home page if Posts page is assigned
    if( is_home() && !( is_front_page() ) ) {
        $queried_id = get_option( 'page_for_posts' );
        $layout_meta = get_post_meta( $queried_id, 'singleapp_page_specific_layout', true );

        if( $layout_meta != 'default_layout' && $layout_meta != '' ) {
            $layout = get_post_meta( $queried_id, 'singleapp_page_specific_layout', true );
        }
    }
    elseif( is_page() ) {
        $layout = get_theme_mod( 'singleapp_default_page_layout', 'right_sidebar' );
        if( $layout_meta != 'default_layout' && $layout_meta != '' ) {
            $layout = get_post_meta( $post->ID, 'singleapp_page_specific_layout', true );
        }
    }
    elseif( is_single() ) {
        $layout = get_theme_mod( 'singleapp_default_single_post_layout', 'right_sidebar' );
        if( $layout_meta != 'default_layout' && $layout_meta != '' ) {
            $layout = get_post_meta( $post->ID, 'singleapp_page_specific_layout', true );
        }
    }
    return $layout;
}
endif;

/****************************************************************************************/
if ( ! function_exists( 'singleapp_sidebar_select' ) ) :
/**
 * Select and show sidebar based on post meta and customizer default settings
 */
function singleapp_sidebar_select() {
    $layout = singleapp_layout_class();
    if( $layout != "no_sidebar_full_width" &&  $layout != "no_sidebar_content_centered" ) {
        if ( $layout == "right_sidebar" ) {
            get_sidebar();
        } else {
            get_sidebar('left');
        }
    }
}
endif;

/****************************************************************************************/
if ( ! function_exists( 'singleapp_navigation' ) ) :
/**
 * Return the navigations.
 */
function singleapp_navigation() {
    if( is_archive() || is_home() || is_search() ) {
    /**
     * Checking WP-PageNaviplugin exist
     */
    if ( function_exists('wp_pagenavi' ) ) :
      wp_pagenavi();
    else:
      global $wp_query;
      if ( $wp_query->max_num_pages > 1 ) :
      ?>
      <ul class="default-wp-page clearfix">
        <li class="previous"><?php next_posts_link( esc_html__( '&larr; Previous', 'singleapp' ) ); ?></li>
        <li class="next"><?php previous_posts_link( esc_html__( 'Next &rarr;', 'singleapp' ) ); ?></li>
      </ul>
      <?php
      endif;
    endif;
  }

  if ( is_single() ) {
    if( is_attachment() ) {
    ?>
      <ul class="default-wp-page clearfix">
        <li class="previous"><?php previous_image_link( false, esc_html__( '&larr; Previous', 'singleapp' ) ); ?></li>
        <li class="next"><?php next_image_link( false, esc_html__( 'Next &rarr;', 'singleapp' ) ); ?></li>
      </ul>
    <?php
    }
    else {
    ?>
      <ul class="default-wp-page clearfix">
        <li class="previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . esc_html_x( '&larr; Previous Post', 'Previous post link', 'singleapp' ) . '</span>' ); ?></li>
        <li class="next"><?php next_post_link( '%link', '<span class="meta-nav">' . esc_html_x( 'Next Post &rarr;', 'Next post link', 'singleapp' ) . '</span>' ); ?></li>
      </ul>
    <?php
    }
  } 
}
endif;


/**************************************************************************************/	
if ( ! function_exists( 'the_post_thumbnail_caption' ) ) :
/**
 * Display thumbnail caption.
 */
function the_post_thumbnail_caption() {
    global $post;
    $thumbnail_id    = get_post_thumbnail_id($post->ID);
    $thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));

    if ($thumbnail_image && isset($thumbnail_image[0])) {
        echo '<span>'.$thumbnail_image[0]->post_excerpt.'</span>';
    }
}
endif;

/**************************************************************************************/
if ( ! function_exists( 'singleapp_breadcrumbs' ) ) :
/**
 * Display Breadcrumbs
 *
 * This code is a modified version of Melissacabral's original menu code for dimox_breadcrumbs().
 *
 */
function singleapp_breadcrumbs(){
  /* === OPTIONS === */
	$text['home']     = esc_html__('Home', 'singleapp'); // text for the 'Home' link
	$text['category'] = esc_html__('Archive by Category "%s"', 'singleapp'); // text for a category page
	$text['tax'] 	  = esc_html__('Archive for "%s"', 'singleapp'); // text for a taxonomy page
	$text['search']   = esc_html__('Search Results for "%s" query', 'singleapp'); // text for a search results page
	$text['tag']      = esc_html__('Posts Tagged "%s"', 'singleapp'); // text for a tag page
	$text['author']   = esc_html__('Articles Posted by %s', 'singleapp'); // text for an author page
	$text['404']      = esc_html__('Error 404', 'singleapp'); // text for the 404 page
	$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
	$showOnHome  = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
	$delimiter   = '&nbsp;&frasl;&nbsp;'; // delimiter between crumbs
	$before      = '<span class="current">'; // tag before the current crumb
	$after       = '</span>'; // tag after the current crumb
	/* === END OF OPTIONS === */
	global $post;
	$homeLink   = esc_url(home_url()) . '/';
	$linkBefore = '<span typeof="v:Breadcrumb">';
	$linkAfter = '</span>';
	$linkAttr = ' rel="v:url" property="v:title"';
	$link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;
	if (is_home() || is_front_page()) {
		if ($showOnHome == 1) echo '<div id="crumbs"><a href="' . $homeLink . '">' . $text['home'] . '</a></div>';
	} else {
		echo '<div id="crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">' . sprintf($link, $homeLink, $text['home']) . $delimiter;

		if ( is_category() ) {
			$thisCat = get_category(get_query_var('cat'), false);
			if ($thisCat->parent != 0) {
				$cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
				$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
				$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
				echo $cats;
			}
			echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;
		} elseif( is_tax() ){
			$thisCat = get_category(get_query_var('cat'), false);
			if ($thisCat->parent != 0) {
				$cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
				$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
				$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
				echo $cats;
			}
			echo $before . sprintf($text['tax'], single_cat_title('', false)) . $after;

		}elseif ( is_search() ) {
			echo $before . sprintf($text['search'], get_search_query()) . $after;
		} elseif ( is_day() ) {
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
			echo $before . get_the_time('d') . $after;
		} elseif ( is_month() ) {
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo $before . get_the_time('F') . $after;
		} elseif ( is_year() ) {
			echo $before . get_the_time('Y') . $after;
		} elseif ( is_single() && !is_attachment() ) {
			if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
				if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
			} else {
				$cat = get_the_category(); $cat = $cat[0];
				$cats = get_category_parents($cat, TRUE, $delimiter);
				if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
				$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
				$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
				echo $cats;
				if ($showCurrent == 1) echo $before . get_the_title() . $after;
			}
		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			$post_type = get_post_type_object(get_post_type());
			echo $before . $post_type->labels->singular_name . $after;
		} elseif ( is_attachment() ) {
			$parent = get_post($post->post_parent);
			$cat = get_the_category($parent->ID); $cat = $cat[0];
			$cats = get_category_parents($cat, TRUE, $delimiter);
			$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
			$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
			echo $cats;
			printf($link, get_permalink($parent), $parent->post_title);
			if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
		} elseif ( is_page() && !$post->post_parent ) {
			if ($showCurrent == 1) echo $before . get_the_title() . $after;
		} elseif ( is_page() && $post->post_parent ) {
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();
			while ($parent_id) {
				$page = get_page($parent_id);
				$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
				$parent_id  = $page->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			for ($i = 0; $i < count($breadcrumbs); $i++) {
				echo $breadcrumbs[$i];
				if ($i != count($breadcrumbs)-1) echo $delimiter;
			}
			if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
		} elseif ( is_tag() ) {
			echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
		} elseif ( is_author() ) {
	 		global $author;
			$userdata = get_userdata($author);
			echo $before . sprintf($text['author'], $userdata->display_name) . $after;
		} elseif ( is_404() ) {
			echo $before . $text['404'] . $after;
		}
		if ( get_query_var('paged') ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
			echo esc_html__( 'Page', 'singleapp' ) . ' ' . get_query_var('paged');
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
		}
		echo '</div>';
	}
} // end singleapp_breadcrumbs()
endif;

/**************************************************************************************/
if ( ! function_exists( 'singleapp_comment' ) ) :
/**
 * Template for comments and pingbacks.
 * 
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function singleapp_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php esc_html_e( 'Pingback:', 'singleapp' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'singleapp' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo '<figure>'.esc_url( get_avatar( $comment, 74 ) ).'</figure>';
					echo '<div class="comment-meta-wrapper">';
					printf( '<div class="comment-author-link"><i class="fa fa-user" aria-hidden="true"></i> %1$s%2$s</div>',
						wp_kses( get_comment_author_link(), array( 'a'=> array( 'href' => array(), 'rel' => array(), 'class' => array() ) ) ),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span>' . esc_html__( 'Post author', 'singleapp' ) . '</span>' : ''
					);
					printf( '<div class="comment-date-time"><i class="fa fa-calendar-o" aria-hidden="true"></i> %1$s</div>',
						sprintf( __( '%1$s at %2$s', 'singleapp' ), esc_html( get_comment_date() ), esc_html( get_comment_time() ) )
					);
					printf( '<a class="comment-permalink" href="%1$s"><i class="fa fa-link aria-hidden="true""></i> Permalink</a>', esc_url( get_comment_link( $comment->comment_ID ) ) );
					edit_comment_link();
					echo '</div>';
				?>
			</header><!-- .comment-meta -->
			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'singleapp' ); ?></p>
			<?php endif; ?>
			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( '<i class="fa fa-reply-all" aria-hidden="true"></i> Reply', 'singleapp' ), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</section><!-- .comment-content -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

/**************************************************************************************/
/**
 * Hooks to change the default comment form fields.
 */
function singleapp_theme_comment_form_fileds( $fields ) {
    $commenter = wp_get_current_commenter();
    $req      = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $html5    = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;
    $fields   =  array(
        'author'=>'<input class="form-control" placeholder="'.esc_html__('Name*','singleapp').'" name="author" type="text" value="' .
            esc_attr( $commenter['comment_author'] ) . '" ' . $aria_req . ' />'.
            ( $req ? '<span class="required"></span>' : '' ),
        'email'=> '<input class="form-control" placeholder="'.esc_html__('Email*','singleapp').'" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) .
            '" ' . $aria_req . ' />' .
            ( $req ? '<span class="required"></span>' : '' ),
    	);
    return $fields;
}
add_filter( 'comment_form_default_fields', 'singleapp_theme_comment_form_fileds' );

/**************************************************************************************/
/**
 * Hooks to change the default comment textarea.
 */
function singleapp_modify_comment_form_text_area($arg) {
    $arg['comment_field'] = '<textarea id="comment" name="comment" cols="45" rows="1" aria-required="true" placeholder="'.esc_html__('Your Message','singleapp').'"></textarea>';
    return $arg;
}
add_filter('comment_form_defaults', 'singleapp_modify_comment_form_text_area');

/**************************************************************************************/
/**
 * Hooks to set comment textarea bottom.
 */
function singleapp_comment_textarea_fild_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
}
add_filter( 'comment_form_fields', 'singleapp_comment_textarea_fild_bottom' );

/****************************************************************************************/

/**
 * Removing the default style of wordpress gallery
 */
add_filter( 'use_default_gallery_style', '__return_false' );
/****************************************************************************************/

/**
 * Filtering the size to be medium from thumbnail to be used in WordPress gallery as a default size
 */
function singleapp_gallery_atts( $out, $pairs, $atts ) {
	$atts = shortcode_atts( array(
	'size' => 'medium',
	), $atts );
	$out['size'] = $atts['size'];
	return $out;
}
add_filter( 'shortcode_atts_gallery', 'singleapp_gallery_atts', 10, 3 );

/****************************************************************************************/
if (!function_exists('singleapp_admin_header_image')) :
/**
 * Retriving header image
 */	
	function singleapp_admin_header_image() {
	    if ( get_header_image() ) : ?>
      		<img class="slider-bg" src="<?php header_image(); ?>" alt="<?php bloginfo( 'name' ); ?>">
    	<?php endif; ?>
	<?php }
endif;

/****************************************************************************************/
if ( ! function_exists( 'singleapp_the_custom_logo' ) ) :
/**
 * Displays the optional custom logo Introduced in WordPress 4.5 .
 *
 * Does nothing if the custom logo is not available.
 *
 */
	function singleapp_the_custom_logo() {
		if ( function_exists( 'the_custom_logo' ) ) {
			the_custom_logo();
		}
	}
endif;

/****************************************************************************************/
if ( !function_exists('singleapp_theme_style') ) :
/**
 * check to theme style.
 */
	function singleapp_theme_style() {
		$style = '';
		if ( get_theme_mod( 'singleapp_style_layout','onepage_layout' ) == 'onepage_layout' ) {
			$style = 'onepage';
		} else {
			$style = 'fullpage';
		}
		return $style;
	}
endif;

/****************************************************************************************/
/**
 * Hooks the Custom Internal CSS to head section
 */
function singleapp_internal_css() {
	if ( get_background_image() || get_background_color() ) : ?>
		<style type="text/css" id="custom-background-css">
			body.custom-background { background: none !important; }
		</style>
		<?php
	endif;
}
add_action('wp_head', 'singleapp_internal_css');

/**
 * Change hex code to RGB
 * Source: https://css-tricks.com/snippets/php/convert-hex-to-rgb/#comment-1052011
 */
function singleapp_hex2rgb($hexstr) {
    $int = hexdec($hexstr);
    $rgb = array("red" => 0xFF & ($int >> 0x10), "green" => 0xFF & ($int >> 0x8), "blue" => 0xFF & $int);
    $r = $rgb['red'];
    $g = $rgb['green'];
    $b = $rgb['blue'];

    return "rgba($r,$g,$b, 0.85)";
}

/**
 * Generate darker color
 * Source: http://stackoverflow.com/questions/3512311/how-to-generate-lighter-darker-color-with-php
 */
function singleapp_lightcolor($hex, $steps) {
	// Steps should be between -255 and 255. Negative = darker, positive = lighter
	$steps = max(+255, min(255, $steps));

	// Normalize into a six character long hex string
	$hex = str_replace('#', '', $hex);
	if (strlen($hex) == 3) {
		$hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
	}

	// Split into three parts: R, G and B
	$color_parts = str_split($hex, 2);
	$return = '#';

	foreach ($color_parts as $color) {
		$color   = hexdec($color); // Convert to decimal
		$color   = max(0,min(255,$color + $steps)); // Adjust color
		$return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
	}

	return $return;
}

add_action( 'wp_head', 'singleapp_custom_css' );
/**
 * Hooks the Custom Internal CSS to head section
 */
function singleapp_custom_css() {

	$primary_color   = esc_attr( get_theme_mod( 'singleapp_primary_color', '#00aced' ) );
	$primary_opacity = singleapp_hex2rgb($primary_color);
	$primary_light    = singleapp_lightcolor($primary_color, -20);

	$singleapp_internal_css = '';
	if( $primary_color != '#00aced' ) {
		$singleapp_internal_css = '.site-description,.feature-left .feature-title a,.feature-icon .fa,.feature-right .feature-title a,.design-by a:hover,.copyright-desc a:hover,#crumbs span,.entry-footer a,.widget_archive a:hover::before, .widget_categories a:hover:before, .widget_pages a:hover:before, .widget_meta a:hover:before, .widget_recent_comments a:hover:before, .widget_recent_entries a:hover:before, .widget_rss a:hover:before, .widget_nav_menu a:hover:before, .widget_archive li a:hover, .widget_categories li a:hover, .widget_pages li a:hover, .widget_meta li a:hover, .widget_recent_comments li a:hover, .widget_recent_entries li a:hover, .widget_rss li a:hover, .widget_nav_menu li a:hover, .widget_tag_cloud a:hover,.archive .page-title, .archive .entry-footer a,#site-navigation ul.sub-menu > li:hover > a, #site-navigation ul.children > li:hover > a, #nav li.active a,#site-navigation ul li a:hover,.fullpage_layout .copyright-desc a,.fullpage_layout #site-navigation ul li a:hover, .fullpage_layout #site-navigation ul li a.active,.fullpage_layout .client-name,.fullpage_layout #nav li.active a,#site-navigation .menu-toggle:hover::before { color: '.$primary_opacity.' } .icon-border,.reviews-wrapper .bx-pager-item .bx-pager-link.active,#crumbs,blockquote,input[type="text"]:focus, input[type="email"]:focus, input[type="url"]:focus, input[type="password"]:focus, input[type="search"]:focus, textarea:focus,.fullpage_layout .reviews-wrapper .bx-pager-item .bx-pager-link,.fullpage_layout .reviews-wrapper .bx-pager-item .bx-pager-link.active,.fullpage_layout .reviews-desc,.fullpage_layout #nav li:hover a::after, .fullpage_layout #nav li.active a::after,#site-navigation ul.sub-menu, #site-navigation ul.children,.fullpage_layout .share-wrapper .btn-wrapper a:first-child, .fullpage_layout .share-wrapper .btn-wrapper a,.fullpage_layout .share-wrapper .btn-wrapper a:first-child:hover, .fullpage_layout .share-wrapper .btn-wrapper a:hover,.share-wrapper .btn-wrapper a,.share-wrapper .btn-wrapper a:first-child,.share-wrapper .btn-wrapper a:hover,.bx-pager-link { border-color: '.$primary_color.'} .contact-wrapper form .wpcf7-submit,.onepage_layout .contact .social-icons .social-icon:hover,#scroll-up,.widget .widget-title::after,.num-404,.fullpage_layout .reviews-wrapper .bx-pager-item .bx-pager-link.active,.fullpage_layout #nav li:hover a::after, .fullpage_layout #nav li.active a::after,.fullpage_layout footer .social-icons .social-icon:hover, .onepage_layout .contact .social-icons .social-icon:hover,.fullpage_layout .banner-btn-wrapper > a,.fullpage_layout .share-wrapper .btn-wrapper a:first-child, .fullpage_layout .share-wrapper .btn-wrapper a,.share-wrapper .btn-wrapper a:hover,.bx-pager-link.active { background-color: '.$primary_color.'} ';
	}

	if( !empty( $singleapp_internal_css ) ) {
	?>
		<style type="text/css"><?php echo $singleapp_internal_css; ?></style>
	<?php
	}

	$singleapp_custom_css = get_theme_mod( 'singleapp_custom_css', '' );
	if( !empty( $singleapp_custom_css ) ) {
		echo '<!-- '.get_bloginfo('name').' Custom Styles -->';
	?>
		<style type="text/css"><?php echo esc_html( $singleapp_custom_css ); ?></style>
	<?php
	}
}