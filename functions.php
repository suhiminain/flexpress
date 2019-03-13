<?php
/**
 * Flexpress.
 *
 * This file adds functions to the Flexpress..
 *
 * @package Flexpress
 * @author  Suhimi Nain
 * @license GPL-2.0+
 * @link    https://www.suhiminain.com/
 */
 
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'flexpress', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'flexpress' ) );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Flexpress' );
define( 'CHILD_THEME_URL', 'http://www.suhiminain.com/flexpress' );
define( 'CHILD_THEME_VERSION', '1.0.0' );

//* Enqueue Scripts and Styles
add_action( 'wp_enqueue_scripts', 'genesis_simple_enqueue_scripts_styles' );
function genesis_simple_enqueue_scripts_styles() {

	wp_enqueue_style( 'flexpress-fonts', '//fonts.googleapis.com/css?family=Archivo:400,400i|Lato:900', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'flaticon-fonts', get_stylesheet_directory_uri() . '/fonts/flaticon.css', array(),CHILD_THEME_VERSION);
	wp_enqueue_script( 'flexpress-jquery', '//code.jquery.com/jquery-1.10.2.js', array('jquery'), CHILD_THEME_VERSION );
	$output = array(
		'mainMenu' => __( 'Menu', 'flexpress' ),
		'subMenu'  => __( 'Menu', 'flexpress' ),
	);
	wp_localize_script( 'flexpress-responsive-menu', 'genesisSampleL10n', $output );

      wp_register_script( 'slide-in-menu-1', get_stylesheet_directory_uri() . '/js/responsive-menu.js', false, null);
      wp_enqueue_script( 'slide-in-menu-1');

}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery') );

//* Add Accessibility support
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'skip-links' ) );

//* Disable the superfish script
add_action( 'wp_enqueue_scripts', 'sp_disable_superfish' );
function sp_disable_superfish() {
	wp_deregister_script( 'superfish' );
	wp_deregister_script( 'superfish-args' );
}

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

/* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 600,
	'height'          => 160,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
) );
*/
//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
    'header',
    'footer-widgets',
    'footer'
) );

//* Add new featured image size
add_image_size( 'featured-image', 360, 300, TRUE );

//* Remove default layout
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

//* Display author box on single posts
add_filter( 'get_the_author_genesis_author_box_single', '__return_true' );

//* Featured Image reposition
//* remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
//* add_action( 'genesis_entry_header', 'genesis_do_post_image', 2 );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Add support for 4-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );


//* Rename primary and secondary navigation menus
add_theme_support( 'genesis-menus' , array( 'primary' => __( 'Header Menu', 'flexpress' ),'secondary' => __( 'Footer Menu', 'flexpress' ) ) );

//* Remove the site description
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

//* Remove the header right widget area
unregister_sidebar( 'header-right' );

//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* add new featured images size
add_image_size( 'custom-size', 800, 329, array( 'center', 'top' ) );

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav' );

//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 5 );

//* Reduce the secondary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'genesis_simple_secondary_menu_args' );
function genesis_simple_secondary_menu_args( $args ) {
	if ( 'secondary' != $args['theme_location'] ) {
		return $args;
	}
	$args['depth'] = 1;
	return $args;
}

//* Modify size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'flexpress_comments_gravatar' );
function flexpress_comments_gravatar( $args ) {
	$args['avatar_size'] = 45;
	return $args;
}

//* Display the entry meta in the entry header (requires HTML5 theme support)
add_action( 'genesis_entry_header', 'genesis_post_info', 12 );

add_filter( 'post_cat', 'do_shortcode', 20 );
add_action( 'genesis_entry_header', 'post_cat',5 );
 
