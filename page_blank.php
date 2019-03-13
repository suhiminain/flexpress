<?php

/**
 * This file adds the Blank Page template to the Genesis Flexpress.
 *
 * @author Suhimi Nain
 * @package flexpress
 * @subpackage Customizations
 */

/*
Template Name: Blank Page
*/
do_action( 'genesis_doctype' );
do_action( 'genesis_title' );
do_action( 'genesis_meta' ); 
wp_head(); 
?>
<body <?php body_class( $class ); ?>> 
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php the_content(); ?>
<?php endwhile; ?>
<?php endif; ?>
<?php wp_footer(); ?>