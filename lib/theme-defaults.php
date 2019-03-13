<?php
/**
 * Flexpress.
 *
 * This file adds the Customizer additions to the Flexpress Theme.
 *
 * @package Flexpress
 * @author  Suhimi Nain
 * @license GPL-2.0+
 * @link    http://www.suhiminain.com/
 */

add_filter( 'genesis_theme_settings_defaults', 'flexpress_theme_defaults' );
/**
* Updates theme settings on reset.
*
* @since 2.2.3
*/
function flexpress_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 6;
	$defaults['content_archive']           = 'full';
	$defaults['content_archive_limit']     = 200;
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['image_size']                = 'custom-size';
	$defaults['image_alignment']           = '';
	$defaults['breadcrumb_home']		   = 0;
	$defaults['breadcrumb_front_page']     = 0;
	$defaults['breadcrumb_posts_page']     = 0;
	$defaults['breadcrumb_single']         = 1; 
	$defaults['breadcrumb_page']           = 1;  
	$defaults['breadcrumb_archive']        = 0;
	$defaults['breadcrumb_404']            = 0;  
	$defaults['breadcrumb_attachment']     = 0;
	$defaults['comments_pages']            = 1;
	$defaults['comments_posts']            = 1;
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'content-sidebar';
	return $defaults;

}

add_action( 'after_switch_theme', 'flexpress_theme_setting_defaults' );
/**
* Updates theme settings on activation.
*
* @since 2.2.3
*/
function flexpress_theme_setting_defaults() {

	if ( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 6,	
			'content_archive'           => 'full',
			'content_archive_limit'     => 200,
			'content_archive_thumbnail' => 1,
			'image_size'                => 'custom-size',
			'image_alignment'           => '',
			'breadcrumb_home'           => 0,
			'breadcrumb_front_page'     => 0,
			'breadcrumb_posts_page'     => 0,
			'breadcrumb_single'         => 1,
			'breadcrumb_page'           => 1,
			'breadcrumb_archive'        => 0,
			'breadcrumb_404'            => 0,
			'breadcrumb_attachment'     => 0,
			'comments_pages'            => 1,
			'comments_posts'            => 1,
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'content-sidebar',
		) );
		
	} 

	update_option( 'posts_per_page', 6 );

}