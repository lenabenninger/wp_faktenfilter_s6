<?php
/*
Template Name: Faktenfilter
*/

use Timber\Timber;

// Get the context
$context = Timber::context();

// Define the custom query to get posts from the "Allgemein" category
$args = [
    'category_name' => 'Allgemein',
    'posts_per_page' => -1, // Fetch all posts (or adjust as needed)
];
$context['posts'] = Timber::get_posts($args);

// Fetch "Leserbrief" page by slug
$page = get_page_by_path('leserbrief');
if ($page) {
    $context['leserbrief_page'] = Timber::get_post($page->ID);
} else {
    error_log('Page "leserbrief" not found!');
}

// Fetch "Vorschlag" page by slug
$page = get_page_by_path('vorschlag');
if ($page) {
    $context['vorschlag_page'] = Timber::get_post($page->ID);
} else {
    error_log('Page "vorschlag" not found!');
}

// Render the template **AFTER** adding all data to context
Timber::render('faktenfilter.twig', $context);