function post_cat() {

	global $post;

	if ( 'page' === get_post_type( $post->ID ) )
		return;

	$post_meta = apply_filters( 'post_cat', '[post_categories before=""]' );

	genesis_markup( array(
		'html5' => sprintf( '<p class="entry-meta categories">%s</p>', $post_meta ),
		'xhtml' => sprintf( '<div class="post-meta categories">%s</div>', $post_meta ),
	) );

}

 
//* Customize the post meta function
add_filter( 'genesis_post_meta', 'sp_post_meta_filter' );
function sp_post_meta_filter($post_meta) {
	$post_meta = '[post_tags before="Tagged: "]';
	return $post_meta;
}

//* Add column class to each of the Genesis Footer Widgets 
//* https://gist.github.com/hellofromtonya/5ea51a6ee899e99bc04c
//* https://gist.github.com/studiopress/5700003

add_filter('genesis_footer_widget_areas', 'add_columns_to_footer_widgets',10, 2);
function add_columns_to_footer_widgets($output,$footer_widgets)
{
    $output = str_replace('footer-widget-area', 'footer-widget-area one-third', $output);
    $output = str_replace('footer-widgets-1 footer-widget-area one-third', 'footer-widget-1 footer-widget-area one-third first', $output);
    return $output;
}


//* Customize the entry meta in the entry header (requires HTML5 theme support)
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter($post_info) {
	$post_info = '[post_author_posts_link] on [post_date] [post_comments] [post_edit]';
	return $post_info;
}

add_action( 'genesis_header', 'wp_header_search',14 );

function wp_header_search() {
		echo '<div class="header-search">
		<form class="search-form" itemprop="potentialAction" itemscope itemtype="https://schema.org/SearchAction" method="get" action="' . home_url() . '"><meta itemprop="target" content="'.home_url().'/?s={s}"/><input itemprop="query-input" type="search" name="s" placeholder="Search" /><input type="submit" value="Search"  /></form></div>';
}

add_action( 'genesis_before', 'flexpress_genesis_meta' );

function flexpress_genesis_meta() {

	if ( is_front_page() || is_archive() || is_search() || is_home() || is_page() || is_page_template( 'page_blog.php' ) ) {

	//* Remove breadcrumbs
	remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

	//Removes Title and Description on CPT Archive
	remove_action( 'genesis_before_loop', 'genesis_do_cpt_archive_title_description' );
	//Removes Title and Description on Blog Archive
	remove_action( 'genesis_before_loop', 'genesis_do_posts_page_heading' );
	//Removes Title and Description on Date Archive
	remove_action( 'genesis_before_loop', 'genesis_do_date_archive_title' );
	//Removes Title and Description on Archive, Taxonomy, Category, Tag
	remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
	//Removes Title and Description on Author Archive
	remove_action( 'genesis_before_loop', 'genesis_do_author_title_description', 15 );
	//Removes Title and Description on Blog Template Page
	remove_action( 'genesis_before_loop', 'genesis_do_blog_template_heading' );
	//Removes Title and Description on Search Result Template Page
	remove_action( 'genesis_before_loop', 'genesis_do_search_title' );

	//Reposition Title and Description on CPT Archive
	add_action( 'genesis_after_header', 'genesis_do_cpt_archive_title_description' );
	//Reposition Title and Description on Blog Archive
	add_action( 'genesis_after_header', 'genesis_do_posts_page_heading' );
	//Reposition Title and Description on Date Archive
	add_action( 'genesis_after_header', 'genesis_do_date_archive_title' );
	//Reposition Title and Description on Archive, Taxonomy, Category, Tag
	add_action( 'genesis_after_header', 'genesis_do_taxonomy_title_description', 15 );
	//Reposition Title and Description on Author Archive
	add_action( 'genesis_after_header', 'genesis_do_author_title_description', 15 );
	//Reposition Title and Description on Blog Template Page
	add_action( 'genesis_after_header', 'genesis_do_blog_template_heading' );
	//Reposition Title and Description on Search Result Template Page
	add_action( 'genesis_after_header', 'genesis_do_search_title' );

	//* Remove the entry footer markup (requires HTML5 theme support)
	remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
	remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

	//* Remove the entry meta in the entry footer (requires HTML5 theme support)
	remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

	}
}

