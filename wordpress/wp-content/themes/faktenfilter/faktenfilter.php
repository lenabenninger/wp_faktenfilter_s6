<?php
/*
Template Name: Faktenfilter
*/

// Include Timber
use Timber\Timber;

// Get the context
$context = Timber::context();

// Define the custom query to get posts from the "Allgemein" category
$args = [
    'category_name' => 'Allgemein',
    'posts_per_page' => -1, // Fetch all posts (or adjust as needed)
];
$context['posts'] = Timber::get_posts($args);

// Render the template
Timber::render('faktenfilter.twig', $context);

