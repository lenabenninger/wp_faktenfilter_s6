<?php
$context = Timber::context();

// Get 3 posts from "allgemein"
$context['allgemein_posts'] = Timber::get_posts([
    'posts_per_page' => 3,
    'category_name'  => 'allgemein',
]);

// Get 1 post from "empfehlung"
$context['empfehlung_post'] = Timber::get_posts([
    'posts_per_page' => 1,
    'category_name'  => 'empfehlung',
]);

// Fetch "Leserbrief" page by slug
$page = get_page_by_path('leserbrief'); // Search for the page by its slug

if ($page) {
    // If the page is found, get its details and pass it to the Twig template
    $context['leserbrief_page'] = Timber::get_post($page->ID);
} else {
    // Debugging: log an error if the page wasn't found
    error_log('Page "leserbrief" not found!');
}

// Fetch "Vorschlag" page by slug
$page = get_page_by_path('vorschlag'); // Search for the page by its slug

if ($page) {
    // If the page is found, get its details and pass it to the Twig template
    $context['vorschlag_page'] = Timber::get_post($page->ID);
} else {
    // Debugging: log an error if the page wasn't found
    error_log('Page "vorschlag" not found!');
}

// Render the front-page.twig template and pass the context to it (only once)
Timber::render('front-page.twig', $context);
?>






