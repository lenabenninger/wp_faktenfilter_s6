<?php
$context = Timber::context();

// Get 3 posts from "allgemein"
$context['allgemein_posts'] = Timber::get_posts([
    'posts_per_page' => 3,
    'category_name'  => 'allgemein',
]);

// Get 1 post from "empfehlung"
$empfehlung_posts = Timber::get_posts([
    'posts_per_page' => 1,
    'category_name'  => 'empfehlung',
]);
$context['empfehlung_post'] = !empty($empfehlung_posts) ? $empfehlung_posts[0] : null;

// Fetch "Leserbrief" page by slug
$page = get_page_by_path('leserbrief');
error_log('Leserbrief page: ' . print_r($page, true));

if ($page instanceof WP_Post) {
    $context['leserbrief_page'] = Timber::get_post($page);
} else {
    error_log('Page "Leserbrief" not found!');
}

// Fetch "Vorschlag" page by slug
$page = get_page_by_path('vorschlag');
error_log('Vorschlag page: ' . print_r($page, true));

if ($page instanceof WP_Post) {
    $context['vorschlag_page'] = Timber::get_post($page);
} else {
    error_log('Page "Vorschlag" not found!');
}

// Fetch "Hörenswert" page by slug
$page = get_page_by_path('hoerenswert');
error_log('Hörenswert page: ' . print_r($page, true));

if ($page instanceof WP_Post) {
    $context['hoerenswert_page'] = Timber::get_post($page);
} else {
    error_log('Page "Hörenswert" not found!');
}

// Debugging: Check what is inside $context
error_log(print_r($context, true));

// Render the front-page.twig template and pass the context to it
Timber::render('front-page.twig', $context);

?>







