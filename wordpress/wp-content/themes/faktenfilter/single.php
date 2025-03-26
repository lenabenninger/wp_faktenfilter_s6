<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context         = Timber::context();
$timber_post     = Timber::get_post();
$context['post'] = $timber_post;

// Check if $timber_post is an object and has an ID
if ( isset( $timber_post ) && is_object( $timber_post ) && isset( $timber_post->ID ) ) {
    // If the post is password protected, render the password form template
    if ( post_password_required( $timber_post->ID ) ) {
        Timber::render( 'single-password.twig', $context );
    } else {
        // Render the appropriate templates for the post
        Timber::render(
            array(
                'single-' . $timber_post->ID . '.twig',
                'single-' . $timber_post->post_type . '.twig',
                'single-' . $timber_post->slug . '.twig',
                'single.twig'
            ),
            $context
        );
    }
} else {
    // Handle the case where $timber_post is not available or invalid
    Timber::render( 'error.twig', $context );
}
