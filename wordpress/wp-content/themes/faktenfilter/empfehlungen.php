<?php
/**
 * Template Name: Empfehlungen
 */
$context = Timber::context();

// Get podcast posts
$podcast_posts = Timber::get_posts(array(
    'category_name' => 'podcast', // Make sure this matches the correct category slug
));

// Get influencer posts
$influencer_posts = Timber::get_posts(array(
    'category_name' => 'influencer', // Make sure this matches the correct category slug
));

// Merge both sets of posts
$context['posts'] = array_merge($podcast_posts->to_array(), $influencer_posts->to_array());

Timber::render('empfehlungen.twig', $context);
?>