/* ==========================================================================
 * WooCommerce
 * ========================================================================== 
*/

add_action('genesis_meta','genesis_woocommerce');

function genesis_woocommerce(){
    
    // Enqueue WooCommerce styles conditionally.
    if ( class_exists( 'WooCommerce' ) && ( is_woocommerce() || is_shop() || is_product_category() || is_product_tag() || is_product() || is_cart() || is_checkout() || is_account_page() ) ) {
    
        //* Force full-width-content layout setting
        add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
        
        //* http://gasolicious.com/remove-tabs-keep-product-description-woocommerce/
        //  Location: add to functions.php
        //  Output: removes woocommerce tabs
        
        // remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
        
        //* http://gasolicious.com/remove-tabs-keep-product-description-woocommerce/
        //  Location: add to functions.php
        //  Output: adds full description to below price
        
        // function woocommerce_template_product_description() {
        //  woocommerce_get_template( 'single-product/tabs/description.php' );
        // }
        add_action( 'woocommerce_single_product_summary', 'woocommerce_template_product_description', 20 );
        
        add_filter('woocommerce_product_description_heading', '__return_null');
    
    }
    
}
 
/* ==========================================================================
 * Previous - Next Post Navigation
 * ========================================================================== */

//* Add post navigation (requires HTML5 theme support)
add_action( 'genesis_after_entry', 'custom_prev_next_post_nav',5);

function custom_prev_next_post_nav() {

	if ( ! is_singular( 'post' ) )
		return;

	genesis_markup( array(
		'html5'   => '<div %s>',
		'xhtml'   => '<div class="navigation">',
		'context' => 'adjacent-entry-pagination',
	) );

 	$prevPost = get_previous_post();
	if ($prevPost){
	echo '<div class="pagination-previous one-half first">';
	previous_post_link('<div class="prev"><span>Previous Post</span><h3>%link</h3></div>');
	$prevContent = $prevPost->post_content;
	/* echo '<p>';
	echo wp_trim_words( $prevContent , '15' );
	echo '</p>'; */
	echo '</div>';
	}

 	$nextPost = get_next_post();
	if ($nextPost){
	echo '<div class="pagination-next one-half">';
	next_post_link('<div class="next"><span>Next Post</span><h3>%link</h3></div>');
	$nextContent = $nextPost->post_content;
	/* echo '<p>';
	echo wp_trim_words( $nextContent  , '15' );
	echo '</p>'; */
	echo '</div>';
	}
	echo '</div>';

}


/* ==========================================================================
 * Landing Pages 
 * ========================================================================== */

add_action( 'genesis_meta', 'flexpress_landing_pages' );

function flexpress_landing_pages() {
 
	if( is_page_template('page_landing.php')){

		//* Add custom body class to the head
		add_filter( 'body_class', 'one_page_pro_add_body_class' );
		function one_page_pro_add_body_class( $classes ) {

			$classes[] = 'landing-page';
			return $classes;
		   
		}

		//* Force full width content layout
		add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

		//* Remove site header elements
		remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
		remove_action( 'genesis_header', 'genesis_do_header' );
		remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

		//* Remove slide in menu elements
		remove_action( 'genesis_before_header', 'genesis_slide_in_menu',15 ); 
		remove_action( 'genesis_header', 'genesis_slide_in_toggle',10 );

		//* Remove header search elements
		remove_action( 'genesis_header', 'wp_header_search',14 );

		//* Remove navigation
		remove_action( 'genesis_header', 'genesis_do_nav' );
		remove_action( 'genesis_footer', 'genesis_do_subnav', 5 );

		//* Remove breadcrumbs
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

		//* Remove site footer widgets
		remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

		//* Remove site footer elements
		remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
		remove_action( 'genesis_footer', 'genesis_do_footer' );
		remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

	}

}
 